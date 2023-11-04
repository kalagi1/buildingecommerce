@extends('client.layouts.master')

@section('content')
    <section class="recently portfolio bg-white homepage-5 ">
        <div class="container">

            <div class="row" style="justify-content: end">
                <div class="col-md-8 mt-5">
                    <div class="my-properties">
                        <table class="table-responsive">
                            <thead>
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
        App\Models\Offer::where('type', 'housing')->where('housing_id', $cart['item']['id'])->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0,
)
                                    <tr>
                                        <td class="image myelist">
                                            <a
                                                href="{{ $cart['type'] == 'housing' ? route('housing.show', ['id' => $cart['item']['id']]) : route('project.housing.detail', ['slug' => App\Models\Project::find($cart['item']['id'])->slug ?? '']) }}"><img
                                                    alt="my-properties-3" src="{{ $cart['item']['image'] }}"
                                                    class="img-fluid"></a>
                                        </td>
                                        <td>
                                            <div class="inner">
                                                <a
                                                    href="{{ $cart['type'] == 'housing' ? route('housing.show', ['id' => $cart['item']['id']]) : route('project.housing.detail', ['slug' => App\Models\Project::find($cart['item']['id'])->slug ?? '']) }}">
                                                    <h2 style="font-weight: 600">{{ $cart['item']['title'] }}</h2>
                                                    <figure><i class="lni-map-marker"></i> {{ $cart['item']['city'] }}
                                                    </figure>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <span style="color:#e54242; font-weight:600">
                                                @if ($discount_amount)
                                                    <svg viewBox="0 0 24 24" width="24" height="24"
                                                        stroke="currentColor" stroke-width="2" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                        <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                        <polyline points="17 18 23 18 23 12"></polyline>
                                                    </svg>
                                                @endif
                                                {{ number_format($cart['item']['price'] - $cart['item']['discount_amount'], 2, ',', '.') }}
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
                                                class="pull-right">{{ number_format(floatval(str_replace('.', '', $cart['item']['price'] - $cart['item']['discount_amount'])), 2, ',', '.') }}
                                                TL</strong></li>
                                        <li>%1'si<strong
                                                class="pull-right">{{ number_format(floatval(str_replace('.', '', $cart['item']['price'] - $cart['item']['discount_amount'])) * 0.01, 2, ',', '.') }}
                                                TL</strong></li>
                                    </ul>
                                @endif
                                <ul>
                                    <li>
                                        <button type="button" class="btn btn-primary btn-lg btn-block mb-3"
                                            data-toggle="modal" data-target="#paymentModal">
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
                        <!-- Fatura / Sipariş Bilgileri -->
                        <div class="invoice">
                            <div class="invoice-header">
                                <h3>Fatura Detayları</h3>
                                <p>Fatura Tarihi: {{ date('d.m.Y') }}</p>
                            </div>

                            <div class="invoice-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Ürün Adı</th>
                                            <th>Miktar</th>
                                            <th>Fiyat</th>
                                            <th>Toplam</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $cart['item']['title'] }}</td>
                                            <td>1</td>
                                            <td>{{ number_format($cart['item']['price'] - $cart['item']['discount_amount'], 2, ',', '.') }}
                                                ₺</td>
                                            <td>{{ number_format(floatval(str_replace('.', '', $cart['item']['price'] - $cart['item']['discount_amount'])) * 0.01, 2, ',', '.') }}
                                                ₺</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="invoice-total">
                                <span>EFT/Havale yapacağınız bankayı seçiniz</span>

                                @foreach ($bankAccounts as $bankAccount)
                                    <div class="col-md-3 bank-account" bank_id="{{ $bankAccount->id }}">
                                        <img src="{{ URL::to('/') }}/{{ $bankAccount->image }}" alt="">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- Ödeme işlemi düğmesi burada bulunuyor -->
                        <button type="submit" @if ((Auth::check() && Auth::user()->type == '2') || (Auth::check() && Auth::user()->parent_id)) disabled @endif
                            class="btn btn-primary btn-lg btn-block mb-3">Satın Al
                        </button>

                        @if ((Auth::check() && Auth::user()->type == '2') || (Auth::check() && Auth::user()->parent_id))
                            <span class="text-danger">Mağazalar için şu an satın alma modülümüz
                                kapalıdır.</span>
                        @endif
                    </div>
                </div>


            </div>
        </div>


    </section>
@endsection
@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
