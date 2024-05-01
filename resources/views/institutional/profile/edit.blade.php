@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-300 border-bottom mb-4">

                    <div class="card-body">
                        {{-- @if ($errors->any())
                            <div class="alert alert-danger text-white">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}
                        {{-- @if (session('success'))
                            <div class="alert alert-success text-white text-white">
                                {{ session('success') }}
                            </div>
                        @endif --}}

                        <form action="{{ route('institutional.profile.update') }}" method="POST" enctype="multipart/form-data"
                            onsubmit="return validateForm()">
                            @csrf
                            @method('PUT')

                            <div class="corporate-form row" id="corporateForm">

                                <div class="col-lg-12">
                                    <div>
                                        <input class="d-none" id="upload-settings-porfile-picture" name="profile_image"
                                            type="file" accept=".jpeg, .jpg, .png" onchange="showImage(this)">
                                        <label class="avatar avatar-4xl status-online cursor-pointer"
                                            for="upload-settings-porfile-picture">
                                            <img id="profile-image-preview"
                                                class="rounded-circle img-thumbnail shadow-sm border-0"
                                                src="{{ asset('storage/profile_images/' . $user->profile_image) }}"
                                                width="200" alt="">
                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-6">

                                    <div class="mt-3">
                                        <label class="q-label">İsim</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name', $user->name) }}">
                                    </div>
                                    {{-- <div class="mt-3">
                                        <label class="q-label">Cep Telefon</label>
                                        <input type="number" name="mobile_phone" class="form-control" id="phone"
                                            value="{{ old('mobile_phone', $user->mobile_phone) }}" maxlength="10">
                                        <span id="error_message" class="error-message"></span>
                                    </div> --}}

                                    <div class="mt-3">
                                        <label class="q-label">Iban Numarası</label>
                                        <input type="text" name="iban" class="form-control"
                                            value="{{ old('iban', $user->iban) }}" oninput="formatIBAN(this)">
                                    </div>



                                    @if (Auth::check() && Auth::user()->type == 2)
                                        <div class="mt-3">
                                            <label class="q-label">Website Linki</label>
                                            <input type="url" name="website" class="form-control"
                                                value="{{ old('website', $user->website) }}">
                                        </div>
                                        {{-- <div class="mt-3">
                                            <label class="q-label">Sabit Telefon</label>
                                            <input type="number" name="phone" class="form-control" id="landPhone"
                                                value="{{ old('phone', $user->phone) }}" maxlength="10">
                                            <span id="error_message_land_phone" class="error-message"></span>
                                        </div> --}}
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <label class="q-label">Sabit Telefon (Opsiyonel)</label>
                                            </div>
                                            <div class="col-md-4 r-0" style="margin-right: 0px;">
                                                <div class="input-group">
                                                    <select name="area_code" id="area_code" class="form-control">
                                                        <option value="">Alan Kodu Seçiniz</option>
                                                        <?php
                                                        $alanKodu = [
                                                            'Adana' => '322',
                                                            'Adıyaman' => '416',
                                                            'Afyon' => '272',
                                                            'Ağrı' => '472',
                                                            'Aksaray' => '382',
                                                            'Amasya' => '358',
                                                            'Ankara' => '312',
                                                            'Antalya' => '242',
                                                            'Ardahan' => '478',
                                                            'Artvin' => '466',
                                                            'Aydın' => '256',
                                                            'Balıkesir' => '266',
                                                            'Bartın' => '378',
                                                            'Batman' => '488',
                                                            'Bayburt' => '458',
                                                            'Bilecik' => '228',
                                                            'Bingöl' => '426',
                                                            'Bitlis' => '434',
                                                            'Bolu' => '374',
                                                            'Burdur' => '248',
                                                            'Bursa' => '224',
                                                            'Çanakkale' => '286',
                                                            'Çankırı' => '376',
                                                            'Çorum' => '364',
                                                            'Denizli' => '258',
                                                            'Diyarbakır' => '412',
                                                            'Düzce' => '380',
                                                            'Edirne' => '284',
                                                            'Elazığ' => '424',
                                                            'Erzincan' => '446',
                                                            'Erzurum' => '442',
                                                            'Eskişehir' => '222',
                                                            'Gaziantep' => '342',
                                                            'Giresun' => '454',
                                                            'Gümüşhane' => '456',
                                                            'Hakkari' => '438',
                                                            'Hatay' => '326',
                                                            'Iğdır' => '476',
                                                            'Isparta' => '246',
                                                            'İçel (Mersin)' => '324',
                                                            'İstanbul' => [
                                                                'Avrupa Yakası' => '212',
                                                                'Anadolu Yakası' => '216'
                                                            ],
                                                            'İzmir' => '232',
                                                            'Kahramanmaraş' => '344',
                                                            'Karabük' => '370',
                                                            'Karaman' => '338',
                                                            'Kars' => '474',
                                                            'Kastamonu' => '366',
                                                            'Kayseri' => '352',
                                                            'Kırıkkale' => '318',
                                                            'Kırklareli' => '288',
                                                            'Kırşehir' => '386',
                                                            'Kilis' => '348',
                                                            'Kocaeli' => '262',
                                                            'Konya' => '332',
                                                            'Kütahya' => '274',
                                                            'Malatya' => '422',
                                                            'Manisa' => '236',
                                                            'Mardin' => '482',
                                                            'Muğla' => '252',
                                                            'Muş' => '436',
                                                            'Nevşehir' => '384',
                                                            'Niğde' => '388',
                                                            'Ordu' => '452',
                                                            'Osmaniye' => '328',
                                                            'Rize' => '464',
                                                            'Sakarya' => '264',
                                                            'Samsun' => '362',
                                                            'Siirt' => '484',
                                                            'Sinop' => '368',
                                                            'Sivas' => '346',
                                                            'Şanlıurfa' => '414',
                                                            'Şırnak' => '486',
                                                            'Tekirdağ' => '282',
                                                            'Tokat' => '356',
                                                            'Trabzon' => '462',
                                                            'Tunceli' => '428',
                                                            'Uşak' => '276',
                                                            'Van' => '432',
                                                            'Yalova' => '226',
                                                            'Yozgat' => '354',
                                                            'Zonguldak' => '372'
                                                        ];
                                                    
                                                        foreach ($alanKodu as $cityName => $cityCode) {
                                                            if (is_array($cityCode)) {
                                                                echo '<optgroup label="' . $cityName . '">';
                                                                foreach ($cityCode as $subCityName => $subCityCode) {
                                                                    echo '<option value="' . $subCityCode . '">' . $subCityName . ' (' . $subCityCode . ')' . '</option>';
                                                                }
                                                                echo '</optgroup>';
                                                            } else {
                                                                echo '<option value="' . $cityCode . '">' . $cityName . ' (' . $cityCode . ')' . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>   
                                            </div>
                                            <div class="col-md-8 pl-0" style="margin-left: -20px;">
                                                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone',$user->phone) }}" maxlength="10">
                                            </div>    
                                        </div> 
                                        <div class="mt-3">
                                            <label class="q-label">Kaç yıldır sektördesiniz ?</label>
                                            <input type="text" name="year" class="form-control"
                                                value="{{ old('year', $user->year) }}">
                                        </div>
                                    @endif

                                    <div class="mt-3">
                                        <label class="q-label">
                                            @if (Auth::check() && Auth::user()->type == 2)
                                                Mağaza
                                            @else
                                                Profil
                                            @endif
                                            arka plan rengi
                                        </label><br>
                                        <input type="color" name="banner_hex_code" class="form-control"
                                            value="{{ old('banner_hex_code', $user->banner_hex_code) }}">
                                    </div>
                                </div>

                                @if (Auth::check() && Auth::user()->type == 2)
                                    <div class="col-lg-6">
                                        <div class="mt-3">
                                            <label class="q-label">Konum (Lütfen haritadan konumunuzu seçiniz.)</label>
                                            <input type="hidden" name="latitude" id="latitude"
                                                value="{{ old('latitude', $user->latitude) }}">
                                            <input type="hidden" name="longitude" id="longitude"
                                                value="{{ old('longitude', $user->longitude) }}">
                                            <div id="mapContainer" style="height: 350px;"></div>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary mt-5">Güncelle</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">



            <div class="col-md-7 col-12">
                <div class="card shadow-sm border-300 border-bottom mb-4">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger text-white">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success text-white text-white">
                                {{ session('success') }}
                            </div>
                        @endif



                        <form action="{{ route('institutional.edit.phone') }}" method="POST" enctype="multipart/form-data"
                            onsubmit="return validateForm()">
                            @csrf
                            @method('PUT')

                            <div class="corporate-form row" id="corporateForm">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mt-3">
                                            <label class="q-label">Cep Numarası</label>
                                            <span id="error_message" class="error-message"></span>
                                            <input type="number" name="mobile_phone" class="form-control"
                                                id="phone" value="{{ old('mobile_phone', $user->mobile_phone) }}"
                                                readonly>
                                            <input type="checkbox" id="enablePhone" onchange="togglePhone()">
                                            <label for="enablePhone" class="mt-5 mb-5">Güncellemek İstiyorum</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div id="phoneFields" style="display: none;">
                                            <label class="q-label mt-3">Belge Ekle</label>
                                            <div class="" style="position: relative;">
                                                <!-- Resmin boyutunu küçültmek için max-width ve max-height stil özellikleri ekleyelim -->
                                                <img src="" alt="Yüklenen Resim" id="uploadedImage"
                                                    style="display: none; max-width: 200px; max-height: 200px; border: 1px solid #ccc;">
                                            </div>
                                            <input type="file" name="image" id="image" class="form-control"
                                                onchange="toggleUpdateButton()">

                                            <p class="text-danger mt-2">Lütfen Belge Formatına Uygun Şeklinde Ekleyiniz.
                                                </p>    
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-6"> 
                                <button type="submit" class="btn btn-primary mt-4" id="updateButton"
                                            disabled>Güncelle</button>
                                        </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-md-5 col-12">
                <div class="card shadow-sm border-100 border-bottom mb-4">
                    <div class="card-body">
                        <p class="card-text">Belge formatı:</p>
                        <p class="card-text">xxxx mail adresim ve xxxx telefon numarası ile kayıtlı olan üyeliğimdeki</p>
                        <p class="card-text">xxxx mail addresim ve xxxx telefon numarasıyla değiştirilmesini talep ediyorum
                        </p>
                        <p class="card-text">isim soyisim</p>
                        <p class="card-text">imza</p>
                        <!-- TC Kimlik Numarası alanı -->
                        <img class="img-fluid mx-auto d-block" src="{{ asset('images/tc/tcpng.png') }}"
                            alt="Örnek Resim" style="width: 300px;">

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Google Maps API script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&callback=initMap" async
        defer></script>

        <script>
            $(document).ready(function() {
                $('#area_code').change(function() {
                    var areaCode = $(this).val();
                    $('#phone').val(areaCode);
                    $('#phone').append(areaCode);
                });
    
                $('#phone').on('input', function() {
                    var areaCode = $('#area_code').val();
                    var phoneNumber = $(this).val();
                    
                    var fullPhoneNumber = areaCode + phoneNumber;
                }); 
            });
    
        </script>

    <script>
        function togglePhone() {
            var phoneInput = document.getElementById('phone');
            var enablePhoneCheckbox = document.getElementById('enablePhone');
            var phoneFields = document.getElementById('phoneFields');
            var updateButton = document.getElementById('updateButton');

            if (enablePhoneCheckbox.checked) {
                phoneInput.readOnly = false;
                phoneFields.style.display = 'block';
                toggleUpdateButton(); // Telefonu düzenle seçildiğinde, güncelleme butonunu kontrol et
            } else {
                phoneInput.readOnly = true;
                phoneFields.style.display = 'none';
                toggleUpdateButton(); // Telefonu düzenle seçilmediğinde, güncelleme butonunu kontrol et
            }
        }

        function toggleUpdateButton() {
            var imageInput = document.getElementById('image');
            var updateButton = document.getElementById('updateButton');
            var uploadedImage = document.getElementById('uploadedImage');

            if (imageInput.files.length > 0) {
                updateButton.disabled = false; // Eğer bir resim yüklendi ise, güncelleme butonunu etkinleştir
                uploadedImage.src = URL.createObjectURL(imageInput.files[0]); // Yüklenen resmi göster
                uploadedImage.style.display = 'block';
            } else {
                updateButton.disabled = true; // Eğer resim yüklenmedi ise, güncelleme butonunu devre dışı bırak
                uploadedImage.src = '';
                uploadedImage.style.display = 'none';
            }
        }
    </script>


    <script>
        $(document).ready(function() {
            $("#landPhone").blur(function() {
                var phoneNumber = $(this).val();
                var pattern = /^[0-9]\d{9}$/;

                if (!pattern.test(phoneNumber)) {
                    $("#error_message_land_phone").text(
                        "Lütfen geçerli bir telefon numarası giriniz."
                        );
                } else {
                    $("#error_message_land_phone").text("");
                }
                     // Kullanıcı 10 haneden fazla veri girdiğinde bu kontrol edilir
                     $('#landPhone').on('keypress', function (e) {
                        var max_length = 10;
                        // Eğer giriş karakter sayısı 10'a ulaştıysa ve yeni karakter ekleme işlemi değilse
                        if ($(this).val().length >= max_length && e.which != 8 && e.which != 0) {
                            // Olayın işlenmesini durdur
                            e.preventDefault();
                        }
                    });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#phone").on("input blur", function(){
                var phoneNumber = $(this).val();
                var pattern = /^5[0-9]\d{8}$/;

                if (!pattern.test(phoneNumber)) {
                    $("#error_message").text(
                        "Lütfen geçerli bir telefon numarası giriniz.");
                } else {
                    $("#error_message").text("");
                }
                     // Kullanıcı 10 haneden fazla veri girdiğinde bu kontrol edilir
                     $('#phone').on('keypress', function (e) {
                        var max_length = 10;
                        // Eğer giriş karakter sayısı 10'a ulaştıysa ve yeni karakter ekleme işlemi değilse
                        if ($(this).val().length >= max_length && e.which != 8 && e.which != 0) {
                            // Olayın işlenmesini durdur
                            e.preventDefault();
                        }
                    });
            });
        });
    </script>
    <script>
        function showImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-image-preview').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>



    <script>
        var map;
        var marker;

        function initMap(cityName, zoomLevel) {
            // Harita oluştur
            map = new google.maps.Map(document.getElementById('mapContainer'), {
                zoom: 10, // Başlangıç zoom seviyesi
                center: {
                    lat: 41.0082,
                    lng: 28.9784
                } // Başlangıç merkez koordinatları (İstanbul örneği)
            });

            google.maps.event.addListener(map, 'click', function(event) {
                placeMarker(event.latLng);
            });

            if (cityName) {
                // Google Haritalar Geocoding API'yi kullanarak şehir adını koordinatlara dönüştür
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    address: cityName
                }, function(results, status) {
                    if (status === 'OK') {
                        // Başarılı ise haritayı zoomla
                        map.setCenter(results[0].geometry.location);
                        map.setZoom(zoomLevel); // İstediğiniz zoom seviyesini ayarlayabilirsiniz
                    } else {
                        alert('Şehir bulunamadı: ' + status);
                    }
                });
            }

            var userLatitude = $("#latitude").val();
            var userLongitude = $("#longitude").val();



            if (userLatitude && userLongitude) {
                var userLocation = new google.maps.LatLng(userLatitude, userLongitude);
                placeMarker(userLocation);
            }
        }

        window.initMap = initMap;

        function placeMarker(location) {
            clearMarker(); // Önceki işaretçiyi temizle

            // İşaretçiyi oluşturun
            marker = new google.maps.Marker({
                position: location,
                map: map
            });

            document.getElementById('latitude').value = location.lat();
            document.getElementById('longitude').value = location.lng();

            // Bilgi penceresi oluşturun (isteğe bağlı)
            var infowindow = new google.maps.InfoWindow({
                content: 'Koordinatlar: ' + location.lat() + ', ' + location.lng()
            });

            // İşaretçiye tıklandığında bilgi penceresini gösterin
            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });

            // İşaretçiyi dizide saklayın
            markers.push(marker);
        }

        function clearMarker() {
            if (marker) {
                marker.setMap(null);
                marker = null;
            }
        }
    </script>


    <script>
        const accountTypeRadios = document.querySelectorAll('input[name="account_type"]');
        const idNumberDiv = document.getElementById('idNumberDiv');

        // Sayfa yüklendiğinde mevcut kullanıcının hesap türünü kontrol edin ve TC Kimlik Numarası alanını gösterin veya gizleyin
        function toggleIdNumberVisibility() {
            const selectedAccountType = document.querySelector('input[name="account_type"]:checked').value;
            if (selectedAccountType === '1') {
                idNumberDiv.style.display = 'block'; // Şahıs Şirketi seçildiyse göster
            } else {
                idNumberDiv.style.display = 'none'; // Diğer türler seçildiyse gizle
            }
        }

        // Sayfa yüklendiğinde hesap türünü kontrol edin ve TC Kimlik Numarası alanını gösterin veya gizleyin
        toggleIdNumberVisibility();

        // Hesap türü değiştikçe TC Kimlik Numarası alanının görünürlüğünü güncelleyin
        accountTypeRadios.forEach(radio => {
            radio.addEventListener('change', toggleIdNumberVisibility);
        });

        const companyTypeRadios = document.querySelectorAll('input[name="account_type"]');
        const taxNumberInput = document.getElementById('taxNumber');
        const idNumberInput = document.getElementById('idNumberDiv');

        companyTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === '1') { // Şahıs Şirketi seçildiğinde
                    taxNumberInput.style.display = 'block'; // Vergi Numarası görünür
                    idNumberInput.style.display = 'block'; // TC Kimlik Numarası gizli
                } else if (this.value === '2') { // Limited veya Anonim Şirketi seçildiğinde
                    taxNumberInput.style.display = 'block'; // Vergi Numarası gizli
                    idNumberInput.style.display = 'none'; // TC Kimlik Numarası görünür
                }
            });
        });

        $('#citySelect').change(function() {
            var selectedCity = $(this).val();

            $.ajax({
                type: 'GET',
                url: '/get-counties/' + selectedCity,
                success: function(data) {
                    var countySelect = $('#countySelect');
                    countySelect.empty();
                    $.each(data, function(index, county) {
                        countySelect.append('<option value="' + county.ilce_key + '">' + county
                            .ilce_title +
                            '</option>');
                    });
                }
            });
        });


        $('#countySelect').change(function() {
            var selectedCounty = $(this).val();

            $.ajax({
                type: 'GET',
                url: '/get-neighborhoods/' + selectedCounty,
                success: function(data) {
                    var neighborhoodSelect = $('#neighborhoodSelect');
                    neighborhoodSelect.empty();
                    $.each(data, function(index, county) {
                        neighborhoodSelect.append('<option value="' + county.mahalle_key +
                            '">' +
                            county
                            .mahalle_title +
                            '</option>');
                    });
                }
            });
        });

        $('#taxOfficeCity').change(function() {
            var selectedCity = $(this).val();
            console.log(selectedCity);
            $.ajax({
                type: 'GET',
                url: '/get-tax-office/' + selectedCity,
                success: function(data) {
                    console.log(data);
                    var taxOffice = $('#taxOffice');
                    taxOffice.empty();
                    $.each(data, function(index, office) {
                        taxOffice.append('<option value="' + office.id + '">' + office
                            .daire +
                            '</option>');
                    });
                }
            });
        });

        $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                items: 2, // Varsayılan olarak 2 öğe göster
                loop: true,
                margin: 10,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1

                    },
                    768: {
                        items: 1 // 768 piksel genişlikte 1 öğe göster
                    },
                    1000: {
                        items: 2
                    }
                }
            });
        });

        function deselectOtherPlans() {
            // Tüm abonelik planı düğmelerini seçin
            const planButtons = document.querySelectorAll('.plan-button');

            // Her düğmeden "selected-plan-btn" sınıfını kaldırın
            planButtons.forEach(function(button) {
                button.classList.remove("selected-plan-btn");
                button.classList.add("btn-primary", "btn"); // Önceki stilini geri yükleyin
            });
        }

        function selectPlan(button) {
            const planId = button.getAttribute('data-plan-id');
            const planName = button.getAttribute('data-plan-name');
            const planPrice = button.getAttribute('data-plan-price');
            toastr.success("Abonelik Planı Başarıyla Seçildi");
            // Diğer plan düğmelerinden "selected-plan-btn" sınıfını kaldırın
            deselectOtherPlans();

            // Button'un sınıfını güncelle
            button.classList.remove("btn-primary", "btn");
            button.classList.add("btn-success", "selected-plan-btn");
            document.getElementById('selected-plan-id').value = planId;
        }
    </script>
    <script>
        function formatIBAN(input) {
            // TR ile başlat
            var formattedIBAN = "TR";

            // Gelen değerden sadece rakamları al
            var numbersOnly = input.value.replace(/\D/g, '');

            // İBAN uzunluğunu kontrol et ve fazla karakterleri kırp
            if (numbersOnly.length > 24) {
                numbersOnly = numbersOnly.substring(0, 24);
            }

            // Geri kalanı 4'er basamaklı gruplara ayır ve aralarına boşluk ekle
            for (var i = 0; i < numbersOnly.length; i += 4) {
                formattedIBAN += numbersOnly.substr(i, 4) + " ";
            }

            // Formatlanmış İBAN'ı input değerine ata
            input.value = formattedIBAN.trim();
        }
    </script>

    <script>
        function validateForm() {
            var ibanInput = document.getElementsByName("iban")[0];
            var ibanValue = ibanInput.value;

            if (ibanValue.length < 26) {
                alert("IBAN numarası 26 haneden az olamaz!");
                return false; // Formun gönderilmesini engelle
            }

            return true; // Formu gönder
        }
    </script>


    <style>
        .companyType {
            display: flex;
            align-items: center;
            justify-content: start
        }

        .error-message {
            color: #e54242;
            font-size: 11px;
        }
    </style>
@endsection
