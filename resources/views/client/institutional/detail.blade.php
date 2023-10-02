@extends('client.layouts.master')

@section('content')
    <div class="brand-head">
        <div class="container">
            <div class="card mb-3">
                <div class="card-img-top" style="background-color: {{ $institutional->banner_hex_code }}">
                    <div class="brands-square">
                        <img src="{{ url('storage/profile_images/' . $institutional->profile_image) }}" alt=""
                            class="brand-logo">
                        <p class="brand-name"><a href="{{ route('instituional.profile', Str::slug($institutional->name)) }}"
                                style="color:White">{{ $institutional->name }}</a></p>
                        <p class="brand-name"><i class="fa fa-angle-right"></i> </p>
                        <p class="brand-name">Profil</p>
                    </div>
                </div>
                <div class="card-body">
                    <nav class="navbar" style="padding: 0 !important">
                        <div class="navbar-items">
                            <a class="navbar-item"
                                href="{{ route('instituional.dashboard', Str::slug($institutional->name)) }}">Anasayfa</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.projects.detail', Str::slug($institutional->name)) }}">Tüm
                                Projeler</a>
                            <a class="navbar-item active"
                                href="{{ route('instituional.profile', Str::slug($institutional->name)) }}">Satıcı
                                Profili</a>
                        </div>
                        <form class="search-form" action="{{ route('instituional.search') }}" method="GET">
                            @csrf
                            <input class="search-input" type="search" placeholder="Mağazada Ara" aria-label="Search"
                                name="q">
                            <div class="header-search__suggestions">
                                <div class="header-search__suggestions__section">
                                    <h5>Markalar</h5>
                                    <div class="header-search__suggestions__section__items">
                                        @foreach ($institutional->brands as $item)
                                            <a href="#"><span>{{ $item->title }}</span></a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <button class="search-button" type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="portfolio bg-white homepage-5 ">
        <div class="container">
            <div class="seller-profile">
                <div class="seller-info-container">
                    <?php
                    $totalHousingCount = 0;

                    foreach ($institutional->projects as $userProject) {
                        $totalHousingCount += count($userProject->housings);
                    }
                    ?>
                    <div class="seller-info-container__wrapper"><img
                            src="https://cdn.dsmcdn.com/seller-store/resources/activation-date-web-icon.svg" alt="icon"
                            class="seller-info-container__wrapper__img">
                        <div class="seller-info-container__wrapper__text-container"><span
                                class="seller-info-container__wrapper__text-container__title">Katılma Tarihi</span><span
                                class="seller-info-container__wrapper__text-container__value">
                                {{ $institutional->created_at->setTimezone('Europe/Istanbul')->format('d.m.Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="seller-info-container__wrapper"><img
                            src="https://cdn.dsmcdn.com/seller-store/resources/location-web-icon.svg" alt="icon"
                            class="seller-info-container__wrapper__img">
                        <div class="seller-info-container__wrapper__text-container"><span
                                class="seller-info-container__wrapper__text-container__title">Konum</span><span
                                class="seller-info-container__wrapper__text-container__value">
                                {{ $institutional->city->title }}</span></div>
                    </div>
                    <div class="seller-info-container__wrapper"><img
                            src="https://cdn.dsmcdn.com/seller-store/resources/corporate-invoice-web-icon.svg"
                            alt="icon" class="seller-info-container__wrapper__img">
                        <div class="seller-info-container__wrapper__text-container"><span
                                class="seller-info-container__wrapper__text-container__title">Konut Sayısı</span><span
                                class="seller-info-container__wrapper__text-container__value">{{ $totalHousingCount }}
                            </span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
@endsection

@section('styles')
@endsection
