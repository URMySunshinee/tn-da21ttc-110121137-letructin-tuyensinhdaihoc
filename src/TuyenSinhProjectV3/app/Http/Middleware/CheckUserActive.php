<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status_user != 0) {
            Auth::logout();
            return redirect()->route('user.auth')->withErrors(['email' => 'Tài khoản của bạn đã bị khóa hoặc xóa.']);
        }
        return $next($request);
    }
}
