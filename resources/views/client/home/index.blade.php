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
    <section class="recently portfolio bg-white homepage-5 ">
        <div class="container recently-slider">

            <div class="portfolio right-slider">
                <div class="owl-carousel home5-right-slider">
                    @foreach ($sliders as $slider)
                        <a href="javascript:void()" class="recent-16" data-aos="fade-up" data-aos-delay="150">
                            <div class="recent-img16 img-fluid img-center"
                                style="background-image: url({{ url('storage/sliders/' . $slider->image) }});"></div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- END SECTION RECENTLY PROPERTIES -->



    <!-- START SECTION RECENTLY PROPERTIES -->
    <section class="featured  home18 bg-white">
        <div class="container">
            <div class="portfolio ">
                <div class="slick-lancers">
                    @foreach ($brands as $brand)
                        <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                            <a href="{{ route('instituional.dashboard', Str::slug($brand->name)) }}" class="homes-img">
                                <div class="landscapes">
                                    <div class="project-single">
                                        <div class="project-inner project-head">
                                            <div class="homes">
                                                <!-- homes img -->
                                                <img src="{{ asset('storage/profile_images/' . $brand->profile_image) }}"
                                                    alt="home-1" class="img-responsive brand-image-pp">
                                                <span>{{ $brand->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- END SECTION RECENTLY PROPERTIES -->



    <section class="container justify-content-center">
        <div class="special-button-content row">
            @foreach ($dashboardStatuses as $status)
                <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                    <a href="{{ url('kategori/' . $status->slug) }}">
                        <button style="background-color: #dee0f5; color: #504fa3;" class="w-100">
                            {{ $status->name }}
                        </button>
                    </a>
                </div>
            @endforeach
        </div>
    </section>


    <!-- category banner headers ends-->





    <!-- START SECTION POPULAR PLACES -->
    <section class="popular-places home18">
        <div class="container">
            <div style="display: flex; justify-content: space-between;">
                <div class="section-title">
                    <h2>Tüm Projeler</h2>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                </div>
                @foreach ($dashboardProjects as $project)
                    <div class="col-sm-12 col-md-4 col-lg-4 col-6" data-aos="zoom-in" data-aos-delay="150">
                        <!-- Image Box -->
                        <a href="{{ route('project.detail', $project->project->slug) }}" class="img-box hover-effect">
                            <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->project->image) }}"
                                class="img-fluid w100" alt="">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- END SECTION RECENTLY PROPERTIES -->


    <!-- START SECTION RECENTLY PROPERTIES -->
    <section class="featured portfolio rec-pro disc bg-white">
        <div class="container">
            <div style="display: flex; justify-content: space-between;">
                <div class="section-title">
                    <h2>Tamamlanan Projeler</h2>
                </div>
            </div>
            @php
                function getHouse($project, $key, $roomOrder)
                {
                    foreach ($project->roomInfo as $room) {
                        if ($room->room_order == $roomOrder && $room->name == $key) {
                            return $room;
                        }
                    }
                }
            @endphp
            <div class="mobile-show">
                @foreach ($finishProjects as $project)
                    @for ($i = 0; $i < $project->room_count; $i++)
                        <div class="row mb-3" style="flex-wrap: nowrap">
                            <div class="col-md-2" style="padding-right:0">
                                <div class="project-inner project-head">
                                    <a
                                        href="{{ route('project.housings.detail', [$project->slug, getHouse($project, 'squaremeters[]', $i + 1)->room_order]) }}">
                                        <div class="homes">
                                            <!-- homes img -->

                                            <div class="homes-img">
                                                <div class="homes-tag button sale rent"
                                                    style="background-color:#ff5a5f !important">Öne Çıkan
                                                </div>

                                                <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', $i + 1)->value }}"
                                                    alt="{{ $project->housingType->title }}" class="img-responsive">
                                            </div>
                                        </div>
                                    </a>
                                    <div class="button-effect">
                                        <a href="#" class="btn toggle-project-favorite"
                                            data-project-housing-id="{{ getHouse($project, 'squaremeters[]', $i + 1)->room_order }}"
                                            data-project-id={{ $project->id }}>
                                            <i class="fa fa-heart"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10" style="padding-left:0">
                                <div class="homes-content p-3" style="padding:20px !important">

                                    <a style="text-decoration: none"
                                        href="{{ route('project.housings.detail', [$project->slug, getHouse($project, 'squaremeters[]', $i + 1)->room_order]) }}">
                                        <h4>{{ $project->project_title }} Projesinde
                                            {{ getHouse($project, 'squaremeters[]', $i + 1)->value }}m2
                                            {{ getHouse($project, 'room_count[]', $i + 1)->value }}
                                        </h4>
                                        <span> {{ getHouse($project, 'price[]', $i + 1)->value }} TL</span>


                                    </a>
                                    <ul class="homes-list clearfix pb-0"
                                        style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                        <div class="button-effect-2" style="margin-right:3px">
                                            <a href="#" class="btn toggle-project-favorite"
                                                data-project-housing-id="{{ getHouse($project, 'squaremeters[]', $i + 1)->room_order }}"
                                                data-project-id={{ $project->id }}>
                                                <i class="fa fa-heart"></i>
                                            </a>
                                        </div>
                                        <button class="addToCart"
                                            style="width: 100%; border: none; background-color: #446BB6; border-radius: .25rem; padding: 5px 0px; color: white;"
                                            data-type='project' data-project='{{ $project->id }}'
                                            data-id='{{ getHouse($project, 'price[]', $i + 1)->room_order }}'>Sepete
                                            Ekle</button>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endfor
                @endforeach
            </div>

            <div class="mobile-hidden">
                @if (count($finishProjects))
                    <div class="properties-right list featured portfolio blog pb-5 bg-white">
                        <div class="container">
                            <div class="row project-filter-reverse blog-pots">
                                @foreach ($finishProjects as $project)
                                    @for ($i = 0; $i < $project->room_count; $i++)
                                        <div class="col-md-3" data-aos="fade-up" data-aos-delay="150">
                                            <div class="landscapes">
                                                <div class="project-single">
                                                    <div class="project-inner project-head">
                                                        <a
                                                            href="{{ route('project.housings.detail', [$project->slug, getHouse($project, 'squaremeters[]', $i + 1)->room_order]) }}">
                                                            <div class="homes">
                                                                <!-- homes img -->

                                                                <div class="homes-img">
                                                                    <div class="homes-tag button sale rent"
                                                                        style="background-color:#ff5a5f !important">Öne
                                                                        Çıkan
                                                                    </div>

                                                                    <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', $i + 1)->value }}"
                                                                        alt="{{ $project->housingType->title }}"
                                                                        class="img-responsive">
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <div class="button-effect">
                                                            <a href="#" class="btn toggle-project-favorite"
                                                                data-project-housing-id="{{ getHouse($project, 'squaremeters[]', $i + 1)->room_order }}"
                                                                data-project-id={{ $project->id }}>
                                                                <i class="fa fa-heart"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <!-- homes content -->
                                                    <div class="homes-content p-3" style="padding:20px !important">

                                                        <a style="text-decoration: none"
                                                            href="{{ route('project.housings.detail', [$project->slug, getHouse($project, 'squaremeters[]', $i + 1)->room_order]) }}">
                                                            <h3>{{ $project->project_title }} Projesinde
                                                                {{ getHouse($project, 'squaremeters[]', $i + 1)->value }}m2
                                                                {{ getHouse($project, 'room_count[]', $i + 1)->value }}
                                                            </h3>

                                                            <p class="homes-address mb-3">


                                                                <i
                                                                    class="fa fa-map-marker"></i><span>{{ $project->address }}</span>

                                                            </p>

                                                        </a>
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
                                                            <li
                                                                style="font-size: large; font-weight: 700;width:100%;white-space:nowrap">
                                                                {{ getHouse($project, 'price[]', $i + 1)->value }} TL
                                                            </li>
                                                            <li style="display: flex; justify-content: right;width:100%">
                                                                {{ date('j', strtotime($project->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($project->created_at))) }}
                                                            </li>
                                                        </ul>
                                                        <ul class="homes-list clearfix pb-0"
                                                            style="display: flex; justify-content: center;margin-top:20px !important;">
                                                            <button class="addToCart"
                                                                style="width: 100%; border: none; background-color: #446BB6; border-radius: .25rem; padding: 5px 0px; color: white;"
                                                                data-type='project' data-project='{{ $project->id }}'
                                                                data-id='{{ getHouse($project, 'price[]', $i + 1)->room_order }}'>Sepete
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
                    </div>
                @else
                    <p>Veri Yok</p>
                @endif
            </div>


        </div>
    </section>
    <!-- END SECTION POPULAR PLACES -->


    <!-- START SECTION RECENTLY PROPERTIES -->
    <section class="featured portfolio rec-pro disc bg-white">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div class="section-title">
                    <h2>Yapım Aşamasındaki Projeler</h2>
                </div>
            </div>
            <div class="mobile-show">
                @foreach ($continueProjects as $project)
                    @for ($i = 0; $i < $project->room_count; $i++)
                        <div class="row mb-3" style="flex-wrap: nowrap">
                            <div class="col-md-2" style="padding-right:0">
                                <div class="project-inner project-head">
                                    <a
                                        href="{{ route('project.housings.detail', [$project->slug, getHouse($project, 'squaremeters[]', $i + 1)->room_order]) }}">
                                        <div class="homes">
                                            <!-- homes img -->

                                            <div class="homes-img">
                                                <div class="homes-tag button sale rent"
                                                    style="background-color:#ff5a5f !important">Öne Çıkan
                                                </div>

                                                <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', $i + 1)->value }}"
                                                    alt="{{ $project->housingType->title }}" class="img-responsive">
                                            </div>
                                        </div>
                                    </a>
                                    <div class="button-effect">
                                        <a href="#" class="btn toggle-project-favorite"
                                            data-project-housing-id="{{ getHouse($project, 'squaremeters[]', $i + 1)->room_order }}"
                                            data-project-id={{ $project->id }}>
                                            <i class="fa fa-heart"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10" style="padding-left:0">
                                <div class="homes-content p-3" style="padding:20px !important">

                                    <a style="text-decoration: none"
                                        href="{{ route('project.housings.detail', [$project->slug, getHouse($project, 'squaremeters[]', $i + 1)->room_order]) }}">
                                        <h4>{{ $project->project_title }} Projesinde
                                            {{ getHouse($project, 'squaremeters[]', $i + 1)->value }}m2
                                            {{ getHouse($project, 'room_count[]', $i + 1)->value }}
                                        </h4>
                                        <span> {{ getHouse($project, 'price[]', $i + 1)->value }} TL</span>


                                    </a>
                                    <ul class="homes-list clearfix pb-0"
                                        style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                        <div class="button-effect-2" style="margin-right:3px">
                                            <a href="#" class="btn toggle-project-favorite"
                                                data-project-housing-id="{{ getHouse($project, 'squaremeters[]', $i + 1)->room_order }}"
                                                data-project-id={{ $project->id }}>
                                                <i class="fa fa-heart"></i>
                                            </a>
                                        </div>
                                        <button class="addToCart"
                                            style="width: 100%; border: none; background-color: #446BB6; border-radius: .25rem; padding: 5px 0px; color: white;"
                                            data-type='project' data-project='{{ $project->id }}'
                                            data-id='{{ getHouse($project, 'price[]', $i + 1)->room_order }}'>Sepete
                                            Ekle</button>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endfor
                @endforeach
            </div>
            <div class="mobile-hidden">

                @if (count($continueProjects))
                    <section class="properties-right list featured portfolio blog  pb-5 bg-white">
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

                                                            <a href="{{ route('project.housings.detail', [$project->slug, getHouse($project, 'squaremeters[]', $i + 1)->room_order]) }}"
                                                                class="homes-img">
                                                                <div class="homes-tag button sale rent"
                                                                    style="background-color:#ff5a5f !important">Öne Çıkan
                                                                </div>
                                                                <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', $i + 1)->value }}"
                                                                    alt="{{ $project->housingType->title }}"
                                                                    class="img-responsive">
                                                            </a>
                                                        </div>
                                                        <div class="button-effect">
                                                            <a href="#" class="btn toggle-project-favorite"
                                                                data-project-housing-id="{{ getHouse($project, 'squaremeters[]', $i + 1)->room_order }}"
                                                                data-project-id={{ $project->id }}>
                                                                <i class="fa fa-heart"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <!-- homes content -->
                                                    <div class="homes-content p-3" style="padding:20px !important">
                                                        <a style="text-decoration: none"
                                                            href="{{ route('project.housings.detail', [$project->slug, getHouse($project, 'squaremeters[]', $i + 1)->room_order]) }}">
                                                            <h3>{{ $project->project_title }} Projesinde
                                                                {{ getHouse($project, 'squaremeters[]', $i + 1)->value }}m2
                                                                {{ getHouse($project, 'room_count[]', $i + 1)->value }}
                                                            </h3>

                                                            <p class="homes-address mb-3">


                                                                <i
                                                                    class="fa fa-map-marker"></i><span>{{ $project->address }}</span>

                                                            </p>
                                                        </a>
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
                                                            <li
                                                                style="font-size: large; font-weight: 700;width:100%; white-space:nowrap">
                                                                {{ getHouse($project, 'price[]', $i + 1)->value }} TL
                                                            </li>
                                                            <li style="display: flex; justify-content: right;width:100%">
                                                                {{ date('j', strtotime($project->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($project->created_at))) }}
                                                            </li>
                                                        </ul>
                                                        <ul class="homes-list clearfix pb-0"
                                                            style="display: flex; justify-content: center;margin-top:20px !important;">
                                                            <button class="addToCart"
                                                                style="width: 100%; border: none; background-color: #446BB6; border-radius: .25rem; padding: 5px 0px; color: white;"
                                                                data-type='project' data-project='{{ $project->id }}'
                                                                data-id='{{ getHouse($project, 'price[]', $i + 1)->room_order }}'>Sepete
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
                @else
                    <p>Veri Yok</p>
                @endif
            </div>
        </div>
    </section>
    <!-- END SECTION RECENTLY PROPERTIES -->





    <section class="real-estate popular-places bg-white ">
        <div class="container">

            <div class="section-title mbb ">
                <h2>Emlak 360</h2>
            </div>
            <div class="real-estate-body pt-5 border-top pb-5">
                <div class="row ">
                    <div class="col-md-2 col-6 text-center">
                        <div class="estate-item">
                            <img src="images/iconbar.png" style="width: 50px;" alt="">
                            <p>Emlak Endeksi</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-6 text-center">
                        <div class="estate-item">
                            <img src="images/Group 575.png" style="width: 50px;" alt="">
                            <p>Emlak Endeksi</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-6 text-center">
                        <div class="estate-item">
                            <img src="images/Group 576.png" style="width: 50px;" alt="">
                            <p>Emlak Endeksi</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-6 text-center">
                        <div class="estate-item">
                            <img src="images/Group 577.png" style="width: 50px;" alt="">
                            <p>Emlak Endeksi</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-6 text-center">
                        <div class="estate-item">
                            <img src="images/Group 578.png" style="width: 50px;" alt="">
                            <p>Emlak Endeksi</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-6 text-center">
                        <div class="estate-item">
                            <img src="images/Group 579.png" style="width: 50px;" alt="">
                            <p>Emlak Endeksi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- START SECTION INFO-HELP -->
    <section class="container">
        <div class="info-help h18">
            <div class="row info-head">
                <div class="col-lg-12 col-md-8 col-xs-8">
                    <div class="info-text" data-aos="fade-up" data-aos-delay="150">
                        <h3 class="text-center mb-0">Neden Biz</h3>
                        <p class="text-center mb-4 p-0">Lorem ipsum dolor sit amet consectetur.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END SECTION INFO-HELP -->

    <!-- START SECTION INFO -->
    <section class="featured-boxes-area bg-white-1 ">
        <div class="container">
            <div class="featured-boxes-inner">
                <div class="row m-0">
                    <div class="col-lg-3 col-sm-6 col-md-6 p-0" data-aos="fade-up" data-aos-delay="250">
                        <div class="single-featured-box">
                            <div class="icon color-fb7756"><img src="images/icons/i-1.svg" width="85" height="85"
                                    alt=""></div>
                            <h3 class="mt-5">Find Your Home</h3>
                            <p>Lorem ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan.
                            </p><a class="read-more-btn" href="single-property-1.html">Read More</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 p-0" data-aos="fade-up" data-aos-delay="350">
                        <div class="single-featured-box">
                            <div class="icon color-facd60"><img src="images/icons/i-2.svg" width="85" height="85"
                                    alt=""></div>
                            <h3 class="mt-5">Trusted by thousands</h3>
                            <p>Lorem ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan.
                            </p><a class="read-more-btn" href="single-property-1.html">Read More</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 p-0" data-aos="fade-up" data-aos-delay="450">
                        <div class="single-featured-box">
                            <div class="icon color-1ac0c6"><img src="images/icons/i-3.svg" width="85" height="85"
                                    alt=""></div>
                            <h3 class="mt-5">Financing made easy</h3>
                            <p>Lorem ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan.
                            </p><a class="read-more-btn" href="single-property-1.html">Read More</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 p-0" data-aos="fade-up" data-aos-delay="550">
                        <div class="single-featured-box">
                            <div class="icon"><img src="images/icons/i-4.svg" width="85" height="85"
                                    alt=""></div>
                            <h3 class="mt-5">24/7 support</h3>
                            <p>Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan.</p>
                            <a class="read-more-btn" href="single-property-1.html">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END SECTION INFO -->




    <!-- START SECTION RECENTLY PROPERTIES -->
    <section class="recently popular-places bg-white homepage-5" style="margin-top: 50px; margin-bottom: 50px; ">
        <div class="container recently-slider">

            <div class="portfolio right-slider">
                <div class="owl-carousel home5-right-slider">
                    @foreach ($footerSlider as $slider)
                        <div class="inner-box">
                            <a href="#" class="recent-16" data-aos="fade-up" data-aos-delay="150">
                                <div class="recent-img16 img-fluid img-center"
                                    style="background-image: url({{ asset('storage/footer-sliders/' . $slider->image) }});">
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@endsection
