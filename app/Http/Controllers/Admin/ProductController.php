<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Product::with(['category', 'primaryImage']);

        // 1. منطق البحث (ابحث بالاسم أو الكود)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_de', 'like', '%' . $search . '%')
                    ->orWhere('name_ar', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
            });
        }

        // 2. فحص إذا كان المستخدم ضغط على زر "منتجات بدون صور"
        if ($request->has('no_image')) {
            // نجلب كل المنتجات للفحص (بناءً على نظام الأكواد والصور لديك)
            $allProducts = Product::select('id', 'code')->get();
            $idsWithoutImages = [];

            foreach ($allProducts as $product) {
                // نتحقق من وجود الصورة في مجلد public/images
                $imageExists = false;
                // أضفت 'JPG' بحروف كبيرة لتفادي مشاكل حساسية الأحرف في بعض السيرفرات
                $extensions = ['jpg', 'JPG', 'jpeg', 'png', 'webp'];

                foreach ($extensions as $ext) {
                    if (file_exists(public_path("images/{$product->code}.{$ext}"))) {
                        $imageExists = true;
                        break;
                    }
                }

                if (!$imageExists) {
                    $idsWithoutImages[] = $product->id;
                }
            }

            // نقيد الاستعلام بالمنتجات التي لم نجد لها صوراً
            $query->whereIn('id', $idsWithoutImages);
        }

        // 3. تنفيذ الاستعلام مع الترقيم والحفاظ على معاملات الرابط (مثل no_image=1 و search)
        $products = $query->latest()->paginate(20)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name_de' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_de' => 'required|string',
            'description_ar' => 'required|string',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'condition' => 'required|in:new,used,refurbished',
            'brand' => 'nullable|string|max:100',
            'stock' => 'required|integer|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $validated['code'] = 'PRD-' . strtoupper(Str::random(8));
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        $product = Product::create($validated);

        // رفع الصور
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'order' => $index,
                    'is_primary' => $index === 0
                ]);
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'تم إضافة المنتج بنجاح');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name_de' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_de' => 'required|string',
            'description_ar' => 'required|string',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'condition' => 'required|in:new,used,refurbished',
            'brand' => 'nullable|string|max:100',
            'stock' => 'required|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');


        $product->update($validated);

        // رفع صور جديدة
        if ($request->hasFile('images')) {
            $lastOrder = $product->images()->max('order') ?? -1;

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'order' => $lastOrder + $index + 1,
                    'is_primary' => false
                ]);
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'تم تحديث المنتج بنجاح');
    }

    public function destroy(Product $product)
    {
        // حذف الصور
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'تم حذف المنتج بنجاح');
    }
}
