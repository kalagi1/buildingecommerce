@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-300 border-bottom mb-4">
                    <div class="card-header border-bottom border-300 bg-soft">
                        <h4 class="text-900 mb-0" data-anchor="data-anchor" id="soft-buttons">Güncelle</h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger text-white">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.permission_groups.update', $permissionGroup->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Başlık</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $permissionGroup->name }}" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                                    value="1" {{ $permissionGroup->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Aktif</label>
                            </div>
                            @if (in_array('UpdatePermissionGroup', $userPermissions))
                                <button type="submit" class="btn btn-primary">Güncelle</button>
                            @else
                                <p>Bu işlem için yetkiniz yok</p>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
