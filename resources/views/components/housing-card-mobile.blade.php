@props(['housing','sold'])

<div class="d-flex" style="flex-wrap: nowrap">
    <div class="align-items-center d-flex " style="padding-right:0; width: 110px;">
        <div class="project-inner project-head">
            <a href="{{ route('housing.show', ['housingSlug' => $housing->step1_slug. "-".$housing->step2_slug. "-" . $housing->slug, 'housingID' => $housing->id + 2000000]) }}">

                <div class="homes">
                    <div class="homes-img h-100 d-flex align-items-center"
                        style="width: 115px; height: 128px;">
                      
                        
                        @if (isset(json_decode($housing->housing_type_data)->open_sharing1[0]))
                        <div class="homes-price"
                        style="bottom: 0;left:0;z-index:9"><i class="fa fa-handshake-o"></i></div>
                        @endif
                        <img loading="lazy" src="{{ URL::to('/') . '/housing_images/' . json_decode($housing->housing_type_data)->image }}"
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
            href="{{ route('housing.show', ['housingSlug' => $housing->step1_slug. "-".$housing->step2_slug. "-" . $housing->slug, 'housingID' => $housing->id + 2000000]) }}">
                <div class="d-flex"
                    style="gap: 8px;justify-content:space-between;align-items:center">
                    <h4 class="mobile-left-width">
                        {{ mb_convert_case($housing->housing_title, MB_CASE_TITLE, 'UTF-8') }}
                    </h4>
                    <div class="mobile-right-width">
                        @if (isset(json_decode($housing->housing_type_data)->open_sharing1[0]))

                        <span
                            class="btn @if (($sold && $sold[0] == '1') || isset(json_decode($housing->housing_type_data)->off_sale1[0])) disabledShareButton @else addCollection mobileAddCollection @endif "
                            data-type='housing' data-id="{{ $housing->id }}">
                            <i class="fa fa-bookmark-o"></i>
                        </span>
                        @endif
                        <span class="btn toggle-favorite bg-white"
                            data-housing-id="{{ $housing->id }}" style="color: white;">
                            <i class="fa fa-heart-o"></i>
                        </span>
                    </div>

                </div>
            </a>
            <div class="d-flex" style="align-items:Center">
                <div class="d-flex" style="gap: 8px;">

                    @if ($housing->step2_slug != 'gunluk-kiralik')
                        @if (isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                            <button class="btn second-btn  mobileCBtn"
                                style="background: #EA2B2E !important;color:White">

                                <span class="text">Satışa Kapatıldı</span>
                            </button>
                        @else
                            @if ($sold != null && $sold != '2')
                                <button class="btn mobileCBtn second-btn "
                                    @if ($sold == '0') style="background: orange !important;color:White"
                            @else 
                            style="background: #EA2B2E !important;color:White" @endif>
                                    <span class="IconContainer">
                                        <img loading="lazy" src="{{ asset('sc.png') }}" alt="">
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
                                        <img loading="lazy" src="{{ asset('sc.png') }}" alt="">

                                    </span>
                                    <span class="text">Sepete Ekle</span>
                                </button>
                            @endif
                        @endif
                    @else
                        <button onclick="redirectToReservation()"
                            class="reservationBtn mobileCBtn">
                            <span class="IconContainer">
                                <img loading="lazy" src="{{ asset('sc.png') }}" alt="">
                            </span>
                            <span class="text">Rezervasyon Yap</span>
                        </button>
                        
                        <script>
                            function redirectToReservation() {
                                window.location.href = "{{ route('housing.show', ['housingSlug' => $housing->step1_slug. "-".$housing->step2_slug. "-" . $housing->slug, 'housingID' => $housing->id + 2000000]) }}";
                            }
                        </script>
                    @endif
                </div>
                <span class="ml-auto text-primary priceFont">
                    @if ($housing->discount_amount)
                            <svg viewBox="0 0 24 24" width="18" height="18" stroke="#EA2B2E" stroke-width="2"
                                fill="#EA2B2E" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
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
                                                <span style="font-size:9px; color:#EA2B2E">
                                                    {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                </span>
                                            </del>
                                            {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0] - $housing->discount_amount, 0, ',', '.') }}
                                            ₺
                                        @else
                                            {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                            ₺
                                        @endif
                                        <span style="font-size:9px; color:#EA2B2E">
                                            1 Gece</span>
                                    @else
                                        @if ($housing->discount_amount)
                                            <del style="font-size:9px; color:#EA2B2E">

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
                                        <del style="font-size:9px; color:#EA2B2E">
                                            {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                        </del>
                                        {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0] - $housing->discount_amount, 0, ',', '.') }}
                                        ₺
                                        <span style="font-size:9px; color:#EA2B2E">
                                            1 Gece</span>
                                    @else
                                        {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                        ₺
                                        <span style="font-size:9px; color:#EA2B2E">
                                            1 Gece</span>
                                    @endif
                                @else
                                    @if ($housing->discount_amount)
                                        <del style="font-size:9px; color:#EA2B2E">
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
        <span style="font-size: 9px !important">{!! $housing->city_title !!}
            {{ '/' }} {!! $housing->county_title !!}
        </span>
    </div>

</div>
<hr>