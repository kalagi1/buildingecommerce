@extends('client.layouts.master')

@section('content')
    <section class="loginItems">
        <div class="container">
            <div class="row">
                <div class="col-md-7 mx-auto">
                    <div class="login-container">
                        <ul class="nav nav-tabs login-tabs" id="myTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link @if ($errors->has('login_error') || (!$errors->any() && !isset($_GET['uye-ol']))) active show @else hide @endif "
                                    id="normal-tab" data-toggle="tab" href="#normal" role="tab" aria-controls="normal"
                                    aria-selected="true">
                                    <h3 class="text-center ">Giriş Yap</h3>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link @if (($errors->any() && !$errors->has('login_error')) || isset($_GET['uye-ol'])) active show @endif" id="corporate-tab"
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

                                    <form method="POST"class="form w-100" action="{{ route('client.submit.login') }}">
                                        @csrf

                                        <input type="hidden" name="backurl" value="{{ request('backurl') }}">
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

                                            <input type="password" name="password" id="passwordInput" class="form-control">
                                            <i id="eyeIcon" class="fa fa-eye-slash field-icon"
                                                onclick="togglePassword()"></i>

                                        </div>
                                        <script src="https://kit.fontawesome.com/your-fontawesome-kit-id.js"></script>
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




                                        <div class="forgot-password d-flex justify-content-between">
                                            <a href="{{ route('institutional.login') }}"><span>Kurumsal Giriş</span></a>
                                            <a href="{{ route('password.request') }}"><span>Şifremi Unuttum</span></a>
                                        </div>

                                        <button class="btn btn-primary q-button" type="submit">Giriş Yap</button>

                                        <div class="social-account-login-buttons pb-3">
                                            <div class="q-layout social-login-button flex flex-1">

                                                <div class="social-login-icon" style="background-color: #007bff;">
                                                    <i class="fa fa-facebook"></i>
                                                </div>
                                                <div class="flex flex-column">
                                                    <div>
                                                        <a href="{{ route('login.facebook') }}"
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
                                <div class="tab-pane fade @if (($errors->any() && !$errors->has('login_error')) || isset($_GET['uye-ol'])) active show @endif"
                                    id="corporate" role="tabpanel" aria-labelledby="corporate-tab">


                                    <form method="POST" class="form w-100" action="{{ route('client.submit.register') }}">
                                        @csrf
                                        <div class="user-type-selection">
                                            <label class="q-label">Kullanıcı Türü</label>
                                            <div class="button-group" style="height: 40px">
                                                <button
                                                    class="user-type-button individual {{ old('type') == 1 ? 'active' : '' }}"
                                                    data-user-type="1" type="button">Bireysel</button>
                                                <button
                                                    class="user-type-button institutional {{ old('type') == 2 ? 'active' : '' }}"
                                                    data-user-type="2" type="button">Kurumsal</button>

                                            </div>
                                            <input type="hidden" name="type" id="user-type-input"
                                                value="{{ old('type', 1) }}">
                                        </div>
                                        <div class="corporate-form {{ old('type') == 2 ? 'd-show' : '' }} "
                                        id="corporateFormNone">
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
                                        </div>

                                        <div class="individual-form {{ old('type') == 1 ? 'd-show' : '' }} {{ old('type') == 2 ? 'hidden' : '' }} "
                                            id="individualForm">

                                            <!-- İsim -->
                                            <div class="mt-3">
                                                <label class="q-label">İsim Soyisim</label>
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
                                            <label class="q-label">Cep Telefonu</label>
                                            <input type="number" name="mobile_phone" id="mobile_phone"
                                                class="form-control {{ $errors->has('mobile_phone') ? 'error-border' : '' }}"
                                                value="{{ old('mobile_phone') }}" maxlength="10">
                                            <span id="error_message" class="error-message"></span>
                                            @if ($errors->has('mobile_phone'))
                                                <span class="error-message">{{ $errors->first('mobile_phone') }}</span>
                                            @endif
                                        </div>




                                        <div class="mt-3">
                                            <label class="q-label">Şifre</label>
                                            <input type="password" name="password" id="passwordInput2"
                                                class="form-control {{ $errors->has('password') ? 'error-border' : '' }}">
                                            <i id="eyeIcon2" class="fa fa-eye-slash field-icon"
                                                onclick="togglePassword2()"></i>
                                            @if ($errors->has('password'))
                                                <span class="error-message">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>

                                        <script src="https://kit.fontawesome.com/your-fontawesome-kit-id.js"></script>
                                        <script>
                                            function togglePassword2() {
                                                var passwordInput = document.getElementById("passwordInput2");
                                                var eyeIcon = document.getElementById("eyeIcon2");

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

                                        <div class="corporate-form {{ old('type') == 2 ? 'd-show' : '' }} "
                                            id="corporateForm">


                                            <!-- Firma Adı -->
                                            <div class="mt-3">
                                                <label class="q-label">Ticari Unvan
                                                    <i class="info-icon fas fa-info-circle" data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="Firma adını kısaltmadan aynen yazınız."></i>
                                                </label>

                                                <input type="text" name="store_name"
                                                    class="form-control {{ $errors->has('store_name') ? 'error-border' : '' }}"
                                                    value="{{ old('store_name') }}">
                                                @if ($errors->has('store_name'))
                                                    <span class="error-message">{{ $errors->first('store_name') }}</span>
                                                @endif
                                            </div>

                                            <div class="mt-3">
                                                <label class="q-label">Mağaza Adı
                                                </label>

                                                <input type="text" name="name"
                                                    class="form-control {{ $errors->has('name') ? 'error-border' : '' }}"
                                                    value="{{ old('name') }}">
                                                @if ($errors->has('name'))
                                                    <span class="error-message">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>

                                            {{-- <div class="mt-3">
                                                <label class="q-label">Sabit Telefon (Opsiyonel)</label>
                                                <input type="text" name="phone"
                                                    class="form-control {{ $errors->has('phone') ? 'error-border' : '' }}"
                                                    value="{{ old('phone') }}" maxlength="10">
                                                @if ($errors->has('phone'))
                                                    <span class="error-message">{{ $errors->first('phone') }}</span>
                                                @endif
                                            </div> --}}

                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <label class="q-label">Sabit Telefon (Opsiyonel)</label>
                                                </div>
                                                <div class="col-md-4 r-0">
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
                                                <div class="col-md-8 pl-0">
                                                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" maxlength="7">
                                                </div>    
                                            </div>                                            

                                            <!-- Kurumsal Hesap Türü -->
                                            <div class="mt-3">
                                                <label for="corporate-account-type" class="q-label">Faaliyet Alanı</label>
                                                <select name="corporate-account-type" id="corporate-account-type"
                                                    class="form-control {{ $errors->has('corporate-account-type') ? 'error-border' : '' }}">
                                                    <option value="" disabled selected>Seçiniz</option>
                                                    <option value="Emlak Ofisi"
                                                        {{ old('corporate-account-type') == 'Emlak Ofisi' ? 'selected' : '' }}>
                                                        Emlak Ofisi</option>
                                                    <option value="Banka"
                                                        {{ old('corporate-account-type') == 'Banka' ? 'selected' : '' }}>
                                                        Banka</option>
                                                    <option value="İnşaat Ofisi"
                                                        {{ old('corporate-account-type') == 'İnşaat Ofisi' ? 'selected' : '' }}>
                                                        İnşaat Ofisi</option>
                                                    <option value="Turizm Amaçlı Kiralama"
                                                        {{ old('corporate-account-type') == 'Turizm Amaçlı Kiralama' ? 'selected' : '' }}>
                                                        Turizm Amaçlı Kiralama</option>
                                                </select>
                                                @if ($errors->has('corporate-account-type'))
                                                    <span
                                                        class="error-message">{{ $errors->first('corporate-account-type') }}</span>
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
                                                        <option for="{{ $item['sehir_title'] }}"
                                                            value="{{ $item['sehir_key'] }}"
                                                            {{ old('city_id') == $item['sehir_key'] ? 'selected' : '' }}>
                                                            {{ $item['sehir_title'] }}
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
                                                                    <option for="{{ $item['title'] }}"
                                                                        value="{{ $item['title'] }}"
                                                                        {{ old('taxOfficeCity') == $item['title'] ? 'selected' : '' }}>
                                                                        {{ $item['title'] }}
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

                                                      <!-- Yetki Belgesi No -->
                                                      <div class="split-form corporate-input mt-3">
                                                        <div class="corporate-input input-city">
                                                            <div class="mbdef">
                                                                <div class="select select-tax-office">
                                                                    <label for="" class="q-label">Yetki Belgesi No</label>
                                                                    <input type="text" id="authority_licence" name="authority_licence" class="form-control" maxlength="7">
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
                                        <div class="fl-wrap filter-tags clearfix mt-3 mb-3">
                                            <fieldset>

                                                <div class="checkboxes float-left">
                                                    <div class="filter-tags-wrap   {{ old('type') == '1' ? 'd-show ' : '' }}  {{ old('type') == '2' ? 'hidden' : '' }}  {{ $errors->has('check-a') ? 'error-check' : '' }}"
                                                        id="individualFormCheck">
                                                        <input id="check-a" type="checkbox" name="check-a"
                                                            style="margin-top-10px !important;">
                                                        <label for="check-a" style="font-size: 11px;">
                                                            <a href="/sayfa/bireysel-uyelik-sozlesmesi" target="_blank"
                                                                style="margin-top: 20px;">
                                                                Bireysel üyelik sözleşmesini
                                                            </a>
                                                            okudum onaylıyorum.
                                                        </label>
                                                        @if ($errors->has('check-a'))
                                                            <span
                                                                class="error-message">{{ $errors->first('check-a') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="filter-tags-wrap {{ old('type') == '2' ? 'd-show ' : '' }}{{ old('type') == '1' ? 'hidden' : '' }} {{ $errors->has('check-d') ? 'error-check' : '' }}"
                                                        id="corporateFormCheck">
                                                        <input id="check-d" type="checkbox" name="check-d">
                                                        <label for="check-d" style="font-size: 11px;">
                                                            <a href="/sayfa/kurumsal-uyelik-sozlesmesi" target="_blank">
                                                                Kurumsal üyelik sözleşmesini
                                                            </a>
                                                            okudum onaylıyorum.
                                                        </label>
                                                        @if ($errors->has('check-d'))
                                                            <span
                                                                class="error-message">{{ $errors->first('check-d') }}</span>
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="filter-tags-wrap {{ $errors->has('check-b') ? 'error-check' : '' }}">
                                                        <input id="check-b" type="checkbox" name="check-b">
                                                        <label for="check-b" style="font-size: 11px;">
                                                            <a href="/sayfa/kvkk-politikasi" target="_blank">
                                                                Kvkk metnini
                                                            </a>
                                                            okudum onaylıyorum.
                                                        </label>
                                                        @if ($errors->has('check-b'))
                                                            <span
                                                                class="error-message">{{ $errors->first('check-b') }}</span>
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="filter-tags-wrap {{ $errors->has('check-c') ? 'error-check' : '' }}">
                                                        <input id="check-c" type="checkbox" name="check-c">
                                                        <label for="check-c" style="font-size: 11px;">
                                                            <a href="/sayfa/gizlilik-sozlesmesi-ve-aydinlatma-metni"
                                                                target="_blank">
                                                                Gizlilik sözleşmesi ve aydınlatma metnini
                                                            </a>
                                                            okudum onaylıyorum.
                                                        </label>
                                                        @if ($errors->has('check-c'))
                                                            <span
                                                                class="error-message">{{ $errors->first('check-c') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="filter-tags-wrap">
                                                        <input id="check-e" type="checkbox" name="check-e">
                                                        <label for="check-e" style="font-size: 11px;">
                                                            Tarafıma elektronik ileti gönderilmesini kabul ediyorum.
                                                        </label>
                                                    </div>
                                                </div>
                                            </fieldset>

                                        </div>

                                        <button class="btn btn-primary q-button mb-3" type="submit"> Üye OL</button>
                                    </form>
                                </div>
                                <h4 class="support-phone">Bilgi almak için arayın : <a href="tel:4443284">444 3 284</a>
                                </h4>
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


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
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
                        countySelect.empty();
                        countySelect.append('<option value="">İlçe Seçiniz</option>');
                        $.each(data, function(index, county) {
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


            if (countyId) {
                $.ajax({
                    type: 'GET',
                    url: '/get-neighborhoods/' + countyId,
                    success: function(data) {
                        var neighborhoodSelect = $('#neighborhoodSelect');
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
            color: #007bff;
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
            margin-right: 9px;
            margin-top: -27px;
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
            border-color: #EA2B2E !important;
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
