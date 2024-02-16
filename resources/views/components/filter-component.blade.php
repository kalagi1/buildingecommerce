<!-- FilterComponent.blade.php -->

<div id="room_count_field" class="room_count_field">
    <div class="trip-search mt-md-2">
        <div class="head widget-boxed-header mobile-title widget-boxed-header" onclick="toggleFilter(@isset($filter['toggle']) && $filter['toggle'] ? 'this' : 'null')">
            <span>
                @if ($filter['label'] == 'Peşin Fiyat')
                    Fiyat
                @else
                    {{ $filter['label'] }}
                @endif
            </span>
        </div>
        <div class="mt-md-2 filtreArea" @if ($filter['label'] == 'Peşin Fiyat' || $filter['label'] == 'Fiyat') style="display: flex !important;" @else style="display: none !important;" @endif>
            @foreach ($filter['values'] as $key => $value)
                @if (isset($filter['toggle']) && $filter['toggle'] == true)
                    <!-- Switch-slider öğesi -->
                    <div class="mb-2 d-flex align-items-center">
                        <label class="switch-slider">
                            <input name="{{ $filter['name'] }}[]" type="checkbox" value="{{ $value->value }}" class="filter-now form-control switch" id="{{ $filter['name'] . $key }}">
                            <span class="slider"></span>
                        </label>
                        <label for="{{ $filter['name'] . $key }}" class="form-check-label w-100 ml-4">{{ $value->label }}</label>
                    </div>
                @else
                    @if ($filter['type'] == 'select')
                        @if ($key != 0)
                            <div class="mb-2 d-flex align-items-center">
                                <input name="{{ $filter['name'] }}[]" type="checkbox" value="{{ $value->value }}" class="filter-now form-control" id="{{ $filter['name'] . $key }}">
                                <label for="{{ $filter['name'] . $key }}" class="form-check-label w-100 ml-4">{{ $value->label }}</label>
                            </div>
                        @endif
                    @elseif($filter['type'] == 'checkbox-group')
                        <div class="mb-2 d-flex align-items-center">
                            <input name="{{ $filter['name'] }}[]" type="checkbox" value="{{ $value->value }}" class="filter-now form-control" id="{{ $filter['name'] . $key }}">
                            <label for="{{ $filter['name'] . $key }}" class="form-check-label w-100 ml-4">{{ $value->label }}</label>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
    </div>
</div>
