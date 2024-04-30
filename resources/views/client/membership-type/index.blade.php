@extends('institutional.layouts.master')

@section('content')
    <section class="loginItems">
        <div class="content"> 
            <div class="row">
                <div class="col-md-7 mx-auto">
                    <div class="login-container" style="background-color: #fff">
                      
                                    <div class="card-body" id="corporate" role="tabpanel" aria-labelledby="corporate-tab">
                                        <div class="card shadow-sm border-300 border-bottom mb-4">

                                            <div class="card-body">
                                                @if($changedUser)
                                                       <!-- Başvurunuz incelenmeye alınmıştır mesajı -->
                                        <div class="text-center">
                                            <i class="fas fa-exclamation-circle fa-5x text-warning mb-3"></i>
                                            <h5 class="text-warning">Başvurunuz İncelenmeye Alınmıştır</h5>
                                            <p class="text-muted">Başvurunuz inceleniyor. Lütfen bekleyiniz.</p>
                                        </div>
                                                @else

                                            <form method="POST" class="form" action="{{ route('client.institutional.register') }}">
                                                @csrf
                                                <div class="user-type-selection">
                                                    <div class="button-group" style="height: 40px">
                                                        <h4 class="text-center mb-4">Kurumsal Hesap Başvuru Formu</h4>
                                                    </div>
                                                    <input type="hidden" name="type" id="user-type-input"
                                                        value="{{ old('type', 1) }}">
                                                </div>

                                                <div class="mt-3">
                                                    <label class="q-label">Yetkili İsim Soyisim</label>
                                                    <input type="text" name="username"
                                                        class="form-control {{ $errors->has('username') ? 'error-border' : '' }}" required>
                                                    @if ($errors->has('username'))
                                                        <span class="error-message">{{ $errors->first('username') }}</span>
                                                    @endif
                                                </div> 

                                                <div class="corporate-form {{ old('type') == 2 ? 'd-show' : '' }} "
                                                    id="corporateForm">                         


                                                    <!-- Firma Adı -->
                                                    <div class="mt-3">
                                                        <label class="q-label">Mağaza Adı
                                                            <i class="info-icon fas fa-info-circle" data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="Firma adını kısaltmadan aynen yazınız."></i>
                                                        </label>

                                                        <input type="text" name="name"
                                                            class="form-control {{ $errors->has('name') ? 'error-border' : '' }}"
                                                            value="{{ old('name') }}" required>
                                                        @if ($errors->has('name'))
                                                            <span class="error-message">{{ $errors->first('name') }}</span>
                                                        @endif
                                                    </div>

                                                    
                                                    <!-- ticari Unvan -->
                                                    <div class="mt-3">
                                                        <label class="q-label">Ticari Unvan
                                                            <i class="info-icon fas fa-info-circle" data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="Ticari Unvanı kısaltmadan aynen yazınız."></i>
                                                        </label>

                                                        <input type="text" name="store_name"
                                                        class="form-control {{ $errors->has('commercial_title') ? 'error-border' : '' }}"
                                                        value="{{ old('store_name') }}" required>
                                                    @if ($errors->has('store_name'))
                                                        <span class="error-message">{{ $errors->first('store_name') }}</span>
                                                    @endif
                                                    
                                                    </div>

                                                    <div class="mt-3">
                                                        <label class="q-label">Sabit Telefon (Opsiyonel)</label>
                                                        <input type="number" name="phone"
                                                            class="form-control {{ $errors->has('phone') ? 'error-border' : '' }}"
                                                            value="{{ old('phone') }}" maxlength="10">
                                                        @if ($errors->has('phone'))
                                                            <span class="error-message">{{ $errors->first('phone') }}</span>
                                                        @endif
                                                    </div>

                                                    <!-- Kurumsal Hesap Türü -->
                                                    <div class="mt-3">
                                                        <label for="corporate-account-type" class="q-label">Kurumsal Hesap Türü</label>
                                                        <select name="corporate-account-type" id="corporate-account-type"
                                                            class="form-control {{ $errors->has('corporate-account-type') ? 'error-border' : '' }}" required>
                                                            <option value="" disabled selected>Seçiniz</option>
                                                            <option value="Emlak Ofisi"
                                                                {{ old('corporate-account-type') == 'Emlak Ofisi' ? 'selected' : '' }}>
                                                                Emlak Ofisi</option>
                                                            <option value="Banka"
                                                                {{ old('corporate-account-type') == 'Banka' ? 'selected' : '' }}>
                                                                Banka</option>
                                                            <option value="İnşaat Ofisi"
                                                                {{ old('corporate-account-type') == 'İnşaat Ofisi' ? 'selected' : '' }}>
                                                                İnşaat Ofisi</option>
                                                            <option value="Turizm Amaçlı Kiralama"
                                                                {{ old('corporate-account-type') == 'Turizm Amaçlı' ? 'selected' : '' }}>
                                                                Turizm Amaçlı Kiralama</option>
                                                        </select>
                                                        @if ($errors->has('corporate-account-type'))
                                                            <span
                                                                class="error-message">{{ $errors->first('corporate-account-type') }}</span>
                                                        @endif
                                                    </div>

                                                    <!-- İl -->                                    
                                            
                                                        <div class="mt-3">
                                                            <label class="form-label" for="il"> İl:</label>
                                                            <select class="form-control" id="city_id"  name="city_id">
                                                                <option value="">Şehir Seçiniz</option>
                                                                @foreach ($cities as $city)
                                                                    <option value="{{ $city->id }}" required>
                                                                        {{ $city->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mt-3">
                                                            <label class="form-label" for="ilce">İlçe:</label>
                                                            <select class="form-control" id="county_id" name="county_id" disabled required>
                                                                <option value="">İlçe Seçiniz</option>
                                                            </select>
                                                        </div>

                                                        <div class="mt-3">
                                                            <label class="form-label" for="mahalle">Mahalle:</label>
                                                            <select class="form-control" id="neighborhood_id" name="neighborhood_id" disabled required>
                                                                <option value="">Mahalle Seçiniz</option>
                                                            </select>
                                                        </div>
                                                

                                                    <!-- İşletme Türü -->
                                                    <div class="mt-3">
                                                        <label for="" class="q-label mb-2">İşletme Türü</label>
                                                        <div class="companyType">
                                                            <label for="of"  style="margin-right: 10px;"><input type="radio" class="input-radio off"
                                                                    id="of" name="account_type" value="1"
                                                                    {{ old('account_type') == 1 ? 'checked' : '' }}> Şahıs
                                                                Şirketi</label>
                                                            <label for="on"><input type="radio" class="input-radio off"
                                                                    id="on" name="account_type" value="2"
                                                                    {{ old('account_type') == 2 ? 'checked' : '' }}> Limited veya
                                                                Anonim Şirketi</label>
                                                        </div>
                                                    </div>
                                                    <!-- Vergi Dairesi İli -->
                                                    <div class="mt-3">
                                                        <label class="form-label" for="il">Vergi Dairesi:</label>
                                                        <select class="form-control" id="taxOfficeCity"  name="taxOfficeCity" required>
                                                            <option value="">Şehir Seçiniz</option>
                                                            @foreach ($cities as $city)
                                                                <option value="{{ $city->title }}">
                                                                    {{ $city->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="split-form corporate-input mt-3">
                                                        <div class="corporate-input input-city">
                                                            <div class="mbdef">
                                                                <div class="select select-tax-office">
                                                                    <label for="" class="q-label">Vergi Dairesi
                                                                    </label>

                                                                    <select id="taxOffice"
                                                                        class="form-control {{ $errors->has('taxOffice') ? 'error-border' : '' }}"
                                                                        name="taxOffice" required>
                                                                        <option value="">Seçiniz</option>
                                                                    </select>
                                                                    @if ($errors->has('taxOffice'))
                                                                        <span
                                                                            class="error-message">{{ $errors->first('taxOffice') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Vergi No -->
                                                    <div class="split-form corporate-input mt-3">
                                                        <div class="corporate-input input-city">
                                                            <div class="mbdef">
                                                                <div class="select select-tax-office">
                                                                    <label for="" class="q-label">Vergi No</label>
                                                                    <input type="text" id="taxNumber" name="taxNumber"
                                                                        class="form-control {{ $errors->has('taxNumber') ? 'error-border' : '' }}"
                                                                        value="{{ old('taxNumber') }}" required>
                                                                    @if ($errors->has('taxNumber'))
                                                                        <span
                                                                            class="error-message">{{ $errors->first('taxNumber') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    
                                                      <!-- Yetki Belgesi No -->
                                                      <div class="split-form corporate-input mt-3">
                                                        <div class="corporate-input input-city">
                                                            <div class="mbdef">
                                                                <div class="select select-tax-office">
                                                                    <label for="" class="q-label">Yetki Belgesi No</label>
                                                                    <input type="text" id="authority_licence" name="authority_licence" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- TC Kimlik No -->
                                                    <div class="split-form corporate-input mt-3 {{ old('account_type') == 2 ? 'd-none' : '' }}"
                                                        id="idNumberDiv">
                                                        <div class="corporate-input input-city">
                                                            <div class="mbdef">
                                                                <div class="select select-tax-office">
                                                                    <label for="" class="q-label">TC Kimlik No</label>
                                                                    <input type="text" id="idNumber" name="idNumber"
                                                                        class="form-control" value="{{ old('idNumber') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" id="selected-plan-id" name="subscription_plan_id">
                                                <div class="fl-wrap filter-tags clearfix mt-3 mb-3">
                                                    <fieldset>

                                                        <div class="checkboxes float-left">
                                                            <div class="filter-tags-wrap {{ old('type') == '2' ? 'd-show ' : '' }}{{ old('type') == '1' ? 'hidden' : '' }} {{ $errors->has('check-d') ? 'error-check' : '' }}"
                                                                id="corporateFormCheck">
                                                                <input id="check-d" type="checkbox" name="check-d">
                                                                <label for="check-d" style="font-size: 11px;">
                                                                    <a href="/sayfa/kurumsal-uyelik-sozlesmesi" target="_blank">
                                                                        Kurumsal üyelik sözleşmesini
                                                                    </a>
                                                                    okudum onaylıyorum.
                                                                </label>
                                                                <br>
                                                                @if ($errors->has('check-d'))
                                                                    <span
                                                                        class="error-message">{{ $errors->first('check-d') }}</span>
                                                                @endif
                                                            </div>
                                                            <div
                                                                class="filter-tags-wrap {{ $errors->has('check-b') ? 'error-check' : '' }}">
                                                                <input id="check-b" type="checkbox" name="check-b">
                                                                <label for="check-b" style="font-size: 11px;">
                                                                    <a href="/sayfa/kvkk-politikasi" target="_blank">
                                                                        Kvkk metnini
                                                                    </a>
                                                                    okudum onaylıyorum.
                                                                </label>
                                                                <br>
                                                                @if ($errors->has('check-b'))
                                                                    <span
                                                                        class="error-message">{{ $errors->first('check-b') }}</span>
                                                                @endif
                                                            </div>
                                                            <div
                                                                class="filter-tags-wrap {{ $errors->has('check-c') ? 'error-check' : '' }}">
                                                                <input id="check-c" type="checkbox" name="check-c">
                                                                <label for="check-c" style="font-size: 11px;">
                                                                    <a href="/sayfa/gizlilik-sozlesmesi-ve-aydinlatma-metni"
                                                                        target="_blank">
                                                                        Gizlilik sözleşmesi ve aydınlatma metnini
                                                                    </a>
                                                                    okudum onaylıyorum.
                                                                </label>
                                                                <br>
                                                                @if ($errors->has('check-c'))
                                                                    <span
                                                                        class="error-message">{{ $errors->first('check-c') }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="filter-tags-wrap">
                                                                <input id="check-e" type="checkbox" name="check-e">
                                                                <label for="check-e" style="font-size: 11px;">
                                                                    Tarafıma elektronik ileti gönderilmesini kabul ediyorum.
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <button class="btn btn-primary q-button mb-5" type="submit">Kurumsal Üye OL</button>
                                            </form>
                                            @endif
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        // İşletme Türü seçildiğinde TC Kimlik Numarası alanının görünürlüğünü kontrol et
        $(document).ready(function() {
            $('input[name="account_type"]').change(function() {
                var selectedAccountType = $(this).val();
                var idNumberDiv = $('#idNumberDiv');
    
                // Eğer işletme türü 2 (Anonim veya Limited Şirket) ise TC Kimlik Numarası alanını gizle, aksi takdirde göster
                if (selectedAccountType === '2') {
                    idNumberDiv.addClass('d-none'); // TC Kimlik Numarası alanını gizle
                } else {
                    idNumberDiv.removeClass('d-none'); // TC Kimlik Numarası alanını göster
                }
            });
        });
    
        // Sayfa yüklendiğinde de işletme türüne göre TC Kimlik Numarası alanını göster veya gizle
        $(document).ready(function() {
            var selectedAccountType = $('input[name="account_type"]:checked').val();
            var idNumberDiv = $('#idNumberDiv');
    
            if (selectedAccountType === '2') {
                idNumberDiv.addClass('d-none'); // TC Kimlik Numarası alanını gizle
            } else {
                idNumberDiv.removeClass('d-none'); // TC Kimlik Numarası alanını göster
            }
        });
    </script>
    <script>

        $(document).ready(function(){
            $("#mobile_phone").on("input blur", function(){
            var phoneNumber = $(this).val();
            var pattern = /^5[1-9]\d{8}$/;
        
            if (!pattern.test(phoneNumber)) {
              $("#error_message").text("Lütfen geçerli bir telefon numarası giriniz.");
            } else {
              $("#error_message").text("");
            }
                 // Kullanıcı 10 haneden fazla veri girdiğinde bu kontrol edilir
                 $('#mobile_phone').on('keypress', function (e) {
                        var max_length = 10;
                        // Eğer giriş karakter sayısı 10'a ulaştıysa ve yeni karakter ekleme işlemi değilse
                        if ($(this).val().length >= max_length && e.which != 8 && e.which != 0) {
                            // Olayın işlenmesini durdur
                            e.preventDefault();
                        }
                    });
          });
        });
        </script>

<script>
    $(document).ready(function() {

        $('#city_id').change(function() {
            var cityId = $(this).val();
            console.log(cityId)
            if (cityId) {
                $.ajax({
                    url: '{{ route('get-districts', ':city_id') }}'.replace(':city_id',
                        cityId),
                    type: 'GET',
                    data: {
                        city_id: cityId
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data)
                        $('#county_id').empty().prop('disabled', false);
                        $('#county_id').html(
                                '<option value="">İlçe Seçiniz</option>');
                        $.each(data, function(index, district) {
                            $('#county_id').append('<option value="' + district
                                .ilce_key + '">' + district.ilce_title +
                                '</option>');
                        });
                    }
                });
            } else {
                $('#county_id').empty().prop('disabled', true);
            }
        });



        // İlçe seçildiğinde mahallelerin yüklenmesi
        $('#county_id').change(function() {
            var districtId = $(this).val();
            console.log(districtId)
            if (districtId) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('get-neighborhoods', ['districtId' => '__districtId__']) }}"
                        .replace('__districtId__', districtId),
                    success: function(data) {
                        console.log(data)
                        if (data) {
                            $('#neighborhood_id').html(
                                '<option value="">Mahalle Seçiniz</option>');
                            $.each(data, function(index, neighborhoods) {
                                $('#neighborhood_id').append('<option value="' +
                                    neighborhoods.mahalle_id + '">' +
                                    neighborhoods.mahalle_title + '</option>');
                            });
                            $('#neighborhood_id').prop('disabled', false);
                        } else {
                            $('#neighborhood_id').html(
                                '<option value="">Mahalle bulunamadı</option>');
                            $('#neighborhood_id').prop('disabled', true);
                        }
                    }
                });
            } else {
                $('#neighborhood_id').html('<option value="">Mahalle Seçiniz</option>');
                $('#neighborhood_id').prop('disabled', true);
            }
        });
    });
</script>
    <script>
        const individualForm = document.getElementById('individualForm');
        const individualFormCheck = document.getElementById('individualFormCheck');
        const corporateForm = document.getElementById('corporateForm');
        const corporateFormCheck = document.getElementById('corporateFormCheck');
        const userTypeButtons = document.querySelectorAll('.user-type-button');
        const userTypeInput = document.getElementById('user-type-input');

        individualForm.style.display = 'block';
        individualFormCheck.style.display = 'block';
        corporateForm.style.display = 'none';
        corporateFormCheck.style.display = 'none';

        userTypeButtons.forEach(button => {
            button.addEventListener('click', function() {
                userTypeButtons.forEach(btn => btn.classList.remove('active'));

                this.classList.add('active');
                const userType = this.getAttribute('data-user-type');
                userTypeInput.value = userType;

                // individualForm.style.display = 'none';
                // individualFormCheck.style.display = 'none';
                // corporateForm.style.display = 'none';
                // corporateFormCheck.style.display = 'none';


                if (userType === '1' || userType === '21') {
                    individualForm.style.display = 'block';
                    individualFormCheck.style.display = 'block';
                    individualFormCheck.classList.remove('hidden');
                    individualForm.classList.remove("hidden");

                    corporateForm.classList.remove('d-show');
                    corporateFormCheck.classList.remove('d-show');
                    corporateForm.classList.add('hidden');
                    corporateFormCheck.classList.add('hidden');

                } else if (userType === '2') {
                    corporateForm.style.display = 'block';
                    corporateFormCheck.style.display = 'block';
                    corporateFormCheck.classList.remove('hidden');
                    individualForm.style.display = 'none';
                    individualFormCheck.style.display = 'block';
                    corporateForm.classList.remove("hidden");

                    individualForm.classList.remove('d-show');
                    individualFormCheck.classList.remove('d-show');
                    individualForm.classList.add('hidden');
                    individualFormCheck.classList.add('hidden');



                }
            });
        });

        const companyTypeRadios = document.querySelectorAll('input[name="account_type"]');
        const taxNumberInput = document.getElementById('taxNumber');
        const idNumberInput = document.getElementById('idNumberDiv');

        companyTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === '1') { // Şahıs Şirketi seçildiğinde
                    taxNumberInput.style.display = 'block'; // Vergi Numarası görünür
                    idNumberInput.style.display = 'block'; // TC Kimlik Numarası gizli
                } else if (this.value === '2') { // Limited veya Anonim Şirketi seçildiğinde
                    taxNumberInput.style.display = 'block'; // Vergi Numarası gizli
                    idNumberInput.style.display = 'none'; // TC Kimlik Numarası görünür
                }
            });
        });

        function deselectOtherPlans() {
            // Tüm abonelik planı düğmelerini seçin
            const planButtons = document.querySelectorAll('.plan-button');

            // Her düğmeden "selected-plan-btn" sınıfını kaldırın
            planButtons.forEach(function(button) {
                button.classList.remove("selected-plan-btn");
                button.classList.add("btn-primary", "btn"); // Önceki stilini geri yükleyin
            });
        }

        function selectPlan(button) {
            const planId = button.getAttribute('data-plan-id');
            const planName = button.getAttribute('data-plan-name');
            const planPrice = button.getAttribute('data-plan-price');
            toastr.success("Abonelik Planı Başarıyla Seçildi");
            // Diğer plan düğmelerinden "selected-plan-btn" sınıfını kaldırın
            deselectOtherPlans();

            // Button'un sınıfını güncelle
            button.classList.remove("btn-primary", "btn");
            button.classList.add("btn-success", "selected-plan-btn");
            document.getElementById('selected-plan-id').value = planId;
        }
    </script>
    <script>
        'use strict';
        $('#corporate-account-type').on('change', function() {
            let value = $(this).val();
            let data = {
                "Emlakçı": "tab-emlakci",
                "Banka": "tab-banka",
                "İnşaat": "tab-insaat",
            };

            $('.sub-plan-tab').addClass('d-none');
            $(`.sub-plan-tab.${data[value]}`).removeClass('d-none');
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script>
           
           $(document).ready(function() {
        $('#taxOfficeCity').change(function() {
            var selectedCity = $(this).val();
            console.log(selectedCity)
            $.ajax({
                type: 'GET',
                url: '/get-tax-office/' + selectedCity,
                success: function(data) {
                    console.log(data)
                    var taxOffice = $('#taxOffice');
                    taxOffice.empty();
                    $.each(data, function(index, office) {
                        taxOffice.append('<option value="' + office.id + '">' + office
                            .daire +
                            '</option>');
                    });
                }
            });
        });
        });
    </script>
@endsection

@section('styles')
    <style>
        
        .formInput {
            display: block;
            width: 100%;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 2.0;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #b9b9b9;
            border-radius: .35rem;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.07);
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .formInput:focus {
            color: #495057;
            background-color: #fff;
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .25);
        }

        .loginItems .login-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin: 0 auto;
}
        .loginItems {
    padding-bottom: 100px;
    padding-top: 100px;
    background-color: #f2f2f2;
}

