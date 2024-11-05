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
        Schema::create('site_name_table', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('folder_name')->nullable();
            $table->string('site_name')->nullable();
            $table->string('site_type')->nullable();
            $table->string('version')->nullable();
            $table->string('themes')->nullable();
            $table->longText('plugin')->nullable();
            $table->string('email')->nullable();
            $table->string('user_name')->nullable();
            $table->string('password')->nullable();
            $table->string('domain_name')->nullable();
            $table->string('owner_domain_name')->nullable();
            $table->string('login_url')->nullable();
            $table->string('db_name')->nullable();
            $table->string('db_user_name')->nullable();
            $table->string('db_password')->nullable();
           
            $table->enum('status', ['RUNNING', 'STOP', 'DELETED'])->default('RUNNING');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_name_table');
    }
};
