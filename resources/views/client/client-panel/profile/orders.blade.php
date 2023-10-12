@extends('client.layouts.master')

@section('content')
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
                                                <li
                                                style="border:none !important">
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
                    <div class="ps-page__content">
                        <div class="ps-page__dashboard">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Sipariş No.</th>
                                        <th>Tutar</th>
                                        <th>Tarih</th>
                                        <th>Durum</th>
                                        <th>Sipariş</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($cartOrders->count() > 0)
                                    @foreach ($cartOrders as $order)
                                        <tr>
                                            <td>{{$order->id}}</td>
                                            <td>{{$order->amount}}</td>
                                            <td>{{$order->created_at}}</td>
                                            <td>{{['0' => 'Başarısız', '1' => 'Başarılı'][$order->status]}}</td>
                                            <td>
                                                {{ json_decode($order->cart)->item->title }}<br/>
                                                {{ json_decode($order->cart)->item->address }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" class="text-center">Sipariş Bulunamadı</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
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
@endsection
