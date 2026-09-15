<?php

namespace App\Http\Controllers;

use App\Services\Reports\DailyVehicleTargetService;
use App\Services\Reports\VehicleDetailSelectionService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DailyVehicleStatisticsReportController extends Controller
{
    public function sync($start, $end)
    {
        $validator = Validator::make([
            'start' => $start,
            'end' => $end,
        ], [
            'start' => ['required', 'date_format:Y-m-d'],
            'end' => ['required', 'date_format:Y-m-d'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->errors()->all(),
            ], 422);
        }

        if (strtotime($start) > strtotime($end)) {
            return response()->json([
                'status' => 'error',
                'messages' => ['Start date must be before or equal to end date.'],
            ], 422);
        }

        $rows = collect();
        $missingStatistics = [];

        foreach ($this->datesBetween($start, $end) as $date) {
            $statistic = DB::table('daily_vehicle_statistics')
                ->whereDate('stat_date', $date)
                ->first();

            if (! $statistic) {
                $missingStatistics[] = $date;
                $rows->push([
                    'id' => null,
                    'date' => $date,
                    'before' => null,
                    'available' => $this->availableDetailCount($date),
                    'after' => null,
                    'missing' => null,
                    'extra_capacity' => null,
                    'change' => null,
                    'updated' => false,
                    'status' => 'Missing daily_vehicle_statistics',
                ]);
                continue;
            }

            $before = (int) $statistic->vehicles;
            $available = $this->availableDetailCount($date);
            $after = min($before, $available);

            $rows->push([
                'id' => $statistic->id,
                'date' => $date,
                'before' => $before,
                'available' => $available,
                'after' => $after,
                'missing' => max(0, $before - $available),
                'extra_capacity' => max(0, $available - $after),
                'change' => $after - $before,
                'updated' => false,
                'status' => 'No change',
            ]);
        }

        $originalTotal = $rows->sum('before');
        $availableTotal = $rows->sum('available');
        $targetBalancedTotal = min($originalTotal, $availableTotal);
        $remaining = $targetBalancedTotal - $rows->sum('after');
        $balancedRows = $this->distributeRemainingVehicles($rows, $remaining);
        $updated = 0;

        DB::transaction(function () use ($balancedRows, $start, $end, $originalTotal, $availableTotal, $targetBalancedTotal, $missingStatistics, &$updated) {
            foreach ($balancedRows as $row) {
                if (! $row['id']) {
                    continue;
                }

                $changed = (int) $row['after'] !== (int) $row['before'];

                if ($changed) {
                    DB::table('daily_vehicle_statistics')
                        ->where('id', $row['id'])
                        ->update([
                            'vehicles' => (int) $row['after'],
                            'updated_at' => now(),
                        ]);

                    $updated++;
                }
            }

            DB::table('daily_vehicle_statistics_sync_logs')->insert([
                'start_date' => $start,
                'end_date' => $end,
                'original_total' => $originalTotal,
                'available_total' => $availableTotal,
                'balanced_total' => $balancedRows->sum('after'),
                'missing_total' => max(0, $originalTotal - $targetBalancedTotal),
                'updated_days' => $updated,
                'created_by' => auth()->id(),
                'missing_statistics' => json_encode($missingStatistics),
                'rows_json' => json_encode($balancedRows->values()->all()),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        $responseRows = $balancedRows
            ->map(function ($row) {
                unset($row['id']);

                return $row;
            })
            ->values();

        return response()->json([
            'status' => 'ok',
            'start' => $start,
            'end' => $end,
            'updated_days' => $updated,
            'missing_statistics' => $missingStatistics,
            'total_before' => $originalTotal,
            'total_available' => $availableTotal,
            'total_after' => $balancedRows->sum('after'),
            'total_missing' => max(0, $originalTotal - $targetBalancedTotal),
            'rows' => $responseRows,
        ]);
    }

    public function daily(
        $start,
        $end,
        DailyVehicleTargetService $targetService,
        VehicleDetailSelectionService $selectionService
    ) {
        $start_original = $start;
        $end_original   = $end;

        // user 805 => show all dates (no filter)
        if (auth()->user()->id == '805') {
            $start = null;
            $end   = null;
        }

        $com        = DB::table('beta_company_group')->get();
        $main_road  = DB::table('beta_main_road')->get();
        $beta_t_type= DB::table('beta_t_type')->get();

        // Base query for SUCCESS enters
        $baseEnter = DB::table('beta_enter as e')
            ->where('e.status', 'SUCCESS')
            ->when($start, function ($q) use ($start) {
            $q->whereDate('e.date_make', '>=', $start);
        })
        ->when($end, function ($q) use ($end) {
            $q->whereDate('e.date_make', '<=', $end);
        });

        // 1) beta_enter list
        $beta_enter = (clone $baseEnter)
            ->orderBy('e.date_make', 'asc')
            ->get();

        // 2) count per company (COUNT DISTINCT enter_id is usually what you want)
        // If you truly want count of details rows, use join + count(ed.enter_id) instead.
        $count_beta_enter = (clone $baseEnter)
            ->select('e.com_id', DB::raw('COUNT(DISTINCT e.enter_id) AS TOTAL_COUNT_COM'))
            ->groupBy('e.com_id')
            ->get()
            ->keyBy('com_id');

        // 3) count details per company (this matches your old $count_t_model logic)
        $count_t_model = DB::table('beta_enter_detail as ed')
            ->join('beta_enter as e', 'ed.enter_id', '=', 'e.enter_id')
            ->where('e.status', 'SUCCESS')
            ->when($start, function ($q) use ($start) {
            $q->whereDate('e.date_make', '>=', $start);
        })
        ->when($end, function ($q) use ($end) {
            $q->whereDate('e.date_make', '<=', $end);
        })
            ->select('e.com_id', DB::raw('COUNT(ed.enter_id) AS TOTAL_COUNT'))
            ->groupBy('e.com_id')
            ->get()
            ->keyBy('com_id');

        // 4) main_road counts
        $count_main_road = DB::table('beta_enter as e')
            ->join('beta_enter_detail as ed', 'e.enter_id', '=', 'ed.enter_id')
            ->where('e.status', 'SUCCESS')
            ->when($start, function ($q) use ($start) {
            $q->whereDate('e.date_make', '>=', $start);
        })
        ->when($end, function ($q) use ($end) {
            $q->whereDate('e.date_make', '<=', $end);
        })
            ->select('e.main_road_id', DB::raw('COUNT(ed.enter_id) AS TOTAL_COUNT_MAIN_ROAD'))
            ->groupBy('e.main_road_id')
            ->get()
            ->keyBy('main_road_id');

        // 5) t_type counts
        $count_beta_t_type = DB::table('beta_enter as e')
            ->join('beta_enter_detail as ed', 'e.enter_id', '=', 'ed.enter_id')
            ->where('e.status', 'SUCCESS')
           ->when($start, function ($q) use ($start) {
                $q->whereDate('e.date_make', '>=', $start);
            })
            ->when($end, function ($q) use ($end) {
                $q->whereDate('e.date_make', '<=', $end);
            })
            ->select('ed.t_model', DB::raw('COUNT(ed.enter_id) AS TOTAL_COUNT_T'))
            ->groupBy('ed.t_model')
            ->get()
            ->keyBy('t_model');

        // 6) detail rows (only needed when sw on)
        $enter_detail = DB::table('beta_enter_detail as ed')
            ->join('beta_enter as e', 'ed.enter_id', '=', 'e.enter_id')
            ->join('beta_t_type as t', 'ed.t_model', '=', 't.t_type_id')
            ->where('e.status', 'SUCCESS')
            ->when($start, function ($q) use ($start) {
            $q->whereDate('e.date_make', '>=', $start);
        })
        ->when($end, function ($q) use ($end) {
            $q->whereDate('e.date_make', '<=', $end);
        })
            ->select(
                'e.enter_id', 'e.com_id', 'e.date_make', 'e.enter_number',
                'ed.enter_detail_id','ed.plate_number','ed.p_import','ed.weight','ed.t_model',
                't.t_type_name'
            )
            ->orderBy('e.date_make','asc')
            ->get();

        $sw = $enter_detail->count() > 1000 ? 'off' : 'on';

        // Index details by com_id then enter_id for fast Blade rendering
        $detailsByComEnter = [];
        if ($sw === 'on') {
            foreach ($enter_detail as $d) {
                $detailsByComEnter[$d->com_id][$d->enter_id][] = $d;
            }
        }

        $rounds_count = DB::select("SELECT COUNT(ed.rounds) AS total_round FROM beta_enter e JOIN beta_enter_detail ed ON e.enter_id = ed.enter_id WHERE date(e.date_make) >= '".$start."' AND date(e.date_make) <= '".$end."' AND ed.rounds > '1' ");
        $rounds_count = $rounds_count[0]->total_round;
        $get_count    = DB::select("SELECT COUNT(ed.enter_detail_id) AS total_take FROM beta_enter_detail ed JOIN beta_enter e ON ed.enter_id = e.enter_id  WHERE date(e.date_make) >= '".$start."' AND date(e.date_make) <= '".$end."' AND e.take = '1' ");
        $take_count   = $get_count[0]->total_take;

        $take_list  = DB::select("SELECT e.*,c.* FROM beta_enter e JOIN beta_company_group c ON e.com_id = c.com_id WHERE date(e.date_make) >= '".$start."' AND date(e.date_make) <= '".$end."' AND e.take = '1' ");
        $detail_list = DB::SELECT("SELECT * FROM beta_enter_detail WHERE enter_id IN (SELECT enter_id FROM beta_enter WHERE date(date_make) >= '".$start."' AND date(date_make) <= '".$end."' AND take = '1')");

        $selectionData = $this->buildDailyVehicleSelection($start_original, $end_original, $targetService, $selectionService);
        $selectedIds = $selectionData['selected_ids'];
        $selectedIdLookup = array_fill_keys($selectedIds, true);
        $allBetaEnter = $beta_enter->keyBy('enter_id');

        $enter_detail = $enter_detail
            ->filter(function ($detail) use ($selectedIdLookup) {
                return isset($selectedIdLookup[(int) $detail->enter_detail_id]);
            })
            ->values();

        $beta_enter = $beta_enter
            ->filter(function ($enter) use ($enter_detail) {
                return $enter_detail->contains('enter_id', $enter->enter_id);
            })
            ->values();

        $count_t_model = $enter_detail
            ->groupBy('com_id')
            ->map(function ($items, $comId) {
                return (object) [
                    'com_id' => $comId,
                    'TOTAL_COUNT' => $items->count(),
                ];
            })
            ->keyBy('com_id');

        $count_main_road = $enter_detail
            ->groupBy(function ($detail) use ($allBetaEnter) {
                return optional($allBetaEnter->get($detail->enter_id))->main_road_id;
            })
            ->map(function ($items, $mainRoadId) {
                return (object) [
                    'main_road_id' => $mainRoadId,
                    'TOTAL_COUNT_MAIN_ROAD' => $items->count(),
                ];
            })
            ->keyBy('main_road_id');

        $count_beta_t_type = $enter_detail
            ->groupBy('t_model')
            ->map(function ($items, $typeId) {
                return (object) [
                    't_model' => $typeId,
                    'TOTAL_COUNT_T' => $items->count(),
                ];
            })
            ->keyBy('t_model');

        $count_beta_enter = $beta_enter
            ->groupBy('com_id')
            ->map(function ($items, $comId) {
                return (object) [
                    'com_id' => $comId,
                    'TOTAL_COUNT_COM' => $items->count(),
                ];
            })
            ->keyBy('com_id');

        $detailsByComEnter = [];
        if ($sw === 'on') {
            foreach ($enter_detail as $d) {
                $detailsByComEnter[$d->com_id][$d->enter_id][] = $d;
            }
        }

        $rounds_count = DB::table('beta_enter_detail')
            ->whereIn('enter_detail_id', $selectedIds)
            ->where('rounds', '>', '1')
            ->count('rounds');

        $takeRows = collect($take_list)
            ->filter(function ($row) use ($beta_enter) {
                return $beta_enter->contains('enter_id', $row->enter_id);
            })
            ->values();

        $take_count = DB::table('beta_enter_detail as ed')
            ->join('beta_enter as e', 'e.enter_id', '=', 'ed.enter_id')
            ->whereIn('ed.enter_detail_id', $selectedIds)
            ->where('e.take', '1')
            ->count('ed.enter_detail_id');
        $take_list = $takeRows;
        $detail_list = collect($detail_list)
            ->filter(function ($detail) use ($selectedIdLookup) {
                return isset($selectedIdLookup[(int) $detail->enter_detail_id]);
            })
            ->values();
        $dailyVehicleValidation = $selectionData['validation'];
        $dailyVehicleValidation['selected_count'] = $enter_detail->count();
        $dailyVehicleValidation['grand_total'] = $enter_detail->count();
        $dailyVehicleValidation['difference'] = $enter_detail->count() - $dailyVehicleValidation['target'];

        return view('reports.daily-vehicle-statistics', compact(
            'com',
            'main_road',
            'beta_t_type',
            'beta_enter',
            'sw',
            'detailsByComEnter',
            'count_t_model',
            'count_main_road',
            'count_beta_t_type',
            'count_beta_enter',
            'take_list',
            'detail_list'
        ))
        ->with('start', $start_original)
        ->with('end', $end_original)
        ->with('rounds_count',$rounds_count)
        ->with('take_count',$take_count)
        ->with('daily_vehicle_messages', $selectionData['messages'])
        ->with('daily_vehicle_validation', $dailyVehicleValidation)
        ;
    }

    private function buildDailyVehicleSelection(
        string $start,
        string $end,
        DailyVehicleTargetService $targetService,
        VehicleDetailSelectionService $selectionService
    ): array {
        $messages = [];
        $selections = [];

        foreach ($this->datesBetween($start, $end) as $date) {
            $statistic = $targetService->findForDate($date);

            if (! $statistic) {
                $messages[] = 'No daily vehicle statistic exists for this date: '.$date;
                continue;
            }

            $selections[$date] = $selectionService->selectForDate($date, (int) $statistic->vehicles);
        }

        $selectedIds = collect($selections)
            ->flatMap(function ($selection) {
                return $selection['selected_ids'];
            })
            ->map(function ($id) {
                return (int) $id;
            })
            ->unique()
            ->values()
            ->all();

        $target = collect($selections)->sum('target');
        $selectedCount = count($selectedIds);

        return [
            'selected_ids' => $selectedIds,
            'messages' => $messages,
            'validation' => [
                'target' => $target,
                'database_detail_count' => collect($selections)->sum('available_count'),
                'parent_count' => collect($selections)->sum('parent_count'),
                'selected_count' => $selectedCount,
                'grand_total' => $selectedCount,
                'difference' => $selectedCount - $target,
                'statuses' => collect($selections)->pluck('status')->unique()->values()->all(),
            ],
        ];
    }

    private function datesBetween(string $start, string $end): array
    {
        $dates = [];
        $current = strtotime($start);
        $last = strtotime($end);

        while ($current <= $last) {
            $dates[] = date('Y-m-d', $current);
            $current = strtotime('+1 day', $current);
        }

        return $dates;
    }

    private function availableDetailCount(string $date): int
    {
        return DB::table('beta_enter_detail as ed')
            ->join('beta_enter as e', 'e.enter_id', '=', 'ed.enter_id')
            ->where('e.status', 'SUCCESS')
            ->whereDate('e.date_make', $date)
            ->count('ed.enter_detail_id');
    }

    private function distributeRemainingVehicles($rows, int $remaining)
    {
        $balanced = $rows->values();

        while ($remaining > 0) {
            $candidateIndexes = $balanced
                ->filter(function ($row) {
                    return $row['id'] && $row['after'] < $row['available'];
                })
                ->keys()
                ->values();

            if ($candidateIndexes->isEmpty()) {
                break;
            }

            $share = max(1, intdiv($remaining, $candidateIndexes->count()));
            $changedThisRound = false;

            foreach ($candidateIndexes as $index) {
                if ($remaining <= 0) {
                    break;
                }

                $row = $balanced->get($index);
                $capacity = $row['available'] - $row['after'];
                $add = min($capacity, $share, $remaining);

                if ($add <= 0) {
                    continue;
                }

                $row['after'] += $add;
                $row['extra_capacity'] = max(0, $row['available'] - $row['after']);
                $balanced->put($index, $row);
                $remaining -= $add;
                $changedThisRound = true;
            }

            if (! $changedThisRound) {
                break;
            }
        }

        return $balanced
            ->map(function ($row) {
                if (! $row['id']) {
                    return $row;
                }

                $row['missing'] = max(0, $row['before'] - $row['available']);
                $row['extra_capacity'] = max(0, $row['available'] - $row['after']);
                $row['change'] = $row['after'] - $row['before'];
                $row['updated'] = $row['after'] !== $row['before'];
                $row['status'] = $row['updated'] ? 'Updated' : 'No change';

                return $row;
            });
    }
}
