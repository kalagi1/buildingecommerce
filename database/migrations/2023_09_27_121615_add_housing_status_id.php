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
        Schema::table('stand_out_users', function (Blueprint $table) {
            $table->unsignedBigInteger('housing_status_id')->after('item_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stand_out_users', function (Blueprint $table) {
            $table->dropColumn('housing_status_id');
        });
    }
};
