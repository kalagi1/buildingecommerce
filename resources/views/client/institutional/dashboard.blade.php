@extends('client.layouts.master')

@section('content')
    @php
        function getHouse($project, $key, $roomOrder)
        {
            foreach ($project->roomInfo as $room) {
                if ($room->room_order == $roomOrder && $room->name == $key) {
                    return $room;
                }
            }
        }
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
    <div class="brand-head">
        <div class="container">
            <div class="card mb-3">
                <div class="card-img-top" style="background-color: {{ $store->banner_hex_code }}">
                    <div class="brands-square">
                        <img src="{{ url('storage/profile_images/' . $store->profile_image) }}" alt=""
                            class="brand-logo">
                        <p class="brand-name"><a href="{{ route('instituional.profile', Str::slug($store->name)) }}"
                                style="color:White">{{ $store->name }}</a></p>
                        <p class="brand-name"><i class="fa fa-angle-right"></i> </p>
                        <p class="brand-name">Profil</p>
                    </div>
                </div>

                <div class="card-body">
                    <nav class="navbar" style="padding: 0 !important">
                        <div class="navbar-items">
                            <a class="navbar-item active"
                                href="{{ route('instituional.dashboard', Str::slug($store->name)) }}">Anasayfa</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.projects.detail', Str::slug($store->name)) }}">Tüm
                                Projeler</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.profile', Str::slug($store->name)) }}">Satıcı
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
                                        @foreach ($store->brands as $item)
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

    <section class="featured portfolio rec-pro disc bg-white">
        <div class="container">
            <div class="portfolio  col-xl-12">
                <div class="banner-agents">
                    @foreach ($store->banners as $banner)
                        <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                            <div class="landscapes">
                                <div class="project-single">
                                    <div class="project-inner project-head">
                                        <div class="homes">
                                            <!-- homes img -->
                                            <a href="javascript:void()" class="homes-img">
                                                <img src="{{ asset('storage/store_banners/' . $banner->image) }}"
                                                    alt="{{ $banner->title }}" class="img-responsive">
                                            </a>
                                        </div>
                                    </div>
                                    <!-- homes content -->

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>


    @if (count($projects))
        <section class="popular-places home18">
            <div class="container">
                <div class="row">
                    @foreach ($projects as $project)
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

    @if (count($secondhandHousings))
        <!-- START SECTION RECENTLY PROPERTIES -->
        <section class="featured portfolio rec-pro disc bg-white">
            <div class="container">
                <div style="display: flex; justify-content: space-between; align-items: center;" class="mbb">
                    <div class="section-title">
                        <h2>İkinci El Konutlar</h2>
                    </div>
                </div>
                <div class="portfolio col-xl-12">
                    <div class="slick-agents">

                        @foreach ($secondhandHousings as $housing)
                            <div class="agents-grid col-md-6" data-aos="fade-up" data-aos-delay="150">
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

                    </div>
                </div>
            </div>
        </section>
        <!-- END SECTION RECENTLY PROPERTIES -->
    @endif


    @if (count($finishProjects))
        <!-- START SECTION RECENTLY PROPERTIES -->
        <section class="featured portfolio rec-pro disc bg-white">
            <div class="container">
                <div style="display: flex; justify-content: space-between;">
                    <div class="section-title">
                        <h2>Tamamlanan Projeler</h2>
                    </div>
                </div>


                <section class="properties-right list featured portfolio blog pt-5 pb-5 bg-white">
                    <div class="container">
                        <div class="row project-filter-reverse blog-pots">
                            @foreach ($finishProjects as $project)
                                @for ($i = 0; $i < $project->room_count; $i++)
                                    <div class="col-md-3" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="homes">
                                                        <!-- homes img -->

                                                        <a href="{{ route('project.housings.detail', [$project->slug, $project->id]) }}"
                                                            class="homes-img">
                                                            <div class="homes-tag button sale rent"
                                                                style="background-color:#ff5a5f !important">Öne Çıkan</div>
                                                            <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', $i + 1)->value }}"
                                                                alt="{{ $project->housingType->title }}"
                                                                class="img-responsive">
                                                        </a>
                                                    </div>
                                                    <div class="button-effect">
                                                        <a href="#" class="btn toggle-project-favorite"
                                                            data-project-housing-id="{{ $project->id }}">
                                                            <i class="fa fa-heart"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- homes content -->
                                                <div class="homes-content p-3" style="padding:20px !important">
                                                    <h3>{{ $project->project_title }} Projesinde
                                                        {{ getHouse($project, 'squaremeters[]', $i + 1)->value }}m2
                                                        {{ getHouse($project, 'room_count[]', $i + 1)->value }}
                                                    </h3>

                                                    <p class="homes-address mb-3">

                                                        <a
                                                            href="{{ route('project.housings.detail', [$project->slug, $project->id]) }}">
                                                            <i
                                                                class="fa fa-map-marker"></i><span>{{ $project->address }}</span>
                                                        </a>
                                                    </p>
                                                    <!-- homes List -->
                                                    <ul class="homes-list clearfix pb-0"
                                                        style="display: flex;justify-content:space-between">
                                                        <li class="sude-the-icons" style="width:auto !important">
                                                            <i class="flaticon-bed mr-2" aria-hidden="true"></i>
                                                            <span>{{ getHouse($project, 'room_count[]', $i + 1)->value }}</span>
                                                        </li>
                                                        <li class="sude-the-icons" style="width:auto !important">
                                                            <i class="flaticon-bathtub mr-2" aria-hidden="true"></i>
                                                            <span>{{ getHouse($project, 'numberoffloors[]', $i + 1)->value }}.Kat</span>
                                                        </li>
                                                        <li class="sude-the-icons" style="width:auto !important">
                                                            <i class="flaticon-square mr-2" aria-hidden="true"></i>
                                                            <span>{{ getHouse($project, 'squaremeters[]', $i + 1)->value }}
                                                                m2</span>
                                                        </li>
                                                    </ul>
                                                    <ul class="homes-list clearfix pb-0"
                                                        style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                        <li style="font-size: large; font-weight: 700;width:100%">
                                                            {{ getHouse($project, 'price[]', $i + 1)->value }} TL
                                                        </li>
                                                        <li style="display: flex; justify-content: center;">
                                                            {{ date('j', strtotime($project->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($project->created_at))) }}
                                                        </li>
                                                    </ul>
                                                    <ul class="homes-list clearfix pb-0"
                                                        style="display: flex; justify-content: center;margin-top:20px !important;">
                                                        <button id="addToCart"
                                                            style="width: 100%; border: none; background-color: #446BB6; border-radius: 10px; padding: 5px 0px; color: white;"
                                                            data-type='project' data-id='{{ $project->id }}'>Sepete
                                                            Ekle</button>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @endforeach
                        </div>
                    </div>
                </section>

            </div>
        </section>
        <!-- END SECTION POPULAR PLACES -->
    @endif


    @if (count($continueProjects))
        <!-- START SECTION RECENTLY PROPERTIES -->
        <section class="featured portfolio rec-pro disc bg-white">
            <div class="container">
                <div style="display: flex; justify-content: space-between; align-items: center;" class="mbb">
                    <div class="section-title">
                        <h2>Yapım Aşamasındaki Projeler</h2>
                    </div>
                </div>

                <section class="properties-right list featured portfolio blog pb-5 bg-white">
                    <div class="container">
                        <div class="row project-filter-reverse blog-pots">
                            @foreach ($continueProjects as $project)
                                @for ($i = 0; $i < $project->room_count; $i++)
                                    <div class="col-md-3" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="homes">
                                                        <!-- homes img -->

                                                        <a href="{{ route('project.housings.detail', [$project->slug, $project->id]) }}"
                                                            class="homes-img">
                                                            <div class="homes-tag button sale rent"
                                                                style="background-color:#ff5a5f !important">Öne Çıkan</div>
                                                            <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', $i + 1)->value }}"
                                                                alt="{{ $project->housingType->title }}"
                                                                class="img-responsive">
                                                        </a>
                                                    </div>
                                                    <div class="button-effect">
                                                        <a href="#" class="btn toggle-project-favorite"
                                                            data-project-housing-id="{{ $project->id }}">
                                                            <i class="fa fa-heart"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- homes content -->
                                                <div class="homes-content p-3" style="padding:20px !important">
                                                    <h3>{{ $project->project_title }} Projesinde
                                                        {{ getHouse($project, 'squaremeters[]', $i + 1)->value }}m2
                                                        {{ getHouse($project, 'room_count[]', $i + 1)->value }}
                                                    </h3>

                                                    <p class="homes-address mb-3">

                                                        <a
                                                            href="{{ route('project.housings.detail', [$project->slug, $project->id]) }}">
                                                            <i
                                                                class="fa fa-map-marker"></i><span>{{ $project->address }}</span>
                                                        </a>
                                                    </p>
                                                    <!-- homes List -->
                                                    <ul class="homes-list clearfix pb-0"
                                                        style="display: flex;justify-content:space-between">
                                                        <li class="sude-the-icons" style="width:auto !important">
                                                            <i class="flaticon-bed mr-2" aria-hidden="true"></i>
                                                            <span>{{ getHouse($project, 'room_count[]', $i + 1)->value }}</span>
                                                        </li>
                                                        <li class="sude-the-icons" style="width:auto !important">
                                                            <i class="flaticon-bathtub mr-2" aria-hidden="true"></i>
                                                            <span>{{ getHouse($project, 'numberoffloors[]', $i + 1)->value }}.Kat</span>
                                                        </li>
                                                        <li class="sude-the-icons" style="width:auto !important">
                                                            <i class="flaticon-square mr-2" aria-hidden="true"></i>
                                                            <span>{{ getHouse($project, 'squaremeters[]', $i + 1)->value }}
                                                                m2</span>
                                                        </li>
                                                    </ul>
                                                    <ul class="homes-list clearfix pb-0"
                                                        style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                        <li style="font-size: large; font-weight: 700;width:100%">
                                                            {{ getHouse($project, 'price[]', $i + 1)->value }} TL
                                                        </li>
                                                        <li style="display: flex; justify-content: center;">
                                                            {{ date('j', strtotime($project->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($project->created_at))) }}
                                                        </li>
                                                    </ul>
                                                    <ul class="homes-list clearfix pb-0"
                                                        style="display: flex; justify-content: center;margin-top:20px !important;">
                                                        <button id="addToCart"
                                                            style="width: 100%; border: none; background-color: #446BB6; border-radius: 10px; padding: 5px 0px; color: white;"
                                                            data-type='project' data-id='{{ $project->id }}'>Sepete
                                                            Ekle</button>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
        </section>
        <!-- END SECTION RECENTLY PROPERTIES -->
    @endif

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.banner-agents').slick({
                infinite: false,
                slidesToShow: 3,
                slidesToScroll: 1,
                dots: false,
                loop: true,
                autoplay: true,
                arrows: true,
                nav: true,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1292,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        dots: false,
                        arrows: true
                    }
                }, {
                    breakpoint: 993,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        dots: false,
                        arrows: true
                    }
                }, {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: false,
                        arrows: true
                    }
                }]
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        .section-title h2 {
            color: black !important
        }

        .section-title:before {
            background-color: black !important
        }
    </style>
@endsection
