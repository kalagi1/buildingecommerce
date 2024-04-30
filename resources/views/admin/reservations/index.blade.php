@extends('admin.layouts.master')

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
                                                data-sort="order_user">Onay</th>
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
                                                    <td class="order_user">
                                                        {{ $order->owner->name }} <br>
                                                        {{ $order->owner->email }}</td>
                                                        <td class="order_details">
                                                            @if ($order->status == 0 || $order->status == 2)
                                                                <!-- Eğer sipariş durumu 0 veya 2 ise -->
                                                                <a onclick="return confirm('Rezervasyonu onaylamak istediğinize emin misiniz?')" href="{{ route('admin.approve-reservation', ['reservation' => $order->id]) }}" class="badge badge-phoenix badge-phoenix-success">Rezervasyonu onayla</a>
                                                                <!-- Ayrıca, rezervasyonu onaylamadan iptal etmek için bağlantı ekle -->
                                                                <a onclick="return confirm('Rezervasyonu iptal etmek istediğinize emin misiniz?')" href="{{ route('admin.unapprove-reservation', ['reservation' => $order->id]) }}" class="badge badge-phoenix badge-phoenix-danger">Rezervasyonu reddet</a>
                                                            @else
                                                                <!-- Diğer durumlarda, yani sipariş durumu 0 veya 2 değilse -->
                                                                <a onclick="return confirm('Rezervasyonu iptal etmek istediğinize emin misiniz?')" href="{{ route('admin.unapprove-reservation', ['reservation' => $order->id]) }}" class="badge badge-phoenix badge-phoenix-danger">Rezervasyonu reddet</a>
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
                                                data-sort="order_user">Onay</th>
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
                                                            <td class="order_details">
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
                                                data-sort="order_user">Onay</th>
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
                                                    <td class="order_details">
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
                                                data-sort="order_user">Onay</th>
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
                                                            <td class="order_details">
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
                                            data-sort="order_user">Onay</th>
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
