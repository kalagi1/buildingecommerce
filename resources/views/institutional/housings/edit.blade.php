@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Emlağı Düzenle</h2>
        <div class="mt-4">
            <div class="row g-4">
                <div class="col-12 col-xl-12 order-1 order-xl-0">
                    <div class="mb-9">
                        <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                            @if (session()->has('success'))
                                <div class="alert alert-success text-white">
                                    {{ session()->get('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger text-white">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card-body p-0">
                                <div class="p-4">

                                    <form class="row g-3 needs-validation" novalidate="" method="POST"
                                        action="{{ route('institutional.housing.update',$housing->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-md-12">
                                            <div class="row" style="align-items: flex-end">
                                                <div class="col-md-8">
                                                    <label class="form-label" for="validationCustom01">Projenin size ait olduğuna dair belge</label>
                                                    <input name="document" class="form-control" id="validationCustom01"
                                                        type="file" value="" >
                                                    <div class="valid-feedback">Looks good!</div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <a href="{{URL::to('/')}}/housing_documents/{{$housing->document}}" class="btn btn-info" download="">Dosyayı İndir</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom01">Başlık</label>
                                            <input name="title" class="form-control" id="validationCustom01"
                                                type="text" value="{{$housing->title}}" required="">
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom01">Hangi Marka Adına Ekliyorsun</label>
                                            <select name="brand_id" class="form-control" id="">
                                                @foreach($brands as $brand)
                                                    <option @if($housing->brand_id == $brand->id) selected @endif value="{{$brand->id}}">{{$brand->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom01">Şehir</label>
                                            <select name="city_id" class="form-control" id="cities">
                                                @foreach($cities as $city)
                                                    <option @if($housing->city_id == $city->id) selected @endif value="{{$city->id}}">{{$city->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom01">İlçe</label>
                                            <select name="county_id" class="form-control" id="counties">
                                                @foreach($counties as $county)
                                                    <option @if($housing->county_id == $county->id) selected @endif value="{{$county->id}}">{{$county->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="address">Adres</label>
                                            <textarea class="form-control" id="address" name="address" rows="3">{{$housing->address}} </textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="description">Açıklama</label>
                                            <textarea class="form-control" id="description" name="description" rows="3">{{$housing->description}} </textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="status">Durum</label>
                                            <select name="status[]" id="housing_status" multiple
                                                aria-label="Default select example">
                                                <option value="" selected="">Konut durumunu seçiniz:</option>
                                                @foreach ($housing_status as $status)
                                                    <option @if(isset($statuses[$status->id])) selected @endif value="{{ $status->id }}">{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Daire Türünü Seçiniz</label>
                                            <select name="housing_type" id="housing_type" class="form-select"
                                                aria-label="Default select example">
                                                <option selected="">Daire Türünü Seçiniz:</option>
                                                @foreach ($housing_types as $type)
                                                    <option @if($housing->housing_type_id == $type->id) selected @endif value="{{ $type->id }}">{{ $type->title }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="location">Konum:</label>
                                            <input name="location" class="form-control" id="location" readonly type="hidden"
                                                value="{{$housing->latitude}},{{$housing->longitude}}" />
                                            <div id="mapContainer"></div>
                                        </div>

                                        <div id="renderForm"></div>
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Kaydet</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
            <div class="toast align-items-center text-white bg-dark border-0 light" id="icon-copied-toast" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body p-3"></div><button class="btn-close btn-close-white me-2 m-auto"
                        type="button" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css" integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
<script src="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.min.js"></script>
    <script>
        jQuery($ => {
            $('#location').leafletLocationPicker({
                alwaysOpen: true,
                mapContainer: "#mapContainer",
                height: 300,
                map: {
                    zoom: 5
                }


            });

            @if($housing->housing_type_id)
                var selectedid = {{$housing->housing_type_id}}
                var oldData = @json($housing->housing_type_data);
                oldData = JSON.parse(oldData);
                $.ajax({
                    method: "GET",
                    url: "{{ route('institutional.ht.getform') }}",
                    data: {
                        id: selectedid
                    },
                    success: function(response) {
                        formRenderOpts = {
                            dataType: 'json',
                            formData: response.form_json
                        };

                        var renderedForm = $('<div>');
                        renderedForm.formRender(formRenderOpts);

                        $('#renderForm').html(renderedForm.html());
                        var houseCount = 1;
                        var formInputs = JSON.parse(response.form_json);
                        for (let i = 1; i <= houseCount; i++) {
                            for(var j = 2 ; j < formInputs.length; j++){
                            if(formInputs[j].type == "number" || formInputs[j].type == "text"){
                                var inputName = formInputs[j].name;
                                var inputNamex = inputName;
                                inputNamex = inputNamex.split('[]')
                                $('input[name="'+formInputs[j].name+'"]').val(oldData[inputNamex[0]][0]);
                            }else if(formInputs[j].type == "select"){
                                var inputName = formInputs[j].name;
                                var inputNamex = inputName;
                                inputNamex = inputNamex.split('[]')
                                $($('select[name="'+formInputs[j].name+'"]')).children('option').map((key,item) => {
                                if($(item).attr("value") == oldData[inputNamex[0]]){
                                    $(item).attr('selected','selected')
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
                                $($('input[name="'+checkboxName+'[][]"]')).map((key,item) => {
                                
                                oldData[inputNamex[0]].map((checkbox) => {
                                    if(checkbox[0] == $(item).attr("value")){
                                    $(item).attr('checked','checked')
                                    }
                                })
                                });
                            }
                            
                            }
                        }

                        $('.dropzonearea').parent('div').append('<div class="add-new-project-house-image"><span class="btn btn-success">Yeni Resim ekle</span></div>')
                        $('.dropzonearea').parent('div').append('<div class="dropzone2"></div>')
                        $('.dropzonearea').remove();
                        for(let i = 1 ; i <= houseCount; i++){
                            var images = '';
                            if(oldData.images){
                            housingImages =  oldData.images;
                            }else{
                            housingImages = [];
                            }

                            for(let j = 0; j < housingImages.length; j++){
                            images += '<div class="project_images_area"><img class="edit_project_housing_image" src="{{URL::to("/")."/housing_images/"}}'+housingImages[j]+'"> <span order="'+j+'" housing_order="'+i+'" class="btn btn-danger remove_housing_image">Sil</span>  </div>';
                            }
                            $('.dropzone2').eq(i-1).parent('div').append('<div class="d-none"><input housing_order="'+i+'" type="file" class="new_file_on_drop"></div>')
                            $('.dropzone2').eq(i-1).html(images);
                        }

                        var csrfToken = "{{ csrf_token() }}";
                        $('.remove_housing_image').click(function(){
                            var thisx = $(this);
                            var housingId = {{$housing->id}};
                            var housingOrder = $(this).attr('housing_order');
                            var order = $(this).attr('order');

                            $.ajax({
                            url: '{{route("institutional.remove.housing.image")}}', // İstek gönderilecek URL
                            type: 'POST', // HTTP isteği türü (POST)
                            data: {
                                housingId: housingId, // POST verileri,
                                order : order
                            },
                            dataType: 'json', // Sunucudan dönen veri türü (JSON, XML, vs.)
                            headers: {
                                'X-CSRF-TOKEN': csrfToken // CSRF tokeni başlık olarak eklenir
                            },
                            success: function(response) {
                                $.toast({
                                    heading: 'Başarılı',
                                    text: 'Başarıyla daireye ait fotoğrafı sildiniz',
                                    position: 'top-right',
                                    stack: false
                                })

                                thisx.parent('div').remove();
                            },
                            error: function(xhr, status, error) {
                                // İstek başarısız olduğunda çalışacak kodlar
                                console.error('Hata:', error);
                            }
                            });
                        })

                        $('.add-new-project-house-image').click(function(){
                            $(this).parent('div').find('.new_file_on_drop').trigger("click")
                        })

                        $('.new_file_on_drop').change(function(){
                            var thisx= $(this);
                            var fileInput = $(this)[0]; // File input öğesini alın
                            var selectedFile = fileInput.files[0]; // Seçilen dosyayı alın (ilk dosya)

                            if (selectedFile) {
                            // Dosya seçildiyse
                            var formData = new FormData();
                            formData.append('file', selectedFile); // Dosyayı FormData'ya ekleyin
                            formData.append('housingId', {{$housing->id}}); // Dosyayı FormData'ya ekleyin

                            // AJAX isteği gönderin
                            $.ajax({
                                url: '{{route("institutional.new.housing.image")}}', // İstek gönderilecek URL
                                type: 'POST', // HTTP isteği türü (POST)
                                data: formData, // FormData içeriği
                                processData: false, // FormData işleme
                                contentType: false, // FormData içeriği türü
                                headers: {
                                'X-CSRF-TOKEN': csrfToken // CSRF tokeni başlık olarak eklenir
                                },
                                success: function(response) {
                                response = JSON.parse(response);
                                var images = '<div class="project_images_area"><img class="edit_project_housing_image" src="{{URL::to("/")."/housing_images/"}}'+response.imageName+'"> <span order="'+($('.project_images_area').length)+'"  class="btn btn-danger remove_housing_image">Sil</span>  </div>';
                                thisx.parent('div').parent('div').find('.dropzone2').append(images);
                                $.toast({
                                    heading: 'Başarılı',
                                    text: 'Başarıyla daireye ait fotoğraf eklediniz',
                                    position: 'top-right',
                                    stack: false
                                })

                                $('.remove_housing_image').click(function(){
                                    var thisx = $(this);
                                    var housingId = {{$housing->id}};
                                    var housingOrder = $(this).attr('housing_order');
                                    var order = $(this).attr('order');

                                    $.ajax({
                                    url: '{{route("institutional.remove.housing.image")}}', // İstek gönderilecek URL
                                    type: 'POST', // HTTP isteği türü (POST)
                                    data: {
                                        housingId: housingId, // POST verileri,
                                        order : order
                                    },
                                    dataType: 'json', // Sunucudan dönen veri türü (JSON, XML, vs.)
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken // CSRF tokeni başlık olarak eklenir
                                    },
                                    success: function(response) {
                                        $.toast({
                                            heading: 'Başarılı',
                                            text: 'Başarıyla daireye ait fotoğrafı sildiniz',
                                            position: 'top-right',
                                            stack: false
                                        })

                                        thisx.parent('div').remove();
                                    },
                                    error: function(xhr, status, error) {
                                        // İstek başarısız olduğunda çalışacak kodlar
                                        console.error('Hata:', error);
                                    }
                                    });
                                })
                                },
                                error: function(xhr, status, error) {
                                // İstek başarısız olduğunda çalışacak kodlar
                                console.error('Hata:', error);
                                }
                            });
                            }
                        })
                        $('input[name="image[]"]').parent('div').append('<img style="max-width:250px;margin-top:20px;" src="{{URL::to("/")."/housing_images/"}}'+oldData.image+'">')

                    },
                    error: function(error) {
                        console.log(error)
                    }
                })
            @endif

            $('#housing_type').change(function() {
                var selectedid = this.value
                $.ajax({
                    method: "GET",
                    url: "{{ route('institutional.ht.getform') }}",
                    data: {
                        id: selectedid
                    },
                    success: function(response) {

                        formRenderOpts = {
                            dataType: 'json',
                            formData: response.form_json
                        };

                        var renderedForm = $('<div>');
                        renderedForm.formRender(formRenderOpts);

                        $('#renderForm').html(renderedForm.html());


                    },
                    error: function(error) {
                        console.log(error)
                    }
                })


            })

        });

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
                          value: response[i].id, // İlçe ID'si
                          text: response[i].title // İlçe adı
                      }));
                  }
              },
              error: function(xhr, status, error) {
                  // Hata durumunda çalışacak kod
                  console.error('Hata: ' + error);
              }
          });
      });

      $('#housing_status').selectize({
        plugins: ['remove_button'], // Kaldırma düğmesini etkinleştirme
      });
    </script>
    @stack('scripts')
@endsection
