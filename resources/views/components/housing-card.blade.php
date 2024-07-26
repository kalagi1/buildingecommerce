@props(['housing', 'sold'])

<a href="{{ route('housing.show', ['housingSlug' => $housing->step1_slug . '-' . $housing->step2_slug . '-' . $housing->slug, 'housingID' => $housing->id + 2000000]) }}"
    class="text-decoration-none">
    <div class="landscapes">
        <div class="project-single">
            <div class="project-inner project-head">
                <div class="homes">
                    <div class="homes-img">
                        <div class="homes-tag button alt featured" style="width:90px !important">
                            No: {{ $housing->id + 2000000 }}
                        </div>

                        <div class="type-tag button alt featured">
                            @if ($housing->step2_slug == 'kiralik')
                                Kiralık
                            @elseif ($housing->step2_slug == 'gunluk-kiralik')
                                Günlük Kiralık
                            @else
                                Satılık
                            @endif
                        </div>
                        @if (checkIfUserCanAddToCart($housing->id))

                        @if ((isset(json_decode($housing->housing_type_data)->open_sharing1[0]) && $sold == null) || $sold == '2')
                            <div class="homes-price"><i class="fa fa-handshake-o"></i> Paylaşımlı İlan</div>
                        @endif
                        @endif

                        <img loading="lazy"
                            src="{{ URL::to('/') . '/housing_images/' . json_decode($housing->housing_type_data)->image }}"
                            alt="{{ $housing->housing_title }}" class="img-responsive">
                    </div>
                </div>
                @if (checkIfUserCanAddToCart($housing->id))

                <div class="button-effect-div">
                    @if ((isset(json_decode($housing->housing_type_data)->open_sharing1[0]) && $sold == null) || $sold == '2')
                        <span
                            class="btn @if (($sold && $sold[0] == '1') || isset(json_decode($housing->housing_type_data)->off_sale1[0])) disabledShareButton @else addCollection mobileAddCollection @endif"
                            data-type='housing' data-id="{{ $housing->id }}">
                            <i class="fa fa-bookmark-o"></i>
                        </span>
                    @endif

                    <span class="btn toggle-favorite bg-white" data-housing-id={{ $housing->id }}>
                        <i class="fa fa-heart-o"></i>
                    </span>
                </div>
                @endif
            </div>
            <div class="homes-content p-3" style="padding:20px !important">
                <span style="text-decoration: none">

                    <h4 style="height: 25px">
                        {{ $housing->title }}
                    </h4>


                    <p class="homes-address mb-3">



                        <i class="fa fa-map-marker"></i>
                        <span>
                            {{ $housing->city ? $housing->city->title : '' }}
                            {{ $housing->city ? ($housing->district ? '/ ' . $housing->district->ilce_title : '') : ($housing->district ? $housing->district->ilce_title : '') }}
                            {{ $housing->city || $housing->district ? ($housing->neighborhood ? '/ ' . $housing->neighborhood->mahalle_title : '') : ($housing->neighborhood ? $housing->neighborhood->mahalle_title : '') }}
                        </span>


                    </p>
                </span>
                <!-- homes List -->
                <ul class="homes-list clearfix mb-3" style="display: flex; justify-content: space-between">
                    @if (isset($housing->listItems->column1_name) &&
                            isset(json_decode($housing->housing_type_data)->{$housing->listItems->column1_name}[0]) &&
                            json_decode($housing->housing_type_data)->{$housing->listItems->column1_name}[0] != 'Belirtilmemiş')
                        <li class="sude-the-icons" style="width:auto !important">
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
                        <li class="sude-the-icons" style="width:auto !important">
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
                        <li class="sude-the-icons" style="width:auto !important">
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
                        <li class="sude-the-icons" style="width:auto !important">
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

                <ul class="homes-list clearfix mb-3"
                    style="display: flex; justify-content: space-between;align-items:center">
                    <li style="font-size: 16px; font-weight: 700;width:100%; white-space:nowrap">
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



                    </li>
                    <li style="display: flex; justify-content: right;width:100%">

                        {{ date('j', strtotime($housing->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($housing->created_at))) . ' ' . date('Y', strtotime($housing->created_at)) }}
                    </li>

                </ul>


                @if ($housing->step2_slug != 'gunluk-kiralik')
                    @if (isset(json_decode($housing->housing_type_data)->off_sale1[0]))
                        <button class="btn second-btn " style="background: #EA2B2E !important;width:100%;color:White">

                            <span class="text">Satışa
                                Kapatıldı</span>
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
                            @if (checkIfUserCanAddToCart($housing->id))
                                <button class="CartBtn" data-type='housing' data-id='{{ $housing->id }}'>
                                    <span class="IconContainer">
                                        <img loading="lazy" src="{{ asset('sc.png') }}" alt="">

                                    </span>
                                    <span class="text">Sepete Ekle</span>
                                </button>
                            @else
                                <a href="{{ route('institutional.housing.edit', ['id' => hash_id($housing->id)]) }}"
                                    class="btn btn-success"
                                    style="width: 100%;
                                    height: 40px;
                                    border: none;
                                    background-color: green;
                                    display: flex;
                                    border-radius: 0;
                                    align-items: center;
                                    justify-content: center;
                                    cursor: pointer;
                                    transition-duration: .5s;
                                    overflow: hidden;
                                    position: relative;">
                                    <span class="text">İlanı Düzenle</span>
                                </a>
                            @endif


                        @endif
                    @endif
                @else
                    @if (checkIfUserCanAddToCart($housing->id))
                        <button onclick="redirectToReservation()" class="reservationBtn">
                            <span class="IconContainer">
                                <img loading="lazy" src="{{ asset('sc.png') }}" alt="">
                            </span>
                            <span class="text">Rezervasyon Yap</span>
                        </button>

                        <script>
                            function redirectToReservation() {
                                window.location.href =
                                    "{{ route('housing.show', ['housingSlug' => $housing->slug, 'housingID' => $housing->id + 2000000]) }}";
                            }
                        </script>
                    @else
                        <a href="{{ route('institutional.housing.edit', ['id' => hash_id($housing->id)]) }}"
                            class="btn btn-success"
                            style="width: 100%;
    height: 40px;
    border: none;
    background-color: green;
    display: flex;
    border-radius: 0;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition-duration: .5s;
    overflow: hidden;
    position: relative;">
                            <span class="text">İlanı Düzenle</span>
                        </a>
                    @endif
                @endif


            </div>
        </div>


    </div>
</a>
