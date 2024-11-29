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
                'country' => 'USA',
                'state' => 'California',
                'city' => 'Los Angeles',
                'pincode' => '90001',
                'company_name' => 'Walstar',
                'subscription_status' => 1,
                'subscription_type' => 'Premium',
                'start_date' => '2024-12-01',
                'end_date' => '2025-12-31',
                'status' => '1',
                'duration' => 'year',

            ],
            [
                'user_id' => 2,
                'phone' => '9876543210',
                'country' => 'USA',
                'state' => 'California',
                'city' => 'Los Angeles',
                'pincode' => '90001',
                'company_name' => 'TCS',
                'subscription_status' => 1,
                'subscription_type' => 'Premium',
                'start_date' => '2024-12-01',
                'end_date' => '2025-12-31',
                'status' => '1',
                'duration' => 'year',
            ],

        ]);
    }
}
