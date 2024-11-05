<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Sourabh',
                'email' => 'sourabhsj@walstartechnologies.com',
                'email_verified_at' => now(), 
                'password' => Hash::make('password123'), 
                'remember_token' => Str::random(10), 
                'created_at' => now(),
                'updated_at' => now(),
                'role_id' => 1, 
            ],
            [
                'name' => 'User',
                'email' => 'user@domain.com',
                'email_verified_at' => null, 
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'role_id' => 3, 
            ],
        ]);
    }
}
