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
            <div class="collections">
                @foreach ($store->child as $item)
                    @if (count($item->collections) > 0)
                        <div class="collection">
                            <div class="collection-head">
                                <div><a
                                        href="{{ route('club.dashboard', ['slug' => Str::slug($item->name), 'userID' => $item->id]) }}">
                                        @if ($item->profile_image == 'indir.png')
                                            @php
                                                $nameInitials = collect(preg_split('/\s+/', $item->name))
                                                    ->map(function ($word) {
                                                        return mb_strtoupper(mb_substr($word, 0, 1));
                                                    })
                                                    ->take(2)
                                                    ->implode('');
                                            @endphp

                                            <div class="profile-initial">{{ $nameInitials }}</div>
                                        @else
                                            <img src="{{ asset('storage/profile_images/' . $item->profile_image) }}"
                                                alt="{{ $item->name }}" style="object-fit: contain !important;"
                                                class="img-responsive collection-owner">
                                        @endif
                                        <span class="label with-image"> {{ $item->name }}</span>
                                    </a></div>
                                <ul class="collection-actions">
                                    <li> <button>
                                            <a href="whatsapp://send?text={{ route('club.dashboard', ['slug' => Str::slug($item->name), 'userID' => $item->id]) }}"
                                                style="color: green">
                                                <i class="fa fa-whatsapp"></i><span>Whatsapp'ta Paylaş</span>
                                            </a>
                                        </button></li>

                                </ul>
                            </div>
                            <div class="collection-content">
                                <div class="collection-images">
                                    @foreach ($item->collections->take(1) as $collection)
                                        @foreach ($collection->links->take(4) as $link)
                                            @php
                                                $projectFirstImage = null;
                                                if ($link->item_type == 1) {
                                                    $data = $link->projectHousingData(
                                                        $link->project->id,
                                                        $link->room_order,
                                                    );
                                                    foreach ($data as $key => $value) {
                                                        if (isset($value['name']) && $value['name'] == 'image[]') {
                                                            $projectFirstImage = $value['value'];
                                                        }
                                                    }
                                                }
                                            @endphp


                                            <img src="{{ $link->item_type == 1 ? URL::to('/') . '/project_housing_images/' . $projectFirstImage : URL::to('/') . '/housing_images/' . json_decode($link->housing->housing_type_data)->image }}"
                                                alt="product-image">
                                        @endforeach
                                    @endforeach

                                </div>
                                <div class="collection-navigation"><a
                                        href="{{ route('club.dashboard', ['slug' => Str::slug($item->name), 'userID' => $item->id]) }}"><span>Koleksiyonlara
                                            Git</span> ({{ count($item->collections) }} Koleksiyon)</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                @foreach ($collections as $collection)
                    <div class="collection">
                        <div class="collection-head">
                            <div><a
                                    href="{{ route('sharer.links.showClientLinks', ['slug' => Str::slug($store->name), 'userid' => $store->id, 'id' => $collection->id]) }}"><img
                                        class="collection-owner"
                                        src="{{ url('storage/profile_images/' . $collection->user->profile_image) }}"><span
                                        class="label with-image"> {{ $store->name }} <i class="fa fa-angle-right"></i>
                                        {{ \Illuminate\Support\Str::limit($collection->name, 20, '...') }}
                                        Koleksiyonu</span></a></div>
                            <ul class="collection-actions">
                                <li> <button>
                                        <a href="whatsapp://send?text={{ route('sharer.links.showClientLinks', ['slug' => Str::slug($store->name), 'userid' => $store->id, 'id' => $collection->id]) }}"
                                            style="color: green">
                                            <i class="fa fa-whatsapp"></i><span>Whatsapp'ta Paylaş</span>
                                        </a>
                                    </button></li>

                            </ul>
                        </div>
                        <div class="collection-content">
                            <div class="collection-images">
                                @foreach ($collection->links->take(4) as $link)
                                    @php
                                        $projectFirstImage = null;
                                        if ($link->item_type == 1) {
                                            $data = $link->projectHousingData($link->project->id, $link->room_order);
                                            foreach ($data as $key => $value) {
                                                if (isset($value['name']) && $value['name'] == 'image[]') {
                                                    $projectFirstImage = $value['value'];
                                                }
                                            }
                                        }
                                    @endphp


                                    <img src="{{ $link->item_type == 1 ? URL::to('/') . '/project_housing_images/' . $projectFirstImage : URL::to('/') . '/housing_images/' . json_decode($link->housing->housing_type_data)->image }}"
                                        alt="product-image">
                                @endforeach
                            </div>
                            <div class="collection-navigation">
                                <div class="collection-stats">
                                    <span class="collection-show-count"><i class="fa fa-eye"></i>
                                        {{ count($collection->clicks) }}</span>
                                </div><a
                                    href="{{ route('sharer.links.showClientLinks', ['slug' => Str::slug($store->name), 'userid' => $store->id, 'id' => $collection->id]) }}"><span>Koleksiyona
                                        Git</span> ({{ count($collection->links) }} İlan)</a>
                            </div>
                        </div>
                    </div>
                @endforeach
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

        .collections {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            margin: 0 auto;
            justify-content: space-between;
        }

        .collection {
            display: flex;
            flex-direction: column;
            background-color: #fff;
            border: 1px solid #e6e6e6;
            width: calc(50% - 10px);
            margin-bottom: 20px;
            box-sizing: border-box;
            box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.05);
        }

        .collection-head {
            display: flex;
            justify-content: space-between;
            color: #333;
            border-bottom: 1px solid #e6e6e6;
            font-size: 16px;
            padding: 12px 15px;
            height: 44px;
            box-sizing: border-box;
        }

        .collection-head div,
        .collection-head a {
            display: flex;
            align-items: center;
            font-size: 11px;
            font-weight: 600;
            flex: 1;
            width: calc(100% - 100px);
        }

        .collection-owner {
            border-radius: 50%;
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }

        .collection-head a span.label.with-image {
            width: calc(100% - 44px);
        }

        .collection-head div span.label,
        .collection-head a span.label {
            display: block;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            width: calc(100% - 10px);
        }

        .collection-head .collection-actions {
            display: flex;
            align-items: center;
            margin-bottom: 0 !important;
        }

        .collection-head button i {
            margin-right: 5px
        }

        .collection-head button {
            display: flex;
            align-items: center;
            background-color: transparent;
            color: black;
            font-size: 12px;
            border: none;
            padding: 0;
            cursor: pointer;
            transition: all 0.3s ease-out;
        }

        .collection-images img {
            border: 1px solid #e6e6e6;
            border-radius: 4px;
            width: 50px;
            height: 64px;
            margin-right: 10px;
            object-fit: cover;
        }

        .collection-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
        }

        .collection-content .collection-images {
            display: flex;
        }

        .collection-content .collection-navigation {
            display: flex;
            flex-direction: column;
        }

        .collection-stats {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 10px;
            font-size: 12px;
            color: #666666;
            font-weight: 600;
            line-height: 15px;
            letter-spacing: 0;
            text-align: center;
            padding-right: 10px;
        }

        .collection-stats .spacer {
            background: #999999;
            opacity: 0.3;
            width: 1px;
            height: 10px;
            display: inline-block;
            margin: 0 7px;
        }

        .collection-stats i {
            margin-right: 6px;
            font-size: 9px;
        }

        .collection-content a {
            color: #EA2B2E;
            text-align: center;
            padding: 10px 0;
            transition: all 0.3s ease-out;
        }

        .collection-show-count {
            color: black;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection
