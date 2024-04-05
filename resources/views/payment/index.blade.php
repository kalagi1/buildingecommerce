@extends('client.layouts.master')



@section('content')

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    {{-- @php
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];
        $shareUrl = $protocol . '://' . $host . $uri;
    @endphp --}}
    <section class="payment-method notfound">
        <div class="container  pt-5">

            @if (!$cart || empty($cart['item']))
                <div class="tr-single-box">
                    <div class="tr-single-header">
                        <div class="tr-single-body">

                            <tr>
                                <td colspan="4">Sepette Ürün Bulunmuyor</td>
                            </tr>

                        </div>
                    </div>
                </div>
            @else
                @if ($cart['type'] == 'project')
                    <div class="wrap-house wg-dream flex bg-white">
                        <div class="box-0">
                            <a
                                href="{{ $cart['type'] == 'housing'
                                    ? route('housing.show', ['housingSlug' => $cart['item']['slug'], 'housingID' => $cart['item']['id'] + 2000000])
                                    : route('project.housings.detail', [
                                        'projectSlug' =>
                                            optional(App\Models\Project::find($cart['item']['id']))->slug .
                                            '-' .
                                            optional(App\Models\Project::find($cart['item']['id']))->step2_slug .
                                            '-' .
                                            optional(App\Models\Project::find($cart['item']['id']))->housingtype->slug,
                                        'projectID' => optional(App\Models\Project::find($cart['item']['id']))->id + 1000000,
                                        'housingOrder' => $cart['item']['housing'],
                                    ]) }}">
                                <img alt="my-properties-3" src="{{ $cart['item']['image'] }}" class="img-fluid">
                            </a>
                        </div>
                        <div class="box-1">
                            <div class="">
                                {{ $cart['type'] == 'housing' ? 'İlan No: ' . $cart['item']['id'] + 2000000 : 'İlan No: ' . $cart['item']['housing'] + optional(App\Models\Project::find($cart['item']['id']))->id + 1000000 }}</div>
                            <div class="title-heading fs-30 fw-7 lh-45">{{ $project->project_title }}</div>
                            <div class="inner flex">
                                <div class="sales fs-12 fw-7 font-2 text-color-1">
                                    @if ($project->step2_slug)
                                        @if ($project->step2_slug == 'kiralik')
                                            Kiralık {{ $project->housingType->title }}
                                        @elseif ($project->step2_slug == 'satilik')
                                            Satılık {{ $project->housingType->title }}
                                        @else
                                            Günlük Kiralık {{ $project->housingType->title }}
                                        @endif
                                    @endif
                                </div>
                                {{-- <div class="text-address">
                                    <p></p>
                                </div> --}}
                                <div class="icon-inner flex">
                                    <div class="years-icon flex align-center">
                                        <i class="fa fa-map-marker"></i>
                                        <p class="text-color-2">
                                            {!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}
                                            @if ($project->neighbourhood)
                                                {!! ' / ' . optional($project->neighbourhood)->mahalle_title !!}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="view-icon flex align-center">
                                        {{-- <i class="far fa-eye"></i> --}}
                                        <p class="text-color-2">{{ $project->create_company }}</p>
                                    </div>

                                </div>
                            </div>

                            <div class="icon-box flex">
                                <div class="icons icon-1 flex">
                                    <i class="fa fa-circle circleIcon mr-1 fa-lg-2" aria-hidden="true"></i>
                                    <span class="fw-6">
                                        {{ $cart['item']['housing'] }} No'lu
                                    </span>
                                </div>

                                @foreach (['column1', 'column2', 'column3'] as $column)
                                    @php
                                        $column_name = $project->listItemValues->{$column . '_name'} ?? '';
                                        $column_additional = $project->listItemValues->{$column . '_additional'} ?? '';
                                        $column_name_exists =
                                            $column_name &&
                                            isset($projectHousingsList[$cart['item']['housing']][$column_name . '[]']);
                                    @endphp
                                    @if ($column_name_exists)
                                        <div class="icons icon-1 flex">
                                            <i class="fa fa-circle circleIcon mr-1 fa-lg-2" aria-hidden="true"></i>
                                            <span class="fw-6">
                                                {{ $projectHousingsList[$cart['item']['housing']][$column_name . '[]'] }}
                                                @if ($column_additional)
                                                    {{ $column_additional }}
                                                @endif
                                            </span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                        </div>
                        <div class="box-2 text-end ">

                            <div class="icon-boxs flex">
                                {{-- <a href="#">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.75 6.1875C15.75 4.32375 14.1758 2.8125 12.234 2.8125C10.7828 2.8125 9.53625 3.657 9 4.86225C8.46375 3.657 7.21725 2.8125 5.76525 2.8125C3.825 2.8125 2.25 4.32375 2.25 6.1875C2.25 11.6025 9 15.1875 9 15.1875C9 15.1875 15.75 11.6025 15.75 6.1875Z" stroke="#8E8E93" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </a> --}}
                                {{-- <a href="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="18" cy="5" r="3" />
                                        <circle cx="6" cy="12" r="3" />
                                        <circle cx="18" cy="19" r="3" />
                                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49" />
                                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49" />
                                    </svg>
                                </a> --}}
                                <a
                                    href="{{ $cart['type'] == 'housing'
                                        ? route('housing.show', ['housingSlug' => $cart['item']['slug'], 'housingID' => $cart['item']['id'] + 2000000])
                                        : route('project.housings.detail', [
                                            'projectSlug' =>
                                                optional(App\Models\Project::find($cart['item']['id']))->slug .
                                                '-' .
                                                optional(App\Models\Project::find($cart['item']['id']))->step2_slug .
                                                '-' .
                                                optional(App\Models\Project::find($cart['item']['id']))->housingtype->slug,
                                            'projectID' => optional(App\Models\Project::find($cart['item']['id']))->id + 1000000,
                                            'housingOrder' => $cart['item']['housing'],
                                        ]) }}">
                                    İLANI GÖR
                                </a>

                                {{-- <a href="#">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.04 10.3718C4.86 10.3943 4.68 10.4183 4.5 10.4438M5.04 10.3718C7.66969 10.0418 10.3303 10.0418 12.96 10.3718M5.04 10.3718L4.755 13.5M12.96 10.3718C13.14 10.3943 13.32 10.4183 13.5 10.4438M12.96 10.3718L13.245 13.5L13.4167 15.3923C13.4274 15.509 13.4136 15.6267 13.3762 15.7378C13.3388 15.8489 13.2787 15.951 13.1996 16.0376C13.1206 16.1242 13.0244 16.1933 12.9172 16.2407C12.8099 16.288 12.694 16.3125 12.5767 16.3125H5.42325C4.92675 16.3125 4.53825 15.8865 4.58325 15.3923L4.755 13.5M4.755 13.5H3.9375C3.48995 13.5 3.06072 13.3222 2.74426 13.0057C2.42779 12.6893 2.25 12.2601 2.25 11.8125V7.092C2.25 6.28125 2.826 5.58075 3.62775 5.46075C4.10471 5.3894 4.58306 5.32764 5.0625 5.2755M13.2435 13.5H14.0618C14.2834 13.5001 14.5029 13.4565 14.7078 13.3718C14.9126 13.287 15.0987 13.1627 15.2555 13.006C15.4123 12.8493 15.5366 12.6632 15.6215 12.4585C15.7063 12.2537 15.75 12.0342 15.75 11.8125V7.092C15.75 6.28125 15.174 5.58075 14.3723 5.46075C13.8953 5.38941 13.4169 5.32764 12.9375 5.2755M12.9375 5.2755C10.3202 4.99073 7.67978 4.99073 5.0625 5.2755M12.9375 5.2755V2.53125C12.9375 2.0655 12.5595 1.6875 12.0938 1.6875H5.90625C5.4405 1.6875 5.0625 2.0655 5.0625 2.53125V5.2755M13.5 7.875H13.506V7.881H13.5V7.875ZM11.25 7.875H11.256V7.881H11.25V7.875Z" stroke="#8E8E93" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </a> --}}
                            </div>
                            <div class="moneys fs-30 fw-7 lh-45 text-color-3">
                                {{ number_format($cart['item']['amount'], 0, ',', '.') }}
                                TL</div>
                            <div class="text-sq fs-12 lh-16">
                                @if (isset($cart['item']['isShare']) && !empty($cart['item']['isShare']))
                                 
                                    <span style="color:#EA2B2E" class="mt-3">{{ $cart['item']['qt'] }} adet hisse satın alıyorsunuz!</span>
                                @endif
                            </div>
                            
                            <div class="show-mobile">
                                <a
                                    href="{{ $cart['type'] == 'housing'
                                        ? route('housing.show', ['housingSlug' => $cart['item']['slug'], 'housingID' => $cart['item']['id'] + 2000000])
                                        : route('project.housings.detail', [
                                            'projectSlug' =>
                                                optional(App\Models\Project::find($cart['item']['id']))->slug .
                                                '-' .
                                                optional(App\Models\Project::find($cart['item']['id']))->step2_slug .
                                                '-' .
                                                optional(App\Models\Project::find($cart['item']['id']))->housingtype->slug,
                                            'projectID' => optional(App\Models\Project::find($cart['item']['id']))->id + 1000000,
                                            'housingOrder' => $cart['item']['housing'],
                                        ]) }}">
                                    <div class="mobile">İlanı Gör</div>
                                </a>

                            </div>
                        </div>
                    </div>
                @else
                    <div class="wrap-house wg-dream flex bg-white">
                        <div class="box-0">
                            <a
                                href="{{ $cart['type'] == 'housing'
                                    ? route('housing.show', ['housingSlug' => $cart['item']['slug'], 'housingID' => $cart['item']['id'] + 2000000])
                                    : route('project.housings.detail', [
                                        'projectSlug' =>
                                            optional(App\Models\Project::find($cart['item']['id']))->slug .
                                            '-' .
                                            optional(App\Models\Project::find($cart['item']['id']))->step2_slug .
                                            '-' .
                                            optional(App\Models\Project::find($cart['item']['id']))->housingtype->slug,
                                        'projectID' => optional(App\Models\Project::find($cart['item']['id']))->id + 1000000,
                                        'housingOrder' => $cart['item']['housing'],
                                    ]) }}">
                                <img alt="my-properties-3" src="{{ $cart['item']['image'] }}" class="img-fluid">
                            </a>
                        </div>
                        <div class="box-1">
                            <div> {{ $cart['type'] == 'housing' ? 'İlan No: ' . $cart['item']['id'] + 2000000 : 'İlan No: ' . $cart['item']['housing'] + optional(App\Models\Project::find($cart['item']['id']))->id + 1000000 }}</div>
                            <div class="title-heading fs-30 fw-7 lh-45">{{ $housing->housing_title }}</div>
                            <div class="inner flex">
                                <div class="sales fs-12 fw-7 font-2 text-color-1">
                                    @if ($housing->step2_slug == 'kiralik')
                                        Kiralık {{ $housing->housing_type_title }}
                                    @elseif ($housing->step2_slug == 'gunluk-kiralik')
                                        Günlük Kiralık {{ $housing->housing_type_title }}
                                    @else
                                        Satılık {{ $housing->housing_type_title }}
                                    @endif
                                </div>
                                {{-- <div class="text-address">
                                    
                                </div> --}}
                                <div class="years-icon flex align-center">
                                    <i class="fa fa-map-marker"></i>
                                    <p class="text-color-2">
                                        {{ $housing->city_title }}
                                        {{ '/' }}
                                        {{ $housing->county_title }}
                                    </p>
                                </div>
                                <div class="icon-inner flex">
                                    <div class="view-icon flex align-center">
                                        {{-- <i class="far fa-eye"></i> --}}
                                        <p class="text-color-2">{{ $housing->create_company }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="icon-box flex">
                                <ul class="row column">

                                    @if ($housing->column1_name)
                                        <div class="icon-box flex">
                                            <div class="icons icon-1 flex">
                                                <i class="fa fa-circle circleIcon mr-1 fa-lg-2" aria-hidden="true"></i>
                                                <span class="fw-6">
                                                    {{ json_decode($housing->housing_type_data)->{$housing->column1_name}[0] ?? null }}
                                                    @if ($housing->column1_additional)
                                                        {{ $housing->column1_additional }}
                                                    @endif
                                                </span>
                                            </div>
                                    @endif
                                    @if ($housing->column2_name)
                                        <div class="icon-box flex">
                                            <div class="icons icon-1 flex">
                                                <i class="fa fa-circle circleIcon mr-1 fa-lg-2" aria-hidden="true"></i>
                                                <span class="fw-6">
                                                    {{ json_decode($housing->housing_type_data)->{$housing->column2_name}[0] ?? null }}
                                                    @if ($housing->column2_additional)
                                                        {{ $housing->column2_additional }}
                                                    @endif
                                                </span>
                                            </div>
                                    @endif
                                    @if ($housing->column3_name)
                                        <div class="icon-box flex">
                                            <div class="icons icon-1 flex">
                                                <i class="fa fa-circle circleIcon mr-1 fa-lg-2" aria-hidden="true"></i>
                                                <span class="fw-6">
                                                    {{ json_decode($housing->housing_type_data)->{$housing->column3_name}[0] ?? null }}
                                                    @if ($housing->column3_additional)
                                                        {{ $housing->column3_additional }}
                                                    @endif
                                                </span>
                                            </div>
                                    @endif
                                    @if ($housing->column4_name)
                                        <div class="icon-box flex">
                                            <div class="icons icon-1 flex">
                                                <i class="fa fa-circle circleIcon mr-1 fa-lg-2" aria-hidden="true"></i>
                                                <span class="fw-6">
                                                    {{ json_decode($housing->housing_type_data)->{$housing->column4_name}[0] ?? null }}
                                                    @if ($housing->column4_additional)
                                                        {{ $housing->column4_additional }}
                                                    @endif
                                                </span>
                                            </div>
                                    @endif

                                </ul>
                            </div>
                        </div>
                        <div class="box-2 text-end">
                            <div class="icon-boxs flex">
                                {{-- <a href="#">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.75 6.1875C15.75 4.32375 14.1758 2.8125 12.234 2.8125C10.7828 2.8125 9.53625 3.657 9 4.86225C8.46375 3.657 7.21725 2.8125 5.76525 2.8125C3.825 2.8125 2.25 4.32375 2.25 6.1875C2.25 11.6025 9 15.1875 9 15.1875C9 15.1875 15.75 11.6025 15.75 6.1875Z" stroke="#8E8E93" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </a> --}}
                                {{-- <a href="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="18" cy="5" r="3" />
                                        <circle cx="6" cy="12" r="3" />
                                        <circle cx="18" cy="19" r="3" />
                                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49" />
                                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49" />
                                    </svg>
                                </a> --}}
                                <a
                                    href="{{ $cart['type'] == 'housing'
                                        ? route('housing.show', ['housingSlug' => $cart['item']['slug'], 'housingID' => $cart['item']['id'] + 2000000])
                                        : route('project.housings.detail', [
                                            'projectSlug' =>
                                                optional(App\Models\Project::find($cart['item']['id']))->slug .
                                                '-' .
                                                optional(App\Models\Project::find($cart['item']['id']))->step2_slug .
                                                '-' .
                                                optional(App\Models\Project::find($cart['item']['id']))->housingtype->slug,
                                            'projectID' => optional(App\Models\Project::find($cart['item']['id']))->id + 1000000,
                                            'housingOrder' => $cart['item']['housing'],
                                        ]) }}">
                                    İLANI GÖR
                                </a>

                                {{-- <a href="#">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.04 10.3718C4.86 10.3943 4.68 10.4183 4.5 10.4438M5.04 10.3718C7.66969 10.0418 10.3303 10.0418 12.96 10.3718M5.04 10.3718L4.755 13.5M12.96 10.3718C13.14 10.3943 13.32 10.4183 13.5 10.4438M12.96 10.3718L13.245 13.5L13.4167 15.3923C13.4274 15.509 13.4136 15.6267 13.3762 15.7378C13.3388 15.8489 13.2787 15.951 13.1996 16.0376C13.1206 16.1242 13.0244 16.1933 12.9172 16.2407C12.8099 16.288 12.694 16.3125 12.5767 16.3125H5.42325C4.92675 16.3125 4.53825 15.8865 4.58325 15.3923L4.755 13.5M4.755 13.5H3.9375C3.48995 13.5 3.06072 13.3222 2.74426 13.0057C2.42779 12.6893 2.25 12.2601 2.25 11.8125V7.092C2.25 6.28125 2.826 5.58075 3.62775 5.46075C4.10471 5.3894 4.58306 5.32764 5.0625 5.2755M13.2435 13.5H14.0618C14.2834 13.5001 14.5029 13.4565 14.7078 13.3718C14.9126 13.287 15.0987 13.1627 15.2555 13.006C15.4123 12.8493 15.5366 12.6632 15.6215 12.4585C15.7063 12.2537 15.75 12.0342 15.75 11.8125V7.092C15.75 6.28125 15.174 5.58075 14.3723 5.46075C13.8953 5.38941 13.4169 5.32764 12.9375 5.2755M12.9375 5.2755C10.3202 4.99073 7.67978 4.99073 5.0625 5.2755M12.9375 5.2755V2.53125C12.9375 2.0655 12.5595 1.6875 12.0938 1.6875H5.90625C5.4405 1.6875 5.0625 2.0655 5.0625 2.53125V5.2755M13.5 7.875H13.506V7.881H13.5V7.875ZM11.25 7.875H11.256V7.881H11.25V7.875Z" stroke="#8E8E93" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </a> --}}
                            </div>
                            <div class="moneys fs-30 fw-7 lh-45 text-color-3">
                                {{ number_format($cart['item']['amount'], 0, ',', '.') }}
                                TL</div>
                            {{-- <div class="text-sq fs-12 lh-16">1964 Sq Ft</div> --}}

                            <div class="show-mobile">
                                <a
                                    href="{{ $cart['type'] == 'housing'
                                        ? route('housing.show', ['housingSlug' => $cart['item']['slug'], 'housingID' => $cart['item']['id'] + 2000000])
                                        : route('project.housings.detail', [
                                            'projectSlug' =>
                                                optional(App\Models\Project::find($cart['item']['id']))->slug .
                                                '-' .
                                                optional(App\Models\Project::find($cart['item']['id']))->step2_slug .
                                                '-' .
                                                optional(App\Models\Project::find($cart['item']['id']))->housingtype->slug,
                                            'projectID' => optional(App\Models\Project::find($cart['item']['id']))->id + 1000000,
                                            'housingOrder' => $cart['item']['housing'],
                                        ]) }}">
                                    <div class="mobile">İlanı Gör</div>
                                </a>

                            </div>
                        </div>
                    </div>

                @endif
                <div class="row mr-4">
                    <div class="col-md-12">
                        <div class="">
                            <div class="row">
                                @if (!$cart || empty($cart['item']))
                                    <div class="tr-single-body">
                                        <ul>
                                            <li>Sepette Ürün Bulunmuyor</td>
                                        </ul>
                                    </div>
                                @else
                                    @php
                                        $housingDiscountAmount = 0;
                                        $projectDiscountAmount = 0;

                                        if ($cart['type'] == 'housing') {
                                            $housingOffer = App\Models\Offer::where('type', 'housing')
                                                ->where('housing_id', $cart['item']['id'])
                                                ->where('start_date', '<=', now())
                                                ->where('end_date', '>=', now())
                                                ->first();

                                            $housingDiscountAmount = $housingOffer ? $housingOffer->discount_amount : 0;
                                        } else {
                                            $projectOffer = App\Models\Offer::where('type', 'project')
                                                ->where('project_id', $cart['item']['id'])
                                                ->where(
                                                    'project_housings',
                                                    'LIKE',
                                                    '%' . $cart['item']['housing'] . '%',
                                                )
                                                ->where('start_date', '<=', now())
                                                ->where('end_date', '>=', now())
                                                ->first();

                                            $projectDiscountAmount = $projectOffer ? $projectOffer->discount_amount : 0;
                                        }
                                    @endphp
                                @endif
                            </div>
                        </div>
                    </div>
                    @php
                    $itemPrice = $cart['item']['amount'];

                    if ($cart['hasCounter']) {
                        if ($cart['type'] == 'housing') {
                            $housing = App\Models\Housing::find($cart['item']['id']);
                            $housingData = json_decode($housing->housing_type_data);
                            $discountRate = $housingData->discount_rate[0] ?? 0;

                            $housingAmount = $itemPrice - $housingDiscountAmount;
                            $discountedPrice = $housingAmount - ($housingAmount * $discountRate) / 100;
                        } else {
                            $project = App\Models\Project::find($cart['item']['id']);
                            $roomOrder = $cart['item']['housing'];
                            $projectHousing = App\Models\ProjectHousing::where('project_id', $project->id)
                                ->where('room_order', $roomOrder)
                                ->get()
                                ->keyBy('name');

                            $discountRate = $projectHousing['discount_rate[]']->value ?? 0;
                            $projectAmount = $itemPrice - $projectDiscountAmount;
                            $discountedPrice = $projectAmount - ($projectAmount * $discountRate) / 100;
                        }
                    } else {
                        $discountedPrice = $itemPrice;
                        $discountRate = 0;
                    }
                    $selectedPaymentOption = request('paymentOption');
                    $itemPrice =
                        $selectedPaymentOption === 'taksitli' && isset($cart['item']['installmentPrice'])
                            ? $cart['item']['installmentPrice']
                            : $discountedPrice;

                    $displayedPrice = number_format($itemPrice, 0, ',', '.');
                    $share_sale = $cart['item']['isShare'] ?? null;
                    $number_of_share = $cart['item']['numbershare'] ?? null;
                @endphp
                    <div class="col-md-12 col-lg-12 col-xl-7">
                        <div class="tr-single-box">
                            <div class="tr-single-body">
                                <div class="tr-single-header">
                                    <h4><i class="far fa-address-card pr-2"></i>Satın Alan Kişinin Bilgileri</h4>
                                </div>

                                <form method="POST" id="paymentForm">
                                    @csrf
                                    <input type="hidden" name="key" id="orderKey">
                                    <input type="hidden" name="banka_id" id="bankaID">
                                    <input type="hidden" name="have_discount" class="have_discount">
                                    <input type="hidden" name="discount" class="discount">
                                    <input type="hidden" name="is_swap" class="is_swap"
                                        value="{{ $cart['item']['payment-plan'] ?? null }}">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="fullName">Ad Soyad:</label>
                                            <input type="text" class="form-control" id="fullName" name="fullName"
                                                required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="email">E-posta:</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="tc">TC: </label>
                                            <input type="number" class="form-control" id="tc" name="tc"
                                                required oninput="validateTCLength(this)">
                                        </div>
                                        <script>
                                            function validateTCLength(input) {
                                                var maxLength = 11;
                                                if (input.value.length > maxLength) {
                                                    input.value = input.value.slice(0, maxLength);
                                                    toastr.warning("TC kimlik numarası 11 karakterden fazla olamaz!");
                                                }
                                            }
                                        </script>
                                        <div class="col-sm-6">
                                            <label for="phone">Telefon:</label>
                                            <input type="number" class="form-control" id="phone" name="phone"
                                                required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="address">Adres:</label>
                                            <textarea class="form-control" id="address" name="address" rows="5" required></textarea>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="notes">Notlar:</label>
                                            <textarea class="form-control" id="notes" name="notes" rows="5"></textarea>
                                        </div>

                                        <div class="col-sm-6">
                                            <label for="notes">Referans Kodu (Opsiyonel):</label>
                                            <input class="form-control" id="reference_code" name="reference_code"
                                                rows="5">
                                        </div>

                                        <div class="col-sm-6">
                                            @if (isset($cart['item']['neighborProjects']) && count($cart['item']['neighborProjects']) > 0 && empty($share_sale))
                                                <label for="neighborProjects">Komşunuzun referansıyla mı satın
                                                    alıyorsunuz?</label>
                                                <select class="form-control" id="is_reference" name="is_reference">
                                                    <option value="" selected>Komşu Seçiniz</option>
                                                    @foreach ($cart['item']['neighborProjects'] as $neighborProject)
                                                        <option value="{{ $neighborProject->owner["id"] }}">
                                                            {{ $neighborProject->owner["name"] }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>

                                  
                                            @if (isset($cart) && isset($cart['type']))
                                                @if ($cart['type'] == 'project' && isset($share_sale) && $share_sale == '[]' || $cart['type'] == 'project' && empty($share_sale))
                                                        <div class="col-sm-12 pt-5">
                                                            <div class="d-flex align-items-center mb-3">
                                                                <input id="is_show_user" type="checkbox" value="off" name="is_show_user">
                                                                <i class="fa fa-info-circle ml-2"
                                                                    title="Komşumu Gör özelliğini aktif ettiğinizde, diğer komşularınızın sizin iletişim bilgilerinize ulaşmasına izin vermiş olursunuz."
                                                                    style="font-size: 18px; color: black;"></i>
                                                                <label for="is_show_user" class="m-0 ml-1 text-black">
                                                                    Komşumu Gör özelliği ile iletişim bilgilerimi paylaşmayı
                                                                    kabul
                                                                    ediyorum.
                                                                </label>
                                                            </div>
                                                        </div>
                                                @endif
                                            @endif



                                      

                                        <div class="col-sm-12 pt-2">
                                            <div class="d-flex align-items-center mb-3">
                                                <input id="checkPay" type="checkbox" name="checkPay">

                                                <label for="checkPay" class="m-0 ml-1 text-black">
                                                    <a href="/sayfa/mesafeli-kapora-emanet-sozlesmesi" target="_blank">
                                                        Mesafeli kapora emanet sözleşmesini
                                                    </a>
                                                     okudum ve kabul ediyorum
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
          

                    <div class="col-md-12 col-lg-12 col-xl-5 mb-5">
                        <div class="row">

                            <div class="col-md-12" style="background: white !important;">
                                <div class="tr-single-body">
                                    <div class="tr-single-header pb-2">
                                        <h4><i class="fa fa-star-o"></i>Sepet Özeti</h4>
                                    </div>
                                    <div class="booking-price-detail side-list no-border mb-3">
                                        @if (!$cart || empty($cart['item']))
                                            <ul>
                                                <li>Toplam Fiyat<strong class="pull-right">00.00
                                                        TL</strong></li>
                                            </ul>
                                        @else
                                            <ul>
                                                <li>İlan Fiyatı<strong class="pull-right">
                                                        {{ number_format($cart['item']['amount'], 0, ',', '.') }}
                                                        TL</strong></li>

                                                @if ($housingDiscountAmount != 0 || $projectDiscountAmount != 0)
                                                    <li style="color:#EA2B2E">Mağaza İndirimi :<strong class="pull-right">
                                                            <svg viewBox="0 0 24 24" width="18" height="18"
                                                                stroke="currentColor" stroke-width="2" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="css-i6dzq1">
                                                                <polyline points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                </polyline>
                                                                <polyline points="17 18 23 18 23 12"></polyline>
                                                            </svg>
                                                            <span
                                                                style="margin-left: 2px">{{ number_format($housingDiscountAmount ? $housingDiscountAmount : $projectDiscountAmount, 0, ',', '.') }}
                                                                ₺ </span></strong></li>
                                                @endif

                                                @if (isset($discountRate) && $discountRate != '0')
                                                    <li style="color:#EA2B2E">Emlak Kulüp İndirim Oranı :<strong
                                                            class="pull-right">
                                                            <svg viewBox="0 0 24 24" width="18" height="18"
                                                                stroke="currentColor" stroke-width="2" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="css-i6dzq1">
                                                                <polyline points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                </polyline>
                                                                <polyline points="17 18 23 18 23 12"></polyline>
                                                            </svg>
                                                            <span style="margin-left: 2px">{{ $discountRate }}
                                                                % </span></strong></li>
                                                @endif
                                                <li>Toplam Fiyat<strong class="pull-right">
                                                        {{ number_format($discountedPrice, 0, ',', '.') }}

                                                        TL</strong></li>



                                                @if ($saleType == 'kiralik')
                                                    <li>Bir Kira Kapora :<strong
                                                            class="pull-right ">{{ number_format($discountedPrice, 0, ',', '.') }}
                                                            TL</strong></li>
                                                @else
                                                    <li>Toplam Fiyatın %2 Kaporası :<strong
                                                            class="pull-right">{{ number_format($discountedPrice * 0.02, 0, ',', '.') }}
                                                            TL</strong></li>
                                                @endif

                                            </ul>
                                        @endif
                                    </div>

                                    @if (!$cart || empty($cart['item']))
                                        <button type="button" class="btn btn-primary btn-lg btn-block"
                                            style="font-size: 11px;margin: 0 auto;"
                                            onclick="window.location.href='{{ route('index') }}'">
                                            Alışverişe Devam Et
                                        </button>
                                    @endif
                                    {{-- @if ($saleType == 'kiralik')
                                    <div>
                                        <div class="text-success">Ödenecek Tutar :<strong
                                                class="button-price-inner pull-right text-success ">{{ number_format($discountedPrice, 0, ',', '.') }}
                                                TL</strong></div>

                                    </div>
                                @else
                                    <div>
                                        <div class="text-success">Ödenecek Tutar :<strong
                                                class="button-price-inner pull-right text-success">{{ number_format($discountedPrice * 0.02, 0, ',', '.') }}
                                                TL</strong></div>

                                    </div>
                                @endif --}}

                                    @if ($saleType == 'kiralik')
                                        <div id="rental-amount">
                                            <div class="text-success">Ödenecek Tutar : <strong
                                                    class="button-price-inner pull-right text-success">{{ number_format($discountedPrice, 0, ',', '.') }}
                                                    TL</strong></div>
                                        </div>
                                    @else
                                        <div id="other-amount">
                                            <div class="text-success">Ödenecek Tutar : <strong
                                                    class="button-price-inner pull-right text-success">{{ number_format($discountedPrice * 0.02, 0, ',', '.') }}
                                                    TL</strong></div>
                                        </div>
                                    @endif

                                    {{-- <div class="col-md-12 col-lg-12 col-xl-6">  --}}
                                    <div class="col-md-12" style="background: white !important;">
                                        <div class="mt-5">
                                            <div class="tr-single-header">

                                                <div class="row">

                                                    <div class="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="payment_option" id="option2" value="option2"
                                                                checked>
                                                            <label class="form-check-label pt-1 ml-2 mb-2 offset-md-1"
                                                                for="option2">
                                                                EFT / Havale ile Ödeme
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="payment_option" id="option1" value="option1">
                                                            <label class="form-check-label pt-1 ml-2  mb-2 offset-md-1"
                                                                for="option1">
                                                                Kredi Kartı ile Ödeme
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="payment1" class="payment">

                                        {{-- <div class="payment-card"> --}}
                                        <header class="payment-card-header cursor-pointer collapsed"
                                            data-toggle="collapse" data-target="#debit-credit" aria-expanded="true">
                                            <div class="payment-card-title flexbox">
                                                <h4>Kredi / Banka Kartı</h4>
                                            </div>
                                            <div class="pull-right">
                                                <img src="images/credit.png" class="img-responsive" alt="">
                                            </div>
                                        </header>
                                        <div class="collapse show" id="debit-credit" role="tablist"
                                            aria-expanded="false" style="">
                                            <div class="payment-card-body">
                                                <form method="POST" id="3dPayForm" action="{{ route('3d.pay') }}">
                                                    @csrf
                                                    <input type="hidden" name="cart"
                                                        value="{{ json_encode($cart) }}">
                                                    <input type="hidden" name="payable_amount" id="payableAmountInput">
                                                    <input type="hidden" id="fullName2" name="fullName">
                                                    <input type="hidden" id="email2" name="email">
                                                    <input type="hidden" id="tc2" name="tc">
                                                    <input type="hidden" id="phone2" name="phone">
                                                    <input type="hidden" id="address2" name="address">
                                                    <input type="hidden" id="notes2" name="notes">
                                                    <input type="hidden" id="reference_code2" name="reference_code">
                                                    <input type="hidden" id="orderKey2" name="key">
                                                    <input type="hidden" id="is_reference2" name="is_reference">
                                                    <input type="hidden" id="have_discount2" name="have_discount "
                                                        class="have_discount">
                                                    <input type="hidden" id="discount2" name="discount"
                                                        class="discount">
                                                    <input type="hidden" id="is_swap2" name="is_swap" class="is_swap"
                                                        value="{{ $cart['item']['payment-plan'] ?? null }}">
                                                    <div class="row mrg-bot-20">
                                                        <div class="col-sm-6">
                                                            <label for="creditcard">Kart Numarası</label>
                                                            <input type="text" class="form-control" id="creditcard"
                                                                name="creditcard" oninput="formatCreditCard(this)">
                                                            <script>
                                                                function formatCreditCard(input) {
                                                                    // Boşlukları, tireleri ve boşlukları kaldırarak sadece rakamları al
                                                                    var creditCardNumber = input.value.replace(/\D/g, '');

                                                                    // Kredi kartı numarasını 16 karaktere sınırlandır
                                                                    var maxLength = 16;
                                                                    creditCardNumber = creditCardNumber.slice(0, maxLength);

                                                                    // Rakamları 4 haneli bloklara ayır
                                                                    //var formattedCreditCardNumber = creditCardNumber.replace(/(\d{4})(?=\d)/g, '$1 ');

                                                                    // Input alanına formatlı kredi kartı numarasını yerleştir
                                                                    input.value = creditCardNumber;
                                                                }
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <div class="row mrg-bot-20">
                                                        <div class="col-sm-4 col-md-4">
                                                            <label>Son Kullanma Ayı</label>
                                                            {{-- <input type="number" class="form-control" id="month"
                                                            name="month" placeholder="09"> --}}
                                                            <select class="form-control" id="month" name="month">
                                                                <option value="01">Ocak</option>
                                                                <option value="02">Şubat</option>
                                                                <option value="03">Mart</option>
                                                                <option value="04">Nisan</option>
                                                                <option value="05">Mayıs</option>
                                                                <option value="06">Haziran</option>
                                                                <option value="07">Temmuz</option>
                                                                <option value="08">Ağustos</option>
                                                                <option value="09">Eylül</option>
                                                                <option value="10">Ekim</option>
                                                                <option value="11">Kasım</option>
                                                                <option value="12">Aralık</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-4 col-md-4">
                                                            <label>Son Kullanma Yılı</label>
                                                            <select class="form-control" id="year" name="year">
                                                                <?php
                                                                // Başlangıç ve bitiş yılını belirle
                                                                $startYear = date('Y'); // Şu anki yıl
                                                                $endYear = $startYear + 10; // Şu anki yıldan 10 yıl sonrası
                                                                
                                                                // Yılları doldur
                                                                for ($i = $startYear; $i <= $endYear; $i++) {
                                                                    echo "<option value='$i'>$i</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                            {{-- <input type="number" class="form-control" id="year"
                                                            name="year" placeholder="2022"> --}}
                                                        </div>
                                                        {{-- <div class="col-sm-4 col-md-4">
                                                        <label>CCV Kodu</label>
                                                        <input type="text" class="form-control" placeholder="258">
                                                    </div> --}}
                                                    </div>
                                                    {{-- <div class="row mrg-bot-20">
                                                    <div class="col-sm-7">
                                                        <span class="custom-checkbox d-block font-12 mb-2">
                                                            <input type="checkbox" id="promo" name="promo">
                                                            <label for="promo"></label>
                                                            Bir promosyon kodunuz var mı?
                                                        </span>
                                                        <input type="text" class="form-control">
                                                    </div> --}}
                                                    {{-- <div class="col-sm-5 padd-top-10 text-right">
                                                        <label>Toplam Sipariş</label>
                                                        <h2 class="mrg-0"><span class="theme-cl">₺</span>987</h2>
                                                    </div> --}}
                                                    {{-- <div class="col-sm-12 bt-1 padd-top-15 pt-3">
                                                        <span class="custom-checkbox d-block font-12 mb-3">
                                                            <input type="checkbox" id="privacy1">
                                                            <label for="privacy1"></label>
                                                            Sipariş vererek <a href="#" class="theme-cl">Gizlilik Politikamızı</a> kabul etmiş olursunuz.
                                                        </span>
                                                    </div> --}}
                                            </div>

                                            <button type="submit" class="btn btn-success 3dPaySuccess">Ödemeyi
                                                Tamamla
                                                <svg viewBox="0 0 576 512" class="svgIcon">
                                                    <path
                                                        d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24H360c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z">
                                                    </path>
                                                </svg></button>
                                            </form>
                                        </div>
                                        {{-- </div> --}}
                                    </div>

                                    <div id="payment2" class="payment" style="display: none;">
                                        {{-- EFT Havale --}}
                                        {{-- <div class="payment-card mb-0"> --}}
                                        <header class="payment-card-header cursor-pointer collapsed"
                                            data-toggle="collapse" data-target="#paypal" aria-expanded="true">
                                            <div class="payment-card-title flexbox">
                                                <h4>EFT / HAVALE</h4>
                                            </div>
                                        </header>
                                        <div class="collapse show" id="paypal" role="tablist" aria-expanded="false"
                                            style="">
                                            {{-- <div class="payment-card-body"> --}}
                                            <div class="invoice-total mt-3">
                                                <span class="mt-3">EFT/Havale yapacağınız bankayı seçiniz</span>
                                                <div class="container row mb-3 mt-3">
                                                    <span>1. <strong style="color:#EA2B2E;font-weight:bold !important"
                                                            id="uniqueCodeRetry"></strong> kodunu EFT/Havale açıklama
                                                        alanına yazdığınızdan emin olun.</span>

                                                    {{-- <div class="row"> --}}
                                                    @if ($bankAccounts && count($bankAccounts) > 0)
                                                        @foreach ($bankAccounts as $bankAccount)
                                                            <a class=" copy-iban-button"
                                                                onclick="copyIban('{{ $bankAccount->iban }}')">
                                                                <li class="fa fa-copy"></li>
                                                            </a>
                                                            <div class="col-sm-5 col-md-5 bank-account"
                                                                data-id="{{ $bankAccount->id }}"
                                                                data-iban="{{ $bankAccount->iban }}"
                                                                data-title="{{ $bankAccount->receipent_full_name }}">
                                                                <img src="{{ URL::to('/') }}/{{ $bankAccount->image }}"
                                                                    alt=""
                                                                    style="width: 100%; height: 100px; object-fit: contain; cursor: pointer">

                                                            </div>
                                                        @endforeach
                                                    @endif

                                                    {{-- </div> --}}

                                                </div>
                                                <div id="ibanInfo" style="font-size: 12px !important"></div>
                                                <span>Ödeme işlemini tamamlamak için, lütfen bu
                                                    <span style="color:#EA2B2E;font-weight:bold" id="uniqueCode"></span>
                                                    kodu
                                                    kullanarak ödemenizi
                                                    yapın. IBAN açıklama
                                                    alanına
                                                    bu kodu eklemeyi unutmayın. Ardından "Ödemeyi Tamamla" düğmesine
                                                    tıklayarak
                                                    işlemi
                                                    bitirin.</span>
                                            </div>
                                            <div class="d-flex">
                                                {{-- @if (Auth::check()) disabled @endif --}}
                                                <button type="button" class="btn btn-m btn-success mt-5 paySuccess"
                                                    id="completePaymentButton" style="float:right">Ödemeyi
                                                    Tamamla
                                                    <svg viewBox="0 0 576 512" class="svgIcon">
                                                        <path
                                                            d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24H360c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                            {{-- </div> --}}
                                        </div>
                                        {{-- </div> --}}
                                    </div>


                                    <!-- Debit card option -->




                                </div>
                                {{-- </div> --}}
                            </div>


                        </div>
                    </div>

                </div>

        </div>

        @endif
    </section>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZwT" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&callback=initMap"></script>
    <script>
        function copyIban(iban) {
            // Yapıştırılacak metni oluştur
            var textArea = document.createElement("textarea");
            textArea.value = iban;

            // Text area'yı sayfaya ekleyerek içeriğini seç ve kopyala
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand("copy");

            // Artık gerekli olmadığı için text area'yı kaldır
            document.body.removeChild(textArea);

            // Kullanıcıya kopyalandı bildirimini göster
            toastr.success("IBAN kopyalandı: " + iban);
        }

        var payableAmount = 0;
        @if ($cart && !empty($cart['item']))
            @if ($saleType == 'kiralik')
                payableAmount = {{ $discountedPrice }};
            @else
                payableAmount = {{ $discountedPrice * 0.02 }};
            @endif
        @endif
        // Ödeme tutarını form alanına yerleştir
        document.getElementById('payableAmountInput').value = payableAmount;


        $(document).ready(function() {
            $('input[type="radio"]').change(function() {
                var paymentOption = $(this).val();
                $('.payment').hide();
                $('#payment' + paymentOption.substring(paymentOption.length - 1)).show();
            });
        });

        $(document).ready(function() {
            // Sayfa yüklendiğinde varsayılan olarak seçili olan ödeme yönteminin değerini al
            var paymentOption = $('input[name="payment_option"]:checked').val();

            // İlgili içeriği göstermek için değişiklik olayını tetikle
            $('input[name="payment_option"][value="' + paymentOption + '"]').change();
        });

        // Function to format numbers
        function number_format(number, decimals, dec_point, thousands_sep) {
            number = number.toFixed(decimals);
            var parts = number.toString().split(dec_point);
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_sep);
            return parts.join(dec_point);
        }

        $(document).ready(function() {

            var displayedPriceSpan = $('#itemPrice');
            var originalPrice = parseFloat(displayedPriceSpan.data('original-price'));
            var installmentPrice = parseFloat(displayedPriceSpan.data('installment-price'));
            $('.custom-option').on('click', function() {
                var selectedOption = $(this).data('value');
                updateCart(selectedOption);
            });

            function number_format(number, decimals, dec_point, thousands_sep) {
                number = number.toFixed(decimals);
                var parts = number.toString().split(dec_point);
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_sep);
                return parts.join(dec_point);
            }
        });

        //EFT/Havale
        $(document).ready(function() {
            var $cart = <?php echo json_encode($cart); ?>; // $cart değişkenini hazırla
            var uniqueCode = ($cart['type'] === 'housing') ? // uniqueCode'u oluştur
                $cart['item']['id'] + 2000000 :
                $cart['item']['housing'] + $cart['item']['id'] + 1000000;
            $('#uniqueCode, #uniqueCodeRetry').text(uniqueCode); // uniqueCode değerini span içine yerleştir
            $("#orderKey").val(uniqueCode); // uniqueCode değerini gizli input içine yerleştir
        });
        $(document).ready(function() {
            $('.paySuccess').on('click', function() {
                // $("#loadingOverlay").css("visibility", "visible"); // Visible olarak ayarla
                if ($('#fullName').val() === '' && $('#tc').val() === '' && $('#email').val() === '') {
                    toastr.warning('Ad Soyad, TC ve E-posta alanları zorunludur.')
                    return;
                }
                if ($('#fullName').val() === '') {
                    toastr.warning('Ad Soyad alanı zorunludur.')
                    return;
                }
                if ($('#tc').val() === '') {
                    toastr.warning('TC alanı zorunludur.')
                    return;
                }
                if ($('#email').val() === '') {
                    toastr.warning('E-posta alanı zorunludur.')
                    return;
                }

                if ($('#bankaID').val() === '') {
                    toastr.warning('EFT/Havale kart alanı zorunludur.')
                    return;
                }
                if (!$('#checkPay').prop('checked')) {
                    toastr.warning('Lütfen sözleşmeyi onaylayınız.');
                    $('#checkPay').css({
                        "border": "1px solid red"
                    });
                    return;
                }
                $.ajax({
                    url: "{{ route('pay.cart') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        key: $('#orderKey').val(),
                        banka_id: $('#bankaID').val(),
                        have_discount: $('.have_discount').val(),
                        discount: $('.discount').val(),
                        fullName: $('#fullName').val(),
                        email: $('#email').val(),
                        tc: $('#tc').val(),
                        phone: $('#phone').val(),
                        address: $('#address').val(),
                        notes: $('#notes').val(),
                        reference_code: $('#reference_code').val(),
                        is_reference: $("#is_reference").val(),
                        is_show_user: $('#is_show_user').prop('checked') ? 'on' : null
                    },
                    success: function(response) {
                        if (response.success == "fail") {
                            toastr.error('Bu ürün zaten satın alınmış.');

                        } else {
                            toastr.success('Siparişiniz başarıyla oluşturuldu.');
                            var cartOrderId = response.cart_order;
                            var redirectUrl =
                                "{{ route('pay.success', ['cart_order' => ':cartOrderId']) }}";
                            window.location.href = redirectUrl.replace(':cartOrderId',
                                cartOrderId);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        toastr.error('Ödeme işlemi sırasında bir hata oluştu.')
                    },
                    complete: function() {
                        $("#loadingOverlay").css("visibility",
                            "hidden"); // Visible olarak ayarla
                    }
                });
            });
            //  $('#completePaymentButton').prop('disabled', false);
            $('.bank-account').on('click', function() {
                // Tüm banka görsellerini seçim olmadı olarak ayarla
                $('.bank-account').removeClass('selected');
                // Seçilen banka görselini işaretle
                $(this).addClass('selected');
                // İlgili IBAN bilgisini al
                var selectedBankIban = $(this).data('iban');
                var selectedBankIbanID = $(this).data('id');
                var selectedBankTitle = $(this).data('title');
                $('#bankaID').val(selectedBankIbanID);
                var ibanInfo = "<span style='color:black'><strong>Banka Alıcı Adı:</strong> " +
                    selectedBankTitle + "<br><strong>IBAN:</strong> " + selectedBankIban + "</span>";
                $('#ibanInfo').html(ibanInfo);
            });
            $('#completePaymentButton').on('click', function() {
                if ($('.bank-account.selected').length === 0) {
                    toastr.error('Lütfen EFT/Havale kart seçimi yapınız.')
                } else {
                    $('#paymentModal').removeClass('show').hide();
                    $('.modal-backdrop').removeClass('show');
                    $('.modal-backdrop').remove();
                    $('#finalConfirmationModal').modal('show');
                }
            });

            function formatPrice(price) {
                var parts = price.toString().split(".");
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                return parts.join(".");
            }
            $(document).ready(function() {
                var $cart = <?php echo json_encode($cart); ?>;
                $(".paymentButton").on("click", function() {
                    var uniqueCode = ($cart['type'] === 'housing') ?
                        $cart['item']['id'] + 2000000 :
                        $cart['item']['housing'] + $cart['item']['id'] + 1000000;
                    $('#uniqueCode, #uniqueCodeRetry').text(uniqueCode);
                    $("#orderKey").val(uniqueCode);
                });
            });
        });


        //kredi kartı alanı

        $('.3dPaySuccess').on('click', function() {
            var $cart = JSON.parse($('#3dPayForm input[name="cart"]').val());
            // Kullanıcı bilgilerini al
            var fullName = $('#fullName').val();
            var tc = $('#tc').val();
            var email = $('#email').val();
            var card = $('#creditcard').val();
            var month = $('#month').val();
            var year = $('#year').val();
            // Kullanıcı bilgilerini kontrol et
            // Formun doldurulup doldurulmadığını kontrol et
            if (fullName === '' || tc === '' || email === '' || card === '' || month === '' || year === '') {
                toastr.warning('Ad Soyad, TC, E-posta ve Kredi Kartı alanları zorunludur.');
                return false; // Formun submit işlemini durdur
            }

            if (!$('#checkPay').prop('checked')) {
                toastr.warning('Lütfen sözleşmeyi onaylayınız.');
                $('#checkPay').css({
                    "border": "1px solid red"
                });
                return false;
            }

            // Kullanıcı bilgileri mevcutsa formu gönder
            $('#3dPayForm').submit();
        });



        $(document).ready(function() {
            $('#3dPayForm').on('submit', function(event) {
                // Kullanıcı bilgilerini al
                var fullName = $('#fullName').val();
                var email = $('#email').val();
                var tc = $('#tc').val();
                var phone = $('#phone').val();
                var address = $('#address').val();
                var notes = $('#notes').val();
                var reference_code = $('#reference_code').val();
                var orderKey = $('#orderKey').val();
                var have_discount = $('.have_discount').val();
                var discount = $('.discount').val();
                var is_swap = $('#is_swap').val();
                var is_reference = $("#is_reference").val()
                // Alınan kullanıcı bilgilerini ikinci forma set et
                $('#fullName2').val(fullName);
                $('#email2').val(email);
                $('#tc2').val(tc);
                $('#phone2').val(phone);
                $('#address2').val(address);
                $('#notes2').val(notes);
                $('#reference_code2').val(reference_code);
                $('#orderKey2').val(orderKey);
                $('#have_discount2').val(have_discount);
                $('#discount2').val(discount);
                //$('#have_discount2').val(have_discount);
                $('#is_swap2').val(is_swap);
                $("#is_reference2").val(is_reference)

            });
        });
    </script>
