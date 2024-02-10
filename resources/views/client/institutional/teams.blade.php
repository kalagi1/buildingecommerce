@extends('client.layouts.master')

@section('content')
    <div class="brand-head">
        <div class="container">
            <div class="card mb-3">
                <div class="card-img-top" style="background-color: {{ $institutional->banner_hex_code }}">
                    <div class="brands-square">
                        <img src="{{ url('storage/profile_images/' . $institutional->profile_image) }}" alt=""
                            class="brand-logo">
                        <p class="brand-name"><a href="{{ route('instituional.profile',  ["slug" => Str::slug($institutional->name), "userID" => $institutional->id]) }}"
                                style="color:White">{{ $institutional->name }}
                                <style type="text/css">
                                    .st0 {
                                        fill: #e54242;
                                    }

                                    .st1 {
                                        opacity: 0.15;
                                    }

                                    .st2 {
                                        fill: #FFFFFF;
                                    }
                                </style>
                                 @if ($institutional->corporate_account_status )
                                 <svg id="Layer_1" style="enable-background:new 0 0 120 120;" version="1.1"
                                     width="24px" height="24px" viewBox="0 0 120 120" xml:space="preserve"
                                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                     <g>
                                         <path class="st0"
                                             d="M99.5,52.8l-1.9,4.7c-0.6,1.6-0.6,3.3,0,4.9l1.9,4.7c1.1,2.8,0.2,6-2.3,7.8L93,77.8c-1.4,1-2.3,2.5-2.7,4.1   l-0.9,5c-0.6,3-3.1,5.2-6.1,5.3l-5.1,0.2c-1.7,0.1-3.3,0.8-4.5,2l-3.5,3.7c-2.1,2.2-5.4,2.7-8,1.2l-4.4-2.6   c-1.5-0.9-3.2-1.1-4.9-0.7l-5,1.2c-2.9,0.7-6-0.7-7.4-3.4l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8   l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8   l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6c1.4-2.7,4.4-4.1,7.4-3.4l5,1.2c1.6,0.4,3.4,0.2,4.9-0.7l4.4-2.6c2.6-1.5,5.9-1.1,8,1.2   l3.5,3.7c1.2,1.2,2.8,2,4.5,2l5.1,0.2c3,0.1,5.6,2.3,6.1,5.3l0.9,5c0.3,1.7,1.3,3.2,2.7,4.1l4.2,2.9C99.7,46.8,100.7,50,99.5,52.8z   " />
                                         <g class="st1">
                                             <path
                                                 d="M43.4,93.5l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4    c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6    c0.8-1.6,2.2-2.7,3.7-3.2c-2.7-0.4-5.4,1-6.6,3.5l-2.3,4.6c-0.8,1.5-2.1,2.7-3.7,3.2l-4.8,1.6c-2.9,1-4.7,3.8-4.4,6.8l0.5,5.1    c0.2,1.7-0.3,3.4-1.4,4.7l-3.2,4c-1.9,2.4-1.9,5.7,0,8.1l3.2,4c1.1,1.3,1.6,3,1.4,4.7l-0.5,5.1c-0.3,3,1.5,5.8,4.4,6.8l4.8,1.6    c1.6,0.5,2.9,1.7,3.7,3.2l2.3,4.6c1.4,2.7,4.4,4.1,7.4,3.4l0.6-0.1C46.3,96.7,44.4,95.5,43.4,93.5z" />
                                             <path
                                                 d="M60.6,22.5l4.4-2.6c0.4-0.2,0.8-0.4,1.2-0.5c-1.4-0.2-2.9,0.1-4.1,0.8l-4.4,2.6c-0.4,0.2-0.8,0.4-1.2,0.5    C57.9,23.5,59.3,23.3,60.6,22.5z" />
                                             <path
                                                 d="M81,92c-0.5,0-1,0.1-1.4,0.2l3.6-0.2c0.5,0,0.9-0.1,1.4-0.2L81,92z" />
                                             <path
                                                 d="M65,98.9l-4.4-2.6c-1.5-0.9-3.2-1.1-4.9-0.7l-0.6,0.1c0.9,0.1,1.7,0.4,2.5,0.8l4.4,2.6c1.7,1,3.6,1.1,5.4,0.5    C66.6,99.6,65.8,99.4,65,98.9z" />
                                         </g>
                                         <polyline class="st0" points="44,53.6 56.5,67.9 82.1,47.3  " />
                                         <path class="st2"
                                             d="M53.5,75.3c-1.4,0-2.8-0.6-3.8-1.7L37.2,59.3c-1.8-2.1-1.6-5.2,0.4-7.1c2.1-1.8,5.2-1.6,7.1,0.4l9.4,10.7   l21.9-17.6c2.1-1.7,5.3-1.4,7,0.8c1.7,2.2,1.4,5.3-0.8,7L56.6,74.2C55.7,74.9,54.6,75.3,53.5,75.3z" />
                                     </g>
                                 </svg>
                             @endif
                            </a></p>
                        <p class="brand-name"><i class="fa fa-angle-right"></i> </p>
                        <p class="brand-name">Projeler</p>
                    </div>
                </div>
                <div class="card-body">
                    <nav class="navbar" style="padding: 0 !important">
                        <div class="navbar-items">
                            <a class="navbar-item"
                                href="{{ route('instituional.dashboard', ["slug" => Str::slug($institutional->name), "userID" => $institutional->id]) }}">Anasayfa</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.profile',["slug" => Str::slug($institutional->name), "userID" => $institutional->id]) }}">Mağaza
                                Profili</a>
                            <a class="navbar-item "
                                href="{{ route('instituional.projects.detail', ["slug" => Str::slug($institutional->name), "userID" => $institutional->id]) }}">Proje
                                İlanları</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.housings', ["slug" => Str::slug($institutional->name), "userID" => $institutional->id]) }}">Emlak
                                İlanları</a>
                                <a class="navbar-item active"
                                href="{{ route('instituional.teams', ["slug" => Str::slug($institutional->name), "userID" => $institutional->id]) }}">Ekibimiz</a>
                            
                        </div>
                        <form class="search-form" action="{{ route('instituional.search') }}" method="GET">
                            @csrf
                            <input class="search-input" type="search" placeholder="Mağazada Ara" id="search-project"
                                aria-label="Search" name="q">
                            <div class="header-search__suggestions">
                                <div class="header-search__suggestions__section">
                                    <h5>Projeler</h5>
                                    <div class="header-search__suggestions__section__items">
                                        @foreach ($institutional->projects as $item)
                                            <a href="{{ route('project.detail', ['slug' => $item->slug, 'id' => $item->id]) }}"
                                                class="project-item"
                                                data-title="{{ $item->project_title }}"><span>{{ $item->project_title }}</span></a>
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

    <section class="properties-right featured portfolio blog pt-5 bg-white">
        <div class="container">
            <div class="row">
                @foreach ($teams as $item)
                <div class="item col-lg-3 col-md-3 col-xs-12 landscapes sale">
                    <div class="project-single">
                        <div class="project-inner project-head">
                            <div class="homes">
                                <!-- homes img -->
                                <div class="homes-img">
                                    <img src="{{asset('storage/profile_images/'. $item->profile_image)}}" alt="{{$item->name}}"
                                    style="object-fit: contain !important;" class="img-responsive">
                                </div>
                            </div>
                        </div>
                        <!-- homes content -->
                        <div class="homes-content">
                            <!-- homes address -->
                            <div class="the-agents p-2 w-100">
                                <ul class="the-agents-details mt-0 text-center w-100">
                                    <li><a href="#">{{$item->name}}</a></li>
                                    <li><a href="#">{{$item->role->name}}</a></li>
                                    <li><a href="#">Referans Kodu: {{$item->code}}</a></li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
             
            </div>
            </div>
        
    </section>



@endsection

@section('scripts')
@endsection

@section('styles')
@endsection
