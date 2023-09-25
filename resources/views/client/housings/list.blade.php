@extends('client.layouts.master')

@php
                                                function convertMonthToTurkishCharacter($date){
                                                    $aylar = array(
                                                        'January'    =>    'Ocak',
                                                        'February'    =>    'Şubat',
                                                        'March'        =>    'Mart',
                                                        'April'        =>    'Nisan',
                                                        'May'        =>    'Mayıs',
                                                        'June'        =>    'Haziran',
                                                        'July'        =>    'Temmuz',
                                                        'August'    =>    'Ağustos',
                                                        'September'    =>    'Eylül',
                                                        'October'    =>    'Ekim',
                                                        'November'    =>    'Kasım',
                                                        'December'    =>    'Aralık',
                                                        'Monday'    =>    'Pazartesi',
                                                        'Tuesday'    =>    'Salı',
                                                        'Wednesday'    =>    'Çarşamba',
                                                        'Thursday'    =>    'Perşembe',
                                                        'Friday'    =>    'Cuma',
                                                        'Saturday'    =>    'Cumartesi',
                                                        'Sunday'    =>    'Pazar',
                                                        'Jan' => 'Oca',
                                                        'Feb' => 'Şub',
                                                        'Mar' => 'Mar',
                                                        'Apr' => 'Nis',
                                                        'May' => 'May',
                                                        'Jun' => 'Haz',
                                                        'Jul' => 'Tem',
                                                        'Aug' => 'Ağu',
                                                        'Sep' => 'Eyl',
                                                        'Oct' => 'Eki',
                                                        'Nov' => 'Kas',
                                                        'Dec' => 'Ara'

                                                    );
                                                    return  strtr($date, $aylar);
                                                }
                                            @endphp

