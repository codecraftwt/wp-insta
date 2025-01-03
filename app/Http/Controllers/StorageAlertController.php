<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FiftyPerStorageUsageAlert;
use App\Mail\NinetyPerStorageUsageAlert;
use App\Mail\HundredPerStorageUsageAlert;
use Illuminate\Support\Facades\Auth;

class StorageAlertController extends Controller
{
    // public function checkAndSendStorageAlert(Request $request)
    // {
    //     $user = Auth::user();
    //     $usedPercentage = $request->input('usedPercentage'); // Get the usage percentage from the frontend.

    //     // If the percentage is 50 or above, send an email alert
    //     if ($usedPercentage >= 50) {
    //         // Send an email alert to the user.
    //         Mail::to($user->email)->send(new FiftyPerStorageUsageAlert($user, $usedPercentage));

    //         return response()->json(['message' => 'Alert email sent successfully'], 200);
    //     }

    //     return response()->json(['message' => 'Usage below threshold, no email sent'], 200);
    // }

    // public function checkAndSendStorageAlert(Request $request)
    // {
    //     $user = Auth::user();
    //     $usedPercentage = $request->input('usedPercentage');


    //     if ($usedPercentage >= 50 && !session('storage_alert_sent')) {

    //         Mail::to($user->email)->send(new FiftyPerStorageUsageAlert($user, $usedPercentage));


    //         session(['storage_alert_sent' => true]);

    //         return response()->json(['message' => 'Alert email sent successfully'], 200);
    //     }

    //     return response()->json(['message' => 'Usage below threshold or email already sent'], 200);
    // }

    // 50% Storage Alert
    public function checkAndSendFiftyPercentStorageAlert(Request $request)
    {
        $user = Auth::user();
        $usedPercentage = $request->input('usedPercentage');

        if ($usedPercentage >= 50 && !session('fifty_percent_alert_sent')) {
            Mail::to($user->email)->send(new FiftyPerStorageUsageAlert($user, $usedPercentage));
            session(['fifty_percent_alert_sent' => true]);

            return response()->json(['message' => '50% Alert email sent successfully'], 200);
        }

        return response()->json(['message' => 'Usage below 50% threshold or email already sent'], 200);
    }

    // 90% Storage Alert
    public function checkAndSendNinetyPercentStorageAlert(Request $request)
    {
        $user = Auth::user();
        $usedPercentage = $request->input('usedPercentage');

        if ($usedPercentage >= 90 && !session('ninety_percent_alert_sent')) {
            Mail::to($user->email)->send(new NinetyPerStorageUsageAlert($user, $usedPercentage));
            session(['ninety_percent_alert_sent' => true]);

            return response()->json(['message' => '90% Alert email sent successfully'], 200);
        }

        return response()->json(['message' => 'Usage below 90% threshold or email already sent'], 200);
    }

    // 100% Storage Alert
    public function checkAndSendHundredPercentStorageAlert(Request $request)
    {
        $user = Auth::user();
        $usedPercentage = $request->input('usedPercentage');

        if ($usedPercentage >= 100 && !session('hundred_percent_alert_sent')) {
            Mail::to($user->email)->send(new HundredPerStorageUsageAlert($user, $usedPercentage));
            session(['hundred_percent_alert_sent' => true]);

            return response()->json(['message' => '100% Alert email sent successfully'], 200);
        }

        return response()->json(['message' => 'Usage below 100% threshold or email already sent'], 200);
    }
}
