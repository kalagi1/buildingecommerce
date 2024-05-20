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
    'blockItemCount',
    'blockStart',
])

@php
    if ($key == 0) {
        $keyIndex = $i + 1;
    } else {
        $keyIndex = $i + 1 + $allCounts;
    }

    if (!function_exists('convertMonthToTurkishCharacter')) {
        function convertMonthToTurkishCharacter($date)
        {
            $aylar = [
                'January' => 'Ocak',
                'February' => 'Şubat',
                'March' => 'Mart',
                'April' => 'Nisan',
                'May' => 'Mayıs',
                'June' => 'Haziran',
                'July' => 'Temmuz',
                'August' => 'Ağustos',
                'September' => 'Eylül',
                'October' => 'Ekim',
                'November' => 'Kasım',
                'December' => 'Aralık',
                'Monday' => 'Pazartesi',
                'Tuesday' => 'Salı',
                'Wednesday' => 'Çarşamba',
                'Thursday' => 'Perşembe',
                'Friday' => 'Cuma',
                'Saturday' => 'Cumartesi',
                'Sunday' => 'Pazar',
                'Jan' => 'Oca',
                'Feb' => 'Şub',
                'Mar' => 'Mar',
                'Apr' => 'Nis',
                'May' => 'May',
                'Jun' => 'Haz',
                'Jul' => 'Tem',
                'Aug' => 'Ağu',
                'Sep' => 'Eyl',
                'Oct' => 'Eki',
                'Nov' => 'Kas',
                'Dec' => 'Ara',
            ];
            return strtr($date, $aylar);
        }
    }
