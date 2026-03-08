<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // 1. استخدام query builder
        $query = Product::with(['category']) // شلنا primaryImage لو كنت بتستخدم نظام الصور اللي تكلمنا عنه سابقاً
        ->where('is_active', true);

        // 2. تصفية حسب الفئة (Category Filter)
        if ($request->filled('category')) {
            $categoryParam = $request->category;

            // تحسين: إذا كان الرقم موجوداً، نفلتر مباشرة بالـ ID دون الحاجة لـ whereHas (أسرع للأداء)
            if (is_numeric($categoryParam)) {
                $query->where('category_id', $categoryParam);
            } else {
                $query->whereHas('category', function($q) use ($categoryParam) {
                    $q->where('slug', $categoryParam);
                });
            }
        }

        // 3. منطق البحث (Search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // البحث في الأسماء حسب اللغة أو الكود
                $q->where('name_de', 'like', "%{$search}%")
                    ->orWhere('name_ar', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // 4. الترتيب (Sorting)
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // 5. الحل السحري لمشكلة التنقل (Pagination with Anchors)
        // أضفنا appends و fragment لضمان بقاء المستخدم في نفس المكان عند الانتقال بين الصفحات
        $products = $query->paginate(9) // جعلناها 9 لتناسب تقسيم 3 أعمدة (3x3)
        ->withQueryString()
            ->fragment('products-list');

        $categories = Category::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['category']);

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
