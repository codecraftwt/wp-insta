<?php

namespace App\Http\Controllers;

use App\Models\ManageSite;
use App\Models\ManageUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\WpMaterial;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

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
                $folderPath = public_path('wp_sites/' . $site->folder_name);
                $folderSize = $this->safeGetFolderSize($folderPath);

                return [
                    'site' => $site,
                    'subscription_type' => $site->manageUser->subscription_type,
                    'start_date' => $site->manageUser->start_date,
                    'end_date' => $site->manageUser->end_date,
                    'subscription_status' => $site->manageUser->subscription_status,
                    'folder_name' => $site->folder_name,
                    'storage_usage' => $this->formatSize($folderSize), // Calculate and format storage usage
                ];
            })->toArray();
        }

        return response()->json($filteredSites);
    }

    private function safeGetFolderSize($dir)
    {
        $size = 0;
        if (is_dir($dir)) {
            try {
                foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)) as $file) {
                    if ($file->isFile()) {
                        $size += $file->getSize();
                    }
                }
            } catch (\Exception $e) {
                // Handle errors gracefully, e.g., log the error
                Log::error("Error calculating folder size for: $dir. Error: " . $e->getMessage());
            }
        }
        return $size;
    }

    // Helper function to format size into KB, MB, or GB
    private function formatSize($size)
    {
        if ($size >= 1073741824) {
            return number_format($size / 1073741824, 2) . ' GB';
        } elseif ($size >= 1048576) {
            return number_format($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) {
            return number_format($size / 1024, 2) . ' KB';
        } else {
            return $size . ' bytes';
        }
    }






    public function updatepro(Request $request)
    {


        // Validate the input
        $validator = Validator::make($request->all(), [
            'name_profile' => 'required|string|max:255',
            'email_profile' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'password_profile' => 'nullable|string|min:6|confirmed',
            'password_confirmation_profile' => 'nullable|string|min:6',
        ]);

        // If validation fails, log errors and redirect back
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }



        // Find the authenticated user
        $user = User::find(Auth::id());

        if (!$user) {

            return redirect()->back()->with('error', 'User not found.');
        }



        // Update the user details
        $user->name = $request->input('name_profile');
        $user->email = $request->input('email_profile');

        // Check if a password is provided and update it
        if ($request->filled('password_profile')) {

            $hashedPassword = Hash::make($request->input('password_profile'));

            $user->password = $hashedPassword;
        } else {
        }

        // Attempt to save the user data
        if ($user->save()) {

            return redirect()->back()->with('success', 'Profile updated successfully!');
        } else {

            return redirect()->back()->with('error', 'Failed to update profile. Please try again.');
        }
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


    public function UserStorage()
    {
        // Get the authenticated user's ID
        $authId = auth()->user()->id;

        // Get all entries from ManageSite where user_id matches the authenticated user's ID
        $storage = ManageSite::where('user_id', $authId)->get();

        $totalStorage = 0;
        $totalDatabaseStorage = 0;

        // Loop through each storage entry and calculate the folder sizes and database sizes
        foreach ($storage as $site) {
            // Get the folder path for each site
            $folderPath = public_path('wp_sites/' . $site->folder_name);

            // Get the database name from the site (assuming it's stored as 'db_name' in the ManageSite model)
            $databaseName = $site->db_name; // Replace with the actual column name in your database

            // Calculate folder size
            if (is_dir($folderPath)) {
                $folderSize = $this->getFolderSize($folderPath);
                $totalStorage += $folderSize;
            }

            // Calculate database size
            $databaseSize = $this->getDatabaseSize($databaseName);
            $totalDatabaseStorage += $databaseSize;
        }

        // Return both total storage and database storage size in a response
        return response()->json([
            'total_storage' => $this->formatSize($totalStorage),
            'database_storage' => $this->formatSize($totalDatabaseStorage),

        ]);
    }

    // Helper function to calculate the size of a folder
    private function getFolderSize($folder)
    {
        $totalSize = 0;

        // Recursively get the size of all files and subdirectories in the folder
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::LEAVES_ONLY) as $file) {
            $totalSize += $file->getSize();
            // Log the size of each file to debug
            Log::info("File: " . $file->getPathname() . " Size: " . $file->getSize());
        }

        return $totalSize;
    }

    // Helper function to calculate the size of a database

    private function getDatabaseSize($databaseName)
    {
        // Assuming you're using MySQL/MariaDB, you can run a query to get the database size
        $sizeQuery = DB::select("SELECT table_schema AS database_name,
                                    SUM(data_length + index_length) / 1024 / 1024 AS database_size_mb
                             FROM information_schema.tables
                             WHERE table_schema = ?
                             GROUP BY table_schema", [$databaseName]);

        // Return the size of the database in MB (no need to convert to bytes)
        return $sizeQuery ? $sizeQuery[0]->database_size_mb : 0; // Return size in MB
    }
}
