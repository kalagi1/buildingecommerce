@extends('institutional.layouts.master')

@section('content')
    <div class="load-area d-none">
        <div class="progress">
            <div class="progress-bar"  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <span>Proje Oluşturuluyor</span>
    </div>
    @if($hasTemp)
    <div class="pop-up-v2">
        <div class="pop-back">

        </div>
        <div class="pop-content">
            <div class="pop-content-inner">
                <h2 class="text-center">Proje üzerinde önceden bir düzenleme yapmışsınız</h2>
                <div class="choises">
                    <div class="choise choise-1">
                        Kaldığım Yerden Devam Et
                    </div>
                    <div class="choise choise-2">
                        Yeni Proje Oluştur
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="pop-up-v4 d-none">
        <div class="pop-back">

        </div>
        <div class="pop-content">
            <div class="load-area2">
                <div class="progress2">
                    <div class="progress-bar2"  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span>Konut Değiştiriliyor</span>
            </div>
        </div>
    </div>
    

    <div class="pop-up-v3 d-none">
        <div class="pop-back">

        </div>
        <div class="pop-content">
            <div class="pop-content-inner">
                <div class="form-control mb-2">
                    <label for="">Blok Adı</label>
                    <input type="text" class="form-control block-name" >
                </div>
                <div class="form-control mb-2">
                    <label for="">Bu Blokta Kaç Tane Konut Var</label>
                    <input type="number" class="form-control block-count" >
                </div>
                <div class="form-group">
                    <button class="btn btn-success confirm-button-block">Bloğu Ekle</button>
                </div>
                
            </div>
        </div>
    </div>

    <div class="bottom-housing-area align-center col-xl-6 col-md-6 col-6 d-none" style="justify-content: center">
        <div class="row w-100">
            <div class="col-md-12 mbpx-10">
                <div class="row jc-space-between ">
                    <div class="col-md-5">
                        <div class="d-flex" style="align-items: center">
                            <div class="show-houing-order " style="width: calc(100% - 30px)"><div class="full-load" style="width: 0%"></div> <span>Daire <span class="room-order-progress">1</span> / <span class="percent-housing">0</span>%</span></div>
                            <div class="icon" style="margin-left: 5px;" data-toggle="tooltip" data-placement="top" title="Doldurduğunuz konutun doluluk oranını görüntüleyebilirsiniz">
                                <i class="fa fa-circle-info"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="d-flex" style="align-items: center">
                            <div class="icon" style="margin-right: 5px;" data-toggle="tooltip" data-placement="top" title="Aynı olan konutları kopyalamak için bu alanı kullanabilirsiniz">
                                <i class="fa fa-circle-info"></i>
                            </div>
                            
                            <select class="form-control  copy-item" name="" id="">
                                <option value="">Kopyalamak istediğiniz daireyi seçin</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 ">
                <div class="row" style="justify-content: space-between;">
                    <div class=" col-md-4">
                        <div class="button-white prev-house-bottom disabled-button">
                            <i class="fa fa-circle-chevron-left"></i> <span class="ml-5px last-housing-text">Önceki @if($housingTypeTempX) {{$housingTypeTempX->title}} @endif</span>
                        </div>
                    </div>
                    <div class="button-white2 col-md-4">
                        <input type="text" value="1" class="form-control house_order_input"><span>/</span><span class="total-house-text">@if(isset($tempData->has_blocks) && $tempData->has_blocks) {{isset($tempData->house_count0) ? $tempData->house_count0 : ''}} @else {{isset($tempData->house_count) ? $tempData->house_count : ''}} @endif</span>
                    </div>
                    <div class="col-md-4">
                        <div class="button-white next-house-bottom">
                            <span class="mr-5px next-housing-text">Sonraki @if($housingTypeTempX) {{$housingTypeTempX->title}} @endif</span> <i class="fa fa-circle-chevron-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content"> <h4 class="mb-2 lh-sm @if (isset($tempDataFull->step_order) && $tempDataFull->step_order != 1) d-none @endif">
        
        Proje İlanı Ekle    
                </h4>
        <div class="breadcrumb  @if(isset($tempDataFull->step_order) && $tempDataFull->step_order != 1) d-none @endif">
            <span>Proje</span>
            @foreach($areaSlugs as $slug)
                <span class="breadcrumb-after-item">{{$slug}}</span>
            @endforeach
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
                            <a href="">Proje Detayları</a>
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
                        <div class="area-listx">
                            <ul >
                                @foreach($housing_status as $status)
                                    <li @if(isset($tempData->statuses) && in_array($status->id,$tempData->statuses)) class="selected" @endif attr-id="{{$status->id}}">{{$status->name}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="area-list @if(isset($tempData->statuses) && count($tempData->statuses) > 1) active @endif">
                            <ul>
                                @foreach($housingTypeParent as $parent)
                                <li @if(isset($tempData->step1_slug) && $tempData->step1_slug == $parent->slug) class="selected" @endif slug="{{$parent->slug}}">{{$parent->title}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="area-list @if(isset($tempDataFull->data) && isset($tempData->step1_slug) && $tempData->step1_slug) active @endif">
                            <ul>
                                @if(isset($tempDataFull->data) && isset($tempData->step1_slug) &&$tempData->step1_slug)
                                    @foreach($secondAreaList as $secondAreaItem)
                                        <li @if($tempData->step2_slug == $secondAreaItem->slug) class="selected" @endif slug="{{$secondAreaItem->slug}}">{{$secondAreaItem->title}}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="area-list @if(isset($tempDataFull->data) && isset($tempData->step2_slug) && $tempData->step2_slug) active @endif">
                            <ul>
                                @if(isset($tempDataFull->data) && isset($tempData->step1_slug) && isset($tempData->step2_slug) && $tempData->step1_slug && $tempData->step2_slug)
                                    @foreach($housingTypes as $housingType)
                                        <li @if($tempData->step3_slug == $housingType->slug) class="selected" @endif slug="{{$housingType->slug}}">{{$housingType->title}}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="area-list @if(isset($tempDataFull->data) && isseT($tempData->step3_slug) && $tempData->step3_slug) active @endif">
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
                        <div class="card px-5 py-2 breadcrumb-v2" style="display: flex;flex-direction:row;">
                            <div class="icon"><i class="fa fa-house"></i></div> Emlak
                            @foreach($areaSlugs as $slug)
                                <span class="breadcrumb-after-item">{{$slug}}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-area mt-4">
                        <span class="section-title">Proje Detayları</span>
                        
                        <div class="form-group">
                            <label for="">Proje Adı <span class="required">*</span></label>
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
                            <label for="">Proje Açıklaması <span class="required">*</span></label>
                            <textarea name="description" id="editor" cols="30" rows="5"  class="form-control">{!! isset($tempData->description) ? $tempData->description : '' !!}</textarea>
                        </div>
                        <div class="card p-3 mb-4">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Yapımcı Firma</label>
                                        <div class="icon-input">
                                            <div class="icon-area">
                                                <i class="fa fa-building"></i>
                                            </div>
                                            <input type="text" value="{{isset($tempData->create_company) ? $tempData->create_company : ''}}" class="create_company" onkeyup="changeData(this.value,'create_company')">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Toplam Proje Alanı (M2)</label>
                                        <div class="icon-input">
                                            <div class="icon-area">
                                                <svg style="width: 20px;height: 20px;" fill="#ffffff" height="800px" width="800px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 491.541 491.541" xml:space="preserve"> <g> <path d="M350.373,116.048H24.445C10.942,116.048,0,126.988,0,140.492V466.42c0,13.503,10.942,24.445,24.445,24.445h325.928 c13.503,0,24.444-10.942,24.444-24.445V140.492C374.817,126.988,363.876,116.048,350.373,116.048z M325.928,441.975H48.889V164.936 h277.039V441.975z"/> <path d="M486.695,411.913h-26.513V126.63h26.513c1.958,0,3.724-1.178,4.472-2.991c0.756-1.814,0.342-3.892-1.05-5.283 l-42.802-42.802c-1.894-1.894-4.965-1.894-6.858,0l-42.803,42.802c-1.392,1.392-1.806,3.469-1.05,5.283 c0.749,1.813,2.515,2.991,4.473,2.991h26.513v285.283h-26.513c-1.958,0-3.724,1.177-4.473,2.991 c-0.755,1.815-0.342,3.893,1.05,5.285l42.803,42.802c1.893,1.894,4.965,1.894,6.858,0l42.802-42.802 c1.393-1.392,1.807-3.469,1.05-5.285C490.419,413.09,488.654,411.913,486.695,411.913z"/> <path d="M70.676,94.563c1.392,1.392,3.469,1.806,5.284,1.05c1.814-0.747,2.992-2.514,2.992-4.472V64.628h285.283v26.513 c0,1.958,1.177,3.725,2.991,4.472c1.814,0.756,3.891,0.342,5.284-1.05l42.802-42.802c1.894-1.895,1.894-4.967,0-6.86L372.51,2.1 c-1.393-1.393-3.469-1.807-5.284-1.051c-1.814,0.748-2.991,2.514-2.991,4.472v26.515H78.952V5.521c0-1.957-1.177-3.724-2.992-4.472 c-1.814-0.756-3.892-0.342-5.284,1.051L27.875,44.901c-1.894,1.893-1.894,4.965,0,6.86L70.676,94.563z"/> </g> </svg>
                                            </div>
                                            <input type="text" value="{{isset($tempData->total_project_area) ? $tempData->total_project_area : ''}}" class="total_project_area price-only" onkeyup="changeData(this.value,'total_project_area')">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mt-2">
                                        <label for="">Başlangıç Tarihi</label>
                                        <div class="icon-input">
                                            <div class="icon-area">
                                                <i class="fa fa-calendar-days"></i>
                                            </div>
                                            <input type="date" value="{{isset($tempData->start_date) ? $tempData->start_date : ''}}" class="start_date" onchange="changeData(this.value,'start_date')" onkeyup="changeData(this.value,'start_date')">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mt-2">
                                        <label for="">Bitiş Tarihi</label>
                                        <div class="icon-input">
                                            <div class="icon-area">
                                                <i class="fa fa-calendar-days"></i>
                                            </div>
                                            <input type="date" value="{{isset($tempData->end_date) ? $tempData->end_date : ''}}" class="end_date" onchange="changeData(this.value,'end_date')" onkeyup="changeData(this.value,'end_date')">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group description-field">
                            <label for="">Bu Projede Bloklar Var mı? <span class="required">*</span></label>
                            <div class="form-group">
                                <div class="flex">
                                    <div class="form-check form-switch" style="display: inline-block;">
                                        <input @if(isset($tempData->has_blocks) && $tempData->has_blocks) checked @endif class="form-check-input has_blocks_input" name="has_blocks" value="1" type="radio" role="switch" id="yes" >
                                        <label for="yes" class="form-check-label">Evet</label>
                                    </div>
                                    <div class="form-check form-switch mx-3" style="display: inline-block;">
                                        <input @if(isset($tempData->has_blocks) && !$tempData->has_blocks) checked @endif  name="has_blocks" class="form-check-input has_blocks_input" value="0" type="radio" role="switch" id="no" >
                                        <label class="form-check-label" for="no">Hayır</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="d-flex ai-center has_blocks-open @if(isset($tempData->has_blocks)) @if(!$tempData->has_blocks) d-none @endif @else d-none  @endif">Bloklar <div class="add-block-button"><i class="fa fa-plus"></i></div> </h4>
                        <div class="blocks has_blocks-open @if(isset($tempData->has_blocks)) @if(!$tempData->has_blocks) d-none @endif @else d-none @endif">
                            @if(isset($tempData->blocks) && count($tempData->blocks) > 0)
                                @foreach($tempData->blocks as $key => $block)
                                    <div class="block @if($key == 0) active @endif">
                                        {{$block}}
                                        <div class="remove-block">Sil</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <h4 style="display: inline-block;" class=" housings_title has_blocks-close @if(isset($tempData->has_blocks)) @if($tempData->has_blocks) d-none @endif @else d-none @endif">Bu @if(isset($tempData->has_blocks) && $tempData->has_blocks) Blokta @else Projede @endif  Kaç Adet @if($housingTypeTempX) {{$housingTypeTempX->title}} @endif Var</h4>
                        <div class="d-flex mt-3 mb-3" style="align-items: center;">
                            <input style="width: 150px;" value="@if(isset($tempData->has_blocks) && $tempData->has_blocks) {{isset($tempData->house_count0) ? $tempData->house_count0 : ''}} @else {{isset($tempData->house_count) ? $tempData->house_count : ''}} @endif" class="form-control housing_count_input has_blocks-close @if(isset($tempData->has_blocks)) @if($tempData->has_blocks) d-none @endif @else d-none @endif" type="text" id="house_count" name="house_count" placeholder="Kaç Adet Konutunuz Var" />
                            <span id="generate_tabs" style="width: 230px;justify-content: center" class="mx-2 d-flex btn btn-primary has_blocks-close @if(isset($tempData->has_blocks)) @if($tempData->has_blocks) d-none @endif @else d-none @endif">İlan Formunu Oluştur</span>
                        </div>
                        
                        
                        <div class="row full-area d-none">
                            <div class="col-sm-12">
                                <div class="card p-3">
                                    <div class="tab-content" id="pricingTabContent" role="tabpanel">
                                        <div id="renderForm1"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="address housing_after_step d-none">
                                <span class="section-title">Adres Bilgileri</span>
                                <div class="card">
                                    <div class="row px-5 py-4">
                                        <div class="col-md-4">
                                            <label for="">İl <span class="required">*</span></label>
                                            <select onchange="changeData(this.value,'city_id')" name="city_id" id="cities" class="form-control">
                                                <option value="">İl Seç</option>
                                                @foreach($cities as $city)
                                                    <option {{isset($tempData->city_id) && $tempData->city_id == $city['id'] ? "selected" : ''}} value="{{$city['id']}}">{{$city['title']}}</option>
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
                                </div>
                                <div>
                                    <input name="location" class="form-control" id="location" readonly type="hidden"
                                                value="@if(isset($tempData->location)){{$tempData->location}}@else 39.1667,35.6667 @endif" />
                                    <div id="mapContainer" style="height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                        <span class="section-title mt-4 housing_after_step d-none">Kapak Fotoğrafı</span>
                        <div class="cover-photo-full card py-2 px-5 housing_after_step d-none">
                            <input type="file" name="cover-image" class="cover_image d-none">
                            <div class="upload-container col-md-4 col-xl-3 cover-photo-area" ondrop="handleDrop(event)" ondragover="allowDrop(event)" id="resim-surukle">
                                <div class="border-container">
                                  <div class="icons fa-4x">
                                    <i class="fas fa-file-image" data-fa-transform="shrink-2 up-4"></i>
                                  </div>
                                  <!--<input type="file" id="file-upload">-->
                                  <p>Bilgisayardan Fotoğraf Ekle <span>veya sürükle bırak</span></p>
                                </div>
                              </div>
                            <div class="cover-photo">
                                @if(isset($tempData->cover_image) && $tempData->cover_image)
                                    <div class="project_imagex">
                                        <img src="{{URL::to('/')}}/project_images/{{$tempData->cover_image}}" alt="">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <span class="section-title mt-4 housing_after_step d-none">Proje Galerisi</span>
                        <div class="photo card py-2 px-5 housing_after_step d-none">
                            <input type="file" multiple name="project-images" class="project_image d-none">
                            <div class="upload-container col-md-4 col-xl-3 photo-area" ondrop="handleDrop2(event)" ondragover="allowDrop2(event)">
                                <div class="border-container">
                                  <div class="icons fa-4x">
                                    <i class="fas fa-file-image" data-fa-transform="shrink-2 up-4"></i>
                                  </div>
                                  <!--<input type="file" id="file-upload">-->
                                  <p>Bilgisayardan Fotoğraf Ekle <span>veya sürükle bırak</span></p>
                                </div>
                            </div>
                            <div class="photos">
                                @if(isset($tempData->images) && $tempData->images)
                                    @foreach($tempData->images as $image)
                                        <div class="project_imagex"  order="{{$image}}">
                                            <img src="{{URL::to('/')}}/project_images/{{$image}}" alt="">
                                            <div class="image-buttons">
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <span class="section-title mt-4 housing_after_step d-none">Ruhsat Belgesi / Tapu Belgesi</span>
                        <div class="cover-photo-full card py-2 px-5 housing_after_step d-none">
                            <input type="file" name="cover-image" class="document d-none">
                            <div class="upload-container col-md-4 col-xl-3 cover-document-area" ondrop="handleDrop3(event)" ondragover="allowDrop3(event)">
                                <div class="border-container">
                                  <div class="icons fa-4x mb-4">
                                    <i class="fas fa-file-image" data-fa-transform="shrink-3 down-2 left-6 rotate--45"></i>
                                    <i class="fas fa-file-alt" data-fa-transform="shrink-2 up-4"></i>
                                    <i class="fas fa-file-pdf" data-fa-transform="shrink-3 down-2 right-6 rotate-45"></i>
                                  </div>
                                  <!--<input type="file" id="file-upload">-->
                                  <p>Bilgisayardan Dosya Ekle <span>veya sürükle bırak</span></p>
                                </div>
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
                        
                        
                        <div class="second-area-finish">
                            <div class="finish-tick ">
                                <input type="checkbox" id="rules_confirmx" value="1" class="rules_confirm" >
                                <label for="rules_confirmx">
                                    <span class="rulesOpen">İlan verme kurallarını</span>
                                    <span>okudum, kabul ediyorum</span>
                                </label>
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
                <div class="row" style="align-items: flex-end;">
                    <div class="col-md-4">
                        <div class="doping-square @if(isset($tempDataFull) && isset($tempData) && isset($tempData->featured) && $tempData->featured) selected @endif" data-id="1">
                            <div class="row" style="align-items: center">
                                <div class="col-md-12">
                                    <span class="doping-is-selected">@if(isset($tempDataFull) && isset($tempData) && isset($tempData->featured) && $tempData->featured) Seçildi @else Seçilmedi @endif </span>
                                    <img src="{{ URL::to('/') }}/images/emlaksepettelogo.png" alt="">
                                    <h4 class="mt-3">Öne Çıkarılanlar Vitrini</h4>
                                    <span>İlanınız anasayfamızda önce çıkan emlak ilanları sekmesinde yer alsın.</span>
                                    <select name="" id="" class="form-control mt-3">
                                        @foreach($featuredPrices as $price)
                                            <option @if(isset($tempDataFull) && isset($tempData) && isset($tempData->featured_data_day) && $tempData->featured_data_day == $price->day) selected @endif value="{{$price->day}}">{{$price->day / 7}} Hafta ({{$price->price}} TL)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="doping-square @if(isset($tempDataFull) && isset($tempData) && isset($tempData->top_row) && $tempData->top_row) selected @endif" data-id="2">
                            <div class="row" style="align-items: center">
                                <div class="col-md-12">
                                    <span class="doping-is-selected">@if(isset($tempDataFull) && isset($tempData) && isset($tempData->top_row) && $tempData->top_row) Seçildi @else Seçilmedi @endif</span>
                                    <img src="{{ URL::to('/') }}/images/emlaksepettelogo.png" alt="">
                                    <h4 class="mt-3">Üst Sıradayım</h4>
                                    <span>İlanınız anasayfamızda önce çıkan emlak ilanları sekmesinde yer alsın.</span>
                                    <select name="" id="" class="form-control mt-3">
                                        @foreach($topRowPrices as $price)
                                            <option @if(isset($tempDataFull) && isset($tempData) && isset($tempData->top_row_data_day) && $tempData->top_row_data_day == $price->day) selected @endif value="{{$price->day}}">{{$price->day / 7}} Hafta ({{$price->price}} TL)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="without-dopingxx mt-4 mb-5">
                        <button class="payment-area d-flex btn btn-info">Devam</button>
                    </div>
                </div>
            </div>
            <div class="fourth-area d-none">
                <div class="row" style="justify-content:center;">
                    <div class="col-md-5">
                        <div class="finish-area">
                            <div class="icon"><i class="fa fa-thumbs-up"></i></div>
                            <div class="text">Başarıyla ilan eklediniz</div>
                            <div class="text"><a href="{{route('institutional.projects.index')}}" class="btn btn-info">Mağazama Git</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="paymentModalLabel">Emlak Sepette Ödeme Adımı</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                &times;
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="invoice">
                                <div class="invoice-header mb-3">
                                    <strong>Fatura Tarihi: {{ date('d.m.Y') }}</strong>
                                </div>

                                <div class="invoice-body">
                                    <table class="table table-bordered d-none d-md-table"> <!-- Tabloyu sadece tablet ve daha büyük ekranlarda göster -->
                                        <thead>
                                            <tr>
                                                <th>Ürün Adı</th>
                                                <th>Miktar</th>
                                                <th>Fiyat</th>
                                                <th>Toplam</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Doping Ücreti</td>
                                                <td>1</td>
                                                <td>2500 ₺</td>
                                                <td>2500 ₺</td>
                                            </tr>
                                        </tbody>
                                    </table>
                        
                                    <!-- Mobilde sadece alt alta liste göster -->
                                    <div class="d-md-none">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <strong>Ürün Adı:</strong> Doping Ücreti
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Miktar:</strong> 1
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Fiyat:</strong> 2500 ₺
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Toplam:</strong> 2500 ₺
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="invoice-total mt-3">
                                    <strong class="mt-3">EFT/Havale yapacağınız bankayı seçiniz</strong>
                                    <div class="row mb-3 px-5 mt-3">
                                        @foreach ($bankAccounts as $bankAccount)
                                            <div class="col-md-4 bank-account" data-id="{{ $bankAccount->id }}"
                                                data-iban="{{ $bankAccount->iban }}"
                                                data-title="{{ $bankAccount->receipent_full_name }}">
                                                <img src="{{ URL::to('/') }}/{{ $bankAccount->image }}" alt=""
                                                    style="width: 100%;height:100px;object-fit:contain;cursor:pointer">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div id="ibanInfo"></div>
                                    <strong>Ödeme işlemini tamamlamak için, lütfen bu
                                        <span style="color:red" id="uniqueCode"></span> kodu kullanarak ödemenizi
                                        yapın. IBAN açıklama
                                        alanına
                                        bu kodu eklemeyi unutmayın. Ardından "Ödemeyi Tamamla" düğmesine tıklayarak işlemi
                                        bitirin.</strong>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @if ((Auth::check() && Auth::user()->type == '2') || (Auth::check() && Auth::user()->parent_id)) disabled @endif
                                class="btn btn-primary btn-lg btn-block mb-3" id="completePaymentButton">Satın Al
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="finalConfirmationModal" tabindex="-1" role="dialog"
                aria-labelledby="finalConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="finalConfirmationModalLabel">Ödeme Onayı</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Ödemeniz başarıyla tamamlamak için lütfen aşağıdaki adımları takip edin:</p>
                            <ol>
                                <li>
                                    <strong style="color:red" id="uniqueCodeRetry"></strong> kodunu EFT/Havale açıklama
                                    alanına yazdığınızdan emin olun.
                                </li>
                                <li>
                                    Son olarak, işlemi bitirmek için aşağıdaki butona tıklayın: <br>
                                    <button type="submit" class="btn btn-primary without-doping mt-3">Ödemeyi Tamamla
                                        <svg viewBox="0 0 576 512" style="width: 16px;color: #fff;fill: #fff;" class="svgIcon">
                                            <path
                                                d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24H360c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z">
                                            </path>
                                        </svg></button>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="rulesOpenModal" tabindex="-1" role="dialog"
                aria-labelledby="finalConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="finalConfirmationModalLabel">İlan Verme Kuralları</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                &times;
                            </button>
                        </div>
                        <div class="modal-body">
                            <ol>
                                <li> İlan yayıncısı EMLAKSEPETTE’de ilanlarını yayınlayarak “İlan Yayınlama Kuralları”nı kabul etmiş sayılır. Bu sebeple ilan yayınlayan her kişi ve kurum kurallara riayet etme mecburiyetindedir.</li>
                                <li> İlan yayıncıları ilanın içeriğiyle ilgili bilgilerin doğruluğundan sorumludur. İlan bilgileri içerisindeki gerçek dışı fiyat, metrekare, açıklama, kat sayısı gibi parametreler sonucunda ilan, ilan sahibinde danışılmaksızın sistemden kaldırılabilir.</li>
                                <li> İlan içerisinde yer alan fotoğrafların emlak ile ilişkili olması, ilanı yayınlayan kurumun ya da kişinin logo, tanıtım görseli vb.. olmaması gerekmektedir. Sistemde bulunan diğer ilanlardan ayrışmak maksadıyla ve haksız rekabet yaratmak amacıyla ilan resimlerinin üzerine herhangi bir yazı, ikon, şerit, çerçeve yerleştirilmesi fotoğrafın yayından kaldırılmasına sebep olabilir.</li>
                                <li> İlan sahibi aynı gayrimenkulle ilgili sadece bir adet ilan yayınlayabilir. Aynı emlak ile ilgili girilecek çoklu kayıtlar mükerrer ilan sayılacaktır. Mükerrer ilanlar haksız rekabete yol açtığından ötürü sistemden ilan sahibine duyurmaksızın tamamen kaldırılabilir.</li>
                                <li> İlan başlığı içerisinde yalnızca ilanda söz konusu olan gayrimenkule ait bilgiler verilebilir. İlan başlığı içerisinde iletişim bilgisi gibi haksız rekabete yol açabilecek bilgilerin yer verilmesi ilanın yayından kaldırılmasına sebep olabilir.</li>
                                <li> İlan başlığı içerisinde Türkçe karakterler, Türk alfabesinde bulunmayan X, W, Q harfleri, rakamlar, nokta(.), virgül(,), ünlem(!) noktalama işaretleri kullanılabilir. Bu karakterlerin dışında kullanılacak alfanumerik olmayan, rekabete gölge düşürecek hiçbir karakterin ilanlarda yer almasına izin verilmeyecektir.</li>
                                <li> İlan sahibi tarafından satılmış ya da kiralanmış gayrimenkullere ait ilanlar, ilan sahibi tarafından arşivlenmelidir. EMLAKSEPETTE sistemindeki operasyonu tamamlanmış ilanları belirli periyotlarla sistem haricine çıkarma hakkını saklı tutar. Bu işlem sonrasında doğacak yedekleme problemlerinden EMLAKSEPETTE sorumlu değildir.</li>
                                <li> İlan bilgilerinin doluluğu ve doğruluğu, fotoğrafların kalitesi ve geçmiş hareketler göz önünde bulundurularak ilan sahiplerinin ilanları değerlendirilebilir. İlan yayınlama kurallarını sıklıkla ihlal eden kullanıcıların sözleşmesini tek taraflı olarak fesh etme hakkını EMLAKSEPETTE saklı tutar. Aynı şekilde ilan bilgilerini daimi olarak doğru ve hatasız giren kullanıcılar, haksız rekabete yol açmayacak şekilde sistem algoritması tarafından ödüllendirilerek ilanların öne çıkması sağlanabilir.</li>
                                <li> İlan içerisinde yer alan ifadelerin cinsiyet, ırk, renk, dil, din, inanç, mezhep, felsefi ve siyasi görüş, etnik köken, servet, doğum, medeni hâl, sağlık durumu, engellilik ve yaş temellerine dayalı ayrımcılık niteliği taşımaması yasal bir zorunluluktur. Bu tür ifadeler kullanılması hukuka aykırı olup, Türkiye İnsan Hakları ve Eşitlik Kurumu (TİHEK) tarafından idari para cezası verilmesine sebep olabilir. Ayrıca, İlanda belirtilen ifadelerle ayrımcılığa yol açabilecek bilgilere yer verilmesi ilgili ifadelerin ve/veya ilanın yayından kaldırılması sebebidir.</li>
                                <li> İlan yayınlama kurallarına riayet etmeyen kullanıcıların ilanlarındaki bilgilerinin bir kısmı ya da tamamının yayından kaldırılması hakkını EMLAKSEPETTE saklı tutar.</li>
                                <li> Bireysel ve Kurumsal Hesap Sahibi, Portal üzerinden ilan verme, ilan düzenleme ve ilanı yeniden yayına alma işlemlerinden önce yasal mevzuat gereği sistem üzerinden kimliklerini doğrulamalıdır. Bireysel ve Kurumsal Hesap Sahibi, doğrulama işlemi yapmadıkları takdirde ilgili mevzuat uyarınca ilan veremeyeceklerini kabul eder. </li>
                                <li> İlan başlığında ve ilan açıklama bölümünde sadece gayrimenkul hakkındaki bilgiler yer almalıdır.</li>
                                <li> İlan başlığında ve ilan açıklama bölümlerde reklam içerikli yazı yazılmaması, link ve ürüne ait fotoğrafların eklenmemesi gerekmektedir.</li>
                                <li> Yayınlanmak istenen ilanlarda kullanılan fotoğraflar, videolar ve 3 Boyutlu Tur görüntüsü, satılan/kiralanan gayrimenkule ait olmalıdır. Yayınlanan içerikler, fotoğraf, video veya link olarak ilana eklenen 3 Boyutlu Tur görüntüler hakkında EMLAKSEPETTE'nin herhangi bir sorumluluğu bulunmamaktadır.</li>
                                <li> İlan girişlerinde belirtilen kriterlerde (metrekare, oda sayısı, bulunduğu kat, fiyat v.b.) doğru bilgiler yer almalıdır.</li>
                                <li> Eklenen fotoğrafların, videoların, 3 Boyutlu Tur görüntülerinin içeriğinde firma logoları, telefon numarası veya farklı web sitelerinin link, logo ya da isimleri yer almamalıdır. Seçili vitrin resmi olarak işaretlenen görsellerde; firma logoları, telefon numarası, web sitelerinin linki, renkli arka plan, renkli çerçeve, metin içerikleri,firma isimleri, photoshop ve benzeri uygulamalarla eklentiler yer almamalıdır.</li>
                                <li> Sistem içerisindeki farklı bir kullanıcının fotoğrafı / fotoğrafları kullanılmamalıdır.</li>
                                <li> Bir gayrimenkulü satmak için ayrı, kiralamak için ayrı ilan verilmelidir. Aynı ilanda hem satılık hem kiralık detayları bulunamaz.</li>
                                <li> Girilen bir ilanın aynısı, ilk girilen ilan silinerek sisteme yeniden girilemez. Bir ilanın silinip sisteme tekrar yeni baştan girilmesi ve benzeri nitelikteki faaliyetleri gerçekleştiren hesap sahiplerinin bu ilanları silinebilir, hesapları geçici olarak durdurulabilir veya iptal edilebilir.</li>
                                <li> Aynı sitede veya blokta bulunan ve aynı özellikleri taşıyan gayrimenkuller için ayrı ilan girişi yapılmaması, tek bir ilan verilmesi ve bu ilanın açıklamasında aynı konumda farklı dairelerin de olduğunun belirtilmesi gerekmektedir. Aynı özellikte ikinci ilan girişi mükerrer (aynı kayıt) sayılmaktadır.</li>
                                <li> Her bir ilan için farklı resimler kullanılmalıdır, aynı konumda dahi olsa aynı resim ikinci bir ilanda kullanılmamalıdır.</li>
                                <li> Emlak ilan girişleri mutlaka mal sahibi tarafından veya mal sahibinin onayı alınarak yapılmalıdır. Bu sorumluluk ilan verene aittir. Mal sahibinin itirazı doğrultusunda hesap sahiplerinin bu ilanları silinebilir, hesapları geçici olarak durdurulabilir veya iptal edilebilir.</li>
                                <li> Satılık veya kiralık gayrimenkuller için temsili fiyat verilmemelidir.</li>
                                <li> İlan açıklama bölümlerinde web sayfası, mail adresi ve firma iletişim bilgilerine yer verilmemelidir. Telefon numarası ve kullanıcı adı sadece “Kullanıcı bilgileri” bölümünde yayınlanmalıdır. Mağaza kullanıcıları mağazaları için tanıtım sayfası hazırlayarak iletişim ve adres bilgilerini bu alanda yayınlayabilirler ancak web sayfası ve mail adreslerini belirtmemeleri gerekir</li>
                                <li> Satılan ya da kiralanan ürünler Satıldı / Kiralandı olarak tekrar yayına verilemez. Satış işleminin devam ettiği izlenimi yaratan ya da tüketiciyi aldatma ve yanıltma ihtimali yaratabilecek “opsiyonlanmıştır', “kaporası alınmıştır”, "satılmıştır", "ilginiz için teşekkürler" gibi ya da bunlara benzer anlamda ibareler içeren ilanlar yayına alınmaz, yayında olan ilanlar yayından kaldırılır.</li>
                                <li> İlan verme aşamasında, ilana ait belirlenmiş bazı kriterler için girilen bilgiler, ilan veren tarafından sonradan değiştirilemez, ilan veren bu konuda itirazda bulunmayacağını peşinen kabul etmektedir. EMLAKSEPETTE hangi kriterlere ait bilgilerin değiştirilemeyeceğini belirleme, zaman içinde belirlediği kriterlerde değişiklik yapma ve değişiklik yapma tarihi itibariyle belirlediği kriterleri tüm ilanlara uygulama hakkını saklı tutmaktadır.</li>
                                <li> Günlük Kiralık İlan yayınlayanlar; 22/11/2016 tarihli Olağanüstü Hal Kapsamında Bazı Düzenlemeler Yapılması Hakkında Kanun Hükmünde Kararname ile getirilen yeni düzenlemelere, yasal mevzuata ve Portal'daki İlan Yayınlama Kurallarına uygun hareket etmekle yükümlüdür. Yasal yükümlülüklerini yerine getirmeden günlük kiralık ilan yayınlayanlar hakkında uygulanacak cezalardan münhasıran Günlük Kiralık İlan Veren sorumlu olacaktır.</li>
                                <li> Turizm amaçlı kiralık ilan yayınlayanlar; “7464 sayılı “Konutların Turizm Amaçlı Kiralanmasına ve Bazı Kanunlarda Değişiklik Yapılmasına Dair Kanun” ile getirilen yeni düzenlemelere, yasal mevzuata ve Portal'daki İlan Yayınlama Kurallarına uygun hareket etmekle yükümlüdür. Yasal yükümlülüklerini yerine getirmeden turizm amaçlı kiralık ilan yayınlayanlar hakkında uygulanacak cezalardan münhasıran İlan Veren sorumlu olacaktır.</li>
                                <li> Konut> Kiralık kategorisinde sadece aylık kiralık ilanlar verilebilir. Günlük, haftalık vb. kiralık ilanların Günlük Kiralık kategorisinden verilmesi gerekmektedir.</li>
                                <li> Günlük kiralık dairelerde, fiyat kriterine günlük kiralama bedeli girilmelidir.</li>
                                <li> İlanın işyeri ya da konut olarak değerlendirilmesinin kararı ilan verenin sorumluluğundadır. Seçilmiş kategori doğru olarak kabul edilir, ilan verme kurallarına aykırı bir durum yer almıyor ise ilan yayına alınır.</li>
                                <li> Her farklı taşınmaz için ayrı ilan verilmelidir. Farklı konumdaki, taşınmazlar için toplu satış yapılamamaktadır.</li>
                                <li> Turistik Tesis kategorisinde sadece turistik bir tesisin tamamı kiralanabilir ya da tamamının satışı yapılabilir.</li>
                                <li> 13 Eylül 2018 tarihli "Türk Parasının Kıymetini Koruma hakkında 32 sayılı Kararda Değişiklik Yapılmasına Dair Karar"da, 6 Ekim 2018 tarihli “Türk Parası Kıymetini Koruma Hakkında 32 Sayılı Karara İlişkin Tebliğ”de ve 16 Kasım 2018 tarihli ve 30597 sayılı Türk Parası Kıymetini Koruma Hakkında 32 Sayılı Karara İlişkin Tebliğ'de Değişiklik Yapılmasına Dair Tebliğ'de belirtilen sözleşme tiplerine dair kategorilerdeki ilanların fiyat bilgilerinin Türk Lirası olarak girilmesi gerekmektedir.</li>
                                <li> Metaverse, OVR, sanal arazi, sanal dünya üzerinden arazi ve arsa satışları üzerinden arazi ve arsa satışlarına izin verilmez.</li>
                            </ol>
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

    
        

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.min.js"></script>
        <script src="{{ URL::to('/') }}/adminassets/assets/js/moment.min.js" integrity="sha512-CryKbMe7sjSCDPl18jtJI5DR5jtkUWxPXWaLCst6QjH8wxDexfRJic2WRmRXmstr2Y8SxDDWuBO6CQC6IE4KTA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{ URL::to('/') }}/adminassets/assets/js/jquery.daterangepicker.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&callback=initMap" async defer></script>
        <script>
            var selectedDopings = [];
            var selectedBlock = 0;
            var copyHousings = [];
            var cityName = "";
            var countyName = "";
            var neighbourhoodName = "";
            var fullHouses = [];
            var selectedid = @if(isset($tempData) && isset($tempData->housing_type_id)) {{$tempData->housing_type_id}} @else 0 @endif;
            @if(isset($tempData->has_blocks))
                @if($tempData->has_blocks)
                    var hasBlocks = true;
                @else
                    var hasBlocks = false;
                @endif
            @else
                var hasBlocks = false;
            @endif
            var blockHouseCount = [];
            var blockNames = [];
            
            var map;
            var markers = [];
            function initMap(cityName,zoomLevel) {
                // Harita oluştur
                map = new google.maps.Map(document.getElementById('mapContainer'), {
                    zoom: 10,  // Başlangıç zoom seviyesi
                    center: {lat: 41.0082, lng: 28.9784}  // Başlangıç merkez koordinatları (İstanbul örneği)
                });

                google.maps.event.addListener(map, 'click', function(event) {
                    clearMarkers(); // Tüm işaretçileri temizleyin
                    placeMarker(event.latLng); // Yeni işaretçiyi ekleyin
                });

                if (cityName) {
                    // Google Haritalar Geocoding API'yi kullanarak şehir adını koordinatlara dönüştür
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({ address: cityName }, function(results, status) {
                    if (status === 'OK') {
                        // Başarılı ise haritayı zoomla
                        map.setCenter(results[0].geometry.location);
                        map.setZoom(zoomLevel);  // İstediğiniz zoom seviyesini ayarlayabilirsiniz
                    } else {
                        alert('Şehir bulunamadı: ' + status);
                    }
                    });
                }
            }

            
            window.initMap = initMap;

            function placeMarker(location) {
                // İşaretçiyi oluşturun
                var marker = new google.maps.Marker({
                    position: location,
                    map: map
                });

                // Bilgi penceresi oluşturun (isteğe bağlı)
                var infowindow = new google.maps.InfoWindow({
                    content: 'Koordinatlar: ' + location.lat() + ', ' + location.lng()
                });

                changeData(location.lat()+','+location.lng(),'location');

                // İşaretçiye tıklandığında bilgi penceresini gösterin
                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                });

                markers.push(marker); // İşaretçiyi dizide saklayın
            }

            
            function clearMarkers() {
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(null);
                }
                markers = [];
            }
            

            @if(isset($tempData->city_id))
                @php 
                    $cityJs = DB::table('cities')->where('id',$tempData->city_id)->first();
                @endphp

                cityName = "{{$cityJs->title}}";
                @if(isset($tempData->county_id))
                    @php 
                        $countyJs = DB::table('districts')->where('ilce_key',$tempData->county_id)->first();
                    @endphp

                    countyName = "{{$countyJs->ilce_title}}";
                    @if(isset($tempData->neighbourhood_id))
                        @php 
                            $countyJs = DB::table('neighborhoods')->where('mahalle_id',$tempData->neighbourhood_id)->first();
                        @endphp

                        neighbourhoodName = "{{$countyJs->mahalle_title}}";
                        
                        setTimeout(() => {
                            initMap(cityName+','+countyName+','+neighbourhoodName,13);
                        }, 1000);
                    @else 
                        setTimeout(() => {
                        initMap(cityName+','+countyName,13);
                        }, 1000);
                    @endif
                @else
                    setTimeout(() => {
                        initMap(cityName,10);
                    }, 1000);
                @endif
            @endif
            @if(isset($tempDataFull->data) && isset($tempData->statuses) && $tempData->statuses)
                @if(in_array('3',$tempData->statuses))
                    var isContinueProject = 1;
                @else
                    var isContinueProject = 0;
                @endif
            @else
                var isContinueProject = 0;
            @endif


            @if(isset($tempDataFull->data) && isset($tempData->step1_slug) && $tempData->step1_slug )
                @if($tempData->step1_slug == "arsa")
                    var disabledBlocks = 1;
                @else
                    var disabledBlocks = 0;
                @endif
            @else
                var disabledBlocks = 0;
            @endif

            $('.pop-back').click(function(){
                console.log("asd");
                $('.pop-up-v3').addClass('d-none')
            })


            $('.has_blocks_input').change(function(){
                if($(this).val() == "1"){
                    changeData(1,"has_blocks")
                    $('.has_blocks-open').removeClass('d-none')
                    $('.has_blocks-close').addClass('d-none')
                    hasBlocks = true;
                }else{
                    $('.has_blocks-open').addClass('d-none')
                    $('.has_blocks-close').removeClass('d-none')
                    changeData(0,"has_blocks")
                    hasBlocks = false;
                }
            })

            @if(isset($tempData->blocks))
                @foreach($tempData->blocks as $key=>$block)
                    @if(isset($tempData->{'house_count'.$key}))
                        blockHouseCount.push({{($tempData->{'house_count'.$key})}});
                        blockNames.push("{{$block}}");
                    @endif
                @endforeach
            @endif
            function generateUniqueCode() {
                return Math.random().toString(36).substring(2, 10).toUpperCase();
            }

            $('.housing_count_input').keyup(function(){
                if(hasBlocks){
                    blockHouseCount[selectedBlock] = this.value;
                    changeData(this.value,'house_count'+selectedBlock)
                }else{
                    changeData(this.value,'house_count')
                }
            })

            $('.add-block-button').click(function(){
                $('.pop-up-v3').removeClass('d-none');
            })

            var houseCount = 0;

            const houseCountInput = document.getElementById('house_count');
            const generateTabsButton = document.getElementById('generate_tabs');
            const tabsContainer = document.getElementById('tabs');

            generateTabsButton.addEventListener('click', function () {
                $('.full-area').removeClass('d-none')
                $(this).append('<div class="loading-icon"><i class="fa fa-spinner"></i></div>')
                $('.total-house-text').html(houseCountInput.value)
                $('.bottom-housing-area').removeClass('d-none')
                $('.pop-up-v2').addClass('d-none')
                
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
                houseCount = parseInt(houseCountInput.value);

                if (isNaN(houseCount) || houseCount <= 0) {
                    alert('Lütfen geçerli bir sayı girin.');
                    return;
                }

                var htmlContent = '';
                $.ajax({
                    method: "GET",
                    url: "{{ route('institutional.ht.getform') }}",
                    data: {
                        id: selectedid
                    },
                    success: function(response) {
                        for(var i = 0 ; i < 1; i++ ){
                            htmlContent += '<div class="tab-pane fade show '+(i == 0 ? 'active' : '')+'" id="TabContent'+(i+1)+'" role="tabpanel">'+
                                '<div id="renderForm'+(i+1)+'"></div>'+
                            '</div>';
                        }

                        $('.tab-content').html(htmlContent)

                        $('#generate_tabs .loading-icon').remove();

                    for (let i = 1; i <= 1; i++) {
                        formRenderOpts = {
                            dataType: 'json',
                            formData: response.form_json
                        };

                        var renderedForm = $('<div>');
                        renderedForm.formRender(formRenderOpts);
                        var renderHtml = renderedForm.html().toString();
                        renderHtml = renderHtml.toString().split('images[][]');
                        renderHtml = renderHtml[0];
                        var json = JSON.parse(response.form_json);
                        for(var lm = 0 ; lm < json.length; lm++){
                            if(json[lm].type == "checkbox-group"){
                            var json = JSON.parse(response.form_json);
                            var renderHtml = renderHtml.toString().split(json[lm].name+'-');
                            renderHtmlx = "";
                            for(var t = 0 ; t < renderHtml.length ; t++){
                                if(t != renderHtml.length - 1){
                                    renderHtmlx += renderHtml[t]+(json[lm].name.split('[]')[0])+i+'[]-'+i;
                                }else{
                                    renderHtmlx += renderHtml[t];
                                }
                            }

                            renderHtml = renderHtmlx;
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
                    
                    confirmHousings();

                    $('.dropzonearea').closest('.formbuilder-file').remove();
                    

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
                                if(!$(item).val() || $(item).val() == "Seçiniz"){
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
                        var transactionIndex = 0;
                        $('.tab-pane').prepend('<div class="loading-icon-right"><i class="fa fa-spinner"></i></div>');
                        var order = parseInt($(this).val()) - 1;
                        var currentOrder = parseInt($(this).closest('.item-left-area').index());
                        var arrayValues = {};
                        var formData = new FormData();
                        formData.append('_token', csrfToken);
                        formData.append('last_order',(parseInt($(this).val()) - 1));
                        formData.append('new_order',(parseInt($('.house_order_input').val()) - 1));
                        formData.append('item_type',1);
                        
                        $.ajax({
                            type: "POST",
                            url: "{{route('institutional.temp.order.copy.data')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                var data = response.data;
                                for(var i = 0 ; i < data.length; i++){
                                    var key = Object.keys(data[i])
                                    if(data[i].type == "select"){
                                        $('select[name="'+key[0]+'[]"]')
                                        if(data[i][key[0]] == null){
                                            $('select[name="'+key[0]+'[]"]').find('option').prop('selected',false);
                                        }else{
                                            $('select[name="'+key[0]+'[]"]').val(data[i][key[0]]);
                                        }
                                    }else{
                                        if(data[i].type != "file"){
                                            if(data[i].type == "checkbox-group"){
                                                    console.log(data[i][key[0]]);
                                                if(data[i][key[0]] == null){
                                                    $('input[name="'+key[0]+'1[][]"]').prop("checked",false);
                                                }else{
                                                    $('input[name="'+key[0]+'1[][]"]').map((keyx,item) => {
                                                        $(item).prop('checked',false);
                                                        for(var k = 0 ; k < data[i][key[0]].length; k++){
                                                            if($(item).attr('value')){
                                                                if($(item).attr('value').trim() == data[i][key[0]][k]){
                                                                    $(item).prop('checked',true);
                                                                }
                                                            }
                                                        }
                                                        
                                                    })
                                                }
                                            }else{
                                                if(data[i][key[0]] == null){
                                                    $('input[name="'+key[0]+'[]"]').val("");
                                                }else{
                                                    $('input[name="'+key[0]+'[]"]').val(data[i][key[0]]);
                                                }
                                            }
                                        }else{
                                            if(data[i][key[0]] == null){
                                                $('.project_imaget img').remove();
                                            }else{
                                                if($('.project_imaget img').length > 0){
                                                    $('.project_imaget img').attr('src',"{{URL::to('/')}}/storage/project_images/"+data[i][key[0]])
                                                }else{
                                                    $('.project_imaget').html('<img src="'+"{{URL::to('/')}}/storage/project_images/"+data[i][key[0]]+'">')
                                                }
                                            }
                                        }
                                    }
                                }

                                var data2 = response.data2;


                                $('.dec-pay-area').remove();
                                var newOrderx = (parseInt($('.house_order_input').val()));
                                console.log(newOrderx);
                                if(data2['pay-dec-count'+( parseInt($('.house_order_input').val()))]){
                                    $('.installement-dec-pay').closest('.form-group').after(`
                                        <div class="dec-pay-area">
                                            <div class="top">
                                                <h4>Ara Ödemeler</h4>
                                                <button class="btn btn-primary add-pay-dec"><i class="fa fa-plus"></i></button>
                                            </div>
                                            <div class="pay-desc">
                                                <div class="pay-desc-item">
                                                    <div class="row" style="align-items: flex-end;">
                                                        <div class="flex-1">
                                                            <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                        <div class="flex-10">
                                                            <label for="">Ara Ödeme Tutarı</label>
                                                            <input type="text" value="${data2['pay_desc_price'+newOrderx+'0']}" class="price-only form-control pay-desc-price">
                                                        </div>
                                                        <div class="flex-10">
                                                            <label for="">Ara Ödeme Tarihi</label>
                                                            <input type="date" value="${data2['pay_desc_date'+newOrderx+'0']}" class="form-control pay-desc-date">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    `)

                                    for(var i = 1; i < data2['pay-dec-count'+(lastOrders + parseInt($('.house_order_input').val()))]; i++){
                                        $('.pay-desc').append(`
                                            <div class="pay-desc-item">
                                                <div class="row" style="align-items: flex-end;">
                                                    <div class="flex-1">
                                                        <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                    <div class="flex-10">
                                                        <label for="">Ara Ödeme Tutarı</label>
                                                        <input type="text" value="${data2['pay_desc_price'+newOrderx+i] ? data2['pay_desc_price'+newOrderx+i] : ""}" class="price-only pay-desc-price form-control">
                                                    </div>
                                                    <div class="flex-10">
                                                        <label for="">Ara Ödeme Tarihi</label>
                                                        <input type="date" value="${data2['pay_desc_date'+newOrderx+i] ? data2['pay_desc_date'+newOrderx+i] : ""}" class="form-control pay-desc-date">
                                                    </div>
                                                </div>
                                            </div>
                                        `)
                                    }
                                }else{

                                    $('.installement-dec-pay').closest('.form-group').after(`
                                        <div class="dec-pay-area">
                                            <div class="top">
                                                <h4>Ara Ödemeler</h4>
                                                <button class="btn btn-primary add-pay-dec"><i class="fa fa-plus"></i></button>
                                            </div>
                                            <div class="pay-desc">
                                                <div class="pay-desc-item">
                                                    <div class="row" style="align-items: flex-end;">
                                                        <div class="flex-1">
                                                            <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                        <div class="flex-10">
                                                            <label for="">Ara Ödeme Tutarı</label>
                                                            <input type="text" value="" class="price-only form-control pay-desc-price">
                                                        </div>
                                                        <div class="flex-10">
                                                            <label for="">Ara Ödeme Tarihi</label>
                                                            <input type="date" value="" class="form-control pay-desc-date">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    `)
                                }

                                
                                $('.loading-icon-right').remove();
                                $('.copy-item').val('')
                                confirmHousings();
                            },
                        });
                    })

                    if(isContinueProject){
                        $('.continue-disabled').closest('.form-group').remove();
                    }
                    
                    $('.project-disabled').closest('.form-group').remove();
                    
                    $('.rendered-form input').change(function(){
                        if($(this).attr('type') != "file"){
                            var formData = new FormData();
                            var csrfToken = $("meta[name='csrf-token']").attr("content");
                            formData.append('_token', csrfToken);
                            formData.append('value',$(this).val());
                            
                            console.log($(this).attr('name'))
                            formData.append('order',parseInt($('.house_order_input').val()) - 1);
                            formData.append('item_type',1);
                            if($(this).hasClass('only-one')){
                                formData.append('only-one',"1");
                                $(this).closest('.form-group').find('.only-one[value!="'+$(this).val()+'"]').prop('checked',false);
                            }
                            if($(this).attr('type') == "checkbox"){
                                formData.append('checkbox',"1");
                                formData.append('key',$(this).attr('name').replace("[]", "").replace("[]", "").slice(0, -1)+$('.house_order_input').val());
                            }else{
                                formData.append('key',$(this).attr('name').replace("[]", "").replace("[]", ""));
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
                        formData.append('order',parseInt($('.house_order_input').val()) - 1);
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
                        if($(this).val().replace('.','').replace('.','').replace('.','').replace('.','') != parseInt($(this).val().replace('.','').replace('.','').replace('.','').replace('.','').replace('.','') )){
                            if($(this).closest('.form-group').find('.error-text').length > 0){
                                $(this).val("");
                            }else{
                                $(this).closest('.form-group').append('<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                                $(this).val("");
                            }
                            
                        }else{
                            let inputValue = $(this).val();

                            // Sadece sayı karakterlerine izin ver
                            inputValue = inputValue.replace(/\D/g, '');

                            // Her üç basamakta bir nokta ekleyin
                            inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                            $(this).val(inputValue)
                            $(this).closest('.form-group').find('.error-text').remove();
                        }
                    })

                    
                    $('.maks-3').keyup(function(){
                        console.log("asd")
                        if(parseInt($(this).val()) > 3){
                            $(this).val(3);
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
                            var lastOrders = 0;
                            if(hasBlocks){
                                for(var i = 0 ; i < selectedBlock; i++){
                                    lastOrders += parseInt(blockHouseCount[i]);
                                }
                            }
                            formData.append('order',(lastOrders + parseInt($('.house_order_input').val()) - 1));
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

                                $('.tab-pane.active .cover-image-by-housing-type').parent('div').find('.project_imaget').remove()
                                $('.tab-pane.active .cover-image-by-housing-type').closest('.formbuilder-file').append(imageDiv)
                                confirmHousings();
                            };

                            // Resmi okuyun
                            reader.readAsDataURL(input.files[0]);
                            
                        }
                    })

                    
                    $('.installement-dec-pay').closest('.form-group').after(`
                        <div class="dec-pay-area">
                            <div class="top">
                                <h4>Ara Ödemeler</h4>
                                <button class="btn btn-primary add-pay-dec"><i class="fa fa-plus"></i></button>
                            </div>
                            <div class="pay-desc">
                                <div class="pay-desc-item">
                                    <div class="row" style="align-items: flex-end;">
                                        <div class="flex-1">
                                            <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                        </div>
                                        <div class="flex-10">
                                            <label for="">Ara Ödeme Tutarı</label>
                                            <input type="text" value="{{isset($tempData->pay_desc_price10) ? $tempData->pay_desc_price10 : ''}}" class="price-only form-control pay-desc-price">
                                        </div>
                                        <div class="flex-10">
                                            <label for="">Ara Ödeme Tarihi</label>
                                            <input type="date" value="{{isset($tempData->pay_desc_date10) ? $tempData->pay_desc_date10 : ""}}" class="form-control pay-desc-date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `)

                    @if(isset($tempData->{"pay-dec-count1"}))
                        @for($i = 1; $i < $tempData->{"pay-dec-count1"}; $i++)
                            $('.pay-desc').append(`
                                <div class="pay-desc-item">
                                    <div class="row" style="align-items: flex-end;">
                                        <div class="flex-1">
                                            <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                        </div>
                                        <div class="flex-10">
                                            <label for="">Ara Ödeme Tutarı</label>
                                            <input type="text" value="{{ isset($tempData->{"pay_desc_price1".$i}) ? $tempData->{"pay_desc_price1".$i} : ""  }}" class="price-only pay-desc-price form-control">
                                        </div>
                                        <div class="flex-10">
                                            <label for="">Ara Ödeme Tarihi</label>
                                            <input type="date" value="{{isset($tempData->{"pay_desc_date1".$i}) ? $tempData->{"pay_desc_date1".$i} : ""}}" class="form-control pay-desc-date">
                                        </div>
                                    </div>
                                </div>
                            `)
                        @endfor
                    @endif


                    

                    $('.price-only').keyup(function(){
                        $('.price-only .error-text').remove();
                        if($(this).val().replace('.','').replace('.','').replace('.','').replace('.','') != parseInt($(this).val().replace('.','').replace('.','').replace('.','').replace('.','').replace('.','') )){
                            if($(this).closest('.form-group').find('.error-text').length > 0){
                                $(this).val("");
                            }else{
                                $(this).closest('.form-group').append('<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                                $(this).val("");
                            }
                            
                        }else{
                            let inputValue = $(this).val();

                            // Sadece sayı karakterlerine izin ver
                            inputValue = inputValue.replace(/\D/g, '');

                            // Her üç basamakta bir nokta ekleyin
                            inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                            $(this).val(inputValue)
                            $(this).closest('.form-group').find('.error-text').remove();
                        }
                    })

                    $(document).on("click",".remove-pay-dec",function(){
                        var thisx = $(this);
                        var itemIndex = $(this).closest('.pay-desc-item').index();
                        var formData = new FormData();
                        var csrfToken = $("meta[name='csrf-token']").attr("content");
                        formData.append('_token', csrfToken);
                        formData.append('item_index',itemIndex);
                        formData.append('item_type',1);
                        formData.append('active_housing',$('.house_order_input').val());
                        $.ajax({
                            type: "POST",
                            url: "{{route('institutional.temp.order.remove.pay.dec')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                console.log(response);
                                thisx.closest('.pay-desc-item').remove()
                            },
                        });
                    })

                    $(document).on('change','.pay-desc-price',function(){
                        changeData($(this).val(),'pay_desc_price'+($('.house_order_input').val()+''+$(this).closest('.pay-desc-item').index()))
                    })

                    $(document).on('change','.pay-desc-date',function(){
                        changeData($(this).val(),'pay_desc_date'+($('.house_order_input').val()+''+$(this).closest('.pay-desc-item').index()))
                    })

                    $('#tablist').attr('style','height:'+$('.tab-content').css('height')+' !important;flex-wrap:nowrap;overflow:scroll;')
                    },
                    error: function(error) {
                        console.log(error)
                    }
                })
                // Belirtilen sayıda sekme oluştur

            });

            $('.confirm-button-block').click(function(){
                var blockName = $('.block-name').val();
                var housingCount = $('.block-count').val();
                var errors = [];
                if(!$('.block-name').val()){
                    errors.push("Blok ismi boş bırakılamaz");
                    $('.block-name').addClass('error-border')
                }

                if(!$('.block-count').val()){
                    errors.push("Bu Blokta Kaç Tane Konut Var Kısmı Boş Bırakılamaz");
                    $('.block-count').addClass('error-border')
                }
                

                if(errors.length == 0){
                    $('.pop-up-v4').removeClass('d-none');
                    $('.pop-up-v4 .load-area2 span').html('Blok Oluşturuluyor');
                    $('.pop-up-v3').addClass('d-none')
                    $.ajax({
                        url: '{{route("institutional.temp.order.add.house.block")}}',
                        type: 'POST',
                        data: { 
                            block : blockName,
                            item_type : 1,
                            _token : csrfToken
                        },
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            console.log(xhr);
                            // İlerleme durumu değiştikçe çalışacak olan fonksiyon
                            xhr.upload.addEventListener('progress', function(evt) {
                                console.log(evt)
                                if (evt.lengthComputable) {
                                    var percentComplete = (evt.loaded / evt.total) * 100;
                                    $('.progress-bar2').css('width',percentComplete+'%');
                                }
                            }, false);

                            return xhr;
                        },
                        success: function(response) {
                            var html = '<div class="block">'+blockName+
                                '<div class="remove-block">Sil</div>'+
                            '</div>';

                            $('.blocks').append(html);

                            changeData($('.block-count').val(),'house_count'+blockHouseCount.length)
                            blockNames.push(blockName);
                            blockHouseCount.push($('.block-count').val());
                            console.log(blockHouseCount.length);
                            confirmHousings();
                            $('.pop-up-v4').addClass('d-none');
                            if(blockHouseCount.length == 1){
                                $('.block').addClass('active');
                                $('.total-house-text').html($('.block-count').val())
                                $('.bottom-housing-area').removeClass('d-none')
                                
                                houseCount = parseInt($('.block-count').val());

                                if (isNaN(houseCount) || houseCount <= 0) {
                                    alert('Lütfen geçerli bir sayı girin.');
                                }

                                console.log(selectedid);
                                var htmlContent = '';
                                $.ajax({
                                    method: "GET",
                                    url: "{{ route('institutional.ht.getform') }}",
                                    data: {
                                        id: selectedid
                                    },
                                    success: function(response) {
                                        console.log(response)
                                        for(var i = 0 ; i < 1; i++ ){
                                            htmlContent += '<div class="tab-pane fade show '+(i == 0 ? 'active' : '')+'" id="TabContent'+(i+1)+'" role="tabpanel">'+
                                                '<div id="renderForm'+(i+1)+'"></div>'+
                                            '</div>';
                                        }

                                        $('.tab-content').html(htmlContent)

                                        $('#generate_tabs .loading-icon').remove();

                                    for (let i = 1; i <= 1; i++) {
                                        formRenderOpts = {
                                            dataType: 'json',
                                            formData: response.form_json
                                        };

                                        var renderedForm = $('<div>');
                                        renderedForm.formRender(formRenderOpts);
                                        var renderHtml = renderedForm.html().toString();
                                        renderHtml = renderHtml.toString().split('images[][]');
                                        renderHtml = renderHtml[0];
                                        var json = JSON.parse(response.form_json);
                                        for(var lm = 0 ; lm < json.length; lm++){
                                            if(json[lm].type == "checkbox-group"){
                                            var json = JSON.parse(response.form_json);
                                            var renderHtml = renderHtml.toString().split(json[lm].name+'-');
                                            renderHtmlx = "";
                                            for(var t = 0 ; t < renderHtml.length ; t++){
                                                if(t != renderHtml.length - 1){
                                                    renderHtmlx += renderHtml[t]+(json[lm].name.split('[]')[0])+i+'[]-'+i;
                                                }else{
                                                    renderHtmlx += renderHtml[t];
                                                }
                                            }

                                            renderHtml = renderHtmlx;
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
                                        $('.full-area').removeClass('d-none');
                                        $('#renderForm'+(i)).html(renderHtmlx);

                                        
                                    }

                                    
                                    
                                    confirmHousings();

                                    $('.dropzonearea').closest('.formbuilder-file').remove();
                                    

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
                                                if(!$(item).val() || $(item).val() == "Seçiniz"){
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
                                        var transactionIndex = 0;
                                        $('.tab-pane').prepend('<div class="loading-icon-right"><i class="fa fa-spinner"></i></div>');
                                        var order = parseInt($(this).val()) - 1;
                                        var currentOrder = parseInt($(this).closest('.item-left-area').index());
                                        var arrayValues = {};
                                        var formData = new FormData();
                                        formData.append('_token', csrfToken);
                                        var lastOrders = 0;
                                        if(hasBlocks){
                                            for(var i = 0 ; i < selectedBlock; i++){
                                                lastOrders += parseInt(blockHouseCount[i]);
                                            }
                                        }
                                        formData.append('last_order',(parseInt($(this).val()) - 1));
                                        console.log((lastOrders + parseInt($('.house_order_input').val()) - 1));
                                        formData.append('new_order',(parseInt(lastOrders) + parseInt($('.house_order_input').val()) - 1));
                                        formData.append('item_type',1);
                                        
                                        $.ajax({
                                            type: "POST",
                                            url: "{{route('institutional.temp.order.copy.data')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                            data: formData,
                                            processData: false,
                                            contentType: false,
                                            success: function(response) {
                                                var data = response.data;
                                                for(var i = 0 ; i < data.length; i++){
                                                    var key = Object.keys(data[i])
                                                    if(data[i].type == "select"){
                                                        $('select[name="'+key[0]+'[]"]')
                                                        if(data[i][key[0]] == null){
                                                            $('select[name="'+key[0]+'[]"]').find('option').prop('selected',false);
                                                        }else{
                                                            $('select[name="'+key[0]+'[]"]').val(data[i][key[0]]);
                                                        }
                                                    }else{
                                                        if(data[i].type != "file"){
                                                            if(data[i].type == "checkbox-group"){
                                                                if(data[i][key[0]] == null){
                                                                    $('input[name="'+key[0]+'1[][]"]').prop("checked",false);
                                                                }else{
                                                                    $('input[name="'+key[0]+'1[][]"]').map((keyx,item) => {
                                                                        $(item).prop('checked',false);
                                                                        for(var k = 0 ; k < data[i][key[0]].length; k++){
                                                                            if($(item).attr('value')){
                                                                                if($(item).attr('value').trim() == data[i][key[0]][k]){
                                                                                    $(item).prop('checked',true);
                                                                                }
                                                                            }
                                                                        }
                                                                        
                                                                    })
                                                                }
                                                            }else{
                                                                if(data[i][key[0]] == null){
                                                                    $('input[name="'+key[0]+'[]"]').val("");
                                                                }else{
                                                                    $('input[name="'+key[0]+'[]"]').val(data[i][key[0]]);
                                                                }
                                                            }
                                                        }else{
                                                                console.log(data[i][key[0]]);
                                                            if(data[i][key[0]] == null){
                                                                $('.project_imaget img').remove();
                                                            }else{
                                                                if($('.project_imaget img').length > 0){
                                                                    $('.project_imaget img').attr('src',"{{URL::to('/')}}/storage/project_images/"+data[i][key[0]])
                                                                }else{
                                                                    $('.project_imaget').html('<img src="'+"{{URL::to('/')}}/storage/project_images/"+data[i][key[0]]+'">')
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                                var data2 = response.data2;


                                                $('.dec-pay-area').remove();
                                                var newOrderx = (parseInt($('.house_order_input').val()));
                                                console.log(newOrderx);
                                                if(data2['pay-dec-count'+( parseInt($('.house_order_input').val()))]){
                                                    $('.installement-dec-pay').closest('.form-group').after(`
                                                        <div class="dec-pay-area">
                                                            <div class="top">
                                                                <h4>Ara Ödemeler</h4>
                                                                <button class="btn btn-primary add-pay-dec"><i class="fa fa-plus"></i></button>
                                                            </div>
                                                            <div class="pay-desc">
                                                                <div class="pay-desc-item">
                                                                    <div class="row" style="align-items: flex-end;">
                                                                        <div class="flex-1">
                                                                            <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                                                        </div>
                                                                        <div class="flex-10">
                                                                            <label for="">Ara Ödeme Tutarı</label>
                                                                            <input type="text" value="${data2['pay_desc_price'+newOrderx+'0']}" class="price-only form-control pay-desc-price">
                                                                        </div>
                                                                        <div class="flex-10">
                                                                            <label for="">Ara Ödeme Tarihi</label>
                                                                            <input type="date" value="${data2['pay_desc_date'+newOrderx+'0']}" class="form-control pay-desc-date">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    `)

                                                    for(var i = 1; i < data2['pay-dec-count'+(lastOrders + parseInt($('.house_order_input').val()))]; i++){
                                                        $('.pay-desc').append(`
                                                            <div class="pay-desc-item">
                                                                <div class="row" style="align-items: flex-end;">
                                                                    <div class="flex-1">
                                                                        <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                                                    </div>
                                                                    <div class="flex-10">
                                                                        <label for="">Ara Ödeme Tutarı</label>
                                                                        <input type="text" value="${data2['pay_desc_price'+newOrderx+i] ? data2['pay_desc_price'+newOrderx+i] : ""}" class="price-only pay-desc-price form-control">
                                                                    </div>
                                                                    <div class="flex-10">
                                                                        <label for="">Ara Ödeme Tarihi</label>
                                                                        <input type="date" value="${data2['pay_desc_date'+newOrderx+i] ? data2['pay_desc_date'+newOrderx+i] : ""}" class="form-control pay-desc-date">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        `)
                                                    }
                                                }else{

                                                    $('.installement-dec-pay').closest('.form-group').after(`
                                                        <div class="dec-pay-area">
                                                            <div class="top">
                                                                <h4>Ara Ödemeler</h4>
                                                                <button class="btn btn-primary add-pay-dec"><i class="fa fa-plus"></i></button>
                                                            </div>
                                                            <div class="pay-desc">
                                                                <div class="pay-desc-item">
                                                                    <div class="row" style="align-items: flex-end;">
                                                                        <div class="flex-1">
                                                                            <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                                                        </div>
                                                                        <div class="flex-10">
                                                                            <label for="">Ara Ödeme Tutarı</label>
                                                                            <input type="text" value="" class="price-only form-control pay-desc-price">
                                                                        </div>
                                                                        <div class="flex-10">
                                                                            <label for="">Ara Ödeme Tarihi</label>
                                                                            <input type="date" value="" class="form-control pay-desc-date">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    `)
                                                }

                                                
                                                $('.loading-icon-right').remove();
                                                $('.copy-item').val('')
                                                confirmHousings();
                                                
                                                $('.loading-icon-right').remove();
                                                $('.copy-item').val('')
                                                confirmHousings();


                                            },
                                        });
                                        console.log(transactionIndex);
                                    })
                                    
                        
                                    $('.project-disabled').closest('.form-group').remove();
                                    
                                    $('.rendered-form input').change(function(){
                                        if($(this).attr('type') != "file"){
                                            var formData = new FormData();
                                            var csrfToken = $("meta[name='csrf-token']").attr("content");
                                            formData.append('_token', csrfToken);
                                            formData.append('value',$(this).val());
                                            var lastOrders = 0;
                                            for(var i = 0 ; i < selectedBlock; i++){
                                                lastOrders += parseInt(blockHouseCount[i]);
                                            }

                                            formData.append('order',parseInt(lastOrders) +(parseInt($('.house_order_input').val()) - 1));
                                            formData.append('item_type',1);
                                            if($(this).hasClass('only-one')){
                                                formData.append('only-one',"1");
                                                $(this).closest('.form-group').find('.only-one[value!="'+$(this).val()+'"]').prop('checked',false);
                                            }
                                            if($(this).attr('type') == "checkbox"){
                                                formData.append('checkbox',"1");
                                                formData.append('key',$(this).attr('name').replace("[]", "").replace("[]", "").slice(0, -1)+$('.house_order_input').val());
                                            }else{
                                                formData.append('key',$(this).attr('name').replace("[]", "").replace("[]", ""));
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
                                        formData.append('order',parseInt($('.house_order_input').val()) - 1);
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
                                        if($(this).val().replace('.','').replace('.','').replace('.','').replace('.','') != parseInt($(this).val().replace('.','').replace('.','').replace('.','').replace('.','').replace('.','') )){
                                            if($(this).closest('.form-group').find('.error-text').length > 0){
                                                $(this).val("");
                                            }else{
                                                $(this).closest('.form-group').append('<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                                                $(this).val("");
                                            }
                                            
                                        }else{
                                            let inputValue = $(this).val();

                                            // Sadece sayı karakterlerine izin ver
                                            inputValue = inputValue.replace(/\D/g, '');

                                            // Her üç basamakta bir nokta ekleyin
                                            inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                                            $(this).val(inputValue)
                                            $(this).closest('.form-group').find('.error-text').remove();
                                        }
                                    })
                                    
                                    $('.maks-3').keyup(function(){
                                        console.log("asd")
                                        if(parseInt($(this).val()) > 3){
                                            $(this).val(3);
                                        }
                                    })

                                    $('.number-only').keyup(function(){
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
                                            var lastOrders = 0;
                                            if(hasBlocks){
                                                for(var i = 0 ; i < selectedBlock; i++){
                                                    lastOrders += parseInt(blockHouseCount[i]);
                                                }
                                            }
                                            formData.append('order',(lastOrders + parseInt($('.house_order_input').val()) - 1));
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

                                                $('.tab-pane.active .cover-image-by-housing-type').parent('div').find('.project_imaget').remove()
                                                $('.tab-pane.active .cover-image-by-housing-type').closest('.formbuilder-file').append(imageDiv)
                                                confirmHousings();
                                            };

                                            // Resmi okuyun
                                            reader.readAsDataURL(input.files[0]);
                                            
                                        }
                                    })

                                    
                                    

                                    $('#tablist').attr('style','height:'+$('.tab-content').css('height')+' !important;flex-wrap:nowrap;overflow:scroll;')
                                    },
                                    error: function(error) {
                                        console.log(error)
                                    }
                                })
                            }
                            $('.block-name').val("");
                            $('.block-count').val("");
                        },
                        error: function(xhr, status, error) {
                            console.error("Ajax isteği sırasında bir hata oluştu: " + error);
                        }
                    });
                }

                if($('.block').length == 0){
                    if(housingCount == 1){
                        $('.next-house-bottom').addClass('disabled-button')
                    }else{
                        $('.next-house-bottom').removeClass('disabled-button')
                    }
                }

                

                $('.error-border').change(function(){
                    if($(this).val() != ""){
                        $(this).removeClass("error-border");
                    }
                })
                
            })

            $(document).on('click', '.block', function(e) {
                var index = $(this).index();
                var thisx = $(this);
                $('.pop-up-v4').removeClass('d-none');
                $('.pop-up-v4 .load-area2 span').html('Blok değiştiriliyor')
                $.ajax({
                    url: '{{route("institutional.temp.order.get.block.data")}}',
                    type: 'GET',
                    data: { 
                        block_index : index,
                        item_type : 1,
                        _token : csrfToken
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        $('.pop-up-v4').addClass('d-none');
                        if(response.status){
                            houseCount = blockHouseCount[index];
                            if(response.housing_count){
                                $('.housing_count_input').val(response.housing_count);
                                $('.total-house-text').html(response.housing_count);
                            }else{
                                $('.housing_count_input').val("");
                                $('.tab-content').html("");
                            }
                            selectedBlock = index;
                            $('.block').removeClass('active');
                            thisx.addClass('active');
                            var data = response.data;
                            for(var i = 0 ; i < data.length; i++){
                                var key = Object.keys(data[i])
                                if(data[i].type == "select"){
                                    $('select[name="'+key[0]+'[]"]')
                                    if(data[i][key[0]] == null){
                                        $('select[name="'+key[0]+'[]"]').find('option').prop('selected',false);
                                    }else{
                                        $('select[name="'+key[0]+'[]"]').val(data[i][key[0]]);
                                    }
                                }else{
                                    if(data[i].type != "file"){
                                        if(data[i].type == "checkbox-group"){
                                            if(data[i][key[0]] == null){
                                                $('input[name="'+key[0]+'1[][]"]').prop("checked",false);
                                            }else{
                                                $('input[name="'+key[0]+'1[][]"]').map((keyx,item) => {
                                                    $(item).prop('checked',false)
                                                    for(var k = 0 ; k < data[i][key[0]].length; k++){
                                                        if($(item).attr('value')){
                                                            if($(item).attr('value').trim() == data[i][key[0]][k]){
                                                                $(item).prop('checked',true);
                                                            }
                                                        }
                                                    }
                                                    
                                                })
                                            }
                                        }else{
                                            if(data[i][key[0]] == null){
                                                $('input[name="'+key[0]+'[]"]').val("");
                                            }else{
                                                $('input[name="'+key[0]+'[]"]').val(data[i][key[0]]);
                                            }
                                        }
                                    }else{
                                        if(data[i][key[0]] == null){
                                            $('.project_imaget img').remove();
                                        }else{
                                            if($('.project_imaget img').length > 0){
                                                $('.project_imaget img').attr('src',"{{URL::to('/')}}/storage/project_images/"+data[i][key[0]])
                                            }else{
                                                $('.project_imaget').html('<img src="{{URL::to("/")}}/storage/project_images/'+data[i][key[0]]+'"/>')
                                            }
                                        }
                                    }
                                }
                            }

                            confirmHousings();
                            $('.prev-house-bottom').addClass('disabled-button')
                            if(houseCount == 1){
                                $('.next-house-bottom').addClass('disabled-button')
                            }else{
                                $('.next-house-bottom').removeClass('disabled-button')
                            }
                            $('.house_order_input').val(1)
                            $('.room-order-progress').html(parseInt($('.house_order_input').val()))
                            $('.error-border').removeClass('error-border');
                        }else{
                            $.toast({
                                heading: 'Hata',
                                text: response.message,
                                position: 'top-right',
                                stack: false
                            })
                        }
                        
                    },
                    error: function(xhr, status, error) {
                        console.error("Ajax isteği sırasında bir hata oluştu: " + error);
                    }
                });
            })
            $(document).on('click', '.remove-block', function(e) {
                e.stopPropagation();
                $('.pop-up-v4').removeClass('d-none');
                $('.pop-up-v4 .load-area2 span').html('Blok siliniyor')
                var thisx = $(this);
                var isActiveBlock = 0;
                if(thisx.closest('.block').hasClass('active')){
                    isActiveBlock = 1;
                }

                if($('.block').length == 1){
                    $('.tab-pane').remove();
                }

                $.ajax({
                    url: '{{route("institutional.temp.order.remove.block.data")}}?item_type='+1+'&block_index='+($(this).closest('.block').index())+'&is_active_block='+isActiveBlock,
                    type: 'GET',
                    success: function(response) {
                        response = JSON.parse(response);
                        blockHouseCount.splice(thisx.closest('.block').index(),1);
                        blockNames.splice(thisx.closest('.block').index(),1);
                        
                        confirmHousings();
                        if(response.status){
                            $('.pop-up-v4').addClass('d-none');
                            thisx.parent('.block').remove();
                            if(isActiveBlock){
                                var data = response.data;
                                $('.block').eq(0).addClass('active');
                                $('.housing_count_input').val(response.housing_count);
                                $('.total-house-text').html(response.housing_count);
                                houseCount = response.housing_count;
                                $('.house_order_input').val(1)
                                $('.room-order-progress').html(parseInt($('.house_order_input').val()))
                                $('.error-border').removeClass('error-border');
                                selectedBlock = 0;
                                for(var i = 0 ; i < data.length; i++){
                                    var key = Object.keys(data[i])
                                    if(data[i].type == "select"){
                                        $('select[name="'+key[0]+'[]"]')
                                        if(data[i][key[0]] == null){
                                            $('select[name="'+key[0]+'[]"]').find('option').prop('selected',false);
                                        }else{
                                            $('select[name="'+key[0]+'[]"]').val(data[i][key[0]]);
                                        }
                                    }else{
                                        if(data[i].type != "file"){
                                            if(data[i].type == "checkbox-group"){
                                                if(data[i][key[0]] == null){
                                                    $('input[name="'+key[0]+'1[][]"]').prop("checked",false);
                                                }else{
                                                    $('input[name="'+key[0]+'1[][]"]').map((keyx,item) => {
                                                        $(item).prop('checked',false)
                                                        for(var k = 0 ; k < data[i][key[0]].length; k++){
                                                            if($(item).attr('value')){
                                                                if($(item).attr('value').trim() == data[i][key[0]][k]){
                                                                    $(item).prop('checked',true);
                                                                }
                                                            }
                                                        }
                                                        
                                                    })
                                                }
                                            }else{
                                                if(data[i][key[0]] == null){
                                                    $('input[name="'+key[0]+'[]"]').val("");
                                                }else{
                                                    $('input[name="'+key[0]+'[]"]').val(data[i][key[0]]);
                                                }
                                            }
                                        }else{
                                            if(data[i][key[0]] == null){
                                                $('.project_imaget img').remove();
                                            }else{
                                                if($('.project_imaget img').length > 0){
                                                    $('.project_imaget img').attr('src',"{{URL::to('/')}}/storage/project_images/"+data[i][key[0]])
                                                }else{
                                                    $('.project_imaget').html('<img src="{{URL::to("/")}}/storage/project_images/'+data[i][key[0]]+'"/>')
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Ajax isteği sırasında bir hata oluştu: " + error);
                    }
                });
            })

            $(document).on('click', '.prev-house-bottom', function(e) {
                if(!$(this).hasClass('disabled-button')){
                var thisx = $(this);
                $('.pop-up-v4').removeClass('d-none');
                $('.pop-up-v4 .load-area2 span').html('Daire Değiştiriliyor');
                var indexItem = $('.tab-pane.active').index();
                $('.tab-pane.active').removeClass('active');
                $('.tab-pane').eq(indexItem - 1).addClass('active');
                
                $('.item-left-area p').removeClass('active');
                $('.item-left-area').eq(indexItem - 1).find('p').addClass('active');
                $('html, body').animate({
                    scrollTop: $('.tab-pane.active').offset().top - parseFloat($('.navbar-top').css('height'))
                }, 100);
                $('.next-house-bottom').removeClass('disabled-button')
                var lastOrders = 0;
                if(hasBlocks){
                    for(var i = 0 ; i < selectedBlock; i++){
                        lastOrders += parseInt(blockHouseCount[i]);
                    }
                }

                $.ajax({
                    url: "{{URL::to('/')}}/institutional/get_house_data?item_type=1&order="+(lastOrders + parseInt($('.house_order_input').val()) - 2), // AJAX isteği yapılacak URL
                    type: "GET", // GET isteği
                    dataType: "json", // Gelen veri tipi JSON
                    success: function (data) {
                        console.log(data.length);
                        for(var i = 0 ; i < data.data.length; i++){
                            var key = Object.keys(data.data[i])
                            if(data.data[i].type == "select"){
                                $('select[name="'+key[0]+'[]"]')
                                if(data.data[i][key[0]] == null){
                                    $('select[name="'+key[0]+'[]"]').find('option').prop('selected',false);
                                }else{
                                    $('select[name="'+key[0]+'[]"]').val(data.data[i][key[0]]);
                                }
                            }else{
                                if(data.data[i].type != "file"){
                                    if(data.data[i].type == "checkbox-group"){
                                        if(data.data[i][key[0]] == null){
                                            $('input[name="'+key[0]+'1[][]"]').prop("checked",false);
                                        }else{
                                            $('input[name="'+key[0]+'1[][]"]').map((keyx,item) => {
                                                $(item).prop('checked',false);
                                                for(var k = 0 ; k < data.data[i][key[0]].length; k++){
                                                    if($(item).attr('value')){
                                                        if($(item).attr('value').trim() == data.data[i][key[0]][k]){
                                                            $(item).prop('checked',true);
                                                        }
                                                    }
                                                }
                                                
                                            })
                                        }
                                    }else{
                                        if(data.data[i][key[0]] == null){
                                            $('input[name="'+key[0]+'[]"]').val("");
                                        }else{
                                            $('input[name="'+key[0]+'[]"]').val(data.data[i][key[0]]);
                                        }
                                    }
                                }else{
                                    if(data.data[i][key[0]] == null){
                                        $('.project_imaget img').remove();
                                    }else{
                                        if($('.project_imaget img').length > 0){
                                            $('.project_imaget img').attr('src',"{{URL::to('/')}}/storage/project_images/"+data.data[i][key[0]])
                                        }else{
                                            $('.project_imaget').html('<img src="{{URL::to("/")}}/storage/project_images/'+data.data[i][key[0]]+'"/>')
                                        }
                                    }
                                }
                            }
                        }

                        $('.pop-up-v4').addClass('d-none');
                        confirmHousings();
                        $('.house_order_input').val(parseInt($('.house_order_input').val()) - 1)
                        $('.room-order-progress').html(parseInt($('.house_order_input').val()))
                        
                        if(parseInt($('.house_order_input').val()) == 1){
                            thisx.addClass('disabled-button')
                        }else{
                            thisx.removeClass('disabled-button')
                        }

                        $('.dec-pay-area').remove();
                        var newOrderx = (lastOrders + parseInt($('.house_order_input').val()));
                        if(data.data2['pay-dec-count'+(lastOrders + parseInt($('.house_order_input').val()))]){
                            $('.installement-dec-pay').closest('.form-group').after(`
                                <div class="dec-pay-area">
                                    <div class="top">
                                        <h4>Ara Ödemeler</h4>
                                        <button class="btn btn-primary add-pay-dec"><i class="fa fa-plus"></i></button>
                                    </div>
                                    <div class="pay-desc">
                                        <div class="pay-desc-item">
                                            <div class="row" style="align-items: flex-end;">
                                                <div class="flex-1">
                                                    <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                                </div>
                                                <div class="flex-10">
                                                    <label for="">Ara Ödeme Tutarı</label>
                                                    <input type="text" value="${data.data2['pay_desc_price'+newOrderx+'0']}" class="price-only form-control pay-desc-price">
                                                </div>
                                                <div class="flex-10">
                                                    <label for="">Ara Ödeme Tarihi</label>
                                                    <input type="date" value="${data.data2['pay_desc_date'+newOrderx+'0']}" class="form-control pay-desc-date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `)

                            for(var i = 1; i < data.data2['pay-dec-count'+(lastOrders + parseInt($('.house_order_input').val()))]; i++){
                                $('.pay-desc').append(`
                                    <div class="pay-desc-item">
                                        <div class="row" style="align-items: flex-end;">
                                            <div class="flex-1">
                                                <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="flex-10">
                                                <label for="">Ara Ödeme Tutarı</label>
                                                <input type="text" value="${data.data2['pay_desc_price'+newOrderx+i]}" class="price-only pay-desc-price form-control">
                                            </div>
                                            <div class="flex-10">
                                                <label for="">Ara Ödeme Tarihi</label>
                                                <input type="date" value="${data.data2['pay_desc_date'+newOrderx+i]}" class="form-control pay-desc-date">
                                            </div>
                                        </div>
                                    </div>
                                `)
                            }
                        }else{
                            $('.installement-dec-pay').closest('.form-group').after(`
                                <div class="dec-pay-area">
                                    <div class="top">
                                        <h4>Ara Ödemeler</h4>
                                        <button class="btn btn-primary add-pay-dec"><i class="fa fa-plus"></i></button>
                                    </div>
                                    <div class="pay-desc">
                                        <div class="pay-desc-item">
                                            <div class="row" style="align-items: flex-end;">
                                                <div class="flex-1">
                                                    <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                                </div>
                                                <div class="flex-10">
                                                    <label for="">Ara Ödeme Tutarı</label>
                                                    <input type="text" value="" class="price-only form-control pay-desc-price">
                                                </div>
                                                <div class="flex-10">
                                                    <label for="">Ara Ödeme Tarihi</label>
                                                    <input type="date" value="" class="form-control pay-desc-date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `)
                        }
                    },
                    error: function (xhr, status, error) {
                        // İstek hata verdiğinde çalışacak fonksiyon
                        console.error(xhr.statusText);
                    }
                });
                } 
            })
            
            $(document).on('click', '.next-house-bottom', function(e) {
                var thisx = $(this);
                if(!$(this).hasClass('disabled-button')){
                    

                    var nextHousing = true;

                    $('.tab-pane.active input[required="required"]').map((key,item) => {
                        if(!$(item).val() && $(item).attr('type') != "file"){
                            nextHousing = false;
                            $(item).addClass("error-border")
                        }
                    })
                    $('.tab-pane.active select[required="required"]').map((key,item) => {
                        if(!$(item).val() || $(item).val() == "Seçiniz"){
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
                    }else{
                        $('html, body').animate({
                            scrollTop: $('.tab-pane.active').offset().top - parseFloat($('.navbar-top').css('height'))
                        }, 100);
                    }

                    if(nextHousing){
                        $('.pop-up-v4').removeClass('d-none');
                        $('.pop-up-v4 .load-area2 span').html('Daire Değiştiriliyor');
                        var lastOrders = 0;
                        if(hasBlocks){
                            for(var i = 0 ; i < selectedBlock; i++){
                                lastOrders += parseInt(blockHouseCount[i]);
                            }
                        }
                        $.ajax({
                            url: "{{URL::to('/')}}/institutional/get_house_data?item_type=1&order="+(lastOrders + parseInt($('.house_order_input').val())), // AJAX isteği yapılacak URL
                            type: "GET", // GET isteği
                            dataType: "json", // Gelen veri tipi JSON
                            xhr: function() {
                                var xhr = new window.XMLHttpRequest();
                                console.log(xhr)
                                // İlerleme durumu değiştikçe çalışacak olan fonksiyon
                                xhr.upload.addEventListener('progress', function(evt) {
                                        console.log(evt)
                                    if (evt.lengthComputable) {
                                        var percentComplete = (evt.loaded / evt.total) * 100;
                                        $('.progress-bar2').css('width',percentComplete+'%');
                                    }
                                }, false);

                                return xhr;
                            },
                            success: function (data) {
                                for(var i = 0 ; i < data.data.length; i++){
                                    var key = Object.keys(data.data[i])
                                    if(data.data[i].type == "select"){
                                        $('select[name="'+key[0]+'[]"]')
                                        if(data.data[i][key[0]] == null){
                                            $('select[name="'+key[0]+'[]"]').find('option').prop('selected',false);
                                        }else{
                                            $('select[name="'+key[0]+'[]"]').val(data.data[i][key[0]]);
                                        }
                                    }else{
                                        if(data.data[i].type != "file"){
                                            if(data.data[i].type == "checkbox-group"){
                                                if(data.data[i][key[0]] == null){
                                                    $('input[name="'+key[0]+'1[][]"]').prop("checked",false);
                                                }else{
                                                    $('input[name="'+key[0]+'1[][]"]').map((keyx,item) => {
                                                        $(item).prop('checked',false)
                                                        for(var k = 0 ; k < data.data[i][key[0]].length; k++){
                                                            if($(item).attr('value')){
                                                                if($(item).attr('value').trim() == data.data[i][key[0]][k]){
                                                                    $(item).prop('checked',true);
                                                                }
                                                            }
                                                        }
                                                        
                                                    })
                                                }
                                            }else{
                                                if(data.data[i][key[0]] == null){
                                                    $('input[name="'+key[0]+'[]"]').val("");
                                                }else{
                                                    $('input[name="'+key[0]+'[]"]').val(data.data[i][key[0]]);
                                                }
                                            }
                                        }else{
                                            if(data.data[i][key[0]] == null){
                                                $('.project_imaget img').remove();
                                            }else{
                                                if($('.project_imaget img').length > 0){
                                                    $('.project_imaget img').attr('src',"{{URL::to('/')}}/storage/project_images/"+data.data[i][key[0]])
                                                }else{
                                                    $('.project_imaget').html('<img src="'+"{{URL::to('/')}}/storage/project_images/"+data.data[i][key[0]]+'">')
                                                }
                                            }
                                        }
                                    }
                                }
                                
                                
                                $('.price-only').keyup(function(){
                                    $('.price-only .error-text').remove();
                                    if($(this).val().replace('.','').replace('.','').replace('.','').replace('.','') != parseInt($(this).val().replace('.','').replace('.','').replace('.','').replace('.','').replace('.','') )){
                                        if($(this).closest('.form-group').find('.error-text').length > 0){
                                            $(this).val("");
                                        }else{
                                            $(this).closest('.form-group').append('<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                                            $(this).val("");
                                        }
                                        
                                    }else{
                                        let inputValue = $(this).val();

                                        // Sadece sayı karakterlerine izin ver
                                        inputValue = inputValue.replace(/\D/g, '');

                                        // Her üç basamakta bir nokta ekleyin
                                        inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                                        $(this).val(inputValue)
                                        $(this).closest('.form-group').find('.error-text').remove();
                                    }
                                })
                                
                                if((parseInt($('.house_order_input').val())+1) == houseCount){
                                    thisx.addClass('disabled-button')
                                }else{
                                    thisx.removeClass('disabled-button')
                                }
                                $('.pop-up-v4').addClass('d-none');
                                confirmHousings();
                                $('.prev-house-bottom').removeClass('disabled-button')
                                $('.house_order_input').val(parseInt($('.house_order_input').val()) + 1)
                                $('.room-order-progress').html(parseInt($('.house_order_input').val()))
                                $('.error-border').removeClass('error-border');

                                $('.dec-pay-area').remove();
                                var newOrderx = (lastOrders + parseInt($('.house_order_input').val()));
                                if(data.data2['pay-dec-count'+(lastOrders + parseInt($('.house_order_input').val()))]){
                                    $('.installement-dec-pay').closest('.form-group').after(`
                                        <div class="dec-pay-area">
                                            <div class="top">
                                                <h4>Ara Ödemeler</h4>
                                                <button class="btn btn-primary add-pay-dec"><i class="fa fa-plus"></i></button>
                                            </div>
                                            <div class="pay-desc">
                                                <div class="pay-desc-item">
                                                    <div class="row" style="align-items: flex-end;">
                                                        <div class="flex-1">
                                                            <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                        <div class="flex-10">
                                                            <label for="">Ara Ödeme Tutarı</label>
                                                            <input type="text" value="${data.data2['pay_desc_price'+newOrderx+'0']}" class="price-only form-control pay-desc-price">
                                                        </div>
                                                        <div class="flex-10">
                                                            <label for="">Ara Ödeme Tarihi</label>
                                                            <input type="date" value="${data.data2['pay_desc_date'+newOrderx+'0']}" class="form-control pay-desc-date">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    `)

                                    for(var i = 1; i < data.data2['pay-dec-count'+(lastOrders + parseInt($('.house_order_input').val()))]; i++){
                                        $('.pay-desc').append(`
                                            <div class="pay-desc-item">
                                                <div class="row" style="align-items: flex-end;">
                                                    <div class="flex-1">
                                                        <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                    <div class="flex-10">
                                                        <label for="">Ara Ödeme Tutarı</label>
                                                        <input type="text" value="${data.data2['pay_desc_price'+newOrderx+i] ? data.data2['pay_desc_price'+newOrderx+i] : ""}" class="price-only pay-desc-price form-control">
                                                    </div>
                                                    <div class="flex-10">
                                                        <label for="">Ara Ödeme Tarihi</label>
                                                        <input type="date" value="${data.data2['pay_desc_date'+newOrderx+i] ? data.data2['pay_desc_date'+newOrderx+i] : ""}" class="form-control pay-desc-date">
                                                    </div>
                                                </div>
                                            </div>
                                        `)
                                    }
                                }else{
                                    
                                    changeData(1,'pay-dec-count'+$('.house_order_input').val())
                                    $('.installement-dec-pay').closest('.form-group').after(`
                                        <div class="dec-pay-area">
                                            <div class="top">
                                                <h4>Ara Ödemeler</h4>
                                                <button class="btn btn-primary add-pay-dec"><i class="fa fa-plus"></i></button>
                                            </div>
                                            <div class="pay-desc">
                                                <div class="pay-desc-item">
                                                    <div class="row" style="align-items: flex-end;">
                                                        <div class="flex-1">
                                                            <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                        <div class="flex-10">
                                                            <label for="">Ara Ödeme Tutarı</label>
                                                            <input type="text" value="" class="price-only form-control pay-desc-price">
                                                        </div>
                                                        <div class="flex-10">
                                                            <label for="">Ara Ödeme Tarihi</label>
                                                            <input type="date" value="" class="form-control pay-desc-date">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    `)
                                }
                            },
                            error: function (xhr, status, error) {
                                // İstek hata verdiğinde çalışacak fonksiyon
                                console.error(xhr.statusText);
                            }
                        });
                    }
                }
            })

            $(document).on('click','.add-pay-dec',function(){
                $('.pay-desc').append(`
                    <div class="pay-desc-item">
                        <div class="row" style="align-items: flex-end;">
                            <div class="flex-1">
                                <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                            </div>
                            <div class="flex-10">
                                <label for="">Ara Ödeme Tutarı</label>
                                <input type="text" class="price-only pay-desc-price form-control">
                            </div>
                            <div class="flex-10">
                                <label for="">Ara Ödeme Tarihi</label>
                                <input type="date" class="form-control pay-desc-date">
                            </div>
                        </div>
                    </div>
                `)

                changeData($('.pay-desc-item').length,'pay-dec-count'+$('.house_order_input').val())
            })

            $('#rulesOpenModal').click(function(){
                $(this).removeClass('show')
                $(this).removeClass('d-block')
            })

            $('#rulesOpenModal .close').click(function(){
                $(this).removeClass('show')
                $(this).removeClass('d-block')
            })

            $('#rulesOpenModal .modal-dialog').click(function(e){
                if(!$(event.target).hasClass('close')){
                    e.stopPropagation();
                }
            })

            $('#paymentModal').click(function(){
                $(this).removeClass('show')
                $(this).removeClass('d-block')
            })

            $('#paymentModal .close').click(function(){
                $(this).removeClass('show')
                $(this).removeClass('d-block')
            })

            $('#paymentModal .modal-dialog').click(function(e){
                if(!$(event.target).hasClass('close')){
                    e.stopPropagation();
                }
            })

            $('.rulesOpen').click(function(){
                $('#rulesOpenModal').addClass('show')
                $('#rulesOpenModal').addClass('d-block')
            })

            $('.payment-area').click(function(){
                var totalPrice = '';
                $(this).append('<div class="loading-icon"><i class="fa fa-spinner"></i></div>')
                var thisx = $(this);
                $.ajax({
                    url: '{{route("institutional.temp.order.get.doping.price")}}?item_type='+1,
                    type: 'GET',
                    success: function(response) {
                        response = response;
                        var totalPrice = 0;
                        for(var i = 0 ; i < response.length; i++){
                            totalPrice += response[i].price; 
                        }
                        if(totalPrice == 0){
                            $('.without-doping').trigger("click")
                        }else{
                            $('.invoice-body table tbody tr').eq(0).find('td').eq(2).html(totalPrice.toFixed(2)+'₺')
                            $('.invoice-body table tbody tr').eq(0).find('td').eq(3).html(totalPrice.toFixed(2)+'₺')
                            $('#paymentModal').addClass('show')
                            $('#paymentModal').addClass('d-block')
                            
                            var uniqueCode = generateUniqueCode();
                            $('#uniqueCode').text(uniqueCode);
                            $('#uniqueCodeRetry').text(uniqueCode);
                            $("#orderKey").val(uniqueCode);
                            changeData(uniqueCode,"key");
                            thisx.find('.loading-icon').remove();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Ajax isteği sırasında bir hata oluştu: " + error);
                    }
                });
                for(var i = 0; i < selectedDopings.length; i++){
                    totalPrice += parseFloat(selectedDopings[i].price);
                }
                
            })

            $(document).ready(function() {
                // Başlangıçta ödeme düğmesini devre dışı bırak
                $('#completePaymentButton').prop('disabled', true);


                $('.bank-account').on('click', function() {
                    // Tüm banka görsellerini seçim olmadı olarak ayarla
                    $('.bank-account').removeClass('selected');

                    // Seçilen banka görselini işaretle
                    $(this).addClass('selected');

                    // İlgili IBAN bilgisini al
                    var selectedBankIban = $(this).data('iban');
                    var selectedBankIbanID = $(this).data('id');
                    var selectedBankTitle = $(this).data('title');
                    $('#bankaID').val(selectedBankIbanID);
                    changeData(selectedBankIbanID,"bank_id");

                    // IBAN bilgisini ekranda göster
                    $('#ibanInfo').text(selectedBankTitle + " : " + selectedBankIban);
                    // Ödeme düğmesini etkinleştir
                    $('#completePaymentButton').prop('disabled', false);
                });

                $('#completePaymentButton').on('click', function() {
                    $('#paymentModal').removeClass('show');
                    $('#paymentModal').css('display','none');
                    $('#finalConfirmationModal').modal('show');
                });
            });

            @if(!isset($tempDataFull) || !isset($tempData) || !isset($tempData->top_row))
                changeData(0,"top_row");
            @endif

            @if(!isset($tempDataFull) || !isset($tempData) || !isset($tempData->featured))
                changeData(0,"featured");
            @endif

            $('.doping-square').click(function(){
                if($(this).hasClass('selected')){
                    if($(this).attr('data-id') == "1"){
                        changeData(0,"featured");
                    }else{
                        changeData(0,"top_row");
                    }
                    $(this).removeClass('selected')
                    $(this).find('.doping-is-selected').html('Seçilmedi')
                }else{
                    if($(this).attr('data-id') == "1"){
                        changeData(1,"featured");
                        changeData($(this).find('select').val(),'featured_data_day')
                    }else{
                        changeData(1,"top_row");
                        changeData($(this).find('select').val(),'top_row_data_day')
                    }
                    $(this).addClass('selected')
                    $(this).find('.doping-is-selected').html('Seçildi')
                }
            })

            $('.doping-square select').click(function(e){
                e.stopPropagation();
            })

            $('.doping-square select').change(function(e) {
                var dataId = $(this).closest('.doping-square').attr('data-id')
                if(dataId == "1"){
                    var itemType = 1;
                    changeData(1,"featured");
                    changeData($(this).val(),'featured_data_day')
                }else{
                    var itemType = 2;
                    changeData(1,"top_row");
                    changeData($(this).val(),'top_row_data_day')
                }
            })

            changeData(1,'pricing-type')
            var nextTemp = false;
            var housingTypeTitle = "";
            var housingImages = [];
            var descriptionText = @if(isset($tempData) && isset($tempData->description)) 'evet var' @else "" @endif;

            $('.after_step_housing').click(function(){
                $.ajax({
                    url: '{{route("institutional.temp.order.housing.confirm.full")}}?item_type=1',
                    type: 'GET',
                    success: function(response) {
                        response = JSON.parse(response);
                        if(response.status){
                            $('.housing_after_step').removeClass('d-none')
                        }else{
                            $.toast({
                                heading: 'Hata',
                                text: response.message,
                                position: 'top-right',
                                stack: false
                            })
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Ajax isteği sırasında bir hata oluştu: " + error);
                    }
                });
            })

            $(window).scroll(function(){
                
                var scrollTopValue = $(".tab-pane").offset().top;
                var fullAreaHeight = $(".tab-pane").height();
                console.log($(".tab-pane").offset().top,$(window).scrollTop())
                if($(window).scrollTop() < (scrollTopValue+fullAreaHeight - 500) && $(window).scrollTop() > (scrollTopValue - 500)){
                    $('.bottom-housing-area').removeClass('d-none')
                }else{
                    $('.bottom-housing-area').addClass('d-none')
                }
            });

            $('.photos').sortable({
                revert: true,
                update: function(event, ui) {
                    var ids = [];
                    for(var i = 0; i < $('.photos .project_imagex').length; i++){
                        ids.push($('.photos .project_imagex').eq(i).attr('order'));
                    }
                    console.log(ids);
                    // Sıralama değiştiğinde bir Ajax POST isteği gönder
                    $.ajax({
                        url: '{{route("institutional.update.image.order.temp.update")}}',
                        type: 'POST',
                        data: { 
                            images: ids ,
                            item_type : 1,
                            _token : csrfToken
                        },
                        success: function(response) {
                            console.log("Sıralama güncellendi.");
                        },
                        error: function(xhr, status, error) {
                            console.error("Ajax isteği sırasında bir hata oluştu: " + error);
                        }
                    });
                }
            });

            $('.project_imagex').draggable({
                connectToSortable: ".photos",
            });

            function allowDrop(event) {
                event.preventDefault();
            }

            function handleDrop(event) {
                event.preventDefault();

                var files = event.dataTransfer.files;
                console.log(event);
                if (files.length > 0) {
                    handleDroppedFiles(files);
                }
            }

            function handleDroppedFiles(files) {
                var input = this;

                if (files.length > 0) {
                    $('.cover-photo-area').removeClass('error-border')
                    var reader = new FileReader();

                    var formData = new FormData();
                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                    formData.append('_token', csrfToken);
                    formData.append('image',files[0]);
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
                    reader.readAsDataURL(files[0]);
                }
                
            }

            function allowDrop2(event) {
                event.preventDefault();
            }

            function handleDrop2(event) {
                event.preventDefault();

                var files = event.dataTransfer.files;
                console.log(event);
                if (files.length > 0) {
                    handleDroppedFiles2(files);
                }
            }

            function handleDroppedFiles2(files) {
                console.log(files)
                if (files && files[0]) {
                    $('.photo-area').removeClass('error-border')

                    var formData = new FormData();
                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                    formData.append('_token', csrfToken);
                    formData.append('item_type',1);
                    for (let i = 0; i < files.length; i++) {
                        console.log(files[i]);
                        formData.append(`file${i}`, files[i]);
                    }
                    $.ajax({
                        type: "POST",
                        url: "{{route('institutional.temp.order.image.add')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            
                            for (let i = 0; i < response.length; i++) {
                                var imageDiv = $('<div class="project_imagex" order="'+response[i]+'"></div>');
                                var image = $('<img>').attr('src', '{{URL::to('/')}}/project_images/'+response[i]);
                                var imageButtons = $('<div>').attr('class','image-buttons');
                                var imageButtonsIcon = $('<i>').attr('class','fa fa-trash');
                                imageButtons.append(imageButtonsIcon)
                                imageDiv.append(image);
                                imageDiv.append(imageButtons);
                                $('.photos').append(imageDiv);

                                $('.project_imagex .image-buttons').click(function(){
                                    var thisx = $(this);
                                    $.ajax({
                                        url: '{{route("institutional.delete.image.order.temp.update")}}',
                                        type: 'POST',
                                        data: { 
                                            image: $(this).closest('.project_imagex').attr('order') ,
                                            item_type : 1,
                                            _token : csrfToken
                                        },
                                        success: function(response) {
                                            thisx.closest('.project_imagex').remove()
                                        },
                                        error: function(xhr, status, error) {
                                            console.error("Ajax isteği sırasında bir hata oluştu: " + error);
                                        }
                                    });
                                })
                            }
                        },
                        error: function() {
                            // Hata durumunda kullanıcıya bir mesaj gösterebilirsiniz
                            alert("Dosya yüklenemedi.");
                        }
                    });
                    

                }
                
            }

            function allowDrop3(event) {
                event.preventDefault();
            }

            function handleDrop3(event) {
                event.preventDefault();

                var files = event.dataTransfer.files;
                console.log(event);
                if (files.length > 0) {
                    handleDroppedFiles3(files);
                }
            }

            function handleDroppedFiles3(files) {
                if (files && files[0]) {
                    $('.cover-document-area').removeClass('error-border')
                    var reader = new FileReader();

                    var formData = new FormData();
                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                    formData.append('_token', csrfToken);
                    formData.append('document',files[0]);
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
            }

            var houseCount = @if(isset($tempData->has_blocks) && $tempData->has_blocks) {{isset($tempData->house_count0) ? $tempData->house_count0 : 0}} @else {{isset($tempData->house_count) ? $tempData->house_count : 0}} @endif;
            $('.choise-1').click(function(){
                $('.full-area').removeClass('d-none')
                $('.bottom-housing-area').removeClass('d-none')
                $('.pop-up-v2').addClass('d-none')
                if(disabledBlocks){
                    $('.has_blocks_input').parent('.form-group').parent('.form-group').addClass("d-none");
                    $('.has_blocks-close').removeClass("d-none");
                }
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
                        console.log(oldData);
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
                            for(var i = 0 ; i < 1; i++ ){
                                htmlContent += '<div class="tab-pane fade show '+(i == 0 ? 'active' : '')+'" id="TabContent'+(i+1)+'" role="tabpanel">'+
                                    '<div id="renderForm'+(i+1)+'"></div>'+
                                '</div>';
                            }

                            $('.tab-content').html(htmlContent)

                            for (let i = 1; i <= 1; i++) {
                                formRenderOpts = {
                                    dataType: 'json',
                                    formData: response.form_json
                                };

                                var renderedForm = $('<div>');
                                renderedForm.formRender(formRenderOpts);
                                var renderHtml = renderedForm.html().toString();
                                renderHtml = renderHtml.toString().split('images[][]');
                                renderHtml = renderHtml[0];
                                var json = JSON.parse(response.form_json);
                                for(var lm = 0 ; lm < json.length; lm++){
                                    if(json[lm].type == "checkbox-group"){
                                    var json = JSON.parse(response.form_json);
                                    var renderHtml = renderHtml.toString().split(json[lm].name+'-');
                                    renderHtmlx = "";
                                    for(var t = 0 ; t < renderHtml.length ; t++){
                                        if(t != renderHtml.length - 1){
                                            renderHtmlx += renderHtml[t]+(json[lm].name.split('[]')[0])+i+'[]-'+i;
                                        }else{
                                            renderHtmlx += renderHtml[t];
                                        }
                                    }

                                    renderHtml = renderHtmlx;
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


                                    $('#renderForm'+(i)).html(renderHtmlx);
                                    renderHtml = renderHtmlx;

                                    
                                    }
                                }

                                
                            }

                            
                            for (let i = 1; i <= 1; i++) {
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
                                            if(checkbox && $(item).attr("value")){
                                                if(checkbox.trim() == $(item).attr("value").trim()){
                                                    $(item).attr('checked','checked')
                                                }
                                            }
                                        })
                                    }
                                    
                                    });
                                }else if(formInputs[j].type == 'file'){
                                    var inputName = formInputs[j].name;
                                    var inputNamex = inputName;
                                    inputNamex = inputNamex.split('[]')
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

                            if(houseCount == 1){
                                $('.next-house-bottom').addClass('disabled-button');
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
                                        if(!$(item).val() || $(item).val() == "Seçiniz"){
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
                                console.log($(this).val())
                                var transactionIndex = 0;
                                $('.tab-pane').prepend('<div class="loading-icon-right"><i class="fa fa-spinner"></i></div>');
                                var order = parseInt($(this).val()) - 1;
                                var currentOrder = parseInt($(this).closest('.item-left-area').index());
                                var arrayValues = {};
                                var formData = new FormData();
                                formData.append('_token', csrfToken);
                                var lastOrders = 0;
                                if(hasBlocks){
                                    for(var i = 0 ; i < selectedBlock; i++){
                                        lastOrders += blockHouseCount[i];
                                    }
                                }
                                formData.append('last_order',(parseInt($(this).val()) - 1));
                                formData.append('new_order',(lastOrders + parseInt($('.house_order_input').val()) - 1));
                                formData.append('item_type',1);
                                
                                $.ajax({
                                    type: "POST",
                                    url: "{{route('institutional.temp.order.copy.data')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        var data = response.data;
                                        for(var i = 0 ; i < data.length; i++){
                                            var key = Object.keys(data[i])
                                            if(data[i].type == "select"){
                                                $('select[name="'+key[0]+'[]"]')
                                                if(data[i][key[0]] == null){
                                                    $('select[name="'+key[0]+'[]"]').find('option').prop('selected',false);
                                                }else{
                                                    $('select[name="'+key[0]+'[]"]').val(data[i][key[0]]);
                                                }
                                            }else{
                                                if(data[i].type != "file"){
                                                    if(data[i].type == "checkbox-group"){
                                                        if(data[i][key[0]] == null){
                                                            $('input[name="'+key[0]+'1[][]"]').prop("checked",false);
                                                        }else{
                                                            $('input[name="'+key[0]+'1[][]"]').map((keyx,item) => {
                                                                $(item).prop('checked',false);
                                                                for(var k = 0 ; k < data[i][key[0]].length; k++){
                                                                    if($(item).attr('value')){
                                                                        if($(item).attr('value').trim() == data[i][key[0]][k]){
                                                                            $(item).prop('checked',true);
                                                                        }
                                                                    }
                                                                }
                                                                
                                                            })
                                                        }
                                                    }else{
                                                        if(data[i][key[0]] == null){
                                                            $('input[name="'+key[0]+'[]"]').val("");
                                                        }else{
                                                            $('input[name="'+key[0]+'[]"]').val(data[i][key[0]]);
                                                        }
                                                    }
                                                }else{
                                                        console.log(data[i][key[0]]);
                                                    if(data[i][key[0]] == null){
                                                        $('.project_imaget img').remove();
                                                    }else{
                                                        if($('.project_imaget img').length > 0){
                                                            $('.project_imaget img').attr('src',"{{URL::to('/')}}/storage/project_images/"+data[i][key[0]])
                                                        }else{
                                                            $('.project_imaget').html('<img src="'+"{{URL::to('/')}}/storage/project_images/"+data[i][key[0]]+'">')
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        var data2 = response.data2;


                                        $('.dec-pay-area').remove();
                                        var newOrderx = (parseInt($('.house_order_input').val()));
                                        console.log(newOrderx);
                                        if(data2['pay-dec-count'+( parseInt($('.house_order_input').val()))]){
                                            $('.installement-dec-pay').closest('.form-group').after(`
                                                <div class="dec-pay-area">
                                                    <div class="top">
                                                        <h4>Ara Ödemeler</h4>
                                                        <button class="btn btn-primary add-pay-dec"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                    <div class="pay-desc">
                                                        <div class="pay-desc-item">
                                                            <div class="row" style="align-items: flex-end;">
                                                                <div class="flex-1">
                                                                    <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                                                </div>
                                                                <div class="flex-10">
                                                                    <label for="">Ara Ödeme Tutarı</label>
                                                                    <input type="text" value="${data2['pay_desc_price'+newOrderx+'0']}" class="price-only form-control pay-desc-price">
                                                                </div>
                                                                <div class="flex-10">
                                                                    <label for="">Ara Ödeme Tarihi</label>
                                                                    <input type="date" value="${data2['pay_desc_date'+newOrderx+'0']}" class="form-control pay-desc-date">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            `)

                                            for(var i = 1; i < data2['pay-dec-count'+(lastOrders + parseInt($('.house_order_input').val()))]; i++){
                                                $('.pay-desc').append(`
                                                    <div class="pay-desc-item">
                                                        <div class="row" style="align-items: flex-end;">
                                                            <div class="flex-1">
                                                                <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                                            </div>
                                                            <div class="flex-10">
                                                                <label for="">Ara Ödeme Tutarı</label>
                                                                <input type="text" value="${data2['pay_desc_price'+newOrderx+i] ? data2['pay_desc_price'+newOrderx+i] : ""}" class="price-only pay-desc-price form-control">
                                                            </div>
                                                            <div class="flex-10">
                                                                <label for="">Ara Ödeme Tarihi</label>
                                                                <input type="date" value="${data2['pay_desc_date'+newOrderx+i] ? data2['pay_desc_date'+newOrderx+i] : ""}" class="form-control pay-desc-date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                `)
                                            }
                                        }else{

                                            $('.installement-dec-pay').closest('.form-group').after(`
                                                <div class="dec-pay-area">
                                                    <div class="top">
                                                        <h4>Ara Ödemeler</h4>
                                                        <button class="btn btn-primary add-pay-dec"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                    <div class="pay-desc">
                                                        <div class="pay-desc-item">
                                                            <div class="row" style="align-items: flex-end;">
                                                                <div class="flex-1">
                                                                    <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                                                </div>
                                                                <div class="flex-10">
                                                                    <label for="">Ara Ödeme Tutarı</label>
                                                                    <input type="text" value="" class="price-only form-control pay-desc-price">
                                                                </div>
                                                                <div class="flex-10">
                                                                    <label for="">Ara Ödeme Tarihi</label>
                                                                    <input type="date" value="" class="form-control pay-desc-date">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            `)
                                        }

                                        
                                        $('.loading-icon-right').remove();
                                        $('.copy-item').val('')
                                        confirmHousings();
                                        
                                        $('.loading-icon-right').remove();
                                        $('.copy-item').val('')
                                        confirmHousings();
                                    },
                                });
                            })
                            
                            $('.project-disabled').closest('.form-group').remove();

                            $('.rendered-form input').change(function(){
                                if($(this).attr('type') != "file"){
                                    var lastOrders = 0;
                                    for(var i = 0 ; i < selectedBlock; i++){
                                        lastOrders += blockHouseCount[i];
                                    }
                                    var formData = new FormData();
                                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                                    formData.append('_token', csrfToken);
                                    formData.append('value',$(this).val());
                                    if($(this).hasClass('only-one')){
                                        formData.append('only-one',"1");
                                        $(this).closest('.form-group').find('.only-one[value!="'+$(this).val()+'"]').prop('checked',false);
                                    }
                                    console.log($(this).attr('name'))
                                    formData.append('order',lastOrders +(parseInt($('.house_order_input').val()) - 1));
                                    formData.append('item_type',1);
                                    if($(this).attr('type') == "checkbox"){
                                        formData.append('checkbox',"1");
                                        formData.append('key',$(this).attr('name').replace("[]", "").replace("[]", "").slice(0, -1)+(lastOrders + parseInt($('.house_order_input').val())));
                                    }else{
                                        formData.append('key',$(this).attr('name').replace("[]", "").replace("[]", ""));
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
                                var lastOrders = 0;
                                for(var i = 0 ; i < selectedBlock; i++){
                                    lastOrders += blockHouseCount[i];
                                }
                                if($(this).val().length){
                                    $(this).removeClass('error-border')
                                }
                                var formData = new FormData();
                                var csrfToken = $("meta[name='csrf-token']").attr("content");
                                formData.append('_token', csrfToken);
                                formData.append('value',$(this).val());
                                formData.append('order',lastOrders + parseInt($('.house_order_input').val()) - 1);
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

                            $(document).on('keyup','.price-only',function(){
                                $('.price-only .error-text').remove();
                                if($(this).val().replace('.','').replace('.','').replace('.','').replace('.','') != parseInt($(this).val().replace('.','').replace('.','').replace('.','').replace('.','').replace('.','') )){
                                    if($(this).closest('.form-group').find('.error-text').length > 0){
                                        $(this).val("");
                                    }else{
                                        $(this).closest('.form-group').append('<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                                        $(this).val("");
                                    }
                                    
                                }else{
                                    let inputValue = $(this).val();

                                    // Sadece sayı karakterlerine izin ver
                                    inputValue = inputValue.replace(/\D/g, '');

                                    // Her üç basamakta bir nokta ekleyin
                                    inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                                    $(this).val(inputValue)
                                    $(this).closest('.form-group').find('.error-text').remove();
                                }
                            })

                            $('.maks-3').keyup(function(){
                                console.log("asd")
                                if(parseInt($(this).val()) > 3){
                                    $(this).val(3);
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

                            if(isContinueProject){
                                $('.continue-disabled').closest('.form-group').remove();
                            }

                            $('.cover-image-by-housing-type').change(function(){
                                var input = this;
                                if (input.files && input.files[0]) {
                                    $(this).removeClass('error-border');
                                    confirmHousings();
                                    var reader = new FileReader();

                                    var formData = new FormData();
                                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                                    var lastOrders = 0;
                                    if(hasBlocks){
                                        for(var i = 0 ; i < selectedBlock; i++){
                                            lastOrders += parseInt(blockHouseCount[i]);
                                        }
                                    }
                                    formData.append('order',(lastOrders + parseInt($('.house_order_input').val()) - 1));
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

                                        $('.tab-pane.active .cover-image-by-housing-type').parent('div').find('.project_imaget').remove()
                                        $('.tab-pane.active .cover-image-by-housing-type').closest('.formbuilder-file').append(imageDiv)
                                        confirmHousings();
                                    };

                                    // Resmi okuyun
                                    reader.readAsDataURL(input.files[0]);
                                    
                                }
                            })
                            
                            $('.installement-dec-pay').closest('.form-group').after(`
                                <div class="dec-pay-area">
                                    <div class="top">
                                        <h4>Ara Ödemeler</h4>
                                        <button class="btn btn-primary add-pay-dec"><i class="fa fa-plus"></i></button>
                                    </div>
                                    <div class="pay-desc">
                                        <div class="pay-desc-item">
                                            <div class="row" style="align-items: flex-end;">
                                                <div class="flex-1">
                                                    <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                                </div>
                                                <div class="flex-10">
                                                    <label for="">Ara Ödeme Tutarı</label>
                                                    <input type="text" value="{{isset($tempData->pay_desc_price10) ? $tempData->pay_desc_price10 : ''}}" class="price-only form-control pay-desc-price">
                                                </div>
                                                <div class="flex-10">
                                                    <label for="">Ara Ödeme Tarihi</label>
                                                    <input type="date" value="{{isset($tempData->pay_desc_date10) ? $tempData->pay_desc_date10 : ""}}" class="form-control pay-desc-date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `)

                            @if(isset($tempData->{"pay-dec-count1"}))
                                @for($i = 1; $i < $tempData->{"pay-dec-count1"}; $i++)
                                    $('.pay-desc').append(`
                                        <div class="pay-desc-item">
                                            <div class="row" style="align-items: flex-end;">
                                                <div class="flex-1">
                                                    <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                                </div>
                                                <div class="flex-10">
                                                    <label for="">Ara Ödeme Tutarı</label>
                                                    <input type="text" value="{{ isset($tempData->{"pay_desc_price1".$i}) ? $tempData->{"pay_desc_price1".$i} : ""  }}" class="price-only pay-desc-price form-control">
                                                </div>
                                                <div class="flex-10">
                                                    <label for="">Ara Ödeme Tarihi</label>
                                                    <input type="date" value="{{isset($tempData->{"pay_desc_date1".$i}) ? $tempData->{"pay_desc_date1".$i} : ""}}" class="form-control pay-desc-date">
                                                </div>
                                            </div>
                                        </div>
                                    `)
                                @endfor
                            @endif

                            $('.price-only').keyup(function(){
                                $('.price-only .error-text').remove();
                                if($(this).val().replace('.','').replace('.','').replace('.','').replace('.','') != parseInt($(this).val().replace('.','').replace('.','').replace('.','').replace('.','').replace('.','') )){
                                    if($(this).closest('.form-group').find('.error-text').length > 0){
                                        $(this).val("");
                                    }else{
                                        $(this).closest('.form-group').append('<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                                        $(this).val("");
                                    }
                                    
                                }else{
                                    let inputValue = $(this).val();

                                    // Sadece sayı karakterlerine izin ver
                                    inputValue = inputValue.replace(/\D/g, '');

                                    // Her üç basamakta bir nokta ekleyin
                                    inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                                    $(this).val(inputValue)
                                    $(this).closest('.form-group').find('.error-text').remove();
                                }
                            })


                            $(document).on("click",".remove-pay-dec",function(){
                                var thisx = $(this);
                                var itemIndex = $(this).closest('.pay-desc-item').index();
                                var formData = new FormData();
                                var csrfToken = $("meta[name='csrf-token']").attr("content");
                                formData.append('_token', csrfToken);
                                formData.append('item_index',itemIndex);
                                formData.append('item_type',1);
                                formData.append('active_housing',$('.house_order_input').val());
                                $.ajax({
                                    type: "POST",
                                    url: "{{route('institutional.temp.order.remove.pay.dec')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        console.log(response);
                                        thisx.closest('.pay-desc-item').remove()
                                    },
                                });
                            })

                            $(document).on('change','.pay-desc-price',function(){
                                changeData($(this).val(),'pay_desc_price'+($('.house_order_input').val()+''+$(this).closest('.pay-desc-item').index()))
                            })

                            $(document).on('change','.pay-desc-date',function(){
                                changeData($(this).val(),'pay_desc_date'+($('.house_order_input').val()+''+$(this).closest('.pay-desc-item').index()))
                            })

                            $('#tablist').attr('style','height:'+$('.tab-content').css('height')+' !important;flex-wrap:nowrap;overflow:scroll;')

                            confirmHousings();
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    })
                    }
                    
                }
            })

            $('.choise-2').click(function(){
                $.ajax({
                    method: "POST",
                    url: "{{route('institutional.delete.temp.create')}}",
                    data : {
                        item_type : 1,
                        _token : csrfToken
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        if(response.status){
                            window.location.href = window.location.href
                        }
                        
                    }
                })
            })

            function confirmHousings(){
                var confirm = 0;
                var confirmCount = 0;
                $('.tab-pane').eq(0).find('input[required="required"]').map((key,item) => {
                    if($(item).attr('type') != "file"){
                        if(!$(item).val()){
                            confirmCount += 1;
                        }else{
                            confirm += 1;
                            confirmCount += 1;
                        }
                    }
                })
                $('.tab-pane').eq(0).find('select[required="required"]').map((key,item) => {
                    if(!$(item).val() || $(item).val() == "Seçiniz"){
                        confirmCount += 1;
                        console.log("selectte hata var");
                    }else{
                        confirm += 1;
                        console.log("select");
                        confirmCount += 1;
                    }
                })
                if($('.tab-pane').eq(0).find('input[type="file"]').closest('.formbuilder-file').find('.project_imaget img').length == 0){
                    confirmCount += 1;
                }else{
                    console.log("file");
                    confirm += 1;
                    confirmCount += 1;
                }

                var percent = (100 * confirm) / confirmCount;
                if(percent == 100){
                    fullHouses.push($('.house_order_input').val())
                }

                console.log(fullHouses);
                $('.percent-housing').html((percent.toFixed(2)))
                $('.full-load').css('width',percent+'%')
                var htmlCopyItems = "<option value=''>Daire bilgilerini kopyala</option>";
                var tempX = 1;
                if(hasBlocks){
                    for(var i = 0; i < blockHouseCount.length; i++){
                        for(var j = 0; j < blockHouseCount[i]; j++){
                            htmlCopyItems += "<option value='"+(tempX)+"'>"+blockNames[i]+" Blok "+(j+1)+" Nolu Konut</option>";
                            tempX++;
                        }
                    }
                    $('.copy-item').html(htmlCopyItems);
                }else{
                    for(var i = 0; i < houseCount; i++){
                        htmlCopyItems += "<option value='"+(i+1)+"'>"+(i+1)+" Nolu Konut </option>";
                    }
                    $('.copy-item').html(htmlCopyItems);
                }
            }

            $('#cities').change(function(){
                var selectedCity = $(this).val(); // Seçilen şehir değerini al
                cityName = $('#cities option[value="'+selectedCity+'"]').html()
                initMap(cityName,10)
                if($(this).val() != ""){
                    $(this).removeClass('error-border');
                }
            })

            $('#counties').change(function(){
                var selectedCounty = $(this).val(); // Seçilen şehir değerini al
                countyName = $('#counties option[value="'+selectedCounty+'"]').html()
                initMap(cityName+','+countyName,13);
                if($(this).val() != ""){
                    $(this).removeClass('error-border');
                }
            })

            $('#neighbourhood').change(function(){
                
                neighbourhoodName = $('#neighbourhood option[value="'+$(this).val()+'"]').html()
                initMap(cityName+','+countyName+','+neighbourhoodName,15)
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

            $('.finish-button-first').click(function() {
                toSecondArea();
            });

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

            $('.without-doping').click(function(e){
                $.ajax({
                    method: "POST",
                    url: "{{route('institutional.project.end.temp.order')}}",
                    data : {
                        _token : csrfToken,
                        without_doping : 1
                    },
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        console.log("asd");
                        // İlerleme durumu değiştikçe çalışacak olan fonksiyon
                        xhr.upload.addEventListener('progress', function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = (evt.loaded / evt.total) * 100;
                                console.log(percentComplete);
                                $('.progress-bar').css('width',percentComplete+'%');
                            }
                        }, false);

                        return xhr;
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
                            $('.load-area').addClass('d-none');
                            $('#finalConfirmationModal').removeClass('show')
                        }
                    }
                })
                
                $(this).off(e);
            })
            
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
                console.log(input.files)
                if (input.files && input.files[0]) {
                    $('.photo-area').removeClass('error-border')

                    var formData = new FormData();
                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                    formData.append('_token', csrfToken);
                    formData.append('item_type',1);
                    for (let i = 0; i < this.files.length; i++) {
                        formData.append(`file${i}`, this.files[i]);
                    }
                    $.ajax({
                        type: "POST",
                        url: "{{route('institutional.temp.order.image.add')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            
                            for (let i = 0; i < response.length; i++) {
                                var imageDiv = $('<div class="project_imagex" order="'+response[i]+'"></div>');
                                var image = $('<img>').attr('src', '{{URL::to('/')}}/project_images/'+response[i]);
                                var imageButtons = $('<div>').attr('class','image-buttons');
                                var imageButtonsIcon = $('<i>').attr('class','fa fa-trash');
                                imageButtons.append(imageButtonsIcon)
                                imageDiv.append(image);
                                imageDiv.append(imageButtons);
                                $('.photos').append(imageDiv);

                                $('.project_imagex .image-buttons').click(function(){
                                    var thisx = $(this);
                                    $.ajax({
                                        url: '{{route("institutional.delete.image.order.temp.update")}}',
                                        type: 'POST',
                                        data: { 
                                            image: $(this).closest('.project_imagex').attr('order') ,
                                            item_type : 1,
                                            _token : csrfToken
                                        },
                                        success: function(response) {
                                            thisx.closest('.project_imagex').remove()
                                        },
                                        error: function(xhr, status, error) {
                                            console.error("Ajax isteği sırasında bir hata oluştu: " + error);
                                        }
                                    });
                                })
                            }
                        },
                        error: function() {
                            // Hata durumunda kullanıcıya bir mesaj gösterebilirsiniz
                            alert("Dosya yüklenemedi.");
                        }
                    });
                    

                }
            });
            
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
                                        var json = JSON.parse(response.form_json);
                                            console.log(json[lm].name+'-');
                                        var renderHtml = renderHtml.toString().split(json[lm].name+'-');
                                        renderHtmlx = "";
                                        console.log(renderHtml);
                                        for(var t = 0 ; t < renderHtml.length ; t++){
                                            if(t != renderHtml.length - 1){
                                                renderHtmlx += renderHtml[t]+(json[lm].name.split('[]')[0])+i+'[]-'+i;
                                            }else{
                                                renderHtmlx += renderHtml[t];
                                            }
                                        }

                                        renderHtml = renderHtmlx;
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
                cityName = $('#cities option[value="'+selectedCity+'"]').html()
                initMap(cityName,10)
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
                countyName = $('#counties option[value="'+selectedCounty+'"]').html()
                initMap(cityName+','+countyName,13);
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
    <script src="{{URL::to('/')}}/adminassets/rich-editor/jquery.richtext.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#editor').richText({
                saveOnBlur : 1,
                saveCallback: function (editor, source, content) {

                    const editorContent = content;
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
                }
            });
        })


        $('.finish-button').click(function(e){
            e.preventDefault();
            if($('.housing_after_step').hasClass('d-none')){
                $.ajax({
                    url: '{{route("institutional.temp.order.housing.confirm.full")}}?item_type=1',
                    type: 'GET',
                    success: function(response) {
                        response = JSON.parse(response);
                        if(response.status){
                            $('.housing_after_step').removeClass('d-none')
                        }else{
                            $.toast({
                                heading: 'Hata',
                                text: response.message,
                                position: 'top-right',
                                stack: false
                            })
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Ajax isteği sırasında bir hata oluştu: " + error);
                    }
                });
            }else{
                var next = true;
                var topError = 0;
                if(!$('input[name="name"]').val()){
                    next = false;
                    $('input[name="name"]').addClass('error-border')
                    topError = $('input[name="name"]').offset().top - parseFloat($('.navbar-top').css('height')) - 100;
                }

                $.ajax({
                    method: "GET",
                    url: "{{ route('institutional.temp.order.location.control') }}",
                    data: {
                        item_type: 1,
                        _token: csrfToken
                    },
                    success: function(response) {
                        if(!response){
                            next = false;
                            $('#mapContainer').parent('div').prepend('<div style="border-radius:0;color:#fff;" class="alert alert-danger">Haritada konumu seçmeniz gerekiyor</div>')
                            topError = $('#mapContainer').offset().top - parseFloat($('.navbar-top').css( 'height')) - 100;
                            
                        }else{
                            $('#mapContainer').parent('div').find('.alert-danger').remove();
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
                            if(!$(item).val() || $(item).val() == "Seçiniz"){
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
                    }
                })
            }
           
            

            
        })
        var itemOrder = 0;
        var itemSlug = "";
        var areasSlugs = [];
        

        $('.area-listx li').click(function(){
            $(this).append('<div class="loading-icon"><i class="fa fa-spinner"></i></div>')
            var thisx = $(this);
            $('.area-listx li').removeClass('selected');
            var thisx = $(this);
            var value = $(this).attr('attr-id');
            var key = "statuses";
            var isArray = 1; 
            if($(this).attr('attr-id') == 3){
                isContinueProject = true;
            }

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
                    changeData("",'step3_slug')
                    changeData("",'step2_slug')
                    changeData("",'step1_slug')
                    thisx.addClass('selected')
                    thisx.find('.loading-icon').remove();
                    $('.area-list').removeClass('active');
                    $('.area-list').eq(0).addClass('active')
                    $('.area-list').eq(0).find('li').removeClass('selected');
                },
            });
        })

        $('.area-list').eq(0).find('li').click(function(){
            $(this).append('<div class="loading-icon"><i class="fa fa-spinner"></i></div>')
            itemSlug = $(this).attr('slug');
            var thisx = $(this);
            var formData = new FormData();
            var csrfToken = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', csrfToken);
            formData.append("key","step1_slug");
            formData.append("value",itemSlug);
            formData.append("item_type",1);
            $.ajax({
                type: "POST",
                url: "{{route('institutional.temp.order.change.area.list.data')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
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
            itemSlug = $(this).attr('slug');
            if(itemSlug == "arsa"){
                $('.has_blocks_input').parent('.form-group').parent('.form-group').addClass("d-none");
                $('.has_blocks-close').removeClass("d-none");
            }else{
                $('.has_blocks_input').parent('.form-group').parent('.form-group').removeClass("d-none");
                $('.has_blocks-close').addClass("d-none");
            }
            $('.breadcrumb-v2').find('.breadcrumb-after-item').remove()
            $('.breadcrumb-v2').find('.breadcrumb-after-item').remove()
            $('.breadcrumb-v2').find('.breadcrumb-after-item').remove()
            $('.breadcrumb').find('.breadcrumb-after-item').remove()
            $('.breadcrumb').find('.breadcrumb-after-item').remove()
            $('.breadcrumb').find('.breadcrumb-after-item').remove()
            $.ajax({
                url: "{{URL::to('/')}}/institutional/get_housing_type_childrens/"+itemSlug, // AJAX isteği yapılacak URL
                type: "GET", // GET isteği
                dataType: "json", // Gelen veri tipi JSON
                success: function (data) {
                    $('.area-list').eq(0).find('li').removeClass('selected');
                    data = data.data;
                    var list = "";
                    for(var i = 0 ; i < data.length; i++){
                        list += "<li slug='"+data[i].slug+"'>"+data[i].title+"</li>"
                    }
                    $('.area-list').eq(1).children('ul').html(list)
                    thisx.addClass('selected')
                    thisx.find('.loading-icon').remove();
                    $('.breadcrumb').append('<span class="breadcrumb-after-item">'+(thisx.html())+'</span>')
                    $('.breadcrumb-v2').append('<span class="breadcrumb-after-item">'+(thisx.html())+'</span>')

                    $('.area-list').eq(1).addClass('active');
                    thisx.addClass('selected');

                    $('.area-list').eq(2).removeClass('active');
                    $('.area-list').eq(3).removeClass('active');

                    $('.area-list').eq(1).find('li').click(function(){
                        $(this).append('<div class="loading-icon"><i class="fa fa-spinner"></i></div>')
                        itemSlug = $(this).attr('slug');
                        var thisx = $(this);
                        var formData = new FormData();
                        var csrfToken = $("meta[name='csrf-token']").attr("content");
                        formData.append('_token', csrfToken);
                        formData.append("key","step2_slug");
                        formData.append("value",itemSlug);
                        formData.append("item_type",1);
                        $.ajax({
                            type: "POST",
                            url: "{{route('institutional.temp.order.change.area.list.data')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
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
                        $('.breadcrumb').find('.breadcrumb-after-item').eq(1).remove()
                        $('.breadcrumb').find('.breadcrumb-after-item').eq(1).remove()
                        $('.breadcrumb-v2').find('.breadcrumb-after-item').eq(1).remove()
                        $('.breadcrumb-v2').find('.breadcrumb-after-item').eq(1).remove()
                        $.ajax({
                            url: "{{URL::to('/')}}/institutional/get_housing_type_childrens/"+itemSlug+'?parent_slug='+$('.area-list').eq(0).find('li.selected').attr('slug'), // AJAX isteği yapılacak URL
                            type: "GET", // GET isteği
                            dataType: "json", // Gelen veri tipi JSON
                            success: function (data) {
                                $('.area-list').eq(1).find('li').removeClass('selected');
                                $('.area-list').eq(3).removeClass('active');
                                data = data.data;
                                var list = "";
                                for(var i = 0 ; i < data.length; i++){
                                    list += "<li slug='"+data[i].slug+"'>"+data[i].title+"</li>"
                                }
                                thisx.addClass('selected')
                                thisx.find('.loading-icon').remove();
                                $('.breadcrumb').append('<span class="breadcrumb-after-item">'+(thisx.html())+'</span>')
                                $('.breadcrumb-v2').append('<span class="breadcrumb-after-item">'+(thisx.html())+'</span>')
                                $('.area-list').eq(2).children('ul').html(list)

                                $('.area-list').eq(2).addClass('active');
                                thisx.addClass('selected');

                                $('.area-list').eq(2).find('li').click(function(){
                                    $(this).append('<div class="loading-icon"><i class="fa fa-spinner"></i></div>')
                                    itemSlug = $(this).attr('slug');
                                    var thisx = $(this);
                                    var formData = new FormData();
                                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                                    formData.append('_token', csrfToken);
                                    formData.append("key","step3_slug");
                                    formData.append("value",itemSlug);
                                    formData.append("item_type",1);
                                    $.ajax({
                                        type: "POST",
                                        url: "{{route('institutional.temp.order.change.area.list.data')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
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
                                    $('.breadcrumb').find('.breadcrumb-after-item').eq(2).remove()
                                    $('.breadcrumb-v2').find('.breadcrumb-after-item').eq(2).remove()
                                    $.ajax({
                                        url: "{{URL::to('/')}}/institutional/get_housing_type_id/"+itemSlug, // AJAX isteği yapılacak URL
                                        type: "GET", // GET isteği
                                        dataType: "json", // Gelen veri tipi JSON
                                        success: function (data) {
                                            $('.area-list').eq(2).find('li').removeClass('selected');
                                            changeData(data,'housing_type_id');
                                            console.log(data);
                                            selectedid = data;
                                            thisx.addClass('selected')
                                            thisx.find('.loading-icon').remove();
                                            $('.breadcrumb').append('<span class="breadcrumb-after-item">'+(thisx.html())+'</span>')
                                            $('.breadcrumb-v2').append('<span class="breadcrumb-after-item">'+(thisx.html())+'</span>')
                                            $('.last-housing-text').html('Önceki '+(thisx.html())+'')
                                            $('.next-housing-text').html('Sonraki '+(thisx.html())+'')
                                    
                                            $('.housings_title').html('Bu Projede Kaç Adet '+(thisx.html())+' Var')
                                            
                                            thisx.addClass('selected');
                                            $('.area-list').eq(3).addClass('active');
                                        }
                                    })
                                })
                            },
                            error: function (xhr, status, error) {
                                // İstek hata verdiğinde çalışacak fonksiyon
                                console.error(xhr.statusText);
                            }
                        });
                    })

                    
                },
                error: function (xhr, status, error) {
                    // İstek hata verdiğinde çalışacak fonksiyon
                    console.error(xhr.statusText);
                }
            });
        })

        $('.area-list').eq(1).find('li').click(function(){
            $(this).append('<div class="loading-icon"><i class="fa fa-spinner"></i></div>')
            itemSlug = $(this).attr('slug');
            var thisx = $(this);
            var formData = new FormData();
            var csrfToken = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', csrfToken);
            formData.append("key","step2_slug");
            formData.append("value",itemSlug);
            formData.append("item_type",1);
            $.ajax({
                type: "POST",
                url: "{{route('institutional.temp.order.change.area.list.data')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
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
            $('.breadcrumb').find('.breadcrumb-after-item').eq(1).remove()
            $('.breadcrumb').find('.breadcrumb-after-item').eq(1).remove()
            $('.breadcrumb-v2').find('.breadcrumb-after-item').eq(1).remove()
            $('.breadcrumb-v2').find('.breadcrumb-after-item').eq(1).remove()
            $.ajax({
                url: "{{URL::to('/')}}/institutional/get_housing_type_childrens/"+itemSlug+'?parent_slug='+$('.area-list').eq(0).find('li.selected').attr('slug'), // AJAX isteği yapılacak URL
                type: "GET", // GET isteği
                dataType: "json", // Gelen veri tipi JSON
                success: function (data) {
                    console.log(data);
                    $('.area-list').eq(1).find('li').removeClass('selected');
                    data = data.data;
                    var list = "";
                    for(var i = 0 ; i < data.length; i++){
                        list += "<li slug='"+data[i].slug+"'>"+data[i].title+"</li>"
                    }
                    $('.area-list').eq(2).children('ul').html(list)
                    thisx.addClass('selected')
                    thisx.find('.loading-icon').remove();
                    $('.breadcrumb').append('<span class="breadcrumb-after-item">'+(thisx.html())+'</span>')
                    $('.breadcrumb-v2').append('<span class="breadcrumb-after-item">'+(thisx.html())+'</span>')

                    $('.area-list').eq(2).addClass('active');
                    thisx.addClass('selected');

                    $('.area-list').eq(2).find('li').click(function(){
                        $(this).append('<div class="loading-icon"><i class="fa fa-spinner"></i></div>')
                        itemSlug = $(this).attr('slug');
                        var thisx = $(this);
                        var formData = new FormData();
                        var csrfToken = $("meta[name='csrf-token']").attr("content");
                        formData.append('_token', csrfToken);
                        formData.append("key","step3_slug");
                        formData.append("value",itemSlug);
                        formData.append("item_type",1);
                        $.ajax({
                            type: "POST",
                            url: "{{route('institutional.temp.order.change.area.list.data')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
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
                        $('.breadcrumb').find('.breadcrumb-after-item').eq(2).remove()
                        $('.breadcrumb-v2').find('.breadcrumb-after-item').eq(2).remove()
                        $.ajax({
                            url: "{{URL::to('/')}}/institutional/get_housing_type_id/"+itemSlug, // AJAX isteği yapılacak URL
                            type: "GET", // GET isteği
                            dataType: "json", // Gelen veri tipi JSON
                            success: function (data) {
                                $('.area-list').eq(2).find('li').removeClass('selected');
                                changeData(data,'housing_type_id');
                                selectedid = data;
                                thisx.addClass('selected')
                                thisx.find('.loading-icon').remove();
                                $('.breadcrumb').append('<span class="breadcrumb-after-item">'+(thisx.html())+'</span>')
                                $('.breadcrumb-v2').append('<span class="breadcrumb-after-item">'+(thisx.html())+'</span>')
                                $('.last-housing-text').html('Önceki '+(thisx.html())+'')
                                $('.next-housing-text').html('Sonraki '+(thisx.html())+'')
                        
                                $('.housings_title').html('Bu Projede Kaç Adet '+(thisx.html())+' Var')
                                
                                thisx.addClass('selected');
                                $('.area-list').eq(3).addClass('active');
                            }
                        })
                    })
                },
                error: function (xhr, status, error) {
                    // İstek hata verdiğinde çalışacak fonksiyon
                    console.error(xhr.statusText);
                }
            });
        })

        $('.area-list').eq(2).find('li').click(function(){
            $(this).append('<div class="loading-icon"><i class="fa fa-spinner"></i></div>')
            itemSlug = $(this).attr('slug');
            
            console.log($(this).html());
            
            var thisx = $(this);
            var formData = new FormData();
            var csrfToken = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', csrfToken);
            formData.append("key","step3_slug");
            formData.append("value",itemSlug);
            formData.append("item_type",1);
            $.ajax({
                type: "POST",
                url: "{{route('institutional.temp.order.change.area.list.data')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
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
            $('.breadcrumb').find('.breadcrumb-after-item').eq(2).remove()
            $('.breadcrumb-v2').find('.breadcrumb-after-item').eq(2).remove()
            $.ajax({
                url: "{{URL::to('/')}}/institutional/get_housing_type_id/"+itemSlug, // AJAX isteği yapılacak URL
                type: "GET", // GET isteği
                dataType: "json", // Gelen veri tipi JSON
                success: function (data) {
                    $('.area-list').eq(2).find('li').removeClass('selected');
                    changeData(data,'housing_type_id');
                    thisx.addClass('selected')
                    thisx.find('.loading-icon').remove();
                    $('.breadcrumb').append('<span class="breadcrumb-after-item">'+(thisx.html())+'</span>')
                    $('.breadcrumb-v2').append('<span class="breadcrumb-after-item">'+(thisx.html())+'</span>')
                    $('.last-housing-text').html('Önceki '+(thisx.html())+'')
                    $('.next-housing-text').html('Sonraki '+(thisx.html())+'')
                    $('.housings_title').html('Bu Projede Kaç Adet '+(thisx.html())+' Var')
                    selectedid = data;
                    thisx.addClass('selected');
                    $('.area-list').eq(3).addClass('active');
                }
            })
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css"
        integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.css" />

    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/assets/css/daterangepicker.css">
    <link rel="stylesheet" href="{{URL::to('/')}}/adminassets/rich-editor/richtext.min.css">
    <link rel="stylesheet" href="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/skins/content/default/content.min.css">
@endsection

