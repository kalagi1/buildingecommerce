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
                    <div class="brands-square w-100">
                        <img src="{{ url('storage/profile_images/' . $store->profile_image) }}" alt=""
                            class="brand-logo">
                        <div style="display: flex;margin-left:5px">

                            <p class="brand-name"><a href="{{ route('instituional.profile', Str::slug($store->name)) }}"
                                    style="color:White">
                                    {{ $store->name }}</a>
                            </p>

                            @if ($store->corporate_account_status)
                                <span class="badgeYearIcon" style="display: inline-block; position: relative;">
                                    <img src="{{ asset('badge_fa1c1ff1863d3279ba0e8a1583c94547.png') }}" alt=""
                                        style="display: block; margin: 0 auto;">

                                    <span
                                        style="position: absolute;line-height:.9;color:black;font-size:9px !important; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                        <i class="fa fa-check"></i></span>
                                </span>
                                @if ($store->year)
                                    <span class="badgeYearIcon" style="display: inline-block; position: relative;">
                                        <img src="{{ asset('badge_fa1c1ff1863d3279ba0e8a1583c94547.png') }}" alt=""
                                            style="display: block; margin: 0 auto;">

                                        <span
                                            style="position: absolute;line-height:.9;color:black;font-size:9px !important; top: 50%; left: 50%; transform: translate(-50%, -50%);">{{ $store->year }}
                                            Yıl</span>
                                    </span>
                                @endif
                            @endif

                        </div>
                        @if (Auth::check())
                            @if ($store->id == Auth::user()->id)
                                <a href="{{ url('institutional/choise-advertise-type') }}"
                                    style="margin-left: auto; margin-right:30px">
                                    <button type="button" class="buyUserRequest ml-3">
                                        <span class="buyUserRequest__text">
                                            <div class="mobile-show"><i class="fa fa-plus"></i></div>
                                            <div class="mobile-hidden">İlan Ekle</div>
                                        </span>
                                        <span class="buyUserRequest__icon">
                                            <img src="{{ asset('sc.png') }}" alt="" srcset="">
                                        </span>
                                    </button>
                                </a>
                            @endif
                        @endif
                    </div>

                </div>

                <div class="card-body">
                    <nav class="navbar" style="padding: 0 !important">
                        <div class="navbar-items">
                            <a class="navbar-item active"
                                href="{{ route('instituional.dashboard', Str::slug($store->name)) }}">Anasayfa</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.profile', Str::slug($store->name)) }}">Mağaza Profili</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.projects.detail', Str::slug($store->name)) }}">Proje
                                İlanları</a>
                                <a class="navbar-item"
                                href="{{ route('instituional.housings', Str::slug($store->name)) }}">Emlak İlanları</a>
                                <a class="navbar-item"
                                href="{{ route('instituional.teams', ["slug" => Str::slug($store->name), "userID" => $store->id]) }}">Ekip</a>
                            
                        </div>
                        <div class="search-form">
                            <input class="search-input" type="text" placeholder="Mağazada Ara" id="search-project"
                                aria-label="Search" name="q">
                            <div class="header-search__suggestions">
                                <div class="header-search__suggestions__section">
                                    <h5>Projeler</h5>
                                    <div class="header-search__suggestions__section__items">
                                        @foreach ($store->projects as $item)
                                            <a href="{{ route('project.detail', ['slug' => $item->slug, 'id' => $item->id]) }}"
                                                class="project-item"
                                                data-title="{{ $item->project_title }}"><span>{{ $item->project_title }}</span></a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <button class="search-button" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="loading-area d-none">
        <div class="container">
            <div style="display: flex; justify-content: space-between;" class="mb-3">
                <div class="section-title">
                    <h2>Tüm Projeler</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4 col-12 " data-aos="zoom-in" data-aos-delay="150">
                    <div class="skeleton-loader w-100" style="height:200px"></div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4 col-12 " data-aos="zoom-in" data-aos-delay="150">
                    <div class="skeleton-loader w-100" style="height:200px"></div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4 col-12 " data-aos="zoom-in" data-aos-delay="150">
                    <div class="skeleton-loader w-100" style="height:200px"></div>
                </div>
            </div>
            <div style="display: flex; justify-content: space-between;" class="mb-3">
                <div class="section-title">
                    <h2>TAMAMLANAN PROJELER</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3 col-12 " data-aos="zoom-in" data-aos-delay="150">
                    <div class="skeleton-loader w-100" style="height:300px"></div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3 col-12 " data-aos="zoom-in" data-aos-delay="150">
                    <div class="skeleton-loader w-100" style="height:300px"></div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3 col-12 " data-aos="zoom-in" data-aos-delay="150">
                    <div class="skeleton-loader w-100" style="height:300px"></div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3 col-12 " data-aos="zoom-in" data-aos-delay="150">
                    <div class="skeleton-loader w-100" style="height:300px"></div>
                </div>
            </div>
            <div style="display: flex; justify-content: space-between;" class="mb-3">
                <div class="section-title">
                    <h2>DEVAM EDEN PROJELER</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3 col-12 " data-aos="zoom-in" data-aos-delay="150">
                    <div class="skeleton-loader w-100" style="height:300px"></div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3 col-12 " data-aos="zoom-in" data-aos-delay="150">
                    <div class="skeleton-loader w-100" style="height:300px"></div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3 col-12 " data-aos="zoom-in" data-aos-delay="150">
                    <div class="skeleton-loader w-100" style="height:300px"></div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3 col-12 " data-aos="zoom-in" data-aos-delay="150">
                    <div class="skeleton-loader w-100" style="height:300px"></div>
                </div>
            </div>
            <div style="display: flex; justify-content: space-between;" class="mb-3">
                <div class="section-title">
                    <h2>TOPRAKTAN PROJELER</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3 col-12 " data-aos="zoom-in" data-aos-delay="150">
                    <div class="skeleton-loader w-100" style="height:300px"></div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3 col-12 " data-aos="zoom-in" data-aos-delay="150">
                    <div class="skeleton-loader w-100" style="height:300px"></div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3 col-12 " data-aos="zoom-in" data-aos-delay="150">
                    <div class="skeleton-loader w-100" style="height:300px"></div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3 col-12 " data-aos="zoom-in" data-aos-delay="150">
                    <div class="skeleton-loader w-100" style="height:300px"></div>
                </div>
            </div>
            <div style="display: flex; justify-content: space-between;" class="mb-3">
                <div class="section-title">
                    <h2>EMLAK İLANLARI</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3 col-12 " data-aos="zoom-in" data-aos-delay="150">
                    <div class="skeleton-loader w-100" style="height:300px"></div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3 col-12 " data-aos="zoom-in" data-aos-delay="150">
                    <div class="skeleton-loader w-100" style="height:300px"></div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3 col-12 " data-aos="zoom-in" data-aos-delay="150">
                    <div class="skeleton-loader w-100" style="height:300px"></div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3 col-12 " data-aos="zoom-in" data-aos-delay="150">
                    <div class="skeleton-loader w-100" style="height:300px"></div>
                </div>
            </div>
        </div>
    </div>

    @if (count($store->banners))
        <section class="featured portfolio rec-pro disc bg-white">
            <div class="container">
                <div class="portfolio col-xl-12 bannerResize">
                    <div class="banner-agents">
                        @foreach ($store->banners as $banner)
                            <div class="agents-grid bannerResizeGrid" data-aos="fade-up" data-aos-delay="150">
                                <div class="landscapes">
                                    <div class="project-single">
                                        <div class="project-inner project-head">
                                            <div class="homes">
                                                <!-- homes img -->
                                                <a href="{{ asset('storage/store_banners/' . $banner->image) }}"
                                                    data-lightbox="gallery">
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
    @endif



    @if (count($projects))
        <section class="featured portfolio rec-pro disc bg-white">
            <div class="container">
                <div class="featured-heads">
                    <div class="section-title">
                        <h2>Tüm Projeler</h2>
                    </div>
                    <a href="https://emlaksepette.com/kategori/topraktan-projeler" style="font-size: 11px;">
                        <button style="background-color: #ea2a28; color: white;padding: 5px 10px;border:none;"
                            class="w-100">
                            Tümünü Gör
                        </button>
                    </a>
                </div>

                <div class="row mobile-show homepage-9">
                    <div class="container">
                        <div class="row">
                            @foreach ($projects as $project)
                                <div class="col-xl-3 col-lg-6 col-sm-6 aos-init aos-animate" data-aos="fade-up"
                                    data-aos-delay="150">
                                    <div class="small-category-2">
                                        <div class="small-category-2-thumb img-1">
                                            <a
                                                href="{{ route('project.detail', ['slug' => $project->slug, 'id' => $project->id]) }}"><img
                                                    src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}""
                                                    alt=""></a>
                                        </div>
                                        <div class=" sc-2-detail">
                                            <h4 class="sc-jb-title"><a
                                                    href="{{ route('project.detail', ['slug' => $project->slug, 'id' => $project->id]) }}">{{ $project->project_title }}</a>
                                            </h4>
                                            <span>{{ $project->city->title }}
                                                /
                                                {{ $project->county->ilce_title }}
                                                {{ $project->neighbourhood ? '/ ' . $project->neighbourhood->mahalle_title : null }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mobile-hidden">
                    @if (count($projects))
                        <div class="properties-right list featured portfolio blog pb-5 bg-white">
                            <div class="container">
                                <div class="row project-filter-reverse blog-pots finish-projects-web">
                                    @foreach ($projects as $project)
                                        <div class="projectMobileMargin marginLeftRightZero" data-aos="zoom-in"
                                            data-aos-delay="150" style="height:200px">
                                            <div class="project-single no-mb aos-init aos-animate" style="height:100%"
                                                data-aos="zoom-in" data-aos-delay="150">
                                                <div class="listing-item compact" style="height:100%">
                                                    <a href="{{ route('project.detail', ['slug' => $project->slug, 'id' => $project->id]) }}"
                                                        class="listing-img-container">
                                                        <img class="project_brand_profile_image"
                                                            src="{{ URL::to('/') . '/storage/profile_images/' . $project->user->profile_image }}"
                                                            alt="">
                                                        <div class="listing-img-content"
                                                            style="padding-left:10px;text-transform:uppercase;">
                                                            <span
                                                                class="badge badge-phoenix text-left">{{ $project->project_title }}
                                                                <span class="d-block mt-1 mb-1"><small>{{ $project->city->title }}
                                                                        /
                                                                        {{ $project->county->ilce_title }}
                                                                        {{ $project->neighbourhood ? '/ ' . $project->neighbourhood->mahalle_title : null }}</small></span></span>

                                                        </div>
                                                        <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                                            alt="" style="height:100%;object-fit:contain">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <p>Henüz İlan Yayınlanmadı</p>
                    @endif
                </div>

            </div>
        </section>
    @endif

    @if (count($finishProjects))
        <section class="featured portfolio rec-pro disc bg-white">
            <div class="container">
                <div class="featured-heads">
                    <div class="section-title">
                        <h2>Tamamlanan Projeler</h2>
                    </div>
                    <a href="https://emlaksepette.com/kategori/topraktan-projeler" style="font-size: 11px;">
                        <button style="background-color: #ea2a28; color: white;padding: 5px 10px;border:none;"
                            class="w-100">
                            Tümünü Gör
                        </button>
                    </a>
                </div>

                <div class="row mobile-show homepage-9">
                    <div class="container">
                        <div class="row">
                            @foreach ($finishProjects as $project)
                                <div class="col-xl-3 col-lg-6 col-sm-6 aos-init aos-animate" data-aos="fade-up"
                                    data-aos-delay="150">
                                    <div class="small-category-2">
                                        <div class="small-category-2-thumb img-1">
                                            <a
                                                href="{{ route('project.detail', ['slug' => $project->slug, 'id' => $project->id]) }}"><img
                                                    src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}""
                                                    alt=""></a>
                                        </div>
                                        <div class=" sc-2-detail">
                                            <h4 class="sc-jb-title"><a
                                                    href="{{ route('project.detail', ['slug' => $project->slug, 'id' => $project->id]) }}">{{ $project->project_title }}</a>
                                            </h4>
                                            <span>{{ $project->city->title }}
                                                /
                                                {{ $project->county->ilce_title }}
                                                {{ $project->neighbourhood ? '/ ' . $project->neighbourhood->mahalle_title : null }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mobile-hidden">
                    @if (count($finishProjects))
                        <div class="properties-right list featured portfolio blog pb-5 bg-white">
                            <div class="container">
                                <div class="row project-filter-reverse blog-pots finish-projects-web">
                                    @foreach ($finishProjects as $project)
                                        <div class="projectMobileMargin marginLeftRightZero" data-aos="zoom-in"
                                            data-aos-delay="150" style="height:200px">
                                            <div class="project-single no-mb aos-init aos-animate" style="height:100%"
                                                data-aos="zoom-in" data-aos-delay="150">
                                                <div class="listing-item compact" style="height:100%">
                                                    <a href="{{ route('project.detail', ['slug' => $project->slug, 'id' => $project->id]) }}"
                                                        class="listing-img-container">
                                                        <img class="project_brand_profile_image"
                                                            src="{{ URL::to('/') . '/storage/profile_images/' . $project->user->profile_image }}"
                                                            alt="">
                                                        <div class="listing-img-content"
                                                            style="padding-left:10px;text-transform:uppercase;">
                                                            <span
                                                                class="badge badge-phoenix text-left">{{ $project->project_title }}
                                                                <span class="d-block mt-1 mb-1"><small>{{ $project->city->title }}
                                                                        /
                                                                        {{ $project->county->ilce_title }}
                                                                        {{ $project->neighbourhood ? '/ ' . $project->neighbourhood->mahalle_title : null }}</small></span></span>

                                                        </div>
                                                        <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                                            alt="" style="height:100%;object-fit:contain">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <p>Henüz İlan Yayınlanmadı</p>
                    @endif
                </div>

            </div>
        </section>
    @endif


    @if (count($continueProjects))
        <section class="featured portfolio rec-pro disc bg-white">
            <div class="container">
                <div class="featured-heads">
                    <div class="section-title">
                        <h2>Devam Eden Projeler</h2>
                    </div>
                    <a href="https://emlaksepette.com/kategori/topraktan-projeler" style="font-size: 11px;">
                        <button style="background-color: #ea2a28; color: white;padding: 5px 10px;border:none;"
                            class="w-100">
                            Tümünü Gör
                        </button>
                    </a>
                </div>

                <div class="row mobile-show homepage-9">
                    <div class="container">
                        <div class="row">
                            @foreach ($continueProjects as $project)
                                <div class="col-xl-3 col-lg-6 col-sm-6 aos-init aos-animate" data-aos="fade-up"
                                    data-aos-delay="150">
                                    <div class="small-category-2">
                                        <div class="small-category-2-thumb img-1">
                                            <a
                                                href="{{ route('project.detail', ['slug' => $project->slug, 'id' => $project->id]) }}"><img
                                                    src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}""
                                                    alt=""></a>
                                        </div>
                                        <div class=" sc-2-detail">
                                            <h4 class="sc-jb-title"><a
                                                    href="{{ route('project.detail', ['slug' => $project->slug, 'id' => $project->id]) }}">{{ $project->project_title }}</a>
                                            </h4>
                                            <span>{{ $project->city->title }}
                                                /
                                                {{ $project->county->ilce_title }}
                                                {{ $project->neighbourhood ? '/ ' . $project->neighbourhood->mahalle_title : null }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mobile-hidden">
                    @if (count($continueProjects))
                        <div class="properties-right list featured portfolio blog pb-5 bg-white">
                            <div class="container">
                                <div class="row project-filter-reverse blog-pots finish-projects-web">
                                    @foreach ($continueProjects as $project)
                                        <div class="projectMobileMargin marginLeftRightZero" data-aos="zoom-in"
                                            data-aos-delay="150" style="height:200px">
                                            <div class="project-single no-mb aos-init aos-animate" style="height:100%"
                                                data-aos="zoom-in" data-aos-delay="150">
                                                <div class="listing-item compact" style="height:100%">
                                                    <a href="{{ route('project.detail', ['slug' => $project->slug, 'id' => $project->id]) }}"
                                                        class="listing-img-container">
                                                        <img class="project_brand_profile_image"
                                                            src="{{ URL::to('/') . '/storage/profile_images/' . $project->user->profile_image }}"
                                                            alt="">
                                                        <div class="listing-img-content"
                                                            style="padding-left:10px;text-transform:uppercase;">
                                                            <span
                                                                class="badge badge-phoenix text-left">{{ $project->project_title }}
                                                                <span class="d-block mt-1 mb-1"><small>{{ $project->city->title }}
                                                                        /
                                                                        {{ $project->county->ilce_title }}
                                                                        {{ $project->neighbourhood ? '/ ' . $project->neighbourhood->mahalle_title : null }}</small></span></span>

                                                        </div>
                                                        <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                                            alt="" style="height:100%;object-fit:contain">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <p>Henüz İlan Yayınlanmadı</p>
                    @endif
                </div>

            </div>
        </section>
    @endif

    @if (count($soilProjects))
        <section class="featured portfolio rec-pro disc bg-white">
            <div class="container">
                <div class="featured-heads">
                    <div class="section-title">
                        <h2>Topraktan Projeler</h2>
                    </div>
                    <a href="https://emlaksepette.com/kategori/topraktan-projeler" style="font-size: 11px;">
                        <button style="background-color: #ea2a28; color: white;padding: 5px 10px;border:none;"
                            class="w-100">
                            Tümünü Gör
                        </button>
                    </a>
                </div>

                <div class="row mobile-show homepage-9">
                    <div class="container">
                        <div class="row">
                            @foreach ($soilProjects as $project)
                                <div class="col-xl-3 col-lg-6 col-sm-6 aos-init aos-animate" data-aos="fade-up"
                                    data-aos-delay="150">
                                    <div class="small-category-2">
                                        <div class="small-category-2-thumb img-1">
                                            <a
                                                href="{{ route('project.detail', ['slug' => $project->slug, 'id' => $project->id]) }}"><img
                                                    src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}""
                                                    alt=""></a>
                                        </div>
                                        <div class=" sc-2-detail">
                                            <h4 class="sc-jb-title"><a
                                                    href="{{ route('project.detail', ['slug' => $project->slug, 'id' => $project->id]) }}">{{ $project->project_title }}</a>
                                            </h4>
                                            <span>{{ $project->city->title }}
                                                /
                                                {{ $project->county->ilce_title }}
                                                {{ $project->neighbourhood ? '/ ' . $project->neighbourhood->mahalle_title : null }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mobile-hidden">
                    @if (count($soilProjects))
                        <div class="properties-right list featured portfolio blog pb-5 bg-white">
                            <div class="container">
                                <div class="row project-filter-reverse blog-pots finish-projects-web">
                                    @foreach ($soilProjects as $project)
                                        <div class="projectMobileMargin marginLeftRightZero" data-aos="zoom-in"
                                            data-aos-delay="150" style="height:200px">
                                            <div class="project-single no-mb aos-init aos-animate" style="height:100%"
                                                data-aos="zoom-in" data-aos-delay="150">
                                                <div class="listing-item compact" style="height:100%">
                                                    <a href="{{ route('project.detail', ['slug' => $project->slug, 'id' => $project->id]) }}"
                                                        class="listing-img-container">
                                                        <img class="project_brand_profile_image"
                                                            src="{{ URL::to('/') . '/storage/profile_images/' . $project->user->profile_image }}"
                                                            alt="">
                                                        <div class="listing-img-content"
                                                            style="padding-left:10px;text-transform:uppercase;">
                                                            <span
                                                                class="badge badge-phoenix text-left">{{ $project->project_title }}
                                                                <span class="d-block mt-1 mb-1"><small>{{ $project->city->title }}
                                                                        /
                                                                        {{ $project->county->ilce_title }}
                                                                        {{ $project->neighbourhood ? '/ ' . $project->neighbourhood->mahalle_title : null }}</small></span></span>

                                                        </div>
                                                        <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                                            alt="" style="height:100%;object-fit:contain">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <p>Henüz İlan Yayınlanmadı</p>
                    @endif
                </div>

            </div>
        </section>
    @endif



    @if (count($secondhandHousings))
        <section class="featured portfolio rec-pro disc bg-white">
            <div class="container">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="section-title">
                        <h2>Emlak İlanları</h2>
                    </div>
                </div>
                <div class="mobile-show">
                    @foreach ($secondhandHousings as $housing)
                        @php($sold = $housing->sold)

                            <div class="d-flex" style="flex-wrap: nowrap">
                                <div class="align-items-center d-flex " style="padding-right:0; width: 110px;">
                                    <div class="project-inner project-head">
                                        <a href="{{ route('housing.show', $housing->id) }}">
                                            <div class="homes">
                                                <div class="homes-img h-100 d-flex align-items-center"
                                                    style="width: 130px; height: 128px;">
                                                    <img src="{{ URL::to('/') . '/housing_images/' . json_decode($housing->housing_type_data)->image }}"
                                                        alt="{{ $housing->housing_title }}" class="img-responsive"
                                                        style="height: 80px !important;">
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="w-100" style="padding-left:0;">
                                    <div class="bg-white px-3 h-100 d-flex flex-column justify-content-center">

                                        <a style="text-decoration: none;height:100%"
                                            href="{{ route('housing.show', $housing->id) }}">
                                            <div class="d-flex"
                                                style="gap: 8px;justify-content:space-between;align-items:center">
                                                <h4>{{ mb_convert_case($housing->housing_title, MB_CASE_TITLE, 'UTF-8') }}
                                                </h4>
                                                <span
                                                class="btn  @if ($sold && $sold[0] == '1' || isset(json_decode($housing->housing_type_data)->off_sale1[0])) disabledShareButton @else addCollection mobileAddCollection @endif "  data-type='housing' data-id="{{ $housing->id }}" >
                                                   <i class="fa fa-bookmark-o"></i>
                                               </span>
                                                <span class="btn toggle-favorite bg-white"
                                                    data-housing-id="{{ $housing->id }}" style="color: white;">
                                                    <i class="fa fa-heart-o"></i>
                                                </span>
                                            </div>
                                        </a>
                                        <div class="d-flex" style="align-items:Center">
                                            <div class="d-flex" style="gap: 8px;">

                                                @if ($housing->step2_slug != 'gunluk-kiralik')
                                                    @if (isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                        <button class="btn second-btn  mobileCBtn"
                                                            style="background: #EA2B2E !important;width:100%;color:White">

                                                            <span class="text">Satışa Kapatıldı</span>
                                                        </button>
                                                    @else
                                                        @if ($sold != null && $sold != '2')
                                                            <button class="btn mobileCBtn second-btn "
                                                                @if ($sold == '0') style="background: orange !important;width:100%;color:White"
                                                            @else 
                                                            style="background: #EA2B2E !important;width:100%;color:White" @endif>
                                                                <span class="IconContainer">
                                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                                </span>
                                                                @if ($sold == '0')
                                                                    <span class="text">Rezerve Edildi</span>
                                                                @else
                                                                    <span class="text">Satıldı</span>
                                                                @endif
                                                            </button>
                                                        @else
                                                            <button class="CartBtn mobileCBtn" data-type='housing'
                                                                data-id='{{ $housing->id }}'>
                                                                <span class="IconContainer">
                                                                    <img src="{{ asset('sc.png') }}" alt="">

                                                                </span>
                                                                <span class="text">Sepete Ekle</span>
                                                            </button>
                                                        @endif
                                                    @endif
                                                @else
                                                    <button onclick="redirectToReservation()"
                                                        class="reservationBtn mobileCBtn">
                                                        <span class="IconContainer">
                                                            <img src="{{ asset('sc.png') }}" alt="">
                                                        </span>
                                                        <span class="text">Rezervasyon Yap</span>
                                                    </button>

                                                    <script>
                                                        function redirectToReservation() {
                                                            window.location.href = "{{ route('housing.show', [$housing->id]) }}";
                                                        }
                                                    </script>
                                                @endif
                                            </div>
                                            <span class="ml-auto text-primary priceFont">
                                                @if ($housing->discount_amount)
                                                    <svg viewBox="0 0 24 24" width="18" height="18"
                                                        stroke="#EA2B2E" stroke-width="2" fill="#EA2B2E"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="css-i6dzq1">
                                                        <polyline points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                        </polyline>
                                                        <polyline points="17 18 23 18 23 12">
                                                        </polyline>
                                                    </svg>
                                                @endif


                                                @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                @if ($sold != null)
                                                        @if ($sold != '1' && $sold != '0')
                                                            @if ($housing->step2_slug == 'gunluk-kiralik')
                                                                @if ($housing->discount_amount)
                                                                    <del>
                                                                        <span style="font-size:11px; color:#EA2B2E">
                                                                            {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                                        </span>
                                                                    </del> <br>
                                                                    {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0] - $housing->discount_amount, 0, ',', '.') }}
                                                                    ₺
                                                                @else
                                                                    {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                                    ₺
                                                                @endif
                                                                <span style="font-size:11px; color:#EA2B2E">
                                                                    1 Gece</span>
                                                            @else
                                                                @if ($housing->discount_amount)
                                                                    <del style="font-size:11px; color:#EA2B2E">

                                                                        {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                                    </del> <br>
                                                                    {{ number_format(json_decode($housing->housing_type_data)->price[0] - $housing->discount_amount, 0, ',', '.') }}
                                                                    ₺
                                                                @else
                                                                    {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                                    ₺
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @else
                                                        @if ($housing->step2_slug == 'gunluk-kiralik')
                                                            @if ($housing->discount_amount)
                                                                <del style="font-size:11px; color:#EA2B2E">
                                                                    {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                                </del> <br>
                                                                {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0] - $housing->discount_amount, 0, ',', '.') }}
                                                                ₺
                                                                <span style="font-size:11px; color:#EA2B2E">
                                                                    1 Gece</span>
                                                            @else
                                                                {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                                ₺
                                                                <span style="font-size:11px; color:#EA2B2E">
                                                                    1 Gece</span>
                                                            @endif
                                                        @else
                                                            @if ($housing->discount_amount)
                                                                <del style="font-size:11px; color:#EA2B2E">
                                                                    {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                                </del><br>
                                                                {{ number_format(json_decode($housing->housing_type_data)->price[0] - $housing->discount_amount, 0, ',', '.') }}
                                                                ₺
                                                            @else
                                                                {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                                ₺
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif

                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100" style="height:40px;background-color:#8080802e;margin-top:20px">
                                <div class="d-flex justify-content-between align-items-center"
                                    style="height: 100%;padding: 10px">
                                    <ul class="d-flex align-items-center h-100"
                                        style="list-style: none;padding:0;font-weight:600;justify-content:start;margin-bottom:0 !important">


                                        @if ($housing->column1_name)
                                            <li class="d-flex align-items-center itemCircleFont">

                                                <i class="fa fa-circle circleIcon mr-1"></i>
                                                <span>{{ json_decode($housing->housing_type_data)->{$housing->column1_name}[0] ?? null }}
                                                    @if ($housing->column1_additional)
                                                        {{ $housing->column1_additional }}
                                                    @endif
                                                </span>
                                            </li>
                                        @endif

                                        @if ($housing->column2_name)
                                            <li class="d-flex align-items-center itemCircleFont">

                                                <i class="fa fa-circle circleIcon mr-1"></i>
                                                <span>{{ json_decode($housing->housing_type_data)->{$housing->column2_name}[0] ?? null }}
                                                    @if ($housing->column2_additional)
                                                        {{ $housing->column2_additional }}
                                                    @endif
                                                </span>
                                            </li>
                                        @endif

                                        @if ($housing->column3_name)
                                            <li class="d-flex align-items-center itemCircleFont">

                                                <i class="fa fa-circle circleIcon mr-1"></i>
                                                <span>{{ json_decode($housing->housing_type_data)->{$housing->column3_name}[0] ?? null }}
                                                    @if ($housing->column3_additional)
                                                        {{ $housing->column3_additional }}
                                                    @endif
                                                </span>
                                            </li>
                                        @endif

                                        @if ($housing->column4_name)
                                            <li class="d-flex align-items-center itemCircleFont">

                                                <i class="fa fa-circle circleIcon mr-1"></i>
                                                <span>{{ json_decode($housing->housing_type_data)->{$housing->column4_name}[0] ?? null }}
                                                    @if ($housing->column4_additional)
                                                        {{ $housing->column4_additional }}
                                                    @endif
                                                </span>
                                            </li>
                                        @endif



                                    </ul>
                                    <span style="font-size: 11px !important">{!! $housing->city_title !!}
                                        {{ '/' }} {!! $housing->county_title !!}
                                    </span>
                                </div>

                            </div>
                            <hr>
                    @endforeach
                </div>

                <div class="mobile-hidden">
                    @if (count($secondhandHousings))
                        <section class="properties-right list featured portfolio blog  pb-5 bg-white">
                            <div class="container">
                                <div class="row project-filter-reverse blog-pots secondhand-housings-web">
                                    @foreach ($secondhandHousings as $housing)
                                        @php($sold = $housing->sold)

                                    
                                            <a href="{{ route('housing.show', [$housing->id]) }}"
                                                class="text-decoration-none">
                                                <div data-aos="fade-up" data-aos-delay="150">
                                                    <div class="landscapes">
                                                        <div class="project-single">
                                                            <div class="project-inner project-head">
                                                                <div class="homes">
                                                                    <div class="homes-img">
                                                                        <div class="type-tag button alt featured">
                                                                            @if ($housing->step2_slug == 'kiralik')
                                                                                Kiralık
                                                                            @elseif ($housing->step2_slug == 'gunluk-kiralik')
                                                                                Günlük Kiralık
                                                                            @else
                                                                                Satılık
                                                                            @endif
                                                                        </div>
                                                                        <img src="{{ URL::to('/') . '/housing_images/' . json_decode($housing->housing_type_data)->image }}"
                                                                            alt="{{ $housing->housing_title }}"
                                                                            class="img-responsive">
                                                                    </div>
                                                                </div>
                                                                <div class="button-effect-div">
                                                                    <span
                                                                    class="btn @if ($sold && $sold[0] == '1' || isset(json_decode($housing->housing_type_data)->off_sale1[0])) disabledShareButton @else addCollection mobileAddCollection @endif "  data-type='housing' data-id="{{ $housing->id }}" >
                                                                       <i class="fa fa-bookmark-o"></i>
                                                                   </span>

                                                                    <span class="btn toggle-favorite bg-white"
                                                                        data-housing-id={{ $housing->id }}>
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="homes-content p-3"
                                                                style="padding:20px !important">
                                                                <span style="text-decoration: none">

                                                                    <h4 style="height:30px">
                                                                        {{ mb_substr(mb_convert_case($housing->housing_title, MB_CASE_TITLE, 'UTF-8'), 0, 45, 'UTF-8') }}
                                                                        {{ mb_strlen($housing->housing_title, 'UTF-8') > 25 ? '...' : '' }}
                                                                    </h4>


                                                                    <p class="homes-address mb-3">


                                                                        <i class="fa fa-map-marker"></i>
                                                                        <span> {{ $housing->city_title }}
                                                                            {{ '/' }}
                                                                            {{ $housing->county_title }}
                                                                        </span>

                                                                    </p>
                                                                </span>
                                                                <!-- homes List -->
                                                                <ul class="homes-list clearfix pb-0"
                                                                    style="display: flex;justify-content:space-between">
                                                                    <li class="sude-the-icons"
                                                                        style="width:auto !important">
                                                                        <i class="fa fa-circle circleIcon mr-1"></i>
                                                                        <span>
                                                                            {{ json_decode($housing->housing_type_data)->{$housing->column1_name}[0] ?? null }}
                                                                            @if ($housing->column1_additional)
                                                                                {{ $housing->column1_additional }}
                                                                            @endif
                                                                        </span>
                                                                    </li>
                                                                    @if ($housing->column2_name)
                                                                        <li class="sude-the-icons"
                                                                            style="width:auto !important">
                                                                            <i class="fa fa-circle circleIcon mr-1"></i>
                                                                            <span>{{ json_decode($housing->housing_type_data)->{$housing->column2_name}[0] ?? null }}
                                                                                @if ($housing->column2_additional)
                                                                                    {{ $housing->column2_additional }}
                                                                                @endif
                                                                            </span>
                                                                        </li>
                                                                    @endif

                                                                    @if ($housing->column3_name)
                                                                        <li class="sude-the-icons"
                                                                            style="width:auto !important">
                                                                            <i class="fa fa-circle circleIcon mr-1"></i>
                                                                            <span>{{ json_decode($housing->housing_type_data)->{$housing->column3_name}[0] ?? null }}
                                                                                @if ($housing->column3_additional)
                                                                                    {{ $housing->column3_additional }}
                                                                                @endif
                                                                            </span>
                                                                        </li>
                                                                    @endif

                                                                    @if ($housing->column4_name)
                                                                        <li class="sude-the-icons"
                                                                            style="width:auto !important">
                                                                            <i class="fa fa-circle circleIcon mr-1"></i>
                                                                            <span>{{ json_decode($housing->housing_type_data)->{$housing->column4_name}[0] ?? null }}
                                                                                @if ($housing->column4_additional)
                                                                                    {{ $housing->column4_additional }}
                                                                                @endif
                                                                            </span>
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                                <ul class="homes-list clearfix pb-0"
                                                                style="display: flex; justify-content: space-between;">
                                                                <li
                                                                    style="font-size: 16px; font-weight: 700;width:100%; white-space:nowrap">
                                                                    @if ($housing->discount_amount)
                                                                        <svg viewBox="0 0 24 24" width="18"
                                                                            height="18" stroke="#EA2B2E"
                                                                            stroke-width="2" fill="#EA2B2E"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            class="css-i6dzq1">
                                                                            <polyline
                                                                                points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                            </polyline>
                                                                            <polyline points="17 18 23 18 23 12">
                                                                            </polyline>
                                                                        </svg>
                                                                    @endif


                                                                    @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                                        @if ($sold != null)
                                                                            @if ($sold != '1' && $sold != '0')
                                                                                @if ($housing->step2_slug == 'gunluk-kiralik')
                                                                                    @if ($housing->discount_amount)
                                                                                        <del>
                                                                                            <span
                                                                                                style="font-size:11px; color:#EA2B2E">
                                                                                                {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                                                            </span>
                                                                                        </del>
                                                                                        {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0] - $housing->discount_amount, 0, ',', '.') }}
                                                                                        ₺
                                                                                    @else
                                                                                        {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                                                        ₺
                                                                                    @endif
                                                                                    <span
                                                                                        style="font-size:11px; color:#EA2B2E">
                                                                                        1 Gece</span>
                                                                                @else
                                                                                    @if ($housing->discount_amount)
                                                                                        <del
                                                                                            style="font-size:11px; color:#EA2B2E">

                                                                                            {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                                                        </del>
                                                                                        {{ number_format(json_decode($housing->housing_type_data)->price[0] - $housing->discount_amount, 0, ',', '.') }}
                                                                                        ₺
                                                                                    @else
                                                                                        {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                                                        ₺
                                                                                    @endif
                                                                                @endif
                                                                            @endif
                                                                        @else
                                                                            @if ($housing->step2_slug == 'gunluk-kiralik')
                                                                                @if ($housing->discount_amount)
                                                                                    <del
                                                                                        style="font-size:11px; color:#EA2B2E">
                                                                                        {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                                                    </del>
                                                                                    {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0] - $housing->discount_amount, 0, ',', '.') }}
                                                                                    ₺
                                                                                    <span
                                                                                        style="font-size:11px; color:#EA2B2E">
                                                                                        1 Gece</span>
                                                                                @else
                                                                                    {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                                                    ₺
                                                                                    <span
                                                                                        style="font-size:11px; color:#EA2B2E">
                                                                                        1 Gece</span>
                                                                                @endif
                                                                            @else
                                                                                @if ($housing->discount_amount)
                                                                                    <del
                                                                                        style="font-size:11px; color:#EA2B2E">
                                                                                        {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                                                    </del>
                                                                                    {{ number_format(json_decode($housing->housing_type_data)->price[0] - $housing->discount_amount, 0, ',', '.') }}
                                                                                    ₺
                                                                                @else
                                                                                    {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                                                    ₺
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    @endif



                                                                </li>
                                                                @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                                    @if ($sold != null)
                                                                        @if ($sold != '1' && $sold != '0')
                                                                            @if (!$housing->discount_amount)
                                                                                <li
                                                                                    style="display: flex; justify-content: right;width:100%">
                                                                                    {{ date('j', strtotime($housing->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($housing->created_at))) }}
                                                                                </li>
                                                                            @endif
                                                                        @endif
                                                                        @else
                                                                        @if (!$housing->discount_amount)
                                                                        <li
                                                                            style="display: flex; justify-content: right;width:100%">
                                                                            {{ date('j', strtotime($housing->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($housing->created_at))) }}
                                                                        </li>
                                                                    @endif
                                                                    @endif
                                                                @endif

                                                            </ul>


                                                                @if ($housing->step2_slug != 'gunluk-kiralik')
                                                                    @if (isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                                                                        <button class="btn second-btn "
                                                                            style="background: #EA2B2E !important;width:100%;color:White">

                                                                            <span class="text">Satışa Kapatıldı</span>
                                                                        </button>
                                                                    @else
                                                                        @if ($sold != null && $sold != '2')
                                                                            <button class="btn second-btn "
                                                                                @if ($sold == '0') style="background: orange !important;width:100%;color:White" @else  style="background: #EA2B2E !important;width:100%;color:White" @endif>
                                                                                @if ($sold == '0')
                                                                                    <span class="text">Rezerve
                                                                                        Edildi</span>
                                                                                @else
                                                                                    <span class="text">Satıldı</span>
                                                                                @endif
                                                                            </button>
                                                                        @else
                                                                            <button class="CartBtn" data-type='housing'
                                                                                data-id='{{ $housing->id }}'>
                                                                                <span class="IconContainer">
                                                                                    <img src="{{ asset('sc.png') }}"
                                                                                        alt="">

                                                                                </span>
                                                                                <span class="text">Sepete Ekle</span>
                                                                            </button>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    <button onclick="redirectToReservation()"
                                                                        class="reservationBtn">
                                                                        <span class="IconContainer">
                                                                            <img src="{{ asset('sc.png') }}"
                                                                                alt="">
                                                                        </span>
                                                                        <span class="text">Rezervasyon Yap</span>
                                                                    </button>

                                                                    <script>
                                                                        function redirectToReservation() {
                                                                            window.location.href = "{{ route('housing.show', [$housing->id]) }}";
                                                                        }
                                                                    </script>
                                                                @endif


                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </a>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    @else
                        <p>Henüz İlan Yayınlanmadı</p>
                    @endif
                </div>
            </div>
        </section>

    @endif



@endsection

@section('scripts')
    <!-- lightbox2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- lightbox2 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $('.search-button').click(function() {
            $('.loading-area').removeClass('d-none')

            $.ajax({
                'url': '{{ URL::to('/') }}/magaza/{{ $slug }}',
                'type': 'POST',
                'data': {
                    'text': $('.search-input').val(),
                    "_token": "{{ csrf_token() }}",
                },
                'success': function(data) {
                    $('.loading-area').addClass('d-none')
                    $('.all-projects').html(data.projects)
                    $('.finish-projects').html(data.finishProjects)
                    $('.finish-projects-web').slick({
                        loop: true,
                        nav: false,
                        slidesToShow: 4,
                        margin: 10,
                    })

                    $('.continue-projects-web').slick({
                        loop: true,
                        nav: false,
                        slidesToShow: 4,
                        margin: 10,
                    })

                    $('.secondhand-housings-web').slick({
                        loop: true,
                        nav: false,
                        slidesToShow: 4,
                        margin: 10,
                    });
                },
                'error': function(request, error) {
                    alert("Request: " + JSON.stringify(request));
                }
            });
        })

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
                margin: 0,
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
                        arrows: false
                    }
                }]
            });
        });
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

    <script>
        $('.finish-projects-web').slick({
            infinite: false,
            slidesToShow: 3,
            slidesToScroll: 3,
            dots: false,
            arrows: true,
            adaptiveHeight: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        dots: false,
                        arrows: false
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: false,
                        arrows: false
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: false,
                        arrows: false
                    }
                }
            ]
        })

        $('.continue-projects-web').slick({
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 4,
            dots: false,
            arrows: true,
            adaptiveHeight: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        dots: false,
                        arrows: false
                    }
                },
                {
                    breakpoint: 993,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: false,
                        arrows: false
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: false,
                        arrows: false
                    }
                }
            ]
        })

        $('.secondhand-housings-web').slick({
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 4,
            dots: false,
            arrows: true,
            adaptiveHeight: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        dots: false,
                        arrows: false
                    }
                },
                {
                    breakpoint: 993,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: false,
                        arrows: false
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: false,
                        arrows: false
                    }
                }
            ]
        });
    </script>
@endsection

@section('styles')
    <style>
        .slick-track {
            margin: 0 !important;
        }

        .slick-slide {
            margin: 10px
        }

        .section-title h2 {
            color: black !important
        }

        .section-title:before {
            background-color: black !important
        }

        .bannerResize,
        .bannerResizeGrid {
            padding: 0 !important;
        }

        .projectMobileMargin {
            margin-bottom: 20px !important;
        }

        @media (max-width: 768px) {

            .bannerResize,
            .bannerResizeGrid {
                padding: 0 !important;
            }

            .section-title {
                margin-bottom: 20px !important;
                padding-bottom: 0 !important;
            }

            .circleIcon {
                font-size: 5px;
                color: #e54242;
                padding-right: 5px
            }

            .priceFont {
                font-weight: 600;
                font-size: 11px;
            }
        }
    </style>
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

        .badgeYearIcon{
            display: flex !important;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-left: 5px;
        }

        .badgeYearIcon img {
            width: 25px;
            height: 25px;
        }
    </style>
@endsection
