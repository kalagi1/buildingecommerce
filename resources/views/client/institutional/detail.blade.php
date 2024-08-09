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
    <div class="row justify-content-center mt-5 mb-5">
        <div class="col-md-7">
            <div class="d-flex justify-content-center align-items-center">
                <img src="https://craftohtml.themezaa.com/images/demo-decor-store-about-01.png" class="img-fluid mr-2"
                    style="width: 10%" alt="Profile Image">
                <div>
                    <span class="fs-13 ls-2px fw-600 mb-2 d-block" style="font-size: 10px !important">Hesap Açma Tarihi: {{$institutional->created_at->format('d.m.Y') }} </span>
                    <h3 class="text-dark-gray alt-font fw-700 mb-0" style="font-size: 20px;">
                        {{ $institutional->name }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <div
                class="row align-items-center justify-content-center border border-color-extra-medium-gray border-radius-100px sm-border-radius-6px sm-mx-0">
                <div
                    class="col-md-6 p-20px border-end border-color-transparent-dark-very-light text-center ls-minus-05px align-items-center d-flex justify-content-center sm-border-end-0 sm-pb-0 sm-mb-10px">
                    <span class="text-dark-gray fs-18 text-start fw-500 xs-lh-28">
                        @if (isset($institutional->phone_verification_status) && $institutional->phone_verification_status == 1)
                            <span class="text-success d-flex align-items-center">
                                <i class="fa fa-check-circle me-2 mr-2"></i> Cep Telefonu Onaylı
                            </span>
                        @else
                            <span class="text-danger d-flex align-items-center">
                                <i class="fa fa-times-circle me-2 mr-2"></i> Cep Telefonu Onaylı Değil
                            </span>
                        @endif
                    </span>
                </div>
                <div
                    class="col-md-6 p-20px sm-pt-0 border-send text-center ls-minus-05px align-items-center d-flex justify-content-center">
                    <span class="text-dark-gray fs-18 text-start fw-500">
                        @if (isset($institutional->status) && $institutional->status == '1')
                            <span class="text-success d-flex align-items-center">
                                <i class="fa fa-check-circle me-2 mr-2"></i> E-Posta Onaylı
                            </span>
                        @else
                            <span class="text-danger d-flex align-items-center">
                                <i class="fa fa-times-circle me-2 mr-2"></i> E-Posta Onaylı Değil
                            </span>
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>



    <section class="pt-4 mb-5">
        <div class="container">
            <div
                class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 justify-content-center text-center text-sm-start">
                <!-- Location Information -->
                @if ($institutional->town || $institutional->district || $institutional->neighborhood)
                    <div class="col mb-4">
                        <span class="d-block fs-18 fw-600 text-dark-gray border-bottom border-2 border-dark-gray pb-2 mb-3">
                            <i class="fa fa-map-pin me-2 me-10px"></i>Konum
                        </span>
                        <p>
                            @if ($institutional->town)
                                {{ $institutional->town->sehir_title }}
                            @endif
                            @if ($institutional->district)
                                <i class="fa fa-angle-right mx-2"></i>
                                {{ $institutional->district->ilce_title }}
                            @endif
                            @if ($institutional->neighborhood)
                                <i class="fa fa-angle-right mx-2"></i>
                                {{ $institutional->neighborhood->mahalle_title }}
                            @endif
                        </p>
                    </div>
                @endif

                <!-- Email Information -->
                @if ($institutional->email)
                    <div class="col mb-4">
                        <span class="d-block fs-18 fw-600 text-dark-gray border-bottom border-2 border-dark-gray pb-2 mb-3">
                            <i class="fa fa-envelope me-2 me-10px"></i>E-Posta
                        </span>
                        <a href="mailto:{{ $institutional->email }}">{{ $institutional->email }}</a>
                    </div>
                @endif

                <!-- Phone Information -->
                @if ($institutional->phone || $institutional->mobile_phone)
                    <div class="col mb-4">
                        <span class="d-block fs-18 fw-600 text-dark-gray border-bottom border-2 border-dark-gray pb-2 mb-3">
                            <i class="fa fa-phone me-2 me-10px"></i>Hemen Ara
                        </span>
                        @if ($institutional->phone)
                            <a href="tel:{{ $institutional->phone }}">{{ $institutional->phone }}</a>
                        @elseif ($institutional->mobile_phone)
                            <a href="tel:{{ $institutional->mobile_phone }}">{{ $institutional->mobile_phone }}</a>
                        @endif
                    </div>
                @endif

                <!-- Directions Button -->
                {{-- @if ($institutional && $institutional->type != '1')
                    <div class="col mb-4">
                        <span class="d-block fs-18 fw-600 text-dark-gray border-bottom border-2 border-dark-gray pb-2 mb-3">
                            <i class="fa fa-users me-2 me-10px"></i>Yol Tarifi Al
                        </span>
                        @if (isset($institutional->latitude))
                            <button onclick="getDirections()" class="btn btn-primary w-100">
                                Yol Tarifi Al
                            </button>
                        @else
                            <p>Konum Bilgisi Yok</p>
                        @endif
                    </div>
                @endif --}}

                <!-- Website Information -->
                @if ($institutional && $institutional->website && $institutional->type != '1')
                    <div class="col mb-4">
                        <span class="d-block fs-18 fw-600 text-dark-gray border-bottom border-2 border-dark-gray pb-2 mb-3">
                            <i class="fa fa-link me-2 me-10px"></i>Web Siteye Git
                        </span>
                        @if ($institutional->website)
                            <a href="{{ $institutional->website }}" target="_blank">Websiteye Git</a>
                        @else
                            <p>Belirtilmedi.</p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Map Container -->
            @if (isset($institutional->latitude))
                <div id="mapContainer" class="mt-5" style="height: 350px; width: 100%; margin-bottom: 20px;"></div>
            @endif
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
