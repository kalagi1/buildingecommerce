@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="mb-9">
                <div id="userList">
                    <div class="row justify-content-between mb-4 gx-6 gy-3 align-items-center mt-5">
                        <div class="col-auto">
                            <h2 class="mb-0">Üyeler

                            </h2>

                        </div>
                        <div class="col-auto">
                            <a class="btn btn-primary px-5" href="{{ route('admin.users.create') }}">
                                <i class="fa-solid fa-plus me-2"></i>Yeni Üye Ekle
                            </a> <button class="btn px-3 btn-phoenix-secondary" type="button" id="filterButton"
                                data-bs-toggle="modal" data-bs-target="#filterModal" data-boundary="window"
                                aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><svg
                                    class="svg-inline--fa fa-filter text-primary" data-fa-transform="down-3"
                                    aria-hidden="true" focusable="false" data-prefix="fas" data-icon="filter" role="img"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""
                                    style="transform-origin: 0.5em 0.6875em;">
                                    <g transform="translate(256 256)">
                                        <g transform="translate(0, 96)  scale(1, 1)  rotate(0 0 0)">
                                            <path fill="currentColor"
                                                d="M3.853 54.87C10.47 40.9 24.54 32 40 32H472C487.5 32 501.5 40.9 508.1 54.87C514.8 68.84 512.7 85.37 502.1 97.33L320 320.9V448C320 460.1 313.2 471.2 302.3 476.6C291.5 482 278.5 480.9 268.8 473.6L204.8 425.6C196.7 419.6 192 410.1 192 400V320.9L9.042 97.33C-.745 85.37-2.765 68.84 3.854 54.87L3.853 54.87z"
                                                transform="translate(-256 -256)"></path>
                                        </g>
                                    </g>
                                </svg><!-- <span class="fa-solid fa-filter text-primary" data-fa-transform="down-3"></span> Font Awesome fontawesome.com --></button>

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
                        .st0 {
                            fill: rgb(44, 191, 247);
                        }

                        .st1 {
                            opacity: 0.15;
                        }

                        .st2 {
                            fill: #FFFFFF;
                        }
                    </style>

                    <div class="pb-6">
                        <div id="lealsTable"
                            data-list='{"valueNames":["name","email","phone","contact","company","date"],"page":10,"pagination":true}'>


                            <div class="table-responsive scrollbar mx-n1 px-1 border-top">
                                <table class="table fs--1 mb-0 leads-table">
                                    <thead>
                                        <tr>
                                            <th class="sort white-space-nowrap align-middle text-uppercase ps-0"
                                                scope="col" data-sort="name" style="width:25%;">Kullanıcı Adı</th>
                                            <th class="sort align-middle ps-4 pe-5 text-uppercase border-end" scope="col"
                                                data-sort="email" style="width:15%;">
                                                <div class="d-inline-flex flex-center">
                                                    <div
                                                        class="d-flex align-items-center px-1 py-1 bg-success-100 rounded me-2">
                                                        <span class="text-success-600 dark__text-success-300"
                                                            data-feather="mail"></span>
                                                    </div><span>Email</span>
                                                </div>
                                            </th>

                                            <th class="sort align-middle ps-4 pe-5 text-uppercase border-end" scope="col"
                                                data-sort="contact" style="width:15%;">
                                                <div class="d-inline-flex flex-center">
                                                    <div
                                                        class="d-flex align-items-center px-1 py-1 bg-info-100 rounded me-2">
                                                        <span class="text-info-600 dark__text-info-300"
                                                            data-feather="user"></span>
                                                    </div><span>Durum</span>
                                                </div>
                                            </th>
                                            <th class="sort align-middle ps-4 pe-5 text-uppercase border-end" scope="col"
                                                data-sort="company" style="width:15%;">
                                                <div class="d-inline-flex flex-center">
                                                    <div
                                                        class="d-flex align-items-center px-1 py-1 bg-warning-100 rounded me-2">
                                                        <span class="text-warning-600 dark__text-warning-300"
                                                            data-feather="grid"></span>
                                                    </div><span>Belgeler</span>
                                                </div>
                                            </th>
                                            <th class="sort align-middle ps-4 pe-5 text-uppercase border-end" scope="col"
                                                data-sort="company" style="width:15%;">
                                                <div class="d-inline-flex flex-center">
                                                    <span>Tarih</span>
                                                </div>
                                            </th>
                                            <th class="sort align-middle ps-4 pe-5 text-uppercase border-end" scope="col"
                                                data-sort="contact" style="width:15%;">İşlemler</th>

                                        </tr>
                                    </thead>
                                    <tbody class="list" id="leal-tables-body">
                                        @foreach ($users as $key => $user)
                                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                                <td class="name align-middle white-space-nowrap ps-0">
                                                    <div class="d-flex align-items-center"><a href="#!">
                                                            <div class="avatar avatar-xl me-3"><img class="rounded-circle"
                                                                    src="{{ url('storage/profile_images/' . $user->profile_image) }}"
                                                                    alt="" />
                                                            </div>
                                                        </a>
                                                        <div><a class="fs-0 fw-bold" href="#!">
                                                                {{ $user->name }}</a>
                                                            <div class="d-flex align-items-center">
                                                                <p class="mb-0 text-1000 fw-semi-bold fs--1 me-2">
                                                                    <span class="badge bg-warning">
                                                                        {{ $user->role->name }}</span><br>

                                                                </p>
                                                                @if (isset($user->parent))
                                                                    <span
                                                                        class="badge badge-phoenix badge-phoenix-primary ">
                                                                        Kurumsal Hesap:
                                                                        {{ $user->parent->name }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td
                                                    class="email align-middle white-space-nowrap fw-semi-bold ps-4 border-end">
                                                    <a class="text-1000"
                                                        href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                                </td>
                                                <td
                                                    class="contact align-middle white-space-nowrap ps-4 border-end fw-semi-bold text-1000">
                                                    @if ($user->status == 1)
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-danger">Pasif</span>
                                                    @endif
                                                </td>
                                                <td
                                                    class="company align-middle white-space-nowrap text-600 ps-4 border-end fw-semi-bold text-1000">
                                                    <a
                                                        href="{{ route('admin.user.show-corporate-account', ['user' => $user->id]) }}">İncele</a>
                                                </td>
                                                <td
                                                    class="company align-middle white-space-nowrap text-600 ps-4 border-end fw-semi-bold text-1000">
                                                    {{ $user->created_at->locale('tr')->isoFormat('D MMM, HH:mm') }}

                                                </td>
                                                <td>
                                                    @if (in_array('GetUserById', $userPermissions) && in_array('UpdateUser', $userPermissions))
                                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                                            class="btn btn-sm btn-primary">Düzenle</a>
                                                    @elseif (in_array('GetUserById', $userPermissions))
                                                        <a href="{{ route('admin.users.edit', $user->id) }}"
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
                                                    <div class="modal fade" id="deleteModal{{ $user->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="deleteModalLabel{{ $user->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="deleteModalLabel{{ $user->id }}">
                                                                        Kullanıcıyı
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
                                                                        <button type="submit"
                                                                            class="btn btn-danger">Evet,
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
                            <div class="row align-items-center justify-content-end py-4 pe-0 fs--1">
                                <div class="col-auto d-flex">
                                    <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900"
                                        data-list-info="data-list-info"></p><a class="fw-semi-bold" href="#!"
                                        data-list-view="*">View all<span class="fas fa-angle-right ms-1"
                                            data-fa-transform="down-1"></span></a><a class="fw-semi-bold d-none"
                                        href="#!" data-list-view="less">View Less<span
                                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                                </div>
                                <div class="col-auto d-flex"><button class="page-link" data-list-pagination="prev"><span
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
    </div>
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Sonuçları Filtrele</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="filterForm">
                        <div class="mb-3">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Kullanıcı Adı">
                        </div>
                        <div class="mb-3">
                            <select name="role" id="role" class="form-control">
                                <option value="">Tüm Roller</option>
                                <option value="2">Kurumsal</option>
                                <option value="1">Bireysel</option>
                                <option value="3">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="email" id="email" class="form-control" placeholder="E-Posta Adresi">
                        </div>
                        <button type="submit" class="btn btn-primary">Filtrele</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
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
        #table_filter {
            margin-bottom: 20px;
        }
    </style>
@endsection
