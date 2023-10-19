@extends('admin.layouts.master')

@section('content')

<div class="content">

      <div class="row g-3 flex-between-end mb-5">
        <div class="col-auto">
          <h2 class="mb-2">{{$housing->title}}</h2>
        </div>
        <div class="col-auto">
            @if($housing->status == 1)
                <a href="{{route('admin.housings.set.status',$housing->id)}}" project_id="{{$housing->id}}" class="btn btn-danger set_status">Pasife Al</a>
                <a href="{{route('admin.housings.set.status',$housing->id)}}" class="btn btn-danger reject">Reddet</a>
            @elseif($housing->status == 2)
              <a href="{{route('admin.housings.set.status',$housing->id)}}" class="btn btn-success set_status">Onayla</a>
              <a href="{{route('admin.housings.set.status',$housing->id)}}" class="btn btn-danger reject">Reddet</a>
              @elseif($housing->status == 3)
                <span class="btn btn-info show-reason">Sebebini Gör</span>
                <a href="#" class="btn btn-success confirm_rejected_after">Önceden Reddedilmiş Bir Proje Onaya Al</a>
                <a href="#" class="btn btn-danger reject">Tekrar Reddet</a>
            @else
                <a href="{{route('admin.housings.set.status',$housing->id)}}" class="btn btn-success set_status">Aktife Al</a>
            @endif
            <a class="btn btn-primary mb-2 mb-sm-0 download_document" href="{{URL::to('/')}}/housing_documents/{{$housing->document}}" download>Emlak Belgesini İndir</a></div>
      </div>
      <div class="row g-5">
        <div class="col-12 col-xl-8">
          <h4 class="mb-3">Emlak Adı</h4>
          <p>{{$housing->title}}</p>
          <div class="mb-6">
            <h4 class="mb-3">Emlak Açıklaması</h4>
            <div>
                {!! $housing->description !!}
            </div>
          </div>
          <h4 class="mb-3">Emlak Kapak Fotoğrafı</h4>
          <div>
            <img style="width:150px;" class="mb-5" src="{{asset('housing_images/' . $housingData->image)}}" alt="">
          </div>
          <h4 class="mb-3">Emlak Görselleri</h4>
          <div class="images owl-carousel mb-4">
            @foreach($housingData->images as $key=> $image)
                    <img src="{{asset('housing_images/' . $housingData->image)}}"
                        class="img-fluid" alt="slider-listing">
            @endforeach
          </div>

            <div class="rendered-area">
                <h4 class="mb-3">Daire Bilgileri</h4>
                    <div class="row g-0 border-top border-bottom border-300">
                    
                    <div class="col-sm-12">
                        <div class="tab-content py-3  h-100">
                            @for($i = 0; $i <1; $i++)
                            <div class="tab-pane fade show @if($i == 0) active @endif" id="TabContent{{$i}}" role="tabpanel">
                                @foreach($housingTypeData as $housingType)
                                    @if($housingType->type != "file" && isset($housingType->name))
                                        @if($housingType->type == "checkbox-group")
                                            <div class="view-form-json mt-4">
                                                <label for="" style="font-weight: bold;">{{$housingType->label}}</label>
                                                @foreach($housingData->{str_replace("[]","",$housingType->name)} as $checkboxItem)
                                                <p class="mb-1">{{$checkboxItem}}</p>
                                                @endforeach
                                            </div>
                                        @else 
                                            <div class="view-form-json">
                                                <label for="" style="font-weight: bold;">{{$housingType->label}}</label>
                                                <p>{!! $housingData->{str_replace("[]","",$housingType->name)}[0] !!}</p>
                                            </div>
                                        @endif 
                                    @endif
                                @endforeach
                            </div>
                            @endfor
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
                            <h5 class="mb-0 text-1000 me-2">Konut Tipi</h5>
                          </div>
                          <p>{{$housing->housing_type->title}}</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-12">
                      <div class="mb-4">
                        <div class="d-flex flex-wrap mb-2">
                          <h5 class="mb-0 text-1000 me-2">Emlak Statüleri</h5>
                        </div>
                        @foreach($housing->housingStatus as $housingStatue)
                            <p class="mb-2">{{$housingStatue->housingStatus->name}}</p>
                        @endforeach
                      </div>
                  </div>
                    <div class="col-12 col-sm-6 col-xl-12">
                      <div class="mb-4">
                          <div class="d-flex flex-wrap mb-2">
                              <h5 class="mb-0 text-1000 me-2">Şehir</h5>
                          </div>
                          <div class="col-md-12">
                              <p>{{$housing->city->title}}</p>
                          </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-12">
                      <div class="mb-4">
                          <div class="d-flex flex-wrap mb-2">
                              <h5 class="mb-0 text-1000 me-2">İlçe</h5>
                          </div>
                          <div class="col-md-12">
                            {{$housing->county->ilce_title}}
                          </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-12">
                        <div class="mb-4">
                          <div class="d-flex flex-wrap mb-2">
                            <h5 class="mb-0 text-1000 me-2">Adresini Yazınız</h5>
                          </div>
                          <p>{{$housing->address}}</p>
                        </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.owl-carousel').owlCarousel({
            loop:true,
            nav:true,
            margin:10,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:2
                },
                1600 : {
                    items:3
                }
            }
        })

        $('.set_status').click(function(e){
            e.preventDefault();
            var projectId = $(this).attr('project_id');
            Swal.fire({
                @if($housing->status)
                    title: 'Pasife almak istediğine emin misin?',
                @else 
                    title: 'Aktife almak istediğine emin misin?',
                @endif
                showCancelButton: true,
                confirmButtonText: 'Evet',
                denyButtonText: `İptal`,
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.location.href="{{route('admin.housings.set.status.get',$housing->id)}}"
                }
            })
        })
        var defaultMessagesItems = @json($defaultMessages);
        console.log(defaultMessagesItems[0].title);
        function defaultMessages(){
          var messages = "<div class='mb-2'><label style='text-align:left;width:100%;'>Örnek Mesajlardan Seç</label><select class='form-control change-default-text'><option value=''>Seç</option>";
            for(var i = 0 ; i < defaultMessagesItems.length; i++){
              messages += '<option value="'+defaultMessagesItems[i].content+'">'+defaultMessagesItems[i].title+'-'+defaultMessagesItems[i].content+'</option>'
            }
          messages += "</select></div>";

          return messages;
        }
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('.reject').click(function(e){
            e.preventDefault();
            Swal.fire({
              title : 'Emlağı reddetmek istediğine emin misin ?',
              showCancelButton: true,
              confirmButtonText: 'Evet',
              denyButtonText: `İptal`,
              html : defaultMessages()+"<div><input class='form-control reason' placeholder='Neden reddediyorsun'></div>",
              }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                var data = {
                    _token: csrfToken, // CSRF tokeni ekle
                    reason: $('.reason').val(),
                    status: 3
                };

                // Ajax isteği oluştur
                $.ajax({
                    type: 'POST', // Veri gönderme yöntemi (POST)
                    url: '{{ route("admin.housings.set.status", $housing->id) }}', // Hedef URL
                    data: data, // Gönderilecek veriler
                    success: function(response) {
                      response = JSON.parse(response);
                      if(response.status){
                        $.toast({
                          heading: 'Başarılı',
                          text: 'Başarıyla emlağı reddetiniz',
                          position: 'top-right',
                          stack: false
                        })
                      }
                    },
                    error: function(xhr, status, error) {
                        // Hata durumunda burada işlemleri gerçekleştirin
                        console.error('İstek sırasında bir hata oluştu.');
                        console.error('Hata detayı:', error);
                    }
                });
              }
            })

          $('.change-default-text').change(function(){
            $('.reason').val($(this).val());
          })
        })

        $('.confirm_rejected_after').click(function(e){
            e.preventDefault();
            Swal.fire({
            title : 'Emlağı onaylamak istediğine emin misin ?',
            showCancelButton: true,
            confirmButtonText: 'Evet',
            denyButtonText: `İptal`,
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              var data = {
                  _token: csrfToken, // CSRF tokeni ekle
                  reason: "",
                  status: 1
              };

              // Ajax isteği oluştur
              $.ajax({
                  type: 'POST', // Veri gönderme yöntemi (POST)
                  url: '{{ route("admin.housings.set.status", $housing->id) }}', // Hedef URL
                  data: data, // Gönderilecek veriler
                  success: function(response) {
                    response = JSON.parse(response);
                    if(response.status){
                      $.toast({
                        heading: 'Başarılı',
                        text: 'Başarıyla emlağı aktife aldınız',
                        position: 'top-right',
                        stack: false
                      })
                    }
                  },
                  error: function(xhr, status, error) {
                      // Hata durumunda burada işlemleri gerçekleştirin
                      console.error('İstek sırasında bir hata oluştu.');
                      console.error('Hata detayı:', error);
                  }
              });
            }
          })
        })
        @if($housing->status == 3)
          $('.show-reason').click(function(){
            Swal.fire({
              title : 'Reddilme sebebi',
              showCancelButton: false,
              confirmButtonText: 'Tamam',
              html : '{{$housing->rejectedLog->reason}}',
            })
          })
        @endif
    </script>
    
    
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.css"/>
<link href="https://cdn.jsdelivr.net/npm/fine-uploader@5.16.2/fine-uploader/fine-uploader-gallery.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css" integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .leaflet-container{
            height: 100%;
        }
    </style>
@endsection
