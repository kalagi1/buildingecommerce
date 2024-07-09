@extends('client.layouts.masterPanel')

@section('content')
    <div class="table-breadcrumb">
        <ul>
            <li>
                Hesabım
            </li>
            <li>
                Şifreyi Değiştir
            </li>
        </ul>
    </div>


    <section>
        <div>
            <div class="row justify-content-center">
                <div class="col-12 col-xxl-11">
                    <div class="card border-light-subtle shadow-sm">
                        <div class="row g-0">
                            <div class="col-12 col-md-6 border-right ">
                                <img class="img-fluid rounded-start w-100 h-100 object-fit-cover" loading="lazy"
                                    src="{{ url('/images/template/changePassword.jpg') }}"
                                    alt="Welcome back you've been missed!">
                            </div>
                            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center border-left ">
                                <div class="col-12 col-lg-11 col-xl-10">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-5">
                                                    <div class="text-center mb-5">
                                                        <a href="#!">
                                                            <img src="{{ url('/images/emlaksepettelogo.png') }}"
                                                                alt="Emlak Sepette Logo" width="175" height="57">
                                                        </a>
                                                    </div>
                                                    <h2 class="h4 text-center">Şifre Değiştir</h2>
                                                    <h3 class="fs-6 fw-normal text-secondary text-center m-0">Herhangi bir
                                                        sorunla karşılaşırsanız, lütfen info@emlaksepette.com ile iletişime
                                                        geçmekten çekinmeyin.
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <form method="POST" action="{{ route('institutional.password.update') }}">
                                            @csrf
                                            <div class="row gy-3 overflow-hidden">
                                                <div class="col-12 mt-2">
                                                    <div class="form-floating mb-3">

                                                        <div class="form-group">
                                                            <div class="form-icon-container mb-3">
                                                                <div class="form-floating">
                                                                    <input class="form-control form-icon-input"
                                                                        id="oldPassword" type="password"
                                                                        name="current_password" placeholder="Mevcut Şifre"
                                                                        required>


                                                                </div>
                                                            </div>
                                                            @error('current_password')
                                                                <div
                                                                    class="badge badge-phoenix fs-10 badge-phoenix-danger d-inline-flex align-items-center ms-2">
                                                                    {{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-floating mb-3">
                                                        <div class="form-group">
                                                            <div class="form-icon-container mb-3">
                                                                <div class="form-floating">
                                                                    <input class="form-control form-icon-input"
                                                                        id="newPassword" type="password" name="new_password"
                                                                        placeholder="Yeni Şifre" required>


                                                                </div>
                                                            </div>
                                                            @error('new_password')
                                                                <div
                                                                    class="badge badge-phoenix fs-10 badge-phoenix-danger d-inline-flex align-items-center ms-2">
                                                                    {{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-floating mb-3">
                                                        <div class="form-group">
                                                            <div class="form-icon-container">
                                                                <div class="form-floating">
                                                                    <input class="form-control form-icon-input"
                                                                        id="newPassword2" type="password"
                                                                        name="new_password_confirmation"
                                                                        placeholder="Yeni Şifre Onayı" required>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="justify-content-center">
                                                <div class="col-12 d-flex justify-content-center">
                                                    <button class="button" type="submit">Şifreyi Güncelle</button>
                                                </div>
                                            </div>


                                        </form>
                                        {{-- <div class="row">
                      <div class="col-12">
                        <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center mt-5">
                          <a href="#!" class="link-secondary text-decoration-none">Login</a>
                          <a href="#!" class="link-secondary text-decoration-none">Register</a>
                        </div>
                      </div>
                    </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
    <style>
        .button {
            background-color: #ea2a28;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #c22321;
        }
    </style>
@endsection
