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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string("coupon_code");
            $table->float("amount");
            $table->integer("discount_type");
            $table->float("estate_club_user_amount");
            $table->integer("estate_club_user_amount_type");
            $table->integer("use_count");
            $table->integer("time_type"); // 1 ise sınırsız 2 ise tarihler aralığında;
            $table->date("start_date")->nullable();
            $table->date("end_date")->nullable();
            $table->integer("select_projects_type"); // 1 ise tüm projelerde 2 ise belirli projelerde 3 ise hiçbir projede
            $table->integer("select_housings_type"); // 1 ise tüm konutlarda 2 ise belirli konutlarda 3 ise hiçbir konutta
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("estate_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
