@extends('client.layouts.masterPanel')

@section('content')
    <div class="content">
        <div class="card border mb-3 mt-3" data-list="{&quot;valueNames&quot;:[&quot;icon-list-item&quot;]}">

            <div class="card-body">
                <div class="mobile-hidden">
                    <div class="row project-filter-reverse blog-pots" style="width: 100%">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 15%">İlan No</th>
                                    <th style="width: 10%">Kapak Fotoğrafı</th>
                                    <th style="width: 35%">İlan Başlığı</th>
                                    <th style="width: 10%">Fiyat</th>
                                    <th style="width: 15%">Kazanç</th>

                                    <th style="width: 5%"></th>
                                </tr>
                            </thead>
                            <tbody class="collection-title">
                                @foreach ($mergedItems as $item)
                                    @php
                                        $discountedPrice = null;
                                        $price = null;
                                        $share_sale = null;
                                        $number_of_share = null;
                                        $deposit_rate = 0.02;

                                        if (
                                            $item['item_type'] == 2 &&
                                            isset(json_decode($item['housing']['housing_type_data'])->discount_rate[0])
                                        ) {
                                            $discountRate = json_decode($item['housing']['housing_type_data'])
                                                ->discount_rate[0];

                                            $defaultPrice =
                                                json_decode($item['housing']['housing_type_data'])->price[0] ??
                                                json_decode($item['housing']['housing_type_data'])->daily_rent[0];

                                            $price = $defaultPrice - $item['discount_amount'];
                                            $discountedPrice = $price - ($price * $discountRate) / 100;
                                            $deposit_rate = 0.02;
                                        } elseif ($item['item_type'] == 1) {
                                            $discountRate = $item['project_values']['discount_rate[]'] ?? 0;
                                            $share_sale = $item['project_values']['share_sale[]'] ?? null;
                                            $number_of_share = $item['project_values']['number_of_shares[]'] ?? null;
                                            $price = $item['project_values']['price[]'] - $item['discount_amount'];
                                            $discountedPrice = $price - ($price * $discountRate) / 100;
                                            $deposit_rate = $item['project']->deposit_rate / 100;
                                        }
                                    @endphp

                                    <tr>
                                        <td>
                                            #{{ $item['item_type'] == 1 ? $item['project']->id + $item['room_order'] + 1000000 : $item['housing']->id + 2000000 }}

                                        </td>

                                        <td>
                                            <a
                                                href="{{ $item['item_type'] == 1 ? route('project.housings.detail', ['projectSlug' => $item['project']['slug'], 'projectID' => $item['project']['id'] + 1000000, 'housingOrder' => $item['room_order']]) : route('housing.show', ['housingSlug' => $item['housing']['step1_slug'] . '-' . $item['housing']['step2_slug'] . '-' . $item['housing']['slug'], 'housingID' => $item['housing']['id'] + 2000000]) }}">
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
                                            @endif
                                            <spanW style="font-size: 9px !important;font-weight:700">
                                                {{ isset($item['item_type']) && $item['item_type'] == 1
                                                    ? $item['project']['city']['title'] .
                                                        ' / ' .
                                                        $item['project']['county']['ilce_title'] .
                                                        ' / ' .
                                                        $item['project']['neighbourhood']['mahalle_title']
                                                    : ($item['housing']['city']
                                                        ? $item['housing']['city']['title']
                                                        : 'City Not Available') }}
                                                <br>
                                            </spanW>
                                        </td>
                                        <td>
                                            @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                <span class="text-center w-100">
                                                    1 Hisse Fiyatı
                                                </span><br>
                                            @endif
                                            @if (($item['action'] && $item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                                                @if (isset($discountRate) && $discountRate != 0 && isset($discountedPrice))
                                                    <span style="color: green;">
                                                        {{ number_format($discountedPrice, 0, ',', '.') }} ₺
                                                    </span><br>
                                                    <del style="color: #e54242;">

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
                                                    </del>
                                                @else
                                                    <span style="color: green; ">
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
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-danger" style="font-weight: 700"> SATILDI</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="ml-auto text-success priceFont">
                                                @if (($item['action'] && $item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                                                    @if ($item['item_type'] == 2)
                                                        @php

                                                            $rates = App\Models\Rate::where(
                                                                'housing_id',
                                                                $item['housing']['id'],
                                                            )->get();

                                                            $share_percent_earn = null;
                                                            $sales_rate_club = null;

                                                            foreach ($rates as $key => $rate) {
                                                                if (
                                                                    Auth::user()->corporate_type ==
                                                                    $rate->institution->name
                                                                ) {
                                                                    $sales_rate_club = $rate->sales_rate_club;
                                                                }
                                                                if (
                                                                    $item['housing']['user']['corporate_type'] ==
                                                                    $rate->institution->name
                                                                ) {
                                                                    $share_percent_earn = $rate->default_deposit_rate;
                                                                    $share_percent_balance = 1.0 - $share_percent_earn;
                                                                }
                                                            }

                                                            if ($sales_rate_club === null && count($rates) > 0) {
                                                                $sales_rate_club = $rates->last()->sales_rate_club;
                                                            }

                                                            $total = $discountedPrice * 0.04 * $share_percent_earn;

                                                            $earningAmount = $total * $sales_rate_club;
                                                        @endphp
                                                        <strong>
                                                            @if (strpos($earningAmount, '.') == false)
                                                                {{ number_format($earningAmount, 0, ',', '.') }} ₺
                                                            @else
                                                                {{ $earningAmount }} ₺
                                                            @endif

                                                        </strong>
                                                    @elseif ($item['item_type'] == 1)
                                                        @php
                                                            $estateProjectRate = $item['project']['club_rate'] / 100;
                                                            if (Auth::user()->type != '1') {
                                                                if (Auth::user()->corporate_type == 'Emlak Ofisi') {
                                                                    $sharePercent = $estateProjectRate;
                                                                } else {
                                                                    $sharePercent = 0.5;
                                                                }
                                                            } else {
                                                                $sharePercent = 0.25;
                                                            }
                                                            $discountedPrice =
                                                                isset($discountRate) &&
                                                                $discountRate != 0 &&
                                                                isset($discountedPrice)
                                                                    ? $discountedPrice
                                                                    : (isset($item['project_values']['price[]'])
                                                                        ? $item['project_values']['price[]']
                                                                        : $item['project_values']['daily_rent[]']);
                                                            if (Auth::user()->corporate_type == 'Emlak Ofisi') {
                                                                $earningAmount = $discountedPrice * $sharePercent;
                                                            } else {
                                                                $earningAmount =
                                                                    $discountedPrice * $deposit_rate * $sharePercent;
                                                            }
                                                        @endphp
                                                        <strong>
                                                            @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                                {{ number_format($earningAmount / $number_of_share, 0, ',', '.') }}
                                                            @else
                                                                @if (strpos($earningAmount, '.') == false)
                                                                    {{ number_format($earningAmount, 0, ',', '.') }}
                                                                @else
                                                                    {{ $earningAmount }}
                                                                @endif
                                                            @endif ₺
                                                        </strong>
                                                    @endif
                                                @else
                                                    @if (isset($item['share_price']['balance']) && $item['share_price']['status'] == '0')
                                                        <strong style="color: orange">
                                                            <span>Onay Bekleniyor:</span><br>
                                                            {{ number_format($item['share_price']['balance'], 0, ',', '.') }}
                                                            ₺
                                                        </strong>
                                                    @elseif (isset($item['share_price']['balance']) && $item['share_price']['status'] == '1')
                                                        <strong style="color: green">
                                                            <span>Komisyon Kazancınız:</span><br>
                                                            {{ number_format($item['share_price']['balance'], 0, ',', '.') }}
                                                            ₺

                                                        </strong>
                                                    @elseif (isset($item['share_price']['balance']) && $item['share_price']['status'] == '2')
                                                        <strong style="color: red">
                                                            <span>Kazancınız Reddedildi:</span><br>
                                                            {{ number_format($item['share_price']['balance'], 0, ',', '.') }}
                                                            ₺

                                                        </strong>
                                                    @else
                                                        -
                                                    @endif
                                                @endif
                                            </span>
                                        </td>


                                        <td>

                                            <button class="btn btn-info remove-from-collection btn-sm" style="float: right"
                                                data-collection="{{ $collection }}"
                                                data-type="{{ $item['item_type'] == 1 ? 'project' : 'housing' }}"
                                                data-id="{{ $item['item_type'] == 1 ? $item['room_order'] : $item['housing']->id }}"
                                                @if ($item['item_type'] == 1) data-project="{{ $item['project']->id }}" @endif>
                                                Sil
                                            </button>

                                        </td>


                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mobile-show">

                    @foreach ($mergedItems as $item)
                        @php
                            $discountedPrice = null;
                            $price = null;

                            if (
                                $item['item_type'] == 2 &&
                                isset(json_decode($item['housing']['housing_type_data'])->discount_rate[0])
                            ) {
                                $discountRate = json_decode($item['housing']['housing_type_data'])->discount_rate[0];
                                $defaultPrice =
                                    json_decode($item['housing']['housing_type_data'])->price[0] ??
                                    json_decode($item['housing']['housing_type_data'])->daily_rent[0];

                                $price = $defaultPrice - $item['discount_amount'];
                                $discountedPrice = $price - ($price * $discountRate) / 100;
                            } elseif ($item['item_type'] == 1) {
                                $discountRate = $item['project_values']['discount_rate[]'] ?? 0;
                                $share_sale = $item['project_values']['share_sale[]'] ?? null;
                                $number_of_share = $item['project_values']['number_of_shares[]'] ?? null;
                                $price = $item['project_values']['price[]'] - $item['discount_amount'];
                                $discountedPrice = $price - ($price * $discountRate) / 100;
                            }
                        @endphp
                        <div class="d-flex" style="flex-wrap: nowrap">
                            <div class="align-items-center d-flex " style="padding-right:0; width: 70px;">
                                <div class="project-inner project-head">
                                    <a
                                        href="{{ $item['item_type'] == 1 ? route('project.housings.detail', ['projectSlug' => $item['project']['slug'], 'projectID' => $item['project']['id'] + 1000000, 'housingOrder' => $item['room_order']]) : route('housing.show', ['housingSlug' => $item['housing']['step1_slug'] . '-' . $item['housing']['step2_slug'] . '-' . $item['housing']['slug'], 'housingID' => $item['housing']['id'] + 2000000]) }}">
                                        <div class="homes">
                                            <div class="homes-img h-100 d-flex align-items-center">
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

                                    <a
                                        href="{{ $item['item_type'] == 1 ? route('project.housings.detail', ['projectSlug' => $item['project']['slug'], 'projectID' => $item['project']['id'] + 1000000, 'housingOrder' => $item['room_order']]) : route('housing.show', ['housingSlug' => $item['housing']['step1_slug'] . '-' . $item['housing']['step2_slug'] . '-' . $item['housing']['slug'], 'housingID' => $item['housing']['id'] + 2000000]) }}">
                                        <div class="d-flex"
                                            style="gap: 8px;justify-content:space-between;align-items:center">

                                            <h4>
                                                #{{ $item['item_type'] == 1 ? $item['project']->id + $item['room_order'] + 1000000 : $item['housing']->id + 2000000 }}
                                                <br>
                                                {{ $item['item_type'] == 1 ? $item['project_values']['advertise_title[]'] : $item['housing']->title }}
                                            </h4>

                                            <button class="btn btn-danger"
                                                data-type="{{ $item['item_type'] == 1 ? 'project' : 'housing' }}"
                                                style="width:50px;padding:4px !important;margin-bottom:4px"
                                                data-id="{{ $item['item_type'] == 1 ? $item['room_order'] : $item['housing']->id }}"
                                                @if ($item['item_type'] == 1) data-project="{{ $item['project']->id }}" @endif>
                                                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor"
                                                    stroke-width="2" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round" class="css-i6dzq1">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
                                                    <line x1="10" y1="11" x2="10" y2="17">
                                                    </line>
                                                    <line x1="14" y1="11" x2="14" y2="17">
                                                    </line>
                                                </svg>
                                            </button>

                                        </div>
                                    </a>

                                    <div class="d-flex" style="align-items: center;justify-content:space-between">
                                        <div>
                                            @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                <span class="text-center w-100">
                                                    1 Hisse Fiyatı
                                                </span><br>
                                            @endif
                                            @if (($item['action'] && $item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                                                @if (isset($discountRate) && $discountRate != 0 && isset($discountedPrice))
                                                    <span style="color: green;">
                                                        {{ number_format($discountedPrice, 0, ',', '.') }} ₺
                                                    </span><br>
                                                    <del style="color: #e54242;">

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
                                                    </del>
                                                @else
                                                    <span style="color: green; ">
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
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-danger" style="font-weight: 700"> SATILDI</span>
                                            @endif
                                        </div>

                                        <div>

                                            <span class="ml-auto text-success priceFont">
                                                @if (($item['action'] && $item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                                                    @if ($item['item_type'] == 2)
                                                        @php

                                                            $rates = App\Models\Rate::where(
                                                                'housing_id',
                                                                $item['housing']['id'],
                                                            )->get();

                                                            $share_percent_earn = null;
                                                            $sales_rate_club = null;

                                                            foreach ($rates as $key => $rate) {
                                                                if (
                                                                    Auth::user()->corporate_type ==
                                                                    $rate->institution->name
                                                                ) {
                                                                    $sales_rate_club = $rate->sales_rate_club;
                                                                }
                                                                if (
                                                                    $item['housing']['user']['corporate_type'] ==
                                                                    $rate->institution->name
                                                                ) {
                                                                    $share_percent_earn = $rate->default_deposit_rate;
                                                                    $share_percent_balance = 1.0 - $share_percent_earn;
                                                                }
                                                            }

                                                            if ($sales_rate_club === null && count($rates) > 0) {
                                                                $sales_rate_club = $rates->last()->sales_rate_club;
                                                            }

                                                            $total = $discountedPrice * 0.04 * $share_percent_earn;

                                                            $earningAmount = $total * $sales_rate_club;
                                                        @endphp
                                                        <strong>

                                                            @if (strpos($earningAmount, '.') == false)
                                                                {{ number_format($earningAmount, 0, ',', '.') }} ₺
                                                            @else
                                                                {{ $earningAmount }} ₺
                                                            @endif
                                                        </strong>
                                                    @elseif ($item['item_type'] == 1)
                                                        @php
                                                            $estateProjectRate = $item['project']['club_rate'] / 100;
                                                            if (Auth::user()->type != '1') {
                                                                if (Auth::user()->corporate_type == 'Emlak Ofisi') {
                                                                    $sharePercent = $estateProjectRate;
                                                                } else {
                                                                    $sharePercent = 0.5;
                                                                }
                                                            } else {
                                                                $sharePercent = 0.25;
                                                            }
                                                            $discountedPrice = (isset($discountedPrice)
                                                                    ? $discountedPrice
                                                                    : isset($item['project_values']['price[]']))
                                                                ? $item['project_values']['price[]']
                                                                : $item['project_values']['daily_rent[]'];

                                                            if (Auth::user()->corporate_type == 'Emlak Ofisi') {
                                                                $earningAmount = $discountedPrice * $sharePercent;
                                                            } else {
                                                                $earningAmount =
                                                                    $discountedPrice * $deposit_rate * $sharePercent;
                                                            }

                                                        @endphp
                                                        <strong>
                                                            @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                                {{ number_format($earningAmount / $number_of_share, 0, ',', '.') }}
                                                            @else
                                                                @if (strpos($earningAmount, '.') == false)
                                                                    {{ number_format($earningAmount, 0, ',', '.') }}
                                                                @else
                                                                    {{ $earningAmount }}
                                                                @endif
                                                            @endif ₺
                                                        </strong>
                                                    @endif
                                                @else
                                                    @if (isset($item['share_price']['balance']) && $item['share_price']['status'] == '0')
                                                        <strong style="color: orange">
                                                            <span>Onay Bekleniyor:</span><br>
                                                            {{ $item['share_price']['balance'] }} ₺
                                                        </strong>
                                                    @elseif (isset($item['share_price']['balance']) && $item['share_price']['status'] == '1')
                                                        <strong style="color: green">
                                                            <span>Komisyon Kazancınız:</span><br>
                                                            {{ $item['share_price']['balance'] }} ₺
                                                        </strong>
                                                    @elseif (isset($item['share_price']['balance']) && $item['share_price']['status'] == '2')
                                                        <strong style="color: red">
                                                            <span>Kazancınız Reddedildi:</span><br>
                                                            {{ $item['share_price']['balance'] }} ₺
                                                        </strong>
                                                    @else
                                                        -
                                                    @endif
                                                @endif
                                            </span>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>


                        <hr>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    <!-- Modal -->


@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".remove-from-collection").on("click", function() {
                var button = $(this); // Tıklanan düğmeyi referans al
                var itemType = button.data('type');
                var itemId = button.data('id');
                var projectId = button.data('project');
                var collection = button.data('collection');

                $.ajax({
                    method: 'POST',
                    url: '/remove-from-collection',
                    data: {
                        itemType: itemType,
                        itemId: itemId,
                        projectId: projectId,
                        collection: collection,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.complete) {

                            var redirectUrl = '/hesabim/koleksiyonlarim';

                            // Yönlendirme yap
                            window.location.href = redirectUrl;

                        } else {
                            location.reload();
                        }
                    },
                    error: function(error) {
                        console.error('Hata:', error);
                    }
                });
            });
        });
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        .mobile-hidden {
            display: flex;
        }

        .mobile-show {
            display: none;
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

        thead,
        tbody,
        tfoot,
        tr,
        td,
        th {
            text-align: center
        }


        @media (max-width: 768px) {

            h4,
            .h4 {
                font-size: 11px !important;
            }

            .mobile-hidden {
                display: none
            }

            .mobile-show {
                display: block
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
