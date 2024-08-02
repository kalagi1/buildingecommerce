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
        Schema::create('cookie_preferences', function (Blueprint $table) {
            $table->id();
            $table->string('cookie_name');
            $table->string('site_domain');
            $table->text('description');
            $table->integer('expiry_duration'); // Geçerlilik süresi, gün cinsinden
            $table->string('cookie_type'); // Çerez türü
            $table->timestamps(); // Created_at ve updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cookie_preferences');
    }
};
