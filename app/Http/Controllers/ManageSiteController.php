<?php

namespace App\Http\Controllers;

use App\Models\ManageSite;
use App\Models\User;
use App\Models\WpMaterial;
use Illuminate\Http\Request;

class ManageSiteController extends Controller
{
    public function index()
    {

        $users = User::select('id', 'name')
            ->where('role_id', 3)
            ->get();

        $plugin = WpMaterial::select('id', 'name')
            ->where('type', 'plugin')
            ->get();


        return view('pages.manage_sites', compact('users', 'plugin'));
    }





    public function storesite(Request $request)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required',
            'site_name' => 'required',
            'site_type' => 'required',
            'email' => 'required',
            'password' => 'required',
            'username' => 'required',
            'db_name' => 'required',
            'db_username' => 'required',
            'db_password' => 'required',
            'plugin_list' => 'required',
            'theam' => 'required',
            'domain_name' => 'required',
            'ownerdomain_name' => 'required',
        ]);

        // Get all form data
        $data = $request->all();


        $data['plugin_list'] = implode(',', $request->input('plugin_list'));

        // Save the data to the database
        ManageSite::create($data);

        return redirect()->back()->with('success', 'FORM IS SAVE SUCCESS');
    }

    public function showsites()
    {

        $sites = ManageSite::with('user:id,name')
            ->select('id', 'user_id', 'site_name', 'domain_name')
            ->get();

        return response()->json($sites); // Return as JSON
    }

    public function siteedit($id)
    {
        // Find the site by ID
        $site = ManageSite::find($id);

        $user = User::find($site->user_id);


        $response = [
            'id' => $site->id,
            'user_id' => $site->user_id,
            'site_name' => $site->site_name,
            'site_type' => $site->site_type,
            'email' => $site->email,
            'username' => $user->name,
            'db_name' => $site->db_name,
            'db_username' => $site->db_username,
            'plugin_list' => $site->plugin_list,
            'theam' => $site->theam,
            'domain_name' => $site->domain_name,
            'ownerdomain_name' => $site->ownerdomain_name,
        ];


        return response()->json($response);
    }


    public function updatesite(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'edomain_name' => 'required',

        ]);

        $site = ManageSite::find($request->id);
        $site->domain_name = $request->edomain_name;


        $site->save();

        return response()->json(['message' => 'Site updated successfully', 'site' => $site]);
    }

    public function destroy($id)
    {
        $user = ManageSite::find($id);

        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully.']);
        }

        return response()->json(['message' => 'User not found.'], 404);
    }
}
