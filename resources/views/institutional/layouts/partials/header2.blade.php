<!DOCTYPE html>
<html lang="tr" dir="ltr">


<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Sana Özel | Emlak Sepette</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Canonical URL için bölüm -->
    @if (isset($canonicalUrl))
        <link rel="canonical" href="canonical-url" />
    @endif

    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::to('/') }}/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.3/themes/base/jquery-ui.min.css"
        integrity="sha512-8PjjnSP8Bw/WNPxF6wkklW6qlQJdWJc/3w/ZQPvZ/1bjVDkrrSqLe9mfPYrMxtnzsXFPc434+u4FHLnLjXTSsg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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

    @yield('css')
    @yield('csss')


</head>

<body>
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
                            <a href="{{ route('index') }}"><img src="{{ URL::to('/') }}/images/emlaksepettelogo.png"
                                    alt=""></a>
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
                                                'icon' => 'fa fa-user',
                                                'text' => 'Hesabım',
                                            ],
                                            [
                                                'url' => route('institutional.sharer.index'),
                                                'icon' => 'fa fa-bookmark',
                                                'text' =>
                                                    Auth::user()->corporate_type == 'Emlak Ofisi'
                                                        ? 'Portföylerim'
                                                        : 'Koleksiyonlarım',
                                            ],
                                            [
                                                'url' => route('institutional.profile.cart-orders'),
                                                'icon' => 'fa fa-shopping-cart',
                                                'text' => 'Siparişlerim',
                                            ],
                                            [
                                                'url' => route('favorites'),
                                                'icon' => 'fa fa-heart',
                                                'text' => 'Favorilerim',
                                            ],
                                            [
                                                'url' => route('client.logout'),
                                                'icon' => 'fa fa-sign-out',
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
                                        'mainLink' => 'Hesabım',
                                        'links' => [
                                            [
                                                'url' => route('institutional.dashboard', [
                                                    'slug' => Str::slug(auth()->user()->name),
                                                    'userID' => auth()->user()->id,
                                                ]),
                                                'icon' => 'fas fa-store',
                                                'text' => 'Mağazam',
                                            ],
                                            [
                                                'url' => route('institutional.index'),
                                                'icon' => 'fa fa-user',
                                                'text' => 'Panelim',
                                            ],
                                            [
                                                'url' =>
                                                    Auth::user()->corporate_type == 'Emlak Ofisi'
                                                        ? route('institutional.housing.list')
                                                        : route('institutional.react.projects'),
                                                'icon' => 'fa fa-home',
                                                'text' => 'İlanlarım',
                                            ],
                                            [
                                                'url' => route('institutional.sharer.index'),
                                                'icon' => 'fa fa-bookmark',
                                                'text' =>
                                                    Auth::user()->corporate_type == 'Emlak Ofisi'
                                                        ? 'Portföylerim'
                                                        : 'Koleksiyonlarım',
                                            ],
                                            [
                                                'url' => url('hesabim/ilan-tipi-sec'),
                                                'icon' => 'fa fa-plus',
                                                'text' => 'İlan Ekle',
                                            ],
                                            [
                                                'url' => route('institutional.profile.cart-orders'),
                                                'icon' => 'fa fa-shopping-cart',
                                                'text' => 'Siparişlerim',
                                            ],
                                            [
                                                'url' => route('favorites'),
                                                'icon' => 'fa fa-heart',
                                                'text' => 'Favorilerim',
                                            ],
                                            [
                                                'url' => route('client.logout'),
                                                'icon' => 'fa fa-sign-out',
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
                                                'icon' => 'fa fa-user',
                                                'text' => 'Hesabım',
                                            ],
                                            [
                                                'url' => route('client.logout'),
                                                'icon' => 'fa fa-sign-out',
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
                        @php
                            $groupedMenuData = [];

                            foreach ($menuData as $menuItem) {
                                $label = $menuItem['label'];

                                // Gruplandırılmış menüyü oluştur
                                if (!isset($groupedMenuData[$label])) {
                                    $groupedMenuData[$label] = [];
                                }

                                // Menü öğesini ilgili gruba ekle
                                $groupedMenuData[$label][] = $menuItem;
                            }
                        @endphp

                        @foreach ($groupedMenuData as $label => $groupedMenu)
                            @php
                                $hasVisibleMenus = false;
                            @endphp
                            @foreach ($groupedMenu as $menuItem)
                                @if ($menuItem['visible'])
                                    @php
                                        $hasVisibleMenus = true;
                                        $applicationCount = null;
                                        $pendingHousingTypes = null;
                                        $pendingProjects = null;
                                        $orderCount = null;
                                        $neighborCount = null;
                                        $reservationsCount = null;
                                        $commentCount = null;

                                        if ($menuItem['key'] == 'EmlakClubApplications') {
                                            $applicationCount =
                                                \App\Models\User::where('has_club', '2')->count() ?: null;
                                        } elseif ($menuItem['key'] == 'NeighborSeeApplications') {
                                            $neighborCount =
                                                \App\Models\NeighborView::where('status', '0')->count() ?: null;
                                        } elseif ($menuItem['key'] == 'Housings') {
                                            $pendingHousingTypes =
                                                \App\Models\Housing::with('city', 'county', 'neighborhood')
                                                    ->where('status', 2)
                                                    ->where('user_id', Auth::user()->id)
                                                    ->leftJoin(
                                                        'housing_types',
                                                        'housing_types.id',
                                                        '=',
                                                        'housings.housing_type_id',
                                                    )
                                                    ->select(
                                                        'housings.id',
                                                        'housings.title AS housing_title',
                                                        'housings.status AS status',
                                                        'housings.address',
                                                        'housings.created_at',
                                                        'housing_types.title as housing_type',
                                                        'housing_types.slug',
                                                        'housings.deleted_at',
                                                        'housings.city_id',
                                                        'housings.county_id',
                                                        'housings.neighborhood_id',
                                                        'housing_types.form_json',
                                                    )
                                                    ->orderByDesc('housings.updated_at')
                                                    ->count() ?:
                                                null;
                                        } elseif ($menuItem['key'] == 'Projects') {
                                            $pendingProjects = \App\Models\Project::where('status', 2)
                                                ->where('user_id', Auth::user()->id)
                                                ->orderByDesc('updated_at')
                                                ->get();
                                        } elseif ($menuItem['key'] == 'GetOrders') {
                                            $orderCount = \App\Models\CartOrder::with('user', 'share', 'price')
                                                ->orderByDesc('created_at')
                                                ->where('status', '0')
                                                ->get();
                                        } elseif ($menuItem['key'] == 'GetReservations') {
                                            $reservationsCount = \App\Models\Reservation::with('user')
                                                ->orderByDesc('created_at')
                                                ->where('status', '0')
                                                ->get();
                                        } elseif ($menuItem['key'] == 'GetHousingComments') {
                                            $commentCount = \App\Models\HousingComment::with('user')
                                                ->orderByDesc('created_at')
                                                ->where('status', '0')
                                                ->get();
                                        }

                                    @endphp


                                    <li>
                                        <a
                                            href="@if (isset($menuItem['subMenu']) && count($menuItem['subMenu']) > 0) #nv-{{ $menuItem['key'] }} @else {{ route($menuItem['url']) }} @endif ">
                                            @if (!empty($menuItem['icon']))
                                                <i class="{{ $menuItem['icon'] }}"></i>
                                            @endif
                                            @if ($menuItem['key'] == 'GetMyCollection')
                                                @if (Auth::user()->corporate_type == 'Emlak Ofisi')
                                                    Portföylerim
                                                @else
                                                    Koleksiyonlarım
                                                @endif
                                            @else
                                                {{ $menuItem['text'] }}
                                            @endif

                                            {{ $applicationCount != null ? "($applicationCount)" : null }}
                                            {{ $neighborCount != null ? "($neighborCount)" : null }}

                                            {{ $pendingHousingTypes != null ? "($pendingHousingTypes)" : null }}
                                            {{ $pendingProjects != null && $pendingProjects->count() != 0 ? '(' . $pendingProjects->count() . ')' : null }}
                                            {{ $orderCount != null ? '(' . $orderCount->count() . ')' : null }}
                                            {{ $reservationsCount != null ? '(' . $reservationsCount->count() . ')' : null }}
                                            {{ $commentCount != null ? '(' . $commentCount->count() . ')' : null }}
                                            @if (isset($menuItem['subMenu']) && count($menuItem['subMenu']) > 0)
                                                <span class="caret"></span>
                                            @endif
                                        </a>

                                        {{-- @if (isset($menuItem['subMenu']) && count($menuItem['subMenu']) > 0)
                                    @include('client.layouts.partials.menu-item', [
                                        'items' => $menuItem['subMenu'],
                                    ])
                                @endif --}}
                                    </li>
                                @endif
                            @endforeach
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
