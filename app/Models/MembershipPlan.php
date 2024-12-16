<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{

    protected $table = 'membership_plans';

    // Specify the fillable attributes for mass assignment
    protected $fillable = [
        'plain_title',
        'plain_id',
        'plan_description',
        'plan_type',
        'plan_price',
        'plan_details',
        'stripe_product_id',
        'stripe_price_id',
        'currency'
    ];
}