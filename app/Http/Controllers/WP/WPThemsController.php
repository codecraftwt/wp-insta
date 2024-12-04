<?php

namespace App\Http\Controllers\WP;

use App\Http\Controllers\Controller;
use App\Models\ThemesCategoriesModel;
use Illuminate\Http\Request;
use App\Models\WpMaterial;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class WPThemsController extends Controller
{
    public function themes_index(Request $request)
    {
        $categories = ThemesCategoriesModel::all();
        return view("wp.themes", compact('categories'));
    }

    public function fetchThemes(Request $request)
    {
        $search = $request->input('search') ?? '';

        $url = "https://api.wordpress.org/themes/info/1.2/?action=query_themes";
        $params = [
            'search' => $search,
        ];

        $query_url = $url . '&' . http_build_query($params);
        $response = file_get_contents($query_url);
        $themes = json_decode($response, true);


        if ($themes && isset($themes['themes'])) {
            return response()->json([
                'data' => $themes['themes'],
                'recordsTotal' => $themes['info']['results'],
                'recordsFiltered' => $themes['info']['results']
            ]);
        }
    }



    // public function downloadTheme(Request $request)
    // {
    //     $slug = $request->input('slug');
    //     $name = $request->input('name');
    //     $description = $request->input('description');

    //     // Define the directory and file path
    //     $directoryPath = public_path("wp-themes");
    //     $filePath = $directoryPath . "/{$slug}.zip";

    //     // Check if the directory exists, if not, create it with proper permissions
    //     if (!file_exists($directoryPath)) {
    //         mkdir($directoryPath, 0775, true); // 0775 permissions for the directory
    //     }

    //     // Set the appropriate permissions for the directory
    //     chmod($directoryPath, 0775); // Ensure directory is writable

    //     // Download the file and save it to the server
    //     $fileContent = file_get_contents("https://downloads.wordpress.org/theme/{$slug}.zip");

    //     // Save the file content
    //     file_put_contents($filePath, $fileContent);

    //     // Set permissions for the downloaded file
    //     chmod($filePath, 0664); // Permissions for the file

    //     // Create the database record for the downloaded theme
    //     WpMaterial::create([
    //         'type' => 'wp-themes',
    //         'name' => $name,
    //         'description' => $description,
    //         'file_path' => "wp-themes/{$slug}.zip",
    //         'status' => 1,
    //         'slug' => $slug
    //     ]);

    //     return response()->json(['message' => 'Theme downloaded successfully!']);
    // }



    public function downloadTheme(Request $request)
    {
        $slug = $request->input('slug');
        $name = $request->input('name');
        $description = $request->input('description');
        $categoryId = $request->input('category_id'); // New category_id parameter

        // Define the directory and file path
        $directoryPath = public_path("wp-themes");
        $filePath = $directoryPath . "/{$slug}.zip";

        // Check if the directory exists, if not, create it with proper permissions
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0775, true); // 0775 permissions for the directory
        }

        // Set the appropriate permissions for the directory
        chmod($directoryPath, 0775); // Ensure directory is writable

        // Download the file and save it to the server
        $fileContent = file_get_contents("https://downloads.wordpress.org/theme/{$slug}.zip");

        // Save the file content
        file_put_contents($filePath, $fileContent);

        // Set permissions for the downloaded file
        chmod($filePath, 0664); // Permissions for the file

        // Create the database record for the downloaded theme, including category_id
        WpMaterial::create([
            'type' => 'wp-themes',
            'name' => $name,
            'description' => $description,
            'file_path' => "wp-themes/{$slug}.zip",
            'status' => 1,
            'slug' => $slug,
            'category_id' => $categoryId // Save the category ID
        ]);

        return response()->json(['message' => 'Theme downloaded successfully!']);
    }



    public function getthemes()
    {
        $getthemes = WpMaterial::where('type', 'wp-themes')->get();

        // Return data wrapped in a 'data' key
        return response()->json(['data' => $getthemes]);
    }

    public function uploadthemes(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'file_path' => 'required|file|mimes:zip',
            'description' => 'nullable|string|max:1000',
            'category_id' => 'required',
        ]);


        if ($request->hasFile('file_path')) {

            $originalFileName = $request->file('file_path')->getClientOriginalName();
            $fileName =  $originalFileName;

            $request->file('file_path')->move(public_path('wp-themes'), $fileName);

            $plugin = new WpMaterial();
            $plugin->name = $request->name;
            $plugin->file_path = 'wp-themes/' . $fileName;
            $plugin->description = $request->description;
            $plugin->type = 'wp-themes';
            $plugin->status = 'installed';
            $plugin->category_id = $request->category_id;


            $plugin->save();

            return redirect()->back()->with('success', 'plugin uploaded successfully.');
        }
    }



    //WP THEMES CATA



    public function deleteTheme(Request $request)
    {
        // Get the slug from the request
        $slug = $request->input('slug');

        // Find the theme by slug in the database
        $theme =  WpMaterial::where('slug', $slug)->where('type', 'wp-themes')->first();

        if ($theme) {
            // Path to the theme's zip file (slug.zip)
            $themeFilePath = public_path('wp-themes/' . $slug . '.zip');

            // Check if the theme file exists and delete it
            if (File::exists($themeFilePath)) {
                File::delete($themeFilePath);  // Delete the file
            }

            // Delete the theme record from the database
            $theme->delete();

            // Return a success response
            return response()->json(['message' => 'Theme deleted successfully']);
        }

        // If the theme is not found, return an error
        return response()->json(['message' => 'Theme not found'], 404);
    }


    public function themes_categories()
    {

        return view('pages.themes_categories');
    }
    public function storethemescategories(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:theme_categories_table,name|max:255',
        ]);

        $themes_categories =  ThemesCategoriesModel::create([
            'name' => $request->name,
        ]);
        return response()->json(['success' => 'Themes category created successfully!']);
    }

    public function getthemescategories()
    {

        $themes_categories = ThemesCategoriesModel::all();


        return response()->json(['data' => $themes_categories]);
    }

    public function destroythemescategories($id)
    {
        $themes_categories = ThemesCategoriesModel::find($id);

        if (!$themes_categories) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $themes_categories->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }

    public function edit(string $id)
    {
        // Find the category by ID
        $themes_categories = ThemesCategoriesModel::find($id);

        // Return the category data as JSON
        return response()->json($themes_categories);
    }
    public function updatethemescategories(Request $request, string $id)
    {
        $themes_categories = ThemesCategoriesModel::find($id);
        $themes_categories->update($request->all());

        return response()->json(['message' => 'Category updated successfully!']);
    }
}
