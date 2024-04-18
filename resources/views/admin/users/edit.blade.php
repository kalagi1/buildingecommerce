@extends('admin.layouts.master')

@section('content')
    <div class="content">
        @if ($userDetail->type == 2)
            <div class="grid-container mb-4 mt-2">
                <div class="card l-bg-cherry">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Proje Sayısı</h5>
                            <h5 class="float-right">{{ $projectCount }}</h5>
                        </div>
                    </div>
                </div>

                <div class="card l-bg-blue-dark">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fa-solid fa-house"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Emlak Sayısı</h5>
                            <h5 class="float-right">{{ $housingCount }}</h5>
                        </div>
                    </div>
                </div>

                <div class="card l-bg-green-dark">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Alt Kullanıcı Sayısı</h5>
                            <h5 class="float-right">{{ $userChildCount }}</h5>
                        </div>
                    </div>
                </div>

                <div class="card l-bg-orange-dark">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fa-solid fa-star"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Değerlendirme Sayısı</h5>
                            <h5 class="float-right">{{ $userCommentCount }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($userDetail->role->id == '2')
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-5">
                        <div class="card-header hover-actions-trigger d-flex justify-content-center align-items-end position-relative mb-7 mb-xxl-0"
                            style="min-height: 214px; ">
                            <div class="bg-holder rounded-top" style="background-color: {{ $userDetail->banner_hex_code }}">
                            </div>
                            <div class="hoverbox feed-profile" style="width: 150px; height: 150px">
                                <div
                                    class="position-relative bg-400 rounded-circle cursor-pointer d-flex flex-center mb-xxl-7">
                                    <div class="avatar avatar-5xl"><img
                                            class="rounded-circle rounded-circle bg-white img-thumbnail shadow-sm"
                                            src="{{ url('storage/profile_images/' . $userDetail->profile_image) }}"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-xl-between">
                                <div class="col-auto">
                                    <div class="d-flex flex-wrap mb-3 align-items-center">
                                        <h2 class="me-2">{{ $userDetail->name }}</h2>
                                    </div>
                                    <div class="mb-5">
                                        <div class="d-md-flex align-items-center">
                                            <div class="d-flex align-items-center"><svg
                                                    class="svg-inline--fa fa-user-group fs--1 text-700 me-2 me-lg-1 me-xl-2"
                                                    aria-hidden="true" focusable="false" data-prefix="fas"
                                                    data-icon="user-group" role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 640 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3c-95.73 0-173.3 77.6-173.3 173.3C0 496.5 15.52 512 34.66 512H413.3C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM479.1 320h-73.85C451.2 357.7 480 414.1 480 477.3C480 490.1 476.2 501.9 470 512h138C625.7 512 640 497.6 640 479.1C640 391.6 568.4 320 479.1 320zM432 256C493.9 256 544 205.9 544 144S493.9 32 432 32c-25.11 0-48.04 8.555-66.72 22.51C376.8 76.63 384 101.4 384 128c0 35.52-11.93 68.14-31.59 94.71C372.7 243.2 400.8 256 432 256z">
                                                    </path>
                                                </svg><span class="fs-1 fw-bold text-600 hover-text-1100"
                                                    style="font-size:13px !important">{{ count($userDetail->child) }}
                                                    <span class="fw-semi-bold ms-1 me-4">Alt Kullanıcılar</span></span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                @if(isset($userDetail->town)  && isset($userDetail->district) && isset($userDetail->neighborhood))
                                                    <svg class="svg-inline--fa fa-location-dot fs--1 text-700 me-2 me-lg-1 me-xl-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                        <path fill="currentColor" d="M168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2H168.3zM192 256C227.3 256 256 227.3 256 192C256 156.7 227.3 128 192 128C156.7 128 128 156.7 128 192C128 227.3 156.7 256 192 256z"></path>
                                                    </svg>
                                                    <span class="fs-1 fw-semi-bold text-600 hover-text-1100" style="font-size:13px !important">
                                                        {{$userDetail->town->sehir_title}}
                                                        <i class="fa fa-angle-right"></i>
                                                        {{$userDetail->district->ilce_title}}
                                                        <i class="fa fa-angle-right"></i>
                                                        {{$userDetail->neighborhood->mahalle_title}}
                                                    </span>
                                                @endif
                                            </div>
                                            
                                        </div>
                                    </div>

                                </div>
                                <div class="col-auto">
                                    <div class="row g-2">
                                        <div class="col-auto order-xxl-2"><button class="btn btn-phoenix-danger">
                                                <a
                                                    href="{{ route('institutional.dashboard', ['slug' => Str::slug($userDetail->name), 'userID' => $userDetail->id]) }}">Mağazaya
                                                    Git</a>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card ">
                        <div class="card-body pb-3">
                            @if(isset($userDetail->town)  && isset($userDetail->district) && isset($userDetail->neighborhood))
                            <h5 class="text-800">Konum</h5>
                            
                            <p class="text-800"> {{ $userDetail->town->sehir_title }} <i class="fa fa-angle-right"></i>
                                {{ $userDetail->district->ilce_title }} <i class="fa fa-angle-right"></i>
                                {{ $userDetail->neighborhood->mahalle_title }} </p>
                            <div class="mb-3">
                                <h5 class="text-800">E-mail</h5><a
                                    href="mailto:{{ $userDetail->email }}">{{ $userDetail->email }}</a>
                            </div>
                            @if ($userDetail->phone)
                                <h5 class="text-800">Telefon</h5><a class="text-800"
                                    href="tel:{{ $userDetail->phone }}">{{ $userDetail->phone }}</a>
                            @endif
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-12 col-xl-12 order-1 order-xl-0">
                <div class="mb-9">
                    <div class="card shadow-none border border-300 p-0" data-component-card="data-component-card">
                        <div class="card-header border-bottom border-300 bg-soft">
                            <div class="row g-3 justify-content-between align-items-center">
                                <div class="col-6 col-md">
                                    <h4 class="text-900 mb-0" data-anchor="data-anchor" id="soft-buttons">Üye
                                        Düzenle</h4>
                                </div>
                                <div class="col-6">
                                    @if ($userDetail->is_blocked)
                                        <form action="{{ route('admin.users.block', $userDetail) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-phoenix-danger" style="float: right">

                                                <svg viewBox="0 0 24 24" width="24" height="24"
                                                    stroke="currentColor" stroke-width="2" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                                                    <line x1="9" y1="9" x2="9.01" y2="9">
                                                    </line>
                                                    <line x1="15" y1="9" x2="15.01" y2="9">
                                                    </line>
                                                </svg>
                                                <span style="margin-left: 5px"> Kullanıcının Engelini Kaldır</span>

                                            </button>
                                        </form>
                                    @else
                                        {{-- <form action="{{ route('admin.users.block', $userDetail) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-phoenix-danger" style="float: right">
                                                <svg viewBox="0 0 24 24" width="24" height="24"
                                                    stroke="currentColor" stroke-width="2" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <line x1="8" y1="15" x2="16" y2="15">
                                                    </line>
                                                    <line x1="9" y1="9" x2="9.01" y2="9">
                                                    </line>
                                                    <line x1="15" y1="9" x2="15.01" y2="9">
                                                    </line>
                                                </svg>
                                                <span style="margin-left: 5px">Kullanıcıyı Engelle</span>
                                            </button>
                                        </form> --}}

                                        <button class="btn btn-phoenix-danger" style="float: right"
                                            data-bs-toggle="modal" data-bs-target="#blockUserModal">
                                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                                stroke-width="2" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round" class="css-i6dzq1">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="8" y1="15" x2="16" y2="15">
                                                </line>
                                                <line x1="9" y1="9" x2="9.01" y2="9">
                                                </line>
                                                <line x1="15" y1="9" x2="15.01" y2="9">
                                                </line>
                                            </svg>
                                            <span style="margin-left: 5px">Kullanıcıyı Engelle</span>
                                        </button>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="blockUserModal" tabindex="-1" aria-labelledby="blockUserModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="blockUserModalLabel">Kullanıcı Engelle</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.users.block', $userDetail) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="form-floating">
                                                <textarea class="form-control" placeholder="Kullanıcı Engelleme Nedeni" id="blockReason" name="blockReason"></textarea>
                                                <label for="floatingTextarea">Kullanıcı Engelleme Nedeni</label>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Kapat</button>
                                                <button type="submit" class="btn btn-primary">Engelle</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">

                            <div class="p-4">
                                @if (session()->has('success'))
                                    <div class="alert alert-success text-white text-white">
                                        {{ session()->get('success') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger text-white">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form class="row g-3 needs-validation" novalidate="" method="POST"
                                    action="{{ route('admin.users.update', $userDetail->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT') <!-- HTTP PUT kullanarak güncelleme işlemi yapılacak -->
                                    <div class="col-lg-8">
                                        <div>
                                            <input class="d-none" id="upload-settings-porfile-picture"
                                                name="profile_image" type="file" accept=".jpeg, .jpg, .png"><label
                                                class="avatar avatar-4xl status-online cursor-pointer"
                                                for="upload-settings-porfile-picture"><img
                                                    class="rounded-circle img-thumbnail shadow-sm border-0"
                                                    src="{{ asset('storage/profile_images/' . $userDetail->profile_image) }}"
                                                    width="200" alt=""></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        @if ($userDetail->parent_id)
                                            <p>
                                                {{ $parent }} kurumsal hesabının alt kullanıcısı
                                                {{ $userDetail->name }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="mt-3">
                                        <label class="q-label">Yetkili İsim Soyisim</label>
                                        <input type="text" name="username"
                                            class="form-control {{ $errors->has('username') ? 'error-border' : '' }}"
                                            value="{{ old('username') }}">
                                        @if ($errors->has('username'))
                                            <span class="error-message">{{ $errors->first('username') }}</span>
                                        @endif
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <label class="form-label" for="email">Email</label>
                                        <input name="email" class="form-control" id="email" type="email"
                                            value="{{ old('email', $userDetail->email) }}" required="">
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="mobile_phone">Cep Numarası</label>
                                        <input name="mobile_phone" class="form-control" id="mobile_phone"
                                            type="number"
                                            value="{{ old('mobile_phone', $userDetail->mobile_phone) }}" required="">
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    @if ($userDetail->type != '1')
                                        <div class="col-md-12">
                                            <label class="form-label" for="phone">İş Numarası</label>
                                            <input name="phone" class="form-control" id="phone" type="number"
                                                value="{{ old('phone', $userDetail->phone) }}" required="">
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                    @endif
                                    <div class="col-md-12">
                                        <label class="form-label" for="password">Şifre (Değiştirmek istemiyorsanız boş
                                            bırakın)</label>
                                        <input name="password" class="form-control" id="password" type="password"
                                            value="">
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="validationCustom04">Kullanıcı Tipi</label>
                                        <select name="type" class="form-select" id="validationCustom04"
                                            required="">
                                            @foreach ($roles as $item)
                                                <option value={{ $item->id }}
                                                    {{ old('type', $userDetail->type) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    @if ($userDetail->type != '1')
                                    
                                    <div class="col-md-12">
                                        <label class="form-label" for="name">Firma Adı</label>
                                        <input name="name" class="form-control" id="name" type="text"
                                            value="{{ old('name', $userDetail->username) }}" required="">
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>


                                        {{-- <div class="col-md-6">
                                            <label class="form-label" for="validationCustom04">Hesap Türü</label>
                                            <input name="account_type" class="form-control" id="account_type"
                                                type="text" value="{{ $userDetail->account_type }}">
                                        </div> --}}
                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom04">Faaliyet Alanı</label>
                                            <select name="corporate_type" id="corporate_type" class="form-control">
                                                @foreach (['Emlakçı', 'İnşaat', 'Turizm', 'Banka'] as $type)
                                                    <option value="{{ $type }}"
                                                        {{ $userDetail->corporate_type === $type ? 'selected' : '' }}>
                                                        {{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom04">IBAN</label>
                                            <input name="iban" class="form-control" id="iban" type="text"
                                                value="{{ $userDetail->iban }}">
                                        </div>


                                        {{-- daire --}}
                                        {{-- <div class="col-md-6">
                                            <label class="form-label" for="taxOffice">Vergi Dairesi</label>
                                            <select name="taxOffice" class="form-select" id="taxOffice">
                                                @foreach ($taxOffices as $item)
                                                    <option value="{{ $item->id }}"
                                                        @if ($item->id == $userDetail->taxOffice) selected @endif>
                                                        {{ $item->daire }}</option>
                                                @endforeach
                                            </select>
                                        </div> --}}

                                        {{-- il --}}
                                        {{-- <div class="col-md-6">
                                            <label class="form-label" for="taxOfficeCity">Vergi Dairesi Şehri</label>
                                            <input name="taxOfficeCity" class="form-control" id="taxOfficeCity"
                                                type="text">
                                        </div> --}}

                                        {{-- no --}}
                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom04">Vergi No</label>
                                            <input name="taxNumber" class="form-control" id="taxNumber" type="number"
                                                value="{{ $userDetail->taxNumber }}">
                                        </div>


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

                                        @if ($userDetail->account_type == 'Şahıs Şirketi')
                                            <div class="col-md-6">
                                                <label class="form-label" for="validationCustom04">TC</label>
                                                <input name="idNumber" class="form-control" id="idNumber"
                                                    type="number" value="{{ $userDetail->idNumber }}">
                                            </div>
                                        @endif


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

                                    @endif
                                    <div class="col-md-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="is_active"
                                                id="flexSwitchCheckCheckedDisabled" type="checkbox"
                                                {{ old('is_active', $userDetail->status) ? 'checked' : '' }} />
                                            <label class="form-check-label"
                                                for="flexSwitchCheckCheckedDisabled">Aktif</label>
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        @if (in_array('UpdateUser', $userPermissions))
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        @else
                                            <p>Bu işlem için yetkiniz yok</p>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (!($userDetail->type == 18))
            <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white pt-7 border-y border-300">
                <div data-list='{"valueNames":["product","customer","rating","review","time"],"page":4}'>
                    <div class="row align-items-end justify-content-between pb-5 g-3">
                        <div class="col-auto">
                            <h3>Değerlendirmeler</h3>
                        </div>
                    </div>
                    <div class="table-responsive mx-n1 px-1 scrollbar">
                        <table class="table fs--1 mb-0 border-top border-200">
                            <thead>
                                <tr>
                                    <th class="sort white-space-nowrap align-middle" scope="col">No.</th>
                                    <th class="sort white-space-nowrap align-middle" scope="col"
                                        style="min-width: 200px;" data-sort="product">Üye</th>
                                    <th class="sort align-middle" scope="col" data-sort="customer"
                                        style="min-width: 200px;">
                                        Yorum</th>
                                    <th class="sort align-middle" scope="col" data-sort="rating"
                                        style="min-width: 110px;">
                                        Oylama</th>

                                    <th class="sort text-start ps-5 align-middle" scope="col" data-sort="status">Durum
                                    </th>
                                    <th class="sort align-middle" scope="col" colspan="2" data-sort="review">Tarih
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="list" id="table-latest-review-body">
                                @foreach ($userDetail->comments as $key => $comment)
                                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                        <td class="align-middle product white-space-nowrap py-0">
                                            {{ $key + 1 }}
                                        </td>
                                        <td class="align-middle customer white-space-nowrap">
                                            <a class="d-flex align-items-center text-900">
                                                <div class="avatar avatar-l">
                                                    <img class="rounded-circle"
                                                        src="{{ URL::to('/') }}/storage/profile_images/{{ $comment->user->profile_image }}"
                                                        alt="" />
                                                </div>
                                                <h6 class="mb-0 ms-3 text-900">{{ $comment->user->name }}</h6>
                                            </a>
                                        </td>
                                        <td class="align-middle review" style="min-width: 350px;">
                                            <p class="fs--1 fw-semi-bold text-1000 mb-0">{{ $comment->comment }}</p>
                                            <div class="row mt-3">
                                                @foreach (json_decode($comment->images, true) as $img)
                                                    <div class="col-md-2">
                                                        <a href="<?= asset('storage/' . preg_replace('@^public/@', null, $img)) ?>"
                                                            data-lightbox="gallery">
                                                            <img src="<?= asset('storage/' . preg_replace('@^public/@', null, $img)) ?>"
                                                                style="object-fit: cover;width:100%" />
                                                        </a>

                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="align-middle rating white-space-nowrap fs--2">
                                            @for ($i = 0; $i < $comment->rate; $i++)
                                                <svg viewBox="0 0 14 14" class="widget-svg"
                                                    style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                                    <path class="star"
                                                        d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                        style="fill: rgb(255, 192, 0); transition: fill 0.2s ease-in-out 0s;">
                                                    </path>
                                                </svg>
                                            @endfor
                                        </td>
                                        <td class="align-middle text-start ps-5 status">
                                            @if ($comment->status == '1')
                                                <span class="badge badge-phoenix fs--2 badge-phoenix-success">
                                                    <span class="badge-label">Aktif</span>
                                                    <span class="ms-1" data-feather="check"
                                                        style="height: 12.8px; width: 12.8px;"></span>
                                                </span>
                                            @else
                                                <span class="badge badge-phoenix fs--2 badge-phoenix-danger">
                                                    <span class="badge-label">Pasif</span>
                                                    <span data-feather="x" style="height: 12.8px; width: 12.8px;"></span>

                                                </span>
                                            @endif

                                        </td>
                                        <td class="align-middle text-end time white-space-nowrap">
                                            <div class="hover-hide">
                                                <h6 class="text-1000 mb-0">
                                                    {{ $comment->created_at->locale('tr')->isoFormat('D MMM, HH:mm') }}
                                                </h6>
                                            </div>
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row align-items-center py-1">
                        <div class="pagination d-none"></div>
                        <div class="col d-flex fs--1">
                            <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info">
                            </p>
                            <a class="fw-semi-bold" href="{{ route('admin.housings.comments') }}"
                                data-list-view="*">Tümünü
                                Görüntüle<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>

                        </div>
                        <div class="col-auto d-flex">
                            <button class="btn btn-link px-1 me-1" type="button" title="Previous"
                                data-list-pagination="prev">
                                <span class="fas fa-chevron-left me-2"></span>Geri
                            </button>
                            <button class="btn btn-link px-1 ms-1" type="button" title="Next"
                                data-list-pagination="next">
                                İleri<span class="fas fa-chevron-right ms-2"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <!-- lightbox2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- lightbox2 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

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

            var taxOfficeId = $('#taxOffice').val();
            $.ajax({
                url: '{{ route('getTaxOfficeCity') }}',
                method: 'GET',
                data: {
                    taxOfficeId: taxOfficeId
                },
                success: function(response) {
                    console.log(response);
                    $('#taxOfficeCity').val(response.city);
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error('Hata:', errorThrown);
                }
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

            $('#taxOffice').change(function() {
                var taxOfficeId = $(this).val();
                $.ajax({
                    url: '{{ route('getTaxOfficeCity') }}',
                    method: 'GET',
                    data: {
                        taxOfficeId: taxOfficeId
                    },
                    success: function(response) {
                        console.log(response);
                        $('#taxOfficeCity').val(response.city);
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error('Hata:', errorThrown);
                    }
                });
            });
        });
    </script>
@endsection

@section('css')
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .grid-container .card {
            border-radius: 10px;
            border: none;
            position: relative;
            box-shadow: 0 0.46875rem 2.1875rem rgba(90, 97, 105, 0.1), 0 0.9375rem 1.40625rem rgba(90, 97, 105, 0.1), 0 0.25rem 0.53125rem rgba(90, 97, 105, 0.12), 0 0.125rem 0.1875rem rgba(90, 97, 105, 0.1);
            transition: transform 0.5s ease, box-shadow 0.5s ease;
        }

        .grid-container .card:hover {
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            transform: translateY(-15px);
        }

        .l-bg-cherry {
            background: linear-gradient(to right, #493240, #f09) !important;
            color: #fff;
        }

        .l-bg-blue-dark {
            background: linear-gradient(to right, #373b44, #4286f4) !important;
            color: #fff;
        }

        .l-bg-green-dark {
            background: linear-gradient(to right, #0a504a, #38ef7d) !important;
            color: #fff;
        }

        .l-bg-orange-dark {
            background: linear-gradient(to right, #a86008, #ffba56) !important;
            color: #fff;
        }

        .statistic .card .card-statistic-3 .card-icon {
            text-align: center;
            line-height: 50px;
            margin-left: 15px;
            color: #000;
            position: absolute;
            right: -5px;
            top: 20px;
            opacity: 0.1;
        }

        .l-bg-cyan {
            background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
            color: #fff;
        }

        .l-bg-green {
            background: linear-gradient(135deg, #23bdb8 0%, #43e794 100%) !important;
            color: #fff;
        }

        .l-bg-orange {
            background: linear-gradient(to right, #f9900e, #ffba56) !important;
            color: #fff;
        }

        .l-bg-cyan {
            background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
            color: #fff;
        }

        .card-statistic-3 .mb-4 {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-statistic-3 .mb-4 h5 {
            color: #fff;
        }

        .card-statistic-3 .mb-4 .float-right {
            color: #333;
        }
    </style>
@endsection
