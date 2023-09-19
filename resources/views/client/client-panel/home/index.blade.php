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
                            <p>Merhaba <strong>{{ Auth::user()->email }}</strong>!</p>
                            <p>Hesap panonuzdan son <a href="/hesap/siparislerim"> siparişlerinizi</a> görüntüleyebilir ve <a href="/hesap/kullanici-bilgileri">şifrenizi ve hesap detaylarınızı düzenleyebilirsiniz</a>.</p>
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
