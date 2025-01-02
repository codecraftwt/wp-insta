<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

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
            // Validate that domainname and directory are provided
            if (empty($domainname) || empty($directory)) {
                return response()->json(['error' => 'Domain name and directory are required.'], 400);
            }

            // 1. Create the site directory if it does not exist
            $siteDirectoryPath = $site_path . '/' . $directory;
            $this->createDirectory($siteDirectoryPath);

            // 2. Set the correct permissions for the site directory
            $this->setPermissions($siteDirectoryPath);

            // 3. Create the Apache config file for the domain
            $this->createApacheConfig($domainname, $siteDirectoryPath, $folderPath);

            // 4. Enable the site by creating a symlink and reload Apache
            $this->enableSiteAndReload($domainname, $folderPath);

            // Return success message
            return response()->json(['message' => 'Domain pointing configuration completed successfully.']);
        } catch (Exception $e) {
            // Log the error and return the exception message as response
            Log::error("Error in domain pointing: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Function to create directory if it doesn't exist
    private function createDirectory($path)
    {
        if (!File::exists($path)) {
            if (!File::makeDirectory($path, 0755, true)) {
                throw new Exception("Failed to create directory: $path");
            }
        }
    }

    // Function to set permissions for the directory
    private function setPermissions($path)
    {
        // Ensure the directory is writable by the web server user (www-data)
        if (!is_writable($path)) {
            if (!chown($path, 'www-data')) {
                throw new Exception("Failed to change ownership of directory $path.");
            }
            if (!chmod($path, 0755)) {
                throw new Exception("Failed to set permissions for directory $path.");
            }
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

        // Check if the folder path is writable
        if (!is_writable($folderPath)) {
            throw new Exception("Folder $folderPath is not writable.");
        }

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
            // Create symlink using sudo to bypass permission issue
            $command = "sudo ln -s $configFile $symlinkPath";
            $output = null;
            $resultCode = null;
            exec($command, $output, $resultCode);

            if ($resultCode !== 0) {
                throw new Exception("Failed to create symlink for $domain. Error: " . implode("\n", $output));
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
