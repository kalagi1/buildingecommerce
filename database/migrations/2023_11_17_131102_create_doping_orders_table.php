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
        Schema::create('doping_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("stand_out_id");
            $table->unsignedBigInteger("project_id");
            $table->string("key");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("bank_id");
            $table->float("price");
            $table->integer("status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doping_orders');
    }
};
