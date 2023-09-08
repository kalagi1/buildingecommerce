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
                            <h4>Find Your House</h4>
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
                </div>
            </aside>
            <div class="col-lg-9 col-md-12 blog-pots">
                <!-- <div class="row project-detalist-list" style="display: flex;justify-content: space-between;">
                    <h3 style="padding: 17px;">Daireler</h3>
                    <div style="display: flex; float: right;">
                        <div class="">
                            <button class="mr-3" style=" height: 42px; box-sizing: border-box; border-radius: 3px; padding:
                        10px; background-color: #ccef69; border: none; border: solid 1px #e8e8e8;">
                                <h6 style="margin: 0; padding: 0;">Proje Detayını Gör</h6>
                            </button>
                        </div>
                        <select>
                            <option selected>Sıralama</option>
                            <option value="Fiyata Göre">Fiyata Göre</option>
                            <option value="Tarihe Göre">Tarihe Göre</option>
                        </select>
                    </div>
                </div> -->
                <!-- <div class="row mt-3 mb-3" style="font-size: 14px;">

                    <div class="col-md-2 col-6" style="align-items: center;">
                        <div style="display: flex; align-items: center;">
                            <i class="fa fa-map" style="color: #2bf327; margin-right: 7px; "></i>
                            <span>Lokasyon</span>
                        </div>
                        <div>
                            <p style="font-weight: 700;">Pendik,İstanbul</p>
                        </div>

                    </div>
                    <div class="col-md-2 col-6" style="align-items: center;">
                        <div style="display: flex; align-items: center;">
                            <i class="fa fa-home" style="color: #2bf327;margin-right: 7px; "></i>
                            <span>Konut Sayısı</span>
                        </div>
                        <div>
                            <p style="font-weight: 700;">42 Konut</p>
                        </div>


                    </div>
                    <div class="col-md-2 col-6" style="align-items: center;">
                        <div style="display: flex; align-items: center;">
                            <i class="fa fa-building" style="color: #2bf327;margin-right: 7px; "></i>
                            <span>Proje Tipi</span>
                        </div>
                        <div>
                            <p style="font-weight: 700;">Daire,Villa</p>
                        </div>


                    </div>
                    <div class="col-md-2 col-6" style="align-items: center;">
                        <div style="display: flex; align-items: center;">
                            <i class="fa fa-calendar-check" style="color: #2bf327;margin-right: 7px; "></i>
                            <span style="white-space: nowrap;">Teslim Tarihi</span>
                        </div>
                        <div>
                            <p style="font-weight: 700;">30 Ağustos</p>
                        </div>


                    </div>
                    <div class="col-md-2 col-6" style="align-items: center;">
                        <div style="display: flex; align-items: center;">
                            <i class="fa fa-chart-pie" style="color: #2bf327;margin-right: 7px; "></i>
                            <span>Kalan Daire</span>
                        </div>
                        <div>
                            <p style="font-weight: 700;">20 Daire</p>
                        </div>


                    </div>
                    <div class="col-md-2 col-6" style="align-items: center; padding-right: 0%;">
                        <div style="display: flex; align-items: center;">
                            <i class="fa fa-credit-card" style="color: #2bf327;margin-right: 7px; "></i>
                            <span style="white-space: nowrap;">Krediye Uygun</span>
                        </div>
                        <div>
                            <p style="font-weight: 700;">Evet</p>
                        </div>


                    </div>



                </div> -->
                <section class="popular-places home18">
                    <div class="container">
                        <!-- <div style="display: flex; justify-content: space-between;">
                            <div class="section-title">
                                <h2>Yeni Projeler</h2>
                            </div>
                            <div>
                                <button>
                                    <h3 >Tümünü Gör</h3>
                                </button>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-md-12">
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6" data-aos="zoom-in" data-aos-delay="150">
                                <!-- Image Box -->
                                <a href="projects.html" class="img-box hover-effect">
                                    <img src="https://cdn.dsmcdn.com/ty866/campaign/banners/original/618435/d52d6e00a5_0.jpg" class="img-fluid w100" alt="">
                                </a>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6" data-aos="zoom-in" data-aos-delay="150">
                                <!-- Image Box -->
                                <a href="projects.html" class="img-box hover-effect">
                                    <img src="https://cdn.dsmcdn.com/ty866/campaign/banners/original/618435/d52d6e00a5_0.jpg" class="img-fluid w100" alt="">
                                </a>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6" data-aos="zoom-in" data-aos-delay="150">
                                <!-- Image Box -->
                                <a href="projects.html" class="img-box hover-effect">
                                    <img src="https://cdn.dsmcdn.com/ty866/campaign/banners/original/618435/d52d6e00a5_0.jpg" class="img-fluid w100" alt="">
                                </a>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6" data-aos="zoom-in" data-aos-delay="150">
                                <!-- Image Box -->
                                <a href="projects.html" class="img-box hover-effect">
                                    <img src="https://cdn.dsmcdn.com/ty866/campaign/banners/original/618435/d52d6e00a5_0.jpg" class="img-fluid w100" alt="">
                                </a>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6" data-aos="zoom-in" data-aos-delay="150">
                                <!-- Image Box -->
                                <a href="projects.html" class="img-box hover-effect">
                                    <img src="https://cdn.dsmcdn.com/ty866/campaign/banners/original/618435/d52d6e00a5_0.jpg" class="img-fluid w100" alt="">
                                </a>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6" data-aos="zoom-in" data-aos-delay="150">
                                <!-- Image Box -->
                                <a href="projects.html" class="img-box hover-effect">
                                    <img src="https://cdn.dsmcdn.com/ty866/campaign/banners/original/618435/d52d6e00a5_0.jpg" class="img-fluid w100" alt="">
                                </a>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6" data-aos="zoom-in" data-aos-delay="150">
                                <!-- Image Box -->
                                <a href="projects.html" class="img-box hover-effect">
                                    <img src="https://cdn.dsmcdn.com/ty866/campaign/banners/original/618435/d52d6e00a5_0.jpg" class="img-fluid w100" alt="">
                                </a>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6" data-aos="zoom-in" data-aos-delay="150">
                                <!-- Image Box -->
                                <a href="projects.html" class="img-box hover-effect">
                                    <img src="https://cdn.dsmcdn.com/ty866/campaign/banners/original/618435/d52d6e00a5_0.jpg" class="img-fluid w100" alt="">
                                </a>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6" data-aos="zoom-in" data-aos-delay="150">
                                <!-- Image Box -->
                                <a href="projects.html" class="img-box hover-effect">
                                    <img src="https://cdn.dsmcdn.com/ty866/campaign/banners/original/618435/d52d6e00a5_0.jpg" class="img-fluid w100" alt="">
                                </a>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6" data-aos="zoom-in" data-aos-delay="150">
                                <!-- Image Box -->
                                <a href="projects.html" class="img-box hover-effect">
                                    <img src="https://cdn.dsmcdn.com/ty866/campaign/banners/original/618435/d52d6e00a5_0.jpg" class="img-fluid w100" alt="">
                                </a>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6" data-aos="zoom-in" data-aos-delay="150">
                                <!-- Image Box -->
                                <a href="projects.html" class="img-box hover-effect">
                                    <img src="https://cdn.dsmcdn.com/ty866/campaign/banners/original/618435/d52d6e00a5_0.jpg" class="img-fluid w100" alt="">
                                </a>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6" data-aos="zoom-in" data-aos-delay="150">
                                <!-- Image Box -->
                                <a href="projects.html" class="img-box hover-effect">
                                    <img src="https://cdn.dsmcdn.com/ty866/campaign/banners/original/618435/d52d6e00a5_0.jpg" class="img-fluid w100" alt="">
                                </a>
                            </div>
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