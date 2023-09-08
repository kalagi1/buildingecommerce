@extends('client.layouts.master')

@section('content')
<div class="brand-head" style="margin-top: 20px;">
    <div class="container">

        <div class="card mb-3">
            <img src="{{URL::to('/')}}/storage/brand_images/{{$brand->cover_photo}}" class="card-img-top" style="position: relative;" alt="...">
            <div class="brands-square d-flex" style="position: absolute; top: 30px; left: 30px; align-items: center;">
                <img src="{{URL::to('/')}}/storage/brand_images/{{$brand->logo}}" alt="" style=" width: 50px; height: 50px; border-radius: 30px; border: 3px solid orange !important; padding: 5px; ">
                <p style="margin-left: 10px !important; font-weight: 600; margin: 0; padding: 0;color:#fff">{{$brand->title}}</p>
            </div>
            <div class="card-body" style="padding: 0px; !important">
                <nav class="navbar navbar-light  justify-content-between" style="">
                    <div class="justify-content-left">
                        <a class="navbar-brand">Anasayfa</a>
                        <a class="navbar-brand">Tüm Ürünler</a>
                        <a class="navbar-brand">Satıcı Profili</a>
                    </div>
                    <form class="form-inline" style="flex-wrap: nowrap;">
                        <input class="form-control mr-sm-2" type="search" placeholder="Mağazada Ara" aria-label="Search">
                        <button class="btn " type="submit" style="border-radius: 50px; color: orange; left: -48px;position: relative !important; background: transparent !important;  "><i
                                class="fas fa-search"></i></button>
                    </form>
                </nav>
            </div>
        </div>
        <!-- <nav class="navbar navbar-light bg-light justify-content-between"
            style="border-bottom: 1px solid rgb(196, 196, 196);">
            <div class="justify-content-left">
                <a class="navbar-brand">Anasayfa</a>
                <a class="navbar-brand">Tüm Ürünler</a>
                <a class="navbar-brand">Satıcı Profili</a>
            </div>
            <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" placeholder="Mağazada Ara"
                    aria-label="Search">
                <button class="btn " type="submit"
                    style="border-radius: 50px; color: orange; left: -48px;position: relative !important;"><i
                        class="fas fa-search"></i></button>
            </form>
        </nav> -->
    </div>
</div>

<section class="popular-places home18" style="margin-top: 30px;">
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
            @foreach($brand->projects as $project)
                <div class="col-sm-12 col-md-4 col-lg-4" data-aos="zoom-in" data-aos-delay="150">
                    <!-- Image Box -->
                    <a href="{{route('project.detail',$project->slug)}}" class="img-box hover-effect">
                        <img src="{{URL::to('/').'/'.str_replace("public/", "storage/", $project->image)}}" class="img-fluid w100" alt="">
                    </a>
                </div>
            @endforeach
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