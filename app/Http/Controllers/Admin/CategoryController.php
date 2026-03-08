<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->orderBy('order')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_de' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories',
            'icon' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'تم إضافة التصنيف بنجاح');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name_de' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug,' . $category->id,
            'icon' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'تم تحديث التصنيف بنجاح');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'لا يمكن حذف تصنيف يحتوي على منتجات');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'تم حذف التصنيف بنجاح');
    }
}
