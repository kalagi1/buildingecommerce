@extends('admin.layouts.master')

@section('content')
<div class="content">
    <div class="row">
        <div class="mb-9">
            <div id="emailTemplateList"
                data-list='{"valueNames":["id","name","subject","action"],"page":12,"pagination":true}'>
                <div class="row justify-content-between mb-4 gx-6 gy-3 align-items-center">
                    <div class="col-auto">
                        <h2 class="mb-0">Ödeme Kayıtları<span class="fw-normal text-700 ms-3">({{ count($tempPayments) }})</span>
                        </h2>
                    </div>
                </div>
                @if (session('success'))
                    <div class="alert alert-success text-white text-white">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger text-white text-white">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="card shadow-none border border-300 my-4 p-5">
                    <div class="table-responsive scrollbar">
                        <table class="table fs--1 mb-0 border-top border-200">
                            <thead>
                                <tr>
                                    <th>İşlemi yapan kişinin adı</th>
                                    <th>Yapılan İşlem Tipi</th>
                                    <th>Yapılan işlemin açıklaması </th>
                                    <th>İşlem Durumu </th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="email-template-list-table-body">
                                @foreach ($tempPayments as $tempPayment)
                                    <tr class="position-static">
                                        <td>{{ $tempPayment->user->name }}</td>
                                        <td>{{ $tempPayment->transactionTypes[$tempPayment->transaction_type] }}</td>
                                        <td>{{ $tempPayment->description }}</td>
                                        <td>
                                            @if($tempPayment->status == 0)
                                                <span class="badge badge-phoenix badge-phoenix-warning">İşlem Yapılmadı</span> 
                                            @elseif($tempPayment->status == 1)
                                                <span class="badge badge-phoenix badge-phoenix-warning">Onaylandı</span> 
                                            @else 
                                                <span class="badge badge-phoenix badge-phoenix-danger">Reddedildi</span> 
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $tempPayment->id }}">Ödemeyi Onayla</button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $tempPayment->id }}">Ödemeyi Reddet</button>

                                            <!-- Silme işlemi için modal -->
                                            <div class="modal fade" id="deleteModal{{ $tempPayment->id }}" tabindex="-1"
                                                aria-labelledby="deleteModalLabel{{ $tempPayment->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="deleteModalLabel{{ $tempPayment->id }}">Ödemeyi Reddet</h5>
                                                            <button type="button" class="btn p-1"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="svg-inline--fa fa-xmark fs--1"
                                                                    aria-hidden="true" focusable="false"
                                                                    data-prefix="fas" data-icon="xmark" page="img"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 320 512" data-fa-i2svg="">
                                                                    <path fill="currentColor"
                                                                        d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z">
                                                                    </path>
                                                                </svg><!-- <span class="fas fa-times fs--1"></span> Font Awesome fontawesome.com -->
                                                            </button>
                                                        </div>
                                                        
                                                        <form
                                                        action="{{ route('admin.payment.temp.change.status', $tempPayment->id) }}"
                                                        method="POST" class="d-inline">
                                                        <div class="modal-body">
                                                            <p class="text-700 lh-lg mb-0">Ödeyi reddetmek istediğine emin misin?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="">
                                                                <button type="submit" class="btn btn-danger">Evet,
                                                                    Reddet</button>
                                                                </form>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">İptal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Silme işlemi için modal -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div
                        class="d-flex flex-wrap align-items-center justify-content-between py-3 pe-0 fs--1 border-bottom border-200">
                        <div class="d-flex">
                            <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900"
                                data-list-info="data-list-info"></p>
                        </div>
                        <div class="d-flex"><button class="page-link" data-list-pagination="prev"><span
                                    class="fas fa-chevron-left"></span></button>
                            <ul class="mb-0 pagination"></ul><button class="page-link pe-0"
                                data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
