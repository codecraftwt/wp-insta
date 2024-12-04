<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\File;
use App\Models\WpMaterial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PluginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $sourceFilePath = public_path('Import_mysql/elementor.zip');
        $pluginDirectory = public_path('wp-plugins');

        // Ensure the target directory exists
        if (!File::exists($pluginDirectory)) {
            File::makeDirectory($pluginDirectory, 0775, true);
        }

        // Check if the directory is writable
        if (!is_writable($pluginDirectory)) {
            return redirect()->back()->with('error', 'The wp-plugins directory is not writable.');
        }

        // Define the target file path
        $fileName = 'elementor.zip';
        $targetFilePath = $pluginDirectory . '/' . $fileName;

        // Copy the file instead of moving it
        if (File::exists($sourceFilePath)) {
            File::copy($sourceFilePath, $targetFilePath);
        } else {
            echo "Source file does not exist: " . $sourceFilePath . "\n";
            return;
        }

        // Set the file permissions
        chmod($targetFilePath, 0775);

        // Create a record for the uploaded plugin
        $plugin = new WpMaterial();
        $plugin->name = 'elementor';
        $plugin->file_path = 'wp-plugins/' . $fileName;
        $plugin->description = 'elementor to free use and do anything';
        $plugin->type = 'plugin';
        $plugin->status = 'installed';
        $plugin->category_id = 1;
        $plugin->save();

        echo "Plugin 'elementor' uploaded and seeded successfully.\n";
    }
}
