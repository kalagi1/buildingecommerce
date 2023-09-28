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
        Schema::table('project_images', function($table) {
            $table->string('image')->after('id');
            $table->unsignedBigInteger('project_id')->after('image');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_images', function($table) {
            $table->dropColumn('image');
            $table->dropColumn('project_id');
        });
    }
};
