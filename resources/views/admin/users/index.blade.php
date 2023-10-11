@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="mb-9">
                <div id="userList">
                    <div class="row justify-content-between mb-4 gx-6 gy-3 align-items-center">
                        <div class="col-auto">
                            <h2 class="mb-0">Üyeler <span class="fw-normal text-700 ms-3">({{ count($users) }})</span>
                            </h2>
                        </div>
                        <div class="col-auto">
                            <div class="col-auto">
                                <a class="btn btn-primary px-5" href="{{ route('admin.users.create') }}">
                                    <i class="fa-solid fa-plus me-2"></i>Yeni Üye Ekle
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

                    <style type="text/css">
                        .st0{fill:rgb(44,191,247);}
                        .st1{opacity:0.15;}
                        .st2{fill:#FFFFFF;}
                    </style>

                    <div class="card shadow-none border border-300 my-4 p-5">
                        <div class="table-responsive scrollbar">
                            <table id="table" data-order='[[ 0, "desc" ]]' class="fs--1 mb-0 border-top border-200">
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
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="list" id="user-list-table-body">
                                    @foreach ($users as $key => $user)
                                        <tr class="position-static">
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                {{ $user->name }}
                                                @if ($user->type == 2)
                                                 <svg id="Layer_1" style="enable-background:new 0 0 120 120;" version="1.1" width="24px" height="24px" viewBox="0 0 120 120" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path class="st0" d="M99.5,52.8l-1.9,4.7c-0.6,1.6-0.6,3.3,0,4.9l1.9,4.7c1.1,2.8,0.2,6-2.3,7.8L93,77.8c-1.4,1-2.3,2.5-2.7,4.1   l-0.9,5c-0.6,3-3.1,5.2-6.1,5.3l-5.1,0.2c-1.7,0.1-3.3,0.8-4.5,2l-3.5,3.7c-2.1,2.2-5.4,2.7-8,1.2l-4.4-2.6   c-1.5-0.9-3.2-1.1-4.9-0.7l-5,1.2c-2.9,0.7-6-0.7-7.4-3.4l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8   l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8   l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6c1.4-2.7,4.4-4.1,7.4-3.4l5,1.2c1.6,0.4,3.4,0.2,4.9-0.7l4.4-2.6c2.6-1.5,5.9-1.1,8,1.2   l3.5,3.7c1.2,1.2,2.8,2,4.5,2l5.1,0.2c3,0.1,5.6,2.3,6.1,5.3l0.9,5c0.3,1.7,1.3,3.2,2.7,4.1l4.2,2.9C99.7,46.8,100.7,50,99.5,52.8z   "/><g class="st1"><path d="M43.4,93.5l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4    c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6    c0.8-1.6,2.2-2.7,3.7-3.2c-2.7-0.4-5.4,1-6.6,3.5l-2.3,4.6c-0.8,1.5-2.1,2.7-3.7,3.2l-4.8,1.6c-2.9,1-4.7,3.8-4.4,6.8l0.5,5.1    c0.2,1.7-0.3,3.4-1.4,4.7l-3.2,4c-1.9,2.4-1.9,5.7,0,8.1l3.2,4c1.1,1.3,1.6,3,1.4,4.7l-0.5,5.1c-0.3,3,1.5,5.8,4.4,6.8l4.8,1.6    c1.6,0.5,2.9,1.7,3.7,3.2l2.3,4.6c1.4,2.7,4.4,4.1,7.4,3.4l0.6-0.1C46.3,96.7,44.4,95.5,43.4,93.5z"/><path d="M60.6,22.5l4.4-2.6c0.4-0.2,0.8-0.4,1.2-0.5c-1.4-0.2-2.9,0.1-4.1,0.8l-4.4,2.6c-0.4,0.2-0.8,0.4-1.2,0.5    C57.9,23.5,59.3,23.3,60.6,22.5z"/><path d="M81,92c-0.5,0-1,0.1-1.4,0.2l3.6-0.2c0.5,0,0.9-0.1,1.4-0.2L81,92z"/><path d="M65,98.9l-4.4-2.6c-1.5-0.9-3.2-1.1-4.9-0.7l-0.6,0.1c0.9,0.1,1.7,0.4,2.5,0.8l4.4,2.6c1.7,1,3.6,1.1,5.4,0.5    C66.6,99.6,65.8,99.4,65,98.9z"/></g><polyline class="st0" points="44,53.6 56.5,67.9 82.1,47.3  "/><path class="st2" d="M53.5,75.3c-1.4,0-2.8-0.6-3.8-1.7L37.2,59.3c-1.8-2.1-1.6-5.2,0.4-7.1c2.1-1.8,5.2-1.6,7.1,0.4l9.4,10.7   l21.9-17.6c2.1-1.7,5.3-1.4,7,0.8c1.7,2.2,1.4,5.3-0.8,7L56.6,74.2C55.7,74.9,54.6,75.3,53.5,75.3z"/></g></svg>
                                                 @endif
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="badge bg-warning"> {{ $user->role->name }}</span><br>
                                                @if (isset($user->parent))
                                                    <span class="badge bg-info "> Kurumsal Hesap:
                                                        {{ $user->parent->name }}</span>
                                                @endif
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
                                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                                        class="btn btn-sm btn-primary">Düzenle</a>
                                                @elseif (in_array('GetUserById', $userPermissions))
                                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                                        class="btn btn-sm btn-primary">Önizle</a>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('admin.user.show-corporate-account', ['user' => $user->id]) }}" class="btn btn-info">Belgeleri Gör</a>
                                            </td>

                                            <td>
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
                                                                    action="{{ route('admin.users.destroy', $user->id) }}"
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
                        <!--<div
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
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        let table = new DataTable('#table', {
            language: { 
                url: '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json' ,
            },
});
    </script>
@endsection
