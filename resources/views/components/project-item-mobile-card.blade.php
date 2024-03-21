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

@endphp
@php
    $off_sale_check = $projectHousingsList[$keyIndex]['off_sale[]'] == '[]';
    $share_sale = $projectHousingsList[$keyIndex]['share_sale[]'] ?? null;
    $number_of_share = $projectHousingsList[$keyIndex]['number_of_shares[]'] ?? null;
    $sold_check = $sold && in_array($sold->status, ['1', '0']);
    $discounted_price = $projectHousingsList[$keyIndex]['price[]'] - $projectDiscountAmount;
    $share_sale_empty = !isset($share_sale) || $share_sale == '[]';

@endphp

<div class="d-flex" style="flex-wrap: nowrap">
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
                        No
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
                    <span
                        class="btn @if (($sold && $sold->status == '1') || $projectHousingsList[$keyIndex]['off_sale[]'] != '[]') disabledShareButton @else addCollection mobileAddCollection @endif"
                        data-type='project' data-project='{{ $project->id }}' data-id='{{ $keyIndex }}'>
                        <i class="fa fa-bookmark-o"></i>
                    </span>
                    <span class="btn toggle-project-favorite bg-white" data-project-housing-id="{{ $keyIndex }}"
                        style="color: white;" data-project-id="{{ $project->id }}">
                        <i class="fa fa-heart-o"></i>
                    </span>
                </div>
            </a>
            <div class="d-flex align-items-end projectItemFlex">
                <div style="width: 50%;
                                align-items: center;">

                    @if (
                        ($projectHousingsList[$keyIndex]['off_sale[]'] != '[]' && !$sold) ||
                            ($sold && $sold->status == '2' && $projectHousingsList[$keyIndex]['off_sale[]'] != '[]'))
                        <button class="btn second-btn mobileCBtn"
                            style="background: #EA2B2E !important; width: 100%; color: White;">
                            <span class="text">Satışa Kapatıldı</span>
                        </button>
                    @else
                        @if (
                            ($sold_check && $share_sale_empty) ||
                                (isset($sumCartOrderQt[$keyIndex]) &&
                                    $sold_check &&
                                    $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share))
                            <button class="btn second-btn mobileCBtn"
                                @if (
                                    ($sold->status == '0' && (empty($share_sale) || $share_sale == '[]')) ||
                                        (isset($share_sale) &&
                                            $share_sale != '[]' &&
                                            isset($sumCartOrderQt[$keyIndex]) &&
                                            $sumCartOrderQt[$keyIndex]['qt_total'] != $number_of_share)) style="background: orange !important; color: White;"
                    @elseif ($sold->status == '1')
                        style="background: #EA2B2E !important; color: White; "
                    @else
                        style="background: #EA2B2E !important; color: White; " @endif>
                                @if ($sold->status == '0' && $share_sale_empty)
                                    <span class="text">Rezerve Edildi</span>
                                @elseif (
                                    ($sold->status == '1' && $share_sale_empty) ||
                                        (isset($sumCartOrderQt[$keyIndex]) && $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share))
                                    <span class="text">Satıldı</span>
                                @endif
                            </button>
                        @else
                            <div>
                                <span class="ml-auto text-primary priceFont">

                                    @if ($off_sale_check && $projectDiscountAmount)

                                        @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                            <span class="text-center w-100 d-block">
                                                1 / {{ $number_of_share }} Pay Fiyatı
                                            </span>
                                        @endif
                                        <h6
                                            style="color: #274abb !important; position: relative; top: 4px; font-weight: 700">
                                            @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                {{ number_format($discounted_price / $number_of_share, 0, ',', '.') }}
                                                ₺
                                            @else
                                                {{ number_format($discounted_price, 0, ',', '.') }}
                                                ₺
                                            @endif
                                        </h6>

                                        <h6
                                            style="color: #e54242 !important;position: relative;font-weight:700;font-size: 11px;text-decoration:line-through;">
                                            {{ number_format($projectHousingsList[$keyIndex]['price[]'], 0, ',', '.') }}
                                            ₺
                                        </h6>
                                    @elseif ($off_sale_check)
                                        @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                            <span class="text-center w-100 d-block">
                                                1 / {{ $number_of_share }} Pay Fiyatı
                                            </span>
                                        @endif
                                        <h6
                                            style="color: #274abb !important; position: relative; top: 4px; font-weight: 700">
                                            @if (isset($share_sale) && $share_sale != '[]' && $number_of_share != 0)
                                                {{ number_format($projectHousingsList[$keyIndex]['price[]'] / $number_of_share, 0, ',', '.') }}
                                                ₺
                                            @else
                                                {{ number_format($projectHousingsList[$keyIndex]['price[]'], 0, ',', '.') }}
                                                ₺
                                            @endif
                                        </h6>

                                    @endif
                                </span>
                                <button class="CartBtn second-btn mobileCBtn" data-type='project'
                                    data-project='{{ $project->id }}' data-id='{{ $keyIndex }}'
                                    data-share="{{ $share_sale }}" data-number-share="{{ $number_of_share }}">
                                    <span class="IconContainer">
                                        <img src="{{ asset('sc.png') }}" alt="">
                                    </span>
                                    <span class="text">Sepete Ekle</span>
                                </button>
                            </div>
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
                                data-bs-toggle="modal" data-bs-target="#neighborViewModal{{ $sold->id }}"
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
                            data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0) && $share_sale_empty) || (isset($sumCartOrderQt[$keyIndex]) && $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share) || (isset($projectHousingsList[$keyIndex + $lastHousingCount]['off_sale']) && $projectHousingsList[$keyIndex + $lastHousingCount]['off_sale'] != '[]') ? '1' : '0' }}"
                            order="{{ $keyIndex }}" data-block="{{ $blockName }}"
                            data-payment-order="{{ isset($blockStart) && $blockStart ? $i - $blockStart + 1 : $i + 1 }}">
                            Ödeme Detayı
                        </button>
                    @endif
                @else
                    @if (isset($projectHousingsList[$keyIndex]['off_sale[]']) &&
                            $projectHousingsList[$keyIndex]['off_sale[]'] != '[]' &&
                            !$sold)
                        @if (Auth::user())
                            <button class="first-btn payment-plan-mobile-btn mobileCBtn" data-toggle="modal"
                                data-target="#applyModal{{ $keyIndex }}"
                                style="width:50% !important;background-color:black !important;border:1px solid black;color:white">
                                Başvuru Yap
                            </button>
                        @else
                            <a href="{{ route('client.login') }}"
                                style="width:50% !important;
                            text-align: center;
                            align-items: center;
                            display: flex;
                            justify-content: center;background-color:black !important;border:1px solid black;color:white"
                                class="first-btn payment-plan-mobile-btn mobileCBtn">
                                Başvuru Yap
                            </a>
                        @endif
                    @else
                        <button class="first-btn payment-plan-button payment-plan-mobile-btn mobileCBtn"
                            style="width:50% !important;background-color:black !important;border:1px solid black;color:white"
                            project-id="{{ $project->id }}"
                            data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0) && $share_sale_empty) || (isset($sumCartOrderQt[$keyIndex]) && $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share) || (isset($projectHousingsList[$keyIndex + $lastHousingCount]['off_sale']) && $projectHousingsList[$keyIndex + $lastHousingCount]['off_sale'] != '[]') ? '1' : '0' }}"
                            order="{{ $keyIndex }}" data-block="{{ $blockName }}"
                            data-payment-order="{{ isset($blockStart) && $blockStart ? $i - $blockStart + 1 : $i + 1 }}">
                            Ödeme Detayı
                        </button>
                    @endif
                @endif

            </div>
        </div>
    </div>
