@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-300 border-bottom mb-4">
                    <div class="card-header border-bottom border-300 bg-soft">
                        <h4 class="text-900 mb-0" data-anchor="data-anchor" id="soft-buttons">Şifreyi Değiştir</h4>
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
                        @if (session('success'))
                            <div class="alert alert-success text-white text-white">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('institutional.password.update') }}">
                            @csrf

                            <div class="form-group">
                                <label for="current_password">Mevcut Şifre</label>
                                <input type="password" name="current_password" id="current_password" class="form-control"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="new_password">Yeni Şifre</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="new_password_confirmation">Yeni Şifre Tekrar</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                    class="form-control" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Şifreyi Değiştir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
