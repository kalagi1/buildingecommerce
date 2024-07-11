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
                <li>Kullanıcı Tiplerini Listele</li>
            </ul>
        </div>
        @if (in_array('CreateRole', $userPermissions))
            <a class="btn btn-primary px-5" href="{{ route('institutional.roles.create') }}">
                <i class="fa fa-plus me-2 mr-2"></i>Yeni Ekle
            </a>
        @endif
    </div>
    <section>

        @foreach ($roles as $key => $role)
            <div class="project-table-content">
                <ul>
                    <li style="width: 5%;">{{ $key + 1 }}</li>
                    <li style="width: 90%; align-items: flex-start;">
                        <div>
                            <p class="project-table-content-title">{{ $role->name }}</p>
                        </div>
                    </li>
                    <li style="width: 5%;"><span class="project-table-content-actions-button"
                            data-toggle="popover-{{ $role->id }}"><i class="fa fa-chevron-down"></i></span>

                    </li>
                </ul>
                <div class="popover-project-actions d-none" id="popover-{{ $role->id }}">
                    <ul>
                        @if (in_array('UpdateRole', $userPermissions))
                            <li><a href="{{ route('institutional.roles.edit', hash_id($role->id)) }}">
                                    Rolü Düzenle</a></li>
                        @elseif (in_array('GetRoleById', $userPermissions))
                            <li><a href="{{ route('institutional.roles.edit', hash_id($role->id)) }}">Önizle</a>
                            </li>
                        @endif
                        @if (in_array('DeleteRole', $userPermissions))
                            <li data-bs-toggle="modal" data-bs-target="#deleteModal{{ $role->id }}">Sil
                            </li>
                        @endif
                    </ul>
                </div>

            </div>

            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal{{ $role->id }}" tabindex="-1"
                aria-labelledby="deleteModalLabel{{ $role->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{ $role->id }}">Sil</h5>
                            <button type="button" class="btn p-1" data-bs-dismiss="modal" aria-label="Close">
                                <svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false"
                                    data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512" data-fa-i2svg="">
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
                            <form action="{{ route('institutional.roles.destroy', hash_id($role->id)) }}" method="POST"
                                class="d-inline">
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
@endsection

@section('styles')
    <style>
        .table-breadcrumb {
            margin-bottom: 0 !important
        }
    </style>
@endsection
