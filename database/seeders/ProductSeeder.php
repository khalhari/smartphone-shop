<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * تشغيل الـ Seeder
     */
    public function run(): void
    {
        // الحصول على التصنيفات
        $chargers = Category::where('slug', 'chargers')->first();
        $accessories = Category::where('slug', 'accessories')->first();
        $headphones = Category::where('slug', 'headphones')->first();
        $cases = Category::where('slug', 'cases')->first();

        // إنشاء تصنيف جديد للسماعات إذا لم يكن موجود
        if (!$headphones) {
            $headphones = Category::create([
                'name_de' => 'Kopfhörer',
                'name_ar' => 'السماعات',
                'slug' => 'headphones',
                'icon' => 'fa-headphones',
                'order' => 5,
                'is_active' => true
            ]);
        }

        // إنشاء تصنيف للأغطية إذا لم يكن موجود
        if (!$cases) {
            $cases = Category::create([
                'name_de' => 'Handyhüllen',
                'name_ar' => 'أغطية الهواتف',
                'slug' => 'cases',
                'icon' => 'fa-mobile-screen',
                'order' => 6,
                'is_active' => true
            ]);
        }

        // ========== القسم الأول: الشواحن ==========
        $chargersData = [
            // شواحن 20 وات PD
            [
                'code' => 'XB-4001',
                'name_de' => '20W PD Ladegerät USB-C Weiß',
                'name_ar' => 'شاحن 20 وات PD أبيض',
                'description_de' => 'Schnellladegerät mit USB-C Anschluss, 1m geflochtenes Kabel, US-Stecker',
                'description_ar' => 'شاحن سريع بمنفذ USB-C، كابل مضفر 1 متر، قابس أمريكي',
                'category_id' => $chargers->id,
                'price' => 24.99,
                'condition' => 'new',
                'stock' => 50,
                'image' => 'xb-40013.jpg'
            ],
            [
                'code' => 'XB-4002',
                'name_de' => '20W PD Ladegerät USB-C Weiß',
                'name_ar' => 'شاحن 20 وات PD أبيض',
                'description_de' => 'Schnellladegerät mit USB-C Anschluss, 1m geflochtenes Kabel, US-Stecker',
                'description_ar' => 'شاحن سريع بمنفذ USB-C، كابل مضفر 1 متر، قابس أمريكي',
                'category_id' => $chargers->id,
                'price' => 24.99,
                'condition' => 'new',
                'stock' => 50,
                'image' => 'xb-40013.jpg'
            ],

            // شواحن 20 وات سريعة
            [
                'code' => 'XB-4003',
                'name_de' => '20W Schnellladegerät USB-A+C EU',
                'name_ar' => 'شاحن سريع 20 وات EU',
                'description_de' => 'Dual-Port Ladegerät mit Type-C Kabel, europäischer Stecker',
                'description_ar' => 'شاحن بمنفذين مع كابل Type-C، قابس أوروبي',
                'category_id' => $chargers->id,
                'price' => 19.99,
                'condition' => 'new',
                'stock' => 75,
                'image' => 'xb-40013.jpg'
            ],
            [
                'code' => 'XB-4004',
                'name_de' => '20W Schnellladegerät USB-A+C Lightning EU',
                'name_ar' => 'شاحن سريع 20 وات Lightning EU',
                'description_de' => 'Dual-Port Ladegerät mit Lightning Kabel, europäischer Stecker',
                'description_ar' => 'شاحن بمنفذين مع كابل Lightning، قابس أوروبي',
                'category_id' => $chargers->id,
                'price' => 19.99,
                'condition' => 'new',
                'stock' => 60,
                'image' => 'xb-40013.jpg'
            ],
            [
                'code' => 'XB-4005',
                'name_de' => '20W Schnellladegerät USB-A+C US',
                'name_ar' => 'شاحن سريع 20 وات US',
                'description_de' => 'Dual-Port Ladegerät mit Type-C Kabel, US-Stecker',
                'description_ar' => 'شاحن بمنفذين مع كابل Type-C، قابس أمريكي',
                'category_id' => $chargers->id,
                'price' => 19.99,
                'condition' => 'new',
                'stock' => 60,
                'image' => 'xb-40013.jpg'
            ],
            [
                'code' => 'XB-4006',
                'name_de' => '20W Schnellladegerät USB-A+C Lightning US',
                'name_ar' => 'شاحن سريع 20 وات Lightning US',
                'description_de' => 'Dual-Port Ladegerät mit Lightning Kabel, US-Stecker',
                'description_ar' => 'شاحن بمنفذين مع كابل Lightning، قابس أمريكي',
                'category_id' => $chargers->id,
                'price' => 19.99,
                'condition' => 'new',
                'stock' => 55,
                'image' => 'xb-40013.jpg'
            ],

            // شواحن 45 وات
            [
                'code' => 'XB-4007',
                'name_de' => '45W Schnellladegerät Type-C EU',
                'name_ar' => 'شاحن سريع 45 وات EU',
                'description_de' => 'Ultra-Schnellladegerät Type-C zu Type-C, europäischer Stecker',
                'description_ar' => 'شاحن فائق السرعة Type-C، قابس أوروبي',
                'category_id' => $chargers->id,
                'price' => 34.99,
                'condition' => 'new',
                'stock' => 40,
                'is_featured' => true,
                'image' => 'xb-40013.jpg'
            ],
            [
                'code' => 'XB-4008',
                'name_de' => '45W Schnellladegerät Lightning EU',
                'name_ar' => 'شاحن سريع 45 وات Lightning EU',
                'description_de' => 'Ultra-Schnellladegerät Type-C zu Lightning, europäischer Stecker',
                'description_ar' => 'شاحن فائق السرعة Lightning، قابس أوروبي',
                'category_id' => $chargers->id,
                'price' => 34.99,
                'condition' => 'new',
                'stock' => 40,
                'is_featured' => true,
                'image' => 'xb-40013.jpg'
            ],
            [
                'code' => 'XB-4009',
                'name_de' => '45W Schnellladegerät Type-C US',
                'name_ar' => 'شاحن سريع 45 وات US',
                'description_de' => 'Ultra-Schnellladegerät Type-C zu Type-C, US-Stecker',
                'description_ar' => 'شاحن فائق السرعة Type-C، قابس أمريكي',
                'category_id' => $chargers->id,
                'price' => 34.99,
                'condition' => 'new',
                'stock' => 35,
                'image' => 'xb-40013.jpg'
            ],
            [
                'code' => 'XB-4010',
                'name_de' => '45W Schnellladegerät Lightning US',
                'name_ar' => 'شاحن سريع 45 وات Lightning US',
                'description_de' => 'Ultra-Schnellladegerät Type-C zu Lightning, US-Stecker',
                'description_ar' => 'شاحن فائق السرعة Lightning، قابس أمريكي',
                'category_id' => $chargers->id,
                'price' => 34.99,
                'condition' => 'new',
                'stock' => 35,
                'image' => 'xb-40013.jpg'
            ],

            // شواحن 12 وات
            [
                'code' => 'XB-4011',
                'name_de' => '12W Dual USB Ladegerät US',
                'name_ar' => 'شاحن 12 وات US',
                'description_de' => 'Kompaktes Ladegerät mit 2 USB-A Ports, ABS+PC Material',
                'description_ar' => 'شاحن صغير بمنفذين USB-A، مادة ABS+PC',
                'category_id' => $chargers->id,
                'price' => 14.99,
                'condition' => 'new',
                'stock' => 100,
                'image' => 'xb-40013.jpg'
            ],
            [
                'code' => 'XB-4012',
                'name_de' => '12W Dual USB Ladegerät EU',
                'name_ar' => 'شاحن 12 وات EU',
                'description_de' => 'Kompaktes Ladegerät mit 2 USB-A Ports, ABS+PC Material',
                'description_ar' => 'شاحن صغير بمنفذين USB-A، مادة ABS+PC',
                'category_id' => $chargers->id,
                'price' => 14.99,
                'condition' => 'new',
                'stock' => 100,
                'image' => 'xb-40013.jpg'
            ],

            // شواحن السيارة
            [
                'code' => 'XB-4021',
                'name_de' => 'KFZ-Ladegerät 52.5W',
                'name_ar' => 'شاحن سيارة 52.5 وات',
                'description_de' => 'Auto-Schnellladegerät, 12-24V Eingang, Zigarettenanzünder',
                'description_ar' => 'شاحن سيارة سريع، مدخل 12-24 فولت، ولاعة سجائر',
                'category_id' => $chargers->id,
                'price' => 16.99,
                'condition' => 'new',
                'stock' => 45,
                'image' => 'xb-40013.jpg'
            ],
            [
                'code' => 'XB-4022',
                'name_de' => 'KFZ-Ladegerät 38W',
                'name_ar' => 'شاحن سيارة 38 وات',
                'description_de' => 'Kompaktes Auto-Ladegerät, 12-24V, Zigarettenanzünder',
                'description_ar' => 'شاحن سيارة صغير، 12-24 فولت، ولاعة سجائر',
                'category_id' => $chargers->id,
                'price' => 14.99,
                'condition' => 'new',
                'stock' => 50,
                'image' => 'xb-40013.jpg'
            ],
        ];

        // إدخال الشواحن
        foreach ($chargersData as $data) {
            $this->createProduct($data);
        }

        // ========== القسم الثاني: الإكسسوارات ==========
        $accessoriesData = [
            // بنوك الطاقة الأساسية
            [
                'code' => 'XB-4013',
                'name_de' => 'Powerbank 10000mAh PD 20W',
                'name_ar' => 'باور بانك 10000 ميلي أمبير',
                'description_de' => 'Kompakte Powerbank mit 20W PD und QC 22.5W Schnellladung',
                'description_ar' => 'باور بانك صغير مع شحن سريع 20 وات',
                'category_id' => $accessories->id,
                'price' => 29.99,
                'condition' => 'new',
                'stock' => 80,
                'is_featured' => true,
                'image' => 'xb-40013.jpg',
                'specifications' => [
                    'capacity' => '10000mAh',
                    'output' => '20W PD + QC 22.5W',
                    'input' => 'Type-C'
                ]
            ],
            [
                'code' => 'XB-4014',
                'name_de' => 'Powerbank 20000mAh PD 20W',
                'name_ar' => 'باور بانك 20000 ميلي أمبير',
                'description_de' => 'Hochkapazitäts-Powerbank mit 20W PD und QC 22.5W',
                'description_ar' => 'باور بانك عالي السعة مع شحن سريع 20 وات',
                'category_id' => $accessories->id,
                'price' => 39.99,
                'condition' => 'new',
                'stock' => 70,
                'is_featured' => true,
                'image' => 'xb-40013.jpg',
                'specifications' => [
                    'capacity' => '20000mAh',
                    'output' => '20W PD + QC 22.5W'
                ]
            ],
            [
                'code' => 'XB-4015',
                'name_de' => 'Powerbank 20000mAh Dual Port',
                'name_ar' => 'باور بانك 20000 مزدوج المنافذ',
                'description_de' => 'Powerbank mit Dual USB-A und Type-C Anschlüssen',
                'description_ar' => 'باور بانك بمنفذين USB-A و Type-C',
                'category_id' => $accessories->id,
                'price' => 39.99,
                'condition' => 'new',
                'stock' => 65,
                'image' => 'xb-40013.jpg'
            ],

            // بنوك الطاقة المتقدمة
            [
                'code' => 'XB-4520',
                'name_de' => 'Premium Powerbank 10000mAh Wireless',
                'name_ar' => 'باور بانك بريميوم لاسلكي',
                'description_de' => 'Kabelloses 15W Laden, 3-in-1 Kabel, Ständer, Magnetisch',
                'description_ar' => 'شحن لاسلكي 15 وات، كابل 3 في 1، حامل، مغناطيسي',
                'category_id' => $accessories->id,
                'price' => 49.99,
                'old_price' => 59.99,
                'condition' => 'new',
                'stock' => 30,
                'is_featured' => true,
                'image' => 'xb-40013.jpg'
            ],
            [
                'code' => 'XB-4521',
                'name_de' => 'Premium Powerbank 10000mAh 5-in-1',
                'name_ar' => 'باور بانك بريميوم 5 في 1',
                'description_de' => 'Super-Schnellladung 22.5W, 5-in-1 Ausgang, großes Display',
                'description_ar' => 'شحن فائق 22.5 وات، مخرج 5 في 1، شاشة كبيرة',
                'category_id' => $accessories->id,
                'price' => 54.99,
                'condition' => 'new',
                'stock' => 25,
                'is_featured' => true,
                'image' => 'xb-40013.jpg'
            ],
            [
                'code' => 'XB-4522',
                'name_de' => 'Premium Powerbank 20000mAh 4-in-1',
                'name_ar' => 'باور بانك بريميوم 20000',
                'description_de' => 'Super-Schnellladung 22.5W, 4-in-1 Ausgang, großes Display',
                'description_ar' => 'شحن فائق 22.5 وات، مخرج 4 في 1، شاشة كبيرة',
                'category_id' => $accessories->id,
                'price' => 59.99,
                'condition' => 'new',
                'stock' => 20,
                'is_featured' => true,
                'image' => 'xb-40013.jpg'
            ],
        ];

        foreach ($accessoriesData as $data) {
            $this->createProduct($data);
        }

        // سأكمل بقية المنتجات في التعليق التالي...
        // يمكنك إضافة باقي المنتجات بنفس الطريقة

        $this->command->info('✅ تم إضافة المنتجات بنجاح!');
    }

    /**
     * إنشاء منتج مع صورته
     */
    private function createProduct(array $data)
    {
        $image = $data['image'] ?? null;
        unset($data['image']);

        // إنشاء المنتج
        $product = Product::create($data);

        // إضافة الصورة (صورة وهمية للاختبار)
        if ($image) {
            // استخدام صورة placeholder
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'products/placeholder.jpg', // ✅ تغيير المسار
                'order' => 0,
                'is_primary' => true
            ]);
        }

        return $product;
    }
}