</div>
<div class="w-100" style="height: 25px; background-color: #8080802e; margin-top: 15px">
    <div class="d-flex justify-content-between align-items-center" style="height: 100%">

        <ul class="d-flex justify-content-start align-items-center h-100 w-100"
            style="list-style: none;padding:0;font-weight:600;padding: 10px;justify-content:start;margin-bottom:0 !important">

            @foreach (['column1', 'column2', 'column3'] as $column)
                @php
                    $column_name = $project->listItemValues->{$column . '_name'} ?? '';
                    $column_additional = $project->listItemValues->{$column . '_additional'} ?? '';
                    $column_name_exists = $column_name && isset($projectHousingsList[$keyIndex][$column_name . '[]']);
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
        </ul>

        <span
            style="    font-size: 9px !important;
                            width: 50% !important;
                            text-align: right;
                            margin-right: 10px;">{!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}</span>
    </div>
</div>
<hr>




<!-- Modal -->
<div class="modal fade" id="applyModal{{ $keyIndex }}" tabindex="-1" role="dialog"
    aria-labelledby="applyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-body">
                <h3 class="modal-title" style="margin:10px;font-size:12px !important;text-align:center"
                    id="applyModalLabel"> {{ $project->project_title }} Projesi {{ $keyIndex }} No'lu İlan için
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
                                    class="form-control citySelect2 {{ $errors->has('city_id') ? 'error-border' : '' }}"
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

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        style="width:100px">Kapat</button>
                </div>
            </div>
        </div>
    </div>

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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


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

        $(document).ready(function() {
            $('#applySampleModal img').click(function() {
                $('#applySampleModal').modal('hide');
                $('#exampleModal10').modal('show');
            });
        });

        $(document).on("change",".citySelect2", function() {
                var selectedCity = $(this).val();
                console.log(selectedCity);
                $.ajax({
                    type: 'GET',
                    url: '/get-counties/' + selectedCity,
                    success: function(data) {
                        var countySelect = $('.countySelect');
                        countySelect.empty();
                        countySelect.append('<option value="">İlçe Seçiniz</option>');
                        $.each(data, function(index, county) {
                            countySelect.append('<option value="' + county.ilce_key +
                                '">' + county
                                .ilce_title +
                                '</option>');
                        });
                    }
                });
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
