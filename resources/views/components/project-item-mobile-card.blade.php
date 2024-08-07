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
    'blockName',
    'cities',
    'towns',
    'statusSlug',
    'blockName',
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
    // Retrieve the necessary data
    $canAddToProject = checkIfUserCanAddToProjectHousings($project->id, $keyIndex);
    $user = Auth::user();
    $isUserType2EmlakOfisi = $user && $user->type == '2' && $user->corporate_type == 'Emlak Ofisi';
    $isUserType1 = $user && $user->type == '1';
@endphp
@php
    // Initialize variables
    $off_sale_1 = $off_sale_2 = $off_sale_3 = $off_sale_4 = false;

    // Check if 'off_sale[]' key exists
    if (isset($projectHousingsList[$keyIndex]['off_sale[]'])) {
        // Convert the string to an array if needed
        $off_sale_array = json_decode($projectHousingsList[$keyIndex]['off_sale[]'], true);

        // Check if the conversion was successful and if each value is in the array
        if (is_array($off_sale_array)) {
            $off_sale_1 = in_array('1', $off_sale_array);
            $off_sale_2 = in_array('2', $off_sale_array);
            $off_sale_3 = in_array('3', $off_sale_array);
            $off_sale_4 = in_array('4', $off_sale_array);
        }
    }

    $share_sale = $projectHousingsList[$keyIndex]['share_sale[]'] ?? null;
    $number_of_share = $projectHousingsList[$keyIndex]['number_of_shares[]'] ?? null;
    $sold_check = $sold && in_array($sold->status, ['1', '0']);
    $discounted_price = $projectHousingsList[$keyIndex]['price[]'] - $projectDiscountAmount;
    $share_sale_empty = !isset($share_sale) || $share_sale == '[]';

@endphp

