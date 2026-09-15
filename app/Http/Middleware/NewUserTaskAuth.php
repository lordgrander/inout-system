<?php

namespace App\Http\Middleware;

use Closure;
use DateTimeImmutable;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewUserTaskAuth
{
    public function handle(Request $request, Closure $next)
    {
        $userId = session('new_user_task_user_id');
        $expiresAt = session('new_user_task_auth_until');

        if (!$userId || !$expiresAt) {
            return redirect()->route('new-user-task.login');
        }

        $now = new DateTimeImmutable('now', new DateTimeZone('Asia/Bangkok'));
        $expiresAt = new DateTimeImmutable($expiresAt, new DateTimeZone('Asia/Bangkok'));

        if ($now >= $expiresAt) {
            $this->forget($request);

            return redirect()->route('new-user-task.login')->withErrors([
                'email' => 'ການເຂົ້າໃຊ້ໝົດອາຍຸແລ້ວ. ກະລຸນາເຂົ້າລະບົບອີກຄັ້ງ.',
            ]);
        }

        $user = DB::table('users')
            ->where('id', $userId)
            ->select(['id', 'name', 'email', 'is_admin'])
            ->first();

        if (!$user || !in_array((string) $user->is_admin, ['2', '3', '4', '5'], true)) {
            $this->forget($request);

            return redirect()->route('new-user-task.login')->withErrors([
                'email' => 'This user is not allowed for this dashboard.',
            ]);
        }

        $request->session()->put([
            'new_user_task_user_name' => $user->name ?: $user->email,
            'new_user_task_is_admin' => (string) $user->is_admin,
        ]);

        return $next($request);
    }

    private function forget(Request $request): void
    {
        $request->session()->forget([
            'new_user_task_user_id',
            'new_user_task_user_name',
            'new_user_task_is_admin',
            'new_user_task_auth_until',
            'new_user_task_sign_mode',
        ]);
    }
}
