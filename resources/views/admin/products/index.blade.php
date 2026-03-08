<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 rounded-3xl p-6 shadow-xl mb-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl"></div>

            <div class="flex flex-col md:flex-row justify-between items-center text-white gap-4 relative z-10">
                <div>
                    <h2 class="text-3xl font-extrabold flex items-center gap-3">
                        <i class="fas fa-box-open"></i> إدارة المنتجات
                        <span class="bg-white text-indigo-600 text-sm px-3 py-1 rounded-full font-bold shadow-sm">
                            {{ $products->total() }} منتج
                        </span>
                    </h2>
                    <p class="text-indigo-100 text-sm mt-1 opacity-90">تحكم بمخزون متجرك، الأسعار، والصور بكل سهولة</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    @if(request()->has('no_image'))
                        <a href="{{ route('admin.products.index') }}" class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-lg flex items-center">
                            <i class="fas fa-times ml-2"></i> عرض كل المنتجات
                        </a>
                    @else
                        <a href="{{ route('admin.products.index', ['no_image' => 1]) }}" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-lg flex items-center">
                            <i class="fas fa-image-slash ml-2"></i> منتجات بدون صور
                        </a>
                    @endif

                    <a href="{{ route('admin.products.create') }}" class="bg-white text-indigo-600 px-5 py-2.5 rounded-xl font-black hover:bg-gray-50 transition shadow-lg flex items-center border-2 border-transparent hover:border-indigo-100">
                        <i class="fas fa-plus ml-2"></i> إضافة منتج جديد
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-center">
                <form action="{{ route('admin.products.index') }}" method="GET" class="flex w-full md:w-1/2 gap-2">
                    @if(request()->has('no_image'))
                        <input type="hidden" name="no_image" value="1">
                    @endif

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث باسم المنتج أو الـ Code..."
                           class="w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm px-4">

                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl text-sm font-bold transition shadow">
                        <i class="fas fa-search"></i>
                    </button>

                    @if(request('search'))
                        <a href="{{ route('admin.products.index', request()->has('no_image') ? ['no_image' => 1] : []) }}"
                           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-xl text-sm font-bold transition flex items-center justify-center">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </form>
            </div>

            <div class="bg-white border border-gray-100 shadow-xl shadow-gray-200/40 sm:rounded-3xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-right whitespace-nowrap">
                        <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-gray-500">
                            <th class="px-6 py-4 text-sm font-extrabold">المنتج</th>
                            <th class="px-6 py-4 text-sm font-extrabold">السعر</th>
                            <th class="px-6 py-4 text-sm font-extrabold">المخزون</th>
                            <th class="px-6 py-4 text-sm font-extrabold">الحالة</th>
                            <th class="px-6 py-4 text-sm font-extrabold text-center">الإجراءات</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @forelse($products as $product)
                            @php
                                $adminImage = null;
                                $extensions = ['jpg', 'JPG', 'jpeg', 'png', 'webp'];
                                foreach($extensions as $ext) {
                                    if(file_exists(public_path("images/{$product->code}.{$ext}"))) {
                                        $adminImage = "images/{$product->code}.{$ext}";
                                        break;
                                    }
                                }
                            @endphp

                            <tr class="hover:bg-indigo-50/40 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="h-16 w-16 rounded-2xl overflow-hidden bg-gray-50 border border-gray-200 shadow-sm flex-shrink-0 relative">
                                            @if($adminImage)
                                                <img src="{{ asset($adminImage) }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center bg-red-50 text-red-400">
                                                    <i class="fas fa-image-slash text-xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-sm font-extrabold text-gray-900 group-hover:text-indigo-600 transition">
                                                {{ $product->name_de ?? $product->name }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1.5 flex items-center gap-2">
                                                <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-600 font-mono">Code: {{ $product->code }}</span>
                                                @if(!$adminImage)
                                                    <span class="text-red-500 font-bold"><i class="fas fa-exclamation-triangle"></i> لا توجد صورة</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-base font-black text-gray-800">{{ number_format($product->price, 2) }} €</span>
                                        @if($product->old_price && $product->old_price > $product->price)
                                            <span class="text-xs text-red-400 line-through">{{ number_format($product->old_price, 2) }} €</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    @if($product->stock > 0)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                                <i class="fas fa-box-open"></i> {{ $product->stock }} حبة
                                            </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 animate-pulse">
                                                <i class="fas fa-times-circle"></i> نفدت الكمية
                                            </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    @if($product->is_active)
                                        <span class="text-green-500 text-sm font-bold flex items-center gap-1">
                                                <i class="fas fa-circle text-[8px]"></i> نشط
                                            </span>
                                    @else
                                        <span class="text-gray-400 text-sm font-bold flex items-center gap-1">
                                                <i class="fas fa-circle text-[8px]"></i> مخفي
                                            </span>
                                    @endif
                                </td>

                                <td class="px-8 py-5">
                                    <div class="flex justify-center items-center gap-3">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="تعديل">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" onclick="return confirm('هل أنت متأكد؟')" title="حذف">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                    <i class="fas fa-box-open text-5xl mb-3 opacity-50"></i>
                                    <p class="text-lg font-bold">لا توجد منتجات مطابقة</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
