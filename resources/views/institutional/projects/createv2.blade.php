@extends('institutional.layouts.master')

@section('content')
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
                            <a href="">Öne Çıkar</a>
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
                            <div class="icon"><i class="fa fa-house"></i></div> Emlak
                        </div>
                    </div>
                    <div class="form-area mt-4">
                        <span class="section-title">İlan Detayları</span>
                        
                        <div class="form-group">
                            <label for="">İlan Başlığı <span class="required">*</span></label>
                            <div class="max-character-input">
                                <div class="row" style="align-items:center;">
                                    <div class="input col-md-10">
                                        <input type="text" value="{{isset($tempData->name) ? $tempData->name : ''}}" name="name" class="form-control advert_title">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="max-character" for="">{{isset($tempData->name) ? Str::length(trim($tempData->name)) : '0'}}/70</label>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group description-field">
                            <label for="">İlan Açıklaması <span class="required">*</span></label>
                            <textarea name="description" id="editor" cols="30" rows="5" onkeyup="changeData(this.value,'description')" class="form-control">{{isset($tempData->description) ? $tempData->description : ''}}</textarea>
                        </div>
                        <h4 class="mb-3">Kaç Adet Konutunuz Var</h4><input value="{{isset($tempData->house_count) ? $tempData->house_count : ''}}" onkeyup="changeData(this.value,'house_count')" class="form-control mb-5" type="text" id="house_count" name="house_count" value="{{old('house_count')}}" placeholder="Kaç Adet Konutunuz Var" />
                        <span id="generate_tabs" class=" btn btn-primary mb-5">Daireleri Oluştur</span>
                        <div class="row">
                            <div class="col-sm-3">
                                <div id="tablist" class="nav flex-sm-column border-bottom border-bottom-sm-0 border-end-sm border-300 fs--1 vertical-tab h-100" role="tablist" aria-orientation="vertical">
        
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="tab-content" id="pricingTabContent" role="tabpanel">
                                    <div id="renderForm"></div>
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
                                            <span class="btn btn-primary remaining_projects">Kalan Proje Adedi : {{$userPlan->project_limit}}</span>
                                            <div style="margin-right: 20px">
                                                <input type="radio" style="display: none;margin:0 auto;">
                                                <div class="price-radio @if(isset($tempData->{"pricing-type"}) && $tempData->{"pricing-type"} == 1) select @endif" >
                                                    <div class="inside"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <h3>Paket Sayımdan Öde</h3>
                                                <span>Paketinde ki mevcut proje sayısından düş</span>
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
                                                <span  class="old_price">{{$price->old_price}}₺</span>
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
                <div class="without-doping mb-5">
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
                            <div class="text"><a href="{{route('institutional.projects.index')}}" class="btn btn-info">Projelerime yönlen</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/assets/js/moment.min.js" integrity="sha512-CryKbMe7sjSCDPl18jtJI5DR5jtkUWxPXWaLCst6QjH8wxDexfRJic2WRmRXmstr2Y8SxDDWuBO6CQC6IE4KTA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ URL::to('/') }}/adminassets/assets/js/jquery.daterangepicker.min.js"></script>
    
    <script>
        var nextTemp = false;
        var housingImages = [];
        var descriptionText = @if(isset($tempData) && isset($tempData->description)) 'evet var' @else "" @endif;
        var selectedid = @if(isset($tempData) && isset($tempData->housing_type_id)) {{$tempData->housing_type_id}} @else 0 @endif;
        
        function confirmHousings(){
            for(var i = 0 ; i < $('.tab-pane').length; i++){
                var confirm = 1;
                $('.tab-pane').eq(i).find('input[required="required"]').map((key,item) => {
                    if(!$(item).val()){
                        confirm = 0;
                    }
                })

                $('.tab-pane').eq(i).find('select[required="required"]').map((key,item) => {
                    if(!$(item).val()){
                        confirm = 0;
                    }
                })
                if($('.tab-pane').eq(i).find('input[type="file"]').closest('.formbuilder-file').find('.project_imaget').length == 0){
                    confirm = 0;
                }


                if(confirm){
                    $('#tablist>.item-left-area').eq(i).addClass('confirm');
                }
            }
            
        }

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
                url: "{{route('institutional.change.step.order')}}",
                data : {
                    order : 2,
                    item_type : 1,
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
                    url: "{{route('institutional.change.step.order')}}",
                    data : {
                        order : 3,
                        item_type : 1,
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
                url: "{{route('institutional.change.step.order')}}",
                data : {
                    order : 1,
                    item_type : 1,
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


        function datediff(first, second) {        
            return Math.round((second - first) / (1000 * 60 * 60 * 24));
        }
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
                url: "{{ URL::to('/') }}/institutional/get_busy_housing_statuses/"+$('.doping_statuses').val(),
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

        var csrfToken = "{{ csrf_token() }}";
        $('.finish-step-3').click(function(){
            $.ajax({
                method: "POST",
                url: "{{route('institutional.project.end.temp.order')}}",
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
            $.ajax({
                method: "POST",
                url: "{{route('institutional.project.end.temp.order')}}",
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
                url: "{{ route('institutional.ht.getform') }}",
                data: {
                    id: houseType
                },
                success: function(response) {
                    var html = "";
                    var htmlContent = "";
                    for(var i = 0 ; i < houseCount; i++ ){
                        html += '<div class="item-left-area"><p class="nav-linkx border-end border-end-sm-0 border-bottom-sm border-300 text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center '+(i == 0 ? 'active' : '')+'" id="Tab'+(i+1)+'"  aria-controls="TabContent'+(i+1)+'" aria-selected="true">'+
                            '<span class="me-sm-2 fs-4 nav-icons" data-feather="tag"></span>'+
                            '<span class="d-block d-sm-inline">'+(i+1)+' Nolu Konut Bilgileri</span>'+
                            '<span class="d-block d-sm-inline">Kopyala (Aynı Olan Dairelere Otomatik Giriş) '+getCopyList(houseCount,i+1)+'</span>'+
                        '</p></div>';

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

                        if(i > 1 && i != $('.tab-pane').length){
                            $('.rendered-form').eq(i - 1).append('<div class="housing_buttons"><button class="prev_house btn btn-primary">Önceki Ev</button><button class="next_house btn btn-primary">Sonraki Konut</button></div>')
                        }else if(i == $('.tab-pane').length){
                            $('.rendered-form').eq(i - 1).append('<div class="housing_buttons"><button class="prev_house btn btn-primary">Önceki Ev</button></div>')
                        }else{
                            $('.rendered-form').eq(i - 1).append('<div class="housing_buttons"><button class="next_house btn btn-primary">Sonraki Konut</button></div>')
                        }

                        
                    }

                    $('.next_house').click(function(){
                        var nextHousing = true;
                        $('.tab-pane.active input[required="required"]').map((key,item) => {
                            if(!$(item).val() && $(item).attr('type') != "file"){
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

                        
                        $('.tab-pane.active input[type="file"]').map((key,item) => {
                            if($(item).parent('div').find('.project_imaget').length == 0){
                                nextHousing = false;
                                $(item).addClass("error-border")
                            }
                        })

                        var indexItem = $('.tab-pane.active').index();
                        if(nextHousing){
                            $('html, body').animate({
                                scrollTop: $('.tab-pane.active').offset().top - parseFloat($('.navbar-top').css('height'))
                            }, 100);
                            $('.tab-pane.active').removeClass('active');
                            $('.tab-pane').eq(indexItem + 1).addClass('active');
                            $('.item-left-area p').removeClass('active');
                            $('.item-left-area').eq(indexItem + 1).find('p').addClass('active');
                        }else{
                            $('html, body').animate({
                                scrollTop: $('.tab-pane.active').offset().top - parseFloat($('.navbar-top').css('height'))
                            }, 100);
                        }
                    })

                    $('.prev_house').click(function(){
                        
                        var indexItem = $('.tab-pane.active').index();
                        $('.tab-pane.active').removeClass('active');
                        $('.tab-pane').eq(indexItem - 1).addClass('active');
                        
                        $('.item-left-area p').removeClass('active');
                        $('.item-left-area').eq(indexItem - 1).find('p').addClass('active');
                        $('html, body').animate({
                            scrollTop: $('.tab-pane.active').offset().top - parseFloat($('.navbar-top').css('height'))
                        }, 100);
                    })
                    for (let i = 1; i <= houseCount; i++) {
                        for(var j = 0 ; j < formInputs.length; j++){
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
                                    if(checkbox.trim() == $(item).attr("value").trim()){
                                        $(item).attr('checked','checked')
                                    }
                                })
                            }
                            
                            });
                        }else if(formInputs[j].type == 'file'){
                            var inputName = formInputs[j].name;
                            var inputNamex = inputName;
                            inputNamex = inputNamex.split('[]')
                            console.log(oldData[inputNamex[0]])
                            if(oldData[inputNamex[0]] != undefined){
                                $($('input[name="'+formInputs[j].name+'"]')[i-1]).parent('div').append('<div class="project_imaget"><img src="{{URL::to("/")}}/storage/project_images/'+oldData[inputNamex[0]][i - 1]+'"></div>');
                            }
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
                    $('.second-payment-plan').closest('div').addClass('d-none')
                    $('.tab-pane select[multiple="false"]').removeAttr('multiple')

                    $('input[value="taksitli"]').change(function(){
                        if($(this).is(':checked')){
                            $('.second-payment-plan').closest('div').removeClass('d-none');
                        }else{
                            $('.second-payment-plan').closest('div').addClass('d-none');
                        }
                    })

                    $('.item-left-area').click(function(e){
                        var clickIndex = $(this).index();
                        var currentIndex = $('.nav-linkx.active').closest('.item-left-area').index();

                        if(clickIndex>currentIndex){
                            var nextHousing = true;
                            $('.tab-pane.active input[required="required"]').map((key,item) => {
                                if(!$(item).val() && $(item).attr('type') != "file"){
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
                            

                            $('.tab-pane.active input[type="file"]').map((key,item) => {
                                if($(item).parent('div').find('.project_imaget').length == 0){
                                    nextHousing = false;
                                    $(item).addClass("error-border")
                                }
                            })
                            
                            var indexItem = $('.tab-pane.active').index();
                            if(nextHousing){
                                $('.tab-pane.active').removeClass('active');
                                $('.tab-pane').eq(indexItem + 1).addClass('active');
                                $('.item-left-area p').removeClass('active')
                                $(this).children('p').addClass('active');
                            }else{
                                $('html, body').animate({
                                    scrollTop: $('.tab-pane.active').offset().top - parseFloat($('.navbar-top').css('height'))
                                }, 100);
                            }

                            

                        }else{

                            $('.item-left-area p').removeClass('active')
                            $(this).children('p').addClass('active');
                            $('.tab-pane.active').removeClass('active');
                            $('.tab-pane').eq(clickIndex).addClass('active');
                        }
                        
                    })

                    
                    $('.copy-item').change(function(){
                        var order = parseInt($(this).val()) - 1;
                        var currentOrder = parseInt($(this).closest('.item-left-area').index());
                        for(var lm = 0 ; lm < json.length; lm++){
                            if(json[lm].type == "checkbox-group"){
                            for(var i = 0 ; i < json[lm].values.length; i++){
                                var isChecked = $('input[name="'+(json[lm].name.replace('[]',''))+(order+1  )+'[][]"][value="'+json[lm].values[i].value+'"]'+'').is(':checked')
                                if(isChecked){
                                    var formData = new FormData();
                                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                                    formData.append('_token', csrfToken);
                                    formData.append('value', json[lm].values[i].value);
                                    formData.append('order',currentOrder);
                                    formData.append('key',json[lm].name.replace("[]", "").replace("[]", "")+(currentOrder + 1));
                                    formData.append('item_type',1);
                                    formData.append('checkbox',"1");
                                    $.ajax({
                                        type: "POST",
                                        url: "{{route('institutional.temp.order.project.housing.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                        },
                                    });
                                    $('input[name="'+(json[lm].name.replace('[]',''))+(currentOrder+1  )+'[][]"][value="'+json[lm].values[i].value+'"]'+'').prop('checked',true)
                                }else{
                                    $('input[name="'+(json[lm].name.replace('[]',''))+(currentOrder+1  )+'[][]"][value="'+json[lm].values[i].value+'"]'+'').prop('checked',false)
                                }
                            }
                            }else if(json[lm].type == "select"){
                                var value = $('select[name="'+(json[lm].name)+'"]').eq(order).val();
                                $('select[name="'+(json[lm].name)+'"]').eq(currentOrder).children('option').removeAttr('selected')
                                $('select[name="'+(json[lm].name)+'"]').eq(currentOrder).children('option[value="'+value[0]+'"]').prop('selected',true);
                                var formData = new FormData();
                                var csrfToken = $("meta[name='csrf-token']").attr("content");
                                formData.append('_token', csrfToken);
                                formData.append('value', value);
                                formData.append('order',currentOrder);
                                formData.append('key',json[lm].name.replace("[]", "").replace("[]", ""));
                                formData.append('item_type',1);
                                $.ajax({
                                    type: "POST",
                                    url: "{{route('institutional.temp.order.project.housing.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                    },
                                });

                                confirmHousings();
                            }else if(json[lm].type == "file" && json[lm].name == "image[]"){
                                
                                var formData = new FormData();
                                var csrfToken = $("meta[name='csrf-token']").attr("content");
                                formData.append('_token', csrfToken);
                                formData.append('lastorder',order);
                                formData.append('order',currentOrder);
                                formData.append('item_type',1);
                                $.ajax({
                                    type: "POST",
                                    url: "{{route('institutional.copy.item.image')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                    },
                                });
                                var cloneImage = $('.tab-pane').eq(order).find('.project_imaget').clone();
                                $('.tab-pane.active').find('.cover-image-by-housing-type').parent('div').append(cloneImage)
                            }else if(json[lm].type != "file"){
                                if(json[lm].name){
                                    var value = $('input[name="'+(json[lm].name)+'"]').eq(order).val();
                                    var formData = new FormData();
                                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                                    formData.append('_token', csrfToken);
                                    formData.append('value', value);
                                    formData.append('order',currentOrder);
                                    formData.append('key',json[lm].name.replace("[]", "").replace("[]", ""));
                                    formData.append('item_type',1);
                                    $.ajax({
                                        type: "POST",
                                        url: "{{route('institutional.temp.order.project.housing.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                        },
                                    });

                                    confirmHousings();
                                    $('input[name="'+(json[lm].name)+'"]').eq(currentOrder).val(value);
                                }
                                
                            }
                        }
                    })
                    
                    $('.rendered-form input').change(function(){
                        if($(this).attr('type') != "file"){
                            var formData = new FormData();
                            var csrfToken = $("meta[name='csrf-token']").attr("content");
                            formData.append('_token', csrfToken);
                            formData.append('value',$(this).val());
                            
                            console.log($(this).attr('name'))
                            formData.append('order',parseInt($(this).closest('.tab-pane').attr('id').replace('TabContent',"")) - 1);
                            formData.append('key',$(this).attr('name').replace("[]", "").replace("[]", ""));
                            formData.append('item_type',1);
                            if($(this).attr('type') == "checkbox"){
                                formData.append('checkbox',"1");
                            }
                            $.ajax({
                                type: "POST",
                                url: "{{route('institutional.temp.order.project.housing.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                },
                            });

                            confirmHousings();
                        }
                    })

                    $('.rendered-form select').change(function(){
                        if($(this).val().length){
                            $(this).removeClass('error-border')
                        }
                        var formData = new FormData();
                        var csrfToken = $("meta[name='csrf-token']").attr("content");
                        formData.append('_token', csrfToken);
                        formData.append('value',$(this).val());
                        formData.append('order',parseInt($(this).closest('.tab-pane').attr('id').replace('TabContent',"")) - 1);
                        formData.append('key',$(this).attr('name').replace("[]", ""));
                        formData.append('item_type',1);
                        $.ajax({
                            type: "POST",
                            url: "{{route('institutional.temp.order.project.housing.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                            },
                        });

                        confirmHousings();
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

                    
                    $('.cover-image-by-housing-type').change(function(){
                        var input = this;
                        if (input.files && input.files[0]) {
                            $(this).removeClass('error-border');

                            confirmHousings();
                            var reader = new FileReader();

                            var formData = new FormData();
                            var csrfToken = $("meta[name='csrf-token']").attr("content");
                            formData.append('_token', csrfToken);
                            formData.append('file',this.files[0]);
                            formData.append('item_type',1);
                            $.ajax({
                                type: "POST",
                                url: "{{route('institutional.temp.order.project.add.image')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                },
                                error: function() {
                                    // Hata durumunda kullanıcıya bir mesaj gösterebilirsiniz
                                    alert("Dosya yüklenemedi.");
                                }
                            });

                            reader.onload = function(e) {
                                // Resmi görüntülemek için bir div oluşturun
                                var imageDiv = $('<div class="project_imaget"></div>');

                                // Resmi oluşturun ve div içine ekleyin
                                var image = $('<img>').attr('src', e.target.result);
                                imageDiv.append(image);
                                // Resmi görüntüleyici divini temizleyin ve yeni resmi ekleyin
                                $('.cover-photo').html(imageDiv);

                                $('.tab-pane.active .cover-image-by-housing-type img').remove()
                                $('.tab-pane.active .cover-image-by-housing-type').closest('.formbuilder-file').append(imageDiv)
                            };

                            // Resmi okuyun
                            reader.readAsDataURL(input.files[0]);
                            
                        }
                    })

                    
                    confirmHousings();
                    


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
            formData.append('item_type',1);
            formData.append('array_data',isArray);
            $.ajax({
                type: "POST",
                url: "{{route('institutional.temp.order.data.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
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
                formData.append('item_type',1);
                $.ajax({
                    type: "POST",
                    url: "{{route('institutional.temp.order.document.add')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
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
                formData.append('item_type',1);
                $.ajax({
                    type: "POST",
                    url: "{{route('institutional.temp.order.single.file.add')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
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
                formData.append('item_type',1);
                $.ajax({
                    type: "POST",
                    url: "{{route('institutional.temp.order.image.add')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
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
                var formInputs = JSON.parse(housingTypeData.form_json);

                $('.rendered-area').removeClass('d-none')
                $.ajax({
                    method: "GET",
                    url: "{{ route('institutional.ht.getform') }}",
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

                        }
                        for (let i = 1; i <= houseCount; i++) {
                            for(var j = 2 ; j < formInputs.length; j++){
                            if(formInputs[j].type == "number" || formInputs[j].type == "text"){
                                var inputName = formInputs[j].name;
                                var inputNamex = inputName;
                                inputNamex = inputNamex.split('[]')
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

            generateTabsButton.addEventListener('click', function () {
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
                const houseCount = parseInt(houseCountInput.value);

                if (isNaN(houseCount) || houseCount <= 0) {
                    alert('Lütfen geçerli bir sayı girin.');
                    return;
                }


                $.ajax({
                    method: "GET",
                    url: "{{ route('institutional.ht.getform') }}",
                    data: {
                        id: selectedid
                    },
                    success: function(response) {
                        var html = "";
                        var htmlContent = "";
                        for(var i = 0 ; i < houseCount; i++ ){
                            html += '<div class="item-left-area"><p class="nav-linkx border-end border-end-sm-0 border-bottom-sm border-300 text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center '+(i == 0 ? 'active' : '')+'" id="Tab'+(i+1)+'"  aria-controls="TabContent'+(i+1)+'" aria-selected="true">'+
                                '<span class="me-sm-2 fs-4 nav-icons" data-feather="tag"></span>'+
                                '<span class="d-block d-sm-inline">'+(i+1)+' Nolu Konut Bilgileri</span>'+
                                '<span class="d-block d-sm-inline">Kopyala (Aynı Olan Dairelere Otomatik Giriş) '+getCopyList(houseCount,i+1)+'</span>'+
                            '</p></div>';

                            htmlContent += '<div class="tab-pane fade show '+(i == 0 ? 'active' : '')+'" id="TabContent'+(i+1)+'" role="tabpanel">'+
                                '<div id="renderForm'+(i+1)+'" class="card p-4"></div>'+
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
                            var json = JSON.parse(response.form_json);
                            renderHtml = renderHtml[0]+'images'+i+'[][]'+renderHtml[1];
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
                                
                                $('.checkbox-item').closest('.checkbox-group').addClass('d-flex')
                                $('.checkbox-item').closest('.checkbox-group').addClass('checkbox-items')
                            }

                            $('#renderForm'+(i)).html(renderHtml);

                            if(i > 1 && i != $('.tab-pane').length){
                                $('.rendered-form').eq(i - 1).append('<div class="housing_buttons"><button class="prev_house btn btn-primary">Önceki Ev</button><button class="next_house btn btn-primary">Sonraki Konut</button></div>')
                            }else if(i == $('.tab-pane').length){
                                $('.rendered-form').eq(i - 1).append('<div class="housing_buttons"><button class="prev_house btn btn-primary">Önceki Ev</button></div>')
                            }else{
                                $('.rendered-form').eq(i - 1).append('<div class="housing_buttons"><button class="next_house btn btn-primary">Sonraki Konut</button></div>')
                            }
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
                                $('html, body').animate({
                                    scrollTop: $('.tab-pane.active').offset().top - parseFloat($('.navbar-top').css('height'))
                                }, 100);
                                $('.tab-pane.active').removeClass('active');
                                $('.tab-pane').eq(indexItem + 1).addClass('active');
                                $('.item-left-area p').removeClass('active');
                                $('.item-left-area').eq(indexItem + 1).find('p').addClass('active');
                            }else{
                                $('html, body').animate({
                                    scrollTop: $('.tab-pane.active').offset().top - parseFloat($('.navbar-top').css('height'))
                                }, 100);
                            }
                        })

                        $('.prev_house').click(function(){
                            
                            var indexItem = $('.tab-pane.active').index();
                            $('.tab-pane.active').removeClass('active');
                            $('.tab-pane').eq(indexItem - 1).addClass('active');

                            $('.item-left-area p').removeClass('active');
                            $('.item-left-area').eq(indexItem - 1).find('p').addClass('active');
                            $('html, body').animate({
                                scrollTop: $('.tab-pane.active').offset().top - parseFloat($('.navbar-top').css('height'))
                            }, 100);
                        })

                        $('.item-left-area').click(function(e){
                            var clickIndex = $(this).index();
                            var currentIndex = $('.nav-linkx.active').closest('.item-left-area').index();

                            if(clickIndex>currentIndex){
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

                                $('.tab-pane.active input[type="file"]').map((key,item) => {
                                    if($(item).parent('div').find('.project_imaget').length == 0){
                                        nextHousing = false;
                                        $(item).addClass("error-border")
                                    }
                                })
                                
                                var indexItem = $('.tab-pane.active').index();
                                if(nextHousing){
                                    $('.tab-pane.active').removeClass('active');
                                    $('.tab-pane').eq(indexItem + 1).addClass('active');
                                    $('.item-left-area p').removeClass('active')
                                    $(this).children('p').addClass('active');
                                }else{
                                    $('html, body').animate({
                                        scrollTop: $('.tab-pane.active').offset().top - parseFloat($('.navbar-top').css('height'))
                                    }, 100);
                                }

                                

                            }else{

                                $('.item-left-area p').removeClass('active')
                                $(this).children('p').addClass('active');
                                $('.tab-pane.active').removeClass('active');
                                $('.tab-pane').eq(clickIndex).addClass('active');
                            }
                            
                        })

                        $('.copy-item').change(function(){
                        var order = parseInt($(this).val()) - 1;
                        var currentOrder = parseInt($(this).closest('.item-left-area').index());
                        for(var lm = 0 ; lm < json.length; lm++){
                            if(json[lm].type == "checkbox-group"){
                            for(var i = 0 ; i < json[lm].values.length; i++){
                                var isChecked = $('input[name="'+(json[lm].name.replace('[]',''))+(order+1  )+'[][]"][value="'+json[lm].values[i].value+'"]'+'').is(':checked')
                                if(isChecked){
                                    var formData = new FormData();
                                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                                    formData.append('_token', csrfToken);
                                    formData.append('value', json[lm].values[i].value);
                                    formData.append('order',currentOrder);
                                    formData.append('key',json[lm].name.replace("[]", "").replace("[]", "")+(currentOrder + 1));
                                    formData.append('item_type',1);
                                    formData.append('checkbox',"1");
                                    $.ajax({
                                        type: "POST",
                                        url: "{{route('institutional.temp.order.project.housing.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                        },
                                    });
                                    $('input[name="'+(json[lm].name.replace('[]',''))+(currentOrder+1  )+'[][]"][value="'+json[lm].values[i].value+'"]'+'').prop('checked',true)
                                }else{
                                    $('input[name="'+(json[lm].name.replace('[]',''))+(currentOrder+1  )+'[][]"][value="'+json[lm].values[i].value+'"]'+'').prop('checked',false)
                                }
                            }
                            }else if(json[lm].type == "select"){
                                var value = $('select[name="'+(json[lm].name)+'"]').eq(order).val();
                                $('select[name="'+(json[lm].name)+'"]').eq(currentOrder).children('option').removeAttr('selected')
                                $('select[name="'+(json[lm].name)+'"]').eq(currentOrder).children('option[value="'+value[0]+'"]').prop('selected',true);
                                var formData = new FormData();
                                var csrfToken = $("meta[name='csrf-token']").attr("content");
                                formData.append('_token', csrfToken);
                                formData.append('value', value);
                                formData.append('order',currentOrder);
                                formData.append('key',json[lm].name.replace("[]", "").replace("[]", ""));
                                formData.append('item_type',1);
                                $.ajax({
                                    type: "POST",
                                    url: "{{route('institutional.temp.order.project.housing.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                    },
                                });

                                confirmHousings();
                            }else if(json[lm].type == "file" && json[lm].name == "image[]"){
                                
                                var formData = new FormData();
                                var csrfToken = $("meta[name='csrf-token']").attr("content");
                                formData.append('_token', csrfToken);
                                formData.append('lastorder',order);
                                formData.append('order',currentOrder);
                                formData.append('item_type',1);
                                $.ajax({
                                    type: "POST",
                                    url: "{{route('institutional.copy.item.image')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                    },
                                });
                                var cloneImage = $('.tab-pane').eq(order).find('.project_imaget').clone();
                                $('.tab-pane.active').find('.cover-image-by-housing-type').parent('div').append(cloneImage)
                            }else if(json[lm].type != "file"){
                                if(json[lm].name){
                                    var value = $('input[name="'+(json[lm].name)+'"]').eq(order).val();
                                    var formData = new FormData();
                                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                                    formData.append('_token', csrfToken);
                                    formData.append('value', value);
                                    formData.append('order',currentOrder);
                                    formData.append('key',json[lm].name.replace("[]", "").replace("[]", ""));
                                    formData.append('item_type',1);
                                    $.ajax({
                                        type: "POST",
                                        url: "{{route('institutional.temp.order.project.housing.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                        },
                                    });

                                    confirmHousings();
                                    $('input[name="'+(json[lm].name)+'"]').eq(currentOrder).val(value);
                                }
                                
                            }
                        }
                    })

                        $('.rendered-form input').change(function(){
                            if($(this).attr('type') != "file"){
                                var formData = new FormData();
                                var csrfToken = $("meta[name='csrf-token']").attr("content");
                                formData.append('_token', csrfToken);
                                formData.append('value',$(this).val());
                                formData.append('order',parseInt($(this).closest('.tab-pane').attr('id').replace('TabContent',"")) - 1);
                                formData.append('key',$(this).attr('name').replace("[]", "").replace("[]", ""));
                                formData.append('item_type',1);
                                if($(this).attr('type') == "checkbox"){
                                    formData.append('checkbox',"1");
                                }
                                $.ajax({
                                    type: "POST",
                                    url: "{{route('institutional.temp.order.project.housing.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                    },
                                });

                                confirmHousings();
                            }
                        })

                        $('.rendered-form select').change(function(){
                            confirmHousings();
                            if($(this).val().length){
                                $(this).removeClass('error-border')
                            }
                            var formData = new FormData();
                            var csrfToken = $("meta[name='csrf-token']").attr("content");
                            formData.append('_token', csrfToken);
                            formData.append('value',$(this).val());
                            formData.append('order',parseInt($(this).closest('.tab-pane').attr('id').replace('TabContent',"")) - 1);
                            formData.append('key',$(this).attr('name').replace("[]", ""));
                            formData.append('item_type',1);
                            $.ajax({
                                type: "POST",
                                url: "{{route('institutional.temp.order.project.housing.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
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

                        $('.cover-image-by-housing-type').change(function(){
                            var input = this;
                            if (input.files && input.files[0]) {
                                $(this).removeClass('error-border');
                                confirmHousings();
                                var reader = new FileReader();

                                var formData = new FormData();
                                var csrfToken = $("meta[name='csrf-token']").attr("content");
                                formData.append('_token', csrfToken);
                                formData.append('file',this.files[0]);
                                formData.append('item_type',1);
                                $.ajax({
                                    type: "POST",
                                    url: "{{route('institutional.temp.order.project.add.image')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                    },
                                    error: function() {
                                        // Hata durumunda kullanıcıya bir mesaj gösterebilirsiniz
                                        alert("Dosya yüklenemedi.");
                                    }
                                });

                                reader.onload = function(e) {
                                    // Resmi görüntülemek için bir div oluşturun
                                    var imageDiv = $('<div class="project_imaget"></div>');

                                    // Resmi oluşturun ve div içine ekleyin
                                    var image = $('<img>').attr('src', e.target.result);
                                    imageDiv.append(image);
                                    // Resmi görüntüleyici divini temizleyin ve yeni resmi ekleyin
                                    $('.cover-photo').html(imageDiv);

                                    $('.tab-pane.active .cover-image-by-housing-type img').remove()
                                    $('.tab-pane.active .cover-image-by-housing-type').closest('.formbuilder-file').append(imageDiv)
                                };

                                // Resmi okuyun
                                reader.readAsDataURL(input.files[0]);
                                
                            }
                        })
                    },
                    error: function(error) {
                        console.log(error)
                    }
                })
                // Belirtilen sayıda sekme oluştur

            });
        });

        @if(isset($tempData->city_id))
            var selectedCity = {{$tempData->city_id}}; // Seçilen şehir değerini al

            // AJAX isteği yap
            $.ajax({
                url: '{{route("institutional.get.counties")}}', // Endpoint URL'si (get.counties olarak varsayalım)
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
                            url: '{{route("institutional.get.neighbourhood")}}', // Endpoint URL'si (get.counties olarak varsayalım)
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
                url: '{{route("institutional.get.counties")}}', // Endpoint URL'si (get.counties olarak varsayalım)
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
            var selectedCountyKey = $('#counties option[value="'+selectedCounty+'"]').attr("key_x");
            // AJAX isteği yap
            $.ajax({
                url: '{{route("institutional.get.neighbourhood")}}', // Endpoint URL'si (get.counties olarak varsayalım)
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
                            text: response[i].mahalle_title, // İlçe adı
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor5/40.0.0/ckeditor.min.js" integrity="sha512-Zyl/SvrviD3rEMVNCPN+m5zV0PofJYlGHnLDzol2kM224QpmWj9p5z7hQYppmnLFhZwqif5Fugjjouuk5l1lgA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
    <script>
         

        

        
            tinymce.init({
                selector: '#editor', // HTML elementinizi seçin
                plugins: 'advlist autolink lists link image charmap print preview anchor',
                toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | forecolor backcolor ',
                menubar: false, // Menü çubuğunu tamamen devre dışı bırakır

                // Görünümleri devre dışı bırakmak için aşağıdaki yapılandırmaları kullanın
                file_browser_callback_types: 'image media',
                file_browser_callback: function(field_name, url, type, win) {
                    // Herhangi bir işlem yapmadan boş bir işlev kullanarak "File" görünümünü devre dışı bırakır
                },
                file_picker_types: 'image media',
                file_picker_callback: function(callback, value, meta) {
                    // Herhangi bir işlem yapmadan boş bir işlev kullanarak "File" görünümünü devre dışı bırakır
                },
                setup: function (editor) {
                    // 'change' olayını dinleyin
                    editor.on('change', function () {
                        // Editör içeriği değiştiğinde yapılacak işlemi burada tanımlayabilirsiniz.
                        console.log("Editör içeriği değişti.");
                        const editorContent = editor.getContent();
                        console.log(editorContent);
                        if(editorContent != ""){
                            descriptionText = "evet var";
                        }else{
                            descriptionText = "";
                        }
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
                        
                        
                        // Verileri FormData nesnesine ekleyin
                        const formData = new FormData();
                        formData.append('_token', csrfToken);
                        formData.append('value', editorContent);
                        formData.append('key', "description");
                        formData.append('item_type', 1);
                        
                        // AJAX isteği gönderin
                        fetch("{{ route('institutional.temp.order.data.change') }}", {
                            method: "POST",
                            body: formData,
                        })
                        .then(data => {
                            // Sunucu yanıtını işleyebilirsiniz.
                        })
                        .catch(error => {
                            console.error(error);
                        });
                    });
                }
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
                    if(!$(item).val() && $(item).attr('type') != 'file'){
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

                $('.tab-pane.active input[type="file"]').map((key,item) => {
                    if($(item).parent('div').find('.project_imaget').length == 0){
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
                    url: "{{route('institutional.change.step.order')}}",
                    data : {
                        order : 3,
                        item_type : 1,
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
                url: "{{URL::to('/')}}/institutional/get_housing_type_childrens/"+itemSlug, // AJAX isteği yapılacak URL
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
                url: "{{URL::to('/')}}/institutional/get_housing_type_childrens/"+itemSlug, // AJAX isteği yapılacak URL
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
                                url: "{{URL::to('/')}}/institutional/get_housing_type_id/"+itemSlug, // AJAX isteği yapılacak URL
                                type: "GET", // GET isteği
                                dataType: "json", // Gelen veri tipi JSON
                                success: function (data) {
                                    changeData(data,'housing_type_id');
                                    selectedid = data;
                                }
                            })
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

        $('.advert_title').keyup(function(){
            if($(this).val().length > 70){
                $(this).val($(this).val().substring(0,70))
            }else{
                changeData($(this).val(),'name')
                $('.max-character').html(($(this).val().length)+'/70');
            
                if($(this).val() != ""){
                    $(this).removeClass('error-border');
                }
            }

            
        })
    </script>
    <script>
        
        var $select = $('#housing_status').selectize();
        var selectize = $select[0].selectize;
        selectize.on('item_click', function(item) {
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
            formData.append('item_type',1);
            formData.append('array_data',isArray);
            $.ajax({
                type: "POST",
                url: "{{route('institutional.temp.order.data.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
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

@section('css')
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.css"/>
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/assets/css/daterangepicker.css">
    <link rel="stylesheet" href="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/skins/content/default/content.min.css">
@endsection

