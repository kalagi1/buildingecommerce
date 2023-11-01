@extends('client.layouts.master')

@section('content')
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
                            <div class="recent-img16 sliderSize img-fluid img-center mobile-show"
                                style="background-image: url({{ url('storage/sliders/' . $slider->mobile_image) }});"></div>

                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>




    <!-- START SECTION RECENTLY PROPERTIES -->
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
                                                <!-- homes img -->
                                                <img src="{{ asset('storage/profile_images/' . $brand->profile_image) }}"
                                                    alt="home-1" class="img-responsive brand-image-pp">
                                                <span>{{ $brand->name }}</span>
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
    <!-- END SECTION RECENTLY PROPERTIES -->



    <section class="container justify-content-center">
        <div class="special-button-content row">
            @foreach ($dashboardStatuses as $status)
                <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                    <a href="{{ url('kategori/' . $status->slug) }}">
                        <button style="background-color: #e5424224; color: #e54242;" class="w-100">
                            {{ $status->name }}
                        </button>
                    </a>
                </div>
            @endforeach
        </div>
    </section>


    <!-- category banner headers ends-->





    <!-- START SECTION POPULAR PLACES -->
    <section class="popular-places home18">
        <div class="container">
            <div style="display: flex; justify-content: space-between;">
                <div class="section-title">
                    <h2>Öne Çıkan Projeler</h2>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                </div>
                @foreach ($dashboardProjects as $project)
                    <div class="col-sm-12 col-md-4 col-lg-4 col-12" data-aos="zoom-in" data-aos-delay="150">
                        <!-- Image Box -->
                        <a href="{{ route('project.detail', $project->project->slug) }}" class="img-box hover-effect">
                            <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->project->image) }}"
                                class="img-fluid w100" alt="">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- END SECTION RECENTLY PROPERTIES -->


    <!-- START SECTION RECENTLY PROPERTIES -->
    <section class="featured portfolio rec-pro disc bg-white">
        <div class="container">
            <div style="display: flex; justify-content: space-between;">
                <div class="section-title">
                    <h2>Tamamlanan Projeler</h2>
                </div>
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
            <div class="mobile-show">
                @foreach ($finishProjects as $project)
                    @for ($i = 0; $i < $project->room_count; $i++)
                        @php($room_order = getHouse($project, 'squaremeters[]', $i + 1)->room_order)
                        @php(
    $discount_amount =
        App\Models\Offer::where('type', 'project')->where('project_id', $project->id)->where('project_housings', 'LIKE', "%\"{$room_order}\"%")->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0
)
                        <div class="d-flex" style="flex-wrap: nowrap">
                            <div class="align-items-center d-flex" style="padding-right:0; width: 110px;">
                                <div class="project-inner project-head">
                                    <a
                                        href="{{ route('project.housings.detail', [$project->slug, getHouse($project, 'squaremeters[]', $i + 1)->room_order]) }}">
                                        <div class="homes">
                                            <!-- homes img -->

                                            <div class="homes-img h-100 d-flex align-items-center"
                                                style="width: 130px; height: 128px;">

                                                <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', $i + 1)->value }}"
                                                    alt="{{ $project->housingType->title }}" class="img-responsive"
                                                    style="height: 100px !important;">
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="w-100" style="padding-left:0;">
                                <div class="bg-white px-3 h-100 d-flex flex-column justify-content-center">

                                    <a style="text-decoration: none;height:100%"
                                        href="{{ route('project.housings.detail', [$project->slug, getHouse($project, 'squaremeters[]', $i + 1)->room_order]) }}">
                                        <h3>{{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}{{ ' ' }}Projesinde
                                            {{ getHouse($project, 'squaremeters[]', $i + 1)->value }}m2
                                            {{ getHouse($project, 'room_count[]', $i + 1)->value }}
                                        </h3>


                                    </a>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex" style="gap: 8px;">
                                            <a href="#" class="btn toggle-project-favorite bg-white"
                                                data-project-housing-id="{{ getHouse($project, 'squaremeters[]', $i + 1)->room_order }}"
                                                style="color: white;" data-project-id="{{ $project->id }}">
                                                <i class="fa fa-heart-o"></i>
                                            </a>
                                            <button class="addToCart mobile px-2"
                                                style="width: 100%; border: none; background-color: #274abb; border-radius: .25rem; padding: 5px 0px; color: white;"
                                                data-type='project' data-project='{{ $project->id }}'
                                                data-id='{{ getHouse($project, 'price[]', $i + 1)->room_order }}'>
                                                <img src="{{ asset('images/sc.png') }}" alt="sc" width="24px"
                                                    height="24px"
                                                    style="width: 24px !important; height: 24px !important;" />
                                            </button>
                                        </div>
                                        <span class="ml-auto text-primary priceFont">
                                            @if ($discount_amount)
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                                    stroke-width="2" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round" class="css-i6dzq1">
                                                    <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                    <polyline points="17 18 23 18 23 12"></polyline>
                                                </svg>
                                            @endif
                                            {{ number_format(getHouse($project, 'price[]', $i + 1)->value - $discount_amount, 2, ',', '.') }}
                                            ₺
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-100" style="height:40px;background-color:#8080802e;margin-top:20px">
                            <ul class="d-flex justify-content-around align-items-center h-100"
                                style="list-style: none;padding:0;font-weight:600">
                                <li class="d-flex align-items-center itemCircleFont">
                                    <i class="fa fa-circle circleIcon"></i>
                                    No: {{ getHouse($project, 'squaremeters[]', $i + 1)->room_order }}
                                </li>
                                <li class="d-flex align-items-center itemCircleFont">
                                    <i class="fa fa-circle circleIcon"></i>
                                    {{ getHouse($project, 'squaremeters[]', $i + 1)->value }} m2
                                </li>
                                <li class="d-flex align-items-center itemCircleFont">
                                    <i class="fa fa-circle circleIcon"></i>
                                    {{ getHouse($project, 'room_count[]', $i + 1)->value }}
                                </li>
                                <li class="d-flex align-items-center itemCircleFont">
                                    <i class="fa fa-circle circleIcon"></i>
                                    {{ $project->city->title }} {{ '/' }} {{ $project->county->ilce_title }}
                                </li>



                            </ul>
                        </div>
                        <hr>
                    @endfor
                @endforeach
            </div>

            <div class="mobile-hidden">
                @if (count($finishProjects))
                    <div class="properties-right list featured portfolio blog pb-5 bg-white">
                        <div class="container">
                            <div class="row project-filter-reverse blog-pots finish-projects-web">
                                @foreach ($finishProjects as $project)
                                    @for ($i = 0; $i < $project->room_count; $i++)
                                        @php($room_order = getHouse($project, 'squaremeters[]', $i + 1)->room_order)
                                        @php(
    $discount_amount =
        App\Models\Offer::where('type', 'project')->where('project_id', $project->id)->where('project_housings', 'LIKE', "%\"{$room_order}\"%")->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0
)
                                        <div data-aos="fade-up" data-aos-delay="150">
                                            <a class="text-decoration-none"
                                                href="{{ route('project.housings.detail', [$project->slug, getHouse($project, 'squaremeters[]', $i + 1)->room_order]) }}">
                                                <div class="landscapes">
                                                    <div class="project-single">
                                                        <div class="project-inner project-head">
                                                            <div class="homes">
                                                                <!-- homes img -->

                                                                <div class="homes-img">
                                                                    <div class="homes-tag button alt featured">Öne
                                                                        Çıkan
                                                                    </div>
                                                                    @if ($discount_amount)
                                                                        <div class="homes-tag button alt sale"
                                                                            style="background-color:#EA2B2E!important">
                                                                            İNDİRİM
                                                                        </div>
                                                                    @endif

                                                                    <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', $i + 1)->value }}"
                                                                        alt="{{ $project->housingType->title }}"
                                                                        class="img-responsive">
                                                                </div>
                                                            </div>
                                                            <div class="button-effect">
                                                                <span class="btn toggle-project-favorite bg-white"
                                                                    data-project-housing-id="{{ getHouse($project, 'squaremeters[]', $i + 1)->room_order }}"
                                                                    data-project-id={{ $project->id }}>
                                                                    <i class="fa fa-heart-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <!-- homes content -->
                                                        <div class="homes-content p-3">

                                                            <span style="text-decoration: none">
                                                                <h3>{{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}
                                                                    Projesinde
                                                                    {{ getHouse($project, 'squaremeters[]', $i + 1)->value }}m2
                                                                    {{ getHouse($project, 'room_count[]', $i + 1)->value }}
                                                                </h3>

                                                                <p class="homes-address mb-3">

                                                                    <i class="fa fa-map-marker"></i><span>
                                                                        {{ $project->city->title }} {{ '/' }}
                                                                        {{ $project->county->ilce_title }}
                                                                    </span>

                                                                </p>

                                                            </span>
                                                            <!-- homes List -->
                                                            <ul class="homes-list clearfix pb-0"
                                                                style="display: flex;justify-content:space-between">
                                                                <li class="sude-the-icons" style="width:auto !important">
                                                                    <i class="fa fa-circle circleIcon mr-1"></i>
                                                                    <span>{{ getHouse($project, 'room_count[]', $i + 1)->value }}</span>
                                                                </li>
                                                                <li class="sude-the-icons" style="width:auto !important">
                                                                    <i class="fa fa-circle circleIcon mr-1"
                                                                        aria-hidden="true"></i>
                                                                    <span>{{ getHouse($project, 'numberoffloors[]', $i + 1)->value }}
                                                                        @if ($project->step1_slug == 'konut')
                                                                            .Kat
                                                                        @else
                                                                            ₺
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                                <li class="sude-the-icons" style="width:auto !important">
                                                                    <i class="fa fa-circle circleIcon mr-1"
                                                                        aria-hidden="true"></i>
                                                                    <span>{{ getHouse($project, 'squaremeters[]', $i + 1)->value }}
                                                                        m2</span>
                                                                </li>
                                                            </ul>
                                                            <ul class="homes-list clearfix pb-0"
                                                                style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                                <li
                                                                    style="font-size: 16px; font-weight: 700;width:100%;white-space:nowrap">
                                                                    @if ($discount_amount)
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
                                                                    {{ number_format(getHouse($project, 'price[]', $i + 1)->value - $discount_amount, 2, ',', '.') }}
                                                                    ₺

                                                                </li>
                                                                <li
                                                                    style="display: flex; justify-content: right;width:100%">
                                                                    {{ date('j', strtotime($project->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($project->created_at))) }}
                                                                </li>
                                                            </ul>
                                                            <button class="CartBtn" data-type='project'
                                                                data-project='{{ $project->id }}'
                                                                data-id='{{ getHouse($project, 'price[]', $i + 1)->room_order }}'>
                                                                <span class="IconContainer">
                                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                                </span>
                                                                <span class="text">Sepete Ekle</span>
                                                            </button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endfor
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
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div class="section-title">
                    <h2>Yapım Aşamasındaki Projeler</h2>
                </div>
            </div>
            <div class="mobile-show">
                @foreach ($continueProjects as $project)
                    @for ($i = 0; $i < $project->room_count; $i++)
                        @php($room_order = getHouse($project, 'squaremeters[]', $i + 1)->room_order)
                        @php(
    $discount_amount =
        App\Models\Offer::where('type', 'project')->where('project_id', $project->id)->where('project_housings', 'LIKE', "%\"{$room_order}\"%")->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0
)
                        <div class="d-flex" style="flex-wrap: nowrap">
                            <div class="align-items-center d-flex" style="padding-right:0; width: 110px;">
                                <div class="project-inner project-head">
                                    <a
                                        href="{{ route('project.housings.detail', [$project->slug, getHouse($project, 'squaremeters[]', $i + 1)->room_order]) }}">
                                        <div class="homes">
                                            <!-- homes img -->

                                            <div class="homes-img h-100 d-flex align-items-center"
                                                style="width: 130px; height: 128px;">

                                                <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', $i + 1)->value }}"
                                                    alt="{{ $project->housingType->title }}" class="img-responsive"
                                                    style="height: 100px !important;">
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="w-100" style="padding-left:0;">
                                <div class="bg-white px-3 h-100 d-flex flex-column justify-content-center">

                                    <a style="text-decoration: none;height:100%"
                                        href="{{ route('project.housings.detail', [$project->slug, getHouse($project, 'squaremeters[]', $i + 1)->room_order]) }}">
                                        <h3>{{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}{{ ' ' }}Projesinde
                                            {{ getHouse($project, 'squaremeters[]', $i + 1)->value }}m2
                                            {{ getHouse($project, 'room_count[]', $i + 1)->value }}
                                        </h3>


                                    </a>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex" style="gap: 8px;">
                                            <a href="#" class="btn toggle-project-favorite bg-white"
                                                data-project-housing-id="{{ getHouse($project, 'squaremeters[]', $i + 1)->room_order }}"
                                                style="color: white;" data-project-id="{{ $project->id }}">
                                                <i class="fa fa-heart-o"></i>
                                            </a>
                                            <button class="addToCart mobile px-2"
                                                style="width: 100%; border: none; background-color: #274abb; border-radius: .25rem; padding: 5px 0px; color: white;"
                                                data-type='project' data-project='{{ $project->id }}'
                                                data-id='{{ getHouse($project, 'price[]', $i + 1)->room_order }}'>
                                                <img src="{{ asset('images/sc.png') }}" alt="sc" width="24px"
                                                    height="24px"
                                                    style="width: 24px !important; height: 24px !important;" />
                                            </button>
                                        </div>
                                        <span class="ml-auto text-primary priceFont">
                                            @if ($discount_amount)
                                                <svg viewBox="0 0 24 24" width="24" height="24"
                                                    stroke="currentColor" stroke-width="2" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                    <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                    <polyline points="17 18 23 18 23 12"></polyline>
                                                </svg>
                                            @endif
                                            {{ number_format(getHouse($project, 'price[]', $i + 1)->value - $discount_amount, 2, ',', '.') }}
                                            ₺
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-100" style="height:40px;background-color:#8080802e;margin-top:20px">
                            <ul class="d-flex justify-content-around align-items-center h-100"
                                style="list-style: none;padding:0;font-weight:600">
                                <li class="d-flex align-items-center itemCircleFont">
                                    <i class="fa fa-circle circleIcon"></i>
                                    No: {{ getHouse($project, 'squaremeters[]', $i + 1)->room_order }}
                                </li>
                                <li class="d-flex align-items-center itemCircleFont">
                                    <i class="fa fa-circle circleIcon"></i>
                                    {{ getHouse($project, 'squaremeters[]', $i + 1)->value }} m2
                                </li>
                                <li class="d-flex align-items-center itemCircleFont">
                                    <i class="fa fa-circle circleIcon"></i>
                                    {{ getHouse($project, 'room_count[]', $i + 1)->value }}
                                </li>
                                <li class="d-flex align-items-center itemCircleFont">
                                    <i class="fa fa-circle circleIcon"></i>
                                    {{ $project->city->title }} {{ '/' }} {{ $project->county->ilce_title }}
                                </li>



                            </ul>
                        </div>
                        <hr>
                    @endfor
                @endforeach
            </div>

            <div class="mobile-hidden">
                @if (count($continueProjects))
                    <div class="properties-right list featured portfolio blog pb-5 bg-white">
                        <div class="container">
                            <div class="row project-filter-reverse blog-pots finish-projects-web">
                                @foreach ($continueProjects as $project)
                                    @for ($i = 0; $i < $project->room_count; $i++)
                                        @php($room_order = getHouse($project, 'squaremeters[]', $i + 1)->room_order)
                                        @php(
    $discount_amount =
        App\Models\Offer::where('type', 'project')->where('project_id', $project->id)->where('project_housings', 'LIKE', "%\"{$room_order}\"%")->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0
)
                                        <div data-aos="fade-up" data-aos-delay="150">
                                            <a class="text-decoration-none"
                                                href="{{ route('project.housings.detail', [$project->slug, getHouse($project, 'squaremeters[]', $i + 1)->room_order]) }}">
                                                <div class="landscapes">
                                                    <div class="project-single">
                                                        <div class="project-inner project-head">
                                                            <div class="homes">
                                                                <!-- homes img -->

                                                                <div class="homes-img">
                                                                    <div class="homes-tag button alt featured">Öne
                                                                        Çıkan
                                                                    </div>
                                                                    @if ($discount_amount)
                                                                        <div class="homes-tag button alt sale"
                                                                            style="background-color:#EA2B2E!important">
                                                                            İNDİRİM
                                                                        </div>
                                                                    @endif

                                                                    <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', $i + 1)->value }}"
                                                                        alt="{{ $project->housingType->title }}"
                                                                        class="img-responsive">
                                                                </div>
                                                            </div>
                                                            <div class="button-effect">
                                                                <span class="btn toggle-project-favorite bg-white"
                                                                    data-project-housing-id="{{ getHouse($project, 'squaremeters[]', $i + 1)->room_order }}"
                                                                    data-project-id={{ $project->id }}>
                                                                    <i class="fa fa-heart-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <!-- homes content -->
                                                        <div class="homes-content p-3">

                                                            <span style="text-decoration: none">
                                                                <h3>{{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}
                                                                    Projesinde
                                                                    {{ getHouse($project, 'squaremeters[]', $i + 1)->value }}m2
                                                                    {{ getHouse($project, 'room_count[]', $i + 1)->value }}
                                                                </h3>

                                                                <p class="homes-address mb-3">

                                                                    <i class="fa fa-map-marker"></i><span>
                                                                        {{ $project->city->title }} {{ '/' }}
                                                                        {{ $project->county->ilce_title }}
                                                                    </span>

                                                                </p>

                                                            </span>
                                                            <!-- homes List -->
                                                            <ul class="homes-list clearfix pb-0"
                                                                style="display: flex;justify-content:space-between">
                                                                <li class="sude-the-icons" style="width:auto !important">
                                                                    <i class="fa fa-circle circleIcon mr-1"></i>
                                                                    <span>{{ getHouse($project, 'room_count[]', $i + 1)->value }}</span>
                                                                </li>
                                                                <li class="sude-the-icons" style="width:auto !important">
                                                                    <i class="fa fa-circle circleIcon mr-1"
                                                                        aria-hidden="true"></i>
                                                                    <span>{{ getHouse($project, 'numberoffloors[]', $i + 1)->value }}
                                                                        @if ($project->step1_slug == 'konut')
                                                                            .Kat
                                                                        @else
                                                                            ₺
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                                <li class="sude-the-icons" style="width:auto !important">
                                                                    <i class="fa fa-circle circleIcon mr-1"
                                                                        aria-hidden="true"></i>
                                                                    <span>{{ getHouse($project, 'squaremeters[]', $i + 1)->value }}
                                                                        m2</span>
                                                                </li>
                                                            </ul>
                                                            <ul class="homes-list clearfix pb-0"
                                                                style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                                <li
                                                                    style="font-size: 16px; font-weight: 700;width:100%;white-space:nowrap">
                                                                    @if ($discount_amount)
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
                                                                    {{ number_format(getHouse($project, 'price[]', $i + 1)->value - $discount_amount, 2, ',', '.') }}
                                                                    ₺

                                                                </li>
                                                                <li
                                                                    style="display: flex; justify-content: right;width:100%">
                                                                    {{ date('j', strtotime($project->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($project->created_at))) }}
                                                                </li>
                                                            </ul>
                                                            <button class="CartBtn" data-type='project'
                                                                data-project='{{ $project->id }}'
                                                                data-id='{{ getHouse($project, 'price[]', $i + 1)->room_order }}'>
                                                                <span class="IconContainer">
                                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                                </span>
                                                                <span class="text">Sepete Ekle</span>
                                                            </button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endfor
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
                    <h2>Topraktan Projeler</h2>
                </div>
            </div>
            <div class="mobile-show">
                @foreach ($soilProjects as $project)
                    @for ($i = 0; $i < $project->room_count; $i++)
                        @php($room_order = getHouse($project, 'squaremeters[]', $i + 1)->room_order)
                        @php(
    $discount_amount =
        App\Models\Offer::where('type', 'project')->where('project_id', $project->id)->where('project_housings', 'LIKE', "%\"{$room_order}\"%")->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0
)
                        <div class="d-flex" style="flex-wrap: nowrap">
                            <div class="align-items-center d-flex" style="padding-right:0; width: 110px;">
                                <div class="project-inner project-head">
                                    <a
                                        href="{{ route('project.housings.detail', [$project->slug, getHouse($project, 'squaremeters[]', $i + 1)->room_order]) }}">
                                        <div class="homes">
                                            <!-- homes img -->

                                            <div class="homes-img h-100 d-flex align-items-center"
                                                style="width: 130px; height: 128px;">

                                                <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', $i + 1)->value }}"
                                                    alt="{{ $project->housingType->title }}" class="img-responsive"
                                                    style="height: 100px !important;">
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="w-100" style="padding-left:0;">
                                <div class="bg-white px-3 h-100 d-flex flex-column justify-content-center">

                                    <a style="text-decoration: none;height:100%"
                                        href="{{ route('project.housings.detail', [$project->slug, getHouse($project, 'squaremeters[]', $i + 1)->room_order]) }}">
                                        <h3>{{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}{{ ' ' }}Projesinde
                                            {{ getHouse($project, 'squaremeters[]', $i + 1)->value }}m2
                                            {{ getHouse($project, 'room_count[]', $i + 1)->value }}
                                        </h3>


                                    </a>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex" style="gap: 8px;">
                                            <a href="#" class="btn toggle-project-favorite bg-white"
                                                data-project-housing-id="{{ getHouse($project, 'squaremeters[]', $i + 1)->room_order }}"
                                                style="color: white;" data-project-id="{{ $project->id }}">
                                                <i class="fa fa-heart-o"></i>
                                            </a>
                                            <button class="addToCart mobile px-2"
                                                style="width: 100%; border: none; background-color: #274abb; border-radius: .25rem; padding: 5px 0px; color: white;"
                                                data-type='project' data-project='{{ $project->id }}'
                                                data-id='{{ getHouse($project, 'price[]', $i + 1)->room_order }}'>
                                                <img src="{{ asset('images/sc.png') }}" alt="sc" width="24px"
                                                    height="24px"
                                                    style="width: 24px !important; height: 24px !important;" />
                                            </button>
                                        </div>
                                        <span class="ml-auto text-primary priceFont">
                                            @if ($discount_amount)
                                                <svg viewBox="0 0 24 24" width="24" height="24"
                                                    stroke="currentColor" stroke-width="2" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                    <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                    <polyline points="17 18 23 18 23 12"></polyline>
                                                </svg>
                                            @endif
                                            {{ number_format(getHouse($project, 'price[]', $i + 1)->value - $discount_amount, 2, ',', '.') }}
                                            ₺
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-100" style="height:40px;background-color:#8080802e;margin-top:20px">
                            <ul class="d-flex justify-content-around align-items-center h-100"
                                style="list-style: none;padding:0;font-weight:600">
                                <li class="d-flex align-items-center itemCircleFont">
                                    <i class="fa fa-circle circleIcon"></i>
                                    {{ getHouse($project, 'squaremeters[]', $i + 1)->room_order }} <span> No'lu

                                    </span>
                                </li>
                                <li class="d-flex align-items-center itemCircleFont">
                                    <i class="fa fa-circle circleIcon"></i>
                                    {{ getHouse($project, 'squaremeters[]', $i + 1)->value }} m2
                                </li>
                                <li class="d-flex align-items-center itemCircleFont">
                                    <i class="fa fa-circle circleIcon"></i>
                                    {{ getHouse($project, 'room_count[]', $i + 1)->value }}
                                </li>
                                <li class="d-flex align-items-center itemCircleFont">
                                    <i class="fa fa-circle circleIcon"></i>
                                    {{ $project->city->title }} {{ '/' }} {{ $project->county->ilce_title }}
                                </li>



                            </ul>
                        </div>
                        <hr>
                    @endfor
                @endforeach
            </div>

            <div class="mobile-hidden">
                @if (count($soilProjects))
                    <div class="properties-right list featured portfolio blog pb-5 bg-white">
                        <div class="container">
                            <div class="row project-filter-reverse blog-pots finish-projects-web">
                                @foreach ($soilProjects as $project)
                                    @for ($i = 0; $i < $project->room_count; $i++)
                                        @php($room_order = getHouse($project, 'squaremeters[]', $i + 1)->room_order)
                                        @php(
    $discount_amount =
        App\Models\Offer::where('type', 'project')->where('project_id', $project->id)->where('project_housings', 'LIKE', "%\"{$room_order}\"%")->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0
)
                                        <div data-aos="fade-up" data-aos-delay="150">
                                            <a class="text-decoration-none"
                                                href="{{ route('project.housings.detail', [$project->slug, getHouse($project, 'squaremeters[]', $i + 1)->room_order]) }}">
                                                <div class="landscapes">
                                                    <div class="project-single">
                                                        <div class="project-inner project-head">
                                                            <div class="homes">
                                                                <!-- homes img -->

                                                                <div class="homes-img">
                                                                    <div class="homes-tag button alt featured">Öne
                                                                        Çıkan
                                                                    </div>
                                                                    @if ($discount_amount)
                                                                        <div class="homes-tag button alt sale"
                                                                            style="background-color:#EA2B2E!important">
                                                                            İNDİRİM
                                                                        </div>
                                                                    @endif

                                                                    <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', $i + 1)->value }}"
                                                                        alt="{{ $project->housingType->title }}"
                                                                        class="img-responsive">
                                                                </div>
                                                            </div>
                                                            <div class="button-effect">
                                                                <span class="btn toggle-project-favorite bg-white"
                                                                    data-project-housing-id="{{ getHouse($project, 'squaremeters[]', $i + 1)->room_order }}"
                                                                    data-project-id={{ $project->id }}>
                                                                    <i class="fa fa-heart-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <!-- homes content -->
                                                        <div class="homes-content p-3">

                                                            <span style="text-decoration: none">
                                                                <h3>{{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}
                                                                    Projesinde
                                                                    {{ getHouse($project, 'squaremeters[]', $i + 1)->value }}m2
                                                                    {{ getHouse($project, 'room_count[]', $i + 1)->value }}
                                                                </h3>

                                                                <p class="homes-address mb-3">

                                                                    <i class="fa fa-map-marker"></i><span>
                                                                        {{ $project->city->title }} {{ '/' }}
                                                                        {{ $project->county->ilce_title }}
                                                                    </span>

                                                                </p>

                                                            </span>
                                                            <!-- homes List -->
                                                            <ul class="homes-list clearfix pb-0"
                                                                style="display: flex;justify-content:space-between">
                                                                <li class="sude-the-icons" style="width:auto !important">
                                                                    <i class="fa fa-circle circleIcon mr-1"></i>
                                                                    <span>{{ getHouse($project, 'room_count[]', $i + 1)->value }}</span>
                                                                </li>
                                                                <li class="sude-the-icons" style="width:auto !important">
                                                                    <i class="fa fa-circle circleIcon mr-1"
                                                                        aria-hidden="true"></i>
                                                                    <span>{{ getHouse($project, 'numberoffloors[]', $i + 1)->value }}
                                                                        @if ($project->step1_slug == 'konut')
                                                                            .Kat
                                                                        @else
                                                                            ₺
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                                <li class="sude-the-icons" style="width:auto !important">
                                                                    <i class="fa fa-circle circleIcon mr-1"
                                                                        aria-hidden="true"></i>
                                                                    <span>{{ getHouse($project, 'squaremeters[]', $i + 1)->value }}
                                                                        m2</span>
                                                                </li>
                                                            </ul>
                                                            <ul class="homes-list clearfix pb-0"
                                                                style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                                <li
                                                                    style="font-size: 16px; font-weight: 700;width:100%;white-space:nowrap">
                                                                    @if ($discount_amount)
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
                                                                    {{ number_format(getHouse($project, 'price[]', $i + 1)->value - $discount_amount, 2, ',', '.') }}
                                                                    ₺

                                                                </li>
                                                                <li
                                                                    style="display: flex; justify-content: right;width:100%">
                                                                    {{ date('j', strtotime($project->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($project->created_at))) }}
                                                                </li>
                                                            </ul>
                                                            <button class="CartBtn" data-type='project'
                                                                data-project='{{ $project->id }}'
                                                                data-id='{{ getHouse($project, 'price[]', $i + 1)->room_order }}'>
                                                                <span class="IconContainer">
                                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                                </span>
                                                                <span class="text">Sepete Ekle</span>
                                                            </button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endfor
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
                    <h2>İkinci El İlanlar</h2>
                </div>
            </div>
            <div class="mobile-show">
                @foreach ($secondhandHousings as $project)
                    @php(
    $discount_amount =
        App\Models\Offer::where('type', 'housing')->where('housing_id', $project->id)->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0
)

                    <div class="d-flex" style="flex-wrap: nowrap">
                        <div class="align-items-center d-flex " style="padding-right:0; width: 110px;">
                            <div class="project-inner project-head">
                                <a href="{{ route('housing.show', [$project->id]) }}">
                                    <div class="homes">
                                        <!-- homes img -->

                                        <div class="homes-img h-100 d-flex align-items-center"
                                            style="width: 130px; height: 128px;">
                                            <img src="{{ URL::to('/') . '/housing_images/' . json_decode($project->housing_type_data)->image }}"
                                                alt="{{ $project->housing_title }}" class="img-responsive"
                                                style="height: 100px !important;">
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="w-100" style="padding-left:0;">
                            <div class="bg-white px-3 h-100 d-flex flex-column justify-content-center">

                                <a style="text-decoration: none;height:100%"
                                    href="{{ route('housing.show', [$project->id]) }}">
                                    <h3>
                                        {{ mb_convert_case($project->housing_title, MB_CASE_TITLE, 'UTF-8') }}{{ ' ' }}
                                        {{ json_decode($project->housing_type_data)->squaremeters[0] ?? '?' }}m2
                                        {{ json_decode($project->housing_type_data)->room_count[0] ?? '?' }}
                                    </h3>
                                </a>
                                <div class="d-flex">
                                    <div class="d-flex" style="gap: 8px;">
                                        <a href="#" class="btn toggle-favorite bg-white"
                                            data-housing-id="{{ $project->id }}" style="color: white;">
                                            <i class="fa fa-heart-o"></i>
                                        </a>
                                        <button class="addToCart mobile px-2"
                                            style="width: 100%; border: none; background-color: #274abb; border-radius: .25rem; padding: 5px 0px; color: white;"
                                            data-type='housing' data-id='{{ $project->id }}'>
                                            <img src="{{ asset('images/sc.png') }}" alt="sc" width="24px"
                                                height="24px" style="width: 24px !important; height: 24px !important;" />
                                        </button>
                                    </div>
                                    <span class="ml-auto text-primary priceFont">
                                        @if ($discount_amount)
                                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                                stroke-width="2" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round" class="css-i6dzq1">
                                                <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                <polyline points="17 18 23 18 23 12"></polyline>
                                            </svg>
                                        @endif
                                        {{ number_format(json_decode($project->housing_type_data)->price[0] - $discount_amount, 2, ',', '.') }}

                                        ₺
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-100" style="height:40px;background-color:#8080802e;margin-top:20px">
                        <ul class="d-flex justify-content-around align-items-center h-100"
                            style="list-style: none;padding:0;font-weight:600">
                            <li class="d-flex align-items-center itemCircleFont">
                                <i class="fa fa-circle circleIcon"></i>
                                No: {{ $project->id }}
                            </li>
                            <li class="d-flex align-items-center itemCircleFont">
                                <i class="fa fa-circle circleIcon"></i>
                                {{ json_decode($project->housing_type_data)->squaremeters[0] ?? null }} m2
                            </li>
                            <li class="d-flex align-items-center itemCircleFont">
                                <i class="fa fa-circle circleIcon"></i>
                                {{ json_decode($project->housing_type_data)->room_count[0] ?? null }}
                            </li>
                            <li class="d-flex align-items-center itemCircleFont">
                                <i class="fa fa-circle circleIcon"></i>
                                {{ $project->city_title }} {{ '/' }} {{ $project->county_title }}
                            </li>



                        </ul>
                    </div>
                    <hr>
                @endforeach
            </div>
            <div class="mobile-hidden">
                @if (count($secondhandHousings))
                    <section class="properties-right list featured portfolio blog  pb-5 bg-white">
                        <a href="{{ route('housing.show', [$project->id]) }}" class="text-decoration-none">
                            <div class="container">
                                <div class="row project-filter-reverse blog-pots secondhand-housings-web">
                                    @foreach ($secondhandHousings as $project)
                                        <div data-aos="fade-up" data-aos-delay="150">
                                            <div class="landscapes">
                                                <div class="project-single">
                                                    <div class="project-inner project-head">
                                                        <div class="homes">
                                                            <!-- homes img -->

                                                            <div class="homes-img">
                                                                <div class="homes-tag button alt featured">Öne
                                                                    Çıkan
                                                                </div>
                                                                @if ($discount_amount)
                                                                    <div class="homes-tag button alt sale"
                                                                        style="background-color:#EA2B2E!important">İNDİRİM
                                                                    </div>
                                                                @endif

                                                                <img src="{{ URL::to('/') . '/housing_images/' . json_decode($project->housing_type_data)->image }}"
                                                                    alt="Housing {{ $project->id }}"
                                                                    class="img-responsive">
                                                            </div>
                                                        </div>
                                                        <div class="button-effect">
                                                            <span class="btn toggle-favorite bg-white"
                                                                data-housing-id={{ $project->id }}>
                                                                <i class="fa fa-heart-o"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <!-- homes content -->
                                                    <div class="homes-content p-3" style="padding:20px !important">
                                                        <span style="text-decoration: none">

                                                            <h4>{{ mb_convert_case($project->housing_title, MB_CASE_TITLE, 'UTF-8') }}
                                                            </h4>

                                                            <p class="homes-address mb-3">


                                                                <i class="fa fa-map-marker"></i>
                                                                <span> {{ $project->city_title }} {{ '/' }}
                                                                    {{ $project->county_title }}
                                                                </span>

                                                            </p>
                                                        </span>
                                                        <!-- homes List -->
                                                        <ul class="homes-list clearfix pb-0"
                                                            style="display: flex;justify-content:space-between">
                                                            <li class="sude-the-icons" style="width:auto !important">
                                                                <i class="fa fa-circle circleIcon mr-1"></i>
                                                                <span>{{ json_decode($project->housing_type_data)->room_count[0] ?? null }}</span>
                                                            </li>
                                                            <li class="sude-the-icons" style="width:auto !important">
                                                                <i class="fa fa-circle circleIcon mr-1"></i>
                                                                <span>{{ json_decode($project->housing_type_data)->numberoffloors[0] ?? null }}
                                                                    @if ($project->step1_slug == 'konut')
                                                                        .Kat
                                                                    @else
                                                                        ₺
                                                                    @endif
                                                                </span>
                                                            </li>
                                                            <li class="sude-the-icons" style="width:auto !important">
                                                                <i class="fa fa-circle circleIcon mr-1"></i>
                                                                <span>{{ json_decode($project->housing_type_data)->squaremeters[0] ?? null }}
                                                                    m2</span>
                                                            </li>
                                                        </ul>
                                                        <ul class="homes-list clearfix pb-0"
                                                            style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                            <li
                                                                style="font-size: 16px; font-weight: 700;width:100%; white-space:nowrap">
                                                                @if ($discount_amount)
                                                                    <svg viewBox="0 0 24 24" width="24"
                                                                        height="24" stroke="currentColor"
                                                                        stroke-width="2" fill="none"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="css-i6dzq1">
                                                                        <polyline points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                        </polyline>
                                                                        <polyline points="17 18 23 18 23 12"></polyline>
                                                                    </svg>
                                                                @endif
                                                                {{ number_format(json_decode($project->housing_type_data)->price[0], 2, ',', '.') }}
                                                                ₺
                                                            </li>
                                                            <li style="display: flex; justify-content: right;width:100%">
                                                                {{ date('j', strtotime($project->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($project->created_at))) }}
                                                            </li>
                                                        </ul>
                                                        <button class="CartBtn" data-type='housing'
                                                            data-id='{{ $project->id }}'>
                                                            <span class="IconContainer">
                                                                <img src="{{ asset('sc.png') }}" alt="">

                                                            </span>
                                                            <span class="text">Sepete Ekle</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </a>
                    </section>
                @else
                    <p>Henüz İlan Yayınlanmadı</p>
                @endif
            </div>
        </div>
    </section>
    <!-- END SECTION RECENTLY PROPERTIES -->


    {{-- <section class="real-estate popular-places bg-white ">
        <div class="container">

            <div class="section-title mbb ">
                <h2>Emlak 360</h2>
            </div>
            <div class="real-estate-body pt-5 border-top pb-5">
                <div class="row ">
                    <div class="col-md-2 col-6 text-center">
                        <div class="estate-item">
                            <img src="images/iconbar.png" style="width: 50px;" alt="">
                            <p>Emlak Endeksi</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-6 text-center">
                        <div class="estate-item">
                            <img src="images/Group 575.png" style="width: 50px;" alt="">
                            <p>Emlak Endeksi</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-6 text-center">
                        <div class="estate-item">
                            <img src="images/Group 576.png" style="width: 50px;" alt="">
                            <p>Emlak Endeksi</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-6 text-center">
                        <div class="estate-item">
                            <img src="images/Group 577.png" style="width: 50px;" alt="">
                            <p>Emlak Endeksi</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-6 text-center">
                        <div class="estate-item">
                            <img src="images/Group 578.png" style="width: 50px;" alt="">
                            <p>Emlak Endeksi</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-6 text-center">
                        <div class="estate-item">
                            <img src="images/Group 579.png" style="width: 50px;" alt="">
                            <p>Emlak Endeksi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- START SECTION INFO-HELP -->
    <section class="container">
        <div class="info-help h18">
            <div class="row info-head">
                <div class="col-lg-12 col-md-8 col-xs-8">
                    <div class="info-text" data-aos="fade-up" data-aos-delay="150">
                        <h3 class="text-center mb-0">Neden Biz</h3>
                        <p class="text-center mb-4 p-0">Lorem ipsum dolor sit amet consectetur.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END SECTION INFO HELP --> --}}

    {{-- <!-- START SECTION INFO -->
    <section class="featured-boxes-area bg-white-1 ">
        <div class="container">
            <div class="featured-boxes-inner">
                <div class="row m-0">
                    <div class="col-lg-3 col-sm-6 col-md-6 p-0" data-aos="fade-up" data-aos-delay="250">
                        <div class="single-featured-box">
                            <div class="icon color-fb7756"><img src="images/icons/i-1.svg" width="85" height="85"
                                    alt=""></div>
                            <h3 class="mt-5">Find Your Home</h3>
                            <p>Lorem ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan.
                            </p><a class="read-more-btn" href="single-property-1.html">Read More</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 p-0" data-aos="fade-up" data-aos-delay="350">
                        <div class="single-featured-box">
                            <div class="icon color-facd60"><img src="images/icons/i-2.svg" width="85" height="85"
                                    alt=""></div>
                            <h3 class="mt-5">Trusted by thousands</h3>
                            <p>Lorem ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan.
                            </p><a class="read-more-btn" href="single-property-1.html">Read More</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 p-0" data-aos="fade-up" data-aos-delay="450">
                        <div class="single-featured-box">
                            <div class="icon color-1ac0c6"><img src="images/icons/i-3.svg" width="85" height="85"
                                    alt=""></div>
                            <h3 class="mt-5">Financing made easy</h3>
                            <p>Lorem ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan.
                            </p><a class="read-more-btn" href="single-property-1.html">Read More</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 p-0" data-aos="fade-up" data-aos-delay="550">
                        <div class="single-featured-box">
                            <div class="icon"><img src="images/icons/i-4.svg" width="85" height="85"
                                    alt=""></div>
                            <h3 class="mt-5">24/7 support</h3>
                            <p>Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan.</p>
                            <a class="read-more-btn" href="single-property-1.html">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END SECTION INFO --> --}}




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
                                <div class="recent-img16 sliderSize img-fluid img-center mobile-show"
                                    style="background-image: url({{ url('storage/footer-sliders/' . $slider->mobile_image) }});">
                                </div>

                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $('.finish-projects-web').slick({
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 1,
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
            slidesToScroll: 1,
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
            slidesToScroll: 1,
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
        @media (max-width: 768px) {
            .section-title {
                margin-bottom: 20px !important;
                padding-bottom: 0 !important;
            }

            .circleIcon {
                font-size: 5px;
                color: #e54242;
                padding-right: 5px
            }

            .priceFont {
                font-weight: 600;
                font-size: 14px;
            }
        }
    </style>
@endsection
