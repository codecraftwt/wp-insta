<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ManageUser; // Use the same model or another one based on your needs
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SeedSubscriptionStatus extends Command
{
    protected $signature = 'subscription:seed';
    protected $description = 'Seed subscription status every minute for testing or seeding purposes';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Log::info('Starting subscription check...'); // Log the start of the command

        // Fetch users with a non-null subscription end date
        $users = ManageUser::whereNotNull('end_date')->get();
        Log::info("Fetched users: {$users->count()}");

        foreach ($users as $user) {
            Log::info("Processing user ID: {$user->user_id}");

            // Calculate remaining time for each user
            $remainingTime = $this->calculateRemainingTime($user->end_date);
            Log::info("Remaining time for user {$user->user_id}: {$remainingTime}");

            if ($remainingTime === "Expired") {
                Log::info("Subscription expired for user {$user->user_id}");

                $user->status = 0;  // Mark as expired
                $user->save();

                // Store the expired notification with a 2-hour expiration in cache
                Cache::put('subscription_notification_' . $user->user_id, "Your subscription has expired.", now()->addHours(2));
            } else {
                // Extract remaining days
                $remainingDays = (int)explode(' ', $remainingTime)[0];
                Log::info("Remaining days for user {$user->user_id}: {$remainingDays} days");

                if ($remainingDays <= 3) {
                    Log::info("Subscription notification set for user {$user->user_id} - {$remainingDays} days left");

                    // Set the subscription reminder in cache with a 2-hour expiration
                    Cache::put('subscription_notification_' . $user->user_id, "Subscription {$remainingDays} days left", now()->addHours(2));
                }
            }
        }

        Log::info('Subscription check completed.');
    }

    // Helper method to calculate remaining time
    public function calculateRemainingTime($endDate)
    {
        $now = Carbon::now()->startOfDay();  // Get today's date at midnight
        $end = Carbon::parse($endDate)->startOfDay();  // Ensure the end date is treated as midnight

        // Log the dates for debugging
        Log::info("Current date: " . $now->toDateString());
        Log::info("End date: " . $end->toDateString());

        // Check if the subscription is expired
        if ($end->isPast()) {
            return "Expired";
        }

        // Return the remaining time in days
        return $end->diffInDays($now) . ' days remaining';
    }
}
