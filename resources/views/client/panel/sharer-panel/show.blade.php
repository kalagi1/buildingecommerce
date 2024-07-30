@extends('client.layouts.masterPanel')

@section('content')
    <div class="table-breadcrumb mb-5">
        <ul>
            <li>
                Hesabım
            </li>
            <li>
                Koleksiyonlarım
            </li>
            <li>{{ $collection->name }} Koleksiyonu</li>
            <li>{{ count($collection->links) }} İlan</li>

        </ul>
    </div>
    <section>

        @foreach ($mergedItems as $key => $item)
            @php
                $discountedPrice = (float) 0;
                $price = (float) 0;
                $share_sale = (float) 0;
                $number_of_share = (float) 0;
                $deposit_rate = (float) 0.02;

                if ($item['item_type'] == 2) {
                    // Housing items
                    $housingData = json_decode($item['housing']['housing_type_data']);
                    $discountRate = isset($housingData->discount_rate[0]) ? (float) $housingData->discount_rate[0] : 0;

                    // Determine the base price
                    $defaultPrice = isset($housingData->price[0])
                        ? (float) $housingData->price[0]
                        : (isset($housingData->daily_rent[0])
                            ? (float) $housingData->daily_rent[0]
                            : 0);

                    // Calculate the price and discounted price
                    $price = $defaultPrice - $item['discount_amount'];
                    $discountedPrice = $price - ($price * $discountRate) / 100;
                } elseif ($item['item_type'] == 1) {
                    // Project items
                    $discountRate = isset($item['project_values']['discount_rate[]'])
                        ? (float) $item['project_values']['discount_rate[]']
                        : 0;
                    $share_sale = isset($item['project_values']['share_sale[]'])
                        ? (float) $item['project_values']['share_sale[]']
                        : 0;
                    $number_of_share = isset($item['project_values']['number_of_shares[]'])
                        ? (float) $item['project_values']['number_of_shares[]']
                        : 0;

                    // Determine the base price
                    $defaultPrice = isset($item['project_values']['price[]'])
                        ? (float) $item['project_values']['price[]']
                        : (isset($item['project_values']['daily_rent[]'])
                            ? (float) $item['project_values']['daily_rent[]']
                            : 0);

                    // Calculate the price and discounted price
                    $price = $defaultPrice - $item['discount_amount'];
                    $discountedPrice = $price - ($price * $discountRate) / 100;
                    $deposit_rate = isset($item['project']->deposit_rate)
                        ? (float) $item['project']->deposit_rate / 100
                        : 0.02;
                }
            @endphp

            <div class="project-table-content">
                <ul>
                    <li>
                        #{{ $item['item_type'] == 1
                            ? $item['project']->id + 1000000 . '-' . $item['room_order']
                            : $item['housing']->id + 2000000 }}
                    </li>

                    <li style="align-items: flex-start;">
                        <a
                            href="{{ $item['item_type'] == 1 ? route('project.housings.detail', ['projectSlug' => $item['project']['slug'], 'projectID' => $item['project']['id'] + 1000000, 'housingOrder' => $item['room_order']]) : route('housing.show', ['housingSlug' => $item['housing']['step1_slug'] . '-' . $item['housing']['step2_slug'] . '-' . $item['housing']['slug'], 'housingID' => $item['housing']['id'] + 2000000]) }}">
                            <img src="{{ $item['item_type'] == 1 ? URL::to('/') . '/project_housing_images/' . $item['project_values']['image[]'] : URL::to('/') . '/housing_images/' . json_decode($item['housing']['housing_type_data'])->image }}"
                                alt="home-1" class="img-responsive"
                                style="height: 40px !important;width: 40px !important; object-fit: cover;border-radius:50%;border: 1px solid #bebebe;">
                        </a>
                    </li>
                    <li>
                        {{ $item['item_type'] == 1 ? $item['project_values']['advertise_title[]'] : $item['housing']->title }}

                        @if ($item['item_type'] == 1)
                            {!! ' ' . $item['room_order'] . " No'lu Daire <br>" !!}
                        @endif
                    </li>
                    {{-- <li>
                        <span style="font-size: 9px !important;font-weight:700">
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
                        </span>
                    </li> --}}
                    <li>
                        @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                            <span class="text-center w-100">
                                1 Hisse Fiyatı
                            </span>
                        @endif
                        @if (($item['action'] && $item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                            @if (isset($discountRate) && $discountRate != 0 && isset($discountedPrice))
                                <span style="color: green;">
                                    {{ number_format($discountedPrice, 0, ',', '.') }} ₺
                                </span>
                                <del style="color: #e54242;">
                                    @if ($item['item_type'] == 1)
                                        @if (isset($item['project_values']['price[]']))
                                            @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                {{ number_format($item['project_values']['price[]'] / $number_of_share, 0, ',', '.') }}
                                            @else
                                                {{ number_format($item['project_values']['price[]'], 0, ',', '.') }}
                                            @endif
                                        @elseif (isset($item['project_values']['daily_rent[]']))
                                            @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                {{ number_format($item['project_values']['daily_rent[]'] / $number_of_share, 0, ',', '.') }}
                                            @else
                                                {{ number_format($item['project_values']['daily_rent[]'], 0, ',', '.') }}
                                            @endif
                                        @endif
                                    @else
                                        @if (isset($housingData->price[0]))
                                            {{ number_format($housingData->price[0], 0, ',', '.') }}
                                        @elseif (isset($housingData->daily_rent[0]))
                                            {{ number_format($housingData->daily_rent[0], 0, ',', '.') }}
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
                                        @elseif (isset($item['project_values']['daily_rent[]']))
                                            @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                {{ number_format($item['project_values']['daily_rent[]'] / $number_of_share, 0, ',', '.') }}
                                            @else
                                                {{ number_format($item['project_values']['daily_rent[]'], 0, ',', '.') }}
                                            @endif
                                        @endif
                                    @else
                                        @if (isset($housingData->price[0]))
                                            {{ number_format($housingData->price[0], 0, ',', '.') }}
                                        @elseif (isset($housingData->daily_rent[0]))
                                            {{ number_format($housingData->daily_rent[0], 0, ',', '.') }}
                                        @endif
                                    @endif ₺
                                </span>
                            @endif
                        @else
                            @if ($item['action'] && $item['action'] == 'payment_await')
                                <span class="text-warning" style="font-weight: 700"> REZERVE EDİLDİ</span>
                            @else
                                <span class="text-danger" style="font-weight: 700"> SATILDI</span>
                            @endif
                        @endif
                    </li>

                    <li>
                        <span class="ml-auto text-success priceFont">
                            @if (($item['action'] && $item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                                <div class="text-dark" style="color:black">
                                    <span>Komisyon Miktarı:</span><br>
                    
                                    @if ($item['item_type'] == 2)
                                        @php
                                            $rates = App\Models\Rate::where('housing_id', $item['housing']['id'])->get();
                                            $user = App\Models\User::find($item['housing']['user_id']);
                    
                                            $share_percent_earn = null;
                                            $sales_rate_club = null;
                    
                                            foreach ($rates as $rate) {
                                                if (Auth::user()->corporate_type == $rate->institution->name) {
                                                    $sales_rate_club = $rate->sales_rate_club;
                                                }
                                                if ($item['housing']['user']['corporate_type'] == $rate->institution->name ||
                                                    ($user->type == 1 && $rate->institution->name == 'Diğer')) {
                                                    $share_percent_earn = $rate->default_deposit_rate;
                                                    $share_percent_balance = 1.0 - $share_percent_earn;
                                                }
                                            }
                    
                                            if ($sales_rate_club === null && $rates->count() > 0) {
                                                $sales_rate_club = $rates->last()->sales_rate_club;
                                            }
                    
                                            $discountedPrice = isset($discountRate) && $discountRate != 0
                                                ? $discountRate
                                                : (json_decode($item['housing']['housing_type_data'])->price[0] ?? json_decode($item['housing']['housing_type_data'])->daily_rent[0]);
                    
                                            $total = $discountedPrice * 0.02 * $share_percent_earn;
                                            $earningAmount = $total * $sales_rate_club;
                                        @endphp
                                        <strong>
                                            {{ number_format($earningAmount, strpos($earningAmount, '.') === false ? 0 : 2, ',', '.') }} ₺
                                        </strong>
                                    @elseif ($item['item_type'] == 1)
                                        @php
                                            $estateProjectRate = $item['project']['club_rate'] / 100;
                                            if (Auth::user()->type != '1') {
                                                $sharePercent = Auth::user()->corporate_type == 'Emlak Ofisi' ? $estateProjectRate : 0.5;
                                            } else {
                                                $sharePercent = 0.25;
                                            }
                    
                                            $discountedPrice = isset($discountRate) && $discountRate != 0
                                                ? $discountRate
                                                : ($item['project_values']['price[]'] ?? $item['project_values']['daily_rent[]']);
                    
                                            $earningAmount = Auth::user()->corporate_type == 'Emlak Ofisi'
                                                ? $discountedPrice * $sharePercent
                                                : $discountedPrice * $deposit_rate * $sharePercent;
                                        @endphp
                                        <strong>
                                            @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                {{ number_format($earningAmount / $number_of_share, 0, ',', '.') }}
                                            @else
                                                {{ number_format($earningAmount, strpos($earningAmount, '.') === false ? 0 : 2, ',', '.') }}
                                            @endif ₺
                                        </strong>
                                    @endif
                                </div>
                            @else
                                @if ((isset($item['share_price']['balance']) && $item['share_price']['status'] == '0') ||
                                     ($item['action'] && $item['action'] == 'payment_await'))
                                    <strong style="color: orange">
                                        <span>Onay Bekleniyor @if (isset($item['share_price']['balance'])) : @endif</span><br>
                                        @if (isset($item['share_price']['balance']))
                                            {{ number_format($item['share_price']['balance'], 0, ',', '.') }} ₺
                                        @endif
                                    </strong>
                                @elseif ((isset($item['share_price']['balance']) && $item['share_price']['status'] == '1') ||
                                         ($item['action'] && $item['action'] == 'sold'))
                                    <strong style="color: green">
                                        <span>Komisyon Kazancınız @if (isset($item['share_price']['balance'])) : @endif</span><br>
                                        @if (isset($item['share_price']['balance']))
                                            {{ number_format($item['share_price']['balance'], 0, ',', '.') }} ₺
                                        @endif
                                    </strong>
                                @elseif (isset($item['share_price']['balance']) && $item['share_price']['status'] == '2')
                                    <strong style="color: red">
                                        <span>Kazancınız Reddedildi @if (isset($item['share_price']['balance'])) : @endif</span><br>
                                        @if (isset($item['share_price']['balance']))
                                            {{ number_format($item['share_price']['balance'], 0, ',', '.') }} ₺
                                        @endif
                                    </strong>
                                @else
                                    -
                                @endif
                            @endif
                        </span>
                    </li>
                    
                    <li> <span class="project-table-content-actions-button"
                            data-toggle="popover-{{ $item['item_type'] == 1
                                ? $item['project']->id + 1000000 . '-' . $item['room_order']
                                : $item['housing']->id + 2000000 }}"><i
                                class="fa fa-chevron-down"></i></span>

                    </li>
                </ul>
                <div class="popover-project-actions d-none"
                    id="popover-{{ $item['item_type'] == 1
                        ? $item['project']->id + 1000000 . '-' . $item['room_order']
                        : $item['housing']->id + 2000000 }}">
                    <ul>
                        <li>
                            <a class="remove-from-collection" data-collection="{{ $collection }}"
                                data-type="{{ $item['item_type'] == 1 ? 'project' : 'housing' }}"
                                data-id="{{ $item['item_type'] == 1 ? $item['room_order'] : $item['housing']->id }}"
                                @if ($item['item_type'] == 1) data-project="{{ $item['project']->id }}" @endif>
                                Koleksiyondan Kaldır</a>

                        </li>
                        <li>
                            <a
                                href="{{ $item['item_type'] != 1
                                    ? route('housing.show', [
                                        'housingSlug' => $item['housing']->slug,
                                        'housingID' => $item['housing']->id + 2000000,
                                    ])
                                    : route('project.housings.detail', [
                                        'projectSlug' =>
                                            optional(App\Models\Project::find($item['project']->id))->slug .
                                            '-' .
                                            optional(App\Models\Project::find($item['project']->id))->step2_slug .
                                            '-' .
                                            optional(App\Models\Project::find($item['project']->id))->housingtype->slug,
                                        'projectID' => optional(App\Models\Project::find($item['project']->id))->id + 1000000,
                                        'housingOrder' => $item['room_order'],
                                    ]) }}">
                                İlanı Gör
                            </a>
                        </li>

                    </ul>
                </div>

            </div>
        @endforeach
    </section>

@endsection

@section('scripts')
    <script src="https://unpkg.com/@material-ui/core@latest/umd/material-ui.development.js"></script>

    <script>
        $(document).ready(function() {
            $('.project-table-content-actions-button').on('click', function() {
                var targetId = $(this).data('toggle');
                var $popover = $('#' + targetId);

                // Hide other popovers
                $('.popover-project-actions').not($popover).addClass('d-none');

                // Toggle current popover
                $popover.toggleClass('d-none');
            });

            // Close popover when clicking outside
            $(document).on('click', function(event) {
                if (!$(event.target).closest('.project-table-content').length) {
                    $('.popover-project-actions').addClass('d-none');
                }
            });
        });
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
