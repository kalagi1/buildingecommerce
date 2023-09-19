@extends('client.layouts.master')


@php 

    function getData($housing,$key){
        $housing_type_data= json_decode($housing->housing_type_data);
        $a = $housing_type_data->$key;
        return $a[0];
    }

    function getImages($housing,$key){
        $housing_type_data= json_decode($housing->housing_type_data);
        $a = $housing_type_data->$key;
        return $a;
    }
@endphp

@section('content')
    <section class="single-proper blog details bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="container">
                        <section class="headings-2 pt-0">
                            <div class="pro-wrapper" style="width: 100%; justify-content: space-between;">
                                <div class="detail-wrapper-body">
                                    <div class="listing-title-bar">
                                        <h3>{{ $housing->title }} </h3>
                                        <div class="mt-0">
                                            <a href="#listing-location" class="listing-address">
                                                <i
                                                    class="fa fa-map-marker pr-2 ti-location-pin mrg-r-5">{{ $housing->title }}</i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="single detail-wrapper mr-2">
                                    <div class="detail-wrapper-body">
                                        <div class="listing-title-bar">
                                            <h4>{{getData($housing,'price')}} TL</h4>
                                            <!-- <div class="mt-0">
                                                                        <a href="#listing-location" class="listing-address">
                                                                            <p>$ 1,200 / sq ft</p>
                                                                        </a>
                                                                    </div> -->
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
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach (json_decode(getImages($housing,'images')) as $image)
                                        <div class="item carousel-item {{ $i == 0 ? 'active' : '' }}"
                                            data-slide-number="{{ $i }}">
                                            <img src="{{ asset('housing_images/' . $image) }}" class="img-fluid"
                                                alt="slider-listing">
                                            @php
                                                $i++;
                                            @endphp
                                        </div>
                                    @endforeach


                                    <a class="carousel-control left" href="#listingDetailsSlider" data-slide="prev"><i
                                            class="fa fa-angle-left"></i></a>
                                    <a class="carousel-control right" href="#listingDetailsSlider" data-slide="next"><i
                                            class="fa fa-angle-right"></i></a>

                                </div>
                                <!-- main slider carousel nav controls -->
                                <ul class="carousel-indicators smail-listing list-inline">
                                    @php
                                        $j = 0;
                                    @endphp
                                    @foreach ($housing->images as $image)
                                        <li class="list-inline-item {{ $i == 0 ? 'active' : '' }}">
                                            <a id="carousel-selector-0" class="selected" data-slide-to="0"
                                                data-target="#listingDetailsSlider">
                                                <img src="{{ asset('storage/' . $image->imagepath) }}" class="img-fluid"
                                                    alt="listing-small">
                                            </a>
                                        </li>
                                        @php
                                            $j++;
                                        @endphp
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
                                <h5 class="" style="font-size: 20px; font-weight: 600;">{{$housing->brand->title}}</h5>
                                <p>0507 585 40 33</p>
                            </div>
                        </div>
                        <!-- End: Schedule a Tour -->
                        <!-- end author-verified-badge -->
                        <div class="sidebar">
                            <div class="widget-boxed mt-33 mt-5">
                                <div class="divider-fade"></div>
                                <div id="map" class="contactmap">
                                    <iframe
                                        src="https://maps.google.com/maps?q={{ $housing->latitude }},{{ $housing->longitude }}&hl=trh&z=14&amp;output=embed"
                                        width="100%" height="300px" style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>

                            </div>

                        </div>
                    </div>
                </aside>
            </div>

            <section class="similar-property featured portfolio p-0 bg-white">
                <div class="blog-info details mb-30">
                    <h5 class="mb-4">Açıklama</h5>
                    <p class="mb-3">{{ $housing->description }}</p>
                </div>
                <div class="single homes-content details mb-30">
                    <!-- title -->
                    <h5 class="mb-4">Bina Özellikleri</h5>
                    <ul class="homes-list clearfix">
                        @foreach (json_decode($housing->housing_type_data) as $key=>$val)
                          <li style="border: none !important;">
                            <span class="font-weight-bold mr-1">{{$key}}:</span>
                            <span class="det">{{json_encode($val[0])}}</span>
                        </li>
                        @endforeach

                    </ul>

                   
                </div>

            </section>

        </div>
    </section>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([{{ $housing->latitude }},{{ $housing->longitude }}], 13);

    // OpenStreetMap katmanını haritaya ekleyin
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Yakınındaki alışveriş yerlerini Overpass API kullanarak getirin
    var overpassUrl = 'https://overpass-api.de/api/interpreter';
    var query = `[out:json];
    (
        node["amenity"="clinic"](around:12000,{{ $housing->latitude }},{{ $housing->longitude }});
        way["amenity"="clinic"](around:12000,{{ $housing->latitude }},{{ $housing->longitude }});
        relation["amenity"="clinic"](around:12000,{{ $housing->latitude }},{{ $housing->longitude }});
    );
    out center;`;
    var url = `${overpassUrl}?data=${encodeURIComponent(query)}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            // Alışveriş yerlerini işaretle
            console.log(data.elements);
            data.elements.forEach(element => {
                var lat = element.lat;
                var lon = element.lon;
                var marker = L.marker([lat, lon]).addTo(map);
                marker.bindPopup(element.tags.name || 'Bilinmeyen Mağaza');
            });
        })
        .catch(error => console.error('Hata:', error));
</script>
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endsection