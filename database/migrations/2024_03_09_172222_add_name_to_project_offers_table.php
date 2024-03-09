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
        Schema::table('project_offers', function (Blueprint $table) {
            $table->string("name")->nullable();
            $table->string("phone")->nullable();
            $table->string("title")->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_offers', function (Blueprint $table) {
            //
        });
    }
};
