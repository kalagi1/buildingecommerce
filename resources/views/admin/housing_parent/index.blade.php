@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="firt-area">
                    <div class="row">
                        <div class="area-lists">
                            <div class="area-list active">
                                <div class="create"><i class="fa fa-plus"></i></div>
                                <ul>
                                    @foreach($housingTypeParent as $parent)
                                    <li @if(isset($tempData->step1_slug) && $tempData->step1_slug == $parent->slug) class="selected" @endif slug="{{$parent->slug}}">{{$parent->title}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="area-list ">
                                <div class="create"><i class="fa fa-plus"></i></div>
                                <ul>
                                    <li slug="satilik">Satılık</li>
                                    <li slug="kiralik">Kiralık</li>
                                </ul>
                            </div>
                            <div class="area-list ">
                                <div class="create"><i class="fa fa-plus"></i></div>
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
            <div class="col-md-12">
                <button class="save-menu btn btn-primary" class="">Kaydet</button>
            </div>
        </div>
    </div>
    <div class="pop-up-v2 d-none">
        <div class="pop-back">

        </div>
        <div class="pop-content">
            <div class="pop-content-inner">
                <h2 class="text-center">Yeni bir veri ekle</h2>
                    <div class="form-group">
                        <label for="">Başlık</label>
                        <input type="text" class="form-control new_data_title">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success new_data_button">Ekle</button>
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
    <script>
        var areasSlugs = [];
        function listChange(){
            $.ajax({
                url: "{{URL::to('/')}}/admin/get_housing_type_childrens/"+itemSlug, // AJAX isteği yapılacak URL
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

        var selectedSlug = "";
        var itemIndex = 0;

        $('.area-list li').click(function(){
            var clickItem = $(this).closest('.area-list');
            itemOrder = clickItem.index();
            itemSlug = $(this).attr('slug')
            listChange();
        })
        
        $('.area-list .create').click(function(){
            itemIndex = $(this).closest('.area-list').index();
            if(itemIndex != 0){
                selectedSlug = areasSlugs[itemIndex - 1];
            }
            
            $('.pop-up-v2').removeClass('d-none');
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
                        console.log(itemIndex);
                        console.log($('.area-list').eq(itemIndex));
                        $('.area-list').eq(itemIndex).find('ul').append('<li>'+dataTitle+'</li>')
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
