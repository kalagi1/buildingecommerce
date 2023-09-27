@extends('client.layouts.master')

@section('content')
    <div class="brand-head">
        <div class="container">
            <div class="card mb-3">
                <img src="https://genetikonvet.com/wp-content/uploads/revslider/slider-hardware/black-electronics-s-3-bg.jpg"
                    class="card-img-top" alt="...">
                <div class="brands-square">
                    <img src="/images/4.png" alt="" class="brand-logo">
                    <p class="brand-name"><a href="{{ route('instituional.profile', Str::slug($project->user->name)) }}"
                            style="color:White">{{ $project->user->name }}</a></p>
                    <p class="brand-name"><i class="fa fa-angle-right"></i> </p>
                    <p class="brand-name">{{ $project->project_title }}</p>

                </div>
                <div class="card-body">
                    <nav class="navbar">
                        <div class="navbar-items">

                            <a class="navbar-item"
                                href="{{ route('instituional.projects.detail', Str::slug($project->user->name)) }}">Tüm
                                Projeler</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.profile', Str::slug($project->user->name)) }}">Satıcı
                                Profili</a>
                        </div>
                        <form class="search-form" action="{{ route('instituional.search') }}" method="GET">
                            @csrf
                            <input class="search-input" type="search" placeholder="Mağazada Ara" aria-label="Search"
                                name="q">
                            <div class="header-search__suggestions">
                                <div class="header-search__suggestions__section">
                                    <h5>Markalar</h5>
                                    <div class="header-search__suggestions__section__items">
                                        @foreach ($project->user->brands as $item)
                                            <a href="#"><span>{{ $item->title }}</span></a>
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

    <section class="recently portfolio bg-white homepage-5 ">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <!-- main slider carousel items -->
                    <div id="listingDetailsSlider" class="carousel listing-details-sliders slide mb-30">
                        <!-- <h5 class="mb-4">Gallery</h5> -->
                        <div class="carousel-inner">
                            @foreach ($project->images as $key => $item)
                                <div class="@if ($key == 0) active @endif item carousel-item"
                                    data-slide-number="0">
                                    <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                        class="img-fluid" alt="slider-listing">
                                </div>
                            @endforeach

                            <a class="carousel-control left" href="#listingDetailsSlider" data-slide="prev"><i
                                    class="fa fa-angle-left"></i></a>
                            <a class="carousel-control right" href="#listingDetailsSlider" data-slide="next"><i
                                    class="fa fa-angle-right"></i></a>

                        </div>
                        <!-- main slider carousel nav controls -->
                        <ul class="carousel-indicators smail-listing list-inline">
                            @foreach ($project->images as $key => $item)
                                <li class="list-inline-item @if ($key == 0) active @endif ">
                                    <a id="carousel-selector-{{ $key }}"
                                        @if ($key == 0) class="selected" @endif
                                        data-slide-to="{{ $key }}" data-target="#listingDetailsSlider">
                                        <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                            class="img-fluid" alt="listing-small">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <!-- main slider carousel items -->
                    </div>

                </div>
                <div class="col-md-5">
                    <div class="blog-section">
                        <div class="news-item news-item-sm">
                            <div class="news-item-text">
                                <a href="{{ route('project.housing.detail', $project->slug) }}">
                                    <h3>{{ $project->project_title }}</h3>
                                </a>
                                <div class="the-agents">
                                    <ul class="the-agents-details">
                                        <?php
                                        $totalHousingCount = 0;

                                        foreach ($project->user->projects as $userProject) {
                                            $totalHousingCount += count($userProject->housings);
                                        }
                                        ?>

                                        <li><a href="#"><strong>Adres:</strong> {!! $project->address !!} </a></li>
                                        <li><a href="#"><strong>Proje Sayısı:</strong>
                                                {{ count($project->user->projects) }}</a></li>
                                        <li><a href="#"><strong>Konut Sayısı:</strong> {{ $totalHousingCount }}</a>
                                        </li>
                                        <li><a href="#"><strong>Konut Tipi:</strong>
                                                {{ $project->housingtype->title }} </a></li>


                                    </ul>
                                </div>
                                <div class="news-item-bottom">
                                    <a href="{{ route('project.housing.detail', $project->slug) }}" class="news-link">Proje
                                        Detayı</a>
                                    <div class="admin">
                                        <p>{!! $project->brand->title !!}</p>
                                        <img src="{{ URL::to('/') . '/storage/brand_images/' . $project->brand->logo }}"
                                            alt="">
                                    </div>
                                </div>
                                <div class="divider-fade mt-5"></div>
                                <div id="map" class="contactmap">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3015.3091375028957!2d29.17737287645882!3d40.908967225533395!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14cac554b56486c5%3A0x19df79713477599e!2sMaliyetine%20Ev!5e0!3m2!1str!2str!4v1692189778851!5m2!1str!2str"
                                        width="100%" height="215px" style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class=" blog details bg-white">
        <div class="container">
            <div class="similar-property featured portfolio p-0 bg-white">
                <div class="blog-info details mb-30">
                    <h5 class="mb-4">Açıklama</h5>
                    <p class="mb-3">{!! $project->description !!}</p>
                </div>

            </div>
        </div>
    </section>

    @php
        function getData($project, $key, $roomOrder)
        {
            foreach ($project->roomInfo as $room) {
                if ($room->room_order == $roomOrder && $room->name == $key) {
                    return $room;
                }
            }
        }
    @endphp


    <section class="properties-right list featured portfolio blog pt-5 pb-5 bg-white">
        <div class="container">

            <div class="row project-filter-reverse blog-pots">

                @for ($i = 0; $i < $project->room_count; $i++)
                    <div class="col-md-12 col-12">
                        <div class="project-card mb-3">
                            <div class="row">
                                <a href="{{ route('project.housings.detail', [$project->slug, $i + 1]) }}"
                                    class="col-md-3">
                                    <div class=" d-flex" style="height: 100%;">
                                        <div class=""
                                            style="background-color: #446BB6; border-radius: 0px 8px 0px 8px;">
                                            <p
                                                style="padding: 10px; color: white; height: 100%; display: flex; align-items: center; ">
                                                {{ $i + 1 }}</p>
                                        </div>
                                        <div class="project-single mb-0 bb-0 aos-init aos-animate" data-aos="fade-up">
                                            <div class="project-inner project-head">


                                                <div class="homes">
                                                    <!-- homes img -->
                                                    <img src="{{ URL::to('/') . '/project_housing_images/' . getData($project, 'image[]', $i + 1)->value }}"
                                                        alt="home-1" class="img-responsive"
                                                        style="height: 120px;object-fit:cover">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="col-lg-9 col-md-12 homes-content pb-0 mb-44 aos-init aos-animate"
                                    data-aos="fade-up">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-md-7">
                                            <div class="homes-list-div">

                                                <ul class="homes-list clearfix pb-3 d-flex">
                                                    <li class="the-icons">
                                                        <i class="fas fa-home mr-2" style="color: #446BB6;"
                                                            aria-hidden="true"></i>
                                                        <span>{{ $project->housingType->title }}</span>
                                                    </li>
                                                    <li class="the-icons">
                                                        <i class="flaticon-bed mr-2" aria-hidden="true"></i>
                                                        <span>{{ getData($project, 'room_count[]', $i + 1)->value }}</span>
                                                    </li>
                                                    <li class="the-icons">
                                                        <i class="flaticon-bathtub mr-2" aria-hidden="true"></i>
                                                        <span>{{ getData($project, 'numberoffloors[]', $i + 1)->value }}.Kat</span>
                                                    </li>
                                                    <li class="the-icons">
                                                        <i class="flaticon-square mr-2" aria-hidden="true"></i>
                                                        <span>{{ getData($project, 'squaremeters[]', $i + 1)->value }}m2</span>
                                                    </li>
                                                    <!-- <li class="the-icons">
                                                                                                                                                <i class="flaticon-car mr-2" aria-hidden="true"></i>
                                                                                                                                                <span>2 Garages</span>
                                                                                                                                            </li> -->
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="height: 120px">
                                            <div class="homes-button">

                                                <button class="first-btn">
                                                    <h6>Ödeme Detaylarını Gör</h6>
                                                </button>
                                                <div class="second-btn">
                                                    <div class="" style="">
                                                        <div class="second-price-btn">
                                                            <h6
                                                                style="color: black;position: relative;top:4px;font-weight:600">
                                                                {{ getData($project, 'price[]', $i + 1)->value }} TL</h6>
                                                        </div>

                                                    </div>
                                                    <button id="addToCart" data-type="project"
                                                        data-id="{{ $project->id }}">
                                                        <h6
                                                            style="color: black;font-weight:600;top:3px;position: relative;">
                                                            Sepete Ekle
                                                        </h6>

                                                    </button>

                                                </div>
                                            </div>
                                        </div>


                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                @endfor




            </div>

        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        @php
            $location = explode(',', $project->location);
            $location['latitude'] = $location[0];
            $location['longitude'] = $location[1];

            $location = json_encode($location);
            $location = json_decode($location);
        @endphp
        var map = L.map('map').setView([{{ $location->latitude }}, {{ $location->longitude }}], 13);
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
                    if (element.tags.highway == "bus_stop" || element.tags.type == "public_transport") {
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
                    dots: false,
                    arrows: true,
                    adaptiveHeight: true,
                    responsive: [{
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2,
                                dots:false,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 993,
                            settings: {
                                slidesToShow: 4,
                                slidesToScroll: 4,
                                dots:false,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 769,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
                                dots:false,
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
