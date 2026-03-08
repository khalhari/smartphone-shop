<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@smartphone-shop.de',
            'password' => Hash::make('password'), // غير هذا!
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ تم إنشاء حساب Admin');
        $this->command->info('📧 Email: admin@smartphone-shop.de');
        $this->command->info('🔑 Password: password');
    }
}
