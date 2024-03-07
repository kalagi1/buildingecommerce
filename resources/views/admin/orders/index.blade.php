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
                                        data-sort="order_no">Kod</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_image">Görsel</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_project">Proje</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_amount">Tutar</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_amount">Ödeme Türü</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_date">Sipariş Tarihi</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_status">Durum</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_user">Sipariş Detayı</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_details">Onay</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="order-table-body">

                                @if ($cartOrders->count() > 0)
                                    @foreach ($cartOrders as $order)
                                        @php($o = json_decode($order->cart))
                                        @php($project = $o->type == 'project' ? App\Models\Project::with('user')->find($o->item->id) : null)
                                        @php($housing = $o->type == 'housing' ? App\Models\Housing::with('user')->find($o->item->id) : null)
                                        <tr>
                                            <td class="order_no">{{ $order->id }}</td>
                                            <td class="order_image">
                                                @if ($o->type == 'housing')
                                                    <img src="{{ asset('housing_images/' . json_decode(App\Models\Housing::find(json_decode($order->cart)->item->id ?? 0)->housing_type_data ?? '[]')->image ?? null) }}"
                                                        width="100px" height="120px" style="object-fit: contain;" />
                                                @else
                                                    <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', json_decode($order->cart)->item->housing)->value }}"
                                                        style="object-fit: cover;width:100px;height:75px" alt="Görsel">
                                                @endif
                                            </td>
                                            <td class="order_project" style="width:350px">
                                                @if ($o->type == 'project')
                                                    <span>{{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}{{ ' ' }}Projesinde
                                                        {{ json_decode($order->cart)->item->housing }} {{ "No'lu" }}
                                                        {{ $project->step1_slug }}
                                                    </span>
                                                @else
                                                    {{ App\Models\Housing::find(json_decode($order->cart)->item->id ?? 0)->title ?? null }}
                                                @endif
                                                @if (isset($order->is_reference))
                                                    <br>
                                                    <strong class="text-success">Bu ilan komşumu gör referansı ile
                                                        satılmıştır. <br>
                                                        Referans: {{ $order->isReference->name }} -
                                                        {{ $order->isReference->phone }}</strong>
                                                @endif
                                                @if (isset(json_decode($order->cart)->item->isShare) && !empty(json_decode($order->cart)->item->isShare))
                                                    <br>
                                                    <span style="color:#EA2B2E"
                                                        class="mt-3">{{ json_decode($order->cart)->item->qt }} adet hisse
                                                        satın alındı
                                                        !</span>
                                                @endif
                                            </td>
                                            <td class="order_amount">{{ $order->amount }} <br>

                                            </td>
                                            <td class="order_amount">{{ $order->is_swap == 0 ? 'Peşin' : 'Taksitli' }} <br>

                                            </td>
                                            <td class="order_date">{{ $order->created_at }}</td>
                                            <td class="order_status">{!! [
                                                '0' => '<span class="text-warning">Rezerve Edildi</span>',
                                                '1' => '<span class="text-success">Satış Onaylandı</span>',
                                                '2' => '<span class="text-danger">Satış Reddedildi</span>',
                                            ][$order->status] !!} <br>
                                                @if (isset($order->share))
                                                    <span class="text-warning">Bu ilan emlak kulüp aracılığı ile
                                                        satılmıştır.
                                                        @if ($order->share->status == 1)
                                                            <br>
                                                            Hakedişler Onaylandı.
                                                        @endif
                                                    </span>
                                                @endif
                                                @if (isset($order->price) && $order->price->status == 1)
                                                    <span class="text-success">Hakedişler Onaylandı.</span>
                                                @endif

                                                @if (isset($order->price) && $order->price->status == 0)
                                                    <span class="text-warning">Hakediş onayı bekleniyor.</span>
                                                @endif

                                                @if (isset($order->price) && $order->price->status == 2)
                                                    <span class="text-danger">Hakediş reddedildi.</span>
                                                @endif
                                            </td>
                                            <td class="order_user">
                                                <a href="{{ route('admin.order.detail', ['order_id' => $order->id]) }}"
                                                    class="badge badge-phoenix fs--2 badge-phoenix-success">Sipariş
                                                    Detayı</a>
                                            </td>
                                            <td class="order_details">
                                                @if ($order->status == 0)
                                                    <a onclick="return confirm('İlan satışını onaylamak istediğinize emin misiniz?')"
                                                        href="{{ route('admin.approve-order', ['cartOrder' => $order->id]) }}"
                                                        class="badge badge-phoenix fs--2 badge-phoenix-success">İlan
                                                        Satışını Onayla</a>
                                                    <br>
                                                    <a onclick="return confirm('İlan satışını reddetmek istediğinize emin misiniz?')"
                                                        href="{{ route('admin.unapprove-order', ['cartOrder' => $order->id]) }}"
                                                        class="badge badge-phoenix fs--2 badge-phoenix-danger">İlan Satışını
                                                        Reddet</a>
                                                @elseif($order->status == 2)
                                                    <a onclick="return confirm('İlan satışını onaylamak istediğinize emin misiniz?')"
                                                        href="{{ route('admin.approve-order', ['cartOrder' => $order->id]) }}"
                                                        class="badge badge-phoenix fs--2 badge-phoenix-success">İlan
                                                        Satışını Onayla</a>
                                                @else
                                                    <a onclick="return confirm('İlan satışını reddetmek istediğinize emin misiniz?')"
                                                        href="{{ route('admin.unapprove-order', ['cartOrder' => $order->id]) }}"
                                                        class="badge badge-phoenix fs--2 badge-phoenix-danger">İlan Satışını
                                                        Reddet</a>
                                                @endif

                                                @if (isset($order->share))
                                                    <br>
                                                    @if ($order->share->status == 0)
                                                        <a onclick="return confirm('Hakedişleri onaylamak istediğinize emin misiniz?')"
                                                            href="{{ route('admin.approve-share', ['share' => $order->share->id]) }}"
                                                            class="badge badge-phoenix fs--2 badge-phoenix-info">Hakedişleri
                                                            Onayla</a>
                                                        <br>
                                                        <a onclick="return confirm('Hakedişleri reddetmek istediğinize emin misiniz?')"
                                                            href="{{ route('admin.unapprove-share', ['share' => $order->share->id]) }}"
                                                            class="badge badge-phoenix fs--2 badge-phoenix-danger">Hakedişleri
                                                            Reddet</a>
                                                    @elseif($order->share->status == 2)
                                                        <a onclick="return confirm('Hakedişleri onaylamak istediğinize emin misiniz?')"
                                                            href="{{ route('admin.approve-share', ['share' => $order->share->id]) }}"
                                                            class="badge badge-phoenix fs--2 badge-phoenix-info">Hakedişleri
                                                            Onayla</a>
                                                    @else
                                                        <a onclick="return confirm('Hakedişleri reddetmek istediğinize emin misiniz?')"
                                                            href="{{ route('admin.unapprove-share', ['share' => $order->share->id]) }}"
                                                            class="badge badge-phoenix fs--2 badge-phoenix-danger">Hakedişleri
                                                            Reddet</a>
                                                    @endif
                                                    <br>
                                                @endif

                                                @if (isset($order->price))
                                                    <br>
                                                    @if ($order->price->status == 0 || $order->price->status == 2)
                                                        <a onclick="return confirm('Hakedişleri onaylamak istediğinize emin misiniz?')"
                                                            href="{{ route('admin.approve-price', ['price' => $order->price->id]) }}"
                                                            class="badge badge-phoenix fs--2 badge-phoenix-info">Hakedişleri
                                                            Onayla</a>
                                                    @else
                                                        <a onclick="return confirm('Hakedişleri reddetmek istediğinize emin misiniz?')"
                                                            href="{{ route('admin.unapprove-price', ['price' => $order->price->id]) }}"
                                                            class="badge badge-phoenix fs--2 badge-phoenix-danger">Hakedişleri
                                                            Reddet</a>
                                                    @endif
                                                @endif
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
