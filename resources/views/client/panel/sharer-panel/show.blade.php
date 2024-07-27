@extends('client.layouts.masterPanel')

@section('content')
<div class="table-breadcrumb mb-5">
    <ul>
        <li>Hesabım</li>
        <li>Koleksiyonlarım</li>
        <li>{{ $collection->name }} Koleksiyonu</li>
        <li>{{ count($collection->links) }} İlan</li>
    </ul>
</div>
<section>
    @foreach ($mergedItems as $item)
        @php
            $price = null;
            $discountedPrice = null;
            $shareSale = $numberOfShare = null;
            $depositRate = 0.02;
            
            $housingData = json_decode($item['housing']['housing_type_data']);
            if ($item['item_type'] == 2 && isset($housingData->discount_rate[0])) {
                $discountRate = $housingData->discount_rate[0];
                $defaultPrice = $housingData->price[0] ?? $housingData->daily_rent[0];
                $price = $defaultPrice - $item['discount_amount'];
                $discountedPrice = $price - ($price * $discountRate) / 100;
            } elseif ($item['item_type'] == 1) {
                $discountRate = $item['project_values']['discount_rate[]'] ?? 0;
                $shareSale = $item['project_values']['share_sale[]'] ?? null;
                $numberOfShare = $item['project_values']['number_of_shares[]'] ?? null;
                $price = $item['project_values']['price[]'] - $item['discount_amount'];
                $discountedPrice = $price - ($price * $discountRate) / 100;
                $depositRate = $item['project']->deposit_rate / 100;
            }
        @endphp
        <div class="project-table-content">
            <ul>
                <li>#{{ $item['item_type'] == 1 ? $item['project']->id + 1000000 . '-' . $item['room_order'] : $item['housing']->id + 2000000 }}</li>
                <li>
                    <a href="{{ $item['item_type'] == 1 ? route('project.housings.detail', ['projectSlug' => $item['project']['slug'], 'projectID' => $item['project']['id'] + 1000000, 'housingOrder' => $item['room_order']]) : route('housing.show', ['housingSlug' => $item['housing']['step1_slug'] . '-' . $item['housing']['step2_slug'] . '-' . $item['housing']['slug'], 'housingID' => $item['housing']['id'] + 2000000]) }}">
                        <img src="{{ $item['item_type'] == 1 ? URL::to('/') . '/project_housing_images/' . $item['project_values']['image[]'] : URL::to('/') . '/housing_images/' . $housingData->image }}" alt="home-1" class="img-responsive" style="height: 40px; width: 40px; object-fit: cover; border-radius: 50%; border: 1px solid #bebebe;">
                    </a>
                </li>
                <li>
                    {{ $item['item_type'] == 1 ? $item['project_values']['advertise_title[]'] . ' ' . $item['room_order'] . " No'lu Daire" : $item['housing']->title }}
                </li>
                <li>
                    @if ($item['item_type'] == 1)
                        {!! '1 Hisse Fiyatı' !!}
                    @endif
                    @if (($item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                        <span style="color: green;">
                            {{ number_format($discountedPrice ?? $price, 0, ',', '.') }} ₺
                        </span>
                        @if (isset($discountedPrice))
                            <del style="color: #e54242;">{{ number_format($price, 0, ',', '.') }} ₺</del>
                        @endif
                    @else
                        <span style="color: {{ $item['action'] == 'payment_await' ? 'orange' : 'red' }}; font-weight: 700">
                            {{ $item['action'] == 'payment_await' ? 'REZERVE EDİLDİ' : 'SATILDI' }}
                        </span>
                    @endif
                </li>
                <li>
                    @if (($item['action'] == 'tryBuy') || $item['action'] == 'noCart')
                        <div class="text-dark">
                            <span>Komisyon Miktarı:</span><br>
                            @php
                                $earningAmount = 0;
                                if ($item['item_type'] == 2) {
                                    $rates = App\Models\Rate::where('housing_id', $item['housing']['id'])->get();
                                    $user = App\Models\User::find($item['housing']['user_id']);
                                    $sharePercentEarn = $salesRateClub = null;
                                    foreach ($rates as $rate) {
                                        if (Auth::user()->corporate_type == $rate->institution->name) {
                                            $salesRateClub = $rate->sales_rate_club;
                                        }
                                        if ($item['housing']['user']['corporate_type'] == $rate->institution->name || ($user->type == 1 && $rate->institution->name == 'Diğer')) {
                                            $sharePercentEarn = $rate->default_deposit_rate;
                                        }
                                    }
                                    $discountedPrice = $discountedPrice ?? ($housingData->price[0] ?? $housingData->daily_rent[0]);
                                    $total = $discountedPrice * 0.02 * $sharePercentEarn;
                                    $earningAmount = $total * $salesRateClub;
                                } elseif ($item['item_type'] == 1) {
                                    $estateProjectRate = $item['project']['club_rate'] / 100;
                                    $sharePercent = Auth::user()->type != '1' && Auth::user()->corporate_type == 'Emlak Ofisi' ? $estateProjectRate : 0.25;
                                    $discountedPrice = $discountedPrice ?? ($item['project_values']['price[]'] ?? $item['project_values']['daily_rent[]']);
                                    $earningAmount = Auth::user()->corporate_type == 'Emlak Ofisi' ? $discountedPrice * $sharePercent : $discountedPrice * $depositRate * $sharePercent;
                                }
                            @endphp
                            <strong>{{ number_format($earningAmount, 0, ',', '.') }} ₺</strong>
                        </div>
                    @else
                        @if (isset($item['share_price']['balance']))
                            @php
                                $balance = number_format($item['share_price']['balance'], 0, ',', '.');
                                $statusColor = $item['share_price']['status'] == '0' ? 'orange' : ($item['share_price']['status'] == '1' ? 'green' : 'red');
                                $statusText = $item['share_price']['status'] == '0' ? 'Onay Bekleniyor' : ($item['share_price']['status'] == '1' ? 'Komisyon Kazancınız' : 'Kazancınız Reddedildi');
                            @endphp
                            <strong style="color: {{ $statusColor }}">
                                <span>{{ $statusText }}:</span><br>
                                {{ $balance }} ₺
                            </strong>
                        @else
                            -
                        @endif
                    @endif
                </li>
                <li>
                    <span class="project-table-content-actions-button" data-toggle="popover-{{ $item['item_type'] == 1 ? $item['project']->id + 1000000 . '-' . $item['room_order'] : $item['housing']->id + 2000000 }}" data-id="{{ $item['item_type'] == 1 ? $item['project']->id + 1000000 . '-' . $item['room_order'] : $item['housing']->id + 2000000 }}">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                    </span>
                    <div class="popover-{{ $item['item_type'] == 1 ? $item['project']->id + 1000000 . '-' . $item['room_order'] : $item['housing']->id + 2000000 }} d-none">
                        <a href="#" class="remove-item" data-id="{{ $item['item_type'] == 1 ? $item['project']->id + 1000000 . '-' . $item['room_order'] : $item['housing']->id + 2000000 }}">
                            <i class="fa fa-trash" aria-hidden="true"></i> İlanı Koleksiyondan Çıkar
                        </a>
                        <a href="{{ $item['item_type'] == 1 ? route('project.housings.detail', ['projectSlug' => $item['project']['slug'], 'projectID' => $item['project']['id'] + 1000000, 'housingOrder' => $item['room_order']]) : route('housing.show', ['housingSlug' => $item['housing']['step1_slug'] . '-' . $item['housing']['step2_slug'] . '-' . $item['housing']['slug'], 'housingID' => $item['housing']['id'] + 2000000]) }}">
                            <i class="fa fa-eye" aria-hidden="true"></i> İlanı İncele
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    @endforeach
</section>
<script>
    $(document).ready(function () {
        $("[data-toggle^='popover-']").popover({
            trigger: 'manual',
            html: true,
            content: function () {
                return $('.popover-' + $(this).data('id')).html();
            }
        }).on('click', function () {
            $(this).popover('toggle');
        });
        
        $(".remove-item").on('click', function (e) {
            e.preventDefault();
            let itemId = $(this).data('id');
            $.ajax({
                url: '{{ route("collection.remove") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    item_id: itemId
                },
                success: function (response) {
                    location.reload();
                }
            });
        });
    });
</script>
@endsection
