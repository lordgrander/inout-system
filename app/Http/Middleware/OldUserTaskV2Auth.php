<?php

namespace App\Http\Middleware;

use Closure;
use DateTimeImmutable;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OldUserTaskV2Auth
{
    public function handle(Request $request, Closure $next)
    {
        $userId = session('old_user_task_v2_user_id');
        $expiresAt = session('old_user_task_v2_auth_until');

        if (!$userId || !$expiresAt) {
            return redirect()->route('old-user-task-v2.login');
        }

        $now = new DateTimeImmutable('now', new DateTimeZone('Asia/Bangkok'));
        $expiresAt = new DateTimeImmutable($expiresAt, new DateTimeZone('Asia/Bangkok'));

        if ($now >= $expiresAt) {
            $this->forget($request);

            return redirect()->route('old-user-task-v2.login')->withErrors([
                'email' => 'ການເຂົ້າໃຊ້ໝົດອາຍຸແລ້ວ. ກະລຸນາເຂົ້າລະບົບອີກຄັ້ງ.',
            ]);
        }

        $user = DB::table('users')
            ->where('id', $userId)
            ->select(['id', 'name', 'email', 'is_admin'])
            ->first();

        if (!$user || !in_array((string) $user->is_admin, ['2', '3', '4', '5'], true)) {
            $this->forget($request);

            return redirect()->route('old-user-task-v2.login')->withErrors([
                'email' => 'This user is not allowed for this dashboard.',
            ]);
        }

        $request->session()->put([
            'old_user_task_v2_user_name' => $user->name ?: $user->email,
            'old_user_task_v2_is_admin' => (string) $user->is_admin,
        ]);

        return $next($request);
    }

    private function forget(Request $request): void
    {
        $request->session()->forget([
            'old_user_task_v2_user_id',
            'old_user_task_v2_user_name',
            'old_user_task_v2_is_admin',
            'old_user_task_v2_auth_until',
            'old_user_task_v2_sign_mode',
        ]);
    }
}
