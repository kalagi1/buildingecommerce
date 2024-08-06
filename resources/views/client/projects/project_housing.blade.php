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
    @endphp
    @php
        // Retrieve the necessary data
        $canAddToProject = checkIfUserCanAddToProjectHousings($project->id, $housingOrder);
        $user = Auth::user();
        $isUserType2EmlakOfisi = $user && $user->type == '2' && $user->corporate_type == 'Emlak Ofisi';
        $isUserType1 = $user && $user->type == '1';
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
        $projectDiscountAmount = 0;
        $offer = App\Models\Offer::where('type', 'project')
            ->where('project_id', $project->id)
            ->whereJsonContains('project_housings', $housingOrder)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if ($offer) {
            $projectDiscountAmount = $offer->discount_amount;
        }
    @endphp
    @php
        // Initialize variables
        $off_sale_1 = $off_sale_2 = $off_sale_3 = $off_sale_4 = false;

        // Check if 'off_sale[]' key exists
        if (isset($projectHousingsList[$housingOrder]['off_sale[]'])) {
            // Convert the string to an array if neededx
            $off_sale_array = json_decode($projectHousingsList[$housingOrder]['off_sale[]'], true);

            // Check if the conversion was successful and if each value is in the array
            if (is_array($off_sale_array)) {
                $off_sale_1 = in_array('1', $off_sale_array);
                $off_sale_2 = in_array('2', $off_sale_array);
                $off_sale_3 = in_array('3', $off_sale_array);
                $off_sale_4 = in_array('4', $off_sale_array);
            }
        }
        $share_sale = $projectHousingsList[$housingOrder]['share_sale[]'] ?? null;
        $number_of_share = $projectHousingsList[$housingOrder]['number_of_shares[]'] ?? null;
        $sold_check = $sold && in_array($sold->status, ['1', '0']);
        $discounted_price = $projectHousingsList[$housingOrder]['price[]'] - $projectDiscountAmount;
        $share_sale_empty = !isset($share_sale) || $share_sale == '[]';

    @endphp
    <section class="single-proper blog details bg-white">
        <div class="loading-full d-none">
            <div class="back-opa">

            </div>
            <div class="content-loading">
                <i class="fa fa-spinner"></i>
            </div>
        </div>

        <x-store-card :store="$project->user" :project="$project" :housingOrder="$housingOrder" />

        <div class="container">
            <div class="row mb-3" style="align-items: center">
                <div class="col-md-8">
                    <div class="headings-2 pt-0 pb-0">
                        <div class="pro-wrapper" style="width: 100%; justify-content: space-between;">
                            @php
                                $advertiseTitle = $projectHousingsList[$housingOrder]['advertise_title[]'] ?? null;
                                $isSwap = $projectHousingsList[$housingOrder]['swap[]'] ?? null;
                                $status = optional($sold)->status;
                            @endphp

                            <div class="detail-wrapper-body">
                                <div class="listing-title-bar">
                                    <h3>
                                        @if ($status && $status != '0' && $status != '1')
                                            @include('client.layouts.partials.project_title', [
                                                'title' => $project->project_title,
                                                'advertiseTitle' => $advertiseTitle,
                                                'housingOrder' => $housingOrder,
                                                'step1Slug' => $project->step1_slug,
                                                'blockName' => $blockName,
                                                'blockHousingOrder' => $blockHousingOrder,
                                            ])
                                        @else
                                            @include('client.layouts.partials.project_title', [
                                                'title' => $project->project_title,
                                                'advertiseTitle' => $advertiseTitle,
                                                'housingOrder' => $housingOrder,
                                                'step1Slug' => $project->step1_slug,
                                                'blockName' => $blockName,
                                                'blockHousingOrder' => $blockHousingOrder,
                                            ])
                                        @endif
                                        {{-- @if ($project->step1_slug)
                                            <span class="mrg-l-5 category-tag">
                                                {{ ucfirst($project->step2_slug) }}
                                                {{ ucfirst($project->step1_slug) }}
                                            </span>
                                        @endif --}}
                                    </h3>
                                    {{-- <div class="mt-0">
                                        <a href="#listing-location" class="listing-address">
                                            <i class="fa fa-map-marker pr-2 ti-location-pin mrg-r-5"></i>
                                            {!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}
                                            @if ($project->neighbourhood)
                                                {!! ' / ' . optional($project->neighbourhood)->mahalle_title !!}
                                            @endif

                                        </a>
                                    </div> --}}


                                </div>


                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="headings-2 pt-0 pb-0 move-gain">
                        @if (isset($projectHousingsList[$housingOrder]['projected_earnings[]']) ||
                                isset($projectHousingsList[$housingOrder]['ong_kira[]']))
                            <div class="gainStyle"
                                style="width: 100%; justify-content: center;align-items:center;display:flex;flex-direction: column;">

                                @if (isset($projectHousingsList[$housingOrder]['projected_earnings[]']))
                                    <div>
                                        <svg viewBox="0 0 24 24" width="30" height="21" stroke="green"
                                            stroke-width="2" fill="green" stroke-linecap="round" stroke-linejoin="round"
                                            class="css-i6dzq1">
                                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                            <polyline points="17 6 23 7 23 12"></polyline>
                                        </svg>
                                        <strong style="font-size:13px;"> Öngörülen Yıllık Kazanç: </strong>
                                        <span style="font-size:13px;margin-left:4px">
                                            %{{ $projectHousingsList[$housingOrder]['projected_earnings[]'] }}</span>
                                    </div>
                                @endif



                                @if (isset($projectHousingsList[$housingOrder]['ong_kira[]']))
                                    <div>
                                        <svg viewBox="0 0 24 24" width="30" height="21" stroke="green"
                                            stroke-width="2" fill="green" stroke-linecap="round" stroke-linejoin="round"
                                            class="css-i6dzq1">
                                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                            <polyline points="17 6 23 7 23 12"></polyline>
                                        </svg>
                                        <strong style="font-size:13px;"> Öngörülen Kira Getirisi: </strong>
                                        <span style="font-size:13px;margin-left:4px">
                                            {{ $projectHousingsList[$housingOrder]['ong_kira[]'] }} TL</span>
                                    </div>
                                @endif

                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-md-12 blog-pots">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="listingDetailsSlider" class="carousel listing-details-sliders slide mb-30">
                                <div class="button-effect-div favorite-move">

                                    <div class="button-effect toggle-project-favorite" style="width:35px !important"
                                        data-project-housing-id="{{ isset($projectHousingsList[$housingOrder]['squaremeters'][0]) ? $projectHousingsList[$housingOrder]['squaremeters'][0] : '' }}"
                                        data-project-id={{ $project->id }}>
                                        <i class="fa fa-heart-o"></i>
                                    </div>
                                </div>
                                <div class="carousel-inner">

                                    {{-- Kapak Görseli --}}
                                    <div class="item carousel-item active" data-slide-number="0">
                                        <a href="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[$housingOrder]['image[]'] }}"
                                            data-lightbox="project-images">
                                            <img src="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[$housingOrder]['image[]'] }}"
                                                class="img-fluid" alt="slider-listing">
                                        </a>
                                    </div>

                                    {{-- Diğer Görseller --}}
                                    @foreach ($project->images as $key => $housingImage)
                                        <div class="item carousel-item" data-slide-number="{{ $key + 1 }}">
                                            <a href="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $housingImage->image) }}"
                                                data-lightbox="project-images">
                                                <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $housingImage->image) }}"
                                                    class="img-fluid" alt="slider-listing">
                                            </a>
                                        </div>
                                    @endforeach


                                </div>

                                {{-- Küçük Resim Navigasyonu --}}
                                <div class="listingDetailsSliderNav mt-3">
                                    <div class="item active" style="margin: 10px; cursor: pointer">
                                        <a id="carousel-selector-0" data-slide-to="0" data-target="#listingDetailsSlider">
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
                                <nav aria-label="Page navigation example" style="margin-top: 7px">
                                    <ul class="pagination">
                                        <li class="page-item page-item-left"><a class="page-link" href="#"><i
                                                    class="fas fa-angle-left"></i></a></li>
                                        <li class="page-item page-item-middle"><a class="page-link" href="#"></a>
                                        </li>
                                        <li class="page-item page-item-right"><a class="page-link" href="#"><i
                                                    class="fas fa-angle-right"></i></a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>

                </div>
                <aside class="col-md-4  car">
                    <div class="single widget buyBtn">
                        @if (isset($projectHousingsList[$housingOrder]['projected_earnings[]']) ||
                                isset($projectHousingsList[$housingOrder]['ong_kira[]']))
                            <div class="schedule widget-boxed move-mobile-gain mb-30 mobile-show"
                                style="background-color: green "></div>
                        @endif
                        @php
                            $soldOut =
                                ($sold && $sold->status == '2' && $share_sale == '[]') ||
                                ($sold && $sold->status == '2' && empty($share_sale)) ||
                                (isset($sumCartOrderQt[$housingOrder]) &&
                                    $sold &&
                                    $sold->status != '2' &&
                                    $sumCartOrderQt[$housingOrder]['qt_total'] != $number_of_share);

                            $offSale = $off_sale_1 && !$sold;

                            $saleClosed = $sold && $sold->status == '2' && $off_sale_1;

                            $soldAndNotStatus2 =
                                ($sold && $sold->status != '2' && $share_sale == '[]') ||
                                ($sold && $sold->status != '2' && empty($share_sale)) ||
                                (isset($sumCartOrderQt[$housingOrder]) &&
                                    $sold &&
                                    $sold->status != '2' &&
                                    $sumCartOrderQt[$housingOrder]['qt_total'] == $number_of_share);

                            $style = "style='background: #EC2F2E !important; width: 100%; color: White;'";
                            $rezerveStyle = "style='background: orange !important; color: White; width: 100%;'";
                            $satildiStyle = "style='background: #EC2F2E !important; color: White; width: 100%;'";

                            if (
                                ($sold && $sold->status == '0' && (empty($share_sale) || $share_sale == '[]')) ||
                                (isset($share_sale) &&
                                    $share_sale != '[]' &&
                                    isset($sumCartOrderQt[$housingOrder]) &&
                                    $sumCartOrderQt[$housingOrder]['qt_total'] != $number_of_share)
                            ) {
                                $btnStyle = $rezerveStyle;
                            } elseif ($sold && $sold->status == '1') {
                                $btnStyle = $satildiStyle;
                            } else {
                                $btnStyle = $satildiStyle;
                            }
                        @endphp



                        <div class="schedule widget-boxed mt-33 mt-0 widgetBuyButton mb-5">
                            <div class="row buttonDetail" style="align-items:center;width:100%;margin:0 auto">






                                @if (
                                    ($off_sale_2 && Auth::check() && $isUserType2EmlakOfisi && $canAddToProject) ||
                                        ($off_sale_3 && (Auth::check() && ($isUserType2EmlakOfisi || $isUserType1)) && $canAddToProject) ||
                                        (!$canAddToProject && Auth::check()))
                                    <div class="col-md-6 col-6 mobile-action-move p-0">


                                        <span style="width:100%;text-align:center">

                                            @if (!$off_sale_1 && !$sold_check && $share_sale_empty)


                                                @if ($projectDiscountAmount)
                                                    <svg viewBox="0 0 24 24" width="18" height="18"
                                                        stroke="#EC2F2E" stroke-width="2" fill="#EC2F2E"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="css-i6dzq1">
                                                        <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                        <polyline points="17 18 23 18 23 12"></polyline>
                                                    </svg>
                                                    <del
                                                        style="color: #ea2a28!important;font-weight: 700;font-size: 11px;">

                                                        {{ number_format($projectHousingsList[$housingOrder]['price[]'], 0, ',', '.') }}
                                                        ₺
                                                    </del>
                                                    <h6
                                                        style="color: #27bb53 !important; position: relative; top: 4px; font-weight: 700">
                                                        {{ number_format($discounted_price, 0, ',', '.') }}
                                                        ₺
                                                    </h6>
                                                @else
                                                    <h6
                                                        style="color:#274abb; position: relative; top: 4px; font-weight: 700">
                                                        {{ number_format($discounted_price, 0, ',', '.') }}
                                                        ₺
                                                    </h6>
                                                @endif

                                                @if ($projectDiscountAmount)
                                                    <h6 style="color: #27bb53 !important;">(Kampanyalı)</h6>
                                                @endif
                                            @elseif(
                                                (isset($share_sale) &&
                                                    $share_sale != '[]' &&
                                                    isset($sumCartOrderQt[$housingOrder]) &&
                                                    $sumCartOrderQt[$housingOrder]['qt_total'] != $number_of_share) ||
                                                    (isset($share_sale) && $share_sale != '[]' && !isset($sumCartOrderQt[$housingOrder])))
                                                @if (!$off_sale_1)
                                                    @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                        <span class="text-center w-100">
                                                            1 / {{ $number_of_share }} Fiyatı
                                                        </span>
                                                    @endif
                                                    <h6
                                                        style="color: #274abb !important; position: relative; top: 4px; font-weight: 700">
                                                        @if (
                                                            (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0) ||
                                                                (isset($share_sale) && empty($share_sale) && $number_of_share != 0))
                                                            {{ number_format($projectHousingsList[$housingOrder]['price[]'] / $number_of_share, 0, ',', '.') }}
                                                            ₺
                                                        @else
                                                            {{ number_format($projectHousingsList[$housingOrder]['price[]'], 0, ',', '.') }}
                                                            ₺
                                                        @endif
                                                    </h6>
                                                @endif
                                            @endif
                                        </span>
                                        {{-- 
                                        @if (Auth::check() && Auth::user()->id == $project->user_id)
                                            <div class="col-md-12 col-12 p-0 ml-3">
                                                <a data-bs-toggle="modal" data-bs-target="#priceUpdateModal"
                                                    style="color:#007bff !important;cursor: pointer; ">
                                                    Fiyatı Güncelle
                                                </a>
                                            </div>
                                        @endif --}}

                                    </div>
                                @endif

                                <div class="
                                 @if (
                                     ($off_sale_2 && Auth::check() && $isUserType2EmlakOfisi && $canAddToProject) ||
                                         $off_sale_1 ||
                                         $off_sale_4 ||
                                         ($off_sale_3 && (Auth::check() && ($isUserType2EmlakOfisi || $isUserType1)) && $canAddToProject) ||
                                         (!$canAddToProject && Auth::check())) col-md-12 col-12
                                @else
                                    col-md-6 col-6 @endif "
                                    style="display: flex; justify-content: space-between; align-items: center; padding: 0 !important">

                                    @if ($offSale || $saleClosed)
                                        <button class="btn second-btn" {!! $style !!}>
                                            <span class="text">Satışa Kapalı</span>
                                        </button>
                                    @elseif ($soldAndNotStatus2)
                                        <button class="btn second-btn" {!! $btnStyle !!}>
                                            @if ($sold->status == '0' && ($share_sale == '[]' || empty($share_sale)))
                                                <span class="text">Rezerve Edildi</span>
                                            @elseif (
                                                ($sold->status == '1' && ($share_sale == '[]' || empty($share_sale))) ||
                                                    (isset($sumCartOrderQt[$housingOrder]) && $sumCartOrderQt[$housingOrder]['qt_total'] == $number_of_share))
                                                <span class="text">Satıldı</span>
                                            @endif
                                        </button>
                                    @else
                                        @if (
                                            ($off_sale_2 && Auth::check() && $isUserType2EmlakOfisi && $canAddToProject) ||
                                                ($off_sale_3 && (Auth::check() && ($isUserType2EmlakOfisi || $isUserType1)) && $canAddToProject))
                                            <button class="CartBtn second-btn mobileCBtn" data-type='project'
                                                data-project='{{ $project->id }}' style="height: auto !important"
                                                data-id='{{ $housingOrder }}' data-share="{{ $share_sale }}"
                                                data-number-share="{{ $number_of_share }}">
                                                <span class="IconContainer">
                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                </span>
                                                <span class="text">Sepete Ekle</span>
                                            </button>
                                        @elseif (!$canAddToProject && Auth::check())
                                            <a href="{{ route('institutional.project.edit.v2', ['projectSlug' => $project->slug, 'project_id' => $project->id]) }}"
                                                class="second-btn">
                                                <span class="text">İlanı Düzenle</span>
                                            </a>
                                        @elseif ($off_sale_4)
                                            @if (Auth::user())
                                                <button class="first-btn payment-plan-button" data-bs-toggle="modal"
                                                    data-bs-target="#approveProjectModal{{ $housingOrder }}">
                                                    TEKLİF VER
                                                </button>
                                            @else
                                                <a href="{{ route('client.login') }}"
                                                    class="first-btn payment-plan-button">
                                                    TEKLİF VER
                                                </a>
                                            @endif
                                        @endif
                                    @endif



                                    {{-- <div class="button-effect toggle-project-favorite" style="margin-left:13px;width:40px !important"
                                         data-project-housing-id="{{ $projectHousingsList[$housingOrder]['squaremeters[]'] }}" data-project-id={{ $project->id }}>
                                        <i class="fa fa-heart-o"></i>
                                    </div> --}}
                                </div>

                            </div>
                        </div>

                    </div>

                    @if (checkIfUserCanAddToProjectHousings($project->id, $housingOrder))

                        @if (($sold && $sold->status == '2') || !$sold || $off_sale_1)
                            <div class="moveCollection">
                                <div class="add-to-collections-wrapper addCollectionMobile addCollection"
                                    data-type='project' data-id="{{ $housingOrder }}"
                                    data-project="{{ $project->id }}">
                                    <div class="add-to-collection-button-wrapper">
                                        <div class="add-to-collection-button">

                                            <svg width="32" height="32" viewBox="0 0 32 32" fill="e54242"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect width="32" height="32" fill="#e54242" />
                                                <g id="Add Collections-00 (Default)" clip-path="url(#clip0_1750_971)">
                                                    <rect width="1440" height="1577"
                                                        transform="translate(-1100 -1183)" fill="white" />
                                                    <g id="Group 6131">
                                                        <g id="Frame 21409">
                                                            <g id="Group 6385">
                                                                <rect id="Rectangle 4168" x="-8" y="-8" width="228"
                                                                    height="48" rx="8" fill="#ea2a28" />
                                                                <g id="Group 2664">
                                                                    <rect id="Rectangle 316" width="32"
                                                                        height="32" rx="4" fill="#ea2a28" />
                                                                    <g id="Group 72">
                                                                        <path id="Rectangle 12"
                                                                            d="M16.7099 17.2557L16 16.5401L15.2901 17.2557L12 20.5721L12 12C12 10.8954 12.8954 10 14 10H18C19.1046 10 20 10.8954 20 12V20.5721L16.7099 17.2557Z"
                                                                            fill="white" stroke="white"
                                                                            stroke-width="2" />
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
                                        <i class="fa fa-caret-right"></i>
                                    </div>
                                </div>

                                @if ($isSwap == '["Evet"]')
                                    <div class="add-to-swap-wrapper" data-bs-toggle="modal" data-bs-target="#takasModal">
                                        <div class="add-to-collection-button-wrapper">
                                            <div class="add-to-collection-button">

                                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect width="32" height="32" fill="#F0F0F0" />
                                                    <g id="Add Collections-00 (Default)" clip-path="url(#clip0_1750_971)">
                                                        <rect width="1440" height="1577"
                                                            transform="translate(-1100 -1183)" fill="white" />
                                                        <g id="Group 6131">
                                                            <g id="Frame 21409">
                                                                <g id="Group 6385">
                                                                    <rect id="Rectangle 4168" x="-8" y="-8" width="228"
                                                                        height="48" rx="8" fill="#FEF4EB" />
                                                                    <g id="Group 2664">
                                                                        <rect id="Rectangle 316" width="32"
                                                                            height="32" rx="4"
                                                                            fill="#F27A1A" />
                                                                        <g id="Group 72">
                                                                            <path d="M16 11V21M11 16H21" stroke="white"
                                                                                stroke-width="2" stroke-linecap="round" />
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
                                                </svg>

                                                <span class="add-to-collection-button-text">Takas Başvurusu Yap</span>
                                            </div>
                                            <i class="fa fa-caret-right"></i>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="takasModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-body">

                                                    <form action="{{ route('form.kaydet') }}" method="POST"
                                                        id="takasFormu" enctype="multipart/form-data">
                                                        @csrf

                                                        <div class="row">
                                                            <div class="col-md-6 col-12 mb-2">
                                                                <label class="form-label" for="ad">Ad:</label>
                                                                <input class="modal-input" type="text" id="ad"
                                                                    required name="ad">
                                                            </div>

                                                            <div class="col-md-6 col-12 mb-2">
                                                                <label class="form-label"
                                                                    for="soyad">Soyadınız:</label>
                                                                <input class="modal-input" type="text" id="soyad"
                                                                    required name="soyad">
                                                            </div>

                                                            <div class="col-md-6 col-12 mb-2">
                                                                <label class="form-label" for="telefon">Telefon
                                                                    Numaranız:</label>
                                                                <input class="modal-input" type="number" id="telefon"
                                                                    required name="telefon" maxlength="10">
                                                            </div>

                                                            <div class="col-md-6 col-12 mb-2">
                                                                <label class="form-label" for="email">E-mail:</label>
                                                                <input class="modal-input" type="email" id="email"
                                                                    required name="email">
                                                            </div>

                                                            <div class="col-md-6 col-12 mb-2">
                                                                <label class="form-label" for="sehir">Şehir:</label>
                                                                <select class="modal-input" id="sehir" name="sehir"
                                                                    required>
                                                                    <option value="">Şehir Seçiniz</option>
                                                                    @foreach ($cities as $city)
                                                                        <option value="{{ $city->id }}">
                                                                            {{ $city->title }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-md-6 col-12 mb-2">
                                                                <label class="form-label" for="ilce">İlçe:</label>
                                                                <select class="modal-input" id="ilce" name="ilce"
                                                                    required disabled>
                                                                    <option value="">İlçe Seçiniz</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-12 col-12 mb-2">
                                                                <label class="form-label" for="takas_tercihi">Takas
                                                                    Tercihiniz:</label>
                                                                <select class="modal-input" id="takas_tercihi" required
                                                                    name="takas_tercihi">
                                                                    <option value="">Seçiniz</option>
                                                                    <option value="emlak">Emlak</option>
                                                                    <option value="araç">Araç</option>
                                                                    <option value="barter">Barter</option>
                                                                    <option value="diğer">Diğer</option>
                                                                </select>
                                                            </div>


                                                            <div id="digeryse" style="display: none;"
                                                                class="col-md-12 col-12 mb-2">
                                                                <label class="form-label" for="diger_detay">Takas ile
                                                                    ilgili
                                                                    ürün/hizmet detayı:</label>
                                                                <textarea class="modal-input" id="diger_detay" name="diger_detay"></textarea>
                                                            </div>

                                                            <div id="barteryse" style="display: none;"
                                                                class="col-md-12 col-12 mb-2">
                                                                <label class="form-label" for="barter_detay">Lütfen barter
                                                                    durumunuz ile ilgili detaylı bilgileri giriniz:</label>
                                                                <textarea class="modal-input" id="barter_detay" name="barter_detay"></textarea>
                                                            </div>

                                                            <div id="emlakyse" style="display: none;"
                                                                class="col-md-12 col-12 mb-2">
                                                                <label class="form-label" for="emlak_tipi">Emlak
                                                                    Tipi:</label>
                                                                <select class="modal-input" id="emlak_tipi"
                                                                    name="emlak_tipi">
                                                                    <option value="">Seçiniz</option>
                                                                    <option value="konut">Konut</option>
                                                                    <option value="arsa">Arsa</option>
                                                                    <option value="işyeri">İşyeri</option>
                                                                </select>
                                                            </div>

                                                            <div id="konutyse" style="display: none;"
                                                                class="col-md-12 col-12">

                                                                <div class="mb-2">
                                                                    <label class="form-label" for="konut_tipi">Konut
                                                                        Tipi:</label>
                                                                    <select class="modal-input" id="konut_tipi"
                                                                        name="konut_tipi">
                                                                        <option value="">Seçiniz</option>
                                                                        <option value="daire">Daire</option>
                                                                        <option value="villa">Villa</option>
                                                                        <option value="residance">Residance</option>
                                                                        <option value="prefabrik_ev">Prefabrik Ev</option>
                                                                        <option value="çiftlik_evi">Çiftlik Evi</option>
                                                                    </select>

                                                                </div>

                                                                <div class="mb-2">
                                                                    <label for="oda_sayisi">Oda Sayısı</label>
                                                                    <select class="form-select modal-input"
                                                                        aria-label="Default select example"
                                                                        id="oda_sayisi" name="oda_sayisi">
                                                                        <option selected>Seçiniz</option>
                                                                        <option value="1+0">1+0</option>
                                                                        <option value="1.5+1">1.5+1</option>
                                                                        <option value="2+0">2+0</option>
                                                                        <option value="2+1">2+1</option>
                                                                        <option value="2.5+1">2.5+1</option>
                                                                        <option value="3+0">3+0</option>
                                                                        <option value="3+1">3+1</option>
                                                                        <option value="3.5+1">3.5+1</option>
                                                                        <option value="3+2">3+2</option>
                                                                        <option value="3+3">3+3</option>
                                                                        <option value="4+0">4+0</option>
                                                                        <option value="4+1">4+1</option>
                                                                        <option value="4.5+1">4.5+1</option>
                                                                        <option value="4+2">4+2</option>
                                                                        <option value="4+3">4+3</option>
                                                                        <option value="4+4">4+4</option>
                                                                        <option value="5+1">5+1</option>
                                                                        <option value="5.5+1">5.5+1</option>
                                                                        <option value="5+2">5+2</option>
                                                                        <option value="5+3">5+3</option>
                                                                        <option value="5+4">5+4</option>
                                                                        <option value="6+1">6+1</option>
                                                                        <option value="6+2">6+2</option>
                                                                        <option value="6.5+1">6.5+1</option>
                                                                        <option value="6+3">6+3</option>
                                                                        <option value="6+4">6+4</option>
                                                                        <option value="7+1">7+1</option>
                                                                        <option value="7+2">7+2</option>
                                                                        <option value="7+3">7+3</option>
                                                                        <option value="8+1">8+1</option>
                                                                        <option value="8+2">8+2</option>
                                                                        <option value="8+3">8+3</option>
                                                                        <option value="8+4">8+4</option>
                                                                        <option value="9+1">9+1</option>
                                                                        <option value="9+2">9+2</option>
                                                                        <option value="9+3">9+3</option>
                                                                        <option value="9+4">9+4</option>
                                                                        <option value="9+5">9+5</option>
                                                                        <option value="9+6">9+6</option>
                                                                        <option value="10+1">10+1</option>
                                                                        <option value="10+2">10+2</option>
                                                                        <option value="11+1">11+1</option>
                                                                        <option value="12 ve üzeri">12 ve üzeri</option>
                                                                    </select>
                                                                </div>

                                                                <div class="mb-2">
                                                                    <label class="form-label" for="konut_tipi">Konut
                                                                        Yaşı:</label>
                                                                    <select class="modal-input" id="konut_yasi"
                                                                        name="konut_yasi">
                                                                        <option value="">Seçiniz</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5-10">5-10</option>
                                                                        <option value="11-15">11-15</option>
                                                                        <option value="16-20">16-20</option>
                                                                        <option value="20 ve Üzeri">20 ve Üzeri</option>
                                                                    </select>
                                                                </div>

                                                                <input class="modal-input" type="hidden" id="store_id"
                                                                    name="store_id" value="{{ $project->user->id }}">

                                                                <div class="mb-2">
                                                                    <label class="form-label"
                                                                        for="kullanim_durumu">Kullanım
                                                                        Durumu:</label>
                                                                    <select class="modal-input" id="kullanim_durumu"
                                                                        name="kullanim_durumu">
                                                                        <option value="">Seçiniz</option>
                                                                        <option value="kiracılı">Kiracılı</option>
                                                                        <option value="boş">Boş</option>
                                                                        <option value="mülk_sahibi">Mülk Sahibi</option>
                                                                    </select>
                                                                </div>

                                                                <div class="mb-2">

                                                                    <label class="form-label"
                                                                        for="konut_satis_rakami">Düşündüğünüz Satış
                                                                        Rakamı:</label>
                                                                    <input class="modal-input" type="text"
                                                                        id="konut_satis_rakami" name="konut_satis_rakami"
                                                                        min="0">

                                                                </div>

                                                                <div class="mb-2">
                                                                    <label class="form-label" for="tapu_belgesi">Tapu
                                                                        Belgesi
                                                                        Yükleyiniz:</label>
                                                                    <input class="modal-input" type="file"
                                                                        id="tapu_belgesi" name="tapu_belgesi"
                                                                        accept=".pdf,.doc,.docx">
                                                                </div>
                                                            </div>

                                                            <div id="arsayse" style="display: none;"
                                                                class="col-md-12 col-12 mb-2">

                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label class="form-label" for="arsa_il">Arsa
                                                                            İl:</label>
                                                                        <select class="modal-input" id="arsa_il"
                                                                            name="arsa_il">
                                                                            <option value="">Şehir Seçiniz</option>
                                                                            @foreach ($cities as $city)
                                                                                <option value="{{ $city->id }}">
                                                                                    {{ $city->title }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label class="form-label" for="arsa_ilce">Arsa
                                                                            İlçe:</label>
                                                                        <select class="modal-input" id="arsa_ilce"
                                                                            name="arsa_ilce" disabled>
                                                                            <option value="">İlçe Seçiniz</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label class="form-label" for="arsa_mahalle">Arsa
                                                                            Mahalle:</label>
                                                                        <select class="modal-input" id="arsa_mahalle"
                                                                            name="arsa_mahalle" disabled>
                                                                            <option value="">Mahalle Seçiniz</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <label class="form-label" for="ada_parsel">Ada Parsel
                                                                    Bilgisi:</label>
                                                                <input class="modal-input" type="text" id="ada_parsel"
                                                                    name="ada_parsel">

                                                                <label class="form-label" for="imar_durumu">Arsa İmar
                                                                    Durumu:</label>
                                                                <select class="modal-input" id="imar_durumu"
                                                                    name="imar_durumu">
                                                                    <option value="">Seçiniz</option>
                                                                    <option value="villa">Villa</option>
                                                                    <option value="konut">Konut</option>
                                                                    <option value="turizm">Turizm Amaçlı Kiralama</option>
                                                                    <option value="sanayi">Sanayi</option>
                                                                    <option value="ticari">Ticari</option>
                                                                    <option value="bağ_bahçe">Bağ Bahçe</option>
                                                                    <option value="tarla">Tarla</option>
                                                                </select>

                                                                <label class="form-label" for="satis_rakami">Düşündüğünüz
                                                                    Satış Rakamı:</label>
                                                                <input class="modal-input" type="text"
                                                                    id="satis_rakami" name="satis_rakami" min="0">
                                                            </div>

                                                            <div id="aracyse" style="display: none;"
                                                                class="col-md-12 col-12 ">
                                                                <div class="mb-2">

                                                                    <label class="form-label" for="arac_model_yili">Araç
                                                                        Model
                                                                        Yılı:</label>
                                                                    <select class="modal-input" id="arac_model_yili"
                                                                        name="arac_model_yili">
                                                                        <option value="">Model Yılı Seçiniz</option>
                                                                        @for ($year = date('Y'); $year >= 2004; $year--)
                                                                            <option value="{{ $year }}">
                                                                                {{ $year }}</option>
                                                                        @endfor
                                                                    </select>

                                                                </div>


                                                                <div class="mb-2">
                                                                    <label class="form-label" for="arac_markasi">Araç
                                                                        Markası:</label>
                                                                    <select class="modal-input" name="arac_markasi"
                                                                        id="arac_markasi">
                                                                        <option value="">Seçiniz...</option>
                                                                        <option value="Alfa Romeo">Alfa Romeo</option>
                                                                        <option value="Aston Martin">Aston Martin</option>
                                                                        <option value="Audi">Audi</option>
                                                                        <option value="Bentley">Bentley</option>
                                                                        <option value="BMW">BMW</option>
                                                                        <option value="Bugatti">Bugatti</option>
                                                                        <option value="Buick">Buick</option>
                                                                        <option value="Cadillac">Cadillac</option>
                                                                        <option value="Chery">Chery</option>
                                                                        <option value="Chevrolet">Chevrolet</option>
                                                                        <option value="Chrysler">Chrysler</option>
                                                                        <option value="Citroen">Citroen</option>
                                                                        <option value="Cupra">Cupra</option>
                                                                        <option value="Dacia">Dacia</option>
                                                                        <option value="DS Automobiles">DS Automobiles
                                                                        </option>
                                                                        <option value="Daewoo">Daewoo</option>
                                                                        <option value="Daihatsu">Daihatsu</option>
                                                                        <option value="Dodge">Dodge</option>
                                                                        <option value="Ferrari">Ferrari</option>
                                                                        <option value="Fiat">Fiat</option>
                                                                        <option value="Ford">Ford</option>
                                                                        <option value="Geely">Geely</option>
                                                                        <option value="Honda">Honda</option>
                                                                        <option value="Hyundai">Hyundai</option>
                                                                        <option value="Infiniti">Infiniti</option>
                                                                        <option value="Isuzu">Isuzu</option>
                                                                        <option value="Iveco">Iveco</option>
                                                                        <option value="Jaguar">Jaguar</option>
                                                                        <option value="Jeep">Jeep</option>
                                                                        <option value="Kia">Kia</option>
                                                                        <option value="Lada">Lada</option>
                                                                        <option value="Lamborghini">Lamborghini</option>
                                                                        <option value="Lancia">Lancia</option>
                                                                        <option value="Land-rover">Land-rover</option>
                                                                        <option value="Leapmotor">Leapmotor</option>
                                                                        <option value="Lexus">Lexus</option>
                                                                        <option value="Lincoln">Lincoln</option>
                                                                        <option value="Lotus">Lotus</option>
                                                                        <option value="Maserati">Maserati</option>
                                                                        <option value="Mazda">Mazda</option>
                                                                        <option value="McLaren">McLaren</option>
                                                                        <option value="Mercedes-Benz">Mercedes-Benz
                                                                        </option>
                                                                        <option value="MG">MG</option>
                                                                        <option value="Mini">Mini</option>
                                                                        <option value="Mitsubishi">Mitsubishi</option>
                                                                        <option value="Nissan">Nissan</option>
                                                                        <option value="Opel">Opel</option>
                                                                        <option value="Peugeot">Peugeot</option>
                                                                        <option value="Porsche">Porsche</option>
                                                                        <option value="Proton">Proton</option>
                                                                        <option value="Renault">Renault</option>
                                                                        <option value="Rolls Royce">Rolls Royce</option>
                                                                        <option value="Rover">Rover</option>
                                                                        <option value="Saab">Saab</option>
                                                                        <option value="Seat">Seat</option>
                                                                        <option value="Skoda">Skoda</option>
                                                                        <option value="Smart">Smart</option>
                                                                        <option value="Ssangyong">Ssangyong</option>
                                                                        <option value="Subaru">Subaru</option>
                                                                        <option value="Suzuki">Suzuki</option>
                                                                        <option value="Tata">Tata</option>
                                                                        <option value="Tesla">Tesla</option>
                                                                        <option value="Tofaş">Tofaş</option>
                                                                        <option value="Toyota">Toyota</option>
                                                                        <option value="Volkswagen">Volkswagen</option>
                                                                        <option value="Volvo">Volvo</option>
                                                                        <option value="Voyah">Voyah</option>
                                                                        <option value="Yudo">Yudo</option>
                                                                    </select>

                                                                </div>

                                                                <div class="mb-2">
                                                                    <label class="form-label" for="yakit_tipi">Yakıt
                                                                        Tipi:</label>
                                                                    <select class="modal-input" id="yakit_tipi"
                                                                        name="yakit_tipi">
                                                                        <option value="">Seçiniz</option>
                                                                        <option value="benzin">Benzin</option>
                                                                        <option value="dizel">Dizel</option>
                                                                        <option value="lpg">LPG</option>
                                                                        <option value="elektrik">Elektrik</option>
                                                                    </select>
                                                                </div>



                                                                <div class="mb-2">
                                                                    <label class="form-label" for="vites_tipi">Vites
                                                                        Tipi:</label>
                                                                    <select class="modal-input" id="vites_tipi"
                                                                        name="vites_tipi">
                                                                        <option value="">Seçiniz</option>
                                                                        <option value="manuel">Manuel</option>
                                                                        <option value="otomatik">Otomatik</option>
                                                                    </select>
                                                                </div>


                                                                <div class="mb-2">
                                                                    <label class="form-label"
                                                                        for="arac_satis_rakami">Satış
                                                                        Rakamı:</label>
                                                                    <input class="modal-input" type="text"
                                                                        id="arac_satis_rakami" name="arac_satis_rakami"
                                                                        min="0">
                                                                </div>

                                                                <div class="mb-2">
                                                                    <label class="form-label" for="ruhsat_belgesi">Ruhsat
                                                                        Belgesi
                                                                        Yükleyiniz:</label>
                                                                    <input class="modal-input" type="file"
                                                                        id="ruhsat_belgesi" name="ruhsat_belgesi"
                                                                        accept=".pdf,.doc,.docx">
                                                                </div>
                                                            </div>

                                                            <div id="isyeriyse" style="display: none;"
                                                                class="mb-3 col-md-12 col-12">

                                                                <div class="mb-2">

                                                                    <label for="ticari_bilgiler" class="form-label">Ticari
                                                                        ile
                                                                        ilgili Bilgileri Giriniz:</label>
                                                                    <textarea class="modal-input" id="ticari_bilgiler" name="ticari_bilgiler"></textarea>

                                                                </div>

                                                                <div class="mb-2">
                                                                    <label for="isyeri_satis_rakami"
                                                                        class="form-label">Düşündüğünüz Satış
                                                                        Rakamı:</label>
                                                                    <input type="text" class="modal-input"
                                                                        id="isyeri_satis_rakami"
                                                                        name="isyeri_satis_rakami" min="0">
                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="modal-footer" style="justify-content: end !important">
                                                            <button type="submit" class="btn btn-success"
                                                                style="width:150px">Başvur</button>
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal" style="width:150px">Kapat</button>
                                                        </div>


                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endif


                            </div>
                        @endif
                    @endif




                    <div class="mobileMove">
                        <div class="single widget storeInfo">
                            <div class="widget-boxed">
                                <div class="widget-boxed-body pt-0">
                                    <div class="sidebar-widget author-widget2">

                                        <table class="table">
                                            <tr style="border-top: none !important">
                                                <td style="border-top: none !important">
                                                    <span class="det" style="color: #EC2F2E !important;">
                                                        {!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}
                                                        @if ($project->neighbourhood)
                                                            {!! ' / ' . optional($project->neighbourhood)->mahalle_title !!}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    İlan No:
                                                    <span class="det" style="color: #274abb !important;">
                                                        {{ $project->id + 1000000 . '-' . $housingOrder }}

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
                                            @if ($project->user->phone)
                                                <tr>
                                                    <td>
                                                        <span class="autoWidthTr">İş:</span>
                                                        <span class="det">
                                                            <a style="text-decoration: none;color:#274abb;"
                                                                href="tel:{!! $project->user->phone !!}">{!! $project->user->phone !!}</a>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($project->user->mobile_phone)
                                                <tr>
                                                    <td>
                                                        <span class="autoWidthTr">Cep :</span>
                                                        <span class="det">
                                                            <a style="text-decoration: none;color:#274abb;"
                                                                href="tel:{!! $project->user->mobile_phone !!}">{!! $project->user->mobile_phone !!}</a>
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
                                            <tr>
                                                <td>
                                                    Mağaza :
                                                    <span class="det"> <a style="text-decoration: none;color:inherit"
                                                            href="{{ route('institutional.dashboard', ['slug' => Str::slug($project->user->name), 'userID' => $project->user->id]) }}">{!! $project->user->name !!}</a></span>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td>
                                                    <span class="autoWidthTr">Ada:</span>
                                                    <span class="det"
                                                        style="color: black;">{{ $project->island ? $project->island : 'Belirtilmedi' }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="autoWidthTr">Parsel:</span>
                                                    <span class="det"
                                                        style="color: black;">{{ $project->parcel ? $project->parcel : 'Belirtilmedi' }}</span>
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
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>

            <!-- Fiyat Güncelleme Modal -->
            <div class="modal fade" id="priceUpdateModal" tabindex="-1" role="dialog"
                aria-labelledby="priceUpdateModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="priceUpdateModalLabel">Fiyat Güncelleme</h5>
                            <button type="button" class="close priceUpdateModalLabelClose" data-bs-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Fiyatı güncellerseniz projeniz onaya düşecektir.</p>
                            <form id="price-update-form" method="POST"
                                action="{{ route('project.update.price', ['id' => $project->id, 'room' => $housingOrder]) }}"
                                onsubmit="return false;">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="newPrice" class="q-label">Yeni Fiyat: </label><br>
                                    <input type="text" class="modal-input" id="newPrice" name="new_price"
                                        placeholder="Yeni Fiyat">
                                </div>
                                <button type="button" class="btn btn-primary"
                                    id="confirm-price-update">Güncelle</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Onay Modal -->
            <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                aria-labelledby="confirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationModalLabel">Fiyatı Onayla</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p id="confirmation-message"></p>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                            <button type="button" class="btn btn-primary" id="confirm-update-button">Evet,
                                Güncelle</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.getElementById('confirm-price-update').addEventListener('click', function() {
                    var newPrice = document.getElementById('newPrice').value;
                    document.getElementById('confirmation-message').innerText = 'Fiyatı ' + newPrice +
                        ' ₺ olarak güncellemek istediğinizden emin misiniz?';

                    // Close the price update modal
                    document.querySelector(".priceUpdateModalLabelClose").click();

                    // Open the confirmation modal
                    var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
                    confirmationModal.show();
                });

                document.getElementById('confirm-update-button').addEventListener('click', function() {
                    document.getElementById('price-update-form').onsubmit = function() {
                        return true;
                    };
                    document.getElementById('price-update-form').submit();
                });
            </script>

            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link  active  " id="contact-tab" data-bs-toggle="tab"
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
                                data-sold="{{ ($sold && $sold->status != 2 && $share_sale_empty) || (!$share_sale_empty && isset($sumCartOrderQt[$housingOrder]) && $sumCartOrderQt[$housingOrder]['qt_total'] == $number_of_share) || ((!$sold && isset($projectHousingsList[$housingOrder]['off_sale']) && $off_sale_1) || $offSale || $saleClosed) ? 1 : 0 }}"
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
                                                        {{ $project->id + 1000000 . '-' . $housingOrder }}
                                                    </span>
                                                </td>
                                            </tr>

                                            @foreach ($projectHousingSetting as $housingSetting)
                                                @php
                                                    $isArrayCheck = $housingSetting->is_array;
                                                    $value = '';

                                                    // Filtreleme: Eğer mevcutsa ve 'housingOrder' ile eşleşiyorsa veriyi al
                                                    if (isset($projectHousing[$housingSetting->column_name . '[]'])) {
                                                        $valueArray = json_decode(
                                                            $projectHousing[$housingSetting->column_name . '[]'][
                                                                'value'
                                                            ] ?? null,
                                                            true,
                                                        );

                                                        if ($isArrayCheck && isset($valueArray)) {
                                                            $value = implodeData($valueArray);
                                                        } elseif ($housingSetting->is_parent_table) {
                                                            $value = $project[$housingSetting->column_name] ?? null;
                                                        } elseif ($project->roomInfo) {
                                                            foreach ($project->roomInfo as $roomInfo) {
                                                                // 'room_order' kontrolü yaparak doğru veriyi çek
                                                                if (
                                                                    $roomInfo['name'] ===
                                                                        $housingSetting->column_name . '[]' &&
                                                                    $roomInfo['room_order'] == $housingOrder
                                                                ) {
                                                                    $decodedValue = json_decode(
                                                                        $roomInfo['value'],
                                                                        true,
                                                                    );
                                                                    $value = is_array($decodedValue)
                                                                        ? (isset($decodedValue[0])
                                                                            ? $decodedValue[0]
                                                                            : '')
                                                                        : $decodedValue;
                                                                    $value =
                                                                        $value == 'on'
                                                                            ? 'Evet'
                                                                            : ($value == 'off'
                                                                                ? 'Hayır'
                                                                                : $value);
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    }
                                                @endphp

                                                @if (
                                                    !$isArrayCheck &&
                                                        isset($value) &&
                                                        $value !== '' &&
                                                        !in_array($housingSetting->label, [
                                                            'Kapak Resmi',
                                                            'Taksitli Satış',
                                                            'Fiyat',
                                                            'Seçenekler',
                                                            'Acil Satılık',
                                                            'İndirim Oranı %',
                                                            'Yıldız Sayısı',
                                                            'Yapının Durumu',
                                                            'Peşinat',
                                                            'İlan Başlığı',
                                                            'Günlük Fiyat',
                                                            'Peşin Fiyat',
                                                            'Taksitli Toplam Fiyat',
                                                        ]))
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
                            style="border: none !important;box-shadow: none !important; padding: 0 !important"
                            role="tabpanel" aria-labelledby="contact-tab">

                            @if ($project->have_blocks == 1)
                                <div class="ui-elements properties-right list featured portfolio blog pb-5 bg-white">
                                    <div class="container p-0">

                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 ">
                                                <div class="tabbed-content button-tabs">
                                                    <ul class="tabs">
                                                        @foreach ($project->blocks as $key => $block)
                                                            <li class="nav-item-block {{ $key == $blockIndex ? ' active' : '' }}"
                                                                role="presentation"
                                                                id="contentblocktab-{{ $block['id'] }}"
                                                                onclick="changeTabContent('{{ $block['id'] }}',{{ $key }})">
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
                                                                $blockName = $block['block_name'];

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
                                                                    <div class="row project-filter-reverse blog-pots"
                                                                        id="project-room{{ $blockKey }}">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mobile-show">
                                                                <div class=""
                                                                    id="project-room-mobile{{ $blockKey }}">

                                                                </div>
                                                            </div>
                                                            <div class="ajax-load" style="display: none;">
                                                                Yükleniyor...
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
                                        <div class="container p-0">
                                            @php
                                                $blockName = null;
                                            @endphp

                                            <div class="row project-filter-reverse blog-pots w-100 m-auto"
                                                id="project-room">
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
                                                        :blockStart="0" :towns="$towns" :cities="$cities"
                                                        :key="$key" :statusSlug="$statusSlug" :blockName="$blockName"
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
                                        <div class="container p-0">
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
                                                        :blockStart="0" :blockName="$blockName" :project="$project"
                                                        :allCounts="$allCounts" :statusSlug="$statusSlug" :key="$key"
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



                                </div>
                            @endif

                        </div>
                        <div class="tab-pane fad blog-info details mb-30" id="payment" role="tabpanel"
                            aria-labelledby="payment">
                            @php
                                $offSaleValue = $projectHousingsList[$housingOrder]['off_sale[]'];
                                $soldStatus = optional($sold)->status;
                            @endphp
                            @if (!$off_sale_1)
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
                            <iframe width="100%" height="100%" frameborder="0" style="border:0;"
                                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&q={{ explode(',', $project->location)[0] }},{{ explode(',', $project->location)[1] }}"
                                allowfullscreen="">
                            </iframe>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&callback=initMap"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        document.getElementById('newPrice').addEventListener('input', function(e) {
            var value = e.target.value;
            // Sadece rakamları ve virgülü tut
            value = value.replace(/[^0-9,]/g, '');

            // Noktaları ve virgülü ayarlama
            if (value.includes(',')) {
                var parts = value.split(',');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                value = parts.join(',');
            } else {
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            e.target.value = value;
        });
        var navLinks = document.querySelectorAll('.nav-link');

        // Her bir nav-link öğesi için bir event listener ekleyin
        navLinks.forEach(function(navLink) {
            navLink.addEventListener('click', function() {
                // Tüm nav-link öğelerinden active sınıfını kaldırın
                navLinks.forEach(function(link) {
                    link.classList.remove('active');
                });

                // Tıklanan öğeye active sınıfını ekleyin
                this.classList.add('active');
            });
        });
    </script>

    </script>
    <script>
        $('.citySelect').change(function() {
            var selectedCity = $(this).val();

            $.ajax({
                type: 'GET',
                url: '/get-counties/' + selectedCity,
                success: function(data) {
                    var countySelect = $('.countySelect');
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
        document.getElementById('price').addEventListener('input', function(e) {
            var value = e.target.value;
            // Sadece rakamları ve virgülü tut
            value = value.replace(/[^0-9,]/g, '');

            // Noktaları ve virgülü ayarlama
            if (value.includes(',')) {
                var parts = value.split(',');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                value = parts.join(',');
            } else {
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            e.target.value = value;
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
                zoom: 16,
                gestureHandling: 'greedy'
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
                zoom: 12,
                gestureHandling: 'greedy'
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
            var moveGain = $(".move-gain").html();

            $("#listingDetailsSlider").after(mobileHour);
            $(".mobileHourDiv").after(mobileMove);
            $(".mobile-action").html(mobileActionMove);


            $(".mobileMovePrice").remove();
            $(".move-gain").remove();

            $(".mobile-action-move").html(mobileMovePrice);
            $(".mobileMove").remove();
            $(".mobileHour").remove();
            var buyBtn = $(".buyBtn").html();
            var moveCollection = $(".moveCollection").html();
            $("#listingDetailsSlider").after(buyBtn);
            $(".widgetBuyButton").after(moveCollection);
            $(".move-mobile-gain").html(moveGain);
            $(".buyBtn").css("display", "none");
            $(".moveCollection").css("display", "none");


        };

        $('.project-housing-pagination li').click(function() {
            $('.loading-full').removeClass('d-none')
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
            slidesToScroll: 5,
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

        // Sayfa yüklendiğinde
        $(document).ready(function() {
            updateIndex(); // Index değerini güncelle
        });

        // Slayt geçiş işlemi tamamlandığında
        $('#listingDetailsSlider').on('slid.bs.carousel', function() {
            updateIndex();
        });

        // Index değerini güncelleyen fonksiyon
        function updateIndex() {
            var totalSlides = $('#listingDetailsSlider .carousel-item').length; // Toplam slayt sayısını al
            var index = $('#listingDetailsSlider .carousel-item.active').index(); // Aktif slaydın indeksini al
            $('.pagination .page-item-middle .page-link').text((index + 1) + '/' +
                totalSlides); // Ortadaki li etiketinin metnini güncelle
        }

        if (window.innerWidth <= 768) {
            // Sol ok tuşuna tıklandığında
            $('.pagination .page-item-left').on('click', function(event) {
                event.preventDefault();
                $('#listingDetailsSlider').carousel('prev');
                var index = $('#listingDetailsSlider .carousel-item.active').attr('data-slide-number');
                // $('.pagination .page-item-middle .page-link').text(index);
                $('.listingDetailsSliderNav').slick('slickGoTo', index);
                var smallIndex = $('#listingDetailsSlider .active').data('slide-number');

            });

            // Sağ ok tuşuna tıklandığında
            $('.pagination .page-item-right').on('click', function(event) {
                event.preventDefault(); // Sayfanın yukarı gitmesini engelle
                $('#listingDetailsSlider').carousel('next');
                var index = $('#listingDetailsSlider .carousel-item.active').attr('data-slide-number');
                // $('.pagination .page-item-middle .page-link').text(index);
                $('.listingDetailsSliderNav').slick('slickGoTo', index);
                var smallIndex = $('#listingDetailsSlider .active').data('slide-number');
            });
        }


        var currentSlideIndex = 0;

        // Sağ ok tuşuna tıklandığında
        $('.pagination .page-item-right').on('click', function(event) {
            event.preventDefault(); // Sayfanın yukarı gitmesini engelle
            var totalItems = $('#listingDetailsSlider .carousel-item').length + 1; // Toplam slayt sayısını al
            var remainingItems = totalItems - (currentSlideIndex + 1) * 5; // Kalan slayt sayısını hesapla
            console.log(totalItems)
            console.log(remainingItems)
            if (remainingItems >= 5) {
                currentSlideIndex++;
                $('.listingDetailsSliderNav').slick('slickGoTo', currentSlideIndex *
                    5); // Bir sonraki beşli kümeye git
            } else {
                $('.listingDetailsSliderNav').slick('slickNext'); // Son beşli kümeye git
            }
        });

        // Sol ok tuşuna tıklandığında
        $('.pagination .page-item-left').on('click', function(event) {
            event.preventDefault();
            if (currentSlideIndex > 0) {
                currentSlideIndex--;
                $('.listingDetailsSliderNav').slick('slickGoTo', currentSlideIndex * 5); // Önceki beşli kümeye git
            } else {
                $('.listingDetailsSliderNav').slick('slickPrev'); // Son beşli kümeye git

            }
        });



        $('.listingDetailsSliderNav').on('click', 'a', function() {
            var index2 = $(this).attr('data-slide-to');
            $('#listingDetailsSlider').carousel(parseInt(index2));
        });

        // Mobil cihazlarda kaydırma işlevselliği
        $('#listingDetailsSlider').on('touchstart', function(event) {
            var xClick = event.originalEvent.touches[0].pageX;
            $(this).one('touchmove', function(event) {
                var xMove = event.originalEvent.touches[0].pageX;
                var sensitivityInPx = 5;

                if (Math.floor(xClick - xMove) > sensitivityInPx) {
                    $(this).carousel('next');
                } else if (Math.floor(xClick - xMove) < -sensitivityInPx) {
                    $(this).carousel('prev');
                }
            });
        });

        // Mobil cihazlarda dokunmatik olayları devre dışı bırakma
        $('#listingDetailsSlider').on('touchend', function() {
            $(this).off('touchmove');
        });
        // Büyük görsel kaydığında küçük görselleri de eşleştirme
        // $('#listingDetailsSlider').on('slid.bs.carousel', function() {
        //     var index = $('#listingDetailsSlider .carousel-item.active').attr('data-slide-number');
        //     // $('.pagination .page-item-middle .page-link').text(index);
        //     $('.listingDetailsSliderNav').slick('slickGoTo', index);
        //     var smallIndex = $('#listingDetailsSlider .active').data('slide-number');

        //     console.log("Büyük Görsel Data Slide Number: ", index);
        //     console.log("Küçük Görsel Index: ", smallIndex);
        // });

        $(document).ready(function() {
            // Sayfa yüklendiğinde, öncelikle $active değişkenini kontrol ediyoruz
            if ("{{ isset($active) ? $active : '' }}") {
                // Eğer $active varsa, payment-plan-tab butonuna tıklanmış gibi yaparak işlem yapıyoruz
                $('#payment-tab').click();
            }
        });

        $('.payment-plan-tab').click(function() {
            showLoadingSpinner();

            var order = $(this).attr('order');
            var soldStatus = $(this).data('sold');
            var block = $(this).data("block") ? $(this).data("block") : " ";
            var paymentOrder = $(this).data("payment-order") ? $(this).data("payment-order") : $(this).attr(
                'order');


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
                    text: 'Bu ilan için ödeme detay bilgisi gösterilemiyor.',
                    confirmButtonText: 'Kapat'
                });
                var html = "<span>Bu ilan için ödeme detay bilgisi gösterilemiyor.</span>";
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
                                    "' style='background-color: #EEE !important;' ><th style='text-align:center' class='paymentTableTitle' colspan=" +
                                    (4 + parseInt(getDataJS(response, "pay-dec-count" + orderHousing,
                                        response.room_info[i].room_order), 10)) + " >" + response
                                    .project_title +
                                    " Projesinde " + block + " " + paymentOrder +
                                    " No'lu İlan Ödeme Planı</th></tr>";


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

                                            var projectedEarningsData = "";
                                            var ongKiraData = "";

                                            var projectedEarnings = getDataJS(response,
                                                "projected_earnings[]", response.room_info[i]
                                                .room_order);

                                            var ongKira = getDataJS(response,
                                                "ong_kira[]", response.room_info[i]
                                                .room_order);
                                            // var projectedEarnings = 10;
                                            var svgCode =
                                                '<svg viewBox="0 0 24 24" width="21" height="21" stroke="green" stroke-width="2" fill="green" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 7 23 12"></polyline></svg>';
                                            var projectedEarningsHTML = projectedEarnings ? svgCode +
                                                "<strong style='color:#28a745'> Öngörülen Yıllık Kazanç:</strong>" +
                                                "<span style='color:#28a745'> %" + projectedEarnings +
                                                "</span>" : "";

                                            var ongKiraHTML = ongKira ? svgCode +
                                                "<strong style='color:#28a745'> Öngörülen Kira Getirisi:</strong>" +
                                                "<span style='color:#28a745'>" + ongKira +
                                                " TL</span>" : "";

                                            projectedEarningsData += projectedEarningsHTML;
                                            ongKiraData += ongKiraHTML;

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


                                            if (ongKiraData) {
                                                html += "<th></th>";

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

                                                if (projectedEarningsData) {
                                                    html += "<td>" + projectedEarningsData + "</td>";

                                                }
                                                if (ongKiraData) {
                                                    html += "<td>" + ongKiraData + "</td>";

                                                }
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


                                                        if (ongKiraData) {
                                                            html += "<td></td>";

                                                        }
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
        var itemsPerPage = 10;
        var isLoading = false; // Kontrol flag'ı ekledik
        var currentBlock = 0;
        var currentPage = 0;
        var maxPages = null;

        $(document).ready(function() {
            // Önceki slayta geçme
            $('.carousel-control-prev').click(function() {
                $('#listingDetailsSlider').carousel('prev');
            });

            // Sonraki slayta geçme
            $('.carousel-control-next').click(function() {
                $('#listingDetailsSlider').carousel('next');
            });

            // Mobil cihazlarda kaydırma işlevselliği
            $('#listingDetailsSlider').on('touchstart', function(event) {
                var xClick = event.originalEvent.touches[0].pageX;
                $(this).one('touchmove', function(event) {
                    var xMove = event.originalEvent.touches[0].pageX;
                    var sensitivityInPx = 5;

                    if (Math.floor(xClick - xMove) > sensitivityInPx) {
                        $(this).carousel('next');
                    } else if (Math.floor(xClick - xMove) < -sensitivityInPx) {
                        $(this).carousel('prev');
                    }
                });
            });

            // Mobil cihazlarda dokunmatik olayları devre dışı bırakma
            $('#listingDetailsSlider').on('touchend', function() {
                $(this).off('touchmove');
            });
        });
        $(document).ready(function() {

            @if ($project->have_blocks)
                currentPage = 0;
                var projectBlocks = @json($project->blocks);
                maxPages = Math.ceil(projectBlocks[currentBlock]["housing_count"] / itemsPerPage);

                if (window.innerWidth >= 768) {
                    loadMoreDataBlock(0);
                } else {
                    loadMoreDataBlockMobil(0);
                }
                $(window).scroll(function() {
                    var projectRoom = $('#project-room' + currentBlock);
                    var projectRoomMobile = $('#project-room-mobile' + currentBlock);

                    // Web
                    if ($(window).scrollTop() + $(window).height() >= projectRoom.offset().top + projectRoom
                        .outerHeight() - 50 && !isLoading && window.innerWidth >= 768) {
                        if (currentPage < maxPages) {
                            isLoading = true; // Yüklenme başladığında flag'ı true olarak ayarla
                            currentPage++;
                            loadMoreDataBlock(currentPage);
                        }
                    }

                    // Mobil
                    if ($(window).scrollTop() + $(window).height() >= projectRoomMobile.offset().top +
                        projectRoomMobile.outerHeight() - 50 && !isLoading && window.innerWidth < 768) {
                        if (currentPage < maxPages) {
                            isLoading = true; // Yüklenme başladığında flag'ı true olarak ayarla
                            currentPage++;
                            loadMoreDataBlockMobil(currentPage);
                        }
                    }
                });
            @else

                currentPage = 1;
                maxPages = Math.ceil({{ $project->room_count }} / itemsPerPage);

                $(window).scroll(function() {
                    var projectRoom = $('#project-room');
                    var projectRoomMobile = $('#project-room-mobile');

                    // Web
                    if ($(window).scrollTop() + $(window).height() >= projectRoom.offset().top + projectRoom
                        .outerHeight() - 50 && !isLoading && window.innerWidth >= 768) {
                        if (currentPage < maxPages) {
                            isLoading = true; // Yüklenme başladığında flag'ı true olarak ayarla
                            currentPage++;
                            loadMoreData(currentPage);
                        }
                    }

                    // Mobil
                    if ($(window).scrollTop() + $(window).height() >= projectRoomMobile.offset().top +
                        projectRoomMobile.outerHeight() - 50 && !isLoading && window.innerWidth < 768) {
                        if (currentPage < maxPages) {
                            isLoading = true; // Yüklenme başladığında flag'ı true olarak ayarla
                            currentPage++;
                            loadMoreDataMobile(currentPage);
                        }
                    }
                });
            @endif
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

        function loadMoreDataBlock(page) {
            $.ajax({
                url: "{{ url('/load-more-rooms-block') }}/{{ $project->id }}/" + currentBlock + "/" + page,
                type: 'get',
                beforeSend: function() {
                    $('.ajax-load').show();
                },
                success: function(response) {
                    $('#project-room' + currentBlock).append(response);
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

        function loadMoreDataBlockMobil(page) {
            $.ajax({
                url: "{{ url('/load-more-rooms-block-mobile') }}/{{ $project->id }}/" + currentBlock + "/" +
                    page,
                type: 'get',
                beforeSend: function() {
                    $('.ajax-load').show();
                },
                success: function(response) {
                    console.log($('#project-room-mobile' + currentBlock));
                    $('#project-room-mobile' + currentBlock).append(response);
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

        function changeTabContent(tabName, key) {
            currentPage = 0;
            currentBlock = key;


            if (window.innerWidth >= 768) {
                loadMoreDataBlock(0);
                $('#project-room' + currentBlock).html("");
            } else {
                loadMoreDataBlockMobil(0);
                $('#project-room-mobile' + currentBlock).html("");
            }

            projectBlocks = @json($project->blocks);
            maxPages = Math.ceil(projectBlocks[key]["housing_count"] / itemsPerPage);

            document.querySelectorAll('.nav-item-block').forEach(function(content) {
                content.classList.remove('active');
            });
            document.querySelectorAll('.tab-content-block').forEach(function(content) {
                content.classList.remove('active');
            });
            document.getElementById('contentblock-' + tabName).classList.add('active');
            document.getElementById('contentblocktab-' + tabName).classList.add('active');



            var block = document.getElementById('contentblock-' + tabName).dataset.blockName;

            var blockIndex = $('#contentblock-' + tabName).index() - 1;
            var startIndex = 0;
            var endIndex = 12;

        }
        $(document).ready(function() {
            $("#telefon").on("input blur", function() {
                var phoneNumber = $(this).val();
                var pattern = /^5[0-9]\d{8}$/;

                if (!pattern.test(phoneNumber)) {
                    $("#error_message").text("Lütfen geçerli bir telefon numarası giriniz.");
                } else {
                    $("#error_message").text("");
                }
                // Kullanıcı 10 haneden fazla veri girdiğinde bu kontrol edilir
                $('#telefon').on('keypress', function(e) {
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

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
        $(document).ready(function() {
            // jQuery Validation eklentisini form elemanlarına uygula
            $('#takasFormu').validate({
                // Türkçe hata mesajlarını tanımla
                messages: {
                    ad: {
                        required: "Lütfen adınızı girin."
                    },
                    soyad: {
                        required: "Lütfen soyadınızı girin."
                    },
                    telefon: {
                        required: "Lütfen telefon numaranızı girin."
                    },
                    email: {
                        required: "Lütfen e-posta adresinizi girin.",
                        email: "Lütfen geçerli bir e-posta adresi girin."
                    },
                    sehir: {
                        required: "Lütfen bir şehir seçin."
                    },
                    ilce: {
                        required: "Lütfen bir ilçe seçin."
                    },
                    takas_tercihi: {
                        required: "Lütfen takas tercihinizi belirtin."
                    }
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#takasFormu').submit(function(e) {
                var isEmpty = false;

                // Emlak seçildiyse, ilgili alanların doldurulma zorunluluğunu kontrol et
                if ($('#takas_tercihi').val() === 'emlak') {
                    var emlakTipi = $('#emlak_tipi').val();
                    if (emlakTipi === 'konut' || emlakTipi === 'arsa') {
                        var requiredFields = [];
                        if (emlakTipi === 'konut') {
                            requiredFields = ['konut_satis_rakami', 'kullanim_durumu', 'konut_yasi',
                                'oda_sayisi', 'konut_tipi'
                            ];
                        } else if (emlakTipi === 'arsa') {
                            requiredFields = ['arsa_il', 'arsa_ilce', 'arsa_mahalle', 'ada_parsel',
                                'imar_durumu', 'satis_rakami'
                            ];
                        }
                    } else if (emlakTipi === 'işyeri') {
                        requiredFields = ['ticari_bilgiler', 'isyeri_satis_rakami'];
                    }

                    for (var i = 0; i < requiredFields.length; i++) {
                        var field = $('#' + requiredFields[i]);
                        if (field.val().trim() === '') {
                            isEmpty = true;
                            field.addClass('error');
                        } else {
                            field.removeClass('error');
                        }
                    }
                }

                // Araç seçildiyse, ilgili alanların doldurulma zorunluluğunu kontrol et
                if ($('#takas_tercihi').val() === 'araç') {
                    var requiredFields = ['arac_model_yili', 'arac_markasi', 'yakit_tipi', 'vites_tipi',
                        'arac_satis_rakami'
                    ];

                    for (var i = 0; i < requiredFields.length; i++) {
                        var field = $('#' + requiredFields[i]);
                        if (field.val().trim() === '') {
                            isEmpty = true;
                            field.addClass('error');
                        } else {
                            field.removeClass('error');
                        }
                    }
                }


                // Barter veya Diğer seçildiyse, ilgili alanların boş olup olmadığını kontrol et
                if ($('#takas_tercihi').val() === 'barter' || $('#takas_tercihi').val() === 'diğer') {
                    $('.conditional-fields:visible').find('.modal-input').each(function() {
                        if ($(this).val().trim() === '') {
                            isEmpty = true;
                            $(this).addClass('error');
                        } else {
                            $(this).removeClass('error');
                        }
                    });
                }

                if (isEmpty) {
                    e.preventDefault();
                    alert('Tüm zorunlu alanları doldurunuz!');
                }

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#sehir').change(function() {
                var cityId = $(this).val();
                console.log(cityId)
                if (cityId) {
                    $.ajax({
                        url: '{{ route('get-districts', ':city_id') }}'.replace(':city_id',
                            cityId),
                        type: 'GET',
                        data: {
                            city_id: cityId
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data)
                            $('#ilce').empty().prop('disabled', false);
                            $.each(data, function(index, district) {
                                $('#ilce').append('<option value="' + district
                                    .ilce_key + '">' + district.ilce_title +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#ilce').empty().prop('disabled', true);
                }
            });

            $('#arsa_il').change(function() {
                var cityId = $(this).val();
                console.log(cityId)
                if (cityId) {
                    $.ajax({
                        url: '{{ route('get-districts', ':city_id') }}'.replace(':city_id',
                            cityId),
                        type: 'GET',
                        data: {
                            city_id: cityId
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data)
                            $('#arsa_ilce').empty().prop('disabled', false);
                            $.each(data, function(index, district) {
                                $('#arsa_ilce').append('<option value="' + district
                                    .ilce_key + '">' + district.ilce_title +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#ilce').empty().prop('disabled', true);
                }
            });



            // İlçe seçildiğinde mahallelerin yüklenmesi
            $('#arsa_ilce').change(function() {
                var districtId = $(this).val();
                console.log(districtId)
                if (districtId) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('get-neighborhoods', ['districtId' => '__districtId__']) }}"
                            .replace('__districtId__', districtId),
                        success: function(data) {
                            console.log(data)
                            if (data) {
                                $('#arsa_mahalle').html(
                                    '<option value="">Mahalle Seçiniz</option>');
                                $.each(data, function(index, neighborhoods) {
                                    $('#arsa_mahalle').append('<option value="' +
                                        neighborhoods.mahalle_id + '">' +
                                        neighborhoods.mahalle_title + '</option>');
                                });
                                $('#arsa_mahalle').prop('disabled', false);
                            } else {
                                $('#arsa_mahalle').html(
                                    '<option value="">Mahalle bulunamadı</option>');
                                $('#arsa_mahalle').prop('disabled', true);
                            }
                        }
                    });
                } else {
                    $('#arsa_mahalle').html('<option value="">Mahalle Seçiniz</option>');
                    $('#arsa_mahalle').prop('disabled', true);
                }
            });
        });
    </script>

    <script>
        // Price inputlarının istenilen biçimde gösterilmesini sağlayan jQuery kodu
        $(document).ready(function() {
            // Price inputlarının seçimi
            $('input[type="text"][name*="_rakami"]').on('input', function() {
                // Girilen değer
                var value = $(this).val().replace(/[^\d,]/g, ''); // Sadece rakamlar ve virgülü kabul et
                // Değerin binlik ayraçları ile formatlanması
                var formattedValue = addCommas(value);
                // Input alanına formatlanmış değerin eklenmesi
                $(this).val(formattedValue);
            });

            // Girilen değeri binlik ayraçları ile formatlayan fonksiyon
            function addCommas(num) {
                // Virgül ve nokta içeren bir regex paterni
                var pattern = /(\d)(?=(\d{3})+(?!\d))/g;
                // Değerdeki noktayı virgüle dönüştürme
                num = num.replace('.', ',');
                // Değeri binlik ayraçlarını ekleyerek formatlama
                return num.toString().replace(pattern, '$1.');
            }
        });
    </script>
    <script>
        document.getElementById('takas_tercihi').addEventListener('change', function() {
            var digerDiv = document.getElementById('digeryse');
            var barterDiv = document.getElementById('barteryse');
            var emlakDiv = document.getElementById('emlakyse');
            var aracDiv = document.getElementById('aracyse');
            var konutDiv = document.getElementById('konutyse');
            var arsaDiv = document.getElementById('arsayse');
            var isyeriDiv = document.getElementById('isyeriyse');

            if (this.value === 'diğer') {
                digerDiv.style.display = 'block';
                barterDiv.style.display = 'none';
                emlakDiv.style.display = 'none';
                aracDiv.style.display = 'none';
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'none';
            } else if (this.value === 'emlak') {
                digerDiv.style.display = 'none';
                barterDiv.style.display = 'none';
                emlakDiv.style.display = 'block';
                aracDiv.style.display = 'none';
            } else if (this.value === 'araç') {
                digerDiv.style.display = 'none';
                barterDiv.style.display = 'none';
                emlakDiv.style.display = 'none';
                aracDiv.style.display = 'block';
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'none';
            } else if (this.value === 'barter') {
                digerDiv.style.display = 'none';
                barterDiv.style.display = 'block';
                emlakDiv.style.display = 'none';
                aracDiv.style.display = 'none';
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'none';
            } else {
                digerDiv.style.display = 'none';
                emlakDiv.style.display = 'none';
                barterDiv.style.display = 'none';
                aracDiv.style.display = 'none';
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'none';
            }
        });

        document.getElementById('emlak_tipi').addEventListener('change', function() {
            var konutDiv = document.getElementById('konutyse');
            var arsaDiv = document.getElementById('arsayse');
            var isyeriDiv = document.getElementById('isyeriyse');

            if (this.value === 'konut') {
                konutDiv.style.display = 'block';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'none';
            } else if (this.value === 'arsa') {
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'block';
                isyeriDiv.style.display = 'none';
            } else if (this.value === 'işyeri') {
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'block';
            } else {
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'none';
            }
        });

        $(document).on("change", ".citySelect2", function() {
            var selectedCity = $(this).val();
            $.ajax({
                type: 'GET',
                url: '/get-counties/' + selectedCity,
                success: function(data) {
                    var countySelect = $('.countySelect');
                    countySelect.empty();
                    countySelect.append('<option value="">İlçe Seçiniz</option>');
                    $.each(data.counties, function(index, county) {
                        countySelect.append('<option value="' + county.ilce_key +
                            '">' + county
                            .ilce_title +
                            '</option>');
                    });
                }
            });
        });
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('css/project-housing.css') }}">
    <style>
        #ad-error,
        #soyad-error,
        #email-error,
        #telefon-error,
        #sehir-error,
        #takas_tercihi-error {
            font-size: 10px !important;
        }

        .error-message {
            color: #e54242;
            font-weight: bold;
            margin-left: 11px !important;
            margin-top: 11px !important;
        }

        .mobile-action-move {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            justify-content: space-evenly;
        }

        .error-message {
            color: #e54242;
            font-size: 11px;
        }

        .success-message {
            color: green;
            font-size: 11px;
        }

        .inner-pages .form-control {
            padding: 0 0.3rem !important
        }

        .modal-input {
            display: block;
            width: 100%;
            height: 38px !important;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 2.0;
            /* background-color: #fff; */
            /* background-clip: padding-box; */
            border: 1px solid #eee;
            /* border-radius: .35rem; */
            /* box-shadow: 0 0 8px rgba(0, 0, 0, 0.07); */
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .modal-input:focus {
            color: #495057;
            background-color: #fff;
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .25);
        }

        .favorite-move {
            position: absolute;
            z-index: 9;
            margin-top: 20px;
            right: 40px;
        }

        .gainStyle strong,
        .gainStyle span {
            color: green
        }

        .gainStyle svg {
            stroke: green
        }

        @media (max-width: 768px) {
            .favorite-move {

                margin-top: 15px;
                right: 15px;
            }

            .gainStyle strong,
            .gainStyle span {
                color: white
            }

            .gainStyle svg {
                stroke: white
            }

            .add-to-swap-wrapper {
                margin-bottom: 30px !important;
            }
        }
    </style>
@endsection
