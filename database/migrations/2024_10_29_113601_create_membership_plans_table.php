<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('membership_plans', function (Blueprint $table) {
            $table->id();
            $table->string('plain_title');
            $table->string('plain_id')->nullable();
            $table->text('plan_description');
            $table->string('plan_type');
            $table->integer('plan_price');
            $table->text('plan_details');
            $table->string('no_sites');
            $table->string('storage');
            $table->string('currency')->default('usd');
            $table->string('stripe_product_id')->unique();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_plans');
    }
};