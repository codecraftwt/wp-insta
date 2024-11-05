<?php

namespace App\Http\Controllers;

use App\Models\PaymentSetting;
use Illuminate\Http\Request;
use Stripe\StripeClient;
use Stripe\Product;
use Stripe\Price;
use App\Models\MembershipPlan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class MembershipPlanController extends Controller
{
    // public function createMembershipPlan(Request $request)
    // {
    //     // Use the configured Stripe secret directly in this function
    //     $stripeSecret = Config::get('services.stripe.secret');
    //     Log::info('Stripe secret: ' . $stripeSecret);

    //     if (empty($stripeSecret)) {
    //         return response()->json(['error' => 'Stripe API key is not configured.'], 500);
    //     }



    //     $stripe = new StripeClient($stripeSecret);



    //     // Validate incoming request
    //     $request->validate([
    //         'plain_title' => 'required',
    //         'plan_description' => 'required',
    //         'plan_price' => 'required',
    //         'plan_details' => 'required',
    //         'plan_type' => 'required',
    //     ]);



    //     try {
    //         // Create a product
    //         $product = Product::create([
    //             'name' => $request->plain_title,
    //             'description' => $request->plan_description,
    //         ]);


    //         $price = $stripe->prices->create([
    //             'unit_amount' => $request->plan_price * 100,
    //             'currency' => 'INR',
    //             'recurring' => ['interval' => $request->plan_type],
    //             'product' => $product->id,
    //         ]);

    //         // Store membership plan details in the database
    //         $membershipPlan = MembershipPlan::create([
    //             'plain_title' => $request->plain_title,
    //             'plan_description' => $request->plan_description,
    //             'stripe_product_id' => $product->id,
    //             'plan_price' => $request->plan_price * 100,
    //             'plan_details' => $request->plan_details,
    //             'plan_type' => $request->plan_type,
    //         ]);

    //         return response()->json(['success' => true, 'plan' => $membershipPlan], 201);
    //     } catch (\Exception $e) {

    //         Log::error('Error creating membership plan: ' . $e->getMessage());

    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }


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
                'currency' => 'INR',
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
}
