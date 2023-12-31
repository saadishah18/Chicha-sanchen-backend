<?php

namespace Database\Seeders;

use App\Models\Outlet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutLetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Outlet::insert([
            ['name' => 'Outlet 1', 'address' => '123 Main St',  'latitude' => 40.7128, 'longitude' => -74.0060],
            // ... Add more records ...
            ['OutletName' => 'Outlet 10', 'address' => '789 Oak St',  'latitude' => 51.5074, 'longitude' => -0.1278]
        ]);
    }
}
