@if (count($items) > 0)
    <ul>
        @foreach ($items as $item)
            <li>
                <a href="{{ $item['href'] }}">
                    @if (!empty($item['icon']))
                        <i class="{{ $item['icon'] }}"></i>
                    @endif
                    {{ $item['text'] }}
                    @if (!empty($item['children']))
                        <span class="caret"></span>
                    @endif
                </a>

                @if (!empty($item['children']))
                    @include('client.layouts.partials.menu-item', ['items' => $item['children']])
                @endif
            </li>
        @endforeach
    </ul>
@endif
