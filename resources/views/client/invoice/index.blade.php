@php
    function getHouse($project, $key, $roomOrder)
    {
        foreach ($project->roomInfo as $room) {
            if ($room->room_order == $roomOrder && $room->name == $key) {
                return $room;
            }
        }
    }
    $cart = json_decode($data['invoice']['order']['cart'], true);

@endphp



<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['invoice']['invoice_number'] }}</title>
    <link type="text/css" rel="stylesheet" href="{{ URL::to('/') }}/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="{{ URL::to('/') }}/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/new.css">

    <style>
        .btn {
            height: 100% !important;
        }

        .invoice-top .logo {
            float: right
        }

        .table td {
            display: table-cell !important;
        }
    </style>

</head>

<body>
    <div class="invoice-2 invoice-content">
        <div class="container ">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-inner-2">
                        <div class="invoice-info" id="invoice_wrapper">
                            <div class="invoice-inner">
                                <div class="invoice-top">
                                    <div class="row align-items-center">
                                        <div class="col-sm-6 invoice-name">
                                            <h4 class="inv-header-2">{{ $data['invoice']['invoice_number'] }}</h4>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="title-logo text-end">
                                                <div class="logo">
                                                    <img src="{{ URL::to('/') }}/images/emlaksepettelogo.png"
                                                        alt="logo">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="invoice-center">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <address class="address-info">
                                                <p class="strong">Tarih</p>
                                                <p>{{ \Carbon\Carbon::parse($data['invoice']['created_at'])->isoFormat('LLLL') }}
                                                </p>
                                            </address>
                                        </div>
                                        <div class="col-sm-4">
                                            <address class="address-info">
                                                <p class="strong">Alıcı</p>
                                                <p class="invo-addr-1">
                                                    {{ $data['invoice']['order']['user']['name'] }} <br>
                                                    {{ $data['invoice']['order']['user']['email'] }}<br>
                                                </p>
                                            </address>
                                        </div>
                                        <div class="col-sm-4">
                                            <address class="address-info ai2 text-end">
                                                <p class="strong">Satıcı</p>
                                                <p class="invo-addr-1">
                                                    {{ $data['project']['user']['name'] }} <br>
                                                    {{ $data['project']['user']['email'] }} <br>
                                                    {{ $data['project']['user']['phone'] }} <br>
                                                </p>
                                            </address>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-summary">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Sipariş Detayı</h4>
                                            <div class="table-responsive">
                                                <table class="table invoice-table">
                                                    <thead class="bg-active">
                                                        <tr>
                                                            <th>İlan</th>
                                                            <th class="text-center">Toplam Fiyat</th>
                                                            <th class="text-right">Ödenen Kapora</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="item-desc-1">
                                                                    <strong style="font-size: 12px">
                                                                        İlan No:
                                                                        @if ($data['project']['project_title'])
                                                                            {{ $data['project']['id'] + 1000000 + $cart['item']['housing'] }}
                                                                        @else
                                                                            {{ $data['project']['id'] + 2000000 }}
                                                                        @endif
                                                                    </strong>
                                                                    <small>
                                                                        @if ($data['project']['project_title'])
                                                                            {{ mb_convert_case($data['project']['project_title'], MB_CASE_TITLE, 'UTF-8') }}{{ ' ' }}Projesinde

                                                                            {{ $cart['item']['housing'] }}
                                                                            {{ "No'lu" }}
                                                                            {{ $data['project']['step1_slug'] }}
                                                                        @else
                                                                            {{ $data['project']['title'] }}
                                                                        @endif
                                                                    </small>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                {{ number_format($data['invoice']['total_amount'], 2) }}
                                                                ₺
                                                            </td>
                                                            <td class="text-right">
                                                                {{ $data['invoice']['order']['amount'] }}
                                                                ₺</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="account-transfer">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="bank-transfer">
                                                <h3 class="inv-title-1">Banka Havalesi</h3>
                                                <ul class="bank-transfer-list-1">
                                                    <li><strong>Hesap:</strong>
                                                        {{ $data['invoice']['order']['bank']['receipent_full_name'] }}
                                                    </li>
                                                    <li><strong>Ödeme Şekli:</strong> EFT/HAVALE</li>
                                                    <li><strong>Web Adresi:</strong> <a
                                                            href="https://emlaksepette.com">https://emlaksepette.com</a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="total-amount text-end">
                                                <h3 class="inv-title-1">Toplam Tutar</h3>
                                                <h1>{{ $data['invoice']['order']['amount'] }} ₺</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-btn-section clearfix d-print-none">
                            <a href="javascript:window.print()" class="btn btn-lg btn-print">
                                <i class="fa fa-print"></i> Faturayı Yazdır
                            </a>
                            <a id="invoice_download_btn" class="btn btn-lg btn-download">
                                <i class="fa fa-download"></i> Faturayı İndir
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
