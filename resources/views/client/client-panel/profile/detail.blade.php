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
                <div id="orders-container">
                    @if ($cartOrders->count() > 0)
                        @foreach ($cartOrders as $order)
                            @php($o = json_decode($order->cart))
                            @php(
    $project =
        $o->type == 'project'
            ? App\Models\Project::with('roomInfo')->where('id', $o->item->id)->first()
            : null
)


                            <div class="order">
                                <div class="order-header">
                                    <?php
                                    $tarih = date('d F Y', strtotime($order->created_at));
                                    $tarih = str_replace(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'], $tarih);
                                    ?>

                                    <div class="order-header-info" style="flex-direction: column;">
                                        <b style="font-weight:700 !important">Sipariş Detayı </b>

                                    </div>
                                    <div class="order-header-info" style="flex-direction: column;">
                                        <b>Sipariş Tarihi: {{ $tarih }} </b>

                                    </div>
                                    <div class="order-header-info" style="flex-direction: column;">
                                        <b>
                                            Alıcı: {{ Auth::user()->name }}
                                        </b>
                                    </div>

                                    <div class="order-header-info" style="flex-direction: column;">
                                        <b>
                                            Tutar: <span style="color: #EA2B2E;font-weight:700 !important">
                                                {{ number_format(floatval(str_replace('.', '', json_decode($order->cart)->item->price)) * 0.02, 0, ',', '.') }}
                                                ₺</span>
                                        </b>

                                    </div>


                                </div>
                                <div class="order-list d-flex justify-content-between">
                                    <div class="order-item-images d-flex">
                                        <div>
                                            @if ($o->type == 'housing')
                                                <img src="{{ asset('housing_images/' . json_decode(App\Models\Housing::find(json_decode($order->cart)->item->id ?? 0)->housing_type_data ?? '[]')->image ?? null) }}"
                                                    style="object-fit: contain;width:100px;height:75px" alt="Görsel">
                                            @else
                                                <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', json_decode($order->cart)->item->housing)->value }}"
                                                    style="object-fit: cover;width:100px;height:75px" alt="Görsel">
                                            @endif
                                        </div>
                                        <div style="margin-left: 10px">
                                            @if ($o->type == 'housing')
                                                {{ App\Models\Housing::find(json_decode($order->cart)->item->id ?? 0)->title ?? null }}
                                            @else
                                                <strong>
                                                    {{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}{{ ' ' }}Projesinde

                                                    {{ ' ' }}
                                                    {{ json_decode($order->cart)->item->housing }} {{ "No'lu" }}
                                                    {{ $project->step1_slug }}
                                                </strong>
                                            @endif <br>


                                            <span> {!! [
                                                '0' =>
                                                    '<i class="fa fa-exclamation-circle text-warning"></i><span class="text-warning ml-2"> Rezerve Edildi</span>',
                                                '1' => '<i class="fa fa-check-circle text-success"></i><span class="text-success ml-2"> Ödeme Onaylandı</span>',
                                                '2' => '<i class="fa fa-times-circle text-danger"></i><span class="text-danger ml-2"> Ödeme Reddedildi</span>',
                                            ][$order->status] !!}</span>

                                        </div>


                                    </div>
                                    <div>
                                        @if ($order->invoice)
                                            <a href="{{ route('client.invoice.show', $order->id) }}">
                                                <button class="invoiceBtn">
                                                    <span class="button_lg">
                                                        <span class="button_sl"></span>
                                                        <span class="button_text">Faturayı Görüntüle</span>
                                                    </span>
                                                </button>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="payment summary-box ">
                                        <div class="header"><span class="header-text"
                                            style="font-weight: 700 !important;color: #333">Ödeme Bilgileri</span>
                                        </div>
                                        <div class="content">
                                            <div class="price-info"><span class="price-text">İlan Fiyatı</span><span
                                                    class="price-amount">
                                                    {{ number_format(floatval(str_replace('.', '',getHouse($project, 'price[]', json_decode($order->cart)->item->housing)->value)), 0, ',', '.') }}   ₺</span></div>
                                            <div class="price-info"><span class="price-text">Ödenen Kapora Miktarı</span><span
                                                    class="price-amount"><span style="color: #EA2B2E;font-weight:700 !important">
                                                        {{ number_format(floatval(str_replace('.', '', json_decode($order->cart)->item->price)) * 0.02, 0, ',', '.') }}
                                                        ₺</span></div>
                                            {{-- <div class="price-info"><span class="price-text">150 TL ve Üzeri Kargo Bedava
                                                    (Satıcı
                                                    Karşılar)</span><span class="price-amount highlighted">-29,99 TL</span>
                                            </div> --}}
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
    </section>
@endsection

@section('scripts')
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/account.css') }}" />

    <style>
         .summary-box .header {
    display: flex !important;
    width: 100%;
    height: 42px !important;
    border-radius: 6px 6px 0 0;
    border-bottom: solid 1px #e2e2e2;
    background-color: #fafafa;
    align-items: center !important;
    padding: 0 20px;
    box-sizing: border-box;
    justify-content: space-between !important;
}
.summary-box .content {
    margin: 20px;
    display: flex;
    flex-direction: column;
    position: relative;
    color: #333;
}
.payment .content .price-info {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    padding: 1px 0;
    font-size: 12px;
}
        .summary-box {
            width: 100%;
            height: max-content;
            border-radius: 6px;
            border: solid 1px #e2e2e2;
            background-color: #ffffff;
            box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.05);
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
            font-weight: 600;
            font-size: 11px;
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
