<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ManageUsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('manage_users_table')->insert([
            [
                'user_id' => 1,
                'phone' => '9876543210',
                'address' => 'USA',

                'company_name' => 'Walstar',
                'subscription_status' => 1,
                'subscription_type' => 'Pro',
                'start_date' => '2024-12-01',
                'end_date' => '2025-12-31',
                'status' => '1',
                'duration' => 'year',
                'no_sites' => '500000',
                'storage' => '500000',

            ],
            [
                'user_id' => 2,
                'phone' => '9876543210',
                'address' => 'USA',

                'company_name' => 'TCS',
                'subscription_status' => 1,
                'subscription_type' => 'Pro',
                'start_date' => '2024-12-01',
                'end_date' => '2025-12-31',
                'status' => '1',
                'duration' => 'month',
                'no_sites' => '500000',
                'storage' => '500000',
            ],

        ]);
    }
}