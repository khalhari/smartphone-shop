<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

    <!-- Logo -->
    <div class="mb-6">
        <a href="/">
            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg">
                <i class="fas fa-mobile-alt text-purple-600 text-4xl"></i>
            </div>
        </a>
    </div>

    <!-- Card -->
    <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-2xl overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>

    <!-- Back to Home -->
    <div class="mt-6">
        <a href="{{ route('home') }}" class="text-white hover:text-gray-200 font-semibold text-sm">
            <i class="fas fa-home ml-2"></i>
            العودة للموقع الرئيسي
        </a>
    </div>
</div>
</body>
</html>
