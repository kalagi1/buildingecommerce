@extends('client.layouts.master')

@section('content')

    <x-store-card :store="$project->user" :project="$project" />



    <section class="recently portfolio bg-white homepage-5 ">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- main slider carousel items -->
                    <div id="listingDetailsSlider" class="carousel listing-details-sliders slide mb-30">
                        <!-- <h5 class="mb-4">Gallery</h5> -->
                        <div class="carousel-inner">
                            @foreach ($project->images as $key => $item)
                                <div class="@if ($key == 0) active @endif item carousel-item"
                                    data-slide-number="{{ $key }}">
                                    <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $item->image) }}"
                                        class="img-fluid" alt="slider-listing">
                                </div>
                            @endforeach

                            <a class="carousel-control left" href="#listingDetailsSlider" data-slide="prev"><i
                                    class="fa fa-angle-left"></i></a>
                            <a class="carousel-control right" href="#listingDetailsSlider" data-slide="next"><i
                                    class="fa fa-angle-right"></i></a>

                        </div>
                        <!-- main slider carousel nav controls -->
                        <ul class="carousel-indicators smail-listing list-inline">
                            @foreach ($project->images as $key => $item)
                                <li class="list-inline-item @if ($key == 0) active @endif ">
                                    <a id="carousel-selector-{{ $key }}" data-slide-to="{{ $key }}"
                                        @if ($key == 0) class="selected" @endif
                                        data-target="#listingDetailsSlider">
                                        <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $item->image) }}"
                                            class="img-fluid" alt="listing-small">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="widget-boxed">
                        <div class="widget-boxed-header">
                            <h4>{{ $project->project_title }}</h4>
                        </div>
                        <div class="widget-boxed-body">
                            <div class="sidebar-widget author-widget2">
                                <div class="author-box clearfix">
                                    <img src="{{ URL::to('/') . '/storage/profile_images/' . $project->user->profile_image }}"
                                        alt="author-image" class="author__img">
                                    <h4 class="author__title">{!! $project->user->name !!}</h4>
                                    <p class="author__meta">{{ $project->user->corporate_type }}</p>
                                </div>
                                <ul class="author__contact">
                                    <li><span class="la la-map-marker"><i class="fa fa-map-marker"></i></span>
                                        {!! $project->city->title !!} {{ '/' }} {!! $project->county->ilce_title !!}
                                    </li>

                                    @if ($project->user->phone)
                                        <li><span class="la la-phone"><i class="fa fa-phone"
                                                    aria-hidden="true"></i></span><a
                                                style="text-decoration: none;color:inherit"
                                                href="tel:{!! $project->user->phone !!}">{!! $project->user->phone !!}</a>
                                        </li>
                                    @endif


                                    <li><span class="la la-envelope-o"><i class="fa fa-envelope"
                                                aria-hidden="true"></i></span><a style="text-decoration: none;color:inherit"
                                            href="mailto:{!! $project->user->email !!}">{!! $project->user->email !!}</a></li>
                                    <li><span class="la la-home-o"><i class="fa fa-home" aria-hidden="true"></i></span>
                                        {{ $project->room_count }} Adet Konut</li>

                                    <li><span class="la la-info-o"><i class="fa fa-info" aria-hidden="true"></i></span>
                                        {{ $project->housingtype->title }}</li>
                                </ul>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="blog-section mt-3">
                        <div class="news-item news-item-sm">
                            <div class="news-item-text">

                                <div class="blog-info details mb-30">
                                    <h3 class="mb-4">Açıklama</h3>
                                    <p class="mb-3">{!! $project->description !!}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    @php
        function getData($project, $key, $roomOrder)
        {
            foreach ($project->roomInfo as $room) {
                if ($room->room_order == $roomOrder && $room->name == $key) {
                    return $room;
                }
            }
        }
    @endphp


    <section class="properties-right list featured portfolio blog pb-5 bg-white">
        <div class="mobile-hidden">
            <div class="container">
                <div class="row project-filter-reverse blog-pots">
                    @for ($i = 0; $i < $project->room_count; $i++)
                        @php
                            $sold = DB::select(
                                'SELECT * FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "project"  AND JSON_EXTRACT(cart, "$.item.housing") = ? AND JSON_EXTRACT(cart, "$.item.id") = ? LIMIT 1',
                                [$i + 1, $project->id],
                            );
                        @endphp

                        <div class="col-md-12 col-12">
                            <div class="project-card mb-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <a href="{{ route('project.housings.detail', [
                                            'projectSlug' =>
                                                $project->slug .
                                                '-' .
                                                $status->slug .
                                                '-' .
                                                $project->step2_slug .
                                                '-' .
                                                $project->housingtype->slug .
                                                '-' .
                                                strtolower($project->city->title) .
                                                '-' .
                                                strtolower($project->county->ilce_title),
                                            'projectID' => $project->id + 1000000,
                                            'housingOrder' => $i + 1,
                                        ]) }}"
                                            style="height: 100%">
                                            <div class="d-flex" style="height: 100%;">
                                                <div
                                                    style="background-color: #EA2B2E !important; border-radius: 0px 8px 0px 8px;height:100%">
                                                    <p
                                                        style="padding: 10px; color: white; height: 100%; display: flex; align-items: center;text-align:center; ">
                                                        No <br>
                                                        {{ $i + 1 }}</p>
                                                </div>
                                                <div class="project-single mb-0 bb-0 aos-init aos-animate"
                                                    data-aos="fade-up">
                                                    <div class="project-inner project-head">

                                                        <div class="button-effect">
                                                            <div href="javascript:void()"
                                                                class="btn toggle-project-favorite bg-white"
                                                                data-project-housing-id="{{ $i + 1 }}"
                                                                data-project-id={{ $project->id }}>
                                                                <i class="fa fa-heart-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="homes position-relative">
                                                            <!-- homes img -->
                                                            <img src="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[$i + 1]['image[]'] }}"
                                                                alt="home-1" class="img-responsive"
                                                                style="height: 120px !important;object-fit:cover">
                                                            @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                <div
                                                                    style="z-index: 2;right: 0;top: 0;background: #e54242; width: 96px; height: 96px; position: absolute; clip-path: polygon(0 0, 45% 0, 100% 55%, 100% 100%);">
                                                                    <div
                                                                        style="color: #FFF; transform: rotate(45deg); margin-left: 25px; margin-top: 30px; font-weight: bold;">
                                                                        {{ '%' . round(($offer->discount_amount / $projectHousingsList[$i + 1]['price[]']) * 100) }}
                                                                        <svg viewBox="0 0 24 24" width="16"
                                                                            height="16" stroke="currentColor"
                                                                            stroke-width="2" fill="none"
                                                                            stroke-linecap="round" stroke-linejoin="round"
                                                                            class="css-i6dzq1"
                                                                            style="transform: rotate(45deg);">
                                                                            <polyline points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                            </polyline>
                                                                            <polyline points="17 18 23 18 23 12">
                                                                            </polyline>
                                                                        </svg>
                                                                    </div>

                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>


                                    <div class="col-lg-9 col-md-9 homes-content pb-0 mb-44 aos-init aos-animate"
                                        data-aos="fade-up">

                                        <div class="row align-items-center justify-content-between mobile-position"
                                            @if ($sold && $sold->status != '2') style="background: #EEE !important;" @endif>
                                            <div class="col-md-8">

                                                <div class="homes-list-div">

                                                    <ul class="homes-list clearfix pb-3 d-flex">
                                                        <li class="the-icons custom-width">
                                                            <i class="fa fa-circle circleIcon mr-1" style="color: black;"
                                                                aria-hidden="true"></i>
                                                            <span>{{ $project->housingType->title }}</span>
                                                        </li>
                                                        @if (isset($project->listItemValues) &&
                                                                isset($project->listItemValues->column1_name) &&
                                                                $project->listItemValues->column1_name)
                                                            <li class="the-icons custom-width flex-1">
                                                                <i class="fa fa-circle circleIcon mr-1"
                                                                    aria-hidden="true"></i>
                                                                <span>
                                                                    {{ $projectHousingsList[$i + 1][$project->listItemValues->column1_name . '[]'] }}
                                                                    @if (isset($project->listItemValues) &&
                                                                            isset($project->listItemValues->column1_additional) &&
                                                                            $project->listItemValues->column1_additional)
                                                                        {{ $project->listItemValues->column1_additional }}
                                                                    @endif
                                                                </span>
                                                            </li>
                                                        @endif
                                                        @if (isset($project->listItemValues) &&
                                                                isset($project->listItemValues->column2_name) &&
                                                                $project->listItemValues->column2_name)
                                                            <li class="the-icons custom-width flex-1">
                                                                <i class="fa fa-circle circleIcon mr-1"
                                                                    aria-hidden="true"></i>
                                                                <span>
                                                                    {{ $projectHousingsList[$i + 1][$project->listItemValues->column2_name . '[]'] }}
                                                                    @if (isset($project->listItemValues) &&
                                                                            isset($project->listItemValues->column2_additional) &&
                                                                            $project->listItemValues->column2_additional)
                                                                        {{ $project->listItemValues->column2_additional }}
                                                                    @endif
                                                                </span>
                                                            </li>
                                                        @endif
                                                        @if (isset($project->listItemValues) &&
                                                                isset($project->listItemValues->column3_name) &&
                                                                $project->listItemValues->column3_name)
                                                            <li class="the-icons custom-width flex-1">
                                                                <i class="fa fa-circle circleIcon mr-1"
                                                                    aria-hidden="true"></i>
                                                                <span>
                                                                    {{ $projectHousingsList[$i + 1][$project->listItemValues->column3_name . '[]'] }}
                                                                    @if (isset($project->listItemValues) &&
                                                                            isset($project->listItemValues->column3_additional) &&
                                                                            $project->listItemValues->column3_additional)
                                                                        {{ $project->listItemValues->column3_additional }}
                                                                    @endif
                                                                </span>
                                                            </li>
                                                        @endif

                                                        <li class="the-icons mobile-hidden">
                                                            <span>
                                                                @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                    <h6
                                                                        style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'] - $offer->discount_amount, 0, ',', '.') }}
                                                                        ₺</h6>
                                                                    <h6
                                                                        style="color: #EA2B2E !important;position: relative;top:4px;font-weight:600;font-size: 11px;text-decoration:line-through;">
                                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                        ₺

                                                                    </h6>
                                                                @else
                                                                    <h6
                                                                        style="color: #EA2B2E !important;position: relative;top:4px;font-weight:600">
                                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                        ₺
                                                                    </h6>
                                                                @endif
                                                            </span>
                                                        </li>


                                                    </ul>

                                                </div>
                                                <div class="footer">
                                                    <a
                                                        href="{{ route('institutional.profile', ['slug' => Str::slug($project->user->name), 'userID' => $project->user->id]) }}">
                                                        <img src="{{ url('storage/profile_images/' . $project->user->profile_image) }}"
                                                            alt="" class="mr-2"> {{ $project->user->name }}
                                                    </a>
                                                    <span class="price-mobile">
                                                        @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                            <h6
                                                                style="color: #EA2B2E !important;position: relative;top:4px;font-weight:600;font-size: 11px;text-decoration:line-through;margin-right:5px">
                                                                {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                                ₺
                                                            </h6>
                                                            <h6
                                                                style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:20px;">
                                                                {{ number_format($projectHousingsList[$i + 1]['price[]'] - $offer->discount_amount, 0, ',', '.') }}

                                                                ₺</h6>
                                                        @else
                                                            <h6
                                                                style="color: #EA2B2E !important;position: relative;top:4px;font-weight:600">
                                                                {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}₺
                                                            </h6>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mobile-hidden" style="height: 120px;padding:0">
                                                <div class="homes-button" style="width:100%;height:100%">
                                                    <button class="first-btn payment-plan-button"
                                                        data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0)) || $projectHousingsList[$i + 1]['off_sale[]'] != '["Sat\u0131\u015fa A\u00e7\u0131k"]' ? '1' : '0' }}"
                                                        project-id="{{ $project->id }}" order="{{ $i }}">
                                                        Ödeme Detayları </button>
                                                    @if ($sold && $sold[0]->status != '2')
                                                        <button class="btn second-btn soldBtn" disabled
                                                            @if ($sold[0]->status == '0') style="background: orange !important;color:White"
                                                    @else 
                                                    style="background: #EA2B2E !important;color:White" @endif>
                                                            @if ($sold[0]->status == '0')
                                                                <span class="text">Rezerve Edildi</span>
                                                            @else
                                                                <span class="text">Satıldı</span>
                                                            @endif
                                                        </button>
                                                    @else
                                                        <button class="CartBtn second-btn" data-type='project'
                                                            data-project='{{ $project->id }}'
                                                            data-id='{{ $i + 1 }}'>
                                                            <span class="IconContainer">
                                                                <img src="{{ asset('sc.png') }}" alt="">
                                                            </span>
                                                            <span class="text">Sepete Ekle</span>
                                                        </button>
                                                    @endif

                                                </div>
                                            </div>


                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
        <div class="mobile-show">
            <div class="container">
                @for ($i = 0; $i < $project->room_count; $i++)
                    @php
                        $room_order = $i + 1;
                        $discount_amount =
                            App\Models\Offer::where('type', 'project')
                                ->where('project_id', $project->id)
                                ->where('project_housings', 'LIKE', "%\"{$room_order}\"%")
                                ->where('start_date', '<=', date('Y-m-d H:i:s'))
                                ->where('end_date', '>=', date('Y-m-d H:i:s'))
                                ->first()->discount_amount ?? 0;
                    @endphp
                    <div class="d-flex" style="flex-wrap: nowrap">
                        <div class="align-items-center d-flex" style="padding-right:0; width: 110px;">
                            <div class="project-inner project-head">
                                <a
                                    href="{{ route('project.housings.detail', [
                                        'projectSlug' =>
                                            $statusSlug .
                                            '-' .
                                            $project->step2_slug .
                                            '-' .
                                            $project->housingtype->slug .
                                            '-' .
                                            $project->slug .
                                            '-' .
                                            strtolower($project->city->title) .
                                            '-' .
                                            strtolower($project->county->ilce_title),
                                        'projectID' => $project->id + 1000000,
                                        'housingOrder' => $room_order,
                                    ]) }}">
                                    <div class="homes">
                                        <!-- homes img -->
                                        <div class="homes-img h-100 d-flex align-items-center"
                                            style="width: 130px; height: 128px;">
                                            <img src="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[$i + 1]['image[]'] }}"
                                                alt="{{ $project->housingType->title }}" class="img-responsive"
                                                style="height: 80px !important;">
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="w-100" style="padding-left:0;">
                            <div class="bg-white px-3 h-100 d-flex flex-column justify-content-center">
                                <a style="text-decoration: none; height: 100%"
                                    href="{{ route('project.housings.detail', [
                                        'projectSlug' =>
                                            $project->slug .
                                            '-' .
                                            $status->slug .
                                            '-' .
                                            $project->step2_slug .
                                            '-' .
                                            $project->housingtype->slug .
                                            '-' .
                                            strtolower($project->city->title) .
                                            '-' .
                                            strtolower($project->county->ilce_title),
                                        'projectID' => $project->id + 1000000,
                                        'housingOrder' => $room_order,
                                    ]) }}">
                                    <h3>
                                        @php($advertiseTitle = $projectHousingsList[$i + 1]['advertise_title[]'] ?? null)

                                        @if ($advertiseTitle)
                                            {{ $advertiseTitle }}
                                        @else
                                            {{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}
                                            Projesinde
                                            {{ $i + 1 }} {{ "No'lu" }} {{ $project->step1_slug }}
                                        @endif
                                    </h3>
                                </a>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex" style="gap: 8px;">
                                        <span class="btn toggle-project-favorite bg-white"
                                            data-project-housing-id="{{ $i + 1 }}" style="color: white;"
                                            data-project-id="{{ $project->id }}">
                                            <i class="fa fa-heart-o"></i>
                                        </span>
                                        <button class="addToCart mobile px-2"
                                            style="width: 100%; border: none; background-color: #274abb; border-radius: .25rem; padding: 5px 0px; color: white;"
                                            data-type='project' data-project='{{ $project->id }}'
                                            data-id='{{ $i + 1 }}'>
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
                                        {{ number_format($projectHousingsList[$i + 1]['price[]'] - $discount_amount, 0, ',', '.') }}
                                        ₺
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-100" style="height: 40px; background-color: #8080802e; margin-top: 15px">
                        <div class="d-flex justify-content-between align-items-center" style="height: 100%">
                            <span
                                style="    height: 100%;
                            font-size: 11px !important;
                            width: 15% !important;
                            padding: 3px 10px;
                            background: #EA2B2E !important;
                            color: white;
                            text-align: center;">No
                                <br> {{ $room_order }}</span>
                            <ul class="d-flex justify-content-start align-items-center h-100 w-100"
                                style="list-style: none;padding:0;font-weight:600;padding: 10px;justify-content:start;margin-bottom:0 !important">

                                @if (isset($project->listItemValues) &&
                                        isset($project->listItemValues->column1_name) &&
                                        $project->listItemValues->column1_name)
                                    <li class="d-flex align-items-center itemCircleFont">
                                        <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                        <span>
                                            {{ $projectHousingsList[$i + 1][$project->listItemValues->column1_name . '[]'] }}
                                            @if (isset($project->listItemValues) &&
                                                    isset($project->listItemValues->column1_additional) &&
                                                    $project->listItemValues->column1_additional)
                                                {{ $project->listItemValues->column1_additional }}
                                            @endif
                                        </span>
                                    </li>
                                @endif
                                @if (isset($project->listItemValues) &&
                                        isset($project->listItemValues->column2_name) &&
                                        $project->listItemValues->column2_name)
                                    <li class="d-flex align-items-center itemCircleFont">
                                        <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                        <span>
                                            {{ $projectHousingsList[$i + 1][$project->listItemValues->column2_name . '[]'] }}
                                            @if (isset($project->listItemValues) &&
                                                    isset($project->listItemValues->column2_additional) &&
                                                    $project->listItemValues->column2_additional)
                                                {{ $project->listItemValues->column2_additional }}
                                            @endif
                                        </span>
                                    </li>
                                @endif
                                @if (isset($project->listItemValues) &&
                                        isset($project->listItemValues->column3_name) &&
                                        $project->listItemValues->column3_name)
                                    <li class="d-flex align-items-center itemCircleFont">
                                        <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                        <span>
                                            {{ $projectHousingsList[$i + 1][$project->listItemValues->column3_name . '[]'] }}
                                            @if (isset($project->listItemValues) &&
                                                    isset($project->listItemValues->column3_additional) &&
                                                    $project->listItemValues->column3_additional)
                                                {{ $project->listItemValues->column3_additional }}
                                            @endif
                                        </span>
                                    </li>
                                @endif
                            </ul>

                            <span
                                style="    font-size: 11px !important;
                                width: 60% !important;
                                text-align: right;
                                margin-right: 10px;">{!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}</span>
                        </div>
                    </div>
                    <hr>
                @endfor
            </div>
        </div>



    </section>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
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
                                slidesToShow: 4,
                                slidesToScroll: 4,
                                dots: false,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 769,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
                                dots: false,
                                arrows: false
                            }
                        }
                    ]
                });
            })
            .catch(error => console.error('Hata:', error));
    </script>
    <script>
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
                    // Hata durumunda buraya gelir
                    toast.error(error)
                    console.error("Hata oluştu: " + error);
                }
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        .mobile-hidden {
            display: flex;
        }

        .desktop-hidden {
            display: none;
        }

        .homes-content .footer {
            display: none
        }

        .price-mobile {
            display: flex;
            align-items: self-end;
        }

        @media (max-width: 768px) {
            .mobile-hidden {
                display: none
            }

            .desktop-hidden {
                display: block;
            }

            .mobile-position {
                width: 100%;
                margin: 0 auto;
                box-shadow: 0 0 10px 1px rgba(71, 85, 95, 0.08);
            }

            .inner-pages .portfolio .homes-content .homes-list-div ul {
                flex-wrap: wrap
            }

            .homes-content .footer {
                display: block;
                background: none;
                border-top: 1px solid #e8e8e8;
                padding-top: 1rem;
                font-size: 13px;
                color: #666;
            }

        }
    </style>
@endsection
