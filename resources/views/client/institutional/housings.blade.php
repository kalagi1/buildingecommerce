@extends('client.layouts.master')

@section('content')
@php

function convertMonthToTurkishCharacter($date)
{
$aylar = [
'January' => 'Ocak',
'February' => 'Şubat',
'March' => 'Mart',
'April' => 'Nisan',
'May' => 'Mayıs',
'June' => 'Haziran',
'July' => 'Temmuz',
'August' => 'Ağustos',
'September' => 'Eylül',
'October' => 'Ekim',
'November' => 'Kasım',
'December' => 'Aralık',
'Monday' => 'Pazartesi',
'Tuesday' => 'Salı',
'Wednesday' => 'Çarşamba',
'Thursday' => 'Perşembe',
'Friday' => 'Cuma',
'Saturday' => 'Cumartesi',
'Sunday' => 'Pazar',
'Jan' => 'Oca',
'Feb' => 'Şub',
'Mar' => 'Mar',
'Apr' => 'Nis',
'May' => 'May',
'Jun' => 'Haz',
'Jul' => 'Tem',
'Aug' => 'Ağu',
'Sep' => 'Eyl',
'Oct' => 'Eki',
'Nov' => 'Kas',
'Dec' => 'Ara',
];
return strtr($date, $aylar);
}

