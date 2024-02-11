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
            [
                'fname' => 'admin',
                'lname' => 'super',
                'email' => 'admin@domain.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin'
            ],
        ]);
    }
}
