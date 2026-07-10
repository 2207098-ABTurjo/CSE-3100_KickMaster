<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Ei main seeder shob choto seeder ke call kore, order ta important
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TeamSeeder::class,
        ]);
    }
}