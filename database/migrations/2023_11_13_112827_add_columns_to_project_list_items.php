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
        Schema::table('project_list_items', function (Blueprint $table) {
            $table->string('column1_additional')->after('column4_name')->nullable();
            $table->string('column2_additional')->after('column1_additional')->nullable();
            $table->string('column3_additional')->after('column2_additional')->nullable();
            $table->string('column4_additional')->after('column3_additional')->nullable();
            $table->string('column1_icon')->after('column4_additional')->nullable();
            $table->string('column2_icon')->after('column1_icon')->nullable();
            $table->string('column3_icon')->after('column2_icon')->nullable();
            $table->string('column4_icon')->after('column3_icon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_list_items', function (Blueprint $table) {
            //
        });
    }
};