function getImage($housing, $key)
{
$housing_type_data = json_decode($housing->housing_type_data);
$a = $housing_type_data->$key;
return $a;
}
@endphp
<div class="brand-head">
    <div class="container">
        <div class="card mb-3">
            <div class="card-img-top" style="background-color: {{ $store->banner_hex_code }}">
                <div class="brands-square w-100">
                    <img src="{{ url('storage/profile_images/' . $store->profile_image) }}" alt="" class="brand-logo">
                    <p class="brand-name"><a href="{{ route('instituional.profile', Str::slug($store->name)) }}" style="color:White">
                            {{ $store->name }}
                            <style type="text/css">
                                .st0 {
                                    fill: #e54242;
                                }

                                .st1 {
                                    opacity: 0.15;
                                }

                                .st2 {
                                    fill: #FFFFFF;
                                }
                            </style>
                            <svg id="Layer_1" style="enable-background:new 0 0 120 120;" version="1.1" width="24px" height="24px" viewBox="0 0 120 120" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g>
                                    <path class="st0" d="M99.5,52.8l-1.9,4.7c-0.6,1.6-0.6,3.3,0,4.9l1.9,4.7c1.1,2.8,0.2,6-2.3,7.8L93,77.8c-1.4,1-2.3,2.5-2.7,4.1   l-0.9,5c-0.6,3-3.1,5.2-6.1,5.3l-5.1,0.2c-1.7,0.1-3.3,0.8-4.5,2l-3.5,3.7c-2.1,2.2-5.4,2.7-8,1.2l-4.4-2.6   c-1.5-0.9-3.2-1.1-4.9-0.7l-5,1.2c-2.9,0.7-6-0.7-7.4-3.4l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8   l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8   l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6c1.4-2.7,4.4-4.1,7.4-3.4l5,1.2c1.6,0.4,3.4,0.2,4.9-0.7l4.4-2.6c2.6-1.5,5.9-1.1,8,1.2   l3.5,3.7c1.2,1.2,2.8,2,4.5,2l5.1,0.2c3,0.1,5.6,2.3,6.1,5.3l0.9,5c0.3,1.7,1.3,3.2,2.7,4.1l4.2,2.9C99.7,46.8,100.7,50,99.5,52.8z   " />
                                    <g class="st1">
                                        <path d="M43.4,93.5l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4    c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6    c0.8-1.6,2.2-2.7,3.7-3.2c-2.7-0.4-5.4,1-6.6,3.5l-2.3,4.6c-0.8,1.5-2.1,2.7-3.7,3.2l-4.8,1.6c-2.9,1-4.7,3.8-4.4,6.8l0.5,5.1    c0.2,1.7-0.3,3.4-1.4,4.7l-3.2,4c-1.9,2.4-1.9,5.7,0,8.1l3.2,4c1.1,1.3,1.6,3,1.4,4.7l-0.5,5.1c-0.3,3,1.5,5.8,4.4,6.8l4.8,1.6    c1.6,0.5,2.9,1.7,3.7,3.2l2.3,4.6c1.4,2.7,4.4,4.1,7.4,3.4l0.6-0.1C46.3,96.7,44.4,95.5,43.4,93.5z" />
                                        <path d="M60.6,22.5l4.4-2.6c0.4-0.2,0.8-0.4,1.2-0.5c-1.4-0.2-2.9,0.1-4.1,0.8l-4.4,2.6c-0.4,0.2-0.8,0.4-1.2,0.5    C57.9,23.5,59.3,23.3,60.6,22.5z" />
                                        <path d="M81,92c-0.5,0-1,0.1-1.4,0.2l3.6-0.2c0.5,0,0.9-0.1,1.4-0.2L81,92z" />
                                        <path d="M65,98.9l-4.4-2.6c-1.5-0.9-3.2-1.1-4.9-0.7l-0.6,0.1c0.9,0.1,1.7,0.4,2.5,0.8l4.4,2.6c1.7,1,3.6,1.1,5.4,0.5    C66.6,99.6,65.8,99.4,65,98.9z" />
                                    </g>
                                    <polyline class="st0" points="44,53.6 56.5,67.9 82.1,47.3  " />
                                    <path class="st2" d="M53.5,75.3c-1.4,0-2.8-0.6-3.8-1.7L37.2,59.3c-1.8-2.1-1.6-5.2,0.4-7.1c2.1-1.8,5.2-1.6,7.1,0.4l9.4,10.7   l21.9-17.6c2.1-1.7,5.3-1.4,7,0.8c1.7,2.2,1.4,5.3-0.8,7L56.6,74.2C55.7,74.9,54.6,75.3,53.5,75.3z" />
                                </g>
                            </svg>
                        </a>
                    </p>
                    @if (Auth::check())
                    @if ($store->id == Auth::user()->id)
                    <a href="{{ url('institutional/choise-advertise-type') }}" style="margin-left: auto; margin-right:30px">
                        <button type="button" class="buyUserRequest ml-3">
                            <span class="buyUserRequest__text"> İlan Ekle</span>
                            <span class="buyUserRequest__icon">
                                <img src="{{ asset('sc.png') }}" alt="" srcset="">
                            </span>
                        </button></a>
                    @endif
                    @endif

                </div>

            </div>

            <div class="card-body">
                <nav class="navbar" style="padding: 0 !important">
                    <div class="navbar-items">
                        <a class="navbar-item " href="{{ route('instituional.dashboard', Str::slug($store->name)) }}">Anasayfa</a>
                        <a class="navbar-item" href="{{ route('instituional.profile', Str::slug($store->name)) }}">Mağaza
                            Profili</a>
                        <a class="navbar-item" href="{{ route('instituional.projects.detail', Str::slug($store->name)) }}">Proje
                            İlanları</a>

                        <a class="navbar-item active" href="{{ route('instituional.housings', Str::slug($store->name)) }}">Emlak İlanları</a>
                    </div>
                    <form class="search-form" action="{{ route('instituional.search') }}" method="GET">
                        @csrf
                        <input class="search-input" type="search" placeholder="Mağazada Ara" id="search-project" aria-label="Search" name="q">
                        <div class="header-search__suggestions">
                            <div class="header-search__suggestions__section">
                                <h5>Projeler</h5>
                                <div class="header-search__suggestions__section__items">
                                    @foreach ($store->projects as $item)
                                    <a href="{{ route('project.detail', ['slug' => $item->slug]) }}" class="project-item" data-title="{{ $item->project_title }}"><span>{{ $item->project_title }}</span></a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <button class="search-button" type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- START SECTION RECENTLY PROPERTIES -->
