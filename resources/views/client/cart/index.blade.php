@extends('client.layouts.master')

@section('content')
    <section class="recently portfolio bg-white homepage-5 ">
        <div class="container">

            <div class="my-properties">
                <table class="table-responsive">
                    <thead>
                        <tr>
                            <th class="pl-2">Konut</th>
                            <th class="p-0"></th>
                            <th class="pl-2">İl</th>
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
                                    <a href="single-property-1.html"><img alt="my-properties-3"
                                            src="{{ $cart['item']['image'] }}" class="img-fluid"></a>
                                </td>
                                <td>
                                    <div class="inner">
                                        <a href="single-property-1.html">
                                            <h2>{{ $cart['item']['title'] }}</h2>
                                            <figure><i class="lni-map-marker"></i> {{ $cart['item']['address'] }}</figure>
                                        </a>
                                    </div>
                                </td>
                                <td> {{ $cart['item']['city'] }}</td>
                                <td> {{ $cart['item']['price'] }}</td>
                                <td class="actions">
                                    <a href="#" class="remove-from-cart" style="float: left"><i
                                            class="far fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
            <div class="row" style="justify-content: end">
                <div class="col-md-4 mt-5">
                    <div class="tr-single-box mb-0">
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
                                                class="pull-right">{{ number_format(floatval(str_replace('.', '', $cart['item']['price'])), 2, ',', '.') }}
                                                TL</strong></li>
                                        <li>%1'si<strong
                                                class="pull-right">{{ number_format(floatval(str_replace('.', '', $cart['item']['price'])) * 0.01, 2, ',', '.') }}
                                                TL</strong></li>
                                    </ul>
                                @endif
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
