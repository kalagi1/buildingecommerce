<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    @if (isset($pageInfo))
        <meta name="keywords" content="{{ $pageInfo->meta_keywords }}">
        <meta name="description" content="{{ $pageInfo->meta_description }}">
        <meta name="author" content="{{ $pageInfo->meta_author }}">
        <title>{{ $pageInfo->meta_title }}</title>

        <meta property="og:site_name" content="Emlak Sepette">
        <meta property="og:url"content="https://private.emlaksepette.com/" />
        <meta property="og:type"content="website" />
        <meta property="og:title"content="{{ $pageInfo->meta_title }}" />
        <meta property="og:description"content="{{ $pageInfo->meta_description }}" />
        @php
            $imageUrl = $pageInfo->meta_image ?? 'https://private.emlaksepette.com/images/mini_logo.png';
        @endphp

        <meta property="og:image" content="{{ $imageUrl }}" />

        <meta property="og:image:width" content="300">
    @endif


    <!-- FAVICON -->
    <!-- Canonical URL için bölüm -->
    @if (isset($canonicalUrl))
        <link rel="canonical" href="{{ $canonicalUrl }}" />
    @endif
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::to('/') }}/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.3/themes/base/jquery-ui.min.css" integrity="sha512-8PjjnSP8Bw/WNPxF6wkklW6qlQJdWJc/3w/ZQPvZ/1bjVDkrrSqLe9mfPYrMxtnzsXFPc434+u4FHLnLjXTSsg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i%7CMontserrat:600,800" rel="stylesheet">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/font/flaticon.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/fontawesome-5-all.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/font-awesome.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- ARCHIVES CSS -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/search-form.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/search.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/animate.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/aos.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/aos2.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/magnific-popup.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/lightcase.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/menu.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/slick.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/stylesNew.css?v=2">
    <link rel="stylesheet" id="color" href="{{ URL::to('/') }}/css/colors/dark-gray.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@600&display=swap" rel="stylesheet">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">

    <style>
        .error-message {
            color: #e54242;
            font-size: 11px;
        }

        .success-message {
            color: green;
            font-size: 11px;
        }
    </style>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FVHQEVC6S0"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-FVHQEVC6S0');
    </script>
    <style>
        .notification-card.unread {
            background-color: #eff2f6;
        }

        #whatsappButton {
            height: 100% !important;
            background: transparent;
            color: green;
            margin-bottom: 10px;
            margin-top: 10px;

        }
        .notification-card {
            cursor: pointer;
        }

        .box::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            background-color: #F5F5F5;
            border-radius: 5px
        }

        .box::-webkit-scrollbar {
            width: 7px;
            background-color: #F5F5F5;
            border-radius: 5px
        }

        .box::-webkit-scrollbar-thumb {
            background-color: #787373;
            border: 1px solid rgba(0, 0, 0, .03);
            border-radius: 5px
        }


        .icons {
            display: inline;
            float: right
        }

        .notification {
            padding-top: 10px;
            position: relative;
            display: inline-block;
        }

        .number {
            height: 22px;
            width: 22px;
            background-color: #d63031;
            border-radius: 20px;
            color: white;
            text-align: center;
            position: absolute;
            top: -1px;
            left: 27px;
            display: flex;
            padding: 0;
            font-size: 10px;
            border-style: solid;
            align-items: center;
            justify-content: center;
        }

        .number:empty {
            display: none;
        }

        .notBtn {
            transition: 0.5s;
            cursor: pointer
        }

        .fa-bell {
            font-size: 18px;
            padding-bottom: 10px;
            color: black;
            margin-left: 20px;
            margin-right: 20px;

        }

        .fs--1 {
            text-align: left;
            font-size: 11px !important;
            line-height: 11px;
            margin-bottom: 0 !important;
        }

        .box {
            width: 300px;
            z-index: 9999;
            height: 300px !important;
            height: 200px;
            border-radius: 10px;
            transition: 0.5s;
            position: absolute;
            overflow-y: scroll;
            overflow-x: hidden;
            padding: 0px;
            left: -74px;
            margin-top: 5px;
            background-color: #F4F4F4;
            -webkit-box-shadow: 10px 10px 23px 0px rgba(0, 0, 0, 0.2);
            -moz-box-shadow: 10px 10px 23px 0px rgba(0, 0, 0, 0.1);
            box-shadow: 10px 10px 23px 0px rgba(0, 0, 0, 0.1);
            cursor: context-menu;
        }

        .fas:hover {
            color: #d63031;
        }


        .gry {
            background-color: #F4F4F4;
        }

        .top {
            color: black;
            padding: 10px
        }


        .cont {
            position: absolute;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #F4F4F4;
        }

        .cont:empty {
            display: none;
        }

        .stick {
            text-align: center;
            display: block;
            font-size: 50pt;
            padding-top: 70px;
            padding-left: 80px
        }

        .stick:hover {
            color: black;
        }

        .cent {
            text-align: center;
            display: block;
        }

        .sec {
            padding: 25px 10px;
            background-color: #F4F4F4;
            transition: 0.5s;
        }

        .profCont {
            padding-left: 15px;
        }

        .profile {
            -webkit-clip-path: circle(50% at 50% 50%);
            clip-path: circle(50% at 50% 50%);
            width: 75px;
            float: left;
        }

        .txt {
            vertical-align: top;
            font-size: 1.25rem;
            padding: 5px 10px 0px 115px;
        }

        .sub {
            font-size: 1rem;
            color: grey;
        }

        .new {
            border-style: none none solid none;
            border-color: #e54242;
        }

        .sec:hover {
            background-color: #BFBFBF;
        }

        .filter-date {
            display: flex;
            align-items: center;
            justify-content: start;
        }

        .collectionTitle {
            width: 100%;
            display: block;
            color: black;
            font-size: 13px !important;
        }

        .circleIcon {
            font-size: 5px !important;
            color: #ea2a28!important;
            padding-right: 5px
        }

        .button-container {
            display: none;
        }

        @media (max-width: 768px) {
            .pro-wrapper {
                text-align: center
            }

            .button-container {
                z-index: 9999999;
                position: fixed;
                width: 100%;
                bottom: 0;
                display: flex;
                background-color: #F7F7F7;
                height: 60px;
                align-items: center;
                justify-content: space-around;
                box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px,
                    rgba(245, 73, 144, 0.5) 5px 10px 15px;
            }

            .button-container .button {
                outline: 0 !important;
                border: 0 !important;
                padding: 0 !important;
                width: 100%;
                height: 100%;
                border-radius: 50%;
                background-color: transparent;
                display: flex;
                align-items: center;
                justify-content: center;
                color: black;
                transition: all ease-in-out 0.3s;
                cursor: pointer;
                flex-direction: column;

            }

            .button-container .button span {
                margin-top: 5px;
                font-size: 11px
            }

            .button-container .button:hover {
                transform: translateY(-3px);
            }

            .button-container .icon {
                font-size: 18px;
            }
        }
    </style>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-55Q6HGHL');
    </script>
    <!-- End Google Tag Manager -->
</head>
<body>
    


<div class="loading-full d-none">
    <div class="back-opa">

    </div>
    <div class="content-loading">
        <i class="fa fa-spinner"></i>
    </div>
</div>

