@extends('client.layouts.master')

@section('content')

<section class="properties-right list featured portfolio blog pt-5 bg-white">
    <div class="container">

        <div class="row project-filter-reverse">
            <aside class="col-lg-3 col-md-12 car">
                <div class="widget">
                    <form class="form">
                    <!-- Search Fields -->
                    <div class="widget-boxed main-search-field">
                        <div class="widget-boxed-header">
                            <h4>Filtrele</h4>
                        </div>
                        <!-- Search Form -->
                        <div class="trip-search">
                                <div class="form-group looking">
                                    <div class="first-select wide">
                                        <div class="main-search-input-item">
                                            <input type="text" name="search" value="{{request('search')}}" placeholder="Ara..." value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <select name="city_id" class="form-control mt-2" id="">
                                        <option value=""><i class="fa fa-home"
                                            aria-hidden="true"></i>Şehir Seç</option>
                                        @foreach($cities as $city)
                                            <option @if(request('city_id') && request('city_id') == $city->id) selected @endif value="{{$city->id}}">{{$city->title}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group categories mb-0">
                                    <select name="housing_type_id" class="form-control mt-2" id="">
                                        <option value=""><i class="fa fa-home"
                                            aria-hidden="true"></i>Konut Tipi</option>
                                        @foreach($housingTypes as $housingType)
                                            <option @if(request('housing_type_id') && request('housing_type_id') == $housingType->id) selected @endif value="{{$housingType->id}}">{{$housingType->title}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group categories mb-0">
                                    <div class="nice-select form-control wide" tabindex="0"><span class="current"><i class="fa fa-home"></i>Konut Durumu</span>
                                        <ul class="list">
                                            @foreach($housingStatus as $housingStatu)
                                                <li data-value="{{$housingStatu->id}}" class="option selected ">{{$housingStatu->name}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                        </div>
                        <div class="col-lg-12 no-pds">
                            <div class="at-col-default-mar">
                                <button class="btn btn-default hvr-bounce-to-right" type="submit">Filtrele</button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </aside>
            <div class="col-lg-9 col-md-12 blog-pots">
                <section class="popular-places home18">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                            </div>
                            @foreach($projects as $project)
                            <div class="col-sm-12 col-md-6 col-lg-6" data-aos="zoom-in" data-aos-delay="150">
                                <!-- Image Box -->
                                <a href="{{route('project.detail',$project->slug)}}" class="img-box hover-effect">
                                    <img src="{{URL::to('/').'/'.str_replace("public/", "storage/", $project->image)}}" class="img-fluid w100" alt="">
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>

            </div>

        </div>

    </div>
</section>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>

</script>
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endsection
