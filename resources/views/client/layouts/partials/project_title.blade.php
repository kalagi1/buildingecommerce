{{ $advertiseTitle ? $advertiseTitle : ' ' }}

@if ($blockName)
    {{ $blockName }} {{ ' ' }} {{ $blockHousingOrder }} {{ "No'lu" }} {{ $step1Slug }}
@else
    {{ $housingOrder }} {{ "No'lu" }} {{ $step1Slug }}
@endif
