<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // تجهيز الإحصائيات المطلوبة في الكود الخاص بك
        $stats = [
            'total_products'   => Product::count(),
            'active_products'  => Product::where('is_active', true)->count(),
            'total_categories' => Category::count(),
            'low_stock'        => Product::where('stock', '<', 10)->count(),
        ];

        // جلب أحدث 5 منتجات للعرض في الجدول
        $recent_products = Product::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_products'));
    }
}
