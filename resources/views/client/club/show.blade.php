@extends('client.layouts.master')

@section('content')
    <section>
        <div class="brand-head">
            <div class="container">
                <div class="card mb-3">
                    <div class="card-img-top" style="background-color: {{ $store->banner_hex_code }}">
                        <div class="brands-square w-100">
                            <img src="{{ url('storage/profile_images/' . $store->profile_image) }}" alt=""
                                class="brand-logo">
                            <p class="brand-name"><span
                                    style="color:White">
                                    {{ $store->name }}
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
                                    </style>
                                    @if ($store->corporate_account_status)
                                        <svg id="Layer_1" style="enable-background:new 0 0 120 120;" version="1.1"
                                            width="24px" height="24px" viewBox="0 0 120 120" xml:space="preserve"
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <g>
                                                <path class="st0"
                                                    d="M99.5,52.8l-1.9,4.7c-0.6,1.6-0.6,3.3,0,4.9l1.9,4.7c1.1,2.8,0.2,6-2.3,7.8L93,77.8c-1.4,1-2.3,2.5-2.7,4.1   l-0.9,5c-0.6,3-3.1,5.2-6.1,5.3l-5.1,0.2c-1.7,0.1-3.3,0.8-4.5,2l-3.5,3.7c-2.1,2.2-5.4,2.7-8,1.2l-4.4-2.6   c-1.5-0.9-3.2-1.1-4.9-0.7l-5,1.2c-2.9,0.7-6-0.7-7.4-3.4l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8   l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8   l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6c1.4-2.7,4.4-4.1,7.4-3.4l5,1.2c1.6,0.4,3.4,0.2,4.9-0.7l4.4-2.6c2.6-1.5,5.9-1.1,8,1.2   l3.5,3.7c1.2,1.2,2.8,2,4.5,2l5.1,0.2c3,0.1,5.6,2.3,6.1,5.3l0.9,5c0.3,1.7,1.3,3.2,2.7,4.1l4.2,2.9C99.7,46.8,100.7,50,99.5,52.8z   " />
                                                <g class="st1">
                                                    <path
                                                        d="M43.4,93.5l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4    c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6    c0.8-1.6,2.2-2.7,3.7-3.2c-2.7-0.4-5.4,1-6.6,3.5l-2.3,4.6c-0.8,1.5-2.1,2.7-3.7,3.2l-4.8,1.6c-2.9,1-4.7,3.8-4.4,6.8l0.5,5.1    c0.2,1.7-0.3,3.4-1.4,4.7l-3.2,4c-1.9,2.4-1.9,5.7,0,8.1l3.2,4c1.1,1.3,1.6,3,1.4,4.7l-0.5,5.1c-0.3,3,1.5,5.8,4.4,6.8l4.8,1.6    c1.6,0.5,2.9,1.7,3.7,3.2l2.3,4.6c1.4,2.7,4.4,4.1,7.4,3.4l0.6-0.1C46.3,96.7,44.4,95.5,43.4,93.5z" />
                                                    <path
                                                        d="M60.6,22.5l4.4-2.6c0.4-0.2,0.8-0.4,1.2-0.5c-1.4-0.2-2.9,0.1-4.1,0.8l-4.4,2.6c-0.4,0.2-0.8,0.4-1.2,0.5    C57.9,23.5,59.3,23.3,60.6,22.5z" />
                                                    <path
                                                        d="M81,92c-0.5,0-1,0.1-1.4,0.2l3.6-0.2c0.5,0,0.9-0.1,1.4-0.2L81,92z" />
                                                    <path
                                                        d="M65,98.9l-4.4-2.6c-1.5-0.9-3.2-1.1-4.9-0.7l-0.6,0.1c0.9,0.1,1.7,0.4,2.5,0.8l4.4,2.6c1.7,1,3.6,1.1,5.4,0.5    C66.6,99.6,65.8,99.4,65,98.9z" />
                                                </g>
                                                <polyline class="st0" points="44,53.6 56.5,67.9 82.1,47.3  " />
                                                <path class="st2"
                                                    d="M53.5,75.3c-1.4,0-2.8-0.6-3.8-1.7L37.2,59.3c-1.8-2.1-1.6-5.2,0.4-7.1c2.1-1.8,5.2-1.6,7.1,0.4l9.4,10.7   l21.9-17.6c2.1-1.7,5.3-1.4,7,0.8c1.7,2.2,1.4,5.3-0.8,7L56.6,74.2C55.7,74.9,54.6,75.3,53.5,75.3z" />
                                            </g>
                                        </svg>
                                    @endif

                                </span>
                            </p>
                            <p class="brand-name"><i class="fa fa-angle-right"></i> </p>

                            <p class="brand-name">{{ $collection->name }}</p>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="container featured portfolio rec-pro disc bg-white">
            <div class="content">
                <div class="card border mb-3 mt-3" data-list="{&quot;valueNames&quot;:[&quot;icon-list-item&quot;]}">

                    <div class="card-body">
                        <div class="mobile-hidden">
                            <div class="row project-filter-reverse blog-pots" style="width: 100%">
                                <table class="table">
                                    <tbody class="collection-title">

                                        @foreach ($mergedItems as $item)
                                            <tr>
                                                <td>
                                                    #{{ $item['item_type'] == 1 ? $item['project']->id + $item['room_order'] + 10000000 : $item['housing']->id + 2000000 }}

                                                </td>

                                                <td>
                                                    <a
                                                        href="{{ $item['item_type'] == 1 ? route('project.housings.detail', [$item['project']['slug'], $item['room_order']]) : route('housing.show', [$item['housing']['id']]) }}">
                                                        <img src="{{ $item['item_type'] == 1 ? URL::to('/') . '/project_housing_images/' . $item['project_values']['image[]'] : URL::to('/') . '/housing_images/' . json_decode($item['housing']['housing_type_data'])->image }}"
                                                            alt="home-1" class="img-responsive"
                                                            style="height: 70px !important; object-fit: cover;width:100px">
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ $item['item_type'] == 1 ? $item['project_values']['advertise_title[]'] : $item['housing']->title }}
                                                    <br>
                                                    @if ($item['item_type'] == 1)
                                                        {!! $item['room_order'] . " No'lu Daire <br>" !!}
                                                    @endif <span
                                                        style="font-size: 9px !important;font-weight:700">
                                                        {{ $item['item_type'] == 1 ? $item['project']['city']['title'] . ' / ' . $item['project']['county']['ilce_title'] . ' / ' . $item['project']['neighbourhood']['mahalle_title'] : $item['housing']['city']['title'] . ' / ' . $item['housing']['county']['title'] . ' / ' . $item['housing']['neighborhood']['mahalle_title'] }}
                                                        <br>
                                                    </span>
                                                </td>
                                                <td>
                                                    @if (($item['action'] && $item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                                                        @php
                                                            $discountedPrice = null;
                                                            $price = null;
                                                            $discountRate = null;
                                                            if ($item['item_type'] == 2 && isset(json_decode($item['housing']['housing_type_data'])->discount_rate[0])) {
                                                                $discountRate = json_decode($item['housing']['housing_type_data'])->discount_rate[0];
                                                                $price = json_decode($item['housing']['housing_type_data'])->price[0] - $item['discount_amount'];
                                                                $discountedPrice = $price - ($price * $discountRate) / 100;
                                                            } elseif ($item['item_type'] == 1 && isset($item['project_values']['discount_rate[]']) && $item['project_values']['discount_rate[]'] != 0) {
                                                                $discountRate = $item['project_values']['discount_rate[]'];
                                                                $price = $item['project_values']['price[]'] - $item['discount_amount'];
                                                                $discountedPrice = $price - ($price * $discountRate) / 100;
                                                            }
                                                        @endphp

                                                        @if (isset($discountRate) && $discountRate != 0)
                                                            <span style="color: green;">
                                                                {{ number_format($discountedPrice, 0, ',', '.') }} ₺
                                                            </span><br>
                                                            <del style="color: red;">
                                                                {{ number_format($item['item_type'] == 1 ? $item['project_values']['price[]'] : json_decode($item['housing']['housing_type_data'])->price[0], 0, ',', '.') }}
                                                                ₺
                                                            </del>
                                                        @else
                                                            <span style="color: green; font-size:12px !important">
                                                                {{ number_format($item['item_type'] == 1 ? $item['project_values']['price[]'] : json_decode($item['housing']['housing_type_data'])->price[0], 0, ',', '.') }}
                                                                ₺
                                                            </span>
                                                        @endif
                                                    @endif
                                                </td>



                                                <td>

                                                    @if ($item['item_type'] != 1)
                                                        @if ($item['housing']->step2_slug != 'gunluk-kiralik')
                                                            @if (isset(json_decode($item['housing']['housing_type_data'])->off_sale1[0]))
                                                                <button class="btn second-btn mobileCBtn"
                                                                    style="background: #EA2B2E !important;width:100%;height:40px !important;color:White">
                                                                    <span class="text">Satıldı</span>
                                                                </button>
                                                            @else
                                                                @if ($item['action'] && $item['action'] != 'tryBuy' && $item['action'] != 'noCart')
                                                                    <button class="btn mobileCBtn second-btn "
                                                                        @if ($item['action'] == 'payment_await') style="background: orange !important;width:100%;height:40px !important;color:White"
                                                        @else style="background: #EA2B2E !important;width:100%;height:40px !important;color:White" @endif>
                                                                        <span class="IconContainer">
                                                                            <img src="{{ asset('sc.png') }}"
                                                                                alt="">
                                                                        </span>
                                                                        @if ($item['action'] == 'payment_await')
                                                                            <span class="text">Rezerve Edildi</span>
                                                                        @else
                                                                            <span class="text">Satıldı</span>
                                                                        @endif
                                                                    </button>
                                                                @elseif ($item['action'] == 'payment_await')
                                                                    <button class="btn mobileCBtn second-btn"
                                                                        style="background: orange !important;width:100%;height:40px !important;color:White">
                                                                        <span class="text">Ödeme Bekleniyor</span>
                                                                    </button>
                                                                @elseif ($item['action'] == 'tryBuy')
                                                                    <button class="btn mobileCBtn second-btn"
                                                                        style="background: orange !important;width:100%;height:40px !important;color:White">
                                                                        <span class="text">Satın Al</span>
                                                                    </button>
                                                                @else
                                                                    <button class="CartBtn mobileCBtn" data-type='housing'
                                                                        data-id='{{ $item['housing']->id }}'>
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
                                                                class="reservationBtn mobileCBtn">
                                                                <span class="IconContainer">
                                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                                </span>
                                                                <span class="text">Rezervasyon Yap</span>
                                                            </button>
                                                            <script>
                                                                function redirectToReservation() {
                                                                    window.location.href = "{{ route('housing.show', [$item['housing']->id]) }}";
                                                                }
                                                            </script>
                                                        @endif
                                                    @else
                                                        @if ($item['project_values']['off_sale[]'] != '[]')
                                                            <button class="btn second-btn  mobileCBtn"
                                                                style="background: #EA2B2E !important;width:100%;height:40px !important;color:White">

                                                                <span class="text">Satışa
                                                                    Kapatıldı</span>
                                                            </button>
                                                        @elseif ($item['action'] && $item['action'] != 'tryBuy' && $item['action'] != 'noCart')
                                                            <button class="btn second-btn  mobileCBtn"
                                                                @if ($item['action'] == 'payment_await') style="background: orange !important;color:White;width:100%;height:40px !important;" @else  style="background: #EA2B2E !important;color:White;height: 40px !important;width:100%" @endif>
                                                                @if ($item['action'] == 'payment_await')
                                                                    <span class="text">Onay
                                                                        Bekleniyor</span>
                                                                @else
                                                                    <span class="text">Satıldı</span>
                                                                @endif
                                                            </button>
                                                        @else
                                                            <button class="CartBtn second-btn " data-type='project'
                                                                style="width:100%;height:40px !important;"
                                                                data-project='{{ $item['project']->id }}'
                                                                data-id='{{ $item['room_order'] }}'>
                                                                <span class="IconContainer">
                                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                                </span>
                                                                <span class="text">Sepete
                                                                    Ekle</span>
                                                            </button>
                                                        @endif
                                                    @endif

                                                </td>
                                            </tr>
                                            @if (($item['action'] && $item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                                                @if (
                                                    ($item['item_type'] == 2 &&
                                                        isset(json_decode($item['housing']['housing_type_data'])->discount_rate[0]) &&
                                                        json_decode($item['housing']['housing_type_data'])->discount_rate[0] != 0) ||
                                                        null)
                                                    <tr style="background-color: #8080802e">
                                                        <td colspan="5">
                                                            <span style="color: #e54242">
                                                                #{{ $item['item_type'] == 1 ? $item['project']->id + $item['room_order'] + 10000000 : $item['housing']->id + 2000000 }}
                                                                Numaralı İlan İçin:
                                                                Satın alma işlemi gerçekleştirdiğinizde, Emlak Kulüp üyesi
                                                                tarafından paylaşılan link aracılığıyla
                                                                %{{ json_decode($item['housing']['housing_type_data'])->discount_rate[0] }}
                                                                indirim uygulanacaktır.
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @elseif (
                                                    ($item['item_type'] == 1 &&
                                                        isset($item['project_values']['discount_rate[]']) &&
                                                        $item['project_values']['discount_rate[]'] != 0) ||
                                                        null)
                                                    <tr style="background-color: #8080802e">
                                                        <td colspan="5">
                                                            <span style="color: #e54242">
                                                                #{{ $item['project']->id + $item['room_order'] + 10000000 }}
                                                                Numaralı İlan İçin:
                                                                Satın alma işlemi gerçekleştirdiğinizde, Emlak Kulüp üyesi
                                                                tarafından paylaşılan link aracılığıyla
                                                                %{{ $item['project_values']['discount_rate[]'] }}
                                                                indirim uygulanacaktır.
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mobile-show">

                            @foreach ($mergedItems as $item)
                                <div class="d-flex" style="flex-wrap: nowrap">
                                    <div class="align-items-center d-flex " style="padding-right:0; width: 110px;">
                                        <div class="project-inner project-head">
                                            <a
                                                href="{{ $item['item_type'] == 1 ? route('project.housings.detail', [$item['project']['slug'], $item['room_order']]) : route('housing.show', [$item['housing']['id']]) }}">
                                                <div class="homes">
                                                    <div class="homes-img h-100 d-flex align-items-center"
                                                        style="width: 130px; height: 128px;">
                                                        <img src="{{ $item['item_type'] == 1 ? URL::to('/') . '/project_housing_images/' . $item['project_values']['image[]'] : URL::to('/') . '/housing_images/' . json_decode($item['housing']['housing_type_data'])->image }}"
                                                            alt="home-1" class="img-responsive"
                                                            style="height: 70px !important; object-fit: cover;width:100px">
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="w-100" style="padding-left:0;">
                                        <div class="bg-white px-3 h-100 d-flex flex-column justify-content-center">

                                            <a style="text-decoration: none;height:100%"
                                                href="{{ $item['item_type'] == 1 ? route('project.housings.detail', [$item['project']['slug'], $item['room_order']]) : route('housing.show', [$item['housing']['id']]) }}">
                                                <div class="d-flex" style="gap: 8px;justify-content:space-between">

                                                    <h4>
                                                        #{{ $item['item_type'] == 1 ? $item['project']->id + $item['room_order'] + 10000000 : $item['housing']->id + 2000000 }}
                                                        <br>
                                                        {{ $item['item_type'] == 1 ? $item['project_values']['advertise_title[]'] : $item['housing']->title }}
                                                    </h4>
                                                    @if ($item['item_type'] == 1)
                                                        <span class="btn toggle-project-favorite bg-white"
                                                            data-project-housing-id="{{ $item['room_order'] }}"
                                                            data-project-id="{{ $item['project']->id }}">
                                                            <i class="fa fa-heart-o"></i>
                                                        </span>
                                                    @else
                                                        <span class="btn toggle-favorite bg-white"
                                                            data-housing-id="{{ $item['housing']['id'] }}"
                                                            style="color: white;">
                                                            <i class="fa fa-heart-o"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </a>
                                            <div class="d-flex" style="align-items:Center">
                                                <div class="d-flex" style="gap: 8px;">

                                                    @if ($item['item_type'] != 1)
                                                        @if ($item['housing']->step2_slug != 'gunluk-kiralik')
                                                            @if (isset(json_decode($item['housing']['housing_type_data'])->off_sale1[0]))
                                                                <button class="btn second-btn mobileCBtn"
                                                                    style="background: #EA2B2E !important;color:White">
                                                                    <span class="text">Satıldı</span>
                                                                </button>
                                                            @else
                                                                @if ($item['action'] && $item['action'] != 'tryBuy' && $item['action'] != 'noCart')
                                                                    <button class="btn mobileCBtn second-btn "
                                                                        @if ($item['action'] == 'payment_await') style="background: orange !important;color:White"
                                                            @else style="background: #EA2B2E !important;color:White" @endif>
                                                                        <span class="IconContainer">
                                                                            <img src="{{ asset('sc.png') }}"
                                                                                alt="">
                                                                        </span>
                                                                        @if ($item['action'] == 'payment_await')
                                                                            <span class="text">Rezerve Edildi</span>
                                                                        @else
                                                                            <span class="text">Satıldı</span>
                                                                        @endif
                                                                    </button>
                                                                @elseif ($item['action'] == 'payment_await')
                                                                    <button class="btn mobileCBtn second-btn"
                                                                        style="background: orange !important;width:100%;height:40px !important;color:White">
                                                                        <span class="text">Ödeme Bekleniyor</span>
                                                                    </button>
                                                                @elseif ($item['action'] == 'tryBuy')
                                                                    <button class="btn mobileCBtn second-btn"
                                                                        style="background: orange !important;width:100%;height:40px !important;color:White">
                                                                        <span class="text">Satın Al</span>
                                                                    </button>
                                                                @else
                                                                    <button class="CartBtn mobileCBtn" data-type='housing'
                                                                        data-id='{{ $item['housing']->id }}'>
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
                                                                class="reservationBtn mobileCBtn">
                                                                <span class="IconContainer">
                                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                                </span>
                                                                <span class="text">Rezervasyon Yap</span>
                                                            </button>
                                                            <script>
                                                                function redirectToReservation() {
                                                                    window.location.href = "{{ route('housing.show', [$item['housing']->id]) }}";
                                                                }
                                                            </script>
                                                        @endif
                                                    @else
                                                        @if ($item['project_values']['off_sale[]'] != '[]')
                                                            <button class="btn second-btn  mobileCBtn"
                                                                style="background: #EA2B2E !importantcolor:White">

                                                                <span class="text">Satışa Kapatıldı</span>
                                                            </button>
                                                        @elseif ($item['action'] && $item['action'] != 'tryBuy' && $item['action'] != 'noCart')
                                                            <button class="btn second-btn  mobileCBtn"
                                                                @if ($item['action'] == 'payment_await') style="background: orange !important;color:White" @else  style="background: #EA2B2E !important;color:White;height: 40px !important;width:100%" @endif>
                                                                @if ($item['action'] == 'payment_await')
                                                                    <span class="text">Onay Bekleniyor</span>
                                                                @else
                                                                    <span class="text">Satıldı</span>
                                                                @endif
                                                            </button>
                                                        @else
                                                            <button class="CartBtn second-btn mobileCBtn "
                                                                data-type='project'
                                                                data-project='{{ $item['project']->id }}'
                                                                data-id='{{ $item['room_order'] }}'>
                                                                <span class="IconContainer">
                                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                                </span>
                                                                <span class="text">Sepete Ekle</span>
                                                            </button>
                                                        @endif
                                                    @endif
                                                </div>
                                                <span class="ml-auto text-primary priceFont">
                                                    @if (($item['action'] && $item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                                                    @php
                                                        $discountedPrice = null;
                                                        $price = null;
                                                        $discountRate = null;
                                                        if ($item['item_type'] == 2 && isset(json_decode($item['housing']['housing_type_data'])->discount_rate[0])) {
                                                            $discountRate = json_decode($item['housing']['housing_type_data'])->discount_rate[0];
                                                            $price = json_decode($item['housing']['housing_type_data'])->price[0] - $item['discount_amount'];
                                                            $discountedPrice = $price - ($price * $discountRate) / 100;
                                                        } elseif ($item['item_type'] == 1 && isset($item['project_values']['discount_rate[]']) && $item['project_values']['discount_rate[]'] != 0) {
                                                            $discountRate = $item['project_values']['discount_rate[]'];
                                                            $price = $item['project_values']['price[]'] - $item['discount_amount'];
                                                            $discountedPrice = $price - ($price * $discountRate) / 100;
                                                        }
                                                    @endphp

                                                    @if (isset($discountRate) && $discountRate != 0)
                                                        <span style="color: green;">
                                                            {{ number_format($discountedPrice, 0, ',', '.') }} ₺
                                                        </span><br>
                                                        <del style="color: red;">
                                                            {{ number_format($item['item_type'] == 1 ? $item['project_values']['price[]'] : json_decode($item['housing']['housing_type_data'])->price[0], 0, ',', '.') }}
                                                            ₺
                                                        </del>
                                                    @else
                                                        <span style="color: green; font-size:12px !important">
                                                            {{ number_format($item['item_type'] == 1 ? $item['project_values']['price[]'] : json_decode($item['housing']['housing_type_data'])->price[0], 0, ',', '.') }}
                                                            ₺
                                                        </span>
                                                    @endif
                                                @endif


                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if (($item['action'] && $item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                                    @if (
                                        ($item['item_type'] == 2 &&
                                            isset(json_decode($item['housing']['housing_type_data'])->discount_rate[0]) &&
                                            json_decode($item['housing']['housing_type_data'])->discount_rate[0] != 0) ||
                                            null)
                                        <div class="w-100"
                                            style="height:50px;background-color:#8080802e;margin-top:20px">
                                            <div class="d-flex justify-content-between align-items-center"
                                                style="height: 100%;padding: 10px">
                                                <span style="color: #e54242;font-size:9px !important">
                                                    #{{ $item['item_type'] == 1 ? $item['project']->id + $item['room_order'] +  10000000 : $item['housing']->id + 2000000 }}
                                                    Numaralı İlan İçin:
                                                    Satın alma işlemi gerçekleştirdiğinizde, Emlak Kulüp üyesi
                                                    tarafından paylaşılan link aracılığıyla
                                                    %{{ json_decode($item['housing']['housing_type_data'])->discount_rate[0] }}
                                                    indirim uygulanacaktır.
                                                </span>
                                            </div>

                                        </div>
                                    @elseif (
                                        ($item['item_type'] == 1 &&
                                            isset($item['project_values']['discount_rate[]']) &&
                                            $item['project_values']['discount_rate[]'] != 0) ||
                                            null)
                                        <div class="w-100"
                                            style="height:50px;background-color:#8080802e;margin-top:20px">
                                            <div class="d-flex justify-content-between align-items-center"
                                                style="height: 100%;padding: 10px">
                                                <span style="color: #e54242;font-size:9px !important">
                                                    #{{ $item['project']->id + $item['room_order'] + 10000000 }}
                                                    Numaralı İlan İçin:
                                                    Satın alma işlemi gerçekleştirdiğinizde, Emlak Kulüp üyesi
                                                    tarafından paylaşılan link aracılığıyla
                                                    %{{ $item['project_values']['discount_rate[]'] }}
                                                    indirim uygulanacaktır.
                                                </span>
                                            </div>

                                        </div>
                                    @endif
                                @endif


                                <hr>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(".remove-from-collection").on("click", function() {
            var button = $(this); // Reference the clicked button
            var itemType = button.data('type');
            var itemId = button.data('id');
            var projectId = button.data('project');

            $.ajax({
                method: 'POST',
                url: '/remove-from-collection',
                data: {
                    itemType: itemType,
                    itemId: itemId,
                    projectId: projectId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    location.reload();
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        .CartBtn {
            margin-top: 0 !important;
        }

        .mobile-hidden {
            display: flex;
            flex-wrap: wrap
        }

        .desktop-hidden {
            display: none;
        }

        .homes-content .footer {
            display: none
        }

        .price-mobile {
            display: flex;
            align-items: self-end;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 0 !important;
            }

            .mobile-hidden {
                display: none
            }

            .desktop-hidden {
                display: block;
            }

            .mobile-position {
                width: 100%;
                margin: 0 auto;
                box-shadow: 0 0 10px 1px rgba(71, 85, 95, 0.08);
            }

            .inner-pages .portfolio .homes-content .homes-list-div ul {
                flex-wrap: wrap
            }



            .homes-content .footer {
                display: block;
                background: none;
                border-top: 1px solid #e8e8e8;
                padding-top: 1rem;
                font-size: 13px;
                color: #666;
            }

        }
    </style>
@endsection
