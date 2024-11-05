<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\ManageUser;

class ManageUsers extends Controller
{

    public function index()
    {
        return view("pages.manage_users");
    }


    public function storeusers(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:15',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required|string|max:10',
            'gender' => 'required|string',
            'dob' => 'required',
            'subscription_type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'status' => 'required',
        ]);


        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role_id' => 3,
        ]);


        ManageUser::create([
            'user_id' => $user->id,
            'phone' => $validatedData['phone'],
            'country' => $validatedData['country'],
            'state' => $validatedData['state'],
            'city' => $validatedData['city'],
            'pincode' => $validatedData['pincode'],
            'gender' => $validatedData['gender'],
            'dob' => $validatedData['dob'],
            'subscription_type' => $validatedData['subscription_type'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'status' => $validatedData['status'],
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'User added successfully!');
    }

    public function getusers()
    {
        $users = User::with('manageUsers')->where('role_id', 3)->get();

        // Ensure the JSON response is well-formed
        return response()->json($users);
    }


    public function updateusers(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable',
            'phone' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'subscription_type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'status' => 'required',
        ]);

        // Find the user
        $user = User::findOrFail($id);

        // Update user details
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

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
        $manageUser->country = $validatedData['country'];
        $manageUser->state = $validatedData['state'];
        $manageUser->city = $validatedData['city'];
        $manageUser->pincode = $validatedData['pincode'];
        $manageUser->gender = $validatedData['gender'];
        $manageUser->dob = $validatedData['dob'];
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
