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
            //Plugin :-
            'Plugin View',
            //PUGIN ACTION  :-
            'Install Plugin Tab',
            'Plugin List Tab',
            'Upload Plugin',
            'Download Plugin',
            'Plugin Search',
            //Themes :-
            'Themes View',
            'Install Themes Tab',
            'Themes List Tab',
            'Upload Themes',
            'Download Themes',
            'Themes Search',

            'Version View',
            //Plugin Categories :-
            'ADD Plugin Categories View',
            'Plugin Categories Create',
            'Plugin Categories Update',
            'Plugin Categories Delete',
            //Setting :-
            'Setting Menu',
            //SMTP :-
            'SMTP View',
            'SMTP Create',

            'SMTP Delete',
            //Site Setting :-
            'Site Setting View',
            'Site Setting Create',
            // Manage Users
            'Manage Users View',
            'Manage Users Create',
            'Manage Users Update',
            'Manage Users Delete',
            //PAYMENT Settings
            'PAYMENT Settings Menu',
            //PAYMENT Configuration : 
            'Payment Configuration View',
            'PAYMENT Configuration Create',
            'PAYMENT Configuration Delete',
            //PAYMENT History : 
            'Payment History View',
            //View Subscription : 
            'View Subscription View',
            // Plan
            'Add Plan View',
            'Add Plan Create',
            'Add Plan Delete',
            // ALL SITES
            'ALL SITES Menu',
            //Permission Menu
            'Permission Menu',
            //Add Permission
            'Add Permission View',
            'Add Permission Create',
            'Add Permission Update',
            'Add Permission Delete',
            //Manage Role
            'Manage Role View',
            'Manage Role Create',
            'Manage Role Update',
            'Manage Role Delete',


        ];

        foreach ($menuPermissions as $permission) {
            PermissionsModel::create([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}