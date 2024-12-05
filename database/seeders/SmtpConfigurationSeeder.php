<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SmtpConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('smpt_setting_table')->insert([
            'mail_mailer' => 'smtp',
            'mail_host' => 'mail.walstartechnologies.com',
            'mail_port' => 465,
            'mail_username' => 'sourabhsj@walstartechnologies.com',
            'mail_password' => 'sourabh@0525',
            'mail_encryption' => 'ssl',
            'mail_from_address' => 'sourabhsj@walstartechnologies.com',
            'mail_from_name' => 'Walstar WP',
            'status' => 1,
        ]);
    }
}
