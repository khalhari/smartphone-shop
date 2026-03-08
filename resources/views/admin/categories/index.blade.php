<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">🏷️ إدارة التصنيفات</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8">

            <div class="lg:col-span-4">
                <div class="bg-white p-8 border border-gray-100 shadow-2xl shadow-gray-200/50 rounded-3xl sticky top-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">إضافة تصنيف جديد</h3>
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">اسم التصنيف (DE)</label>
                                <input type="text" name="name_de" placeholder="مثلاً: iPhone Cases" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-200 transition-all shadow-sm" required>
                            </div>
                            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-100 transition-all">
                                حفظ التصنيف
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-8 bg-white border border-gray-100 shadow-2xl shadow-gray-200/50 rounded-3xl overflow-hidden">
                <table class="w-full text-right">
                    <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-8 py-5 text-sm font-bold text-gray-600">اسم التصنيف</th>
                        <th class="px-8 py-5 text-sm font-bold text-gray-600">عدد المنتجات</th>
                        <th class="px-8 py-5 text-sm font-bold text-gray-600 text-center">الإجراء</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @foreach($categories as $category)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-8 py-5 font-bold text-gray-800">{{ $category->name_de }}</td>
                            <td class="px-8 py-5">
                                <span class="bg-blue-50 text-blue-600 text-xs font-bold px-2.5 py-1 rounded-lg">
                                    {{ $category->products_count }} منتجات
                                </span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="text-red-400 hover:text-red-600 font-bold text-sm transition-colors">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
