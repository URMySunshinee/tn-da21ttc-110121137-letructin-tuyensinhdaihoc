<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Thiết lập các header CORS
        return $next($request)
            ->header('Access-Control-Allow-Origin', '')   // URL mà bạn muốn cho phép
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE')  // Các phương thức HTTP cho phép
            ->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization')  // Các header cho phép
            ->header('Access-Control-Allow-Credentials', 'true');  // Cho phép gửi cookies
    }
}
