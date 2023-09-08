@extends('client.layouts.master')

@section('content')

<section class="properties-right list featured portfolio blog pt-5 bg-white">
    <div class="container">

        <div class="row project-filter-reverse">
            <aside class="col-lg-3 col-md-12 car">
                <div class="widget">
                    <!-- Search Fields -->
                    <div class="widget-boxed main-search-field">
                        <div class="widget-boxed-header">
                            <h4>Filtrele</h4>
                        </div>
                        <!-- Search Form -->
                        <div class="trip-search">
                            <form class="form">
                                <!-- Form Lookin for -->
                                <div class="form-group looking">
                                    <div class="first-select wide">
                                        <div class="main-search-input-item">
                                            <input type="text" name="search" value="{{request('search')}}" placeholder="Ara..." value="" />
                                        </div>
                                    </div>
                                </div>
                                <!--/ End Form Lookin for -->
                                <!-- Form Location -->
                                <div class="form-group ">
                                    <select name="city_id" class="form-control mt-2" id="">
                                        <option value=""><i class="fa fa-home"
                                            aria-hidden="true"></i>Şehir Seç</option>
                                        @foreach($cities as $city)
                                            <option @if(request('city_id') && request('city_id') == $city->id) selected @endif value="{{$city->id}}">{{$city->title}}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                                <!--/ End Form Location -->
                                <!-- Form Categories -->
                                <div class="form-group categories mb-0">
                                    <select name="housing_type_id" class="form-control mt-2" id="">
                                        <option value=""><i class="fa fa-home"
                                            aria-hidden="true"></i>Konut Tipi</option>
                                        @foreach($housingTypes as $housingType)
                                            <option @if(request('housing_type_id') && request('housing_type_id') == $housingType->id) selected @endif value="{{$housingType->id}}">{{$housingType->title}}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                                <!--/ End Form Categories -->
                                <!-- Form Property Status -->
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
                        <!--/ End Search Form -->
                        <!-- Price Fields -->
                        <div class="main-search-field-2">
                            <!-- Area Range -->
                            <div class="range-slider">
                                <label>Metrekare</label>
                                <div id="area-range" data-min="0" data-max="1300" data-unit="m2"></div>
                                <div class="clearfix"></div>
                                <input type="hidden" name="area" id="area-input" value="0">
                            </div>
                            <br>
                            <!-- Price Range -->
                            <div class="range-slider">
                                <label>Fiyat</label>
                                <div id="price-range" data-min="0" data-max="600000" data-unit="₺"></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        {{-- <div class="more-search-options relative">
                            <!-- Checkboxes -->
                            <div class="checkboxes one-in-row margin-bottom-10">
                                <input id="check-2" type="checkbox" name="check">
                                <label for="check-2">Air Conditioning</label>
                                <input id="check-3" type="checkbox" name="check">
                                <label for="check-3">Swimming Pool</label>
                                <input id="check-4" type="checkbox" name="check">
                                <label for="check-4">Central Heating</label>
                                <input id="check-5" type="checkbox" name="check">
                                <label for="check-5">Laundry Room</label>
                                <input id="check-6" type="checkbox" name="check">
                                <label for="check-6">Gym</label>
                                <input id="check-7" type="checkbox" name="check">
                                <label for="check-7">Alarm</label>
                                <input id="check-8" type="checkbox" name="check">
                                <label for="check-8">Window Covering</label>
                                <input id="check-9" type="checkbox" name="check">
                                <label for="check-9">WiFi</label>
                                <input id="check-10" type="checkbox" name="check">
                                <label for="check-10">TV Cable</label>
                                <input id="check-11" type="checkbox" name="check">
                                <label for="check-11">Dryer</label>
                                <input id="check-12" type="checkbox" name="check">
                                <label for="check-12">Microwave</label>
                                <input id="check-13" type="checkbox" name="check">
                                <label for="check-13">Washer</label>
                                <input id="check-14" type="checkbox" name="check">
                                <label for="check-14">Refrigerator</label>
                                <input id="check-15" type="checkbox" name="check">
                                <label for="check-15">Outdoor Shower</label>
                            </div>
                            <!-- Checkboxes / End -->
                        </div> --}}
                        <!-- More Search Options / End -->
                        <div class="col-lg-12 no-pds">
                            <div class="at-col-default-mar">
                                <button class="btn btn-default hvr-bounce-to-right" type="submit">Search</button>
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