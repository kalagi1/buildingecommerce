<!-- TextInputComponent.blade.php -->

<div id="room_count_field" class="room_count_field">
    <div class="trip-search mt-md-2">
        <div class="widget-boxed-header mobile-title widget-boxed-header" onclick="toggleFilterDiv(this)">
            <span>
                @if ($filter['label'] == 'Peşin Fiyat')
                    Fiyat
                @else
                    {{ $filter['label'] }}
                @endif
            </span>
        </div>
        <div class="d-flex align-items-center mt-md-2" @if ($filter['label'] == 'Peşin Fiyat' || $filter['label'] == 'Fiyat') style="display: flex !important;" @else style="display: none !important;" @endif>
            @if ($filter['text_style'] == 'min-max')
                <span id="slider-range-value1">
                    <input type="text" name="{{ str_replace('[]', '', $filter['name']) }}-min" id="{{ str_replace('[]', '', $filter['name']) }}-min" min="0" placeholder="En Düşük" class="filter-now form-control price-only">
                </span>
                <i class="fa fa-solid fa-minus mx-2 dark-color icon"></i>
                <span id="slider-range-value2">
                    <input type="text" id="{{ str_replace('[]', '', $filter['name']) }}-max" min="0" placeholder="En Yüksek" class="filter-now form-control price-only" name="{{ str_replace('[]', '', $filter['name']) }}-max">
                </span>
            @else
                <span class="w-100">
                    <input type="text" name="{{ str_replace('[]', '', $filter['name']) }}" id="{{ str_replace('[]', '', $filter['name']) }}" class="filter-now form-control">
                </span>
            @endif
        </div>
    </div>
</div>
