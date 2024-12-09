<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MembershipPlan;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Config;

class MembershipPlanSeeder extends Seeder
{
    public function run()
    {
        $stripeSecret = Config::get('services.stripe.secret');
        $stripe = new StripeClient($stripeSecret);

        // Define the membership plans
        $plans = [

            [
                'plain_title' => 'Free',
                'plan_description' => 'For Free Users ',
                'plan_price' => 0,
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>1 GB disk space</li>
                        <li>1 Migration</li>
                        
                    </ul>",
                'plan_type' => 'month',
            ],
            [
                'plain_title' => 'Basic',
                'plan_description' => 'For simple websites',
                'plan_price' => 1000,
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>Up to 3 WordPress Installs</li>
                        <li>Up to 3 Staging Sites</li>
                        <li>30GB Storage</li>
                        <li>15 GB disk space</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Build WaaS</li>
                    </ul>",
                'plan_type' => 'month',
            ],
            [
                'plain_title' => 'Premium',
                'plan_description' => 'For high traffic websites',
                'plan_price' => 2000,
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        
                        <li>Up to 20 WordPress Installs</li>
                        <li>Up to 20 Staging Sites</li>
                        <li>Unlimited templates</li>
                        <li>50GB Storage</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Jetpack Security</li>
                        <li>Free Site Migrations</li>
                    </ul>",
                'plan_type' => 'month',
            ],
            [
                'plain_title' => 'Basic',
                'plan_description' => 'For simple websites',
                'plan_price' => 10000,
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>Up to 50 WordPress Installs</li>
                        <li>Up to 50 Staging Sites</li>
                        <li>100GB Storage</li>
                        <li>50 GB disk space</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Build WaaS</li>
                    </ul>",
                'plan_type' => 'year',
            ],
            [
                'plain_title' => 'Premium',
                'plan_description' => 'For high traffic websites',
                'plan_price' => 20000,
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        
                        <li>Up to 80 WordPress Installs</li>
                        <li>Up to 80 Staging Sites</li>
                        <li>Unlimited templates</li>
                        <li>150GB Storage</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Jetpack Security</li>
                        <li>Free Site Migrations</li>
                    </ul>",
                'plan_type' => 'year',
            ],
        ];

        foreach ($plans as $plan) {
            try {
                // Create a product on Stripe
                $product = $stripe->products->create([
                    'name' => $plan['plain_title'],
                    'description' => $plan['plan_description'],
                ]);

                // Create a price for the product on Stripe
                $price = $stripe->prices->create([
                    'unit_amount' => $plan['plan_price'] * 100, // Stripe requires amount in cents
                    'currency' => 'INR',
                    'recurring' => ['interval' => $plan['plan_type']],
                    'product' => $product->id,
                ]);

                // Store the plan details in the database
                MembershipPlan::create([
                    'plain_title' => $plan['plain_title'],
                    'plan_description' => $plan['plan_description'],
                    'stripe_product_id' => $product->id,
                    'plan_price' => $plan['plan_price'],
                    'plan_details' => $plan['plan_details'],
                    'plan_type' => $plan['plan_type'],
                ]);

                echo "Plan '{$plan['plain_title']}' seeded successfully.\n";
            } catch (\Exception $e) {
                echo "Error creating plan '{$plan['plain_title']}': " . $e->getMessage() . "\n";
            }
        }
    }
}
