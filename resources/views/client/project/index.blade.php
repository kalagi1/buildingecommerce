@extends('client.layouts.master')

@section('content')
<section class="recently portfolio bg-white homepage-5 ">
    <div class="container recently-slider">

        <div class="portfolio right-slider">
            <div class="owl-carousel home5-right-slider">
                @foreach($project->images as $image)
                <div class="inner-box">
                    <a href="single-property-1.html" class="recent-16" data-aos="fade-up" data-aos-delay="150">
                        <div class="recent-img16 img-fluid img-center" style="background-image: url({{URL::to('/').'/'.str_replace("public/", "storage/", $image->image)}});"></div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>


<section class="featured portfolio rec-pro disc bg-white">
    <div class="container">

        <div class="portfolio  col-xl-12">
            <div class="slick-agents">
                <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                    <div class="landscapes">
                        <div class="project-single">
                            <div class="project-inner project-head">
                                <div class="homes">
                                    <!-- homes img -->
                                    <a href="single-property-1.html" class="homes-img">


                                        <img src="{{URL::to('/')}}/images/blog/b-11.jpg" alt="home-1" class="img-responsive">
                                    </a>
                                </div>
                                <div class="button-effect">

                                </div>
                            </div>
                            <!-- homes content -->

                        </div>
                    </div>
                </div>
                <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                    <div class="landscapes">
                        <div class="project-single">
                            <div class="project-inner project-head">
                                <div class="homes">
                                    <!-- homes img -->
                                    <a href="single-property-1.html" class="homes-img">


                                        <img src="{{URL::to('/')}}/images/blog/b-11.jpg" alt="home-1" class="img-responsive">
                                    </a>
                                </div>
                                <div class="button-effect">

                                </div>
                            </div>
                            <!-- homes content -->

                        </div>
                    </div>
                </div>
                <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                    <div class="landscapes">
                        <div class="project-single">
                            <div class="project-inner project-head">
                                <div class="homes">
                                    <!-- homes img -->
                                    <a href="single-property-1.html" class="homes-img">


                                        <img src="{{URL::to('/')}}/images/blog/b-11.jpg" alt="home-1" class="img-responsive">
                                    </a>
                                </div>
                                <div class="button-effect">

                                </div>
                            </div>
                            <!-- homes content -->

                        </div>
                    </div>
                </div>
                <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                    <div class="landscapes">
                        <div class="project-single">
                            <div class="project-inner project-head">
                                <div class="homes">
                                    <!-- homes img -->
                                    <a href="single-property-1.html" class="homes-img">


                                        <img src="{{URL::to('/')}}/images/blog/b-11.jpg" alt="home-1" class="img-responsive">
                                    </a>
                                </div>
                                <div class="button-effect">

                                </div>
                            </div>
                            <!-- homes content -->

                        </div>
                    </div>
                </div>
                <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                    <div class="landscapes">
                        <div class="project-single">
                            <div class="project-inner project-head">
                                <div class="homes">
                                    <!-- homes img -->
                                    <a href="single-property-1.html" class="homes-img">


                                        <img src="{{URL::to('/')}}/images/blog/b-11.jpg" alt="home-1" class="img-responsive">
                                    </a>
                                </div>
                                <div class="button-effect">

                                </div>
                            </div>
                            <!-- homes content -->

                        </div>
                    </div>
                </div>
                <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                    <div class="landscapes">
                        <div class="project-single">
                            <div class="project-inner project-head">
                                <div class="homes">
                                    <!-- homes img -->
                                    <a href="single-property-1.html" class="homes-img">


                                        <img src="{{URL::to('/')}}/images/blog/b-11.jpg" alt="home-1" class="img-responsive">
                                    </a>
                                </div>
                                <div class="button-effect">

                                </div>
                            </div>
                            <!-- homes content -->

                        </div>
                    </div>
                </div>







            </div>
        </div>
    </div>
</section>
@php 
    function getData($project,$key,$roomOrder){
        foreach ($project->roomInfo as  $room) {
            if($room->room_order == $roomOrder && $room->name == $key){
                return $room;
            }
        }
    }
