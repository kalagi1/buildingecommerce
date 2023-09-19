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
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('client.password.update') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="current_password">Mevcut Şifreniz</label>
                                <input type="password" name="current_password" id="current_password" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="new_password">Yeni Şifre</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="new_password_confirmation">Yeni Şifre Tekrar</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                    class="form-control" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="ps-btn">Şifreyi Değiştir</button>
                            </div>
                        </form>
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