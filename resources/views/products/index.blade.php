<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Products') }} - SmartPhone Shop</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        [dir="rtl"] body {
            font-family: 'Cairo', sans-serif;
        }

        .product-card {
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
        }

        .whatsapp-btn {
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            transition: all 0.3s ease;
        }

        .whatsapp-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.6);
        }
    </style>
</head>
<body class="bg-gray-50">

<!-- HEADER -->
<header class="bg-gradient-to-r from-purple-600 to-blue-600 text-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <i class="fas fa-mobile-alt text-3xl"></i>
                <div>
                    <h1 class="text-2xl font-bold">SmartPhone Shop</h1>
                    <p class="text-sm opacity-90">
                        @if(app()->getLocale() === 'ar')
                            متجر الهواتف الذكية
                        @else
                            Premium Smartphones
                        @endif
                    </p>
                </div>
            </div>

            <!-- Language Switcher -->
            <div class="flex gap-2 bg-white/20 rounded-full p-1">
                <a href="{{ route('language.switch', 'de') }}"
                   class="px-4 py-2 rounded-full @if(app()->getLocale() === 'de') bg-white text-purple-600 @else text-white @endif font-semibold transition">
                    🇩🇪 Deutsch
                </a>
                <a href="{{ route('language.switch', 'ar') }}"
                   class="px-4 py-2 rounded-full @if(app()->getLocale() === 'ar') bg-white text-purple-600 @else text-white @endif font-semibold transition">
                    🇸🇦 العربية
                </a>
            </div>
        </div>
    </div>
</header>

<!-- CATEGORIES -->
<section class="bg-white py-6 shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap gap-3 justify-center">
            <!-- زر "الكل" -->
            <a href="{{ route('products.index') }}"
               class="px-6 py-2 rounded-full border-2 @if(!request('category')) bg-purple-600 text-white border-purple-600 @else border-gray-300 hover:border-purple-600 @endif transition">
                <i class="fas fa-th mr-2"></i>
                @if(app()->getLocale() === 'ar') الكل @else Alle @endif
            </a>

            <!-- التصنيفات -->
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                   class="px-6 py-2 rounded-full border-2 @if(request('category') === $category->slug) bg-purple-600 text-white border-purple-600 @else border-gray-300 hover:border-purple-600 @endif transition">
                    <i class="fas {{ $category->icon }} mr-2"></i>
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- SEARCH BAR -->
<section class="bg-gradient-to-br from-purple-50 to-blue-50 py-8">
    <div class="container mx-auto px-4">
        <form method="GET" action="{{ route('products.index') }}" class="max-w-2xl mx-auto">
            <div class="relative">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="@if(app()->getLocale() === 'ar') ابحث عن منتج... @else Suche nach Produkten... @endif"
                    class="w-full px-6 py-4 rounded-full border-2 border-purple-200 focus:border-purple-600 focus:outline-none text-lg">
                <button type="submit" class="absolute @if(app()->getLocale() === 'ar') left-2 @else right-2 @endif top-1/2 transform -translate-y-1/2 bg-purple-600 text-white w-12 h-12 rounded-full hover:bg-purple-700 transition">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <!-- عرض نتيجة البحث -->
        @if(request('search'))
            <div class="text-center mt-4">
                <p class="text-gray-600">
                    @if(app()->getLocale() === 'ar')
                        نتائج البحث عن:
                    @else
                        Suchergebnisse für:
                    @endif
                    <strong>"{{ request('search') }}"</strong>
                    ({{ $products->total() }} @if(app()->getLocale() === 'ar') منتج @else Produkte @endif)
                </p>
            </div>
        @endif
    </div>
</section>

