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
            ['name' => 'fiction', 'slug' => 'tag/fiction'],
            ['name' => 'adventure', 'slug' => 'tag/adventure'],
            ['name' => 'non-fiction', 'slug' => 'tag/non-fiction'],
            ['name' => 'facts', 'slug' => 'tag/facts'],
            ['name' => 'science', 'slug' => 'tag/science'],
            ['name' => 'universe', 'slug' => 'tag/universe'],
            ['name' => 'history', 'slug' => 'tag/history'],
            ['name' => 'civilization', 'slug' => 'tag/civilization'],
            ['name' => 'fantasy', 'slug' => 'tag/fantasy'],
            ['name' => 'magic', 'slug' => 'tag/magic'],
            ['name' => 'biography', 'slug' => 'tag/biography'],
            ['name' => 'legends', 'slug' => 'tag/legends'],
            ['name' => 'sports', 'slug' => 'tag/sports'],
            ['name' => 'strategies', 'slug' => 'tag/strategies'],
            ['name' => 'self-help', 'slug' => 'tag/self-help'],
            ['name' => 'personal-growth', 'slug' => 'tag/personal-growth'],
            ['name' => 'cooking', 'slug' => 'tag/cooking'],
            ['name' => 'recipes', 'slug' => 'tag/recipes'],
            ['name' => 'travel', 'slug' => 'tag/travel'],
            ['name' => 'destinations', 'slug' => 'tag/destinations'],
        ];

        // Insert records into the tags table
        DB::table('tags')->insert($tags);
    }
}
