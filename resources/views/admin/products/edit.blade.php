<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل المنتج: {{ $product->name_ar }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Cairo', sans-serif; }</style>
</head>
<body class="bg-gray-100 p-4 md:p-8">

<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
    <div class="bg-gradient-to-r from-blue-800 to-blue-600 p-6 text-white">
        <h2 class="text-2xl font-bold">تعديل بيانات: {{ $product->name_ar }}</h2>
        <p class="text-blue-100">كود المنتج: {{ $product->code }}</p>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="p-8">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-r-4 border-red-500 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="mr-3">
                        <h3 class="text-sm font-bold text-red-800">هناك أخطاء تمنع الحفظ:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الاسم (بالألمانية)</label>
                <input type="text" name="name_de" value="{{ $product->name_de }}" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الاسم (بالعربية)</label>
                <input type="text" name="name_ar" value="{{ $product->name_ar }}" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">السعر الحالي (€)</label>
                <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">السعر القديم</label>
                <input type="number" step="0.01" name="old_price" value="{{ $product->old_price }}" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الكمية في المخزن</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">التصنيف</label>
                <select name="category_id" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name_ar }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الحالة</label>
                <select name="condition" class="w-full p-3 border rounded-lg">
                    <option value="new" {{ $product->condition == 'new' ? 'selected' : '' }}>جديد</option>
                    <option value="used" {{ $product->condition == 'used' ? 'selected' : '' }}>مستعمل</option>
                    <option value="refurbished" {{ $product->condition == 'refurbished' ? 'selected' : '' }}>مجدد</option>
                </select>
            </div>
        </div>
        <div class="mt-8 p-6 bg-gray-50 rounded-2xl border border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}
                class="w-6 h-6 text-green-600 border-gray-300 rounded focus:ring-green-500">
                <label for="is_active" class="mr-3 font-bold text-gray-700 cursor-pointer">
                    تنشيط المنتج (يظهر في المتجر)
                </label>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }}
                class="w-6 h-6 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="is_featured" class="mr-3 font-bold text-gray-700 cursor-pointer">
                    إضافة كمنتج مميز (يظهر في المقدمة)
                </label>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الوصف (German)</label>
                <textarea name="description_de" rows="4" class="w-full p-3 border rounded-lg">{{ $product->description_de }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الوصف (عربي)</label>
                <textarea name="description_ar" rows="4" class="w-full p-3 border rounded-lg">{{ $product->description_ar }}</textarea>
            </div>
        </div>

        <div class="mt-6">
            <label class="block text-sm font-bold text-gray-700 mb-2">إضافة صور جديدة</label>
            <input type="file" name="images[]" multiple class="w-full p-2 border border-dashed rounded-lg">
            <p class="text-xs text-gray-500 mt-1">الصور الحالية ستبقى كما هي، وسيتم إضافة الصور الجديدة إليها.</p>
        </div>

        <div class="mt-10 flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 text-white font-bold py-4 rounded-xl hover:bg-blue-700 transition">
                تحديث البيانات
            </button>
            <a href="{{ route('admin.dashboard') }}" class="flex-1 bg-gray-100 text-gray-600 font-bold py-4 rounded-xl text-center hover:bg-gray-200 transition">
                إلغاء
            </a>
        </div>
    </form>
</div>

</body>
</html>
