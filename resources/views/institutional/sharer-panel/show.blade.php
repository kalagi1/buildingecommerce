@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="card border mb-3 mt-3" data-list="{&quot;valueNames&quot;:[&quot;icon-list-item&quot;]}">

            <div class="card-body">
                <div class="mobile-hidden">
                    <div class="row project-filter-reverse blog-pots" style="width: 100%">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 10%">İlan No</th>
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
                                                @if (isset($discountRate) && $discountRate != 0 && isset($discountedPrice))
                                                    <span style="color: green;">
                                                        {{ number_format($discountedPrice, 0, ',', '.') }} ₺
                                                    </span><br>
                                                    <del style="color: red;">
                                                        {{ number_format($item['item_type'] == 1 ? $item['project_values']['price[]'] : json_decode($item['housing']['housing_type_data'])->price[0], 0, ',', '.') }}
                                                        ₺
                                                    </del>
                                                @else
                                                    <span style="color: green; ">
                                                        {{ number_format($item['item_type'] == 1 ? $item['project_values']['price[]'] : json_decode($item['housing']['housing_type_data'])->price[0], 0, ',', '.') }}
                                                        ₺
                                                    </span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <span class="ml-auto text-success priceFont">
                                                @if (($item['action'] && $item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                                                    @if ($item['item_type'] == 2)
                                                        @php
                                                            $sharePercent = 0.25;
                                                            $discountedPrice = isset($discountedPrice) ? $discountedPrice : json_decode($item['housing']['housing_type_data'])->price[0];
                                                            $earningAmount = $discountedPrice * 0.02 * $sharePercent;
                                                        @endphp
                                                        <strong>

                                                            {{ number_format($earningAmount / 2, 0, ',', '.') }} ₺
                                                        </strong>
                                                    @elseif ($item['item_type'] == 1)
                                                        @php
                                                            $sharePercent = 0.5;
                                                            $discountedPrice = isset($discountedPrice) ? $discountedPrice : $item['project_values']['price[]'];
                                                            $earningAmount = $discountedPrice * 0.02 * $sharePercent;
                                                        @endphp
                                                        <strong>
                                                            {{ number_format($earningAmount, 0, ',', '.') }} ₺
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
                                        </td>


                                        <td>

                                            <button class="btn btn-info remove-from-collection btn-sm" style="float: right"
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
                                    <button class="btn btn-danger"
                                        data-type="{{ $item['item_type'] == 1 ? 'project' : 'housing' }}"
                                        style="width:50px;padding:0 !important;margin-bottom:4px"
                                        data-id="{{ $item['item_type'] == 1 ? $item['room_order'] : $item['housing']->id }}"
                                        @if ($item['item_type'] == 1) data-project="{{ $item['project']->id }}" @endif>
                                        Sil
                                    </button>
                                    <a style="text-decoration: none;height:100%;margin-bottom:5px"
                                        href="{{ $item['item_type'] == 1 ? route('project.housings.detail', [$item['project']['slug'], $item['room_order']]) : route('housing.show', [$item['housing']['id']]) }}">
                                        <div class="d-flex"
                                            style="gap: 8px;justify-content:space-between;align-items:center">

                                            <h4>
                                                #{{ $item['item_type'] == 1 ? $item['project']->id + $item['room_order'] + 10000000 : $item['housing']->id + 2000000 }}
                                                <br>
                                                {{ $item['item_type'] == 1 ? $item['project_values']['advertise_title[]'] : $item['housing']->title }}
                                            </h4>



                                        </div>
                                    </a>
                                        @if (($item['action'] && $item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                                            <span class="badge badge-phoenix fs-10 badge-phoenix-danger">
                                                @if (isset($discountRate) && $discountRate != 0 && isset($discountedPrice))
                                                    <span>
                                                        {{ number_format($discountedPrice, 0, ',', '.') }} ₺
                                                    </span><br>
                                                    <del>
                                                        {{ number_format($item['item_type'] == 1 ? $item['project_values']['price[]'] : json_decode($item['housing']['housing_type_data'])->price[0], 0, ',', '.') }}
                                                        ₺
                                                    </del>
                                                @else
                                                    <span>
                                                        {{ number_format($item['item_type'] == 1 ? $item['project_values']['price[]'] : json_decode($item['housing']['housing_type_data'])->price[0], 0, ',', '.') }}
                                                        ₺
                                                    </span>
                                                @endif
                                            </span>
                                            <br>
                                        @endif
                                  
                                        <span class="badge badge-phoenix fs-10 badge-phoenix-success">
                                            Kazanç:
                                            @if (($item['action'] && $item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                                                @if ($item['item_type'] == 2)
                                                    @php
                                                        $sharePercent = 0.5;
                                                        $discountedPrice = isset($discountedPrice) ? $discountedPrice : json_decode($item['housing']['housing_type_data'])->price[0];
                                                        $earningAmount = $discountedPrice * $sharePercent;
                                                    @endphp
                                                    <strong>

                                                        {{ number_format($earningAmount * 0.02, 0, ',', '.') }} ₺
                                                    </strong>
                                                @elseif ($item['item_type'] == 1)
                                                    @php
                                                        $sharePercent = 0.5;
                                                        $discountedPrice = isset($discountedPrice) ? $discountedPrice : $item['project_values']['price[]'];
                                                        $earningAmount = number_format($discountedPrice * 0.02, 0, ',', '.') * $sharePercent;
                                                    @endphp
                                                    <strong>
                                                        {{ $earningAmount }} ₺
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
                                                 SATILDI
                                                @endif
                                            @endif

                                        </span>
                                </div>
                            </div>
                        </div>


                        <hr>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
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

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        .mobile-hidden {
            display: flex;
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

            h4,
            .h4 {
                font-size: 11px !important;
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
