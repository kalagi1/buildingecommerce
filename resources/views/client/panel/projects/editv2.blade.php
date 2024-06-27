@extends('institutional.layouts.master')

@section('content')
    <div class="loading-area d-none">
        <div class="loading">Loading&#8230;</div>
    </div>
    @if ($tempUpdateHas)
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
                            Eski haline Döndür
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="content">
        <h2 class="mb-2 lh-sm  @if (isset($tempDataFull->step_order) && $tempDataFull->step_order != 1) d-none @endif">İlanı Güncelle</h2>
        <div class="breadcrumb  @if (isset($tempDataFull->step_order) && $tempDataFull->step_order != 1) d-none @endif">
            <span>Emlak</span>
        </div>
        @if ($project->status == 0)
            <h3 style="color:orange">Projeniz şu anda pasif durumda !</h3>
        @elseif ($project->status == 3)
            <h3 style="color:#e54242">Projeniz reddedildi !</h3>
        @else
            <h3 style="color:green">Projeniz şu anda yayında !</h3>
        @endif
        <div class="mt-4">
            <div class="clear-both"></div>
            <div class="firt-area d-none">
                <div class="row">
                    <div class="area-lists">
                        <div class="area-list active">
                            <ul>
                                @foreach ($housingTypeParent as $parent)
                                    <li @if (isset($tempData->step1_slug) && $tempData->step1_slug == $parent->slug) class="selected" @endif
                                        slug="{{ $parent->slug }}">{{ $parent->title }}</li>
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
            <div class="second-area">
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
                                        <input type="text"
                                            value="{{ isset($tempData->project_title) ? $tempData->project_title : '' }}"
                                            name="name" class="form-control advert_title">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="max-character"
                                            for="">{{ isset($tempData->project_title) ? Str::length(trim($tempData->project_title)) : '0' }}/70</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group description-field">
                            <label for="">İlan Açıklaması <span class="required">*</span></label>
                            <div id="editor2">
                                {!! isset($tempData->description) ? $tempData->description : '' !!}
                            </div>
                              
                            {{-- <textarea name="description" id="editor" cols="30" rows="5" onkeyup="changeData(this.value,'description')"
                                class="form-control">{!! isset($tempData->description) ? $tempData->description : '' !!}</textarea> --}}
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
                                            <input type="text" value="{{isset($tempData->total_project_area) && $tempData->total_project_area ?  number_format(str_replace('.','',$tempData->total_project_area), 0, ',', '.')  : ''}}" class="total_project_area price-only" onkeyup="changeData(this.value,'total_project_area')">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Ada Bilgisi</label>
                                        <div class="icon-input">
                                            <div class="icon-area">
                                                <svg style="width: 20px;height: 20px;" fill="#ffffff" height="800px" width="800px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 491.541 491.541" xml:space="preserve"> <g> <path d="M350.373,116.048H24.445C10.942,116.048,0,126.988,0,140.492V466.42c0,13.503,10.942,24.445,24.445,24.445h325.928 c13.503,0,24.444-10.942,24.444-24.445V140.492C374.817,126.988,363.876,116.048,350.373,116.048z M325.928,441.975H48.889V164.936 h277.039V441.975z"/> <path d="M486.695,411.913h-26.513V126.63h26.513c1.958,0,3.724-1.178,4.472-2.991c0.756-1.814,0.342-3.892-1.05-5.283 l-42.802-42.802c-1.894-1.894-4.965-1.894-6.858,0l-42.803,42.802c-1.392,1.392-1.806,3.469-1.05,5.283 c0.749,1.813,2.515,2.991,4.473,2.991h26.513v285.283h-26.513c-1.958,0-3.724,1.177-4.473,2.991 c-0.755,1.815-0.342,3.893,1.05,5.285l42.803,42.802c1.893,1.894,4.965,1.894,6.858,0l42.802-42.802 c1.393-1.392,1.807-3.469,1.05-5.285C490.419,413.09,488.654,411.913,486.695,411.913z"/> <path d="M70.676,94.563c1.392,1.392,3.469,1.806,5.284,1.05c1.814-0.747,2.992-2.514,2.992-4.472V64.628h285.283v26.513 c0,1.958,1.177,3.725,2.991,4.472c1.814,0.756,3.891,0.342,5.284-1.05l42.802-42.802c1.894-1.895,1.894-4.967,0-6.86L372.51,2.1 c-1.393-1.393-3.469-1.807-5.284-1.051c-1.814,0.748-2.991,2.514-2.991,4.472v26.515H78.952V5.521c0-1.957-1.177-3.724-2.992-4.472 c-1.814-0.756-3.892-0.342-5.284,1.051L27.875,44.901c-1.894,1.893-1.894,4.965,0,6.86L70.676,94.563z"/> </g> </svg>
                                            </div>
                                            <input type="text" value="{{isset($tempData->island) && $tempData->island ?  $tempData->island : ''}}" class="total_project_area" onkeyup="changeData(this.value,'island')">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Parsel Bilgisi</label>
                                        <div class="icon-input">
                                            <div class="icon-area">
                                                <svg style="width: 20px;height: 20px;" fill="#ffffff" height="800px" width="800px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 491.541 491.541" xml:space="preserve"> <g> <path d="M350.373,116.048H24.445C10.942,116.048,0,126.988,0,140.492V466.42c0,13.503,10.942,24.445,24.445,24.445h325.928 c13.503,0,24.444-10.942,24.444-24.445V140.492C374.817,126.988,363.876,116.048,350.373,116.048z M325.928,441.975H48.889V164.936 h277.039V441.975z"/> <path d="M486.695,411.913h-26.513V126.63h26.513c1.958,0,3.724-1.178,4.472-2.991c0.756-1.814,0.342-3.892-1.05-5.283 l-42.802-42.802c-1.894-1.894-4.965-1.894-6.858,0l-42.803,42.802c-1.392,1.392-1.806,3.469-1.05,5.283 c0.749,1.813,2.515,2.991,4.473,2.991h26.513v285.283h-26.513c-1.958,0-3.724,1.177-4.473,2.991 c-0.755,1.815-0.342,3.893,1.05,5.285l42.803,42.802c1.893,1.894,4.965,1.894,6.858,0l42.802-42.802 c1.393-1.392,1.807-3.469,1.05-5.285C490.419,413.09,488.654,411.913,486.695,411.913z"/> <path d="M70.676,94.563c1.392,1.392,3.469,1.806,5.284,1.05c1.814-0.747,2.992-2.514,2.992-4.472V64.628h285.283v26.513 c0,1.958,1.177,3.725,2.991,4.472c1.814,0.756,3.891,0.342,5.284-1.05l42.802-42.802c1.894-1.895,1.894-4.967,0-6.86L372.51,2.1 c-1.393-1.393-3.469-1.807-5.284-1.051c-1.814,0.748-2.991,2.514-2.991,4.472v26.515H78.952V5.521c0-1.957-1.177-3.724-2.992-4.472 c-1.814-0.756-3.892-0.342-5.284,1.051L27.875,44.901c-1.894,1.893-1.894,4.965,0,6.86L70.676,94.563z"/> </g> </svg>
                                            </div>
                                            <input type="text" value="{{isset($tempData->parcel) && $tempData->parcel ?  $tempData->parcel  : ''}}" class="total_project_area" onkeyup="changeData(this.value,'parcel')">
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
                                            <input type="date" value="{{isset($tempData->project_end_date) ? $tempData->project_end_date : ''}}" class="project_end_date" onchange="changeData(this.value,'project_end_date')" onkeyup="changeData(this.value,'project_end_date')">
                                        </div>
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
                                        <select onchange="changeData(this.value,'city_id')" name="city_id" id="cities"
                                            class="form-control">
                                            <option value="">İl Seç</option>
                                            @foreach ($cities as $city)
                                                <option
                                                    {{ isset($tempData->city_id) && $tempData->city_id == $city->id ? 'selected' : '' }}
                                                    value="{{ $city->id }}">{{ $city->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">İlçe <span class="required">*</span></label>
                                        <select onchange="changeData(this.value,'county_id')" name="county_id"
                                            id="counties" class="form-control">
                                            <option value="">İlçe Seç</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Mahalle <span class="required">*</span></label>
                                        <select onchange="changeData(this.value,'neighbourhood_id')"
                                            name="neighbourhood_id" id="neighbourhood" class="form-control">
                                            <option value="">Mahalle Seç</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <input name="location" class="form-control" id="location" readonly type="hidden"
                                        value="@if (isset($tempData->location)) {{ $tempData->location }}@else 39.1667,35.6667 @endif" />
                                    <div style="height: 350px;" id="mapContainer"></div>
                                </div>
                            </div>
                        </div>
                        <span class="section-title mt-4">Kapak Fotoğrafı</span>
                        <div class="cover-photo-full card py-2 px-5">
                            <input type="file" accept="image/*" name="cover-image" class="cover_image d-none">
                            <div class="upload-container col-md-3 cover-photo-area">
                                <div class="border-container">
                                    <div class="icons fa-4x">
                                        <i class="fas fa-file-image" data-fa-transform="shrink-2 up-4"></i>
                                    </div>
                                    <!--<input type="file" id="file-upload">-->
                                    <p>Bilgisayardan Fotoğraf Ekle <span>veya sürükle bırak</span></p>
                                </div>
                            </div>
                            <div class="cover-photo">
                                @if (isset($tempData->image) && $tempData->image)
                                    <div class="project_imagex">
                                        <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $tempData->image) }}"
                                            alt="">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <span class="section-title mt-4">Proje Galerisi</span>
                        <div class="photo card py-2 px-5">
                            <input type="file" accept="image/*" multiple name="project-images" class="project_image d-none">
                            <div class="upload-container col-md-3 photo-area">
                                <div class="border-container">
                                    <div class="icons fa-4x">
                                        <i class="fas fa-file-image" data-fa-transform="shrink-2 up-4"></i>
                                    </div>
                                    <!--<input type="file" id="file-upload">-->
                                    <p>Bilgisayardan Fotoğraf Ekle <span>veya sürükle bırak</span></p>
                                </div>
                            </div>
                            <div class="photos">
                                <div>
                                    <span>{{count($tempData->images)}} / 40</span>
                                </div>
                                @if (isset($tempData->images) && $tempData->images)
                                    @foreach ($tempData->images as $key => $image)
                                        <div class="project_imagex" order="{{ $image->image }}">
                                            <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $image->image) }}" alt="">
                                            <div class="image-buttons">
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <span class="section-title mt-4 housing_after_step">Vaziyet & Kat Planı</span>
                        <div class="photo card py-2 px-5 housing_after_step">
                            <input type="file" multiple name="situation-plans" accept="image/*" class="situation-plan d-none">
                            <div class="upload-container col-md-4 col-xl-3 situation-plan-div" ondrop="handleDrop4(event)" ondragover="allowDrop4(event)">
                                <div class="border-container">
                                  <div class="icons fa-4x">
                                    <i class="fas fa-file-image" data-fa-transform="shrink-2 up-4"></i>
                                  </div>
                                  <!--<input type="file" id="file-upload">-->
                                  <p>Bilgisayardan Fotoğraf Ekle <span>veya sürükle bırak</span></p>
                                </div>
                            </div>
                            <div class="situations">
                                <div>
                                    <span>{{count($tempData->situations)}} / 40</span>
                                </div>
                                @if(isset($tempData->situations) && $tempData->situations)
                                    @foreach($tempData->situations as $image)
                                        <div class="situation_imagex"  order="{{$image->situation}}">
                                            <img src="{{URL::to('/')}}/situation_images/{{str_replace('public/situation_images/', '', $image->situation)}}" alt="">
                                            <div class="image-buttons">
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="second-area-finish">
                            <div class="finish-tick ">
                                <input type="checkbox" value="1" class="rules_confirm">
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
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
        integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/assets/js/moment.min.js"
        integrity="sha512-CryKbMe7sjSCDPl18jtJI5DR5jtkUWxPXWaLCst6QjH8wxDexfRJic2WRmRXmstr2Y8SxDDWuBO6CQC6IE4KTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ URL::to('/') }}/adminassets/assets/js/jquery.daterangepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
        integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&callback=initMap" async defer></script>

    <script>
        const toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            ['blockquote', 'code-block'],
            ['link', 'image', 'video', 'formula'],

            [{ 'header': 1 }, { 'header': 2 }],               // custom button values
            [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
            [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
            [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
            [{ 'direction': 'rtl' }],                         // text direction

            [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

            [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
            [{ 'font': [] }],
            [{ 'align': [] }],

            ['clean']                                         // remove formatting button
        ];
        const quill = new Quill('#editor2', {
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions,
            }
        });

        console.log($('#editor2').html());

        $('#editor2').on('text-change',() => {
            
        })

        quill.on('text-change', function(delta, oldDelta, source) {
            if (quill.container.firstChild.innerHTML != "") {
                descriptionText = "evet var";

            }
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                "content");


            // Verileri FormData nesnesine ekleyin
            const formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('value', quill.container.firstChild.innerHTML);
            formData.append('key', "description");
            formData.append('item_type', 3);

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

        var nextTemp = false;
        var housingImages = [];
        var descriptionText =
            @if (isset($tempData) && isset($tempData->description))
                'evet var'
            @else
                ""
            @endif ;
        var selectedid =
            @if (isset($tempData) && isset($tempData->housing_type_id))
                {{ $tempData->housing_type_id }}
            @else
                0
            @endif ;

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
                formData.append('item_type',3);
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

        $('.situations').sortable({
            revert: true,
            update: function(event, ui) {
                var ids = [];
                for(var i = 0; i < $('.situations .situation_imagex').length; i++){
                    ids.push($('.situations .situation_imagex').eq(i).attr('order'));
                }
                // Sıralama değiştiğinde bir Ajax POST isteği gönder
                $.ajax({
                    url: '{{route("institutional.update.situation.order.temp.update")}}',
                    type: 'POST',
                    data: { 
                        situations: ids ,
                        item_type : 3,
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

        $('.situation_imagex').draggable({
            connectToSortable: ".situations",
        });

        $('.situation-plan-div').click(function(){
            $('.situation-plan.d-none').trigger('click');
        })

        $('.situation-plan').change(function() {
            var input = this;
            console.log(input.files)
            if (input.files && input.files[0]) {
                $('.situation-area').removeClass('error-border')

                var formData = new FormData();
                var csrfToken = $("meta[name='csrf-token']").attr("content");
                formData.append('_token', csrfToken);
                formData.append('item_type',3);
                for (let i = 0; i < this.files.length; i++) {
                    formData.append(`file${i}`, this.files[i]);
                }
                $.ajax({
                    type: "POST",
                    url: "{{route('institutional.temp.order.situation.add')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        
                        for (let i = 0; i < response.length; i++) {
                            var imageDiv = $('<div class="situation_imagex" order="'+response[i]+'"></div>');
                            var image = $('<img>').attr('src', '{{URL::to('/')}}/situation_images/'+response[i]);
                            var imageButtons = $('<div>').attr('class','image-buttons');
                            var imageButtonsIcon = $('<i>').attr('class','fa fa-trash');
                            imageButtons.append(imageButtonsIcon)
                            imageDiv.append(image);
                            imageDiv.append(imageButtons);
                            $('.situations').append(imageDiv);

                            $('.situation_imagex .image-buttons').click(function(){
                                var thisx = $(this);
                                $.ajax({
                                    url: '{{route("institutional.delete.situation.order.temp.update")}}',
                                    type: 'POST',
                                    data: { 
                                        situation: $(this).closest('.situation_imagex').attr('order') ,
                                        item_type : 3,
                                        _token : csrfToken
                                    },
                                    success: function(response) {
                                        thisx.closest('.situation_imagex').remove()
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

        $('.situation_imagex .image-buttons').click(function(){
            var thisx = $(this);
            $.ajax({
                url: '{{route("institutional.delete.situation.order.temp.update")}}',
                type: 'POST',
                data: { 
                    situation: $(this).closest('.situation_imagex').attr('order') ,
                    item_type : 3,
                    _token : csrfToken
                },
                success: function(response) {
                    thisx.closest('.situation_imagex').remove()
                },
                error: function(xhr, status, error) {
                    console.error("Ajax isteği sırasında bir hata oluştu: " + error);
                }
            });
        })

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
                formData.append('item_type',3);
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
                formData.append('item_type',3);
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


        $('.price-only').keyup(function(){
            if($('.price-only').val().replace('.','').replace('.','').replace('.','').replace('.','') != parseInt($('.price-only').val().replace('.','').replace('.','').replace('.','').replace('.','').replace('.','') )){
                $('.price-only').val("");
            }else{
                let inputValue = $(this).val();

                // Sadece sayı karakterlerine izin ver
                inputValue = inputValue.replace(/\D/g, '');

                // Her üç basamakta bir nokta ekleyin
                inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                $(this).val(inputValue)
            }
        })

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
                        $neighbourhoodJs = DB::table('neighborhoods')->where('mahalle_id',$tempData->neighbourhood_id)->first();
                    @endphp

                    neighbourhoodName = "{{isset($neighbourhoodJs->mahalle_title) && $neighbourhoodJs->mahalle_title ? $neighbourhoodJs->mahalle_title : ""}}";
                    
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
        
        @if(isset($tempData->location) && $tempData->location)
            @php 
                $location = explode(',',$tempData->location);
            @endphp
            setTimeout(() => {
                var marker = new google.maps.Marker({
                    position: {lat: {{$location[0]}}, lng: {{$location[1]}}},
                    map: map,
                });

                markers.push(marker); // İşaretçiyi dizide saklayın
            }, 2000);
        @endif

        $('.choise-1').click(function() {
            $('.pop-up-v2').addClass('d-none')
        })

        $('.photos').sortable({
            revert: true,
            update: function(event, ui) {
                var ids = [];
                for (var i = 0; i < $('.photos .project_imagex').length; i++) {
                    ids.push($('.photos .project_imagex').eq(i).attr('order'));
                }
                console.log(ids);
                // Sıralama değiştiğinde bir Ajax POST isteği gönder
                $.ajax({
                    url: '{{ route('institutional.update.image.order.temp.update') }}',
                    type: 'POST',
                    data: {
                        images: ids,
                        item_type: 3,
                        _token: csrfToken
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

        $('.project_imagex .image-buttons').click(function() {
            var thisx = $(this);
            $.ajax({
                url: '{{ route('institutional.delete.image.order.temp.update') }}',
                type: 'POST',
                data: {
                    image: $(this).closest('.project_imagex').attr('order'),
                    item_type: 3,
                    _token: csrfToken
                },
                success: function(response) {
                    thisx.closest('.project_imagex').remove()
                },
                error: function(xhr, status, error) {
                    console.error("Ajax isteği sırasında bir hata oluştu: " + error);
                }
            });
        })

        $('.choise-2').click(function() {
            $.ajax({
                method: "POST",
                url: "{{ route('institutional.delete.temp.update') }}",
                data: {
                    item_type: 3,
                    _token: csrfToken
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status) {
                        window.location.href = window.location.href
                    }

                }
            })
        })


        function confirmHousings() {
            for (var i = 0; i < $('.tab-pane').length; i++) {
                var confirm = 1;
                $('.tab-pane').eq(i).find('input[required="required"]').map((key, item) => {
                    if (!$(item).val() && $(item).attr('type') != "file") {

                        confirm = 0;
                    }
                })
                $('.tab-pane').eq(i).find('select[required="required"]').map((key, item) => {
                    if (!$(item).val() || $(item).val() == "Seçiniz") {

                        confirm = 0;
                    }
                })
                if ($('.tab-pane').eq(i).find('input[type="file"]').closest('.formbuilder-file').find('.project_imaget')
                    .length == 0) {
                    confirm = 0;
                }

                if (confirm) {
                    $('#tablist>.item-left-area').eq(i).addClass('confirm');
                }
            }

        }

        $('#cities').change(function() {
            if ($(this).val() != "") {
                $(this).removeClass('error-border');
            }
        })

        $('#counties').change(function() {
            if ($(this).val() != "") {
                $(this).removeClass('error-border');
            }
        })

        $('#neighbourhood').change(function() {
            if ($(this).val() != "") {
                $(this).removeClass('error-border');
            }
        })

        $('.progress-line li').click(function(e) {
            e.preventDefault();
            var currentIndex = $('.progress-line li.current').index();

            var clickIndex = $(this).index();
            if (clickIndex == 0) {
                toFirstArea();
            } else if (clickIndex == 1) {
                toSecondArea();
            }
            if (clickIndex == 2) {
                toThirdArea();
            }

        })

        function toSecondArea() {
            $.ajax({
                method: "POST",
                url: "{{ route('institutional.change.step.order') }}",
                data: {
                    order: 2,
                    item_type: 3,
                    _token: csrfToken
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status) {
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

        function toThirdArea() {
            $('.finish-button').trigger('click');

            if (nextTemp) {
                $.ajax({
                    method: "POST",
                    url: "{{ route('institutional.change.step.order') }}",
                    data: {
                        order: 3,
                        item_type: 3,
                        _token: csrfToken
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status) {
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

        function toFirstArea() {
            $.ajax({
                method: "POST",
                url: "{{ route('institutional.change.step.order') }}",
                data: {
                    order: 1,
                    item_type: 3,
                    _token: csrfToken
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status) {
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
        })

        $('.doping_statuses').change(function() {
            if ($(this).val() != "") {
                $('.doping_statuses').removeClass('error-border')
            }
        })

        $('.doping_order').change(function() {
            if ($(this).val() != "") {
                $('.doping_order').removeClass('error-border')
            }
        })


        function datediff(first, second) {
            return Math.round((second - first) / (1000 * 60 * 60 * 24));
        }
        $('.list-dates').click(function() {
            console.log()
            if ($('.doping_statuses').val() == "") {
                $('.doping_statuses').addClass('error-border')
            }

            if ($('.doping_order').val() == "") {
                $('.doping_order').addClass('error-border')
            }

            changeData($('.doping_statuses').val(), "doping_statuses");
            changeData($('.doping_order').val(), "doping_order");
            $.ajax({
                method: "GET",
                url: "{{ URL::to('/') }}/institutional/get_busy_housing_statuses/" + $('.doping_statuses')
                    .val(),
                data: {
                    order: $('.doping_order').val()
                },
                success: function(response) {
                    response = JSON.parse(response);
                    $('.daily-price').html(response.price.price + ' ₺')
                    $('.total-price').html('-')
                    $('.date-range').removeClass('d-none');
                    $('#date-range2').dateRangePicker({
                        showShortcuts: false,
                        beforeShowDay: function(t) {
                            const now = new Date();
                            var valid = true;
                            var birGun = 24 * 60 * 60 * 1000;
                            for (var i = 0; i < response.busy_dates.length; i++) {
                                const startTime = new Date(response.busy_dates[i]
                                    .start_date);
                                const endTime = new Date(response.busy_dates[i].end_date);
                                if (t.getTime() < now.getTime() || t.getTime() < (endTime
                                        .getTime() + birGun) && t.getTime() > startTime
                                    .getTime()) {
                                    valid = false;
                                }
                            }


                            if (t.getTime() < now.getTime()) {
                                valid = false;
                            }
                            var _class = '';
                            var _tooltip = valid ? '' : 'Bu tarihler dolu';
                            return [valid, _class, _tooltip];
                        }
                    }).on('datepicker-change', function(event, obj) {
                        
                        /* This event will be triggered when second date is selected */
                        var startTime = new Date(obj.date1);
                        var endTime = new Date(obj.date2);
                        var endTimeFull = endTime.getDate() + '-' + (endTime.getMonth() + 1) +
                            '-' + endTime.getFullYear();
                        var startTimeFull = startTime.getDate() + '-' + (startTime.getMonth() +
                            1) + '-' + startTime.getFullYear();
                        var dateDiff = datediff(startTime.getTime(), endTime.getTime()) + 1;
                        $('.total-price').html((response.price.price * dateDiff) + " ₺")
                        changeData(startTimeFull, "doping_start_date")
                        changeData(endTimeFull, "doping_end_date")
                        changeData(dateDiff, "doping_date_count")
                    })

                }
            })
        })

        var csrfToken = "{{ csrf_token() }}";
        $('.finish-step-3').click(function() {
            $.ajax({
                method: "POST",
                url: "{{ route('institutional.project.end.temp.order') }}",
                data: {
                    _token: csrfToken,
                    without_doping: 0
                },
                success: function(response) {
                    response = JSON.parse(response);

                    if (response.status) {
                        $('.third-area').addClass('d-none');
                        $('.fourth-area').removeClass('d-none')
                    }
                }
            })
        })

        $('.without-doping').click(function() {
            $.ajax({
                method: "POST",
                url: "{{ route('institutional.project.end.temp.order') }}",
                data: {
                    _token: csrfToken,
                    without_doping: 1
                },
                success: function(response) {
                    response = JSON.parse(response);

                    if (response.status) {
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

        var houseCount = {{ isset($tempData->room_count) ? $tempData->room_count : 0 }};
        if (!isNaN(houseCount) && houseCount > 0) {
            var houseType = {{ isset($tempData->housing_type_id) ? $tempData->housing_type_id : 0 }};
            if (houseType != 0) {
                @if (isset($tempData->housing_type_id))
                    @php
                        $housingType = DB::table('housing_types')
                            ->where('id', $tempData->housing_type_id)
                            ->first();
                    @endphp
                    var housingTypeData = @json($housingType);
                    @if (isset($tempData->roomInfoKeys))
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
                        for (var i = 0; i < houseCount; i++) {
                            html +=
                                '<div class="item-left-area"><p class="nav-linkx border-end border-end-sm-0 border-bottom-sm border-300 text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center ' +
                                (i == 0 ? 'active' : '') + '" id="Tab' + (i + 1) +
                                '"  aria-controls="TabContent' + (i + 1) + '" aria-selected="true">' +
                                '<span class="me-sm-2 fs-4 nav-icons" data-feather="tag"></span>' +
                                '<span class="d-block d-sm-inline">' + (i + 1) +
                                ' Nolu Konut Bilgileri</span>' +
                                '<span class="d-block d-sm-inline">Kopyala (Aynı Olan Dairelere Otomatik Giriş) ' +
                                getCopyList(houseCount, i + 1) + '</span>' +
                                '</p></div>';

                            htmlContent += '<div class="tab-pane fade show ' + (i == 0 ? 'active' : '') +
                                '" id="TabContent' + (i + 1) + '" role="tabpanel">' +
                                '<div id="renderForm' + (i + 1) + '"></div>' +
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
                            renderHtml = renderHtml[0];
                            var json = JSON.parse(response.form_json);
                            for (var lm = 0; lm < json.length; lm++) {
                                if (json[lm].type == "checkbox-group") {
                                    var json = JSON.parse(response.form_json);
                                    var renderHtml = renderHtml.toString().split(json[lm].name + '-');
                                    renderHtmlx = "";
                                    for (var t = 0; t < renderHtml.length; t++) {
                                        if (t != renderHtml.length - 1) {
                                            renderHtmlx += renderHtml[t] + (json[lm].name.split('[]')[0]) + i +
                                                '[]-' + i;
                                        } else {
                                            renderHtmlx += renderHtml[t];
                                        }
                                    }

                                    renderHtml = renderHtmlx;
                                    var renderHtml = renderHtml.toString().split(json[lm].name + '[]');
                                    renderHtmlx = "";
                                    var json = JSON.parse(response.form_json);
                                    for (var t = 0; t < renderHtml.length; t++) {
                                        if (t != renderHtml.length - 1) {
                                            renderHtmlx += renderHtml[t] + (json[lm].name.split('[]')[0]) + i +
                                                '[][]';
                                        } else {
                                            renderHtmlx += renderHtml[t];
                                        }
                                    }


                                    renderHtml = renderHtmlx;


                                }
                            }
                            $('#renderForm' + (i)).html(renderHtmlx);

                            if (i > 1 && i != $('.tab-pane').length) {
                                $('.rendered-form').eq(i - 1).append(
                                    '<div class="housing_buttons"><button class="prev_house btn btn-primary">Önceki Ev</button><button class="next_house btn btn-primary">Sonraki Konut</button></div>'
                                )
                            } else if (i == $('.tab-pane').length) {
                                $('.rendered-form').eq(i - 1).append(
                                    '<div class="housing_buttons"><button class="prev_house btn btn-primary">Önceki Ev</button></div>'
                                )
                            } else {
                                $('.rendered-form').eq(i - 1).append(
                                    '<div class="housing_buttons"><button class="next_house btn btn-primary">Sonraki Konut</button></div>'
                                )
                            }


                        }

                        $('.next_house').click(function() {
                            var nextHousing = true;
                            $('.tab-pane.active input[required="required"]').map((key, item) => {
                                if (!$(item).val() && $(item).attr('type') != "file") {
                                    nextHousing = false;
                                    $(item).addClass("error-border")
                                }
                            })
                            $('.tab-pane.active select[required="required"]').map((key, item) => {
                                if (!$(item).val() || $(item).val() == "Seçiniz") {
                                    nextHousing = false;
                                    $(item).addClass("error-border")
                                }
                            })


                            $('.tab-pane.active input[type="file"]').map((key, item) => {
                                if ($(item).parent('div').find('.project_imaget').length == 0) {
                                    nextHousing = false;
                                    $(item).addClass("error-border")
                                }
                            })

                            var indexItem = $('.tab-pane.active').index();
                            if (nextHousing) {
                                $('html, body').animate({
                                    scrollTop: $('.tab-pane.active').offset().top - parseFloat(
                                        $('.navbar-top').css('height'))
                                }, 100);
                                $('.tab-pane.active').removeClass('active');
                                $('.tab-pane').eq(indexItem + 1).addClass('active');
                                $('.item-left-area p').removeClass('active');
                                $('.item-left-area').eq(indexItem + 1).find('p').addClass('active');
                            } else {
                                $('html, body').animate({
                                    scrollTop: $('.tab-pane.active').offset().top - parseFloat(
                                        $('.navbar-top').css('height'))
                                }, 100);
                            }
                        })


                        $('.prev_house').click(function() {

                            var indexItem = $('.tab-pane.active').index();
                            $('.tab-pane.active').removeClass('active');
                            $('.tab-pane').eq(indexItem - 1).addClass('active');
                        })

                        function getOldData(roomOrder, inputName) {
                            for (var q = 0; q < oldData.length; q++) {
                                if (oldData[q].room_order == roomOrder && oldData[q].name == inputName) {
                                    return oldData[q].value;
                                }
                            }
                        }
                        for (let i = 1; i <= houseCount; i++) {
                            for (var j = 0; j < formInputs.length; j++) {
                                if (formInputs[j].type == "number" || formInputs[j].type == "text") {
                                    var inputName = formInputs[j].name;
                                    var inputNamex = inputName;
                                    inputNamex = inputNamex.split('[]')
                                    if (getOldData(i, inputName) != undefined) {
                                        $($('input[name="' + formInputs[j].name + '"]')[i - 1]).val(getOldData(
                                            i, inputName));
                                    }
                                } else if (formInputs[j].type == "select") {
                                    var inputName = formInputs[j].name;
                                    var inputNamex = inputName;
                                    inputNamex = inputNamex.split('[]')
                                    $($('select[name="' + formInputs[j].name + '"]')[i - 1]).children('option')
                                        .map((key, item) => {
                                            console.log(getOldData(i, inputName));
                                            if (getOldData(i, inputName) != undefined) {
                                                if ($(item).attr("value") == getOldData(i, inputName)) {
                                                    $(item).attr('selected', 'selected')
                                                } else {
                                                    $(item).removeAttr('selected')
                                                }
                                            } else {
                                                $(item).removeAttr('selected')
                                            }

                                        });
                                } else if (formInputs[j].type == 'checkbox-group') {
                                    var inputName = formInputs[j].name;
                                    var inputNamex = inputName;
                                    inputNamex = inputNamex.split('[]')
                                    var checkboxName = inputName;
                                    checkboxName = checkboxName.split('[]');
                                    checkboxName = checkboxName[0];
                                    $($('input[name="' + inputNamex[0] + [i] + '[][]"]')).map((key, item) => {
                                        console.log(getOldData(i, inputName), inputName)
                                        if (getOldData(i, inputName)) {
                                            JSON.parse(getOldData(i, inputName)).map((checkbox) => {

                                                if ($(item).attr("value").trim() ==
                                                    "taksitli") {
                                                    if ($(item).attr("value") != undefined &&
                                                        checkbox.trim() == $(item).attr("value")
                                                        .trim()) {
                                                        $(item).closest('.tab-pane').find(
                                                            'second-payment-plan').closest(
                                                            'div').removeClass('d-none')
                                                        $(item).attr('checked', 'checked')
                                                    } else {
                                                        $(item).closest('.tab-pane').find(
                                                            'second-payment-plan').closest(
                                                            'div').addClass('d-none')
                                                    }
                                                } else {
                                                    if ($(item).attr("value") != undefined &&
                                                        checkbox.trim() == $(item).attr("value")
                                                        .trim()) {
                                                        $(item).attr('checked', 'checked')
                                                    }
                                                }
                                            })
                                        }
                                    });
                                } else if (formInputs[j].type == 'file') {
                                    var inputName = formInputs[j].name;
                                    var inputNamex = inputName;
                                    inputNamex = inputNamex.split('[]')
                                    if (getOldData(i, inputName) != undefined) {
                                        $($('input[name="' + formInputs[j].name + '"]')[i - 1]).parent('div')
                                            .append(
                                                '<div class="project_imaget"><img src="{{ URL::to('/') }}/project_housing_images/' +
                                                getOldData(i, inputName) + '"></div>');
                                    }
                                }

                            }
                        }
                        console.log($('.dropzonearea'))
                        $('.dropzonearea').closest('.formbuilder-file').remove();
                        for (let i = 1; i <= houseCount; i++) {
                            var images = '';
                            if (oldData.images) {
                                housingImages = JSON.parse(oldData.images[i - 1]);
                            } else {
                                housingImages = [];
                            }
                            for (let j = 0; j < housingImages.length; j++) {
                                images +=
                                    '<div class="project_images_area"><img class="edit_project_housing_image" src="{{ URL::to('/') . '/project_images/' }}' +
                                    housingImages[j] + '"> <span order="' + j + '" housing_order="' + i +
                                    '" class="btn btn-danger remove_housing_image">Sil</span>  </div>';
                            }
                            $('.dropzone2').eq(i - 1).parent('div').append(
                                '<div class="d-none"><input housing_order="' + i +
                                '" type="file" class="new_file_on_drop"></div>')
                            $('.dropzone2').eq(i - 1).html(images);
                        }

                        

                        var csrfToken = "{{ csrf_token() }}";

                        $('.add-new-project-house-image').click(function() {
                            $(this).parent('div').find('.new_file_on_drop').trigger("click")
                        })

                        $('.new_project_housing_image').click(function() {
                            
                        })

                        $('.item-left-area').click(function(e) {
                            var clickIndex = $(this).index();
                            var currentIndex = $('.nav-linkx.active').closest('.item-left-area')
                                .index();

                            if (clickIndex > currentIndex) {
                                var nextHousing = true;
                                $('.tab-pane.active input[required="required"]').map((key, item) => {
                                    if (!$(item).val()) {
                                        nextHousing = false;
                                        $(item).addClass("error-border")
                                    }
                                })

                                $('.tab-pane.active select[required="required"]').map((key, item) => {
                                    if (!$(item).val()) {
                                        nextHousing = false;
                                        $(item).addClass("error-border")
                                    }
                                })
                                if ($('.tab-pane.active input[required="required"]').val() == "") {
                                    nextHousing = false;
                                    $('.tab-pane.active input[name="price[]"]').addClass('error-border')
                                }

                                $('.tab-pane.active input[type="file"]').map((key, item) => {
                                    if ($(item).parent('div').find('.project_imaget').length ==
                                        0) {
                                        nextHousing = false;
                                        $(item).addClass("error-border")
                                    }
                                })

                                var indexItem = $('.tab-pane.active').index();
                                if (nextHousing) {
                                    $('.tab-pane.active').removeClass('active');
                                    $('.tab-pane').eq(indexItem + 1).addClass('active');
                                    $('.item-left-area p').removeClass('active')
                                    $(this).children('p').addClass('active');
                                } else {
                                    $('html, body').animate({
                                        scrollTop: $('.tab-pane.active').offset().top -
                                            parseFloat($('.navbar-top').css('height'))
                                    }, 100);
                                }



                            } else {

                                $('.item-left-area p').removeClass('active')
                                $(this).children('p').addClass('active');
                                $('.tab-pane.active').removeClass('active');
                                $('.tab-pane').eq(clickIndex).addClass('active');
                            }

                        })

                        $('.tab-pane select[multiple="false"]').removeAttr('multiple')
                        $('input[value="taksitli"]').change(function() {
                            if ($(this).is(':checked')) {
                                $('.second-payment-plan').closest('div').removeClass('d-none');
                            } else {
                                $('.second-payment-plan').closest('div').addClass('d-none');
                            }
                        })

                        $('.copy-item').change(function() {
                            var transactionIndex = 0;
                            $('.tab-pane').prepend(
                                '<div class="loading-icon-right"><i class="fa fa-spinner"></i></div>'
                            );
                            var order = parseInt($(this).val()) - 1;
                            var currentOrder = parseInt($(this).closest('.item-left-area').index());
                            var arrayValues = {};
                            for (var lm = 0; lm < json.length; lm++) {
                                if (json[lm].type == "checkbox-group") {
                                    arrayValues[json[lm].name.replace("[]", "").replace("[]", "") + (
                                        currentOrder + 1)] = [];
                                    for (var i = 0; i < json[lm].values.length; i++) {
                                        var isChecked = $('input[name="' + (json[lm].name.replace('[]',
                                                '')) + (order + 1) + '[][]"][value="' + json[lm]
                                            .values[i].value + '"]' + '').is(':checked')
                                        if (isChecked) {
                                            $('input[name="' + (json[lm].name.replace('[]', '')) + (
                                                    currentOrder + 1) + '[][]"][value="' + json[lm]
                                                .values[i].value + '"]' + '').prop('checked', true)

                                            arrayValues[json[lm].name.replace("[]", "").replace("[]",
                                                "") + (currentOrder + 1)].push(json[lm].values[i]
                                                .value)
                                        } else {
                                            transactionIndex++;
                                            $('input[name="' + (json[lm].name.replace('[]', '')) + (
                                                    currentOrder + 1) + '[][]"][value="' + json[lm]
                                                .values[i].value + '"]' + '').prop('checked', false)
                                        }
                                    }
                                    var formData = new FormData();
                                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                                    formData.append('_token', csrfToken);
                                    formData.append('value', JSON.stringify(arrayValues));
                                    formData.append('order', currentOrder);
                                    formData.append('key', json[lm].name.replace("[]", "").replace("[]",
                                        "") + (currentOrder + 1));
                                    formData.append('item_type', 3);
                                    formData.append('checkbox', "1");
                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('institutional.temp.order.copy.checkbox') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                            if (transactionIndex + 1 == json.length) {
                                                $('.loading-icon-right').remove();
                                            }

                                            transactionIndex++;
                                        },
                                    });
                                } else if (json[lm].type == "select") {
                                    var value = $('select[name="' + (json[lm].name) + '"]').eq(order)
                                        .val();
                                    $('select[name="' + (json[lm].name) + '"]').eq(currentOrder)
                                        .children('option').removeAttr('selected')
                                    $('select[name="' + (json[lm].name) + '"]').eq(currentOrder)
                                        .children('option[value="' + value + '"]').prop('selected',
                                            true);
                                    var formData = new FormData();
                                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                                    formData.append('_token', csrfToken);
                                    formData.append('value', value);
                                    formData.append('order', currentOrder);
                                    formData.append('key', json[lm].name.replace("[]", "").replace("[]",
                                        ""));
                                    formData.append('item_type', 3);
                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('institutional.temp.order.project.housing.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                            if (transactionIndex + 1 == json.length) {
                                                $('.loading-icon-right').remove();
                                            }
                                            transactionIndex++;
                                        },
                                    });

                                    confirmHousings();
                                } else if (json[lm].type == "file" && json[lm].name == "image[]") {

                                    var formData = new FormData();
                                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                                    formData.append('_token', csrfToken);
                                    formData.append('lastorder', order);
                                    formData.append('order', currentOrder);
                                    formData.append('item_type', 3);
                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('institutional.copy.item.image') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                            if (transactionIndex + 1 == json.length) {
                                                $('.loading-icon-right').remove();
                                            }
                                            transactionIndex++;
                                        },
                                    });
                                    var cloneImage = $('.tab-pane').eq(order).find('.project_imaget')
                                        .clone();
                                    $('.tab-pane.active').find('.cover-image-by-housing-type').parent(
                                        'div').find('.project_imaget').remove();
                                    $('.tab-pane.active').find('.cover-image-by-housing-type').parent(
                                        'div').append(cloneImage)
                                } else if (json[lm].type != "file") {
                                    if (json[lm].name) {
                                        var value = $('input[name="' + (json[lm].name) + '"]').eq(order)
                                            .val();
                                        var formData = new FormData();
                                        var csrfToken = $("meta[name='csrf-token']").attr("content");
                                        formData.append('_token', csrfToken);
                                        formData.append('value', value);
                                        formData.append('order', currentOrder);
                                        formData.append('key', json[lm].name.replace("[]", "").replace(
                                            "[]", ""));
                                        formData.append('item_type', 3);
                                        $.ajax({
                                            type: "POST",
                                            url: "{{ route('institutional.temp.order.project.housing.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                            data: formData,
                                            processData: false,
                                            contentType: false,
                                            success: function(response) {
                                                if (transactionIndex + 1 == json.length) {
                                                    $('.loading-icon-right').remove();
                                                }
                                                transactionIndex++;
                                            },
                                        });

                                        confirmHousings();
                                        $('input[name="' + (json[lm].name) + '"]').eq(currentOrder).val(
                                            value);
                                    }

                                }
                            }
                            console.log(transactionIndex);
                        })

                        $('.rendered-form input').change(function() {
                            if ($(this).attr('type') != "file") {
                                var formData = new FormData();
                                var csrfToken = $("meta[name='csrf-token']").attr("content");
                                formData.append('_token', csrfToken);
                                formData.append('value', $(this).val());
                                formData.append('order', parseInt($(this).closest('.tab-pane').attr(
                                    'id').replace('TabContent', "")) - 1);
                                formData.append('key', $(this).attr('name').replace("[]", "").replace(
                                    "[]", ""));
                                formData.append('item_type', 3);
                                if ($(this).attr('type') == "checkbox") {
                                    formData.append('checkbox', "1");
                                }
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('institutional.temp.order.project.housing.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {},
                                });

                                confirmHousings();
                            }
                        })

                        $('.rendered-form select').change(function() {
                            if ($(this).val()) {
                                $(this).removeClass('error-border')
                            }
                            var formData = new FormData();
                            var csrfToken = $("meta[name='csrf-token']").attr("content");
                            formData.append('_token', csrfToken);
                            formData.append('value', $(this).val());
                            console.log($(this).closest('.tab-pane').attr('id'))
                            formData.append('order', parseInt($(this).closest('.tab-pane').attr('id')
                                .replace('TabContent', "")) - 1);
                            formData.append('key', $(this).attr('name').replace("[]", ""));
                            formData.append('item_type', 3);
                            $.ajax({
                                type: "POST",
                                url: "{{ route('institutional.temp.order.project.housing.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {},
                            });

                            confirmHousings();
                        })

                        $('.number-only').keyup(function() {
                            $('.number-only .error-text').remove();
                            if ($(this).val() != parseInt($(this).val())) {
                                if ($(this).closest('.form-group').find('.error-text').length > 0) {
                                    $(this).val("");
                                } else {
                                    $(this).closest('.form-group').append(
                                        '<span class="error-text">Girilen değer sadece sayı olmalıdır</span>'
                                    )
                                    $(this).val("");
                                }

                            } else {
                                $(this).closest('.form-group').find('.error-text').remove();
                            }
                        })

                        $('.formbuilder-text input').change(function() {
                            if ($(this).val() != "") {
                                $(this).removeClass('error-border')
                            }
                        })

                        $('.formbuilder-number input').change(function() {
                            if ($(this).val() != "") {
                                $(this).removeClass('error-border')
                            }
                        })


                        $('.cover-image-by-housing-type').change(function() {
                            var input = this;
                            if (input.files && input.files[0]) {
                                $(this).removeClass('error-border');

                                confirmHousings();
                                var reader = new FileReader();

                                var formData = new FormData();
                                var csrfToken = $("meta[name='csrf-token']").attr("content");
                                formData.append('_token', csrfToken);
                                formData.append('file', this.files[0]);
                                formData.append('order', $(this).closest('.tab-pane').index());
                                formData.append('item_type', 3);
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('institutional.temp.order.project.add.image') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {},
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
                                    $('.tab-pane.active .cover-image-by-housing-type').closest(
                                            '.formbuilder-file').find('.project_imaget').eq(0)
                                        .remove()
                                    $('.tab-pane.active .cover-image-by-housing-type').closest(
                                        '.formbuilder-file').append(imageDiv)
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

        function changeData(value, key, isArray = 0) {
            var formData = new FormData();
            var csrfToken = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', csrfToken);
            formData.append('value', value);
            formData.append('key', key);
            formData.append('item_type', 3);
            formData.append('array_data', isArray);
            $.ajax({
                type: "POST",
                url: "{{ route('institutional.temp.order.data.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (key == 'pricing-type') {
                        if (value == 2) {
                            $('.single-price-project-area').removeClass('d-none')
                            $('.pricing-select-first').addClass('d-none')
                        } else {
                            $('.single-price-project-area').addClass('d-none')
                        }
                    }
                },
            });
        }

        $('.redirect-back-pricing').click(function() {
            $('.single-price-project-area').addClass('d-none')
            $('.pricing-select-first').removeClass('d-none')
        })

        $('.photo-area').click(function() {
            $('.project_image.d-none').trigger('click');
        })

        $('.cover-photo-area').click(function() {
            $('.cover_image.d-none').trigger('click');
        })

        $('.cover-document-area').click(function() {
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
                formData.append('document', this.files[0]);
                formData.append('item_type', 3);
                $.ajax({
                    type: "POST",
                    url: "{{ route('institutional.temp.order.document.add') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        response = JSON.parse(response);

                        if (response.status) {
                            var html = '<div class="has_file">' +
                                '<span class="d-block">Dosya Eklediniz</span>' +
                                '<a class="btn btn-info" href="{{ URL::to('/') }}/housing_documents/' +
                                response.document_name + '" download="">Mevcut Dosyayı İndir</a>' +
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
                formData.append('image', this.files[0]);
                formData.append('item_type', 3);
                $.ajax({
                    type: "POST",
                    url: "{{ route('institutional.temp.order.single.file.add') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
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
                for (let i = 0; i < this.files.length; i++) {
                    formData.append(`file${i}`, this.files[i]);
                }
                formData.append('item_type', 3);
                $.ajax({
                    type: "POST",
                    url: "{{ route('institutional.temp.order.image.add') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Dosya yükleme başarılı ise sunucudan gelen yanıtı görüntüle
                        for (let i = 0; i < response.length; i++) {
                            var imageDiv = $('<div class="project_imagex" order="'+response[i]+'"></div>');
                            var image = $('<img>').attr('src', '{{URL::to('/')}}/storage/project_images/'+response[i]);
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

                        // Resmi okuyun
                        reader.readAsDataURL(input.files[0]);
                    },
                    error: function() {
                        // Hata durumunda kullanıcıya bir mesaj gösterebilirsiniz
                        alert("Dosya yüklenemedi.");
                    }
                });

            }
        });

        $('.finish-tick').click(function() {
            console.log($(this).find('input').is(':checked'));
            if ($(this).find('input').is(':checked')) {
                $(this).find('input').prop('checked', false)
            } else {
                $('.finish-tick').removeClass('error-border')
                $(this).find('input').prop('checked', true)
            }
        })

        $('.rules_confirm').click(function(e){
            e.stopPropagation();
        })

        $('.pricing-item').click(function() {
            $('.pricing-item').find('input').removeAttr('checked');
            $('.pricing-item').find('.price-radio').removeClass('select');
            $(this).find('input').attr('checked', 'checked');
            $(this).find('.price-radio').addClass('select')
            $('.single-price-project-area .error-text').remove()
        })

        $('.pricing-item-first').click(function() {
            $('.pricing-item-first').find('input').removeAttr('checked');
            $('.pricing-item-first').find('.price-radio').removeClass('select');
            $(this).find('input').attr('checked', 'checked');
            $(this).find('.price-radio').addClass('select')
            $('.pricing-select-first .error-text').remove();
        })

        $('.photo-area').click(function() {

        })

        function getCopyList(housingCount, currentItemKey) {
            var html = '<select class="copy-item"><option value="">Daire bilgilerini kopyala</option>'
            for (var i = 1; i <= housingCount; i++) {
                if (i != currentItemKey) {
                    html += '<option value="' + i + '">Daire ' + i + '</option>'
                }
            }

            html += '</select>'

            return html;
        }

        jQuery($ => {
            var houseCount = {{ old('house_count') ? old('house_count') : 0 }};
            if (!isNaN(houseCount) && houseCount > 0) {
                var houseType = {{ old('housing_type') ? old('housing_type') : 0 }};
                if (houseType != 0) {
                    @php
                        $housingType = DB::table('housing_types')
                            ->where('id', old('housing_type'))
                            ->first();
                    @endphp
                    var housingTypeData = @json($housingType);
                    var oldData = @json(old());
                    console.log(oldData);
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
                            for (var i = 0; i < houseCount; i++) {
                                html +=
                                    '<a class="nav-link border-end border-end-sm-0 border-bottom-sm border-300 text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center ' +
                                    (i == 0 ? 'active' : '') + '" id="Tab' + (i + 1) +
                                    '" data-bs-toggle="tab" data-bs-target="#TabContent' + (i + 1) +
                                    '" role="tab" aria-controls="TabContent' + (i + 1) +
                                    '" aria-selected="true">' +
                                    '<span class="me-sm-2 fs-4 nav-icons" data-feather="tag"></span>' +
                                    '<span class="d-none d-sm-inline">' + (i + 1) +
                                    ' Nolu Konut Bilgileri</span>' +
                                    '</a>';

                                htmlContent += '<div class="tab-pane fade show ' + (i == 0 ? 'active' :
                                        '') + '" id="TabContent' + (i + 1) + '" role="tabpanel">' +
                                    '<div id="renderForm' + (i + 1) + '"></div>' +
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
                                renderHtml = renderHtml[0] + 'images' + i + '[][]' + renderHtml[1];
                                var json = JSON.parse(response.form_json);
                                for (var lm = 0; lm < json.length; lm++) {
                                    if (json[lm].type == "checkbox-group") {
                                        var renderHtml = renderHtml.toString().split(json[lm].name +
                                            '[]');
                                        renderHtmlx = "";
                                        var json = JSON.parse(response.form_json);
                                        for (var t = 0; t < renderHtml.length; t++) {
                                            if (t != renderHtml.length - 1) {
                                                renderHtmlx += renderHtml[t] + (json[lm].name.split(
                                                    '[]')[0]) + i + '[][]';
                                            } else {
                                                renderHtmlx += renderHtml[t];
                                            }
                                        }

                                        renderHtml = renderHtmlx;
                                    }
                                }
                                $('#renderForm' + (i)).html(renderHtmlx);

                            }
                            for (let i = 1; i <= houseCount; i++) {
                                for (var j = 2; j < formInputs.length; j++) {
                                    if (formInputs[j].type == "number" || formInputs[j].type ==
                                        "text") {
                                        var inputName = formInputs[j].name;
                                        var inputNamex = inputName;
                                        inputNamex = inputNamex.split('[]')
                                        console.log(inputNamex);
                                        $($('input[name="' + formInputs[j].name + '"]')[i - 1]).val(
                                            oldData[inputNamex[0]][i - 1]);
                                    } else if (formInputs[j].type == "select") {
                                        var inputName = formInputs[j].name;
                                        var inputNamex = inputName;
                                        inputNamex = inputNamex.split('[]')
                                        $($('select[name="' + formInputs[j].name + '"]')[i - 1])
                                            .children('option').map((key, item) => {
                                                if ($(item).attr("value") == oldData[inputNamex[0]][
                                                        i - 1
                                                    ]) {
                                                    $(item).attr('selected', 'selected')
                                                } else {
                                                    $(item).removeAttr('selected')
                                                }
                                            });
                                    } else if (formInputs[j].type == 'checkbox-group') {
                                        var inputName = formInputs[j].name;
                                        var inputNamex = inputName;
                                        inputNamex = inputNamex.split('[][]')
                                        var checkboxName = inputName;
                                        checkboxName = checkboxName.split('[]');
                                        checkboxName = checkboxName[0];
                                        $($('input[name="' + checkboxName + [i] + '[][]"]')).map((key,
                                            item) => {
                                            console.log(oldData[(checkboxName + i)], $(item)
                                                .attr("value"))
                                            oldData[(checkboxName + i)].map((checkbox) => {
                                                if (checkbox[0] == $(item).attr(
                                                        "value")) {
                                                    $(item).attr('checked', 'checked')
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

        @if (isset($tempData->city_id))
            var selectedCity = {{ $tempData->city_id }}; // Seçilen şehir değerini al

            // AJAX isteği yap
            $.ajax({
                url: '{{ route('institutional.get.counties') }}', // Endpoint URL'si (get.counties olarak varsayalım)
                method: 'GET',
                data: {
                    city: selectedCity
                }, // Şehir verisini isteğe ekle
                dataType: 'json', // Yanıtın JSON formatında olduğunu belirt
                success: function(response) {
                    // Yanıt başarılı olduğunda çalışacak kod
                    var countiesSelect = $('#counties'); // counties id'li select'i seç
                    countiesSelect.empty(); // Select içeriğini temizle
                    var countyId =
                        @if (isset($tempData->county_id))
                            {{ $tempData->county_id }}
                        @else
                            null
                        @endif
                    // Dönen yanıttaki ilçeleri döngüyle ekleyin
                    for (var i = 0; i < response.length; i++) {
                        countiesSelect.append($('<option>', {
                            value: response[i].ilce_key, // İlçe ID'si
                            text: response[i].ilce_title, // İlçe adı
                            key_x: response[i].key_x,
                            selected: (response[i].ilce_key == countyId ? true : false)
                        }));
                    }

                    @if (isset($tempData->county_id))
                        var selectedCounty = {{ $tempData->county_id }}; // Seçilen şehir değerini al
                        var selectedCountyKey = $('#counties option[value="' + selectedCounty + '"]').attr(
                            "key_x");
                        // AJAX isteği yap

                        $.ajax({
                            url: '{{ route('institutional.get.neighbourhood') }}', // Endpoint URL'si (get.counties olarak varsayalım)
                            method: 'GET',
                            data: {
                                county_id: selectedCounty
                            }, // Şehir verisini isteğe ekle
                            dataType: 'json', // Yanıtın JSON formatında olduğunu belirt
                            success: function(response) {
                                // Yanıt başarılı olduğunda çalışacak kod
                                var countiesSelect = $(
                                    '#neighbourhood'); // counties id'li select'i seç
                                countiesSelect.empty(); // Select içeriğini temizle
                                var countyId =
                                    @if (isset($tempData->neighbourhood_id))
                                        {{ $tempData->neighbourhood_id }}
                                    @else
                                        null
                                    @endif

                                for (var i = 0; i < response.length; i++) {
                                    countiesSelect.append($('<option>', {
                                        value: response[i].mahalle_id, // İlçe ID'si
                                        text: response[i].mahalle_title, // İlçe adı
                                        selected: (response[i].mahalle_id == countyId ?
                                            true : false)
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

        $('#cities').change(function() {
            var selectedCity = $(this).val(); // Seçilen şehir değerini al

            // AJAX isteği yap
            $.ajax({
                url: '{{ route('institutional.get.counties') }}', // Endpoint URL'si (get.counties olarak varsayalım)
                method: 'GET',
                data: {
                    city: selectedCity
                }, // Şehir verisini isteğe ekle
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

        $('#counties').change(function() {
            var selectedCounty = $(this).val(); // Seçilen şehir değerini al
            var selectedCountyKey = $('#counties option[value="' + selectedCounty + '"]').attr("key_x");
            console.log($('#counties option[value="' + selectedCounty + '"]'));
            // AJAX isteği yap
            $.ajax({
                url: '{{ route('institutional.get.neighbourhood') }}', // Endpoint URL'si (get.counties olarak varsayalım)
                method: 'GET',
                data: {
                    county_id: selectedCounty
                }, // Şehir verisini isteğe ekle
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
        $('#editor').richText({
            saveOnBlur : 1,
            saveCallback: function (editor, source, content) {
                console.log("Editör içeriği değişti.");
                const editorContent = content;
                if (editorContent != "") {
                    descriptionText = "evet var";

                }
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                    "content");


                // Verileri FormData nesnesine ekleyin
                const formData = new FormData();
                formData.append('_token', csrfToken);
                formData.append('value', editorContent);
                formData.append('key', "description");
                formData.append('item_type', 3);

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



        $('.finish-button').click(function(e) {
            e.preventDefault();
            
            var next = true;
            var topError = 0;
            if (!$('input[name="name"]').val()) {
                next = false;
                console.log("deneme")
                $('input[name="name"]').addClass('error-border')
                topError = $('input[name="name"]').offset().top - parseFloat($('.navbar-top').css('height')) - 100;
            }


            if (!$('#location').val()) {
                next = false;
                if (topError) {
                    if ($('#location').parent('div').offset().top - parseFloat($('.navbar-top').css('height')) -
                        100 < topError) {
                        topError = $('#location').parent('div').offset().top - parseFloat($('.navbar-top').css(
                            'height')) - 100;
                    }
                } else {
                    topError = $('#location').parent('div').offset().top - parseFloat($('.navbar-top').css(
                        'height')) - 100;
                }
                $('#location').parent('div').find('.error-text').remove();
                $('#location').parent('div').append(
                    '<span class="error-text">Haritadan konum seçmek zorunludur</span>')
            }

            if (!$('.rules_confirm').is(':checked')) {
                next = false;

                if (topError) {
                    if ($('.finish-tick').offset().top - parseFloat($('.navbar-top').css('height')) - 100 <
                        topError) {
                        topError = $('.finish-tick').offset().top - parseFloat($('.navbar-top').css('height')) -
                            100;
                    }
                } else {
                    topError = $('.finish-tick').offset().top - parseFloat($('.navbar-top').css('height')) - 100;
                }
                $('.finish-tick').addClass('error-border')
            }

            if (descriptionText == "") {
                next = false;
                if (topError) {
                    if ($('.description-field').offset().top - parseFloat($('.navbar-top').css('height')) - 100 <
                        topError) {
                        topError = $('.description-field').offset().top - parseFloat($('.navbar-top').css(
                            'height')) - 100;
                    }
                } else {
                    topError = $('.description-field').offset().top - parseFloat($('.navbar-top').css('height')) -
                        100;
                }
                $('.description-field .error-text').remove();
                $('.description-field').append('<span class="error-text">Açıklama metnini girmek zorunludur</span>')
            }

            $('.tab-pane.active input[required="required"]').map((key, item) => {
                if (!$(item).val() && $(item).attr('type') != 'file') {
                    next = false;

                    if (topError) {
                        if ($(item).offset().top - parseFloat($('.navbar-top').css('height')) - 100 <
                            topError) {
                            topError = $(item).offset().top - parseFloat($('.navbar-top').css('height')) -
                                100;
                        }
                    } else {
                        topError = $(item).offset().top - parseFloat($('.navbar-top').css('height')) - 100;
                    }
                    $(item).addClass("error-border")
                }
            })

            $('.tab-pane.active input[type="file"]').map((key, item) => {
                if ($(item).parent('div').find('.project_imaget').length == 0) {
                    next = false;

                    if (topError) {
                        if ($(item).offset().top - parseFloat($('.navbar-top').css('height')) - 100 <
                            topError) {
                            topError = $(item).offset().top - parseFloat($('.navbar-top').css('height')) -
                                100;
                        }
                    } else {
                        topError = $(item).offset().top - parseFloat($('.navbar-top').css('height')) - 100;
                    }
                    $(item).addClass("error-border")
                }
            })

            $('.tab-pane.active select[required="required"]').map((key, item) => {
                if (!$(item).val() || $(item).val() == "Seçiniz") {
                    next = false;
                    if (topError) {
                        if ($(item).offset().top - parseFloat($('.navbar-top').css('height')) - 100 <
                            topError) {
                            topError = $(item).offset().top - parseFloat($('.navbar-top').css('height')) -
                                100;
                        }
                    } else {
                        topError = $(item).offset().top - parseFloat($('.navbar-top').css('height')) - 100;
                    }
                    $(item).addClass("error-border")
                }
            })



            if ($('.photos .project_imagex').length == 0) {
                next = false;
                if (topError) {
                    if ($('.photo-area').offset().top - parseFloat($('.navbar-top').css('height')) - 100 <
                        topError) {
                        topError = $('.photo-area').offset().top - parseFloat($('.navbar-top').css('height')) - 100;
                    }
                } else {
                    topError = $('.photo-area').offset().top - parseFloat($('.navbar-top').css('height')) - 100;
                }
                $('.photo-area').addClass('error-border')
            }

            if ($('.cover-photo .project_imagex').length == 0) {
                next = false;
                if (topError) {
                    if ($('.cover-photo').offset().top - parseFloat($('.navbar-top').css('height')) - 100 <
                        topError) {
                        topError = $('.cover-photo').offset().top - parseFloat($('.navbar-top').css('height')) -
                            100;
                    }
                } else {
                    topError = $('.cover-photo').offset().top - parseFloat($('.navbar-top').css('height')) - 100;
                }
                $('.cover-photo-area').addClass('error-border')
            }

            if (!$('select[name="city_id"]').val()) {
                next = false;
                if (topError) {
                    if ($('select[name="city_id"]').offset().top - parseFloat($('.navbar-top').css('height')) -
                        100 < topError) {
                        topError = $('select[name="city_id"]').offset().top - parseFloat($('.navbar-top').css(
                            'height')) - 100;
                    }
                } else {
                    topError = $('select[name="city_id"]').offset().top - parseFloat($('.navbar-top').css(
                        'height')) - 100;
                }
                $('select[name="city_id"]').addClass('error-border')
            }

            if (!$('select[name="county_id"]').val()) {
                next = false;
                if (topError) {
                    if ($('select[name="county_id"]').offset().top - parseFloat($('.navbar-top').css('height')) -
                        100 < topError) {
                        topError = $('select[name="county_id"]').offset().top - parseFloat($('.navbar-top').css(
                            'height')) - 100;
                    }
                } else {
                    topError = $('select[name="county_id"]').offset().top - parseFloat($('.navbar-top').css(
                        'height')) - 100;
                }
                $('select[name="county_id"]').addClass('error-border')
            }

            if (!$('select[name="neighbourhood_id"]').val()) {
                next = false;
                if (topError) {
                    if ($('select[name="neighbourhood_id"]').offset().top - parseFloat($('.navbar-top').css(
                            'height')) - 100 < topError) {
                        topError = $('select[name="neighbourhood_id"]').offset().top - parseFloat($('.navbar-top')
                            .css('height')) - 100;
                    }
                } else {
                    topError = $('select[name="neighbourhood_id"]').offset().top - parseFloat($('.navbar-top').css(
                        'height')) - 100;
                }
                $('select[name="neighbourhood_id"]').addClass('error-border')
            }

            if ($('.pricing-item-first .price-radio.select').length > 0) {
                if ($('.single-price-project-area .pricing-item .price-radio.select').length == 0) {
                    if (topError) {
                        if ($('.single-price-project-area').offset().top - parseFloat($('.navbar-top').css(
                                'height')) - 100 < topError) {
                            topError = $('.single-price-project-area').offset().top - parseFloat($('.navbar-top')
                                .css('height')) - 100;
                        }
                    } else {
                        topError = $('.single-price-project-area').offset().top - parseFloat($('.navbar-top').css(
                            'height')) - 100;
                    }
                    $('.single-price-project-area .error-text').remove();
                    $('.single-price-project-area').append(
                        "<p class='error-text'>İlan süresini seçmeniz gerekmektedir</p>")
                }
            }
            if (next) {
                $('.loading-area').removeClass('d-none');
                nextTemp = true;
                $.ajax({
                    method: "POST",
                    url: "{{ route('institutional.project.update.temp.order') }}",
                    data: {
                        _token: csrfToken,
                        without_doping: 1
                    },
                    success: function(response) {
                        response = JSON.parse(response);

                        if (response.status) {
                            window.location.href =
                                "{{ route('institutional.react.projects') }}"
                        }
                    }
                })
            } else {
                nextTemp = false;
                $('html, body').animate({
                    scrollTop: topError
                }, 100);
            }
        })
        var itemOrder = 0;
        var itemSlug = "";
        var areasSlugs = [];
        @if (isset($tempData->step1_slug))
            itemSlug = "{{ $tempData->step1_slug }}";
            itemOrder = 0;
            listChangex()
        @endif


        @if (isset($tempData->step2_slug))
            itemSlug = "{{ $tempData->step2_slug }}";
            itemOrder = 1;
            listChangex()
        @endif

        @if (isset($tempData->step3_slug))
            itemSlug = "{{ $tempData->step3_slug }}";
            itemOrder = 2;
            listChangex()
        @endif

        function listChangex() {
            $.ajax({
                url: "{{ URL::to('/') }}/institutional/get_housing_type_childrens/" +
                    itemSlug, // AJAX isteği yapılacak URL
                type: "GET", // GET isteği
                dataType: "json", // Gelen veri tipi JSON
                success: function(data) {
                    data = data.data;
                    var list = "";
                    for (var i = 0; i < data.length; i++) {
                        list += "<li slug='" + data[i].slug + "'>" + data[i].title + "</li>"
                    }
                    $('.area-list').eq(itemOrder + 1).children('ul').html(list)

                    $('.area-list li').click(function() {
                        var clickItem = $(this).closest('.area-list');
                        itemOrder = clickItem.index();
                        itemSlug = $(this).attr('slug')
                        listChange();
                    })

                },
                error: function(xhr, status, error) {
                    // İstek hata verdiğinde çalışacak fonksiyon
                    console.error(xhr.statusText);
                }
            });
            if (areasSlugs.filter((slug) => {
                    return slug.order == itemOrder
                }).length == 0) {
                areasSlugs.push({
                    order: itemOrder,
                    slug: itemSlug,
                    label: $("li[slug='" + itemSlug + "']").html()
                });
            } else {
                if (areasSlugs.filter((slug) => {
                        return slug.order == itemOrder
                    })[0].slug != itemSlug) {
                    areasSlugs[itemOrder].slug = itemSlug;
                    var tempItems = [];
                    for (var i = 0; i < areasSlugs.length; i++) {
                        if (areasSlugs[i].order <= itemOrder) {
                            tempItems[i] = areasSlugs[i];
                        }
                    }

                    areasSlugs = tempItems;
                }

            }

            $('.area-list').find('li').removeClass('selected');
            $('.breadcrumb-after-item').remove();
            for (var i = 0; i < areasSlugs.length; i++) {
                $('.area-list').eq(i).addClass('active');
                $('.breadcrumb').append('<span class="breadcrumb-after-item">' + areasSlugs[i].label + '</span>')
                $('.area-list').eq(i).find('li').removeClass('selected');
                $("li[slug='" + areasSlugs[i].slug + "']").addClass('selected');
            }

            for (var i = 0; i < $('.area-list').length; i++) {
                if (i > areasSlugs.length) {
                    $('.area-list').eq(i).removeClass('active');
                } else {
                    $('.area-list').eq(i).addClass('active');
                }
            }
        }

        function listChange() {

            changeData(itemSlug, 'step' + (itemOrder + 1) + '_slug')
            $.ajax({
                url: "{{ URL::to('/') }}/institutional/get_housing_type_childrens/" +
                    itemSlug, // AJAX isteği yapılacak URL
                type: "GET", // GET isteği
                dataType: "json", // Gelen veri tipi JSON
                success: function(data) {
                    data = data.data;
                    var list = "";
                    for (var i = 0; i < data.length; i++) {
                        list += "<li slug='" + data[i].slug + "'>" + data[i].title + "</li>"
                    }
                    $('.area-list').eq(itemOrder + 1).children('ul').html(list)

                    $('.area-list li').click(function() {
                        var clickItem = $(this).closest('.area-list');
                        itemOrder = clickItem.index();
                        itemSlug = $(this).attr('slug')
                        if (itemOrder == 2) {
                            $.ajax({
                                url: "{{ URL::to('/') }}/institutional/get_housing_type_id/" +
                                    itemSlug, // AJAX isteği yapılacak URL
                                type: "GET", // GET isteği
                                dataType: "json", // Gelen veri tipi JSON
                                success: function(data) {
                                    changeData(data, 'housing_type_id');
                                    selectedid = data;
                                }
                            })
                        }
                        listChange();
                    })
                },
                error: function(xhr, status, error) {
                    // İstek hata verdiğinde çalışacak fonksiyon
                    console.error(xhr.statusText);
                }
            });
            if (areasSlugs.filter((slug) => {
                    return slug.order == itemOrder
                }).length == 0) {
                areasSlugs.push({
                    order: itemOrder,
                    slug: itemSlug,
                    label: $("li[slug='" + itemSlug + "']").html()
                });
            } else {
                if (areasSlugs.filter((slug) => {
                        return slug.order == itemOrder
                    })[0].slug != itemSlug) {
                    areasSlugs[itemOrder].slug = itemSlug;
                    var tempItems = [];
                    for (var i = 0; i < areasSlugs.length; i++) {
                        if (areasSlugs[i].order <= itemOrder) {
                            tempItems[i] = areasSlugs[i];
                        }
                    }

                    areasSlugs = tempItems;
                }

            }

            $('.area-list').find('li').removeClass('selected');
            $('.breadcrumb-after-item').remove();
            for (var i = 0; i < areasSlugs.length; i++) {
                $('.area-list').eq(i).addClass('active');
                $('.breadcrumb').append('<span class="breadcrumb-after-item">' + areasSlugs[i].label + '</span>')
                $('.area-list').eq(i).find('li').removeClass('selected');
                $("li[slug='" + areasSlugs[i].slug + "']").addClass('selected');
            }

            for (var i = 0; i < $('.area-list').length; i++) {
                if (i > areasSlugs.length) {
                    $('.area-list').eq(i).removeClass('active');
                } else {
                    $('.area-list').eq(i).addClass('active');
                }
            }
        }

        $('.area-list li').click(function() {
            var clickItem = $(this).closest('.area-list');
            itemOrder = clickItem.index();
            itemSlug = $(this).attr('slug')
            listChange();
        })

        $('.advert_title').keyup(function() {
            if ($(this).val().length > 70) {
                $(this).val($(this).val().substring(0, 70))
            } else {
                changeData($(this).val(), 'project_title')
                $('.max-character').html(($(this).val().length) + '/70');

                if ($(this).val() != "") {
                    $(this).removeClass('error-border');
                }
            }


        })
    </script>
    <script>
        $('#housing_status').change(function() {
            var value = $(this).val();
            var html = "<option value=''>Statü Seç</option>";
            for (var i = 0; i < value.length; i++) {
                html += "<option value='" + value[i] + "'>" + ($('#housing_status option[value="' + value[i] + '"]')
                    .html()) + "</option>";
            }
            $('.doping_statuses').html(html);
            var key = "statuses";
            var isArray = 1;
            var formData = new FormData();
            var csrfToken = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', csrfToken);
            formData.append('value', value);
            formData.append('key', key);
            formData.append('item_type', 3);
            formData.append('array_data', isArray);
            $.ajax({
                type: "POST",
                url: "{{ route('institutional.temp.order.data.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {},
            });
        })

        changeData($('#location').val(), "location")
    </script>
    @stack('scripts')
@endsection

@section('css')
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/assets/css/daterangepicker.css">
    <link rel="stylesheet" href="{{URL::to('/')}}/adminassets/rich-editor/richtext.min.css">
    <style>
        /* Absolute Center Spinner */
.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: visible;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.3);
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 1500ms infinite linear;
  -moz-animation: spinner 1500ms infinite linear;
  -ms-animation: spinner 1500ms infinite linear;
  -o-animation: spinner 1500ms infinite linear;
  animation: spinner 1500ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
  box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
    </style>
@endsection