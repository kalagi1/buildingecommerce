@extends('client.layouts.master')

@section('content')
    @php
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

    <x-store-card :store="$institutional" />


    <section class="portfolio bg-white homepage-5 ">
        <div class="container">
            <div class="seller-profile">
                <div class="seller-info-container">

                    <div class="seller-info-container__wrapper">
                        <div class="seller-info-container__wrapper__text-container w-100 text-center"><span
                                class="seller-info-container__wrapper__text-container__title"> Katılma Tarihi</span><span
                                class="seller-info-container__wrapper__text-container__value">
                                {{ $institutional->created_at->setTimezone('Europe/Istanbul')->format('d.m.Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="seller-info-container__wrapper">

                        <div class="seller-info-container__wrapper__text-container w-100 text-center"><span
                                class="seller-info-container__wrapper__text-container__title"> İletişim </span><span
                                class="seller-info-container__wrapper__text-container__value">
                                <span> Telefon:
                                    {{ $institutional->phone ? $institutional->phone : 'Belirtilmedi.' }} <br>
                                    Email: {{ $institutional->email ? $institutional->email : 'Belirtilmedi' }}</span>

                            </span>
                        </div>
                    </div>
                    <div class="seller-info-container__wrapper">
                        <div class="seller-info-container__wrapper__text-container w-100 text-center"><span
                                class="seller-info-container__wrapper__text-container__title"> <button
                                    onclick="getDirections()" class="btn btn-primary w-100 text-center"
                                    style="    height: 30px !important;
                                    width: 50% !important;
                                    margin: 3px auto;">
                                    Yol Tarifi Al
                                </button></span><span class="seller-info-container__wrapper__text-container__value">
                                {{ $institutional->town->sehir_title }} <i class="fa fa-angle-right"></i>
                                {{ $institutional->district->ilce_title }} <i class="fa fa-angle-right"></i>
                                {{ $institutional->neighborhood->mahalle_title }} </span>
                        </div>


                    </div>
                    <div class="seller-info-container__wrapper">
                        <a href="{{ $institutional->website }}" class="w-100 text-center" target="_blank">
                            <div class="seller-info-container__wrapper__text-container w-100 text-center"><span
                                    class="seller-info-container__wrapper__text-container__title"> <i
                                        class="fa fa-globe"></i></span><span
                                    class="seller-info-container__wrapper__text-container__value">
                                    Websiteye Git</span></div>
                        </a>

                    </div>
                </div>

                @if (isset($institutional->latitude))
                    <div id="mapContainer" style="height: 350px;width:100%;margin-bottom:20px"></div>
                @endif

            </div>

        </div>
    </section>
@endsection

@section('scripts')
    <!-- lightbox2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- lightbox2 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
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

    <!-- Google Maps API script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&callback=initMap" async
        defer></script>

    <script>
        var map;
        var marker;

        function initMap(cityName, zoomLevel) {
            var userLatitude = parseFloat("{{ $institutional->latitude }}");
            var userLongitude = parseFloat("{{ $institutional->longitude }}");

            map = new google.maps.Map(document.getElementById('mapContainer'), {
                zoom: 10,
                center: {
                    lat: userLatitude,
                    lng: userLongitude
                }
            });

            if (cityName) {
                // Google Haritalar Geocoding API'yi kullanarak şehir adını koordinatlara dönüştür
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    address: cityName
                }, function(results, status) {
                    if (status === 'OK') {
                        // Başarılı ise haritayı zoomla
                        map.setCenter(results[0].geometry.location);
                        map.setZoom(zoomLevel); // İstediğiniz zoom seviyesini ayarlayabilirsiniz
                    } else {
                        alert('Şehir bulunamadı: ' + status);
                    }
                });
            }





            if (userLatitude && userLongitude) {
                var userLocation = new google.maps.LatLng(userLatitude, userLongitude);
                placeMarker(userLocation);
            }
        }

        window.initMap = initMap;

        function placeMarker(location) {
            clearMarker(); // Önceki işaretçiyi temizle

            // İşaretçiyi oluşturun
            marker = new google.maps.Marker({
                position: location,
                map: map
            });

            // İşaretçiye tıklandığında bilgi penceresini gösterin
            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });

            // İşaretçiyi dizide saklayın
            markers.push(marker);
        }

        function clearMarker() {
            if (marker) {
                marker.setMap(null);
                marker = null;
            }
        }

        function getDirections() {
            var userLatitude = parseFloat("{{ $institutional->latitude }}");
            var userLongitude = parseFloat("{{ $institutional->longitude }}");
            var url = "https://www.google.com/maps/dir/?api=1&destination=" + userLatitude + "," + userLongitude;
            window.open(url, '_blank');
        }
    </script>
@endsection

@section('styles')
    <style>
        .product-review-container__redirect__span-wrapper {
            width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .product-review-container__redirect__span-wrapper p {
            font-family: source_sans_proregular, sans-serif;
            font-style: normal;
            font-size: 11px;
            overflow: hidden;
            text-overflow: ellipsis;
            margin: 0;
            line-height: inherit !important;
        }

        .product-review-container__redirect {
            display: flex;
            flex-direction: row;
            margin-top: 15px;
            cursor: pointer;
            text-decoration: none;
        }

        .product-review-container__redirect img {
            width: 50px;
            height: 44.95px;
            border: 1px solid #e6e6e6;
            box-sizing: border-box;
            border-radius: 4px;
            margin-right: 10px;
        }

        .slick-prev {
            left: 0 !important;
        }

        .slick-next {
            right: 0 !important;
        }

        .product-review-section-wrapper__wrapper__product-rating-filters {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            margin-left: 20px;
            margin-top: 10px;
            align-items: center margin-right: 20px;
        }

        @media (max-width:768px) {
            .product-rating-count-container {
                width: 45% !important;
                margin-top: 20px !important;
            }
        }

        .product-rating-count-container {
            width: 150px;
            height: 38px;
            background: #fff;
            border: 2px solid #e6e6e6;
            box-sizing: border-box;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .0511637);
            border-radius: 6px;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
        }

        .product-rating-count-container__count {
            margin-left: 7px;
            margin-top: 3px
        }

        .product-review-section-wrapper__wrapper__filter_title {
            font-family: source_sans_proregular, sans-serif;
            font-style: normal;
            font-weight: 600;
            font-size: 11px;
            line-height: 15px;
            color: #999;
            margin-left: 20px;
            margin-bottom: 10px;
        }

        .seller-info-container__wrapper__text-container__title i {
            font-size: 25px;
        }
    </style>
@endsection
