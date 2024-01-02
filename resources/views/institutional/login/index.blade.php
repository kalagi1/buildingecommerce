<!DOCTYPE html>
<html lang="en-US" dir="ltr">


<!-- Mirrored from prium.github.io/phoenix/v1.13.0/pages/authentication/card/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 20 Aug 2023 12:32:04 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kurumsal Üye</title>
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
        <div class="support-chat-container">
            <div class="container-fluid support-chat">
                <div class="card bg-white">
                    <div class="card-header d-flex flex-between-center px-4 py-3 border-bottom">
                        <h5 class="mb-0 d-flex align-items-center gap-2">Demo widget<span
                                class="fa-solid fa-circle text-success fs--3"></span></h5>
                        <div class="btn-reveal-trigger"><button
                                class="btn btn-link p-0 dropdown-toggle dropdown-caret-none transition-none d-flex"
                                type="button" id="support-chat-dropdown" data-bs-toggle="dropdown"
                                data-boundary="window" aria-haspopup="true" aria-expanded="false"
                                data-bs-reference="parent"><span class="fas fa-ellipsis-h text-900"></span></button>
                            <div class="dropdown-menu dropdown-menu-end py-2" aria-labelledby="support-chat-dropdown">
                                <a class="dropdown-item" href="#!">Request a callback</a><a
                                    class="dropdown-item" href="#!">Search in chat</a><a class="dropdown-item"
                                    href="#!">Show history</a><a class="dropdown-item" href="#!">Report to
                                    Admin</a><a class="dropdown-item btn-support-chat" href="#!">Close
                                    Support</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body chat p-0">
                        <div class="d-flex flex-column-reverse scrollbar h-100 p-3">
                            <div class="text-end mt-6"><a
                                    class="mb-2 d-inline-flex align-items-center text-decoration-none text-1100 hover-bg-soft rounded-pill border border-primary py-2 ps-4 pe-3"
                                    href="#!">
                                    <p class="mb-0 fw-semi-bold fs--1">I need help with something</p><span
                                        class="fa-solid fa-paper-plane text-primary fs--1 ms-3"></span>
                                </a><a
                                    class="mb-2 d-inline-flex align-items-center text-decoration-none text-1100 hover-bg-soft rounded-pill border border-primary py-2 ps-4 pe-3"
                                    href="#!">
                                    <p class="mb-0 fw-semi-bold fs--1">I can’t reorder a product I previously ordered
                                    </p><span class="fa-solid fa-paper-plane text-primary fs--1 ms-3"></span>
                                </a><a
                                    class="mb-2 d-inline-flex align-items-center text-decoration-none text-1100 hover-bg-soft rounded-pill border border-primary py-2 ps-4 pe-3"
                                    href="#!">
                                    <p class="mb-0 fw-semi-bold fs--1">How do I place an order?</p><span
                                        class="fa-solid fa-paper-plane text-primary fs--1 ms-3"></span>
                                </a><a
                                    class="false d-inline-flex align-items-center text-decoration-none text-1100 hover-bg-soft rounded-pill border border-primary py-2 ps-4 pe-3"
                                    href="#!">
                                    <p class="mb-0 fw-semi-bold fs--1">My payment method not working</p><span
                                        class="fa-solid fa-paper-plane text-primary fs--1 ms-3"></span>
                                </a></div>
                            <div class="text-center mt-auto">
                                <div class="avatar avatar-3xl status-online"><img
                                        class="rounded-circle border border-3 border-white"
                                        src="{{ URL::to('/') }}/adminassets/assets/img/team/30.webp"
                                        alt="" /></div>
                                <h5 class="mt-2 mb-3">Eric</h5>
                                <p class="text-center text-black mb-0">Ask us anything – we’ll get back to you here or
                                    by email within 24 hours.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center gap-2 border-top ps-3 pe-4 py-3">
                        <div class="d-flex align-items-center flex-1 gap-3 border rounded-pill px-4"><input
                                class="form-control outline-none border-0 flex-1 fs--1 px-0" type="text"
                                placeholder="Write message" /><label
                                class="btn btn-link d-flex p-0 text-500 fs--1 border-0" for="supportChatPhotos"><span
                                    class="fa-solid fa-image"></span></label><input class="d-none" type="file"
                                accept="image/*" id="supportChatPhotos" /><label
                                class="btn btn-link d-flex p-0 text-500 fs--1 border-0" for="supportChatAttachment">
                                <span class="fa-solid fa-paperclip"></span></label><input class="d-none"
                                type="file" id="supportChatAttachment" /></div><button
                            class="btn p-0 border-0 send-btn"><span
                                class="fa-solid fa-paper-plane fs--1"></span></button>
                    </div>
                </div>
            </div><button class="btn p-0 border border-200 btn-support-chat"><span
                    class="fs-0 btn-text text-primary text-nowrap">Chat demo</span><span
                    class="fa-solid fa-circle text-success fs--1 ms-2"></span><span
                    class="fa-solid fa-chevron-down text-primary fs-1"></span></button>
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
