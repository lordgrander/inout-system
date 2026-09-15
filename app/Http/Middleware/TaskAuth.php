<?php

namespace App\Http\Middleware;

use Closure;
use DateTimeImmutable;
use DateTimeZone;
use Illuminate\Http\Request;

class TaskAuth
{
    public function handle(Request $request, Closure $next)
    {
        $userId = session('task_user_id');
        $expiresAt = session('task_auth_until');

        if (!$userId || !$expiresAt) {
            return redirect()->route('task.login');
        }

        $now = new DateTimeImmutable('now', new DateTimeZone('Asia/Bangkok'));
        $expiresAt = new DateTimeImmutable($expiresAt, new DateTimeZone('Asia/Bangkok'));

        if ($now >= $expiresAt) {
            $request->session()->forget(['task_user_id', 'task_user_name', 'task_auth_until']);

            return redirect()->route('task.login')->withErrors([
                'username' => 'ການເຂົ້າໃຊ້ໝົດອາຍຸແລ້ວ. ກະລຸນາເຂົ້າລະບົບອີກຄັ້ງ.',
            ]);
        }

        return $next($request);
    }
}
