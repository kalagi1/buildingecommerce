@extends('institutional.layouts.master')

@section('content')
    <div class="container">
        <h2 class="mt-4">Kazanç sağladığım siparişler</h2>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Ürün Adı</th>
                <th scope="col">Kazanç Miktarı</th>
                <th scope="col">Satış yapılan tarih</th>
                <th scope="col">Durum</th>
              </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        @if($order->item_type == 1)
                            <td>{{$order->project->project_title}}</td>
                        @else 
                            <td>{{$order->housing->title}}</td>
                        @endif
                        <td>{{$order->price}}₺</td>
                        <td>{{date('d-m-Y H:i',strtotime($order->created_at))}}</td>
                        <td>
                            @if($order->status == 0)
                                Ödeme Onayı Bekliyor
                            @else 
                                Ödeme Onaylandı (Miktar bakiyenize yansıtıldı)
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        .mobile-hidden {
            display: flex;
        }

        .desktop-hidden {
            display: none;
        }

        .homes-content .footer {
            display: none
        }

        .price-mobile {
            display: flex;
            align-items: self-end;
        }

        @media (max-width: 768px) {
            .mobile-hidden {
                display: none
            }

            .desktop-hidden {
                display: block;
            }

            .mobile-position {
                width: 100%;
                margin: 0 auto;
                box-shadow: 0 0 10px 1px rgba(71, 85, 95, 0.08);
            }

            .inner-pages .portfolio .homes-content .homes-list-div ul {
                flex-wrap: wrap
            }

            .homes-content .footer {
                display: block;
                background: none;
                border-top: 1px solid #e8e8e8;
                padding-top: 1rem;
                font-size: 13px;
                color: #666;
            }

        }
    </style>
@endsection
