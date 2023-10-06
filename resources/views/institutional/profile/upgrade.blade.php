@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            @foreach ($plans as $plan)
            <div class="col-lg-4">
                <div class="card shadow-sm border-300 border-bottom mb-4">
                    <div class="card-header">
                        {{$plan->name}}
                    </div>
                    <div class="card-body p-0">
                        @if (auth()->user()->corporate_type == 'Emlakçı')
                            <div class="py-2 px-3 border-bottom d-flex">
                                <b>Konut Limiti:</b>
                                <span style="margin-left: auto;">
                                    {{$plan->housing_limit}}
                                </span>
                            </div>
                            <div class="py-2 px-3 border-bottom d-flex">
                                <b>Kullanıcı Limiti:</b>
                                <span style="margin-left: auto;">
                                    {{$plan->user_limit}}
                                </span>
                            </div>
                            <div class="py-2 px-3 border-bottom d-flex w-100">
                                <b>Fiyat:</b>
                                <span class="text-primary" style="margin-left: auto; font-weight: bold; font-size: 20px;">
                                    {{$plan->price}}TL
                                </span>
                            </div>
                            <div class="py-2 px-3">
                                <form method="POST" action="{{route('institutional.profile.upgrade.action', [$plan->id])}}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-lg btn-block w-100">{{$current && $current->price <= $plan->price ? 'SATIN AL' : 'YÜKSELT'}}</button>
                                </form>
                            </div>
                        @else
                            <div class="py-2 px-3 border-bottom d-flex">
                                <b>Proje Limiti:</b>
                                <span style="margin-left: auto;">
                                    {{$plan->project_limit}}
                                </span>
                            </div>
                            <div class="py-2 px-3 border-bottom d-flex">
                                <b>Konut Limiti:</b>
                                <span style="margin-left: auto;">
                                    {{$plan->housing_limit}}
                                </span>
                            </div>
                            <div class="py-2 px-3 border-bottom d-flex">
                                <b>Kullanıcı Limiti:</b>
                                <span style="margin-left: auto;">
                                    {{$plan->user_limit}}
                                </span>
                            </div>
                            <div class="py-2 px-3 border-bottom d-flex w-100">
                                <b>Fiyat:</b>
                                <span class="text-primary" style="margin-left: auto; font-weight: bold; font-size: 20px;">
                                    {{$plan->price}}TL
                                </span>
                            </div>
                            <div class="py-2 px-3">
                                <form method="POST" action="{{route('institutional.profile.upgrade.action', [$plan->id])}}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-lg btn-block w-100">{{$current && $current->price <= $plan->price ? 'SATIN AL' : 'YÜKSELT'}}</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
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
