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
        Schema::table('filters', function (Blueprint $table) {
            $table->string('order_by')->nullable();
            $table->string('transfer_for_sale_status')->default(0);
            $table->string('transfer_for_rent_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('filters', function (Blueprint $table) {
            $table->dropColumn('order_by');
            $table->dropColumn('transfer_for_sale_status');
            $table->dropColumn('transfer_for_rent_status');
        });
    }
};

