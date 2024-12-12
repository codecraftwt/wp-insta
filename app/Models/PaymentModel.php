<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentModel extends Model
{

    protected $table = 'payments_table';

    protected $fillable = [
        'name','status','type','payment_id','email','amount','user_id','subscription_id','stripe_key','stripe_secret',
    ];
}