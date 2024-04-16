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
                            <div class="alert alert-danger text-white">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success text-white">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('client.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">İsim</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $user->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Telefon</label>
                                <input type="number" class="form-control" id="phone" name="phone"
                                    value="{{ $user->phone }}" required>
                                    <span id="error_message" class="error-message"></span>
                            </div>

                            <div class="mb-3">
                                <label for="birthday" class="form-label">Doğum Tarihi</label>
                                <input type="date" class="form-control" id="birthday" name="birthday"
                                    value="{{ $user->birthday }}" required>
                            </div>

                            <button type="submit" class="ps-btn">Kaydet</button>
                        </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
      $("#phone").blur(function(){
        var phoneNumber = $(this).val();
        var pattern = /^5[1-9]\d{8}$/;
    
        if (!pattern.test(phoneNumber)) {
          $("#error_message").text("Lütfen telefon numarasını belirtilen formatta girin. Örneğin: (555) 111 22 33");
        } else {
          $("#error_message").text("");
        }
      });
    });
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/account.css') }}" />
    <style>
                .error-message {
            color: red;
            font-size: 11px;
        }
    </style>
@endsection
