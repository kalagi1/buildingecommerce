@extends('client.layouts.master')

@section('content')
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
        
        function getData($housing, $key)
        {
            $housing_type_data = json_decode($housing->housing_type_data);
            $a = $housing_type_data->$key;
            return $a[0];
        }
        
        function getImage($housing, $key)
        {
            $housing_type_data = json_decode($housing->housing_type_data);
            $a = $housing_type_data->$key;
            return $a;
        }
    @endphp

    <div class="brand-head" style="margin-top: 20px;">
        <div class="container">

            <div class="card mb-3">
                <div class="card-img-top" style="background-color: {{ $brand->user->banner_hex_code }}">
                    <div class="brands-square">
                        <img src="{{ url('storage/profile_images/' . $brand->user->profile_image) }}" alt=""
                            class="brand-logo">
                        <p class="brand-name"><a href="{{ route('instituional.profile', Str::slug($brand->user->name)) }}"
                                style="color:White">{{ $brand->user->name }}</a></p>
                        <p class="brand-name"><i class="fa fa-angle-right"></i> </p>
                        <p class="brand-name">
                            {{ $brand->title }}
                            <img src="{{ URL::to('/') }}/storage/brand_images/{{ $brand->cover_photo }}"
                                class="card-img-top" style="width:30px;height:30px" alt="{{ $brand->title }}">
                        </p>
                    </div>
                </div>
                <div class="card-body">
                    <nav class="navbar" style="padding: 0 !important">
                        <div class="navbar-items">
                            <a class="navbar-item"
                                href="{{ route('instituional.dashboard', Str::slug($brand->user->name)) }}">Anasayfa</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.projects.detail', Str::slug($brand->user->name)) }}">Tüm
                                Projeler</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.profile', Str::slug($brand->user->name)) }}">Satıcı
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
                                        @foreach ($brand->user->brands as $item)
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

    @if (count($brand->projects))
        <section class="popular-places home18" style="margin-top: 30px;">
            <div class="container">
                <div style="display: flex; justify-content: space-between; align-items: center;" class="mbb">
                    <div class="section-title">
                        <h2>Projeler</h2>
                    </div>
                </div>
                <div class="row">
                    @foreach ($brand->projects as $project)
                        <div class="col-sm-12 col-md-4 col-lg-4" data-aos="zoom-in" data-aos-delay="150">
                            <!-- Image Box -->
                            <a href="{{ route('project.detail', $project->slug) }}" class="img-box hover-effect">
                                <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                    class="img-fluid w100" alt="">
                            </a>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif


    <!-- START SECTION RECENTLY PROPERTIES -->
    <section class="featured portfolio rec-pro disc bg-white mb-5">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center;" class="mbb">
                <div class="section-title">
                    <h2>İkinci El Konutlar</h2>
                </div>
            </div>
            <div class="portfolio col-xl-12">
                <div class="slick-agents">
                    @if (count($brand->housings))
                        @foreach ($brand->housings as $housing)
                            <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                <div class="landscapes">
                                    <div class="project-single">
                                        <div class="project-inner project-head">
                                            <div class="homes">
                                                <!-- homes img -->
                                                <a href="single-property-1.html" class="homes-img">
                                                    <div class="homes-tag button sale rent"
                                                        style="background-color:#ff5a5f !important">Öne Çıkan</div>
                                                    <img src="{{ asset('housing_images/' . getImage($housing, 'image')) }}"
                                                        alt="{{ $housing->housing_type_title }}" class="img-responsive">
                                                </a>
                                            </div>
                                            <div class="button-effect">
                                                <!-- Örneğin Kalp İkonu -->
                                                <a href="#" class="btn toggle-favorite"
                                                    data-housing-id="{{ $housing->id }}">
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <!-- homes content -->
                                        <div class="homes-content p-3" style="padding:20px !important">
                                            <!-- homes address -->
                                            <h3><a
                                                    href="{{ route('housing.show', $housing->id) }}">{{ $housing->housing_title }}</a>
                                            </h3>
                                            <p class="homes-address mb-3">
                                                <a href="{{ route('housing.show', $housing->id) }}">
                                                    <i class="fa fa-map-marker"></i><span>{{ $housing->address }}</span>
                                                </a>
                                            </p>
                                            <!-- homes List -->
                                            <ul class="homes-list clearfix pb-0"
                                                style="display: flex;justify-content:space-between">
                                                <li class="sude-the-icons" style="width:auto !important">
                                                    <i class="flaticon-bed mr-2" aria-hidden="true"></i>
                                                    <span>{{ $housing->housing_type_title }}</span>
                                                </li>
                                                <li class="sude-the-icons" style="width:auto !important">
                                                    <i class="flaticon-bathtub mr-2" aria-hidden="true"></i>
                                                    <span>{{ getData($housing, 'room_count') }}</span>
                                                </li>
                                                <li class="sude-the-icons" style="width:auto !important">
                                                    <i class="flaticon-square mr-2" aria-hidden="true"></i>
                                                    <span>{{ getData($housing, 'squaremeters') }} m2</span>
                                                </li>
                                            </ul>
                                            <ul class="homes-list clearfix pb-0"
                                                style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                <li style="font-size: large; font-weight: 700;">
                                                    {{ getData($housing, 'price') }}TL
                                                </li>

                                                <li style="display: flex; justify-content: center;">
                                                    {{ date('j', strtotime($housing->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($housing->created_at))) }}
                                                </li>
                                            </ul>
                                            <ul class="homes-list clearfix pb-0"
                                                style="display: flex; justify-content: center;margin-top:20px !important;">
                                                <button id="addToCart"
                                                    style="width: 100%; border: none; background-color: #446BB6; border-radius: 10px; padding: 5px 0px; color: white;"
                                                    data-type='housing' data-id='{{ $housing->id }}'>Sepete
                                                    Ekle</button>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>Veri Yok</p>
                    @endif








                </div>
            </div>
        </div>
    </section>
    <!-- END SECTION RECENTLY PROPERTIES -->



@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script></script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        .section-title h2 {
            color: black !important
        }

        .section-title:before {
            background-color: black !important
        }
        
        .portfolio{
            padding: 0 !important
        }
        .slick-track {
            width: 100% !important
        }
    </style>


@endsection
