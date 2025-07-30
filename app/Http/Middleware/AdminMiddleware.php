<?php

// app/Http/Middleware/AdminMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra đăng nhập
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập để truy cập admin');
        }

        // Kiểm tra quyền admin
        if (!auth()->user()->is_admin) {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập khu vực admin');
        }

        // Kiểm tra tài khoản active
        if (!auth()->user()->is_active) {
            auth()->logout();
            return redirect('/login')->with('error', 'Tài khoản admin đã bị khóa');
        }

        return $next($request);
    }
}
