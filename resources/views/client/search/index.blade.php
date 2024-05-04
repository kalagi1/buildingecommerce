@extends('client.layouts.master')

@section('content')
    <section class="recently portfolio bg-white homepage-5 ">
        <div class="container">
            <div class="header-search-box-page">
                <div class="row">
                    <!-- plan start -->
                    <div class="col-lg-3 col-md-6 col-xs-12">
                        <div class="plan text-center">
                            <span class="plan-name">Emlak</span>
                            <p class="plan-price"><small>{{ $housingTotalCount }} İlan bulundu</small><sub></sub></p>
                            <ul class="list-unstyled">
                                @foreach ($housings as $step1_slug => $step1_data)
                                    @foreach ($step1_data as $step2_slug => $step2_data)
                                       <a href="{{ url('/kategori/' . $step1_slug . '/' . $step2_slug) }}"><li>{{ $step2_slug }}
                                            {{ $step1_slug }}<span>({{ $step2_data[0]['count'] }})</span></li></a>
                                    @endforeach
                                @endforeach
                            </ul>
                          
                            <a class="btn btn-primary" href="#.">Daha Fazlasını Gör</a>
                        
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-xs-12">
                        <div class="plan text-center">
                            <span class="plan-name">Proje</span>
                            <p class="plan-price"><sup class="currency"></sup><small>{{ $projectTotalCount }} proje
                                    bulundu</small><sub></sub></p>
                            <ul class="list-unstyled">
                                @foreach ($projects as $project)
                                <a href="{{ url('/kategori/' . $project['status_slug']) }}"> 
                                    <li>{{ $project['name'] }}<span>({{ $project['count'] }})</span></li> 
                                </a>
                            @endforeach

                            </ul>
                         
                                <a class="btn btn-primary" href="#.">Daha Fazlasını Gör</a>
                            
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-xs-12">
                        <div class="plan text-center">
                            <span class="plan-name">Mağaza</span>
                            <p class="plan-price">
                                <sup class="currency"></sup><small>{{ $merchant_count }} Mağaza bulundu</small><sub></sub>
                            </p>
                            <ul class="list-unstyled">
                                @foreach ($merchants->take(6) as $merchant)
                                <a href="{{url('/magaza/' .  strtolower(str_replace(' ', '-', $merchant->name)) . "/" .$merchant['id'] )}}"><li>{{ $merchant['name'] }}<span></span></li></a>
                                    
                                @endforeach
                            </ul>
                           
                            <a class="btn btn-primary" href="#.">Daha Fazlasını Gör</a>
                          
                        </div>
                    </div>
                    <!-- plan end -->
                </div>
            </div>
        </div>
    </section>
@endsection
