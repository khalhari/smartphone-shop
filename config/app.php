<?php

return [
    'name' => env('APP_NAME', 'SmartPhone Shop'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),

    'timezone' => env('APP_TIMEZONE', 'Europe/Berlin'),

    'locale' => env('APP_LOCALE', 'de'),
    'fallback_locale' => 'de',
    'faker_locale' => 'de_DE',

    // اللغات المدعومة
    'available_locales' => ['de', 'ar'],

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),
    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],
];
