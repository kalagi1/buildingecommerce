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
        Schema::create('customer_calls', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('meeting_date');
            $table->string('note');
            $table->string('presentation');
            $table->string('conclusion');
            $table->string('meet_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_calls');
    }
};