@section('content')
<div class="brand-head" style="margin-top: 20px;">

    <section class="properties-right list featured portfolio blog  bg-white">
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
                                                <input type="text" placeholder="Enter Keyword..." value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ End Form Lookin for -->
                                    <!-- Form Location -->
                                    <div class="form-group location">
                                        <div class="nice-select form-control wide" tabindex="0"><span class="current"><i class="fa fa-map-marker"></i>Location</span>
                                            <ul class="list">
                                                <li data-value="1" class="option selected ">New York</li>
                                                <li data-value="2" class="option">Los Angeles</li>
                                                <li data-value="3" class="option">Chicago</li>
                                                <li data-value="3" class="option">Philadelphia</li>
                                                <li data-value="3" class="option">San Francisco</li>
                                                <li data-value="3" class="option">Miami</li>
                                                <li data-value="3" class="option">Houston</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--/ End Form Location -->
                                    <!-- Form Categories -->
                                    <div class="form-group categories mb-0">
                                        <div class="nice-select form-control wide" tabindex="0"><span class="current"><i class="fa fa-home"
                                                aria-hidden="true"></i>Property Type</span>
                                            <ul class="list">
                                                <li data-value="1" class="option selected ">House</li>
                                                <li data-value="2" class="option">Apartment</li>
                                                <li data-value="3" class="option">Condo</li>
                                                <li data-value="3" class="option">Land</li>
                                                <li data-value="3" class="option">Bungalow</li>
                                                <li data-value="3" class="option">Single Family</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--/ End Form Categories -->
                                    <!-- Form Property Status -->
                                    <div class="form-group categories mb-0">
                                        <div class="nice-select form-control wide" tabindex="0"><span class="current"><i class="fa fa-home"></i>Property Status</span>
                                            <ul class="list">
                                                <li data-value="1" class="option selected ">For Sale</li>
                                                <li data-value="2" class="option">For Rent</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--/ End Form Property Status -->
                                    <!-- Form Bedrooms -->
                                    <div class="form-group beds">
                                        <div class="nice-select form-control wide" tabindex="0"><span class="current"><i class="fa fa-bed" aria-hidden="true"></i>
                                            Bedrooms</span>
                                            <ul class="list">
                                                <li data-value="1" class="option selected">1</li>
                                                <li data-value="2" class="option">2</li>
                                                <li data-value="3" class="option">3</li>
                                                <li data-value="3" class="option">4</li>
                                                <li data-value="3" class="option">5</li>
                                                <li data-value="3" class="option">6</li>
                                                <li data-value="3" class="option">7</li>
                                                <li data-value="3" class="option">8</li>
                                                <li data-value="3" class="option">9</li>
                                                <li data-value="3" class="option">10</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--/ End Form Bedrooms -->
                                    <!-- Form Bathrooms -->
                                    <div class="form-group bath">
                                        <div class="nice-select form-control wide" tabindex="0"><span class="current"><i class="fa fa-bath" aria-hidden="true"></i>
                                            Bathrooms</span>
                                            <ul class="list">
                                                <li data-value="1" class="option selected">1</li>
                                                <li data-value="2" class="option">2</li>
                                                <li data-value="3" class="option">3</li>
                                                <li data-value="3" class="option">4</li>
                                                <li data-value="3" class="option">5</li>
                                                <li data-value="3" class="option">6</li>
                                                <li data-value="3" class="option">7</li>
                                                <li data-value="3" class="option">8</li>
                                                <li data-value="3" class="option">9</li>
                                                <li data-value="3" class="option">10</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--/ End Form Bathrooms -->
                                </form>
                            </div>
                            <!--/ End Search Form -->
                            <!-- Price Fields -->
                            <div class="main-search-field-2">
                                <!-- Area Range -->
                                <div class="range-slider">
                                    <label>Area Size</label>
                                    <div id="area-range" data-min="0" data-max="1300" data-unit="sq ft"></div>
                                    <div class="clearfix"></div>
                                </div>
                                <br>
                                <!-- Price Range -->
                                <div class="range-slider">
                                    <label>Price Range</label>
                                    <div id="price-range" data-min="0" data-max="600000" data-unit="$"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <!-- More Search Options -->
                            <a href="#" class="more-search-options-trigger margin-bottom-10 margin-top-30" data-open-title="Advanced Features" data-close-title="Advanced Features"></a>

                            <div class="more-search-options relative">
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
                            </div>
                            <!-- More Search Options / End -->
                            <div class="col-lg-12 no-pds">
                                <div class="at-col-default-mar">
                                    <button class="btn btn-default hvr-bounce-to-right" type="submit">Search</button>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="widget-boxed mt-5">
                        <div class="widget-boxed-header">
                            <h4>Recent Properties</h4>
                        </div>
                        <div class="widget-boxed-body">
                            <div class="recent-post">
                                <div class="recent-main">
                                    <div class="recent-img">
                                        <a href="blog-details.html"><img
                                                src="images/feature-properties/fp-1.jpg" alt=""></a>
                                    </div>
                                    <div class="info-img">
                                        <a href="blog-details.html">
                                            <h6>Family Modern Home</h6>
                                        </a>
                                        <p>$230,000</p>
                                    </div>
                                </div>
                                <div class="recent-main my-4">
                                    <div class="recent-img">
                                        <a href="blog-details.html"><img
                                                src="images/feature-properties/fp-2.jpg" alt=""></a>
                                    </div>
                                    <div class="info-img">
                                        <a href="blog-details.html">
                                            <h6>Luxury Villa House</h6>
                                        </a>
                                        <p>$120,000</p>
                                    </div>
                                </div>
                                <div class="recent-main">
                                    <div class="recent-img">
                                        <a href="blog-details.html"><img
                                                src="images/feature-properties/fp-3.jpg" alt=""></a>
                                    </div>
                                    <div class="info-img">
                                        <a href="blog-details.html">
                                            <h6>Luxury Family Home</h6>
                                        </a>
                                        <p>$150,000</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    </div>
                </aside>
                <div class="col-lg-9 col-md-12 blog-pots">
                    <div class="row project-detalist-list" style="display: flex;justify-content: space-between;">
                        <h3 style="padding: 17px;">Daireler</h3>
                        <div style="display: flex; float: right; padding-right: 17px;">
                            <select>
                                <option selected>Sıralama</option>
                                <option value="Fiyata Göre">Fiyata Göre</option>
                                <option value="Tarihe Göre">Tarihe Göre</option>
                            </select>
                        </div>
                    </div>
                    @php
                    function getData($housing,$key){
                            $housing_type_data= json_decode($housing->housing_type_data);
                            $a = $housing_type_data->$key;
                            return $a[0];
                        }

                    function getImage($housing,$key){
                            $housing_type_data= json_decode($housing->housing_type_data);
                            $a = $housing_type_data->$key;
                            return $a;
                        }
                    @endphp
                    <div class="slick-agentsx row">
                        @foreach($housings as $housing)
                        <div class="agents-grid col-md-6" data-aos="fade-up" data-aos-delay="150">
                            <div class="landscapes">
                                <div class="project-single">
                                    <div class="project-inner project-head">
                                        <div class="homes">
                                            <!-- homes img -->
                                            <a href="{{route('housing.show',$housing->id)}}" class="homes-img">
                                                <div class="homes-tag button alt featured" style="background-color: rgba(255, 166, 0, 0.89) !important;">Öne Çıkan
                                                </div>
                                                <div class="homes-tag button alt sale" style="background-color: rgba(255, 1, 1, 0.849) !important;">Yeni
                                                </div>

                                                <img src="{{ asset('housing_images/' . getImage($housing,'image')) }}" style="height:190px;" alt="home-1" class="img-responsive">
                                            </a>
                                        </div>
                                        <div class="button-effect">

                                        </div>
                                    </div>
                                    <!-- homes content -->
                                    <div class="homes-content p-3" style="padding:20px !important">
                                        <!-- homes address -->
                                        <h3><a href="{{route('housing.show',$housing->id)}}">{{$housing->title}}</a></h3>
                                        <p class="homes-address mb-3">
                                            <a href="{{route('housing.show',$housing->id)}}">
                                                <i class="fa fa-map-marker"></i><span>{{$housing->address}}</span>
                                            </a>
                                        </p>
                                        <!-- homes List -->
                                        <ul class="homes-list clearfix pb-0" style="display: flex;justify-content:space-between">
                                            <li class="sude-the-icons" style="width:auto !important">
                                                <i class="flaticon-bed mr-2"  aria-hidden="true"></i>
                                                <span>{{$housing->housing_type->title}}</span>
                                            </li>
                                            <li class="sude-the-icons" style="width:auto !important">
                                                <i class="flaticon-bathtub mr-2" aria-hidden="true"></i>
                                                <span>{{getData($housing,'room_count')}}</span>
                                            </li>
                                            <li class="sude-the-icons" style="width:auto !important">
                                                <i class="flaticon-square mr-2" aria-hidden="true"></i>
                                                <span>{{getData($housing,'squaremeters')}} m2</span>
                                            </li>
                                        </ul>
                                        <ul class="homes-list clearfix pb-0" style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                            <li style="font-size: large; font-weight: 700;">{{getData($housing,'price')}}TL</li>

                                            <li style="display: flex; justify-content: center;">{{date('j', strtotime($housing->created_at)).' '.convertMonthToTurkishCharacter(date('F', strtotime($housing->created_at)))}}</li>
                                        </ul>
                                        <ul class="homes-list clearfix pb-0" style="display: flex; justify-content: center;margin-top:20px !important;">
                                            <button style="width: 100%; border: none; background-color: #446BB6; border-radius: 10px; padding: 5px 0px; color: white;">Sepete
                                                Ekle</button>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach







                    </div>

                </div>
            </div>
        </div>

    </section>

</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endsection
