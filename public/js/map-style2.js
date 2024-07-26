$(document).ready(function () {
    'use strict';

    if ($('#map-leaflet').length) {
        var map = L.map('map-leaflet', {
            zoom: 6,
            maxZoom: 20,
            tap: false,
            gestureHandling: true,
            center: [38.9334, 32.8597] 
        });

        var marker_cluster = L.markerClusterGroup();

        map.scrollWheelZoom.disable();

        var OpenStreetMap_Mapnik = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            scrollWheelZoom: false,
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var markers = [
            {	
                "id": "marker-1",
                "center": [40.929399, -74.430091],
                "icon": "<i class='fa fa-home'></i>",
                "title": "Real House Luxury Villa",
                "desc": "Est St, 77 - Central Park South, NYC",
                "price": "$ 230,000",
                "image": "images/feature-properties/fp-1.jpg"
            },
            {
                "id": "marker-2",
                "center": [40.896321, -74.467377],
                "icon": "<i class='fa fa-home'></i>",
                "title": "Real House Luxury Villa",
                "desc": "Est St, 77 - Central Park South, NYC",
                "price": "$ 230,000",		
                "image": "images/feature-properties/fp-2.jpg"	
            },
            {
                "id": "marker-3",
                "center": [40.895654, -74.333256],
                "icon": "<i class='fa fa-home'></i>",
                "title": "Real House Luxury Villa",
                "desc": "Est St, 77 - Central Park South, NYC",
                "price": "$ 230,000",		
                "image": "images/feature-properties/fp-3.jpg"
            },
            {
                "id": "marker-4",
                "center": [40.882099, -74.379868],
                "icon": "<i class='fa fa-home'></i>",
                "title": "Real House Luxury Villa",
                "desc": "Est St, 77 - Central Park South, NYC",
                "price": "$ 230,000",		
                "image": "images/feature-properties/fp-4.jpg"
            },
            {
                "id": "marker-5",
                "center": [40.976543, -74.025419],
                "icon": "<i class='fa fa-home'></i>",
                "title": "Real House Luxury Villa",
                "desc": "Est St, 77 - Central Park South, NYC",
                "price": "$ 230,000",		
                "image": "images/feature-properties/fp-5.jpg"
            },
            {
                "id": "marker-6",
                "center": [40.953510, -74.227921],
                "icon": "<i class='fa fa-home'></i>",
                "title": "Real House Luxury Villa",
                "desc": "Est St, 77 - Central Park South, NYC",
                "price": "$ 230,000",		
                "image": "images/feature-properties/fp-6.jpg"
            },
            {
                "id": "marker-7",
                "center": [40.932510, -74.029862],
                "icon": "<i class='fa fa-home'></i>",
                "title": "Real House Luxury Villa",
                "desc": "Est St, 77 - Central Park South, NYC",
                "price": "$ 230,000",		
                "image": "images/feature-properties/fp-7.jpg"
            },
            {
                "id": "marker-8",
                "center": [40.963966, -74.287921],
                "icon": "<i class='fa fa-home'></i>",
                "title": "Real House Luxury Villa",
                "desc": "Est St, 77 - Central Park South, NYC",
                "price": "$ 230,000",		
                "image": "images/feature-properties/fp-8.jpg"
            },
            {
                "id": "marker-9",
                "center": [40.918876, -74.373921],
                "icon": "<i class='fa fa-home'></i>",
                "title": "Real House Luxury Villa",
                "desc": "Est St, 77 - Central Park South, NYC",
                "price": "$ 230,000",		
                "image": "images/feature-properties/fp-9.jpg"
            },
            {
                "id": "marker-10",
                "center": [40.929000, -74.292921],
                "icon": "<i class='fa fa-building'></i>",
                "title": "Real House Luxury Villa",
                "desc": "Est St, 77 - Central Park South, NYC",
                "price": "$ 230,000",		
                "image": "images/feature-properties/fp-1.jpg"
            },
            {
                "id": "marker-11",
                "center": [40.846000, -74.292921],
                "icon": "<i class='fa fa-home'></i>",
                "title": "Real House Luxury Villa",
                "desc": "Est St, 77 - Central Park South, NYC",
                "price": "$ 230,000",		
                "image": "images/feature-properties/fp-2.jpg"
            },
            {
                "id": "marker-12",
                "center": [40.898000, -74.258121],
                "icon": "<i class='fa fa-home'></i>",
                "title": "Real House Luxury Villa",
                "desc": "Est St, 77 - Central Park South, NYC",
                "price": "$ 230,000",		
                "image": "images/feature-properties/fp-3.jpg"
            },
            {
                "id": "marker-13",
                "center": [40.947000, -74.358921],
                "icon": "<i class='fa fa-home'></i>",
                "title": "Real House Luxury Villa",
                "desc": "Est St, 77 - Central Park South, NYC",
                "price": "$ 230,000",		
                "image": "images/feature-properties/fp-4.jpg"
            },
            {
                "id": "marker-14",
                "center": [40.957000, -74.458921],
                "icon": "<i class='fa fa-building'></i>",
                "title": "Real House Luxury Villa",
                "desc": "Est St, 77 - Central Park South, NYC",
                "price": "$ 230,000",		
                "image": "images/feature-properties/fp-5.jpg"
            }	
        ];
        $.each(markers, function (index, value) {
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
                '<div class="listing-window-image" style="background-image: url(' + value.image + ');"></div>' +
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
    }

});
