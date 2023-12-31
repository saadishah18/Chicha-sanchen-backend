<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            ['fname' => 'John','lname' => 'Doe', 'email' => 'john@example.com', 'password' => Hash::make('password')],
            // ... Add more records ...
            ['fname' => 'Jane','lname' => 'Doe', 'email' => 'jane@example.com', 'password' => Hash::make('password')]
            // Repeat this pattern for 10 users
        ]);
    }
}
