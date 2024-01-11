@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-4">
                <div class="card shadow-sm border-300 border-bottom mb-4">
                    <div class="card-body">
                        @if (session('success'))
                        <div class="alert alert-success text-white text-white">
                            {{ session('success') }}
                        </div>
                    @endif
        
                    <form method="POST" action="{{ route('institutional.password.update') }}">
                        @csrf
        
                        <div class="col-12">
                            <h4 class="mb-4">Şifre Değiştir</h4>
        
                            <div class="form-group">
                                <div class="form-icon-container mb-3">
                                    <div class="form-floating">
                                        <input class="form-control form-icon-input" id="oldPassword" type="password"
                                            name="current_password" placeholder="Old password" required>
                                        <label class="text-body-tertiary form-icon-label" for="oldPassword">Mevcut Şifre</label>
                                    </div>
                                    <svg class="svg-inline--fa fa-lock text-body fs-9 form-icon" aria-hidden="true"
                                        focusable="false" data-prefix="fas" data-icon="lock" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M80 192V144C80 64.47 144.5 0 224 0C303.5 0 368 64.47 368 144V192H384C419.3 192 448 220.7 448 256V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V256C0 220.7 28.65 192 64 192H80zM144 192H304V144C304 99.82 268.2 64 224 64C179.8 64 144 99.82 144 144V192z">
                                        </path>
                                    </svg>
                                </div>
                                @error('current_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            </div>
        
                            <div class="form-group">
                                <div class="form-icon-container mb-3">
                                    <div class="form-floating">
                                        <input class="form-control form-icon-input" id="newPassword" type="password"
                                            name="new_password" placeholder="New password" required>
                                        <label class="text-body-tertiary form-icon-label" for="newPassword">Yeni Şifre</label>
                                    </div>
                                    <svg class="svg-inline--fa fa-key text-body fs-9 form-icon" aria-hidden="true"
                                        focusable="false" data-prefix="fas" data-icon="key" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M282.3 343.7L248.1 376.1C244.5 381.5 238.4 384 232 384H192V424C192 437.3 181.3 448 168 448H128V488C128 501.3 117.3 512 104 512H24C10.75 512 0 501.3 0 488V408C0 401.6 2.529 395.5 7.029 391L168.3 229.7C162.9 212.8 160 194.7 160 176C160 78.8 238.8 0 336 0C433.2 0 512 78.8 512 176C512 273.2 433.2 352 336 352C317.3 352 299.2 349.1 282.3 343.7zM376 176C398.1 176 416 158.1 416 136C416 113.9 398.1 96 376 96C353.9 96 336 113.9 336 136C336 158.1 353.9 176 376 176z">
                                        </path>
                                    </svg>
                                </div>
                                @error('new_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            </div>
        
                            <div class="form-group">
                                <div class="form-icon-container">
                                    <div class="form-floating">
                                        <input class="form-control form-icon-input" id="newPassword2" type="password"
                                            name="new_password_confirmation" placeholder="Confirm New password"
                                            required>
                                        <label class="text-body-tertiary form-icon-label" for="newPassword2">Yeni Şifre Onayı</label>
                                    </div>
                                    <svg class="svg-inline--fa fa-key text-body fs-9 form-icon" aria-hidden="true"
                                        focusable="false" data-prefix="fas" data-icon="key" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M282.3 343.7L248.1 376.1C244.5 381.5 238.4 384 232 384H192V424C192 437.3 181.3 448 168 448H128V488C128 501.3 117.3 512 104 512H24C10.75 512 0 501.3 0 488V408C0 401.6 2.529 395.5 7.029 391L168.3 229.7C162.9 212.8 160 194.7 160 176C160 78.8 238.8 0 336 0C433.2 0 512 78.8 512 176C512 273.2 433.2 352 336 352C317.3 352 299.2 349.1 282.3 343.7zM376 176C398.1 176 416 158.1 416 136C416 113.9 398.1 96 376 96C353.9 96 336 113.9 336 136C336 158.1 353.9 176 376 176z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
        
                        </div>
        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Şifre Güncelle</button>
                        </div>
                    </form>
                    

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
