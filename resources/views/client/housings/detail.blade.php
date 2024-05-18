@extends('client.layouts.master')

@php
    // Retrieve the most recent record where JSON_EXTRACT(cart, "$.item.id") matches $housing->id
    $sold = DB::select(
        'SELECT * FROM cart_orders 
        WHERE JSON_EXTRACT(cart, "$.type") = "housing" 
        AND JSON_EXTRACT(cart, "$.item.id") = ?
        ORDER BY created_at DESC
        LIMIT 1',
        [$housing->id],
    );
@endphp

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
        <div class="loading-full d-none">
            <div class="back-opa">

            </div>
            <div class="content-loading">
                <i class="fa fa-spinner"></i>
            </div>
        </div>

        <x-store-card :store="$housing->user" :housing="$housing" />
        {{-- {{dd($housing)}} --}}
        <div class="container">
            <div class="row mb-3" style="align-items: center">
                <div class="col-md-8">
                    <div class="headings-2 pt-0">
                        <div class="pro-wrapper" style="width: 100%; justify-content: space-between;">
                            @php
                                $status = optional($sold)->status;
                            @endphp
                            <div class="detail-wrapper-body">
                                <div class="listing-title-bar pb-3">
                                    {{-- <strong style="color: black;font-size: 12px !important;">İlan No: <span
                                            style="color:#274abb;font-size: 12px !important;">{{ $housing->id + 2000000 }}</span>
                                    </strong> --}}
                                    <h3>
                                        @if ($status && $status != '0' && $status != '1')
                                            @include('client.layouts.partials.housing_title', [
                                                'title' => $housing->title,
                                            ])
                                        @else
                                            @include('client.layouts.partials.housing_title', [
                                                'title' => $housing->title,
                                            ])
                                        @endif

                                        @if ($housing->step1_slug)

                                            <span class="mrg-l-5 category-tag">
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
                                            </span>

                                        @endif
                                    </h3>
                                    <div class="mt-0">
                                        <a href="#listing-location" class="listing-address">
                                            <i class="fa fa-map-marker pr-2 ti-location-pin mrg-r-5"></i>
                                            {!! optional($housing->city)->title .
                                                ' / ' .
                                                optional($housing->county)->title .
                                                ' / ' .
                                                optional($housing->neighborhood)->mahalle_title ??
                                                '' !!}
                                        </a>
                                    </div>
                                </div>
                                <div class="mobile-action"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="headings-2 pt-0 move-gain">
                        <div class="gainStyle" style="width: 100%; justify-content: center;align-items:center;display:flex">

                            {{-- @if (isset(json_decode($housing->housing_type_data)->projected_earnings))
                                <svg viewBox="0 0 24 24" width="30" height="21" stroke="green" stroke-width="2"
                                    fill="green" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                    <polyline points="17 6 23 7 23 12"></polyline>
                                </svg>
                                <strong style="font-size:13px;"> Öngörülen Yıllık Kazanç: </strong>
                                <span style="font-size:13px;margin-left:4px">
                                    %{{ json_decode($housing->housing_type_data)->projected_earnings }}</span>
                            @endif --}}

                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-8 blog-pots">
                    <div class="row">
                        <div class="col-md-12">

                            <div id="listingDetailsSlider" class="carousel listing-details-sliders slide mb-30">
                                <div class="button-effect-div favorite-move">
                                    <div class="button-effect toggle-favorite" data-housing-id={{ $housing->id }}>
                                        <i class="fa fa-heart-o"></i>
                                    </div>
                                </div>
                                <div class="carousel-inner">

                                    {{-- Kapak Görseli --}}
                                    <div class="item carousel-item active" data-slide-number="0">
                                        <a href="{{ asset('housing_images/' . json_decode($housing->housing_type_data)->image) }}"
                                            data-lightbox="project-images">
                                            <img src="{{ asset('housing_images/' . json_decode($housing->housing_type_data)->image) }}"
                                                class="img-fluid" alt="slider-listing">
                                        </a>
                                    </div>

                                    {{-- Diğer Görseller --}}
                                    @foreach (json_decode(getImages($housing, 'images')) as $key => $image)
                                        <div class="item carousel-item" data-slide-number="{{ $key + 1 }}">
                                            <a href="{{ asset('housing_images/' . $image) }}"
                                                data-lightbox="project-images">
                                                <img src="{{ asset('housing_images/' . $image) }}" class="img-fluid"
                                                    alt="slider-listing">
                                            </a>
                                        </div>
                                    @endforeach

                                    {{-- Carousel Kontrolleri --}}
                                    {{-- <a class="carousel-control left" href="#listingDetailsSlider" data-slide="prev"><i
                                            class="fa fa-angle-left"></i></a>
                                    <a class="carousel-control right" href="#listingDetailsSlider" data-slide="next"><i
                                            class="fa fa-angle-right"></i></a> --}}
                                </div>

                                {{-- Küçük Resim Navigasyonu --}}
                                <div class="listingDetailsSliderNav mt-3">
                                    {{-- Kapak Görseli --}}
                                    <div class="item active" style="margin: 10px; cursor: pointer">
                                        <a id="carousel-selector-0" data-slide-to="0" data-target="#listingDetailsSlider">
                                            <img src="{{ asset('housing_images/' . json_decode($housing->housing_type_data)->image) }}"
                                                class="img-fluid carousel-indicator-image" alt="listing-small">
                                        </a>
                                    </div>
                                    {{-- Diğer Görseller --}}
                                    @foreach (json_decode(getImages($housing, 'images')) as $imageKey => $image)
                                        <div class="item" style="margin: 10px; cursor: pointer">
                                            <a id="carousel-selector-{{ $imageKey + 1 }}"
                                                data-slide-to="{{ $imageKey + 1 }}" data-target="#listingDetailsSlider">
                                                <img src="{{ asset('housing_images/' . $image) }}"
                                                    class="img-fluid carousel-indicator-image" alt="listing-small">
                                            </a>
                                        </div>
                                    @endforeach

                                </div>
                                <nav aria-label="Page navigation example" style="margin-top: 7px">
                                    <ul class="pagination">
                                        <li class="page-item page-item-left"><a class="page-link" href="#"><i
                                                    class="fas fa-angle-left"></i></a></li>
                                        <li class="page-item page-item-middle"><a class="page-link" href="#"></a>
                                        </li>
                                        <li class="page-item page-item-right"><a class="page-link" href="#"><i
                                                    class="fas fa-angle-right"></i></a></li>
                                    </ul>
                                </nav>
                            </div>

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                @if ($housing->step2_slug == 'gunluk-kiralik')
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="rez-tab" data-bs-toggle="tab"
                                            data-bs-target="#rez" type="button" role="tab" aria-controls="rez"
                                            aria-selected="true"> Takvim</button>
                                    </li>
                                @endif
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link @if ($housing->step2_slug != 'gunluk-kiralik') active @endif" id="home-tab"
                                        data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab"
                                        aria-controls="home" aria-selected="true">Açıklama</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                                        aria-selected="false">Özellikler</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#map"
                                        type="button" role="tab" aria-controls="contact"
                                        aria-selected="false">Harita</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                        data-bs-target="#contact" type="button" role="tab" aria-controls="contact"
                                        aria-selected="false">Yorumlar</button>
                                </li>


                            </ul>
                            
                            <div class="tab-content" id="myTabContent">
                                @if ($housing->step2_slug == 'gunluk-kiralik')
                                    <div class="tab-pane fade show active blog-info details mb-30" id="rez"
                                        role="tabpanel" aria-labelledby="rez-tab">
                                        <div class="row">
                                            <div class="col-md-12 col-12 mb-5">
                                                <div id="reservation-calendar"></div>
                                            </div>
                                        </div>

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
                                            <table class="table ">
                                                <tbody class="trStyle">
                                                    <tr>
                                                        <td>
                                                            <span class="mr-1">İlan No:</span>
                                                            <span class="det" style="color: #274abb;">
                                                                {{ $housing->id + 2000000 }}
                                                            </span>
                                                        </td>
                                                    </tr>

                                                    @foreach ($labels as $label => $val)
                                                        @if (
                                                            $label != 'Kapak Resmi' &&
                                                                $label != 'Taksitli Satış' &&
                                                                $label != 'Fiyat' &&
                                                                $label != 'Seçenekler' &&
                                                                $label != 'Acil Satılık' &&
                                                                $label != 'İndirim Oranı %' &&
                                                                $label != 'Yıldız Sayısı' &&
                                                                $label != 'Yapının Durumu' &&
                                                                $label != 'Peşinat' &&
                                                                $label != 'İlan Başlığı' &&
                                                                $label != 'Günlük Fiyat' &&
                                                                $label != 'Peşin Fiyat' &&
                                                                $label != 'Taksitli Toplam Fiyat' &&
                                                                isset($val[0]) &&
                                                                $val[0] != 0 &&
                                                                $val[0] != null &&
                                                                !isset($val[1]))
                                                            <tr>
                                                                <td>
                                                                    <span class="mr-1">{{ $label }}:</span>
                                                                    @if ($label == 'm² (Net)<br>')
                                                                        <span class="det">{{ $val[0] }}
                                                                            m2</span>
                                                                    @elseif ($label == 'Özellikler')
                                                                        <ul>
                                                                            @foreach ($val as $ozellik)
                                                                                <li>{{ $ozellik }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @else
                                                                        <span class="det">
                                                                            {{ isset($val[0]) && $val[0] ? ($val[0] == 'yes' ? 'Evet' : ($val[0] == 'no' ? 'Hayır' : $val[0])) : '' }}
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach

                                                </tbody>
                                            </table>

                                            @foreach ($labels as $label => $val)
                                                @if (is_array($val))
                                                    @if (count($val) > 1)
                                                        @if ($label != 'Galeri')
                                                            <h5 class="mt-5">{{ $label }}</h5>
                                                            <ul class="homes-list clearfix checkSquareIcon">
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
                                <div class="tab-pane fade  blog-info details mb-30" id="contact" role="tabpanel"
                                    aria-labelledby="contact-tab">
                                    <h5 class="mt-4">Yorumlar</h5>
                                    @if (count($housingComments))
                                        <div class="flex flex-col gap-6">
                                            @foreach ($housingComments as $comment)
                                                <div class="bg-white border rounded-md pb-3 mb-3"
                                                    style="border-bottom: 1px solid #E6E6E6 !important; ">
                                                    <div class="head d-flex w-full">
                                                        <div>
                                                            <div>{{ $comment->user->name }}</div>
                                                            <i
                                                                class="small">{{ \Carbon\Carbon::parse($comment->created_at)->locale('tr')->isoFormat('DD MMMM dddd') }}</i>
                                                        </div>
                                                        {{-- {{dd($comment)}} --}}
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

                                    <form id="commentForm" enctype="multipart/form-data" class="mt-5">
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
                                                <input type="file" style="display: none;" class="fileinput"
                                                    name="images[]" multiple accept="image/*" />
                                                <button type="button" class="btn btn-primary q-button"
                                                    id="selectImageButton">Resimleri Seç</button>
                                            </div>
                                        </div>
                                        <textarea name="comment" rows="10" class="form-control mt-4" placeholder="Yorum girin..." required></textarea>
                                        <button type="button" class="ud-btn btn-white2 mt-3"
                                            onclick="submitForm()">Yorumu
                                            Gönder<i class="fal fa-arrow-right-long"></i></button>

                                    </form>

                                </div>
                                <div class="tab-pane fade  blog-info details mb-30" id="map" role="tabpanel"
                                    aria-labelledby="contact-tab">
                                    <div id="mapContainer" style="height: 100%"></div>
                                </div>
                            </div>


                        </div>
                    </div>


                </div>
                <aside class="col-md-4  car">
                    <div class="single widget">
                        @if ($housing->step2_slug == 'gunluk-kiralik')
                            <div class="mobileHour mobileHourDiv">
                                <div class="homes-content details-2">
                                    <ul class="homes-list reservation-list clearfix">
                                        <li>
                                            <span>Giriş: {{ getData($housing, 'start_time') }}</span>
                                        </li>
                                        <li>
                                            <span>Çıkış: {{ getData($housing, 'end_time') }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @else
                            {{-- <div class="schedule widget-boxed move-mobile-gain mb-30 mobile-show"
                        style="background-color: green "></div> --}}
                            <div class="mobileHour mobileHourDiv">

                                <div class="schedule widget-boxed mt-33 mt-0">


                                    <div class="row buttonDetail" style="align-items: center">
                                        <div class="col-md-5 col-5 mobile-action-move">
                                            @if ($sold)
                                                @if ($sold[0]->status != '0' && $sold[0]->status != '1')
                                                    <div class="single detail-wrapper mr-2">
                                                        <div class="detail-wrapper-body">
                                                            <div class="listing-title-bar mobileMovePrice">
                                                                <h4>
                                                                    @if ($discountAmount)
                                                                        <svg viewBox="0 0 24 24" width="24"
                                                                            height="24" stroke="currentColor"
                                                                            stroke-width="2" fill="none"
                                                                            stroke-linecap="round" stroke-linejoin="round"
                                                                            class="css-i6dzq1">
                                                                            <polyline points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                            </polyline>
                                                                            <polyline points="17 18 23 18 23 12">
                                                                            </polyline>
                                                                        </svg>
                                                                    @endif
                                                                    @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                                        @php
                                                                            $price =
                                                                                $housing->step2_slug == 'gunluk-kiralik'
                                                                                    ? json_decode(
                                                                                        $housing->housing_type_data,
                                                                                    )->daily_rent[0]
                                                                                    : json_decode(
                                                                                        $housing->housing_type_data,
                                                                                    )->price[0];
                                                                            $discountedPrice = $price - $discountAmount;
                                                                        @endphp
                                                                        @if ($discountAmount)
                                                                            <svg viewBox="0 0 24 24" width="18"
                                                                                height="18" stroke="#EA2B2E"
                                                                                stroke-width="2" fill="#EA2B2E"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="css-i6dzq1">
                                                                                <polyline
                                                                                    points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                                </polyline>
                                                                                <polyline points="17 18 23 18 23 12">
                                                                                </polyline>
                                                                            </svg>
                                                                            <del style="font-size:11px; color:#EA2B2E">
                                                                                {{ number_format($price, 0, ',', '.') }}
                                                                            </del>
                                                                        @endif
                                                                        {{ number_format($discountedPrice, 0, ',', '.') }}
                                                                        ₺
                                                                        @if ($housing->step2_slug == 'gunluk-kiralik')
                                                                            <span style="font-size:12px; color:#EA2B2E">(1
                                                                                Gece)</span>
                                                                        @endif
                                                                    @endif
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="single detail-wrapper mr-2">
                                                    <div class="detail-wrapper-body">
                                                        <div class="listing-title-bar mobileMovePrice">
                                                            <h4>
                                                                <div style="text-align: center">
                                                                    @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                                        @php
                                                                            $price =
                                                                                $housing->step2_slug == 'gunluk-kiralik'
                                                                                    ? json_decode(
                                                                                        $housing->housing_type_data,
                                                                                    )->daily_rent[0]
                                                                                    : json_decode(
                                                                                        $housing->housing_type_data,
                                                                                    )->price[0];
                                                                            $discountedPrice = $price - $discountAmount;
                                                                        @endphp
                                                                        @if ($discountAmount)
                                                                            <svg viewBox="0 0 24 24" width="18"
                                                                                height="18" stroke="#EA2B2E"
                                                                                stroke-width="2" fill="#EA2B2E"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="css-i6dzq1">
                                                                                <polyline
                                                                                    points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                                </polyline>
                                                                                <polyline points="17 18 23 18 23 12">
                                                                                </polyline>
                                                                            </svg>
                                                                            <del style="font-size:11px; color:#EA2B2E">
                                                                                {{ number_format($price, 0, ',', '.') }}
                                                                            </del>
                                                                        @endif
                                                                        {{ number_format($discountedPrice, 0, ',', '.') }}
                                                                        ₺
                                                                        @if ($housing->step2_slug == 'gunluk-kiralik')
                                                                            <span style="font-size:11px; color:#EA2B2E">1
                                                                                Gece</span>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif


                                        </div>
                                        <div
                                            class="@if (($sold && isset($sold[0]) && $sold[0]->status == '2') || !$sold) col-md-7 col-7
                                            @else
                                            col-md-12 col-12 @endif">
                                            @if (isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                <button class="btn second-btn "
                                                    style="background: #EA2B2E !important;width:100%;color:White">

                                                    <span class="text">Satışa Kapatıldı</span>
                                                </button>
                                            @else
                                                @if ($sold && isset($sold[0]) && $sold[0]->status != '2')
                                                    @php
                                                        $buttonStyle = '';
                                                        $buttonText = '';
                                                        if ($sold[0]->status == '0') {
                                                            $buttonStyle =
                                                                'background: orange !important; width: 100%; color: white;';
                                                            $buttonText = 'Rezerve Edildi';
                                                        } else {
                                                            $buttonStyle =
                                                                'background: #EA2B2E !important; width: 100%; color: white;';
                                                            $buttonText = 'Satıldı';
                                                        }
                                                    @endphp

                                                    <button class="btn second-btn soldBtn" style="{{ $buttonStyle }}">
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
                           
                            </div>

                        @endif

                        @if (isset(json_decode($housing->housing_type_data)->open_sharing1[0]))
                        <div class="add-to-collections-wrapper addCollection" data-type='housing'
                            data-id="{{ $housing->id }}">
                            <div class="add-to-collection-button-wrapper">
                                <div class="add-to-collection-button">

                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="e54242"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect width="32" height="32" fill="#e54242" />
                                        <g id="Add Collections-00 (Default)" clip-path="url(#clip0_1750_971)">
                                            <rect width="1440" height="1577"
                                                transform="translate(-1100 -1183)" fill="white" />
                                            <g id="Group 6131">
                                                <g id="Frame 21409">
                                                    <g id="Group 6385">
                                                        <rect id="Rectangle 4168" x="-8" y="-8" width="228"
                                                            height="48" rx="8" fill="#ea2a28" />
                                                        <g id="Group 2664">
                                                            <rect id="Rectangle 316" width="32"
                                                                height="32" rx="4"
                                                                fill="#ea2a28" />
                                                            <g id="Group 72">
                                                                <path id="Rectangle 12"
                                                                    d="M16.7099 17.2557L16 16.5401L15.2901 17.2557L12 20.5721L12 12C12 10.8954 12.8954 10 14 10H18C19.1046 10 20 10.8954 20 12V20.5721L16.7099 17.2557Z"
                                                                    fill="white" stroke="white"
                                                                    stroke-width="2" />
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1750_971">
                                                <rect width="1440" height="1577" fill="white"
                                                    transform="translate(-1100 -1183)" />
                                            </clipPath>
                                        </defs>
                                    </svg><span class="add-to-collection-button-text">
                                        @if (Auth::check() && Auth::user()->corporate_type == 'Emlak Ofisi')
                                            Portföyüme Ekle
                                        @else
                                            Koleksiyona Ekle
                                        @endif
                                    </span>
                                </div>
                                <i class="fa fa-caret-right"></i>
                            </div>
                        </div>
                    @endif

                    @if (isset(json_decode($housing->housing_type_data)->swap[0]))
                        <div class="add-to-swap-wrapper" data-bs-toggle="modal" data-bs-target="#takasModal">
                            <div class="add-to-collection-button-wrapper">
                                <div class="add-to-collection-button">

                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect width="32" height="32" fill="#F0F0F0" />
                                        <g id="Add Collections-00 (Default)" clip-path="url(#clip0_1750_971)">
                                            <rect width="1440" height="1577"
                                                transform="translate(-1100 -1183)" fill="white" />
                                            <g id="Group 6131">
                                                <g id="Frame 21409">
                                                    <g id="Group 6385">
                                                        <rect id="Rectangle 4168" x="-8" y="-8" width="228"
                                                            height="48" rx="8" fill="#FEF4EB" />
                                                        <g id="Group 2664">
                                                            <rect id="Rectangle 316" width="32"
                                                                height="32" rx="4"
                                                                fill="#F27A1A" />
                                                            <g id="Group 72">
                                                                <path d="M16 11V21M11 16H21" stroke="white"
                                                                    stroke-width="2" stroke-linecap="round" />
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1750_971">
                                                <rect width="1440" height="1577" fill="white"
                                                    transform="translate(-1100 -1183)" />
                                            </clipPath>
                                        </defs>
                                    </svg>

                                    <span class="add-to-collection-button-text">Takas Başvurusu Yap</span>
                                </div>
                                <i class="fa fa-caret-right"></i>
                            </div>
                        </div>
                    @endif
                    <div class="modal fade" id="takasModal" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Takas Formu</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="{{ route('form.kaydet') }}" method="POST"
                                        enctype="multipart/form-data" id="takasFormu">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <label class="form-label" for="ad">Ad:</label>
                                                <input class="formInput" type="text" id="ad"
                                                    name="ad" required>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <label class="form-label" for="soyad">Soyadınız:</label>
                                                <input class="formInput" type="text" id="soyad"
                                                    name="soyad" required>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <label class="form-label" for="telefon">Telefon
                                                    Numaranız:</label>
                                                <input class="formInput" type="number" id="telefon"
                                                    name="telefon" required maxlength="10">
                                                <span id="error_message" class="error-message"></span>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <label class="form-label" for="email">E-mail:</label>
                                                <input class="formInput" type="email" id="email"
                                                    name="email" required>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <label class="form-label" for="sehir">Şehir:</label>
                                                <select class="formInput" id="sehir" name="sehir"
                                                    required>
                                                    <option value="">Şehir Seçiniz</option>
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}">
                                                            {{ $city->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <label class="form-label" for="ilce">İlçe:</label>
                                                <select class="formInput" id="ilce" name="ilce"
                                                    disabled required>
                                                    <option value="">İlçe Seçiniz</option>
                                                </select>
                                            </div>

                                            <div class="col-md-12 col-12">
                                                <label class="form-label" for="takas_tercihi">Takas
                                                    Tercihiniz:</label>
                                                <select class="formInput" id="takas_tercihi"
                                                    name="takas_tercihi" required>
                                                    <option value="">Seçiniz</option>
                                                    <option value="emlak">Emlak</option>
                                                    <option value="araç">Araç</option>
                                                    <option value="barter">Barter</option>
                                                    <option value="diğer">Diğer</option>
                                                </select>
                                            </div>


                                            <div id="digeryse" style="display: none;"
                                                class="col-md-12 col-12">
                                                <label class="form-label" for="diger_detay">Takas ile ilgili
                                                    ürün/hizmet detayı:</label>
                                                <textarea class="formInput" id="diger_detay" name="diger_detay"></textarea>
                                            </div>

                                            <div id="barteryse" style="display: none;"
                                                class="col-md-12 col-12">
                                                <label class="form-label" for="barter_detay">Lütfen barter
                                                    durumunuz ile ilgili detaylı bilgileri
                                                    giriniz:</label>
                                                <textarea class="formInput" id="barter_detay" name="barter_detay"></textarea>
                                            </div>

                                            <div id="emlakyse" style="display: none;"
                                                class="col-md-12 col-12">
                                                <label class="form-label" for="emlak_tipi">Emlak Tipi:</label>
                                                <select class="formInput" id="emlak_tipi" name="emlak_tipi">
                                                    <option value="">Seçiniz</option>
                                                    <option value="konut">Konut</option>
                                                    <option value="arsa">Arsa</option>
                                                    <option value="işyeri">İşyeri</option>
                                                </select>
                                            </div>

                                            <div id="konutyse" style="display: none;"
                                                class="col-md-12 col-12">
                                                <label class="form-label" for="konut_tipi">Konut Tipi:</label>
                                                <select class="formInput" id="konut_tipi" name="konut_tipi">
                                                    <option value="">Seçiniz</option>
                                                    <option value="daire">Daire</option>
                                                    <option value="villa">Villa</option>
                                                    <option value="residance">Residance</option>
                                                    <option value="prefabrik_ev">Prefabrik Ev</option>
                                                    <option value="çiftlik_evi">Çiftlik Evi</option>
                                                </select>

                                                <label for="oda_sayisi">Oda Sayısı</label>
                                                <select class="form-select formInput"
                                                    aria-label="Default select example" id="oda_sayisi"
                                                    name="oda_sayisi">
                                                    <option selected>Seçiniz</option>
                                                    <option value="1+0">1+0</option>
                                                    <option value="1.5+1">1.5+1</option>
                                                    <option value="2+0">2+0</option>
                                                    <option value="2+1">2+1</option>
                                                    <option value="2.5+1">2.5+1</option>
                                                    <option value="3+0">3+0</option>
                                                    <option value="3+1">3+1</option>
                                                    <option value="3.5+1">3.5+1</option>
                                                    <option value="3+2">3+2</option>
                                                    <option value="3+3">3+3</option>
                                                    <option value="4+0">4+0</option>
                                                    <option value="4+1">4+1</option>
                                                    <option value="4.5+1">4.5+1</option>
                                                    <option value="4+2">4+2</option>
                                                    <option value="4+3">4+3</option>
                                                    <option value="4+4">4+4</option>
                                                    <option value="5+1">5+1</option>
                                                    <option value="5.5+1">5.5+1</option>
                                                    <option value="5+2">5+2</option>
                                                    <option value="5+3">5+3</option>
                                                    <option value="5+4">5+4</option>
                                                    <option value="6+1">6+1</option>
                                                    <option value="6+2">6+2</option>
                                                    <option value="6.5+1">6.5+1</option>
                                                    <option value="6+3">6+3</option>
                                                    <option value="6+4">6+4</option>
                                                    <option value="7+1">7+1</option>
                                                    <option value="7+2">7+2</option>
                                                    <option value="7+3">7+3</option>
                                                    <option value="8+1">8+1</option>
                                                    <option value="8+2">8+2</option>
                                                    <option value="8+3">8+3</option>
                                                    <option value="8+4">8+4</option>
                                                    <option value="9+1">9+1</option>
                                                    <option value="9+2">9+2</option>
                                                    <option value="9+3">9+3</option>
                                                    <option value="9+4">9+4</option>
                                                    <option value="9+5">9+5</option>
                                                    <option value="9+6">9+6</option>
                                                    <option value="10+1">10+1</option>
                                                    <option value="10+2">10+2</option>
                                                    <option value="11+1">11+1</option>
                                                    <option value="12 ve üzeri">12 ve üzeri</option>
                                                </select>

                                                <label class="form-label" for="konut_tipi">Konut Yaşı:</label>
                                                <select class="formInput" id="konut_yasi" name="konut_yasi">
                                                    <option value="">Seçiniz</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5-10">5-10</option>
                                                    <option value="11-15">11-15</option>
                                                    <option value="16-20">16-20</option>
                                                    <option value="20 ve Üzeri">20 ve Üzeri</option>
                                                </select>

                                                <input class="formInput" type="hidden" id="store_id"
                                                    name="store_id" value="{{ $housing->user->id }}">

                                                <label class="form-label" for="kullanim_durumu">Kullanım
                                                    Durumu:</label>
                                                <select class="formInput" id="kullanim_durumu"
                                                    name="kullanim_durumu">
                                                    <option value="">Seçiniz</option>
                                                    <option value="kiracılı">Kiracılı</option>
                                                    <option value="boş">Boş</option>
                                                    <option value="mülk_sahibi">Mülk Sahibi</option>
                                                </select>

                                                <label class="form-label"
                                                    for="konut_satis_rakami">Düşündüğünüz Satış Rakamı:</label>
                                                <input class="formInput" type="text"
                                                    id="konut_satis_rakami" name="konut_satis_rakami"
                                                    min="0">

                                                <label class="form-label" for="tapu_belgesi">Tapu Belgesi
                                                    Yükleyiniz:</label>
                                                <input class="formInput" type="file" id="tapu_belgesi"
                                                    name="tapu_belgesi" accept=".pdf,.doc,.docx">
                                            </div>

                                            <div id="arsayse" style="display: none;"
                                                class="col-md-12 col-12">

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="form-label" for="arsa_il">Arsa
                                                            İl:</label>
                                                        <select class="formInput" id="arsa_il"
                                                            name="arsa_il">
                                                            <option value="">Şehir Seçiniz</option>
                                                            @foreach ($cities as $city)
                                                                <option value="{{ $city->id }}">
                                                                    {{ $city->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label" for="arsa_ilce">Arsa
                                                            İlçe:</label>
                                                        <select class="formInput" id="arsa_ilce"
                                                            name="arsa_ilce" disabled>
                                                            <option value="">İlçe Seçiniz</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label" for="arsa_mahalle">Arsa
                                                            Mahalle:</label>
                                                        <select class="formInput" id="arsa_mahalle"
                                                            name="arsa_mahalle" disabled>
                                                            <option value="">Mahalle Seçiniz</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <label class="form-label" for="ada_parsel">Ada Parsel
                                                    Bilgisi:</label>
                                                <input class="formInput" type="text" id="ada_parsel"
                                                    name="ada_parsel">

                                                <label class="form-label" for="imar_durumu">Arsa İmar
                                                    Durumu:</label>
                                                <select class="formInput" id="imar_durumu"
                                                    name="imar_durumu">
                                                    <option value="">Seçiniz</option>
                                                    <option value="villa">Villa</option>
                                                    <option value="konut">Konut</option>
                                                    <option value="turizm">Turizm Amaçlı Kiralama</option>
                                                    <option value="sanayi">Sanayi</option>
                                                    <option value="ticari">Ticari</option>
                                                    <option value="bağ_bahçe">Bağ Bahçe</option>
                                                    <option value="tarla">Tarla</option>
                                                </select>

                                                <label class="form-label" for="satis_rakami">Düşündüğünüz
                                                    Satış Rakamı:</label>
                                                <input class="formInput" type="text" id="satis_rakami"
                                                    name="satis_rakami" min="0">
                                            </div>

                                            <div id="aracyse" style="display: none;"
                                                class="col-md-12 col-12">

                                                <label class="form-label" for="arac_model_yili">Araç Model
                                                    Yılı:</label>
                                                <select class="formInput" id="arac_model_yili"
                                                    name="arac_model_yili">
                                                    <option value="">Model Yılı Seçiniz</option>
                                                    @for ($year = date('Y'); $year >= 2004; $year--)
                                                        <option value="{{ $year }}">
                                                            {{ $year }}</option>
                                                    @endfor
                                                </select>


                                                <label class="form-label" for="arac_markasi">Araç
                                                    Markası:</label>
                                                <select class="formInput" name="arac_markasi"
                                                    id="arac_markasi">
                                                    <option value="">Seçiniz...</option>
                                                    <option value="Alfa Romeo">Alfa Romeo</option>
                                                    <option value="Aston Martin">Aston Martin</option>
                                                    <option value="Audi">Audi</option>
                                                    <option value="Bentley">Bentley</option>
                                                    <option value="BMW">BMW</option>
                                                    <option value="Bugatti">Bugatti</option>
                                                    <option value="Buick">Buick</option>
                                                    <option value="Cadillac">Cadillac</option>
                                                    <option value="Chery">Chery</option>
                                                    <option value="Chevrolet">Chevrolet</option>
                                                    <option value="Chrysler">Chrysler</option>
                                                    <option value="Citroen">Citroen</option>
                                                    <option value="Cupra">Cupra</option>
                                                    <option value="Dacia">Dacia</option>
                                                    <option value="DS Automobiles">DS Automobiles</option>
                                                    <option value="Daewoo">Daewoo</option>
                                                    <option value="Daihatsu">Daihatsu</option>
                                                    <option value="Dodge">Dodge</option>
                                                    <option value="Ferrari">Ferrari</option>
                                                    <option value="Fiat">Fiat</option>
                                                    <option value="Ford">Ford</option>
                                                    <option value="Geely">Geely</option>
                                                    <option value="Honda">Honda</option>
                                                    <option value="Hyundai">Hyundai</option>
                                                    <option value="Infiniti">Infiniti</option>
                                                    <option value="Isuzu">Isuzu</option>
                                                    <option value="Iveco">Iveco</option>
                                                    <option value="Jaguar">Jaguar</option>
                                                    <option value="Jeep">Jeep</option>
                                                    <option value="Kia">Kia</option>
                                                    <option value="Lada">Lada</option>
                                                    <option value="Lamborghini">Lamborghini</option>
                                                    <option value="Lancia">Lancia</option>
                                                    <option value="Land-rover">Land-rover</option>
                                                    <option value="Leapmotor">Leapmotor</option>
                                                    <option value="Lexus">Lexus</option>
                                                    <option value="Lincoln">Lincoln</option>
                                                    <option value="Lotus">Lotus</option>
                                                    <option value="Maserati">Maserati</option>
                                                    <option value="Mazda">Mazda</option>
                                                    <option value="McLaren">McLaren</option>
                                                    <option value="Mercedes-Benz">Mercedes-Benz</option>
                                                    <option value="MG">MG</option>
                                                    <option value="Mini">Mini</option>
                                                    <option value="Mitsubishi">Mitsubishi</option>
                                                    <option value="Nissan">Nissan</option>
                                                    <option value="Opel">Opel</option>
                                                    <option value="Peugeot">Peugeot</option>
                                                    <option value="Porsche">Porsche</option>
                                                    <option value="Proton">Proton</option>
                                                    <option value="Renault">Renault</option>
                                                    <option value="Rolls Royce">Rolls Royce</option>
                                                    <option value="Rover">Rover</option>
                                                    <option value="Saab">Saab</option>
                                                    <option value="Seat">Seat</option>
                                                    <option value="Skoda">Skoda</option>
                                                    <option value="Smart">Smart</option>
                                                    <option value="Ssangyong">Ssangyong</option>
                                                    <option value="Subaru">Subaru</option>
                                                    <option value="Suzuki">Suzuki</option>
                                                    <option value="Tata">Tata</option>
                                                    <option value="Tesla">Tesla</option>
                                                    <option value="Tofaş">Tofaş</option>
                                                    <option value="Toyota">Toyota</option>
                                                    <option value="Volkswagen">Volkswagen</option>
                                                    <option value="Volvo">Volvo</option>
                                                    <option value="Voyah">Voyah</option>
                                                    <option value="Yudo">Yudo</option>
                                                </select>

                                                <label class="form-label" for="yakit_tipi">Yakıt Tipi:</label>
                                                <select class="formInput" id="yakit_tipi" name="yakit_tipi">
                                                    <option value="">Seçiniz</option>
                                                    <option value="benzin">Benzin</option>
                                                    <option value="dizel">Dizel</option>
                                                    <option value="lpg">LPG</option>
                                                    <option value="elektrik">Elektrik</option>
                                                </select>

                                                <label class="form-label" for="vites_tipi">Vites Tipi:</label>
                                                <select class="formInput" id="vites_tipi" name="vites_tipi">
                                                    <option value="">Seçiniz</option>
                                                    <option value="manuel">Manuel</option>
                                                    <option value="otomatik">Otomatik</option>
                                                </select>

                                                <label class="form-label" for="arac_satis_rakami">Satış
                                                    Rakamı:</label>
                                                <input class="formInput" type="text"
                                                    id="arac_satis_rakami" name="arac_satis_rakami"
                                                    min="0">

                                                <label class="form-label" for="ruhsat_belgesi">Ruhsat
                                                    Belgesi
                                                    Yükleyiniz:</label>
                                                <input class="formInput" type="file" id="ruhsat_belgesi"
                                                    name="ruhsat_belgesi" accept=".pdf,.doc,.docx">
                                            </div>

                                            <div id="isyeriyse" style="display: none;"
                                                class="mb-3 col-md-12 col-12">

                                                <label for="ticari_bilgiler" class="form-label">Ticari ile
                                                    ilgili Bilgileri Giriniz:</label>
                                                <textarea class="formInput" id="ticari_bilgiler" name="ticari_bilgiler"></textarea>

                                                <label for="isyeri_satis_rakami"
                                                    class="form-label">Düşündüğünüz Satış Rakamı:</label>
                                                <input type="text" class="formInput"
                                                    id="isyeri_satis_rakami" name="isyeri_satis_rakami"
                                                    min="0">
                                            </div>

                                        </div>

                                        <button type="submit"
                                            style="background-color: #ea2a28; color: white; padding: 10px; border: none;width:150px;margin-top:20px">Başvur</button>
                                        <button type="button" data-bs-dismiss="modal"
                                            style="background-color: black; color: white; padding: 10px; border: none;width:150px;margin-top:20px">Kapat</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                            <div class="mt-5 mb-5">
                                    @if ($housing->step2_slug == 'gunluk-kiralik')
                                        <div class="mobileMove" id="mobileMoveID">

                                            <div class="schedule widget-boxed mt-33 mt-0">
                                                <div class="widget-boxed-header">

                                                    <div
                                                        class="d-flex justify-content-between align-items-center">
                                                        <h4><i
                                                                class="fa fa-calendar pr-3 padd-r-10"></i>Rezervasyon
                                                            Yap
                                                        </h4>
                                                        <div
                                                            class="d-flex align-items-center justify-content-around mobile-action-move">
                                                            <div class="buttons" style="margin-right: 5px">
                                                                <button class="main-button">
                                                                    <svg width="20" height="30"
                                                                        fill="currentColor"
                                                                        viewBox="0 0 24 24"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M15.75 5.125a3.125 3.125 0 1 1 .754 2.035l-8.397 3.9a3.124 3.124 0 0 1 0 1.88l8.397 3.9a3.125 3.125 0 1 1-.61 1.095l-8.397-3.9a3.125 3.125 0 1 1 0-4.07l8.397-3.9a3.125 3.125 0 0 1-.144-.94Z">
                                                                        </path>
                                                                    </svg>
                                                                </button>
                                                                <button class="twitter-button button"
                                                                    style="transition-delay: 0.1s, 0s, 0.1s; transition-property: translate, background, box-shadow;">

                                                                    <a
                                                                        href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}">
                                                                        <svg viewBox="0 0 24 24"
                                                                            width="24" height="24"
                                                                            stroke="currentColor"
                                                                            stroke-width="2" fill="none"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            class="css-i6dzq1">
                                                                            <path
                                                                                d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z">
                                                                            </path>
                                                                        </svg></a>
                                                                </button>

                                                                <button class="reddit-button button"
                                                                    style="transition-delay: 0.2s, 0s, 0.2s; transition-property: translate, background, box-shadow;">
                                                                    <a
                                                                        href="whatsapp://send?text={{ $shareUrl }}">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 24 24"
                                                                            fill="currentColor" height="24"
                                                                            width="24">
                                                                            <path
                                                                                d="M19.001 4.908A9.817 9.817 0 0 0 11.992 2C6.534 2 2.085 6.448 2.08 11.908c0 1.748.458 3.45 1.321 4.956L2 22l5.255-1.377a9.916 9.916 0 0 0 4.737 1.206h.005c5.46 0 9.908-4.448 9.913-9.913A9.872 9.872 0 0 0 19 4.908h.001ZM11.992 20.15A8.216 8.216 0 0 1 7.797 19l-.3-.18-3.117.818.833-3.041-.196-.314a8.2 8.2 0 0 1-1.258-4.381c0-4.533 3.696-8.23 8.239-8.23a8.2 8.2 0 0 1 5.825 2.413 8.196 8.196 0 0 1 2.41 5.825c-.006 4.55-3.702 8.24-8.24 8.24Zm4.52-6.167c-.247-.124-1.463-.723-1.692-.808-.228-.08-.394-.123-.556.124-.166.246-.641.808-.784.969-.143.166-.29.185-.537.062-.247-.125-1.045-.385-1.99-1.23-.738-.657-1.232-1.47-1.38-1.716-.142-.247-.013-.38.11-.504.11-.11.247-.29.37-.432.126-.143.167-.248.248-.413.082-.167.043-.31-.018-.433-.063-.124-.557-1.345-.765-1.838-.2-.486-.404-.419-.557-.425-.142-.009-.309-.009-.475-.009a.911.911 0 0 0-.661.31c-.228.247-.864.845-.864 2.067 0 1.22.888 2.395 1.013 2.56.122.167 1.742 2.666 4.229 3.74.587.257 1.05.408 1.41.523.595.19 1.13.162 1.558.1.475-.072 1.464-.6 1.673-1.178.205-.58.205-1.075.142-1.18-.061-.104-.227-.165-.475-.29Z">
                                                                            </path>
                                                                        </svg>
                                                                    </a>

                                                                </button>
                                                                <button class="messenger-button button"
                                                                    style="transition-delay: 0.3s, 0s, 0.3s; transition-property: translate, background, box-shadow;">
                                                                    <a
                                                                        href="https://telegram.me/share/url?url={{ $shareUrl }}">
                                                                        <svg viewBox="0 0 24 24"
                                                                            width="24" height="24"
                                                                            stroke="currentColor"
                                                                            stroke-width="2" fill="none"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            class="css-i6dzq1">
                                                                            <line x1="22"
                                                                                y1="2" x2="11"
                                                                                y2="13"></line>
                                                                            <polygon
                                                                                points="22 2 15 22 11 13 2 9 22 2">
                                                                            </polygon>
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
                                                        <input type="hidden" name="key" id="orderKey">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-12 col-6 book">
                                                                <input type="date" id="date-checkin"
                                                                    placeholder="Giriş Tarihi"
                                                                    name="check_in_date"
                                                                    class="date-field form-control">
                                                            </div>
                                                            <div class="col-lg-6 col-md-12 col-6 book2">
                                                                <input type="date" id="date-checkout"
                                                                    placeholder="Çıkış Tarihi"
                                                                    name="check_out_date"
                                                                    class="date-field form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row mrg-top-15 mb-3">
                                                            <div class="col-lg-6 col-md-12 mt-3 mb-2">
                                                                <label>Kişi Sayısı</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-btn">
                                                                        <button type="button"
                                                                            class="btn counter-btn theme-cl btn-number"
                                                                            disabled="disabled"
                                                                            data-type="minus"
                                                                            data-field="quant[1]">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </span>
                                                                    <input type="number" name="person_count"
                                                                        class="border-0 text-center form-control input-number"
                                                                        data-min="1" data-max="10"
                                                                        value="1" readonly>
                                                                    <span class="input-group-btn">
                                                                        <button type="button"
                                                                            class="btn counter-btn theme-cl btn-number"
                                                                            data-type="plus"
                                                                            data-field="quant[1]">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-lg-6 col-md-12 mt-3 showPrice d-none">
                                                                <label>Toplam Tutar</label>
                                                                <div class="input-group">
                                                                    <span id="totalPrice">₺</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12 col-md-12 mt-3 ">
                                                            <div class="row">
                                                                <div class="d-flex align-items-center">
                                                                    <input id="money-trusted" type="checkbox">
                                                                    <i class="fa fa-info-circle ml-2"
                                                                        title="Param güvende seçeneği işaretlerseniz rezervasyon iptal durumunda paranızın iadesinde kesinti olmayacaktır."
                                                                        style="font-size: 18px;"></i>
                                                                    <label for="money-trusted"
                                                                        class="m-0 ml-1"> Param
                                                                        güvende (+1.000₺)</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button"
                                                            @if (!Auth::check()) onclick="redirectToPage()" @endif
                                                            class="reservationBtn reservation btn-radius full-width mt-2 text-white" id="submitBtn">Rezervasyon
                                                            Yap</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                              

                            </div>

                        <div class="moveStore">
                            <div class="widget-boxed removeClass mt-5 mb-5">
                                <div class="widget-boxed-body pt-0">
                                    <div class="sidebar-widget author-widget2">
                                        <table class="table">
                                            <tbody>
                                                @if ($housing->consultant)
                                                    <div class="author-box clearfix d-flex align-items-center">

                                                        <img src="{{ asset('storage/profile_images/' . $housing->consultant->profile_image) }}"
                                                            alt="author-image" class="author__img">
                                                        <div>
                                                            <h4 class="author__title">{{ $housing->consultant->name }}
                                                            </h4>
                                                            <p class="author__meta">
                                                                {{ $housing->consultant->role->name }}</p>
                                                        </div>


                                                    </div>
                                                @endif

                                                <tr style="border-top: none !important">
                                                    <td style="border-top: none !important">
                                                        <span class="det" style="color: #EA2B2E !important;">
                                                            {!! optional($housing->city)->title .
                                                                ' / ' .
                                                                optional($housing->county)->title .
                                                                ' / ' .
                                                                optional($housing->neighborhood)->mahalle_title ??
                                                                '' !!}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span> İlan No :</span>
                                                        <span class="det" style="color:#274abb;">
                                                            {{ $housing->id + 2000000 }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span> İlan Tarihi :</span>
                                                        <span class="det" style="color:#274abb;">
                                                            {{ date('j', strtotime($housing->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($housing->created_at))) . ' ' . date('Y', strtotime($housing->created_at)) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span> Mağaza :</span>
                                                        <span class="det text-wrap" style="color:#274abb;">
                                                            {!! $housing->user->name !!}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <span> Kimden :</span>
                                                        <span class="det text-wrap" style="color:#274abb;">
                                                            {{ $housing->user->corporate_type == 'Emlak Ofisi' ? 'Gayrimenkul Ofisi' : $housing->user->corporate_type }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                @if ($housing->consultant && $housing->consultant->mobile_phone)
                                                    @php

                                                        $consultantPermissions = $housing->consultant->role->rolePermissions
                                                            ->flatMap(function ($rolePermission) {
                                                                return $rolePermission->permissions->pluck('key');
                                                            })
                                                            ->unique()
                                                            ->toArray();
                                                    @endphp
                                                    @if (in_array('showPhone', $consultantPermissions))
                                                        <tr>
                                                            <td>
                                                                Cep :
                                                                <span class="det">
                                                                    <a style="text-decoration: none;color:#274abb;"
                                                                        href="tel:{!! $housing->consultant->mobile_phone !!}">{!! $housing->consultant->mobile_phone !!}</a>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @else
                                                    @if ($housing->user->mobile_phone)
                                                        <tr>
                                                            <td>
                                                                Cep :
                                                                <span class="det">
                                                                    <a style="text-decoration: none;color:#274abb;"
                                                                        href="tel:{!! $housing->user->mobile_phone !!}">{!! $housing->user->mobile_phone !!}</a>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endif


                                                @if ($housing->user->phone)
                                                    <tr>
                                                        <td>
                                                            İş :
                                                            <span class="det">
                                                                <a style="text-decoration: none;color:#274abb;"
                                                                    href="tel:{!! $housing->user->phone !!}">{!! $housing->user->phone !!}</a>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endif


                                                <tr>
                                                    <td>
                                                        İlan Tipi :
                                                        <span class="det">
                                                            @if ($housing->step1_slug)
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
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        E-Posta :
                                                        <span class="det">
                                                            <a style="text-decoration: none;color:inherit"
                                                                href="mailto:{!! $housing->user->email !!}">{!! $housing->user->email !!}</a>
                                                        </span>

                                                    </td>
                                                </tr>
                                                @foreach ($labels as $label => $val)
                                                    @if (
                                                        $label != 'Kapak Resmi' &&
                                                            $label != 'Taksitli Satış' &&
                                                            $label != 'Fiyat' &&
                                                            $label != 'Seçenekler' &&
                                                            $label != 'Acil Satılık' &&
                                                            $label != 'İndirim Oranı %' &&
                                                            $label != 'Yıldız Sayısı' &&
                                                            $label != 'Yapının Durumu' &&
                                                            $label != 'Peşinat' &&
                                                            $label != 'İlan Başlığı' &&
                                                            $label != 'Günlük Fiyat' &&
                                                            $label != 'Peşin Fiyat' &&
                                                            $label != 'Taksitli Toplam Fiyat' &&
                                                            isset($val[0]) &&
                                                            $val[0] != 0 &&
                                                            $val[0] != null &&
                                                            !isset($val[1]))
                                                        <tr>
                                                            <td>
                                                                <span class="mr-1">{{ $label }}:</span>
                                                                @if ($label == 'm² (Net)<br>')
                                                                    <span class="det">{{ $val[0] }}
                                                                        m2</span>
                                                                @elseif ($label == 'Özellikler')
                                                                    <ul>
                                                                        @foreach ($val as $ozellik)
                                                                            <li>{{ $ozellik }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                @else
                                                                    <span class="det">
                                                                        {{ isset($val[0]) && $val[0] ? ($val[0] == 'yes' ? 'Evet' : ($val[0] == 'no' ? 'Hayır' : $val[0])) : '' }}
                                                                    </span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach








                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>

                </aside>
            </div>


        </div>
    </section>

    {{-- <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="hidden" name="key" id="orderKey">
                    <div class="tr-single-box mb-0 shadow-sm p-3 mb-5 bg-body-tertiary rounded">
                        <div class="row">
                            <div class="col-md-12 pt-4">
                                <h2 class="font-weight-bold">Rezervasyon Detayları</h2>
                                <ul class="list-group">
                                    <li class="list-group-item bg-light">İlan: <span
                                            class="float-right font-weight-bold">{{ $housing->title }} </span></li>
                                    <li class="list-group-item bg-light">İlan No: <span
                                            class="float-right font-weight-bold"
                                            style="color:#007bff">{{ $housing->id + 2000000 }} </span></li>
                                    <li class="list-group-item bg-light">Rezervasyon Tarihi:<span
                                            class="float-right font-weight-bold">{{ date('d.m.Y') }}</span></li>
                                    <li class="list-group-item bg-light">Giriş Tarihi:<span
                                            class="float-right font-weight-bold inDate">9pm 10pm</span></li>
                                    <li class="list-group-item bg-light">Kişi Sayısı:<span
                                            class="float-right font-weight-bold userCount">9pm 10pm</span></li>
                                    <li class="list-group-item bg-light">Çıkış Tarihi:<span
                                            class="float-right font-weight-bold outDate">10 jan 2019</span></li>
                                </ul>
                            </div>

                            <div class="col-md-12 pt-4">
                                <h2 class="font-weight-bold">Ödeme Detayları</h2>
                                <ul class="list-group">
                                    <li class="list-group-item bg-light ">
                                        <span class="font-weight-bold">&nbsp;X Gece</span>
                                        <span class="dayCount float-left font-weight-bold">
                                            @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                @if ($housing->step2_slug == 'gunluk-kiralik')
                                                    {{ getData($housing, 'daily_rent') - $discountAmount }} ₺
                                                @else
                                                    {{ number_format(getData($housing, 'price') - $discountAmount, 0, ',', '.') }}
                                                    ₺
                                                @endif
                                            @endif
                                        </span>
                                        <span class="float-right font-weight-bold totalPrice">$263</span>
                                    </li>



                                    <li class="list-group-item bg-light">Şimdi Ödenecek Tutar:&nbsp;<span
                                            class="float-right font-weight-bold newTotalPrice">$263</span> </li>
                                    <li class="list-group-item bg-light">Kapıda Ödenecek Tutar<span
                                            class="float-right font-weight-bold newTotalPrice">$263</span> </li>
                                    <li class="list-group-item bg-light">Toplam Tutar<span
                                            class="float-right font-weight-bold totalPrice">$150</span></li>
                                </ul>
                            </div>

                            <div class="col-md-12 pt-4">
                                <h2 class="font-weight-bold">Destek Detayları</h2>
                                <ul class="list-group">
                                    <li class="list-group-item bg-light">
                                        <i class=" float-left fas fa-phone-alt mt-1 mr-4"></i> <span
                                            class="float-left font-weight-bold"></span> 444 3 284
                                    </li>
                                    <li class="list-group-item bg-light">
                                        <i class=" float-left fas fa-envelope mt-1 mr-3"></i> <span
                                            class="float-left font-weight-bold"></span> destek@emlaksepette.com
                                    </li>
                                </ul>
                            </div>

                            <div class="col-md-12 pt-4">
                                <h2 class="font-weight-bold">EFT/Havale Detayları</h2>
                                <ul class="list-group">
                                    <li class="list-group-item bg-light">EFT/Havale Kodu<span
                                            class="float-right font-weight-bold  totalPriceCode">$60<span>
                                    </li>
                                </ul>
                            </div>



                            @foreach ($bankAccounts as $bankAccount)
                                <div class="col-md-4 pt-4 px-4 pb-4  bank-account" data-id="{{ $bankAccount->id }}"
                                    data-iban="{{ $bankAccount->iban }}"
                                    data-title="{{ $bankAccount->receipent_full_name }}">
                                    <img src="{{ URL::to('/') }}/{{ $bankAccount->image }}" alt=""
                                        style="width: 100%;height:100px;object-fit:contain;cursor:pointer">
                                </div>
                            @endforeach

                            <div class="col-md-12 pt-4">
                                <span id="ibanInfo"></span>
                                <span>Ödeme işlemini tamamlamak için, lütfen bu
                                    <span style="color:red;font-size:15px !important;font-weight:bold"
                                        id="uniqueCode"></span>
                                    kodu kullanarak ödemenizi
                                    yapın. IBAN açıklama
                                    alanına
                                    bu kodu eklemeyi unutmayın. Ardından "Ödemeyi Tamamla" düğmesine tıklayarak işlemi
                                    bitirin.</span>

                                <fieldset>

                                    <div class="checkboxes float-left mt-3 mb-3">
                                        <div class="filter-tags-wrap" id="individualFormCheck"
                                            style="display: block;">
                                            <input id="check-a" type="checkbox" name="check-a">
                                            <label for="check-a" style="font-size: 11px;">
                                                <a href="/sayfa/mesafeli-kiralama-sozlesmesi" target="_blank">
                                                    Mesafeli Kiralama Sözleşmesini
                                                </a>
                                                okudum onaylıyorum.
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="modal-footer"> <button type="button"
                                        @if ((Auth::check() && Auth::user()->type == '2') || (Auth::check() && Auth::user()->parent_id)) disabled @endif class="btn btn-primary"
                                        id="completePaymentButton" style="width:150px">Satın Al
                                    </button>
                                    <button type="button" class="btn btn-secondary " style="width:150px"
                                        data-bs-dismiss="modal">İptal</button>

                                </div>

                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div> --}}


    {{-- <div class="modal fade" id="finalConfirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="finalConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <h5 style="color:black;font-size:15px !important">Ödeme Onayı</h5>

                        <span>Ödemeniz başarıyla tamamlamak için lütfen aşağıdaki adımları takip edin:</span> <br>
                        <span>1. <strong style="color:red;font-size:15px;font-weight:bold"
                                id="uniqueCodeRetry"></strong>
                            kodunu EFT/Havale açıklama
                            alanına yazdığınızdan emin olun.</span>

                        <div class="row mt-3 mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fullName">Ad Soyad *</label>
                                    <input type="text" class="form-control" id="fullName" name="fullName"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">E-posta *</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tc">TC * </label>
                                    <input type="number" class="form-control" id="tc" name="tc"
                                        required oninput="validateTCLength(this)">
                                </div>
                            </div>

                            <script>
                                function validateTCLength(input) {
                                    var maxLength = 11;
                                    if (input.value.length > maxLength) {
                                        input.value = input.value.slice(0, maxLength);
                                        alert("TC kimlik numarası 11 karakterden fazla olamaz!");
                                    }
                                }
                            </script>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Telefon *</label>
                                    <input type="tel" class="form-control" id="phone" name="phone"
                                        required maxlength="10">
                                    <span id="error_message" class="error-message"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Adres *</label>
                                    <textarea class="form-control" id="address" name="address" rows="5" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="notes">Notlar:</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="submitBtn" class="btn btn btn-primary paySuccess">Ödemeyi
                                Tamamla
                                <svg viewBox="0 0 576 512" class="svgIcon">
                                    <path
                                        d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24H360c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z">
                                    </path>
                                </svg></button>
                            <button type="button" class="btn btn-secondary " style="width:150px"
                                data-bs-dismiss="modal">İptal</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"
        integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&callback=initMap"></script>

    <script>
        $(document).ready(function() {
            $("#telefon").on("input blur", function() {
                var phoneNumber = $(this).val();
                var pattern = /^5[0-9]\d{8}$/;

                if (!pattern.test(phoneNumber)) {
                    $("#error_message").text(
                        "Lütfen geçerli bir telefon numarası giriniz.");
                } else {
                    $("#error_message").text("");
                }
                // Kullanıcı 10 haneden fazla veri girdiğinde bu kontrol edilir
                $('#telefon').on('keypress', function(e) {
                    var max_length = 10;
                    // Eğer giriş karakter sayısı 10'a ulaştıysa ve yeni karakter ekleme işlemi değilse
                    if ($(this).val().length >= max_length && e.which != 8 && e.which != 0) {
                        // Olayın işlenmesini durdur
                        e.preventDefault();
                    }
                });
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#takasFormu').submit(function(e) {
                var isEmpty = false;

                // Emlak seçildiyse, ilgili alanların doldurulma zorunluluğunu kontrol et
                if ($('#takas_tercihi').val() === 'emlak') {
                    var emlakTipi = $('#emlak_tipi').val();
                    if (emlakTipi === 'konut' || emlakTipi === 'arsa') {
                        var requiredFields = [];
                        if (emlakTipi === 'konut') {
                            requiredFields = ['konut_satis_rakami', 'kullanim_durumu', 'konut_yasi',
                                'oda_sayisi', 'konut_tipi'
                            ];
                        } else if (emlakTipi === 'arsa') {
                            requiredFields = ['arsa_il', 'arsa_ilce', 'arsa_mahalle', 'ada_parsel',
                                'imar_durumu', 'satis_rakami'
                            ];
                        }
                    } else if (emlakTipi === 'işyeri') {
                        requiredFields = ['ticari_bilgiler', 'isyeri_satis_rakami'];
                    }

                    for (var i = 0; i < requiredFields.length; i++) {
                        var field = $('#' + requiredFields[i]);
                        if (field.val().trim() === '') {
                            isEmpty = true;
                            field.addClass('error');
                        } else {
                            field.removeClass('error');
                        }
                    }
                }

                // Araç seçildiyse, ilgili alanların doldurulma zorunluluğunu kontrol et
                if ($('#takas_tercihi').val() === 'araç') {
                    var requiredFields = ['arac_model_yili', 'arac_markasi', 'yakit_tipi', 'vites_tipi',
                        'arac_satis_rakami'
                    ];

                    for (var i = 0; i < requiredFields.length; i++) {
                        var field = $('#' + requiredFields[i]);
                        if (field.val().trim() === '') {
                            isEmpty = true;
                            field.addClass('error');
                        } else {
                            field.removeClass('error');
                        }
                    }
                }


                // Barter veya Diğer seçildiyse, ilgili alanların boş olup olmadığını kontrol et
                if ($('#takas_tercihi').val() === 'barter' || $('#takas_tercihi').val() === 'diğer') {
                    $('.conditional-fields:visible').find('.formInput').each(function() {
                        if ($(this).val().trim() === '') {
                            isEmpty = true;
                            $(this).addClass('error');
                        } else {
                            $(this).removeClass('error');
                        }
                    });
                }

                if (isEmpty) {
                    e.preventDefault();
                    alert('Tüm zorunlu alanları doldurunuz!');
                }

            });
        });
    </script>
    <script>
        $('#selectImageButton').on('click', function() {
            console.log("a");
            $('.fileinput').click();
        });
        $(function() {
            $('.fa-info-circle').tooltip()
        })
        if (window.innerWidth <= 768) {
            var mobileActionMove = $(".mobile-action-move").html();
            var mobileMove = $(".mobileMove").html();
            var mobileHour = $(".mobileHour").html();
            var mobileMovePrice = $(".mobileMovePrice").html();
            var moveGain = $(".move-gain").html();

            $("#listingDetailsSlider").after(mobileHour);
            $(".mobileHourDiv").after(mobileMove);
            $(".mobile-action").html(mobileActionMove);


            $(".mobileMovePrice").remove();
            $(".move-gain").remove();

            if (mobileMovePrice == undefined) {
                $(".mobile-action-move").remove();
                $(".col-md-7").removeClass("col-md-7").removeClass("col-7").addClass("col-md-12");
            } else {
                $(".mobile-action-move").html(mobileMovePrice);
            }
            $(".mobileMove").remove();
            $(".mobileHour").remove();

            var store = $(".moveStore").html();
            $("#myTabContent").after(store);
            $(".moveStore").addClass("mb-30");
            $(".moveStore").remove();
            $(".move-mobile-gain").html(moveGain);


        }

        function redirectToPage() {
            window.location.href = "/giris-yap";
        }

        function initMap() {
            // İlk harita görüntüsü
            var map = new google.maps.Map(document.getElementById('mapContainer'), {
                center: {
                    lat: {{ $housing->latitude }},
                    lng: {{ $housing->longitude }}
                },
                zoom: 16,
                gestureHandling: 'greedy'
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

        function submitForm() {
            // Rate değerini al
            var rateValue = $('#rate').val();

            // Eğer rate değeri boş veya 0 ise, 1 olarak ayarla
            if (rateValue === '' || rateValue === '0') {
                $('#rate').val('1');
            }
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            console.log(csrfToken);
            var formData = new FormData($('#commentForm')[0]);
            // Append CSRF token to form data
            formData.append('_token', csrfToken);

            $.ajax({
                url: "{{ route('housing.send-comment', ['id' => $housing->id]) }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Yorum Gönderildi',
                        text: 'Yorumunuz admin onayladıktan sonra yayınlanacaktır.',
                    }).then(function() {
                        location.reload(); // Reload the page
                    });
                },
                error: function(error) {
                    window.location.href = "/giris-yap";
                    //console.log(error);
                }
            });
        }

        $(document).ready(function() {
            $('.listingDetailsSliderNav').slick({
                slidesToShow: 5,
                slidesToScroll: 5,
                dots: false,
                loop: false,
                autoplay: false,
                arrows: false,
                margin: 0,
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
        // Sayfa yüklendiğinde
        $(document).ready(function() {
            updateIndex(); // Index değerini güncelle

            // Slayt geçiş işlemi tamamlandığında
            $('#listingDetailsSlider').on('slid.bs.carousel', function() {
                updateIndex(); // Index değerini güncelle
            });

        });
        // Mobil cihazlarda kaydırma işlevselliği
        $('#listingDetailsSlider').on('touchstart', function(event) {
            var xClick = event.originalEvent.touches[0].pageX;
            $(this).one('touchmove', function(event) {
                var xMove = event.originalEvent.touches[0].pageX;
                var sensitivityInPx = 5;

                if (Math.floor(xClick - xMove) > sensitivityInPx) {
                    $(this).carousel('next');
                } else if (Math.floor(xClick - xMove) < -sensitivityInPx) {
                    $(this).carousel('prev');
                }
            });
        });

        // Mobil cihazlarda dokunmatik olayları devre dışı bırakma
        $('#listingDetailsSlider').on('touchend', function() {
            $(this).off('touchmove');
        });

        // Index değerini güncelleyen fonksiyon
        function updateIndex() {
            var totalSlides = $('#listingDetailsSlider .carousel-item').length; // Toplam slayt sayısını al
            var index = $('#listingDetailsSlider .carousel-item.active').index(); // Aktif slaydın indeksini al
            $('.pagination .page-item-middle .page-link').text((index + 1) + '/' +
                totalSlides); // Ortadaki li etiketinin metnini güncelle
        }
        if (window.innerWidth <= 768) {
            // Sol ok tuşuna tıklandığında
            $('.pagination .page-item-left').on('click', function(event) {
                event.preventDefault();
                $('#listingDetailsSlider').carousel('prev');
                var index = $('#listingDetailsSlider .carousel-item.active').attr('data-slide-number');
                // $('.pagination .page-item-middle .page-link').text(index);
                $('.listingDetailsSliderNav').slick('slickGoTo', index);
                var smallIndex = $('#listingDetailsSlider .active').data('slide-number');

            });

            // Sağ ok tuşuna tıklandığında
            $('.pagination .page-item-right').on('click', function(event) {
                event.preventDefault(); // Sayfanın yukarı gitmesini engelle
                $('#listingDetailsSlider').carousel('next');
                var index = $('#listingDetailsSlider .carousel-item.active').attr('data-slide-number');
                // $('.pagination .page-item-middle .page-link').text(index);
                $('.listingDetailsSliderNav').slick('slickGoTo', index);
                var smallIndex = $('#listingDetailsSlider .active').data('slide-number');
            });
        }

        var currentSlideIndex = 0;

        // Sağ ok tuşuna tıklandığında
        $('.pagination .page-item-right').on('click', function(event) {
            event.preventDefault(); // Sayfanın yukarı gitmesini engelle
            var totalItems = $('#listingDetailsSlider .carousel-item').length + 1; // Toplam slayt sayısını al
            var remainingItems = totalItems - (currentSlideIndex + 1) * 5; // Kalan slayt sayısını hesapla

            if (remainingItems >= 5) {
                currentSlideIndex++;
                $('.listingDetailsSliderNav').slick('slickGoTo', currentSlideIndex *
                    5); // Bir sonraki beşli kümeye git
            } else {
                $('.listingDetailsSliderNav').slick('slickNext'); // Son beşli kümeye git
            }
        });

        // Sol ok tuşuna tıklandığında
        $('.pagination .page-item-left').on('click', function(event) {
            event.preventDefault();
            if (currentSlideIndex > 0) {
                currentSlideIndex--;
                $('.listingDetailsSliderNav').slick('slickGoTo', currentSlideIndex * 5); // Önceki beşli kümeye git
            } else {
                $('.listingDetailsSliderNav').slick('slickPrev'); // Son beşli kümeye git

            }
        });


        $('.listingDetailsSliderNav').on('click', 'a', function() {
            var index2 = $(this).attr('data-slide-to');
            $('#listingDetailsSlider').carousel(parseInt(index2));
        });


        $(document).ready(function() {
            // Büyük görsel kaydığında küçük görselleri de eşleştirme
            $('#listingDetailsSlider').on('slid.bs.carousel', function() {
                var index = $('#listingDetailsSlider .carousel-item.active').attr('data-slide-number');
                $('.listingDetailsSliderNav').slick('slickGoTo', index);
                var smallIndex = $('#listingDetailsSlider .active').data('slide-number');

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
        // jQuery('form').submit(function(event) {
        //     if ($('#rate').val() === '') {
        //         $('#rate').val('1'); // Rate değerini 1 olarak ayarla
        //     }
        // });




        function showLocation() {
            var location = document.getElementById('locationInput').value;

            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: {{ $housing->longitude }},
                    lng: {{ $housing->latitude }}
                },
                zoom: 12,
                gestureHandling: 'greedy'
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

    <script>
        $(document).ready(function() {
            $("#phone").on("input blur", function() {
                var phoneNumber = $(this).val();
                var pattern = /^5[0-9]\d{8}$/;

                if (!pattern.test(phoneNumber)) {
                    $("#error_message").text(
                        "Lütfen geçerli bir telefon numarası giriniz.");
                } else {
                    $("#error_message").text("");
                }
                // Kullanıcı 10 haneden fazla veri girdiğinde bu kontrol edilir
                $('#phone').on('keypress', function(e) {
                    var max_length = 10;
                    // Eğer giriş karakter sayısı 10'a ulaştıysa ve yeni karakter ekleme işlemi değilse
                    if ($(this).val().length >= max_length && e.which != 8 && e.which != 0) {
                        // Olayın işlenmesini durdur
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
    @if ($housing->step2_slug == 'gunluk-kiralik')
        <script>
            $(document).ready(function() {
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
                $(".reservation").on("click", function() {
                    $('.modal-backdrop').show();

                    if ($(".showPrice").hasClass("d-none")) {
                        $(".reservationBtn").removeAttr("data-toggle data-target");
                        Swal.fire({
                            icon: 'warning',
                            title: 'Uyarı!',
                            text: 'Lütfen geçerli bir tarih seçiniz!',
                        });
                    } else {
                        // Assuming dateCheckin and dateCheckout are in the format "DD-MM-YYYY"
                        var dateCheckin = $("#date-checkin").val();
                        var dateCheckout = $("#date-checkout").val();

                        // Parse the input dates
                        var checkinDate = new Date(dateCheckin);
                        var checkoutDate = new Date(dateCheckout);

                        // Format the dates as "DD.MM.YYYY" in Turkish locale
                        var formattedCheckinDate = checkinDate.toLocaleDateString('tr-TR');
                        var formattedCheckoutDate = checkoutDate.toLocaleDateString('tr-TR');

                        // Update the HTML content of elements with classes inDate and outDate
                        $(".inDate").html(formattedCheckinDate);
                        $(".outDate").html(formattedCheckoutDate);

                        var inputNumber = $(".input-number").val();
                        $(".userCount").html(inputNumber + " Kişi");


                        var uniqueCode = generateUniqueCode();
                        $('#uniqueCode').text(uniqueCode);
                        $('#uniqueCodeRetry').text(uniqueCode);
                        $("#orderKey").val(uniqueCode);
                        $(".totalPriceCode").html(uniqueCode);
                        $(".reservationBtn").attr({
                            "data-bs-toggle": "modal",
                            "data-bs-target": "#paymentModal"
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
                        console.log(diffDays)

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
                            $(".dayCount").html(diffDays);
                            $("#totalPrice").html(price * diffDays + " ₺");
                            $(".totalPrice").html(price * diffDays + " ₺");
                            $("#completePaymentButton").html((price * diffDays / 2) + " ₺" + " Öde");
                            $(".paySuccess ").html((price * diffDays / 2) + " ₺" + " Ödemeyi Tamamla");

                            $(".newTotalPrice").html((price * diffDays / 2) + " ₺");

                            $('.reservationBtn').prop('disabled', false);

                        }
                    }
                }

                $('#money-trusted').change(function() {
                    if ($(this).is(':checked')) {
                        $('.reservation-form-add-area ul').append(
                            "<li class='pb-0'>Param Güvende <strong class='pull-right money-trusted-price'>1000 ₺</strong></li>"
                        )
                        $('.reservation-form-add-area ul').append(
                            "<li >Yeni toplam fiyat <strong class='pull-right money-trusted-add-total-price'>" +
                            (parseInt($('.newTotalPrice').html()) + 1000) + " ₺</strong></li>")
                        $('#completePaymentButton').html((parseInt($('.newTotalPrice').html()) + 1000) +
                            " ₺ Öde")
                    } else {
                        $('.money-trusted-price').closest('li').remove();
                        $('.money-trusted-add-total-price').closest('li').remove();
                        $('#completePaymentButton').html((parseInt($('.newTotalPrice').html())) + " ₺ Öde")
                    }
                })

                $('#submitBtn').click(function() {
                    // Kullanıcı bilgileri
                    // var fullName = $('#fullName').val();
                    // var email = $('#email').val();
                    // var tc = $('#tc').val();
                    // var phone = $('#phone').val();
                    // var address = $('#address').val();
                    // var notes = $('#notes').val();

                    var price = parseInt("{{ getData($housing, 'daily_rent') }}");
                    var checkInDate = $('#date-checkin').val();
                    var checkOutDate = $('#date-checkout').val();
                    var key = $("#orderKey").val();
                    var moneyTrusted = $("#money-trusted").is(':checked');

                    // Giriş ve çıkış tarihlerini Date objesine çevir
                    var startDate = new Date(checkInDate);
                    var endDate = new Date(checkOutDate);

                    // Minimum 7 gün tarih aralığı kontrolü
                    var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
                    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));


                    var moneyTrusted = $("#money-trusted").is(':checked');
                    var moneyIsSafe = moneyTrusted ? 1000 : 0;

                    // Gerekli alanları kontrol et
                    // if (!fullName || !email || !tc || !phone || !address) {
                    //     toastr.error("Lütfen tüm zorunlu alanları doldurun.")
                    //     return; // Fonksiyonu burada sonlandır
                    // }

                    // TC Kimlik Numarası için regular expression
                    // var tcRegex = /^[1-9]{1}[0-9]{9}[02468]{1}$/;

                    // Check if the provided tc matches the expected format
                    // if (!tcRegex.test(tc)) {
                    //     toastr.error("Lütfen geçerli bir TC Kimlik Numarası giriniz.");
                    //     return;
                    // }
                        console.log(key);

                    // Diğer bilgileri burada alabilir ve kullanabilirsiniz
                    var personCount = $('input[name="person_count"]').val();

                    // AJAX ile sunucuya gönder
                    $.ajax({
                        url: "{{ route('reservation.sessions') }}",
                        type: "POST",
                        data: {
                            _token: $('input[name="_token"]').val(),
                            check_in_date: checkInDate,
                            check_out_date: checkOutDate,
                            person_count: personCount,
                            housing_id: {{ $housing->id }},
                            owner_id: {{ $housing->user->id }},
                            price: price ,
                            total_price : price * diffDays,
                            money_is_safe : moneyIsSafe,
                            key: key,
                            // fullName: fullName,
                            // email: email,
                            // tc: tc,
                            // phone: phone,
                            // address: address,
                            money_trusted: moneyTrusted
                        },
                        success: function(response) {
                            // $('#finalConfirmationModal').modal('hide');
                            // $('.modal-backdrop').remove();
                            // location.reload();
                            if (!response.success) {
                                toastr.error(response.message);
                                // location.reload();
                            } else {
                                // $('#finalConfirmationModal').modal('hide');
                                // $('.modal-backdrop').remove();
                                toastr.success(response.message);
                                console.log(response);
                                window.location.href = "{{ route('payment.reservation.index', ['housing' => $housing->id ]) }}";
                            }

                        },
                        error: function(xhr, status, error) {
                            toastr.error(
                                'İşlem sırasında bir hata oluştu. Lütfen tekrar deneyin veya destek ekibimizle iletişime geçin.'
                            );
                        }

                    });
                });

            });

            $(document).ready(function() {
                // Başlangıçta ödeme düğmesini devre dışı bırak
                $('#completePaymentButton').prop('disabled', false);


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
                });

                $('#completePaymentButton').on('click', function() {
                    var checkAInput = $('#check-a');

                    if (!checkAInput.prop('checked')) {
                        toastr.error('Lütfen sözleşmeyi onaylayınız.');
                    } else {
                        // Diğer işlemleri yap
                        if ($('.bank-account.selected').length === 0) {
                            toastr.error('Lütfen banka seçimi yapınız.');
                        } else {
                            $('#paymentModal').removeClass('show').hide();
                            $('.modal-backdrop').removeClass('show');
                            $(".modal-backdrop").remove();
                            $('#finalConfirmationModal').modal('show');
                        }
                    }
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
                            var bookingFromDate = new Date(booking.from);
                            var targetDateWithoutTime = new Date(targetDate.getFullYear(), targetDate.getMonth(),
                                targetDate.getDate());

                            if (booking.status === 0) {
                                day.classList.add("flatpickr-disabled");
                                day.classList.add("yellow-bg");
                                addWarningTooltip(day, booking);

                                var bookingFromOneDayBefore = new Date(bookingFromDate);
                                bookingFromOneDayBefore.setDate(bookingFromDate.getDate() - 1);

                                if (targetDateWithoutTime >= bookingFromOneDayBefore || targetDateWithoutTime >
                                    bookingFromDate) {
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
                            var reservationFromDate = new Date(reservation.from);
                            var reservationToDate = new Date(reservation.to);
                            var targetDateWithoutTime = new Date(targetDate.getFullYear(), targetDate
                                .getMonth(), targetDate.getDate());

                            // Subtract one day from the reservation.from date
                            var reservationFromOneDayBefore = new Date(reservationFromDate);
                            reservationFromOneDayBefore.setDate(reservationFromDate.getDate() - 1);

                            if (targetDateWithoutTime >= reservationFromOneDayBefore && targetDateWithoutTime <=
                                reservationToDate) {
                                if (reservation.status === 0) {
                                    day.classList.add("flatpickr-disabled");
                                    day.classList.add("yellow-bg");
                                } else if (reservation.status === 1) {
                                    day.classList.add("red-bg");
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
                                var bookingFromDate = new Date(booking.from);
                                var targetDateWithoutTime = new Date(targetDate.getFullYear(), targetDate.getMonth(),
                                    targetDate.getDate());

                                if (booking.status === 0) {
                                    day.classList.add("flatpickr-disabled");
                                    day.classList.add("yellow-bg");
                                    addWarningTooltip(day, booking);

                                    var bookingFromOneDayBefore = new Date(bookingFromDate);
                                    bookingFromOneDayBefore.setDate(bookingFromDate.getDate() - 1);

                                    if (targetDateWithoutTime >= bookingFromOneDayBefore || targetDateWithoutTime >
                                        bookingFromDate) {
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
                                var reservationFromDate = new Date(reservation.from);
                                var reservationToDate = new Date(reservation.to);
                                var targetDateWithoutTime = new Date(targetDate.getFullYear(), targetDate
                                    .getMonth(), targetDate.getDate());

                                // Subtract one day from the reservation.from date
                                var reservationFromOneDayBefore = new Date(reservationFromDate);
                                reservationFromOneDayBefore.setDate(reservationFromDate.getDate() - 1);

                                if (targetDateWithoutTime >= reservationFromOneDayBefore &&
                                    targetDateWithoutTime <=
                                    reservationToDate) {
                                    if (reservation.status === 0) {
                                        day.classList.add("flatpickr-disabled");
                                        day.classList.add("yellow-bg");
                                    } else if (reservation.status === 1) {
                                        day.classList.add("red-bg");
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

                        if (endDate.getTime() !== startDate.getTime()) {
                            var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
                            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

                            console.log(diffDays)
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
                                $(".dayCount").html(diffDays);
                                $("#totalPrice").html(price * diffDays + " ₺");
                                $(".totalPrice").html(price * diffDays + " ₺");
                                $(".newTotalPrice").html((price * diffDays / 2) + " ₺");
                                $("#completePaymentButton").html((price * diffDays / 2) + " ₺" + " Öde");
                                $(".paySuccess ").html((price * diffDays / 2) + " ₺" + " Ödemeyi Tamamla");

                                var totalPriceElement = document.getElementById('mobileMoveID');
                                totalPriceElement.scrollIntoView({
                                    behavior: 'smooth'
                                });

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
    <script>
        $(document).ready(function() {
            $('#sehir').change(function() {
                var cityId = $(this).val();
                console.log(cityId)
                if (cityId) {
                    $.ajax({
                        url: '{{ route('get-districts', ':city_id') }}'.replace(':city_id',
                            cityId),
                        type: 'GET',
                        data: {
                            city_id: cityId
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data)
                            $('#ilce').empty().prop('disabled', false);
                            $.each(data, function(index, district) {
                                $('#ilce').append('<option value="' + district
                                    .ilce_key + '">' + district.ilce_title +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#ilce').empty().prop('disabled', true);
                }
            });

            $('#arsa_il').change(function() {
                var cityId = $(this).val();
                console.log(cityId)
                if (cityId) {
                    $.ajax({
                        url: '{{ route('get-districts', ':city_id') }}'.replace(':city_id',
                            cityId),
                        type: 'GET',
                        data: {
                            city_id: cityId
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data)
                            $('#arsa_ilce').empty().prop('disabled', false);
                            $.each(data, function(index, district) {
                                $('#arsa_ilce').append('<option value="' + district
                                    .ilce_key + '">' + district.ilce_title +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#ilce').empty().prop('disabled', true);
                }
            });



            // İlçe seçildiğinde mahallelerin yüklenmesi
            $('#arsa_ilce').change(function() {
                var districtId = $(this).val();
                console.log(districtId)
                if (districtId) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('get-neighborhoods', ['districtId' => '__districtId__']) }}"
                            .replace('__districtId__', districtId),
                        success: function(data) {
                            console.log(data)
                            if (data) {
                                $('#arsa_mahalle').html(
                                    '<option value="">Mahalle Seçiniz</option>');
                                $.each(data, function(index, neighborhoods) {
                                    $('#arsa_mahalle').append('<option value="' +
                                        neighborhoods.mahalle_id + '">' +
                                        neighborhoods.mahalle_title + '</option>');
                                });
                                $('#arsa_mahalle').prop('disabled', false);
                            } else {
                                $('#arsa_mahalle').html(
                                    '<option value="">Mahalle bulunamadı</option>');
                                $('#arsa_mahalle').prop('disabled', true);
                            }
                        }
                    });
                } else {
                    $('#arsa_mahalle').html('<option value="">Mahalle Seçiniz</option>');
                    $('#arsa_mahalle').prop('disabled', true);
                }
            });
        });
    </script>

    <script>
        // Price inputlarının istenilen biçimde gösterilmesini sağlayan jQuery kodu
        $(document).ready(function() {
            // Price inputlarının seçimi
            $('input[type="text"][name*="_rakami"]').on('input', function() {
                // Girilen değer
                var value = $(this).val().replace(/[^\d,]/g, ''); // Sadece rakamlar ve virgülü kabul et
                // Değerin binlik ayraçları ile formatlanması
                var formattedValue = addCommas(value);
                // Input alanına formatlanmış değerin eklenmesi
                $(this).val(formattedValue);
            });

            // Girilen değeri binlik ayraçları ile formatlayan fonksiyon
            function addCommas(num) {
                // Virgül ve nokta içeren bir regex paterni
                var pattern = /(\d)(?=(\d{3})+(?!\d))/g;
                // Değerdeki noktayı virgüle dönüştürme
                num = num.replace('.', ',');
                // Değeri binlik ayraçlarını ekleyerek formatlama
                return num.toString().replace(pattern, '$1.');
            }
        });
    </script>
    <script>
        document.getElementById('takas_tercihi').addEventListener('change', function() {
            var digerDiv = document.getElementById('digeryse');
            var barterDiv = document.getElementById('barteryse');
            var emlakDiv = document.getElementById('emlakyse');
            var aracDiv = document.getElementById('aracyse');
            var konutDiv = document.getElementById('konutyse');
            var arsaDiv = document.getElementById('arsayse');
            var isyeriDiv = document.getElementById('isyeriyse');

            if (this.value === 'diğer') {
                digerDiv.style.display = 'block';
                barterDiv.style.display = 'none';
                emlakDiv.style.display = 'none';
                aracDiv.style.display = 'none';
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'none';
            } else if (this.value === 'emlak') {
                digerDiv.style.display = 'none';
                barterDiv.style.display = 'none';
                emlakDiv.style.display = 'block';
                aracDiv.style.display = 'none';
            } else if (this.value === 'araç') {
                digerDiv.style.display = 'none';
                barterDiv.style.display = 'none';
                emlakDiv.style.display = 'none';
                aracDiv.style.display = 'block';
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'none';
            } else if (this.value === 'barter') {
                digerDiv.style.display = 'none';
                barterDiv.style.display = 'block';
                emlakDiv.style.display = 'none';
                aracDiv.style.display = 'none';
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'none';
            } else {
                digerDiv.style.display = 'none';
                emlakDiv.style.display = 'none';
                barterDiv.style.display = 'none';
                aracDiv.style.display = 'none';
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'none';
            }
        });

        document.getElementById('emlak_tipi').addEventListener('change', function() {
            var konutDiv = document.getElementById('konutyse');
            var arsaDiv = document.getElementById('arsayse');
            var isyeriDiv = document.getElementById('isyeriyse');

            if (this.value === 'konut') {
                konutDiv.style.display = 'block';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'none';
            } else if (this.value === 'arsa') {
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'block';
                isyeriDiv.style.display = 'none';
            } else if (this.value === 'işyeri') {
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'block';
            } else {
                konutDiv.style.display = 'none';
                arsaDiv.style.display = 'none';
                isyeriDiv.style.display = 'none';
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
        $(document).ready(function() {
            // jQuery Validation eklentisini form elemanlarına uygula
            $('#takasFormu').validate({
                // Türkçe hata mesajlarını tanımla
                messages: {
                    ad: {
                        required: "Lütfen adınızı girin."
                    },
                    soyad: {
                        required: "Lütfen soyadınızı girin."
                    },
                    telefon: {
                        required: "Lütfen telefon numaranızı girin."
                    },
                    email: {
                        required: "Lütfen e-posta adresinizi girin.",
                        email: "Lütfen geçerli bir e-posta adresi girin."
                    },
                    sehir: {
                        required: "Lütfen bir şehir seçin."
                    },
                    ilce: {
                        required: "Lütfen bir ilçe seçin."
                    },
                    takas_tercihi: {
                        required: "Lütfen takas tercihinizi belirtin."
                    }
                }
            });
        });
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/housing.css') }}">
    <style>
        #ad-error,
        #soyad-error,
        #email-error,
        #telefon-error,
        #sehir-error,
        #takas_tercihi-error {
            font-size: 10px !important;
        }

        .inner-pages .form-control {
            padding: 0 0.3rem !important
        }

        .formInput {
            display: block;
            width: 100%;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 2.0;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #b9b9b9;
            border-radius: .35rem;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.07);
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .formInput:focus {
            color: #495057;
            background-color: #fff;
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .25);
        }

        .profile-initial {
            font-size: 20px;
            color: #e54242;
            background: white;
            padding: 5px;
            border: 2px solid #e6e6e6;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto;
        }


        .error-message {
            color: #e54242;
            font-size: 11px;
        }

        .favorite-move {
            position: absolute;
            z-index: 9;
            margin-top: 0;
            right: 20px;
        }

        .gainStyle strong,
        .gainStyle span {
            color: green
        }

        .gainStyle svg {
            stroke: green
        }

        @media (max-width: 768px) {
            .favorite-move {

                margin-top: 15px;
                right: 15px;
            }

            .gainStyle strong,
            .gainStyle span {
                color: white
            }

            .gainStyle svg {
                stroke: white
            }

            .add-to-swap-wrapper {
                margin-bottom: 30px !important;
            }
        }
    </style>
@endsection
