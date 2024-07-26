<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Laralink">
    <title>{{ $data['invoice']['invoice_number'] }}</title>
    <link rel="stylesheet" href="{{ asset('invoice.css') }}">
</head>
@php
    $cart = json_decode($data['invoice']['order']['cart'], true);

    function getHouse($project, $key, $roomOrder)
    {
        foreach ($project->roomInfo as $room) {
            if ($room->room_order == $roomOrder && $room->name == $key) {
                return $room;
            }
        }
    }
@endphp


<body>
    <div class="tm_container">
        <div class="tm_invoice_wrap">
            <div class="tm_invoice tm_style3" id="tm_download_section">
                <div class="tm_invoice_in">
                    <div class="tm_invoice_head tm_align_center tm_accent_bg">
                        <div class="tm_invoice_left">
                            <div class="tm_logo"><img src="{{ URL::to('/') }}/images/emlaksepettelogo.png"
                                    alt="Logo" style="width:200px"></div>
                        </div>
                        <div class="tm_invoice_right">
                            <div class="tm_head_address tm_white_color">
                                Cevizli, Çanakkale Cd. No:103A, 34865 <br> Kartal/İstanbul<br>
                                Müşteri Hizmetleri: 444 3 284 <br>
                                Email: info@emlaksepette.com
                            </div>
                        </div>
                        <div class="tm_primary_color tm_text_uppercase tm_watermark_title tm_white_color">Fatura</div>
                    </div>
                    <div class="tm_invoice_info">
                        <div class="tm_invoice_info_left tm_gray_bg">
                            <p class="tm_mb2"><b class="tm_primary_color">Alıcı Bilgisi:</b></p>
                            <p class="tm_mb0">
                                <?php echo isset($data['invoice']['order']['user']['name']) ? $data['invoice']['order']['user']['name'] : ''; ?> <br>
                                <?php echo isset($data['invoice']['order']['user']['email']) ? $data['invoice']['order']['user']['email'] : ''; ?> <br>
                                @if (isset($data['invoice']['order']['user']['type']) &&
                                        $data['invoice']['order']['user']['type'] != '1' &&
                                        $data['invoice']['order']['user']['type'] != '3')
                                    İş: <?php echo isset($data['invoice']['order']['user']['phone']) ? $data['invoice']['order']['user']['phone'] : ''; ?> <br>
                                @else
                                    Cep: <?php echo isset($data['invoice']['order']['user']['mobile_phone']) ? $data['invoice']['order']['user']['mobile_phone'] : ''; ?>
                                @endif
                            </p>
                        </div>
                        <div class="tm_invoice_info_right tm_text_right">
                            <p class="tm_invoice_number tm_m0">Fatura No: <b
                                    class="tm_primary_color">{{ $data['invoice']['invoice_number'] }}</b></p>
                            <p class="tm_invoice_date tm_m0">Tarih: <b
                                    class="tm_primary_color">{{ $data['invoice']['created_at'] }}</b></p>
                        </div>
                    </div>
                    <div class="tm_invoice_details">
                        <div class="tm_table tm_style1 tm_mb30">
                            <div class="tm_border">
                                <div class="tm_table_responsive">
                                    <table class="tm_gray_bg">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="tm_width_2 tm_semi_bold tm_white_color tm_accent_bg tm_border_left">
                                                    Kapak Görseli</th>
                                                <th class="tm_width_5 tm_semi_bold tm_white_color tm_accent_bg"
                                                    style="width:100px">
                                                    İlan Başlığı</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="tm_width_2"> <img src="{{ $cart['item']['image'] }}"
                                                        alt=""
                                                        style="width:100px;height:100px;object-fit:cover"></td>
                                                <td class="tm_width_5  tm_border_left" style="width: 100px">

                                                    <?php
                                                    if (isset($data['project']) && $data['project'] instanceof \App\Models\Housing) {
                                                        echo $data['project']['title'] . '<br><span style="font-size: 11px;font-weight:700;color:black">' . $data['project']['city']['title'] . '/' . $data['project']['county']['title'] . '</span>';
                                                    } else {
                                                        if (count($cart['item']['isShare']) > 0) {
                                                            echo mb_convert_case($data['project']['project_title'], MB_CASE_TITLE, 'UTF-8') . ' ' . 'Projesinde ' . $cart['item']['housing'] . " No'lu " . $data['project']['step1_slug'] . ' -' . '   Hisse Sayısı ' . $cart['item']['qt'] . '<br><span style="font-size: 11px;font-weight:700;color:black">' . $data['project']['city']['title'] . '/' . $data['project']['county']['ilce_title'] . '</span>';
                                                        } else {
                                                            echo mb_convert_case($data['project']['project_title'], MB_CASE_TITLE, 'UTF-8') . ' ' . 'Projesinde ' . $cart['item']['housing'] . " No'lu " . $data['project']['step1_slug'] . '<br><span style="font-size: 11px;font-weight:700;color:black">' . $data['project']['city']['title'] . '/' . $data['project']['county']['ilce_title'] . '</span>';
                                                        }
                                                    }
                                                    ?>
                                                </td>


                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tm_invoice_footer">
                                <div class="tm_left_footer">
                                    <p class="tm_mb2"><b class="tm_primary_color">Ödeme Bilgileri:</b></p>
                                    <p class="tm_m0">{{ $data['invoice']['order']['bank']['receipent_full_name'] }} -
                                        {{ $data['invoice']['order']['bank']['iban'] }} <br>Kapora:
                                        {{ $data['invoice']['order']['amount'] }} ₺</p>
                                </div>
                                <div class="tm_right_footer">
                                    <table class="tm_gray_bg">
                                        <tbody>

                                            <tr>
                                                <td class="tm_width_3 tm_primary_color tm_bold">Toplam Fiyat</td>
                                                <td class="tm_width_3 tm_primary_color tm_bold tm_text_right">
                                                    {{ number_format($data['invoice']['total_amount'], 2) }} ₺</td>
                                            </tr>
                                            <tr class="tm_border_top tm_border_bottom tm_accent_bg">
                                                <td class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_white_color">
                                                    Kapora
                                                </td>
                                                <td
                                                    class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_white_color tm_text_right">
                                                    {{ $data['invoice']['order']['amount'] }} ₺</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tm_padd_15_20 tm_gray_bg">
                            <p class="tm_mb5"><b class="tm_primary_color">Satıcı Bilgileri:</b></p>
                            <ul class="tm_m0 tm_note_list">
                                <li>{{ $data['project']['user']['name'] }}</li>
                                <li>{{ $data['project']['user']['email'] }}</li>
                                <li>Vergi No: {{ $data['project']['user']['taxNumber'] }}</li>
                                <li>İletişim No: {{ $data['project']['user']['phone'] }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tm_invoice_btns tm_hide_print">
                <a href="javascript:window.print()" id="tm_download_btn" class="tm_invoice_btn tm_color2">
                    <span class="tm_btn_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                            <path
                                d="M320 336h76c55 0 100-21.21 100-75.6s-53-73.47-96-75.6C391.11 99.74 329 48 256 48c-69 0-113.44 45.79-128 91.2-60 5.7-112 35.88-112 98.4S70 336 136 336h56M192 400.1l64 63.9 64-63.9M256 224v224.03"
                                fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="32" />
                        </svg>
                    </span>
                    <span class="tm_btn_text">Download</span>
                </a>
                {{-- <button id="tm_download_btn" class="tm_invoice_btn tm_color2">
                    <span class="tm_btn_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                            <path
                                d="M320 336h76c55 0 100-21.21 100-75.6s-53-73.47-96-75.6C391.11 99.74 329 48 256 48c-69 0-113.44 45.79-128 91.2-60 5.7-112 35.88-112 98.4S70 336 136 336h56M192 400.1l64 63.9 64-63.9M256 224v224.03"
                                fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="32" />
                        </svg>
                    </span>
                    
                    <span class="tm_btn_text">Download</span>
                </button> --}}

            </div>

        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jspdf.min.js"></script>
    <script src="assets/js/html2canvas.min.js"></script>
    <script src="assets/js/main.js"></script>


    </script>
</body>

</html>
