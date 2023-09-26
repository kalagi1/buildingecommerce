@extends('client.layouts.master')

@section('content')
    <div class="brand-head">
        <div class="container">
            <div class="card mb-3">
                <img src="https://genetikonvet.com/wp-content/uploads/revslider/slider-hardware/black-electronics-s-3-bg.jpg"
                    class="card-img-top" alt="...">
                <div class="brands-square">
                    <img src="/images/4.png" alt="" class="brand-logo">
                    <p class="brand-name"><a href="{{ route('instituional.profile', Str::slug($institutional->name)) }}"
                            style="color:White">{{ $institutional->name }}</a></p>

                </div>
                <div class="card-body">
                    <nav class="navbar">
                        <div class="navbar-items">
                            <a class="navbar-item"
                                href="{{ route('instituional.projects.detail', Str::slug($institutional->name)) }}">Tüm
                                Projeler</a>
                            <a class="navbar-item"
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


    <!-- START SECTION POPULAR PLACES -->
    <section class="popular-places home18">
        <div class="container">
            <div class="row">
                @foreach ($institutional->projects as $project)
                    <div class="col-sm-12 col-md-4 col-lg-4" data-aos="zoom-in" data-aos-delay="150">
                        <!-- Image Box -->
                        <a href="{{ route('project.detail', $project->slug) }}" class="img-box hover-effect">
                            <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                class="img-fluid w100" alt="">
                        </a>
                    </div>
                @endforeach


            </div>
        </div>
    </section>
    <!-- END SECTION POPULAR PLACES -->
@endsection

@section('scripts')
@endsection

@section('styles')
@endsection
