@extends('client.layouts.masterPanel')

@section('content')
    @if (!in_array('GetUsers', $userPermissions))
        @php
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        @endphp
    @endif
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="table-breadcrumb">
            <ul>
                <li>Hesabım</li>
                <li> Alt Kullanıcıları Listele
                </li>
            </ul>
        </div>
        @if (in_array('CreateUser', $userPermissions))
            <a class="btn btn-primary px-5" href="{{ route('institutional.users.create') }}">
                <i class="fa fa-plus me-2 mr-2"></i>Yeni Ekle
            </a>
        @endif
    </div>
    <section>
        <div class="alert alert-info">
            Alt kullanıcıları sürükleyip bırakarak sıralayabilirsiniz. Bu sıralama mağazanızda belirlediğiniz sırada görünecektir.
        </div>
        <div id="user-list-table-body">
            @foreach ($users as $key => $user)
                <div class="project-table-content user-item" data-order="{{ $user->order }}" data-id="{{ $user->id }}">
                    <ul>
                        <li style="width: 5%;"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                class="css-i6dzq1">
                                <polyline points="5 9 2 12 5 15"></polyline>
                                <polyline points="9 5 12 2 15 5"></polyline>
                                <polyline points="15 19 12 22 9 19"></polyline>
                                <polyline points="19 9 22 12 19 15"></polyline>
                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                <line x1="12" y1="2" x2="12" y2="22"></line>
                            </svg></li>
                        <li style="width: 5%;">{{ $user->order }}</li>
                        <li style="width: 55%; align-items: flex-start;">
                            <div>
                                <p class="project-table-content-title">{{ $user->name }}</p>
                                <span>{{ $user->email }}</span>
                            </div>
                        </li>
                        <li style="width: 20%;">
                            <span> {{ $user->role->name }}</span>
                        </li>
                        <li style="width: 20%;">
                            @if ($user->status == 1)
                                <span class="text-success">Hesap Doğrulandı</span>
                            @elseif($user->status == 0)
                                <span class="text-warning ">Hesap Doğrulanmadı</span>
                            @else
                                <span class="text-danger ">Hesap Engellendi</span>
                            @endif
                        </li>
                        <li style="width: 5%;"><span class="project-table-content-actions-button"
                                data-toggle="popover-{{ $user->id }}"><i class="fa fa-chevron-down"></i></span>

                        </li>
                    </ul>
                    <div class="popover-project-actions d-none" id="popover-{{ $user->id }}">
                        <ul>
                            @if (in_array('UpdateUser', $userPermissions))
                                <li><a href="{{ route('institutional.users.edit', hash_id($user->id)) }}">
                                        AL Kullanıcıyı Düzenle</a></li>
                            @elseif (in_array('GetUserById', $userPermissions))
                                <li><a href="{{ route('institutional.users.edit', hash_id($user->id)) }}">Önizle</a>
                                </li>
                            @endif
                            @if (in_array('DeleteUser', $userPermissions))
                                <li data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">Sil
                                </li>
                            @endif
                        </ul>
                    </div>

                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                    aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">Sil</h5>
                                <button type="button" class="btn p-1" data-bs-dismiss="modal" aria-label="Close">
                                    <svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false"
                                        data-prefix="fas" data-icon="xmark" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z">
                                        </path>
                                    </svg><!-- <span class="fas fa-times fs--1"></span> Font Awesome fontawesome.com -->
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="text-700 lh-lg mb-0">Silmek istediğinize emin misiniz?</p>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('institutional.users.destroy', hash_id($user->id)) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Evet, Sil</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </section>
@endsection

@section('scripts')
    <script src="https://unpkg.com/@material-ui/core@latest/umd/material-ui.development.js"></script>
    <script>
        $(document).ready(function() {
            $('.project-table-content-actions-button').on('click', function() {
                var targetId = $(this).data('toggle');
                var $popover = $('#' + targetId);

                // Hide other popovers
                $('.popover-project-actions').not($popover).addClass('d-none');

                // Toggle current popover
                $popover.toggleClass('d-none');
            });

            // Close popover when clicking outside
            $(document).on('click', function(event) {
                if (!$(event.target).closest('.project-table-content').length) {
                    $('.popover-project-actions').addClass('d-none');
                }
            });
        });
    </script>
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
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                text: "Sıralama başarıyla güncellendi",
                                showClass: {
                                    popup: `
      animate__animated
      animate__fadeInUp
      animate__faster
    `
                                },
                                hideClass: {
                                    popup: `
      animate__animated
      animate__fadeOutDown
      animate__faster
    `
                                },
                                showConfirmButton: false,
                                timer: 2000
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
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

@section('styles')
    <style>
        .table-breadcrumb {
            margin-bottom: 0 !important
        }
    </style>
@endsection
