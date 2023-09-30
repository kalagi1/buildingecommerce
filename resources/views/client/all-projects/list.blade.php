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
    <section class="properties-right list featured portfolio blog pt-5 bg-white">
        <div class="container">

            <div class="row project-filter-reverse">
                <aside class="col-lg-3 col-md-12 car">
                    <div class="widget">
                        <form class="form">
                            <!-- Search Fields -->
                            <div class="widget-boxed main-search-field">
                                <div class="widget-boxed-header">
                                    <h4>Filtrele</h4>
                                </div>
                                <!-- Search Form -->
                                <div class="trip-search">
                                    <div class="form-group looking">
                                        <div class="first-select wide">
                                            <div class="main-search-input-item">
                                                <input type="text" name="search" value="{{ request('search') }}"
                                                    placeholder="Ara..." value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <select name="city_id" class="form-control mt-2" id="">
                                            <option value=""><i class="fa fa-home" aria-hidden="true"></i>Şehir Seç
                                            </option>
                                            @foreach ($cities as $city)
                                                <option @if (request('city_id') && request('city_id') == $city->id) selected @endif
                                                    value="{{ $city->id }}">{{ $city->title }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="form-group categories mb-0">
                                        <select name="housing_type_id" class="form-control mt-2" id="">
                                            <option value=""><i class="fa fa-home" aria-hidden="true"></i>Konut Tipi
                                            </option>
                                            @foreach ($housingTypes as $housingType)
                                                <option @if (request('housing_type_id') && request('housing_type_id') == $housingType->id) selected @endif
                                                    value="{{ $housingType->id }}">{{ $housingType->title }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="form-group categories mb-0">
                                        <div class="nice-select form-control wide" tabindex="0"><span class="current"><i
                                                    class="fa fa-home"></i>Konut Durumu</span>
                                            <ul class="list">
                                                @foreach ($housingStatuses as $housingStatus)
                                                    <li data-value="{{ $housingStatus->id }}" class="option selected ">
                                                        {{ $housingStatus->name }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 no-pds">
                                    <div class="at-col-default-mar">
                                        <button class="btn btn-default hvr-bounce-to-right" type="submit">Filtrele</button>
                                    </div>
                                </div>
                        </form>
                    </div>
            </div>
            </aside>
            <div class="col-lg-9 col-md-12 blog-pots">
                <section class="headings-2 pt-0">
                    <div class="brand-head" style="padding-top:0">
                        <div class="brands-square" style="position: relative;top:0;left:0">
                            <p class="brand-name"><a href="{{ url('/') }}" style="color:black">Anasayfa</a></p>
                            <p class="brand-name"><i class="fa fa-angle-right" style="color: black"></i> </p>
                            <p class="brand-name" style="color: black">
                                Kategori
                            </p>
                            <p class="brand-name"><i class="fa fa-angle-right" style="color: black"></i> </p>
                            <p class="brand-name" style="color: black">
                                {{ $title }}
                            </p>
                        </div>
                    </div>
                </section>
                <section class="popular-places home18" style="padding-top:0 !important">
                    <div class="container">

                        <div class="row">
                            @if (count($secondhandHousings) == 0)
                                @forelse($projects as $project)
                                    <div class="col-sm-12 col-md-6 col-lg-6" data-aos="zoom-in" data-aos-delay="150">
                                        <!-- Image Box -->
                                        <a href="{{ route('project.detail', $project->slug) }}"
                                            class="img-box hover-effect">
                                            <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                                class="img-fluid w100" alt="">
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-sm-12">
                                        <strong>Bu kategoriye ait proje bulunamadı.</strong>
                                    </div>
                                @endforelse
                            @else
                                <div class="slick-agentsx row">
                                    @foreach ($secondhandHousings as $housing)
                                        <div class="agents-grid col-md-4" data-aos="fade-up" data-aos-delay="150">
                                            <div class="landscapes">
                                                <div class="project-single">
                                                    <div class="project-inner project-head">
                                                        <div class="homes">
                                                            <!-- homes img -->
                                                            <a href="single-property-1.html" class="homes-img">
                                                                <img src="{{ asset('housing_images/' . getImage($housing, 'image')) }}"
                                                                    alt="{{ $housing->housing_type_title }}"
                                                                    class="img-responsive">
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
                                                                href="{{ route('housing.show', $housing->id) }}">{{ $housing->title }}</a>
                                                        </h3>
                                                        <p class="homes-address mb-3">
                                                            <a href="{{ route('housing.show', $housing->id) }}">
                                                                <i
                                                                    class="fa fa-map-marker"></i><span>{{ $housing->address }}</span>
                                                            </a>
                                                        </p>
                                                        <!-- homes List -->
                                                        <ul class="homes-list clearfix pb-0"
                                                            style="display: flex;justify-content:space-between">
                                                            <li class="sude-the-icons" style="width:auto !important">
                                                                <i class="flaticon-bed mr-2" aria-hidden="true"></i>
                                                                <span>{{ $housing->housing_type->title }} </span>
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
                                                                {{ getData($housing, 'price') }}TL</li>

                                                            <li style="display: flex; justify-content: center;">
                                                                {{ date('j', strtotime($housing->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($housing->created_at))) }}
                                                            </li>
                                                        </ul>
                                                        <ul class="homes-list clearfix pb-0"
                                                            style="display: flex; justify-content: center;margin-top:20px !important;">
                                                            <button class="addToCart"
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
                            @endif


                        </div>
                    </div>
                </section>

            </div>

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
