@extends('client.layouts.masterPanel')

@section('content')
    {{-- <div class="content">
        <div class="row">
            <div class="col-lg-12">
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
                                    

                                    @if (Auth::check() && Auth::user()->has_club == 1)
                                        <div class="mt-3">
                                            <label class="q-label">Iban Numarası</label>
                                            <input type="text" name="iban" class="form-control"
                                                value="{{ old('iban', $user->iban) }}" oninput="formatIBAN(this)">
                                        </div>
                                    @endif


                                    @if (Auth::check() && Auth::user()->type == 2)
                                        <div class="mt-3">
                                            <label class="q-label">Website Linki</label>
                                            <input type="url" name="website" class="form-control"
                                                value="{{ old('website', $user->website) }}">
                                        </div>
                                       
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
                                                                'Anadolu Yakası' => '216',
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
                                                            'Zonguldak' => '372',
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
                                                <input type="text" name="phone" id="phone" class="form-control"
                                                    value="{{ old('phone', $user->phone) }}" maxlength="10">
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

                        <div>
                            <h5>Cep Telefonu Güncelleme</h5>
                        </div>

                        <div>
                            <form action="{{ route('institutional.edit.phone') }}" method="POST"
                                enctype="multipart/form-data" onsubmit="return validateForm2()">
                                @csrf
                                @method('PUT')

                                <div class="corporate-form row" id="corporateForm">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mt-3">
                                                <div class="form-group">
                                                    <label for="mobile_phone">Mevcut Telefon Numarası</label>
                                                    <input type="text" class="form-control" id="current_mobile_phone"
                                                        value="{{ old('mobile_phone', $user->mobile_phone) }}" disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="new_mobile_phone">Yeni Telefon Numarası</label>
                                                    <input type="text" class="form-control" id="mobile_phone"
                                                        name="mobile_phone" placeholder="5xxxxxxxxxx" required>
                                                    <div class="invalid-feedback">
                                                        Telefon numarası boş bırakılamaz.
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div id="phoneFields">
                                                <label class="q-label mt-3">Belge Ekle</label>
                                                <div class="" style="position: relative;">
                                                    <!-- Resmin boyutunu küçültmek için max-width ve max-height stil özellikleri ekleyelim -->
                                                    <img src="" alt="Yüklenen Resim" id="uploadedImage"
                                                        style="display: none; max-width: 200px; max-height: 200px; border: 1px solid #ccc;">
                                                </div>
                                                <input type="file" name="image" id="image" class="form-control"
                                                    required>
                                                <div class="invalid-feedback">
                                                    Belge seçilmelidir ve uygun bir formatta olmalıdır.
                                                </div>
                                                <p class="text-danger mt-2">Lütfen Belge Formatına Uygun Görsel Ekleyiniz.
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-primary mt-4">Güncelle</button>

                                    </div>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5 col-12">
                <div class="card shadow-sm border-100 border-bottom mb-4">
                    <div class="card-body">

                        <img class="img-fluid mx-auto d-block"
                            src="{{ asset('images/phone-update-image/phonefile.jpg') }}" alt="Örnek Resim">

                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="table-breadcrumb mb-5 pl-4">
        <ul>
            <li>
                Hesabım
            </li>
            <li>
               Profil Düzenleme
            </li>
        </ul>
    </div>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 ">
                    <div
                        class="bg-solitude-blue border-radius-6px p-45px lg-p-30px mb-25px bg-white shadow-sm p-3 mb-5 bg-body-tertiary rounded">
                        {{-- <span class="fs-19 alt-font text-dark-gray fw-700 mb-20px d-inline-block">Maliyetine Ev</span> --}}
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <div>
                                <div>
                                    <p>Profil</p>
                                </div>

                                <div>
                                    <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                                        href="#v-pills-home" role="tab" aria-controls="v-pills-home"
                                        aria-selected="true">Genel Bilgiler</a>
                                    <a class="nav-link " id="v-pills-phone-tab" data-bs-toggle="pill" href="#v-pills-phone"
                                        role="tab" aria-controls="v-pills-phone" aria-selected="false">Cep Telefonu</a>

                                    @if (Auth::check() && Auth::user()->type == 1)
                                        <a class="nav-link " id="v-pills-photo-tab" data-bs-toggle="pill"
                                            href="#v-pills-photo" role="tab" aria-controls="v-pills-photo"
                                            aria-selected="false">Profil
                                            Fotoğrafı</a>
                                    @endif
                                </div>
                            </div>

                            @if (Auth::check() && Auth::user()->type == 2)
                                <div>
                                    <div>
                                        <p>Firma</p>
                                    </div>
                                    <div>
                                        <a class="nav-link" id="v-pills-info-tab" data-bs-toggle="pill" href="#v-pills-info"
                                            role="tab" aria-controls="v-pills-info" aria-selected="false">Genel Bilgiler
                                        </a>
                                        <a class="nav-link" id="v-pills-map-tab" data-bs-toggle="pill" href="#v-pills-map"
                                            role="tab" aria-controls="v-pills-map" aria-selected="false">Konum </a>

                                        <a class="nav-link " id="v-pills-photo-tab" data-bs-toggle="pill"
                                            href="#v-pills-photo" role="tab" aria-controls="v-pills-photo"
                                            aria-selected="false">Logo
                                        </a>

                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                            aria-labelledby="v-pills-home-tab">

                            <div class="col-lg-12 col-md-12 col-xs-12 widget-boxed mt-33 mt-0 ">

                                <h4>Profil Bilgilerini Güncelleme</h4>
                                <div class="row">
                                    <div class="col-6 agent-contact-form-sidebar">
                                        <div class="sidebar-widget author-widget2">
                                            <div class="">
                                                @if (isset($user->profile_image) && !empty($user->profile_image))
                                                    <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}"
                                                        alt="author-image" class="author__img"
                                                        style="border: 4px solid {{ $user->banner_hex_code ? $user->banner_hex_code : '#000' }};">
                                                @else
                                                    <div class="author__initials">
                                                        {{ getInitials($user->name) }}
                                                    </div>
                                                @endif
                                                <h4 class="author__title">{!! $user->name !!}</h4>
                                                <p class="author__meta">{!! $user->corporate_type !!}</p>
                                            </div>
                                            <ul class="author__contact">
                                                {{-- <li><span class="la la-map-marker"><i class="fa fa-map-marker"></i></span>302 Av Park, New York</li> --}}
                                                <li><span class="la la-phone"><i class="fa fa-phone"
                                                            aria-hidden="true"></i></span><a
                                                        href="#">{!! $user->mobile_phone !!}</a></li>
                                                <li><span class="la la-envelope-o"><i class="fa fa-envelope"
                                                            aria-hidden="true"></i></span><a
                                                        href="#">{!! $user->email !!}</a></li>
                                                <li><span class="la la-envelope-o"><i class="far fa-address-card"
                                                            aria-hidden="true"></i></span><a
                                                        href="#">{!! $user->iban !!}</a></li>
                                            </ul>

                                        </div>
                                    </div>

                                    <div class="col-6">

                                        <div class="agent-contact-form-sidebar">
                                            <form name="contact_form" method="POST" enctype="multipart/form-data"
                                                action="{{ route('institutional.individual.profile.update') }}">
                                                @csrf
                                                <label for="name">Ad Soyad</label>
                                                <input type="text" id="name" name="name" placeholder="Ad Soyad"
                                                    class="form-control @error('name') is-invalid @enderror" required
                                                    value="{!! $user->name !!}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <label for="iban">İban Numarası</label>
                                                <input type="text" id="iban" name="iban" placeholder="İban"
                                                    class="form-control @error('iban') is-invalid @enderror" required
                                                    value="{!! $user->iban !!}" oninput="formatIBAN(this)">
                                                @error('iban')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <button type="submit" class="btn btn-primary">
                                                    Güncelle </button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="v-pills-phone" role="tabpanel"
                            aria-labelledby="v-pills-phone-tab">


                            <div class="row widget-boxed mt-33 mt-0 ">
                                <div class="col-6">
                                    <h4>Telefon Numarasını Güncelleme</h4>

                                    <div class="agent-contact-form-sidebar">
                                        <form name="contact_form" method="POST" enctype="multipart/form-data" action="{{ route('institutional.edit.phone') }}">
                                            @csrf
                                    
                                            <!-- Mevcut telefon numarası, sadece görüntüleme -->
                                            <input type="text" id="phone" name="phone" placeholder="Mevcut Telefon Numarası" value="{!! $user->mobile_phone !!}" disabled>
                                    
                                            <!-- Yeni telefon numarası için doğrulama -->
                                            <input type="text" id="new_phone_number" name="new_phone_number" placeholder="Yeni Telefon Numarası" required maxlength="11" pattern="\d{10,11}" title="Telefon numarası 10 veya 11 rakamdan oluşmalıdır." class="@error('new_phone_number') is-invalid @enderror">
                                    
                                            <!-- Hata mesajı için yer -->
                                            <div id="error-message" class="error-message">
                                                @error('new_phone_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                    
                                            <!-- Yüklenen dosyanın JSON verisi için gizli alan -->
                                            <input type="hidden" id="form2_file_input" name="uploaded_file" value="">
                                    
                                            <!-- Gönder butonu -->
                                            <button type="submit" class="btn btn-primary">Güncelle</button>
                                        </form>
                                    </div>

                                </div>

                                <div class="col-6">

                                    <div class="container mt-5">
                                        <form action="/file-upload" class="dropzone" id="myDropzone">
                                            <div class="fallback">
                                                <input name="file" type="file" multiple />
                                            </div>
                                        </form>
                                        <!-- FontAwesome İkonlu Metin veya İkon -->
                                        <div class="mt-4 ml-4">
                                            <i class="fas fa-exclamation-circle" id="popoverContent"
                                                data-toggle="popover" data-trigger="hover" data-placement="top"
                                                title="Yüklenmesi Gereken Belge Detayı">
                                                Yüklemeniz Gereken Belge Detayı
                                            </i>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        @if (Auth::check() && Auth::user()->type == 1)
                            <div class="tab-pane fade" id="v-pills-photo" role="tabpanel"
                                aria-labelledby="v-pills-photo-tab">
                                <div class="card shadow-sm border-300 border-bottom mb-4">


                                    <div class="row widget-boxed mt-33 mt-0">
                                        <div class="col-6">
                                            <h4>Profil Fotoğrafını Güncelleme</h4>
                                            <div class="agent-contact-form-sidebar">
                                                <div class="image-preview-container">
                                                    @if (isset($user->profile_image) && !empty($user->profile_image))
                                                        <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}"
                                                            alt="author-image" id="profileImagePreview"
                                                            alt="Profil Resmi Önizleme">
                                                    @else
                                                        <img id="profileImagePreview" src="#"
                                                            alt="Profil Resmi Önizleme" />
                                                    @endif
                                                </div>

                                                <!-- Özel renk seçici -->


                                            </div>


                                            <form name="contact_form" method="POST" enctype="multipart/form-data"
                                                action="{{ route('institutional.profile.image') }}">
                                                @csrf
                                                <div class="col-md-4">
                                                    <input type="hidden" id="form_file_input" name="uploaded_file"
                                                        value="">

                                                    <input type="color" id="customColorPicker"
                                                        class="custom-color-picker" name="banner_hex_code"
                                                        title="Arka Plan Rengi Seçin" value="$user->banner_hex_code">
                                                </div>
                                                <div class="col-md-4 pt-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        Güncelle </button>
                                                </div>

                                            </form>



                                        </div>




                                        <div class="col-md-6">

                                            <div class="container mt-5" style="padding-top: 30px !important;">
                                                <form action="/file-upload" class="dropzone" id="profileImageDropzone">
                                                    <div class="fallback">
                                                        <input name="file" type="file" multiple />
                                                    </div>
                                                </form>
                                            </div>

                                        </div>

                                    </div>


                                </div>

                            </div>
                        @endif


                        @if (Auth::check() && Auth::user()->type == 2)
                            <div class="tab-pane fade" id="v-pills-photo" role="tabpanel"
                                aria-labelledby="v-pills-photo-tab">
                                <div class="card shadow-sm border-300 border-bottom mb-4">


                                    <div class="row widget-boxed mt-33 mt-0">
                                        <div class="col-6">
                                            <h4>Logo Güncelleme</h4>
                                            <div class="agent-contact-form-sidebar">
                                                <div class="image-preview-container">
                                                    @if (isset($user->profile_image) && !empty($user->profile_image))
                                                        <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}"
                                                            alt="author-image" id="profileImagePreview"
                                                            alt="Profil Resmi Önizleme">
                                                    @else
                                                        <img id="profileImagePreview" src="#"
                                                            alt="Profil Resmi Önizleme" />
                                                    @endif
                                                </div>

                                                <!-- Özel renk seçici -->

                                            </div>


                                            <form name="contact_form" method="POST" enctype="multipart/form-data"
                                                action="{{ route('institutional.profile.image') }}">
                                                @csrf
                                                <div class="col-md-4">
                                                    <input type="hidden" id="form_file_input" name="uploaded_file"
                                                        value="">

                                                    <input type="color" id="customColorPicker"
                                                        class="custom-color-picker" name="banner_hex_code"
                                                        title="Arka Plan Rengi Seçin" value="$user->banner_hex_code">
                                                </div>
                                                <div class="col-md-4 pt-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        Güncelle </button>
                                                </div>

                                            </form>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="container mt-5" style="padding-top: 30px !important;">
                                                <form action="/file-upload" class="dropzone" id="profileImageDropzone">
                                                    <div class="fallback">
                                                        <input name="file" type="file" multiple />
                                                    </div>
                                                </form>
                                            </div>

                                        </div>

                                    </div>


                                </div>

                            </div>
                        @endif



                        @if (Auth::check() && Auth::user()->type == 2)
                            <div class="tab-pane fade" id="v-pills-info" role="tabpanel"
                                aria-labelledby="v-pills-info-tab">
                                <div class="card shadow-sm border-300 border-bottom mb-4">
                                    <div class="col-lg-12 col-md-12 col-xs-12 widget-boxed mt-33 mt-0 ">

                                        <h4>Firma Bilgilerini Güncelleme</h4>
                                        <div class="agent-contact-form-sidebar">
                                            <form name="contact_form" method="POST" enctype="multipart/form-data"
                                                action="{{ route('institutional.profile.company.update') }}">
                                                @csrf


                                                <div class="col-6">
                                                    <label for="name">Firma Adı</label>
                                                    <input type="text" id="name" name="name"
                                                        placeholder="Firma Adı" required
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        value="{!! $user->name !!}">

                                                    @error('full_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror

                                                    <label for="iban">İban Numarası</label>
                                                    <input type="text" id="iban" name="iban"
                                                        placeholder="İban"
                                                        class="form-control @error('iban') is-invalid @enderror" required
                                                        value="{!! $user->iban !!}" oninput="formatIBAN(this)">
                                                    @error('iban')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror

                                                    <label for="web_site">Web Sitesi</label>
                                                    <input type="text" id="fweb" name="web_site"
                                                        placeholder="Web Sitesi Linki"
                                                        class="form-control @error('web_site') is-invalid @enderror"
                                                        required value="{!! $user->website !!}">

                                                    @error('web_site')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <label for="phone_number">Sabit Telefon</label>
                                                    <div class="row">

                                                        <div class="col-6">
                                                            <select name="area_code" id="area_code"
                                                                class="form-control m-1">
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
                                                                        'Anadolu Yakası' => '216',
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
                                                                    'Zonguldak' => '372',
                                                                ];
                                                                
                                                                foreach ($alanKodu as $cityName => $cityCode) {
                                                                    if (is_array($cityCode)) {
                                                                        echo '<optgroup label="' . $cityName . '">';
                                                                        foreach ($cityCode as $subCityName => $subCityCode) {
                                                                            $selected = $subCityCode == $user->area_code ? 'selected' : '';
                                                                            echo '<option value="' . $subCityCode . '" ' . $selected . '>' . $subCityName . ' (' . $subCityCode . ')' . '</option>';
                                                                        }
                                                                        echo '</optgroup>';
                                                                    } else {
                                                                        $selected = $cityCode == $user->area_code ? 'selected' : '';
                                                                        echo '<option value="' . $cityCode . '" ' . $selected . '>' . $cityName . ' (' . $cityCode . ')' . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-6">

                                                            <input type="tel" id="phone_number" name="phone_number"
                                                                class="form-control @error('phone_number') is-invalid @enderror"
                                                                placeholder="Sabit Telefon" required
                                                                value="{!! $user->phone !!}">

                                                            @error('phone_number')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                    <label for="sector_year">Kaç Yıldır Sektördesiniz?</label>
                                                    <input type="number" id="fsector" name="sector_year"
                                                        placeholder="Kaç Yıldır Sektördesiniz?" required
                                                        class="form-control @error('sector_year') is-invalid @enderror"
                                                        value="{!! $user->year !!}">
                                                    @error('sector_year')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror

                                                </div>



                                                <div class="col-6">
                                                    <div class="mt-3">
                                                        <label class="q-label">Ticari Unvan
                                                            <i class="info-icon fas fa-info-circle" data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="Firma adını kısaltmadan aynen yazınız."></i>
                                                        </label>

                                                        <input type="text" name="store_name"
                                                            class="form-control {{ $errors->has($user->store_name) ? 'error-border' : '' }}"
                                                            value="{{ $user->store_name }}">
                                                        @if ($errors->has($user->store_name))
                                                            <span
                                                                class="error-message">{{ $errors->first($user->store_name) }}</span>
                                                        @endif
                                                    </div>


                                                    <div class="mt-3">
                                                        <label for="corporate-account-type" class="q-label">Faaliyet
                                                            Alanı</label>
                                                        <select name="corporate-account-type" id="corporate-account-type"
                                                            class="form-control {{ $errors->has($user->corporate_type) ? 'error-border' : '' }}">
                                                            <option value="" disabled selected>Seçiniz</option>
                                                            <option value="Emlak Ofisi"
                                                                {{ $user->corporate_type == 'Emlak Ofisi' ? 'selected' : '' }}>
                                                                Emlak Ofisi</option>
                                                            <option value="Banka"
                                                                {{ $user->corporate_type == 'Banka' ? 'selected' : '' }}>
                                                                Banka</option>
                                                            <option value="İnşaat Ofisi"
                                                                {{ $user->corporate_type == 'İnşaat Ofisi' ? 'selected' : '' }}>
                                                                İnşaat Ofisi</option>
                                                            <option value="Turizm Amaçlı Kiralama"
                                                                {{ $user->corporate_type == 'Turizm Amaçlı Kiralama' ? 'selected' : '' }}>
                                                                Turizm Amaçlı Kiralama</option>
                                                        </select>
                                                        @if ($errors->has($user->corporate_type))
                                                            <span
                                                                class="error-message">{{ $errors->first($user->corporate_type) }}</span>
                                                        @endif
                                                    </div>


                                                    <!-- İl -->
                                                    <div class="mt-3">
                                                        <label for="" class="q-label">İl</label>
                                                        <select
                                                            class="form-control {{ $errors->has($user->city_id) ? 'error-border' : '' }}"
                                                            id="citySelect" name="city_id">
                                                            <option value="">Seçiniz</option>
                                                            @foreach ($towns as $item)
                                                                <option for="{{ $item['sehir_title'] }}"
                                                                    value="{{ $item['sehir_key'] }}"
                                                                    {{ $user->city_id == $item['sehir_key'] ? 'selected' : '' }}>
                                                                    {{ $item['sehir_title'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has($user->city_id))
                                                            <span
                                                                class="error-message">{{ $errors->first($user->city_id) }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="" class="q-label">İlçe</label>
                                                        <select
                                                            class="form-control {{ $errors->has($user->county_id) ? 'error-border' : '' }}"
                                                            name="county_id" id="countySelect">
                                                            <option value="{{ $user->county_id }}">Seçiniz</option>
                                                        </select>
                                                        @if ($errors->has($user->county_id))
                                                            <span
                                                                class="error-message">{{ $errors->first($user->county_id) }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="" class="q-label">Mahalle</label>
                                                        <select
                                                            class="form-control {{ $errors->has($user->neighborhood_id) ? 'error-border' : '' }}"
                                                            name="neighborhood_id" id="neighborhoodSelect">
                                                            <option value="{{ $user->neighborhood_id }}">Seçiniz</option>
                                                        </select>
                                                        @if ($errors->has($user->neighborhood_id))
                                                            <span
                                                                class="error-message">{{ $errors->first($user->neighborhood_id) }}</span>
                                                        @endif
                                                    </div>
                                                    @php
                                                        // Gelen account_type verisini kontrol ederek uygun değeri belirleyin

                                                        $account_type =
                                                            $user->account_type == 'Limited veya Anonim Şirketi'
                                                                ? 1
                                                                : 2;

                                                    @endphp
                                                    <!-- İşletme Türü -->
                                                    <div class="mt-3">
                                                        <label for="" class="q-label">İşletme Türü</label>
                                                        <div class="companyType">
                                                            <label for="of">
                                                                <input type="radio" class="input-radio off"
                                                                    id="of" name="account_type"
                                                                    value="Şahıs Şirketi"
                                                                    {{ $account_type == 1 ? 'checked' : '' }}> Şahıs
                                                                Şirketi
                                                            </label>
                                                            <label for="on">
                                                                <input type="radio" class="input-radio off"
                                                                    id="on" name="account_type"
                                                                    value="Limited veya Anonim Şirketi"
                                                                    {{ $account_type == 2 ? 'checked' : '' }}> Limited veya
                                                                Anonim Şirketi
                                                            </label>
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
                                                                        class="form-control {{ $errors->has($user->taxOfficeCity) ? 'error-border' : '' }}"
                                                                        name="taxOfficeCity">
                                                                        <option value="">Seçiniz</option>
                                                                        @foreach ($cities as $item)
                                                                            <option value="{{ $item['title'] }}"
                                                                                {{ $user->taxOfficeCity == $item['title'] ? 'selected' : '' }}>
                                                                                {{ $item['title'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if ($errors->has($user->taxOfficeCity))
                                                                        <span
                                                                            class="error-message">{{ $errors->first($user->taxOfficeCity) }}</span>
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
                                                                        class="form-control {{ $errors->has($user->taxOffice) ? 'error-border' : '' }}"
                                                                        name="taxOffice">
                                                                        <option value="">Seçiniz</option>
                                                                    </select>
                                                                    @if ($errors->has($user->taxOffice))
                                                                        <span
                                                                            class="error-message">{{ $errors->first($user->taxOffice) }}</span>
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
                                                                    <input type="number" id="taxNumber" name="taxNumber"
                                                                        class="form-control {{ $errors->has($user->taxNumber) ? 'error-border' : '' }}"
                                                                        value="{{ $user->taxNumber }}" maxlength="10">
                                                                    @if ($errors->has($user->taxNumber))
                                                                        <span
                                                                            class="error-message">{{ $errors->first($user->taxNumber) }}</span>
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
                                                                    <label for="" class="q-label">Yetki Belgesi
                                                                        No</label>
                                                                    <input type="text" id="authority_licence"
                                                                        name="authority_licence"
                                                                        value="{{ $user->authority_licence }}"
                                                                        class="form-control" maxlength="7">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="split-form corporate-input mt-3 {{ old('account_type') == 2 ? 'd-none' : '' }}"
                                                        id="idNumberDiv">
                                                        <div class="corporate-input input-city">
                                                            <div class="mbdef">
                                                                <div class="select select-tax-office">
                                                                    <label for="" class="q-label">TC Kimlik
                                                                        No</label>
                                                                    <input type="number" id="idNumber" name="idNumber"
                                                                        class="form-control"
                                                                        value="{{ $user->idNumber }}" maxlength="11">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>


                                                <button type="submit" class="btn btn-primary ml-4">
                                                    Güncelle </button>
                                            </form>
                                        </div>



                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-map" role="tabpanel"
                                aria-labelledby="v-pills-map-tab">
                                <div class="card shadow-sm border-300 border-bottom mb-4">
                                    <div class="col-lg-12 col-md-12 col-xs-12 widget-boxed mt-33 mt-0 ">

                                        <div class="col-lg-12">
                                            <h4>Firma Konumunu Güncelleme</h4>
                                            <div class="agent-contact-form-sidebar">
                                                <label class="q-label"></label>
                                                <form name="contact_form" method="POST" enctype="multipart/form-data"
                                                    action="{{ route('institutional.profile.location') }}">
                                                    @csrf
                                                    <input type="hidden" name="latitude" id="latitude"
                                                        value="{{ old('latitude', $user->latitude) }}">
                                                    <input type="hidden" name="longitude" id="longitude"
                                                        value="{{ old('longitude', $user->longitude) }}">
                                                    <div id="mapContainer" style="height: 350px;"></div>
                                                    <button type="submit" class="btn btn-primary mt-4">
                                                        Güncelle </button>
                                                </form>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        @endif
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

    <!-- Google Maps API script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&callback=initMap" async
        defer></script>
    <!-- Dropzone.js CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropzone@5/dist/dropzone.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/dropzone@5/dist/dropzone.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#new_phone_number').on('input', function() {
                var inputValue = $(this).val();
                var maxLength = 11;

                // Sadece rakamları izin ver
                var numericValue = inputValue.replace(/\D/g, '');

                if (numericValue.length > maxLength) {
                    numericValue = numericValue.slice(0, maxLength);
                }

                $(this).val(numericValue);

                if (numericValue.length > maxLength) {
                    $('#error-message').text('Telefon numarası 11 haneden fazla olamaz.');
                } else {
                    $('#error-message').text('');
                }
            });
        });
    </script>
    <script>
        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone("#myDropzone", {
            paramName: "file", // Yüklenecek dosya adı
            maxFilesize: 2, // MB cinsinden maksimum dosya boyutu
            acceptedFiles: ".jpg, .jpeg, .png, .pdf", // Kabul edilen dosya türleri
            dictDefaultMessage: "Dosyaları buraya sürükleyin veya tıklayın", // Varsayılan mesaj
            maxFiles: 1, // Sadece bir dosya yüklemeye izin ver
            addRemoveLinks: true, // Dosya kaldırma bağlantısı ekle
            dictRemoveFile: "Dosyayı kaldır", // Dosya kaldırma bağlantısının metni
            init: function() {
                this.on("addedfile", function(file) {
                    if (this.files[1] != null) {
                        this.removeFile(this.files[0]);
                    }
                });

                this.on("success", function(file, response) {
                    // Yükleme başarılı olduğunda çalışır
                    console.log("Yükleme başarılı: ", response);
                });

                this.on("error", function(file, response) {
                    // Yükleme hatası olduğunda çalışır
                    console.error("Yükleme hatası: ", response);
                });

                this.on("complete", function(file) {
                    // Yükleme tamamlandığında çalışır
                    if (file.upload.filename) {
                        console.log("Yüklenen dosya adı: ", file.upload.filename);
                        var form2FileInput = document.getElementById("form2_file_input");
                        form2FileInput.value = JSON.stringify(
                            file);
                    }
                });
            }
        });
    </script>


    <script>
        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone("#profileImageDropzone", {
            paramName: "file", // Yüklenecek dosya adı
            maxFilesize: 2, // MB cinsinden maksimum dosya boyutu
            acceptedFiles: ".jpg, .jpeg, .png, .pdf", // Kabul edilen dosya türleri
            dictDefaultMessage: "Dosyaları buraya sürükleyin veya tıklayın", // Varsayılan mesaj
            maxFiles: 1, // Sadece bir dosya yüklemeye izin ver
            addRemoveLinks: true, // Dosya kaldırma bağlantısı ekle
            dictRemoveFile: "Dosyayı kaldır", // Dosya kaldırma bağlantısının metni
            init: function() {
                this.on("addedfile", function(file) {
                    if (this.files[1] != null) {
                        this.removeFile(this.files[0]);
                    }
                });

                this.on("success", function(file, response) {
                    // Yükleme başarılı olduğunda çalışır
                    console.log("Yükleme başarılı: ", response);
                });

                this.on("error", function(file, response) {
                    // Yükleme hatası olduğunda çalışır
                    console.error("Yükleme hatası: ", response);
                });

                this.on("complete", function(file) {
                    // Yükleme tamamlandığında çalışır
                    if (file.upload.filename) {
                        // Yüklenen dosya adını alabiliriz, burada file.upload.filename kullanıyoruz.
                        // İstenilen formdaki input elementine atama yapmak için JavaScript ile bu dosya adını alabiliriz.
                        var form2FileInput = document.getElementById("form_file_input");
                        form2FileInput.value = JSON.stringify(
                            file); // Burada file.upload.filename ile alıyoruz.
                    }
                });
            }
        });





        // Renk seçiciden arka plan rengini değiştirme
        // Laravel'den banner_hex_code değerini alın
        var bannerHexCode = @json($user->banner_hex_code);

        // Eğer bannerHexCode varsa, image-preview-container arka plan rengini ayarlayın
        if (bannerHexCode) {
            document.querySelector('.image-preview-container').style.backgroundColor = bannerHexCode;
            document.getElementById('customColorPicker').value = bannerHexCode;
        }

        // Color picker değiştiğinde arka plan rengini güncelleyin
        document.getElementById('customColorPicker').addEventListener('input', function() {
            document.querySelector('.image-preview-container').style.backgroundColor = this.value;
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // localStorage'dan son ziyaret edilen sekmeyi al
            let activeTab = localStorage.getItem('activeTab');

            if (activeTab) {
                // Eğer localStorage'da bir sekme kaydedilmişse, onu aktif yap
                let tabElement = document.querySelector(`a[href="${activeTab}"]`);
                let tabContentElement = document.querySelector(activeTab);

                if (tabElement && tabContentElement) {
                    // Tüm sekmeleri aktif olmayan duruma getir
                    document.querySelectorAll('.nav-link').forEach((el) => {
                        el.classList.remove('active');
                    });

                    // Tüm tab içeriklerini gizle
                    document.querySelectorAll('.tab-pane').forEach((el) => {
                        el.classList.remove('show');
                        el.classList.remove('active');
                    });

                    // localStorage'dan gelen sekmeyi aktif yap
                    tabElement.classList.add('active');
                    tabContentElement.classList.add('show');
                    tabContentElement.classList.add('active');
                }
            }

            // Her sekme tıklandığında, o sekmeyi localStorage'a kaydet
            document.querySelectorAll('.nav-link').forEach((tab) => {
                tab.addEventListener('click', function(event) {
                    localStorage.setItem('activeTab', event.target.getAttribute('href'));
                });
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Popover'ı etkinleştir
            $('#popoverContent').popover({
                content: function() {
                    return '<img src="/images/phone-update-image/phonefile.jpg" class="img-fluid" alt="Belge Örneği"><br><strong>Ekstra Bilgi:</strong> Bu belge çok önemlidir ve eksiksiz olmalıdır.';
                },
                html: true,
                trigger: 'hover',
                placement: 'top'
            });
        });
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
                $('#landPhone').on('keypress', function(e) {
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
            $("#phone").on("input blur", function() {
                var phoneNumber = $(this).val();
                var pattern = /^5[0-9]\d{8}$/;

                if (!pattern.test(phoneNumber)) {
                    $("#error_message").text(
                        "Lütfen geçerli bir telefon numarası giriniz.");
                } else {
                    $("#error_message").text("");
                }
                // Kullanıcı 10 haneden fazla veri girdiğinde bu kontrol edilir
                $('#phone').on('keypress', function(e) {
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
        function validateForm2() {
            var mobilePhone = document.getElementById('mobile_phone').value;
            var image = document.getElementById('image').value;

            if (mobilePhone.trim() === '') {
                alert('Telefon numarası boş bırakılamaz.');
                return false;
            }

            var fileInput = document.getElementById('image');
            if (!fileInput.files[0]) {
                alert('Dosya seçmelisiniz.');
                return false;
            }

            return true;
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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
        const companyTypeRadios = document.querySelectorAll('input[name="account_type"]');
        const taxNumberInput = document.getElementById('taxNumber');
        const idNumberInput = document.getElementById('idNumberDiv');

        companyTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'Şahıs Şirketi') { // Şahıs Şirketi seçildiğinde
                    taxNumberInput.style.display = 'block'; // Vergi Numarası görünür
                    idNumberInput.style.display = 'block'; // TC Kimlik Numarası gizli
                } else if (this.value ===
                    'Limited veya Anonim Şirketi') { // Limited veya Anonim Şirketi seçildiğinde
                    taxNumberInput.style.display = 'block'; // Vergi Numarası gizli
                    idNumberInput.style.display = 'none'; // TC Kimlik Numarası görünür
                }
            });
        });

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
        $(document).ready(function() {
            var cityId = "{{ $user->city_id }}";
            var countyId = "{{ $user->county_id }}";
            var taxOfficeCity = "{{ $user->taxOfficeCity }}";
            var neighborhoodId = "{{ $user->neighborhood_id }}";
            var taxOffice = "{{ $user->taxOffice }}";

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
                        var selectedAttribute = (office.id == taxOffice.val()) ?
                            // Düzeltilmiş kısım
                            'selected' : '';
                        taxOffice.append(
                            '<option value="' + office.id + '" ' +
                            selectedAttribute + '>' +
                            office.daire +
                            '</option>'
                        );
                    });
                },
                error: function(xhr, status, error) {
                    console.log('AJAX Hatası:', error);
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

        .author__initials {
            display: inline-block;
            width: 50px;
            height: 50px;
            background-color: #ddd;
            color: #ab0000;
            font-size: 24px;
            text-align: center;
            line-height: 50px;
            border-radius: 50%;
        }
    </style>



    <style>
        /* Özelleştirmeler */
        .fa-exclamation-circle {
            cursor: pointer;
            /* Fare üzerine gelince işaret değişsin */
        }

        /* Popover içeriği için özelleştirmeler */
        .popover {
            max-width: 400px;
            /* Popover'ın maksimum genişliği */
        }

        .popover-body img {
            width: 100%;
            /* Resmin genişliği */
        }

        .dropzone {
            border: 2px dashed #1ABC9C !important;
            padding-top: 20px !important;
        }
    </style>

    <style>
        .companyType label {
            display: flex;
            align-items: normal;
            justify-content: center;
            margin: 0 10px 0 0;
        }

        .dz-message {
            background: none !important;
            border: none !important;
            padding: none !important;
            text-align: none !important;
        }

        .dz-remove {
            cursor: pointer;
            color: red;
            text-decoration: underline;
        }

        .image-preview-container {
            width: 400px;
            height: 200px;
            border: 2px solid #ddd;
            padding: 5px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
            background-color: #f8f9fa;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .image-preview-container img {

            max-width: 100%;
            max-height: 100%;
        }


        .custom-color-picker {
            margin-top: 20px !important;
            width: 150px !important;
            height: 40px !important;
            border: 1px solid #ccc !important;
            border-radius: 5px !important;
            padding: 5px !important;
            font-size: 16px !important;
            cursor: pointer !important;
            background-color: #ffffff !important;
            /* Arka plan rengi */
        }

        .custom-color-picker:focus {
            outline: none !important;
            border-color: #007bff !important;
            /* Odaklandığında kenarlık rengi */
        }
    </style>
    
@endsection
