<!DOCTYPE html>
<html lang="en-US" dir="ltr">


<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Admin Girişi</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ URL::to('/') }}/adminassets/assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ URL::to('/') }}/adminassets/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ URL::to('/') }}/adminassets/assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ URL::to('/') }}/adminassets/assets/img/favicons/favicon.ico">
    <link rel="manifest" href="{{ URL::to('/') }}/adminassets/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage"
        content="{{ URL::to('/') }}/adminassets/assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ URL::to('/') }}/adminassets/vendors/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors/simplebar/simplebar.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/assets/js/config.js"></script>

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ URL::to('/') }}/adminassets/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="{{ URL::to('/') }}/adminassets/assets/css/theme-rtl.min.css" type="text/css" rel="stylesheet"
        id="style-rtl">
    <link href="{{ URL::to('/') }}/adminassets/assets/css/theme.min.css" type="text/css" rel="stylesheet"
        id="style-default">
    <link href="{{ URL::to('/') }}/adminassets/assets/css/user-rtl.min.css" type="text/css" rel="stylesheet"
        id="user-style-rtl">
    <link href="{{ URL::to('/') }}/adminassets/assets/css/user.min.css" type="text/css" rel="stylesheet"
        id="user-style-default">
    <script>
        var phoenixIsRTL = window.config.config.phoenixIsRTL;
        if (phoenixIsRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
    <link href="{{ URL::to('/') }}/adminassets/vendors/leaflet/leaflet.css" rel="stylesheet">
    <link href="{{ URL::to('/') }}/adminassets/vendors/leaflet.markercluster/MarkerCluster.css" rel="stylesheet">
    <link href="{{ URL::to('/') }}/adminassets/vendors/leaflet.markercluster/MarkerCluster.Default.css"
        rel="stylesheet">
    @yield('css')
</head>

<body>
    <main class="main" id="top">
        <div class="container-fluid bg-300 dark__bg-1200">
            <div class="bg-holder bg-auth-card-overlay"
                style="background-image:url({{ asset('adminassets/assets/img/bg/37.png') }});">
            </div>
            <!--/.bg-holder-->
            <div class="row flex-center position-relative min-vh-100 g-0 py-2">
                <div class="col-11 col-sm-10 col-xl-5">
                    <div class="card border border-200 auth-card">
                        <div class="card-body pe-md-0">
                            <div class="row align-items-center gx-0 gy-3">
                                <div class="col mx-auto">
                                    <div class="auth-form-box">
                                        <form method="POST" action="{{ route('admin.submit.login') }}">
                                            @csrf

                                            <div class="text-center mb-7">
                                                <h3 class="text-1000">Yönetici Girişi</h3>
                                                <p class="text-700">Hesabınıza erişim sağlayın

                                                </p>
                                            </div>
                                            <div class="mb-3 text-start"><label class="form-label"
                                                    for="email">E-Posta
                                                </label>
                                                <div class="form-icon-container"><input
                                                        class="form-control form-icon-input" id="email"
                                                        name="email" type="email"
                                                        placeholder="name@example.com" /><span
                                                        class="fas fa-user text-900 fs--1 form-icon"></span></div>
                                            </div>
                                            <div class="mb-3 text-start"><label class="form-label"
                                                    for="password">Şifre</label>
                                                <div class="form-icon-container"><input
                                                        class="form-control form-icon-input" name="password"
                                                        id="password" type="password" placeholder="Password" /><span
                                                        class="fas fa-key text-900 fs--1 form-icon"></span></div>
                                            </div>
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <button type="submit" class="btn btn-primary w-100 mb-3">Giriş
                                                Yap</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ URL::to('/') }}/adminassets/vendors//popper/popper.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors//bootstrap/bootstrap.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors//anchorjs/anchor.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors//is/is.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors//fontawesome/all.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors//lodash/lodash.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/polyfill.io/v3/polyfill.min58be.js?features=window.scroll"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors//list.js/list.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors//feather-icons/feather.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors//dayjs/dayjs.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/assets//js/phoenix.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors//echarts/echarts.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors//leaflet/leaflet.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors//leaflet.markercluster/leaflet.markercluster.js"></script>
    <script
        src="{{ URL::to('/') }}/adminassets/vendors//leaflet.tilelayer.colorfilter/leaflet-tilelayer-colorfilter.min.js">
    </script>

    <script src="{{ URL::to('/') }}/adminassets/assets//js/ecommerce-dashboard.js"></script>
    <!--FormBuilder-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-formBuilder/3.4.2/form-render.min.js">
    </script>
    <!--FormBuilder-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.6.0/leaflet.js"></script>
    <script src="https://www.jqueryscript.net/demo/leaflet-location-picker/src/leaflet-locationpicker.js"></script>
    @yield('scripts')
</body>



</html>
