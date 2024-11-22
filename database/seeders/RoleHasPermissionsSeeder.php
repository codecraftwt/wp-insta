<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PermissionsModel;
use Illuminate\Support\Facades\DB;

class RoleHasPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Get all permissions
        $permissions = PermissionsModel::all();

        // Loop through each permission and assign to role_id = 1
        foreach ($permissions as $permission) {
            // Ensure only role_id = 1
            DB::table('role_has_permissions')->insert([
                'role_id' => 1, // Ensuring role_id = 1
                'permission_id' => $permission->id,
            ]);
        }
    }
}
