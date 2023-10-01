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
        Schema::create('project_house_settings', function (Blueprint $table) {
            $table->id();
            $table->string("column_name");
            $table->integer("is_array")->nullable();
            $table->integer("is_object")->nullable();
            $table->integer("order");
            $table->unsignedBigInteger("house_type");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_house_settings');
    }
};
