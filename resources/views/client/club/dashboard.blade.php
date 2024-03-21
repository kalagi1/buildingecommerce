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

 

    <section>
        <div class="container">
            <div class="card border mb-3" data-list="{&quot;valueNames&quot;:[&quot;icon-list-item&quot;]}">

                <div class="card-body">
                    <div class="row list" id="icon-list">
                        @foreach ($collections as $collection)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <a href="{{ route('sharer.links.showClientLinks', ['slug' => Str::slug($store->name), 'userid' => $store->id, 'id' => $collection->id]) }}"
                                    class="text-decoration-none">

                                    <span class="icon-list-item d-none">{{ $collection->name }}</span>
                                    <div class="border rounded-2 p-3 mb-4 text-center bg-body-emphasis dark__bg-gray-1000 shadow-sm"
                                        style="color:black">
                                        <span class="numberCollection"
                                            style="display:flex;align-items:center;justify-content:center">
                                            <span>{{ count($collection->links) }} İlan</span>
                                        </span>
                                        <input style="cursor: pointer;background-color: #EA2B2E;color:White !important;"
                                            class="form-control form-control-sm mt-3 text-center w-100 text-dark dark__text-gray-100 bg-body-secondary dark__bg-gray-1100"
                                            type="text" readonly="readonly" value="{{ $collection->name }}">
                                    </div>
                                </a>
                            </div>
                        @endforeach



                    </div>
                </div>
            </div>
        </div>
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
@endsection
