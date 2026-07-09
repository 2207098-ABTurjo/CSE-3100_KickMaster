<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// Ei seeder default admin ar kichu normal user create kore
class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account - viva te login kore dekhano jabe
        User::create([
            'name' => 'Admin',
            'email' => 'admin@kickmaster.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Kichu normal user create kora hocche
        User::create([
            'name' => 'John Doe',
            'email' => 'user@kickmaster.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::factory(8)->create();
    }
}