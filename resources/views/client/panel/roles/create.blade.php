@extends('client.layouts.masterPanel')

@section('content')
    <div class="table-breadcrumb mb-5">
        <ul>
            <li>
                Hesabım
            </li>
            <li>
                Kullanıcı Tipi Oluştur
            </li>
        </ul>
    </div>
    <section>
        <div class="single homes-content details mb-30">

            <div class="container">
                <form action="{{ route('institutional.roles.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name">Kullanıcı Tipi</label>
                        <input class="form-control" id="name" name="name" type="text" placeholder="Rol">
                    </div>

                    <div class="mb-3">
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
                                        'Orders',
                                    ];
                                @endphp

                                {{-- Özel izinleri listeden çıkar --}}
                                @foreach ($groupedPermissions as $groupId => $groupPermissions)
                                    @php
                                        // Grup içindeki özel izinleri çıkartarak izin listesini güncelle
                                        $filteredPermissions = $groupPermissions->reject(function ($permission) use (
                                            $specialPermissions,
                                        ) {
                                            return in_array($permission->key, $specialPermissions);
                                        });
                                    @endphp

                                    {{-- Eğer grup içinde izin kalmadıysa bu grubu atla --}}
                                    @if ($filteredPermissions->isNotEmpty())
                                        <div class="col-12">
                                            @php
                                                $groupTitle = \App\Models\PermissionGroup::find($groupId)->desc;
                                            @endphp
                                            <label class="form-label">{{ $groupTitle }}</label>

                                            <div class="mb-3">
                                                @foreach ($filteredPermissions as $permission)
                                                    @if ($permission->description !== 'Modülün menüde etkin olması için bu seçeneği işaretlemeniz gerekmektedir.')
                                                    
                                                        <div class="form-check form-control px-3" style="cursor: pointer">
                                                            <div class="checkboxes float-left">
                                                                <div class="filter-tags-wrap">
                                                                    <input  class="form-check-input"  type="checkbox" id="permission-{{ $permission->id }}" name="permissions[]"
                                                                    value="{{ $permission->id }}">
                                                                    <label class="form-check-label"
                                                                    for="permission-{{ $permission->id }}">{{ $permission->description }}</label>
                                                                </div>
                                                            </div>
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

                    @foreach ($specialPermissionIDs as $specialPermissionID)
                        <input type="hidden" name="permissions[]" value="{{ $specialPermissionID }}">
                    @endforeach
                    <button type="submit" class="btn btn-primary">Oluştur</button>
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
                if (!checkbox.prop('disabled')) {
                    checkbox.prop('checked', !checkbox.prop('checked'));
                }
            });
        });
    </script>
@endsection
