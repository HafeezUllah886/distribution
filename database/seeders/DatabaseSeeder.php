<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\products;
use App\Models\units;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(usersSeeder::class);
        $this->call(accountsSeeder::class);
        $this->call(unitSeeder::class);
        $this->call(productSeeder::class);
        $this->call(salesmanSeeder::class);
        $this->call(orderbookerSeeder::class);
    }
}
