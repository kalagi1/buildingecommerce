@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-300 border-bottom mb-4">
                    <div class="card-header border-bottom border-300 bg-soft">
                        <h4 class="text-900 mb-0" data-anchor="data-anchor" id="soft-buttons">Profili Güncelle</h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success text-white">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('institutional.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Diğer giriş alanlarını buraya ekleyin -->
                            <div class="corporate-form" id="corporateForm">
                                <!-- İsim -->
                                <div class="mt-3">
                                    <label class="q-label">İsim</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $user->name) }}">
                                </div>

                                <!-- E-Posta -->
                                <div class="mt-3">
                                    <label class="q-label">E-Posta</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $user->email) }}">
                                </div>

                                <!-- Sabit Telefon -->
                                <div class="mt-3">
                                    <label class="q-label">Sabit Telefon</label>
                                    <input type="number" name="phone" class="form-control"
                                        value="{{ old('phone', $user->phone) }}">
                                </div>

                                <!-- Doğum Tarihi -->
                                <div class="mt-3">
                                    <label class="q-label">Doğum Tarihi</label>
                                    <input type="date" name="birthday" class="form-control"
                                        value="{{ old('birthday', $user->birthday) }}">
                                </div>

                                <!-- Faaliyet Alanı -->
                                <div class="mt-3">
                                    <label class="q-label">Faaliyet Alanı</label>
                                    <select class="form-control" name="activity">
                                        <option value="">Seçiniz</option>
                                        <option value="200003"
                                            {{ old('activity', $user->activity) == '200003' ? 'selected' : '' }}>Alışveriş
                                        </option>
                                        <option value="200002"
                                            {{ old('activity', $user->activity) == '200002' ? 'selected' : '' }}>Emlak
                                        </option>
                                        <option value="200020"
                                            {{ old('activity', $user->activity) == '200020' ? 'selected' : '' }}>Günlük
                                            Kiralık</option>
                                        <!-- Diğer seçenekleri buraya ekleyin -->
                                    </select>
                                </div>

                                <!-- İl -->
                                <div class="mt-3">
                                    <label class="q-label">İl</label>
                                    <select class="form-control" id="citySelect" name="city_id">
                                        <option value="">Seçiniz</option>
                                        @foreach ($cities as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('city_id', $user->city_id) == $item->id ? 'selected' : '' }}>
                                                {{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- İlçe -->
                                <div class="mt-3">
                                    <label class="q-label">İlçe</label>
                                    <select class="form-control" name="county_id" id="countySelect">
                                        <option value="">Seçiniz</option>
                                        @foreach ($counties as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('county_id', $user->county_id) == $item->id ? 'selected' : '' }}>
                                                {{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- İşletme Türü -->
                                <div class="mt-3">
                                    <label class="q-label">İşletme Türü</label>
                                    <div class="companyType">
                                        <label for="of" class="mr-3"><input type="radio" class="input-radio off"
                                                id="of" name="account_type" value="1"
                                                {{ old('account_type', $user->account_type) == 'Şahıs Şirketi' ? 'checked' : '' }}
                                                style="margin-right: 5px">Şahıs
                                            Şirketi</label>
                                        <label for="on" class="ml-3" style="margin-left: 20px"><input type="radio"
                                                class="input-radio off" id="on" name="account_type" value="2"
                                                {{ old('account_type', $user->account_type) == 'Limited veya Anonim Şirketi' ? 'checked' : '' }}
                                                style="margin-right: 5px">Limited
                                            veya Anonim Şirketi</label>
                                    </div>
                                </div>

                                <!-- Vergi Dairesi İli -->
                                <div class="split-form corporate-input mt-3">
                                    <div class="corporate-input input-city">
                                        <div class="mbdef">
                                            <div class="select select-tax-office">
                                                <label for="" class="q-label">Vergi Dairesi İli</label>
                                                <select id="taxOfficeCity" class="form-control" name="taxOfficeCity">
                                                    <option value="">Seçiniz</option>
                                                    @foreach ($cities as $item)
                                                        <option value="{{ $item->title }}"
                                                            {{ old('taxOfficeCity', $user->taxOfficeCity) == $item->id ? 'selected' : '' }}>
                                                            {{ $item->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Vergi Dairesi -->
                                <div class="split-form corporate-input mt-3">
                                    <div class="corporate-input input-city">
                                        <div class="mbdef">
                                            <div class="select select-tax-office">
                                                <label for="" class="q-label">Vergi Dairesi</label>
                                                <select id="taxOffice" class="form-control" name="taxOffice">
                                                    <option value="">Seçiniz</option>
                                                    @foreach ($taxOffices as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('taxOffice', $user->taxOffice) == $item->id ? 'selected' : '' }}>
                                                            {{ $item->daire }}</option>
                                                    @endforeach
                                                </select>
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
                                                    class="form-control"
                                                    value="{{ old('taxNumber', $user->taxNumber) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="split-form corporate-input mt-3" id="idNumberDiv">
                                    <div class="corporate-input input-city">
                                        <div class="mbdef">
                                            <div class="select select-tax-office">
                                                <label for="" class="q-label">TC Kimlik No</label>
                                                <input type="text" id="idNumber" name="idNumber"
                                                    class="form-control" value="{{ old('idNumber', $user->idNumber) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <button type="submit" class="btn btn-primary mt-5">Güncelle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        const accountTypeRadios = document.querySelectorAll('input[name="account_type"]');
        const idNumberDiv = document.getElementById('idNumberDiv');

        // Sayfa yüklendiğinde mevcut kullanıcının hesap türünü kontrol edin ve TC Kimlik Numarası alanını gösterin veya gizleyin
        function toggleIdNumberVisibility() {
            const selectedAccountType = document.querySelector('input[name="account_type"]:checked').value;
            if (selectedAccountType === '1') {
                idNumberDiv.style.display = 'block'; // Şahıs Şirketi seçildiyse göster
            } else {
                idNumberDiv.style.display = 'none'; // Diğer türler seçildiyse gizle
            }
        }

        // Sayfa yüklendiğinde hesap türünü kontrol edin ve TC Kimlik Numarası alanını gösterin veya gizleyin
        toggleIdNumberVisibility();

        // Hesap türü değiştikçe TC Kimlik Numarası alanının görünürlüğünü güncelleyin
        accountTypeRadios.forEach(radio => {
            radio.addEventListener('change', toggleIdNumberVisibility);
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

        $('#citySelect').change(function() {
            var selectedCity = $(this).val();

            $.ajax({
                type: 'GET',
                url: '/get-counties/' + selectedCity,
                success: function(data) {
                    var countySelect = $('#countySelect');
                    countySelect.empty();
                    $.each(data, function(index, county) {
                        countySelect.append('<option value="' + county.id + '">' + county
                            .title +
                            '</option>');
                    });
                }
            });
        });

        $('#taxOfficeCity').change(function() {
            var selectedCity = $(this).val();
            console.log(selectedCity);
            $.ajax({
                type: 'GET',
                url: '/get-tax-office/' + selectedCity,
                success: function(data) {
                    console.log(data);
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

        $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                items: 2, // Varsayılan olarak 2 öğe göster
                loop: true,
                margin: 10,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1

                    },
                    768: {
                        items: 1 // 768 piksel genişlikte 1 öğe göster
                    },
                    1000: {
                        items: 2
                    }
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

    <style>
        .companyType {
            display: flex;
            align-items: center;
            justify-content: start
        }
    </style>
@endsection
