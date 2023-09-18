@extends('client.layouts.master')

@section('content')

@php
    function getData($project,$key,$roomOrder){
        foreach ($project->roomInfo as  $room) {
            if($room->room_order == $roomOrder && $room->name == $key){
                return $room;
            }
        }
    }

    $housingImages = getData($project,'images[]',$housingOrder);
    $housingImages = json_decode($housingImages->value);
@endphp

<section class="single-proper blog details bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="container">
                    <section class="headings-2 pt-0">
                        <div class="pro-wrapper" style="width: 100%; justify-content: space-between;">
                            <div class="detail-wrapper-body">
                                <div class="listing-title-bar">
                                    <h3>{{$project->project_title}} Projesinde {{getData($project,'squaremeters[]',$housingOrder)->value}}m2 {{getData($project,'room_count[]',$housingOrder)->value}} {{$project->housingType->title}} </h3>
                                    <div class="mt-0">
                                        <a href="#listing-location" class="listing-address">
                                            <i
                                                class="fa fa-map-marker pr-2 ti-location-pin mrg-r-5"></i>{{ucfirst(strtolower($project->city->title))}}
                                            / {{ucfirst(strtolower($project->county->title))}} / {{$project->address}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="single detail-wrapper mr-2">
                                <div class="detail-wrapper-body">
                                    <div class="listing-title-bar">
                                        <h4>{{getData($project,'price[]',$housingOrder)->value}} TL</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
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
                                @foreach($housingImages as $key => $housingImage)
                                    <div class="@if($key == 0) active @endif item carousel-item" data-slide-number="0">
                                        <img src="{{URL::to('/').'/project_housing_images/'.$housingImage}}" class="img-fluid" alt="slider-listing">
                                    </div>
                                @endforeach


                                <a class="carousel-control left" href="#listingDetailsSlider"
                                    data-slide="prev"><i class="fa fa-angle-left"></i></a>
                                <a class="carousel-control right" href="#listingDetailsSlider"
                                    data-slide="next"><i class="fa fa-angle-right"></i></a>

                            </div>
                            <!-- main slider carousel nav controls -->
                            <ul class="carousel-indicators smail-listing list-inline">
                                @foreach($housingImages as $key => $housingImage)

                                    <li class="list-inline-item active">
                                        <a id="carousel-selector-0" class="selected" data-slide-to="0"
                                            data-target="#listingDetailsSlider">
                                            <img src="{{URL::to('/').'/project_housing_images/'.$housingImage}}" class="img-fluid" alt="listing-small">
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                            <!-- main slider carousel items -->
                        </div>

                    </div>
                </div>


            </div>
            <aside class="col-lg-4 col-md-12 car">
                <div class="single widget">
                    <!-- Start: Schedule a Tour -->
                    <div class="schedule widget-boxed mt-33 mt-0" style="text-align: center;">
                        <div class="widget-boxed-header">
                            <h4><i class="fa fa-calendar pr-3 padd-r-10"></i>İletişim Bilgileri</h4>
                        </div>
                        <div class="widget-boxed-body">
                            <h5 class="" style="font-size: 20px; font-weight: 600;">{{$project->brand->title}}</h5>
                            <p>0507 585 40 33</p>
                        </div>
                    </div>
                    <!-- End: Schedule a Tour -->
                    <!-- end author-verified-badge -->
                    <div class="sidebar">
                        <div class="widget-boxed mt-33 mt-5">
                            <div class="divider-fade"></div>
                            <div id="map" class="contactmap" style="height: 300px">
                            </div>

                        </div>

                    </div>
                </div>
            </aside>
        </div>

        <section class="similar-property featured portfolio p-0 bg-white">
            <div class="blog-info details mb-30">
                <h5 class="mb-4">Açıklama</h5>
                <p class="mb-3">{!! $project->description !!}</p>
            </div>
            <div class="single homes-content details mb-30">
                <!-- title -->
                <h5 class="mb-4">Bina Özellikleri</h5>
                <ul class="homes-list clearfix">
                    <li style="border: none !important;" >
                        <span class="font-weight-bold mr-1">İlan No:</span>
                        <span class="det">1029405223</span>
                    </li>
                    <li style="border: none !important;" >
                        <span class="font-weight-bold mr-1">İlan Tarihi:</span>
                        <span class="det">22 Temmuz 2023</span>
                    </li>
                    @foreach($project->roomInfo as $room)
                        <li style="border: none !important;" >
                            <span class="font-weight-bold mr-1">{{$room->key}}:</span>
                            <span class="det">{{$room->value}}</span>
                        </li>
                    @endforeach

                </ul>

                <!-- <h5 class="mt-5">Amenities</h5>

                    <ul class="homes-list clearfix">
                        <li>
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                            <span>Air Cond</span>
                        </li>
                        <li>
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                            <span>Balcony</span>
                        </li>
                        <li>
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                            <span>Internet</span>
                        </li>
                        <li>
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                            <span>Dishwasher</span>
                        </li>
                        <li>
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                            <span>Bedding</span>
                        </li>
                        <li>
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                            <span>Cable TV</span>
                        </li>
                        <li>
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                            <span>Parking</span>
                        </li>
                        <li>
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                            <span>Pool</span>
                        </li>
                        <li>
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                            <span>Fridge</span>
                        </li>
                    </ul> -->
            </div>

        </section>

    </div>
</section>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    @php
        $location = explode(',',$project->location);
        $location['latitude'] = $location[0];
        $location['longitude'] = $location[1];

        $location = json_encode($location);
        $location = json_decode($location);
    @endphp
    var map = L.map('map').setView([{{ $location->latitude }},{{ $location->longitude }}], 13);
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
            if(element.tags.highway == "bus_stop" || element.tags.type == "public_transport"){
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
            dots: true,
            arrows: true,
            adaptiveHeight: true,
            responsive: [
                {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    dots: true,
                    arrows: false
                }
                },
                {
                breakpoint: 993,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    dots: true,
                    arrows: false
                }
                },
                {
                breakpoint: 769,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
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
@endsection
