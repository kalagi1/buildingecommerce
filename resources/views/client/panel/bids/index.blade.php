@extends('client.layouts.masterPanel')

@section('content')
    <div class="content">
        <h3 class="mt-2 mb-4">Pazarlık Teklifleri | İlan No : {{ intval(2000000) + $housing->id }}</h3>
        <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white">
            <div class="table-responsive mx-n1 px-1 scrollbar">
                <table class="table table-sm fs--1 mb-0">
                    <thead>
                        <tr>
                            <th>Ad</th>
                            <th>Email</th>
                            <th>Telefon</th>
                            <th>Teklif Tutarı (₺)</th>
                            <th>Teklif Tarihi</th>
                            <th>Durum</th>
                            {{-- <th>Geçerlilik Süresi</th> --}}
                            <th>İşlemler</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($housing->bids as $bid)
                            <tr>
                                <td>{{ $bid->user->name }}</td>
                                <td>{{ $bid->user->email }}</td>
                                <td>{{ $bid->user->phone }}</td>
                                <td>{{ number_format($bid->bid_amount, 2, ',', '.') }}</td>
                                <td>{{ $bid->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    @if ($bid->status == 'accepted')
                                        <span class="badge badge-phoenix badge-phoenix-success">Kabul Edildi</span>
                                    @elseif ($bid->status == 'rejected')
                                        <span class="badge badge-phoenix badge-phoenix-danger">Rededildi</span>
                                    @else
                                        <span class="badge badge-phoenix badge-phoenix-warning">Beklemede</span>
                                    @endif
                                </td>
                                {{-- <td>
                                    @if ($bid->acceptedBid)
                                        {{ $bid->acceptedBid->expires_at > now() ? $bid->acceptedBid->expires_at->diffForHumans() : 'Süre Dolmuş' }}
                                    @else
                                        -
                                    @endif
                                </td> --}}
                                <td>
                                    @if (Auth::check() && Auth::user()->id == $housing->user_id)
                                        <form action="{{ route('bids.accept', $bid->id) }}" method="POST"
                                            style="display:inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">Kabul Et</button>
                                        </form>
                                        <form action="{{ route('bids.reject', $bid->id) }}" method="POST"
                                            style="display:inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-danger btn-sm">Reddet</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Buraya gerekli scriptler eklenebilir -->
@endsection
