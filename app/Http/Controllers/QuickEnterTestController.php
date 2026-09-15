<?php

namespace App\Http\Controllers;

use App\Models\NewEnter;
use App\Models\NewEnterDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuickEnterTestController extends Controller
{
    public function index()
    {
        return view('quick-enter-test.index', [
            'lastCreated' => session('quick_enter_test_last_created'),
        ]);
    }

    public function createNew(Request $request)
    {
        $user = $this->testUser();
        $typeId = $this->vehicleTypeId();
        $now = $this->nowString();
        $token = strtoupper(Str::random(5));

        $enter = null;

        DB::transaction(function () use ($user, $typeId, $now, $token, &$enter) {
            $enter = NewEnter::create([
                'user_id' => $user->id,
                'com_id' => $user->com_id,
                'enter_number' => '0',
                'sign_status' => '0',
                'take' => '0',
                'date_make' => $now,
                'date_in' => $now,
                'date_out' => $this->dateTimeAfterDays(2),
                'status' => 'WAITING',
                'price' => 0,
                'lasttails' => 'Quick test order for new_enters',
                'slug' => Str::random(50),
                'address' => 'Quick Village',
                'district' => 'Quick District',
                'province' => 'Quick Province',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            NewEnterDetail::create([
                'new_enter_id' => $enter->id,
                'user_id' => $user->id,
                'plate_number' => 'NEW-'.$token,
                'driver_name' => 'Quick Driver New',
                'vehicle_type_id' => $typeId,
                'rounds' => 1,
                'import_product' => 'Quick Product',
                'import_document_no' => 'NEW-REF-'.$token,
                'weight_kg' => 12.50,
                'watchlist_status' => 'NO',
                'status' => '0',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        });

        return back()->with('quick_enter_test_last_created', [
            'type' => 'new_enters',
            'id' => $enter->id,
            'status' => 'WAITING',
        ]);
    }

    public function createOld(Request $request)
    {
        $user = $this->testUser();
        $typeId = $this->vehicleTypeId();
        $now = $this->nowString();
        $token = strtoupper(Str::random(5));

        $enterId = null;

        DB::transaction(function () use ($user, $typeId, $now, $token, &$enterId) {
            $enterId = DB::table('beta_enter')->insertGetId([
                'user_id' => $user->id,
                'com_id' => $user->com_id,
                'enter_number' => '0',
                'sign_status' => '0',
                'date_make' => $now,
                'date_in' => $now,
                'date_out' => $this->dateTimeAfterDays(2),
                'status' => 'WAITING',
                'price' => 0,
                'lasttails' => 'Quick test order for beta_enter',
                'slug' => Str::random(50),
                'address' => 'Quick Village',
                'district' => 'Quick District',
                'province' => 'Quick Province',
                'take' => '0',
            ], 'enter_id');

            DB::table('beta_enter_detail')->insert([
                'enter_id' => $enterId,
                'user_id' => $user->id,
                'plate_number' => 'OLD-'.$token,
                't_model' => $typeId,
                'd_name' => 'Quick Driver Old',
                'p_import' => 'Quick Product',
                'rounds' => 1,
                'weight' => 12.50,
                'detail' => 'OLD-REF-'.$token,
                'status' => '0',
                't_type_id' => '0',
                'p_type_id' => '0',
            ]);
        });

        return back()->with('quick_enter_test_last_created', [
            'type' => 'beta_enter',
            'id' => $enterId,
            'status' => 'WAITING',
        ]);
    }

    public function setUserRole(Request $request, int $role)
    {
        abort_unless(in_array($role, [1, 2, 3, 4, 5], true), 404);

        DB::table('users')->where('id', 1)->update([
            'is_admin' => $role,
        ]);

        return back()->with('quick_enter_test_last_created', [
            'type' => 'users',
            'id' => 1,
            'status' => 'is_admin = '.$role,
        ]);
    }

    private function testUser()
    {
        $user = DB::table('users')
            ->where('is_admin', 1)
            ->whereNotNull('com_id')
            ->orderBy('id')
            ->first(['id', 'name', 'email', 'com_id']);

        abort_unless($user, 422, 'No is_admin=1 user found for quick testing.');

        return $user;
    }

    private function vehicleTypeId(): int
    {
        return (int) DB::table('beta_t_type')->orderBy('t_type_id')->value('t_type_id') ?: 1;
    }

    private function nowString(): string
    {
        return (new \DateTimeImmutable('now', new \DateTimeZone('Asia/Bangkok')))->format('Y-m-d H:i:s');
    }

    private function dateTimeAfterDays(int $days): string
    {
        return (new \DateTimeImmutable('now', new \DateTimeZone('Asia/Bangkok')))
            ->modify('+'.$days.' days')
            ->format('Y-m-d H:i:s');
    }
}
