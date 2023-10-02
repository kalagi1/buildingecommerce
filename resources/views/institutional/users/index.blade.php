@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="mb-9">
                <div id="userList"
                    data-list='{"valueNames":["userName","userEmail","userType","userStatus","userActions"],"page":12,"pagination":true}'>
                    <div class="row justify-content-between mb-4 gx-6 gy-3 align-items-center">
                        <div class="col-auto">
                            <h2 class="mb-0">Kullanıcılar<span class="fw-normal text-700 ms-3">({{ count($users) }})</span>
                            </h2>
                        </div>
                        <div class="col-auto">
                            <div class="col-auto">
                                <a class="btn btn-primary px-5" href="{{ route('institutional.users.create') }}">
                                    <i class="fa-solid fa-plus me-2"></i>Yeni Kullanıcı Ekle
                                </a>
                            </div>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success text-white">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger text-white">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="card shadow-none border border-300 my-4 p-5">
                        <div class="table-responsive scrollbar">
                            <table class="table fs--1 mb-0 border-top border-200">
                                <thead>
                                    <tr>
                                        <th style="width:10%;">ID</th>
                                        <th class="sort white-space-nowrap align-middle ps-0" scope="col"
                                            data-sort="userName">Kullanıcı Adı</th>
                                        <th class="sort white-space-nowrap align-middle ps-0" scope="col"
                                            data-sort="userEmail">E-posta</th>
                                        <th class="sort white-space-nowrap align-middle ps-0" scope="col"
                                            data-sort="userType">Kullanıcı Tipi</th>
                                        <th class="sort white-space-nowrap align-middle ps-0" scope="col"
                                            data-sort="userStatus">Durum</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody class="list" id="user-list-table-body">
                                    @foreach ($users as $key => $user)
                                        <tr class="position-static">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="badge bg-warning"> {{ $user->role->name }}</span>

                                            </td>
                                            <td>
                                                @if ($user->status == 1)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Pasif</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if (in_array('GetUserById', $userPermissions) && in_array('UpdateUser', $userPermissions))
                                                    <a href="{{ route('institutional.users.edit', $user->id) }}"
                                                        class="btn btn-sm btn-primary">Düzenle</a>
                                                @elseif (in_array('GetUserById', $userPermissions))
                                                    <a href="{{ route('institutional.users.edit', $user->id) }}"
                                                        class="btn btn-sm btn-primary">Önizle</a>
                                                @endif
                                                @if (in_array('DeleteUser', $userPermissions))
                                                    <!-- Silme işlemi için modal -->
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $user->id }}">
                                                        Sil
                                                    </button>
                                                @endif




                                                <!-- Silme işlemi için modal -->
                                                <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel{{ $user->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteModalLabel{{ $user->id }}">Kullanıcıyı
                                                                    Sil</h5>
                                                                <button type="button" class="btn p-1"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <svg class="svg-inline--fa fa-xmark fs--1"
                                                                        aria-hidden="true" focusable="false"
                                                                        data-prefix="fas" data-icon="xmark"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 320 512" data-fa-i2svg="">
                                                                        <path fill="currentColor"
                                                                            d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z">
                                                                        </path>
                                                                    </svg><!-- <span class="fas fa-times fs--1"></span> Font Awesome fontawesome.com -->
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="text-700 lh-lg mb-0">Bu kullanıcıyı silmek
                                                                    istediğinizden emin misiniz?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form
                                                                    action="{{ route('institutional.users.destroy', $user->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">Evet,
                                                                        Sil</button>
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
                                    data-list-info="data-list-info">
                                </p>
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

@push('scripts')
@endpush
