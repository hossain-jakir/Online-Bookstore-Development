<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data for tags
        $tags = [
            ['name' => 'fiction', 'slug' => 'fiction'],
            ['name' => 'adventure', 'slug' => 'adventure'],
            ['name' => 'non-fiction', 'slug' => 'non-fiction'],
            ['name' => 'facts', 'slug' => 'facts'],
            ['name' => 'science', 'slug' => 'science'],
            ['name' => 'universe', 'slug' => 'universe'],
            ['name' => 'history', 'slug' => 'history'],
            ['name' => 'civilization', 'slug' => 'civilization'],
            ['name' => 'fantasy', 'slug' => 'fantasy'],
            ['name' => 'magic', 'slug' => 'magic'],
            ['name' => 'biography', 'slug' => 'biography'],
            ['name' => 'legends', 'slug' => 'legends'],
            ['name' => 'sports', 'slug' => 'sports'],
            ['name' => 'strategies', 'slug' => 'strategies'],
            ['name' => 'self-help', 'slug' => 'self-help'],
            ['name' => 'personal-growth', 'slug' => 'personal-growth'],
            ['name' => 'cooking', 'slug' => 'cooking'],
            ['name' => 'recipes', 'slug' => 'recipes'],
            ['name' => 'travel', 'slug' => 'travel'],
            ['name' => 'destinations', 'slug' => 'destinations'],
        ];

        // Insert records into the tags table
        DB::table('tags')->insert($tags);
    }
}
