<?php

namespace App\Http\Controllers\WP;

use App\Http\Controllers\Controller;
use App\Mail\SiteStopMail;
use App\Mail\SiteResumeMail;
use App\Mail\SiteDeleteMail;
use App\Models\ManageSite;
use App\Models\PluginCategoriesModel;
use App\Models\ThemesCategoriesModel;
use App\Models\User;
use App\Models\WpMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class CreateWordpressController extends Controller
{
    public function wordpress_version()
    {
        // Retrieve all records of type 'wp-version'
        $wordpress_version = WpMaterial::where('type', 'wp-version')->get();

        // Return the results as a JSON response
        return response()->json($wordpress_version);
    }

    public function showPlugins()
    {
        $pluginCategories = PluginCategoriesModel::all();
        return response()->json(['pluginCategories' => $pluginCategories]);
    }

    public function getPlugins()
    {
        // Fetch plugins from the database
        $plugins = WpMaterial::where('type', 'plugin')->get(['id', 'name', 'file_path']); // Fetch necessary fields

        // Prepare plugins with their paths
        $plugins = $plugins->map(function ($plugin) {
            return [
                'id' => $plugin->id,
                'name' => $plugin->name,
                'path' => asset('wp-plugins/' . basename($plugin->file_path)), // Assuming the file_path includes the full name
            ];
        });

        return response()->json([
            'plugins' => $plugins
        ]);
    }

    public function getByCategory($id)
    {
        // Fetch plugins where category_id matches the provided ID
        $plugins = WpMaterial::where('category_id', $id)
            ->where('type', 'plugin') // Assuming you want only plugins
            ->get();

        // Return the plugins as a JSON response
        return response()->json(['plugins' => $plugins]);
    }

    public function extractplugin(Request $request)
    {
        // Retrieve the unique folder name from the session
        $uniqueFolderName = session('unique_folder_name');

        // Check if the folder name exists
        if (!$uniqueFolderName) {
            return response()->json(['success' => false, 'message' => 'No folder name found.']);
        }

        // Construct the target directory for plugins
        $targetDirectory = public_path("wp_sites/{$uniqueFolderName}/wp-content/plugins");

        // Create the plugins directory if it doesn't exist
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        // Retrieve the selected plugins from the request
        $plugins = $request->input('plugins');

        $pluginNames = []; // Array to hold the new plugin names

        foreach ($plugins as $plugin) {
            $filePath = public_path("wp-plugins/" . basename($plugin['filePath'])); // Get the full path to the zip file

            // Check if the file exists before attempting to extract
            if (file_exists($filePath)) {
                $zip = new ZipArchive;

                if ($zip->open($filePath) === TRUE) {
                    // Extract the zip file to the target directory
                    $zip->extractTo($targetDirectory);
                    $zip->close();

                    // Clean up the plugin name
                    $cleanedName = str_replace([' ', '×'], '', $plugin['name']); // Remove spaces and '×'
                    $pluginNames[] = $cleanedName; // Add cleaned plugin name to the array


                } else {
                    return response()->json(['success' => false, 'message' => "Failed to extract {$plugin['filePath']}"]);
                }
            } else {
                return response()->json(['success' => false, 'message' => "File does not exist: {$filePath}"]);
            }
        }

        // Convert the array to a comma-separated string
        $newPluginNamesString = implode(',', $pluginNames);



        // Fetch the existing plugin names from the database
        $site = ManageSite::where('folder_name', $uniqueFolderName)->first();
        $existingPlugins = $site->plugin ? explode(',', $site->plugin) : [];

        // Merge existing plugins with the new plugins (keeping unique values only)
        $allPlugins = array_unique(array_merge($existingPlugins, $pluginNames));

        // Convert the array back to a comma-separated string
        $allPluginNamesString = implode(',', $allPlugins);

        // Update the database with the combined plugin names
        $site->update([
            'plugin' => $allPluginNamesString,
        ]);

        session(['plugin' => $allPluginNamesString]);

        return response()->json(['success' => true, 'message' => 'Plugins extracted and saved successfully!']);
    }




    public function themesforextract()
    {


        $themes = WpMaterial::where('type', 'wp-themes')
            ->select('name', 'file_path', 'id')
            ->get();


        return response()->json(['themes' => $themes]);
    }

    public function getCategories()
    {
        $categories = ThemesCategoriesModel::all(); // Fetch all categories from your database
        return response()->json(['categories' => $categories]);
    }

    public function getThemesByCategory($categoryId)
    {
        // Filter themes by category and type 'wp-themes'
        $themes = WpMaterial::where('category_id', $categoryId) // Filter themes by category
            ->where('type', 'wp-themes') // Add condition for type 'wp-themes'
            ->select('name', 'file_path', 'id')
            ->get();

        // Return the response in JSON format
        return response()->json(['themes' => $themes]);
    }





    public function extractthemes(Request $request)
    {
        // Retrieve the unique folder name from the session
        $uniqueFolderName = session('unique_folder_name');

        // Check if the folder name exists
        if (!$uniqueFolderName) {
            return response()->json(['success' => false, 'message' => 'No folder name found.']);
        }

        // Construct the target directory for themes
        $targetDirectory = public_path("wp_sites/{$uniqueFolderName}/wp-content/themes");

        // Check if the target directory exists, if not attempt to create it
        if (!is_dir($targetDirectory)) {
            if (!mkdir($targetDirectory, 0775, true)) {
                Log::error("Failed to create target directory: {$targetDirectory}");
                return response()->json(['success' => false, 'message' => "Failed to create directory: {$targetDirectory}"]);
            }
            Log::info("Target directory created: {$targetDirectory}");
        }

        // Check if the target directory is writable
        if (!is_writable($targetDirectory)) {
            // Attempt to set writable permissions (775 is typically a good choice for writable directories)
            if (chmod($targetDirectory, 0775)) {
                Log::info("Permissions set successfully for: {$targetDirectory}");
            } else {
                Log::error("Failed to set permissions for: {$targetDirectory}");
                return response()->json(['success' => false, 'message' => "Failed to set writable permissions for directory."]);
            }
        }

        // Retrieve the selected themes from the request
        $themes = $request->input('themes');
        $theme = $themes[0]; // Get the first (and only) theme

        $filePath = public_path("wp-themes/" . basename($theme['filePath'])); // Get the full path to the zip file

        // Log the paths
        Log::info("Target Directory: " . $targetDirectory);
        Log::info("File Path: " . $filePath);

        // Check if the file exists before attempting to extract
        if (!file_exists($filePath)) {
            return response()->json(['success' => false, 'message' => "File does not exist: {$filePath}"]);
        }

        // Check if ZipArchive is available
        if (!class_exists('ZipArchive')) {
            return response()->json(['success' => false, 'message' => 'ZipArchive class is not available on this server.']);
        }

        $zip = new ZipArchive;

        if ($zip->open($filePath) === TRUE) {
            Log::info("Zip file opened successfully.");
            // Extract the zip file to the target directory
            $extracted = $zip->extractTo($targetDirectory);
            $zip->close();

            if ($extracted) {
                Log::info("Theme extracted successfully.");
            } else {
                Log::info("Failed to extract the zip file.");
                return response()->json(['success' => false, 'message' => "Failed to extract {$theme['filePath']}"]);
            }
        } else {
            Log::info("Failed to open the zip file.");
            return response()->json(['success' => false, 'message' => "Failed to open {$theme['filePath']}"]);
        }

        // Clean the theme name by extracting it from the file name
        $cleanedName = pathinfo($theme['filePath'], PATHINFO_FILENAME); // Get the file name without the extension

        // Fetch the existing theme names from the database
        $site = ManageSite::where('folder_name', $uniqueFolderName)->first();

        if (!$site) {
            Log::error("Site not found in the database for folder name: {$uniqueFolderName}");
            return response()->json(['success' => false, 'message' => 'Site not found in database.']);
        }

        $existingThemes = $site->themes ? $site->themes : ''; // Retrieve existing themes
        $allThemeNamesString = $existingThemes ? $existingThemes . ',' . $cleanedName : $cleanedName;

        // Log before updating the database
        Log::info("All Theme Names to save: " . $allThemeNamesString);

        // Save the theme names in the session
        session(['ThemeNames' => $allThemeNamesString]);

        // Update the database with the combined theme names
        $site->update([
            'themes' => $allThemeNamesString,
        ]);

        Log::info("Themes updated in database for site: {$uniqueFolderName}");

        return response()->json(['success' => true, 'message' => 'Theme extracted and saved successfully!']);
    }






    public function downloadWordPress(Request $request)
    {
        // Validate inputs
        $request->validate([
            'siteName' => 'required',
            'user_name' => 'required',
            'password' => 'required',
            'version_wp' => 'required',
            'folder_name' => 'required|unique:site_name_table',
            'total_usage' => 'nullable',
            'usersite' => 'nullable',
        ]);

        $userId = Auth::id();
        $email = Auth::user()->email;
        $hashedPassword = $request->input('password');
        $total_usage = $request->input('total_usage'); // total usage in MB or GB
        $storage_limit = $request->input('storage_limit'); // storage limit in MB or GB
        $citecancreate = $request->input('usersite');
        $selectedVersion = $request->input('version_wp');

        // Get the running count for the user
        $runningcount = ManageSite::where('user_id', $userId)
            ->where('status', 'RUNNING')
            ->count();

        // Ensure running count is 0 if no results
        $runningcount = $runningcount ?? 0;

        // Check if running count is greater than citecancreate
        if ($runningcount >= $citecancreate) {
            return response()->json(['success' => false, 'message' => 'You have exceeded the maximum number of sites you can create.']);
        }

        // Set time limit for script execution
        set_time_limit(180);

        $baseUrl = config('site.base_url');
        $folderUrl = config('site.folder_url');
        $mysqlUser = config('site.mysql_user');
        $mysqlPassword = config('site.mysql_password');

        $uniqueFolderName = $request->input('folder_name');

        try {
            // Check if selected version is valid
            if ($selectedVersion === '6.6.2') {
                $zipPath = public_path('wp-versions/wordpress-6.6.2.zip');
            } elseif ($selectedVersion === '6.7.1') {
                $zipPath = public_path('wp-versions/wordpress-6.7.1.zip');
            } else {
                return response()->json(['success' => false, 'message' => 'Invalid WordPress version selected.']);
            }

            // Check the unit for total_usage and storage_limit and convert them to MB if needed
            $totalUsageInMB = $this->convertToMB($total_usage);
            $storageLimitInMB = $this->convertToMB($storage_limit);

            // Debug the values
            if ($totalUsageInMB >= $storageLimitInMB) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have exceeded your storage limit. Unable to create a new site.',
                ]);
            }

            // Path for wp_sites
            $wpSitesPath = public_path('wp_sites');

            // Create the base directory if it doesn't exist
            if (!file_exists($wpSitesPath)) {
                mkdir($wpSitesPath, 0755, true);
            }

            // Create the extraction path
            $extractPath = $wpSitesPath . "/{$uniqueFolderName}";
            if (!file_exists($extractPath)) {
                mkdir($extractPath, 0755, true);
            }

            // Extract the zip file
            if ($this->extractZipFile($zipPath, $extractPath)) {
                // Save the site information to the database
                try {
                    $site = ManageSite::create([
                        'site_name' => $request->input('siteName'),
                        'folder_name' => $uniqueFolderName,
                        'user_id' => $userId,
                        'version' => '6.2.2',
                        'site_type' => 'single',
                        'user_name' => $request->input('user_name'),
                        'email' => $email,
                        'password' => $hashedPassword,
                        'login_url' => $baseUrl . $folderUrl . $uniqueFolderName,
                        'domain_name' => $baseUrl . $folderUrl . $uniqueFolderName,
                        'db_name' => $uniqueFolderName,
                        'db_user_name' => 'root',
                        'status' => 'RUNNING'
                    ]);

                    if ($site) {
                        $siteId = $site->id;
                        session([
                            'unique_folder_name' => $site->folder_name,
                            'user_id' => $userId,
                            'site_name' => $site->site_name,
                            'user_name' => $site->user_name,
                            'email' => $email,
                            'password' => $hashedPassword,
                            'site_id' => $siteId,
                            'login_url' => $site->login_url,
                        ]);
                    } else {
                        return response()->json(['success' => false, 'message' => 'Failed to save site to the database.']);
                    }
                } catch (\Exception $e) {
                    return response()->json(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
                }

                // Define paths for wp-config
                $configSamplePath = $extractPath . '/wp-config-sample.php';
                $configPath = $extractPath . '/wp-config.php';

                if (file_exists($configSamplePath)) {
                    // Create wp-config.php and copy content from wp-config-sample.php
                    $wpConfigContent = file_get_contents($configSamplePath);

                    // Modify the wp-config.php content
                    $wpConfigContent = str_replace(
                        ['database_name_here', 'username_here', 'password_here'],
                        [$uniqueFolderName, $mysqlUser, $mysqlPassword],
                        $wpConfigContent
                    );

                    // Write the modified content to wp-config.php
                    file_put_contents($configPath, $wpConfigContent);

                    return response()->json(['success' => true, 'message' => 'WordPress extracted successfully!', 'path' => $extractPath]);
                } else {
                    return response()->json(['success' => false, 'message' => 'wp-config-sample.php not found.']);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to extract WordPress.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }


    // Helper function to convert storage values (MB or GB) to MB
    private function convertToMB($value)
    {
        // Check if value contains 'GB' and convert it to MB
        if (strpos($value, 'GB') !== false) {
            $valueInMB = floatval(str_replace('GB', '', $value)) * 1024;
        } else {
            // If the value is in MB, just return it
            $valueInMB = floatval(str_replace('MB', '', $value));
        }

        return $valueInMB;
    }



    protected function extractZipFile($zipPath, $extractPath)
    {
        $zip = new ZipArchive;
        if ($zip->open($zipPath) === TRUE) {
            $zip->extractTo($extractPath);
            $zip->close();
            return true;
        }
        return false;
    }


    public function createDatabase()
    {

        // Retrieve the unique folder name from the session
        $uniqueFolderName = session('unique_folder_name');

        // Construct the database name
        $databaseName = $uniqueFolderName;

        // Check if session variable exists
        if (!$uniqueFolderName) {
            return response()->json(['error' => 'Session expired or unique folder name missing.'], 400);
        }

        try {
            // Create the database using raw SQL
            DB::statement("CREATE DATABASE IF NOT EXISTS `$databaseName`");

            // Path to the SQL file
            $sqlFilePath = public_path('Import_mysql/wordpress_laravel.sql');

            // Check if the SQL file exists
            if (!file_exists($sqlFilePath)) {
                return response()->json(['error' => 'SQL file not found.'], 404);
            }

            // Read the SQL file
            $sql = file_get_contents($sqlFilePath);

            // Import the SQL into the newly created database
            $this->importSqlToDatabase($databaseName, $sql);

            // session()->forget([
            //     'unique_folder_name',
            //     'site_name',
            //     'user_name',
            //     'password',
            //     'email',
            //     'ThemeNames',
            // ]);
            $adminPassword = session('password');
            $adminEmail = session('email');
            $adminurl = session('login_url');
            $adminUsername = session('user_name');
            // Return a success response without 'database' and 'admin_details'
            return response()->json([
                'success' => 'Wordpress Created successfully!',
                'login_url' => $adminurl,
                'user_email' => $adminEmail,
                'password' => $adminPassword,
                'user_name' => $adminUsername,
            ]);
        } catch (\Exception $e) {
            Log::error('Database creation or import failed: ' . $e->getMessage() . ' in file ' . $e->getFile() . ' at line ' . $e->getLine());
            return response()->json(['error' => 'Database creation or import failed: ' . $e->getMessage()], 500);
        }
    }

    protected function splitSqlStatements($sql)
    {
        // Use a regex-based approach to avoid splitting on semicolons within strings or comments
        $queries = preg_split('/;[\r\n]+/', $sql);

        return array_filter($queries, function ($query) {
            return !empty(trim($query));
        });
    }

    protected function importSqlToDatabase($databaseName, $sql)
    {
        $uniqueFolderName = session('unique_folder_name');
        $connection = DB::connection('mysql');
        $adminDetails = [];
        $baseUrl = config('site.base_url');
        $folderUrl = config('site.folder_url');


        try {
            $connection->statement("USE `$databaseName`");

            // Split and execute SQL statements
            $queries = $this->splitSqlStatements($sql);
            foreach ($queries as $query) {
                $trimmedQuery = trim($query);
                if (!empty($trimmedQuery)) {
                    if (preg_match('/CREATE TABLE `(.*?)`/', $trimmedQuery, $matches)) {
                        $tableName = $matches[1];
                        $exists = $connection->select(
                            "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?",
                            [$databaseName, $tableName]
                        );
                        if (!empty($exists)) continue;
                    }
                    Log::info('Executing query: ' . $trimmedQuery);
                    $connection->statement($trimmedQuery);
                }
            }

            // Update WordPress settings and user details
            $siteTitle = session('site_name');
            $siteUrl =     $baseUrl  .   $folderUrl . session('unique_folder_name');
            $adminUsername = session('user_name');
            $adminPassword = session('password');
            $adminEmail = session('email');
            $themesName = session('ThemeNames');

            $connection->statement("UPDATE wp_options SET option_value=? WHERE option_name='siteurl' OR option_name='home'", [$siteUrl]);
            $connection->statement("UPDATE wp_options SET option_value=? WHERE option_name='blogname'", [$siteTitle]);
            $connection->statement("UPDATE wp_users SET user_login=?, user_pass=MD5(?), user_email=?, user_nicename=?, user_url=? WHERE ID=1", [
                $adminUsername,
                $adminPassword,
                $adminEmail,
                $adminUsername,
                $siteUrl,
            ]);

            // Theme handling
            if ($themesName) {
                $templateExists = $connection->select("SELECT COUNT(*) as count FROM wp_options WHERE option_name='template'")[0]->count;
                $stylesheetExists = $connection->select("SELECT COUNT(*) as count FROM wp_options WHERE option_name='stylesheet'")[0]->count;

                if ($templateExists) {
                    $connection->statement("UPDATE wp_options SET option_value=? WHERE option_name='template'", [$themesName]);
                } else {
                    $connection->statement("INSERT INTO wp_options (option_name, option_value, autoload) VALUES (?, ?, 'yes')", ['template', $themesName]);
                }

                if ($stylesheetExists) {
                    $connection->statement("UPDATE wp_options SET option_value=? WHERE option_name='stylesheet'", [$themesName]);
                } else {
                    $connection->statement("INSERT INTO wp_options (option_name, option_value, autoload) VALUES (?, ?, 'yes')", ['stylesheet', $themesName]);
                }
            }

            // Plugin handling
            $plugin = session('plugin');
            $pluginArray = explode("\n,", $plugin);
            $pluginFiles = [];

            // Build the array of plugins with sequential keys starting from 0
            foreach ($pluginArray as $pluginItem) {
                $cleanPlugin = ltrim(trim($pluginItem), ',');
                if (!empty($cleanPlugin)) {
                    $pluginName = explode('/', $cleanPlugin)[0];
                    $pluginFile = $pluginName . DIRECTORY_SEPARATOR . $pluginName . ".php";
                    $pluginFiles[] = $pluginFile;
                }
            }

            // Ensure the array keys are sequential integers
            $pluginFiles = array_values($pluginFiles);
            $activePluginsSerialized = str_replace('\\', '/', serialize($pluginFiles));

            // Check if the `active_plugins` option exists and update/insert it
            $activePluginsExists = $connection->select("SELECT COUNT(*) as count FROM wp_options WHERE option_name = 'active_plugins'")[0]->count;

            if ($activePluginsExists) {
                $connection->statement("UPDATE wp_options SET option_value=? WHERE option_name='active_plugins'", [$activePluginsSerialized]);
            } else {
                $connection->statement("INSERT INTO wp_options (option_name, option_value, autoload) VALUES ('active_plugins', ?, 'yes')", [$activePluginsSerialized]);
            }
        } catch (\Exception $e) {
            Log::error('Database import failed: ' . $e->getMessage());
            throw $e;
        }

        return $adminDetails;
    }

    public function getAdminDetails()
    {
        $authUser = auth()->user();
        $id = session('site_id');

        if ($authUser->role_id == 1) {
            $info = ManageSite::all();
        } else {
            $info = ManageSite::where('user_id', $authUser->id)->get();
        }

        $runningCount = $info->where('status', 'RUNNING')->count();
        $stoppedcount = $info->where('status', 'STOP')->count();
        $deletedcount = $info->where('status', 'DELETED')->count();

        return response()->json([
            'info' => $info,
            'runningCount' => $runningCount,
            'id' => $id,
            'stoppedcount' => $stoppedcount,
            'deletedcount' => $deletedcount

        ]);
    }

    public function deletesite($id)
    {
        $record = ManageSite::find($id);
        if (!$record) {
            return response()->json(['error' => 'Site not found'], 404);
        }


        // Get the user_id from the ManageSite record
        $userId = $record->user_id;

        // Retrieve the user's email using the user_id
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Get the user's email
        $userEmail = $user->email;
        $userName = $user->name;
        $siteName = $record->site_name;

        Mail::to($userEmail)->send(new SiteDeleteMail($userEmail, $userName, $siteName));


        // Get the folder name from the record
        $folderName = $record->folder_name;

        // Use the public_path helper to construct the folder path dynamically
        $folderPath = public_path('wp_sites/' . $folderName);  // Refers to public/wp_sites/your_folder_name

        $this->deleteFolderAndDatabase($folderName, $folderPath);

        // Update the record status to 'DELETED'
        $record->status = 'DELETED';
        $record->save();

        return response()->json(['message' => 'Site marked as deleted, folder removed, and database deleted'], 200);
    }

    private function deleteFolderAndDatabase($folderName, $folderPath)
    {
        // Delete the database if it exists
        if ($folderName) {
            DB::statement("DROP DATABASE IF EXISTS `$folderName`");
        }

        // Delete the folder and its contents
        if (is_dir($folderPath)) {
            $files = array_diff(scandir($folderPath), array('.', '..'));

            foreach ($files as $file) {
                $filePath = $folderPath . '/' . $file;
                if (is_dir($filePath)) {
                    $this->deleteFolderAndDatabase($folderName, $filePath);
                } else {
                    unlink($filePath); // Delete file
                }
            }

            // Remove the empty directory
            rmdir($folderPath);
            Log::info("Folder '$folderPath' and its contents deleted successfully.");
        }
    }

    public function stopsite(Request $request)
    {
        $id = $request->input('id');
        $record = ManageSite::find($id);

        if (!$record) {
            return response()->json(['error' => 'Site not found'], 404);
        }

        // Get the user_id from the ManageSite record
        $userId = $record->user_id;

        // Retrieve the user's email using the user_id
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Get the user's email
        $userEmail = $user->email;
        $userName = $user->name;
        $siteName = $record->site_name;

        Mail::to($userEmail)->send(new SiteStopMail($userEmail, $userName, $siteName));

        // Update the status to 'STOP'
        $record->status = 'STOP';
        $record->save();

        // Respond with the email and success message
        return response()->json([
            'message' => 'Site status updated to STOP',
            'user_email' => $userEmail
        ]);
    }

    public function runsite(Request $request)
    {
        $id = $request->input('id');
        $record = ManageSite::find($id);

        if (!$record) {
            return response()->json(['error' => 'Site not found'], 404);
        }

        $userId = $record->user_id;

        $user = User::find($userId);


        $userEmail = $user->email;
        $userName = $user->name;
        $siteName = $record->site_name;


        Mail::to($userEmail)->send(new SiteResumeMail($userEmail, $userName, $siteName));

        // Update the status to 'STOP'
        $record->status = 'RUNNING';
        $record->save();


        return response()->json([
            'message' => 'Site status updated to RUNNING',
            'user_email' => $userEmail
        ]);
    }
}
