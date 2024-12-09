<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\File;
use App\Models\WpMaterial;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run()
    {
        // Seed the Astra theme
        $this->seedTheme(
            fileName: 'astra.zip',
            name: 'Astra',
            description: 'Astra is a fast, lightweight, and highly customizable theme.',
            categoryId: 1
        );
    }

    private function seedTheme(string $fileName, string $name, string $description, int $categoryId)
    {
        $sourceFilePath = public_path('Import_mysql/' . $fileName);
        $themeDirectory = public_path('wp-themes');

        // Ensure the target directory exists
        if (!File::exists($themeDirectory)) {
            File::makeDirectory($themeDirectory, 0775, true);
        }

        // Check if the directory is writable
        if (!is_writable($themeDirectory)) {
            echo "The wp-themes directory is not writable.\n";
            return;
        }

        // Define the target file path
        $targetFilePath = $themeDirectory . '/' . $fileName;

        // Copy the file
        if (File::exists($sourceFilePath)) {
            File::copy($sourceFilePath, $targetFilePath);
        } else {
            echo "Source file does not exist: " . $sourceFilePath . "\n";
            return;
        }

        // Set the file permissions
        chmod($targetFilePath, 0775);

        // Create a record for the uploaded theme
        $theme = new WpMaterial();
        $theme->name = $name;
        $theme->slug = $name;
        $theme->file_path = 'wp-themes/' . $fileName;
        $theme->description = $description;
        $theme->type = 'wp-themes';
        $theme->status = 'installed';
        $theme->category_id = $categoryId;
        $theme->save();
    }
}
