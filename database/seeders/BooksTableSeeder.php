<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            [
                'code' => 'FIC001',
                'title' => 'Adventures in Fiction',
                'description' => 'A captivating tale of adventure and fantasy.',
                'author_id' => 11,
                'isbn' => '9781234567890',
                'edition_language' => 'English',
                'publication_date' => Carbon::parse('2022-01-15'),
                'publisher' => 'Fiction House',
                'pages' => 350,
                'lessons' => null,
                'tags' => 'fiction,adventure',
                'rating' => 4.5,
                'min_age' => 10,
                'quantity' => 20,
                'purchase_price' => 12.50,
                'sell_price' => 15.00,
                'discounted_price' => 13.50,
                'discount_type' => 'fixed',
                'image' => 'images/books/fiction1.jpg',
                'availability' => 1,
                'featured' => 1,
                'on_sale' => 1,
                'free_delivery' => 1,
                'status' => 'published',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'NF001',
                'title' => 'The World of Facts',
                'description' => 'An exploration of fascinating facts from around the globe.',
                'author_id' => 12,
                'isbn' => '9782345678901',
                'edition_language' => 'English',
                'publication_date' => Carbon::parse('2022-03-10'),
                'publisher' => 'Knowledge Press',
                'pages' => 220,
                'lessons' => null,
                'tags' => 'non-fiction,facts',
                'rating' => 4.0,
                'min_age' => 12,
                'quantity' => 50,
                'purchase_price' => 8.00,
                'sell_price' => 10.00,
                'discounted_price' => 9.00,
                'discount_type' => 'percentage',
                'image' => 'images/books/non_fiction1.jpg',
                'availability' => 1,
                'featured' => 0,
                'on_sale' => 1,
                'free_delivery' => 0,
                'status' => 'published',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'SCI001',
                'title' => 'Discovering the Universe',
                'description' => 'An in-depth look into the wonders of the cosmos.',
                'author_id' => 3,
                'isbn' => '9783456789012',
                'edition_language' => 'English',
                'publication_date' => Carbon::parse('2022-05-21'),
                'publisher' => 'Science Today',
                'pages' => 300,
                'lessons' => null,
                'tags' => 'science,universe',
                'rating' => 4.8,
                'min_age' => 14,
                'quantity' => 30,
                'purchase_price' => 15.00,
                'sell_price' => 18.00,
                'discounted_price' => 16.50,
                'discount_type' => 'fixed',
                'image' => 'images/books/science1.jpg',
                'availability' => 1,
                'featured' => 1,
                'on_sale' => 1,
                'free_delivery' => 1,
                'status' => 'published',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'HIS001',
                'title' => 'History of Civilizations',
                'description' => 'A comprehensive guide to the rise and fall of civilizations.',
                'author_id' => 4,
                'isbn' => '9784567890123',
                'edition_language' => 'English',
                'publication_date' => Carbon::parse('2022-08-10'),
                'publisher' => 'History Press',
                'pages' => 500,
                'lessons' => null,
                'tags' => 'history,civilization',
                'rating' => 4.7,
                'min_age' => 16,
                'quantity' => 40,
                'purchase_price' => 20.00,
                'sell_price' => 25.00,
                'discounted_price' => 22.00,
                'discount_type' => 'fixed',
                'image' => 'images/books/history1.jpg',
                'availability' => 1,
                'featured' => 1,
                'on_sale' => 1,
                'free_delivery' => 1,
                'status' => 'published',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'FAN001',
                'title' => 'Magical Realms',
                'description' => 'A journey into worlds of magic and wonder.',
                'author_id' => 5,
                'isbn' => '9785678901234',
                'edition_language' => 'English',
                'publication_date' => Carbon::parse('2022-10-15'),
                'publisher' => 'Fantasy Worlds',
                'pages' => 450,
                'lessons' => null,
                'tags' => 'fantasy,magic',
                'rating' => 4.9,
                'min_age' => 10,
                'quantity' => 60,
                'purchase_price' => 18.00,
                'sell_price' => 22.00,
                'discounted_price' => 20.00,
                'discount_type' => 'fixed',
                'image' => 'images/books/fantasy1.jpg',
                'availability' => 1,
                'featured' => 1,
                'on_sale' => 1,
                'free_delivery' => 1,
                'status' => 'published',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'BIO001',
                'title' => 'Life of Legends',
                'description' => 'Biographies of people who shaped history.',
                'author_id' => 6,
                'isbn' => '9786789012345',
                'edition_language' => 'English',
                'publication_date' => Carbon::parse('2022-12-20'),
                'publisher' => 'Biography Today',
                'pages' => 400,
                'lessons' => null,
                'tags' => 'biography,legends',
                'rating' => 4.3,
                'min_age' => 14,
                'quantity' => 70,
                'purchase_price' => 16.00,
                'sell_price' => 20.00,
                'discounted_price' => 18.00,
                'discount_type' => 'fixed',
                'image' => 'images/books/biography1.jpg',
                'availability' => 1,
                'featured' => 1,
                'on_sale' => 1,
                'free_delivery' => 1,
                'status' => 'published',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'SPO001',
                'title' => 'Winning Spirit',
                'description' => 'Stories and strategies from the world of sports.',
                'author_id' => 7,
                'isbn' => '9787890123456',
                'edition_language' => 'English',
                'publication_date' => Carbon::parse('2023-02-15'),
                'publisher' => 'Sports Enthusiast',
                'pages' => 320,
                'lessons' => null,
                'tags' => 'sports,strategies',
                'rating' => 4.2,
                'min_age' => 12,
                'quantity' => 80,
                'purchase_price' => 14.00,
                'sell_price' => 17.00,
                'discounted_price' => 15.00,
                'discount_type' => 'fixed',
                'image' => 'images/books/sports1.jpg',
                'availability' => 1,
                'featured' => 1,
                'on_sale' => 1,
                'free_delivery' => 1,
                'status' => 'published',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'SELF001',
                'title' => 'The Path to Success',
                'description' => 'Guidance and tips on personal growth and development.',
                'author_id' => 8,
                'isbn' => '9788901234567',
                'edition_language' => 'English',
                'publication_date' => Carbon::parse('2023-04-10'),
                'publisher' => 'Self-Help Publishing',
                'pages' => 270,
                'lessons' => null,
                'tags' => 'self-help,personal-growth',
                'rating' => 4.6,
                'min_age' => 16,
                'quantity' => 90,
                'purchase_price' => 12.00,
                'sell_price' => 14.00,
                'discounted_price' => 13.00,
                'discount_type' => 'fixed',
                'image' => 'images/books/self_help1.jpg',
                'availability' => 1,
                'featured' => 1,
                'on_sale' => 1,
                'free_delivery' => 1,
                'status' => 'published',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'COOK001',
                'title' => 'Culinary Delights',
                'description' => 'A collection of recipes from around the world.',
                'author_id' => 9,
                'isbn' => '9789012345678',
                'edition_language' => 'English',
                'publication_date' => Carbon::parse('2023-06-05'),
                'publisher' => 'Culinary Books',
                'pages' => 150,
                'lessons' => null,
                'tags' => 'cooking,recipes',
                'rating' => 4.1,
                'min_age' => 12,
                'quantity' => 100,
                'purchase_price' => 10.00,
                'sell_price' => 12.00,
                'discounted_price' => 11.00,
                'discount_type' => 'fixed',
                'image' => 'images/books/cooking1.jpg',
                'availability' => 1,
                'featured' => 1,
                'on_sale' => 1,
                'free_delivery' => 1,
                'status' => 'published',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'TRAV001',
                'title' => 'Wanderlust Adventures',
                'description' => 'Exploring exotic travel destinations and experiences.',
                'author_id' => 10,
                'isbn' => '9780123456789',
                'edition_language' => 'English',
                'publication_date' => Carbon::parse('2023-08-01'),
                'publisher' => 'Travel Globe',
                'pages' => 240,
                'lessons' => null,
                'tags' => 'travel,destinations',
                'rating' => 4.4,
                'min_age' => 18,
                'quantity' => 110,
                'purchase_price' => 11.00,
                'sell_price' => 13.00,
                'discounted_price' => 12.00,
                'discount_type' => 'fixed',
                'image' => 'images/books/travel1.jpg',
                'availability' => 1,
                'featured' => 1,
                'on_sale' => 1,
                'free_delivery' => 1,
                'status' => 'published',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}