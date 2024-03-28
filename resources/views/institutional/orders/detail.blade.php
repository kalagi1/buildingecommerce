@extends('institutional.layouts.master')

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
                {{-- bireysel ise  hesabım kurumsal ise  mağazam  --}}
                <li><i class="fa fa-home"></i> {{ $userType = Auth::user()->type == 1 ? 'Hesabım' : 'Mağazam' }}</li>
                <li>Siparişler</li>
                <li>Tüm Siparişler</li>
                <li>#{{ $order->id }} Nolu Sipariş Detayı</li>
            </ul>
        </div>
        <div class="row g-5 gy-7">
            <div class="col-12 col-xl-8 col-xxl-9">
                <div class="card p-3">
                    <div>
                        <a href="{{ redirect()->back()->getTargetUrl() }}" class="button-back"><i class="fa fa-angle-left"></i>
                            Geri
                            Dön</a>
                    </div>
                    <div class="order-detail-content mt-3">
                        <h5>#{{ $order->id }} Nolu Sipariş Detayı</h5>
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
                        <div class="order-detail-inner mt-3 px-3 py-3">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <p>Sipariş No</p>
                                    <span><strong>#{{ $order->id  }}</strong></span>
                                </div>
                                <div class="col-md-4 text-center">
                                    <p>Sipariş Tarihi</p>
                                    <span><strong>{{ date('d', strtotime($order->created_at)) . ' ' . $months[date('n', strtotime($order->created_at)) - 1] . ' ' . date('Y , H:i', strtotime($order->created_at)) }}</strong></span>
                                </div>
                                
                                
                                @php
                                    $orderCart = json_decode($order->cart, true) 
                                @endphp
                            <div class="col-md-4 text-center">
                                <p>İlan No</p>

                                <a  target="_blank"
                                href="{{ $orderCart['type'] == 'housing'
                                    ? route('housing.show', ['housingSlug' => $orderCart['item']['slug'], 'housingID' => $orderCart['item']['id'] + 2000000])
                                    : route('project.housings.detail', [
                                        'projectSlug' => optional(App\Models\Project::find($orderCart['item']['id']))->slug .
                                            '-' .
                                            optional(App\Models\Project::find($orderCart['item']['id']))->step2_slug .
                                            '-' .
                                            optional(App\Models\Project::find($orderCart['item']['id']))->housingtype->slug,
                                        'projectID' => optional(App\Models\Project::find($orderCart['item']['id']))->id + 1000000,
                                        'housingOrder' => $orderCart['item']['housing'],
                                    ]) }}">
                                    {{$order->key}} 
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
                                    <a target="_blank" href="{{ route('institutional.dashboard', ["slug" => $order->store->name, "userID" =>$order->store->id ]) }}"
                                    class="cursor-pointer avatar avatar-3xl" for="avatarFile"><img
                                        class="rounded-circle" src="{{ $storeImage }}"
                                        alt=""></a>
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
                                <textarea name="" class="form-control" style="height: 150px" id="" cols="30" rows="10" readonly>{{ $order->notes }}</textarea>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
            <div class="col-12 col-xl-4 col-xxl-3">


                <div class="row mt-3">

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
                                    {{-- <div class="d-flex justify-content-between">
                                        <p class="text-body fw-semibold">Subtotal :</p>
                                        <p class="text-body-emphasis fw-semibold">$665</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="text-body fw-semibold">Shipping Cost :</p>
                                        <p class="text-body-emphasis fw-semibold">$30</p>
                                    </div> --}}
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

                                    <span class="text-success">

                                        {{-- class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"> --}}
                                        {!! [
                                            '0' => '<span class="badge badge-phoenix fs-10 badge-phoenix-warning"><span
                                                                                                                                                                                                                                                                    class="badge-label">Rezerve Edildi</span><svg
                                                                                                                                                                                                                                                                    xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                                                                                                                                                                                                                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                                                                                                                                                                                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                                                                                                                                                                                                                    class="feather feather-check ms-1" style="height:12.8px;width:12.8px;">
                                                                                                                                                                                                                                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                                                                                                                                                                                                                                </svg>',
                                            '1' => '<span class="badge badge-phoenix fs-10 badge-phoenix-success"><span
                                                                                                                                                                                                                                                                    class="badge-label">Ödeme Onaylandı</span><svg
                                                                                                                                                                                                                                                                    xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                                                                                                                                                                                                                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                                                                                                                                                                                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                                                                                                                                                                                                                    class="feather feather-check ms-1" style="height:12.8px;width:12.8px;">
                                                                                                                                                                                                                                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                                                                                                                                                                                                                                </svg>',
                                            '2' => '<span class="badge badge-phoenix fs-10 badge-phoenix-danger"><span
                                                                                                                                                                                                                                                                    class="badge-label">Ödeme Reddedildi</span><svg
                                                                                                                                                                                                                                                                    xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                                                                                                                                                                                                                            class="feather feather-check ms-1" style="height:12.8px;width:12.8px;">
                                                                                                                                                                                                                                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                                                                                                                                                                                                                                </svg>',
                                        ][$order->status] !!}
                                    </span>



                                </div>
                                
                                {{-- <h6 class="mb-2">Fulfillment status</h6><select class="form-select"
                                    aria-label="delivery type">
                                    <option value="cod">Unfulfilled</option>
                                    <option value="card">Fulfilled</option>
                                    <option value="paypal">Pending</option>
                                </select> --}}
                            </div>
                        </div>
                    </div>

                    @if(Auth::check() && Auth::user()->id == $order->store->id)
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
                                    <form action="{{ route('institutional.contract.upload.pdf') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}"> 
                                        <div class="mb-3">
                                            <input type="file" name="pdf_file" class="form-control">
                                        </div>
                                        <button class="btn btn-phoenix-success me-1 mb-1 mt-3" type="submit">Yükle</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                

                   
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

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
