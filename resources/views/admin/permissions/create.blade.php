@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="card shadow-sm border-300 border-bottom mb-4 p-0">
                <div class="card-header border-bottom border-300 bg-soft">
                    <h4 class="text-900 mb-0" data-anchor="data-anchor" id="soft-buttons">İzin Oluştur</h4>
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

                    <form action="{{ route('admin.permissions.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="permission_group_id" class="form-label">İzin Grupları</label>
                            <select class="form-select" id="permission_group_id" name="permission_group_id" required>
                                <option value="" disabled selected>Seç</option>
                                @foreach ($permissionGroups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="key" class="form-label">Anahtar</label>
                            <input type="text" class="form-control" id="key" name="key" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Açıklama</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Başlık</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                                checked>
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Oluştur</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
