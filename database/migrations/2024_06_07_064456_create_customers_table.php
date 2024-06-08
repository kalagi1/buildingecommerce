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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->date("date");
            $table->unsignedBigInteger("source");
            $table->integer("new");
            $table->string("name");
            $table->string("phone");
            $table->string("email");
            $table->string("job");
            $table->string("city");
            $table->string("interested_project")->nullable();
            $table->string("meet_type")->nullable();
            $table->text("note")->nullable();
            $table->integer("rating")->nullable();
            $table->integer("customer_status")->nullable();
            $table->integer("presentation")->nullable();
            $table->integer("conclusion")->nullable();
            $table->date("return_date")->nullable();
            $table->unsignedBigInteger("user")->nullable();
            $table->integer("was_meeting")->default("0");
            $table->date("meeting_date")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