.loginItems .button {
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px gray solid;
    border-radius: 24px;
    background-color: white;
    padding: .5rem 4rem;
    margin: 1rem 0;
}

.loginItems .button:hover {
    background-color: #f5f5f5;
    cursor: pointer;
}

.loginItems .button .img {
    padding-right: 1rem;
}

.loginItems .button p {
    font-weight: bolder;
    padding-bottom: 0 !important;
    margin-bottom: 0 !important;
}

.loginItems .img {
    max-width: 40px;
    max-height: 40px;
}

.loginItems .form {
    margin: 1rem 0;
    display: flex;
    flex-direction: column;
}

.loginItems input {
    width: 100% !important;
    border-radius: 3px !important;
    background-color: #fafafa !important;
    width: inherit;
    height: 40px;
    padding: 10px;
    color: #666;
    height: 40px;
}
        .filter-tags-wrap{
            margin-bottom: 8px;
        }
        .inner-pages .checkboxes label:before {
            content: "";
            display: inline-block;
            width: 19px;
            height: 19px;
            margin-right: 10px;
            position: absolute;
            left: 0;
            top: -3px;
            background-color: #fff;
            border: 2px solid #d0d0d0;
            border-radius: 2px;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-transition: border-color 0.3s;
            transition: border-color 0.3s;
        }
        #passwordInput {
            position: relative;

        }

        #passwordInput2 {
            position: relative;

        }

        .field-icon {
            float: right;
            margin-right: 9px;
            margin-top: -27px;
            position: relative;
            z-index: 2;
            z-index: 9999;
        }

        .hidden {
            display: none !important;
        }

        .d-show {
            display: block !important;
        }

        .error-border {
            border-color: #EA2B2E !important;
        }

        .error-message {
            color: red;
            font-size: 11px;
        }
        .success-message {
            color: green;
            font-size: 11px;
        }
    </style>
@endsection
