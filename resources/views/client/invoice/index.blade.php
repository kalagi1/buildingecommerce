@extends('client.layouts.master')

@section('content')
    @php
        function getHouse($project, $key, $roomOrder)
        {
            foreach ($project->roomInfo as $room) {
                if ($room->room_order == $roomOrder && $room->name == $key) {
                    return $room;
                }
            }
        }
    @endphp
    <div class="invoice-3 invoice-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-inner">
                        <div class="invoice-info" id="invoice_wrapper">
                            <div class="invoice-top">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="invoice">
                                            <h4 class="inv-header-1">Fatura<br> {{ $data['invoice']['invoice_number'] }}
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="invoice-name text-end">
                                            <div class="logo">
                                                <img class="logo" src="{{ URL::to('/') }}/images/emlaksepettelogo.png"
                                                    alt="logo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="informeshon">
                                            <p class="inv-title-1">Tarih</p>
                                            <p>Fatura Tarihi: {{ $data['invoice']['created_at'] }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="informeshon">
                                            <p class="inv-title-1">Alıcı Bilgileri</p>
                                            <p class="invo-addr-1">
                                                {{ $data['invoice']['order']['user']['name'] }} <br>
                                                {{ $data['invoice']['order']['user']['email'] }} <br>

                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="informeshon text-end">
                                            <p class="inv-title-1">Satıcı Bilgileri</p>
                                            <p class="invo-addr-1">
                                                {{ $data['project']['user']['name'] }} <br>
                                                {{ $data['project']['user']['email'] }} <br>
                                                Vergi No: {{ $data['project']['user']['taxNumber'] }} <br>
                                                Telefon: {{ $data['project']['user']['phone'] }} <br>


                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $cart = json_decode($data['invoice']['order']['cart'], true);

                            @endphp
                            <div class="invoice-center">
                                <div class="table-section table-responsive clearfix">
                                    <table class="table caption-top invoice-table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <img src={{ $cart['item']['image'] }} style="width:200px">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{ $data['project']['city']['title'] }} {{ ' / ' }}
                                                    {{ $data['project']['county']['ilce_title'] }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end">
                                                    {{ mb_convert_case($data['project']['project_title'], MB_CASE_TITLE, 'UTF-8') }}{{ ' ' }}Projesinde
                                                    {{ getHouse($data['project'], 'squaremeters[]', $cart['item']['housing'])->value }}m2
                                                    {{ getHouse($data['project'], 'room_count[]', $cart['item']['housing'])->value }}
                                                    {{ $data['project']['step1_slug'] }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end fw-bold">Ara Tutar</td>
                                                <td class="text-right fw-bold">
                                                    {{ number_format($data['invoice']['total_amount'], 2) }} ₺</td>
                                            </tr>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end fw-bold">%1 Kapora Tutarı</td>
                                                <td class="text-right fw-bold">{{ $data['invoice']['order']['amount'] }} ₺
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="invoice-bottom">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="bank-transfer">
                                            <h3 class="inv-title-1">Banka Havalesi</h3>
                                            <ul class="bank-transfer-list-1">
                                                <li><strong>Hesap:</strong>
                                                    {{ $data['invoice']['order']['bank']['receipent_full_name'] }}</li>
                                                <li><strong>Ödeme Şekli</strong> EFT/HAVALE</li>
                                                <li><strong>Web Adresi</strong> <a
                                                        href="https://emlaksepette.com/">https://emlaksepette.com/</a></li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="amount text-end">
                                            <h3 class="inv-title-1">Toplam Tutar</h3>
                                            <h1>{{ $data['invoice']['order']['amount'] }} ₺</h1>
                                            <p class="mb-0">KDV Dahil</p>
                                        </div>
                                    </div>
                                    {{-- </div>
                          <div class="note mt-3">
                              <p class="text-muted">{!! $data['project']['description'] !!}</p>
                          </div> --}}
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
    @endsection

    @section('scripts')
    @endsection

    @section('styles')
        <link rel="stylesheet" href="{{ URL::to('/') }}/css/new.css">
        <style>
            .invoice-top .logo {
                float: right
            }
        </style>
    @endsection
