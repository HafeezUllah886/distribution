<?php

namespace Database\Seeders;

use App\Models\units;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class unitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        units::create(
            [
                'name' => 'Nos',
                'sym' => 'pc',
                'value' => 1,
            ]
        );
    }
}
