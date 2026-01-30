<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'code',
        'name_de',
        'name_ar',
        'description_de',
        'description_ar',
        'price',
        'old_price',
        'condition',
        'brand',
        'stock',
        'is_featured',
        'is_active',
        'specifications'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'specifications' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function getNameAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : $this->name_de;
    }

    public function getDescriptionAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description_de;
    }

    public function getWhatsappLinkAttribute()
    {
        $phone = setting('whatsapp_number', '491633617202');
        $message = $this->generateWhatsappMessage();
        return "https://wa.me/{$phone}?text=" . urlencode($message);
    }

    private function generateWhatsappMessage()
    {
        $productUrl = route('products.show', $this->id);

        return "مرحباً، أنا مهتم بهذا المنتج:\n\n" .
            "📱 المنتج: {$this->name}\n" .
            "💰 السعر: {$this->price}€\n" .
            "🔢 الكود: {$this->code}\n" .
            "🔗 الرابط: {$productUrl}\n\n" .
            "أرجو التواصل معي.";
    }
}

