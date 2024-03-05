<?php

namespace Database\Seeders;

use App\Models\orderbooker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class orderbookerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        orderbooker::create(
            [
                'name' => 'Test Order Booker',
                'contact' => '0312-34567890',
            ]
        );
    }
}
