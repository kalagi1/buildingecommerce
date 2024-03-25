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
                        <div class="alert alert-success text-white text-white">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger text-white text-white">
                            {{ session('error') }}
                        </div>
                    @endif

                    <style type="text/css">
                        .st0 {
                            fill: #e54242;
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
                            data-list='{"valueNames":["name","email","phone","contact","company","date"],"page":20,"pagination":true}'>


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
                                                    <div
                                                        class="d-flex align-items-center px-1 py-1 bg-danger-100 rounded me-2">
                                                        <span class="text-danger-600 dark__text-danger-300"
                                                            data-feather="grid"></span>
                                                    </div><span>Tarih</span>
                                                </div>
                                            </th>
                                            <th class="sort align-middle ps-4 pe-5 text-uppercase border-end" scope="col"
                                                data-sort="company" style="width:15%;">
                                                <div class="d-inline-flex flex-center">
                                                    <div
                                                        class="d-flex align-items-center px-1 py-1 bg-danger-100 rounded me-2">
                                                        <span class="text-danger-600 dark__text-danger-300"
                                                            data-feather="grid"></span>
                                                    </div><span>İl & İlçe</span>
                                                </div>
                                            </th>
                                            <th class="sort align-middle ps-4 pe-5 text-uppercase border-end" scope="col"
                                                data-sort="contact" style="width:15%;">İşlemler</th>

                                        </tr>
                                    </thead>
                                    <tbody class="list" id="leal-tables-body">
                                        @foreach ($users as $key => $user)
                                            <tr class="hover-actions-trigger btn-reveal-trigger position-static {{ $user->is_blocked == '1' ? 'bg-warning' : '' }}">
                                                <td class="name align-middle white-space-nowrap ps-0">
                                                    <div class="d-flex align-items-center"><a href="#!">
                                                            <div class="avatar avatar-xl me-3"><img class="rounded-circle"
                                                                    src="{{ url('storage/profile_images/' . $user->profile_image) }}"
                                                                    alt="" />
                                                            </div>
                                                        </a>
                                                        <div><a class="fs-0 fw-bold" href="#!">
                                                                {{ $user->name }}

                                                                @if ($user->corporate_account_status)
                                                                    <style type="text/css">
                                                                        .st0 {
                                                                            fill: #e54242;
                                                                        }

                                                                        .st1 {
                                                                            opacity: 0.15;
                                                                        }

                                                                        .st2 {
                                                                            fill: #FFFFFF;
                                                                        }
                                                                    </style>
                                                                  @if ($user->corporate_account_status )
                                                                  <svg id="Layer_1" style="enable-background:new 0 0 120 120;" version="1.1"
                                                                      width="24px" height="24px" viewBox="0 0 120 120" xml:space="preserve"
                                                                      xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                      <g>
                                                                          <path class="st0"
                                                                              d="M99.5,52.8l-1.9,4.7c-0.6,1.6-0.6,3.3,0,4.9l1.9,4.7c1.1,2.8,0.2,6-2.3,7.8L93,77.8c-1.4,1-2.3,2.5-2.7,4.1   l-0.9,5c-0.6,3-3.1,5.2-6.1,5.3l-5.1,0.2c-1.7,0.1-3.3,0.8-4.5,2l-3.5,3.7c-2.1,2.2-5.4,2.7-8,1.2l-4.4-2.6   c-1.5-0.9-3.2-1.1-4.9-0.7l-5,1.2c-2.9,0.7-6-0.7-7.4-3.4l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8   l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8   l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6c1.4-2.7,4.4-4.1,7.4-3.4l5,1.2c1.6,0.4,3.4,0.2,4.9-0.7l4.4-2.6c2.6-1.5,5.9-1.1,8,1.2   l3.5,3.7c1.2,1.2,2.8,2,4.5,2l5.1,0.2c3,0.1,5.6,2.3,6.1,5.3l0.9,5c0.3,1.7,1.3,3.2,2.7,4.1l4.2,2.9C99.7,46.8,100.7,50,99.5,52.8z   " />
                                                                          <g class="st1">
                                                                              <path
                                                                                  d="M43.4,93.5l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4    c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6    c0.8-1.6,2.2-2.7,3.7-3.2c-2.7-0.4-5.4,1-6.6,3.5l-2.3,4.6c-0.8,1.5-2.1,2.7-3.7,3.2l-4.8,1.6c-2.9,1-4.7,3.8-4.4,6.8l0.5,5.1    c0.2,1.7-0.3,3.4-1.4,4.7l-3.2,4c-1.9,2.4-1.9,5.7,0,8.1l3.2,4c1.1,1.3,1.6,3,1.4,4.7l-0.5,5.1c-0.3,3,1.5,5.8,4.4,6.8l4.8,1.6    c1.6,0.5,2.9,1.7,3.7,3.2l2.3,4.6c1.4,2.7,4.4,4.1,7.4,3.4l0.6-0.1C46.3,96.7,44.4,95.5,43.4,93.5z" />
                                                                              <path
                                                                                  d="M60.6,22.5l4.4-2.6c0.4-0.2,0.8-0.4,1.2-0.5c-1.4-0.2-2.9,0.1-4.1,0.8l-4.4,2.6c-0.4,0.2-0.8,0.4-1.2,0.5    C57.9,23.5,59.3,23.3,60.6,22.5z" />
                                                                              <path
                                                                                  d="M81,92c-0.5,0-1,0.1-1.4,0.2l3.6-0.2c0.5,0,0.9-0.1,1.4-0.2L81,92z" />
                                                                              <path
                                                                                  d="M65,98.9l-4.4-2.6c-1.5-0.9-3.2-1.1-4.9-0.7l-0.6,0.1c0.9,0.1,1.7,0.4,2.5,0.8l4.4,2.6c1.7,1,3.6,1.1,5.4,0.5    C66.6,99.6,65.8,99.4,65,98.9z" />
                                                                          </g>
                                                                          <polyline class="st0" points="44,53.6 56.5,67.9 82.1,47.3  " />
                                                                          <path class="st2"
                                                                              d="M53.5,75.3c-1.4,0-2.8-0.6-3.8-1.7L37.2,59.3c-1.8-2.1-1.6-5.2,0.4-7.1c2.1-1.8,5.2-1.6,7.1,0.4l9.4,10.7   l21.9-17.6c2.1-1.7,5.3-1.4,7,0.8c1.7,2.2,1.4,5.3-0.8,7L56.6,74.2C55.7,74.9,54.6,75.3,53.5,75.3z" />
                                                                      </g>
                                                                  </svg>
                                                              @endif
                                                                @endif

                                                            </a>
                                                            <div class="d-flex align-items-center">
                                                                <p class="mb-0 text-1000 fw-semi-bold fs--1 me-2">
                                                                    <span class="badge bg-warning">
                                                                        {{ $user->role->name }}</span><br>

                                                                </p>
                                                                @if (isset($user->parent))
                                                                    <span
                                                                        class="badge badge-phoenix badge-phoenix-primary ">

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
                                                    @if ($user->is_blocked == '1')
                                                        <span class="badge bg-danger">ENGELLENDİ</span>
                                                    @else
                                                        @if ($user->status == 1)
                                                            <span class="badge bg-success">DOĞRULANDI</span>
                                                        @else
                                                            <span class="badge bg-danger">DOĞRULANMADI</span>
                                                        @endif
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
                                                <td
                                                    class="company align-middle white-space-nowrap text-600 ps-4 border-end fw-semi-bold text-1000">
                                                    {{ isset($user->city) && isset($user->district) && $user->city->title ? $user->city->title.' & '.$user->district->ilce_title : "İl Belirtilmemiş" }}
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        @if (in_array('GetUserById', $userPermissions) && in_array('UpdateUser', $userPermissions))
                                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary mr-2">Düzenle</a>
                                                        @elseif (in_array('GetUserById', $userPermissions))
                                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary mr-2">Önizle</a>
                                                        @endif
                                                    
                                                        @if (in_array('DeleteUser', $userPermissions))
                                                            <!-- Silme işlemi için modal -->
                                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal{{ $user->id }}">
                                                                Sil
                                                            </button>
                                                        @endif
                                                    </div>
                                                    

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
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Kullanıcı Adı">
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
                            <input type="text" name="email" id="email" class="form-control"
                                placeholder="E-Posta Adresi">
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
