<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('shops')->insert([
            [
                'name' => 'BookLand',
                'logo' => 'assets/frontend/images/logo.png',
                'favicon' => 'assets/frontend/images/favicon.png',
                'address' => '123 Main Street, Cardiff, Wales, CF10 1AA, UK',
                'phone' => '+44 7311 346877',
                'email' => 'info@bookland.com',
                'tax' => '7.5',
                'latitude' => '51.4835532',
                'longitude' => '-3.1672832',
                'short_description' => 'Bookland is a best and largest online book store. We have a vast collection of books in different categories.',
                'website' => 'https://www.bookland.com',
                'facebook' => 'https://www.facebook.com/bookland',
                'twitter' => 'https://www.twitter.com/bookland',
                'instagram' => 'https://www.instagram.com/bookland',
                'linkedin' => 'https://www.linkedin.com/bookland',
                'whatsapp' => '+1 123 456 7890',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
