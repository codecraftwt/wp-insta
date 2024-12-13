<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManageRolesController;
use App\Http\Controllers\SMTPController;
use App\Http\Controllers\ManageUsers;
use App\Http\Controllers\ManageSiteController;
use App\Http\Controllers\WP\CreateWordpressController;
use App\Http\Controllers\WP\WPController;
use App\Http\Controllers\WP\WPThemsController;
use App\Http\Controllers\WP\WPVersionController;
use App\Http\Controllers\PluginCategoriesController;
use App\Http\Controllers\MembershipPlanController;
use App\Http\Controllers\MainController; //COUNT OF CONTROLLER
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Cache;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes(['reset' => true]);
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');




//Register
Route::post('/userRegister', [PaymentController::class, 'userRegister'])->name('userRegister');
Route::get('/payment-success', [PaymentController::class, 'paymentSuccessregister'])->name('payment.successregister');
Route::get('/payment-cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');


//paymenthistory
Route::get('/payment-history', [PaymentController::class, 'paymenthistory'])->name('payment.history');


//getpaymenthistory record
Route::get('/get-paymenthistory', [PaymentController::class, 'getpaymenthistory']);


//PAYMENT USING UPGRADE
Route::post('/upgradeplan', [PaymentController::class, 'upgradeplan'])->name('upgradeplan');
Route::get('/upgradepaymentsuccess', [PaymentController::class, 'upgradepaymentsuccess'])->name('upgradepaymentsuccess');
Route::get('/upgradepaymentcancle', [PaymentController::class, 'upgradepaymentcancle'])->name('upgradepaymentcancle');


//COUPNS
Route::post('/create-coupon', [PaymentController::class, 'createCoupon'])->name('create.coupon');
Route::view('/coupons', 'pages.coupon');
Route::get('/getCoupon', [PaymentController::class, 'getCoupon'])->name('getCoupon');


//register PAGES
Route::view('/subscription-plans', 'auth.subscription-plans');
Route::view('/register', 'auth.newregister');


//Subscription Detail
Route::get('/getSubscriptiondetail', [MembershipPlanController::class, 'getSubscriptiondetail'])->name('getSubscriptiondetail');


Route::post('/dismiss-notification', function () {
    // Store a flag or action to mark the notification as dismissed
    session()->put('notification_dismissed', true);  // Example, store in session

    return response()->json(['status' => 'success']);
})->name('dismissNotification');




// All OTHERS  PAGES
Route::view('/contact', 'auth.contact')->name('contact');
Route::view('/templates', 'auth.templates')->name('templates');
Route::view('/services', 'auth.services')->name('services');
Route::view('/terms', 'auth.terms')->name('terms');
Route::view('/thankyou', 'auth.thankyou')->name('thankyou');
Route::view('/about', 'auth.about')->name('about');


