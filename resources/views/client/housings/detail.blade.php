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
        $a = json_encode($housing_type_data->{$key});
        return $a;
    }
@endphp

@section('content')
    <style>
        .rating-area .rating.selected polygon {
            fill: gold;
            stroke: gold
        }
    </style>
    <section class="single-proper blog details bg-white">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="container">
                        <div class="headings-2 pt-0">
                            <div class="pro-wrapper" style="width: 100%; justify-content: space-between;">
                                <div class="detail-wrapper-body">
                                    <div class="listing-title-bar">
                                        <h3>{{ $housing->title }} </h3>
                                        <div class="mt-0">
                                            <a href="#listing-location" class="listing-address">
                                                <i class="fa fa-map-marker pr-2 ti-location-pin mrg-r-5"></i>
                                                {!! $housing->address !!}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="single detail-wrapper mr-2">
                                    <div class="detail-wrapper-body">
                                        <div class="listing-title-bar">
                                            <h4>{{ getData($housing, 'price') }} TL</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row buttonDetail">
                        <div class="col-md-2 col-2">
                            <style>
                                .button-effect {
                                    border: solid 1px #e6e6e6;
                                    width: 48px;
                                    height: 48px;
                                    border-radius: 50%;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    cursor: pointer;
                                }
                            </style>
                            <div class="button-effect toggle-favorite" data-housing-id={{ $housing->id }}>
                                <i class="fa fa-heart"></i>
                            </div>
                        </div>
                        <div class="col-md-10 col-10">
                            <button
                                style="border: none;width:100%; background-color: #446BB6; border-radius: 10px; padding: 10px 50px; color: white;"
                                class="addToCart" data-type='housing' data-id='{{ $housing->id }}'>Sepete
                                Ekle</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 blog-pots">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- main slider carousel items -->
                            <div id="listingDetailsSlider" class="carousel listing-details-sliders slide mb-30">
                                <h5 class="mb-4">Galeri</h5>
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
                    <div class="similar-property featured portfolio p-0 bg-white">
                        <div class="blog-info details mb-30">
                            <h5 class="mb-4">Açıklama</h5>
                            <p class="mb-3">{!! $housing->description !!}</p>
                        </div>
                        <div class="single homes-content details mb-30">
                            <!-- title -->
                            <h5 class="mb-4">Bina Özellikleri</h5>
                            <ul class="homes-list clearfix">
                                @foreach (json_decode($housing->housing_type_data, true) as $key => $val)
                                    @php
                                        $turkceKarsilik = [
                                            'price' => 'Fiyat',
                                            'numberoffloors' => 'Bulunduğu Kat',
                                            'squaremeters' => 'Metrekare',
                                            'room_count' => 'Oda Sayısı',
                                            'front1' => 'Cephe',
                                            'internal_features1' => 'Özellikler',
                                        ];

                                        $key = $turkceKarsilik[$key] ?? $key;
                                    @endphp

                                    @if ($key != 'image' && $key != 'images' && $key != 'Özellikler')
                                        <li style="border: none !important;">
                                            @if ($key == 'Fiyat')
                                                <span class="font-weight-bold mr-1">{{ $key }}:</span>

                                                <span class="det"
                                                    style="color: #446BB6; font-weight: bold;">{{ number_format($val[0], 2, ',', '.') }}
                                                    TL</span>
                                            @else
                                                <span class="font-weight-bold mr-1">{{ $key }}:</span>
                                                @if ($key == 'Metrekare')
                                                    <span class="det">{{ $val[0] }} m2</span>
                                                @elseif ($key == 'Özellikler')
                                                    <ul>
                                                        @foreach ($val as $ozellik)
                                                            <li>{{ $ozellik }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <span class="det">{{ $val[0] }}</span>
                                                @endif
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            </ul>

                            <h5 class="mt-5">Özellikler</h5>
                            <ul class="homes-list clearfix">
                                @foreach (json_decode($housing->housing_type_data, true) as $key => $val)
                                    @php
                                        $turkceKarsilik = [
                                            'price' => 'Fiyat',
                                            'numberoffloors' => 'Bulunduğu Kat',
                                            'squaremeters' => 'Metrekare',
                                            'room_count' => 'Oda Sayısı',
                                            'front1' => 'Cephe',
                                            'internal_features1' => 'Özellikler',
                                        ];

                                        $key = $turkceKarsilik[$key] ?? $key;
                                    @endphp

                                    @if ($key == 'Özellikler')
                                        @foreach ($val as $ozellik)
                                            <li><i class="fa fa-check-square"
                                                    aria-hidden="true"></i><span>{{ $ozellik }}</span></li>
                                        @endforeach
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="single homes-content details mb-30">
                            <h5 class="mb-4">Yorumlar</h5>
                            @if (count($housingComments))
                                <div class="flex flex-col gap-6">
                                    @foreach ($housingComments as $comment)
                                        <div class="bg-white border rounded-md pb-3 mb-3"
                                            style="border-bottom: 1px solid #E6E6E6 !important; ">
                                            <div class="head d-flex w-full">
                                                <div>
                                                    <div class="font-weight-bold">{{ $comment->user->name }}</div>
                                                    <i
                                                        class="small"><?= strftime('%d %B %A', strtotime($comment->created_at)) ?></i>
                                                </div>
                                                <div class="ml-auto order-2">
                                                    @for ($i = 0; $i < $comment->rate; ++$i)
                                                        <svg enable-background="new 0 0 50 50" height="24px" id="Layer_1"
                                                            version="1.1" viewBox="0 0 50 50" width="24px"
                                                            xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <rect fill="none" height="50" width="50" />
                                                            <polygon fill="gold"
                                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                stroke="gold" stroke-miterlimit="10" stroke-width="2" />
                                                        </svg>
                                                    @endfor
                                                    @for ($i = 0; $i < 5 - $comment->rate; ++$i)
                                                        <svg enable-background="new 0 0 50 50" height="24px"
                                                            id="Layer_1" version="1.1" viewBox="0 0 50 50"
                                                            width="24px" xml:space="preserve"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <rect fill="none" height="50" width="50" />
                                                            <polygon fill="none"
                                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                stroke="gold" stroke-miterlimit="10" stroke-width="2" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="body py-3">
                                                {{ $comment->comment }}
                                            </div>
                                            <div class="row mt-3">
                                                @foreach (json_decode($comment->images, true) as $img)
                                                    <div class="col-md-2 col-3 mb-3">
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
                        <div class="single homes-content details mb-30">
                            <form action="{{ route('housing.send-comment', ['id' => $id]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="rate" id="rate" />
                                <h5 class="mb-4">Yeni Yorum Ekle</h5>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="d-flex align-items-center w-full" style="gap: 6px;">
                                    <div class="d-flex rating-area">
                                        <svg class="rating" enable-background="new 0 0 50 50" height="24px"
                                            id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px"
                                            xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <rect fill="none" height="50" width="50" />
                                            <polygon fill="none"
                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                stroke="#000000" stroke-miterlimit="10" stroke-width="2" />
                                        </svg>
                                        <svg class="rating" enable-background="new 0 0 50 50" height="24px"
                                            id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px"
                                            xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <rect fill="none" height="50" width="50" />
                                            <polygon fill="none"
                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                stroke="#000000" stroke-miterlimit="10" stroke-width="2" />
                                        </svg>
                                        <svg class="rating" enable-background="new 0 0 50 50" height="24px"
                                            id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px"
                                            xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <rect fill="none" height="50" width="50" />
                                            <polygon fill="none"
                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                stroke="#000000" stroke-miterlimit="10" stroke-width="2" />
                                        </svg>
                                        <svg class="rating" enable-background="new 0 0 50 50" height="24px"
                                            id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px"
                                            xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <rect fill="none" height="50" width="50" />
                                            <polygon fill="none"
                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                stroke="#000000" stroke-miterlimit="10" stroke-width="2" />
                                        </svg>
                                        <svg class="rating" enable-background="new 0 0 50 50" height="24px"
                                            id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px"
                                            xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <rect fill="none" height="50" width="50" />
                                            <polygon fill="none"
                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                stroke="#000000" stroke-miterlimit="10" stroke-width="2" />
                                        </svg>
                                    </div>
                                    <div class="ml-auto">
                                        <input type="file" style="visibility: hidden;" id="fileinput" name="images[]"
                                            multiple accept="image/*" />
                                        <button type="button" class="btn btn-primary q-button "
                                            onClick="jQuery('#fileinput').trigger('click');">Resimleri Seç</button>
                                    </div>
                                </div>
                                <textarea name="comment" rows="10" class="form-control mt-4" placeholder="Yorum girin..."></textarea>
                                <button type="submit" class="btn btn-primary q-button mt-4">YORUMU GÖNDER</button>
                            </form>
                        </div>
                    </div>


                </div>
                <aside class="col-md-4  car">
                    <div class="single widget">
                        <div class="widget-boxed">
                            <div class="widget-boxed-header">
                                <h4>Satıcı Bilgileri</h4>
                            </div>
                            <div class="widget-boxed-body">
                                <div class="sidebar-widget author-widget2">
                                    <div class="author-box clearfix">
                                        <img src="{{ URL::to('/') . '/storage/profile_images/' . $housing->user->profile_image }}"
                                            alt="author-image" class="author__img">
                                        <h4 class="author__title">{!! $housing->user->name !!}</h4>
                                        <p class="author__meta">{{ $housing->user->corporate_type }}</p>
                                    </div>
                                    <ul class="author__contact">
                                        <li><span class="la la-map-marker"><i
                                                    class="fa fa-map-marker"></i></span>{!! $housing->address !!}</li>
                                        <li><span class="la la-phone"><i class="fa fa-phone"
                                                    aria-hidden="true"></i></span><a
                                                style="text-decoration: none;color:inherit"
                                                href="tel:{!! $housing->user->phone !!}">{!! $housing->user->phone !!}</a>
                                        </li>
                                        <li><span class="la la-envelope-o"><i class="fa fa-envelope"
                                                    aria-hidden="true"></i></span><a
                                                style="text-decoration: none;color:inherit"
                                                href="mailto:{!! $housing->user->email !!}">{!! $housing->user->email !!}</a></li>
                                    </ul>
                                </div>
                                <hr>
                                @php
                                    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
                                    $host = $_SERVER['HTTP_HOST'];
                                    $uri = $_SERVER['REQUEST_URI'];
                                    $shareUrl = $protocol . '://' . $host . $uri;
                                @endphp
                                <div class="share-icons">
                                    <button class="button">
                                        <div class="icon">
                                            <svg height="18" width="18" xmlns="http://www.w3.org/2000/svg"
                                                version="1.1" viewBox="0 0 1024 1024" class="shere">
                                                <path fill="#f2295b"
                                                    d="M767.99994 585.142857q75.995429 0 129.462857 53.394286t53.394286 129.462857-53.394286 129.462857-129.462857 53.394286-129.462857-53.394286-53.394286-129.462857q0-6.875429 1.170286-19.456l-205.677714-102.838857q-52.589714 49.152-124.562286 49.152-75.995429 0-129.462857-53.394286t-53.394286-129.462857 53.394286-129.462857 129.462857-53.394286q71.972571 0 124.562286 49.152l205.677714-102.838857q-1.170286-12.580571-1.170286-19.456 0-75.995429 53.394286-129.462857t129.462857-53.394286 129.462857 53.394286 53.394286 129.462857-53.394286 129.462857-129.462857 53.394286q-71.972571 0-124.562286-49.152l-205.677714 102.838857q1.170286 12.580571 1.170286 19.456t-1.170286 19.456l205.677714 102.838857q52.589714-49.152 124.562286-49.152z">
                                                </path>
                                            </svg>
                                            <a href="https://facebook.com/share?url={{ $shareUrl }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-facebook icon-shere"
                                                    viewBox="0 0 16 16">
                                                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"></path>
                                                </svg>
                                            </a>       
                                             <a href="https://twitter.com/share?url={{ $shareUrl }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-twitter icon-shere"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z">
                                                    </path>
                                                </svg>
                                            </a>        
                                            <a href="https://instagram.com/share?url={{ $shareUrl }}">

                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-instagram icon-shere"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <a href="whatsapp://send?text={{ $shareUrl }}">

                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-whatsapp icon-shere"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z">
                                                    </path>
                                                </svg>
                                            </a>
                                        </div>
                                        <p>Paylaş</p>
                                    </button>
                                </div>
                                <div class="first-footer">
                                    <ul class="netsocials px-2">

                                        <li>
                                            <a href="https://twitter.com/share?url={{ $shareUrl }}">
                                                <i class="fa fa-twitter" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.instagram.com/">
                                                <i class="fa fa-instagram" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="whatsapp://send?text={{ $shareUrl }}">
                                                <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}">
                                                <i class="fa fa-facebook" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="widget-boxed popular mt-5">
                            <div class="widget-boxed-header">
                                <h4>Satıcının Diğer Konutları</h4>
                            </div>
                            <div class="widget-boxed-body">
                                <div class="recent-post">
                                    <div class="tags">
                                        @foreach ($housing->user->housings as $item)
                                            <span><a href="{{ route('housing.show', $item->id) }}"
                                                    class="btn btn-outline-primary">{{ $item->title }}</a></span>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-boxed popular mt-5">
                            <div class="widget-boxed-header">
                                <h4>{!! $housing->user->name !!}</h4>
                            </div>
                            <div class="widget-boxed-body">
                                @if (count($housing->user->banners) > 0)
                                    @php
                                        $randomBanner = $housing->user->banners[0];
                                        $imagePath = asset('storage/store_banners/' . $randomBanner['image']);
                                    @endphp
                                    <div class="banner"><img src="{{ $imagePath }}" alt=""></div>
                                @else
                                    <p>No banners available.</p>
                                @endif
                            </div>
                        </div>


                        <!-- End: Schedule a Tour -->
                        <!-- end author-verified-badge -->
                        {{-- <div class="sidebar">
                            <div class="widget-boxed mt-33 mt-5">
                                <div class="divider-fade"></div>
                                <div id="map" class="contactmap">
                                    <iframe
                                        src="https://maps.google.com/maps?q={{ $housing->latitude }},{{ $housing->longitude }}&hl=trh&z=14&amp;output=embed"
                                        width="100%" height="300px" style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>

                            </div>

                        </div> --}}
                    </div>
                </aside>
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
        jQuery('.rating-area .rating').on('mouseover', function() {
            jQuery('.rating-area .rating polygon').attr('fill', 'none');
            for (var i = 0; i <= $(this).index(); ++i)
                jQuery('.rating-area .rating polygon').eq(i).attr('fill', 'gold');
        });

        jQuery('.rating-area .rating').on('mouseleave', function() {
            jQuery('.rating-area .rating:not(.selected) polygon').attr('fill', 'none');
        });

        jQuery('.rating-area .rating').on('click', function() {
            jQuery('.rating-area .rating').removeClass('selected');
            for (var i = 0; i <= $(this).index(); ++i)
                jQuery('.rating-area .rating').eq(i).addClass('selected');

            $('#rate').val($(this).index() + 1);
        });
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endsection
