@extends('client.layouts.master')

@section('content')
    <div class="brand-head">
        <div class="container">
            <div class="card mb-3">
                <div class="card-img-top" style="background-color: {{ $project->user->banner_hex_code }}">
                    <div class="brands-square">
                        <img src="{{ url('storage/profile_images/' . $project->user->profile_image) }}" alt=""
                            class="brand-logo">
                        <p class="brand-name"><a href="{{ route('instituional.profile', Str::slug($project->user->name)) }}"
                                style="color:White">
                                {{ $project->user->name }}
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
                            </a></p>
                        <div class="mobile-hidden">
                            <p class="brand-name"><i class="fa fa-angle-right"></i> </p>
                            <p class="brand-name">{{ $project->project_title }}</p>
                        </div>
                    </div>

                
                </div>
                <div class="card-body">
                    <nav class="navbar" style="padding: 0 !important">
                        <div class="navbar-items">
                            <a class="navbar-item"
                                href="{{ route('instituional.dashboard', Str::slug($project->user->name)) }}">Anasayfa</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.projects.detail', Str::slug($project->user->name)) }}">Tüm
                                Projeler</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.profile', Str::slug($project->user->name)) }}">Mağaza
                                Profili</a>
                        </div>
                        <form class="search-form" action="{{ route('instituional.search') }}" method="GET">
                            @csrf
                            <input class="search-input" type="search" placeholder="Mağazada Ara" id="search-project"
                                aria-label="Search" name="q">
                            <div class="header-search__suggestions">
                                <div class="header-search__suggestions__section">
                                    <h5>Projeler</h5>
                                    <div class="header-search__suggestions__section__items">
                                        @foreach ($project->user->projects as $item)
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


    <section class="recently portfolio bg-white homepage-5 ">
        <div class="container">
            <div class="blog-section">
                <div class="news-item news-item-sm">
                    <div class="news-img-link">
                        <div class="news-item-img homes">
                            <div class="homes-tag button alt featured">
                                <a href="{{ route('instituional.profile', Str::slug($project->user->name)) }}"
                                    style="color:White">{{ $project->user->name }}</a>
                            </div>
                            <img class="resp-img"
                                src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                alt="blog image">
                        </div>
                    </div>
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

                                <li><strong>İl-İlçe:</strong> {!! $project->city->title !!} {{ '/' }}
                                    {!! $project->county->ilce_title !!} </li>
                                <li><strong>Konut Sayısı:</strong> {{ $project->room_count }} </li>
                                <li><strong>Konut Tipi:</strong> {{ $project->housingtype->title }}
                                </li>

                            </ul>
                        </div>
                        <div class="news-item-bottom">
                            <a href="{{ route('project.housing.detail', $project->slug) }}" class="news-link">Proje
                                Detayı</a>
                            <div class="admin">
                                <p>{!! $project->user->name !!}</p>
                                <img src="{{ URL::to('/') . '/storage/profile_images/' . $project->user->profile_image }}"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="ui-elements">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 ">
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
                                            <div class="landscapes"
                                                style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                                <div class="project-single">
                                                    <div class="project-inner project-head">
                                                        <div class="location-card">
                                                            <div class="location-card-head">
                                                                <img src="./{{ URL::to('/') }}/images/1.png"
                                                                    alt="">
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
                                            <div class="landscapes"
                                                style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                                <div class="project-single">
                                                    <div class="project-inner project-head">
                                                        <div class="location-card">
                                                            <div class="location-card-head">
                                                                <img src="./{{ URL::to('/') }}/images/1.png"
                                                                    alt="">
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
                                            <div class="landscapes"
                                                style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                                <div class="project-single">
                                                    <div class="project-inner project-head">
                                                        <div class="location-card">
                                                            <div class="location-card-head">
                                                                <img src="./{{ URL::to('/') }}/images/1.png"
                                                                    alt="">
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
                                            <div class="landscapes"
                                                style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                                <div class="project-single">
                                                    <div class="project-inner project-head">
                                                        <div class="location-card">
                                                            <div class="location-card-head">
                                                                <img src="./{{ URL::to('/') }}/images/1.png"
                                                                    alt="">
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
                                            <div class="landscapes"
                                                style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                                <div class="project-single">
                                                    <div class="project-inner project-head">
                                                        <div class="location-card">
                                                            <div class="location-card-head">
                                                                <img src="./{{ URL::to('/') }}/images/1.png"
                                                                    alt="">
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
                                            <div class="landscapes"
                                                style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                                <div class="project-single">
                                                    <div class="project-inner project-head">
                                                        <div class="location-card">
                                                            <div class="location-card-head">
                                                                <img src="./{{ URL::to('/') }}/images/1.png"
                                                                    alt="">
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
                                            <div class="landscapes"
                                                style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                                <div class="project-single">
                                                    <div class="project-inner project-head">
                                                        <div class="location-card">
                                                            <div class="location-card-head">
                                                                <img src="./{{ URL::to('/') }}/images/1.png"
                                                                    alt="">
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
                                            <div class="landscapes"
                                                style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                                <div class="location-card">
                                                    <div class="location-card-head">
                                                        <img src="./{{ URL::to('/') }}/images/1.png" alt="">
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
                                            <div class="landscapes"
                                                style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                                <div class="project-single">
                                                    <div class="project-inner project-head">
                                                        <div class="location-card">
                                                            <div class="location-card-head">
                                                                <img src="./{{ URL::to('/') }}/images/1.png"
                                                                    alt="">
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
                                dots: false,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 993,
                            settings: {
                                slidesToShow: 4,
                                slidesToScroll: 4,
                                dots: false,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 769,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
                                dots: false,
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        .mobile-hidden {
            display: flex;
        }

        @media (max-width: 768px) {
            .mobile-hidden {
                display: none
            }
        }
    </style>
@endsection