<section class="recently  bg-white homepage-5 " style="margin-top: 30px;">
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
                        <div class="carousel-inner">
                            {{-- Kapak Görseli --}}
                            <div class="item carousel-item active" data-slide-number="0" style="position: absolute">
                                <a href="{{ $coverImage }}"
                                    data-lightbox="project-images">
                                    <img src="{{ $coverImage }}"
                                        class="img-fluid" alt="slider-listing">
                                </a>
                            </div>

                            @foreach ($projectImages as $key => $projectImage)
                                <div class="item carousel-item" data-slide-number="{{ $key + 1 }}">
                                    <a href="{{ $projectImage }}"
                                        data-lightbox="project-images">
                                        <img src="data:{{$mimeTypes[$key]}};base64,{{ $projectImage }}"
                                            class="img-fluid" alt="slider-listing">
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        {{-- Küçük Resim Navigasyonu --}}
                        <div class="listingDetailsSliderNav mt-3">
                            <div class="item active" style="margin: 10px; cursor: pointer">
                                <a id="carousel-selector-0" data-slide-to="0" data-target="#listingDetailsSlider">
                                    <img src="{{ $coverImage }}"
                                        class="img-fluid carousel-indicator-image" alt="listing-small">
                                </a>
                            </div>
                            @foreach ($projectImages as $key => $projectImage)
                                <div class="item" style="margin: 10px; cursor: pointer">
                                    <a id="carousel-selector-{{ $key + 1 }}" data-slide-to="{{ $key + 1 }}"
                                        data-target="#listingDetailsSlider">
                                        <img src="data:{{$mimeTypes[$key]}};base64,{{ $projectImage }}"
                                            class="img-fluid carousel-indicator-image" alt="listing-small">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <nav aria-label="Page navigation example" style="margin-top: 7px">
                            <ul class="pagination">
                                <li class="page-item page-item-left"><a class="page-link" href="#"><</a></li>
                                <li class="page-item page-item-middle"><a class="page-link" href="#"></a></li>
                                <li class="page-item page-item-right"><a class="page-link" href="#">></a></li>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="mobileMove">
                    <div class="single widget storeInfo ">
                        <div class="widget-boxed">
                            <div class="widget-boxed-body" style="padding: 0 !important">
                                <div class="sidebar-widget author-widget2">

                                    <table class="table homes-content" style="margin-bottom: 0 !important">
                                        <tbody>
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
                                                    <span class="autoWidthTr">İlan No:</span>
                                                    <span class="det" style="color: #274abb !important;">
                                                        {{ $project->id + 1000000 }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="autoWidthTr">İlan Tarihi:</span>
                                                    <span class="det" style="color: #274abb !important;">
                                                        {{ date('j', strtotime($project->created_at)) . ' ' . ' ' . date('Y', strtotime($project->created_at)) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="autoWidthTr">Kimden:</span>
                                                    <span class="det" style="color: #274abb !important;">
                                                        {{ $project->user->corporate_type == 'Emlak Ofisi' ? 'Gayrimenkul Ofisi' : $project->user->corporate_type }}
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
                                            {{-- @if($shareSaleCheck)
                                                <tr>
                                                    <td colspan="2">
                                                        <strong class="autoWidthTr">
                                                            <span>Toplam
                                                                Hisse Sayısı:
                                                            </span>
                                                        </strong>
                                                        <span class="det" style="color: black;">{{ $project->numberOfSharesCount }}</span>
                                                    </td>
                                                </tr>
                                            @endif --}}
                                            <tr>
                                                <td colspan="2">
                                                    <strong class="autoWidthTr"><span>Toplam
                                                            {{ ucfirst($project->step1_slug) }}
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





<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>




<!-- ARCHIVES JS -->
<script src="{{ URL::to('/') }}/js/rangeSlider.js?v=2"></script>
<script src="https://cdn.jsdelivr.net/npm/tether@2.0.0/dist/js/tether.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js" integrity="sha512-hUhvpC5f8cgc04OZb55j0KNGh4eh7dLxd/dPSJ5VyzqDWxsayYbojWyl5Tkcgrmb/RVKCRJI1jNlRbVP4WWC4w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/mmenu.min.js?v=2"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/mmenu.js?v=2"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js" integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/aos2.js?v=2"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fitvids/1.2.0/jquery.fitvids.min.js" integrity="sha512-/2sZKAsHDmHNoevKR/xsUKe+Bpf692q4tHNQs9VWWz0ujJ9JBM67iFYbIEdfDV9I2BaodgT5MIg/FTUmUv3oyQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js" integrity="sha512-CEiA+78TpP9KAIPzqBvxUv8hy41jyI3f2uHi7DGp/Y/Ka973qgSdybNegWFciqh6GrN2UePx2KkflnQUbUhNIA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.counterup@2.1.0/jquery.counterup.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/5.0.0/imagesloaded.pkgd.min.js" integrity="sha512-kfs3Dt9u9YcOiIt4rNcPUzdyNNO9sVGQPiZsub7ywg6lRW5KuK1m145ImrFHe3LMWXHndoKo2YRXWy8rnOcSKg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js" integrity="sha512-Zq2BOxyhvnRFXu0+WE6ojpZLOU2jdnqbrM1hmVdGzyeCa1DgM3X5Q4A/Is9xA1IkbUeDd7755dNNI/PzSf2Pew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scroll/16.1.3/smooth-scroll.min.js" integrity="sha512-HYG9E+RmbXS7oy529Nk8byKFw5jqM3R1zzvoV2JnltsIGkK/AhZSzciYCNxDMOXEbYO9w6MJ6SpuYgm5PJPpeQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightcase/2.5.0/js/lightcase.min.js" integrity="sha512-i+A2/k3mB4TtIRp6fyk8Q+xzJqKusi0bvFgCIfDtdJT1tDEMqYvKo60q3bvp6LzGIeS6BahqN4AklwwxbdSaog==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/search.js?v=2"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js" integrity="sha512-gY25nC63ddE0LcLPhxUJGFxa2GoIyA5FLym4UJqHDEMHjp8RET6Zn/SHo1sltt3WuVtqfyxECP38/daUc/WVEA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js" integrity="sha512-IsNh5E3eYy3tr/JiX2Yx4vsCujtkhwl7SLqgnwLNgf04Hrt9BT9SXlLlZlWx+OK4ndzAoALhsMNcCmkggjZB1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxchimp/1.3.0/jquery.ajaxchimp.min.js" integrity="sha512-5yj5elY9u6clGe9/97bj3jJlw8+O9XSv/tbme8m/LR8cKnnT5+rR8qHW/UYQ/MozLg3cvTHeYIpM5kRktASSbg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/newsletter.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.js" integrity="sha512-RTxmGPtGtFBja+6BCvELEfuUdzlPcgf5TZ7qOVRmDfI9fDdX2f1IwBq+ChiELfWt72WY34n0Ti1oo2Q3cWn+kw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/searched.js?v=2"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/forms-2.js?v=2"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/range.js?v=2"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/color-switcher.js?v=2"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


<script>
    $(document).ready(function() {
        $('.listingDetailsSliderNav .item').on('mouseenter', function() {
            var totalSlides = $('#listingDetailsSlider .carousel-item')
                .length; // Toplam slayt sayısını al
            // 'this' bağlamında jQuery öğesi olduğunu varsayarak
            var dataSlideTo = $(this).find('a').attr('data-slide-to');
            // dataSlideTo değerini integer'a dönüştür ve 1 ekle
            var slideNumber = parseInt(dataSlideTo, 10) + 1;
            $('.pagination .page-item-middle .page-link').text((slideNumber) + '/' +
                totalSlides); // Ortadaki li etiketinin metnini güncelle
            $('#listingDetailsSlider .carousel-inner .item').removeClass('active');
            $('#listingDetailsSlider .carousel-inner .item[data-slide-number="' + dataSlideTo + '"]')
                .addClass('active');
            $('.listingDetailsSliderNav .item').removeClass('active');
            $(this).closest('.item').addClass('active');
            $(this).css('border', '1px solid #EC2F2E'); // Border rengini kırmızı yap
            var totalSlides = $('#listingDetailsSlider .carousel-item')
                .length; // Toplam slayt sayısını al
            $('.pagination .page-item-middle .page-link').text((slideNumber) + '/' +
                totalSlides); // Ortadaki li etiketinin metnini güncelle
        }).on('mouseleave', function() {
            $(this).css('border', 'solid 1px #e6e6e6'); // Hover bittiğinde border rengini boş bırak
        });

    });

    $(document).ready(function() {
        $('.listingDetailsSliderNav .item a').on('click', function() {
            var dataSlideTo = $(this).attr('data-slide-to');
            console.log(dataSlideTo);
            var slideNumber = parseInt(dataSlideTo, 10);
            $('#listingDetailsSlider .carousel-inner .item').removeClass('active');
            $('#listingDetailsSlider .carousel-inner .item[data-slide-number="' + dataSlideTo + '"]')
                .addClass('active');
            $('.listingDetailsSliderNav .item').removeClass('active');
            $(this).closest('.item').addClass('active');
        });
    });
    var isLoggedIn = {!! json_encode(auth()->check()) !!};
    var hasClub = isLoggedIn == true ? {!! auth()->user() ? json_encode(auth()->user()->has_club) : 4 !!} : 4;

    $('body').on('click', '.addCollection', function(event) {

        event.preventDefault();
        if (!isLoggedIn) {
            toastr.warning('Lütfen Giriş Yapınız', 'Uyarı');
            redirectToLogin();
            return;

        }





        var button = $(this);
        var productId = $(this).data("id");
        var project = null;
        var type = $(this).data("type");

        if ($(this).data("type") == "project") {
            project = $(this).data("project");
        }
        if (isLoggedIn && hasClub == 0 || hasClub == 2 || hasClub == 3) {
            $('#membershipPopup').modal('show');

        } else if (isLoggedIn && hasClub ==
            1) {
            $('#addCollectionModal').modal('show');
            $(".addCollection").data('cart-info', {
                id: productId,
                type: type,
                project: project,
                _token: "{{ csrf_token() }}",
                clear_cart: "no",
                selectedCollectionId: null
            });


            fetch('/getCollections')
                .then(response => response.json())
                .then(data => {
                    var text;
                    var pluralText;

                    if (isLoggedIn) {
                        var accountType = {!! Auth::check() ? json_encode(Auth::user()->corporate_type) : 'null' !!};
                        if (accountType === "Emlak Ofisi") {
                            text = "Portföy";
                            pluralText = "Portföylerden";
                        } else {
                            text = "Koleksiyon";
                            pluralText = "Koleksiyonlardan";
                        }
                    } else {
                        text = "Koleksiyon";
                        pluralText = "Koleksiyonlardan";
                    }

                    let modalContent =
                        `<div class="modal-header">
          <h3 class="modal-title fs-5" id="exampleModalLabel">${text} Ekle</h3>
       </div>
       <div class="modal-body collection-body">`;

                    if (data.collections.length > 0) {
                        modalContent +=
                            `<span class="collectionTitle mb-3">${pluralText} birini seç veya yeni bir ${text} oluştur</span>`;
                        modalContent +=
                            `<div class="collection-item-wrapper" id="selectedCollectionWrapper">
            <ul class="list-group" id="collectionList" style="justify-content: space-between;">`;

                        data.collections.forEach(collection => {
                            modalContent +=
                                `<li class="list-group-item mb-3" style="cursor:pointer;color:black;font-size:11px !important" data-collection-id="${collection.id}">
             ${collection.name}
           </li>`;
                        });

                        modalContent +=
                            `<li class="list-group-item mb-3" style="cursor:pointer;color:black;font-size:11px !important">
           <i class="fa fa-plus" style="color:#e54242;"></i> Yeni Ekle
         </li>`;
                        modalContent += '</ul></div>';
                    } else {
                        modalContent += `<p>Henüz ${text} yok. Yeni bir ${text} oluştur:</p>`;
                        modalContent +=
                            `<div class="collection-item-wrapper" id="selectedCollectionWrapper">
            <ul class='list-group' id='collectionList' style='justify-content: space-between;'>`;
                        modalContent +=
                            `<li class='list-group-item mb-3' style='cursor:pointer;color:black;font-size:11px !important'>
           <i class='fa fa-plus' style='color:#e54242;'></i> Yeni Ekle
         </li>`;
                        modalContent += '</ul></div>';
                    }

                    modalContent +=
                        '</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button></div>';

                    let modal = document.getElementById('addCollectionModal');
                    let modalBody = modal.querySelector('.modal-content');
                    modalBody.innerHTML = modalContent;

                    // Olay dinleyicilerini yeniden ekleyin
                    document.querySelectorAll('#collectionList li').forEach(item => {
                        item.addEventListener('click', function() {
                            let selectedCollectionId = this.getAttribute(
                                'data-collection-id');
                            if (!this.isEqualNode(document.querySelector(
                                    '#collectionList li:last-child'))) {
                                var cart = {
                                    id: productId,
                                    type: type,
                                    project: project,
                                    _token: "{{ csrf_token() }}",
                                    clear_cart: "no",
                                    selectedCollectionId: parseInt(selectedCollectionId,
                                        10)
                                };

                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('add.to.link') }}",
                                    data: JSON.stringify(cart),
                                    contentType: "application/json;charset=UTF-8",
                                    success: function(response) {
                                        if (response.failed) {
                                            toastr.warning(
                                                "Ürün bu koleksiyonda zaten mevcut."
                                            );
                                        } else {
                                            toastr.success(
                                                "Ürün Koleksiyonunuza Eklendi"
                                            );
                                        }
                                    },
                                    error: function(error) {
                                        console.error(error);
                                    }
                                });

                                closeModal();
                            }
                        });
                    });

                    document.querySelector('#collectionList li:last-child').addEventListener('click',
                        function() {
                            $('#addCollectionModal').modal('hide');
                            $('#newCollectionModal').modal('show');
                        });
                });

        }

        function redirectToLogin() {
            window.location.href = '/giris-yap';
        }



    });


    $('#saveNewCollectionBtn').on('click', function() {


        if (isLoggedIn && hasClub == 0 || hasClub == 2 || hasClub == 3) {
            $('#membershipPopup').modal('show');
        } else if (!isLoggedIn) {
            redirectToLogin();
        } else if (isLoggedIn && hasClub == 1) {
            $(".modal-backdrop").hide();

            let newCollectionName = $('#newCollectionNameInput').val();
            let cartInfo = $('.addCollection').data('cart-info');
            if (newCollectionName) {
                $.ajax({
                    type: 'POST',
                    url: '/collections',
                    data: {
                        collection_name: newCollectionName,
                        _token: "{{ csrf_token() }}",
                        cart: cartInfo
                    },
                    success: function(response) {
                        console.log(response);
                        if (response) {
                            $('#newCollectionModal').modal('hide');
                            $('#newCollectionNameInput').val(" ");
                            toastr.success("Ürün Koleksiyonunuza Eklendİ");

                        } else {
                            toastr.error('Koleksiyon eklenirken bir hata oluştu.');
                        }
                    },
                    error: function(error) {
                        console.error('Koleksiyon eklenirken bir hata oluştu:', error);
                    }
                });
            } else {
                toastr.warning('Lütfen yeni bir koleksiyon adı girin.');
            }
        }

    });

    function closeModal() {
        $(".modal-backdrop").hide();
        $('#addCollectionModal').modal('hide');
        $('#newCollectionModal').modal('hide');
    }

    $(document).ready(function() {
        $(".box").hide();

        $(".notification").click(function(e) {
            e.stopPropagation(); // Bu, dışarı tıklandığında belge olayının tetiklenmesini önler
            $(".box").toggle();
        });

        $(document).click(function(e) {
            if (!$(e.target).closest('.box').length && !$(e.target).closest('.notification').length) {
                $(".box").hide();
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        var notificationCards = document.querySelectorAll(".notification-card");
        notificationCards.forEach(function(card) {
            card.addEventListener("click", function() {
                var notificationId = card.getAttribute("data-id");
                var notificationLink = $(this).data('link');

                fetch('/mark-notification-as-read/' + notificationId, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    })
                    .then(function(response) {

                        if (response.status == "readed") {
                            var numberCount = parseInt($(".notBtn .number").html());
                            if (numberCount > 0) {
                                numberCount--;
                                $(".notBtn .number").html(numberCount);
                            }
                        }

                        if (notificationLink) {
                            window.location.href = notificationLink;
                        }
                        card.classList.remove("unread");
                        card.classList.add("read");

                    })
                    .catch(function(error) {
                        console.error('Bir hata oluştu:', error);
                    });
            });
        });
    });
    $('body').on('click', '.payment-plan-button', function(event) {
        var order = $(this).attr('order');
        var block = $(this).data("block");
        var message = $(this).data("message");

        var paymentOrder = $(this).data("payment-order");
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

        var userCheck = {!! auth()->user() ? json_encode(auth()->user()->id) : 0 !!};


        if (userCheck == 0) {
            if (message) {
                if (message == "approve") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Uyarı',
                        text: 'Projeye teklif göndermek için lütfen giriş yapınız.',
                        showCancelButton: true,
                        confirmButtonText: 'Giriş Yap',
                        cancelButtonText: 'Kapat',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Buraya kullanıcıyı giriş sayfasına yönlendiren kodu ekleyin
                            window.location.href = '/giris-yap'; // Giriş sayfanızın URL'sini buraya koyun
                        }
                    });

                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Uyarı',
                        text: 'Projeye başvurmak için lütfen giriş yapınız.',
                        showCancelButton: true,
                        confirmButtonText: 'Giriş Yap',
                        cancelButtonText: 'Kapat',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Buraya kullanıcıyı giriş sayfasına yönlendiren kodu ekleyin
                            window.location.href = '/giris-yap'; // Giriş sayfanızın URL'sini buraya koyun
                        }
                    });
                }

            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Uyarı',
                    text: 'Ödeme detayını görüntülemek için lütfen giriş yapınız.',
                    showCancelButton: true,
                    confirmButtonText: 'Giriş Yap',
                    cancelButtonText: 'Kapat',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Buraya kullanıcıyı giriş sayfasına yönlendiren kodu ekleyin
                        window.location.href = '/giris-yap'; // Giriş sayfanızın URL'sini buraya koyun
                    }
                });
            }

        } else if (soldStatus == "1") {
            Swal.fire({
                icon: 'warning',
                title: 'Uyarı',
                text: 'Bu ilan için ödeme detay bilgisi gösterilemiyor.',
                confirmButtonText: 'Kapat'
            });
        } else {
            $.ajax({
                url: "{{ route('get.housing.payment.plan') }}", // Sepete veri eklemek için uygun URL'yi belirtin
                type: "get", // Veriyi göndermek için POST kullanabilirsiniz
                data: cart,
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
                            const months = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran",
                                "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"
                            ]
                            orderHousing = parseInt(order);
                            var userTypeOne = {!! auth()->user() ? json_encode(auth()->user()->type) : 0 !!};

                            if (getDataJS(response, "discount_rate[]",
                                    response.room_info[i].room_order) && userTypeOne == 1) {
                                html += "<tr class='" + (isMobile ? "mobile-hidden" : "") +
                                    "' style='background-color: green !important;color:white;font-weight: 100'>" +
                                    "<th style='text-align:center' class='paymentTableTitle' colspan='" +
                                    (4 + parseInt(getDataJS(response, "pay-dec-count" +
                                        orderHousing, response.room_info[i].room_order), 10)) +
                                    "'>" +
                                    "EN YAKIN EMLAK OFİSİNİN KOLEKSİYONU İLE BU İLANI SATIN ALIRSANIZ, %" +
                                    (getDataJS(response, "discount_rate[]", response.room_info[i]
                                        .room_order)) +
                                    " ORANINDA İNDİRİM KAZANIRSINIZ." +
                                    "</th></tr>";


                            }

                            html += "<tr class='" + (isMobile ? "mobile-hidden" : "") +
                                "' style='background-color: #EEE !important;' ><th style='text-align:center' class='paymentTableTitle' colspan=" +
                                (4 + parseInt(getDataJS(response, "pay-dec-count" + orderHousing,
                                    response.room_info[i].room_order), 10)) + " >" + response
                                .project_title +
                                " Projesinde " + block + " " + paymentOrder +
                                " No'lu İlan Ödeme Planı</th></tr>";

                            $(".pop-up-top-gradient .left h3").html(
                                response
                                .project_title +
                                " Projesinde " + block + " " + paymentOrder +
                                " No'lu İlan Ödeme Planı"
                            )



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
                                                    parseFloat(
                                                        getDataJS(
                                                            response,
                                                            "installments-price[]", response
                                                            .room_info[i].room_order)) -
                                                    parseFloat(getDataJS(response,
                                                        "advance[]", response.room_info[
                                                            i].room_order)) - (payDecPrice *
                                                        numberOfShares)) /
                                                parseInt(installementData)) / numberOfShares) +
                                            "₺" : formatPrice((parseFloat(getDataJS(
                                                        response,
                                                        "installments-price[]", response
                                                        .room_info[i].room_order)) -
                                                    parseFloat(getDataJS(response,
                                                        "advance[]", response.room_info[
                                                            i].room_order)) - (payDecPrice)) /
                                                parseInt(installementData)) + "₺";
                                    }
                                    var isMobile = window.innerWidth < 768;

                                    orderHousing = parseInt(order);

                                    var payDecPrice = 0;
                                    if (paymentPlanDatax[paymentPlanData[j]] == "Taksitli") {
                                        html += "<tr class='" + (isMobile ? "mobile-hidden" : "") +
                                            "' style='background-color: #EEE !important;'><th>" +
                                            installementData +
                                            " Ay Taksitli Fiyat</th><th>Peşinat</th><th>Aylık Ödenecek Miktar</th>";



                                        for (var l = 1; l <= getDataJS(response,
                                                "pay-dec-count" + (orderHousing), response
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
                                                installementData + " Ay " +
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

                                    if (!isMobile && isNotEmpty(installmentsPrice) &&
                                        paymentPlanDatax[
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
                                    if (getDataJS(response, "pay-dec-count" + (orderHousing),
                                            response.room_info[i].room_order)) {

                                        for (var l = 0; l < getDataJS(response,
                                                "pay-dec-count" + (orderHousing), response
                                                .room_info[i].room_order); l++) {

                                            if (getDataJS(response, "pay_desc_price" + (
                                                        orderHousing) + l, response.room_info[i]
                                                    .room_order)) {
                                                payDecPrice += numberOfShares ? parseFloat(
                                                        getDataJS(response,
                                                            "pay_desc_price" + (orderHousing) +
                                                            l,
                                                            response.room_info[i].room_order)) /
                                                    numberOfShares : parseFloat(getDataJS(response,
                                                        "pay_desc_price" + (orderHousing) +
                                                        l,
                                                        response.room_info[i].room_order));
                                                var payDecPrice2 = numberOfShares ? parseFloat(
                                                        getDataJS(response,
                                                            "pay_desc_price" + (orderHousing) +
                                                            l,
                                                            response.room_info[i].room_order)) /
                                                    numberOfShares : parseFloat(getDataJS(response,
                                                        "pay_desc_price" + (orderHousing) +
                                                        l,
                                                        response.room_info[i].room_order));
                                                var payDescDate = new Date(getDataJS(response,
                                                    "pay_desc_date" + (orderHousing) +
                                                    l,
                                                    response.room_info[i].room_order));
                                                console.log(payDecPrice);
                                                if (paymentPlanDatax[paymentPlanData[j]] ==
                                                    "Taksitli") {
                                                    html += "<td>" + (isMobile ? "<strong>" + (l +
                                                                1) +
                                                            ". Ara Ödeme :</strong> <br>" :
                                                            "") +
                                                        formatPrice(payDecPrice2) + "₺" +
                                                        (isMobile ? " <br>" : "<br>") +
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


                            $('.payment-plan tbody').html(html);

                            $('.payment-plan-pop-up').removeClass('d-none')

                            document.getElementById("whatsappButton").addEventListener("click",
                                function() {
                                    var projectSlug = response.slug + "-" + response
                                        .step2_slug + "-" + response.housing_type.slug;
                                    var projectID = response.id + 1000000;
                                    var housingOrder = paymentOrder;

                                    var domain = window.location.origin;
                                    var url = domain + '/proje/' + projectSlug + '/ilan/' +
                                        projectID + '/' + housingOrder + '/detay' +
                                        "/odeme-plani";


                                    // Whatsapp yönlendirme URL'sini oluştur
                                    var whatsappURL = 'https://api.whatsapp.com/send?text=' +
                                        encodeURIComponent(url);



                                    window.open(whatsappURL, '_blank');
                                });
                        }
                    }
                },
                error: function(error) {
                    // Hata durumunda buraya gelir
                    toast.error(error)
                    console.error("Hata oluştu: " + error);
                }
            });
        }

    })





    $(document).ready(function() {
        const searchInput = $(".search-input");
        const suggestions = $(".header-search__suggestions");
        searchInput.attr("autocomplete", "off");

        // Arama alanına tıklama olayını ekle
        searchInput.click(function() {

            suggestions.show();
        });

        // Sayfa herhangi bir yerine tıklama olayını ekle
        $(document).click(function(event) {
            if (!searchInput.is(event.target) && !suggestions.is(event.target)) {
                suggestions.hide();
            }
        });
    });
    $('.payment-plan-pop-back').click(function() {
        $('.payment-plan-pop-up').addClass('d-none')
    })

    $('.payment-plan-pop-close-icon').click(function() {
        $('.payment-plan-pop-up').addClass('d-none')
    })
    $('.slick-agents').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        dots: false,
        loop: true,
        autoplay: true,
        arrows: true,
        adaptiveHeight: true,
        responsive: [{
            breakpoint: 1292,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 4,
                dots: false,
                arrows: false
            }
        }, {
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
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                arrows: false
            }
        }]
    });

    $('.slick-agents-2').slick({
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 3,
        dots: false,
        arrows: true,
        adaptiveHeight: true,
        responsive: [{
            breakpoint: 1292,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                dots: false,
                arrows: false
            }
        }, {
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
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                arrows: false
            }
        }]
    });
    $('.slick-agentsc').slick({
        infinite: false,
        slidesToShow: 5,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        adaptiveHeight: true,
        responsive: [{
            breakpoint: 1292,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                dots: false,
                arrows: false
            }
        }, {
            breakpoint: 993,
            settings: {
                slidesToShow: 5,
                slidesToScroll: 1,
                dots: false,
                arrows: false
            }
        }, {
            breakpoint: 769,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                arrows: true
            }
        }]
    });
    $('.slick-lancers').slick({
        infinite: false,
        slidesToShow: 10,
        slidesToScroll: 5,
        dots: false,
        arrows: false,
        adaptiveHeight: true,
        responsive: [{
            breakpoint: 1292,
            settings: {
                slidesToShow: 10,
                slidesToScroll: 4,
                dots: false,
                arrows: false
            }
        }, {
            breakpoint: 993,
            settings: {
                slidesToShow: 8,
                slidesToScroll: 3,
                dots: false,
                arrows: false
            }
        }, {
            breakpoint: 769,
            settings: {
                slidesToShow:4,
                slidesToScroll: 4,
                dots: false,
                arrows: false
            }
        }]
    });

    $('.home5-right-slider').owlCarousel({
        loop: true,
        margin: 30,
        dots: false,
        nav: true,
        rtl: false,
        autoplayHoverPause: false,
        autoplay: true,
        singleItem: true,
        smartSpeed: 1200,
        navText: ["<i class='fas fa-angle-left'></i>", "<i class='fas fa-angle-right'></i>"],
        responsive: {
            0: {
                items: 1,
                center: false,
                nav: false,
            },
            480: {
                items: 1,
                center: false,
                nav: false,

            },
            520: {
                items: 1,
                center: false,
                nav: false,

            },
            600: {
                items: 1,
                center: false,
                nav: false,

            },
            768: {
                items: 1,
                nav: false,

            },
            992: {
                items: 1,
                nav: false,

            },
            1200: {
                items: 1
            },
            1366: {
                items: 1
            },
            1400: {
                items: 1
            }
        }
    });
    $(".dropdown-filter").on('click', function() {

        $(".explore__form-checkbox-list").toggleClass("filter-block");

    });
