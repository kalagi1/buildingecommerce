@extends('client.layouts.masterPanel')

@section('content')
<div class="table-breadcrumb">
    <ul>
        <li>
            Hesabım
        </li>
        <li>
            Pazarlık Teklifleri 
        </li>
        <li>
            {{ intval(2000000) + $housing->id }}
        </li>
    </ul>
</div>

@if($housing->bids && count($housing->bids) > 0)
@foreach ($housing->bids as $key => $bid)
<div class="project-table-content">
    <ul>
        <li style="width: 5%;">{{ $key + 1 }}</li>
        <li style="width: 30%;">
            <div>
                <p class="project-table-content-title">{{ $bid->user->name }}</p>
            </div>
        </li>
        <li style="width: 30%;">
            <p>{{ $bid->user->email }}</p>
        </li>
        <li style="width: 20%;">
            <p>{{ $bid->user->phone }}</p>
        </li>
        <li style="width: 10%;">
            <p>{{ number_format($bid->bid_amount, 2, ',', '.') }}</p>
        </li>
        <li style="width: 15%;">
            <p>{{ $bid->created_at->format('d.m.Y H:i') }}</p>
        </li>
        <li style="width: 10%;">
            @if ($bid->status == 'accepted')
                <span class="badge badge-phoenix badge-phoenix-success">Kabul Edildi</span>
            @elseif ($bid->status == 'rejected')
                <span class="badge badge-phoenix badge-phoenix-danger">Rededildi</span>
            @else
                <span class="badge badge-phoenix badge-phoenix-warning">Beklemede</span>
            @endif
        </li>
        <li style="width: 20%;">
            @if (Auth::check() && Auth::user()->id == $housing->user_id)
                <span class="project-table-content-actions-button" data-toggle="popover-{{ $bid->id }}">
                    <i class="fa fa-chevron-down"></i>
                </span>
            @endif
        </li>
    </ul>
    @if (Auth::check() && Auth::user()->id == $housing->user_id)
        <div class="popover-project-actions d-none" id="popover-{{ $bid->id }}">
            <ul>
                <li>
                    <form action="{{ route('bids.accept', $bid->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success btn-sm">Kabul Et</button>
                    </form>
                </li>
                <li>
                    <form action="{{ route('bids.reject', $bid->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger btn-sm">Reddet</button>
                    </form>
                </li>
            </ul>
        </div>
    @endif
</div>
@endforeach
@else

<div class="project-table-content">
    <p class="text-center mb-0">Henüz pazarlık teklifi almadınız.</p>
</div>
@endif


@endsection

@section('scripts')
    <!-- Buraya gerekli scriptler eklenebilir -->
@endsection
