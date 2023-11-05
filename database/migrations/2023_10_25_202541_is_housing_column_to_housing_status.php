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
        Schema::table('housing_status', function (Blueprint $table) {
            $table->boolean("is_housing")->default(0)->after('is_project');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('housing_status', function (Blueprint $table) {
            $table->dropColumn('is_housing');
        });
    }
};
