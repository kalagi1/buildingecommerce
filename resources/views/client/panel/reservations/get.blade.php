
@extends('client.layouts.masterPanel')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="table-breadcrumb">
            <ul>
                <li>Hesabım</li>
                <li>Kiraladıklarım</li>
            </ul>
        </div>
    </div>

  <section>
    <div class="front-project-tabs">
        <ul class="mt-3 mb-3" id="reservationTabs">
            @foreach ([
                ['id' => 'housingReservations', 'text' => 'Onaylanan Rezervasyonlar', 'count' => $housingReservations->count()],
                ['id' => 'confirmReservations', 'text' => 'Onay Bekleyen Rezervasyonlar', 'count' => $confirmReservations->count()],
                ['id' => 'cancelRequestReservations', 'text' => 'İptal Talebi Bekleyen Rezervasyonlar', 'count' => $cancelRequestReservations->count()],
                ['id' => 'expiredReservations', 'text' => 'Geçmiş Rezervasyonlar', 'count' => $expiredReservations->count()],
                ['id' => 'cancelReservations', 'text' => 'Reddedilmiş Rezervasyonlar', 'count' => $cancelReservations->count()],
                ['id' => 'refundedReservations', 'text' => 'İptal Edilen Rezervasyonlar', 'count' => $refundedReservations->count()]
            ] as $tab)
                <li class="tab-item {{ $loop->first ? 'active' : '' }}" id="{{ $tab['id'] }}-tab" data-target="{{ $tab['id'] }}">
                    {{ $tab['text'] }} ({{ $tab['count'] }})
                </li>
            @endforeach
        </ul>
    </div>

    <div class="tab-content">
        @foreach ([
            'housingReservations' => $housingReservations,
            'confirmReservations' => $confirmReservations,
            'cancelRequestReservations' => $cancelRequestReservations,
            'expiredReservations' => $expiredReservations,
            'cancelReservations' => $cancelReservations,
            'refundedReservations' => $refundedReservations
        ] as $tabId => $reservations)
            <div class="tab-pane {{ $loop->first ? 'show active' : '' }}" id="{{ $tabId }}">
                @if ($reservations->isEmpty())
                    <div class="project-table-content">
                        <p class="text-center mb-0">Rezervasyon bulunamadı</p>
                    </div>
                @else
                    <div class="project-table">
                        @foreach ($reservations as $index => $reservation)
                            <div class="project-table-content">
                                <ul class="list-unstyled d-flex housing-item">
                                    <!-- Index -->
                                    <li style="width: 5%">{{ $index + 1 }}</li>
                                    <li style="width: 5%">{{ $reservation->id + 2000000 }}</li>

                                    <!-- Title -->
                                    <li style="width: 45%">
                                        <div>
                                            <p class="project-table-content-title">{{ $reservation->title }}</p>
                                        </div>
                                    </li>

                                    <!-- Type -->
                                    <li style="width: 10%">
                                        <div>
                                            <p class="project-table-content-title">{{ $reservation->type }}</p>
                                        </div>
                                    </li>

                                    <!-- Consultant or User -->
                                    <li style="width: 10%">
                                        <div>
                                            <p class="project-table-content-title">
                                                @if (!empty($reservation->consultant) && !empty($reservation->consultant->name))
                                                    {{ $reservation->consultant->name }}
                                                @elseif (!empty($reservation->user) && !empty($reservation->user->name))
                                                    {{ $reservation->user->name }}
                                                @else
                                                    Mağaza Yöneticisi
                                                @endif
                                            </p>
                                        </div>
                                    </li>

                                    <!-- Created At -->
                                    <li style="width: 10%">
                                        <div>
                                            <p class="project-table-content-title">
                                                {{ \Carbon\Carbon::parse($reservation->created_at)->format('d.m.Y H:i') }}
                                            </p>
                                        </div>
                                    </li>

                                    <!-- Status -->
                                    <li style="width: 10%">
                                        <div>
                                            <p class="project-table-content-title">
                                                @php
                                                    $status = $reservation->status;
                                                    switch ($status) {
                                                        case 1:
                                                            $badge = '<span class="badge badge-success">Aktif</span>';
                                                            break;
                                                        case 2:
                                                            $badge = '<span class="badge badge-warning">Onay Bekleniyor</span>';
                                                            break;
                                                        case 3:
                                                            $badge = '<span class="badge badge-danger">Yönetim Tarafından Reddedildi</span>';
                                                            break;
                                                        default:
                                                            $badge = '<span class="badge badge-danger">Pasif</span>';
                                                            break;
                                                    }
                                                @endphp
                                                {!! $badge !!}
                                            </p>
                                        </div>
                                    </li>

                                    <!-- Actions -->
                                    <li style="width: 5%">
                                        <span class="project-table-content-actions-button" data-toggle="popover-{{ $reservation->id }}">
                                            <i class="fa fa-chevron-down"></i>
                                        </span>
                                    </li>
                                </ul>

                                <!-- Popover Actions -->
                                <div class="popover-project-actions d-none" id="popover-{{ $reservation->id }}">
                                    <ul class="list-unstyled">
                                        @if (in_array('UpdateReservation', $userPermissions))
                                            <li>
                                                <a href="{{ route('institutional.reservation.edit', ['id' => hash_id($reservation->id)]) }}">Rezervasyonu Düzenle</a>
                                            </li>
                                        @endif

                                        @if (in_array('UpdateReservation', $userPermissions))
                                            <li>
                                                <a href="{{ route('institutional.reservation.images.update', ['id' => hash_id($reservation->id)]) }}">Resimleri Düzenle</a>
                                            </li>
                                        @endif
                                        <li>
                                            <a href="{{ route('institutional.bids.index', ['reservation' => hash_id($reservation->id)]) }}">Pazarlık Teklifleri</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</section>

