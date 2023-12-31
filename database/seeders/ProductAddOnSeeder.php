<?php

namespace Database\Seeders;

use App\Models\AddOn;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductAddOnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product_ids = Product::pluck('id');
        $addon_ids = AddOn::pluck('id');

        foreach ($product_ids as $product_id) {
            foreach ($addon_ids as $addon_id) {
                DB::table('product_add_ons')->insert([
                    'product_id' => $product_id,
                    'add_on_id' => $addon_id
                ]);
            }
        }
    }
}
