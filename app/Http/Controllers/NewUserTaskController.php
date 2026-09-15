<?php

namespace App\Http\Controllers;

use App\Models\User;
use DateTimeImmutable;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NewUserTaskController extends Controller
{
    public function login()
    {
        if (session('new_user_task_user_id') && session('new_user_task_auth_until')) {
            if ($this->now() < $this->dateTime(session('new_user_task_auth_until'))) {
                return redirect()->route('new-user-task-v2.dashboard');
            }
        }

        return view('new-user-task.login');
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
            'new_user_task_user_id' => $user->id,
            'new_user_task_user_name' => $user->name ?: $user->email,
            'new_user_task_is_admin' => (string) $user->is_admin,
            'new_user_task_auth_until' => $this->nextSessionBoundary()->format('Y-m-d H:i:s'),
        ]);

        return redirect()->route('new-user-task-v2.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget([
            'new_user_task_user_id',
            'new_user_task_user_name',
            'new_user_task_is_admin',
            'new_user_task_auth_until',
            'new_user_task_sign_mode',
        ]);

        return redirect()->route('new-user-task.login');
    }

    public function signMode(Request $request)
    {
        $validated = $request->validate([
            'mode' => ['required', 'string', 'in:manual,system'],
        ]);

        if (!in_array($this->userRole(), ['4', '5'], true)) {
            return response()->json(['message' => 'This action is not allowed for your role.'], 403);
        }

        $request->session()->put('new_user_task_sign_mode', $validated['mode']);

        return response()->json([
            'message' => 'ok',
            'mode' => $validated['mode'],
        ]);
    }

    public function dashboard()
    {
        return view('new-user-task.dashboard', [
            'userName' => session('new_user_task_user_name'),
            'authUntil' => session('new_user_task_auth_until'),
            'userRole' => $this->userRole(),
            'statusOptions' => $this->visibleStatuses(),
            'mainRoads' => DB::table('beta_main_road')->orderBy('main_road_id')->get(['main_road_id', 'main_road_name']),
            'roadOptions' => DB::table('beta_road_select')->orderBy('road_id')->get(['road_id', 'road_name']),
        ]);
    }

    public function data(Request $request)
    {
        $filters = $this->filters($request);
        $base = $this->baseQuery($filters);
        $page = max(1, (int) $request->input('page', 1));
        $perPage = 40;
        $totalEntries = (clone $base)->count('ne.id');
        $lastPage = max(1, (int) ceil($totalEntries / $perPage));
        $page = min($page, $lastPage);
        $entryIds = (clone $base)
            ->select('ne.id')
            ->orderByDesc('ne.date_make')
            ->orderByDesc('ne.id')
            ->forPage($page, $perPage)
            ->pluck('ne.id');

        $flatRows = $entryIds->isEmpty()
            ? collect()
            : $this->detailRowsQuery($filters, $entryIds)->get();

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
                    : 'NE-'.$this->formatYear($first->created_at).'-'.str_pad((string) $first->id, 6, '0', STR_PAD_LEFT),
                'date_make' => $this->formatDateTime($first->date_make ?: $first->created_at),
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
                        'product' => $row->import_product,
                        'weight' => $row->weight_kg,
                        'rounds' => $row->rounds,
                        'reference' => $row->import_document_no,
                        'type_name' => $row->t_type_name ?: $row->vehicle_type_id,
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

        $entry = DB::table('new_enters')->where('id', $validated['id'])->first();
        if (!$entry) {
            return response()->json(['message' => 'Document not found.'], 404);
        }

        $action = $this->workflowAction($validated['action'], (string) $entry->status);
        if (!$action) {
            return response()->json(['message' => 'This action is not allowed for your role or this status.'], 403);
        }

        DB::table('new_enters')->where('id', $entry->id)->update($this->actionUpdate($entry, $action));

        if ($action['delete_roads']) {
            DB::table('new_enter_road_details')->where('new_enter_id', $entry->id)->delete();
        }

        $this->recordFeedback((int) $entry->id, $action['message']);

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

        $entry = DB::table('new_enters')->where('id', $validated['id'])->first();
        if (!$entry || (string) $entry->status !== 'POINTING') {
            return response()->json(['message' => 'This document is not in POINTING status.'], 403);
        }

        $roadIds = array_values(array_unique(array_map('intval', $validated['formdata'])));
        $details = trim((string) ($validated['details'] ?? ''));
        $now = $this->nowString();

        DB::transaction(function () use ($entry, $validated, $roadIds, $details, $now) {
            DB::table('new_enter_road_details')->where('new_enter_id', $entry->id)->delete();

            foreach ($roadIds as $roadId) {
                DB::table('new_enter_road_details')->insert([
                    'new_enter_id' => $entry->id,
                    'road_id' => $roadId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            DB::table('new_enters')->where('id', $entry->id)->update([
                'status' => 'SIGNING',
                'feed_back_msg' => $details,
                'main_road_id' => $validated['main_road'],
                'updated_at' => $now,
            ]);

            $this->recordFeedback((int) $entry->id, ' ລະບຸເສັນທາງສຳເລັດ ກຳລັງລໍຖ້າເຊັນ ');
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

    private function baseQuery(array $filters)
    {
        $visibleStatuses = $this->visibleStatuses();
        $status = $filters['status'];
        $query = DB::table('new_enters as ne')
            ->leftJoin('beta_company_group as c', 'c.com_id', '=', 'ne.com_id');

        if ($status && in_array($status, $visibleStatuses, true)) {
            $query->where('ne.status', $status);
        } else {
            $query->whereIn('ne.status', $this->defaultStatuses() ?: ['__none__']);
        }

        if ($filters['date_from']) {
            $query->whereDate('ne.date_make', '>=', $filters['date_from']);
        }

        if ($filters['date_to']) {
            $query->whereDate('ne.date_make', '<=', $filters['date_to']);
        }

        if ($filters['enter_number']) {
            $query->where(function ($sub) use ($filters) {
                $like = '%'.$filters['enter_number'].'%';
                $sub->where('ne.enter_number', 'LIKE', $like)->orWhere('ne.id', 'LIKE', $like);
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
        $query = DB::table('new_enters as ne')
            ->leftJoin('new_enter_details as ned', 'ned.new_enter_id', '=', 'ne.id')
            ->leftJoin('beta_company_group as c', 'c.com_id', '=', 'ne.com_id')
            ->leftJoin('beta_main_road as m', 'm.main_road_id', '=', 'ne.main_road_id')
            ->leftJoin('beta_t_type as t', 't.t_type_id', '=', 'ned.vehicle_type_id')
            ->whereIn('ne.id', $entryIds)
            ->select([
                'ne.id',
                'ne.enter_number',
                'ne.date_make',
                'ne.date_in',
                'ne.date_out',
                'ne.status',
                'ne.take',
                'ne.com_id',
                'ne.main_road_id',
                'ne.address',
                'ne.district',
                'ne.province',
                'ne.lasttails',
                'ne.feed_back_msg',
                'ne.created_at',
                'c.com_name',
                'c.com_phone',
                'm.main_road_name',
                'ned.id as detail_id',
                'ned.plate_number',
                'ned.driver_name',
                'ned.import_product',
                'ned.weight_kg',
                'ned.rounds',
                'ned.import_document_no',
                'ned.vehicle_type_id',
                't.t_type_name',
            ])
            ->orderByDesc('ne.date_make')
            ->orderByDesc('ne.id');

        $this->applyDetailFilters($query, $filters, 'ned');

        return $query;
    }

    private function filesByEnterId($entryIds)
    {
        if ($entryIds->isEmpty()) {
            return collect();
        }

        return DB::table('new_enter_files')
            ->whereIn('new_enter_id', $entryIds)
            ->select(['id', 'new_enter_id', 'file_url', 'original_name', 'mime_type', 'date'])
            ->orderBy('id')
            ->get()
            ->groupBy('new_enter_id')
            ->map(function ($files) {
                return $files->map(function ($file) {
                    $path = (string) $file->file_url;
                    $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

                    return [
                        'file_id' => $file->id,
                        'file_url' => $path,
                        'name' => $file->original_name ?: basename($path),
                        'url' => asset($path),
                        'date' => $file->date,
                        'extension' => $extension,
                        'kind' => in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'], true) ? 'image' : ($extension === 'pdf' ? 'pdf' : 'file'),
                    ];
                })->values();
            });
    }

    private function roadsByEnterId($entryIds)
    {
        if ($entryIds->isEmpty() || !DB::getSchemaBuilder()->hasTable('new_enter_road_details')) {
            return collect();
        }

        return DB::table('new_enter_road_details as nerd')
            ->leftJoin('beta_road_select as brs', 'brs.road_id', '=', 'nerd.road_id')
            ->whereIn('nerd.new_enter_id', $entryIds)
            ->select(['nerd.new_enter_id', 'nerd.road_id', 'brs.road_name'])
            ->orderBy('nerd.id')
            ->get()
            ->groupBy('new_enter_id');
    }

    private function detailCount(array $filters, $baseQuery): int
    {
        $query = DB::table('new_enter_details as ned')
            ->whereIn('ned.new_enter_id', (clone $baseQuery)->select('ne.id'));

        $this->applyDetailFilters($query, $filters, 'ned');

        return $query->count('ned.id');
    }

    private function applyDetailFilterExists($query, array $filters): void
    {
        if (!($filters['plate_number'] || $filters['driver_name'] || $filters['product'])) {
            return;
        }

        $query->whereExists(function ($detailQuery) use ($filters) {
            $detailQuery->select(DB::raw(1))
                ->from('new_enter_details as ned_filter')
                ->whereColumn('ned_filter.new_enter_id', 'ne.id');

            $this->applyDetailFilters($detailQuery, $filters, 'ned_filter');
        });
    }

    private function applyDetailFilters($query, array $filters, string $alias): void
    {
        if ($filters['plate_number']) {
            $query->where($alias.'.plate_number', 'LIKE', '%'.$filters['plate_number'].'%');
        }

        if ($filters['driver_name']) {
            $query->where($alias.'.driver_name', 'LIKE', '%'.$filters['driver_name'].'%');
        }

        if ($filters['product']) {
            $query->where($alias.'.import_product', 'LIKE', '%'.$filters['product'].'%');
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

        if (!$workflowAction || $workflowAction['from'] !== $status) {
            return null;
        }

        return $workflowAction;
    }

    private function actionUpdate($entry, array $action): array
    {
        $update = [
            'status' => $action['to'],
            'updated_at' => $this->nowString(),
        ];

        if ($action['to'] === 'POINTING' && (!$entry->enter_number || $entry->enter_number === '0')) {
            $update['enter_number'] = $this->nextEnterNumber();
        }

        if ($action['to'] === 'WAITING') {
            $update['enter_number'] = '0';
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
        $latestNumber = DB::table('new_enters')
            ->where('enter_number', '<>', '0')
            ->whereDate('date_make', '>=', $this->now()->format('Y-01-01'))
            ->orderByDesc('enter_number')
            ->value('enter_number');

        return str_pad(((int) $latestNumber) + 1, 6, '0', STR_PAD_LEFT);
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
            'pointer' => 'NewUserTask',
        ]);
    }

    private function currentUserId(): int
    {
        return (int) session('new_user_task_user_id');
    }

    private function userRole(): string
    {
        return (string) session('new_user_task_is_admin', '');
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
