@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Konut Ekle</h2>
        <div class="mt-4">
            <div class="row g-4">
                <div class="col-12 col-xl-12 order-1 order-xl-0">
                    <div class="mb-9">
                        <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
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
                                        action="{{ route('institutional.housing.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-md-12">
                                            <label class="form-label" for="validationCustom01">Projenin size ait olduğuna dair belge</label>
                                            <input name="document" class="form-control" id="validationCustom01"
                                                type="file" value="" required="">
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom01">Başlık</label>
                                            <input name="title" class="form-control" id="validationCustom01"
                                                type="text" value="" required="">
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom01">Hangi Marka Adına Ekliyorsun</label>
                                            <select name="brand_id" class="form-control" id="">
                                                @foreach($brands as $brand)
                                                    <option value="{{$brand->id}}">{{$brand->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom01">Şehir</label>
                                            <select name="city_id" class="form-control" id="cities">
                                                @foreach($cities as $city)
                                                    <option value="{{$city->id}}">{{$city->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom01">İlçe</label>
                                            <select name="county_id" class="form-control" id="counties">
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="address">Adres</label>
                                            <textarea class="form-control" id="address" name="address" rows="3"> </textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="description">Açıklama</label>
                                            <textarea class="form-control" id="description" name="description" rows="3"> </textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="status">Durum</label>
                                            <select name="status" id="status" class="form-select"
                                                aria-label="Default select example">
                                                <option selected="">Konut durumunu seçiniz:</option>
                                                @foreach ($housing_status as $status)
                                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Daire Türünü Seçiniz</label>
                                            <select name="housing_type" id="housing_type" class="form-select"
                                                aria-label="Default select example">
                                                <option selected="">Daire Türünü Seçiniz:</option>
                                                @foreach ($housing_types as $type)
                                                    <option value="{{ $type->id }}">{{ $type->title }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="location">Konum:</label>
                                            <input name="location" class="form-control" id="location" readonly type="hidden"
                                                value="39.1667,35.6667" />
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
        <footer class="footer position-absolute">
            <div class="row g-0 justify-content-between align-items-center h-100">
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 mt-2 mt-sm-0 text-900">Thank you for creating with Phoenix<span
                            class="d-none d-sm-inline-block"></span><span
                            class="d-none d-sm-inline-block mx-1">|</span><br class="d-sm-none" />2023 &copy;<a
                            class="mx-1" href="https://themewagon.com/">Themewagon</a>
                    </p>
                </div>
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 text-600">v1.13.0</p>
                </div>
            </div>
        </footer>
    </div>
@endsection
@section('scripts')
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
    </script>
    @stack('scripts')
@endsection
