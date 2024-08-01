@extends('client.layouts.masterPanel')

@section('content')
    <div class="table-breadcrumb mb-5">
        <ul>
            <li>
                Hesabım
            </li>
            <li>
                Emlak Kulüp Üyeliği
            </li>
        </ul>
    </div>

    <section>
        <div class="row justify-content-center">
            <div class="col-12 col-xxl-11">
                <div class="card border-light-subtle shadow-sm">
                    <div class="row g-0">
                        <div class="col-12 col-md-12 d-flex align-items-center justify-content-center ">
                            <div class="col-12 col-lg-11 col-xl-10">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-5 mt-5">
                                                <h2 class="h4 text-center mb-5"> Emlak Kulüp ayrıcalıklarından faydalanmak
                                                    için
                                                    lütfen aşağıdaki bilgileri eksiksiz doldurun ve
                                                    üyelik sözleşmesini onaylayın.</h2>
                                                <form action="{{ route('institutional.club.update') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="corporate-form mb-4" id="corporateForm">
                                                        @if (Auth::check() && Auth::user()->type == '1')
                                                            <div class="mt-3">
                                                                <label class="form-label">Tc Kimlik No</label>
                                                                <input type="number" name="idNumber" id="idNumber"
                                                                    class="form-control @error('idNumber') is-invalid @enderror"
                                                                    value="{{ old('idNumber', $user->idNumber) }}">
                                                                @error('idNumber')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        @endif

                                                        <div class="mt-3">
                                                            <label class="form-label">Hesap Sahibinin Adı Soyadı</label>
                                                            <input type="text" name="bank_name"
                                                                class="form-control @error('bank_name') is-invalid @enderror"
                                                                value="{{ old('bank_name', $user->bank_name) }}">
                                                            @error('bank_name')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="mt-3">
                                                            <label class="form-label">Iban Numarası
                                                                <i class="fa fa-info-circle ml-2" data-toggle="tooltip"
                                                                    style="font-size: 18px;"
                                                                    aria-label="Lütfen geçerli bir iban giriniz. Koleksiyonlarınızdan satış yapıldığında kazandığınız miktar emlaksepette.com tarafından sizlere gönderilir."
                                                                    title="Lütfen geçerli bir iban giriniz. Koleksiyonlarınızdan satış yapıldığında kazandığınız miktar emlaksepette.com tarafından sizlere gönderilir."></i></label>
                                                            <input type="text" name="iban" id="ibanInput"
                                                                class="form-control @error('iban') is-invalid @enderror"
                                                                value="{{ $user->iban != 'null' ? $user->iban : '' }}"
                                                                oninput="formatIBAN(this)">

                                                            @error('iban')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="filter-tags-wrap mt-3 d-flex" id="corporateFormCheck">
                                                        <input id="check-d" class="@error('check-d') is-invalid @enderror"
                                                            type="checkbox" name="check-d">

                                                        <label for="check-d" style="margin-left:10px">
                                                            <a href="/sayfa/emlak-kulup-uyelik-sozlesmesi" target="_blank">
                                                                Emlak Kulüp üyelik sözleşmesini
                                                            </a>
                                                            okudum onaylıyorum.
                                                        </label>

                                                    </div>
                                                    @error('check-d')
                                                        <div class="invalid-feedback" style="display:block !important">
                                                            {{ $message }}</div>
                                                    @enderror
                                                    <button type="submit" class="btn btn-primary mt-5">Üye Ol</button>
                                                </form>
                                            </div>
                                        </div>
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

@section('scripts')
<script>
    function formatIBAN(input) {
        var value = $(input).val();
        var maxLength = 26;

        // Sadece rakamları ve harfleri izin ver
        var alphanumericValue = value.replace(/[^a-zA-Z0-9]/g, '');

        // IBAN uzunluğunu kontrol et
        if (alphanumericValue.length > maxLength) {
            alphanumericValue = alphanumericValue.slice(0, maxLength);
        }

        $(input).val(alphanumericValue);

        // IBAN uzunluğu kontrolü
        if (alphanumericValue.length !== maxLength) {
            $(input).addClass('is-invalid');
            $(input).siblings('.invalid-feedback').text('IBAN numarası 26 haneli olmalıdır.');
        } else {
            $(input).removeClass('is-invalid');
            $(input).siblings('.invalid-feedback').text('');
        }
    }
</script>
    <script>
        $(document).ready(function() {
            $('#idNumber').on('input', function() {
                var inputValue = $(this).val();
                var maxLength = 11;

                // Sadece rakamları izin ver
                var numericValue = inputValue.replace(/\D/g, '');

                if (numericValue.length > maxLength) {
                    numericValue = numericValue.slice(0, maxLength);
                }

                $(this).val(numericValue);

                if (numericValue.length > maxLength) {
                    $('#error-message').text('Telefon numarası 11 haneden fazla olamaz.');
                } else {
                    $('#error-message').text('');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#phone").on("input blur", function() {
                var phoneNumber = $(this).val();
                var pattern = /^5[0-9]\d{8}$/;

                if (!pattern.test(phoneNumber)) {
                    $("#error_message").text("Lütfen geçerli bir telefon numarası giriniz.");
                } else {
                    $("#error_message").text("");
                }
                // Kullanıcı 10 haneden fazla veri girdiğinde bu kontrol edilir
                $('#phone').on('keypress', function(e) {
                    var max_length = 10;
                    // Eğer giriş karakter sayısı 10'a ulaştıysa ve yeni karakter ekleme işlemi değilse
                    if ($(this).val().length >= max_length && e.which != 8 && e.which != 0) {
                        // Olayın işlenmesini durdur
                        e.preventDefault();
                    }
                });
            });
        });

        function formatIBAN(input) {
            // TR ile başlat
            var formattedIBAN = "TR";

            // Gelen değerden sadece rakamları al
            var numbersOnly = input.value.replace(/\D/g, '');

            // İBAN uzunluğunu kontrol et ve fazla karakterleri kırp
            if (numbersOnly.length > 24) {
                numbersOnly = numbersOnly.substring(0, 24);
            }

            // Geri kalanı 4'er basamaklı gruplara ayır ve aralarına boşluk ekle
            for (var i = 0; i < numbersOnly.length; i += 4) {
                formattedIBAN += numbersOnly.substr(i, 4) + " ";
            }

            // Formatlanmış İBAN'ı input değerine ata
            input.value = formattedIBAN.trim();
        }

        // Giriş alanının değeri değiştiğinde formatIBAN fonksiyonunu çağır
        document.getElementById("ibanInput").addEventListener("input", function() {
            formatIBAN(this);
        });
    </script>
@endsection

@section('css')
    <style>
        .error-message {
            color: #e54242;
            font-size: 11px;
        }

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

        .crossmark::after {
            content: '✗';
            color: #D32729;
            font-size: 16px;
            margin-left: 5px;
        }
    </style>
@endsection