//MIDDLE
Route::middleware(['auth'])->group(function () {


    Route::put('/profile/update', [MainController::class, 'update'])->name('profile.update');

    //CONT OF ALL
    Route::get('/getcount', [MainController::class, 'wpdatacount'])->name('getcount');

    // Route to fetch new notifications (notification_status = 0)
    Route::get('/notifications/new-register', [MainController::class, 'notificationNewRegister']);

    // Route to mark (update notification_status to 1)
    Route::post('/notifications/mark-read/', [MainController::class, 'markNotificationsAsRead']);

    //ALL SITES MANAGE
    Route::get('/sites-info', [MainController::class, 'index'])->name('sites-info');
    Route::get('/sites-data', [MainController::class, 'siteinfo'])->name('sites-data');

    Route::get('/countUsers', [MainController::class, 'countUsersByStatus'])->name('countUsersByStatus');
    Route::get('/upgradeplans', [MainController::class, 'upgradeplans'])->name('upgradeplans');



    //Suggestion Domain Name
    Route::get('/suggesstionname', [MainController::class, 'suggesstionname'])->name('suggesstionname');
    Route::get('/getConfig', [MainController::class, 'getConfig'])->name('getConfig');


    Route::get('/php-config', [MainController::class, 'fetchConfig'])->name('php.config');


    // Create WORDPRESS EXTRACT THEM AND DATABASE AND PLUGIN DOWNLOAD
    Route::get('/wordpress-version', [CreateWordpressController::class, 'wordpress_version']);
    Route::get('/get-plugins', [CreateWordpressController::class, 'getPlugins']);
    Route::post('/download-wordpress', [CreateWordpressController::class, 'downloadWordPress']);
    Route::get('/plugins_categories', [CreateWordpressController::class, 'showPlugins'])->name('plugins.show');
    Route::get('/plugins/byCategory/{id}', [CreateWordpressController::class, 'getByCategory'])->name('plugins.byCategory');
    Route::post('/extractplugin', [CreateWordpressController::class, 'extractplugin']);
    Route::get('/themesforextract', [CreateWordpressController::class, 'themesforextract'])->name('themesforextract');
    Route::get('/get-categories', [CreateWordpressController::class, 'getCategories']);
    Route::get('/get-themes-by-category/{categoryId}', [CreateWordpressController::class, 'getThemesByCategory']);
    Route::post('/extract-themes', [CreateWordpressController::class, 'extractthemes'])->name('extraxt-themes');
    Route::post('/create-database', [CreateWordpressController::class, 'createDatabase'])->name('create.database');
    Route::delete('/delete-site/{id}', [CreateWordpressController::class, 'deletesite'])->name('delete.site');
    Route::post('/stop-site', [CreateWordpressController::class, 'stopsite']);
    Route::post('/resume-site', [CreateWordpressController::class, 'runsite']);
    //Deatils of wordpress
    Route::get('/session-details', [CreateWordpressController::class, 'getAdminDetails']);


    //MANAGE ROLE
    Route::get('/managerole', [ManageRolesController::class, 'index'])->name('managerole');
    Route::get('roles', [ManageRolesController::class, 'index'])->name('roles.index');
    Route::get('roles/get', [ManageRolesController::class, 'getrole'])->name('getrole');
    Route::get('get/rolepermisson', [ManageRolesController::class, 'getrolepermisson'])->name('get-rolepermisson');
    Route::get('edite-rolepermisson', [ManageRolesController::class, 'editepermission'])->name('edite-rolepermisson');
    Route::post('roles/store', [ManageRolesController::class, 'store'])->name('roles.store');
    Route::delete('roles/delete/{id}', [ManageRolesController::class, 'destroy'])->name('roles.destroy');
    Route::put('/update-role/{id}', [ManageRolesController::class, 'update'])->name('update.role');

    // SMPT SETTING
    Route::get('smptsetting', [SMTPController::class, 'showpage'])->name('smptsetting');
    Route::post('/mail_settings', [SMTPController::class, 'store'])->name('mail_settings.store');
    Route::post('/send-mail', [SMTPController::class, 'sendMail'])->name('send.mail');
    Route::get('/admin/smtp-settings', [SMTPController::class, 'edit'])->name('smtp.settings.edit');
    Route::post('/admin/smtp-settings', [SMTPController::class, 'update'])->name('smtp.settings.update');
    Route::get('/getsmtp', [SMTPController::class, 'getsmtp'])->name('getsmtp');
    Route::POST('/smtptoggle/{id}', [SMTPController::class, 'toggleStatus'])->name('smtp.toggle');
    Route::delete('smpt-delete/{id}', [SMTPController::class, 'destroy'])->name('smpt.destroy');
    Route::put('/smtpsettings/{id}', [SmtpController::class, 'update'])->name('smtp.update');

    //ManageUsers
    Route::get('/manageusers', [ManageUsers::class, 'index'])->name('manageusers');
    Route::get('/getusers', [ManageUsers::class, 'getusers'])->name('getusers');
    Route::post('/manageusers', [ManageUsers::class, 'storeusers'])->name('storeusers');
    Route::put('/users/update/{id}', [ManageUsers::class, 'updateusers'])->name('updateusers');
    Route::delete('/users/delete/{id}', [ManageUsers::class, 'destroy']);


    //WP MAterial ALL ->
    //PLUGIN
    Route::get('/plugins', [WPController::class, 'plugin_index'])->name('plugins');
    Route::get('/fetch-plugins', [WPController::class, 'fetchPlugins'])->name('fetch.plugins');
    Route::post('/download-plugin', [WPController::class, 'downloadPlugin'])->name('download.plugin');
    Route::get('/installed-plugins', [WPController::class, 'listInstalledPlugins']);
    Route::delete('/installed-plugins/delete', [WPController::class, 'plugindelete'])->name('plugin.delete');
    Route::post('uploadPlugin', [WPController::class, 'uploadPlugin'])->name('uploadPlugin');
    //Add plugin categories
    Route::resource('/plugin_categories', PluginCategoriesController::class);

    // Themes
    Route::get('/themes', [WPThemsController::class, 'themes_index'])->name('themes');
    Route::get('/fetch-themes', [WPThemsController::class, 'fetchThemes'])->name('fetch.themes');
    Route::post('/download-theme', [WPThemsController::class, 'downloadTheme']);
    Route::delete('/themes/delete', [WPThemsController::class, 'deleteTheme']);
    // UPLOADthemes
    Route::get('/getthemes', [WPThemsController::class, 'getthemes'])->name('getthemes');
    Route::post('uploadthemes', [WPThemsController::class, 'uploadthemes'])->name('uploadthemes');
    // Themes Categories
    Route::get('/themes-categories', [WPThemsController::class, 'themes_categories'])->name('themes_categories');
    Route::post('/storethemescategories', [WPThemsController::class, 'storethemescategories']);
    Route::get('/get-themes-categories', [WPThemsController::class, 'getthemescategories']);
    Route::get('/get-themes-category/{categoryId}', [WPThemsController::class, 'edit'])->name('Themscategory.edit');
    Route::put('/update-themes-category/{categoryId}', [WPThemsController::class, 'updatethemescategories']);
    Route::delete('/deleteCategory/{id}', [WPThemsController::class, 'destroythemescategories']);
    //Create wordpress VERSIONS
    Route::get('/wp-version', [WPVersionController::class, 'version_page'])->name('wp-version');
    Route::post('/versionstore', [WPVersionController::class, 'version_store'])->name('version_store');
    Route::get('/getversions', [WPVersionController::class, 'getversions'])->name('getversions');

    //WP MAterial END <--

    //Payment Configuration
    Route::get('/payment-setting', [PaymentController::class, 'index'])->name('payment.setting'); //Payment Configuration
    Route::get('/getpaymentsetting', [PaymentController::class, 'getpaymentsetting'])->name('getpaymentsetting');
    Route::post('/payment-setting', [PaymentController::class, 'paymentsetting'])->name('payment.store');
    Route::get('/plan-page', [PaymentController::class, 'planpage'])->name('plan.page');
    Route::delete('payment-setting/{id}', [PaymentController::class, 'destroy'])->name('payment-setting.destroy');
    Route::put('payment-setting/update-status/{id}', [PaymentController::class, 'updateStatus'])->name('payment-setting.destroy');


    //RENEW Subscription Plans


    Route::get('/renew-plans-data', [MembershipPlanController::class, 'getRenewPlansJson'])->name('renew.plans.data');
    Route::get('/renew-plans', [MembershipPlanController::class, 'renewpage'])->name('renewplan.page');
    Route::post('/renew-subscription', [MembershipPlanController::class, 'renewOrBuyPlan'])->name('renew.subscription');

    Route::get('/renewsuccess', [MembershipPlanController::class, 'renewSuccess'])->name('renewsuccess');

    // Route for the cancel callback in case the user cancels the payment on Stripe
    Route::get('/cancel', [MembershipPlanController::class, 'cancel'])->name('cancel');

    //MEMBERSHIP ADD CREATE AND VIEW Subscription
    Route::post('/membership-plans', [MembershipPlanController::class, 'createMembershipPlan'])->name('membership.plans.create');
    Route::get('/get-membershipplans', [MembershipPlanController::class, 'getMembershipPlan'])->name('get.membershipplans');
    Route::get('/subscription', [MembershipPlanController::class, 'showSubscriptionPage'])->name('subscription');
    Route::delete('/membershipplans-delete/{id}', [MembershipPlanController::class, 'deleteMembershipPlan']);

    // SiteSettingController
    Route::get('/site-setting', [SiteSettingController::class, 'index'])->name('site.settingpage');
    Route::post('/site-settings', [SiteSettingController::class, 'saveSettings'])->name('site.settings.save'); // Save the settings





    // Permission
    Route::get('/permission', [PermissionController::class, 'index'])->name('permission');
    Route::post('/permission', [PermissionController::class, 'store'])->name('permission-store');
    Route::get('/getpermission', [PermissionController::class, 'getpermission'])->name('get-permission');
    Route::put('/permission/{id}', [PermissionController::class, 'update'])->name('permission.update');
    Route::delete('/permission-delete/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');
});