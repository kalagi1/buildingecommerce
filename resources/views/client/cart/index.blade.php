@extends('client.layouts.master')

@section('content')
    <section class="recently portfolio bg-white homepage-5 ">
        <div class="container">
            <button type="button" class="btn btn-close-cart" style="background: black;color:white;font-size:12px"
                onclick="window.location.href='{{ route('index') }}'">
                <i class="fa fa-times"></i> Kapat
            </button>
            <div class="row" style="justify-content: end">
                <div class="col-md-8 mt-5">
                    <div class="my-properties">
                        <table class="table-responsive">
                            <thead class="mobile-hidden">
                                <tr>
                                    <th class="pl-2">İlan</th>
                                    <th class="p-0" style="width: 300px !important"></th>
                                    <th class="pl-2">Fiyat</th>
                                    <th>Kaldır</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!$cart || empty($cart['item']))
                                    <tr>
                                        <td colspan="4">Sepette Ürün Bulunmuyor</td>
                                    </tr>
                                @else
                                    @php
                                        $housingOffer = App\Models\Offer::where('type', 'housing')
                                            ->where('housing_id', $cart['item']['id'])
                                            ->where('start_date', '<=', now())
                                            ->where('end_date', '>=', now())
                                            ->first();
                                        $housingDiscountAmount = $housingOffer ? $housingOffer->discount_amount : 0;

                                        // Project için indirim kontrolü
                                        $projectOffer = App\Models\Offer::where('type', 'project')
                                            ->where('project_id', $cart['item']['id'])
                                            ->where('start_date', '<=', now())
                                            ->where('end_date', '>=', now())
                                            ->first();
                                        $projectDiscountAmount = $projectOffer ? $projectOffer->discount_amount : 0;
                                    @endphp


                                    <tr>
                                        <td class="image myelist">
                                            <a
                                                href="{{ $cart['type'] == 'housing' ? route('housing.show', ['id' => $cart['item']['id']]) : route('project.housings.detail', ['projectSlug' => optional(App\Models\Project::find($cart['item']['id']))->slug, 'id' => $cart['item']['housing']]) }}">
                                                <img alt="my-properties-3" src="{{ $cart['item']['image'] }}"
                                                    style="width: 100px;height:100px;object-fit:cover" class="img-fluid">
                                            </a>
                                        </td>
                                        <td>
                                            <div class="inner">
                                                <a
                                                    href="{{ $cart['type'] == 'housing' ? route('housing.show', ['id' => $cart['item']['id']]) : route('project.housings.detail', ['projectSlug' => optional(App\Models\Project::find($cart['item']['id']))->slug, 'id' => $cart['item']['housing']]) }}">
                                                    <h2 style="font-weight: 600;text-align: left !important">
                                                        {{ $cart['type'] == 'housing'
                                                            ? 'İlan No: ' . $cart['item']['id'] + 2000000
                                                            : 'İlan No: ' . $cart['item']['housing'] + optional(App\Models\Project::find($cart['item']['id']))->id + 1000000 }}
                                                        <br>

                                                        {{ $cart['item']['title'] }}
                                                    </h2>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <span style="color:#e54242; font-weight:600">
                                                @if ($cart['hasCounter'])
                                                    @if ($cart['type'] == 'housing')
                                                        @php
                                                            $housing = App\Models\Housing::find($cart['item']['id']);
                                                            $housingData = json_decode($housing->housing_type_data);
                                                            $discountRate = $housingData->discount_rate[0] ?? 0;

                                                            $housingAmount = $cart['item']['price'] - $housingDiscountAmount; // Assuming $projectDiscountAmount is defined elsewhere

                                                            $discountedPrice = $housingAmount - ($housingAmount * $discountRate) / 100;

                                                        @endphp
                                                    @else
                                                        @php
                                                            $project = App\Models\Project::find($cart['item']['id']);
                                                            $roomOrder = $cart['item']['housing'];
                                                            $projectHousing = App\Models\ProjectHousing::where('project_id', $project->id)
                                                                ->where('room_order', $roomOrder)
                                                                ->get()
                                                                ->keyBy('name');

                                                            $discountRate = $projectHousing['discount_rate[]']->value ?? 0;
                                                            $projectAmount = $cart['item']['price'] - $projectDiscountAmount; // Assuming $projectDiscountAmount is defined elsewhere
                                                            $discountedPrice = $projectAmount - ($projectAmount * $discountRate) / 100;

                                                        @endphp
                                                    @endif

                                                    <del style="color: red;">
                                                        {{ number_format($cart['item']['price']) }} ₺
                                                    </del><br>
                                                    <span class="discounted-price-x" style="color: green; font-size:14px !important">
                                                        {{ number_format($discountedPrice, 0, ',', '.') }} ₺
                                                    </span>
                                                @else
                                                    @php
                                                        $discountedPrice = $cart['item']['price'];

                                                    @endphp
                                                    <span style="color: green; font-size:14px !important">
                                                        {{ number_format($discountedPrice, 0, ',', '.') }} ₺
                                                    </span>
                                                @endif

                                            </span>
                                        </td>

                                        <td class="actions">
                                            <a href="#" class="remove-from-cart" style="float: left"><i
                                                    class="far fa-trash-alt"></i></a>
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
                                        <li>Toplam Fiyat<strong class="pull-right">00.00
                                                TL</strong></li>
                                    </ul>
                                @else
                                    <ul>
                                        <li>İlan Fiyatı<strong class="pull-right">
                                                {{ number_format($cart['item']['price'], 0, ',', '.') }}
                                                TL</strong></li>

                                        @if ($housingDiscountAmount != 0 || $projectDiscountAmount != 0)
                                            <li style="color:red">Mağaza İndirimi :<strong class="pull-right">
                                                    <svg viewBox="0 0 24 24" width="18" height="18"
                                                        stroke="currentColor" stroke-width="2" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                        <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                        <polyline points="17 18 23 18 23 12"></polyline>
                                                    </svg>
                                                    <span
                                                        style="margin-left: 2px">{{ number_format($housingDiscountAmount ? $housingDiscountAmount : $projectDiscountAmount, 0, ',', '.') }}
                                                        ₺ </span></strong></li>
                                        @endif


                                        @if (isset($discountRate) || $cart['hasCounter'])
                                            <li style="color:red">Emlak Kulüp İndirim Oranı :<strong class="pull-right">
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





                                        <li>Toplam Fiyatın %2 Kaporası :<strong
                                                class="pull-right">{{ number_format($discountedPrice * 0.02, 0, ',', '.') }}
                                                TL</strong></li>

                                    </ul>
                                @endif
                            </div>
                            @if (!$cart || empty($cart['item']))
                                <button type="button" class="btn btn-primary btn-lg btn-block"
                                    style="height: 50px !important;font-size: 12px;margin: 0 auto;"
                                    onclick="window.location.href='{{ route('index') }}'">
                                    Alışverişe Devam Et
                                </button>
                            @else
                                <button type="button" class="btn btn-primary btn-lg btn-block paymentButton button-price" data-toggle="modal"
                                    data-target="#paymentModal"
                                    style="height: 50px !important;font-size: 12px;margin: 0 auto;">
                                    <span class="button-price-inner">{{ number_format($discountedPrice * 0.02, 0, ',', '.') }}</span>
                                    TL <br> KAPORA ÖDE
                                </button>
                            @endif

                            <div class="coupon-cart-area mt-3">
                                <div class="d-flex">
                                    <input type="text" placeholder="Kupon Kodu" style="height: 40px;" class="form-control coupon-code">
                                    <button class="btn btn-primary coupon-apply">Uygula</button>
                                </div>
                            </div>
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
                        <div class="modal-header">
                            <h5 class="modal-title" id="paymentModalLabel">Emlak Sepette Ödeme Adımı</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="closeTimes">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="invoice">
                                <div class="invoice-header mb-3">
                                    <strong>Fatura Tarihi: {{ date('d.m.Y') }}</strong>
                                </div>

                                <div class="invoice-body">
                                    <div class="invoice-total mt-3">
                                        <strong class="mt-3">EFT/Havale yapacağınız bankayı seçiniz</strong>
                                        <div class="row mb-3 px-5 mt-3">
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
                                        <div id="ibanInfo"></div>
                                        <strong>Ödeme işlemini tamamlamak için, lütfen bu
                                            <span style="color:red;font-size:15px !important;font-weight:bold"
                                                id="uniqueCode"></span> kodu kullanarak ödemenizi
                                            yapın. IBAN açıklama
                                            alanına
                                            bu kodu eklemeyi unutmayın. Ardından "Ödemeyi Tamamla" düğmesine tıklayarak
                                            işlemi
                                            bitirin.</strong>

                                    </div>
                                </div>

                            </div>
                            <button type="button" @if ((Auth::check() && Auth::user()->type == '2') || (Auth::check() && Auth::user()->parent_id)) disabled @endif
                                class="btn btn-primary btn-lg btn-block mb-3 mt-3" id="completePaymentButton"
                                style="width:150px;float:right">Satın Al
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="finalConfirmationModal" tabindex="-1" role="dialog"
                aria-labelledby="finalConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="finalConfirmationModalLabel">Ödeme Onayı</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="closeTimes">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <span>Ödemeniz başarıyla tamamlamak için lütfen aşağıdaki adımları takip edin:</span> <br>
                                <span>1. <strong style="color:red;font-size:15px;font-weight:bold"
                                        id="uniqueCodeRetry"></strong> kodunu EFT/Havale açıklama
                                    alanına yazdığınızdan emin olun.</span>

                                <form action="{{ route('pay.cart') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="key" id="orderKey">
                                    <input type="hidden" name="banka_id" id="bankaID">
                                    <input type="hidden" name="have_discount" class="have_discount" >
                                    <input type="hidden" name="discount" class="discount" >
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fullName">Ad Soyad:</label>
                                                <input type="text" class="form-control" id="fullName"
                                                    name="fullName" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">E-posta:</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tc">TC:</label>
                                                <input type="number" class="form-control" id="tc" name="tc"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Telefon:</label>
                                                <input type="tel" class="form-control" id="phone" name="phone"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address">Adres:</label>
                                                <textarea class="form-control" id="address" name="address" rows="5" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="notes">Notlar:</label>
                                                <textarea class="form-control" id="notes" name="notes" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary paySuccess" style="float:right">Ödemeyi
                                        Tamamla
                                        <svg viewBox="0 0 576 512" class="svgIcon">
                                            <path
                                                d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24H360c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z">
                                            </path>
                                        </svg>
                                    </button>
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
@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZwT" crossorigin="anonymous">
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&callback=initMap"></script>

    <script>
        $(document).ready(function() {
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


                // IBAN bilgisini ekranda göster
                $('#ibanInfo').text(selectedBankTitle + " : " + selectedBankIban);
                // Ödeme düğmesini etkinleştir
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

        $('.coupon-apply').click(function(){
            @if(isset($discountRate))
                Swal.fire({
                    title: "Kupon indirimini uygularsanız emlak kulüp üyesi indirimi kalkacaktır. Uygulamak istediğinize emin misiniz?",
                    showDenyButton: false,
                    showCancelButton: true,
                    cancelButtonText: "İptal",
                    confirmButtonText: "Evet",
                    denyButtonText: `Hayır`
                    }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('check.coupon') }}", // Sepete veri eklemek için uygun URL'yi belirtin
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                coupon_code : $('.coupon-code').val()
                            }, // Veriyi göndermek için POST kullanabilirsiniz, // Sepete eklemek istediğiniz ürün verilerini gönderin
                            success: function(response) {
                                // İşlem başarılı olduğunda buraya gelir
                                response = JSON.parse(response)
                                if(response.status){
                                    if(response.discount_type == 1){
                                        @if (isset($housingOffer))
                                            var newPrice = parseFloat(response.cart.item.price) - {{$housingOffer->discount_amount}} - (parseFloat(response.cart.item.price) * response.discount_amount / 100);
                                        @else 
                                            var newPrice = parseFloat(response.cart.item.price) - (parseFloat(response.cart.item.price) * response.discount_amount / 100);
                                        @endif
                                        var newCapora = newPrice * 2 / 100;

                                        @if (isset($housingOffer))
                                            $('.booking-price-detail>ul>li').eq(2).css('color','red').html('İndirim Tutarı<strong class="pull-right">'+(formatPrice(parseFloat(response.cart.item.price) * response.discount_amount / 100))+' TL</strong>')
                                            $('.booking-price-detail>ul>li').eq(3).css('color','green').html('Yeni Fiyat<strong class="pull-right">'+(formatPrice(newPrice))+' TL</strong>')
                                            $('.booking-price-detail>ul>li').eq(4).html('Toplam Fiyatın %2 Kaporası :<strong class="pull-right">'+(formatPrice(newCapora))+' TL</strong>')
                                        @else
                                            $('.booking-price-detail>ul>li').eq(1).css('color','red').html('İndirim Tutarı<strong class="pull-right">'+(formatPrice(parseFloat(response.cart.item.price) * response.discount_amount / 100))+' TL</strong>')
                                            $('.booking-price-detail>ul>li').eq(2).css('color','green').html('Yeni Fiyat<strong class="pull-right">'+(formatPrice(newPrice))+' TL</strong>')
                                            $('.booking-price-detail>ul>li').eq(3).html('Toplam Fiyatın %2 Kaporası :<strong class="pull-right">'+(formatPrice(newCapora))+' TL</strong>')
                                            $('.discounted-price-x').html((formatPrice(newPrice))+' ₺')
                                        @endif
                                        
                                        $('.button-price-inner').html(formatPrice(newCapora))
                                        $('.capora-button-price').html((formatPrice(newCapora)))
                                        $('.have_discount').val(1);
                                        $('.discount').val($('.coupon-code').val());
                                        $('.discounted-price-x').html((formatPrice(newPrice))+' ₺')
                                    }else{
                                        var newPrice = parseFloat(response.cart.item.price) - parseFloat( response.discount_amount);

                                        var newCapora = newPrice * 2 / 100;

                                        $('.booking-price-detail ul li').eq(1).after('<li style="color:red;">İndirim Tutarı<strong class="pull-right">'+(formatPrice(response.discount_amount))+' TL</strong></li>')
                                        $('.booking-price-detail ul li').eq(2).after('<li style="color:green;">Yeni Fiyat<strong class="pull-right">'+(formatPrice(newPrice))+' TL</strong></li>')
                                        $('.booking-price-detail ul li').eq(4).html('Toplam Fiyatın %2 Kaporası :<strong class="pull-right">'+(formatPrice(newCapora))+' TL</strong>')
                                        $('.button-price-inner').html(formatPrice(newCapora))
                                        $('.capora-button-price').html((formatPrice(newCapora)))
                                        $('.have_discount').val(1);
                                        $('.discount').val($('.coupon-code').val());
                                    }
                                }else{
                                    toastr.error(response.message)
                                }

                            },
                            error: function(error) {
                                // Hata durumunda buraya gelir
                                toast.error(error)
                                console.error("Hata oluştu: " + error);
                            }
                        });
                    }
                });
            @else
                $.ajax({
                    url: "{{ route('check.coupon') }}", // Sepete veri eklemek için uygun URL'yi belirtin
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        coupon_code : $('.coupon-code').val()
                    }, // Veriyi göndermek için POST kullanabilirsiniz, // Sepete eklemek istediğiniz ürün verilerini gönderin
                    success: function(response) {
                        // İşlem başarılı olduğunda buraya gelir
                        response = JSON.parse(response)
                        if(response.status){
                            if(response.discount_type == 1){
                                var newPrice = parseFloat(response.cart.item.price) - {{$housingOffer->discount_amount}} - (parseFloat(response.cart.item.price) * response.discount_amount / 100);

                                var newCapora = newPrice * 2 / 100;

                                $('.booking-price-detail ul li').eq(1).after('<li style="color:red;">İndirim Tutarı<strong class="pull-right">'+(formatPrice(parseFloat(response.cart.item.price) * response.discount_amount / 100))+' TL</strong></li>')
                                $('.booking-price-detail ul li').eq(2).after('<li style="color:green;">Yeni Fiyat<strong class="pull-right">'+(formatPrice(newPrice))+' TL</strong></li>')
                                $('.booking-price-detail ul li').eq(4).html('Toplam Fiyatın %2 Kaporası :<strong class="pull-right">'+(formatPrice(newCapora))+' TL</strong>')
                                $('.button-price-inner').html(formatPrice(newCapora))
                                $('.capora-button-price').html((formatPrice(newCapora)))
                                $('.have_discount').val(1);
                                $('.discount').val($('.coupon-code').val());
                            }else{
                                var newPrice = parseFloat(response.cart.item.price) - parseFloat( response.discount_amount);

                                var newCapora = newPrice * 2 / 100;

                                $('.booking-price-detail ul li').eq(1).after('<li style="color:red;">İndirim Tutarı<strong class="pull-right">'+(formatPrice(response.discount_amount))+' TL</strong></li>')
                                $('.booking-price-detail ul li').eq(2).after('<li style="color:green;">Yeni Fiyat<strong class="pull-right">'+(formatPrice(newPrice))+' TL</strong></li>')
                                $('.booking-price-detail ul li').eq(4).html('Toplam Fiyatın %2 Kaporası :<strong class="pull-right">'+(formatPrice(newCapora))+' TL</strong>')
                                $('.button-price-inner').html(formatPrice(newCapora))
                                $('.capora-button-price').html((formatPrice(newCapora)))
                                $('.have_discount').val(1);
                                $('.discount').val($('.coupon-code').val());
                            }
                        }else{
                            toastr.error(response.message)
                        }

                    },
                    error: function(error) {
                        // Hata durumunda buraya gelir
                        toast.error(error)
                        console.error("Hata oluştu: " + error);
                    }
                });
            @endif
            
        })

        function formatPrice(price) {
            var parts = price.toString().split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return parts.join(".");
        }
    </script>


    <script>
        $(document).ready(function() {
            $(".paymentButton").on("click", function() {
                var uniqueCode = generateUniqueCode();
                $('#uniqueCode').text(uniqueCode);
                $('#uniqueCodeRetry').text(uniqueCode);
                $("#orderKey").val(uniqueCode);
            });

            // Rastgele bir benzersiz kod oluşturan fonksiyon
            function generateUniqueCode() {
                return Math.random().toString(36).substring(2, 10).toUpperCase();
            }
        });
    </script>

    <script>
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
    </script>
    <!-- HTML kısmı -->

    <!-- JavaScript kısmı -->
    <script>
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
