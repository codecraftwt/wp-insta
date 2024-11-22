<?php

namespace App\Http\Controllers;

use App\Models\ManageSite;
use App\Models\ManageUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\WpMaterial;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MainController extends Controller
{


    public function wpdatacount()
    {
        $data =  WpMaterial::all();

        $users = ManageUser::all();

        $plugin = $data->where('type', 'plugin')->count();
        $themes = $data->where('type', 'wp-themes')->count();

        $userdata = $users->where('status', 1)->count();
        $inactiveusers = $users->where('status', 0)->count();

        $Premium = $users->where('subscription_type', 'Premium')->count();
        $Basic = $users->where('subscription_type', 'Basic')->count();
        $Free = $users->where('subscription_type', 'Free')->count();



        return response([

            'plugin' => $plugin,
            'themes' => $themes,
            'userdata' => $userdata,
            'inactiveusers' => $inactiveusers,
            'Premium' => $Premium,
            'Basic' => $Basic,
            'Free' => $Free,
        ]);
    }


    public function index()
    {
        return view('pages.all_sites');
    }



    public function siteinfo()
    {
        // Retrieve site data with related user details
        $siteinfo = ManageSite::with('manageUser')->get();

        // Define statuses to filter by
        $statuses = ['RUNNING', 'STOP', 'DELETED'];

        // Initialize an empty array to hold filtered results
        $filteredSites = [];

        // Loop through each status and filter the data
        foreach ($statuses as $status) {
            $filteredSites[$status] = $siteinfo->where('status', $status)->map(function ($site) {
                return [
                    'site' => $site,
                    'subscription_type' => $site->manageUser->subscription_type,
                    'start_date' => $site->manageUser->start_date,
                    'end_date' => $site->manageUser->end_date,
                ];
            })->toArray(); // Convert the collection to an array
        }

        // Return the filtered data as a JSON response
        return response()->json($filteredSites);
    }




    public function update(Request $request)
    {
        // Validate the input data
        $request->validate([
            'name_profile' => 'required|string|max:255',
            'email_profile' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'password_profile' => 'nullable|string|min:6|confirmed',
            'password_confirmation_profile' => 'nullable|string|min:6',
        ]);

        // Get the authenticated user
        $user = User::find(Auth::id());

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Update the user details
        $user->name = $request->input('name_profile');
        $user->email = $request->input('email_profile');

        // If a password is provided, hash it and update
        if ($request->filled('password_profile')) {
            $user->password = Hash::make($request->input('password_profile'));
        }

        // Save the changes
        $user->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }


    // Backend Code (Laravel Controller)
    public function fetchLocationDetails(Request $request)
    {
        // Validate the pincode
        $request->validate([
            'pincode' => 'required',
        ]);

        $pincode = $request->input('pincode');
        $apiKey = '20d7d0b95e534459bae0c72805aeee9e';
        $apiUrl = "https://api.geoapify.com/v1/geocode/search?text={$pincode}&apiKey={$apiKey}";

        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $data = $response->json();

            if (isset($data['features']) && count($data['features']) > 0) {
                $location = $data['features'][0];
                $state = $location['properties']['state'] ?? '';
                $country = $location['properties']['country'] ?? '';
                $city = $location['properties']['city'] ??
                    $location['properties']['town'] ??
                    $location['properties']['region'] ??
                    $location['properties']['suburb'] ??
                    $location['properties']['other'] ?? '';

                return response()->json([
                    'state' => $state,
                    'country' => $country,
                    'city' => $city
                ]);
            }
        }

        // Return error response if location not found
        return response()->json([
            'state' => null,
            'country' => null,
            'city' => null,
            'error' => 'Location not found'
        ]);
    }




    public function notificationNewRegister()
    {
        // Fetch only users with notification_status 0
        $usernoti = User::where('notification_status', 0)->get();

        return response()->json(['data' => $usernoti]);
    }
    public function markNotificationsAsRead()
    {
        // Update notification status to 1 (read)
        User::where('notification_status', 0)->update(['notification_status' => 1]);

        return response()->json(['message' => 'Notifications marked as read']);
    }
}
