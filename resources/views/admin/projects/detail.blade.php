@extends('admin.layouts.master')

@section('content')
    @php
        function getData($itemOrder, $key, $housingData)
        {
            foreach ($housingData as $data) {
                if ($data->room_order == $itemOrder && $data->name == $key) {
                    return $data->value;
                }
            }
        }
    @endphp
    <div class="content">

        <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
                <h2 class="mb-2">{{ $project->project_title }}</h2>
            </div>
            <div class="col-auto">
                @if ($project->status == 1)
                    <a href="{{ route('admin.project.set.status', $project->id) }}" project_id="{{ $project->id }}"
                        class="btn btn-danger set_status">Pasife Al</a>
                    <a href="{{ route('admin.project.set.status', $project->id) }}" class="btn btn-danger reject">Reddet</a>
                @elseif($project->status == 2)
                    <a href="{{ route('admin.project.set.status', $project->id) }}"
                        class="btn btn-success set_status">Onayla</a>
                    <a href="{{ route('admin.project.set.status', $project->id) }}" class="btn btn-danger reject">Reddet</a>
                @elseif($project->status == 3)
                    <span class="btn btn-info show-reason">Sebebini Gör</span>
                    <a href="#" class="btn btn-success confirm_rejected_after">Önceden Reddedilmiş Bir Proje Onaya
                        Al</a>
                    <a href="#" class="btn btn-danger reject">Tekrar Reddet</a>
                @else
                    <a href="{{ route('admin.project.set.status', $project->id) }}" class="btn btn-success set_status">Aktife
                        Al</a>
                @endif
                <a class="btn btn-primary mb-2 mb-sm-0 download_document"
                    href="{{ URL::to('/') }}/housing_documents/{{ $project->document }}" download>Proje Belgesini İndir</a>
            </div>
        </div>
        <div class="row g-5">
            <div class="col-12 col-xl-8">
                <h4 class="mb-3">Proje Adı</h4>
                <p>{{ $project->project_title }}</p>
                <div class="mb-6">
                    <h4 class="mb-3">Proje Açıklaması</h4>
                    <div>
                        {!! $project->description !!}
                    </div>
                </div>
                <h4 class="mb-3">Projenin Kapak Fotoğrafı</h4>
                <div>
                    <img style="width:150px;" class="mb-5"
                        src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}" alt="">
                </div>
                <h4 class="mb-3">Proje Görselleri</h4>
                <div class="images owl-carousel mb-4">
                    @foreach ($project->images as $key => $image)
                        <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $image->image) }}"
                            class="img-fluid" alt="slider-listing">
                    @endforeach
                </div>
                <h4 class="mb-3">Emlak Sayısı</h4>
                <p style="font-weight: bold;">{{ $project->room_count }}</p>

                <div class="rendered-area">
                    <h4 class="mb-3">Daire Bilgileri</h4>
                    <div class="row g-0 border-top border-bottom border-300">
                        <div class="col-sm-4">
                            <div id="tablist"
                                class="nav flex-sm-column border-bottom border-bottom-sm-0 border-end-sm border-300 fs--1 vertical-tab h-100 justify-content-between"
                                role="tablist" aria-orientation="vertical">
                                @for ($i = 0; $i < $project->room_count; $i++)
                                    <a class="nav-link border-end border-end-sm-0 border-bottom-sm border-300 text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center @if ($i == 0) active @endif"
                                        id="Tab1" data-bs-toggle="tab" data-bs-target="#TabContent{{ $i }}"
                                        role="tab" aria-controls="TabContent{{ $i }}"
                                        aria-selected="true"><span class="me-sm-2 fs-4 nav-icons"
                                            data-feather="tag"></span><span class="d-none d-sm-inline">{{ $i + 1 }}
                                            Nolu {{ $project->step1_slug }} Bilgileri</span></a>
                                @endfor
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="tab-content py-3 ps-sm-4 h-100">
                                @for ($i = 0; $i < $project->room_count; $i++)
                                    <div class="tab-pane fade show @if ($i == 0) active @endif"
                                        id="TabContent{{ $i }}" role="tabpanel">
                                        @foreach ($housingTypeData as $housingType)
                                            @if ($housingType->type != 'file' && isset($housingType->name))
                                                @if ($housingType->type == 'checkbox-group')
                                                    <div class="view-form-json mt-4">
                                                        <label for=""
                                                            style="font-weight: bold;">{!! $housingType->label !!}</label>
                                                            @foreach (json_decode(getData($i + 1, $housingType->name, $housingData)) as $checkboxItem)
                                                            <p class="mb-1">{{ $checkboxItem }}</p>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="view-form-json">
                                                        <label for=""
                                                            style="font-weight: bold;">{!! $housingType->label !!}</label>
                                                        <p>{{ getData($i + 1, $housingType->name, $housingData) }}</p>
                                                    </div>
                                                @endif
                                            @elseif($housingType->type == 'file')
                                                @if ($housingType->multiple)
                                                @else
                                                    <div class="view-form-json mt-4">
                                                        <img style="width:150px;"
                                                            src="{{ URL::to('/') . '/project_housing_images/' . getData($i + 1, $housingType->name, $housingData) }}"
                                                            alt="">
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
                                            <div class=" mb-2">
                                                <h5 class="mb-0 text-1000 me-2">Marka</h5>
                                                <a style="display: block" href="">{{ $project->user->name }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-xl-12">
                                        <div class="mb-4">
                                            <div class="d-flex flex-wrap mb-2">
                                                <h5 class="mb-0 text-1000 me-2">Konut Tipi</h5>
                                            </div>
                                            <p>{{ $project->housingType->title }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-xl-12">
                                        <div class="mb-4">
                                            <div class="d-flex flex-wrap mb-2">
                                                <h5 class="mb-0 text-1000 me-2">Emlak Statüleri</h5>
                                            </div>
                                            @foreach ($project->housingStatus as $housingStatue)
                                                <p class="mb-2">{{ $housingStatue->housingStatus->name }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-xl-12">
                                        <div class="mb-4">
                                            <div class="d-flex flex-wrap mb-2">
                                                <h5 class="mb-0 text-1000 me-2">Şehir</h5>
                                            </div>
                                            <div class="col-md-12">
                                                <p>{{ $project->city->title }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-xl-12">
                                        <div class="mb-4">
                                            <div class="d-flex flex-wrap mb-2">
                                                <h5 class="mb-0 text-1000 me-2">İlçe</h5>
                                            </div>
                                            <div class="col-md-12">
                                                {{ $project->county->ilce_title }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-xl-12">
                                        <div class="mb-4">
                                            <div class="d-flex flex-wrap mb-2">
                                                <h5 class="mb-0 text-1000 me-2">Adresini Yazınız</h5>
                                            </div>
                                            <p>{{ $project->address }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Emlak Sepette Ödeme Onay Adımı</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="contentx">
                            <div class="invoice-body">
                                <table class="table table-bordered d-none d-md-table"> <!-- Tabloyu sadece tablet ve daha büyük ekranlarda göster -->
                                    <thead>
                                        <tr>
                                            <th>Doping Adı</th>
                                            <th>Kullanıcı</th>
                                            <th>Ödeme Keyi</th>
                                            <th>Ödenen Banka</th>
                                            <th>Ödenen Tutar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($project->dopingOrder as $doping)
                                            <tr>
                                                <td>@if($doping->standOut->housing_type_id == 0) Öne Çıkarılanlar @else Üst Sıradayım @endif</td>
                                                <td>{{$doping->user->name}}</td>
                                                <td>{{$doping->key}}</td>
                                                <td>{{$doping->bank->receipent_full_name}}</td>
                                                <td>{{$doping->price}} ₺</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                    
                                <!-- Mobilde sadece alt alta liste göster -->
                                <div class="d-md-none">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <strong>Ürün Adı:</strong> Doping Ücreti
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Miktar:</strong> 1
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Fiyat:</strong> 2500 ₺
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Toplam:</strong> 2500 ₺
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('admin.project.set.status.get', $project->id) }}"  class="btn btn-primary btn-lg btn-block mb-3" id="completePaymentButton">
                            Ödemeyi Onayla ve Projeyi Aktife Al
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="finalConfirmationModal" tabindex="-1" role="dialog"
            aria-labelledby="finalConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="finalConfirmationModalLabel">Ödeme Onayı</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Ödemeniz başarıyla tamamlamak için lütfen aşağıdaki adımları takip edin:</p>
                        <ol>
                            <li>
                                <strong style="color:red" id="uniqueCodeRetry"></strong> kodunu EFT/Havale açıklama
                                alanına yazdığınızdan emin olun.
                            </li>
                            <li>
                                Son olarak, işlemi bitirmek için aşağıdaki butona tıklayın: <br>
                                <button type="submit" class="btn btn-primary without-doping mt-3">Ödemeyi Tamamla
                                    <svg viewBox="0 0 576 512" style="width: 16px;color: #fff;fill: #fff;" class="svgIcon">
                                        <path
                                            d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24H360c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z">
                                        </path>
                                    </svg></button>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
        integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.owl-carousel').owlCarousel({
            loop: true,
            nav: true,
            margin: 10,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 2
                }
            }
        })

        $('.set_status').click(function(e) {
            e.preventDefault();
            @if($project->confirmDopingOrder)
                $('#paymentModal').addClass('show')
                $('#paymentModal').css('display','block')
                
            @else
                var projectId = $(this).attr('project_id');
                Swal.fire({
                    @if ($project->status != 1)
                        title: 'Aktife almak istediğine emin misin?',
                    @else
                        title: 'Pasife almak istediğine emin misin?',
                    @endif
                    showCancelButton: true,
                    confirmButtonText: 'Evet',
                    denyButtonText: `İptal`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('admin.project.set.status.get', $project->id) }}"
                    }
                })
            @endif
        })
        var defaultMessagesItems = @json($defaultMessages);
        console.log(defaultMessagesItems[0].title);

        function defaultMessages() {
            var messages =
                "<div class='mb-2'><label style='text-align:left;width:100%;'>Örnek Mesajlardan Seç</label><select class='form-control change-default-text'><option value=''>Seç</option>";
            for (var i = 0; i < defaultMessagesItems.length; i++) {
                messages += '<option value="' + defaultMessagesItems[i].content + '">' + defaultMessagesItems[i].title +
                    '-' + defaultMessagesItems[i].content + '</option>'
            }
            messages += "</select></div>";

            return messages;
        }
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('.reject').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Projeyi reddetmek istediğine emin misin ?',
                showCancelButton: true,
                confirmButtonText: 'Evet',
                denyButtonText: `İptal`,
                html: defaultMessages() +
                    "<div><input class='form-control reason' placeholder='Neden reddediyorsun'></div>",
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
                        url: '{{ route('admin.project.set.status', $project->id) }}', // Hedef URL
                        data: data, // Gönderilecek veriler
                        success: function(response) {
                            response = JSON.parse(response);
                            if (response.status) {
                                $.toast({
                                    heading: 'Başarılı',
                                    text: 'Başarıyla projeyi reddetiniz',
                                    position: 'top-right',
                                    stack: false
                                });
                                location.reload();

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

            $('.change-default-text').change(function() {
                $('.reason').val($(this).val());
            })
        })

        $('.confirm_rejected_after').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Projeyi onaylamak istediğine emin misin ?',
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
                        url: '{{ route('admin.project.set.status', $project->id) }}', // Hedef URL
                        data: data, // Gönderilecek veriler
                        success: function(response) {
                            response = JSON.parse(response);
                            if (response.status) {
                                $.toast({
                                    heading: 'Başarılı',
                                    text: 'Başarıyla projeyi aktife aldınız',
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
        @if ($project->status == 3)
            $('.show-reason').click(function() {
                Swal.fire({
                    title: 'Reddilme sebebi',
                    showCancelButton: false,
                    confirmButtonText: 'Tamam',
                    html: '{{ $project->rejectedLog->reason }}',
                })
            })
        @endif
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css"
        integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.css" />
    <link href="https://cdn.jsdelivr.net/npm/fine-uploader@5.16.2/fine-uploader/fine-uploader-gallery.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css"
        integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .leaflet-container {
            height: 100%;
        }
    </style>
@endsection
