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
            $table->dropColumn('housing_status_id');
            $table->dropColumn('item_order');
            $table->unsignedBigInteger('housing_type_id')->after('project_id');
            $table->integer('item_type')->after('housing_status_id');
            $table->dropColumn('project_id');
            $table->unsignedBigInteger('item_id')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stand_out_users', function (Blueprint $table) {
            //
        });
    }
};
