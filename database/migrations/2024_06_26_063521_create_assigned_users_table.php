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
        Schema::create('assigned_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('project_name');
            $table->string('platform');
            $table->string('province');
            $table->string('job_title');

            $table->string('konut_tercihi')->nullable();
            $table->string('varlik_yonetimi')->nullable();
            $table->string('musteri_butcesi')->nullable();
            $table->string('ilgilendigi_bolge')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_users');
    }
};
