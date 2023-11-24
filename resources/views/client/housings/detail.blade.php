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
                                            </div>
                                        </div>
                                    @else
                                        <div class="detail-wrapper-body">
                                            <div class="listing-title-bar">

                                                <h3>{{ $housing->title }} </h3>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="detail-wrapper-body">
                                        <div class="listing-title-bar">
                                            <h3>{{ $housing->title }} </h3>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="headings-2 pt-0">
                        <div class="pro-wrapper" style="width: 100%; justify-content: space-between;">
                            @if ($sold)
                                @if ($sold[0]->status != '0' && $sold[0]->status != '1')
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
                                                    @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                        @if ($housing->step2_slug == 'gunluk-kiralik')
                                                            {{ getData($housing, 'daily_rent') - $discountAmount }} ₺

                                                            <span style="font-size:12px; color:#EA2B2E;margin-left:10px">(1
                                                                Gece)</span>
                                                        @else
                                                            {{ number_format(getData($housing, 'price') - $discountAmount, 0, ',', '.') }}
                                                            ₺
                                                        @endif
                                                    @endif
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
                                <div class="single detail-wrapper mr-2">
                                    <div class="detail-wrapper-bodys">
                                        <div class="listing-title-bar">
                                            <h4>
                                                @if ($discountAmount)
                                                    <svg viewBox="0 0 24 24" width="24" height="24"
                                                        stroke="currentColor" stroke-width="2" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                        <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                        <polyline points="17 18 23 18 23 12"></polyline>
                                                    </svg>
                                                @endif
                                                @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                    @if ($housing->step2_slug == 'gunluk-kiralik')
                                                        {{ number_format(getData($housing, 'daily_rent') - $discountAmount, 0, ',', '.') }}
                                                        ₺

                                                        <span style="font-size:14px; color:#EA2B2E;margin-left:10px">(1
                                                            Gece)</span>
                                                    @else
                                                        {{ number_format(getData($housing, 'price') - $discountAmount, 0, ',', '.') }}
                                                        ₺
                                                    @endif
                                                @endif
                                            </h4>
                                        </div>
                                    </div>
                                </div>
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

                            @if ($housing->step2_slug == 'gunluk-kiralik')
                                <div id="reservation-calendar"></div>
                            @endif


                            @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                @if ($sold)
                                    @if ($sold[0]->status != '0' && $sold[0]->status != '1')
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                                    data-bs-target="#home" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true">Açıklama</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                                    data-bs-target="#profile" type="button" role="tab"
                                                    aria-controls="profile" aria-selected="false">Özellikler</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                                    data-bs-target="#contact" type="button" role="tab"
                                                    aria-controls="contact" aria-selected="false">Yorumlar</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active blog-info details mb-30" id="home"
                                                role="tabpanel" aria-labelledby="home-tab">
                                                {!! $housing->description !!}
                                            </div>
                                            <div class="tab-pane fade blog-info details" id="profile" role="tabpanel"
                                                aria-labelledby="profile-tab">
                                                <div class="similar-property featured portfolio p-0 bg-white">

                                                    <div class="single homes-content">
                                                        <!-- title -->
                                                        <h5 class="mb-4">Özellikler</h5>
                                                        <table class="table table-bordered">
                                                            <tbody class="trStyle"> 
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
                                                                        'daily_rent' => 'Günlük Fiyat',
                                                                        'max_user' => 'Kişi Sayısı',
                                                                        'deposit' => 'Depozito',
                                                                        'end_time' => 'Çıkış Saati',
                                                                        'start_time' => 'Giriş Saati',
                                                                        'ulasim1' => 'Ulaşım',
                                                                        'muhit1' => 'Muhit',
                                                                        'konut_tipi1' => 'Konut Tipi',
                                                                        'manzara1' => 'Manzara',
                                                                        'engelliye_uygun1' => 'Engelliye Uygun',
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
                                                                        $key != 'Muhit' &&
                                                                        $key != 'Ulaşım' &&
                                                                        $key != 'Engelliye Uygun' &&
                                                                        $key != 'Konut Tipi' &&
                                                                        $key != 'payment-plan1')
                                                                

                                                                        </tr>
                                                                    <td>
                                                                        @if ($key == 'Fiyat')
                                                                            <span
                                                                                class=" mr-1">{{ $key }}:</span>
                                                                            <span class="det"
                                                                                style="color: black; ">
                                                                                {{ number_format($val[0], 0, ',', '.') }} ₺
                                                                            </span>
                                                                        @else
                                                                            <span
                                                                                class=" mr-1">{{ $key }}:</span>
                                                                            @if ($key == 'm² (Net)')
                                                                                <span class="det">{{ $val[0] }}
                                                                                    m2</span>
                                                                            @elseif ($key == 'Özellikler')
                                                                                <ul>
                                                                                    @foreach ($val as $ozellik)
                                                                                        <li>{{ $ozellik }}</li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            @else
                                                                                <span
                                                                                    class="det">{{ $val[0] }}</span>
                                                                            @endif
                                                                        @endif
                                                                    </td></tr>

                                                                @endif
                                                            @endforeach
                                                            </tbody>
                                                        </table>



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
                                                                    'daily_rent' => 'Günlük Fiyat',
                                                                    'max_user' => 'Kişi Sayısı',
                                                                    'deposit' => 'Depozito',
                                                                    'end_time' => 'Çıkış Saati',
                                                                    'start_time' => 'Giriş Saati',
                                                                    'ulasim1' => 'Ulaşım',
                                                                    'muhit1' => 'Muhit',
                                                                    'konut_tipi1' => 'Konut Tipi',
                                                                    'manzara1' => 'Manzara',
                                                                    'engelliye_uygun1' => 'Engelliye Uygun',
                                                                    'numberofbathrooms' => 'Banyo Sayısı',
                                                                    'usingstatus' => 'Kullanım Durumu',
                                                                    'dues' => 'Aidat',
                                                                    'titledeedstatus' => 'Tapu Durumu',
                                                                    'external_features1' => 'Dış Özellikler',
                                                                    'swap' => 'Takas',
                                                                    'islandnumber' => 'Ada No',
                                                                    'parcelnumber' => 'Parsel No',
                                                                    'sheetnumber' => 'Pafta No',
                                                                    'floorprovision' => 'Kat Karşılığı',
                                                                    'canbenavigatedviavideocall' => 'Görüntülü Arama ile Gezilebilir',
                                                                    'internal_features1' => 'İç Özellikler',
                                                                    'floorlocation' => 'Kat Sayısı',
                                                                    'canbenavigatedviavideocall1' => 'Görüntülü Arama İle Gezilebilir',
                                                                    'furnished1' => 'Eşyalı',
                                                                ];

                                                                $key = $turkceKarsilik[$key] ?? $key;
                                                            @endphp


                                                            @if (is_array($val))
                                                                @if (count($val) > 1)
                                                                    <h5 class="mt-5">{{ $key }}</h5>
                                                                    <ul class="homes-list clearfix">
                                                                        @foreach ($val as $item)
                                                                            <li><i class="fa fa-check-square"
                                                                                    aria-hidden="true"></i><span>{{ $item }}</span>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
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
                                                                        <div class="">
                                                                            {{ $comment->user->name }}</div>
                                                                        <i
                                                                            class="small"><?= strftime('%d %B %A', strtotime($comment->created_at)) ?></i>
                                                                    </div>
                                                                    <div class="ml-auto order-2">
                                                                        @for ($i = 0; $i < $comment->rate; ++$i)
                                                                            <svg enable-background="new 0 0 50 50"
                                                                                height="24px" id="Layer_1"
                                                                                version="1.1" viewBox="0 0 50 50"
                                                                                width="24px" xml:space="preserve"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                <rect fill="none" height="50"
                                                                                    width="50" />
                                                                                <polygon fill="gold"
                                                                                    points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                                    stroke="gold" stroke-miterlimit="10"
                                                                                    stroke-width="2" />
                                                                            </svg>
                                                                        @endfor
                                                                        @for ($i = 0; $i < 5 - $comment->rate; ++$i)
                                                                            <svg enable-background="new 0 0 50 50"
                                                                                height="24px" id="Layer_1"
                                                                                version="1.1" viewBox="0 0 50 50"
                                                                                width="24px" xml:space="preserve"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                <rect fill="none" height="50"
                                                                                    width="50" />
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

                                                <form action="{{ route('housing.send-comment', ['id' => $id]) }}"
                                                    method="POST" enctype="multipart/form-data" class="mt-5">
                                                    @csrf
                                                    <input type="hidden" name="rate" id="rate" />
                                                    <h5>Yeni Yorum Ekle</h5>

                                                    <div class="d-flex align-items-center w-full" style="gap: 6px;">
                                                        <div class="d-flex rating-area">
                                                            <svg class="rating" enable-background="new 0 0 50 50"
                                                                height="24px" id="Layer_1" version="1.1"
                                                                viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                <rect fill="none" height="50" width="50" />
                                                                <polygon fill="none"
                                                                    points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                    stroke="#dadada" stroke-miterlimit="10"
                                                                    stroke-width="2" />
                                                            </svg>
                                                            <svg class="rating" enable-background="new 0 0 50 50"
                                                                height="24px" id="Layer_1" version="1.1"
                                                                viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                <rect fill="none" height="50" width="50" />
                                                                <polygon fill="none"
                                                                    points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                    stroke="#000000" stroke-miterlimit="10"
                                                                    stroke-width="2" />
                                                            </svg>
                                                            <svg class="rating" enable-background="new 0 0 50 50"
                                                                height="24px" id="Layer_1" version="1.1"
                                                                viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                <rect fill="none" height="50" width="50" />
                                                                <polygon fill="none"
                                                                    points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                    stroke="#000000" stroke-miterlimit="10"
                                                                    stroke-width="2" />
                                                            </svg>
                                                            <svg class="rating" enable-background="new 0 0 50 50"
                                                                height="24px" id="Layer_1" version="1.1"
                                                                viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                <rect fill="none" height="50" width="50" />
                                                                <polygon fill="none"
                                                                    points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                    stroke="#000000" stroke-miterlimit="10"
                                                                    stroke-width="2" />
                                                            </svg>
                                                            <svg class="rating" enable-background="new 0 0 50 50"
                                                                height="24px" id="Layer_1" version="1.1"
                                                                viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                <rect fill="none" height="50" width="50" />
                                                                <polygon fill="none"
                                                                    points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                    stroke="#000000" stroke-miterlimit="10"
                                                                    stroke-width="2" />
                                                            </svg>
                                                        </div>
                                                        <div class="ml-auto">
                                                            <input type="hidden" style="visibility: hidden;"
                                                                class="fileinput" name="images[]" multiple
                                                                accept="image/*" />
                                                            <button type="button" class="btn btn-primary q-button "
                                                                onClick="jQuery('.fileinput').trigger('click');">Resimleri
                                                                Seç</button>
                                                        </div>
                                                    </div>
                                                    <textarea name="comment" rows="10" class="form-control mt-4" placeholder="Yorum girin..."></textarea>
                                                    <button type="submit" class="ud-btn btn-white2 mt-3">Yorumu Gönder<i
                                                            class="fal fa-arrow-right-long"></i></button>

                                                </form>

                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                                data-bs-target="#home" type="button" role="tab"
                                                aria-controls="home" aria-selected="true">Açıklama</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                                data-bs-target="#profile" type="button" role="tab"
                                                aria-controls="profile" aria-selected="false">Özellikler</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                                data-bs-target="#contact" type="button" role="tab"
                                                aria-controls="contact" aria-selected="false">Yorumlar</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active blog-info details mb-30" id="home"
                                            role="tabpanel" aria-labelledby="home-tab">
                                            {!! $housing->description !!}
                                        </div>
                                        <div class="tab-pane fade blog-info details" id="profile" role="tabpanel"
                                            aria-labelledby="profile-tab">
                                            <div class="similar-property featured portfolio p-0 bg-white">

                                                <div class="single homes-content">
                                                    <!-- title -->
                                                    <h5 class="mb-4">Özellikler</h5>
                                                    <table class="table table-bordered">
                                                        <tbody class="trStyle">

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
                                                                        'daily_rent' => 'Günlük Fiyat',
                                                                        'max_user' => 'Kişi Sayısı',
                                                                        'deposit' => 'Depozito',
                                                                        'end_time' => 'Çıkış Saati',
                                                                        'start_time' => 'Giriş Saati',
                                                                        'ulasim1' => 'Ulaşım',
                                                                        'muhit1' => 'Muhit',
                                                                        'konut_tipi1' => 'Konut Tipi',
                                                                        'manzara1' => 'Manzara',
                                                                        'engelliye_uygun1' => 'Engelliye Uygun',
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
                                                                        $key != 'Muhit' &&
                                                                        $key != 'Ulaşım' &&
                                                                        $key != 'Engelliye Uygun' &&
                                                                        $key != 'Konut Tipi' &&
                                                                        $key != 'payment-plan1')
                                                                

                                                                    </tr>
                                                                        <td>
                                                                            @if ($key == 'Fiyat')
                                                                                <span
                                                                                    class=" mr-1">{{ $key }}:</span>
                                                                                <span class="det"
                                                                                    style="color: black; ">
                                                                                    {{ number_format($val[0], 0, ',', '.') }} ₺
                                                                                </span>
                                                                            @else
                                                                                <span
                                                                                    class=" mr-1">{{ $key }}:</span>
                                                                                @if ($key == 'm² (Net)')
                                                                                    <span class="det">{{ $val[0] }}
                                                                                        m2</span>
                                                                                @elseif ($key == 'Özellikler')
                                                                                    <ul>
                                                                                        @foreach ($val as $ozellik)
                                                                                            <li>{{ $ozellik }}</li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                @else
                                                                                    <span
                                                                                        class="det">{{ $val[0] }}</span>
                                                                                @endif
                                                                            @endif
                                                                        </td>
                                                                </tr>

                                                                @endif
                                                            @endforeach

                                                        </tbody>
                                                    </table>



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
                                                                'daily_rent' => 'Günlük Fiyat',
                                                                'max_user' => 'Kişi Sayısı',
                                                                'deposit' => 'Depozito',
                                                                'end_time' => 'Çıkış Saati',
                                                                'start_time' => 'Giriş Saati',
                                                                'numberofbathrooms' => 'Banyo Sayısı',
                                                                'usingstatus' => 'Kullanım Durumu',
                                                                'ulasim1' => 'Ulaşım',
                                                                'muhit1' => 'Muhit',
                                                                'konut_tipi1' => 'Konut Tipi',
                                                                'manzara1' => 'Manzara',
                                                                'engelliye_uygun1' => 'Engelliye Uygun',

                                                                'dues' => 'Aidat',
                                                                'titledeedstatus' => 'Tapu Durumu',
                                                                'external_features1' => 'Dış Özellikler',
                                                                'swap' => 'Takas',
                                                                'islandnumber' => 'Ada No',
                                                                'parcelnumber' => 'Parsel No',
                                                                'sheetnumber' => 'Pafta No',
                                                                'floorprovision' => 'Kat Karşılığı',
                                                                'canbenavigatedviavideocall' => 'Görüntülü Arama ile Gezilebilir',
                                                                'internal_features1' => 'İç Özellikler',
                                                                'floorlocation' => 'Kat Sayısı',
                                                                'canbenavigatedviavideocall1' => 'Görüntülü Arama İle Gezilebilir',
                                                                'furnished1' => 'Eşyalı',
                                                            ];

                                                            $key = $turkceKarsilik[$key] ?? $key;
                                                        @endphp


                                                        @if (is_array($val))
                                                            @if (count($val) > 1)
                                                                <h5 class="mt-5">{{ $key }}</h5>
                                                                <ul class="homes-list clearfix">
                                                                    @foreach ($val as $item)
                                                                        <li><i class="fa fa-check-square"
                                                                                aria-hidden="true"></i><span>{{ $item }}</span>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
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
                                                                    <div class="">
                                                                        {{ $comment->user->name }}</div>
                                                                    <i class="small">{{ $comment->created_at }}</i>
                                                                </div>
                                                                <div class="ml-auto order-2">
                                                                    @for ($i = 0; $i < $comment->rate; ++$i)
                                                                        <svg enable-background="new 0 0 50 50"
                                                                            height="24px" id="Layer_1" version="1.1"
                                                                            viewBox="0 0 50 50" width="24px"
                                                                            xml:space="preserve"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                            <rect fill="none" height="50"
                                                                                width="50" />
                                                                            <polygon fill="gold"
                                                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                                stroke="gold" stroke-miterlimit="10"
                                                                                stroke-width="2" />
                                                                        </svg>
                                                                    @endfor
                                                                    @for ($i = 0; $i < 5 - $comment->rate; ++$i)
                                                                        <svg enable-background="new 0 0 50 50"
                                                                            height="24px" id="Layer_1" version="1.1"
                                                                            viewBox="0 0 50 50" width="24px"
                                                                            xml:space="preserve"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                            <rect fill="none" height="50"
                                                                                width="50" />
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

                                            <form id="commentForm"
                                                action="{{ route('housing.send-comment', ['id' => $id]) }}"
                                                method="POST" enctype="multipart/form-data" class="mt-5">

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
                                                        <svg class="rating" enable-background="new 0 0 50 50"
                                                            height="24px" id="Layer_1" version="1.1"
                                                            viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <rect fill="none" height="50" width="50" />
                                                            <polygon fill="none"
                                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                stroke="#000000" stroke-miterlimit="10"
                                                                stroke-width="2" />
                                                        </svg>
                                                        <svg class="rating" enable-background="new 0 0 50 50"
                                                            height="24px" id="Layer_1" version="1.1"
                                                            viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <rect fill="none" height="50" width="50" />
                                                            <polygon fill="none"
                                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                stroke="#000000" stroke-miterlimit="10"
                                                                stroke-width="2" />
                                                        </svg>
                                                        <svg class="rating" enable-background="new 0 0 50 50"
                                                            height="24px" id="Layer_1" version="1.1"
                                                            viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <rect fill="none" height="50" width="50" />
                                                            <polygon fill="none"
                                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                stroke="#000000" stroke-miterlimit="10"
                                                                stroke-width="2" />
                                                        </svg>
                                                        <svg class="rating" enable-background="new 0 0 50 50"
                                                            height="24px" id="Layer_1" version="1.1"
                                                            viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <rect fill="none" height="50" width="50" />
                                                            <polygon fill="none"
                                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                stroke="#000000" stroke-miterlimit="10"
                                                                stroke-width="2" />
                                                        </svg>
                                                        <svg class="rating" enable-background="new 0 0 50 50"
                                                            height="24px" id="Layer_1" version="1.1"
                                                            viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <rect fill="none" height="50" width="50" />
                                                            <polygon fill="none"
                                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                stroke="#000000" stroke-miterlimit="10"
                                                                stroke-width="2" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-auto">
                                                        <div class="add-review-photos margin-bottom-30">
                                                            <div class="photoUpload">
                                                                <span><i class="sl sl-icon-arrow-up-circle"></i>Fotoğraf
                                                                    Yükle</span>
                                                                <input type="file" class="upload" name="images[]"
                                                                    multiple accept="image/*">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <textarea name="comment" rows="10" class="form-control mt-4" placeholder="Yorum girin..."></textarea>

                                                <button type="button" onclick="submitForm()"
                                                    class="ud-btn btn-white2 mt-3">Yorumu Gönder<i
                                                        class="fal fa-arrow-right-long"></i></button>
                                            </form>

                                        </div>
                                    </div>
                                @endif
                            @endif

                        </div>
                    </div>


                </div>
                <aside class="col-md-4  car">
                    <div class="single widget">

                        @if ($housing->step2_slug == 'gunluk-kiralik')
                            <div class="homes-content details-2 mb-4">
                                <ul class="homes-list reservation-list clearfix">
                                    <li>
                                        <i class="fa fa-object-group" aria-hidden="true"></i>
                                        <span>Giriş: {{ getData($housing, 'start_time') }}</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-car" aria-hidden="true"></i>
                                        <span>Çıkış: {{ getData($housing, 'end_time') }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="schedule widget-boxed mt-33 mt-0">
                                <div class="widget-boxed-header">
                                    <h4><i class="fa fa-calendar pr-3 padd-r-10"></i>Rezervasyon Yap</h4>
                                </div>
                                <div class="widget-boxed-body">
                                    <form id="rezervasyonForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12 book">
                                                <input type="date" id="date-checkin" placeholder="Giriş Tarihi"
                                                    name="check_in_date" class="date-field form-control">
                                            </div>
                                            <div class="col-lg-6 col-md-12 book2">
                                                <input type="date" id="date-checkout" placeholder="Çıkış Tarihi"
                                                    name="check_out_date" class="date-field form-control">
                                            </div>
                                        </div>
                                        <div class="row mrg-top-15 mb-3">
                                            <div class="col-lg-6 col-md-12 mt-4">
                                                <label>Kişi Sayısı</label>
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn counter-btn theme-cl btn-number"
                                                            disabled="disabled" data-type="minus" data-field="quant[1]">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                    </span>
                                                    <input type="text" name="person_count"
                                                        class="border-0 text-center form-control input-number"
                                                        data-min="0" data-max="10" value="0">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn counter-btn theme-cl btn-number"
                                                            data-type="plus" data-field="quant[1]">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12 mt-4 showPrice d-none">
                                                <label>Toplam Tutar</label>
                                                <div class="input-group">
                                                    <span id="totalPrice">₺</span>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button"
                                            @if (!Auth::check()) onclick="redirectToPage()" @else  data-toggle="modal" data-target="#paymentModal" @endif
                                            class=" reservationBtn reservation btn-radius full-width mrg-top-10 text-white">Rezervasyon
                                            Yap</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="schedule widget-boxed mt-33 mt-0">


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
                                        @if (isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                            <button class="btn second-btn CartBtn" disabled
                                                style="background: red !important;width:100%;color:White">

                                                <span class="text">Satıldı</span>
                                            </button>
                                        @else
                                            @if ($sold && isset($sold[0]) && $sold[0]->status != '2')
                                                @php
                                                    $buttonStyle = '';
                                                    $buttonText = '';
                                                    if ($sold[0]->status == '0') {
                                                        $buttonStyle = 'background: orange !important; width: 100%; color: white;';
                                                        $buttonText = 'Onay Bekleniyor';
                                                    } else {
                                                        $buttonStyle = 'background: red !important; width: 100%; color: white;';
                                                        $buttonText = 'Satıldı';
                                                    }
                                                @endphp

                                                <button class="btn second-btn soldBtn" disabled
                                                    style="{{ $buttonStyle }}">
                                                    <span class="text">{{ $buttonText }}</span>
                                                </button>
                                            @else
                                                <button class="CartBtn" data-type='housing'
                                                    data-id='{{ $housing->id }}'>
                                                    <span class="IconContainer">
                                                        <img src="{{ asset('sc.png') }}" alt="">
                                                    </span>
                                                    <span class="text">Sepete Ekle</span>
                                                </button>
                                            @endif
                                        @endif




                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="widget-boxed mt-5">
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
                        {{-- <div class="widget-boxed popular mt-5">
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
                        </div> --}}
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

    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Emlak Sepette Rezervasyon Adımı</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="invoice">
                        <div class="invoice-header mb-3">
                            <strong>Rezervasyon Tarihi: {{ date('d.m.Y') }}</strong>
                        </div>

                        <div class="invoice-body">

                        </div>
                        <div class="invoice-total mt-3">
                            <strong class="mt-3">EFT/Havale yapacağınız bankayı seçiniz</strong>
                            <input type="hidden" name="key" id="orderKey">
                            <div class="row mb-3 px-5 mt-3">
                                @foreach ($bankAccounts as $bankAccount)
                                    <div class="col-md-4 bank-account" data-id="{{ $bankAccount->id }}"
                                        data-iban="{{ $bankAccount->iban }}"
                                        data-title="{{ $bankAccount->receipent_full_name }}">
                                        <img src="{{ URL::to('/') }}/{{ $bankAccount->image }}" alt=""
                                            style="width: 100%;height:100px;object-fit:contain;cursor:pointer">
                                    </div>
                                @endforeach
                            </div>
                            <div id="ibanInfo"></div>
                            <strong>Ödeme işlemini tamamlamak için, lütfen bu
                                <span style="color:red" id="uniqueCode"></span> kodu kullanarak ödemenizi
                                yapın. IBAN açıklama
                                alanına
                                bu kodu eklemeyi unutmayın. Ardından "Ödemeyi Tamamla" düğmesine tıklayarak işlemi
                                bitirin.</strong>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" @if ((Auth::check() && Auth::user()->type == '2') || (Auth::check() && Auth::user()->parent_id)) disabled @endif
                        class="btn btn-primary btn-lg btn-block mb-3" id="completePaymentButton">Satın Al
                    </button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="finalConfirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="finalConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="finalConfirmationModalLabel">Ödeme Onayı</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Ödemeniz başarıyla tamamlamak için lütfen aşağıdaki adımları takip edin:</p>
                    <ol>
                        <li>
                            <strong style="color:red" id="uniqueCodeRetry"></strong> kodunu EFT/Havale açıklama
                            alanına yazdığınızdan emin olun.
                        </li>
                        <li>
                            Son olarak, işlemi bitirmek için aşağıdaki butona tıklayın: <br>
                            <button type="button" id="submitBtn" class="btn btn-primary paySuccess mt-3">Ödemeyi Tamamla
                                <svg viewBox="0 0 576 512" class="svgIcon">
                                    <path
                                        d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24H360c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z">
                                    </path>
                                </svg></button>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        function redirectToPage() {
            window.location.href = "/giris-yap";
        }

        function submitForm() {
            var formData = new FormData($('#commentForm')[0]);
            $.ajax({
                url: $('#commentForm').attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Yorum Gönderildi',
                        text: 'Yorumunuz admin onayladıktan sonra yayınlanacaktır.',
                    });
                },
                error: function(error) {
                    window.location.href = "/giris-yap";
                    console.log(error);
                }
            });
        }
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
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        dots: false,
                        arrows: false
                    }
                }]
            });
        });
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


    @if ($housing->step2_slug == 'gunluk-kiralik')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var maxUser = parseInt("{{ getData($housing, 'max_user') }}"); // $housing'ten max_user değerini alın

                var inputElement = document.querySelector('input[name="person_count"]');
                var minusButton = document.querySelector('.btn-number[data-type="minus"]');
                var plusButton = document.querySelector('.btn-number[data-type="plus"]');

                minusButton.addEventListener('click', function() {
                    updateQuantity(-1);
                });

                plusButton.addEventListener('click', function() {
                    updateQuantity(1);
                });

                function updateQuantity(change) {
                    var currentValue = parseInt(inputElement.value);
                    var newValue = currentValue + change;

                    if (currentValue > maxUser) {
                        plusButton.disabled = true;
                    } else {
                        plusButton.disabled = false;
                    }
                    minusButton.disabled = (newValue <= 0);

                    if (newValue >= 0 && newValue <= maxUser) {
                        inputElement.value = newValue;
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'UYARI!',
                            text: 'Maksimum kişi sayısını aştınız.',
                        });

                        if (newValue > maxUser) {
                            plusButton.disabled = true;
                        } else {
                            plusButton.disabled = false;
                        }
                    }
                }
            });

            $(document).ready(function() {

                $(".reservation").on("click", function() {
                    var uniqueCode = generateUniqueCode();
                    $('#uniqueCode').text(uniqueCode);
                    $('#uniqueCodeRetry').text(uniqueCode);
                    $("#orderKey").val(uniqueCode);

                });
                var dateCheckin = $('#date-checkin');
                var dateCheckout = $('#date-checkout');

                dateCheckin.on('change', handleDateChange);
                dateCheckout.on('change', handleDateChange);

                function handleDateChange() {
                    var checkInDate = dateCheckin.val();
                    var checkOutDate = dateCheckout.val();
                    var price = parseInt("{{ getData($housing, 'daily_rent') }}");

                    // Eğer her iki tarih de seçilmişse kontrolü yap
                    if (checkInDate && checkOutDate) {
                        // Giriş ve çıkış tarihlerini Date objesine çevir
                        var startDate = new Date(checkInDate);
                        var endDate = new Date(checkOutDate);

                        // Minimum 7 gün tarih aralığı kontrolü
                        var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
                        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

                        if (diffDays < 7) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Uyarı!',
                                text: 'Minimum 7 gün tarih aralığı olmalı!',
                            });
                        } else {
                            $(".showPrice").removeClass("d-none");
                            $("#totalPrice").html(price * diffDays + " ₺");
                        }
                    }
                }

                $('#submitBtn').click(function() {
                    var price = parseInt("{{ getData($housing, 'daily_rent') }}");
                    var checkInDate = $('#date-checkin').val();
                    var checkOutDate = $('#date-checkout').val();
                    var key = $("#orderKey").val();

                    // Giriş ve çıkış tarihlerini Date objesine çevir
                    var startDate = new Date(checkInDate);
                    var endDate = new Date(checkOutDate);

                    // Minimum 7 gün tarih aralığı kontrolü
                    var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
                    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));


                    var personCount = $('input[name="person_count"]').val();

                    $.ajax({
                        url: "{{ route('reservation.store') }}",
                        type: "POST",
                        data: {
                            _token: $('input[name="_token"]').val(),
                            check_in_date: checkInDate,
                            check_out_date: checkOutDate,
                            person_count: personCount,
                            housing_id: {{ $housing->id }},
                            owner_id: {{ $housing->user->id }},
                            price: price * diffDays,
                            key: key
                        },
                        success: function(response) {
                            $('#finalConfirmationModal').modal('hide');
                            $('.modal-backdrop').removeClass('show');

                            Swal.fire({
                                icon: 'success',
                                title: 'Başarılı!',
                                text: response.message,
                            }).then(function() {
                                location.reload(); // Sayfayı yenile
                            });
                        },
                        error: function(error) {
                            // Hata durumunda burada gerekli işlemleri yapabilirsiniz
                            console.log(error);
                        }
                    });
                });
            });

            $(document).ready(function() {
                // Başlangıçta ödeme düğmesini devre dışı bırak
                $('#completePaymentButton').prop('disabled', true);


                $('.bank-account').on('click', function() {
                    // Tüm banka görsellerini seçim olmadı olarak ayarla
                    $('.bank-account').removeClass('selected');

                    // Seçilen banka görselini işaretle
                    $(this).addClass('selected');

                    // İlgili IBAN bilgisini al
                    var selectedBankIban = $(this).data('iban');
                    var selectedBankIbanID = $(this).data('id');
                    var selectedBankTitle = $(this).data('title');
                    $('#bankaID').val(selectedBankIbanID);


                    // IBAN bilgisini ekranda göster
                    $('#ibanInfo').text(selectedBankTitle + " : " + selectedBankIban);
                    // Ödeme düğmesini etkinleştir
                    $('#completePaymentButton').prop('disabled', false);
                });

                $('#completePaymentButton').on('click', function() {
                    $('#paymentModal').removeClass('show');
                    $('#finalConfirmationModal').modal('show');
                });
            });


            function generateUniqueCode() {
                return Math.random().toString(36).substring(2, 10).toUpperCase();
            }
        </script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="{{ asset('js/tr.js') }}"></script>
        <script>
            function addWarningTooltip(target, booking) {
                if (booking.status === 0) {
                    target.title = "Bu tarih aralığı için rezervasyon onay bekliyor.";
                }
            }

            function applyClassesToDates(selectedDates, dateStr, instance) {
                var reservations = {!! json_encode($housing->reservations) !!};
                var bookedDates = reservations.map(function(reservation) {
                    return {
                        from: reservation.check_in_date,
                        to: reservation.check_out_date,
                        status: reservation.status
                    };
                });

                var container = instance.calendarContainer;

                container.querySelectorAll(".flatpickr-day").forEach(function(day) {
                    var targetDate = day.dateObj;
                    if (targetDate) {
                        var booking = bookedDates.find(function(reservation) {
                            return targetDate >= new Date(reservation.from) && targetDate <= new Date(
                                reservation.to);
                        });

                        if (booking) {
                            if (booking.status === 0) {
                                day.classList.add("yellow-bg");
                                addWarningTooltip(day, booking);
                                if (targetDate == new Date(booking.from) || targetDate > new Date(booking.from)) {
                                    day.classList.add("flatpickr-disabled");
                                    day.addEventListener("click", function(event) {
                                        event.preventDefault();
                                        event.stopPropagation();
                                    });
                                }
                            } else if (booking.status === 1) {
                                day.classList.add("red-bg");
                                // Disable etme
                                day.addEventListener("click", function(event) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                });
                            } else if (booking.status === 2) {
                                day.classList.remove("flatpickr-disabled");
                                // Tıklanmaya izin verme
                                day.addEventListener("click", function(event) {
                                    event.stopPropagation();
                                });
                            } else {
                                day.classList.remove("yellow-bg", "red-bg", "disable-day");
                            }
                        }

                        bookedDates.forEach(function(reservation) {
                            if (targetDate >= new Date(reservation.from) && targetDate == new Date(reservation
                                    .from) &&
                                targetDate <= new Date(reservation.to)) {
                                if (reservation.status === 0) {
                                    day.classList.add("bg-yellow");
                                } else if (reservation.status === 1) {
                                    day.classList.add("bg-red");
                                }
                            }
                        });
                    }
                });
            }

            var today = new Date().toISOString().split("T")[0];
            var reservationCalendar;

            function updateCalendarView() {
                var isMobile = window.innerWidth <= 768; // Örnek bir mobil genişlik sınıfı
                var showMonths = isMobile ? 1 : 2;

                if (reservationCalendar) {
                    reservationCalendar.destroy();
                }
                // Bu fonksiyon, iki tarih aralığı seçildiğinde tetiklenir
                function onSelectDates(selectedDates, dateStr, instance) {
                    var checkinDate = selectedDates[0];
                    var checkoutDate = selectedDates[selectedDates.length - 1];

                    // Eğer her iki tarih de seçilmişse, input alanlarına yazdır
                    if (checkinDate && checkoutDate) {
                        document.getElementById('date-checkin').value = formatDate(checkinDate);
                        document.getElementById('date-checkout').value = formatDate(checkoutDate);

                        var price = parseInt("{{ getData($housing, 'daily_rent') }}");
                        var startDate = new Date(checkinDate);
                        var endDate = new Date(checkoutDate);

                        // Eğer seçilen tarihler aynı değilse, işlemleri yap
                        if (endDate.getTime() !== startDate.getTime()) {
                            var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
                            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

                            if (diffDays < 7) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Uyarı!',
                                    text: 'Minimum 7 gün tarih aralığı olmalı!',
                                });
                            } else {
                                $(".showPrice").removeClass("d-none");
                                $("#totalPrice").html(price * diffDays + " ₺");
                            }
                        }
                    }
                }

                // Bu fonksiyon, tarihi belirli bir formata dönüştürür
                function formatDate(date) {
                    var day = date.getDate();
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();

                    // Gerekirse ayları ve günleri iki basamaklı hale getirin
                    if (day < 10) {
                        day = '0' + day;
                    }

                    if (month < 10) {
                        month = '0' + month;
                    }

                    return year + '-' + month + '-' + day;
                }
                reservationCalendar = flatpickr("#reservation-calendar", {
                    mode: "range",
                    dateFormat: "Y-m-d",
                    inline: true,
                    locale: 'tr',
                    showMonths: showMonths,
                    minDate: today, // Bugünden önceki tarihleri disable et
                    onReady: applyClassesToDates,
                    onChange: onSelectDates,
                    onMonthChange: applyClassesToDates
                });
            }

            // Sayfa yüklendiğinde ve pencere boyutu değiştiğinde kontrolü güncelle
            document.addEventListener('DOMContentLoaded', updateCalendarView);
            window.addEventListener('resize', updateCalendarView);


            var dateCheckin = flatpickr("#date-checkin", {
                dateFormat: 'Y-m-d',
                locale: 'tr',
                minDate: today, // Bugünden önceki tarihleri disable et
                onReady: applyClassesToDates,
                onChange: applyClassesToDates,
                onMonthChange: applyClassesToDates
            });

            var dateCheckout = flatpickr("#date-checkout", {
                dateFormat: 'Y-m-d',
                locale: 'tr',
                minDate: today, // Bugünden önceki tarihleri disable et
                onReady: applyClassesToDates,
                onChange: applyClassesToDates,
                onMonthChange: applyClassesToDates
            });
        </script>
    @endif
@endsection

@section('styles')
    <style>
        .trStyle
        ,.trStyle tr {
            display: flex;
            flex-wrap: wrap;
        }
        .trStyle tr{
            width: 50%;
        }
        .trStyle tr td{ 
            width: 100%;
            font-size: 13px;
        }
        @media (max-width:768px) {
            .trStyle tr{
            width: 100%;
        }
        }
        .flatpickr-day.flatpickr-disabled,
        .flatpickr-day.flatpickr-disabled:hover {
            background: #f8e7e7;
        }

        .flatpickr-calendar.inline,
        .flatpickr-rContainer,
        .flatpickr-days,
        .dayContainer {
            width: 100% !important;
            max-width: 100% !important;
        }

        .dayContainer {
            padding: 11px !important;
        }

        .rating-area .rating.selected polygon {
            fill: gold;
            stroke: gold
        }

        #totalPrice {
            color: #274abb;
            font-weight: 600;
        }
    </style>
@endsection
