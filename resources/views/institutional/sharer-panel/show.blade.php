@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="card border mb-3 mt-3" data-list="{&quot;valueNames&quot;:[&quot;icon-list-item&quot;]}">

            <div class="card-body">
                <div class="row project-filter-reverse blog-pots" style="width: 100%">
                    <div class="table-responsive">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>İlan No</th>
                                    <th>Kapak Fotoğrafı</th>
                                    <th>İlan Başlığı</th>
                                    <th>Fiyat</th>
                                    <th>Kazanç</th>

                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="collection-title">
                                @foreach ($mergedItems as $item)
                                    <tr>
                                        <td>
                                            #{{ $item['item_type'] == 1 ? $item['project']->id + 10000000 : $item['housing']->id + 2000000 }}

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
                                            @endif <span style="font-size: 12px;font-weight:700">
                                                {{ $item['item_type'] == 1 ? $item['project']['city']['title'] . ' / ' . $item['project']['county']['ilce_title'] . ' / ' . $item['project']['neighbourhood']['mahalle_title'] : $item['housing']['city']['title'] . ' / ' . $item['housing']['county']['title'] . ' / ' . $item['housing']['neighborhood']['mahalle_title'] }}
                                                <br>
                                            </span>
                                        </td>
                                        <td>


                                            @if (($item['action'] && $item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                                                @if (
                                                    $item['item_type'] == 2 &&
                                                        isset(json_decode($item['housing']['housing_type_data'])->{'discount_rate'}[0]) &&
                                                        json_decode($item['housing']['housing_type_data'])->{'discount_rate'}[0]
                                                )
                                                    @php
                                                        $discountRate = json_decode($item['housing']['housing_type_data'])->{'discount_rate'}[0];
                                                        $discountedPrice = (json_decode($item['housing']['housing_type_data'])->price[0] - $item['discount_amount']) - ((json_decode($item['housing']['housing_type_data'])->price[0] - $item['discount_amount']) * $discountRate) / 100;
                                                    @endphp
                                                @elseif (
                                                    $item['item_type'] == 1 &&
                                                        isset($item['project_values']['discount_rate[]']) &&
                                                        $item['project_values']['discount_rate[]']
                                                )
                                                    @php
                                                        $discountRate = $item['project_values']['discount_rate[]'];
                                                        $discountedPrice = ($item['project_values']['price[]'] - $item['discount_amount']) - (($item['project_values']['price[]'] - $item['discount_amount']) * $discountRate) / 100;
                                                    @endphp
                                                @endif

                                                @if (isset($discountedPrice))
                                                    <span style="color: green;">
                                                        {{ number_format($discountedPrice, 0, ',', '.') }} ₺
                                                    </span><br>
                                                    <del style="color: red;">
                                                        {{ number_format($item['item_type'] == 1 ? $item['project_values']['price[]'] : json_decode($item['housing']['housing_type_data'])->price[0], 0, ',', '.') }}
                                                        ₺
                                                    </del>
                                                @else
                                                    <span style="color: green; font-size:15px !important">
                                                        {{ number_format($item['item_type'] == 1 ? $item['project_values']['price[]'] : json_decode($item['housing']['housing_type_data'])->price[0], 0, ',', '.') }}
                                                        ₺
                                                    </span>
                                                @endif
                                            @else
                                                @if ($item['action'] == 'payment_await')
                                                    <span style="color:orange;font-weight:600">Rezerve Edildi</span>
                                                @else
                                                    <span tyle="color:red;font-weight:600">Satıldı</span>
                                                @endif
                                            @endif


                                        </td>
                                        <td>
                                            @if (($item['action'] && $item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                                                @if (
                                                    ($item['item_type'] == 2 &&
                                                        isset(json_decode($item['housing']['housing_type_data'])->{'share-percent'}[0]) &&
                                                        json_decode($item['housing']['housing_type_data'])->{'share-percent'}[0] != 0) ||
                                                        null)
                                                    @php
                                                        $sharePercent = json_decode($item['housing']['housing_type_data'])->{'share-percent'}[0];
                                                        $discountedPrice = isset($discountedPrice) ? $discountedPrice : json_decode($item['housing']['housing_type_data'])->price[0];
                                                        $earningAmount = ($discountedPrice * $sharePercent) / 100;
                                                    @endphp
                                                    <strong style="color: #e54242">
                                                        {{ number_format($earningAmount, 2, ',', '.') }} ₺
                                                    </strong>
                                                @elseif (
                                                    ($item['item_type'] == 1 &&
                                                        isset($item['project_values']['share-percent[]']) &&
                                                        $item['project_values']['share-percent[]'] != 0) ||
                                                        null)
                                                    @php
                                                        $sharePercent = $item['project_values']['share-percent[]'];
                                                        $discountedPrice = isset($discountedPrice) ? $discountedPrice : $item['project_values']['price[]'];
                                                        $earningAmount = ($discountedPrice * $sharePercent) / 100;
                                                    @endphp
                                                    <strong style="color: #e54242">
                                                        {{ number_format($earningAmount, 2, ',', '.') }} ₺
                                                    </strong>
                                                @endif
                                            @else
                                                <strong style="color: #e54242">
                                                    -
                                                </strong>
                                            @endif
                                        </td>

                                        <td>
                                            <button class="btn btn-info remove-from-collection"
                                                data-type="{{ $item['item_type'] == 1 ? 'project' : 'housing' }}"
                                                data-id="{{ $item['item_type'] == 1 ? $item['room_order'] : $item['housing']->id }}"
                                                @if ($item['item_type'] == 1) data-project="{{ $item['project']->id }}" @endif>
                                                Koleksiyondan Kaldır
                                            </button>
                                        </td>
                                    </tr>
                                    @if (($item['action'] && $item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                                        @if (
                                            ($item['item_type'] == 2 &&
                                                isset(json_decode($item['housing']['housing_type_data'])->{'share-percent'}[0]) &&
                                                json_decode($item['housing']['housing_type_data'])->{'share-percent'}[0] != 0) ||
                                                null)
                                            <tr style="background-color: #8080802e">
                                                <td colspan="6">
                                                    <span style="color: #e54242">
                                                        #{{ $item['item_type'] == 1 ? $item['project']->id + 10000000 : $item['housing']->id + 2000000 }}
                                                        Numaralı İlan İçin:
                                                        Bu satıştan
                                                        %{{ json_decode($item['housing']['housing_type_data'])->{'share-percent'}[0] }}
                                                        oranında kazanç elde edeceksiniz. 
                                                        <strong>Link aracılığıyla satın alan emlak sepette üyelerine

                                                            %{{ json_decode($item['housing']['housing_type_data'])->discount_rate[0] }}
                                                            indirim uygulanacaktır.</strong>
                                                    </span>
                                                </td>
                                            </tr>
                                        @elseif (
                                            ($item['item_type'] == 1 &&
                                                isset($item['project_values']['share-percent[]']) &&
                                                $item['project_values']['share-percent[]'] != 0) ||
                                                null)
                                            <tr style="background-color: #8080802e">
                                                <td colspan="6">
                                                    <span style="color: #e54242">
                                                        #{{ $item['project']->id + 10000000 }}
                                                        Numaralı İlan İçin:
                                                        Bu satıştan
                                                        %{{ $item['project_values']['share-percent[]'] }}
                                                        oranında kazanç elde edeceksiniz.
                                                        <strong>Link aracılığıyla satın alan emlak sepette üyelerine
                                                            %{{ $item['project_values']['discount_rate[]'] }}
                                                            indirim uygulanacaktır.</strong>
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


            </div>
        </div>
        <div class="card border mb-3" data-list="{&quot;valueNames&quot;:[&quot;icon-list-item&quot;]}">

            {{-- <div class="card-body">
                <div class="row project-filter-reverse blog-pots mt-3">
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kapak Fotoğrafı</th>
                                <th>İlan Başlığı</th>
                                <th>Fiyat</th>
                                <th>Sil</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < count($items); $i++)
                                <tr>
                                    <td>
                                        <a
                                            href="{{ $items["item_type"]->item_type == 1 ? route('project.housings.detail', [$items["item_type"]->project->slug, $items["item_type"]->room_order]) : route('housing.show', [$items["item_type"]->housing->id]) }}">
                                            <img src="{{ $items["item_type"]->item_type == 1 ? URL::to('/') . '/project_housing_images/' . $items["item_type"]->project_values['image[]'] : URL::to('/') . '/housing_images/' . json_decode($items["item_type"]->housing->housing_type_data)->image }}"
                                                alt="home-1" class="img-responsive"
                                                style="height: 70px !important; object-fit: cover;width:150px">
                                        </a>
                                    </td>
                                    <td>
                                        {{ $items["item_type"]->item_type == 1 ? $items["item_type"]->project_values['advertise_title[]'] : $items["item_type"]->housing->title }}
                                        <br>
                                        <span style="font-size: 12px;font-weight:700">
                                            {{ $items["item_type"]->item_type == 1 ? $items["item_type"]->project->city->title . ' / ' . $items["item_type"]->project->county->ilce_title . ' / ' . $items["item_type"]->project->neighbourhood->mahalle_title  : $items["item_type"]->housing->city->title . ' / ' . $items["item_type"]->housing->county->title . ' / ' . $items["item_type"]->housing->neighborhood->mahalle_title }}
                                            <br>
                                        </span>
                                    </td>
                                    <td>
                                        {{ number_format($items["item_type"]->item_type == 1 ? $items["item_type"]->project_values['price[]'] : json_decode($items["item_type"]->housing->housing_type_data)->price[0], 0, ',', '.') }}
                                        ₺
                                    </td>
                                    <td>
                                        <button class="btn btn-info remove-from-collection"
                                            data-type="{{ $items["item_type"]->item_type == 1 ? 'project' : 'housing' }}"
                                            data-id="{{ $items["item_type"]->item_type == 1 ? $items["item_type"]->room_order : $items["item_type"]->housing->id }}"
                                            @if ($items['item_type']->item_type == 1) data-project="{{ $items["item_type"]->project->id }}" @endif>
                                            Koleksiyondan Kaldır
                                        </button>



                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>


                </div>
            </div> --}}
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

@section('styles')
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
