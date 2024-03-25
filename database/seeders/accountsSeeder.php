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
                'category' => 'Business',
            ]
        );
        account::create(
            [
                'name' => 'Cheque',
                'type' => 'Cheque',
                'category' => 'Business',
            ]
        );
        account::create(
            [
                'name' => 'Bank',
                'type' => 'Bank',
                'category' => 'Business',
            ]
        );
        account::create(
            [
                'name' => 'Vendor',
                'category' => 'Vendor',
                'b_name' => 'Vendor Business Name',
                'contact' => '0123-1111222',
                'address' => 'Abc City'
            ]
        );
        account::create(
            [
                'name' => 'Customer',
                'category' => 'Customer',
                'b_name' => 'Customer Business Name',
                'cnic' => '11111-1111111-1',
                'contact' => '0123-1111222',
                'address' => 'Abc City',
                'ntn' => '12345',
                'strn' => '12345',
                'channel' => 'Retailer',
            ]
        );
        account::create(
            [
                'name' => 'FST',
                'category' => 'Others',
            ]
        );
        account::create(
            [
                'name' => 'Slab',
                'category' => 'Others',
            ]
        );
        account::create(
            [
                'name' => 'Deal',
                'category' => 'Others',
            ]
        );
        account::create(
            [
                'name' => 'Delivery Charges',
                'category' => 'Others',
            ]
        );
    }
}
