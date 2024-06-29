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
                'slug' => 'category/'.Str::slug('fiction'),
                'description' => 'Books that contain fictional stories and events.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Non-Fiction',
                'slug' => 'category/'.Str::slug('Non-Fiction'),
                'description' => 'Books that are based on factual information.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Science',
                'slug' => 'category/'.Str::slug('Science'),
                'description' => 'Books that cover scientific topics and knowledge.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'History',
                'slug' => 'category/'.Str::slug('History'),
                'description' => 'Books that explore historical events and figures.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Fantasy',
                'slug' => 'category/'.Str::slug('Fantasy'),
                'description' => 'Books that contain fantastical and mythical elements.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Biography',
                'slug' => 'category/'.Str::slug('Biography'),
                'description' => 'Books that tell the life stories of real people.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Sports',
                'slug' => 'category/'.Str::slug('Sports'),
                'description' => 'Books that focus on sports and athletic activities.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Self-Help',
                'slug' => 'category/'.Str::slug('Self-Help'),
                'description' => 'Books that provide guidance and advice on personal development.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Cooking',
                'slug' => 'category/'.Str::slug('Cooking'),
                'description' => 'Books that contain recipes and cooking tips.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Travel',
                'slug' => 'category/'.Str::slug('Travel'),
                'description' => 'Books that focus on travel destinations and experiences.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Art',
                'slug' => 'category/'.Str::slug('Art'),
                'description' => 'Books that explore artistic techniques and styles.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Music',
                'slug' => 'category/'.Str::slug('Music'),
                'description' => 'Books that cover musical genres and history.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Poetry',
                'slug' => 'category/'.Str::slug('Poetry'),
                'description' => 'Books that contain poems and verse.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Health',
                'slug' => 'category/'.Str::slug('Health'),
                'description' => 'Books that focus on physical and mental well-being.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Business',
                'slug' => 'category/'.Str::slug('Business'),
                'description' => 'Books that cover business strategies and practices.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Technology',
                'slug' => 'category/'.Str::slug('Technology'),
                'description' => 'Books that explore technological advancements and innovations.',
                'status' => 'active',
                'isDeleted' => 'no',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
