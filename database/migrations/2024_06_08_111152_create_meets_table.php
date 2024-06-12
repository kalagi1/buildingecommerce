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
        Schema::create('meets', function (Blueprint $table) {
            $table->id();
            $table->date("date");
            $table->text("note");
            $table->integer("rating");
            $table->unsignedBigInteger("customer_id");
            $table->time("start_time");
            $table->time("end_time");
            $table->integer("status");
            $table->integer("conclusion");
            $table->date("next_meet_date")->nullable();
            $table->integer("next_meet_type")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meets');
    }
};
