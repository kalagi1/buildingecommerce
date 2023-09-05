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
        Schema::create('project_housings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('status_id');
            $table->json('housing_type_data');
            $table->string('title');
            $table->string('room_count');
            $table->unsignedSmallInteger('square_meter');
            $table->integer('price');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('status_id')->references('id')->on('housing_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_housings');
    }
};