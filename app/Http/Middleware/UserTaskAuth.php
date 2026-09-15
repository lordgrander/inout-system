<?php

namespace App\Http\Middleware;

use Closure;
use DateTimeImmutable;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserTaskAuth
{
    public function handle(Request $request, Closure $next)
    {
        $userId = session('user_task_user_id');
        $expiresAt = session('user_task_auth_until');

        if (!$userId || !$expiresAt) {
            return redirect()->route('user-task.login');
        }

        $now = new DateTimeImmutable('now', new DateTimeZone('Asia/Bangkok'));
        $expiresAt = new DateTimeImmutable($expiresAt, new DateTimeZone('Asia/Bangkok'));

        if ($now >= $expiresAt) {
            $request->session()->forget(['user_task_user_id', 'user_task_user_name', 'user_task_is_admin', 'user_task_auth_until']);

            return redirect()->route('user-task.login')->withErrors([
                'email' => 'ການເຂົ້າໃຊ້ໝົດອາຍຸແລ້ວ. ກະລຸນາເຂົ້າລະບົບອີກຄັ້ງ.',
            ]);
        }

        $user = DB::table('users')
            ->where('id', $userId)
            ->select(['id', 'name', 'email', 'is_admin'])
            ->first();

        if (!$user || (string) $user->is_admin === '1') {
            $request->session()->forget(['user_task_user_id', 'user_task_user_name', 'user_task_is_admin', 'user_task_auth_until']);

            return redirect()->route('user-task.login')->withErrors([
                'email' => 'This user is not allowed for this dashboard.',
            ]);
        }

        $request->session()->put([
            'user_task_user_name' => $user->name ?: $user->email,
            'user_task_is_admin' => (string) $user->is_admin,
        ]);

        return $next($request);
    }
}
