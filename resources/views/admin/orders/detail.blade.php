@extends('admin.layouts.master')

@section('content')
    @php 
        $months = [
            "Ocak",
            "Şubat",
            "Mart",
            "Nisan",
            "Mayıs",
            "Haziran",
            "Temmuz",
            "Ağustos",
            "Eylül",
            "Ekim",
            "Kasım",
            "Aralık",
        ];
    @endphp
    <div class="content">
        <div class="breadcrumb">
            <ul>
                <li><i class="fa fa-home"></i> Yönetim Paneli</li>
                <li>Siparişler</li>
                <li>Tüm Siparişler</li>
                <li>#{{$order->id + 3000000}} Nolu Sipariş Detayı</li>
            </ul>
        </div>
        <div class="card p-3">
            <div>
                <a href="" class="button-back"><i class="fa fa-arrow-left"></i> Geri Dön</a>
            </div>
            <div class="order-detail-content mt-3">
                <h5>#{{$order->id + 3000000}} Nolu Sipariş Detayı</h5>
                <div class="order-status-container mt-3" style="@if($order->status == 2) background-color : #f24734; @elseif($order->status == 1) @else background-color : #a3a327 @endif">
                    <div class="left">
                        <i class="fa fa-check"></i>
                        <span>@if($order->status == 2) ÖDEMEYİ REDDETTİNİZ @elseif($order->status == 1) ÖDEMEYİ ONAYLADINIZ @else ÖDEMEYİ ONAYI BEKLENİYOR @endif</span>
                    </div>
                    <div class="right">
                        <a href="" class="button-rotate-back"><i class="fa fa-arrow-rotate-left"></i> Geri Al</a>
                    </div>
                </div>
                <div class="order-detail-inner mt-3 px-3 py-3">
                    <div class="row">
                        <div class="col-md-3">
                            <p>Sipariş No</p>
                            <span><strong>#{{$order->id + 3000000}}</strong></span>
                        </div>
                        <div class="col-md-3">
                            <p>Sipariş Tarihi</p>
                            <span><strong>{{date('d',strtotime($order->created_at)).' '.$months[date('n',strtotime($order->created_at)) - 1].' '.date('Y , H:i',strtotime($order->created_at))}}</strong></span>
                        </div>
                        <div class="col-md-3">
                            <p>Sipariş Sahibi</p>
                            <span ><strong class="d-flex" style="align-items: center;"><i class="fa fa-user"></i><span class="mx-2 d-block">{{$order->user->name}}</span></strong></span>
                        </div>
                        <div class="col-md-3">
                            <p>Ödeme Yöntemi</p>
                            <span><strong>Havale/Eft</strong></span>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="order-detail-inner px-3 py-3">
                            <div class="title">
                                <h5>Sipariş Durumu</h5>
                            </div>
                            <div class="order-status-change mt-2">
                                <select name="" class="form-control" id="">
                                    <option value="" @if($order->status == 0) selected @endif>Ödeme Onayı Bekleniyor</option>
                                    <option value="" @if($order->status == 2) selected @endif>Ödeme Reddedildi</option>
                                    <option value="" @if($order->status == 1) selected @endif>Ödeme Onaylandı</option>
                                </select>
                                <div class="border-line mb-1 mt-3"></div>
                                <div class="order-not-cancel">
                                    <span>Üyeler siparişlerini dilerse iptal edebilirler. Aşağıdan iptal edilemez alanını aktif ederseniz iptal etme işlemini gerçekleştiremezler.</span>
                                    <div class="checkbox">
                                        <input type="checkbox" id="not-cancel">
                                        <label for="not-cancel">Üye, Bu Siparişi İptal Edemesin</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="order-detail-inner px-3 py-3">
                            <div class="title">
                                <h5>Hakediş Durumu</h5>
                            </div>
                            <div class="order-status-change mt-2">
                                <select name="" class="form-control" id="">
                                    <option value="" >Hakediş Durumu Bekleniyor</option>
                                    <option value="">Hakediş Onaylandı</option>
                                    <option value="">Hakediş Reddedildi</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="order-detail-inner px-3 py-3">
                            <div class="title">
                                <h5>Alıcı Bilgileri</h5>
                            </div>
                            <div class="order-user-info">
                                <span class="mt-3 mb-3 d-block">{{$order->user->name}}</span>
                                <div class="border-line mb-1 mt-1"></div>
                                <span class="mt-2 mb-2 d-block"><strong>TELEFON NUMARASI</strong> : {{$order->user->phone}}</span>
                                <div class="border-line mb-1 mt-1"></div>
                                <span class="mt-2 mb-2 d-block"><strong>E-POSTA ADRESİ</strong> : {{$order->user->email}}</span>
                                <div class="border-line mb-1 mt-1"></div>
                            </div>
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
                                            <img src="{{ asset('housing_images/' . json_decode(App\Models\Housing::find(json_decode($order->cart)->item->id ?? 0)->housing_type_data ?? '[]')->image ?? null) }}" alt="">
                                        @else
                                            <img src="{{ URL::to('/') . '/project_housing_images/' }}"
                                                style="object-fit: cover;width:100px;height:75px" alt="Görsel">
                                        @endif
                                        
                                    </div>
                                    <div class="product-text-info">
                                        <p><strong>{{json_decode($order->cart)->item->title}}</strong></p>
                                        <p>İlan kodu : <strong>{{$order->key}}</strong></p>
                                    </div>
                                </div>
                                <div class="product-status flex-1">
                                    <label for="">Ürün satış durumu</label>
                                    <select name="" class="form-control mt-1" id="">
                                        <option value="">İki taraf arasında satış onaylandı</option>
                                    </select>
    
                                    <button class="button-back mt-2 w-150px">Kaydet</button>
                                </div>
                            </div>
                            <div class="order-detail-product-2">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="product-order-card">
                                            <h5>Ürün Fiyatı</h5>
                                            <div class="border-line mt-1 mb-1"></div>
                                            <span>{{number_format(json_decode($order->cart)->item->price, 0, ',', '.')}}₺</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="product-order-card">
                                            <h5>Adet</h5>
                                            <div class="border-line mt-1 mb-1"></div>
                                            <span>1</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="product-order-card">
                                            <h5>Kapora Yüzdesi</h5>
                                            <div class="border-line mt-1 mb-1"></div>
                                            <span>2%</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="product-order-card">
                                            <h5>Kapora Tutarı</h5>
                                            <div class="border-line mt-1 mb-1"></div>
                                            <span>{{number_format(str_replace(',','',str_replace('.','',$order->amount )) / 100, 0, ',', '.')}}₺</span>
                                        </div>
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
                        <textarea name="" class="form-control" style="height: 150px" id="" cols="30" rows="10">{{$order->notes}}</textarea>
                    </div>
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
