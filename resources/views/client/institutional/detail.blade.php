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

    <div class="brand-head">
        <div class="container">
            <div class="card mb-3">
                <div class="card-img-top" style="background-color: {{ $institutional->banner_hex_code }}">
                    <div class="brands-square">
                        <img src="{{ url('storage/profile_images/' . $institutional->profile_image) }}" alt=""
                            class="brand-logo">
                        <p class="brand-name"><a href="{{ route('instituional.profile', Str::slug($institutional->name)) }}"
                                style="color:White">{{ $institutional->name }}</a></p>
                        <p class="brand-name"><i class="fa fa-angle-right"></i> </p>
                        <p class="brand-name">Profil</p>
                    </div>
                </div>
                <div class="card-body">
                    <nav class="navbar" style="padding: 0 !important">
                        <div class="navbar-items">
                            <a class="navbar-item"
                                href="{{ route('instituional.dashboard', Str::slug($institutional->name)) }}">Anasayfa</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.projects.detail', Str::slug($institutional->name)) }}">Tüm
                                Projeler</a>
                            <a class="navbar-item active"
                                href="{{ route('instituional.profile', Str::slug($institutional->name)) }}">Satıcı
                                Profili</a>
                        </div>
                        <form class="search-form" action="{{ route('instituional.search') }}" method="GET">
                            @csrf
                            <input class="search-input" type="search" placeholder="Mağazada Ara" aria-label="Search"
                                name="q">
                            <div class="header-search__suggestions">
                                <div class="header-search__suggestions__section">
                                    <h5>Projeler</h5>
                                    <div class="header-search__suggestions__section__items">
                                        @foreach ($institutional->projects as $item)
                                            <a href="#"><span>{{ $item->project_title }}</span></a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <button class="search-button" type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="portfolio bg-white homepage-5 ">
        <div class="container">
            <div class="seller-profile">
                <div class="seller-info-container">
                    <?php
                    $totalHousingCount = 0;
                    
                    foreach ($institutional->projects as $userProject) {
                        $totalHousingCount += count($userProject->housings);
                    }
                    ?>
                    <div class="seller-info-container__wrapper"><img
                            src="https://cdn.dsmcdn.com/seller-store/resources/activation-date-web-icon.svg" alt="icon"
                            class="seller-info-container__wrapper__img">
                        <div class="seller-info-container__wrapper__text-container"><span
                                class="seller-info-container__wrapper__text-container__title">Katılma Tarihi</span><span
                                class="seller-info-container__wrapper__text-container__value">
                                {{ $institutional->created_at->setTimezone('Europe/Istanbul')->format('d.m.Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="seller-info-container__wrapper"><img
                            src="https://cdn.dsmcdn.com/seller-store/resources/location-web-icon.svg" alt="icon"
                            class="seller-info-container__wrapper__img">
                        <div class="seller-info-container__wrapper__text-container"><span
                                class="seller-info-container__wrapper__text-container__title">Konum</span><span
                                class="seller-info-container__wrapper__text-container__value">
                                {{ $institutional->town->sehir_title }} <i class="fa fa-angle-right"></i>
                                {{ $institutional->district->ilce_title }} <i class="fa fa-angle-right"></i>
                                {{ $institutional->neighborhood->mahalle_title }} </span></div>
                    </div>
                    <div class="seller-info-container__wrapper"><img
                            src="https://cdn.dsmcdn.com/seller-store/resources/corporate-invoice-web-icon.svg"
                            alt="icon" class="seller-info-container__wrapper__img">
                        <div class="seller-info-container__wrapper__text-container"><span
                                class="seller-info-container__wrapper__text-container__title">Konut Sayısı</span><span
                                class="seller-info-container__wrapper__text-container__value">{{ $totalHousingCount }}
                            </span></div>
                    </div>
                </div>
            </div>

            <div class="single homes-content details mb-30">
                <div style="margin-top: 20.5px;"><span class="product-review-section-wrapper__wrapper__filter_title">Puana
                        Göre Filtrele</span>
                    <div class="product-review-section-wrapper__wrapper__product-rating-filters mb-5">
                        <div class="product-rating-count-container" style="border: 1px solid rgb(230, 230, 230);">
                            <div class="product-rating-count-container__star">
                                <div class="star-ratings" title="5 Stars"
                                    style="position: relative; box-sizing: border-box; display: inline-block;"><svg
                                        class="star-grad"
                                        style="position: absolute; z-index: 0; width: 0px; height: 0px; visibility: hidden;">
                                        <defs>
                                            <linearGradient id="starGrad580477135753019" x1="0%" y1="0%"
                                                x2="100%" y2="0%">
                                                <stop offset="0%" class="stop-color-first"
                                                    style="stop-color: rgb(255, 192, 0); stop-opacity: 1;"></stop>
                                                <stop offset="0%" class="stop-color-first"
                                                    style="stop-color: rgb(255, 192, 0); stop-opacity: 1;"></stop>
                                                <stop offset="0%" class="stop-color-final"
                                                    style="stop-color: rgb(203, 211, 227); stop-opacity: 1;"></stop>
                                                <stop offset="100%" class="stop-color-final"
                                                    style="stop-color: rgb(203, 211, 227); stop-opacity: 1;"></stop>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(255, 192, 0); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(255, 192, 0); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(255, 192, 0); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(255, 192, 0); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(255, 192, 0); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div><span class="product-rating-count-container__count">(58B)</span>
                        </div>
                        <div class="product-rating-count-container" style="border: 1px solid rgb(230, 230, 230);">
                            <div class="product-rating-count-container__star">
                                <div class="star-ratings" title="4 Stars"
                                    style="position: relative; box-sizing: border-box; display: inline-block;"><svg
                                        class="star-grad"
                                        style="position: absolute; z-index: 0; width: 0px; height: 0px; visibility: hidden;">
                                        <defs>
                                            <linearGradient id="starGrad168720571289001" x1="0%" y1="0%"
                                                x2="100%" y2="0%">
                                                <stop offset="0%" class="stop-color-first"
                                                    style="stop-color: rgb(255, 192, 0); stop-opacity: 1;"></stop>
                                                <stop offset="0%" class="stop-color-first"
                                                    style="stop-color: rgb(255, 192, 0); stop-opacity: 1;"></stop>
                                                <stop offset="0%" class="stop-color-final"
                                                    style="stop-color: rgb(203, 211, 227); stop-opacity: 1;"></stop>
                                                <stop offset="100%" class="stop-color-final"
                                                    style="stop-color: rgb(203, 211, 227); stop-opacity: 1;"></stop>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(255, 192, 0); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(255, 192, 0); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(255, 192, 0); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(255, 192, 0); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(203, 211, 227); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div><span class="product-rating-count-container__count">(10.7B)</span>
                        </div>
                        <div class="product-rating-count-container" style="border: 1px solid rgb(230, 230, 230);">
                            <div class="product-rating-count-container__star">
                                <div class="star-ratings" title="3 Stars"
                                    style="position: relative; box-sizing: border-box; display: inline-block;"><svg
                                        class="star-grad"
                                        style="position: absolute; z-index: 0; width: 0px; height: 0px; visibility: hidden;">
                                        <defs>
                                            <linearGradient id="starGrad536339308554862" x1="0%" y1="0%"
                                                x2="100%" y2="0%">
                                                <stop offset="0%" class="stop-color-first"
                                                    style="stop-color: rgb(255, 192, 0); stop-opacity: 1;"></stop>
                                                <stop offset="0%" class="stop-color-first"
                                                    style="stop-color: rgb(255, 192, 0); stop-opacity: 1;"></stop>
                                                <stop offset="0%" class="stop-color-final"
                                                    style="stop-color: rgb(203, 211, 227); stop-opacity: 1;"></stop>
                                                <stop offset="100%" class="stop-color-final"
                                                    style="stop-color: rgb(203, 211, 227); stop-opacity: 1;"></stop>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(255, 192, 0); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(255, 192, 0); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(255, 192, 0); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(203, 211, 227); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(203, 211, 227); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div><span class="product-rating-count-container__count">(4838)</span>
                        </div>
                        <div class="product-rating-count-container" style="border: 1px solid rgb(230, 230, 230);">
                            <div class="product-rating-count-container__star">
                                <div class="star-ratings" title="2 Stars"
                                    style="position: relative; box-sizing: border-box; display: inline-block;"><svg
                                        class="star-grad"
                                        style="position: absolute; z-index: 0; width: 0px; height: 0px; visibility: hidden;">
                                        <defs>
                                            <linearGradient id="starGrad693687090609999" x1="0%" y1="0%"
                                                x2="100%" y2="0%">
                                                <stop offset="0%" class="stop-color-first"
                                                    style="stop-color: rgb(255, 192, 0); stop-opacity: 1;"></stop>
                                                <stop offset="0%" class="stop-color-first"
                                                    style="stop-color: rgb(255, 192, 0); stop-opacity: 1;"></stop>
                                                <stop offset="0%" class="stop-color-final"
                                                    style="stop-color: rgb(203, 211, 227); stop-opacity: 1;"></stop>
                                                <stop offset="100%" class="stop-color-final"
                                                    style="stop-color: rgb(203, 211, 227); stop-opacity: 1;"></stop>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(255, 192, 0); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(255, 192, 0); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(203, 211, 227); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(203, 211, 227); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(203, 211, 227); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div><span class="product-rating-count-container__count">(1645)</span>
                        </div>
                        <div class="product-rating-count-container" style="border: 1px solid rgb(230, 230, 230);">
                            <div class="product-rating-count-container__star">
                                <div class="star-ratings" title="1 Star"
                                    style="position: relative; box-sizing: border-box; display: inline-block;"><svg
                                        class="star-grad"
                                        style="position: absolute; z-index: 0; width: 0px; height: 0px; visibility: hidden;">
                                        <defs>
                                            <linearGradient id="starGrad536671721252328" x1="0%" y1="0%"
                                                x2="100%" y2="0%">
                                                <stop offset="0%" class="stop-color-first"
                                                    style="stop-color: rgb(255, 192, 0); stop-opacity: 1;"></stop>
                                                <stop offset="0%" class="stop-color-first"
                                                    style="stop-color: rgb(255, 192, 0); stop-opacity: 1;"></stop>
                                                <stop offset="0%" class="stop-color-final"
                                                    style="stop-color: rgb(203, 211, 227); stop-opacity: 1;"></stop>
                                                <stop offset="100%" class="stop-color-final"
                                                    style="stop-color: rgb(203, 211, 227); stop-opacity: 1;"></stop>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(255, 192, 0); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(203, 211, 227); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(203, 211, 227); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px; padding-right: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(203, 211, 227); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="star-container"
                                        style="position: relative; display: inline-block; vertical-align: middle; padding-left: 2px;">
                                        <svg viewBox="0 0 14 14" class="widget-svg"
                                            style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                            <path class="star"
                                                d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                style="fill: rgb(203, 211, 227); transition: fill 0.2s ease-in-out 0s;">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div><span class="product-rating-count-container__count">(2594)</span>
                        </div>
                    </div>
                </div>
                <span class="product-review-section-wrapper__wrapper__filter_title">Fotoğraflı Değerlendirmeler</span>
                <div class="slick-agentsc mt-3" style="padding: 0 50px">
                    @foreach ($institutional->owners as $comment)
                        @foreach (json_decode($comment->images, true) as $img)
                            <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                <div class="landscapes">
                                    <div class="project-single">
                                        <div class="project-inner project-head">
                                            <div class="homes">
                                                <a href="{{ asset('storage/' . preg_replace('@^public/@', null, $img)) }}"
                                                    data-lightbox="gallery">
                                                    <img src="{{ asset('storage/' . preg_replace('@^public/@', null, $img)) }}"
                                                        style="object-fit: cover;width:100%;height:100%" />
                                                </a>
                                            </div>
                                        </div>
                                        <!-- homes content -->

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
                @if (count($institutional->owners))
                    <div class="flex flex-col gap-6 mt-5">
                        @foreach ($institutional->owners as $comment)
                            <div class="bg-white border rounded-md pb-3 mb-3"
                                @if (!$loop->last) style="border-bottom: 1px solid #E6E6E6 !important; " @endif>
                                <a href="{{ route('housing.show', $comment->housing->id) }}"
                                    class="product-review-container__redirect" target="_blank"><img
                                        src="{{ asset('housing_images/' . getImage($comment->housing, 'image')) }}"
                                        alt="Ürün Görseli">
                                    <div class="product-review-container__redirect__span-wrapper">
                                        <p style="font-weight: 600; color: rgb(51, 51, 51);">
                                            {{ $comment->housing->title }}</p>
                                        <p style="font-weight: 400; color: rgb(157, 157, 157);">
                                            {{ $comment->housing->address }}</p>
                                    </div>
                                </a>
                                <div class="ml-auto order-2 mt-3 mb-3">
                                    @for ($i = 0; $i < $comment->rate; ++$i)
                                        <svg enable-background="new 0 0 50 50" height="15px" id="Layer_1"
                                            version="1.1" viewBox="0 0 50 50" width="15px" xml:space="preserve"
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <rect fill="none" height="50" width="50" />
                                            <polygon fill="gold"
                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                stroke="gold" stroke-miterlimit="10" stroke-width="2" />
                                        </svg>
                                    @endfor
                                    @for ($i = 0; $i < 5 - $comment->rate; ++$i)
                                        <svg enable-background="new 0 0 50 50" height="15px" id="Layer_1"
                                            version="1.1" viewBox="0 0 50 50" width="15px" xml:space="preserve"
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <rect fill="none" height="50" width="50" />
                                            <polygon fill="none"
                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                stroke="gold" stroke-miterlimit="10" stroke-width="2" />
                                        </svg>
                                    @endfor
                                </div>
                                <div class="head d-flex w-full">
                                    <div>
                                        <div class="font-weight-bold">{{ $comment->user->name }}</div>
                                        <i class="small"><?= strftime('%d %B %A', strtotime($comment->created_at)) ?></i>
                                    </div>
                                </div>
                                <div class="body py-3">
                                    {{ $comment->comment }}
                                </div>
                                <div class="row mt-3">
                                    @foreach (json_decode($comment->images, true) as $img)
                                        <div class="col-md-2">
                                            <a href="<?= asset('storage/' . preg_replace('@^public/@', null, $img)) ?>"
                                                data-lightbox="gallery">
                                                <img src="<?= asset('storage/' . preg_replace('@^public/@', null, $img)) ?>"
                                                    style="object-fit: cover;width:100%" />
                                            </a>

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <span>Bu konut için henüz yorum yapılmadı.</span>
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
            font-size: 14px;
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
            margin-left: 20px;
            margin-top: 10px;
            align-items: center margin-right: 20px;
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
            font-size: 12px;
        }

        .product-rating-count-container__count {
            margin-left: 7px;
            margin-top: 3px
        }

        .product-review-section-wrapper__wrapper__filter_title {
            font-family: source_sans_proregular, sans-serif;
            font-style: normal;
            font-weight: 600;
            font-size: 12px;
            line-height: 15px;
            color: #999;
            margin-left: 20px;
            margin-bottom: 10px;
        }
    </style>
@endsection
