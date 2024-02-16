@if (isset($parents) && count($parents) > 0)
    <ul style="margin-left: 20px" class="item_submenu">
        @foreach ($parents as $parent)
            <li @if ($housingTypeSlug) class="@if ($housingTypeSlug == $parent->slug) d-show @else d-none @endif" @endif>
                <a href="{{ url('kategori/' . ($slugItem ? $slugItem . '/' : '') . ($housingTypeParentSlug ? $housingTypeParentSlug . '/' : '') . $item->slug . '/' . $parent->slug) }}">
                    <i class="fa fa-caret-right" aria-hidden="true"></i>{{ $parent->title }}
                </a>
                @include('client.layouts.partials.submenu', ['parents' => $parent->parents, 'connections' => $parent->connections])
            </li>
        @endforeach
    </ul>
@else
    @if (isset($connections) && count($connections) > 0 && $optName)
        <ul style="margin-left: 20px" class="item_submenu">
            @foreach ($connections as $connection)
                <li @if ($housingTypeSlug) class="@if ($housingTypeSlug == $connection->housingType->slug) d-show @else d-none @endif" @endif>
                    <a href="{{ url('kategori/' . ($slugItem ? $slugItem . '/' : '') . ($housingTypeParentSlug ? $housingTypeParentSlug . '/' : '') . $item->slug . '/' . $connection->housingType->slug) }}">
                        {{ $connection->housingType->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
@endif
