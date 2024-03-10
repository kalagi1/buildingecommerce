@extends('client.layouts.master')



@section('content')
    <section class="payment-method notfound">
        <div class="container">
            <section class="headings-2 pt-0 hee">
                <div class="pro-wrapper">
                    <div class="detail-wrapper-body">
                        <div class="listing-title-bar">
                            {{-- <div class="text-heading text-left">
                            <p><a href="index.html">Home </a> &nbsp;/&nbsp; <span>Checkout</span></p>
                        </div> --}}
                            {{-- <h3>Checkout</h3> --}}
                        </div>
                    </div>
                </div>
            </section>
            <div class="row">


                <div class="col-md-12">
                    <div class="tr-single-box">
                        <div class="tr-single-body">

                            <div class="tr-single-header">
                                <h4><i class="fa fa-star-o booking-price-detail side-list no-border"></i>Sepet
                                    Detayı</h4>
                            </div>
                            @if (!$cart || empty($cart['item']))
                                <ul>
                                    <li>Sepette Ürün Bulunmuyor</td>
                                </ul>
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
                                            ->where('project_housings', 'LIKE', '%' . $cart['item']['housing'] . '%')
                                            ->where('start_date', '<=', now())
                                            ->where('end_date', '>=', now())
                                            ->first();

                                        $projectDiscountAmount = $projectOffer ? $projectOffer->discount_amount : 0;
                                    }
                                @endphp

                                <div class="booking-price-detail side-list no-border mb-3">
                                    <table>
                                        <tr >
                                            <th>Ürün Resmi</th>
                                            <th>Ürün Bilgisi</th>
                                            <th>Fiyat</th>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%" class="image myelist">
                                                <a
                                                    href="{{ $cart['type'] == 'housing' ? route('housing.show', ['id' => $cart['item']['id']]) : route('project.housings.detail', ['projectID' => optional(App\Models\Project::find($cart['item']['id']))->id, 'id' => $cart['item']['housing']]) }}">
                                                    <img alt="my-properties-3" src="{{ $cart['item']['image'] }}"
                                                        style="width: 100px; height: 100px; object-fit: cover;"
                                                        class="img-fluid">
                                                </a>
                                            </td>

                                            <td style="width: 20%">
                                                <div class="inner">
                                                    <a
                                                        href="{{ $cart['type'] == 'housing' ? route('housing.show', ['id' => $cart['item']['id']]) : route('project.housings.detail', ['projectID' => optional(App\Models\Project::find($cart['item']['id']))->id, 'id' => $cart['item']['housing']]) }}">
                                                        <h2 style="font-weight: 600; text-align: left;">
                                                            {{ $cart['type'] == 'housing' ? 'İlan No: ' . ($cart['item']['id'] + 2000000) : 'İlan No: ' . ($cart['item']['housing'] + optional(App\Models\Project::find($cart['item']['id']))->id + 1000000) }}
                                                            <br>
                                                            {{ $cart['item']['title'] }}
                                                            <br>
                                                            {{ $cart['type'] == 'project' ? $cart['item']['housing'] . " No'lu İlan" : null }}
                                                            @if (isset($cart['item']['isShare']) && !empty($cart['item']['isShare']))
                                                                <br><br>
                                                                <span style="color: #EA2B2E;"
                                                                    class="mt-3">{{ $cart['item']['qt'] }} adet hisse
                                                                    sepetinizde!</span>
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

                                                $displayedPrice = number_format($itemPrice, 0, ',', '.');
                                                $share_sale = $cart['item']['isShare'] ?? null;
                                                $number_of_share = $cart['item']['numbershare'] ?? null;
                                            @endphp

                                            <td style="width: 20%">
                                                <span style="width: 100%; text-align: center;">
                                                    @if (isset($share_sale) && !empty($share_sale))
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
                                                            <del style="color: #EA2B2E;">{{ number_format($itemPrice, 0, ',', '.') }}
                                                                ₺</del>
                                                        </span>
                                                    @endif

                                                    <span class="discounted-price-x" id="itemPrice"
                                                        data-original-price="{{ $cart['item']['price'] }}"
                                                        data-installment-price="{{ $cart['item']['installmentPrice'] }}"
                                                        style="color: green; font-size: 14px !important;">
                                                        {{ isset($share_sale) && !empty($share_sale) && is_numeric($displayedPrice) && is_numeric($number_of_share) && $number_of_share != 0 ? $displayedPrice / $number_of_share : $displayedPrice }}
                                                        ₺
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>


                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-12 col-xl-6">
                    <div class="tr-single-box">
                        <div class="tr-single-body">
                            <div class="tr-single-header">
                                <h4><i class="far fa-address-card pr-2"></i>Satın Alan Kişinin Bilgileri</h4>
                            </div>

                            <form method="POST" id="paymentForm">
                                @csrf
                                <input type="hidden" name="key" id="orderKey">
                                <input type="hidden" name="banka_id" id="bankaID">
                                <input type="hidden" name="have_discount" class="have_discount">
                                <input type="hidden" name="discount" class="discount">
                                <input type="hidden" name="is_swap" class="is_swap"
                                    value="{{ $cart['item']['payment-plan'] ?? null }}">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="fullName">Ad Soyad:</label>
                                        <input type="text" class="form-control" id="fullName" name="fullName"
                                            requi#EA2B2E>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="email">E-posta:</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            requi#EA2B2E>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="tc">TC * </label>
                                        <input type="number" class="form-control" id="tc" name="tc"
                                            requi#EA2B2E oninput="validateTCLength(this)">
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
                                    <div class="col-sm-6">
                                        <label for="phone">Telefon:</label>
                                        <input type="tel" class="form-control" id="phone" name="phone"
                                            requi#EA2B2E>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="address">Adres:</label>
                                        <textarea class="form-control" id="address" name="address" rows="5" requi#EA2B2E></textarea>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="notes">Notlar:</label>
                                        <textarea class="form-control" id="notes" name="notes" rows="5"></textarea>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="notes">Referans Kodu (Opsiyonel):</label>
                                        <textarea class="form-control" id="reference_code" name="reference_code" rows="5"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12 col-xl-6">
                    <div class="tr-single-box">
                        <div class="tr-single-body">
                            <div class="tr-single-header">
                                <h4><i class="far fa-credit-card pr-2"></i>Ödeme Seçenekleri</h4>
                            </div>
                            <!-- Paypal Option -->
                            {{-- <div class="payment-card">
                                        <header class="payment-card-header cursor-pointer" data-toggle="collapse"
                                            data-target="#paypal" aria-expanded="true">
                                            <div class="payment-card-title flexbox">
                                                <h4>PayPal</h4>
                                            </div>
                                            <div class="pull-right">
                                                <img src="images/paypal.png" class="img-responsive" alt="">
                                            </div>
                                        </header>
                                        <div class="collapse show" id="paypal" role="tablist" aria-expanded="false"
                                            style="">
                                            <div class="payment-card-body">
                                                <div class="row mrg-bot-20">
                                                    <div class="col-sm-6">
                                                        <span class="custom-checkbox d-block font-12 mb-2">
                                                            <input type="checkbox" id="promo1">
                                                            <label for="promo1"></label>
                                                            Have a promo code?
                                                        </span>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                    <div class="col-sm-6 padd-top-10 text-right">
                                                        <label>Total Order</label>
                                                        <h2 class="mrg-0"><span class="theme-cl">$</span>950</h2>
                                                    </div>
                                                    <div class="col-sm-12 bt-1 padd-top-15 pt-3">
                                                        <span class="custom-checkbox d-block font-12 mb-3">
                                                            <input type="checkbox" id="privacy">
                                                            <label for="privacy"></label>
                                                            By ordering you are agreeing to our <a href="#"
                                                                class="theme-cl">Privacy policy</a>.
                                                        </span>
                                                        <button type="submit" class="btn btn-m btn-success">Checkout</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                            <!-- Debit card option -->
                            <div class="payment-card">
                                <header class="payment-card-header cursor-pointer" data-toggle="collapse"
                                    data-target="#debit-credit" aria-expanded="true">
                                    <div class="payment-card-title flexbox">
                                        <h4>Kredi / Banka Kartı</h4>
                                    </div>
                                    <div class="pull-right">
                                        <img src="images/credit.png" class="img-responsive" alt="">
                                    </div>
                                </header>
                                <div class="collapse show" id="debit-credit" role="tablist" aria-expanded="false"
                                    style="">
                                    <div class="payment-card-body">
                                        <div class="row mrg-bot-20">
                                            <div class="col-sm-6">
                                                <label>Card Holder Name</label>
                                                <input type="text" class="form-control" placeholder="Chris Seail">
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Card No.</label>
                                                <input type="email" class="form-control"
                                                    placeholder="1800 5785 6758 2458">
                                            </div>
                                        </div>
                                        <div class="row mrg-bot-20">
                                            <div class="col-sm-4 col-md-4">
                                                <label>Expire Month</label>
                                                <input type="text" class="form-control" placeholder="09">
                                            </div>
                                            <div class="col-sm-4 col-md-4">
                                                <label>Expire Year</label>
                                                <input type="email" class="form-control" placeholder="2022">
                                            </div>
                                            <div class="col-sm-4 col-md-4">
                                                <label>CCV Code</label>
                                                <input type="email" class="form-control" placeholder="258">
                                            </div>
                                        </div>
                                        <div class="row mrg-bot-20">
                                            <div class="col-sm-7">
                                                <span class="custom-checkbox d-block font-12 mb-2">
                                                    <input type="checkbox" id="promo">
                                                    <label for="promo"></label>
                                                    Have a promo code?
                                                </span>
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="col-sm-5 padd-top-10 text-right">
                                                <label>Total Order</label>
                                                <h2 class="mrg-0"><span class="theme-cl">$</span>987</h2>
                                            </div>
                                            <div class="col-sm-12 bt-1 padd-top-15 pt-3">
                                                <span class="custom-checkbox d-block font-12 mb-3">
                                                    <input type="checkbox" id="privacy1">
                                                    <label for="privacy1"></label>
                                                    By ordering you are agreeing to our <a href="#"
                                                        class="theme-cl">Privacy policy</a>.
                                                </span>
                                                <button type="submit" class="btn btn-m btn-success">Checkout</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- EFT Havale --}}
                            <div class="payment-card mb-0">
                                <header class="payment-card-header cursor-pointer" data-toggle="collapse"
                                    data-target="#paypal" aria-expanded="true">
                                    <div class="payment-card-title flexbox">
                                        <h4>EFT / HAVALE</h4>
                                    </div>
                                    <div class="pull-right">
                                        <span>Fatura Tarihi: {{ date('d.m.Y') }}</span>
                                    </div>
                                </header>
                                <div class="collapse show" id="paypal" role="tablist" aria-expanded="false"
                                    style="">
                                    <div class="payment-card-body">
                                        <div class="invoice-total mt-3">
                                            <span class="mt-3">EFT/Havale yapacağınız bankayı seçiniz</span>
                                            <div class="container row mb-3 mt-3">
                                                <span>1. <strong style="color:#EA2B2E;font-weight:bold !important"
                                                        id="uniqueCodeRetry"></strong> kodunu EFT/Havale açıklama
                                                    alanına yazdığınızdan emin olun.</span>
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

                                            @if (isset($cart['item']['neighborProjects']) && count($cart['item']['neighborProjects']) > 0 && empty($share_sale))
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="neighborProjects">Komşunuzun referansıyla mı satın
                                                            alıyorsunuz?</label>
                                                        <select class="form-control" id="is_reference"
                                                            name="is_reference">
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

                                        @if ($cart['type'] == 'project' && empty($share_sale))
                                            <div class="d-flex align-items-center mb-3">
                                                <input id="is_show_user" type="checkbox" value="off"
                                                    name="is_show_user">
                                                <i class="fa fa-info-circle ml-2"
                                                    title="Komşumu Gör özelliğini aktif ettiğinizde, diğer komşularınızın sizin iletişim bilgilerinize ulaşmasına izin vermiş olursunuz."
                                                    style="font-size: 18px; color: black;"></i>
                                                <label for="is_show_user" class="m-0 ml-1 text-black">
                                                    Komşumu Gör özelliği ile iletişim bilgilerimi paylaşmayı kabul ediyorum.
                                                </label>
                                            </div>
                                        @endif

                                        {{-- @if ($cart['type'] == 'project' && empty($share_sale))
                                                        <div class="d-flex align-items-center mb-3">
                                                            <input id="is_show_user" type="checkbox" value="off"
                                                                name="is_show_user">
                                                            <i class="fa fa-info-circle ml-2"
                                                                title="Komşumu Gör özelliğini aktif ettiğinizde, diğer komşularınızın sizin iletişim bilgilerinize ulaşmasına izin vermiş olursunuz."
                                                                style="font-size: 18px; color: black;"></i>
                                                            <label for="is_show_user" class="m-0 ml-1 text-black">
                                                                Komşumu Gör özelliği ile iletişim bilgilerimi paylaşmayı kabul
                                                                ediyorum.
                                                            </label>
                                                        </div>
                                                    @endif --}}

                                        <div class="d-flex">
                                            <button type="button" @if ((Auth::check() && Auth::user()->type == '2') || (Auth::check() && Auth::user()->parent_id)) disabled @endif
                                                class="btn btn-m btn-success paySuccess" id="completePaymentButton"
                                                style="float:right">Ödemeyi
                                                Tamamla
                                                <svg viewBox="0 0 576 512" class="svgIcon">
                                                    <path
                                                        d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24H360c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>


                                        {{-- <div class="d-flex">
                                                            <button type="button" @if ((Auth::check() && Auth::user()->type == '2') || (Auth::check() && Auth::user()->parent_id)) disabled @endif
                                                                class="btn btn-secondary btn-lg btn-block mb-3 mt-3" id="completePaymentButton"
                                                                style="width:150px;float:right">Satın Al
                                                            </button>
                                                        </div> --}}



                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
        </div>
    </section>
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
            var $cart = <?php echo json_encode($cart); ?>; // $cart değişkenini hazırla

            var uniqueCode = ($cart['type'] === 'housing') ? // uniqueCode'u oluştur
                $cart['item']['id'] + 2000000 :
                $cart['item']['housing'] + $cart['item']['id'] + 1000000;

            $('#uniqueCode, #uniqueCodeRetry').text(uniqueCode); // uniqueCode değerini span içine yerleştir
            $("#orderKey").val(uniqueCode); // uniqueCode değerini gizli input içine yerleştir
        });
        $(document).ready(function() {
            $('.paySuccess').on('click', function() {
                // $("#loadingOverlay").css("visibility", "visible"); // Visible olarak ayarla

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
                        toastr.success('Siparişiniz başarıyla oluşturuldu.');
                        var cartOrderId = response.cart_order;
                        var redirectUrl =
                            "{{ route('pay.success', ['cart_order' => ':cartOrderId']) }}";
                        window.location.href = redirectUrl.replace(':cartOrderId', cartOrderId);

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




            //  $('#completePaymentButton').prop('disabled', false);

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
        });
    </script>
@endsection
