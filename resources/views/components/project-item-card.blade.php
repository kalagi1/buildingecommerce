@props([
    'project',
    'i',
    'projectHousingsList',
    'sold',
    'isUserSame',
    'lastHousingCount',
    'projectDiscountAmount',
    'bankAccounts',
    'sumCartOrderQt',
    'blockHousingCount',
    'key',
    'previousBlockHousingCount',
    'allCounts',
    'cities',
    'towns',
    'statusSlug',
    'blockName',
])

@php
    if ($key == 0) {
        $keyIndex = $i + 1;
    } else {
        $keyIndex = $i + 1 + $allCounts;
    }
@endphp

@if (isset($projectHousingsList[$keyIndex]))
    <div class="col-md-12 col-12">
        <div class="project-card mb-3">
            <div class="row">
                <div class="col-md-3">
                    <a href="{{ route('project.housings.detail', [
                        'projectSlug' =>
                            $statusSlug .
                            '-' .
                            $project->step2_slug .
                            '-' .
                            $project->housingtype->slug .
                            '-' .
                            $project->slug .
                            '-' .
                            strtolower($project->city->title) .
                            '-' .
                            strtolower($project->county->ilce_title),
                        'projectID' => $project->id + 1000000,
                        'housingOrder' => $i + 1,
                    ]) }}"
                        style="height: 100%">

                        <div class="d-flex" style="height: 100%;">
                            <div
                                style="background-color: #EA2B2E !important; border-radius: 0px 8px 0px 8px; height:100%">
                                <p
                                    style="padding: 10px; color: white; height: 100%; display: flex; align-items: center; text-align:center; ">
                                    No<br>{{ $i + 1 }}
                                </p>
                            </div>
                            <div class="project-single mb-0 bb-0 aos-init aos-animate" data-aos="fade-up">
                                <div class="button-effect-div">
                                    <span
                                        class="btn 
                                    @if (($sold && $sold->status == '1') || $projectHousingsList[$keyIndex]['off_sale[]'] != '[]') disabledShareButton @else addCollection mobileAddCollection @endif"
                                        data-type='project' data-project='{{ $project->id }}'
                                        data-id='{{ $keyIndex }}'>
                                        <i class="fa fa-bookmark-o"></i>
                                    </span>
                                    <span class="btn toggle-project-favorite bg-white"
                                        data-project-housing-id="{{ $keyIndex }}"
                                        data-project-id={{ $project->id }}>
                                        <i class="fa fa-heart-o"></i>
                                    </span>
                                </div>
                                <div class="homes position-relative">
                                    <img src="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[$keyIndex]['image[]'] }}"
                                        alt="home-1" class="img-responsive"
                                        style="height: 100px !important; object-fit: cover">
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-9 col-md-9 homes-content pb-0 mb-44 aos-init aos-animate" data-aos="fade-up">
                    <div class="row align-items-center justify-content-between mobile-position"
                        @if (($sold && $sold->status != '2') || $projectHousingsList[$keyIndex]['off_sale[]'] != '[]') style="background: #EEE !important;height:100% !important" @endif>
                        <div class="col-md-9">
                            @php
                                $off_sale_check = $projectHousingsList[$keyIndex]['off_sale[]'] == '[]';
                                $share_sale = $projectHousingsList[$keyIndex]['share_sale[]'] ?? null;
                                $number_of_share = $projectHousingsList[$keyIndex]['number_of_shares[]'] ?? null;
                                $sold_check = $sold && in_array($sold->status, ['1', '0']);
                                $discounted_price = $projectHousingsList[$keyIndex]['price[]'] - $projectDiscountAmount;
                            @endphp

                            <div class="homes-list-div"
                                @if (isset($share_sale) && !empty($share_sale) && $number_of_share != 0) style="flex-direction: column !important;" @endif>
                                <ul class="homes-list clearfix pb-3 d-flex"
                                    @if (isset($share_sale) && !empty($share_sale) && $number_of_share != 0) style="height: 90px !important" @endif>
                                    <li class="d-flex align-items-center itemCircleFont">
                                        <i class="fa fa-circle circleIcon mr-1" style="color: black;"
                                            aria-hidden="true"></i>
                                        <span>{{ $project->housingType->title }}</span>
                                        @foreach (['column1', 'column2', 'column3'] as $column)
                                            @php
                                                $column_name = $project->listItemValues->{$column . '_name'} ?? '';
                                                $column_additional =
                                                    $project->listItemValues->{$column . '_additional'} ?? '';
                                                $column_name_exists =
                                                    $column_name &&
                                                    isset($projectHousingsList[$keyIndex][$column_name . '[]']);
                                            @endphp

                                            @if ($column_name_exists)
                                    <li class="d-flex align-items-center itemCircleFont">
                                        <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                        <span>
                                            {{ $projectHousingsList[$keyIndex][$column_name . '[]'] }}
                                            @if ($column_additional)
                                                {{ $column_additional }}
                                            @endif
                                        </span>
                                    </li>