<section class="featured portfolio rec-pro disc bg-white">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div class="section-title">
                <h2>Emlak İlanları</h2>
            </div>
        </div>
        <div class="mobile-show">
            @foreach ($secondhandHousings as $housing)
                @php($sold = $housing->sold)


                <div class="d-flex" style="flex-wrap: nowrap">
                    <div class="align-items-center d-flex " style="padding-right:0; width: 110px;">
                        <div class="project-inner project-head">
                            <a href="{{ route('housing.show', $housing->id) }}">
                                <div class="homes">
                                    <div class="homes-img h-100 d-flex align-items-center"
                                        style="width: 130px; height: 128px;">
                                        <img src="{{ URL::to('/') . '/housing_images/' . json_decode($housing->housing_type_data)->image }}"
                                            alt="{{ $housing->housing_title }}" class="img-responsive"
                                            style="height: 80px !important;">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="w-100" style="padding-left:0;">
                        <div class="bg-white px-3 h-100 d-flex flex-column justify-content-center">

                            <a style="text-decoration: none;height:100%"
                                href="{{ route('housing.show', $housing->id) }}">
                                <div class="d-flex" style="gap: 8px;justify-content:space-between;align-items:center">
                                    <h4>{{ mb_convert_case($housing->housing_title, MB_CASE_TITLE, 'UTF-8') }}
                                    </h4>
                                    @if (Auth::user()->type == 21)
                                    <span
                                        @if (isset(json_decode($housing->housing_type_data)->{"share-open"}) &&
                                                json_decode($housing->housing_type_data)->{"share-open"}[0]
                                        ) class="btn addCollection mobileAddCollection" data-bs-toggle="modal" data-bs-target="#addCollectionModal" data-type='housing' data-id="{{ $housing->id }}" 
                            @else
                            class="btn addCollection mobileAddCollection disabledShareButton" @endif>
                                        <i class="fa fa-bookmark"></i>
                                    </span>
                                @endif
                                    <span class="btn toggle-favorite bg-white" data-housing-id="{{ $housing->id }}"
                                        style="color: white;">
                                        <i class="fa fa-heart-o"></i>
                                    </span>
                                </div>
                            </a>
                            <div class="d-flex" style="align-items:Center">
                                <div class="d-flex" style="gap: 8px;">

                                    @if ($housing->step2_slug != 'gunluk-kiralik')
                                        @if (isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                            <button class="btn second-btn  mobileCBtn"
                                                style="background: #EA2B2E !important;width:100%;color:White">

                                                <span class="text">Satıldı</span>
                                            </button>
                                        @else
                                            @if ($sold != null && $sold != '2')
                                                <button class="btn mobileCBtn second-btn "
                                                    @if ($sold == '0') style="background: orange !important;width:100%;color:White"
                                                        @else 
                                                        style="background: red !important;width:100%;color:White" @endif>
                                                    <span class="IconContainer">
                                                        <img src="{{ asset('sc.png') }}" alt="">
                                                    </span>
                                                    @if ($sold == '0')
                                                        <span class="text">Rezerve Edildi</span>
                                                    @else
                                                        <span class="text">Satıldı</span>
                                                    @endif
                                                </button>
                                            @else
                                                <button class="CartBtn mobileCBtn" data-type='housing'
                                                    data-id='{{ $housing->id }}'>
                                                    <span class="IconContainer">
                                                        <img src="{{ asset('sc.png') }}" alt="">

                                                    </span>
                                                    <span class="text">Sepete Ekle</span>
                                                </button>
                                            @endif
                                        @endif
                                    @else
                                        <button onclick="redirectToReservation()" class="reservationBtn mobileCBtn">
                                            <span class="IconContainer">
                                                <img src="{{ asset('sc.png') }}" alt="">
                                            </span>
                                            <span class="text">Rezervasyon Yap</span>
                                        </button>

                                        <script>
                                            function redirectToReservation() {
                                                window.location.href = "{{ route('housing.show', [$housing->id]) }}";
                                            }
                                        </script>
                                    @endif
                                </div>
                                <span class="ml-auto text-primary priceFont">
                                    @if ($housing->discount_amount)
                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                            stroke-width="2" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" class="css-i6dzq1">
                                            <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                            <polyline points="17 18 23 18 23 12"></polyline>
                                        </svg>
                                    @endif
                                    @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                        @if ($sold)
                                            @if ($sold != '1' && $sold != '0')
                                                @if ($housing->step2_slug == 'gunluk-kiralik')
                                                    {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                    ₺
                                                    <span style="font-size:11px; color:Red" class="mobilePriceStyle">
                                                        1 Gece</span>
                                                @else
                                                    {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                    ₺
                                                @endif
                                            @endif
                                        @else
                                            @if ($housing->step2_slug == 'gunluk-kiralik')
                                                {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                ₺
                                                <span style="font-size:11px; color:Red" class="mobilePriceStyle"> 1
                                                    Gece</span>
                                            @else
                                                {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                ₺
                                            @endif
                                        @endif
                                    @endif

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100" style="height:40px;background-color:#8080802e;margin-top:20px">
                    <div class="d-flex justify-content-between align-items-center" style="height: 100%;padding: 10px">
                        <ul class="d-flex align-items-center h-100"
                            style="list-style: none;padding:0;font-weight:600;justify-content:start;margin-bottom:0 !important">


                            @if ($housing->column1_name)
                                <li class="d-flex align-items-center itemCircleFont">

                                    <i class="fa fa-circle circleIcon mr-1"></i>
                                    <span>{{ json_decode($housing->housing_type_data)->{$housing->column1_name}[0] ?? null }}
                                        @if ($housing->column1_additional)
                                            {{ $housing->column1_additional }}
                                        @endif
                                    </span>
                                </li>
                            @endif

                            @if ($housing->column2_name)
                                <li class="d-flex align-items-center itemCircleFont">

                                    <i class="fa fa-circle circleIcon mr-1"></i>
                                    <span>{{ json_decode($housing->housing_type_data)->{$housing->column2_name}[0] ?? null }}
                                        @if ($housing->column2_additional)
                                            {{ $housing->column2_additional }}
                                        @endif
                                    </span>
                                </li>
                            @endif

                            @if ($housing->column3_name)
                                <li class="d-flex align-items-center itemCircleFont">

                                    <i class="fa fa-circle circleIcon mr-1"></i>
                                    <span>{{ json_decode($housing->housing_type_data)->{$housing->column3_name}[0] ?? null }}
                                        @if ($housing->column3_additional)
                                            {{ $housing->column3_additional }}
                                        @endif
                                    </span>
                                </li>
                            @endif

                            @if ($housing->column4_name)
                                <li class="d-flex align-items-center itemCircleFont">

                                    <i class="fa fa-circle circleIcon mr-1"></i>
                                    <span>{{ json_decode($housing->housing_type_data)->{$housing->column4_name}[0] ?? null }}
                                        @if ($housing->column4_additional)
                                            {{ $housing->column4_additional }}
                                        @endif
                                    </span>
                                </li>
                            @endif



                        </ul>
                        <span style="font-size: 11px !important">{!! $housing->city_title !!}
                            {{ '/' }} {!! $housing->county_title !!}
                        </span>
                    </div>

                </div>
                <hr>
            @endforeach
        </div>

        <div class="mobile-hidden">
            @if (count($secondhandHousings))
                <section class="properties-right list featured portfolio blog  pb-5 bg-white">
                    <div class="container">
                        <div class="row project-filter-reverse blog-pots secondhand-housings-web">
                            @foreach ($secondhandHousings as $housing)
                                @php($sold = $housing->sold)

                                @if ($sold)
                                    @if ($sold != '1')
                                        <a href="{{ route('housing.show', [$housing->id]) }}"
                                            class="text-decoration-none">
                                            <div data-aos="fade-up" data-aos-delay="150">
                                                <div class="landscapes">
                                                    <div class="project-single">
                                                        <div class="project-inner project-head">
                                                            <div class="homes">
                                                                <div class="homes-img">
                                                                    <div class="homes-tag button alt featured">
                                                                        Sponsorlu
                                                                    </div>
                                                                    <div class="type-tag button alt featured">
                                                                        @if ($housing->step2_slug == 'kiralik')
                                                                            Kiralık
                                                                        @elseif ($housing->step2_slug == 'gunluk-kiralik')
                                                                            Günlük Kiralık
                                                                        @else
                                                                            Satılık
                                                                        @endif
                                                                    </div>
                                                                    @if ($housing->discount_amount)
                                                                        <div class="homes-tag button alt sale"
                                                                            style="background-color:#EA2B2E!important">
                                                                            İNDİRİM
                                                                        </div>
                                                                    @endif
                                                                    <img src="{{ URL::to('/') . '/housing_images/' . json_decode($housing->housing_type_data)->image }}"
                                                                        alt="{{ $housing->housing_title }}"
                                                                        class="img-responsive">
                                                                </div>
                                                            </div>
                                                            <div class="button-effect">
                                                                <span class="btn toggle-favorite bg-white"
                                                                    data-housing-id={{ $housing->id }}>
                                                                    <i class="fa fa-heart-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="homes-content p-3"
                                                            style="padding:20px !important">
                                                            <span style="text-decoration: none">

                                                                <h4 style="height:30px">
                                                                    {{ mb_substr(mb_convert_case($housing->housing_title, MB_CASE_TITLE, 'UTF-8'), 0, 45, 'UTF-8') }}
                                                                    {{ mb_strlen($housing->housing_title, 'UTF-8') > 25 ? '...' : '' }}
                                                                </h4>


                                                                <p class="homes-address mb-3">


                                                                    <i class="fa fa-map-marker"></i>
                                                                    <span> {{ $housing->city_title }}
                                                                        {{ '/' }}
                                                                        {{ $housing->county_title }}
                                                                    </span>

                                                                </p>
                                                            </span>
                                                            <!-- homes List -->
                                                            <ul class="homes-list clearfix pb-0"
                                                                style="display: flex;justify-content:space-between">
                                                                <li class="sude-the-icons"
                                                                    style="width:auto !important">
                                                                    <i class="fa fa-circle circleIcon mr-1"></i>
                                                                    <span>
                                                                        {{ json_decode($housing->housing_type_data)->{$housing->column1_name}[0] ?? null }}
                                                                        @if ($housing->column1_additional)
                                                                            {{ $housing->column1_additional }}
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                                @if ($housing->column2_name)
                                                                    <li class="sude-the-icons"
                                                                        style="width:auto !important">
                                                                        <i class="fa fa-circle circleIcon mr-1"></i>
                                                                        <span>{{ json_decode($housing->housing_type_data)->{$housing->column2_name}[0] ?? null }}
                                                                            @if ($housing->column2_additional)
                                                                                {{ $housing->column2_additional }}
                                                                            @endif
                                                                        </span>
                                                                    </li>
                                                                @endif

                                                                @if ($housing->column3_name)
                                                                    <li class="sude-the-icons"
                                                                        style="width:auto !important">
                                                                        <i class="fa fa-circle circleIcon mr-1"></i>
                                                                        <span>{{ json_decode($housing->housing_type_data)->{$housing->column3_name}[0] ?? null }}
                                                                            @if ($housing->column3_additional)
                                                                                {{ $housing->column3_additional }}
                                                                            @endif
                                                                        </span>
                                                                    </li>
                                                                @endif

                                                                @if ($housing->column4_name)
                                                                    <li class="sude-the-icons"
                                                                        style="width:auto !important">
                                                                        <i class="fa fa-circle circleIcon mr-1"></i>
                                                                        <span>{{ json_decode($housing->housing_type_data)->{$housing->column4_name}[0] ?? null }}
                                                                            @if ($housing->column4_additional)
                                                                                {{ $housing->column4_additional }}
                                                                            @endif
                                                                        </span>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                            <ul class="homes-list clearfix pb-0"
                                                                style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                                <li
                                                                    style="font-size: 16px; font-weight: 700;width:100%; white-space:nowrap">
                                                                    @if ($housing->discount_amount)
                                                                        <svg viewBox="0 0 24 24" width="24"
                                                                            height="24" stroke="currentColor"
                                                                            stroke-width="2" fill="none"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            class="css-i6dzq1">
                                                                            <polyline
                                                                                points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                            </polyline>
                                                                            <polyline points="17 18 23 18 23 12">
                                                                            </polyline>
                                                                        </svg>
                                                                    @endif

                                                                    @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                                        @if ($sold)
                                                                            @if ($sold != '1' && $sold != '0')
                                                                                @if ($housing->step2_slug == 'gunluk-kiralik')
                                                                                    {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                                                    ₺
                                                                                    <span
                                                                                        style="font-size:11px; color:#EA2B2E">/
                                                                                        1 Gece</span>
                                                                                @else
                                                                                    {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                                                    ₺
                                                                                @endif
                                                                            @endif
                                                                        @else
                                                                            @if ($housing->step2_slug == 'gunluk-kiralik')
                                                                                {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                                                ₺
                                                                                <span
                                                                                    style="font-size:11px; color:#EA2B2E">/
                                                                                    1 Gece</span>
                                                                            @else
                                                                                {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                                                ₺
                                                                            @endif
                                                                        @endif
                                                                    @endif


                                                                </li>
                                                                <li
                                                                    style="display: flex; justify-content: right;width:100%">
                                                                    {{ date('j', strtotime($housing->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($housing->created_at))) }}
                                                                </li>
                                                            </ul>

                                                            @if ($housing->step2_slug != 'gunluk-kiralik')
                                                                @if (isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                                    <button class="btn second-btn "
                                                                        style="background: red !important;width:100%;color:White">

                                                                        <span class="text">Satıldı</span>
                                                                    </button>
                                                                @else
                                                                    @if ($sold != null && $sold != '2')
                                                                        <button class="btn second-btn "
                                                                            @if ($sold == '0') style="background: orange !important;width:100%;color:White" @else  style="background: red !important;width:100%;color:White" @endif>
                                                                            @if ($sold == '0')
                                                                                <span class="text">Onay
                                                                                    Bekleniyor</span>
                                                                            @else
                                                                                <span class="text">Satıldı</span>
                                                                            @endif
                                                                        </button>
                                                                    @else
                                                                        <button class="CartBtn" data-type='housing'
                                                                            data-id='{{ $housing->id }}'>
                                                                            <span class="IconContainer">
                                                                                <img src="{{ asset('sc.png') }}"
                                                                                    alt="">
                                                                            </span>
                                                                            <span class="text">Sepete Ekle</span>
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                            @else
                                                                <button onclick="redirectToReservation()"
                                                                    class="reservationBtn">
                                                                    <span class="IconContainer">
                                                                        <img src="{{ asset('sc.png') }}"
                                                                            alt="">
                                                                    </span>
                                                                    <span class="text">Rezervasyon Yap</span>
                                                                </button>

                                                                <script>
                                                                    function redirectToReservation() {
                                                                        window.location.href = "{{ route('housing.show', [$housing->id]) }}";
                                                                    }
                                                                </script>
                                                            @endif


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('housing.show', [$housing->id]) }}"
                                        class="text-decoration-none">
                                        <div data-aos="fade-up" data-aos-delay="150">
                                            <div class="landscapes">
                                                <div class="project-single">
                                                    <div class="project-inner project-head">
                                                        <div class="homes">
                                                            <div class="homes-img">
                                                                <div class="homes-tag button alt featured">Sponsorlu
                                                                </div>
                                                                <div class="type-tag button alt featured">
                                                                    @if ($housing->step2_slug == 'kiralik')
                                                                        Kiralık
                                                                    @elseif ($housing->step2_slug == 'gunluk-kiralik')
                                                                        Günlük Kiralık
                                                                    @else
                                                                        Satılık
                                                                    @endif
                                                                </div>
                                                                @if ($housing->discount_amount)
                                                                    <div class="homes-tag button alt sale"
                                                                        style="background-color:#EA2B2E!important">
                                                                        İNDİRİM
                                                                    </div>
                                                                @endif
                                                                <img src="{{ URL::to('/') . '/housing_images/' . json_decode($housing->housing_type_data)->image }}"
                                                                    alt="{{ $housing->housing_title }}"
                                                                    class="img-responsive">
                                                            </div>
                                                        </div>
                                                        <div class="button-effect-div">
                                                            @if (Auth::user()->type == 21)
                                                                <span
                                                                    @if (isset(json_decode($housing->housing_type_data)->{"share-open"}) &&
                                                                            json_decode($housing->housing_type_data)->{"share-open"}[0]
                                                                    ) class="btn addCollection" data-bs-toggle="modal" data-bs-target="#addCollectionModal" data-type='housing' data-id="{{ $housing->id }}" 
                                                        @else
                                                        class="btn addCollection disabledShareButton" @endif>
                                                                    <i class="fa fa-bookmark"></i>
                                                                </span>
                                                            @endif

                                                            <span class="btn toggle-favorite bg-white"
                                                                data-housing-id={{ $housing->id }}>
                                                                <i class="fa fa-heart-o"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="homes-content p-3" style="padding:20px !important">
                                                        <span style="text-decoration: none">

                                                            <h4 style="height:30px">
                                                                {{ mb_substr(mb_convert_case($housing->housing_title, MB_CASE_TITLE, 'UTF-8'), 0, 45, 'UTF-8') }}
                                                                {{ mb_strlen($housing->housing_title, 'UTF-8') > 25 ? '...' : '' }}
                                                            </h4>


                                                            <p class="homes-address mb-3">


                                                                <i class="fa fa-map-marker"></i>
                                                                <span> {{ $housing->city_title }}
                                                                    {{ '/' }}
                                                                    {{ $housing->county_title }}
                                                                </span>

                                                            </p>
                                                        </span>
                                                        <!-- homes List -->
                                                        <ul class="homes-list clearfix pb-0"
                                                            style="display: flex;justify-content:space-between">
                                                            <li class="sude-the-icons" style="width:auto !important">
                                                                <i class="fa fa-circle circleIcon mr-1"></i>
                                                                <span>
                                                                    {{ json_decode($housing->housing_type_data)->{$housing->column1_name}[0] ?? null }}
                                                                    @if ($housing->column1_additional)
                                                                        {{ $housing->column1_additional }}
                                                                    @endif
                                                                </span>
                                                            </li>
                                                            @if ($housing->column2_name)
                                                                <li class="sude-the-icons"
                                                                    style="width:auto !important">
                                                                    <i class="fa fa-circle circleIcon mr-1"></i>
                                                                    <span>{{ json_decode($housing->housing_type_data)->{$housing->column2_name}[0] ?? null }}
                                                                        @if ($housing->column2_additional)
                                                                            {{ $housing->column2_additional }}
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                            @endif

                                                            @if ($housing->column3_name)
                                                                <li class="sude-the-icons"
                                                                    style="width:auto !important">
                                                                    <i class="fa fa-circle circleIcon mr-1"></i>
                                                                    <span>{{ json_decode($housing->housing_type_data)->{$housing->column3_name}[0] ?? null }}
                                                                        @if ($housing->column3_additional)
                                                                            {{ $housing->column3_additional }}
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                            @endif

                                                            @if ($housing->column4_name)
                                                                <li class="sude-the-icons"
                                                                    style="width:auto !important">
                                                                    <i class="fa fa-circle circleIcon mr-1"></i>
                                                                    <span>{{ json_decode($housing->housing_type_data)->{$housing->column4_name}[0] ?? null }}
                                                                        @if ($housing->column4_additional)
                                                                            {{ $housing->column4_additional }}
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                        <ul class="homes-list clearfix pb-0"
                                                            style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                            <li
                                                                style="font-size: 16px; font-weight: 700;width:100%; white-space:nowrap">
                                                                @if ($housing->discount_amount)
                                                                    <svg viewBox="0 0 24 24" width="24"
                                                                        height="24" stroke="currentColor"
                                                                        stroke-width="2" fill="none"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="css-i6dzq1">
                                                                        <polyline points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                        </polyline>
                                                                        <polyline points="17 18 23 18 23 12">
                                                                        </polyline>
                                                                    </svg>
                                                                @endif

                                                                @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                                    @if ($sold)
                                                                        @if ($sold != '1' && $sold != '0')
                                                                            @if ($housing->step2_slug == 'gunluk-kiralik')
                                                                                {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                                                ₺
                                                                                <span
                                                                                    style="font-size:11px; color:#EA2B2E">/
                                                                                    1 Gece</span>
                                                                            @else
                                                                                {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                                                ₺
                                                                            @endif
                                                                        @endif
                                                                    @else
                                                                        @if ($housing->step2_slug == 'gunluk-kiralik')
                                                                            {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                                            ₺
                                                                            <span
                                                                                style="font-size:11px; color:#EA2B2E">/
                                                                                1 Gece</span>
                                                                        @else
                                                                            {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                                            ₺
                                                                        @endif
                                                                    @endif
                                                                @endif


                                                            </li>
                                                            <li
                                                                style="display: flex; justify-content: right;width:100%">
                                                                {{ date('j', strtotime($housing->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($housing->created_at))) }}
                                                            </li>
                                                        </ul>

                                                        @if ($housing->step2_slug != 'gunluk-kiralik')
                                                            @if (isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                                <button class="btn second-btn "
                                                                    style="background: red !important;width:100%;color:White">

                                                                    <span class="text">Satıldı</span>
                                                                </button>
                                                            @else
                                                                @if ($sold != null && $sold != '2')
                                                                    <button class="btn second-btn "
                                                                        @if ($sold == '0') style="background: orange !important;width:100%;color:White" @else  style="background: red !important;width:100%;color:White" @endif>
                                                                        @if ($sold == '0')
                                                                            <span class="text">Rezerve Edildi</span>
                                                                        @else
                                                                            <span class="text">Satıldı</span>
                                                                        @endif
                                                                    </button>
                                                                @else
                                                                    <button class="CartBtn" data-type='housing'
                                                                        data-id='{{ $housing->id }}'>
                                                                        <span class="IconContainer">
                                                                            <img src="{{ asset('sc.png') }}"
                                                                                alt="">

                                                                        </span>
                                                                        <span class="text">Sepete Ekle</span>
                                                                    </button>
                                                                @endif
                                                            @endif
                                                        @else
                                                            <button onclick="redirectToReservation()"
                                                                class="reservationBtn">
                                                                <span class="IconContainer">
                                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                                </span>
                                                                <span class="text">Rezervasyon Yap</span>
                                                            </button>

                                                            <script>
                                                                function redirectToReservation() {
                                                                    window.location.href = "{{ route('housing.show', [$housing->id]) }}";
                                                                }
                                                            </script>
                                                        @endif


                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </section>
            @else
                <p>Henüz İlan Yayınlanmadı</p>
            @endif
        </div>
    </div>
</section>




@endsection

@section('scripts')
<!-- lightbox2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- lightbox2 JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function() {
        $('.banner-agents').slick({
            infinite: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            dots: false,
            loop: true,
            autoplay: true,
            arrows: true,
            nav: true,
            margin: 0,
            adaptiveHeight: true,
            responsive: [{
                breakpoint: 1292,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: true
                }
            }, {
                breakpoint: 993,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: true
                }
            }, {
                breakpoint: 769,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: false
                }
            }]
        });
    });
    $('#search-project').on('input', function() {
        let val = $(this).val();
        $('.project-item').each(function() {
            if ($(this).data('title').toLowerCase().search(val) == -1)
                $(this).addClass('d-none');
            else
                $(this).removeClass('d-none');
        });
    });
</script>

<script>
    $('.finish-projects-web').slick({
        loop: true,
        nav: false,
        slidesToShow: 4,
        margin: 10,
    })

    $('.continue-projects-web').slick({
        loop: true,
        nav: false,
        slidesToShow: 4,
        margin: 10,
    })

    $('.secondhand-housings-web').slick({
        loop: true,
        nav: false,
        slidesToShow: 4,
        margin: 10,
    });
</script>
@endsection

@section('styles')
<style>
    .slick-track {
        margin: 0 !important;
    }

    .slick-slide {
        margin: 10px
    }

    .section-title h2 {
        color: black !important
    }

    .section-title:before {
        background-color: black !important
    }

    .bannerResize,
    .bannerResizeGrid {
        padding: 0 !important;
    }

    @media (max-width: 768px) {

        .bannerResize,
        .bannerResizeGrid {
            padding: 0 !important;
        }

        .section-title {
            margin-bottom: 20px !important;
            padding-bottom: 0 !important;
        }

        .circleIcon {
            font-size: 5px;
            color: #e54242;
            padding-right: 5px
        }

        .priceFont {
            font-weight: 600;
            font-size: 12px;
        }
    }
</style>
@endsection