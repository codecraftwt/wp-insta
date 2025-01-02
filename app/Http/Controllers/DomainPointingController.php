<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DomainPointingController extends Controller
{
    public function domainPointing(Request $request)
    {
        // Fetch input data from the request
        $domainname = $request->input('domainname');
        $directory = $request->input('defsitename');

        // Base paths (assuming you have them defined directly in your code)
        $site_path = '/var/www/html/my-laravel-app/public';  // Your Laravel public folder path
        $folderPath = public_path('apache_config'); // Folder to save Apache configs

        // Validate that domainname and directory are provided
        if (empty($domainname) || empty($directory)) {
            return response()->json(['error' => 'Domain name and directory are required.'], 400);
        }

        try {
            // Create directory if it does not exist
            $siteDirectoryPath = $site_path . '/' . $directory;
            $this->createDirectory($siteDirectoryPath);

            // Set permissions for the directory
            $this->setPermissions($siteDirectoryPath);

            // Create Apache config file for the domain
            $this->createApacheConfig($domainname, $siteDirectoryPath, $folderPath);

            // Enable site and reload Apache
            $this->enableSiteAndReload($domainname, $folderPath);

            // Return success message
            return response()->json(['message' => 'Domain pointing configuration completed successfully.']);
        } catch (Exception $e) {
            // Handle any exceptions and return error message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Function to create directory if it doesn't exist
    private function createDirectory($path)
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }

    // Function to set permissions for the directory
    private function setPermissions($path)
    {
        // Ensure proper ownership and permissions
        if (!chown($path, 'www-data')) {
            throw new Exception("Failed to change ownership of directory $path.");
        }
        if (!chmod($path, 0755)) {
            throw new Exception("Failed to set permissions for directory $path.");
        }
    }

    // Function to create the Apache config file for the domain
    private function createApacheConfig($domain, $directory, $folderPath)
    {
        // Define Apache configuration
        $config = <<<EOL
<VirtualHost *:80>
    ServerName $domain
    ServerAlias www.$domain
    DocumentRoot "$directory"
    
    <Directory "$directory">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
EOL;

        // Define the config file path in the public folder
        $configFile = "$folderPath/$domain.conf";

        // Save the Apache config to the specified path
        if (File::put($configFile, $config) === false) {
            throw new Exception("Failed to create Apache config file for domain $domain.");
        }

        // Set the proper permissions for the Apache config file
        if (!chmod($configFile, 0644)) {
            throw new Exception("Failed to set permissions for Apache config file $configFile.");
        }
    }

    // Function to enable the site by creating a symlink and reloading Apache
    private function enableSiteAndReload($domain, $folderPath)
    {
        $configFile = "$folderPath/$domain.conf";
        $enabledDir = '/etc/apache2/sites-enabled/';

        // Ensure the 'sites-enabled' directory exists
        if (!File::exists($enabledDir)) {
            if (!File::makeDirectory($enabledDir, 0755, true)) {
                throw new Exception("Failed to create sites-enabled directory.");
            }
        }

        // Check if the symlink already exists
        $symlinkPath = $enabledDir . $domain . '.conf';
        if (!File::exists($symlinkPath)) {
            if (!symlink($configFile, $symlinkPath)) {
                throw new Exception("Failed to create symlink for $domain.");
            }
        }

        // Reload Apache to apply the changes
        $output = null;
        $resultCode = null;
        exec("sudo systemctl reload apache2", $output, $resultCode);

        if ($resultCode !== 0) {
            throw new Exception("Failed to reload Apache server.");
        }
    }
}
