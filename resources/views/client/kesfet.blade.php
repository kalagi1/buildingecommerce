@extends('client.layouts.master')

@section('content')

        <!-- STAR HEADER GOOGLE MAP -->
        <div id="map-container" class="fullwidth-home-map header-map google-maps pull-top map-leaflet-wrapper">
            <div id="map-leaflet"></div>
        
        </div>
        <!-- END HEADER GOOGLE MAP -->

@endsection

@section('scripts')
<script src="{{asset('js/map-style2.js')}}"></script>
<script src="{{ asset('js/leaflet.js') }}"></script>
<script src="{{ asset('js/leaflet-gesture-handling.min.js') }}"></script>
<script src="{{ asset('js/leaflet-providers.js') }}"></script>
<script src="{{ asset('js/leaflet.markercluster.js') }}"></script>

@endsection

@section('styles')
<link rel="stylesheet" href="{{asset('css/maps.css')}}">
   <!-- LEAFLET MAP -->
   <link rel="stylesheet" href="{{asset('css/leaflet.css')}}">
   <link rel="stylesheet" href="{{asset('css/leaflet-gesture-handling.min.css')}}">
   <link rel="stylesheet" href="{{asset('css/leaflet.markercluster.css')}}">
   <link rel="stylesheet" href="{{asset('css/leaflet.markercluster.default.css')}}">

@endsection
