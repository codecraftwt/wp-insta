<?php

namespace App\Http\Controllers;

use App\Models\PermissionsModel;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\RoleHasPermissions;
use Illuminate\Support\Facades\DB;

class ManageRolesController extends Controller
{
    public function index()
    {
        return view("pages.managerole");
    }

    public function getrole()
    {

        $roles = Role::select('id', 'name')->orderBy('id')->get();
        return response()->json(['data' => $roles]);
    }


    public function store(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'role_name' => 'required',
            'permissions' => 'required',  // Permissions as an array
            'permissions.*' => 'exists:permissions,id' // Ensure each permission exists in the permissions table
        ]);

        // Save the new role
        $role = Role::create([
            'name' => $validated['role_name'],
        ]);

        // Save the permissions for the role
        foreach ($validated['permissions'] as $permissionId) {
            RoleHasPermissions::create([
                'role_id' => $role->id,
                'permission_id' => $permissionId,

            ]);
        }

        return redirect()->back()->with('success', 'Role created successfully!');
    }


    public function getrolepermisson()
    {
        $roles = Role::with('permissions')->get();

        return response()->json([
            'data' => $roles->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'guard_name' => $role->guard_name, // Include guard name
                    'permissions' => $role->permissions->pluck('name')->toArray(),
                ];
            }),
        ]);
    }

    public function editepermission()
    {
        // Fetch all permissions and the role with its current permissions
        $roles = Role::with('permissions')->get();

        $allPermissions = PermissionsModel::all(); // Fetch all permissions from PermissionsModel

        return response()->json([
            'data' => $roles->map(function ($role) use ($allPermissions) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'guard_name' => $role->guard_name,
                    'permissions' => $role->permissions->pluck('name')->toArray(),
                    'all_permissions' => $allPermissions->pluck('name', 'id'), // Get all permissions with id and name
                ];
            }),
        ]);
    }
    public function update(Request $request, string $id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Role not found.'
            ], 404);
        }

        // Update role details
        $role->name = $request->name;
        $role->guard_name = $request->guard_name;
        $role->save();

        // Get the selected permissions
        $selectedPermissions = $request->input('permissions', []);

        // Step 1: Delete old permissions for the role
        RoleHasPermissions::where('role_id', $id)->delete();

        // Step 2: Add new selected permissions
        foreach ($selectedPermissions as $permissionId) {
            RoleHasPermissions::create([
                'role_id' => $id,
                'permission_id' => $permissionId,
            ]);
        }

        return response()->json([
            'status' => 'Success',
            'message' => 'Role updated successfully.',
            'data' => $role,
        ], 200);
    }

    public function destroy($role_id)
    {
        try {
            // Begin a transaction to ensure data consistency
            DB::beginTransaction();

            // Find the role by its ID
            $role = Role::find($role_id);

            if (!$role) {
                return response()->json(['success' => false, 'message' => 'Role not found.']);
            }

            // Detach the permissions from the role (this does not delete the permissions)
            $role->permissions()->detach();

            // Now, delete the role
            $role->delete();

            // Commit the transaction
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Role and its permissions deleted successfully.']);
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            return response()->json(['success' => false, 'message' => 'Error deleting role: ' . $e->getMessage()]);
        }
    }
}
