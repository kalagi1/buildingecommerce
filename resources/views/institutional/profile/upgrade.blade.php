@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="mb-4">Premium Paketler</h2>
            </div>
            @foreach ($plans as $plan)
                <div class="col-lg-4">
                    <div class="card shadow-sm border-300 border-bottom mb-4">
                        <div class="card-header">
                            {{ $plan->name }}
                        </div>
                        <div class="card-body p-0">
                            @if (!auth()->user()->corporate_type == 'Emlakçı')
                                <div class="py-2 px-3 border-bottom d-flex">
                                    <b>Proje Limiti:</b>
                                    <span style="margin-left: auto;">
                                        {{ $plan->project_limit }}
                                    </span>
                                </div>
                            @endif
                            <div class="py-2 px-3 border-bottom d-flex">
                                <b>Konut Limiti:</b>
                                <span style="margin-left: auto;">
                                    {{ $plan->housing_limit }}
                                </span>
                            </div>
                            <div class="py-2 px-3 border-bottom d-flex">
                                <b>Alt Kullanıcı Limiti:</b>
                                <span style="margin-left: auto;">
                                    {{ $plan->user_limit }}
                                </span>
                            </div>
                            <div class="py-2 px-3 border-bottom d-flex w-100">
                                <b>Fiyat:</b>
                                <span class="text-primary" style="margin-left: auto; font-weight: bold; font-size: 20px;">
                                    {{ $plan->price }}TL
                                </span>
                            </div>
                            <div class="py-2 px-3">

                                @if (Auth::user()->subscription_plan_id != null)
                                    <button type="button"
                                        class="btn @if ($current->subscriptionPlan->id == $plan->id && $current->status == 0) btn-warning @else btn-primary @endif paymentClick btn-lg btn-block w-100"
                                        data-toggle="modal" data-target="#paymentModal{{ $plan->id }}"
                                        {{ $current->subscriptionPlan->id == $plan->id && $current->status != 2 ? 'disabled' : '' }}>
                                        @if ($current->subscriptionPlan->id == $plan->id && $current->status != 2)
                                            @if ($current->status == 0)
                                                Onay Bekleniyor
                                            @else
                                                AKTİF
                                            @endif
                                        @elseif($current->status != 2)
                                            @if ($current->subscriptionPlan->price >= $plan->price)
                                                SATIN AL
                                            @else
                                                YÜKSELT
                                            @endif
                                            @if ($current->subscriptionPlan->price < $plan->price)
                                            <i class="fas fa-angle-double-up ml-3"></i>
                                        @endif
                                        @else
                                            SATIN AL
                                        @endif
                                     
                                    </button>
                                @else
                                    <button type="button" class="btn btn-primary paymentClick btn-lg btn-block w-100"
                                        data-toggle="modal" data-target="#paymentModal{{ $plan->id }}">
                                        SEPETE EKLE
                                    </button>
                                @endif



                                <!-- Ödeme Modalı -->
                                <div class="modal fade paymentModalStart" id="paymentModal{{ $plan->id }}"
                                    tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="paymentModalLabel">Emlak Sepette Ödeme Adımı
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="invoice">
                                                    <div class="invoice-header mb-3">
                                                        <strong>Fatura Tarihi: {{ date('d.m.Y') }}</strong>
                                                    </div>
                                                    <p>Seçtiğiniz Plan: {{ $plan->name }}</p>
                                                    <p>Plan Fiyatı: {{ $plan->price }} ₺</p>
                                                    <div class="invoice-total mt-3">
                                                        <strong class="mt-3">EFT/Havale yapacağınız bankayı
                                                            seçiniz</strong>
                                                        <div class="row mb-3 px-5 mt-3">
                                                            @foreach ($bankAccounts as $bankAccount)
                                                                <div class="col-md-4 bank-account"
                                                                    bank_id="{{ $bankAccount->id }}"
                                                                    data-iban="{{ $bankAccount->iban }}"
                                                                    data-title="{{ $bankAccount->receipent_full_name }}">
                                                                    <img src="{{ URL::to('/') }}/{{ $bankAccount->image }}"
                                                                        alt=""
                                                                        style="width: 100%;height:100px;object-fit:contain;cursor:pointer">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div id="ibanInfo"></div>
                                                        <strong>Ödeme işlemini tamamlamak için, lütfen bu
                                                            <span style="color:red" class="uniqueCode"></span> kodu
                                                            kullanarak ödemenizi
                                                            yapın. IBAN açıklama
                                                            alanına
                                                            bu kodu eklemeyi unutmayın. Ardından "Ödemeyi Tamamla"
                                                            düğmesine tıklayarak işlemi
                                                            bitirin.</strong>

                                                    </div>
                                                    <button type="submit" class="btn btn-primary completePaymentButton"
                                                        data-toggle="modal"
                                                        data-target="#finalConfirmationModal{{ $plan->id }}">Ödeme

                                                        Yap</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="finalConfirmationModal{{ $plan->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="finalConfirmationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="finalConfirmationModalLabel">Ödeme Onayı</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Ödemeniz başarıyla tamamlamak için lütfen aşağıdaki adımları takip edin:
                                                </p>
                                                <ol>
                                                    <li>
                                                        <strong style="color:red" class="uniqueCodeRetry"></strong> kodunu
                                                        EFT/Havale açıklama
                                                        alanına yazdığınızdan emin olun.
                                                    </li>
                                                    <li>
                                                        Son olarak, işlemi bitirmek için aşağıdaki butona tıklayın: <br>

                                                        <form
                                                            action="{{ route('institutional.profile.upgrade.action', [$plan->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="key" class="orderKey">
                                                            <button type="submit"
                                                                class="btn btn-primary paySuccess mt-3">Ödemeyi Tamamla
                                                                <svg viewBox="0 0 576 512" class="svgIcon">
                                                                    <path
                                                                        d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24H360c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z">
                                                                    </path>
                                                                </svg></button>
                                                        </form>
                                                    </li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection


@section('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            // Başlangıçta ödeme düğmesini devre dışı bırak
            $('.completePaymentButton').prop('disabled', true);

            $(".paymentClick").on("click", function() {
                var uniqueCode = generateUniqueCode();
                console.log(uniqueCode);
                $('.uniqueCode').text(uniqueCode);
                $('.uniqueCodeRetry').text(uniqueCode);
                $(".orderKey").val(uniqueCode);
            });


            // Rastgele bir benzersiz kod oluşturan fonksiyon
            function generateUniqueCode() {
                return Math.random().toString(36).substring(2, 10).toUpperCase();
            }
            $('.bank-account').on('click', function() {
                // Tüm banka görsellerini seçim olmadı olarak ayarla
                $('.bank-account').removeClass('selected');

                // Seçilen banka görselini işaretle
                $(this).addClass('selected');

                // İlgili IBAN bilgisini al
                var selectedBankIban = $(this).data('iban');
                var selectedBankTitle = $(this).data('title');


                // IBAN bilgisini ekranda göster
                $('#ibanInfo').text(selectedBankTitle + " : " + selectedBankIban);
                // Ödeme düğmesini etkinleştir
                $('.completePaymentButton').prop('disabled', false);
            });

            $('.completePaymentButton').on('click', function() {
                $('.paymentModalStart').css({
                    display: "none"
                });
                $('#finalConfirmationModal').modal('show');
            });
        });
    </script>


    <style>
        .companyType {
            display: flex;
            align-items: center;
            justify-content: start
        }

        .selected {
            border: 2px solid red;
        }

        .svgIcon {
            width: 16px;
        }

        .svgIcon path {
            fill: white;
        }
    </style>
@endsection
