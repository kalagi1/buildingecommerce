@extends('client.layouts.master')

@section('content')
    <section class="ps-section--account">
        <div class="container">
            <div class="content">
                <h2 class="mb-2 lh-sm  @if(isset($tempDataFull->step_order) && $tempDataFull->step_order != 1) d-none @endif">Adım Adım Kategori Seç</h2>
                <div class="breadcrumb  @if(isset($tempDataFull->step_order) && $tempDataFull->step_order != 1) d-none @endif">
                    <span>Emlak</span>
                </div>
                <div class="mt-4">
                    <div class="progress-area">
                        <div class="progress-line step{{$tempDataFull->step_order}}">
                            <ol>
                                <li @if(isset($tempDataFull) && $tempDataFull->step_order == 1) class="current" @elseif($tempDataFull->step_order > 1) class="done" @endif >
                                    <a href="" class="step-counter"><i class="fa fa-star"></i> <span>1</span></a>
                                    <a href="">Kategori Seçimi</a>
                                </li>
                                <li @if(isset($tempDataFull) && $tempDataFull->step_order == 2) class="current" @elseif($tempDataFull->step_order > 2) class="done" @endif>
                                    <a href="" class="step-counter"><i class="fa fa-star"></i> <span>2</span></a>
                                    <a href="">İlan Detayları</a>
                                </li>
                                <li @if(isset($tempDataFull) && $tempDataFull->step_order == 3) class="current" @elseif($tempDataFull->step_order > 3) class="done" @endif>
                                    <a href="" class="step-counter"><i class="fa fa-star"></i> <span>3</span></a>
                                    <a href="">Doping</a>
                                </li>
                                <li @if(isset($tempDataFull) && $tempDataFull->step_order == 4) class="current" @endif>
                                    <a href="" class="step-counter"><i class="fa fa-star"></i> <span>4</span></a>
                                    <a href="">Tebrikler</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="clear-both"></div>
                    <div class="firt-area @if(isset($tempDataFull->step_order) && $tempDataFull->step_order != 1) d-none @endif">
                        <div class="row">
                            <div class="area-lists">
                                <div class="area-list active">
                                    <ul>
                                        @foreach($housingTypeParent as $parent)
                                        <li @if(isset($tempData->step1_slug) && $tempData->step1_slug == $parent->slug) class="selected" @endif slug="{{$parent->slug}}">{{$parent->title}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="area-list ">
                                    <ul>
                                        <li slug="satilik">Satılık</li>
                                        <li slug="kiralik">Kiralık</li>
                                    </ul>
                                </div>
                                <div class="area-list ">
                                    <ul>
                                        <li slug="daire">Daire</li>
                                        <li slug="villa">Villa</li>
                                    </ul>
                                </div>
                                <div class="area-list ">
                                    <div class="finish-category-select">
                                        <div class="finish-icon-area">
                                            <i class="fa fa-check"></i>
                                        </div>
                                        <div class="finish-text">
                                            <p>Kategori Seçimi Tamanlanmıştır</p>
                                        </div>
                                        <div class="finish-button-first">
                                            <button class="btn btn-info">
                                                Devam
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="second-area @if($tempDataFull->step_order != 2) d-none @endif">
                        <div class="row">
                            <div class="thumbnail-second">
                                <span class="section-title">Kategori</span>
                                <div class="card px-5 py-2 breadcrumb breadcrumb-v2" style="display: flex;flex-direction:row;">
                                    <div class="icon"><i class="fa fa-home"></i></div> Emlak
                                </div>
                            </div>
                            <div class="form-area mt-4">
                                <span class="section-title">İlan Detayları</span>
                                
                                <div class="card py-2 px-5">
                                    <div class="form-group">
                                        <label for="">İlan Başlığı <span class="required">*</span></label>
                                        <input type="text" value="{{isset($tempData->name) ? $tempData->name : ''}}" onchange="changeData(this.value,'name')" name="name" class="form-control">
                                    </div>
                                    <div class="form-group description-field">
                                        <label for="">İlan Açıklaması <span class="required">*</span></label>
                                        <textarea name="description" id="editor" cols="30" rows="5" onkeyup="changeData(this.value,'description')" class="form-control">{{isset($tempData->description) ? $tempData->description : ''}}</textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="tab-content " id="pricingTabContent" role="tabpanel">
                                                <div id="renderForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="address">
                                    <span class="section-title">Adres Bilgileri</span>
                                    <div class="card">
                                        <div class="row px-5 py-4">
                                            <div class="col-md-4">
                                                <label for="">İl <span class="required">*</span></label>
                                                <select onchange="changeData(this.value,'city_id')" name="city_id" id="cities" class="form-control">
                                                    <option value="">İl Seç</option>
                                                    @foreach($cities as $city)
                                                      <option {{isset($tempData->city_id) && $tempData->city_id == $city->id ? "selected" : ''}} value="{{$city->id}}">{{$city->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">İlçe <span class="required">*</span></label>
                                                <select onchange="changeData(this.value,'county_id')" name="county_id" id="counties" class="form-control">
                                                    <option  value="">İlçe Seç</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">Mahalle <span class="required">*</span></label>
                                                <select onchange="changeData(this.value,'neighbourhood_id')" name="neighbourhood_id" id="neighbourhood" class="form-control">
                                                    <option value="">Mahalle Seç</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div>
                                            <input name="location" class="form-control" id="location" readonly type="hidden"
                                                        value="@if(isset($tempData->location)){{$tempData->location}}@else 39.1667,35.6667 @endif" />
                                            <div id="mapContainer"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="address mt-4">
                                    <span class="section-title">Konut Statü Bilgileri</span>
                                    <div class="card">
                                        <div class="row px-5 py-4">
                                            <div class="col-md-12 statue-text">
                                                <label for="">Proje Konutlarının Statüsü Nedir? <span class="required">*</span></label>
                                                <select multiple name="housing_status" id="housing_status" aria-label="category">
                                                    <option value="" selected="">Tİp Seç:</option>
                                                    @foreach ($housing_status as $status)
                                                        <option @if(isset($tempData->statuses) && in_array($status->id,$tempData->statuses)) selected @endif value="{{ $status->id }}">{{ $status->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class="section-title mt-4">Vekalet Belgesi</span>
                                <div class="cover-photo-full card py-2 px-5">
                                    <input type="file" name="cover-image" class="document d-none">
                                    <div class="cover-document-area">
                                        <div class="icon">
                                            <i class="fa fa-file"></i>
                                        </div>
                                        <label for="">Bilgisayardan Dosya Ekle</label>
                                    </div>
                                    <div class="cover-document">
                                        @if(isset($tempData->document) && $tempData->document)
                                            <div class="has_file">
                                                <span class="d-block">Dosya Eklediniz</span>
                                                <a class="btn btn-info" href="{{URL::to('/')}}/housing_documents/{{$tempData->document}}" download="">Mevcut Dosyayı İndir</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <span class="section-title mt-4">Kapak Fotoğrafı</span>
                                <div class="cover-photo-full card py-2 px-5">
                                    <input type="file" name="cover-image" class="cover_image d-none">
                                    <div class="cover-photo-area">
                                        <div class="icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                        <label for="">Bilgisayardan Fotoğraf Ekle <span>veya sürükle bırak</span></label>
                                    </div>
                                    <div class="cover-photo">
                                        @if(isset($tempData->cover_image) && $tempData->cover_image)
                                            <div class="project_imagex">
                                                <img src="{{URL::to('/')}}/project_images/{{$tempData->cover_image}}" alt="">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <span class="section-title mt-4">Fotoğraf</span>
                                <div class="photo card py-2 px-5">
                                    <input type="file" name="project-images" class="project_image d-none">
                                    <div class="photo-area">
                                        <div class="icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                        <label for="">Bilgisayardan Fotoğraf Ekle <span>veya sürükle bırak</span></label>
                                    </div>
                                    <div class="photos">
                                        @if(isset($tempData->images) && $tempData->images)
                                            @foreach($tempData->images as $image)
                                                <div class="project_imagex">
                                                    <img src="{{URL::to('/')}}/project_images/{{$image}}" alt="">
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <span class="section-title mt-4">İlan Süresi</span>
                                <div class="pricing card py-2 px-5">
                                    
                                    <div class="row pricing-select-first @if(((isset($userPlan) && $userPlan->project_limit > 0)  && (isset($tempData->{"pricing-type"}) && $tempData->{"pricing-type"} == 1)) || (!isset($tempData->{"pricing-type"}))) @else d-none @endif">
                                        <div class="col-md-6">
                                            <div class="pricing-item-first" style="width: 100%;">
                                                <div class="pricing-item-inner" onclick="changeData(1,'pricing-type')">
                                                    <span class="btn btn-primary remaining_projects">Kalan Konut Ekleme Adedi : {{$userPlan->housing_limit}}</span>
                                                    <div style="margin-right: 20px">
                                                        <input type="radio" style="display: none;margin:0 auto;">
                                                        <div class="price-radio @if(isset($tempData->{"pricing-type"}) && $tempData->{"pricing-type"} == 1) select @endif" >
                                                            <div class="inside"></div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h3>Paket Sayımdan Düş</h3>
                                                        <span>Paketinizde ki ilanların yayın süresi 2 aydır</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="pricing-item-first"  style="width: 100%;">
                                                <div class="pricing-item-inner" onclick="changeData(2,'pricing-type')">
                                                    <div style="margin-right: 20px">
                                                        <input type="radio" style="display: none;margin:0 auto;">
                                                        <div class="price-radio @if(isset($tempData->{"pricing-type"}) && $tempData->{"pricing-type"} == 2) select @endif" >
                                                            <div class="inside"></div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h3>Tekil Fiyat</h3>
                                                        <span>Bir proje fiyatı üzerinden öde</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row single-price-project-area @if((isset($tempData->{"pricing-type"}) && $tempData->{"pricing-type"} == 1) || !isset($userPlan) || (isset($userPlan) && $userPlan->project_limit == 0) || !isset($tempData->{"pricing-type"})) d-none @endif">
                                        <div>
                                            <label for="" class="c-pointer redirect-back-pricing"><i class="fa fa-chevron-left"></i> Seçime geri dön</label>
                                        </div>
                                        @foreach($prices as $price)
                                        <div class="col-md-4">
                                            <div class="pricing-item" onclick="changeData({{$price->id}},'price_id')">
                                                <div class="pricing-item-inner">
                                                    <div style="margin-right: 20px">
                                                        <input type="radio" style="display: none;margin:0 auto;">
                                                        <div class="price-radio @if(isset($tempData->price_id) && $price->id == $tempData->price_id) select @endif" >
                                                            <div class="inside"></div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h3>{{$price->month}} Aylık İlan</h3>
                                                        <span>({{$price->month * 30}} Gün Yayın Süresi)</span>
                                                    </div>
                                                </div>
                                                <div class="price pricing-item-inner">
                                                    @if($price->old_price)
                                                        <span  class="old_price">{{$price->old_price}} ₺</span>
                                                    @endif
        
                                                    @if($price->price == 0)
                                                        <span class="new_price">Ücretsiz</span>
                                                    @else 
                                                        <span class="new_price">{{$price->price}}₺</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="second-area-finish">
                                    <div class="finish-tick ">
                                        <input type="checkbox" value="1" class="rules_confirm" >
                                        <span class="rulesOpen">İlan verme kurallarını</span>
                                        <span>okudum, kabul ediyorum</span>
                                    </div>
                                    <div class="finish-button" style="float:right;margin:0;">
                                        <button class="btn btn-info">
                                            Devam
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="third-area @if($tempDataFull->step_order != 3) d-none @endif">
                        <div class="without-dopingxx mb-5">
                            <button class="without-doping btn btn-info">Dopingsiz Bitir</button>
                        </div>
                        <div class="row" style="align-items: flex-end;">
                            <div class="col-md-5">
                                <label for="">Hangi statüde öne çıkarmak istiyorsun ?</label>
                                <select name="" class="form-control doping_statuses" id="doping_status">
                                    <option value="">Statü Seç</option>
                                    @if(isset($selectedStatuses) && count($selectedStatuses) > 0)
                                        @foreach($selectedStatuses as $statu)
                                            <option @if(isset($tempData->doping_statuses) && $tempData->doping_statuses == $statu->id) selected @endif value="{{$statu->id}}">{{$statu->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="">Sıra Seç</label>
                                <select name="" class="form-control doping_order" id="">
                                    <option value="">Sıra Seç</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option @if(isset($tempData->doping_order) && $tempData->doping_order == $i) selected @endif value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="send-button col-md-2">
                                <button class="btn btn-primary list-dates">Tarihleri göster</button>
                            </div>
                            <div class="col-md-12 mt-3 date-range d-none">
                                <div>
                                    <p class="m-0">Günlük Fiyat</p> <span class="daily-price btn btn-info" style="display: inline-block;"></span>
                                </div>
                                <div class="mt-2">
                                    <label for="">Tarih aralığını seçin?</label>
                                    <input id="date-range2" class="form-control" size="40">
                                </div>
                                <div>
                                    <p class="m-0">Toplam Fiyat</p> <span class="total-price btn btn-info" style="display: inline-block;"></span>
                                </div>
                                <div class="mt-5">
                                    <button class="finish-step-3 btn btn-info">Dopingli Bitir</button>
                                </div>
                            </div>
                        </div>
                        <div class="category-select">
                        </div>
                    </div>
                    <div class="fourth-area d-none">
                        <div class="row" style="justify-content:center;">
                            <div class="col-md-5">
                                <div class="finish-area">
                                    <div class="icon"><i class="fa fa-thumbs-up"></i></div>
                                    <div class="text">Başarıyla ilan eklediniz</div>
                                    <div class="text"><a href="{{route('housing.list')}}" class="btn btn-info">Mağazama Git</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/assets/js/moment.min.js" integrity="sha512-CryKbMe7sjSCDPl18jtJI5DR5jtkUWxPXWaLCst6QjH8wxDexfRJic2WRmRXmstr2Y8SxDDWuBO6CQC6IE4KTA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ URL::to('/') }}/adminassets/assets/js/jquery.daterangepicker.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors//leaflet/leaflet.js"></script>
<script src="{{ URL::to('/') }}/adminassets/vendors//leaflet.markercluster/leaflet.markercluster.js"></script>
<script
    src="{{ URL::to('/') }}/adminassets/vendors//leaflet.tilelayer.colorfilter/leaflet-tilelayer-colorfilter.min.js">
</script>
<script src="{{ URL::to('/') }}/js/jqueryscript.net_demo_leaflet-location-picker_src_leaflet-locationpicker.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-formBuilder/3.4.2/form-render.min.js">
</script>
    <script>
        var nextTemp = false;
        var descriptionText = @if(isset($tempData) && isset($tempData->description)) "{!! $tempData->description !!}" @else "" @endif;
        var selectedid = @if(isset($tempData) && isset($tempData->housing_type_id)) {{$tempData->housing_type_id}} @else 0 @endif;
        

        $('input[name="name"]').keyup(function(){
            console.log("asd");
            if($(this).val() != ""){
                $(this).removeClass('error-border');
            }
        })

        changeData(1,'house_count');

        $('#cities').change(function(){
            if($(this).val() != ""){
                $(this).removeClass('error-border');
            }
        })

        $('#counties').change(function(){
            if($(this).val() != ""){
                $(this).removeClass('error-border');
            }
        })

        $('#neighbourhood').change(function(){
            if($(this).val() != ""){
                $(this).removeClass('error-border');
            }
        })
        
        $('.progress-line li').click(function(e){
            e.preventDefault();
            var currentIndex = $('.progress-line li.current').index();

            var clickIndex = $(this).index();
                if(clickIndex == 0){
                    toFirstArea();
                }else if(clickIndex == 1){
                    toSecondArea();
                }
                if(clickIndex == 2){
                    toThirdArea();
                }
            
        })

        function toSecondArea(){
            $.ajax({
                method: "POST",
                url: "{{route('client.change.step.order')}}",
                data : {
                    order : 2,
                    item_type : 2,
                    _token : csrfToken
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if(response.status){
                        $('.firt-area').addClass('d-none');
                        $('.second-area').addClass('d-none');
                        $('.third-area').addClass('d-none');
                        $('.progress-line').removeClass('step1')
                        $('.progress-line').removeClass('step2')
                        $('.progress-line').removeClass('step3')
                        $('.second-area').removeClass('d-none');
                        $('.progress-line').addClass('step2')
                        $('.progress-line li').eq(0).removeClass('current').addClass('done')
                        $('.progress-line li').eq(1).addClass('current')
                        $('.progress-line li').eq(2).removeClass('current').removeClass('done')
                    }
                    
                }
            })
        }

        function toThirdArea(){
            $('.finish-button').trigger('click');

            if(nextTemp){
                $.ajax({
                    method: "POST",
                    url: "{{route('client.change.step.order')}}",
                    data : {
                        order : 3,
                        item_type : 2,
                        _token : csrfToken
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        if(response.status){
                            $('.firt-area').addClass('d-none');
                            $('.second-area').addClass('d-none');
                            $('.third-area').addClass('d-none');
                            $('.progress-line').removeClass('step1')
                            $('.progress-line').removeClass('step2')
                            $('.progress-line').removeClass('step3')
                            $('.third-area').removeClass('d-none');
                            $('.progress-line').addClass('step3')
                            $('.progress-line li').eq(0).removeClass('current').addClass('done')
                            $('.progress-line li').eq(1).removeClass('current').addClass('done')
                            $('.progress-line li').eq(2).addClass('current')
                        }
                        
                    }
                })
                
            }
            
        }

        function toFirstArea(){
            $.ajax({
                method: "POST",
                url: "{{route('client.change.step.order')}}",
                data : {
                    order : 1,
                    item_type : 2,
                    _token : csrfToken
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if(response.status){
                        $('.second-area').addClass('d-none');
                        $('.third-area').addClass('d-none');
                        $('.progress-line').removeClass('step1')
                        $('.progress-line').removeClass('step2')
                        $('.progress-line').removeClass('step3')
                        $('.firt-area').removeClass('d-none');
                        $('.progress-line').addClass('step1')
                        $('.progress-line li').eq(0).addClass('current').removeClass('done')
                        $('.progress-line li').eq(1).removeClass('current').removeClass('done')
                        $('.progress-line li').eq(2).removeClass('current').removeClass('donı')
                    }
                    
                }
            })
        }

        $('.finish-button-first').click(function(){
            toSecondArea();
        })

        $('.doping_statuses').change(function(){
            if($(this).val() != ""){
                $('.doping_statuses').removeClass('error-border')
            }
        })

        $('.doping_order').change(function(){
            if($(this).val() != ""){
                $('.doping_order').removeClass('error-border')
            }
        })

        $('.list-dates').click(function(){
            if($('.doping_statuses').val() == ""){
                $('.doping_statuses').addClass('error-border')
            }

            if($('.doping_order').val() == ""){
                $('.doping_order').addClass('error-border')
            }

            changeData($('.doping_statuses').val(),"doping_statuses");
            changeData($('.doping_order').val(),"doping_order");
            $.ajax({
                method: "GET",
                url: "{{ URL::to('/') }}/hesabim/get_busy_housing_statuses/"+$('.doping_statuses').val(),
                data : {
                    order : $('.doping_order').val()
                },
                success: function(response) {
                    response = JSON.parse(response);
                    $('.daily-price').html(response.price.price+' ₺')
                    $('.total-price').html('-')
                    $('.date-range').removeClass('d-none');
                    $('#date-range2').dateRangePicker({
                        showShortcuts: false,
                        beforeShowDay: function(t)
                        {
                            const now =  new Date(); 
                            var valid = true;
                            var birGun = 24 * 60 * 60 * 1000;
                            for(var i = 0; i<response.busy_dates.length;i++){
                                const startTime =  new Date(response.busy_dates[i].start_date); 
                                const endTime =  new Date(response.busy_dates[i].end_date);
                                if(t.getTime() < now.getTime() || t.getTime() < (endTime.getTime() + birGun) && t.getTime() > startTime.getTime()) {
                                    valid = false;
                                }
                            }

                            if(t.getTime() < now.getTime()) {
                                valid = false;
                            }
                            var _class = '';
                            var _tooltip = valid ? '' : 'Bu tarihler dolu';
                            return [valid,_class,_tooltip];
                        }
                    }).on('datepicker-change',function(event,obj){
                        /* This event will be triggered when second date is selected */
                        var startTime = new Date(obj.date1);
                        var endTime = new Date(obj.date2);
                        var endTimeFull = endTime.getDate() + '-' + (endTime.getMonth() + 1) + '-' + endTime.getFullYear();
                        var startTimeFull = startTime.getDate() + '-' + (startTime.getMonth() + 1) + '-' + startTime.getFullYear();
                        var dateDiff = datediff(startTime.getTime(),endTime.getTime()) + 1;
                        $('.total-price').html((response.price.price * dateDiff) + " ₺")
                        changeData(startTimeFull,"doping_start_date")
                        changeData(endTimeFull,"doping_end_date")
                        changeData(dateDiff,"doping_date_count")
                    })

                }
            })
        })

        @if(isset($tempData->doping_statuses) && isset($tempData->doping_order))
        $.ajax({
                method: "GET",
                url: "{{ URL::to('/') }}/hesabim/get_busy_housing_statuses/{{$tempData->doping_statuses}}",
                data : {
                    order : {{$tempData->doping_order}}
                },
                success: function(response) {
                    response = JSON.parse(response);
                    $('.daily-price').html(response.price.price+' ₺')
                    $('.date-range').removeClass('d-none');
                    $('#date-range2').dateRangePicker({
                        showShortcuts: false,
                        beforeShowDay: function(t)
                        {
                            const now =  new Date(); 
                            var valid = true;
                            var birGun = 24 * 60 * 60 * 1000;
                            for(var i = 0; i<response.busy_dates.length;i++){
                                const startTime =  new Date(response.busy_dates[i].start_date); 
                                const endTime =  new Date(response.busy_dates[i].end_date);
                                if(t.getTime() < now.getTime() || t.getTime() < (endTime.getTime() + birGun) && t.getTime() > startTime.getTime()) {
                                    valid = false;
                                }
                            }

                            if(t.getTime() < now.getTime()) {
                                valid = false;
                            }
                            var _class = '';
                            var _tooltip = valid ? '' : 'Bu tarihler dolu';
                            return [valid,_class,_tooltip];
                        }
                    }).on('datepicker-change',function(event,obj){
                        /* This event will be triggered when second date is selected */
                        var startTime = new Date(obj.date1);
                        var endTime = new Date(obj.date2);
                        var endTimeFull = endTime.getDate() + '-' + (endTime.getMonth() + 1) + '-' + endTime.getFullYear();
                        var startTimeFull = startTime.getDate() + '-' +(startTime.getMonth() + 1) + '-' + startTime.getFullYear();
                        var dateDiff = datediff(startTime.getTime(),endTime.getTime()) + 1;
                        $('.total-price').html((response.price.price * dateDiff) + " ₺")
                        changeData(startTimeFull,"doping_start_date")
                        changeData(endTimeFull,"doping_end_date")
                        changeData(dateDiff,"doping_date_count")
                    })
                }
            })

            function datediff(first, second) {        
                return Math.round((second - first) / (1000 * 60 * 60 * 24));
            }
        @endif

        var csrfToken = "{{ csrf_token() }}";
        $('.finish-step-3').click(function(){
            $.ajax({
                method: "POST",
                url: "{{route('client.project.end.temp.order')}}",
                data : {
                    _token : csrfToken,
                    without_doping : 0
                },
                success: function(response) {
                    response = JSON.parse(response);
                    
                    if(response.status){
                        $('.third-area').addClass('d-none');
                        $('.fourth-area').removeClass('d-none')
                    }
                }
            })
        })

        $('.without-doping').click(function(){
                    console.log("asd");
            $.ajax({
                method: "POST",
                url: "{{route('client.housing.store.v2')}}",
                data : {
                    _token : csrfToken,
                    without_doping : 1
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if(response.status){
                        $('.third-area').addClass('d-none');
                        $('.fourth-area').removeClass('d-none')

                        $('.firt-area').addClass('d-none');
                        $('.second-area').addClass('d-none');
                        $('.third-area').addClass('d-none');
                        $('.progress-line').removeClass('step1')
                        $('.progress-line').removeClass('step2')
                        $('.progress-line').removeClass('step3')
                        $('.fourth-area').removeClass('d-none');
                        $('.progress-line').addClass('step4')
                        $('.progress-line li').eq(0).removeClass('current').addClass('done')
                        $('.progress-line li').eq(1).removeClass('current').addClass('done')
                        $('.progress-line li').eq(2).removeClass('current').addClass('done')
                        $('.progress-line li').eq(3).addClass('current')
                    }
                }
            })
        })
        
        var houseCount = {{isset($tempData->house_count) ? $tempData->house_count : 0}};
        if(!isNaN(houseCount) && houseCount > 0){
            var houseType = {{isset($tempData->housing_type_id) ? $tempData->housing_type_id : 0}};
            if(houseType != 0){
            @if(isset($tempData->housing_type_id))
                @php $housingType = DB::table('housing_types')->where('id',$tempData->housing_type_id)->first(); @endphp
                var housingTypeData = @json($housingType);
                @if(isset($tempData->roomInfoKeys))
                    var oldData = @json($tempData->roomInfoKeys);
                @else 
                    var oldData = [];
                @endif
                var formInputs = JSON.parse(housingTypeData.form_json);
            @endif
            $('.rendered-area').removeClass('d-none')
            $.ajax({
                method: "GET",
                url: "{{ route('client.ht.getform') }}",
                data: {
                    id: houseType
                },
                success: function(response) {
                    var html = "";
                    var htmlContent = "";
                    for(var i = 0 ; i < houseCount; i++ ){
                        html += '<div class="item-left-area"><a class="nav-link border-end border-end-sm-0 border-bottom-sm border-300 text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center '+(i == 0 ? 'active' : '')+'" id="Tab'+(i+1)+'" data-bs-toggle="tab" data-bs-target="#TabContent'+(i+1)+'" role="tab" aria-controls="TabContent'+(i+1)+'" aria-selected="true">'+
                            '<span class="me-sm-2 fs-4 nav-icons" data-feather="tag"></span>'+
                            '<span class="d-block d-sm-inline">'+(i+1)+' Nolu Konut Bilgileri</span>'+
                            '<span class="d-block d-sm-inline">Kopyala (Aynı Olan Dairelere Otomatik Giriş) '+getCopyList(houseCount,i+1)+'</span>'+
                        '</a></div>';

                        htmlContent += '<div class="tab-pane fade show '+(i == 0 ? 'active' : '')+'" id="TabContent'+(i+1)+'" role="tabpanel">'+
                            '<div id="renderForm'+(i+1)+'"></div>'+
                        '</div>';
                    }

                    $('#tablist').html(html);
                    $('.tab-content').html(htmlContent)

                    $('.item-left-area').click(function(){
                        console.log("asd");
                    })
                    for (let i = 1; i <= houseCount; i++) {
                        formRenderOpts = {
                            dataType: 'json',
                            formData: response.form_json
                        };

                        var renderedForm = $('<div>');
                        renderedForm.formRender(formRenderOpts);
                        var renderHtml = renderedForm.html().toString();
                        renderHtml = renderHtml.toString().split('images[][]');
                        renderHtml = renderHtml[0]+'images'+i+'[][]'+renderHtml[1];
                        var json = JSON.parse(response.form_json);
                        for(var lm = 0 ; lm < json.length; lm++){
                            if(json[lm].type == "checkbox-group"){
                            var renderHtml = renderHtml.toString().split(json[lm].name+'[]');
                            renderHtmlx = "";
                            var json = JSON.parse(response.form_json);
                            for(var t = 0 ; t < renderHtml.length ; t++){
                                if(t != renderHtml.length - 1){
                                renderHtmlx += renderHtml[t]+(json[lm].name.split('[]')[0])+i+'[][]';
                                }else{
                                renderHtmlx += renderHtml[t];
                                }
                            }

                            renderHtml = renderHtmlx;
                            }
                        }
                        console.log(renderHtmlx);
                        $('#renderForm'+(i)).html(renderHtmlx);

                        
                        $('#tablist a.nav-link').click(function(e) {
                            e.preventDefault(); // Linki tıklamayı engelleyin

                            // Tüm sekmeleri gizleyin
                            $('.tab-content .tab-pane').removeClass('show active');

                            // Tıklanan tab linkine ait tabın kimliğini alın
                            var tabId = $(this).attr('data-bs-target');

                            // İlgili tabı gösterin
                            $(tabId).addClass('show active');
                        });

                        
                    }

                    $('.next_house').click(function(){
                        var nextHousing = true;
                        $('.tab-pane.active input[required="required"]').map((key,item) => {
                            if(!$(item).val()){
                                nextHousing = false;
                                $(item).addClass("error-border")
                            }
                        })

                        $('.tab-pane.active select[required="required"]').map((key,item) => {
                            if(!$(item).val()){
                                nextHousing = false;
                                $(item).addClass("error-border")
                            }
                        })
                        if($('.tab-pane.active input[required="required"]').val() == ""){
                            nextHousing = false;
                            $('.tab-pane.active input[name="price[]"]').addClass('error-border')
                        }
                        var indexItem = $('.tab-pane.active').index();
                        if(nextHousing){
                            $('.tab-pane.active').removeClass('active');
                            $('.tab-pane').eq(indexItem + 1).addClass('active');
                        }else{
                            $('html, body').animate({
                                scrollTop: $('.tab-pane.active').offset().top - parseFloat($('.navbar-top').css('height'))
                            }, 100);
                        }
                    })

                    $('.prev_house').click(function(){
                        
                        var indexItem = $('.tab-pane.active').index();
                        console.log(indexItem);
                        $('.tab-pane.active').removeClass('active');
                        $('.tab-pane').eq(indexItem - 1).addClass('active');
                    })
                    for (let i = 1; i <= houseCount; i++) {
                        for(var j = 2 ; j < formInputs.length; j++){
                        if(formInputs[j].type == "number" || formInputs[j].type == "text"){
                            var inputName = formInputs[j].name;
                            var inputNamex = inputName;
                            inputNamex = inputNamex.split('[]')
                            if(oldData[inputNamex[0]] != undefined){
                                $($('input[name="'+formInputs[j].name+'"]')[i-1]).val(oldData[inputNamex[0]][i - 1]);
                            }
                        }else if(formInputs[j].type == "select"){
                            var inputName = formInputs[j].name;
                            var inputNamex = inputName;
                            inputNamex = inputNamex.split('[]')
                            $($('select[name="'+formInputs[j].name+'"]')[i-1]).children('option').map((key,item) => {
                            if(oldData[inputNamex[0]] != undefined){
                                if($(item).attr("value") == oldData[inputNamex[0]][i - 1]){
                                    $(item).attr('selected','selected')
                                }else{
                                    $(item).removeAttr('selected')
                                }
                            }else{
                                $(item).removeAttr('selected')
                            }
                            
                            });
                        }else if(formInputs[j].type == 'checkbox-group'){
                            var inputName = formInputs[j].name;
                            var inputNamex = inputName;
                            inputNamex = inputNamex.split('[]')
                            var checkboxName = inputName;
                            checkboxName = checkboxName.split('[]');
                            checkboxName = checkboxName[0];
                            $($('input[name="'+checkboxName+[i]+'[][]"]')).map((key,item) => {
                            if(oldData[inputNamex[0]+(i)]){
                                oldData[inputNamex[0]+(i)].map((checkbox) => {
                                console.log(checkbox,$(item).attr("value"));
                                    if(checkbox == $(item).attr("value")){
                                        $(item).attr('checked','checked')
                                    }
                                })
                            }
                            
                            });
                        }
                        
                        }
                    }
                    
                    $('.dropzonearea').closest('.formbuilder-file').remove();
                    for(let i = 1 ; i <= houseCount; i++){
                        var images = '';
                        if(oldData.images){
                        housingImages = JSON.parse( oldData.images[i-1]);
                        }else{
                        housingImages = [];
                        }
                        for(let j = 0; j < housingImages.length; j++){
                        images += '<div class="project_images_area"><img class="edit_project_housing_image" src="{{URL::to("/")."/project_images/"}}'+housingImages[j]+'"> <span order="'+j+'" housing_order="'+i+'" class="btn btn-danger remove_housing_image">Sil</span>  </div>';
                        }
                        $('.dropzone2').eq(i-1).parent('div').append('<div class="d-none"><input housing_order="'+i+'" type="file" class="new_file_on_drop"></div>')
                        $('.dropzone2').eq(i-1).html(images);
                    }

                    var csrfToken = "{{ csrf_token() }}";

                    $('.add-new-project-house-image').click(function(){
                        $(this).parent('div').find('.new_file_on_drop').trigger("click")
                    })
                    
                    $('.new_project_housing_image').click(function(){
                        console.log("asd");
                    })

                    
                    $('.copy-item').change(function(){
                        var order = parseInt($(this).val()) - 1;
                        var currentOrder = parseInt($(this).closest('a').attr('data-bs-target').replace('#TabContent','')) - 1;
                        for(var lm = 0 ; lm < json.length; lm++){
                            if(json[lm].type == "checkbox-group"){
                            for(var i = 0 ; i < json[lm].values.length; i++){
                                var isChecked = $('input[name="'+(json[lm].name.replace('[]',''))+(order+1  )+'[][]"][value="'+json[lm].values[i].value+'"]'+'').is(':checked')
                                if(isChecked){
                                $('input[name="'+(json[lm].name.replace('[]',''))+(currentOrder+1  )+'[][]"][value="'+json[lm].values[i].value+'"]'+'').prop('checked',true)
                                }else{
                                $('input[name="'+(json[lm].name.replace('[]',''))+(currentOrder+1  )+'[][]"][value="'+json[lm].values[i].value+'"]'+'').prop('checked',false)
                                }
                            }
                            }else if(json[lm].type == "select"){
                                var value = $('select[name="'+(json[lm].name)+'"]').eq(order).val();
                                $('select[name="'+(json[lm].name)+'"]').eq(currentOrder).children('option').removeAttr('selected')
                                console.log($('select[name="'+(json[lm].name)+'"]').eq(currentOrder).children('option[value="'+value[0]+'"]'));
                                $('select[name="'+(json[lm].name)+'"]').eq(currentOrder).children('option[value="'+value[0]+'"]').prop('selected',true);
                            }else if(json[lm].type == "file" && json[lm].name == "image[]"){
                                var files = $('input[name="'+(json[lm].name)+'"]').eq(order)[0].files;
                                var input2 = $('input[name="'+(json[lm].name)+'"]').eq(currentOrder);
                                for (var i = 0; i < files.length; i++) {
                                    var file = files[i];
                                    input2.prop("files",files);
                                }
                            }else if(json[lm].type != "file"){
                                var value = $('input[name="'+(json[lm].name)+'"]').eq(order).val();
                                console.log($('input[name="'+(json[lm].name)+'"]').eq(order).val());
                                $('input[name="'+(json[lm].name)+'"]').eq(currentOrder).val(value);
                            }
                        }
                    })
                    
                    $('.rendered-form input').change(function(){
                        console.log("asd");
                        var formData = new FormData();
                        var csrfToken = $("meta[name='csrf-token']").attr("content");
                        formData.append('_token', csrfToken);
                        formData.append('value',$(this).val());
                        console.log($(this).closest('.tab-pane').attr('id'))
                        formData.append('order',parseInt($(this).closest('.tab-pane').attr('id').replace('TabContent',"")) - 1);
                        formData.append('key',$(this).attr('name').replace("[]", "").replace("[]", ""));
                        formData.append('item_type',2);
                        if($(this).attr('type') == "checkbox"){
                            formData.append('checkbox',"1");
                        }
                        $.ajax({
                            type: "POST",
                            url: "{{route('client.temp.order.project.housing.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                            },
                        });
                    })

                    $('.rendered-form select').change(function(){
                        console.log("asd");
                        var formData = new FormData();
                        var csrfToken = $("meta[name='csrf-token']").attr("content");
                        formData.append('_token', csrfToken);
                        formData.append('value',$(this).val());
                        console.log($(this).closest('.tab-pane').attr('id'))
                        formData.append('order',parseInt($(this).closest('.tab-pane').attr('id').replace('TabContent',"")) - 1);
                        formData.append('key',$(this).attr('name').replace("[]", ""));
                        formData.append('item_type',2);
                        $.ajax({
                            type: "POST",
                            url: "{{route('client.temp.order.project.housing.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                            },
                        });
                    })

                    $('.price-only').keyup(function(){
                        $('.price-only .error-text').remove();
                        if($('.price-only').val() != parseFloat($('.price-only').val())){
                            if($('.price-only').closest('.form-group').find('.error-text').length > 0){
                                $('.price-only').val("");
                            }else{
                                $(this).closest('.form-group').append('<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                                $('.price-only').val("");
                            }
                            
                        }else{
                            $(this).closest('.form-group').find('.error-text').remove();
                        }
                    })

                    $('.number-only').keyup(function(){
                        $('.number-only .error-text').remove();
                        if($(this).val() != parseInt($(this).val())){
                            if($(this).closest('.form-group').find('.error-text').length > 0){
                                $(this).val("");
                            }else{
                                $(this).closest('.form-group').append('<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                                $(this).val("");
                            }
                            
                        }else{
                            $(this).closest('.form-group').find('.error-text').remove();
                        }
                    })

                    $('.formbuilder-text input').change(function(){
                        if($(this).val() != ""){
                            $(this).removeClass('error-border')
                        }
                    })

                    $('.formbuilder-number input').change(function(){
                        if($(this).val() != ""){
                            $(this).removeClass('error-border')
                        }
                    })
                    
                    $('.cover-image-by-housing-type').closest('.formbuilder-file').remove();
                },
                error: function(error) {
                    console.log(error)
                }
            })
            }
            
        }
        function changeData(value,key,isArray = 0){
            var formData = new FormData();
            var csrfToken = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', csrfToken);
            formData.append('value',value);
            formData.append('key',key);
            formData.append('item_type',2);
            formData.append('array_data',isArray);
            $.ajax({
                type: "POST",
                url: "{{route('client.temp.order.data.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(key == 'pricing-type'){
                        if(value == 2){
                            $('.single-price-project-area').removeClass('d-none')
                            $('.pricing-select-first').addClass('d-none')
                        }else{
                            $('.single-price-project-area').addClass('d-none')
                        }
                    }
                },
            });
        }

        $('.redirect-back-pricing').click(function(){
            $('.single-price-project-area').addClass('d-none')
            $('.pricing-select-first').removeClass('d-none')
        })

        $('.photo-area').click(function(){
            $('.project_image.d-none').trigger('click');
        })

        $('.cover-photo-area').click(function(){
            $('.cover_image.d-none').trigger('click');
        })

        $('.cover-document-area').click(function(){
            $('.document.d-none').trigger('click');
        })

        $('.document').change(function() {
            var input = this;
            if (input.files && input.files[0]) {
                $('.cover-document-area').removeClass('error-border')
                var reader = new FileReader();

                var formData = new FormData();
                var csrfToken = $("meta[name='csrf-token']").attr("content");
                formData.append('_token', csrfToken);
                formData.append('document',this.files[0]);
                formData.append('item_type',2);
                $.ajax({
                    type: "POST",
                    url: "{{route('client.temp.order.document.add')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        response = JSON.parse(response);

                        if(response.status){
                            var html = '<div class="has_file">'+
                                '<span class="d-block">Dosya Eklediniz</span>'+
                                '<a class="btn btn-info" href="{{URL::to("/")}}/housing_documents/'+response.document_name+'" download="">Mevcut Dosyayı İndir</a>'+
                            '</div>';

                            $('.cover-document').html(html);
                        }
                    },
                    error: function() {
                        // Hata durumunda kullanıcıya bir mesaj gösterebilirsiniz
                        alert("Dosya yüklenemedi.");
                    }
                });
                
            }
        });

        $('.cover_image').change(function() {
            var input = this;

            if (input.files && input.files[0]) {
                $('.cover-photo-area').removeClass('error-border')
                var reader = new FileReader();

                var formData = new FormData();
                var csrfToken = $("meta[name='csrf-token']").attr("content");
                formData.append('_token', csrfToken);
                formData.append('image',this.files[0]);
                formData.append('item_type',2);
                $.ajax({
                    type: "POST",
                    url: "{{route('client.temp.order.single.file.add')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Dosya yükleme başarılı ise sunucudan gelen yanıtı görüntüle
                        $("#sonuc").html(response);
                    },
                    error: function() {
                        // Hata durumunda kullanıcıya bir mesaj gösterebilirsiniz
                        alert("Dosya yüklenemedi.");
                    }
                });
                reader.onload = function(e) {
                    // Resmi görüntülemek için bir div oluşturun
                    var imageDiv = $('<div class="project_imagex"></div>');

                    // Resmi oluşturun ve div içine ekleyin
                    var image = $('<img>').attr('src', e.target.result);
                    imageDiv.append(image);
                    // Resmi görüntüleyici divini temizleyin ve yeni resmi ekleyin
                    $('.cover-photo').html(imageDiv);

                    $('.cover-photo').on('click', '.fa-trash', function() {
                        var imageDiv = $(this).parent(); // Tıklanan resmin üst öğesini al

                        // Kullanıcıdan resmi silmek istediğine emin misiniz diye sorabilirsiniz
                        var confirmation = confirm("Bu resmi silmek istediğinizden emin misiniz?");
                        
                        if (confirmation) {
                            imageDiv.remove(); // Resmi kaldır
                        }
                    });
                };

                // Resmi okuyun
                reader.readAsDataURL(input.files[0]);
            }
        });

        $('.project_image').change(function() {
            var input = this;

            if (input.files && input.files[0]) {
                $('.photo-area').removeClass('error-border')
                var reader = new FileReader();

                var formData = new FormData();
                var csrfToken = $("meta[name='csrf-token']").attr("content");
                formData.append('_token', csrfToken);
                formData.append('image',this.files[0]);
                formData.append('item_type',2);
                $.ajax({
                    type: "POST",
                    url: "{{route('client.temp.order.image.add')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Dosya yükleme başarılı ise sunucudan gelen yanıtı görüntüle
                        $("#sonuc").html(response);
                    },
                    error: function() {
                        // Hata durumunda kullanıcıya bir mesaj gösterebilirsiniz
                        alert("Dosya yüklenemedi.");
                    }
                });
                reader.onload = function(e) {
                    // Resmi görüntülemek için bir div oluşturun
                    var imageDiv = $('<div class="project_imagex"></div>');

                    // Resmi oluşturun ve div içine ekleyin
                    var image = $('<img>').attr('src', e.target.result);
                    imageDiv.append(image);
                    var deleteIcon = $('<span class="fa fa-trash">Sil</span>');
                    imageDiv.append(deleteIcon);
                    // Resmi görüntüleyici divini temizleyin ve yeni resmi ekleyin
                    $('.photos').append(imageDiv);

                    $('.photos').on('click', '.fa-trash', function() {
                        var imageDiv = $(this).parent(); // Tıklanan resmin üst öğesini al

                        // Kullanıcıdan resmi silmek istediğine emin misiniz diye sorabilirsiniz
                        var confirmation = confirm("Bu resmi silmek istediğinizden emin misiniz?");
                        
                        if (confirmation) {
                            imageDiv.remove(); // Resmi kaldır
                        }
                    });
                };

                // Resmi okuyun
                reader.readAsDataURL(input.files[0]);
            }
        });

        $('.finish-tick').click(function(){
            console.log($(this).find('input').is(':checked'));
            if($(this).find('input').is(':checked')){
                $(this).find('input').prop('checked',false)
            }else{
                $('.finish-tick').removeClass('error-border')
                $(this).find('input').prop('checked',true)
            }
        })
        
        $('.pricing-item').click(function(){
            $('.pricing-item').find('input').removeAttr('checked');
            $('.pricing-item').find('.price-radio').removeClass('select');
            $(this).find('input').attr('checked','checked');
            $(this).find('.price-radio').addClass('select')
            $('.single-price-project-area .error-text').remove()
        })

        $('.pricing-item-first').click(function(){
            $('.pricing-item-first').find('input').removeAttr('checked');
            $('.pricing-item-first').find('.price-radio').removeClass('select');
            $(this).find('input').attr('checked','checked');
            $(this).find('.price-radio').addClass('select')
            $('.pricing-select-first .error-text').remove();
        })

        $('.photo-area').click(function(){

        })

        function getCopyList(housingCount,currentItemKey){
            var html = '<select class="copy-item"><option value="">Daire bilgilerini kopyala</option>'
            for(var i = 1; i <= housingCount; i++){
            if(i != currentItemKey){
                html += '<option value="'+i+'">Daire '+i+'</option>'
            }
            }

            html += '</select>'

            return html;
        }

        jQuery($ => {
            var houseCount = {{old('house_count') ? old('house_count') : 0}};
            if(!isNaN(houseCount) && houseCount > 0){
                var houseType = {{old('housing_type') ? old('housing_type') : 0}};
                if(houseType != 0){
                @php $housingType = DB::table('housing_types')->where('id',old('housing_type'))->first(); @endphp
                var housingTypeData = @json($housingType);
                var oldData = @json(old());
                console.log(oldData);
                var formInputs = JSON.parse(housingTypeData.form_json);

                $('.rendered-area').removeClass('d-none')
                $.ajax({
                    method: "GET",
                    url: "{{ route('client.ht.getform') }}",
                    data: {
                        id: houseType
                    },
                    success: function(response) {
                        var html = "";
                        var htmlContent = "";
                        for(var i = 0 ; i < houseCount; i++ ){
                            html += '<a class="nav-link border-end border-end-sm-0 border-bottom-sm border-300 text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center '+(i == 0 ? 'active' : '')+'" id="Tab'+(i+1)+'" data-bs-toggle="tab" data-bs-target="#TabContent'+(i+1)+'" role="tab" aria-controls="TabContent'+(i+1)+'" aria-selected="true">'+
                                '<span class="me-sm-2 fs-4 nav-icons" data-feather="tag"></span>'+
                                '<span class="d-none d-sm-inline">'+(i+1)+' Nolu Konut Bilgileri</span>'+
                            '</a>';

                            htmlContent += '<div class="tab-pane fade show '+(i == 0 ? 'active' : '')+'" id="TabContent'+(i+1)+'" role="tabpanel">'+
                                '<div id="renderForm'+(i+1)+'"></div>'+
                            '</div>';
                        }

                        $('#tablist').html(html);
                        $('.tab-content').html(htmlContent)
                        for (let i = 1; i <= houseCount; i++) {
                            formRenderOpts = {
                                dataType: 'json',
                                formData: response.form_json
                            };

                            var renderedForm = $('<div>');
                            renderedForm.formRender(formRenderOpts);
                            var renderHtml = renderedForm.html().toString();
                            renderHtml = renderHtml.toString().split('images[][]');
                            renderHtml = renderHtml[0]+'images'+i+'[][]'+renderHtml[1];
                            var json = JSON.parse(response.form_json);
                            for(var lm = 0 ; lm < json.length; lm++){
                                if(json[lm].type == "checkbox-group"){
                                var renderHtml = renderHtml.toString().split(json[lm].name+'[]');
                                renderHtmlx = "";
                                var json = JSON.parse(response.form_json);
                                for(var t = 0 ; t < renderHtml.length ; t++){
                                    if(t != renderHtml.length - 1){
                                    renderHtmlx += renderHtml[t]+(json[lm].name.split('[]')[0])+i+'[][]';
                                    }else{
                                    renderHtmlx += renderHtml[t];
                                    }
                                }

                                renderHtml = renderHtmlx;
                                }
                            }
                            $('#renderForm'+(i)).html(renderHtmlx);
                            $('#tablist a.nav-link').click(function(e) {
                                e.preventDefault(); // Linki tıklamayı engelleyin

                                // Tüm sekmeleri gizleyin
                                $('.tab-content .tab-pane').removeClass('show active');

                                // Tıklanan tab linkine ait tabın kimliğini alın
                                var tabId = $(this).attr('data-bs-target');

                                // İlgili tabı gösterin
                                $(tabId).addClass('show active');
                            });

                        }
                        for (let i = 1; i <= houseCount; i++) {
                            for(var j = 2 ; j < formInputs.length; j++){
                            if(formInputs[j].type == "number" || formInputs[j].type == "text"){
                                var inputName = formInputs[j].name;
                                var inputNamex = inputName;
                                inputNamex = inputNamex.split('[]')
                                console.log(inputNamex);
                                $($('input[name="'+formInputs[j].name+'"]')[i-1]).val(oldData[inputNamex[0]][i - 1]);
                            }else if(formInputs[j].type == "select"){
                                var inputName = formInputs[j].name;
                                var inputNamex = inputName;
                                inputNamex = inputNamex.split('[]')
                                $($('select[name="'+formInputs[j].name+'"]')[i-1]).children('option').map((key,item) => {
                                if($(item).attr("value") == oldData[inputNamex[0]][i - 1]){
                                    $(item).attr('selected','selected')
                                }else{
                                    $(item).removeAttr('selected')
                                }
                                });
                            }else if(formInputs[j].type == 'checkbox-group'){
                                var inputName = formInputs[j].name;
                                var inputNamex = inputName;
                                inputNamex = inputNamex.split('[][]')
                                var checkboxName = inputName;
                                checkboxName = checkboxName.split('[]');
                                checkboxName = checkboxName[0];
                                $($('input[name="'+checkboxName+[i]+'[][]"]')).map((key,item) => {
                                console.log(oldData[(checkboxName+i)],$(item).attr("value"))
                                oldData[(checkboxName+i)].map((checkbox) => {
                                    if(checkbox[0] == $(item).attr("value")){
                                    $(item).attr('checked','checked')
                                    }
                                })
                                });
                            }

                            }
                        }





                    },
                    error: function(error) {
                        console.log(error)
                    }
                })
                }

            }
            $('#location').leafletLocationPicker({
                alwaysOpen: true,
                mapContainer: "#mapContainer",
                height: 300,
                width: '100%',
                map: {
                    zoom: 5
                },
                event: 'click',
                onChangeLocation: function(location) {
                    var latitude = location.latlng.lat;
                    var longitude = location.latlng.lng;
                    changeData(latitude+','+longitude,'location');
                    var apiURL = "https://nominatim.openstreetmap.org/reverse?format=json&lat=" + latitude + "&lon=" + longitude+'&zoom=18&addressdetails=1';
                }
            }); 

            const houseCountInput = document.getElementById('house_count');
            const generateTabsButton = document.getElementById('generate_tabs');
            const tabsContainer = document.getElementById('tabs');

            $('.area-list li').click( function () {
                console.log("asd");
                var clickItem = $(this).closest('.area-list');
                var itemOrderx = clickItem.index();
                if(itemOrderx == 2){
                    if(selectedid){
                        $('.rendered-area').removeClass('d-none')
                    }else{
                        $.toast({
                            heading: 'Hata',
                            text: 'Proje Hangi Tipte Konutlardan Oluşuyor Seçeneğini Lütfen Seçiniz',
                            position: 'top-right',
                            stack: false
                        })
                    }
                    const houseCount = 1;

                    if (isNaN(houseCount) || houseCount <= 0) {
                        alert('Lütfen geçerli bir sayı girin.');
                        return;
                    }


                    $.ajax({
                        method: "GET",
                        url: "{{ route('client.ht.getform') }}",
                        data: {
                            id: selectedid
                        },
                        success: function(response) {
                            var html = "";
                            var htmlContent = "";
                            for(var i = 0 ; i < houseCount; i++ ){

                                htmlContent += '<div class="tab-pane fade show '+(i == 0 ? 'active' : '')+'" id="TabContent'+(i+1)+'" role="tabpanel">'+
                                    '<div id="renderForm'+(i+1)+'" class="card p-4"></div>'+
                                '</div>';
                            }

                            $('#tablist').html(html);
                            $('.tab-content').html(htmlContent)
                            for (let i = 1; i <= houseCount; i++) {
                                console.log(i);
                                formRenderOpts = {
                                    dataType: 'json',
                                    formData: response.form_json
                                };

                                var renderedForm = $('<div>');
                                renderedForm.formRender(formRenderOpts);
                                var renderHtml = renderedForm.html().toString();
                                renderHtml = renderHtml.toString().split('images[][]');
                                var json = JSON.parse(response.form_json);
                                renderHtml = renderHtml[0]+'images'+i+'[][]'+renderHtml[1];
                                for(var lm = 0 ; lm < json.length; lm++){
                                    if(json[lm].type == "checkbox-group"){
                                        console.log();
                                        var renderHtml = renderHtml.toString().split(json[lm].name+'[]');
                                        renderHtmlx = "";
                                        var json = JSON.parse(response.form_json);
                                        for(var t = 0 ; t < renderHtml.length ; t++){
                                            if(t != renderHtml.length - 1){
                                                renderHtmlx += renderHtml[t]+(json[lm].name.split('[]')[0])+i+'[][]';
                                            }else{
                                                renderHtmlx += renderHtml[t];
                                            }
                                        }

                                        renderHtml = renderHtmlx;
                                    }
                                    
                                    $('.checkbox-item').closest('.checkbox-group').addClass('d-flex')
                                    $('.checkbox-item').closest('.checkbox-group').addClass('checkbox-items')
                                }

                                $('#renderForm'+(i)).html(renderHtml);
                                $('#tablist a.nav-link').click(function(e) {
                                    e.preventDefault(); // Linki tıklamayı engelleyin

                                    // Tüm sekmeleri gizleyin
                                    $('.tab-content .tab-pane').removeClass('show active');

                                    // Tıklanan tab linkine ait tabın kimliğini alın
                                    var tabId = $(this).attr('data-bs-target');

                                    // İlgili tabı gösterin
                                    $(tabId).addClass('show active');
                                });
                            }

                            $('.next_house').click(function(){
                                var nextHousing = true;
                                $('.tab-pane.active input[required="required"]').map((key,item) => {
                                    if(!$(item).val()){
                                        nextHousing = false;
                                        $(item).addClass("error-border")
                                    }
                                })

                                $('.tab-pane.active select[required="required"]').map((key,item) => {
                                    if(!$(item).val()){
                                        nextHousing = false;
                                        $(item).addClass("error-border")
                                    }
                                })
                                if($('.tab-pane.active input[required="required"]').val() == ""){
                                    nextHousing = false;
                                    $('.tab-pane.active input[name="price[]"]').addClass('error-border')
                                }
                                var indexItem = $('.tab-pane.active').index();
                                if(nextHousing){
                                    $('.tab-pane.active').removeClass('active');
                                    $('.tab-pane').eq(indexItem + 1).addClass('active');
                                }else{
                                    $('html, body').animate({
                                        scrollTop: $('.tab-pane.active').offset().top - parseFloat($('.navbar-top').css('height'))
                                    }, 100);
                                }
                            })

                            $('.prev_house').click(function(){
                                
                                var indexItem = $('.tab-pane.active').index();
                                console.log(indexItem);
                                $('.tab-pane.active').removeClass('active');
                                $('.tab-pane').eq(indexItem - 1).addClass('active');
                            })

                            $('.copy-item').change(function(){
                                var order = parseInt($(this).val()) - 1;
                                var currentOrder = parseInt($(this).closest('a').attr('data-bs-target').replace('#TabContent','')) - 1;
                                for(var lm = 0 ; lm < json.length; lm++){
                                    if(json[lm].type == "checkbox-group"){
                                    for(var i = 0 ; i < json[lm].values.length; i++){
                                        var isChecked = $('input[name="'+(json[lm].name.replace('[]',''))+(order+1  )+'[][]"][value="'+json[lm].values[i].value+'"]'+'').is(':checked')
                                        if(isChecked){
                                        $('input[name="'+(json[lm].name.replace('[]',''))+(currentOrder+1  )+'[][]"][value="'+json[lm].values[i].value+'"]'+'').attr('checked','checked')
                                        }else{
                                        $('input[name="'+(json[lm].name.replace('[]',''))+(currentOrder+1  )+'[][]"][value="'+json[lm].values[i].value+'"]'+'').removeAttr('checked')
                                        }
                                    }
                                    }else if(json[lm].type == "select"){
                                    var value = $('select[name="'+(json[lm].name)+'"]').eq(order).val();
                                    $('select[name="'+(json[lm].name)+'"]').eq(currentOrder).children('option').removeAttr('selected')
                                    $('select[name="'+(json[lm].name)+'"]').eq(currentOrder).children('option[value="'+value[0]+'"]').attr('selected','selected');
                                    }else if(json[lm].type == "file" && json[lm].name == "image[]"){
                                    var files = $('input[name="'+(json[lm].name)+'"]').eq(order)[0].files;
                                    var input2 = $('input[name="'+(json[lm].name)+'"]').eq(currentOrder);
                                    for (var i = 0; i < files.length; i++) {
                                        var file = files[i];
                                        input2.prop("files",files);
                                    }
                                    }else if(json[lm].type == "file" && json[lm].name != "image[]"){
                                    var files = $('input[name="'+(json[lm].name.replace('[]',''))+(order+1)+'[][]"]')[0].files;
                                    var input2 = $('input[name="'+(json[lm].name.replace('[]',''))+(currentOrder+1)+'[][]"]');
                                    for (var i = 0; i < files.length; i++) {
                                        var file = files[i];
                                        input2.prop("files",files);
                                    }
                                    }else if(json[lm].type != "file"){
                                    var value = $('input[name="'+(json[lm].name)+'"]').eq(order).val();
                                    console.log($('input[name="'+(json[lm].name)+'"]').eq(currentOrder));
                                    $('input[name="'+(json[lm].name)+'"]').eq(currentOrder).attr("value",value);
                                    }
                                }
                            })

                            $('.rendered-form input').change(function(){
                                console.log("asd");
                                var formData = new FormData();
                                var csrfToken = $("meta[name='csrf-token']").attr("content");
                                formData.append('_token', csrfToken);
                                formData.append('value',$(this).val());
                                formData.append('order',parseInt($(this).closest('.tab-pane').attr('id').replace('TabContent',"")) - 1);
                                formData.append('key',$(this).attr('name').replace("[]", "").replace("[]", ""));
                                formData.append('item_type',2);
                                if($(this).attr('type') == "checkbox"){
                                    formData.append('checkbox',"1");
                                }
                                $.ajax({
                                    type: "POST",
                                    url: "{{route('client.temp.order.project.housing.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                    },
                                });
                            })

                            $('.rendered-form select').change(function(){
                                console.log("asd");
                                var formData = new FormData();
                                var csrfToken = $("meta[name='csrf-token']").attr("content");
                                formData.append('_token', csrfToken);
                                formData.append('value',$(this).val());
                                console.log($(this).closest('.tab-pane').attr('id'))
                                formData.append('order',parseInt($(this).closest('.tab-pane').attr('id').replace('TabContent',"")) - 1);
                                formData.append('key',$(this).attr('name').replace("[]", ""));
                                formData.append('item_type',2);
                                $.ajax({
                                    type: "POST",
                                    url: "{{route('client.temp.order.project.housing.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                    },
                                });
                            })

                            $('.dropzonearea').closest('.formbuilder-file').remove();

                            $('.price-only').keyup(function(){
                                $('.price-only .error-text').remove();
                                if($('.price-only').val() != parseFloat($('.price-only').val())){
                                    if($('.price-only').closest('.form-group').find('.error-text').length > 0){
                                        $('.price-only').val("");
                                    }else{
                                        $(this).closest('.form-group').append('<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                                        $('.price-only').val("");
                                    }
                                    
                                }else{
                                    $(this).closest('.form-group').find('.error-text').remove();
                                }
                            })

                            $('.number-only').keyup(function(){
                                $('.number-only .error-text').remove();
                                if($(this).val() != parseInt($(this).val())){
                                    if($(this).closest('.form-group').find('.error-text').length > 0){
                                        $(this).val("");
                                    }else{
                                        $(this).closest('.form-group').append('<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                                        $(this).val("");
                                    }
                                    
                                }else{
                                    $(this).closest('.form-group').find('.error-text').remove();
                                }
                            })

                            $('.formbuilder-text input').change(function(){
                                if($(this).val() != ""){
                                    $(this).removeClass('error-border')
                                }
                            })

                            $('.formbuilder-number input').change(function(){
                                if($(this).val() != ""){
                                    $(this).removeClass('error-border')
                                }
                            })
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    })
                }
                
                // Belirtilen sayıda sekme oluştur

            });
        });

        @if(isset($tempData->city_id))
            var selectedCity = {{$tempData->city_id}}; // Seçilen şehir değerini al

            // AJAX isteği yap
            $.ajax({
                url: '{{route("client.get.counties")}}', // Endpoint URL'si (get.counties olarak varsayalım)
                method: 'GET',
                data: { city: selectedCity }, // Şehir verisini isteğe ekle
                dataType: 'json', // Yanıtın JSON formatında olduğunu belirt
                success: function(response) {
                    // Yanıt başarılı olduğunda çalışacak kod
                    var countiesSelect = $('#counties'); // counties id'li select'i seç
                    countiesSelect.empty(); // Select içeriğini temizle
                    var countyId = @if(isset($tempData->county_id)) {{$tempData->county_id}} @else null @endif
                    // Dönen yanıttaki ilçeleri döngüyle ekleyin
                    for (var i = 0; i < response.length; i++) {
                        countiesSelect.append($('<option>', {
                            value: response[i].ilce_key, // İlçe ID'si
                            text: response[i].ilce_title, // İlçe adı
                            key_x: response[i].key_x,
                            selected : (response[i].ilce_key == countyId ? true : false) 
                        }));
                    }

                    @if(isset($tempData->county_id))
                        var selectedCounty = {{$tempData->county_id}}; // Seçilen şehir değerini al
                        var selectedCountyKey = $('#counties option[value="'+selectedCounty+'"]').attr("key_x");
                        // AJAX isteği yap
                        
                        $.ajax({
                            url: '{{route("client.get.neighbourhood")}}', // Endpoint URL'si (get.counties olarak varsayalım)
                            method: 'GET',
                            data: { county_id: selectedCounty }, // Şehir verisini isteğe ekle
                            dataType: 'json', // Yanıtın JSON formatında olduğunu belirt
                            success: function(response) {
                                // Yanıt başarılı olduğunda çalışacak kod
                                var countiesSelect = $('#neighbourhood'); // counties id'li select'i seç
                                countiesSelect.empty(); // Select içeriğini temizle
                                var countyId = @if(isset($tempData->neighbourhood_id)) {{$tempData->neighbourhood_id}} @else null @endif

                                for (var i = 0; i < response.length; i++) {
                                    countiesSelect.append($('<option>', {
                                        value: response[i].mahalle_id, // İlçe ID'si
                                        text: response[i].mahalle_title, // İlçe adı
                                        selected : (response[i].mahalle_id == countyId ? true : false) 
                                    }));
                                }
                            },
                            error: function(xhr, status, error) {
                                // Hata durumunda çalışacak kod
                                console.error('Hata: ' + error);
                            }
                        });
                    @endif
                },
                error: function(xhr, status, error) {
                    // Hata durumunda çalışacak kod
                    console.error('Hata: ' + error);
                }
            });
        @endif

        $('#cities').change(function(){
            var selectedCity = $(this).val(); // Seçilen şehir değerini al

            // AJAX isteği yap
            $.ajax({
                url: '{{route("client.get.counties")}}', // Endpoint URL'si (get.counties olarak varsayalım)
                method: 'GET',
                data: { city: selectedCity }, // Şehir verisini isteğe ekle
                dataType: 'json', // Yanıtın JSON formatında olduğunu belirt
                success: function(response) {
                    // Yanıt başarılı olduğunda çalışacak kod
                    var countiesSelect = $('#counties'); // counties id'li select'i seç
                    countiesSelect.empty(); // Select içeriğini temizle

                    // Dönen yanıttaki ilçeleri döngüyle ekleyin
                    for (var i = 0; i < response.length; i++) {
                        countiesSelect.append($('<option>', {
                            value: response[i].ilce_key, // İlçe ID'si
                            text: response[i].ilce_title, // İlçe adı
                            key_x: response[i].key_x,
                        }));
                    }

                    
                },
                error: function(xhr, status, error) {
                    // Hata durumunda çalışacak kod
                    console.error('Hata: ' + error);
                }
            });
        });
        
        $('#counties').change(function(){
            var selectedCounty = $(this).val(); // Seçilen şehir değerini al
            console.log(selectedCounty);
            var selectedCountyKey = $('#counties option[value="'+selectedCounty+'"]').attr("key_x");
            console.log($('#counties option[value="'+selectedCounty+'"]'));
            // AJAX isteği yap
            $.ajax({
                url: '{{route("client.get.neighbourhood")}}', // Endpoint URL'si (get.counties olarak varsayalım)
                method: 'GET',
                data: { county_id: selectedCounty }, // Şehir verisini isteğe ekle
                dataType: 'json', // Yanıtın JSON formatında olduğunu belirt
                success: function(response) {
                    // Yanıt başarılı olduğunda çalışacak kod
                    var countiesSelect = $('#neighbourhood'); // counties id'li select'i seç
                    countiesSelect.empty(); // Select içeriğini temizle

                    // Dönen yanıttaki ilçeleri döngüyle ekleyin
                    for (var i = 0; i < response.length; i++) {
                        countiesSelect.append($('<option>', {
                            value: response[i].mahalle_id, // İlçe ID'si
                            text: response[i].mahalle_title // İlçe adı
                        }));
                    }
                },
                error: function(xhr, status, error) {
                    // Hata durumunda çalışacak kod
                    console.error('Hata: ' + error);
                }
            });
        });
    </script>
    <script src="//cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');

        CKEDITOR.on('instanceReady', function (ev) {
            var editor = ev.editor;
            editor.on('change', function (event) {
                var editorContent = editor.getData();
                descriptionText = editorContent;
                if(editorContent == ""){
                }else{
                    $('.description-field .error-text').remove();
                    editor.document.$.body.style.backgroundColor = 'white';
                }

                var formData = new FormData();
                var csrfToken = $("meta[name='csrf-token']").attr("content");
                formData.append('_token', csrfToken);
                formData.append('value',editorContent);
                formData.append('key',"description");
                formData.append('item_type',2);
                $.ajax({
                    type: "POST",
                    url: "{{route('client.temp.order.data.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                    },
                });
            });
        });

        

        $('.finish-button').click(function(e){
            e.preventDefault();
            var next = true;
            var topError = 0;
            if(!$('input[name="name"]').val()){
                next = false;
                $('input[name="name"]').addClass('error-border')
                topError = $('input[name="name"]').offset().top - parseFloat($('.navbar-top').css('height')) - 100;
            }

            if(!$('#housing_status').val()){
                next = false;
                if(topError){
                    if($('.statue-text').offset().top - parseFloat($('.navbar-top').css('height')) - 100 < topError){
                        topError = $('.statue-text').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                    }
                }else{
                    topError = $('.statue-text').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                }
                $('.statue-text .error-text').remove();
                $('.statue-text').append('<span class="error-text">Konut statüsü seçmek zorunludur</span>')
            }

            if(!$('#location').val()){
                next = false;
                if(topError){
                    if($('#location').parent('div').offset().top - parseFloat($('.navbar-top').css('height')) - 100 < topError){
                        topError = $('#location').parent('div').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                    }
                }else{
                    topError = $('#location').parent('div').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                }
                $('#location').parent('div').find('.error-text').remove();
                $('#location').parent('div').append('<span class="error-text">Haritadan konum seçmek zorunludur</span>')
            }

            if(!$('.rules_confirm').is(':checked')){
                next = false;

                if(topError){
                    if($('.finish-tick').offset().top - parseFloat($('.navbar-top').css('height')) - 100 < topError){
                        topError = $('.finish-tick').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                    }
                }else{
                    topError = $('.finish-tick').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                }
                $('.finish-tick').addClass('error-border')
            }

            if(descriptionText == ""){
                next = false;
                if(topError){
                    if($('.description-field').offset().top - parseFloat($('.navbar-top').css('height')) - 100 < topError){
                        topError = $('.description-field').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                    }
                }else{
                    topError = $('.description-field').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                }
                $('.description-field .error-text').remove();
                $('.description-field').append('<span class="error-text">Açıklama metnini girmek zorunludur</span>')
            }

            $('.tab-pane.active input[required="required"]').map((key,item) => {
                if(!$(item).val()){
                    next = false;

                    if(topError){
                        if($(item).offset().top - parseFloat($('.navbar-top').css('height')) - 100 < topError){
                            topError = $(item).offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                        }
                    }else{
                        topError = $(item).offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                    }
                    $(item).addClass("error-border")
                }
            })

            $('.tab-pane.active select[required="required"]').map((key,item) => {
                if(!$(item).val()){
                    next = false;
                    if(topError){
                        if($(item).offset().top - parseFloat($('.navbar-top').css('height')) - 100 < topError){
                            topError = $(item).offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                        }
                    }else{
                        topError = $(item).offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                    }
                    $(item).addClass("error-border")
                }
            })

            if($('.photos .project_imagex').length == 0){
                next = false;
                if(topError){
                    if($('.photo-area').offset().top - parseFloat($('.navbar-top').css('height')) - 100 < topError){
                        topError = $('.photo-area').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                    }
                }else{
                    topError = $('.photo-area').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                }
                $('.photo-area').addClass('error-border')
            }

            if($('.cover-photo .project_imagex').length == 0){
                next = false;
                if(topError){
                    if($('.cover-photo').offset().top - parseFloat($('.navbar-top').css('height')) - 100 < topError){
                        topError = $('.cover-photo').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                    }
                }else{
                    topError = $('.cover-photo').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                }
                $('.cover-photo-area').addClass('error-border')
            }

            if($('.cover-document .has_file').length == 0){
                next = false;
                if(topError){
                    if($('.cover-document-area').offset().top - parseFloat($('.navbar-top').css('height')) - 100 < topError){
                        topError = $('.cover-document-area').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                    }
                }else{
                    topError = $('.cover-document-area').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                }
                $('.cover-document-area').addClass('error-border')
            }
            
            if(!$('select[name="city_id"]').val()){
                next = false;
                if(topError){
                    if($('select[name="city_id"]').offset().top - parseFloat($('.navbar-top').css('height')) - 100 < topError){
                        topError = $('select[name="city_id"]').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                    }
                }else{
                    topError = $('select[name="city_id"]').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                }
                $('select[name="city_id"]').addClass('error-border')
            }

            if(!$('select[name="county_id"]').val()){
                next = false;
                if(topError){
                    if($('select[name="county_id"]').offset().top - parseFloat($('.navbar-top').css('height')) - 100 < topError){
                        topError = $('select[name="county_id"]').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                    }
                }else{
                    topError = $('select[name="county_id"]').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                }
                $('select[name="county_id"]').addClass('error-border')
            }

            if(!$('select[name="neighbourhood_id"]').val()){
                next = false;
                if(topError){
                    if($('select[name="neighbourhood_id"]').offset().top - parseFloat($('.navbar-top').css('height')) - 100 < topError){
                        topError = $('select[name="neighbourhood_id"]').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                    }
                }else{
                    topError = $('select[name="neighbourhood_id"]').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                }
                $('select[name="neighbourhood_id"]').addClass('error-border')
            }
            if($('.pricing-item-first .price-radio.select').length == 0){
                next = false;
                if(topError){
                    if($('.pricing-select-first').offset().top - parseFloat($('.navbar-top').css('height')) - 100 < topError){
                        topError = $('.pricing-select-first').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                    }
                }else{
                    topError = $('.pricing-select-first').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                }
                $('.pricing-select-first .error-text').remove();
                $('.pricing-select-first').append("<p class='error-text'>İlan süresini seçmeniz gerekmektedir</p>")
            }

            if($('.pricing-item-first .price-radio.select').length > 0){
                if($('.single-price-project-area .pricing-item .price-radio.select').length == 0){
                    if(topError){
                        if($('.single-price-project-area').offset().top - parseFloat($('.navbar-top').css('height')) - 100 < topError){
                            topError = $('.single-price-project-area').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                        }
                    }else{
                        topError = $('.single-price-project-area').offset().top - parseFloat($('.navbar-top').css('height')) - 100; 
                    }
                    $('.single-price-project-area .error-text').remove();
                    $('.single-price-project-area').append("<p class='error-text'>İlan süresini seçmeniz gerekmektedir</p>")
                }
            }

            if(next){
                nextTemp = true;
                $.ajax({
                    method: "POST",
                    url: "{{route('client.change.step.order')}}",
                    data : {
                        order : 3,
                        item_type : 2,
                        _token : csrfToken
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        if(response.status){
                            $('.firt-area').addClass('d-none');
                            $('.second-area').addClass('d-none');
                            $('.third-area').addClass('d-none');
                            $('.progress-line').removeClass('step1')
                            $('.progress-line').removeClass('step2')
                            $('.progress-line').removeClass('step3')
                            $('.third-area').removeClass('d-none');
                            $('.progress-line').addClass('step3')
                            $('.progress-line li').eq(0).removeClass('current').addClass('done')
                            $('.progress-line li').eq(1).removeClass('current').addClass('done')
                            $('.progress-line li').eq(2).addClass('current')
                        }
                        
                    }
                })
            }else{
                nextTemp = false;
                $('html, body').animate({
                    scrollTop: topError
                }, 100);
            }
        })
        var itemOrder = 0;
        var itemSlug = "";
        var areasSlugs = [];
        @if(isset($tempData->step1_slug))
            itemSlug = "{{$tempData->step1_slug}}";
            itemOrder = 0;
            listChangex()
        @endif

        
        @if(isset($tempData->step2_slug))
            itemSlug = "{{$tempData->step2_slug}}";
            itemOrder = 1;
            listChangex()
        @endif

        @if(isset($tempData->step3_slug))
            itemSlug = "{{$tempData->step3_slug}}";
            itemOrder = 2;
            listChangex()
        @endif

        function listChangex(){
            $.ajax({
                url: "{{URL::to('/')}}/hesabim/get_housing_type_childrens/"+itemSlug, // AJAX isteği yapılacak URL
                type: "GET", // GET isteği
                dataType: "json", // Gelen veri tipi JSON
                success: function (data) {
                    data = data.data;
                    var list = "";
                    for(var i = 0 ; i < data.length; i++){
                        list += "<li slug='"+data[i].slug+"'>"+data[i].title+"</li>"
                    }
                    $('.area-list').eq(itemOrder + 1).children('ul').html(list)

                    $('.area-list li').click(function(){
                        var clickItem = $(this).closest('.area-list');
                        itemOrder = clickItem.index();
                        itemSlug = $(this).attr('slug')
                        listChange();
                        $('.area-list li').click( function () {
                            var clickItem = $(this).closest('.area-list');
                            var itemOrderx = clickItem.index();
                            if(itemOrderx == 2){
                                if(selectedid){
                                    $('.rendered-area').removeClass('d-none')
                                }else{
                                    $.toast({
                                        heading: 'Hata',
                                        text: 'Proje Hangi Tipte Konutlardan Oluşuyor Seçeneğini Lütfen Seçiniz',
                                        position: 'top-right',
                                        stack: false
                                    })
                                }
                                const houseCount = 1;

                                if (isNaN(houseCount) || houseCount <= 0) {
                                    alert('Lütfen geçerli bir sayı girin.');
                                    return;
                                }


                                $.ajax({
                                    method: "GET",
                                    url: "{{ route('client.ht.getform') }}",
                                    data: {
                                        id: selectedid
                                    },
                                    success: function(response) {
                                        var html = "";
                                        var htmlContent = "";
                                        for(var i = 0 ; i < houseCount; i++ ){

                                            htmlContent += '<div class="tab-pane fade show '+(i == 0 ? 'active' : '')+'" id="TabContent'+(i+1)+'" role="tabpanel">'+
                                                '<div id="renderForm'+(i+1)+'" class="card p-4"></div>'+
                                            '</div>';
                                        }

                                        $('#tablist').html(html);
                                        $('.tab-content').html(htmlContent)
                                        for (let i = 1; i <= houseCount; i++) {
                                            console.log(i);
                                            formRenderOpts = {
                                                dataType: 'json',
                                                formData: response.form_json
                                            };

                                            var renderedForm = $('<div>');
                                            renderedForm.formRender(formRenderOpts);
                                            var renderHtml = renderedForm.html().toString();
                                            renderHtml = renderHtml.toString().split('images[][]');
                                            var json = JSON.parse(response.form_json);
                                            renderHtml = renderHtml[0]+'images'+i+'[][]'+renderHtml[1];
                                            for(var lm = 0 ; lm < json.length; lm++){
                                                if(json[lm].type == "checkbox-group"){
                                                    console.log();
                                                    var renderHtml = renderHtml.toString().split(json[lm].name+'[]');
                                                    renderHtmlx = "";
                                                    var json = JSON.parse(response.form_json);
                                                    for(var t = 0 ; t < renderHtml.length ; t++){
                                                        if(t != renderHtml.length - 1){
                                                            renderHtmlx += renderHtml[t]+(json[lm].name.split('[]')[0])+i+'[][]';
                                                        }else{
                                                            renderHtmlx += renderHtml[t];
                                                        }
                                                    }

                                                    renderHtml = renderHtmlx;
                                                }
                                                
                                                $('.checkbox-item').closest('.checkbox-group').addClass('d-flex')
                                                $('.checkbox-item').closest('.checkbox-group').addClass('checkbox-items')
                                            }

                                            $('#renderForm'+(i)).html(renderHtml);
                                            $('#tablist a.nav-link').click(function(e) {
                                                e.preventDefault(); // Linki tıklamayı engelleyin

                                                // Tüm sekmeleri gizleyin
                                                $('.tab-content .tab-pane').removeClass('show active');

                                                // Tıklanan tab linkine ait tabın kimliğini alın
                                                var tabId = $(this).attr('data-bs-target');

                                                // İlgili tabı gösterin
                                                $(tabId).addClass('show active');
                                            });
                                        }

                                        $('.next_house').click(function(){
                                            var nextHousing = true;
                                            $('.tab-pane.active input[required="required"]').map((key,item) => {
                                                if(!$(item).val()){
                                                    nextHousing = false;
                                                    $(item).addClass("error-border")
                                                }
                                            })

                                            $('.tab-pane.active select[required="required"]').map((key,item) => {
                                                if(!$(item).val()){
                                                    nextHousing = false;
                                                    $(item).addClass("error-border")
                                                }
                                            })
                                            if($('.tab-pane.active input[required="required"]').val() == ""){
                                                nextHousing = false;
                                                $('.tab-pane.active input[name="price[]"]').addClass('error-border')
                                            }
                                            var indexItem = $('.tab-pane.active').index();
                                            if(nextHousing){
                                                $('.tab-pane.active').removeClass('active');
                                                $('.tab-pane').eq(indexItem + 1).addClass('active');
                                            }else{
                                                $('html, body').animate({
                                                    scrollTop: $('.tab-pane.active').offset().top - parseFloat($('.navbar-top').css('height'))
                                                }, 100);
                                            }
                                        })

                                        $('.prev_house').click(function(){
                                            
                                            var indexItem = $('.tab-pane.active').index();
                                            console.log(indexItem);
                                            $('.tab-pane.active').removeClass('active');
                                            $('.tab-pane').eq(indexItem - 1).addClass('active');
                                        })

                                        $('.copy-item').change(function(){
                                            var order = parseInt($(this).val()) - 1;
                                            var currentOrder = parseInt($(this).closest('a').attr('data-bs-target').replace('#TabContent','')) - 1;
                                            for(var lm = 0 ; lm < json.length; lm++){
                                                if(json[lm].type == "checkbox-group"){
                                                for(var i = 0 ; i < json[lm].values.length; i++){
                                                    var isChecked = $('input[name="'+(json[lm].name.replace('[]',''))+(order+1  )+'[][]"][value="'+json[lm].values[i].value+'"]'+'').is(':checked')
                                                    if(isChecked){
                                                    $('input[name="'+(json[lm].name.replace('[]',''))+(currentOrder+1  )+'[][]"][value="'+json[lm].values[i].value+'"]'+'').attr('checked','checked')
                                                    }else{
                                                    $('input[name="'+(json[lm].name.replace('[]',''))+(currentOrder+1  )+'[][]"][value="'+json[lm].values[i].value+'"]'+'').removeAttr('checked')
                                                    }
                                                }
                                                }else if(json[lm].type == "select"){
                                                var value = $('select[name="'+(json[lm].name)+'"]').eq(order).val();
                                                $('select[name="'+(json[lm].name)+'"]').eq(currentOrder).children('option').removeAttr('selected')
                                                $('select[name="'+(json[lm].name)+'"]').eq(currentOrder).children('option[value="'+value[0]+'"]').attr('selected','selected');
                                                }else if(json[lm].type == "file" && json[lm].name == "image[]"){
                                                var files = $('input[name="'+(json[lm].name)+'"]').eq(order)[0].files;
                                                var input2 = $('input[name="'+(json[lm].name)+'"]').eq(currentOrder);
                                                for (var i = 0; i < files.length; i++) {
                                                    var file = files[i];
                                                    input2.prop("files",files);
                                                }
                                                }else if(json[lm].type == "file" && json[lm].name != "image[]"){
                                                var files = $('input[name="'+(json[lm].name.replace('[]',''))+(order+1)+'[][]"]')[0].files;
                                                var input2 = $('input[name="'+(json[lm].name.replace('[]',''))+(currentOrder+1)+'[][]"]');
                                                for (var i = 0; i < files.length; i++) {
                                                    var file = files[i];
                                                    input2.prop("files",files);
                                                }
                                                }else if(json[lm].type != "file"){
                                                var value = $('input[name="'+(json[lm].name)+'"]').eq(order).val();
                                                console.log($('input[name="'+(json[lm].name)+'"]').eq(currentOrder));
                                                $('input[name="'+(json[lm].name)+'"]').eq(currentOrder).attr("value",value);
                                                }
                                            }
                                        })

                                        $('.rendered-form input').change(function(){
                                            console.log("asd");
                                            var formData = new FormData();
                                            var csrfToken = $("meta[name='csrf-token']").attr("content");
                                            formData.append('_token', csrfToken);
                                            formData.append('value',$(this).val());
                                            formData.append('order',parseInt($(this).closest('.tab-pane').attr('id').replace('TabContent',"")) - 1);
                                            formData.append('key',$(this).attr('name').replace("[]", "").replace("[]", ""));
                                            formData.append('item_type',2);
                                            if($(this).attr('type') == "checkbox"){
                                                formData.append('checkbox',"1");
                                            }
                                            $.ajax({
                                                type: "POST",
                                                url: "{{route('client.temp.order.project.housing.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                                data: formData,
                                                processData: false,
                                                contentType: false,
                                                success: function(response) {
                                                },
                                            });
                                        })

                                        $('.rendered-form select').change(function(){
                                            console.log("asd");
                                            var formData = new FormData();
                                            var csrfToken = $("meta[name='csrf-token']").attr("content");
                                            formData.append('_token', csrfToken);
                                            formData.append('value',$(this).val());
                                            console.log($(this).closest('.tab-pane').attr('id'))
                                            formData.append('order',parseInt($(this).closest('.tab-pane').attr('id').replace('TabContent',"")) - 1);
                                            formData.append('key',$(this).attr('name').replace("[]", ""));
                                            formData.append('item_type',2);
                                            $.ajax({
                                                type: "POST",
                                                url: "{{route('client.temp.order.project.housing.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                                data: formData,
                                                processData: false,
                                                contentType: false,
                                                success: function(response) {
                                                },
                                            });
                                        })

                                        $('.dropzonearea').closest('.formbuilder-file').remove();

                                        $('.price-only').keyup(function(){
                                            $('.price-only .error-text').remove();
                                            if($('.price-only').val() != parseFloat($('.price-only').val())){
                                                if($('.price-only').closest('.form-group').find('.error-text').length > 0){
                                                    $('.price-only').val("");
                                                }else{
                                                    $(this).closest('.form-group').append('<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                                                    $('.price-only').val("");
                                                }
                                                
                                            }else{
                                                $(this).closest('.form-group').find('.error-text').remove();
                                            }
                                        })

                                        $('.number-only').keyup(function(){
                                            $('.number-only .error-text').remove();
                                            if($(this).val() != parseInt($(this).val())){
                                                if($(this).closest('.form-group').find('.error-text').length > 0){
                                                    $(this).val("");
                                                }else{
                                                    $(this).closest('.form-group').append('<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                                                    $(this).val("");
                                                }
                                                
                                            }else{
                                                $(this).closest('.form-group').find('.error-text').remove();
                                            }
                                        })

                                        $('.formbuilder-text input').change(function(){
                                            if($(this).val() != ""){
                                                $(this).removeClass('error-border')
                                            }
                                        })

                                        $('.formbuilder-number input').change(function(){
                                            if($(this).val() != ""){
                                                $(this).removeClass('error-border')
                                            }
                                        })
                                    },
                                    error: function(error) {
                                        console.log(error)
                                    }
                                })
                            }
                            
                            // Belirtilen sayıda sekme oluştur

                        });
                    })

                },
                error: function (xhr, status, error) {
                    // İstek hata verdiğinde çalışacak fonksiyon
                    console.error(xhr.statusText);
                }
            });
            if(areasSlugs.filter((slug) => {return slug.order == itemOrder}).length == 0){
                areasSlugs.push(
                    {
                        order : itemOrder,
                        slug : itemSlug,
                        label : $("li[slug='"+itemSlug+"']").html()
                    }
                );
            }else{
                if(areasSlugs.filter((slug) => {return slug.order == itemOrder})[0].slug != itemSlug){
                    areasSlugs[itemOrder].slug = itemSlug;
                    var tempItems = [];
                    for(var i = 0 ; i < areasSlugs.length; i++ ){
                        if(areasSlugs[i].order <= itemOrder){
                            tempItems[i] = areasSlugs[i];
                        }
                    }

                    areasSlugs = tempItems;
                }
                
            }

            $('.area-list').find('li').removeClass('selected');
            $('.breadcrumb-after-item').remove();
            for(var i = 0 ; i < areasSlugs.length; i++){
                $('.area-list').eq(i).addClass('active');
                $('.breadcrumb').append('<span class="breadcrumb-after-item">'+areasSlugs[i].label+'</span>')
                $('.area-list').eq(i).find('li').removeClass('selected');
                $("li[slug='"+areasSlugs[i].slug+"']").addClass('selected');
            }

            for(var i = 0; i < $('.area-list').length; i++){
                if(i  > areasSlugs.length){
                    $('.area-list').eq(i).removeClass('active');
                }else{
                    $('.area-list').eq(i).addClass('active');
                }
            }
        }

        function listChange(){
            
            changeData(itemSlug,'step'+(itemOrder+1)+'_slug')
            $.ajax({
                url: "{{URL::to('/')}}/hesabim/get_housing_type_childrens/"+itemSlug, // AJAX isteği yapılacak URL
                type: "GET", // GET isteği
                dataType: "json", // Gelen veri tipi JSON
                success: function (data) {
                    data = data.data;
                    var list = "";
                    for(var i = 0 ; i < data.length; i++){
                        list += "<li slug='"+data[i].slug+"'>"+data[i].title+"</li>"
                    }
                    $('.area-list').eq(itemOrder + 1).children('ul').html(list)

                    $('.area-list li').click(function(){
                        var clickItem = $(this).closest('.area-list');
                        itemOrder = clickItem.index();
                        itemSlug = $(this).attr('slug')
                        if(itemOrder == 2){
                            $.ajax({
                                url: "{{URL::to('/')}}/hesabim/get_housing_type_id/"+itemSlug, // AJAX isteği yapılacak URL
                                type: "GET", // GET isteği
                                dataType: "json", // Gelen veri tipi JSON
                                success: function (data) {
                                    changeData(data,'housing_type_id');
                                    selectedid = data;

                                    const houseCount = 1;

                                if (isNaN(houseCount) || houseCount <= 0) {
                                    alert('Lütfen geçerli bir sayı girin.');
                                    return;
                                }
                                
                                $.ajax({
                                    method: "GET",
                                    url: "{{ route('client.ht.getform') }}",
                                    data: {
                                        id: selectedid
                                    },
                                    success: function(response) {
                                        var html = "";
                                        var htmlContent = "";
                                        for(var i = 0 ; i < houseCount; i++ ){

                                            htmlContent += '<div class="tab-pane fade show '+(i == 0 ? 'active' : '')+'" id="TabContent'+(i+1)+'" role="tabpanel">'+
                                                '<div id="renderForm'+(i+1)+'" class="card p-4"></div>'+
                                            '</div>';
                                        }

                                        $('#tablist').html(html);
                                        $('.tab-content').html(htmlContent)
                                        for (let i = 1; i <= houseCount; i++) {
                                            console.log(i);
                                            formRenderOpts = {
                                                dataType: 'json',
                                                formData: response.form_json
                                            };

                                            var renderedForm = $('<div>');
                                            renderedForm.formRender(formRenderOpts);
                                            var renderHtml = renderedForm.html().toString();
                                            renderHtml = renderHtml.toString().split('images[][]');
                                            var json = JSON.parse(response.form_json);
                                            renderHtml = renderHtml[0]+'images'+i+'[][]'+renderHtml[1];
                                            for(var lm = 0 ; lm < json.length; lm++){
                                                if(json[lm].type == "checkbox-group"){
                                                    console.log();
                                                    var renderHtml = renderHtml.toString().split(json[lm].name+'[]');
                                                    renderHtmlx = "";
                                                    var json = JSON.parse(response.form_json);
                                                    for(var t = 0 ; t < renderHtml.length ; t++){
                                                        if(t != renderHtml.length - 1){
                                                            renderHtmlx += renderHtml[t]+(json[lm].name.split('[]')[0])+i+'[][]';
                                                        }else{
                                                            renderHtmlx += renderHtml[t];
                                                        }
                                                    }

                                                    renderHtml = renderHtmlx;
                                                }
                                                
                                                $('.checkbox-item').closest('.checkbox-group').addClass('d-flex')
                                                $('.checkbox-item').closest('.checkbox-group').addClass('checkbox-items')
                                            }

                                            $('#renderForm'+(i)).html(renderHtml);
                                            $('#tablist a.nav-link').click(function(e) {
                                                e.preventDefault(); // Linki tıklamayı engelleyin

                                                // Tüm sekmeleri gizleyin
                                                $('.tab-content .tab-pane').removeClass('show active');

                                                // Tıklanan tab linkine ait tabın kimliğini alın
                                                var tabId = $(this).attr('data-bs-target');

                                                // İlgili tabı gösterin
                                                $(tabId).addClass('show active');
                                            });
                                        }

                                        $('.next_house').click(function(){
                                            var nextHousing = true;
                                            $('.tab-pane.active input[required="required"]').map((key,item) => {
                                                if(!$(item).val()){
                                                    nextHousing = false;
                                                    $(item).addClass("error-border")
                                                }
                                            })

                                            $('.tab-pane.active select[required="required"]').map((key,item) => {
                                                if(!$(item).val()){
                                                    nextHousing = false;
                                                    $(item).addClass("error-border")
                                                }
                                            })
                                            if($('.tab-pane.active input[required="required"]').val() == ""){
                                                nextHousing = false;
                                                $('.tab-pane.active input[name="price[]"]').addClass('error-border')
                                            }
                                            var indexItem = $('.tab-pane.active').index();
                                            if(nextHousing){
                                                $('.tab-pane.active').removeClass('active');
                                                $('.tab-pane').eq(indexItem + 1).addClass('active');
                                            }else{
                                                $('html, body').animate({
                                                    scrollTop: $('.tab-pane.active').offset().top - parseFloat($('.navbar-top').css('height'))
                                                }, 100);
                                            }
                                        })

                                        $('.prev_house').click(function(){
                                            
                                            var indexItem = $('.tab-pane.active').index();
                                            console.log(indexItem);
                                            $('.tab-pane.active').removeClass('active');
                                            $('.tab-pane').eq(indexItem - 1).addClass('active');
                                        })

                                        $('.copy-item').change(function(){
                                            var order = parseInt($(this).val()) - 1;
                                            var currentOrder = parseInt($(this).closest('a').attr('data-bs-target').replace('#TabContent','')) - 1;
                                            for(var lm = 0 ; lm < json.length; lm++){
                                                if(json[lm].type == "checkbox-group"){
                                                for(var i = 0 ; i < json[lm].values.length; i++){
                                                    var isChecked = $('input[name="'+(json[lm].name.replace('[]',''))+(order+1  )+'[][]"][value="'+json[lm].values[i].value+'"]'+'').is(':checked')
                                                    if(isChecked){
                                                    $('input[name="'+(json[lm].name.replace('[]',''))+(currentOrder+1  )+'[][]"][value="'+json[lm].values[i].value+'"]'+'').attr('checked','checked')
                                                    }else{
                                                    $('input[name="'+(json[lm].name.replace('[]',''))+(currentOrder+1  )+'[][]"][value="'+json[lm].values[i].value+'"]'+'').removeAttr('checked')
                                                    }
                                                }
                                                }else if(json[lm].type == "select"){
                                                var value = $('select[name="'+(json[lm].name)+'"]').eq(order).val();
                                                $('select[name="'+(json[lm].name)+'"]').eq(currentOrder).children('option').removeAttr('selected')
                                                $('select[name="'+(json[lm].name)+'"]').eq(currentOrder).children('option[value="'+value[0]+'"]').attr('selected','selected');
                                                }else if(json[lm].type == "file" && json[lm].name == "image[]"){
                                                var files = $('input[name="'+(json[lm].name)+'"]').eq(order)[0].files;
                                                var input2 = $('input[name="'+(json[lm].name)+'"]').eq(currentOrder);
                                                for (var i = 0; i < files.length; i++) {
                                                    var file = files[i];
                                                    input2.prop("files",files);
                                                }
                                                }else if(json[lm].type == "file" && json[lm].name != "image[]"){
                                                var files = $('input[name="'+(json[lm].name.replace('[]',''))+(order+1)+'[][]"]')[0].files;
                                                var input2 = $('input[name="'+(json[lm].name.replace('[]',''))+(currentOrder+1)+'[][]"]');
                                                for (var i = 0; i < files.length; i++) {
                                                    var file = files[i];
                                                    input2.prop("files",files);
                                                }
                                                }else if(json[lm].type != "file"){
                                                var value = $('input[name="'+(json[lm].name)+'"]').eq(order).val();
                                                console.log($('input[name="'+(json[lm].name)+'"]').eq(currentOrder));
                                                $('input[name="'+(json[lm].name)+'"]').eq(currentOrder).attr("value",value);
                                                }
                                            }
                                        })

                                        $('.rendered-form input').change(function(){
                                            console.log("asd");
                                            var formData = new FormData();
                                            var csrfToken = $("meta[name='csrf-token']").attr("content");
                                            formData.append('_token', csrfToken);
                                            formData.append('value',$(this).val());
                                            formData.append('order',parseInt($(this).closest('.tab-pane').attr('id').replace('TabContent',"")) - 1);
                                            formData.append('key',$(this).attr('name').replace("[]", "").replace("[]", ""));
                                            formData.append('item_type',2);
                                            if($(this).attr('type') == "checkbox"){
                                                formData.append('checkbox',"1");
                                            }
                                            $.ajax({
                                                type: "POST",
                                                url: "{{route('client.temp.order.project.housing.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                                data: formData,
                                                processData: false,
                                                contentType: false,
                                                success: function(response) {
                                                },
                                            });
                                        })

                                        $('.rendered-form select').change(function(){
                                            console.log("asd");
                                            var formData = new FormData();
                                            var csrfToken = $("meta[name='csrf-token']").attr("content");
                                            formData.append('_token', csrfToken);
                                            formData.append('value',$(this).val());
                                            console.log($(this).closest('.tab-pane').attr('id'))
                                            formData.append('order',parseInt($(this).closest('.tab-pane').attr('id').replace('TabContent',"")) - 1);
                                            formData.append('key',$(this).attr('name').replace("[]", ""));
                                            formData.append('item_type',2);
                                            $.ajax({
                                                type: "POST",
                                                url: "{{route('client.temp.order.project.housing.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                                data: formData,
                                                processData: false,
                                                contentType: false,
                                                success: function(response) {
                                                },
                                            });
                                        })

                                        $('.dropzonearea').closest('.formbuilder-file').remove();
                                        $('.cover-image-by-housing-type').closest('.formbuilder-file').remove();

                                        $('.price-only').keyup(function(){
                                            $('.price-only .error-text').remove();
                                            if($('.price-only').val() != parseFloat($('.price-only').val())){
                                                if($('.price-only').closest('.form-group').find('.error-text').length > 0){
                                                    $('.price-only').val("");
                                                }else{
                                                    $(this).closest('.form-group').append('<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                                                    $('.price-only').val("");
                                                }
                                                
                                            }else{
                                                $(this).closest('.form-group').find('.error-text').remove();
                                            }
                                        })

                                        $('.number-only').keyup(function(){
                                            $('.number-only .error-text').remove();
                                            if($(this).val() != parseInt($(this).val())){
                                                if($(this).closest('.form-group').find('.error-text').length > 0){
                                                    $(this).val("");
                                                }else{
                                                    $(this).closest('.form-group').append('<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                                                    $(this).val("");
                                                }
                                                
                                            }else{
                                                $(this).closest('.form-group').find('.error-text').remove();
                                            }
                                        })

                                        $('.formbuilder-text input').change(function(){
                                            if($(this).val() != ""){
                                                $(this).removeClass('error-border')
                                            }
                                        })

                                        $('.formbuilder-number input').change(function(){
                                            if($(this).val() != ""){
                                                $(this).removeClass('error-border')
                                            }
                                        })
                                    },
                                    error: function(error) {
                                        console.log(error)
                                    }
                                })
                                }
                            })

                            
                            var clickItem = $(this).closest('.area-list');
                            var itemOrderx = clickItem.index();
                            if(itemOrderx == 2){
                                if(selectedid){
                                    $('.rendered-area').removeClass('d-none')
                                }else{
                                    $.toast({
                                        heading: 'Hata',
                                        text: 'Proje Hangi Tipte Konutlardan Oluşuyor Seçeneğini Lütfen Seçiniz',
                                        position: 'top-right',
                                        stack: false
                                    })
                                }
                                
                            }
                            
                            // Belirtilen sayıda sekme oluştur

                        
                        }
                        listChange();
                    })
                },
                error: function (xhr, status, error) {
                    // İstek hata verdiğinde çalışacak fonksiyon
                    console.error(xhr.statusText);
                }
            });
            if(areasSlugs.filter((slug) => {return slug.order == itemOrder}).length == 0){
                areasSlugs.push(
                    {
                        order : itemOrder,
                        slug : itemSlug,
                        label : $("li[slug='"+itemSlug+"']").html()
                    }
                );
            }else{
                if(areasSlugs.filter((slug) => {return slug.order == itemOrder})[0].slug != itemSlug){
                    areasSlugs[itemOrder].slug = itemSlug;
                    var tempItems = [];
                    for(var i = 0 ; i < areasSlugs.length; i++ ){
                        if(areasSlugs[i].order <= itemOrder){
                            tempItems[i] = areasSlugs[i];
                        }
                    }

                    areasSlugs = tempItems;
                }
                
            }

            $('.area-list').find('li').removeClass('selected');
            $('.breadcrumb-after-item').remove();
            for(var i = 0 ; i < areasSlugs.length; i++){
                $('.area-list').eq(i).addClass('active');
                $('.breadcrumb').append('<span class="breadcrumb-after-item">'+areasSlugs[i].label+'</span>')
                $('.area-list').eq(i).find('li').removeClass('selected');
                $("li[slug='"+areasSlugs[i].slug+"']").addClass('selected');
            }

            for(var i = 0; i < $('.area-list').length; i++){
                if(i  > areasSlugs.length){
                    $('.area-list').eq(i).removeClass('active');
                }else{
                    $('.area-list').eq(i).addClass('active');
                }
            }
        }

        $('.area-list li').click(function(){
            var clickItem = $(this).closest('.area-list');
            itemOrder = clickItem.index();
            itemSlug = $(this).attr('slug')
            listChange();
        })
    </script>
    <script>
        
        var $select = $('#housing_status').selectize();
        var selectize = $select[0].selectize;
        selectize.on('item_click', function(item) {
            console.log("asd");
            selectize.removeItem(item);
        });



        $('#housing_status').change(function(){
            var value = $(this).val();
            var html = "<option value=''>Statü Seç</option>";
            for(var i = 0 ; i < value.length; i++){
                html += "<option value='"+value[i]+"'>"+($('#housing_status option[value="'+value[i]+'"]').html())+"</option>";
            }
            $('.doping_statuses').html(html);
            var key = "statuses";
            var isArray = 1; 
            var formData = new FormData();
            var csrfToken = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', csrfToken);
            formData.append('value',value);
            formData.append('key',key);
            formData.append('item_type',2);
            formData.append('array_data',isArray);
            $.ajax({
                type: "POST",
                url: "{{route('client.temp.order.data.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                },
            });
        })

        changeData($('#location').val(),"location")
    </script>
    @stack('scripts')
@endsection


@section('styles')
    <link rel="stylesheet" href="{{ asset('css/account.css') }}" />
    
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.css"/>
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/assets/css/daterangepicker.css">
    <link href="{{ URL::to('/') }}/adminassets/assets/css/theme.min.css" type="text/css" rel="stylesheet"
        id="style-default">
    <link href="{{ URL::to('/') }}/adminassets/assets/css/user-rtl.min.css" type="text/css" rel="stylesheet"
        id="user-style-rtl">
    <link href="{{ URL::to('/') }}/adminassets/assets/css/client.min.css" type="text/css" rel="stylesheet"
        id="user-style-default">
        <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/assets/css/leaflet-locationpicker.src.css" />
        <link href="{{ URL::to('/') }}/adminassets/vendors/leaflet/leaflet.css" rel="stylesheet">
    <link href="{{ URL::to('/') }}/adminassets/vendors/leaflet.markercluster/MarkerCluster.css" rel="stylesheet">
    <link href="{{ URL::to('/') }}/adminassets/vendors/leaflet.markercluster/MarkerCluster.Default.css"
        rel="stylesheet">
    <style>
        .form-control {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem !important;
            font-size: 1.5rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

.dz-preview:hover .dz-remove{
    background-color: #ea2a28;
    cursor: pointer;
    border-radius: 100%;
}

.dz-preview:hover .dz-remove i{
    cursor: pointer;
}

.edit_project_housing_image{
    width: 100px;
    height: 100px;
}

.dropzone2{
    display: flex;
    flex-wrap: wrap;
}

.project_images_area{
    margin: 10px 0;
    margin-right:10px;
    display: flex;
    flex-direction: column;
}

.area-list{
    width: 200px;
    height: 243px;
    margin-right: 10px;
    border: solid 1px #dedede;
    border-radius: 4px;
    position: relative;
    text-align: left;
    vertical-align: top;
    padding: 10px 4px;
    display: none;
}

.area-list ul{
    padding: 0 20px 0 5px;
}

.area-list li{
    cursor: pointer;
    width: 100%;
    height: 20px;
    line-height: 20px;
    padding-left: 5px;
    border-radius: 2px;
    outline: none;
    position: relative;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    font-size: 11px;
    color: #333;
    list-style: none;
}

.area-list li.selected{
    background-color: #dedede;
}

.area-list ul li.selected:before {
    content: '';
    position: absolute;
    top: 3px;
    right: -6px;
    width: 14px;
    height: 14px;
    background-color: #dedede;
    -webkit-transform: rotate(45deg);
    -moz-transform: rotate(45deg);
    -o-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
    border-radius: 2px;
}

.finish-icon-area{
    width: 60px;
    height: 60px;
    color: #fff;
    background: #e54242;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto;
    border-radius: 100%;
    font-size: 30px;
}

.area-list.active{
    display: block;
}

.finish-text p{
    text-align: center;
    font-size: 11px;
    
    margin: 20px 0;
}

.finish-button{
    display: flex;
    justify-content: center;
    margin: 20px 0;
}

.breadcrumb{
    display: flex;
}

.breadcrumb span{
    display: block;
    margin-right: 10px;
}

.breadcrumb-after-item::before{
    content: '>';
    display: inline-block;
    padding: 0 7px 0 0;
}

.thumbnail-second span{
    font-size: 25px;
    
    margin: 5px 0;
    display: block;
}

.form-area .section-title{
    font-size: 25px;
    
    margin: 5px 0;
    display: block;
}

.form-area label{
    font-weight: 700;
    font-size: 13px;
    margin-bottom: 5px;
}

.required{
    color: #EA2B2E;
}

.area-lists{
    display: flex;
}

.breadcrumb-v2{
    align-items: center;
}

.checkbox-items{
    flex-wrap: wrap;
}

.breadcrumb-v2 .breadcrumb-after-item{
    font-size: 13px !important;
    margin-left: 5px;
}

.checkbox-items .formbuilder-checkbox{
    margin-left: 10px;
    display: flex;
    align-items: center;
    width: 23%;
    margin-top: 15px;
}

.checkbox-items .formbuilder-checkbox label{
    margin: 0 !important;
}

.rendered-form label{
    font-weight: bold !important;
}

.pricing-item{
    padding-top: 24px;
    padding-bottom: 24px;
    height: auto;
    width: 296px;
    position: relative;
    background: #fff;
    margin: 5px 5px 0 5px;
    padding: 40px 0 40px 0;
    border: 1px solid #d8d8d8;
    cursor: pointer;
}

.pricing-item-first{
    padding-top: 24px;
    padding-bottom: 24px;
    height: auto;
    width: 296px;
    position: relative;
    background: #fff;
    margin: 5px 5px 0 5px;
    padding: 40px 0 40px 0;
    border: 1px solid #d8d8d8;
    cursor: pointer;
}

.pricing-item-inner{
    display: flex;
    justify-content: center;
    align-items: center;
}

.pricing-item{
    position: relative;
}

.c-pointer{
    cursor: pointer;
}

.remaining_projects{
    position: absolute;
    right: 0;
    top: 0;
}

.old_price:before {
    position: absolute;
    content: "";
    left: 0;
    top: 50%;
    right: 0;
    border-top: 1px solid #f00;
    -webkit-transform: rotate(-10deg);
    -moz-transform: rotate(-10deg);
    -o-transform: rotate(-10deg);
    -ms-transform: rotate(-10deg);
    transform: rotate(-10deg);
}

.old_price{
    font-size: 17px;
    position: relative;
    padding-right: 5px;
    padding-left: 10px;
    vertical-align: middle;
    line-height: 23px;
    color: #9b9b9b;
}

.new_price{
    font-size: 20px;
    line-height: 23px;
    color: #9b9b9b;
    margin-left: 5px;
}

.price{
    margin-top: 20px;
}

.price-radio{
    box-shadow: 1px 2px 2px 0 rgba(0,0,0,0.1) inset;
    border-radius: 100%;
    height: 20px;
    width: 20px;
    border: 1px solid #c0c0c0;
    position: relative;
    display: inline-block;
    left: 0;
    top: 0;
}

.price-radio.select .inside{
    margin: 3px;
    background-color: #da8016;
    width: 13px;
    height: 13px;
    border-radius: 100%;
}

.finish-tick{
    display: inline-block;
    float: right;
    line-height: 31px;
    padding: 7px 20px 7px 15px;
    background-color: #fff;
    border-radius: 2px;
    -webkit-box-shadow: 0 0 2px 0 rgba(0,0,0,0.1);
    box-shadow: 0 0 2px 0 rgba(0,0,0,0.1);
    margin-right: 30px;
}

.rulesOpen{
    color: #e54242;
    cursor: pointer;
    font-weight: normal;
    padding-right: 3px;
}

.second-area-finish{
    display: flex;
    margin-top: 30px;
    justify-content: flex-end;
}

.finish-tick{
    cursor: pointer;
}

.photo-area{
    margin: 0 19px 0 0;
    width: 225px;
    height: 75px;
    border-radius: 2px;
    background-color: #f8f8f8;
    border: dashed 2px #ccc;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.photo-area i{
    font-size: 40px;
    fill: #e54242;
    color : #e54242;
}

.photo-area label {
    color: #e54242;
    width: 50%;
    margin-left: 10px;
    line-height: 17px;
    font-weight: bold !important;
    cursor: pointer;
}

.photo-area label span{
    font-size: 11px;
    color: #999;
    display: block;
    cursor: pointer;
}

.cover-photo-area{
    margin: 0 19px 0 0;
    width: 225px;
    height: 75px;
    border-radius: 2px;
    background-color: #f8f8f8;
    border: dashed 2px #ccc;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.cover-photo-area i{
    font-size: 40px;
    fill: #e54242;
    color : #e54242;
}

.cover-photo-area label {
    color: #e54242;
    width: 50%;
    margin-left: 10px;
    font-weight: bold !important;
    line-height: 17px;
    cursor: pointer;
}

.cover-photo-area label span{
    font-size: 11px;
    color: #999;
    display: block;
    cursor: pointer;
}

.cover-document-area{
    margin: 0 19px 0 0;
    width: 225px;
    height: 75px;
    border-radius: 2px;
    background-color: #f8f8f8;
    border: dashed 2px #ccc;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.cover-document-area i{
    font-size: 40px;
    fill: #e54242;
    color : #e54242;
}

.cover-document-area label {
    color: #e54242;
    width: 50%;
    margin-left: 10px;
    font-weight: bold !important;
    line-height: 17px;
    cursor: pointer;
}

.pricing-item-first h3{
    font-size: 2.5625rem;
}

.cover-document-area label span{
    font-size: 11px;
    color: #999;
    display: block;
    cursor: pointer;
}

.cover-photo{
    margin-top: 20px;
}

.project_imagex{
    text-align: center;
    float: left;
    border: 1px dashed #c8c8c8;
    border-radius: 2px;
    width: 129px;
    height: 97px;
    padding: 0 1px 1px 0;
    margin: 0 10px 10px 0;
    position: relative;
}

.project_imagex img{
    max-width: 100%;
    max-height: 100%;
}

.photos{
    margin-top:20px;
}

.error-border{
    border: solid 1px #f00;
    background-color: #ffeaea;
}

.housing_buttons{
    display: flex;
    justify-content: space-between;
}

.progress-line ol{
    list-style: none;
    height: 60px;
}

.progress-line ol li.done a.step-counter i {
    font-size: 40px;
    height: 40px;
    margin-left: 16px;
    margin-top: -64px;
    color: #e54242;
    line-height: 40px;
    border-radius: 36px;
    display: flex;
    justify-content: center;
    align-items: center;
    top: 50%;
    left: 50%;
    position: absolute;
}

.progress-line ol li.done a.step-counter span{
    position: absolute;
    top: 50%;
    left: 50%;
    z-index: 999;
    color: #fff;
    margin-left: 29px;
    margin-top: -56px;
}

.progress-line ol li a.step-counter span{
    position: absolute;
    top: 50%;
    left: 50%;
    z-index: 999;
    color: #fff;
    margin-left: 14px;
    margin-top: -53px;
    font-size: 16px
}

.progress-line ol:before {
    width: 100%;
    height: 4px;
    content: '';
    background-color: #e54242;
    position: absolute;
    left: 0;
    top: 50%;
    margin-top: -2px;
}

.progress-line {
    position: relative;
    padding: 0;
    margin: 0;
    width: 100%;
}

.progress-line ol li a{
    font-weight: normal;
    color: #999;
    margin-top: 63px;
    display: inline-block;
    text-decoration: none;
}

.progress-line ol li {
    float: left;
    width: 25%;
    text-align: center;
    padding: 0;
    margin: 0;
    position: relative;
    height: 100%;
}

.clear-both{
    clear: both;
}

.progress-line.step1 ol:before {
    width: 15%;
}


.progress-line.step2 ol:before {
    width: 40%;
}

.progress-line.step3 ol:before {
    width: 64.5%;
}

.progress-line.step4 ol:before {
    width: 100%;
}

.progress-line ol:before {
    -webkit-transition: width 0.7s linear;
    -moz-transition: width 0.7s linear;
    -o-transition: width 0.7s linear;
    -ms-transition: width 0.7s linear;
    transition: width 0.7s linear;
    height: 4px;
    content: '';
    background-color: #e54242;
    position: absolute;
    left: 0;
    top: 50%;
    margin-top: -2px;
}

.progress-line ol li.current .step-counter i{
    font-size: 40px;
    margin-left: 17px;
    color: #e54242;
    line-height: 40px;
    position: absolute;
}

.progress-line ol li.current .step-counter span{
    margin-left: 31px;
}


.progress-line ol li .step-counter i{
    font-size: 40px;
    content: '';
    position: absolute;
    top: 40%;
    left: 50%;
    margin-left: 0;
    margin-top: -63px;
    border-radius: 36px;
    color: #999;
    line-height: 36px;
    
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

.progress-line:before {
    width: 100%;
    height: 4px;
    content: '';
    background-color: #dfdfdf;
    position: absolute;
    left: 0;
    top: 50%;
    margin-top: -2px;
}

.progress-area{
    margin-bottom: 70px;
    position: sticky;
}

.has_file{
    margin:15px 0;
    border:1px solid #eee;
    padding: 10px;
    display: inline-block;
}

.breadcrumb-v2 .icon{
    font-size: 16px;
    background-color: #e54242;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    border-radius: 100%;
    margin-right: 10px;
}

.rendered-form h4{
    font-size: 30px;
    margin: 15px 0;
}

.finish-tick input[type="checkbox"]{
    background: #005cbf !important;
    margin-right: 10px;
}

.finish-tick input[type="checkbox"]::before{
    background: white !important;

}

.rendered-form .formbuilder-checkbox-group input[type='checkbox']{
    background: #005cbf !important;
}

.rendered-form .formbuilder-checkbox-group input[type='checkbox']::before{
    background: white !important;
}

.rendered-form .formbuilder-checkbox label{
    cursor: pointer;
}


.finish-button button{
    width: 100px;
    font-size: 13px;
}

.finish-tick{
    display: flex;
    align-items: center;
}

.formbuilder-checkbox{
    display: flex;
    align-items: center;
}

.breadcrumb {
    font-weight: 700;
    font-size: 13px
}

.error-text{
    color: #fb0317;
    margin: 10px 15px;
    font-size: 13px;
}

.finish-area{
    margin: 15px 0;
    border: 1px solid #eee;
    padding: 10px;
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

.finish-area .icon i{
    font-size: 150px;
}

.finish-area .text{
    margin: 20px 0;
}

.project_imaget{
    margin:15px;
}

.form-area label{
    font-size: 13px;
    margin-bottom: 5px;
}

.project_imaget img{
    max-width: 129px;
    max-width: 97px;
}

.confirm span{
    color: green;
}

.nav-linkx{
    position: relative;
    color: var(--phoenix-gray-800);
    padding: 0.875rem 0.5rem;
    -webkit-box-flex: 1;
    -ms-flex: 1;
}

.vertical-tab .nav-linkx.active{
    font-weight: 700;
    font-size: 12.8px;
    color: var(--phoenix-gray-1100);
}
    </style>
@endsection
