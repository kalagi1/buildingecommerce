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
        Schema::table('expense_exports', function (Blueprint $table) {
            
            $table->string('account_type')->change();
            $table->string('pay_status')->change();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expense_exports', function (Blueprint $table) {
            $table->enum('account_type', ['Kurumsal', 'Emlak Kulüp'])->change();
            $table->enum('pay_status', ['Ödeme Yapıldı', 'Ödeme Yapılmadı'])->change();
        });
    }
};
