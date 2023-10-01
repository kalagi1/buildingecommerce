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

    <section class="popular-places home18" style="margin-top: 30px;">
        <div class="container">
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


@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script></script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endsection
