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
        Schema::table('projects', function (Blueprint $table) {
            $table->string("create_company")->after('description')->nullable();
            $table->string("total_project_area")->after('create_company')->nullable();
            $table->string("start_date")->after('total_project_area')->nullable();
            $table->string("project_end_date")->after('start_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn("create_company");
            $table->dropColumn("total_project_area");
            $table->dropColumn("start_date");
            $table->dropColumn("end_date");
        });
    }
};
