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
            $table->boolean('payment_balance')->default(false);
            $table->boolean('payment_earn2')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sharer_prices', function (Blueprint $table) {
            $table->dropColumn('payment_balance');
            $table->dropColumn('payment_earn2');
        });
    }
};
