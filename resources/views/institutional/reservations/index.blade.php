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
        <div class="mb-9">
            <div class="row g-3 mb-4">
                <div class="col-auto">
                    <h2 class="mb-0">Rezervasyonlar</h2>
                </div>
            </div>
            <div id="orderTable"
                data-list='{"valueNames":["order_no","order_image","order_project","order_amount","order_date","order_status","order_user","order_seller","order_details"],"page":10,"pagination":true}'>
                <div class="mb-4">
                    <div class="row g-3">
                        <div class="col-auto">
                            <div class="search-box">
                                <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input
                                        class="form-control search-input search" type="search" placeholder="Ara"
                                        aria-label="Search" />
                                    <span class="fas fa-search search-box-icon"></span>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white border-top border-bottom border-200 position-relative top-1">
                    <div class="table-responsive scrollbar mx-n1 px-1">
                        <table class="table table-sm fs--1 mb-0">
                            <thead>
                                <tr>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_no">Kod</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_image">Konut</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_amount">Tutar</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_amount">Giriş Tarihi</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_amount">Çıkış Tarihi</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_amount">Toplam Gün Sayısı</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_amount">Kişi Sayısı</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_status">Durum</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_user">Alıcı</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="order-table-body">

                                @if ($housingReservations->count() > 0)
                                    @foreach ($housingReservations as $order)
                                        @php($housing = App\Models\Housing::with('user')->find($order->housing_id))

                                        <tr>
                                            <td class="order_no">
                                                {{ $order->created_at }} <br>
                                                {{ App\Models\Housing::find($order->housing_id ?? 0)->title }} <br>
                                                {{ $order->key }} </td>
                                            <td class="order_image">
                                                <img src="{{ asset('housing_images/' . json_decode(App\Models\Housing::find($order->housing_id ?? 0)->housing_type_data ?? '[]')->image ?? null) }}"
                                                    width="100px" style="object-fit: contain;" />

                                            </td>
                                            <td class="order_amount">
                                                {{ number_format($order->total_price, 0, ',', '.') }} ₺
                                            </td>
                                            <td class="order_date">
                                                {{ \Carbon\Carbon::parse($order->check_in_date)->format('d.m.Y') }}</td>
                                            <td class="order_date">
                                                {{ \Carbon\Carbon::parse($order->check_out_date)->format('d.m.Y') }}</td>
                                            <td class="order_date">
                                                <span style="color:#EA2B2E; font-weight:600;font-size:16px"><i class="fas fa-calendar"></i>
                                                    {{ \Carbon\Carbon::parse($order->check_in_date)->diffInDays(\Carbon\Carbon::parse($order->check_out_date)) }}
                                                    gün</span>
                                            </td>

                                            <td class="order_date">{{ $order->person_count }}</td>

                                            <td class="order_status">{!! [
                                                '0' => '<span class="text-warning">Rezerve Edildi</span>',
                                                '1' => '<span class="text-success">Rezervasyon Onaylandı</span>',
                                                '2' => '<span class="text-danger">Ödeme Reddedildi</span>',
                                            ][$order->status] !!}</td>
                                            <td class="order_user">
                                                {{ $order->user->name }} <br>
                                                {{ $order->user->email }}</td>

                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center">Sipariş Bulunamadı</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        let table = new DataTable('#table', {
            language: {
                url: '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json',
            },
        });
        $('#filterButton').click(function() {
            $('#filterModal').modal('show');
        });

        $(document).ready(function() {
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                console.log(formData);

                $.ajax({
                    type: 'GET',
                    url: "{{ route('admin.users.index') }}", // Filtreleme işlemi yapıldıktan sonra sonuçların nasıl getirileceği URL
                    data: formData,
                    success: function(data) {
                        // Filtrelenmiş verileri tabloya ekleme işlemi
                        $('.table-responsive').html(data);
                        console.log(data);

                        // DataTable yeniden yükleme (verileri güncellemek için)
                        table.ajax.reload();

                        $('#filterModal').modal('hide');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endsection

@section('css')
    <style>
        .order_status span {
            font-weight: 800
        }

        #table_filter {
            margin-bottom: 20px;
        }

        .invoiceBtn {
            width: 150px !important;
            -moz-appearance: none;
            -webkit-appearance: none;
            appearance: none;
            border: none;
            background: none;
            color: #0f1923;
            cursor: pointer;
            position: relative;
            padding: 8px;
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 11px;
            transition: all .15s ease;
        }

        .invoiceBtn::before,
        .invoiceBtn::after {
            content: '';
            display: block;
            position: absolute;
            right: 0;
            left: 0;
            height: calc(50% - 5px);
            border: 1px solid #7D8082;
            transition: all .15s ease;
        }

        .invoiceBtn::before {
            top: 0;
            border-bottom-width: 0;
        }

        .invoiceBtn::after {
            bottom: 0;
            border-top-width: 0;
        }

        .invoiceBtn:active,
        .invoiceBtn:focus {
            outline: none;
        }

        .invoiceBtn:active::before,
        .invoiceBtn:active::after {
            right: 3px;
            left: 3px;
        }

        .invoiceBtn:active::before {
            top: 3px;
        }

        .invoiceBtn:active::after {
            bottom: 3px;
        }

        .invoiceBtn_lg {
            position: relative;
            display: block;
            padding: 10px 20px;
            color: #fff;
            background-color: #0f1923;
            overflow: hidden;
            box-shadow: inset 0px 0px 0px 1px transparent;
        }

        .invoiceBtn_lg::before {
            content: '';
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: 2px;
            height: 2px;
            background-color: #0f1923;
        }

        .invoiceBtn_lg::after {
            content: '';
            display: block;
            position: absolute;
            right: 0;
            bottom: 0;
            width: 4px;
            height: 4px;
            background-color: #0f1923;
            transition: all .2s ease;
        }

        .invoiceBtn_sl {
            display: block;
            position: absolute;
            top: 0;
            bottom: -1px;
            left: -8px;
            width: 0;
            background-image: linear-gradient(to bottom right, #00c6ff,
                    #0072ff);
            transform: skew(-15deg);
            transition: all .2s ease;
        }

        .invoiceBtn_text {
            position: relative;
        }

        .invoiceBtn:hover {
            color: #0f1923;
        }

        .invoiceBtn:hover .invoiceBtn_sl {
            width: calc(100% + 15px);
        }

        .invoiceBtn:hover .invoiceBtn_lg::after {
            background-color: #fff;
        }
    </style>
@endsection
