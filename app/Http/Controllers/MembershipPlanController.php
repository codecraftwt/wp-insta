<?php

namespace App\Http\Controllers;

use App\Models\ManageUser;
use App\Models\PaymentModel;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;
use Stripe\StripeClient;
use Stripe\Product;
use Stripe\Price;
use App\Models\MembershipPlan;
use Carbon\Carbon;
use Illuminate\Support\FacadesLog;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MembershipPlanController extends Controller
{

    public function createMembershipPlan(Request $request)
    {

        $stripeSecret = Config::get('services.stripe.secret');

        $stripe = new StripeClient($stripeSecret);

        // Validate incoming request
        $request->validate([
            'plain_title' => 'required',
            'plan_description' => 'required',
            'plan_price' => 'required',
            'plan_details' => 'required',
            'plan_type' => 'required',
        ]);



        try {
            // Create a product using the Stripe client
            $product = $stripe->products->create([
                'name' => $request->plain_title,
                'description' => $request->plan_description,
            ]);

            $price = $stripe->prices->create([
                'unit_amount' => $request->plan_price * 100,
                'currency' => 'usd',
                'recurring' => ['interval' => $request->plan_type],
                'product' => $product->id,
            ]);

            // Store membership plan details in the database
            $membershipPlan = MembershipPlan::create([
                'plain_title' => $request->plain_title,
                'plan_description' => $request->plan_description,
                'stripe_product_id' => $product->id,
                'plan_price' => $request->plan_price,
                'plan_details' => $request->plan_details,
                'plan_type' => $request->plan_type,
            ]);

            return redirect()->back()->with('success', 'Membership plan created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating membership plan: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function getMembershipPlan()
    {

        $mp = MembershipPlan::all();

        return response()->json(['data' => $mp]);
    }

    public function deleteMembershipPlan($id)
    {

        $plan = MembershipPlan::find($id);

        if ($plan) {
            $plan->delete();
            return response()->json(['message' => 'Membership plan deleted successfully!']);
        } else {
            return response()->json(['message' => 'Membership plan not found!'], 404);
        }
    }

    public function showSubscriptionPage()
    {
        $membershipPlans = MembershipPlan::all();
        return view('pages.subscription', compact('membershipPlans'));
    }
    public function getSubscriptiondetail()
    {
        $membershipPlans = MembershipPlan::all();



        foreach ($membershipPlans as $plan) {

            $plan->plan_details = preg_replace(
                '/<(h[1-6])>/i',
                '<$1 style="text-align: left;">',
                str_replace(
                    '<ul>',
                    '<ul style="text-align: center;">',
                    str_replace('<li>', '<li><i class="bi bi-check2-circle"></i> ', $plan->plan_details)
                )
            );
        }

        return response()->json($membershipPlans);
    }


    //Renew Subscription Plans
    public function renewpage()
    {


        return view('pages.renewplans');
    }

    public function getRenewPlansJson()
    {
        $user = auth()->user(); // Ensure the user is authenticated

        // Fetch the user's current active subscription
        $currentPlan = ManageUser::where('user_id', $user->id)
            ->where('subscription_status', 1) // Active subscription
            ->first();

        // Fetch all available membership plans
        $membershipPlans = MembershipPlan::all();

        // Format plan details for display
        foreach ($membershipPlans as $plan) {
            $plan->plan_details = preg_replace(
                '/<(h[1-6])>/i',
                '<$1 style="text-align: left;">',
                str_replace(
                    '<ul>',
                    '<ul style="text-align: center;">',
                    str_replace('<li>', '<li><i class="bi bi-check2-circle"></i> ', $plan->plan_details)
                )
            );
        }

        return response()->json([
            'currentPlan' => $currentPlan,
            'membershipPlans' => $membershipPlans
        ]);
    }



    // public function filterByCurrency(Request $request)
    // {
    //     $plan = MembershipPlan::find($request->plan_id);
    //     $currency = $request->currency;

    //     // Convert the price based on the selected currency
    //     $updatedPrice = $this->convertPrice($plan->plan_price, $currency);
    //     return response()->json(['updated_price' => $updatedPrice]);
    // }

    // private function convertPrice($price, $currency)
    // {
    //     $apiKey = 'ba23bef31024d47078e78361'; // API Key for Exchange Rate API
    //     $baseCurrency = 'USD'; // Default currency (USD)
    //     $endpoint = 'https://v6.exchangerate-api.com/v6/' . $apiKey . '/latest/' . $baseCurrency;

    //     // Return price as is if the selected currency is the same as the base currency
    //     if ($currency === $baseCurrency) {
    //         return $price;
    //     }

    //     // Make API call to get exchange rate only if the currencies differ
    //     try {
    //         $response = Http::get($endpoint);

    //         // Check if the API call was successful and contains the required data
    //         $exchangeRates = $response->json()['conversion_rates'] ?? null;

    //         if (!$exchangeRates || !isset($exchangeRates[strtoupper($currency)])) {
    //             Log::warning("Exchange rate not available for currency: " . strtoupper($currency));
    //             return $price; // Return the original price if the rate is not available
    //         }

    //         // Retrieve the exchange rate for the selected currency
    //         $exchangeRate = $exchangeRates[strtoupper($currency)];

    //         // Return the converted price
    //         return $price * $exchangeRate;
    //     } catch (\Exception $e) {
    //         // Log the exception if it occurs
    //         Log::error('Error during currency conversion: ' . $e->getMessage());
    //         return $price; // Return the original price if any error occurs
    //     }
    // }

    public function filterByCurrency(Request $request)
    {
        $plan = MembershipPlan::find($request->plan_id);
        $currency = strtoupper($request->currency);

        // Convert price based on dynamic currency
        $updatedPrice = $this->convertPrice($plan->plan_price, $currency);

        return response()->json([
            'updated_price' => $updatedPrice,
            'currency' => $currency // You may also want to return the currency so the front end can display the correct symbol
        ]);
    }

    private function convertPrice($price, $currency)
    {
        // Example: Fetch live exchange rates
        $response = Http::get('https://api.exchangerate-api.com/v4/latest/USD');
        $rates = $response->json()['rates'];

        // If the currency exists in the rates, convert; otherwise, return the original price
        return isset($rates[$currency]) ? $price * $rates[$currency] : $price;
    }




    // Renew or Buy Subscription Plan
    public function renewOrBuyPlan(Request $request)
    {
        $userId = auth()->id();
        $paymentSetting = PaymentSetting::where('status', '1')->first();

        // Validate incoming request data
        $validatedData = $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'subscription_type' => 'required',
            'price' => 'required|numeric',
            'duration' => 'required',
            'plain_id' => 'required',
        ]);

        // Store user details in session
        session([
            'user_details' => [
                'subscription_type' => $validatedData['subscription_type'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'duration' => $validatedData['duration'],
            ],
            'userId' => $userId,
        ]);

        $stripe = new StripeClient($paymentSetting->stripe_secret);

        try {
            // Create the product
            $product = $stripe->products->create([
                'name' => $validatedData['subscription_type'],
            ]);

            // Create the price
            $price = $stripe->prices->create([
                'unit_amount' => $validatedData['price'] * 100,
                'currency' => 'usd',
                'recurring' => [
                    'interval' => $validatedData['duration'] === 'month' ? 'month' : 'year',
                ],
                'product' => $product->id,
            ]);

            // Create a checkout session in subscription mode
            $checkoutSession = $stripe->checkout->sessions->create([
                'mode' => 'subscription',
                'payment_method_types' => ['card'],
                'customer_email' => auth()->user()->email,
                'line_items' => [
                    [
                        'price' => $price->id,
                        'quantity' => 1,
                    ],
                ],
                'success_url' => route('renewsuccess'),
                'cancel_url' => route('payment.cancel'),
            ]);

            // Save the session ID to the session
            session(['checkout_session_id' => $checkoutSession->id]);

            return response()->json(['checkout_url' => $checkoutSession->url]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    // public function renewSuccess(Request $request)
    // {
    //     // Retrieve session information for the payment session
    //     $checkoutSessionId = session('checkout_session_id');
    //     if (!$checkoutSessionId) {
    //         return redirect()->route('renewplans')->with('error', 'Session expired or invalid.');
    //     }

    //     // Retrieve user details from the session
    //     $userDetails = session('user_details');
    //     $userId = session('userId');



    //     $paymentSetting = PaymentSetting::where('status', '1')->first();
    //     $stripe = new StripeClient($paymentSetting->stripe_secret);

    //     try {
    //         // Retrieve the checkout session from Stripe
    //         $session = $stripe->checkout->sessions->retrieve($checkoutSessionId);

    //         if ($session->payment_status === 'paid') {
    //             // Fetch the user from the authenticated user (assuming it's the same as the session user)
    //             $user = auth()->user();

    //             // Save the payment record in the PaymentModel
    //             PaymentModel::create([
    //                 'user_id' => $user->id,
    //                 'name' => $session->customer_details->name ?? 'N/A',
    //                 'status' => 1,
    //                 'type' => $userDetails['subscription_type'], // Use the session data
    //                 'payment_id' => $session->id,
    //                 'email' => $session->customer_details->email ?? 'N/A',
    //                 'amount' => $session->amount_total / 100, // Convert cents to dollars
    //                 'payment_intent' => $session->payment_intent,
    //                 'stripe_key' => $paymentSetting->stripe_key,
    //                 'stripe_secret' => $paymentSetting->stripe_secret,
    //             ]);

    //             // Update user subscription details
    //             $manageUser = ManageUser::where('user_id', $userId)->first();
    //             if ($manageUser) {
    //                 $manageUser->update([
    //                     'subscription_status' => 1,
    //                     'subscription_type' => $userDetails['subscription_type'],
    //                     'start_date' => $userDetails['start_date'],
    //                     'end_date' => $userDetails['end_date'],
    //                     'status' => 1,
    //                     'duration' =>  $userDetails['duration'],
    //                 ]);
    //             } else {
    //                 return redirect()->back()->with('error', 'User subscription details not found.');
    //             }

    //             // Clear the session
    //             session()->forget('checkout_session_id');
    //             session()->forget('user_details');

    //             // Redirect back with a success message
    //             return redirect()->back()->with('success', 'Subscription renewed successfully!');
    //         } else {
    //             return redirect()->back()->with('error', 'Payment failed. Please try again.');
    //         }
    //     } catch (\Exception $e) {
    //         // Catch any exceptions and show an error message
    //         return redirect()->back()->with('error', 'Error verifying payment: ' . $e->getMessage());
    //     }
    // }


    public function renewSuccess(Request $request)
    {
        // Retrieve session information for the payment session
        $checkoutSessionId = session('checkout_session_id');
        if (!$checkoutSessionId) {
            return redirect()->route('renewplans')->with('error', 'Session expired or invalid.');
        }

        // Retrieve user details from the session
        $userDetails = session('user_details');
        $userId = session('userId');

        $paymentSetting = PaymentSetting::where('status', '1')->first();
        $stripe = new StripeClient($paymentSetting->stripe_secret);

        try {
            // Retrieve the checkout session from Stripe
            $session = $stripe->checkout->sessions->retrieve($checkoutSessionId);

            if ($session->payment_status === 'paid') {
                // Fetch the user from the authenticated user (assuming it's the same as the session user)
                $user = auth()->user();

                // Save the payment record in the PaymentModel
                PaymentModel::create([
                    'user_id' => $user->id,
                    'name' => $session->customer_details->name ?? 'N/A',
                    'status' => 1,
                    'type' => $userDetails['subscription_type'], // Use the session data
                    'payment_id' => $session->id,
                    'email' => $session->customer_details->email ?? 'N/A',
                    'amount' => $session->amount_total / 100, // Convert cents to dollars
                    'payment_intentcls
                    ' => $session->subscription, // Save the subscription ID
                    'stripe_key' => $paymentSetting->stripe_key,
                    'stripe_secret' => $paymentSetting->stripe_secret,
                ]);

                // Update user subscription details
                $manageUser = ManageUser::where('user_id', $userId)->first();
                if ($manageUser) {
                    $manageUser->update([
                        'subscription_status' => 1,
                        'subscription_type' => $userDetails['subscription_type'],
                        'start_date' => $userDetails['start_date'],
                        'end_date' => $userDetails['end_date'],
                        'status' => 1,
                        'duration' =>  $userDetails['duration'],
                    ]);
                } else {
                    return redirect()->back()->with('error', 'User subscription details not found.');
                }

                // Clear the session
                session()->forget('checkout_session_id');
                session()->forget('user_details');

                // Redirect back with a success message
                return redirect()->back()->with('success', 'Subscription renewed successfully!');
            } else {
                return redirect()->back()->with('error', 'Payment failed. Please try again.');
            }
        } catch (\Exception $e) {
            // Catch any exceptions and show an error message
            return redirect()->back()->with('error', 'Error verifying payment: ' . $e->getMessage());
        }
    }
}
