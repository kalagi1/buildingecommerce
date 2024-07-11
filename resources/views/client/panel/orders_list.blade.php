@foreach ($cartOrders as $order)
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
    <div class="project-table-content user-item @if ($order->refund && $order->refund->status == 1) table-danger @endif">
        <ul>
            @php
                $orderCart = json_decode($order->cart, true);
                if ($order->store->profile_image) {
                    $storeImage = url('storage/profile_images/' . $order->store->profile_image);
                } else {
                    $initial = $order->store->name ? sultoupper(subsul($order->store->name, 0, 1)) : '';
                    $storeImage = $initial;
                }
            @endphp

            <li class="no"><span>#{{ $order->id }}</span></li>

            <li class="sales_person align-middle white-space-nowrap">
                <a target="_blank"
                    href="{{ route('institutional.dashboard', ['slug' => $order->store->name, 'userID' => $order->store->id]) }}"
                    class="d-flex align-items-center text-body">
                    <div class="avatar avatar-m"><img class="rounded-circle" src="{{ $storeImage }}" alt=""></div>
                </a>
            </li>

            <li class="order_amount">{{ number_format(floatval(str_replace('.', '', $order->amount)), 0, ',', '.') }} ₺
            </li>
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

                            @if ($orderCart['type'] == 'housing')
                                {{ $orderCart['item']['id'] + 2000000 }}
                            @else
                                {{ optional(App\Models\Project::find($orderCart['item']['id']))->id + 1000000 . '-' . $orderCart['item']['housing'] }}
                            @endif
                        </a>
                    </strong>
                </span>
            </li>

            @if ($order->refund != null)
                <li class="order_status">
                    <span class="text-success">
                        {!! [
                            '0' =>
                                '<span class=" fs-10 text-warning"><span class="badge-label">İade Talebi Oluşturuldu</span><span class="ms-1" data-feather="alert-octagon" style="height:12.8px;width:12.8px;"></span></span>',
                            '1' =>
                                '<span class=" fs-10 text-info"><span class="badge-label">Sipariş İade Edildi</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>',
                            '2' =>
                                '<span class=" fs-10 text-danger"><span class="badge-label">İade Talebi Reddedildi</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span>',
                            '3' =>
                                '<span class=" fs-10 text-success"><span class="badge-label">Geri Ödeme Yapıldı</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>',
                        ][$order->refund->status] !!}
                    </span>
                </li>
            @else
                <li class="order_status">
                    <span class="text-success">
                        {!! [
                            '0' =>
                                '<span class=" fs-10 text-warning"><span class="badge-label">Onay Bekleniyor</span><span class="ms-1" data-feather="alert-octagon" style="height:12.8px;width:12.8px;"></span></span>',
                            '1' =>
                                '<span class=" fs-10 text-success"><span class="badge-label">Ödeme Onaylandı</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>',
                            '2' =>
                                '<span class=" fs-10 text-danger"><span class="badge-label">Ödeme Reddedildi</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span>',
                        ][$order->status] !!}
                    </span>
                    @if ($order->invoice && $order->status == 1)
                        <span class=" fs-10 text-success">
                            <a href="{{ route('institutional.invoice.show', $order->id) }}">
                                Faturayı Görüntüle
                            </a>
                        </span>
                    @endif
                </li>
            @endif

            <li><span class="project-table-content-actions-button"
                    data-toggle="popover-{{ $order->id }}"><i class="fa fa-chevron-down"></i></span></li>
        </ul>
        <div class="popover-project-actions d-none" id="popover-{{ $order->id }}">
            <ul>
                @if ($order->invoice && $order->status == 1)
                    <li>
                        <a href="{{ route('institutional.invoice.show', $order->id) }}">Faturayı Görüntüle</a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('institutional.order.detail', ['order_id' => hash_id($order->id)]) }}">Sipariş
                        Detayı</a>
                </li>
            </ul>
        </div>
    </div>
@endforeach

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#filterButton').on('click', function() {
                filterOrders();
            });

            $('#searchInput').on('input', function() {
                filterOrders();
            });

            function filterOrders() {
                // $(".spinBorder").removeClass("d-none");

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

                        if (response.html.trim() === '') {
                            $('#user-list-table-body').html('<ul><li>Sonuç bulunamadı</li></ul>');
                            // $(".spinner-border").addClass("d-none");

                        } else if ($('#user-list-table-body').find('ul').length === 0) {
                            // $(".spinner-border").addClass("d-none");
                        }
                    },
                    error: function(xhr) {
                        $(".spinBorder").addClass("d-none");
                    }
                });
            }

            // Toggle popovers
            $(document).on('click', '.project-table-content-actions-button', function() {
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
        });
    </script>
@endsection
