@php
if (!function_exists('getHouse')) {
    function getHouse($project, $key, $roomOrder)
    {
        foreach ($project->roomInfo as $room) {
            if ($room->room_order == $roomOrder && $room->name == $key) {
                return $room;
            }
        }
    }
}
@endphp

@php

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

        function getImage($housing, $key)
        {
            $housing_type_data = json_decode($housing->housing_type_data);
            $a = $housing_type_data->$key;
            return $a;
        }
    @endphp

<section class="featured portfolio rec-pro disc bg-white finish-projects">
    <div class="container">
        <div style="display: flex; justify-content: space-between;">
            <div class="section-title">
                <h2>Tamamlanan Projeler</h2>
            </div>
        </div>
        @php
            if (!function_exists('getHouse')) {
                function getHouse($project, $key, $roomOrder)
                {
                    foreach ($project->roomInfo as $room) {
                        if ($room->room_order == $roomOrder && $room->name == $key) {
                            return $room;
                        }
                    }
                }
            }
        @endphp
        <div class="mobile-show">
            @foreach ($finishProjects as $project)
                @for ($i = 0; $i < 1; $i++)
                    @php($room_order = $i + 1)
                    @php(
                        $discount_amount =
                            App\Models\Offer::where('type', 'project')->where('project_id', $project->id)->where('project_housings', 'LIKE', "%\"{$room_order}\"%")->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0
                    )
                    @php($sold = DB::select('SELECT * FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "project"  AND JSON_EXTRACT(cart, "$.item.housing") = ? AND JSON_EXTRACT(cart, "$.item.id") = ? LIMIT 1', [getHouse($project, 'price[]', $i + 1)->room_order, $project->id]))

                    <div class="d-flex" style="flex-wrap: nowrap">
                        <div class="align-items-center d-flex" style="padding-right:0; width: 110px;">
                            <div class="project-inner project-head">
                                <a href="{{ route('project.housings.detail', [$project->slug, $room_order]) }}">
                                    <div class="homes">
                                        <!-- homes img -->

                                        <div class="homes-img h-100 d-flex align-items-center"
                                            style="width: 130px; height: 128px;">

                                            <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', $i + 1)->value }}"
                                                alt="{{ $project->housingType->title }}" class="img-responsive"
                                                style="height: 80px !important;">
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="w-100" style="padding-left:0;">
                            <div class="bg-white px-3 h-100 d-flex flex-column justify-content-center">

                                <a style="text-decoration: none;height:100%"
                                    href="{{ route('project.housings.detail', [$project->slug, $i + 1]) }}">
                                    <h3>
                                        @php($advertiseTitle = getHouse($project, 'advertise_title[]', $i + 1)->value ?? null)

                                        @if ($advertiseTitle)
                                            {{ $advertiseTitle }}
                                        @else
                                            {{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}
                                            Projesinde
                                            {{ $i + 1 }} {{ "No'lu" }} {{ $project->step1_slug }}
                                        @endif
                                    </h3>
                                </a>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex" style="gap: 8px;">
                                        <span class="btn toggle-project-favorite bg-white"
                                            data-project-housing-id="{{ $room_order }}" style="color: white;"
                                            data-project-id="{{ $project->id }}">
                                            <i class="fa fa-heart-o"></i>
                                        </span>

                                       @if (getHouse($project, 'off_sale[]', $i + 1)->value != "[]")
                                            <button class="btn   mobileBtn  second-btn CartBtn" disabled
                                                style="background: red !important;width:100%;color:White">
                                                <span class="IconContainer">
                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                </span>
                                                <span class="text">Satıldı</span>
                                            </button>
                                        @else
                                            @if ($sold && $sold[0]->status != '2')
                                                <button class="btn mobileBtn second-btn CartBtn" disabled
                                                    @if ($sold[0]->status == '0') style="background: orange !important;width:100%;color:White"
                                @else 
                                style="background: red !important;width:100%;color:White" @endif>
                                                    <span class="IconContainer">
                                                        <img src="{{ asset('sc.png') }}" alt="">
                                                    </span>
                                                    @if ($sold[0]->status == '0')
                                                        <span class="text">Onay Bekleniyor</span>
                                                    @else
                                                        <span class="text">Satıldı</span>
                                                    @endif
                                                </button>
                                            @else
                                                <button class="CartBtn mobileBtn" data-type='project'
                                                    data-project='{{ $project->id }}'
                                                    data-id='{{ getHouse($project, 'price[]', $i + 1)->room_order }}'>
                                                    <span class="IconContainer">
                                                        <img src="{{ asset('sc.png') }}" alt="">
                                                    </span>
                                                    <span class="text">Sepete Ekle</span>
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                    <span class="ml-auto text-primary priceFont">
                                        @if ($discount_amount)
                                            <svg viewBox="0 0 24 24" width="24" height="24"
                                                stroke="currentColor" stroke-width="2" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                <polyline points="17 18 23 18 23 12"></polyline>
                                            </svg>
                                        @endif
                                        @if (getHouse($project, 'off_sale[]', $i + 1)->value == "[]")
                                            @if ($sold)
                                                @if ($sold[0]->status != '1' && $sold[0]->status != '0')
                                                    {{ number_format(getHouse($project, 'price[]', $i + 1)->value - $discount_amount, 0, ',', '.') }}
                                                    ₺
                                                @endif
                                            @else
                                                {{ number_format(getHouse($project, 'price[]', $i + 1)->value - $discount_amount, 0, ',', '.') }}
                                                ₺
                                            @endif
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-100" style="height:40px;background-color:#8080802e;margin-top:20px">
                        <ul class="d-flex justify-content-around align-items-center h-100"
                            style="list-style: none;padding:0;font-weight:600">
                            @if (isset($project->listItemValues) &&
                                    isset($project->listItemValues->column1_name) &&
                                    $project->listItemValues->column1_name)
                                <li class="sude-the-icons" style="width:auto !important">
                                    <i class="fa fa-circle circleIcon mr-1"></i>
                                    <span>
                                        {{ getHouse($project, $project->listItemValues->column1_name . '[]', $i + 1)->value }}
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
                                <li class="sude-the-icons" style="width:auto !important">
                                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                    <span>
                                        {{ getHouse($project, $project->listItemValues->column2_name . '[]', $i + 1)->value }}
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
                                <li class="sude-the-icons" style="width:auto !important">
                                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                    <span>
                                        {{ getHouse($project, $project->listItemValues->column3_name . '[]', $i + 1)->value }}
                                        @if (isset($project->listItemValues) &&
                                                isset($project->listItemValues->column3_additional) &&
                                                $project->listItemValues->column3_additional)
                                            {{ $project->listItemValues->column3_additional }}
                                        @endif
                                    </span>
                                </li>
                            @endif
                            <li class="d-flex align-items-center itemCircleFont">
                                <i class="fa fa-circle circleIcon"></i>
                                {{ $project->city->title }} {{ '/' }} {{ $project->county->ilce_title }}
                            </li>



                        </ul>
                    </div>
                    <hr>
                @endfor
            @endforeach
        </div>

        <div class="mobile-hidden">
            @if (count($finishProjects))
                <div class="properties-right list featured portfolio blog pb-5 bg-white">
                    <div class="container">
                        <div class="row project-filter-reverse blog-pots finish-projects-web">
                            @foreach ($finishProjects as $project)
                                @for ($i = 0; $i < 1; $i++)
                                    @php($room_order = $i + 1)
                                    @php(
                                        $discount_amount =
                                            App\Models\Offer::where('type', 'project')->where('project_id', $project->id)->where('project_housings', 'LIKE', "%\"{$room_order}\"%")->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0
                                            )
                                    @php($sold = DB::select('SELECT * FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "project"  AND JSON_EXTRACT(cart, "$.item.housing") = ? AND JSON_EXTRACT(cart, "$.item.id") = ? LIMIT 1', [getHouse($project, 'price[]', $i + 1)->room_order, $project->id]))

                                    <div data-aos="fade-up" data-aos-delay="150">
                                        <a class="text-decoration-none"
                                            href="{{ route('project.housings.detail', [$project->slug, $room_order]) }}">
                                            <div class="landscapes">
                                                <div class="project-single">
                                                    <div class="project-inner project-head">
                                                        <div class="homes">
                                                            <!-- homes img -->

                                                            <div class="homes-img">
                                                                @if ($project->doping_time)
                                                                    <div class="homes-tag button alt featured">Öne
                                                                        Çıkan
                                                                    </div>
                                                                @endif
                                                                @if ($discount_amount)
                                                                    <div class="homes-tag button alt sale"
                                                                        style="background-color:#EA2B2E!important">
                                                                        İNDİRİM
                                                                    </div>
                                                                @endif

                                                                <img src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', $i + 1)->value }}"
                                                                    alt="{{ $project->housingType->title }}"
                                                                    class="img-responsive">
                                                            </div>
                                                        </div>
                                                        <div class="button-effect">
                                                            <span class="btn toggle-project-favorite bg-white"
                                                                data-project-housing-id="{{ $i + 1 }}"
                                                                data-project-id={{ $project->id }}>
                                                                <i class="fa fa-heart-o"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <!-- homes content -->
                                                    <div class="homes-content p-3">

                                                        <span style="text-decoration: none">
                                                            <h3>
                                                                @php($advertiseTitle = getHouse($project, 'advertise_title[]', $i + 1)->value ?? null)

                                                                @if ($advertiseTitle)
                                                                    {{ $advertiseTitle }}
                                                                @else
                                                                    {{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}
                                                                    Projesinde
                                                                    {{ $i + 1 }} {{ "No'lu" }}
                                                                    {{ $project->step1_slug }}
                                                                @endif
                                                            </h3>

                                                            <p class="homes-address mb-3">

                                                                <i class="fa fa-map-marker"></i><span>
                                                                    {{ $project->city->title }} {{ '/' }}
                                                                    {{ $project->county->ilce_title }}
                                                                </span>

                                                            </p>

                                                        </span>
                                                        <!-- homes List -->
                                                        <ul class="homes-list clearfix pb-0"
                                                            style="display: flex;justify-content:space-between">

                                                            @if (isset($project->listItemValues) &&
                                                                    isset($project->listItemValues->column1_name) &&
                                                                    $project->listItemValues->column1_name)
                                                                <li class="sude-the-icons"
                                                                    style="width:auto !important">
                                                                    <i class="fa fa-circle circleIcon mr-1"></i>
                                                                    <span>
                                                                        {{ getHouse($project, $project->listItemValues->column1_name . '[]', $i + 1)->value }}
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
                                                                <li class="sude-the-icons"
                                                                    style="width:auto !important">
                                                                    <i class="fa fa-circle circleIcon mr-1"
                                                                        aria-hidden="true"></i>
                                                                    <span>
                                                                        {{ getHouse($project, $project->listItemValues->column2_name . '[]', $i + 1)->value }}
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
                                                                <li class="sude-the-icons"
                                                                    style="width:auto !important">
                                                                    <i class="fa fa-circle circleIcon mr-1"
                                                                        aria-hidden="true"></i>
                                                                    <span>
                                                                        {{ getHouse($project, $project->listItemValues->column3_name . '[]', $i + 1)->value }}
                                                                        @if (isset($project->listItemValues) &&
                                                                                isset($project->listItemValues->column3_additional) &&
                                                                                $project->listItemValues->column3_additional)
                                                                            {{ $project->listItemValues->column3_additional }}
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                        <ul class="homes-list clearfix pb-0"
                                                            style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                            <li
                                                                style="font-size: 16px; font-weight: 700;width:100%;white-space:nowrap">
                                                                @if ($discount_amount)
                                                                    <svg viewBox="0 0 24 24" width="24"
                                                                        height="24" stroke="currentColor"
                                                                        stroke-width="2" fill="none"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="css-i6dzq1">
                                                                        <polyline points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                        </polyline>
                                                                        <polyline points="17 18 23 18 23 12">
                                                                        </polyline>
                                                                    </svg>
                                                                @endif
                                                                @if (getHouse($project, 'off_sale[]', $i + 1)->value == "[]")
                                                                    @if ($sold)
                                                                        @if ($sold[0]->status != '1' && $sold[0]->status != '0')
                                                                            {{ number_format(getHouse($project, 'price[]', $i + 1)->value - $discount_amount, 0, ',', '.') }}
                                                                            ₺
                                                                        @endif
                                                                    @else
                                                                        {{ number_format(getHouse($project, 'price[]', $i + 1)->value - $discount_amount, 0, ',', '.') }}
                                                                        ₺
                                                                    @endif
                                                                @endif

                                                            </li>
                                                            <li
                                                                style="display: flex; justify-content: right;width:100%">
                                                                {{ date('j', strtotime($project->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($project->created_at))) }}
                                                            </li>
                                                        </ul>
                                                        @if (getHouse($project, 'off_sale[]', $i + 1)->value != "[]")
                                                            <button class="btn second-btn CartBtn" disabled
                                                                style="background: red !important;width:100%;color:White">

                                                                <span class="text">Satıldı</span>
                                                            </button>
                                                        @else
                                                            @if ($sold && $sold[0]->status != '2')
                                                                <button class="btn second-btn CartBtn" disabled
                                                                    @if ($sold[0]->status == '0') style="background: orange !important;width:100%;color:White" @else  style="background: red !important;width:100%;color:White" @endif>
                                                                    @if ($sold[0]->status == '0')
                                                                        <span class="text">Onay Bekleniyor</span>
                                                                    @else
                                                                        <span class="text">Satıldı</span>
                                                                    @endif
                                                                </button>
                                                            @else
                                                                <button class="CartBtn" data-type='project'
                                                                    data-project='{{ $project->id }}'
                                                                    data-id='{{ getHouse($project, 'price[]', $i + 1)->room_order }}'>
                                                                    <span class="IconContainer">
                                                                        <img src="{{ asset('sc.png') }}"
                                                                            alt="">
                                                                    </span>
                                                                    <span class="text">Sepete Ekle</span>
                                                                </button>
                                                            @endif
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endfor
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <p>Henüz İlan Yayınlanmadı</p>
            @endif
        </div>


    </div>
</section>


