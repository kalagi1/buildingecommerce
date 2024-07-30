@extends('client.layouts.master')

@section('content')
    <!-- STAR HEADER GOOGLE MAP -->
    <div id="map-container" class="fullwidth-home-map header-map google-maps pull-top map-leaflet-wrapper">
        <div id="map-leaflet"></div>
    </div>
    <!-- END HEADER GOOGLE MAP -->
@endsection

@section('scripts')
    <script src="{{ asset('js/leaflet.js') }}"></script>
    <script src="{{ asset('js/leaflet-gesture-handling.min.js') }}"></script>
    <script src="{{ asset('js/leaflet-providers.js') }}"></script>
    <script src="{{ asset('js/leaflet.markercluster.js') }}"></script>

    <script>
        $(document).ready(function() {
            'use strict';

            // Access filter data passed from the controller
            var filters = @json($filters);
            var city = @json($city);

            // Initialize map with filter data
            initMap(filters, city);
        });

        function initMap(filters) {
            // Default center coordinates if city data is not available
            var centerCoordinates = [38.9334, 32.8597];

            // If city data is available, use its coordinates
            if (city && city.lat && city.lang) {
                centerCoordinates = [city.lat, city.lang];
            }

            var map = L.map('map-leaflet', {
                zoom: 6,
                maxZoom: 20,
                tap: false,
                gestureHandling: true,
                center: centerCoordinates
            });
            var marker_cluster = L.markerClusterGroup();

            map.scrollWheelZoom.disable();

            var OpenStreetMap_Mapnik = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                scrollWheelZoom: false,
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            fetchMarkers(filters); // Fetch markers with filter data

            function fetchMarkers(filters) {
                $.ajax({
                    url: '/api/markers', // Your API endpoint
                    method: 'GET',
                    data: filters, // Send all filters as query parameters
                    success: function(response) {
                        marker_cluster.clearLayers();

                        var markers = response.data; // Adjust based on your API response structure

                        $.each(markers, function(index, value) {
                            var icon = L.divIcon({
                                html: value.icon,
                                iconSize: [50, 50],
                                iconAnchor: [50, 50],
                                popupAnchor: [-20, -42]
                            });

                            var marker = L.marker(value.center, {
                                icon: icon
                            }).addTo(map);

                            marker.bindPopup(
                                '<div class="listing-window-image-wrapper">' +
                                '<a href="' + value.link + '">' +
                                '<div class="listing-window-image" style="background-image: url(' +
                                value.image + ');"></div>' +
                                '<div class="listing-window-content">' +
                                '<div class="info">' +
                                '<h2>' + value.title + '</h2>' +
                                '<p>' + value.desc + '</p>' +
                                '<h3>' + value.price + '</h3>' +
                                '</div>' +
                                '</div>' +
                                '</a>' +
                                '</div>'
                            );

                            marker_cluster.addLayer(marker);
                        });

                        map.addLayer(marker_cluster);
                    },
                    error: function(xhr, status, error) {
                        console.error('API çağrısı sırasında bir hata oluştu:', error);
                    }
                });
            }
        }
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/maps.css') }}">
    <!-- LEAFLET MAP -->
    <link rel="stylesheet" href="{{ asset('css/leaflet.css') }}">
    <link rel="stylesheet" href="{{ asset('css/leaflet-gesture-handling.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/leaflet.markercluster.css') }}">
    <link rel="stylesheet" href="{{ asset('css/leaflet.markercluster.default.css') }}">
@endsection
