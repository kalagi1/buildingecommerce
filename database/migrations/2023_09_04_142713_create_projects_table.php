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
        //ilişkisel yakın konumlar tablosu
        //slider resimleri
        //ek resimler 
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('housing_type_id');
            $table->string('project_title');
            $table->string('address');
            $table->unsignedBigInteger('status_id');
            $table->string('image');
            $table->integer('view_count')->default(0);
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('housing_status');
            $table->foreign('housing_type_id')->references('id')->on('housing_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};