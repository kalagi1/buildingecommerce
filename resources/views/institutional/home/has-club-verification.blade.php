@extends('institutional.layouts.master')


@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="toast show" style="width: 100%" role="alert" data-bs-autohide="false" aria-live="assertive"
                    aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">Emlak Sepette | Emlak Kulüp Başvurusu</strong>
                    </div>
                    <div class="toast-body"> Emlak Kulüp ayrıcalıklarından faydalanmak için lütfen aşağıdaki bilgileri
                        eksiksiz doldurun ve
                        üyelik
                        sözleşmesini onaylayın.
                        <form action="{{ route('institutional.club.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Diğer giriş alanlarını buraya ekleyin -->
                            <div class="corporate-form" id="corporateForm">

                                {{-- <div class="mt-3">
                                    <label class="q-label">İsim</label>
                                    <input type="text" name="name" disabled readonly
                                        class="form-control @error('name') is-invalid @enderror"value="{{ old('name', $user->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                                <div class="mt-3">
                                    <label class="q-label">Telefon</label>
                                    <input type="number" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if (Auth::check() && Auth::user()->type == '1')
                                    <div class="mt-3">
                                        <label class="q-label">Tc Kimlik No</label>
                                        <input type="number" name="idNumber"
                                            class="form-control @error('idNumber') is-invalid @enderror"
                                            value="{{ old('idNumber', $user->idNumber) }}">
                                        @error('idNumber')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif

                                <div class="mt-3">
                                    <label class="q-label">Banka Alıcı Adı</label>
                                    <input type="text" name="bank_name"
                                        class="form-control @error('bank_name') is-invalid @enderror"
                                        value="{{ old('bank_name', $user->bank_name) }}">
                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <label class="q-label">Iban Numarası
                                        <i class="fa fa-info-circle ml-2" data-toggle="tooltip" style="font-size: 18px;"
                                            aria-label="Lütfen geçerli bir iban giriniz. Koleksiyonlarınızdan satış yapıldığında kazandığınız miktar emlaksepette.com tarafından sizlere gönderilir."
                                            title="Lütfen geçerli bir iban giriniz. Koleksiyonlarınızdan satış yapıldığında kazandığınız miktar emlaksepette.com tarafından sizlere gönderilir."></i></label>
                                    <input type="text" name="iban"
                                        class="form-control @error('iban') is-invalid @enderror"
                                        value="{{ old('iban', $user->iban) }}">
                                    @error('iban')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>



                            </div>
                            <div class="filter-tags-wrap  mt-3" id="corporateFormCheck">
                                <input id="check-d" class="@error('check-d') is-invalid @enderror" type="checkbox"
                                    name="check-d">
                                <label for="check-d" style="font-size: 14px;">
                                    <a href="/sayfa/emlak-kulup-uyelik-sozlesmesi" target="_blank">
                                        Emlak Kulüp üyelik sözleşmesini
                                    </a>
                                    okudum onaylıyorum.
                                </label>
                                @error('check-d')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <br>
                            </div>

                            <button type="submit" class="btn btn-primary mt-5">Üye Ol </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


@section('css')
    <style>
        .btn-blue {
            background-color: #0080c7 !important;
            color: white
        }

        label {
            color: black;
            font-weight: 700 !important;
            font-size: 14px
        }

        /* Add this to your CSS file */
        .green-border {
            border: 2px solid green;
        }

        .ml-2 {
            margin-left: 5px;
        }

        .mr-2 {
            margin-right: 5px;
        }

        .checkmark::after {
            content: '\2713';
            color: green;
            font-size: 16px;
            margin-left: 5px;
        }

        /* CSS for the "crossmark" icon */
        .crossmark::after {
            content: '✗';
            /* Unicode character for the 'X' symbol */
            color: #EA2B2E;
            /* Color of the crossmark */
            font-size: 16px;
            /* Adjust the font size as needed */
            margin-left: 5px;
            /* Adjust the spacing as needed */
        }
    </style>
@endsection
