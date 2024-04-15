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
            $table->string('full_name')->nullable();
            $table->string('tc')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('neighbor_views', function (Blueprint $table) {
            $table->dropColumn('full_name');
            $table->dropColumn('tc');
            $table->dropColumn('email');
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('notes');
        });
    }
};
