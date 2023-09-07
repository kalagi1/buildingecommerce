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
        Schema::table('brands', function($table) {
            $table->string('title')->after('id');
            $table->string('logo')->after('title');
            $table->string('cover_photo')->after('logo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brands', function($table) {
            $table->dropColumn('title');
            $table->dropColumn('logo');
            $table->dropColumn('cover_photo');
        });
    }
};
