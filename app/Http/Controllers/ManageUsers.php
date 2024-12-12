<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\ManageUser;
use App\Models\Role;

class ManageUsers extends Controller
{

    public function index()
    {
        // Fetch all roles from the database
        $roles = Role::all();

        // Pass the roles to the view using compact
        return view("pages.manage_users", compact('roles'));
    }


    public function storeusers(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:15',
            'address' => 'required',

            'company_name' => 'required|string',

            'subscription_type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'status' => 'required',
            'role_id' => 'required',


        ]);


        $user = User::create([
            'name' => $validatedData['name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role_id' => $validatedData['role_id'],
        ]);


        ManageUser::create([
            'user_id' => $user->id,
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],

            'company_name' => $validatedData['company_name'],

            'subscription_type' => $validatedData['subscription_type'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'status' => $validatedData['status'],
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'User added successfully!');
    }
    public function getusers(Request $request)
    {
        // Get subscription type from the request
        $subscriptionType = $request->input('subscription_type', 'all'); // Default to 'all'

        // Fetch all role IDs from the Role model
        $roleIds = Role::pluck('id')->toArray();

        // Fetch users based on role and subscription type
        $query = User::with('manageUsers')->whereIn('role_id', $roleIds);

        if ($subscriptionType !== 'all') {
            $query->whereHas('manageUsers', function ($query) use ($subscriptionType) {
                $query->where('subscription_type', $subscriptionType);
            });
        }

        $users = $query->get();

        // Ensure the JSON response is well-formed
        return response()->json($users);
    }




    public function updateusers(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable',
            'phone' => 'required',
            'address' => 'required',

            'company_name' => 'required',

            'subscription_type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'status' => 'required',
            'role_id' => 'required',
        ]);

        // Find the user
        $user = User::findOrFail($id);

        // Update user details
        $user->name = $validatedData['name'];
        $user->last_name = $validatedData['last_name'];
        $user->email = $validatedData['email'];
        $user->role_id = $validatedData['role_id'];

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        // Find the related ManageUser entry
        $manageUser = ManageUser::where('user_id', $user->id)->first();
        if (!$manageUser) {
            return response()->json(['error' => 'Manage user not found.'], 404);
        }

        // Update ManageUser details
        $manageUser->phone = $validatedData['phone'];
        $manageUser->address = $validatedData['address'];
        $manageUser->company_name = $validatedData['company_name'];

        $manageUser->subscription_type = $validatedData['subscription_type'];
        $manageUser->start_date = $validatedData['start_date'];
        $manageUser->end_date = $validatedData['end_date'];
        $manageUser->status = $validatedData['status'];

        $manageUser->save(); // Save ManageUser details

        return response()->json(['message' => 'User updated successfully!']);
    }

    public function destroy($id)
    {

        $user = User::findOrFail($id);


        $manageUser = ManageUser::where('user_id', $user->id)->first();


        if ($manageUser) {
            $manageUser->delete();
        }

        $user->delete();

        return response()->json(['message' => 'User and related data deleted successfully!']);
    }
}
