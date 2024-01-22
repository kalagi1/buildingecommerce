@extends('client.layouts.master')

@section('content')
    @php

        if (isset($projectCartOrders[$housingOrder])) {
            $sold = $projectCartOrders[$housingOrder];
        } else {
            $sold = null;
        }
    @endphp
    @php
    @endphp
    @php
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];
        $shareUrl = $protocol . '://' . $host . $uri;
    @endphp
    @php
        $discountAmount = 0;

        $offer = App\Models\Offer::where('type', 'project')
            ->where('project_id', $project->id)
            ->where('project_housings', 'LIKE', '%' . $housingOrder . '%')
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->where('end_date', '>=', date('Y-m-d H:i:s'))
            ->first();

        if ($offer) {
            $discountAmount = $offer->discount_amount;
        }
    @endphp

    <section class="single-proper blog details bg-white">
        <div class="loading-full d-none">
            <div class="back-opa">

            </div>
            <div class="content-loading">
                <i class="fa fa-spinner"></i>
            </div>
        </div>
        <div class="brand-head mb-30">
            <div class="container">
                <div class="card mb-3">
                    <div class="card-img-top" style="background-color: {{ $project->user->banner_hex_code }}">
                        <div class="brands-square">
                            <img src="{{ url('storage/profile_images/' . $project->user->profile_image) }}" alt=""
                                class="brand-logo">
                            <p class="brand-name">
                                <a href="{{ route('instituional.profile', Str::slug($project->user->name)) }}"
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
                                    @if ($project->user->corporate_account_status )
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
                                </a>
                            </p>
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
                                    href="{{ route('instituional.dashboard', Str::slug($project->user->name)) }}">Anasayfa</a>
                                <a class="navbar-item"
                                    href="{{ route('instituional.profile', Str::slug($project->user->name)) }}">Mağaza
                                    Profili</a>
                                <a class="navbar-item"
                                    href="{{ route('instituional.projects.detail', Str::slug($project->user->name)) }}">Proje
                                    İlanları</a>
                                <a class="navbar-item"
                                    href="{{ route('instituional.housings', Str::slug($project->user->name)) }}">Emlak
                                    İlanları</a>
                            </div>
                            <form class="search-form" action="{{ route('instituional.search') }}" method="GET">
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
        <div class="container">
            <div class="row mb-3" style="align-items: center">
                <div class="col-md-8">
                    <div class="container">
                        <section class="headings-2 pt-0 pb-0">
                            <div class="pro-wrapper" style="width: 100%; justify-content: space-between;">
                                @php
                                    $advertiseTitle = $projectHousingsList[$housingOrder]['advertise_title[]'] ?? null;
                                    $status = optional($sold)->status;
                                @endphp

                                <div class="detail-wrapper-body">
                                    <div class="listing-title-bar">
                                        <strong>İlan No:  <span style="color: #274abb;font-size: 14px !important;">{{ $housingOrder + $project->id + 1000000 }}</span>
                                        </strong>

                                        <h3>
                                            @if ($status && $status != '0' && $status != '1')
                                                @include('client.layouts.partials.project_title', [
                                                    'title' => $project->project_title,
                                                    'advertiseTitle' => $advertiseTitle,
                                                    'housingOrder' => $housingOrder,
                                                    'step1Slug' => $project->step1_slug,
                                                ])
                                            @else
                                                @include('client.layouts.partials.project_title', [
                                                    'title' => $project->project_title,
                                                    'advertiseTitle' => $advertiseTitle,
                                                    'housingOrder' => $housingOrder,
                                                    'step1Slug' => $project->step1_slug,
                                                ])
                                            @endif
                                        </h3>
                                    </div>
                                </div>

                            </div>
                        </section>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="headings-2 pt-0 pb-0">
                        <div class="pro-wrapper" style="width: 100%; justify-content: space-between;">
                            @php
                                $offSaleValue = $projectHousingsList[$housingOrder]['off_sale[]'] ?? null;
                            @endphp

                            @if ($sold && $sold->status != '0' && $sold->status != '1')
                                @if ($offSaleValue == '[]')
                                    <div class="single detail-wrapper mr-2">
                                        <div class="detail-wrapper-body">
                                            <div class="listing-title-bar">
                                                <h4 style="white-space: nowrap">
                                                    @if ($discountAmount)
                                                        <svg viewBox="0 0 24 24" width="18" height="18"
                                                            stroke="#e54242" stroke-width="2" fill="#e54242"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="css-i6dzq1">
                                                            <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                            <polyline points="17 18 23 18 23 12"></polyline>
                                                        </svg>
                                                        <h6
                                                            style="color: #e54242 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;margin-right:5px">
                                                            {{ number_format($projectHousingsList[$housingOrder]['price[]'], 0, ',', '.') }}
                                                            ₺
                                                        </h6>
                                                        <br>
                                                    @endif

                                                    {{ number_format($projectHousingsList[$housingOrder]['price[]'] - $discountAmount, 0, ',', '.') }}
                                                    ₺
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="single detail-wrapper mr-2">
                                    <div class="detail-wrapper-body">
                                        <div class="listing-title-bar">
                                            <h4 style="white-space: nowrap">
                                                @if ($discountAmount)
                                                    <svg viewBox="0 0 24 24" width="18" height="18"
                                                        stroke="#e54242" stroke-width="2" fill="#e54242"
                                                        stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"
                                                        style="margin-right: 5px">
                                                        <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                        <polyline points="17 18 23 18 23 12"></polyline>
                                                    </svg>
                                                    <span
                                                        style="color: #e54242 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;margin-right:5px">
                                                        {{ number_format($projectHousingsList[$housingOrder]['price[]'], 0, ',', '.') }}
                                                        ₺
                                                    </span>
                                                @endif
                                                @if ($offSaleValue == '[]')
                                                    {{ number_format($projectHousingsList[$housingOrder]['price[]'] - $discountAmount, 0, ',', '.') }}
                                                    ₺
                                                @endif
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-md-12 blog-pots">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="listingDetailsSlider" class="carousel listing-details-sliders slide mb-30">
                                <div class="homes-tag button alt featured mobileTagProject">
                                    <a href="javascript:void()" style="color:White;">{{ $project->project_title }}</a>
                                </div>
                                <div class="carousel-inner">

                                    {{-- Kapak Görseli --}}
                                    <div class="item carousel-item active" data-slide-number="0">
                                        <a href="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[$housingOrder]['image[]'] }}"
                                            data-lightbox="image-gallery">
                                            <img src="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[$housingOrder]['image[]'] }}"
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
                                        <a id="carousel-selector--1" data-slide-to="-1"
                                            data-target="#listingDetailsSlider">
                                            <img src="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[$housingOrder]['image[]'] }}"
                                                class="img-fluid carousel-indicator-image" alt="listing-small">
                                        </a>
                                    </div>

                                    {{-- Diğer Görseller --}}
                                    @foreach ($project->images as $key => $housingImage)
                                        <div class="item" style="margin: 10px; cursor: pointer">
                                            <a id="carousel-selector-{{ $key }}"
                                                data-slide-to="{{ $key }}" data-target="#listingDetailsSlider">
                                                <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $housingImage->image) }}"
                                                    class="img-fluid carousel-indicator-image" alt="listing-small">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <aside class="col-md-4  car">
                    <div class="single widget buyBtn">
                        <div class="schedule widget-boxed mt-33 mt-0 widgetBuyButton">
                            <div class="row buttonDetail" style="align-items:center">
                                <div class="col-md-2 col-2">
                                    <div class="button-effect toggle-project-favorite"
                                        data-project-housing-id="{{ $projectHousingsList[$housingOrder]['squaremeters[]'] }}"
                                        data-project-id={{ $project->id }}>
                                        <i class="fa fa-heart-o"></i>
                                    </div>
                                </div>
                                <div class="col-md-2 col-2">
                                    <div class="buttons">
                                        <button class="main-button">
                                            <svg width="20" height="30" fill="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M15.75 5.125a3.125 3.125 0 1 1 .754 2.035l-8.397 3.9a3.124 3.124 0 0 1 0 1.88l8.397 3.9a3.125 3.125 0 1 1-.61 1.095l-8.397-3.9a3.125 3.125 0 1 1 0-4.07l8.397-3.9a3.125 3.125 0 0 1-.144-.94Z">
                                                </path>
                                            </svg>
                                        </button>
                                        <button class="twitter-button button"
                                            style="transition-delay: 0.1s, 0s, 0.1s; transition-property: translate, background, box-shadow;">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}">
                                                <svg viewBox="0 0 24 24" width="24" height="24"
                                                    stroke="currentColor" stroke-width="2" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                    <path
                                                        d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z">
                                                    </path>
                                                </svg></a>
                                        </button>
                                        <button class="reddit-button button"
                                            style="transition-delay: 0.2s, 0s, 0.2s; transition-property: translate, background, box-shadow;">
                                            <a href="whatsapp://send?text={{ $shareUrl }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" height="24" width="24">
                                                    <path
                                                        d="M19.001 4.908A9.817 9.817 0 0 0 11.992 2C6.534 2 2.085 6.448 2.08 11.908c0 1.748.458 3.45 1.321 4.956L2 22l5.255-1.377a9.916 9.916 0 0 0 4.737 1.206h.005c5.46 0 9.908-4.448 9.913-9.913A9.872 9.872 0 0 0 19 4.908h.001ZM11.992 20.15A8.216 8.216 0 0 1 7.797 19l-.3-.18-3.117.818.833-3.041-.196-.314a8.2 8.2 0 0 1-1.258-4.381c0-4.533 3.696-8.23 8.239-8.23a8.2 8.2 0 0 1 5.825 2.413 8.196 8.196 0 0 1 2.41 5.825c-.006 4.55-3.702 8.24-8.24 8.24Zm4.52-6.167c-.247-.124-1.463-.723-1.692-.808-.228-.08-.394-.123-.556.124-.166.246-.641.808-.784.969-.143.166-.29.185-.537.062-.247-.125-1.045-.385-1.99-1.23-.738-.657-1.232-1.47-1.38-1.716-.142-.247-.013-.38.11-.504.11-.11.247-.29.37-.432.126-.143.167-.248.248-.413.082-.167.043-.31-.018-.433-.063-.124-.557-1.345-.765-1.838-.2-.486-.404-.419-.557-.425-.142-.009-.309-.009-.475-.009a.911.911 0 0 0-.661.31c-.228.247-.864.845-.864 2.067 0 1.22.888 2.395 1.013 2.56.122.167 1.742 2.666 4.229 3.74.587.257 1.05.408 1.41.523.595.19 1.13.162 1.558.1.475-.072 1.464-.6 1.673-1.178.205-.58.205-1.075.142-1.18-.061-.104-.227-.165-.475-.29Z">
                                                    </path>
                                                </svg>
                                            </a>

                                        </button>
                                        <button class="messenger-button button"
                                            style="transition-delay: 0.3s, 0s, 0.3s; transition-property: translate, background, box-shadow;">
                                            <a href="https://telegram.me/share/url?url={{ $shareUrl }}">
                                                <svg viewBox="0 0 24 24" width="24" height="24"
                                                    stroke="currentColor" stroke-width="2" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                    <line x1="22" y1="2" x2="11" y2="13">
                                                    </line>
                                                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                                </svg></a>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-8 col-8">
                                    @php
                                        $offSaleValue = $projectHousingsList[$housingOrder]['off_sale[]'] ?? null;
                                        $soldStatus = optional($sold)->status;
                                    @endphp


                                    @if ($offSaleValue != '[]')
                                        <button class="btn second-btn  "
                                            style="background: #EA2B2E !important;width:100%;color:White">
                                            <span class="text">Satışa Kapatıldı</span>
                                        </button>
                                    @else
                                        @if ($soldStatus && $soldStatus != '2')
                                            <button class="btn second-btn  "
                                                @if ($soldStatus == '0') style="background: orange !important;color:White" @else style="background: #EA2B2E !important;color:White;height: auto !important" @endif>
                                                @if ($soldStatus == '0')
                                                    <span class="text">Rezerve Edildi</span>
                                                @else
                                                    <span class="text">Satıldı</span>
                                                @endif
                                            </button>
                                        @else
                                            <button class="CartBtn second-btn soldBtn" data-type='project'
                                                data-project='{{ $project->id }}' data-id='{{ $housingOrder }}'>
                                                <span class="IconContainer">
                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                </span>
                                                <span class="text">Sepete Ekle</span>
                                            </button>
                                        @endif
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="moveCollection">
                        @if (Auth::check() && Auth::user()->type == 21)
                            <div
                                @if (isset($projectHousingsList[$housingOrder]['share-open[]'])) class="add-to-collections-wrapper addCollectionMobile addCollection" data-bs-toggle="modal" data-bs-target="#addCollectionModal" data-type='project'  data-id="{{ $housingOrder }}" data-project="{{ $project->id }}" 
                                        @else
                                        class="add-to-collections-wrapper disabledShareButton addCollection addCollectionMobile" @endif>
                                <div class="add-to-collection-button-wrapper">
                                    <div class="add-to-collection-button">

                                        <svg width="32" height="32" viewBox="0 0 32 32" fill="e54242"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect width="32" height="32" fill="#e54242" />
                                            <g id="Add Collections-00 (Default)" clip-path="url(#clip0_1750_971)">
                                                <rect width="1440" height="1577" transform="translate(-1100 -1183)"
                                                    fill="white" />
                                                <g id="Group 6131">
                                                    <g id="Frame 21409">
                                                        <g id="Group 6385">
                                                            <rect id="Rectangle 4168" x="-8" y="-8" width="228"
                                                                height="48" rx="8" fill="#e54242 " />
                                                            <g id="Group 2664">
                                                                <rect id="Rectangle 316" width="32" height="32"
                                                                    rx="4" fill="#e54242 " />
                                                                <g id="Group 72">
                                                                    <path id="Rectangle 12"
                                                                        d="M16.7099 17.2557L16 16.5401L15.2901 17.2557L12 20.5721L12 12C12 10.8954 12.8954 10 14 10H18C19.1046 10 20 10.8954 20 12V20.5721L16.7099 17.2557Z"
                                                                        fill="white" stroke="white" stroke-width="2" />
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_1750_971">
                                                    <rect width="1440" height="1577" fill="white"
                                                        transform="translate(-1100 -1183)" />
                                                </clipPath>
                                            </defs>
                                        </svg><span class="add-to-collection-button-text">Koleksiyona Ekle</span>
                                    </div>
                                    <span class="fa fa-plus"></span>
                                </div>
                            </div>
                        @endif
                    </div>


                    <div class="mobileMove">
                        <div class="single widget storeInfo">
                            <div class="widget-boxed">
                                <div class="widget-boxed-header">
                                    <h4>Mağaza Bilgileri</h4>
                                </div>
                                <div class="widget-boxed-body">
                                    <div class="sidebar-widget author-widget2">
                                        <div class="author-box clearfix d-flex align-items-center">
                                            <img src="{{ URL::to('/') . '/storage/profile_images/' . $project->user->profile_image }}"
                                                alt="author-image" class="author__img">
                                            <div>
                                                <a
                                                    href="{{ route('instituional.dashboard', Str::slug($project->user->name)) }}">
                                                    <h4 class="author__title">{!! $project->user->name !!}</h4>
                                                </a>
                                                <p class="author__meta">
                                                    {{ $project->user->corporate_type == 'Emlakçı' ? 'Gayrimenkul Ofisi' : $project->user->corporate_type }}
                                                </p>
                                            </div>
                                        </div>
                                        <table class="table table-bordered ">
                                            <tr>
                                                <td>
                                                    İlan No:
                                                    <span class="det">
                                                        {{ $housingOrder + $project->id + 1000000 }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {!! 'İl-İlçe' !!}
                                                    @if ($project->neighbourhood)
                                                        {!! '-Mahalle: ' !!}
                                                    @else
                                                        {!! ': ' !!}
                                                    @endif
                                                    <span class="det">
                                                        {!! optional($project->city)->title .
                                                            ' / ' .
                                                            optional($project->county)->ilce_title !!}
                                                        @if ($project->neighbourhood)
                                                            {!! ' / ' . optional($project->neighbourhood)->mahalle_title!!}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                            @if ($project->user->phone)
                                                <tr>
                                                    <td>
                                                        Telefon :
                                                        <span class="det">
                                                            <a style="text-decoration: none;color:inherit"
                                                                href="tel:{!! $project->user->phone !!}">{!! $project->user->phone !!}</a>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($project->step1_slug)
                                                <tr>
                                                    <td>
                                                        Proje Tipi :
                                                        <span class="det">
                                                            @if ($project->step2_slug)
                                                                @if ($project->step2_slug == 'kiralik')
                                                                    Kiralık
                                                                @elseif ($project->step2_slug == 'satilik')
                                                                    Satılık
                                                                @else
                                                                    Günlük Kiralık
                                                                @endif
                                                            @endif
                                                            {{ $project->housingtype->title }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>
                                                    E-Posta :
                                                    <span class="det"> <a style="text-decoration: none;color:inherit"
                                                            href="mailto:{!! $project->user->email !!}">{!! $project->user->email !!}</a></span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                type="button" role="tab" aria-controls="home"
                                aria-selected="true">Açıklama</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab" aria-controls="profile"
                                aria-selected="false">Özellikler</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                                type="button" role="tab" aria-controls="contact" aria-selected="false">Projedeki
                                Diğer Konutlar
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link payment-plan-tab" id="payment-tab" data-bs-toggle="tab"
                                data-bs-target="#payment" type="button" role="tab" aria-controls="payment"
                                project-id="{{ $project->id }}" order="{{ $housingOrder }}"
                                aria-selected="false">Ödeme Planı</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#map"
                                type="button" role="tab" aria-controls="contact"
                                aria-selected="false">Harita</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active blog-info details mb-30" id="home" role="tabpanel"
                            aria-labelledby="home-tab">
                            <h5 class="mb-4">Açıklama</h5>
                            {!! $project->description !!}
                        </div>
                        <div class="tab-pane fade blog-info details mb-30" id="profile" role="tabpanel"
                            aria-labelledby="profile-tab">
                            <div class="similar-property featured portfolio p-0 bg-white">
                                <div class="single homes-content">
                                    <h5 class="mb-4">Özellikler</h5>
                                    <table class="table">
                                        <tbody class="trStyle">
                                            <tr>
                                                <td>
                                                    <span class="mr-1">İlan No:</span>
                                                    <span class="det"  style="color: #274abb;">
                                                        {{ $housingOrder + $project->id + 1000000 }}
                                                    </span>
                                                </td>
                                            </tr>

                                            @foreach ($projectHousingSetting as $key => $housingSetting)
                                                @php
                                                    if (isset($projectHousing[$housingSetting->column_name . '[]']) &&  isset($project[$housingSetting->column_name]) && $project[$housingSetting->column_name]) {
                                                        $isArrayCheck = $housingSetting->is_array;
                                                        $onProject = false;
                                                        $valueArray = [];

                                                        if ($isArrayCheck) {
                                                            $valueArray = json_decode($projectHousing[$housingSetting->column_name . '[]']['value']);
                                                            if (isset($valueArray)) {
                                                                $value = '';
                                                            }
                                                        } elseif ($housingSetting->is_parent_table) {
                                                            $value = $project[$housingSetting->column_name];
                                                            $onProject = true;
                                                        } else {
                                                            foreach ($project->roomInfo as $roomInfo) {
                                                                if ($roomInfo->room_order == $housingOrder) {
                                                                    if ($roomInfo['name'] === $housingSetting->column_name . '[]') {
                                                                        if ($roomInfo['value'] == '["on"]') {
                                                                            $value = 'Evet';
                                                                        } elseif ($roomInfo['value'] == '["off"]') {
                                                                            $value = 'Hayır';
                                                                        } else {
                                                                            $value = $roomInfo['value'];
                                                                        }
                                                                        $onProject = true;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                @if (isset($projectHousing[$housingSetting->column_name . '[]']) &&  isset($project[$housingSetting->column_name]) && $project[$housingSetting->column_name])
                                                    @if (!$isArrayCheck && (isset($value) && $value !== ''))
                                                        <tr>
                                                            @if ($housingSetting->label == 'Fiyat')
                                                                <td>
                                                                    <span
                                                                        class="mr-1">{{ $housingSetting->label }}:</span>
                                                                    <span class="det" style="color: black; ">
                                                                        {{ number_format($value, 0, ',', '.') }} ₺
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>
                                                                    <span
                                                                        class=" mr-1">{{ $housingSetting->label }}:</span>{{ $value }}
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>

                                    @foreach ($projectHousingSetting as $housingSetting)
                                        @php
                                            if (isset($projectHousing[$housingSetting->column_name . '[]']) &&  isset($project[$housingSetting->column_name]) && $project[$housingSetting->column_name]) {
                                                $isArrayCheck = $housingSetting->is_array;
                                                $onProject = false;
                                                $valueArray = [];

                                                if ($isArrayCheck) {
                                                    $valueArray = json_decode($projectHousing[$housingSetting->column_name . '[]']['value']);
                                                    if (isset($valueArray)) {
                                                        $value = '';
                                                    }
                                                } elseif ($housingSetting->is_parent_table) {
                                                    $value = $project[$housingSetting->column_name];
                                                    $onProject = true;
                                                } else {
                                                    foreach ($project->roomInfo as $roomInfo) {
                                                        if ($roomInfo->room_order == $housingOrder) {
                                                            if ($roomInfo['name'] === $housingSetting->column_name . '[]') {
                                                                if ($roomInfo['value'] == '["on"]') {
                                                                    $value = 'Evet';
                                                                } elseif ($roomInfo['value'] == '["off"]') {
                                                                    $value = 'Hayır';
                                                                } else {
                                                                    $value = $roomInfo['value'];
                                                                }
                                                                $onProject = true;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        @endphp
                                        @if (isset($projectHousing[$housingSetting->column_name . '[]']) &&  isset($project[$housingSetting->column_name]) && $project[$housingSetting->column_name])
                                            @if ($isArrayCheck)
                                                @if (isset($valueArray))
                                                    <div class="mt-5">
                                                        <h5>{{ $projectHousing[$housingSetting->column_name . '[]']['key'] }}:
                                                        </h5>
                                                        <ul class="homes-list clearfix checkSquareIcon">
                                                            @foreach ($valueArray as $ozellik)
                                                                <li>
                                                                    <i class="fa fa-check-square"
                                                                        aria-hidden="true"></i><span>{{ $ozellik }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade  blog-info details housingsListTab mb-30 " id="contact"
                            role="tabpanel" aria-labelledby="contact-tab">

                            @if ($project->have_blocks == 1)
                                <div class="ui-elements properties-right list featured portfolio blog pb-5 bg-white">
                                    <div class="container">
                                        <h5 class="mb-4">Projedeki Konutlar </h5>

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
                                                            @endphp

                                                            <div class="mobile-hidden">
                                                                <div class="container">
                                                                    <div
                                                                        class="row project-filter-reverse blog-pots ajax-list">
                                                                        @if ($key == 0)
                                                                            @for ($i; $i < 10; $i++)
                                                                                @php
                                                                                    $j++;
                                                                                    if (isset($projectCartOrders[$i + 1])) {
                                                                                        $sold = $projectCartOrders[$i + 1];
                                                                                    } else {
                                                                                        $sold = null;
                                                                                    }

                                                                                    $projectOffer = App\Models\Offer::where('type', 'project')
                                                                                        ->where('project_id', $project->id)
                                                                                        ->where('housing_id', $i + 1)
                                                                                        ->where('start_date', '<=', now())
                                                                                        ->where('end_date', '>=', now())
                                                                                        ->first();
                                                                                    $projectDiscountAmount = $projectOffer ? $projectOffer->discount_amount : 0;
                                                                                @endphp

                                                                                <div class="col-md-12 col-12">
                                                                                    <div class="project-card mb-3">
                                                                                        <div class="row">
                                                                                            <div class="col-md-3">
                                                                                                <a href="{{ route('project.housings.detail', [$project->slug, $i + 1]) }}"
                                                                                                    style="height: 100%">
                                                                                                    <div class="d-flex"
                                                                                                        style="height: 100%;">
                                                                                                        <div
                                                                                                            style="background-color: #EA2B2E  !important; border-radius: 0px 8px 0px 8px;height:100%">
                                                                                                            <p
                                                                                                                style="padding: 10px; color: white; height: 100%; display: flex; align-items: center;text-align:center; ">
                                                                                                                @if (isset($projectHousingsList[$i + 1]['share-sale[]']) && $projectHousingsList[$i + 1]['share-sale[]'] != '[]')
                                                                                                                    {{ $i + 1 - $lastHousingCount }}.
                                                                                                                    Hisse
                                                                                                                @else
                                                                                                                    No
                                                                                                                    <br>{{ $i + 1 - $lastHousingCount }}
                                                                                                                @endif

                                                                                                            </p>
                                                                                                        </div>
                                                                                                        <div class="project-single mb-0 bb-0 aos-init aos-animate"
                                                                                                            data-aos="fade-up">
                                                                                                            <div
                                                                                                                class="button-effect-div">

                                                                                                                @if (Auth::check() && Auth::user()->type == 21)
                                                                                                                    <span
                                                                                                                        @if (isset($projectHousingsList[$i + 1]['share-open[]']) &&
                                                                                                                                $projectHousingsList[$i + 1]['share-open[]'] != '[]' &&
                                                                                                                                $projectHousingsList[$i + 1]['share-open[]'] != '[]') class="btn addCollection mobileAddCollection" data-bs-toggle="modal" data-bs-target="#addCollectionModal" 
                                                                                                                                    data-type='project'
                                                                                                                                    data-project='{{ $project->id }}'
                                                                                                                                    data-id='{{ $i + 1 }}'
                                                                                                                        @else
                                                                                                                        class="btn mobileAddCollection disabledShareButton" @endif>
                                                                                                                        <i
                                                                                                                            class="fa fa-bookmark"></i>
                                                                                                                    </span>
                                                                                                                @endif
                                                                                                                <div href="javascript:void()"
                                                                                                                    class="btn toggle-project-favorite bg-white"
                                                                                                                    data-project-housing-id="{{ $i + 1 }}"
                                                                                                                    data-project-id={{ $project->id }}>
                                                                                                                    <i
                                                                                                                        class="fa fa-heart-o"></i>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="homes position-relative">
                                                                                                                <!-- homes img -->
                                                                                                                <img src="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[$i + 1]['image[]'] }}"
                                                                                                                    alt="home-1"
                                                                                                                    class="img-responsive"
                                                                                                                    style="height: 120px !important;object-fit:cover">
                                                                                                                @if ($projectDiscountAmount)
                                                                                                                    <div
                                                                                                                        style="z-index: 2;right: 0;top: 0;background: #e54242; width: 96px; height: 96px; position: absolute; clip-path: polygon(0 0, 45% 0, 100% 55%, 100% 100%);">
                                                                                                                        <div
                                                                                                                            style="color: #FFF; transform: rotate(45deg); margin-left: 25px; margin-top: 30px; font-weight: bold;">
                                                                                                                            {{ '%' . round(($projectDiscountAmount / $projectHousingsList[$i + 1]['price[]']) * 100) }}
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
                                                                                                                    </div>
                                                                                                                @endif

                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </a>
                                                                                            </div>


                                                                                            <div class="col-lg-9 col-md-9 homes-content pb-0 mb-44 aos-init aos-animate"
                                                                                                data-aos="fade-up">

                                                                                                <div class="row align-items-center justify-content-between mobile-position"
                                                                                                    @if (($sold && $sold->status != '2') || $projectHousingsList[$i + 1]['off_sale[]'] != '[]') style="background: #EEE !important;" @endif>
                                                                                                    <div class="col-md-8">

                                                                                                        <div
                                                                                                            class="homes-list-div">
                                                                                                            <ul
                                                                                                                class="homes-list clearfix pb-3 d-flex">
                                                                                                                <li
                                                                                                                    class="d-flex align-items-center itemCircleFont">
                                                                                                                    <i class="fa fa-circle circleIcon mr-1"
                                                                                                                        style="color: black;"
                                                                                                                        aria-hidden="true"></i>
                                                                                                                    <span>{{ $project->housingType->title }}</span>
                                                                                                                </li>
                                                                                                                @if (isset($project->listItemValues) &&
                                                                                                                        isset($project->listItemValues->column1_name) &&
                                                                                                                        $project->listItemValues->column1_name)
                                                                                                                    <li
                                                                                                                        class="d-flex align-items-center itemCircleFont">
                                                                                                                        <i class="fa fa-circle circleIcon mr-1"
                                                                                                                            aria-hidden="true"></i>
                                                                                                                        <span>
                                                                                                                            {{ $projectHousingsList[$i + 1][$project->listItemValues->column1_name . '[]'] }}
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
                                                                                                                    <li
                                                                                                                        class="d-flex align-items-center itemCircleFont">
                                                                                                                        <i class="fa fa-circle circleIcon mr-1"
                                                                                                                            aria-hidden="true"></i>
                                                                                                                        <span>
                                                                                                                            {{ $projectHousingsList[$i + 1][$project->listItemValues->column2_name . '[]'] }}
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
                                                                                                                    <li
                                                                                                                        class="d-flex align-items-center itemCircleFont">
                                                                                                                        <i class="fa fa-circle circleIcon mr-1"
                                                                                                                            aria-hidden="true"></i>
                                                                                                                        <span>
                                                                                                                            {{ $projectHousingsList[$i + 1][$project->listItemValues->column3_name . '[]'] }}
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
                                                                                                                        @if ($projectHousingsList[$i + 1]['off_sale[]'] == '[]')
                                                                                                                            @if ($sold)
                                                                                                                                @if ($sold->status != '1' && $sold->status != '0')
                                                                                                                                    @if ($projectDiscountAmount)
                                                                                                                                        <h6
                                                                                                                                            style="color: #274abb;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                                                                            {{ number_format($projectHousingsList[$i + 1]['price[]'] - $projectDiscountAmount, 0, ',', '.') }}
                                                                                                                                            ₺
                                                                                                                                        </h6>
                                                                                                                                        <h6
                                                                                                                                            style="color: #e54242  !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                                                                            {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                                                                            ₺

                                                                                                                                        </h6>
                                                                                                                                    @else
                                                                                                                                        <h6
                                                                                                                                            style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                                                                                                            {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                                                                            ₺
                                                                                                                                        </h6>
                                                                                                                                    @endif
                                                                                                                                @endif
                                                                                                                            @else
                                                                                                                                @if ($projectDiscountAmount)
                                                                                                                                    <h6
                                                                                                                                        style="color: #274abb;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'] - $projectDiscountAmount, 0, ',', '.') }}
                                                                                                                                        ₺
                                                                                                                                    </h6>
                                                                                                                                    <h6
                                                                                                                                        style="color: #e54242  !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                                                                        ₺

                                                                                                                                    </h6>
                                                                                                                                @else
                                                                                                                                    <h6
                                                                                                                                        style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                                                                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                                                                        ₺
                                                                                                                                    </h6>
                                                                                                                                @endif
                                                                                                                            @endif
                                                                                                                        @endif


                                                                                                                    </span>
                                                                                                                </li>


                                                                                                            </ul>

                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="footer">
                                                                                                            <a
                                                                                                                href="{{ route('instituional.profile', Str::slug($project->user->name)) }}">
                                                                                                                <img src="{{ url('storage/profile_images/' . $project->user->profile_image) }}"
                                                                                                                    alt=""
                                                                                                                    class="mr-2">
                                                                                                                {{ $project->user->name }}
                                                                                                            </a>
                                                                                                            <span
                                                                                                                class="price-mobile">
                                                                                                                @if ($projectHousingsList[$i + 1]['off_sale[]'] == '[]')
                                                                                                                    @if ($sold)
                                                                                                                        @if ($sold->status != '1' && $sold->status != '0')
                                                                                                                            @if ($projectDiscountAmount)
                                                                                                                                <h6
                                                                                                                                    style="color: #274abb !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;margin-right:5px">
                                                                                                                                    {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                                                                    ₺
                                                                                                                                </h6>
                                                                                                                                <h6
                                                                                                                                    style="color: #274abb;position: relative;top:4px;font-weight:600;font-size:20px;">
                                                                                                                                    {{ number_format($projectHousingsList[$i + 1]['price[]'] - $projectDiscountAmount, 0, ',', '.') }}

                                                                                                                                    ₺
                                                                                                                                </h6>
                                                                                                                            @else
                                                                                                                                <h6
                                                                                                                                    style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                                                                                                    {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}₺
                                                                                                                                </h6>
                                                                                                                            @endif
                                                                                                                        @endif
                                                                                                                    @else
                                                                                                                        @if ($projectDiscountAmount)
                                                                                                                            <h6
                                                                                                                                style="color: #274abb !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;margin-right:5px">
                                                                                                                                {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                                                                ₺
                                                                                                                            </h6>
                                                                                                                            <h6
                                                                                                                                style="color: #274abb;position: relative;top:4px;font-weight:600;font-size:20px;">
                                                                                                                                {{ number_format($projectHousingsList[$i + 1]['price[]'] - $projectDiscountAmount, 0, ',', '.') }}

                                                                                                                                ₺
                                                                                                                            </h6>
                                                                                                                        @else
                                                                                                                            <h6
                                                                                                                                style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                                                                                                {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}₺
                                                                                                                            </h6>
                                                                                                                        @endif
                                                                                                                    @endif
                                                                                                                @endif


                                                                                                            </span>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-md-3 mobile-hidden"
                                                                                                        style="height: 120px;padding:0">
                                                                                                        <div class="homes-button"
                                                                                                            style="width:100%;height:100%">
                                                                                                            <button
                                                                                                                class="first-btn payment-plan-button"
                                                                                                                project-id="{{ $project->id }}"
                                                                                                                data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0)) || $projectHousingsList[$i + 1]['off_sale[]'] != '[]' ? '1' : '0' }}"
                                                                                                                order="{{ $i }}">
                                                                                                                Ödeme
                                                                                                                Detayları
                                                                                                            </button>

                                                                                                            @if ($projectHousingsList[$i + 1]['off_sale[]'] != '[]')
                                                                                                                <button
                                                                                                                    class="btn second-btn"
                                                                                                                    style="background: #EA2B2E !important;width:100%;color:White;height: auto !important">

                                                                                                                    <span
                                                                                                                        class="text">Satışa
                                                                                                                        Kapatıldı</span>
                                                                                                                </button>
                                                                                                            @else
                                                                                                                @if ($sold && $sold->status != '2')
                                                                                                                    <button
                                                                                                                        class="btn second-btn"
                                                                                                                        @if ($sold->status == '0') style="background: orange !important;color:White;height: auto !important" @else  style="background: #EA2B2E !important;color:White;height: auto !important" @endif>
                                                                                                                        @if ($sold->status == '0')
                                                                                                                            <span
                                                                                                                                class="text">Onay
                                                                                                                                Bekleniyor</span>
                                                                                                                        @else
                                                                                                                            <span
                                                                                                                                class="text">Satıldı</span>
                                                                                                                        @endif
                                                                                                                    </button>
                                                                                                                @else
                                                                                                                    <button
                                                                                                                        class="CartBtn second-btn"
                                                                                                                        data-type='project'
                                                                                                                        data-project='{{ $project->id }}'
                                                                                                                        style="height: auto !important"
                                                                                                                        data-id='{{ $i + 1 }}'>
                                                                                                                        <span
                                                                                                                            class="IconContainer">
                                                                                                                            <img src="{{ asset('sc.png') }}"
                                                                                                                                alt="">
                                                                                                                        </span>
                                                                                                                        <span
                                                                                                                            class="text">Sepete
                                                                                                                            Ekle</span>
                                                                                                                    </button>
                                                                                                                @endif
                                                                                                            @endif

                                                                                                        </div>
                                                                                                    </div>

                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            @endfor
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
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
                                                                    $lastHousingCount = 0;
                                                                    $i = 0;
                                                                }
                                                                $pageCount = $currentBlockHouseCount / 10;

                                                            @endphp
                                                            <div class="mobile-show">
                                                                @for ($i = $startIndex; $i < $endIndex; $i++)
                                                                    @php
                                                                        $j++;
                                                                        if (isset($projectCartOrders[$i + 1])) {
                                                                            $sold = $projectCartOrders[$i + 1];
                                                                        } else {
                                                                            $sold = null;
                                                                        }
                                                                        $room_order = $i + 1;

                                                                        $projectOffer = App\Models\Offer::where('type', 'project')
                                                                            ->where('project_id', $project->id)
                                                                            ->where('housing_id', $i + 1)
                                                                            ->where('start_date', '<=', now())
                                                                            ->where('end_date', '>=', now())
                                                                            ->first();
                                                                        $projectDiscountAmount = $projectOffer ? $projectOffer->discount_amount : 0;

                                                                    @endphp
                                                                    <div class="d-flex" style="flex-wrap: nowrap">
                                                                        <div class="align-items-center d-flex"
                                                                            style="padding-right:0; width: 110px;">
                                                                            <div class="project-inner project-head">
                                                                                <a
                                                                                    href="{{ route('project.housings.detail', [$project->slug, $i + 1]) }}">
                                                                                    <div class="homes">
                                                                                        <!-- homes img -->
                                                                                        <div class="homes-img h-100 d-flex align-items-center"
                                                                                            style="width: 100px; height: 128px;">
                                                                                            <img src="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[$i + 1]['image[]'] }}"
                                                                                                alt="{{ $project->housingType->title }}"
                                                                                                class="img-responsive"
                                                                                                style="height: 80px !important;">
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-100" style="padding-left:0;">
                                                                            <div
                                                                                class="bg-white px-3 h-100 d-flex flex-column justify-content-center">
                                                                                <a style="text-decoration: none; height: 100%"
                                                                                    href="{{ route('project.housings.detail', [$project->slug, $room_order]) }}">
                                                                                    <div class="d-flex  justify-content-between"
                                                                                        style="gap: 8px">
                                                                                        <h3>
                                                                                            @if (isset($projectHousingsList[$i + 1]['advertise_title[]']))
                                                                                                {{ $projectHousingsList[$i + 1]['advertise_title[]'] }}
                                                                                            @else
                                                                                                {{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}
                                                                                                Projesinde
                                                                                                {{ $i + 1 }}
                                                                                                {{ "No'lu" }}
                                                                                                {{ $project->step1_slug }}
                                                                                            @endif
                                                                                        </h3>
                                                                                        @if (Auth::check() && Auth::user()->type == 21)
                                                                                            <span
                                                                                                @if (isset($projectHousingsList[$i + 1]['share-open[]']) && $projectHousingsList[$i + 1]['share-open[]'] != '[]') class="btn addCollection mobileAddCollection" data-bs-toggle="modal" data-bs-target="#addCollectionModal" 
                                                                                          data-type='project'
                                                                                          data-project='{{ $project->id }}'
                                                                                          data-id='{{ $i + 1 }}'
                                                                            @else
                                                                            class="btn mobileAddCollection disabledShareButton" @endif>
                                                                                                <i
                                                                                                    class="fa fa-bookmark"></i>
                                                                                            </span>
                                                                                        @endif
                                                                                        <span
                                                                                            class="btn toggle-project-favorite bg-white"
                                                                                            data-project-housing-id="{{ $i + 1 }}"
                                                                                            style="color: white;"
                                                                                            data-project-id="{{ $project->id }}">
                                                                                            <i class="fa fa-heart-o"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                </a>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="d-flex"
                                                                                        style="gap: 8px;width: 100%;
                                                                                                            align-items: center;">
                                                                                        @if ($projectHousingsList[$i + 1]['off_sale[]'] != '[]')
                                                                                            <button
                                                                                                class="btn second-btn  mobileCBtn"
                                                                                                style="background: #EA2B2E !important;width:100%;color:White">

                                                                                                <span class="text">Satışa
                                                                                                    Kapatıldı</span>
                                                                                            </button>
                                                                                        @else
                                                                                            @if ($sold && $sold->status != '2')
                                                                                                <button
                                                                                                    class="btn second-btn  mobileCBtn"
                                                                                                    @if ($sold->status == '0') style="background: orange !important;color:White" @else  style="background: #EA2B2E !important;color:White;height: auto !important" @endif>
                                                                                                    @if ($sold->status == '0')
                                                                                                        <span
                                                                                                            class="text">Onay
                                                                                                            Bekleniyor</span>
                                                                                                    @else
                                                                                                        <span
                                                                                                            class="text">Satıldı</span>
                                                                                                    @endif
                                                                                                </button>
                                                                                            @else
                                                                                                <button
                                                                                                    class="CartBtn second-btn "
                                                                                                    data-type='project'
                                                                                                    data-project='{{ $project->id }}'
                                                                                                    data-id='{{ $i + 1 }}'>
                                                                                                    <span
                                                                                                        class="IconContainer">
                                                                                                        <img src="{{ asset('sc.png') }}"
                                                                                                            alt="">
                                                                                                    </span>
                                                                                                    <span
                                                                                                        class="text">Sepete
                                                                                                        Ekle</span>
                                                                                                </button>
                                                                                            @endif
                                                                                        @endif


                                                                                    </div>
                                                                                    <span
                                                                                        class="ml-auto text-primary priceFont">
                                                                                        @if ($projectHousingsList[$i + 1]['off_sale[]'] == '[]')
                                                                                            @if ($sold)
                                                                                                @if ($sold->status != '1' && $sold->status != '0')
                                                                                                    @if ($projectDiscountAmount)
                                                                                                        <h6
                                                                                                            style="color: #274abb;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                                            {{ number_format($projectHousingsList[$i + 1]['price[]'] - $projectDiscountAmount, 0, ',', '.') }}
                                                                                                            ₺</h6>
                                                                                                        <h6
                                                                                                            style="color: #274abb !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                                            {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                                            ₺

                                                                                                        </h6>
                                                                                                    @else
                                                                                                        <h6
                                                                                                            style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                                                                            {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                                            ₺
                                                                                                        </h6>
                                                                                                    @endif
                                                                                                @endif
                                                                                            @else
                                                                                                @if ($projectDiscountAmount)
                                                                                                    <h6
                                                                                                        style="color: #274abb;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'] - $projectDiscountAmount, 0, ',', '.') }}
                                                                                                        ₺</h6>
                                                                                                    <h6
                                                                                                        style="color: #274abb !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                                        ₺

                                                                                                    </h6>
                                                                                                @else
                                                                                                    <h6
                                                                                                        style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                                        ₺
                                                                                                    </h6>
                                                                                                @endif
                                                                                            @endif
                                                                                        @endif
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="w-100"
                                                                        style="height: 40px; background-color: #8080802e; margin-top: 20px">
                                                                        <div class="d-flex justify-content-between align-items-center"
                                                                            style="height: 100%">
                                                                            <span
                                                                                style="    height: 100%;
                                                                                                    font-size: 11px !important;
                                                                                                    width: 15% !important;
                                                                                                    padding: 3px 10px;
                                                                                                    background: #EA2B2E !important;
                                                                                                    color: white;
                                                                                                    text-align: center;">No
                                                                                <br>
                                                                                {{ $room_order - $lastHousingCount }}</span>
                                                                            <ul class="d-flex justify-content-start align-items-center h-100 w-100"
                                                                                style="list-style: none;padding:0;font-weight:600;padding: 10px;justify-content:start;margin-bottom:0 !important">

                                                                                @if (isset($project->listItemValues) &&
                                                                                        isset($project->listItemValues->column1_name) &&
                                                                                        $project->listItemValues->column1_name)
                                                                                    <li
                                                                                        class="d-flex align-items-center itemCircleFont">
                                                                                        <i class="fa fa-circle circleIcon mr-1"
                                                                                            aria-hidden="true"></i>
                                                                                        <span>
                                                                                            {{ $projectHousingsList[$i + 1][$project->listItemValues->column1_name . '[]'] }}
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
                                                                                    <li
                                                                                        class="d-flex align-items-center itemCircleFont">
                                                                                        <i class="fa fa-circle circleIcon mr-1"
                                                                                            aria-hidden="true"></i>
                                                                                        <span>
                                                                                            {{ $projectHousingsList[$i + 1][$project->listItemValues->column2_name . '[]'] }}
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
                                                                                    <li
                                                                                        class="d-flex align-items-center itemCircleFont">
                                                                                        <i class="fa fa-circle circleIcon mr-1"
                                                                                            aria-hidden="true"></i>
                                                                                        <span>
                                                                                            {{ $projectHousingsList[$i + 1][$project->listItemValues->column3_name . '[]'] }}
                                                                                            @if (isset($project->listItemValues) &&
                                                                                                    isset($project->listItemValues->column3_additional) &&
                                                                                                    $project->listItemValues->column3_additional)
                                                                                                {{ $project->listItemValues->column3_additional }}
                                                                                            @endif
                                                                                        </span>
                                                                                    </li>
                                                                                @endif
                                                                            </ul>

                                                                            <span
                                                                                style="    font-size: 9px !important;
                                                                                                        width: 50% !important;
                                                                                                        text-align: right;
                                                                                                        margin-right: 10px;">{!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}</span>
                                                                        </div>
                                                                    </div>
                                                                    <hr>
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
                                            <h5 class="mb-4">Projedeki Konutlar </h5>

                                            <div class="row project-filter-reverse blog-pots">
                                                @for ($i = 0; $i < $project->room_count; $i++)
                                                    @php
                                                        if (isset($projectCartOrders[$i + 1])) {
                                                            $sold = $projectCartOrders[$i + 1];
                                                        } else {
                                                            $sold = null;
                                                        }
                                                        $projectOffer = App\Models\Offer::where('type', 'project')
                                                            ->where('project_id', $project->id)
                                                            ->where('housing_id', $i + 1)
                                                            ->where('start_date', '<=', now())
                                                            ->where('end_date', '>=', now())
                                                            ->first();
                                                        $projectDiscountAmount = $projectOffer ? $projectOffer->discount_amount : 0;
                                                    @endphp

                                                    <div class="col-md-12 col-12">
                                                        <div class="project-card mb-3">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <a href="{{ route('project.housings.detail', [$project->slug, $i + 1]) }}"
                                                                        style="height: 100%">
                                                                        <div class="d-flex" style="height: 100%;">
                                                                            <div
                                                                                style="background-color: #EA2B2E  !important; border-radius: 0px 8px 0px 8px;height:100%">
                                                                                <p
                                                                                    style="padding: 10px;text-align:center; color: white; height: 100%; display: flex; align-items: center; ">
                                                                                    @if (isset($projectHousingsList[$i + 1]['share-sale[]']) && $projectHousingsList[$i + 1]['share-sale[]'] != '[]')
                                                                                        {{ $i + 1 }}. Hisse
                                                                                    @else
                                                                                        No<br>{{ $i + 1 }}
                                                                                    @endif
                                                                                </p>
                                                                            </div>
                                                                            <div class="project-single mb-0 bb-0 aos-init aos-animate"
                                                                                data-aos="fade-up">
                                                                                <div class="project-inner project-head">

                                                                                    <div class="button-effect-div">
                                                                                        @if (Auth::check() && Auth::user()->type == 21)
                                                                                            <span
                                                                                                @if (isset($projectHousingsList[$i + 1]['share-open[]']) && $projectHousingsList[$i + 1]['share-open[]'] != '[]') class="btn addCollection mobileAddCollection" data-bs-toggle="modal" data-bs-target="#addCollectionModal" 
                                                                                          data-type='project'
                                                                                          data-project='{{ $project->id }}'
                                                                                          data-id='{{ $i + 1 }}'
                                                                                            @else
                                                                                            class="btn mobileAddCollection disabledShareButton" @endif>
                                                                                                <i
                                                                                                    class="fa fa-bookmark"></i>
                                                                                            </span>
                                                                                        @endif
                                                                                        <div href="javascript:void()"
                                                                                            class="btn toggle-project-favorite bg-white"
                                                                                            data-project-housing-id="{{ $i + 1 }}"
                                                                                            data-project-id={{ $project->id }}>
                                                                                            <i class="fa fa-heart-o"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="homes position-relative">
                                                                                        <!-- homes img -->
                                                                                        <img src="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[$i + 1]['image[]'] }}"
                                                                                            alt="home-1"
                                                                                            class="img-responsive"
                                                                                            style="height: 120px !important;object-fit:cover">
                                                                                        @if ($projectDiscountAmount)
                                                                                            <div
                                                                                                style="z-index: 2;right: 0;top: 0;background: #e54242; width: 96px; height: 96px; position: absolute; clip-path: polygon(0 0, 45% 0, 100% 55%, 100% 100%);">
                                                                                                <div
                                                                                                    style="color: #FFF; transform: rotate(45deg); margin-left: 25px; margin-top: 30px; font-weight: bold;">
                                                                                                    {{ '%' . round(($projectDiscountAmount / $projectHousingsList[$i + 1]['price[]']) * 100) }}
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

                                                                                            </div>
                                                                                        @endif
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </div>


                                                                <div class="col-lg-9 col-md-9 homes-content pb-0 mb-44 aos-init aos-animate"
                                                                    data-aos="fade-up">

                                                                    <div class="row align-items-center justify-content-between mobile-position"
                                                                        @if (($sold && $sold->status != '2') || $projectHousingsList[$i + 1]['off_sale[]'] != '[]') style="background: #EEE !important;" @endif>
                                                                        <div class="col-md-8">

                                                                            <div class="homes-list-div">
                                                                                <ul
                                                                                    class="homes-list clearfix pb-3 d-flex">
                                                                                    <li
                                                                                        class="d-flex align-items-center itemCircleFont">
                                                                                        <i class="fa fa-circle circleIcon mr-1"
                                                                                            style="color: black;"
                                                                                            aria-hidden="true"></i>
                                                                                        <span>{{ $project->housingType->title }}</span>
                                                                                    </li>
                                                                                    @if (isset($project->listItemValues) &&
                                                                                            isset($project->listItemValues->column1_name) &&
                                                                                            $project->listItemValues->column1_name)
                                                                                        <li
                                                                                            class="d-flex align-items-center itemCircleFont">
                                                                                            <i class="fa fa-circle circleIcon mr-1"
                                                                                                aria-hidden="true"></i>
                                                                                            <span>
                                                                                                {{ $projectHousingsList[$i + 1][$project->listItemValues->column1_name . '[]'] }}
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
                                                                                        <li
                                                                                            class="d-flex align-items-center itemCircleFont">
                                                                                            <i class="fa fa-circle circleIcon mr-1"
                                                                                                aria-hidden="true"></i>
                                                                                            <span>
                                                                                                {{ $projectHousingsList[$i + 1][$project->listItemValues->column2_name . '[]'] }}
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
                                                                                        <li
                                                                                            class="d-flex align-items-center itemCircleFont">
                                                                                            <i class="fa fa-circle circleIcon mr-1"
                                                                                                aria-hidden="true"></i>
                                                                                            <span>
                                                                                                {{ $projectHousingsList[$i + 1][$project->listItemValues->column3_name . '[]'] }}
                                                                                                @if (isset($project->listItemValues) &&
                                                                                                        isset($project->listItemValues->column3_additional) &&
                                                                                                        $project->listItemValues->column3_additional)
                                                                                                    {{ $project->listItemValues->column3_additional }}
                                                                                                @endif
                                                                                            </span>
                                                                                        </li>
                                                                                    @endif

                                                                                    <li class="the-icons mobile-hidden">
                                                                                        <span>
                                                                                            @if ($projectHousingsList[$i + 1]['off_sale[]'] == '[]')
                                                                                                @if ($sold)
                                                                                                    @if ($sold->status != '1' && $sold->status != '0')
                                                                                                        @if ($projectDiscountAmount)
                                                                                                            <h6
                                                                                                                style="color: #274abb;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                                                {{ number_format($projectHousingsList[$i + 1]['price[]'] - $projectDiscountAmount, 0, ',', '.') }}
                                                                                                                ₺</h6>
                                                                                                            <h6
                                                                                                                style="color: #e54242 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                                                {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                                                ₺

                                                                                                            </h6>
                                                                                                        @else
                                                                                                            <h6
                                                                                                                style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                                                                                {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                                                ₺
                                                                                                            </h6>
                                                                                                        @endif
                                                                                                    @endif
                                                                                                @else
                                                                                                    @if ($projectDiscountAmount)
                                                                                                        <h6
                                                                                                            style="color: #274abb;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                                            {{ number_format($projectHousingsList[$i + 1]['price[]'] - $projectDiscountAmount, 0, ',', '.') }}
                                                                                                            ₺</h6>
                                                                                                        <h6
                                                                                                            style="color: #e54242 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                                            {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                                            ₺

                                                                                                        </h6>
                                                                                                    @else
                                                                                                        <h6
                                                                                                            style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                                                                            {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                                            ₺
                                                                                                        </h6>
                                                                                                    @endif
                                                                                                @endif
                                                                                            @endif


                                                                                        </span>
                                                                                    </li>


                                                                                </ul>

                                                                            </div>
                                                                            <div class="footer">
                                                                                <a
                                                                                    href="{{ route('instituional.profile', Str::slug($project->user->name)) }}">
                                                                                    <img src="{{ url('storage/profile_images/' . $project->user->profile_image) }}"
                                                                                        alt="" class="mr-2">
                                                                                    {{ $project->user->name }}
                                                                                </a>
                                                                                <span class="price-mobile">
                                                                                    @if ($projectHousingsList[$i + 1]['off_sale[]'] == '[]')
                                                                                        @if ($sold)
                                                                                            @if ($sold->status != '1' && $sold->status != '0')
                                                                                                @if ($projectDiscountAmount)
                                                                                                    <h6
                                                                                                        style="color: #274abb !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;margin-right:5px">
                                                                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                                        ₺
                                                                                                    </h6>
                                                                                                    <h6
                                                                                                        style="color: #e54242 ;position: relative;top:4px;font-weight:600;font-size:20px;">
                                                                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'] - $projectDiscountAmount, 0, ',', '.') }}

                                                                                                        ₺</h6>
                                                                                                @else
                                                                                                    <h6
                                                                                                        style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}₺
                                                                                                    </h6>
                                                                                                @endif
                                                                                            @endif
                                                                                        @else
                                                                                            @if ($projectDiscountAmount)
                                                                                                <h6
                                                                                                    style="color: #274abb !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;margin-right:5px">
                                                                                                    {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                                    ₺
                                                                                                </h6>
                                                                                                <h6
                                                                                                    style="color: #e54242 ;position: relative;top:4px;font-weight:600;font-size:20px;">
                                                                                                    {{ number_format($projectHousingsList[$i + 1]['price[]'] - $projectDiscountAmount, 0, ',', '.') }}

                                                                                                    ₺</h6>
                                                                                            @else
                                                                                                <h6
                                                                                                    style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                                                                    {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}₺
                                                                                                </h6>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endif


                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3 mobile-hidden"
                                                                            style="height: 120px;padding:0">
                                                                            <div class="homes-button"
                                                                                style="width:100%;height:100%">
                                                                                <button
                                                                                    class="first-btn payment-plan-button"
                                                                                    project-id="{{ $project->id }}"
                                                                                    data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0)) || $projectHousingsList[$i + 1]['off_sale[]'] != '[]' ? '1' : '0' }}"
                                                                                    order="{{ $i }}">
                                                                                    Ödeme Detayları
                                                                                </button>

                                                                                @if ($projectHousingsList[$i + 1]['off_sale[]'] != '[]')
                                                                                    <button class="btn second-btn "
                                                                                        style="background: #EA2B2E !important;width:100%;color:White;height: auto !important">

                                                                                        <span class="text">Satışa
                                                                                            Kapatıldı</span>
                                                                                    </button>
                                                                                @else
                                                                                    @if ($sold && $sold->status != '2')
                                                                                        <button class="btn second-btn "
                                                                                            @if ($sold->status == '0') style="background: orange !important;color:White;height: auto !important"
                                                                                                                    @else 
                                                                                                                    style="background: #EA2B2E !important;color:White;height: auto !important" @endif>
                                                                                            @if ($sold->status == '0')
                                                                                                <span class="text">Onay
                                                                                                    Bekleniyor</span>
                                                                                            @else
                                                                                                <span
                                                                                                    class="text">Satıldı</span>
                                                                                            @endif
                                                                                        </button>
                                                                                    @else
                                                                                        <button class="CartBtn second-btn"
                                                                                            data-type='project'
                                                                                            data-project='{{ $project->id }}'
                                                                                            style="height: auto !important"
                                                                                            data-id='{{ $i + 1 }}'>
                                                                                            <span class="IconContainer">
                                                                                                <img src="{{ asset('sc.png') }}"
                                                                                                    alt="">
                                                                                            </span>
                                                                                            <span class="text">Sepete
                                                                                                Ekle</span>
                                                                                        </button>
                                                                                    @endif
                                                                                @endif

                                                                            </div>
                                                                        </div>

                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                @endfor

                                            </div>
                                        </div>
                                    </div>
                                    <div class="mobile-show">
                                        <div class="container">

                                            @for ($i = 0; $i < $project->room_count; $i++)
                                                @php
                                                    $room_order = $i + 1;

                                                    $projectOffer = App\Models\Offer::where('type', 'project')
                                                        ->where('project_id', $project->id)
                                                        ->where('housing_id', $i + 1)
                                                        ->where('start_date', '<=', now())
                                                        ->where('end_date', '>=', now())
                                                        ->first();
                                                    $projectDiscountAmount = $projectOffer ? $projectOffer->discount_amount : 0;
                                                @endphp
                                                <div class="d-flex" style="flex-wrap: nowrap">
                                                    <div class="align-items-center d-flex"
                                                        style="padding-right:0; width: 110px;">
                                                        <div class="project-inner project-head">
                                                            <a
                                                                href="{{ route('project.housings.detail', [$project->slug, $room_order]) }}">
                                                                <div class="homes">
                                                                    <!-- homes img -->
                                                                    <div class="homes-img h-100 d-flex align-items-center"
                                                                        style="width: 100px; height: 128px;">
                                                                        <img src="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[$i + 1]['image[]'] }}"
                                                                            alt="{{ $project->housingType->title }}"
                                                                            class="img-responsive"
                                                                            style="height: 80px !important;">
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="w-100" style="padding-left:0;">
                                                        <div
                                                            class="bg-white px-3 h-100 d-flex flex-column justify-content-center">
                                                            <a style="text-decoration: none; height: 100%"
                                                                href="{{ route('project.housings.detail', [$project->slug, $room_order]) }}">
                                                                <div class="d-flex justify-content-between"
                                                                    style="gap:8px;">
                                                                    <h3>
                                                                        @if (isset($projectHousingsList[$i + 1]['advertise_title[]']))
                                                                            {{ $projectHousingsList[$i + 1]['advertise_title[]'] }}
                                                                        @else
                                                                            {{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}
                                                                            Projesinde
                                                                            {{ $i + 1 }} {{ "No'lu" }}
                                                                            {{ $project->step1_slug }}
                                                                        @endif
                                                                    </h3>
                                                                    @if (Auth::check() && Auth::user()->type == 21)
                                                                        <span
                                                                            @if (isset($projectHousingsList[$i + 1]['share-open[]']) && $projectHousingsList[$i + 1]['share-open[]'] != '[]') class="btn addCollection mobileAddCollection" data-bs-toggle="modal" data-bs-target="#addCollectionModal" 
                                                                      data-type='project'
                                                                      data-project='{{ $project->id }}'
                                                                      data-id='{{ $i + 1 }}'
                                                        @else
                                                        class="btn mobileAddCollection disabledShareButton" @endif>
                                                                            <i class="fa fa-bookmark"></i>
                                                                        </span>
                                                                    @endif
                                                                    <span class="btn toggle-project-favorite bg-white"
                                                                        data-project-housing-id="{{ $i + 1 }}"
                                                                        style="color: white;"
                                                                        data-project-id="{{ $project->id }}">
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </span>
                                                                </div>
                                                            </a>
                                                            <div class="d-flex align-items-center">
                                                                <div class="d-flex"
                                                                    style="gap: 8px;width: 100%;
                                                                                        align-items: center;">
                                                                    @if ($projectHousingsList[$i + 1]['off_sale[]'] != '[]')
                                                                        <button class="btn second-btn  mobileCBtn"
                                                                            style="background: #EA2B2E !important;width:100%;color:White">

                                                                            <span class="text">Satışa
                                                                                Kapatıldı</span>
                                                                        </button>
                                                                    @else
                                                                        @if ($sold && $sold->status != '2')
                                                                            <button class="btn second-btn  mobileCBtn"
                                                                                @if ($sold->status == '0') style="background: orange !important;color:White" @else  style="background: #EA2B2E !important;color:White;height: auto !important" @endif>
                                                                                @if ($sold->status == '0')
                                                                                    <span class="text">Onay
                                                                                        Bekleniyor</span>
                                                                                @else
                                                                                    <span class="text">Satıldı</span>
                                                                                @endif
                                                                            </button>
                                                                        @else
                                                                            <button class="CartBtn second-btn "
                                                                                data-type='project'
                                                                                data-project='{{ $project->id }}'
                                                                                data-id='{{ $i + 1 }}'>
                                                                                <span class="IconContainer">
                                                                                    <img src="{{ asset('sc.png') }}"
                                                                                        alt="">
                                                                                </span>
                                                                                <span class="text">Sepete
                                                                                    Ekle</span>
                                                                            </button>
                                                                        @endif
                                                                    @endif


                                                                </div>
                                                                <span class="ml-auto text-primary priceFont">
                                                                    @if ($projectHousingsList[$i + 1]['off_sale[]'] == '[]')
                                                                        @if ($sold)
                                                                            @if ($sold->status != '1' && $sold->status != '0')
                                                                                @if ($projectDiscountAmount)
                                                                                    <h6
                                                                                        style="color: #274abb;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'] - $projectDiscountAmount, 0, ',', '.') }}
                                                                                        ₺</h6>
                                                                                    <h6
                                                                                        style="color: #e54242  !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                        ₺

                                                                                    </h6>
                                                                                @else
                                                                                    <h6
                                                                                        style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                        ₺
                                                                                    </h6>
                                                                                @endif
                                                                            @endif
                                                                        @else
                                                                            @if ($projectDiscountAmount)
                                                                                <h6
                                                                                    style="color: #274abb;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                    {{ number_format($projectHousingsList[$i + 1]['price[]'] - $projectDiscountAmount, 0, ',', '.') }}
                                                                                    ₺</h6>
                                                                                <h6
                                                                                    style="color: #e54242  !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                    {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                    ₺

                                                                                </h6>
                                                                            @else
                                                                                <h6
                                                                                    style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                                                    {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                                    ₺
                                                                                </h6>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-100"
                                                    style="height: 40px; background-color: #8080802e; margin-top: 20px">
                                                    <div class="d-flex justify-content-between align-items-center"
                                                        style="height: 100%">
                                                        <span
                                                            style="    height: 100%;
                                                                                font-size: 11px !important;
                                                                                width: 15% !important;
                                                                                padding: 3px 10px;
                                                                                background: #EA2B2E !important;
                                                                                color: white;
                                                                                text-align: center;">
                                                            @if (isset($projectHousingsList[$i + 1]['share-sale[]']) && $projectHousingsList[$i + 1]['share-sale[]'] != '[]')
                                                                {{ $i + 1 - $lastHousingCount }}. Hisse
                                                            @else
                                                                No
                                                                <br>{{ $i + 1 - $lastHousingCount }}
                                                            @endif
                                                        </span>
                                                        <ul class="d-flex justify-content-start align-items-center h-100 w-100"
                                                            style="list-style: none;padding:0;font-weight:600;padding: 10px;justify-content:start;margin-bottom:0 !important">

                                                            @if (isset($project->listItemValues) &&
                                                                    isset($project->listItemValues->column1_name) &&
                                                                    $project->listItemValues->column1_name)
                                                                <li class="d-flex align-items-center itemCircleFont">
                                                                    <i class="fa fa-circle circleIcon mr-1"
                                                                        aria-hidden="true"></i>
                                                                    <span>
                                                                        {{ $projectHousingsList[$i + 1][$project->listItemValues->column1_name . '[]'] }}
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
                                                                    <i class="fa fa-circle circleIcon mr-1"
                                                                        aria-hidden="true"></i>
                                                                    <span>
                                                                        {{ $projectHousingsList[$i + 1][$project->listItemValues->column2_name . '[]'] }}
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
                                                                    <i class="fa fa-circle circleIcon mr-1"
                                                                        aria-hidden="true"></i>
                                                                    <span>
                                                                        {{ $projectHousingsList[$i + 1][$project->listItemValues->column3_name . '[]'] }}
                                                                        @if (isset($project->listItemValues) &&
                                                                                isset($project->listItemValues->column3_additional) &&
                                                                                $project->listItemValues->column3_additional)
                                                                            {{ $project->listItemValues->column3_additional }}
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                            @endif
                                                        </ul>

                                                        <span
                                                            style="    font-size: 9px !important;
                                                                                    width: 50% !important;
                                                                                    text-align: right;
                                                                                    margin-right: 10px;">{!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}</span>
                                                    </div>
                                                </div>
                                                <hr>
                                            @endfor
                                        </div>

                                    </div>



                                </div>
                            @endif

                        </div>
                        <div class="tab-pane fad blog-info details mb-30" id="payment" role="tabpanel"
                            aria-labelledby="payment">
                            <h5 class="mb-4">Ödeme Planı</h5>
                            @php
                                $offSaleValue = $projectHousingsList[$housingOrder]['off_sale[]'];
                                $soldStatus = optional($sold)->status;
                            @endphp
                            @if ($offSaleValue == '[]')
                                @if (($sold && $soldStatus != '0') || $soldStatus != '1')
                                    <div class="table-responsive">
                                        <table class="payment-plan-table table">
                                            <thead>
                                                <tr>
                                                    <th>Ödeme Türü</th>
                                                    <th>Fiyat</th>
                                                    <th>Peşin Ödenecek Tutar</th>
                                                    <th>Aylık Ödenecek Tutar</th>
                                                    <th>Taksit Sayısı</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td data-label="Ödeme Türü">...</td>
                                                    <td data-label="Fiyat">...</td>
                                                    <td data-label="Taksit Sayısı">...</td>
                                                    <td data-label="Peşin Ödenecek Tutar">...</td>
                                                    <td data-label="Aylık Ödenecek Tutar">...</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @elseif ($sold && $soldStatus == '2')
                                    <p class="text-center">Bu {{ lcfirst($parent->title) }} satılmıştır.</p>
                                @endif
                            @endif
                        </div>
                        <div class="tab-pane fade  blog-info details mb-30" id="map" role="tabpanel"
                            aria-labelledby="contact-tab">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&callback=initMap"></script>
    <script>
        function initMap() {
            // İlk harita görüntüsü
            var map = new google.maps.Map(document.getElementById('map'), {
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

        if ($(window).width() <= 768) {

            var buyBtn = $(".buyBtn").html();
            var moveCollection = $(".moveCollection").html();
            $("#listingDetailsSlider").after(buyBtn);
            $(".widgetBuyButton").after(moveCollection);
            $(".buyBtn").css("display", "none");
            $(".moveCollection").css("display", "none");


        };

        $('.project-housing-pagination li').click(function() {
            $('.loading-full').removeClass('d-none')
            console.log($(this).index());
            $.ajax({
                url: "{{ URL::to('/') }}/proje_konut_detayi_ajax/{{ $project->slug }}/{{ $housingOrder }}?selected_page=" +
                    $(this).index() + "&block_id=" + $('.tabs .nav-item.active')
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
        $('.payment-plan-tab').click(function() {
            showLoadingSpinner();

            var order = $(this).attr('order');
            var cart = {
                project_id: $(this).attr('project-id'),
                order: $(this).attr('order'),
                _token: "{{ csrf_token() }}"
            };

            var paymentPlanDatax = {
                "pesin": "Peşin",
                "taksitli": "Taksitli"
            }

            function getDataJS(project, key, roomOrder) {
                var a = 0;
                project.room_info.forEach((room) => {
                    if (room.room_order == roomOrder && room.name == key) {
                        a = room.value;
                    }
                })

                return a;

            }
            // Ajax isteği gönderme


            $.ajax({
                url: "{{ route('get.housing.payment.plan') }}", // Sepete veri eklemek için uygun URL'yi belirtin
                type: "get", // Veriyi göndermek için POST kullanabilirsiniz
                data: cart, // Sepete eklemek istediğiniz ürün verilerini gönderin
                success: function(response) {
                    for (var i = 0; i < response.room_info.length; i++) {
                        if (response.room_info[i].name == "payment-plan[]" && response.room_info[i]
                            .room_order == parseInt(order)) {
                            var paymentPlanData = JSON.parse(response.room_info[i].value);


                            var html = "";

                            function formatPrice(number) {
                                number = parseFloat(number);
                                // Sayıyı ondalık kısmı virgülle ayır
                                const parts = number.toFixed(2).toString().split(".");

                                // Virgül ile ayırmak için her üç haneli kısma nokta ekleyin
                                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                                // Sonucu birleştirin ve virgül ile ayırın
                                return parts.join(",");
                            }
                            var tempPlans = [];
                            for (var j = 0; j < paymentPlanData.length; j++) {

                                if (!tempPlans.includes(paymentPlanData[j])) {
                                    if (paymentPlanData[j] == "pesin") {
                                        var priceData = getDataJS(response, "price[]", response
                                            .room_info[i].room_order);
                                        var installementData = "-";
                                        var advanceData = "-";
                                        var monhlyPrice = "-";
                                    } else {
                                        var priceData = getDataJS(response, "installments-price[]",
                                            response.room_info[i].room_order);
                                        var installementData = getDataJS(response, "installments[]",
                                            response.room_info[i].room_order);
                                        var advanceData = formatPrice(getDataJS(response, "advance[]",
                                            response.room_info[i].room_order)) + "₺";
                                        console.log((parseFloat(getDataJS(response,
                                            "installments-price[]", response.room_info[
                                                i].room_order)) - parseFloat(getDataJS(
                                            response, "advance[]", response.room_info[i]
                                            .room_order))));
                                        var monhlyPrice = (formatPrice(((parseFloat(getDataJS(response,
                                                "installments-price[]", response
                                                .room_info[i].room_order)) - parseFloat(
                                                getDataJS(response, "advance[]",
                                                    response.room_info[i].room_order))) /
                                            parseInt(installementData)))) + '₺';
                                    }
                                    var isMobile = window.innerWidth < 768;
                                    html += "<tr>";

                                    // Function to check if the value is empty or not
                                    function isNotEmpty(value) {
                                        return value !== "" && value !== undefined && value !== "-" &&
                                            value !== null;
                                    }

                                    if (!isMobile && isNotEmpty(paymentPlanDatax[paymentPlanData[j]])) {
                                        html += "<td>" + (isMobile ? "<strong>Ödeme Türü:</strong> " :
                                            "") + paymentPlanDatax[paymentPlanData[j]] + "</td>";
                                    }

                                    if (!isMobile || isNotEmpty(formatPrice(priceData))) {
                                        html += "<td>" + (isMobile ? paymentPlanDatax[paymentPlanData[
                                                j]] + " " + "<strong>Fiyat:</strong> " : "") +
                                            formatPrice(priceData) + "₺</td>";
                                    }


                                    if (!isMobile || isNotEmpty(advanceData)) {
                                        html += "<td>" + (isMobile ? "<strong>Peşinat:</strong> " :
                                            "") + advanceData + "</td>";
                                    }

                                    if (!isMobile || isNotEmpty(monhlyPrice)) {
                                        html += "<td>" + (isMobile ?
                                                "<strong>Aylık Ödenecek Tutar:</strong> " : "") +
                                            monhlyPrice + "</td>";
                                    }


                                    if (!isMobile || isNotEmpty(installementData)) {
                                        html += "<td>" + (isMobile ?
                                                "<strong>Taksit Sayısı:</strong> " : "") +
                                            installementData + "</td>";
                                    }

                                    html += "</tr>";

                                }

                                tempPlans.push(paymentPlanData[j])

                            }

                            hideLoadingSpinner();

                            $('.payment-plan-table tbody').html(html);

                        }
                    }
                },
                error: function(error) {
                    hideLoadingSpinner();
                    toast.error(error)
                    console.error("Hata oluştu: " + error);
                }
            });
        })

        function showLoadingSpinner() {
            // Create a spinner row with colspan
            var spinnerElement = document.createElement('tr');
            spinnerElement.className = 'loading-spinner';

            // Create a single cell with colspan
            var spinnerCell = document.createElement('td');
            spinnerCell.colSpan = 5; // Adjust the colspan value based on the number of columns in your table

            // Add the spinner icon to the cell
            spinnerCell.innerHTML = '<i class="fa fa-spinner fa-spin"></i>'; // Use your preferred spinner

            // Append the cell to the row
            spinnerElement.appendChild(spinnerCell);

            // Append the spinner element to the tbody
            $('.payment-plan-table tbody').html(spinnerElement);
        }


        function hideLoadingSpinner() {
            // Remove the spinner element
            var spinnerElement = document.querySelector('.loading-spinner');
            if (spinnerElement) {
                spinnerElement.parentNode.removeChild(spinnerElement);
            }
        }
        @php
            $location = explode(',', $project->location);
            $location['latitude'] = $location[0];
            $location['longitude'] = $location[1];

            $location = json_encode($location);
            $location = json_decode($location);
        @endphp
        var map = L.map('map').setView([{{ $location->latitude }}, {{ $location->longitude }}], 13);
        var marker = L.marker([{{ $location->latitude }}, {{ $location->longitude }}]).addTo(map);

        // OpenStreetMap katmanını haritaya ekleyin
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var overpassUrl = 'https://overpass-api.de/api/interpreter';
        var query = `[out:json];
(
    node["public_transport"](around:1000,{{ $location->latitude }},{{ $location->longitude }});
    way["public_transport"](around:1000,{{ $location->latitude }},{{ $location->longitude }});
    relation["public_transport"](around:1000,{{ $location->latitude }},{{ $location->longitude }});
);
out center;`;
        var url = `${overpassUrl}?data=${encodeURIComponent(query)}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                var listingsContainer = document.querySelector('.slick-lancersx'); // Listeyi içeren div
                listingsContainer.innerHTML = ''; // Önceki içeriği temizleyin
                data.elements.forEach(element => {
                    var lat = element.lat;
                    var lon = element.lon;
                    var name = element.tags.name || 'Bilinmeyen Mağaza';

                    // Yeni bir liste öğesi oluşturun
                    var listingItem = document.createElement('div');
                    listingItem.classList.add('agents-grid');
                    listingItem.dataset.aos = 'fade-up';
                    listingItem.dataset.aosDelay = '150';
                    if (element.tags.highway == "bus_stop" || element.tags.type == "public_transport") {
                        // Liste içeriğini oluşturun
                        listingItem.innerHTML = `
                    <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                        <div class="project-single">
                            <div class="project-inner project-head">
                                <div class="location-card">
                                    <div class="location-card-head">
                                        <img src="#/assets/images/durak:7299b7f721d8e670e9d070f1f816991a.png" alt="">
                                    </div>
                                    <div class="location-card-body">
                                        ${element.tags.type == "public_transport" ? `<p>${name} Metro Durağı </p>` : `<p>${name} Otobüs Durağı</p>`}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;


                        // Listeyi ekrana ekleyin
                        listingsContainer.appendChild(listingItem);
                    }




                });

                $('.slick-lancersx').slick({
                    infinite: false,
                    slidesToShow: 6,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: true,
                    adaptiveHeight: true,
                    responsive: [{
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2,
                                dots: false,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 993,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2,
                                dots: false,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 769,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                dots: false,
                                arrows: false
                            }
                        }
                    ]
                });
            })
            .catch(error => console.error('Hata:', error));

        $(document).ready(function() {
            $(".nav-item-block").click(function() {
                $(".nav-item-block").removeClass("active");
                $(this).addClass("active");
                $(".tab-content-block").hide();
                $(this).children(".tab-content-block").show();
            });
        });

        if (window.innerWidth <= 768) {
            var mobileMove = $(".mobileMove").html();

            $(".single-proper").after(mobileMove);
            $(".mobileMove").remove();
        }


        function changeTabContentMobile(tabName) {
            document.querySelectorAll('.tab-content').forEach(function(content) {
                content.classList.remove('active');
            });
            document.getElementById('content-' + tabName).classList.add('active');

        }

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
                    url: "{{ route('project.get.housings.by.start.and.end', [$project->id, $housingOrder]) }}?start=0&end=10&block_index=" +
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
                                                            ${
                                                                res[i]["share-sale[]"] && res[i]["share-sale[]"] != "[]" ? 
                                                                    `No <br>${startIndex+1+i}`
                                                                : 
                                                                    `${startIndex+1+i}. Hisse`

                                                            }
                                                            
                                                        </p>
                                                    </div>
                                                    <div class="project-single mb-0 bb-0 aos-init aos-animate" data-aos="fade-up">
                                                        <div class="project-inner project-head">

                                                            <div class="button-effect-div">
                                                                <div href="javascript:void()" class="btn toggle-project-favorite bg-white" data-project-housing-id="${startIndex+1+i+lastBlockHousingCount}" data-project-id="{{ $project->id }}">
                                                                    <i class="fa fa-heart-o"></i>
                                                                </div>
                                                            </div>
                                                            <div class="homes position-relative">
                                                                <img src="{{ URL::to('/') . '/project_housing_images/' }}${res[i]['image[]']}" alt="home-1" class="img-responsive" style="height: 120px !important;object-fit:cover">`
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
                                            <div class="row align-items-center justify-content-between mobile-position">
                                                <div class="col-md-8">
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
                                                                                    <h6 style="color: #274abb !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
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
                                                                                <h6 style="color: #274abb !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
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
                                                        <a href="http://127.0.0.1:8000/magaza/maliyetine-ev/profil">
                                                            <img src="http://127.0.0.1:8000/storage/profile_images/profile_image_1701198728.png" alt="" class="mr-2">
                                                            Maliyetine Ev
                                                        </a>
                                                        <span class="price-mobile">
                                                            1.190.000₺
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mobile-hidden" style="height: 120px;padding:0">
                                                    <div class="homes-button" style="width:100%;height:100%">
                                                        <button class="first-btn payment-plan-button" project-id="281" data-sold="0" order="${startIndex+i+lastBlockHousingCount}">
                                                            Ödeme Detayları
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
                        url: "{{ route('project.get.housings.by.start.and.end', [$project->id, $housingOrder]) }}?start=" +
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
                                                            <br>${startIndex+1+i}
                                                        </p>
                                                    </div>
                                                    <div class="project-single mb-0 bb-0 aos-init aos-animate" data-aos="fade-up">
                                                        <div class="project-inner project-head">

                                                            <div class="button-effect-div">
                                                                <div href="javascript:void()" class="btn toggle-project-favorite bg-white" data-project-housing-id="${startIndex+1+i+lastBlockHousingCount}" data-project-id="{{ $project->id }}">
                                                                    <i class="fa fa-heart-o"></i>
                                                                </div>
                                                            </div>
                                                            <div class="homes position-relative">
                                                                <img src="{{ URL::to('/') . '/project_housing_images/' }}${res[i]['image[]']}" alt="home-1" class="img-responsive" style="height: 120px !important;object-fit:cover">`
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
                                            <div class="row align-items-center justify-content-between mobile-position">
                                                <div class="col-md-8">
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
                                                                                    <h6 style="color: #274abb !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
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
                                                                                <h6 style="color: #274abb !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
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
                                                        <a href="http://127.0.0.1:8000/magaza/maliyetine-ev/profil">
                                                            <img src="http://127.0.0.1:8000/storage/profile_images/profile_image_1701198728.png" alt="" class="mr-2">
                                                            Maliyetine Ev
                                                        </a>
                                                        <span class="price-mobile">
                                                            1.190.000₺
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mobile-hidden" style="height: 120px;padding:0">
                                                    <div class="homes-button" style="width:100%;height:100%">
                                                        <button class="first-btn payment-plan-button" project-id="281" data-sold="0" order="${startIndex+i+lastBlockHousingCount}">
                                                            Ödeme Detayları
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
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        .mobile-tab-content {
            display: none;
        }

        .mobile-tab-content.active {
            display: block !important;
        }

        .storeInfo {
            margin-top: 30px;
        }

        .trStyle,
        .trStyle tr {
            display: flex;
            flex-wrap: wrap;
        }



        .trStyle tr {
            width: 33%;
        }

        .trStyle tr td {
            width: 100%;
            font-size: 11px;
            display: flex;
            justify-content: space-between;
            border: 1px solid #dee2e6;
        }

        .mobileTagProject {
            display: none
        }


        @media (max-width:768px) {
            .addCollectionMobile {
                margin-bottom: 30px !important
            }

            .mobileTagProject {
                width: 150px !important;
                z-index: 9;
                position: absolute !important;
                display: block !important;
                bottom: 0;
                left: 30% !important;
                margin: 0 auto;
            }

            .listingDetailsSliderNav {
                display: none !important;
            }

            #listingDetailsSlider {
                padding: 0 !important;
                margin-bottom: 30px !important;

            }

            .title-fs {
                display: none !important;
            }


            .inner-pages .pro-wrapper .detail-wrapper-body p {
                margin-bottom: 0 !important;
            }

            .nav-tabs {
                margin-top: 0 !important;
            }

            .storeInfo {
                margin: 20px !important;
                margin-bottom: 0 !important;
                margin-top: 0 !important;
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

        @media (max-width: 768px) {
            .payment-plan-table thead {
                display: none !important;
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


        .loading-spinner {
            text-align: center
        }
    </style>
@endsection
