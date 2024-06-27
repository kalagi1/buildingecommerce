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
                    <h3 class="mb-0">Siparişler</h2>
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

                <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white border-top border-bottom border-200 position-relative top-1">
                    <div class="table-responsive scrollbar mx-n1 px-1">
                        <table class="table table-sm fs--1 mb-0">
                            <thead>
                                <tr>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="no">
                                        NO
                                    </th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_date">
                                        Sipariş Tarihi</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_no">
                                        İlan Numarası
                                    </th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="customer">Müşteri Bilgileri</th>

                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_project">
                                        İlan Adı</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_amount">
                                        Kapora Tutarı</th>

                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="pay_type">Ödeme Türü</th>

                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_status">
                                        Durum</th>
                                    
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_detail">
                                        Sipariş Detayı</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="order-table-body">
                               
                                @foreach ($cartOrders as $order)
                                    @php
                                        $o = json_decode($order->cart);
                                        $project =
                                            $o->type == 'project'
                                                ? App\Models\Project::with('roomInfo')
                                                    ->where('id', $o->item->id)
                                                    ->first()
                                                : null;
                                        $tarih = date('d F Y H:i:s', strtotime($order->created_at));
                                        $tarih = str_replace(
                                            [
                                                'January',
                                                'February',
                                                'March',
                                                'April',
                                                'May',
                                                'June',
                                                'July',
                                                'August',
                                                'September',
                                                'October',
                                                'November',
                                                'December',
                                            ],
                                            [
                                                'Ocak',
                                                'Şubat',
                                                'Mart',
                                                'Nisan',
                                                'Mayıs',
                                                'Haziran',
                                                'Temmuz',
                                                'Ağustos',
                                                'Eylül',
                                                'Ekim',
                                                'Kasım',
                                                'Aralık',
                                            ],
                                            $tarih,
                                        );
                                    @endphp
                                    <tr @if($order->refund && $order->refund->status == 1) class="table-danger" @endif>
                                        <td class="no"><span>{{ $order->id }}</span></td>

                                        <td class="order_date">{{ $tarih }}</td>
                                        @php
                                            $orderCart = json_decode($order->cart, true);
                                        @endphp
                                        <td class="order_no"><a  target="_blank"
                                        href="{{ $orderCart['type'] == 'housing'
                                            ? route('housing.show', [
                                                'housingSlug' => $orderCart['item']['slug'],
                                                'housingID' => $orderCart['item']['id'] + 2000000,
                                            ])
                                            : route('project.housings.detail', [
                                                'projectSlug' =>
                                                    optional(App\Models\Project::find($orderCart['item']['id']))->slug .
                                                    '-' .
                                                    optional(App\Models\Project::find($orderCart['item']['id']))->step2_slug .
                                                    '-' .
                                                    optional(App\Models\Project::find($orderCart['item']['id']))->housingtype->slug,
                                                'projectID' => optional(App\Models\Project::find($orderCart['item']['id']))->id + 1000000,
                                                'housingOrder' => $orderCart['item']['housing'],
                                            ]) }}">
                                        {{ $order->key }}
                                        </a>
                                        </td>

                                        @php
                                        if ($order->user->profile_image) {
                                            $profileImage = url('storage/profile_images/' . $order->user->profile_image);
                                        } else {
                                            $initial = $order->user->name ? strtoupper(substr($order->user->name, 0, 1)) : '';
                                            $profileImage = $initial;
                                        }
                                        @endphp

                                        <td class="customer align-middle white-space-nowrap "><a class="d-flex align-items-center text-body" href="../../../apps/e-commerce/landing/profile.html">
                                            <div class="avatar avatar-m"><img class="rounded-circle" src="{{ $profileImage }}" alt=""></div>
                                            <p class="mb-0 ms-3 text-body text-wrap">{{$order->user->name}}</p>
                                        </a></td>

                                        
                                        <td class="order_project">
                                            <span>
                                                @if ($o->type == 'housing')
                                                {{ App\Models\Housing::find($o->item->id ?? 0)->title ?? null }}
                                            @else
                                                {{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}
                                                {{ ' ' }}Projesinde
                                                {{ ' ' }}{{ json_decode($order->cart)->type == 'project' ? json_decode($order->cart)->item->housing : null }}.
                                                {{ $project->step1_slug }}
                                            @endif
                                            @if (isset(json_decode($order->cart)->item->isShare) && !empty(json_decode($order->cart)->item->isShare))
                                                <br>
                                                <span style="color:#EA2B2E"
                                                    class="mt-3">{{ json_decode($order->cart)->item->qt }} adet hisse
                                                    satın alındı
                                                    !</span>
                                            @endif
                                            </span>
                                            <br>
        
                                        </td>
                                        <td class="order_amount">{{ number_format(floatval(str_replace('.', '', $order->amount)), 0, ',', '.') }}
                                            ₺</td>
                                       
                                            <td class="order_amount align-middle  fw-semibold text-body-highlight">{{ $order->is_swap == 0 ? 'Peşin' : 'Taksitli' }} <br>

                                            </td>
                                            
                                            @if($order->refund != null)

                                            <td class="order_status"><span class="text-success">

                                                    
                                                {!! [
                                                    '0' => '<span class="badge badge-phoenix fs-10 badge-phoenix-warning"><span class="badge-label">İade Talebi Oluşturuldu</span><span class="ms-1" data-feather="alert-octagon" style="height:12.8px;width:12.8px;"></span></span>',
                                                    '1' => '<span class="badge badge-phoenix fs-10 badge-phoenix-info"><span class="badge-label">İade Talebi Onaylandı</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>',                                                                                                                                                                                                                  
                                                    '2' => '<span class="badge badge-phoenix fs-10 badge-phoenix-danger"><span class="badge-label">İade Talebi Reddedildi</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span>',                                                                                             
                                                    '3' => '<span class="badge badge-phoenix fs-10 badge-phoenix-success"><span class="badge-label">Geri Ödeme Yapıldı</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>',
                                                ][$order->refund->status] !!}
                                            </span>
                                            {{-- @if ($order->invoice && $order->status == 1)
                                                <span class="badge badge-phoenix fs-10 badge-phoenix-success">
                                                    <a href="{{ route('institutional.invoice.show', $order->id) }}">
                                                        Faturayı Görüntüle
                                                    </a>

                                                </span>
                                            @endif --}}

                                        @else
                                            <td class="order_status"><span class="text-success">

                                                
                                                {!! [
                                                    '0' => '<span class="badge badge-phoenix fs-10 badge-phoenix-warning"><span class="badge-label">Onay Bekleniyor</span><span class="ms-1" data-feather="alert-octagon" style="height:12.8px;width:12.8px;"></span></span>',
                                                    '1' => '<span class="badge badge-phoenix fs-10 badge-phoenix-success"><span class="badge-label">Ödeme Onaylandı</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>',
                                                    '2' => '<span class="badge badge-phoenix fs-10 badge-phoenix-danger"><span class="badge-label">Ödeme Reddedildi</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span>',
                                                ][$order->status] !!}
                                            </span>
                                            @if ($order->invoice && $order->status == 1)
                                                <span class="badge badge-phoenix fs-10 badge-phoenix-success">
                                                    <a href="{{ route('institutional.invoice.show', $order->id) }}">
                                                        Faturayı Görüntüle
                                                    </a>

                                                </span>
                                            @endif

                                            </td>
                                        @endif


                                        <td class="order_detail">
                                            <span>
                                                <a href="{{ route('institutional.order.detail', ['order_id' => $order->id]) }}"
                                                    class="badge badge-phoenix fs--2 badge-phoenix-success">Sipariş
                                                    Detayı</a>
                                            </span>
                                        </td>
        
                                    </tr>
        
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

              {{-- <div
                    class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white border-top border-bottom border-200 position-relative top-1">
                    <div class="table-responsive scrollbar mx-n1 px-1">
                        <table class="table table-sm fs--1 mb-0">
                            <thead>
                                <tr>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_no">Kod</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_image">Görsel</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_project">Proje</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_amount">Tutar</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_date">Sipariş Tarihi</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_status">Durum</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_user">Alıcı</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_seller">Satıcı</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="order-table-body">

                                @if ($cartOrders->count() > 0)
                                    @foreach ($cartOrders as $order)
                                        @php($o = json_decode($order->cart))
                                        @php($project = $o->type == 'project' ? App\Models\Project::with('user')->find($o->item->id) : null)
                                        @php($housing = $o->type == 'housing' ? App\Models\Housing::with('user')->find($o->item->id) : null)

                                        <tr>
                                            <td class="order_no">{{ $order->key }} <br>
                                                @if ($order->invoice)
                                                    <a href="{{ route('institutional.invoice.show', $order->id) }}">
                                                        <button class="invoiceBtn">
                                                            <span class="button_lg">
                                                                <span class="button_sl"></span>
                                                                <span class="button_text">Faturayı Görüntüle</span>
                                                            </span>
                                                        </button>
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="order_image">
                                                @if ($o->type == 'housing')
                                                    <img src="{{ asset('housing_images/' . json_decode(App\Models\Housing::find(json_decode($order->cart)->item->id ?? 0)->housing_type_data ?? '[]')->image ?? null) }}"
                                                        width="100px" height="75px" style="object-fit: contain;" />
                                                @else
                                                    <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', json_decode($order->cart)->item->housing)->value }}"
                                                        style="object-fit: cover;width:100px;height:75px" alt="Görsel">
                                                @endif
                                            </td>
                                            <td class="order_project">
                                                @if ($o->type == 'project')
                                                    <span>{{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}{{ ' ' }}Projesinde

                                                        {{ ' ' }}
                                                        {{ json_decode($order->cart)->item->housing }} {{ "No'lu" }}
                                                        {{ $project->step1_slug }}
                                                    </span>
                                                @else
                                                    {{ App\Models\Housing::find(json_decode($order->cart)->item->id ?? 0)->title ?? null }}
                                                @endif <br>
                                                @if (isset($order->reference))
                                                    <span style="font-weight:700 !important">Prim Kazanan Üye: {{$order->reference->name}}</span>
                                                @endif
                                                
                                            </td>
                                            <td class="order_amount">{{ $order->amount }}</td>
                                            <td class="order_date">{{ $order->created_at }}</td>
                                            <td class="order_status">{!! [
                                                '0' => '<span class="text-warning">Rezerve Edildi</span>',
                                                '1' => '<span class="text-success">Ödeme Onaylandı</span>',
                                                '2' => '<span class="text-danger">Ödeme Reddedildi</span>',
                                            ][$order->status] !!}</td>
                                            <td class="order_user">{{ $order->user->email }}</td>
                                            <td class="order_seller">{{ $project->user->email ?? $housing->user->email }}
                                            </td>

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
            </div> --}}
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
