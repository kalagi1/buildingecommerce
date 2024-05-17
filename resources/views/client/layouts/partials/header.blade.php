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
        <meta property="og:url"content="https://emlaksepette.com/" />
        <meta property="og:type"content="website" />
        <meta property="og:title"content="{{ $pageInfo->meta_title }}" />
        <meta property="og:description"content="{{ $pageInfo->meta_description }}" />
        @php
            $imageUrl = $pageInfo->meta_image ?? 'https://emlaksepette.com/images/mini_logo.png';
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
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/styles.css?v=2">
    <link rel="stylesheet" id="color" href="{{ URL::to('/') }}/css/colors/dark-gray.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@600&display=swap" rel="stylesheet">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">

    @yield('styles')

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
            background: green;
            margin-bottom: 10px;
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
            color: #e54242 !important;
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

<body class="m0a homepage-2 the-search hd-white inner-pages">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-55Q6HGHL" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!-- Wrapper -->
    <div id="wrapper">
        @if (request()->routeIs('index'))
            <div class="slick-lancersl">
                @foreach ($adBanners as $adBanner)
                    <div class="home-top-banner d-xl-block d-none d-lg-block"
                        style="background-color: {{ $adBanner->background_color }};padding:0 !important">
                        <img src="{{ asset("storage/{$adBanner->image}") }}" alt="Reklam Bannerı">
                    </div>
                @endforeach
            </div>
        @endif

        <!-- START SECTION HEADINGS -->
        <!-- Header Container
        ================================================== -->

        <header id="header-container">
            <div class="container">
                <div class="header-center">
                    <div class="d-flex justify-content-between align-items-center" style="padding-top:12px !important">
                        <div class="leftSide">
                            <div class="mmenu-trigger d-xl-none d-block d-lg-none ">
                                <button class="hamburger hamburger--collapse" type="button">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                            <div id="logo">
                                <a href="{{ route('index') }}"><img
                                        src="{{ URL::to('/') }}/images/emlaksepettelogo.png" alt=""></a>
                            </div>

                        </div>
                        <div class="center position-relative searchInput">
                            <form action="{{ route('search.index') }}" method="GET" id="search-form2">
                                @csrf
                                <div class="input-group search ml-3 d-xl-flex d-none d-lg-flex">
                                    <input type="text" name="searchTerm" class="ss-box" placeholder="Ara ..">
                                    <button type="submit" class="fa fa-search btn btn-primary" id="search-icon2"
                                        onclick="return validateForm2()"></button>
                                </div>
                            </form>

                            <script>
                                function validateForm2() {
                                    var searchTerm = document.getElementById("search-form2").elements["searchTerm"].value;
                                    if (searchTerm.trim() === "") {
                                        return false; // Form post edilmez
                                    }
                                    return true; // Form post edilir
                                }
                            </script>


                            <div class="header-search-box d-none flex-column position-absolute ml-3 bg-white border-bottom border-left border-right"
                                style="top: 100%; z-index: 100; width:160% ; gap: 12px;z-index:9999;max-height: 269px;
                                overflow-y: scroll;">
                            </div>
                        </div>
                        <div class="rightSide d-xl-block d-none d-lg-block ">
                            <div class="header-widget d-flex">

                                @auth
                                    @php
                                        $notifications = App\Models\DocumentNotification::with('user')
                                            ->orderBy('created_at', 'desc')
                                            ->where('readed', 0)
                                            ->where('owner_id', Auth::user()->id)
                                            ->get();
                                    @endphp


                                    @if (auth()->user()->type == 1)
                                        @include('client.layouts.partials.dropdown_user_icon', [
                                            'mainLink' => 'Hesabım',
                                            'links' => [
                                                [
                                                    'url' => route('institutional.index'),
                                                    'icon' => 'fa-user',
                                                    'text' => 'Hesabım',
                                                ],
                                                [
                                                    'url' => route('institutional.sharer.index'),
                                                    'icon' => 'fa-bookmark',
                                                    'text' =>
                                                        Auth::user()->corporate_type == 'Emlak Ofisi'
                                                            ? 'Portföylerim'
                                                            : 'Koleksiyonlarım',
                                                ],
                                                [
                                                    'url' => route('institutional.profile.cart-orders'),
                                                    'icon' => 'fa-shopping-cart',
                                                    'text' => 'Siparişlerim',
                                                ],
                                                [
                                                    'url' => route('favorites'),
                                                    'icon' => 'fa-heart',
                                                    'text' => 'Favorilerim',
                                                ],
                                                [
                                                    'url' => route('client.logout'),
                                                    'icon' => 'fa-sign-out',
                                                    'text' => 'Çıkış Yap',
                                                ],
                                            ],
                                        ])

                                        <a href="{{ route('cart') }}"
                                            style="    border-left: 1px solid #666;
                                        padding-left: 15px;
                                        border-right: 1px solid #666;
                                        padding-right: 15px;
                                    }">
                                            @include('client.layouts.partials.cart_icon', [
                                                'text' => 'Sepetim',
                                            ])
                                        </a>
                                    @elseif (auth()->user()->type != 1 &&
                                            auth()->user()->parent_id != 4 &&
                                            auth()->user()->type != 3 &&
                                            auth()->user()->type != 21)
                                        @include('client.layouts.partials.dropdown_user_icon', [
                                            'mainLink' => 'Mağazam',
                                            'links' => [
                                                [
                                                    'url' => route('institutional.index'),
                                                    'icon' => 'fa-user',
                                                    'text' => 'Hesabım',
                                                ],
                                                [
                                                    'url' => route('institutional.react.projects'),
                                                    'icon' => 'fa-home',
                                                    'text' => 'İlanlarım',
                                                ],
                                                [
                                                    'url' => route('institutional.sharer.index'),
                                                    'icon' => 'fa-bookmark',
                                                    'text' =>
                                                        Auth::user()->corporate_type == 'Emlak Ofisi'
                                                            ? 'Portföylerim'
                                                            : 'Koleksiyonlarım',
                                                ],
                                                [
                                                    'url' => url('hesabim/ilan-tipi-sec'),
                                                    'icon' => 'fa-plus',
                                                    'text' => 'İlan Ekle',
                                                ],
                                                [
                                                    'url' => route('institutional.profile.cart-orders'),
                                                    'icon' => 'fa-shopping-cart',
                                                    'text' => 'Siparişlerim',
                                                ],
                                                [
                                                    'url' => route('favorites'),
                                                    'icon' => 'fa-heart',
                                                    'text' => 'Favorilerim',
                                                ],
                                                [
                                                    'url' => route('client.logout'),
                                                    'icon' => 'fa-sign-out',
                                                    'text' => 'Çıkış Yap',
                                                ],
                                            ],
                                        ])
                                        <a href="{{ route('cart') }}"
                                            style="border-left: 1px solid #666;
                                         padding-left: 15px;
                                         border-right: 1px solid #666;
                                         padding-right: 15px;">
                                            @include('client.layouts.partials.cart_icon', [
                                                'text' => 'Sepetim',
                                            ])
                                        </a>
                                    @elseif (auth()->user()->type == 3 || auth()->user()->parent_id == 4)
                                        @include('client.layouts.partials.dropdown_user_icon', [
                                            'mainLink' => 'Yönetim',
                                            'links' => [
                                                [
                                                    'url' => route('admin.index'),
                                                    'icon' => 'fa-user',
                                                    'text' => 'Hesabım',
                                                ],
                                                [
                                                    'url' => route('client.logout'),
                                                    'icon' => 'fa-sign-out',
                                                    'text' => 'Çıkış Yap',
                                                ],
                                            ],
                                        ])
                                    @endif
                                @else
                                    <div class="userIconWrapper">
                                        <a href="{{ route('client.login') }}" class="userIcon">
                                            @include('client.layouts.partials.user_icon', [
                                                'text' => 'Giriş Yap',
                                            ])
                                        </a>
                                        <div class="new-login-dropdown">
                                            <div class="user-notloggedin-container container-padding">
                                                <div class="login-button"> <a href="{{ route('client.login') }}"
                                                        class="userIcon"
                                                        style="color: white;
                                                    text-align: center;
                                                    justify-content: center;
                                                    margin-right:0 !important">
                                                        Giriş Yap
                                                    </a></div>
                                                <div class="signup-button signup-button-container"><a
                                                        href="{{ url('giris-yap?uye-ol=/') }}" class="userIcon"
                                                        style="color: black;
                                                    text-align: center;
                                                    justify-content: center; margin-right:0 !important">
                                                        Üye Ol
                                                    </a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('cart') }}"
                                        style="border-left: 1px solid #666;
                                    padding-left: 15px;">
                                        @include('client.layouts.partials.cart_icon', [
                                            'text' => 'Sepetim',
                                        ])
                                    </a>
                                @endauth


                                @if (Auth::check())
                                    <div class="notification">
                                        <div class="notBtn">
                                            @php
                                                $unreadNotifications = $notifications->where('readed', 0);
                                                $unreadCount = $unreadNotifications->count();
                                            @endphp

                                            @if ($unreadCount)
                                                <div class="number">{{ $unreadCount }}</div>
                                            @endif


                                            <i class="fas fa-bell"></i>
                                            <div class="box">
                                                <div class="display">
                                                    <div class="card position-relative border-0">
                                                        <div class="card-header p-2">
                                                            <div class="d-flex justify-content-between">
                                                                <h5 class="text-black mb-0" style="font-size:12px">
                                                                    Bildirimler</h5>
                                                                <a href="{{ route('markAllAsRead') }}">
                                                                    Tümünü Oku
                                                                </a>
                                                            </div>

                                                        </div>
                                                        <div class="card-body p-0">
                                                            <div class="scrollbar-overlay" style="height: 27rem;">
                                                                <div class="border-300">
                                                                    @if (count($notifications) == 0)
                                                                        <span class="p-3 text-center">Bildirim
                                                                            Yok</span>
                                                                    @else
                                                                        @foreach ($notifications as $notification)
                                                                            <div class="px-2 px-sm-3 py-3 border-300 notification-card position-relative {{ $notification->readed == 0 ? 'unread' : 'read' }} border-bottom"
                                                                                data-id="{{ $notification->id }}"
                                                                                data-link="{{ $notification->link }}">
                                                                                <div
                                                                                    class="d-flex align-items-center justify-content-between position-relative">
                                                                                    <div class="d-flex">
                                                                                        <div class="avatar avatar-m status-online me-3"
                                                                                            style="width:45px !important">
                                                                                            <img class="rounded-circle avatar-placeholder"
                                                                                                style="max-width:40px !important"
                                                                                                src="https://prium.github.io/phoenix/v1.14.0/assets/img/team/40x40/avatar.webp"
                                                                                                alt="">
                                                                                        </div>
                                                                                        <div class="flex-1 me-sm-3">
                                                                                            <h4 class="fs-9 text-body-emphasis"
                                                                                                style="font-size: 11px;text-align:left;margin-bottom:0 !important">
                                                                                                {{ Auth::user()->name }}
                                                                                            </h4>
                                                                                            <p
                                                                                                class="fs--1 text-1000 mb-2 mb-sm-3 fw-normal">
                                                                                                {!! $notification->text !!}
                                                                                            </p>
                                                                                            @php
                                                                                                $notificationCreatedAt =
                                                                                                    $notification->created_at;
                                                                                                date_default_timezone_set(
                                                                                                    'Europe/Istanbul',
                                                                                                );
                                                                                                $notificationCreatedAtDate = date(
                                                                                                    'd.m.Y',
                                                                                                    strtotime(
                                                                                                        $notificationCreatedAt,
                                                                                                    ),
                                                                                                );
                                                                                                $notificationCreatedAtTime = date(
                                                                                                    'H:i',
                                                                                                    strtotime(
                                                                                                        $notificationCreatedAt,
                                                                                                    ),
                                                                                                );
                                                                                                $notificationCreatedAtTime12Hour = date(
                                                                                                    'h:i A',
                                                                                                    strtotime(
                                                                                                        $notificationCreatedAt,
                                                                                                    ),
                                                                                                );
                                                                                            @endphp
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $userType = Auth::user()->type;
                                    @endphp

                                    @php
                                        $link = '';
                                        $text = '';

                                        switch ($userType) {
                                            case 2:
                                                $link = url('hesabim/ilan-tipi-sec');
                                                $text = 'İlan Ekle';
                                                break;
                                            case 3:
                                                $link = url('qR9zLp2xS6y/secured/');
                                                $text = 'Yönetim';
                                                break;
                                            default:
                                                $link = url('sat-kirala-nedir/');
                                                $text = 'Sat Kirala';
                                        }
                                    @endphp
                                    <a href="{{ url('/emlak-kulup') }}">
                                        <button type="button" class=" newButtonStyle ml-2">
                                            <span class="buyUserRequest__text newButtonStyle__text"><img
                                                    src="{{ URL::to('/') }}/emlakkulüplogo.png" alt="">
                                                Emlak Kulüp</span>
                                        </button>
                                    </a>
                                    <a href="{{ $link }}">
                                        <button type="button" class="buyUserRequest ml-3">
                                            <span class="buyUserRequest__text">{{ $text }}</span>
                                            <span class="buyUserRequest__icon">
                                                <img src="{{ asset('sc.png') }}" alt="" srcset="">
                                            </span>
                                        </button>
                                    </a>
                                @else
                                    @auth
                                        <a href="{{ url('/emlak-kulup') }}">
                                            <button type="button" class=" newButtonStyle ml-4">
                                                <span class="buyUserRequest__text newButtonStyle__text"><img
                                                        src="{{ URL::to('/') }}/emlakkulüplogo.png" alt="">
                                                    Emlak Kulüp</span>
                                            </button>
                                        </a>
                                        <a href="{{ route('real.estate.index2') }}">
                                            <button type="button" class="buyUserRequest ml-3">
                                                <span class="buyUserRequest__text"> Sat Kirala</span>
                                                <span class="buyUserRequest__icon">
                                                    <img src="{{ asset('sc.png') }}" alt="" srcset="">
                                                </span>
                                            </button>
                                        </a>
                                    @else
                                        <a href="{{ url('/emlak-kulup') }}">
                                            <button type="button" class=" newButtonStyle ml-4">
                                                <span class="buyUserRequest__text newButtonStyle__text"><img
                                                        src="{{ URL::to('/') }}/emlakkulüplogo.png" alt="">
                                                    Emlak Kulüp</span>
                                            </button>
                                        </a>
                                        <a href="{{ url('/sat-kirala-nedir') }}">
                                            <button type="button" class="buyUserRequest ml-3">
                                                <span class="buyUserRequest__text"> Sat Kirala</span>
                                                <span class="buyUserRequest__icon">
                                                    <img src="{{ asset('sc.png') }}" alt="" srcset="">
                                                </span>
                                            </button>
                                        </a>
                                    @endauth
                                @endif



                            </div>
                        </div>

                    </div>
                </div>
                <div class="header-bottom d-xl-block d-none d-lg-block mb-0">
                    <nav id="navigation" class="style-1">
                        <ul id="responsive">
                            @foreach ($menu as $menuItem)
                                <li>
                                    <a href="{{ $menuItem['href'] }}">
                                        @if (!empty($menuItem['icon']))
                                            <i class="{{ $menuItem['icon'] }}"></i>
                                        @endif
                                        {{ $menuItem['text'] }}
                                        @if (!empty($menuItem['children']))
                                            <span class="caret"></span>
                                        @endif
                                    </a>

                                    @if (!empty($menuItem['children']))
                                        @include('client.layouts.partials.menu-item', [
                                            'items' => $menuItem['children'],
                                        ])
                                    @endif
                                </li>
                            @endforeach

                            {{-- @foreach ($headerLinks as $link)
                                <li>
                                    <a href="{{ url('sayfa/' . $link->slug) }}">
                                        {{ $link->meta_title }}
                                    </a>
                                </li>
                            @endforeach --}}
                            <li class="club-items mobile-show">
                                <a href="{{ url('/emlak-kulup') }}">
                                    <b style="font-weight:800 !important;display:flex">
                                        <img style="" class="lazy entered loading clubStyles"
                                            src="{{ url('emlakkulüplogo.png') }}" alt="Yeniler"
                                            data-ll-status="loading">
                                        EMLAK KULÜP</b>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>


            </div>


        </header>
        <div class=" d-lg-none search-style">
            <form action="{{ route('search.index') }}" method="GET" id="search-form">
                @csrf
                <div class="input-group search ml-3 d-xl-flex d-lg-flex"
                    style="
                    width: 100%;
                margin: 0 auto;
                display: flex;
                justify-content: center;
                padding: 0;
                margin-left: 0 !important;">
                    <input type="text" name="searchTerm" class="ss-box" placeholder="Ara ..">
                    <button type="submit" class="fa fa-search btn btn-primary" id="search-icon"
                        onclick="return validateForm()"></button>
                </div>
            </form>


            <script>
                function validateForm() {
                    var searchTerm = document.getElementById("search-form").elements["searchTerm"].value;
                    if (searchTerm.trim() === "") {
                        return false; // Form post edilmez
                    }
                    return true; // Form post edilir
                }
            </script>

            <div class="header-search-box flex-column position-absolute ml-3 bg-white border-bottom border-left border-right"
                style="    top: 100%;
                z-index: 100;
                width: 100%;
                gap: 12px;
                max-height: 296px;
                overflow-y: scroll;
                margin-left: 0 !important;">
            </div>

        </div>
        <div class="clearfix"></div>

        <div id="preloader">
            <div id="status">
                <div class="status-mes"></div>
            </div>
        </div>
