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
        $orderCart = json_decode($order->cart, true);

        $deposit_rate = 0.02;
        $discount_percent = 2;
        if ($orderCart['type'] == 'housing') {
            $housing = \App\Models\Housing::where('id', $orderCart['item']['id'])->first();
            $saleType = $housing->step2_slug;
            $deposit_rate = 0.02;
            $discount_percent = 2;
        } else {
            $project = \App\Models\Project::where('id', $orderCart['item']['id'])->first();
            $saleType = $project->step2_slug;
            $deposit_rate = $project->deposit_rate / 100;
            $discount_percent = $project->deposit_rate;
        }
        $kapora_tutari = str_replace(',', '', str_replace('.', '', $order->amount)) / 100;
        $kapora_orani = $discount_percent / 100;
        $tam_tutar = $kapora_tutari / $kapora_orani;
        $urun_fiyati = json_decode($order->cart)->item->price;

        $tam_tutar_formatli = number_format($tam_tutar, 0, ',', '.') . '₺';
        $urun_fiyati_formatli = number_format($urun_fiyati, 0, ',', '.') . '₺';
        $indirim_miktari = $tam_tutar - $urun_fiyati;
        $indirim_yuzdesi = ($indirim_miktari / $tam_tutar) * 100;
        $indirim_yuzdesi_formatli = number_format($indirim_yuzdesi, 2, ',', '.') . '%';
        $storeImage = null;
        $initial = null;
        $userName = null;
        if ($order->store->profile_image) {
            $storeImage = url('storage/profile_images/' . $order->store->profile_image);
        } else {
            $initial = $order->store->name ? strtoupper(substr($order->store->name, 0, 1)) : '';
        }
        $item = json_decode($order->cart)->item;
        if (json_decode($order->cart)->type == 'housing') {
            $userName = json_decode(App\Models\Housing::with('user')->find($item->id ?? 0))->user->name;
        } else {
            $userName = json_decode(App\Models\Project::with('user')->find($item->id ?? 0))->user->name;
        }
        $isStoreOwner = $order->store_id == Auth::user()->id;
        $isUserOwner = $order->user_id == Auth::user()->id;
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="table-breadcrumb">
            <ul>
                <li>Hesabım</li>
                <li>Siparişler</li>
                <li>Tüm Siparişler</li>
                <li>#{{ $order->id }} Nolu Sipariş Detayı</li>

            </ul>
        </div>

    </div>

    <div class="row g-5 gy-7">
        <div class="col-12 col-xl-8 col-xxl-9">
            <div class="order-detail-content">
                <div class="order-details mb-3">
                    <div class="order-header">

                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="#000000" stroke-width="2" fill="#000000"
                            stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>

                        <h3 style="margin-left: 10px">#{{ $order->id }} Nolu Sipariş Durumu</h3>
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
                                            İADE TALEBİ ONAYLANDI
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
                                            SİPARİŞ REDDEDİLDİ
                                        @break

                                        @case(1)
                                            SİPARİŞ ONAYLANDI
                                        @break

                                        @default
                                            ÖDEME ONAYI BEKLENİYOR
                                    @endswitch
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                @if ($order->reference)
                    <div class="order-status-container mb-3" style="background-color: #1581f536">
                        <div class="left">
                            <i class="fa fa-check"></i>
                            <span>
                                @php
                                    $referenceName = $order->reference->name;

                                @endphp

                                @if ($isStoreOwner)
                                    Bu satış <strong>{{ $referenceName }}</strong> isimli çalışanızın referansı ile
                                    gerçekleşmiştir.
                                @elseif ($isUserOwner)
                                    Satış danışmanınız: <strong>{{ $referenceName }}</strong>
                                @endif
                            </span>
                        </div>
                    </div>
                @endif


                <div class="order-item mb-3">
                    <div class="order-item-header">
                        <div class="order-item-title">
                            <h5>Sipariş Edilen Ürün Listesi
                            </h5>

                        </div>
                    </div>
                    <div class="order-item-body">
                        @php
                            $o = json_decode($order->cart);
                            $itemImage = $o->item->image ?? null;
                        @endphp

                        @if ($o->type == 'housing')
                            <img src="{{ asset('housing_images/' . optional(App\Models\Housing::find($o->item->id ?? 0)->housing_type_data)->image ?? null) }}"
                                style="object-fit: cover;width:100px;height:75px" alt="">
                        @else
                            <img src="{{ $itemImage }}" style="object-fit: cover;width:100px;height:75px" alt="Görsel">
                        @endif

                        <div class="order-item-details">
                            <h5><strong>{{ $o->item->title }}
                                    {{ $o->type == 'project' ? $o->item->housing . ' No\'lu Konut' : '' }}</strong></h5>
                            <span class="badge badge-danger">İlan No:
                                {{ $o->type == 'housing' ? $o->item->id + 2000000 : optional(App\Models\Project::find($o->item->id ?? 0))->id + 1000000 . '-' . $o->item->housing }}</span>
                        </div>

                        <div class="order-item-quantity">
                            <p class="text-muted">{{ number_format($o->item->price, 0, ',', '.') }}₺</p>
                        </div>
                        @if ($order->invoice)
                            <a href="{{ route('institutional.invoice.show', $order->id) }}"
                                class="btn btn-primary">Faturayı Görüntüle</a>
                        @endif
                    </div>
                    @if ($isUserOwner)
                        <div class="order-item-footer">


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
                                        href="{{ route('institutional.dashboard', ['slug' => $order->store->name, 'userID' => $order->store->id]) }}">Mağazayı
                                        Gör</a>
                                </button>


                            </div>
                        </div>
                    @endif
                </div>

                <div class="order-detail-inner">
                    <div class="title mb-3">
                        <i class="fa fa-edit"></i>
                        <h4>Sipariş Notları</h4>
                    </div>
                    <textarea class="form-control" style="height: 150px" readonly>
                      @if ($order->notes)
{!! $order->notes !!}
@else
Sipariş Notu eklenmedi
@endif
                    </textarea>
                </div>



            </div>
        </div>
        <div class="col-12 col-xl-4 col-xxl-3">


            <div class="row ">

                <!-- Order Summary -->
                <div class="col-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Sipariş Özeti</h3>
                            <div>
                                @foreach (['Ödeme Yöntemi', 'İlan Fiyatı', 'Kapora Oranı', 'Kapora Tutarı'] as $title)
                                    <div class="d-flex justify-content-between">
                                        <p class="text-body fw-semibold">{{ $title }}:</p>
                                        <p class="text-body-emphasis fw-semibold">
                                            @switch($title)
                                                @case('Ödeme Yöntemi')
                                                    {{ $order->payment_result ? 'Kredi Kartı' : 'EFT/Havale' }}
                                                @break

                                                @case('İlan Fiyatı')
                                                    {{ number_format(json_decode($order->cart)->item->price, 0, ',', '.') }}₺
                                                @break

                                                @case('Kapora Oranı')
                                                    %{{ $discount_percent }}
                                                @break

                                                @case('Kapora Tutarı')
                                                    {{ number_format(str_replace(',', '', str_replace('.', '', $order->amount)) / 100, 0, ',', '.') }}₺
                                                @break
                                            @endswitch
                                        </p>
                                    </div>
                                @endforeach

                                @if (isset(json_decode($order->cart)->item->qt) && json_decode($order->cart)->item->qt > 1)
                                    <div class="d-flex justify-content-between">
                                        <p class="text-body fw-semibold">Pay Adeti:</p>
                                        <p class="text-danger fw-semibold">{{ json_decode($order->cart)->item->qt }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Buyer Information -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Alıcı Bilgileri <img
                                    src="https://img.icons8.com/ios-filled/50/EA2A28/verified-account.png"
                                    alt="Verified Icon" class="verifiedIcon"></h3>
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
                    <div class="card mb-3">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Satıcı Bilgileri <img
                                    src="https://img.icons8.com/ios-filled/50/EA2A28/verified-account.png"
                                    alt="Verified Icon" class="verifiedIcon"></h3>
                            <div class="event">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <img src="{{ $order->store->profile_image && file_exists(public_path('storage/profile_images/' . $order->store->profile_image)) ? url('storage/profile_images/' . $order->store->profile_image) : url('storage/profile_images/indir.png') }}"
                                            alt="Store Image">
                                        {{ $order->store->name }}
                                    </li>
                                    <li class="list-group-item"><i class="fa fa-phone"></i>
                                        {{ $order->store->phone ?: $order->store->mobile_phone }}
                                    </li>
                                    <li class="list-group-item"><i class="fa fa-envelope"></i>
                                        {{ $order->store->email }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                @if (Auth::check() && Auth::user()->id == $order->store->id)
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title mb-4">Sözleşme Ekleme</h3>
                                <h6 class="mb-2"></h6>
                                @if (isset($order->path))
                                    <a href="{{ asset($order->path) }}" target="_blank">
                                        <i class="fa fa-file"></i> Dosyayı Görüntüle
                                    </a>
                                @endif

                                <div class="order_status mt-3">
                                    <form action="{{ route('institutional.contract.upload.pdf') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <div class="mb-3">
                                            <input type="file" name="pdf_file" class="form-control">
                                        </div>
                                        <button class="btn btn-success me-1 mb-1 mt-3"
                                            type="submit">Yükle</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($order->status == '1')
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title mb-4">İade Talebi</h3>
                                <h6 class="mb-2"></h6>
                                @if (!$order->refund)
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">İade Talebinde Bulun</button>
                                @else
                                    <p>İade Başvurunuz İnceleniyor</p>
                                    <br>
                                    <p>Destek Ekibi: <strong>destek@emlaksepette.com</strong></p>
                                @endif

                                <div class="modal fade modal-xl" id="exampleModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">




                                                <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
                                                    <div class="card-header bg-body-highlight pt-3 pb-2 border-bottom-0">
                                                        <ul class="nav justify-content-between nav-wizard" role="tablist">
                                                            <li class="nav-item" role="presentation"><a
                                                                    class="nav-link active fw-semibold"
                                                                    href="#bootstrap-wizard-validation-tab1"
                                                                    data-bs-toggle="tab" data-wizard-step="1"
                                                                    aria-selected="true" role="tab">
                                                                    <div class="text-center d-inline-block"><span
                                                                            class="nav-item-circle-parent"><span
                                                                                class="nav-item-circle"><svg
                                                                                    class="svg-inline--fa fa-lock"
                                                                                    aria-hidden="true" focusable="false"
                                                                                    data-prefix="fas" data-icon="lock"
                                                                                    role="img"
                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                    viewBox="0 0 448 512"
                                                                                    data-fa-i2svg="">
                                                                                    <path fill="currentColor"
                                                                                        d="M80 192V144C80 64.47 144.5 0 224 0C303.5 0 368 64.47 368 144V192H384C419.3 192 448 220.7 448 256V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V256C0 220.7 28.65 192 64 192H80zM144 192H304V144C304 99.82 268.2 64 224 64C179.8 64 144 99.82 144 144V192z">
                                                                                    </path>
                                                                                </svg></span></span><span
                                                                            class="d-none d-md-block mt-1 fs-9">Sözleşme</span>
                                                                    </div>
                                                                </a></li>
                                                            <li class="nav-item" role="presentation"><a
                                                                    class="nav-link fw-semibold"
                                                                    href="#bootstrap-wizard-validation-tab2"
                                                                    data-bs-toggle="tab" data-wizard-step="2"
                                                                    aria-selected="false" tabindex="-1" role="tab">
                                                                    <div class="text-center d-inline-block"><span
                                                                            class="nav-item-circle-parent"><span
                                                                                class="nav-item-circle"><svg
                                                                                    class="svg-inline--fa fa-user"
                                                                                    aria-hidden="true" focusable="false"
                                                                                    data-prefix="fas" data-icon="user"
                                                                                    role="img"
                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                    viewBox="0 0 448 512"
                                                                                    data-fa-i2svg="">
                                                                                    <path fill="currentColor"
                                                                                        d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z">
                                                                                    </path>
                                                                                </svg></span></span><span
                                                                            class="d-none d-md-block mt-1 fs-9">Alıcı
                                                                            Bilgileri</span>
                                                                    </div>
                                                                </a></li>
                                                            <li class="nav-item" role="presentation"><a
                                                                    class="nav-link fw-semibold"
                                                                    href="#bootstrap-wizard-validation-tab3"
                                                                    data-bs-toggle="tab" data-wizard-step="3"
                                                                    aria-selected="false" tabindex="-1" role="tab">
                                                                    <div class="text-center d-inline-block"><span
                                                                            class="nav-item-circle-parent"><span
                                                                                class="nav-item-circle"><svg
                                                                                    class="svg-inline--fa fa-file-lines"
                                                                                    aria-hidden="true" focusable="false"
                                                                                    data-prefix="fas"
                                                                                    data-icon="file-lines" role="img"
                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                    viewBox="0 0 384 512"
                                                                                    data-fa-i2svg="">
                                                                                    <path fill="currentColor"
                                                                                        d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z">
                                                                                    </path>
                                                                                </svg></span></span><span
                                                                            class="d-none d-md-block mt-1 fs-9">Açıklama</span>
                                                                    </div>
                                                                </a></li>
                                                            <li class="nav-item" role="presentation"><a
                                                                    class="nav-link fw-semibold"
                                                                    href="#bootstrap-wizard-validation-tab4"
                                                                    data-bs-toggle="tab" data-wizard-step="4"
                                                                    aria-selected="false" tabindex="-1" role="tab">
                                                                    <div class="text-center d-inline-block"><span
                                                                            class="nav-item-circle-parent"><span
                                                                                class="nav-item-circle"><svg
                                                                                    class="svg-inline--fa fa-check"
                                                                                    aria-hidden="true" focusable="false"
                                                                                    data-prefix="fas" data-icon="check"
                                                                                    role="img"
                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                    viewBox="0 0 448 512"
                                                                                    data-fa-i2svg="">
                                                                                    <path fill="currentColor"
                                                                                        d="M438.6 105.4C451.1 117.9 451.1 138.1 438.6 150.6L182.6 406.6C170.1 419.1 149.9 419.1 137.4 406.6L9.372 278.6C-3.124 266.1-3.124 245.9 9.372 233.4C21.87 220.9 42.13 220.9 54.63 233.4L159.1 338.7L393.4 105.4C405.9 92.88 426.1 92.88 438.6 105.4H438.6z">
                                                                                    </path>
                                                                                </svg></span></span><span
                                                                            class="d-none d-md-block mt-1 fs-9">Onaylama</span>
                                                                    </div>
                                                                </a></li>
                                                        </ul>
                                                    </div>

                                                    {{-- Aydınlatma metini --}}
                                                    <div class="card-body pt-4 pb-0">
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" role="tabpanel"
                                                                aria-labelledby="bootstrap-wizard-validation-tab1"
                                                                id="bootstrap-wizard-validation-tab1">
                                                                @if (file_exists(public_path('refundpolicy/iadeislemleri.pdf')))
                                                                    <iframe
                                                                        src="{{ asset('refundpolicy/iadeislemleri.pdf') }}"
                                                                        width="100%" height="600px">
                                                                        Tarayıcınız yerleşik PDF dosyalarını
                                                                        desteklemiyor. PDF dosyasını indirmek için
                                                                        lütfen <a
                                                                            href="{{ asset('refundpolicy/iadeislemleri.pdf') }}">buraya
                                                                            tıklayın</a>.
                                                                    </iframe>
                                                                @else
                                                                    <p>PDF bulunamadı.</p>
                                                                @endif
                                                                <form class="needs-validation was-validated"
                                                                    id="wizardValidationForm1" novalidate="novalidate"
                                                                    data-wizard-form="1">
                                                                    @csrf
                                                                    <input type="hidden" name="cart_order_id"
                                                                        value="{{ $order->id }}">
                                                                    <div class="form-check"><input
                                                                            class="form-check-input" type="checkbox"
                                                                            name="terms" required="required"
                                                                            id="bootstrap-wizard-validation-wizard-checkbox"><label
                                                                            class="form-check-label text-body"
                                                                            for="bootstrap-wizard-validation-wizard-checkbox">
                                                                            <p>Aydınlatma Metinini Okudum Onaylıyorum
                                                                            </p>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="tab-pane" role="tabpanel"
                                                                aria-labelledby="bootstrap-wizard-validation-tab2"
                                                                id="bootstrap-wizard-validation-tab2">
                                                                <form class="needs-validation" id="wizardValidationForm2"
                                                                    novalidate="novalidate" data-wizard-form="2">
                                                                    @csrf


                                                                    <div class="mb-2"><label class="form-label"
                                                                            for="bootstrap-wizard-validation-wizard-phone">Ad
                                                                            Soyad</label><input class="form-control"
                                                                            type="text" name="name"
                                                                            placeholder="Ad Soyad"
                                                                            id="bootstrap-wizard-validation-wizard-phone"
                                                                            required="required">
                                                                        <div class="invalid-feedback">Alan Zorunludur.
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-2"><label class="form-label"
                                                                            for="bootstrap-wizard-validation-wizard-phone">Telefon
                                                                            Numarası</label><input
                                                                            class="form-control phoneControl"
                                                                            type="text" name="phone"
                                                                            placeholder="Telefon Numarası"
                                                                            id="bootstrap-wizard-validation-wizard-phone"
                                                                            required="required" maxlength="10">
                                                                        <span id="error_message"
                                                                            class="error-message"></span>
                                                                        <div class="invalid-feedback">Alan Zorunludur.
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-2"><label class="form-label"
                                                                            for="bootstrap-wizard-validation-wizard-phone">E-Posta</label><input
                                                                            class="form-control" type="email"
                                                                            name="email" placeholder="E-Posta"
                                                                            id="bootstrap-wizard-validation-wizard-phone"
                                                                            required="required">
                                                                        <div class="invalid-feedback">Alan Zorunludur.
                                                                        </div>
                                                                    </div>

                                                                    @if ($order->payment_result && $order->payment_result !== '')
                                                                    @else
                                                                        <div class="mb-2"><label class="form-label"
                                                                                for="bootstrap-wizard-validation-wizard-phone">İade
                                                                                Yapılacak Banka</label><input
                                                                                class="form-control" type="text"
                                                                                name="return_bank" placeholder="Banka"
                                                                                id="bootstrap-wizard-validation-wizard-phone"
                                                                                required="required">
                                                                            <div class="invalid-feedback">Alan
                                                                                Zorunludur.
                                                                            </div>
                                                                        </div>

                                                                        <div class="mb-2"><label class="form-label"
                                                                                for="bootstrap-wizard-validation-wizard-phone">İade
                                                                                Yapılacak IBAN</label><input
                                                                                class="form-control" type="text"
                                                                                name="return_iban" placeholder="IBAN"
                                                                                id="bootstrap-wizard-validation-wizard-phone"
                                                                                required="required"
                                                                                oninput="formatIBAN(this)">
                                                                            <div class="invalid-feedback">Alan
                                                                                Zorunludur.
                                                                            </div>
                                                                        </div>
                                                                    @endif



                                                                </form>
                                                            </div>
                                                            <div class="tab-pane" role="tabpanel"
                                                                aria-labelledby="bootstrap-wizard-validation-tab3"
                                                                id="bootstrap-wizard-validation-tab3">
                                                                <form class="mb-2 needs-validation"
                                                                    id="wizardValidationForm3" novalidate="novalidate"
                                                                    data-wizard-form="3">
                                                                    @csrf
                                                                    <div class="row gx-3 gy-2">
                                                                        <div class="col-12"><label class="form-label"
                                                                                for="bootstrap-wizard-validation-card-number">
                                                                                Sipariş İptal Sebebiniz
                                                                            </label>
                                                                            <textarea id="editor" class="form-control" name="content" placeholder="Sipariş İptal Sebebiniz"
                                                                                style="height: 300px; width: 100%; resize: vertical;" required></textarea>


                                                                            <div class="invalid-feedback">Alan
                                                                                Zorunludur</div>
                                                                        </div>

                                                                </form>

                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" role="tabpanel"
                                                            aria-labelledby="bootstrap-wizard-validation-tab4"
                                                            id="bootstrap-wizard-validation-tab4">
                                                            <div class="row flex-center pb-8 pt-4 gx-3 gy-4">
                                                                <div class="col-12 col-sm-auto">
                                                                    <div class="text-center text-sm-start"><img
                                                                            class="d-dark-none"
                                                                            src="../../assets/img/spot-illustrations/38.webp"
                                                                            alt="" width="220"><img
                                                                            class="d-light-none"
                                                                            src="../../assets/img/spot-illustrations/dark_38.webp"
                                                                            alt="" width="220"></div>
                                                                </div>
                                                                <div class="col-12 col-sm-auto">
                                                                    <div class="text-center ">
                                                                        <h5 class="mb-3">İptal Talebiniz Alınmıştır
                                                                        </h5>
                                                                        <p class="text-body-emphasis fs-9">Talep Sonucu
                                                                            Kısa Süre İçerisinde Tarafınıza
                                                                            İletilecektir</p>

                                                                        <a href="{{ route('institutional.order.detail', ['order_id' => $order->id]) }}"
                                                                            class="btn btn-primary px-6"
                                                                            onclick="submitForms()">İade Talebi
                                                                            Oluştur</a>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer border-top-0"
                                                    data-wizard-footer="data-wizard-footer">
                                                    <div class="d-flex pager wizard list-inline mb-0"><button
                                                            class="d-none btn btn-link ps-0" type="button"
                                                            data-wizard-prev-btn="data-wizard-prev-btn"><svg
                                                                class="svg-inline--fa fa-chevron-left me-1"
                                                                data-fa-transform="shrink-3" aria-hidden="true"
                                                                focusable="false" data-prefix="fas"
                                                                data-icon="chevron-left" role="img"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                                                data-fa-i2svg=""
                                                                style="transform-origin: 0.3125em 0.5em;">
                                                                <g transform="translate(160 256)">
                                                                    <g
                                                                        transform="translate(0, 0)  scale(0.8125, 0.8125)  rotate(0 0 0)">
                                                                        <path fill="currentColor"
                                                                            d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z"
                                                                            transform="translate(-160 -256)">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </svg>Geri
                                                            Dön</button>
                                                        <div class="flex-1 text-end"><button
                                                                class="btn btn-primary px-6 px-sm-6" type="submit"
                                                                data-wizard-next-btn="data-wizard-next-btn">İleri<svg
                                                                    class="svg-inline--fa fa-chevron-right ms-1"
                                                                    data-fa-transform="shrink-3" aria-hidden="true"
                                                                    focusable="false" data-prefix="fas"
                                                                    data-icon="chevron-right" role="img"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 320 512" data-fa-i2svg=""
                                                                    style="transform-origin: 0.3125em 0.5em;">
                                                                    <g transform="translate(160 256)">
                                                                        <g
                                                                            transform="translate(0, 0)  scale(0.8125, 0.8125)  rotate(0 0 0)">
                                                                            <path fill="currentColor"
                                                                                d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"
                                                                                transform="translate(-160 -256)">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </svg></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>






                                        </div>
                                        {{-- <div class="modal-footer"><button class="btn btn-primary" type="button">Okay</button><button class="btn btn-outline-primary" type="button" data-bs-dismiss="modal">Cancel</button></div>
                                    </div> --}}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
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
                "cart_order_id": "{{ $order->id }}"
            };

            $.ajax({
                type: "POST",
                url: "{{ route('institutional.order.refund') }}",
                data: formData,
                success: function(response) {
                    // Sunucudan başarılı bir yanıt alındığında burada bir işlem yapabilirsiniz
                    toastr.success('İade talebi başarıyla gönderildi.');
                    console.log("Form başarıyla gönderildi.");
                },
                error: function(xhr, status, error) {
                    // Hata durumunda burada bir işlem yapabilirsiniz
                    toastr.error('İade talebi gönderilirken bir hata oluştu. Tekrar Deneyiniz');
                    console.error(error);
                }
            });
        }

        function formatIBAN(input) {
            // TR ile başlat
            var formattedIBAN = "TR";

            // Gelen değerden sadece rakamları al
            var numbersOnly = input.value.replace(/\D/g, '');

            // İBAN uzunluğunu kontrol et ve fazla karakterleri kırp
            if (numbersOnly.length > 24) {
                numbersOnly = numbersOnly.substring(0, 24);
            }

            // Geri kalanı 4'er basamaklı gruplara ayır ve aralarına boşluk ekle
            for (var i = 0; i < numbersOnly.length; i += 4) {
                formattedIBAN += numbersOnly.substr(i, 4) + " ";
            }

            // Formatlanmış İBAN'ı input değerine ata
            input.value = formattedIBAN.trim();
        }
    </script>
    <script>
        function copyTrackingNumber() {
            var copyText = document.querySelector('.tracking input');
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */
            document.execCommand("copy");
        }
    </script>
@endsection

@section('styles')
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
            background-color: #f44336;
            /* Default color */
            width: 70%;
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
    </style>
@endsection
