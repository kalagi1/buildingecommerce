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
                            {{-- <img src="https://img.icons8.com/ios-filled/50/000000/marker.png" alt="Status Icon"> --}}
                            <p>
                                @if ($order->refund != null)
                                    @if ($order->refund->status == 2)
                                        İADE TALEBİ REDDEDİLDİ
                                    @elseif($order->refund->status == 1)
                                        İADE TALEBİ ONAYLANDI
                                    @elseif($order->refund->status == 3)
                                        İADE TALEBİ İÇİN GERİ ÖDEME YAPILDI
                                    @else
                                        İADE TALEBİ İÇİN ONAY BEKLENİYOR
                                    @endif
                                @else
                                    @if ($order->status == 2)
                                        SİPARİŞ REDDEDİLDİ
                                    @elseif($order->status == 1)
                                        SİPARİŞ ONAYLANDI
                                    @else
                                        ÖDEME ONAYI BEKLENİYOR
                                    @endif
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="progress-bar" style="background-color: #eee;">
                        <div class="progress"
                            style="background-color: 
                            @if ($order->status == 2) #f44336;
                                width: 100%;
                            @elseif(
                                $order->status == 1 ||
                                    ($order->refund && $order->refund->status == 1) ||
                                    ($order->refund && $order->refund->status == 3)) 
                                #4CAF50;
                                width: 100%;
                            @else 
                                #FF9800;
                                width: 70%; @endif
                            ">
                        </div>
                    </div>
                </div>

                {{-- @if ($order->refund != null)
                    <div class="order-status-container mt-3"
                        style="background-color:
                            @if ($order->refund->status == 2) #f44336; 
                            @elseif($order->refund->status == 1 || $order->refund->status == 3) #4CAF50; 
                            @else #FF9800; 
                            @endif">
                        <div class="left">
                            <i class="fa fa-check"></i>
                            <span>
                                @if ($order->refund->status == 2)
                                    İADE TALEBİ REDDEDİLDİ
                                @elseif($order->refund->status == 1)
                                    İADE TALEBİ ONAYLANDI
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
                        style="background-color:
                            @if ($order->status == 2) #f44336; 
                            @elseif($order->status == 1) #4CAF50; 
                            @else #FF9800; 
                            @endif">
                        <div class="left">
                            <i class="fa fa-check"></i>
                            <span>
                                @if ($order->status == 2)
                                    ÖDEME REDDEDİLDİ
                                @elseif($order->status == 1)
                                    ÖDEME ONAYLANDI
                                @else
                                    ÖDEME ONAYI BEKLENİYOR
                                @endif
                            </span>
                        </div>
                    </div>
                @endif --}}

                @if ($order->reference)
                    @if ($order->store_id == Auth::user()->id)
                        <div class="order-status-container mt-3" style="background-color : #1581f5 ">
                            <div class="left">
                                <i class="fa fa-check"></i>
                                <span>
                                    Bu satış <strong>{{ $order->reference->name }}</strong> isimli çalışanızın
                                    referansı ile gerçekleşmiştir.
                                </span>
                            </div>

                        </div>
                    @elseif($order->user_id == Auth::user()->id)
                        <div class="order-status-container mt-3" style="background-color : #1581f5 ">
                            <div class="left">
                                <i class="fa fa-check"></i>
                                <span>
                                    Satış danışmanınız: <strong>{{ $order->reference->name }}</strong>

                                </span>
                            </div>

                        </div>
                    @endif
                @endif

                <div class="order-container">
                    <div class="timeline">
                        <h3>Alıcı Bilgileri</h3>
                        @php
                            if ($order->user->profile_image && file_exists(public_path('storage/profile_images/' . $order->user->profile_image))) {
                                $profileImage = url('storage/profile_images/' . $order->user->profile_image);
                            } else {
                                $profileImage = url('storage/profile_images/indir.png');
                            }
                        @endphp
                        <div class="event">
                            <span class="brand">
                                <img src="{{ $profileImage }}" alt="Profile Image">
                                {{ $order->user->name }}
                                <img src="https://img.icons8.com/ios-filled/50/EA2A28/verified-account.png" alt="Verified Icon" class="verifiedIcon">
                            </span>
                        </div>
                        <div class="event">
                            <p>Telefon</p>
                            <p>{{ $order->user->phone }}</p>
                        </div>
                        <div class="event">
                            <p>E-Posta</p>
                            <p>{{ $order->user->email }}</p>
                        </div>
                    </div>
                    <div class="shipment">
                        <h3>Satıcı Bilgileri</h3>
                        @php
                            if ($order->store->profile_image && file_exists(public_path('storage/profile_images/' . $order->store->profile_image))) {
                                $storeImage = url('storage/profile_images/' . $order->store->profile_image);
                            } else {
                                $storeImage = url('storage/profile_images/indir.png');
                            }
                        @endphp
                        <div class="detail">
                            <span class="brand">
                                <img src="{{ $storeImage }}" alt="Store Image">
                                {{ $order->store->name }}
                                <img src="https://img.icons8.com/ios-filled/50/EA2A28/verified-account.png" alt="Verified Icon" class="verifiedIcon">
                            </span>
                        </div>
                        <div class="detail">
                            <p>Telefon</p>
                            <p>
                                @if (isset($order->store->phone))
                                    {{ $order->store->phone }}
                                @elseif(isset($order->store->mobile_phone))
                                    {{ $order->store->mobile_phone }}
                                @else
                                    Yok
                                @endif
                            </p>
                        </div>
                        <div class="detail">
                            <p>E-Posta</p>
                            <p>{{ $order->store->email }}</p>
                        </div>
                    </div>
                </div>
                {{--                 
                <div class="order-detail-inner mt-3 px-3 py-3">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <p>Sipariş No</p>
                            <span><strong>#{{ $order->id }}</strong></span>
                        </div>
                        <div class="col-md-4 text-center">
                            <p>Sipariş Tarihi</p>
                            <span><strong>{{ date('d', strtotime($order->created_at)) . ' ' . $months[date('n', strtotime($order->created_at)) - 1] . ' ' . date('Y , H:i', strtotime($order->created_at)) }}</strong></span>
                        </div>


                        <div class="col-md-4 text-center">
                            <p>İlan No</p>

                            <a target="_blank"
                                href="{{ $orderCart['type'] == 'housing'
                                    ? route('housing.show', [
                                        'housingSlug' => $orderCart['item']['slug'],
                                        'housingID' => $orderCart['item']['id'] + 2000000,
                                    ])
                                    : route('project.housings.detail', [
                                        'projectSlug' =>
                                            optional(App\Models\Project::find($orderCart['item']['id']))->slug .
                                            '-' .
                                            optional(App\Models\Project::find($orderCart['item']['id']))->step2_slug .
                                            '-' .
                                            optional(App\Models\Project::find($orderCart['item']['id']))->housingtype->slug,
                                        'projectID' => optional(App\Models\Project::find($orderCart['item']['id']))->id + 1000000,
                                        'housingOrder' => $orderCart['item']['housing'],
                                    ]) }}">
                                {{ $order->key }}
                            </a>
                        </div>
                    </div>
                </div> --}}



                <div class="order-detail-inner mt-3 px-3 pt-3 pb-0">
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
                </div>
                <div class="order-detail-inner mt-3 px-3 pt-3 pb-0">
                    <div class="title">
                        <i class="fa fa-edit"></i>
                        <h4>Sipariş Notları </h4>
                    </div>
                    <div class="row py-3 px-3">
                        <textarea name="" class="form-control" style="height: 150px" id="" cols="30" rows="10"
                            readonly>{{ $order->notes }}</textarea>
                    </div>
                </div>


            </div>
            <div class="card p-3">
                <div>
                    <a href="{{ redirect()->back()->getTargetUrl() }}" class="button-back"><i class="fa fa-angle-left"></i>
                        Geri
                        Dön</a>
                </div>
                <div class="order-detail-content mt-3">
                    <h5>#{{ $order->id }} Nolu Sipariş Detayı</h5>
                    <div class="order-details">
                        <div class="order-header">
                            <img src="https://img.icons8.com/ios-filled/50/000000/delivery.png" alt="Delivery Icon">
                            <h3>Be patient, package on deliver!</h3>
                        </div>
                        <div class="order-locations">
                            <div class="location">
                                <img src="https://img.icons8.com/ios-filled/50/000000/marker.png" alt="Location Icon">
                                <p>Malang, Indonesia</p>
                            </div>
                            <div class="location">
                                <img src="https://img.icons8.com/ios-filled/50/000000/marker.png" alt="Location Icon">
                                <p>Emir's House, Indonesia</p>
                            </div>
                        </div>
                        <div class="progress-bar">
                            <div class="progress"></div>
                        </div>
                    </div>
                    @if ($order->refund != null)
                        <div class="order-status-container mt-3"
                            style="@if ($order->refund->status == 2) background-color : #f24734; @elseif($order->refund->status == 1)   @elseif($order->refund->status == 0) background-color :red;  @elseif($order->refund->status == 3) @else background-color : #a3a327 @endif">
                            <div class="left">
                                <i class="fa fa-check"></i>
                                <span>
                                    @if ($order->refund->status == 2)
                                        İADE TALEBİ REDDEDİLDİ
                                    @elseif($order->refund->status == 1)
                                        İADE TALEBİ ONAYLANDI
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
                                        ÖDEME REDDEDİLDİ
                                    @elseif($order->status == 1)
                                        ÖDEME ONAYLANDI
                                    @else
                                        ÖDEME ONAYI BEKLENİYOR
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endif


                    @if ($order->reference)
                        @if ($order->store_id == Auth::user()->id)
                            <div class="order-status-container mt-3" style="background-color : #1581f5 ">
                                <div class="left">
                                    <i class="fa fa-check"></i>
                                    <span>
                                        Bu satış <strong>{{ $order->reference->name }}</strong> isimli çalışanızın
                                        referansı ile gerçekleşmiştir.
                                    </span>
                                </div>

                            </div>
                        @elseif($order->user_id == Auth::user()->id)
                            <div class="order-status-container mt-3" style="background-color : #1581f5 ">
                                <div class="left">
                                    <i class="fa fa-check"></i>
                                    <span>
                                        Satış danışmanınız: <strong>{{ $order->reference->name }}</strong>

                                    </span>
                                </div>

                            </div>
                        @endif
                    @endif

                    <div class="order-detail-inner mt-3 px-3 py-3">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <p>Sipariş No</p>
                                <span><strong>#{{ $order->id }}</strong></span>
                            </div>
                            <div class="col-md-4 text-center">
                                <p>Sipariş Tarihi</p>
                                <span><strong>{{ date('d', strtotime($order->created_at)) . ' ' . $months[date('n', strtotime($order->created_at)) - 1] . ' ' . date('Y , H:i', strtotime($order->created_at)) }}</strong></span>
                            </div>


                            <div class="col-md-4 text-center">
                                <p>İlan No</p>

                                <a target="_blank"
                                    href="{{ $orderCart['type'] == 'housing'
                                        ? route('housing.show', [
                                            'housingSlug' => $orderCart['item']['slug'],
                                            'housingID' => $orderCart['item']['id'] + 2000000,
                                        ])
                                        : route('project.housings.detail', [
                                            'projectSlug' =>
                                                optional(App\Models\Project::find($orderCart['item']['id']))->slug .
                                                '-' .
                                                optional(App\Models\Project::find($orderCart['item']['id']))->step2_slug .
                                                '-' .
                                                optional(App\Models\Project::find($orderCart['item']['id']))->housingtype->slug,
                                            'projectID' => optional(App\Models\Project::find($orderCart['item']['id']))->id + 1000000,
                                            'housingOrder' => $orderCart['item']['housing'],
                                        ]) }}">
                                    {{ $order->key }}
                                </a>
                            </div>
                            {{-- <div class="col-md-3">
                                <p>Ödeme Yöntemi</p>
                                <span><strong>Havale/Eft</strong></span>
                            </div> --}}
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
                                        {{ $order->user->phone }}</span></strong>
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
                            if ($order->store->profile_image) {
                                $storeImage = url('storage/profile_images/' . $order->store->profile_image);
                            } else {
                                $initial = $order->store->name ? strtoupper(substr($order->store->name, 0, 1)) : '';
                                $storeImage = $initial;
                            }
                            //    dd($storeImage)
                        @endphp

                        <div class="row py-3 px-3">
                            <div class="col-3 col-sm-auto">
                                <a target="_blank"
                                    href="{{ route('institutional.dashboard', ['slug' => $order->store->name, 'userID' => $order->store->id]) }}"
                                    class="cursor-pointer avatar avatar-3xl" for="avatarFile"><img class="rounded-circle"
                                        src="{{ $storeImage }}" alt=""></a>
                            </div>
                            <div class="col-md-3">
                                <p>İsim Soyisim</p>
                                <span><strong class="d-flex" style="align-items: center;">
                                        {{ $order->store->name }}</span></strong>
                            </div>

                            <div class="col-md-3">
                                <p>Telefon</p>
                                <span><strong class="d-flex" style="align-items: center;">
                                        @if (isset($order->store->phone))
                                            {{ $order->store->phone }}
                                        @elseif(isset($order->store->mobile_phone))
                                            {{ $order->store->mobile_phone }}
                                        @else
                                            Telefon bilgisi bulunamadı
                                        @endif
                                </span></strong>
                            </div>

                            <div class="col-md-3">
                                <p>E-Posta</p>
                                <span class="word-wrap"><strong class="d-flex " style="align-items: center;">
                                        {{ $order->store->email }}</span></strong>
                            </div>

                        </div>
                    </div>

                    <div class="order-detail-inner mt-3 px-3 pt-3 pb-0">
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
                    </div>
                    <div class="order-detail-inner mt-3 px-3 pt-3 pb-0">
                        <div class="title">
                            <i class="fa fa-edit"></i>
                            <h4>Sipariş Notları </h4>
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


            <div class="row ">

                <div class="col-12">
                    <div class="card mb-3">
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
                                        {{ number_format(json_decode($order->cart)->item->price, 0, ',', '.') }}₺
                                    </p>
                                </div>
                                @if ($tam_tutar != $urun_fiyati)
                                    <div class="d-flex justify-content-between">
                                        <p class="text-body fw-semibold">İndirimli Fiyatı:</p>
                                        <p class="text-body-emphasis fw-semibold">
                                            {{ $tam_tutar_formatli }}
                                        </p>
                                    </div>
                                @endif

                                <!-- Adet -->
                                @if (isset(json_decode($order->cart)->item->qt))
                                    <div class="d-flex justify-content-between">
                                        <p class="text-body fw-semibold">Adet:</p>
                                        <p class="text-danger fw-semibold">{{ json_decode($order->cart)->item->qt }}
                                        </p>
                                    </div>
                                @endif

                                <!-- Kapora Oranı -->
                                <div class="d-flex justify-content-between">
                                    <p class="text-body fw-semibold">Kapora Oranı:</p>
                                    <p class="text-body-emphasis fw-semibold">%{{ $discount_percent }}</p>
                                </div>


                                <!-- Kapora Tutarı -->
                                <div class="d-flex justify-content-between">
                                    <p class="text-body fw-semibold">Kapora Tutarı:</p>
                                    <p class="text-body-emphasis fw-semibold">
                                        {{ number_format(str_replace(',', '', str_replace('.', '', $order->amount)) / 100, 0, ',', '.') }}₺
                                    </p>
                                </div>



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
                                    {{-- {{dd($order->path)}} --}}
                                    <a href="{{ asset($order->path) }}" target="_blank">
                                        <i class="fa fa-file"></i> Dosyayı Görüntüle
                                    </a>
                                @else
                                    <p>PDF dosyası bulunamadı.</p>
                                @endif

                                <div class="order_status mt-3">
                                    <form action="{{ route('institutional.contract.upload.pdf') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <div class="mb-3">
                                            <input type="file" name="pdf_file" class="form-control">
                                        </div>
                                        <button class="btn btn-phoenix-success me-1 mb-1 mt-3"
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
                                            {{-- <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs-9"></span></button>
                                    </div> --}}
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
                                                                                </svg><!-- <span class="fas fa-lock"></span> Font Awesome fontawesome.com --></span></span><span
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
                                                                                </svg><!-- <span class="fas fa-user"></span> Font Awesome fontawesome.com --></span></span><span
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
                                                                                </svg><!-- <span class="fas fa-file-alt"></span> Font Awesome fontawesome.com --></span></span><span
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
                                                                                </svg><!-- <span class="fas fa-check"></span> Font Awesome fontawesome.com --></span></span><span
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
                                                            {{-- Aydınlatma bitişi --}}
                                                            {{-- kullanıcı bilgiler --}}
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
                                                            {{-- kullanıcı bitişi --}}
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
                                                            </svg><!-- <span class="fas fa-chevron-left me-1" data-fa-transform="shrink-3"></span> Font Awesome fontawesome.com -->Geri
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
                                                                </svg><!-- <span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3"> </span> Font Awesome fontawesome.com --></button>
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
            margin: 20px 0;
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
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
            color: white;
            margin-top: 10px;
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

        .timeline .event,
        .shipment .detail {
            margin-bottom: 10px;
        }

        .event time {
            display: block;
            font-size: 14px;
            color: #666;
        }

        .event p {
            margin: 5px 0;
        }

        .event .brand img {
            width: 20px;
            vertical-align: middle;
            margin-right: 5px;
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

        .verifiedIcon{
            width: 15px !important;
            margin-left: 5px
        }
    </style>
@endsection
