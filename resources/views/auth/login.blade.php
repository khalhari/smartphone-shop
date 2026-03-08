<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>تسجيل الدخول - SmartPhone Shop</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .login-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .input-field {
            transition: all 0.3s ease;
        }

        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.5);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

<div class="login-card max-w-md w-full rounded-2xl shadow-2xl overflow-hidden">

    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white p-8 text-center">
        <div class="mb-4">
            <i class="fas fa-mobile-alt text-5xl"></i>
        </div>
        <h1 class="text-3xl font-bold mb-2">SmartPhone Shop</h1>
        <p class="text-purple-100">لوحة تحكم المدير</p>
    </div>

    <!-- Form -->
    <div class="p-8">

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-gray-700 font-bold mb-2">
                    <i class="fas fa-envelope ml-2"></i>
                    البريد الإلكتروني
                </label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    class="input-field w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-600 focus:outline-none"
                    placeholder="admin@smartphone-shop.de">

                @error('email')
                <p class="mt-2 text-sm text-red-600">
                    <i class="fas fa-exclamation-circle ml-1"></i>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-gray-700 font-bold mb-2">
                    <i class="fas fa-lock ml-2"></i>
                    كلمة المرور
                </label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="input-field w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-600 focus:outline-none"
                    placeholder="••••••••">

                @error('password')
                <p class="mt-2 text-sm text-red-600">
                    <i class="fas fa-exclamation-circle ml-1"></i>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                <label for="remember_me" class="mr-2 text-gray-700">
                    تذكرني
                </label>
            </div>

            <!-- Buttons -->
            <div class="space-y-4">
                <button
                    type="submit"
                    class="btn-login w-full text-white font-bold py-4 rounded-lg shadow-lg">
                    <i class="fas fa-sign-in-alt ml-2"></i>
                    تسجيل الدخول
                </button>

                @if (Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        class="block text-center text-purple-600 hover:text-purple-800 font-semibold">
                        <i class="fas fa-key ml-1"></i>
                        نسيت كلمة المرور؟
                    </a>
                @endif
            </div>
        </form>

        <!-- Info Box -->
        <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <p class="text-sm text-blue-800 font-bold mb-2">
                <i class="fas fa-info-circle ml-2"></i>
                معلومات تسجيل الدخول للمطور:
            </p>
            <div class="text-sm text-blue-700 space-y-1">
                <p><strong>البريد:</strong> admin@smartphone-shop.de</p>
                <p><strong>كلمة المرور:</strong> password</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="bg-gray-50 px-8 py-4 text-center border-t">
        <p class="text-sm text-gray-600">
            <a href="{{ route('home') }}" class="text-purple-600 hover:text-purple-800 font-semibold">
                <i class="fas fa-home ml-1"></i>
                العودة للموقع
            </a>
        </p>
    </div>

</div>

</body>
</html>
