@extends('institutional.layouts.master')

@section('content')
    <div class="content mt-3">
        <div class="row">
            <div class="card shadow-none border border-300 p-0" data-component-card="data-component-card">
                <div class="card-header border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0" data-anchor="data-anchor" id="soft-buttons">Kullanıcı Tipi Oluştur</h4>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="p-4 code-to-copy">
                        <form action="{{ route('institutional.roles.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="name">Kullanıcı Tipi</label>
                                <input class="form-control" id="name" name="name" type="text" placeholder="Rol">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">İzinler</label>
                                <div class="mb-3">
                                    <div class="row">
                                        {{-- Özel izinleri kontrol edin --}}
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
                                                'Orders'
                                            ];
                                        @endphp

                                        {{-- Özel izinleri listeden çıkar --}}
                                        @foreach ($groupedPermissions as $groupId => $groupPermissions)
                                            @php
                                                // Grup içindeki özel izinleri çıkartarak izin listesini güncelle
                                                $filteredPermissions = $groupPermissions->reject(function (
                                                    $permission,
                                                ) use ($specialPermissions) {
                                                    return in_array($permission->key, $specialPermissions);
                                                });
                                            @endphp

                                            {{-- Eğer grup içinde izin kalmadıysa bu grubu atla --}}
                                            @if ($filteredPermissions->isNotEmpty())
                                                <div class="col-12">
                                                    @php
                                                        $groupTitle = \App\Models\PermissionGroup::find($groupId)->desc;
                                                    @endphp
                                                    <h4 class="mt-3" style="margin-bottom:10px;">{{ $groupTitle }}</h4>
                                                    <div class="mb-3">
                                                        @foreach ($filteredPermissions as $permission)
                                                            @if ($permission->description !== 'Modülün menüde etkin olması için bu seçeneği işaretlemeniz gerekmektedir.')
                                                                <div class="form-check form-control px-3"
                                                                    style="cursor: pointer">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="permission-{{ $permission->id }}"
                                                                        name="permissions[]" value="{{ $permission->id }}">
                                                                    <label class="form-check-label"
                                                                        for="permission-{{ $permission->id }}">
                                                                        {{ $permission->description }}
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    <hr>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Gizli gönderilecek özel izinler --}}
                            @foreach ($specialPermissions as $specialPermission)
                                <input type="hidden" name="permissions[]" value="{{ $specialPermission }}">
                            @endforeach

                            <button type="submit" class="btn btn-primary">Oluştur</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.form-check').on('click', function() {
                var checkbox = $(this).find('.form-check-input');
                if (!checkbox.prop('disabled')) {
                    checkbox.prop('checked', !checkbox.prop('checked'));
                }
            });
        });
    </script>
@endsection
