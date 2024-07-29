
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
                <li class="tab-item {{ $loop->first ? 'active' : '' }}" id="{{ $tab['id'] }}-tab">
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
                    <div class="project-table-content">
                        @foreach ($reservations as $order)
                            @php
                                $housing = App\Models\Housing::with('user')->find($order->housing_id);
                                $image = json_decode($housing->housing_type_data ?? '[]')->image ?? null;
                            @endphp
                            <ul class="list-unstyled d-flex housing-item">
                                <li class="order_no" style="width: 10%">{{ $order->key }}</li>
                                <li class="order_image" style="width: 20%">
                                <div class="avatar avatar-m">
                            <img class="rounded-circle" src="https://private.emlaksepette.com/storage/profile_images/1722239152_profile_image.jpg" alt="" style="width:35px;height:35px">
                        </div>
                                    <img src="{{ asset('housing_images/' . $image) }}" width="100px" style="object-fit: contain;" />
                                    <br>
                                    {{ $housing->title }}
                                </li>
                                <li class="order_amount" style="width: 10%">
                                    {{ number_format($order->total_price, 0, ',', '.') }} ₺
                                </li>
                                {{-- <li class="order_amount" style="width: 15%">
                                    {{ number_format(($order->total_price / 2) + $order->money_is_safe, 0, ',', '.') }}₺
                                    ({{ $order->money_is_safe }}₺ Param Güvende Ödemesi)
                                </li> --}}
                                <li class="order_date" style="width: 10%">
                                    Giriş: {{ \Carbon\Carbon::parse($order->check_in_date)->format('d.m.Y') }}
                                </li>
                                <li class="order_date" style="width: 10%">
                                    Çıkış: {{ \Carbon\Carbon::parse($order->check_out_date)->format('d.m.Y') }}
                                </li>
                                {{-- <li class="order_date" style="width: 10%">
                                    <span style="color:#EA2B2E; font-weight:600;font-size:16px">
                                        <i class="fas fa-calendar"></i>
                                        {{ \Carbon\Carbon::parse($order->check_in_date)->diffInDays(\Carbon\Carbon::parse($order->check_out_date)) }} gün
                                    </span>
                                </li> --}}
                                <li class="order_date" style="width: 10%">
                                    {{ $order->person_count }} Kişi
                                </li>
                                <li class="order_status" style="width: 10%">
                                    {!! [
                                        '0' => '<span class="text-warning">Rezerve Edildi</span>',
                                        '1' => '<span class="text-success">Rezervasyon Onaylandı</span>',
                                        '2' => '<span class="text-danger">Ödeme Reddedildi</span>',
                                        '3' => '<span class="text-danger">Rezervasyon iptal edildi</span>',
                                    ][$order->status] !!}
                                </li>
                                {{-- <li class="order_user" style="width: 15%">
                                    {{ $order->user->name }} <br>
                                    {{ $order->user->email }}
                                </li>
                                <li class="order_user" style="width: 15%">
                                    {{ $order->owner->name }} <br>
                                    {{ $order->owner->email }}
                                </li> --}}
                                 <li style="width: 5%">
                                            <span class="project-table-content-actions-button" data-toggle="popover-{{ $order->id }}">
                                                <i class="fa fa-chevron-down"></i>
                                            </span>
                                        </li>
                            </ul>

                                 <div class="popover-project-actions d-none" id="popover-{{ $order->id }}">
                                        <ul class="list-unstyled">
                                                <li>
                                    <a href="{{ route('institutional.reservation.order.detail', ['reservation_id' => $order->id]) }}" >Rezervasyon Detayı</a>
                                                </li>


                                        </ul>
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
