<?php

namespace App\Services\Reports;

use Illuminate\Support\Facades\DB;

class VehicleReportBuilderService
{
    public function build(string $date, int $target, array $selection): array
    {
        $selectedIds = $selection['selected_ids'];
        $rows = $this->loadSelectedRows($selectedIds);

        $companies = $rows
            ->groupBy('com_id')
            ->map(function ($companyRows) {
                $first = $companyRows->first();

                return [
                    'com_id' => $first->com_id,
                    'company_name' => $first->com_name ?: '-',
                    'selected_count' => $companyRows->count(),
                    'enters' => $companyRows
                        ->groupBy('enter_id')
                        ->map(function ($enterRows) {
                            $first = $enterRows->first();

                            return [
                                'enter_id' => $first->enter_id,
                                'enter_number' => $first->enter_number,
                                'date_make' => $first->date_make,
                                'details' => $enterRows->values(),
                            ];
                        })
                        ->values(),
                ];
            })
            ->sortBy('company_name')
            ->values();

        $productSummary = $rows
            ->groupBy(function ($row) {
                return $row->p_import ?: '-';
            })
            ->map(function ($items, $name) {
                return [
                    'name' => $name,
                    'total' => $items->count(),
                ];
            })
            ->sortBy('name')
            ->values();

        $vehicleSummary = $rows
            ->groupBy(function ($row) {
                return $row->t_type_name ?: '-';
            })
            ->map(function ($items, $name) {
                return [
                    'name' => $name,
                    'total' => $items->count(),
                ];
            })
            ->sortBy('name')
            ->values();

        $companyTotal = $companies->sum('selected_count');
        $productTotal = $productSummary->sum('total');
        $vehicleTotal = $vehicleSummary->sum('total');
        $displayedRows = $rows->count();
        $status = $selection['status'];

        if (! $this->totalsMatch($displayedRows, $companyTotal, $productTotal, $vehicleTotal, $selection['selected_count'])) {
            $status = 'Mismatch';
        }

        return [
            'date' => $date,
            'target' => $target,
            'companies' => $companies,
            'product_summary' => $productSummary,
            'vehicle_summary' => $vehicleSummary,
            'validation' => [
                'report_date' => $date,
                'target' => $target,
                'database_detail_count' => $selection['available_count'],
                'parent_count' => $selection['parent_count'],
                'min_possible' => $selection['min_possible'],
                'selected_count' => $selection['selected_count'],
                'displayed_detail_rows' => $displayedRows,
                'company_total_sum' => $companyTotal,
                'vehicle_summary_total' => $vehicleTotal,
                'product_summary_total' => $productTotal,
                'grand_total' => $displayedRows,
                'difference' => $displayedRows - $target,
                'shortage' => max(0, $target - $displayedRows),
                'status' => $status,
            ],
        ];
    }

    public function buildLegacyRange(string $start, string $end, array $selections, array $messages = []): array
    {
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

        $rows = $this->loadSelectedRows($selectedIds);

        return $this->buildLegacyViewData($start, $end, $rows, $messages, [
                'target' => collect($selections)->sum('target'),
                'database_detail_count' => collect($selections)->sum('available_count'),
                'parent_count' => collect($selections)->sum('parent_count'),
                'selected_count' => $rows->count(),
                'grand_total' => $rows->count(),
                'difference' => $rows->count() - collect($selections)->sum('target'),
                'statuses' => collect($selections)->pluck('status')->unique()->values()->all(),
        ]);
    }

    public function buildSuccessRange(string $start, string $end, array $messages = []): array
    {
        $rows = empty($messages)
            ? $this->loadSuccessRows($start, $end)
            : collect();

        return $this->buildLegacyViewData($start, $end, $rows, $messages);
    }

    private function loadSelectedRows(array $selectedIds)
    {
        if (empty($selectedIds)) {
            return collect();
        }

        return DB::table('beta_enter_detail as ed')
            ->join('beta_enter as e', 'e.enter_id', '=', 'ed.enter_id')
            ->leftJoin('beta_company_group as c', 'c.com_id', '=', 'e.com_id')
            ->leftJoin('beta_t_type as t', 't.t_type_id', '=', 'ed.t_model')
            ->whereIn('ed.enter_detail_id', $selectedIds)
            ->select([
                'e.enter_id',
                'e.enter_number',
                'e.com_id',
                'e.main_road_id',
                'e.date_make',
                'e.take',
                'c.com_name',
                'ed.enter_detail_id',
                'ed.plate_number',
                'ed.p_import',
                'ed.weight',
                'ed.rounds',
                'ed.t_model',
                't.t_type_name',
            ])
            ->orderBy('c.com_name')
            ->orderBy('e.date_make')
            ->orderBy('e.enter_id')
            ->orderBy('ed.enter_detail_id')
            ->get();
    }

