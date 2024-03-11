@extends('admin.layouts.master')

@section('content')

    <div class="content">

        <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
                <div class="card-body position-relative">
                    <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4"><span class="fw-bold">İlan No:
                            {{ $housing->id + 2000000 }}</span><svg class="svg-inline--fa fa-award ms-1" aria-hidden="true"
                            focusable="false" data-prefix="fas" data-icon="award" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                d="M288 358.3c13.98-8.088 17.53-30.04 28.88-41.39c11.35-11.35 33.3-14.88 41.39-28.87c7.98-13.79 .1658-34.54 4.373-50.29C366.7 222.5 383.1 208.5 383.1 192c0-16.5-17.27-30.52-21.34-45.73c-4.207-15.75 3.612-36.5-4.365-50.29c-8.086-13.98-30.03-17.52-41.38-28.87c-11.35-11.35-14.89-33.3-28.87-41.39c-13.79-7.979-34.54-.1637-50.29-4.375C222.5 17.27 208.5 0 192 0C175.5 0 161.5 17.27 146.3 21.34C130.5 25.54 109.8 17.73 95.98 25.7C82 33.79 78.46 55.74 67.11 67.08C55.77 78.43 33.81 81.97 25.72 95.95C17.74 109.7 25.56 130.5 21.35 146.2C17.27 161.5 .0008 175.5 .0008 192c0 16.5 17.27 30.52 21.34 45.73c4.207 15.75-3.615 36.5 4.361 50.29C33.8 302 55.74 305.5 67.08 316.9c11.35 11.35 14.89 33.3 28.88 41.4c13.79 7.979 34.53 .1582 50.28 4.369C161.5 366.7 175.5 384 192 384c16.5 0 30.52-17.27 45.74-21.34C253.5 358.5 274.2 366.3 288 358.3zM112 192c0-44.27 35.81-80 80-80s80 35.73 80 80c0 44.17-35.81 80-80 80S112 236.2 112 192zM1.719 433.2c-3.25 8.188-1.781 17.48 3.875 24.25c5.656 6.75 14.53 9.898 23.12 8.148l45.19-9.035l21.43 42.27C99.46 507 107.6 512 116.7 512c.3438 0 .6641-.0117 1.008-.0273c9.5-.375 17.65-6.082 21.24-14.88l33.58-82.08c-53.71-4.639-102-28.12-138.2-63.95L1.719 433.2zM349.6 351.1c-36.15 35.83-84.45 59.31-138.2 63.95l33.58 82.08c3.594 8.797 11.74 14.5 21.24 14.88C266.6 511.1 266.1 512 267.3 512c9.094 0 17.23-4.973 21.35-13.14l21.43-42.28l45.19 9.035c8.594 1.75 17.47-1.398 23.12-8.148c5.656-6.766 7.125-16.06 3.875-24.25L349.6 351.1z">
                            </path>
                        </svg><!-- <span class="fa-solid fa-award ms-1"></span> Font Awesome fontawesome.com --></div>
                    <h3 class="mb-5">{{ $housing->title }}</h3>
                </div>
            </div>
            <div class="col-auto">
                @if ($housing->status == 1)
                    <a href="{{ route('admin.housings.set.status', $housing->id) }}" project_id="{{ $housing->id }}"
                        class="btn btn-danger set_status">Pasife Al</a>
                    <a href="{{ route('admin.housings.set.status', $housing->id) }}"
                        class="btn btn-danger reject">Reddet</a>
                @elseif($housing->status == 2)
                    <a href="{{ route('admin.housings.set.status', $housing->id) }}"
                        class="btn btn-success set_status">Onayla</a>
                    <a href="{{ route('admin.housings.set.status', $housing->id) }}"
                        class="btn btn-danger reject">Reddet</a>
                @elseif($housing->status == 3)
                    <span class="btn btn-info show-reason">Sebebini Gör</span>
                    <a href="#" class="btn btn-success confirm_rejected_after">Önceden Reddedilmiş Bir Proje Onaya
                        Al</a>
                    <a href="#" class="btn btn-danger reject">Tekrar Reddet</a>
                @else
                    <a href="{{ route('admin.housings.set.status', $housing->id) }}"
                        class="btn btn-success set_status">Aktife Al</a>
                @endif
                <a class="btn btn-primary mb-2 mb-sm-0 download_document"
                    href="{{ URL::to('/') }}/housing_documents/{{ $housing->document }}" download>Emlak Belgesini İndir</a>
            </div>
        </div>
        <div class="row g-5">
            <div class="col-12 col-xl-8">
                <div class="mb-6">
                    <div class="card p-3 scrollbar to-do-list-body" style="height: 500px; overflow-y:scroll">
                        {!! $housing->description !!}
                    </div>
                </div>
                <h4 class="mb-3">Emlak Kapak Fotoğrafı</h4>
                <div>
                    <img style="width:150px;" class="mb-5" src="{{ asset('housing_images/' . $housingData->image) }}"
                        alt="">
                </div>
                <h4 class="mb-3">Emlak Görselleri</h4>
                <div class="images owl-carousel mb-4">
                    @foreach ($housingData->images as $key => $image)
                        <img src="{{ asset('housing_images/' . $housingData->image) }}" class="img-fluid"
                            alt="slider-listing">
                    @endforeach
                </div>


            </div>
            <div class="col-12 col-xl-4">
                <div class="row g-2">
                    <div class="col-12 col-xl-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Genel Bilgiler</h4>
                                <table class="table">
                                    <tbody class="trTableFlex">
                                        <tr>
                                            <td>
                                                <span> İlan No :</span>
                                                <span class="det" style="color:#274abb;">
                                                    {{ $housing->id + 2000000 }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                {!! 'İl-İlçe' .
                                                optional($housing->neighborhood)->mahalle_title ?
                                                '-Mahalle:' : ":"!!}
                                                <span class="det">
                                                    {!! optional($housing->city)->title .
                                                        ' / ' .
                                                        optional($housing->county)->title .
                                                        ' / ' .
                                                        optional($housing->neighborhood)->mahalle_title ??
                                                        '' !!}
                                                </span>
                                            </td>

                                        </tr>

                                        @if ($housing->user->phone)
                                            <tr>
                                                <td>
                                                    Telefon :
                                                    <span class="det">
                                                        <a style="text-decoration: none;color:inherit"
                                                            href="tel:{!! $housing->user->phone !!}">{!! $housing->user->phone !!}</a>
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($housing->user->mobile_phone)
                                        <tr>
                                            <td>
                                                Telefon :
                                                <span class="det">
                                                    <a style="text-decoration: none;color:inherit"
                                                        href="tel:{!! $housing->user->mobile_phone !!}">{!! $housing->user->mobile_phone !!}</a>
                                                </span>
                                            </td>
                                        </tr>
                                    @endif

                                        <tr>
                                            <td>
                                                Proje Tipi :
                                                <span class="det">
                                                    @if ($housing->step1_slug)
                                                        @if ($housing->step2_slug)
                                                            @if ($housing->step2_slug == 'kiralik')
                                                                Kiralık
                                                            @elseif ($housing->step2_slug == 'satilik')
                                                                Satılık
                                                            @else
                                                                Günlük Kiralık
                                                            @endif
                                                        @endif
                                                        {{ $parent->title }}
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                E-Posta :
                                                <span class="det">
                                                    <a style="text-decoration: none;color:inherit"
                                                        href="mailto:{!! $housing->user->email !!}">{!! $housing->user->email !!}</a>
                                                </span>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="rendered-area card p-5">
                <h4 class="mb-3">Daire Bilgileri</h4>
                <div class="row g-0 border-top border-bottom border-300">

                    <div class="col-sm-12">
                        <div class="tab-content py-3  h-100">
                            @for ($i = 0; $i < 1; $i++)
                                <div class="tab-pane fade show @if ($i == 0) active @endif"
                                    id="TabContent{{ $i }}" role="tabpanel">
                                    @foreach ($housingTypeData as $key => $housingType)
                                        @if ($housingType->type != 'file' && isset($housingType->name))
                                            @if ($housingType->type == 'checkbox-group')
                                                @if (isset($housingData->{str_replace('[]', '', $housingType->name) . ($i + 1)}))
                                                    @if ($housingData->{str_replace('[]', '', $housingType->name) . ($i + 1)} != 'payment-data')
                                                        <div class="view-form-json mt-4">
                                                            <label for="" style="font-weight: bold;">{{ $housingType->label }}</label>
                                                            @foreach ($housingData->{str_replace('[]', '', $housingType->name) . ($i + 1)} as $checkboxItem)
                                                                <p class="mb-1">
                                                                    {{ is_array($checkboxItem) ? implode(',',$checkboxItem) : $checkboxItem }}
                                                                </p>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @endif
                                            @else
                                                <div class="view-form-json">
                                                    @if (isset($housingData->{str_replace('[]', '', $housingType->name)}))
                                                        <label for=""
                                                            style="font-weight: bold;">{!! $housingType->label !!}</label>

                                                        <p>{!! $housingData->{str_replace('[]', '', $housingType->name)}[0] !!}</p>
                                                    @endif
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
                    items: 3
                },
                1000: {
                    items: 2
                },
                1600: {
                    items: 3
                }
            }
        })

        $('.set_status').click(function(e) {
            e.preventDefault();
            var projectId = $(this).attr('project_id');
            Swal.fire({
                @if ($housing->status)
                    title: 'Aktife almak istediğine emin misin?',
                @else
                    title: 'Aktife almak istediğine emin misin?',
                @endif
                showCancelButton: true,
                confirmButtonText: 'Evet',
                denyButtonText: `İptal`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.location.href = "{{ route('admin.housings.set.status.get', $housing->id) }}"
                }
            })
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
                title: 'Emlağı reddetmek istediğine emin misin ?',
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
                        url: '{{ route('admin.housings.set.status', $housing->id) }}', // Hedef URL
                        data: data, // Gönderilecek veriler
                        success: function(response) {
                            response = JSON.parse(response);
                            if (response.status) {
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

            $('.change-default-text').change(function() {
                $('.reason').val($(this).val());
            })
        })

        $('.confirm_rejected_after').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Emlağı onaylamak istediğine emin misin ?',
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
                        url: '{{ route('admin.housings.set.status', $housing->id) }}', // Hedef URL
                        data: data, // Gönderilecek veriler
                        success: function(response) {
                            response = JSON.parse(response);
                            if (response.status) {
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
        @if ($housing->status == 3)
            $('.show-reason').click(function() {
                Swal.fire({
                    title: 'Reddilme sebebi',
                    showCancelButton: false,
                    confirmButtonText: 'Tamam',
                    html: '{{ $housing->rejectedLog->reason }}',
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

        .trTableFlex tr td {
            display: flex;
            justify-content: space-between
        }
    </style>
@endsection
