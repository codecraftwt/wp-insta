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
        Schema::create('site_setting_table', function (Blueprint $table) {
            $table->id();
            $table->string('site_title')->nullable();
            $table->string('logo')->nullable();
            $table->string('header_background')->nullable();
            $table->string('header_text')->nullable();
            $table->string('header_btncolor')->nullable();
            $table->string('header_btn_bgcolor')->nullable();
            $table->string('footer_text')->nullable();
            $table->string('footer_background')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_setting_table');
    }
};
