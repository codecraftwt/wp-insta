<?php

namespace App\Http\Controllers\WP;

use App\Http\Controllers\Controller;
use App\Models\PluginCategoriesModel;
use App\Models\WpMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class WPController extends Controller
{
    public function plugin_index(Request $request)
    {
        $categories = PluginCategoriesModel::all(); // Adjust as necessary based on your model

        // Return the view with categories
        return view("wp.plugin", compact('categories'));
    }

    public function fetchPlugins(Request $request)
    {
        $search_term = $request->input('search', '');
        $page = $request->input('page', 1);
        $plugins = $this->fetch_wordpress_plugins($search_term, $page, 9999);

        return response()->json($plugins);
    }

    private function fetch_wordpress_plugins($search = '', $page = 1, $per_page = 9999)
    {
        $url = "https://api.wordpress.org/plugins/info/1.2/?action=query_plugins";

        $params = [
            'search' => $search,
            'page'   => $page,
            'per_page' => $per_page
        ];

        $query_url = $url . '&' . http_build_query($params);
        $response = file_get_contents($query_url);

        return json_decode($response, true);
    }

    // public function downloadPlugin(Request $request)
    // {
    //     $downloadUrl = $request->input('url');
    //     $pluginName = basename($downloadUrl);
    //     $description = $request->input('description');

    //     $savePath = public_path('wp-plugins/' . $pluginName);

    //     $fileContent = file_get_contents($downloadUrl);


    //     File::put($savePath, $fileContent);


    //     WpMaterial::create([
    //         'type' => 'plugin',
    //         'name' => $pluginName,
    //         'description' => $description,
    //         'file_path' => 'wp-plugins/' . $pluginName,
    //         'status' => 'installed',
    //     ]);

    //     return response()->json(['success' => 'Plugin downloaded and saved successfully.', 'path' => $savePath]);
    // }

    // public function downloadPlugin(Request $request)
    // {
    //     $downloadUrl = $request->input('url');
    //     $description = $request->input('description');

    //     // Get the plugin name without version and extension
    //     $pluginNameWithVersion = basename($downloadUrl);
    //     $pluginName = pathinfo($pluginNameWithVersion, PATHINFO_FILENAME);

    //     $savePath = public_path('wp-plugins/' . $pluginName . '.zip');

    //     // Download the plugin file content
    //     $fileContent = file_get_contents($downloadUrl);

    //     // Save the file
    //     File::put($savePath, $fileContent);

    //     // Store the plugin details in the database
    //     WpMaterial::create([
    //         'type' => 'plugin',
    //         'name' => $pluginName,
    //         'description' => $description,
    //         'file_path' => 'wp-plugins/' . $pluginName . '.zip',
    //         'status' => 'installed',
    //     ]);

    //     return response()->json(['success' => 'Plugin downloaded and saved successfully.', 'path' => $savePath]);
    // }


    // public function downloadPlugin(Request $request)
    // {
    //     // Validate input data
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'url' => 'required|url',
    //         'description' => 'nullable|string|max:1000',
    //     ]);

    //     $downloadUrl = $request->input('url');
    //     $description = $request->input('description');
    //     $pluginName = $request->input('name'); // Use the name provided in the modal

    //     // Create a unique name for the plugin file to avoid conflicts
    //     $pluginFileName = $pluginName . '.zip';
    //     $savePath = public_path('wp-plugins/' . $pluginFileName);

    //     // Download the plugin file content
    //     $fileContent = file_get_contents($downloadUrl);
    //     if ($fileContent === false) {
    //         return response()->json(['error' => 'Failed to download the plugin.'], 500);
    //     }

    //     // Save the file
    //     File::put($savePath, $fileContent);

    //     // Store the plugin details in the database
    //     WpMaterial::create([
    //         'type' => 'plugin',
    //         'name' => $pluginName,
    //         'description' => $description,
    //         'file_path' => 'wp-plugins/' . $pluginFileName,
    //         'status' => 'installed',
    //     ]);

    //     return response()->json(['success' => 'Plugin downloaded and saved successfully.', 'path' => $savePath]);
    // }


    public function downloadPlugin(Request $request)
    {
        // Validate input data
        $request->validate([
            'url' => 'required|url',
            'category_id' => 'required', // Adjust based on your categories table
            'slug' => 'required|string|max:255',
            'description' => 'required',
        ]);

        $downloadUrl = $request->input('url');
        $categoryId = $request->input('category_id');
        $slug = $request->input('slug');
        $description = $request->input('description');

        // Create a unique name for the plugin file
        $pluginFileName = $slug . '.zip';
        $savePath = public_path('wp-plugins/' . $pluginFileName);

        // Ensure the directory exists and is writable
        $pluginDirectory = public_path('wp-plugins');
        if (!File::exists($pluginDirectory)) {
            File::makeDirectory($pluginDirectory, 0775, true); // Create the directory if it doesn't exist
        }

        // Check if the directory is writable
        if (!is_writable($pluginDirectory)) {
            return response()->json(['error' => 'The directory is not writable. Please check permissions.'], 500);
        }

        // Download the plugin file content
        $fileContent = file_get_contents($downloadUrl);
        if ($fileContent === false) {
            return response()->json(['error' => 'Failed to download the plugin.'], 500);
        }

        // Save the file
        File::put($savePath, $fileContent);

        // Store the plugin details in the database
        WpMaterial::create([
            'type' => 'plugin',
            'name' => $slug, // Save the slug
            'category_id' => $categoryId, // Save the category ID
            'file_path' => 'wp-plugins/' . $pluginFileName,
            'status' => 'installed',
            'description' => $description,
        ]);

        return response()->json(['success' => 'Plugin downloaded and saved successfully.', 'path' => $savePath]);
    }




    // public function listInstalledPlugins()
    // {
    //     $pluginsPath = public_path('wp-plugins');
    //     $installedPlugins = [];

    //     if (File::exists($pluginsPath)) {
    //         $pluginFiles = File::files($pluginsPath);

    //         foreach ($pluginFiles as $file) {
    //             $pluginName = $file->getFilename();


    //             $pluginRecord = WpMaterial::where('name', $pluginName)->where('type', 'plugin')->first();


    //             if ($pluginRecord) {
    //                 $description = $pluginRecord->description;
    //             } else {
    //                 $description = "No description available";
    //             }


    //             $installedPlugins[] = [
    //                 'name' => $pluginName,
    //                 'description' => $description
    //             ];
    //         }
    //     }

    //     return response()->json(['installedPlugins' => $installedPlugins]);
    // }


    public function listInstalledPlugins()
    {
        // Fetch all plugins from the database where type is 'plugin', along with their categories
        $plugins = WpMaterial::with('category')->where('type', 'plugin')->get(['name', 'description', 'category_id']);

        $installedPlugins = [];

        // Format the plugins for the response
        foreach ($plugins as $plugin) {
            $installedPlugins[] = [
                'name' => $plugin->name,
                'description' => $plugin->description ?: 'No description available',
                'category_id' => $plugin->category_id,
                'category_name' => $plugin->category ? $plugin->category->name : 'No category available'
            ];
        }

        // Return the list of installed plugins as JSON
        return response()->json(['installedPlugins' => $installedPlugins]);
    }


    // public function uploadPlugin(Request $request)
    // {

    //     $request->validate([
    //         'name' => 'required',
    //         'file_path' => 'required',
    //         'description' => 'nullable',
    //         'category_id' => 'required',
    //     ]);



    //     if ($request->hasFile('file_path')) {

    //         $originalFileName = $request->file('file_path')->getClientOriginalName();
    //         $fileName =  $originalFileName;

    //         $request->file('file_path')->move(public_path('wp-plugins'), $fileName);

    //         $plugin = new WpMaterial();
    //         $plugin->name = $request->name;
    //         $plugin->file_path = 'wp-plugins/' . $fileName;
    //         $plugin->description = $request->description;
    //         $plugin->type = 'plugin';
    //         $plugin->status = 'installed';
    //         $plugin->category_id = $request->category_id;


    //         $plugin->save();

    //         // Redirect back with success message
    //         return redirect()->back()->with('success', 'plugin uploaded successfully.');
    //     }
    // }

    public function uploadPlugin(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'file_path' => 'required|file|mimes:zip',
            'description' => 'nullable',
            'category_id' => 'required',
        ]);

        if ($request->hasFile('file_path')) {

            // Get the original file name and the new file name
            $originalFileName = $request->file('file_path')->getClientOriginalName();
            $fileName = $originalFileName;

            // Define the target directory for the plugin files
            $pluginDirectory = public_path('wp-plugins');

            // Ensure the directory exists and is writable
            if (!File::exists($pluginDirectory)) {
                File::makeDirectory($pluginDirectory, 0775, true); // Create the directory with appropriate permissions
            }

            // Check if the directory is writable
            if (!is_writable($pluginDirectory)) {
                return redirect()->back()->with('error', 'The wp-plugins directory is not writable.');
            }

            // Move the uploaded file to the target directory
            $request->file('file_path')->move($pluginDirectory, $fileName);

            // Ensure the uploaded file has proper permissions (allowing read/write)
            chmod($pluginDirectory . '/' . $fileName, 0775);

            // Create a new record for the uploaded plugin
            $plugin = new WpMaterial();
            $plugin->name = $request->name;
            $plugin->file_path = 'wp-plugins/' . $fileName;
            $plugin->description = $request->description;
            $plugin->type = 'plugin';
            $plugin->status = 'installed';
            $plugin->category_id = $request->category_id;
            $plugin->save();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Plugin uploaded successfully.');
        }

        // If no file was uploaded, redirect with an error
        return redirect()->back()->with('error', 'No file uploaded.');
    }
}