<div class="d-flex" style="flex-wrap: nowrap;box-shadow: 0 0 10px 1px rgba(71, 85, 95, 0.08);padding:10px
    ">
    <div class="align-items-center d-flex" style="padding-right:0; width: 110px;">
        <div class="project-inner project-head">
            <a
                href="{{ route('project.housings.detail', [
                    'projectSlug' =>
                        $project->slug .
                        '-' .
                        $statusSlug .
                        '-' .
                        $project->step2_slug .
                        '-' .
                        $project->housingtype->slug .
                        '-' .
                        strtolower($project->city->title) .
                        '-' .
                        strtolower($project->county->ilce_title),
                    'projectID' => $project->id + 1000000,
                    'housingOrder' => $keyIndex,
                ]) }}">
                <div class="homes">
                    <!-- homes img -->
                    <div class="homes-img h-100 d-flex align-items-center" style="width: 100px; height: 128px;">
                        <img src="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[$keyIndex]['image[]'] }}"
                            alt="{{ $project->housingType->title }}" class="img-responsive"
                            style="height: 95px !important;">
                    </div>

                    <span class="mobileNoStyle">
                        {{ $projectHousingsList[$keyIndex] && isset($projectHousingsList[$keyIndex]['share_sale[]']) && $projectHousingsList[$keyIndex]['share_sale[]'] == '["Var"]' ? 'Etap' : 'No' }}
                        @if (isset($blockStart) && $blockStart)
                            {{ $i - $blockStart + 1 }}
                        @else
                            {{ $i + 1 }}
                        @endif
                    </span>
                </div>
            </a>
        </div>
    </div>
    <div class="w-100" style="padding-left:0;">
        <div class="bg-white px-3 h-100 d-flex flex-column justify-content-center">
            <a style="text-decoration: none; height: 100%"
                href="{{ route('project.housings.detail', [
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
                    'housingOrder' => $keyIndex,
                ]) }}">
                <div class="d-flex justify-content-between" style="gap:8px;">
                    <h3>
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
                    </h3>
                    @if (
                        ($off_sale_2 && Auth::check() && $isUserType2EmlakOfisi && $canAddToProject) ||
                            (!$off_sale_2 && !$off_sale_3 && !$off_sale_4 && !$off_sale_1 && Auth::check() && $canAddToProject) ||
                            ($off_sale_3 && (Auth::check() && ($isUserType2EmlakOfisi || $isUserType1)) && $canAddToProject))

                        @if (!$sold_check)
                            <span class="btn addCollection mobileAddCollection " data-type='project'
                                data-project='{{ $project->id }}' data-id='{{ $keyIndex }}'>
                                <i class="fa fa-bookmark-o"></i>
                            </span>

                            <span class="btn toggle-project-favorite bg-white"
                                data-project-housing-id="{{ $keyIndex }}" style="color: white;"
                                data-project-id="{{ $project->id }}">
                                <i class="fa fa-heart-o"></i>
                            </span>
                        @endif
                    @endif

                </div>
                <span
                    style="    font-size: 9px !important;
                                width: 50% !important;
                                text-align: right;
                                margin-right: 10px;">{!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}</span>
            </a>
            <div class="d-flex align-items-end projectItemFlex">
                <div style="width: 50%;
                                align-items: center;">

                    @if ($off_sale_1 && !$sold)
                        <button class="btn second-btn mobileCBtn"
                            style="background: #EC2F2E !important; width: 100%; color: White;">
                            <span class="text">Satışa Kapalı</span>
                        </button>
                    @elseif ($sold && $sold->status == '2' && $off_sale_1)
                        <button class="btn second-btn mobileCBtn"
                            style="background: #EC2F2E !important; width: 100%; color: White;">
                            <span class="text">Satışa Kapalı</span>
                        </button>
                    @else
                        @if (
                            ($sold && $sold->status != '2' && $share_sale == '[]') ||
                                ($sold && $sold->status != '2' && empty($share_sale)) ||
                                (isset($sumCartOrderQt[$keyIndex]) &&
                                    $sold &&
                                    $sold->status != '2' &&
                                    $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share))
                            <button class="btn second-btn mobileCBtn"
                                @if (
                                    ($sold->status == '0' && (empty($share_sale) || $share_sale == '[]')) ||
                                        (isset($share_sale) &&
                                            $share_sale != '[]' &&
                                            isset($sumCartOrderQt[$keyIndex]) &&
                                            $sumCartOrderQt[$keyIndex]['qt_total'] != $number_of_share)) style="background: orange !important; color: White;"
                @elseif ($sold->status == '1')
                    style="background: #EC2F2E !important; color: White; "
                @else
                    style="background: #EC2F2E !important; color: White; " @endif>
                                @if ($sold->status == '0' && $share_sale_empty)
                                    <span class="text">Rezerve Edildi</span>
                                @elseif (
                                    ($sold->status == '1' && $share_sale_empty) ||
                                        (isset($sumCartOrderQt[$keyIndex]) && $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share))
                                    <span class="text">Satıldı</span>
                                @endif
                            </button>
                        @else
                            @if (
                                ($off_sale_2 && Auth::check() && $isUserType2EmlakOfisi && $canAddToProject) ||
                                    ($off_sale_3 && (Auth::check() && ($isUserType2EmlakOfisi || $isUserType1)) && $canAddToProject))
                                <button class="CartBtn second-btn mobileCBtn" data-type='project'
                                    data-project='{{ $project->id }}' data-id='{{ $keyIndex }}'
                                    data-share="{{ $share_sale }}" data-number-share="{{ $number_of_share }}">
                                    <span class="IconContainer">
                                        <img src="{{ asset('sc.png') }}" alt="">
                                    </span>
                                    <span class="text">Sepete Ekle</span>
                                </button>
                            @elseif (!$canAddToProject)
                                <a href="{{ route('institutional.projects.edit.housing', ['project_id' => $project->id, 'room_order' => $keyIndex]) }}"
                                    class="second-btn mobileCBtn"
                                    style="    background-color: #274abb !important;
                                        border: 1px solid #274abb;
                                        color: white;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;">
                                    İlanı Düzenle </a>
                            @else
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
                                    class="second-btn CartBtn mobileCBtn">
                                    <span class="text">İlanı Gör</span>
                                </a>
                            @endif

                        @endif
                    @endif




                </div>


                @if ($sold_check && $sold->status == '1')
                    @php
                        $neighborView = null;

                        if (Auth::check()) {
                            $neighborView = App\Models\NeighborView::where('user_id', Auth::user()->id)
                                ->where('project_id', $project->id)
                                ->where('housing', $keyIndex)
                                ->first();
                        }

                        $isUserSameText = $isUserSame ? 'evet' : 'hayır';
                    @endphp

                    @if (!$neighborView && $sold->status == '1' && isset($sold->is_show_user) && $sold->is_show_user == 'on' && !$isUserSame)
                        @if (Auth::check())
                            <button class="btn first-btn mobileCBtn payment-plan-mobile-btn see-my-neighbor"
                                style="width:50% !important;color:white !important;background-color:green !important;"
                                data-bs-toggle="modal" data-bs-target="#neighborViewModalMobile{{ $sold->id }}"
                                data-order="{{ $sold->id }}">
                                <span
                                    style="text-align: center; display: flex; align-items: center; justify-content: center;">
                                    <svg viewBox="0 0 24 24" width="10" height="10" stroke="currentColor"
                                        stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                        class="css-i6dzq1" style="margin-right: 2px">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    Komşumu Gör
                                </span>
                            </button>
                        @else
                            <button class="btn first-btn mobileCBtn payment-plan-mobile-btn see-my-neighbor"
                                style="width:50% !important;color:white !important;background-color:green !important;"
                                onclick="window.location.href='{{ route('client.login') }}'">
                                <span
                                    style="text-align: center; display: flex; align-items: center; justify-content: center;">
                                    <svg viewBox="0 0 24 24" width="10" height="10" stroke="currentColor"
                                        stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                        class="css-i6dzq1" style="margin-right: 2px">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    Komşumu Gör
                                </span>
                            </button>
                        @endif
                    @elseif($neighborView && $neighborView->status == '0')
                        <button class="btn payment-plan-button payment-plan-mobile-btn mobileCBtn"
                            style="width:50% !important;background-color:orange !important;border:1px solid orange;color:White">
                            <span> <svg viewBox="0 0 24 24" width="10" height="10" stroke="currentColor"
                                    stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    class="css-i6dzq1">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12">
                                    </line>
                                    <line x1="12" y1="16" x2="12.01" y2="16">
                                    </line>
                                </svg>
                                Ödeme Onayı </span>
                        </button>
                    @elseif($neighborView && $neighborView->status == '1')
                        <button class="btn payment-plan-mobile-btn mobileCBtn"
                            style="width:50% !important;background-color:green !important;color:white;border:1px solid green"
                            data-bs-toggle="modal" data-bs-target="#contactModal{{ $sold->id }}">
                            <span>
                                <svg viewBox="0 0 24 24" width="12" height="12" stroke="currentColor"
                                    stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    class="css-i6dzq1">
                                    <polyline points="19 1 23 5 19 9"></polyline>
                                    <line x1="15" y1="5" x2="23" y2="5"></line>
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                    </path>
                                </svg>
                                İletişime Geç
                            </span>
                        </button>
                    @elseif($neighborView && $neighborView->status == '2')
                        <span class="first-btn see-my-neighbor"
                            @if (Auth::check()) data-bs-toggle="modal"
                                                                                data-bs-target="#neighborViewModalMobile{{ $sold->id }}" data-order="{{ $sold->id }}" @else onclick="window.location.href='{{ route('client.login') }}'" @endif>
                            <span><svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor"
                                    stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    class="css-i6dzq1">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg> Komşumu Gör</span>
                        </span>
                    @elseif($isUserSame == true && isset($share_sale) && $share_sale == '[]')
                        <button class="btn payment-plan-mobile-btn mobileCBtn"
                            style="width:50% !important;background-color: green !important;
                        color: white;
                        border: 1px solid green;">
                            <span>
                                Size Ait Ürün
                            </span>
                        </button>
                    @else
                        <button class="first-btn payment-plan-button payment-plan-mobile-btn mobileCBtn"
                            style="width:50% !important;background-color:black !important;border:1px solid black;color:white"
                            project-id="{{ $project->id }}"
                            data-sold="{{ ($sold && $sold->status != 2 && $share_sale_empty) || (!$share_sale_empty && isset($sumCartOrderQt[$keyIndex]) && $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share) || (!$sold && isset($projectHousingsList[$keyIndex]['off_sale']) && $projectHousingsList[$keyIndex]['off_sale'] != '[]') ? 1 : 0 }}"
                            order="{{ $keyIndex }}" data-block="{{ $blockName }}"
                            data-payment-order="{{ isset($blockStart) && $blockStart ? $i - $blockStart + 1 : $i + 1 }}">
                            ÖDEME DETAYI
                        </button>
                    @endif
                @else
                    @if ($off_sale_1)
                        @if (Auth::user())
                            <button class="first-btn payment-plan-button mobileCBtn" data-bs-toggle="modal"
                                style="width:50% !important;background-color:black !important;border:1px solid black;color:white"
                                data-bs-target="#approveProjectModalmobile{{ $keyIndex }}">
                                BAŞVUR
                            </button>
                        @else
                            <a href="{{ route('client.login') }}" class="first-btn payment-plan-button mobileCBtn"
                                style="width:50% !important;background-color:black !important;border:1px solid black;color:white">
                                BAŞVUR
                            </a>
                        @endif
                        {{-- @if ((isset($share_sale) && $share_sale != '[]' && isset($sumCartOrderQt[$keyIndex]) && $sumCartOrderQt[$keyIndex]['qt_total'] != $number_of_share) || (isset($share_sale) && $share_sale != '[]' && !isset($sumCartOrderQt[$keyIndex])))
                @else
                    @if (Auth::user())
                        <button class="first-btn payment-plan-button mobileCBtn" data-bs-toggle="modal"
                            data-bs-target="#approveProjectModalmobile{{ $keyIndex }}">
                            BAŞVUR
                        </button>
                    @else
                        <a href="{{ route('client.login') }}"
                            class="first-btn payment-plan-button mobileCBtn">
                            BAŞVUR
                        </a>
                    @endif

                @endif --}}
                    @endif

                    @if ($off_sale_2)
                        @if (Auth::check() && Auth::user()->type == '2' && Auth::user()->corporate_type == 'Emlak Ofisi')
                            <button class="first-btn payment-plan-button mobileCBtn" project-id="{{ $project->id }}"
                                style="width:50% !important;background-color:black !important;border:1px solid black;color:white"
                                data-sold="{{ ($sold && $sold->status != 2 && $share_sale_empty) || (!$share_sale_empty && isset($sumCartOrderQt[$keyIndex]) && $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share) || (!$sold && isset($projectHousingsList[$keyIndex]['off_sale']) && $projectHousingsList[$keyIndex]['off_sale'] != '1') ? 1 : 0 }}"
                                order="{{ $keyIndex }}" data-block="{{ $blockName }}"
                                data-payment-order="{{ $keyIndex }}">
                                ÖDEME DETAYI
                            </button>
                        @elseif (!checkIfUserCanAddToProjectHousings($project->id, $keyIndex) && Auth::check())
                            <button class="first-btn payment-plan-button mobileCBtn" project-id="{{ $project->id }}"
                                style="width:50% !important;background-color:black !important;border:1px solid black;color:white"
                                data-sold="0" order="{{ $keyIndex }}" data-block="{{ $blockName }}"
                                data-payment-order="{{ $keyIndex }}">
                                ÖDEME DETAYI
                            </button>
                        @else
                            <button class="first-btn payment-plan-button mobileCBtn" project-id="{{ $project->id }}"
                                style="width:50% !important;background-color:black !important;border:1px solid black;color:white"
                                data-sold="1" order="{{ $keyIndex }}" data-block="{{ $blockName }}"
                                data-payment-order="{{ $keyIndex }}">
                                ÖDEME DETAYI
                            </button>
                        @endif

                    @endif

                    @if ($off_sale_3)
                        @if (Auth::check() &&
                                ((Auth::user()->type == '2' && Auth::user()->corporate_type == 'Emlak Ofisi') || Auth::user()->type == '1'))
                            <button class="first-btn payment-plan-button mobileCBtn" project-id="{{ $project->id }}"
                                style="width:50% !important;background-color:black !important;border:1px solid black;color:white"
                                data-sold="{{ ($sold && $sold->status != 2 && $share_sale_empty) || (!$share_sale_empty && isset($sumCartOrderQt[$keyIndex]) && $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share) || (!$sold && isset($projectHousingsList[$keyIndex]['off_sale']) && $projectHousingsList[$keyIndex]['off_sale'] != '1') ? 1 : 0 }}"
                                order="{{ $keyIndex }}" data-block="{{ $blockName }}"
                                data-payment-order="{{ $keyIndex }}">
                                ÖDEME DETAYI
                            </button>
                        @elseif (!checkIfUserCanAddToProjectHousings($project->id, $keyIndex) && Auth::check())
                            <button class="first-btn payment-plan-button mobileCBtn" project-id="{{ $project->id }}"
                                style="width:50% !important;background-color:black !important;border:1px solid black;color:white"
                                data-sold="0" order="{{ $keyIndex }}" data-block="{{ $blockName }}"
                                data-payment-order="{{ $keyIndex }}">
                                ÖDEME DETAYI
                            </button>
                        @else
                            <button class="first-btn payment-plan-button mobileCBtn" project-id="{{ $project->id }}"
                                style="width:50% !important;background-color:black !important;border:1px solid black;color:white"
                                data-sold="1" order="{{ $keyIndex }}" data-block="{{ $blockName }}"
                                data-payment-order="{{ $keyIndex }}">
                                ÖDEME DETAYI
                            </button>
                        @endif
                    @endif
                    @if ($off_sale_4)
                        @if (Auth::user())
                            <button class="first-btn payment-plan-button mobileCBtn" data-bs-toggle="modal"
                                style="width:50% !important;background-color:black !important;border:1px solid black;color:white"
                                data-bs-target="#approveProjectModalmobile{{ $keyIndex }}">
                                TEKLİF VER
                            </button>
                        @else
                            <a href="{{ route('client.login') }}" class="first-btn payment-plan-button mobileCBtn"
                                style="width:50% !important;background-color:black !important;border:1px solid black;color:white">
                                >
                                TEKLİF VER
                            </a>
                        @endif
                    @endif


                @endif

            </div>
        </div>
    </div>
