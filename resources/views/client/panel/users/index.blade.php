@extends('client.layouts.masterPanel')

@section('content')
    @if (!in_array('GetUsers', $userPermissions))
        @php
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        @endphp
    @endif
    <div class="table-breadcrumb">
        <ul>
            <li>
                Hesabım
            </li>
            <li>
                Alt Kullanıcıları Listele
            </li>
        </ul>

    </div>
    <section>
        <div class="single homes-content details mb-30">

            <div class="container">

                @if (in_array('CreateUser', $userPermissions))
                    <a class="btn btn-primary px-5 mb-3" style="float: right" href="{{ route('institutional.users.create') }}">
                        <i class="fa fa-plus me-2 mr-2"></i>Yeni Ekle
                    </a>
                @endif
                <table class="table fs--1 mb-0 border-top border-200" id="sortable-container2">
                    <thead>
                        <tr>
                            <th></th>
                            <th style="width:10%;">ID</th>
                            <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="userName">
                                Kullanıcı Adı</th>
                            <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="userEmail">
                                E-posta</th>
                            <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="userType">
                                Kullanıcı Tipi</th>
                            <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="userStatus">
                                Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="user-list-table-body">
                        @foreach ($users as $key => $user)
                            <tr class="position-static user-item" data-order="{{ $user->order }}"
                                data-id="{{ $user->id }}">
                                <td><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                        stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                        class="css-i6dzq1">
                                        <polyline points="5 9 2 12 5 15"></polyline>
                                        <polyline points="9 5 12 2 15 5"></polyline>
                                        <polyline points="15 19 12 22 9 19"></polyline>
                                        <polyline points="19 9 22 12 19 15"></polyline>
                                        <line x1="2" y1="12" x2="22" y2="12"></line>
                                        <line x1="12" y1="2" x2="12" y2="22"></line>
                                    </svg></td>
                                <td>{{ $user->order }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="text-warning "> {{ $user->role->name }}</span>

                                </td>
                                <td>
                                    @if ($user->status == 1)
                                        <span class="text-success">Hesap Doğrulandı</span>
                                    @elseif($user->status == 0)
                                        <span class="text-warning ">Hesap Doğrulanmadı</span>
                                    @else
                                        <span class="text-danger ">Hesap Engellendi</span>
                                    @endif
                                </td>

                                <td>
                                    @if (in_array('GetUserById', $userPermissions) && in_array('UpdateUser', $userPermissions))
                                        <a href="{{ route('institutional.users.edit', ['user' => hash_id($user->id)]) }}"
                                            class="btn btn-sm btn-primary"><svg viewBox="0 0 24 24" width="18"
                                                height="18" stroke="currentColor" stroke-width="2" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                            </svg></a>
                                    @elseif (in_array('GetUserById', $userPermissions))
                                        <a href="{{ route('institutional.users.edit', ['user' => hash_id($user->id)]) }}"
                                            class="btn btn-sm btn-primary"><svg viewBox="0 0 24 24" width="18"
                                                height="18" stroke="currentColor" stroke-width="2" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg></a>
                                    @endif
                                    @if (in_array('DeleteUser', $userPermissions))
                                        <!-- Silme işlemi için modal -->
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $user->id }}">
                                            <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor"
                                                stroke-width="2" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round" class="css-i6dzq1">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path
                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                </path>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                            </svg>
                                        </button>
                                    @endif




                                    <!-- Silme işlemi için modal -->
                                    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">
                                                        Kullanıcıyı
                                                        Sil</h5>
                                                    <button type="button" class="btn p-1" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true"
                                                            focusable="false" data-prefix="fas" data-icon="xmark"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                                            data-fa-i2svg="">
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
                                                    <form action="{{ route('institutional.users.destroy', $user->id) }}"
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
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortable = new Sortable(document.getElementById('user-list-table-body'), {
                animation: 150,
                onUpdate: function(evt) {
                    const item = evt.item;
                    const orders = Array.from(item.parentNode.getElementsByClassName('user-item'))
                        .map(function(element) {
                            return {
                                id: $(element).data('id'),
                                order: $(element).index() + 1
                            };
                        });

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('institutional.users.update.order') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            orders: orders
                        },
                        success: function(response) {
                            location.reload();
                            console.log(response);
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                },
            });
        });
    </script>
@endsection
