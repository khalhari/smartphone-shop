<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // تسجيل Middleware الخاص بتحديد اللغة
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
            \App\Http\Middleware\SecurityHeaders::class,
        ]);

        // Middleware للـ API
        $middleware->api(append: [
            \App\Http\Middleware\RateLimitApi::class,
        ]);

        // Middleware Aliases (اختياري)
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
            'locale' => \App\Http\Middleware\SetLocale::class,
            'security' => \App\Http\Middleware\SecurityHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
