@extends('client.layouts.master')

@section('content')
    <section class="loginItems">
        <div class="container">
            <h3 class="text-center font-weight-bold">Hesap Aç</h3>
            <button class="button w-100">
                <img src="https://img.icons8.com/color/48/undefined/google-logo.png" alt="google logo" class="img">
                <p>Google ile hesap aç</p>
            </button>
            <button class="button w-100">
                <img src="https://img.icons8.com/ios-filled/50/undefined/mac-os.png" alt="apple logo" class="img">
                <p>Apple ile hesap aç</p>
            </button>
            <p>ya da</p>
            <form class="form w-100">
                <div class="mt-3">
                    <label class="q-label">E-Posta</label>
                    <input type="email" class="form-control">
                </div>

                <div class="mt-3">
                    <label class="q-label">Şifre</label>
                    <input type="password" class="form-control">
                </div>

                <div class="forgot-password"><a><span>Şifremi Unuttum</span></a></div>
                <button class="btn btn-primary q-button"> Giriş Yap</button>

                <div class="social-account-login-buttons">
                    <div class="q-layout social-login-button flex flex-1">
                        <div class="social-login-icon" style="background-color: rgb(76, 110, 168);"><i
                                class="fa fa-apple"></i></div>
                        <div class="flex flex-column">
                            <div>
                                <div style="text-transform: capitalize;">facebook</div> <small>ile giriş yap</small>
                            </div>
                        </div>
                    </div>
                    <div class="q-layout social-login-button flex flex-1">
                        <div class="social-login-icon" style="background-color: rgb(241, 66, 54);"><i
                                class="fa fa-google"></i></div>
                        <div class="flex flex-column">
                            <div>
                                <div style="text-transform: capitalize;">google</div> <small>ile giriş yap</small>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
            <p id="signup">Henüz hesabın yok mu ? <a href="#">Kayıt Ol</a></p>
        </div>
    </section>
@endsection
