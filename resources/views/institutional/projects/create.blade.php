@extends('institutional.layouts.master')

@section('content')

<div class="content">

    <form class="mb-9" method="post" action="{{route('institutional.projects.store')}}" enctype="multipart/form-data">
        @csrf
      <div class="row g-3 flex-between-end mb-5">
        <div class="col-auto">
          <h2 class="mb-2">Proje Ekle</h2>
          <h5 class="text-700 fw-semi-bold">Aşağıdan proje ekleyebilirsiniz</h5>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary mb-2 mb-sm-0" type="submit">Projeyi Oluştur</button></div>
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
          <h4 class="mb-3">Proje Adı</h4><input value="{{old('name')}}" name="name" class="form-control mb-5" type="text" placeholder="Proje Adı" />
          <div class="mb-6">
            <h4 class="mb-3">Proje Açıklaması</h4>
            <textarea id="editor" name="description" name="content" >{!!old('description')!!}</textarea>
          </div>
          <h4 class="mb-3">Projenin Kapak Fotoğrafı</h4>
          <input type="file" name="cover_photo" class="mb-4" id="">
          <h4 class="mb-3">Proje Görselleri</h4>
          <input type="file" name="project_images[]" multiple class="mb-4" id="">

            <h4 class="mb-3">Kaç Adet Konutunuz Var</h4><input class="form-control mb-5" type="text" id="house_count" name="house_count" value="{{old('house_count')}}" placeholder="Kaç Adet Konutunuz Var" />

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
                          <h5 class="mb-0 text-1000 me-2">Projenin size ait olduğuna dair belge</h5>
                          <input name="document" class="form-control mt-2"  type="file" />
                        </div>
                      </div>
                    </div>
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
                            <h5 class="mb-0 text-1000 me-2">Proje Hangi Tipte Konutlardan Oluşuyor {{old('housing_type')}}</h5>
                          </div>
                          <select class="form-select mb-3" name="housing_type" id="housing_type" aria-label="category">
                            <option value="">Tİp Seç:</option>
                            @foreach ($housing_types as $type)
                                <option @if(old('housing_type') && old('housing_type') == $type->id ) selected @endif value="{{ $type->id }}">{{ $type->title }}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-12">
                      <div class="mb-4">
                        <div class="d-flex flex-wrap mb-2">
                          <h5 class="mb-0 text-1000 me-2">Proje Konutlarının Statüsü Nedir?</h5>
                        </div>
                        <select multiple name="housing_status" id="housing_status" aria-label="category">
                          <option value="" selected="">Tİp Seç:</option>
                          @foreach ($housing_status as $status)
                              <option value="{{ $status->id }}">{{ $status->name }}</option>
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
                              <h5 class="mb-0 text-1000 me-2">Şehir</h5>
                          </div>
                          <div class="col-md-12">
                              <select name="city_id" id="cities" class="form-control">
                                @foreach($cities as $city)
                                  <option value="{{$city->id}}">{{$city->title}}</option>
                                @endforeach
                              </select>
                          </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-12">
                      <div class="mb-4">
                          <div class="d-flex flex-wrap mb-2">
                              <h5 class="mb-0 text-1000 me-2">İlçe</h5>
                          </div>
                          <div class="col-md-12">
                              <select name="county_id" id="counties" class="form-control">
                                <option value="">Pendik</option>
                              </select>
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

                  var apiURL = "https://nominatim.openstreetmap.org/reverse?format=json&lat=" + latitude + "&lon=" + longitude+'&zoom=18&addressdetails=1';

                  $.ajax({
                      url: apiURL,
                      type: "GET",
                      dataType: "json",
                      success: function(data) {
                        console.log(data);
                          var cityName = data.address.province; // Şehir ismini alın
                          $('#cities option').map((key,item) => {
                            if($('#cities option').eq(key).html() == cityName.toUpperCase()){
                              $.ajax({
                                  url: '{{route("institutional.get.counties")}}', // Endpoint URL'si (get.counties olarak varsayalım)
                                  method: 'GET',
                                  data: { city: $('#cities option').eq(key).val() }, // Şehir verisini isteğe ekle
                                  dataType: 'json', // Yanıtın JSON formatında olduğunu belirt
                                  success: function(response) {
                                    $('#cities option').eq(key).attr('selected','selected');
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

                                      $('#counties option').map((key,item) => {
                                        if($('#counties option').eq(key).html() == data.address.town.toUpperCase()){
                                          $('#counties option').eq(key).attr('selected','selected');
                                        }
                                      })
                                  },
                                  error: function(xhr, status, error) {
                                      // Hata durumunda çalışacak kod
                                      console.error('Hata: ' + error);
                                  }
                              });
                            }else{
                              $('#cities option').eq(key).removeAttr('selected');
                            }
                          })
                          console.log("Tıklanan Şehir: " + cityName);
                          console.log("Tıklanan İlçe: " + data.address.town);
                      },
                      error: function(error) {
                          console.error("Hata: Şehir bilgisi alınamadı.");
                      }
                  });
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
                    url: "{{ route('institutional.ht.getform') }}",
                    data: {
                        id: selectedid
                    },
                    success: function(response) {
                        var html = "";
                        var htmlContent = "";
                        for(var i = 0 ; i < houseCount; i++ ){
                            html += '<a class="nav-link border-end border-end-sm-0 border-bottom-sm border-300 text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center '+(i == 0 ? 'active' : '')+'" id="Tab'+(i+1)+'" data-bs-toggle="tab" data-bs-target="#TabContent'+(i+1)+'" role="tab" aria-controls="TabContent'+(i+1)+'" aria-selected="true">'+
                                '<span class="me-sm-2 fs-4 nav-icons" data-feather="tag"></span>'+
                                '<span class="d-block d-sm-inline">'+(i+1)+' Nolu Konut Bilgileri</span>'+
                                '<span class="d-block d-sm-inline">Kopyala (Aynı Olan Dairelere Otomatik Giriş) '+getCopyList(houseCount,i+1)+'</span>'+
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
    <script src="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.min.js"></script>

    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-formBuilder/3.4.2/form-render.min.js">
    <script src="
https://cdn.jsdelivr.net/npm/fine-uploader@5.16.2/fine-uploader/fine-uploader.min.js
"></script>
    <script src="//cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');

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

      $('#housing_status').selectize()


    </script>
    @stack('scripts')
@endsection

@section('css')
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.css"/>
<link href="https://cdn.jsdelivr.net/npm/fine-uploader@5.16.2/fine-uploader/fine-uploader-gallery.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css" integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .leaflet-container{
            height: 100%;
        }
    </style>
@endsection