<!-- PRODUCTS GRID -->
<section class="py-12">
    <div class="container mx-auto px-4">

        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold">
                @if(app()->getLocale() === 'ar') المنتجات @else Unsere Produkte @endif
            </h2>

            <!-- فلتر الترتيب -->
            <form method="GET" class="flex items-center gap-2">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <select name="sort"
                        onchange="this.form.submit()"
                        class="px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none">
                    <option value="latest" @if(request('sort') === 'latest') selected @endif>
                        @if(app()->getLocale() === 'ar') الأحدث @else Neueste @endif
                    </option>
                    <option value="price_low" @if(request('sort') === 'price_low') selected @endif>
                        @if(app()->getLocale() === 'ar') السعر: من الأقل للأعلى @else Preis: Niedrig → Hoch @endif
                    </option>
                    <option value="price_high" @if(request('sort') === 'price_high') selected @endif>
                        @if(app()->getLocale() === 'ar') السعر: من الأعلى للأقل @else Preis: Hoch → Niedrig @endif
                    </option>
                </select>
            </form>
        </div>

        <!-- شبكة المنتجات -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            @forelse($products as $product)
                <div class="product-card bg-white rounded-2xl overflow-hidden shadow-md">

                    <!-- صورة المنتج -->
                    <div class="relative h-64 bg-gradient-to-br from-purple-100 to-blue-100 overflow-hidden">
                        @if($product->primaryImage)
                            <img src="{{ $product->primaryImage->url }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover hover:scale-110 transition duration-300"
                                 onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center\'><i class=\'fas fa-mobile-alt text-6xl text-gray-400\'></i></div>';">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-mobile-alt text-6xl text-gray-400"></i>
                            </div>
                        @endif

                        <!-- Badge - حالة المنتج -->
                        @if($product->condition === 'new')
                            <span class="absolute top-3 @if(app()->getLocale() === 'ar') right-3 @else left-3 @endif bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                @if(app()->getLocale() === 'ar') جديد @else NEU @endif
                            </span>
                        @elseif($product->condition === 'used')
                            <span class="absolute top-3 @if(app()->getLocale() === 'ar') right-3 @else left-3 @endif bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                @if(app()->getLocale() === 'ar') مستعمل @else GEBRAUCHT @endif
                            </span>
                        @endif

                        <!-- خصم إذا وجد -->
                        @if($product->old_price)
                            <span class="absolute top-3 @if(app()->getLocale() === 'ar') left-3 @else right-3 @endif bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                -{{ number_format((($product->old_price - $product->price) / $product->old_price) * 100) }}%
                            </span>
                        @endif
                    </div>

                    <!-- معلومات المنتج -->
                    <div class="p-5">
                        <!-- اسم المنتج -->
                        <h3 class="font-bold text-lg mb-2 line-clamp-2">
                            {{ $product->name }}
                        </h3>

                        <!-- الوصف القصير -->
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                            {{ Str::limit(strip_tags($product->description), 80) }}
                        </p>

                        <!-- السعر -->
                        <div class="mb-4">
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-bold text-purple-600">
                                    {{ number_format($product->price, 2) }}€
                                </span>

                                @if($product->old_price)
                                    <span class="text-sm text-gray-400 line-through">
                                        {{ number_format($product->old_price, 2) }}€
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- المخزون -->
                        <div class="mb-4">
                            @if($product->stock > 0)
                                <span class="text-green-600 text-sm">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    @if(app()->getLocale() === 'ar') متوفر @else Auf Lager @endif ({{ $product->stock }})
                                </span>
                            @else
                                <span class="text-red-600 text-sm">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    @if(app()->getLocale() === 'ar') غير متوفر @else Ausverkauft @endif
                                </span>
                            @endif
                        </div>

                        <!-- زر واتساب -->
                        <a href="{{ $product->whatsapp_link }}"
                           target="_blank"
                           class="whatsapp-btn flex items-center justify-center gap-2 text-white px-4 py-3 rounded-xl font-semibold w-full">
                            <i class="fab fa-whatsapp text-xl"></i>
                            @if(app()->getLocale() === 'ar') تواصل عبر واتساب @else Jetzt anfragen @endif
                        </a>

                        <!-- زر عرض التفاصيل -->
                        <a href="{{ route('products.show', $product->id) }}"
                           class="block text-center mt-3 text-purple-600 hover:text-purple-800 font-semibold">
                            @if(app()->getLocale() === 'ar') عرض التفاصيل @else Details anzeigen @endif
                            <i class="fas fa-arrow-@if(app()->getLocale() === 'ar')left @else right @endif ml-1"></i>
                        </a>
                    </div>
                </div>

            @empty
                <!-- رسالة إذا لم توجد منتجات -->
                <div class="col-span-full text-center py-16">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-600 mb-2">
                        @if(app()->getLocale() === 'ar') لا توجد منتجات @else Keine Produkte gefunden @endif
                    </h3>
                    <p class="text-gray-500">
                        @if(app()->getLocale() === 'ar') جرب البحث عن شيء آخر @else Versuchen Sie, nach etwas anderem zu suchen @endif
                    </p>
                </div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        <div class="mt-12">
            {{ $products->links() }}
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-gray-900 text-white py-12 mt-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- معلومات المحل -->
            <div>
                <h3 class="text-xl font-bold mb-4">SmartPhone Shop</h3>
                <p class="text-gray-400">
                    @if(app()->getLocale() === 'ar')
                        متجركم الموثوق للهواتف الذكية والإكسسوارات
                    @else
                        Ihr vertrauenswürdiger Shop für Smartphones und Zubehör
                    @endif
                </p>
            </div>

            <!-- التواصل -->
            <div>
                <h3 class="text-xl font-bold mb-4">
                    @if(app()->getLocale() === 'ar') تواصل معنا @else Kontakt @endif
                </h3>
                <div class="space-y-2 text-gray-400">
                    <p><i class="fas fa-phone mr-2"></i> +49 123 456 7890</p>
                    <p><i class="fas fa-envelope mr-2"></i> info@smartphone-shop.de</p>
                    <p><i class="fas fa-map-marker-alt mr-2"></i> Kiel, Deutschland</p>
                </div>
            </div>

            <!-- وسائل التواصل -->
            <div>
                <h3 class="text-xl font-bold mb-4">
                    @if(app()->getLocale() === 'ar') تابعنا @else Folgen Sie uns @endif
                </h3>
                <div class="flex gap-3">
                    <a href="#" class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-700 transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center hover:bg-green-700 transition">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} SmartPhone Shop.
                @if(app()->getLocale() === 'ar') جميع الحقوق محفوظة @else Alle Rechte vorbehalten @endif
            </p>
        </div>
    </div>
</footer>

</body>
</html>
