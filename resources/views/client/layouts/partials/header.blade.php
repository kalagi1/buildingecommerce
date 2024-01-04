<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    @if (isset($pageInfo))
        <meta name="keywords" content="{{ $pageInfo->meta_keywords }}">
        <meta name="description" content="{{ $pageInfo->meta_description }}">
        <meta name="author" content="{{ $pageInfo->meta_author }}">
        <title>{{ $pageInfo->meta_title }}</title>
    @endif


    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::to('/') }}/favicon.png">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/jquery-ui.css">
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
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/styles.css">
    <link rel="stylesheet" id="color" href="{{ URL::to('/') }}/css/colors/dark-gray.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@600&display=swap" rel="stylesheet">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">

    @yield('styles')
</head>

<body class="m0a homepage-2 the-search hd-white inner-pages">
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
                    <div class="d-flex justify-content-between align-items-center">
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
                        <div class="center position-relative">
                            <form action="{{ route('search.results') }}" method="GET" id="search-form">
                                @csrf
                                <div class="input-group search ml-3 d-xl-flex d-none d-lg-flex">
                                    <input type="text" name="searchTerm" id="ss-box" placeholder="Ara ..">
                                    <button type="submit" class="fa fa-search btn btn-primary"
                                        id="search-icon"></button>
                                </div>
                            </form>

                            <div class="header-search-box d-none flex-column position-absolute ml-3 bg-white border-bottom border-left border-right"
                                style="top: 100%; z-index: 100; width: calc(100% - 1rem); gap: 12px; max-height: 296px;">
                            </div>
                        </div>
                        <div class="rightSide d-xl-block d-none d-lg-block ">
                            <div class="header-widget d-flex">

                                @auth
                                    @php
                                        $notifications = App\Models\DocumentNotification::with('user')
                                            ->orderBy('created_at', 'desc')
                                            ->where('owner_id', Auth::user()->id)
                                            ->limit(10)
                                            ->get();
                                    @endphp


                                    @if (auth()->user()->type == 1)
                                        <a href="{{ route('client.index') }}" style="padding-right: 15px;">
                                            @include('client.layouts.partials.user_icon', [
                                                'text' => 'Hesabım',
                                            ])
                                        </a>

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
                                    @elseif (auth()->user()->type != 1 && auth()->user()->type != 3)
                                        @include('client.layouts.partials.dropdown_user_icon', [
                                            'mainLink' => 'Mağazam',
                                            'links' => [
                                                [
                                                    'url' => route('institutional.projects.index'),
                                                    'icon' => 'fa-user',
                                                    'text' => 'Hesabım',
                                                ],
                                                [
                                                    'url' => route('institutional.projects.index'),
                                                    'icon' => 'fa-home',
                                                    'text' => 'İlanlarım',
                                                ],
                                                [
                                                    'url' => url('institutional/ilan-tipi-sec'),
                                                    'icon' => 'fa-plus',
                                                    'text' => 'İlan Ekle',
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
                                    @elseif (auth()->user()->type == 3)
                                        <a href="{{ url('admin/') }}"
                                            style="
                                        border-right: 1px solid #666;
                                        padding-right: 15px;">
                                            @include('client.layouts.partials.user_icon', [
                                                'text' => 'Admin',
                                            ])
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('client.login') }}" class="userIcon">
                                        @include('client.layouts.partials.user_icon', [
                                            'text' => 'Giriş Yap',
                                        ])
                                    </a>
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
                                                                                        <div
                                                                                            class="avatar avatar-m status-online me-3" style="width:45px !important">
                                                                                            <img class="rounded-circle avatar-placeholder"
                                                                                            style="max-width:40px !important"
                                                                                                src="https://prium.github.io/phoenix/v1.14.0/assets/img/team/40x40/avatar.webp"
                                                                                                alt=""></div>
                                                                                        <div class="flex-1 me-sm-3">
                                                                                            <h4 class="fs-9 text-body-emphasis" style="font-size: 11px;text-align:left;margin-bottom:0 !important">{{Auth::user()->name}}</h4>
                                                                                            <p
                                                                                                class="fs--1 text-1000 mb-2 mb-sm-3 fw-normal">
                                                                                                {!! $notification->text !!}
                                                                                            </p>
                                                                                            @php
                                                                                                $notificationCreatedAt = $notification->created_at;
                                                                                                date_default_timezone_set('Europe/Istanbul');
                                                                                                $notificationCreatedAtDate = date('d.m.Y', strtotime($notificationCreatedAt));
                                                                                                $notificationCreatedAtTime = date('H:i', strtotime($notificationCreatedAt));
                                                                                                $notificationCreatedAtTime12Hour = date('h:i A', strtotime($notificationCreatedAt));
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
                                                $link = url('institutional/ilan-tipi-sec');
                                                $text = 'İlan Ekle';
                                                break;
                                            case 3:
                                                $link = url('admin/');
                                                $text = 'Yönetim';
                                                break;
                                            default:
                                                $link = url('sat-kirala/');
                                                $text = 'Sat Kirala';
                                        }
                                    @endphp

                                    <a href="{{ $link }}">
                                        <button type="button" class="buyUserRequest ml-3">
                                            <span class="buyUserRequest__text">{{ $text }}</span>
                                            <span class="buyUserRequest__icon">
                                                <img src="{{ asset('sc.png') }}" alt="" srcset="">
                                            </span>
                                        </button>
                                    </a>
                                @else
                                    <a href="{{ route('satKirala') }}">
                                        <button type="button" class="buyUserRequest ml-3">
                                            <span class="buyUserRequest__text"> Sat Kirala</span>
                                            <span class="buyUserRequest__icon">
                                                <img src="{{ asset('sc.png') }}" alt="" srcset="">
                                            </span>
                                        </button>
                                    </a>
                                @endif




                            </div>
                        </div>

                    </div>
                </div>
                <div class="header-bottom d-xl-block d-none d-lg-block">
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

                            @foreach ($headerLinks as $link)
                                <li>
                                    <a href="{{ url('sayfa/' . $link->slug) }}">
                                        {{ $link->meta_title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>

                <div class="p-0 position-relative d-lg-none">
                    <div class="input-group search">
                        <input type="text" id="ss-box-mobile" placeholder="Ara ..">
                        <i class="fa fa-search"></i>
                    </div>

                </div>
            </div>


        </header>
        <div class="clearfix"></div>

        <div id="preloader">
            <div id="status">
                <div class="status-mes"></div>
            </div>
        </div>
