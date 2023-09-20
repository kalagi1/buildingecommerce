@extends('client.layouts.master')

@section('content')

@php
    function getData($project,$key,$roomOrder){
        foreach ($project->roomInfo as  $room) {
            if($room->room_order == $roomOrder && $room->name == $key){
                return $room;
            }
        }
    }

    $housingImages = getData($project,'images[]',$housingOrder);
    $housingImages = json_decode($housingImages->value);
@endphp

<section class="single-proper blog details bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="container">
                    <section class="headings-2 pt-0">
                        <div class="pro-wrapper" style="width: 100%; justify-content: space-between;">
                            <div class="detail-wrapper-body">
                                <div class="listing-title-bar">
                                    <h3>{{$project->project_title}} Projesinde {{getData($project,'squaremeters[]',$housingOrder)->value}}m2 {{getData($project,'room_count[]',$housingOrder)->value}} {{$project->housingType->title}} </h3>
                                    <div class="mt-0">
                                        <a href="#listing-location" class="listing-address">
                                            <i
                                                class="fa fa-map-marker pr-2 ti-location-pin mrg-r-5"></i>{{ucfirst(strtolower($project->city->title))}}
                                            / {{ucfirst(strtolower($project->county->title))}} / {{$project->address}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="single detail-wrapper mr-2">
                                <div class="detail-wrapper-body">
                                    <div class="listing-title-bar">
                                        <h4>{{getData($project,'price[]',$housingOrder)->value}} TL</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6">
                        @if(!session('cart')['item']['id']==$project->id)
                            <button class="addToCart" style="background-color: #2bf327; padding: 8px 0;text-align:center;  "
                            data-type="project"
                            data-id="{{$project->id}}"
                            >
                                <h6 style="color: black;margin:0;">Sepete Ekle</h6>
                    </button>
                        @else
                            <div style="background-color: #2bf327; padding: 8px 0;text-align:center;  ">
                                <h6 style="color: black;margin:0;">Sepette</h6>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="add-to-cart" style="background-color: #2bf327; padding: 8px 0;text-align:center;  ">
                            <h6 style="color: black;margin:0;">Favorilere Ekle</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-12 blog-pots">
                <div class="row">
                    <div class="col-md-12">
                        <!-- main slider carousel items -->
                        <div id="listingDetailsSlider" class="carousel listing-details-sliders slide mb-30">
                            <!-- <h5 class="mb-4">Gallery</h5> -->
                            <div class="carousel-inner">
                                @foreach($housingImages as $key => $housingImage)
                                    <div class="@if($key == 0) active @endif item carousel-item" data-slide-number="0">
                                        <img src="{{URL::to('/').'/project_housing_images/'.$housingImage}}" class="img-fluid" alt="slider-listing">
                                    </div>
                                @endforeach


                                <a class="carousel-control left" href="#listingDetailsSlider"
                                    data-slide="prev"><i class="fa fa-angle-left"></i></a>
                                <a class="carousel-control right" href="#listingDetailsSlider"
                                    data-slide="next"><i class="fa fa-angle-right"></i></a>

                            </div>
                            <!-- main slider carousel nav controls -->
                            <ul class="carousel-indicators smail-listing list-inline">
                                @foreach($housingImages as $key => $housingImage)

                                    <li class="list-inline-item active">
                                        <a id="carousel-selector-0" class="selected" data-slide-to="0"
                                            data-target="#listingDetailsSlider">
                                            <img src="{{URL::to('/').'/project_housing_images/'.$housingImage}}" class="img-fluid" alt="listing-small">
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                            <!-- main slider carousel items -->
                        </div>

                    </div>
                </div>


            </div>
            <aside class="col-lg-4 col-md-12 car">
                <div class="single widget">
                    <!-- Start: Schedule a Tour -->
                    <div class="schedule widget-boxed mt-33 mt-0" style="text-align: center;">
                        <div class="widget-boxed-header">
                            <h4><i class="fa fa-calendar pr-3 padd-r-10"></i>İletişim Bilgileri</h4>
                        </div>
                        <div class="widget-boxed-body">
                            <h5 class="" style="font-size: 20px; font-weight: 600;">{{$project->brand->title}}</h5>
                            <p>0507 585 40 33</p>
                        </div>
                    </div>
                    <!-- End: Schedule a Tour -->
                    <!-- end author-verified-badge -->
                    <div class="sidebar">
                        <div class="widget-boxed mt-33 mt-5">
                            <div class="divider-fade"></div>
                            <div id="map" class="contactmap" style="height: 300px">
                            </div>

                        </div>

                    </div>
                </div>
            </aside>
        </div>

        <section class="similar-property featured portfolio p-0 bg-white">
            <div class="blog-info details mb-30">
                <h5 class="mb-4">Açıklama</h5>
                <p class="mb-3">{!! $project->description !!}</p>
            </div>
            <div class="single homes-content details mb-30">
                <!-- title -->
                <h5 class="mb-4">Bina Özellikleri</h5>
                <ul class="homes-list clearfix">
                    @php 
                        function implodeData($array){
                            $html = "";

                            for($i = 0; $i < count($array); $i++){
                                if($i == 0){
                                    $html .= " ".$array[$i][0];
                                }else{
                                    $html .= ",".$array[$i][0];
                                }
                            }

                            return $html;
                        }
                    @endphp
                    @foreach($projectHousingSetting as $housingSetting)
                    @php 
                        $isArrayCheck = $housingSetting->is_array;
                        $onProject = false;
                        if($isArrayCheck){
                            $onProject = false;
                            $value = json_decode($projectHousing[$housingSetting->column_name.'[]']['value']);
                            $value = implodeData($value);
                        }else if($housingSetting->is_parent_table){
                            $value = $project[$housingSetting->column_name];
                            $onProject = true;
                        }
                    @endphp
                        <li style="border: none !important;" >
                            @if($onProject)
                                <span class="font-weight-bold mr-1">{{$housingSetting->label}}:</span>
                            @else
                                <span class="font-weight-bold mr-1">{{$projectHousing[$housingSetting->column_name.'[]']['key']}}:</span>
                            @endif
                            <span class="det">
                                {{$value}}
                            </span>
                        </li>
                    @endforeach

                </ul>

            </div>

        </section>

    </div>
</section>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    @php
        $location = explode(',',$project->location);
        $location['latitude'] = $location[0];
        $location['longitude'] = $location[1];

        $location = json_encode($location);
        $location = json_decode($location);
    @endphp
    var map = L.map('map').setView([{{ $location->latitude }},{{ $location->longitude }}], 13);
    var marker = L.marker([{{ $location->latitude }}, {{ $location->longitude }}]).addTo(map);

    // OpenStreetMap katmanını haritaya ekleyin
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var overpassUrl = 'https://overpass-api.de/api/interpreter';
var query = `[out:json];
(
    node["public_transport"](around:1000,{{ $location->latitude }},{{ $location->longitude }});
    way["public_transport"](around:1000,{{ $location->latitude }},{{ $location->longitude }});
    relation["public_transport"](around:1000,{{ $location->latitude }},{{ $location->longitude }});
);
out center;`;
var url = `${overpassUrl}?data=${encodeURIComponent(query)}`;

fetch(url)
    .then(response => response.json())
    .then(data => {
        var listingsContainer = document.querySelector('.slick-lancersx'); // Listeyi içeren div
        listingsContainer.innerHTML = ''; // Önceki içeriği temizleyin
        data.elements.forEach(element => {
            var lat = element.lat;
            var lon = element.lon;
            var name = element.tags.name || 'Bilinmeyen Mağaza';

            // Yeni bir liste öğesi oluşturun
            var listingItem = document.createElement('div');
            listingItem.classList.add('agents-grid');
            listingItem.dataset.aos = 'fade-up';
            listingItem.dataset.aosDelay = '150';
            if(element.tags.highway == "bus_stop" || element.tags.type == "public_transport"){
                // Liste içeriğini oluşturun
                listingItem.innerHTML = `
                    <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                        <div class="project-single">
                            <div class="project-inner project-head">
                                <div class="location-card">
                                    <div class="location-card-head">
                                        <img src="https://www.sahibinden.com/assets/images/durak:7299b7f721d8e670e9d070f1f816991a.png" alt="">
                                    </div>
                                    <div class="location-card-body">
                                        ${element.tags.type == "public_transport" ? `<p>${name} Metro Durağı </p>` : `<p>${name} Otobüs Durağı</p>`}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;


                // Listeyi ekrana ekleyin
                listingsContainer.appendChild(listingItem);
            }




        });

        $('.slick-lancersx').slick({
            infinite: false,
            slidesToShow: 6,
            slidesToScroll: 1,
            dots: true,
            arrows: true,
            adaptiveHeight: true,
            responsive: [
                {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    dots: true,
                    arrows: false
                }
                },
                {
                breakpoint: 993,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    dots: true,
                    arrows: false
                }
                },
                {
                breakpoint: 769,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    arrows: false
                }
                }
        ]
        });
    })
    .catch(error => console.error('Hata:', error));
    <script>
        $("#addToCart").click(function() {
            // Sepete eklenecek verileri burada hazırlayabilirsiniz
            var cart = {
                id: $(this).data('id'),
                type: $(this).data('type'),

                _token: "{{ csrf_token() }}"
            };

            // Ajax isteği gönderme
            $.ajax({
                url: "{{ route('add.to.cart') }}", // Sepete veri eklemek için uygun URL'yi belirtin
                type: "POST", // Veriyi göndermek için POST kullanabilirsiniz
                data: cart, // Sepete eklemek istediğiniz ürün verilerini gönderin
                success: function(response) {
                    // İşlem başarılı olduğunda buraya gelir
                    toast.success(response)
                    console.log("Ürün sepete eklendi: " + response);
                },
                error: function(error) {
                    // Hata durumunda buraya gelir
                    toast.error(error)
                    console.error("Hata oluştu: " + error);
                }
            });
        });
    </script>
    
</script>
<script>
    $("#addToCart").click(function() {
        // Sepete eklenecek verileri burada hazırlayabilirsiniz
        var cart = {
            id: $(this).data('id'),
            type: $(this).data('type'),

            _token: "{{ csrf_token() }}"
        };

        // Ajax isteği gönderme
        $.ajax({
            url: "{{ route('add.to.cart') }}", // Sepete veri eklemek için uygun URL'yi belirtin
            type: "POST", // Veriyi göndermek için POST kullanabilirsiniz
            data: cart, // Sepete eklemek istediğiniz ürün verilerini gönderin
            success: function(response) {
                // İşlem başarılı olduğunda buraya gelir
                toast.success(response)
                console.log("Ürün sepete eklendi: " + response);
            },
            error: function(error) {
                // Hata durumunda buraya gelir
                toast.error(error)
                console.error("Hata oluştu: " + error);
            }
        });
    });
</script>
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endsection
