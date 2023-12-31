<?php

namespace Database\Seeders;

use App\Models\AddOn;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddOnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AddOn::insert([
            ['name' => 'Whipped Cream', 'price' => 0.50],
            // ... Add more records ...
            ['name' => 'Extra Cheese', 'price' => 1.00]
            // Repeat this pattern for 10 add-ons
        ]);
    }
}
