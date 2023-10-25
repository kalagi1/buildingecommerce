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
    @else
        <meta name="description" content="Emlak Sepeti">
        <meta name="author" content="">
        <title>Emlak Sepeti</title>
    @endif


    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
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
    <style>
        .swal2-container.swal2-center {
            z-index: 9999999;
        }

        .swal2-popup {
            z-index: 9999999;
        }

        @media (max-width:768px) {
            .brand-head .navbar-item {
                padding: 13px !important
            }
        }
    </style>
</head>

<body class="m0a homepage-2 the-search hd-white inner-pages">
    <!-- Wrapper -->
    <div id="wrapper">
        @if (request()->routeIs('index'))
            <div class="slick-lancersl">
                @foreach ($adBanners as $adBanner)
                    <div class="home-top-banner d-xl-block d-none d-lg-block"
                        style="background-color: {{ $adBanner->background_color }}">
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
                            <div class="input-group search ml-3 d-xl-flex d-none d-lg-flex">
                                <input type="text" id="ss-box" placeholder="Ara ..">
                                <i class="fa fa-search"></i>
                            </div>
                            <div class="header-search-box d-none flex-column position-absolute ml-3 bg-white border-bottom border-left border-right"
                                style="top: 100%; z-index: 100; width: calc(100% - 1rem); gap: 12px; max-height: 296px;">
                            </div>
                        </div>
                        <div class="rightSide d-xl-block d-none d-lg-block ">
                            <div class="header-widget d-flex">
                                @if (Auth::user())
                                    @if (Auth::user()->type == 1)
                                        <a href="{{ route('client.index') }}" class="userIcon">
                                            <svg viewBox="0 0 24 24" width="24" height="24"
                                                stroke="currentColor" stroke-width="2" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                            </svg>
                                            <span class="d-xl-block d-none d-lg-block rightNavText">Hesabım</span> </a>
                                    @elseif (Auth::user()->type != 1 && Auth::user()->type != 3)
                                        <div class="dropdown hover">
                                            <a href="javascript:void()" class="userIcon">
                                                <svg viewBox="0 0 24 24" width="24" height="24"
                                                    stroke="currentColor" stroke-width="2" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="css-i6dzq1">
                                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                                </svg>
                                                <span class="d-xl-block d-none d-lg-block rightNavText">Mağazam</span>
                                                <ul>
                                                    <li><a href="{{ route('institutional.index') }}"><i
                                                                class="fa fa-user"></i> Hesabım</a>
                                                    </li>
                                                    <li><a href="{{ route('institutional.projects.index') }}"><i
                                                                class="fa fa-home"></i> İlanlarım</a>
                                                    </li>
                                                    <li><a href="{{ url('institutional/create_project_v2') }}"> <i
                                                                class="fa fa-plus"></i> İlan
                                                            Ekle</a></li>
                                                    <li><a href="{{ route('client.logout') }}"> <i
                                                                class="fa fa-sign-out"></i> Çıkış Yap</a></li>
                                                </ul>
                                            </a>
                                        </div>
                                    @elseif (Auth::user()->type == 3)
                                        <a href="{{ route('admin.index') }}" target="_blank" class="userIcon">
                                            <svg viewBox="0 0 24 24" width="24" height="24"
                                                stroke="currentColor" stroke-width="2" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                            </svg>
                                            <span class="d-xl-block d-none d-lg-block rightNavText">Admin</span> </a>
                                    @endif
                                @else
                                    <a href="{{ route('client.login') }}" class="userIcon"><svg viewBox="0 0 24 24"
                                            width="24" height="24" stroke="currentColor" stroke-width="2"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round"
                                            class="css-i6dzq1">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <span class="d-xl-block d-none d-lg-block rightNavText">Giriş Yap</span></a>
                                    <a href="{{ route('cart') }}">
                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                            stroke-width="2" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" class="css-i6dzq1">
                                            <circle cx="9" cy="21" r="1"></circle>
                                            <circle cx="20" cy="21" r="1"></circle>
                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6">
                                            </path>
                                        </svg>
                                        <span class="d-xl-block d-none d-lg-block rightNavText">Sepetim</span></a>


                                @endif


                                @if (Auth::check())
                                    <a href="{{ route('favorites') }}" class="heartIcon">
                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                            stroke-width="2" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" class="css-i6dzq1">
                                            <path
                                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                            </path>
                                        </svg>
                                        <span class="d-xl-block d-none d-lg-block rightNavText">Favoriler</span></a>
                                    <a href="{{ route('cart') }}">
                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                            stroke-width="2" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" class="css-i6dzq1">
                                            <circle cx="9" cy="21" r="1"></circle>
                                            <circle cx="20" cy="21" r="1"></circle>
                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6">
                                            </path>
                                        </svg>
                                        <span class="d-xl-block d-none d-lg-block rightNavText">Sepetim</span></a>
                                @endif

                                @if (Auth::check())
                                    @if (Auth::user()->type == 2)
                                        <a href="{{ url('institutional/create_project_v2') }}">
                                            <button type="button" class="buyUserRequest ml-3">
                                                <span class="buyUserRequest__text"> İlan Ekle</span>
                                                <span class="buyUserRequest__icon">
                                                    <img src="{{ asset('sc.png') }}" alt="" srcset="">
                                                </span>
                                            </button></a>
                                    @elseif (Auth::check() && Auth::user()->type == 1)
                                        <button type="button" class="buyUserRequest ml-3">
                                            <span class="buyUserRequest__text"> Sat Kirala</span>
                                            <span class="buyUserRequest__icon">
                                                <img src="{{ asset('sc.png') }}" alt="" srcset="">
                                            </span>
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('client.login') }}">
                                        <button type="button" class="buyUserRequest ml-3">
                                            <span class="buyUserRequest__text"> Sat Kirala</span>
                                            <span class="buyUserRequest__icon">
                                                <img src="{{ asset('sc.png') }}" alt="" srcset="">
                                            </span>
                                        </button></a>

                                @endif


                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-bottom d-xl-block d-none d-lg-block">
                    <nav id="navigation" class="style-1">
                        <ul id="responsive">
                            @foreach ($menu as $key => $menuItem)
                                <li>
                                    <a href="{{ $menuItem['href'] }}">
                                        @if (!empty($menuItem['icon']))
                                            <i class="{{ $menuItem['icon'] }}"></i> <!-- İkonu eklemek için -->
                                        @endif
                                        {{ $menuItem['text'] }}
                                        @if (isset($menuItem['children']) && count($menuItem['children']) > 0)
                                            <span class="caret"></span>
                                        @endif

                                    </a>
                                    @if (isset($menuItem['children']) && count($menuItem['children']) > 0)
                                        <ul>
                                            @foreach ($menuItem['children'] as $childItem)
                                                <li>
                                                    <a href="{{ $childItem['href'] }}">
                                                        @if (!empty($childItem['icon']))
                                                            <i class="{{ $childItem['icon'] }}"></i>
                                                        @endif
                                                        {{ $childItem['text'] }}
                                                    </a>
                                                    @if ($childItem['children'] && count($childItem['children']) > 0)
                                                        <ul>
                                                            @foreach ($childItem['children'] as $subChildItem)
                                                                <li>
                                                                    <a href="{{ $subChildItem['href'] }}">
                                                                        @if (!empty($subChildItem['icon']))
                                                                            <i
                                                                                class="{{ $subChildItem['icon'] }}"></i>
                                                                            <!-- İkonu eklemek için -->
                                                                        @endif
                                                                        {{ $subChildItem['text'] }}
                                                                    </a>
                                                                    @if ($subChildItem['children'] && count($subChildItem['children']) > 0)
                                                                        <ul>
                                                                            @foreach ($subChildItem['children'] as $subofsubChildItem)
                                                                                <li>
                                                                                    <a
                                                                                        href="{{ $subofsubChildItem['href'] }}">
                                                                                        @if (!empty($subofsubChildItem['icon']))
                                                                                            <i
                                                                                                class="{{ $subofsubChildItem['icon'] }}"></i>
                                                                                            <!-- İkonu eklemek için -->
                                                                                        @endif
                                                                                        {{ $subofsubChildItem['text'] }}
                                                                                    </a>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
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
                    <div class="header-search-box-mobile d-none flex-column position-absolute bg-white border-bottom border-left border-right"
                        style="top: 100%; z-index: 100; width: 100%; gap: 12px; max-height: 296px;">
                    </div>
                </div>
            </div>


        </header>
        <div class="clearfix"></div>



        <style>
            a {
                text-decoration: none !important;
            }

            .buyUserRequest {
                position: relative;
                width: 150px;
                height: 35px;
                cursor: pointer;
                display: flex;
                align-items: center;
                border: 1px solid #EA2B2E;
                background-color: #EA2B2E;
            }

            .buyUserRequest,
            .buyUserRequest__icon,
            .buyUserRequest__text {
                transition: all 0.3s;
            }

            .buyUserRequest .buyUserRequest__text {
                transform: translateX(20px);
                color: #fff;
                font-weight: 600;
                line-height: 14px;
            }

            .buyUserRequest .buyUserRequest__icon {
                position: absolute;
                transform: translateX(109px);
                height: 100%;
                width: 39px;
                background-color: black;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .buyUserRequest img {
                width: 30px;
                stroke: #fff;
            }

            .buyUserRequest:hover {
                background: #EA2B2E;
            }

            .buyUserRequest:hover .buyUserRequest__text {
                color: transparent;
            }

            .buyUserRequest:hover .buyUserRequest__icon {
                width: 148px;
                transform: translateX(0);
            }

            .buyUserRequest:active .buyUserRequest__icon {
                background-color: #EA2B2E;
            }

            .buyUserRequest:active {
                border: 1px solid #EA2B2E;
            }


            .cartIconBtn {
                padding: 5px 10px;
                height: 100%;
                background-color: black
            }

            .cartTextBtn {
                padding: 5px 10px;
                height: 100%;
                background-color: red
            }

            @media (max-width: 768px) {
                .buyUserRequest {
                    width: 80px !important;
                }

                .buyUserRequest .buyUserRequest__text {
                    transform: translateX(5px) !important
                }

                .buyUserRequest__icon {
                    display: none !important;

                }

                .cartIconBtn {
                    padding: 2px;
                    height: 100%;
                    background-color: black
                }

                .cartTextBtn {
                    padding: 2px;
                    height: 100%;
                    background-color: red
                }
            }

            .dropdown ul {
                width: 200px !important;
                text-align: left;
                list-style-type: none;
                display: block;
                z-index: 999;
                margin: 0;
                margin-top: 10px;
                padding: 0;
                position: absolute;
                width: 100%;
                box-shadow: 0 6px 5px -5px rgba(0, 0, 0, 0.3);
                overflow: hidden;
            }

            .dropdown li a,
            .dropdown.toggle>label {
                display: block;
                padding: 0 0 0 10px;
                background: white;
                text-decoration: none;
                line-height: 40px;
                font-size: 13px;
                font-weight: 600;
                font-weight: bold;
                color: black background-color: #FFF;
            }

            .dropdown li {
                height: 0;
                overflow: hidden;
                transition: all 500ms;
            }

            .dropdown.hover li {
                transition-delay: 300ms;
            }

            .dropdown li:first-child a {
                border-radius: 2px 2px 0 0;
            }

            .dropdown li:last-child a {
                border-radius: 0 0 2px 2px;
            }

            .dropdown li:first-child a::before {
                content: "";
                display: block;
                position: absolute;
                width: 0;
                height: 0;
                border-left: 10px solid transparent;
                border-right: 10px solid transparent;
                border-bottom: 10px solid #FFF;
                margin: -10px 0 0 30px;
            }

            .dropdown li a:hover,
            .dropdown.toggle>label:hover,
            .dropdown.toggle>input:checked~label {
                background-color: #EEE;
            }

            .dropdown>li>a:hover::after,
            .dropdown.toggle>label:hover::after,
            .dropdown.toggle>input:checked~label::after {
                border-top-color: #AAA;
            }

            .buyUserRequestBtn {
                padding: 0;
                background: Black !important;
                border: none;
                border-radius: 0 !important
            }

            .buyUserRequestBtn:hover {
                background: black !important
            }


            .dropdown li:first-child a:hover::before {
                border-bottom-color: #EEE;
            }

            .dropdown.hover:hover li,
            .dropdown.toggle>input:checked~ul li {
                height: 40px;
            }

            .dropdown.hover:hover li:first-child,
            .dropdown.toggle>input:checked~ul li:first-child {
                padding-top: 15px;
            }
        </style>