@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#reservationTabs .tab-item').on('click', function() {
                var targetId = $(this).attr('id').replace('-tab', '');
                
                // Remove active class from all tabs
                $('#reservationTabs .tab-item').removeClass('active');
                
                // Add active class to the clicked tab
                $(this).addClass('active');

                // Hide all tab panes
                $('.tab-pane').removeClass('show active');

                // Show the corresponding tab pane
                $('#' + targetId).addClass('show active');
            });

            $('.project-table-content-actions-button').on('click', function() {
                var targetId = $(this).data('toggle');
                var $popover = $('#' + targetId);

                console.log("sas");

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


          // Search functionality
          $('#searchInput').on('input', function() {
            var query = $(this).val().toLowerCase();
            $('.tab-pane').each(function() {
                var $tabPane = $(this);
                $tabPane.find('.housing-item').each(function() {
                    var $item = $(this);
                    var text = $item.text().toLowerCase();
                    if (text.indexOf(query) > -1) {
                        $item.show();
                    } else {
                        $item.hide();
                    }
                });
            });
        });
    </script>
@endsection

<style>
    #reservationTabs {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    #reservationTabs .tab-item {
        display: inline-block;
        padding: 10px 20px;
        margin-right: 5px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    #reservationTabs .tab-item.active {
        background-color: #007bff;
        color: #fff;
    }

    #reservationTabs .tab-item:not(.active):hover {
        background-color: #f1f1f1;
    }

    .tab-pane {
        display: none;
    }

    .tab-pane.show {
        display: block;
    }

    .modal-dialog {
        max-width: 500px;
    }
</style>

@extends('client.layouts.masterPanel')

