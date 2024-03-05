<?php

namespace Database\Seeders;

use App\Models\products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class productSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        products::create(
            [
                'code' => '7848945',
                'desc' => 'Product 2',
                'tp' => '0',
                'mrp' => '0',
            ]
        );
        products::create(
            [
                'code' => '95452648',
                'desc' => 'Product 3',
                'tp' => '0',
                'mrp' => '0',
            ]
        );
        products::create(
            [
                'code' => '12548648',
                'desc' => 'Product 1',
                'tp' => '0',
                'mrp' => '0',
            ]
        );
    }
}
