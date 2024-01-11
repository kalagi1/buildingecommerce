@extends('client.layouts.master')

@section('content')
    <meta name="description" content="Emlak Sepette">
    <meta name="author" content="Innovatica Code">
    <title>Emlak Sepette</title>
    <style>
        section.portfolio .slick-slide {
            margin-right: 10px;
        }

        section.portfolio .slick-active:first-child {
            margin-left: 0;
        }

        section.portfolio .slick-active:last-child {
            margin-right: 0 !important;
        }


        section.portfolio .slick-track {
            float: left;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css"
        integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @php
        if (!function_exists('convertMonthToTurkishCharacter')) {
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
        }

        if (!function_exists('getData')) {
            function getData($housing, $key)
            {
                $housing_type_data = json_decode($housing->housing_type_data);
                $a = $housing_type_data->$key;
                return $a[0];
            }
        }

        if (!function_exists('getImage')) {
            function getImage($housing, $key)
            {
                $housing_type_data = json_decode($housing->housing_type_data);
                $a = $housing_type_data->$key;
                return $a;
            }
        }
    @endphp

    <section class="recently portfolio bg-white homepage-5">
        <div class="container recently-slider">
            <div class="portfolio right-slider">
                <div class="owl-carousel home5-right-slider">
                    @foreach ($sliders as $slider)
                        <a href="javascript:void()" class="recent-16" data-aos="fade-up" data-aos-delay="150">
                            <div class="recent-img16 sliderSize img-fluid img-center mobile-hidden"
                                style="background-image: url({{ url('storage/sliders/' . $slider->image) }});"></div>
                            <div class="recent-img16 sliderSize img-fluid img-center mobile-show heitwo"
                                style="background-image: url({{ url('storage/sliders/' . $slider->mobile_image) }});"></div>

                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>



    <section class="featured  home18 bg-white">
        <div class="container">
            <div class="portfolio ">
                <div class="slick-lancers">
                    @foreach ($brands as $brand)
                        <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                            <a href="{{ route('instituional.dashboard', Str::slug($brand->name)) }}" class="homes-img">
                                <div class="landscapes">
                                    <div class="project-single">
                                        <div class="project-inner project-head">
                                            <div class="homes">
                                                <img src="{{ asset('storage/profile_images/' . $brand->profile_image) }}"
                                                    alt="home-1" class="img-responsive brand-image-pp">
                                                <span style="font-size:9px !important;">{{ $brand->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>



    <section class="container justify-content-center">
        <div class="special-button-content row">
            @foreach ($dashboardStatuses as $status)
                <div class="col-lg-2 col-md-6 col-sm-6 mb-3 col-6 statusHome">
                    <a href="{{ url('kategori/' . $status->slug) }}">
                        <button style="background-color: #ea2a28; color: white;" class="w-100">
                            {{ $status->name }}
                        </button>
                    </a>
                </div>
            @endforeach
        </div>
    </section>


    <!-- category banner headers ends-->



    <!-- START SECTION POPULAR PLACES -->
    <section class="popular-places home18 mb-5">
        <div class="container">
            <div style="display: flex; justify-content: space-between;">
                <div class="section-title">
                    <h2>Öne Çıkan Projeler</h2>
                </div>
            </div>
            <div class="row mt-2 mobile-hidden">
                <div class="container">
                    @if (count($dashboardProjects))
                        <div class="row">
                            @foreach ($dashboardProjects as $project)
                                <div class="col-sm-12 col-md-4 col-lg-4 col-12 projectMobileMargin" data-aos="zoom-in"
                                    data-aos-delay="150" style="height:200px">
                                    <div class="project-single no-mb aos-init aos-animate" style="height:100%"
                                        data-aos="zoom-in" data-aos-delay="150">
                                        <div class="listing-item compact" style="height:100%">
                                            <a href="{{ route('project.detail', $project->project->slug) }}"
                                                class="listing-img-container">
                                                <img class="project_brand_profile_image"
                                                    src="{{ URL::to('/') . '/storage/profile_images/' . $project->project->user->profile_image }}"
                                                    alt="">
                                                <div class="listing-img-content"
                                                    style="padding-left:10px;text-transform:uppercase;">
                                                    <span
                                                        class="badge badge-phoenix text-left">{{ $project->project->project_title }}
                                                        <span class="d-block mt-1 mb-1"><small>{{ $project->project->city->title }}
                                                                /
                                                                {{ $project->project->county->ilce_title }}
                                                                {{ $project->project->neighbourhood ? '/ ' . $project->project->neighbourhood->mahalle_title : null }}</small></span></span>

                                                </div>
                                                <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->project->image) }}"
                                                    alt="" style="height:100%;object-fit:contain">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>Henüz Öne Çıkarılan Proje Bulunamadı</p>
                    @endif
                </div>
            </div>
            <div class="row mobile-show homepage-9">
                <div class="container">
                    <div class="row">
                        @foreach ($dashboardProjects as $project)
                            <div class="col-xl-3 col-lg-6 col-sm-6 aos-init aos-animate" data-aos="fade-up"
                                data-aos-delay="150">
                                <div class="small-category-2">
                                    <div class="small-category-2-thumb img-1">
                                        <a href="{{ route('project.detail', $project->project->slug) }}"><img
                                                src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->project->image) }}""
                                                alt=""></a>
                                    </div>
                                    <div class="sc-2-detail">
                                        <h4 class="sc-jb-title"><a
                                                href="{{ route('project.detail', $project->project->slug) }}">{{ $project->project->project_title }}</a>
                                        </h4>
                                        <span>{{ $project->project->city->title }}
                                            /
                                            {{ $project->project->county->ilce_title }}
                                            {{ $project->project->neighbourhood ? '/ ' . $project->project->neighbourhood->mahalle_title : null }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END SECTION RECENTLY PROPERTIES -->



    <!-- START SECTION RECENTLY PROPERTIES -->
    <section class="featured portfolio rec-pro disc bg-white">
        <div class="container">
            <div class="featured-heads">
                <div class="section-title">
                    <h2>Tamamlanan Projeler</h2>
                </div>
                <a href="https://emlaksepette.com/kategori/tamamlanan-projeler" style="font-size: 12px;">
                    <button style="background-color: #ea2a28; color: white;padding: 5px 10px;border:none;" class="w-100">
                        Tümünü Gör
                    </button>
                </a>
            </div>
            @php
                if (!function_exists('getHouse')) {
                    function getHouse($project, $key, $roomOrder)
                    {
                        foreach ($project->roomInfo as $room) {
                            if ($room->room_order == $roomOrder && $room->name == $key) {
                                return $room;
                            }
                        }
                    }
                }
            @endphp

            <div class="row mobile-show homepage-9">
                <div class="container">
                    <div class="row">
                        @foreach ($finishProjects as $project)
                            <div class="col-xl-3 col-lg-6 col-sm-6 aos-init aos-animate" data-aos="fade-up"
                                data-aos-delay="150">
                                <div class="small-category-2">
                                    <div class="small-category-2-thumb img-1">
                                        <a href="{{ route('project.detail', $project->slug) }}"><img
                                                src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}""
                                                alt=""></a>
                                    </div>
                                    <div class="sc-2-detail">
                                        <h4 class="sc-jb-title"><a
                                                href="{{ route('project.detail', $project->slug) }}">{{ $project->project_title }}</a>
                                        </h4>
                                        <span>{{ $project->city->title }}
                                            /
                                            {{ $project->county->ilce_title }}
                                            {{ $project->neighbourhood ? '/ ' . $project->neighbourhood->mahalle_title : null }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mobile-hidden">
                @if (count($finishProjects))
                    <div class="properties-right list featured portfolio blog pb-5 bg-white">
                        <div class="container">
                            <div class="row project-filter-reverse blog-pots finish-projects-web">
                                @foreach ($finishProjects as $project)
                                    <div class="projectMobileMargin marginLeftRightZero" data-aos="zoom-in"
                                        data-aos-delay="150" style="height:200px">
                                        <div class="project-single no-mb aos-init aos-animate" style="height:100%"
                                            data-aos="zoom-in" data-aos-delay="150">
                                            <div class="listing-item compact" style="height:100%">
                                                <a href="{{ route('project.detail', $project->slug) }}"
                                                    class="listing-img-container">
                                                    <img class="project_brand_profile_image"
                                                        src="{{ URL::to('/') . '/storage/profile_images/' . $project->user->profile_image }}"
                                                        alt="">
                                                    <div class="listing-img-content"
                                                        style="padding-left:10px;text-transform:uppercase;">
                                                        <span
                                                            class="badge badge-phoenix text-left">{{ $project->project_title }}
                                                            <span class="d-block mt-1 mb-1"><small>{{ $project->city->title }}
                                                                    /
                                                                    {{ $project->county->ilce_title }}
                                                                    {{ $project->neighbourhood ? '/ ' . $project->neighbourhood->mahalle_title : null }}</small></span></span>

                                                    </div>
                                                    <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                                        alt="" style="height:100%;object-fit:contain">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <p>Henüz İlan Yayınlanmadı</p>
                @endif
            </div>


        </div>
    </section>
    <!-- END SECTION POPULAR PLACES -->


    <!-- START SECTION RECENTLY PROPERTIES -->
    <section class="featured portfolio rec-pro disc bg-white">
        <div class="container">
            <div class="featured-heads">
                <div class="section-title">
                    <h2>Devam Eden Projeler</h2>
                </div>
                <a href="https://emlaksepette.com/kategori/devam-eden-projeler" style="font-size: 12px;">
                    <button style="background-color: #ea2a28; color: white;padding: 5px 10px;border:none;" class="w-100">
                        Tümünü Gör
                    </button>
                </a>
            </div>
            <div class="row mobile-show homepage-9">
                <div class="container">
                    <div class="row">
                        @foreach ($continueProjects as $project)
                            <div class="col-xl-3 col-lg-6 col-sm-6 aos-init aos-animate" data-aos="fade-up"
                                data-aos-delay="150">
                                <div class="small-category-2">
                                    <div class="small-category-2-thumb img-1">
                                        <a href="{{ route('project.detail', $project->slug) }}"><img
                                                src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}""
                                                alt=""></a>
                                    </div>
                                    <div class="sc-2-detail">
                                        <h4 class="sc-jb-title"><a
                                                href="{{ route('project.detail', $project->slug) }}">{{ $project->project_title }}</a>
                                        </h4>
                                        <span>{{ $project->city->title }}
                                            /
                                            {{ $project->county->ilce_title }}
                                            {{ $project->neighbourhood ? '/ ' . $project->neighbourhood->mahalle_title : null }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mobile-hidden">
                @if (count($continueProjects))
                    <div class="properties-right list featured portfolio blog pb-5 bg-white">
                        <div class="container">
                            <div class="row project-filter-reverse blog-pots finish-projects-web">
                                @foreach ($continueProjects as $project)
                                    <div class="projectMobileMargin marginLeftRightZero" data-aos="zoom-in"
                                        data-aos-delay="150" style="height:200px">
                                        <div class="project-single no-mb aos-init aos-animate" style="height:100%"
                                            data-aos="zoom-in" data-aos-delay="150">
                                            <div class="listing-item compact" style="height:100%">
                                                <a href="{{ route('project.detail', $project->slug) }}"
                                                    class="listing-img-container">
                                                    <img class="project_brand_profile_image"
                                                        src="{{ URL::to('/') . '/storage/profile_images/' . $project->user->profile_image }}"
                                                        alt="">
                                                    <div class="listing-img-content"
                                                        style="padding-left:10px;text-transform:uppercase;">
                                                        <span
                                                            class="badge badge-phoenix text-left">{{ $project->project_title }}
                                                            <span class="d-block mt-1 mb-1"><small>{{ $project->city->title }}
                                                                    /
                                                                    {{ $project->county->ilce_title }}
                                                                    {{ $project->neighbourhood ? '/ ' . $project->neighbourhood->mahalle_title : null }}</small></span></span>

                                                    </div>
                                                    <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                                        alt="" style="height:100%;object-fit:contain">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <p>Henüz İlan Yayınlanmadı</p>
                @endif
            </div>

        </div>
    </section>
    <!-- END SECTION RECENTLY PROPERTIES -->


    <!-- START SECTION RECENTLY PROPERTIES -->
    <section class="featured portfolio rec-pro disc bg-white">
        <div class="container">
            <div class="featured-heads">
                <div class="section-title">
                    <h2>Topraktan Projeler</h2>
                </div>
                <a href="https://emlaksepette.com/kategori/topraktan-projeler" style="font-size: 12px;">
                    <button style="background-color: #ea2a28; color: white;padding: 5px 10px;border:none;" class="w-100">
                        Tümünü Gör
                    </button>
                </a>
            </div>

            <div class="row mobile-show homepage-9">
                <div class="container">
                    <div class="row">
                        @foreach ($soilProjects as $project)
                            <div class="col-xl-3 col-lg-6 col-sm-6 aos-init aos-animate" data-aos="fade-up"
                                data-aos-delay="150">
                                <div class="small-category-2">
                                    <div class="small-category-2-thumb img-1">
                                        <a href="{{ route('project.detail', $project->slug) }}"><img
                                                src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}""
                                                alt=""></a>
                                    </div>
                                    <div class="sc-2-detail">
                                        <h4 class="sc-jb-title"><a
                                                href="{{ route('project.detail', $project->slug) }}">{{ $project->project_title }}</a>
                                        </h4>
                                        <span>{{ $project->city->title }}
                                            /
                                            {{ $project->county->ilce_title }}
                                            {{ $project->neighbourhood ? '/ ' . $project->neighbourhood->mahalle_title : null }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mobile-hidden">
                @if (count($soilProjects))
                    <div class="properties-right list featured portfolio blog pb-5 bg-white">
                        <div class="container">
                            <div class="row project-filter-reverse blog-pots finish-projects-web">
                                @foreach ($soilProjects as $project)
                                    <div class="projectMobileMargin marginLeftRightZero" data-aos="zoom-in"
                                        data-aos-delay="150" style="height:200px">
                                        <div class="project-single no-mb aos-init aos-animate" style="height:100%"
                                            data-aos="zoom-in" data-aos-delay="150">
                                            <div class="listing-item compact" style="height:100%">
                                                <a href="{{ route('project.detail', $project->slug) }}"
                                                    class="listing-img-container">
                                                    <img class="project_brand_profile_image"
                                                        src="{{ URL::to('/') . '/storage/profile_images/' . $project->user->profile_image }}"
                                                        alt="">
                                                    <div class="listing-img-content"
                                                        style="padding-left:10px;text-transform:uppercase;">
                                                        <span
                                                            class="badge badge-phoenix text-left">{{ $project->project_title }}
                                                            <span class="d-block mt-1 mb-1"><small>{{ $project->city->title }}
                                                                    /
                                                                    {{ $project->county->ilce_title }}
                                                                    {{ $project->neighbourhood ? '/ ' . $project->neighbourhood->mahalle_title : null }}</small></span></span>

                                                    </div>
                                                    <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                                        alt="" style="height:100%;object-fit:contain">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <p>Henüz İlan Yayınlanmadı</p>
                @endif
            </div>

        </div>
    </section>
    <!-- END SECTION RECENTLY PROPERTIES -->

    <!-- START SECTION RECENTLY PROPERTIES -->
    <section class="featured portfolio rec-pro disc bg-white">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div class="section-title">
                    <h2>Emlak İlanları</h2>
                </div>
            </div>
            <div class="mobile-show">
                @foreach ($secondhandHousings as $housing)
                    @php($sold = $housing->sold)


                    <div class="d-flex" style="flex-wrap: nowrap">
                        <div class="align-items-center d-flex " style="padding-right:0; width: 110px;">
                            <div class="project-inner project-head">
                                <a href="{{ route('housing.show', $housing->id) }}">
                                    <div class="homes">
                                        <div class="homes-img h-100 d-flex align-items-center"
                                            style="width: 130px; height: 128px;">
                                            <img src="{{ URL::to('/') . '/housing_images/' . json_decode($housing->housing_type_data)->image }}"
                                                alt="{{ $housing->housing_title }}" class="img-responsive"
                                                style="height: 80px !important;">
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="w-100" style="padding-left:0;">
                            <div class="bg-white px-3 h-100 d-flex flex-column justify-content-center">

                                <a style="text-decoration: none;height:100%"
                                    href="{{ route('housing.show', $housing->id) }}">
                                    <div class="d-flex" style="gap: 8px;justify-content:space-between;align-items:center">
                                        <h4>{{ mb_convert_case($housing->housing_title, MB_CASE_TITLE, 'UTF-8') }}
                                        </h4>
                                        <span class="btn toggle-favorite bg-white" data-housing-id="{{ $housing->id }}"
                                            style="color: white;">
                                            <i class="fa fa-heart-o"></i>
                                        </span>
                                    </div>
                                </a>
                                <div class="d-flex" style="align-items:Center">
                                    <div class="d-flex" style="gap: 8px;">

                                        @if ($housing->step2_slug != 'gunluk-kiralik')
                                            @if (isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                <button class="btn second-btn  mobileCBtn"
                                                    style="background: #EA2B2E !important;width:100%;color:White">

                                                    <span class="text">Satıldı</span>
                                                </button>
                                            @else
                                                @if ($sold != null && $sold != '2')
                                                    <button class="btn mobileCBtn second-btn "
                                                        @if ($sold == '0') style="background: orange !important;width:100%;color:White"
                                                            @else 
                                                            style="background: red !important;width:100%;color:White" @endif>
                                                        <span class="IconContainer">
                                                            <img src="{{ asset('sc.png') }}" alt="">
                                                        </span>
                                                        @if ($sold == '0')
                                                            <span class="text">Rezerve Edildi</span>
                                                        @else
                                                            <span class="text">Satıldı</span>
                                                        @endif
                                                    </button>
                                                @else
                                                    <button class="CartBtn mobileCBtn" data-type='housing'
                                                        data-id='{{ $housing->id }}'>
                                                        <span class="IconContainer">
                                                            <img src="{{ asset('sc.png') }}" alt="">

                                                        </span>
                                                        <span class="text">Sepete Ekle</span>
                                                    </button>
                                                @endif
                                            @endif
                                        @else
                                            <button onclick="redirectToReservation()" class="reservationBtn mobileCBtn">
                                                <span class="IconContainer">
                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                </span>
                                                <span class="text">Rezervasyon Yap</span>
                                            </button>

                                            <script>
                                                function redirectToReservation() {
                                                    window.location.href = "{{ route('housing.show', [$housing->id]) }}";
                                                }
                                            </script>
                                        @endif
                                    </div>
                                    <span class="ml-auto text-primary priceFont">
                                        @if ($housing->discount_amount)
                                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                                stroke-width="2" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round" class="css-i6dzq1">
                                                <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                <polyline points="17 18 23 18 23 12"></polyline>
                                            </svg>
                                        @endif
                                        @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                            @if ($sold)
                                                @if ($sold != '1' && $sold != '0')
                                                    @if ($housing->step2_slug == 'gunluk-kiralik')
                                                        {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                        ₺
                                                        <span style="font-size:11px; color:Red" class="mobilePriceStyle">
                                                            1 Gece</span>
                                                    @else
                                                        {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                        ₺
                                                    @endif
                                                @endif
                                            @else
                                                @if ($housing->step2_slug == 'gunluk-kiralik')
                                                    {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                    ₺
                                                    <span style="font-size:11px; color:Red" class="mobilePriceStyle"> 1
                                                        Gece</span>
                                                @else
                                                    {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                    ₺
                                                @endif
                                            @endif
                                        @endif

                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-100" style="height:40px;background-color:#8080802e;margin-top:20px">
                        <div class="d-flex justify-content-between align-items-center" style="height: 100%;padding: 10px">
                            <ul class="d-flex align-items-center h-100"
                                style="list-style: none;padding:0;font-weight:600;justify-content:start;margin-bottom:0 !important">


                                @if ($housing->column1_name)
                                    <li class="d-flex align-items-center itemCircleFont">

                                        <i class="fa fa-circle circleIcon mr-1"></i>
                                        <span>{{ json_decode($housing->housing_type_data)->{$housing->column1_name}[0] ?? null }}
                                            @if ($housing->column1_additional)
                                                {{ $housing->column1_additional }}
                                            @endif
                                        </span>
                                    </li>
                                @endif

                                @if ($housing->column2_name)
                                    <li class="d-flex align-items-center itemCircleFont">

                                        <i class="fa fa-circle circleIcon mr-1"></i>
                                        <span>{{ json_decode($housing->housing_type_data)->{$housing->column2_name}[0] ?? null }}
                                            @if ($housing->column2_additional)
                                                {{ $housing->column2_additional }}
                                            @endif
                                        </span>
                                    </li>
                                @endif

                                @if ($housing->column3_name)
                                    <li class="d-flex align-items-center itemCircleFont">

                                        <i class="fa fa-circle circleIcon mr-1"></i>
                                        <span>{{ json_decode($housing->housing_type_data)->{$housing->column3_name}[0] ?? null }}
                                            @if ($housing->column3_additional)
                                                {{ $housing->column3_additional }}
                                            @endif
                                        </span>
                                    </li>
                                @endif

                                @if ($housing->column4_name)
                                    <li class="d-flex align-items-center itemCircleFont">

                                        <i class="fa fa-circle circleIcon mr-1"></i>
                                        <span>{{ json_decode($housing->housing_type_data)->{$housing->column4_name}[0] ?? null }}
                                            @if ($housing->column4_additional)
                                                {{ $housing->column4_additional }}
                                            @endif
                                        </span>
                                    </li>
                                @endif



                            </ul>
                            <span style="font-size: 11px !important">{!! $housing->city_title !!}
                                {{ '/' }} {!! $housing->county_title !!}
                            </span>
                        </div>

                    </div>
                    <hr>
                @endforeach
            </div>

            <div class="mobile-hidden">
                @if (count($secondhandHousings))
                    <section class="properties-right list featured portfolio blog  pb-5 bg-white">
                        <div class="container">
                            <div class="row project-filter-reverse blog-pots secondhand-housings-web">
                                @foreach ($secondhandHousings as $housing)
                                    @php($sold = $housing->sold)

                                    @if ($sold)
                                        @if ($sold != '1')
                                            <a href="{{ route('housing.show', [$housing->id]) }}"
                                                class="text-decoration-none">
                                                <div data-aos="fade-up" data-aos-delay="150">
                                                    <div class="landscapes">
                                                        <div class="project-single">
                                                            <div class="project-inner project-head">
                                                                <div class="homes">
                                                                    <div class="homes-img">
                                                                        <div class="homes-tag button alt featured">
                                                                            Sponsorlu
                                                                        </div>
                                                                        <div class="type-tag button alt featured">
                                                                            @if ($housing->step2_slug == 'kiralik')
                                                                                Kiralık
                                                                            @elseif ($housing->step2_slug == 'gunluk-kiralik')
                                                                                Günlük Kiralık
                                                                            @else
                                                                                Satılık
                                                                            @endif
                                                                        </div>
                                                                        @if ($housing->discount_amount)
                                                                            <div class="homes-tag button alt sale"
                                                                                style="background-color:#EA2B2E!important">
                                                                                İNDİRİM
                                                                            </div>
                                                                        @endif
                                                                        <img src="{{ URL::to('/') . '/housing_images/' . json_decode($housing->housing_type_data)->image }}"
                                                                            alt="{{ $housing->housing_title }}"
                                                                            class="img-responsive">
                                                                    </div>
                                                                </div>
                                                                <div class="button-effect">
                                                                    <span class="btn toggle-favorite bg-white"
                                                                        data-housing-id={{ $housing->id }}>
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="homes-content p-3"
                                                                style="padding:20px !important">
                                                                <span style="text-decoration: none">

                                                                    <h4 style="height:30px">
                                                                        {{ mb_substr(mb_convert_case($housing->housing_title, MB_CASE_TITLE, 'UTF-8'), 0, 45, 'UTF-8') }}
                                                                        {{ mb_strlen($housing->housing_title, 'UTF-8') > 25 ? '...' : '' }}
                                                                    </h4>


                                                                    <p class="homes-address mb-3">


                                                                        <i class="fa fa-map-marker"></i>
                                                                        <span> {{ $housing->city_title }}
                                                                            {{ '/' }}
                                                                            {{ $housing->county_title }}
                                                                        </span>

                                                                    </p>
                                                                </span>
                                                                <!-- homes List -->
                                                                <ul class="homes-list clearfix pb-0"
                                                                    style="display: flex;justify-content:space-between">
                                                                    <li class="sude-the-icons"
                                                                        style="width:auto !important">
                                                                        <i class="fa fa-circle circleIcon mr-1"></i>
                                                                        <span>
                                                                            {{ json_decode($housing->housing_type_data)->{$housing->column1_name}[0] ?? null }}
                                                                            @if ($housing->column1_additional)
                                                                                {{ $housing->column1_additional }}
                                                                            @endif
                                                                        </span>
                                                                    </li>
                                                                    @if ($housing->column2_name)
                                                                        <li class="sude-the-icons"
                                                                            style="width:auto !important">
                                                                            <i class="fa fa-circle circleIcon mr-1"></i>
                                                                            <span>{{ json_decode($housing->housing_type_data)->{$housing->column2_name}[0] ?? null }}
                                                                                @if ($housing->column2_additional)
                                                                                    {{ $housing->column2_additional }}
                                                                                @endif
                                                                            </span>
                                                                        </li>
                                                                    @endif

                                                                    @if ($housing->column3_name)
                                                                        <li class="sude-the-icons"
                                                                            style="width:auto !important">
                                                                            <i class="fa fa-circle circleIcon mr-1"></i>
                                                                            <span>{{ json_decode($housing->housing_type_data)->{$housing->column3_name}[0] ?? null }}
                                                                                @if ($housing->column3_additional)
                                                                                    {{ $housing->column3_additional }}
                                                                                @endif
                                                                            </span>
                                                                        </li>
                                                                    @endif

                                                                    @if ($housing->column4_name)
                                                                        <li class="sude-the-icons"
                                                                            style="width:auto !important">
                                                                            <i class="fa fa-circle circleIcon mr-1"></i>
                                                                            <span>{{ json_decode($housing->housing_type_data)->{$housing->column4_name}[0] ?? null }}
                                                                                @if ($housing->column4_additional)
                                                                                    {{ $housing->column4_additional }}
                                                                                @endif
                                                                            </span>
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                                <ul class="homes-list clearfix pb-0"
                                                                    style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                                    <li
                                                                        style="font-size: 16px; font-weight: 700;width:100%; white-space:nowrap">
                                                                        @if ($housing->discount_amount)
                                                                            <svg viewBox="0 0 24 24" width="24"
                                                                                height="24" stroke="currentColor"
                                                                                stroke-width="2" fill="none"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="css-i6dzq1">
                                                                                <polyline
                                                                                    points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                                </polyline>
                                                                                <polyline points="17 18 23 18 23 12">
                                                                                </polyline>
                                                                            </svg>
                                                                        @endif

                                                                        @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                                            @if ($sold)
                                                                                @if ($sold != '1' && $sold != '0')
                                                                                    @if ($housing->step2_slug == 'gunluk-kiralik')
                                                                                        {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                                                        ₺
                                                                                        <span
                                                                                            style="font-size:11px; color:#EA2B2E">/
                                                                                            1 Gece</span>
                                                                                    @else
                                                                                        {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                                                        ₺
                                                                                    @endif
                                                                                @endif
                                                                            @else
                                                                                @if ($housing->step2_slug == 'gunluk-kiralik')
                                                                                    {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                                                    ₺
                                                                                    <span
                                                                                        style="font-size:11px; color:#EA2B2E">/
                                                                                        1 Gece</span>
                                                                                @else
                                                                                    {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                                                    ₺
                                                                                @endif
                                                                            @endif
                                                                        @endif


                                                                    </li>
                                                                    <li
                                                                        style="display: flex; justify-content: right;width:100%">
                                                                        {{ date('j', strtotime($housing->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($housing->created_at))) }}
                                                                    </li>
                                                                </ul>

                                                                @if ($housing->step2_slug != 'gunluk-kiralik')
                                                                    @if (isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                                        <button class="btn second-btn "
                                                                            style="background: red !important;width:100%;color:White">

                                                                            <span class="text">Satıldı</span>
                                                                        </button>
                                                                    @else
                                                                        @if ($sold != null && $sold != '2')
                                                                            <button class="btn second-btn "
                                                                                @if ($sold == '0') style="background: orange !important;width:100%;color:White" @else  style="background: red !important;width:100%;color:White" @endif>
                                                                                @if ($sold == '0')
                                                                                    <span class="text">Onay
                                                                                        Bekleniyor</span>
                                                                                @else
                                                                                    <span class="text">Satıldı</span>
                                                                                @endif
                                                                            </button>
                                                                        @else
                                                                            <button class="CartBtn" data-type='housing'
                                                                                data-id='{{ $housing->id }}'>
                                                                                <span class="IconContainer">
                                                                                    <img src="{{ asset('sc.png') }}"
                                                                                        alt="">
                                                                                </span>
                                                                                <span class="text">Sepete Ekle</span>
                                                                            </button>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    <button onclick="redirectToReservation()"
                                                                        class="reservationBtn">
                                                                        <span class="IconContainer">
                                                                            <img src="{{ asset('sc.png') }}"
                                                                                alt="">
                                                                        </span>
                                                                        <span class="text">Rezervasyon Yap</span>
                                                                    </button>

                                                                    <script>
                                                                        function redirectToReservation() {
                                                                            window.location.href = "{{ route('housing.show', [$housing->id]) }}";
                                                                        }
                                                                    </script>
                                                                @endif


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('housing.show', [$housing->id]) }}"
                                            class="text-decoration-none">
                                            <div data-aos="fade-up" data-aos-delay="150">
                                                <div class="landscapes">
                                                    <div class="project-single">
                                                        <div class="project-inner project-head">
                                                            <div class="homes">
                                                                <div class="homes-img">
                                                                    <div class="homes-tag button alt featured">Sponsorlu
                                                                    </div>
                                                                    <div class="type-tag button alt featured">
                                                                        @if ($housing->step2_slug == 'kiralik')
                                                                            Kiralık
                                                                        @elseif ($housing->step2_slug == 'gunluk-kiralik')
                                                                            Günlük Kiralık
                                                                        @else
                                                                            Satılık
                                                                        @endif
                                                                    </div>
                                                                    @if ($housing->discount_amount)
                                                                        <div class="homes-tag button alt sale"
                                                                            style="background-color:#EA2B2E!important">
                                                                            İNDİRİM
                                                                        </div>
                                                                    @endif
                                                                    <img src="{{ URL::to('/') . '/housing_images/' . json_decode($housing->housing_type_data)->image }}"
                                                                        alt="{{ $housing->housing_title }}"
                                                                        class="img-responsive">
                                                                </div>
                                                            </div>
                                                            <div class="button-effect">
                                                                <span 
                                                                    @if (isset(json_decode($housing->housing_type_data)->{"share-open"}) &&
                                                                            json_decode($housing->housing_type_data)->{"share-open"}[0]
                                                                           
                                                                    )  class="btn addCollection" data-bs-toggle="modal" data-bs-target="#addCollection" data-type='housing' data-id="{{ $housing->id }}" 
                                                                @else
                                                                class="btn addCollection disabledShareButton" @endif>
                                                                    <i class="fa fa-bookmark"></i>
                                                                </span>
                                                                <span class="btn toggle-favorite bg-white"
                                                                    data-housing-id={{ $housing->id }}>
                                                                    <i class="fa fa-heart-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="homes-content p-3" style="padding:20px !important">
                                                            <span style="text-decoration: none">

                                                                <h4 style="height:30px">
                                                                    {{ mb_substr(mb_convert_case($housing->housing_title, MB_CASE_TITLE, 'UTF-8'), 0, 45, 'UTF-8') }}
                                                                    {{ mb_strlen($housing->housing_title, 'UTF-8') > 25 ? '...' : '' }}
                                                                </h4>


                                                                <p class="homes-address mb-3">


                                                                    <i class="fa fa-map-marker"></i>
                                                                    <span> {{ $housing->city_title }}
                                                                        {{ '/' }}
                                                                        {{ $housing->county_title }}
                                                                    </span>

                                                                </p>
                                                            </span>
                                                            <!-- homes List -->
                                                            <ul class="homes-list clearfix pb-0"
                                                                style="display: flex;justify-content:space-between">
                                                                <li class="sude-the-icons" style="width:auto !important">
                                                                    <i class="fa fa-circle circleIcon mr-1"></i>
                                                                    <span>
                                                                        {{ json_decode($housing->housing_type_data)->{$housing->column1_name}[0] ?? null }}
                                                                        @if ($housing->column1_additional)
                                                                            {{ $housing->column1_additional }}
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                                @if ($housing->column2_name)
                                                                    <li class="sude-the-icons"
                                                                        style="width:auto !important">
                                                                        <i class="fa fa-circle circleIcon mr-1"></i>
                                                                        <span>{{ json_decode($housing->housing_type_data)->{$housing->column2_name}[0] ?? null }}
                                                                            @if ($housing->column2_additional)
                                                                                {{ $housing->column2_additional }}
                                                                            @endif
                                                                        </span>
                                                                    </li>
                                                                @endif

                                                                @if ($housing->column3_name)
                                                                    <li class="sude-the-icons"
                                                                        style="width:auto !important">
                                                                        <i class="fa fa-circle circleIcon mr-1"></i>
                                                                        <span>{{ json_decode($housing->housing_type_data)->{$housing->column3_name}[0] ?? null }}
                                                                            @if ($housing->column3_additional)
                                                                                {{ $housing->column3_additional }}
                                                                            @endif
                                                                        </span>
                                                                    </li>
                                                                @endif

                                                                @if ($housing->column4_name)
                                                                    <li class="sude-the-icons"
                                                                        style="width:auto !important">
                                                                        <i class="fa fa-circle circleIcon mr-1"></i>
                                                                        <span>{{ json_decode($housing->housing_type_data)->{$housing->column4_name}[0] ?? null }}
                                                                            @if ($housing->column4_additional)
                                                                                {{ $housing->column4_additional }}
                                                                            @endif
                                                                        </span>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                            <ul class="homes-list clearfix pb-0"
                                                                style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                                <li
                                                                    style="font-size: 16px; font-weight: 700;width:100%; white-space:nowrap">
                                                                    @if ($housing->discount_amount)
                                                                        <svg viewBox="0 0 24 24" width="24"
                                                                            height="24" stroke="currentColor"
                                                                            stroke-width="2" fill="none"
                                                                            stroke-linecap="round" stroke-linejoin="round"
                                                                            class="css-i6dzq1">
                                                                            <polyline points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                            </polyline>
                                                                            <polyline points="17 18 23 18 23 12">
                                                                            </polyline>
                                                                        </svg>
                                                                    @endif

                                                                    @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                                        @if ($sold)
                                                                            @if ($sold != '1' && $sold != '0')
                                                                                @if ($housing->step2_slug == 'gunluk-kiralik')
                                                                                    {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                                                    ₺
                                                                                    <span
                                                                                        style="font-size:11px; color:#EA2B2E">/
                                                                                        1 Gece</span>
                                                                                @else
                                                                                    {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                                                    ₺
                                                                                @endif
                                                                            @endif
                                                                        @else
                                                                            @if ($housing->step2_slug == 'gunluk-kiralik')
                                                                                {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                                                ₺
                                                                                <span
                                                                                    style="font-size:11px; color:#EA2B2E">/
                                                                                    1 Gece</span>
                                                                            @else
                                                                                {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                                                ₺
                                                                            @endif
                                                                        @endif
                                                                    @endif


                                                                </li>
                                                                <li
                                                                    style="display: flex; justify-content: right;width:100%">
                                                                    {{ date('j', strtotime($housing->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($housing->created_at))) }}
                                                                </li>
                                                            </ul>

                                                            @if ($housing->step2_slug != 'gunluk-kiralik')
                                                                @if (isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                                    <button class="btn second-btn "
                                                                        style="background: red !important;width:100%;color:White">

                                                                        <span class="text">Satıldı</span>
                                                                    </button>
                                                                @else
                                                                    @if ($sold != null && $sold != '2')
                                                                        <button class="btn second-btn "
                                                                            @if ($sold == '0') style="background: orange !important;width:100%;color:White" @else  style="background: red !important;width:100%;color:White" @endif>
                                                                            @if ($sold == '0')
                                                                                <span class="text">Rezerve Edildi</span>
                                                                            @else
                                                                                <span class="text">Satıldı</span>
                                                                            @endif
                                                                        </button>
                                                                    @else
                                                                        <button class="CartBtn" data-type='housing'
                                                                            data-id='{{ $housing->id }}'>
                                                                            <span class="IconContainer">
                                                                                <img src="{{ asset('sc.png') }}"
                                                                                    alt="">

                                                                            </span>
                                                                            <span class="text">Sepete Ekle</span>
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                            @else
                                                                <button onclick="redirectToReservation()"
                                                                    class="reservationBtn">
                                                                    <span class="IconContainer">
                                                                        <img src="{{ asset('sc.png') }}" alt="">
                                                                    </span>
                                                                    <span class="text">Rezervasyon Yap</span>
                                                                </button>

                                                                <script>
                                                                    function redirectToReservation() {
                                                                        window.location.href = "{{ route('housing.show', [$housing->id]) }}";
                                                                    }
                                                                </script>
                                                            @endif


                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </section>
                @else
                    <p>Henüz İlan Yayınlanmadı</p>
                @endif
            </div>
        </div>
    </section>


    <!-- START SECTION RECENTLY PROPERTIES -->
    <section class="recently popular-places bg-white homepage-5" style=" margin-bottom: 50px; ">
        <div class="container recently-slider">

            <div class="portfolio right-slider">
                <div class="owl-carousel home5-right-slider">
                    @foreach ($footerSlider as $slider)
                        <div class="inner-box">
                            <a href="#" class="recent-16" data-aos="fade-up" data-aos-delay="150">
                                <div class="recent-img16 sliderSize img-fluid img-center mobile-hidden"
                                    style="background-image: url({{ url('storage/footer-sliders/' . $slider->image) }});">
                                </div>
                                <div class="recent-img16 sliderSize img-fluid img-center mobile-show heitwo"
                                    style="background-image: url({{ url('storage/footer-sliders/' . $slider->mobile_image) }});">
                                </div>

                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @if (Auth::check() && Auth::user()->type != '3')
        <!-- HTML -->
        <button class="chatbox-open">
            <i class="fa fa-comment" aria-hidden="true"></i>
        </button>
        <button class="chatbox-close">
            <i class="fa fa-close" aria-hidden="true"></i>
        </button>
        <div class="chatbox-popup">
            <header class="chatbox-popup__header">
                <aside style="flex:8">
                    <h4 style="color: white">Emlak Sepette Canlı Destek</h4>
                </aside>
            </header>
            <main class="chatbox-popup__main">
                <div class="chatbox-messages">
                    <div class="msg left-msg">

                        <div class="msg-bubble">

                            <div class="msg-text">
                                Merhaba size nasıl yardımcı olabiliriz ?
                            </div>
                        </div>
                    </div>

                </div>
            </main>
            <footer class="chatbox-popup__footer">
                <aside style="flex:10">
                    <textarea id="userMessage" type="text" placeholder="Mesajınızı Yazınız..." autofocus
                        onkeydown="handleKeyPress(event)"></textarea>
                </aside>
                <aside style="flex:1;color:#888;text-align:center;">
                    <button onclick="sendMessage()" class="btn btn-primary"><i class="fa fa-paper-plane"
                            aria-hidden="true"></i></button>
                </aside>
            </footer>
        </div>
    @endif


@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetchChatHistory();
        });

        function fetchChatHistory() {
            $.ajax({
                url: 'chat/history',
                method: 'GET',
                success: function(response) {

                    renderChatHistory(response);
                },
                error: function(error) {
                    console.error('Sohbet geçmişi alınamadı:', error);
                }
            });

        }

        function renderChatHistory(chatHistory) {
            const chatboxMessages = document.querySelector('.chatbox-messages');

            chatHistory.forEach(entry => {
                const messageElement = document.createElement('div');
                const messageType = entry.receiver_id == 4 ? 'user' : 'admin';

                messageElement.className = messageType == 'admin' ? 'msg left-msg' : 'msg right-msg';
                messageElement.innerHTML = `
            <div class="msg-bubble">
                <div class="msg-text">
                    ${entry.content}
                </div>
            </div>
        `;
                chatboxMessages.appendChild(messageElement);
            });
        }


        var isFirstMessage = true;

        function sendMessage() {
            var userMessage = document.getElementById('userMessage').value;
            var chatboxMessages = document.querySelector('.chatbox-messages');

            // Kullanıcının mesajını ekle
            var userMessageElement = document.createElement('div');
            userMessageElement.className = 'msg right-msg';
            userMessageElement.innerHTML = `
            <div class="msg-bubble">
                <div class="msg-text">
                    ${userMessage}
                </div>
            </div>
        `;
            chatboxMessages.appendChild(userMessageElement);

            $.ajax({
                type: 'POST',
                url: "{{ route('messages.store') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'content': userMessage,
                },
                success: function(response) {
                    // Başarıyla mesaj gönderildiğinde yapılacak işlemler
                    console.log(response.message);
                    chatboxMessages.scrollTop = chatboxMessages.scrollHeight;
                },
                error: function(error) {
                    toastr.error('Bir hata oluştu. Lütfen tekrar deneyin.');

                }
            });


            // Kullanıcının girdiği mesaj alanını temizle
            document.getElementById('userMessage').value = '';
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        }

        $(".chatbox-open").click(() => {
            $(".chatbox-popup, .chatbox-close").fadeIn();
        });

        $(".chatbox-close").click(() => {
            $(".chatbox-popup, .chatbox-close").fadeOut();
        });

        $(".chatbox-maximize").click(() => {
            $(".chatbox-popup, .chatbox-open, .chatbox-close").fadeOut();
            $(".chatbox-panel").fadeIn();
            $(".chatbox-panel").css({
                display: "flex"
            });
        });

        $(".chatbox-minimize").click(() => {
            $(".chatbox-panel").fadeOut();
            $(".chatbox-popup, .chatbox-open, .chatbox-close").fadeIn();
        });

        $(".chatbox-panel-close").click(() => {
            $(".chatbox-panel").fadeOut();
            $(".chatbox-open").fadeIn();
        });
        $('.finish-projects-web').slick({
            infinite: false,
            slidesToShow: 3,
            slidesToScroll: 3,
            dots: false,
            arrows: true,
            adaptiveHeight: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        dots: false,
                        arrows: false
                    }
                },
                {
                    breakpoint: 992,
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
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: false,
                        arrows: false
                    }
                }
            ]
        })

        $('.continue-projects-web').slick({
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 4,
            dots: false,
            arrows: true,
            adaptiveHeight: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
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
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: false,
                        arrows: false
                    }
                }
            ]
        })

        $('.secondhand-housings-web').slick({
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 4,
            dots: false,
            arrows: true,
            adaptiveHeight: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
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
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: false,
                        arrows: false
                    }
                }
            ]
        });
    </script>
@endsection

@section('styles')
    <style>

    </style>
@endsection
