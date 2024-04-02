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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('soyad');
            $table->string('telefon');
            $table->string('email');
            $table->string('sehir');
            $table->string('ilce');
            $table->string('takas_tercihi');
            $table->text('diger_detay')->nullable();
            $table->text('barter_detay')->nullable();
            $table->string('emlak_tipi')->nullable();
            $table->string('konut_tipi')->nullable();
            $table->integer('oda_sayisi')->nullable();
            $table->integer('konut_yasi')->nullable();
            $table->string('kullanim_durumu')->nullable();
            $table->integer('satis_rakami')->nullable();
            $table->text('arsa_il')->nullable();
            $table->text('arsa_ilce')->nullable();
            $table->text('arsa_mahalle')->nullable();
            $table->text('ada_parsel')->nullable();
            $table->string('imar_durumu')->nullable();
            $table->integer('arac_model_yili')->nullable();
            $table->string('arac_markasi')->nullable();
            $table->string('yakit_tipi')->nullable();
            $table->string('vites_tipi')->nullable();
            $table->integer('arac_satis_rakami')->nullable();
            $table->text('ticari_bilgiler')->nullable();
            $table->integer('isyeri_satis_rakami')->nullable();
            $table->unsignedBigInteger('store_id');
            $table->timestamps();
            $table->foreign('store_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
