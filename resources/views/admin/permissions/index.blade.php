@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="mb-9">
                <div id="permissionList"
                    data-list='{"valueNames":["id","key","description","title","is_active","action"],"page":12,"pagination":true}'>
                    <div class="row justify-content-between mb-4 gx-6 gy-3 align-items-center">
                        <div class="col-auto">
                            <h3 class="mb-0">İzinler<span class="fw-normal text-700 ms-3">({{ count($permissions) }})</span>
                            </h2>
                        </div>
                        <div class="col-auto">
                            <div class="col-auto"><a class="btn btn-primary px-5"
                                    href="{{ route('admin.permissions.create') }}"><i class="fa-solid fa-plus me-2"></i>Yeni
                                    Ekle</a></div>
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
                                        <th style="width:10%;">ID</th>
                                        <th class="sort white-space-nowrap align-middle ps-0" scope="col"
                                            data-sort="key">ANAHTAR</th>
                                        <th class="sort white-space-nowrap align-middle ps-0" scope="col"
                                            data-sort="is_active">AKTİF</th>
                                        <th>İŞLEMLER</th>
                                    </tr>
                                </thead>
                                <tbody class="list" id="permission-list-table-body">
                                    @foreach ($permissions as $key => $permission)
                                        <tr class="position-static">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $permission->key }}</td>
                                            <td>
                                                @if ($permission->is_active)
                                                    <span class="badge bg-success">Evet</span>
                                                @else
                                                    <span class="badge bg-danger">Hayır</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (in_array('GetPermissionById', $userPermissions) && in_array('UpdatePermission', $userPermissions))
                                                    <a href="{{ route('admin.permissions.edit', $permission->id) }}"
                                                        class="btn btn-sm btn-primary">Güncelle</a>
                                                @elseif (in_array('GetPermissionById', $userPermissions))
                                                    <a href="{{ route('admin.permissions.edit', $permission->id) }}"
                                                        class="btn btn-sm btn-primary">Önizle</a>
                                                @endif
                                                @if (in_array('DeletePermission', $userPermissions))
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $permission->id }}">Delete</button>
                                                @endif

                                                <!-- Silme işlemi için modal -->
                                                <div class="modal fade" id="deleteModal{{ $permission->id }}" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel{{ $permission->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteModalLabel{{ $permission->id }}">Sil</h5>
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
                                                            <div class="modal-body">
                                                                <p class="text-700 lh-lg mb-0">Silmek istediğinize emin
                                                                    misiniz ?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form
                                                                    action="{{ route('admin.permissions.destroy', $permission->id) }}"
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
