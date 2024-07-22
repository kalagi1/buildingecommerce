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
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->date('title_deed_date')->nullable();
            $table->date('agreement_date')->nullable();
            $table->string('agreement_no')->nullable();
            $table->text('pay_dec_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->dropColumn('title_deed_date');
            $table->dropColumn('agreement_date');
            $table->dropColumn('agreement_no');
            $table->dropColumn('pay_dec_description');
        });
    }
};
