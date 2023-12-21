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

@php
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];
    $shareUrl = $protocol . '://' . $host . $uri;
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

                                    {{-- Kapak Görseli --}}
                                    <div class="item carousel-item active" data-slide-number="0">
                                        <a href="{{ asset('housing_images/' . json_decode($housing->housing_type_data)->image) }}"
                                            data-lightbox="image-gallery">
                                            <img src="{{ asset('housing_images/' . json_decode($housing->housing_type_data)->image) }}"
                                                class="img-fluid" alt="slider-listing">
                                        </a>
                                    </div>

                                    {{-- Diğer Görseller --}}
                                    @foreach (json_decode(getImages($housing, 'images')) as $key => $image)
                                        <div class="item carousel-item" data-slide-number="{{ $key + 1 }}">
                                            <a href="{{ asset('housing_images/' . $image) }}"
                                                data-lightbox="image-gallery">
                                                <img src="{{ asset('housing_images/' . $image) }}" class="img-fluid"
                                                    alt="slider-listing">
                                            </a>
                                        </div>
                                    @endforeach

                                    {{-- Carousel Kontrolleri --}}
                                    <a class="carousel-control left" href="#listingDetailsSlider" data-slide="prev"><i
                                            class="fa fa-angle-left"></i></a>
                                    <a class="carousel-control right" href="#listingDetailsSlider" data-slide="next"><i
                                            class="fa fa-angle-right"></i></a>
                                </div>

                                {{-- Küçük Resim Navigasyonu --}}
                                <div class="listingDetailsSliderNav mt-3">
                                    {{-- Kapak Görseli --}}
                                    <div class="item active" style="margin: 10px; cursor: pointer">
                                        <a id="carousel-selector-0" data-slide-to="0" data-target="#listingDetailsSlider">
                                            <img src="{{ asset('housing_images/' . json_decode($housing->housing_type_data)->image) }}"
                                                class="img-fluid altSlider" alt="listing-small">
                                        </a>
                                    </div>

                                    {{-- Diğer Görseller --}}
                                    @foreach (json_decode(getImages($housing, 'images')) as $imageKey => $image)
                                        <div class="item" style="margin: 10px; cursor: pointer">
                                            <a id="carousel-selector-{{ $imageKey + 1 }}"
                                                data-slide-to="{{ $imageKey + 1 }}" data-target="#listingDetailsSlider">
                                                <img src="{{ asset('housing_images/' . $image) }}"
                                                    class="img-fluid altSlider" alt="listing-small">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>






                            @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                @if ($sold)
                                    @if ($sold[0]->status != '0' && $sold[0]->status != '1')
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @if ($housing->step2_slug == 'gunluk-kiralik')
                                                <div id="reservation-calendar"></div>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="rez-tab" data-bs-toggle="tab"
                                                        data-bs-target="#rez" type="button" role="tab"
                                                        aria-controls="rez" aria-selected="true"> Takvim</button>
                                                </li>
                                            @endif
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link @if ($housing->step2_slug != 'gunluk-kiralik') active @endif"
                                                    id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                                    type="button" role="tab" aria-controls="home"
                                                    aria-selected="true">Açıklama</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                                    data-bs-target="#profile" type="button" role="tab"
                                                    aria-controls="profile" aria-selected="false">Özellikler</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                                    data-bs-target="#map" type="button" role="tab"
                                                    aria-controls="contact" aria-selected="false">Harita</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                                    data-bs-target="#contact" type="button" role="tab"
                                                    aria-controls="contact" aria-selected="false">Yorumlar</button>
                                            </li>
                                          

                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            @if ($housing->step2_slug == 'gunluk-kiralik')
                                                <div class="tab-pane fade show active blog-info details mb-30"
                                                    id="rez" role="tabpanel" aria-labelledby="rez-tab">
                                                    <div id="reservation-calendar"></div>
                                                </div>
                                            @endif

                                            <div class="tab-pane fade blog-info details mb-30 mb-30 @if ($housing->step2_slug != 'gunluk-kiralik') show active @endif"
                                                id="home" role="tabpanel" aria-labelledby="home-tab">
                                                {!! $housing->description !!}
                                            </div>
                                            <div class="tab-pane fade blog-info details mb-30" id="profile"
                                                role="tabpanel" aria-labelledby="profile-tab">
                                                <div class="similar-property featured portfolio p-0 bg-white">

                                                    <div class="single homes-content">
                                                        <!-- title -->
                                                        <h5 class="mb-4">Özellikler</h5>
                                                        <table class="table table-bordered">
                                                            <tbody class="trStyle">
                                                                <tr>
                                                                    <td>
                                                                        <span class="mr-1">İlan No:</span>
                                                                        <span class="det" style="color: black;">
                                                                            {{ $housing->id + 1000000 }}
                                                                        </span>
                                                                    </td>
                                                                </tr>

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
                                                                            'star_count' => 'Yıldız Sayısı',
                                                                            'kitchen_settings1' => 'Mutfak Özellikleri',
                                                                            'room_settings1' => 'Oda Özellikleri',
                                                                            'room_types1' => 'Oda Çeşitleri',
                                                                            'facility_settings1' => 'Tesis Özellikleri',
                                                                            'bath_settings1' => 'Banyo Özellikleri',
                                                                            'use_withs1' => 'Ortak Kullanım',
                                                                            'views1' => 'Manzara',
                                                                            'infrastructures1' => 'Altyapılar',
                                                                            'activities1' => 'Aktiviteler',
                                                                            'konut_tipi1' => 'Konut Tipi',
                                                                            'manzara1' => 'Manzara',
                                                                            'engelliye_uygun1' => 'Engelliye Uygun',
                                                                            'numberofbathrooms' => 'Banyo Sayısı',
                                                                            'usingstatus' => 'Kullanım Durumu',
                                                                            'dues' => 'Aidat',
                                                                            'titledeedstatus' => 'Tapu Durumu',
                                                                            'external_features1' => 'Dış Özellikler',
                                                                            'swap' => 'Takas',
                                                                            'swap1' => 'Takas',
                                                                            'internal_features1' => 'İç Özellikler',
                                                                            'floorlocation' => 'Kat Sayısı',
                                                                            'canbenavigatedviavideocall1' => 'Görüntülü Arama İle Gezilebilir',
                                                                            'furnished1' => 'Eşyalı',
                                                                            'buysellurgent1' => 'Acil Satılık',
                                                                            'structure' => 'Yapının Durumu',
                                                                            'bed_count' => 'Yatak Sayısı',
                                                                            'food_drink1' => 'Yeme İçme',
                                                                            'meeting1' => 'Toplantı & Kongre',
                                                                            'proximity1' => 'Yakınlık',
                                                                            'transportation1' => 'Ulaşım',
                                                                            'facilities1' => 'Tesis Aktiviteleri',
                                                                            'availableforLoan' => 'Krediye Uygun',
                                                                            'images' => 'Galeri',
                                                                            'usagePurpose1' => 'Kullanım Amacı',
                                                                            'generalFeatures1' => 'Genel Özellikler',
                                                                            'infrastructure1' => 'Altyapı',
                                                                        ];
                                                                        $key = $turkceKarsilik[$key] ?? $key;
                                                                    @endphp

                                                                    @if (
                                                                        $key != 'image' &&
                                                                            $key != 'Galeri' &&
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
                                                                                    {{ number_format($val[0], 0, ',', '.') }}
                                                                                    ₺
                                                                                </span>
                                                                            @else
                                                                                <span
                                                                                    class=" mr-1">{{ $key }}:</span>
                                                                                @if ($key == 'm² (Net)')
                                                                                    <span
                                                                                        class="det">{{ $val[0] }}
                                                                                        m2</span>
                                                                                @elseif ($key == 'Özellikler')
                                                                                    <ul>
                                                                                        @foreach ($val as $ozellik)
                                                                                            <li>{{ $ozellik }}</li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                @else
                                                                                    <span
                                                                                        class="det">{{ isset($val[0]) && $val[0] ? $val[0] : '' }}</span>
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
                                                                    'ulasim1' => 'Ulaşım',
                                                                    'muhit1' => 'Muhit',
                                                                    'star_count' => 'Yıldız Sayısı',
                                                                    'kitchen_settings1' => 'Mutfak Özellikleri',
                                                                    'room_settings1' => 'Oda Özellikleri',
                                                                    'room_types1' => 'Oda Çeşitleri',
                                                                    'facility_settings1' => 'Tesis Özellikleri',
                                                                    'bath_settings1' => 'Banyo Özellikleri',
                                                                    'use_withs1' => 'Ortak Kullanım',
                                                                    'views1' => 'Manzara',
                                                                    'infrastructures1' => 'Altyapılar',
                                                                    'activities1' => 'Aktiviteler',
                                                                    'konut_tipi1' => 'Konut Tipi',
                                                                    'manzara1' => 'Manzara',
                                                                    'engelliye_uygun1' => 'Engelliye Uygun',
                                                                    'numberofbathrooms' => 'Banyo Sayısı',
                                                                    'usingstatus' => 'Kullanım Durumu',
                                                                    'dues' => 'Aidat',
                                                                    'titledeedstatus' => 'Tapu Durumu',
                                                                    'external_features1' => 'Dış Özellikler',
                                                                    'swap' => 'Takas',
                                                                    'swap1' => 'Takas',
                                                                    'islandnumber' => 'Ada No',
                                                                    'parcelnumber' => 'Parsel No',
                                                                    'sheetnumber' => 'Pafta No',
                                                                    'floorprovision' => 'Kat Karşılığı',
                                                                    'canbenavigatedviavideocall' => 'Görüntülü Arama ile Gezilebilir',
                                                                    'internal_features1' => 'İç Özellikler',
                                                                    'floorlocation' => 'Kat Sayısı',
                                                                    'canbenavigatedviavideocall1' => 'Görüntülü Arama İle Gezilebilir',
                                                                    'furnished1' => 'Eşyalı',
                                                                    'furnished' => 'Eşyalı',
                                                                    'buysellurgent1' => 'Acil Satılık',
                                                                    'structure' => 'Yapının Durumu',
                                                                    'bed_count' => 'Yatak Sayısı',
                                                                    'food_drink1' => 'Yeme İçme',
                                                                    'meeting1' => 'Toplantı & Kongre',
                                                                    'proximity1' => 'Yakınlık',
                                                                    'transportation1' => 'Ulaşım',
                                                                    'facilities1' => 'Tesis Aktiviteleri',
                                                                    'availableforLoan' => 'Krediye Uygun',
                                                                    'images' => 'Galeri',
                                                                    'usagePurpose1' => 'Kullanım Amacı',
                                                                    'generalFeatures1' => 'Genel Özellikler',
                                                                    'infrastructure1' => 'Altyapı',
                                                                ];

                                                                $key = $turkceKarsilik[$key] ?? $key;
                                                            @endphp


                                                            @if (is_array($val))
                                                                @if (count($val) > 1)
                                                                    @if ($key != 'Galeri')
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
                                            <div class="tab-pane fade  blog-info details" id="map" role="tabpanel"
                                                aria-labelledby="contact-tab">
                                                <div class="similar-property featured portfolio p-0 bg-white">

                                                    <div id="map"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        @if ($housing->step2_slug == 'gunluk-kiralik')
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="rez-tab" data-bs-toggle="tab"
                                                    data-bs-target="#rez" type="button" role="tab"
                                                    aria-controls="rez" aria-selected="true"> Takvim</button>
                                            </li>
                                        @endif
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link @if ($housing->step2_slug != 'gunluk-kiralik') active @endif"
                                                id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                                type="button" role="tab" aria-controls="home"
                                                aria-selected="true">Açıklama</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                                data-bs-target="#profile" type="button" role="tab"
                                                aria-controls="profile" aria-selected="false">Özellikler</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                                data-bs-target="#map" type="button" role="tab"
                                                aria-controls="contact" aria-selected="false">Harita</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                                data-bs-target="#contact" type="button" role="tab"
                                                aria-controls="contact" aria-selected="false">Yorumlar</button>
                                        </li>
                                      
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        @if ($housing->step2_slug == 'gunluk-kiralik')
                                            <div class="tab-pane fade show active blog-info details mb-30" id="rez"
                                                role="tabpanel" aria-labelledby="rez-tab">
                                                <div id="reservation-calendar"></div>
                                            </div>
                                        @endif

                                        <div class="tab-pane fade blog-info details mb-30 mb-30 @if ($housing->step2_slug != 'gunluk-kiralik') show active @endif"
                                            id="home" role="tabpanel" aria-labelledby="home-tab">
                                            {!! $housing->description !!}
                                        </div>
                                        <div class="tab-pane fade blog-info details mb-30" id="profile" role="tabpanel"
                                            aria-labelledby="profile-tab">
                                            <div class="similar-property featured portfolio p-0 bg-white">

                                                <div class="single homes-content">
                                                    <!-- title -->
                                                    <h5 class="mb-4">Özellikler</h5>
                                                    <table class="table table-bordered">
                                                        <tbody class="trStyle">
                                                            <tr>
                                                                <td>
                                                                    <span class="mr-1">İlan No:</span>
                                                                    <span class="det" style="color: black;">
                                                                        {{ $housing->id + 1000000 }}
                                                                    </span>
                                                                </td>
                                                            </tr>

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
                                                                        'star_count' => 'Yıldız Sayısı',
                                                                        'kitchen_settings1' => 'Mutfak Özellikleri',
                                                                        'room_settings1' => 'Oda Özellikleri',
                                                                        'room_types1' => 'Oda Çeşitleri',
                                                                        'facility_settings1' => 'Tesis Özellikleri',
                                                                        'bath_settings1' => 'Banyo Özellikleri',
                                                                        'use_withs1' => 'Ortak Kullanım',
                                                                        'views1' => 'Manzara',
                                                                        'infrastructures1' => 'Altyapılar',
                                                                        'activities1' => 'Aktiviteler',
                                                                        'konut_tipi1' => 'Konut Tipi',
                                                                        'manzara1' => 'Manzara',
                                                                        'engelliye_uygun1' => 'Engelliye Uygun',
                                                                        'numberofbathrooms' => 'Banyo Sayısı',
                                                                        'usingstatus' => 'Kullanım Durumu',
                                                                        'dues' => 'Aidat',
                                                                        'titledeedstatus' => 'Tapu Durumu',
                                                                        'external_features1' => 'Dış Özellikler',
                                                                        'swap' => 'Takas',
                                                                        'swap1' => 'Takas',
                                                                        'internal_features1' => 'İç Özellikler',
                                                                        'floorlocation' => 'Kat Sayısı',
                                                                        'canbenavigatedviavideocall1' => 'Görüntülü Arama İle Gezilebilir',
                                                                        'furnished1' => 'Eşyalı',
                                                                        'furnished' => 'Eşyalı',
                                                                        'buysellurgent1' => 'Acil Satılık',
                                                                        'structure' => 'Yapının Durumu',
                                                                        'bed_count' => 'Yatak Sayısı',
                                                                        'food_drink1' => 'Yeme İçme',
                                                                        'meeting1' => 'Toplantı & Kongre',
                                                                        'proximity1' => 'Yakınlık',
                                                                        'transportation1' => 'Ulaşım',
                                                                        'facilities1' => 'Tesis Aktiviteleri',
                                                                        'availableforLoan' => 'Krediye Uygun',
                                                                        'images' => 'Galeri',
                                                                        'usagePurpose1' => 'Kullanım Amacı',
                                                                        'generalFeatures1' => 'Genel Özellikler',
                                                                        'infrastructure1' => 'Altyapı',
                                                                        'off_sale1' => 'Satışa Kapalı',
                                                                    ];
                                                                    $key = $turkceKarsilik[$key] ?? $key;
                                                                @endphp

                                                                @if (
                                                                    $key != 'image' &&
                                                                        $key != 'Galeri' &&
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
                                                                            <span class="det" style="color: black; ">
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
                                                                                    class="det">{{ isset($val[0]) ? $val[0] : 'Hayır' }}</span>
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
                                                                'star_count' => 'Yıldız Sayısı',
                                                                'kitchen_settings1' => 'Mutfak Özellikleri',
                                                                'room_settings1' => 'Oda Özellikleri',
                                                                'room_types1' => 'Oda Çeşitleri',
                                                                'facility_settings1' => 'Tesis Özellikleri',
                                                                'bath_settings1' => 'Banyo Özellikleri',
                                                                'use_withs1' => 'Ortak Kullanım',
                                                                'views1' => 'Manzara',
                                                                'infrastructures1' => 'Altyapılar',
                                                                'activities1' => 'Aktiviteler',
                                                                'konut_tipi1' => 'Konut Tipi',
                                                                'manzara1' => 'Manzara',
                                                                'engelliye_uygun1' => 'Engelliye Uygun',

                                                                'dues' => 'Aidat',
                                                                'titledeedstatus' => 'Tapu Durumu',
                                                                'external_features1' => 'Dış Özellikler',
                                                                'swap' => 'Takas',
                                                                'swap1' => 'Takas',
                                                                'islandnumber' => 'Ada No',
                                                                'parcelnumber' => 'Parsel No',
                                                                'sheetnumber' => 'Pafta No',
                                                                'floorprovision' => 'Kat Karşılığı',
                                                                'canbenavigatedviavideocall' => 'Görüntülü Arama ile Gezilebilir',
                                                                'internal_features1' => 'İç Özellikler',
                                                                'floorlocation' => 'Kat Sayısı',
                                                                'canbenavigatedviavideocall1' => 'Görüntülü Arama İle Gezilebilir',
                                                                'furnished1' => 'Eşyalı',
                                                                'furnished' => 'Eşyalı',
                                                                'buysellurgent1' => 'Acil Satılık',
                                                                'structure' => 'Yapının Durumu',
                                                                'bed_count' => 'Yatak Sayısı',
                                                                'food_drink1' => 'Yeme İçme',
                                                                'meeting1' => 'Toplantı & Kongre',
                                                                'proximity1' => 'Yakınlık',
                                                                'transportation1' => 'Ulaşım',
                                                                'facilities1' => 'Tesis Aktiviteleri',
                                                                'availableforLoan' => 'Krediye Uygun',
                                                                'images' => 'Galeri',
                                                                'usagePurpose1' => 'Kullanım Amacı',
                                                                'generalFeatures1' => 'Genel Özellikler',
                                                                'infrastructure1' => 'Altyapı',
                                                            ];

                                                            $key = $turkceKarsilik[$key] ?? $key;
                                                        @endphp


                                                        @if (is_array($val))
                                                            @if (count($val) > 1)
                                                                @if ($key != 'Galeri')
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
                                        <div class="tab-pane fade  blog-info details" id="map" role="tabpanel"
                                            aria-labelledby="contact-tab">
                                            <div class="similar-property featured portfolio p-0 bg-white">

                                                <div id="map"></div>
                                            </div>
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
                            <div class="mobileMove">
                                <div class="homes-content details-2 mb-4">
                                    <ul class="homes-list reservation-list clearfix">
                                        <li>
                                            <span>Giriş: {{ getData($housing, 'start_time') }}</span>
                                        </li>
                                        <li>
                                            <span>Çıkış: {{ getData($housing, 'end_time') }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="schedule widget-boxed mt-33 mt-0">
                                    <div class="widget-boxed-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h4><i class="fa fa-calendar pr-3 padd-r-10"></i>Rezervasyon Yap</h4>
                                            <div class="d-flex align-items-center justify-content-around">
                                                <div class="buttons" style="margin-right: 5px">
                                                    <button class="main-button">
                                                        <svg width="20" height="30" fill="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M15.75 5.125a3.125 3.125 0 1 1 .754 2.035l-8.397 3.9a3.124 3.124 0 0 1 0 1.88l8.397 3.9a3.125 3.125 0 1 1-.61 1.095l-8.397-3.9a3.125 3.125 0 1 1 0-4.07l8.397-3.9a3.125 3.125 0 0 1-.144-.94Z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                    <button class="twitter-button button"
                                                        style="transition-delay: 0.1s, 0s, 0.1s; transition-property: translate, background, box-shadow;">
    
                                                        <a
                                                        href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}">
                                                        <svg viewBox="0 0 24 24" width="24" height="24"
                                                            stroke="currentColor" stroke-width="2" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="css-i6dzq1">
                                                            <path
                                                                d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z">
                                                            </path>
                                                        </svg></a>
                                                    </button>
    
                                                    <button class="reddit-button button"
                                                        style="transition-delay: 0.2s, 0s, 0.2s; transition-property: translate, background, box-shadow;">
                                                        <a href="whatsapp://send?text={{ $shareUrl }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                fill="currentColor" height="30" width="30">
                                                                <path
                                                                    d="M19.001 4.908A9.817 9.817 0 0 0 11.992 2C6.534 2 2.085 6.448 2.08 11.908c0 1.748.458 3.45 1.321 4.956L2 22l5.255-1.377a9.916 9.916 0 0 0 4.737 1.206h.005c5.46 0 9.908-4.448 9.913-9.913A9.872 9.872 0 0 0 19 4.908h.001ZM11.992 20.15A8.216 8.216 0 0 1 7.797 19l-.3-.18-3.117.818.833-3.041-.196-.314a8.2 8.2 0 0 1-1.258-4.381c0-4.533 3.696-8.23 8.239-8.23a8.2 8.2 0 0 1 5.825 2.413 8.196 8.196 0 0 1 2.41 5.825c-.006 4.55-3.702 8.24-8.24 8.24Zm4.52-6.167c-.247-.124-1.463-.723-1.692-.808-.228-.08-.394-.123-.556.124-.166.246-.641.808-.784.969-.143.166-.29.185-.537.062-.247-.125-1.045-.385-1.99-1.23-.738-.657-1.232-1.47-1.38-1.716-.142-.247-.013-.38.11-.504.11-.11.247-.29.37-.432.126-.143.167-.248.248-.413.082-.167.043-.31-.018-.433-.063-.124-.557-1.345-.765-1.838-.2-.486-.404-.419-.557-.425-.142-.009-.309-.009-.475-.009a.911.911 0 0 0-.661.31c-.228.247-.864.845-.864 2.067 0 1.22.888 2.395 1.013 2.56.122.167 1.742 2.666 4.229 3.74.587.257 1.05.408 1.41.523.595.19 1.13.162 1.558.1.475-.072 1.464-.6 1.673-1.178.205-.58.205-1.075.142-1.18-.061-.104-.227-.165-.475-.29Z">
                                                                </path>
                                                            </svg>
                                                        </a>
    
                                                    </button>
                                                    <button class="messenger-button button"
                                                        style="transition-delay: 0.3s, 0s, 0.3s; transition-property: translate, background, box-shadow;">
                                                        <a href="https://telegram.me/share/url?url={{ $shareUrl }}">
                                                            <svg viewBox="0 0 24 24" width="24" height="24"
                                                                stroke="currentColor" stroke-width="2" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="css-i6dzq1">
                                                                <line x1="22" y1="2" x2="11"
                                                                    y2="13"></line>
                                                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                                            </svg></a>
                                                    </button>
                                                </div>
                                                <div class="button-effect toggle-favorite"
                                                    data-housing-id={{ $housing->id }}>
                                                    <i class="fa fa-heart-o"></i>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-boxed-body">
                                        <form id="rezervasyonForm">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6 col-md-12 col-6 book">
                                                    <input type="date" id="date-checkin" placeholder="Giriş Tarihi"
                                                        name="check_in_date" class="date-field form-control">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-6 book2">
                                                    <input type="date" id="date-checkout" placeholder="Çıkış Tarihi"
                                                        name="check_out_date" class="date-field form-control">
                                                </div>
                                            </div>
                                            <div class="row mrg-top-15 mb-3">
                                                <div class="col-lg-6 col-md-12 mt-2">
                                                    <label>Kişi Sayısı</label>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button"
                                                                class="btn counter-btn theme-cl btn-number"
                                                                disabled="disabled" data-type="minus"
                                                                data-field="quant[1]">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </span>
                                                        <input type="text" name="person_count"
                                                            class="border-0 text-center form-control input-number"
                                                            data-min="0" data-max="10" value="0">
                                                        <span class="input-group-btn">
                                                            <button type="button"
                                                                class="btn counter-btn theme-cl btn-number"
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
                                                @if (!Auth::check()) onclick="redirectToPage()" @endif
                                                class="reservationBtn reservation btn-radius full-width mrg-top-10 text-white">Rezervasyon
                                                Yap</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mobileMove">
                                <div class="schedule widget-boxed mt-33 mt-0">


                                    <div class="row buttonDetail">
                                        <div class="col-md-2 col-2">
                                            <div class="button-effect toggle-favorite"
                                                data-housing-id={{ $housing->id }}>
                                                <i class="fa fa-heart-o"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-2">
                                            <div class="buttons">
                                                <button class="main-button">
                                                    <svg width="20" height="30" fill="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M15.75 5.125a3.125 3.125 0 1 1 .754 2.035l-8.397 3.9a3.124 3.124 0 0 1 0 1.88l8.397 3.9a3.125 3.125 0 1 1-.61 1.095l-8.397-3.9a3.125 3.125 0 1 1 0-4.07l8.397-3.9a3.125 3.125 0 0 1-.144-.94Z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <button class="twitter-button button"
                                                    style="transition-delay: 0.1s, 0s, 0.1s; transition-property: translate, background, box-shadow;">

                                                    <a
                                                    href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}">
                                                    <svg viewBox="0 0 24 24" width="24" height="24"
                                                        stroke="currentColor" stroke-width="2" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="css-i6dzq1">
                                                        <path
                                                            d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z">
                                                        </path>
                                                    </svg></a>
                                                </button>

                                                <button class="reddit-button button"
                                                    style="transition-delay: 0.2s, 0s, 0.2s; transition-property: translate, background, box-shadow;">
                                                    <a href="whatsapp://send?text={{ $shareUrl }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            fill="currentColor" height="30" width="30">
                                                            <path
                                                                d="M19.001 4.908A9.817 9.817 0 0 0 11.992 2C6.534 2 2.085 6.448 2.08 11.908c0 1.748.458 3.45 1.321 4.956L2 22l5.255-1.377a9.916 9.916 0 0 0 4.737 1.206h.005c5.46 0 9.908-4.448 9.913-9.913A9.872 9.872 0 0 0 19 4.908h.001ZM11.992 20.15A8.216 8.216 0 0 1 7.797 19l-.3-.18-3.117.818.833-3.041-.196-.314a8.2 8.2 0 0 1-1.258-4.381c0-4.533 3.696-8.23 8.239-8.23a8.2 8.2 0 0 1 5.825 2.413 8.196 8.196 0 0 1 2.41 5.825c-.006 4.55-3.702 8.24-8.24 8.24Zm4.52-6.167c-.247-.124-1.463-.723-1.692-.808-.228-.08-.394-.123-.556.124-.166.246-.641.808-.784.969-.143.166-.29.185-.537.062-.247-.125-1.045-.385-1.99-1.23-.738-.657-1.232-1.47-1.38-1.716-.142-.247-.013-.38.11-.504.11-.11.247-.29.37-.432.126-.143.167-.248.248-.413.082-.167.043-.31-.018-.433-.063-.124-.557-1.345-.765-1.838-.2-.486-.404-.419-.557-.425-.142-.009-.309-.009-.475-.009a.911.911 0 0 0-.661.31c-.228.247-.864.845-.864 2.067 0 1.22.888 2.395 1.013 2.56.122.167 1.742 2.666 4.229 3.74.587.257 1.05.408 1.41.523.595.19 1.13.162 1.558.1.475-.072 1.464-.6 1.673-1.178.205-.58.205-1.075.142-1.18-.061-.104-.227-.165-.475-.29Z">
                                                            </path>
                                                        </svg>
                                                    </a>

                                                </button>
                                                <button class="messenger-button button"
                                                    style="transition-delay: 0.3s, 0s, 0.3s; transition-property: translate, background, box-shadow;">
                                                    <a href="https://telegram.me/share/url?url={{ $shareUrl }}">
                                                        <svg viewBox="0 0 24 24" width="24" height="24"
                                                            stroke="currentColor" stroke-width="2" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="css-i6dzq1">
                                                            <line x1="22" y1="2" x2="11"
                                                                y2="13"></line>
                                                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                                        </svg></a>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-8">
                                            @if (isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                <button class="btn second-btn CartBtn" disabled
                                                    style="background: red !important;width:100%;color:White;height:100% !important">

                                                    <span class="text">Satıldı</span>
                                                </button>
                                            @else
                                                @if ($sold && isset($sold[0]) && $sold[0]->status != '2')
                                                    @php
                                                        $buttonStyle = '';
                                                        $buttonText = '';
                                                        if ($sold[0]->status == '0') {
                                                            $buttonStyle = 'background: orange !important; width: 100%; color: white;height:100% !important';
                                                            $buttonText = 'Onay Bekleniyor';
                                                        } else {
                                                            $buttonStyle = 'background: red !important; width: 100%; color: white;height:100% !important';
                                                            $buttonText = 'Satıldı';
                                                        }
                                                    @endphp

                                                    <button class="btn second-btn soldBtn" disabled
                                                        style="{{ $buttonStyle }}">
                                                        <span class="text">{{ $buttonText }}</span>
                                                    </button>
                                                @else
                                                    <button class="CartBtn" data-type='housing'
                                                        data-id='{{ $housing->id }}' style="height:100% !important">
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
                            </div>
                        @endif

                        <div class="widget-boxed removeClass mt-5">
                            <div class="widget-boxed-header">
                                <h4>Mağaza Bilgileri</h4>
                            </div>
                            <div class="widget-boxed-body">
                                <div class="sidebar-widget author-widget2">

                                    <div class="author-box clearfix d-flex align-items-center">
                                        <img src="{{ URL::to('/') . '/storage/profile_images/' . $housing->user->profile_image }}"
                                            alt="author-image" class="author__img">
                                        <div>
                                            <a
                                                href="{{ route('instituional.dashboard', Str::slug($housing->user->name)) }}">
                                                <h4 class="author__title">{!! $housing->user->name !!}</h4>
                                            </a>

                                            <p class="author__meta">
                                                {{ $housing->user->corporate_type == 'Emlakçı' ? 'Gayrimenkul Ofisi' : $housing->user->corporate_type }}
                                            </p>
                                        </div>
                                    </div>
                                    <ul class="author__contact">
                                        <li><span class="la la-map-marker"><i
                                                    class="fa fa-map-marker"></i></span>{!! $housing->city->title !!}
                                            {{ '/' }} {!! $housing->county->title !!}</li>
                                        @if ($housing->user->phone)
                                            <li><span class="la la-phone"><i class="fa fa-phone"
                                                        aria-hidden="true"></i></span><a
                                                    style="text-decoration: none;color:inherit"
                                                    href="tel:{!! $housing->user->phone !!}">{!! $housing->user->phone !!}</a>
                                            </li>
                                        @endif
                                        @if ($housing->step1_slug)
                                            <li>
                                                <span class="la la-dot"><i class="fa fa-check-square"
                                                        aria-hidden="true"></i></span>
                                                @if ($housing->step2_slug)
                                                    @if ($housing->step2_slug == 'kiralik')
                                                        Kiralık
                                                    @elseif ($housing->step2_slug == 'satilik')
                                                        Satılık
                                                    @else
                                                        Günlük Kiralık
                                                    @endif
                                                @endif
                                                {{ $parent->title }}
                                            </li>
                                        @endif


                                        <li><span class="la la-envelope-o"><i class="fa fa-envelope"
                                                    aria-hidden="true"></i></span><a
                                                style="text-decoration: none;color:inherit"
                                                href="mailto:{!! $housing->user->email !!}">{!! $housing->user->email !!}</a></li>
                                    </ul>
                                </div>
                                <hr>


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
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&callback=initMap"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZwT" crossorigin="anonymous">

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <script>
        if (window.innerWidth <= 768) {
            var mobileMove = $(".mobileMove").html();
            console.log(mobileMove);
            $("#listingDetailsSlider").after(mobileMove);
            $(".mobileMove").remove();
            $(".removeClass").removeClass("mt-5");
        }

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

        function initMap() {
            // İlk harita görüntüsü
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: {{ $housing->latitude }},
                    lng: {{ $housing->longitude }}
                },
                zoom: 8
            });

            // Harita üzerinde bir konum gösterme
            var marker = new google.maps.Marker({
                position: {
                    lat: {{ $housing->latitude }},
                    lng: {{ $housing->longitude }}
                },
                map: map,
                title: 'Default Location'
            });
        }

        function showLocation() {
            var location = document.getElementById('locationInput').value;

            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: {{ $housing->longitude }},
                    lng: {{ $housing->latitude }}
                },
                zoom: 12
            });

            var marker = new google.maps.Marker({
                position: {
                    lat: {{ $housing->longitude }},
                    lng: {{ $housing->latitude }}
                },
                map: map,
                title: location
            });
        }
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
                    if ($(".showPrice").hasClass("d-none")) {
                        $(".reservationBtn").removeAttr("data-toggle data-target");
                        Swal.fire({
                            icon: 'warning',
                            title: 'Uyarı!',
                            text: 'Lütfen geçerli bir tarih seçiniz!',
                        });
                    } else {
                        var uniqueCode = generateUniqueCode();
                        $('#uniqueCode').text(uniqueCode);
                        $('#uniqueCodeRetry').text(uniqueCode);
                        $("#orderKey").val(uniqueCode);
                        $(".reservationBtn").attr({
                            "data-toggle": "modal",
                            "data-target": "#paymentModal"
                        })
                    }

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
                            $(".showPrice").addClass("d-none");
                            document.getElementById('date-checkin').value = '';
                            document.getElementById('date-checkout').value = '';
                            $('.reservationBtn').prop('disabled', true);

                        } else {
                            $(".showPrice").removeClass("d-none");
                            $("#totalPrice").html(price * diffDays + " ₺");
                            $('.reservationBtn').prop('disabled', false);

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

                function onSelectDates(selectedDates, dateStr, instance) {
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
                                if (targetDate >= new Date(reservation.from) && targetDate == new Date(
                                        reservation
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
                    var checkinDate = selectedDates[0];
                    var checkoutDate = selectedDates[selectedDates.length - 1];

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
                                $(".showPrice").addClass("d-none");
                                document.getElementById('date-checkin').value = '';
                                document.getElementById('date-checkout').value = '';


                            } else {
                                $(".showPrice").removeClass("d-none");
                                $("#totalPrice").html(price * diffDays + " ₺");

                            }
                        }
                    }
                }

                function formatDate(date) {
                    var day = date.getDate();
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();

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
                    minDate: today,
                    onReady: applyClassesToDates,
                    onChange: onSelectDates,
                    onMonthChange: applyClassesToDates
                });
            }

            document.addEventListener('DOMContentLoaded', updateCalendarView);
            window.addEventListener('resize', updateCalendarView);


            var dateCheckin = flatpickr("#date-checkin", {
                dateFormat: 'Y-m-d',
                locale: 'tr',
                minDate: today,
                onReady: applyClassesToDates,
                onChange: applyClassesToDates,
                onMonthChange: applyClassesToDates
            });

            var dateCheckout = flatpickr("#date-checkout", {
                dateFormat: 'Y-m-d',
                locale: 'tr',
                minDate: today,
                onReady: applyClassesToDates,
                onChange: applyClassesToDates,
                onMonthChange: applyClassesToDates
            });
        </script>
    @endif
@endsection

@section('styles')
    <style>
   
        .trStyle,
        .trStyle tr {
            display: flex;
            flex-wrap: wrap;
        }

        .trStyle tr {
            width: 50%;
        }

        .trStyle tr td {
            width: 100%;
            font-size: 13px;
        }

        @media (max-width:768px) {
            .trStyle tr {
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

        .altSlider {
            width: 100%;
            height: 85px !important;
            padding: 0 !important;
            margin: 0 !important;
        }
    </style>
@endsection
