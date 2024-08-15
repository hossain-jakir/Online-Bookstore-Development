<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'name' => 'United Kingdom',
                'currency' => 'Pound',
                'currency_symbol' => '£',
                'phone_code' => '+44',
                'flag' => null,
            ],
        ];

        DB::table('countries')->insert($countries);
    }
}
