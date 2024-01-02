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
                            <div class="alert alert-danger text-white">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success text-white text-white">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('institutional.profile.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Diğer giriş alanlarını buraya ekleyin -->
                            <div class="corporate-form" id="corporateForm">
                                <!-- İsim -->
                                <!-- Profil Resmi -->
                                <div class="mt-3">
                                    <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}"
                                        alt="Profil Resmi" width="100"><br>
                                    <label class="q-label">Profil Fotoğrafı Seç</label>
                                    <input type="file" name="profile_image" class="form-control"
                                        accept=".jpeg, .jpg, .png">
                                </div>

                                <!-- Banner Rengi -->
                                <div class="mt-3">
                                    <label class="q-label">Banner Rengi</label><br>
                                    <input type="color" name="banner_hex_code" class="form-control"
                                        value="{{ old('banner_hex_code', $user->banner_hex_code) }}">
                                </div>
                                <div class="mt-3">
                                    <label class="q-label">İsim</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $user->name) }}">
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
                        countySelect.append('<option value="' + county.ilce_key + '">' + county
                            .ilce_title +
                            '</option>');
                    });
                }
            });
        });


        $('#countySelect').change(function() {
            var selectedCounty = $(this).val();

            $.ajax({
                type: 'GET',
                url: '/get-neighborhoods/' + selectedCounty,
                success: function(data) {
                    var neighborhoodSelect = $('#neighborhoodSelect');
                    neighborhoodSelect.empty();
                    $.each(data, function(index, county) {
                        neighborhoodSelect.append('<option value="' + county.mahalle_key +
                            '">' +
                            county
                            .mahalle_title +
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
