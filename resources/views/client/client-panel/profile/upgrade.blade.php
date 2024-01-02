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
                        <div class="content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4 class="mb-4">Premium Paketler</h4>
                                </div>
                                @foreach ($plans as $plan)
                                    <div class="col-lg-4">
                                        <div class="card shadow-sm border-300 border-bottom mb-4">
                                            <div class="card-header">
                                                {{ $plan->name }}
                                            </div>
                                            <div class="card-body p-0">
                                                <div class="py-2 px-3 border-bottom d-flex">
                                                    <b>Emlak Limiti:</b>
                                                    <span style="margin-left: auto;">
                                                        {{ $plan->housing_limit }}
                                                    </span>
                                                </div>
                                                <div class="py-2 px-3 border-bottom d-flex w-100">
                                                    <b>Fiyat:</b>
                                                    <span class="text-primary"
                                                        style="margin-left: auto; font-weight: bold; font-size: 20px;">
                                                        {{ $plan->price }}TL
                                                    </span>
                                                </div>
                                                <div class="py-2 px-3">
                                                    <button type="button" class="btn btn-primary btn-lg btn-block w-100"
                                                        data-toggle="modal" data-target="#paymentModal{{ $plan->id }}"
                                                        @if ($current && $current->subscriptionPlan) {{ $current->subscriptionPlan->id == $plan->id ? 'disabled' : '' }} @endif>
                                                        @if ($current && $current->subscriptionPlan)
                                                            {{ $current->subscriptionPlan->id == $plan->id ? 'AKTİF' : ($current->subscriptionPlan->price <= $plan->price ? 'YÜKSELT' : 'SATIN AL') }}
                                                            @if ($current->subscriptionPlan->price < $plan->price)
                                                                <i class="fas fa-angle-double-up ml-3"></i>
                                                            @endif
                                                        @else
                                                            SATIN AL
                                                        @endif
                                                    </button>


                                                    <!-- Ödeme Modalı -->
                                                    <div class="modal fade" id="paymentModal{{ $plan->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="paymentModalLabel">Ödeme
                                                                        Formu</h5>

                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Ödeme Formu Alanları Buraya Gelecek -->
                                                                    <form method="POST"
                                                                        action="{{ route('client.profile.upgrade.action', [$plan->id]) }}">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-primary">Ödeme
                                                                            Yap</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        </div>
    </section>
@endsection

@section('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/account.css') }}" />
@endsection
