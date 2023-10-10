@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Adım Adım Kategori Seç</h2>
        <div class="breadcrumb">
            <span>Emlak</span>
        </div>
        <div class="mt-4">
            <div class="firt-area">
                <div class="row">
                    <div class="area-lists">
                        <div class="area-list active">
                            <ul>
                                @foreach($housingTypeParent as $parent)
                                <li slug="{{$parent->slug}}">{{$parent->title}}</li>
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
                                <div class="finish-button">
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
                            Emlak
                        </div>
                    </div>
                    <div class="form-area mt-4">
                        <span class="section-title">İlan Detayları</span>
                        
                        <div class="form-group">
                            <label for="">İlan Başlığı <span class="required">*</span></label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">İlan Açıklaması <span class="required">*</span></label>
                            <textarea name="" id="editor" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        <h4 class="mb-3">Kaç Adet Konutunuz Var</h4><input class="form-control mb-5" type="text" id="house_count" name="house_count" value="{{old('house_count')}}" placeholder="Kaç Adet Konutunuz Var" />
                        <span id="generate_tabs" class=" btn btn-primary mb-5">Daireleri Oluştur</span>
                        <div class="row">
                            <div class="col-sm-3">
                                <div id="tablist" class="nav flex-sm-column border-bottom border-bottom-sm-0 border-end-sm border-300 fs--1 vertical-tab h-100 justify-content-between" role="tablist" aria-orientation="vertical">
        
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
                                        <select name="city_id" id="cities" class="form-control">
                                            @foreach($cities as $city)
                                              <option value="{{$city->id}}">{{$city->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">İlçe <span class="required">*</span></label>
                                        <select name="county_id" id="counties" class="form-control">
                                            <option value="">Pendik</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">İlçe <span class="required">*</span></label>
                                        <select name="neighbourhood_id" id="neighbourhood" class="form-control">
                                            <option value="">Mahalle</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
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

                var selectedid = 1;
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
                          text: response[i].title, // İlçe adı
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
          console.log($('#counties option[value="'+selectedCounty+'"]'));
          // AJAX isteği yap
          $.ajax({
              url: '{{route("institutional.get.neighbourhood")}}', // Endpoint URL'si (get.counties olarak varsayalım)
              method: 'GET',
              data: { county_id: selectedCountyKey }, // Şehir verisini isteğe ekle
              dataType: 'json', // Yanıtın JSON formatında olduğunu belirt
              success: function(response) {
                  // Yanıt başarılı olduğunda çalışacak kod
                  var countiesSelect = $('#neighbourhood'); // counties id'li select'i seç
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
    </script>

    <script src="//cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
        var itemOrder = 0;
        var itemSlug = "";
        var areasSlugs = [];
        function listChange(){
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

        $('.area-list li').click(function(){
            var clickItem = $(this).closest('.area-list');
            itemOrder = clickItem.index();
            itemSlug = $(this).attr('slug')
            listChange();
        })
    </script>
    @stack('scripts')
@endsection
