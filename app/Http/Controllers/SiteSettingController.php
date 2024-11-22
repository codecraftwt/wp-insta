<?php

namespace App\Http\Controllers;

use App\Models\SiteSettingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{

    public function index()
    {
        $siteSetting = SiteSettingModel::first(); // Or whatever logic you use to fetch site settings
        return view('pages.site_setting', compact('siteSetting'));
    }
    public function saveSettings(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'site_title' => 'required',
            'logo' => 'nullable|image',
            'header_background' => 'required',
            'header_text' => 'required',
            'header_btncolor' => 'required',
            'header_btn_bgcolor' => 'required',
            'footer_text' => 'required',
            'footer_background' => 'required',
        ]);

        // Check if a site setting record already exists
        $siteSetting = SiteSettingModel::first();

        // If record doesn't exist, create a new one, otherwise, update the existing one
        if (!$siteSetting) {
            $siteSetting = new SiteSettingModel();
        }

        // Handle logo upload if a file is provided
        if ($request->hasFile('logo')) {
            // Define the target directory for logo uploads
            $logoDirectory = public_path('logo');

            // Create the directory if it doesn't exist
            if (!File::exists($logoDirectory)) {
                File::makeDirectory($logoDirectory, 0775, true); // Create the directory with 775 permissions
            }

            // Check if the old logo exists, and delete it
            if ($siteSetting->logo && File::exists(public_path($siteSetting->logo))) {
                File::delete(public_path($siteSetting->logo)); // Delete the old logo file
            }

            // Get the uploaded file
            $logoFile = $request->file('logo');
            $logoName = $logoFile->getClientOriginalName();

            // Move the uploaded file to the 'public/logo' directory
            $logoFile->move($logoDirectory, $logoName);

            // Set the new logo path
            $siteSetting->logo = 'logo/' . $logoName;
        }

        // Only update fields that have changed
        if ($request->has('site_title')) {
            $siteSetting->site_title = $request->site_title;
        }

        if ($request->has('header_background')) {
            $siteSetting->header_background = $request->header_background;
        }

        if ($request->has('header_text')) {
            $siteSetting->header_text = $request->header_text;
        }

        if ($request->has('header_btncolor')) {
            $siteSetting->header_btncolor = $request->header_btncolor;
        }

        if ($request->has('header_btn_bgcolor')) {
            $siteSetting->header_btn_bgcolor = $request->header_btn_bgcolor;
        }

        if ($request->has('footer_text')) {
            $siteSetting->footer_text = $request->footer_text;
        }

        if ($request->has('footer_background')) {
            $siteSetting->footer_background = $request->footer_background;
        }

        // Save the record
        $siteSetting->save();

        return redirect()->back()->with('success', 'Settings saved successfully!');
    }
}
