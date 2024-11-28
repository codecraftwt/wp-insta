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

        // Assign all permissions to role_id = 1 (admin)
        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')->insert([
                'role_id' => 1, // Admin role
                'permission_id' => $permission->id,
            ]);
        }

        // Assign only 'ALL SITES Menu' permission to role_id = 2 (user)
        $specificPermission = PermissionsModel::where('name', 'ALL SITES Menu')->first();
        if ($specificPermission) {
            DB::table('role_has_permissions')->insert([
                'role_id' => 2, // User role
                'permission_id' => $specificPermission->id,
            ]);
        }
    }
}
