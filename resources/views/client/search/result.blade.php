@extends('client.layouts.master')

@section('content')
<section class="recently portfolio bg-white homepage-5 ">
    <div class="container">
        <span><strong style="color: black"> "{{$term}}"</strong> araması için toplam <strong style="color: black">{{ count($results['project_housings']) + count($results['projects']) + count($results['merchants'])}} </strong> sonuç bulundu.    </span>


{{-- Display the search results here --}}
<div class="header-search-box">
    {{-- Result count --}}

    
    {{-- Housing results --}}
    @if (count($results['project_housings']) > 0)
        <div class="font-weight-bold p-2 small" style="background-color: #EEE;">KONUTLAR</div>
        @foreach ($results['project_housings'] as $result)
            <a href="{{ route('housing.show', $result['id']) }}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
                <span>{{ $result['name'] }}</span>
            </a>
        @endforeach
    @endif

    {{-- Project results --}}
    @if (count($results['projects']) > 0)
        <div class="font-weight-bold p-2 small" style="background-color: #EEE;">PROJELER</div>
        @foreach ($results['projects'] as $result)
            <a href="{{ route('project.detail', $result['slug']) }}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
                <span>{{ $result['name'] }}</span>
            </a>
        @endforeach
    @endif

    {{-- Merchant results --}}
    @if (count($results['merchants']) > 0)
        <div class="font-weight-bold p-2 small" style="background-color: #EEE;">MAĞAZALAR</div>
        @foreach ($results['merchants'] as $result)
            <a href="{{ route('instituional.dashboard', $result['slug']) }}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
                <span>{{ $result['name'] }}</span>
            </a>
        @endforeach
    @endif

    {{-- No results message --}}
    @if (count($results['project_housings']) == 0 && count($results['projects']) == 0 && count($results['merchants']) == 0)
        <div class="font-weight-bold p-2 small" style="background-color: white; text-align: center;">Sonuç bulunamadı</div>
    @endif
</div>
    </div></section>
@endsection
@section('scripts')
@endsection
