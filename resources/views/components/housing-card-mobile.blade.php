@props(['housing', 'sold'])

@php

    if (!function_exists('checkIfUserCanAddToCart')) {
        function checkIfUserCanAddToCart($housingId)
        {
            $user = auth()->user();

            // Check if the user is logged in
            if ($user) {
                // Check if there exists a housing record with the given $housingId and user_id matching the logged-in user
                $exists = $user->housings()->where('id', $housingId)->exists();
                return !$exists; // Return true if the user can add to cart (housing not found), false otherwise
            }

            return true; // Return false if user is not logged in
        }
    }

@endphp

<div class="d-flex" style="flex-wrap: nowrap">
    <div class="align-items-center d-flex " style="padding-right:0; width: 110px;">
        <div class="project-inner project-head">
            <a
                href="{{ route('housing.show', ['housingSlug' => $housing->step1_slug . '-' . $housing->step2_slug . '-' . $housing->slug, 'housingID' => $housing->id + 2000000]) }}">

                <div class="homes">
                    <div class="homes-img h-100 d-flex align-items-center" style="width: 115px; height: 128px;">


                        @if ((isset(json_decode($housing->housing_type_data)->open_sharing1[0]) && $sold == null) || $sold == '2')
                            <div class="homes-price" style="bottom: 0;left:0;z-index:9"><i class="fa fa-handshake-o"></i>
                            </div>
                        @endif
                        <img loading="lazy"
                            src="{{ URL::to('/') . '/housing_images/' . json_decode($housing->housing_type_data)->image }}"
                            alt="{{ $housing->title }}" class="img-responsive" style="height: 80px !important;">
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="w-100" style="padding-left:0;">
        <div class="bg-white px-3 h-100 d-flex flex-column justify-content-center">

            <a style="text-decoration: none;height:100%"
                href="{{ route('housing.show', ['housingSlug' => $housing->step1_slug . '-' . $housing->step2_slug . '-' . $housing->slug, 'housingID' => $housing->id + 2000000]) }}">
                <div class="d-flex" style="gap: 8px;justify-content:space-between;align-items:center">
                    <h4 class="mobile-left-width">
                        {{ $housing->title }} </h4>

                    <div class="mobile-right-width">
                        @if ((isset(json_decode($housing->housing_type_data)->open_sharing1[0]) && $sold == null) || $sold == '2')
                            <span
                                class="btn @if (($sold && $sold[0] == '1') || isset(json_decode($housing->housing_type_data)->off_sale1[0])) disabledShareButton @else addCollection mobileAddCollection @endif "
                                data-type='housing' data-id="{{ $housing->id }}">
                                <i class="fa fa-bookmark-o"></i>
                            </span>
                        @endif
                        <span class="btn toggle-favorite bg-white" data-housing-id="{{ $housing->id }}"
                            style="color: white;">
                            <i class="fa fa-heart-o"></i>
                        </span>
                    </div>

                </div>
                <p class="homes-address mb-1">
                    <i class="fa fa-map-marker"></i>
                    <span>
                        
                        {{ $housing->city ? $housing->city->title : '' }}
                        {{ $housing->city && $housing->district ? ' / ' : '' }}
                        {{ $housing->district ? $housing->district->ilce_title : '' }}
                        {{ $housing->district && $housing->neighborhood ? ' / ' : '' }}
                        {{ $housing->neighborhood ? $housing->neighborhood->mahalle_title : '' }}
                    </span>
                </p>

            </a>
            <div class="d-flex" style="align-items:Center">
                <div class="d-flex" style="gap: 8px;">

                    @if ($housing->step2_slug != 'gunluk-kiralik')
                        @if (isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                            <button class="btn second-btn  mobileCBtn"
                                style="background: #D32729 !important;color:White">

                                <span class="text">Satışa Kapalı</span>
                            </button>
                        @else
                            @if ($sold != null && $sold != '2')
                                <button class="btn mobileCBtn second-btn "
                                    @if ($sold == '0') style="background: orange !important;color:White"
                            @else 
                            style="background: #D32729 !important;color:White" @endif>
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
                                @if (checkIfUserCanAddToCart($housing->id))
                                    <button class="CartBtn mobileCBtn" data-type='housing'
                                        data-id='{{ $housing->id }}'>
                                        <span class="IconContainer">
                                            <img loading="lazy" src="{{ asset('sc.png') }}" alt="">

                                        </span>
                                        <span class="text">Sepete Ekle</span>
                                    </button>
                                @else
                                    <a href="{{ route('institutional.housing.edit', ['id' => hash_id($housing->id)]) }}"
                                        class="btn btn-success">
                                        <span class="text">İlanı Düzenle</span>
                                    </a>
                                @endif
                            @endif
                        @endif
                    @else
                        @if (checkIfUserCanAddToCart($housing->id))
                            <button onclick="redirectToReservation()" class="reservationBtn mobileCBtn">
                                <span class="IconContainer">
                                    <img loading="lazy" src="{{ asset('sc.png') }}" alt="">
                                </span>
                                <span class="text">Rezervasyon Yap</span>
                            </button>

                            <script>
                                function redirectToReservation() {
                                    window.location.href =
                                        "{{ route('housing.show', ['housingSlug' => $housing->step1_slug . '-' . $housing->step2_slug . '-' . $housing->slug, 'housingID' => $housing->id + 2000000]) }}";
                                }
                            </script>
                        @else
                            <a href="{{ route('institutional.housing.edit', ['id' => hash_id($housing->id)]) }}"
                                class="btn btn-success">
                                <span class="text">İlanı Düzenle</span>
                            </a>
                        @endif
                    @endif
                </div>
                <span class="ml-auto text-primary priceFont">
                    @if ($housing->discount_amount)
                        <svg viewBox="0 0 24 24" width="18" height="18" stroke="#D32729" stroke-width="2"
                            fill="#D32729" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
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
                                            <span style="font-size:9px; color:#D32729">
                                                {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                            </span>
                                        </del> <br>
                                        {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0] - $housing->discount_amount, 0, ',', '.') }}
                                        ₺
                                    @else
                                        {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                        ₺
                                    @endif
                                    <span style="font-size:9px; color:#D32729">
                                        1 Gece</span>
                                @else
                                    @if ($housing->discount_amount)
                                        <del style="font-size:9px; color:#D32729">

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
                                    <del style="font-size:9px; color:#D32729">
                                        {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                    </del> <br>
                                    {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0] - $housing->discount_amount, 0, ',', '.') }}
                                    ₺
                                    <span style="font-size:9px; color:#D32729">
                                        1 Gece</span>
                                @else
                                    {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                    ₺
                                    <span style="font-size:9px; color:#D32729">
                                        1 Gece</span>
                                @endif
                            @else
                                @if ($housing->discount_amount)
                                    <del style="font-size:9px; color:#D32729">
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
                    @endif

                </span>
            </div>

        </div>
    </div>
</div>
<div class="w-100" style="height:40px;background-color:#8080802e;margin-top:10px">
    <div class="d-flex justify-content-between align-items-center" style="height: 100%;padding: 10px">

        <ul class="d-flex align-items-center h-100"
            style="list-style: none; padding: 0; font-weight: 600; justify-content: start; margin-bottom: 0 !important">
            @if (isset($housing->listItems->column1_name) &&
                    isset(json_decode($housing->housing_type_data)->{$housing->listItems->column1_name}[0]) &&
                    json_decode($housing->housing_type_data)->{$housing->listItems->column1_name}[0] != 'Belirtilmemiş')
                <li class="d-flex align-items-center itemCircleFont">
                    <i class="fa fa-circle circleIcon mr-1"></i>
                    <span>
                        {{ json_decode($housing->housing_type_data)->{$housing->listItems->column1_name}[0] ?? null }}
                        @if (isset($housing->listItems->column1_additional))
                            {{ $housing->listItems->column1_additional }}
                        @endif
                    </span>
                </li>
            @endif

            @if (isset($housing->listItems->column2_name) &&
                    isset(json_decode($housing->housing_type_data)->{$housing->listItems->column2_name}[0]) &&
                    json_decode($housing->housing_type_data)->{$housing->listItems->column2_name}[0] != 'Belirtilmemiş')
                <li class="d-flex align-items-center itemCircleFont">
                    <i class="fa fa-circle circleIcon mr-1"></i>
                    <span>
                        {{ json_decode($housing->housing_type_data)->{$housing->listItems->column2_name}[0] ?? null }}
                        @if (isset($housing->listItems->column2_additional))
                            {{ $housing->listItems->column2_additional }}
                        @endif
                    </span>
                </li>
            @endif

            @if (isset($housing->listItems->column3_name) &&
                    isset(json_decode($housing->housing_type_data)->{$housing->listItems->column3_name}[0]) &&
                    json_decode($housing->housing_type_data)->{$housing->listItems->column3_name}[0] != 'Belirtilmemiş')
                <li class="d-flex align-items-center itemCircleFont">
                    <i class="fa fa-circle circleIcon mr-1"></i>
                    <span>
                        {{ json_decode($housing->housing_type_data)->{$housing->listItems->column3_name}[0] ?? null }}
                        @if (isset($housing->listItems->column3_additional))
                            {{ $housing->listItems->column3_additional }}
                        @endif
                    </span>
                </li>
            @endif

            @if (isset($housing->listItems->column4_name) &&
                    isset(json_decode($housing->housing_type_data)->{$housing->listItems->column4_name}[0]) &&
                    json_decode($housing->housing_type_data)->{$housing->listItems->column4_name}[0] != 'Belirtilmemiş')
                <li class="d-flex align-items-center itemCircleFont">
                    <i class="fa fa-circle circleIcon mr-1"></i>
                    <span>
                        {{ json_decode($housing->housing_type_data)->{$housing->listItems->column4_name}[0] ?? null }}
                        @if (isset($housing->listItems->column4_additional))
                            {{ $housing->listItems->column4_additional }}
                        @endif
                    </span>
                </li>
            @endif
        </ul>


    </div>

</div>
<hr>
