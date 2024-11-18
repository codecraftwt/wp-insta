<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PermissionsModel;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // Main menu items
        $menuPermissions = [
            'WP Material Menu',
            //Plugin
            'Plugin View',
            //PUGIN ACTION 
            'Install Plugin Tab',
            'Plugin List Tab',
            'Upload Plugin',
            'Download Plugin',
            'Plugin Search',
            //Themes
            'Themes View',
            'Install Themes Tab',
            'Themes List Tab',
            'Upload Themes',
            'Download Themes',
            'Themes Search',

            'Version View',
            'ADD Plugin Categories View',
            'Plugin Categories Create',
            'Plugin Categories Update',
            'Plugin Categories Delete',
            'Setting Menu',
            'SMTP View',
            'Site Setting View',
            'Manage Users View',
            'PAYMENT Settings Menu',
            'Payment Configuration View',
            'Payment History View',
            'View Subscription View',
            'Add Plan View',
            'ALL SITES Menu',
            'Permission Menu',
            'Add Permission View',
            'Manage Role View',

        ];

        foreach ($menuPermissions as $permission) {
            PermissionsModel::create([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
