@extends('client.layouts.masterPanel')

@section('content')
    <div class="table-breadcrumb">
        <ul>
            <li>
                Hesabım
            </li>
            <li>
                Telefon Numarası Doğrulama
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
                                <img class="img-fluid rounded-start object-fit-cover" loading="lazy"
                                    src="{{ url('/images/template/phoneVerification.jpg') }}"
                                    style="width:100%;height:100%;object-fit:contain" alt="Welcome back you've been missed!">
                            </div>
                            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center border-left ">
                                <div class="col-12 col-lg-11 col-xl-10">
                                    @if (session()->has('success'))
                                        <div class="alert alert-success text-white mt-5">
                                            {{ session()->get('success') }}
                                        </div>
                                    @endif
                                    @if ($errors->any())
                                        <div class="alert alert-danger text-white mt-5">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="card-body ">



                                        @if ($user->phone_verification_code && $user->phone_verification_status == 0)
                                            <div class="px-xxl-5">
                                                <div
                                                    class="text-center mb-6 @if (!session()->has('success') && !$errors->any()) mt-5 @endif ">
                                                    <h2 class="text-body-highlight">Telefon Numarası Doğrulama</h2>
                                                    <p class="text-body-tertiary mb-5"><span
                                                            style="color:#ea2a28;font-size:13px">{{ $user->mobile_phone }}
                                                        </span> ait telefon numarasına 6 haneli
                                                        doğrulama kodunu içeren bir sms gönderildi.</p>
                                                    <p class="text-body-tertiary mb-4">Lütfen telefonunuza gelen doğrulama
                                                        kodunu aşağıdaki
                                                        alana giriniz.</p>

                                                    <form class="verification-form"
                                                        data-2fa-varification="data-2FA-varification"
                                                        action="{{ route('institutional.phone.verifyPhoneNumber') }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="d-flex align-items-center gap-2 mb-5">
                                                            <input name="code[]" class="form-control px-2 text-center"
                                                                type="number" maxlength="1">
                                                            <input name="code[]" class="form-control px-2 text-center"
                                                                type="number" maxlength="1" disabled>
                                                            <input name="code[]" class="form-control px-2 text-center"
                                                                type="number" maxlength="1" disabled>
                                                            <span>-</span>
                                                            <input name="code[]" class="form-control px-2 text-center"
                                                                type="number" maxlength="1" disabled>
                                                            <input name="code[]" class="form-control px-2 text-center"
                                                                type="number" maxlength="1" disabled>
                                                            <input name="code[]" class="form-control px-2 text-center"
                                                                type="number" maxlength="1" disabled>
                                                        </div>

                                                        <button class="btn btn-primary w-100 mb-5"
                                                            type="submit">Doğrula</button>
                                                    </form>
                                                    <form
                                                        action="{{ route('institutional.phone.generateVerificationCode') }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="btn btn-link me-1 mb-1 w-100 mb-5"
                                                            type="submit">Doğrulama Kodunu
                                                            Tekrar
                                                            Gönder</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @else
                                            @if (optional($user)->mobile_phone === null || optional($user)->mobile_phone === '')
                                                <div class="px-xxl-5">
                                                    <div class="text-center mb-6">
                                                        <p class="text-body-tertiary mb-5"> Telefon numaranız sistemimizde
                                                            kayıtlı değil.
                                                            Lütfen
                                                            öncelikle cep telefon numaranızı güncelleyiniz.</p>

                                                        <form
                                                            action="{{ route('institutional.phone.update.generateVerificationCode') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <!-- Eğer update işlemi yapıyorsanız PUT methodunu kullanmalısınız -->
                                                            <div class="form-group">
                                                                <label for="new_mobile_phone">Yeni Telefon Numarası</label>
                                                                <input type="number" class="form-control"
                                                                    id="new_mobile_phone" name="new_mobile_phone"
                                                                    placeholder="5XXXXXXXXX" required>
                                                            </div>

                                                            <button class="btn btn-primary w-100 mb-5"
                                                                type="submit">Güncelle</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="px-xxl-5">
                                                    <div class="text-center mb-6">
                                                        <p class="text-body-tertiary mb-5">Telefon doğrulama kodunu
                                                            oluşturmak için lütfen
                                                            aşağıdaki butona tıklayın.</p>

                                                        <form
                                                            action="{{ route('institutional.phone.generateVerificationCode') }}"
                                                            method="POST">
                                                            @csrf
                                                            <button class="btn btn-primary w-100 mb-5"
                                                                type="submit">Doğrulama Kodu
                                                                Oluştur</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
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
        .verification-form {
            max-width: 17.6875rem;
            margin: 0 auto;
        }

        .verification-form .form-control {
            -moz-appearance: textfield;
        }

        .verification-form .form-control::-webkit-outer-spin-button,
        .verification-form .form-control::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .px-2 {
            padding-right: .5rem !important;
            padding-left: .5rem !important;
        }

        .gap-2 {
            gap: .5rem !important;
        }

        ul {
            margin-bottom: 0 !important;
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.verification-form input[type="number"]');

            inputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    const value = e.target.value;
                    if (value.length === 1) {
                        if (index < inputs.length - 1) {
                            inputs[index + 1].disabled = false;
                            inputs[index + 1].focus();
                        }
                    } else if (value.length > 1) {
                        e.target.value = value[0]; // Keep only the first digit
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
            });

            // Enable only the first input initially
            if (inputs.length > 0) {
                inputs[0].disabled = false;
                inputs[0].focus();
            }
        });
    </script>
@endsection