@endif
@endforeach

<li class="the-icons mobile-hidden">
    <span style="width:100%;text-align:center">

        @if (isset($share_sale) && !empty($share_sale) && $number_of_share != 0)
            <span class="text-center w-100">
                1 Pay Fiyatı
            </span>
        @endif

        @if ($off_sale_check && $projectDiscountAmount && !$sold_check)
            <h6 style="color: #274abb !important; position: relative; top: 4px; font-weight: 600">
                @if (isset($share_sale) && !empty($share_sale) && $number_of_share != 0)
                    {{ number_format($projectHousingsList[$keyIndex]['price[]'] / $number_of_share, 0, ',', '.') }}
                    ₺
                @else
                    {{ number_format($projectHousingsList[$keyIndex]['price[]'], 0, ',', '.') }}
                    ₺
                @endif
            </h6>

            <h6
                style="color: #e54242 !important;position: relative;top:4px;font-weight:600;font-size: 11px;text-decoration:line-through;">
                {{ number_format($projectHousingsList[$keyIndex]['price[]'], 0, ',', '.') }}
                ₺
            </h6>
        @elseif ($off_sale_check && !$sold_check)
            <h6 style="color: #274abb !important; position: relative; top: 4px; font-weight: 600">
                @if (isset($share_sale) && !empty($share_sale) && $number_of_share != 0)
                    {{ number_format($projectHousingsList[$keyIndex]['price[]'] / $number_of_share, 0, ',', '.') }}
                    ₺
                @else
                    {{ number_format($projectHousingsList[$keyIndex]['price[]'], 0, ',', '.') }}
                    ₺
                @endif
            </h6>

        @endif
    </span>
</li>


</ul>

@if (isset($share_sale) && !empty($share_sale) && $number_of_share != 0)
    <div class="bar-chart">
        <div class="progress" style="border-radius: 0 !important">
            <div class="progress-bar"
                @if (isset($sumCartOrderQt[$keyIndex]) &&
                        isset($sumCartOrderQt[$keyIndex]['qt_total']) &&
                        isset($maxQtTotal) &&
                        $maxQtTotal > 0) style="width: {{ (100 / $number_of_share) * $sumCartOrderQt[$keyIndex]['qt_total'] }}% !important"
                                @else
                                    style="width: 0% !important" @endif>
            </div>
        </div>
    </div>
@endif

</div>

@php
    // Example: Set a default value for $maxQtTotal
    $maxQtTotal = 100; // Set the appropriate default value

    // OR check if $maxQtTotal is defined
    if (!isset($maxQtTotal)) {
        $maxQtTotal = 100; // Set the appropriate default value
    }
@endphp



</div>

