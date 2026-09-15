<?php

namespace App\Http\Controllers;

use App\Models\beta_company_group;
use App\Models\beta_enter;
use App\Models\beta_enter_detail;
use App\Models\beta_enter_file;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OldEnterController extends Controller
{
    public function login()
    {
        if (session('old_enter_user_id')) {
            return redirect()->route('old-enter.index');
        }

        return view('new-enter.login', [
            'routePrefix' => 'old-enter',
            'loginLabel' => 'Old Enter',
        ]);
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
                'email' => 'Email or password is incorrect, or this user is not allowed for Old Enter.',
            ])->withInput($request->only('email'));
        }

        $request->session()->put([
            'old_enter_user_id' => $user->id,
            'old_enter_user_name' => $user->name,
            'old_enter_com_id' => $user->com_id,
        ]);

        return redirect()->route('old-enter.index');
    }

    public function registerStore(Request $request)
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:200'],
            'owner_name' => ['required', 'string', 'max:100'],
            'company_phone' => ['required', 'string', 'max:20'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'user_phone' => ['required', 'string', 'max:20'],
            'document_files.*' => ['nullable', 'file', 'max:15360', 'mimes:pdf,jpg,jpeg,png'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $now = $this->nowString();
        $comId = null;
        $userId = null;

        DB::transaction(function () use ($request, $validated, $now, &$comId, &$userId) {
            $comId = DB::table('beta_company_group')->insertGetId([
                'com_name' => trim($validated['company_name']),
                'com_owner' => trim($validated['owner_name']),
                'com_phone' => trim($validated['company_phone']),
                'com_status' => 'NO',
                'active_at' => null,
                'end_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $userId = DB::table('users')->insertGetId([
                'is_admin' => 1,
                'allow_other' => 'NO',
                'com_id' => $comId,
                'name' => trim($validated['name']),
                'user_phone' => trim($validated['user_phone']),
                'itn' => '0',
                'email' => trim($validated['email']),
                'password' => Hash::make($validated['password']),
                'active_at' => null,
                'end_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
                'log' => 'NO',
            ]);

            $profileId = DB::table('beta_company_profile')->insertGetId([
                'text' => 'register',
                'com_id' => $comId,
                'user_id' => $userId,
                'status' => 'pending',
                'log' => 'NO',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            if ($request->hasFile('document_files')) {
                $path = 'company-register/c'.$comId.'/p'.$profileId;
                $fullPath = public_path($path);

                if (!File::exists($fullPath)) {
                    File::makeDirectory($fullPath, 0755, true);
                }

                foreach ($request->file('document_files') as $file) {
                    if (!$file || !File::isReadable($file)) {
                        continue;
                    }

                    $storedPath = $file->store($path, ['disk' => 'my_files']);

                    DB::table('beta_company_profile_detail')->insert([
                        'company_profile_id' => $profileId,
                        'com_id' => $comId,
                        'file_url' => $storedPath,
                        'created_at' => $now,
                        'updated_at' => $now,
                        'text' => 'register',
                        'status' => 'NO',
                        'user_id' => $userId,
                    ]);
                }
            }
        });

        return redirect()->route('old-enter.login')->with('register_success', 'Register request saved. Please wait for approval.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget([
            'old_enter_user_id',
            'old_enter_user_name',
            'old_enter_com_id',
        ]);

        return redirect()->route('old-enter.login');
    }

    public function index()
    {
        $user = $this->currentUser();
        abort_unless($user, 403);

        return view('new-enter.index', [
            'company' => $this->companyFor($user),
            'user' => $user,
            'vehicleTypes' => $this->vehicleTypes(),
            'routePrefix' => 'old-enter',
        ]);
    }

    public function documents()
    {
        $user = $this->currentUser();
        abort_unless($user, 403);

        return view('new-enter.documents', [
            'company' => $this->companyFor($user),
            'user' => $user,
            'documents' => collect(),
            'routePrefix' => 'old-enter',
        ]);
    }

    public function quotars()
    {
        $user = $this->currentUser();
        abort_unless($user, 403);

        $quotars = DB::table('company_quotars')
            ->where('com_id', $user->com_id)
            ->orderByDesc('id')
            ->get();

        return view('new-enter.quotars', [
            'company' => $this->companyFor($user),
            'user' => $user,
            'quotars' => $quotars,
            'routePrefix' => 'old-enter',
        ]);
    }

    public function quotarsStore(Request $request)
    {
        $user = $this->currentUser();
        abort_unless($user, 403);

        $validated = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'total_amount' => ['required', 'numeric', 'min:0.01'],
            'document_files.*' => ['nullable', 'file', 'max:15360', 'mimes:pdf,jpg,jpeg,png'],
        ]);

        $now = $this->nowString();
        $quotarId = DB::table('company_quotars')->insertGetId([
            'com_id' => $user->com_id,
            'product_name' => trim($validated['product_name']),
            'total_amount' => $this->numberValue($validated['total_amount']),
            'remaining_amount' => $this->numberValue($validated['total_amount']),
            'expire_date' => null,
            'status' => 'PENDING',
            'requested_by' => $user->id,
            'approved_by' => null,
            'approved_at' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->storeQuotarFiles($request, $quotarId, $user);

        return redirect()->route('old-enter.quotars')->with('success', 'Quota request saved.');
    }

    public function quotarOptions()
    {
        $user = $this->currentUser();
        abort_unless($user, 403);

        $today = $this->todayString();

        $quotars = DB::table('company_quotars')
            ->where('com_id', $user->com_id)
            ->where('status', 'APPROVED')
            ->where('remaining_amount', '>', 0)
            ->where(function ($query) use ($today) {
                $query->whereNull('expire_date')
                    ->orWhere('expire_date', '>=', $today);
            })
            ->orderBy('product_name')
            ->get()
            ->map(function ($quotar) {
                return [
                    'id' => (int) $quotar->id,
                    'product_name' => $quotar->product_name,
                    'total_amount' => (float) $quotar->total_amount,
                    'remaining_amount' => (float) $quotar->remaining_amount,
                    'expire_date' => $quotar->expire_date,
                ];
            })
            ->values();

        return response()->json(['data' => $quotars]);
    }

    public function documentsData(Request $request)
    {
        $user = $this->currentUser();
        abort_unless($user, 403);

        $activeStatuses = ['WAITING', 'QWAIT', 'POINTING', 'SIGNING', 'QSIGNING', 'SIGNINED', 'READY'];
        $page = max(1, (int) $request->input('page', 1));
        $scope = $request->input('scope', 'today');
        $filter = $request->input('filter', 'ALL');
        $search = trim((string) $request->input('q', ''));

        $query = beta_enter::query()
            ->with(['enterHaveDetail', 'enterHaveFile'])
            ->where('user_id', $user->id)
            ->where('com_id', $user->com_id);

        if ($scope === 'today') {
            $query->whereDate('date_make', $this->todayString());
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
                    ->orWhereHas('enterHaveDetail', function ($details) use ($like) {
                        $details->where('plate_number', 'like', $like)
                            ->orWhere('d_name', 'like', $like)
                            ->orWhere('p_import', 'like', $like)
                            ->orWhere('detail', 'like', $like);
                    })
                    ->orWhereHas('enterHaveFile', function ($files) use ($like) {
                        $files->where('file_url', 'like', $like);
                    });
            });
        }

        $paginator = $query->orderByDesc('date_make')->orderByDesc('enter_id')->paginate(40, ['*'], 'page', $page);

        return response()->json([
            'data' => $paginator->getCollection()->map(function (beta_enter $enter) {
                return $this->documentPayload($enter);
            })->values(),
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
        $enter = $this->ownedEnter($request);

        if ($enter->status !== 'DRAFT') {
            return response()->json(['status' => 'error', 'message' => 'Only draft documents can be sent.'], 422);
        }

        DB::transaction(function () use ($enter, $user) {
            DB::table('beta_enter')->where('enter_id', $enter->enter_id)->update([
                'status' => 'WAITING',
                'date_make' => $this->nowString(),
                'date_in' => $this->nowString(),
            ]);

            $details = beta_enter_detail::where('enter_id', $enter->enter_id)->whereNotNull('quotar_id')->get();
            foreach ($details as $detail) {
                if (!$detail->quotar_usage_id) {
                    $usageId = $this->reserveQuotar($detail->quotar_id, $enter->enter_id, $detail->enter_detail_id, $user->com_id, $detail->weight);
                    $detail->quotar_usage_id = $usageId;
                    $detail->save();
                }
            }
        });

        $this->sendDiscordNotification($enter->fresh(['enterHaveDetail', 'enterHaveFile']), $user);

        return response()->json(['status' => 'ok', 'message' => 'Document sent.']);
    }

    public function cancel(Request $request)
    {
        $enter = $this->ownedEnter($request);

        if (!in_array($enter->status, ['WAITING', 'QWAIT'], true)) {
            return response()->json(['status' => 'error', 'message' => 'Only waiting documents can be cancelled.'], 422);
        }

        DB::transaction(function () use ($enter) {
            DB::table('beta_enter')->where('enter_id', $enter->enter_id)->update([
                'status' => 'CANCEL',
                'cancel_log' => 'ຜູ້ໃຊ້ຍົກເລີກ',
            ]);

            $this->returnQuotarUsages($enter->enter_id);
        });

        return response()->json(['status' => 'ok', 'message' => 'Document cancelled.']);
    }

    public function delete(Request $request)
    {
        $enter = $this->ownedEnter($request);

        if (!in_array($enter->status, ['DRAFT', 'CANCEL'], true)) {
            return response()->json(['status' => 'error', 'message' => 'Only draft or cancelled documents can be deleted.'], 422);
        }

        foreach ($enter->enterHaveFile as $file) {
            $path = public_path($file->file_url);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $enter->enterHaveFile()->delete();
        $enter->enterHaveDetail()->delete();
        $enter->delete();

        return response()->json(['status' => 'ok', 'message' => 'Document deleted.']);
    }

    private function saveApplication(Request $request, string $status)
    {
        $user = $this->currentUser();
        abort_unless($user, 403);

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
            return response()->json(['status' => 'error', 'message' => 'At least one vehicle row is required.'], 422);
        }

        $now = $this->nowString();
        $enter = null;

        DB::transaction(function () use ($request, $user, $status, $details, $now, &$enter) {
            $enter = beta_enter::create([
                'user_id' => $user->id,
                'com_id' => $user->com_id,
                'enter_number' => '0',
                'sign_status' => '0',
                'date_make' => $now,
                'date_in' => $now,
                'date_out' => $this->dateTimeAfterDays(2),
                'status' => $status,
                'price' => 0,
                'lasttails' => $request->input('lasttails'),
                'slug' => $this->uniqueSlug(),
                'address' => $this->cleanPlace($request->input('address')),
                'district' => $this->cleanPlace($request->input('district')),
                'province' => $this->cleanPlace($request->input('province')),
                'take' => '0',
            ]);

            foreach ($details as $detail) {
                $enterDetail = beta_enter_detail::create([
                    'enter_id' => $enter->enter_id,
                    'user_id' => $user->id,
                    'plate_number' => $detail['plate_number'],
                    't_model' => $detail['vehicle_type_id'],
                    'd_name' => $detail['driver_name'],
                    'p_import' => $detail['import_product'],
                    'rounds' => $detail['rounds'],
                    'weight' => $detail['weight_kg'],
                    'detail' => $detail['import_document_no'],
                    'status' => '0',
                    't_type_id' => '0',
                    'p_type_id' => '0',
                    'quotar_id' => $detail['quotar_id'],
                ]);

                if ($status === 'WAITING' && $detail['quotar_id']) {
                    $usageId = $this->reserveQuotar($detail['quotar_id'], $enter->enter_id, $enterDetail->enter_detail_id, $user->com_id, $detail['weight_kg']);
                    $enterDetail->quotar_usage_id = $usageId;
                    $enterDetail->save();
                }
            }
        });

        $this->storeFiles($request, $enter, $user);

        if ($status === 'WAITING') {
            $this->sendDiscordNotification($enter->fresh(['enterHaveDetail', 'enterHaveFile']), $user);
        }

        return response()->json([
            'status' => 'ok',
            'message' => $status === 'DRAFT' ? 'Draft saved.' : 'Form submitted.',
            'enter_id' => $enter->enter_id,
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
                abort(response()->json(['status' => 'error', 'message' => 'Vehicle row '.$i.' is missing required data.'], 422));
            }

            $details[] = [
                'plate_number' => $plate,
                'driver_name' => $driverName,
                'vehicle_type_id' => $vehicleTypeId,
                'rounds' => $rounds,
                'import_product' => $importProduct,
                'import_document_no' => $importDocumentNo,
                'weight_kg' => $weightKg,
                'quotar_id' => $request->input('input_quotar_id_'.$i) ? (int) $request->input('input_quotar_id_'.$i) : null,
            ];
        }

        return $details;
    }

    private function storeFiles(Request $request, beta_enter $enter, User $user): void
    {
        if (!$request->hasFile('upload_files')) {
            return;
        }

        $path = 'com/c'.$user->com_id.'/in'.$enter->enter_id;
        $fullPath = public_path($path);

        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }

        foreach ($request->file('upload_files') as $file) {
            if (!$file || !File::isReadable($file)) {
                continue;
            }

            $storedPath = $file->store($path, ['disk' => 'my_files']);

            beta_enter_file::create([
                'enter_id' => $enter->enter_id,
                'user_id' => $user->id,
                'date' => $this->todayString(),
                'file_url' => $storedPath,
            ]);
        }
    }

    private function storeQuotarFiles(Request $request, $quotarId, User $user)
    {
        if (!$request->hasFile('document_files')) {
            return;
        }

        $path = 'quotars/c'.$user->com_id.'/q'.$quotarId;
        $fullPath = public_path($path);

        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }

        foreach ($request->file('document_files') as $file) {
            if (!$file || !File::isReadable($file)) {
                continue;
            }

            $storedPath = $file->store($path, ['disk' => 'my_files']);

            DB::table('company_quotar_files')->insert([
                'quotar_id' => $quotarId,
                'com_id' => $user->com_id,
                'user_id' => $user->id,
                'file_url' => $storedPath,
                'created_at' => $this->nowString(),
                'updated_at' => $this->nowString(),
            ]);
        }
    }

    private function reserveQuotar($quotarId, $enterId, $enterDetailId, $comId, $amount)
    {
        $today = $this->todayString();
        $amount = $this->numberValue($amount);

        if ($amount <= 0) {
            abort(response()->json(['status' => 'error', 'message' => 'Quota amount must be greater than zero.'], 422));
        }

        $quotar = DB::table('company_quotars')
            ->where('id', $quotarId)
            ->where('com_id', $comId)
            ->where('status', 'APPROVED')
            ->where(function ($query) use ($today) {
                $query->whereNull('expire_date')
                    ->orWhere('expire_date', '>=', $today);
            })
            ->lockForUpdate()
            ->first();

        if (!$quotar) {
            abort(response()->json(['status' => 'error', 'message' => 'Selected quota is not available.'], 422));
        }

        if ((float) $quotar->remaining_amount < $amount) {
            abort(response()->json(['status' => 'error', 'message' => 'Selected quota remaining amount is not enough.'], 422));
        }

        DB::table('company_quotars')->where('id', $quotarId)->update([
            'remaining_amount' => (float) $quotar->remaining_amount - $amount,
            'updated_at' => $this->nowString(),
        ]);

        return DB::table('company_quotar_usages')->insertGetId([
            'quotar_id' => $quotarId,
            'enter_id' => $enterId,
            'enter_detail_id' => $enterDetailId,
            'com_id' => $comId,
            'used_amount' => $amount,
            'status' => 'ACTIVE',
            'used_at' => $this->nowString(),
            'returned_at' => null,
            'created_at' => $this->nowString(),
            'updated_at' => $this->nowString(),
        ]);
    }

    private function returnQuotarUsages($enterId)
    {
        $usages = DB::table('company_quotar_usages')
            ->where('enter_id', $enterId)
            ->where('status', 'ACTIVE')
            ->lockForUpdate()
            ->get();

        foreach ($usages as $usage) {
            $quotar = DB::table('company_quotars')
                ->where('id', $usage->quotar_id)
                ->lockForUpdate()
                ->first();

            if ($quotar) {
                DB::table('company_quotars')->where('id', $usage->quotar_id)->update([
                    'remaining_amount' => (float) $quotar->remaining_amount + (float) $usage->used_amount,
                    'updated_at' => $this->nowString(),
                ]);
            }

            DB::table('company_quotar_usages')->where('id', $usage->id)->update([
                'status' => 'RETURNED',
                'returned_at' => $this->nowString(),
                'updated_at' => $this->nowString(),
            ]);
        }
    }

    private function documentPayload(beta_enter $enter): array
    {
        return [
            'id' => $enter->enter_id,
            'no' => $enter->enter_number && $enter->enter_number !== '0'
                ? $enter->enter_number
                : 'OE-'.$this->formatYear($enter->date_make).'-'.str_pad((string) $enter->enter_id, 6, '0', STR_PAD_LEFT),
            'status' => $enter->status,
            'dateIn' => $this->formatDate($enter->date_in ?: $enter->date_make),
            'dateOut' => $this->formatDate($enter->date_out),
            'destination' => trim(collect([$enter->address, $enter->district, $enter->province])->filter()->implode(', ')),
            'vehicles' => $enter->enterHaveDetail->count(),
            'note' => $enter->status === 'CANCEL' ? $enter->cancel_log : $enter->lasttails,
            'files' => $enter->enterHaveFile->map(function (beta_enter_file $file) {
                $path = (string) $file->file_url;
                $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

                return [
                    'name' => basename($path),
                    'url' => asset($path),
                    'kind' => in_array($extension, ['jpg', 'jpeg', 'png'], true) ? 'img' : 'pdf',
                ];
            })->values(),
            'details' => $enter->enterHaveDetail->map(function (beta_enter_detail $detail) {
                return [
                    'plate' => $detail->plate_number,
                    'driver' => $detail->d_name,
                    'type' => $detail->t_model,
                    'rounds' => $detail->rounds,
                    'product' => $detail->p_import,
                    'weight' => $detail->weight,
                    'reference' => $detail->detail,
                    'quotar_id' => $detail->quotar_id,
                    'quotar_usage_id' => $detail->quotar_usage_id,
                    'watchlist' => null,
                ];
            })->values(),
        ];
    }

    private function sendDiscordNotification(?beta_enter $enter, ?User $user): void
    {
        $webhookUrl = config('services.discord.new_enter_webhook_url');

        if (!$webhookUrl || !$enter || !$user) {
            return;
        }

        $company = $this->companyFor($user);
        $destination = trim(collect([$enter->address, $enter->district, $enter->province])->filter()->implode(', '));
        $number = $enter->enter_number && $enter->enter_number !== '0'
            ? $enter->enter_number
            : 'OE-'.$this->formatYear($enter->date_make).'-'.str_pad((string) $enter->enter_id, 6, '0', STR_PAD_LEFT);
        $vehicleLines = $enter->enterHaveDetail->take(5)->map(function (beta_enter_detail $detail, int $index) {
            return ($index + 1).'. '.$detail->plate_number.' | '.$detail->d_name.' | '.$detail->p_import.' | '.$this->formatWeight($detail->weight);
        })->implode("\n");

        try {
            Http::timeout(5)->post($webhookUrl, [
                'username' => 'Vehicle Permit System',
                'content' => '[OLD] ມີໃບອະນຸຍາດໃໝ່ຖືກສົ່ງເຂົ້າລະບົບ',
                'embeds' => [[
                    'title' => '[OLD] '.$number,
                    'color' => 0x0a427a,
                    'fields' => [
                        ['name' => 'ບໍລິສັດ', 'value' => $company->com_name ?? 'No company', 'inline' => true],
                        ['name' => 'ຜູ້ສົ່ງ', 'value' => $user->name ?? '-', 'inline' => true],
                        ['name' => 'ສະຖານະ', 'value' => $enter->status ?? '-', 'inline' => true],
                        ['name' => 'ວັນທີ', 'value' => $this->formatDate($enter->date_make) ?: '-', 'inline' => true],
                        ['name' => 'ຈຳນວນລົດ', 'value' => (string) $enter->enterHaveDetail->count(), 'inline' => true],
                        ['name' => 'ໄຟລ໌ແນບ', 'value' => (string) $enter->enterHaveFile->count(), 'inline' => true],
                        ['name' => 'ປາຍທາງ', 'value' => $destination ?: '-', 'inline' => false],
                        ['name' => 'ລາຍການລົດ', 'value' => $vehicleLines ?: '-', 'inline' => false],
                    ],
                ]],
            ]);
        } catch (\Throwable $exception) {
            Log::warning('Discord old enter notification failed', [
                'enter_id' => $enter->enter_id,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    private function currentUser(): ?User
    {
        $id = session('old_enter_user_id');

        return $id ? User::where('id', $id)->where('is_admin', '1')->first() : null;
    }

    private function ownedEnter(Request $request): beta_enter
    {
        $user = $this->currentUser();
        abort_unless($user, 403);

        $request->validate(['id' => ['required', 'integer']]);

        return beta_enter::with(['enterHaveDetail', 'enterHaveFile'])
            ->where('enter_id', (int) $request->input('id'))
            ->where('user_id', $user->id)
            ->where('com_id', $user->com_id)
            ->firstOrFail();
    }

    private function companyFor(User $user)
    {
        return beta_company_group::where('com_id', $user->com_id)->first();
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

        while (beta_enter::where('slug', $slug)->exists()) {
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

    private function formatDate($value): ?string
    {
        if (!$value) {
            return null;
        }

        $timestamp = strtotime((string) $value);

        return $timestamp === false ? null : date('d/m/y', $timestamp);
    }

    private function formatYear($value): string
    {
        $timestamp = strtotime((string) $value);

        return $timestamp === false ? date('Y') : date('Y', $timestamp);
    }

    private function formatWeight($value): string
    {
        if ($value === null || $value === '') {
            return '-';
        }

        return number_format((float) $value, 2).' ໂຕນ';
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
        return (new \DateTimeImmutable('now', new \DateTimeZone('Asia/Bangkok')))->modify('+'.$days.' days')->format('Y-m-d H:i:s');
    }
}
