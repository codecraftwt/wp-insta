<?php

namespace App\Http\Controllers;

use App\Models\ManageUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentSetting;
use App\Models\PaymentModel;
use Illuminate\Support\Facades\Hash;
use Stripe\Stripe;

use Stripe\StripeClient;

class PaymentController extends Controller
{
    public function PaymentStripe(Request $request)
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
                            'currency' => 'INR',
                            'product_data' => ['name' => 'WP_INSTA'],
                            'unit_amount' => $validatedData['amount'] * 100,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('paymentsuccess') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('paymentcancle'),
            ]);


            return redirect($response->url);
        } catch (\Exception $e) {
            return redirect()->route('paymentcancle')->withErrors('Error creating payment session: ' . $e->getMessage());
        }
    }

    public function paymentsuccess(Request $request)
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

    public function paymentcancle()
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



    // public function getpaymenthistory(Request $request)
    // {

    //     $user = $request->user();

    //     if ($user->role_id === 1) {

    //         $history = PaymentModel::all();
    //     } else {

    //         $history = PaymentModel::where('user_id', $user->id)->get();
    //     }

    //     return response()->json(['data' => $history]);
    // }


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


    // public function subscriptionRegister(Request $request)
    // {

    //     $validatedData = $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required',
    //         'phone' => 'required',
    //         'country' => 'required',
    //         'state' => 'required',
    //         'city' => 'required',
    //         'pincode' => 'required',
    //         'gender' => 'required',
    //         'dob' => 'required',
    //         'subscription_type' => 'required',
    //         'start_date' => 'required',
    //         'end_date' => 'required',
    //         'status' => 'required',
    //         'plan_id' => 'required',
    //         'stripe_product_id' => 'required',
    //         'plan_price' => 'required',
    //     ]);



    //     $user = User::create([
    //         'name' => $validatedData['name'],
    //         'email' => $validatedData['email'],
    //         'password' => Hash::make($validatedData['password']),
    //         'role_id' => 3,
    //     ]);


    //     ManageUser::create([
    //         'user_id' => $user->id,
    //         'phone' => $validatedData['phone'],
    //         'country' => $validatedData['country'],
    //         'state' => $validatedData['state'],
    //         'city' => $validatedData['city'],
    //         'pincode' => $validatedData['pincode'],
    //         'gender' => $validatedData['gender'],
    //         'dob' => $validatedData['dob'],
    //         'subscription_type' => $validatedData['subscription_type'],
    //         'start_date' => $validatedData['start_date'],
    //         'end_date' => $validatedData['end_date'],
    //         'status' => $validatedData['status'],
    //     ]);

    //     // Redirect back with a success message
    //     return redirect()->back()->with('success', 'User added successfully!');
    // }


    public function subscriptionRegister(Request $request)
    {
        // Validate input data
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'phone' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'subscription_type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'plan_id' => 'required',
            'stripe_product_id' => 'required',
            'plan_price' => 'required',
            'planType' => 'required',
        ]);


        if ($validatedData['subscription_type'] === 'FREE' || $validatedData['subscription_type'] === 'Free' || $validatedData['plan_price'] == 0) {

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role_id' => 3,
            ]);

            ManageUser::create([
                'user_id' => $user->id,
                'phone' => $validatedData['phone'],
                'country' => $validatedData['country'],
                'state' => $validatedData['state'],
                'city' => $validatedData['city'],
                'pincode' => $validatedData['pincode'],
                'gender' => $validatedData['gender'],
                'dob' => $validatedData['dob'],
                'subscription_type' => $validatedData['subscription_type'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'status' => 0,
                'duration' => $validatedData['planType'],
            ]);


            return response()->json([
                'message' => 'User registered successfully! You have a free subscription.',
                'redirect_url' => route('login'), // Return the redirect URL
            ]);
        }

        // Store user data in session for later use
        session(['temp_user' => $validatedData]);

        $paymentSetting = PaymentSetting::where('status', '1')->first();
        Stripe::setApiKey($paymentSetting->stripe_secret);

        // Create a Stripe Checkout session
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'INR',
                    'product_data' => [
                        'name' => 'Subscription Plan',
                    ],
                    'unit_amount' => $validatedData['plan_price'] * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.successregister'),
            'cancel_url' => route('payment.cancel'),
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


        $paymentSetting = PaymentSetting::where('status', '1')->first();
        $stripe = new StripeClient($paymentSetting->stripe_secret);


        $session = $stripe->checkout->sessions->retrieve($sessionId);


        if ($tempUser && $session->payment_status === 'paid') {
            $user = User::create([
                'name' => $tempUser['name'],
                'email' => $tempUser['email'],
                'password' => Hash::make($tempUser['password']),
                'role_id' => 3,
            ]);

            ManageUser::create([
                'user_id' => $user->id,
                'phone' => $tempUser['phone'],
                'country' => $tempUser['country'],
                'state' => $tempUser['state'],
                'city' => $tempUser['city'],
                'pincode' => $tempUser['pincode'],
                'gender' => $tempUser['gender'],
                'dob' => $tempUser['dob'],
                'subscription_type' => $tempUser['subscription_type'],
                'start_date' => $tempUser['start_date'],
                'end_date' => $tempUser['end_date'],
                'status' => 1,
                'duration' => $tempUser['planType'],
            ]);


            PaymentModel::create([
                'user_id' => $user->id,
                'name' => $session->customer_details->name ?? 'N/A',
                'status' => 1,
                'type' => $tempUser['subscription_type'],
                'payment_id' => $session->id,
                'email' => $session->customer_details->email ?? 'N/A',
                'amount' => $session->amount_total / 100,
                'payment_intent' => $session->payment_intent,
                'stripe_key' => $paymentSetting->stripe_key,
                'stripe_secret' => $paymentSetting->stripe_secret,

            ]);

            // Clear the session data
            session()->forget(['temp_user', 'stripe_session_id']);

            // Redirect with success message
            return redirect()->route('home')->with('success', 'User registered successfully!');
        }

        return redirect()->route('home')->with('error', 'Payment was successful, but user data was not found.');
    }

    public function paymentCancel()
    {
        // Handle payment cancellation (optional)
        return redirect()->route('home')->with('error', 'Payment was cancelled.');
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
}
