<?php

namespace App\Http\Controllers;

use App\Models\ManageUser;
use App\Models\PaymentModel;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\RegistrationThankYouMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon; // Make sure to import Carbon for date calculations

class SignUpGoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle the callback from Google
    // public function handleGoogleCallback()
    // {
    //     try {
    //         // Retrieve the user info from Google
    //         $googleUser = Socialite::driver('google')->user();

    //         // Check if the user already exists
    //         $user = User::where('email', $googleUser->getEmail())->first();

    //         // Temporary plain password
    //         $plainPassword = 'password12345';

    //         if (!$user) {
    //             // Hash the plain password before storing
    //             $hashedPassword = Hash::make($plainPassword);

    //             // Create a new user if it doesn't exist
    //             $user = User::create([
    //                 'name' => $googleUser->getName(),
    //                 'last_name' => $googleUser->user['family_name'] ?? '',
    //                 'email' => $googleUser->getEmail(),
    //                 'password' => $hashedPassword, // Store the hashed password
    //                 'role_id' => 2,
    //                 'notification_status' => 0,
    //             ]);
    //         }

    //         // Get the user ID
    //         $userId = $user->id;

    //         $userId = $user->id;

    //         $startDate = Carbon::now()->format('Y-m-d');
    //         $endDate = Carbon::now()->addMonth()->format('Y-m-d');



    //         $phone = 'N/A';
    //         $address = 'N/A';
    //         $companyName = 'N/A';
    //         $subscriptionType = 'Free';
    //         $duration = 'month';
    //         $noSites = 1;
    //         $storage = '1 GB';

    //         // Create a new ManageUser entry with default or user-provided values
    //         ManageUser::create([
    //             'user_id' => $userId,
    //             'phone' => $phone,
    //             'address' => $address,
    //             'company_name' => $companyName,
    //             'subscription_status' => 1,
    //             'subscription_type' => $subscriptionType,
    //             'start_date' => $startDate,
    //             'end_date' => $endDate,
    //             'status' => 1,
    //             'duration' => $duration,
    //             'no_sites' => $noSites,
    //             'storage' => $storage,
    //         ]);

    //         // Send the plain password in the email
    //         Mail::to($user->email)->send(new RegistrationThankYouMail($user->email, $plainPassword));

    //         // Log the user in (Laravel will compare the hashed password during authentication)
    //         Auth::login($user);

    //         // Redirect to the desired page
    //         return redirect()->route('home')->with('success', 'Logged in successfully via Google!');
    //     } catch (\Exception $e) {
    //         return redirect()->route('login')->with('error', 'Failed to log in with Google.');
    //     }
    // }


    // public function handleGoogleCallback()
    // {
    //     try {
    //         // Retrieve the user info from Google
    //         $googleUser = Socialite::driver('google')->user();

    //         // Check if the user already exists based on the email
    //         $user = User::where('email', $googleUser->getEmail())->first();

    //         // Temporary plain password (this could be hashed or generated differently)
    //         $plainPassword = 'password12345';

    //         if ($user) {
    //             // User already exists, so just log them in
    //             Auth::login($user);

    //             // Redirect to the desired page after login
    //             return redirect()->route('home')->with('success', 'Logged in successfully via Google!');
    //         }

    //         // If the user doesn't exist, validate and create a new user
    //         $this->validateEmail($googleUser->getEmail());

    //         // Hash the plain password before storing
    //         $hashedPassword = Hash::make($plainPassword);

    //         // Create a new user if it doesn't exist
    //         $user = User::create([
    //             'name' => $googleUser->getName(),
    //             'last_name' => $googleUser->user['family_name'] ?? '',
    //             'email' => $googleUser->getEmail(),
    //             'password' => $hashedPassword, // Store the hashed password
    //             'role_id' => 2, // Assuming default role is '2'
    //             'notification_status' => 0,
    //         ]);



    //         $userId = $user->id;

    //         $userId = $user->id;

    //         $startDate = Carbon::now()->format('Y-m-d');
    //         $endDate = Carbon::now()->addMonth()->format('Y-m-d');



    //         $phone = 'N/A';
    //         $address = 'N/A';
    //         $companyName = 'N/A';
    //         $subscriptionType = 'Free';
    //         $duration = 'month';
    //         $noSites = 1;
    //         $storage = '1 GB';

    //         // Create a new ManageUser entry with default or user-provided values
    //         ManageUser::create([
    //             'user_id' => $userId,
    //             'phone' => $phone,
    //             'address' => $address,
    //             'company_name' => $companyName,
    //             'subscription_status' => 1,
    //             'subscription_type' => $subscriptionType,
    //             'start_date' => $startDate,
    //             'end_date' => $endDate,
    //             'status' => 1,
    //             'duration' => $duration,
    //             'no_sites' => $noSites,
    //             'storage' => $storage,
    //         ]);

    //         // Send the plain password in the email
    //         Mail::to($user->email)->send(new RegistrationThankYouMail($user->email, $plainPassword));

    //         // Log the user in
    //         Auth::login($user);

    //         // Redirect to the desired page after successful login
    //         return redirect()->route('dashboard')->with('success', 'Logged in successfully via Google!');
    //     } catch (\Exception $e) {
    //         return redirect()->route('login')->with('error', 'Failed to log in with Google.');
    //     }
    // }

    public function handleGoogleCallback()
    {
        try {
            // Retrieve the user info from Google
            $googleUser = Socialite::driver('google')->user();

            // Check if the user already exists based on the email
            $user = User::where('email', $googleUser->getEmail())->first();

            // Temporary plain password (this could be hashed or generated differently)
            $plainPassword = 'password12345';

            if ($user) {
                // User already exists, so just log them in
                Auth::login($user);

                // Redirect to the desired page after login, with success message in the URL
                return redirect()->route('home')->with('success', 'Logged in successfully via Google!');
            }

            // If the user doesn't exist, validate and create a new user
            $this->validateEmail($googleUser->getEmail());

            // Hash the plain password before storing
            $hashedPassword = Hash::make($plainPassword);

            // Create a new user if it doesn't exist
            $user = User::create([
                'name' => $googleUser->getName(),
                'last_name' => $googleUser->user['family_name'] ?? '',
                'email' => $googleUser->getEmail(),
                'password' => $hashedPassword, // Store the hashed password
                'role_id' => 2, // Assuming default role is '2'
                'notification_status' => 0,
            ]);

            $userId = $user->id;

            // Default values
            $startDate = Carbon::now()->format('Y-m-d');
            $endDate = Carbon::now()->addMonth()->format('Y-m-d');
            $phone = 'N/A';
            $address = 'N/A';
            $companyName = 'N/A';
            $subscriptionType = 'Free';
            $duration = 'month';
            $noSites = 1;
            $storage = '1 GB';

            // Create a new ManageUser entry with default or user-provided values
            ManageUser::create([
                'user_id' => $userId,
                'phone' => $phone,
                'address' => $address,
                'company_name' => $companyName,
                'subscription_status' => 1,
                'subscription_type' => $subscriptionType,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 1,
                'duration' => $duration,
                'no_sites' => $noSites,
                'storage' => $storage,
            ]);

            // Send the plain password in the email
            Mail::to($user->email)->send(new RegistrationThankYouMail($user->email, $plainPassword));

            // Log the user in
            Auth::login($user);

            // Redirect to the dashboard with the success message as a query parameter
            return redirect()->route('dashboard')->with('success', 'Login Details Sent to Your Email!');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Failed to log in with Google.');
        }
    }


    private function validateEmail($email)
    {
        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            throw new \Exception('Email already in use.');
        }
    }
}
