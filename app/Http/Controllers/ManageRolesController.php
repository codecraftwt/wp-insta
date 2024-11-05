<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;


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

        $request->validate([
            'name' => 'required|string|unique:roles,name|max:255',
        ]);


        Role::create([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Role added successfully']);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id . '|max:255',
        ]);


        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Role updated successfully']);
    }

    public function destroy($id)
    {

        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully']);
    }
}
