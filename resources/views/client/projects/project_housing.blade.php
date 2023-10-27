@extends('client.layouts.master')

@section('content')
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

    @php
        $discountAmount = 0;

        $offer = App\Models\Offer::where('type', 'project')
            ->where('project_id', $project->id)
            ->where('project_housings', 'LIKE', '%' . getData($project, 'price[]', $housingOrder)->room_order . '%')
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->where('end_date', '>=', date('Y-m-d H:i:s'))
            ->first();

        if ($offer) {
            $discountAmount = $offer->discount_amount;
        }
    @endphp

    <section class="single-proper blog details bg-white">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="container">
                        <section class="headings-2 pt-0">
                            <div class="pro-wrapper" style="width: 100%; justify-content: space-between;">
                                <div class="detail-wrapper-body">
                                    <div class="listing-title-bar">
                                        <h3>{{ $project->project_title }} Projesinde
                                            {{ getData($project, 'squaremeters[]', $housingOrder)->value }}m2
                                            {{ getData($project, 'room_count[]', $housingOrder)->value }}
                                            {{ $project->housingType->title }} </h3>
                                        <div class="mt-0">
                                            <a href="#listing-location" class="listing-address">
                                                <i class="fa fa-map-marker pr-2 ti-location-pin mrg-r-5"></i>
                                                {!! $project->city->title !!} {{ '/' }} {!! $project->county->ilce_title !!}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="single detail-wrapper mr-2">
                                    <div class="detail-wrapper-body">
                                        <div class="listing-title-bar">
                                            <h4 style="white-space: nowrap">

                                                @if ($discountAmount)
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline><polyline points="17 18 23 18 23 12"></polyline></svg>
                                                    
                                                @endif
                                                {{ number_format(getData($project, 'price[]', $housingOrder)->value - $discountAmount, 2, ',', '.') }}
                                                ₺</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <div class="button-effect toggle-project-favorite"
                                data-project-housing-id="{{ getData($project, 'squaremeters[]', $housingOrder)->room_order }}"
                                data-project-id={{ $project->id }}>
                                <i class="fa fa-heart"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <button class="CartBtn" data-type='project' data-project='{{ $project->id }}'
                                data-id='{{ getData($project, 'price[]', $housingOrder)->room_order }}'>
                                <span class="IconContainer">
                                    <img src="{{ asset('sc.png') }}" alt="">
                                </span>
                                <span class="text">Sepete Ekle</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-12 blog-pots">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- main slider carousel items -->
                            <div id="listingDetailsSlider" class="carousel listing-details-sliders slide mb-30">
                                <!-- <h5 class="mb-4">Gallery</h5> -->
                                <div class="carousel-inner">

                                    @foreach ($project->images as $key => $housingImage)
                                        <div class="@if ($key == 0) active @endif item carousel-item"
                                            data-slide-number="{{ $key }}">
                                            <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $housingImage->image) }}"
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
                                    @foreach ($project->images as $key => $housingImage)
                                        <li class="list-inline-item active">
                                            <a id="carousel-selector-0" class="selected"
                                                data-slide-to="{{ $key }}" data-target="#listingDetailsSlider">
                                                <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $housingImage->image) }}"
                                                    class="img-fluid" alt="listing-small">
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
                                <!-- main slider carousel items -->
                            </div>

                        </div>
                    </div>
                    <div class="similar-property featured portfolio p-0 bg-white">
                        <div class="blog-info details mb-30">
                            <h5 class="mb-4">Açıklama</h5>
                            <p class="mb-3">{!! $project->description !!}</p>
                        </div>
                        <div class="single homes-content details mb-30">

                            <h5 class="mb-4">Bina Özellikleri</h5>
                            @php
                                function implodeData($array)
                                {
                                    $html = '';

                                    for ($i = 0; $i < count($array); $i++) {
                                        if ($i == 0) {
                                            $html .= ' ' . $array[$i];
                                        } else {
                                            $html .= ', ' . $array[$i];
                                        }
                                    }

                                    return $html;
                                }
                            @endphp
                            <ul class="homes-list clearfix">

                                @foreach ($projectHousingSetting as $housingSetting)
                                    @php
                                        $isArrayCheck = $housingSetting->is_array;
                                        $onProject = false;
                                        if ($isArrayCheck) {
                                            $onProject = false;
                                            $valueArray = json_decode($projectHousing[$housingSetting->column_name . '[]']['value']);
                                            $value = implodeData($valueArray);
                                        } elseif ($housingSetting->is_parent_table) {
                                            $value = $project[$housingSetting->column_name];
                                            $onProject = true;
                                        } else {
                                            foreach ($project->roomInfo as $roomInfo) {
                                                if ($roomInfo['name'] === $housingSetting->column_name . '[]') {
                                                    if ($roomInfo['value'] == '["on"]') {
                                                        $value = 'Evet';
                                                    } elseif ($roomInfo['value'] == '["off"]') {
                                                        $value = 'Hayır';
                                                    } else {
                                                        $value = $roomInfo['value'];
                                                    }
                                                    $onProject = true;
                                                }
                                            }
                                        }
                                    @endphp
                                    <li style="border: none !important;">
                                        @if ($onProject)
                                            <span class="font-weight-bold mr-1">{{ $housingSetting->label }}:</span> <span
                                                class="det">
                                                {{ $value }}
                                            </span>
                                        @endif

                                    </li>
                                @endforeach

                            </ul>
                            @foreach ($projectHousingSetting as $housingSetting)
                                @php
                                    $isArrayCheck = $housingSetting->is_array;
                                    $onProject = false;
                                    if ($isArrayCheck) {
                                        $onProject = false;
                                        $valueArray = json_decode($projectHousing[$housingSetting->column_name . '[]']['value']);
                                        $value = implodeData($valueArray);
                                    } elseif ($housingSetting->is_parent_table) {
                                        $value = $project[$housingSetting->column_name];
                                        $onProject = true;
                                    } else {
                                        foreach ($project->roomInfo as $roomInfo) {
                                            if ($roomInfo['name'] === $housingSetting->column_name . '[]') {
                                                if ($roomInfo['value'] == '["on"]') {
                                                    $value = 'Evet';
                                                } elseif ($roomInfo['value'] == '["off"]') {
                                                    $value = 'Hayır';
                                                } else {
                                                    $value = $roomInfo['value'];
                                                }
                                                $onProject = true;
                                            }
                                        }
                                    }
                                @endphp

                                @if (!$onProject)
                                    <h5 class="mt-5">{{ $projectHousing[$housingSetting->column_name . '[]']['key'] }}:
                                    </h5>
                                    <span>
                                        <ul class="homes-list clearfix">
                                            @foreach ($valueArray as $ozellik)
                                                <li><i class="fa fa-check-square"
                                                        aria-hidden="true"></i><span>{{ $ozellik }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </span>
                                @endif
                            @endforeach
                        </div>

                    </div>

                </div>
                <aside class="col-md-4  car">
                    <div class="single widget">
                        <div class="widget-boxed">
                            <div class="widget-boxed-header">
                                <h4>Satıcı Bilgileri</h4>
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
                                        <li><span class="la la-phone"><i class="fa fa-phone"
                                                    aria-hidden="true"></i></span><a
                                                style="text-decoration: none;color:inherit"
                                                href="tel:{!! $project->user->phone !!}">{!! $project->user->phone !!}</a>
                                        </li>
                                        <li><span class="la la-envelope-o"><i class="fa fa-envelope"
                                                    aria-hidden="true"></i></span><a
                                                style="text-decoration: none;color:inherit"
                                                href="mailto:{!! $project->user->email !!}">{!! $project->user->email !!}</a></li>
                                    </ul>
                                </div>
                                <hr>
                                <div class="first-footer">
                                    <ul class="netsocials px-2">
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
                        <div class="widget-boxed popular mt-5">
                            <div class="widget-boxed-header">
                                <h4>Satıcının Diğer Projeleri</h4>
                            </div>
                            <div class="widget-boxed-body">
                                <div class="recent-post">
                                    <div class="tags">
                                        @foreach ($project->user->projects as $item)
                                            <span><a href="{{ route('project.detail', ['slug' => $item->slug]) }}"
                                                    class="btn btn-outline-primary">{{ $item->project_title }}</a></span>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-boxed popular mt-5">
                            <div class="widget-boxed-header">
                                <h4>{!! $project->user->name !!}</h4>
                            </div>
                            <div class="widget-boxed-body">
                                @if (count($project->user->banners) > 0)
                                    @php
                                        $randomBanner = $project->user->banners[0];
                                        $imagePath = asset('storage/store_banners/' . $randomBanner['image']);
                                    @endphp
                                    <div class="banner"><img src="{{ $imagePath }}" alt=""></div>
                                @else
                                    <p>No banners available.</p>
                                @endif
                            </div>
                        </div>

                    </div>
                </aside>

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
                                        <img src="https://www.sahibinden.com/assets/images/durak:7299b7f721d8e670e9d070f1f816991a.png" alt="">
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
                                slidesToShow: 2,
                                slidesToScroll: 2,
                                dots: false,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 769,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                dots: false,
                                arrows: false
                            }
                        }
                    ]
                });
            })
            .catch(error => console.error('Hata:', error));
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        .button-effect {
            border: solid 1px #e6e6e6;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .housing-detail-box {
            display: flex;
            align-items: center;
            flex-wrap: wrap
        }
    </style>
@endsection
