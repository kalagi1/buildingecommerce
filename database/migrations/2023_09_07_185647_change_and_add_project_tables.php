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
        Schema::table('projects', function($table) {
            $table->string('location')->after('address');
            $table->text('description')->after('project_title');
            $table->integer('user_id')->after('housing_type_id')->nullable();
            $table->unsignedBigInteger('brand_id')->after('user_id')->nullable();
            $table->integer('room_count')->after('brand_id');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function($table) {
            $table->dropColumn('location');
            $table->dropColumn('brand_id');
            $table->dropColumn('description');
            $table->dropColumn('room_count');
            $table->dropColumn('user_id');
        });
    }
};
