@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-300 border-bottom mb-4">
                    <div class="card-header border-bottom border-300 bg-soft">
                        <h4 class="text-900 mb-0" data-anchor="data-anchor" id="soft-buttons">Edit Permission</h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="permission_group_id" class="form-label">Permission Group</label>
                                <select class="form-select" id="permission_group_id" name="permission_group_id" required>
                                    @foreach ($permissionGroups as $group)
                                        <option value="{{ $group->id }}"
                                            {{ $group->id == $permission->permission_group_id ? 'selected' : '' }}>
                                            {{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="key" class="form-label">Key</label>
                                <input type="text" class="form-control" id="key" name="key"
                                    value="{{ $permission->key }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ $permission->description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ $permission->title }}">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                                    value="1" {{ $permission->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                            @if (in_array('UpdatePermission', $userPermissions))
                                <button type="submit" class="btn btn-primary">Update</button>
                            @else
                                <p>You don't have permission to update this page.</p>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
