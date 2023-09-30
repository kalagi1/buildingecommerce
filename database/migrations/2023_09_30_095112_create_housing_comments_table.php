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
        Schema::create('housing_comments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('housing_id');
            $table->text('comment');
            $table->enum('rate', [1,2,3,4,5]);
            $table->json('images')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housing_comments');
    }
};