<div class="col-md-3 mobile-hidden" style="height: 100%; padding: 0">
    <div class="homes-button" style="width: 100%; height: 100px !important">
        @if ($sold_check && $sold->status == '1')
            @php
                $neighborView = null;

                if (Auth::check()) {
                    $neighborView = App\Models\NeighborView::where('user_id', Auth::user()->id)
                        ->where('project_id', $project->id)
                        ->where('housing', $keyIndex)
                        ->first();
                }
            @endphp

            @if (!$neighborView && $sold->status == '1' && isset($sold->is_show_user) && $sold->is_show_user == 'on' && !$isUserSame)
                <span class="first-btn see-my-neighbor"
                    @if (Auth::check()) data-bs-toggle="modal"
                                    data-bs-target="#neighborViewModal{{ $sold->id }}" data-order="{{ $sold->id }}" @endif>
                    <span><svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg> Komşumu Gör</span>
                </span>
            @elseif($neighborView && $neighborView->status == '0')
                <span class="first-btn see-my-neighbor payment">
                    <span> <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12">
                            </line>
                            <line x1="12" y1="16" x2="12.01" y2="16">
                            </line>
                        </svg>
                        Ödeme Onayı </span>
                </span>
            @elseif($neighborView && $neighborView->status == '1')
                <span class="first-btn see-my-neighbor success">
                    <a href="tel: {{ $sold->phone }}" style="color:white">
                        <span>
                            Komşunuz:
                            {{ $sold->name }} <br>
                            <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor"
                                stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                class="css-i6dzq1">
                                <polyline points="19 1 23 5 19 9"></polyline>
                                <line x1="15" y1="5" x2="23" y2="5">
                                </line>
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                            {{ $sold->phone }}
                        </span>
                    </a>

                </span>
            @elseif($isUserSame == true)
                <span class="first-btn see-my-neighbor success">
                    <span>
                        İLANI SİZ SATIN ALDINIZ
                    </span>

                </span>
            @else
                <button class="first-btn payment-plan-button" project-id="{{ $project->id }}"
                    data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0) && empty($share_sale)) || $projectHousingsList[$keyIndex]['off_sale[]'] != '[]' ? '1' : '0' }}"
                    order="{{ $keyIndex }}" data-block="{{ $blockName }}"
                    data-payment-order="{{ $i + 1 }}">
                    Ödeme Detayı
                </button>
            @endif
        @else
            @if ($projectHousingsList[$keyIndex]['off_sale[]'] != '[]')
                @if (Auth::user())
                    <button class="first-btn payment-plan-button" data-toggle="modal"
                        data-target="#exampleModal{{ $keyIndex }}">
                        Başvuru Yap
                    </button>
                @else
                    <a href="{{ route('client.login') }}" class="first-btn payment-plan-button">
                        Başvuru Yap
                    </a>
                @endif
            @else
                <button class="first-btn payment-plan-button" project-id="{{ $project->id }}"
                    data-block="{{ $blockName }}"
                    data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0)) || $projectHousingsList[$keyIndex]['off_sale[]'] != '[]' ? '1' : '0' }}"
                    order="{{ $keyIndex }}" data-payment-order="{{ $i + 1 }}">
                    Ödeme Detayı
                </button>
            @endif



        @endif


        @if ($projectHousingsList[$keyIndex]['off_sale[]'] != '[]' && !$sold)
            <button class="btn second-btn"
                style="background: #EA2B2E !important; width: 100%; color: White; height: auto !important">
                <span class="text">Satışa Kapatıldı</span>
            </button>
        @else
            @if (
                ($sold && $sold->status != '2' && empty($share_sale)) ||
                    (isset($sumCartOrderQt[$keyIndex]) && $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share))
                <button class="btn second-btn"
                    @if ($sold->status == '0') style="background: orange !important; color: White; height: auto !important" @else  style="background: #EA2B2E !important; color: White; height: auto !important" @endif>
                    @if ($sold->status == '0' && empty($share_sale))
                        <span class="text">Rezerve Edildi</span>
                    @elseif (
                        ($sold->status == '1' && empty($share_sale)) ||
                            (isset($sumCartOrderQt[$keyIndex]) && $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share))
                        <span class="text">Satıldı</span>
                    @endif
                </button>
            @else
                <button class="CartBtn second-btn mobileCBtn" data-type='project' data-project='{{ $project->id }}'
                    style="height: auto !important" data-id='{{ $keyIndex }}' data-share="{{ $share_sale }}"
                    data-number-share="{{ $number_of_share }}">
                    <span class="IconContainer">
                        <img src="{{ asset('sc.png') }}" alt="">
                    </span>
                    <span class="text">Sepete Ekle</span>
                </button>
            @endif
        @endif
    </div>
