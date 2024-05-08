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
                                        @foreach ($groupedPermissions as $groupId => $groupPermissions)
                                        <div class="col-12">
                                            @php
                                                $groupTitle = \App\Models\PermissionGroup::find($groupId)->desc;
                                            @endphp
                                            <h4 class="mt-3" style="margin-bottom:10px;">{{ $groupTitle }}</h4>
                                            @foreach ($groupPermissions->groupBy('permission_group_id') as $groupId => $permissions)
                                                <div class="mb-3">
                                                    @foreach ($permissions as $permission)
                                                        <div class="form-check form-control px-3" style="cursor: pointer">
                                                            <input class="form-check-input" type="checkbox" id="permission-{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}" @if(in_array($permission->key, ['ChangePassword', 'EditProfile', 'ViewDashboard','ShowCartOrders','GetMyCollection','GetMyEarnings','neighborView','GetOrders']) && !request()->has('permissions')) checked disabled @endif>
                                                            <label class="form-check-label" style="cursor: pointer" for="permission-{{ $permission->id }}">{{ $permission->description }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach                                          
                                            <hr>
                                            <hr>
                                        </div>
                                    @endforeach
                                    
                                    </div>
                                </div>
                            </div>

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
                checkbox.prop('checked', !checkbox.prop('checked'));
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const specialPermissions = ['Şifre Değiştir', 'Profili Düzenle', 'Kontrol Panelini Görüntüle'];
            const checkboxes = document.querySelectorAll('.form-check-input');
            
            checkboxes.forEach(function(checkbox) {
                if (specialPermissions.includes(checkbox.nextElementSibling.textContent.trim())) {
                    checkbox.addEventListener('change', function() {
                        if (this.checked === false) {
                            this.checked = true;
                        }
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // // $permission->description değeri "Modülün menüde etkin olması için bu seçeneği işaretlemeniz gerekmektedir." olan inputun class değerine menu-checkbox değerini ekle
            // $('.form-check-input').each(function() {
            //     if ($(this).next().text().trim() === "Modülün menüde etkin olması için bu seçeneği işaretlemeniz gerekmektedir.") {
            //         $(this).addClass('menu-checkbox');
            //         $(this).next().hide(); // label'ı gizle
            // $(this).hide(); // input'u gizle
            //     }
                
            // });


            $('.form-check-input').change(function() {
        // İzin gruplarını temsil eden div'in class'ını bul
        var permissionGroup = $(this).closest('.col-12');
        
        // İzin grubunun içindeki tüm checkbox'ları kontrol et
        var groupCheckboxes = permissionGroup.find('.form-check-input');
        
        // Grup içinde en az bir seçili checkbox var mı kontrol et
        var groupHasChecked = false;
        groupCheckboxes.each(function() {
            if ($(this).prop('checked')) {
                groupHasChecked = true;
            }
        });
        
        // Eğer grup içinde en az bir seçili checkbox varsa, menüyü seçili yap
        // if (groupHasChecked) {
        //     var menuCheckbox = permissionGroup.find('.form-check-input.menu-checkbox');
        //     if (menuCheckbox.length > 0) {
        //         menuCheckbox.prop('checked', true);
        //     }
        // }
    });

        });    
    </script>
@endsection
