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
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('user_id');
            $table->json('housing_type_data');
            $table->string('title');
            $table->string('description');
            $table->string('address')->nullable();
            $table->decimal('latitude', 11, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('room_count');
            $table->unsignedSmallInteger('square_meter');
            $table->integer('price');
            $table->integer('view_count')->default(0);
            $table->integer('order')->default(0);
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('housing_type_id')->references('id')->on('housing_types');
            $table->foreign('status_id')->references('id')->on('housing_status');
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
