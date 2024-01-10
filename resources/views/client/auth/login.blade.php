@extends('client.layouts.master')

@section('content')
    <section class="loginItems">
        <div class="container"> <!-- Genişlik container-fluid ile değiştirildi -->
            <div class="row">
                <div class="col-md-7 mx-auto">
                    <div class="login-container">
                        <!-- Sekme Seçenekleri -->
                        <ul class="nav nav-tabs login-tabs" id="myTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link @if ($errors->has('login_error') || !$errors->any()) active show @else hide @endif "
                                    id="normal-tab" data-toggle="tab" href="#normal" role="tab" aria-controls="normal"
                                    aria-selected="true">
                                    <h3 class="text-center ">Giriş Yap</h3>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link @if ($errors->any() && !$errors->has('login_error')) active show @endif" id="corporate-tab"
                                    data-toggle="tab" href="#corporate" role="tab" aria-controls="corporate"
                                    aria-selected="false">
                                    <h3 class="text-center ">Kayıt Ol</h3>
                                </a>
                            </li>
                        </ul>

                        <div class="login-content">
                            <!-- Sekme İçeriği -->
                            <div class="tab-content" id="myTabContent">
                                <!-- Normal Hesap Girişi Sekmesi -->
                                <div class="tab-pane fade @if ($errors->has('login_error') || !$errors->any()) active show @else hide @endif "
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

                                    <form method="POST"class="form w-100" action="{{ route('client.submit.login') }}">
                                        @csrf

                                        @if ($errors->has('login_error'))
                                            <div class="alert alert-danger text-white">
                                                {{ $errors->first('login_error') }}
                                            </div>
                                        @endif


                                        <!-- E-Posta -->
                                        <div class="mt-3">
                                            <label class="q-label">E-Posta</label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ old('email') }}">

                                        </div>


                                        <div class="mt-3">
                                            <label class="q-label">Şifre</label>
                                            <input type="password" name="password" class="form-control">

                                        </div>

                                        <div class="forgot-password d-flex justify-content-between">
                                            <a href="{{ route('institutional.login') }}"><span>Kurumsal Giriş</span></a>
                                            <a href="{{ route('password.request') }}"><span>Şifremi Unuttum</span></a>
                                        </div>

                                        <button class="btn btn-primary q-button" type="submit"> Giriş Yap</button>

                                        <div class="social-account-login-buttons pb-3">
                                            <div class="q-layout social-login-button flex flex-1">

                                                <div class="social-login-icon" style="background-color: #007bff;">
                                                    <i class="fa fa-facebook"></i>
                                                </div>
                                                <div class="flex flex-column">
                                                    <div>
                                                        <a href="{{ route('auth.facebook') }}"
                                                            style="color: black;text-decoration:none">
                                                            <div style="text-transform: capitalize;">facebook</div>
                                                            <small>ile giriş yap</small>
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="q-layout social-login-button flex flex-1">
                                                <div class="social-login-icon" style="background-color: rgb(241, 66, 54);">
                                                    <i class="fa fa-google"></i>
                                                </div>
                                                <div class="flex flex-column">
                                                    <div>
                                                        <a href="{{ route('client.google.login') }}"
                                                            style="color: black;text-decoration:none">
                                                            <div style="text-transform: capitalize;">google</div> <small>ile
                                                                giriş yap</small>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                    </form>

                                </div>

                                <!-- Kurumsal Hesap Girişi Sekmesi -->
                                <div class="tab-pane fade @if ($errors->any() && !$errors->has('login_error')) active show @endif"
                                    id="corporate" role="tabpanel" aria-labelledby="corporate-tab">


                                    <form method="POST" class="form w-100" action="{{ route('client.submit.register') }}">
                                        @csrf
                                        <div class="user-type-selection">
                                            <label class="q-label">Kullanıcı Türü</label>
                                            <div class="button-group">
                                                <button
                                                    class="user-type-button individual {{ old('type') == 1 ? 'active' : '' }}"
                                                    data-user-type="1" type="button">Bireysel</button>
                                                <button
                                                    class="user-type-button institutional {{ old('type') == 2 ? 'active' : '' }}"
                                                    data-user-type="2" type="button">Kurumsal</button>
                                                {{-- <button
                                                    class="user-type-button sharer {{ old('type') == 21 ? 'active' : '' }}"
                                                    data-user-type="21" type="button"
                                                    style="color:#e54242">Emlak Sepette İle Para Kazan </button> --}}
                                            </div>
                                            <input type="hidden" name="type" id="user-type-input"
                                                value="{{ old('type', 1) }}">
                                        </div>


                                        <div class="individual-form {{ old('type') == 1 || old('type') == 21 ? 'd-show' : '' }} {{ old('type') == 2 ? 'hidden' : '' }} "
                                            id="individualForm">

                                            <!-- İsim -->
                                            <div class="mt-3">
                                                <label class="q-label">İsim</label>
                                                <input type="text" name="name1"
                                                    class="form-control {{ $errors->has('name1') ? 'error-border' : '' }}"
                                                    value="{{ old('name1') }}">
                                                @if ($errors->has('name1'))
                                                    <span class="error-message">{{ $errors->first('name1') }}</span>
                                                @endif
                                            </div>
                                        </div>


                                        <!-- E-Posta -->
                                        <div class="mt-3">
                                            <label class="q-label">E-Posta</label>
                                            <input type="email" name="email"
                                                class="form-control {{ $errors->has('email') ? 'error-border' : '' }}"
                                                value="{{ old('email') }}">
                                            @if ($errors->has('email'))
                                                <span class="error-message">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>

                                        <div class="mt-3">
                                            <label class="q-label">Şifre</label>
                                            <input type="password" name="password"
                                                class="form-control {{ $errors->has('password') ? 'error-border' : '' }}">
                                            @if ($errors->has('password'))
                                                <span class="error-message">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>

                                        <div class="corporate-form {{ old('type') == 2 ? 'd-show' : '' }} "
                                            id="corporateForm">
                                            <!-- E-Posta -->
                                            <div class="mt-3">
                                                <label class="q-label">Yetkili İsim Soyisim</label>
                                                <input type="text" name="username"
                                                    class="form-control {{ $errors->has('username') ? 'error-border' : '' }}"
                                                    value="{{ old('username') }}">
                                                @if ($errors->has('username'))
                                                    <span class="error-message">{{ $errors->first('username') }}</span>
                                                @endif
                                            </div>

                                            <!-- Firma Adı -->
                                            <div class="mt-3">
                                                <label class="q-label">Firma Adı</label>
                                                <input type="text" name="name"
                                                    class="form-control {{ $errors->has('name') ? 'error-border' : '' }}"
                                                    value="{{ old('name') }}">
                                                @if ($errors->has('name'))
                                                    <span class="error-message">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>

                                            <!-- Sabit Telefon -->
                                            <div class="mt-3">
                                                <label class="q-label">Sabit Telefon</label>
                                                <input type="number" name="phone"
                                                    class="form-control {{ $errors->has('phone') ? 'error-border' : '' }}"
                                                    value="{{ old('phone') }}">
                                                @if ($errors->has('phone'))
                                                    <span class="error-message">{{ $errors->first('phone') }}</span>
                                                @endif
                                            </div>

                                            <!-- Kurumsal Hesap Türü -->
                                            <div class="mt-3">
                                                <label for="corporate-account-type" class="q-label">Kurumsal Hesap
                                                    Türü</label>
                                                <select name="corporate-account-type" id="corporate-account-type"
                                                    class="form-control {{ $errors->has('corporate-account-type') ? 'error-border' : '' }}">
                                                    <option value="" disabled selected>Seçiniz</option>
                                                    <option value="Emlakçı"
                                                        {{ old('corporate-account-type') == 'Emlakçı' ? 'selected' : '' }}>
                                                        Emlakçı</option>
                                                    <option value="Banka"
                                                        {{ old('corporate-account-type') == 'Banka' ? 'selected' : '' }}>
                                                        Banka</option>
                                                    <option value="İnşaat"
                                                        {{ old('corporate-account-type') == 'İnşaat' ? 'selected' : '' }}>
                                                        İnşaat</option>
                                                    <option value="Turizm"
                                                        {{ old('corporate-account-type') == 'Turizm' ? 'selected' : '' }}>
                                                        Turizm</option>
                                                </select>
                                                @if ($errors->has('corporate-account-type'))
                                                    <span
                                                        class="error-message">{{ $errors->first('corporate-account-type') }}</span>
                                                @endif
                                            </div>

                                            <!-- Faaliyet Alanı -->
                                            <div class="mt-3">
                                                <label for="" class="q-label">Faaliyet Alanınız</label>
                                                <select
                                                    class="form-control {{ $errors->has('activity') ? 'error-border' : '' }}"
                                                    name="activity">
                                                    <option value="">Seçiniz</option>
                                                    <option value="İnşaat"
                                                        {{ old('activity') == 'İnşaat' ? 'selected' : '' }}>İnşaat</option>
                                                    <option value="Gayrimenkul"
                                                        {{ old('activity') == 'Gayrimenkul' ? 'selected' : '' }}>
                                                        Gayrimenkul</option>
                                                    <option value="Turizm"
                                                        {{ old('activity') == 'Turizm' ? 'selected' : '' }}>Turizm</option>
                                                    <option value="Banka"
                                                        {{ old('activity') == 'Banka' ? 'selected' : '' }}>Banka</option>
                                                </select>
                                                @if ($errors->has('activity'))
                                                    <span class="error-message">{{ $errors->first('activity') }}</span>
                                                @endif
                                            </div>

                                            <!-- İl -->
                                            <div class="mt-3">
                                                <label for="" class="q-label">İl</label>
                                                <select
                                                    class="form-control {{ $errors->has('city_id') ? 'error-border' : '' }}"
                                                    id="citySelect" name="city_id">
                                                    <option value="">Seçiniz</option>
                                                    @foreach ($towns as $item)
                                                        <option for="{{ $item->sehir_title }}"
                                                            value="{{ $item->sehir_key }}"
                                                            {{ old('city_id') == $item->sehir_key ? 'selected' : '' }}>
                                                            {{ $item->sehir_title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('city_id'))
                                                    <span class="error-message">{{ $errors->first('city_id') }}</span>
                                                @endif
                                            </div>
                                            <div class="mt-3">
                                                <label for="" class="q-label">İlçe</label>
                                                <select
                                                    class="form-control {{ $errors->has('county_id') ? 'error-border' : '' }}"
                                                    name="county_id" id="countySelect">
                                                    <option value="">Seçiniz</option>
                                                </select>
                                                @if ($errors->has('county_id'))
                                                    <span class="error-message">{{ $errors->first('county_id') }}</span>
                                                @endif
                                            </div>
                                            <div class="mt-3">
                                                <label for="" class="q-label">Mahalle</label>
                                                <select
                                                    class="form-control {{ $errors->has('neighborhood_id') ? 'error-border' : '' }}"
                                                    name="neighborhood_id" id="neighborhoodSelect">
                                                    <option value="">Seçiniz</option>
                                                </select>
                                                @if ($errors->has('neighborhood_id'))
                                                    <span
                                                        class="error-message">{{ $errors->first('neighborhood_id') }}</span>
                                                @endif
                                            </div>

                                            <!-- İşletme Türü -->
                                            <div class="mt-3">
                                                <label for="" class="q-label">İşletme Türü</label>
                                                <div class="companyType">
                                                    <label for="of"><input type="radio" class="input-radio off"
                                                            id="of" name="account_type" value="1"
                                                            {{ old('account_type') == 1 ? 'checked' : '' }}> Şahıs
                                                        Şirketi</label>
                                                    <label for="on"><input type="radio" class="input-radio off"
                                                            id="on" name="account_type" value="2"
                                                            {{ old('account_type') == 2 ? 'checked' : '' }}> Limited veya
                                                        Anonim Şirketi</label>
                                                </div>
                                            </div>
                                            <!-- Vergi Dairesi İli -->
                                            <div class="split-form corporate-input mt-3">
                                                <div class="corporate-input input-city">
                                                    <div class="mbdef">
                                                        <div class="select select-tax-office">
                                                            <label for="" class="q-label">Vergi Dairesi
                                                                İli</label>
                                                            <select id="taxOfficeCity"
                                                                class="form-control {{ $errors->has('taxOfficeCity') ? 'error-border' : '' }}"
                                                                name="taxOfficeCity">
                                                                <option value="">Seçiniz</option>
                                                                @foreach ($cities as $item)
                                                                    <option for="{{ $item->title }}"
                                                                        value="{{ $item->title }}"
                                                                        {{ old('taxOfficeCity') == $item->title ? 'selected' : '' }}>
                                                                        {{ $item->title }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->has('taxOfficeCity'))
                                                                <span
                                                                    class="error-message">{{ $errors->first('taxOfficeCity') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="split-form corporate-input mt-3">
                                                <div class="corporate-input input-city">
                                                    <div class="mbdef">
                                                        <div class="select select-tax-office">
                                                            <label for="" class="q-label">Vergi Dairesi
                                                            </label>

                                                            <select id="taxOffice"
                                                                class="form-control {{ $errors->has('taxOffice') ? 'error-border' : '' }}"
                                                                name="taxOffice">
                                                                <option value="">Seçiniz</option>
                                                            </select>
                                                            @if ($errors->has('taxOffice'))
                                                                <span
                                                                    class="error-message">{{ $errors->first('taxOffice') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Vergi No -->
                                            <div class="split-form corporate-input mt-3">
                                                <div class="corporate-input input-city">
                                                    <div class="mbdef">
                                                        <div class="select select-tax-office">
                                                            <label for="" class="q-label">Vergi No</label>
                                                            <input type="text" id="taxNumber" name="taxNumber"
                                                                class="form-control {{ $errors->has('taxNumber') ? 'error-border' : '' }}"
                                                                value="{{ old('taxNumber') }}">
                                                            @if ($errors->has('taxNumber'))
                                                                <span
                                                                    class="error-message">{{ $errors->first('taxNumber') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- TC Kimlik No -->
                                            <div class="split-form corporate-input mt-3 {{ old('account_type') == 2 ? 'd-none' : '' }}"
                                                id="idNumberDiv">
                                                <div class="corporate-input input-city">
                                                    <div class="mbdef">
                                                        <div class="select select-tax-office">
                                                            <label for="" class="q-label">TC Kimlik No</label>
                                                            <input type="text" id="idNumber" name="idNumber"
                                                                class="form-control" value="{{ old('idNumber') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                        </div>

                                        <input type="hidden" id="selected-plan-id" name="subscription_plan_id">

                                        <button class="btn btn-primary q-button mb-5" type="submit"> Üye OL</button>
                                    </form>
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        const individualForm = document.getElementById('individualForm');
        const corporateForm = document.getElementById('corporateForm');
        const userTypeButtons = document.querySelectorAll('.user-type-button');
        const userTypeInput = document.getElementById('user-type-input');

        individualForm.style.display = 'block';
        corporateForm.style.display = 'none';

        userTypeButtons.forEach(button => {
            button.addEventListener('click', function() {
                userTypeButtons.forEach(btn => btn.classList.remove('active'));

                this.classList.add('active');
                const userType = this.getAttribute('data-user-type');
                userTypeInput.value = userType;

                individualForm.style.display = 'none';
                corporateForm.style.display = 'none';

                if (userType === '1' || userType === '21') {
                    individualForm.style.display = 'block';
                    corporateForm.classList.remove('d-show');
                } else if (userType === '2') {
                    corporateForm.style.display = 'block';
                    individualForm.classList.remove('hide');

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

        $('#citySelect').change(function() {
            var selectedCity = $(this).val();

            $.ajax({
                type: 'GET',
                url: '/get-counties/' + selectedCity,
                success: function(data) {
                    var countySelect = $('#countySelect');
                    countySelect.empty();
                    countySelect.append('<option value="">İlçe Seçiniz</option>');
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
                    neighborhoodSelect.append('<option value="">Mahalle Seçiniz</option>');

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
                "Emlakçı": "tab-emlakci",
                "Banka": "tab-banka",
                "İnşaat": "tab-insaat",
            };

            $('.sub-plan-tab').addClass('d-none');
            $(`.sub-plan-tab.${data[value]}`).removeClass('d-none');
        });
    </script>
@endsection

@section('styles')
    <style>
        .hidden {
            display: none !important;
        }

        .d-show {
            display: block !important;
        }

        .error-border {
            border: 1px solid #EA2B2E !important;
        }

        .error-message {
            color: red;
            font-size: 12px;
        }
    </style>
@endsection
