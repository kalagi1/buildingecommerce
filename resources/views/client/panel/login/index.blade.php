<!DOCTYPE html>
<html lang="tr" dir="ltr">


<!-- Mirrored from prium.github.io/phoenix/v1.13.0/pages/authentication/card/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 20 Aug 2023 12:32:04 GMT -->

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kurumsal Üye</title>
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ URL::to('/') }}/favicon.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ URL::to('/') }}/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ URL::to('/') }}/favicon.png">
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ URL::to('/') }}/favicon.png">
    <link rel="manifest" href="{{ URL::to('/') }}/adminassets/assets/img/favicons/manifest.json">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <meta name="msapplication-TileImage"
        content="{{ URL::to('/') }}/favicon.png">
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
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
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
</head>

<body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container-fluid bg-300 dark__bg-1200">
            <div class="bg-holder bg-auth-card-overlay"
                style="background-image:url({{ URL::to('/') }}/adminassets/assets/img/bg/37.png);"></div>
            <!--/.bg-holder-->
            <div class="row flex-center position-relative min-vh-100 g-0 py-5">
                <div class="col-11 col-sm-4 col-xl-4 px-5">
                    <div class="card border border-200 auth-card">
                        <div class="card-body pe-md-0">
                            <div class="row align-items-center gx-0 gy-7">
                                <div class="col mx-auto py-5">
                                    <form action="{{ route('institutional.login.post') }}" method="post">
                                        @csrf
                                        <div class="auth-form-box">
                                            <div class="text-center mb-7"><a
                                                    class="d-flex flex-center text-decoration-none mb-4"
                                                    href="{{ URL::to('/') }}">
                                                    <div
                                                        class="d-flex align-items-center fw-bolder fs-5 d-inline-block">
                                                        <img src="{{ URL::to('/') }}/images/emlaksepettelogo.png"
                                                            alt="phoenix" width="250" />
                                                    </div>
                                                </a>
                                                <h3 class="text-1000">Kurumsal Giriş Yap</h3>
                                                <p class="text-700">Hesabınıza erişim sağlayın</p>
                                            </div>
                                            @if (session()->has('success'))
                                                <div class="alert text-white alert-success">
                                                    {{ session()->get('success') }}
                                                </div>
                                            @elseif (session()->has('error'))
                                                <div class="alert text-white alert-danger">
                                                    {{ session()->get('error') }}
                                                </div>
                                            @elseif (session()->has('warning'))
                                                <div class="alert text-white alert-warning">
                                                    {{ session()->get('warning') }}
                                                </div>
                                            @endif
                                            @if ($errors->any())
                                                <div class="alert text-white alert-danger">

                                                    @foreach ($errors->all() as $error)
                                                        {{ $error }}
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="mb-3 text-start"><label class="form-label" for="email">Email
                                                    Adresi</label>
                                                <div class="form-icon-container"><input
                                                        class="form-control form-icon-input" name="email"
                                                        id="email" type="email"
                                                        placeholder="name@example.com" /><span
                                                        class="fas fa-user text-900 fs--1 form-icon"></span></div>
                                            </div>
                                            <div class="mb-3 text-start">
                                                <label class="form-label" for="password">Şifre</label>
                                                <div class="form-icon-container">
                                                    <input autocomplete="off" class="form-control form-icon-input"
                                                        name="password" id="password" type="password"
                                                        placeholder="Password" />
                                                    <span class="fas fa-key text-900 fs--1 form-icon"></span>
                                                </div>
                                            </div>




                                            <div class="row flex-between-center mb-7">
                                                <div class="forgot-password d-flex justify-content-between">
                                                    <a href="{{ route('client.login') }}"><span>Bireysel
                                                            Giriş</span></a>
                                                    <a href="{{ route('password.request') }}"><span>Şifremi
                                                            Unuttum</span></a>
                                                </div>
                                            </div><button class="btn btn-primary w-100 mb-3">Kurumsal Giriş
                                                Yap</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main><!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ URL::to('/') }}/adminassets/vendors/popper/popper.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors/anchorjs/anchor.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors/is/is.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors/fontawesome/all.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors/lodash/lodash.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/polyfill.io/v3/polyfill.min58be.js?features=window.scroll"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors/list.js/list.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors/feather-icons/feather.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors/dayjs/dayjs.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/assets/js/phoenix.js"></script>

    <style>
        .forgot-password a {
            color: black;
            text-decoration: none
        }
    </style>
</body>


<!-- Mirrored from prium.github.io/phoenix/v1.13.0/pages/authentication/card/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 20 Aug 2023 12:32:05 GMT -->

</html>
