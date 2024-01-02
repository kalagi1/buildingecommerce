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
        Schema::create('payment_temps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("admin_id")->nullable();
            $table->unsignedBigInteger("user_id");
            $table->text("description");
            $table->integer("transaction_type");
            $table->integer("bank_id");
            $table->text("data");
            $table->integer("status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_temps');
    }
};
