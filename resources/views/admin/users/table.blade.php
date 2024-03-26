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
                    @if ($user->is_blocked == 1)
                        <span class="badge bg-danger">ENGELLENDİ</span>
                    @else
                        <span class="badge bg-success">DOĞRULANDI</span>
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