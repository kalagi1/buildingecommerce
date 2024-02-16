@props(['project', 'index', 'housingsList', 'sold', 'lastHousingCount'])

<div class="col-md-12 col-12">
    <div class="project-card mb-3">
        <div class="row">
            <div class="col-md-3">
                <a href="{{ route('project.housings.detail', [$project->slug, $i + 1]) }}"
                    style="height: 100%">
                    <div class="d-flex"
                        style="height: 100%;">
                        <div
                            style="background-color: #EA2B2E  !important; border-radius: 0px 8px 0px 8px;height:100%">
                            <p
                                style="padding: 10px; color: white; height: 100%; display: flex; align-items: center;text-align:center; ">
                                No
                                <br>{{ $i + 1 + $lastHousingCount }}


                            </p>
                        </div>
                        <div class="project-single mb-0 bb-0 aos-init aos-animate"
                            data-aos="fade-up">
                            <div
                                class="button-effect-div">

                                <span
                                    class="btn 
                            @if (($sold && $sold->status == '1') || $projectHousingsList[$i + 1]['off_sale[]'] != '[]') disabledShareButton @else addCollection mobileAddCollection @endif"
                                    data-type='project'
                                    data-project='{{ $project->id }}'
                                    data-id='{{ $i + 1 }}'>
                                    <i
                                        class="fa fa-bookmark-o"></i>
                                </span>
                                <div href="javascript:void()"
                                    class="btn toggle-project-favorite bg-white"
                                    data-project-housing-id="{{ $i + 1 }}"
                                    data-project-id={{ $project->id }}>
                                    <i
                                        class="fa fa-heart-o"></i>
                                </div>
                            </div>
                            <div
                                class="homes position-relative">
                                <!-- homes img -->
                                <img src="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[$i + 1]['image[]'] }}"
                                    alt="home-1"
                                    class="img-responsive"
                                    style="height: 100px !important;object-fit:cover">


                            </div>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-lg-9 col-md-9 homes-content pb-0 mb-44 aos-init aos-animate"
                data-aos="fade-up">

                <div class="row align-items-center justify-content-between mobile-position"
                    @if (($sold && $sold->status != '2') || $projectHousingsList[$i + 1]['off_sale[]'] != '[]') style="background: #EEE !important;" @endif>
                    <div class="col-md-8">

                        <div
                            class="homes-list-div">
                            <ul
                                class="homes-list clearfix pb-3 d-flex">
                                <li
                                    class="d-flex align-items-center itemCircleFont">
                                    <i class="fa fa-circle circleIcon mr-1"
                                        style="color: black;"
                                        aria-hidden="true"></i>
                                    <span>{{ $project->housingType->title }}</span>
                                </li>
                                @if (isset($project->listItemValues) &&
                                        isset($project->listItemValues->column1_name) &&
                                        $project->listItemValues->column1_name)
                                    <li
                                        class="d-flex align-items-center itemCircleFont">
                                        <i class="fa fa-circle circleIcon mr-1"
                                            aria-hidden="true"></i>
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
                                    <li
                                        class="d-flex align-items-center itemCircleFont">
                                        <i class="fa fa-circle circleIcon mr-1"
                                            aria-hidden="true"></i>
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
                                    <li
                                        class="d-flex align-items-center itemCircleFont">
                                        <i class="fa fa-circle circleIcon mr-1"
                                            aria-hidden="true"></i>
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

                                <li
                                    class="the-icons mobile-hidden">
                                    <span>
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
                                </li>


                            </ul>

                        </div>
                        <div
                            class="footer">
                            <a
                                href="{{ route('institutional.profile', ['slug' => Str::slug($project->user->name), 'userID' => $project->user->id]) }}">
                                <img src="{{ url('storage/profile_images/' . $project->user->profile_image) }}"
                                    alt=""
                                    class="mr-2">
                                {{ $project->user->name }}
                            </a>
                            <span
                                class="price-mobile">
                                @if ($projectHousingsList[$i + 1]['off_sale[]'] == '[]')
                                    @if ($sold)
                                        @if ($sold->status != '1' && $sold->status != '0')
                                            @if ($projectDiscountAmount)
                                                <h6
                                                    style="color: #274abb !important;position: relative;top:4px;font-weight:600;font-size: 11px;text-decoration:line-through;margin-right:5px">
                                                    {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                    ₺
                                                </h6>
                                                <h6
                                                    style="color: #274abb;position: relative;top:4px;font-weight:600;font-size:20px;">
                                                    {{ number_format($projectHousingsList[$i + 1]['price[]'] - $projectDiscountAmount, 0, ',', '.') }}

                                                    ₺
                                                </h6>
                                            @else
                                                <h6
                                                    style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                    {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}₺
                                                </h6>
                                            @endif
                                        @endif
                                    @else
                                        @if ($projectDiscountAmount)
                                            <h6
                                                style="color: #274abb !important;position: relative;top:4px;font-weight:600;font-size: 11px;text-decoration:line-through;margin-right:5px">
                                                {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                ₺
                                            </h6>
                                            <h6
                                                style="color: #274abb;position: relative;top:4px;font-weight:600;font-size:20px;">
                                                {{ number_format($projectHousingsList[$i + 1]['price[]'] - $projectDiscountAmount, 0, ',', '.') }}

                                                ₺
                                            </h6>
                                        @else
                                            <h6
                                                style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}₺
                                            </h6>
                                        @endif
                                    @endif
                                @endif


                            </span>
                        </div>
                    </div>

                    <div class="col-md-3 mobile-hidden"
                        style="height: 100px;padding:0">
                        <div class="homes-button"
                            style="width:100%;height:100%">
                            <button
                                class="first-btn payment-plan-button"
                                project-id="{{ $project->id }}"
                                data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0)) || $projectHousingsList[$i + 1]['off_sale[]'] != '[]' ? '1' : '0' }}"
                                order="{{ $i + 1 }}">
                                Ödeme
                                Detayı
                            </button>

                            @if ($projectHousingsList[$i + 1]['off_sale[]'] != '[]')
                                <button
                                    class="btn second-btn"
                                    style="background: #EA2B2E !important;width:100%;color:White;height: auto !important">

                                    <span
                                        class="text">Satışa
                                        Kapatıldı</span>
                                </button>
                            @else
                                @if ($sold && $sold->status != '2')
                                    <button
                                        class="btn second-btn"
                                        @if ($sold->status == '0') style="background: orange !important;color:White;height: auto !important" @else  style="background: #EA2B2E !important;color:White;height: auto !important" @endif>
                                        @if ($sold->status == '0')
                                            <span
                                                class="text">Onay
                                                Bekleniyor</span>
                                        @else
                                            <span
                                                class="text">Satıldı</span>
                                        @endif
                                    </button>
                                @else
                                    <button
                                        class="CartBtn second-btn mobileCBtn"
                                        data-type='project'
                                        data-project='{{ $project->id }}'
                                        style="height: auto !important"
                                        data-id='{{ $i + 1 }}'>
                                        <span
                                            class="IconContainer">
                                            <img src="{{ asset('sc.png') }}"
                                                alt="">
                                        </span>
                                        <span
                                            class="text">Sepete
                                            Ekle</span>
                                    </button>
                                @endif
                            @endif

                        </div>
                    </div>

                    </span>
                </div>
            </div>
        </div>

    </div>
</div>