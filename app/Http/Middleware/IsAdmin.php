<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // التحقق من تسجيل الدخول
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        // التحقق من صلاحيات Admin
        if (!auth()->user()->is_admin) {
            abort(403, 'غير مصرح لك بالوصول لهذه الصفحة');
        }

        return $next($request);
    }
}
