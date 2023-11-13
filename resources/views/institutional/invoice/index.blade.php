@extends('institutional.layouts.master')

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
    <div class="content">
        <section class="pt-5 pb-9 bg-white dark__bg-1200 border-top border-300">
            <div class="container-small">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <h2 class="mb-0">Emlak Sepette Sipariş Faturası</h2>
                    <div><button class="btn btn-phoenix-secondary me-2"><svg class="svg-inline--fa fa-download me-sm-2"
                                aria-hidden="true" focusable="false" data-prefix="fas" data-icon="download" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                <path fill="currentColor"
                                    d="M480 352h-133.5l-45.25 45.25C289.2 409.3 273.1 416 256 416s-33.16-6.656-45.25-18.75L165.5 352H32c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h448c17.67 0 32-14.33 32-32v-96C512 366.3 497.7 352 480 352zM432 456c-13.2 0-24-10.8-24-24c0-13.2 10.8-24 24-24s24 10.8 24 24C456 445.2 445.2 456 432 456zM233.4 374.6C239.6 380.9 247.8 384 256 384s16.38-3.125 22.62-9.375l128-128c12.49-12.5 12.49-32.75 0-45.25c-12.5-12.5-32.76-12.5-45.25 0L288 274.8V32c0-17.67-14.33-32-32-32C238.3 0 224 14.33 224 32v242.8L150.6 201.4c-12.49-12.5-32.75-12.5-45.25 0c-12.49 12.5-12.49 32.75 0 45.25L233.4 374.6z">
                                </path>
                            </svg><!-- <span class="fa-solid fa-download me-sm-2"></span> Font Awesome fontawesome.com --><span
                                class="d-none d-sm-inline-block">İndir</span></button><button
                            class="btn btn-phoenix-secondary"><svg class="svg-inline--fa fa-print me-sm-2"
                                aria-hidden="true" focusable="false" data-prefix="fas" data-icon="print" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                <path fill="currentColor"
                                    d="M448 192H64C28.65 192 0 220.7 0 256v96c0 17.67 14.33 32 32 32h32v96c0 17.67 14.33 32 32 32h320c17.67 0 32-14.33 32-32v-96h32c17.67 0 32-14.33 32-32V256C512 220.7 483.3 192 448 192zM384 448H128v-96h256V448zM432 296c-13.25 0-24-10.75-24-24c0-13.27 10.75-24 24-24s24 10.73 24 24C456 285.3 445.3 296 432 296zM128 64h229.5L384 90.51V160h64V77.25c0-8.484-3.375-16.62-9.375-22.62l-45.25-45.25C387.4 3.375 379.2 0 370.8 0H96C78.34 0 64 14.33 64 32v128h64V64z">
                                </path>
                            </svg><!-- <span class="fa-solid fa-print me-sm-2"></span> Font Awesome fontawesome.com --><span
                                class="d-none d-sm-inline-block">Yazdır</span></button></div>
                </div>
                <div class="bg-soft dark__bg-1100 p-4 mb-4 rounded-2">
                    <div class="row g-4">
                        <div class="col-12 col-lg-3">
                            <div class="row g-4 g-lg-2">
                                <div class="col-12 col-sm-6 col-lg-12">
                                    <div class="row align-items-center g-0">
                                        <div class="col-auto col-lg-6 col-xl-5">
                                            <h6 class="mb-0 me-3">Fatura No :</h6>
                                        </div>
                                        <div class="col-auto col-lg-6 col-xl-7">
                                            <p class="fs--1 text-800 fw-semi-bold mb-0">
                                                {{ $data['invoice']['invoice_number'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-12">
                                    <div class="row align-items-center g-0">
                                        <div class="col-auto col-lg-6 col-xl-5">
                                            <h6 class="me-3">Fatura Tarihi :</h6>
                                        </div>
                                        <div class="col-auto col-lg-6 col-xl-7">
                                            <p class="fs--1 text-800 fw-semi-bold mb-0">{{ $data['invoice']['created_at'] }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $cart = json_decode($data['invoice']['order']['cart'], true);

                        @endphp

                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="row g-4">
                                <div class="col-12 col-lg-6">
                                    <h6 class="mb-2"> Alıcı Bilgileri :</h6>
                                    <div class="fs--1 text-800 fw-semi-bold mb-0">
                                        <p class="mb-2">{{ $data['invoice']['order']['user']['name'] }} </p>
                                        <p class="mb-2">{{ $data['invoice']['order']['user']['email'] }},</p>

                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <h6 class="mb-2 me-3">Satıcı :</h6>
                                    <p class="fs--1 text-800 fw-semi-bold mb-0">{{ $data['project']['user']['name'] }}</p>
                                    <p class="fs--1 text-800 fw-semi-bold mb-0">{{ $data['project']['user']['email'] }}</p>
                                    <h6 class="mb-2 mt-3">Vergi No:</h6>
                                    <p class="fs--1 text-800 fw-semi-bold mb-0">{{ $data['project']['user']['taxNumber'] }}
                                    </p>
                                    @if ($data['project']['user']['phone'])
                                        <h6 class="mb-2"> Telefon :</h6>
                                        <p class="fs--1 text-800 fw-semi-bold mb-0">$data['project']['user']['phone']</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-0">
                    <div class="table-responsive scrollbar">
                        <table class="table fs--1 text-900 mb-0">
                            <thead class="bg-200">
                                <tr>
                                    <th scope="col" style="width: 24px;"></th>
                                    <th scope="col">NO.</th>
                                    <th scope="col">Sipariş Görseli</th>
                                    <th scope="col">Sipariş</th>

                                    <th>Ara Tutar</th>
                                    <th scope="col">%1 Kapora Tutarı</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border-0"></td>
                                    <td class="align-middle">1</td>
                                    <td class="align-middle">
                                        <img src="{{ $cart['item']['image'] }}" alt="" style="width:200px">
                                    </td>
                                    <td class="align-middle ps-5">
                                        @if ($data['project']['project_title'])
                                            {{ mb_convert_case($data['project']['project_title'], MB_CASE_TITLE, 'UTF-8') }}{{ ' ' }}Projesinde
                                            {{ getHouse($data['project'], 'squaremeters[]', $cart['item']['housing'])->value }}m2
                                            {{ getHouse($data['project'], 'room_count[]', $cart['item']['housing'])->value }}
                                            {{ ' ' }}
                                            {{ $cart['item']['housing'] }} {{ "No'lu" }}
                                            {{ $data['project']['step1_slug'] }}
                                        @else
                                            {{ $data['project']['title'] }}
                                        @endif
                                    </td>
                                    <td class="align-middle text-700 fw-semi-bold">
                                        {{ number_format($data['invoice']['total_amount'], 2) }} ₺</td>
                                    <td class="align-middle text-end text-1000 fw-semi-bold">
                                        {{ $data['invoice']['order']['amount'] }} ₺</td>

                                    <td class="border-0"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end py-9 border-bottom border-300"><img class="mb-3"
                            src="{{ URL::to('/') }}/images/emlaksepettelogo.png" alt="" style="width:200px">
                        <h4>Ödeme Onaylandı</h4>
                    </div>
                </div>
            </div><!-- end of .container-->
        </section>

    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('print-button').addEventListener('click', function() {
            var printContent = document.documentElement.innerHTML; // Sayfanın tamamını al

            var printWindow = window.open('', '', 'width=800, height=600');
            printWindow.document.open();
            printWindow.document.write(printContent);
            printWindow.document.close();

            printWindow.print(); // Yazdır
            printWindow.close();
        });

        // Faturayı indirmek için
        document.getElementById('invoice_download_btn').addEventListener('click', function() {
            var downloadContent = document.getElementById('invoice_wrapper')
                .innerHTML;

            var blob = new Blob([downloadContent], {
                type: 'application/pdf'
            });
            var url = URL.createObjectURL(blob);

            var a = document.createElement('a');
            a.href = url;
            a.download = 'emlaksepettefatura.pdf';
            a.style.display = 'none';

            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        });
    </script>
@endsection


@section('styles')
    <style>
        .invoice-top .logo {
            float: right
        }
    </style>
@endsection
