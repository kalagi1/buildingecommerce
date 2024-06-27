@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <form action="{{route('institutional.housing.update',$housing->id)}}" method="post">
            @csrf
            <div class="">
                <div class="clear-both"></div>
                <div class="second-area">
                    <div class="row">
                        <div class="form-area mt-4">
                            <span class="section-title mt-4">Kapak Fotoğrafı</span>
                            <div class="cover-photo-full card py-2 px-5">
                                <input type="file" name="cover-image" accept="image/*" class="cover_image d-none">
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
                                    @if(isset($formData->image) && $formData->image)
                                        <div class="project_imagex">
                                            <img src="{{ asset('housing_images/' . json_decode($housing->housing_type_data)->image) }}" alt="">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <span class="section-title mt-4">İlan Galerisi</span>
                            <div class="photo card py-2 px-5">
                                <input type="file" multiple name="project-images" accept="image/*" class="project_image d-none">
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
                                    @if(isset($formData->images) && $formData->images)
                                        @foreach($formData->images as $image)
                                            <div class="project_imagex"  order="{{$image}}">
                                                <img src="{{ asset('housing_images/' . $image) }}" alt="">
                                                <div class="image-buttons">
                                                    <i class="fa fa-trash"></i>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
        integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/assets/js/moment.min.js"
        integrity="sha512-CryKbMe7sjSCDPl18jtJI5DR5jtkUWxPXWaLCst6QjH8wxDexfRJic2WRmRXmstr2Y8SxDDWuBO6CQC6IE4KTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ URL::to('/') }}/adminassets/assets/js/jquery.daterangepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
        integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        
        var csrfToken = $("meta[name='csrf-token']").attr("content");
        $('.project_imagex .image-buttons').click(function(){
            var thisx = $(this);
            $.ajax({
                url: '{{route("institutional.housing.image.delete",$housing->id)}}',
                type: 'POST',
                data: { 
                    image: $(this).closest('.project_imagex').attr('order') ,
                    item_type : 2,
                    _token : csrfToken
                },
                success: function(response) {
                    thisx.closest('.project_imagex').remove()
                    $.toast({
                        heading: 'Başarılı',
                        text: 'Başarıyla resimi kaldırdınız',
                        position: 'top-right',
                        stack: false
                    })
                },
                error: function(xhr, status, error) {
                    console.error("Ajax isteği sırasında bir hata oluştu: " + error);
                }
            });
        })

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
                    url: '{{route("institutional.housing.update.orders",$housing->id)}}',
                    type: 'POST',
                    data: { 
                        images: ids ,
                        item_type : 2,
                        _token : csrfToken
                    },
                    success: function(response) {
                        $.toast({
                            heading: 'Başarılı',
                            text: 'Başarıyla sıralamayı güncellediniz',
                            position: 'top-right',
                            stack: false
                        })
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

        
        $('.project_image').change(function() {
            var input = this;

            if (input.files && input.files[0]) {
                $('.photo-area').removeClass('error-border')

                var formData = new FormData();
                var csrfToken = $("meta[name='csrf-token']").attr("content");
                formData.append('_token', csrfToken);
                formData.append('item_type',2);
                for (let i = 0; i < this.files.length; i++) {
                    formData.append(`file${i}`, this.files[i]);
                }
                $.ajax({
                    type: "POST",
                    url: "{{route('institutional.housing.image.add',$housing->id)}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $.toast({
                            heading: 'Başarılı',
                            text: 'Başarıyla yeni resim eklediniz',
                            position: 'top-right',
                            stack: false
                        })
                        for (let i = 0; i < response.length; i++) {
                            var imageDiv = $('<div class="project_imagex" order="'+response[i]+'"></div>');
                            var image = $('<img>').attr('src', '{{URL::to('/')}}/housing_images/'+response[i]);
                            var imageButtons = $('<div>').attr('class','image-buttons');
                            var imageButtonsIcon = $('<i>').attr('class','fa fa-trash');
                            imageButtons.append(imageButtonsIcon)
                            imageDiv.append(image);
                            imageDiv.append(imageButtons);
                            $('.photos').append(imageDiv);

                            $('.project_imagex .image-buttons').click(function(){
                                var thisx = $(this);
                                $.ajax({
                                    url: '{{route("institutional.housing.image.delete",$housing->id)}}',
                                    type: 'POST',
                                    data: { 
                                        image: $(this).closest('.project_imagex').attr('order') ,
                                        item_type : 2,
                                        _token : csrfToken
                                    },
                                    success: function(response) {
                                        thisx.closest('.project_imagex').remove()
                                        $.toast({
                                            heading: 'Başarılı',
                                            text: 'Başarıyla resimi kaldırdınız',
                                            position: 'top-right',
                                            stack: false
                                        })
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

        
        $('.photo-area').click(function() {
            $('.project_image.d-none').trigger('click');
        })

        $('.cover-photo-area').click(function() {
            $('.cover_image.d-none').trigger('click');
        })

        $('.cover_image').change(function() {
            var input = this;

            if (input.files && input.files[0]) {
                $('.cover-photo-area').removeClass('error-border')
                var reader = new FileReader();

                var formData = new FormData();
                var csrfToken = $("meta[name='csrf-token']").attr("content");
                formData.append('_token', csrfToken);
                formData.append('image', this.files[0]);
                formData.append('item_type', 2);
                $.ajax({
                    type: "POST",
                    url: "{{ route('institutional.housing.change.cover.image',$housing->id) }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $.toast({
                            heading: 'Başarılı',
                            text: 'Başarıyla kapak fotoğrafını güncellediniz',
                            position: 'top-right',
                            stack: false
                        })
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
        
    </script>
    @stack('scripts')
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css"
        integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/assets/css/daterangepicker.css">
@endsection
