@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">İletişim Ayarları</h2>
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
                                        action="{{ route('admin.info.contact.set') }}" enctype="multipart/form-data">
                                        @csrf


                                        <div class="col-md-6">
                                            <label class="form-label" for="email">Email</label>
                                            <input name="email" class="form-control" id="email" type="text"
                                                value="{{ $contactInfo->email }}" required="">
                                            <div class="valid-feedback">İyi Görünüyor !</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="phone">Telefon</label>
                                            <input name="phone" class="form-control" id="phone" type="text"
                                                value="{{ $contactInfo->phone }}" required="" maxlength="10">
                                                <span id="error_message" class="error-message"></span>
                                            <div class="valid-feedback">İyi Görünüyor !</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="working_time">Çalışma zamanı(09:00-17:00)</label>
                                            <input name="working_time" class="form-control" id="working_time" type="text"
                                                value="{{ $contactInfo->working_time }}" required="">
                                            <div class="valid-feedback">İyi Görünüyor !</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="address">Adres</label>
                                            <textarea class="form-control" id="address" name="address" rows="3">{{ $contactInfo->address }}</textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="location">Konum:</label>
                                            <input name="location" class="form-control" id="location" readonly
                                                type="text" value="{{ $contactInfo->location }}" />
                                            <div id="mapContainer"></div>

                                        </div>

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
                    <div class="toast-body p-3"></div><button class="btn-close btn-close-white me-2 m-auto" type="button"
                        data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

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
        })
    </script>
     <script>
        $(document).ready(function(){
            $("#phone").on("input blur", function(){
            var phoneNumber = $(this).val();
            var pattern = /^5[0-9]\d{8}$/;
        
            if (!pattern.test(phoneNumber)) {
              $("#error_message").text("Lütfen geçerli bir telefon numarası giriniz.");
            } else {
              $("#error_message").text("");
            }

                 // Kullanıcı 10 haneden fazla veri girdiğinde bu kontrol edilir
                 $('#phone').on('keypress', function (e) {
                        var max_length = 10;
                        // Eğer giriş karakter sayısı 10'a ulaştıysa ve yeni karakter ekleme işlemi değilse
                        if ($(this).val().length >= max_length && e.which != 8 && e.which != 0) {
                            // Olayın işlenmesini durdur
                            e.preventDefault();
                        }
                    });
          });
        });
        </script>
@endsection

@section('styles')
    <style>
        .error-message {
            color: #e54242;
            font-size: 11px;
        }
    </style>
@endsection