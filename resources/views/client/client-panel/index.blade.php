@extends('client.layouts.master')

@section('content')
    <section class="ps-section--account">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="ps-section__left">
                        <aside class="ps-widget--account-dashboard">
                            <div class="ps-widget__header"><img src="https://nouthemes.net/html/martfury/img/users/3.jpg" alt="">
                                <figure>
                                    <figcaption>{{Auth::user()->name}}</figcaption>
                                    <p><a href="#">{{Auth::user()->email}}</a></p>
                                </figure>
                            </div>
                            <div class="ps-widget__content">
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
                               <ul style="padding: 10px !important">
                                @foreach ($groupedMenuData as $label => $groupedMenu)
                                    @php
                                        $isActive = false;
                                    @endphp
                                    <li @if ($isActive) class="active" @endif>
                                        <ul>
                                            @foreach ($groupedMenu as $menuItem)
                                                @if ($menuItem['visible'])
                                                    @php
                                                        $isActive = request()->is($menuItem['activePath']);
                                                    @endphp
                                                    <li @if ($isActive) class="active" @endif>
                                                        <a href="{{ route($menuItem['url']) }}"><i class="icon-{{ $menuItem['icon'] }}"></i> {{ $menuItem['text'] }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>


                            </div>
                        </aside>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="ps-section__right">
                        <form class="ps-form--account-setting" action="index.html" method="get">
                            <div class="ps-form__header">
                                <h3> User Information</h3>
                            </div>
                            <div class="ps-form__content">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control" type="text" placeholder="Please enter your name...">
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input class="form-control" type="text"
                                                placeholder="Please enter phone number...">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" type="text"
                                                placeholder="Please enter your email...">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Birthday</label>
                                            <input class="form-control" type="text"
                                                placeholder="Please enter your birthday...">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select class="form-control">
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                                <option value="3">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group submit">
                                <button class="ps-btn text-white">Update</button>
                            </div>
                        </form>
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
