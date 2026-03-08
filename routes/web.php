<?php

use App\Http\Controllers\ProductController as PublicProductController;
use App\Http\Controllers\Admin\DashboardController; // استيراد متحكم لوحة التحكم الجديدة
use App\Http\Controllers\Admin\ProductController as adminProductController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// --- 1. مسارات المتجر (للجميع) ---
Route::get('/', [PublicProductController::class, 'index'])->name('home'); // إضافة name('home') لأن الكود يطلبه
Route::get('/shop', [PublicProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [PublicProductController::class, 'show'])->name('products.show');
Route::get('lang/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// --- 2. مسارات المستخدمين العادية (Profile & Default Dashboard) ---
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- 3. مسارات الإدارة (Admin Dashboard) ---
// ملاحظة: يمكنك لاحقاً إضافة Middleware مخصص للـ Admin هنا
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // الرابط الأساسي للوحة التحكم الجديدة
     Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // استخدام Route::resource هو الخيار الأفضل لأنه يغطي (index, create, store, edit, update, destroy) تلقائياً
    // ولكن بما أنك تريد تخصيص الأسماء لتطابق التصميم، سنستخدم الطريقة التفصيلية:

    Route::get('/products', [adminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [adminProductController::class, 'create'])->name('admin.products.create');

    // سطر مهم جداً لمعالجة عملية الحفظ (التي تلي الـ create)
    Route::post('/products', [adminProductController::class, 'store'])->name('admin.products.store');

    Route::get('/products/{product}/edit', [adminProductController::class, 'edit'])->name('admin.products.edit');

    // سطر مهم جداً لمعالجة عملية التحديث (التي تلي الـ edit)
    Route::put('/products/{product}', [adminProductController::class, 'update'])->name('admin.products.update');

    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

    // المسارات الأخرى
    Route::get('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.categories.store');
    Route::delete('/categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');
});

// مسارات المصادقة
require __DIR__.'/auth.php';
