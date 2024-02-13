@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="firt-area management">
                    <div class="row">
                        <div class="area-lists">
                            <div class="area-list active">
                                <div class="create"><i class="fa fa-plus"></i></div>
                                <ul>
                                    @foreach($housingTypeParent as $parent)
                                    <li @if(isset($tempData->step1_slug) && $tempData->step1_slug == $parent->slug) class="selected" @endif slug="{{$parent->slug}}"><div class="li-icon"><i class="fa fa-trash"></i></div> <span>{{$parent->title}}</span></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="area-list area-list1 ">
                                <div class="create"><i class="fa fa-plus"></i></div>
                                <ul>
                                    <li slug="satilik">Satılık</li>
                                    <li slug="kiralik">Kiralık</li>
                                </ul>
                            </div>
                            <div class="area-list area-list2">
                                <div class="create"><i class="fa fa-edit"></i></div>
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
            </div>
        </div>
    </div>
    <div class="pop-up-housing d-none">
        <div class="pop-back-housing">

        </div>
        <div class="pop-content-housing">
            <div class="pop-content-inner">
                <div class="step1x">
                    <h2 class="text-center">Yeni bir veri ekle</h2>
                    <div class="form-group">
                        <label for="">Başlık</label>
                        <input type="text" class="form-control new_data_title">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success new_data_button">Ekle</button>
                    </div>
                </div>
                <div class="step2x d-none">
                    <h2 class="text-center">Yeni bir veri ekle</h2>
                    <div class="housing_types">
                        @foreach($housingTypes as $i => $housingType)
                            <div class="form-group">
                                <input type="checkbox" class="housing_type_checkbox" name="housing_type[]" id="housing_type{{$i}}" value="{{$housingType->id}}">
                                <label for="housing_type{{$i}}">{{$housingType->title}}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success save_data_button">Ekle</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" />
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/assets/js/jquery-menu-editor.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/assets/js/bootstrap-iconpicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var areasSlugs = [];
        var itemSlug = "";
        var itemOrder = 0;

        $('.pop-back-housing').click(function(){
            $('.pop-up-housing').addClass('d-none')
        })
        function listChange(order = 0){
            $.ajax({
                url: "{{URL::to('/')}}/qR9zLp2xS6y/secured/get_housing_type_childrens/"+itemSlug, // AJAX isteği yapılacak URL
                type: "GET", // GET isteği
                dataType: "json", // Gelen veri tipi JSON
                success: function (data) {
                    data = data.data;
                    var list = "";
                    for(var i = 0 ; i < data.length; i++){
                        if(itemOrder != 1){
                            list += "<li slug='"+data[i].slug+"'><div class='li-icon'><i class='fa fa-trash'></i></div><span>"+data[i].title+"</span></li>"
                        }else{
                            list += "<li slug='"+data[i].slug+"'><span>"+data[i].title+"</span></li>"
                        }
                    }
                    $('.area-list').eq(itemOrder + 1).children('ul').html(list)

                    $('.area-list li .li-icon').click(function(e){
            
                        itemOrder = $(this).closest('.area-list').index();
                        var parentItem = $(this).closest('li');
                        itemSlug = $(this).parent('li').attr('slug')
                        var veri = {
                            _token: csrfToken,
                            slug : itemSlug,
                            parentSlug : areasSlugs[0] ? areasSlugs[0].slug : null,
                            itemIndex : itemOrder
                        };

                        $.ajax({
                            url: "{{route('admin.delete.housing.type.parent')}}", // İstek gönderilecek URL
                            type: "POST", // POST isteği
                            data: JSON.stringify(veri), // Veriyi JSON formatına dönüştürün
                            contentType: "application/json; charset=utf-8", // İçerik türü JSON
                            dataType: "json", // Gelen yanıtın JSON olduğunu belirtin
                            success: function(response) {
                                if(response.success == true){
                                    parentItem.remove();
                                    $.toast({
                                        heading: 'Başarılı',
                                        text: 'Başarıyla listeleme verisini sildiniz',
                                        position: 'top-right',
                                        stack: false
                                    })
                                }
                            },
                            error: function(xhr, status, error) {
                                // İstek başarısızsa bu fonksiyon çalışır
                                $("#sonuc").text("İşlem başarısız: " + error);
                            }
                        });
                    })
                    
                    $('.area-list1 li span').click(function(){
                        var clickItem = $(this).closest('.area-list');
                        itemOrder = clickItem.index();
                        itemSlug = $(this).parent('li').attr('slug')
                            $.ajax({
                                url: "{{URL::to('/')}}/qR9zLp2xS6y/secured/get_housing_type_childrens/"+itemSlug+'?parent_slug='+(areasSlugs[0] ? areasSlugs[0].slug : ''), // AJAX isteği yapılacak URL
                                type: "GET", // GET isteği
                                dataType: "json", // Gelen veri tipi JSON
                                success: function (data) {
                                    data = data.data;
                                    var list = "";
                                    for(var i = 0 ; i < data.length; i++){
                                        if(itemOrder != 1){
                                            list += "<li slug='"+data[i].slug+"'><div class='li-icon'><i class='fa fa-trash'></i></div><span>"+data[i].title+"</span></li>"
                                        }else{
                                            list += "<li slug='"+data[i].slug+"'><span>"+data[i].title+"</span></li>"
                                        }
                                    }
                                    $('.area-list').eq(itemOrder + 1).children('ul').html(list)

                                    $('.area-list li .li-icon').click(function(e){
                            
                                        itemOrder = $(this).closest('.area-list').index();
                                        var parentItem = $(this).closest('li');
                                        itemSlug = $(this).parent('li').attr('slug')
                                        var veri = {
                                            _token: csrfToken,
                                            slug : itemSlug,
                                            parentSlug : areasSlugs[0] ? areasSlugs[0].slug : null,
                                            itemIndex : itemOrder
                                        };

                                        $.ajax({
                                            url: "{{route('admin.delete.housing.type.parent')}}", // İstek gönderilecek URL
                                            type: "POST", // POST isteği
                                            data: JSON.stringify(veri), // Veriyi JSON formatına dönüştürün
                                            contentType: "application/json; charset=utf-8", // İçerik türü JSON
                                            dataType: "json", // Gelen yanıtın JSON olduğunu belirtin
                                            success: function(response) {
                                                if(response.success == true){
                                                    parentItem.remove();
                                                    $.toast({
                                                        heading: 'Başarılı',
                                                        text: 'Başarıyla listeleme verisini sildiniz',
                                                        position: 'top-right',
                                                        stack: false
                                                    })
                                                }
                                            },
                                            error: function(xhr, status, error) {
                                                // İstek başarısızsa bu fonksiyon çalışır
                                                $("#sonuc").text("İşlem başarısız: " + error);
                                            }
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
                                        label : $("li[slug='"+itemSlug+"'] span").html()
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
                        label : $("li[slug='"+itemSlug+"'] span").html()
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

        var selectedSlug = "";
        var itemIndex = 0;

        function listChange2(order = 0){
            $.ajax({
                url: "{{URL::to('/')}}/qR9zLp2xS6y/secured/get_housing_type_childrens/"+itemSlug+'?parent_slug='+(areasSlugs[0] ? areasSlugs[0].slug : ''), // AJAX isteği yapılacak URL
                type: "GET", // GET isteği
                dataType: "json", // Gelen veri tipi JSON
                success: function (data) {
                    data = data.data;
                    var list = "";
                    for(var i = 0 ; i < data.length; i++){
                        if(itemOrder != 1){
                            list += "<li slug='"+data[i].slug+"'><div class='li-icon'><i class='fa fa-trash'></i></div><span>"+data[i].title+"</span></li>"
                        }else{
                            list += "<li slug='"+data[i].slug+"'><span>"+data[i].title+"</span></li>"
                        }
                    }
                    $('.area-list').eq(itemOrder + 1).children('ul').html(list)

                    $('.area-list li .li-icon').click(function(e){
            
                        itemOrder = $(this).closest('.area-list').index();
                        var parentItem = $(this).closest('li');
                        itemSlug = $(this).parent('li').attr('slug')
                        var veri = {
                            _token: csrfToken,
                            slug : itemSlug,
                            parentSlug : areasSlugs[0] ? areasSlugs[0].slug : null,
                            itemIndex : itemOrder
                        };

                        $.ajax({
                            url: "{{route('admin.delete.housing.type.parent')}}", // İstek gönderilecek URL
                            type: "POST", // POST isteği
                            data: JSON.stringify(veri), // Veriyi JSON formatına dönüştürün
                            contentType: "application/json; charset=utf-8", // İçerik türü JSON
                            dataType: "json", // Gelen yanıtın JSON olduğunu belirtin
                            success: function(response) {
                                if(response.success == true){
                                    parentItem.remove();
                                    $.toast({
                                        heading: 'Başarılı',
                                        text: 'Başarıyla listeleme verisini sildiniz',
                                        position: 'top-right',
                                        stack: false
                                    })
                                }
                            },
                            error: function(xhr, status, error) {
                                // İstek başarısızsa bu fonksiyon çalışır
                                $("#sonuc").text("İşlem başarısız: " + error);
                            }
                        });
                    })
                    
                    $('.area-list1 li span').click(function(){
                        var clickItem = $(this).closest('.area-list');
                        itemOrder = clickItem.index();
                        itemSlug = $(this).parent('li').attr('slug')
                            $.ajax({
                                url: "{{URL::to('/')}}/qR9zLp2xS6y/secured/get_housing_type_childrens/"+itemSlug+'?parent_slug='+(areasSlugs[0] ? areasSlugs[0].slug : ''), // AJAX isteği yapılacak URL
                                type: "GET", // GET isteği
                                dataType: "json", // Gelen veri tipi JSON
                                success: function (data) {
                                    data = data.data;
                                    var list = "";
                                    for(var i = 0 ; i < data.length; i++){
                                        if(itemOrder != 1){
                                            list += "<li slug='"+data[i].slug+"'><div class='li-icon'><i class='fa fa-trash'></i></div><span>"+data[i].title+"</span></li>"
                                        }else{
                                            list += "<li slug='"+data[i].slug+"'><span>"+data[i].title+"</span></li>"
                                        }
                                    }
                                    $('.area-list').eq(itemOrder + 1).children('ul').html(list)

                                    $('.area-list li .li-icon').click(function(e){
                            
                                        itemOrder = $(this).closest('.area-list').index();
                                        var parentItem = $(this).closest('li');
                                        itemSlug = $(this).parent('li').attr('slug')
                                        var veri = {
                                            _token: csrfToken,
                                            slug : itemSlug,
                                            parentSlug : areasSlugs[0] ? areasSlugs[0].slug : null,
                                            itemIndex : itemOrder
                                        };

                                        $.ajax({
                                            url: "{{route('admin.delete.housing.type.parent')}}", // İstek gönderilecek URL
                                            type: "POST", // POST isteği
                                            data: JSON.stringify(veri), // Veriyi JSON formatına dönüştürün
                                            contentType: "application/json; charset=utf-8", // İçerik türü JSON
                                            dataType: "json", // Gelen yanıtın JSON olduğunu belirtin
                                            success: function(response) {
                                                if(response.success == true){
                                                    parentItem.remove();
                                                    $.toast({
                                                        heading: 'Başarılı',
                                                        text: 'Başarıyla listeleme verisini sildiniz',
                                                        position: 'top-right',
                                                        stack: false
                                                    })
                                                }
                                            },
                                            error: function(xhr, status, error) {
                                                // İstek başarısızsa bu fonksiyon çalışır
                                                $("#sonuc").text("İşlem başarısız: " + error);
                                            }
                                        });
                                    })
                                    
                                    $('.area-list1 li span').click(function(){
                                        var clickItem = $(this).closest('.area-list');
                                        itemOrder = clickItem.index();
                                        itemSlug = $(this).parent('li').attr('slug')
                                        if(itemOrder == 2){
                                            $.ajax({
                                                url: "{{URL::to('/')}}/institutional/get_housing_type_id/"+itemSlug, // AJAX isteği yapılacak URL
                                                type: "GET", // GET isteği
                                                dataType: "json", // Gelen veri tipi JSON
                                                success: function (data) {
                                                    selectedid = data;
                                                }
                                            })
                                        }
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
                                        label : $("li[slug='"+itemSlug+"'] span").html()
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
                        label : $("li[slug='"+itemSlug+"'] span").html()
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

        $('.area-list1 span').click(function(){
            var clickItem = $(this).closest('.area-list');
            itemOrder = clickItem.index();
            itemSlug = $(this).parent('li').attr('slug')
            listChange(0);
        })

        $('.area-list2 span').click(function(){
            var clickItem = $(this).closest('.area-list');
            itemOrder = clickItem.index();
            itemSlug = $(this).parent('li').attr('slug')
            listChange2(0);
        })

        $('.area-list li span').click(function(){
            var clickItem = $(this).closest('.area-list');
            itemOrder = clickItem.index();
            itemSlug = $(this).parent('li').attr('slug')
            if(itemOrder == 2){
                $.ajax({
                    url: "{{URL::to('/')}}/institutional/get_housing_type_id/"+itemSlug, // AJAX isteği yapılacak URL
                    type: "GET", // GET isteği
                    dataType: "json", // Gelen veri tipi JSON
                    success: function (data) {
                        selectedid = data;
                    }
                })
            }
            listChange(1);
        })
        
        $('.area-list .create').click(function(){
            itemIndex = $(this).closest('.area-list').index();
            if(itemIndex != 0){
                selectedSlug = areasSlugs[itemIndex - 1].slug;
            }

            if(itemIndex == 2){
                $('.step2x').removeClass('d-none')
                $('.step1x').addClass('d-none')
                $.get("{{route('admin.get.housing.type.parent.connections')}}?parent_slug="+areasSlugs[1].slug+"&top_slug="+areasSlugs[0].slug, function(data) {
                    $('.housing_type_checkbox').prop('checked',false);
                    for(var i = 0 ; i < data.length ; i++){
                        $('.housing_type_checkbox[value="'+data[i].housing_type_id+'"]').prop('checked',true);
                    }
                });
            }else{
                $('.step2x').addClass('d-none')
                $('.step1x').removeClass('d-none')
            }
            
            $('.pop-up-housing').removeClass('d-none');
        })

        $('.area-list li .li-icon').click(function(e){
            
            itemOrder = $(this).closest('.area-list').index();
            var parentItem = $(this).closest('li');
            itemSlug = $(this).parent('li').attr('slug')
            var veri = {
                _token: csrfToken,
                slug : itemSlug,
                parentSlug : areasSlugs[0] ? areasSlugs[0].slug : null,
                itemIndex : itemOrder
            };

            $.ajax({
                url: "{{route('admin.delete.housing.type.parent')}}", // İstek gönderilecek URL
                type: "POST", // POST isteği
                data: JSON.stringify(veri), // Veriyi JSON formatına dönüştürün
                contentType: "application/json; charset=utf-8", // İçerik türü JSON
                dataType: "json", // Gelen yanıtın JSON olduğunu belirtin
                success: function(response) {
                    if(response.success == true){
                        parentItem.remove();
                        $.toast({
                            heading: 'Başarılı',
                            text: 'Başarıyla listeleme verisini sildiniz',
                            position: 'top-right',
                            stack: false
                        })
                    }
                },
                error: function(xhr, status, error) {
                    // İstek başarısızsa bu fonksiyon çalışır
                    $("#sonuc").text("İşlem başarısız: " + error);
                }
            });
        })

        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('.new_data_button').click(function(e){
            e.preventDefault();
            var dataTitle = $('.new_data_title').val();
            var veri = {
                _token: csrfToken,
                dataTitle: dataTitle,
                slug : selectedSlug,
                itemIndex : itemIndex
            };

            $.ajax({
                url: "{{route('admin.new.housing.type.parent')}}", // İstek gönderilecek URL
                type: "POST", // POST isteği
                data: JSON.stringify(veri), // Veriyi JSON formatına dönüştürün
                contentType: "application/json; charset=utf-8", // İçerik türü JSON
                dataType: "json", // Gelen yanıtın JSON olduğunu belirtin
                success: function(response) {
                    if(response.success == true){
                        $('.new_data_title').val("")
                        $('.area-list').eq(itemIndex).find('ul').append('<li slug="'+response.data.slug+'"> <div class="li-icon"><i class="fa fa-trash"></i></div><span>'+dataTitle+'</span></li>')
                        $('.pop-up-housing').addClass('d-none');
                        $.toast({
                            heading: 'Başarılı',
                            text: 'Başarıyla listeleme verisi eklediniz',
                            position: 'top-right',
                            stack: false
                        })

                        $('.area-list li .li-icon').click(function(e){
                            itemOrder = $(this).closest('.area-list').index();
                            var parentItem = $(this).closest('li');
                            itemSlug = $(this).parent('li').attr('slug')
                            var veri = {
                                _token: csrfToken,
                                slug : itemSlug,
                                parentSlug : areasSlugs[0] ? areasSlugs[0].slug : null,
                                itemIndex : itemOrder
                            };

                            $.ajax({
                                url: "{{route('admin.delete.housing.type.parent')}}", // İstek gönderilecek URL
                                type: "POST", // POST isteği
                                data: JSON.stringify(veri), // Veriyi JSON formatına dönüştürün
                                contentType: "application/json; charset=utf-8", // İçerik türü JSON
                                dataType: "json", // Gelen yanıtın JSON olduğunu belirtin
                                success: function(response) {
                                    if(response.success == true){
                                        parentItem.remove();
                                        $.toast({
                                            heading: 'Başarılı',
                                            text: 'Başarıyla listeleme verisini sildiniz',
                                            position: 'top-right',
                                            stack: false
                                        })
                                    }
                                },
                                error: function(xhr, status, error) {
                                    // İstek başarısızsa bu fonksiyon çalışır
                                    $("#sonuc").text("İşlem başarısız: " + error);
                                }
                            });
                        })

                        $('.area-list span').click(function(){
                            var clickItem = $(this).closest('.area-list');
                            itemOrder = clickItem.index();
                            itemSlug = $(this).parent('li').attr('slug')
                            listChange(0);
                        })
                    }
                },
                error: function(xhr, status, error) {
                    // İstek başarısızsa bu fonksiyon çalışır
                    $("#sonuc").text("İşlem başarısız: " + error);
                }
            });
        })

        $('.save_data_button').click(function(){
            var secilenVeriler = [];
            $('input[name="housing_type[]"]:checked').each(function() {
                secilenVeriler.push($(this).val());
            });

            var veri = {
                _token: csrfToken,
                checkboxes: secilenVeriler,
                slug : selectedSlug,
                topSlug : areasSlugs[0].slug,
                itemIndex : itemIndex
            };
            
            $.ajax({
                url: "{{route('admin.add.housing.parent.connection')}}", // İstek gönderilecek URL
                type: "POST", // POST isteği
                data: JSON.stringify(veri), // Veriyi JSON formatına dönüştürün
                contentType: "application/json; charset=utf-8", // İçerik türü JSON
                dataType: "json", // Gelen yanıtın JSON olduğunu belirtin
                success: function(response) {
                    console.log(response.success);
                    if(response.success == true){
                        $('.pop-up-housing').addClass('d-none');
                        $.toast({
                            heading: 'Başarılı',
                            text: 'Başarıyla listeleme verisi eklediniz',
                            position: 'top-right',
                            stack: false
                        })
                        var list = "";
                        for(var i = 0 ; i < response.connections.length; i++){
                            list += "<li slug='"+response.connections[i].housing_type.slug+"'><span>"+response.connections[i].housing_type.title+"</span></li>"
                        }

                        $('.area-list').eq(2).children('ul').html(list);
                    }
                },
                error: function(xhr, status, error) {
                    // İstek başarısızsa bu fonksiyon çalışır
                    $("#sonuc").text("İşlem başarısız: " + error);
                }
            });
        })
    </script>
@endsection

@section('csss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css" integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
