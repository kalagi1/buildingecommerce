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
        Schema::create('project_list_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("housing_type_id");
            $table->string("column1_name");
            $table->string("column2_name")->nullable();
            $table->string("column3_name")->nullable();
            $table->string("column4_name")->nullable();
            $table->integer("item_type"); // 1 ise proje 2 ise konut
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_list_items');
    }
};
