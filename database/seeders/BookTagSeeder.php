<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data for book_tags
        $bookTags = [
            ['book_id' => 1, 'tag_id' => 1],   // Adventures in Fiction: fiction
            ['book_id' => 1, 'tag_id' => 2],   // Adventures in Fiction: adventure

            ['book_id' => 2, 'tag_id' => 3],   // The World of Facts: non-fiction
            ['book_id' => 2, 'tag_id' => 4],   // The World of Facts: facts

            ['book_id' => 3, 'tag_id' => 5],   // Discovering the Universe: science
            ['book_id' => 3, 'tag_id' => 6],   // Discovering the Universe: universe

            ['book_id' => 4, 'tag_id' => 7],   // History of Civilizations: history
            ['book_id' => 4, 'tag_id' => 8],   // History of Civilizations: civilization

            ['book_id' => 5, 'tag_id' => 1],   // Magical Realms: fiction
            ['book_id' => 5, 'tag_id' => 9],   // Magical Realms: fantasy

            ['book_id' => 6, 'tag_id' => 10],  // Life of Legends: biography
            ['book_id' => 6, 'tag_id' => 11],  // Life of Legends: legends

            ['book_id' => 7, 'tag_id' => 12],  // Winning Spirit: sports
            ['book_id' => 7, 'tag_id' => 13],  // Winning Spirit: strategies

            ['book_id' => 8, 'tag_id' => 14],  // The Path to Success: self-help
            ['book_id' => 8, 'tag_id' => 15],  // The Path to Success: personal-growth

            ['book_id' => 9, 'tag_id' => 16],  // Culinary Delights: cooking
            ['book_id' => 9, 'tag_id' => 17],  // Culinary Delights: recipes

            ['book_id' => 10, 'tag_id' => 18], // Wanderlust Adventures: travel
            ['book_id' => 10, 'tag_id' => 19], // Wanderlust Adventures: destinations
        ];

        // Insert records into the book_tags table
        DB::table('book_tags')->insert($bookTags);
    }
}
