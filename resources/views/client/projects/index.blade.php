@extends('client.layouts.master')

@section('content')

    @php

        function implodeData($array)
        {
            $html = '';

            for ($i = 0; $i < count($array); $i++) {
                if ($i == 0) {
                    $html .= ' ' . $array[$i];
                } else {
                    $html .= ', ' . $array[$i];
                }
            }

            return $html;
        }
        $projectHousings = [];
        $projectDiscountAmount = null;
    @endphp


    @foreach ($offer as $item)
        @php
            $projectHousings = json_decode($item['project_housings'], true);
            $projectDiscountAmount = $item['discount_amount'];
        @endphp
    @endforeach

    <div class="loading-full d-none">
        <div class="back-opa">

        </div>
        <div class="content-loading">
            <i class="fa fa-spinner"></i>
        </div>
    </div>
    <div class="brand-head">
        <div class="container">
            <div class="card mb-3">
                <div class="card-img-top" style="background-color: {{ $project->user->banner_hex_code }}">
                    <div class="brands-square">
                        <img src="{{ url('storage/profile_images/' . $project->user->profile_image) }}" alt=""
                            class="brand-logo">
                        <p class="brand-name"><a
                                href="{{ route('institutional.profile', ['slug' => Str::slug($project->user->name), 'userID' => $project->user->id]) }}"
                                style="color:White;">
                                {{ $project->user->name }}
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
                                @if ($project->user->corporate_account_status)
                                    <svg id="Layer_1" style="enable-background:new 0 0 120 120;" version="1.1"
                                        width="24px" height="24px" viewBox="0 0 120 120" xml:space="preserve"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <g>
                                            <path class="st0"
                                                d="M99.5,52.8l-1.9,4.7c-0.6,1.6-0.6,3.3,0,4.9l1.9,4.7c1.1,2.8,0.2,6-2.3,7.8L93,77.8c-1.4,1-2.3,2.5-2.7,4.1   l-0.9,5c-0.6,3-3.1,5.2-6.1,5.3l-5.1,0.2c-1.7,0.1-3.3,0.8-4.5,2l-3.5,3.7c-2.1,2.2-5.4,2.7-8,1.2l-4.4-2.6   c-1.5-0.9-3.2-1.1-4.9-0.7l-5,1.2c-2.9,0.7-6-0.7-7.4-3.4l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8   l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8   l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6c1.4-2.7,4.4-4.1,7.4-3.4l5,1.2c1.6,0.4,3.4,0.2,4.9-0.7l4.4-2.6c2.6-1.5,5.9-1.1,8,1.2   l3.5,3.7c1.2,1.2,2.8,2,4.5,2l5.1,0.2c3,0.1,5.6,2.3,6.1,5.3l0.9,5c0.3,1.7,1.3,3.2,2.7,4.1l4.2,2.9C99.7,46.8,100.7,50,99.5,52.8z   " />
                                            <g class="st1">
                                                <path
                                                    d="M43.4,93.5l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4    c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6    c0.8-1.6,2.2-2.7,3.7-3.2c-2.7-0.4-5.4,1-6.6,3.5l-2.3,4.6c-0.8,1.5-2.1,2.7-3.7,3.2l-4.8,1.6c-2.9,1-4.7,3.8-4.4,6.8l0.5,5.1    c0.2,1.7-0.3,3.4-1.4,4.7l-3.2,4c-1.9,2.4-1.9,5.7,0,8.1l3.2,4c1.1,1.3,1.6,3,1.4,4.7l-0.5,5.1c-0.3,3,1.5,5.8,4.4,6.8l4.8,1.6    c1.6,0.5,2.9,1.7,3.7,3.2l2.3,4.6c1.4,2.7,4.4,4.1,7.4,3.4l0.6-0.1C46.3,96.7,44.4,95.5,43.4,93.5z" />
                                                <path
                                                    d="M60.6,22.5l4.4-2.6c0.4-0.2,0.8-0.4,1.2-0.5c-1.4-0.2-2.9,0.1-4.1,0.8l-4.4,2.6c-0.4,0.2-0.8,0.4-1.2,0.5    C57.9,23.5,59.3,23.3,60.6,22.5z" />
                                                <path
                                                    d="M81,92c-0.5,0-1,0.1-1.4,0.2l3.6-0.2c0.5,0,0.9-0.1,1.4-0.2L81,92z" />
                                                <path
                                                    d="M65,98.9l-4.4-2.6c-1.5-0.9-3.2-1.1-4.9-0.7l-0.6,0.1c0.9,0.1,1.7,0.4,2.5,0.8l4.4,2.6c1.7,1,3.6,1.1,5.4,0.5    C66.6,99.6,65.8,99.4,65,98.9z" />
                                            </g>
                                            <polyline class="st0" points="44,53.6 56.5,67.9 82.1,47.3  " />
                                            <path class="st2"
                                                d="M53.5,75.3c-1.4,0-2.8-0.6-3.8-1.7L37.2,59.3c-1.8-2.1-1.6-5.2,0.4-7.1c2.1-1.8,5.2-1.6,7.1,0.4l9.4,10.7   l21.9-17.6c2.1-1.7,5.3-1.4,7,0.8c1.7,2.2,1.4,5.3-0.8,7L56.6,74.2C55.7,74.9,54.6,75.3,53.5,75.3z" />
                                        </g>
                                    </svg>
                                @endif
                            </a></p>
                        <div class="mobile-hidden">
                            <p class="brand-name"><i class="fa fa-angle-right"></i> </p>
                            <p class="brand-name">{{ $project->project_title }}</p>
                        </div>
                    </div>


                </div>
                <div class="card-body">
                    <nav class="navbar" style="padding: 0 !important">
                        <div class="navbar-items">
                            <a class="navbar-item"
                                href="{{ route('institutional.dashboard', ['slug' => Str::slug($project->user->name), 'userID' => $project->user->id]) }}">Anasayfa</a>
                            <a class="navbar-item"
                                href="{{ route('institutional.profile', ['slug' => Str::slug($project->user->name), 'userID' => $project->user->id]) }}">Mağaza
                                Profili</a>
                            <a class="navbar-item"
                                href="{{ route('institutional.projects.detail', ['slug' => Str::slug($project->user->name), 'userID' => $project->user->id]) }}">Proje
                                İlanları</a>
                            <a class="navbar-item"
                                href="{{ route('institutional.housings', ['slug' => Str::slug($project->user->name), 'userID' => $project->user->id]) }}">Emlak
                                İlanları</a>
                            <a class="navbar-item"
                                href="{{ route('institutional.teams', ['slug' => Str::slug($project->user->name), 'userID' => $project->user->id]) }}">Ekip</a>
                        </div>
                        <form class="search-form" action="{{ route('institutional.search') }}" method="GET">
                            @csrf
                            <input class="search-input" type="search" placeholder="Mağazada Ara" id="search-project"
                                aria-label="Search" name="q">
                            <div class="header-search__suggestions">
                                <div class="header-search__suggestions__section">
                                    <h5>Projeler</h5>
                                    <div class="header-search__suggestions__section__items">
                                        @foreach ($project->user->projects as $item)
                                            <a href="{{ route('project.detail', ['slug' => $item->slug, 'id' => $item->id]) }}"
                                                class="project-item"
                                                data-title="{{ $item->project_title }}"><span>{{ $item->project_title }}</span></a>
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


    <section class="recently  bg-white homepage-5 ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="headings-2 pt-0 pb-0">
                        <div class="pro-wrapper mb-3" style="width: 100%; justify-content: space-between;">

                            <div class="detail-wrapper-body">
                                <div class="listing-title-bar">
                                    <strong
                                        style="color: black;font-size: 11px !important;text-align:left;width:100%;display:block">İlan
                                        No: <span style="color: #274abb;">{{ $project->id + 1000000 }}</span></strong>
                                    <h3>{{ $project->project_title }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="headings-2 pt-0 pb-0">

                        <div id="listingDetailsSlider" class="carousel listing-details-sliders slide mb-30">
                            <div class="homes-tag button alt featured mobileTagProject">
                                <a href="javascript:void()" style="color:White;">{{ $project->project_title }}</a>
                            </div>
                            <div class="carousel-inner">

                                {{-- Kapak Görseli --}}
                                <div class="item carousel-item active" data-slide-number="0">
                                    <a href="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[1]['image[]'] }}"
                                        data-lightbox="image-gallery">
                                        <img src="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[1]['image[]'] }}"
                                            class="img-fluid" alt="slider-listing">
                                    </a>
                                </div>

                                {{-- Diğer Görseller --}}
                                @foreach ($project->images as $key => $housingImage)
                                    <div class="item carousel-item" data-slide-number="{{ $key + 1 }}">
                                        <a href="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $housingImage->image) }}"
                                            data-lightbox="image-gallery">
                                            <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $housingImage->image) }}"
                                                class="img-fluid" alt="slider-listing">
                                        </a>
                                    </div>
                                @endforeach


                                {{-- Carousel Kontrolleri --}}
                                <a class="carousel-control left" href="#listingDetailsSlider" data-slide="prev"><i
                                        class="fa fa-angle-left"></i></a>
                                <a class="carousel-control right" href="#listingDetailsSlider" data-slide="next"><i
                                        class="fa fa-angle-right"></i></a>
                            </div>

                            {{-- Küçük Resim Navigasyonu --}}
                            <div class="listingDetailsSliderNav mt-3">
                                <div class="item active" style="margin: 10px; cursor: pointer">
                                    <a id="carousel-selector-0" data-slide-to="0" data-target="#listingDetailsSlider">
                                        <img src="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[1]['image[]'] }}"
                                            class="img-fluid carousel-indicator-image" alt="listing-small">
                                    </a>
                                </div>

                                {{-- Diğer Görseller --}}
                                @foreach ($project->images as $key => $housingImage)
                                    <div class="item" style="margin: 10px; cursor: pointer">
                                        <a id="carousel-selector-{{ $key + 1 }}"
                                            data-slide-to="{{ $key + 1 }}" data-target="#listingDetailsSlider">
                                            <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $housingImage->image) }}"
                                                class="img-fluid carousel-indicator-image" alt="listing-small">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mobileMove">
                        <div class="single widget storeInfo ">
                            <div class="widget-boxed">
                                <div class="widget-boxed-body" style="padding: 0 !important">
                                    <div class="sidebar-widget author-widget2">
                                        <h2 class="classifiedInfo"> {!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}
                                            @if ($project->neighbourhood)
                                                {!! ' / ' . optional($project->neighbourhood)->mahalle_title !!}
                                            @endif
                                        </h2>
                                        {{-- <div class="author-box clearfix d-flex align-items-center">
                                            <img src="{{ URL::to('/') . '/storage/profile_images/' . $project->user->profile_image }}"
                                                alt="author-image" class="author__img">
                                            <div> <a
                                                    href="{{ route('institutional.dashboard', Str::slug($project->user->name)) }}">
                                                    <h4 class="author__title">{!! $project->user->name !!}</h4>
                                                </a>
                                                <p class="author__meta">
                                                    {{ $project->user->corporate_type == 'Emlakçı' ? 'Gayrimenkul Ofisi' : $project->user->corporate_type }}
                                                </p>
                                            </div>
                                        </div> --}}
                                        <table class="table homes-content" style="margin-bottom: 0 !important">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <span class="autoWidthTr">Proje Durumu:</span>
                                                        <span class="det"
                                                            style="color: black;">{{ $status->name }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong class="autoWidthTr">Mağaza:</strong>
                                                        <span class="det"
                                                            style="color: black;">{!! $project->user->name !!}</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <span class="autoWidthTr">Telefon:</span>
                                                        <span class="det"
                                                            style="color: black;">{!! $project->user->phone ? $project->user->phone : 'Belirtilmedi' !!}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <strong class="autoWidthTr"><span>E-Posta:</span></strong>
                                                        <span class="det"
                                                            style="color: black;">{!! $project->user->email !!}</span>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td colspan="2">
                                                        <strong class="autoWidthTr"><span>
                                                                @if ($project->neighbourhood)
                                                                    {!! 'İl-İlçe-Mahalle:' !!}
                                                                @else
                                                                    {!! 'İl-İlçe:' !!}
                                                                @endif
                                                            </span></strong>
                                                        <span class="det"
                                                            style="color: black;font-size:10px !important">
                                                            {!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}
                                                            @if ($project->neighbourhood)
                                                                {!! ' / ' . optional($project->neighbourhood)->mahalle_title !!}
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="autoWidthTr">Yapımcı Firma:</span>
                                                        <span class="det"
                                                            style="color: black;">{{ $project->create_company ? $project->create_company : 'Belirtilmedi' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="autoWidthTr">Başlangıç Tarihi:</span>
                                                        <span class="det" style="color: black;">
                                                            {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d.m.Y') : 'Belirtilmedi' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="autoWidthTr">Bitiş Tarihi:</span>
                                                        <span class="det" style="color: black;">
                                                            {{ $project->project_end_date ? \Carbon\Carbon::parse($project->project_end_date)->format('d.m.Y') : 'Belirtilmedi' }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <span class="autoWidthTr">Toplam Proje Alanı m<sup>2</sup>:</span>
                                                        <span class="det"
                                                            style="color: black;">{{ $project->total_project_area ? $project->total_project_area : 'Belirtilmedi' }}</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <strong class="autoWidthTr"><span>{{ ucfirst($project->step1_slug) }}
                                                                Tipi:</span></strong>
                                                        <span class="det"
                                                            style="color: black;">{{ $project->housingtype->title }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <strong class="autoWidthTr"><span>Toplam
                                                                @if (isset($projectHousingsList[1]['share-sale[]']) && $projectHousingsList[1]['share-sale[]'] != '[]')
                                                                    Hisse
                                                                @else
                                                                    {{ ucfirst($project->step1_slug) }}
                                                                @endif
                                                                Sayısı:
                                                            </span></strong>
                                                        <span class="det"
                                                            style="color: black;">{{ $project->room_count }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <strong class="autoWidthTr"><span>Satışa Açık
                                                                @if (isset($projectHousingsList[1]['share-sale[]']) && $projectHousingsList[1]['share-sale[]'] != '[]')
                                                                    Hisse
                                                                @else
                                                                    {{ ucfirst($project->step1_slug) }}
                                                                @endif
                                                                Sayısı:
                                                            </span></strong>
                                                        <span class="det"
                                                            style="color: black;">{{ $project->room_count - $project->cartOrders - $salesCloseProjectHousingCount }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <strong class="autoWidthTr"><span>Satılan
                                                                @if (isset($projectHousingsList[1]['share-sale[]']) && $projectHousingsList[1]['share-sale[]'] != '[]')
                                                                    Hisse
                                                                @else
                                                                    {{ ucfirst($project->step1_slug) }}
                                                                @endif
                                                                Sayısı:
                                                            </span></strong>
                                                        <span class="det"
                                                            style="color: black;">{{ $project->cartOrders }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <strong class="autoWidthTr"><span>Satışa Kapalı
                                                                @if (isset($projectHousingsList[1]['share-sale[]']) && $projectHousingsList[1]['share-sale[]'] != '[]')
                                                                    Hisse
                                                                @else
                                                                    {{ ucfirst($project->step1_slug) }}
                                                                @endif
                                                                Sayısı:
                                                            </span></strong>
                                                        <span class="det"
                                                            style="color: black;">{{ $salesCloseProjectHousingCount }}</span>
                                                    </td>
                                                </tr>
                                            </tbody>

                                        </table>


                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    @php
        function getData($project, $key, $roomOrder)
        {
            foreach ($project->roomInfo as $room) {
                if ($room->room_order == $roomOrder && $room->name == $key) {
                    return $room;
                }
            }
        }
    @endphp


    <section class="single-proper blog details bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="contact-tab" data-bs-toggle="tab"
                                data-bs-target="#contact" type="button" role="tab" aria-controls="contact"
                                aria-selected="false">Projedeki
                                Konutlar</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                type="button" role="tab" aria-controls="home"
                                aria-selected="true">Açıklama</button>
                        </li>
                        <li class="nav-item d-lg-none" role="presentation">
                            <button class="nav-link" id="general-tab" data-bs-toggle="tab" data-bs-target="#general"
                                type="button" role="tab" aria-controls="general" aria-selected="true">Genel
                                Bilgi</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab" aria-controls="profile"
                                aria-selected="false">Özellikler</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#map"
                                type="button" role="tab" aria-controls="contact"
                                aria-selected="false">Harita</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="situation-tab" data-bs-toggle="tab" data-bs-target="#situation"
                                type="button" role="tab" aria-controls="situation"
                                aria-selected="false">Vaziyet&Kat Planı</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane d-lg-none fade blog-info details mb-30 single homes-content" id="general"
                            role="tabpanel" aria-labelledby="general-tab">

                            <table class="table" style="margin-bottom: 0 !important">
                                <tbody class="trStyle">
                                    <tr>
                                        <td colspan="2">
                                            <strong><span class="mr-1">Proje Adı:</span></strong>
                                            <span class="det"
                                                style="color: black;">{{ $project->project_title }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="mr-1">Proje Durumu:</span>
                                            <span class="det" style="color: black;">{{ $status->name }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="mr-1">Mağaza:</span>
                                            <span class="det" style="color: black;">{!! $project->user->name !!}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong><span class="mr-1">
                                                    @if ($project->neighbourhood)
                                                        {!! 'İl-İlçe-Mahalle:' !!}
                                                    @else
                                                        {!! 'İl-İlçe:' !!}
                                                    @endif
                                                </span></strong>
                                            <span class="det" style="color: black;">
                                                {!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}
                                                @if ($project->neighbourhood)
                                                    {!! ' / ' . optional($project->neighbourhood)->mahalle_title !!}
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="mr-1">Telefon:</span>
                                            <span class="det" style="color: black;">{!! $project->user->phone ? $project->user->phone : 'Belirtilmedi' !!}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong><span class="mr-1">E-Posta:</span></strong>
                                            <span class="det" style="color: black;">{!! $project->user->email !!}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong><span class="mr-1">{{ ucfirst($project->step1_slug) }}
                                                    Tipi:</span></strong>
                                            <span class="det"
                                                style="color: black;">{{ $project->housingtype->title }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong><span class="mr-1">Toplam {{ ucfirst($project->step1_slug) }}
                                                    Sayısı:</span></strong>
                                            <span class="det" style="color: black;">{{ $project->room_count }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong><span class="mr-1">Satışa Açık {{ ucfirst($project->step1_slug) }}
                                                    Sayısı:</span></strong>
                                            <span class="det"
                                                style="color: black;">{{ $project->room_count - $project->cartOrders - $salesCloseProjectHousingCount }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong><span class="mr-1">Satılan {{ ucfirst($project->step1_slug) }}
                                                    Sayısı:</span></strong>
                                            <span class="det" style="color: black;">{{ $project->cartOrders }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong><span class="mr-1">Satışa Kapalı {{ ucfirst($project->step1_slug) }}
                                                    Sayısı:</span></strong>
                                            <span class="det"
                                                style="color: black;">{{ $salesCloseProjectHousingCount }}</span>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>


                        </div>
                        <div class="tab-pane fade blog-info details mb-30" id="profile" role="tabpanel"
                            aria-labelledby="profile-tab">
                            <div class="similar-property featured portfolio p-0 bg-white">

                                <div class="single homes-content">
                                    <table class="table">
                                        <tbody class="trStyle">
                                            <tr>
                                                <td>
                                                    <span class="mr-1">İlan No:</span>
                                                    <span class="det" style="color: #274abb;">
                                                        {{ $project->id + 1000000 }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @foreach ($projectHousingSetting as $housingSetting)
                                                @php
                                                    $isArrayCheck = $housingSetting->is_array;
                                                    $value = '';

                                                    if (isset($projectHousing[$housingSetting->column_name . '[]'])) {
                                                        $valueArray = json_decode($projectHousing[$housingSetting->column_name . '[]']['value'] ?? null);

                                                        if ($isArrayCheck && isset($valueArray)) {
                                                            $value = implodeData($valueArray);
                                                        } elseif ($housingSetting->is_parent_table) {
                                                            $value = $project[$housingSetting->column_name] ?? null;
                                                        } elseif ($project->roomInfo) {
                                                            foreach ($project->roomInfo as $roomInfo) {
                                                                if ($roomInfo->room_order == 1 && $roomInfo['name'] === $housingSetting->column_name . '[]') {
                                                                    $value = $roomInfo['value'] == '["on"]' ? 'Evet' : ($roomInfo['value'] == '["off"]' ? 'Hayır' : $roomInfo['value']);
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    }
                                                @endphp

                                                @if (!$isArrayCheck && isset($value) && $value !== '' && $housingSetting->label != 'Fiyat')
                                                    <tr>
                                                        <td>
                                                            <span class="mr-1">{{ $housingSetting->label }}:</span>
                                                            <span
                                                                class="det">{{ $housingSetting->label == 'Fiyat' ? number_format($value, 0, ',', '.') : $value }}</span>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach


                                        </tbody>
                                    </table>
                                    @foreach ($projectHousingSetting as $housingSetting)
                                        @php
                                            if (isset($projectHousing[$housingSetting->column_name . '[]'])) {
                                                $isArrayCheck = $housingSetting->is_array;
                                                $valueArray = json_decode($projectHousing[$housingSetting->column_name . '[]']['value'] ?? null);

                                                if ($isArrayCheck && isset($valueArray) && $valueArray != null) {
                                                    echo "<div class='mt-5'><h5>{$projectHousing[$housingSetting->column_name . '[]']['key']}:</h5><ul class='homes-list clearfix checkSquareIcon'>";
                                                    foreach ($valueArray as $ozellik) {
                                                        echo "<li><i class='fa fa-check-square' aria-hidden='true'></i><span>{$ozellik}</span></li>";
                                                    }
                                                    echo '</ul></div>';
                                                }
                                            }
                                        @endphp
                                    @endforeach
                                </div>



                            </div>
                        </div>
                        <div class="tab-pane fade blog-info details mb-30" id="home" role="tabpanel"
                            aria-labelledby="home-tab">

                            {!! $project->description !!}
                        </div>
                        <div class="tab-pane fade show active  blog-info details housingsListTab mb-30 " id="contact"
                            role="tabpanel" aria-labelledby="contact-tab">

                            @if ($project->have_blocks == 1)
                                <div class="ui-elements properties-right list featured portfolio blog pb-5 bg-white">
                                    <div class="container">

                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 ">
                                                <div class="tabbed-content button-tabs">
                                                    <ul class="tabs">
                                                        @foreach ($project->blocks as $key => $block)
                                                            <li class="nav-item-block {{ $key == $blockIndex ? ' active' : '' }}"
                                                                role="presentation"
                                                                onclick="changeTabContent('{{ $block['id'] }}')">
                                                                <div class="tab-title">
                                                                    <span>{{ $block['block_name'] }}</span>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    @foreach ($project->blocks as $key => $block)
                                                        <div id="contentblock-{{ $block['id'] }}"
                                                            class="tab-content-block{{ $loop->first ? ' active' : '' }}"
                                                            block-id="{{ $block['id'] }}">
                                                            @php
                                                                $j = -1;
                                                                $blockHousingCount = $block['housing_count'];
                                                                if ($key > 0) {
                                                                    $previousBlockHousingCount = $project->blocks[$key - 1]['housing_count'];
                                                                    $i = $previousBlockHousingCount;
                                                                    $lastHousingCount = $project->blocks[$key - 1]['housing_count'];
                                                                    $j = -1; // Bir önceki bloğun housing_count değerinden başlat
                                                                    $blockHousingCount = $previousBlockHousingCount + $project->blocks[$key]['housing_count'];
                                                                } else {
                                                                    $i = 0;
                                                                }
                                                                $pageCount = $currentBlockHouseCount / 10;
                                                                $count = $blockHousingCount > 10 ? 10 : $blockHousingCount;

                                                            @endphp

                                                            <div class="mobile-hidden">
                                                                <div class="container">
                                                                    <div
                                                                        class="row project-filter-reverse blog-pots ajax-list">
                                                                        @if ($key == 0)
                                                                            @for ($i = 0; $i < $count - 1; $i++)
                                                                                @php
                                                                                    $j++;
                                                                                    if (isset($projectCartOrders[$i + 1])) {
                                                                                        $sold = $projectCartOrders[$i + 1];
                                                                                    } else {
                                                                                        $sold = null;
                                                                                    }
                                                                                    $isUserSame = isset($projectCartOrders[$i + 1]) && (Auth::check() ? $projectCartOrders[$i + 1]->user_id == Auth::user()->id : false);

                                                                                    $projectOffer = App\Models\Offer::where('type', 'project')
                                                                                        ->where('project_id', $project->id)
                                                                                        ->where(function ($query) use ($i) {
                                                                                            $query->orWhereJsonContains('project_housings', [$i + 1])->orWhereJsonContains('project_housings', (string) ($i + 1)); // Handle as string as JSON might store values as strings
                                                                                        })
                                                                                        ->where('start_date', '<=', now())
                                                                                        ->where('end_date', '>=', now())
                                                                                        ->first();
                                                                                    $projectDiscountAmount = $projectOffer ? $projectOffer->discount_amount : 0;
                                                                                @endphp

                                                                                <x-project-item-card :project="$project"
                                                                                :isUserSame="$isUserSame"
                                                                                    :bankAccounts="$bankAccounts" :i="$i"
                                                                                    :projectHousingsList="$projectHousingsList" :projectDiscountAmount="$projectDiscountAmount"
                                                                                    :sold="$sold" :lastHousingCount="$lastHousingCount" />
                                                                            @endfor
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mobile-show">
                                                                @for ($i = 0; $i < $count - 1; $i++)
                                                                    @php
                                                                        $j++;
                                                                        if (isset($projectCartOrders[$i + 1])) {
                                                                            $sold = $projectCartOrders[$i + 1];
                                                                        } else {
                                                                            $sold = null;
                                                                        }
                                                                        $isUserSame = isset($projectCartOrders[$i + 1]) && (Auth::check() ? $projectCartOrders[$i + 1]->user_id == Auth::user()->id : false);

                                                                        $projectOffer = App\Models\Offer::where('type', 'project')
                                                                            ->where('project_id', $project->id)
                                                                            ->where(function ($query) use ($i) {
                                                                                $query->orWhereJsonContains('project_housings', [$i + 1])->orWhereJsonContains('project_housings', (string) ($i + 1)); // Handle as string as JSON might store values as strings
                                                                            })
                                                                            ->where('start_date', '<=', now())
                                                                            ->where('end_date', '>=', now())
                                                                            ->first();
                                                                        $projectDiscountAmount = $projectOffer ? $projectOffer->discount_amount : 0;
                                                                    @endphp

                                                                    <x-project-item-mobile-card :project="$project"
                                                                        :bankAccounts="$bankAccounts" :room_order="$room_order"
                                                                        :isUserSame="$isUserSame"
                                                                        :i="$i" :projectHousingsList="$projectHousingsList"
                                                                        :projectDiscountAmount="$projectDiscountAmount" :sold="$sold"
                                                                        :lastHousingCount="$lastHousingCount" />
                                                                @endfor

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="properties-right list featured portfolio blog pb-5 bg-white">
                                    <div class="mobile-hidden">
                                        <div class="container">

                                            <div class="row project-filter-reverse blog-pots">
                                                @for ($i = 0; $i < $project->room_count; $i++)
                                                    @php
                                                        $sold = isset($projectCartOrders[$i + 1]) ? $projectCartOrders[$i + 1] : null;
                                                        $isUserSame = isset($projectCartOrders[$i + 1]) && (Auth::check() ? $projectCartOrders[$i + 1]->user_id == Auth::user()->id : false);
                                                        $projectOffer = App\Models\Offer::where('type', 'project')
                                                            ->where('project_id', $project->id)
                                                            ->where(function ($query) use ($i) {
                                                                $query->orWhereJsonContains('project_housings', [$i + 1])->orWhereJsonContains('project_housings', (string) ($i + 1)); // Handle as string as JSON might store values as strings
                                                            })
                                                            ->where('start_date', '<=', now())
                                                            ->where('end_date', '>=', now())
                                                            ->first();

                                                        $projectDiscountAmount = $projectOffer ? $projectOffer->discount_amount : 0;

                                                    @endphp

                                                    <x-project-item-card :project="$project" :i="$i"
                                                    :isUserSame="$isUserSame"
                                                        :bankAccounts="$bankAccounts" :projectHousingsList="$projectHousingsList" :projectDiscountAmount="$projectDiscountAmount"
                                                        :sold="$sold" :lastHousingCount="$lastHousingCount" />
                                                @endfor

                                            </div>
                                        </div>
                                    </div>
                                    <div class="mobile-show">
                                        <div class="container">

                                            @for ($i = 0; $i < $project->room_count; $i++)
                                                @php
                                                    $sold = isset($projectCartOrders[$i + 1]) ? $projectCartOrders[$i + 1] : null;

                                                    $room_order = $i + 1;
                                                    $isUserSame = isset($projectCartOrders[$i + 1]) && (Auth::check() ? $projectCartOrders[$i + 1]->user_id == Auth::user()->id : false);

                                                    $projectOffer = App\Models\Offer::where('type', 'project')
                                                        ->where('project_id', $project->id)
                                                        ->where(function ($query) use ($i) {
                                                            $query->orWhereJsonContains('project_housings', [$i + 1])->orWhereJsonContains('project_housings', (string) ($i + 1)); // Handle as string as JSON might store values as strings
                                                        })
                                                        ->where('start_date', '<=', now())
                                                        ->where('end_date', '>=', now())
                                                        ->first();
                                                    $projectDiscountAmount = $projectOffer ? $projectOffer->discount_amount : 0;
                                                @endphp
                                                <x-project-item-mobile-card :project="$project" :room_order="$room_order"
                                                :isUserSame="$isUserSame"
                                                    :bankAccounts="$bankAccounts" :i="$i" :projectHousingsList="$projectHousingsList"
                                                    :projectDiscountAmount="$projectDiscountAmount" :sold="$sold" :lastHousingCount="$lastHousingCount" />
                                            @endfor
                                        </div>

                                    </div>



                                </div>
                            @endif

                        </div>
                        <div class="tab-pane fade  blog-info details mb-30" id="map" role="tabpanel"
                            aria-labelledby="contact-tab">
                            <div id="mapContainer" style="height: 100%"></div>
                        </div>
                        <div class="tab-pane fade blog-info details mb-30" id="situation" role="tabpanel"
                            aria-labelledby="situation-tab">
                            <div class="situation-images-project">
                                <div class="row w-100 m-auto">
                                    @if ($project->situations && count($project->situations) > 0)
                                        @foreach ($project->situations as $situation)
                                            <div class="col-md-4 mb-2">
                                                <a href="{{ URL::to('/') . '/' . str_replace('public/', '', $situation->situation) }}"
                                                    data-lightbox="image-gallery1"> <img
                                                        style="height: 100%;object-fit: contain"
                                                        src="{{ URL::to('/') }}/{{ str_replace('public/', '', $situation->situation) }}"
                                                        alt=""></a>

                                            </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-danger w-100" style="color:#fff;">
                                            Vaziyet planı belirtilmedi
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
    </section>



    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="invoice">
                        <div class="invoice-header mb-3">
                            <span>Ödeme Tarihi: {{ date('d.m.Y') }}</span> <br>
                            <span style="color:#e54242;font-weight:700">Tutar: 250 TL</span>

                        </div>

                        <div class="invoice-body">
                            <div class="invoice-total mt-3">
                                <div class="mt-3">
                                    <span><strong style="color:black">Komşumu Gör Özelliği:</strong> Bu özellik, komşunuzun
                                        iletişim bilgilerine ulaşabilmeniz için aktif edilmelidir.</span><br>
                                    <span>Komşunuza ait iletişim bilgilerini görmek için aşağıdaki adımları takip
                                        edin:</span>
                                    <ul>
                                        <li><i class="fa fa-circle circleIcon mr-1" style="color: #EA2B2E ;"
                                                aria-hidden="true"></i>Ödeme işlemini tamamlayın ve belirtilen tutarı
                                            aşağıdaki banka hesaplarından birine havale veya EFT yapın.</li>
                                        <li><i class="fa fa-circle circleIcon mr-1" style="color: #EA2B2E ;"
                                                aria-hidden="true"></i>Ödemeniz onaylandıktan sonra, "Komşumu Gör" düğmesi
                                            aktif olacak ve komşunuzun iletişim bilgilerine ulaşabileceksiniz.</li>
                                    </ul>
                                </div>
                                <div class="container row mb-3 mt-3">
                                    @foreach ($bankAccounts as $bankAccount)
                                        <div class="col-md-4 bank-account" data-id="{{ $bankAccount->id }}"
                                            data-iban="{{ $bankAccount->iban }}"
                                            data-title="{{ $bankAccount->receipent_full_name }}">
                                            <img src="{{ URL::to('/') }}/{{ $bankAccount->image }}" alt=""
                                                style="width: 100%;height:100px;object-fit:contain;cursor:pointer">
                                        </div>
                                    @endforeach
                                </div>
                                <div id="ibanInfo" style="font-size: 12px !important"></div>
                                <span>Ödeme işlemini tamamlamak için, lütfen bu
                                    <span style="color:#EA2B2E;font-weight:bold" id="uniqueCode"></span> kodu
                                    kullanarak ödemenizi
                                    yapın. IBAN açıklama
                                    alanına
                                    bu kodu eklemeyi unutmayın.</span>

                            </div>
                        </div>

                    </div>

                    <div class="d-flex">
                        <button type="button"
                            class="btn btn-secondary btn-lg btn-block mb-3 mt-3 completePaymentButtonOrder"
                            id="completePaymentButton" style="width:150px;float:right">
                            250 TL Öde
                        </button>
                        <button type="button" class="btn btn-secondary btn-lg btn-block mt-3"
                            style="width:150px;margin-left:10px" data-bs-dismiss="modal">İptal</button>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div id="loadingOverlay">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>





@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&callback=initMap"></script>


    <script>
        function checkOffer(offers, housingOrder) {
            var returnData = null;
            for (i = 0; i < offers.length; i++) {
                if (offers[i]["project_housings"].includes(housingOrder + " No")) {
                    returnData = offers[i];
                }
            }

            return returnData;
        }

        function priceFormat(price) {
            let inputValue = price;
            inputValue = inputValue.replace(/\D/g, '');
            inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            return inputValue;
        }
        var isLoading = false;
        $(window).scroll(function() {
            var windowBottom = $(this).scrollTop() + $(this).innerHeight();
            var documentHeight = $(document).height();
            var blockIndex = $('.nav-item-block.active').index();
            var startIndex = $('.ajax-list').eq(blockIndex).children('div').length;
            var endIndex = startIndex + 10;
            if (windowBottom >= (documentHeight - 500)) {
                if (!isLoading) {
                    isLoading = true;
                    $.ajax({
                        url: "{{ route('project.get.housings.by.start.and.end', [$project->id, 1]) }}?start=" +
                            startIndex + "&end=" + endIndex + "&block_index=" + blockIndex,
                    }).done(function(response) {
                        isLoading = false;
                        var res = response.projectHousingsList;
                        var cartOrders = response.projectCartOrders;
                        var html = "";
                        var blocks = response.blocks;
                        var lastBlockHousingCount = 0;
                        for (var i = 0; i < blocks.length; i++) {
                            if (i < blockIndex) {
                                lastBlockHousingCount += blocks[i]['housing_count']
                            }
                        }
                        for (var i = 0; i < res.length; i++) {
                            if (cartOrders[startIndex + 1 + i]) {
                                var sold = cartOrders[startIndex + 1 + i];
                            } else {
                                var sold = null;
                            }
                            html +=
                                `<div class="col-md-12 col-12">
                                <div class="project-card mb-3">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <a href="{{ URL::to('/') }}/proje_konut_detayi/{{ $project->slug }}/${startIndex+1+i+lastBlockHousingCount}" style="height: 100%">
                                                <div class="d-flex" style="height: 100%;">
                                                    <div style="background-color: #EA2B2E  !important; border-radius: 0px 8px 0px 8px;height:100%">
                                                        <p style="padding: 10px; color: white; height: 100%; display: flex; align-items: center;text-align:center; ">
                                                            No
                                                            <br>${lastBlockHousingCount+1+i+startIndex}
                                                        </p>
                                                    </div>
                                                    <div class="project-single mb-0 bb-0 aos-init aos-animate" data-aos="fade-up">
                                                        <div class="project-inner project-head">

                                                            <div class="button-effect-div">
                                                                <span class="btn {{ (isset($sold) && $sold['status'] == '1') || (isset($res[$i]['off_sale[]']) && $res[$i]['off_sale[]'] != '[]') ? 'disabledShareButton' : 'addCollection mobileAddCollection' }}"
    data-type='project'
    data-project='{{ $project->id }}'
    data-id='${startIndex+1+i+lastBlockHousingCount}'>
    <i class="fa fa-bookmark-o"></i>
</span>

                                                                <div href="javascript:void()" class="btn toggle-project-favorite bg-white" data-project-housing-id="${startIndex+1+i+lastBlockHousingCount}" data-project-id="{{ $project->id }}">
                                                                    <i class="fa fa-heart-o"></i>
                                                                </div>
                                                            </div>
                                                            <div class="homes position-relative">
                                                                <img src="{{ URL::to('/') . '/project_housing_images/' }}${res[i]['image[]']}" alt="home-1" class="img-responsive" style="height: 100px !important;object-fit:cover;width:100%">`
                            var checkOfferX = checkOffer(response.offers, startIndex + 1 + i +
                                lastBlockHousingCount);
                            if (checkOfferX) {
                                var newPercent = Math.round((checkOfferX['discount_amount'] / res[i][
                                    "price[]"
                                ]) * 100);
                                html += `
                                                                    <div style="z-index: 2;right: 0;top: 0;background: #e54242; width: 96px; height: 96px; position: absolute; clip-path: polygon(0 0, 45% 0, 100% 55%, 100% 100%);">
                                                                        <div style="color: #FFF; transform: rotate(45deg); margin-left: 25px; margin-top: 30px; font-weight: bold;">
                                                                            % ${newPercent}
                                                                            <svg viewBox="0 0 24 24"
                                                                                width="16"
                                                                                height="16"
                                                                                stroke="currentColor"
                                                                                stroke-width="2"
                                                                                fill="none"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="css-i6dzq1"
                                                                                style="transform: rotate(45deg);">
                                                                                <polyline
                                                                                    points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                                </polyline>
                                                                                <polyline
                                                                                    points="17 18 23 18 23 12">
                                                                                </polyline>
                                                                            </svg>
                                                                        </div>
                                                                    </div>`
                            }
                            html += `</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-9 col-md-9 homes-content pb-0 mb-44 aos-init aos-animate" data-aos="fade-up">
                                            <div class="row align-items-center justify-content-between mobile-position"
                                            style=" ${sold && sold['status'] != '2' || res[i]['off_sale[]']  != '[]' ? "background: #EEE !important;" : null}">

                                                <div class="col-md-9">
                                                    <div class="homes-list-div">
                                                        <ul class="homes-list clearfix pb-3 d-flex">
                                                            
                                                            <li class="d-flex align-items-center itemCircleFont">
                                                                <i class="fa fa-circle circleIcon mr-1" style="color: black;" aria-hidden="true"></i>
                                                                <span>Daire</span>
                                                            </li>
                                                            @if (isset($project->listItemValues) &&
                                                                    isset($project->listItemValues->column1_name) &&
                                                                    $project->listItemValues->column1_name)
                                                                <li class="d-flex align-items-center itemCircleFont">
                                                                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                                    <span>
                                                                        ${res[i]["{{ $project->listItemValues->column1_name . '[]' }}"]}
                                                                        @if (isset($project->listItemValues) &&
                                                                                isset($project->listItemValues->column1_additional) &&
                                                                                $project->listItemValues->column1_additional)
                                                                            {{ $project->listItemValues->column1_additional }}
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                            @endif
                                                            @if (isset($project->listItemValues) &&
                                                                    isset($project->listItemValues->column2_name) &&
                                                                    $project->listItemValues->column2_name)
                                                                <li class="d-flex align-items-center itemCircleFont">
                                                                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                                    <span>
                                                                        ${res[i]["{{ $project->listItemValues->column2_name . '[]' }}"]}
                                                                        @if (isset($project->listItemValues) &&
                                                                                isset($project->listItemValues->column2_additional) &&
                                                                                $project->listItemValues->column2_additional)
                                                                            {{ $project->listItemValues->column2_additional }}
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                            @endif
                                                            @if (isset($project->listItemValues) &&
                                                                    isset($project->listItemValues->column3_name) &&
                                                                    $project->listItemValues->column3_name)
                                                                <li class="d-flex align-items-center itemCircleFont">
                                                                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                                    <span>
                                                                        ${res[i]["{{ $project->listItemValues->column3_name . '[]' }}"]}
                                                                        @if (isset($project->listItemValues) &&
                                                                                isset($project->listItemValues->column3_additional) &&
                                                                                $project->listItemValues->column3_additional)
                                                                            {{ $project->listItemValues->column3_additional }}
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                            @endif
                                                            <li
                                                                class="the-icons mobile-hidden">
                                                                <span>
                                                            `
                            if (res[i]['off_sale[]'] == "[]") {
                                var checkOfferX = checkOffer(response.offers, startIndex + 1 + i +
                                    lastBlockHousingCount);
                                if (sold) {
                                    if (sold['status'] != 1 && sold['status'] != 0) {
                                        if (checkOfferX) {
                                            var newPrice = res[i]["price[]"] - checkOfferX[
                                                'discount_amount'];
                                            html += `
                                                                                    <h6 style="color: #274abb !important;position: relative;top:4px;font-weight:600;font-size: 11px;text-decoration:line-through;">
                                                                                        ${priceFormat(res[i]["price[]"])} ₺
                                                                                    </h6>
                                                                                    <h6 style="color: #274abb !important;position: relative;top:4px;font-weight:600;">
                                                                                        ${priceFormat(""+newPrice+"")} ₺
                                                                                    </h6>
                                                                                `
                                        } else {
                                            html += `
                                                                                <h6 style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                                                    ${priceFormat(res[i]["price[]"])} ₺
                                                                                </h6>`
                                        }
                                    } else {
                                        html += `
                                                                            <h6 style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                                                ${priceFormat(res[i]["price[]"])} ₺
                                                                            </h6>`
                                    }
                                } else {
                                    if (checkOfferX) {
                                        var newPrice = res[i]["price[]"] - checkOfferX['discount_amount'];
                                        html += `
                                                                                <h6 style="color: #274abb !important;position: relative;top:4px;font-weight:600;font-size: 11px;text-decoration:line-through;">
                                                                                    ${priceFormat(res[i]["price[]"])} ₺
                                                                                </h6>
                                                                                <h6 style="color: #274abb !important;position: relative;top:4px;font-weight:600;">
                                                                                    ${priceFormat(""+newPrice+"")} ₺
                                                                                </h6>
                                                                            `
                                    } else {
                                        html += `
                                                                                <h6 style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                                                    ${priceFormat(res[i]["price[]"])} ₺
                                                                                </h6>
                                                                            `
                                    }
                                }
                            }
                            html += `</span>
                                                            </li>
                                                        </ul>

                                                    </div>
                                                    <div class="footer">
                                                        <a href="https://emlaksepette.com/magaza/maliyetine-ev/profil">
                                                            <img src="https://emlaksepette.com/storage/profile_images/profile_image_1701198728.png" alt="" class="mr-2">
                                                            Maliyetine Ev
                                                        </a>
                                                        <span class="price-mobile">
                                                            1.190.000₺
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mobile-hidden" style="height: 100px;padding:0">
                                                    <div class="homes-button" style="width:100%;height:100%">
                                                        <button class="first-btn payment-plan-button" 
                                                        project-id="{{ $project->id }}"
                                                        data-sold="${ (sold && (sold['status'] == 1 || sold['status'] == 0)) || res[i]['off_sale[]'] != '[]' ? '1' : '0' }"
                                                        order="${startIndex+i+lastBlockHousingCount+1}">
                                                            Ödeme Detayı
                                                        </button>`
                            if (res[i]['off_sale[]'] != "[]") {
                                html += `<button
                                                                class="btn second-btn"
                                                                style="background: #EA2B2E !important;width:100%;color:White;height: auto !important">

                                                                <span
                                                                    class="text">Satışa
                                                                    Kapatıldı</span>
                                                            </button>`
                            } else {
                                if (sold && sold['status'] != 2) {
                                    html += `<button class="btn second-btn" ${sold['status'] == 0 ? 'style="background: orange !important;color:White;height: auto !important"' : 'style="background: #EA2B2E !important;color:White;height: auto !important"'}>
                                                                    ${
                                                                        sold['status'] == 0 ? '<span class="text">Onay Bekleniyor</span>' : '<span class="text">Satıldı</span>'
                                                                    }
                                                                </button>`
                                } else {
                                    html += `<button class="CartBtn second-btn" data-type='project' data-project='281' style="height: auto !important" data-id="${startIndex+i+lastBlockHousingCount+1}">
                                                                    <span
                                                                        class="IconContainer">
                                                                        <img src="{{ asset('sc.png') }}"
                                                                            alt="">
                                                                    </span>
                                                                    <span class="text">Sepete Ekle</span>
                                                                </button>`
                                }
                            }
                            html += `
                                                    </div>
                                                </div>

                                                
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>`
                        }

                        $('.ajax-list').eq(blockIndex).append(html);
                    });
                }

            }
        })

        function initMap() {
            // İlk harita görüntüsü
            var map = new google.maps.Map(document.getElementById('mapContainer'), {
                center: {
                    lat: {{ explode(',', $project->location)[0] }},
                    lng: {{ explode(',', $project->location)[1] }}
                },
                zoom: 16
            });

            // Harita üzerinde bir konum gösterme
            var marker = new google.maps.Marker({
                position: {
                    lat: {{ explode(',', $project->location)[0] }},
                    lng: {{ explode(',', $project->location)[1] }}
                },
                map: map,
                title: 'Default Location'
            });
        }

        function showLocation() {
            var location = document.getElementById('locationInput').value;

            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: {{ explode(',', $project->location)[0] }},
                    lng: {{ explode(',', $project->location)[1] }}
                },
                zoom: 12
            });

            var marker = new google.maps.Marker({
                position: {
                    lat: {{ explode(',', $project->location)[0] }},
                    lng: {{ explode(',', $project->location)[1] }}
                },
                map: map,
                title: location
            });
        }

        @php
            $location = explode(',', $project->location);
            $location['latitude'] = $location[0];
            $location['longitude'] = $location[1];

            $location = json_encode($location);
            $location = json_decode($location);
        @endphp
    </script>
    <script>
        $('.project-housing-pagination li').click(function() {
            $('.loading-full').removeClass('d-none')
            $.ajax({
                url: "{{ URL::to('/') }}/proje_ajax/{{ $project->slug }}?selected_page=" + $(this)
                    .index() + "&block_id=" + $('.tabs .nav-item.active')
                    .index(), // Sepete veri eklemek için uygun URL'yi belirtin
                type: "GET", // Veriyi göndermek için POST kullanabilirsiniz
                success: function(response) {
                    $('.loading-full').addClass('d-none')
                    $('body').html(response)
                },
                error: function(error) {
                    // Hata durumunda buraya gelir
                    toast.error(error)
                    console.error("Hata oluştu: " + error);
                }
            });
        })

        $('.tabs .nav-item').click(function() {
            $('.loading-full').removeClass('d-none')
            $.ajax({
                url: "{{ URL::to('/') }}/proje_ajax/{{ $project->slug }}?selected_page=0" +
                    "&block_id=" + $(this).index(), // Sepete veri eklemek için uygun URL'yi belirtin
                type: "GET", // Veriyi göndermek için POST kullanabilirsiniz
                success: function(response) {
                    $('.loading-full').addClass('d-none')
                    $('body').html(response)
                },
                error: function(error) {
                    // Hata durumunda buraya gelir
                    toast.error(error)
                    console.error("Hata oluştu: " + error);
                }
            });
        })



        $("#addToCart").click(function() {
            // Sepete eklenecek verileri burada hazırlayabilirsiniz
            var cart = {
                id: $(this).data('id'),
                type: $(this).data('type'),
                _token: "{{ csrf_token() }}"
            };

            // Ajax isteği gönderme
            $.ajax({
                url: "{{ route('add.to.cart') }}", // Sepete veri eklemek için uygun URL'yi belirtin
                type: "POST", // Veriyi göndermek için POST kullanabilirsiniz
                data: cart, // Sepete eklemek istediğiniz ürün verilerini gönderin
                success: function(response) {
                    // İşlem başarılı olduğunda buraya gelir
                    toast.success(response)
                    console.log("Ürün sepete eklendi: " + response);
                },
                error: function(error) {
                    // Hata durumunda buraya gelir
                    toast.error(error)
                    console.error("Hata oluştu: " + error);
                }
            });
        });

        $(document).ready(function() {
            $(".tabs li").click(function() {
                $(".tabs li").removeClass("active");
                $(this).addClass("active");
            });
        });

        $('.listingDetailsSliderNav').slick({
            slidesToShow: 5,
            slidesToScroll: 4,
            dots: false,
            loop: false,
            autoplay: false,
            arrows: false,
            margin: 20,
            adaptiveHeight: true,
            responsive: [{
                breakpoint: 993,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 2,
                    dots: false,
                    arrows: false
                }
            }, {
                breakpoint: 769,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    dots: false,
                    arrows: false
                }
            }]
        });

        function changeTabContent(tabName) {
            document.querySelectorAll('.nav-item-block').forEach(function(content) {
                content.classList.remove('active');
            });
            document.querySelectorAll('.tab-content-block').forEach(function(content) {
                content.classList.remove('active');
            });
            document.getElementById('contentblock-' + tabName).classList.add('active');
            console.log($('#contentblock-' + tabName).index())
            var blockIndex = $('#contentblock-' + tabName).index() - 1;
            var startIndex = 0;
            var endIndex = 10;
            if ($('#contentblock-' + tabName).find('.ajax-list').children('div').length == 0) {
                $.ajax({
                    url: "{{ route('project.get.housings.by.start.and.end', [$project->id, 1]) }}?start=0&end=10&block_index=" +
                        blockIndex,
                }).done(function(response) {
                    isLoading = false;
                    var res = response.projectHousingsList;
                    var cartOrders = response.projectCartOrders;
                    var html = "";
                    var blocks = response.blocks;
                    var lastBlockHousingCount = 0;
                    for (var i = 0; i < blocks.length; i++) {
                        if (i < blockIndex) {
                            lastBlockHousingCount += blocks[i]['housing_count']
                        }
                    }
                    for (var i = 0; i < res.length; i++) {
                        if (cartOrders[startIndex + 1 + i]) {
                            var sold = cartOrders[startIndex + 1 + i];
                        } else {
                            var sold = null;
                        }
                        html +=
                            `<div class="col-md-12 col-12">
                                <div class="project-card mb-3">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <a href="{{ URL::to('/') }}/proje_konut_detayi/{{ $project->slug }}/${startIndex+1+i+lastBlockHousingCount}" style="height: 100%">
                                                <div class="d-flex" style="height: 100%;">
                                                    <div style="background-color: #EA2B2E  !important; border-radius: 0px 8px 0px 8px;height:100%">
                                                        <p style="padding: 10px; color: white; height: 100%; display: flex; align-items: center;text-align:center; ">
                                                            No
                                                            <br>${lastBlockHousingCount+1+i+startIndex}
                                                        </p>
                                                    </div>
                                                    <div class="project-single mb-0 bb-0 aos-init aos-animate" data-aos="fade-up">
                                                        <div class="project-inner project-head">

                                                            <div class="button-effect-div">
                                                                <span class="btn {{ (isset($sold) && $sold['status'] == '1') || (isset($res[$i]['off_sale[]']) && $res[$i]['off_sale[]'] != '[]') ? 'disabledShareButton' : 'addCollection mobileAddCollection' }}"
                                                        data-type='project'
                                                        data-project='{{ $project->id }}'
                                                        data-id='${startIndex+1+i+lastBlockHousingCount}'>
                                                        <i class="fa fa-bookmark-o"></i>
                                                    </span>
                                                                <div href="javascript:void()" class="btn toggle-project-favorite bg-white" data-project-housing-id="${startIndex+1+i+lastBlockHousingCount}" data-project-id="{{ $project->id }}">
                                                                    <i class="fa fa-heart-o"></i>
                                                                </div>
                                                            </div>
                                                            <div class="homes position-relative">
                                                                    <img src="{{ URL::to('/') . '/project_housing_images/' }}${res[i]['image[]']}" alt="home-1" class="img-responsive" style="height: 100px !important;object-fit:cover;width:100%">`
                        var checkOfferX = checkOffer(response.offers, startIndex + 1 + i + lastBlockHousingCount);
                        if (checkOfferX) {
                            var newPercent = Math.round((checkOfferX['discount_amount'] / res[i]["price[]"]) * 100);
                            html += `
                                                                    <div style="z-index: 2;right: 0;top: 0;background: #e54242; width: 96px; height: 96px; position: absolute; clip-path: polygon(0 0, 45% 0, 100% 55%, 100% 100%);">
                                                                        <div style="color: #FFF; transform: rotate(45deg); margin-left: 25px; margin-top: 30px; font-weight: bold;">
                                                                            % ${newPercent}
                                                                            <svg viewBox="0 0 24 24"
                                                                                width="16"
                                                                                height="16"
                                                                                stroke="currentColor"
                                                                                stroke-width="2"
                                                                                fill="none"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="css-i6dzq1"
                                                                                style="transform: rotate(45deg);">
                                                                                <polyline
                                                                                    points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                                </polyline>
                                                                                <polyline
                                                                                    points="17 18 23 18 23 12">
                                                                                </polyline>
                                                                            </svg>
                                                                        </div>
                                                                    </div>`
                        }
                        html += `</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-9 col-md-9 homes-content pb-0 mb-44 aos-init aos-animate" data-aos="fade-up">
                                            <div class="row align-items-center justify-content-between mobile-position"
                                            style=" ${sold && sold['status'] != '2' || res[i]['off_sale[]']  != '[]' ? "background: #EEE !important;" : null}">

                                                <div class="col-md-9">
                                                    <div class="homes-list-div">
                                                        <ul class="homes-list clearfix pb-3 d-flex">
                                                            
                                                            <li class="d-flex align-items-center itemCircleFont">
                                                                <i class="fa fa-circle circleIcon mr-1" style="color: black;" aria-hidden="true"></i>
                                                                <span>Daire</span>
                                                            </li>
                                                            @if (isset($project->listItemValues) &&
                                                                    isset($project->listItemValues->column1_name) &&
                                                                    $project->listItemValues->column1_name)
                                                                <li class="d-flex align-items-center itemCircleFont">
                                                                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                                    <span>
                                                                        ${res[i]["{{ $project->listItemValues->column1_name . '[]' }}"]}
                                                                        @if (isset($project->listItemValues) &&
                                                                                isset($project->listItemValues->column1_additional) &&
                                                                                $project->listItemValues->column1_additional)
                                                                            {{ $project->listItemValues->column1_additional }}
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                            @endif
                                                            @if (isset($project->listItemValues) &&
                                                                    isset($project->listItemValues->column2_name) &&
                                                                    $project->listItemValues->column2_name)
                                                                <li class="d-flex align-items-center itemCircleFont">
                                                                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                                    <span>
                                                                        ${res[i]["{{ $project->listItemValues->column2_name . '[]' }}"]}
                                                                        @if (isset($project->listItemValues) &&
                                                                                isset($project->listItemValues->column2_additional) &&
                                                                                $project->listItemValues->column2_additional)
                                                                            {{ $project->listItemValues->column2_additional }}
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                            @endif
                                                            @if (isset($project->listItemValues) &&
                                                                    isset($project->listItemValues->column3_name) &&
                                                                    $project->listItemValues->column3_name)
                                                                <li class="d-flex align-items-center itemCircleFont">
                                                                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                                    <span>
                                                                        ${res[i]["{{ $project->listItemValues->column3_name . '[]' }}"]}
                                                                        @if (isset($project->listItemValues) &&
                                                                                isset($project->listItemValues->column3_additional) &&
                                                                                $project->listItemValues->column3_additional)
                                                                            {{ $project->listItemValues->column3_additional }}
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                            @endif
                                                            <li
                                                                class="the-icons mobile-hidden">
                                                                <span>
                                                            `
                        if (res[i]['off_sale[]'] == "[]") {
                            var checkOfferX = checkOffer(response.offers, startIndex + 1 + i +
                                lastBlockHousingCount);
                            if (sold) {
                                if (sold['status'] != 1 && sold['status'] != 0) {
                                    if (checkOfferX) {
                                        var newPrice = res[i]["price[]"] - checkOfferX['discount_amount'];
                                        html += `
                                                                                    <h6 style="color: #274abb !important;position: relative;top:4px;font-weight:600;font-size: 11px;text-decoration:line-through;">
                                                                                        ${priceFormat(res[i]["price[]"])} ₺
                                                                                    </h6>
                                                                                    <h6 style="color: #274abb !important;position: relative;top:4px;font-weight:600;">
                                                                                        ${priceFormat(""+newPrice+"")} ₺
                                                                                    </h6>
                                                                                `
                                    } else {
                                        html += `
                                                                                <h6 style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                                                    ${priceFormat(res[i]["price[]"])} ₺
                                                                                </h6>`
                                    }
                                } else {
                                    html += `
                                                                            <h6 style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                                                ${priceFormat(res[i]["price[]"])} ₺
                                                                            </h6>`
                                }
                            } else {
                                if (checkOfferX) {
                                    var newPrice = res[i]["price[]"] - checkOfferX['discount_amount'];
                                    html += `
                                                                                <h6 style="color: #274abb !important;position: relative;top:4px;font-weight:600;font-size: 11px;text-decoration:line-through;">
                                                                                    ${priceFormat(res[i]["price[]"])} ₺
                                                                                </h6>
                                                                                <h6 style="color: #274abb !important;position: relative;top:4px;font-weight:600;">
                                                                                    ${priceFormat(""+newPrice+"")} ₺
                                                                                </h6>
                                                                            `
                                } else {
                                    html += `
                                                                                <h6 style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                                                    ${priceFormat(res[i]["price[]"])} ₺
                                                                                </h6>
                                                                            `
                                }
                            }
                        }
                        html += `</span>
                                                            </li>
                                                        </ul>

                                                    </div>
                                                    <div class="footer">
                                                        <a href="https://emlaksepette.com/magaza/maliyetine-ev/profil">
                                                            <img src="https://emlaksepette.com/storage/profile_images/profile_image_1701198728.png" alt="" class="mr-2">
                                                            Maliyetine Ev
                                                        </a>
                                                        <span class="price-mobile">
                                                            1.190.000₺
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mobile-hidden" style="height: 100px;padding:0">
                                                    <div class="homes-button" style="width:100%;height:100%">
                                                        <button class="first-btn payment-plan-button" 
                                                        project-id="{{ $project->id }}"
                                                        data-sold="${ (sold && (sold['status'] == 1 || sold['status'] == 0)) || res[i]['off_sale[]'] != '[]' ? '1' : '0' }"
                                                        order="${lastBlockHousingCount+1+i+startIndex}">
                                                            Ödeme Detayı
                                                        </button>`
                        if (res[i]['off_sale[]'] != "[]") {
                            html += `<button
                                                                class="btn second-btn"
                                                                style="background: #EA2B2E !important;width:100%;color:White;height: auto !important">

                                                                <span
                                                                    class="text">Satışa
                                                                    Kapatıldı</span>
                                                            </button>`
                        } else {
                            if (sold && sold['status'] != 2) {
                                html += `<button class="btn second-btn" ${sold['status'] == 0 ? 'style="background: orange !important;color:White;height: auto !important"' : 'style="background: #EA2B2E !important;color:White;height: auto !important"'}>
                                                                    ${
                                                                        sold['status'] == 0 ? '<span class="text">Onay Bekleniyor</span>' : '<span class="text">Satıldı</span>'
                                                                    }
                                                                </button>`
                            } else {
                                html += `<button class="CartBtn second-btn" data-type='project' data-project='281' style="height: auto !important" data-id="${startIndex+i+lastBlockHousingCount+1}">
                                                                    <span
                                                                        class="IconContainer">
                                                                        <img src="{{ asset('sc.png') }}"
                                                                            alt="">
                                                                    </span>
                                                                    <span class="text">Sepete Ekle</span>
                                                                </button>`
                            }
                        }
                        html += `
                                                    </div>
                                                </div>

                                                
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>`
                    }

                    $('.ajax-list').eq(blockIndex).append(html);
                });
            }
        }
    </script>

    <script>
        'use strict';
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
        $('#completePaymentButton').prop('disabled', false);

        $('.bank-account').on('click', function() {
            // Tüm banka görsellerini seçim olmadı olarak ayarla
            $('.bank-account').removeClass('selected');

            // Seçilen banka görselini işaretle
            $(this).addClass('selected');

            // İlgili IBAN bilgisini al
            var selectedBankIban = $(this).data('iban');
            var selectedBankIbanID = $(this).data('id');
            var selectedBankTitle = $(this).data('title');
            $('#bankaID').val(selectedBankIbanID);


            var ibanInfo = "<span style='color:black'><strong>Banka Alıcı Adı:</strong> " +
                selectedBankTitle + "<br><strong>IBAN:</strong> " + selectedBankIban + "</span>";
            $('#ibanInfo').html(ibanInfo);

        });

        $('#completePaymentButton').on('click', function() {

            if ($('.bank-account.selected').length === 0) {
                toastr.error('Lütfen banka seçimi yapınız.')

            } else {
                $("#loadingOverlay").css("visibility", "visible"); // Visible olarak ayarla

                $.ajax({
                    url: "{{ route('neighbor.store') }}", // Sepete veri eklemek için uygun URL'yi belirtin
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_id: "{{ Auth::check() ? Auth::user()->id : null }}",
                        order_id: $(this).data('order'),
                        status: 0,
                        key: $("#uniqueCode").html(),
                        amount: "100"
                    },
                    success: function(response) {
                        $("#loadingOverlay").css("visibility", "hidden");
                        $('#paymentModal').removeClass('show').hide();
                        $('.modal-backdrop').removeClass('show');
                        $('.modal-backdrop').remove();
                        if (response.success) {
                            toastr.success(
                                'Ödeme onayından sonra komşu bilgileri tarafınıza iletilecektir.');
                                location.reload();
                        }
                    },
                    error: function(error) {
                        toastr.error("Bu işlemle ilgili daha önce talepte bulunmuşsunuz.");
                            location.reload();
                    }
                });
            }
        });

        function generateRandomCode() {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const codeLength = 8; // Kod uzunluğu

            let randomCode = '';
            for (let i = 0; i < codeLength; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                randomCode += characters.charAt(randomIndex);
            }

            return randomCode;
        }
        $(".see-my-neighbor").on("click", function() {
            var uniqueCode = generateRandomCode();


            $('#uniqueCode, #uniqueCodeRetry').text(uniqueCode);
            $("#orderKey").val(uniqueCode);

            var soldId = $(this).data('order');
            $('#completePaymentButton').attr('data-order', soldId);
        });
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        .trStyle tr {
            width: 33%;
        }

        .trStyle,
        .trStyle tr {
            display: flex;
            flex-wrap: wrap;
        }

        .trStyle tr td {
            width: 100%;
            display: flex;
            justify-content: space-between font-size: 11px;
            border: 1px solid #dee2e6;
        }

        .table td {
            display: flex;
            justify-content: space-between
        }

        .table td,
        .table th {
            padding: .55rem;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block !important;
        }

        .mobile-hidden {
            display: flex;
        }

        @media (max-width: 768px) {
            .mobile-hidden {
                display: none
            }

            .trStyle tr {
                width: 100%;
            }

            .housingsListTab {
                padding: 0 !important;
            }
        }

        .button-effect {
            border: solid 1px #e6e6e6;
            width: 48px;
            height: 48px !important;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .housing-detail-box {
            display: flex;
            align-items: center;
            flex-wrap: wrap
        }


        .mobile-hidden {
            display: flex;
        }

        .desktop-hidden {
            display: none;
        }

        .homes-content .footer {
            display: none
        }

        .price-mobile {
            display: flex;
            align-items: self-end;
        }

        @media (max-width: 768px) {
            .mobile-hidden {
                display: none
            }

            .desktop-hidden {
                display: block;
            }

            .mobile-position {
                width: 100%;
                margin: 0 auto;
                box-shadow: 0 0 10px 1px rgba(71, 85, 95, 0.08);
            }

            .inner-pages .portfolio .homes-content .homes-list-div ul {
                flex-wrap: wrap
            }

            .homes-content .footer {
                display: block;
                background: none;
                border-top: 1px solid #e8e8e8;
                padding-top: 1rem;
                font-size: 13px;
                color: #666;
            }

        }

        @media (max-width:768px) {
            .storeInfo {
                display: none !important;
            }

            .listingDetailsSliderNav {
                display: none !important;
            }

            #listingDetailsSlider {
                padding: 0 !important;
                margin-bottom: 30px !important;
            }

            .storeInfo {
                margin-bottom: 30px !important;
                width: 100%;
                padding-right: 15px;
                padding-left: 15px;
                margin-right: auto;
                margin-left: auto;
            }

        }

        .title {
            font-family: sans-serif;
            color: red;
            text-align: center;
        }

        .mobile-tab-content {
            display: none;
        }

        .mobile-tab-content.active {
            display: block !important;
        }

        .trStyle,
        .trStyle tr {
            display: flex;
            flex-wrap: wrap;
        }


        .title-fs {
            display: none
        }

        @media (max-width:768px) {

            .title-fs {
                display: block;
                border-bottom: none !important;
            }

            .inner-pages .headings-2 .listing-title-bar h3 span {
                font-size: 16px !important;
            }

            .trStyle tr {
                width: 100%;
            }
        }

        .tab-content-block {
            display: none
        }

        .tab-content-block.active {
            display: block !important
        }

        .button-effect {
            border: solid 1px #e6e6e6;
            width: 48px;
            height: 48px !important;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .housing-detail-box {
            display: flex;
            align-items: center;
            flex-wrap: wrap
        }

        .mobile-hidden {
            display: flex;
        }

        .desktop-hidden {
            display: none;
        }

        .homes-content .footer {
            display: none
        }

        .price-mobile {
            display: flex;
            align-items: self-end;
        }

        .mobileTagProject {
            display: none
        }

        @media (max-width: 768px) {
            .mobileTagProject {
                width: 150px !important;
                position: absolute !important;
                display: block !important;
                bottom: 0;
                left: 30% !important;
                margin: 0 auto;
            }

            .payment-plan-table th,
            .payment-plan-table td {
                display: block !important;
                width: 100%;
            }

            .payment-plan-table th {
                text-align: left;
                margin-bottom: 10px;
            }

            .housingsListTab {
                padding: 0 !important;
            }

            .widget-boxed {
                margin-bottom: 30px;
            }

            .car {
                margin-top: 10px
            }

            .mobile-hidden {
                display: none
            }

            .desktop-hidden {
                display: block;
            }

            .mobile-position {
                width: 100%;
                margin: 0 auto;
                box-shadow: 0 0 10px 1px rgba(71, 85, 95, 0.08);
            }

            .inner-pages .portfolio .homes-content .homes-list-div ul {
                flex-wrap: wrap
            }

            .homes-content .footer {
                display: block;
                background: none;
                border-top: 1px solid #e8e8e8;
                padding-top: 1rem;
                font-size: 13px;
                color: #666;
            }

        }

        .classifiedInfo {
            font-size: 11px;
            color: #039;
            padding: 3px 10px 10px 0;
        }

        .loading-spinner {
            text-align: center
        }
    </style>
@endsection