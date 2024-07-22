@extends('client.layouts.masterPanel')

@section('content')
    <div class="table-breadcrumb">
        <ul>
            <li>
                Hesabım
            </li>
            <li>
                Kullanıcı Tipi Düzenle
            </li>
            <li>
                {{ $role->name }}
            </li>
        </ul>
    </div>
    <section>
        <div class="single homes-content details mb-30">

            <div class="container">
                <form action="{{ route('institutional.roles.update', hash_id($role->id)) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label" for="name">Kullanıcı Tipi</label>
                        <input class="form-control" id="name" name="name" type="text" placeholder="Rol"
                            value="{{ $role->name }}">
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            @php
                                $specialPermissions = [
                                    'ChangePassword',
                                    'EditProfile',
                                    'ViewDashboard',
                                    'ShowCartOrders',
                                    'GetMyCollection',
                                    'GetMyEarnings',
                                    'neighborView',
                                    'GetOrders',
                                    'GetReceivedOffers',
                                    'GetGivenOffers',
                                    'GetSwapApplications',
                                    'MyReservations',
                                    'Reservations',
                                    'Orders',
                                ];
                            @endphp
                            @foreach ($groupedPermissions as $groupId => $groupPermissions)
                                @php
                                    // Grup içindeki özel izinleri çıkartarak izin listesini güncelle
                                    $filteredPermissions = $groupPermissions->reject(function (
                                        $permission,
                                    ) use ($specialPermissions) {
                                        return in_array($permission->key, $specialPermissions);
                                    });
                                @endphp
                                @if ($filteredPermissions->isNotEmpty())
                                    <div class="col-12">
                                        @php
                                            $groupTitle = \App\Models\PermissionGroup::find($groupId)->desc;
                                        @endphp
                                        <label class="form-label">{{ $groupTitle }}</label>

                                        @foreach ($filteredPermissions as $permission)
                                            @if ($permission->description !== 'Modülün menüde etkin olması için bu seçeneği işaretlemeniz gerekmektedir.')
                                                <div class="form-check form-control px-3" style="cursor: pointer">
                                                    <div class="checkboxes float-left">
                                                        <div class="filter-tags-wrap">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="permission-{{ $permission->id }}"
                                                                name="permissions[]" value="{{ $permission->id }}"
                                                                @if ($role->rolePermissions->contains('permission_id', $permission->id)) checked @endif>
                                                            <label class="form-check-label"
                                                                for="permission-{{ $permission->id }}">{{ $permission->description }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        <hr>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                    </div>

                    @foreach ($specialPermissionIDs as $specialPermissionID)
                        <input type="hidden" name="permissions[]" value="{{ $specialPermissionID }}">
                    @endforeach

                    @if (in_array('UpdateRole', $userPermissions))
                        <button type="submit" class="btn btn-primary">Güncelle</button>
                    @endif
                </form>
            </div>
        </div>
    </section>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            $('.form-check').on('click', function() {
                var checkbox = $(this).find('.form-check-input');
                checkbox.prop('checked', !checkbox.prop('checked'));
            });
        });
    </script>
@endsection
