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
            @if(session('success'))
                <div class="alert alert-success text-white">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('form.kaydet') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 col-12">
                        <label class="form-label" for="ad">Ad:</label>
                        <input class="formInput always-required" type="text" id="ad" name="ad" required>
                    </div>

                    <div class="col-md-6 col-12">
                        <label class="form-label" for="soyad">Soyadınız:</label>
                        <input class="formInput always-required" type="text" id="soyad" name="soyad" required>
                    </div>

                    <div class="col-md-6 col-12">
                        <label class="form-label" for="telefon">Telefon Numaranız:</label>
                        <input class="formInput always-required" type="number" id="telefon" name="telefon" required>
                        <span id="error_message" class="error-message"></span>
                    </div>

                    <div class="col-md-6 col-12">
                        <label class="form-label" for="email">E-mail:</label>
                        <input class="formInput always-required" type="email" id="email" name="email" required>
                    </div>

                    <div class="col-md-6 col-12">
                        <label class="form-label" for="sehir">Şehir:</label>
                        <select class="formInput always-required" id="sehir" name="sehir" required>
                            <option value="">Şehir Seçiniz</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 col-12">
                        <label class="form-label" for="ilce">İlçe:</label>
                        <select class="formInput always-required" id="ilce" name="ilce" disabled required>
                            <option value="">İlçe Seçiniz</option>
                        </select>
                    </div>

                    <div class="col-md-12 col-12">
                        <label class="form-label" for="takas_tercihi">Takas Tercihiniz:</label>
                        <select class="formInput" id="takas_tercihi" name="takas_tercihi" required>
                            <option value="">Seçiniz</option>
                            <option value="emlak">Emlak</option>
                            <option value="araç">Araç</option>
                            <option value="barter">Barter</option>
                            <option value="diğer">Diğer</option>
                        </select>
                    </div>

                    
                    <div id="digeryse" style="display: none;" class="col-md-12 col-12 conditional-fields">
                        <label class="form-label" for="diger_detay">Takas ile ilgili ürün/hizmet detayı:</label>
                        <textarea class="formInput" id="diger_detay" name="diger_detay"></textarea>
                    </div>

                    <div id="barteryse" style="display: none;" class="col-md-12 col-12 conditional-fields">
                        <label class="form-label" for="barter_detay">Lütfen barter durumunuz ile ilgili detaylı bilgileri
                            giriniz:</label>
                        <textarea class="formInput" id="barter_detay" name="barter_detay"></textarea>
                    </div>

                    <div id="emlakyse" style="display: none;" class="col-md-12 col-12 conditional-fields">
                        <label class="form-label" for="emlak_tipi">Emlak Tipi:</label>
                        <select class="formInput" id="emlak_tipi" name="emlak_tipi">
                            <option value="">Seçiniz</option>
                            <option value="konut">Konut</option>
                            <option value="arsa">Arsa</option>
                            <option value="işyeri">İşyeri</option>
                        </select>
                    </div>

                    <div id="konutyse" style="display: none;" class="col-md-12 col-12 conditional-fields">
                        <label class="form-label" for="konut_tipi">Konut Tipi:</label>
                        <select class="formInput" id="konut_tipi" name="konut_tipi">
                            <option value="">Seçiniz</option>
                            <option value="daire">Daire</option>
                            <option value="villa">Villa</option>
                            <option value="residance">Residance</option>
                            <option value="prefabrik_ev">Prefabrik Ev</option>
                            <option value="çiftlik_evi">Çiftlik Evi</option>
                        </select>

                            <label for="oda_sayisi">Oda Sayısı</label>
                            <select class="form-select formInput" aria-label="Default select example" id="oda_sayisi" name="oda_sayisi">
                                <option selected>Seçiniz</option>
                                <option value="1+0">1+0</option>
                                <option value="1.5+1">1.5+1</option>
                                <option value="2+0">2+0</option>
                                <option value="2+1">2+1</option>
                                <option value="2.5+1">2.5+1</option>
                                <option value="3+0">3+0</option>
                                <option value="3+1">3+1</option>
                                <option value="3.5+1">3.5+1</option>
                                <option value="3+2">3+2</option>
                                <option value="3+3">3+3</option>
                                <option value="4+0">4+0</option>
                                <option value="4+1">4+1</option>
                                <option value="4.5+1">4.5+1</option>
                                <option value="4+2">4+2</option>
                                <option value="4+3">4+3</option>
                                <option value="4+4">4+4</option>
                                <option value="5+1">5+1</option>
                                <option value="5.5+1">5.5+1</option>
                                <option value="5+2">5+2</option>
                                <option value="5+3">5+3</option>
                                <option value="5+4">5+4</option>
                                <option value="6+1">6+1</option>
                                <option value="6+2">6+2</option>
                                <option value="6.5+1">6.5+1</option>
                                <option value="6+3">6+3</option>
                                <option value="6+4">6+4</option>
                                <option value="7+1">7+1</option>
                                <option value="7+2">7+2</option>
                                <option value="7+3">7+3</option>
                                <option value="8+1">8+1</option>
                                <option value="8+2">8+2</option>
                                <option value="8+3">8+3</option>
                                <option value="8+4">8+4</option>
                                <option value="9+1">9+1</option>
                                <option value="9+2">9+2</option>
                                <option value="9+3">9+3</option>
                                <option value="9+4">9+4</option>
                                <option value="9+5">9+5</option>
                                <option value="9+6">9+6</option>
                                <option value="10+1">10+1</option>
                                <option value="10+2">10+2</option>
                                <option value="11+1">11+1</option>
                                <option value="12 ve üzeri">12 ve üzeri</option>
                            </select>

                        <label class="form-label" for="konut_tipi">Konut Yaşı:</label>
                        <select class="formInput" id="konut_yasi" name="konut_yasi">
                            <option value="">Seçiniz</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5-10">5-10</option>
                            <option value="11-15">11-15</option>
                            <option value="16-20">16-20</option>
                            <option value="20 ve Üzeri">20 ve Üzeri</option>
                        </select>

                        <input class="formInput" type="hidden" id="store_id" name="store_id" value="{{ $institutional->id }}">

                        <label class="form-label" for="kullanim_durumu">Kullanım Durumu:</label>
                        <select class="formInput" id="kullanim_durumu" name="kullanim_durumu">
                            <option value="">Seçiniz</option>
                            <option value="kiracılı">Kiracılı</option>
                            <option value="boş">Boş</option>
                            <option value="mülk_sahibi">Mülk Sahibi</option>
                        </select>

                        <label class="form-label" for="konut_satis_rakami">Düşündüğünüz Satış Rakamı:</label>
                        <input class="formInput" type="text" id="konut_satis_rakami" name="konut_satis_rakami" min="0">

                        <label class="form-label" for="tapu_belgesi">Tapu Belgesi Yükleyiniz:</label>
                        <input class="formInput" type="file" id="tapu_belgesi" name="tapu_belgesi" accept=".pdf,.doc,.docx">
                    </div>

                    <div id="arsayse" style="display: none;" class="col-md-12 col-12 conditional-fields">

                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label" for="arsa_il">Arsa İl:</label>
                                <select class="formInput" id="arsa_il" name="arsa_il">
                                    <option value="">Şehir Seçiniz</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->title }}</option>
                                    @endforeach
                                </select>
                            </div>    

                            <div class="col-md-4">
                                <label class="form-label" for="arsa_ilce">Arsa İlçe:</label>
                                <select class="formInput" id="arsa_ilce" name="arsa_ilce" disabled>
                                    <option value="">İlçe Seçiniz</option>
                                </select>
                            </div>   

                            <div class="col-md-4">
                                <label class="form-label" for="arsa_mahalle">Arsa Mahalle:</label>
                                <select class="formInput" id="arsa_mahalle" name="arsa_mahalle" disabled>
                                    <option value="">Mahalle Seçiniz</option>
                                </select>
                            </div>   
                        </div>

                        <label class="form-label" for="ada_parsel">Ada Parsel Bilgisi:</label>
                        <input class="formInput" type="text" id="ada_parsel" name="ada_parsel">

                        <label class="form-label" for="imar_durumu">Arsa İmar Durumu:</label>
                        <select class="formInput" id="imar_durumu" name="imar_durumu">
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
                        <input class="formInput" type="text" id="satis_rakami" name="satis_rakami" min="0">
                    </div>

                    <div id="aracyse" style="display: none;" class="col-md-12 col-12 conditional-fields">

                            <label class="form-label" for="arac_model_yili">Araç Model Yılı:</label>
                            <select class="formInput" id="arac_model_yili" name="arac_model_yili">
                                <option value="">Model Yılı Seçiniz</option>
                                @for ($year = date('Y'); $year >= 2004; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>


                        <label class="form-label" for="arac_markasi">Araç Markası:</label>
                        <input class="formInput" type="text" id="arac_markasi" name="arac_markasi">

                        <label class="form-label" for="yakit_tipi">Yakıt Tipi:</label>
                        <select class="formInput" id="yakit_tipi" name="yakit_tipi">
                            <option value="">Seçiniz</option>
                            <option value="benzin">Benzin</option>
                            <option value="dizel">Dizel</option>
                            <option value="lpg">LPG</option>
                            <option value="elektrik">Elektrik</option>
                        </select>

                        <label class="form-label" for="vites_tipi">Vites Tipi:</label>
                        <select class="formInput" id="vites_tipi" name="vites_tipi">
                            <option value="">Seçiniz</option>
                            <option value="manuel">Manuel</option>
                            <option value="otomatik">Otomatik</option>
                        </select>

                        <label class="form-label" for="arac_satis_rakami">Satış Rakamı:</label>
                        <input class="formInput" type="text" id="arac_satis_rakami" name="arac_satis_rakami" min="0">

                        <label class="form-label" for="ruhsat_belgesi">Ruhsat Belgesi Yükleyiniz:</label>
                        <input class="formInput" type="file" id="ruhsat_belgesi" name="ruhsat_belgesi" accept=".pdf,.doc,.docx">
                    </div>

                    <div id="isyeriyse" style="display: none;" class="mb-3 col-md-12 col-12 conditional-fields">

                        <label for="ticari_bilgiler" class="form-label">Ticari ile ilgili Bilgileri Giriniz:</label>
                        <textarea class="formInput" id="ticari_bilgiler" name="ticari_bilgiler"></textarea>

                        <label for="isyeri_satis_rakami" class="form-label">Düşündüğünüz Satış Rakamı:</label>
                        <input type="text" class="formInput" id="isyeri_satis_rakami" name="isyeri_satis_rakami"  min="0">
                    </div>

                </div>

                <button type="submit" style="background-color: #ea2a28; color: white; padding: 10px; border: none;width:150px;margin-top:20px">Başvur</button>
            </form>

        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
               $(document).ready(function() {
            $("#telefon").blur(function() {
                var phoneNumber = $(this).val();
                var pattern = /^5[1-9]\d{8}$/;

                if (!pattern.test(phoneNumber)) {
                    $("#error_message").text(
                        "Lütfen telefon numarasını belirtilen formatta girin. Örneğin: (555) 111 22 33");
                } else {
                    $("#error_message").text("");
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('form').submit(function(e) {
                var isEmpty = false;

               // Emlak seçildiyse, ilgili alanların doldurulma zorunluluğunu kontrol et
 // Emlak seçildiyse, ilgili alanların doldurulma zorunluluğunu kontrol et
 if ($('#takas_tercihi').val() === 'emlak') {
            var emlakTipi = $('#emlak_tipi').val();
            if (emlakTipi === 'konut' || emlakTipi === 'arsa') {
                var requiredFields = [];
                if (emlakTipi === 'konut') {
                    requiredFields = ['konut_satis_rakami', 'kullanim_durumu', 'konut_yasi', 'oda_sayisi', 'konut_tipi'];
                } else if (emlakTipi === 'arsa') {
                    requiredFields = ['arsa_il', 'arsa_ilce', 'arsa_mahalle', 'ada_parsel', 'imar_durumu', 'satis_rakami'];
                }
            } else if (emlakTipi === 'işyeri') {
                requiredFields = ['ticari_bilgiler', 'isyeri_satis_rakami'];
            }

            for (var i = 0; i < requiredFields.length; i++) {
                var field = $('#' + requiredFields[i]);
                if (field.val().trim() === '') {
                    isEmpty = true;
                    field.addClass('error');
                } else {
                    field.removeClass('error');
                }
            }
        }

                 // Araç seçildiyse, ilgili alanların doldurulma zorunluluğunu kontrol et
                    if ($('#takas_tercihi').val() === 'araç') {
                        var requiredFields = ['arac_model_yili', 'arac_markasi', 'yakit_tipi', 'vites_tipi', 'arac_satis_rakami'];

                        for (var i = 0; i < requiredFields.length; i++) {
                            var field = $('#' + requiredFields[i]);
                            if (field.val().trim() === '') {
                                isEmpty = true;
                                field.addClass('error');
                            } else {
                                field.removeClass('error');
                            }
                        }
                    }

           
                // Barter veya Diğer seçildiyse, ilgili alanların boş olup olmadığını kontrol et
                if ($('#takas_tercihi').val() === 'barter' || $('#takas_tercihi').val() === 'diğer') {
                    $('.conditional-fields:visible').find('.formInput').each(function() {
                        if ($(this).val().trim() === '') {
                            isEmpty = true;
                            $(this).addClass('error');
                        } else {
                            $(this).removeClass('error');
                        }
                    });
                }

                if (isEmpty) {
                    e.preventDefault();
                    alert('Tüm zorunlu alanları doldurunuz!');
                }
        
            });   
        });
        </script>

    <script>
        $(document).ready(function() {
            $('#sehir').change(function() {
                var cityId = $(this).val();
                console.log(cityId)
                if(cityId) {
                    $.ajax({
                        url: '{{ route("get-districts", ":city_id") }}'.replace(':city_id', cityId),
                        type: 'GET',
                        data: { city_id: cityId },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data)
                            $('#ilce').empty().prop('disabled', false);
                            $.each(data, function(index, district) {
                            $('#ilce').append('<option value="'+ district.ilce_key +'">'+ district.ilce_title +'</option>');
                        });
                        }
                    });
                } else {
                    $('#ilce').empty().prop('disabled', true);
                }
            });

            $('#arsa_il').change(function() {
                var cityId = $(this).val();
                console.log(cityId)
                if(cityId) {
                    $.ajax({
                        url: '{{ route("get-districts", ":city_id") }}'.replace(':city_id', cityId),
                        type: 'GET',
                        data: { city_id: cityId },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data)
                            $('#arsa_ilce').empty().prop('disabled', false);
                            $.each(data, function(index, district) {
                            $('#arsa_ilce').append('<option value="'+ district.ilce_key +'">'+ district.ilce_title +'</option>');
                        });
                        }
                    });
                } else {
                    $('#ilce').empty().prop('disabled', true);
                }
            });


            
            // İlçe seçildiğinde mahallelerin yüklenmesi
            $('#arsa_ilce').change(function() {
                var districtId = $(this).val();
                console.log(districtId)
                if(districtId) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('get-neighborhoods', ['districtId' => '__districtId__']) }}".replace('__districtId__', districtId), 
                        success: function(data) {
                            console.log(data)
                            if(data) {
                                $('#arsa_mahalle').html('<option value="">Mahalle Seçiniz</option>');
                                $.each(data, function(index, neighborhoods) {
                                    $('#arsa_mahalle').append('<option value="'+ neighborhoods.mahalle_id +'">'+ neighborhoods.mahalle_title +'</option>');
                                });
                                $('#arsa_mahalle').prop('disabled', false);
                            } else {
                                $('#arsa_mahalle').html('<option value="">Mahalle bulunamadı</option>');
                                $('#arsa_mahalle').prop('disabled', true);
                            }
                        }
                    });
                } else {
                    $('#arsa_mahalle').html('<option value="">Mahalle Seçiniz</option>');
                    $('#arsa_mahalle').prop('disabled', true);
                }
            });
        });
    </script>

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

        .formInput{
            display: block;
            width: 100%;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 2.0;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #b9b9b9;
            border-radius: .35rem;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.07);
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .formInput:focus {
            color: #495057;
            background-color: #fff;
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 .2rem rgba(0,123,255,.25);
        }
    </style>
@endsection
