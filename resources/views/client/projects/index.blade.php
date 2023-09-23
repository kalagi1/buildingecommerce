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
                        <form class="search-form">
                            <input class="search-input" type="search" placeholder="Mağazada Ara" aria-label="Search">
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

                                <li><a href="#"><strong>Adres:</strong> {!! $project->address !!} </a></li>
                                <li><a href="#"><strong>Proje Sayısı:</strong>
                                        {{ count($project->user->projects) }}</a></li>
                                <li><a href="#"><strong>Konut Sayısı:</strong> {{ $totalHousingCount }} </a></li>
                                <li><a href="#"><strong>Konut Tipi:</strong> {{ $project->housingtype->title }} </a>
                                </li>

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
                                dots: true,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 993,
                            settings: {
                                slidesToShow: 4,
                                slidesToScroll: 4,
                                dots: true,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 769,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
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