</div>
<div class="w-100" style="height: 25px; background-color: #8080802e; margin-top: 15px">
    <div class="d-flex justify-content-between align-items-center mb-5" style="height: 100%">

        <ul class="d-flex align-items-center h-100 w-100"
            style="list-style: none;padding:0;font-weight:600;padding: 10px;justify-content:space-between !important;margin-bottom:0 !important">

            @if ($project->id == 431)
                <li class="d-flex align-items-center itemCircleFont">
                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                    <span>
                        1+1
                    </span>
                </li>
                <li class="d-flex align-items-center itemCircleFont">
                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                    <span>
                        Suit Oda
                    </span>
                </li>
                <li class="d-flex align-items-center itemCircleFont">
                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                    <span>
                        Konya/Ilgın
                    </span>
                </li>
            @elseif($project->id == 433)
                <li class="d-flex align-items-center itemCircleFont">
                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                    <span>
                        2+1
                    </span>
                </li>
                <li class="d-flex align-items-center itemCircleFont">
                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                    <span>
                        Suit Oda
                    </span>
                </li>
                <li class="d-flex align-items-center itemCircleFont">
                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                    <span>
                        Konya/Ilgın
                    </span>
                </li>
            @elseif($project->id == 434)
                <li class="d-flex align-items-center itemCircleFont">
                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                    <span>
                        3+1
                    </span>
                </li>
                <li class="d-flex align-items-center itemCircleFont">
                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                    <span>
                        Villa
                    </span>
                </li>
                <li class="d-flex align-items-center itemCircleFont">
                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                    <span>
                        Konya/Ilgın
                    </span>
                </li>
            @else
                @foreach (['column1', 'column2', 'column3'] as $column)
                    @php
                        $column_name = $project->listItemValues->{$column . '_name'} ?? '';
                        $column_additional = $project->listItemValues->{$column . '_additional'} ?? '';
                        $column_name_exists =
                            $column_name && isset($projectHousingsList[$keyIndex][$column_name . '[]']);
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
            @endif
            {{-- <li class="d-flex align-items-center itemCircleFont">
                <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                <span>
                    {{ date('j', strtotime($project->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($project->created_at))) . ' ' . date('Y', strtotime($project->created_at)) }}
                </span>
            </li> --}}

        </ul>


    </div>
