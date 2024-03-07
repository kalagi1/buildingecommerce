@extends('client.layouts.master')

@section('content')
@php

function convertMonthToTurkishCharacter($date)
{
$aylar = [
'January' => 'Ocak',
'February' => 'Şubat',
'March' => 'Mart',
'April' => 'Nisan',
'May' => 'Mayıs',
'June' => 'Haziran',
'July' => 'Temmuz',
'August' => 'Ağustos',
'September' => 'Eylül',
'October' => 'Ekim',
'November' => 'Kasım',
'December' => 'Aralık',
'Monday' => 'Pazartesi',
'Tuesday' => 'Salı',
'Wednesday' => 'Çarşamba',
'Thursday' => 'Perşembe',
'Friday' => 'Cuma',
'Saturday' => 'Cumartesi',
'Sunday' => 'Pazar',
'Jan' => 'Oca',
'Feb' => 'Şub',
'Mar' => 'Mar',
'Apr' => 'Nis',
'May' => 'May',
'Jun' => 'Haz',
'Jul' => 'Tem',
'Aug' => 'Ağu',
'Sep' => 'Eyl',
'Oct' => 'Eki',
'Nov' => 'Kas',
'Dec' => 'Ara',
];
return strtr($date, $aylar);
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
            <div class="card-img-top" style="background-color: {{ $store->banner_hex_code }}">
                <div class="brands-square w-100">
                    <img src="{{ url('storage/profile_images/' . $store->profile_image) }}" alt="" class="brand-logo">
                    <p class="brand-name"><a href="{{ route('institutional.profile', ["slug" => Str::slug($store->name), "userID" => $store->id]) }}" style="color:White">
                            {{ $store->name }}
                            <style type="text/css">
                                .st0 {
                                    fill: #e54242;
                                }

                                .st1 {
                                    opacity: 0.15;
                                }

                                .st2 {
                                    fill: #FFFFFF;
                                }
                            </style>
                            @if ($store->corporate_account_status )
                            <svg id="Layer_1" style="enable-background:new 0 0 120 120;" version="1.1"
                                width="24px" height="24px" viewBox="0 0 120 120" xml:space="preserve"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g>
                                    <path class="st0"
                                        d="M99.5,52.8l-1.9,4.7c-0.6,1.6-0.6,3.3,0,4.9l1.9,4.7c1.1,2.8,0.2,6-2.3,7.8L93,77.8c-1.4,1-2.3,2.5-2.7,4.1   l-0.9,5c-0.6,3-3.1,5.2-6.1,5.3l-5.1,0.2c-1.7,0.1-3.3,0.8-4.5,2l-3.5,3.7c-2.1,2.2-5.4,2.7-8,1.2l-4.4-2.6   c-1.5-0.9-3.2-1.1-4.9-0.7l-5,1.2c-2.9,0.7-6-0.7-7.4-3.4l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8   l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8   l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6c1.4-2.7,4.4-4.1,7.4-3.4l5,1.2c1.6,0.4,3.4,0.2,4.9-0.7l4.4-2.6c2.6-1.5,5.9-1.1,8,1.2   l3.5,3.7c1.2,1.2,2.8,2,4.5,2l5.1,0.2c3,0.1,5.6,2.3,6.1,5.3l0.9,5c0.3,1.7,1.3,3.2,2.7,4.1l4.2,2.9C99.7,46.8,100.7,50,99.5,52.8z   " />
                                    <g class="st1">
                                        <path
                                            d="M43.4,93.5l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4    c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6    c0.8-1.6,2.2-2.7,3.7-3.2c-2.7-0.4-5.4,1-6.6,3.5l-2.3,4.6c-0.8,1.5-2.1,2.7-3.7,3.2l-4.8,1.6c-2.9,1-4.7,3.8-4.4,6.8l0.5,5.1    c0.2,1.7-0.3,3.4-1.4,4.7l-3.2,4c-1.9,2.4-1.9,5.7,0,8.1l3.2,4c1.1,1.3,1.6,3,1.4,4.7l-0.5,5.1c-0.3,3,1.5,5.8,4.4,6.8l4.8,1.6    c1.6,0.5,2.9,1.7,3.7,3.2l2.3,4.6c1.4,2.7,4.4,4.1,7.4,3.4l0.6-0.1C46.3,96.7,44.4,95.5,43.4,93.5z" />
                                        <path
                                            d="M60.6,22.5l4.4-2.6c0.4-0.2,0.8-0.4,1.2-0.5c-1.4-0.2-2.9,0.1-4.1,0.8l-4.4,2.6c-0.4,0.2-0.8,0.4-1.2,0.5    C57.9,23.5,59.3,23.3,60.6,22.5z" />
                                        <path
                                            d="M81,92c-0.5,0-1,0.1-1.4,0.2l3.6-0.2c0.5,0,0.9-0.1,1.4-0.2L81,92z" />
                                        <path
                                            d="M65,98.9l-4.4-2.6c-1.5-0.9-3.2-1.1-4.9-0.7l-0.6,0.1c0.9,0.1,1.7,0.4,2.5,0.8l4.4,2.6c1.7,1,3.6,1.1,5.4,0.5    C66.6,99.6,65.8,99.4,65,98.9z" />
                                    </g>
                                    <polyline class="st0" points="44,53.6 56.5,67.9 82.1,47.3  " />
                                    <path class="st2"
                                        d="M53.5,75.3c-1.4,0-2.8-0.6-3.8-1.7L37.2,59.3c-1.8-2.1-1.6-5.2,0.4-7.1c2.1-1.8,5.2-1.6,7.1,0.4l9.4,10.7   l21.9-17.6c2.1-1.7,5.3-1.4,7,0.8c1.7,2.2,1.4,5.3-0.8,7L56.6,74.2C55.7,74.9,54.6,75.3,53.5,75.3z" />
                                </g>
                            </svg>
                        @endif
                        </a>
                    </p>
                    @if (Auth::check())
                    @if ($store->id == Auth::user()->id)
                    <a href="{{ url('institutional/choise-advertise-type') }}" style="margin-left: auto; margin-right:30px">
                        <button type="button" class="buyUserRequest ml-3">
                            <span class="buyUserRequest__text"> İlan Ekle</span>
                            <span class="buyUserRequest__icon">
                                <img src="{{ asset('sc.png') }}" alt="" srcset="">
                            </span>
                        </button></a>
                    @endif
                    @endif

                </div>

            </div>

            <div class="card-body">
                <nav class="navbar" style="padding: 0 !important">
                    <div class="navbar-items">
                        <a class="navbar-item " href="{{ route('institutional.dashboard',  ["slug" => Str::slug($store->name), "userID" => $store->id]) }}">Anasayfa</a>
                        <a class="navbar-item" href="{{ route('institutional.profile', ["slug" => Str::slug($store->name), "userID" => $store->id]) }}">Mağaza
                            Profili</a>
                        <a class="navbar-item" href="{{ route('institutional.projects.detail', ["slug" => Str::slug($store->name), "userID" => $store->id]) }}">Proje
                            İlanları</a>

                        <a class="navbar-item active" href="{{ route('institutional.housings', ["slug" => Str::slug($store->name), "userID" => $store->id]) }}">Emlak İlanları</a>
                        <a class="navbar-item"
                        href="{{ route('institutional.teams', ["slug" => Str::slug($store->name), "userID" => $store->id]) }}">Ekip</a>
                    </div>
                    <form class="search-form" action="{{ route('institutional.search') }}" method="GET">
                        @csrf
                        <input class="search-input" type="search" placeholder="Mağazada Ara" id="search-project" aria-label="Search" name="q">
                        <div class="header-search__suggestions">
                            <div class="header-search__suggestions__section">
                                <h5>Projeler</h5>
                                <div class="header-search__suggestions__section__items">
                                    @foreach ($store->projects as $item)
                                    <a href="{{ route('project.detail', ['slug' => $item->slug, 'id' => $item->id+1000000]) }}" class="project-item" data-title="{{ $item->project_title }}"><span>{{ $item->project_title }}</span></a>
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

<section class="featured portfolio rec-pro disc bg-white">
    @if ($secondhandHousings->isNotEmpty())
    <div class="container">
        <div class="featured-heads mb-3">
            <div class="section-title">
                <h2>Emlak İlanları</h2>
            </div>
        </div>

        <div class="mobile-show">
            @foreach ($secondhandHousings as $housing)
                @php($sold = $housing->sold)
                @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]) && (($sold && $sold != '1') || !$sold))
                    <x-housing-card-mobile :housing="$housing" :sold="$sold" />
                @endif
            @endforeach
        </div>

        <div class="mobile-hidden" style="margin-top: 20px">
            <section class="properties-right list featured portfolio blog pb-5 bg-white">
                <div class="container">
                    <div class="row">
                        @forelse ($secondhandHousings as $housing)
                            @php($sold = $housing->sold)
                            @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]) && (($sold && $sold != '1') || !$sold))
                                <div class="col-md-3">
                                    <x-housing-card :housing="$housing" :sold="$sold" />
                                </div>
                            @endif
                        @empty
                            <p>Henüz İlan Yayınlanmadı</p>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>
    </div>
    @else
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h2 class="mt-5 mb-3">Mağazaya ait emlak kaydı bulunamadı.</h2>
            <p>Lütfen daha sonra tekrar deneyin veya başka bir arama yapın.</p>
        </div>
    </div>
