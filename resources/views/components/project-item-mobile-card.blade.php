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
<<<<<<< HEAD
    'blockStart'
=======
    'blockStart',
>>>>>>> 199d957f09454fe2229081f2d19c89ab6190b568
])
@php
    if ($key == 0) {
        $keyIndex = $i + 1;
    } else {
        $keyIndex = $i + 1 + $allCounts;
    }

@endphp


<div class="d-flex" style="flex-wrap: nowrap">
    <div class="align-items-center d-flex" style="padding-right:0; width: 110px;">
        <div class="project-inner project-head">
            {{-- <a href="{{ route('project.housings.detail', [$project->id, $keyIndex]) }}"> --}}
            <a
                href="{{ route('project.housings.detail', [
                      'projectSlug' => $project->slug. "-".$statusSlug. "-".$project->step2_slug. "-". $project->housingtype->slug."-". strtolower($project->city->title)."-". strtolower($project->county->ilce_title),
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
                        @if(isset($blockStart) && $blockStart)
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
                      'projectSlug' => $statusSlug. "-".$project->step2_slug. "-". $project->housingtype->slug."-".$project->slug."-". strtolower($project->city->title)."-". strtolower($project->county->ilce_title),
                    'projectID' => $project->id + 1000000,
                    'housingOrder' => $keyIndex,
                ]) }}">
                <div class="d-flex justify-content-between" style="gap:8px;">
                    <h3>
                        @if (isset($projectHousingsList[$keyIndex]['advertise_title[]']))
                            {{ $projectHousingsList[$keyIndex]['advertise_title[]'] }}
                            {{ $blockName }}
                            {{ $i + 1 }}
                            {{ "No'lu" }}
                            {{ $project->step1_slug }}
                        @else
                            {{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}
                            Projesinde {{ $blockName }}
                            {{ $i + 1 }}
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
                    @php
                        $off_sale_check = $projectHousingsList[$keyIndex]['off_sale[]'] == '[]';
                        $share_sale = $projectHousingsList[$keyIndex]['share_sale[]'] ?? null;
                        $number_of_share = $projectHousingsList[$keyIndex]['number_of_shares[]'] ?? null;
                        $sold_check = $sold && in_array($sold->status, ['1', '0']);
                        $discounted_price = $projectHousingsList[$keyIndex]['price[]'] - $projectDiscountAmount;
                    @endphp
                    @if ($projectHousingsList[$keyIndex]['off_sale[]'] != '[]' && !$sold)
                        <button class="btn second-btn mobileCBtn"
                            style="background: #EA2B2E !important; width: 100%; color: White;">
                            <span class="text">Satışa Kapatıldı</span>
                        </button>
                    @else
                        @if (
                            ($sold && $sold->status != '2' && empty($share_sale)) ||
                                (isset($sumCartOrderQt[$keyIndex]) && $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share))
                            <button class="btn second-btn mobileCBtn"
                                @if ($sold->status == '0') style="background: orange !important; color: White;" @else  style="background: #EA2B2E !important; color: White;" @endif>
                                @if ($sold->status == '0' && empty($share_sale))
                                    <span class="text">Rezerve Edildi</span>
                                @elseif (
                                    ($sold->status == '1' && empty($share_sale)) ||
                                        (isset($sumCartOrderQt[$keyIndex]) && $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share))
                                    <span class="text">Satıldı</span>
                                @endif
                            </button>
                        @else
                            <div>
                                <span class="ml-auto text-primary priceFont">
                                    @php
                                        $off_sale_check = $projectHousingsList[$keyIndex]['off_sale[]'] == '[]';
                                        $share_sale = $projectHousingsList[$keyIndex]['share_sale[]'] ?? null;
                                        $number_of_share =
                                            $projectHousingsList[$keyIndex]['number_of_shares[]'] ?? null;
                                        $sold_check = $sold && in_array($sold->status, ['1', '0']);
                                        $discounted_price =
                                            $projectHousingsList[$keyIndex]['price[]'] - $projectDiscountAmount;
                                    @endphp

                                    @if (isset($share_sale) && !empty($share_sale) && $number_of_share != 0)
                                        <span class="text-center w-100 d-block">
                                            1 Pay Fiyatı
                                        </span>
                                    @endif

                                    @if ($off_sale_check && $projectDiscountAmount)
                                        <h6
                                            style="color: #274abb !important; position: relative; top: 4px; font-weight: 600">
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
                                    @elseif ($off_sale_check)
                                        <h6
                                            style="color: #274abb !important; position: relative; top: 4px; font-weight: 600">
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

                                            </div>

                @if (isset($sold) && $sold->status == '1')
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
                        <button
                            class="btn payment-plan-button first-btn payment-plan-mobile-btn mobileCBtn see-my-neighbor"
                            style="width:50% !important;color:#274abb !important"
                            @if (Auth::check()) data-bs-toggle="modal"
                        data-bs-target="#paymentModal" data-order="{{ $sold->id }}" @endif>
                            <span>Komşumu Gör</span>
                        </button>
                    @elseif($neighborView && $neighborView->status == '0')
                        <button class="btn payment-plan-button payment-plan-mobile-btn mobileCBtn"
                            style="width:50% !important">
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
                        <button class="btn payment-plan-button payment-plan-mobile-btn mobileCBtn"
                            style="width:50% !important">
                            <a href="tel: {{ $sold->phone }}" style="color:#274abb">
                                <span>
                                    <svg viewBox="0 0 24 24" width="12" height="12" stroke="currentColor"
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
                        </button>
                    @elseif($isUserSame == true)
                        <button class="btn payment-plan-button payment-plan-mobile-btn mobileCBtn"
                            style="width:50% !important"> <span>
                                Size Ait Ürün
                            </span>
                        </button>
                    @endif
                @else
                    @if (isset($projectHousingsList[$keyIndex]['off_sale']) && $projectHousingsList[$keyIndex]['off_sale'] != '[]')
                        @if (Auth::user())
                            <button class="first-btn payment-plan-button payment-plan-mobile-btn mobileCBtn"
                                data-toggle="modal" data-target="#offerModal{{ $keyIndex }}"
                                style="width:50% !important">
                                Başvuru Yap
                            </button>
                        @else
                            <a href="{{ route('client.login') }}"
                                style="width:50% !important;
                            text-align: center;
                            align-items: center;
                            display: flex;
                            justify-content: center;"
                                class="first-btn payment-plan-button payment-plan-mobile-btn mobileCBtn">
                                Başvuru Yap
                            </a>
                        @endif
                    @else
                        <button class="first-btn payment-plan-button payment-plan-mobile-btn mobileCBtn"
                            style="width:50% !important" project-id="{{ $project->id }}"
                            data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0)) || (isset($projectHousingsList[$keyIndex + $lastHousingCount]['off_sale']) && $projectHousingsList[$keyIndex + $lastHousingCount]['off_sale'] != '[]') ? '1' : '0' }}"
                            order="{{ $keyIndex }}" data-block="{{ $blockName }}" data-payment-order="{{ $i + 1 }}">
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
<div class="modal fade" id="offerModal{{ $keyIndex }}" tabindex="-1" role="dialog"
    aria-labelledby="offerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

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
