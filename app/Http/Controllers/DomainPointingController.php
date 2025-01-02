<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DomainPointingController extends Controller
{




    // public function domainpointing(Request $request)
    // {


    //     // config get 
    //     $server_ip = config('site.server_ip');
    //     $site_path = config('site.site_path');
    //     $apache_config_path = config('site.apache_config_path');
    //     $apache_service_path = config('site.apache_service_path');

    //     $folderPath = public_path('apache_config/');
    //     // Get the input data from the request
    //     $domainname = $request->input('domainname');
    //     $directory = $request->input('defsitename');


    //     dd($domainname, $directory, $server_ip, $apache_config_path, $apache_service_path, $site_path, $folderPath);
    // }

    public function domainPointing(Request $request)
    {
        // Fetch configuration values
        $server_ip = config('site.server_ip');
        $site_path = config('site.site_path');
        $apache_config_path = config('site.apache_config_path');
        $apache_service_path = config('site.apache_service_path');
        $folderPath = public_path('apache_config/'); // Folder to save Apache configs

        // Get the input data from the request
        $domainname = $request->input('domainname');
        $directory = $request->input('defsitename');



        try {
            // Example actions that can be performed after getting the data
            // (For example, directory creation, permissions setting, and Apache config generation)

            // 1. Validate that domainname and directory are provided
            if (empty($domainname) || empty($directory)) {
                return response()->json(['error' => 'Domain name and directory are required.'], 400);
            }

            // 2. Create directory if it does not exist
            $siteDirectoryPath = $site_path . '/' . $directory;
            $this->createDirectory($siteDirectoryPath);

            // 3. Set permissions for the directory
            $this->setPermissions($siteDirectoryPath);

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
            File::makeDirectory($path, 0755, true);
            // Optionally log or return success message
        }
    }

    // Function to set permissions for the directory
    private function setPermissions($path)
    {
        // Set ownership and permissions (assuming www-data user)
        chown($path, 'www-data');
        chmod($path, 0755);
        // Optionally log or return success message
    }

    // Function to create the Apache config file for the domain
    private function createApacheConfig($domain, $directory, $folderPath)
    {
        // Define Apache configuration without log file definitions
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
        File::put($configFile, $config);
    }



    // Function to enable the site by creating a symlink and reloading Apache
    private function enableSiteAndReload($domain, $folderPath)
    {
        $configFile = "$folderPath/$domain.conf";
        $enabledDir = '/etc/apache2/sites-enabled/';

        // Ensure the 'sites-enabled' directory exists
        if (!File::exists($enabledDir)) {
            File::makeDirectory($enabledDir, 0755, true);
        }

        // Symbolically link the config file to 'sites-enabled'
        symlink($configFile, $enabledDir . $domain . '.conf');

        // Simulate Apache reload via HTTP (you can modify this to actually trigger a reload in your environment)
        file_get_contents("http://localhost/reload-apache.php");
    }
}
