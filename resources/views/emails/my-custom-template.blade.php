
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <title>Fastkart | Email template </title>

    <!-- Google Font css -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&display=swap"
        rel="stylesheet">

    <style type="text/css">
        body {
            text-align: center;
            margin: 0 auto;
            width: 650px;
            font-family: 'Public Sans', sans-serif;
            background-color: #e2e2e2;
            display: block;
        }

        .mb-3 {
            margin-bottom: 30px;
        }

        ul {
            margin: 0;
            padding: 0;
        }

        li {
            display: inline-block;
            text-decoration: unset;
        }

        a {
            text-decoration: none;
        }

        h5 {
            margin: 10px;
            color: #777;
        }

        .text-center {
            text-align: center
        }

        .header-menu ul li+li {
            margin-left: 20px;
        }

        .header-menu ul li a {
            font-size: 14px;
            color: #252525;
            font-weight: 500;
        }

        .password-button {
            background-color: #ea2a28;
            border: none;
            color: #fff;
            padding: 14px 26px;
            font-size: 18px;
            font-weight: 700;
            font-family: 'Nunito Sans', sans-serif;
        }

        .password-button u{
            text-decoration: none !important
        }

        .footer-table {
            position: relative;
        }

        .footer-table::before {
            position: absolute;
            content: "";
            background-image: url(images/footer-left.svg);
            background-position: top right;
            top: 0;
            left: -71%;
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            z-index: -1;
            background-size: contain;
            opacity: 0.3;
        }

        .footer-table::after {
            position: absolute;
            content: "";
            background-image: url(images/footer-right.svg);
            background-position: top right;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            z-index: -1;
            background-size: contain;
            opacity: 0.3;
        }

        .theme-color {
            color: #0DA487;
        }
    </style>
</head>

<body style="margin: 20px auto;">
    <table align="center" border="0" cellpadding="0" cellspacing="0"
        style="background-color: white; width: 100%; box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);-webkit-box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);">
        <tbody>
            <tr>
                <td>
                    <table class="header-table" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr class="header"
                            style="background-color: #f7f7f7;display: flex;flex-wrap:wrap;align-items: center;justify-content: space-between;width: 100%;">
                            <td class="header-logo" style="padding: 10px 32px;">
                                <a href="{{url('/')}}" style="display: block; text-align: left;">
                                    <img src="https://emlaksepette.com/images/emlaksepettelogo.png"
                                    style="width: 200px" class="main-logo" alt="logo">
                                </a>
                            </td>
                            <td class="header-menu" style="display: block; padding: 10px 32px;text-align: right;">
                                <ul>
                                    <li>
                                        <a href="{{url('/')}}">Anasayfa</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/sayfa/hakkimizda')}}">Hakkımızda</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/sayfa/kvkk_politikasi')}}">KVKK</a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </table>

                    <table class="content-table" style="margin-bottom: -6px;" align="center" border="0" cellpadding="0"
                        cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <td>
                                    <img src="images/welcome-poster.jpg" alt="">
                                </td>
                            </tr>
                        </thead>
                    </table>

                    <table class="content-table" style="margin-top: 40px;" align="center" border="0" cellpadding="0"
                        cellspacing="0" width="100%">
                        <thead>
                            <tr style="display: block;">
                                <td style="display: block;">
                                    <h3
                                        style="font-weight: 700; font-size: 20px; margin: 0; text-transform: uppercase;">
                                        {!! $subject !!}</h3>
                                </td>

                                <td>
                                    <p
                                        style="font-size: 14px;font-weight: 600;width: 82%;margin: 8px auto 0;line-height: 1.5;color: #939393;font-family: 'Nunito Sans', sans-serif;">
                                        {!! $content !!}
                                    </p>
                                </td>
                            </tr>
                        </thead>
                    </table>

                 

                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>