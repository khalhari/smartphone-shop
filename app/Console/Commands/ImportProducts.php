<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;

class ImportProducts extends Command
{
    protected $signature = 'products:import';
    protected $description = 'Import all products from data file';

    public function handle()
    {
        // نسخ البيانات هنا
        $this->info('Importing products...');

        // ... الكود

        $this->info('✅ Products imported successfully!');
    }
}
