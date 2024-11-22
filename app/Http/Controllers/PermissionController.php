<?php

namespace App\Http\Controllers;

use App\Models\PermissionsModel;
use Illuminate\Http\Request;

class PermissionController extends Controller
{


    public function index()
    {


        return view('pages.permissions');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'guard_name' => 'required',
        ]);

        $data = PermissionsModel::create($validatedData);
        return redirect()->back()->with('success', 'Permission added successfully!');
    }

    public function getpermission()
    {

        $data = PermissionsModel::all();
        return response()->json(['data' => $data]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'guard_name' => 'required|string|max:255',
        ]);

        $permission = PermissionsModel::find($id);

        if (!$permission) {
            return response()->json(['success' => false, 'message' => 'Permission not found'], 404);
        }

        $permission->name = $request->name;
        $permission->guard_name = $request->guard_name;
        $permission->save();

        return response()->json(['success' => true, 'message' => 'Permission updated successfully']);
    }

    public function destroy($id)
    {
        // Find the permission by ID
        $permission = PermissionsModel::find($id);

        // If permission not found, return error
        if (!$permission) {
            return response()->json(['success' => false, 'message' => 'Permission not found'], 404);
        }

        // Delete the permission
        $permission->delete();

        // Return success response
        return response()->json(['success' => true, 'message' => 'Permission deleted successfully']);
    }
}
