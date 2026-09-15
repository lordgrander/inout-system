<?php

namespace App\Http\Controllers;

use App\Models\User;
use DateTimeImmutable;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class OldUserTaskV2Controller extends Controller
{
    public function login()
    {
        if (session('old_user_task_v2_user_id') && session('old_user_task_v2_auth_until')) {
            if ($this->now() < $this->dateTime(session('old_user_task_v2_auth_until'))) {
                return redirect()->route('old-user-task-v2.dashboard');
            }
        }

        return view('new-user-task.login', [
            'taskRoutePrefix' => 'old-user-task-v2',
        ]);
    }

    public function loginStore(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !in_array((string) $user->is_admin, ['2', '3', '4', '5'], true) || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Email or password is incorrect, or this user is not allowed for this dashboard.',
            ])->withInput($request->only('email'));
        }

        $request->session()->put([
            'old_user_task_v2_user_id' => $user->id,
            'old_user_task_v2_user_name' => $user->name ?: $user->email,
            'old_user_task_v2_is_admin' => (string) $user->is_admin,
            'old_user_task_v2_auth_until' => $this->nextSessionBoundary()->format('Y-m-d H:i:s'),
        ]);

        return redirect()->route('old-user-task-v2.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget([
            'old_user_task_v2_user_id',
            'old_user_task_v2_user_name',
            'old_user_task_v2_is_admin',
            'old_user_task_v2_auth_until',
            'old_user_task_v2_sign_mode',
        ]);

        return redirect()->route('old-user-task-v2.login');
    }

    public function signMode(Request $request)
    {
        $validated = $request->validate([
            'mode' => ['required', 'string', 'in:manual,system'],
        ]);

        if (!in_array($this->userRole(), ['4', '5'], true)) {
            return response()->json(['message' => 'This action is not allowed for your role.'], 403);
        }

        $request->session()->put('old_user_task_v2_sign_mode', $validated['mode']);

        return response()->json([
            'message' => 'ok',
            'mode' => $validated['mode'],
        ]);
    }

    public function dashboard()
    {
        return view('new-user-task-v2.dashboard', [
            'userName' => session('old_user_task_v2_user_name'),
            'authUntil' => session('old_user_task_v2_auth_until'),
            'userRole' => $this->userRole(),
            'signMode' => session('old_user_task_v2_sign_mode', 'system'),
            'statusOptions' => $this->visibleStatuses(),
            'mainRoads' => DB::table('beta_main_road')->orderBy('main_road_id')->get(['main_road_id', 'main_road_name']),
            'roadOptions' => DB::table('beta_road_select')->orderBy('road_id')->get(['road_id', 'road_name']),
            'roadLabel' => 'ທັງໝົດ',
            'taskRoutePrefix' => 'old-user-task-v2',
            'printUrlBase' => url('/old-user-task-v2/print'),
        ]);
    }

    public function print($id)
    {
        if (session('old_user_task_v2_user_id')) {
            Auth::onceUsingId((int) session('old_user_task_v2_user_id'));
        }

        $beta_enter = DB::table('beta_enter as e')
            ->leftJoin('beta_main_road as m', 'm.main_road_id', '=', 'e.main_road_id')
            ->where('e.enter_id', $id)
            ->select(['e.*', 'm.main_road_name'])
            ->get();

        abort_if($beta_enter->isEmpty(), 404);

        $company = DB::table('beta_company_group')->where('com_id', $beta_enter[0]->com_id)->first();
        $user = DB::table('users')->where('id', $beta_enter[0]->user_id)->first();
        $user_data = collect([$user ?: (object) ['id' => $beta_enter[0]->user_id, 'name' => '', 'email' => '']]);
        $com_name = $company->com_name ?? '';
        $com_owner_name = $company->com_owner ?? '';

        $beta_enter_detail = DB::table('beta_enter_detail as ed')
            ->leftJoin('beta_t_type as t', 't.t_type_id', '=', 'ed.t_model')
            ->where('ed.enter_id', $id)
            ->select(['ed.*', 't.t_type_name'])
            ->get();

        $beta_enter_road_detail = DB::table('beta_enter_road_detail as erd')
            ->leftJoin('beta_road_select as rs', 'rs.road_id', '=', 'erd.road_id')
            ->where('erd.enter_id', $id)
            ->select(['erd.road_id', 'rs.road_name'])
            ->get();

        $beta_enter_file = DB::table('beta_enter_file')
            ->where('enter_id', $id)
            ->select(['file_id', 'enter_id', 'file_url', 'date'])
            ->get();

        return view('old-seeprint-preview.show', compact('beta_enter', 'beta_enter_detail', 'user_data', 'beta_enter_road_detail', 'beta_enter_file'))
            ->with('com_name', $com_name)
            ->with('com_owner_name', $com_owner_name)
            ->with('id', $id);
    }

    public function data(Request $request)
    {
        $filters = $this->filters($request);
        $base = $this->baseQuery($filters);
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

        $flatRows = $entryIds->isEmpty() ? collect() : $this->detailRowsQuery($filters, $entryIds)->get();
        $visibleEntryIds = $flatRows->pluck('id')->unique()->values();
        $filesById = $this->filesByEnterId($visibleEntryIds);
        $roadsById = $this->roadsByEnterId($visibleEntryIds);

        $rows = $flatRows->groupBy('id')->map(function ($group) use ($filesById, $roadsById) {
            $first = $group->first();
            $files = $filesById->get($first->id, collect());

            return [
                'id' => $first->id,
                'no' => $first->enter_number && $first->enter_number !== '0'
                    ? $first->enter_number
                    : 'OE-'.$this->formatYear($first->date_make).'-'.str_pad((string) $first->id, 6, '0', STR_PAD_LEFT),
                'date_make' => $this->formatDateTime($first->date_make),
                'date_in' => $this->formatDateTime($first->date_in),
                'date_out' => $this->formatDateTime($first->date_out),
                'status' => $first->status,
                'take' => $first->take,
                'com_id' => $first->com_id,
                'com_name' => $first->com_name,
                'com_phone' => $first->com_phone,
                'main_road_id' => $first->main_road_id,
                'main_road_name' => $first->main_road_name,
                'road_names' => $roadsById->get($first->id, collect())->pluck('road_name')->filter()->values(),
                'address' => $first->address,
                'district' => $first->district,
                'province' => $first->province,
                'note' => $first->feed_back_msg ?: $first->lasttails,
                'file_count' => $files->count(),
                'files' => $files->values(),
                'details' => $group->filter(function ($row) {
                    return $row->detail_id !== null;
                })->map(function ($row) {
                    return [
                        'detail_id' => $row->detail_id,
                        'plate_number' => $row->plate_number,
                        'driver_name' => $row->driver_name,
                        'product' => $row->product,
                        'weight' => $row->weight,
                        'rounds' => $row->rounds,
                        'reference' => $row->reference,
                        'type_name' => $row->type_name ?: $row->vehicle_type_id,
                    ];
                })->values(),
            ];
        })->values();

        return response()->json([
            'rows' => $rows,
            'summary' => [
                'enter_count' => $totalEntries,
                'detail_count' => $this->detailCount($filters, $base),
                'updated_at' => $this->now()->format('d-m-Y H:i:s'),
                'user_role' => $this->userRole(),
                'visible_statuses' => $this->visibleStatuses(),
                'pagination' => [
                    'page' => $page,
                    'per_page' => $perPage,
                    'total' => $totalEntries,
                    'last_page' => $lastPage,
                ],
            ],
        ]);
    }

    public function action(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'integer'],
            'action' => ['required', 'string'],
        ]);

        $entry = DB::table('beta_enter')->where('enter_id', $validated['id'])->first();

        if (!$entry) {
            return response()->json(['message' => 'Document not found.'], 404);
        }

        $action = $this->workflowAction($validated['action'], (string) $entry->status);

        if (!$action) {
            return response()->json(['message' => 'This action is not allowed for your role or this status.'], 403);
        }

        DB::table('beta_enter')->where('enter_id', $entry->enter_id)->update($this->actionUpdate($entry, $action));

        if ($action['delete_roads']) {
            DB::table('beta_enter_road_detail')->where('enter_id', $entry->enter_id)->delete();
        }

        $this->recordFeedback((int) $entry->enter_id, $action['message']);

        return response()->json(['message' => 'ok']);
    }

    public function pointing(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'integer'],
            'main_road' => ['required', 'integer', 'exists:beta_main_road,main_road_id'],
            'details' => ['nullable', 'string'],
            'formdata' => ['required', 'array', 'min:1'],
            'formdata.*' => ['required', 'integer', 'exists:beta_road_select,road_id'],
        ]);

        if (!in_array($this->userRole(), ['3', '5'], true)) {
            return response()->json(['message' => 'This action is not allowed for your role.'], 403);
        }

        $entry = DB::table('beta_enter')->where('enter_id', $validated['id'])->first();

        if (!$entry || (string) $entry->status !== 'POINTING') {
            return response()->json(['message' => 'This document is not in POINTING status.'], 403);
        }

        $roadIds = array_values(array_unique(array_map('intval', $validated['formdata'])));
        $details = trim((string) ($validated['details'] ?? ''));

        DB::transaction(function () use ($entry, $validated, $roadIds, $details) {
            DB::table('beta_enter_road_detail')->where('enter_id', $entry->enter_id)->delete();

            foreach ($roadIds as $roadId) {
                DB::table('beta_enter_road_detail')->insert([
                    'enter_id' => $entry->enter_id,
                    'road_id' => $roadId,
                ]);
            }

            DB::table('beta_enter')->where('enter_id', $entry->enter_id)->update([
                'status' => 'SIGNING',
                'feed_back_msg' => $details,
                'main_road_id' => $validated['main_road'],
            ]);

            $this->recordFeedback((int) $entry->enter_id, ' ລະບຸເສັນທາງສຳເລັດ ກຳລັງລໍຖ້າເຊັນ ');
        });

        return response()->json(['message' => 'ok']);
    }

    public function subjects(Request $request)
    {
        $validated = $request->validate(['id' => ['required', 'integer']]);

        return response()->json([
            'status' => 200,
            'data' => DB::table('beta_com_nano')
                ->where('com_id', $validated['id'])
                ->select('id', 'subject', 'com_id')
                ->orderBy('id')
            ->get(),
        ]);
    }

    public function fileOpened(Request $request)
    {
        $validated = $request->validate([
            'enter_id' => ['required', 'integer'],
            'file_id' => ['required', 'integer'],
        ]);

        if (!Schema::hasTable('old_user_task_file_views')) {
            return response()->json(['message' => 'File view table is missing.'], 500);
        }

        $file = DB::table('beta_enter_file')
            ->where('file_id', $validated['file_id'])
            ->where('enter_id', $validated['enter_id'])
            ->first();

        if (!$file) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        $now = $this->now()->format('Y-m-d H:i:s');

        $existingView = DB::table('old_user_task_file_views')
            ->where('file_id', $validated['file_id'])
            ->where('user_id', $this->currentUserId())
            ->first();

        if ($existingView) {
            DB::table('old_user_task_file_views')
                ->where('id', $existingView->id)
                ->update([
                    'enter_id' => (int) $validated['enter_id'],
                    'viewed_at' => $now,
                    'updated_at' => $now,
                ]);
        } else {
            DB::table('old_user_task_file_views')->insert([
                'file_id' => (int) $validated['file_id'],
                'user_id' => $this->currentUserId(),
                'enter_id' => (int) $validated['enter_id'],
                'viewed_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        return response()->json(['message' => 'ok']);
    }

    private function baseQuery(array $filters)
    {
        $query = DB::table('beta_enter as e')
            ->leftJoin('beta_company_group as c', 'c.com_id', '=', 'e.com_id');

        if ($filters['status'] && in_array($filters['status'], $this->visibleStatuses(), true)) {
            $query->where('e.status', $filters['status']);
        } else {
            $query->whereIn('e.status', $this->defaultStatuses() ?: ['__none__']);
        }

        if ($filters['date_from']) {
            $query->whereDate('e.date_make', '>=', $filters['date_from']);
        }

        if ($filters['date_to']) {
            $query->whereDate('e.date_make', '<=', $filters['date_to']);
        }

        if ($filters['enter_number']) {
            $query->where(function ($sub) use ($filters) {
                $like = '%'.$filters['enter_number'].'%';
                $sub->where('e.enter_number', 'LIKE', $like)->orWhere('e.enter_id', 'LIKE', $like);
            });
        }

        if ($filters['company_name']) {
            $query->where('c.com_name', 'LIKE', '%'.$filters['company_name'].'%');
        }

        $this->applyDetailFilterExists($query, $filters);

        return $query;
    }

    private function detailRowsQuery(array $filters, $entryIds)
    {
        $query = DB::table('beta_enter as e')
            ->leftJoin('beta_enter_detail as ed', 'ed.enter_id', '=', 'e.enter_id')
            ->leftJoin('beta_company_group as c', 'c.com_id', '=', 'e.com_id')
            ->leftJoin('beta_main_road as m', 'm.main_road_id', '=', 'e.main_road_id')
            ->leftJoin('beta_t_type as t', 't.t_type_id', '=', 'ed.t_model')
            ->whereIn('e.enter_id', $entryIds)
            ->select([
                'e.enter_id as id',
                'e.enter_number',
                'e.date_make',
                'e.date_in',
                'e.date_out',
                'e.status',
                'e.take',
                'e.com_id',
                'e.main_road_id',
                'e.address',
                'e.district',
                'e.province',
                'e.lasttails',
                'e.feed_back_msg',
                'c.com_name',
                'c.com_phone',
                'm.main_road_name',
                'ed.enter_detail_id as detail_id',
                'ed.plate_number',
                'ed.d_name as driver_name',
                'ed.p_import as product',
                'ed.weight',
                'ed.rounds',
                'ed.detail as reference',
                'ed.t_model as vehicle_type_id',
                't.t_type_name as type_name',
            ])
            ->orderByDesc('e.date_make')
            ->orderByDesc('e.enter_id');

        $this->applyDetailFilters($query, $filters, 'ed');

        return $query;
    }

    private function filesByEnterId($entryIds)
    {
        if ($entryIds->isEmpty()) {
            return collect();
        }

        $viewedFileIds = collect();
        if (Schema::hasTable('old_user_task_file_views')) {
            $viewedFileIds = DB::table('old_user_task_file_views')
                ->whereIn('enter_id', $entryIds)
                ->pluck('file_id')
                ->unique()
                ->values();
        }

        return DB::table('beta_enter_file')
            ->whereIn('enter_id', $entryIds)
            ->select(['file_id', 'enter_id', 'file_url', 'date'])
            ->orderBy('file_id')
            ->get()
            ->groupBy('enter_id')
            ->map(function ($files) use ($viewedFileIds) {
                return $files->map(function ($file) use ($viewedFileIds) {
                    $path = (string) $file->file_url;
                    $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

                    return [
                        'file_id' => $file->file_id,
                        'enter_id' => $file->enter_id,
                        'file_url' => $path,
                        'name' => basename($path),
                        'url' => asset($path),
                        'date' => $file->date,
                        'extension' => $extension,
                        'kind' => in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'], true) ? 'image' : ($extension === 'pdf' ? 'pdf' : 'file'),
                        'viewed' => $viewedFileIds->contains($file->file_id),
                    ];
                })->values();
            });
    }

    private function roadsByEnterId($entryIds)
    {
        if ($entryIds->isEmpty()) {
            return collect();
        }

        return DB::table('beta_enter_road_detail as erd')
            ->leftJoin('beta_road_select as brs', 'brs.road_id', '=', 'erd.road_id')
            ->whereIn('erd.enter_id', $entryIds)
            ->select(['erd.enter_id', 'erd.road_id', 'brs.road_name'])
            ->orderBy('erd.road_id')
            ->get()
            ->groupBy('enter_id');
    }

    private function detailCount(array $filters, $baseQuery): int
    {
        $query = DB::table('beta_enter_detail as ed')
            ->whereIn('ed.enter_id', (clone $baseQuery)->select('e.enter_id'));

        $this->applyDetailFilters($query, $filters, 'ed');

        return $query->count('ed.enter_detail_id');
    }

    private function applyDetailFilterExists($query, array $filters): void
    {
        if (!($filters['plate_number'] || $filters['driver_name'] || $filters['product'])) {
            return;
        }

        $query->whereExists(function ($detailQuery) use ($filters) {
            $detailQuery->select(DB::raw(1))
                ->from('beta_enter_detail as ed_filter')
                ->whereColumn('ed_filter.enter_id', 'e.enter_id');

            $this->applyDetailFilters($detailQuery, $filters, 'ed_filter');
        });
    }

    private function applyDetailFilters($query, array $filters, string $alias): void
    {
        if ($filters['plate_number']) {
            $query->where($alias.'.plate_number', 'LIKE', '%'.$filters['plate_number'].'%');
        }

        if ($filters['driver_name']) {
            $query->where($alias.'.d_name', 'LIKE', '%'.$filters['driver_name'].'%');
        }

        if ($filters['product']) {
            $query->where($alias.'.p_import', 'LIKE', '%'.$filters['product'].'%');
        }
    }

    private function filters(Request $request): array
    {
        $today = $this->now()->format('Y-m-d');

        return [
            'date_from' => $request->input('date_from', $today),
            'date_to' => $request->input('date_to', $today),
            'enter_number' => trim((string) $request->input('enter_number', '')),
            'company_name' => trim((string) $request->input('company_name', '')),
            'plate_number' => trim((string) $request->input('plate_number', '')),
            'driver_name' => trim((string) $request->input('driver_name', '')),
            'product' => trim((string) $request->input('product', '')),
            'status' => trim((string) $request->input('status', '')),
        ];
    }

    private function visibleStatuses(): array
    {
        switch ($this->userRole()) {
            case '2':
                return ['WAITING', 'POINTING', 'READY', 'SUCCESS'];
            case '3':
                return ['POINTING', 'SIGNING', 'SIGNINED', 'READY'];
            case '4':
                return ['SIGNING', 'SIGNINED', 'READY', 'SUCCESS'];
            case '5':
                return ['WAITING', 'POINTING', 'SIGNING', 'SIGNINED', 'READY', 'SUCCESS'];
            default:
                return [];
        }
    }

    private function defaultStatuses(): array
    {
        return array_values(array_filter($this->visibleStatuses(), function ($status) {
            return $status !== 'SUCCESS';
        }));
    }

    private function workflowAction(string $action, string $status): ?array
    {
        $actions = [
            '2' => [
                'send_pointing' => ['from' => 'WAITING', 'to' => 'POINTING', 'message' => 'ສົ່ງເອກະສານໄປລະບຸປາຍທາງ', 'delete_roads' => false],
                'back_waiting' => ['from' => 'POINTING', 'to' => 'WAITING', 'message' => 'ດຶງຄືນເອກະສານຈາກການລະບຸເສັ້ນທາງ', 'delete_roads' => true],
                'send_success' => ['from' => 'READY', 'to' => 'SUCCESS', 'message' => 'ສົ່ງເອກະສານໃຫ້ບໍລິສັດສຳເລັດ', 'delete_roads' => false],
            ],
            '3' => [
                'send_ready' => ['from' => 'SIGNINED', 'to' => 'READY', 'message' => 'ເຊັນແລ້ວ ສົ່ງໃຫ້ຂາເຂົ້າຂາອອກ', 'delete_roads' => false],
                'back_pointing' => ['from' => 'SIGNING', 'to' => 'POINTING', 'message' => 'ດຶງຄືນເອກະສານຈາກການຢືນເຊັນ', 'delete_roads' => false],
            ],
            '4' => [
                'send_signed' => ['from' => 'SIGNING', 'to' => 'SIGNINED', 'message' => 'ເຊັນແລ້ວ', 'delete_roads' => false],
                'back_signing' => ['from' => 'SIGNINED', 'to' => 'SIGNING', 'message' => 'ຍົກເລີກເຊັນ', 'delete_roads' => false],
                'back_signed' => ['from' => 'READY', 'to' => 'SIGNINED', 'message' => 'ດຶງຄືນໄປສະຖານະເຊັນແລ້ວ', 'delete_roads' => false],
                'send_success' => ['from' => 'READY', 'to' => 'SUCCESS', 'message' => 'ສົ່ງເອກະສານໃຫ້ບໍລິສັດສຳເລັດ', 'delete_roads' => false],
                'back_ready' => ['from' => 'SUCCESS', 'to' => 'READY', 'message' => 'ດຶງກັບເອກະສານຈາກບໍລິສັດ', 'delete_roads' => false],
            ],
            '5' => [
                'send_pointing' => ['from' => 'WAITING', 'to' => 'POINTING', 'message' => 'ສົ່ງເອກະສານໄປລະບຸປາຍທາງ', 'delete_roads' => false],
                'back_waiting' => ['from' => 'POINTING', 'to' => 'WAITING', 'message' => 'ດຶງຄືນເອກະສານຈາກການລະບຸເສັ້ນທາງ', 'delete_roads' => true],
                'back_pointing' => ['from' => 'SIGNING', 'to' => 'POINTING', 'message' => 'ດຶງຄືນເອກະສານຈາກການຢືນເຊັນ', 'delete_roads' => false],
                'send_signed' => ['from' => 'SIGNING', 'to' => 'SIGNINED', 'message' => 'ເຊັນແລ້ວ', 'delete_roads' => false],
                'back_signing' => ['from' => 'SIGNINED', 'to' => 'SIGNING', 'message' => 'ຍົກເລີກເຊັນ', 'delete_roads' => false],
                'send_ready' => ['from' => 'SIGNINED', 'to' => 'READY', 'message' => 'ເຊັນແລ້ວ ສົ່ງໃຫ້ຂາເຂົ້າຂາອອກ', 'delete_roads' => false],
                'back_signed' => ['from' => 'READY', 'to' => 'SIGNINED', 'message' => 'ດຶງຄືນໄປສະຖານະເຊັນແລ້ວ', 'delete_roads' => false],
                'send_success' => ['from' => 'READY', 'to' => 'SUCCESS', 'message' => 'ສົ່ງເອກະສານໃຫ້ບໍລິສັດສຳເລັດ', 'delete_roads' => false],
                'back_ready' => ['from' => 'SUCCESS', 'to' => 'READY', 'message' => 'ດຶງກັບເອກະສານຈາກບໍລິສັດ', 'delete_roads' => false],
            ],
        ];

        $workflowAction = $actions[$this->userRole()][$action] ?? null;

        return $workflowAction && $workflowAction['from'] === $status ? $workflowAction : null;
    }

    private function actionUpdate($entry, array $action): array
    {
        $update = ['status' => $action['to']];

        if ($action['to'] === 'POINTING' && (!$entry->enter_number || $entry->enter_number === '0')) {
            $update['enter_number'] = $this->nextEnterNumber();
        }

        if ($action['to'] === 'WAITING' && !$entry->date_sign) {
            $update['enter_number'] = '0';
        }

        if ($action['to'] === 'SIGNINED') {
            $signUrl = $this->currentSignMode() === 'manual'
                ? $this->manualSignUrl()
                : DB::table('beta_sign')->where('user_id', $this->currentUserId())->value('sign_url');
            $now = $this->nowString();
            $update['sign_url'] = $signUrl;
            $update['boss_id'] = $this->signingBossId();
            $update['date_sign'] = $now;
            $update['date_confirm'] = $now;
            $update['mark'] = '0';
        }

        if ($action['to'] === 'SIGNING' && !$entry->date_sign) {
            $update['sign_url'] = '';
            $update['date_sign'] = null;
            $update['date_confirm'] = null;
            $update['mark'] = '0';
        }

        if ($action['to'] === 'SUCCESS') {
            $update['take'] = '1';
        }

        if ($action['to'] !== 'SUCCESS' && (string) $entry->take === '1') {
            $update['take'] = '0';
        }

        return $update;
    }

    private function nextEnterNumber(): string
    {
        $latestNumber = DB::table('beta_enter')
            ->whereYear('date_make', date('Y'))
            ->where('enter_number', '<>', '0')
            ->orderByDesc('enter_number')
            ->value('enter_number');

        return str_pad(((int) $latestNumber) + 1, 5, '0', STR_PAD_LEFT);
    }

    private function recordFeedback(int $enterId, string $message): void
    {
        if (!DB::getSchemaBuilder()->hasTable('beta_feed_back')) {
            return;
        }

        DB::table('beta_feed_back')->insert([
            'user_id' => $this->currentUserId(),
            'date' => $this->now()->format('Y-m-d'),
            'time' => $this->now()->format('H:i:s'),
            'feed_back_msg' => $message,
            'ref_id' => $enterId,
            'pointer' => 'OldUserTaskV2',
        ]);
    }

    private function currentUserId(): int
    {
        return (int) session('old_user_task_v2_user_id');
    }

    private function signingBossId(): int
    {
        $user = DB::table('users')->where('id', $this->currentUserId())->first(['id', 'itn']);

        return $user && (string) $user->itn === '1' ? (int) $user->id : 0;
    }

    private function currentSignMode(): string
    {
        return session('old_user_task_v2_sign_mode', 'system') === 'manual' ? 'manual' : 'system';
    }

    private function manualSignUrl(): ?string
    {
        return $this->currentUserId() === 13 ? '/sign/13/default_sign.png' : null;
    }

    private function userRole(): string
    {
        return (string) session('old_user_task_v2_is_admin', '');
    }

    private function nextSessionBoundary()
    {
        $now = $this->now();
        $noon = $now->setTime(12, 0, 0);

        return $now < $noon ? $noon : $now->modify('+1 day')->setTime(0, 0, 0);
    }

    private function now()
    {
        return new DateTimeImmutable('now', $this->timeZone());
    }

    private function nowString(): string
    {
        return $this->now()->format('Y-m-d H:i:s');
    }

    private function dateTime($value)
    {
        return new DateTimeImmutable($value, $this->timeZone());
    }

    private function timeZone()
    {
        return new DateTimeZone('Asia/Bangkok');
    }

    private function formatDateTime($value): ?string
    {
        if (!$value) {
            return null;
        }

        $timestamp = strtotime((string) $value);

        return $timestamp === false ? null : date('Y-m-d H:i', $timestamp);
    }

    private function formatYear($value): string
    {
        $timestamp = strtotime((string) $value);

        return $timestamp === false ? date('Y') : date('Y', $timestamp);
    }
}
