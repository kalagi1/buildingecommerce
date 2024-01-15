@extends('client.layouts.master')

@section('content')
    @php
        if (!function_exists('convertMonthToTurkishCharacter')) {
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
        }

        if (!function_exists('getData')) {
            function getData($housing, $key)
            {
                $housing_type_data = json_decode($housing->housing_type_data);
                $a = $housing_type_data->$key;
                return $a[0];
            }
        }

        if (!function_exists('getImage')) {
            function getImage($housing, $key)
            {
                $housing_type_data = json_decode($housing->housing_type_data);
                $a = $housing_type_data->$key;
                return $a;
            }
        }
    @endphp
    <section class="recently portfolio bg-white homepage-5 ">
        <div class="container">
            <span><strong style="color: black"> "{{ $term }}"</strong> araması için toplam <strong
                    style="color: black">{{ count($results['housings']) + count($results['projects']) + count($results['merchants']) }}
                </strong> sonuç bulundu. </span>

            {{-- Display the search results here --}}
            <div class="header-search-box-page">
                {{-- Result count --}}
                @if (count($results['merchants']) > 0)
                    <div class="font-weight-bold p-2 small mt-2 mb-3" style="background-color: #EEE;">MAĞAZALAR
                        ({{ count($results['merchants']) }})</div>


                    <section class="featured  home18 bg-white">
                        <div class="container">
                            <div class="portfolio ">
                                <div class="slick-lancers">
                                    @foreach ($results['merchants'] as $result)
                                        <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                            <a href="{{ route('instituional.dashboard', $result['slug']) }}"
                                                class="homes-img">
                                                <div class="landscapes">
                                                    <div class="project-single">
                                                        <div class="project-inner project-head">
                                                            <div class="homes">
                                                                <img src="{{ asset('storage/profile_images/' . $result['photo']) }}"
                                                                    alt="home-1" class="img-responsive brand-image-pp">
                                                                <span
                                                                    style="font-size:9px !important;">{{ $result['name'] }}</span>
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
                @endif
                {{-- Housing results --}}
                @if (count($results['housings']) > 0)
                    <div class="font-weight-bold p-2 small mt-2 mb-3" style="background-color: #EEE;">EMLAK İLANLARI
                        ({{ count($results['housings']) }})</div>
                    <section class="featured portfolio rec-pro disc bg-white">
                        <div class="container">
                            <div class="mobile-show">
                                @foreach ($results['housings'] as $result)
                                    @php(
    $discount_amount =
        App\Models\Offer::where('type', 'housing')->where('housing_id', $result['id'])->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0
)
                                    @php($sold = DB::select('SELECT * FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "housing"  AND  JSON_EXTRACT(cart, "$.item.id") = ? LIMIT 1', [$result['id']]))
                                    <div class="d-flex" style="flex-wrap: nowrap">
                                        <div class="align-items-center d-flex " style="padding-right:0; width: 110px;">
                                            <div class="project-inner project-head">
                                                <a href="{{ route('housing.show', $result['id']) }}">
                                                    <div class="homes">
                                                        <div class="homes-img h-100 d-flex align-items-center"
                                                            style="width: 130px; height: 128px;">
                                                            <img src="{{ URL::to('/') . '/housing_images/' . json_decode($result['housing_type_data'])->image }}"
                                                                alt="{{ $result['housing_title'] }}" class="img-responsive"
                                                                style="height: 80px !important;">
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="w-100" style="padding-left:0;">
                                            <div class="bg-white px-3 h-100 d-flex flex-column justify-content-center">

                                                <a style="text-decoration: none;height:100%"
                                                    href="{{ route('housing.show', $result['id']) }}">
                                                    <div class="d-flex"
                                                        style="gap: 8px;justify-content:space-between;align-items:center">
                                                        <h4>{{ mb_convert_case($result['housing_title'], MB_CASE_TITLE, 'UTF-8') }}
                                                        </h4>
                                                        <span class="btn toggle-favorite bg-white"
                                                            data-housing-id="{{ $result['id'] }}" style="color: white;">
                                                            <i class="fa fa-heart-o"></i>
                                                        </span>
                                                    </div>
                                                </a>
                                                <div class="d-flex" style="align-items:Center">
                                                    <div class="d-flex" style="gap: 8px;">

                                                        @if ($result['step2_slug'] != 'gunluk-kiralik')
                                                            @if (isset(json_decode($result['housing_type_data'])->off_sale1[0]))
                                                                <button class="btn second-btn  mobileCBtn"
                                                                    style="background: #EA2B2E !important;width:100%;color:White">

                                                                    <span class="text">Satıldı</span>
                                                                </button>
                                                            @else
                                                                @if ($sold && $sold[0]->status != '2')
                                                                    <button class="btn second-btn  mobileCBtn"
                                                                        @if ($sold[0]->status == '0') style="background: orange !important;width:100%;color:White" @else  style="background: #EA2B2E !important;width:100%;color:White" @endif>
                                                                        @if ($sold[0]->status == '0')
                                                                            <span class="text">Onay
                                                                                Bekleniyor</span>
                                                                        @else
                                                                            <span class="text">Satıldı</span>
                                                                        @endif
                                                                    </button>
                                                                @else
                                                                    <button class="CartBtn mobileCBtn" data-type='housing'
                                                                        data-id='{{ $result['id'] }}'>
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
                                                                class="reservationBtn CartBtn mobileCBtn">
                                                                <span class="IconContainer">
                                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                                </span>
                                                                <span class="text">Rezervasyon Yap</span>
                                                            </button>

                                                            <script>
                                                                function redirectToReservation() {
                                                                    window.location.href = "{{ route('housing.show', [$result['id']]) }}";
                                                                }
                                                            </script>
                                                        @endif
                                                    </div>
                                                    <span class="ml-auto text-primary priceFont">
                                                        @if ($discount_amount)
                                                            <svg viewBox="0 0 24 24" width="24" height="24"
                                                                stroke="currentColor" stroke-width="2" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="css-i6dzq1">
                                                                <polyline points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                </polyline>
                                                                <polyline points="17 18 23 18 23 12"></polyline>
                                                            </svg>
                                                        @endif
                                                        @if (!isset(json_decode($result['housing_type_data'])->off_sale1[0]))
                                                            @if ($sold)
                                                                @if ($sold[0]->status != '1' && $sold[0]->status != '0')
                                                                    @if ($result['step2_slug'] == 'gunluk-kiralik')
                                                                        {{ number_format(json_decode($result['housing_type_data'])->daily_rent[0], 0, ',', '.') }}
                                                                        ₺
                                                                        <span style="font-size:11px; color:Red"
                                                                            class="mobilePriceStyle">1 Gece</span>
                                                                    @else
                                                                        {{ number_format(json_decode($result['housing_type_data'])->price[0], 0, ',', '.') }}
                                                                        ₺
                                                                    @endif
                                                                @endif
                                                            @else
                                                                @if ($result['step2_slug'] == 'gunluk-kiralik')
                                                                    {{ number_format(json_decode($result['housing_type_data'])->daily_rent[0], 0, ',', '.') }}
                                                                    ₺
                                                                    <span style="font-size:11px; color:Red"
                                                                        class="mobilePriceStyle">1 Gece</span>
                                                                @else
                                                                    {{ number_format(json_decode($result['housing_type_data'])->price[0], 0, ',', '.') }}
                                                                    ₺
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


                                                @if ($result['column1_name'])
                                                    <li class="d-flex align-items-center itemCircleFont">

                                                        <i class="fa fa-circle circleIcon mr-1"></i>
                                                        <span>{{ json_decode($result['housing_type_data'])->{$result['column1_name']}[0] ?? null }}
                                                            @if ($result['column1_additional'])
                                                                {{ $result['column1_additional'] }}
                                                            @endif
                                                        </span>
                                                    </li>
                                                @endif

                                                @if ($result['column2_name'])
                                                    <li class="d-flex align-items-center itemCircleFont">

                                                        <i class="fa fa-circle circleIcon mr-1"></i>
                                                        <span>{{ json_decode($result['housing_type_data'])->{$result['column2_name']}[0] ?? null }}
                                                            @if ($result['column2_additional'])
                                                                {{ $result['column2_additional'] }}
                                                            @endif
                                                        </span>
                                                    </li>
                                                @endif

                                                @if ($result['column3_name'])
                                                    <li class="d-flex align-items-center itemCircleFont">

                                                        <i class="fa fa-circle circleIcon mr-1"></i>
                                                        <span>{{ json_decode($result['housing_type_data'])->{$result['column3_name']}[0] ?? null }}
                                                            @if ($result['column3_additional'])
                                                                {{ $result['column3_additional'] }}
                                                            @endif
                                                        </span>
                                                    </li>
                                                @endif
                                                @if ($result['column4_name'])
                                                    <li class="d-flex align-items-center itemCircleFont">

                                                        <i class="fa fa-circle circleIcon mr-1"></i>
                                                        <span>{{ json_decode($result['housing_type_data'])->{$result['column4_name']}[0] ?? null }}
                                                            @if ($result['column4_additional'])
                                                                {{ $result['column4_additional'] }}
                                                            @endif
                                                        </span>
                                                    </li>
                                                @endif


                                            </ul>


                                            <span style="font-size: 11px !important">{!! $result['city_title'] !!}
                                                {{ '/' }} {!! $result['county_title'] !!}</span>
                                        </div>

                                    </div>
                                    <hr>
                                @endforeach
                            </div>

                            <div class="mobile-hidden">
                                @if (count($results['housings']))
                                    <section class="properties-right list featured portfolio blog  pb-5 bg-white"
                                        style="padding: 0 !important">
                                        <div class="container">
                                            <div class="row project-filter-reverse blog-pots">
                                                @foreach ($results['housings'] as $result)
                                                    @php($sold = DB::select('SELECT * FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "housing"  AND  JSON_EXTRACT(cart, "$.item.id") = ? LIMIT 1', [$result['id']]))

                                                    <div class="col-md-3 mb-3">
                                                        <a href="{{ route('housing.show', [$result['id']]) }}"
                                                            class="text-decoration-none">
                                                            <div data-aos="fade-up" data-aos-delay="150">
                                                                <div class="landscapes">
                                                                    <div class="project-single">
                                                                        <div class="project-inner project-head">
                                                                            <div class="homes">
                                                                                <div class="homes-img">
                                                                                    <div
                                                                                        class="homes-tag button alt featured">
                                                                                        Sponsorlu
                                                                                    </div>
                                                                                    <div
                                                                                        class="type-tag button alt featured">
                                                                                        @if ($result['step2_slug'] == 'kiralik')
                                                                                            Kiralık
                                                                                            @elseif
                                                                                            ($result['step2_slug'] == 'gunluk-kiralik')
                                                                                            Günlük Kiralık
                                                                                        @else
                                                                                            Satılık
                                                                                        @endif


                                                                                    </div>
                                                                                    @if ($discount_amount)
                                                                                        <div class="homes-tag button alt sale"
                                                                                            style="background-color:#EA2B2E!important">
                                                                                            İNDİRİM
                                                                                        </div>
                                                                                    @endif
                                                                                    <img src="{{ URL::to('/') . '/housing_images/' . json_decode($result['housing_type_data'])->image }}"
                                                                                        alt="{{ $result['housing_title'] }}"
                                                                                        class="img-responsive">
                                                                                </div>
                                                                            </div>
                                                                            <div class="button-effect">
                                                                                <span class="btn toggle-favorite bg-white"
                                                                                    data-housing-id={{ $result['id'] }}>
                                                                                    <i class="fa fa-heart-o"></i>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="homes-content p-3"
                                                                            style="padding:20px !important">
                                                                            <span style="text-decoration: none">

                                                                                <h4 style="height:30px">
                                                                                    {{ mb_substr(mb_convert_case($result['housing_title'], MB_CASE_TITLE, 'UTF-8'), 0, 45, 'UTF-8') }}
                                                                                    {{ mb_strlen($result['housing_title'], 'UTF-8') > 25 ? '...' : '' }}
                                                                                </h4>


                                                                                <p class="homes-address mb-3">


                                                                                    <i class="fa fa-map-marker"></i>
                                                                                    <span>
                                                                                        {{ $result['city_title'] }}
                                                                                        {{ '/' }}
                                                                                        {{ $result['county_title'] }}
                                                                                    </span>

                                                                                </p>
                                                                            </span>
                                                                            <!-- homes List -->
                                                                            <ul class="homes-list clearfix pb-0"
                                                                                style="display: flex;justify-content:space-between">


                                                                                @if ($result['column1_name'])
                                                                                    <li class="sude-the-icons"
                                                                                        style="width:auto !important">

                                                                                        <i
                                                                                            class="fa fa-circle circleIcon mr-1"></i>
                                                                                        <span>{{ json_decode($result['housing_type_data'])->{$result['column1_name']}[0] ?? null }}
                                                                                            @if ($result['column1_additional'])
                                                                                                {{ $result['column1_additional'] }}
                                                                                            @endif
                                                                                        </span>
                                                                                    </li>
                                                                                @endif

                                                                                @if ($result['column2_name'])
                                                                                    <li class="sude-the-icons"
                                                                                        style="width:auto !important">

                                                                                        <i
                                                                                            class="fa fa-circle circleIcon mr-1"></i>
                                                                                        <span>{{ json_decode($result['housing_type_data'])->{$result['column2_name']}[0] ?? null }}
                                                                                            @if ($result['column2_additional'])
                                                                                                {{ $result['column2_additional'] }}
                                                                                            @endif
                                                                                        </span>
                                                                                    </li>
                                                                                @endif

                                                                                @if ($result['column3_name'])
                                                                                    <li class="sude-the-icons"
                                                                                        style="width:auto !important">

                                                                                        <i
                                                                                            class="fa fa-circle circleIcon mr-1"></i>
                                                                                        <span>{{ json_decode($result['housing_type_data'])->{$result['column3_name']}[0] ?? null }}
                                                                                            @if ($result['column3_additional'])
                                                                                                {{ $result['column3_additional'] }}
                                                                                            @endif
                                                                                        </span>
                                                                                    </li>
                                                                                @endif
                                                                                @if ($result['column4_name'])
                                                                                    <li class="sude-the-icons"
                                                                                        style="width:auto !important">

                                                                                        <i
                                                                                            class="fa fa-circle circleIcon mr-1"></i>
                                                                                        <span>{{ json_decode($result['housing_type_data'])->{$result['column4_name']}[0] ?? null }}
                                                                                            @if ($result['column4_additional'])
                                                                                                {{ $result['column4_additional'] }}
                                                                                            @endif
                                                                                        </span>
                                                                                    </li>
                                                                                @endif
                                                                            </ul>
                                                                            <ul class="homes-list clearfix pb-0"
                                                                                style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                                                <li
                                                                                    style="font-size: 16px; font-weight: 700;width:100%; white-space:nowrap">
                                                                                    @if ($discount_amount)
                                                                                        <svg viewBox="0 0 24 24"
                                                                                            width="24" height="24"
                                                                                            stroke="currentColor"
                                                                                            stroke-width="2"
                                                                                            fill="none"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round"
                                                                                            class="css-i6dzq1">
                                                                                            <polyline
                                                                                                points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                                            </polyline>
                                                                                            <polyline
                                                                                                points="17 18 23 18 23 12">
                                                                                            </polyline>
                                                                                        </svg>
                                                                                    @endif

                                                                                    @if (!isset(json_decode($result['housing_type_data'])->off_sale1[0]))
                                                                                        @if ($sold)
                                                                                            @if ($sold[0]->status != '1' && $sold[0]->status != '0')
                                                                                                @if ($result['step2_slug'] == 'gunluk-kiralik')
                                                                                                    {{ number_format(json_decode($result['housing_type_data'])->daily_rent[0], 0, ',', '.') }}
                                                                                                    ₺
                                                                                                    <span
                                                                                                        style="font-size:11px; color:#EA2B2E"
                                                                                                        class="mobilePriceStyle">
                                                                                                        1
                                                                                                        Gece</span>
                                                                                                @else
                                                                                                    {{ number_format(json_decode($result['housing_type_data'])->price[0], 0, ',', '.') }}
                                                                                                    ₺
                                                                                                @endif
                                                                                            @endif
                                                                                        @else
                                                                                            @if ($result['step2_slug'] == 'gunluk-kiralik')
                                                                                                {{ number_format(json_decode($result['housing_type_data'])->daily_rent[0], 0, ',', '.') }}
                                                                                                ₺
                                                                                                <span
                                                                                                    style="font-size:11px; color:#EA2B2E"
                                                                                                    class="mobilePriceStyle">
                                                                                                    1
                                                                                                    Gece</span>
                                                                                            @else
                                                                                                {{ number_format(json_decode($result['housing_type_data'])->price[0], 0, ',', '.') }}
                                                                                                ₺
                                                                                            @endif
                                                                                        @endif
                                                                                    @endif


                                                                                </li>
                                                                                <li
                                                                                    style="display: flex; justify-content: right;width:100%">
                                                                                    {{ date('j', strtotime($result['created_at'])) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($result['created_at']))) }}
                                                                                </li>
                                                                            </ul>

                                                                            @if ($result['step2_slug'] != 'gunluk-kiralik')
                                                                                @if (isset(json_decode($result['housing_type_data'])->off_sale1[0]))
                                                                                    <button class="btn second-btn "
                                                                                        style="background: #EA2B2E !important;width:100%;color:White">

                                                                                        <span class="text">Satıldı</span>
                                                                                    </button>
                                                                                @else
                                                                                    @if ($sold && $sold[0]->status != '2')
                                                                                        <button class="btn second-btn "
                                                                                            @if ($sold[0]->status == '0') style="background: orange !important;width:100%;color:White" @else  style="background: #EA2B2E !important;width:100%;color:White" @endif>
                                                                                            @if ($sold[0]->status == '0')
                                                                                                <span class="text">Onay
                                                                                                    Bekleniyor</span>
                                                                                            @else
                                                                                                <span
                                                                                                    class="text">Satıldı</span>
                                                                                            @endif
                                                                                        </button>
                                                                                    @else
                                                                                        <button class="CartBtn"
                                                                                            data-type='housing'
                                                                                            data-id='{{ $result['id'] }}'>
                                                                                            <span class="IconContainer">
                                                                                                <img src="{{ asset('sc.png') }}"
                                                                                                    alt="">

                                                                                            </span>
                                                                                            <span class="text">Sepete
                                                                                                Ekle</span>
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
                                                                                    <span class="text">Rezervasyon
                                                                                        Yap</span>
                                                                                </button>

                                                                                <script>
                                                                                    function redirectToReservation() {
                                                                                        window.location.href = "{{ route('housing.show', [$result['id']]) }}";
                                                                                    }
                                                                                </script>
                                                                            @endif


                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </section>
                                @else
                                    <p>Henüz İlan Yayınlanmadı</p>
                                @endif
                            </div>

                            <div class="row justify-content-center">
                                <?php
                                $uri = $_SERVER['REQUEST_URI'];
                                ?>

                                <ul class="pagination">
                                    @foreach ($results['housings']->getUrlRange(1, $results['housings']->lastPage()) as $page => $url)
                                        <li
                                            class="page-item {{ $page == $results['housings']->currentPage() ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $uri }}{{ strpos($url, '?') !== false ? '&' : '?' }}page={{ $page }}">{{ $page }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                            </div>



                        </div>
                    </section>
                @endif

                {{-- Project results --}}
                @if (count($results['projects']) > 0)
                    <div class="font-weight-bold p-2 small mt-2 mb-3" style="background-color: #EEE;">PROJELER
                        ({{ count($results['projects']) }})</div>
                    <div class="row mt-2">
                        @foreach ($results['projects'] as $result)
                            <div class="col-sm-12 col-md-4 col-lg-4 col-12 projectMobileMargin" data-aos="zoom-in"
                                data-aos-delay="150" style="height:200px">
                                <div class="project-single no-mb aos-init aos-animate" style="height:100%"
                                    data-aos="zoom-in" data-aos-delay="150">
                                    <div class="listing-item compact" style="height:100%">
                                        <a href="{{ route('project.detail', ['slug' => $result['slug'], 'id' => $result['id']]) }}"
                                            class="listing-img-container">
                                            <div class="listing-img-content"
                                                style="padding-left:10px;text-transform:uppercase;">
                                                <span class="badge badge-phoenix text-left">{{ $result['name'] }}</span>

                                            </div>
                                            <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $result['photo']) }}"
                                                alt="" style="height:100%;object-fit:contain">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif



                {{-- No results message --}}
                @if (count($results['housings']) == 0 && count($results['projects']) == 0 && count($results['merchants']) == 0)
                    <div class="font-weight-bold p-2 small" style="background-color: white; text-align: center;">Sonuç
                        bulunamadı</div>
                @endif
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetchChatHistory();
        });

        function fetchChatHistory() {
            $.ajax({
                url: 'chat/history',
                method: 'GET',
                success: function(response) {

                    renderChatHistory(response);
                },
                error: function(error) {
                    console.error('Sohbet geçmişi alınamadı:', error);
                }
            });

        }

        function renderChatHistory(chatHistory) {
            const chatboxMessages = document.querySelector('.chatbox-messages');

            chatHistory.forEach(entry => {
                const messageElement = document.createElement('div');
                const messageType = entry.receiver_id == 4 ? 'user' : 'admin';

                messageElement.className = messageType == 'admin' ? 'msg left-msg' : 'msg right-msg';
                messageElement.innerHTML = `
        <div class="msg-bubble">
            <div class="msg-text">
                ${entry.content}
            </div>
        </div>
    `;
                chatboxMessages.appendChild(messageElement);
            });
        }


        var isFirstMessage = true;

        function sendMessage() {
            var userMessage = document.getElementById('userMessage').value;
            var chatboxMessages = document.querySelector('.chatbox-messages');

            // Kullanıcının mesajını ekle
            var userMessageElement = document.createElement('div');
            userMessageElement.className = 'msg right-msg';
            userMessageElement.innerHTML = `
        <div class="msg-bubble">
            <div class="msg-text">
                ${userMessage}
            </div>
        </div>
    `;
            chatboxMessages.appendChild(userMessageElement);

            $.ajax({
                type: 'POST',
                url: "{{ route('messages.store') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'content': userMessage,
                },
                success: function(response) {
                    // Başarıyla mesaj gönderildiğinde yapılacak işlemler
                    console.log(response.message);
                    chatboxMessages.scrollTop = chatboxMessages.scrollHeight;
                },
                error: function(error) {
                    toastr.error('Bir hata oluştu. Lütfen tekrar deneyin.');

                }
            });


            // Kullanıcının girdiği mesaj alanını temizle
            document.getElementById('userMessage').value = '';
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        }

        $(".chatbox-open").click(() => {
            $(".chatbox-popup, .chatbox-close").fadeIn();
        });

        $(".chatbox-close").click(() => {
            $(".chatbox-popup, .chatbox-close").fadeOut();
        });

        $(".chatbox-maximize").click(() => {
            $(".chatbox-popup, .chatbox-open, .chatbox-close").fadeOut();
            $(".chatbox-panel").fadeIn();
            $(".chatbox-panel").css({
                display: "flex"
            });
        });

        $(".chatbox-minimize").click(() => {
            $(".chatbox-panel").fadeOut();
            $(".chatbox-popup, .chatbox-open, .chatbox-close").fadeIn();
        });

        $(".chatbox-panel-close").click(() => {
            $(".chatbox-panel").fadeOut();
            $(".chatbox-open").fadeIn();
        });
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
        .projectMobileMargin {
            margin-top: 10px !important;
            margin-bottom: 10px !important;

        }
    </style>
@endsection
