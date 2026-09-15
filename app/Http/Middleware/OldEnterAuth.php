<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OldEnterAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('old_enter_user_id')) {
            return redirect()->route('old-enter.login');
        }

        return $next($request);
    }
}
