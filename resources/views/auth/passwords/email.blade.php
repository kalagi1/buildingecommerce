@extends('client.layouts.master')

@section('content')
<div style="background-color: ghostwhite;">
    <div class="container pb-5 pt-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div class="table-breadcrumb">
                <ul>
                    <li>Emlak Sepette</li>
                    <li>Şifremi Unuttum</li>
                </ul>
            </div>
        </div>
        <section>
            <div class="single homes-content details mb-30">
                @if (session('status'))
                    <div class="alert alert-success text-white" role="alert">
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <span>E-posta Adresi</span>
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="email" 
                            autofocus
                        >

                        @error('email')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <button type="submit" class="btn btn-primary">
                            <span>Şifre Sıfırlama Bağlantısı Gönder</span>
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection
