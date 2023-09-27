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
        Schema::table('users', function (Blueprint $table) {
            $table->string("activity")->nullable();
            $table->integer("county_id")->nullable();
            $table->integer("account_type")->nullable();
            $table->integer("taxOfficeCity")->nullable();
            $table->integer("taxOffice")->nullable();
            $table->string("taxNumber")->nullable();
            $table->string("idNumber")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
