@extends('institutional.layouts.master')

@section('content')
    <div class="content mt-3">
        <div class="row">
            <div class="card shadow-none border border-300 p-0" data-component-card="data-component-card">
                <div class="card-header border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0" data-anchor="data-anchor" id="soft-buttons">Departman Oluştur</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="p-4 code-to-copy">
                        <form action="{{ route('institutional.roles.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="name">Departman</label>
                                <input class="form-control" id="name" name="name" type="text" placeholder="Rol">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">İzinler</label>
                                <div class="row">
                                    @foreach ($permissions as $permission)
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="permission-{{ $permission->id }}" name="permissions[]"
                                                    value="{{ $permission->id }}">
                                                <label class="form-check-label"
                                                    for="permission-{{ $permission->id }}">{{ $permission->key }}</label>
                                            </div>
                                        </div>
                                        @if ($loop->iteration % 20 == 0)
                                </div>
                                <div class="row">
                                    @endif
                                    @endforeach
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
