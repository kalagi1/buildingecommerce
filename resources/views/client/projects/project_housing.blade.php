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
    @endphp
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
                <div class="card">
                    <div class="card-img-top" style="background-color: {{ $project->user->banner_hex_code }}">
                        <div class="brands-square">
                            <img src="{{ url('storage/profile_images/' . $project->user->profile_image) }}" alt=""
                                class="brand-logo">
                            <p class="brand-name">
                                <a href="{{ route('institutional.profile', ['slug' => Str::slug($project->user->name), 'userID' => $project->user->id]) }}"
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
                                                <a href="{{ route('project.detail', ['slug' => $item->slug, 'id' => $item->id + 1000000]) }}"
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
                    <div class="headings-2 pt-0 pb-0">
                        <div class="pro-wrapper" style="width: 100%; justify-content: space-between;">
                            @php
                                $advertiseTitle = $projectHousingsList[$housingOrder]['advertise_title[]'] ?? null;
                                $status = optional($sold)->status;
                            @endphp

                            <div class="detail-wrapper-body">
                                <div class="listing-title-bar">
                                    <strong style="color: black;font-size: 11px !important;">İlan No:
                                        <span style="color: #274abb;">{{ $housingOrder + $project->id + 1000000 }}</span>
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
                                <div class="mobile-action"></div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="headings-2 pt-0 pb-0">
                        <div class="pro-wrapper" style="width: 100%; justify-content: space-between;">


                            @php
                                $off_sale_check = $projectHousingsList[$housingOrder]['off_sale[]'] == '[]';
                                $share_sale = $projectHousingsList[$housingOrder]['share_sale[]'] ?? null;
                                $number_of_share = $projectHousingsList[$housingOrder]['number_of_shares[]'] ?? null;
                                $sold_check = $sold && in_array($sold->status, ['1', '0']);
                                $discounted_price =
                                    $projectHousingsList[$housingOrder]['price[]'] - $projectDiscountAmount;

                            @endphp

                            <span style="width:100%;text-align:center">

                                @if (isset($share_sale) && !empty($share_sale) && $number_of_share != 0)
                                    <span class="text-center w-100">
                                        1 Pay Fiyatı
                                    </span>
                                @endif

                                @if ($off_sale_check && $projectDiscountAmount)
                                    <h4
                                        style="color: #274abb !important; position: relative; top: 4px; font-weight: 600;font-size:20px">
                                        @if (isset($share_sale) && !empty($share_sale) && $number_of_share != 0)
                                            {{ number_format($projectHousingsList[$housingOrder]['price[]'] / $number_of_share, 0, ',', '.') }}
                                            ₺
                                        @else
                                            {{ number_format($projectHousingsList[$housingOrder]['price[]'], 0, ',', '.') }}
                                            ₺
                                        @endif
                                    </h4>

                                    <h4
                                        style="color: #e54242 !important;position: relative;top:4px;font-weight:600;font-size: 11px;text-decoration:line-through;">
                                        {{ number_format($projectHousingsList[$housingOrder]['price[]'], 0, ',', '.') }}
                                        ₺
                                    </h4>
                                @elseif ($off_sale_check)
                                    <h4
                                        style="color: #274abb !important; position: relative; top: 4px; font-weight: 600;font-size:20px">
                                        @if (isset($share_sale) && !empty($share_sale) && $number_of_share != 0)
                                            {{ number_format($projectHousingsList[$housingOrder]['price[]'] / $number_of_share, 0, ',', '.') }}
                                            ₺
                                        @else
                                            {{ number_format($projectHousingsList[$housingOrder]['price[]'], 0, ',', '.') }}
                                            ₺
                                        @endif
                                    </h4>
                                @endif
                            </span>
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
                                        <a id="carousel-selector-0" data-slide-to="0"
                                            data-target="#listingDetailsSlider">
                                            <img src="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[$housingOrder]['image[]'] }}"
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

                </div>
                <aside class="col-md-4  car">
                    <div class="single widget buyBtn">
                        <div class="schedule widget-boxed mt-33 mt-0 widgetBuyButton">
                            <div class="row buttonDetail" style="align-items:center;width:100%;margin:0 auto">
                                <div class="col-md-5 col-5 mobile-action-move">
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
                                                <svg viewBox="0 0 24 24" width="20" height="20"
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
                                                    fill="currentColor" width="20" height="20">
                                                    <path
                                                        d="M19.001 4.908A9.817 9.817 0 0 0 11.992 2C6.534 2 2.085 6.448 2.08 11.908c0 1.748.458 3.45 1.321 4.956L2 22l5.255-1.377a9.916 9.916 0 0 0 4.737 1.206h.005c5.46 0 9.908-4.448 9.913-9.913A9.872 9.872 0 0 0 19 4.908h.001ZM11.992 20.15A8.216 8.216 0 0 1 7.797 19l-.3-.18-3.117.818.833-3.041-.196-.314a8.2 8.2 0 0 1-1.258-4.381c0-4.533 3.696-8.23 8.239-8.23a8.2 8.2 0 0 1 5.825 2.413 8.196 8.196 0 0 1 2.41 5.825c-.006 4.55-3.702 8.24-8.24 8.24Zm4.52-6.167c-.247-.124-1.463-.723-1.692-.808-.228-.08-.394-.123-.556.124-.166.246-.641.808-.784.969-.143.166-.29.185-.537.062-.247-.125-1.045-.385-1.99-1.23-.738-.657-1.232-1.47-1.38-1.716-.142-.247-.013-.38.11-.504.11-.11.247-.29.37-.432.126-.143.167-.248.248-.413.082-.167.043-.31-.018-.433-.063-.124-.557-1.345-.765-1.838-.2-.486-.404-.419-.557-.425-.142-.009-.309-.009-.475-.009a.911.911 0 0 0-.661.31c-.228.247-.864.845-.864 2.067 0 1.22.888 2.395 1.013 2.56.122.167 1.742 2.666 4.229 3.74.587.257 1.05.408 1.41.523.595.19 1.13.162 1.558.1.475-.072 1.464-.6 1.673-1.178.205-.58.205-1.075.142-1.18-.061-.104-.227-.165-.475-.29Z">
                                                    </path>
                                                </svg>
                                            </a>

                                        </button>
                                        <button class="messenger-button button"
                                            style="transition-delay: 0.3s, 0s, 0.3s; transition-property: translate, background, box-shadow;">
                                            <a href="https://telegram.me/share/url?url={{ $shareUrl }}">
                                                <svg viewBox="0 0 24 24" width="20" height="20"
                                                    stroke="currentColor" stroke-width="2" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                    <line x1="22" y1="2" x2="11" y2="13">
                                                    </line>
                                                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                                </svg></a>
                                        </button>
                                    </div>
                                    <div class="button-effect toggle-project-favorite"
                                        data-project-housing-id="{{ $projectHousingsList[$housingOrder]['squaremeters[]'] }}"
                                        data-project-id={{ $project->id }}>
                                        <i class="fa fa-heart-o"></i>
                                    </div>

                                </div>
                                <div class="col-md-7 col-7">
                                    @php
                                        $offSaleValue = $projectHousingsList[$housingOrder]['off_sale[]'] ?? null;
                                        $soldStatus = optional($sold)->status;
                                        $share_sale = $projectHousingsList[$housingOrder]['share_sale[]'] ?? null;
                                        $number_of_share =
                                            $projectHousingsList[$housingOrder]['number_of_shares[]'] ?? null;
                                    @endphp


                                    @if ($offSaleValue != '[]')
                                        <button class="btn second-btn  "
                                            style="background: #EA2B2E !important;width:100%;color:White">
                                            <span class="text">Satışa Kapatıldı</span>
                                        </button>
                                    @else
                                        @if (
                                            (isset($soldStatus) && $soldStatus != '2' && empty($share_sale)) ||
                                                (isset($sumCartOrderQt[$housingOrder]) && $sumCartOrderQt[$housingOrder]['qt_total'] == $number_of_share))
                                            <button class="btn second-btn  soldBtn"
                                                @if ($soldStatus == '0') style="background: orange !important;color:White" @else style="background: #EA2B2E !important;color:White" @endif>
                                                @if ($soldStatus == '0' && empty($share_sale))
                                                    <span class="text">Rezerve Edildi</span>
                                                @elseif (
                                                    ($soldStatus == '1' && empty($share_sale)) ||
                                                        (isset($sumCartOrderQt[$housingOrder]) && $sumCartOrderQt[$housingOrder]['qt_total'] == $number_of_share))
                                                    <span class="text">Satıldı</span>
                                                @endif
                                            </button>
                                        @else
                                            <button class="CartBtn second-btn soldBtn" data-type='project'
                                                data-project='{{ $project->id }}' data-id='{{ $housingOrder }}'
                                                data-share="{{ $share_sale }}"
                                                data-number-share="{{ $number_of_share }}">
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
                        <div class="add-to-collections-wrapper addCollectionMobile addCollection" data-type='project'
                            data-id="{{ $housingOrder }}" data-project="{{ $project->id }}">
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
                                                    href="{{ route('institutional.dashboard', ['slug' => Str::slug($project->user->name), 'userID' => $project->user->id]) }}">
                                                    <h4 class="author__title">{!! $project->user->name !!}</h4>
                                                </a>
                                                <p class="author__meta">
                                                    {{ $project->user->corporate_type == 'Emlakçı' ? 'Gayrimenkul Ofisi' : $project->user->corporate_type }}
                                                </p>
                                            </div>
                                        </div>
                                        <table class="table">
                                            <tr>
                                                <td>
                                                    İlan No:
                                                    <span class="det" style="color: #274abb !important;">
                                                        {{ $housingOrder + $project->id + 1000000 }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    İlan Tarihi:
                                                    <span class="det" style="color: #274abb !important;">
                                                        {{ date('j', strtotime($project->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($project->created_at))) . ' ' . date('Y', strtotime($project->created_at)) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    @if ($project->neighbourhood)
                                                        {!! 'İl-İlçe-Mahalle:' !!}
                                                    @else
                                                        {!! 'İl-İlçe:' !!}
                                                    @endif

                                                    <span class="det">
                                                        {!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}
                                                        @if ($project->neighbourhood)
                                                            {!! ' / ' . optional($project->neighbourhood)->mahalle_title !!}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                            @if ($project->user->phone)
                                                <tr>
                                                    <td>
                                                        Kurumsal Numara :
                                                        <span class="det">
                                                            <a style="text-decoration: none;color:inherit"
                                                                href="tel:{!! $project->user->phone !!}">{!! $project->user->phone !!}</a>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($project->user->mobile_phone)
                                                <tr>
                                                    <td>
                                                        Cep :
                                                        <span class="det">
                                                            <a style="text-decoration: none;color:inherit"
                                                                href="tel:{!! $project->user->mobile_phone !!}">{!! $project->user->mobile_phone !!}</a>
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
                            <button class="nav-link active" id="contact-tab" data-bs-toggle="tab"
                                data-bs-target="#contact" type="button" role="tab" aria-controls="contact"
                                aria-selected="false">Projedeki
                                Diğer Konutlar
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                type="button" role="tab" aria-controls="home"
                                aria-selected="true">Açıklama</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab" aria-controls="profile"
                                aria-selected="false">Özellikler</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link payment-plan-tab" id="payment-tab" data-bs-toggle="tab"
                                data-bs-target="#payment" type="button" role="tab" aria-controls="payment"
                                project-id="{{ $project->id }}" order="{{ $housingOrder }}"
                                data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0)) || $projectHousingsList[$housingOrder]['off_sale[]'] != '[]' ? '1' : '0' }}"
                                aria-selected="false">Ödeme Planı</button>
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
                        <div class="tab-pane fade blog-info details mb-30" id="home" role="tabpanel"
                            aria-labelledby="home-tab">
                            {!! $project->description !!}
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
                                                        {{ $project->id + $housingOrder + 1000000 }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @foreach ($projectHousingSetting as $housingSetting)
                                                @php
                                                    $isArrayCheck = $housingSetting->is_array;
                                                    $value = '';

                                                    if (isset($projectHousing[$housingSetting->column_name . '[]'])) {
                                                        $valueArray = json_decode(
                                                            $projectHousing[$housingSetting->column_name . '[]'][
                                                                'value'
                                                            ] ?? null,
                                                        );

                                                        if ($isArrayCheck && isset($valueArray)) {
                                                            $value = implodeData($valueArray);
                                                        } elseif ($housingSetting->is_parent_table) {
                                                            $value = $project[$housingSetting->column_name] ?? null;
                                                        } elseif ($project->roomInfo) {
                                                            foreach ($project->roomInfo as $roomInfo) {
                                                                if (
                                                                    $roomInfo->room_order == 1 &&
                                                                    $roomInfo['name'] ===
                                                                        $housingSetting->column_name . '[]'
                                                                ) {
                                                                    $value =
                                                                        $roomInfo['value'] == '["on"]'
                                                                            ? 'Evet'
                                                                            : ($roomInfo['value'] == '["off"]'
                                                                                ? 'Hayır'
                                                                                : $roomInfo['value']);
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    }
                                                @endphp

                                                @if (!$isArrayCheck && isset($value) && $value !== '')
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
                                                $valueArray = json_decode(
                                                    $projectHousing[$housingSetting->column_name . '[]']['value'] ??
                                                        null,
                                                );

                                                if ($isArrayCheck && isset($valueArray) && $valueArray != null) {
                                                    echo "<div class='mt-5'><h5>{$projectHousing[$housingSetting->column_name .
                '[]']['key']}:</h5><ul class='homes-list clearfix checkSquareIcon'>";
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
                        <div class="tab-pane fade show active   blog-info details housingsListTab mb-30 " id="contact"
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
                                                    @foreach ($project->blocks as $blockKey => $block)
                                                        <div id="contentblock-{{ $block['id'] }}"
                                                            class="tab-content-block{{ $loop->first ? ' active' : '' }}"
                                                            block-id="{{ $block['id'] }}"
                                                            data-block-name="{{ $block['block_name'] }}">
                                                            @php
                                                                $blockHousingCount = $block['housing_count'];
                                                                $previousBlockHousingCount = 0;
                                                                $allCounts = 0;

                                                                if ($blockKey > 0) {
                                                                    $previousBlockHousingCount =
                                                                        $project->blocks[$blockKey - 1][
                                                                            'housing_count'
                                                                        ];
                                                                    $i = $previousBlockHousingCount;
                                                                    $lastHousingCount =
                                                                        $project->blocks[$blockKey - 1][
                                                                            'housing_count'
                                                                        ];
                                                                    for ($j = 0; $j < $blockKey; $j++) {
                                                                        if (
                                                                            isset($project->blocks[$j]) &&
                                                                            isset($project->blocks[$j]['housing_count'])
                                                                        ) {
                                                                            $allCounts +=
                                                                                $project->blocks[$j]['housing_count'];
                                                                        }
                                                                    }
                                                                } else {
                                                                    $i = 0;
                                                                }

                                                            @endphp
                                                            <div class="mobile-hidden">
                                                                <div class="container">
                                                                    <div class="row project-filter-reverse blog-pots">
                                                                        @for ($i = 0; $i < $blockHousingCount; $i++)
                                                                            @php
                                                                                if (isset($projectCartOrders[$i + 1])) {
                                                                                    $sold = $projectCartOrders[$i + 1];
                                                                                } else {
                                                                                    $sold = null;
                                                                                }
                                                                                $isUserSame =
                                                                                    isset($projectCartOrders[$i + 1]) &&
                                                                                    (Auth::check()
                                                                                        ? $projectCartOrders[$i + 1]
                                                                                                ->user_id ==
                                                                                            Auth::user()->id
                                                                                        : false);

                                                                                $projectOffer = App\Models\Offer::where(
                                                                                    'type',
                                                                                    'project',
                                                                                )
                                                                                    ->where('project_id', $project->id)
                                                                                    ->where(function ($query) use ($i) {
                                                                                        $query
                                                                                            ->orWhereJsonContains(
                                                                                                'project_housings',
                                                                                                [$i + 1],
                                                                                            )
                                                                                            ->orWhereJsonContains(
                                                                                                'project_housings',
                                                                                                (string) ($i + 1),
                                                                                            ); // Handle as string as JSON might store values as strings
                                                                                    })
                                                                                    ->where('start_date', '<=', now())
                                                                                    ->where('end_date', '>=', now())
                                                                                    ->first();
                                                                                $projectDiscountAmount = $projectOffer
                                                                                    ? $projectOffer->discount_amount
                                                                                    : 0;
                                                                            @endphp

                                                                            <x-project-item-card :project="$project"
                                                                                :towns="$towns" :cities="$cities"
                                                                                :allCounts="$allCounts" :key="$key"
                                                                                :blockHousingCount="$blockHousingCount" :previousBlockHousingCount="$previousBlockHousingCount"
                                                                                :sumCartOrderQt="$sumCartOrderQt" :isUserSame="$isUserSame"
                                                                                :bankAccounts="$bankAccounts" :i="$i"
                                                                                :projectHousingsList="$projectHousingsList" :projectDiscountAmount="$projectDiscountAmount"
                                                                                :sold="$sold" :lastHousingCount="$lastHousingCount" />
                                                                        @endfor
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mobile-show">
                                                                @for ($i = 0; $i < $blockHousingCount; $i++)
                                                                    @php
                                                                        if (isset($projectCartOrders[$i + 1])) {
                                                                            $sold = $projectCartOrders[$i + 1];
                                                                        } else {
                                                                            $sold = null;
                                                                        }
                                                                        $isUserSame =
                                                                            isset($projectCartOrders[$i + 1]) &&
                                                                            (Auth::check()
                                                                                ? $projectCartOrders[$i + 1]->user_id ==
                                                                                    Auth::user()->id
                                                                                : false);

                                                                        $projectOffer = App\Models\Offer::where(
                                                                            'type',
                                                                            'project',
                                                                        )
                                                                            ->where('project_id', $project->id)
                                                                            ->where(function ($query) use ($i) {
                                                                                $query
                                                                                    ->orWhereJsonContains(
                                                                                        'project_housings',
                                                                                        [$i + 1],
                                                                                    )
                                                                                    ->orWhereJsonContains(
                                                                                        'project_housings',
                                                                                        (string) ($i + 1),
                                                                                    ); // Handle as string as JSON might store values as strings
                                                                            })
                                                                            ->where('start_date', '<=', now())
                                                                            ->where('end_date', '>=', now())
                                                                            ->first();
                                                                        $projectDiscountAmount = $projectOffer
                                                                            ? $projectOffer->discount_amount
                                                                            : 0;
                                                                        $blockName = $block['block_name'];
                                                                    @endphp

                                                                    <x-project-item-mobile-card :project="$project"
                                                                        :towns="$towns" :cities="$cities"
                                                                        :blockName="$blockName" :allCounts="$allCounts"
                                                                        :key="$key" :blockHousingCount="$blockHousingCount"
                                                                        :previousBlockHousingCount="$previousBlockHousingCount" :sumCartOrderQt="$sumCartOrderQt"
                                                                        :isUserSame="$isUserSame" :bankAccounts="$bankAccounts"
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

                                            <div class="row project-filter-reverse blog-pots" id="project-room">
                                                @for ($i = 0; $i < min($project->room_count, 10); $i++)
                                                    @php

                                                        if (isset($projectCartOrders[$i + 1])) {
                                                            $sold = $projectCartOrders[$i + 1];
                                                        } else {
                                                            $sold = null;
                                                        }
                                                        $allCounts = 0;
                                                        $blockHousingCount = 0;
                                                        $previousBlockHousingCount = 0;
                                                        $key = 0;
                                                        $isUserSame =
                                                            isset($projectCartOrders[$i + 1]) &&
                                                            (Auth::check()
                                                                ? $projectCartOrders[$i + 1]->user_id ==
                                                                    Auth::user()->id
                                                                : false);

                                                        $projectOffer = App\Models\Offer::where('type', 'project')
                                                            ->where('project_id', $project->id)
                                                            ->where(function ($query) use ($i) {
                                                                $query
                                                                    ->orWhereJsonContains('project_housings', [$i + 1])
                                                                    ->orWhereJsonContains(
                                                                        'project_housings',
                                                                        (string) ($i + 1),
                                                                    ); // Handle as string as JSON might store values as strings
                                                            })
                                                            ->where('start_date', '<=', now())
                                                            ->where('end_date', '>=', now())
                                                            ->first();
                                                        $projectDiscountAmount = $projectOffer
                                                            ? $projectOffer->discount_amount
                                                            : 0;
                                                    @endphp

                                                    <x-project-item-card :project="$project" :allCounts="$allCounts"
                                                        :towns="$towns" :cities="$cities" :key="$key"
                                                        :blockHousingCount="$blockHousingCount" :previousBlockHousingCount="$previousBlockHousingCount" :sumCartOrderQt="$sumCartOrderQt"
                                                        :isUserSame="$isUserSame" :bankAccounts="$bankAccounts" :i="$i"
                                                        :projectHousingsList="$projectHousingsList" :projectDiscountAmount="$projectDiscountAmount" :sold="$sold"
                                                        :lastHousingCount="$lastHousingCount" />
                                                @endfor
                                            </div>
                                            <div class="ajax-load" style="display: none;">
                                                Yükleniyor...
                                            </div>

                                        </div>
                                    </div>
                                    <div class="mobile-show">
                                        <div class="container">
                                            <div id="project-room-mobile">
                                                @for ($i = 0; $i < min($project->room_count, 10); $i++)
                                                    @php
                                                        $sold = isset($projectCartOrders[$i + 1])
                                                            ? $projectCartOrders[$i + 1]
                                                            : null;

                                                        $room_order = $i + 1;
                                                        $allCounts = 0;
                                                        $blockHousingCount = 0;
                                                        $previousBlockHousingCount = 0;
                                                        $key = 0;
                                                        $isUserSame =
                                                            isset($projectCartOrders[$i + 1]) &&
                                                            (Auth::check()
                                                                ? $projectCartOrders[$i + 1]->user_id ==
                                                                    Auth::user()->id
                                                                : false);

                                                        $projectOffer = App\Models\Offer::where('type', 'project')
                                                            ->where('project_id', $project->id)
                                                            ->where(function ($query) use ($i) {
                                                                $query
                                                                    ->orWhereJsonContains('project_housings', [$i + 1])
                                                                    ->orWhereJsonContains(
                                                                        'project_housings',
                                                                        (string) ($i + 1),
                                                                    ); // Handle as string as JSON might store values as strings
                                                            })
                                                            ->where('start_date', '<=', now())
                                                            ->where('end_date', '>=', now())
                                                            ->first();
                                                        $projectDiscountAmount = $projectOffer
                                                            ? $projectOffer->discount_amount
                                                            : 0;
                                                    @endphp
                                                    <x-project-item-mobile-card :towns="$towns" :cities="$cities"
                                                        :blockName="null" :project="$project" :allCounts="$allCounts"
                                                        :key="$key" :blockHousingCount="$blockHousingCount" :previousBlockHousingCount="$previousBlockHousingCount"
                                                        :sumCartOrderQt="$sumCartOrderQt" :isUserSame="$isUserSame" :bankAccounts="$bankAccounts"
                                                        :i="$i" :projectHousingsList="$projectHousingsList" :projectDiscountAmount="$projectDiscountAmount"
                                                        :sold="$sold" :lastHousingCount="$lastHousingCount" />
                                                @endfor
                                            </div>
                                            <div class="ajax-load" style="display: none;">
                                                Yükleniyor...
                                            </div>
                                        </div>

                                    </div>



                                </div>
                            @endif

                        </div>
                        <div class="tab-pane fad blog-info details mb-30" id="payment" role="tabpanel"
                            aria-labelledby="payment">
                            @php
                                $offSaleValue = $projectHousingsList[$housingOrder]['off_sale[]'];
                                $soldStatus = optional($sold)->status;
                            @endphp
                            @if ($offSaleValue == '[]')
                                @if (($sold && $soldStatus != '0') || $soldStatus != '1')
                                    <div class="table-responsive">
                                        <table class="payment-plan-table table">

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
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&callback=initMap"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
   
    <script>
        var successMessage = "{{ session('success') }}";

        if (successMessage) {
            Toastify({
                text: successMessage,
                duration: 5000,
                gravity: 'bottom',
                position: 'center',
                backgroundColor: 'green',
                stopOnFocus: true,
            }).showToast();
        }
        $('.citySelect').change(function() {
            var selectedCity = $(this).val();

            $.ajax({
                type: 'GET',
                url: '/get-counties/' + selectedCity,
                success: function(data) {
                    var countySelect = $('.countySelect');
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
    </script>
    <script>
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

        if ($(window).width() <= 768) {
            var mobileActionMove = $(".mobile-action-move").html();
            var mobileMove = $(".mobileMove").html();
            var mobileHour = $(".mobileHour").html();
            var mobileMovePrice = $(".mobileMovePrice").html();

            $("#listingDetailsSlider").after(mobileHour);
            $(".mobileHourDiv").after(mobileMove);
            $(".mobile-action").html(mobileActionMove);


            $(".mobileMovePrice").remove();
            $(".mobile-action-move").html(mobileMovePrice);
            $(".mobileMove").remove();
            $(".mobileHour").remove();
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
            var soldStatus = $(this).data('sold');

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

            const months = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran",
                "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"
            ]

            if (soldStatus == "1") {

                hideLoadingSpinner();
                Swal.fire({
                    icon: 'warning',
                    title: 'Uyarı',
                    text: 'Bu ürün için ödeme detay bilgisi gösterilemiyor.',
                    confirmButtonText: 'Kapat'
                });
                var html = "<span>Bu ürün için ödeme detay bilgisi gösterilemiyor.</span>";
                $('.payment-plan-table tbody').html(html);
            } else {
                $.ajax({
                    url: "{{ route('get.housing.payment.plan') }}", // Sepete veri eklemek için uygun URL'yi belirtin
                    type: "get", // Veriyi göndermek için POST kullanabilirsiniz
                    data: cart, // Sepete eklemek istediğiniz ürün verilerini gönderin
                    success: function(response) {
                        for (var i = 0; i < response.room_info.length; i++) {
                            var numberOfShares = 0;
                            var shareSale = getDataJS(response, "share_sale[]", response.room_info[i]
                                .room_order);
                            if (shareSale && shareSale == '["Var"]') {
                                var numberOfShares = parseFloat(getDataJS(response,
                                    "number_of_shares[]",
                                    response.room_info[i].room_order));


                            }
                            if (response.room_info[i].name == "payment-plan[]" && response.room_info[i]
                                .room_order == parseInt(order)) {
                                var paymentPlanData = JSON.parse(response.room_info[i].value);
                                if (!paymentPlanData.includes("pesin")) {
                                    // "peşin" not present, add it to the beginning of the array
                                    paymentPlanData.unshift("pesin");
                                } else if (!paymentPlanData.includes("taksitli")) {
                                    // "peşin" already present, but "taksitli" is not, add "taksitli" to the end
                                    const indexOfPesin = paymentPlanData.indexOf("pesin");
                                    paymentPlanData.splice(indexOfPesin + 1, 0, "taksitli");
                                }

                                if (paymentPlanData[0] != "pesin") {
                                    paymentPlanData.reverse();

                                }


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
                                orderHousing = parseInt(order);

                                html += "<tr class='" + (isMobile ? "mobile-hidden" : "") +
                                    "' style='background-color: #EEE !important;' ><th style='text-align:center' colspan=" +
                                    3 + getDataJS(response,
                                        "pay-dec-count" + (orderHousing), response
                                        .room_info[i].room_order) + " >" + response.project_title +
                                    " Projesinde " + response.room_info[i]
                                    .room_order + " No'lu İlan Ödeme Planı</th></tr>";


                                for (var j = 0; j < paymentPlanData.length; j++) {

                                    if (!tempPlans.includes(paymentPlanData[j])) {
                                        if (paymentPlanData[j] == "pesin") {
                                            var priceData = numberOfShares != 0 ? (getDataJS(response,
                                                    "price[]", response
                                                    .room_info[i].room_order) / numberOfShares) :
                                                getDataJS(response, "price[]", response
                                                    .room_info[i].room_order);
                                            var installementData = "";
                                            var advanceData = "";
                                            var monhlyPrice = "";
                                        } else {


                                            var priceData = numberOfShares != 0 ? (getDataJS(response,
                                                    "installments-price[]", response
                                                    .room_info[i].room_order) / numberOfShares) :
                                                getDataJS(response, "installments-price[]", response
                                                    .room_info[i].room_order);

                                            var installementData = getDataJS(response, "installments[]",
                                                response.room_info[i].room_order);

                                            var advanceData = numberOfShares != 0 ? formatPrice(
                                                getDataJS(response,
                                                    "advance[]",
                                                    response.room_info[i].room_order) /
                                                numberOfShares) + "₺" : formatPrice(getDataJS(
                                                response,
                                                "advance[]",
                                                response.room_info[i].room_order)) + "₺";

                                            var monhlyPrice = numberOfShares != 0 ? formatPrice(((
                                                        parseFloat(getDataJS(
                                                            response,
                                                            "installments-price[]", response
                                                            .room_info[i].room_order)) -
                                                        parseFloat(getDataJS(response,
                                                            "advance[]", response.room_info[
                                                                i].room_order)) - payDecPrice) /
                                                    parseInt(installementData)) / numberOfShares) +
                                                "₺" : formatPrice((parseFloat(getDataJS(
                                                            response,
                                                            "installments-price[]", response
                                                            .room_info[i].room_order)) -
                                                        parseFloat(getDataJS(response,
                                                            "advance[]", response.room_info[
                                                                i].room_order)) - payDecPrice) /
                                                    parseInt(installementData)) + "₺";
                                        }
                                        var isMobile = window.innerWidth < 768;

                                        orderHousing = "{{ $housingOrder }}" - 1;

                                        var payDecPrice = 0;
                                        if (paymentPlanDatax[paymentPlanData[j]] == "Taksitli") {
                                            html += "<tr class='" + (isMobile ? "mobile-hidden" : "") +
                                                "' style='background-color: #EEE !important;'><th>" +
                                                installementData +
                                                " Ay Taksitli Fiyat</th><th>Peşinat</th><th>Aylık Ödenecek Miktar</th>";

                                            for (var l = 1; l <= getDataJS(response,
                                                    "pay-dec-count" + (orderHousing + 1), response
                                                    .room_info[i].room_order); l++) {
                                                html += "<th>" +
                                                    l + ". Ara Ödeme</th>";
                                            }

                                            html += "</tr>";
                                        }

                                        html += "<tr>";

                                        // Function to check if the value is empty or not
                                        function isNotEmpty(value) {
                                            return value !== "" && value !== undefined && value !==
                                                "-" &&
                                                value !== null;
                                        }

                                        if (!isMobile && isNotEmpty(paymentPlanDatax[paymentPlanData[
                                                j]]) && paymentPlanDatax[paymentPlanData[j]] !=
                                            "Taksitli") {
                                            html += "<td>" + (isMobile ?
                                                "<strong>Ödeme Türü:</strong> " :
                                                "") + paymentPlanDatax[paymentPlanData[j]] + "</td>";
                                        }
                                        if (!isMobile || isNotEmpty(formatPrice(priceData))) {

                                            if (paymentPlanDatax[paymentPlanData[j]] === 'Taksitli') {
                                                html += "<td><strong>" + (
                                                    isMobile ? paymentPlanDatax[
                                                        paymentPlanData[j]] + " " +
                                                    "Fiyat:</strong> " : "") + formatPrice(
                                                    priceData) + "₺</td>";
                                            } else {
                                                html += "<td><strong>" + (isMobile ? paymentPlanDatax[
                                                        paymentPlanData[j]] + " " +
                                                    "Fiyat:</strong> " : "") + formatPrice(
                                                    priceData) + "₺</td>";
                                            }


                                        }


                                        if (!isMobile || isNotEmpty(advanceData)) {
                                            html += advanceData ? "<td>" + (isMobile ?
                                                "<strong>Peşinat:</strong> " :
                                                "") + advanceData + "</td>" : null;
                                        }

                                        if (!isMobile || isNotEmpty(monhlyPrice)) {
                                            html += monhlyPrice ? "<td>" + (isMobile ?
                                                "<strong>Aylık Ödenecek Tutar:</strong> " :
                                                "") + monhlyPrice + "</td>" : null;
                                        }

                                        if (!isMobile && isNotEmpty(advanceData) && paymentPlanDatax[
                                                paymentPlanData[j]] != "Taksitli") {
                                            var installmentsPrice = parseFloat(getDataJS(response,
                                                "installments-price[]", response.room_info[i]
                                                .room_order));
                                            var advanceAmount = parseFloat(getDataJS(response,
                                                "advance[]", response.room_info[i].room_order));

                                            // Check if the values are valid numbers
                                            if (!isNaN(installmentsPrice) && !isNaN(advanceAmount) && !
                                                isNaN(payDecPrice)) {
                                                var calculatedValue = installmentsPrice -
                                                    advanceAmount - payDecPrice;

                                                html += "<td>" + (isMobile ?
                                                        "<strong>Ara Ödemeler Çıkınca Ödenecek Tutar:</strong> " :
                                                        "") +
                                                    formatPrice(calculatedValue) + "</td>";
                                            }
                                        }





                                        if (!isMobile && isNotEmpty(installementData) &&
                                            paymentPlanDatax[paymentPlanData[j]] != "Taksitli") {
                                            html += "<td>" + (isMobile ?
                                                    "<strong>Taksit Sayısı:</strong> " : "") +
                                                installementData + "</td>";
                                        }


                                        var payDecPrice = 0;
                                        if (getDataJS(response, "pay-dec-count" + (orderHousing + 1),
                                                response.room_info[i].room_order)) {

                                            for (var l = 0; l < getDataJS(response,
                                                    "pay-dec-count" + (orderHousing + 1), response
                                                    .room_info[i].room_order); l++) {

                                                if (getDataJS(response, "pay_desc_price" + (
                                                            orderHousing +
                                                            1) + l, response.room_info[i]
                                                        .room_order)) {
                                                    payDecPrice += parseFloat(getDataJS(response,
                                                        "pay_desc_price" + (orderHousing + 1) +
                                                        l,
                                                        response.room_info[i].room_order));
                                                    var payDescDate = new Date(getDataJS(response,
                                                        "pay_desc_date" + (orderHousing + 1) +
                                                        l,
                                                        response.room_info[i].room_order));

                                                    if (paymentPlanDatax[paymentPlanData[j]] ==
                                                        "Taksitli") {
                                                        html += "<td>" + (isMobile ? "<strong>" + (l +
                                                                    1) +
                                                                ". Ara Ödeme :</strong> <br>" : "") +
                                                            formatPrice(parseFloat(getDataJS(response,
                                                                "pay_desc_price" + (
                                                                    orderHousing +
                                                                    1) + l, response.room_info[
                                                                    i]
                                                                .room_order))) + "₺" +
                                                            (isMobile ? "<br>" : "<br>") +
                                                            (months[payDescDate.getMonth()] + ' ' +
                                                                payDescDate.getDate() + ', ' +
                                                                payDescDate
                                                                .getFullYear()) + "</td>";
                                                    } else {
                                                        html += null;
                                                    }


                                                }

                                            }
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
            }
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
            var block = document.getElementById('contentblock-' + tabName).dataset.blockName;

            var startIndex = 0;
            var endIndex = 10;
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

    </script>
 <script>
    var currentPage = 1;
var itemsPerPage = 10;
var maxPages = Math.ceil({{ $project->room_count }} / itemsPerPage);
var isLoading = false; // Kontrol flag'ı ekledik

$(document).ready(function() {
 $(window).scroll(function() {
     var projectRoom = $('#project-room');
     var projectRoomMobile = $('#project-room-mobile');

     // Web
     if ($(window).scrollTop() + $(window).height() >= projectRoom.offset().top + projectRoom.outerHeight() - 50 && !isLoading && window.innerWidth >= 768) {
         if (currentPage < maxPages) {
             isLoading = true; // Yüklenme başladığında flag'ı true olarak ayarla
             currentPage++;
             loadMoreData(currentPage);
         }
     }

     // Mobil
     if ($(window).scrollTop() + $(window).height() >= projectRoomMobile.offset().top + projectRoomMobile.outerHeight() - 50 && !isLoading && window.innerWidth < 768) {
         if (currentPage < maxPages) {
             isLoading = true; // Yüklenme başladığında flag'ı true olarak ayarla
             currentPage++;
             loadMoreDataMobile(currentPage);
         }
     }
 });
});

function loadMoreData(page) {
 $.ajax({
     url: "{{ url('/load-more-rooms') }}/{{ $project->id }}/" + page,
     type: 'get',
     beforeSend: function() {
         $('.ajax-load').show();
     },
     success: function(response) {
         $('#project-room').append(response);
         $('.ajax-load').hide();
         isLoading = false; // Yüklenme tamamlandığında flag'ı false olarak ayarla
     },
     error: function(jqXHR, ajaxOptions, thrownError) {
         console.log(thrownError);

         $('.ajax-load').hide();
         isLoading = false; // Hata durumunda flag'ı false olarak ayarla
     }
 });
}

function loadMoreDataMobile(page) {
 $.ajax({
     url: "{{ url('/load-more-rooms-mobile') }}/{{ $project->id }}/" + page,
     type: 'get',
     beforeSend: function() {
         $('.ajax-load').show();
     },
     success: function(response) {
         $('#project-room-mobile').append(response);
         $('.ajax-load').hide();
         isLoading = false; // Yüklenme tamamlandığında flag'ı false olarak ayarla
     },
     error: function(jqXHR, ajaxOptions, thrownError) {
         console.log(thrownError);

         $('.ajax-load').hide();
         isLoading = false; // Hata durumunda flag'ı false olarak ayarla
     }
 });
}

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
            if (!{{ Auth::check() ? 'true' : 'false' }}) {
                // User is not authenticated, show error toast
                // You can use a library like toastr.js or any other method to display a toast
                // Example using toastr.js
                toastr.error('Lütfen giriş yapın!');
                return;
            }

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

        .mobile-action-move {
            display: flex;
            align-items: center;
            justify-content: space-evenly
        }

        @media (max-width:768px) {
            .mobile-action {
                margin-left: 10px
            }

            .mobile-action-move h4 {
                font-size: 18px;
                font-weight: 700;
                color: #274abb;
                display: flex;
                width: 100%;
                margin-bottom: 0;
                align-items: center;
                justify-content: center;
                text-transform: capitalize !important;
            }

            .buttons {
                margin-right: 10px
            }


            .detail-wrapper-body,
            .mobile-action {
                display: flex;
                align-items: center;
                justify-content: center
            }

            .listing-title-bar {
                color: black;
                font-size: 12px !important;
                width: 100%;
                display: block;
                text-align: left;
            }

            .brand-head {
                margin-bottom: 0 !important;
            }

            .addCollectionMobile {
                margin-bottom: 20px !important
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
            height: 48px;
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

            .payment-plan-table td strong {
                font-weight: 700 !important
            }

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
    <style>
        .modal-label {
            margin: 0.3em 0em;
            font-size: 13px;
            font: bold;
            color: #000000 !important;
        }

        .modal-input {
            padding: 1em !important;
            border: 1px solid #eee !important;
            margin: 0.5em 0em;
            width: 100%;
            transition: border-color 0.3s;
        }

        .modal-footer {
            display: flex;
            justify-content: space-between;
        }

        .modal-btn-gonder,
        .modal-btn-kapat {
            padding: 0.8em 2em;
            font-weight: 600;
            transition: background-color 0.3s;
            width: 45%;
            border: none;
            height: 45px;
        }

        .modal-btn-gonder {
            background-color: #ea2b2e;
            color: #fff;
        }

        .modal-btn-kapat {
            background-color: #1e1e1e;
            color: #fff;
        }

        form {
            margin: 1em;
        }


        .modal-title {
            font-size: 2.5rem;
            margin-right: 30%;
            margin-left: 43%;
            font-size: 15px !important;
            margin-top: 0.8em;
            margin-bottom: 0.8em;
        }

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
            height: 35px !important;
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
            height: 35px !important;
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
