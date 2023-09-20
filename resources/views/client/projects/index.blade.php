@extends('client.layouts.master')

@section('content')
<section class="recently portfolio bg-white homepage-5 ">
    <div class="container recently-slider">

        <div class="portfolio right-slider">
            <div class="owl-carousel home5-right-slider">
                @foreach($project->images as $image)
                <div class="inner-box">
                    <a href="single-property-1.html" class="recent-16" data-aos="fade-up" data-aos-delay="150">
                        <div class="recent-img16 img-fluid img-center" style="background-image: url({{URL::to('/').'/'.str_replace("public/", "storage/", $image->image)}});"></div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>


<section class="featured portfolio rec-pro disc bg-white">
    <div class="container">

        <div class="portfolio  col-xl-12">
            <div class="slick-agents">
                <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                    <div class="landscapes">
                        <div class="project-single">
                            <div class="project-inner project-head">
                                <div class="homes">
                                    <!-- homes img -->
                                    <a href="single-property-1.html" class="homes-img">


                                        <img src="{{URL::to('/')}}/images/blog/b-11.jpg" alt="home-1" class="img-responsive">
                                    </a>
                                </div>
                                <div class="button-effect">

                                </div>
                            </div>
                            <!-- homes content -->

                        </div>
                    </div>
                </div>
                <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                    <div class="landscapes">
                        <div class="project-single">
                            <div class="project-inner project-head">
                                <div class="homes">
                                    <!-- homes img -->
                                    <a href="single-property-1.html" class="homes-img">


                                        <img src="{{URL::to('/')}}/images/blog/b-11.jpg" alt="home-1" class="img-responsive">
                                    </a>
                                </div>
                                <div class="button-effect">

                                </div>
                            </div>
                            <!-- homes content -->

                        </div>
                    </div>
                </div>
                <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                    <div class="landscapes">
                        <div class="project-single">
                            <div class="project-inner project-head">
                                <div class="homes">
                                    <!-- homes img -->
                                    <a href="single-property-1.html" class="homes-img">


                                        <img src="{{URL::to('/')}}/images/blog/b-11.jpg" alt="home-1" class="img-responsive">
                                    </a>
                                </div>
                                <div class="button-effect">

                                </div>
                            </div>
                            <!-- homes content -->

                        </div>
                    </div>
                </div>
                <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                    <div class="landscapes">
                        <div class="project-single">
                            <div class="project-inner project-head">
                                <div class="homes">
                                    <!-- homes img -->
                                    <a href="single-property-1.html" class="homes-img">


                                        <img src="{{URL::to('/')}}/images/blog/b-11.jpg" alt="home-1" class="img-responsive">
                                    </a>
                                </div>
                                <div class="button-effect">

                                </div>
                            </div>
                            <!-- homes content -->

                        </div>
                    </div>
                </div>
                <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                    <div class="landscapes">
                        <div class="project-single">
                            <div class="project-inner project-head">
                                <div class="homes">
                                    <!-- homes img -->
                                    <a href="single-property-1.html" class="homes-img">


                                        <img src="{{URL::to('/')}}/images/blog/b-11.jpg" alt="home-1" class="img-responsive">
                                    </a>
                                </div>
                                <div class="button-effect">

                                </div>
                            </div>
                            <!-- homes content -->

                        </div>
                    </div>
                </div>
                <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                    <div class="landscapes">
                        <div class="project-single">
                            <div class="project-inner project-head">
                                <div class="homes">
                                    <!-- homes img -->
                                    <a href="single-property-1.html" class="homes-img">


                                        <img src="{{URL::to('/')}}/images/blog/b-11.jpg" alt="home-1" class="img-responsive">
                                    </a>
                                </div>
                                <div class="button-effect">

                                </div>
                            </div>
                            <!-- homes content -->

                        </div>
                    </div>
                </div>







            </div>
        </div>
    </div>
</section>
@php
    function getData($project,$key,$roomOrder){
        foreach ($project->roomInfo as  $room) {
            if($room->room_order == $roomOrder && $room->name == $key){
                return $room;
            }
        }
    }
