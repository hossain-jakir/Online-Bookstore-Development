<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryFeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('delivery_fees')->insert([
            [
                'name' => 'Standard Delivery',
                'price' => 2.00,
                'description' => 'Standard delivery takes 3-5 business days.',
                'default' => 1, // Set as default delivery fee
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Express Delivery',
                'price' => 5.00,
                'description' => 'Express delivery takes 1-2 business days.',
                'default' => 0, // Not the default delivery fee
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Overnight Delivery',
                'price' => 10.00,
                'description' => 'Overnight delivery takes 1 business day.',
                'default' => 0, // Not the default delivery fee
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
