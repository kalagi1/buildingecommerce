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
                        @if (count($favorites) == 0)
                            <tr>
                                <td colspan="5">Favorileriniz Bulunmuyor</td>
                            </tr>
                        @else
                            @foreach ($favorites as $key => $item)
                                <tr>
                                    <td class="image myelist">
                                        <a href="{{ route('housing.show', $item->housing->id ) }}"><img alt="my-properties-3"
                                                src="{{ asset('housing_images/') . '/' . json_decode($item->housing->housing_type_data)->image }}"
                                                class="img-fluid"></a>
                                    </td>
                                    <td>
                                        <div class="inner">
                                            <a href="{{ route('housing.show', $item->housing->id ) }}">
                                                <h2 style="font-weight: 600">{{ $item->housing->title }}</h2>
                                                <figure><i class="lni-map-marker"></i> {{ $item->housing->address }}
                                                </figure>
                                            </a>
                                        </div>
                                    </td>
                                    <td> {{ $item->housing->city->title }}</td>
                                    <td> {{ json_decode($item->housing->housing_type_data)->price[0] }}₺</td>
                                    <td class="actions">
                                        <a href="#" class="remove-from-cart"
                                            data-housing-id="{{ $item->housing->id }}" style="float: left"><i
                                                class="far fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        @endif

                    </tbody>
                </table>
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
            var confirmation = confirm("Ürünü favorilerden kaldırmak istiyor musunuz?");

            if (confirmation) {
                // Ürünü sepetten kaldırmak için Ajax isteği gönderme
                var housingId = this.getAttribute("data-housing-id");

                // AJAX isteği gönderme
                $.ajax({
                    url: "{{ route('add.housing.to.favorites', ['id' => ':id']) }}"
                        .replace(':id',
                            housingId),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                        toastr.success("Ürün favorilerden kaldırıldı");
                        console.log("Ürün favorilerden kaldırıldı: " + response);
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
