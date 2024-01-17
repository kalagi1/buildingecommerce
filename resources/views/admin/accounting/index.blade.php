@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="mb-9">
            <div class="row g-3 mb-4">
                <div class="col-auto">
                    <h2 class="mb-0">Emlak Sepette Muhasabe Yönetimi</h2>
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
                                        data-sort="order_no">Sipariş Kodu</th>
                                        <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_date">Sipariş Tarihi</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_amount">Ödenen Kapora Bedeli</th>
                                
                                </tr>
                            </thead>
                            <tbody class="list" id="order-table-body">
                                @foreach ($mergedArray as $item)
                                    <tr>
                                        <td>{{ $item->cart->key }}</td>
                                        <td>{{ $item->cart->amount }}</td>
                                        <td>{{ $item->cart->created_at }}</td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection

@section('css')
@endsection
