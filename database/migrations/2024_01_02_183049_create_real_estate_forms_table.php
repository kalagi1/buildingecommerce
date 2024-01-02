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
        Schema::create('real_estate_forms', function (Blueprint $table) {
            $table->id();
            $table->boolean('konut')->default(0);
            $table->boolean('ticari')->default(0);
            $table->boolean('kiralik')->default(0);
            $table->boolean('satilik')->default(0);
            $table->boolean('devren')->default(0);
            $table->string('adres')->nullable();
            $table->string('istenilen_fiyat')->nullable();
            $table->text('ilan_aciklamasi')->nullable();
            $table->boolean('sozlesme')->default(0);
            $table->boolean('afis')->default(0);
            $table->boolean('anahtar_yetkili')->default(0);
            $table->string('yapi_tipi')->nullable();
            $table->integer('bina_kat')->nullable();
            $table->integer('bulundugu_kat')->nullable();
            $table->integer('m2_net')->nullable();
            $table->integer('m2_brut')->nullable();
            $table->integer('bina_yasi')->nullable();
            $table->string('cephe')->nullable();
            $table->string('manzara')->nullable();
            $table->integer('banyo_tuvalet')->nullable();
            $table->string('isinma')->nullable();
            $table->string('oda_salon')->nullable();
            $table->string('tapu')->nullable();
            $table->boolean('dsl')->default(0);
            $table->boolean('asansor')->default(0);
            $table->boolean('esyali')->default(0);
            $table->boolean('garaj')->default(0);
            $table->boolean('barbeku')->default(0);
            $table->boolean('boyali')->default(0);
            $table->boolean('cam_odasi')->default(0);
            $table->boolean('celik_kapi')->default(0);
            $table->boolean('dusakabin')->default(0);
            $table->boolean('intercom')->default(0);
            $table->boolean('jakuzi')->default(0);
            $table->boolean('msd')->default(0);
            $table->boolean('jenerator')->default(0);
            $table->boolean('mutfak_d')->default(0);
            $table->boolean('sauna')->default(0);
            $table->boolean('seramik_z')->default(0);
            $table->boolean('su_deposu')->default(0);
            $table->boolean('somine')->default(0);
            $table->boolean('teras')->default(0);
            $table->boolean('guvenlik')->default(0);
            $table->boolean('gonme_dolap')->default(0);
            $table->boolean('kablo_tv')->default(0);
            $table->boolean('mutfak_l')->default(0);
            $table->boolean('otopark')->default(0);
            $table->boolean('gor_diafon')->default(0);
            $table->boolean('kiler')->default(0);
            $table->boolean('oyun_parki')->default(0);
            $table->boolean('hidrofor')->default(0);
            $table->boolean('klima')->default(0);
            $table->boolean('pvc')->default(0);
            $table->boolean('hilton_banyo')->default(0);
            $table->boolean('kombi')->default(0);
            $table->boolean('panjur')->default(0);
            $table->boolean('isicam')->default(0);
            $table->boolean('laminant_z')->default(0);
            $table->boolean('parke')->default(0);
            $table->boolean('yangin_m')->default(0);
            $table->boolean('yuzme_havuzu')->default(0);
            $table->boolean('wifi')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('real_estate_forms');
    }
};
