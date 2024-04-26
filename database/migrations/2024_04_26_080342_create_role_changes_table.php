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
        Schema::create('role_changes', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('username');
            $table->string('email');
            $table->string('mobile_phone');
            $table->string('name');
            $table->string('store_name');
            $table->string('phone');
            $table->string('corporate-account-type');
            $table->string('city_id');
            $table->string('county_id');
            $table->string('neighborhood_id');
            $table->string('account_type');
            $table->string('taxOfficeCity');
            $table->string('taxOffice');
            $table->string('taxNumber');
            $table->string('idNumber')->nullable();
            $table->string('subscription_plan_id');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_changes');
    }
};
