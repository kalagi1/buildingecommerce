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
        <meta name="description" content="Maliyetine Ev">
        <meta name="author" content="">
        <title>Maliyetine Ev</title>
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

    @yield('styles')
</head>

<body class="m0a homepage-2 the-search hd-white inner-pages">
    <!-- Wrapper -->
    <div id="wrapper">
        <div class="home-top-banner d-xl-block d-none d-lg-block">
            <img src="https://cdn.dsmcdn.com/mrktng/crm/2023/top/jul/t1.jpg" alt="Home Top Banner Görseli">
        </div>
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
                                <a href="{{ route('index') }}"><img src="{{ URL::to('/') }}/images/logo.png"
                                        alt=""></a>
                            </div>
                        </div>
                        <div class="center">
                            <div class="input-group search ml-3 d-xl-flex d-none d-lg-flex">
                                <input type="text" placeholder="Ara ..">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                        <div class="rightSide">
                            <div class="header-widget d-flex">
                                @if (Auth::user())
                                    @if (Auth::user()->type == 1)
                                        <a href="{{ route('client.index') }}"  class="userIcon">
                                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                                stroke-width="2" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round" class="css-i6dzq1">
                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                            </svg>
                                            <span class="d-xl-block d-none d-lg-block rightNavText">Hesabım</span> </a>
                                    @elseif (Auth::user()->type == 2)
                                        <a href="{{ route('institutional.index') }}" target="_blank" class="userIcon">
                                            <svg viewBox="0 0 24 24" width="24" height="24"
                                                stroke="currentColor" stroke-width="2" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                            </svg>
                                            <span class="d-xl-block d-none d-lg-block rightNavText">Hesabım</span> </a>
                                    @elseif (Auth::user()->type == 3)
                                        <a href="{{ route('admin.index') }}" target="_blank" class="userIcon">
                                            <svg viewBox="0 0 24 24" width="24" height="24"
                                                stroke="currentColor" stroke-width="2" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                            </svg>
                                            <span class="d-xl-block d-none d-lg-block rightNavText">Hesabım</span> </a>
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
                                @endif

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
                            </div>
                        </div>
                    </div>
                    <div class="input-group search d-xl-none d-lg-none d-flex">
                        <input type="text" placeholder="Ara ..">
                        <i class="fa fa-search"></i>
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
                                        @if ($key == 0 || $key == 3 || $key == 7)
                                            <span class="new-badge">Yeni</span>
                                        @endif
                                    </a>
                                    @if (isset($menuItem['children']) && count($menuItem['children']) > 0)
                                        <ul>
                                            @foreach ($menuItem['children'] as $childItem)
                                                <li>
                                                    <a href="{{ $childItem['href'] }}">
                                                        @if (!empty($childItem['icon']))
                                                            <i class="{{ $childItem['icon'] }}"></i>
                                                            <!-- İkonu eklemek için -->
                                                        @endif
                                                        {{ $childItem['text'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
            </div>


        </header>
        <div class="clearfix"></div>
