<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API Routes للمنتجات (اختياري)
Route::prefix('v1')->group(function () {
    Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index']);
    Route::get('/products/{product}', [\App\Http\Controllers\ProductController::class, 'show']);
});
