<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_path',
        'order',
        'is_primary'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    // ✅ إضافة Accessor للحصول على URL الصورة
    protected $appends = ['url'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ✅ الطريقة الصحيحة للحصول على رابط الصورة
    public function getUrlAttribute()
    {
        // التحقق من وجود الصورة
        if ($this->image_path && Storage::disk('public')->exists($this->image_path)) {
            return asset('storage/' . $this->image_path);
        }

        // صورة افتراضية إذا لم توجد الصورة
        return asset('images/default-product.png');
    }
}
