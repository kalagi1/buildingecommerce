@extends('client.layouts.master')



@section('content')

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @php

        $deposit_rate = 0.02;
        $discount_percent = 2;
        if ($cart['type'] == 'housing') {
            $deposit_rate = 0.02;
            $discount_percent = 2;
        } else {
            $deposit_rate = $project->deposit_rate / 100;
            $discount_percent = $project->deposit_rate;
        }
    @endphp
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
                <div class="row">
                    <div class="col-md-12">

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
                                    <div class="mb-3">
                                        {{ $cart['type'] == 'housing' ? 'İlan No: ' . $cart['item']['id'] + 2000000 : 'İlan No: ' . $cart['item']['housing'] + optional(App\Models\Project::find($cart['item']['id']))->id + 1000000 }}
                                    </div>
                                    <div class="title-heading fs-30 fw-7 lh-45">{{ $project->project_title }}
                                        {{ $cart['type'] != 'housing' ? 'Projesi' : null }}
                                        {{ $cart['item']['housing'] }} No'lu
                                        @if (isset($cart['item']['isShare']) && !empty($cart['item']['isShare']))
                                            PAY
                                        @else
                                            İLAN
                                        @endif
</div>
                                    <div class="inner flex">
                                        {{-- <div class="sales fs-12 fw-7 font-2 text-color-1">
                                            @if ($project->step2_slug)
                                                @if ($project->step2_slug == 'kiralik')
                                                    Kiralık {{ $project->housingType->title }}
                                                @elseif ($project->step2_slug == 'satilik')
                                                    Satılık {{ $project->housingType->title }}
                                                @else
                                                    Günlük Kiralık {{ $project->housingType->title }}
                                                @endif
                                            @endif
                                        </div> --}}
                                        <div class="icon-inner flex mb-3">
                                            <div class="years-icon flex align-center">
                                                <i class="fa fa-map-marker"></i>
                                                <span class="text-color-2">
                                                    {!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}
                                                    @if ($project->neighbourhood)
                                                        {!! ' / ' . optional($project->neighbourhood)->mahalle_title !!}
                                                    @endif
                                                </span>
                                            </div>
                                            {{-- <div class="view-icon flex align-center">
                                                <p class="text-color-2">{{ $project->create_company }}</p>
                                            </div> --}}

                                        </div>
                                    </div>

                                    <div class="icon-box flex">

                                        @if ($cart['type'] != 'housing')
                                            @if ($cart['item']['id'] == 431)
                                                <li class="d-flex align-items-center itemCircleFont">
                                                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                    <span>
                                                        1+1
                                                    </span>
                                                </li>
                                                <li class="d-flex align-items-center itemCircleFont icons">
                                                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                    <span>
                                                        Suit Oda
                                                    </span>
                                                </li>
                                                <li class="d-flex align-items-center itemCircleFont icons">
                                                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                    <span>
                                                        Konya/Ilgın
                                                    </span>
                                                </li>
                                            @elseif($cart['item']['id'] == 433)
                                                <li class="d-flex align-items-center itemCircleFont">
                                                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                    <span>
                                                        2+1
                                                    </span>
                                                </li>
                                                <li class="d-flex align-items-center itemCircleFont icons">
                                                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                    <span>
                                                        Suit Oda
                                                    </span>
                                                </li>
                                                <li class="d-flex align-items-center itemCircleFont icons">
                                                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                    <span>
                                                        Konya/Ilgın
                                                    </span>
                                                </li>
                                            @elseif($cart['item']['id'] == 434)
                                                <li class="d-flex align-items-center itemCircleFont">
                                                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                    <span>
                                                        3+1
                                                    </span>
                                                </li>
                                                <li class="d-flex align-items-center itemCircleFont icons">
                                                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                    <span>
                                                        Villa
                                                    </span>
                                                </li>
                                                <li class="d-flex align-items-center itemCircleFont icons">
                                                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                    <span>
                                                        Konya/Ilgın
                                                    </span>
                                                </li>
                                            @else
                                                @foreach (['column1', 'column2', 'column3'] as $key => $column)
                                                    @php
                                                        $column_name =
                                                            $project->listItemValues->{$column . '_name'} ?? '';
                                                        $column_additional =
                                                            $project->listItemValues->{$column . '_additional'} ?? '';
                                                        $column_name_exists =
                                                            $column_name &&
                                                            isset($projectHousingsList[$cart['item']['housing']][$column_name . '[]']);
                                                    @endphp

                                                    @if ($column_name_exists)
                                                        <li class="d-flex align-items-center itemCircleFont @if($key != 0) icons @endif">
                                                            <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                            <span>
                                                                {{ $projectHousingsList[$cart['item']['housing']][$column_name . '[]'] }}
                                                                @if ($column_additional && is_numeric($projectHousingsList[$cart['item']['housing']][$column_name . '[]']))
                                                                    {{ $column_additional }}
                                                                @endif
                                                            </span>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                            @else
                                            @foreach (['column1', 'column2', 'column3'] as $key => $column)
                                            @php
                                                $column_name = $project->listItemValues->{$column . '_name'} ?? '';
                                                $column_additional =
                                                    $project->listItemValues->{$column . '_additional'} ?? '';
                                                $column_name_exists =
                                                    $column_name &&
                                                    isset(
                                                        $projectHousingsList[$cart['item']['housing']][
                                                            $column_name . '[]'
                                                        ],
                                                    );
                                            @endphp
                                            @if ($column_name_exists)
                                            <li class="d-flex align-items-center itemCircleFont @if($key != 0) icons @endif">
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
                                        @endif

                                     
                                    </div>

                                </div>
                                <div class="box-2 text-end ">

                                    <div class="icon-boxs flex">
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

                                    </div>
                                    <div class="moneys fs-30 fw-7 lh-45 text-color-3">
                                        {{ number_format($cart['item']['amount'], 0, ',', '.') }}
                                        TL</div>
                                    <div class="text-sq fs-12 lh-16">
                                        @if (isset($cart['item']['isShare']) && !empty($cart['item']['isShare']))
                                            <span style="color:#EC2F2E" class="mt-3">{{ $cart['item']['qt'] }} adet
                                                tapulu pay
                                                satın
                                                alıyorsunuz!</span>
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
                                    <div>
                                        {{ $cart['type'] == 'housing' ? 'İlan No: ' . $cart['item']['id'] + 2000000 : 'İlan No: ' . $cart['item']['housing'] + optional(App\Models\Project::find($cart['item']['id']))->id + 1000000 }}
                                    </div>
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
                                                <p class="text-color-2">{{ $housing->create_company }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="icon-box flex">
                                        <ul class="row column">

                                            @if ($housing->column1_name)
                                                <div class="icon-box flex">
                                                    <div class="icons icon-1 flex">
                                                        <i class="fa fa-circle circleIcon mr-1 fa-lg-2"
                                                            aria-hidden="true"></i>
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
                                                        <i class="fa fa-circle circleIcon mr-1 fa-lg-2"
                                                            aria-hidden="true"></i>
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
                                                        <i class="fa fa-circle circleIcon mr-1 fa-lg-2"
                                                            aria-hidden="true"></i>
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
                                                        <i class="fa fa-circle circleIcon mr-1 fa-lg-2"
                                                            aria-hidden="true"></i>
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

                                    </div>
                                    <div class="moneys fs-30 fw-7 lh-45 text-color-3">
                                        {{ number_format($cart['item']['amount'], 0, ',', '.') }}
                                        TL</div>

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
                    </div>
                </div>

                <div class="row">
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
                                $projectHousing = App\Models\ProjectHousing::where('project_id', $cart['item']['id'])
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
                        $discountedPrice =
                            $itemPrice - ($housingDiscountAmount ? $housingDiscountAmount : $projectDiscountAmount);

                        $displayedPrice = number_format($discountedPrice, 0, ',', '.');
                        $share_sale = $cart['item']['isShare'] ?? null;
                        $number_of_share = $cart['item']['numbershare'] ?? null;
                    @endphp
                    <div class="col-md-12 col-lg-12 col-xl-7">
                        <div class="tr-single-box">
                            <div class="tr-single-body">
                                <div class="tr-single-header pb-3">
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
                                            <label for="tc">TC: </label>
                                            <input type="number" class="form-control" id="tc" name="tc"
                                                required oninput="validateTCLength(this)">
                                        </div>
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
                                        <script>
                                            function validateTCLength(input) {
                                                const tckNo = input.value.replace(/\D/g, '');
                                                // TC Kimlik No'nun uzunluğu 11 haneli olmalıdır
                                                if (tckNo.length > 11) {
                                                    toastr.warning("TC kimlik numarası 11 karakterden fazla olamaz!");
                                                    return '';
                                                }

                                                // İlk hane 0 olamaz
                                                if (tckNo[0] == "0") {
                                                    toastr.warning("Geçersiz TC Kimlik No! İlk rakam 0 olamaz.");
                                                    $('#tc').val("")
                                                    return '';
                                                }

                                                // TC Kimlik No'nun ilk 9 hanesinin toplamı 10. ve 11. haneleri verir
                                                let sum = 0;
                                                for (let i = 0; i < 10; i++) {
                                                    sum += Number(tckNo[i]);
                                                }

                                                const lastDigit = sum % 10;
                                                if (tckNo.length == 11 && lastDigit !== Number(tckNo[10])) {
                                                    toastr.warning("Geçersiz TC Kimlik No! Kontrol haneleri uyuşmuyor.");
                                                    $('#tc').val("")
                                                    return '';
                                                }

                                                // TC Kimlik No formatını düzenle (5-6-5)
                                                const formattedTC = input.target.value;
                                                console.log(formattedTC);
                                                $('#tc').val(formattedTC)
                                                return formattedTC;
                                            }
                                        </script>
                                        <div class="col-sm-6">
                                            <label for="phone">Telefon:</label>

                                            <input type="number" class="form-control" id="phone" name="phone"
                                                required maxlength="10">
                                            <span id="error_message" class="error-message"></span>

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
                                                        <option
                                                            value="{{ isset($neighborProject['owner']) ? $neighborProject['owner']['id'] : '' }}">
                                                            {{ isset($neighborProject['owner']) ? $neighborProject['owner']['name'] : '' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>



                                        @if (isset($cart) && isset($cart['type']))
                                            @if (
                                                ($cart['type'] == 'project' && isset($share_sale) && $share_sale == '[]') ||
                                                    ($cart['type'] == 'project' && empty($share_sale)))
                                                <div class="col-sm-12 pt-2">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <input id="is_show_user" type="checkbox" value="off"
                                                            name="is_show_user">
                                                        <div>


                                                            <label for="is_show_user" class="m-0 ml-1 text-black">
                                                                <i class="fa fa-info-circle ml-2 mobile-hidden"
                                                                    title="Komşumu Gör özelliğini aktif ettiğinizde, diğer komşularınızın sizin iletişim bilgilerinize ulaşmasına izin vermiş olursunuz."
                                                                    style="font-size: 18px; color: black;"></i> Komşumu Gör
                                                                özelliği ile iletişim bilgilerimi paylaşmayı
                                                                kabul
                                                                ediyorum.

                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif





                                        {{-- <div class="col-sm-12 pt-2">
                                            <div class="d-flex align-items-center mb-3">
                                                <input id="checkPay" type="checkbox" name="checkPay">

                                                <label for="checkPay" class="m-0 ml-1 text-black">
                                                    <a href="/sayfa/mesafeli-kapora-emanet-sozlesmesi" target="_blank">
                                                        Mesafeli kapora emanet sözleşmesini
                                                    </a>
                                                    okudum ve kabul ediyorum
                                                </label>
                                            </div>
                                        </div> --}}



                                        <div class="col-sm-12 pt-2">
                                            <div class="d-flex align-items-center mb-3">
                                                <input id="checkSignature" type="checkbox" name="checkSignature">
                                                <label for="checkSignature" class="m-0 ml-1 text-black">
                                                    Sözleşme aslını imzalamak için 7 iş günü içerisinde geleceğimi
                                                    kabul ve beyan ediyorum.
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
                                <div class="tr-single-box">

                                    <div class="tr-single-body">
                                        <div class="tr-single-header pb-3">
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
                                                        <li style="color:#EC2F2E">Mağaza İndirimi :<strong
                                                                class="pull-right">
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
                                                        <li style="color:#EC2F2E">Emlak Kulüp İndirim Oranı :<strong
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
                                                        <li> %{{ $discount_percent }} Kapora:<strong
                                                                class="pull-right">{{ number_format($discountedPrice * $deposit_rate, 0, ',', '.') }}
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
                                                        class="button-price-inner pull-right text-success">{{ number_format($discountedPrice * $deposit_rate, 0, ',', '.') }}
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
                                                        class="button-price-inner pull-right text-success">{{ number_format($discountedPrice * $deposit_rate, 0, ',', '.') }}
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
                                                                <input class="form-check-input mt-0" type="radio"
                                                                    name="payment_option" id="option1" value="option1"
                                                                    checked>
                                                                <label class="form-check-label  ml-2  mb-2 offset-md-1"
                                                                    for="option1">
                                                                    Kredi Kartı ile Ödeme
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-check">
                                                                <input class="form-check-input mt-0" type="radio"
                                                                    name="payment_option" id="option2" value="option2">
                                                                <label class="form-check-label  ml-2 mb-2 offset-md-1"
                                                                    for="option2">
                                                                    EFT / Havale ile Ödeme
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="payment1" class="payment">
                                            <div class='card'>
                                                <div class='front'>
                                                    <div class='top'>
                                                        <div class='chip'></div>
                                                        <div class='cardType'><svg
                                                                xmlns:dc="http://purl.org/dc/elements/1.1/"
                                                                xmlns:cc="http://creativecommons.org/ns#"
                                                                xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                                                                xmlns:svg="http://www.w3.org/2000/svg"
                                                                xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                                id="svg10306" viewBox="0 0 500.00001 162.81594"
                                                                height="162.81593" width="500">
                                                                <defs id="defs10308">
                                                                    <clipPath id="clipPath10271"
                                                                        clipPathUnits="userSpaceOnUse">
                                                                        <path id="path10273"
                                                                            d="m 413.742,90.435 c -0.057,-4.494 4.005,-7.002 7.065,-8.493 3.144,-1.53 4.2,-2.511 4.188,-3.879 -0.024,-2.094 -2.508,-3.018 -4.833,-3.054 -4.056,-0.063 -6.414,1.095 -8.289,1.971 l -1.461,-6.837 c 1.881,-0.867 5.364,-1.623 8.976,-1.656 8.478,0 14.025,4.185 14.055,10.674 0.033,8.235 -11.391,8.691 -11.313,12.372 0.027,1.116 1.092,2.307 3.426,2.61 1.155,0.153 4.344,0.27 7.959,-1.395 l 1.419,6.615 c -1.944,0.708 -4.443,1.386 -7.554,1.386 -7.98,0 -13.593,-4.242 -13.638,-10.314 m 34.827,9.744 c -1.548,0 -2.853,-0.903 -3.435,-2.289 l -12.111,-28.917 8.472,0 1.686,4.659 10.353,0 0.978,-4.659 7.467,0 -6.516,31.206 -6.894,0 m 1.185,-8.43 2.445,-11.718 -6.696,0 4.251,11.718 m -46.284,8.43 -6.678,-31.206 8.073,0 6.675,31.206 -8.07,0 m -11.943,0 -8.403,-21.24 -3.399,18.06 c -0.399,2.016 -1.974,3.18 -3.723,3.18 l -13.737,0 -0.192,-0.906 c 2.82,-0.612 6.024,-1.599 7.965,-2.655 1.188,-0.645 1.527,-1.209 1.917,-2.742 l 6.438,-24.903 8.532,0 13.08,31.206 -8.478,0" />
                                                                    </clipPath>
                                                                    <linearGradient id="linearGradient10277"
                                                                        spreadMethod="pad"
                                                                        gradientTransform="matrix(84.1995,31.0088,31.0088,-84.1995,19.512,-27.4192)"
                                                                        gradientUnits="userSpaceOnUse" y2="0"
                                                                        x2="1" y1="0" x1="0">
                                                                        <stop id="stop10279" offset="0"
                                                                            style="stop-opacity:1;stop-color:#222357" />
                                                                        <stop id="stop10281" offset="1"
                                                                            style="stop-opacity:1;stop-color:#254aa5" />
                                                                    </linearGradient>
                                                                </defs>
                                                                <metadata id="metadata10311">
                                                                    <rdf:RDF>
                                                                        <cc:Work rdf:about="">
                                                                            <dc:format>image/svg+xml</dc:format>
                                                                            <dc:type
                                                                                rdf:resource="http://purl.org/dc/dcmitype/StillImage" />
                                                                            <dc:title />
                                                                        </cc:Work>
                                                                    </rdf:RDF>
                                                                </metadata>
                                                                <g transform="translate(-333.70157,-536.42431)"
                                                                    id="layer1">
                                                                    <g id="g10267"
                                                                        transform="matrix(4.9846856,0,0,-4.9846856,-1470.1185,1039.6264)">
                                                                        <g clip-path="url(#clipPath10271)" id="g10269">
                                                                            <g transform="translate(351.611,96.896)"
                                                                                id="g10275">
                                                                                <path id="path10283"
                                                                                    style="fill: white;fill-opacity:1;fill-rule:nonzero;stroke:none"
                                                                                    d="M 0,0 98.437,36.252 120.831,-24.557 22.395,-60.809" />
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </svg></div>
                                                    </div>
                                                    <div class='middle'>
                                                        <div class='cd-number'>
                                                            <p><span class='num-1'>####</span><span
                                                                    class='num-2'>####</span><span
                                                                    class='num-3'>####</span><span
                                                                    class='num-4'>####</span></p>
                                                        </div>
                                                    </div>
                                                    <div class='bottom'>
                                                        <div class='cardholder'>
                                                            <p class='label'>Kart Sahibinin Adı</p>
                                                            <p class='holder'>İsim Soyisim</p>
                                                        </div>
                                                        <div class='expires'>
                                                            <p class='label'>Ay/Yıl</p>
                                                            <p><span class='month'>**</span>/<span
                                                                    class='year'>**</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='back'>
                                                    <div class='top'>
                                                        <div class='magstripe'></div>
                                                    </div>
                                                    <div class='middle'>
                                                        <p class='label'>CCV</p>
                                                        <div class='cvc'>
                                                            <p>***</p>
                                                        </div>
                                                    </div>
                                                    <div class='bottom'>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class='form'>
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
                                                    <div class='cd-numbers'>
                                                        <label>Kart Numarası</label>
                                                        <div class='fields'>
                                                            <input type='number' name="creditcard[]" class='1'
                                                                maxlength="4" />
                                                            <input type='number' name="creditcard[]" class='2'
                                                                maxlength="4" />
                                                            <input type='number' name="creditcard[]" class='3'
                                                                maxlength="4" />
                                                            <input type='number' name="creditcard[]" class='4'
                                                                maxlength="4" />
                                                        </div>
                                                    </div>
                                                    <div class='cd-holder'>
                                                        <label for='cd-holder-input'>Kart Sahibinin Adı Soyadı</label>
                                                        <input type='text' id='cd-holder-input' />
                                                    </div>
                                                    <div class='cd-validate'>
                                                        <div class='expiration'>
                                                            <div class='field'>
                                                                <label for='month'>Ay</label>
                                                                <select id='month' name="month">
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
                                                            <div class='field'>
                                                                <label for='year'>Yıl</label>
                                                                <select id='year' name="year">
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
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class='payButtonStyle 3dPaySuccess'><i
                                                            class="fa fa-credit-card mr-2" aria-hidden="true"></i>Ödemeyi
                                                        Tamamla</button>
                                                </form>
                                            </div>
                                            {{-- <div class="payment-card"> --}}

                                            {{-- <div class="collapse show" id="debit-credit" role="tablist"
                                                aria-expanded="false" style="">
                                                <div class="payment-card-body">
                                                    <form method="POST" id="3dPayForm" action="{{ route('3d.pay') }}">
                                                        @csrf
                                                        <input type="hidden" name="cart"
                                                            value="{{ json_encode($cart) }}">
                                                        <input type="hidden" name="payable_amount"
                                                            id="payableAmountInput">
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
                                                        <input type="hidden" id="is_swap2" name="is_swap"
                                                            class="is_swap"
                                                            value="{{ $cart['item']['payment-plan'] ?? null }}">
                                                        <div class="row" style="width:100% !important">
                                                            <div class="col-sm-12 p-0">
                                                                <label for="creditcard">Kart Numarası</label>
                                                                <input type="text" class="form-control"
                                                                    id="creditcard" name="creditcard"
                                                                    style="height: 37px" oninput="formatCreditCard(this)">
                                                             
                                                            </div>
                                                        </div>
                                                        <div class="row mrg-bot-20 justify-content-between"
                                                            style="width:100% !important">
                                                            <div class="col-sm-5 col-md-5 p-0 pl-0">
                                                                <label>Son Kullanma Ayı</label>
                                                                <select class="form-control" id="month"
                                                                    name="month">
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
                                                            <div class="col-sm-5 col-md-5 pr-0 pl-0">
                                                                <label>Son Kullanma Yılı</label>
                                                                <select class="form-control" id="year"
                                                                    name="year">
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
                                                            </div>
                                                        </div>
                                                </div>

                                                <button type="submit"
                                                    class="btn btn-block btn-success 3dPaySuccess">Ödemeyi
                                                    Tamamla
                                                    <svg viewBox="0 0 576 512" class="svgIcon">
                                                        <path
                                                            d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24H360c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z">
                                                        </path>
                                                    </svg></button>

                                                </form>

                                            </div> --}}
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
                                            <div class="collapse show" id="paypal" role="tablist"
                                                aria-expanded="false" style="">
                                                {{-- <div class="payment-card-body"> --}}
                                                <div class="invoice-total mt-3">
                                                    <span class="mt-3">EFT/Havale yapacağınız bankayı seçiniz</span>
                                                    <div class="row mb-3 mt-3 p-0 mx-0">
                                                        <span>1. <strong style="color:#EC2F2E;font-weight:bold !important"
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
                                                        <span style="color:#EC2F2E;font-weight:bold"
                                                            id="uniqueCode"></span>
                                                        kodu
                                                        kullanarak ödemenizi
                                                        yapın. IBAN açıklama
                                                        alanına
                                                        bu kodu eklemeyi unutmayın. Ardından "Ödemeyi Tamamla" düğmesine
                                                        tıklayarak
                                                        işlemi
                                                        bitirin.</span>
                                                </div>
                                                <div class="mt-5" style="width:50%">
                                                    <label class="custom-file-upload btn btn-m">
                                                        <i class="fas fa-link mr-2" style="font-size:14px;"></i>
                                                        Dekont Ekle
                                                        <input type="file" name="file" id="fileInput" />
                                                    </label>
                                                    <span id="fileStatus" style="font-size: 12px;"></span>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <button type="button"
                                                        class="btn btn-block btn-m btn-success mt-5 paySuccess"
                                                        id="completePaymentButton" style="float:right">Ödemeyi
                                                        Tamamla
                                                    </button>

                                                </div>
                                                {{-- </div> --}}
                                            </div>
                                            {{-- </div> --}}
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&callback=initMap"></script>
    <script>
        $(document).ready(function() {

            $("#phone").on("input blur", function() {
                var phoneNumber = $(this).val();
                var pattern = /^5[0-9]\d{8}$/;

                if (!pattern.test(phoneNumber)) {
                    $("#success_message").text("");
                    $("#error_message").text(
                        "Lütfen geçerli bir telefon numarası giriniz.");
                } else {
                    $("#error_message").text("");
                }
                // Kullanıcı 10 haneden fazla veri girdiğinde bu kontrol edilir
                $('#phone').on('keypress', function(e) {
                    var max_length = 10;
                    // Eğer giriş karakter sayısı 10'a ulaştıysa ve yeni karakter ekleme işlemi değilse
                    if ($(this).val().length >= max_length && e.which != 8 && e.which != 0) {
                        // Olayın işlenmesini durdur
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $('#fileInput').change(function() {
                var file = $(this)[0].files[0];
                var fileName = file.name;
                var fileExt = fileName.split('.').pop().toLowerCase(); // Dosya uzantısını al

                // Sadece PDF dosyalarını kabul et
                if (fileExt !== 'pdf') {
                    toastr.error("Lütfen PDF formatında bir dosya seçiniz.");
                    $(this).val(''); // Dosya seçimini temizle
                    $('#fileStatus').text(''); // Dosya adı gösterimini temizle
                } else {
                    $('#fileStatus').text('Dosya Eklendi: ' + fileName); // Dosya adını görüntüle
                }
            });
        });


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
                payableAmount = {{ $discountedPrice * $deposit_rate }};
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

        $(document).ready(function() {
            const cart =
                @json($cart); // Use Laravel Blade directive to safely pass PHP data to JavaScript
            const uniqueCode = cart.type === 'housing' ?
                cart.item.id + 2000000 :
                `${cart.item.id + 1000000}-${cart.item.housing}`;

            $('#uniqueCode, #uniqueCodeRetry').text(uniqueCode); // Insert uniqueCode into span elements
            $('#orderKey').val(uniqueCode); // Insert uniqueCode into hidden input element
        });
        $(document).ready(function() {

            $('.paySuccess').on('click', function() {
                var fileInput = document.getElementById('fileInput');
                if (fileInput.files.length == 0) {
                    toastr.warning('Lütfen dekont yükleyiniz.')
                    return false;
                }
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
                if (!$('#checkPay').prop('checked')) {
                    toastr.warning('Lütfen sözleşmeyi onaylayınız.');
                    $('#checkPay').css({
                        "border": "1px solid red"
                    });
                    return;
                }
                if (!$('#checkSignature').prop('checked')) {
                    toastr.warning('Lütfen onay veriniz.');
                    $('#checkSignature').css({
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
                        is_show_user: $('#is_show_user').prop('checked') ? 'on' : null,
                        payableAmount: payableAmount
                    },
                    success: function(response) {
                        if (response.success == "fail") {
                            toastr.error('Bu ürün zaten satın alınmış.');

                        } else {
                            toastr.success('Siparişiniz başarıyla oluşturuldu.');
                            var cartOrderId = response.cart_order;

                            // Dosya yükleme AJAX isteği
                            var formData = new FormData();
                            formData.append('file', $('#fileInput')[0].files[0]);

                            // Cart order ID'yi ikinci AJAX isteğine ekleyelim
                            formData.append('cart_order', response.cart_order);
                            formData.append('_token', '{{ csrf_token() }}');

                            $.ajax({
                                url: "{{ route('dekont.file.upload') }}",
                                type: "POST",
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    console.log(response)
                                    toastr.success("Dosya başarıyla yüklendi.");
                                },
                                error: function(error) {
                                    toastr.error(
                                        "Dosya yüklenirken bir hata oluştu.");
                                    console.error("Hata oluştu: " + error
                                        .responseText);
                                }
                            });

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
                var ibanInfo = "<span style='color:black'><strong>Hesap Sahibinin Adı Soyadı:</strong> " +
                    selectedBankTitle + "<br><br><strong>IBAN:</strong> " + selectedBankIban +
                    "</span><br><br>";
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
                    const uniqueCode = cart.type === 'housing' ?
                        cart.item.id + 2000000 :
                        `${cart.item.id + 1000000}-${cart.item.housing}`;
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
            var card = $('.1').val();
            var card2 = $('.2').val();
            var card3 = $('.3').val();
            var card4 = $('.4').val();

            var month = $('#month').val();
            var year = $('#year').val();
            // Kullanıcı bilgilerini kontrol et
            // Formun doldurulup doldurulmadığını kontrol et
            if (fullName === '' || tc === '' || email === '' || card === '' || card2 === '' || card3 === '' ||
                card4 === '' || month === '' || year === '') {
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

            if (!$('#checkSignature').prop('checked')) {
                toastr.warning('Lütfen onay veriniz.');
                $('#checkSignature').css({
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

        $(".form").find(".cd-numbers").find(".fields").find("input").on('keyup change', function(e) {

            var charLength = $(this).val().length;

            $(".card").removeClass("flip");

            if (charLength == 4) {
                $(this).next("input").focus();
            }

            if ($(this).hasClass("1")) {
                var inputVal = $(this).val();
                if (!inputVal.length == 0) {
                    $(".card").find(".front").find(".cd-number").find("span.num-1").text(inputVal);
                }
            }

            if ($(this).hasClass("2")) {
                var inputVal = $(this).val();
                if (!inputVal.length == 0) {
                    $(".card").find(".front").find(".cd-number").find("span.num-2").text(inputVal);
                }
            }

            if ($(this).hasClass("3")) {
                var inputVal = $(this).val();
                if (!inputVal.length == 0) {
                    $(".card").find(".front").find(".cd-number").find("span.num-3").text(inputVal);
                }
            }

            if ($(this).hasClass("4")) {
                var inputVal = $(this).val();
                if (!inputVal.length == 0) {
                    $(".card").find(".front").find(".cd-number").find("span.num-4").text(inputVal);
                }
            }

        });
        $(".form").find(".cd-holder").find("input").on('keyup change', function(e) {
            var inputValCdHolder = $(this).val();

            $(".card").removeClass("flip");

            if (!inputValCdHolder.length == 0) {
                $(".card").find(".front").find(".bottom").find(".cardholder").find("p.holder").text(
                    inputValCdHolder)
            }

        });
        $(".form").find(".cd-validate").find(".cvc").find('input').on('keyup change', function(e) {
            var inputCvcVal = $(this).val();

            if (!inputCvcVal.length == 0) {
                $(".card").addClass("flip").find(".cvc").find("p").text(inputCvcVal);
            } else if (inputCvcVal.length == 0) {
                $(".card").removeClass("flip");
            }
        });
        $(".form").find(".cd-validate").find(".expiration").find('select#month').on('keyup change', function() {

            $(".card").removeClass("flip");
            if (!$(this).val().length == 0) {
                $(".card").find('.bottom').find('.expires').find("p").find("span.month").text($(this).val())
            }

        });
        $(".form").find(".cd-validate").find(".expiration").find('select#year').on('keyup change', function() {

            $(".card").removeClass("flip");
            if (!$(this).val().length == 0) {
                $(".card").find('.bottom').find('.expires').find("p").find("span.year").text($(this).val())
            }

        });
        $("button.submit").on('click', function(e) {
            e.preventDefault();
            $(this).parents("form").submit();
        });
    </script>
@endsection


@section('styles')
    <style>
        .custom-file-upload {
            color: White !important;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: black;
        }

        .custom-file-upload input[type="file"] {
            display: none;
        }

        .error-message {
            color: #e54242;
            font-size: 11px;
        }

        .success-message {
            color: green;
            font-size: 11px;
        }

        .wrap-house {
            // border-radius: 10px;
            padding: 32px;
            box-shadow: 0px 4px 18px 0px rgba(0, 0, 0, 0.0784313725);
            justify-content: space-between;
            margin-bottom: 40px;
            align-items: center;

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
            padding: 6px 8px 6px 8px;
            background-color: #EC2F2E;
            width: 140px;
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
    <style>
        .credits {
            padding: 20px;
            font-size: 25px;
        }

        .credits a {
            color: #4FB0C6;
            text-decoration: none;
            font-weight: 700;
        }

        .card {
            position: relative;
            color: white;
            transform-style: preserve-3d;
            transition: 0.5s ease-in-out;
            widtH: 100%;
            height: 250px;
            margin: auto;
            border-radius: 10px;
            z-index: 2;
        }

        @media (max-widtH: 500px) {
            .card {
                widtH: 300px;
                height: 187.5px;
            }
        }


        .card .front,
        .card .back {
            widtH: 100%;
            height: 250px;
            background: linear-gradient(-45deg, #4FB0C6, #3e79be);
            padding: 20px;
            position: absolute;
            top: 0;
            left: 0;
            border-radius: 10px;
            overflow: hidden;
            transition: 0.5s ease-in-out;
        }

        @media (max-widtH: 500px) {

            .card .front,
            .card .back {
                widtH: 300px;
                height: 187.5px;
            }
        }

        .card .front:after,
        .card .back:after {
            content: "";
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            widtH: 100%;
            height: 250px;
            transition: 0.5s ease-in-out;
            z-index: -1;
            opacity: 0.15;
            background-image: url("http://image.flaticon.com/icons/svg/126/126511.svg");
            background-repeat: no-repeat;
            background-size: 75%;
            background-position: 150px center;
        }

        @media (max-widtH: 500px) {

            .card .front:after,
            .card .back:after {
                widtH: 300px;
                height: 187.5px;
            }
        }

        .card .front {
            z-index: 5;
            transform: rotateY(0deg);
        }

        .card .back {
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transform: rotateY(180deg);
        }

        .card .back .label {
            font-size: 12.5px;
            font-weight: bold;
            color: rgba(233, 245, 248, 0.85);
            margin-right: 5px;
        }

        .card .back .top {
            padding-top: 40px;
            transition: 0.5s ease-in-out;
        }

        @media (max-width: 500px) {
            .card .back .top {
                padding-top: 15px;
            }
        }

        .card .back .top .magstripe {
            width: 100%;
            height: 50px;
            background: #333;
        }

        .card .back .middle {
            margin-top: -40px;
            padding: 0 20px;
            text-align: right;
        }

        .card .back .middle .cvc {
            width: 100%;
            height: 40px;
            background: white;
            color: black;
            line-height: 40px;
            padding: 0 10px;
            border-radius: 10px;
        }

        .card .front {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card .front .middle .cd-number p {
            margin-bottom: 0;
        }

        .card .front .middle .cd-number p span {
            margin-right: 20px;
            font-size: 25px;
            font-size: 20px;
        }

        .card .front .bottom {
            display: flex;
            justify-content: space-between;
        }

        .card .front .bottom .cardholder .label,
        .card .front .bottom .expires .label {
            font-size: 12.5px;
            font-weight: bold;
            color: rgba(233, 245, 248, 0.85);
        }

        .card .front .top {
            display: flex;
            justify-content: space-between;
        }

        .card .front .top .cardType svg,
        .card .front .top .cardType img {
            width: 70px;
            height: 50px;
            transition: 0.5s ease-in-out;
        }

        @media (max-widtH: 500px) {

            .card .front .top .cardType svg,
            .card .front .top .cardType img {
                width: 50px;
                height: 35px;
            }
        }

        .card .front .top .chip {
            width: 70px;
            height: 50px;
            background: linear-gradient(-45deg, #e1e7ed, #9baec8);
            position: relative;
            border-radius: 5px;
            transition: 0.5s ease-in-out;
        }

        @media (max-widtH: 500px) {
            .card .front .top .chip {
                width: 50px;
                height: 35px;
            }
        }

        .card .front .top .chip:after {
            content: "";
            display: block;
            width: 50px;
            height: 30px;
            transition: 0.5s ease-in-out;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 2px solid #5a79a3;
            opacity: 0.35;
            border-radius: 5px;
        }

        @media (max-widtH: 500px) {
            .card .front .top .chip:after {
                width: 35px;
                height: 20px;
            }
        }

        .form {
            width: 100%;
            margin: auto;
            padding: 20px;
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.35);
            margin-top: -20px;
            border-radius: 10px;
            transition: 0.5s ease-in-out;
        }

        .form button.payButtonStyle {
            display: block;
            padding: 20px 5px;
            width: 100%;
            margin-top: 20px;
            background: #2b90d9;
            color: white;
            border-radius: 5px;
            outline: 0;
            border: none;
            transition: 0.15s ease-in-out;
        }

        .form button.submit:hover {
            background: #2689d2;
        }

        @media (max-widtH: 500px) {
            .form {
                width: 300px;
                margin-top: -25px;
            }
        }

        .form input,
        .form select {
            padding: 10px 5px;
            border-radius: 5px;
            outline: 0;
            border: none;
            box-shadow: 0px 0px 5px #2b90d9;
        }

        .form .cd-validate {
            display: flex;
            justify-content: space-between;
        }

        .form .cd-validate .expiration {
            display: flex;
            justify-content: space-between;
        }

        .form .cd-validate .expiration .field:last-child {
            margin-left: 10px;
        }

        .form .cd-validate .cvc {
            text-align: right;
        }

        .form .cd-validate .cvc input#cvc {
            width: 50px;
        }

        .form .cd-validate label {
            display: block;
            margin-bottom: 10px;
        }

        .form .cd-holder {
            margin: 20px 0;
        }

        .form .cd-holder label {
            display: block;
            margin-bottom: 10px;
        }

        .form .cd-holder input {
            width: 100%;
        }

        .form .cd-numbers {
            margin: 20px 0;
        }

        .form .cd-numbers label {
            display: block;
            margin-bottom: 10px;
        }

        .form .cd-numbers .fields {
            display: flex;
        }

        .form .cd-numbers .fields input {
            width: 100%;
            margin: 0 10px;
        }

        .form .cd-numbers .fields input:first-child {
            margin-left: 0;
        }

        .form .cd-numbers .fields input:last-child {
            margin-right: 0;
        }
    </style>
@endsection
