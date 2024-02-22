@props(['room_order', 'i','projectHousingsList','lastHousingCount','sold','projectDiscountAmount'])

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
                        class="btn @if (($sold && $sold->status == '1') || $projectHousingsList[$i + 1]['off_sale[]'] != '[]') disabledShareButton @else addCollection mobileAddCollection @endif"
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
                    @if ($projectHousingsList[$i + 1]['off_sale[]'] != '[]')
                        <button class="btn second-btn  mobileCBtn"
                            style="background: #EA2B2E !important;width:100%;color:White">

                            <span class="text">Satışa
                                Kapatıldı</span>
                        </button>
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

               

                @if ($projectHousingsList[$i + 1]['off_sale[]'] == '[]')
                    @if ($sold)
                        <button class="btn  payment-plan-button payment-plan-mobile-btn mobileCBtn"
                            style="width:50% !important" project-id="{{ $project->id }}"
                            data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0)) || $projectHousingsList[$i + 1]['off_sale[]'] != '[]' ? '1' : '0' }}"
                            order="{{ $i + 1 + $lastHousingCount }}">
                            Ödeme Detayı
                        </button>
                    @else
                        <button class="btn  payment-plan-button payment-plan-mobile-btn mobileCBtn"
                            style="width:50% !important" project-id="{{ $project->id }}"
                            data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0)) || $projectHousingsList[$i + 1]['off_sale[]'] != '[]' ? '1' : '0' }}"
                            order="{{ $i + 1 + $lastHousingCount }}">
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
