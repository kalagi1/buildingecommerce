@extends('client.layouts.master')

@section('content')
    <section class="loginItems">
        <div class="container">

                <div class="row">
                    {{-- <div class="col-md-6">


                        <img src="{{ asset('login/loginImage.png') }}" alt=""
                            style="width:100%;height:auto !important">

                    </div> --}}
                    <div class="col-md-7 mx-auto">
                        <div class="single homes-content details mb-30 ">

                        <div class="login-container">
                            <ul class="nav nav-tabs login-tabs" id="myTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active show "
                                        id="normal-tab" data-toggle="tab" href="#normal" role="tab"
                                        aria-controls="normal" aria-selected="true">
                                        <h3 class="text-center ">Giriş Yap</h3>
                                    </a>
                                </li>
                            </ul>

                            <div class="login-content">
                                <!-- Sekme İçeriği -->
                                <div class="tab-content" id="myTabContent">
                                    <!-- Normal Hesap Girişi Sekmesi -->
                                    <div class="tab-pane fade @if ($errors->has('login_error') || (!$errors->any() && !isset($_GET['uye-ol']))) active show @else hide @endif "
                                        id="normal" role="tabpanel" aria-labelledby="normal-tab">

                                        <div class="mt-5">
                                            @if (session()->has('success'))
                                                <div class="alert alert-success text-white">
                                                    {{ session()->get('success') }}
                                                </div>
                                            @elseif (session()->has('error'))
                                                <div class="alert alert-danger text-white">
                                                    {{ session()->get('error') }}
                                                </div>
                                            @elseif (session()->has('warning'))
                                                <div class="alert alert-warning">
                                                    {{ session()->get('warning') }}
                                                </div>
                                            @endif
                                        </div>
                                        @if ($errors->has('login_error'))
                                            <div class="alert alert-danger text-white">
                                                {{ $errors->first('login_error') }}
                                            </div>
                                        @endif

                                        <form method="POST" class="form w-100" action="{{ route('client.submit.login') }}">
                                            @csrf

                                            <!-- E-Posta -->
                                            <div class="mt-3">
                                                <label class="q-label">E-Posta</label>
                                                <input type="email" name="email" class="form-control"
                                                    value="{{ old('email') }}">
                                            </div>

                                            <!-- Şifre -->
                                            <div class="mt-3">
                                                <label class="q-label">Şifre</label>
                                                <input type="password" name="password" id="passwordInput"
                                                    class="form-control">
                                                <i id="eyeIcon" class="fa fa-eye-slash field-icon"
                                                    onclick="togglePassword()"></i>
                                            </div>

                                            <!-- Remember me and forgot password links -->
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-check-inline" style="margin-top:12px;">
                                                        <input type="checkbox" class="form-check-input" id="remember"
                                                            name="remember">
                                                        <label class="form-check-label" for="remember"
                                                            style="margin-top:2px;">Beni Hatırla</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="forgot-password d-flex justify-content-end">
                                                        <a href="{{ route('password.request') }}"><span>Şifremi
                                                                Unuttum</span></a>
                                                    </div>
                                                </div>
                                            </div>

                                            <button class="btn btn-primary q-button" type="submit">Giriş Yap</button>
                                            <p class="redirect-to-register text-center pt-2">
                                                <span>Henüz hesabın yok mu?</span>
                                                <a href="{{route('client.register')}}"> Üye Ol </a>
                                                
                                            </p>

                                            <div class="social-account-login-buttons mt-2 pb-3 col-12 p-0">
                                                <!-- Social login buttons -->
                                                <div class="q-layout social-login-button  w-100 m-0" style="justify-content: center;align-items:center">
                                                    <div class="social-login-icon"
                                                        style="background-color: rgb(241, 66, 54);">
                                                        <i class="fa fa-google"></i>
                                                    </div>
                                                    <div class="flex flex-column">
                                                        <div>
                                                            <a href="{{ route('client.google.login') }}"
                                                                style="color: black;text-decoration:none">
                                                                <div style="text-transform: capitalize;">google İle giriş yap</div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="redirect-to-register text-center pt-2">
                                                <span><label> Google kimliğinizle bir sonraki adıma geçmeniz halinde <a href="/sayfa/bireysel-uyelik-sozlesmesi" rel="nofollow" target="_blank">Bireysel Hesap Sözleşmesi ve Ekleri</a></label>'ni kabul etmiş sayılırsınız.</span>                                                <a href="{{route('client.register')}}"> Üye Ol </a>
                                                
                                            </p>
                                        </form>


                                    </div>
                                    {{-- <h4 class="support-phone">Bilgi almak için arayın : <a href="tel:4443284">444 3
                                            284</a>
                                    </h4> --}}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- Scripts for toggling password visibility -->
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("passwordInput");
            var eyeIcon = document.getElementById("eyeIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            }
        }
    </script>

    <script>
        $(document).ready(function() {

            $('#area_code, #phone').on('input', function() {
                var areaCode = $('#area_code').val();
                var phoneNumber = $('#phone').val();
                // Eğer alan kodu veya telefon numarası girilmediyse işlem yapma
                if (areaCode && phoneNumber) {
                    // Telefon numarasını güncelle
                    var fullPhoneNumber = areaCode + phoneNumber;
                    // Telefon numarasını konsola yazdır
                    console.log("Telefon numarası: " + fullPhoneNumber);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#mobile_phone").on("input blur", function() {
                var phoneNumber = $(this).val();
                var pattern = /^5[0-9]\d{8}$/;

                if (!pattern.test(phoneNumber)) {
                    $("#error_message").text("Lütfen geçerli bir telefon numarası giriniz.");
                } else {
                    $("#error_message").text("");
                }
                // Kullanıcı 10 haneden fazla veri girdiğinde bu kontrol edilir
                $('#mobile_phone').on('keypress', function(e) {
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
        const individualForm = document.getElementById('individualForm');
        const individualFormCheck = document.getElementById('individualFormCheck');
        const corporateForm = document.getElementById('corporateForm');
        const corporateFormNone = document.getElementById('corporateFormNone');

        const corporateFormCheck = document.getElementById('corporateFormCheck');
        const userTypeButtons = document.querySelectorAll('.user-type-button');
        const userTypeInput = document.getElementById('user-type-input');

        individualForm.style.display = 'block';
        individualFormCheck.style.display = 'block';
        corporateForm.style.display = 'none';
        corporateFormNone.style.display = 'none';

        corporateFormCheck.style.display = 'none';

        userTypeButtons.forEach(button => {
            button.addEventListener('click', function() {
                userTypeButtons.forEach(btn => btn.classList.remove('active'));

                this.classList.add('active');
                const userType = this.getAttribute('data-user-type');
                userTypeInput.value = userType;

                // individualForm.style.display = 'none';
                // individualFormCheck.style.display = 'none';
                // corporateForm.style.display = 'none';
                // corporateFormCheck.style.display = 'none';


                if (userType === '1' || userType === '21') {
                    individualForm.style.display = 'block';
                    individualFormCheck.style.display = 'block';
                    individualFormCheck.classList.remove('hidden');
                    individualForm.classList.remove("hidden");

                    corporateForm.classList.remove('d-show');
                    corporateFormNone.classList.remove('d-show');

                    corporateFormCheck.classList.remove('d-show');
                    corporateForm.classList.add('hidden');
                    corporateFormNone.classList.add('hidden');

                    corporateFormCheck.classList.add('hidden');

                } else if (userType === '2') {
                    corporateForm.style.display = 'block';
                    corporateFormNone.style.display = 'block';

                    corporateFormCheck.style.display = 'block';
                    corporateFormCheck.classList.remove('hidden');
                    individualForm.style.display = 'none';
                    individualFormCheck.style.display = 'block';
                    corporateForm.classList.remove("hidden");
                    corporateFormNone.classList.remove("hidden");


                    individualForm.classList.remove('d-show');
                    individualFormCheck.classList.remove('d-show');
                    individualForm.classList.add('hidden');
                    individualFormCheck.classList.add('hidden');



                }
            });
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

        $(document).ready(function() {
            var cityId = "{{ old('city_id') }}";
            var countyId = "{{ old('county_id') }}";
            var taxOfficeCity = "{{ old('taxOfficeCity') }}";
            var neighborhoodId = "{{ old('neighborhood_id') }}";
            var taxOffice = "{{ old('taxOffice') }}";

            if (cityId) {
                $.ajax({
                    type: 'GET',
                    url: '/get-counties/' + cityId,
                    success: function(data) {
                        var countySelect = $('#countySelect');
                        $('#countySelect').select2({
                            placeholder: 'İlçe',
                            width: '100%',
                            searchInputPlaceholder: 'Ara...'
                        }).prop('disabled', false);
                        countySelect.empty();
                        countySelect.append('<option value="">İlçe Seçiniz</option>');
                        $.each(data.counties, function(index, county) {
                            var selectedAttribute = (county.ilce_key == countyId) ?
                                'selected' : '';

                            countySelect.append(
                                '<option value="' + county.ilce_key + '" ' +
                                selectedAttribute + '>' +
                                county.ilce_title +
                                '</option>'
                            );
                        });
                    }
                });
            }
            // Show overlay when a Select2 dropdown is opened
            $(document).on('click', '.select2-container', function() {
                if ($(this).hasClass('select2-container--open')) {
                    const searchField = $('.select2-search__field');
                    if (searchField.length) {
                        searchField.attr('placeholder', 'Ara...');
                    }

                }
            });

            if (countyId) {
                $.ajax({
                    type: 'GET',
                    url: '/get-neighborhoods/' + countyId,
                    success: function(data) {
                        var neighborhoodSelect = $('#neighborhoodSelect');
                        $('#neighborhoodSelect').select2({
                            placeholder: 'Mahalle',
                            width: '100%',
                            searchInputPlaceholder: 'Ara...'
                        }).prop('disabled', false);
                        neighborhoodSelect.empty();
                        neighborhoodSelect.append('<option value="">Mahalle Seçiniz</option>');

                        $.each(data, function(index, county) {
                            var selectedAttribute = (county.mahalle_key == neighborhoodId) ?
                                'selected' : '';
                            neighborhoodSelect.append(
                                '<option value="' + county.mahalle_key + '" ' +
                                selectedAttribute + '>' +
                                county.mahalle_title +
                                '</option>'
                            );
                        });
                    }
                });
            }


            $.ajax({
                type: 'GET',
                url: '/get-tax-office/' + taxOfficeCity,
                success: function(data) {
                    var taxOffice = $('#taxOffice');
                    taxOffice.empty();
                    $.each(data, function(index, office) {
                        var selectedAttribute = (office.id == taxOffice) ?
                            'selected' : '';
                        taxOffice.append(
                            '<option value="' + office.id + '" ' +
                            selectedAttribute + '>' +
                            office.daire +
                            '</option>'
                        );
                    });
                }
            });
        });
        $('#citySelect').select2({
            placeholder: 'İl',
            width: '100%',
            language: {
                noResults: function() {
                    return 'Arama sonuç bulunamadı';
                }
            }
        });
        $('#taxOfficeCity').select2({
            placeholder: 'Vergi Dairesi İli',
            width: '100%',
            language: {
                noResults: function() {
                    return 'Arama sonuç bulunamadı';
                }
            }
        });
        $('#taxOffice').select2({
            placeholder: 'Vergi Dairesi',
            width: '100%',
            language: {
                noResults: function() {
                    return 'Arama sonuç bulunamadı';
                }
            }
        }).prop('disabled', true);
        $('#countySelect').select2({
            minimumResultsForSearch: -1,
            width: '100%',
            language: {
                noResults: function() {
                    return 'Arama sonuç bulunamadı';
                }
            }
        }).prop('disabled', true);

        $('#neighborhoodSelect').select2({
            minimumResultsForSearch: -1,
            width: '100%',
            language: {
                noResults: function() {
                    return 'Arama sonuç bulunamadı';
                }
            }
        }).prop('disabled', true);
        $('#citySelect').change(function() {
            var selectedCity = $(this).val();

            $.ajax({
                type: 'GET',
                url: '/get-counties/' + selectedCity,
                success: function(data) {
                    var countySelect = $('#countySelect');
                    $('#countySelect').select2({
                        placeholder: 'İlçe',
                        width: '100%',
                        searchInputPlaceholder: 'Ara...'
                    }).prop('disabled', false);
                    countySelect.empty();
                    countySelect.append('<option value="">İlçe Seçiniz</option>');
                    $.each(data.counties, function(index, county) {
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
                    neighborhoodSelect.append('<option value="">Mahalle Seçiniz</option>');
                    $('#neighborhoodSelect').select2({
                        placeholder: 'Mahalle',
                        width: '100%',
                        searchInputPlaceholder: 'Ara...'
                    }).prop('disabled', false);
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
            $.ajax({
                type: 'GET',
                url: '/get-tax-office/' + selectedCity,
                success: function(data) {
                    var taxOffice = $('#taxOffice');
                    taxOffice.empty();
                    $('#taxOffice').select2({
                        placeholder: 'Vergi Dairesi',
                        width: '100%',
                        language: {
                            noResults: function() {
                                return 'Arama sonuç bulunamadı';
                            }
                        }
                    }).prop('disabled', false);
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
                dots: false,
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
        'use strict';
        $('#corporate-account-type').on('change', function() {
            let value = $(this).val();
            let data = {
                "Emlak Ofisi": "tab-emlakci",
                "Banka": "tab-banka",
                "İnşaat Ofisi": "tab-insaat",
            };

            $('.sub-plan-tab').addClass('d-none');
            $(`.sub-plan-tab.${data[value]}`).removeClass('d-none');
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection

@section('styles')
    <style>
        .form-check-inline .form-check-input[type="checkbox"] {
            transform: scale(0.7);
            /* Boyutu %50 oranında küçültür */
        }

        .inner-pages .checkboxes label:before {
            content: "";
            display: inline-block;
            width: 19px;
            height: 19px;
            margin-right: 10px;
            position: absolute;
            left: 0;
            top: -3px;
            background-color: #fff;
            border: 2px solid #d0d0d0;
            border-radius: 2px;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-transition: border-color 0.3s;
            transition: border-color 0.3s;
        }

        .filter-tags-wrap {
            margin-bottom: 8px;
        }

        .support-phone {
            font-size: 14px;
            color: hsl(0, 0%, 7%);
            margin-bottom: 10px;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .support-phone a {
            text-decoration: none;
            color: #2f5f9e;
            /* Link rengi */
        }

        .support-phone a:hover {
            text-decoration: underline;
        }

        #passwordInput {
            position: relative;

        }

        #passwordInput2 {
            position: relative;

        }

        .field-icon {
            float: right;
            margin-right: 12px;
            margin-top: -24px;
            font-size: 14px;
            position: relative;
            z-index: 2;
            z-index: 9999;
        }

        .hidden {
            display: none !important;
        }

        .d-show {
            display: block !important;
        }

        .error-border {
            border-color: #EC2F2E !important;
        }

        .error-message {
            color: #e54242;
            font-size: 11px;
        }

        .success-message {
            color: green;
            font-size: 11px;
        }
    </style>
@endsection
