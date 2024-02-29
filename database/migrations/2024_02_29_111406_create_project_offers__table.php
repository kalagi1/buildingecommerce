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
        Schema::create('project_offers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('store_id')->nullable();
            $table->bigInteger('project_id')->nullable();
            $table->bigInteger('room_id');
            $table->string('email', 150)->nullable();
            $table->string('offer_price_range', 100)->nullable();
            $table->string('offer_description', 500)->nullable();
            $table->integer('approval_status')->nullable();
            $table->integer('response_status')->nullable()->comment('0 - olumsuz, 1 - olumlu');
            $table->integer('sales_status')->nullable()->comment('0 - Satın alınamaz, 1 - Satın Alınabilir');
            $table->tinyInteger('offer_response')->nullable()->comment('0 - yanıtlanmadı, 1 - Yanıtlandı');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_offers_');
    }
};
