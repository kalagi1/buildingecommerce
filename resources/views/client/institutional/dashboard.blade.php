@extends('client.layouts.master')

@section('content')
    @php

        function getHouse($project, $key, $roomOrder)
        {
            foreach ($project->roomInfo as $room) {
                if ($room->room_order == $roomOrder && $room->name == $key) {
                    return $room;
                }
            }
        }
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

        function getData($housing, $key)
        {
            $housing_type_data = json_decode($housing->housing_type_data);
            $a = $housing_type_data->$key;
            return $a[0];
        }

        function getImage($housing, $key)
        {
            $housing_type_data = json_decode($housing->housing_type_data);
            $a = $housing_type_data->$key;
            return $a;
        }
    @endphp
    <div class="brand-head">
        <div class="container">
            <div class="card mb-3">
                <div class="card-img-top" style="background-color: {{ $store->banner_hex_code }}">
                    <div class="brands-square w-100">
                        <img src="{{ url('storage/profile_images/' . $store->profile_image) }}" alt=""
                            class="brand-logo">
                        <p class="brand-name"><a href="{{ route('instituional.profile', Str::slug($store->name)) }}"
                                style="color:White">
                                {{ $store->name }}
                                <style type="text/css">
                                    .st0 {
                                        fill: #446BB6;
                                    }

                                    .st1 {
                                        opacity: 0.15;
                                    }

                                    .st2 {
                                        fill: #FFFFFF;
                                    }
                                </style>
                                <svg id="Layer_1" style="enable-background:new 0 0 120 120;" version="1.1" width="24px"
                                    height="24px" viewBox="0 0 120 120" xml:space="preserve"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g>
                                        <path class="st0"
                                            d="M99.5,52.8l-1.9,4.7c-0.6,1.6-0.6,3.3,0,4.9l1.9,4.7c1.1,2.8,0.2,6-2.3,7.8L93,77.8c-1.4,1-2.3,2.5-2.7,4.1   l-0.9,5c-0.6,3-3.1,5.2-6.1,5.3l-5.1,0.2c-1.7,0.1-3.3,0.8-4.5,2l-3.5,3.7c-2.1,2.2-5.4,2.7-8,1.2l-4.4-2.6   c-1.5-0.9-3.2-1.1-4.9-0.7l-5,1.2c-2.9,0.7-6-0.7-7.4-3.4l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8   l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8   l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6c1.4-2.7,4.4-4.1,7.4-3.4l5,1.2c1.6,0.4,3.4,0.2,4.9-0.7l4.4-2.6c2.6-1.5,5.9-1.1,8,1.2   l3.5,3.7c1.2,1.2,2.8,2,4.5,2l5.1,0.2c3,0.1,5.6,2.3,6.1,5.3l0.9,5c0.3,1.7,1.3,3.2,2.7,4.1l4.2,2.9C99.7,46.8,100.7,50,99.5,52.8z   " />
                                        <g class="st1">
                                            <path
                                                d="M43.4,93.5l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4    c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6    c0.8-1.6,2.2-2.7,3.7-3.2c-2.7-0.4-5.4,1-6.6,3.5l-2.3,4.6c-0.8,1.5-2.1,2.7-3.7,3.2l-4.8,1.6c-2.9,1-4.7,3.8-4.4,6.8l0.5,5.1    c0.2,1.7-0.3,3.4-1.4,4.7l-3.2,4c-1.9,2.4-1.9,5.7,0,8.1l3.2,4c1.1,1.3,1.6,3,1.4,4.7l-0.5,5.1c-0.3,3,1.5,5.8,4.4,6.8l4.8,1.6    c1.6,0.5,2.9,1.7,3.7,3.2l2.3,4.6c1.4,2.7,4.4,4.1,7.4,3.4l0.6-0.1C46.3,96.7,44.4,95.5,43.4,93.5z" />
                                            <path
                                                d="M60.6,22.5l4.4-2.6c0.4-0.2,0.8-0.4,1.2-0.5c-1.4-0.2-2.9,0.1-4.1,0.8l-4.4,2.6c-0.4,0.2-0.8,0.4-1.2,0.5    C57.9,23.5,59.3,23.3,60.6,22.5z" />
                                            <path d="M81,92c-0.5,0-1,0.1-1.4,0.2l3.6-0.2c0.5,0,0.9-0.1,1.4-0.2L81,92z" />
                                            <path
                                                d="M65,98.9l-4.4-2.6c-1.5-0.9-3.2-1.1-4.9-0.7l-0.6,0.1c0.9,0.1,1.7,0.4,2.5,0.8l4.4,2.6c1.7,1,3.6,1.1,5.4,0.5    C66.6,99.6,65.8,99.4,65,98.9z" />
                                        </g>
                                        <polyline class="st0" points="44,53.6 56.5,67.9 82.1,47.3  " />
                                        <path class="st2"
                                            d="M53.5,75.3c-1.4,0-2.8-0.6-3.8-1.7L37.2,59.3c-1.8-2.1-1.6-5.2,0.4-7.1c2.1-1.8,5.2-1.6,7.1,0.4l9.4,10.7   l21.9-17.6c2.1-1.7,5.3-1.4,7,0.8c1.7,2.2,1.4,5.3-0.8,7L56.6,74.2C55.7,74.9,54.6,75.3,53.5,75.3z" />
                                    </g>
                                </svg>
                            </a></p>
                        {{-- <div class="first-footer">
                            <ul class="netsocials" style="margin-right:30px">
                                @php
                                    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
                                    $host = $_SERVER['HTTP_HOST'];
                                    $uri = $_SERVER['REQUEST_URI'];
                                    $shareUrl = $protocol . '://' . $host . $uri;
                                @endphp
                                <li>
                                    <a href="https://twitter.com/share?url={{ $shareUrl }}">
                                        <i class="fa fa-twitter" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/">
                                        <i class="fa fa-instagram" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="whatsapp://send?text={{ $shareUrl }}">
                                        <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}">
                                        <i class="fa fa-facebook" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </div> --}}
                        @if (Auth::check())
                            @if ($store->id == Auth::user()->id)
                                <a href="{{ url('institutional/create_project_v2') }}" target="_blank"
                                    class="btn btn-primary ml-auto mr-5"> <i class="fa fa-plus"></i> İlan
                                    Ekle</a>
                            @endif
                        @endif

                    </div>
                    <div class="social-square" style="gap: 16px; font-size: 26px !important; padding: 30px 35px;">
                        @php
                            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
                            $host = $_SERVER['HTTP_HOST'];
                            $uri = $_SERVER['REQUEST_URI'];
                            $shareUrl = $protocol . '://' . $host . $uri;
                        @endphp
                        <div class="first-footer">
                            <ul class="netsocials px-2" style="margin-right: 0 !important">
                                @php
                                    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
                                    $host = $_SERVER['HTTP_HOST'];
                                    $uri = $_SERVER['REQUEST_URI'];
                                    $shareUrl = $protocol . '://' . $host . $uri;
                                @endphp
                                <li>
                                    <a href="https://twitter.com/share?url={{ $shareUrl }}">
                                        <i class="fa fa-twitter" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/">
                                        <i class="fa fa-instagram" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="whatsapp://send?text={{ $shareUrl }}">
                                        <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}">
                                        <i class="fa fa-facebook" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <nav class="navbar" style="padding: 0 !important">
                        <div class="navbar-items">
                            <a class="navbar-item active"
                                href="{{ route('instituional.dashboard', Str::slug($store->name)) }}">Anasayfa</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.projects.detail', Str::slug($store->name)) }}">Tüm
                                Projeler</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.profile', Str::slug($store->name)) }}">Satıcı
                                Profili</a>
                        </div>
                        <form class="search-form" action="{{ route('instituional.search') }}" method="GET">
                            @csrf
                            <input class="search-input" type="search" placeholder="Mağazada Ara" id="search-project"
                                aria-label="Search" name="q">
                            <div class="header-search__suggestions">
                                <div class="header-search__suggestions__section">
                                    <h5>Projeler</h5>
                                    <div class="header-search__suggestions__section__items">
                                        @foreach ($store->projects as $item)
                                            <a href="{{ route('project.detail', ['slug' => $item->slug]) }}"
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



    <section class="featured portfolio rec-pro disc bg-white">
        <div class="container">
            <div class="portfolio  col-xl-12">
                <div class="banner-agents">
                    @foreach ($store->banners as $banner)
                        <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                            <div class="landscapes">
                                <div class="project-single">
                                    <div class="project-inner project-head">
                                        <div class="homes">
                                            <!-- homes img -->
                                            <a href="javascript:void()" class="homes-img">
                                                <img src="{{ asset('storage/store_banners/' . $banner->image) }}"
                                                    alt="{{ $banner->title }}" class="img-responsive">
                                            </a>
                                        </div>
                                    </div>
                                    <!-- homes content -->

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>


    @if (count($projects))
        <section class="popular-places home18">
            <div class="container">
                <div class="row">
                    @foreach ($projects as $project)
                        <div class="col-sm-12 col-md-4 col-lg-4" data-aos="zoom-in" data-aos-delay="150">
                            <!-- Image Box -->
                            <a href="{{ route('project.detail', $project->slug) }}" class="img-box hover-effect">
                                <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                    class="img-fluid w100" alt="">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if (count($secondhandHousings))
        <!-- START SECTION RECENTLY PROPERTIES -->
        <section class="featured portfolio rec-pro disc bg-white">
            <div class="container">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="section-title">
                        <h2>İkinci El Konutlar</h2>
                    </div>
                </div>
                <div class="portfolio col-xl-12">
                    <div class="row project-filter-reverse blog-pots">

                        @foreach ($secondhandHousings as $housing)
                            <a href="{{ route('housing.show', ['id' => $housing->id]) }}" class="col-md-3 text-decoration-none" data-aos="fade-up" data-aos-delay="150">
                                <div class="landscapes">
                                    <div class="project-single">
                                        <div class="project-inner project-head">
                                            <div class="homes">
                                                <!-- homes img -->
                                                <div class="homes-img">
                                                    <img src="{{ asset('housing_images/' . getImage($housing, 'image')) }}"
                                                        alt="{{ $housing->housing_type_title }}" class="img-responsive">
                                                </div >
                                            </div>
                                            <div class="button-effect">
                                                <!-- Örneğin Kalp İkonu -->
                                                <span class="btn toggle-favorite"
                                                    data-housing-id="{{ $housing->id }}">
                                                    <i class="fa fa-heart"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- homes content -->
                                        <div class="homes-content p-3" style="padding:20px !important">
                                            <!-- homes address -->
                                            <h3><span>{{ $housing->housing_title }}</span>
                                            </h3>
                                            <p class="homes-address mb-3">
                                                <span>
                                                    <i class="fa fa-map-marker"></i><span>{{ $housing->address }}</span>
                                                </span>
                                            </p>
                                            <!-- homes List -->
                                            <ul class="homes-list clearfix pb-0"
                                                style="display: flex;justify-content:space-between">
                                                <li class="sude-the-icons" style="width:auto !important">
                                                    <i class="flaticon-bed mr-2" aria-hidden="true"></i>
                                                    <span>{{ $housing->housing_type_title }}</span>
                                                </li>
                                                <li class="sude-the-icons" style="width:auto !important">
                                                    <i class="flaticon-bathtub mr-2" aria-hidden="true"></i>
                                                    <span>{{ getData($housing, 'room_count') }}</span>
                                                </li>
                                                <li class="sude-the-icons" style="width:auto !important">
                                                    <i class="flaticon-square mr-2" aria-hidden="true"></i>
                                                    <span>{{ getData($housing, 'squaremeters') }} m2</span>
                                                </li>
                                            </ul>
                                            <ul class="homes-list clearfix pb-0"
                                                style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                <li style="font-size: large; font-weight: 700;">
                                                    {{ getData($housing, 'price') }}TL
                                                </li>

                                                <li style="display: flex; justify-content: center;">
                                                    {{ date('j', strtotime($housing->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($housing->created_at))) }}
                                                </li>
                                            </ul>
                                            <ul class="homes-list clearfix pb-0"
                                                style="display: flex; justify-content: center;margin-top:20px !important;">
                                                <button class="addToCart"
                                                    style="width: 100%; border: none; background-color: #446BB6; border-radius: 10px; padding: 5px 0px; color: white;"
                                                    data-type='housing' data-id='{{ $housing->id }}'>Sepete
                                                    Ekle</button>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach

                    </div>
                </div>
            </div>
        </section>
        <!-- END SECTION RECENTLY PROPERTIES -->
    @endif


    @if (count($finishProjects))
        <!-- START SECTION RECENTLY PROPERTIES -->
        <section class="featured portfolio rec-pro disc bg-white">
            <div class="container">
                <div style="display: flex; justify-content: space-between;">
                    <div class="section-title">
                        <h2>Tamamlanan Projeler</h2>
                    </div>
                </div>


                <section class="properties-right list featured portfolio blog pb-5 bg-white">
                    <div class="container">
                        <div class="row project-filter-reverse blog-pots">
                            @foreach ($finishProjects as $project)
                                @for ($i = 0; $i < $project->room_count; $i++)
                                    <a href="{{ route('project.housings.detail', [$project->slug, $project->id]) }}" class="col-md-3 text-decoration-none" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="homes">
                                                        <!-- homes img -->

                                                        <div
                                                            class="homes-img">
                                                            <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', $i + 1)->value }}"
                                                                alt="{{ $project->housingType->title }}"
                                                                class="img-responsive">
                                                        </div>
                                                    </div>
                                                    <div class="button-effect">
                                                        <span class="btn toggle-project-favorite"
                                                            data-project-housing-id="{{ $project->id }}">
                                                            <i class="fa fa-heart"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <!-- homes content -->
                                                <div class="homes-content p-3" style="padding:20px !important">
                                                    <h3>{{ $project->project_title }} Projesinde
                                                        {{ getHouse($project, 'squaremeters[]', $i + 1)->value }}m2
                                                        {{ getHouse($project, 'room_count[]', $i + 1)->value }}
                                                    </h3>

                                                    <p class="homes-address mb-3">

                                                        <span>
                                                            <i
                                                                class="fa fa-map-marker"></i><span>{{ $project->address }}</span>
                                                        </span>
                                                    </p>
                                                    <!-- homes List -->
                                                    <ul class="homes-list clearfix pb-0"
                                                        style="display: flex;justify-content:space-between">
                                                        <li class="sude-the-icons" style="width:auto !important">
                                                            <i class="flaticon-bed mr-2" aria-hidden="true"></i>
                                                            <span>{{ getHouse($project, 'room_count[]', $i + 1)->value }}</span>
                                                        </li>
                                                        <li class="sude-the-icons" style="width:auto !important">
                                                            <i class="flaticon-bathtub mr-2" aria-hidden="true"></i>
                                                            <span>{{ getHouse($project, 'numberoffloors[]', $i + 1)->value }}.Kat</span>
                                                        </li>
                                                        <li class="sude-the-icons" style="width:auto !important">
                                                            <i class="flaticon-square mr-2" aria-hidden="true"></i>
                                                            <span>{{ getHouse($project, 'squaremeters[]', $i + 1)->value }}
                                                                m2</span>
                                                        </li>
                                                    </ul>
                                                    <ul class="homes-list clearfix pb-0"
                                                        style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                        <li style="font-size: large; font-weight: 700;width:100%">
                                                            {{ getHouse($project, 'price[]', $i + 1)->value }} TL
                                                        </li>
                                                        <li style="display: flex; justify-content: center;">
                                                            {{ date('j', strtotime($project->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($project->created_at))) }}
                                                        </li>
                                                    </ul>
                                                    <ul class="homes-list clearfix pb-0"
                                                        style="display: flex; justify-content: center;margin-top:20px !important;">
                                                        <button id="addToCart"
                                                            style="width: 100%; border: none; background-color: #446BB6; border-radius: 10px; padding: 5px 0px; color: white;"
                                                            data-type='project' data-project='{{ $project->id }}'
                                                            data-id='{{ getHouse($project, 'price[]', $i + 1)->room_order }}'>Sepete
                                                            Ekle</button>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endfor
                            @endforeach
                        </div>
                    </div>
                </section>

            </div>
        </section>
        <!-- END SECTION POPULAR PLACES -->
    @endif


    @if (count($continueProjects))
        <!-- START SECTION RECENTLY PROPERTIES -->
        <section class="featured portfolio rec-pro disc bg-white">
            <div class="container">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="section-title">
                        <h2>Yapım Aşamasındaki Projeler</h2>
                    </div>
                </div>

                <section class="properties-right list featured portfolio blog pb-5 bg-white">
                    <div class="container">
                        <div class="row project-filter-reverse blog-pots">
                            @foreach ($continueProjects as $project)
                                @for ($i = 0; $i < $project->room_count; $i++)
                                    <a href="{{ route('project.housings.detail', [$project->slug, $project->id]) }}" class="col-md-3 text-decoration-none" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="homes">
                                                        <!-- homes img -->

                                                        <div
                                                            class="homes-img">

                                                            <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', $i + 1)->value }}"
                                                                alt="{{ $project->housingType->title }}"
                                                                class="img-responsive">
                                                        </div>
                                                    </div>
                                                    <div class="button-effect">
                                                        <span class="btn toggle-project-favorite"
                                                            data-project-housing-id="{{ $project->id }}">
                                                            <i class="fa fa-heart"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <!-- homes content -->
                                                <div class="homes-content p-3" style="padding:20px !important">
                                                    <h3>{{ $project->project_title }} Projesinde
                                                        {{ getHouse($project, 'squaremeters[]', $i + 1)->value }}m2
                                                        {{ getHouse($project, 'room_count[]', $i + 1)->value }}
                                                    </h3>

                                                    <p class="homes-address mb-3">

                                                        <span>
                                                            <i
                                                                class="fa fa-map-marker"></i><span>{{ $project->address }}</span>
                                                        </span>
                                                    </p>
                                                    <!-- homes List -->
                                                    <ul class="homes-list clearfix pb-0"
                                                        style="display: flex;justify-content:space-between">
                                                        <li class="sude-the-icons" style="width:auto !important">
                                                            <i class="flaticon-bed mr-2" aria-hidden="true"></i>
                                                            <span>{{ getHouse($project, 'room_count[]', $i + 1)->value }}</span>
                                                        </li>
                                                        <li class="sude-the-icons" style="width:auto !important">
                                                            <i class="flaticon-bathtub mr-2" aria-hidden="true"></i>
                                                            <span>{{ getHouse($project, 'numberoffloors[]', $i + 1)->value }}.Kat</span>
                                                        </li>
                                                        <li class="sude-the-icons" style="width:auto !important">
                                                            <i class="flaticon-square mr-2" aria-hidden="true"></i>
                                                            <span>{{ getHouse($project, 'squaremeters[]', $i + 1)->value }}
                                                                m2</span>
                                                        </li>
                                                    </ul>
                                                    <ul class="homes-list clearfix pb-0"
                                                        style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                        <li style="font-size: large; font-weight: 700;width:100%">
                                                            {{ getHouse($project, 'price[]', $i + 1)->value }} TL
                                                        </li>
                                                        <li style="display: flex; justify-content: center;">
                                                            {{ date('j', strtotime($project->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($project->created_at))) }}
                                                        </li>
                                                    </ul>
                                                    <ul class="homes-list clearfix pb-0"
                                                        style="display: flex; justify-content: center;margin-top:20px !important;">
                                                        <button id="addToCart"
                                                            style="width: 100%; border: none; background-color: #446BB6; border-radius: 10px; padding: 5px 0px; color: white;"
                                                            data-type='project' data-project='{{ $project->id }}'
                                                            data-id='{{ getHouse($project, 'price[]', $i + 1)->room_order }}'>Sepete
                                                            Ekle</button>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endfor
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
        </section>
        <!-- END SECTION RECENTLY PROPERTIES -->
    @endif

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.banner-agents').slick({
                infinite: false,
                slidesToShow: 3,
                slidesToScroll: 1,
                dots: false,
                loop: true,
                autoplay: true,
                arrows: true,
                nav: true,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1292,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        dots: false,
                        arrows: true
                    }
                }, {
                    breakpoint: 993,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        dots: false,
                        arrows: true
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
        });
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
@endsection

@section('styles')
    <style>
        .section-title h2 {
            color: black !important
        }

        .section-title:before {
            background-color: black !important
        }
    </style>
@endsection
