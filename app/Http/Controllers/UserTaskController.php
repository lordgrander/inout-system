<?php

namespace App\Http\Controllers;

use App\Models\User;
use DateTimeImmutable;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTaskController extends Controller
{
    public function login()
    {
        if (session('user_task_user_id') && session('user_task_auth_until')) {
            $expiresAt = $this->dateTime(session('user_task_auth_until'));

            if ($this->now() < $expiresAt) {
                return redirect()->route('user-task.dashboard');
            }
        }

        return view('user-task.login');
    }

    public function loginStore(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || (string) $user->is_admin === '1' || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Email or password is incorrect, or this user is not allowed for this dashboard.',
            ])->withInput($request->only('email'));
        }

        $expiresAt = $this->nextSessionBoundary();

        $request->session()->put([
            'user_task_user_id' => $user->id,
            'user_task_user_name' => $user->name ?: $user->email,
            'user_task_is_admin' => (string) $user->is_admin,
            'user_task_auth_until' => $expiresAt->format('Y-m-d H:i:s'),
        ]);

        return redirect()->route('user-task.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['user_task_user_id', 'user_task_user_name', 'user_task_is_admin', 'user_task_auth_until']);

        return redirect()->route('user-task.login');
    }

    public function dashboard()
    {
        return view('user-task.dashboard', [
            'userName' => session('user_task_user_name'),
            'authUntil' => session('user_task_auth_until'),
            'userRole' => $this->userRole(),
            'statusOptions' => $this->visibleStatuses(),
            'mainRoads' => DB::table('beta_main_road')->orderBy('main_road_id')->get(['main_road_id', 'main_road_name']),
            'roadOptions' => DB::table('beta_road_select')->orderBy('road_id')->get(['road_id', 'road_name']),
            'roadIds' => [],
            'roadLabel' => 'ທັງໝົດ',
        ]);
    }

    public function data(Request $request)
    {
        $filters = $this->filters($request);
        $base = $this->baseEntryQuery($filters);
        $page = max(1, (int) $request->input('page', 1));
        $perPage = 20;
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
            : $this->detailRowsQuery($filters, $entryIds)->get();

        $visibleEntryIds = $flatRows->pluck('enter_id')->unique()->values();
        $filesByEnterId = $visibleEntryIds->isEmpty()
            ? collect()
            : DB::table('beta_enter_file')
                ->whereIn('enter_id', $visibleEntryIds)
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
                    'com_id' => $first->com_id,
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
                'detail_count' => $this->detailCount($filters, $base),
                'updated_at' => $this->now()->format('d-m-Y'),
                'road_ids' => [],
                'road_label' => 'ທັງໝົດ',
                'take_visible' => 'all',
                'target_limited' => false,
                'target_limited_dates' => [],
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
            'enter_id' => ['required', 'integer'],
            'action' => ['required', 'string'],
        ]);

        $entry = DB::table('beta_enter')
            ->where('enter_id', $validated['enter_id'])
            ->first();

        if (!$entry) {
            return response()->json(['message' => 'Document not found.'], 404);
        }

        $action = $this->workflowAction($validated['action'], (string) $entry->status);

        if (!$action) {
            return response()->json(['message' => 'This action is not allowed for your role or this status.'], 403);
        }

        DB::table('beta_enter')
            ->where('enter_id', $entry->enter_id)
            ->update($this->actionUpdate($entry, $action));

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

        $entry = DB::table('beta_enter')
            ->where('enter_id', $validated['id'])
            ->first();

        if (!$entry) {
            return response()->json(['message' => 'Document not found.'], 404);
        }

        if ((string) $entry->status !== 'POINTING') {
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

            DB::table('beta_enter')
                ->where('enter_id', $entry->enter_id)
                ->update([
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
        $validated = $request->validate([
            'id' => ['required', 'integer'],
        ]);

        $companyExists = DB::table('beta_company_group')
            ->where('com_id', $validated['id'])
            ->exists();

        if (!$companyExists) {
            return response()->json(['status' => 404, 'msg' => 'Not_found'], 404);
        }

        $subjects = DB::table('beta_com_nano')
            ->where('com_id', $validated['id'])
            ->select('id', 'subject', 'com_id')
            ->orderBy('id')
            ->get();

        return response()->json([
            'status' => 200,
            'data' => $subjects,
        ]);
    }

    private function baseEntryQuery(array $filters)
    {
        $visibleStatuses = $this->visibleStatuses();
        $defaultStatuses = $this->defaultStatuses();
        $status = $filters['status'];

        $query = DB::table('beta_enter as e')
            ->leftJoin('beta_company_group as c', 'c.com_id', '=', 'e.com_id');

        if ($status && in_array($status, $visibleStatuses, true)) {
            $query->where('e.status', $status);
        } else {
            $query->whereIn('e.status', $defaultStatuses ?: ['__none__']);
        }

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
                'e.enter_id',
                'e.enter_number',
                'e.date_make',
                'e.date_in',
                'e.date_out',
                'e.status',
                'e.com_id',
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

        $this->applyDetailFilters($query, $filters, 'ed');

        return $query;
    }

    private function detailCount(array $filters, $baseEntryQuery): int
    {
        $query = DB::table('beta_enter_detail as ed')
            ->whereIn('ed.enter_id', (clone $baseEntryQuery)->select('e.enter_id'));

        $this->applyDetailFilters($query, $filters, 'ed');

        return $query->count('ed.enter_detail_id');
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
        $role = $this->userRole();
        $actions = [
            '2' => [
                'send_pointing' => ['from' => 'WAITING', 'to' => 'POINTING', 'message' => 'ສົ່ງເອກະສານໄປລະບຸປາຍທາງ', 'delete_roads' => false],
                'back_waiting' => ['from' => 'POINTING', 'to' => 'WAITING', 'message' => 'ດືງຄືນເອກະສານກັບຈາກການລະບຸເສັ້ນທາງ', 'delete_roads' => true],
                'send_success' => ['from' => 'READY', 'to' => 'SUCCESS', 'message' => 'ສົ່ງເອກະສານໃຫ້ບໍລິສັດສຳເລັດ', 'delete_roads' => false],
                'back_ready' => ['from' => 'SUCCESS', 'to' => 'READY', 'message' => 'ດືງກັບເອກະສານຈາກບໍລິສັດ ແຕ່ເຊັນແລ້ວ', 'delete_roads' => false],
            ],
            '3' => [
                'send_ready' => ['from' => 'SIGNINED', 'to' => 'READY', 'message' => ' ເຊັນແລ້ວ ລະບຸສາຍທາງສົ່ງໃຫ້ ຂາເຂົ້າຂາອອກ', 'delete_roads' => false],
                'back_pointing' => ['from' => 'SIGNING', 'to' => 'POINTING', 'message' => 'ດືງຄືນເອກະສານກັບຈາກການຢືນເຊັນ', 'delete_roads' => false],
                'back_signed' => ['from' => 'READY', 'to' => 'SIGNINED', 'message' => 'ຕີເອກະສານກັບໄປຫາສາຍທາງ ແຕ່ເຊັນແລ້ວ', 'delete_roads' => false],
            ],
            '4' => [
                'send_signed' => ['from' => 'SIGNING', 'to' => 'SIGNINED', 'message' => 'ເຊັນແລ້ວ ເອກະສານຢູ່ນຳລະບຸສານທາງ', 'delete_roads' => false],
                'back_signing' => ['from' => 'SIGNINED', 'to' => 'SIGNING', 'message' => 'ຍົກເລີກເຊັນ', 'delete_roads' => false],
                'send_ready' => ['from' => 'SIGNINED', 'to' => 'READY', 'message' => ' ເຊັນແລ້ວ ລະບຸສາຍທາງສົ່ງໃຫ້ ຂາເຂົ້າຂາອອກ', 'delete_roads' => false],
                'back_signed' => ['from' => 'READY', 'to' => 'SIGNINED', 'message' => 'ຕີເອກະສານກັບໄປຫາສາຍທາງ ແຕ່ເຊັນແລ້ວ', 'delete_roads' => false],
                'send_success' => ['from' => 'READY', 'to' => 'SUCCESS', 'message' => 'ສົ່ງເອກະສານໃຫ້ບໍລິສັດສຳເລັດ', 'delete_roads' => false],
                'back_ready' => ['from' => 'SUCCESS', 'to' => 'READY', 'message' => 'ດືງກັບເອກະສານຈາກບໍລິສັດ ແຕ່ເຊັນແລ້ວ', 'delete_roads' => false],
            ],
            '5' => [
                'send_pointing' => ['from' => 'WAITING', 'to' => 'POINTING', 'message' => 'ສົ່ງເອກະສານໄປລະບຸປາຍທາງ', 'delete_roads' => false],
                'back_waiting' => ['from' => 'POINTING', 'to' => 'WAITING', 'message' => 'ດືງຄືນເອກະສານກັບຈາກການລະບຸເສັ້ນທາງ', 'delete_roads' => true],
                'back_pointing' => ['from' => 'SIGNING', 'to' => 'POINTING', 'message' => 'ດືງຄືນເອກະສານກັບຈາກການຢືນເຊັນ', 'delete_roads' => false],
                'send_signed' => ['from' => 'SIGNING', 'to' => 'SIGNINED', 'message' => 'ເຊັນແລ້ວ ເອກະສານຢູ່ນຳລະບຸສານທາງ', 'delete_roads' => false],
                'back_signing' => ['from' => 'SIGNINED', 'to' => 'SIGNING', 'message' => 'ຍົກເລີກເຊັນ', 'delete_roads' => false],
                'back_signed' => ['from' => 'READY', 'to' => 'SIGNINED', 'message' => 'ຕີເອກະສານກັບໄປຫາສາຍທາງ ແຕ່ເຊັນແລ້ວ', 'delete_roads' => false],
                'send_success' => ['from' => 'READY', 'to' => 'SUCCESS', 'message' => 'ສົ່ງເອກະສານໃຫ້ບໍລິສັດສຳເລັດ', 'delete_roads' => false],
                'back_ready' => ['from' => 'SUCCESS', 'to' => 'READY', 'message' => 'ດືງກັບເອກະສານຈາກບໍລິສັດ ແຕ່ເຊັນແລ້ວ', 'delete_roads' => false],
            ],
        ];

        $workflowAction = $actions[$role][$action] ?? null;

        if (!$workflowAction || $workflowAction['from'] !== $status) {
            return null;
        }

        return $workflowAction;
    }

    private function actionUpdate($entry, array $action): array
    {
        $update = [
            'status' => $action['to'],
        ];

        if ($action['to'] === 'POINTING' && !$entry->date_sign && !$entry->enter_number) {
            $update['enter_number'] = $this->nextEnterNumber();
        }

        if ($action['to'] === 'WAITING' && !$entry->date_sign) {
            $update['enter_number'] = '0';
        }

        if ($action['to'] === 'SIGNINED') {
            $signUrl = DB::table('beta_sign')->where('user_id', $this->currentUserId())->value('sign_url');
            $now = $this->now()->format('Y-m-d H:i:s');
            $update['sign_url'] = $signUrl;
            $update['boss_id'] = $this->currentUserId();
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

        return $update;
    }

    private function nextEnterNumber(): string
    {
        $latestNumber = DB::table('beta_enter')
            ->whereYear('date_make', date('Y'))
            ->orderByDesc('enter_number')
            ->value('enter_number');

        return str_pad(((int) $latestNumber) + 1, 5, '0', STR_PAD_LEFT);
    }

    private function recordFeedback(int $enterId, string $message): void
    {
        DB::table('beta_feed_back')->insert([
            'user_id' => $this->currentUserId(),
            'date' => $this->now()->format('Y-m-d'),
            'time' => $this->now()->format('H:i:s'),
            'feed_back_msg' => $message,
            'ref_id' => $enterId,
            'pointer' => 'UserTask',
        ]);
    }

    private function currentUserId(): int
    {
        return (int) session('user_task_user_id');
    }

    private function userRole(): string
    {
        return (string) session('user_task_is_admin', '');
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
}