</div>
</div>
</div>
</div>
</div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal{{ $keyIndex }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-body">
                <h3 class="modal-title" style="margin:10px;font-size:12px !important;text-align:center"
                    id="exampleModalLabel"> {{ $project->project_title }} Projesi {{ $keyIndex }} No'lu İlan için
                    Başvuru Yap</h3>
                <hr>
                <form method="POST" action="{{ route('give_offer') }}">
                    @csrf
                    {{-- {{ $i+1 }} --}}
                    <input type="hidden" value="{{ $keyIndex }}" name="roomId">
                    <input type="hidden" value="{{ $project->id }}" name="projectId">
                    <input type="hidden" value="{{ $project->user_id }}" name="projectUserId">


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="surname" class="q-label">Ad Soyad : </label>
                                <input type="text" class="modal-input" placeholder="Ad Soyad" id="name"
                                    name="name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="surname" class="q-label">Telefon Numarası : </label>
                                <input type="number" class="modal-input" placeholder="Telefon Numarası"
                                    id="phone" name="phone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="surname" class="q-label">E-Posta : </label>
                                <input type="email" class="modal-input" placeholder="E-Posta" id="email"
                                    name="email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="surname" class="q-label">Meslek : </label>
                                <input type="text" class="modal-input" placeholder="Meslek" id="title"
                                    name="title">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="q-label">İl</label>
                                <select
                                    class="form-control citySelect {{ $errors->has('city_id') ? 'error-border' : '' }}"
                                    name="city_id">
                                    <option value="">Seçiniz</option>
                                    @foreach ($towns as $item)
                                        <option for="{{ $item['sehir_title'] }}" value="{{ $item['sehir_key'] }}"
                                            {{ old('city_id') == $item['sehir_key'] ? 'selected' : '' }}>
                                            {{ $item['sehir_title'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="q-label">İlçe</label>
                                <select
                                    class="form-control countySelect {{ $errors->has('county_id') ? 'error-border' : '' }}"
                                    name="county_id">
                                    <option value="">Seçiniz</option>
                                </select>
                            </div>
                        </div>
                    </div>




                    <div class="form-group">
                        <label for="comment" class="q-label">Açıklama:</label>
                        <textarea class="modal-input" id="offer_description" rows="45" style="height: 130px !important;"
                            name="offer_description"></textarea>
                    </div>

                    <div class="modal-footer" style="justify-content: end !important">
                        <button type="submit" class="btn btn-success" style="width:150px">Gönder</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"
                            style="width:150px">Kapat</button>
                    </div>
                </form>



            </div>

        </div>
    </div>
</div>

@if ($sold_check && $sold->status == '1')

    <div class="modal fade" id="neighborViewModal{{ $sold->id }}" tabindex="-1"
        aria-labelledby="neighborViewModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="invoice">
                        <div class="invoice-header mb-3">
                            <span>Ödeme Tarihi: {{ date('d.m.Y') }}</span> <br>
                            <span style="color:#e54242;font-weight:700">Tutar: 250 TL</span>

                        </div>

                        <div class="invoice-body">
                            <div class="invoice-total mt-3">
                                <div class="mt-3">
                                    <span><strong style="color:black">Komşumu Gör Özelliği:</strong> Bu özellik,
                                        komşunuzun
                                        iletişim bilgilerine ulaşabilmeniz için aktif edilmelidir.</span><br>
                                    <span>Komşunuza ait iletişim bilgilerini görmek için aşağıdaki adımları takip
                                        edin:</span>
                                    <ul>
                                        <li><i class="fa fa-circle circleIcon mr-1" style="color: #EA2B2E ;"
                                                aria-hidden="true"></i>Ödeme işlemini tamamlayın ve belirtilen tutarı
                                            aşağıdaki banka hesaplarından birine havale veya EFT yapın.</li>
                                        <li><i class="fa fa-circle circleIcon mr-1" style="color: #EA2B2E ;"
                                                aria-hidden="true"></i>Ödemeniz onaylandıktan sonra, "Komşumu Gör"
                                            düğmesi
                                            aktif olacak ve komşunuzun iletişim bilgilerine ulaşabileceksiniz.</li>
                                    </ul>
                                </div>
                                <div class="container row mb-3 mt-3">
                                    @foreach ($bankAccounts as $bankAccount)
                                        <div class="col-md-4 bank-account" data-id="{{ $bankAccount->id }}"
                                            data-sold-id="{{ $sold->id }}" data-iban="{{ $bankAccount->iban }}"
                                            data-title="{{ $bankAccount->receipent_full_name }}">
                                            <img src="{{ URL::to('/') }}/{{ $bankAccount->image }}" alt=""
                                                style="width: 100%;height:100px;object-fit:contain;cursor:pointer">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="ibanInfo" style="font-size: 12px !important"></div>

                            </div>
                        </div>

                    </div>

                    <div class="d-flex">
                        <button type="button"
                            class="btn btn-secondary btn-lg btn-block mb-3 mt-3 completePaymentButtonOrder"
                            id="completePaymentButton{{ $sold->id }}" data-order="{{ $sold->id }}"
                            style="width:150px;float:right">
                            250 TL Öde
                        </button>
                        <button type="button" class="btn btn-secondary btn-lg btn-block mt-3"
                            style="width:150px;margin-left:10px" data-bs-dismiss="modal">İptal</button>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endif

@endif
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


<script>
    $('.bank-account').on('click', function() {
        // Tüm banka görsellerini seçim olmadı olarak ayarla
        $('.bank-account').removeClass('selected');
        // Seçilen banka görselini işaretle
        $(this).addClass('selected');

        // İlgili IBAN bilgisini al
        var selectedBankIban = $(this).data('iban');
        var selectedBankIbanID = $(this).data('id');
        var selectedBankTitle = $(this).data('title');

        var ibanInfo = "<span style='color:black'><strong>Banka Alıcı Adı:</strong> " +
            selectedBankTitle + "<br><strong>IBAN:</strong> " + selectedBankIban + "</span>";
        $('.ibanInfo').html(ibanInfo);
    });


    $('.completePaymentButtonOrder').on('click', function() {
        // Ödeme sırasındaki satış ID'sini al
        var order = $(this).data('order');

        // Seçilen banka hesabını kontrol et
        if ($('.bank-account.selected').length === 0) {
            toastr.error('Lütfen banka seçimi yapınız.');
        } else {
            // Ödeme işlemine başla
            $("#loadingOverlay").css("visibility", "visible"); // Loading overlay göster

            // Ödeme bilgilerini ve diğer verileri hazırla
            var requestData = {
                _token: "{{ csrf_token() }}",
                user_id: "{{ Auth::check() ? Auth::user()->id : null }}",
                order_id: order,
                status: 0,
                key: generateRandomCode(), // Rastgele bir kod oluştur
                amount: "100" // Ödeme miktarı
            };

            // AJAX isteği gönder
            $.ajax({
                url: "{{ route('neighbor.store') }}", // Verileri göndereceğiniz URL
                type: "POST",
                data: requestData,
                success: function(response) {
                    // İşlem başarılıysa
                    $("#loadingOverlay").css("visibility", "hidden"); // Loading overlay gizle
                    $('#neighborViewModal' + order).modal('hide'); // Modalı gizle

                    toastr.success(
                        'Ödeme onayından sonra komşu bilgileri tarafınıza iletilecektir.');
                    // Sayfayı yenile
                    location.reload();
                }
            });
        }
    });

    function generateRandomCode() {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        const codeLength = 8; // Kod uzunluğu

        let randomCode = '';
        for (let i = 0; i < codeLength; i++) {
            const randomIndex = Math.floor(Math.random() * characters.length);
            randomCode += characters.charAt(randomIndex);
        }

        return randomCode;
    }
</script>
