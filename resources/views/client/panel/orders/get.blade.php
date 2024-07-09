@extends('client.layouts.masterPanel')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="table-breadcrumb">
            <ul>
                <li>Hesabım</li>
                <li> Siparişlerim</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="alert alert-info">
            Emlak Sepette yaptığınız tüm satın alım işlemlerine aşağıdaki alandan ulaşabilirsiniz.
        </div>

        <!-- Filter Section -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <input type="text" id="searchInput" class="form-control w-25" placeholder="Siparişlerde Ara...">
            <div class="d-flex align-items-center">
                <input type="date" id="startDate" class="form-control mr-3">
                <input type="date" id="endDate" class="form-control">
                <button id="filterButton" class="btn btn-primary ml-3">Filtrele</button>
            </div>
        </div>

        <div id="user-list-table-body">
            <div class="spinner-border text-danger" role="status">
                <span class="visually-hidden"></span>
              </div>
            @include('client.panel.orders_list', ['cartOrders' => $cartOrders])

            {{-- @foreach ($cartOrders as $order)
                @php
                    $o = json_decode($order->cart);
                    $project =
                        $o->type == 'project'
                            ? App\Models\Project::with('roomInfo')
                                ->where('id', $o->item->id)
                                ->first()
                            : null;
                    $tarih = date('d F Y', strtotime($order->created_at));
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
                <div class="project-table-content user-item">
                    <ul @if ($order->refund && $order->refund->status == 1) class="table-danger" @endif>
                        @php
                            $orderCart = json_decode($order->cart, true);
                        @endphp

                        <li class="no"><span>#{{ $order->id }}</span></li>
                        @php
                        if ($order->store->profile_image) {
                            $storeImage = url('storage/profile_images/' . $order->store->profile_image);
                        } else {
                            $initial = $order->store->name ? sultoupper(subsul($order->store->name, 0, 1)) : '';
                            $storeImage = $initial;
                        }
                    @endphp

                    <li class="sales_person align-middle white-space-nowrap">
                        <a target="_blank"
                            href="{{ route('institutional.dashboard', ['slug' => $order->store->name, 'userID' => $order->store->id]) }}"
                            class="d-flex align-items-center text-body">
                            <div class="avatar avatar-m"><img class="rounded-circle" src="{{ $storeImage }}" alt=""></div>
                        </a>
                    </li>

                        <li class="order_amount">{{ number_format(floatval(str_replace('.', '', $order->amount)), 0, ',', '.') }} ₺</li>
                        <li class="order_date">{{ $tarih }}</li>

                        <li class="order_project">
                            <span>
                                <strong>İlan No:
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
                                </strong>
                            </span>
                        </li>

                        @if ($order->refund != null)
                            <li class="order_status">
                                <span class="text-success">
                                    {!! [
                                        '0' => '<span class="badge badge-phoenix fs-10 badge-phoenix-warning"><span class="badge-label">İade Talebi Oluşturuldu</span><span class="ms-1" data-feather="alert-octagon" style="height:12.8px;width:12.8px;"></span></span>',
                                        '1' => '<span class="badge badge-phoenix fs-10 badge-phoenix-info"><span class="badge-label">İade Talebi Onaylandı</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>',
                                        '2' => '<span class="badge badge-phoenix fs-10 badge-phoenix-danger"><span class="badge-label">İade Talebi Reddedildi</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span>',
                                        '3' => '<span class="badge badge-phoenix fs-10 badge-phoenix-success"><span class="badge-label">Geri Ödeme Yapıldı</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>',
                                    ][$order->refund->status] !!}
                                </span>
                            </li>
                        @else
                            <li class="order_status">
                                <span class="text-success">
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
                            </li>
                        @endif

                        <li style="width: 5%;"><span class="project-table-content-actions-button" data-toggle="popover-{{ $order->id }}"><i class="fa fa-chevron-down"></i></span></li>
                    </ul>
                    <div class="popover-project-actions d-none" id="popover-{{ $order->id }}">
                        <ul>
                            @if ($order->invoice && $order->status == 1)
                                <li>
                                    <a href="{{ route('institutional.invoice.show', $order->id) }}">Faturayı Görüntüle</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('institutional.order.detail', ['order_id' => hash_id($order->id)]) }}">Sipariş Detayı</a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endforeach --}}
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#filterButton').on('click', function() {
                filterOrders();
            });

            function filterOrders() {
                var searchInput = $('#searchInput').val();
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();

                $.ajax({
                    url: "{{ route('institutional.orders.filter') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        search: searchInput,
                        startDate: startDate,
                        endDate: endDate
                    },
                    success: function(response) {
                        $('#user-list-table-body').html(response.html);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
        $(document).ready(function() {
            // Toggle popovers
            $('.project-table-content-actions-button').on('click', function() {
                var targetId = $(this).data('toggle');
                var $popover = $('#' + targetId);

                // Hide other popovers
                $('.popover-project-actions').not($popover).addClass('d-none');

                // Toggle current popover
                $popover.toggleClass('d-none');
            });

            // Close popover when clicking outside
            $(document).on('click', function(event) {
                if (!$(event.target).closest('.project-table-content').length) {
                    $('.popover-project-actions').addClass('d-none');
                }
            });

            // Filter orders
            $('#searchInput').on('input', function() {
                $('.project-table-content').each(function() {
                    var orderText = $(this).text().toLowerCase();

                    var isSearchMatch = orderText.includes(searchInput);

                    $(this).toggle(isSearchMatch);
                });
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        .avatar {
            position: relative;
            display: inline-block;
            vertical-align: middle;
        }

        .avatar-m {
            height: 50px;
            width: 50px;
            border: 1px solid #bebebe;
            border-radius: 50%
        }

        .avatar img,
        .avatar .avatar-name {
            width: 100%;
            height: 100%;
        }

        .avatar img {
            -o-object-fit: cover;
            object-fit: cover;
        }

        .avatar img {
            display: block;
        }

        .rounded-circle {
            float: left;
            height: 2rem;
            width: 2rem;
        }

        .table-breadcrumb {
            margin-bottom: 0 !important
        }

        .visually-hidden, .visually-hidden-focusable:not(:focus):not(:focus-within) {
    width: 1px !important;
    height: 1px !important;
    padding: 0 !important;
    margin: -1px !important;
    overflow: hidden !important;
    clip: rect(0, 0, 0, 0) !important;
    white-space: nowrap !important;
    border: 0 !important;
}
    </style>
@endsection
