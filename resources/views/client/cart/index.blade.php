@extends('client.layouts.master')

@section('content')
    <section class="recently portfolio bg-white homepage-5 ">
        <div class="container">

            <div class="row" style="justify-content: end">
                <div class="col-md-8 mt-5">
                    <div class="my-properties">
                        <table class="table-responsive">
                            <thead class="mobile-hidden">
                                <tr>
                                    <th class="pl-2">Konut</th>
                                    <th class="p-0"></th>
                                    <th class="pl-2">Fiyat</th>
                                    <th>Kaldır</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!$cart || empty($cart['item']))
                                    <tr>
                                        <td colspan="5">Sepette Ürün Bulunmuyor</td>

                                    </tr>
                                @else
                                    @php(
                                    $discount_amount =
                                        App\Models\Offer::where('type', 'housing')->where('housing_id', $cart['item']['id'])->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0
                                )
                                    <tr>
                                        <td class="image myelist">
                                            <a
                                                href="{{ $cart['type'] == 'housing' ? route('housing.show', ['id' => $cart['item']['id']]) : route('project.housings.detail', ['projectSlug' => App\Models\Project::find($cart['item']['id'])->slug ?? '', 'id' =>$cart['item']['housing'] ]) }}"><img
                                                    alt="my-properties-3" src="{{ $cart['item']['image'] }}"
                                                    class="img-fluid"></a>
                                        </td>
                                        <td>
                                            <div class="inner">
                                                <a
                                                    href="{{ $cart['type'] == 'housing' ? route('housing.show', ['id' => $cart['item']['id']]) : route('project.housings.detail', ['projectSlug' => App\Models\Project::find($cart['item']['id'])->slug ?? '' ,  'id' =>$cart['item']['housing']]) }}">
                                                    <h2 style="font-weight: 600">{{ $cart['item']['title'] }}</h2>
                                                    <figure><i class="lni-map-marker"></i> {{ $cart['item']['city'] }}
                                                    </figure>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <span style="color:#e54242; font-weight:600">
                                                @if ($discount_amount)
                                                    <svg viewBox="0 0 24 24" width="18" height="18"
                                                        stroke="currentColor" stroke-width="2" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                        <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                        <polyline points="17 18 23 18 23 12"></polyline>
                                                    </svg>
                                                @endif
                                                {{ number_format($cart['item']['price'] - $cart['item']['discount_amount'], 0, ',', '.') }}
                                                ₺
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
                            <div class="tr-single-header pb-3">
                                <h4><i class="fa fa-star-o"></i>Sepet Özeti</h4>
                            </div>
                            <div class="booking-price-detail side-list no-border mb-3">
                                @if (!$cart || empty($cart['item']))
                                    <ul>
                                        <li>Ürün Fiyatı<strong class="pull-right">00.00
                                                TL</strong></li>
                                    </ul>
                                @else
                                    <ul>
                                        <li>Ürün Fiyatı<strong
                                                class="pull-right">{{ number_format(floatval(str_replace('.', '', $cart['item']['price'] - $cart['item']['discount_amount'])), 0, ',', '.') }}
                                                TL</strong></li>
                                        <li>%1'i<strong
                                                class="pull-right">{{ number_format(floatval(str_replace('.', '', $cart['item']['price'] - $cart['item']['discount_amount'])) * 0.01, 0, ',', '.') }}
                                                TL</strong></li>
                                    </ul>
                                @endif
                                <ul>
                                    <li>
                                        <button type="button" class="btn btn-primary btn-lg btn-block mb-3"
                                           data-toggle="modal"
                                            data-target="#paymentModal">
                                            Satın Al
                                        </button>
                                     
                                    </li>
                                </ul>
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
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="invoice">
                                <div class="invoice-header mb-3">
                                    <strong>Fatura Tarihi: {{ date('d.m.Y') }}</strong>
                                </div>

                                <div class="invoice-body">
                                    <table class="table table-bordered d-none d-md-table"> <!-- Tabloyu sadece tablet ve daha büyük ekranlarda göster -->
                                        <thead>
                                            <tr>
                                                <th>Ürün Görseli</th>
                                                <th>Ürün Adı</th>
                                                <th>Miktar</th>
                                                <th>Fiyat</th>
                                                <th>Toplam</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a
                                                    href="{{ $cart['type'] == 'housing' ? route('housing.show', ['id' => $cart['item']['id']]) : route('project.housing.detail', ['slug' => App\Models\Project::find($cart['item']['id'])->slug ?? '']) }}"><img
                                                        alt="my-properties-3" src="{{ $cart['item']['image'] }}"
                                                        style="width:100px"
                                                        class="img-fluid"></a>
                                                </td>
                                                <td>{{ $cart['item']['title'] }}</td>
                                                <td>1</td>
                                                <td>{{ number_format($cart['item']['price'] - $cart['item']['discount_amount'], 0, ',', '.') }} ₺</td>
                                                <td>{{ number_format(floatval(str_replace('.', '', $cart['item']['price'] - $cart['item']['discount_amount'])) * 0.01, 0, ',', '.') }} ₺</td>
                                            </tr>
                                        </tbody>
                                    </table>
                        
                                    <!-- Mobilde sadece alt alta liste göster -->
                                    <div class="d-md-none">
                                        <ul class="list-group">
                                         
                                                <li class="list-group-item">
                                                    <strong>Ürün Görseli:</strong> 
                                                    <a
                                                    href="{{ $cart['type'] == 'housing' ? route('housing.show', ['id' => $cart['item']['id']]) : route('project.housing.detail', ['slug' => App\Models\Project::find($cart['item']['id'])->slug ?? '']) }}"><img
                                                        alt="my-properties-3" src="{{ $cart['item']['image'] }}"
                                                        class="img-fluid"></a>
                                                </li>
                                            <li class="list-group-item">
                                                <strong>Ürün Adı:</strong> {{ $cart['item']['title'] }}
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Miktar:</strong> 1
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Fiyat:</strong> {{ number_format($cart['item']['price'] - $cart['item']['discount_amount'], 0, ',', '.') }} ₺
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Toplam:</strong> {{ number_format(floatval(str_replace('.', '', $cart['item']['price'] - $cart['item']['discount_amount'])) * 0.01, 0, ',', '.') }} ₺
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="invoice-total mt-3">
                                    <strong class="mt-3">EFT/Havale yapacağınız bankayı seçiniz</strong>
                                    <div class="row mb-3 px-5 mt-3">
                                        @foreach ($bankAccounts as $bankAccount)
                                            <div class="col-md-4 bank-account" data-id="{{ $bankAccount->id }}"
                                                data-iban="{{ $bankAccount->iban }}"
                                                data-title="{{ $bankAccount->receipent_full_name }}">
                                                <img src="{{ URL::to('/') }}/{{ $bankAccount->image }}" alt=""
                                                    style="width: 100%;height:100px;object-fit:contain;cursor:pointer">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div id="ibanInfo"></div>
                                    <strong>Ödeme işlemini tamamlamak için, lütfen bu
                                        <span style="color:red" id="uniqueCode"></span> kodu kullanarak ödemenizi
                                        yapın. IBAN açıklama
                                        alanına
                                        bu kodu eklemeyi unutmayın. Ardından "Ödemeyi Tamamla" düğmesine tıklayarak işlemi
                                        bitirin.</strong>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @if ((Auth::check() && Auth::user()->type == '2') || (Auth::check() && Auth::user()->parent_id)) disabled @endif
                                class="btn btn-primary btn-lg btn-block mb-3" id="completePaymentButton">Satın Al
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
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Ödemeniz başarıyla tamamlamak için lütfen aşağıdaki adımları takip edin:</p>
                            <ol>
                                <li>
                                    <strong style="color:red" id="uniqueCodeRetry"></strong> kodunu EFT/Havale açıklama
                                    alanına yazdığınızdan emin olun.
                                </li>
                                <li>
                                    Son olarak, işlemi bitirmek için aşağıdaki butona tıklayın: <br>
                                    <form action="{{ route('pay.cart') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="key" id="orderKey">
                                        <input type="hidden" name="banka_id" id="bankaID">

                                        <button type="submit" class="btn btn-primary paySuccess mt-3">Ödemeyi Tamamla
                                            <svg viewBox="0 0 576 512" class="svgIcon">
                                                <path
                                                    d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24H360c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z">
                                                </path>
                                            </svg></button>
                                    </form>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        @endif


    </section>
