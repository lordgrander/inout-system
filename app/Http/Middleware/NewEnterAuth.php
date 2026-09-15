<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NewEnterAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('new_enter_user_id')) {
            return redirect()->route('new-enter.login');
        }

        return $next($request);
    }
}
