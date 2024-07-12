@if (count($cartOrders) > 0)
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
                    if (Auth::check() && Auth::user()->id == $order->store->id) {
                        if ($order->user->profile_image) {
                            $storeImage = url('storage/profile_images/' . $order->user->profile_image);
                        } else {
                            $initial = $order->user->name ? sultoupper(subsul($order->user->name, 0, 1)) : '';
                            $storeImage = $initial;
                        }
                    } else {
                        if ($order->store->profile_image) {
                            $storeImage = url('storage/profile_images/' . $order->store->profile_image);
                        } else {
                            $initial = $order->store->name ? sultoupper(subsul($order->store->name, 0, 1)) : '';
                            $storeImage = $initial;
                        }
                    }

                @endphp

                <li class="no"><span>#{{ $order->id }}</span></li>

                <li class="sales_person align-middle white-space-nowrap">
                    <a target="_blank"
                        href="{{ route('institutional.dashboard', ['slug' => $key && $key == 'my-orders' ? $order->store->name : $order->user->name, 'userID' => $key && $key == 'my-orders' ? $order->store->id : $order->user->id]) }}"
                        class="d-flex align-items-center text-body">
                        <div class="avatar avatar-m">
                            <img class="rounded-circle" src="{{ $storeImage }}" alt=""
                                style="width:35px;height:35px">
                        </div>
                        <p style="margin-left: 10px">
                            {{ $key && $key == 'my-orders' ? $order->store->name : $order->user->name }}</p>
                    </a>
                </li>

                <li class="order_amount">
                    {{ number_format(floatval(str_replace('.', '', $order->amount)), 0, ',', '.') }} ₺
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
                    </li>
                @endif

                <li><span class="project-table-content-actions-button" data-toggle="popover-{{ $order->id }}"><i
                            class="fa fa-chevron-down"></i></span></li>
            </ul>
            <div class="popover-project-actions d-none" id="popover-{{ $order->id }}">
                <ul>
                    @if ($order->invoice && $order->status == 1)
                        <li>
                            <a href="{{ route('institutional.invoice.show', hash_id($order->id)) }}">Faturayı
                                Görüntüle</a>
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
@else
    <ul>
        <li>Sonuç Bulunamadı</li>
    </ul>
@endif
