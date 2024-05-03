@extends('client.layouts.master')

@section('content')
    <section>

       
            <x-store-card :store="$store" :collection="$collection" :mergedItems="$mergedItems" />
      


        <div class="container featured portfolio rec-pro disc bg-white">
            <div class="content">
                <div class="card border mb-3 mt-3" data-list="{&quot;valueNames&quot;:[&quot;icon-list-item&quot;]}">

                    <div class="card-body">
                        <div class="mobile-hidden">
                            {{-- @foreach ($mergedItems as $key => $item)
                                @if (isset($item) && $item['item_type'] == 1)
                                    @php
                                        if (isset($item['projectCartOrders'][$item['room_order']])) {
                                            $sold = $item['projectCartOrders'][$item['room_order']];
                                        } else {
                                            $sold = null;
                                        }

                                        $allCounts = 0;
                                        $blockHousingCount = 0;
                                        $previousBlockHousingCount = 0;
                                        $key = $item['room_order'] - 1;
                                        $isUserSame =
                                            isset($item['projectCartOrders'][$item['room_order']]) &&
                                            (Auth::check()
                                                ? $item['projectCartOrders'][$item['room_order']]->user_id ==
                                                    Auth::user()->id
                                                : false);

                                        $projectOffer = App\Models\Offer::where('type', 'project')
                                            ->where('project_id', $item['item_id'])
                                            ->where(function ($query) use ($item) {
                                                $query
                                                    ->orWhereJsonContains('project_housings', [$item['room_order']])
                                                    ->orWhereJsonContains(
                                                        'project_housings',
                                                        (string) $item['room_order'],
                                                    ); // Handle as string as JSON might store values as strings
                                            })
                                            ->where('start_date', '<=', now())
                                            ->where('end_date', '>=', now())
                                            ->first();

                                        $projectDiscountAmount = $projectOffer ? $projectOffer->discount_amount : 0;

                                        $statusSlug = null;
                                        $lastHousingCount = 0;
                                        $sumCartOrderQt = $item['sumCartOrderQt'];

                                        $blockName = null;
                                        $projectHousingsList = $item['projectHousingsList'];
                                        $project = $item['project'];
                                    @endphp

                                    <x-project-item-card :project="$project" :allCounts="$allCounts" :blockStart="0"
                                        :towns="$towns" :cities="$cities" :key="$key" :statusSlug="$statusSlug"
                                        :blockName="$blockName" :blockHousingCount="$blockHousingCount" :previousBlockHousingCount="$previousBlockHousingCount" :sumCartOrderQt="$sumCartOrderQt"
                                        :isUserSame="$isUserSame" :bankAccounts="$bankAccounts" :i="$key" :projectHousingsList="$projectHousingsList"
                                        :projectDiscountAmount="$projectDiscountAmount" :sold="$sold" :lastHousingCount="$lastHousingCount" />
                                    @if ((isset($item['project_values']['discount_rate[]']) && $item['project_values']['discount_rate[]'] != 0) || null)
                                        <div class="col-md-12 col-12" >
                                            <div class="d-flex justify-content-between align-items-center"
                                                style="height: 100%;padding: 10px">
                                                <span style="color: #e54242;font-size:9px !important">
                                                    #{{ $item['project']->id + $item['room_order'] + 1000000 }}
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
                            @endforeach --}}
                            <div class="row project-filter-reverse blog-pots">
                                <table class="table">
                                    <tbody class="collection-title">

                                        @foreach ($mergedItems as $item)
                                            @php
                                                if (isset($item['projectCartOrders'][$item['room_order']])) {
                                                    $sold = $item['projectCartOrders'][$item['room_order']];
                                                } else {
                                                    $sold = null;
                                                }

                                                $allCounts = 0;
                                                $blockHousingCount = 0;
                                                $previousBlockHousingCount = 0;
                                                $key = $item['room_order'] - 1;
                                                $isUserSame =
                                                    isset($item['projectCartOrders'][$item['room_order']]) &&
                                                    (Auth::check()
                                                        ? $item['projectCartOrders'][$item['room_order']]->user_id ==
                                                            Auth::user()->id
                                                        : false);

                                                $projectOffer = App\Models\Offer::where('type', 'project')
                                                    ->where('project_id', $item['item_id'])
                                                    ->where(function ($query) use ($item) {
                                                        $query
                                                            ->orWhereJsonContains('project_housings', [
                                                                $item['room_order'],
                                                            ])
                                                            ->orWhereJsonContains(
                                                                'project_housings',
                                                                (string) $item['room_order'],
                                                            ); // Handle as string as JSON might store values as strings
                                                    })
                                                    ->where('start_date', '<=', now())
                                                    ->where('end_date', '>=', now())
                                                    ->first();

                                                $projectDiscountAmount = $projectOffer
                                                    ? $projectOffer->discount_amount
                                                    : 0;

                                                $statusSlug = null;
                                                $lastHousingCount = 0;
                                                $sumCartOrderQt = $item['sumCartOrderQt'];

                                                $blockName = null;
                                                $projectHousingsList = $item['projectHousingsList'];
                                                $project = $item['project'];
                                                $share_sale_empty = !isset($share_sale) || $share_sale == '[]';
                                                $blockName = null;
                                            @endphp
                                            @if (isset($item) &&
                                                    ((isset($item['housing']) && !empty($item['housing'])) ||
                                                        (isset($item['project']) && !empty($item['project']))))
                                                <tr>
                                                    <td>
                                                        İlan No: <br>
                                                        #{{ $item['item_type'] == 1 ? $item['project']->id + $item['room_order'] + 1000000 : $item['housing']->id + 2000000 }}

                                                    </td>

                                                    <td>
                                                        <a
                                                            href="{{ $item['item_type'] == 1 ? route('project.housings.detail', ['projectSlug' => $item['project']['slug'], 'projectID' => $item['project']['id'] + 1000000, 'housingOrder' => $item['room_order']]) : route('housing.show', ['housingSlug' => $item['housing']->step1_slug . '-' . $item['housing']->step2_slug . '-' . $item['housing']->slug, 'housingID' => $item['housing']->id + 2000000]) }}">
                                                            <img src="{{ $item['item_type'] == 1 ? URL::to('/') . '/project_housing_images/' . $item['project_values']['image[]'] : URL::to('/') . '/housing_images/' . json_decode($item['housing']['housing_type_data'])->image }}"
                                                                alt="home-1" class="img-responsive"
                                                                style="height: 80px !important; object-fit: cover;width:100px">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{ $item['item_type'] == 1 ? $item['project_values']['advertise_title[]'] : $item['housing']->title . "<br>" }}

                                                        @if ($item['item_type'] == 1)
                                                            {!! $item['room_order'] . " No'lu Daire <br>" !!}
                                                        @endif

                                                        <span style="font-size: 9px !important; font-weight:700">
                                                            @if (isset($item['item_type']) &&
                                                                    $item['item_type'] == 1 &&
                                                                    isset($item['project']['city']['title']) &&
                                                                    isset($item['project']['county']['ilce_title']) &&
                                                                    isset($item['project']['neighbourhood']['mahalle_title']))
                                                                {{ $item['project']['city']['title'] .
                                                                    ' / ' .
                                                                    $item['project']['county']['ilce_title'] .
                                                                    ' / ' .
                                                                    $item['project']['neighbourhood']['mahalle_title'] }}
                                                            @elseif (isset($item['housing']['city']['title']))
                                                                {{ $item['housing']['city']['title'] }}
                                                            @endif
                                                            <br>
                                                        </span>
                                                    </td>

                                                    <td>

                                                        @if (($item['action'] && $item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                                                            @php
                                                                $discountedPrice = null;
                                                                $price = null;
                                                                $discountRate = null;
                                                                if (
                                                                    $item['item_type'] == 2 &&
                                                                    isset(
                                                                        json_decode(
                                                                            $item['housing']['housing_type_data'],
                                                                        )->discount_rate[0],
                                                                    )
                                                                ) {
                                                                    $discountRate = json_decode(
                                                                        $item['housing']['housing_type_data'],
                                                                    )->discount_rate[0];
                                                                    $price =
                                                                        json_decode(
                                                                            $item['housing']['housing_type_data'],
                                                                        )->price[0] - $item['discount_amount'];
                                                                    $discountedPrice =
                                                                        $price - ($price * $discountRate) / 100;
                                                                } elseif ($item['item_type'] == 1) {
                                                                    $discountRate =
                                                                        $item['project_values']['discount_rate[]'] ?? 0;
                                                                    $share_sale =
                                                                        $item['project_values']['share_sale[]'] ?? null;
                                                                    $number_of_share =
                                                                        $item['project_values']['number_of_shares[]'] ??
                                                                        null;
                                                                    $price =
                                                                        $item['project_values']['price[]'] -
                                                                        $item['discount_amount'];
                                                                    $discountedPrice =
                                                                        $price - ($price * $discountRate) / 100;
                                                                }
                                                            @endphp
                                                            @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                                <span class="w-100">
                                                                    1 Hisse Fiyatı
                                                                </span><br>
                                                            @endif

                                                            @if (isset($discountRate) && $discountRate != 0)
                                                                <del style="color: #e54242;">
                                                                    @if ($item['item_type'] == 1)
                                                                        @if (isset($item['project_values']['price[]']))
                                                                            @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                                                {{ number_format($item['project_values']['price[]'] / $number_of_share, 0, ',', '.') }}
                                                                            @else
                                                                                {{ number_format($item['project_values']['price[]'], 0, ',', '.') }}
                                                                            @endif
                                                                        @elseif ($item['project_values']['daily_rent[]'])
                                                                            {{ number_format($item['project_values']['daily_rent[]'], 0, ',', '.') }}
                                                                        @endif
                                                                    @else
                                                                        @if (isset(json_decode($item['housing']['housing_type_data'])->price[0]))
                                                                            {{ number_format(json_decode($item['housing']['housing_type_data'])->price[0], 0, ',', '.') }}
                                                                        @elseif (isset(json_decode($item['housing']['housing_type_data'])->daily_rent[0]))
                                                                            {{ number_format(json_decode($item['housing']['housing_type_data'])->daily_rent[0], 0, ',', '.') }}
                                                                        @endif
                                                                    @endif

                                                                    ₺
                                                                </del>
                                                                <h6
                                                                    style="color: #274abb !important; position: relative; top: 4px; font-weight: 700">
                                                                    @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                                        {{ number_format($discountedPrice / $number_of_share, 0, ',', '.') }}
                                                                        ₺
                                                                    @else
                                                                        {{ number_format($discountedPrice, 0, ',', '.') }}
                                                                        ₺
                                                                    @endif
                                                                </h6>
                                                            @else
                                                                <h6
                                                                    style="color: #274abb !important; position: relative; top: 4px; font-weight: 700">
                                                                    @if ($item['item_type'] == 1)
                                                                        @if (isset($item['project_values']['price[]']))
                                                                            @if (isset($share_sale) && $share_sale != '[]' && !empty($share_sale) && $number_of_share != 0)
                                                                                {{ number_format($item['project_values']['price[]'] / $number_of_share, 0, ',', '.') }}
                                                                            @else
                                                                                {{ number_format($item['project_values']['price[]'], 0, ',', '.') }}
                                                                            @endif
                                                                        @elseif ($item['project_values']['daily_rent[]'])
                                                                            @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                                                {{ number_format($item['project_values']['daily_rent[]'] / $number_of_share, 0, ',', '.') }}
                                                                            @else
                                                                                {{ number_format($item['project_values']['daily_rent[]'], 0, ',', '.') }}
                                                                            @endif
                                                                        @endif
                                                                    @else
                                                                        @if (isset(json_decode($item['housing']['housing_type_data'])->price[0]))
                                                                            {{ number_format(json_decode($item['housing']['housing_type_data'])->price[0], 0, ',', '.') }}
                                                                        @elseif (isset(json_decode($item['housing']['housing_type_data'])->daily_rent[0]))
                                                                            {{ number_format(json_decode($item['housing']['housing_type_data'])->daily_rent[0], 0, ',', '.') }}
                                                                        @endif
                                                                    @endif ₺
                                                                </h6>
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
                                                                        <button class="CartBtn mobileCBtn"
                                                                            data-type='housing'
                                                                            data-id='{{ $item['housing']->id }}'>
                                                                            <span class="IconContainer">
                                                                                <img src="{{ asset('sc.png') }}"
                                                                                    alt="">
                                                                            </span>
                                                                            <span class="text">Sepete Ekle</span>
                                                                        </button>
                                                                    @else
                                                                        <button class="CartBtn mobileCBtn"
                                                                            data-type='housing'
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
                                                                        window.location.href =
                                                                            "{{ route('housing.show', ['housingSlug' => $item['housing']->step1_slug . '-' . $item['housing']->step2_slug . '-' . $item['housing']->slug, 'housingID' => $item['housing']->id + 2000000]) }}";
                                                                    }
                                                                </script>
                                                            @endif
                                                        @else
                                                            @if (
                                                                $item['project_values']['off_sale[]'] != '[]' &&
                                                                    $item['project_values']['off_sale[]'] != '["Sat\u0131\u015fa A\u00e7\u0131k"]')
                                                                @if ($item['project_values']['off_sale[]'] == '["Sat\u0131\u015fa Kapal\u0131"]')
                                                                    <button class="btn second-btn  mobileCBtn"
                                                                        style="background: #EA2B2E !important;width:100%;height:40px !important;color:White">

                                                                        <span class="text">Satışa
                                                                            Kapatıldı</span>
                                                                    </button>
                                                                @elseif ($item['project_values']['off_sale[]'] == '["Sat\u0131ld\u0131"]')
                                                                    <button class="btn second-btn  mobileCBtn"
                                                                        style="background: #EA2B2E !important;color:White;height: 40px !important;width:100%">
                                                                        <span class="text">Satıldı</span>

                                                                    </button>
                                                                @endif
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
                                                                <button class="first-btn payment-plan-button"
                                                                    project-id="{{ $item['project']->id }}"
                                                                    style="width:100% !important;height:40px !important;margin-bottom:3px;background-color:black !important;border:1px solid black;color:white"
                                                                    data-sold="{{ ($sold && $sold->status != 2 && $share_sale_empty) || (!$share_sale_empty && isset($sumCartOrderQt[$item['room_order']]) && $sumCartOrderQt[$item['room_order']]['qt_total'] == $number_of_share) || (!$sold && isset($projectHousingsList[$item['room_order']]['off_sale']) && $projectHousingsList[$item['room_order']]['off_sale'] != '[]') ? 1 : 0 }}"
                                                                    order="{{ $item['room_order'] }}"
                                                                    data-block="{{ $blockName }}"
                                                                    data-payment-order="{{ $item['room_order'] }}">
                                                                    Ödeme Detayı
                                                                </button>
                                                                <button class="CartBtn second-btn " data-type='project'
                                                                    style="width:100%;height:40px !important;"
                                                                    data-project='{{ $item['project']->id }}'
                                                                    data-id='{{ $item['room_order'] }}'
                                                                    data-share="{{ $share_sale }}"
                                                                    data-number-share="{{ $number_of_share }}">
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
                                                                    #{{ $item['item_type'] == 1 ? $item['project']->id + $item['room_order'] + 1000000 : $item['housing']->id + 2000000 }}
                                                                    Numaralı İlan İçin:
                                                                    Satın alma işlemi gerçekleştirdiğinizde, Emlak Kulüp
                                                                    üyesi
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
                                                                    #{{ $item['project']->id + $item['room_order'] + 1000000 }}
                                                                    Numaralı İlan İçin:
                                                                    Satın alma işlemi gerçekleştirdiğinizde, Emlak Kulüp
                                                                    üyesi
                                                                    tarafından paylaşılan link aracılığıyla
                                                                    %{{ $item['project_values']['discount_rate[]'] }}
                                                                    indirim uygulanacaktır.
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endif
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mobile-show">
                            {{-- @foreach ($mergedItems as $key => $item)
                                @if (isset($item) && $item['item_type'] == 1)
                                    @php
                                        if (isset($item['projectCartOrders'][$item['room_order']])) {
                                            $sold = $item['projectCartOrders'][$item['room_order']];
                                        } else {
                                            $sold = null;
                                        }

                                        $allCounts = 0;
                                        $blockHousingCount = 0;
                                        $previousBlockHousingCount = 0;
                                        $key = $item['room_order'] - 1;
                                        $isUserSame =
                                            isset($item['projectCartOrders'][$item['room_order']]) &&
                                            (Auth::check()
                                                ? $item['projectCartOrders'][$item['room_order']]->user_id ==
                                                    Auth::user()->id
                                                : false);

                                        $projectOffer = App\Models\Offer::where('type', 'project')
                                            ->where('project_id', $item['item_id'])
                                            ->where(function ($query) use ($item) {
                                                $query
                                                    ->orWhereJsonContains('project_housings', [$item['room_order']])
                                                    ->orWhereJsonContains(
                                                        'project_housings',
                                                        (string) $item['room_order'],
                                                    ); // Handle as string as JSON might store values as strings
                                            })
                                            ->where('start_date', '<=', now())
                                            ->where('end_date', '>=', now())
                                            ->first();

                                        $projectDiscountAmount = $projectOffer ? $projectOffer->discount_amount : 0;

                                        $statusSlug = null;
                                        $lastHousingCount = 0;
                                        $sumCartOrderQt = $item['sumCartOrderQt'];

                                        $blockName = null;
                                        $projectHousingsList = $item['projectHousingsList'];
                                        $project = $item['project'];
                                    @endphp

                                    <x-project-item-mobile-card :project="$project" :allCounts="$allCounts" :blockStart="0"
                                        :towns="$towns" :cities="$cities" :key="$key" :statusSlug="$statusSlug"
                                        :blockName="$blockName" :blockHousingCount="$blockHousingCount" :previousBlockHousingCount="$previousBlockHousingCount" :sumCartOrderQt="$sumCartOrderQt"
                                        :isUserSame="$isUserSame" :bankAccounts="$bankAccounts" :i="$key" :projectHousingsList="$projectHousingsList"
                                        :projectDiscountAmount="$projectDiscountAmount" :sold="$sold" :lastHousingCount="$lastHousingCount" />
                                @endif
                            @endforeach --}}
                            @foreach ($mergedItems as $item)
                                @php
                                    if (isset($item['projectCartOrders'][$item['room_order']])) {
                                        $sold = $item['projectCartOrders'][$item['room_order']];
                                    } else {
                                        $sold = null;
                                    }

                                    $allCounts = 0;
                                    $blockHousingCount = 0;
                                    $previousBlockHousingCount = 0;
                                    $key = $item['room_order'] - 1;
                                    $isUserSame =
                                        isset($item['projectCartOrders'][$item['room_order']]) &&
                                        (Auth::check()
                                            ? $item['projectCartOrders'][$item['room_order']]->user_id ==
                                                Auth::user()->id
                                            : false);

                                    $projectOffer = App\Models\Offer::where('type', 'project')
                                        ->where('project_id', $item['item_id'])
                                        ->where(function ($query) use ($item) {
                                            $query
                                                ->orWhereJsonContains('project_housings', [$item['room_order']])
                                                ->orWhereJsonContains('project_housings', (string) $item['room_order']); // Handle as string as JSON might store values as strings
                                        })
                                        ->where('start_date', '<=', now())
                                        ->where('end_date', '>=', now())
                                        ->first();

                                    $projectDiscountAmount = $projectOffer ? $projectOffer->discount_amount : 0;

                                    $statusSlug = null;
                                    $lastHousingCount = 0;
                                    $sumCartOrderQt = $item['sumCartOrderQt'];

                                    $blockName = null;
                                    $projectHousingsList = $item['projectHousingsList'];
                                    $project = $item['project'];
                                    $share_sale = $item['project_values']['share_sale[]'] ?? null;
                                    $share_sale_empty = !isset($share_sale) || $share_sale == '[]';
                                    $blockName = null;
                                @endphp
                                @if (isset($item) &&
                                        ((isset($item['housing']) && !empty($item['housing'])) ||
                                            (isset($item['project']) && !empty($item['project']))))
                                    <div class="d-flex" style="flex-wrap: nowrap">
                                        <div class="align-items-center d-flex " style="padding-right:0; width: 110px;">
                                            <div class="project-inner project-head">
                                                <a
                                                    href="{{ $item['item_type'] == 1 ? route('project.housings.detail', ['projectSlug' => $item['project']['slug'], 'projectID' => $item['project']['id'] + 1000000, 'housingOrder' => $item['room_order']]) : route('housing.show', ['housingSlug' => $item['housing']->step1_slug . '-' . $item['housing']->step2_slug . '-' . $item['housing']->slug, 'housingID' => $item['housing']->id + 2000000]) }}">
                                                    <div class="homes">
                                                        <div class="homes-img h-100 d-flex align-items-center"
                                                            style="width: 130px; height: 128px;">
                                                            <img src="{{ $item['item_type'] == 1 ? URL::to('/') . '/project_housing_images/' . $item['project_values']['image[]'] : URL::to('/') . '/housing_images/' . json_decode($item['housing']['housing_type_data'])->image }}"
                                                                alt="home-1" class="img-responsive"
                                                                style="height: 100px !important; object-fit: cover;width:100px">
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="w-100" style="padding-left:0;">
                                            <div class="bg-white px-3 h-100 d-flex flex-column justify-content-center">

                                                <a style="text-decoration: none;height:100%"
                                                    href="{{ $item['item_type'] == 1 ? route('project.housings.detail', ['projectSlug' => $item['project']['slug'], 'projectID' => $item['project']['id'] + 1000000, 'housingOrder' => $item['room_order']]) : route('housing.show', ['housingSlug' => $item['housing']->step1_slug . '-' . $item['housing']->step2_slug . '-' . $item['housing']->slug, 'housingID' => $item['housing']->id + 2000000]) }}">
                                                    <div class="d-flex" style="gap: 8px;justify-content:space-between">

                                                        <h4>
                                                            İlan
                                                            No:{{ $item['item_type'] == 1 ? $item['project']->id + $item['room_order'] + 1000000 : $item['housing']->id + 2000000 }}
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
                                                @if (($item['action'] && $item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                                                    @php
                                                        $discountedPrice = null;
                                                        $price = null;
                                                        $discountRate = null;
                                                        if (
                                                            $item['item_type'] == 2 &&
                                                            isset(
                                                                json_decode($item['housing']['housing_type_data'])
                                                                    ->discount_rate[0],
                                                            )
                                                        ) {
                                                            $discountRate = json_decode(
                                                                $item['housing']['housing_type_data'],
                                                            )->discount_rate[0];
                                                            $price =
                                                                json_decode($item['housing']['housing_type_data'])
                                                                    ->price[0] - $item['discount_amount'];
                                                            $discountedPrice = $price - ($price * $discountRate) / 100;
                                                        } elseif ($item['item_type'] == 1) {
                                                            $discountRate =
                                                                $item['project_values']['discount_rate[]'] ?? 0;
                                                            $share_sale =
                                                                $item['project_values']['share_sale[]'] ?? null;
                                                            $number_of_share =
                                                                $item['project_values']['number_of_shares[]'] ?? null;
                                                            $price =
                                                                $item['project_values']['price[]'] -
                                                                $item['discount_amount'];
                                                            $discountedPrice = $price - ($price * $discountRate) / 100;
                                                        }
                                                    @endphp
                                                    @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                        <span class="w-100">
                                                            1 Hisse Fiyatı
                                                        </span>
                                                    @endif

                                                    @if (isset($discountRate) && $discountRate != 0)
                                                        <h6
                                                            style="color: #274abb !important; position: relative; top: 4px; font-weight: 700">
                                                            @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                                {{ number_format($discountedPrice / $number_of_share, 0, ',', '.') }}
                                                                ₺
                                                            @else
                                                                {{ number_format($discountedPrice, 0, ',', '.') }} ₺
                                                            @endif
                                                        </h6>

                                                        <del style="color: #e54242;">
                                                            @if ($item['item_type'] == 1)
                                                                @if (isset($item['project_values']['price[]']))
                                                                    @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                                        {{ number_format($item['project_values']['price[]'] / $number_of_share, 0, ',', '.') }}
                                                                    @else
                                                                        {{ number_format($item['project_values']['price[]'], 0, ',', '.') }}
                                                                    @endif
                                                                @elseif ($item['project_values']['daily_rent[]'])
                                                                    {{ number_format($item['project_values']['daily_rent[]'], 0, ',', '.') }}
                                                                @endif
                                                            @else
                                                                @if (isset(json_decode($item['housing']['housing_type_data'])->price[0]))
                                                                    {{ number_format(json_decode($item['housing']['housing_type_data'])->price[0], 0, ',', '.') }}
                                                                @elseif (isset(json_decode($item['housing']['housing_type_data'])->daily_rent[0]))
                                                                    {{ number_format(json_decode($item['housing']['housing_type_data'])->daily_rent[0], 0, ',', '.') }}
                                                                @endif
                                                            @endif

                                                            ₺
                                                        </del>
                                                    @else
                                                        <h6
                                                            style="color: #274abb !important; position: relative; top: 4px; font-weight: 700">
                                                            @if ($item['item_type'] == 1)
                                                                @if (isset($item['project_values']['price[]']))
                                                                    @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                                        {{ number_format($item['project_values']['price[]'] / $number_of_share, 0, ',', '.') }}
                                                                    @else
                                                                        {{ number_format($item['project_values']['price[]'], 0, ',', '.') }}
                                                                    @endif
                                                                @elseif ($item['project_values']['daily_rent[]'])
                                                                    @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                                        {{ number_format($item['project_values']['daily_rent[]'] / $number_of_share, 0, ',', '.') }}
                                                                    @else
                                                                        {{ number_format($item['project_values']['daily_rent[]'], 0, ',', '.') }}
                                                                    @endif
                                                                @endif
                                                            @else
                                                                @if (isset(json_decode($item['housing']['housing_type_data'])->price[0]))
                                                                    {{ number_format(json_decode($item['housing']['housing_type_data'])->price[0], 0, ',', '.') }}
                                                                @elseif (isset(json_decode($item['housing']['housing_type_data'])->daily_rent[0]))
                                                                    {{ number_format(json_decode($item['housing']['housing_type_data'])->daily_rent[0], 0, ',', '.') }}
                                                                @endif
                                                            @endif ₺
                                                        </h6>
                                                    @endif
                                                @endif
                                                <div class="d-flex align-items-end projectItemFlex" style="width:100%;">

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
                                                                    <button class="CartBtn mobileCBtn" data-type='housing'
                                                                        data-id='{{ $item['housing']->id }}'>
                                                                        <span class="IconContainer">
                                                                            <img src="{{ asset('sc.png') }}"
                                                                                alt="">
                                                                        </span>
                                                                        <span class="text">Sepete Ekle</span>
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
                                                                    window.location.href =
                                                                        "{{ route('housing.show', ['housingSlug' => $item['housing']->step1_slug . '-' . $item['housing']->step2_slug . '-' . $item['housing']->slug, 'housingID' => $item['housing']->id + 2000000]) }}";
                                                                }
                                                            </script>
                                                        @endif
                                                    @else
                                                        @if (
                                                            $item['project_values']['off_sale[]'] != '[]' &&
                                                                $item['project_values']['off_sale[]'] != '["Sat\u0131\u015fa A\u00e7\u0131k"]')
                                                            @if ($item['project_values']['off_sale[]'] == '["Sat\u0131\u015fa Kapal\u0131"]')
                                                                <button class="btn second-btn  mobileCBtn"
                                                                    style="background: #EA2B2E !importantcolor:White">

                                                                    <span class="text">Satışa Kapatıldı</span>
                                                                </button>
                                                            @elseif ($item['project_values']['off_sale[]'] == '["Sat\u0131ld\u0131"]')
                                                                <button class="btn second-btn"
                                                                    style="background: #EA2B2E !important; color: White; height: auto !important">
                                                                    <span class="text">Satıldı</span>
                                                                </button>
                                                            @endif
                                                        @elseif ($item['action'] && $item['action'] != 'tryBuy' && $item['action'] != 'noCart')
                                                            <button class="btn second-btn  mobileCBtn"
                                                                @if ($item['action'] == 'payment_await') style="background: orange !important;color:White" @else  style="background: #EA2B2E !important;color:White;height: 40px !important;width:100%" @endif>
                                                                @if ($item['action'] == 'payment_await')
                                                                    <span class="text">Rezerve Edildi</span>
                                                                @else
                                                                    <span class="text">Satıldı</span>
                                                                @endif
                                                            </button>
                                                        @else
                                                            <div style="width:50% !important;">

                                                                <button class="CartBtn second-btn mobileCBtn "
                                                                    data-type='project'
                                                                    data-project='{{ $item['project']->id }}'
                                                                    data-id='{{ $item['room_order'] }}'
                                                                    data-share="{{ $share_sale }}"
                                                                    data-number-share="{{ $number_of_share }}">
                                                                    <span class="IconContainer">
                                                                        <img src="{{ asset('sc.png') }}" alt="">
                                                                    </span>
                                                                    <span class="text">Sepete Ekle</span>
                                                                </button>
                                                            </div>

                                                            <button class="first-btn payment-plan-button"
                                                                project-id="{{ $item['project']->id }}"
                                                                style="width:50% !important;height:25px !important;background-color:black !important;border:1px solid black;color:white"
                                                                data-sold="{{ ($sold && $sold->status != 2 && $share_sale_empty) || (!$share_sale_empty && isset($sumCartOrderQt[$item['room_order']]) && $sumCartOrderQt[$item['room_order']]['qt_total'] == $number_of_share) || (!$sold && isset($projectHousingsList[$item['room_order']]['off_sale']) && $projectHousingsList[$item['room_order']]['off_sale'] != '[]') ? 1 : 0 }}"
                                                                order="{{ $item['room_order'] }}"
                                                                data-block="{{ $blockName }}"
                                                                data-payment-order="{{ $item['room_order'] }}">
                                                                Ödeme Detayı
                                                            </button>
                                                        @endif
                                                    @endif

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
                                                        #{{ $item['item_type'] == 1 ? $item['project']->id + $item['room_order'] + 1000000 : $item['housing']->id + 2000000 }}
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
                                                        #{{ $item['project']->id + $item['room_order'] + 1000000 }}
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
                                @endif
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
        .fa-heart-o,
        .fa-bookmark-o {
            color: #666 !important;
        }

        .CartBtn {
            margin-top: 0 !important;
        }

        .mobile-hidden {
            display: block;
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
