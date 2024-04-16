@extends('admin.layouts.master')

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
                    <h2 class="mb-0">Siparişler</h2>
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
                                        data-sort="order_no"> No</th>
                                    <th class="sort white-space-nowrap align-middle pe-3 text-center" scope="col"
                                        data-sort="order_date">Sipariş Tarihi</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="ad_no">
                                        İlan Numarası</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="customer">Müşteri Bilgileri</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="sales_person">Satıcı Bilgileri</th>
                                    {{-- <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_project">
                                        İlan Adı</th> --}}
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_amount">Kapora Tutarı</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="pay_type">Ödeme Türü</th>

                                        <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="pay_type">Ödeme Yöntemi</th>    

                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_status">
                                        Durum</th>
                                    {{-- <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_status">Durum</th> --}}
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_details">Sipariş Detayı</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="order-table-body">

                                @if ($cartOrders->count() > 0)
                                    @foreach ($cartOrders as $order)
                                        @php
                                            $orderCart = json_decode($order->cart, true);
                                        @endphp
                                        @php
                                            if ($order->user->profile_image) {
                                                $profileImage = url(
                                                    'storage/profile_images/' . $order->user->profile_image,
                                                );
                                            } else {
                                                $initial = $order->user->name
                                                    ? strtoupper(substr($order->user->name, 0, 1))
                                                    : '';
                                                $profileImage = $initial;
                                            }
                                        @endphp

                                        @php
                                            if ($order->store->profile_image) {
                                                $storeImage = url(
                                                    'storage/profile_images/' . $order->store->profile_image,
                                                );
                                            } else {
                                                $initial = $order->store->name
                                                    ? strtoupper(substr($order->store->name, 0, 1))
                                                    : '';
                                                $storeImage = $initial;
                                            }
                                        @endphp


                                        @php($o = json_decode($order->cart))
                                        @php($project = $o->type == 'project' ? App\Models\Project::with('user')->find($o->item->id) : null)
                                        @php($housing = $o->type == 'housing' ? App\Models\Housing::with('user')->find($o->item->id) : null)
                                        <tr  @if($order->refund && $order->refund->status == 1) class="table-danger" @endif>

                                            <td class="order_no align-middle  fw-semibold text-body-highlight">
                                                {{ $order->id }}
                                            </td>

                                            <td
                                                class="order_date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4   text-wrap">
                                                {{ $order->created_at }}</td>


                                            <td class="ad_no align-middle  fw-semibold text-body-highlight">
                                                <a target="_blank"
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

                                            <td class="customer align-middle white-space-nowrap">
                                                <a class="d-flex align-items-center text-body">
                                                    <div class="avatar avatar-m">
                                                        <img class="rounded-circle" src="{{ $profileImage }}"
                                                            alt="">
                                                    </div>
                                                    <p class="mb-0 ms-3 text-body text-wrap">{{ $order->user->name }}</p>
                                                </a>
                                            </td>

                                            <td class="customer align-middle white-space-nowrap">
                                                <a target="_href"
                                                    href="{{ route('institutional.dashboard', ['slug' => $order->store->name, 'userID' => $order->store->id]) }}"
                                                    class="d-flex align-items-center text-body">
                                                    <div class="avatar avatar-m">
                                                        <img class="rounded-circle" src="{{ $storeImage }}"
                                                            alt="">
                                                    </div>
                                                    <p class="mb-0 ms-3 text-body text-wrap">{{ $order->store->name }}</p>
                                                </a>
                                            </td>

                                                {{-- 
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
                                                            class="mt-3">{{ json_decode($order->cart)->item->qt }} adet
                                                            hisse
                                                            satın alındı
                                                            !</span>
                                                    @endif
                                                </span>
                                                <br>

                                            </td> --}}
                                            <td class="order_amount align-middle fw-semibold text-body-highlight">
                                                {{ $order->amount }} <br>

                                            </td>
                                            <td class="order_amount align-middle  fw-semibold text-body-highlight">
                                                {{ $order->is_swap == 0 ? 'Peşin' : 'Taksitli' }} <br>

                                            </td>

                                            <td class="order_amount align-middle fw-semibold text-body-highlight">
                                                @if(isset($order->payment_result))
                                                    <!-- Payment result varsa -->
                                                    Kredi Kartı ile<br>
                                                @else
                                                    <span>EFT / Havale</span> <br>
                                                    <!-- Payment result yoksa -->
                                                    <a href="{{ route('dekont.indir', ['order_id' => $order->id]) }}">Dekontu indir</a><br>
                                                @endif
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
                                                </td>
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
                                                        <a href="{{ route('admin.invoice.show', $order->id) }}">
                                                            Faturayı Görüntüle
                                                        </a>

                                                    </span>
                                                @endif

                                                </td>
                                            @endif

                                            

                                           
                                            <td class="order_user align-middle fw-semibold text-body-highlight">
                                                <a href="{{ route('admin.order.detail', ['order_id' => $order->id]) }}"
                                                    class="badge badge-phoenix fs--2 badge-phoenix-success">Sipariş
                                                    Detayı</a>
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

    <script>
        // Hücreyi seçin
        var statusCell = document.querySelector('.status-cell');

        console.log(statusCell);
        // Koşulu kontrol edin ve arka plan rengini belirleyin
        if (statusCell.innerText.trim() === '1') {
            statusCell.style.backgroundColor = 'red';
        }

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
    </style>
@endsection
