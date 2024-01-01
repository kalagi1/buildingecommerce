<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Emlak Sepette</title>
    <style>
        .ii a[href]{
            color: white !important;
        }
    </style>
</head>

<body>
    <!-- Önceki style etiketini kaldır -->
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #fff; width: 100%">
        <tbody>
            {{-- <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                        <tr>
                            <td align="center" valign="top" style="background-color: #ffe4e1">
                                <img src="{{ URL::to('/') }}/images/emlaksepettelogo.png" class="main-logo"
                                    style="width: 50%">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr> --}}

            <tr>
                <td style="position: relative; padding: 0 calc(15px + (88 - 15) * ((100vw - 320px) / (1920 - 320)))">
                    <table style="width: 100%">
                        <tbody>
                            <tr>
                                <td
                                    style="padding-left: calc(0px + (88 - 0) * ((100vw - 320px) / (1920 - 320))); padding-right: calc(0px + (88 - 0) * ((100vw - 320px) / (1920 - 320)))">
                                    <div
                                        style="margin-bottom: -3px; font-weight: 600; font-size: 12px; line-height: calc(21px + (23 - 21) * ((100vw - 320px) / (1920 - 320))); text-align: center; color: #939393;">
                                        {!! $content !!}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>


            <tr>
                <td colspan="2"
                    style="background-color: #212121; padding: calc(20px + (26 - 20) * ((100vw - 320px) / (1920 - 320))) 0">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0" align="center"
                                        style="vertical-align: middle; margin: 0 auto; width: 326px">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p
                                                        style="font-weight: 800; font-size: calc(11px + (12 - 11) * ((100vw - 320px) / (1920 - 320))); line-height: 23px; text-align: center; letter-spacing: 0.5px; color: #e4e4e4; margin-top: 15px; text-transform: uppercase;">
                                                        2023 © Copyright - All Rights Reserved. @innovaticacode
                                                    </p>
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

</body>

</html>
