@extends('client.layouts.masterPanel')

@section('content')
    @php
        $months = [
            'Ocak',
            'Şubat',
            'Mart',
            'Nisan',
            'Mayıs',
            'Haziran',
            'Temmuz',
            'Ağustos',
            'Eylül',
            'Ekim',
            'Kasım',
            'Aralık',
        ];
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="table-breadcrumb">
            <ul>
                <li><i class="fa fa-home"></i> {{ $userType = Auth::user()->type == 1 ? 'Hesabım' : 'Mağazam' }}</li>
                <li>Rezervasyonlar</li>
                <li>Tüm Rezervasyonlar</li>
                <li>#{{ $order->key }} Nolu Rezervasyon Detayı</li>

            </ul>
        </div>

    </div>

    <div class="row g-5 gy-7">
        <div class="col-12 col-xl-8 col-xxl-9">
            <div class="order-detail-content">
                <div class="order-details mb-3">
                    <div class="order-header">

                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="#000000" stroke-width="2"
                            fill="#000000" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>

                        <h3 style="margin-left: 10px">#{{ $order->key }} Nolu Rezervasyon Durumu</h3>
                    </div>

                    <div class="order-status">
                        <div class="status">
                            <p>
                                @if ($order->refund != null)
                                    @switch($order->refund->status)
                                        @case(2)
                                            İADE TALEBİ REDDEDİLDİ
                                        @break

                                        @case(1)
                                            REZERVASYON REDDEDİLDİ
                                        @break

                                        @case(3)
                                            İADE TALEBİ İÇİN GERİ ÖDEME YAPILDI
                                        @break

                                        @default
                                            İADE TALEBİ İÇİN ONAY BEKLENİYOR
                                    @endswitch
                                @else
                                    @switch($order->status)
                                        @case(2)
                                            REZERVASYON REDDEDİLDİ
                                        @break

                                        @case(1)
                                            REZERVASYON ONAYLANDI
                                        @break

                                        @default
                                            ÖDEME ONAYI BEKLENİYOR
                                    @endswitch
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>



            <div class="order-item mb-3">
                <div class="order-item-header">
                    <div class="order-item-title">
                        <h5>Rezervasyon Yapılan İlan
                        </h5>

                    </div>
                </div>
                <div class="order-item-body">

                    <img src="{{ asset('housing_images/' . json_decode($order->housing->housing_type_data)->image ?? null) }}"
                        style="object-fit: cover;width:100px;height:75px" alt="">


                    <div class="order-item-details">
                        <h5><strong>{{ $order->housing->title }}</strong></h5>
                        <span class="badge badge-danger">İlan No:
                            {{ $order->housing->id + 2000000 }}</span>
                    </div>

                    <div class="order-item-quantity">
                        <p class="text-muted">
                            {{ number_format($order->price, 0, ',', '.') }}₺</p>
                    </div>

                </div>
                <div class="order-item-footer">

                    @php
                        $storeImage = null;
                        $initial = null;
                        $userName = null;
                        if ($order->housing->user->profile_image) {
                            $storeImage = url('storage/profile_images/' . $order->housing->user->profile_image);
                        } else {
                            $initial = $order->housing->user->name
                                ? strtoupper(substr($order->housing->user->name, 0, 1))
                                : '';
                        }
                        $userName = $order->housing->user->name;

                    @endphp

                    <div class="avatar avatar-m" style="display: flex;align-items: center;justify-content: center;">
                        @if ($storeImage)
                            <img class="rounded-circle" src="{{ $storeImage }}" alt=""
                                style="width: 20px;height: 20px">
                        @else
                            <span style="width: 20px;height: 20px">{{ $initial }}</span>
                        @endif
                        <p class="text-muted" style="padding-bottom: 0 ; margin-bottom: 0;margin-left: 10px">
                            {{ $userName }}</p>
                    </div>

                    <div>

                        <button class="btn btn-outline-primary">
                            <a
                                href="{{ route('institutional.dashboard', ['slug' => $order->housing->user->name, 'userID' => $order->housing->user->id]) }}">Mağazayı
                                Gör</a>
                        </button>
                        {{-- @if ($order->invoice)
                            <a href="{{ route('institutional.invoice.show', hash_id($order->id)) }}"
                                class="btn btn-primary">Faturayı Görüntüle</a>
                        @endif --}}

                    </div>
                </div>
            </div>
            <div class="order-detail-inner mb-3">
                <div class="title mb-3">
                    <i class="fa fa-shopping-cart"></i>
                    <h4>Sipariş Onaylama Durumu</h4>
                </div>
                <div class="container mt-5">



                    <div class="status-card bg-light-blue">
                        <div class="status-icon text-primary box-shadow-blue ">
                            <i class=""><img class="pay-icon" src="{{ asset('images/template/pay-icon.png') }}"
                                    alt=""></i>
                        </div>
                        @if ($order->status == 0)
                            <div class="status-header">
                                <div class="status-title text-primary">Ödeme Onay Aşamasındadır</div>
                                <div class="status-description">Ödeme şu anda onay aşamasındadır. Sürecin güncel
                                    durumunu ve gelişmeleri buradan takip edebilirsiniz.</div>
                            </div>
                            <div class="status-timestamp">{{ $order->created_at }}</div>
                        @else
                            <div class="status-header">
                                <div class="status-title text-primary">Ödeme İşlemi Tamamlandı</div>
                                <div class="status-description">Ödeme şu an da havuz hesabında. Satıcı ücretini
                                    sipariş
                                    tamamlandığında alacak.</div>
                            </div>
                            <div class="status-timestamp">{{ $order->created_at }}</div>
                        @endif


                    </div>
                    <div class="horizontal-line"></div>



                    @if ($order && $order->status && $order->status == 1)
                        <div class="status-card bg-light-green">
                            <div class="status-icon box-shadow-green text-success">
                                <i class=""><img class="pay-icon" src="{{ asset('images/template/guard-icon.png') }}"
                                        alt=""></i>
                            </div>
                            <div class="status-header">
                                <div class="status-title text-success">Kaporanız Emlak Sepette ile Güvende</div>
                                <div class="status-description">Satıcı satışı gerçekleştirdi. Siparişi inceleyip
                                    onaylamanız
                                    bekleniyor.</div>
                            </div>

                            @if (isset($order->share) && optional($order->share)->status != 1)
                                <div class="approve-button">
                                    <a class="btn btn-success"
                                        href="{{ route('client.approve-reservation', ['reservation' => $order->share->id]) }}"
                                        @if ($order->share->status == 1) disabled @endif>
                                        Onayla</a>
                                    {{-- <button class="btn btn-danger"
                                        onclick="submitFormPriceAndShare('{{ route('client.unapprove-reservation', ['reservation' => $order->share->id]) }}')"
                                        @if ($order->share->status != 1) disabled @endif>Hakedişleri
                                        Reddet</button> --}}

                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">İptal Et</button>
                                </div>
                            @endif



                            @if (isset($order->cartPrice) && optional($order->cartPrice)->status != 1)
                                <div class="approve-button">

                                    <a class="btn btn-success"
                                        href="{{ route('client.approve-price', ['price' => $order->cartPrice->id]) }}"
                                        @if ($order->cartPrice->status == 1) disabled @endif>Onayla
                                    </a>
                                    {{-- <button class="btn btn-danger"
                                        onclick="submitFormPriceAndShare('{{ route('client.unapprove-price', ['price' => $order->price->id]) }}')"
                                        @if ($order->price->status != 1) disabled @endif>Hakedişleri
                                        Reddet</button> --}}
                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">İptal Et</button>
                                </div>
                            @endif
                            <div class="status-timestamp">{{ $order->created_at }}</div>
                        </div>

                        <div class="horizontal-line"></div>

                        @if (($order->share && $order->share->status == 1) || ($order->cartPrice && $order->cartPrice->status == 1))
                            <div class="status-card bg-light">
                                <div class="status-icon text-success box-shadow-light">
                                    <i class=""><img class="pay-icon"
                                            src="{{ asset('images/template/success-icon.png') }}" alt=""></i>
                                </div>
                                <div class="status-header">
                                    <div class="status-title text-success">Siparişiniz Başarıyla Tamamlandı</div>
                                    <div class="status-description">Ödemeniz satıcıya aktarılacak. Satıcı hakkında
                                        değerlendirme
                                        yapabilirsiniz.</div>
                                </div>
                                {{-- <div class="rating">
                                  
                                </div> --}}


                                <div class="status-timestamp">{{ $order->created_at }}</div>
                            </div>

                            <div class="horizontal-line"></div>
                            <div class="accordion" id="accordionPanelsStayOpenExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                            aria-controls="panelsStayOpen-collapseOne">
                                            Yorum Ekle
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                        <div class="accordion-body">

                                            <form id="commentForm" enctype="multipart/form-data" class="mt-5">
                                                @csrf
                                                <input type="hidden" name="rate" id="rate" />

                                                <input type="hidden" name="type" id="type"
                                                    value="housing" />
                                                <input type="hidden" name="id" id="id"
                                                    value="{{ $housing->id }}" />

                                                <div class="d-flex align-items-center w-full" style="gap: 6px;">
                                                    <div class="d-flex rating-area">
                                                        <svg class="rating" enable-background="new 0 0 50 50"
                                                            height="24px" id="Layer_1" version="1.1"
                                                            viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <rect fill="none" height="50" width="50" />
                                                            <polygon fill="none"
                                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                stroke="#000000" stroke-miterlimit="10"
                                                                stroke-width="2" />
                                                        </svg>
                                                        <svg class="rating" enable-background="new 0 0 50 50"
                                                            height="24px" id="Layer_1" version="1.1"
                                                            viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <rect fill="none" height="50" width="50" />
                                                            <polygon fill="none"
                                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                stroke="#000000" stroke-miterlimit="10"
                                                                stroke-width="2" />
                                                        </svg>
                                                        <svg class="rating" enable-background="new 0 0 50 50"
                                                            height="24px" id="Layer_1" version="1.1"
                                                            viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <rect fill="none" height="50" width="50" />
                                                            <polygon fill="none"
                                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                stroke="#000000" stroke-miterlimit="10"
                                                                stroke-width="2" />
                                                        </svg>
                                                        <svg class="rating" enable-background="new 0 0 50 50"
                                                            height="24px" id="Layer_1" version="1.1"
                                                            viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <rect fill="none" height="50" width="50" />
                                                            <polygon fill="none"
                                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                stroke="#000000" stroke-miterlimit="10"
                                                                stroke-width="2" />
                                                        </svg>
                                                        <svg class="rating" enable-background="new 0 0 50 50"
                                                            height="24px" id="Layer_1" version="1.1"
                                                            viewBox="0 0 50 50" width="24px" xml:space="preserve"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <rect fill="none" height="50" width="50" />
                                                            <polygon fill="none"
                                                                points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                                stroke="#000000" stroke-miterlimit="10"
                                                                stroke-width="2" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-auto">
                                                        <input type="file" style="display: none;" class="fileinput"
                                                            name="images[]" multiple accept="image/*" />
                                                        <button type="button" class="btn btn-primary q-button"
                                                            id="selectImageButton">Resimleri Seç</button>
                                                    </div>
                                                </div>
                                                <textarea name="comment" rows="10" class="form-control mt-4" placeholder="Yorum girin..." required></textarea>
                                                <button type="button" class="ud-btn btn-white2 mt-3"
                                                    onclick="submitForm()">Yorumu
                                                    Gönder<i class="fal fa-arrow-right-long"></i></button>
                                                <div id="previewContainer"
                                                    style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;">
                                                </div>

                                            </form>


                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endif
                    @endif
                </div>
            </div>

        </div>
        <div class="col-12 col-xl-4 col-xxl-3">
            <div class="col-12">
                <div class="card mb-3 summary-padding">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Sipariş Özeti</h3>
                        <div>
                            <!-- Ödeme Yöntemi -->
                            <div class="d-flex justify-content-between">
                                <p class="text-body fw-semibold">Ödeme Yöntemi:</p>
                                <p class="text-body-emphasis fw-semibold">
                                    @if ($order->payment_result && $order->payment_result !== '')
                                        Kredi Kartı
                                    @else
                                        EFT/Havale
                                    @endif
                                </p>
                            </div>

                            <!-- İlan Fiyatı -->
                            <div class="d-flex justify-content-between">
                                <p class="text-body fw-semibold">İlan Fiyatı:</p>
                                <p class="text-body-emphasis fw-semibold">
                                    {{ number_format($order->price, 0, ',', '.') }}₺
                                </p>
                            </div>


                            <div class="d-flex justify-content-between">
                                <p class="text-body fw-semibold">Toplam Fiyat:</p>
                                <p class="text-body-emphasis fw-semibold">
                                    {{ number_format($order->total_price, 0, ',', '.') }}₺
                                </p>
                            </div>


                            <div class="d-flex justify-content-between">
                                <p class="text-body fw-semibold">Param Güvende Fiyatı:</p>
                                <p class="text-body-emphasis fw-semibold">
                                    {{ number_format($order->money_is_safe, 0, ',', '.') }}₺
                                </p>
                            </div>


                            <div class="d-flex justify-content-between">
                                <p class="text-body fw-semibold">Ödenen Fiyat:</p>
                                <p class="text-body-emphasis fw-semibold">
                                    {{ number_format($order->total_price / 2 + $order->money_is_safe, 0, ',', '.') }}₺
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Buyer Information -->
                <div class="card mb-3 summary-padding">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Alıcı Bilgileri <img
                                src="https://img.icons8.com/ios-filled/50/EA2A28/verified-account.png" alt="Verified Icon"
                                class="verifiedIcon"></h3>
                        <div class="event">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <img src="{{ $order->user->profile_image && file_exists(public_path('storage/profile_images/' . $order->user->profile_image)) ? url('storage/profile_images/' . $order->user->profile_image) : url('storage/profile_images/indir.png') }}"
                                        alt="Store Image">
                                    {{ $order->user->name }}
                                </li>
                                <li class="list-group-item"><i class="fa fa-phone"></i>
                                    {{ $order->user->phone ?: $order->user->mobile_phone }}
                                </li>
                                <li class="list-group-item"><i class="fa fa-envelope"></i>
                                    {{ $order->user->email }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Seller Information -->
                <div class="card mb-3 summary-padding">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Satıcı Bilgileri <img
                                src="https://img.icons8.com/ios-filled/50/EA2A28/verified-account.png" alt="Verified Icon"
                                class="verifiedIcon"></h3>
                        <div class="event">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <img src="{{ $order->housing->user->profile_image && file_exists(public_path('storage/profile_images/' . $order->housing->user->profile_image)) ? url('storage/profile_images/' . $order->housing->user->profile_image) : url('storage/profile_images/indir.png') }}"
                                        alt="Store Image">
                                    {{ $order->housing->user->name }}
                                </li>
                                <li class="list-group-item"><i class="fa fa-phone"></i>
                                    {{ $order->housing->user->phone ?: $order->housing->user->mobile_phone }}
                                </li>
                                <li class="list-group-item"><i class="fa fa-envelope"></i>
                                    {{ $order->housing->user->email }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".phoneControl").on("input blur", function() {
                var phoneNumber = $(this).val();
                var pattern = /^5[0-9]\d{8}$/;

                if (!pattern.test(phoneNumber)) {
                    $("#error_message").text("Lütfen geçerli bir telefon numarası giriniz.");
                } else {
                    $("#error_message").text("");
                }
                // Kullanıcı 10 haneden fazla veri girdiğinde bu kontrol edilir
                $('.phoneControl').on('keypress', function(e) {
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

    <script>
        // CSRF tokenını al
        var csrfToken = "{{ csrf_token() }}";

        // Form verilerini topla ve gönder
        function submitForms() {
            var form1 = $("#wizardValidationForm1");
            var form2 = $("#wizardValidationForm2");
            var form3 = $("#wizardValidationForm3");

            var formData = {
                "_token": csrfToken,
                "terms": form1.find("input[name='terms']").prop("checked") ? 1 : 0,
                "name": form2.find("input[name='name']").val(),
                "phone": form2.find("input[name='phone']").val(),
                "email": form2.find("input[name='email']").val(),
                "return_bank": form2.find("input[name='return_bank']").val(),
                "return_iban": form2.find("input[name='return_iban']").val(),
                "content": form3.find("textarea[name='content']").val(),
                "reservation_id": "{{ $order->id }}"
            };

            console.log(formData);
            // AJAX isteğiyle sunucuya form verilerini gönder
            $.ajax({
                type: "POST",
                url: "{{ route('institutional.reservation.order.refund') }}",
                data: formData,
                success: function(response) {
                    // Sunucudan başarılı bir yanıt alındığında yönlendirme yap
                    toastr.success('İade talebi başarıyla gönderildi.');
                    console.log("Form başarıyla gönderildi.");
                    location.href =
                        "{{ route('institutional.reservation.order.detail', ['reservation_id' => $order->id]) }}";
                },
                error: function(xhr, status, error) {
                    // Hata durumunda burada bir işlem yapabilirsiniz
                    console.log(error);
                    toastr.error('İade talebi gönderilirken bir hata oluştu. Tekrar Deneyiniz');
                }
            });
        }

        function number_format(number, decimals, dec_point, thousands_sep) {
            number = number.toFixed(decimals);
            var parts = number.toString().split(dec_point);
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_sep);
            return parts.join(dec_point);
        }
    </script>

    <script>
        function formatIBAN(input) {
            // TR ile başlat
            var value = input.value.toUpperCase().replace(/\s+/g, '');
            var formattedIBAN = 'TR';

            // TR harflerini başa eklemek için
            if (value.startsWith('TR')) {
                value = value.substring(2);
            }

            // Gelen değerden sadece rakamları al ve ilk 24 karakteri sınırla
            var numbersOnly = value.replace(/[^0-9]/g, '').substring(0, 22);

            // Geri kalanı 4'er basamaklı gruplara ayır ve aralarına boşluk ekle
            for (var i = 0; i < numbersOnly.length; i += 4) {
                formattedIBAN += ' ' + numbersOnly.substr(i, 4);
            }

            // Formatlanmış IBAN'ı input değerine ata
            input.value = formattedIBAN.trim();
        }
    </script>
@endsection

@section('styles')
    <style>
        .invalid-checkbox {
            color: #ff0000 !important;
        }
    </style>
    <style>
        .invalid {
            background-color: #ffdddd !important;
        }
    </style>


    <style>
        a.btn.btn-success {
            border-radius: 20px !important;
        }

        img.pay-icon {
            margin-bottom: 30px;
        }

        .box-shadow-green {
            box-shadow: 0 0 10px rgba(0, 177, 18, 0.5);
        }

        .box-shadow-light {
            box-shadow: 0 0 10px rgba(0, 154, 56, 0.5);
        }

        .box-shadow-blue {
            box-shadow: 0 0 10px rgba(9, 74, 187, 0.5);
        }

        .status-icon.box-shadow-green.text-success {
            background-color: #0E713D;
        }

        .status-icon.text-primary.box-shadow-blue {
            background-color: #2F7DF7;
        }

        .status-icon.text-success.box-shadow-light {
            background-color: #0FA958;
        }

        .status-card {
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            position: relative;
            padding-top: 40px;
            text-align: center;
        }

        .status-icon {
            width: 40px;
            height: 40px;
            position: absolute;
            top: -18px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 20px;

            border-radius: 50%;
            padding: 10px;

        }

        .status-header {
            margin-top: 30px;
        }

        .status-title {
            font-size: 18px;
            font-weight: bold;
        }

        .status-description {
            font-size: 14px;
            margin-top: 10px;
        }

        .status-timestamp {
            font-size: 12px;
            color: #888;
            margin-top: 10px;
        }

        .approve-button {
            text-align: center;
            margin-top: 20px;
        }

        .rating {
            margin-top: 10px;
            text-align: center;
            font-size: 18px;
            color: #FFD700;
        }

        .horizontal-line {
            border-top: 1px solid #ddd;
            margin-top: 20px;
            margin-bottom: 30px !important;
        }

        .bg-light-blue {
            background-color: #e9f5ff;
        }

        .bg-light-green {
            background-color: rgba(116, 190, 151, 0.5);
        }

        .bg-light {
            background-color: #E0F2E3 !important;
        }

        .status-icon i {
            color: #007bff;
        }

        .bg-light-green .status-icon i {
            color: #28a745;
        }

        .bg-light .status-icon i {
            color: #28a745;
        }

        button.btn.btn-success {
            border-radius: 20px !important;
        }

        button.btn.btn-danger {
            border-radius: 20px !important;
        }
    </style>

    <style>
        .error-message {
            color: #e54242;
            font-size: 11px;
        }

        .order_status span {
            font-weight: 800
        }

        #table_filter {
            margin-bottom: 20px;
        }

        .table-breadcrumb {
            margin-bottom: 0
        }

        .order-details {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            max-width: 100%;
            width: 100%;
        }

        .order-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .order-header-image {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: white;
            background-color: black;
            border-radius: 50%;
        }

        .order-header h3 {
            margin: 0;
        }

        .order-status {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .status {
            display: flex;
            align-items: center;
        }

        .status p {
            margin-bottom: 0 !important;
        }

        .status img {
            width: 20px;
            margin-right: 5px;
        }

        .progress-bar {
            height: 8px;
            border-radius: 5px;
            background-color: #eee;
            overflow: hidden;
            position: relative;
        }

        .progress {
            height: 100%;
            /* Default color */

            /* Change this value to reflect progress */
        }

        .order-status-container {
            color: black;
            border-radius: 10px;
            padding: 20px;
            max-width: 900px;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .order-status-container .left {
            display: flex;
            align-items: center;
        }

        .order-status-container .left i {
            margin-right: 5px;
        }

        .order-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            max-width: 900px;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .timeline,
        .shipment {
            width: 45%;
        }

        .timeline h3,
        .shipment h3 {
            margin-bottom: 10px;
            font-size: 18px;
        }


        .event time {
            display: block;
            font-size: 14px;
            color: #666;
        }

        .event p {
            margin: 5px 0;
        }

        .event img {
            width: 20px;
            vertical-align: middle;
            margin-right: 5px;
            border-radius: 50%;
            height: 20px;
        }

        .shipment .detail img {
            width: 20px;
            vertical-align: middle;
            margin-right: 5px;
        }

        .shipment .tracking {
            display: flex;
            align-items: center;
        }

        .shipment .tracking input {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
            width: 100%;
            margin-right: 10px;
        }

        .shipment .tracking button {
            background-color: #ddd;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .verifiedIcon {
            width: 15px !important;
            margin-left: 5px
        }

        .event .list-group-item {
            width: 100%;
            border: none;
            padding: 0;
            padding-bottom: 10px;

        }

        .order-item {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            max-width: 100%;
            width: 100%;
            border: none;
            position: relative;
        }

        .order-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-item-header .badge {
            background-color: #f8d7da;
            color: #721c24;
        }

        .order-item-body {
            display: flex;
            margin-top: 20px;
        }

        .order-item-body img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
        }

        .order-item-details {
            margin-left: 20px;
            flex-grow: 1;
        }

        .order-item-details h5 {
            margin: 0 0 10px;
        }

        .order-item-details .text-muted {
            margin: 5px 0;
        }

        .order-item-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .order-detail-inner {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            max-width: 100%;
            width: 100%;
            border: none;
            position: relative;
        }

        .order-detail-inner .title {
            display: flex;
            align-items: center;
            font-size: 1.25rem
        }

        .order-detail-inner .title i {
            margin-right: 8px;
        }

        .order-detail-inner .timeline {
            padding: 16px;
        }

        .order-detail-inner .timeline h3 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .order-detail-inner .timeline p {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 16px;
        }

        .order-detail-inner .event {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
        }

        .order-detail-inner .event .brand {
            display: flex;
            align-items: center;
        }

        .order-detail-inner .event .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .order-detail-inner .row {
            padding: 16px;
        }

        .order-detail-inner textarea.form-control {
            width: 100%;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 8px;
        }

        .file-input,
        .file-drop-area {
            height: 120px !important
        }
    </style>
    <style>
        .main {
            max-width: 500px;
            background-color: #ffffff;
            margin: 40px auto;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.1);
        }

        .step {
            display: none;
        }

        .active {
            display: block;
        }

        input {
            padding: 15px 20px;
            width: 100%;
            font-size: 1em;
            border: 1px solid #e3e3e3;
            border-radius: 5px;
        }

        input:focus {
            border: 1px solid #009688;
            outline: 0;
        }

        .invalid {
            border: 1px solid #ffaba5;
        }

        #nextBtn,
        #prevBtn {
            background-color: #009688;
            color: #ffffff;
            border: none;
            padding: 13px 30px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
            flex: 1;
            margin-top: 5px;
            transition: background-color 0.3s ease;
        }

        #prevBtn {
            background-color: #ffffff;
            color: #009688;
            border: 1px solid #009688;
        }

        #prevBtn:hover,
        #nextBtn:hover {
            background-color: #00796b;
            color: #ffffff;
        }

        .progress {
            margin-bottom: 20px;
        }
    </style>
    <style>
        .custom-checkbox {
            position: relative;
            display: inline-block;
            width: 20px;
            height: 20px;
        }

        .custom-checkbox input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #ccc;
            border-radius: 4px;
        }

        .custom-checkbox input:checked~.checkmark {
            background-color: #28a745;
            /* Checkbox seçiliyse yeşil */
        }

        .custom-checkbox input:invalid~.checkmark {
            background-color: #ff0000;
            /* Checkbox seçili değilse kırmızı */
        }

        .custom-checkbox input:focus~.checkmark {
            box-shadow: 0 0 2px 2px rgba(0, 123, 255, 0.25);
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .custom-checkbox input:checked~.checkmark:after {
            display: block;
        }

        .custom-checkbox .checkmark:after {
            left: 7px;
            top: 3px;
            width: 6px;
            height: 12px;
            border: solid white;
            border-width: 0 3px 3px 0;
            transform: rotate(45deg);
        }
    </style>
@endsection
