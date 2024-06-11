@extends('institutional.layouts.master')


@section('content')
    <div class="content">
        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="p-5 bg-white border rounded-3 shadow-lg">

            <div class="row flex-center py-5">
                <div class="col-sm-10 col-md-8 col-lg-5 col-xxl-4">
                    <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block justify-content-center mb-3"><img
                            src="{{ asset('/images/emlaksepettelogo.png') }}" alt="phoenix" height="100%" width="40%">
                    </div>
                    </a>

                    @if ($user->phone_verification_code && $user->phone_verification_status == 0)
                        <div class="px-xxl-5">
                            <div class="text-center mb-6">
                                <h4 class="text-body-highlight">Telefon Numarası Doğrulama</h4>
                                <p class="text-body-tertiary mb-5">{{$user->mobile_phone}} ait telefon numarasına 6 haneli doğrulama kodunu
                                    içeren bir sms gönderildi.</p>

                                <p class="text-body-tertiary mb-4">Lütfen telefonunuza gelen doğrulama kodunu aşağıdaki
                                    alana giriniz.</p>

                                <form class="verification-form" data-2fa-varification="data-2FA-varification"
                                    action="{{ route('institutional.phone.verifyPhoneNumber') }}" method="POST">
                                    @csrf
                                    <div class="d-flex align-items-center gap-2 mb-5">
                                        <input name="code[]" class="form-control px-2 text-center" type="number">
                                        <input name="code[]" class="form-control px-2 text-center" type="number"
                                            disabled="disabled">
                                        <input name="code[]" class="form-control px-2 text-center" type="number"
                                            disabled="disabled">
                                        <span>-</span>
                                        <input name="code[]" class="form-control px-2 text-center" type="number"
                                            disabled="disabled">
                                        <input name="code[]" class="form-control px-2 text-center" type="number"
                                            disabled="disabled">
                                        <input name="code[]" class="form-control px-2 text-center" type="number"
                                            disabled="disabled">
                                    </div>

                                    <button class="btn btn-primary w-100 mb-5" type="submit">Doğrula</button>
                                </form>
                                <form action="{{ route('institutional.phone.generateVerificationCode') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-link me-1 mb-1 w-100 mb-5" type="submit">Doğrulama Kodunu Tekrar
                                        Gönder</button>
                                </form>
                            </div>
                        </div>
                    @else
                        @if(optional($user)->mobile_phone === null || optional($user)->mobile_phone === '')
                            <div class="px-xxl-5">
                                <div class="text-center mb-6">
                                    <p class="text-body-tertiary mb-5"> Telefon numaranız sistemimizde kayıtlı değil. Lütfen öncelikle cep telefon numaranızı güncelleyiniz.</p>
                            
                                    <form action="{{ route('institutional.phone.update.generateVerificationCode') }}" method="POST">
                                        @csrf
                                        @method('PUT') <!-- Eğer update işlemi yapıyorsanız PUT methodunu kullanmalısınız -->
                                        <div class="form-group">
                                            <label for="new_mobile_phone">Yeni Telefon Numarası</label>
                                            <input type="number" 
                                                   class="form-control" 
                                                   id="new_mobile_phone" 
                                                   name="new_mobile_phone" 
                                                   placeholder="5XXXXXXXXX" 
                                                   required>
                                        </div>
                                        
                                    
                                        <button class="btn btn-primary w-100 mb-5" type="submit">Güncelle</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="px-xxl-5">
                                <div class="text-center mb-6">
                                    <p class="text-body-tertiary mb-5">Telefon doğrulama kodunu oluşturmak için lütfen aşağıdaki düğmeye tıklayın.</p>
                            
                                    <form action="{{ route('institutional.phone.generateVerificationCode') }}" method="POST">
                                        @csrf
                                        <button class="btn btn-primary w-100 mb-5" type="submit">Doğrulama Kodu Oluştur</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endif

                </div>
            </div>


        </div>

    </div>
@endsection

@section('css')
@endsection
