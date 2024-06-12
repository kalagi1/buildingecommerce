
<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  

    <link rel="apple-touch-icon" type="image/png" href="https://cpwebassets.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png" />

    <meta name="apple-mobile-web-app-title" content="CodePen">

    <link rel="shortcut icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico" />

    <link rel="mask-icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/logo-pin-b4b4269c16397ad2f0f7a01bcdf513a1994f4c94b8af2f191c09eb0d601762b1.svg" color="#111" />



  
    <script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-2c7831bb44f98c1391d6a4ffda0e1fd302503391ca806e7fcc7b9b87197aec26.js"></script>


  <title>CodePen - Pop in text with stars</title>

    <link rel="canonical" href="https://codepen.io/JoeHastings/pen/yeeqNv">
  
  
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'>
  
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
</style>

  <script>
  window.console = window.console || function(t) {};
</script>

  
  
</head>

<body translate="no">
  <div class="congrats">
	<h1>Congratulations!</h1>
</div>
  <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/gsap/1.18.0/TweenMax.min.js'></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.2/underscore-min.js'></script>
      <script id="rendered-js" >
// Click "Congratulations!" to play animation

$(function () {
  var numberOfStars = 20;

  for (var i = 0; i < numberOfStars; i++) {if (window.CP.shouldStopExecution(0)) break;
    $('.congrats').append('<div class="blob fa fa-star ' + i + '"></div>');
  }window.CP.exitedLoop(0);

  animateText();

  animateBlobs();
});

$('.congrats').click(function () {
  reset();

  animateText();

  animateBlobs();
});

function reset() {
  $.each($('.blob'), function (i) {
    TweenMax.set($(this), { x: 0, y: 0, opacity: 1 });
  });

  TweenMax.set($('h1'), { scale: 1, opacity: 1, rotation: 0 });
}

function animateText() {
  TweenMax.from($('h1'), 0.8, {
    scale: 0.4,
    opacity: 0,
    rotation: 15,
    ease: Back.easeOut.config(4) });

}

function animateBlobs() {

  var xSeed = _.random(350, 380);
  var ySeed = _.random(120, 170);

  $.each($('.blob'), function (i) {
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
      onStart: function ($element) {
        $element.css('display', 'block');
      },
      onCompleteParams: [$blob],
      onComplete: function ($element) {
        $element.css('display', 'none');
      } });

  });
}
//# sourceURL=pen.js
    </script>

  
</body>

</html>
