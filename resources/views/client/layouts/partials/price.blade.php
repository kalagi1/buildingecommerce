@php
    $offSaleValue = getData($project, 'off_sale[]', $i + 1)->value ?? null;
    $priceValue = getData($project, 'price[]', $i + 1)->value ?? null;
@endphp

@if ($offSaleValue == '[]' && $priceValue)
    @if ($sold && ($sold->status != '1' && $sold->status != '0'))
        @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
            <h6 style="color: #EA2B2E !important;position: relative;top:4px;font-weight:600;font-size: 11px;text-decoration:line-through;margin-right:5px">
                {{ number_format($priceValue, 0, ',', '.') }} ₺
            </h6>
            <h6 style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:20px;">
                {{ number_format($priceValue - $offer->discount_amount, 0, ',', '.') }} ₺
            </h6>
        @else
            <h6 style="color: #EA2B2E !important;position: relative;top:4px;font-weight:600">
                {{ number_format($priceValue, 0, ',', '.') }} ₺
            </h6>
        @endif
    @else
        @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
            <h6 style="color: #EA2B2E !important;position: relative;top:4px;font-weight:600;font-size: 11px;text-decoration:line-through;margin-right:5px">
                {{ number_format($priceValue, 0, ',', '.') }} ₺
            </h6>
            <h6 style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:20px;">
                {{ number_format($priceValue - $offer->discount_amount, 0, ',', '.') }} ₺
            </h6>
        @else
            <h6 style="color: #EA2B2E !important;position: relative;top:4px;font-weight:600">
                {{ number_format($priceValue, 0, ',', '.') }} ₺
            </h6>
        @endif
    @endif
@endif
