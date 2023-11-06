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
                                        <div class="order-header-info">Sipariş Tarihi<b>
                                                {{ date('Y-m-d', strtotime($order->created_at)) }}</b></div>
                                        <div class="order-header-info">Sipariş Bilgisi<b
                                                title=" @if ($o->type == 'project') {{ $project->project_title ?? '?' }}
                                        @else
                                            - @endif">
                                                @if ($o->type == 'project')
                                                    {{ $project->project_title ?? '?' }}
                                                @else
                                                    -
                                                @endif
                                            </b>
                                        </div>
                                        <div class="order-header-info">Tutar<b class="text--red">
                                                {{ number_format(floatval(str_replace('.', '', json_decode($order->cart)->item->price)) * 0.01, 2, ',', '.') }}
                                                ₺</b></div>
                                    </div>
                                    <div class="order-list">
                                        <div class="order-item">
                                            <div class="order-item-status">
                                                <span
                                                    style="color: 
                                                    @if ($order->status == 0) orange
                                                    @elseif ($order->status == 1)
                                                        green
                                                    @elseif ($order->status == 2)
                                                        red @endif
                                                ">
                                                    <strong>
                                                        {{ ['Ödeme Bekleniyor', 'Başarılı', 'Ödeme Reddedildi'][$order->status] }}
                                                    </strong>
                                                </span>
                                            </div>

                                            <div class="order-item-images">
                                                @if ($o->type == 'housing')
                                                    <img src="{{ asset('housing_images/' . json_decode(App\Models\Housing::find(json_decode($order->cart)->item->id ?? 0)->housing_type_data ?? '[]')->image ?? null) }}"
                                                        style="object-fit: contain;width:100px" alt="Görsel">
                                                @else
                                                    <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', json_decode($order->cart)->item->housing)->value }}"
                                                        style="object-fit: cover;width:100px;height:100px" alt="Görsel">
                                                @endif
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
    </style>
@endsection
