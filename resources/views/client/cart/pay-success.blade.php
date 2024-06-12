@extends('client.layouts.master')

@section('content')
    <section class="recently portfolio bg-white homepage-5 ">
        <div class="container text-center">
            <div class="congrats">
                <h1>Congratulations!</h1>
            </div>
            <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaGVpZ2h0PSIyNCIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iMjQiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6Y2M9Imh0dHA6Ly9jcmVhdGl2ZWNvbW1vbnMub3JnL25zIyIgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPjxnIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAgLTEwMjguNCkiPjxwYXRoIGQ9Im0yMiAxMmMwIDUuNTIzLTQuNDc3IDEwLTEwIDEwLTUuNTIyOCAwLTEwLTQuNDc3LTEwLTEwIDAtNS41MjI4IDQuNDc3Mi0xMCAxMC0xMCA1LjUyMyAwIDEwIDQuNDc3MiAxMCAxMHoiIGZpbGw9IiMyN2FlNjAiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAgMTAyOS40KSIvPjxwYXRoIGQ9Im0yMiAxMmMwIDUuNTIzLTQuNDc3IDEwLTEwIDEwLTUuNTIyOCAwLTEwLTQuNDc3LTEwLTEwIDAtNS41MjI4IDQuNDc3Mi0xMCAxMC0xMCA1LjUyMyAwIDEwIDQuNDc3MiAxMCAxMHoiIGZpbGw9IiMyZWNjNzEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAgMTAyOC40KSIvPjxwYXRoIGQ9Im0xNiAxMDM3LjQtNiA2LTIuNS0yLjUtMi4xMjUgMi4xIDIuNSAyLjUgMiAyIDAuMTI1IDAuMSA4LjEyNS04LjEtMi4xMjUtMi4xeiIgZmlsbD0iIzI3YWU2MCIvPjxwYXRoIGQ9Im0xNiAxMDM2LjQtNiA2LTIuNS0yLjUtMi4xMjUgMi4xIDIuNSAyLjUgMiAyIDAuMTI1IDAuMSA4LjEyNS04LjEtMi4xMjUtMi4xeiIgZmlsbD0iI2VjZjBmMSIvPjwvZz48L3N2Zz4="
                width="128px" height="128px" class="mb-3" />

            <div style="color: #27ae60; font-size: 26px; text-align: center;">ÖDEME BAŞARILI</div>
            <p style="font-size: 18px;">Sipariş başarıyla verildi. Sipariş Numaranız: {{ $cart_order->id }}</p>


            <a href="{{ route('institutional.profile.cart-orders') }}" class="btn btn-primary btn-lg">Siparişleri
                Görüntüle</a>

            <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Anasayfaya Gİt</a>

            <!-- İlerleme çubuğu -->
            {{-- <div class="progress mt-3">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100"
                    aria-valuemin="0" aria-valuemax="100" style="width: 100%;height:50px;">Anasayfaya
                    Yönlendiriliyorsunuz...</div>
            </div> --}}

        </div>



    </section>
@endsection
@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/gsap/1.18.0/TweenMax.min.js'></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.2/underscore-min.js'></script>
    <script>
        $(document).ready(function() {
            $(function() {
                var numberOfStars = 20;

                for (var i = 0; i < numberOfStars; i++) {
                    if (window.CP.shouldStopExecution(0)) break;
                    $('.congrats').append('<div class="blob fa fa-star ' + i + '"></div>');
                }
                window.CP.exitedLoop(0);

                animateText();

                animateBlobs();
            });

            $('.congrats').click(function() {
                reset();

                animateText();

                animateBlobs();
            });

            function reset() {
                $.each($('.blob'), function(i) {
                    TweenMax.set($(this), {
                        x: 0,
                        y: 0,
                        opacity: 1
                    });
                });

                TweenMax.set($('h1'), {
                    scale: 1,
                    opacity: 1,
                    rotation: 0
                });
            }

            function animateText() {
                TweenMax.from($('h1'), 0.8, {
                    scale: 0.4,
                    opacity: 0,
                    rotation: 15,
                    ease: Back.easeOut.config(4)
                });

            }

            function animateBlobs() {

                var xSeed = _.random(350, 380);
                var ySeed = _.random(120, 170);

                $.each($('.blob'), function(i) {
                    var $blob = $(this);
                    var speed = _.random(1, 5);
                    var rotation = _.random(5, 100);
                    var scale = _.random(0.8, 1.5);
                    var x = _.random(-xSeed, xSeed);
                    var y = _.random(-ySeed, ySeed);

                    TweenMax.to($blob, speed, {
                        x: x,
                        y: y,
                        ease: Power1.easeOut,
                        opacity: 0,
                        rotation: rotation,
                        scale: scale,
                        onStartParams: [$blob],
                        onStart: function($element) {
                            $element.css('display', 'block');
                        },
                        onCompleteParams: [$blob],
                        onComplete: function($element) {
                            $element.css('display', 'none');
                        }
                    });

                });
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


@section('styles')
    <style>
        @font-face {
  font-family: 'Sigmar One';
  font-style: normal;
  font-weight: 400;
  src: url(https://fonts.gstatic.com/s/sigmarone/v18/co3DmWZ8kjZuErj9Ta3do6Tpow.ttf) format('truetype');
}
body {
  background: #3da1d1;
  color: #fff;
  overflow: hidden;
}
.congrats {
  position: absolute;
  top: 140px;
  width: 550px;
  height: 100px;
  padding: 20px 10px;
  text-align: center;
  margin: 0 auto;
  left: 0;
  right: 0;
}
h1 {
  transform-origin: 50% 50%;
  font-size: 50px;
  font-family: 'Sigmar One', cursive;
  cursor: pointer;
  z-index: 2;
  position: absolute;
  top: 0;
  text-align: center;
  width: 100%;
}
.blob {
  height: 50px;
  width: 50px;
  color: #ffcc00;
  position: absolute;
  top: 45%;
  left: 45%;
  z-index: 1;
  font-size: 30px;
  display: none;
}
        .custom-file-upload {
            border: 1px solid #ccc;
            display: inline-block;
            padding: 9px 12px;
            cursor: pointer;
            background-color: #cfcfcf69;
            height: 47px;
            width: 100%;
            text-align: center;
            style="color: #0056b3 !important;
        }

        .custom-file-upload:hover {
            background-color: #eee;
        }

        .custom-file-upload input[type="file"] {
     display: none;
        }
    </style>
@endsection
