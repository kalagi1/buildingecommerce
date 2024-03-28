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
    <div class="content">
        <div class="breadcrumb">
            <ul>
                <li><i class="fa fa-home"></i> Yönetim Paneli</li>
                <li>Siparişler</li>
                <li>Tüm Siparişler</li>
                <li>#{{ $order->id + 3000000 }} Nolu Sipariş Detayı</li>
            </ul>
        </div>
        <div class="row g-5 gy-7">
            <div class="col-12 col-xl-8 col-xxl-9">
                <div class="card p-3">
                    <div>
                        <a href="{{route('admin.orders')}}" class="button-back"><i class="fa fa-angle-left"></i> Geri Dön</a>
                    </div>
                    <div class="order-detail-content mt-3">
                        <h5>#{{ $order->id + 3000000 }} Nolu Sipariş Detayı</h5>
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
                                        ÖDEMEYİ ONAYI BEKLENİYOR
                                    @endif
                                </span>
                            </div>
                            
                        </div>

                       
                        <div class="order-detail-inner mt-3 px-3 py-3">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <p>Sipariş No</p>
                                    <span><strong>#{{ $order->id + 3000000 }}</strong></span>
                                </div>
                                
                                <div class="col-md-4 text-center">
                                    <p>Sipariş Tarihi</p>
                                    <span><strong>{{ date('d', strtotime($order->created_at)) . ' ' . $months[date('n', strtotime($order->created_at)) - 1] . ' ' . date('Y , H:i', strtotime($order->created_at)) }}</strong></span>
                                </div>
        

                                @php
                                    $orderCart = json_decode($order->cart, true);
                                @endphp
                                <div class="col-md-4 text-center">
                                    <p>İlan No</p>
                                    <a
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
                                <div class="col-3 col-sm-auto"><label
                                    class="cursor-pointer avatar avatar-3xl" for="avatarFile"><img
                                        class="rounded-circle" src="{{ $profileImage }}"
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
                                        @if(isset($order->user->phone))
                                        {{ $order->user->phone }}
                                    @elseif(isset($order->user->mobile_phone))
                                        {{ $order->user->mobile_phone }}
                                    @else
                                        Telefon bilgisi bulunamadı
                                    @endif</span></strong>
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
                               
                          @endphp

                            <div class="row py-3 px-3">
                                <div class="col-3 col-sm-auto"><label
                                    class="cursor-pointer avatar avatar-3xl" for="avatarFile"><img
                                        class="rounded-circle" src="{{ $storeImage }}"
                                        alt=""></label>
                                </div>
                                <div class="col-md-3">
                                    <p>İsim Soyisim</p>
                                    <span><strong class="d-flex" style="align-items: center;">
                                            {{ $order->store->name }}</span></strong>
                                </div>

                                <div class="col-md-3">
                                    <p>Telefon</p>
                                    <span><strong class="d-flex" style="align-items: center;">
                                        @if(isset($order->store->phone))
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
                                    <span><strong class="d-flex" style="align-items: center;">
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
                                                @php($o = json_decode($order->cart))
                                                @if ($o->type == 'housing')
                                                    <img src="{{ asset('housing_images/' . json_decode(App\Models\Housing::find(json_decode($order->cart)->item->id ?? 0)->housing_type_data ?? '[]')->image ?? null) }}"
                                                    style="object-fit: cover;width:100px;height:75px"  alt="">
                                                @else
                                                    <img src="{{ URL::to('/') . '/project_housing_images/' }}"
                                                        style="object-fit: cover;width:100px;height:75px" alt="Görsel">
                                                @endif

                                            </div>
                                            <div class="product-text-info ">
                                                <p><strong>{{ json_decode($order->cart)->item->title }} <strong>{{ json_decode($order->cart)->type == 'project' ? json_decode($order->cart)->item->housing : null }} No'lu Konut </strong></strong></p>
                                                
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


                <div class="row">

                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h3 class="card-title mb-4">Özet</h3>
                                <div>
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
                                    <div class="d-flex justify-content-between">
                                        <p class="text-body fw-semibold">Ürün Fiyatı:</p>
                                        <p class="text-body-emphasis fw-semibold">
                                            {{ number_format(json_decode($order->cart)->item->price, 0, ',', '.') }}₺</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="text-body fw-semibold">Adet:</p>
                                        <p class="text-danger fw-semibold">1</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="text-body fw-semibold">Kapora Yüzdesi:</p>
                                        <p class="text-body-emphasis fw-semibold">%2</p>
                                    </div>
                                </div>
                                <div
                                    class="d-flex justify-content-between border-top border-translucent border-dashed pt-4">
                                    <h4 class="mb-0">Kapora Tutarı:</h4>
                                    <h4 class="mb-0">
                                        {{ number_format(str_replace(',', '', str_replace('.', '', $order->amount)) / 100, 0, ',', '.') }}₺
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title mb-4">Sipariş Durumu</h3>
                                <h6 class="mb-2"></h6>
                                <div class="order_status">

                                    <select class="form-select mb-4"  name="status" id="status" onchange="submitForm()">
                                        <option value="{{ route('admin.approve-order', ['cartOrder' => $order->id]) }}" @if($order->status == 1) selected @endif>İlan Satışını Onayla</option>
                                        <option value="{{ route('admin.unapprove-order', ['cartOrder' => $order->id]) }}" @if($order->status != 1) selected @endif>İlan Satışını Reddet</option>
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
                                
                                @if (isset($order->share))
                                    <select class="form-select mb-4" onchange="submitFormPriceAndShare(this)">
                                        <option value="{{ route('admin.approve-share', ['share' => $order->share->id]) }}" @if($order->share->status == 1) selected @endif>Hakedişleri Onayla</option>
                                        <option value="{{ route('admin.unapprove-share', ['share' => $order->share->id]) }}" @if($order->share->status != 1) selected @endif>Hakedişleri Reddet</option>
                                     </select>
                                
                                    <form id="status-form" action="#" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                              @endif
                                 
                                 @if (isset($order->price))
                                 <select class="form-select mb-4" onchange="submitFormPriceAndShare(this)">
                                    <option value="{{ route('admin.approve-price', ['price' => $order->price->id]) }}" @if($order->price->status == 1) selected @endif>Hakedişleri Onayla</option>
                                    <option value="{{ route('admin.unapprove-price', ['price' => $order->price->id]) }}" @if($order->price->status != 1) selected @endif>Hakedişleri Reddet</option>
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
                                
                                <td class="order_status align-middle text-center fw-semibold text-body-highlight">{!! [
                                                '0' => '<span class="text-warning">Rezerve Edildi</span>',
                                                '1' => '<span class="text-success">Satış Onaylandı</span>',
                                                '2' => '<span class="text-danger">Satış Reddedildi</span>',
                                            ][$order->status] !!} <br>
                                                @if (isset($order->share))
                                                    <span class="text-warning">Bu ilan emlak kulüp aracılığı ile
                                                        satılmıştır.
                                                        @if ($order->share->status == 1)
                                                            <br>
                                                            Hakedişler Onaylandı.
                                                        @endif
                                                    </span>
                                                @endif
                                                @if (isset($order->price) && $order->price->status == 1)
                                                    <span class="text-success">Hakedişler Onaylandı.</span>
                                                @endif

                                                @if (isset($order->price) && $order->price->status == 0)
                                                    <span class="text-warning">Hakediş onayı bekleniyor.</span>
                                                @endif

                                                @if (isset($order->price) && $order->price->status == 2)
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


    
    function submitForm(){
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
