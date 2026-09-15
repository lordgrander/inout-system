<?php

namespace App\Http\Controllers;

use App\Models\SpecialUser;
use App\Services\Reports\VehicleDetailSelectionService;
use DateTimeImmutable;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TaskController extends Controller
{
    public function login()
    {
        if (session('task_user_id') && session('task_auth_until')) {
            $expiresAt = $this->dateTime(session('task_auth_until'));

            if ($this->now() < $expiresAt) {
                return redirect()->route('task.dashboard');
            }
        }

        return view('task.login');
    }

    public function loginStore(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = SpecialUser::where('username', $request->username)->first();

        if (!$user || !$user->status || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'username' => 'ຊື່ຜູ້ໃຊ້ ຫຼື ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ ຫຼື ບັນຊີນີ້ຖືກປິດໃຊ້ງານ.',
            ])->withInput($request->only('username'));
        }

        $expiresAt = $this->nextSessionBoundary();

        $request->session()->put([
            'task_user_id' => $user->id,
            'task_user_name' => $user->name ?: $user->username,
            'task_auth_until' => $expiresAt->format('Y-m-d H:i:s'),
        ]);

        DB::table('special_user')
            ->where('id', $user->id)
            ->update([
                'last_login_at' => $this->now()->format('Y-m-d H:i:s'),
                'updated_at' => $this->now()->format('Y-m-d H:i:s'),
            ]);

        return redirect()->route('task.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['task_user_id', 'task_user_name', 'task_auth_until']);

        return redirect()->route('task.login');
    }

    public function dashboard()
    {
        return view('task.dashboard', [
            'userName' => session('task_user_name'),
            'authUntil' => session('task_auth_until'),
            'roadIds' => $this->allowedRoadIds(),
            'roadLabel' => $this->roadLabel(),
        ]);
    }

    public function data(Request $request, VehicleDetailSelectionService $selectionService)
    {
        $filters = $this->filters($request);
        $targetLimit = $this->targetLimit($filters, $selectionService);
        $base = $this->baseEntryQuery($filters, $targetLimit);
        $page = max(1, (int) $request->input('page', 1));
        $perPage = 40;
        $totalEntries = (clone $base)->count('e.enter_id');
        $lastPage = max(1, (int) ceil($totalEntries / $perPage));
        $page = min($page, $lastPage);
        $entryIds = (clone $base)
            ->select('e.enter_id')
            ->orderByDesc('e.date_make')
            ->orderByDesc('e.enter_id')
            ->forPage($page, $perPage)
            ->pluck('e.enter_id');

        $flatRows = $entryIds->isEmpty()
            ? collect()
            : $this->detailRowsQuery($filters, $targetLimit, $entryIds)->get();

        $entryIds = $flatRows->pluck('enter_id')->unique()->values();
        $filesByEnterId = $entryIds->isEmpty()
            ? collect()
            : DB::table('beta_enter_file')
                ->whereIn('enter_id', $entryIds)
                ->select(['file_id', 'enter_id', 'file_url', 'date'])
                ->orderBy('file_id')
                ->get()
                ->groupBy('enter_id')
                ->map(function ($files) {
                    return $files->map(function ($file) {
                        $path = (string) $file->file_url;
                        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

                        return [
                            'file_id' => $file->file_id,
                            'file_url' => $path,
                            'url' => asset($path),
                            'date' => $file->date,
                            'extension' => $extension,
                            'kind' => in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']) ? 'image' : ($extension === 'pdf' ? 'pdf' : 'file'),
                        ];
                    })->values();
                });

        $rows = $flatRows
            ->groupBy('enter_id')
            ->map(function ($group) use ($filesByEnterId) {
                $first = $group->first();
                $files = $filesByEnterId->get($first->enter_id, collect());

                return [
                    'enter_id' => $first->enter_id,
                    'enter_number' => $first->enter_number,
                    'date_make' => $first->date_make,
                    'date_in' => $first->date_in,
                    'date_out' => $first->date_out,
                    'status' => $first->status,
                    'main_road_id' => $first->main_road_id,
                    'main_road_name' => $first->main_road_name,
                    'address' => $first->address,
                    'district' => $first->district,
                    'province' => $first->province,
                    'com_name' => $first->com_name,
                    'com_phone' => $first->com_phone,
                    'file_count' => $files->count(),
                    'files' => $files->values(),
                    'details' => $group
                        ->filter(function ($row) {
                            return $row->enter_detail_id !== null;
                        })
                        ->map(function ($row) {
                            return [
                                'enter_detail_id' => $row->enter_detail_id,
                                'plate_number' => $row->plate_number,
                                'd_name' => $row->d_name,
                                'p_import' => $row->p_import,
                                'weight' => $row->weight,
                                'rounds' => $row->rounds,
                                'detail' => $row->detail,
                                't_type_name' => $row->t_type_name,
                            ];
                        })
                        ->values(),
                ];
            })
            ->values();

        return response()->json([
            'rows' => $rows,
            'summary' => [
                'enter_count' => $totalEntries,
                'detail_count' => $this->detailCount($filters, $targetLimit, $base),
                'updated_at' => $this->now()->format('d-m-Y'),
                'road_ids' => $this->allowedRoadIds(),
                'road_label' => $this->roadLabel(),
                'take_visible' => $this->takeVisible(),
                'target_limited' => !empty($targetLimit['limited_dates']),
                'target_limited_dates' => $targetLimit['limited_dates'],
                'pagination' => [
                    'page' => $page,
                    'per_page' => $perPage,
                    'total' => $totalEntries,
                    'last_page' => $lastPage,
                ],
            ],
        ]);
    }

    private function baseEntryQuery(array $filters, array $targetLimit)
    {
        $query = DB::table('beta_enter as e')
            ->leftJoin('beta_company_group as c', 'c.com_id', '=', 'e.com_id')
            ->where('e.status', 'SUCCESS');

        $takeVisible = $this->takeVisible();
        if ($takeVisible !== 'all') {
            $query->where('e.take', $takeVisible);
        }

        $this->applyRoadPermission($query, $targetLimit);

        if ($filters['date_from']) {
            $query->whereDate('e.date_make', '>=', $filters['date_from']);
        }

        if ($filters['date_to']) {
            $query->whereDate('e.date_make', '<=', $filters['date_to']);
        }

        if ($filters['enter_number']) {
            $query->where('e.enter_number', 'LIKE', '%' . $filters['enter_number'] . '%');
        }

        if ($filters['company_name']) {
            $query->where('c.com_name', 'LIKE', '%' . $filters['company_name'] . '%');
        }

        if (!empty($targetLimit['limited_dates'])) {
            $this->applyTargetLimitToEntryQuery($query, $targetLimit, $filters);
        } else {
            $this->applyDetailFilterExists($query, $filters);
        }

        return $query;
    }

    private function detailRowsQuery(array $filters, array $targetLimit, $entryIds)
    {
        $query = DB::table('beta_enter as e')
            ->leftJoin('beta_enter_detail as ed', 'ed.enter_id', '=', 'e.enter_id')
            ->leftJoin('beta_company_group as c', 'c.com_id', '=', 'e.com_id')
            ->leftJoin('beta_main_road as m', 'm.main_road_id', '=', 'e.main_road_id')
            ->leftJoin('beta_t_type as t', 't.t_type_id', '=', 'ed.t_model')
            ->whereIn('e.enter_id', $entryIds)
            ->select([
                'e.enter_id',
                'e.enter_number',
                'e.date_make',
                'e.date_in',
                'e.date_out',
                'e.status',
                'e.main_road_id',
                'e.address',
                'e.district',
                'e.province',
                'c.com_name',
                'c.com_phone',
                'm.main_road_name',
                'ed.enter_detail_id',
                'ed.plate_number',
                'ed.d_name',
                'ed.p_import',
                'ed.weight',
                'ed.rounds',
                'ed.detail',
                't.t_type_name',
            ])
            ->orderByDesc('e.date_make')
            ->orderByDesc('e.enter_id');

        $this->applyTargetLimitToDetailQuery($query, $targetLimit, 'ed', 'e');
        $this->applyDetailFilters($query, $filters, 'ed');

        return $query;
    }

    private function detailCount(array $filters, array $targetLimit, $baseEntryQuery): int
    {
        $query = DB::table('beta_enter_detail as ed')
            ->whereIn('ed.enter_id', (clone $baseEntryQuery)->select('e.enter_id'));

        $this->applyDetailFilters($query, $filters, 'ed');

        if (!empty($targetLimit['limited_dates'])) {
            $query->join('beta_enter as e_count', 'e_count.enter_id', '=', 'ed.enter_id');
            $this->applyTargetLimitToDetailQuery($query, $targetLimit, 'ed', 'e_count');
        }

        return $query->count('ed.enter_detail_id');
    }

    private function applyTargetLimitToEntryQuery($query, array $targetLimit, array $filters): void
    {
        if (empty($targetLimit['limited_dates'])) {
            return;
        }

        $query->where(function ($limitedQuery) use ($targetLimit, $filters) {
            if (!empty($targetLimit['selected_ids'])) {
                $limitedQuery->whereExists(function ($detailQuery) use ($targetLimit, $filters) {
                    $detailQuery->select(DB::raw(1))
                        ->from('beta_enter_detail as ed_limit')
                        ->whereColumn('ed_limit.enter_id', 'e.enter_id')
                        ->whereIn('ed_limit.enter_detail_id', $targetLimit['selected_ids']);

                    $this->applyDetailFilters($detailQuery, $filters, 'ed_limit');
                });
            }

            $limitedQuery->orWhere(function ($normalDateQuery) use ($targetLimit) {
                foreach ($targetLimit['limited_dates'] as $date) {
                    $normalDateQuery->whereDate('e.date_make', '<>', $date);
                }
            });

            if ($this->hasDetailFilters($filters)) {
                $limitedQuery->whereExists(function ($detailQuery) use ($filters) {
                    $detailQuery->select(DB::raw(1))
                        ->from('beta_enter_detail as ed_filter')
                        ->whereColumn('ed_filter.enter_id', 'e.enter_id');

                    $this->applyDetailFilters($detailQuery, $filters, 'ed_filter');
                });
            }
        });
    }

    private function applyTargetLimitToDetailQuery($query, array $targetLimit, string $detailAlias, string $entryAlias): void
    {
        if (empty($targetLimit['limited_dates'])) {
            return;
        }

        $query->where(function ($limitedQuery) use ($targetLimit, $detailAlias, $entryAlias) {
            if (!empty($targetLimit['selected_ids'])) {
                $limitedQuery->whereIn($detailAlias . '.enter_detail_id', $targetLimit['selected_ids']);
            }

            $limitedQuery->orWhere(function ($normalDateQuery) use ($targetLimit, $entryAlias) {
                foreach ($targetLimit['limited_dates'] as $date) {
                    $normalDateQuery->whereDate($entryAlias . '.date_make', '<>', $date);
                }
            });
        });
    }

    private function applyDetailFilterExists($query, array $filters): void
    {
        if (! $this->hasDetailFilters($filters)) {
            return;
        }

        $query->whereExists(function ($detailQuery) use ($filters) {
            $detailQuery->select(DB::raw(1))
                ->from('beta_enter_detail as ed_filter')
                ->whereColumn('ed_filter.enter_id', 'e.enter_id');

            $this->applyDetailFilters($detailQuery, $filters, 'ed_filter');
        });
    }

    private function applyDetailFilters($query, array $filters, string $detailAlias): void
    {
        if ($filters['plate_number']) {
            $query->where($detailAlias . '.plate_number', 'LIKE', '%' . $filters['plate_number'] . '%');
        }

        if ($filters['d_name']) {
            $query->where($detailAlias . '.d_name', 'LIKE', '%' . $filters['d_name'] . '%');
        }

        if ($filters['p_import']) {
            $query->where($detailAlias . '.p_import', 'LIKE', '%' . $filters['p_import'] . '%');
        }
    }

    private function hasDetailFilters(array $filters): bool
    {
        return (bool) ($filters['plate_number'] || $filters['d_name'] || $filters['p_import']);
    }

    private function applyRoadPermission($query, array $targetLimit): void
    {
        $allowedRoadIds = $this->allowedRoadIds();
        if (empty($allowedRoadIds)) {
            return;
        }

        if (empty($targetLimit['limited_dates'])) {
            $query->whereIn('e.main_road_id', $allowedRoadIds);
            return;
        }

        $query->where(function ($roadQuery) use ($allowedRoadIds, $targetLimit) {
            $roadQuery->whereIn('e.main_road_id', $allowedRoadIds)
                ->orWhere(function ($limitedDateQuery) use ($targetLimit) {
                    foreach ($targetLimit['limited_dates'] as $date) {
                        $limitedDateQuery->orWhereDate('e.date_make', $date);
                    }
                });
        });
    }

    private function targetLimit(array $filters, VehicleDetailSelectionService $selectionService): array
    {
        if (substr((string) $filters['date_from'], 0, 4) !== '2025') {
            return [
                'limited_dates' => [],
                'selected_ids' => [],
            ];
        }

        $dates = array_values(array_filter($this->datesBetween($filters['date_from'], $filters['date_to']), function ($date) {
            return substr($date, 0, 4) === '2025';
        }));

        if (empty($dates)) {
            return [
                'limited_dates' => [],
                'selected_ids' => [],
            ];
        }

        $statistics = DB::table('daily_vehicle_statistics')
            ->whereIn('stat_date', $dates)
            ->pluck('vehicles', 'stat_date');

        $limitedDates = [];
        $selectedIds = [];

        foreach ($dates as $date) {
            if (! $statistics->has($date)) {
                continue;
            }

            $selection = $selectionService->selectForDate($date, (int) $statistics->get($date));
            $limitedDates[] = $date;
            $selectedIds = array_merge($selectedIds, $selection['selected_ids']);
        }

        return [
            'limited_dates' => $limitedDates,
            'selected_ids' => array_values(array_unique(array_map('intval', $selectedIds))),
        ];
    }

    private function datesBetween($start, $end): array
    {
        if (! $this->validDate($start) || ! $this->validDate($end)) {
            return [];
        }

        $current = new DateTimeImmutable($start, $this->timeZone());
        $last = new DateTimeImmutable($end, $this->timeZone());

        if ($current > $last) {
            return [];
        }

        $dates = [];
        while ($current <= $last) {
            $dates[] = $current->format('Y-m-d');
            $current = $current->modify('+1 day');
        }

        return $dates;
    }

    private function validDate($value): bool
    {
        $date = DateTimeImmutable::createFromFormat('!Y-m-d', (string) $value, $this->timeZone());

        return $date && $date->format('Y-m-d') === $value;
    }

    private function filters(Request $request)
    {
        $today = $this->now()->format('Y-m-d');

        return [
            'date_from' => $request->input('date_from', $today),
            'date_to' => $request->input('date_to', $today),
            'enter_number' => trim((string) $request->input('enter_number', '')),
            'company_name' => trim((string) $request->input('company_name', '')),
            'plate_number' => trim((string) $request->input('plate_number', '')),
            'd_name' => trim((string) $request->input('d_name', '')),
            'p_import' => trim((string) $request->input('p_import', '')),
        ];
    }

    private function nextSessionBoundary()
    {
        $now = $this->now();
        $noon = $now->setTime(12, 0, 0);

        if ($now < $noon) {
            return $noon;
        }

        return $now->modify('+1 day')->setTime(0, 0, 0);
    }

    private function now()
    {
        return new DateTimeImmutable('now', $this->timeZone());
    }

    private function dateTime($value)
    {
        return new DateTimeImmutable($value, $this->timeZone());
    }

    private function timeZone()
    {
        return new DateTimeZone('Asia/Bangkok');
    }

    private function allowedRoadIds()
    {
        return DB::table('special_user_road')
            ->where('special_user_id', session('task_user_id'))
            ->orderBy('main_road_id')
            ->pluck('main_road_id')
            ->map(function ($roadId) {
                return (int) $roadId;
            })
            ->values()
            ->all();
    }

    private function roadLabel()
    {
        $roadIds = $this->allowedRoadIds();

        if (empty($roadIds)) {
            return 'ທັງໝົດ';
        }

        return implode(', ', $roadIds);
    }

    private function takeVisible()
    {
        $value = DB::table('special_user')
            ->where('id', session('task_user_id'))
            ->value('take_visible');

        return in_array($value, ['0', '1', 'all'], true) ? $value : '1';
    }
}
