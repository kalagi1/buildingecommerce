@extends('client.layouts.master')

@section('content')
    <section class="recently portfolio bg-white homepage-5 ">
        <div class="container">


            <div class="row" style="justify-content: end">
                <div class="col-md-8 mt-5">
                    <div class="my-choose mb-3 d-flex align-items-center justify-content-between flex-wrap">
                        {{-- {{$cart['item']['payment-plan']}} --}}
                        @if (isset($cart['item']) && $cart['item']['installmentPrice'])
                            <div class="payment-options">
                                <div class="custom-option pesin-option {{ $cart['item']['payment-plan'] === 'pesin' ? 'selected' : '' }}"
                                    data-value="pesin">
                                    Peşin Fiyat ile Ödeme
                                </div>
                                <div class="custom-option taksitli-option {{ $cart['item']['payment-plan'] === 'taksitli' ? 'selected' : '' }}"
                                    data-value="taksitli">
                                    Taksitli Fiyat ile Ödeme
                                </div>
                            </div>
                        @endif
                        <div class="clearButtons">
                            @if (isset($cart['item']))
                                <button type="button" class="btn btn-close-cart remove-from-cart"
                                    style="background: #EA2B2E;padding:5px;height:auto !important; color: white; font-size: 12px;">
                                    <i class="fa fa-times"></i> Sepeti Temizle
                                </button>
                            @endif
                            <button type="button" class="btn btn-close-cart"
                                style="background: black;padding:5px;height:auto !important; color: white; font-size: 12px;"
                                onclick="window.location.href='{{ route('index') }}'">
                                <i class="fa fa-times"></i> Kapat
                            </button>
                        </div>
                    </div>

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

                    @if (isset($cart['item']) && isset($cart['item']['payment-plan']))
                        <div
                            class="my-properties p-0 my-choose mb-3 {{ $cart['item']['payment-plan'] === 'pesin' ? 'd-none' : 'd-block' }}">
                            <table class="table-responsive">
                                <tbody>
                                    <tr>
                                        <td><strong>Peşinat</strong>
                                            <br>{{ number_format($cart['item']['pesinat'], 0, ',', '.') }} ₺
                                        </td>
                                        <td><strong>Taksit Sayısı</strong> <br>{{ $cart['item']['taksitSayisi'] }}</td>
                                        <td><strong>Aylık Ödenecek
                                                Tutar</strong><br>{{ number_format($cart['item']['aylik'], 0, ',', '.') }} ₺
                                        </td>
                                        @if (isset($cart['item']['pay_decs']) && count($cart['item']['pay_decs']) != 0)
                                            <td><strong>Ara Ödeme
                                                    Sayısı</strong><br>{{ isset($cart['item']['pay_decs']) ? count($cart['item']['pay_decs']) : '' }}
                                            </td>
                                        @endif

                                        <td><strong>Toplam
                                                Fiyat</strong><br>
                                            @if ($cart['item']['qt'] > 1)
                                                {{ number_format($cart['item']['amount'], 0, ',', '.') }}
                                            @else
                                                {{ number_format($cart['item']['installmentPrice'], 0, ',', '.') }}
                                            @endif

                                            ₺
                                        </td>
                                    </tr>
                                    @if (isset($cart['item']['pay_decs']))
                                        <tr>
                                            @foreach ($cart['item']['pay_decs'] as $index => $payDec)
                                                <td><strong>{{ $index + 1 }}. Ara Ödeme</strong>
                                                    <br>{{ number_format($payDec['pay_dec_price' . $index], 0, ',', '.') }}
                                                    ₺ <br>
                                                    {{ $months[date('n', strtotime($payDec['pay_dec_date' . $index])) - 1] . ', ' . date('d Y', strtotime($payDec['pay_dec_date' . $index])) }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="my-properties p-0">
                        <table class="table-responsive">
                            <tbody>
                                @if (!$cart || empty($cart['item']))
                                    <tr>
                                        <td colspan="4">Sepette Ürün Bulunmuyor</td>
                                    </tr>
                                @else
                                    @php
                                        $housingDiscountAmount = 0;
                                        $projectDiscountAmount = 0;

                                        if ($cart['type'] == 'housing') {
                                            $housingOffer = App\Models\Offer::where('type', 'housing')
                                                ->where('housing_id', $cart['item']['id'])
                                                ->where('start_date', '<=', now())
                                                ->where('end_date', '>=', now())
                                                ->first();

                                            $housingDiscountAmount = $housingOffer ? $housingOffer->discount_amount : 0;
                                        } else {
                                            $projectOffer = App\Models\Offer::where('type', 'project')
                                                ->where('project_id', $cart['item']['id'])
                                                ->whereRaw('FIND_IN_SET(?, project_housings)', [
                                                    $cart['item']['housing'],
                                                ])
                                                ->where('start_date', '<=', now())
                                                ->where('end_date', '>=', now())
                                                ->first();

                                            $projectDiscountAmount = $projectOffer ? $projectOffer->discount_amount : 0;
                                        }

                                    @endphp
                                    <tr>
                                        <td class="image myelist">
                                            <a
                                                href="{{ $cart['type'] == 'housing'
                                                    ? route('housing.show', ['housingSlug' => $cart['item']['slug'], 'housingID' => $cart['item']['id'] + 2000000])
                                                    : route('project.housings.detail', [
                                                        'projectSlug' =>
                                                            optional(App\Models\Project::find($cart['item']['id']))->slug .
                                                            '-' .
                                                            optional(App\Models\Project::find($cart['item']['id']))->step2_slug .
                                                            '-' .
                                                            optional(App\Models\Project::find($cart['item']['id']))->housingtype->slug,
                                                        'projectID' => optional(App\Models\Project::find($cart['item']['id']))->id + 1000000,
                                                        'housingOrder' => $cart['item']['housing'],
                                                    ]) }}">
                                                <img alt="my-properties-3" src="{{ $cart['item']['image'] }}"
                                                    style="width: 100px;height:100px;object-fit:cover" class="img-fluid">
                                            </a>
                                        </td>
                                        <td>
                                            <div class="inner">
                                                <a
                                                    href="{{ $cart['type'] == 'housing'
                                                        ? route('housing.show', ['housingSlug' => $cart['item']['slug'], 'housingID' => $cart['item']['id'] + 2000000])
                                                        : route('project.housings.detail', [
                                                            'projectSlug' =>
                                                                optional(App\Models\Project::find($cart['item']['id']))->slug .
                                                                '-' .
                                                                optional(App\Models\Project::find($cart['item']['id']))->step2_slug .
                                                                '-' .
                                                                optional(App\Models\Project::find($cart['item']['id']))->housingtype->slug,
                                                            'projectID' => optional(App\Models\Project::find($cart['item']['id']))->id + 1000000,
                                                            'housingOrder' => $cart['item']['housing'],
                                                        ]) }}">
                                                    <h2 style="font-weight: 600;text-align: left ">
                                                        {{ $cart['type'] == 'housing' ? 'İlan No: ' . $cart['item']['id'] + 2000000 : 'İlan No: ' . $cart['item']['housing'] + optional(App\Models\Project::find($cart['item']['id']))->id + 1000000 }}
                                                        <br>
                                                        {{ $cart['item']['title'] }}
                                                        <br>
                                                        {{ $cart['type'] == 'project' ? $cart['item']['housing'] . " No'lu İlan" : null }}
                                                        @if (isset($cart['item']['isShare']) && !empty($cart['item']['isShare']))
                                                            <br><br>
                                                            <span style="color:#EA2B2E"
                                                                class="mt-3">{{ $cart['item']['qt'] }} adet hisse
                                                                sepetinizde
                                                                !</span>
                                                        @endif
                                                    </h2>
                                                </a>
                                            </div>
                                        </td>
                                        @php
                                            $itemPrice = $cart['item']['amount'];
                                            if ($cart['hasCounter']) {
                                                if ($cart['type'] == 'housing') {
                                                    $housing = App\Models\Housing::find($cart['item']['id']);
                                                    $housingData = json_decode($housing->housing_type_data);
                                                    $discountRate = $housingData->discount_rate[0] ?? 0;

                                                    $housingAmount = $itemPrice - $housingDiscountAmount;
                                                    $discountedPrice =
                                                        $housingAmount - ($housingAmount * $discountRate) / 100;
                                                } else {
                                                    $project = App\Models\Project::find($cart['item']['id']);
                                                    $roomOrder = $cart['item']['housing'];
                                                    $projectHousing = App\Models\ProjectHousing::where(
                                                        'project_id',
                                                        $project->id,
                                                    )
                                                        ->where('room_order', $roomOrder)
                                                        ->get()
                                                        ->keyBy('name');
                                                    $discountRate = $projectHousing['discount_rate[]']->value ?? 0;
                                                    $projectAmount = $itemPrice - $projectDiscountAmount;
                                                    $discountedPrice =
                                                        $projectAmount - ($projectAmount * $discountRate) / 100;
                                                }
                                            } else {
                                                $discountedPrice = $itemPrice;
                                                $discountRate = 0;
                                            }
                                            $selectedPaymentOption = request('paymentOption');
                                            $itemPrice =
                                                $selectedPaymentOption === 'taksitli' &&
                                                isset($cart['item']['installmentPrice'])
                                                    ? $cart['item']['installmentPrice']
                                                    : $discountedPrice;
                                            $discountedPrice =
                                                $itemPrice -
                                                ($housingDiscountAmount
                                                    ? $housingDiscountAmount
                                                    : $projectDiscountAmount);

                                            $displayedPrice = number_format($discountedPrice, 0, ',', '.');
                                            $share_sale = $cart['item']['isShare'] ?? null;
                                            $number_of_share = $cart['item']['numbershare'] ?? null;
                                        @endphp

                                        <td>
                                            <span style="width:100%;text-align:center">
                                                @if (isset($share_sale) && $share_sale != '[]')
                                                    <div
                                                        class="text-center w-100 d-flex align-items-center justify-content-center mb-3">
                                                        <button
                                                            class="btn btn-sm btn-outline-secondary updateNumberShareMinus">-</button>
                                                        <span class="mx-2 count">{{ $cart['item']['qt'] }}</span>
                                                        <button
                                                            class="btn btn-sm btn-outline-secondary updateNumberSharePlus">+</button>
                                                    </div>
                                                @endif


                                                @if ($discountRate != 0)
                                                    <span>
                                                        <del
                                                            style="color:#EA2B2E">{{ number_format($itemPrice, 0, ',', '.') }}₺</del>
                                                    </span>
                                                @endif

                                                <span class="discounted-price-x" id="itemPrice"
                                                    data-original-price="{{ $cart['item']['defaultPrice'] }}"
                                                    data-installment-price="{{ $cart['item']['installmentPrice'] }}"
                                                    style="color: green; font-size:14px !important">
                                                    {{ $displayedPrice }}
                                                    ₺
                                                </span>
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-4 mt-5">
                    <div class="tr-single-box mb-0" style="background: white !important;">
                        <div class="tr-single-body">
                            <div class="tr-single-header pb-2" style="margin-bottom:10px !important;">
                                <h4><i class="fa fa-star-o"></i>Sepet Özeti</h4>
                            </div>
                            <div class="booking-price-detail side-list no-border mb-3">
                                @if (!$cart || empty($cart['item']))
                                    <ul>
                                        <li>Toplam Fiyat<strong class="pull-right">00.00TL</strong></li>
                                    </ul>
                                @else
                                    <ul>
                                        <li>İlan Fiyatı<strong class="pull-right">
                                                {{ number_format($cart['item']['amount'], 0, ',', '.') }} TL</strong></li>
                                        @if ($housingDiscountAmount != 0 || $projectDiscountAmount != 0)
                                            <li style="color:#EA2B2E">Mağaza İndirimi :
                                                <strong class="pull-right">
                                                    <svg viewBox="0 0 24 24" width="18" height="18"
                                                        stroke="currentColor" stroke-width="2" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                        <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                        <polyline points="17 18 23 18 23 12"></polyline>
                                                    </svg>
                                                    <span style="margin-left: 2px">
                                                        {{ number_format($housingDiscountAmount ? $housingDiscountAmount : $projectDiscountAmount, 0, ',', '.') }}
                                                        ₺
                                                    </span>
                                                </strong>
                                            </li>
                                        @endif

                                        @if (isset($discountRate) && $discountRate != '0')
                                            <li style="color:#EA2B2E">Emlak Kulüp İndirim Oranı :<strong class="pull-right">
                                                    <svg viewBox="0 0 24 24" width="18" height="18"
                                                        stroke="currentColor" stroke-width="2" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                        <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                        <polyline points="17 18 23 18 23 12"></polyline>
                                                    </svg>
                                                    <span style="margin-left: 2px">{{ $discountRate }}
                                                        % </span></strong></li>
                                        @endif
                                        <li>Toplam Fiyat<strong class="pull-right">
                                                {{ number_format($discountedPrice, 0, ',', '.') }}

                                                TL</strong></li>



                                        @if ($saleType == 'kiralik')
                                            <li>Bir Kira Kapora :<strong
                                                    class="pull-right">{{ number_format($discountedPrice, 0, ',', '.') }}
                                                    TL</strong></li>
                                        @else
                                            <li>Toplam Fiyatın %2 Kaporası :<strong
                                                    class="pull-right">{{ number_format($discountedPrice * 0.02, 0, ',', '.') }}
                                                    TL</strong></li>
                                        @endif

                                    </ul>
                                @endif
                            </div>
                            <div class="coupon-cart-area mb-3">
                                <div class="d-flex">
                                    <input type="text" placeholder="İndirim Kupon Kodu" style="height: 40px;"
                                        class="form-control coupon-code">
                                    <button class="btn btn-primary coupon-apply">Uygula</button>
                                </div>
                            </div>
                            @if (!$cart || empty($cart['item']))
                                <button type="button" class="btn btn-primary btn-lg btn-block"
                                    style="font-size: 11px;margin: 0 auto;"
                                    onclick="window.location.href='{{ route('index') }}'">
                                    Alışverişe Devam Et
                                </button>
                            @else
                                @if ($saleType == 'kiralik')
                                    <a href="{{ route('payment.index') }}"
                                        class="btn btn-primary btn-lg btn-block paymentButton button-price"
                                        style="height: 50px !important;font-size: 11px;margin: 0 auto;">
                                        <span
                                            class="button-price-inner">{{ number_format($discountedPrice, 0, ',', '.') }}</span>
                                        TL <br> KAPORA ÖDE
                                    </a>
                                @else
                                    <a href="{{ route('payment.index') }}"
                                        class="btn btn-primary btn-lg btn-block paymentButton button-price"
                                        style="height: 50px !important;font-size: 11px;margin: 0 auto;">
                                        <span
                                            class="button-price-inner">{{ number_format($discountedPrice * 0.02, 0, ',', '.') }}</span>
                                        TL <br> KAPORA ÖDE
                                    </a>
                                @endif
                            @endif



                        </div>
                    </div>
                </div>
            </div>


        </div>

        @if ($cart || !empty($cart['item']))
            <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="invoice">
                                <div class="invoice-header mb-3">
                                    <span>Fatura Tarihi: {{ date('d.m.Y') }}</span>
                                </div>

                                <div class="invoice-body">
                                    <div class="invoice-total mt-3">
                                        <span class="mt-3">EFT/Havale yapacağınız bankayı seçiniz</span>
                                        <div class="container row mb-3 mt-3">
                                            @foreach ($bankAccounts as $bankAccount)
                                                <div class="col-md-4 bank-account" data-id="{{ $bankAccount->id }}"
                                                    data-iban="{{ $bankAccount->iban }}"
                                                    data-title="{{ $bankAccount->receipent_full_name }}">
                                                    <img src="{{ URL::to('/') }}/{{ $bankAccount->image }}"
                                                        alt=""
                                                        style="width: 100%;height:100px;object-fit:contain;cursor:pointer">
                                                </div>
                                            @endforeach
                                        </div>
                                        <div id="ibanInfo" style="font-size: 12px !important"></div>
                                        <span>Ödeme işlemini tamamlamak için, lütfen bu
                                            <span style="color:#EA2B2E;font-weight:bold" id="uniqueCode"></span> kodu
                                            kullanarak ödemenizi
                                            yapın. IBAN açıklama
                                            alanına
                                            bu kodu eklemeyi unutmayın. Ardından "Ödemeyi Tamamla" düğmesine tıklayarak
                                            işlemi
                                            bitirin.</span>

                                    </div>
                                </div>

                            </div>

                            <div class="d-flex">
                                <button type="button" @if ((Auth::check() && Auth::user()->type == '2') || (Auth::check() && Auth::user()->parent_id)) disabled @endif
                                    class="btn btn-secondary btn-lg btn-block mb-3 mt-3" id="completePaymentButton"
                                    style="width:150px;float:right">Satın Al
                                </button>
                                <button type="button" class="btn btn-secondary btn-lg btn-block mt-3"
                                    style="width:150px;margin-left:10px" data-dismiss="modal">İptal</button>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="finalConfirmationModal" tabindex="-1" role="dialog"
                aria-labelledby="finalConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">

                        <div class="modal-body">
                            <div class="container">
                                <span>Ödemeniz başarıyla tamamlamak için lütfen aşağıdaki adımları takip edin:</span> <br>
                                <span>1. <strong style="color:#EA2B2E;font-weight:bold !important"
                                        id="uniqueCodeRetry"></strong> kodunu EFT/Havale açıklama
                                    alanına yazdığınızdan emin olun.</span>

                                <form method="POST" id="paymentForm">
                                    @csrf
                                    <input type="hidden" name="key" id="orderKey">
                                    <input type="hidden" name="banka_id" id="bankaID">
                                    <input type="hidden" name="have_discount" class="have_discount">
                                    <input type="hidden" name="discount" class="discount">
                                    <input type="hidden" name="is_swap" class="is_swap"
                                        value="{{ $cart['item']['payment-plan'] ?? null }}">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fullName">Ad Soyad:</label>
                                                <input type="text" class="form-control" id="fullName"
                                                    name="fullName" requi#EA2B2E>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">E-posta:</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    requi#EA2B2E>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tc">TC * </label>
                                                <input type="number" class="form-control" id="tc" name="tc"
                                                    requi#EA2B2E oninput="validateTCLength(this)">
                                            </div>
                                        </div>

                                        <script>
                                            function validateTCLength(input) {
                                                var maxLength = 11;
                                                if (input.value.length > maxLength) {
                                                    input.value = input.value.slice(0, maxLength);
                                                    toastr.warning("TC kimlik numarası 11 karakterden fazla olamaz!");
                                                }
                                            }
                                        </script>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Telefon:</label>
                                                <input type="tel" class="form-control" id="phone" name="phone"
                                                    requi#EA2B2E>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address">Adres:</label>
                                                <textarea class="form-control" id="address" name="address" rows="5" requi#EA2B2E></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="notes">Notlar:</label>
                                                <textarea class="form-control" id="notes" name="notes" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="notes">Referans Kodu (Opsiyonel):</label>
                                                <textarea class="form-control" id="reference_code" name="reference_code" rows="5"></textarea>
                                            </div>
                                        </div>
                                        @if (isset($cart['item']['neighborProjects']) && count($cart['item']['neighborProjects']) > 0 && $share_sale == '[]')
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="neighborProjects">Komşunuzun referansıyla mı satın
                                                        alıyorsunuz?</label>
                                                    <select class="form-control" id="is_reference" name="is_reference">
                                                        <option value="" selected>Komşu Seçiniz</option>
                                                        @foreach ($cart['item']['neighborProjects'] as $neighborProject)
                                                            <option value="{{ $neighborProject->owner->id }}">
                                                                {{ $neighborProject->owner->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endif


                                    </div>

                                    @if ($cart['type'] == 'project' && $share_sale == '[]')
                                        <div class="d-flex align-items-center">
                                            <input id="is_show_user" type="checkbox" value="off" name="is_show_user">

                                            <label for="is_show_user" class="m-0 ml-1 text-black">
                                                Komşumu Gör özelliği ile iletişim bilgilerimi paylaşmayı kabul ediyorum.
                                            </label>
                                        </div>
                                    @endif
                                    <div class="d-flex align-items-center mb-3">
                                        <input id="checkPay" type="checkbox" name="checkPay">

                                        <label for="checkPay" class="m-0 ml-1 text-black">
                                            <a href="/sayfa/mesafeli-kapora-emanet" target="_blank">
                                                Mesafeli kapora emanet
                                            </a>
                                            sözleşmesini okudum ve kabul ediyorum
                                        </label>
                                    </div>

                                    <div class="d-flex">
                                        <button type="button" class="btn btn-secondary paySuccess"
                                            style="float:right">Ödemeyi
                                            Tamamla
                                            <svg viewBox="0 0 576 512" class="svgIcon">
                                                <path
                                                    d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24H360c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z">
                                                </path>
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-lg btn-block"
                                            style="width:150px;margin-left:10px" data-bs-dismiss="modal">İptal</button>
                                    </div>


                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div id="loadingOverlay">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

    </section>


@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        #loadingIndicator {
            color: #007bff;
        }

        .my-choose td {
            padding: 15px 20px 15px 0 !important;
        }

        /* Style for custom option container */
        .payment-options {
            display: flex;
        }

        .shopping-cart__totals {
            border: 1px solid #e4e4e4;
            margin-bottom: 1.25rem;
            max-width: 100%;
        }



        /* Style for custom option */
        .custom-option {
            display: flex;
            cursor: pointer;
            font-size: 11px !important;
            color: black;

            align-items: center;
            justify-content: center;
            border: 1px solid #e4e4e4;
            padding: 10px;
        }

        /* Style for selected option */
        .custom-option.selected {
            background-color: #5cb85c;
            /* Adjust color as needed */
            color: #fff;
        }

        @media (max-width: 768px) {
            .my-choose {
                flex-direction: column-reverse;
            }

            .clearButtons {
                margin-bottom: 10px;
            }

            .my-properties table h2 {
                text-align: center !important;
                margin: 9px 0 9px 0
            }

            .payment-options {
                width: 100%;
            }

            .clearButtons {
                width: 100%;
            }

            .custom-option {
                width: 50%;
            }


        }

        .updateNumberShareMinus,
        .updateNumberSharePlus {
            width: 20px;
            height: 20px !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZwT" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&callback=initMap"></script>
    <script>
        $(document).ready(function() {

            var displayedPriceSpan = $('#itemPrice');
            var originalPrice = parseFloat(displayedPriceSpan.data('original-price'));
            var installmentPrice = parseFloat(displayedPriceSpan.data('installment-price'));
            $('.custom-option').on('click', function() {
                var selectedOption = $(this).data('value');
                updateCart(selectedOption);
            });


            $(".updateNumberSharePlus").on("click", function() {
                $.ajax({
                    type: 'POST',
                    url: '/update-cart-qt',
                    data: {
                        _token: '{{ csrf_token() }}',
                        change: "artir"
                    },
                    success: function(response) {
                        if (response.response) {
                            toastr.warning(response.response);
                        } else {
                            location.reload();
                            console.log(response);
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });

            $(".updateNumberShareMinus").on("click", function() {
                $.ajax({
                    type: 'POST',
                    url: '/update-cart-qt',
                    data: {
                        _token: '{{ csrf_token() }}',
                        change: "azalt"
                    },
                    success: function(response) {
                        if (response.response) {
                            toastr.warning(response.response);
                        } else {
                            location.reload();
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });


            function updateCart(selectedOption) {
                var qt =
                "{{ isset($cart['item']['qt']) ? $cart['item']['qt'] : 1 }}"; // Varsa quantity değeri, yoksa 1


                var updatedPrice = (selectedOption === 'taksitli') ? (installmentPrice * qt) : (originalPrice * qt);

                $.ajax({
                    type: 'POST',
                    url: '/update-cart',
                    data: {
                        paymentOption: selectedOption,
                        updatedPrice: updatedPrice,
                        _token: '{{ csrf_token() }}' // CSRF token'ı eklemek için bu satırı ekleyin
                    },
                    success: function(response) {
                        location.reload();
                        console.log(response);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }



            // Function to format numbers
            function number_format(number, decimals, dec_point, thousands_sep) {
                number = number.toFixed(decimals);
                var parts = number.toString().split(dec_point);
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_sep);
                return parts.join(dec_point);
            }
        });
        $(document).ready(function() {
            $('.paySuccess').on('click', function() {

                if ($('#fullName').val() === '' && $('#tc').val() === '' && $('#email').val() === '') {
                    toastr.warning('Ad Soyad, TC ve E-posta alanları zorunludur.')
                    return;
                }

                if ($('#fullName').val() === '') {
                    toastr.warning('Ad Soyad alanı zorunludur.')
                    return;
                }


                if ($('#tc').val() === '') {
                    toastr.warning('TC alanı zorunludur.')
                    return;
                }

                if ($('#email').val() === '') {
                    toastr.warning('E-posta alanı zorunludur.')
                    return;
                }

                if (!$('#checkPay').prop('checked')) {
                    toastr.warning('Lütfen sözleşmeyi onaylayınız.');
                    $('#checkPay').css({
                        "border": "1px solid red"
                    });
                    return;
                }
                $("#loadingOverlay").css("visibility", "visible"); // Visible olarak ayarla

                $.ajax({
                    url: "{{ route('pay.cart') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        key: $('#orderKey').val(),
                        banka_id: $('#bankaID').val(),
                        have_discount: $('.have_discount').val(),
                        discount: $('.discount').val(),
                        fullName: $('#fullName').val(),
                        email: $('#email').val(),
                        tc: $('#tc').val(),
                        phone: $('#phone').val(),
                        address: $('#address').val(),
                        notes: $('#notes').val(),
                        reference_code: $('#reference_code').val(),
                        is_reference: $("#is_reference").val(),
                        is_show_user: $('#is_show_user').prop('checked') ? 'on' : null
                    },
                    success: function(response) {
                        if (response.success == "fail") {
                            toastr.error('Bu ürün zaten satın alınmış.');

                        } else {
                            toastr.success('Siparişiniz başarıyla oluşturuldu.');
                            var cartOrderId = response.cart_order;
                            var redirectUrl =
                                "{{ route('pay.success', ['cart_order' => ':cartOrderId']) }}";
                            window.location.href = redirectUrl.replace(':cartOrderId',
                                cartOrderId);
                        }


                    },
                    error: function(error) {
                        toastr.error('Ödeme işlemi sırasında bir hata oluştu.')
                    },
                    complete: function() {
                        $("#loadingOverlay").css("visibility",
                            "hidden"); // Visible olarak ayarla
                    }
                });
            });




            $('#completePaymentButton').prop('disabled', false);

            $('.bank-account').on('click', function() {
                // Tüm banka görsellerini seçim olmadı olarak ayarla
                $('.bank-account').removeClass('selected');

                // Seçilen banka görselini işaretle
                $(this).addClass('selected');

                // İlgili IBAN bilgisini al
                var selectedBankIban = $(this).data('iban');
                var selectedBankIbanID = $(this).data('id');
                var selectedBankTitle = $(this).data('title');
                $('#bankaID').val(selectedBankIbanID);


                var ibanInfo = "<span style='color:black'><strong>Banka Alıcı Adı:</strong> " +
                    selectedBankTitle + "<br><strong>IBAN:</strong> " + selectedBankIban + "</span>";
                $('#ibanInfo').html(ibanInfo);

            });

            $('#completePaymentButton').on('click', function() {
                if ($('.bank-account.selected').length === 0) {
                    toastr.error('Lütfen banka seçimi yapınız.')

                } else {
                    $('#paymentModal').removeClass('show').hide();
                    $('.modal-backdrop').removeClass('show');
                    $('.modal-backdrop').remove();
                    $('#finalConfirmationModal').modal('show');
                }
            });
        });


        function formatPrice(price) {
            var parts = price.toString().split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return parts.join(".");
        }
        $(document).ready(function() {
            var $cart = <?php echo json_encode($cart); ?>;
            $(".paymentButton").on("click", function() {
                var uniqueCode = ($cart['type'] === 'housing') ?
                    $cart['item']['id'] + 2000000 :
                    $cart['item']['housing'] + $cart['item']['id'] + 1000000;

                $('#uniqueCode, #uniqueCodeRetry').text(uniqueCode);
                $("#orderKey").val(uniqueCode);
            });
        });
        $("#createOrder").click(function() {
            // Sepete eklenecek verileri burada hazırlayabilirsiniz


            // Ajax isteği gönderme
            $.ajax({
                url: "{{ route('client.create.order') }}", // Sepete veri eklemek için uygun URL'yi belirtin
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                }, // Veriyi göndermek için POST kullanabilirsiniz, // Sepete eklemek istediğiniz ürün verilerini gönderin
                success: function(response) {
                    // İşlem başarılı olduğunda buraya gelir
                    toast.success(response)
                    console.log("Ürün sepete eklendi: " + response);

                },
                error: function(error) {
                    // Hata durumunda buraya gelir
                    toast.error(error)
                    console.error("Hata oluştu: " + error);
                }
            });
        });
        $(".remove-from-cart").click(function() {
            var productId = $(this).data('id');
            var confirmation = confirm("Ürünü sepetten kaldırmak istiyor musunuz?");

            if (confirmation) {
                // Loading göster
                $("#loadingOverlay").css("visibility", "visible"); // Visible olarak ayarla

                $.ajax({
                    url: "{{ route('client.remove.from.cart') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // Loading gizle
                        $("#loadingOverlay").css("visibility", "hidden"); // Hidden olarak ayarla
                        location.reload();
                        toastr.success("Sepet Temizlendi.");
                    },
                    error: function(error) {
                        // Loading gizle
                        $("#loadingOverlay").css("visibility", "hidden"); // Hidden olarak ayarla

                        toastr.error("Hata oluştu: " + error.responseText, "Hata");
                        console.error("Hata oluştu: " + error);
                    }
                });
            }
        });
    </script>
@endsection
