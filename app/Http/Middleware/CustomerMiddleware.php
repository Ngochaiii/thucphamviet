<?php

// app/Http/Middleware/CustomerMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomerMiddleware
{
     public function handle(Request $request, Closure $next)
    {
        // Kiểm tra đăng nhập
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập');
        }

        // Kiểm tra tài khoản active
        if (!auth()->user()->is_active) {
            auth()->logout();
            return redirect('/login')->with('error', 'Tài khoản đã bị khóa');
        }

        // Admin có thể vào mọi nơi, Customer chỉ vào frontend
        return $next($request);
    }
}
