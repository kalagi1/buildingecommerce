@props([
    'room_order',
    'i',
    'projectHousingsList',
    'isUserSame',
    'lastHousingCount',
    'sold',
    'projectDiscountAmount',
])

<div class="d-flex" style="flex-wrap: nowrap">
    <div class="align-items-center d-flex" style="padding-right:0; width: 110px;">
        <div class="project-inner project-head">
            <a href="{{ route('project.housings.detail', [$project->slug, $room_order]) }}">
                <div class="homes">
                    <!-- homes img -->
                    <div class="homes-img h-100 d-flex align-items-center" style="width: 100px; height: 128px;">
                        <img src="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[$i + 1]['image[]'] }}"
                            alt="{{ $project->housingType->title }}" class="img-responsive"
                            style="height: 95px !important;">
                    </div>

                    <span class="mobileNoStyle">
                        No
                        {{ $i + 1 + $lastHousingCount }}
                    </span>
                </div>
            </a>
        </div>
    </div>
    <div class="w-100" style="padding-left:0;">
        <div class="bg-white px-3 h-100 d-flex flex-column justify-content-center">
            <a style="text-decoration: none; height: 100%"
                href="{{ route('project.housings.detail', [$project->slug, $room_order]) }}">
                <div class="d-flex justify-content-between" style="gap:8px;">
                    <h3>
                        @if (isset($projectHousingsList[$i + 1]['advertise_title[]']))
                            {{ $projectHousingsList[$i + 1]['advertise_title[]'] }}
                        @else
                            {{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}
                            Projesinde
                            {{ $i + 1 }}
                            {{ "No'lu" }}
                            {{ $project->step1_slug }}
                        @endif
                    </h3>
                    <span
                        class="btn @if (
                            ($sold && $sold->status == '1') ||
                                $projectHousingsList[$i + 1]['off_sale[]'] != '["Sat\u0131\u015fa A\u00e7\u0131k"]') disabledShareButton @else addCollection mobileAddCollection @endif"
                        data-type='project' data-project='{{ $project->id }}'
                        data-id='{{ $i + 1 + $lastHousingCount }}'>
                        <i class="fa fa-bookmark-o"></i>
                    </span>
                    <span class="btn toggle-project-favorite bg-white"
                        data-project-housing-id="{{ $i + 1 + $lastHousingCount }}" style="color: white;"
                        data-project-id="{{ $project->id }}">
                        <i class="fa fa-heart-o"></i>
                    </span>
                </div>
            </a>
            <div class="d-flex align-items-end projectItemFlex">
                <div style="width: 50%;
                                align-items: center;">
                    @if (
                        $projectHousingsList[$i + 1]['off_sale[]'] != '["Sat\u0131\u015fa A\u00e7\u0131k"]' &&
                            $projectHousingsList[$i + 1]['off_sale[]'] != '[]' &&
                            $projectHousingsList[$i + 1]['off_sale[]'] != 'Satışa Açık')
                        @if (
                            $projectHousingsList[$i + 1]['off_sale[]'] == '["Sat\u0131\u015fa Kapal\u0131"]' ||
                                $projectHousingsList[$i + 1]['off_sale[]'] == 'Satışa Kapalı' ||
                                $projectHousingsList[$i + 1]['off_sale[]'] == '["Satışa Kapalı"]')
                            <button class="btn second-btn  mobileCBtn"
                                style="background: #EA2B2E !important;width:100%;color:White">

                                <span class="text">Satışa
                                    Kapatıldı</span>
                            </button>
                        @elseif ($projectHousingsList[$i + 1]['off_sale[]'] == '["Sat\u0131ld\u0131"]')
                            <button class="btn second-btn  mobileCBtn"
                                style="background: #EA2B2E !important;color:White;">
                                <span class="text">Satıldı</span>
                            </button>
                        @endif
                    @else
                        @if ($sold && $sold->status != '2')
                            <button class="btn second-btn  mobileCBtn"
                                @if ($sold->status == '0') style="background: orange !important;color:White" @else  style="background: #EA2B2E !important;color:White;" @endif>
                                @if ($sold->status == '0')
                                    <span class="text">Onay
                                        Bekleniyor</span>
                                @else
                                    <span class="text">Satıldı</span>
                                @endif
                            </button>
                        @else
                            <div>
                                <span class="ml-auto text-primary priceFont">
                                    @if ($projectHousingsList[$i + 1]['off_sale[]'] == '[]')
                                        @if ($sold)
                                            @if ($sold->status != '1' && $sold->status != '0')
                                                @if ($projectDiscountAmount)
                                                    <h6
                                                        style="color: #274abb;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'] - $projectDiscountAmount, 0, ',', '.') }}
                                                        ₺
                                                    </h6>
                                                    <h6
                                                        style="color: #e54242  !important;position: relative;top:4px;font-weight:600;font-size: 11px;text-decoration:line-through;">
                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                        ₺

                                                    </h6>
                                                @else
                                                    <h6
                                                        style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                        ₺
                                                    </h6>
                                                @endif
                                            @endif
                                        @else
                                            @if ($projectDiscountAmount)
                                                <h6
                                                    style="color: #274abb;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                    {{ number_format($projectHousingsList[$i + 1]['price[]'] - $projectDiscountAmount, 0, ',', '.') }}
                                                    ₺
                                                </h6>
                                                <h6
                                                    style="color: #e54242  !important;position: relative;top:4px;font-weight:600;font-size: 11px;text-decoration:line-through;">
                                                    {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                    ₺

                                                </h6>
                                            @else
                                                <h6
                                                    style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                    {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                    ₺
                                                </h6>
                                            @endif
                                        @endif
                                    @endif
                                </span>
                                <button class="CartBtn second-btn mobileCBtn " data-type='project'
                                    data-project='{{ $project->id }}' data-id='{{ $i + 1 + $lastHousingCount }}'>
                                    <span class="IconContainer">
                                        <img src="{{ asset('sc.png') }}" alt="">
                                    </span>
                                    <span class="text">Sepete
                                        Ekle</span>
                                </button>
                            </div>
                        @endif
                    @endif


                </div>



                @if (isset($sold) && $sold->status == '1')
                    @php
                        $neighborView = null;

                        if (Auth::check()) {
                            $neighborView = App\Models\NeighborView::where('user_id', Auth::user()->id)
                                ->where('project_id', $project->id)
                                ->where('housing', $room_order)
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
                    <button class="btn  payment-plan-button payment-plan-mobile-btn mobileCBtn"
                        style="width:50% !important" project-id="{{ $project->id }}"
                        data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0)) || $projectHousingsList[$i + 1]['off_sale[]'] != '["Sat\u0131\u015fa A\u00e7\u0131k"]' ? '1' : '0' }}"
                        order="{{ $i + 1 + $lastHousingCount }}">
                        Ödeme Detayı

                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="w-100" style="height: 25px; background-color: #8080802e; margin-top: 15px">
    <div class="d-flex justify-content-between align-items-center" style="height: 100%">

        <ul class="d-flex justify-content-start align-items-center h-100 w-100"
            style="list-style: none;padding:0;font-weight:600;padding: 10px;justify-content:start;margin-bottom:0 !important">

            @if (isset($project->listItemValues) &&
                    isset($project->listItemValues->column1_name) &&
                    $project->listItemValues->column1_name)
                <li class="d-flex align-items-center itemCircleFont">
                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                    <span>
                        {{ $projectHousingsList[$i + 1][$project->listItemValues->column1_name . '[]'] }}
                        @if (isset($project->listItemValues) &&
                                isset($project->listItemValues->column1_additional) &&
                                $project->listItemValues->column1_additional)
                            {{ $project->listItemValues->column1_additional }}
                        @endif
                    </span>
                </li>
            @endif
            @if (isset($project->listItemValues) &&
                    isset($project->listItemValues->column2_name) &&
                    $project->listItemValues->column2_name)
                <li class="d-flex align-items-center itemCircleFont">
                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                    <span>
                        {{ $projectHousingsList[$i + 1][$project->listItemValues->column2_name . '[]'] }}
                        @if (isset($project->listItemValues) &&
                                isset($project->listItemValues->column2_additional) &&
                                $project->listItemValues->column2_additional)
                            {{ $project->listItemValues->column2_additional }}
                        @endif
                    </span>
                </li>
            @endif
            @if (isset($project->listItemValues) &&
                    isset($project->listItemValues->column3_name) &&
                    $project->listItemValues->column3_name)
                <li class="d-flex align-items-center itemCircleFont">
                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                    <span>
                        {{ $projectHousingsList[$i + 1][$project->listItemValues->column3_name . '[]'] }}
                        @if (isset($project->listItemValues) &&
                                isset($project->listItemValues->column3_additional) &&
                                $project->listItemValues->column3_additional)
                            {{ $project->listItemValues->column3_additional }}
                        @endif
                    </span>
                </li>
            @endif
        </ul>

        <span
            style="    font-size: 9px !important;
                            width: 50% !important;
                            text-align: right;
                            margin-right: 10px;">{!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}</span>
    </div>
</div>
<hr>
