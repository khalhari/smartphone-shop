<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name_de' => 'Smartphones',
                'name_ar' => 'الهواتف الذكية',
                'slug' => 'smartphones',
                'icon' => 'fa-mobile-alt',
                'order' => 1,
                'is_active' => true
            ],
            [
                'name_de' => 'Zubehör',
                'name_ar' => 'الإكسسوارات',
                'slug' => 'accessories',
                'icon' => 'fa-plug',
                'order' => 2,
                'is_active' => true
            ],
            [
                'name_de' => 'Ladegeräte',
                'name_ar' => 'الشواحن',
                'slug' => 'chargers',
                'icon' => 'fa-charging-station',
                'order' => 3,
                'is_active' => true
            ],
            [
                'name_de' => 'Smart Watches',
                'name_ar' => 'الساعات الذكية',
                'slug' => 'smartwatches',
                'icon' => 'fa-watch',
                'order' => 4,
                'is_active' => true
            ],
            [
                'name_de' => 'Kopfhörer',
                'name_ar' => 'السماعات',
                'slug' => 'headphones',
                'icon' => 'fa-headphones',
                'order' => 5,
                'is_active' => true
            ],
            [
                'name_de' => 'Handyhüllen',
                'name_ar' => 'أغطية الهواتف',
                'slug' => 'cases',
                'icon' => 'fa-mobile-screen',
                'order' => 6,
                'is_active' => true
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✅ تم إنشاء التصنيفات بنجاح!');
    }
}
