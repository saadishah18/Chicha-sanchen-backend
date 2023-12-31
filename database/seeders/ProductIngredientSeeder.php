<?php

namespace Database\Seeders;

use App\Models\AddOn;
use App\Models\Ingredient;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product_ids = Product::pluck('id');
        $addon_ids = Ingredient::pluck('id');

        foreach ($product_ids as $product_id) {
            foreach ($addon_ids as $addon_id) {
                DB::table('product_ingredients')->insert([
                    'product_id' => $product_id,
                    'ingredient_id' => $addon_id
                ]);
            }
        }
    }
}
