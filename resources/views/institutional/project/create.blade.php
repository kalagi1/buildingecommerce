@extends('admin.layouts.master')

@section('content')
    
<div class="content">
    
    <form class="mb-9" method="post" action="{{route('institutional.project.store')}}" enctype="multipart/form-data">
        @csrf
      <div class="row g-3 flex-between-end mb-5">
        <div class="col-auto">
          <h2 class="mb-2">Proje Ekle</h2>
          <h5 class="text-700 fw-semi-bold">Aşağıdan proje ekleyebilirsiniz</h5>
        </div>
        <div class="col-auto"><button class="btn btn-phoenix-secondary me-2 mb-2 mb-sm-0" type="button">Discard</button><button class="btn btn-phoenix-primary me-2 mb-2 mb-sm-0" type="button">Save draft</button><button class="btn btn-primary mb-2 mb-sm-0" type="submit">Projeyi Oluştur</button></div>
      </div>
      @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif
      <div class="row g-5">
        <div class="col-12 col-xl-8">
          <h4 class="mb-3">Proje Adı</h4><input name="name" class="form-control mb-5" type="text" placeholder="Proje Adı" />
          <div class="mb-6">
            <h4 class="mb-3">Proje Açıklaması</h4>
            <textarea id="editor" name="description" name="content" ></textarea>
          </div>
          <h4 class="mb-3">Projenin Kapak Fotoğrafı</h4>
          <input type="file" name="cover_photo" class="mb-4" id="">
          <h4 class="mb-3">Proje Görselleri</h4>
          <input type="file" name="project_images[]" multiple class="mb-4" id="">
          
            <h4 class="mb-3">Kaç Adet Konutunuz Var</h4><input class="form-control mb-5" type="text" id="house_count" name="house_count" placeholder="Kaç Adet Konutunuz Var" />
          
            <span id="generate_tabs" class=" btn btn-primary mb-5">Daireleri Oluştur</span>

            <div class="rendered-area d-none">
                <h4 class="mb-3">Daire Bilgileri</h4>
                    <div class="row g-0 border-top border-bottom border-300">
                    <div class="col-sm-4">
                        <div id="tablist" class="nav flex-sm-column border-bottom border-bottom-sm-0 border-end-sm border-300 fs--1 vertical-tab h-100 justify-content-between" role="tablist" aria-orientation="vertical">
                        
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="tab-content py-3 ps-sm-4 h-100">
                            <div class="tab-pane fade show active" id="pricingTabContent" role="tabpanel">
                                <div id="renderForm"></div>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
          <div class="row g-2">
            <div class="col-12 col-xl-12">
              <div class="card mb-3">
                <div class="card-body">
                  <h4 class="card-title mb-4">Genel Bilgiler</h4>
                  <div class="row gx-3">
                    <div class="col-12 col-sm-6 col-xl-12">
                      <div class="mb-4">
                        <div class="d-flex flex-wrap mb-2">
                          <h5 class="mb-0 text-1000 me-2">Hangi Marka Adına Eklensin</h5>
                        </div>
                        <select class="form-select mb-3" name="brand_id" aria-label="category">
                            @foreach($brands as $brand)
                                <option value="{{$brand->id}}">{{$brand->title}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-12">
                        <div class="mb-4">
                          <div class="d-flex flex-wrap mb-2">
                            <h5 class="mb-0 text-1000 me-2">Proje Hangi Tipte Konutlardan Oluşuyor</h5>
                          </div>
                          <select class="form-select mb-3" name="housing_type" id="housing_type" aria-label="category">
                            <option value="" selected="">Tİp Seç:</option>
                            @foreach ($housing_types as $type)
                                <option value="{{ $type->id }}">{{ $type->title }}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-12">
                        <div class="mb-4">
                            <div class="d-flex flex-wrap mb-2">
                                <h5 class="mb-0 text-1000 me-2">Haritadan Konumu Seçiniz</h5>
                            </div>
                            <div class="col-md-12">
                                <input name="location" class="form-control" id="location" readonly type="hidden"
                                                value="39.1667,35.6667" />
                                <div id="mapContainer"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-12">
                        <div class="mb-4">
                          <div class="d-flex flex-wrap mb-2">
                            <h5 class="mb-0 text-1000 me-2">Adresini Yazınız</h5>
                          </div>
                          <textarea name="address" id="" cols="30" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
    <footer class="footer position-absolute">
      <div class="row g-0 justify-content-between align-items-center h-100">
        <div class="col-12 col-sm-auto text-center">
          <p class="mb-0 mt-2 mt-sm-0 text-900">Thank you for creating with Phoenix<span class="d-none d-sm-inline-block"></span><span class="d-none d-sm-inline-block mx-1">|</span><br class="d-sm-none" />2023 &copy;<a class="mx-1" href="https://themewagon.com/">Themewagon</a></p>
        </div>
        <div class="col-12 col-sm-auto text-center">
          <p class="mb-0 text-600">v1.13.0</p>
        </div>
      </div>
    </footer>
  </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        jQuery($ => {
            $('#location').leafletLocationPicker({
                alwaysOpen: true,
                mapContainer: "#mapContainer",
                height: 300,
                width : '100%',
                map: {
                    zoom: 5
                }


            });

            const houseCountInput = document.getElementById('house_count');
            const generateTabsButton = document.getElementById('generate_tabs');
            const tabsContainer = document.getElementById('tabs');

            generateTabsButton.addEventListener('click', function () {
                
                var selectedid = $('#housing_type').val();
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
                    url: "{{ route('admin.ht.getform') }}",
                    data: {
                        id: selectedid
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
                            console.log(i);
                            formRenderOpts = {
                                dataType: 'json',
                                formData: response.form_json
                            };

                            var renderedForm = $('<div>');
                            renderedForm.formRender(formRenderOpts);
                            console.log($('#renderForm'+(i)),renderedForm.html());
                            $('#renderForm'+(i)).html(renderedForm.html());
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
                        


                    },
                    error: function(error) {
                        console.log(error)
                    }
                })
                // Belirtilen sayıda sekme oluştur
                
            });
        });
           
    </script>
    <script src="{{ URL::to('/') }}/adminassets/vendors/tinymce/tinymce.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors/dropzone/dropzone.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors/choices/choices.min.js"></script>
    
    <script src="//cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
        
    </script>
    @stack('scripts')
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css" integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .leaflet-container{
            height: 100%;
        }
    </style>
@endsection