<!-- partials/dropdown_user_icon.blade.php -->

<div class="dropdown hover">
    <a href="javascript:void()" class="userIcon">
        {{-- @include('client.layouts.partials.user_icon', ['text' => $mainLink]) --}}
        {{-- <i class="fa fa-angle-down pl-1"></i> --}}

        <ul>
            @foreach ($links as $link)
                <li><a href="{{ $link['url'] }}"> {{ $link['text'] }}</a></li>
            @endforeach
        </ul>
    </a>
</div>
