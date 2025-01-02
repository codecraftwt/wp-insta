<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DomainPointingController extends Controller
{
    public function domainPointing(Request $request)
    {
        // Fetch configuration values
        $server_ip = config('site.server_ip');
        $site_path = config('site.site_path');
        $apache_config_path = config('site.apache_config_path');
        $apache_service_path = config('site.apache_service_path');
        $folderPath = public_path('apache_config'); // Folder to save Apache configs

        // Get the input data from the request
        $domainname = $request->input('domainname');
        $directory = $request->input('defsitename');

        try {
            // 1. Validate that domainname and directory are provided
            if (empty($domainname) || empty($directory)) {
                return response()->json(['error' => 'Domain name and directory are required.'], 400);
            }

            // 2. Create directory if it does not exist
            $siteDirectoryPath = $site_path . '/' . $directory;
            $this->createDirectory($siteDirectoryPath);

            // 3. Set permissions for the directory (recursively)
            $this->setPermissionsRecursively($siteDirectoryPath);

            // 4. Create Apache config file for the domain
            $this->createApacheConfig($domainname, $siteDirectoryPath, $folderPath);

            // 5. Enable site and reload Apache
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
            File::makeDirectory($path, 0755, true);  // Create directory with permissions
        }
    }

    // Function to set permissions recursively for all directories and files
    private function setPermissionsRecursively($path)
    {
        // Set ownership and permissions (assuming www-data user)
        $this->setPermissions($path);

        // Get all files and directories within the specified path
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        // Iterate through each file/directory and set permissions
        foreach ($files as $fileinfo) {
            if ($fileinfo->isDir()) {
                chmod($fileinfo->getRealPath(), 0755); // Set directory permissions
                chown($fileinfo->getRealPath(), 'www-data'); // Set ownership
            } else {
                chmod($fileinfo->getRealPath(), 0644); // Set file permissions
                chown($fileinfo->getRealPath(), 'www-data'); // Set ownership
            }
        }
    }

    // Function to set permissions for the directory (single level)
    private function setPermissions($path)
    {
        // Set ownership and permissions (assuming www-data user)
        chown($path, 'www-data');
        chmod($path, 0755);
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
        try {
            File::put($configFile, $config);
        } catch (Exception $e) {
            throw new Exception("Failed to create Apache config file: " . $e->getMessage());
        }
    }

    // Function to enable the site by creating a symlink and reloading Apache
    private function enableSiteAndReload($domain, $folderPath)
    {
        $configFile = "$folderPath/$domain.conf";
        $enabledDir = '/etc/apache2/sites-enabled/';

        // Ensure the 'sites-enabled' directory exists
        if (!File::exists($enabledDir)) {
            try {
                File::makeDirectory($enabledDir, 0755, true);
            } catch (Exception $e) {
                throw new Exception("Failed to create 'sites-enabled' directory: " . $e->getMessage());
            }
        }

        // Check if the symlink already exists
        $symlinkPath = $enabledDir . $domain . '.conf';
        if (!File::exists($symlinkPath)) {
            try {
                if (symlink($configFile, $symlinkPath)) {
                    echo "Symlink created successfully for $domain.<br>";
                } else {
                    echo "Failed to create symlink for $domain.<br>";
                }
            } catch (Exception $e) {
                throw new Exception("Failed to create symlink: " . $e->getMessage());
            }
        } else {
            echo "Symlink already exists for $domain.<br>";
        }

        // Simulate Apache reload via HTTP (you can modify this to actually trigger a reload in your environment)
        try {
            file_get_contents("http://localhost/reload-apache.php");
        } catch (Exception $e) {
            throw new Exception("Failed to reload Apache: " . $e->getMessage());
        }
    }
}
