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
        Schema::table('sharer_prices', function (Blueprint $table) {
            $table->integer('is_reservation')->default(0)->after('earn2');
            $table->unsignedBigInteger('reservation_id')->nullable()->after('is_reservation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sharer_prices', function (Blueprint $table) {
            $table->dropColumn('is_reservation');
            $table->dropColumn('reservation_id');
        });
    }
};
