<?php

namespace App\Providers;

use App\Models\PaymentSetting;
use App\Models\SiteSettingModel;
use Illuminate\Support\ServiceProvider;
use App\Models\SMPTModel;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

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

        Blade::componentNamespace('App\\View\\Components', 'structures');
    }
}
