<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\File;
use App\Models\WpMaterial;
use Illuminate\Database\Seeder;

class PluginSeeder extends Seeder
{

    public function run()
    {
        // First Plugin: Elementor
        $this->seedPlugin(
            'elementor.zip',
            'elementor',
            'elementor to free use and do anything',
            1
        );

        // Second Plugin: 301 Redirects – Easy Redirect Manager
        $this->seedPlugin(
            '301 Redirects – Easy Redirect Manager.zip',
            '301 Redirects – Easy Redirect Manager',
            '301 Redirects plugin to manage URL redirects easily',
            2
        );
        $this->seedPlugin(
            'classic-editor.zip',
            'classic-editor',
            '301 Redirects plugin to manage URL redirects easily',
            4
        );
        $this->seedPlugin(
            'wp-seo.zip',
            'wp-seo',
            '301 Redirects plugin to manage URL redirects easily',
            3
        );
    }


    private function seedPlugin(string $fileName, string $name, string $description, int $categoryId)
    {
        $sourceFilePath = public_path('Import_mysql/' . $fileName);
        $pluginDirectory = public_path('wp-plugins');

        // Ensure the target directory exists
        if (!File::exists($pluginDirectory)) {
            File::makeDirectory($pluginDirectory, 0775, true);
        }

        // Check if the directory is writable
        if (!is_writable($pluginDirectory)) {
            echo "The wp-plugins directory is not writable.\n";
            return;
        }

        // Define the target file path
        $targetFilePath = $pluginDirectory . '/' . $fileName;

        // Copy the file
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
        $plugin->name = $name;
        $plugin->slug = $name;
        $plugin->file_path = 'wp-plugins/' . $fileName;
        $plugin->description = $description;
        $plugin->type = 'plugin';
        $plugin->status = 'installed';
        $plugin->category_id = $categoryId;
        $plugin->save();
    }
}