@endphp
<section class="properties-right list featured portfolio blog pt-5 bg-white">
    <div class="container">

        <div class="row project-filter-reverse">

            <div class="col-lg-12 col-md-12 blog-pots">
                @for($i = 0; $i < $project->room_count; $i++)
                <div class="project-card mb-3">
                    <div class="row">

                        <div class="col-md-4 d-flex" style="height: 100%;">
                            <div class="" style="background-color: #446BB6; border-radius: 0px 8px 0px 8px;">
                                <p style="padding: 10px; color: white; height: 100%; display: flex; align-items: center; ">
                                    {{$i+1}}</p>
                            </div>
                            <div class="project-single mb-0 bb-0 aos-init aos-animate" data-aos="fade-up">
                                <div class="project-inner project-head">
                                    <div class="homes">
                                        <!-- homes img -->
                                        <a href="single-property-1.html" class="homes-img">

                                            <img src="{{URL::to('/').'/project_housing_images/'.getData($project,'image[]',$i+1)->value}}" alt="home-1" class="img-responsive">
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-12 homes-content pb-0 mb-44 aos-init aos-animate" data-aos="fade-up">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="homes-list-div">

                                    <ul class="homes-list clearfix pb-3 d-flex">
                                        <li class="the-icons">
                                            <i class="fas fa-home mr-2" style="color: #446BB6;" aria-hidden="true"></i>
                                            <span>{{$project->housingType->title}}</span>
                                        </li>
                                        <li class="the-icons">
                                            <i class="flaticon-bed mr-2" aria-hidden="true"></i>
                                            <span>{{getData($project,'room_count[]',$i+1)->value}}</span>
                                        </li>
                                        <li class="the-icons">
                                            <i class="flaticon-bathtub mr-2" aria-hidden="true"></i>
                                            <span>{{getData($project,'numberoffloors[]',$i+1)->value}}.Kat</span>
                                        </li>
                                        <li class="the-icons">
                                            <i class="flaticon-square mr-2" aria-hidden="true"></i>
                                            <span>{{getData($project,'squaremeters[]',$i+1)->value}}m2</span>
                                        </li>
                                        <!-- <li class="the-icons">
                                            <i class="flaticon-car mr-2" aria-hidden="true"></i>
                                            <span>2 Garages</span>
                                        </li> -->
                                    </ul>
                                </div>
                                <div class="homes-button">

                                    <button style="padding: 10px; background-color: #ccef69; border: none;">
                                        <h6>Ödeme detaylarını gor</h6>
                                    </button>
                                    <div class="mt-3">
                                        <div class="" style="">
                                            <div style="border :1px solid #2bf327; border-radius: 10px 10px 0 0 ; padding: 2px; text-align:center;width: 172px;;">
                                                <h6 style="color: black;">{{getData($project,'price[]',$i+1)->value}} TL</h6>
                                            </div>

                                        </div>
                                        <button id="addToCart" data-type="project" data-id="{{$project->id}}" style="background-color: #2bf327; padding: 4px; width: 172px;text-align:center;;  ">
                                            <h6 style="color: black;">%1 Sepete Ekle</h6>

                                        </button>

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
                @endfor



            </div>

        </div>

    </div>
</section>


<section class="ui-elements">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 ">
                <div class="listing-title-bar mb-3">
                    <h3>KONUM</h3>
                </div>
                <div class="tabbed-content button-tabs">
                    <ul class="tabs">
                        <li class="active">
                            <div class="tab-title">
                                <span>Ulaşım</span>
                            </div>

                        </li>
                        <li class="">
                            <div class="tab-title">
                                <span>Alışveriş</span>
                            </div>

                        </li>
                        <li class="">
                            <div class="tab-title">
                                <span>Eğitim</span>
                            </div>

                        </li>
                        <li class="">
                            <div class="tab-title">
                                <span>Sağlık</span>
                            </div>

                        </li>
                    </ul>
                    <div id="map" style="height: 300px" class="contactmap">

                    </div>
                    <ul class="content mt-3" style="list-style: none">
                        <li class="active">
                            <div class="tab-content">
                                <div class="slick-lancersx">

                                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="location-card">
                                                        <div class="location-card-head">
                                                            <img src="./{{URL::to('/')}}/images/1.png" alt="">
                                                        </div>
                                                        <div class="location-card-body">
                                                            <p>Kartal Merkez</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="location-card">
                                                        <div class="location-card-head">
                                                            <img src="./{{URL::to('/')}}/images/1.png" alt="">
                                                        </div>
                                                        <div class="location-card-body">
                                                            <p>Kartal Merkez</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="location-card">
                                                        <div class="location-card-head">
                                                            <img src="./{{URL::to('/')}}/images/1.png" alt="">
                                                        </div>
                                                        <div class="location-card-body">
                                                            <p>Kartal Merkez</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="location-card">
                                                        <div class="location-card-head">
                                                            <img src="./{{URL::to('/')}}/images/1.png" alt="">
                                                        </div>
                                                        <div class="location-card-body">
                                                            <p>Kartal Merkez</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="location-card">
                                                        <div class="location-card-head">
                                                            <img src="./{{URL::to('/')}}/images/1.png" alt="">
                                                        </div>
                                                        <div class="location-card-body">
                                                            <p>Kartal Merkez</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="location-card">
                                                        <div class="location-card-head">
                                                            <img src="./{{URL::to('/')}}/images/1.png" alt="">
                                                        </div>
                                                        <div class="location-card-body">
                                                            <p>Kartal Merkez</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="location-card">
                                                        <div class="location-card-head">
                                                            <img src="./{{URL::to('/')}}/images/1.png" alt="">
                                                        </div>
                                                        <div class="location-card-body">
                                                            <p>Kartal Merkez</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                            <div class="location-card">
                                                <div class="location-card-head">
                                                    <img src="./{{URL::to('/')}}/images/1.png" alt="">
                                                </div>
                                                <div class="location-card-body">
                                                    <p>Kartal Merkez</p>
                                                </div>
                                            </div>
                                            <div class="project-single">
                                                <div class="project-inner project-head">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="location-card">
                                                        <div class="location-card-head">
                                                            <img src="./{{URL::to('/')}}/images/1.png" alt="">
                                                        </div>
                                                        <div class="location-card-body">
                                                            <p>Kartal Merkez</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
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
