<?php

namespace Database\Seeders;

use App\Models\account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class accountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        account::create(
            [
                'name' => 'Cash',
                'type' => 'Cash',
                'notes' => 'Auto Generated',
            ]
        );
        account::create(
            [
                'name' => 'ABC Bank',
                'type' => 'Bank',
                'notes' => 'Auto Generated',
            ],
        );
    }
}
