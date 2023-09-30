@extends('client.layouts.master')


@php

    function getData($housing, $key)
    {
        $housing_type_data = json_decode($housing->housing_type_data);
        $a = $housing_type_data->$key;
        return $a[0];
    }

    function getImages($housing, $key)
    {
        $housing_type_data = json_decode($housing->housing_type_data);
        $a = $housing_type_data->$key;
        return $a;
    }
@endphp

@section('content')
    <style>
        .rating-area .rating.selected polygon
        {
            fill: gold;
        }
    </style>
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
                                            <h4>{{ getData($housing, 'price') }} TL</h4>
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
                <div class="col-md-7 blog-pots">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- main slider carousel items -->
                            <div id="listingDetailsSlider" class="carousel listing-details-sliders slide mb-30">
                                <!-- <h5 class="mb-4">Gallery</h5> -->
                                <div class="carousel-inner">
                                    @foreach (json_decode(getImages($housing, 'images')) as $key => $image)
                                        <div class="item carousel-item {{ $key == 0 ? 'active' : '' }}"
                                            data-slide-number="{{ $key }}">
                                            <img src="{{ asset('housing_images/' . $image) }}" class="img-fluid"
                                                alt="slider-listing">
                                        </div>
                                    @endforeach


                                    <a class="carousel-control left" href="#listingDetailsSlider" data-slide="prev"><i
                                            class="fa fa-angle-left"></i></a>
                                    <a class="carousel-control right" href="#listingDetailsSlider" data-slide="next"><i
                                            class="fa fa-angle-right"></i></a>

                                </div>
                                <!-- main slider carousel nav controls -->
                                <ul class="carousel-indicators smail-listing list-inline">

                                    @foreach (json_decode(getImages($housing, 'images')) as $imageKey => $image)
                                        <li class="list-inline-item {{ $imageKey == 0 ? 'active' : '' }}">
                                            <a id="carousel-selector-{{ $imageKey }}" class="selected"
                                                data-slide-to="{{ $imageKey }}" data-target="#listingDetailsSlider">
                                                <img src="{{ asset('housing_images/' . $image) }}" class="img-fluid"
                                                    alt="listing-small">
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
                                <!-- main slider carousel items -->
                            </div>

                        </div>
                    </div>


                </div>
                <aside class="col-md-5  car">
                    <div class="single widget">
                        <!-- Start: Schedule a Tour -->
                        <div class="schedule widget-boxed mt-33 mt-0" style="text-align: center;">
                            <div class="widget-boxed-header">
                                <h4><i class="fa fa-calendar pr-3 padd-r-10"></i>İletişim Bilgileri</h4>
                            </div>
                            <div class="widget-boxed-body">
                                <h5 class="" style="font-size: 20px; font-weight: 600;">{{ $housing->brand?->title }}
                                </h5>
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
                        @foreach (json_decode($housing->housing_type_data) as $key => $val)
                            <li style="border: none !important;">
                                <span class="font-weight-bold mr-1">{{ $key }}:</span>
                                <span class="det">{{ json_encode($val[0]) }}</span>
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
                <div class="single homes-content details mb-30">
                    <h5 class="mb-4">Yorumlar</h5>
                    <div class="flex flex-col gap-6">
                        <div class="bg-white border rounded-md p-6">
                            <div class="head d-flex w-full">
                                <div>
                                    <div class="font-weight-bold">KULLANICI ADI</div>
                                    <i class="small">20 EKİ</i>
                                </div>
                                <div class="ml-auto order-2">
                                    <svg enable-background="new 0 0 50 50" height="24px" id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><rect fill="none" height="50" width="50"/><polygon fill="none" points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 " stroke="#000000" stroke-miterlimit="10" stroke-width="2"/></svg>
                                    <svg enable-background="new 0 0 50 50" height="24px" id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><rect fill="none" height="50" width="50"/><polygon fill="none" points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 " stroke="#000000" stroke-miterlimit="10" stroke-width="2"/></svg>
                                    <svg enable-background="new 0 0 50 50" height="24px" id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><rect fill="none" height="50" width="50"/><polygon fill="none" points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 " stroke="#000000" stroke-miterlimit="10" stroke-width="2"/></svg>
                                    <svg enable-background="new 0 0 50 50" height="24px" id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><rect fill="none" height="50" width="50"/><polygon fill="none" points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 " stroke="#000000" stroke-miterlimit="10" stroke-width="2"/></svg>
                                    <svg enable-background="new 0 0 50 50" height="24px" id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><rect fill="none" height="50" width="50"/><polygon fill="none" points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 " stroke="#000000" stroke-miterlimit="10" stroke-width="2"/></svg>
                                </div>
                            </div>
                            <div class="body py-3">
                                Lorem ipsum dolor sit amet, consectet ut labore et dolore magna aliqu fugiat nulla pariatur et accus ut labore et dolore magna aliqu fug et accus ut labore et dolore magna aliqu fugiat nulla par iatur et accus ut labore et dolore magna aliqu fugiat null a ante. Lorem ipsum dolor sit amet, consect et netis et dolore magna aliqu fugiat nulla par.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single homes-content details mb-30">
                    <form action="{{ route('housing.send-comment', ['id' => $id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="rate" id="rate"/>
                        <h5 class="mb-4">Yeni Yorum Ekle</h5>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                        </div>
                        @endif
                        <div class="d-flex align-items-center w-full" style="gap: 6px;">
                            <div class="d-flex rating-area">
                                <svg class="rating" enable-background="new 0 0 50 50" height="24px" id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><rect fill="none" height="50" width="50"/><polygon fill="none" points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 " stroke="#000000" stroke-miterlimit="10" stroke-width="2"/></svg>
                                <svg class="rating" enable-background="new 0 0 50 50" height="24px" id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><rect fill="none" height="50" width="50"/><polygon fill="none" points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 " stroke="#000000" stroke-miterlimit="10" stroke-width="2"/></svg>
                                <svg class="rating" enable-background="new 0 0 50 50" height="24px" id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><rect fill="none" height="50" width="50"/><polygon fill="none" points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 " stroke="#000000" stroke-miterlimit="10" stroke-width="2"/></svg>
                                <svg class="rating" enable-background="new 0 0 50 50" height="24px" id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><rect fill="none" height="50" width="50"/><polygon fill="none" points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 " stroke="#000000" stroke-miterlimit="10" stroke-width="2"/></svg>
                                <svg class="rating" enable-background="new 0 0 50 50" height="24px" id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><rect fill="none" height="50" width="50"/><polygon fill="none" points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 " stroke="#000000" stroke-miterlimit="10" stroke-width="2"/></svg>
                            </div>
                            <div class="ml-auto">
                                <input type="file" style="visibility: hidden;" id="fileinput" name="files[]" multiple accept="image/*"/>
                                <button type="button" class="btn btn-primary btn-lg" onClick="jQuery('#fileinput').trigger('click');">Resimleri Seç</button>
                            </div>
                        </div>
                        <textarea name="comment" rows="10" class="form-control mt-4" placeholder="Yorum girin..."></textarea>
                        <button type="submit" class="btn btn-primary btn-block btn-lg mt-4">YORUMU GÖNDER</button>
                    </form>
                </div>
            </section>

        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([{{ $housing->latitude }}, {{ $housing->longitude }}], 13);

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
    <script>
        jQuery('.rating-area .rating').on('mouseover', function()
        {
            jQuery('.rating-area .rating polygon').attr('fill', 'none');
            for (var i = 0; i <= $(this).index(); ++i)
                jQuery('.rating-area .rating polygon').eq(i).attr('fill', 'gold');
        });

        jQuery('.rating-area .rating').on('mouseleave', function()
        {
            jQuery('.rating-area .rating:not(.selected) polygon').attr('fill', 'none');
        });

        jQuery('.rating-area .rating').on('click', function()
        {
            jQuery('.rating-area .rating').removeClass('selected');
            for (var i = 0; i <= $(this).index(); ++i)
                jQuery('.rating-area .rating').eq(i).addClass('selected');

            $('#rate').val($(this).index()+1);
        });
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endsection
