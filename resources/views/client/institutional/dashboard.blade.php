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

                            <p class="brand-name"><a href="{{ route('institutional.profile', ["slug" => Str::slug($store->name), "userID" => $store->id]) }}"
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
                                @if ($store->year && $store->name == "Maliyetine Ev")
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
                
                    </div>

                </div>

                <div class="card-body">
                    <nav class="navbar" style="padding: 0 !important">
                        <div class="navbar-items">
                            <a class="navbar-item active"
                                href="{{ route('institutional.dashboard', ["slug" => Str::slug($store->name), "userID" => $store->id]) }}">Anasayfa</a>
                            <a class="navbar-item"
                                href="{{ route('institutional.profile', ["slug" => Str::slug($store->name), "userID" => $store->id]) }}">Mağaza Profili</a>
                            <a class="navbar-item"
                                href="{{ route('institutional.projects.detail', ["slug" => Str::slug($store->name), "userID" => $store->id]) }}">Proje
                                İlanları</a>
                                <a class="navbar-item"
                                href="{{ route('institutional.housings',["slug" => Str::slug($store->name), "userID" => $store->id]) }}">Emlak İlanları</a>
                                <a class="navbar-item"
                                href="{{ route('institutional.teams', ["slug" => Str::slug($store->name), "userID" => $store->id]) }}">Ekibimiz</a>
                            
                        </div>
                        <div class="search-form">
                            <input class="search-input" type="text" placeholder="Mağazada Ara" id="search-project"
                                aria-label="Search" name="q">
                            <div class="header-search__suggestions">
                                <div class="header-search__suggestions__section">
                                    <h5>Projeler</h5>
                                    <div class="header-search__suggestions__section__items">
                                        @foreach ($store->projects as $item)
                                            <a href="{{ route('project.detail', ['slug' => $item->slug, 'id' => $item->id+1000000]) }}"
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
                <div class="featured-heads mb-5">
                    <div class="section-title">
                        <h2>Tüm Projeler</h2>
                    </div>
                </div>
                <div class="row">
                    @foreach ($projects as $project)
                        <x-project-card :project="$project" />
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    @if ($secondhandHousings->isNotEmpty())
    <section class="featured portfolio rec-pro disc bg-white">
        <div class="container">
            <div class="featured-heads mb-3">
                <div class="section-title">
                    <h2>Emlak İlanları</h2>
                </div>
            </div>

            <div class="mobile-show">
                @foreach ($secondhandHousings as $housing)
                    @php($sold = $housing->sold)
                    @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]) && (($sold && $sold != '1') || !$sold))
                        <x-housing-card-mobile :housing="$housing" :sold="$sold" />
                    @endif
                @endforeach
            </div>

            <div class="mobile-hidden" style="margin-top: 20px">
                <section class="properties-right list featured portfolio blog pb-5 bg-white">
                    <div class="container">
                        <div class="row">
                            @forelse ($secondhandHousings as $housing)
                                @php($sold = $housing->sold)
                                @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]) && (($sold && $sold != '1') || !$sold))
                                    <div class="col-md-3">
                                        <x-housing-card :housing="$housing" :sold="$sold" />
                                    </div>
                                @endif
                            @empty
                                <p>Henüz İlan Yayınlanmadı</p>
                            @endforelse
                        </div>
                    </div>
                </section>
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
