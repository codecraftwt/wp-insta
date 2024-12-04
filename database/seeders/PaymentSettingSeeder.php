<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentSetting;

class PaymentSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        PaymentSetting::create([
            'stripe_key' => 'pk_test_51QEqM3G3k56W49A0txrprzNVNPqFUcJ3p0f3aROTh72cX3wotlTrQBkeBXS3HdOU8M7VosKXMTnp8WHUZcfzc5zh002jcMBo7l',
            'stripe_secret' => 'sk_test_51QEqM3G3k56W49A0Fok0xLiJEBs4ONOYwLZCHVQ3s8JcRUqeES5pq4I5PEofpYIlRO0YPE4a4mbZFsICJuJbOPp400A89JzJzK',
        ]);

      
    }
}
