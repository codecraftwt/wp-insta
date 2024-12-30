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
                'currency' => 'inr',
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>1 Storage</li>
                        <li>1 WordPress Install</li>
                        <li>1 GB Storage</li>
                    </ul>",
                'plan_type' => 'month',
                'no_sites' => '1',
                'storage' => '1 GB',
            ],
            //Standard
            [
                'plain_title' => 'Standard',
                'plan_description' => 'For simple websites',
                'plan_price' => 25,
                'currency' => 'inr',
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>Up to 2 WordPress Installs</li>
                        <li>Up to 2 Staging Sites</li>
                        <li>20GB Storage</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Build WaaS</li>
                    </ul>",
                'plan_type' => 'month',
                'no_sites' => '2',
                'storage' => '20 GB',
            ],
            [
                'plain_title' => 'Standard',
                'plan_description' => 'For simple websites',
                'plan_price' => 250,
                'currency' => 'inr',
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>Up to 2 WordPress Installs</li>
                        <li>Up to 2 Staging Sites</li>
                        <li>20GB Storage</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Build WaaS</li>
                    </ul>",
                'plan_type' => 'year',
                'no_sites' => '2',
                'storage' => '20 GB',
            ],
            //Silver
            [
                'plain_title' => 'Silver',
                'plan_description' => 'For simple websites',
                'plan_price' => 45,
                'currency' => 'inr',
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>Up to 3 WordPress Installs</li>
                        <li>Up to 3 Staging Sites</li>
                        <li>30GB Storage</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Build WaaS</li>
                    </ul>",
                'plan_type' => 'month',
                'no_sites' => '3',
                'storage' => '30 GB',
            ],
            [
                'plain_title' => 'Silver',
                'plan_description' => 'For simple websites',
                'plan_price' => 450,
                'currency' => 'inr',
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>Up to 3 WordPress Installs</li>
                        <li>Up to 3 Staging Sites</li>
                        <li>30GB Storage</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Build WaaS</li>
                    </ul>",
                'plan_type' => 'year',
                'no_sites' => '3',
                'storage' => '30 GB',
            ],

            //Gold
            [
                'plain_title' => 'Gold',
                'plan_description' => 'For simple websites',
                'plan_price' => 60,
                'currency' => 'inr',
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>Up to 5 WordPress Installs</li>
                        <li>Up to 5 Staging Sites</li>
                        <li>35GB Storage</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Build WaaS</li>
                    </ul>",
                'plan_type' => 'month',
                'no_sites' => '5',
                'storage' => '35 GB',
            ],
            [
                'plain_title' => 'Gold',
                'plan_description' => 'For simple websites',
                'plan_price' => 600,
                'currency' => 'inr',
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>Up to 5 WordPress Installs</li>
                        <li>Up to 5 Staging Sites</li>
                        <li>35GB Storage</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Build WaaS</li>
                    </ul>",
                'plan_type' => 'year',
                'no_sites' => '5',
                'storage' => '35 GB',
            ],

            //Platinum
            [
                'plain_title' => 'Platinum',
                'plan_description' => 'For simple websites',
                'plan_price' => 90,
                'currency' => 'inr',
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>Up to 10 WordPress Installs</li>
                        <li>Up to 10 Staging Sites</li>
                        <li>50GB Storage</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Build WaaS</li>
                    </ul>",
                'plan_type' => 'month',
                'no_sites' => '10',
                'storage' => '50 GB',
            ],
            [
                'plain_title' => 'Platinum',
                'plan_description' => 'For simple websites',
                'plan_price' => 900,
                'currency' => 'inr',
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>Up to 10 WordPress Installs</li>
                        <li>Up to 10 Staging Sites</li>
                        <li>50GB Storage</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Build WaaS</li>
                    </ul>",
                'plan_type' => 'year',
                'no_sites' => '10',
                'storage' => '50 GB',
            ],
            //Diamond
            [
                'plain_title' => 'Diamond',
                'plan_description' => 'For simple websites',
                'plan_price' => 155,
                'currency' => 'inr',
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>Up to 20 WordPress Installs</li>
                        <li>Up to 20 Staging Sites</li>
                        <li>80GB Storage</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Build WaaS</li>
                    </ul>",
                'plan_type' => 'month',
                'no_sites' => '20',
                'storage' => '80 GB',
            ],
            [
                'plain_title' => 'Diamond',
                'plan_description' => 'For simple websites',
                'plan_price' => 1550,
                'currency' => 'inr',
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>Up to 20 WordPress Installs</li>
                        <li>Up to 20 Staging Sites</li>
                        <li>80GB Storage</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Build WaaS</li>
                    </ul>",
                'plan_type' => 'year',
                'no_sites' => '20',
                'storage' => '80 GB',
            ],
            //Ultimate
            [
                'plain_title' => 'Ultimate',
                'plan_description' => 'For simple websites',
                'plan_price' => 350,
                'currency' => 'inr',
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>Up to 50 WordPress Installs</li>
                        <li>Up to 50 Staging Sites</li>
                        <li>200GB Storage</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Build WaaS</li>
                    </ul>",
                'plan_type' => 'month',
                'no_sites' => '50',
                'storage' => '200 GB',
            ],
            [
                'plain_title' => 'Ultimate',
                'plan_description' => 'For simple websites',
                'plan_price' => 3500,
                'currency' => 'inr',
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>Up to 50 WordPress Installs</li>
                        <li>Up to 50 Staging Sites</li>
                        <li>200GB Storage</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Build WaaS</li>
                    </ul>",
                'plan_type' => 'year',
                'no_sites' => '50',
                'storage' => '200 GB',
            ],

            //Premier
            [
                'plain_title' => 'Premier',
                'plan_description' => 'For simple websites',
                'plan_price' => 545,
                'currency' => 'inr',
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>Up to 80 WordPress Installs</li>
                        <li>Up to 80 Staging Sites</li>
                        <li>275GB Storage</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Build WaaS</li>
                    </ul>",
                'plan_type' => 'month',
                'no_sites' => '80',
                'storage' => '275 GB',
            ],
            [
                'plain_title' => 'Premier',
                'plan_description' => 'For simple websites',
                'plan_price' => 5450,
                'currency' => 'inr',
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>Up to 80 WordPress Installs</li>
                        <li>Up to 80 Staging Sites</li>
                        <li>275GB Storage</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Build WaaS</li>
                    </ul>",
                'plan_type' => 'year',
                'no_sites' => '80',
                'storage' => '275 GB',
            ],
            //Pro
            [
                'plain_title' => 'Pro',
                'plan_description' => 'For simple websites',
                'plan_price' => 545,
                'currency' => 'inr',
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>Up to 100  WordPress Installs</li>
                        <li>Up to 100  Staging Sites</li>
                        <li>325GB Storage</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Build WaaS</li>
                    </ul>",
                'plan_type' => 'month',
                'no_sites' => '100 ',
                'storage' => '325 GB',
            ],
            [
                'plain_title' => 'Pro',
                'plan_description' => 'For simple websites',
                'plan_price' => 5450,
                'currency' => 'inr',
                'plan_details' => "
                    <h2>Developer Tools</h2>
                    <ul>
                        <li>Up to 100  WordPress Installs</li>
                        <li>Up to 100  Staging Sites</li>
                        <li>325GB Storage</li>
                        <li>24/7 WordPress Hosting Support</li>
                        <li>Build WaaS</li>
                    </ul>",
                'plan_type' => 'year',
                'no_sites' => '100 ',
                'storage' => '325 GB',
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
                    'currency' => 'usd',
                    'recurring' => ['interval' => $plan['plan_type']],
                    'product' => $product->id,
                ]);

                // Generate a plain_id (e.g., a unique identifier based on plan title)
                $plain_id = strtolower(str_replace(' ', '_', $plan['plain_title'])) . '_' . uniqid();

                // Store the plan details in the database
                MembershipPlan::create([
                    'plain_title' => $plan['plain_title'],
                    'plan_description' => $plan['plan_description'],
                    'stripe_product_id' => $product->id,
                    'plan_price' => $plan['plan_price'],
                    'plan_details' => $plan['plan_details'],
                    'plan_type' => $plan['plan_type'],
                    'plain_id' => $plain_id, // Save the plain_id
                    'currency' => $plan['currency'],
                    'no_sites' => $plan['no_sites'],
                    'storage' => $plan['storage'],
                ]);

                echo "Plan '{$plan['plain_title']}' seeded successfully.\n";
            } catch (\Exception $e) {
                echo "Error creating plan '{$plan['plain_title']}': " . $e->getMessage() . "\n";
            }
        }
    }
}
