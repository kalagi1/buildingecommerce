@extends('admin.layouts.master')

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
    @php
        // İade talebinin oluşturulma tarihini al
        $refundCreatedAt = $order->created_at;

        // Şu anki zamanı al
        $now = now();

        // İade talebinin oluşturulma tarihinden 14 gün sonrasını al
        $expirationDate = $refundCreatedAt->addDays(14);

        // İade talebinin oluşturulma tarihinden 14 gün sonrasına kadar kaç gün kaldığını hesapla
        $daysLeft = $now->diffInDays($expirationDate);

        // İade talebi 14 günü geçmişse
        $isExpired = $now->greaterThan($expirationDate);

    @endphp

    <div class="content">
        <div class="breadcrumb">
            <ul>
                <li><i class="fa fa-home"></i> Yönetim Paneli</li>
                <li>Rezervasyonlar</li>
                <li>Tüm Rezervasyonlar</li>
                <li>#{{ $order->key }} Nolu Rezervasyon Detayı</li>
            </ul>
        </div>
        <div class="row g-5 gy-7">
            <div class="col-12 col-xl-8 col-xxl-9">
                <div class="card p-3">
                    <div>
                        <a href="{{ route('admin.reservations') }}" class="button-back"><i class="fa fa-angle-left"></i> Geri
                            Dön</a>
                    </div>
                    <div class="order-detail-content mt-3">
                        <h5>#{{ $order->key }} Nolu Rezervasyon Detayı</h5>

                        @if ($order->refund != null)
                            <div class="order-status-container mt-3"
                                style="@if ($order->refund->status == 2) background-color : #f24734; @elseif($order->refund->status == 0) background-color :red;  @elseif($order->refund->status == 1)  @elseif($order->refund->status == 3) @else background-color : #a3a327 @endif">
                                <div class="left">
                                    <i class="fa fa-check"></i>
                                    <span>
                                        @if ($order->refund->status == 2)
                                            İADE TALEBİNİ REDDETTİNİZ
                                        @elseif($order->refund->status == 1)
                                            İADE TALEBİNİ ONAYLADINIZ
                                        @elseif($order->refund->status == 3)
                                            İADE TALEBİ İÇİN GERİ ÖDEME YAPILDI
                                        @else
                                            İADE TALEBİ İÇİN ONAY BEKLENİYOR
                                        @endif
                                    </span>
                                </div>

                            </div>
                        @else
                            <div class="order-status-container mt-3"
                                style="@if ($order->status == 2) background-color : #f24734; @elseif($order->status == 1) @else background-color : #a3a327 @endif">
                                <div class="left">
                                    <i class="fa fa-check"></i>
                                    <span>
                                        @if ($order->status == 2)
                                            ÖDEMEYİ REDDETTİNİZ
                                        @elseif($order->status == 1)
                                            ÖDEMEYİ ONAYLADINIZ
                                        @else
                                            ÖDEME ONAYI BEKLENİYOR
                                        @endif
                                    </span>
                                </div>

                            </div>
                        @endif

                        {{-- @if ($order->reference)
                            <div class="order-status-container mt-3" style="background-color : #1581f5 ">
                                <div class="left">
                                    <i class="fa fa-check"></i>
                                    <span>
                                        Bu İlan <strong>{{ $order->reference->name }}</strong> referansı ile satılmıştır
                                    </span>
                                </div>

                            </div>
                        @endif --}}


                        <div class="order-detail-inner mt-3 px-3 py-3">
                            <div class="row">
                                <div class="col-md-2 text-center">
                                    <p>Rezervasyon No</p>
                                    <span><strong>#{{ $order->key }}</strong></span>
                                </div>


                                <div class="col-md-2 text-center">
                                    <p>İlan No</p>
                                    <a target="_blank"
                                        href="{{ route('housing.show', [
                                            'housingSlug' => $order->housing->slug,
                                            'housingID' => $order->housing->id + 2000000,
                                        ]) }}">
                                        {{ $order->housing->id + 2000000 }}
                                    </a>
                                </div>

                                <div class="col-md-2 text-center">
                                    <p>Oluşturma Tarihi</p>
                                    <span><strong>{{ date('d', strtotime($order->created_at)) . ' ' . $months[date('n', strtotime($order->created_at)) - 1] . ' ' . date('Y', strtotime($order->created_at)) }}</strong></span>
                                </div>

                                <div class="col-md-2 text-center">
                                    <p>Giriş Tarihi</p>
                                    <span><strong>{{ date('d', strtotime($order->check_in_date)) . ' ' . $months[date('n', strtotime($order->check_in_date)) - 1] . ' ' . date('Y', strtotime($order->check_in_date)) }}</strong></span>
                                </div>


                                <div class="col-md-2 text-center">
                                    <p>Çıkış Tarihi</p>
                                    <span><strong>{{ date('d', strtotime($order->check_out_date)) . ' ' . $months[date('n', strtotime($order->check_out_date)) - 1] . ' ' . date('Y', strtotime($order->check_out_date)) }}</strong></span>
                                </div>




                            </div>
                        </div>

                        <div class="order-detail-inner mt-3 px-3 pt-3 pb-0">
                            <div class="title">
                                <i class="fa fa-user"></i>
                                <h4>Alıcı Bilgileri</h4>
                            </div>
                            @php
                                if ($order->user->profile_image) {
                                    $profileImage = url('storage/profile_images/' . $order->user->profile_image);
                                } else {
                                    $initial = $order->user->name ? strtoupper(substr($order->user->name, 0, 1)) : '';
                                    $profileImage = $initial;
                                }

                            @endphp

                            <div class="row py-3 px-3">
                                <div class="col-3 col-sm-auto"><label class="cursor-pointer avatar avatar-3xl"
                                        for="avatarFile"><img class="rounded-circle" src="{{ $profileImage }}"
                                            alt=""></label>
                                </div>
                                <div class="col-md-3">
                                    <p>İsim Soyisim</p>
                                    <span><strong class="d-flex" style="align-items: center;">
                                            {{ $order->user->name }}</span></strong>
                                </div>

                                <div class="col-md-3">
                                    <p>Telefon</p>
                                    <span><strong class="d-flex" style="align-items: center;">
                                            @if (isset($order->user->phone))
                                                {{ $order->user->phone }}
                                            @elseif(isset($order->user->mobile_phone))
                                                {{ $order->user->mobile_phone }}
                                            @else
                                                Telefon bilgisi bulunamadı
                                            @endif
                                    </span></strong>
                                </div>

                                <div class="col-md-3">
                                    <p>E-Posta</p>
                                    <span><strong class="d-flex" style="align-items: center;">
                                            {{ $order->user->email }}</span></strong>
                                </div>

                            </div>
                        </div>

                        <div class="order-detail-inner mt-3 px-3 pt-3 pb-0">
                            <div class="title">
                                <i class="fa fa-user"></i>
                                <h4>Satıcı Bilgileri</h4>
                            </div>
                            @php
                                if ($order->owner->profile_image) {
                                    $storeImage = url('storage/profile_images/' . $order->owner->profile_image);
                                } else {
                                    $initial = $order->owner->name ? strtoupper(substr($order->owner->name, 0, 1)) : '';
                                    $storeImage = $initial;
                                }

                            @endphp

                            <div class="row py-3 px-3">
                                <div class="col-3 col-sm-auto"><a target="_blank"
                                        href="{{ route('institutional.dashboard', ['slug' => $order->owner->name, 'userID' => $order->owner->id]) }}"
                                        class="cursor-pointer avatar avatar-3xl" for="avatarFile"><img
                                            class="rounded-circle" src="{{ $storeImage }}" alt=""></a>
                                </div>
                                <div class="col-md-3">
                                    <p>İsim Soyisim</p>
                                    <span><strong class="d-flex" style="align-items: center;">
                                            {{ $order->owner->name }}</span></strong>
                                </div>

                                <div class="col-md-3">
                                    <p>Telefon</p>
                                    <span><strong class="d-flex" style="align-items: center;">
                                            @if (isset($order->owner->phone))
                                                {{ $order->owner->phone }}
                                            @elseif(isset($order->owner->mobile_phone))
                                                {{ $order->owner->mobile_phone }}
                                            @else
                                                Telefon bilgisi bulunamadı
                                            @endif
                                    </span></strong>
                                </div>

                                <div class="col-md-3">
                                    <p>E-Posta</p>
                                    <span><strong class="d-flex" style="align-items: center;">
                                            {{ $order->owner->email }}</span></strong>
                                </div>

                            </div>
                        </div>
                        {{-- <div class="order-detail-inner mt-3 px-3 pt-3 pb-0">
                            <div class="title">
                                <i class="fa fa-shopping-bag"></i>
                                <h4>Sipariş Edilen Ürün Listesi</h4>
                            </div>
                            <div class="row py-3 px-3">
                                <div class="order-detail-product px-3 py-3">
                                    <div class="d-flex jc-space-between pb-4">
                                        <div class="product-info flex-1">
                                            <div class="product-info-img">
                                                @php
                                                    $orderCartData = json_decode($order->cart, true); // JSON verisini diziye dönüştür
                                                    $itemImage = isset($orderCartData['item']['image'])
                                                        ? $orderCartData['item']['image']
                                                        : null; // item özelliğine eriş
                                                @endphp
                                                @php($o = json_decode($order->cart))

                                                @if ($o->type == 'housing')
                                                    <img src="{{ asset('housing_images/' . json_decode(App\Models\Housing::find(json_decode($order->cart)->item->id ?? 0)->housing_type_data ?? '[]')->image ?? null) }}"
                                                        style="object-fit: cover;width:100px;height:75px" alt="">
                                                @else
                                                    <img src="{{ $itemImage }}"
                                                        style="object-fit: cover;width:100px;height:75px" alt="Görsel">
                                                @endif

                                            </div>
                                            <div class="product-text-info ">
                                                <p><strong>{{ json_decode($order->cart)->item->title }}
                                                        <strong>{{ json_decode($order->cart)->type == 'project' ? json_decode($order->cart)->item->housing : null }}
                                                            No'lu Konut </strong></strong></p>

                                                <p>İlan No : <strong>{{ $order->key }}</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="order-detail-inner mt-3 px-3 pt-3 pb-0">
                            <div class="title">
                                <i class="fa fa-edit"></i>
                                <h4>Rezervasyon Notları </h4>
                            </div>
                            <div class="row py-3 px-3">
                                <textarea name="" class="form-control" style="height: 150px" id="" cols="30" rows="10"
                                    readonly>{{ $order->notes }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12 col-xl-4 col-xxl-3">


                <div class="row">


                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h3 class="card-title mb-4">Özet</h3>
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
                                            {{ number_format($order->down_payment, 0, ',', '.') }}₺
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($order->refund != null)
                        <div class="col-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title mb-4">İade Talebi</h3>
                                    <h6 class="mb-2"></h6>
                                    <div class="order_status">



                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop">Detaylar</button>
                                        <div class="modal fade" id="staticBackdrop" tabindex="-1"
                                            data-bs-backdrop="static" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary">
                                                        <h5 class="modal-title text-white dark__text-gray-1100"
                                                            id="staticBackdropLabel">İade Talebi Oluşturan Alıcı Bilgileri
                                                        </h5><button class="btn p-1" type="button"
                                                            data-bs-dismiss="modal" aria-label="Close"><svg
                                                                class="svg-inline--fa fa-xmark fs-9 text-white dark__text-gray-1100"
                                                                aria-hidden="true" focusable="false" data-prefix="fas"
                                                                data-icon="xmark" role="img"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                                                data-fa-i2svg="">
                                                                <path fill="currentColor"
                                                                    d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z">
                                                                </path>
                                                            </svg><!-- <span class="fas fa-times fs-9 text-white dark__text-gray-1100"></span> Font Awesome fontawesome.com --></button>
                                                    </div>
                                                    @if ($isExpired)
                                                        <!-- İade talebi 14 günü geçmiş -->
                                                        <div style="background-color: #e54242;">Satın alım işleminde 14 gün
                                                            geçmiştir!</div>
                                                    @endif
                                                    <div class="modal-body">
                                                        <div class="card w-100 mb-3">
                                                            <div class="card-body">
                                                                <div class="row">

                                                                    <div class="col-md-3">
                                                                        <h5 class="card-title">İsim Soyisim:</h5>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <p>{{ $order->refund->name }}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <h5 class="card-title">Email:</h5>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <p>{{ $order->refund->email }}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <h5 class="card-title">Telefon:</h5>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <p>{{ $order->refund->phone }}</p>
                                                                    </div>
                                                                </div>
                                                                @if ($order->payment_result && $order->payment_result !== '')
                                                                @else
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <h5 class="card-title">İade Yapılacak Banka:
                                                                            </h5>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <p>{{ $order->refund->return_bank }}</p>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <h5 class="card-title">İade Yapılacak IBAN:
                                                                            </h5>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <p>{{ $order->refund->return_iban }}</p>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <h5 class="card-title">Açıklama:</h5>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <p>{{ $order->refund->content }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h4 class="card-title mb-4">Dekont Ekleme</h4>

                                                                    @if (isset($order->refund->path))
                                                                        <a href="{{ asset($order->refund->path) }}"
                                                                            target="_blank">
                                                                            <i class="fa fa-file"></i> Dosyayı Görüntüle
                                                                        </a>
                                                                    @else
                                                                        <p>PDF dosyası bulunamadı.</p>
                                                                    @endif

                                                                    <div class="order_status mt-3">
                                                                        <form
                                                                            action="{{ route('admin.reservation.receipt.refund.upload.pdf') }}"
                                                                            method="POST" enctype="multipart/form-data">
                                                                            @csrf
                                                                            <input type="hidden" name="refund_id"
                                                                                value="{{ $order->refund->id }}">
                                                                            <div class="mb-3">
                                                                                <input type="file" name="pdf_file"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <button
                                                                                class="btn btn-phoenix-success me-1 mb-1 mt-3"
                                                                                type="submit">Yükle</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="col-12 mt-3">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h4 class="card-title mb-4">İade Durumu</h4>


                                                                    <form
                                                                        action="{{ route('admin.reservation.refund.update.status', $order->refund->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <select class="form-select" name="status">
                                                                            <option value="1"
                                                                                {{ $order->refund->status == 1 ? 'selected' : '' }}>
                                                                                İade talebini onayla</option>
                                                                            <option value="2"
                                                                                {{ $order->refund->status == 2 ? 'selected' : '' }}>
                                                                                İade talebini reddet</option>
                                                                            <option value="3"
                                                                                {{ $order->refund->status == 3 ? 'selected' : '' }}>
                                                                                Geri Ödeme tamamlandı</option>
                                                                        </select>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary" type="submit">Güncelle</button>
                                                        <button class="btn btn-outline-primary" type="button"
                                                            data-bs-dismiss="modal">kapat</button>
                                                    </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title mb-4">Rezervasyon Durumu</h3>
                                <h6 class="mb-2"></h6>
                                <div class="order_status">
                                    <select class="form-select mb-4" name="status" id="status"
                                        onchange="submitForm()">
                                        <option
                                            value="{{ route('admin.approve-reservation', ['reservation' => $order->id]) }}"
                                            @if ($order->status == 1) selected @endif>Onayla</option>
                                        <option
                                            value="{{ route('admin.unapprove-reservation', ['reservation' => $order->id]) }}"
                                            @if ($order->status != 1) selected @endif>Reddet</option>
                                        <option value="" @if ($order->status == 0) selected @endif>Onay
                                            Bekleniyor</option>

                                    </select>

                                    <form id="status-form" action="#" method="POST" style="display: none;">
                                        @csrf
                                    </form>


                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title mb-4">Hakediş Durumu</h3>
                                <h6 class="mb-2"></h6>
                                <div class="order_status">

                                    @if (isset($order->sharer))
                                        <select class="form-select mb-4" onchange="submitFormPriceAndShare(this)">
                                            <option
                                                value="{{ route('admin.approve-share', ['share' => $order->sharer->id]) }}"
                                                @if ($order->sharer->status == 1) selected @endif>Hakedişleri Onayla
                                            </option>
                                            <option
                                                value="{{ route('admin.unapprove-share', ['share' => $order->sharer->id]) }}"
                                                @if ($order->sharer->status != 1) selected @endif>Hakedişleri Reddet
                                            </option>
                                        </select>

                                        <form id="status-form" action="#" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    @endif

                                    @if (isset($order->cartPrice))
                                        <select class="form-select mb-4" onchange="submitFormPriceAndShare(this)">
                                            <option
                                                value="{{ route('admin.approve-price', ['price' => $order->cartPrice->id]) }}"
                                                @if ($order->cartPrice->status == 1) selected @endif>Hakedişleri Onayla
                                            </option>
                                            <option
                                                value="{{ route('admin.unapprove-price', ['price' => $order->cartPrice->id]) }}"
                                                @if ($order->cartPrice->status != 1) selected @endif>Hakedişleri Reddet
                                            </option>
                                        </select>

                                        <form id="status-form" action="#" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title mb-4">İlan Durumu</h3>
                                <h6 class="mb-2"></h6>
                                <div class="order_status">
                                    <td class="order_status align-middle text-center fw-semibold text-body-highlight">
                                       @php
    $statusMessages = [
        '0' => '<span class="text-warning">Onay Bekleniyor</span>',
        '1' => '<span class="text-success">Satış Onaylandı</span>',
        '2' => '<span class="text-danger">Satış Reddedildi</span>',
    ];
    $status = $statusMessages[$order->status] ?? '<span class="text-muted">Durum Bilinmiyor</span>';
@endphp

{!! $status !!}
 <br>

                                        @if (isset($order->sharer))
                                            <span class="text-warning">Bu ilan emlak kulüp aracılığı ile
                                                satılmıştır.
                                                @if ($order->sharer->status == 1)
                                                    <br>
                                                    Hakedişler Onaylandı.
                                                @endif
                                            </span>
                                        @endif
                                        @if (isset($order->cartPrice) && $order->cartPrice->status == 1)
                                            <span class="text-success">Hakedişler Onaylandı.</span>
                                        @endif

                                        @if (isset($order->cartPrice) && $order->cartPrice->status == 0)
                                            <span class="text-warning">Hakediş onayı bekleniyor.</span>
                                        @endif

                                        @if (isset($order->cartPrice) && $order->cartPrice->status == 2)
                                            <span class="text-danger">Hakediş reddedildi.</span>
                                        @endif
                                    </td>
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
    <script src="//cdn.ckeditor.com/4.21.0/full/ckeditor.js"></script>

    <script src="https://cdn.tiny.cloud/1/uzaxwtnfjkyj1l9egzl3mea3go0cq6xgmlkoanf5eb2jry8u/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        CKEDITOR.replace('emailContent', {
            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
        //  tinymce.init({
        //     selector: 'textarea#body', // Hedef elementin id'si
        //     plugins: 'link code anchor autolink charmap codesample emoticons image lists media searchreplace table visualblocks wordcount', // İhtiyacınıza göre eklentileri ayarlayabilirsiniz
        //     toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        //     menubar: true,
        //     branding: true
        // });
    </script>
    <script>
        // function submitForm() {
        //     var form = document.getElementById("status-form");
        //     var select = document.getElementById("status");
        //     var selectedOption = select.options[select.selectedIndex];

        //     if (selectedOption.value) {
        //         form.action = selectedOption.value;
        //         form.submit();
        //     }
        // }

        function submitFormPriceAndShare(select) {
            var form = document.getElementById("status-form");
            var selectedOption = select.options[select.selectedIndex];

            if (selectedOption.value) {
                var actionText = selectedOption.text.includes("Onayla") ? "Onaylamak" : "Reddetmek";
                if (confirm("İşlemi " + actionText + " istediğinize emin misiniz?")) {
                    form.action = selectedOption.value;
                    form.submit();
                }
            }
        }



        function submitForm() {
            var form = document.getElementById("status-form");
            var select = document.getElementById("status");
            var selectedOption = select.options[select.selectedIndex];

            if (selectedOption.value) {
                var actionText = "";
                if (selectedOption.text.includes("Onayla")) {
                    actionText = "Onaylamak";
                } else if (selectedOption.text.includes("Reddet")) {
                    actionText = "Reddetmek";
                }

                if (confirm("İşlemi " + actionText + " istediğinize emin misiniz?")) {
                    form.action = selectedOption.value;
                    form.submit();
                }
            }
        }

        function number_format(number, decimals, dec_point, thousands_sep) {
            number = number.toFixed(decimals);
            var parts = number.toString().split(dec_point);
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_sep);
            return parts.join(dec_point);
        }
    </script>
@endsection

@section('css')
    <style>
        .order_status span {
            font-weight: 800
        }

        #table_filter {
            margin-bottom: 20px;
        }
    </style>
@endsection
