<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'admin@gmail.com',
                'phone' => '1234567890',
                'image' => '',
                'dob' => Carbon::parse('1990-01-01'),
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('pass'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'user@gmail.com',
                'phone' => '0987654321',
                'image' => '',
                'dob' => Carbon::parse('1985-05-15'),
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('pass'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Emily',
                'last_name' => 'Brown',
                'email' => 'emily@gmail.com',
                'phone' => '1122334455',
                'image' => '',
                'dob' => Carbon::parse('1992-04-22'),
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('pass'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'email' => 'michael@gmail.com',
                'phone' => '2233445566',
                'image' => '',
                'dob' => Carbon::parse('1988-11-03'),
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('pass'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Williams',
                'email' => 'sarah@gmail.com',
                'phone' => '3344556677',
                'image' => '',
                'dob' => Carbon::parse('1995-08-10'),
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('pass'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Jones',
                'email' => 'david@gmail.com',
                'phone' => '4455667788',
                'image' => '',
                'dob' => Carbon::parse('1982-06-15'),
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('pass'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Laura',
                'last_name' => 'Miller',
                'email' => 'laura@gmail.com',
                'phone' => '5566778899',
                'image' => '',
                'dob' => Carbon::parse('1989-12-25'),
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('pass'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Kevin',
                'last_name' => 'Davis',
                'email' => 'kevin@gmail.com',
                'phone' => '6677889900',
                'image' => '',
                'dob' => Carbon::parse('1993-07-30'),
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('pass'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Anna',
                'last_name' => 'Garcia',
                'email' => 'anna@gmail.com',
                'phone' => '7788990011',
                'image' => '',
                'dob' => Carbon::parse('1996-02-17'),
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('pass'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'James',
                'last_name' => 'Martinez',
                'email' => 'james@gmail.com',
                'phone' => '8899001122',
                'image' => '',
                'dob' => Carbon::parse('1987-09-08'),
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('pass'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Olivia',
                'last_name' => 'Hernandez',
                'email' => 'hernandez@gmail.com',
                'phone' => '9900112233',
                'image' => '',
                'dob' => Carbon::parse('1991-03-20'),
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('pass'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Daniel',
                'last_name' => 'Young',
                'email' => 'young@gamil.com',
                'phone' => '0011223344',
                'image' => '',
                'dob' => Carbon::parse('1984-10-12'),
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('pass'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
