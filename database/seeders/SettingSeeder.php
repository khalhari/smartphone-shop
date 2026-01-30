<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'whatsapp_number', 'value' => '491633617202', 'type' => 'text'],
            ['key' => 'shop_name_de', 'value' => 'SmartPhone Shop', 'type' => 'text'],
            ['key' => 'shop_name_ar', 'value' => 'متجر الهواتف الذكية', 'type' => 'text'],
            ['key' => 'contact_email', 'value' => 'info@smartphone-shop.de', 'type' => 'text'],
            ['key' => 'shop_phone', 'value' => '+49 123 456 7890', 'type' => 'text'],
            ['key' => 'shop_address', 'value' => 'Kiel, Deutschland', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }

        $this->command->info('✅ تم إنشاء الإعدادات بنجاح!');
    }
}
