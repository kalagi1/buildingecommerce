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
        Schema::table('real_estate_forms', function (Blueprint $table) {
            $table->string("name")->after('id');
            $table->string("phone")->after('name');
            $table->string("email")->after('phone');
            $table->string("is_show")->default(0)->after('wifi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('real_estate_forms', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('phone');
            $table->dropColumn('email');
            $table->dropColumn('is_show');
        });
    }
};
