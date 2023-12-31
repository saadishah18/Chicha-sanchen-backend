<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            ['name' => 'Coffee', 'description' => 'Hot brewed coffee', 'price' => 3.99, 'category_id' => 1,'image' => '34234.jpg'],
            // ... Add more records ...
            ['name' => 'Muffin', 'description' => 'Variety of flavors', 'price' => 1.99, 'category_id' => 2,'image' => '33234.jpg']
        ]);
    }
}
