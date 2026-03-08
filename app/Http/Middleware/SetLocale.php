<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // الحصول على اللغة من الـ Session أو اللغة الافتراضية
        $locale = Session::get('locale', config('app.locale', 'de'));

        // التحقق من أن اللغة مدعومة
        if (in_array($locale, config('app.available_locales', ['de', 'ar']))) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
