@extends('client.layouts.master')

@section('content')
    @php
        function getData($housing, $key)
        {
            $housing_type_data = json_decode($housing->housing_type_data);
            $a = $housing_type_data->$key;
            return $a[0];
        }

        function getImage($housing, $key)
        {
            $housing_type_data = json_decode($housing->housing_type_data);
            $a = $housing_type_data->$key;
            return $a;
        }
    @endphp

    <x-store-card :store="$institutional" />


    <section class="portfolio bg-white homepage-5 ">
        <div class="container pb-5">
            <form action="{{ route('form.kaydet') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-4 col-12">
                        <label class="form-label" for="ad">Adınız:</label>
                        <input class="form-control" type="text" id="ad" name="ad">
                    </div>

                    <div class="col-md-4 col-12">
                        <label class="form-label" for="soyad">Soyadınız:</label>
                        <input class="form-control" type="text" id="soyad" name="soyad">
                    </div>

                    <div class="col-md-4 col-12">
                        <label class="form-label" for="telefon">Telefon Numaranız:</label>
                        <input class="form-control" type="tel" id="telefon" name="telefon">
                    </div>

                    <div class="col-md-4 col-12">
                        <label class="form-label" for="email">Email:</label>
                        <input class="form-control" type="email" id="email" name="email">
                    </div>

                    <div class="col-md-4 col-12">
                        <label class="form-label" for="sehir">Şehir:</label>
                        <input class="form-control" type="text" id="sehir" name="sehir">
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="form-label" for="ilce">İlçe:</label>
                        <input class="form-control" type="text" id="ilce" name="ilce">
                    </div>

                    <div class="col-md-12 col-12">
                        <label class="form-label" for="takas_tercihi">Takas Tercihiniz:</label>
                        <select class="form-control" id="takas_tercihi" name="takas_tercihi">
                            <option value="">Seçiniz</option>
                            <option value="emlak">Emlak</option>
                            <option value="araç">Araç</option>
                            <option value="barter">Barter</option>
                            <option value="diğer">Diğer</option>
                        </select>
                    </div>

                    <div id="digeryse" style="display: none;" class="col-md-12 col-12">
                        <label class="form-label" for="diger_detay">Takas ile ilgili ürün/hizmet detayı:</label>
                        <textarea class="form-control" id="diger_detay" name="diger_detay"></textarea>
                    </div>

                    <div id="barteryse" style="display: none;" class="col-md-12 col-12">
                        <label class="form-label" for="barter_detay">Lütfen barter durumunuz ile ilgili detaylı bilgileri
                            giriniz:</label>
                        <textarea class="form-control" id="barter_detay" name="barter_detay"></textarea>
                    </div>

                    <div id="emlakyse" style="display: none;" class="col-md-12 col-12">
                        <label class="form-label" for="emlak_tipi">Emlak Tipi:</label>
                        <select class="form-control" id="emlak_tipi" name="emlak_tipi">
                            <option value="">Seçiniz</option>
                            <option value="konut">Konut</option>
                            <option value="arsa">Arsa</option>
                            <option value="işyeri">İşyeri</option>
                        </select>
                    </div>

                    <div id="konutyse" style="display: none;" class="col-md-12 col-12">
                        <label class="form-label" for="konut_tipi">Konut Tipi:</label>
                        <select class="form-control" id="konut_tipi" name="konut_tipi">
                            <option value="">Seçiniz</option>
                            <option value="daire">Daire</option>
                            <option value="villa">Villa</option>
                            <option value="residance">Residance</option>
                            <option value="prefabrik_ev">Prefabrik Ev</option>
                            <option value="çiftlik_evi">Çiftlik Evi</option>
                        </select>

                        <label class="form-label" for="oda_sayisi">Oda Sayısı:</label>
                        <input class="form-control" type="text" id="oda_sayisi" name="oda_sayisi" min="1">

                        <label class="form-label" for="konut_yasi">Konut Yaşı:</label>
                        <input class="form-control" type="text" id="konut_yasi" name="konut_yasi" min="0">

                        <input class="form-control" type="hidden" id="store_id" name="store_id"
                            value="{{ $institutional->id }}">

                        <label class="form-label" for="kullanim_durumu">Kullanım Durumu:</label>
                        <select class="form-control" id="kullanim_durumu" name="kullanim_durumu">
                            <option value="">Seçiniz</option>
                            <option value="kiracılı">Kiracılı</option>
                            <option value="boş">Boş</option>
                            <option value="mülk_sahibi">Mülk Sahibi</option>
                        </select>

                        <label class="form-label" for="satis_rakami">Düşündüğünüz Satış Rakamı:</label>
                        <input class="form-control" type="text" id="satis_rakami" name="satis_rakami"
                            min="0">

                        <label class="form-label" for="tapu_belgesi">Tapu Belgesi Yükleyiniz:</label>
                        <input class="form-control" type="file" id="tapu_belgesi" name="tapu_belgesi"
                            accept=".pdf,.doc,.docx">
                    </div>

                    <div id="arsayse" style="display: none;" class="col-md-12 col-12">
                        <label class="form-label" for="arsa_il">Arsa İli:</label>
                        <input class="form-control" type="text" id="arsa_il" name="arsa_il">

                        <label class="form-label" for="arsa_ilce">Arsa İlçe:</label>
                        <input class="form-control" type="text" id="arsa_ilce" name="arsa_ilce">

                        <label class="form-label" for="arsa_mahalle">Arsa Mahalle:</label>
                        <input class="form-control" type="text" id="arsa_mahalle" name="arsa_mahalle">

                        <label class="form-label" for="ada_parsel">Ada Parsel Bilgisi:</label>
                        <input class="form-control" type="text" id="ada_parsel" name="ada_parsel">

                        <label class="form-label" for="imar_durumu">Arsa İmar Durumu:</label>
                        <select class="form-control" id="imar_durumu" name="imar_durumu">
                            <option value="">Seçiniz</option>
                            <option value="villa">Villa</option>
                            <option value="konut">Konut</option>
                            <option value="turizm">Turizm</option>
                            <option value="sanayi">Sanayi</option>
                            <option value="ticari">Ticari</option>
                            <option value="bağ_bahçe">Bağ Bahçe</option>
                            <option value="tarla">Tarla</option>
                        </select>

                        <label class="form-label" for="satis_rakami">Düşündüğünüz Satış Rakamı:</label>
                        <input class="form-control" type="text" id="satis_rakami" name="satis_rakami"
                            min="0">
                    </div>

                    <div id="aracyse" style="display: none;" class="col-md-12 col-12">
                        <label class="form-label" for="arac_model_yili">Araç Model Yılı:</label>
                        <input class="form-control" type="text" id="arac_model_yili" name="arac_model_yili"
                            min="1900" max="{{ date('Y') }}">

                        <label class="form-label" for="arac_markasi">Araç Markası:</label>
                        <input class="form-control" type="text" id="arac_markasi" name="arac_markasi">

                        <label class="form-label" for="yakit_tipi">Yakıt Tipi:</label>
                        <select class="form-control" id="yakit_tipi" name="yakit_tipi">
                            <option value="">Seçiniz</option>
                            <option value="benzin">Benzin</option>
                            <option value="dizel">Dizel</option>
                            <option value="lpg">LPG</option>
                            <option value="elektrik">Elektrik</option>
                        </select>

                        <label class="form-label" for="vites_tipi">Vites Tipi:</label>
                        <select class="form-control" id="vites_tipi" name="vites_tipi">
                            <option value="">Seçiniz</option>
                            <option value="manuel">Manuel</option>
                            <option value="otomatik">Otomatik</option>
                        </select>

                        <label class="form-label" for="arac_satis_rakami">Satış Rakamı:</label>
                        <input class="form-control" type="text" id="arac_satis_rakami" name="arac_satis_rakami"
                            min="0">

                        <label class="form-label" for="ruhsat_belgesi">Ruhsat Belgesi Yükleyiniz:</label>
                        <input class="form-control" type="file" id="ruhsat_belgesi" name="ruhsat_belgesi"
                            accept=".pdf,.doc,.docx">
                    </div>

                    <div id="isyeriyse" style="display: none;" class="mb-3 col-md-12 col-12">

                        <label for="ticari_bilgiler" class="form-label">Ticari ile ilgili Bilgileri Giriniz:</label>
                        <textarea class="form-control" id="ticari_bilgiler" name="ticari_bilgiler"></textarea>

                        <label for="isyeri_satis_rakami" class="form-label">Düşündüğünüz Satış Rakamı:</label>
                        <input type="text" class="form-control" id="isyeri_satis_rakami" name="isyeri_satis_rakami"
                            min="0">
                    </div>

                </div>

                <button type="submit"
                    style="background-color: #ea2a28; color: white; padding: 10px; border: none;width:150px;margin-top:20px">Başvur</button>
            </form>



        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Price inputlarının istenilen biçimde gösterilmesini sağlayan jQuery kodu
        $(document).ready(function() {
            // Price inputlarının seçimi
            $('input[type="text"][name*="_rakami"]').on('input', function() {
                // Girilen değer
                var value = $(this).val().replace(/[^\d,]/g, ''); // Sadece rakamlar ve virgülü kabul et
                // Değerin binlik ayraçları ile formatlanması
                var formattedValue = addCommas(value);
                // Input alanına formatlanmış değerin eklenmesi
                $(this).val(formattedValue);
            });

            // Girilen değeri binlik ayraçları ile formatlayan fonksiyon
            function addCommas(num) {
                // Virgül ve nokta içeren bir regex paterni
                var pattern = /(\d)(?=(\d{3})+(?!\d))/g;
                // Değerdeki noktayı virgüle dönüştürme
                num = num.replace('.', ',');
                // Değeri binlik ayraçlarını ekleyerek formatlama
                return num.toString().replace(pattern, '$1.');
            }
        });
    </script>
    <script>
        document.getElementById('takas_tercihi').addEventListener('change', function() {
            var digerDiv = document.getElementById('digeryse');
            var barterDiv = document.getElementById('barteryse');
            var emlakDiv = document.getElementById('emlakyse');
            var aracDiv = document.getElementById('aracyse');
            var konutDiv = document.getElementById('konutyse');
            var arsaDiv = document.getElementById('arsayse');
            var isyeriDiv = document.getElementById('isyeriyse');

            if (this.value === 'diğer') {
                digerDiv.style.display = 'block';
                barterDiv.style.display = 'none';
                emlakDiv.style.display = 'none';
                aracDiv.style.display = 'none';
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'none';
            } else if (this.value === 'emlak') {
                digerDiv.style.display = 'none';
                barterDiv.style.display = 'none';
                emlakDiv.style.display = 'block';
                aracDiv.style.display = 'none';
            } else if (this.value === 'araç') {
                digerDiv.style.display = 'none';
                barterDiv.style.display = 'none';
                emlakDiv.style.display = 'none';
                aracDiv.style.display = 'block';
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'none';
            } else if (this.value === 'barter') {
                digerDiv.style.display = 'none';
                barterDiv.style.display = 'block';
                emlakDiv.style.display = 'none';
                aracDiv.style.display = 'none';
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'none';
            } else {
                digerDiv.style.display = 'none';
                emlakDiv.style.display = 'none';
                barterDiv.style.display = 'none';
                aracDiv.style.display = 'none';
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'none';
            }
        });

        document.getElementById('emlak_tipi').addEventListener('change', function() {
            var konutDiv = document.getElementById('konutyse');
            var arsaDiv = document.getElementById('arsayse');
            var isyeriDiv = document.getElementById('isyeriyse');

            if (this.value === 'konut') {
                konutDiv.style.display = 'block';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'none';
            } else if (this.value === 'arsa') {
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'block';
                isyeriDiv.style.display = 'none';
            } else if (this.value === 'işyeri') {
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'block';
            } else {
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'none';
            }
        });
    </script>
@endsection

@section('styles')
    <style>
        label {
            margin-top: 20px;
        }

        .inner-pages .form-control {
            padding: 0 0.3rem !important
        }
    </style>
@endsection
