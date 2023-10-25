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
                                            {{ number_format($cart['item']['price'] - $cart['item']['discount_amount'], 2, ',', '.') }}
                                            ₺ </td>
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

                                        <form action="{{ route('client.pay.cart') }}" method="POST">
                                            @csrf
                                            <button type="submit" @if (Auth::user()->type == '2') disabled @endif
                                                class="btn btn-primary btn-lg btn-block mb-3">ÖDEME
                                                YAP</button>
                                            @if (Auth::user()->type == '2')
                                                <span class="text-danger">Şu an mağazalar için satın alma modülümüz kapalıdır.</span>
                                            @endif

                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
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
