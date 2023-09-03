<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('housings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('housing_type_id');
            $table->json('housing_type_data');
            $table->string('title');
            $table->string('address');
            $table->string('room_count');
            $table->unsignedSmallInteger('square_meter');
            $table->timestamps();

            $table->foreign('housing_type_id')->references('id')->on('housing_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housings');
    }
};