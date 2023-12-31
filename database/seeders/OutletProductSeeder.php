<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Outlet;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OutletProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product_ids = Product::pluck('id');
        $addon_ids = Outlet::pluck('id');

        foreach ($product_ids as $product_id) {
            foreach ($addon_ids as $addon_id) {
                DB::table('product_outlets')->insert([
                    'product_id' => $product_id,
                    'outlet_id' => $addon_id
                ]);
            }
        }
    }
}
