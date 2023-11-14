@extends('client.layouts.master')

@php
    $sold = DB::select('SELECT * FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "housing"  AND JSON_EXTRACT(cart, "$.item.id") = ? LIMIT 1', [$housing->id]);
@endphp
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

    $discountAmount = 0;

    $offer = App\Models\Offer::where('type', 'housing')
        ->where('housing_id', $housing->id)
        ->where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->first();

    if ($offer) {
        $discountAmount = $offer->discount_amount;
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
                                @if ($sold)
                                    @if ($sold[0]->status != '0' && $sold[0]->status != '1')
                                        <div class="detail-wrapper-body">
                                            <div class="listing-title-bar">
                                                <h3>{{ $housing->title }} </h3>
                                                <div class="mt-0">
                                                    <a href="#listing-location" class="listing-address">
                                                        <i class="fa fa-map-marker pr-2 ti-location-pin mrg-r-5"></i>
                                                        {!! $housing->city->title !!} {{ '/' }} {!! $housing->county->ilce_title !!}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="single detail-wrapper mr-2">
                                            <div class="detail-wrapper-body">
                                                <div class="listing-title-bar">
                                                    <h4>
                                                        @if ($discountAmount)
                                                            <svg viewBox="0 0 24 24" width="24" height="24"
                                                                stroke="currentColor" stroke-width="2" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="css-i6dzq1">
                                                                <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                                <polyline points="17 18 23 18 23 12"></polyline>
                                                            </svg>
                                                        @endif
                                                        {{ number_format(getData($housing, 'price') - $discountAmount, 0, ',', '.') }}
                                                        ₺
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="detail-wrapper-body">
                                            <div class="listing-title-bar">

                                                <h3>{{ $housing->title }} </h3>
                                                <div class="mt-0">
                                                    <a href="#listing-location" class="listing-address">
                                                        <i class="fa fa-map-marker pr-2 ti-location-pin mrg-r-5"></i>
                                                        {!! $housing->city->title !!} {{ '/' }} {!! $housing->county->ilce_title !!}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="detail-wrapper-body">
                                        <div class="listing-title-bar">
                                            <h3>{{ $housing->title }} </h3>
                                            <div class="mt-0">
                                                <a href="#listing-location" class="listing-address">
                                                    <i class="fa fa-map-marker pr-2 ti-location-pin mrg-r-5"></i>
                                                    {!! $housing->city->title !!} {{ '/' }} {!! $housing->county->ilce_title !!}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single detail-wrapper mr-2">
                                        <div class="detail-wrapper-bodys">
                                            <div class="listing-title-bar">
                                                <h4>
                                                    @if ($discountAmount)
                                                        <svg viewBox="0 0 24 24" width="24" height="24"
                                                            stroke="currentColor" stroke-width="2" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="css-i6dzq1">
                                                            <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                            <polyline points="17 18 23 18 23 12"></polyline>
                                                        </svg>
                                                    @endif
                                                    {{ number_format(getData($housing, 'price') - $discountAmount, 0, ',', '.') }}
                                                    ₺
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                @endif

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
                                <i class="fa fa-heart-o"></i>
                            </div>
                        </div>
                        <div class="col-md-10 col-10">

                            @if ($sold && $sold[0]->status != '2')
                                <button class="btn second-btn soldBtn" disabled
                                    @if ($sold[0]->status == '0') style="background: orange !important;width:100%;color:White"
                                                        @else 
                                                        style="background: red !important;width:100%;color:White" @endif>
                                    @if ($sold[0]->status == '0')
                                        <span class="text">Onay Bekleniyor</span>
                                    @else
                                        <span class="text">Satıldı</span>
                                    @endif
                                </button>
                            @else
                                <button class="CartBtn" data-type='housing' data-id='{{ $housing->id }}'>
                                    <span class="IconContainer">
                                        <img src="{{ asset('sc.png') }}" alt="">
                                    </span>
                                    <span class="text">Sepete Ekle</span>
                                </button>
                            @endif



                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 blog-pots">
                    <div class="row">
                        <div class="col-md-12">

                            <div id="listingDetailsSlider" class="carousel listing-details-sliders slide mb-30">
                                <h5 class="mb-4">Galeri</h5>
                                <div class="carousel-inner">
                                    @foreach (json_decode(getImages($housing, 'images')) as $key => $image)
                                        <div class="item carousel-item {{ $key == 0 ? 'active' : '' }}"
                                            data-slide-number="{{ $key }}">
                                            <a href="{{ asset('housing_images/' . $image) }}"
                                                data-lightbox="image-gallery">
                                                <img src="{{ asset('housing_images/' . $image) }}" class="img-fluid"
                                                    alt="slider-listing">
                                            </a>
                                        </div>
                                    @endforeach

                                    <a class="carousel-control left" href="#listingDetailsSlider" data-slide="prev"><i
                                            class="fa fa-angle-left"></i></a>
                                    <a class="carousel-control right" href="#listingDetailsSlider" data-slide="next"><i
                                            class="fa fa-angle-right"></i></a>
                                </div>

                                <div class="listingDetailsSliderNav mt-3">
                                    @foreach (json_decode(getImages($housing, 'images')) as $imageKey => $image)
                                        <div class="item {{ $imageKey == 0 ? 'active' : '' }}"
                                            style="margin: 10px; cursor: pointer">
                                            <a id="carousel-selector-{{ $imageKey }}"
                                                data-slide-to="{{ $imageKey }}" data-target="#listingDetailsSlider">
                                                <img src="{{ asset('housing_images/' . $image) }}" class="img-fluid"
                                                    alt="listing-small">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            @if ($sold)
                            @if ($sold[0]->status != '0' && $sold[0]->status != '1')
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                            data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                            aria-selected="true">Açıklama</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                            type="button" role="tab" aria-controls="profile"
                                            aria-selected="false">Özellikler</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                                            type="button" role="tab" aria-controls="contact"
                                            aria-selected="false">Yorumlar</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active blog-info details mb-30" id="home" role="tabpanel"
                                        aria-labelledby="home-tab">
                                        {!! $housing->description !!}
                                    </div>
                                    <div class="tab-pane fade blog-info details" id="profile" role="tabpanel"
                                        aria-labelledby="profile-tab">
                                        <div class="similar-property featured portfolio p-0 bg-white">
        
                                            <div class="single homes-content">
                                                <!-- title -->
                                                <h5 class="mb-4">Özellikler</h5>
                                                <ul class="homes-list clearfix">
                                                    @foreach (json_decode($housing->housing_type_data, true) as $key => $val)
                                                        @php
                                                            $turkceKarsilik = [
                                                                'price' => 'Fiyat',
                                                                'numberoffloors' => 'Bulunduğu Kat',
                                                                'squaremeters' => 'm² (Net)',
                                                                'room_count' => 'Oda Sayısı',
                                                                'front1' => 'Cephe',
                                                                'm2gross' => 'm² (Brüt)',
                                                                'buildingage' => 'Bina Yaşı',
                                                                'heating' => 'Isıtma',
                                                                'balcony' => 'Balkon',
                                                                'numberofbathrooms' => 'Banyo Sayısı',
                                                                'usingstatus' => 'Kullanım Durumu',
                                                                'dues' => 'Aidat',
                                                                'titledeedstatus' => 'Tapu Durumu',
                                                                'external_features1' => 'Dış Özellikler',
                                                                'swap' => 'Takas',
                                                                'internal_features1' => 'İç Özellikler',
                                                                'floorlocation' => 'Kat Sayısı',
                                                                'canbenavigatedviavideocall1' => 'Görüntülü Arama İle Gezilebilir',
                                                                'furnished1' => 'Eşyalı',
                                                            ];
                                                            $key = $turkceKarsilik[$key] ?? $key;
                                                        @endphp
        
                                                        @if (
                                                            $key != 'image' &&
                                                                $key != 'images' &&
                                                                $key != 'İç Özellikler' &&
                                                                $key != 'Dış Özellikler' &&
                                                                $key != 'payment-plan1')
                                                            <li style="border: none !important;">
                                                                @if ($key == 'Fiyat')
                                                                    <span
                                                                        class="font-weight-bold mr-1">{{ $key }}:</span>
        
                                                                    <span class="det"
                                                                        style="color: black; font-weight: bold;">{{ number_format($val[0], 0, ',', '.') }}
                                                                        ₺</span>
                                                                @else
                                                                    <span
                                                                        class="font-weight-bold mr-1">{{ $key }}:</span>
                                                                    @if ($key == 'm² (Net)')
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
        
                                                @foreach (json_decode($housing->housing_type_data, true) as $key => $val)
                                                    @php
                                                        $turkceKarsilik = [
                                                            'price' => 'Fiyat',
                                                            'numberoffloors' => 'Bulunduğu Kat',
                                                            'squaremeters' => 'm² (Net)',
                                                            'room_count' => 'Oda Sayısı',
                                                            'front1' => 'Cephe',
                                                            'm2gross' => 'm² (Brüt)',
                                                            'buildingage' => 'Bina Yaşı',
                                                            'heating' => 'Isıtma',
                                                            'balcony' => 'Balkon',
                                                            'numberofbathrooms' => 'Banyo Sayısı',
                                                            'usingstatus' => 'Kullanım Durumu',
                                                            'dues' => 'Aidat',
                                                            'titledeedstatus' => 'Tapu Durumu',
                                                            'external_features1' => 'Dış Özellikler',
                                                            'swap' => 'Takas',
                                                            'canbenavigatedviavideocall' => 'Görüntülü Arama ile Gezilebilir',
                                                            'internal_features1' => 'İç Özellikler',
                                                            'floorlocation' => 'Kat Sayısı',
                                                            'canbenavigatedviavideocall1' => 'Görüntülü Arama İle Gezilebilir',
                                                            'furnished1' => 'Eşyalı',
                                                        ];
        
                                                        $key = $turkceKarsilik[$key] ?? $key;
                                                    @endphp
        
                                                    @if ($key == 'İç Özellikler' || $key == 'Dış Özellikler')
                                                        <h5 class="mt-5">{{ $key }}</h5>
                                                        <ul class="homes-list clearfix">
                                                            @foreach ($val as $ozellik)
                                                                <li><i class="fa fa-check-square"
                                                                        aria-hidden="true"></i><span>{{ $ozellik }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade  blog-info details" id="contact" role="tabpanel"
                                        aria-labelledby="contact-tab">
                                        <h5 class="mt-4">Yorumlar</h5>
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
                                                                    <svg enable-background="new 0 0 50 50" height="24px"
                                                                        id="Layer_1" version="1.1" viewBox="0 0 50 50"
                                                                        width="24px" xml:space="preserve"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                        <rect fill="none" height="50" width="50" />
                                                                        <polygon fill="gold"
                                                                            points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                            stroke="gold" stroke-miterlimit="10"
                                                                            stroke-width="2" />
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
                                                                            stroke="gold" stroke-miterlimit="10"
                                                                            stroke-width="2" />
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
                                            <span class="mb-3">Bu konut için henüz yorum yapılmadı.</span>
                                        @endif
        
                                        <form action="{{ route('housing.send-comment', ['id' => $id]) }}" method="POST"
                                            enctype="multipart/form-data" class="mt-5">
                                            @csrf
                                            <input type="hidden" name="rate" id="rate" />
                                            <h5>Yeni Yorum Ekle</h5>
                                            
                                            <div class="d-flex align-items-center w-full" style="gap: 6px;">
                                                <div class="d-flex rating-area">
                                                    <svg class="rating" enable-background="new 0 0 50 50" height="24px"
                                                        id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px"
                                                        xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                        <rect fill="none" height="50" width="50" />
                                                        <polygon fill="none"
                                                            points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                            stroke="#dadada" stroke-miterlimit="10" stroke-width="2" />
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
                                                    <input type="hidden" style="visibility: hidden;" class="fileinput"
                                                        name="images[]" multiple accept="image/*" />
                                                    <button type="button" class="btn btn-primary q-button "
                                                        onClick="jQuery('.fileinput').trigger('click');">Resimleri Seç</button>
                                                </div>
                                            </div>
                                            <textarea name="comment" rows="10" class="form-control mt-4" placeholder="Yorum girin..."></textarea>
                                            <button type="submit" class="ud-btn btn-white2 mt-3">Yorumu Gönder<i class="fal fa-arrow-right-long"></i></button>

                                        </form>
        
                                    </div>
                                </div>
                            @endif
                        @else
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                        type="button" role="tab" aria-controls="home"
                                        aria-selected="true">Açıklama</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                        type="button" role="tab" aria-controls="profile"
                                        aria-selected="false">Özellikler</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                                        type="button" role="tab" aria-controls="contact"
                                        aria-selected="false">Yorumlar</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active blog-info details mb-30" id="home" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    {!! $housing->description !!}
                                </div>
                                <div class="tab-pane fade blog-info details" id="profile" role="tabpanel"
                                    aria-labelledby="profile-tab">
                                    <div class="similar-property featured portfolio p-0 bg-white">
        
                                        <div class="single homes-content">
                                            <!-- title -->
                                            <h5 class="mb-4">Özellikler</h5>
                                            <ul class="homes-list clearfix">
                                                @foreach (json_decode($housing->housing_type_data, true) as $key => $val)
                                                    @php
                                                        $turkceKarsilik = [
                                                            'price' => 'Fiyat',
                                                            'numberoffloors' => 'Bulunduğu Kat',
                                                            'squaremeters' => 'm² (Net)',
                                                            'room_count' => 'Oda Sayısı',
                                                            'front1' => 'Cephe',
                                                            'm2gross' => 'm² (Brüt)',
                                                            'buildingage' => 'Bina Yaşı',
                                                            'heating' => 'Isıtma',
                                                            'balcony' => 'Balkon',
                                                            'numberofbathrooms' => 'Banyo Sayısı',
                                                            'usingstatus' => 'Kullanım Durumu',
                                                            'dues' => 'Aidat',
                                                            'titledeedstatus' => 'Tapu Durumu',
                                                            'external_features1' => 'Dış Özellikler',
                                                            'swap' => 'Takas',
                                                            'canbenavigatedviavideocall' => 'Görüntülü Arama ile Gezilebilir',
                                                            'internal_features1' => 'İç Özellikler',
                                                            'floorlocation' => 'Kat Sayısı',
                                                            'canbenavigatedviavideocall1' => 'Görüntülü Arama İle Gezilebilir',
                                                            'furnished1' => 'Eşyalı',
                                                        ];
        
                                                        $key = $turkceKarsilik[$key] ?? $key;
                                                    @endphp
        
                                                    @if (
                                                        $key != 'image' &&
                                                            $key != 'images' &&
                                                            $key != 'İç Özellikler' &&
                                                            $key != 'Dış Özellikler' &&
                                                            $key != 'payment-plan1')
                                                        <li style="border: none !important;">
                                                            @if ($key == 'Fiyat')
                                                                <span class="font-weight-bold mr-1">{{ $key }}:</span>
        
                                                                <span class="det"
                                                                    style="color: black; font-weight: bold;">{{ number_format($val[0], 0, ',', '.') }}
                                                                    ₺</span>
                                                            @else
                                                                <span class="font-weight-bold mr-1">{{ $key }}:</span>
                                                                @if ($key == 'm² (Net)')
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
        
                                            @foreach (json_decode($housing->housing_type_data, true) as $key => $val)
                                                @php
                                                    $turkceKarsilik = [
                                                        'price' => 'Fiyat',
                                                        'numberoffloors' => 'Bulunduğu Kat',
                                                        'squaremeters' => 'm² (Net)',
                                                        'room_count' => 'Oda Sayısı',
                                                        'front1' => 'Cephe',
                                                        'm2gross' => 'm² (Brüt)',
                                                        'buildingage' => 'Bina Yaşı',
                                                        'heating' => 'Isıtma',
                                                        'balcony' => 'Balkon',
                                                        'numberofbathrooms' => 'Banyo Sayısı',
                                                        'usingstatus' => 'Kullanım Durumu',
                                                        'dues' => 'Aidat',
                                                        'titledeedstatus' => 'Tapu Durumu',
                                                        'external_features1' => 'Dış Özellikler',
                                                        'swap' => 'Takas',
                                                        'canbenavigatedviavideocall' => 'Görüntülü Arama ile Gezilebilir',
                                                        'internal_features1' => 'İç Özellikler',
                                                        'floorlocation' => 'Kat Sayısı',
                                                        'canbenavigatedviavideocall1' => 'Görüntülü Arama İle Gezilebilir',
                                                        'furnished1' => 'Eşyalı',
                                                    ];
        
                                                    $key = $turkceKarsilik[$key] ?? $key;
                                                @endphp
        
                                                @if ($key == 'İç Özellikler' || $key == 'Dış Özellikler')
                                                    <h5 class="mt-5">{{ $key }}</h5>
                                                    <ul class="homes-list clearfix">
                                                        @foreach ($val as $ozellik)
                                                            <li><i class="fa fa-check-square"
                                                                    aria-hidden="true"></i><span>{{ $ozellik }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @php 
                                    $turkishMonths = [
                                        "Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık"
                                    ]
                                    @endphp
                                <div class="tab-pane fade  blog-info details" id="contact" role="tabpanel"
                                    aria-labelledby="contact-tab">
                                    <h5 class="mt-4">Yorumlar</h5>
                                    @if (count($housingComments))
                                        <div class="flex flex-col gap-6">
                                            @foreach ($housingComments as $comment)
                                                <div class="bg-white border rounded-md pb-3 mb-3"
                                                    style="border-bottom: 1px solid #E6E6E6 !important; ">
                                                    <div class="head d-flex w-full">
                                                        <div>
                                                            <div class="font-weight-bold">{{ $comment->user->name }}</div>
                                                            <i
                                                                class="small">{{$turkishMonths[date('n',strtotime($comment->created_at)) - 1].', '.date('d Y',strtotime($comment->created_at))}}</i>
                                                        </div>
                                                        <div class="ml-auto order-2">
                                                            @for ($i = 0; $i < $comment->rate; ++$i)
                                                                <svg enable-background="new 0 0 50 50" height="24px"
                                                                    id="Layer_1" version="1.1" viewBox="0 0 50 50"
                                                                    width="24px" xml:space="preserve"
                                                                    xmlns="http://www.w3.org/2000/svg"
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
                                        <span class="mb-3">Bu konut için henüz yorum yapılmadı.</span>
                                    @endif
        
                                    <form action="{{ route('housing.send-comment', ['id' => $id]) }}" method="POST"
                                        enctype="multipart/form-data" class="mt-5">
                                        @csrf
                                        <input type="hidden" name="rate" id="rate" />
                                        <h5>Yeni Yorum Ekle</h5>
                                        @if ($errors->any())
                                            <div class="alert alert-danger text-white">
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
                                                <div class="add-review-photos margin-bottom-30">
                                                    <div class="photoUpload">
                                                        <span><i class="sl sl-icon-arrow-up-circle"></i>Fotoğraf Yükle</span>
                                                        <input type="file" class="upload" name="images[]" multiple
                                                            accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <textarea name="comment" rows="10" class="form-control mt-4" placeholder="Yorum girin..."></textarea>
                                        
                                        <button type="submit" class="ud-btn btn-white2 mt-3">Yorumu Gönder<i class="fal fa-arrow-right-long"></i></button>
                                    </form>
        
                                </div>
                            </div>
                        @endif

                        </div>
                    </div>
                    <div class="tab-pane fade blog-info details" id="profile" role="tabpanel"
                        aria-labelledby="profile-tab">
                        <div class="similar-property featured portfolio p-0 bg-white">

                            <div class="single homes-content">
                                <!-- title -->
                                <h5 class="mb-4">Özellikler</h5>
                                <ul class="homes-list clearfix">
                                    @foreach (json_decode($housing->housing_type_data, true) as $key => $val)
                                        @php
                                            $turkceKarsilik = [
                                                'price' => 'Fiyat',
                                                'numberoffloors' => 'Bulunduğu Kat',
                                                'squaremeters' => 'm² (Net)',
                                                'room_count' => 'Oda Sayısı',
                                                'front1' => 'Cephe',
                                                'm2gross' => 'm² (Brüt)',
                                                'buildingage' => 'Bina Yaşı',
                                                'heating' => 'Isıtma',
                                                'balcony' => 'Balkon',
                                                'numberofbathrooms' => 'Banyo Sayısı',
                                                'usingstatus' => 'Kullanım Durumu',
                                                'dues' => 'Aidat',
                                                'titledeedstatus' => 'Tapu Durumu',
                                                'external_features1' => 'Dış Özellikler',
                                                'swap' => 'Takas',
                                                'canbenavigatedviavideocall' => 'Görüntülü Arama ile Gezilebilir',
                                                'internal_features1' => 'İç Özellikler',
                                                'floorlocation' => 'Kat Sayısı',
                                                'canbenavigatedviavideocall1' => 'Görüntülü Arama İle Gezilebilir',
                                                'furnished1' => 'Eşyalı',
                                                'availableforLoan1' => 'Krediye Uygun',
                                                'swap1' => 'Takaslı',
                                                'buysellurgent1' => 'Acil Satılık',
                                            ];

                                            $key = $turkceKarsilik[$key] ?? $key;
                                        @endphp


                </div>
                <aside class="col-md-4  car">
                    <div class="single widget">
                        <div class="widget-boxed">
                            <div class="widget-boxed-header">
                                <h4>Mağaza Bilgileri</h4>
                            </div>
                            <div class="widget-boxed-body">
                                <div class="sidebar-widget author-widget2">
                                    <div class="author-box clearfix">
                                        <img src="{{ URL::to('/') . '/storage/profile_images/' . $housing->user->profile_image }}"
                                            alt="author-image" class="author__img">
                                        <a href="{{ route('instituional.dashboard', Str::slug($housing->user->name)) }}">
                                            <h4 class="author__title">{!! $housing->user->name !!}</h4>
                                        </a>

                                        <p class="author__meta">{{ $housing->user->corporate_type }}</p>
                                    </div>
                                    <ul class="author__contact">
                                        <li><span class="la la-map-marker"><i
                                                    class="fa fa-map-marker"></i></span>{!! $housing->city->title !!}
                                            {{ '/' }} {!! $housing->county->ilce_title !!}</li>
                                        @if ($housing->user->phone)
                                            <li><span class="la la-phone"><i class="fa fa-phone"
                                                        aria-hidden="true"></i></span><a
                                                    style="text-decoration: none;color:inherit"
                                                    href="tel:{!! $housing->user->phone !!}">{!! $housing->user->phone !!}</a>
                                            </li>
                                        @endif

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
                                <h4>Mağazanın Diğer Konutları</h4>
                            </div>
                            <div class="widget-boxed-body">
                                <div class="recent-post">
                                    <div class="tags">
                                        @foreach ($housing->user->housings->take(5) as $item)
                                        <span><a href="{{ route('housing.show', $item->id) }}" class="btn btn-outline-primary">{{ $item->title }}</a></span>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (count($housing->user->banners) > 0)
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
                        @endif
                    </div>

            </aside>
        </div>


        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <!-- lightbox2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- lightbox2 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Owl Carousel Initialization
        $(document).ready(function() {
            $('.listingDetailsSliderNav').slick({
                slidesToShow: 5,
                slidesToScroll: 4,
                dots: false,
                loop: true,
                autoplay: false,
                arrows: false,
                margin: 20,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 993,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 2,
                        dots: false,
                        arrows: false
                    }
                }, {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        dots: false,
                        arrows: false
                    }
                }]
            });
        });
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endsection
