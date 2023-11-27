
<style type="text/css">
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    ul {
        list-style: none;
    }

    li {
        display: inline-block;
    }

    body {
        text-align: center;
        margin: 20px auto;
        width: 650px;
        font-family: "Nunito Sans", sans-serif;
        background-color: #e2e2e2;
        display: block;
        position: relative;
    }

    @media only screen and (max-width: 665px) {
        body {
            width: 100%;
            margin: 0;
        }
    }

    a {
        text-decoration: none;
    }

    table {
        border-collapse: collapse;
        border-spacing: 0;
    }

    .main-logo {
        width: 150px;
        height: auto;
    }

    .header td {
        padding: 16px calc(12px + (26 - 12) * ((100vw - 320px) / (1920 - 320)));
    }

    @media only screen and (max-width: 450px) {
        .header {
            display: block;
            text-align: center;
            padding: 16px 0;
        }

        .header td {
            display: block;
            text-align: center;
            padding-top: 0;
            padding-bottom: 0;
        }

        .menu {
            margin-top: 6px;
        }

        .menu li {
            margin-left: calc(5px + (20 - 5) * ((100vw - 320px) / (1920 - 320)));
            margin-right: calc(5px + (20 - 5) * ((100vw - 320px) / (1920 - 320)));
        }
    }

    .menu {
        width: 100%;
    }

    .menu li {
        margin-left: calc(10px + (20 - 10) * ((100vw - 320px) / (1920 - 320)));
    }

    .menu li a {
        font-weight: bold;
        font-size: 12px;
        line-height: 19px;
        color: #252525;
        text-transform: capitalize;
    }

    u {
        text-decoration: none !important;
    }

    .button-solid {
        font-weight: bold;
        font-size: 15px;
        line-height: calc(22px + (27 - 22) * ((100vw - 320px) / (1920 - 320)));
        display: inline-block;
        color: #ffffff !important; 
        background: #ff4c3b;
        border-radius: 6px;
        padding: 7px 15px;
    }

    table {
            margin-top: 30px
        }

        table.top-0 {
            margin-top: 0;
        }

        table.order-detail,
        .order-detail th,
        .order-detail td {
            border: 1px solid #ddd;
            border-collapse: collapse;
        }

        .order-detail th {
            font-size: 16px;
            padding: 15px;
            text-align: center;
        }

    .banner {
        position: relative;
    }

    .banner img {
        margin-bottom: -6px;
    }

    .section-t {
        margin-top: calc(25px + (32 - 25) * ((100vw - 320px) / (1920 - 320)));
        display: block;
    }

    .heading-1 {
        font-weight: bold;
        font-size: 16px;
        line-height: calc(17px + (20 - 17) * ((100vw - 320px) / (1920 - 320)));
        color: #252525;
    }

    .pera {
        font-weight: 600;
        font-size: 12px;
        line-height: calc(21px + (23 - 21) * ((100vw - 320px) / (1920 - 320)));
        text-align: center;
        color: #939393;
        margin-bottom: -4px;
    }

    .pera a {
        font-weight: bold;
        color: #ff4c3b;
    }

    .footer {
        position: relative;
        width: 100%;
    }

    @media only screen and (max-width: 345px) {
        .footer-content {
            padding-left: 15px;
            padding-right: 15px;
        }

        .footer-content>table {
            width: 100% !important;
        }
    }

    .footer-content p,
    .footer-content a {
        font-weight: 800;
        font-size: calc(11px + (12 - 11) * ((100vw - 320px) / (1920 - 320)));
        line-height: 23px;
        text-align: center;
        letter-spacing: 0.5px;
    }

    .footer-content p {
        color: #e4e4e4;
        margin-top: 15px;
        text-transform: uppercase;
    }

    .footer-content .unsubscribe {
        text-decoration-line: underline;
        text-transform: uppercase;
        color: #ff4c3b;
        display: inline-block;
        margin-top: calc(15px + (21 - 15) * ((100vw - 320px) / (1920 - 320)));
    }

    .footer-content .social td {
        width: calc(18px + (20 - 18) * ((100vw - 320px) / (1920 - 320)));
        height: calc(18px + (20 - 18) * ((100vw - 320px) / (1920 - 320)));
        display: inline-block;
        margin: 0 calc(7px + (10 - 7) * ((100vw - 320px) / (1920 - 320)));
    }

    .footer-content td img {
        width: 100%;
    }

    p{
        margin-bottom: 10px
    }
</style>

<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #fff; width: 100%">
    <tbody>
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                        <tr class="header">
                            <td align="center" valign="top" style="background-color: #ffe4e1">
                                <img src="{{ URL::to('/') }}/images/emlaksepettelogo.png" class="main-logo">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>

        <tr>
            <td class="section-t"
                style="position: relative; padding: 0 calc(15px + (88 - 15) * ((100vw - 320px) / (1920 - 320)))">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td class="container-border"
                                style="padding-left: calc(0px + (88 - 0) * ((100vw - 320px) / (1920 - 320))); padding-right: calc(0px + (88 - 0) * ((100vw - 320px) / (1920 - 320)))">
                                <div class="pera font-sm" style="margin-bottom: -3px">
                                    {!! $content !!} </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="section-t"
                style="background-color: #212121; padding: calc(20px + (26 - 20) * ((100vw - 320px) / (1920 - 320))) 0">
                <table class="footer">
                    <tbody>
                        <tr>
                            <td class="footer-content">
                                <table border="0" cellpadding="0" cellspacing="0" class="footer-social-icon"
                                    align="center" style="vertical-align: middle; margin: 0 auto; width: 326px">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <p>2023 © Copyright - All Rights Reserved. @innovaticacode</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
