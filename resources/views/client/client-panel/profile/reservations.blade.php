@extends('client.layouts.master')

@section('content')
    @php

        function getHouse($project, $key, $roomOrder)
        {
            foreach ($project->roomInfo as $room) {
                if ($room->room_order == $roomOrder && $room->name == $key) {
                    return $room;
                }
            }
        }

    @endphp
    <section class="ps-section--account">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="ps-section__left">
                        <aside class="ps-widget--account-dashboard">
                            <div class="ps-widget__header">
                                <figure>
                                    <figcaption>{{ Auth::user()->name }}</figcaption>
                                    <p><a href="#">{{ Auth::user()->email }}</a></p>
                                </figure>
                            </div>
                            @php
                                $groupedMenuData = [];

                                foreach ($menuData as $menuItem) {
                                    $label = $menuItem['label'];

                                    // Gruplandırılmış menüyü oluştur
                                    if (!isset($groupedMenuData[$label])) {
                                        $groupedMenuData[$label] = [];
                                    }

                                    // Menü öğesini ilgili gruba ekle
                                    $groupedMenuData[$label][] = $menuItem;
                                }
                            @endphp
                            @foreach ($groupedMenuData as $label => $groupedMenu)
                                <div class="ps-widget__content mt-3">

                                    <ul style="padding: 10px !important">

                                        @php
                                            $isActive = false;
                                        @endphp
                                        {{-- <p class="navbar-vertical-label">{{ $label }}</p> --}}

                                        <li @if ($isActive) class="active" @endif>
                                            <ul style="border:none !important">
                                                @foreach ($groupedMenu as $menuItem)
                                                    @if ($menuItem['visible'])
                                                        @php
                                                            $isActive = request()->is($menuItem['activePath']);
                                                        @endphp
                                                        <li @if ($isActive) class="active" @endif
                                                            style="border:none !important">
                                                            <a href="{{ route($menuItem['url']) }}"><i
                                                                    class="fa fa-{{ $menuItem['icon'] }} pl-3"></i>
                                                                {{ $menuItem['text'] }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                                <li style="border:none !important">
                                                    <a href="{{ route('client.logout') }}"><i
                                                            class="fa fa-sign-out pl-3"></i>
                                                        Çıkış Yap</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                            @endforeach
                    </div>
                    </aside>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="my-properties">

                    <div id="orders-container">
                        @if ($housingReservations->count() > 0)
                            @foreach ($housingReservations as $order)
                                <div class="order">
                                    <div class="order-header">
                                        <?php
                                        $tarih = date('d F Y', strtotime($order->created_at));
                                        $tarih = str_replace(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'], $tarih);
                                        ?>

                                        <div class="order-header-info" style="flex-direction: column;">
                                            <b>Sipariş Tarihi: {{ $tarih }}</b>
                                            <b>Sipariş Durumu:   {!! [
                                                '0' => '<span class="text-warning">Onay Bekleniyor</span>',
                                                '1' => '<span class="text-success">Ödeme Onaylandı</span>',
                                                '2' => '<span class="text-danger">Ödeme Reddedildi</span>',
                                            ][$order->status] !!}</b>
                                            <span>
                                                Fiyat:
                                                <b class="text-red">
                                                    {{ number_format($order->total_price, 0, ',', '.') }}
                                                    ₺
                                                </b>
                                            </span>
                                          
                                        </div>

                                    </div>
                                    <div class="order-list">
                                        <div class="order-item">

                                            <div class="order-item-images">
                                                <img src="{{ asset('housing_images/' . json_decode(App\Models\Housing::find($order->housing_id ?? 0)->housing_type_data ?? '[]')->image ?? null) }}"
                                                        style="object-fit: contain;width:100px" alt="Görsel">
                                            </div>
                                            <div class="order-item-status">
                                                <table >
                                                    <thead>
                                                     <tr>
                                                        <th>Giriş Tarihi</th>
                                                        <th>Çıkış Tarihi</th>
                                                        <th>Toplam Konaklama</th>
                                                        <th>Kişi Sayısı</th>
                                                     </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="order_date">
                                                                {{ \Carbon\Carbon::parse($order->check_in_date)->format('d.m.Y') }}</td>
                                                            <td class="order_date">
                                                                {{ \Carbon\Carbon::parse($order->check_out_date)->format('d.m.Y') }}</td>
                                                            <td class="order_date">
                                                                <span style="color:#EA2B2E; font-weight:600;font-size:16px"><i class="fas fa-calendar"></i>
                                                                    {{ \Carbon\Carbon::parse($order->check_in_date)->diffInDays(\Carbon\Carbon::parse($order->check_out_date)) }}
                                                                    gün</span>
                                                            </td>
                                                            <td class="order_date">{{ $order->person_count }}</td>
                                                        </tr>
                                                    </tbody>
                                                

                                                </table>
                                               

                                              
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <span class="text-center">Sipariş Bulunamadı</span>
                        @endif
                    </div>


                </div>
            </div>

        </div>
        </div>
    </section>
@endsection

@section('scripts')
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/account.css') }}" />

    <style>
        
table {
  border-spacing: 0;
  overflow: hidden;
  inline-size: 100%;
  text-align: left;
  background-color: inherit;
  border: 1px solid lightgray;
  border-radius: 0.5rem;
  box-shadow: 0px 4px 6px -2px rgba(14, 30, 37, 0.12);
}
.my-properties table thead tr th{
    background-color: #fafafa !important;
    border-bottom: solid 1px #e2e2e2 !important;
}

:is(th, td) {
  padding: 1rem !important;
  font-weight: 500 !important;
  font-size: 14px !important;
  min-inline-size: 10rem;
  border-block-end: 1px solid lightgray;
}

tfoot :is(th, td) {
  border-block-end: unset;
}

tfoot tr {
  background-color: whitesmoke;
}

:is(th, td):not(:first-child) {
  border-inline-start: 1px solid lightgray;
}

.visually-hidden {
  clip: rect(0 0 0 0);
  clip-path: inset(50%);
  height: 1px;
  overflow: hidden;
  position: absolute;
  white-space: nowrap;
  width: 1px;
}
.my-properties table{
    text-align: center
}

        @media(max-width: 768px) {
            .mobile-shadow {
                background: white;
                box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.103)
            }

            .my-properties table tr {
                margin-bottom: 20px;
            }

            .ps-section--account {
                padding: 60px 0;
            }

            .my-properties table tr td {
                padding: 10px !important;
            }

            .my-properties {
                background: transparent;
                padding: 0 !important;
                margin-top: 20px;
                box-shadow: none !important;
            }
        }

        .invoiceBtn {
            width: 150px !important;
            -moz-appearance: none;
            -webkit-appearance: none;
            appearance: none;
            border: none;
            background: none;
            color: #0f1923;
            cursor: pointer;
            position: relative;
            padding: 8px;
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 14px;
            transition: all .15s ease;
        }

        .invoiceBtn::before,
        .invoiceBtn::after {
            content: '';
            display: block;
            position: absolute;
            right: 0;
            left: 0;
            height: calc(50% - 5px);
            border: 1px solid #7D8082;
            transition: all .15s ease;
        }

        .invoiceBtn::before {
            top: 0;
            border-bottom-width: 0;
        }

        .invoiceBtn::after {
            bottom: 0;
            border-top-width: 0;
        }

        .invoiceBtn:active,
        .invoiceBtn:focus {
            outline: none;
        }

        .invoiceBtn:active::before,
        .invoiceBtn:active::after {
            right: 3px;
            left: 3px;
        }

        .invoiceBtn:active::before {
            top: 3px;
        }

        .invoiceBtn:active::after {
            bottom: 3px;
        }

        .invoiceBtn_lg {
            position: relative;
            display: block;
            padding: 10px 20px;
            color: #fff;
            background-color: #0f1923;
            overflow: hidden;
            box-shadow: inset 0px 0px 0px 1px transparent;
        }

        .invoiceBtn_lg::before {
            content: '';
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: 2px;
            height: 2px;
            background-color: #0f1923;
        }

        .invoiceBtn_lg::after {
            content: '';
            display: block;
            position: absolute;
            right: 0;
            bottom: 0;
            width: 4px;
            height: 4px;
            background-color: #0f1923;
            transition: all .2s ease;
        }

        .invoiceBtn_sl {
            display: block;
            position: absolute;
            top: 0;
            bottom: -1px;
            left: -8px;
            width: 0;
            background-image: linear-gradient(to bottom right, #00c6ff,
                    #0072ff);
            transform: skew(-15deg);
            transition: all .2s ease;
        }

        .invoiceBtn_text {
            position: relative;
        }

        .invoiceBtn:hover {
            color: #0f1923;
        }

        .invoiceBtn:hover .invoiceBtn_sl {
            width: calc(100% + 15px);
        }

        .invoiceBtn:hover .invoiceBtn_lg::after {
            background-color: #fff;
        }
    </style>
@endsection
