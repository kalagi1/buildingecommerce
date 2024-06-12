@extends('client.layouts.master')

@section('content')
    <section class="recently portfolio bg-white homepage-5 ">
        <div class="container text-center bg-congrat-style">
            <div class="congrats">
                <h1>Siparişiniz için Teşekkürler !</h1>
            </div>

            <h3>Sipariş Bilgileri</h3>

            <p style="font-size: 15px;"> #{{ $cart_order->id }} numaralı siparişiniz başarıyla oluşturuldu.</p>


            <a href="{{ route('institutional.profile.cart-orders') }}" class="btn btn-primary btn-lg">Siparişleri
                Görüntüle</a>

            <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Anasayfaya Gİt</a>


        </div>

        <button id="button-conf" onclick="startConfetti()">
            <i id="icon" class="fa-solid fa-play"></i>
            <span id="text" class="text">Start deploy</span>
          </button>

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
                    $('.congrats').append('<div class="blob fa fa-star ' + i + '"></div>');
                }

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
      <script src='https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js'></script>
      <script id="rendered-js" >
var startConfetti = function () {

  var text = document.getElementById("text");
  text.textContent = "Start deploy";
  text.className = "text hidden";

  var icon = document.getElementById("icon");
  icon.className = "fa-solid fa-spinner animate-spin";

  var button = document.getElementById("button-conf");
  button.className = "loading";
  const rect = button.getBoundingClientRect();
  const center = {
    x: rect.left + rect.width / 2,
    y: rect.top + rect.height / 2 };

  const origin = {
    x: center.x / window.innerWidth,
    y: center.y / window.innerHeight };


  // Canvas && confetti settings
  var myCanvas = document.createElement('canvas');
  document.body.appendChild(myCanvas);
  const defaults = {
    disableForReducedMotion: true };

  var colors = ['#757AE9', '#28224B', '#EBF4FF'];
  var myConfetti = confetti.create(myCanvas, {});

  // Confetti function to be more realistic
  function fire(particleRatio, opts) {
    confetti(
    Object.assign({}, defaults, opts, {
      particleCount: Math.floor(100 * particleRatio) }));


  }
  // Finished state confetti
  setTimeout(() => {
    icon.className = "";
    button.className = "success";
    fire(0.25, {
      spread: 26,
      startVelocity: 10,
      origin,
      colors });

    fire(0.2, {
      spread: 60,
      startVelocity: 20,
      origin,
      colors });

    fire(0.35, {
      spread: 100,
      startVelocity: 15,
      decay: 0.91,
      origin,
      colors });

    fire(0.1, {
      spread: 120,
      startVelocity: 10,
      decay: 0.92,
      origin,
      colors });

    fire(0.1, {
      spread: 120,
      startVelocity: 20,
      origin,
      colors });


  }, "3000");
  // Finished state text
  setTimeout(() => {
    text.textContent = "Finished";
    text.className = "text";
    icon.className = "fa-solid fa-check";
  }, 3500);
  // Reset animation
  setTimeout(() => {
    text.textContent = "Start deploy";
    icon.className = "fa-solid fa-play";
    button.className = "";
  }, 6000);
};
//# sourceURL=pen.js
    </script>
@endsection



@section('styles')
    <style>
        .congrats {
            position: relative;
            width: 550px;
            height: 100px;
            padding: 20px 10px;
            text-align: center;
            margin: 0 auto;
            left: 0;
            top: 140;
            right: 0;
        }

        .congrats h1 {
            transform-origin: 50% 50%;
            font-size: 25px;
            cursor: pointer;
            z-index: 2;
            position: relative;
            top: 140;
            text-align: center;
            width: 100%;
            color: #27ae60;
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

        .bg-congrat-style {
            border: 1px solid #ebebeb;
            padding-bottom: 20px;
            margin: 50px auto;
            width: 40%
        }
    </style>
@endsection