</script>

<!-- Slider Revolution scripts -->
<script src="{{ URL::to('/') }}/revolution/js/jquery.themepunch.tools.min.js"></script>
<script src="{{ URL::to('/') }}/revolution/js/jquery.themepunch.revolution.min.js"></script>
<!-- lightbox2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<!-- jQuery -->

<!-- lightbox2 JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<!-- MAIN JS -->
<script src="{{ URL::to('/') }}/js/script.js"></script>

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<!-- SweetAlert2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $(document).ready(function() {

        checkFavorites();
        checkProjectFavorites();
        var cart = @json(session('cart', []));

        var addToCartButtons = document.querySelectorAll(".CartBtn");
        $('body').on('click', '.CartBtn', function(event) {
            event.preventDefault();

            var button = event.target;
            var productId = $(this).data("id");
            var isShare = $(this).data("share");
            var numbershare = $(this).data("number-share");
            var project = null;

            if ($(this).data("type") == "project") {
                project = $(this).data("project");
            }


            var cart = {
                id: productId,
                isShare: isShare,
                numbershare: parseInt(numbershare, 10), // Parse numbershare to an integer
                qt: 1,
                type: $(this).data("type"),
                project: project,
                _token: "{{ csrf_token() }}",
                clear_cart: "no"
            };



            if (isProductInCart(productId, project)) {
                Swal.fire({
                    title: "Ürünü sepetten kaldırmak istiyor musunuz?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: "Evet, Kaldır",
                    cancelButtonText: 'Hayır',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('add.to.cart') }}",
                            data: JSON.stringify(cart),
                            contentType: "application/json;charset=UTF-8",
                            success: function(response) {

                                toastr.error("Ürün Sepetten Kaldırılıyor.");
                                button.classList.remove("bg-success");
                                location.reload();

                            },
                            error: function(error) {
                                // window.location.href = "/giris-yap";

                                // console.error(error);
                            }
                        });
                    }
                });
            } else {
                Swal.fire({
                    title: isCartEmpty() ? 'Sepete eklemek istiyor musunuz?' :
                        'Mevcut sepeti temizlemek istiyor musunuz?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: isCartEmpty() ? 'Evet' : 'Evet, temizle',
                    cancelButtonText: 'Hayır',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('add.to.cart') }}",
                            data: JSON.stringify(cart),
                            contentType: "application/json;charset=UTF-8",
                            success: function(response) {


                                toastr.success("Ürün Sepete Eklendi");
                                if (!button.classList.contains("mobile")) {
                                    button.textContent = "Sepete Eklendi";
                                }
                                button.classList.add("bg-success");
                                window.location.href = "/sepetim";


                            },
                            error: function(error) {

                                // window.location.href = "/giris-yap";

                                console.error(error);

                            }
                        });
                    }
                });

            }

        });

        $('body').on('click', '.disabledShareButton', function(event) {
            event.preventDefault();
            toastr.error("Satışa kapalı ürünleri koleksiyonunuza ekleyemezsiniz.");
        });

        updateCartButton();

        function updateCartButton() {
            var CartBtn = document.querySelectorAll(".CartBtn");
            CartBtn.forEach(function(button) {
                var productId = button.getAttribute("data-id");
                var productType = button.getAttribute("data-type");
                var product = null;
                if (productType == "project") {
                    product = button.getAttribute("data-project");
                }

                if (isProductInCart(productId, product)) {
                    if (!button.classList.contains("mobile")) {
                        button.querySelector(".text").textContent = "Sepete Eklendi";
                    }

                    button.classList.add("bg-success");
                } else {
                    button.classList.remove("bg-success");
                }
            });
        }

        function isCartEmpty() {
            var cart = @json(session('cart', []));
            return cart.length <= 0;
        }



        function isProductInCart(productId, product) {
            var cart = @json(session('cart', []));
            if (cart.length != 0) {
                if (product != null) {
                    if (cart.item.id == product && cart.item.housing == productId) {
                        return true;
                    }
                } else {
                    if (cart.item.id == productId) {
                        return true; // Ürün sepette bulundu
                    }
                }
            }
            return false;
        }



        function checkProjectFavorites() {
            // Favorileri sorgula ve uygun renk ve ikonları ayarla
            var favoriteButtons = document.querySelectorAll(".toggle-project-favorite");
            var projectHousingPairs = []; // Proje ve housing ID'lerini içeren bir dizi

            favoriteButtons.forEach(function(button) {
                var housingId = button.getAttribute("data-project-housing-id");
                var projectId = button.getAttribute("data-project-id");

                projectHousingPairs.push({
                    projectId: projectId,
                    housingId: housingId
                });
            });
            var csrfToken = $('meta[name="csrf-token"]').attr('content');


            $.ajax({
                url: "{{ route('get.project.housing.favorite.status') }}",
                type: "POST",
                data: {
                    _token: csrfToken,
                    projectHousingPairs: projectHousingPairs
                },
                success: function(response) {
                    favoriteButtons.forEach(function(button) {
                        var housingId = button.getAttribute(
                            "data-project-housing-id");
                        var projectId = button.getAttribute("data-project-id");
                        var isFavorite = response[projectId][housingId];

                        if (isFavorite) {
                            button.querySelector("i").classList.remove(
                                "fa-heart-o");
                            button.querySelector("i").classList.add(
                                "fa-heart");
                            button.querySelector("i").classList.add(
                                "text-danger");
                            button.classList.add("bg-white");
                        } else {
                            button.querySelector("i").classList.remove(
                                "text-danger");
                            button.querySelector("i").classList.remove(
                                "fa-heart");
                            button.querySelector("i").classList.add(
                                "fa-heart-o");
                        }
                    });
                },
            });



        }


        function checkFavorites() {
            var favoriteButtons = document.querySelectorAll(".toggle-favorite");
            favoriteButtons.forEach(function(button) {
                var housingId = button.getAttribute("data-housing-id");

                $.ajax({
                    url: "{{ route('get.housing.favorite.status', ['id' => ':id']) }}"
                        .replace(':id', housingId),
                    type: "GET",
                    success: function(response) {
                        if (response.is_favorite) {
                            button.querySelector("i").classList.remove(
                                "fa-heart-o");
                            button.querySelector("i").classList.add(
                                "fa-heart");
                            button.querySelector("i").classList.add(
                                "text-danger");
                            button.classList.add("bg-white");
                        } else {
                            button.querySelector("i").classList.remove(
                                "text-danger");
                            button.querySelector("i").classList.remove(
                                "fa-heart");
                            button.querySelector("i").classList.add(
                                "fa-heart-o");
                        }
                    },
                    error: function(error) {
                        button.querySelector("i").classList.remove(
                            "text-danger");
                        button.querySelector("i").classList.remove(
                            "fa-heart");
                        button.querySelector("i").classList.add(
                            "fa-heart-o");
                        console.error(error);
                    }
                });
            });
        }



        function toggleProjectFavorite(event) {
            event.preventDefault();

            var button = event.target;
            if ($(event.target).is('i')) {
                button = button.closest('.toggle-project-favorite');
            }
            var housingId = button.getAttribute("data-project-housing-id");
            var projectId = button.getAttribute("data-project-id");

            $.ajax({
                url: "{{ route('add.project.housing.to.favorites', ['id' => ':id']) }}".replace(':id',
                    housingId),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    project_id: projectId,
                    housing_id: housingId
                },
                success: function(response) {
                    if (response.status == 'added') {
                        updateFavoriteButton(button, true);
                    } else if (response.status == 'removed') {
                        updateFavoriteButton(button, false);
                    } else if (response.status == 'notLogin') {
                        window.location.href =
                            "{{ route('client.login') }}"; // Redirect to the login route
                    }
                },
                error: function(error) {
                    // window.location.href = "/giris-yap";
                }
            });
        }



        // Function to handle the click event for generic favorite toggle
        function toggleFavorite(event) {
            event.preventDefault();
            var housingId = event.currentTarget.getAttribute("data-housing-id");
            var button = event.currentTarget;

            $.ajax({
                url: "{{ route('add.housing.to.favorites', ['id' => ':id']) }}".replace(':id',
                    housingId),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status == 'added') {
                        toastr.success("Konut Favorilere Eklendi");
                        updateFavoriteButton(button, true);
                    } else if (response.status == 'removed') {
                        toastr.warning("Konut Favorilerden Kaldırıldı");
                        updateFavoriteButton(button, false);
                    } else if (response.status == 'notLogin') {
                        window.location.href =
                            "{{ route('client.login') }}"; // Redirect to the login route
                    }
                },
                error: function(error) {
                    window.location.href = "/giris-yap";
                    console.error(error);
                }
            });
        }

        // Function to update the favorite button styles
        function updateFavoriteButton(button, isAdded) {
            var heartIconClassList = button.querySelector("i").classList;
            heartIconClassList.remove("text-danger", "fa-heart", "fa-heart-o");

            if (isAdded) {
                heartIconClassList.add("fa-heart", "text-danger");
                button.classList.add("bg-white");
            } else {
                heartIconClassList.add("fa-heart-o");
                button.classList.remove("bg-white");
            }
        }

        // Event delegation for project favorite toggle
        $('body').on('click', '.toggle-project-favorite', toggleProjectFavorite);


        // Event delegation for generic favorite toggle
        $('body').on("click", ".toggle-favorite", toggleFavorite);

    });
    const appUrl = "https://private.emlaksepette.com/"; // Uygulama URL'si
    let timeout; // AJAX isteği için zamanlayıcı değişkeni

    function showSearchingMessage() {
        $('.header-search-box').empty().append(
            '<div class="font-weight-bold p-2 small" style="background-color: #EEE;">Aranıyor...</div>');
    }

    function hideSearchingMessage() {
        $('.header-search-box div:contains("Aranıyor...")').remove();
    }

    function drawHeaderSearchbox(searchTerm) {
        showSearchingMessage();

        if (timeout) {
            clearTimeout(timeout); // Önceki AJAX isteğini iptal et
        }

        timeout = setTimeout(function() {
            $.ajax({
                url: "{{ route('get-search-list') }}",
                method: "GET",
                data: {
                    searchTerm
                },
                success: function(data) {
                    let hasResults = false;
                    // Housing search
                    if (data.housings.length > 0) {
                        hasResults = true;
                        $('.header-search-box').append(`
                            <div class="d-flex font-weight-bold justify-content-center border-bottom border-2 pb-2 pt-3 small">İkinci-El Emlak</div>
                        `);

                        const maxResultsToShow = 4; // Gösterilecek maksimum sonuç sayısı
                        const housingsToShow = data.housings.slice(0,
                            maxResultsToShow); // İlk 4 sonucu al

                        housingsToShow.forEach((e) => {
                            const imageUrl = `${appUrl}housing_images/${e.photo}`;
                            const formattedName = e.name.charAt(0).toUpperCase() + e.name
                                .slice(1);
                            var baseRoute =
                                `{{ route('housing.show', ['housingSlug' => 'slug_placeholder', 'housingID' => 'id_placeholder']) }}`
                                .replace('slug_placeholder', e.slug)
                                .replace('id_placeholder', parseInt(e.id) + 2000000);

                            //housign.show link eklenecek
                            $('.header-search-box').append(`
                            <a href="${baseRoute.replace('slug_placeholder', e.slug).replace('id_placeholder', e.id)}" class="d-flex text-dark  align-items-center px-3 py-1" style="gap: 8px;">
                                <span>${formattedName}</span>
                            </a>
                        `);
                        });

                        if (data.housings.length > maxResultsToShow) {
                            const remainingResults = data.housings.length - maxResultsToShow;
                            // Arama terimi "housing" olarak belirleniyor
                            const searchUrl = "{{ route('search.results') }}?searchTerm=" +
                                searchTerm + "&type=housing";

                            // Laravel route'u kullanarak URL oluşturma
                            $('.header-search-box').append(`
                            <a href="${searchUrl}" class="text-muted m-3">${remainingResults} sonuç daha bulunmaktadır.</a>
                        `);
                        }
                    }


                    // Project search
                    if (data.projects.length > 0) {
                        const maxResultsToShow = 4; // Gösterilecek maksimum sonuç sayısı
                        const projectsToShow = data.projects.slice(0,
                            maxResultsToShow); // İlk 4 sonucu al

                        hasResults = true;
                        $('.header-search-box').append(`
                            <div class="d-flex font-weight-bold justify-content-center border-bottom border-2 pb-2 pt-3 small">PROJELER</div>
                        `);

                        projectsToShow.forEach((e) => {
                            console.log(e);
                            const imageUrl =
                                `${appUrl}${e.photo.replace('public', 'storage')}`; // Resim URL'sini uygulama URL'si ile birleştirin
                            const formattedName = e.name.charAt(0).toUpperCase() + e.name
                                .slice(1);
                            var baseRoute =
                                `{{ route('project.detail', ['slug' => 'slug_placeholder', 'id' => 'id_placeholder']) }}`
                                .replace('slug_placeholder', e.slug)
                                .replace('id_placeholder', parseInt(e.id) + 1000000);

                            // Now, you can use it in your append statement:
                            $('.header-search-box').append(`
                                <a href="${baseRoute.replace('slug_placeholder', e.slug).replace('id_placeholder', e.id)}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
                                    <span>${formattedName}</span>
                                </a>
                            `);
                        });

                        if (data.projects.length > maxResultsToShow) {
                            const remainingResults = data.projects.length - maxResultsToShow;
                            // Arama terimi "project" olarak belirleniyor
                            const searchUrl = "{{ route('search.results') }}?searchTerm=" +
                                searchTerm + "&type=project";

                            // Laravel route'u kullanarak URL oluşturma
                            $('.header-search-box').append(`
                                <a href="${searchUrl}" class="text-muted m-3">${remainingResults} sonuç daha bulunmaktadır.</a>
                            `);
                        }
                    }

                    if (data.merchants.length > 0) {
                        hasResults = true;
                        $('.header-search-box').append(`
                            <div class="d-flex font-weight-bold justify-content-center border-bottom border-2 pb-2 pt-3 small">MAĞAZALAR</div>
                        `);
                        const maxResultsToShow = 4; // Gösterilecek maksimum sonuç sayısı
                        const merchantsToShow = data.merchants.slice(0,
                            maxResultsToShow); // İlk 4 sonucu al

                        merchantsToShow.forEach((e) => {
                            const imageUrl =
                                `${appUrl}storage/profile_images/${e.photo}`; // Resim URL'sini uygulama URL'si ile birleştirin
                            const formattedName = e.name.charAt(0).toUpperCase() + e.name
                                .slice(1);

                            $('.header-search-box').append(`
                        <a href="{{ URL::to('/magaza/') }}/${e.slug}/${e.id}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
                            <span>${formattedName}</span>
                        </a>
                    `);
                        });

                        if (data.merchants.length > maxResultsToShow) {
                            const remainingResults = data.merchants.length - maxResultsToShow;
                            // Arama terimi "merchant" olarak belirleniyor
                            const searchUrl = "{{ route('search.results') }}?searchTerm=" +
                                searchTerm + "&type=merchant";

                            // Laravel route'u kullanarak URL oluşturma
                            $('.header-search-box').append(`
                                <a href="${searchUrl}" class="text-muted m-3">${remainingResults} sonuç daha bulunmaktadır.</a>
                            `);
                        }
                    }


                    // Veri yoksa veya herhangi bir sonuç yoksa "Sonuç Bulunamadı" mesajını görüntüle
                    if (!hasResults) {
                        $('.header-search-box').append(`
                                <div class="font-weight-bold p-2 small" style="background-color: white; text-align: center;">Sonuç bulunamadı</div>
                            `);
                    } else {
                        hideSearchingMessage
                            (); // AJAX başarılı olduğunda "Aranıyor..." yazısını kaldır
                    }

                    if ($('.header-search-box').children().length > 3) {
                        $('.header-search-box').css('overflow-y',
                            'scroll'
                        ); // 7'den fazla sonuç varsa kaydırma çubuğunu etkinleştir
                    } else {
                        $('.header-search-box').css('overflow-y',
                            'unset'
                        ); // 7 veya daha az sonuç varsa kaydırma çubuğunu devre dışı bırak
                    }
                }
            });
        }, 1000); // 1 saniye gecikmeli AJAX isteği başlat
    }

    $('.ss-box').on('input', function() {
        let term = $(this).val();

        if (term != '') {
            $('.header-search-box').addClass('d-flex').removeClass('d-none');
            drawHeaderSearchbox(term);
        } else {
            $('.header-search-box').removeClass('d-flex').addClass('d-none');
        }
    });
    $(document).click(function(event) {

        if (
            $('.toggle > input').is(':checked') &&
            !$(event.target).parents('.toggle').is('.toggle')
        ) {
            $('.toggle > input').prop('checked', false);
        }
    })
    'use strict';
    $(function() {
        const appUrl = "https://private.emlaksepette.com/"; // Uygulama URL'si
        let timeout; // AJAX isteği için zamanlayıcı değişkeni

        function showSearchingMessage() {
            $('.header-search-box-mobile').empty().append(
                '<div class="font-weight-bold p-2 small" style="background-color: #EEE;">Aranıyor...</div>');
        }

        function hideSearchingMessage() {
            $('.header-search-box-mobile div:contains("Aranıyor...")').remove();
        }

        function drawHeaderSearchbox(searchTerm) {
            showSearchingMessage();

            if (timeout) {
                clearTimeout(timeout); // Önceki AJAX isteğini iptal et
            }

            timeout = setTimeout(function() {
                $.ajax({
                    url: "{{ route('get-search-list') }}",
                    method: "GET",
                    data: {
                        searchTerm
                    },
                    success: function(data) {
                        let hasResults = false;

                        // Housing search
                        if (data.housings.length > 0) {
                            hasResults = true;
                            $('.header-search-box-mobile').append(`
                                <div class="font-weight-bold p-2 small" style="background-color: #EEE;">KONUTLAR</div>
                            `);

                            data.housings.forEach((e) => {
                                const imageUrl =
                                    `${appUrl}housing_images/${e.photo}`; // Resim URL'sini uygulama URL'si ile birleştirin
                                const formattedName = e.name.charAt(0)
                                    .toUpperCase() + e.name.slice(1);


                                var baseRoute =
                                    `{{ route('housing.show', ['housingSlug' => 'slug_placeholder', 'housingID' => 'id_placeholder']) }}`
                                    .replace('slug_placeholder', e.slug).replace(
                                        'id_placeholder', parseInt(e.id) + 2000000);

                                //housign.show metodu eklenecek    
                                $('.header-search-box-mobile').append(`
                                  <a href="${baseRoute.replace('slug_placeholder', e.slug).replace('id_placeholder', e.id)}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
                                    <span>${formattedName}</span>
                                </a>
                                `);

                            });
                        }

                        // Project search
                        if (data.projects.length > 0) {
                            hasResults = true;
                            $('.header-search-box-mobile').append(`
                                <div class="font-weight-bold p-2 small" style="background-color: #EEE;">PROJELER</div>
                            `);
                            console.log(data.projects);
                            data.projects.forEach((e) => {
                                const imageUrl =
                                    `${appUrl}${e.photo.replace('public', 'storage')}`; // Resim URL'sini uygulama URL'si ile birleştirin
                                const formattedName = e.name.charAt(0)
                                    .toUpperCase() + e.name.slice(1);

                                // Assuming you have a JavaScript variable like this:
                                var baseRoute =
                                    `{{ route('project.detail', ['slug' => 'slug_placeholder', 'id' => 'id_placeholder']) }}`
                                    .replace('slug_placeholder', e.slug).replace(
                                        'id_placeholder', parseInt(e.id) + 1000000);


                                // Now, you can use it in your append statement:
                                $('.header-search-box-mobile').append(`
                                <a href="${baseRoute.replace('slug_placeholder', e.slug).replace('id_placeholder', e.id)}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
                                    <span>${formattedName}</span>
                                </a>
                            `);



                            });
                        }

                        // Merchant search
                        if (data.merchants.length > 0) {
                            hasResults = true;
                            $('.header-search-box-mobile').append(`
                                <div class="font-weight-bold p-2 small" style="background-color: #EEE;">MAĞAZALAR</div>
                            `);
                            data.merchants.forEach((e) => {
                                const imageUrl =
                                    `${appUrl}storage/profile_images/${e.photo}`; // Resim URL'sini uygulama URL'si ile birleştirin
                                const formattedName = e.name.charAt(0)
                                    .toUpperCase() + e.name.slice(1);

                                $('.header-search-box').append(`
    <a href="{{ URL::to('/magaza/') }}/${e.slug}/${e.id}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
        <span>${formattedName}</span>
    </a>
`);

                            });
                        }

                        // Veri yoksa veya herhangi bir sonuç yoksa "Sonuç Bulunamadı" mesajını görüntüle
                        if (!hasResults) {
                            $('.header-search-box-mobile').append(`
                                <div class="font-weight-bold p-2 small" style="background-color: white; text-align: center;">Sonuç bulunamadı</div>
                            `);
                        } else {
                            hideSearchingMessage
                                (); // AJAX başarılı olduğunda "Aranıyor..." yazısını kaldır
                        }

                        if ($('.header-search-box-mobile').children().length > 3) {
                            $('.header-search-box-mobile').css('overflow-y',
                                'scroll'
                            ); // 7'den fazla sonuç varsa kaydırma çubuğunu etkinleştir
                        } else {
                            $('.header-search-box-mobile').css('overflow-y',
                                'unset'
                            ); // 7 veya daha az sonuç varsa kaydırma çubuğunu devre dışı bırak
                        }
                    }
                });
            }, 1000); // 1 saniye gecikmeli AJAX isteği başlat
        }

        $('#ss-box-mobile').on('input', function() {
            let term = $(this).val();

            if (term != '') {
                $('.header-search-box-mobile').addClass('d-flex').removeClass('d-none');
                drawHeaderSearchbox(term);
            } else {
                $('.header-search-box-mobile').removeClass('d-flex').addClass('d-none');
            }
        });
    });
    $(document).ready(function() {
        $('.slick-lancersl').slick({
            loop: true,
            margin: 30,
            rtl: false,
            autoplayHoverPause: false,
            singleItem: true,
            smartSpeed: 1200,
            infinite: true,
            autoplay: true,
            loop: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: false,
            arrows: true,
            adaptiveHeight: true,
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&callback=initMap"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openLightbox(index) {
            const slideNumber = index.toString();
            const slides = document.querySelectorAll('.carousel-inner .item');
            slides.forEach((slide) => {
                if (slide.getAttribute('data-slide-number') === slideNumber) {
                    slide.querySelector('a[data-lightbox="project-images"]').click();
                }
            });
        }
    </script>


    <script>
        $(document).ready(function() {

            $(document).on("change", ".citySelect2", function() {
                var selectedCity = $(this).val();
                console.log(selectedCity);
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

        });
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
            var block = document.getElementById('contentblock-' + tabName).dataset.blockName;

            var blockIndex = $('#contentblock-' + tabName).index() - 1;
            var startIndex = 0;
            var endIndex = 12;

        }
    </script>
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
                    if (error.message == 'error') {
                        alert('dasdsada');
                    }
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
            slidesToScroll: 5,
            dots: false,
            loop: false,
            autoplay: false,
            arrows: false,
            margin: 0,
            adaptiveHeight: true,
            responsive: [{
                breakpoint: 993,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
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
            updateIndex(); // Index değerini güncelle
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
            console.log(index2);
            $('#listingDetailsSlider').carousel(parseInt(index2));
        });


        // Büyük görsel kaydığında küçük görselleri de eşleştirme
        // $('#listingDetailsSlider').on('slid.bs.carousel', function() {
        //     var index = $('#listingDetailsSlider .carousel-item.active').attr('data-slide-number');
        //     // $('.pagination .page-item-middle .page-link').text(index);
        //     $('.listingDetailsSliderNav').slick('slickGoTo', index);
        //     var smallIndex = $('#listingDetailsSlider .active').data('slide-number');
        // });
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
    <link rel="stylesheet" href="{{ asset('css/project.css') }}">




</body>



</html>

    