<?php

namespace App\Http\Controllers;

use App\Models\beta_company_group;
use App\Models\beta_watching_list;
use App\Models\NewEnter;
use App\Models\NewEnterDetail;
use App\Models\NewEnterFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NewEnterController extends Controller
{
    public function login()
    {
        if (session('new_enter_user_id')) {
            return redirect()->route('new-enter.index');
        }

        return view('new-enter.login');
    }

    public function loginStore(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || (string) $user->is_admin !== '1' || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Email or password is incorrect, or this user is not allowed for New Enter.',
            ])->withInput($request->only('email'));
        }

        $request->session()->put([
            'new_enter_user_id' => $user->id,
            'new_enter_user_name' => $user->name,
            'new_enter_com_id' => $user->com_id,
        ]);

        return redirect()->route('new-enter.index');
    }

    public function logout(Request $request)
    {
        $request->session()->forget([
            'new_enter_user_id',
            'new_enter_user_name',
            'new_enter_com_id',
        ]);

        return redirect()->route('new-enter.login');
    }

    public function index()
    {
        $user = $this->currentUser();
        abort_unless($user, 403);

        $company = $this->companyFor($user);
        $vehicleTypes = $this->vehicleTypes();

        return view('new-enter.index', compact('company', 'user', 'vehicleTypes'));
    }

    public function documents()
    {
        $user = $this->currentUser();
        abort_unless($user, 403);

        $company = $this->companyFor($user);
        $documents = collect();

        return view('new-enter.documents', compact('company', 'user', 'documents'));
    }

    public function documentsData(Request $request)
    {
        $user = $this->currentUser();
        abort_unless($user, 403);

        $activeStatuses = ['WAITING', 'QWAIT', 'POINTING', 'SIGNING', 'QSIGNING', 'SIGNINED', 'READY'];
        $page = max(1, (int) $request->input('page', 1));
        $scope = $request->input('scope', 'all');
        $filter = $request->input('filter', 'ALL');
        $search = trim((string) $request->input('q', ''));

        $query = NewEnter::query()
            ->select([
                'id',
                'user_id',
                'com_id',
                'enter_number',
                'sign_status',
                'take',
                'date_make',
                'date_in',
                'date_out',
                'status',
                'price',
                'lasttails',
                'slug',
                'address',
                'district',
                'province',
                'main_road_id',
                'cancel_log',
                'created_at',
                'updated_at',
            ])
            ->with(['details', 'files'])
            ->where('user_id', $user->id)
            ->where('com_id', $user->com_id);

        if ($scope === 'today') {
            $query->whereDate('created_at', $this->todayString());
        }

        if ($filter === 'ACTIVE') {
            $query->whereIn('status', $activeStatuses);
        } elseif (in_array($filter, ['DRAFT', 'SUCCESS', 'CANCEL'], true)) {
            $query->where('status', $filter);
        }

        if ($search !== '') {
            $query->where(function ($subQuery) use ($search) {
                $like = '%'.$search.'%';
                $subQuery->where('enter_number', 'like', $like)
                    ->orWhere('status', 'like', $like)
                    ->orWhere('address', 'like', $like)
                    ->orWhere('district', 'like', $like)
                    ->orWhere('province', 'like', $like)
                    ->orWhere('lasttails', 'like', $like)
                    ->orWhere('cancel_log', 'like', $like)
                    ->orWhereHas('details', function ($details) use ($like) {
                        $details->where('plate_number', 'like', $like)
                            ->orWhere('driver_name', 'like', $like)
                            ->orWhere('import_product', 'like', $like)
                            ->orWhere('import_document_no', 'like', $like);
                    })
                    ->orWhereHas('files', function ($files) use ($like) {
                        $files->where('original_name', 'like', $like);
                    });
            });
        }

        $paginator = $query->orderByDesc('created_at')->paginate(40, ['*'], 'page', $page);

        return response()->json([
            'data' => $paginator->getCollection()
                ->map(function (NewEnter $enter) {
                    return $this->documentPayload($enter);
                })
                ->values(),
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        return $this->saveApplication($request, 'WAITING');
    }

    public function draft(Request $request)
    {
        return $this->saveApplication($request, 'DRAFT');
    }

    public function send(Request $request)
    {
        $user = $this->currentUser();
        abort_unless($user && (string) $user->is_admin === '1', 403);

        $enter = $this->ownedEnter($request);

        if ($enter->status !== 'DRAFT') {
            return response()->json([
                'status' => 'error',
                'message' => 'Only draft documents can be sent.',
            ], 422);
        }

        $now = $this->nowString();

        DB::table('new_enters')->where('id', $enter->id)->update([
            'status' => 'WAITING',
            'date_make' => $now,
            'date_in' => $now,
            'updated_at' => $now,
        ]);

        $this->sendNewEnterDiscordNotification(
            $enter->fresh(['details', 'files']),
            $user
        );

        return response()->json([
            'status' => 'ok',
            'message' => 'Document sent.',
        ]);
    }

    public function cancel(Request $request)
    {
        $enter = $this->ownedEnter($request);

        if (!in_array($enter->status, ['WAITING', 'QWAIT'], true)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Only waiting documents can be cancelled.',
            ], 422);
        }

        DB::table('new_enters')->where('id', $enter->id)->update([
            'status' => 'CANCEL',
            'cancel_log' => 'ຜູ້ໃຊ້ຍົກເລີກ',
            'updated_at' => $this->nowString(),
        ]);

        return response()->json([
            'status' => 'ok',
            'message' => 'Document cancelled.',
        ]);
    }

    public function delete(Request $request)
    {
        $enter = $this->ownedEnter($request);

        if (!in_array($enter->status, ['DRAFT', 'CANCEL'], true)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Only draft or cancelled documents can be deleted.',
            ], 422);
        }

        foreach ($enter->files as $file) {
            $path = public_path($file->file_url);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $enter->files()->delete();
        $enter->details()->delete();
        $enter->delete();

        return response()->json([
            'status' => 'ok',
            'message' => 'Document deleted.',
        ]);
    }

    private function saveApplication(Request $request, string $status)
    {
        $user = $this->currentUser();
        abort_unless($user && (string) $user->is_admin === '1', 403);

        $validated = $request->validate([
            'index' => ['required', 'integer', 'min:1', 'max:5'],
            'address' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'lasttails' => ['nullable', 'string'],
            'upload_files.*' => ['nullable', 'file', 'max:15360', 'mimes:pdf,jpg,jpeg,png'],
        ]);

        $details = $this->validatedDetails($request, (int) $validated['index']);

        if (count($details) < 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'At least one vehicle row is required.',
            ], 422);
        }

        $now = $this->nowString();
        $slug = $this->uniqueSlug();

        $newEnter = null;
        DB::transaction(function () use ($request, $user, $status, $details, $now, $slug, &$newEnter) {
            $newEnter = NewEnter::create([
                'user_id' => $user->id,
                'com_id' => $user->com_id,
                'enter_number' => '0',
                'sign_status' => '0',
                'take' => '0',
                'date_make' => $now,
                'date_in' => $now,
                'date_out' => $this->dateTimeAfterDays(2),
                'status' => $status,
                'price' => 0,
                'lasttails' => $request->input('lasttails'),
                'slug' => $slug,
                'address' => $this->cleanPlace($request->input('address')),
                'district' => $this->cleanPlace($request->input('district')),
                'province' => $this->cleanPlace($request->input('province')),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            foreach ($details as $detail) {
                NewEnterDetail::create([
                    'new_enter_id' => $newEnter->id,
                    'user_id' => $user->id,
                    'plate_number' => $detail['plate_number'],
                    'driver_name' => $detail['driver_name'],
                    'vehicle_type_id' => $detail['vehicle_type_id'],
                    'rounds' => $detail['rounds'],
                    'import_product' => $detail['import_product'],
                    'import_document_no' => $detail['import_document_no'],
                    'weight_kg' => $detail['weight_kg'],
                    'watchlist_status' => $this->watchlistStatus($detail['plate_number']),
                    'status' => '0',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        });

        $this->storeFiles($request, $newEnter, $user);

        if ($status === 'WAITING') {
            $this->sendNewEnterDiscordNotification(
                $newEnter->fresh(['details', 'files']),
                $user
            );
        }

        return response()->json([
            'status' => 'ok',
            'message' => $status === 'DRAFT' ? 'Draft saved.' : 'Form submitted.',
            'new_enter_id' => $newEnter->id,
        ]);
    }

    private function validatedDetails(Request $request, int $index): array
    {
        $details = [];

        for ($i = 1; $i <= $index; $i++) {
            $plate = trim((string) $request->input('input_plate_'.$i));

            if ($plate === '' || $plate === 'this_delete') {
                continue;
            }

            $driverName = trim((string) $request->input('input_driver_name_'.$i));
            $vehicleTypeId = (int) $request->input('input_vehicle_type_id_'.$i);
            $importProduct = trim((string) $request->input('input_import_product_'.$i));
            $importDocumentNo = trim((string) $request->input('input_import_document_no_'.$i));
            $weightKg = $this->numberValue($request->input('input_weight_kg_'.$i));
            $rounds = max(1, min(5, (int) $request->input('input_rounds_'.$i, 1)));

            if (!$driverName || !$vehicleTypeId || !$importProduct || !$importDocumentNo || $weightKg <= 0) {
                abort(response()->json([
                    'status' => 'error',
                    'message' => 'Vehicle row '.$i.' is missing required data.',
                ], 422));
            }

            $details[] = [
                'plate_number' => $plate,
                'driver_name' => $driverName,
                'vehicle_type_id' => $vehicleTypeId,
                'rounds' => $rounds,
                'import_product' => $importProduct,
                'import_document_no' => $importDocumentNo,
                'weight_kg' => $weightKg,
            ];
        }

        return $details;
    }

    private function storeFiles(Request $request, NewEnter $newEnter, User $user): void
    {
        if (!$request->hasFile('upload_files')) {
            return;
        }

        $path = 'new-enter-files/c'.$user->com_id.'/ne'.$newEnter->id;
        $fullPath = public_path($path);

        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }

        foreach ($request->file('upload_files') as $file) {
            if (!$file || !File::isReadable($file)) {
                continue;
            }

            $storedPath = $file->store($path, ['disk' => 'my_files']);

            $now = $this->nowString();

            NewEnterFile::create([
                'new_enter_id' => $newEnter->id,
                'user_id' => $user->id,
                'date' => $this->todayString(),
                'file_url' => $storedPath,
                'original_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function sendNewEnterDiscordNotification(?NewEnter $enter, User $user): void
    {
        $webhookUrl = config('services.discord.new_enter_webhook_url');

        if (!$webhookUrl || !$enter) {
            return;
        }

        $company = $this->companyFor($user);
        $createdAt = $this->formatDateTime($enter->getRawOriginal('created_at')) ?: date('d/m/y');
        $destination = trim(collect([$enter->address, $enter->district, $enter->province])->filter()->implode(', '));
        $number = $enter->enter_number && $enter->enter_number !== '0'
            ? $enter->enter_number
            : 'NE-'.$this->formatYear($enter->getRawOriginal('created_at')).'-'.str_pad((string) $enter->id, 6, '0', STR_PAD_LEFT);

        $vehicleLines = $enter->details
            ->take(5)
            ->map(function (NewEnterDetail $detail, int $index) {
                return ($index + 1).'. '.$detail->plate_number.' | '.$detail->driver_name.' | '.$detail->import_product.' | '.$this->formatWeight($detail->weight_kg);
            })
            ->implode("\n");

        if ($enter->details->count() > 5) {
            $vehicleLines .= "\n... +".($enter->details->count() - 5).' more';
        }

        try {
            Http::timeout(5)->post($webhookUrl, [
                'username' => 'Sompong bot',
                'content' => 'ມີໃບອະນຸຍາດໃໝ່ຖືກສົ່ງເຂົ້າລະບົບ',
                'embeds' => [[
                    'title' => $number,
                    'color' => 0x0f4c81,
                    'fields' => [
                        ['name' => 'ບໍລິສັດ', 'value' => $company->com_name ?? 'No company', 'inline' => true],
                        ['name' => 'ຜູ້ສົ່ງ', 'value' => $user->name ?? '-', 'inline' => true],
                        ['name' => 'ສະຖານະ', 'value' => $enter->status ?? '-', 'inline' => true],
                        ['name' => 'ວັນທີ', 'value' => $createdAt, 'inline' => true],
                        ['name' => 'ຈຳນວນລົດ', 'value' => (string) $enter->details->count(), 'inline' => true],
                        ['name' => 'ໄຟລ໌ແນບ', 'value' => (string) $enter->files->count(), 'inline' => true],
                        ['name' => 'ປາຍທາງ', 'value' => $destination ?: '-', 'inline' => false],
                        ['name' => 'ລາຍການລົດ', 'value' => $vehicleLines ?: '-', 'inline' => false],
                    ],
                ]],
            ]);
        } catch (\Throwable $exception) {
            Log::warning('Discord new enter notification failed', [
                'new_enter_id' => $enter->id,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    private function formatWeight($value): string
    {
        if ($value === null || $value === '') {
            return '-';
        }

        return number_format((float) $value, 2).' ໂຕນ';
    }

    private function documentPayload(NewEnter $enter): array
    {
        $createdAt = $enter->getRawOriginal('created_at');
        $dateIn = $enter->getRawOriginal('date_in');
        $dateOut = $enter->getRawOriginal('date_out');

        return [
            'id' => $enter->id,
            'no' => $enter->enter_number && $enter->enter_number !== '0'
                ? $enter->enter_number
                : 'NE-'.$this->formatYear($createdAt).'-'.str_pad((string) $enter->id, 6, '0', STR_PAD_LEFT),
            'status' => $enter->status,
            'dateIn' => $this->formatDateTime($dateIn) ?: $this->formatDateTime($createdAt),
            'dateOut' => $this->formatDateTime($dateOut),
            'destination' => trim(collect([$enter->address, $enter->district, $enter->province])->filter()->implode(', ')),
            'vehicles' => $enter->details->count(),
            'note' => $enter->status === 'CANCEL' ? $enter->cancel_log : $enter->lasttails,
            'files' => $enter->files->map(function (NewEnterFile $file) {
                return [
                    'name' => $file->original_name ?: basename($file->file_url),
                    'url' => asset($file->file_url),
                    'kind' => str_contains((string) $file->mime_type, 'image') ? 'img' : 'pdf',
                ];
            })->values(),
            'details' => $enter->details->map(function (NewEnterDetail $detail) {
                return [
                    'plate' => $detail->plate_number,
                    'driver' => $detail->driver_name,
                    'type' => $detail->vehicle_type_id,
                    'rounds' => $detail->rounds,
                    'product' => $detail->import_product,
                    'weight' => $detail->weight_kg,
                    'reference' => $detail->import_document_no,
                    'watchlist' => $detail->watchlist_status,
                ];
            })->values(),
        ];
    }

    private function currentUser(): ?User
    {
        $id = session('new_enter_user_id');

        if (!$id) {
            return null;
        }

        return User::where('id', $id)->where('is_admin', '1')->first();
    }

    private function ownedEnter(Request $request): NewEnter
    {
        $user = $this->currentUser();
        abort_unless($user && (string) $user->is_admin === '1', 403);

        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        return NewEnter::with(['details', 'files'])
            ->where('id', (int) $request->input('id'))
            ->where('user_id', $user->id)
            ->where('com_id', $user->com_id)
            ->firstOrFail();
    }

    private function companyFor(User $user)
    {
        return beta_company_group::where('com_id', $user->com_id)->first();
    }

    private function formatDateTime($value): ?string
    {
        if (!$value) {
            return null;
        }

        $timestamp = $this->timestampValue($value);

        if (!$timestamp) {
            return null;
        }

        return date('d/m/y', $timestamp);
    }

    private function formatYear($value): string
    {
        $timestamp = $this->timestampValue($value);

        if (!$timestamp) {
            return date('Y');
        }

        return date('Y', $timestamp);
    }

    private function timestampValue($value): ?int
    {
        if ($value instanceof \DateTimeInterface) {
            return $value->getTimestamp();
        }

        $timestamp = strtotime((string) $value);

        return $timestamp === false ? null : $timestamp;
    }

    private function nowString(): string
    {
        return (new \DateTimeImmutable('now', new \DateTimeZone('Asia/Bangkok')))->format('Y-m-d H:i:s');
    }

    private function todayString(): string
    {
        return (new \DateTimeImmutable('now', new \DateTimeZone('Asia/Bangkok')))->format('Y-m-d');
    }

    private function dateTimeAfterDays(int $days): string
    {
        return (new \DateTimeImmutable('now', new \DateTimeZone('Asia/Bangkok')))
            ->modify('+'.$days.' days')
            ->format('Y-m-d H:i:s');
    }

    private function dateTimeBeforeDays(int $days): string
    {
        return (new \DateTimeImmutable('now', new \DateTimeZone('Asia/Bangkok')))
            ->modify('-'.$days.' days')
            ->format('Y-m-d H:i:s');
    }

    private function vehicleTypes()
    {
        return DB::table('beta_t_type')
            ->orderByRaw('t_type_id = 19 DESC')
            ->orderBy('t_type_id')
            ->get()
            ->map(function ($type) {
                return [
                    'id' => (int) $type->t_type_id,
                    'name' => $type->t_type_name,
                    'is_round' => (int) $type->is_round,
                ];
            })
            ->values();
    }

    private function uniqueSlug(): string
    {
        $slug = Str::random(50);

        while (NewEnter::where('slug', $slug)->exists()) {
            $slug = Str::random(50);
        }

        return $slug;
    }

    private function cleanPlace($value): string
    {
        return preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛ໝໜ\s]/u', '', (string) $value);
    }

    private function numberValue($value): float
    {
        return (float) str_replace(',', '', (string) $value);
    }

    private function watchlistStatus(string $plateNumber): string
    {
        $numbers = preg_replace('/\D/', '', $plateNumber);

        if ($numbers === '') {
            return 'NO';
        }

        return beta_watching_list::where('watching_number', $numbers)
            ->where('created_at', '>=', $this->dateTimeBeforeDays(7))
            ->exists() ? 'YES' : 'NO';
    }
}