</div>
@endif
</section>






@endsection

@section('scripts')
<!-- lightbox2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- lightbox2 JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function() {
        $('.banner-agents').slick({
            infinite: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            dots: false,
            loop: true,
            autoplay: true,
            arrows: true,
            nav: true,
            margin: 0,
            adaptiveHeight: true,
            responsive: [{
                breakpoint: 1292,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: true
                }
            }, {
                breakpoint: 993,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: true
                }
            }, {
                breakpoint: 769,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: false
                }
            }]
        });
    });
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

<script>
    $('.finish-projects-web').slick({
        loop: true,
        nav: false,
        slidesToShow: 4,
        margin: 10,
    })

    $('.continue-projects-web').slick({
        loop: true,
        nav: false,
        slidesToShow: 4,
        margin: 10,
    })

    $('.secondhand-housings-web').slick({
        loop: true,
        nav: false,
        slidesToShow: 4,
        margin: 10,
    });
</script>
@endsection

@section('styles')
<style>
    .slick-track {
        margin: 0 !important;
    }

    .slick-slide {
        margin: 10px
    }

    .section-title h2 {
        color: black !important
    }

    .section-title:before {
        background-color: black !important
    }

    .bannerResize,
    .bannerResizeGrid {
        padding: 0 !important;
    }

    @media (max-width: 768px) {

        .bannerResize,
        .bannerResizeGrid {
            padding: 0 !important;
        }

        .section-title {
            margin-bottom: 20px !important;
            padding-bottom: 0 !important;
        }

        .circleIcon {
            font-size: 5px;
            color: #e54242;
            padding-right: 5px
        }

        .priceFont {
            font-weight: 600;
            font-size: 11px;
        }
    }
</style>
@endsection