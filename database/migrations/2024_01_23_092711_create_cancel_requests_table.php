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
        Schema::create('cancel_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("reservation_id");
            $table->text("description");
            $table->string("iban");
            $table->string("iban_name");
            $table->integer("item_type");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancel_requests');
    }
};