@endphp
<section class="properties-right list featured portfolio blog pt-5 bg-white">
    <div class="container">

        <div class="row project-filter-reverse">

            <div class="col-lg-12 col-md-12 blog-pots">
                @for($i = 0; $i < $project->room_count; $i++)
                <div class="project-card mb-3">
                    <div class="row">

                        <div class="col-md-4 d-flex" style="height: 100%;">
                            <div class="" style="background-color: #446BB6; border-radius: 0px 8px 0px 8px;">
                                <p style="padding: 10px; color: white; height: 100%; display: flex; align-items: center; ">
                                    {{$i+1}}</p>
                            </div>
                            <div class="project-single mb-0 bb-0 aos-init aos-animate" data-aos="fade-up">
                                <div class="project-inner project-head">
                                    <div class="homes">
                                        <!-- homes img -->
                                        <a href="single-property-1.html" class="homes-img">

                                            <img src="{{URL::to('/')}}/images/blog/b-11.jpg" alt="home-1" class="img-responsive">
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-12 homes-content pb-0 mb-44 aos-init aos-animate" data-aos="fade-up">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="homes-list-div">

                                    <ul class="homes-list clearfix pb-3 d-flex">
                                        <li class="the-icons">
                                            <i class="fas fa-home mr-2" style="color: #446BB6;" aria-hidden="true"></i>
                                            <span>{{$project->housingType->title}}</span>
                                        </li>
                                        <li class="the-icons">
                                            <i class="flaticon-bed mr-2" aria-hidden="true"></i>
                                            <span>{{getData($project,'room_count[]',$i+1)->value}}</span>
                                        </li>
                                        <li class="the-icons">
                                            <i class="flaticon-bathtub mr-2" aria-hidden="true"></i>
                                            <span>{{getData($project,'numberoffloors[]',$i+1)->value}}.Kat</span>
                                        </li>
                                        <li class="the-icons">
                                            <i class="flaticon-square mr-2" aria-hidden="true"></i>
                                            <span>{{getData($project,'squaremeters[]',$i+1)->value}}m2</span>
                                        </li>
                                        <!-- <li class="the-icons">
                                            <i class="flaticon-car mr-2" aria-hidden="true"></i>
                                            <span>2 Garages</span>
                                        </li> -->
                                    </ul>
                                </div>
                                <div class="homes-button">

                                    <button style="padding: 10px; background-color: #ccef69; border: none;">
                                        <h6>Ödeme detaylarını gor</h6>
                                    </button>
                                    <div class="mt-3">
                                        <div class="" style="">
                                            <div style="border :1px solid #2bf327; border-radius: 10px 10px 0 0 ; padding: 2px; text-align:center;width: 172px;;">
                                                <h6 style="color: black;">{{getData($project,'price[]',$i+1)->value}} TL</h6>
                                            </div>

                                        </div>
                                        <div style="background-color: #2bf327; padding: 4px; width: 172px;text-align:center;;  ">
                                            <h6 style="color: black;">%1 Sepete Ekle</h6>

                                        </div>

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
                @endfor



            </div>

        </div>

    </div>
</section>


<section class="ui-element">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 ">
                <div class="listing-title-bar mb-3">
                    <h3>KONUM</h3>
                </div>
                <div class="tabbed-content button-tabs">
                    <ul class="tabs">
                        <li class="active">
                            <div class="tab-title">
                                <span>Ulaşım</span>
                            </div>

                        </li>
                        <li class="">
                            <div class="tab-title">
                                <span>Alışveriş</span>
                            </div>

                        </li>
                        <li class="">
                            <div class="tab-title">
                                <span>Eğitim</span>
                            </div>

                        </li>
                        <li class="">
                            <div class="tab-title">
                                <span>Sağlık</span>
                            </div>

                        </li>
                    </ul>
                    <div id="map" class="contactmap">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3015.3091375028957!2d29.17737287645882!3d40.908967225533395!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14cac554b56486c5%3A0x19df79713477599e!2sMaliyetine%20Ev!5e0!3m2!1str!2str!4v1692189778851!5m2!1str!2str"
                            width="100%" height="300px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <ul class="content mt-3">
                        <li class="active">
                            <div class="tab-content">
                                <div class="slick-lancers">

                                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="location-card">
                                                        <div class="location-card-head">
                                                            <img src="./{{URL::to('/')}}/images/1.png" alt="">
                                                        </div>
                                                        <div class="location-card-body">
                                                            <p>Kartal Merkez</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="location-card">
                                                        <div class="location-card-head">
                                                            <img src="./{{URL::to('/')}}/images/1.png" alt="">
                                                        </div>
                                                        <div class="location-card-body">
                                                            <p>Kartal Merkez</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="location-card">
                                                        <div class="location-card-head">
                                                            <img src="./{{URL::to('/')}}/images/1.png" alt="">
                                                        </div>
                                                        <div class="location-card-body">
                                                            <p>Kartal Merkez</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="location-card">
                                                        <div class="location-card-head">
                                                            <img src="./{{URL::to('/')}}/images/1.png" alt="">
                                                        </div>
                                                        <div class="location-card-body">
                                                            <p>Kartal Merkez</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="location-card">
                                                        <div class="location-card-head">
                                                            <img src="./{{URL::to('/')}}/images/1.png" alt="">
                                                        </div>
                                                        <div class="location-card-body">
                                                            <p>Kartal Merkez</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="location-card">
                                                        <div class="location-card-head">
                                                            <img src="./{{URL::to('/')}}/images/1.png" alt="">
                                                        </div>
                                                        <div class="location-card-body">
                                                            <p>Kartal Merkez</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="location-card">
                                                        <div class="location-card-head">
                                                            <img src="./{{URL::to('/')}}/images/1.png" alt="">
                                                        </div>
                                                        <div class="location-card-body">
                                                            <p>Kartal Merkez</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                            <div class="location-card">
                                                <div class="location-card-head">
                                                    <img src="./{{URL::to('/')}}/images/1.png" alt="">
                                                </div>
                                                <div class="location-card-body">
                                                    <p>Kartal Merkez</p>
                                                </div>
                                            </div>
                                            <div class="project-single">
                                                <div class="project-inner project-head">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                        <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                                            <div class="project-single">
                                                <div class="project-inner project-head">
                                                    <div class="location-card">
                                                        <div class="location-card-head">
                                                            <img src="./{{URL::to('/')}}/images/1.png" alt="">
                                                        </div>
                                                        <div class="location-card-body">
                                                            <p>Kartal Merkez</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
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