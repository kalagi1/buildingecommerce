@extends('client.layouts.master')

@section('content')
    <section class="loginItems">
        <div class="container"> <!-- Genişlik container-fluid ile değiştirildi -->
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="login-container">
                        <!-- Sekme Seçenekleri -->
                        <ul class="nav nav-tabs login-tabs" id="myTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="normal-tab" data-toggle="tab" href="#normal" role="tab"
                                    aria-controls="normal" aria-selected="true">
                                    <h3 class="text-center font-weight-bold">Giriş Yap</h3>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="corporate-tab" data-toggle="tab" href="#corporate" role="tab"
                                    aria-controls="corporate" aria-selected="false">
                                    <h3 class="text-center font-weight-bold">Kayıt Ol</h3>
                                </a>
                            </li>
                        </ul>

                        <div class="login-content">
                            <!-- Sekme İçeriği -->
                            <div class="tab-content" id="myTabContent">
                                <!-- Normal Hesap Girişi Sekmesi -->
                                <div class="tab-pane fade show active" id="normal" role="tabpanel"
                                    aria-labelledby="normal-tab">
                                    @if (session()->has('success'))
                                        <div class="alert alert-success">
                                            {{ session()->get('success') }}
                                        </div>
                                    @elseif (session()->has('error'))
                                        <div class="alert alert-danger">
                                            {{ session()->get('error') }}
                                        </div>
                                    @endif

                                    <form method="POST"class="form w-100" action="{{ route('client.submit.login') }}">

                                        @csrf
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="mt-3">
                                            <label class="q-label">E-Posta</label>
                                            <input type="email" name="email" class="form-control">
                                        </div>

                                        <div class="mt-3">
                                            <label class="q-label">Şifre</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>

                                        <div class="forgot-password d-flex justify-content-between">
                                            <a href="{{ route('institutional.login') }}"><span>Kurumsal Giriş</span></a>
                                            <a href="#"><span>Şifremi Unuttum</span></a>
                                        </div>

                                        <button class="btn btn-primary q-button" type="submit"> Giriş Yap</button>

                                        <div class="social-account-login-buttons pb-3">
                                            <div class="q-layout social-login-button flex flex-1">
                                                <div class="social-login-icon" style="background-color: black;"><i
                                                        class="fa fa-apple"></i>
                                                </div>
                                                <div class="flex flex-column">
                                                    <div>
                                                        <div style="text-transform: capitalize;">facebook</div> <small>ile
                                                            giriş
                                                            yap</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="q-layout social-login-button flex flex-1">
                                                <div class="social-login-icon" style="background-color: rgb(241, 66, 54);">
                                                    <i class="fa fa-google"></i>
                                                </div>
                                                <div class="flex flex-column">
                                                    <div>
                                                        <div style="text-transform: capitalize;">google</div> <small>ile
                                                            giriş
                                                            yap</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>

                                </div>

                                <!-- Kurumsal Hesap Girişi Sekmesi -->
                                <div class="tab-pane fade" id="corporate" role="tabpanel" aria-labelledby="corporate-tab">
                                    <form method="POST" class="form w-100" action="{{ route('client.submit.register') }}">
                                        @csrf

                                        <!-- E-Posta -->
                                        <div class="mt-3">
                                            <label class="q-label">İsim</label>
                                            <input type="text" name="name" class="form-control">
                                        </div>

                                        <!-- E-Posta -->
                                        <div class="mt-3">
                                            <label class="q-label">E-Posta</label>
                                            <input type="email" name="email" class="form-control">
                                        </div>

                                        <!-- Şifre -->
                                        <div class="mt-3">
                                            <label class="q-label">Şifre</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>

                                        <div class="user-type-selection">
                                            <label>Kullanıcı Türü</label>
                                            <div class="button-group">
                                                <button class="user-type-button active" data-user-type="1"
                                                    type="button">Bireysel</button>
                                                <button class="user-type-button" data-user-type="2"
                                                    type="button">Kurumsal</button>
                                            </div>
                                            <input type="hidden" name="type" id="user-type-input" value="1">
                                        </div>

                                        <div class="form-group custom-control custom-checkbox mt-3">
                                            <input type="checkbox" class="custom-control-input" id="exampleCheck3"
                                                required>
                                            <label class="custom-control-label" for="exampleCheck3">Kişisel verilerimin
                                                işlenmesine yönelik aydınlatma metnini okudum anladım.</label>
                                        </div>


                                        <button class="btn btn-primary q-button" type="submit"> üYE OL</button>
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section>
@endsection


@section('scripts')
    <script>
        const userTypeButtons = document.querySelectorAll('.user-type-button');
        const userTypeInput = document.getElementById('user-type-input');

        userTypeButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Tüm düğmeleri aktiflikten çıkar
                userTypeButtons.forEach(btn => btn.classList.remove('active'));

                // Tıklanan düğmeyi aktif yap
                this.classList.add('active');

                // Seçilen türü gizli input alanına yaz
                const userType = this.getAttribute('data-user-type');
                userTypeInput.value = userType;
            });
        });
    </script>
@endsection
