<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PluginSeeder; // Add this line

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call other seeders
        $this->call(PaymentSettingSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ManageUsersTableSeeder::class);
        $this->call(PluginCategoriesSeeder::class);
        $this->call(ThemesCategoriesSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(RoleHasPermissionsSeeder::class);
        $this->call(SmtpConfigurationSeeder::class);

        // Call PluginSeeder
        $this->call(PluginSeeder::class);
        $this->call(MembershipPlanSeeder::class);
        $this->call(ThemeSeeder::class);
    }
}
