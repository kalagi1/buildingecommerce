@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="mb-9">
            <div class="row g-3 mb-4">
                <div class="col-auto">
                    <h3 class="mb-0">İade Tablosu</h2>
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
                                        data-sort="refund_no">İade No</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="refund_date">İade Tarihi</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="refund_customer">İade Eden Alıcı</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="refund_amount">Toplam Kapora</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="refund_customer_amount">Alıcının İade Miktarı</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="refund_admin_amount">Emlak Sepettenin Miktarı</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="refund_status">İade Durumu</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="refund_detail">İade Detayı</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $item)
                                    <tr>

                                        <td class="refund_no">{{ $item['refund']->id }}</td>
                                        <td class="refund_date">{{ $item['refund']->created_at }}</td>
                                        <td class="refund_customer">{{ $item['refund']->user->name }}</td>
                                        <td class="refund_amount">{{ $item['order']->amount }}</td>
                                        <td class="refund_customer_amount">{{ $item['recipientAmount'] }}</td>
                                        <td class="refund_admin_amount">{{ $item['refundAmount'] }}</td>

                                        <td class="order_status"><span class="text-success">


                                                {!! [
                                                    '0' =>
                                                        '<span class="badge badge-phoenix fs-10 badge-phoenix-warning"><span class="badge-label">İade Talebi Oluşturuldu</span><span class="ms-1" data-feather="alert-octagon" style="height:12.8px;width:12.8px;"></span></span>',
                                                    '1' =>
                                                        '<span class="badge badge-phoenix fs-10 badge-phoenix-info"><span class="badge-label">İade Talebi Onaylandı</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>',
                                                    '2' =>
                                                        '<span class="badge badge-phoenix fs-10 badge-phoenix-danger"><span class="badge-label">İade Talebi Reddedildi</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span>',
                                                    '3' =>
                                                        '<span class="badge badge-phoenix fs-10 badge-phoenix-success"><span class="badge-label">Geri Ödeme Yapıldı</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>',
                                                ][$item['refund']->status] !!}

                                            </span>
                                        </td>

                                        <td class="order_user align-middle fw-semibold text-body-highlight">
                                            <a href="{{ route('admin.order.detail', ['order_id' => $item['order']->id]) }}"
                                                class="badge badge-phoenix fs--2 badge-phoenix-success">Sipariş
                                                Detayı</a>
                                        </td>



                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    @endsection

    @section('scripts')
    @endsection

    @section('css')
    @endsection
