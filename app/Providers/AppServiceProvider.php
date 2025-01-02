<?php

namespace App\Providers;

use App\Models\ManageSite;
use App\Models\ManageUser;
use App\Models\PaymentSetting;
use App\Models\SiteSettingModel;
use Illuminate\Support\ServiceProvider;
use App\Models\SMPTModel;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

use Illuminate\Support\Facades\DB;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Check if the table exists
        if (Schema::hasTable('smpt_setting_table')) {
            // Attempt to retrieve SMTP settings
            $smtpSetting = SMPTModel::where('status', '1')->first();

            if ($smtpSetting) {
                Config::set('mail.mailers.smtp.host', $smtpSetting->mail_host);
                Config::set('mail.mailers.smtp.port', $smtpSetting->mail_port);
                Config::set('mail.mailers.smtp.username', $smtpSetting->mail_username);
                Config::set('mail.mailers.smtp.password', $smtpSetting->mail_password);
                Config::set('mail.mailers.smtp.encryption', $smtpSetting->mail_encryption);
                Config::set('mail.from.address', $smtpSetting->mail_from_address);
                Config::set('mail.from.name', $smtpSetting->mail_from_name);
            }
        }


        // Load payment settings
        if (Schema::hasTable('payment_settings_table')) {
            $paymentSetting = PaymentSetting::where('status', '1')->first();
            if ($paymentSetting) {
                // Ensure the retrieved values are strings or arrays
                Config::set('services.stripe.key', $paymentSetting->stripe_key);
                Config::set('services.stripe.secret', $paymentSetting->stripe_secret);
            }
        }

        if (Schema::hasTable('site_setting_table')) {
            $siteSetting = SiteSettingModel::first(); // Adjust the query as needed

            if ($siteSetting) {
                // Share site settings with all views
                View::share('siteSetting', $siteSetting);
            }
        }

        Config::set('site.base_url', env('BASE_URL', 'http://localhost/wp-insta/'));
        Config::set('site.folder_url', env('FOLDER_URL', 'public/wp_sites/'));
        Config::set('site.mysql_password', env('SERVER_MYSQL_PASSWORD', ''));
        Config::set('site.mysql_user', env('SERVER_MYSQL_USER', 'root'));
        Config::set('site.for_image', env('FOR_IMAGE', 'http://127.0.0.1:8000/'));

        //SERVER DOMAIN Config

        Config::set('site.server_ip', env('SERVER_IP', '139.84.151.191'));
        Config::set('site.site_path', env('SITE_PATH', '/var/www/html/my-laravel-app/public'));
        Config::set('site.apache_config_path', env('APACHE_CONFIG_PATH', '/var/www/html/my-laravel-app/public'));
        Config::set('site.apache_service_path', env('APACHE_SERVICE_PATH', '/usr/sbin/apache2ctl'));

        Blade::componentNamespace('App\\View\\Components', 'structures');

        View::composer('*', function ($view) {
            $view->with('userStorage', $this->getUserStorage());
        });
    }


    // private function getUserStorage()
    // {
    //     $authId = auth()->user()->id ?? null;

    //     // Get all entries from ManageSite where user_id matches the authenticated user's ID
    //     $storage = ManageSite::where('user_id', $authId)->get();
    //     $userData = ManageUser::where('user_id', $authId)
    //         ->select('storage',)
    //         ->first();
    //     $usersite = ManageUser::where('user_id', $authId)
    //         ->select('no_sites')
    //         ->first();

    //     $storagelimite = $userData->storage ?? null;
    //     $totalStorage = 0;
    //     $totalDatabaseStorage = 0;

    //     foreach ($storage as $site) {
    //         $folderPath = public_path('wp_sites/' . $site->folder_name);
    //         $databaseName = $site->db_name;

    //         if (is_dir($folderPath)) {
    //             $folderSize = $this->getFolderSize($folderPath);
    //             $totalStorage += $folderSize;
    //         }

    //         $databaseSize = $this->getDatabaseSize($databaseName);
    //         $totalDatabaseStorage += $databaseSize;
    //     }

    //     $totalusages = $totalStorage + $totalDatabaseStorage;

    //     return [
    //         'total_storage' => $this->formatSize($totalStorage),
    //         'database_storage' => $this->formatSize($totalDatabaseStorage),
    //         'totalusages' => $this->formatSize($totalusages),
    //         'storage' => $storagelimite,
    //         'usersite' => $usersite ? $usersite->no_sites : 0,
    //     ];
    // }


    // private function getUserStorage()
    // {
    //     $authId = auth()->user()->id ?? null;

    //     // Cache the user storage for 30  (30 seconds)
    //     return Cache::remember("user_storage_{$authId}", 30, function () use ($authId) {
    //         // Get all entries from ManageSite where user_id matches the authenticated user's ID
    //         $storage = ManageSite::where('user_id', $authId)->get();
    //         $userData = ManageUser::where('user_id', $authId)
    //             ->select('storage')
    //             ->first();
    //         $usersite = ManageUser::where('user_id', $authId)
    //             ->select('no_sites')
    //             ->first();

    //         $storagelimite = $userData->storage ?? null;
    //         $totalStorage = 0;
    //         $totalDatabaseStorage = 0;

    //         foreach ($storage as $site) {
    //             $folderPath = public_path('wp_sites/' . $site->folder_name);
    //             $databaseName = $site->db_name;

    //             if (is_dir($folderPath)) {
    //                 $folderSize = $this->getFolderSize($folderPath);
    //                 $totalStorage += $folderSize;
    //             }

    //             $databaseSize = $this->getDatabaseSize($databaseName);
    //             $totalDatabaseStorage += $databaseSize;
    //         }

    //         $totalusages = $totalStorage + $totalDatabaseStorage;

    //         return [
    //             'total_storage' => $this->formatSize($totalStorage),
    //             'database_storage' => $this->formatSize($totalDatabaseStorage),
    //             'totalusages' => $this->formatSize($totalusages),
    //             'storage' => $storagelimite,
    //             'usersite' => $usersite ? $usersite->no_sites : 0,
    //         ];
    //     });
    // }


    private function getUserStorage()
    {
        $authId = auth()->user()->id ?? null;

        // Cache the user storage for 30 seconds
        return Cache::remember("user_storage_{$authId}", 30, function () use ($authId) {
            // Get all entries from ManageSite where user_id matches the authenticated user's ID
            $storage = ManageSite::where('user_id', $authId)->get();
            $userData = ManageUser::where('user_id', $authId)
                ->select('storage')
                ->first();
            $usersite = ManageUser::where('user_id', $authId)
                ->select('no_sites')
                ->first();

            $storagelimite = $userData->storage ?? null;
            $totalStorage = 0;
            $totalDatabaseStorage = 0;
            $siteCount = 0;

            foreach ($storage as $site) {
                $folderPath = public_path('wp_sites/' . $site->folder_name);
                $databaseName = $site->db_name;

                if (is_dir($folderPath)) {
                    $folderSize = $this->getFolderSize($folderPath);
                    $totalStorage += $folderSize;
                    $siteCount++;
                }

                $databaseSize = $this->getDatabaseSize($databaseName);
                $totalDatabaseStorage += $databaseSize;
            }

            $totalusages = $totalStorage + $totalDatabaseStorage;

            return [
                'total_storage' => $this->formatSize($totalStorage),
                'database_storage' => $this->formatSize($totalDatabaseStorage),
                'totalusages' => $this->formatSize($totalusages),
                'storage' => $storagelimite,
                'usersite' => $usersite ? $usersite->no_sites : 0,
                'site_count' => $siteCount,
            ];
        });
    }


    private function getFolderSize($folder)
    {
        $totalSize = 0;

        foreach (
            new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($folder, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::LEAVES_ONLY
            ) as $file
        ) {
            $totalSize += $file->getSize();
        }

        return $totalSize;
    }

    private function getDatabaseSize($databaseName)
    {
        $sizeQuery = DB::select("
            SELECT table_schema AS database_name,
                   SUM(data_length + index_length) AS database_size
            FROM information_schema.tables
            WHERE table_schema = ?
            GROUP BY table_schema
        ", [$databaseName]);

        return $sizeQuery ? $sizeQuery[0]->database_size : 0;
    }

    private function formatSize($size)
    {
        if ($size >= 1073741824) {
            return number_format($size / 1073741824, 2) . ' GB';
        } elseif ($size >= 1048576) {
            return number_format($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) {
            return number_format($size / 1024, 2) . ' KB';
        } else {
            return $size . ' bytes';
        }
    }
}