@section('content')
    <div class="content">
        <div class="mb-9">
            <div class="row g-3 mb-4">
                <div class="col-auto">
                    <h3 class="mb-0">Rezervasyonlar</h2>
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
                    <ul class="nav nav-tabs" id="couponTabs">
                        <li class="nav-item active">
                            <a class="nav-link active" id="lastReservationsTab" data-toggle="tab" href="#confirmWaiting">Onay Bekleyen Rezervasyonlar ({{$confirmReservations->count()}})</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="activeTab" data-toggle="tab" href="#activeReservations">Onaylanmış Rezervasyonlar ({{$housingReservations->count()}})</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="activeTab" data-toggle="tab" href="#cancelRequestReservations">İptal Talebi Bekleyen Rezervasyonlar ({{$cancelRequestReservations->count()}})</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="lastReservationsTab" data-toggle="tab" href="#lastReservations">Geçmiş Rezervasyonlar ({{$expiredReservations->count()}})</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="expiredTab" data-toggle="tab" href="#expiredReservations">Reddedilmiş Rezervasyonlar ({{$cancelReservations->count()}})</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="expiredTab" data-toggle="tab" href="#refundedReservations">İade Edilen Rezervasyonlar ({{$refundedReservations->count()}})</a>
                        </li>

                    </ul>
                    <div class="tab-content mt-2">
                        <div class="tab-pane fade show active" id="confirmWaiting">
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
                                                data-sort="order_amount">Kapora Ödemesi</th>
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
                                                <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                                data-sort="order_user">Satıcı</th>
                                            <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                                data-sort="order_detail">Detay</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list" id="order-table-body">

                                        @if ($confirmReservations->count() > 0)
                                            @foreach ($confirmReservations as $order)
                                                @php $housing = App\Models\Housing::with('user')->find($order->housing_id) @endphp
                                                @php
                                                    $estateSecured = $order->money_trusted == 1 ? 1000 : 0;
                                                @endphp
                                                <tr>
                                                    <td class="order_no">
                                                        {{$order->key}}
                                                    </td>
                                                    <td class="order_image">
                                                        <img src="{{ asset('housing_images/' . json_decode(App\Models\Housing::find($order->housing_id ?? 0)->housing_type_data ?? '[]')->image ?? null) }}"
                                                            width="100px" style="object-fit: contain;" />
                                                            <br>

                                                            {{ $order->created_at }} <br>
                                                        {{ App\Models\Housing::find($order->housing_id ?? 0)->title }} <br>
                                                        {{ $order->key }} 

                                                    </td>
                                                    <td class="order_amount">
                                                        {{ number_format($order->total_price, 0, ',', '.') }} ₺
                                                    </td>
                                                    <td class="order_amount">
                                                        {{ number_format(($order->total_price / 2) + $order->money_is_safe, 0, ',', '.') }}₺ ({{$order->money_is_safe}}₺ Param Güvende Ödemesi)  
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
                                                        '3' => '<span class="text-danger">Rezervasyon iptal edildi</span>',
                                                    ][$order->status] !!}</td>
                                                    <td class="order_user">
                                                        {{ $order->user->name }} <br>
                                                        {{ $order->user->email }}
                                                    </td>
                                                    <td class="order_user">
                                                        {{ $order->owner->name }} <br>
                                                        {{ $order->owner->email }}
                                                    </td>
                                                    

                                                    <td class="order_details"> 
                                                        <a href="{{ route('institutional.reservation.order.detail', ['reservation_id' => $order->id]) }}" class="badge badge-phoenix badge-phoenix-success">Rezervasyon Detayı</a>
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
                        <div class="tab-pane fade" id="activeReservations">
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
                                                data-sort="order_amount">Kapora Ödemesi</th>
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
                                                <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                                data-sort="order_user">Satıcı</th>
                                                <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                                data-sort="order_user">Detay</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list" id="order-table-body">

                                        @if ($housingReservations->count() > 0)
                                            @foreach ($housingReservations as $order)
                                                @php $housing = App\Models\Housing::with('user')->find($order->housing_id) @endphp
                                                @php
                                                    $estateSecured = $order->money_trusted == 1 ? 1000 : 0;
                                                @endphp

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
                                                    <td class="order_amount">
                                                        {{ number_format(($order->total_price / 2) + $estateSecured, 0, ',', '.') }}₺ @if($order->money_trusted == 1) (+1000₺ Param Güvende Ödemesi) @endif 
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
                                                        <td class="order_user">
                                                            {{ $order->owner->name }} <br>
                                                            {{ $order->owner->email }}</td>
                                                            {{-- <td class="order_details">
                                                                @if ($order->status == 0 || $order->status == 2)
                                                                    <a onclick="return confirm('Rezervasyonu onaylamak istediğinize emin misiniz?')" href="{{ route('admin.approve-reservation', ['reservation' => $order->id]) }}" class="badge badge-phoenix badge-phoenix-success">Rezervasyonu onayla</a>
                                                                @else
                                                                    <a onclick="return confirm('Rezervasyonu iptal etmek istediğinize emin misiniz?')" href="{{ route('admin.unapprove-reservation', ['reservation' => $order->id]) }}" class="badge badge-phoenix badge-phoenix-danger" >Rezervasyonu reddet</a>
                                                                @endif

                                                                <br>
                                                                @if(isset($order->cartPrice))
                                                                    @if($order->cartPrice->status == 0 || $order->cartPrice->status == 2)
                                                                        <a onclick="return confirm('Hakedişleri onaylamak istediğinize emin misiniz?')" href="{{ route('admin.approve-price', ['price' => $order->cartPrice->id]) }}" class="badge badge-phoenix badge-phoenix-success">Hakedişleri onayla</a>
                                                                    @else
                                                                        <a onclick="return confirm('Hakedişleri reddetmek istediğinize emin misiniz?')" href="{{ route('admin.unapprove-price', ['price' => $order->cartPrice->id]) }}" class="badge badge-phoenix badge-phoenix-danger">Hakedişleri reddet</a>
                                                                    @endif
                                                                @endif

                                                                @if(isset($order->sharer))
                                                                    @if($order->sharer->status == 0 || $order->sharer->status == 2)
                                                                        <a onclick="return confirm('Hakedişleri onaylamak istediğinize emin misiniz?')" href="{{ route('admin.approve-share', ['share' => $order->sharer->id]) }}" class="badge badge-phoenix badge-phoenix-success">Hakedişleri onayla</a>
                                                                    @else
                                                                        <a onclick="return confirm('Hakedişleri reddetmek istediğinize emin misiniz?')" href="{{ route('admin.unapprove-share', ['share' => $order->sharer->id]) }}" class="badge badge-phoenix badge-phoenix-danger">Hakedişleri reddet</a>
                                                                    @endif
                                                                @endif
                                                                <br>
                                                                @if(isset($order->cancelRequest))
                                                                    <a href="" reservation_id="{{$order->id}}" cancel_request_id="{{$order->cancelRequest->id}}" class="badge badge-phoenix badge-phoenix-secondary reservation-cancel">İptal Talebini Görüntüle</a>
                                                                @endif
                                                            </td> --}}


                                                    <td class="order_details"> 
                                                        <a href="{{ route('institutional.reservation.order.detail', ['reservation_id' => $order->id]) }}" class="badge badge-phoenix badge-phoenix-success">Rezervasyon Detayı</a>
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
                        <div class="tab-pane fade" id="cancelRequestReservations">
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
                                                data-sort="order_amount">Kapora</th>
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
                                                <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                                data-sort="order_user">Satıcı</th>
                                                <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                                data-sort="order_user">Detay</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list" id="order-table-body">

                                        @if ($cancelRequestReservations->count() > 0)
                                            @foreach ($cancelRequestReservations as $order)
                                                @php $housing = App\Models\Housing::with('user')->find($order->housing_id) @endphp
                                                @php
                                                    $estateSecured = $order->money_trusted == 1 ? 1000 : 0;
                                                @endphp

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
                                                    <td class="order_amount">
                                                        {{ number_format(($order->total_price / 2) + $estateSecured, 0, ',', '.') }}₺ @if($order->money_trusted == 1) (+1000₺ Param Güvende Ödemesi) @endif 
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

                                                    <td class="order_status">
                                                    {!! [
                                                        '0' => '<span class="text-warning">Rezerve Edildi</span>',
                                                        '1' => '<span class="text-success">Rezervasyon Onaylandı</span>',
                                                        '2' => '<span class="text-danger">Ödeme Reddedildi</span>',
                                                    ][$order->status] !!}
                                                    </td>
                                                    <td class="order_user">
                                                        {{ $order->user->name }} <br>
                                                        {{ $order->user->email }}
                                                    </td>
                                                    <td class="order_user">
                                                        {{ $order->owner->name }} <br>
                                                        {{ $order->owner->email }}
                                                    </td>
                                                    {{-- <td class="order_details">
                                                        @if ($order->status == 0 || $order->status == 2)
                                                            <a onclick="return confirm('Rezervasyonu onaylamak istediğinize emin misiniz?')" href="{{ route('admin.approve-reservation', ['reservation' => $order->id]) }}" class="badge badge-phoenix badge-phoenix-success">Rezervasyonu onayla</a>
                                                        @else
                                                            <a onclick="return confirm('Rezervasyonu iptal etmek istediğinize emin misiniz?')" href="{{ route('admin.unapprove-reservation', ['reservation' => $order->id]) }}" class="badge badge-phoenix badge-phoenix-danger" >Rezervasyonu reddet</a>
                                                        @endif

                                                        <br>
                                                        @if(isset($order->cartPrice))
                                                            @if($order->cartPrice->status == 0 || $order->cartPrice->status == 2)
                                                                <a onclick="return confirm('Hakedişleri onaylamak istediğinize emin misiniz?')" href="{{ route('admin.approve-price', ['price' => $order->cartPrice->id]) }}" class="badge badge-phoenix badge-phoenix-success">Hakedişleri onayla</a>
                                                            @else
                                                                <a onclick="return confirm('Hakedişleri reddetmek istediğinize emin misiniz?')" href="{{ route('admin.unapprove-price', ['price' => $order->cartPrice->id]) }}" class="badge badge-phoenix badge-phoenix-danger">Hakedişleri reddet</a>
                                                            @endif
                                                        @endif

                                                        @if(isset($order->sharer))
                                                            @if($order->sharer->status == 0 || $order->sharer->status == 2)
                                                                <a onclick="return confirm('Hakedişleri onaylamak istediğinize emin misiniz?')" href="{{ route('admin.approve-share', ['share' => $order->sharer->id]) }}" class="badge badge-phoenix badge-phoenix-success">Hakedişleri onayla</a>
                                                            @else
                                                                <a onclick="return confirm('Hakedişleri reddetmek istediğinize emin misiniz?')" href="{{ route('admin.unapprove-share', ['share' => $order->sharer->id]) }}" class="badge badge-phoenix badge-phoenix-danger">Hakedişleri reddet</a>
                                                            @endif
                                                        @endif
                                                        <br>
                                                        @if(isset($order->cancelRequest))
                                                            <a href="" reservation_id="{{$order->id}}" cancel_request_id="{{$order->cancelRequest->id}}" class="badge badge-phoenix badge-phoenix-secondary reservation-cancel">İptal Talebini Görüntüle</a>
                                                        @endif
                                                    </td> --}}


                                                    <td class="order_details"> 
                                                        <a href="{{ route('institutional.reservation.order.detail', ['reservation_id' => $order->id]) }}" class="badge badge-phoenix badge-phoenix-success">Rezervasyon Detayı</a>
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
                        <div class="tab-pane fade  " id="lastReservations">
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
                                                data-sort="order_amount">Kapora</th>
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
                                                <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                                data-sort="order_user">Satıcı</th>
                                                <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                                data-sort="order_user">Detay</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list" id="order-table-body">

                                        @if ($expiredReservations->count() > 0)
                                            @foreach ($expiredReservations as $order)
                                                @php $housing = App\Models\Housing::with('user')->find($order->housing_id) @endphp
                                                @php
                                                    $estateSecured = $order->money_trusted == 1 ? 1000 : 0;
                                                @endphp

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
                                                    <td class="order_amount">
                                                        {{ number_format(($order->total_price / 2) + $estateSecured, 0, ',', '.') }}₺ @if($order->money_trusted == 1) (+1000₺ Param Güvende Ödemesi) @endif 
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
                                                        '3' => '<span class="text-danger">Rezervasyon iptal edildi</span>',
                                                    ][$order->status] !!}</td>
                                                    <td class="order_user">
                                                        {{ $order->user->name }} <br>
                                                        {{ $order->user->email }}</td>
                                                        <td class="order_user">
                                                            {{ $order->owner->name }} <br>
                                                            {{ $order->owner->email }}</td>
                                                            {{-- <td class="order_details">
                                                                @if ($order->status == 0 || $order->status == 2)
                                                                    <a onclick="return confirm('Rezervasyonu onaylamak istediğinize emin misiniz?')" href="{{ route('admin.approve-reservation', ['reservation' => $order->id]) }}" class="badge badge-phoenix badge-phoenix-success">Rezervasyonu onayla</a>
                                                                @else
                                                                    <a onclick="return confirm('Rezervasyonu iptal etmek istediğinize emin misiniz?')" href="{{ route('admin.unapprove-reservation', ['reservation' => $order->id]) }}" class="badge badge-phoenix badge-phoenix-danger" >Rezervasyonu reddet</a>
                                                                @endif

                                                                <br>
                                                                @if(isset($order->cartPrice))
                                                                    @if($order->cartPrice->status == 0 || $order->cartPrice->status == 2)
                                                                        <a onclick="return confirm('Hakedişleri onaylamak istediğinize emin misiniz?')" href="{{ route('admin.approve-price', ['price' => $order->cartPrice->id]) }}" class="badge badge-phoenix badge-phoenix-success">Hakedişleri onayla</a>
                                                                    @else
                                                                        <a onclick="return confirm('Hakedişleri reddetmek istediğinize emin misiniz?')" href="{{ route('admin.unapprove-price', ['price' => $order->cartPrice->id]) }}" class="badge badge-phoenix badge-phoenix-danger">Hakedişleri reddet</a>
                                                                    @endif
                                                                @endif

                                                                @if(isset($order->sharer))
                                                                    @if($order->sharer->status == 0 || $order->sharer->status == 2)
                                                                        <a onclick="return confirm('Hakedişleri onaylamak istediğinize emin misiniz?')" href="{{ route('admin.approve-share', ['share' => $order->sharer->id]) }}" class="badge badge-phoenix badge-phoenix-success">Hakedişleri onayla</a>
                                                                    @else
                                                                        <a onclick="return confirm('Hakedişleri reddetmek istediğinize emin misiniz?')" href="{{ route('admin.unapprove-share', ['share' => $order->sharer->id]) }}" class="badge badge-phoenix badge-phoenix-danger">Hakedişleri reddet</a>
                                                                    @endif
                                                                @endif
                                                                <br>
                                                                @if(isset($order->cancelRequest))
                                                                    <a href="" reservation_id="{{$order->id}}" cancel_request_id="{{$order->cancelRequest->id}}" class="badge badge-phoenix badge-phoenix-secondary reservation-cancel">İptal Talebini Görüntüle</a>
                                                                @endif
                                                            </td> --}}

                                                    <td class="order_details"> 
                                                        <a href="{{ route('institutional.reservation.order.detail', ['reservation_id' => $order->id]) }}" class="badge badge-phoenix badge-phoenix-success">Rezervasyon Detayı</a>
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
                        <div class="tab-pane fade  " id="expiredReservations">
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
                                                data-sort="order_amount">Kapora</th>
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
                                            <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                            data-sort="order_user">Satıcı</th>
                                            <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                            data-sort="order_user"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="list" id="order-table-body">

                                        @if ($cancelReservations->count() > 0)
                                            @foreach ($cancelReservations as $order)
                                                @php $housing = App\Models\Housing::with('user')->find($order->housing_id) @endphp
                                                @php
                                                    $estateSecured = $order->money_trusted == 1 ? 1000 : 0;
                                                @endphp

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
                                                    <td class="order_amount">
                                                        {{ number_format(($order->total_price / 2) + $estateSecured, 0, ',', '.') }}₺ @if($order->money_trusted == 1) (+1000₺ Param Güvende Ödemesi) @endif 
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
                                                        '3' => '<span class="text-danger">Rezervasyon iptal edildi</span>',
                                                    ][$order->status] !!}</td>
                                                    <td class="order_user">
                                                        {{ $order->user->name }} <br>
                                                        {{ $order->user->email }}
                                                    </td>
                                                    <td class="order_user">
                                                        {{ $order->owner->name }} <br>
                                                        {{ $order->owner->email }}
                                                    </td>
                                                    <td class="order_details">
                                                        
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

                        <div class="tab-pane fade  " id="refundedReservations">
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
                                                data-sort="order_amount">Kapora</th>
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
                                                <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                                data-sort="order_user">Satıcı</th>
                                                <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                                data-sort="order_user">Detay</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list" id="order-table-body">

                                        @if ($refundedReservations->count() > 0)
                                            @foreach ($refundedReservations as $order)
                                                @php $housing = App\Models\Housing::with('user')->find($order->housing_id) @endphp
                                                @php
                                                    $estateSecured = $order->money_trusted == 1 ? 1000 : 0;
                                                @endphp

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
                                                    <td class="order_amount">
                                                        {{ number_format(($order->total_price / 2) + $estateSecured, 0, ',', '.') }}₺ @if($order->money_trusted == 1) (+1000₺ Param Güvende Ödemesi) @endif 
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
                                                        '3' => '<span class="text-danger">Rezervasyon iptal edildi</span>',
                                                    ][$order->refund->status] !!}</td>
                                                    <td class="order_user">
                                                        {{ $order->user->name }} <br>
                                                        {{ $order->user->email }}</td>
                                                        <td class="order_user">
                                                            {{ $order->owner->name }} <br>
                                                            {{ $order->owner->email }}</td>
                                                            {{-- <td class="order_details">
                                                                @if ($order->status == 0 || $order->status == 2)
                                                                    <a onclick="return confirm('Rezervasyonu onaylamak istediğinize emin misiniz?')" href="{{ route('admin.approve-reservation', ['reservation' => $order->id]) }}" class="badge badge-phoenix badge-phoenix-success">Rezervasyonu onayla</a>
                                                                @else
                                                                    <a onclick="return confirm('Rezervasyonu iptal etmek istediğinize emin misiniz?')" href="{{ route('admin.unapprove-reservation', ['reservation' => $order->id]) }}" class="badge badge-phoenix badge-phoenix-danger" >Rezervasyonu reddet</a>
                                                                @endif

                                                                <br>
                                                                @if(isset($order->cartPrice))
                                                                    @if($order->cartPrice->status == 0 || $order->cartPrice->status == 2)
                                                                        <a onclick="return confirm('Hakedişleri onaylamak istediğinize emin misiniz?')" href="{{ route('admin.approve-price', ['price' => $order->cartPrice->id]) }}" class="badge badge-phoenix badge-phoenix-success">Hakedişleri onayla</a>
                                                                    @else
                                                                        <a onclick="return confirm('Hakedişleri reddetmek istediğinize emin misiniz?')" href="{{ route('admin.unapprove-price', ['price' => $order->cartPrice->id]) }}" class="badge badge-phoenix badge-phoenix-danger">Hakedişleri reddet</a>
                                                                    @endif
                                                                @endif

                                                                @if(isset($order->sharer))
                                                                    @if($order->sharer->status == 0 || $order->sharer->status == 2)
                                                                        <a onclick="return confirm('Hakedişleri onaylamak istediğinize emin misiniz?')" href="{{ route('admin.approve-share', ['share' => $order->sharer->id]) }}" class="badge badge-phoenix badge-phoenix-success">Hakedişleri onayla</a>
                                                                    @else
                                                                        <a onclick="return confirm('Hakedişleri reddetmek istediğinize emin misiniz?')" href="{{ route('admin.unapprove-share', ['share' => $order->sharer->id]) }}" class="badge badge-phoenix badge-phoenix-danger">Hakedişleri reddet</a>
                                                                    @endif
                                                                @endif
                                                                <br>
                                                                @if(isset($order->cancelRequest))
                                                                    <a href="" reservation_id="{{$order->id}}" cancel_request_id="{{$order->cancelRequest->id}}" class="badge badge-phoenix badge-phoenix-secondary reservation-cancel">İptal Talebini Görüntüle</a>
                                                                @endif
                                                            </td> --}}

                                                    <td class="order_details"> 
                                                        <a href="{{ route('institutional.reservation.order.detail', ['reservation_id' => $order->id]) }}" class="badge badge-phoenix badge-phoenix-success">Rezervasyon Detayı</a>
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
        </div>
    </div>
    <div class="modal-reservation-cancel d-none">
        <div class="modal-reservation-bg"></div>
        <div class="modal-reservation-cancel-content">
            <div class="close">
                <i class="fa fa-times"></i>
            </div>
            <div class="title-top">
                <h3>Rezervasyon İptali</h3>
            </div>
            <div class="reservation-cancel-table mt-2">
                <table>
                    <thead>
                        <tr>
                            <th>Rezervasyon Numarası</th>
                            <th>Rezervasyon Ücreti</th>
                            <th>Giriş Tarihi</th>
                            <th>Çıkış Tarihi</th>
                            <th>Rezervasyon Yapan Kişi</th>
                            <th>Param Güvende</th>
                            <th>Geri Ödenecek Tutar</th>
                            <th>Emlak Sepette Kazancı</th>
                            <th>Turizm Amaçlı Kiralama Acentesi Kazancı</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="reservation-number"></td>
                            <td class="reservation-price"></td>
                            <td class="reservation-open-date"></td>
                            <td class="reservation-close-date"></td>
                            <td class="reservation-user"></td>
                            <td class="reservation-money-trusted"></td>
                            <td class="reservation-back-money"></td>
                            <td class="reservation-estate-shopping-money"></td>
                            <td class="reservation-tourism-money"></td>
                        </tr>
                    </tbody>
                </table>

                <div class="info mt-3">
                    <span><strong>Turizm Amaçlı Kiralama Acentesi Iban Numarası</strong></span>
                    <br>
                    <span class="tourism-iban">Tr52</span>
                </div>

                <div class="info mt-3">
                    <span><strong>Rezervasyon Yapan Kişinin Iban Numarası</strong></span>
                    <br>
                    <span class="customer-iban">Tr52</span>
                    <br>
                    <span><strong>Rezervasyon Yapan Kişinin Alıcı Adı</strong></span>
                    <br>
                    <span class="customer-name"></span>
                </div>

                <div>
                    <a class="btn btn-sm btn-secondary mt-3 cancel-rezervation-admin">Rezervasyonu İptal Et</a>
                    <a class="btn btn-sm btn-primary mt-3 cancel-rezervation-admin-cancel">İptal Talebini Reddet</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        var months = ["Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık"]
        $(document).ready(function(){
            $('.modal-reservation-cancel-content .close').click(function(){
                $('.modal-reservation-cancel').addClass('d-none')
            })
            $('.modal-reservation-bg').click(function(){
                $('.modal-reservation-cancel').addClass('d-none')
            })
            $('.reservation-cancel').click(function(e){
                e.preventDefault();
                $('.modal-reservation-cancel').removeClass('d-none')
                var itemId = $(this).attr('reservation_id')
                $.ajax({
                    type: 'GET',
                    url: "{{ URL::to('/') }}/qR9zLp2xS6y/secured/reservation_info/"+itemId, // Filtreleme işlemi yapıldıktan sonra sonuçların nasıl getirileceği URL
                    success: function(data) {
                        data = JSON.parse(data);
                        var reservation = data.reservation;
                        console.log(reservation);
                        // Sadece sayı karakterlerine izin ver
                        var inputValue = reservation.total_price.toFixed(0);
                        inputValue = inputValue.replace(/\D/g, '');
                        // Her üç basamakta bir nokta ekleyin
                        inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                        var checkInDate = new Date(reservation.check_in_date);
                        var checkOutDate = new Date(reservation.check_out_date);

                        $('.reservation-number').html(1000000+reservation.id)
                        $('.reservation-price').html(inputValue+'₺')
                        $('.reservation-open-date').html(months[checkInDate.getMonth()]+', '+checkInDate.getDate()+' '+checkInDate.getFullYear())
                        $('.reservation-close-date').html(months[checkOutDate.getMonth()]+', '+checkOutDate.getDate()+' '+checkOutDate.getFullYear())
                        $('.reservation-user').html(reservation.user.name)
                        if(reservation.money_trusted){
                            $('.reservation-money-trusted').html("<span class='badge badge-phoenix badge-phoenix-success'><i class='fa fa-check'></span></span>")
                            $('.reservation-money-trusted').addClass('text-center')
                        }else{
                            $('.reservation-money-trusted').html("<span class='badge badge-phoenix badge-phoenix-danger'><i class='fa fa-times'></span></span>")
                            $('.reservation-money-trusted').addClass('text-center')
                        }
                        console.log(reservation.money_trusted);
                        if(reservation.money_trusted){
                            var backPrice = reservation.total_price.toFixed(0);
                            backPrice = backPrice.replace(/\D/g, '');
                            backPrice = backPrice.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            $('.reservation-back-money').html(backPrice+'₺')
                            $('.reservation-estate-shopping-money').html('1000₺ (Param güvende ücreti)')
                            $('.reservation-tourism-money').html('0₺')
                        }else{
                            var price = reservation.total_price;
                            var backPrice = (price / 2).toFixed(0);
                            backPrice = backPrice.replace(/\D/g, '');
                            backPrice = backPrice.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            var estateBagPrice = ((price / 2) / 10 * 2).toFixed(0);
                            estateBagPrice = estateBagPrice.replace(/\D/g, '');
                            estateBagPrice = estateBagPrice.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            var institutionalPrice = ((price / 2) / 10 * 8).toFixed(0);
                            institutionalPrice = institutionalPrice.replace(/\D/g, '');
                            institutionalPrice = institutionalPrice.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            $('.reservation-back-money').html(backPrice+'₺')
                            $('.reservation-estate-shopping-money').html(estateBagPrice+'₺')
                            $('.reservation-tourism-money').html(institutionalPrice+'₺')
                        }

                        if(reservation.owner.iban){
                            $('.tourism-iban').html(reservation.owner.iban)
                        }else{
                            $('.tourism-iban').addClass('badge badge-phoenix badge-phoenix-danger d-inline-block')
                            $('.tourism-iban').css('text-align','left')
                            $('.tourism-iban').html("Acenteye ait iban bilgisi sistemde kayıtlı değil")
                        }

                        if(reservation.cancel_request){
                            $('.customer-iban').html(reservation.cancel_request.iban)
                            $('.customer-name').html(reservation.cancel_request.iban_name)
                        }

                        $('.cancel-rezervation-admin').attr('href','{{URL::to("/")}}/qR9zLp2xS6y/secured/reservation/unapprove/'+itemId)
                        $('.cancel-rezervation-admin-cancel').attr('href','{{URL::to("/")}}/qR9zLp2xS6y/secured/reservation/delete_cancel_request/'+itemId)
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            })
        })

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

