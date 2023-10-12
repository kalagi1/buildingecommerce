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
                <div class="row">
                        <div class="col-md-2">
                            <style>
                                .button-effect
                                {
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
                            <div class="button-effect toggle-favorite"
                                data-housing-id={{ $housing->id }}>
                                <i class="fa fa-heart"></i>
                            </div>
                        </div>
                        <div class="col-md-10">
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
                                <!-- <h5 class="mb-4">Gallery</h5> -->
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


                </div>
                <aside class="col-md-4  car">
                    <div class="single widget">
                        <!-- Start: Schedule a Tour -->
                        <div class="schedule widget-boxed mt-33 mt-0">
                            

                            <div class="widget-boxed-body">

                                <div class="the-agents">
                                    <ul class="the-agents-details">
                                        <li><a href="#"><strong>Adres:</strong> {!! $housing->address !!} </a></li>
                                        <li><a href="#"><strong>Telefon:</strong> {!! $housing->user->phone !!} </a></li>
                                        <li><a href="#"><strong>E-Mail:</strong> {!! $housing->user->email !!} </a></li>



                                    </ul>
                                </div>

                            </div>
                        </div>
                        <!-- End: Schedule a Tour -->
                        <!-- end author-verified-badge -->
                        <div class="sidebar">
                            <div class="widget-boxed mt-33 mt-5">
                                <div class="divider-fade"></div>
                                <div id="map" class="contactmap">
                                    <iframe
                                        src="https://maps.google.com/maps?q={{ $housing->latitude }},{{ $housing->longitude }}&hl=trh&z=14&amp;output=embed"
                                        width="100%" height="300px" style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>

                            </div>

                        </div>
                    </div>
                </aside>
            </div>

            <section class="similar-property featured portfolio p-0 bg-white">
                <div class="blog-info details mb-30">
                    <h5 class="mb-4">Açıklama</h5>
                    <p class="mb-3">{{ $housing->description }}</p>
                </div>
                <div class="single homes-content details mb-30">
                    <!-- title -->
                    <h5 class="mb-4">Bina Özellikleri</h5>
                    <ul class="homes-list clearfix">
                        @foreach (json_decode($housing->housing_type_data) as $key => $val)
                            <li style="border: none !important;">
                                <span class="font-weight-bold mr-1">{{ $key }}:</span>
                                <span class="det">{{ json_encode($val[0]) }}</span>
                            </li>
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
                                                    version="1.1" viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <rect fill="none" height="50" width="50" />
                                                    <polygon fill="gold"
                                                        points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                        stroke="gold" stroke-miterlimit="10" stroke-width="2" />
                                                </svg>
                                            @endfor
                                            @for ($i = 0; $i < 5 - $comment->rate; ++$i)
                                                <svg enable-background="new 0 0 50 50" height="24px" id="Layer_1"
                                                    version="1.1" viewBox="0 0 50 50" width="24px"
                                                    xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
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
                                            <div class="col-md-2">
                                                <a href="<?= asset('storage/' . preg_replace('@^public/@', null, $img)) ?>" data-lightbox="gallery">
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
                                <svg class="rating" enable-background="new 0 0 50 50" height="24px" id="Layer_1"
                                    version="1.1" viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <rect fill="none" height="50" width="50" />
                                    <polygon fill="none"
                                        points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                        stroke="#000000" stroke-miterlimit="10" stroke-width="2" />
                                </svg>
                                <svg class="rating" enable-background="new 0 0 50 50" height="24px" id="Layer_1"
                                    version="1.1" viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <rect fill="none" height="50" width="50" />
                                    <polygon fill="none"
                                        points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                        stroke="#000000" stroke-miterlimit="10" stroke-width="2" />
                                </svg>
                                <svg class="rating" enable-background="new 0 0 50 50" height="24px" id="Layer_1"
                                    version="1.1" viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <rect fill="none" height="50" width="50" />
                                    <polygon fill="none"
                                        points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                        stroke="#000000" stroke-miterlimit="10" stroke-width="2" />
                                </svg>
                                <svg class="rating" enable-background="new 0 0 50 50" height="24px" id="Layer_1"
                                    version="1.1" viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <rect fill="none" height="50" width="50" />
                                    <polygon fill="none"
                                        points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                        stroke="#000000" stroke-miterlimit="10" stroke-width="2" />
                                </svg>
                                <svg class="rating" enable-background="new 0 0 50 50" height="24px" id="Layer_1"
                                    version="1.1" viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
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
            </section>

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
