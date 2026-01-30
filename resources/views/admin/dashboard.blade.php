<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - SmartPhone Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-gray-100">

<!-- Sidebar -->
<div class="flex h-screen">
    <aside class="w-64 bg-gradient-to-b from-purple-900 to-purple-700 text-white">
        <div class="p-6">
            <h1 class="text-2xl font-bold">
                <i class="fas fa-mobile-alt ml-2"></i>
                SmartPhone Shop
            </h1>
            <p class="text-purple-200 text-sm mt-1">لوحة التحكم</p>
        </div>

        <nav class="mt-6">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 bg-purple-800 border-l-4 border-white">
                <i class="fas fa-chart-line ml-3"></i>
                الرئيسية
            </a>
            <a href="{{ route('admin.products.index') }}" class="flex items-center px-6 py-3 hover:bg-purple-800 transition">
                <i class="fas fa-box ml-3"></i>
                المنتجات
            </a>
            <a href="{{ route('admin.categories.index') }}" class="flex items-center px-6 py-3 hover:bg-purple-800 transition">
                <i class="fas fa-tags ml-3"></i>
                التصنيفات
            </a>
            <a href="{{ route('admin.settings.index') }}" class="flex items-center px-6 py-3 hover:bg-purple-800 transition">
                <i class="fas fa-cog ml-3"></i>
                الإعدادات
            </a>
            <a href="{{ route('home') }}" class="flex items-center px-6 py-3 hover:bg-purple-800 transition">
                <i class="fas fa-home ml-3"></i>
                الموقع
            </a>
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="flex items-center px-6 py-3 hover:bg-red-600 transition w-full text-right">
                    <i class="fas fa-sign-out-alt ml-3"></i>
                    تسجيل الخروج
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="flex items-center justify-between px-8 py-4">
                <h2 class="text-2xl font-bold text-gray-800">لوحة التحكم</h2>
                <div class="flex items-center gap-4">
                        <span class="text-gray-600">
                            <i class="fas fa-user-circle ml-2"></i>
                            {{ auth()->user()->name }}
                        </span>
                </div>
            </div>
        </header>

        <!-- Stats Cards -->
        <div class="p-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <i class="fas fa-check-circle ml-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- إجمالي المنتجات -->
                <div class="stat-card bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">إجمالي المنتجات</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_products'] }}</h3>
                        </div>
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-box text-blue-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- المنتجات النشطة -->
                <div class="stat-card bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">المنتجات النشطة</p>
                            <h3 class="text-3xl font-bold text-green-600 mt-2">{{ $stats['active_products'] }}</h3>
                        </div>
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- التصنيفات -->
                <div class="stat-card bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">عدد التصنيفات</p>
                            <h3 class="text-3xl font-bold text-purple-600 mt-2">{{ $stats['total_categories'] }}</h3>
                        </div>
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-tags text-purple-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- مخزون منخفض -->
                <div class="stat-card bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">مخزون منخفض</p>
                            <h3 class="text-3xl font-bold text-red-600 mt-2">{{ $stats['low_stock'] }}</h3>
                        </div>
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- أحدث المنتجات -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold">أحدث المنتجات</h3>
                    <a href="{{ route('admin.products.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                        <i class="fas fa-plus ml-2"></i>
                        إضافة منتج جديد
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">الكود</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">الاسم</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">التصنيف</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">السعر</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">المخزون</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">الحالة</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">إجراءات</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @forelse($recent_products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm">{{ $product->code }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-medium">{{ $product->name_de }}</div>
                                    <div class="text-sm text-gray-500">{{ $product->name_ar }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm">{{ $product->category->name_ar }}</td>
                                <td class="px-4 py-3 text-sm font-semibold">{{ number_format($product->price, 2) }}€</td>
                                <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-sm {{ $product->stock < 10 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                            {{ $product->stock }}
                                        </span>
                                </td>
                                <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-sm {{ $product->is_active ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $product->is_active ? 'نشط' : 'غير نشط' }}
                                        </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('هل أنت متأكد؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                    لا توجد منتجات
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 text-center">
                    <a href="{{ route('admin.products.index') }}" class="text-purple-600 hover:text-purple-800 font-semibold">
                        عرض جميع المنتجات
                        <i class="fas fa-arrow-left mr-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
