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
                Kullanıcı Tiplerinin Listele
            </li>
        </ul>

    </div>
    <section>
        <div class="single homes-content details mb-30">

            <div class="container">

                @if (in_array('CreateRole', $userPermissions))
                    <a class="btn btn-primary px-5 mb-3" style="float: right" href="{{ route('institutional.roles.create') }}">
                        <i class="fa fa-plus me-2 mr-2"></i>Yeni Ekle
                    </a>
                @endif

                <table class="table fs--1 mb-0 border-top border-200">
                    <thead>
                        <tr>
                            <th style="width:15%;text-align:start">ID</th>
                            <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="projectName"
                                style="width:60%">Kullanıcı Tipi</th>
                            <th style="text-align:end">İşlemler</ths>
                        </tr>
                    </thead>
                    <tbody class="list" id="project-list-table-body">
                        @foreach ($roles as $key => $role)
                            <tr class="position-static">
                                <td style="text-align:start"> {{ $key + 1 }}</td>
                                <td>{{ $role->name }}</td>
                                <td style="text-align:end">

                                    @if (in_array('UpdateRole', $userPermissions))
                                        <a href="{{ route('institutional.roles.edit', hash_id($role->id)) }}"
                                            class="btn btn-sm btn-primary"><svg viewBox="0 0 24 24" width="18"
                                            height="18" stroke="currentColor" stroke-width="2" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg></a>
                                    @elseif (in_array('GetRoleById', $userPermissions))
                                        <a href="{{ route('institutional.roles.edit', hash_id($role->id)) }}"
                                            class="btn btn-sm btn-primary"><svg viewBox="0 0 24 24" width="18"
                                            height="18" stroke="currentColor" stroke-width="2" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg></a>
                                    @endif

                                    <!-- Silme işlemi için modal -->
                                    @if (in_array('DeleteRole', $userPermissions))
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $role->id }}">
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
                                    @else
                                    @endif




                                    <!-- Silme işlemi için modal -->
                                    <div class="modal fade" id="deleteModal{{ $role->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel{{ $role->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $role->id }}">Sil
                                                    </h5>
                                                    <button type="button" class="btn p-1" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true"
                                                            focusable="false" data-prefix="fas" data-icon="xmark"
                                                            role="img" xmlns="http://www.w3.org/2000/svg"
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
                                                    <form action="{{ route('institutional.roles.destroy', hash_id($role->id)) }}"
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
