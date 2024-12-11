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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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

        $authUser = auth()->user();


        if ($authUser->id === 1) {

            $siteinfo = ManageSite::with('manageUser')->get();
        } else {

            $siteinfo = ManageSite::with('manageUser')
                ->where('user_id', $authUser->id)
                ->get();
        }


        $statuses = ['RUNNING', 'STOP', 'DELETED'];

        $filteredSites = [];


        foreach ($statuses as $status) {
            $filteredSites[$status] = $siteinfo->where('status', $status)->map(function ($site) {

                return [
                    'site' => $site,
                    'subscription_type' => $site->manageUser->subscription_type,
                    'start_date' => $site->manageUser->start_date,
                    'end_date' => $site->manageUser->end_date,
                    'subscription_status' => $site->manageUser->subscription_status,
                ];
            })->toArray();
        }


        return response()->json($filteredSites);
    }






    public function update(Request $request)
    {

        $request->validate([
            'name_profile' => 'required|string|max:255',
            'email_profile' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'password_profile' => 'nullable|string|min:6|confirmed',
            'password_confirmation_profile' => 'nullable|string|min:6',
        ]);


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





    public function notificationNewRegister()
    {

        $usernoti = User::where('notification_status', 0)->get();

        return response()->json(['data' => $usernoti]);
    }
    public function markNotificationsAsRead()
    {

        User::where('notification_status', 0)->update(['notification_status' => 1]);

        return response()->json(['message' => 'Notifications marked as read']);
    }


    public function countUsersByStatus()
    {
        $activeCount = ManageUser::where('status', 1)->count();
        $inactiveCount = ManageUser::where('status', 0)->count();

        return response()->json([
            'active' => $activeCount,
            'inactive' => $inactiveCount
        ]);
    }



    public function upgradeplans()
    {

        if (Auth::check()) {
            $userId = Auth::id();


            if ($userId == 1) {

                return response()->json([0]);
            }

            $subscriptionStatus = ManageUser::where('user_id', $userId)->pluck('subscription_status')->first();


            return response()->json([$subscriptionStatus]);
        }

        return response()->json([0]);
    }


    public function suggesstionname(Request $request)
    {
        // Validate the domain name
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'regex:/^[a-zA-Z]+$/',], // Only letters allowed
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Domain names can only contain letters (a-z, A-Z). No symbols, numbers, or spaces are allowed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $inputName = $request->input('name');
        $existingNames = ManageSite::pluck('folder_name')->toArray();

        if (in_array($inputName, $existingNames)) {
            $suggestion = $this->generateUniqueName($inputName, $existingNames);
            return response()->json([
                'status' => 'taken',
                'message' => 'The domain name is already taken.',
                'suggestion' => $suggestion,
            ]);
        }

        return response()->json([
            'status' => 'available',
            'message' => 'The domain name is available.',
        ]);
    }

    private function generateUniqueName($name, $existingNames)
    {
        do {
            // Generate a random alphabetic string (letters only)
            $randomString = collect(range('a', 'z'))
                ->random(3) // Pick 3 random letters
                ->implode(''); // Convert the collection to a string

            $newName = $name . $randomString;
        } while (in_array($newName, $existingNames));

        return $newName;
    }


    public function fetchConfig()
    {
        // Fetch current PHP configuration values
        return response()->json([
            'php_version' => phpversion(),
            'max_execution_time' => ini_get('max_execution_time'),
            'max_input_time' => ini_get('max_input_time'),
            'max_input_vars' => ini_get('max_input_vars'),
            'memory_limit' => ini_get('memory_limit'),
            'allow_url_fopen' => ini_get('allow_url_fopen'),
            'post_max_size' => ini_get('post_max_size'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'session_gc_maxlifetime' => ini_get('session.gc_maxlifetime'),
            'output_buffering' => ini_get('output_buffering'),
            'pm_max_children' => shell_exec("grep 'pm.max_children' /etc/php/8.0/fpm/pool.d/www.conf | awk '{print $3}'"),
        ]);
    }

    public function getConfig()
    {
        // Get all PHP configuration settings
        $phpConfig = phpinfo();

        // Return the configuration as a JSON response
        return response()->json(['data' => $phpConfig]);
    }
}