</div>
<hr>




<!-- Modal -->
<div class="modal fade" id="approveProjectModalmobile{{ $keyIndex }}" tabindex="-1" role="dialog"
    aria-labelledby="approveProjectModalmobileLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" style="height: calc(100vh - 200px); overflow-y: scroll;">
                {{-- <h3 class="modal-title" style="margin:10px;font-size:12px !important;text-align:center"
                    id="approveProjectModalmobileLabel"> {{ $project->project_title }} Projesi {{ $keyIndex }} No'lu İlan için
                    Başvur</h3>
                <hr> --}}
                <form method="POST" action="{{ route('give_offer') }}">
                    @csrf
                    <input type="hidden" value="{{ $keyIndex }}" name="roomId">
                    <input type="hidden" value="{{ $project->id }}" name="projectId">
                    <input type="hidden" value="{{ $project->user_id }}" name="projectUserId">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="q-label">Ad Soyad : </label>
                                <input type="text" class="modal-input" placeholder="Ad Soyad" id="name"
                                    name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="q-label">Telefon Numarası : </label>
                                <input type="tel" class="modal-input" placeholder="Telefon Numarası"
                                    id="phone" name="phone" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="q-label">E-Posta : </label>
                                <input type="email" class="modal-input" placeholder="E-Posta" id="email"
                                    name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title" class="q-label">Meslek : </label>
                                <input type="text" class="modal-input" placeholder="Meslek" id="title"
                                    name="title" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city_id" class="q-label">İl</label>
                                <select
                                    class="form-control citySelect2 {{ $errors->has('city_id') ? 'error-border' : '' }}"
                                    name="city_id" required>
                                    <option value="">Seçiniz</option>
                                    @foreach ($towns as $item)
                                        <option value="{{ $item['sehir_key'] }}"
                                            {{ old('city_id') == $item['sehir_key'] ? 'selected' : '' }}>
                                            {{ $item['sehir_title'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="county_id" class="q-label">İlçe</label>
                                <select
                                    class="form-control countySelect {{ $errors->has('county_id') ? 'error-border' : '' }}"
                                    name="county_id" required>
                                    <option value="">Seçiniz</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="price" class="q-label">Teklif Ettiğiniz Fiyat : </label>
                                <input type="text" class="modal-input" placeholder="Fiyat" id="price"
                                    name="price" required>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="offer_description" class="q-label">Açıklama:</label>
                        <textarea class="modal-input" id="offer_description" rows="45" style="height: 130px !important;"
                            name="offer_description" required></textarea>
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

    <!-- Modal -->
    <div class="modal fade" id="contactModal{{ $sold->id }}" tabindex="-1" aria-labelledby="contactModalLabel"
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
                            {{ !empty($sold->phone) ? $sold->phone : (!is_null($sold->mobile_phone) ? $sold->mobile_phone : 'Belirtilmedi') }}
                        </li>


                    </ul>
                </div>
                <div class="modal-footer" style="justify-content: end !important">
                    <a href="tel:{{ isset($sold->phone) ? $sold->phone : null }}"><button class="btn btn-success"
                            style="width:100px">Ara</button></a>

                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                        style="width:100px">Kapat</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="neighborViewModalMobile{{ $sold->id }}" tabindex="-1"
        aria-labelledby="neighborViewModalMobileLabel" aria-hidden="true">

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
                                        <li><i class="fa fa-circle circleIcon mr-1" style="color: #EC2F2E ;"
                                                aria-hidden="true"></i>Ödeme işlemini tamamlayın ve belirtilen tutarı
                                            aşağıdaki banka hesaplarından birine havale veya EFT yapın.</li>
                                        <li><i class="fa fa-circle circleIcon mr-1" style="color: #EC2F2E ;"
                                                aria-hidden="true"></i>Ödemeniz onaylandıktan sonra, "Komşumu Gör"
                                            düğmesi
                                            aktif olacak ve komşunuzun iletişim bilgilerine ulaşabileceksiniz.</li>
                                    </ul>
                                </div>
                                <div class="ibanInfo" style="font-size: 12px !important"></div>

                            </div>
                        </div>

                    </div>

                    <div class="d-flex align-items-center">

                        <form action="{{ route('neighborView.index') }}" method="POST">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $sold->id }}">
                            <button type="submit" class="btn btn-success btn-lg btn-bloc mt-3k"
                                style="width:150px;float:right">
                                250 TL Öde
                            </button>
                        </form>
                        <button type="button" class="btn btn-secondary btn-lg btn-block mt-3 mb-3"
                            style="width:150px;margin-left:10px" data-bs-dismiss="modal">İptal</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        document.getElementById('price').addEventListener('input', function(e) {
            var value = e.target.value;
            // Sadece rakamları ve virgülü tut
            value = value.replace(/[^0-9,]/g, '');

            // Noktaları ve virgülü ayarlama
            if (value.includes(',')) {
                var parts = value.split(',');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                value = parts.join(',');
            } else {
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            e.target.value = value;
        });

        $('.bank-account').on('click', function() {
            // Tüm banka görsellerini seçim olmadı olarak ayarla
            $('.bank-account').removeClass('selected');
            // Seçilen banka görselini işaretle
            $(this).addClass('selected');

            // İlgili IBAN bilgisini al
            var selectedBankIban = $(this).data('iban');
            var selectedBankIbanID = $(this).data('id');
            var selectedBankTitle = $(this).data('title');

            var ibanInfo = "<span style='color:black'><strong>Hesap Sahibinin Adı Soyadı:</strong> " +
                selectedBankTitle + "<br><strong>IBAN:</strong> " + selectedBankIban + "</span>";
            $('.ibanInfo').html(ibanInfo);
        });


        $('#completePaymentButton{{ $sold->id }}').on('click', function() {
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

                        toastr.success(
                            'Ödeme onayından sonra komşu bilgileri tarafınıza iletilecektir.');
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



@endif
