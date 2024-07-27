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
                                            SİPARİŞ REDDEDİLDİ
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

                    </div>
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
                            @if ($order->invoice)
                                <a href="{{ route('institutional.invoice.show', hash_id($order->id)) }}"
                                    class="btn btn-primary">Faturayı Görüntüle</a>
                            @endif

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
                                    <i class=""><img class="pay-icon"
                                            src="{{ asset('images/template/guard-icon.png') }}" alt=""></i>
                                </div>
                                <div class="status-header">
                                    <div class="status-title text-success">Kaparonız Emlak Sepette ile Güvende</div>
                                    <div class="status-description">Satıcı satışı gerçekleştirdi. Siparişi inceleyip
                                        onaylamanız
                                        bekleniyor.</div>
                                </div>

                                @if (isset($order->share) && optional($order->share)->status != 1)
                                    <div class="approve-button">
                                        <a class="btn btn-success"
                                            href="{{ route('client.approve-share', ['share' => $order->share->id]) }}"
                                            @if ($order->share->status == 1) disabled @endif>
                                            Onayla</a>
                                        {{-- <button class="btn btn-danger"
                                            onclick="submitFormPriceAndShare('{{ route('client.unapprove-share', ['share' => $order->share->id]) }}')"
                                            @if ($order->share->status != 1) disabled @endif>Hakedişleri
                                            Reddet</button> --}}

                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">İptal Et</button>
                                    </div>
                                @endif

                                @if (isset($order->price) && optional($order->price)->status != 1)
                                    <div class="approve-button">

                                        <a class="btn btn-success"
                                            href="{{ route('client.approve-price', ['price' => $order->price->id]) }}"
                                            @if ($order->price->status == 1) disabled @endif>Onayla
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

                            @if (($order->share && $order->share->status == 1) || ($order->price && $order->price->status == 1))
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

                                @if ($cartType == "housing" && canUserAddComment($cartId))
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
                                                            value="{{ $cartType }}" />
                                                        <input type="hidden" name="id" id="id"
                                                            value="{{ $cartId }}" />

                                                        <div class="d-flex align-items-center w-full" style="gap: 6px;">
                                                            <div class="d-flex rating-area">
                                                                <svg class="rating" enable-background="new 0 0 50 50"
                                                                    height="24px" id="Layer_1" version="1.1"
                                                                    viewBox="0 0 50 50" width="24px"
                                                                    xml:space="preserve"
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
                                                                    viewBox="0 0 50 50" width="24px"
                                                                    xml:space="preserve"
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
                                                                    viewBox="0 0 50 50" width="24px"
                                                                    xml:space="preserve"
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
                                                                    viewBox="0 0 50 50" width="24px"
                                                                    xml:space="preserve"
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
                                                                    viewBox="0 0 50 50" width="24px"
                                                                    xml:space="preserve"
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
                                                                <input type="file" style="display: none;"
                                                                    class="fileinput" name="images[]" multiple
                                                                    accept="image/*" />
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
                                @elseif ($cartType == "project" && canUserAddProjectComment($cartId))
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
                                                            value="{{ $cartType }}" />
                                                        <input type="hidden" name="id" id="id"
                                                            value="{{ $cartId }}" />

                                                        <div class="d-flex align-items-center w-full" style="gap: 6px;">
                                                            <div class="d-flex rating-area">
                                                                <svg class="rating" enable-background="new 0 0 50 50"
                                                                    height="24px" id="Layer_1" version="1.1"
                                                                    viewBox="0 0 50 50" width="24px"
                                                                    xml:space="preserve"
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
                                                                    viewBox="0 0 50 50" width="24px"
                                                                    xml:space="preserve"
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
                                                                    viewBox="0 0 50 50" width="24px"
                                                                    xml:space="preserve"
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
                                                                    viewBox="0 0 50 50" width="24px"
                                                                    xml:space="preserve"
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
                                                                    viewBox="0 0 50 50" width="24px"
                                                                    xml:space="preserve"
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
                                                                <input type="file" style="display: none;"
                                                                    class="fileinput" name="images[]" multiple
                                                                    accept="image/*" />
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
                                @else
                                    <div class="accordion" id="accordionPanelsStayOpenExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                                    aria-controls="panelsStayOpen-collapseOne">

                                                </button>
                                            </h2>
                                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                                <div class="accordion-body">
                                                    Yorumunuz Başarılıyla Gönderilmiştir.
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endif
                            @endif
                        @endif
                    </div>
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
                    <div class="card mb-3 summary-padding">
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
                    <div class="card mb-3 summary-padding">
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
                    <div class="card mb-3 summary-padding">
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
                        <div class="card summary-padding">
                            <div class="card-body">
                                <h3 class="card-title mb-4">Sözleşme Yükle</h3>
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
                                        <div class="col-md-12 p-0">
                                            <div class="file-drop-area">
                                                <span class="fake-btn"> <i class="fa fa-cloud-upload"></i>Sözleşme
                                                    Yükle</span>
                                                <span class="file-msg">Yüklemek için buraya tıklayın</span>
                                                <label class="form-label" for="image"> </label><br>
                                                <input name="pdf_file" class="form-control file-input h-120"
                                                    id="image" type="file" accept="image/*" required>
                                                <div class="valid-feedback">İyi Görünüyor !</div>
                                            </div>
                                        </div>
                                        <button class="btn btn-success me-1 mb-1 mt-3" type="submit">Yükle</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($order->status == '1')
                    <div class="col-12">
                        <div class="card summary-padding">
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

                                <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1"
                                    aria-hidden="true">

                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body">


                                                <div class="">
                                                    <div class="progress">
                                                        <div class="progress-bar
                                                                    progress-bar-striped bg-success"
                                                            role="progressbar" style="width: 0%" aria-valuenow="0"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>

                                                    <div class="step active">
                                                        <p class="text-center mb-4">İade İşlemi</p>
                                                        <div class="mb-3">
                                                            @if (file_exists(public_path('refundpolicy/iadeislemleri.pdf')))
                                                                <iframe
                                                                    src="{{ asset('refundpolicy/iadeislemleri.pdf') }}"
                                                                    width="100%" height="400px">
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
                                                                style="white-space: nowrap;" id="wizardValidationForm1"
                                                                novalidate="novalidate" data-wizard-form="1">
                                                                @csrf
                                                                <input type="hidden" name="cart_order_id"
                                                                    value="{{ $order->id }}">

                                                                <div class="custom-checkbox">
                                                                    <input type="checkbox" name="terms"
                                                                        required="required">
                                                                    <span class="checkmark"></span>
                                                                    <label class="form-check-label text-body"
                                                                        for="bootstrap-wizard-validation-wizard-checkbox">
                                                                        Aydınlatma Metinini Okudum Onaylıyorum
                                                                    </label>
                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>

                                                    <div class="step">
                                                        <p class="text-center mb-4">Gerekli Bilgiler</p>
                                                        <form class="needs-validation" id="wizardValidationForm2"
                                                            novalidate="novalidate" data-wizard-form="2">
                                                            @csrf


                                                            <div class="mb-2"><label class="form-label"
                                                                    for="bootstrap-wizard-validation-wizard-phone">Ad
                                                                    Soyad</label><input class="form-control"
                                                                    type="text" name="name" placeholder="Ad Soyad"
                                                                    id="bootstrap-wizard-validation-wizard-phone"
                                                                    required="required">
                                                                <div class="invalid-feedback">Alan Zorunludur.
                                                                </div>
                                                            </div>
                                                            <div class="mb-2"><label class="form-label"
                                                                    for="bootstrap-wizard-validation-wizard-phone">Ad
                                                                    Soyad</label><input class="form-control"
                                                                    type="text" name="name" placeholder="Ad Soyad"
                                                                    id="bootstrap-wizard-validation-wizard-phone"
                                                                    required="required">
                                                                <div class="invalid-feedback">Alan Zorunludur.
                                                                </div>
                                                            </div>

                                                            <div class="mb-2"><label class="form-label"
                                                                    for="bootstrap-wizard-validation-wizard-phone">Telefon
                                                                    Numarası</label><input
                                                                    class="form-control phoneControl" type="text"
                                                                    name="phone" placeholder="Telefon Numarası"
                                                                    id="bootstrap-wizard-validation-wizard-phone"
                                                                    required="required" maxlength="10">
                                                                <span id="error_message" class="error-message"></span>
                                                                <div class="invalid-feedback">Alan Zorunludur.
                                                                </div>
                                                            </div>

                                                            <div class="mb-2"><label class="form-label"
                                                                    for="bootstrap-wizard-validation-wizard-phone">E-Posta</label><input
                                                                    class="form-control" type="email" name="email"
                                                                    placeholder="E-Posta"
                                                                    id="bootstrap-wizard-validation-wizard-phone"
                                                                    required="required">
                                                                <div class="invalid-feedback">Alan Zorunludur.
                                                                </div>
                                                            </div>

                                                            @if ($order->payment_result && $order->payment_result !== '')
                                                            @else
                                                                <div class="mb-2"><label class="form-label"
                                                                        for="bootstrap-wizard-validation-wizard-phone">İade
                                                                        Yapılacak Banka</label><input class="form-control"
                                                                        type="text" name="return_bank"
                                                                        placeholder="Banka"
                                                                        id="bootstrap-wizard-validation-wizard-phone"
                                                                        required="required">
                                                                    <div class="invalid-feedback">Alan
                                                                        Zorunludur.
                                                                    </div>
                                                                </div>

                                                                <div class="mb-2"><label class="form-label"
                                                                        for="bootstrap-wizard-validation-wizard-phone">İade
                                                                        Yapılacak IBAN</label><input class="form-control"
                                                                        type="text" name="return_iban"
                                                                        placeholder="IBAN"
                                                                        id="bootstrap-wizard-validation-wizard-phone"
                                                                        required="required" oninput="formatIBAN(this)">
                                                                    <div class="invalid-feedback">Alan
                                                                        Zorunludur.
                                                                    </div>
                                                                </div>
                                                            @endif



                                                        </form>
                                                    </div>

                                                    <div class="step">
                                                        <p class="text-center mb-4"> Sipariş İptal Sebebiniz</p>
                                                        <form class="mb-2 needs-validation" id="wizardValidationForm3"
                                                            novalidate="novalidate" data-wizard-form="3">
                                                            @csrf
                                                            <div class="row gx-3 gy-2">
                                                                <div class="col-12"><label class="form-label"
                                                                        for="bootstrap-wizard-validation-card-number">

                                                                    </label>
                                                                    <textarea id="editor" class="form-control" name="content" placeholder="Sipariş İptal Sebebiniz"
                                                                        style="height: 300px !important; width: 100%; resize: vertical;" required></textarea>
                                                                </div>
                                                            </div>

                                                        </form>
                                                    </div>

                                                    <div class="form-footer d-flex">
                                                        <button type="button" id="prevBtn"
                                                            onclick="nextPrev(-1)">Geri</button>
                                                        <button type="button" id="nextBtn"
                                                            onclick="nextPrev(1)">İleri</button>
                                                    </div>
                                                </div>

                                                {{-- <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
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

                                                   
                                                    <div class="card-body pt-4 pb-0">
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" role="tabpanel"
                                                                aria-labelledby="bootstrap-wizard-validation-tab1"
                                                                id="bootstrap-wizard-validation-tab1">
                                                                
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
                                                </div> --}}
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

    <script>
        let currentTab = 0;
     // Başlangıç tabı

    function showTab(n) {
        let tabs = document.getElementsByClassName("step");
        tabs[n].style.display = "block";
        document.getElementById("prevBtn").style.display = n === 0 ? "none" : "inline";
        document.getElementById("nextBtn").innerHTML = n === tabs.length - 1 ? "Tamamla" : "İleri";
    }

    function nextPrev(n) {
        let tabs = document.getElementsByClassName("step");
        
        // Mevcut adımı gizle
        tabs[currentTab].style.display = "none";
        
        // Yeni adımı güncelle
        currentTab += n;
        
        // Eğer tüm adımlar tamamlandıysa formu gönder
        if (currentTab >= tabs.length) {
            submitForms(); // formu gönder
            return false;
        }
        
        // Adımı göster
        showTab(currentTab);
    }

    function validateForm() {
    let valid = true;
    let step = document.getElementsByClassName("step")[currentTab];
    
    // Input ve textarea elementlerini seç
    let inputs = step.querySelectorAll("input:not([type='checkbox']), textarea");
    let checkboxes = step.querySelectorAll("input[type='checkbox']");

    // Her input ve textarea için doğrulama
    inputs.forEach(input => {
        if (input.value.trim() === "") {
            input.classList.add("invalid");
            valid = false;
        } else {
            input.classList.remove("invalid");
        }
    });

    // Checkbox doğrulaması
    checkboxes.forEach(checkbox => {
        if (!checkbox.checked) {
            checkbox.classList.add("invalid-checkbox");
            valid = false;
        } else {
            checkbox.classList.remove("invalid-checkbox");
        }
    });

    // Event listener ekleme (Her bir input ve checkbox için bir kez eklenir)
    // Bu listener'lar, kullanıcı formu doldururken boş olan alanları kontrol eder.
    inputs.forEach(input => {
        input.removeEventListener('input', handleInputChange); // Eski event listener'ları temizle
        input.addEventListener('input', handleInputChange);
    });

    checkboxes.forEach(checkbox => {
        checkbox.removeEventListener('change', handleCheckboxChange); // Eski event listener'ları temizle
        checkbox.addEventListener('change', handleCheckboxChange);
    });

    function handleInputChange() {
        if (this.value.trim() !== "") {
            this.classList.remove("invalid");
        } else {
            this.classList.add("invalid");
        }
    }

    function handleCheckboxChange() {
        if (this.checked) {
            this.classList.remove("invalid-checkbox");
        } else {
            this.classList.add("invalid-checkbox");
        }
    }

    return valid;
}








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
                    resetForm();
                    location.reload();

                },
                error: function(xhr, status, error) {
                    // Hata durumunda burada bir işlem yapabilirsiniz
                    toastr.error('İade talebi gönderilirken bir hata oluştu. Tekrar Deneyiniz');
                    console.error(error);
                }
            });
        }

        function resetForm() {
            let x = document.getElementsByClassName("step");
            for (var i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            let inputs = document.querySelectorAll("input");
            inputs.forEach(input => {
                input.value = "";
                input.className = "";
            });
            currentTab = 0;
            showTab(currentTab);
            document.querySelector(".progress-bar")
                .style.width = "0%";
            document.querySelector(".progress-bar")
                .setAttribute("aria-valuenow", 0);
            document.getElementById("prevBtn")
                .style.display = "none";
        }
    </script>


    <script>
        jQuery('.rating-area .rating').on('mouseover', function() {
            jQuery('.rating-area .rating polygon').attr('fill', 'none');
            for (var i = 0; i <= $(this).index(); ++i)
                jQuery('.rating-area .rating polygon').eq(i).attr('fill', 'gold');
        });

        jQuery('.rating-area .rating').on('mouseleave', function() {
            jQuery('.rating-area .rating:not(.selected) polygon').attr('fill', 'none');
        });

        jQuery('.rating-area .rating').on('click', function() {
            jQuery('.rating-area .rating').removeClass('selected');
            for (var i = 0; i <= $(this).index(); ++i)
                jQuery('.rating-area .rating').eq(i).addClass('selected');

            $('#rate').val($(this).index() + 1);
        });

        function validateForm() {
            let isValid = true;

            // Gerekli inputları seç ve kontrol et
            const requiredFields = ['comment']; // Gerekli input isimlerini ekleyin
            requiredFields.forEach(fieldName => {
                const field = document.querySelector(`[name="${fieldName}"]`);
                if (field && (field.value === '' || field.value == null)) {
                    field.classList.add('is-invalid'); // Bootstrap kullanıyorsanız
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid'); // Bootstrap kullanıyorsanız
                }
            });

            return isValid;
        }

        function submitForm() {


            if (!validateForm()) {
                toastr.error('Lütfen tüm gerekli alanları doldurun.');
                return;
            }
            // Rate değerini al
            var rateValue = $('#rate').val();

            // Eğer rate değeri boş veya 0 ise, 1 olarak ayarla
            if (rateValue === '' || rateValue === '0') {
                $('#rate').val('1');
            }


            var formData = new FormData($('#commentForm')[0]);



            $.ajax({
                url: "{{ route('client.commentAfterPayment') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Yorum Gönderildi',
                        text: 'Yorumunuz admin onayladıktan sonra yayınlanacaktır.',
                    }).then(function() {
                        location.reload(); // Reload the page
                    });
                },
                error: function(error) {
                    console.error('AJAX Error:', error);
                    //console.log(error);
                }
            });
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
