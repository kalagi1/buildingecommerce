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

    <x-store-card :store="$store" />


    <section class="featured portfolio rec-pro disc bg-white">
        @if ($secondhandHousings->isNotEmpty())
            <div class="container">
                <div class="mobile-hidden">
                    <section class="properties-right list featured portfolio blog pb-5 pt-3 bg-white">
                        <div class="row">
                            @php
                                function addQueryParamToUrl($paramName, $paramValue)
                                {
                                    $queryParams = request()->query();
                                    $queryParams[$paramName] = $paramValue;

                                    return request()->url() . '?' . http_build_query($queryParams);
                                }

                                $counts = [
                                    'satilik' => 0,
                                    'kiralik' => 0,
                                    'gunluk-kiralik' => 0,
                                ];
                            @endphp
                            @php
                                $filter = request('filter', 'tumu');
                            @endphp
                            @foreach ($secondhandHousings as $housing)
                                @php $sold = $housing->sold @endphp
                                @if (
                                    !isset(json_decode($housing->housing_type_data)->off_sale1[0]) &&
                                        (($sold && $sold != '1') ||
                                            (!$sold && in_array($housing->step2_slug, ['satilik', 'kiralik', 'gunluk-kiralik']))))
                                    @php
                                        $counts[$housing->step2_slug]++;
                                    @endphp
                                @endif
                            @endforeach

                            <div class="col-md-12">
                                <div class="tabbed-content button-tabs mb-3">
                                    <ul class="tabs">
                                        <li class="nav-item-block {{ $filter === 'tumu' ? 'active' : '' }}">
                                            <a href="{{ addQueryParamToUrl('filter', 'tumu') }}">
                                                <div class="tab-title">
                                                    <span>Tümü</span>
                                                </div>
                                            </a>
                                        </li>
                                        @foreach ($counts as $slug => $count)
                                            <li class="nav-item-block {{ $filter === $slug ? 'active' : '' }}"
                                                role="presentation">

                                                <a href="{{ addQueryParamToUrl('filter', $slug) }}">
                                                    <div class="tab-title">
                                                        <span>
                                                            @if ($slug == 'satilik')
                                                                Satılık
                                                            @elseif($slug == 'kiralik')
                                                                Kiralık
                                                            @elseif($slug == 'gunluk-kiralik')
                                                                Günlük Kiralık
                                                            @endif
                                                            ({{ $count }})
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>


                        </div>
                        <div class="row">


                            @forelse ($secondhandHousings as $housing)
                                @php($sold = $housing->sold)
                                @if (
                                    !isset(json_decode($housing->housing_type_data)->off_sale1[0]) &&
                                        (($sold && $sold != '1') || !$sold) &&
                                        ($filter === 'tumu' ||
                                            ($filter === 'satilik' && $housing->step2_slug === 'satilik') ||
                                            ($filter === 'gunluk-kiralik' && $housing->step2_slug === 'gunluk-kiralik') ||
                                            ($filter === 'kiralik' && $housing->step2_slug === 'kiralik')))
                                    <div class="col-md-3">
                                        <x-housing-card :housing="$housing" :sold="$sold" />
                                    </div>
                                @endif
                            @empty
                                <p>Henüz İlan Yayınlanmadı</p>
                            @endforelse
                        </div>
                    </section>
                </div>
                <div class="mobile-shoe">
                    <section class="properties-right list featured portfolio blog pb-5 pt-3 bg-white">
                        <div class="row">
                            @php
                                function addQueryParamToUrl($paramName, $paramValue)
                                {
                                    $queryParams = request()->query();
                                    $queryParams[$paramName] = $paramValue;

                                    return request()->url() . '?' . http_build_query($queryParams);
                                }

                                $counts = [
                                    'satilik' => 0,
                                    'kiralik' => 0,
                                    'gunluk-kiralik' => 0,
                                ];
                            @endphp
                            @php
                                $filter = request('filter', 'tumu');
                            @endphp
                            @foreach ($secondhandHousings as $housing)
                                @php $sold = $housing->sold @endphp
                                @if (
                                    !isset(json_decode($housing->housing_type_data)->off_sale1[0]) &&
                                        (($sold && $sold != '1') ||
                                            (!$sold && in_array($housing->step2_slug, ['satilik', 'kiralik', 'gunluk-kiralik']))))
                                    @php
                                        $counts[$housing->step2_slug]++;
                                    @endphp
                                @endif
                            @endforeach

                            <div class="col-md-12">
                                <div class="tabbed-content button-tabs mb-3">
                                    <ul class="tabs">
                                        <li class="nav-item-block {{ $filter === 'tumu' ? 'active' : '' }}">
                                            <a href="{{ addQueryParamToUrl('filter', 'tumu') }}">
                                                <div class="tab-title">
                                                    <span>Tümü</span>
                                                </div>
                                            </a>
                                        </li>
                                        @foreach ($counts as $slug => $count)
                                            <li class="nav-item-block {{ $filter === $slug ? 'active' : '' }}"
                                                role="presentation">

                                                <a href="{{ addQueryParamToUrl('filter', $slug) }}">
                                                    <div class="tab-title">
                                                        <span>
                                                            @if ($slug == 'satilik')
                                                                Satılık
                                                            @elseif($slug == 'kiralik')
                                                                Kiralık
                                                            @elseif($slug == 'gunluk-kiralik')
                                                                Günlük Kiralık
                                                            @endif
                                                            ({{ $count }})
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>


                        </div>
                        <div class="row">


                            @forelse ($secondhandHousings as $housing)
                                @php($sold = $housing->sold)
                                @if (
                                    !isset(json_decode($housing->housing_type_data)->off_sale1[0]) &&
                                        (($sold && $sold != '1') || !$sold) &&
                                        ($filter === 'tumu' ||
                                            ($filter === 'satilik' && $housing->step2_slug === 'satilik') ||
                                            ($filter === 'gunluk-kiralik' && $housing->step2_slug === 'gunluk-kiralik') ||
                                            ($filter === 'kiralik' && $housing->step2_slug === 'kiralik')))
                                    <div class="col-md-3">
                                        <x-housing-card-mobile :housing="$housing" :sold="$sold" />
                                    </div>
                                @endif
                            @empty
                                <p>Henüz İlan Yayınlanmadı</p>
                            @endforelse
                        </div>
                    </section>
                </div>
            </div>
        @else
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        <h2 class="mt-5 mb-3">Mağazaya ait emlak kaydı bulunamadı.</h2>
                        <p>Lütfen daha sonra tekrar deneyin veya başka bir arama yapın.</p>
                    </div>
                </div>
            </div>
        @endif
    </section>








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
@endsection
