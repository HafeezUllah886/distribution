<?php

namespace Database\Seeders;

use App\Models\salesman;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class salesmanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        salesman::create(
            [
                'name' => 'Test Sales Man',
                'contact' => '0312-34567890',
            ]
        );
    }
}
