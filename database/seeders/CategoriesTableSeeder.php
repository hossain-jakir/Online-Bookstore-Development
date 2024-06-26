<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Fiction',
                'slug' => Str::slug('category/fiction'),
                'description' => 'Books that contain fictional stories and events.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Non-Fiction',
                'slug' => Str::slug('category/Non-Fiction'),
                'description' => 'Books that are based on factual information.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Science',
                'slug' => Str::slug('category/Science'),
                'description' => 'Books that cover scientific topics and knowledge.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'History',
                'slug' => Str::slug('category/History'),
                'description' => 'Books that explore historical events and figures.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Fantasy',
                'slug' => Str::slug('category/Fantasy'),
                'description' => 'Books that contain fantastical and mythical elements.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Biography',
                'slug' => Str::slug('category/Biography'),
                'description' => 'Books that tell the life stories of real people.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Sports',
                'slug' => Str::slug('category/Sports'),
                'description' => 'Books that focus on sports and athletic activities.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Self-Help',
                'slug' => Str::slug('category/Self-Help'),
                'description' => 'Books that provide guidance and advice on personal development.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Cooking',
                'slug' => Str::slug('category/Cooking'),
                'description' => 'Books that contain recipes and cooking tips.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Travel',
                'slug' => Str::slug('category/Travel'),
                'description' => 'Books that focus on travel destinations and experiences.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Art',
                'slug' => Str::slug('category/Art'),
                'description' => 'Books that explore artistic techniques and styles.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Music',
                'slug' => Str::slug('category/Music'),
                'description' => 'Books that cover musical genres and history.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Poetry',
                'slug' => Str::slug('category/Poetry'),
                'description' => 'Books that contain poems and verse.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Health',
                'slug' => Str::slug('category/Health'),
                'description' => 'Books that focus on physical and mental well-being.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Business',
                'slug' => Str::slug('category/Business'),
                'description' => 'Books that cover business strategies and practices.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Technology',
                'slug' => Str::slug('category/Technology'),
                'description' => 'Books that explore technological advancements and innovations.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