@endsection
@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            // Başlangıçta ödeme düğmesini devre dışı bırak
            $('#completePaymentButton').prop('disabled', true);


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
                $('#completePaymentButton').prop('disabled', false);
            });

            $('#completePaymentButton').on('click', function() {
                $('#paymentModal').modal('hide');
                $('#finalConfirmationModal').modal('show');
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#paymentModal').on('show.bs.modal', function(e) {
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
    <script>
        // "Sil" düğmesine tıklanıldığında
        $(".remove-from-cart").click(function() {
            var productId = $(this).data('id');
            var confirmation = confirm("Ürünü sepetten kaldırmak istiyor musunuz?");

            if (confirmation) {
                // Ürünü sepetten kaldırmak için Ajax isteği gönderme
                $.ajax({
                    url: "{{ route('client.remove.from.cart') }}", // Sepetten ürünü kaldırmak için uygun URL'yi belirtin
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                        // İşlem başarılı olduğunda buraya gelir
                        toastr.success("Ürün sepetten kaldırıldı");
                        console.log("Ürün sepetten kaldırıldı: " + response);
                        location.reload();

                    },
                    error: function(error) {
                        // Hata durumunda buraya gelir
                        toastr.error("Hata oluştu: " + error.responseText, "Hata");
                        console.error("Hata oluştu: " + error);
                    }
                });
            }
        });
    </script>
@endsection

