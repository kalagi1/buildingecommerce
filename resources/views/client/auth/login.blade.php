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
                                            <div class="button-group" style="height: 40px">
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
                                                <label class="q-label">Firma Adı 
                                                    <i class="info-icon fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Firma adını kısaltmadan aynen yazınız."></i>
                                                </label>
                                            
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
                                        <div class="fl-wrap filter-tags clearfix mt-3 mb-3">
                                            <fieldset>
                                    
                                                <div class="checkboxes float-left">
                                                    <div class="filter-tags-wrap">
                                                        <input id="check-a" type="checkbox" name="check-a" required>
                                                        <label for="check-a" style="font-size: 12px;">
                                                            <a href="/sayfa/bireysel-uyelik-sozlesmesi" target="_blank">
                                                                Bireysel üyelik sözleşmesini
                                                            </a>
                                                            okudum onaylıyorum.
                                                        </label>
                                                    </div>
                                                    <div class="filter-tags-wrap">
                                                        <input id="check-d" type="checkbox" name="check-d" required>
                                                        <label for="check-d" style="font-size: 12px;">
                                                            <a href="/sayfa/kurumsal-uyelik-sozlesmesi" target="_blank">
                                                                Kurumsal üyelik sözleşmesini
                                                            </a>
                                                            okudum onaylıyorum.
                                                        </label>
                                                    </div>
                                                    <div class="filter-tags-wrap">
                                                        <input id="check-b" type="checkbox" name="check-b" required>
                                                        <label for="check-b" style="font-size: 12px;">
                                                            <a href="/sayfa/kvkk-politikasi"  target="_blank">
                                                                KVKK metnini
                                                            </a>
                                                            okudum onaylıyorum.
                                                        </label>
                                                    </div>
                                                    <div class="filter-tags-wrap">
                                                        <input id="check-c" type="checkbox" name="check-c" required>
                                                        <label for="check-c" style="font-size: 12px;">
                                                            <a href="/sayfa/gizlilik-sozlesmesi-ve-aydinlatma-metni"  target="_blank">
                                                                Gizlilik sözleşmesi ve aydınlatma metnini
                                                            </a>
                                                            okudum onaylıyorum.
                                                        </label>
                                                    </div>
                                                </div>
                                            </fieldset>
                                    
                                            <!-- Diğer form alanları burada bulunabilir -->
                                        </div>
                                    
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

    {{-- <div class="modal" id="agreementModal" tabindex="-1" role="dialog" aria-labelledby="agreementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="agreementModalLabel">Sözleşme</h5>
              <button type="button" class="closeTimes" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="closeTimes">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                BİREYSEL ÜYELİK SÖZLEŞMESİ
                1. Taraflar
                İşbu Bireysel Üyelik Sözleşmesi (bundan böyle “Üyelik Sözleşmesi” olarak anılacaktır); “Cevizli Mah. Çanakkale Cad. No: 103a Kartal / İstanbul” adresinde mukim Master Girişim Bilgi Teknolojileri Gayrimenkul Yatırım Ve Pazarlama A.Ş (bundan böyle kısaca"EMLAKSEPETTE" olarak anılacaktır) ile www.emlaksepette.com Portalına üye olmak için işbu Üyelik Sözleşmesi ile ayrılmaz parçası olan eklerine ve emlaksepette.com Portalında yer alan şartlar ile kurallara onay veren"Üye" arasında elektronik ortamda akdedilerek yürürlüğe girmiştir.
                Üye, işbu Sözleşmeyi kabul etmeden önce ticari amaçlarla verilen sözleşme öncesi bilgilendirme metnini okuyup incelediğini, şartlarını anladığını, bilgilendirme metnini bilgisayarına indirebildiğini ve sözleşme öncesi bilgilendirme yükümlülüğünün kendisine karşı tam olarak yerine getirildiğini, sözleşme ile ilgili ön bilgileri edindiğini teyit ettiğini beyan ve kabul eder.
                Üye, Sözleşme sürecine ilişkin işlemleri tamamlayarak işbu Sözleşme’nin tamamını okuduğunu, içeriğini tamamen anladığını, kendisi ile ilgili olarak verdiği bilgilerin doğru ve güncel olduğunu ve Sözleşme’de belirtilen ve Web Sitesi’nde de yer alan işbu Sözleşme konusu ile ilgili tüm hususları kayıtsız ve şartsız olarak kabul ettiğini ve onayladığını, bu hususlar ile ilgili olarak herhangi bir itiraz ve defi ileri sürmeyeceğini şimdiden beyan, kabul ve taahhüt eder. Üye, Sözleşme konusunu oluşturan hizmetin içeriği, esaslı nitelikleri, özellikleri, KDV dahil satış fiyatı, ödeme şekli ile ilgili bilgileri okuyup hizmetler hakkında gerekli tüm bilgilere sahip olduğunu, bu bilgiler doğrultusunda elektronik ortamda Sözleşme’ye ilişkin gerekli onayı verdiğini beyan, kabul ve taahhüt eder.
                Bu sözleşmeyi bilgisayarınıza indirebilir ve elektronik ortamda kaydedebilirsiniz. Üye, işbu Sözleşme metnini bilgisayarına indirdiğini ve Sözleşmenin bu şekilde kalıcı veri saklayıcısı ile kendisine verildiğini beyan ve kabul eder. Üye tarafından onaylanarak kabul edilen işbu Sözleşme EMLAKSEPETTE tarafından saklanmamaktadır. Web Sitesi’nde yer alan standart sözleşmeye her zaman ulaşmanız mümkündür. Ancak, standart sözleşmede değişiklikler yapılmış olabileceğinden, Üye’nin onayladığı metne göre farklılıklar içerebilir. Üye’nin onayladığı metne daha sonra ulaşma imkanı bulunmamaktadır.
                EMLAKSEPETTE’nin 6698 sayılı Kişisel Verilerin Korunması Kanunu kapsamında hazırladığı, kişisel verilerin işlenmesi ile ilgili aydınlatma metni Web Sitesi’nde yayınlanmaktadır. Üye, anılan aydınlatma metnini ve gizlilik politikasını okuyup incelediğini, EMLAKSEPETTE’nin ilgili kanun kapsamındaki aydınlatma yükümlülüğünü kendisine karşı yerine getirdiğini beyan ve kabul eder.
                2. Tanımlar
                "Portal": www.emlaksepette.com isimli alan adından ve bu alan adına bağlı alt alan adlarından oluşan EMLAKSEPETTE"nin Hizmetler"ini sunduğu internet sitesi.
                "Kullanıcı": Portal"a erişen her gerçek veya tüzel kişi.
                "Üye": “Portal” a üye olan ve "Portal" dahilinde sunulan hizmetlerden belirlenen koşullar dahilinde yararlanan “Kullanıcı”.
                "Üyelik": Üye olmak isteyen Kullanıcı"nın, Portal"daki üyelik formunu doğru ve gerçek bilgilerle doldurması, verdiği kimlik bilgilerinin EMLAKSEPETTE tarafından onaylanması ve bildirimi ile kazanılan statüdür. Üyelik işlemleri tamamlanmadan üye olma hak ve yetkisine sahip olunamaz. Üyelik hak ve yükümlülükleri, başvuruda bulunana ait olan, kısmen veya tamamen herhangi bir üçüncü şahsa devredilemeyen hak ve yükümlülüklerdir. Üyelik başvurusu herhangi bir sebep gösterilmeksizin EMLAKSEPETTE tarafından reddedilebilir veya ek şart ve koşullar talep edilebilir.EMLAKSEPETTE gerekli görmesi halinde üye"nin üyelik statüsünü sona erdirebilir, üyelik"i herhangi bir sebeple sona erenin sonradan yapacağı üyelik başvurusunu kabul etmeyebilir.
                "Üyelik Sözleşmesi": Portal" da yer alan şartlar ve koşullar ile eklerden oluşan, kullanıcının üyelik sözleşmesi"ni okuduğuna, anladığına ve kabul ettiğine ilişkin elektronik olarak verdiği onay neticesinde elektronik ortamda akdedilen, ayrılmaz parçası olan ekler ile portal"da yer alan şart ve kuralları bir bütün olan elektronik sözleşmedir.
                "EMLAKSEPETTE Üyelik Hesabı": Üye"nin portal içerisinde kendisine sunulan hizmetlerden yararlanmak için gerekli olan iş ve işlemleri gerçekleştirdiği, üyelik ile ilgili konularda EMLAKSEPETTE" ye talepte bulunduğu, Üyelik bilgilerini güncelleyip, sunulan hizmetlerle ilgili raporlamaları görüntüleyebildiği, kendisinin belirlediği ve münhasıran kendisi tarafından kullanılacağını taahhüt ettiği kullanıcı adı ve şifre ile portal üzerinden eriştiği üye"ye özel internet sayfaları bütünü.
                "EMLAKSEPETTE Hizmetleri": Portal içerisinde EMLAKSEPETTE tarafından üyelik sözleşmesi içerisinde bulunan ve üyenin iş ve işlemlerini gerçekleştirmek amacıyla sunulan uygulamalardır. EMLAKSEPETTE, portal içerisinde sunulan hizmetler"inde dilediği zaman değişiklikler ve/veya uyarlamalar yapabilir. Yapılan değişiklikler ve/veya uyarlamalarla ilgili üye"nin uymakla yükümlü olduğu kural ve koşullar portal"dan üye"ye duyurulur, açıklanan şartlar ve koşullar portal"da yayımlandığı tarihte yürürlüğe girer.
                "İçerik": Portal"da yayınlanan ve erişimi mümkün olan her türlü bilgi, yazı, dosya, resim, video, rakam vb. görsel, yazımsal ve işitsel imgeler.
                "EMLAKSEPETTE Arayüzü": EMLAKSEPETTE ve EMLAKSEPETTE üyeleri tarafından oluşturulan içerik/içeriklerin kullanıcılar tarafından görüntülenebilmesi, incelenebilmesi ve veritabanından sorgulanabilmesi amacıyla kullanıcılar tarafından kullanılan 5846 Sayılı Fikir ve Sanat Eserleri Kanunu kapsamında korunan ve tüm fikri hakları EMLAKSEPETTE"ye ait olan tasarımlar içerisinde portal üzerinden yapılabilecek her türlü işlemin gerçekleştirilmesi için bilgisayar programına komut veren internet sayfaları.
                "EMLAKSEPETTE Veritabanı": Portal dahilinde erişilen içeriklerin depolandığı, tasnif edildiği, sorgulanabildiği ve erişilebildiği EMLAKSEPETTE"ye ait olan 5846 Sayılı Fikir ve Sanat Eserleri Kanunu gereğince korunan veritabanıdır.
                "EMLAKSEPETTE Panel": Üye"nin portal"da yer alan uygulamalardan ve hizmetler"den yararlanabilmesi için gerekli işlemleri gerçekleştirebildiği, kişisel bilgilerini, tercihlerini, uygulama bazında kendisinden talep eden bilgileri girdiği, sadece Üye tarafından belirlenen kullanıcı adı ve şifre ile erişilebilen Üye"ye özel sayfa.
                "Kişisel Veri": 6698 sayılı Kişisel Verilerin Korunması Hakkında Kanun"un (KVKK) 3/d maddesi uyarınca, kimliği belirli veya belirlenebilir gerçek kişiye ilişkin her türlü bilgi ile KVKK m.6/1"de sayılan özel nitelikli kişisel verilerdir.
                "Özel nitelikli kişisel veri": Kişilerin ırkı, etnik kökeni, siyasi düşüncesi, felsefi inancı, dini, mezhebi veya diğer inançları, kılık ve kıyafeti, dernek, vakıf ya da sendika üyeliği, sağlığı, cinsel hayatı, ceza mahkûmiyeti ve güvenlik tedbirleriyle ilgili verileri ile biyometrik ve genetik verileri özel nitelikli kişisel veridir.
                3. Üyelik Sözleşmesi"nin Konusu ve Kapsamı
                İşbu Üyelik Sözleşmesi"nin konusu, portal"da sunulan hizmetler"in, bu hizmetler"den yararlanma şartları ile tarafların hak ve yükümlülüklerinin tespitidir. Üyelik sözleşmesi ve ekleri ile portal içerisinde yer alan kullanıma, üyeliğe ve hizmetler"e ilişkin EMLAKSEPETTE tarafından yapılan tüm uyarı, bildirim, uygulama ve açıklama gibi beyanlar kapsam dâhilindedir. "Kullanıcı", işbu üyelik sözleşmesi hükümlerini kabul etmekle, portal içinde yer alan kullanıma, üyeliğe ve hizmetlere ilişkin EMLAKSEPETTE tarafından açıklanan her türlü beyana uygun davranacağını kabul ve taahhüt etmektedir.
                4. Üyelik Şartları
                4.1 Portal"a üye olabilmek için reşit olmak ve EMLAKSEPETTE tarafından işbu üyelik sözleşmesi kapsamında geçici olarak üyelikten uzaklaştırılmamış, üyeliği askıya alınmamış veya üyelikten süresiz yasaklanmamış olmak gerekmektedir.
                4.2 EMLAKSEPETTE herhangi bir zamanda gerekçe göstermeden, bildirimde bulunmadan, tazminat, ceza vb. sair yükümlülüğü bulunmaksızın derhal yürürlüğe girecek şekilde işbu üyelik sözleşmesini tek taraflı olarak feshedebilir, üye"nin üyeliğine son verebilir veya geçici olarak durdurabilir. Portal"da belirtilen kurallara aykırılık halleri, üye"nin EMLAKSEPETTE bilgi güvenliği sistemine risk oluşturması halleri üyeliğe son verme veya üyeliği geçici durdurma hallerindendir.
                5. Tarafların Hak ve Yükümlülükleri
                5.1 "Üye"nin Hak ve Yükümlülükleri
                5.1.1. Üye, portal"da belirtilen kurallara, beyanlara, yürürlükteki tüm mevzuata ve ahlak kurallarına uygun hareket edeceğini, üyelik sözleşmesi hükümleri ile portal"daki tüm şart ve kuralları anladığını ve onayladığını kabul ve taahhüt etmektedir.
                5.1.2. Üye EMLAKSEPETTE"nin yürürlükteki mevzuat hükümleri gereğince resmi makamlara açıklama yapmakla yükümlü olduğu durumlarda; Üye"lere ait gizli/özel/kişisel veri-özel nitelikli kişisel veri/ticari bilgileri resmi makamlara açıklamaya yetkili olduğunu, bu sebeple EMLAKSEPETTE"den her ne nam altında olursa olsun tazminat talep etmeyeceğini kabul ve taahhüt etmektedir. Bunun haricinde Üye"nin portal üzerinde dahil olduğu ilanlarla ilgili olarak herhangi bir kişi ya da kurumun haklarının ihlal edildiği iddiası ile EMLAKSEPETTE"ye bildirimde bulunması, yargı yoluna başvuracağını bildirmesi halinde; Üye"nin kendisine bildirdiği ad-soyad bilgisini EMLAKSEPETTE ilgili tarafa verebilir.
                5.1.3. Üye"lerin, EMLAKSEPETTE üyelik hesabı"na girişte kullandıkları kullanıcı adı ve şifre"nin güvenliğini sağlamaları, münhasıran ve münferiden kendileri tarafından kullanılmasını temin etmeleri, üçüncü kişilerden saklamaları tamamen kendi sorumluluğundadır. Bu konuda ihmal veya kusurlarından dolayı diğer üye"lerin ve/veya EMLAKSEPETTE"nin ve/veya üçüncü kişilerin uğradığı veya uğrayabileceği maddi ve/veya manevi her tür zararlardan üye sorumludur.
                5.1.4. Üye, portal dahilinde kendisi tarafından sağlanan bilgilerin ve içeriklerin doğru ve hukuka uygun olduğunu, söz konusu bilgi ve içeriklerin portal üzerinde yayınlanmasının veya bu içeriklerle bağlantılı ürünlerin satışının yürürlükteki mevzuat doğrultusunda herhangi bir hukuka aykırılık yaratmadığını kabul ve taahhüt etmektedir. "EMLAKSEPETTE", üye tarafından "EMLAKSEPETTE"ne iletilen veya portal üzerinden “Üye” tarafından yüklenen bilgilerin ve içeriklerin doğruluğunu araştırmakla yükümlü ve sorumlu olmadığı gibi, söz konusu bilgi ve içeriklerin yanlış veya hatalı olmasından veya yayınlanmasından dolayı ortaya çıkacak hiçbir zarardan sorumlu tutulamaz.
                5.1.5. "Üye", "EMLAKSEPETTE"nin yazılı onayı olmadan işbu “Üyelik Sözleşmesi”ni veya bu “Üyelik Sözleşmesi”nin kapsamındaki hak ve yükümlülüklerini kısmen veya tamamen herhangi bir üçüncü kişiye devredemez.
                5.1.6. Üye hukuka uygun amaçlarla portal üzerinde işlem yapabilir. Üye"nin, portal dahilinde yaptığı her işlem ve eylemdeki hukuki ve cezai sorumluluk kendisine aittir. Üye "EMLAKSEPETTE"nin ve/veya başka bir üçüncü şahsın ayni veya şahsi haklarına, malvarlığına, kişisel verilerine tecavüz teşkil edecek nitelikteki portal dâhilinde bulunan resimleri, metinleri, görsel ve işitsel imgeleri, video klipleri, dosyaları, veritabanları, katalogları ve listeleri çoğaltmayacağını, kopyalamayacağını, dağıtmayacağını, işlemeyeceğini, başka veritabanına aktarmayacağını veya bu nitelikte sonuçlar doğurabilecek şekilde "Portal"a yüklemeyeceğini; bu tür eylemler gerçekleştirerek herhangi bir ticari faaliyette bulunmayacağını; gerek bu eylemleri ile gerekse de başka yollarla doğrudan ve/veya dolaylı olarak haksız rekabet teşkil eden davranış ve işlemler gerçekleştirmeyeceğini kabul ve taahhüt etmektedir. Üye"nin işbu “Üyelik Sözleşmesi” hükümlerine ve hukuka aykırı olarak gerçekleştirdikleri portal üzerindeki faaliyetler nedeniyle üçüncü kişilerin uğradıkları veya uğrayabilecekleri zararlardan dolayı "EMLAKSEPETTE" doğrudan ve/veya dolaylı olarak hiçbir şekilde sorumlu tutulamaz.
                5.1.7. “EMLAKSEPETTE”, üye"lerin sadece ilgili ilanların içeriklerini öğrenme amacıyla ilanları görüntülemesine ve "EMLAKSEPETTE" arayüzü"nü kullanmasına izin vermekte olup, bunun dışında bir amaçla veri tabanı üzerinden belirli bir sayıda veya bütününe yönelik olarak ilanlara ulaşılmaya çalışılması, ilanların kısmen veya tamamen kopyalanması, bunların başka mecralarda doğrudan veya dolaylı olarak yayınlanması, derlenmesi, işlenmesi, başka veritabanlarına aktarılması, bu veritabanından üçüncü kişilerin erişimine ve kullanımına açılması, “EMLAKSEPETTE” üzerindeki ilanlara link verilmesi de dahil olmak üzere benzer fiillerin işlenmesine “EMLAKSEPETTE” tarafından izin verilmemekte ve rıza gösterilmemektedir. Bu tür fiiller hukuka aykırı olup; "EMLAKSEPETTE"nin gerekli talep, dava ve takip hakları saklıdır.
                5.1.8. Üye, üçüncü şahıslardan aldığı mal ve hizmetlerdeki ayıplarla ilgili “EMLAKSEPETTE”nin herhangi bir sorumluluğu bulunmadığını, Tüketicinin Korunması Hakkındaki Kanun ve ilgili sair mevzuat kapsamındaki her türlü talep ve sorumluluğun muhatabının ilgili mal ve hizmeti satıcısına ait olduğunu ve bunlara ilişkin olarak her tür sorumluluk ve yükümlülükten “EMLAKSEPETTE”yi ibra ettiğini kabul ve taahhüt etmektedir. EMLAKSEPETTE”, Üye ile diğer üyeler ve kullanıcılar arasındaki ilişkiler nedeniyle hiçbir şekilde sorumlu tutulamaz. EMLAKSEPETTE hiçbir şekilde, diğer üyelerin veya kullanıcıların Üye ile sözleşme yapacaklarını, iyiniyetli olduklarını, borçlarını ifa kabiliyetlerinin varlığını, borçlarının ifasını, beyanlarının doğruluğunu, işlem yapmaya yetkili olduklarını, sağlanan mal ve hizmetlerin ayıpsız olacağını ve benzer diğer hususları garanti etmez. EMLAKSEPETTE, Üye’nin emlaksepette.com vasıtasıyla gireceği hukuki ilişkilere tamamen yabancıdır ve bunlara ilişkin hiç bir sorumluluğu yoktur. Sorumluluğun tamamı Üye’ye aittir. EMLAKSEPETTE sadece taşınmaz alım-satım, kiralama işlerini kolaylaştırmak amacıyla web sitesini kullanıma sunmakta olup, web sitesi üzerinden yapılan işlemlerde alıcı, satıcı, temsilci, acenta, simsar, vekil, kefil, garantör, komisyoncu, mümessil, danışman veya burada belirtilmeyen diğer herhangi bir hukuki sıfatı yoktur. Üye’nin emlaksepette.com web sitesi kanalıyla işlem yapması, üçüncü kişilerle ilişkiler tesis etmesi, alım satım, kiralama ve diğer şekillerle ticaret yapması, Üye ve diğer üçüncü kişilerle EMLAKSEPETTE arasında, söz konusu işlemlerden kaynaklanan her hangi bir hukuki ilişki veya sorumluluk oluşturmaz. Bu işlemlerin tarafı ve sorumlusu sadece Üye’dir.
                5.1.9. Üye, emlaksepette.com web sitesinde belirtilen gayrimenkul satın alma hizmetinden yararlanabilmesi için söz konusu kapora bedeline ilişkin EMLAKSEPETTE tarafından belirlenen ücreti EMLAKSEPETTE’ye ödeyeceğini kabul ve taahhüt eder. Üye, satın almak istediği gayrimenkulun rezerve edilmesine yönelik kapora ücretini emaneten toplam satış bedeli üzerinden belirlenecek yüzde oranında sisteme ödeyeceğini kabul ve taahhüt eder. 
                A- Kapora ücreti yatırıldığında satılık gayrimenkul ilanı sistemden otomatik olarak kaldırılır. Kapora ücretinin ödenmesi, ÜYE’ye gayrimenkulun ÜYE’ye tahsis edilmesi/ ayrılması ve rezerve edilmesi anlamı taşımaktadır. 
                B- Kapora ücreti, toplam satış bedelinin %2’si tutarındadır. Kaparo bedelinin yatırılmasından itibaren maximum 30 gün boyunca EmlakSepette güvencesi ile blokeli hesapta tutulur. Satış gerçekleşmesine bağlı olarak ödenen kapora ücreti hak sahibine aktarılır veya hak sahibinin ödemelerinden mahsup edilmek üzere EmlakSepette hesaplarına geçer. Taraflar arasında satış işleminin gerçekleştiğine dair EmlakSepette tarafından bilgi,belge ve dökümanlar talep edilebilir. Taraflar satışı onayladığında EmlakSepette tarafından gerekli işlemler başlatılır ve EmlakSepette sisteme ödenen kaparo ücretine hak kazanır. Üye, kaparo ücretini EmlakSepette’ye emaneten kaparo bedeli olarak yatırdığını ve satış işleminin bu platform dışında gerçekleşeceğini kabul etmiştir. 
                B- Kapora bedelinin yatırılmasından itibaren 30 günlük süre içerisinde, satış gerçekleşirse kapora ücreti satış bedelinden mahsup edilecektir/düşülecektir. 
                C- Satış işlemi 30 gün süre ile gerçekleşmezse Satıcı veya EMLAKSEPETTE ödenen kapora ücretini kendi uhdesine geçiremez. Kapora bedelinin yatırılmasından itibaren 30 günlük süre sonunda satış gerçekleşmezse, iptal talebinin oluşturulduğu tarihten itibaren ÜYE tarafından ödenen kapora bedeli ÜYE’ye 30 iş günü içerisinde iade edilir. EMLAKSEPETTE her zaman kapora ücreti tarifesinde değişiklik yapabilir. EMLAKSEPETTE’nin internet, e-posta veya web sitesi yoluyla tarife yayınlaması, Üye’ye yapılmış tebligat yerine geçecektir. Bu Sözleşme altında tahakkuk eden ücretler EMLAKSEPETTE’ye net olarak ödenir. Yasal olarak ödenmesi gereken KDV, stopaj gibi diğer her türlü ödeme ve vergiler söz konusu olursa, bunlar ücretin dışında olup, Üye tarafından ayrıca ödenir. 
                5.1.10. Bireysel üyeler EMLAKSEPETTE platformunda ilan yayınlayamazlar. Bireysel üyeler EMLAKSEPETTE’de satılık gayrimenkul ilanı yayınlamak isterse sistemde yer alan kayıt formunu doldurarak sistem tarafından en yakın Gayrimenkul Danışmanına yönlendirilirler. Üye’ye yönlendirilen gayrimenkul danışmanı işlemin gerçekleşmesi için gerekli işlemleri Üye adına başlatacaktır.
                5.1.11. Bireysel üyeler satış talebini iptal ettiklerinde kapora ücreti en geç 30 gün içerisinde ÜYE hesabına iade edilir. 
                5.2. "EMLAKSEPETTE"in Hak ve Yükümlülükleri
                5.2.1. "EMLAKSEPETTE", işbu üyelik sözleşmesi"nde bahsi geçen hizmetleri; ilgili hizmetlerin sunumuyla ilgili "EMLAKSEPETTE üyelik hesabı" içerisinde belirtilen açıklamalar ve işbu üyelik sözleşmesi"nde belirtilen koşullar dâhilinde yerine getirmeyi, işbu üyelik sözleşmesi kapsamında belirtilen hizmetlerin sunulabilmesi için gerekli olan teknolojik altyapıyı tesis etmeyi ve işletmeyi kabul, beyan ve taahhüt eder. İşbu madde içerisinde belirtilen teknolojik altyapı tesis etme yükümlülüğü, sınırsız ve eksiksiz bir hizmet taahhüdü anlamına gelmemektedir; “EMLAKSEPETTE” her zaman herhangi bir bildirimde bulunmadan işbu üyelik sözleşmesi ile belirlenen hizmetlerini ve teknolojik altyapısını durdurabilir veya son verebilir.
                5.2.2. "EMLAKSEPETTE", portal"da sunulan hizmetleri ve içerikleri her zaman değiştirebilme; "Üye"lerin sisteme yükledikleri bilgileri ve içerikleri portal kullanıcıları da dâhil olmak üzere üçüncü kişilerin erişimine kapatabilme ve silme hakkını saklı tutmaktadır. "EMLAKSEPETTE", bu hakkını hiçbir bildirimde bulunmadan ve önel vermeden kullanabilir. Üye"ler, "EMLAKSEPETTE"nin talep ettiği değişiklik ve/veya düzeltmeleri ivedi olarak yerine getirmek zorundadırlar. Değişiklik ve/veya düzeltmeleri gerekli görüldüğü takdirde "EMLAKSEPETTE" yapabilir. "EMLAKSEPETTE" tarafından talep edilen değişiklik ve/veya düzeltme taleplerinin, kullanıcılar tarafından zamanında yerine getirilmemesi sebebiyle doğan veya doğabilecek zararlar, hukuki ve cezai sorumluluklar tamamen kullanıcılara aittir.
                5.2.3. Portal üzerinden, "EMLAKSEPETTE"nin kendi kontrolünde olmayan sağlayıcılar ve başkaca üçüncü kişilerin sahip olduğu ve işlettiği başka internet sitelerine ve/veya portallara, dosyalara veya içeriklere link verebilir. Bu linkler "Üye"ler tarafından veya sadece referans kolaylığı nedeniyle "EMLAKSEPETTE" tarafından sağlanmış olabilir ve linkin yöneldiği internet sitesini veya işleten kişisini desteklemek amacıyla veya internet sitesi veya içerdiği bilgilere yönelik herhangi bir türde doğrulama beyanı veya garanti niteliği taşımamaktadır. Portal üzerindeki linkler vasıtasıyla erişilen portallar, internet siteleri, dosyalar ve içerikler, bu linkler vasıtasıyla erişilen portallar veya internet sitelerinden sunulan hizmetler veya ürünler veya bunların içeriği hakkında "EMLAKSEPETTE"nin herhangi bir sorumluluğu yoktur.
                5.2.4. "EMLAKSEPETTE", portal"ın işleyişine, hukuka, başkalarının haklarına, üyelik sözleşmesi koşullarına, kişisel verilerin korunmasına genel ahlak kurallarına aykırı olan mesajları, içerikleri istediği zaman ve şekilde erişimden kaldırabilir; "EMLAKSEPETTE" bu mesaj ve içeriği giren üye"nin üyeliğine herhangi bir bildirim yapmadan son verebilir.
                5.2.5. "EMLAKSEPETTE"nin, "EMLAKSEPETTE" çalışanlarının ve yöneticilerinin portal"da üye"ler ve kullanıcılar tarafından sağlanan içeriklerin hukuka uygun olup olmadığını, gerçekliğini, doğruluğunu araştırmak ve kontrol etmek yükümlülüğü bulunmamaktadır.
                5.2.6. "EMLAKSEPETTE", 5651 sayılı "İnternet Ortamında Yapılan Yayınların Düzenlenmesi ve Bu Yayınlar Yoluyla İşlenen Suçlarla Mücadele Edilmesi Hakkında Kanun" kapsamında ve bu Kanun doğrultusunda Telekomünikasyon Kurumu İletişim Başkanlığı"nın 17.01.2013 tarih ve 581 Belge no"lu yazısı ile "Yer Sağlayıcı" olarak faaliyet göstermektedir. Yer Sağlayıcı” statüsünde olan EMLAKSEPETTE, Üye tarafından sağlanan içeriği kontrol etmek veya hukuka aykırı bir faaliyetin olup olmadığını araştırmakla yükümlü değildir. Üye’nin emlaksepette.com web sitesi kanalıyla yaptığı işlemlerin kaçakçılık, gümrük mevzuatına aykırılık, hakaret, kişisel verileri hukuka aykırı olarak ele geçirme veya diğer bir şekilde suç teşkil eden bir eylem olması halinde, bu fiillere ilişkin tüm cezai sorumluluklar Üye’ye aittir. Web sitesini kullanarak yaptığı işlemlerin ve üçüncü kişilerin haklarını ihlal etmesinin hukuki tüm sorumluluğu da tek başına Üye’ye aittir.
                6. Gizlilik Politikası
                6.1. “EMLAKSEPETTE”, "Portal"da üyelerle ilgili bilgileri işbu “Üyelik Sözleşmesi” ve işbu üyelik sözleşmesi"nin eklerinden biri ve ayrılmaz parçası olan site içinde bulunan Gizlilik Politikası kapsamında kullanabilir. “EMLAKSEPETTE” "Üye"lere ait gizli bilgileri ancak Gizlilik Politikası"nda belirtilen koşullar dâhilinde üçüncü kişilere açıklayabilir veya kullanabilir.
                6.2. “EMLAKSEPETTE”, “Üyelik Sözleşmesi” ile belirlenen amaç ve kapsam dışında da üye olma aşamasında talep edilen ad-soyad, telefon numarası, e-posta adresi gibi bilgileri; yürürlükte bulunan mevzuatta öngörülen koşullara tabi şekilde ve gerektiğinde ek onayları almak suretiyle sms, e-posta, site içi bilgilendirmeler ve benzeri yöntemlerle, tanıtım ve bilgilendirme amaçlı iletişim faaliyetleri, araştırma, pazarlama faaliyetleri ve istatistikî analizler yapmak amacıyla veya gerektiğinde “Üye” ile temas kurmak için kullanabilir. Yine yürürlükte bulunan mevzuat uyarınca kişisel veriler aynı zamanda emlaksepette.com"un süreçlerini iyileştirme amaçlı araştırmalar yapmak, veri tabanı oluşturmak ve pazar araştırmaları yapmak için “EMLAKSEPETTE”nin işbirliği içinde olduğu firmalara aktarılabilir, bu firmalar tarafından işlenebilir ve kullanılabilir. “EMLAKSEPETTE”nin belirtilen amaçlarla işbirliği içinde bulunduğu gerçek kişi ve/veya tüzel kişilere, Kullanıcıların kişisel verilerini iletmesine Kullanıcılar onay vermektedir.
                6.3. Üye kişisel veri teşkil edebilecek ve kendisi tarafından portal"a girilen verileri “EMLAKSEPETTE” tarafından portal"in fonksiyonlarının kullandırılması ve yukarıda sayılan amaçlarla toplamaktadır. Üye bu verilerin toplanmasının, işlenmesinin ve aktarılmasının öncelikle “EMLAKSEPETTE” sisteminin işleyebilmesinin zorunlu bir unsuru olduğunu anladığını kabul, beyan ve taahhüt eder. Kişisel Verilerin Korunması Hakkında detaylı bilgi içinSözleşmeler ve Koşullar sayfası ziyaret edilmelidir. “EMLAKSEPETTE” Kişisel Verilerin Korunması Politikası"nda ve sair kişisel veriler ile ilgili politika, prosedür, sözleşme maddeleri ve kullanım koşullarında istediği zaman değişiklik yapabilir. Değişiklikler portal"da yayınlandığı anda yürürlüğe girer. Üye bu değişiklikleri takip etmekle yükümlü olup, “EMLAKSEPETTE”den bu değişikliklerle ilgili herhangi bir talepte veya zarar ziyan iddiasında bulunamaz.
                6.4. Üye portal dahilinde eriştiği bilgileri yalnızca bu bilgileri ifşa eden Üye"nin veya "EMLAKSEPETTE"nin ifşa ettiği amaçlara uygun olarak kullanmakla yükümlü olup, elde ettiği kullanıcılara veya üçüncü kişilere ait Kişisel Verilerin korunmasından, işlenmesinden, aktarılmasından ve KVKK kapsamındaki tüm yükümlülüklerden kendisinin sorumlu olduğunu, EMLAKSEPETTE"nin kendi sistemlerinde internet sitesinin kullanımı için zorunlu olarak topladığı kişisel veriler dışındaki hiçbir kişisel veri için KVKK kapsamında herhangi bir yükümlülüğünün ve sorumluluğunun olmadığını kabul, beyan ve taahhüt eder. Üye; kişisel verilerin korunması yükümlülüğüne aykırı hareket etmesi veya kişisel verileri işlemesi, aktarması veya sair surette bir işleme konu etmesi ve bu kullanımın bir ihlal meydana getirmesi durumunda, Kişisel Verileri Koruma Kurulu"nun veya idari makamların veya mahkemelerin kişisel verilerle ilgili olarak verdikleri kararlar neticesinde EMLAKSEPETTE"nin bir zarara uğraması durumunda bu zararı ilk talepte nakden ve defaten tazmin edeceğini kabul, beyan ve taahhüt eder.
                6.5. Üye “EMLAKSEPETTE” üyeliği ve/veya yayınladığı ilanlar nedeniyle alenileşmiş olan kişisel verilerinin arama motorları veya benzer verileri indeksleyen sistemler tarafından kaydedilmesi, işlenmesi, arama sonuçlarında çıkarılması gibi durumlar için “EMLAKSEPETTE”nin herhangi bir dahlinin, katkısının olmadığını ve kişisel verilerinin indesklenmek veya sair yöntemlerle aramaya mahsus yapılandırılmış sistemlerde herhangi bir şekil ve surette işlenmesi veya aktarılmasından dolayı “EMLAKSEPETTE”in herhangi bir sorumluluğunun olmadığını, taleplerini başta google olmak üzere diğer arama motoru veya arama sistemleri, indeskleme sistemleri işleten gerçek ve/veya tüzel kişilere yöneltmeyi kabul, beyan ve taahhüt eder.
                6.6. Üye ilan verirken veya herhangi bir nedenle özel nitelikli kişisel verilerini “EMLAKSEPETTE” portal" üzerinden yayınladığı takdirde, özel nitelikli kişisel verilerin bu şekilde aleniyet kazandığını, “EMLAKSEPETTE”in bu özel nitelikli kişisel verileri portal ile ilgili doğrudan veya dolaylı amaçlar için almasının, işlemesinin ve aktarmasının hukuka aykırılık teşkil etmediğini kabul, beyan ve taahhüt eder.
                6.7. Üye, EmlakSepette portalı üzerinden satın aldığı gayrimenkullere ait ilanlarda isim ve soyisim bilgilerinin görünmesini onaylarsa bu bilgiler diğer üyeler ile paylaşılır. Kişisel bilgielerinin paylaşılmasını onaylamayan üyelerin bilgileri gizlenecektir. Kişisel bilgilerinin paylaşılmasına onay veren üyeler gayrimenkulu satın almayı düşünen yeni üyeler ile etkileşim kurarak deneyim ve tecrübelerini aktarabilecektir. 
                7. Fikri Mülkiyet Hakları
                7.1. Üye"ler, "EMLAKSEPETTE" hizmetlerini, "EMLAKSEPETTE" bilgilerini ve "EMLAKSEPETTE"nin telif haklarına tabi çalışmalarını satmak, işlemek, paylaşmak, dağıtmak, sergilemek veya başkasının "EMLAKSEPETTE"nin hizmetlerine erişmesi veya kullanmasına izin vermek hakkına sahip değildirler. İşbu portal kullanım koşulları dâhilinde "EMLAKSEPETTE" tarafından sarahaten izin verilen durumlar haricinde "EMLAKSEPETTE"nin telif haklarına tabi çalışmalarını çoğaltamaz, işleyemez, dağıtamaz veya bunlardan türemiş çalışmalar yapamaz.
                7.2. "EMLAKSEPETTE", tamamen kendi takdirine bağlı ve tek taraflı olarak işbu üyelik sözleşmesi"ni uygun göreceği herhangi bir zamanda portal"da yayınlayarak değiştirebilir. İşbu üyelik sözleşmesinin değişen hükümleri, portal"da yayınlandığı tarihte geçerlilik kazanarak yürürlüğe girecek, geri kalan hükümler aynen yürürlükte kalarak hüküm ve sonuçlarını doğurmaya devam edecektir. İşbu üyelik sözleşmesi, üye"nin tek taraflı beyanları ile değiştirilemez.
                9. Mücbir Sebepler
                Hukuken mücbir sebep sayılan tüm durumlarda, "EMLAKSEPETTE" işbu üyelik sözleşmesi ile belirlenen edimlerinden herhangi birini geç veya eksik ifa etme veya ifa etmeme nedeniyle yükümlü değildir. Bu ve bunun gibi durumlar, "EMLAKSEPETTE" için, gecikme, eksik ifa etme veya ifa etmeme veya temerrüt addedilmeyecek veya bu durumlar için "EMLAKSEPETTE"den herhangi bir ad altında tazminat talep edilemeyecektir. Mücbir sebep terimi; doğal afet, isyan, savaş, grev, iletişim sorunları, altyapı ve internet arızaları, sisteme ilişkin iyileştirme veya yenileştirme çalışmaları ve bu sebeple meydana gelebilecek arızalar, elektrik kesintisi ve kötü hava koşulları da dâhil ve fakat bunlarla sınırlı olmamak kaydıyla ilgili tarafın makul kontrolü haricinde ve "EMLAKSEPETTE"nin gerekli özeni göstermesine rağmen önleyemediği kaçınılamayacak olaylar olarak yorumlanacaktır.
                10. Uygulanacak Hukuk ve Yetki
                İşbu üyelik sözleşmesi"nin uygulanmasında, yorumlanmasında ve işbu üyelik sözleşmesi dâhilinde doğan hukuki ilişkilerin yönetiminde yabancılık unsuru bulunması durumunda Türk kanunlar ihtilafı kuralları hariç olmak üzere doğrudan Türk İç Hukuku uygulanacaktır. İşbu üyelik sözleşmesi"nden dolayı doğan veya doğabilecek her türlü ihtilafın hallinde İstanbul Anadolu Mahkemeleri ve İcra Daireleri yetkilidir.
                11. "EMLAKSEPETTE" Kayıtlarının Geçerliliği
                Üye işbu üyelik sözleşmesi"nden doğabilecek ihtilaflarda "EMLAKSEPETTE"nin kendi veritabanında, sunucularında tuttuğu elektronik ve sistem kayıtlarının, ticari kayıtlarının, defter kayıtlarının, mikrofilm, mikrofiş ve bilgisayar kayıtlarının muteber bağlayıcı, kesin ve münhasır delil teşkil edeceğini,"EMLAKSEPETTE"yi yemin teklifinden beri kıldığını ve bu maddenin HMK 193. Madde anlamında delil sözleşmesi niteliğinde olduğunu kabul, beyan ve taahhüt eder.
                12. Yürürlük ve Süre
                İşbu üyelik sözleşmesi ve üyelik sözleşmesi"yle atıfta bulunulan ve üyelik sözleşmesi"nin ayrılmaz bir parçası olan ekler ile portal" da yer alan kurallar ve şartlar, üye"nin elektronik olarak onay vermesi ile elektronik ortamda akdedilerek yürürlüğe girmiştir. Üyelik sözleşmesi"nin herhangi bir hükmünün geçersizliği, mevzuata aykırılığı veya uygulanabilir olmaması sözleşmenin geri kalan hükümlerinin yürürlüğünü etkilemeyecektir.
                İşbu Sözleşme süresiz olarak düzenlenmiştir. Taraflardan her biri 7 (yedi) gün önceden yapacağı bir ihbarla istediği zaman sözleşmeyi fesih hakkına sahiptir. Ancak, fesih tarihine kadar ödenen kapora ücreti geçerliliğini kendi sürelesi içinde korur ve bu ücretten doğan EMLAKSEPETTE alacakları tam olarak ödenir.
                13. “Üyelik Sözleşmesi”nin Ekleri
                13.1 “Üye”, portal"da yayınlanan şartlar ve kuralların, işbu “Üyelik Sözleşmesi”nin içeriklerini okuyup anladığını, “Üye” olarak “Üyelik Sözleşmesi” ile 
                Ek-1 Kullanım Koşulları
                Ek-2 Gizlilik Politikası
                Ek-3 EmlakSepette Hizmetleri
                Ek-4 İlan Verilmesi, Satışa Arzı, Listelenmesi Yasaklı Ürün Ve Hizmetleri
                İşbu “Üyelik Sözleşmesi”nin eki ve ayrılmaz olduğunu, içeriklerini okuyup anladığını, “ÜYE” olarak “Üyelik Sözleşmesi” ile eklerine” ve “Portal”da yayınlanan şartlarla kurallara uygun davranacağını kayıtsız ve şartsız olarak kabul ettiğini beyan ve taahhüt etmektedir
                EK-1. KULLANIM KOŞULLARI
                www.emlaksepette.com alan adlı internet sitesini kullanmak için lütfen aşağıda yazılı koşulları okuyunuz. www.emlaksepette.com internet sitesini (bundan böyle “Portal” olarak anılacaktır) ziyaret ederek ve/veya “Üye” olarak, işbu “Kullanım Koşulları”nı okuduğunuzu, içeriğini tamamen anladığınızı, “Kullanım Koşulları”nda belirtilen ve “Portal”de bulunan ve zaman içinde yer alacak tüm hususları kayıtsız ve şartsız olarak kabul ettiğinizi, “Portal”da belirtilen tüm hususlarla ilgili olarak herhangi bir itiraz ve defi ileri sürmeyeceğinizi kabul, beyan ve taahhüt ediyorsunuz. Bu koşulları kabul etmediğiniz takdirde, lütfen "Portal"ı kullanmaktan vazgeçiniz.
                1.1. İşbu portal"ın sahibi Cevizli Mah. Çanakkale Cad. No: 103a Kartal / İstanbul” adresinde mukim Master Girişim Bilgi Teknolojileri Gayrimenkul Yatırım Ve Pazarlama A.Ş (bundan böyle kısaca "EMLAKSEPETTE" olarak anılacaktır)"dir. “Portal”da sunulan ve işbu “Kullanım Koşulları”nın 3. maddesinde belirtilen hizmetler, “EMLAKSEPETTE” tarafından sağlanmaktadır.
                1.2. "EMLAKSEPETTE" işbu “Kullanım Koşulları”nı, “Portal”da yer alan her tür bilgi ve “İçerik”i, "KULLANICI"ya herhangi bir ihbarda veya bildirimde bulunmadan dilediği zaman değiştirebilir. Bu değişiklikler periyodik olarak “PORTAL”da yayımlanacak ve yayımlandığı tarihte geçerli olacaktır. “PORTAL” hizmetlerinden belirli bir bedel ödeyerek ya da bedelsiz olarak yararlanan veya herhangi bir şekilde “PORTAL”a erişim sağlayan her gerçek veya tüzel kişi “Kullanım Koşulları”nı ve "EMLAKSEPETTE" tarafından işbu “Kullanım Koşulları”nda yapılan her değişikliği kabul etmiş sayılmaktadır. İşbu " Kullanım Koşulları" internet sitesi üzerinden yayınlanarak; “PORTAL”ı kullanan her gerçek veya tüzel kişi tarafından erişimi mümkün kılınmıştır.
                2. Tanımlar
                "Portal”": www.emlaksepette.com isimli alan adından ve bu alan adına bağlı alt alan adlarından oluşan “EMLAKSEPETTE”nin “Hizmet”lerini sunduğu internet sitesi.
                "Kullanıcı”": “Portal”a erişen her gerçek veya tüzel kişi.
                "Üye”": “Portal”a üye olan ve "Portal" dahilinde sunulan hizmetlerden işbu sözleşmede belirtilen koşullar dahilinde yararlanan “Kullanıcı”.
                "Üyelik”": “Üye” olmak isteyen “Kullanıcı”nın, “Portal”daki üyelik formunu doğru ve gerçek bilgilerle doldurması, verdiği kimlik bilgilerinin “EMLAKSEPETTE” tarafından onaylanması ve bildirimi ile kazanılan statüdür. Üyelik işlemleri tamamlanmadan “Üye” olma hak ve yetkisine sahip olunamaz. “Üyelik” hak ve yükümlülükleri, başvuruda bulunana ait olan, kısmen veya tamamen herhangi bir üçüncü şahsa devredilemeyen hak ve yükümlülüklerdir. “Üyelik” başvurusu herhangi bir sebep gösterilmeksizin “EMLAKSEPETTE” tarafından reddedilebilir veya ek şart ve koşullar talep edilebilir. “EMLAKSEPETTE” gerekli görmesi halinde “Üye”nin “Üyelik” statüsünü sona erdirebilir, “Üyelik”i herhangi bir sebeple sona erenin sonradan yapacağı “Üyelik” başvurusunu kabul etmeyebilir.
                "EMLAKSEPETTE Üyelik Hesabı"": Üye"nin "Portal" içerisinde sunulan hizmetlerden yararlanmak için gerekli olan iş ve işlemleri gerçekleştirdiği, "Üyelik”le ilgili konularda "EMLAKSEPETTE"ye talepte bulunduğu, "Üyelik bilgilerini güncelleyip, sunulan hizmetlerle ilgili raporlamaları görüntüleyebildiği, kendisinin belirlediği ve münhasıran kendisi tarafından kullanılacağını taahhüt ettiği "kullanıcı adı" ve "şifre" ile "Portal" üzerinden eriştiği "Üye"ye özel internet sayfaları bütünü.
                "EMLAKSEPETTE Hizmetleri" ("Hizmet"): "Portal" içerisinde "Üye"nin işbu sözleşme içerisinde tanımlı olan iş ve işlemlerini gerçekleştirmelerini sağlamak amacıyla “EMLAKSEPETTE” tarafından sunulan uygulamalardır. "EMLAKSEPETTE", "Portal" içerisinde sunulan "Hizmet"lerinde dilediği zaman değişiklikler ve/veya uyarlamalar yapabilir. Yapılan değişiklikler ve/veya uyarlamalarla ilgili "Üye"nin uymakla yükümlü olduğu kural ve koşullar “Portal”dan "Üye"ye duyurulur, açıklanan şartlar ve koşullar “Portal”da yayımlandığı tarihte yürürlüğe girer.
                "İçerik": “Portal”da yayınlanan ve erişimi mümkün olan her türlü bilgi, yazı, dosya, resim, video, rakam vb. görsel, yazımsal ve işitsel imgeler.
                "EMLAKSEPETTE Panel": EMLAKSEPETTE ve "Üye"ler tarafından oluşturulan içeriğin "Kullanıcı”lar tarafından görüntülenebilmesi ve "EMLAKSEPETTE Veritabanı"ından sorgulanabilmesi amacıyla "Kullanıcı”lar tarafından kullanılan; 5846 Sayılı Fikir ve Sanat Eserleri Kanunu kapsamında korunan ve tüm fikri hakları “EMLAKSEPETTE”ye ait olan tasarımlar içerisinde “Portal” üzerinden yapılabilecek her türlü işlemin gerçekleştirilmesi için bilgisayar programına komut veren internet sayfaları.
                "EMLAKSEPETTE Veritabanı": “Portal” dahilinde erişilen içeriklerin depolandığı, tasnif edildiği, sorgulanabildiği ve erişilebildiği “EMLAKSEPETTE”e ait olan 5846 Sayılı Fikir ve Sanat Eserleri Kanunu gereğince korunan veritabanıdır.
                3. Emlaksepette Hizmetleri
                3.1. "EMLAKSEPETTE", "Üye"ler tarafından "EMLAKSEPETTE Veritabanı"na yüklenen içeriklerin, arayüzler kullanılmak suretiyle "EMLAKSEPETTE Veritabanı" üzerinden "Kullanıcı”lar tarafından görüntülenebilmesini temin etmektedir.
                3.2. "EMLAKSEPETTE", “Portal” içerisinde "Kullanıcı”ların, "Üye" ilanlarına daha kolay ulaşabilmelerini sağlamak üzere ilanların görüntülenmesini önceliklendiren çeşitli tiplerde listeleme hizmetleri vermektedir.
                3.3. "EMLAKSEPETTE", “Portal” dahilinde gerçekleştirilen işlemlere, görüntüleme sayılarına yönelik çeşitli kategoriler altında raporlama hizmetlerini sunmaktadır.
                3.4. "EMLAKSEPETTE", “Portal” dahilinde verdiği hizmetlere yenilerini ekleme, mevcut hizmetlerin kapsam ve sunulma koşulları ile “Portal” dahilinde erişilen "İçerik"leri her zaman değiştirme, üçüncü kişilerin erişimine kapatabilme ve silme hakkını saklı tutmaktadır. "EMLAKSEPETTE", bu hakkını hiçbir bildirimde bulunmadan ve önel vermeden dilediği biçimde kullanabilir.
                4. Emlaksepette Portalı Kullanımına İlişkin Koşullar ve Yükümlülükler
                4.1. "Kullanıcı”lar hukuka uygun amaçlarla “Portal” üzerinde işlem yapabilirler. "Kullanıcı”ların “Portal” dahilinde yaptığı her işlem ve eylemdeki hukuki ve cezai sorumluluk kendilerine ait olacak olup, söz konusu hukuki ve cezai yükümlülüklerle ilgili “EMLAKSEPETTE”nin herhangi bir sorumluluğu bulunmadığını “Kullanıcı” kabul, beyan ve taahhüt etmektedir.
                4.2. “Portal”, "Üye"ler tarafından "EMLAKSEPETTE Veritabanı"na yüklenen "İçerik"lerin görüntülenmesi esasıyla çalışmaktadır. "EMLAKSEPETTE", "Kullanıcı"lar tarafından görüntülenen ilan ve "İçerik"lerin hiçbir koşulda doğruluğunu, gerçekliği, güvenliğini ve hukuka uygunluğunu garanti etmemektedir. Söz konusu ilan ve "İçerik"ler dolayısıyla “EMLAKSEPETTE”nin herhangi bir sorumluluğu bulunmadığını, ortaya çıkabilecek zararlardan ötürü “EMLAKSEPETTE”nin hiçbir tazmin yükümlülüğü olmayacağını “Kullanıcı”lar kabul ve beyan etmektedir.
                4.3. "Kullanıcı" “Portal” dâhilinde bulunan her türlü resimleri, metinleri, görsel ve işitsel imgeleri, video klipleri, dosyaları, veritabanlarını, katalogları ve listeleri kopyalamayacağını, dağıtmayacağını, işlemeyeceğini, gerek bu eylemleri ile gerekse de başka yollarla "EMLAKSEPETTE" ile doğrudan ve/veya dolaylı olarak rekabete girmeyeceğini, izni ve yetkisi olmayan başka amaçlarla kullanımda bulunmayacağını, kendisine ya da başka bir kişiye ait veritabanı, kayıt veya rehber yaratmak için kullanmayacağını, ticari amaçlarla kullanmayacağını kabul ve taahhüt etmektedir.
                4.4. "Kullanıcı"lar “Portal” dâhilinde Türk Ticaret Kanunu hükümleri uyarınca haksız rekabete yol açacak faaliyetlerde bulunmayacağını, "EMLAKSEPETTE"nin ve üçüncü kişilerin şahsi ve ticari itibarı sarsacak, kişilik haklarına tecavüz veya taarruz edecek fiilleri gerçekleştirmeyeceğini, mevzuata, kamu düzenine ve genel ahlak kurallarına uygun hareket edeceğini, mevzuatın gerektirdiği önlemleri alacağını ve prosedürleri yerine getireceğini, yasadışı, suç teşkil edecek, rahatsız edici, kişilik haklarına zarar verici, fikri haklara, telif haklarına, marka haklarına ve mülkiyet haklarına tecavüz edici tutum ve davranışlarda bulunmayacağını kabul ve taahhüt etmektedir.
                4.5. "Kullanıcı"lar, “Portal” dahilinde eriştikleri bilgileri yalnızca bu bilgileri ifşa eden "Üye" veya "EMLAKSEPETTE"nin amacına uygun olarak kullanmakla, ticari olmayan amaçla görüntülemekle yükümlüdür.
                4.6. "EMLAKSEPETTE", 5651 Sayılı Yasa uyarınca "Yer Sağlayıcılığı Faaliyet Belgesi"ne sahiptir. 5651 Sayılı Yasa ve ilgili mevzuat uyarınca "Yer Sağlayıcı"lara getirilen yükümlülüklere uymak amacıyla "Kullanıcı"ların “Portal” üzerinde gerçekleştirdikleri işlemlere ilişkin ilgili mevzuatta belirtilen nitelikteki kayıtları yasal süresi içinde kayıt altına almakta ve saklamaktadır.
                4.7. "EMLAKSEPETTE", "Kullanıcı" bilgilerini tanıtım ve bilgilendirme amaçlı iletişim faaliyetlerinde, pazarlama faaliyetlerinde ve istatistikî analizler yapmak amacıyla kullanabilir. "EMLAKSEPETTE" aynı zamanda; kullanıcının IP adresi, “Portal”ın hangi bölümlerini ziyaret ettiği, domain tipi, tarayıcı (browser) tipi, tarih ve saat gibi bilgileri de istatistiki değerlendirme ve kişiye yönelik hizmetler ve teklifler sunma gibi amaçlarla kullanabilir.
                4.8. EMLAKSEPETTE, online davranışsal reklamcılık ve pazarlama yapılabilmesi amacıyla siteye gelen kullanıcının sitedeki davranışlarını tarayıcıda bulunan bir cookie (çerez) ile ilişkilendirme ve görüntülenen sayfa sayısı, ziyaret süresi ve hedef tamamlama sayısı gibi metrikleri temel alan yeniden pazarlama listeleri tanımlama, pazarlama otomasyon araçlarını kullanma ve kullanıcıya özel mesaj/teklif ve öneriler iletme hakkını haizdir. Daha sonra bu kullanıcıya sitede ya da Görüntülü Reklam Ağı"ndaki diğer sitelerde, kullanıcıların ilgi alanlarına göre hedefe yönelik reklam içeriği gösterebilir. Ayrıca arama motorları , AFS reklamlarının EMLAKSEPETTE"ye yönlendirilmesi esnasında bu arama motoru kullanıcıların tarayıcısına çerez yerleştirebilir veya bunlarda yer alan çerezleri okuyabilir veya bilgi toplamak amacı ile web işaretleri kullanabilir.
                4.9. “Portal” üzerinden erişilen ve/veya görüntülenen içeriğin depolandığı veritabanına yalnızca ilgili içeriklerin görüntülenmesi amacıyla ve/veya "EMLAKSEPETTE"nin “Kullanım Koşulları” çerçevesinde üçüncü kişilerce erişilmesi hukuka uygundur. Bunun dışındaki yapılan erişimler hukuka aykırı olup; "EMLAKSEPETTE"nin her tür talep, dava ve takip hakları saklıdır.
                4.10. “EMLAKSEPETTE”, “ilanların içeriklerini öğrenme amacıyla görüntülemeye ve “EMLAKSEPETTE Arayüzü”nü kullanmaya izin vermekte olup, bunun dışında bir amaçla veri tabanı üzerinden belirli bir sayıda veya bütününe yönelik olarak ilanlara ulaşılmaya çalışılması, ilanların, müşteri bilgilerinin, tasarımlarının, kod ve yazılımlarının, veri tabanında yer alan bilgilerinin kısmen veya tamamen kopyalanması, bunların başka mecralarda doğrudan veya dolaylı olarak yayınlanması, derlenmesi, işlenmesi, değiştirilmesi, başka veritabanlarına aktarılması, bu veritabanından üçüncü kişilerin erişimine ve kullanımına açılması, “EMLAKSEPETTE” üzerindeki ilanlara link verilmesi de dâhil olmak üzere benzer fiillerin işlenmesine “EMLAKSEPETTE” tarafından izin verilmemekte ve rıza gösterilmemektedir. Bu tür fiiller hukuka aykırı olup; "EMLAKSEPETTE"nin talep, dava ve takip hakları saklıdır.
                4.11. "Portal"in bütününün veya herhangi bir bölümünün bozma, değiştirme, tersine mühendislik yapma amacıyla kullanılması, "Portal"in iletişim veya teknik sistemleri engelleyen, bozan ya da sistemlere müdahale eder bir şekilde "Site"ye erişim sağlanmaya çalışılması, Site üzerinde otomatik program, robot, örümcek, web crawler, örümcek, veri madenciliği (data minig) veri taraması (data trawling) vb. "screen scraping" yazılımları veya sistemleri, otomatik aletler ya da manuel süreçler kullanılması, diğer kullanıcılarının verilerine veya yazılımlarına izinsiz olarak ulaşılması, "Site"nin ve "Portal"deki içeriğin “Kullanım Koşulları” ile belirlenen kullanım sınırları dışında kullanılması hukuka aykırı olup; "EMLAKSEPETTE"nin her tür talep, dava ve takip hakları saklıdır. İşbu şartlara ve yasalara aykırı kullanımın tespiti halinde; “EMLAKSEPETTE”, “Kullanıcı”yı yetkili makamlara bildirme hakkına sahiptir. “Kullanıcı” bu tür kullanımlar sonucu oluşan zarar ve taleplerden “bizzat sorumlu olduğunu kabul etmektedir.
                4.12. “Portal”de verilen hizmetin kesintiye uğraması, bilgi iletiminde aksaklıklar, gecikmeler, başarısızlar yaşanması, veri kaybı halinde oluşabilecek her türlü doğrudan ve dolaylı zararlardan “EMLAKSEPETTE”nin sorumlu tutulamayacağını “Kullanıcı” kabul ve taahhüt etmektedir.
                5. Fikri Mülkiyet Hakları
                Bu “Portal” dahilinde erişilen veya hukuka uygun olarak kullanıcılar tarafından sağlanan bilgiler ve bu “Portal”ın (sınırlı olmamak kaydıyla "EMLAKSEPETTE Veritabanı", "EMLAKSEPETTE Arayüzü", EMLAKSEPETTE MARKASI, tasarım, metin, imge, html kodu ve diğer kodlar) tüm elemanları (hepsi birlikte "EMLAKSEPETTE"in telif haklarına tabi çalışmaları” olarak anılacaktır) "EMLAKSEPETTE"e ait ve/veya "EMLAKSEPETTE" tarafından üçüncü bir kişiden lisans altında alınmıştır. "Kullanıcı"lar, "EMLAKSEPETTE" hizmetlerini, "EMLAKSEPETTE" bilgilerini ve "EMLAKSEPETTE"nin telif haklarına tabi çalışmalarını yeniden satmak, işlemek, kopyalamak, paylaşmak, dağıtmak, sergilemek veya başkasının "EMLAKSEPETTE"nin hizmetlerine erişmesi veya kullanmasına izin vermek hakkına sahip değildirler. İşbu "Site Kullanım Koşulları" dahilinde "EMLAKSEPETTE" tarafından sarahaten izin verilen durumlar haricinde "EMLAKSEPETTE"nin telif haklarına tabi çalışmalarını çoğaltamaz, işleyemez, dağıtamaz veya bunlardan türemiş çalışmalar yapamaz.
                İşbu "Kullanım Koşulları" dahilinde "EMLAKSEPETTE" tarafından sarahaten yetki verilmediği hallerde "EMLAKSEPETTE"; "EMLAKSEPETTE" hizmetleri, "EMLAKSEPETTE" bilgileri, "EMLAKSEPETTE" telif haklarına tabi çalışmaları, "EMLAKSEPETTE" ticari markaları, "EMLAKSEPETTE" ticari görünümü veya bu site vasıtasıyla sağladığı başkaca varlık ve bilgilere yönelik tüm haklarını saklı tutmaktadır.
                6. Kullanım Koşullarında Değişiklikler
                "EMLAKSEPETTE", dilediğinde, tek taraflı olarak işbu "Kullanım Koşulları"nı herhangi bir zamanda “Portal”da ilan ederek değiştirebilir. İşbu "Kullanım Koşulları"nın değişen hükümleri, ilan edildikleri tarihte geçerlilik kazanarak, yürürlüğe girecektir. İşbu "Kullanım Koşulları" “Kullanıcı”nın tek taraflı beyanları ile değiştirilemez.
                7. Mücbir Sebepler
                Hukuken mücbir sebep sayılan tüm durumlarda, geç ifa etme, eksik ifa etme veya ifa etmeme hallerinde "EMLAKSEPETTE"nin herhangi bir tazminat yükümlülüğü doğmayacaktır. "Mücbir sebep", ilgili tarafın makul kontrolü haricinde ve "EMLAKSEPETTE"nin gerekli özeni göstermesine rağmen önleyemediği olaylar olarak yorumlanacak olup, sayılanlarla sınırlı olmamak şartıyla doğal afet, savaş, yangın, grev, ayaklanma, isyan, kötü hava koşulları, altyapı ve internet arızaları, sisteme ilişkin iyileştirme veya yenileştirme çalışmaları ve bu sebeple meydana gelebilecek her türlü arıza, elektrik kesintisi mücbir sebep hallerindendir.
                8. Uygulanacak Hukuk ve Yetki
                İşbu "Kullanım Koşulları" uygulanmasında, yorumlanmasında ve bu "Kullanım Koşulları" dahilinde doğan hukuki ilişkilerin yönetiminde yabancılık unsuru bulunması durumunda Türk kanunlar ihtilafı kuralları hariç olmak üzere Türk Hukuku uygulanacaktır. İşbu “Kullanım Koşulları”ndan dolayı doğan veya doğabilecek her türlü ihtilafın hallinde İstanbul Anadolu Mahkemeleri ve İcra Daireleri yetkilidir.
                9. Yürürlük ve Kabul
                İşbu "Kullanım Koşulları" "EMLAKSEPETTE" tarafından “Portal”de yayınlandığı tarihte yürürlüğe girer. "Kullanıcı"lar işbu ”Kullanım Koşulları”nı ve zaman içinde yapılan değişiklikleri “Portal”ı kullanmakla kabul etmiş olmaktadırlar.
                EK - 2 GİZLİLİK POLİTİKASI
                İşbu Gizlilik Politikası"nın amacı, Master Girişim Bilgi Teknolojileri Gayrimenkul Yatırım Ve Pazarlama A.Ş (“EMLAKSEPETTE” veya “Şirket”) tarafından yönetilmekte olan https://www.emlaksepette.com/ adresinde yer alan web sitesinin, (“Portal”) kullanımına ilişkin koşul ve şartları tespit etmektir. İşbu Gizlilik Politikası"nda tanımlanmayan ifadelerin yorumlanmasında Kullanım ve Üyelik Sözleşmesi"ndeki tanımlar dikkate alınacaktır. Kullanıcılar, Üyelik Sözleşmesi"ni kabul etmeleri üzerine işbu Gizlilik Politikası"nı da kabul etmiş sayılacaktır.
                Üyeler, davet edecekleri Alt Kullanıcı"ların işbu Gizlilik Politikası hükümlerini bizzat onaylamaları gerektiğini kabul etmektedir. Bu doğrultuda Üye belirleyeceği her Alt Kullanıcı"dan: Onay alınacağını, Onay alınmazsa, Alt Kullanıcı"nın Portal"i kullanamayacağını, Her bir Alt Kullanıcı için ayrı ayrı onay alınacağını taahhüt eder.
                EMLAKSEPETTE, teknolojiye yatırım yaparak yenilikçi ürün ve hizmet uygulamaları ile internet alanında Kullanıcılarına daha iyi hizmet vermek için sürekli kendisini yenilemekte ve en iyi hizmeti verebilmek için çalışmaktadır.
                EMLAKSEPETTE, online davranışsal reklamcılık ve pazarlama yapılabilmesi amacıyla siteye gelen Kullanıcı"nın üye olmasalar dahi sitedeki davranışlarını tarayıcıda bulunan bir cookie (çerez) ile ilişkilendirme ve görüntülenen sayfa sayısı, ziyaret süresi ve hedef tamamlama sayısı gibi metrikleri temel alan yeniden pazarlama listeleri tanımlama hakkını haizdir. Daha sonra bu Kullanıcı"ya sitede ya da Görüntülü Reklam Ağı"ndaki diğer sitelerde, Kullanıcılar"ın ilgi alanlarına göre hedefe yönelik reklam içeriği gösterilebilir.
                Google AFS reklamlarının EMLAKSEPETTE"ye yönlendirilmesi esnasında Google kullanıcıların tarayıcısına çerez yerleştirebilir veya bunlarda yer alan çerezleri okuyabilir veya bilgi toplamak amacı ile web işaretleri kullanabilir.
                Gizlilik Politikası Üzerinde Gerçekleşecek Olan Değişiklikler
                EMLAKSEPETTE, işbu Gizlilik Politikası hükümlerini dilediği zaman Portal üzerinden yayımlamak suretiyle güncelleyebilir ve değiştirebilir. EMLAKSEPETTE"in Gizlilik Politikası"nda yaptığı güncelleme ve değişiklikler Portal"da yayınlandığı tarihten itibaren geçerli olacaktır.
                Kullanıcı, işbu Gizlilik Politikası"na konu bilgilerinin tam, doğru ve güncel olduğunu, bu bilgilerde herhangi bir değişiklik olması halinde bunları derhal info@emlaksepette.com adresinden güncelleyeceğini taahhüt eder. Kullanıcı"nın güncel bilgileri sağlamamış olması halinde EMLAKSEPETTE"in herhangi bir sorumluluğu olmayacaktır.
                EK - 3 EMLAKSEPETTE HİZMETLERİ
                1. "EMLAKSEPETTE" İlan Hizmetleri
                1.1. "Üye", "EMLAKSEPETTE Üyelik Hesabı" üzerinden bireysel ilan yayınlayamaz. Üye, EMLAKSEPETTE’ye gayrimenkul ilanı verme talebi ile kayıt formu doldurduğunda EMLAKSEPETTE tarafından gayrimenkul danışmanı veya emlak ofisine yönlendirilecektir. Üye, "EMLAKSEPETTE" tarafından belirlenen kurallara uygun olarak kayıt formunu yaratacak ve EMLAKSEPETTE Veritabanı"na yükleyecektir.
                1.2. "EMLAKSEPETTE", "Üye" tarafından oluşturulan ilan/ilanları değerlendirmeye alacak; bahsi geçen ilanların "Portal"da yönlendirilen gayrimenkul danışmanları veya emlak ofisleri tarafından yayınlanmasını kabul veya reddedecektir. "EMLAKSEPETTE", ilanların değerlendirmesine yönelik kriterleri, koşulları ve süreleri serbestçe tayin ve tespit ederek, “Portal”da yayınlayacaktır.
                1.3. "EMLAKSEPETTE", “Portal”da yayınlanan ilanların hukuka ve ahlaka aykırı olması, başkalarının şahsi ve ticari haklarına tecavüz edici nitelik taşıması veya bu yönde yapılan ihtarlara muhatap olması veya işbu sözleşme ve “Portal”da yer alan kural ve koşullara doğrudan veya dolaylı olarak aykırı olması gibi sebeplerle "Üye"ye herhangi bir ihtarda bulunmadan ilgili ilanının yayınını geçici veya sürekli olarak durdurabilir. "EMLAKSEPETTE" bahsi geçen duruma ilişkin "Üye"ye herhangi bir geri ödemede bulunmayacağını, aynı şekilde "Üye" de ödemiş olduğu bedel var ise bedelin iadesini "EMLAKSEPETTE"den talep ve dava etmeyeceğini kabul, beyan ve taahhüt eder.
                1.4. "EMLAKSEPETTE", "Üye"nin ilanlarının ve ilan içerisindeki metin, resim ve içeriklerin başka sitelerde, arama motorlarında ve “EMLAKSEPETTE” ilan ve reklamlarında görüntülenebilmesi için üçüncü kişilerle anlaşma yapabilir. "Üye", bu konuda "EMLAKSEPETTE"e yetki verdiğini işbu sözleşmede açıklıkla beyan ve kabul etmektedir.
                1.5. "Üye", "EMLAKSEPETTE Üyelik Hesabı" üzerinden yaptığı her türlü iş ve işlemin sorumluluğunun kendisine ait olduğunu; burada gerçekleştirilen iş ve işlemleri kendisinin gerçekleştirmediği yolunda herhangi bir def"i ve/veya itiraz ileri süremeyeceğini ve/veya bu def"i veya itiraza dayanarak yükümlülüklerini yerine getirmekten kaçınmayacağını kabul, beyan ve taahhüt eder.
                1.6. "Üye", "Portal"da yayınlayacağı ilanlarda karalama, kötüleme, ticari iftira atma, tehdit veya taciz etme gibi hukuka aykırı her türlü fiili gerçekleştirmeyeceğini, "Portal"ın altyapısını gerekçesiz ya da aşırı derecede yük getirecek girişimlerde ve eylemlerde bulunmayacağını, yüz kızartıcı, pornografik veya ahlaka aykırı içerikli metinlerin ve görsellerin "Portal"da yayınlanacak reklamlarda yer almasına izin vermeyeceğini kabul, beyan ve taahhüt eder.
                1.7. "Üye", "Portal"da yayınlattığı ilanlarda gerçek, doğru ve hukuka uygun bilgilerle mal ve hizmetlerinin reklam ve tanıtımını yapacaktır. "Üye"nin hukuken üzerinde ilanında belirttiği şekilde tasarruf yetkisi olmayan, mal ve hizmetlere ilişkin ilan vermesi yasaktır. Bu kapsamda ilan veren "Üye"ler için "EMLAKSEPETTE", "Üye"ye herhangi bir ihtarda bulunmaya gerek olmadan "Üye"liğini askıya alabilir, "Üye"likten çıkarabilir, "Üye"likten geçici bir süre uzaklaştırabilir, işbu sözleşmeyi herhangi bir geri ödeme yükümlülüğü olmadan tek taraflı olarak feshedebilir.
                1.8. "Üye", tüketicinin korunması, fikri haklar, haksız rekabet, reklam konularını düzenleyenler dahil ancak bunlarla sınırlı olmaksızın herhangi bir mevzuata aykırı ilan vermeyeceğini ve ilanlarında bu mevzuatlara aykırı beyanların; resim, video gibi görsellerin bulunmayacağını kabul, beyan ve taahhüt eder.
                1.9. “Üye”, kendisine ait ilanlarını "Portal"da detaylı olarak açıklandığı ve sınırları belirtildiği üzere, kendisine ait bir bölümde, kendisi tarafından belirlenen içerik ve bilgilerle birlikte "Portal" üzerinden yayınlayabilir. Üye"nin işbu madde içerisinde belirtilen şekilde ilanlarını yayınlayabilmesi için, işbu sözleşmenin haricinde, "Portal"da belirtilen bedelleri ödemesi, bu bölümde belirtilen kural ve koşullara uyması ve uyacağını kabul, beyan ve taahhüt etmesi gerekmektedir.
                1.10. "Üye", farklı bir kullanıcı adı kullanmak suretiyle birden fazla "EMLAKSEPETTE Üyelik Hesabı" açmamayı kabul, beyan ve taahhüt eder. Bu kuralın ihlali veya herhangi bir sebeple "Üye"likten çıkarılan, "Üye"liği durdurulan veya askıya alınan birisinin tekrar Portal"a girmek için farklı bir kullanıcı adı ile bir veya daha fazla "EMLAKSEPETTE Üyelik Hesabı" açtığının, EMLAKSEPETTE tarafından tespit edilmesi halinde; EMLAKSEPETTE"in, bu kişinin tüm "EMLAKSEPETTE Üyelik Hesapları"nı, herhangi bir ihtara gerek olmaksızın iptal etme ve işbu sözleşmeyi herhangi bir geri ödeme yükümlülüğü olmadan tek taraflı olarak feshetme yetkisi olacaktır.
                2. Listeleme Hizmetleri
                2.1. Bu “Hizmet” “Üye”lerin “EMLAKSEPETTE Üyelik Hesabı” üzerinden girmiş oldukları ilan içeriklerinin Emlak Ofisleri veya Gayrimenkul danışmanları tarafından “EMLAKSEPETTE” “Portal”ında yer alan kategoriler altında görüntülenmesinin sağlanmasıdır. Listeleme; “EMLAKSEPETTE” “portal”ının dinamik alt yapısı üzerinden “Kullanıcı”ların ilgili kategoriler altında özelleştirdikleri sorguları doğrultusunda “Üye”lere ait ilanların “Kullanıcı” tarafından “EMLAKSEPETTE” tarafından belirlenen sıra dahilinde “EMLAKSEPETTE” ara yüzü üzerinden görüntülenmesidir. Listeleme; “EMLAKSEPETTE” veritabanına gelen sorguların “EMLAKSEPETTE” veritabanı üzerinde çalışan bilgisayar programının döneceği otomatik yanıtların “Kullanıcı”ya gösterilmesi esasına dayanır. 
                2.2. İlanlarının hangi kategori altında görüntüleneceğinin seçimi öncelikle “Üye”ye aittir. “Üye”nin belirlediği kategorinin ilanının konusuyla ilişkili olmaması durumunda “EMLAKSEPETTE” ilgili ilanının konusuyla ilişkili olan kategori altında görüntülenmesini “Üye”ye herhangi bir bildirimde bulunmadan sağlayabilir.
                3. Panel Hizmetleri
                3.1. “Üye”lerin “EMLAKSEPETTE Üyelik Hesabı” üzerinden girmiş oldukları ilan içeriklerinin EMLAKSEPETTE’ye üye emlak ofisleri ve gayrimenkul danışmanları tarafından “panel” adı altında oluşturulacak sayfalar toplu olarak gösterilmesini sağlayan hizmettir.
                3.2. “Üye”  diğer kurumsal satış ofisleri, gayrimenkul danışmanları, emlak ofisleri veya turizm acentelerinin ilanlarına toplu olarak ulaşabilir. Üye toplu ilanları kategorisine göre listeleyebilir. Üye satın almak talebi ile gayrimenkulu sepete ekleyerek kapora ücretini emaneten ödeyerek gayrimenkul alım ve satım faaliyetini gerçekleştirebilir.
                3.3. “Üye”, EMLAKSEPETTE sistemi üzerinden turizm amacıyla haftalık veya günlük gayrimenkul kiralayabilir. Üye, kiralamak istediği gayrimenkulun müsait olduğu tarih aralıklarını sistemden seçer ve sepete ekler. Üye sepette belirlenen kapora ücretini sisteme ödedikten sonra kiralanmak istenen gayrimenkul Üye adına opsiyonlanır. EMLAKSEPETTE portala ödenen kapora ücreti toplam kiralama bedelinden kiralama anında düşülür. 
                3.4. Panel Hizmetlerinin kullanım ve yararlanma koşulları Portalın ilgili bölümünde “Üye”lere yönelik açıklamalarda belirtilir. “Üye”ler bu açıklamalarda belirtilen koşullara uymakla mükelleftir.
                4. Ek Hizmetler
                "Üye"ler, yukarıda sayılan temel "hizmet"lere ek olarak "Portal"dan duyurulan ve kullanım koşulları “Portal”ın ilgili kısımlarında belirtilen "Hizmet"lerden, eğer ilgili hizmet için bir ücret öngörülmüşse belirtilen ücreti ödeyerek yararlanabilirler. "Üye"ler "EMLAKSEPETTE" tarafından işbu madde kapsamında tanımlanan ve "Portal"ın ilgili bölümünde duyurulan hizmetlere ilişkin "Portal"ın ilgili bölümünde yapılan açıklamalar çerçevesindeki yükümlülüklere uyacağını kabul ve taahhüt etmektedir
                EK - 4 İLAN VERİLMESİ, SATIŞA ARZI, LİSTELENMESİ YASAKLI ÜRÜN VE HİZMETLER
                EMLAKSEPETTE.com portalında ilanı verilmesi, satışa arzı ve listelenmesi yasaklı olan ürün ve hizmetler sınırlı sayıda olmamak üzere web sitesinde belirtilmektedir.
                EMLAKSEPETTE bu ürün ve hizmetlere ilişkin portalın ilgili bölümünde yapacağı açıklamalar doğrultusunda web stesinde örnek olarak belirtilen ürün ve hizmetlere eklemeler yapabilir.
                “Üye”ler EMLAKSEPETTE portalında belirtilen ilanı verilmesi, satışa arzı ve listelenmesi yasaklı olan ürün ve hizmetleri güncel olarak takip etmek ve verdiği ilanlarının bu özellikleri taşımadığından emin olmak zorundadır.
                EMLAKSEPETTE; satılık, kiralık,devren türlerinde konut, işyeri, arsa kategorilerinde ilan listelemektedir. Bu tür ve kategoriler dışında ilanları siteden nedensiz, sebeb göstermeksizin yayından kaldırabilir.
                CAYMA HAKKI
                Üye işbu Sözleşmeyi elektronik ortamda kabul ettiği tarihten itibaren 14 (ondört) gün içinde herhangi bir gerekçe göstermeksizin ve cezai şart ödemeksizin sözleşmeden cayma hakkına sahiptir. Cayma hakkının kullanıldığına dair bildirim bu süre içinde yazılı olarak veya info@emlaksepette.com adresine e-posta gönderilmesi suretiyle yapılabileceği gibi Müşteri’nin cayma kararını bildiren açık bir beyanının süresi içinde EMLAKSEPETTE’ye iletilmesi suretiyle de kullanılabilir. Üye, cayma hakkı sona ermeden Üye’nin onayı ile ilanın yayınına başlanmışsa bu hakkını kullanamaz.
                
            </div>
          </div>
        </div>
      </div> --}}
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
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
      <script>
        $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();
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
