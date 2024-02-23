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
        Schema::table('neighbor_views', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('housing')->nullable();
            $table->unsignedBigInteger('owner_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('neighbor_views', function (Blueprint $table) {
            //
        });
    }
};
