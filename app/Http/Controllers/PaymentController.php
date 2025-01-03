<?php

namespace App\Http\Controllers;

use App\Models\CouponsModel;
use App\Models\ManageUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentSetting;
use App\Models\PaymentModel;
use Illuminate\Support\Facades\Hash;
use Stripe\Stripe;
use App\Mail\RegistrationThankYouMail;
use Illuminate\Support\Facades\Mail;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    public function upgradeplan(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect if not authenticated
        }
        // Validate the amount
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        // get  Stripe settings from the database
        $paymentSetting = PaymentSetting::where('status', '1')->first();

        // get Stripe client using keys from the db
        $stripe = new StripeClient($paymentSetting->stripe_secret);

        try {

            $response = $stripe->checkout->sessions->create([
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => ['name' => 'WP_INSTA'],
                            'unit_amount' => $validatedData['amount'] * 100,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('upgradepaymentsuccess') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('upgradepaymentcancle'),
            ]);


            return redirect($response->url);
        } catch (\Exception $e) {
            return redirect()->route('paymentcancle')->withErrors('Error creating payment session: ' . $e->getMessage());
        }
    }

    public function upgradepaymentsuccess(Request $request)
    {
        if ($request->has('session_id')) {
            $paymentSetting = PaymentSetting::where('status', '1')->first();

            $stripe = new StripeClient($paymentSetting->stripe_secret);
            $response = $stripe->checkout->sessions->retrieve($request->session_id);

            // user ID
            $userId = Auth::id();
            if (!$userId) {
                return redirect()->route('paymentcancle')->withErrors('User not authenticated');
            }

            $amountInDollars = $response->amount_total / 100;
            $type = $amountInDollars == 190 ? 'Premier' : 'Regular';

            // Save the PaymentModel MODEL
            PaymentModel::create([
                'user_id' => $userId,
                'name' => $response->customer_details->name ?? 'N/A',
                'status' => $response->payment_status,
                'type' => $type,
                'payment_id' => $response->id,
                'email' => $response->customer_details->email ?? 'N/A',
                'amount' => $amountInDollars,
                'payment_intent' => $response->payment_intent,
                'stripe_key' => $paymentSetting->stripe_key,
                'stripe_secret' => $paymentSetting->stripe_secret,
            ]);
            return redirect()->route('home');
        } else {
            return redirect()->route('paymentcancle');
        }
    }

    public function upgradepaymentcancle()
    {
        return 'PAYMENT IS CANCELLED';
    }


    public function index()
    {

        return view('pages.payment_setting');
    }

    public function paymenthistory()
    {

        return view('pages.payment_history');
    }

    public function paymentsetting(Request $request)
    {
        $validatedData = $request->validate([
            'stripe_key' => 'required|string',
            'stripe_secret' => 'required|string',
        ]);


        PaymentSetting::create([
            'stripe_key' => $validatedData['stripe_key'],
            'stripe_secret' => $validatedData['stripe_secret'],
        ]);


        return redirect()->back()->with('success', 'Payment settings saved successfully!');
    }

    public function getpaymentsetting()
    {
        $settings = PaymentSetting::all();

        return response(['data' => $settings]);
    }





    public function getpaymenthistory(Request $request)
    {
        // Capture the start and end dates from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');



        // Check if the user is authenticated and has a role
        if (auth()->check() && auth()->user()->role && auth()->user()->role->name === 'superadmin') {
            // If the user is a superadmin, return all payment records
            $query = PaymentModel::query();
        } else {
            // If the user is not a superadmin, return only their payment records
            $query = PaymentModel::where('user_id', auth()->id());
        }

        // Apply filters based on input parameters
        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('email') && $request->email != '') {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Use whereBetween for start_date and end_date if both are provided
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Get the results and return as JSON
        $history = $query->get();

        return response()->json(['data' => $history]);
    }



    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);

        $paymentSetting = PaymentSetting::find($id);

        if (!$paymentSetting) {
            return response()->json(['success' => false, 'message' => 'Payment setting not found.'], 404);
        }

        // Update the status
        $paymentSetting->status = $request->input('status');
        $paymentSetting->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }


    public function planpage()
    {

        return view('pages.plan');
    }




    public function userRegister(Request $request)
    {
        // Validate input data
        $validatedData = $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'company_name' => 'nullable|string',
            'subscription_type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'plan_id' => 'required',
            'plan_price' => 'required',
            'planType' => 'required',
            'coupon' => 'nullable|string',
            'currency' => 'nullable|string',
            'no_sites' => 'nullable|string',
            'storage' => 'nullable|string',
        ]);


        $currency = $validatedData['currency'] ?? 'usd';
        // Check for valid coupon
        $discount = 0;  // Default no discount
        if ($request->has('coupon') && $request->coupon) {
            $coupon = CouponsModel::where('code', $request->coupon)->first();

            if ($coupon) {
                // Apply coupon discount
                $discount = $coupon->percent_off;  // You can also handle duration, etc., if needed
            } else {
                return response()->json(['message' => 'Invalid coupon code'], 400); // Return error if coupon is invalid
            }
        }

        // If discount is applied, update the plan price
        $planPrice = $validatedData['plan_price'];
        $discountedPrice = $planPrice - ($planPrice * ($discount / 100));

        // Proceed with the subscription process
        if ($validatedData['subscription_type'] === 'FREE' || $validatedData['subscription_type'] === 'Free' || $validatedData['plan_price'] == 0) {
            $user = User::create([
                'name' => $validatedData['name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role_id' => 2,
                'notification_status' => 0
            ]);

            ManageUser::create([
                'user_id' => $user->id,
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'company_name' => $validatedData['company_name'],
                'subscription_status' => 1,
                'subscription_type' => $validatedData['subscription_type'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'status' => 1,
                'duration' => $validatedData['planType'],
                'no_sites' => $validatedData['no_sites'],
                'storage' => $validatedData['storage'],
            ]);

            Mail::to($user->email)->send(new RegistrationThankYouMail($user->email, $validatedData['password']));

            return response()->json([
                'message' => 'User registered successfully! You have a free subscription.',
                'redirect_url' => route('thankyou'), // Return the redirect URL
            ]);
        }

        // Store user data in session for later use
        session(['temp_user' => $validatedData]);

        $paymentSetting = PaymentSetting::where('status', '1')->first();
        Stripe::setApiKey($paymentSetting->stripe_secret);

        // Create a Stripe Checkout session with the discounted price
        // Use the plan_id for subscription-based pricing
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => $currency,
                    'product_data' => [
                        'name' => 'Subscription Plan', // Plan is associated with a subscription product
                    ],
                    'recurring' => [
                        'interval' => 'month',  // Set the subscription interval, e.g., 'month', 'year'
                    ],
                    'unit_amount' => $discountedPrice * 100, // Apply the discounted price
                ],
                'quantity' => 1,
            ]],
            'mode' => 'subscription', // Ensure this is for a recurring payment
            'success_url' => route('payment.successregister'),
            'cancel_url' => route('payment.cancel'),
            'customer_email' => $validatedData['email'],
        ]);

        // Store session ID in the session for later use
        session(['stripe_session_id' => $session->id]);

        // Redirect to the Stripe Checkout page
        return response()->json(['redirect_url' => $session->url]);
    }



    public function paymentSuccessregister()
    {
        // Retrieve temporary user data from session
        $tempUser = session('temp_user');
        $sessionId = session('stripe_session_id');

        // Retrieve payment settings
        $paymentSetting = PaymentSetting::where('status', '1')->first();
        $stripe = new StripeClient($paymentSetting->stripe_secret);

        // Retrieve the Stripe Checkout session
        $session = $stripe->checkout->sessions->retrieve($sessionId);

        // Ensure payment was successful
        if ($tempUser && $session->payment_status === 'paid') {
            // Retrieve subscription ID directly from the session
            $subscriptionId = $session->subscription;

            // If no subscriptionId is found, log an error
            if (empty($subscriptionId)) {
                return redirect()->route('/')->with('error', 'Subscription was not created successfully.');
            }

            // Create the user
            $user = User::create([
                'name' => $tempUser['name'],
                'last_name' => $tempUser['last_name'],
                'email' => $tempUser['email'],
                'password' => Hash::make($tempUser['password']),
                'role_id' => 2,
                'notification_status' => 0
            ]);

            // Manage the user details
            ManageUser::create([
                'user_id' => $user->id,
                'phone' => $tempUser['phone'],
                'address' => $tempUser['address'],
                'company_name' => $tempUser['company_name'],
                'subscription_status' => 1,
                'subscription_type' => $tempUser['subscription_type'],
                'start_date' => $tempUser['start_date'] ?? null,
                'end_date' => $tempUser['end_date'],
                'status' => 1,
                'duration' => $tempUser['planType'],
                'no_sites' => $tempUser['no_sites'],
                'storage' => $tempUser['storage'],
            ]);

            // Save payment and subscription details
            PaymentModel::create([
                'user_id' => $user->id,
                'name' => $session->customer_details->name ?? 'N/A',
                'status' => 1,
                'type' => $tempUser['subscription_type'],
                'payment_id' => $session->id,
                'email' => $session->customer_details->email ?? 'N/A',
                'amount' => $session->amount_total / 100,
                'payment_intent' => $subscriptionId, // Store subscription ID here
                'stripe_key' => $paymentSetting->stripe_key,
                'stripe_secret' => $paymentSetting->stripe_secret,
            ]);

            // Send a thank-you email
            Mail::to($user->email)->send(new RegistrationThankYouMail($user->email, $tempUser['password']));


            // Clear the session data
            session()->forget(['temp_user', 'stripe_session_id']);

            // Redirect with success message
            return redirect()->route('thankyou')->with('success', 'User registered successfully!');
        }

        return redirect()->route('/')->with('error', 'Payment was successful, but user data was not found.');
    }



    public function paymentCancel()
    {
        // Handle payment cancellation (optional)
        return redirect()->route('/')->with('error', 'Payment was cancelled.');
    }


    public function destroy($id)
    {
        // Find the smtp by ID
        $smtp = PaymentSetting::find($id);

        // If smtp not found, return error
        if (!$smtp) {
            return response()->json(['success' => false, 'message' => 'Permission not found'], 404);
        }

        // Delete the smtp
        $smtp->delete();

        // Return success response
        return response()->json(['success' => true, 'message' => 'Permission deleted successfully']);
    }


    public function createCoupon(Request $request)
    {
        // Fetch the active payment setting
        $paymentSetting = PaymentSetting::where('status', '1')->first();

        if (!$paymentSetting) {
            return response()->json([
                'success' => false,
                'message' => 'No active payment setting found!',
            ], 400);
        }

        // Set Stripe API key dynamically
        Stripe::setApiKey($paymentSetting->stripe_secret);


        $request->validate([
            'discount' => 'required|numeric|min:1|max:100',
            'code' => 'required|string|unique:coupons,code',
            'name' => 'required|unique:coupons,name',
            'duration' => 'required|in:once,forever,repeating',
            'duration_in_months' => $request->duration === 'repeating' ? 'required|integer|min:1' : 'nullable|integer|min:1',
        ]);

        try {

            $stripeCoupon = \Stripe\Coupon::create([
                'percent_off' => $request->discount,
                'duration' => $request->duration,
                'name' => $request->name,
                'duration_in_months' => $request->duration === 'repeating' ? $request->duration_in_months : null,
                'id' => $request->code,
            ]);


            $coupon = CouponsModel::create([
                'code' => $stripeCoupon->id,
                'percent_off' => $stripeCoupon->percent_off,
                'duration' => $stripeCoupon->duration,
                'duration_in_months' => $stripeCoupon->duration_in_months,
                'name' => $stripeCoupon->name,
            ]);

            return back()->with('success', 'Coupon created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function getCoupon(Request $request)
    {
        $coupons = CouponsModel::all();

        return response()->json(['data' => $coupons]);
    }
}