    private function loadSuccessRows(string $start, string $end)
    {
        return DB::table('beta_enter_detail as ed')
            ->join('beta_enter as e', 'e.enter_id', '=', 'ed.enter_id')
            ->leftJoin('beta_company_group as c', 'c.com_id', '=', 'e.com_id')
            ->leftJoin('beta_t_type as t', 't.t_type_id', '=', 'ed.t_model')
            ->where('e.status', 'SUCCESS')
            ->whereDate('e.date_make', '>=', $start)
            ->whereDate('e.date_make', '<=', $end)
            ->select([
                'e.enter_id',
                'e.enter_number',
                'e.com_id',
                'e.main_road_id',
                'e.date_make',
                'e.take',
                'c.com_name',
                'ed.enter_detail_id',
                'ed.plate_number',
                'ed.p_import',
                'ed.weight',
                'ed.rounds',
                'ed.t_model',
                't.t_type_name',
            ])
            ->orderBy('c.com_name')
            ->orderBy('e.date_make')
            ->orderBy('e.enter_id')
            ->orderBy('ed.enter_detail_id')
            ->get();
    }

    private function buildLegacyViewData(string $start, string $end, $rows, array $messages = [], ?array $validation = null): array
    {
        $betaEnter = $rows
            ->unique('enter_id')
            ->sortBy([
                ['date_make', 'asc'],
                ['enter_id', 'asc'],
            ])
            ->map(function ($row) {
                return (object) [
                    'enter_id' => $row->enter_id,
                    'com_id' => $row->com_id,
                    'main_road_id' => $row->main_road_id,
                    'date_make' => $row->date_make,
                    'enter_number' => $row->enter_number,
                    'take' => $row->take,
                ];
            })
            ->values();

        $detailsByComEnter = [];
        foreach ($rows as $row) {
            $detailsByComEnter[$row->com_id][$row->enter_id][] = $row;
        }

        $countTModel = $rows
            ->groupBy('com_id')
            ->map(function ($items, $comId) {
                return (object) [
                    'com_id' => $comId,
                    'TOTAL_COUNT' => $items->count(),
                ];
            })
            ->keyBy('com_id');

        $countMainRoad = $rows
            ->groupBy('main_road_id')
            ->map(function ($items, $mainRoadId) {
                return (object) [
                    'main_road_id' => $mainRoadId,
                    'TOTAL_COUNT_MAIN_ROAD' => $items->count(),
                ];
            })
            ->keyBy('main_road_id');

        $countBetaTType = $rows
            ->groupBy('t_model')
            ->map(function ($items, $typeId) {
                return (object) [
                    't_model' => $typeId,
                    'TOTAL_COUNT_T' => $items->count(),
                ];
            })
            ->keyBy('t_model');

        $takeRows = $rows->filter(function ($row) {
            return (string) $row->take === '1';
        });

        $takeList = $takeRows
            ->unique('enter_id')
            ->map(function ($row) {
                return (object) [
                    'enter_id' => $row->enter_id,
                    'enter_number' => $row->enter_number,
                    'com_name' => $row->com_name,
                ];
            })
            ->values();

        return [
            'com' => DB::table('beta_company_group')->get(),
            'main_road' => DB::table('beta_main_road')->get(),
            'beta_t_type' => DB::table('beta_t_type')->get(),
            'beta_enter' => $betaEnter,
            'sw' => $rows->count() > 1000 ? 'off' : 'on',
            'detailsByComEnter' => $detailsByComEnter,
            'count_t_model' => $countTModel,
            'count_main_road' => $countMainRoad,
            'count_beta_t_type' => $countBetaTType,
            'count_beta_enter' => $betaEnter
                ->groupBy('com_id')
                ->map(function ($items, $comId) {
                    return (object) [
                        'com_id' => $comId,
                        'TOTAL_COUNT_COM' => $items->count(),
                    ];
                })
                ->keyBy('com_id'),
            'take_list' => $takeList,
            'detail_list' => $takeRows->values(),
            'start' => $start,
            'end' => $end,
            'rounds_count' => $rows->filter(function ($row) {
                return (int) $row->rounds > 1;
            })->count(),
            'take_count' => $takeRows->count(),
            'daily_vehicle_messages' => $messages,
            'daily_vehicle_validation' => $validation,
        ];
    }

    private function totalsMatch(int $displayedRows, int $companyTotal, int $productTotal, int $vehicleTotal, int $selectedCount): bool
    {
        return $displayedRows === $companyTotal
            && $displayedRows === $productTotal
            && $displayedRows === $vehicleTotal
            && $displayedRows === $selectedCount;
    }
}
