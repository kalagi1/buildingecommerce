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
        Schema::create('expense_exports', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('iban')->nullable();
            $table->enum('account_type',['Kurumsal','Emlak Kulüp'])->nullable();
            $table->string('amount')->nullable();
            $table->enum('pay_status',['Ödeme Yapıldı','Ödeme Yapılmadı'])->nullable();
            $table->string('advert_no')->nullable();
            $table->date('advert_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_exports');
    }
};