@endphp
@php
    $off_sale_check = $projectHousingsList[$keyIndex]['off_sale[]'] == '[]';
    $share_sale = $projectHousingsList[$keyIndex]['share_sale[]'] ?? null;
    $number_of_share = $projectHousingsList[$keyIndex]['number_of_shares[]'] ?? null;
    $sold_check = $sold && in_array($sold->status, ['1', '0']);
    $discounted_price = $projectHousingsList[$keyIndex]['price[]'] - $projectDiscountAmount;
    $share_sale_empty = !isset($share_sale) || $share_sale == '[]';
    $projectOrder = 1;
    if (isset($blockStart) && $blockStart) {
        $projectOrder = $i - $blockStart + 1;
    } else {
        $projectOrder = $i + 1;
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
                                    No<br>

                                    @if (isset($blockStart) && $blockStart)
                                        {{ $i - $blockStart + 1 }}
                                    @else
                                        {{ $i + 1 }}
                                    @endif

                                </p>
                            </div>
                            <div class="project-single mb-0 bb-0 aos-init aos-animate" data-aos="fade-up">
                                <div class="button-effect-div">



                                    @if (
                                        ($sold && $sold->status == '2' && $share_sale == '[]') ||
                                        !$sold && $projectHousingsList[$keyIndex]['off_sale[]'] == '[]' ||
                                            ($sold && $sold->status == '2' && empty($share_sale)) ||
                                            (isset($sumCartOrderQt[$keyIndex]) &&
                                                $sold &&
                                                $sold->status != '2' &&
                                                $sumCartOrderQt[$keyIndex]['qt_total'] != $number_of_share))
                                        <span class="btn addCollection mobileAddCollection" data-type='project'
                                            data-project='{{ $project->id }}' data-id='{{ $keyIndex }}'>
                                            <i class="fa fa-bookmark-o"></i>
                                        </span>
                                    @endif

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
                        @if (
                            ($sold && $sold->status != '2' && $share_sale == '[]') ||
                                ($sold && $sold->status != '2' && empty($share_sale)) ||
                                $projectHousingsList[$keyIndex]['off_sale[]'] != '[]' ||
                                (isset($sumCartOrderQt[$keyIndex]) &&
                                    $sold &&
                                    $sold->status != '2' &&
                                    $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share)) style="background: #EEE !important;height:100% !important" @endif>
                        <div class="col-md-9">


                            <div class="homes-list-div"
                                @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0) style="flex-direction: column !important;" @endif>
                                <ul class="homes-list clearfix pb-3 d-flex projectCardList"
                                    @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0) style="height: 90px !important" @endif>
                                    {{-- <li class="d-flex align-items-center itemCircleFont">
                                        <i class="fa fa-circle circleIcon mr-1" style="color: black;"
                                            aria-hidden="true"></i>
                                        <span>{{ $project->housingType->title }}</span>
                                    </li> --}}
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
                                                    @if ($column_additional && is_numeric($projectHousingsList[$keyIndex][$column_name . '[]']))
                                                        {{ $column_additional }}
                                                    @endif
                                                </span>
                                            </li>
                                        @endif
                                    @endforeach

                                    <li class="d-flex align-items-center itemCircleFont">
                                        <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                        <span>
                                            {{ date('j', strtotime($project->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($project->created_at))) . ' ' . date('Y', strtotime($project->created_at)) }}
                                        </span>
                                    </li>

                                    <li class="the-icons mobile-hidden">
                                        <span style="width:100%;text-align:center">

                                            @if ($off_sale_check && !$sold_check && $share_sale_empty)


                                                @if ($projectDiscountAmount)
                                                    <svg viewBox="0 0 24 24" width="18" height="18"
                                                        stroke="#EA2B2E" stroke-width="2" fill="#EA2B2E"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="css-i6dzq1">
                                                        <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                        <polyline points="17 18 23 18 23 12"></polyline>
                                                    </svg>
                                                    <del
                                                        style="color: #ea2a28!important;font-weight: 700;font-size: 11px;">

                                                        {{ number_format($projectHousingsList[$keyIndex]['price[]'], 0, ',', '.') }}
                                                        ₺
                                                    </del>
                                                    <h6
                                                        style="color: #27bb53 !important; position: relative; top: 4px; font-weight: 700">
                                                        {{ number_format($discounted_price, 0, ',', '.') }}
                                                        ₺
                                                    </h6>
                                                @else
                                                    <h6
                                                        style="color:#274abb; position: relative; top: 4px; font-weight: 700">
                                                        {{ number_format($discounted_price, 0, ',', '.') }}
                                                        ₺
                                                    </h6>
                                                @endif
                                          
                                                @if ($projectDiscountAmount)
                                                    <h6 style="color: #27bb53 !important;">(Kampanyalı)</h6>
                                                @endif
                                            @elseif(
                                                (isset($share_sale) &&
                                                    $share_sale != '[]' &&
                                                    isset($sumCartOrderQt[$keyIndex]) &&
                                                    $sumCartOrderQt[$keyIndex]['qt_total'] != $number_of_share) ||
                                                    (isset($share_sale) && $share_sale != '[]' && !isset($sumCartOrderQt[$keyIndex])))
                                                @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                    <span class="text-center w-100">
                                                        1 / {{ $number_of_share }} Fiyatı
                                                    </span>
                                                @endif
                                                <h6
                                                    style="color: #274abb !important; position: relative; top: 4px; font-weight: 700">
                                                    @if (
                                                        (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0) ||
                                                            (isset($share_sale) && empty($share_sale) && $number_of_share != 0))
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

                                @php
                                    // Example: Set a default value for $maxQtTotal
                                    $maxQtTotal = 100; // Set the appropriate default value

                                    // OR check if $maxQtTotal is defined
                                    if (!isset($maxQtTotal)) {
                                        $maxQtTotal = 100; // Set the appropriate default value
                                    }
                                @endphp

                                @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                    <div class="bar-chart">
                                        <div class="progress"
                                            style="border-radius: 0 !important; display: grid;
                                                                    grid-template-columns: repeat({{ $number_of_share }}, 1fr);">
                                            @for ($i = 0; $i < $number_of_share; $i++)
                                                <div class="progress-bar"
                                                    style="@if ($i != 0) border-left: 1px solid #cbcbcb; @endif
                                                                                @if (isset($sumCartOrderQt[$keyIndex]) &&
                                                                                        isset($sumCartOrderQt[$keyIndex]['qt_total']) &&
                                                                                        isset($maxQtTotal) &&
                                                                                        $maxQtTotal > 0) width: {{ $i < $sumCartOrderQt[$keyIndex]['qt_total'] ? '100%' : '0%' }}; @else width: 0%; @endif">
                                                    @if (isset($sumCartOrderQt[$keyIndex]) && $i < $sumCartOrderQt[$keyIndex]['qt_total'])
                                                        <i class="fa fa-check" style="margin-top:-1px"></i>
                                                    @endif
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                @endif




                            </div>

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
                                            @if (Auth::check()) data-bs-toggle="modal" data-bs-target="#neighborViewModal{{ $sold->id }}" data-order="{{ $sold->id }}" @else onclick="window.location.href='{{ route('client.login') }}'" @endif>

                                            <span><svg viewBox="0 0 24 24" width="18" height="18"
                                                    stroke="currentColor" stroke-width="2" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg> Komşumu Gör</span>
                                        </span>
                                    @elseif($neighborView && $neighborView->status == '0')
                                        <span class="first-btn see-my-neighbor payment">
                                            <span> <svg viewBox="0 0 24 24" width="18" height="18"
                                                    stroke="currentColor" stroke-width="2" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <line x1="12" y1="8" x2="12" y2="12">
                                                    </line>
                                                    <line x1="12" y1="16" x2="12.01" y2="16">
                                                    </line>
                                                </svg>
                                                Ödeme Onayı </span>
                                        </span>
                                    @elseif($neighborView && $neighborView->status == '1')
                                        <span class="first-btn see-my-neighbor success" data-bs-toggle="modal"
                                            data-bs-target="#phoneModal{{ $sold->id }}">

                                            <span>

                                                <svg viewBox="0 0 24 24" width="18" height="18"
                                                    stroke="currentColor" stroke-width="2" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="css-i6dzq1">
                                                    <polyline points="19 1 23 5 19 9"></polyline>
                                                    <line x1="15" y1="5" x2="23"
                                                        y2="5">
                                                    </line>
                                                    <path
                                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                                    </path>
                                                </svg>
                                                İletişime Geç
                                            </span>

                                        </span>
                                    @elseif($neighborView && $neighborView->status == '2')
                                        <span class="first-btn see-my-neighbor"
                                            @if (Auth::check()) data-bs-toggle="modal"
                                                                                                data-bs-target="#neighborViewModal{{ $sold->id }}" data-order="{{ $sold->id }}" @else onclick="window.location.href='{{ route('client.login') }}'" @endif>
                                            <span><svg viewBox="0 0 24 24" width="18" height="18"
                                                    stroke="currentColor" stroke-width="2" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="css-i6dzq1">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg> Komşumu Gör</span>
                                        </span>
                                    @elseif($isUserSame == true && isset($share_sale) && $share_sale == '[]')
                                        <span class="first-btn see-my-neighbor success">
                                            <span>
                                                İLANI SİZ SATIN ALDINIZ
                                            </span>

                                        </span>
                                    @else
                                        <button class="first-btn payment-plan-button"
                                            project-id="{{ $project->id }}"
                                            data-sold="{{ ($sold && $sold->status != 2 && $share_sale_empty) || (!$share_sale_empty && isset($sumCartOrderQt[$keyIndex]) && $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share) || (!$sold && isset($projectHousingsList[$keyIndex]['off_sale']) && $projectHousingsList[$keyIndex]['off_sale'] != '[]') ? 1 : 0 }}"
                                            order="{{ $keyIndex }}" data-block="{{ $blockName }}"
                                            data-payment-order="{{ $projectOrder }}">
                                            Ödeme Detayı
                                        </button>
                                    @endif
                                @else
                                    @if ($projectHousingsList[$keyIndex]['off_sale[]'] != '[]')
                                        @if (Auth::user())
                                            <button class="first-btn payment-plan-button" data-toggle="modal"
                                                data-target="#approveProjectModal{{ $keyIndex }}">
                                                Başvuru Yap
                                            </button>
                                        @else
                                            <a href="{{ route('client.login') }}"
                                                class="first-btn payment-plan-button">
                                                Başvuru Yap
                                            </a>
                                        @endif
                                    @else
                                        <button class="first-btn payment-plan-button"
                                            project-id="{{ $project->id }}"
                                            data-sold="{{ ($sold && $sold->status != 2 && $share_sale_empty) || (!$share_sale_empty && isset($sumCartOrderQt[$keyIndex]) && $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share) || (!$sold && isset($projectHousingsList[$keyIndex]['off_sale']) && $projectHousingsList[$keyIndex]['off_sale'] != '[]') ? 1 : 0 }}"
                                            order="{{ $keyIndex }}" data-block="{{ $blockName }}"
                                            data-payment-order="{{ $projectOrder }}">
                                            Ödeme Detayı
                                        </button>


                                    @endif



                                @endif

                                @if ($projectHousingsList[$keyIndex]['off_sale[]'] != '[]' && !$sold)
                                    <button class="btn second-btn"
                                        style="background: #EA2B2E !important; width: 100%; color: White; height: auto !important">
                                        <span class="text">Satışa Kapatıldı</span>
                                    </button>
                                @elseif ($sold && $sold->status == '2' && $projectHousingsList[$keyIndex]['off_sale[]'] != '[]')
                                    <button class="btn second-btn"
                                        style="background: #EA2B2E !important; width: 100%; color: White; height: auto !important">
                                        <span class="text">Satışa Kapatıldı</span>
                                    </button>
                                @else
                                    @if (
                                        ($sold && $sold->status != '2' && $share_sale == '[]') ||
                                            ($sold && $sold->status != '2' && empty($share_sale)) ||
                                            (isset($sumCartOrderQt[$keyIndex]) &&
                                                $sold &&
                                                $sold->status != '2' &&
                                                $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share))
                                        <button class="btn second-btn"
                                            @if (
                                                ($sold->status == '0' && (empty($share_sale) || $share_sale == '[]')) ||
                                                    (isset($share_sale) &&
                                                        $share_sale != '[]' &&
                                                        isset($sumCartOrderQt[$keyIndex]) &&
                                                        $sumCartOrderQt[$keyIndex]['qt_total'] != $number_of_share)) style="background: orange !important; color: White; height: auto !important"
                                    @elseif ($sold->status == '1')
                                        style="background: #EA2B2E !important; color: White; height: auto !important"
                                    @else  style="background: #EA2B2E !important; color: White; height: auto !important" @endif>
                                            @if (($sold->status == '0' && $share_sale == '[]') || ($sold->status == '0' && empty($share_sale)))
                                                <span class="text">Rezerve Edildi</span>
                                            @elseif (
                                                ($sold->status == '1' && $share_sale == '[]') ||
                                                    ($sold->status == '1' && empty($share_sale)) ||
                                                    (isset($sumCartOrderQt[$keyIndex]) && $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share))
                                                <span class="text">Satıldı</span>
                                            @endif
                                        </button>
                                    @else
                                        <button class="CartBtn second-btn mobileCBtn" data-type='project'
                                            data-project='{{ $project->id }}' style="height: auto !important"
                                            data-id='{{ $keyIndex }}' data-share="{{ $share_sale }}"
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
    <div class="modal fade" id="approveProjectModal{{ $keyIndex }}" tabindex="-1" role="dialog"
        aria-labelledby="approveProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-body">
                    {{-- <h3 class="modal-title" style="margin:10px;font-size:12px !important;text-align:center"
                        id="approveProjectModalLabel"> {{ $project->project_title }} Projesi {{ $keyIndex }} No'lu İlan
                        için
                        Başvuru Yap</h3>
                    <hr> --}}
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
                                    <span id="error_message" class="error-message"></span>
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
                                        class="form-control citySelect2 {{ $errors->has('city_id') ? 'error-border' : '' }}"
                                        name="city_id">
                                        <option value="">Seçiniz</option>
                                        @foreach ($towns as $item)
                                            <option for="{{ $item['sehir_title'] }}"
                                                value="{{ $item['sehir_key'] }}"
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
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
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
                                        <span><strong style="color:black">Komşumu Gör Özelliği:</strong> İlgilendiğiniz projeden konut alanları arayıp proje hakkında detaylı referans bilgisi almanıza imkan sağlar.</span><br>
                                        <span>Komşunuza ait iletişim bilgilerini görmek için aşağıdaki adımları takip
                                            edin:</span>
                                        <ul>
                                            <li><i class="fa fa-circle circleIcon mr-1" style="color: #EA2B2E ;"
                                                    aria-hidden="true"></i>Ödeme işlemini tamamlayın ve belirtilen
                                                tutarı ödediğiniz taktirde,
                                            </li>
                                            <li><i class="fa fa-circle circleIcon mr-1" style="color: #EA2B2E ;"
                                                    aria-hidden="true"></i>Ödemeniz onaylandıktan sonra, "Komşumu Gör"
                                                düğmesi
                                                aktif olacak ve komşunuzun iletişim bilgilerine ulaşabileceksiniz.</li>
                                        </ul>
                                    </div>


                                </div>
                            </div>

                        </div>

                        <div class="d-flex align-items-center">
                            <form action="{{ route('neighborView.index') }}" method="POST">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $sold->id }}">
                                <button type="submit" class="btn btn-success btn-lg btn-block mt-3"
                                    style="width:150px;float:right">
                                    250 TL Öde
                                </button>
                            </form>
                            <button type="button" class=" btn btn-danger"
                                style="width:150px;margin-left:10px; margin-top:10px; " data-bs-dismiss="modal">İptal</button>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="phoneModal{{ $sold->id }}" tabindex="-1" aria-labelledby="phoneModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <strong class="text-center text-black d-block" style="color: black">
                            @if (isset($projectHousingsList[$keyIndex]['advertise_title[]']))
                                {{ $projectHousingsList[$keyIndex]['advertise_title[]'] }}
                                {{ $blockName }}
                                {{ isset($blockStart) && $blockStart ? $i - $blockStart + 1 : $i + 1 }}
                                {{ "No'lu" }}
                                {{ $project->step1_slug }}
                            @else
                                {{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}
                                Projesinde {{ $blockName }}
                                {{ isset($blockStart) && $blockStart ? $i - $blockStart + 1 : $i + 1 }}
                                {{ "No'lu" }}
                                {{ $project->step1_slug }}
                            @endif
                        </strong>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item" style="width:100%">İsim: {{ $sold->name }}
                            </li>
                            <li class="list-group-item" style="width:100%">
                                Telefon:
                                {{ !empty($sold->phone) ? $sold->phone : (isset($sold->mobile_phone) && $sold->mobile_phone && !is_null($sold->mobile_phone) ? $sold->mobile_phone : 'Belirtilmedi') }}
                            </li>


                        </ul>
                    </div>
                    <div class="modal-footer" style="justify-content: end !important">

                        <a href="tel:{{ isset($sold->phone) ? $sold->phone : null }}"><button class="btn btn-success"
                                style="width:100px">Ara</button></a>

                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            style="width:100px">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


        <script>
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

    @endif

@endif
