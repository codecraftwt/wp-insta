<?php

namespace App\Http\Controllers\WP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WpMaterial;
use Illuminate\Support\Facades\Storage;

class WPVersionController extends Controller
{
    public function version_page()
    {
        return view('wp.version');
    }
    public function getversions()
    {

        $versions = WpMaterial::where('type', 'wp-version')->get();


        return response($versions);
    }


    public function version_store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^\d+(\.\d+){0,2}$/',
            ],
            'description' => 'nullable|string|max:1000',
        ]);

        $version = new WpMaterial();
        $version->name = $request->name;
        $version->file_path = 'https://wordpress.org/wordpress-' . $request->name . '.zip';
        $version->description = $request->description;
        $version->type = 'wp-version';
        $version->status = 'installed';
        $version->save();

        return redirect()->back()->with('success',  'form save successfully');
    }
}
