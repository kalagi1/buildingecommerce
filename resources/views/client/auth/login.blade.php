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
                                <a class="nav-link active" id="normal-tab" data-toggle="tab" href="#normal" role="tab"
                                    aria-controls="normal" aria-selected="true">
                                    <h3 class="text-center font-weight-bold">Giriş Yap</h3>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="corporate-tab" data-toggle="tab" href="#corporate" role="tab"
                                    aria-controls="corporate" aria-selected="false">
                                    <h3 class="text-center font-weight-bold">Kayıt Ol</h3>
                                </a>
                            </li>
                        </ul>

                        <div class="login-content">
                            <!-- Sekme İçeriği -->
                            <div class="tab-content" id="myTabContent">
                                <!-- Normal Hesap Girişi Sekmesi -->
                                <div class="tab-pane fade show active" id="normal" role="tabpanel"
                                    aria-labelledby="normal-tab">
                                    @if (session()->has('success'))
                                        <div class="alert alert-success">
                                            {{ session()->get('success') }}
                                        </div>
                                    @elseif (session()->has('error'))
                                        <div class="alert alert-danger">
                                            {{ session()->get('error') }}
                                        </div>
                                    @endif

                                    <form method="POST"class="form w-100" action="{{ route('client.submit.login') }}">

                                        @csrf
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="mt-3">
                                            <label class="q-label">E-Posta</label>
                                            <input type="email" name="email" class="form-control">
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

                                                <div class="social-login-icon" style="background-color: black;">
                                                    <i class="fa fa-apple"></i>
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
                                                        <a href="{{ route('auth.google') }}"
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
                                <div class="tab-pane fade" id="corporate" role="tabpanel" aria-labelledby="corporate-tab">
                                    <form method="POST" class="form w-100" action="{{ route('client.submit.register') }}">
                                        @csrf
                                        <div class="user-type-selection">
                                            <label class="q-label">Kullanıcı Türü</label>
                                            <div class="button-group">
                                                <button class="user-type-button individual active" data-user-type="1"
                                                    type="button">Bireysel</button>
                                                <button class="user-type-button institutional" data-user-type="2"
                                                    type="button">Kurumsal</button>
                                            </div>
                                            <input type="hidden" name="type" id="user-type-input" value="1">
                                        </div>

                                        <!-- E-Posta -->
                                        <div class="mt-3 ">
                                                <label class="q-label">İsim</label>
                                                <input type="text" name="name" class="form-control">
                                            </div>

                                            <!-- E-Posta -->
                                            <div class="mt-3">
                                                <label class="q-label">E-Posta</label>
                                                <input type="email" name="email" class="form-control">
                                            </div>


                                            <!-- Şifre -->
                                            <div class="mt-3">
                                                <label class="q-label">Şifre</label>
                                                <input type="password" name="password" class="form-control">
                                        </div>

                                        <div class="individual-form" id="individualForm">


                                            <div class="mt-3">
                                                <label for="" class="q-label">Abonelik Planı</label>
                                                <div class="owl-carousel">
                                                    @foreach ($subscriptionPlans_bireysel as $plan)
                                                        <div class="item">
                                                            <div class="card mb-4">
                                                                <div class="card-body">
                                                                    <label for=""
                                                                        class="q-label">{{ $plan->name }}</label>

                                                                    <label for="" class="q-label">Fiyat:
                                                                        <span style="color:#446BB6">{{ $plan->price }}
                                                                            TL</span></label>

                                                                    <label for="" class="q-label">Konut Ekleme
                                                                        Limiti:
                                                                        <span
                                                                            style="color:#446BB6">{{ $plan->housing_limit }}
                                                                        </span></label>

                                                                </div>
                                                                <div class="card-footer">
                                                                    <button type="button"
                                                                        class="btn btn-primary btn-block plan-button"
                                                                        data-plan-id="{{ $plan->id }}"
                                                                        data-plan-name="{{ $plan->name }}"
                                                                        data-plan-price="{{ $plan->price }}"
                                                                        onclick="selectPlan(this)">
                                                                        Seç
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            {{--
                                            <div class="form-group custom-control custom-checkbox mt-3">
                                                <input type="checkbox" name="check" class="custom-control-input" id="exampleCheck3"
                                                    required>
                                                <label class="custom-control-label" for="exampleCheck3">Kişisel
                                                    verilerimin
                                                    işlenmesine yönelik aydınlatma metnini okudum anladım.</label>
                                            </div> --}}
                                        </div>


                                        <div class="corporate-form" id="corporateForm">
                                            <!-- E-Posta -->
                                            <div class="mt-3">
                                                <label for="corporate-account-type" class="q-label">Kurumsal Hesap
                                                    Türü</label>
                                                <select name="corporate-account-type" id="corporate-account-type"
                                                    class="form-control">
                                                    <option value="" disabled selected>Seçiniz</option>
                                                    <option value="Emlakçı">Emlakçı</option>
                                                    <option value="Banka">Banka</option>
                                                    <option value="İnşaat">İnşaat</option>
                                                </select>
                                            </div>
                                            <div class="mt-3 sub-plan-tab tab-emlakci d-none">
                                                <label for="" class="q-label">Abonelik Planı</label>
                                                <div class="owl-carousel">
                                                    @foreach ($subscriptionPlans_emlakci as $plan)
                                                        <div class="item">
                                                            <div class="card mb-4">
                                                                <div class="card-body">
                                                                    <label for=""
                                                                        class="q-label">{{ $plan->name }}</label>

                                                                    <label for="" class="q-label">Fiyat:
                                                                        <span style="color:#446BB6">{{ $plan->price }}
                                                                            TL</span></label>

                                                                    <label for="" class="q-label">Proje Ekleme
                                                                        Limiti:
                                                                        <span
                                                                            style="color:#446BB6">{{ $plan->project_limit }}
                                                                        </span></label>

                                                                    <label for="" class="q-label">Kullanıcı
                                                                        Limiti:
                                                                        <span
                                                                            style="color:#446BB6">{{ $plan->user_limit }}</span></label>

                                                                    <label for="" class="q-label">Konut Ekleme
                                                                        Limiti:
                                                                        <span
                                                                            style="color:#446BB6">{{ $plan->housing_limit }}
                                                                        </span></label>

                                                                </div>
                                                                <div class="card-footer">
                                                                    <button type="button"
                                                                        class="btn btn-primary btn-block plan-button"
                                                                        data-plan-id="{{ $plan->id }}"
                                                                        data-plan-name="{{ $plan->name }}"
                                                                        data-plan-price="{{ $plan->price }}"
                                                                        onclick="selectPlan(this)">
                                                                        Seç
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="mt-3 sub-plan-tab tab-banka d-none">
                                                <label for="" class="q-label">Abonelik Planı</label>
                                                <div class="owl-carousel">
                                                    @foreach ($subscriptionPlans_banka as $plan)
                                                        <div class="item">
                                                            <div class="card mb-4">
                                                                <div class="card-body">
                                                                    <label for=""
                                                                        class="q-label">{{ $plan->name }}</label>

                                                                    <label for="" class="q-label">Fiyat:
                                                                        <span style="color:#446BB6">{{ $plan->price }}
                                                                            TL</span></label>

                                                                    <label for="" class="q-label">Proje Ekleme
                                                                        Limiti:
                                                                        <span
                                                                            style="color:#446BB6">{{ $plan->project_limit }}
                                                                        </span></label>

                                                                    <label for="" class="q-label">Kullanıcı
                                                                        Limiti:
                                                                        <span
                                                                            style="color:#446BB6">{{ $plan->user_limit }}</span></label>

                                                                    <label for="" class="q-label">Konut Ekleme
                                                                        Limiti:
                                                                        <span
                                                                            style="color:#446BB6">{{ $plan->housing_limit }}
                                                                        </span></label>

                                                                </div>
                                                                <div class="card-footer">
                                                                    <button type="button"
                                                                        class="btn btn-primary btn-block plan-button"
                                                                        data-plan-id="{{ $plan->id }}"
                                                                        data-plan-name="{{ $plan->name }}"
                                                                        data-plan-price="{{ $plan->price }}"
                                                                        onclick="selectPlan(this)">
                                                                        Seç
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="mt-3 sub-plan-tab tab-insaat d-none">
                                                <label for="" class="q-label">Abonelik Planı</label>
                                                <div class="owl-carousel">
                                                    @foreach ($subscriptionPlans_insaat as $plan)
                                                        <div class="item">
                                                            <div class="card mb-4">
                                                                <div class="card-body">
                                                                    <label for=""
                                                                        class="q-label">{{ $plan->name }}</label>

                                                                    <label for="" class="q-label">Fiyat:
                                                                        <span style="color:#446BB6">{{ $plan->price }}
                                                                            TL</span></label>

                                                                    <label for="" class="q-label">Proje Ekleme
                                                                        Limiti:
                                                                        <span
                                                                            style="color:#446BB6">{{ $plan->project_limit }}
                                                                        </span></label>

                                                                    <label for="" class="q-label">Kullanıcı
                                                                        Limiti:
                                                                        <span
                                                                            style="color:#446BB6">{{ $plan->user_limit }}</span></label>

                                                                    <label for="" class="q-label">Konut Ekleme
                                                                        Limiti:
                                                                        <span
                                                                            style="color:#446BB6">{{ $plan->housing_limit }}
                                                                        </span></label>

                                                                </div>
                                                                <div class="card-footer">
                                                                    <button type="button"
                                                                        class="btn btn-primary btn-block plan-button"
                                                                        data-plan-id="{{ $plan->id }}"
                                                                        data-plan-name="{{ $plan->name }}"
                                                                        data-plan-price="{{ $plan->price }}"
                                                                        onclick="selectPlan(this)">
                                                                        Seç
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="mt-3">
                                                <label for="" class="q-label">Faaliyet Alanınız</label>
                                                <select class="form-control" name="activity">
                                                    <option value="">Seçiniz</option>
                                                    <option for="Alışveriş" value="200003" data-title="Alışveriş">
                                                        Alışveriş</option>
                                                    <option for="Emlak" value="200002" data-title="Emlak">
                                                        Emlak</option>
                                                    <option for="Günlük Kiralık " value="200020"
                                                        data-title="Günlük Kiralık ">
                                                        Günlük Kiralık </option>
                                                    <option for="Hayvanlar Alemi" value="200004"
                                                        data-title="Hayvanlar Alemi">
                                                        Hayvanlar Alemi</option>
                                                    <option for="İş Makinesi &amp; Sanayi" value="200013"
                                                        data-title="İş Makinesi &amp; Sanayi">
                                                        İş Makinesi &amp; Sanayi</option>
                                                    <option for="Kiralık Araç" value="200010" data-title="Kiralık Araç">
                                                        Kiralık Araç</option>
                                                    <option for="Kiralık Deniz Araçları" value="200021"
                                                        data-title="Kiralık Deniz Araçları">
                                                        Kiralık Deniz Araçları</option>
                                                    <option for="Motosiklet" value="200012" data-title="Motosiklet">
                                                        Motosiklet</option>
                                                    <option for="Vasıta" value="200011" data-title="Vasıta">
                                                        Vasıta</option>
                                                    <option for="Yedek Parça, Aksesuar, Donanım &amp; Tuning"
                                                        value="200009"
                                                        data-title="Yedek Parça, Aksesuar, Donanım &amp; Tuning">
                                                        Yedek Parça, Aksesuar, Donanım &amp; Tuning</option>
                                                </select>
                                            </div>

                                            <div class="mt-3">
                                                <label for="" class="q-label">İl</label>
                                                <select class="form-control" id="citySelect" name="city_id">
                                                    <option value="">Seçiniz</option>
                                                    @foreach ($towns as $item)
                                                        <option for="{{ $item->sehir_title }}"
                                                            value="{{ $item->sehir_key }}"
                                                            data-title="{{ $item->sehir_title }}">
                                                            {{ $item->sehir_title }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="mt-3">
                                                <label for="" class="q-label">İlçe</label>
                                                <select class="form-control" name="county_id" id="countySelect">
                                                    <option value="">Seçiniz</option>
                                                </select>
                                            </div>
                                            <div class="mt-3">
                                                <label for="" class="q-label">Mahalle</label>
                                                <select class="form-control" name="neighborhood_id"
                                                    id="neighborhoodSelect">
                                                    <option value="">Seçiniz</option>
                                                </select>
                                            </div>

                                            <div class="mt-3">
                                                <label for="" class="q-label">İşletme Türü</label>
                                                <div class="companyType">
                                                    <label for="of"><input type="radio" class="input-radio off"
                                                            id="of" name="account_type" value="1" checked>
                                                        Şahıs
                                                        Şirketi</label>
                                                    <label for="on"><input type="radio" class="input-radio off"
                                                            id="on" name="account_type" value="2"> Limited
                                                        veya
                                                        Anonim Şirketi</label>
                                                </div>
                                            </div>

                                            <div class="split-form corporate-input mt-3">
                                                <div class="corporate-input input-city">
                                                    <div class="mbdef">
                                                        <div class="select select-tax-office">
                                                            <label for="" class="q-label">Vergi Dairesi
                                                                İli</label>

                                                            <select id="taxOfficeCity" class="form-control"
                                                                name="taxOfficeCity">
                                                                <option value="">Seçiniz</option>
                                                                @foreach ($cities as $item)
                                                                    <option for="{{ $item->title }}"
                                                                        value="{{ $item->title }}"
                                                                        data-title="{{ $item->title }}">
                                                                        {{ $item->title }}</option>
                                                                @endforeach
                                                            </select>
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

                                                            <select id="taxOffice" class="form-control" name="taxOffice">
                                                                <option value="">Seçiniz</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="split-form corporate-input mt-3">
                                                <div class="corporate-input input-city">
                                                    <div class="mbdef">
                                                        <div class="select select-tax-office">
                                                            <label for="" class="q-label">Vergi No
                                                            </label>
                                                            <input type="text" id="taxNumber" name="taxNumber"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="split-form corporate-input mt-3" id="idNumberDiv">
                                                <div class="corporate-input input-city">
                                                    <div class="mbdef">
                                                        <div class="select select-tax-office">
                                                            <label for="" class="q-label">TC Kimlik No
                                                            </label>
                                                            <input type="text" id="idNumber" name="idNumber"
                                                                class="form-control">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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

                if (userType === '1') {
                    individualForm.style.display = 'block';
                } else if (userType === '2') {
                    corporateForm.style.display = 'block';
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
