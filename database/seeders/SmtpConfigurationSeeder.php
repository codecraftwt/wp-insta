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
            'mail_host' => 'mail.instantwebsitedevelopment.in',
            'mail_port' => 587,
            'mail_username' => 'ibf@instantwebsitedevelopment.in',
            'mail_password' => 'm!hkScLg&E=d',
            'mail_encryption' => 'tls',
            'mail_from_address' => 'ibf@instantwebsitedevelopment.in',
            'mail_from_name' => 'Walstar_WP',
            'status' => 1,
        ]);
    }
}
