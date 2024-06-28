@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="card border mb-3" data-list="{&quot;valueNames&quot;:[&quot;icon-list-item&quot;]}">
            <div class="card-header border-bottom bg-body">
                <div class="row flex-between-center g-2">
                    <div class="col-auto">
                        <h4 class="mb-0">Görüntülenme Listesi</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row list" id="icon-list">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th> @if (Auth::user()->corporate_type == 'Emlak Ofisi')
                                    Portföy Adı:
                                @else
                                    Koleksiyon Adı:
                                @endif</th>
                                <th>Görüntüleyen User ID</th>
                                <th>Görüntüleyen IP</th>
                                <th>Görüntülenme Tarihi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($collection->clicks as $index => $click)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $collection->name }}</td>
                                    <td>{{ optional($click->user)->name }}</td>
                                    <td>{{ $click->ip_address }}</td>
                                    <td>{{ $click->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        @media (max-width: 768px) {
            #icon-list div {
                margin-bottom: 10px;
            }
        }
    </style>
@endsection
