<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ingredient::insert([
            ['name' => 'Milk', 'description' => 'Contains lactose'],
            // ... Add more records ...
            ['name' => 'Nuts', 'description' => 'Allergy warning: nuts']
            // Repeat this pattern for 10 ingredients
        ]);
    }
}
