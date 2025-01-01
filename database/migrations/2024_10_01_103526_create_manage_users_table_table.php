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
        Schema::create('manage_users_table', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            $table->string('company_name')->nullable();
            $table->string('subscription_type')->default('Free');
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('duration')->nullable();
            $table->string('status')->default('1');
            $table->string('no_sites')->default('1');
            $table->string('storage')->default('1 GB');
            $table->string('subscription_status')->default('1');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manage_users_table');
    }
};
