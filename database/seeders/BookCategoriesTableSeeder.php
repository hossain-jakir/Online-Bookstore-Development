<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookCategories = [
            // Fiction category
            ['book_id' => 1, 'category_id' => 1], // Adventures in Fiction
            ['book_id' => 5, 'category_id' => 5], // Magical Realms

            // Non-Fiction category
            ['book_id' => 2, 'category_id' => 2], // The World of Facts

            // Science category
            ['book_id' => 3, 'category_id' => 3], // Discovering the Universe

            // History category
            ['book_id' => 4, 'category_id' => 4], // History of Civilizations

            // Biography category
            ['book_id' => 6, 'category_id' => 6], // Life of Legends

            // Sports category
            ['book_id' => 7, 'category_id' => 7], // Winning Spirit

            // Self-Help category
            ['book_id' => 8, 'category_id' => 8], // The Path to Success

            // Cooking category
            ['book_id' => 9, 'category_id' => 9], // Culinary Delights

            // Travel category
            ['book_id' => 10, 'category_id' => 10], // Wanderlust Adventures
        ];

        // Insert records into the book_categories table
        DB::table('book_categories')->insert($bookCategories);
    }
}