@endsection


@section('styles')
    <style>
        .wrap-house {
            // border-radius: 10px;
            padding: 32px;
            box-shadow: 0px 4px 18px 0px rgba(0, 0, 0, 0.0784313725);
            justify-content: space-between;
            margin-bottom: 40px;
            align-items:center;

        }

        .text-end {
            text-align: end;
        }

        .wrap-house .title-heading {
            font-size: 18px !important;
            font-weight: 700;
            color: black;
        }

        .sales {
            padding: 6px, 8px, 6px, 8px;
            background-color: #EA2B2E;
            width: 100px;
            color: #fff;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            margin-right: 13px;
        }

        .flat-property-detail .wrap-house .inner {
            margin-bottom: 14px;
        }

        .flex {
            /* display: -webkit-box; */
            display: -moz-box;
            display: -ms-flexbox;
            /* display: -webkit-flex; */
            display: flex;
        }

        .inner.flex {
            margin-top: 10px;
            /* padding-right: 10px; */
        }

        p {
            line-height: 20px;
            margin-top: 0;
            margin-bottom: 1rem;
            margin-right: 15px;
        }

        .flat-property-detail .wrap-house .icon-boxs a {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1px solid #E5E5EA;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 8px;
        }

        .wg-dream .icons span:nth-child(1) {
            margin-right: 14px;
        }

        .icons {
            /* display: inline; */
            float: right;
            margin-left: 6px;
        }

        .fs-30 {
            font-size: 25px;
        }

        .fw-6 {
            font-weight: 600;
            margin-right: 5px;
        }

        .row {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: 0px;
            !imporatant
        }

        .icon-boxs a {
            width: 100px;
            height: 40px;
            border: 1px solid #E5E5EA;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 123px;
        }

        .text-sq {
            // margin-left: 120px;
            margin-top: 5px;
        }

        .moneys {
            margin-top: 15px
        }

        .text-color-3 {
            color: #0259b6 !important;
        }

        .box-0 {
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .box-1 {
            margin-right: auto;
            padding-left: inherit;
        }

        i.fa.fa-map-marker {
            margin-right: 2px;
            margin-top: 3px;
        }

        @media only screen and (max-width: 991px) .wrap-house {
            display: block;
        }

        @media screen and (max-width: 768px) {
            .flex {
                /* display: -webkit-box; */
                display: -moz-box;
                display: -ms-flexbox;
                /* display: -webkit-flex; */
                display: flex;
                flex-wrap: wrap;
                align-content: stretch;
                justify-content: center;
            }


            .icon-boxs.flex {
                display: none;
            }

            .show-mobile {

                display: flex;
                justify-content: space-around;
                border: 1px solid #E5E5EA;

            }

            .box-0 {
                box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
                width: 200px;
                height: 200px;
                object-fit: cover;
            }

            .mobile {
                display: inline-block !important;
            }
        }

        .mobile {
            display: none;
        }

        .form-check {
            position: relative;
            display: block;
            padding-left: 0;
        }

        .copy-iban-button {
            width: 20px;
            height: 20px !important;
        }

        img.img-fluid {
            width: 100%;
            object-fit: contain;
            height: 100% !important;
        }

        a.copy-iban-button {
            color: #8e8a8a;
            font-size: 15px;
            cursor: pointer;
        }
    </style>
@endsection
