@extends('client.layouts.master')

@section('content')
    <section class="recently portfolio bg-white homepage-5 ">
        <div class="container text-center">

            <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaGVpZ2h0PSIyNCIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iMjQiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6Y2M9Imh0dHA6Ly9jcmVhdGl2ZWNvbW1vbnMub3JnL25zIyIgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPjxnIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAgLTEwMjguNCkiPjxwYXRoIGQ9Im0yMiAxMmMwIDUuNTIzLTQuNDc3IDEwLTEwIDEwLTUuNTIyOCAwLTEwLTQuNDc3LTEwLTEwIDAtNS41MjI4IDQuNDc3Mi0xMCAxMC0xMCA1LjUyMyAwIDEwIDQuNDc3MiAxMCAxMHoiIGZpbGw9IiMyN2FlNjAiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAgMTAyOS40KSIvPjxwYXRoIGQ9Im0yMiAxMmMwIDUuNTIzLTQuNDc3IDEwLTEwIDEwLTUuNTIyOCAwLTEwLTQuNDc3LTEwLTEwIDAtNS41MjI4IDQuNDc3Mi0xMCAxMC0xMCA1LjUyMyAwIDEwIDQuNDc3MiAxMCAxMHoiIGZpbGw9IiMyZWNjNzEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAgMTAyOC40KSIvPjxwYXRoIGQ9Im0xNiAxMDM3LjQtNiA2LTIuNS0yLjUtMi4xMjUgMi4xIDIuNSAyLjUgMiAyIDAuMTI1IDAuMSA4LjEyNS04LjEtMi4xMjUtMi4xeiIgZmlsbD0iIzI3YWU2MCIvPjxwYXRoIGQ9Im0xNiAxMDM2LjQtNiA2LTIuNS0yLjUtMi4xMjUgMi4xIDIuNSAyLjUgMiAyIDAuMTI1IDAuMSA4LjEyNS04LjEtMi4xMjUtMi4xeiIgZmlsbD0iI2VjZjBmMSIvPjwvZz48L3N2Zz4="
                width="128px" height="128px" class="mb-3" />

            <div style="color: #27ae60; font-size: 26px; text-align: center;">ÖDEME BAŞARILI</div>
            <p style="font-size: 18px;">Sipariş başarıyla verildi. Sipariş numaranız: {{ $cart_order->key }}</p>
            
          
<a href="{{ route('institutional.profile.cart-orders') }}" class="btn btn-primary btn-lg">Siparişleri Görüntüle</a>


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
