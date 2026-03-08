<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة منتج جديد</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Cairo', sans-serif; }</style>
</head>
<body class="bg-gray-100 p-4 md:p-8">

<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
    <div class="bg-gradient-to-r from-purple-800 to-purple-600 p-6 text-white">
        <h2 class="text-2xl font-bold">إضافة هاتف جديد للمتجر</h2>
        <p class="text-purple-100">أدخل بيانات المنتج بدقة لتظهر بشكل صحيح للعملاء</p>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الاسم (بالألمانية)</label>
                <input type="text" name="name_de" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-purple-500 outline-none" placeholder="مثلاً: iPhone 15 Pro" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الاسم (بالعربية)</label>
                <input type="text" name="name_ar" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-purple-500 outline-none" placeholder="مثلاً: ايفون 15 برو" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">السعر الحالي (€)</label>
                <input type="number" step="0.01" name="price" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-purple-500 outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">السعر القديم (اختياري)</label>
                <input type="number" step="0.01" name="old_price" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-purple-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">التصنيف</label>
                <select name="category_id" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-purple-500 outline-none" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">حالة الهاتف</label>
                <select name="condition" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-purple-500 outline-none">
                    <option value="new">جديد (New)</option>
                    <option value="used">مستعمل (Used)</option>
                    <option value="refurbished">مجدد (Refurbished)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الماركة (Brand)</label>
                <input type="text" name="brand" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-purple-500 outline-none" placeholder="مثلاً: Apple">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الكمية المتوفرة (Stock)</label>
                <input type="number" name="stock" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-purple-500 outline-none" value="1" required>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الوصف (German)</label>
                <textarea name="description_de" rows="4" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-purple-500 outline-none" required></textarea>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الوصف (عربي)</label>
                <textarea name="description_ar" rows="4" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-purple-500 outline-none" required></textarea>
            </div>
        </div>

        <div class="mt-6 p-4 border-2 border-dashed border-purple-200 rounded-xl bg-purple-50">
            <label class="block text-sm font-bold text-purple-700 mb-2">صور المنتج (يمكنك اختيار أكثر من صورة)</label>
            <input type="file" name="images[]" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-700">
        </div>

        <div class="mt-6 flex gap-6">
            <label class="flex items-center space-x-2 space-x-reverse">
                <input type="checkbox" name="is_active" checked class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                <span class="text-gray-700 font-bold">تفعيل المنتج (نشط)</span>
            </label>
            <label class="flex items-center space-x-2 space-x-reverse">
                <input type="checkbox" name="is_featured" class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                <span class="text-gray-700 font-bold">تمييز المنتج (Featured)</span>
            </label>
        </div>

        <div class="mt-10 flex flex-col md:flex-row gap-4">
            <button type="submit" class="flex-1 bg-purple-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-purple-700 transition duration-300">
                حفظ المنتج ونشره
            </button>
            <a href="{{ route('admin.dashboard') }}" class="flex-1 bg-gray-100 text-gray-600 font-bold py-4 rounded-xl text-center hover:bg-gray-200 transition duration-300">
                إلغاء والعودة
            </a>
        </div>
    </form>
</div>

</body>
</html>
