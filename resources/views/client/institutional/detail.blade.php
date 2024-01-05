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
                                style="color:White">
                                {{ $institutional->name }}
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
                                <svg id="Layer_1" style="enable-background:new 0 0 120 120;" version="1.1" width="24px"
                                    height="24px" viewBox="0 0 120 120" xml:space="preserve"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g>
                                        <path class="st0"
                                            d="M99.5,52.8l-1.9,4.7c-0.6,1.6-0.6,3.3,0,4.9l1.9,4.7c1.1,2.8,0.2,6-2.3,7.8L93,77.8c-1.4,1-2.3,2.5-2.7,4.1   l-0.9,5c-0.6,3-3.1,5.2-6.1,5.3l-5.1,0.2c-1.7,0.1-3.3,0.8-4.5,2l-3.5,3.7c-2.1,2.2-5.4,2.7-8,1.2l-4.4-2.6   c-1.5-0.9-3.2-1.1-4.9-0.7l-5,1.2c-2.9,0.7-6-0.7-7.4-3.4l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8   l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8   l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6c1.4-2.7,4.4-4.1,7.4-3.4l5,1.2c1.6,0.4,3.4,0.2,4.9-0.7l4.4-2.6c2.6-1.5,5.9-1.1,8,1.2   l3.5,3.7c1.2,1.2,2.8,2,4.5,2l5.1,0.2c3,0.1,5.6,2.3,6.1,5.3l0.9,5c0.3,1.7,1.3,3.2,2.7,4.1l4.2,2.9C99.7,46.8,100.7,50,99.5,52.8z   " />
                                        <g class="st1">
                                            <path
                                                d="M43.4,93.5l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4    c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6    c0.8-1.6,2.2-2.7,3.7-3.2c-2.7-0.4-5.4,1-6.6,3.5l-2.3,4.6c-0.8,1.5-2.1,2.7-3.7,3.2l-4.8,1.6c-2.9,1-4.7,3.8-4.4,6.8l0.5,5.1    c0.2,1.7-0.3,3.4-1.4,4.7l-3.2,4c-1.9,2.4-1.9,5.7,0,8.1l3.2,4c1.1,1.3,1.6,3,1.4,4.7l-0.5,5.1c-0.3,3,1.5,5.8,4.4,6.8l4.8,1.6    c1.6,0.5,2.9,1.7,3.7,3.2l2.3,4.6c1.4,2.7,4.4,4.1,7.4,3.4l0.6-0.1C46.3,96.7,44.4,95.5,43.4,93.5z" />
                                            <path
                                                d="M60.6,22.5l4.4-2.6c0.4-0.2,0.8-0.4,1.2-0.5c-1.4-0.2-2.9,0.1-4.1,0.8l-4.4,2.6c-0.4,0.2-0.8,0.4-1.2,0.5    C57.9,23.5,59.3,23.3,60.6,22.5z" />
                                            <path d="M81,92c-0.5,0-1,0.1-1.4,0.2l3.6-0.2c0.5,0,0.9-0.1,1.4-0.2L81,92z" />
                                            <path
                                                d="M65,98.9l-4.4-2.6c-1.5-0.9-3.2-1.1-4.9-0.7l-0.6,0.1c0.9,0.1,1.7,0.4,2.5,0.8l4.4,2.6c1.7,1,3.6,1.1,5.4,0.5    C66.6,99.6,65.8,99.4,65,98.9z" />
                                        </g>
                                        <polyline class="st0" points="44,53.6 56.5,67.9 82.1,47.3  " />
                                        <path class="st2"
                                            d="M53.5,75.3c-1.4,0-2.8-0.6-3.8-1.7L37.2,59.3c-1.8-2.1-1.6-5.2,0.4-7.1c2.1-1.8,5.2-1.6,7.1,0.4l9.4,10.7   l21.9-17.6c2.1-1.7,5.3-1.4,7,0.8c1.7,2.2,1.4,5.3-0.8,7L56.6,74.2C55.7,74.9,54.6,75.3,53.5,75.3z" />
                                    </g>
                                </svg>
                            </a>
                        </p>
                        <p class="brand-name"><i class="fa fa-angle-right"></i> </p>
                        <p class="brand-name">Profil</p>

                    </div>

                </div>
                <div class="card-body">
                    <nav class="navbar" style="padding: 0 !important">
                        <div class="navbar-items">
                            <a class="navbar-item"
                                href="{{ route('instituional.dashboard', Str::slug($institutional->name)) }}">Anasayfa</a>
                            <a class="navbar-item active"
                                href="{{ route('instituional.profile', Str::slug($institutional->name)) }}">Mağaza
                                Profili</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.projects.detail', Str::slug($institutional->name)) }}">Proje
                                İlanları</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.housings', Str::slug($institutional->name)) }}">Emlak
                                İlanları</a>
                        </div>
                        <form class="search-form" action="{{ route('instituional.search') }}" method="GET">
                            @csrf
                            <input class="search-input" type="search" placeholder="Mağazada Ara" id="search-project"
                                aria-label="Search" name="q">
                            <div class="header-search__suggestions">
                                <div class="header-search__suggestions__section">
                                    <h5>Projeler</h5>
                                    <div class="header-search__suggestions__section__items">
                                        @foreach ($institutional->projects as $item)
                                            <a href="{{ route('project.detail', ['slug' => $item->slug]) }}"
                                                class="project-item"
                                                data-title="{{ $item->project_title }}"><span>{{ $item->project_title }}</span></a>
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

                    <div class="seller-info-container__wrapper"><img
                            src="{{url('images/artboard-2.svg')}}" alt="icon"
                            class="seller-info-container__wrapper__img">
                        <div class="seller-info-container__wrapper__text-container"><span
                                class="seller-info-container__wrapper__text-container__title">Katılma Tarihi</span><span
                                class="seller-info-container__wrapper__text-container__value">
                                {{ $institutional->created_at->setTimezone('Europe/Istanbul')->format('d.m.Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="seller-info-container__wrapper"><img
                        src="{{url('images/artboard.svg')}}" alt="icon"
                            class="seller-info-container__wrapper__img">
                        <div class="seller-info-container__wrapper__text-container"><span
                                class="seller-info-container__wrapper__text-container__title">Konum</span><span
                                class="seller-info-container__wrapper__text-container__value">
                                {{ $institutional->town->sehir_title }} <i class="fa fa-angle-right"></i>
                                {{ $institutional->district->ilce_title }} <i class="fa fa-angle-right"></i>
                                {{ $institutional->neighborhood->mahalle_title }} </span></div>
                    </div>
                </div>
            </div>

            <div class="single homes-content details mb-30">
                @if (count($institutional->owners))
                    <div style="margin-top: 20.5px;"><span
                            class="product-review-section-wrapper__wrapper__filter_title">Puana
                            Göre Filtrele</span>
                        <div class="product-review-section-wrapper__wrapper__product-rating-filters mb-5">

                            <!-- Create an array to store counts for each rating (1-5) -->
                            @php
                                $ratingCounts = [0, 0, 0, 0, 0];
                            @endphp

                            @foreach ($institutional->owners as $comment)
                                @if ($comment->rate >= 1 && $comment->rate <= 5)
                                    <!-- Increment the corresponding rating count -->
                                    @php
                                        $ratingCounts[$comment->rate - 1]++;
                                    @endphp
                                @endif
                            @endforeach

                            @foreach ([5, 4, 3, 2, 1] as $rating)
                                <div class="product-rating-count-container" style="border: 1px solid rgb(230, 230, 230);">

                                    <div class="product-rating-count-container__star">
                                        <div class="star-ratings" title="{{ $rating }} Stars"
                                            style="position: relative; box-sizing: border-box; display: inline-block;">
                                            @for ($i = 0; $i < $rating; $i++)
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
                                            @endfor
                                            @for ($i = $rating; $i < 5; $i++)
                                                <div class="star-container"
                                                    style="position: relative; display: inline-block; vertical-align: middle; padding-right: 2px;">
                                                    <svg viewBox="0 0 14 14" class="widget-svg"
                                                        style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                                        <path class="star"
                                                            d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                            style="fill: rgb(203, 211, 227); transition: fill 0.2s ease-in-out 0s;">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endfor
                                        </div>
                                        <span class="product-rating-count-container__count">
                                            ({{ $ratingCounts[$rating - 1] }})
                                        </span>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                    </div>
                    <span class="product-review-section-wrapper__wrapper__filter_title">Fotoğraflı Değerlendirmeler</span>
                    <div class="slick-agentsc mt-3 mb-3" style="padding: 0 50px">
                        @foreach ($institutional->owners as $comment)
                            @if (json_decode($comment->images, true) > 0)
                                @foreach (json_decode($comment->images, true) as $img)
                                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="homes">
                                                        <a href="{{ asset('storage/' . preg_replace('@^public/@', null, $img)) }}"
                                                            data-lightbox="gallery">
                                                            <img src="{{ asset('storage/' . preg_replace('@^public/@', null, $img)) }}"
                                                                style="object-fit: cover;width:100%;height:150px" />
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- homes content -->

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <span>Bu konut için fotoğraflı değerlendirme yapılmadı.</span>
                            @endif
                        @endforeach
                    </div>

                    <span class="product-review-section-wrapper__wrapper__filter_title"> Değerlendirmeler</span>
                    <div class="flex flex-col gap-6 mt-3" style="padding: 0 20px">
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
                                        <div class="">{{ $comment->user->name }}</div>
                                        <i class="small"><?= strftime('%d %B %A', strtotime($comment->created_at)) ?></i>
                                    </div>
                                </div>
                                <div class="body py-3">
                                    {{ $comment->comment }}
                                </div>
                                <div class="row mt-3">
                                    @foreach (json_decode($comment->images, true) as $img)
                                        <div class="col-md-1 col-3 mt-3">
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
                    <span>Bu mağaza için henüz yorum yapılmadı.</span>
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
            font-size: 12px;
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
