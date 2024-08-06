@extends('client.layouts.master')

@section('content')
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
    @endphp
    @php
        function implodeData($array)
        {
            $html = '';

            foreach ($array as $value) {
                // Convert the value to string before concatenation
                $stringValue = strval($value);

                if (!empty($html)) {
                    $html .= ', ';
                }

                $html .= ' ' . $stringValue;
            }

            return $html;
        }

        $projectHousings = [];
        $projectDiscountAmount = null;
    @endphp


    <div class="loading-full d-none">
        <div class="back-opa">

        </div>
        <div class="content-loading">
            <i class="fa fa-spinner"></i>
        </div>
    </div>


    <x-store-card :store="$project->user" :project="$project" />


    <section class="recently  bg-white homepage-5 ">
        <div class="container">
            <div class="row mb-3" style="align-items:center">
                <div class="col-md-8 col-12">
                    <div class="headings-2 pt-0 pb-0">
                        <div class="pro-wrapper" style="width: 100%; justify-content: space-between;">
                            <div class="detail-wrapper-body">
                                <div class="listing-title-bar">
                                    <strong
                                        style="color: black;font-size: 11px !important;text-align:left;width:100%;display:block">İlan
                                        No: <span style="color: #274abb;">{{ $project->id + 1000000 }}</span></strong>
                                    <h3>{{ $project->project_title }}</h3>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12 mt-2">
                    @if (Auth::check() && Auth::user()->corporate_type == 'Emlak Ofisi')
                    <hr>
                        <span
                            style="    color: green;
                          font-weight: 700;
                          font-size: 16px;
                          text-align: center;
                          width:100%;
                          display: flex;
                          justify-content: center;
                          align-items: center;">SATIŞTAN
                            %{{ $project->club_rate }} KOMİSYON KAZAN!</span>
                            <hr>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="headings-2 pt-0 pb-0">

                        <div id="listingDetailsSlider" class="carousel listing-details-sliders slide mb-30">
                            <div class="carousel-inner">
                                {{-- Kapak Görseli --}}
                                <div class="item carousel-item active" data-slide-number="0" style="position: absolute">
                                    <a href="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                        data-lightbox="project-images">
                                        <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                            class="img-fluid" alt="slider-listing">
                                    </a>
                                </div>

                                @foreach ($project->images as $key => $housingImage)
                                    <div class="item carousel-item" data-slide-number="{{ $key + 1 }}">
                                        <a href="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $housingImage->image) }}"
                                            data-lightbox="project-images">
                                            <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $housingImage->image) }}"
                                                class="img-fluid" alt="slider-listing">
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Küçük Resim Navigasyonu --}}
                            <div class="listingDetailsSliderNav mt-3">
                                <div class="item active" style="margin: 10px; cursor: pointer">
                                    <a id="carousel-selector-0" data-slide-to="0" data-target="#listingDetailsSlider">
                                        <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                            class="img-fluid carousel-indicator-image" alt="listing-small">
                                    </a>
                                </div>
                                @foreach ($project->images as $key => $housingImage)
                                    <div class="item" style="margin: 10px; cursor: pointer">
                                        <a id="carousel-selector-{{ $key + 1 }}" data-slide-to="{{ $key + 1 }}"
                                            data-target="#listingDetailsSlider">
                                            <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $housingImage->image) }}"
                                                class="img-fluid carousel-indicator-image" alt="listing-small">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <nav aria-label="Page navigation example" style="margin-top: 7px">
                                <ul class="pagination">
                                    <li class="page-item page-item-left"><a class="page-link" href="#"><i
                                                class="fas fa-angle-left"></i></a></li>
                                    <li class="page-item page-item-middle"><a class="page-link" href="#"></a></li>
                                    <li class="page-item page-item-right"><a class="page-link" href="#"><i
                                                class="fas fa-angle-right"></i></a></li>
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mobileMove">
                        <div class="single widget storeInfo ">
                            <div class="widget-boxed">
                                <div class="widget-boxed-body" style="padding: 0 !important">
                                    <div class="sidebar-widget author-widget2">

                                        <table class="table homes-content" style="margin-bottom: 0 !important">
                                            <tbody>
                                                {{-- <tr style="border-top: none !important">
                                                    <td style="border-top: none !important">
                                                        <span class="det" style="color: #EC2F2E !important;">
                                                            {!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}
                                                            @if ($project->neighbourhood)
                                                                {!! ' / ' . optional($project->neighbourhood)->mahalle_title !!}
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr> --}}
                                                <tr style="border-top: none !important">
                                                    <td style="border-top: none !important">
                                                        <span class="autoWidthTr">İlan No:</span>
                                                        <span class="det" style="color: #274abb !important;">
                                                            {{ $project->id + 1000000 }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="autoWidthTr">İlan Tarihi:</span>
                                                        <span class="det" style="color: #274abb !important;">
                                                            {{ date('j', strtotime($project->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($project->created_at))) . ' ' . date('Y', strtotime($project->created_at)) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="autoWidthTr">Kimden:</span>
                                                        <span class="det" style="color: #274abb !important;">
                                                            {{ $project->user->corporate_type == 'Emlak Ofisi' ? 'Gayrimenkul Ofisi' : $project->user->corporate_type }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @if ($project->user->phone)
                                                    <tr>
                                                        <td>
                                                            <span class="autoWidthTr">İş:</span>
                                                            <span class="det">
                                                                <a style="text-decoration: none;color:#274abb;"
                                                                    href="tel:{!! $project->user->phone !!}">{!! $project->user->phone !!}</a>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($project->user->mobile_phone)
                                                    <tr>
                                                        <td>
                                                            <span class="autoWidthTr">Cep :</span>
                                                            <span class="det">
                                                                <a style="text-decoration: none;color:#274abb;"
                                                                    href="tel:{!! $project->user->mobile_phone !!}">{!! $project->user->mobile_phone !!}</a>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td>
                                                        <span class="autoWidthTr">Proje Durumu:</span>
                                                        <span class="det"
                                                            style="color: black;">{{ $status->name }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong class="autoWidthTr">Mağaza:</strong>
                                                        <span class="det"
                                                            style="color: black;">{!! $project->user->name !!}</span>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td colspan="2">
                                                        <strong class="autoWidthTr"><span>E-Posta:</span></strong>
                                                        <span class="det"
                                                            style="color: black;">{!! $project->user->email !!}</span>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td colspan="2">
                                                        <strong class="autoWidthTr"><span>
                                                                @if ($project->neighbourhood)
                                                                    {!! 'İl-İlçe-Mahalle:' !!}
                                                                @else
                                                                    {!! 'İl-İlçe:' !!}
                                                                @endif
                                                            </span></strong>
                                                        <span class="det"
                                                            style="color: black;font-size:10px !important">
                                                            {!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}
                                                            @if ($project->neighbourhood)
                                                                {!! ' / ' . optional($project->neighbourhood)->mahalle_title !!}
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="autoWidthTr">Yapımcı Firma:</span>
                                                        <span class="det"
                                                            style="color: black;">{{ $project->create_company ? $project->create_company : 'Belirtilmedi' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="autoWidthTr">Ada:</span>
                                                        <span class="det"
                                                            style="color: black;">{{ $project->island ? $project->island : 'Belirtilmedi' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="autoWidthTr">Parsel:</span>
                                                        <span class="det"
                                                            style="color: black;">{{ $project->parcel ? $project->parcel : 'Belirtilmedi' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="autoWidthTr">Başlangıç Tarihi:</span>
                                                        <span class="det" style="color: black;">
                                                            {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d.m.Y') : 'Belirtilmedi' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="autoWidthTr">Bitiş Tarihi:</span>
                                                        <span class="det" style="color: black;">
                                                            {{ $project->project_end_date ? \Carbon\Carbon::parse($project->project_end_date)->format('d.m.Y') : 'Belirtilmedi' }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <span class="autoWidthTr">Toplam Proje Alanı m<sup>2</sup>:</span>
                                                        <span class="det"
                                                            style="color: black;">{{ $project->total_project_area ? $project->total_project_area : 'Belirtilmedi' }}</span>
                                                    </td>
                                                </tr>
                                                {{-- @if ($shareSaleCheck)
                                                    <tr>
                                                        <td colspan="2">
                                                            <strong class="autoWidthTr">
                                                                <span>Toplam
                                                                    Hisse Sayısı:
                                                                </span>
                                                            </strong>
                                                            <span class="det" style="color: black;">{{ $project->numberOfSharesCount }}</span>
                                                        </td>
                                                    </tr>
                                                @endif --}}
                                                @if (
                                                    (isset($projectHousingsList[1]['share_sale[]']) && $projectHousingsList[1]['share_sale[]'] != '[]') ||
                                                        (isset($projectHousingsList[1]['share-sale[]']) && $projectHousingsList[1]['share-sale[]'] != '[]'))
                                                @else
                                                    <tr>
                                                        <td colspan="2">
                                                            <strong class="autoWidthTr"><span>Toplam
                                                                    {{ ucfirst($project->step1_slug) }}
                                                                    Sayısı:
                                                                </span></strong>
                                                            <span class="det"
                                                                style="color: black;">{{ $project->room_count }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <strong class="autoWidthTr"><span>Satışa Açık
                                                                    @if (isset($projectHousingsList[1]['share-sale[]']) && $projectHousingsList[1]['share-sale[]'] != '[]')
                                                                        Hisse
                                                                    @else
                                                                        {{ ucfirst($project->step1_slug) }}
                                                                    @endif
                                                                    Sayısı:
                                                                </span></strong>
                                                            <span class="det"
                                                                style="color: black;">{{ $project->room_count - $project->cartOrders - $salesCloseProjectHousingCount }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <strong class="autoWidthTr"><span>Satılan
                                                                    @if (isset($projectHousingsList[1]['share-sale[]']) && $projectHousingsList[1]['share-sale[]'] != '[]')
                                                                        Hisse
                                                                    @else
                                                                        {{ ucfirst($project->step1_slug) }}
                                                                    @endif
                                                                    Sayısı:
                                                                </span></strong>
                                                            <span class="det"
                                                                style="color: black;">{{ $project->cartOrders }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <strong class="autoWidthTr"><span>Satışa Kapalı
                                                                    @if (isset($projectHousingsList[1]['share-sale[]']) && $projectHousingsList[1]['share-sale[]'] != '[]')
                                                                        Hisse
                                                                    @else
                                                                        {{ ucfirst($project->step1_slug) }}
                                                                    @endif
                                                                    Sayısı:
                                                                </span></strong>
                                                            <span class="det"
                                                                style="color: black;">{{ $salesCloseProjectHousingCount }}</span>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>

                                        </table>


                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    @php
        function getData($project, $key, $roomOrder)
        {
            foreach ($project->roomInfo as $room) {
                if ($room->room_order == $roomOrder && $room->name == $key) {
                    return $room;
                }
            }
        }
    @endphp


    <section class="single-proper blog details bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="contact-tab" data-bs-toggle="tab"
                                data-bs-target="#contact" type="button" role="tab" aria-controls="contact"
                                aria-selected="false">Projedeki
                                Konutlar</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                type="button" role="tab" aria-controls="home"
                                aria-selected="true">Açıklama</button>
                        </li>
                        <li class="nav-item d-lg-none" role="presentation">
                            <button class="nav-link" id="general-tab" data-bs-toggle="tab" data-bs-target="#general"
                                type="button" role="tab" aria-controls="general" aria-selected="true">Genel
                                Bilgi</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab" aria-controls="profile"
                                aria-selected="false">Özellikler</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#map"
                                type="button" role="tab" aria-controls="contact"
                                aria-selected="false">Harita</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="situation-tab" data-bs-toggle="tab" data-bs-target="#situation"
                                type="button" role="tab" aria-controls="situation"
                                aria-selected="false">Vaziyet&Kat Planı</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="comment-tab" data-bs-toggle="tab"
                                data-bs-target="#projectComment" type="button" role="tab" aria-controls="comment"
                                aria-selected="false">Yorumlar</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="commentSend-tab" data-bs-toggle="tab"
                                data-bs-target="#commentSend" type="button" role="tab" aria-controls="commentSend"
                                aria-selected="false">Değerlendir</button>
                        </li>

                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane d-lg-none fade blog-info details mb-30 single homes-content" id="general"
                            role="tabpanel" aria-labelledby="general-tab">

                            <table class="table" style="margin-bottom: 0 !important">
                                <tbody class="trStyle">
                                    <tr>
                                        <td>
                                            <span class="det" style="color: #EC2F2E !important;">
                                                {!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}
                                                @if ($project->neighbourhood)
                                                    {!! ' / ' . optional($project->neighbourhood)->mahalle_title !!}
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="autoWidthTr">İlan No:</span>
                                            <span class="det" style="color: #274abb !important;">
                                                {{ $project->id + 1000000 }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="autoWidthTr">İlan Tarihi:</span>
                                            <span class="det" style="color: #274abb !important;">
                                                {{ date('j', strtotime($project->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($project->created_at))) . ' ' . date('Y', strtotime($project->created_at)) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="autoWidthTr">Kimden:</span>
                                            <span class="det" style="color: #274abb !important;">
                                                {{ $project->user->corporate_type == 'Emlak Ofisi' ? 'Gayrimenkul Ofisi' : $project->user->corporate_type }}
                                            </span>
                                        </td>
                                    </tr>
                                    @if ($project->user->phone)
                                        <tr>
                                            <td>
                                                <span class="autoWidthTr">İş:</span>
                                                <span class="det">
                                                    <a style="text-decoration: none;color:#274abb;"
                                                        href="tel:{!! $project->user->phone !!}">{!! $project->user->phone !!}</a>
                                                </span>
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($project->user->mobile_phone)
                                        <tr>
                                            <td>
                                                <span class="autoWidthTr">Cep :</span>
                                                <span class="det">
                                                    <a style="text-decoration: none;color:#274abb;"
                                                        href="tel:{!! $project->user->mobile_phone !!}">{!! $project->user->mobile_phone !!}</a>
                                                </span>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>
                                            <span class="autoWidthTr">Proje Durumu:</span>
                                            <span class="det" style="color: black;">{{ $status->name }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong class="autoWidthTr">Mağaza:</strong>
                                            <span class="det" style="color: black;">{!! $project->user->name !!}</span>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td colspan="2">
                                            <strong class="autoWidthTr"><span>E-Posta:</span></strong>
                                            <span class="det" style="color: black;">{!! $project->user->email !!}</span>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td colspan="2">
                                            <strong class="autoWidthTr"><span>
                                                    @if ($project->neighbourhood)
                                                        {!! 'İl-İlçe-Mahalle:' !!}
                                                    @else
                                                        {!! 'İl-İlçe:' !!}
                                                    @endif
                                                </span></strong>
                                            <span class="det" style="color: black;font-size:10px !important">
                                                {!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}
                                                @if ($project->neighbourhood)
                                                    {!! ' / ' . optional($project->neighbourhood)->mahalle_title !!}
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="autoWidthTr">Yapımcı Firma:</span>
                                            <span class="det"
                                                style="color: black;">{{ $project->create_company ? $project->create_company : 'Belirtilmedi' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="autoWidthTr">Ada:</span>
                                            <span class="det"
                                                style="color: black;">{{ $project->island ? $project->island : 'Belirtilmedi' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="autoWidthTr">Parsel:</span>
                                            <span class="det"
                                                style="color: black;">{{ $project->parcel ? $project->parcel : 'Belirtilmedi' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="autoWidthTr">Başlangıç Tarihi:</span>
                                            <span class="det" style="color: black;">
                                                {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d.m.Y') : 'Belirtilmedi' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="autoWidthTr">Bitiş Tarihi:</span>
                                            <span class="det" style="color: black;">
                                                {{ $project->project_end_date ? \Carbon\Carbon::parse($project->project_end_date)->format('d.m.Y') : 'Belirtilmedi' }}
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <span class="autoWidthTr">Toplam Proje Alanı m<sup>2</sup>:</span>
                                            <span class="det"
                                                style="color: black;">{{ $project->total_project_area ? $project->total_project_area : 'Belirtilmedi' }}</span>
                                        </td>
                                    </tr>
                                    {{-- @if ($shareSaleCheck)
                                        <tr>
                                            <td colspan="2">
                                                <strong class="autoWidthTr">
                                                    <span>Toplam
                                                        Hisse Sayısı:
                                                    </span>
                                                </strong>
                                                <span class="det" style="color: black;">{{ $project->numberOfSharesCount }}</span>
                                            </td>
                                        </tr>
                                    @endif --}}
                                    <tr>
                                        <td colspan="2">
                                            <strong class="autoWidthTr"><span>Toplam
                                                    {{ ucfirst($project->step1_slug) }}
                                                    Sayısı:
                                                </span></strong>
                                            <span class="det" style="color: black;">{{ $project->room_count }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong class="autoWidthTr"><span>Satışa Açık
                                                    @if (isset($projectHousingsList[1]['share-sale[]']) && $projectHousingsList[1]['share-sale[]'] != '[]')
                                                        Hisse
                                                    @else
                                                        {{ ucfirst($project->step1_slug) }}
                                                    @endif
                                                    Sayısı:
                                                </span></strong>
                                            <span class="det"
                                                style="color: black;">{{ $project->room_count - $project->cartOrders - $salesCloseProjectHousingCount }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong class="autoWidthTr"><span>Satılan
                                                    @if (isset($projectHousingsList[1]['share-sale[]']) && $projectHousingsList[1]['share-sale[]'] != '[]')
                                                        Hisse
                                                    @else
                                                        {{ ucfirst($project->step1_slug) }}
                                                    @endif
                                                    Sayısı:
                                                </span></strong>
                                            <span class="det" style="color: black;">{{ $project->cartOrders }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong class="autoWidthTr"><span>Satışa Kapalı
                                                    @if (isset($projectHousingsList[1]['share-sale[]']) && $projectHousingsList[1]['share-sale[]'] != '[]')
                                                        Hisse
                                                    @else
                                                        {{ ucfirst($project->step1_slug) }}
                                                    @endif
                                                    Sayısı:
                                                </span></strong>
                                            <span class="det"
                                                style="color: black;">{{ $salesCloseProjectHousingCount }}</span>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>


                        </div>
                        <div class="tab-pane fade blog-info details mb-30" id="profile" role="tabpanel"
                            aria-labelledby="profile-tab">
                            <div class="similar-property featured portfolio p-0 bg-white">

                                <div class="single homes-content">
                                    <table class="table">
                                        <tbody class="trStyle">
                                            <tr>
                                                <td>
                                                    <span class="mr-1">İlan No:</span>
                                                    <span class="det" style="color: #274abb;">
                                                        {{ $project->id + 1000000 }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="mr-1">Ada:</span>
                                                    <span class="det" style="color: #274abb;">
                                                        {{ $project->island ? $project->island : 'Belirtilmedi' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="mr-1">Parsel:</span>
                                                    <span class="det" style="color: #274abb;">
                                                        {{ $project->parcel ? $project->parcel : 'Belirtilmedi' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="mr-1">Başlangıç Tarihi:</span>
                                                    <span class="det" style="color: #274abb;">
                                                        {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d.m.Y') : 'Belirtilmedi' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="mr-1">Bitiş Tarihi:</span>
                                                    <span class="det" style="color: #274abb;">
                                                        {{ $project->project_end_date ? \Carbon\Carbon::parse($project->project_end_date)->format('d.m.Y') : 'Belirtilmedi' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="mr-1">Toplam Proje Alanı m<sup>2</sup>:</span>
                                                    <span class="det" style="color: #274abb;">
                                                        {{ $project->total_project_area ? $project->total_project_area : 'Belirtilmedi' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <strong class="autoWidthTr"><span>Toplam
                                                            {{ ucfirst($project->step1_slug) }}
                                                            Sayısı:
                                                        </span></strong>
                                                    <span class="det"
                                                        style="color: black;">{{ $project->room_count }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <strong class="autoWidthTr"><span>Satışa Açık
                                                            @if (isset($projectHousingsList[1]['share-sale[]']) && $projectHousingsList[1]['share-sale[]'] != '[]')
                                                                Hisse
                                                            @else
                                                                {{ ucfirst($project->step1_slug) }}
                                                            @endif
                                                            Sayısı:
                                                        </span></strong>
                                                    <span class="det"
                                                        style="color: black;">{{ $project->room_count - $project->cartOrders - $salesCloseProjectHousingCount }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <strong class="autoWidthTr"><span>Satılan
                                                            @if (isset($projectHousingsList[1]['share-sale[]']) && $projectHousingsList[1]['share-sale[]'] != '[]')
                                                                Hisse
                                                            @else
                                                                {{ ucfirst($project->step1_slug) }}
                                                            @endif
                                                            Sayısı:
                                                        </span></strong>
                                                    <span class="det"
                                                        style="color: black;">{{ $project->cartOrders }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <strong class="autoWidthTr"><span>Satışa Kapalı
                                                            @if (isset($projectHousingsList[1]['share-sale[]']) && $projectHousingsList[1]['share-sale[]'] != '[]')
                                                                Hisse
                                                            @else
                                                                {{ ucfirst($project->step1_slug) }}
                                                            @endif
                                                            Sayısı:
                                                        </span></strong>
                                                    <span class="det"
                                                        style="color: black;">{{ $salesCloseProjectHousingCount }}</span>
                                                </td>
                                                {{-- @foreach ($projectHousingSetting as $housingSetting)
                                                @php
                                                    $isArrayCheck = $housingSetting->is_array;
                                                    $value = '';

                                                    if (isset($projectHousing[$housingSetting->column_name . '[]'])) {
                                                        $valueArray = json_decode(
                                                            $projectHousing[$housingSetting->column_name . '[]'][
                                                                'value'
                                                            ] ?? null,
                                                        );

                                                        if ($isArrayCheck && isset($valueArray)) {
                                                            $value = implodeData($valueArray);
                                                        } elseif ($housingSetting->is_parent_table) {
                                                            $value = $project[$housingSetting->column_name] ?? null;
                                                        } elseif ($project->roomInfo) {
                                                            foreach ($project->roomInfo as $roomInfo) {
                                                                if (
                                                                    $roomInfo->room_order == 1 &&
                                                                    $roomInfo['name'] ===
                                                                        $housingSetting->column_name . '[]'
                                                                ) {
                                                                    $value =
                                                                        $roomInfo['value'] == '["on"]'
                                                                            ? 'Evet'
                                                                            : ($roomInfo['value'] == '["off"]'
                                                                                ? 'Hayır'
                                                                                : $roomInfo['value']);
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    }
                                                @endphp

                                                @if (!$isArrayCheck && isset($value) && $value !== '' && $housingSetting->label != 'Fiyat' && $housingSetting->label != 'Günlük Fiyat' && $housingSetting->label != 'Peşin Fiyat' && $housingSetting->label != 'Taksitli Toplam Fiyat ')
                                                    <tr>
                                                        <td>
                                                            <span class="mr-1">{{ $housingSetting->label }}:</span>
                                                            <span
                                                                class="det">{{ $housingSetting->label == 'Fiyat' ? number_format($value, 0, ',', '.') : $value }}</span>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach --}}


                                        </tbody>
                                    </table>
                                    @foreach ($projectHousingSetting as $housingSetting)
                                        @php
                                            if (isset($projectHousing[$housingSetting->column_name . '[]'])) {
                                                $isArrayCheck = $housingSetting->is_array;
                                                $valueArray = json_decode(
                                                    $projectHousing[$housingSetting->column_name . '[]']['value'] ??
                                                        null,
                                                );

                                                if ($isArrayCheck && isset($valueArray) && $valueArray != null) {
                                                    echo "<div class='mt-5'><h5>{$projectHousing[$housingSetting->column_name .
                '[]']['key']}:</h5><ul class='homes-list clearfix checkSquareIcon'>";
                                                    foreach ($valueArray as $ozellik) {
                                                        echo "<li><i class='fa fa-check-square' aria-hidden='true'></i><span>{$ozellik}</span></li>";
                                                    }
                                                    echo '</ul></div>';
                                                }
                                            }
                                        @endphp
                                    @endforeach
                                </div>



                            </div>
                        </div>
                        <div class="tab-pane fade blog-info details mb-30 descriptionProject" id="home"
                            role="tabpanel" aria-labelledby="home-tab">
                            {!! $project->description !!}
                        </div>

                        <div class="tab-pane fade show active  blog-info details housingsListTab mb-30 " id="contact"
                            style="border: none !important;box-shadow: none !important; padding: 0 !important"
                            role="tabpanel" aria-labelledby="contact-tab">
                            @php
                                $housingTypeFormJson = json_decode($project->housingType->form_json);
                                $column1Order = array_search(
                                    $project->listItemValues->column1_name . '[]',
                                    array_column(json_decode($project->housingType->form_json), 'name'),
                                );
                                $column2Order = array_search(
                                    $project->listItemValues->column2_name . '[]',
                                    array_column(json_decode($project->housingType->form_json), 'name'),
                                );
                                $column3Order = array_search(
                                    $project->listItemValues->column3_name . '[]',
                                    array_column(json_decode($project->housingType->form_json), 'name'),
                                );
                            @endphp

                            @if ($project->have_blocks == 1)
                                <div class="ui-elements properties-right list featured portfolio blog pb-5 bg-white">
                                    <div class="container p-0">

                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 ">
                                                <div class="tabbed-content button-tabs">
                                                    <ul class="tabs">
                                                        @foreach ($project->blocks as $key => $block)
                                                            <li class="nav-item-block {{ $key == $blockIndex ? ' active' : '' }}"
                                                                role="presentation"
                                                                onclick="changeTabContent('{{ $block['id'] }}',{{ $key }})">
                                                                <div class="tab-title">
                                                                    <span>{{ $block['block_name'] }}</span>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    @foreach ($project->blocks as $blockKey => $block)
                                                        <div id="contentblock-{{ $block['id'] }}"
                                                            class="tab-content-block{{ $loop->first ? ' active' : '' }}"
                                                            block-id="{{ $block['id'] }}"
                                                            data-block-name="{{ $block['block_name'] }}">
                                                            @php
                                                                $blockHousingCount = $block['housing_count'];
                                                                $previousBlockHousingCount = 0;
                                                                $allCounts = 0;
                                                                $blockName = $block['block_name'];

                                                                if ($blockKey > 0) {
                                                                    $previousBlockHousingCount =
                                                                        $project->blocks[$blockKey - 1][
                                                                            'housing_count'
                                                                        ];
                                                                    $i = $previousBlockHousingCount;
                                                                    $lastHousingCount =
                                                                        $project->blocks[$blockKey - 1][
                                                                            'housing_count'
                                                                        ];
                                                                    for ($j = 0; $j < $blockKey; $j++) {
                                                                        if (
                                                                            isset($project->blocks[$j]) &&
                                                                            isset($project->blocks[$j]['housing_count'])
                                                                        ) {
                                                                            $allCounts +=
                                                                                $project->blocks[$j]['housing_count'];
                                                                        }
                                                                    }
                                                                } else {
                                                                    $i = 0;
                                                                }

                                                            @endphp
                                                            <div class="mobile-hidden">
                                                                <div class="container">
                                                                    <div class="row project-filter-reverse blog-pots"
                                                                        id="project-room{{ $blockKey }}">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mobile-show">
                                                                <div class=""
                                                                    id="project-room-mobile{{ $blockKey }}">

                                                                </div>
                                                            </div>
                                                            <div class="ajax-load" style="display: none;">
                                                                Yükleniyor...
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="properties-right list featured portfolio blog pb-5 bg-white">
                                    <div class="mobile-hidden">
                                        <div class="container p-0">
                                            @php
                                                $blockName = null;
                                            @endphp
                                            <div class="row" style="margin-bottom:10px">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-3 pr-0">
                                                            <div
                                                                style="background:#ea2b2e;width: 100%;height: 100%;border-top-left-radius: 7px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="row" style="width: 102%;">
                                                                <div class="col-md-9"
                                                                    style="background:#ea2b2e;color:#fff;padding : 5px 15px;">
                                                                    @if ($project->id == 434 || $project->id == 433 || $project->id == 431)
                                                                        <div class="d-flex">
                                                                            <li style="width:20%;list-style:none;">Oda
                                                                                Sayısı</li>
                                                                            <li style="width:20%;list-style:none;">Oda Tipi
                                                                            </li>
                                                                            <li style="width:20%;list-style:none;">İl/İlçe
                                                                            </li>
                                                                            <li style="width:20%;list-style:none;">Eklenme
                                                                                Tarihi</li>
                                                                            <li
                                                                                style="width:20%;display:flex;justify-content:center">
                                                                                Fiyat</li>
                                                                        </div>
                                                                    @else
                                                                        <div class="d-flex">
                                                                            <li style="width:20%;list-style:none;">
                                                                                {{ $housingTypeFormJson[$column1Order]->label }}
                                                                            </li>
                                                                            <li style="width:20%;list-style:none;">
                                                                                {{ $housingTypeFormJson[$column2Order]->label }}
                                                                            </li>
                                                                            @if ($project->listItemValues->column3_name)
                                                                                <li style="width:20%;list-style:none;">
                                                                                    {{ $housingTypeFormJson[$column3Order]->label }}
                                                                                </li>
                                                                            @endif
                                                                            <li style="width:20%;list-style:none;">Eklenme
                                                                                Tarihi</li>
                                                                            <li
                                                                                style="width:20%;display:flex;justify-content:center">
                                                                                Fiyat</li>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-3"
                                                                    style="background:#ea2b2e;width: 100%;height: 26px;border-bottom-right-radius: 7px;">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row project-filter-reverse blog-pots w-100 m-auto"
                                                id="project-room">
                                                @for ($i = 0; $i < min($project->room_count, 10); $i++)
                                                    @php

                                                        if (isset($projectCartOrders[$i + 1])) {
                                                            $sold = $projectCartOrders[$i + 1];
                                                        } else {
                                                            $sold = null;
                                                        }
                                                        $allCounts = 0;
                                                        $blockHousingCount = 0;
                                                        $previousBlockHousingCount = 0;
                                                        $key = 0;
                                                        $isUserSame =
                                                            isset($projectCartOrders[$i + 1]) &&
                                                            (Auth::check()
                                                                ? $projectCartOrders[$i + 1]->user_id ==
                                                                    Auth::user()->id
                                                                : false);

                                                        $projectOffer = App\Models\Offer::where('type', 'project')
                                                            ->where('project_id', $project->id)
                                                            ->where(function ($query) use ($i) {
                                                                $query
                                                                    ->orWhereJsonContains('project_housings', [$i + 1])
                                                                    ->orWhereJsonContains(
                                                                        'project_housings',
                                                                        (string) ($i + 1),
                                                                    ); // Handle as string as JSON might store values as strings
                                                            })
                                                            ->where('start_date', '<=', now())
                                                            ->where('end_date', '>=', now())
                                                            ->first();

                                                        $projectDiscountAmount = $projectOffer
                                                            ? $projectOffer->discount_amount
                                                            : 0;

                                                        $statusSlug = $status->slug;
                                                    @endphp


                                                    <x-project-item-card :project="$project" :allCounts="$allCounts"
                                                        :blockStart="0" :towns="$towns" :cities="$cities"
                                                        :key="$key" :statusSlug="$statusSlug" :blockName="$blockName"
                                                        :blockHousingCount="$blockHousingCount" :previousBlockHousingCount="$previousBlockHousingCount" :sumCartOrderQt="$sumCartOrderQt"
                                                        :isUserSame="$isUserSame" :bankAccounts="$bankAccounts" :i="$i"
                                                        :projectHousingsList="$projectHousingsList" :projectDiscountAmount="$projectDiscountAmount" :sold="$sold"
                                                        :lastHousingCount="$lastHousingCount" />
                                                @endfor
                                            </div>
                                            <div class="ajax-load" style="display: none;">
                                                Yükleniyor...
                                            </div>

                                        </div>
                                    </div>
                                    <div class="mobile-show">
                                        <div class="container p-0">
                                            <div id="project-room-mobile">
                                                @for ($i = 0; $i < min($project->room_count, 10); $i++)
                                                    @php
                                                        $sold = isset($projectCartOrders[$i + 1])
                                                            ? $projectCartOrders[$i + 1]
                                                            : null;

                                                        $room_order = $i + 1;
                                                        $allCounts = 0;
                                                        $blockHousingCount = 0;
                                                        $previousBlockHousingCount = 0;
                                                        $key = 0;
                                                        $isUserSame =
                                                            isset($projectCartOrders[$i + 1]) &&
                                                            (Auth::check()
                                                                ? $projectCartOrders[$i + 1]->user_id ==
                                                                    Auth::user()->id
                                                                : false);

                                                        $projectOffer = App\Models\Offer::where('type', 'project')
                                                            ->where('project_id', $project->id)
                                                            ->where(function ($query) use ($i) {
                                                                $query
                                                                    ->orWhereJsonContains('project_housings', [$i + 1])
                                                                    ->orWhereJsonContains(
                                                                        'project_housings',
                                                                        (string) ($i + 1),
                                                                    ); // Handle as string as JSON might store values as strings
                                                            })
                                                            ->where('start_date', '<=', now())
                                                            ->where('end_date', '>=', now())
                                                            ->first();
                                                        $projectDiscountAmount = $projectOffer
                                                            ? $projectOffer->discount_amount
                                                            : 0;

                                                        $statusSlug = $status->slug;
                                                    @endphp
                                                    <x-project-item-mobile-card :towns="$towns" :cities="$cities"
                                                        :blockStart="0" :blockName="$blockName" :project="$project"
                                                        :allCounts="$allCounts" :statusSlug="$statusSlug" :key="$key"
                                                        :blockHousingCount="$blockHousingCount" :previousBlockHousingCount="$previousBlockHousingCount" :sumCartOrderQt="$sumCartOrderQt"
                                                        :isUserSame="$isUserSame" :bankAccounts="$bankAccounts" :i="$i"
                                                        :projectHousingsList="$projectHousingsList" :projectDiscountAmount="$projectDiscountAmount" :sold="$sold"
                                                        :lastHousingCount="$lastHousingCount" />
                                                @endfor
                                            </div>
                                            <div class="ajax-load" style="display: none;">
                                                Yükleniyor...
                                            </div>
                                        </div>

                                    </div>



                                </div>
                            @endif

                        </div>
                        <div class="tab-pane fade  blog-info details mb-30" id="map" role="tabpanel"
                            aria-labelledby="contact-tab">
                            <iframe width="100%" height="100%" frameborder="0" style="border:0;"
                                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&q={{ explode(',', $project->location)[0] }},{{ explode(',', $project->location)[1] }}"
                                allowfullscreen="">
                            </iframe>
                        </div>
                        <div class="tab-pane fade blog-info details mb-30" id="situation" role="tabpanel"
                            aria-labelledby="situation-tab">
                            <div class="situation-images-project">
                                <div class="row w-100 m-auto">
                                    @if ($project->situations && count($project->situations) > 0)
                                        @foreach ($project->situations as $situation)
                                            <div class="col-md-4 mb-2">
                                                <a href="{{ URL::to('/') . '/' . str_replace('public/', '', $situation->situation) }}"
                                                    data-lightbox="image-gallery1"> <img
                                                        style="height: 100%;object-fit: contain"
                                                        src="{{ URL::to('/') }}/{{ str_replace('public/', '', $situation->situation) }}"
                                                        alt=""></a>

                                            </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-danger w-100" style="color:#fff;">
                                            Vaziyet planı belirtilmedi
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade  blog-info details mb-30" id="projectComment" role="tabpanel"
                            aria-labelledby="contact-tab">
                            @if (count($projectComments))
                                @php
                                    // Initialize rating counts array
                                    $ratingCounts = [0, 0, 0, 0, 0];

                                    // Populate rating counts based on comments
                                    foreach ($projectComments as $comment) {
                                        if ($comment->rate >= 1 && $comment->rate <= 5) {
                                            $ratingCounts[$comment->rate - 1]++;
                                        }
                                    }

                                    // Calculate total number of reviews and comments
                                    $totalReviews = array_sum($ratingCounts);
                                    $totalComments = $projectComments->count();

                                    // Calculate rating percentages
                                    $ratingPercentages = array_map(function ($count) use ($totalReviews) {
                                        return $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                    }, $ratingCounts);

                                    // Calculate average rating
                                    $averageRating = $totalReviews
                                        ? array_sum(
                                                array_map(
                                                    function ($rate, $index) use ($ratingCounts) {
                                                        return $rate * $ratingCounts[$index];
                                                    },
                                                    [1, 2, 3, 4, 5],
                                                    array_keys($ratingCounts),
                                                ),
                                            ) / $totalReviews
                                        : 0;

                                    // Calculate width for the average rating star display
                                    $averageRatingWidth = ($averageRating / 5) * 100;
                                @endphp
                                <div class="ps-ratings">
                                    <div class="ps-ratings__stars">

                                        <div class="ps-ratings__count-text">{{ number_format($averageRating, 1) }}
                                        </div>
                                        <div class="ps-ratings__average">
                                            <div>Ortalama</div>
                                            <div>Puan</div>
                                        </div>
                                    </div>

                                    <div class="ps-ratings__counts">
                                        <div class="ps-ratings__count">
                                            <div>{{ number_format($totalReviews) }} Değerlendirme</div>
                                        </div>
                                        <div class="ps-ratings__divider">•</div>
                                        <div class="ps-ratings__count">
                                            <div>{{ number_format($totalComments) }} Yorum</div>
                                        </div>
                                    </div>
                                </div>

                                <hr />
                                <div style="margin-top: 20.5px;"><span
                                        class="product-review-section-wrapper__wrapper__filter_title">Puana
                                        Göre Filtrele</span>
                                    <div class="product-review-section-wrapper__wrapper__product-rating-filters mb-5">

                                        <!-- Create an array to store counts for each rating (1-5) -->
                                        @php
                                            $ratingCounts = [0, 0, 0, 0, 0];
                                        @endphp

                                        @foreach ($projectComments as $comment)
                                            @if ($comment->rate >= 1 && $comment->rate <= 5)
                                                <!-- Increment the corresponding rating count -->
                                                @php
                                                    $ratingCounts[$comment->rate - 1]++;
                                                @endphp
                                            @endif
                                        @endforeach

                                        @foreach ([5, 4, 3, 2, 1] as $rating)
                                            <div class="product-rating-count-container"
                                                style="border: 1px solid rgb(230, 230, 230);">

                                                <div class="product-rating-count-container__star">
                                                    <div class="star-ratings" title="{{ $rating }} Stars"
                                                        style="position: relative; box-sizing: border-box; display: inline-block;">
                                                        @for ($i = 0; $i < $rating; $i++)
                                                            <div class="star-container"
                                                                style="position: relative; display: inline-block; vertical-align: middle; padding-right: 2px;">
                                                                <svg viewBox="0 0 14 14" class="widget-svg"
                                                                    style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                                                    <path class="star"
                                                                        d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                                        style="fill: rgb(255, 192, 0); transition: fill 0.2s ease-in-out 0s;">
                                                                    </path>
                                                                </svg>
                                                            </div>
                                                        @endfor
                                                        @for ($i = $rating; $i < 5; $i++)
                                                            <div class="star-container"
                                                                style="position: relative; display: inline-block; vertical-align: middle; padding-right: 2px;">
                                                                <svg viewBox="0 0 14 14" class="widget-svg"
                                                                    style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                                                    <path class="star"
                                                                        d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                                        style="fill: rgb(203, 211, 227); transition: fill 0.2s ease-in-out 0s;">
                                                                    </path>
                                                                </svg>
                                                            </div>
                                                        @endfor
                                                    </div>
                                                    <span class="product-rating-count-container__count">
                                                        ({{ $ratingCounts[$rating - 1] }})
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>

                                </div>
                                <span class="product-review-section-wrapper__wrapper__filter_title">Fotoğraflı
                                    Değerlendirmeler</span>
                                <div class="slick-agentsc mt-3 mb-3" style="padding: 0 50px">
                                    @foreach ($projectComments as $comment)
                                        @if (json_decode($comment->images, true) > 0)
                                            @foreach (json_decode($comment->images, true) as $img)
                                                <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                                                    <div class="landscapes">
                                                        <div class="project-single">
                                                            <div class="project-inner project-head">
                                                                <div class="homes">
                                                                    <a href="{{ asset('storage/' . preg_replace('@^public/@', null, $img)) }}"
                                                                        data-lightbox="gallery">
                                                                        <img src="{{ asset('storage/' . preg_replace('@^public/@', null, $img)) }}"
                                                                            style="object-fit: cover;width:100%;height:150px" />
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <!-- homes content -->

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <span>Bu konut için fotoğraflı değerlendirme yapılmadı.</span>
                                        @endif
                                    @endforeach
                                </div>

                                <span class="product-review-section-wrapper__wrapper__filter_title">
                                    Değerlendirmeler</span>
                                <div class="flex flex-col gap-6 mt-3">
                                    @foreach ($projectComments as $comment)
                                        <div class="bg-white border rounded-md pb-3 mb-3"
                                            @if (!$loop->last) style="border-bottom: 1px solid #E6E6E6 !important; " @endif>

                                            <div class="ml-auto order-2 mt-3 mb-3">
                                                @for ($i = 0; $i < $comment->rate; ++$i)
                                                    <svg enable-background="new 0 0 50 50" height="15px" id="Layer_1"
                                                        version="1.1" viewBox="0 0 50 50" width="15px"
                                                        xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                        <rect fill="none" height="50" width="50" />
                                                        <polygon fill="gold"
                                                            points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                            stroke="gold" stroke-miterlimit="10" stroke-width="2" />
                                                    </svg>
                                                @endfor
                                                @for ($i = 0; $i < 5 - $comment->rate; ++$i)
                                                    <svg enable-background="new 0 0 50 50" height="15px" id="Layer_1"
                                                        version="1.1" viewBox="0 0 50 50" width="15px"
                                                        xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                        <rect fill="none" height="50" width="50" />
                                                        <polygon fill="none"
                                                            points="25,3.553 30.695,18.321 46.5,19.173   34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                            stroke="gold" stroke-miterlimit="10" stroke-width="2" />
                                                    </svg>
                                                @endfor
                                            </div>
                                            <div class="head d-flex w-full">
                                                <div>
                                                    <div class="">{{ $comment->user->name }}</div>
                                                    <i
                                                        class="small"><?= strftime('%d %B %A', strtotime($comment->created_at)) ?></i>
                                                </div>
                                            </div>
                                            <div class="body py-3">
                                                {{ $comment->comment }}
                                            </div>
                                            <div class="row mt-3">
                                                @foreach (json_decode($comment->images, true) as $img)
                                                    <div class="col-md-1 col-3 mt-3">
                                                        <a href="<?= asset('storage/' . preg_replace('@^public/@', null, $img)) ?>"
                                                            data-lightbox="gallery">
                                                            <img src="<?= asset('storage/' . preg_replace('@^public/@', null, $img)) ?>"
                                                                style="object-fit: cover;width:100%" />
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span>Bu mağaza için henüz yorum yapılmadı.</span>
                            @endif

                        </div>
                        <div class="tab-pane fade  blog-info details mb-30" id="commentSend" role="tabpanel"
                            aria-labelledby="commentSend-tab">
                            @if (checkIfUserCanAddToCart($project->id))
                                <form id="commentForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="rate" id="rate" />
                                    <h5>Yeni Yorum Ekle</h5>

                                    <div class="d-flex align-items-center w-full" style="gap: 6px;">
                                        <div class="d-flex rating-area">
                                            <svg class="rating" enable-background="new 0 0 50 50" height="24px"
                                                id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px"
                                                xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <rect fill="none" height="50" width="50" />
                                                <polygon class="rating-polygon" fill="none"
                                                    points="25,3.553 30.695,18.321 46.5,19.173 34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                    stroke="#717171" stroke-miterlimit="10" stroke-width="2" />
                                            </svg>
                                            <svg class="rating" enable-background="new 0 0 50 50" height="24px"
                                                id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px"
                                                xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <rect fill="none" height="50" width="50" />
                                                <polygon class="rating-polygon" fill="none"
                                                    points="25,3.553 30.695,18.321 46.5,19.173 34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                    stroke="#717171" stroke-miterlimit="10" stroke-width="2" />
                                            </svg>
                                            <svg class="rating" enable-background="new 0 0 50 50" height="24px"
                                                id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px"
                                                xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <rect fill="none" height="50" width="50" />
                                                <polygon class="rating-polygon" fill="none"
                                                    points="25,3.553 30.695,18.321 46.5,19.173 34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                    stroke="#717171" stroke-miterlimit="10" stroke-width="2" />
                                            </svg>
                                            <svg class="rating" enable-background="new 0 0 50 50" height="24px"
                                                id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px"
                                                xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <rect fill="none" height="50" width="50" />
                                                <polygon class="rating-polygon" fill="none"
                                                    points="25,3.553 30.695,18.321 46.5,19.173 34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                    stroke="#717171" stroke-miterlimit="10" stroke-width="2" />
                                            </svg>
                                            <svg class="rating" enable-background="new 0 0 50 50" height="24px"
                                                id="Layer_1" version="1.1" viewBox="0 0 50 50" width="24px"
                                                xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <rect fill="none" height="50" width="50" />
                                                <polygon class="rating-polygon" fill="none"
                                                    points="25,3.553 30.695,18.321 46.5,19.173 34.214,29.152 38.287,44.447 25,35.848 11.712,44.447 15.786,29.152 3.5,19.173 19.305,18.321 "
                                                    stroke="#717171" stroke-miterlimit="10" stroke-width="2" />
                                            </svg>
                                        </div>
                                        <div class="ml-auto">
                                            <input type="file" style="display: none;" class="fileinput"
                                                name="images[]" multiple accept="image/*" />
                                            <button type="button" class="btn btn-primary q-button"
                                                id="selectImageButton">Resimleri Seç</button>
                                        </div>
                                    </div>
                                    <textarea name="comment" rows="10" class="form-control mt-4" placeholder="Yorum girin..." required
                                        style="padding: 10px !important;height: 100px !important;"></textarea>
                                    <button type="button" class="ud-btn btn-white2 mt-3" onclick="submitForm()">Yorumu
                                        Gönder<i class="fal fa-arrow-right-long"></i></button>
                                    <div id="previewContainer"
                                        style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;"></div>

                                </form>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
    </section>

    <div id="loadingOverlay">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="applySampleModal" tabindex="-1" aria-labelledby="applySampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <img loading="lazy" src="{{ asset('images/apply-popup.jpg') }}" class="img-fluid blur-up lazyloaded"
                        alt="" style="width:100%;height:100%;cursor:pointer">
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary fixed-button" data-bs-toggle="modal" data-bs-target="#applyNowModal">
        Hemen Başvur
    </button>
    <!-- Modal -->
    <div class="modal fade" id="applyNowModal" tabindex="-1" aria-labelledby="applyNowModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyNowModalLabel">Başvuru Formu</h5>
                    <button type="button" class="close applyNowModalClose" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="applyNowForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Ad</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="surname">Soyad</label>
                            <input type="text" class="form-control" id="surname" name="surname" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-posta</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Telefon</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="title">Başlık</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <input type="hidden" name="project_id" value="{{ $project->id }}">

                        <button type="submit" class="btn btn-primary">Gönder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&callback=initMap"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        function editComment(commentId) {
            $.ajax({
                url: `{{ url('get-project-comment') }}/${commentId}`,
                type: 'GET',
                success: function(response) {
                    Swal.fire({
                        title: 'Yorumu Düzenle',
                        html: `
                            <form id="edit-comment-form">
                                <input type="hidden" name="id" value="${response.data.id}">
                              
                                <div class="form-group">
                                    <label for="comment">Yorumunuz/label>
                                    <textarea id="comment" name="comment" class="form-control" style="height:125px !important>${response.data.comment}</textarea>
                                </div>
                            </form>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Güncelle',
                        cancelButtonText: 'İptal',
                        preConfirm: () => {
                            const formData = new FormData(document.getElementById(
                                'edit-comment-form'));
                            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                            return $.ajax({
                                url: "{{ route('project.update-comment') }}",
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    Swal.fire('Başarılı!',
                                        'Yorum başarıyla güncellendi.', 'success');
                                    location.reload(); // Reload the page
                                },
                                error: function(error) {
                                    Swal.fire('Hata!',
                                        'Yorum güncellenirken bir hata oluştu.',
                                        'error');
                                }
                            });
                        }
                    });
                },
                error: function(error) {
                    Swal.fire('Hata!', 'Yorum bilgileri alınırken bir hata oluştu.', 'error');
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            // Yıldızlara fare ile gelindiğinde
            $('.rating-area .rating').on('mouseover', function() {
                var index = $(this).index();
                $('.rating-area .rating-polygon').each(function(i) {
                    $(this).attr('fill', i <= index ? 'gold' : 'none');
                    $(this).attr('stroke', i <= index ? 'gold' :
                        '#717171'); // Seçili yıldızların kenarlık rengini altın yap
                });
            });

            // Fare yıldızların üzerinden ayrıldığında
            $('.rating-area').on('mouseleave', function() {
                var selectedIndex = $('.rating-area .rating.selected').last().index();
                $('.rating-area .rating-polygon').each(function(i) {
                    $(this).attr('fill', i <= selectedIndex ? 'gold' : 'none');
                    $(this).attr('stroke', i <= selectedIndex ? 'gold' :
                        '#717171'); // Seçili yıldızların kenarlık rengini altın yap
                });
            });

            // Yıldızlara tıklama işlemi
            $('.rating-area .rating').on('click', function() {
                var index = $(this).index();
                $('.rating-area .rating').removeClass('selected').each(function(i) {
                    if (i <= index) $(this).addClass('selected');
                });
                $('#rate').val(index + 1);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#selectImageButton').on('click', function() {
                $('.fileinput').click();
            });

            $('.fileinput').on('change', function(event) {
                var previewContainer = $('#previewContainer');
                previewContainer.empty(); // Clear previous previews

                var files = event.target.files;
                if (files) {
                    $.each(files, function(index, file) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var img = $('<img>').attr('src', e.target.result);
                            previewContainer.append(img);
                        }
                        reader.readAsDataURL(file);
                    });
                }
            });
        });

        function submitForm() {

            const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

            if (!isLoggedIn) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Giriş Yapmanız Gerekiyor',
                    text: 'Lütfen yorum yapabilmek için giriş yapınız.',
                    confirmButtonText: 'Giriş Yap',
                    showCancelButton: true,
                    cancelButtonText: 'İptal',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('client.login') }}"; // Redirect to login page
                    }
                });
            } else {
                var rateValue = $('#rate').val();

                // Eğer rate değeri boş veya 0 ise, 1 olarak ayarla
                if (rateValue === '' || rateValue === '0') {
                    $('#rate').val('1');
                }
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                var formData = new FormData($('#commentForm')[0]);
                // Append CSRF token to form data
                formData.append('_token', csrfToken);
                $.ajax({
                    url: "{{ route('project.send-comment', ['id' => $project->id]) }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Yorum Gönderildi',
                            text: 'Yorumunuz admin onayladıktan sonra yayınlanacaktır.',
                        }).then(function() {
                            location.reload(); // Reload the page
                        });
                    },
                    error: function(error) {
                        console.log(xhr.responseText);
                        // window.location.href = "/giris-yap";
                        //console.log(error);
                    }
                });
            }


        }
    </script>

    <script>
        function openLightbox(index) {
            const slideNumber = index.toString();
            const slides = document.querySelectorAll('.carousel-inner .item');
            slides.forEach((slide) => {
                if (slide.getAttribute('data-slide-number') === slideNumber) {
                    slide.querySelector('a[data-lightbox="project-images"]').click();
                }
            });
        }
    </script>


    <script>
        $(document).ready(function() {
            $(document).ready(function() {
                $('#applyNowForm').on('submit', function(event) {
                    event.preventDefault();

                    $.ajax({
                        url: '{{ route('apply_now.store') }}', // Burada doğru route'u eklediğinizden emin olun
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            Toastify({
                                text: "Başvurunuz başarıyla gönderildi!",
                                duration: 5000,
                                gravity: 'bottom',
                                position: 'center',
                                backgroundColor: 'green',
                                stopOnFocus: true,
                            }).showToast();
                            $('.applyNowModalClose').click();
                        },
                        error: function(xhr) {
                            alert('Başvurunuz gönderilirken bir hata oluştu.');
                        }
                    });

                });
            });
            $(document).on("change", ".citySelect2", function() {
                var selectedCity = $(this).val();
                console.log(selectedCity);
                $.ajax({
                    type: 'GET',
                    url: '/get-counties/' + selectedCity,
                    success: function(data) {
                        var countySelect = $('.countySelect');
                        countySelect.empty();
                        countySelect.append('<option value="">İlçe Seçiniz</option>');
                        $.each(data.counties, function(index, county) {
                            countySelect.append('<option value="' + county.ilce_key +
                                '">' + county
                                .ilce_title +
                                '</option>');
                        });
                    }
                });
            });

        });
    </script>

    <script>
        var itemsPerPage = 10;
        var isLoading = false; // Kontrol flag'ı ekledik
        var currentBlock = 0;
        var currentPage = 0;
        var maxPages = null;
        $(document).ready(function() {
            // Önceki slayta geçme
            $('.carousel-control-prev').click(function() {
                $('#listingDetailsSlider').carousel('prev');
            });

            // Sonraki slayta geçme
            $('.carousel-control-next').click(function() {
                $('#listingDetailsSlider').carousel('next');
            });

            // Mobil cihazlarda kaydırma işlevselliği
            $('#listingDetailsSlider').on('touchstart', function(event) {
                var xClick = event.originalEvent.touches[0].pageX;
                $(this).one('touchmove', function(event) {
                    var xMove = event.originalEvent.touches[0].pageX;
                    var sensitivityInPx = 5;

                    if (Math.floor(xClick - xMove) > sensitivityInPx) {
                        $(this).carousel('next');
                    } else if (Math.floor(xClick - xMove) < -sensitivityInPx) {
                        $(this).carousel('prev');
                    }
                });
            });

            // Mobil cihazlarda dokunmatik olayları devre dışı bırakma
            $('#listingDetailsSlider').on('touchend', function() {
                $(this).off('touchmove');
            });
        });

        $(document).ready(function() {

            @if ($project->have_blocks)
                currentPage = 0;
                var projectBlocks = @json($project->blocks);
                maxPages = Math.ceil(projectBlocks[currentBlock]["housing_count"] / itemsPerPage);

                if (window.innerWidth >= 768) {
                    loadMoreDataBlock(0);
                } else {
                    loadMoreDataBlockMobil(0);
                }
                $(window).scroll(function() {
                    var projectRoom = $('#project-room' + currentBlock);
                    var projectRoomMobile = $('#project-room-mobile' + currentBlock);

                    // Web
                    if ($(window).scrollTop() + $(window).height() >= projectRoom.offset().top + projectRoom
                        .outerHeight() - 50 && !isLoading && window.innerWidth >= 768) {
                        if (currentPage < maxPages) {
                            isLoading = true; // Yüklenme başladığında flag'ı true olarak ayarla
                            currentPage++;
                            loadMoreDataBlock(currentPage);
                        }
                    }

                    // Mobil
                    if ($(window).scrollTop() + $(window).height() >= projectRoomMobile.offset().top +
                        projectRoomMobile.outerHeight() - 50 && !isLoading && window.innerWidth < 768) {
                        if (currentPage < maxPages) {
                            isLoading = true; // Yüklenme başladığında flag'ı true olarak ayarla
                            currentPage++;
                            loadMoreDataBlockMobil(currentPage);
                        }
                    }
                });
            @else

                currentPage = 1;
                maxPages = Math.ceil({{ $project->room_count }} / itemsPerPage);

                $(window).scroll(function() {
                    var projectRoom = $('#project-room');
                    var projectRoomMobile = $('#project-room-mobile');

                    // Web
                    if ($(window).scrollTop() + $(window).height() >= projectRoom.offset().top + projectRoom
                        .outerHeight() - 50 && !isLoading && window.innerWidth >= 768) {
                        if (currentPage < maxPages) {
                            isLoading = true; // Yüklenme başladığında flag'ı true olarak ayarla
                            currentPage++;
                            loadMoreData(currentPage);
                        }
                    }

                    // Mobil
                    if ($(window).scrollTop() + $(window).height() >= projectRoomMobile.offset().top +
                        projectRoomMobile.outerHeight() - 50 && !isLoading && window.innerWidth < 768) {
                        if (currentPage < maxPages) {
                            isLoading = true; // Yüklenme başladığında flag'ı true olarak ayarla
                            currentPage++;
                            loadMoreDataMobile(currentPage);
                        }
                    }
                });
            @endif
        });

        function loadMoreData(page) {
            $.ajax({
                url: "{{ url('/load-more-rooms') }}/{{ $project->id }}/" + page,
                type: 'get',
                beforeSend: function() {
                    $('.ajax-load').show();
                },
                success: function(response) {
                    $('#project-room').append(response);
                    $('.ajax-load').hide();
                    isLoading = false; // Yüklenme tamamlandığında flag'ı false olarak ayarla
                },
                error: function(jqXHR, ajaxOptions, thrownError) {
                    console.log(thrownError);

                    $('.ajax-load').hide();
                    isLoading = false; // Hata durumunda flag'ı false olarak ayarla
                }
            });
        }

        function loadMoreDataMobile(page) {
            $.ajax({
                url: "{{ url('/load-more-rooms-mobile') }}/{{ $project->id }}/" + page,
                type: 'get',
                beforeSend: function() {
                    $('.ajax-load').show();
                },
                success: function(response) {
                    $('#project-room-mobile').append(response);
                    $('.ajax-load').hide();
                    isLoading = false; // Yüklenme tamamlandığında flag'ı false olarak ayarla
                },
                error: function(jqXHR, ajaxOptions, thrownError) {
                    console.log(thrownError);

                    $('.ajax-load').hide();
                    isLoading = false; // Hata durumunda flag'ı false olarak ayarla
                }
            });
        }

        function loadMoreDataBlock(page) {
            $.ajax({
                url: "{{ url('/load-more-rooms-block') }}/{{ $project->id }}/" + currentBlock + "/" + page,
                type: 'get',
                beforeSend: function() {
                    $('.ajax-load').show();
                },
                success: function(response) {
                    $('#project-room' + currentBlock).append(response);
                    $('.ajax-load').hide();
                    isLoading = false; // Yüklenme tamamlandığında flag'ı false olarak ayarla
                },
                error: function(jqXHR, ajaxOptions, thrownError) {
                    console.log(thrownError);

                    $('.ajax-load').hide();
                    isLoading = false; // Hata durumunda flag'ı false olarak ayarla
                }
            });
        }

        function loadMoreDataBlockMobil(page) {
            $.ajax({
                url: "{{ url('/load-more-rooms-block-mobile') }}/{{ $project->id }}/" + currentBlock + "/" +
                    page,
                type: 'get',
                beforeSend: function() {
                    $('.ajax-load').show();
                },
                success: function(response) {
                    console.log($('#project-room-mobile' + currentBlock));
                    $('#project-room-mobile' + currentBlock).append(response);
                    $('.ajax-load').hide();
                    isLoading = false; // Yüklenme tamamlandığında flag'ı false olarak ayarla
                },
                error: function(jqXHR, ajaxOptions, thrownError) {
                    console.log(thrownError);

                    $('.ajax-load').hide();
                    isLoading = false; // Hata durumunda flag'ı false olarak ayarla
                }
            });
        }

        function changeTabContent(tabName, key) {
            currentPage = 0;
            currentBlock = key;


            if (window.innerWidth >= 768) {
                loadMoreDataBlock(0);
                $('#project-room' + currentBlock).html("");
            } else {
                loadMoreDataBlockMobil(0);
                $('#project-room-mobile' + currentBlock).html("");
            }

            projectBlocks = @json($project->blocks);
            maxPages = Math.ceil(projectBlocks[key]["housing_count"] / itemsPerPage);

            document.querySelectorAll('.nav-item-block').forEach(function(content) {
                content.classList.remove('active');
            });
            document.querySelectorAll('.tab-content-block').forEach(function(content) {
                content.classList.remove('active');
            });
            document.getElementById('contentblock-' + tabName).classList.add('active');
            var block = document.getElementById('contentblock-' + tabName).dataset.blockName;

            var blockIndex = $('#contentblock-' + tabName).index() - 1;
            var startIndex = 0;
            var endIndex = 12;

        }
    </script>

    <script>
        function checkOffer(offers, housingOrder) {
            var returnData = null;
            for (i = 0; i < offers.length; i++) {
                if (offers[i]["project_housings"].includes(housingOrder + " No")) {
                    returnData = offers[i];
                }
            }

            return returnData;
        }

        function priceFormat(price) {
            let inputValue = price;
            inputValue = inputValue.replace(/\D/g, '');
            inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            return inputValue;
        }
        var isLoading = false;


        function initMap() {
            // İlk harita görüntüsü
            var map = new google.maps.Map(document.getElementById('mapContainer'), {
                center: {
                    lat: {{ explode(',', $project->location)[0] }},
                    lng: {{ explode(',', $project->location)[1] }}
                },
                zoom: 16,
                gestureHandling: 'greedy'
            });

            // Harita üzerinde bir konum gösterme
            var marker = new google.maps.Marker({
                position: {
                    lat: {{ explode(',', $project->location)[0] }},
                    lng: {{ explode(',', $project->location)[1] }}
                },
                map: map,
                title: 'Default Location'
            });
        }

        function showLocation() {
            var location = document.getElementById('locationInput').value;

            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: {{ explode(',', $project->location)[0] }},
                    lng: {{ explode(',', $project->location)[1] }}
                },
                zoom: 12,
                gestureHandling: 'greedy'
            });

            var marker = new google.maps.Marker({
                position: {
                    lat: {{ explode(',', $project->location)[0] }},
                    lng: {{ explode(',', $project->location)[1] }}
                },
                map: map,
                title: location
            });
        }

        @php
            $location = explode(',', $project->location);
            $location['latitude'] = $location[0];
            $location['longitude'] = $location[1];

            $location = json_encode($location);
            $location = json_decode($location);
        @endphp
    </script>
    <script>
        $('.project-housing-pagination li').click(function() {
            $('.loading-full').removeClass('d-none')
            $.ajax({
                url: "{{ URL::to('/') }}/proje_ajax/{{ $project->slug }}?selected_page=" + $(this)
                    .index() + "&block_id=" + $('.tabs .nav-item.active')
                    .index(), // Sepete veri eklemek için uygun URL'yi belirtin
                type: "GET", // Veriyi göndermek için POST kullanabilirsiniz
                success: function(response) {
                    $('.loading-full').addClass('d-none')
                    $('body').html(response)
                },
                error: function(error) {
                    // Hata durumunda buraya gelir
                    toast.error(error)
                    console.error("Hata oluştu: " + error);
                }
            });
        })

        $('.tabs .nav-item').click(function() {
            $('.loading-full').removeClass('d-none')
            $.ajax({
                url: "{{ URL::to('/') }}/proje_ajax/{{ $project->slug }}?selected_page=0" +
                    "&block_id=" + $(this).index(), // Sepete veri eklemek için uygun URL'yi belirtin
                type: "GET", // Veriyi göndermek için POST kullanabilirsiniz
                success: function(response) {
                    $('.loading-full').addClass('d-none')
                    $('body').html(response)
                },
                error: function(error) {
                    // Hata durumunda buraya gelir
                    toast.error(error)
                    console.error("Hata oluştu: " + error);
                }
            });
        })



        $("#addToCart").click(function() {
            // Sepete eklenecek verileri burada hazırlayabilirsiniz
            var cart = {
                id: $(this).data('id'),
                type: $(this).data('type'),
                _token: "{{ csrf_token() }}"
            };

            // Ajax isteği gönderme
            $.ajax({
                url: "{{ route('add.to.cart') }}", // Sepete veri eklemek için uygun URL'yi belirtin
                type: "POST", // Veriyi göndermek için POST kullanabilirsiniz
                data: cart, // Sepete eklemek istediğiniz ürün verilerini gönderin
                success: function(response) {
                    // İşlem başarılı olduğunda buraya gelir
                    toast.success(response)
                    console.log("Ürün sepete eklendi: " + response);
                },
                error: function(error) {
                    if (error.message == 'error') {
                        alert('dasdsada');
                    }
                    // Hata durumunda buraya gelir
                    toast.error(error)
                    console.error("Hata oluştu: " + error);
                }
            });
        });

        $(document).ready(function() {
            $(".tabs li").click(function() {
                $(".tabs li").removeClass("active");
                $(this).addClass("active");
            });
        });

        $('.listingDetailsSliderNav').slick({
            slidesToShow: 5,
            slidesToScroll: 5,
            dots: false,
            loop: false,
            autoplay: false,
            arrows: false,
            margin: 0,
            adaptiveHeight: true,
            responsive: [{
                breakpoint: 993,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    dots: false,
                    arrows: false
                }
            }, {
                breakpoint: 769,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    dots: false,
                    arrows: false
                }
            }]
        });
        // Sayfa yüklendiğinde
        $(document).ready(function() {
            updateIndex(); // Index değerini güncelle
        });

        // Slayt geçiş işlemi tamamlandığında
        $('#listingDetailsSlider').on('slid.bs.carousel', function() {
            updateIndex(); // Index değerini güncelle
        });

        // Index değerini güncelleyen fonksiyon
        function updateIndex() {
            var totalSlides = $('#listingDetailsSlider .carousel-item').length; // Toplam slayt sayısını al
            var index = $('#listingDetailsSlider .carousel-item.active').index(); // Aktif slaydın indeksini al
            $('.pagination .page-item-middle .page-link').text((index + 1) + '/' +
                totalSlides); // Ortadaki li etiketinin metnini güncelle
        }

        if (window.innerWidth <= 768) {
            // Sol ok tuşuna tıklandığında
            $('.pagination .page-item-left').on('click', function(event) {
                event.preventDefault();
                $('#listingDetailsSlider').carousel('prev');
                var index = $('#listingDetailsSlider .carousel-item.active').attr('data-slide-number');
                // $('.pagination .page-item-middle .page-link').text(index);
                $('.listingDetailsSliderNav').slick('slickGoTo', index);
                var smallIndex = $('#listingDetailsSlider .active').data('slide-number');

            });

            // Sağ ok tuşuna tıklandığında
            $('.pagination .page-item-right').on('click', function(event) {
                event.preventDefault(); // Sayfanın yukarı gitmesini engelle
                $('#listingDetailsSlider').carousel('next');
                var index = $('#listingDetailsSlider .carousel-item.active').attr('data-slide-number');
                // $('.pagination .page-item-middle .page-link').text(index);
                $('.listingDetailsSliderNav').slick('slickGoTo', index);
                var smallIndex = $('#listingDetailsSlider .active').data('slide-number');
            });
        }



        var currentSlideIndex = 0;

        // Sağ ok tuşuna tıklandığında
        $('.pagination .page-item-right').on('click', function(event) {
            event.preventDefault(); // Sayfanın yukarı gitmesini engelle
            var totalItems = $('#listingDetailsSlider .carousel-item').length + 1; // Toplam slayt sayısını al
            var remainingItems = totalItems - (currentSlideIndex + 1) * 5; // Kalan slayt sayısını hesapla
            if (remainingItems >= 5) {
                currentSlideIndex++;
                $('.listingDetailsSliderNav').slick('slickGoTo', currentSlideIndex *
                    5); // Bir sonraki beşli kümeye git
            } else {
                $('.listingDetailsSliderNav').slick('slickNext'); // Son beşli kümeye git
            }
        });

        // Sol ok tuşuna tıklandığında
        $('.pagination .page-item-left').on('click', function(event) {
            event.preventDefault();
            if (currentSlideIndex > 0) {
                currentSlideIndex--;
                $('.listingDetailsSliderNav').slick('slickGoTo', currentSlideIndex * 5); // Önceki beşli kümeye git
            } else {
                $('.listingDetailsSliderNav').slick('slickPrev'); // Son beşli kümeye git

            }
        });




        $('.listingDetailsSliderNav').on('click', 'a', function() {
            var index2 = $(this).attr('data-slide-to');
            console.log(index2);
            $('#listingDetailsSlider').carousel(parseInt(index2));
        });


        // Büyük görsel kaydığında küçük görselleri de eşleştirme
        // $('#listingDetailsSlider').on('slid.bs.carousel', function() {
        //     var index = $('#listingDetailsSlider .carousel-item.active').attr('data-slide-number');
        //     // $('.pagination .page-item-middle .page-link').text(index);
        //     $('.listingDetailsSliderNav').slick('slickGoTo', index);
        //     var smallIndex = $('#listingDetailsSlider .active').data('slide-number');
        // });
    </script>

    <script>
        'use strict';
        $('#search-project').on('input', function() {
            let val = $(this).val();
            $('.project-item').each(function() {
                if ($(this).data('title').toLowerCase().search(val) == -1)
                    $(this).addClass('d-none');
                else
                    $(this).removeClass('d-none');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#phone").on("input blur", function() {
                var phoneNumber = $(this).val();
                var pattern = /^5[0-9]\d{8}$/;

                if (!pattern.test(phoneNumber)) {
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
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/project.css') }}">
    <style>
        .fixed-button {
            position: fixed;
            bottom: 70px;
            left: 20px;
            z-index: 1000;
            display: none;
            background-color: #ea2a28 !important;
            border-color: #ea2a28 !important;
        }

        .error-message {
            color: #e54242;
            font-size: 11px;
        }

        .success-message {
            color: green;
            font-size: 11px;
        }

        @media (max-width: 768px) {
            .fixed-button {
                display: block !important
            }
        }
    </style>
    <style>
        .product-review-container__redirect__span-wrapper {
            width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .product-review-container__redirect__span-wrapper p {
            font-family: source_sans_proregular, sans-serif;
            font-style: normal;
            font-size: 11px;
            overflow: hidden;
            text-overflow: ellipsis;
            margin: 0;
            line-height: inherit !important;
        }

        .product-review-container__redirect {
            display: flex;
            flex-direction: row;
            margin-top: 15px;
            cursor: pointer;
            text-decoration: none;
        }

        .product-review-container__redirect img {
            width: 50px;
            height: 44.95px;
            border: 1px solid #e6e6e6;
            box-sizing: border-box;
            border-radius: 4px;
            margin-right: 10px;
        }

        .slick-prev {
            left: 0 !important;
        }

        .slick-next {
            right: 0 !important;
        }

        .product-review-section-wrapper__wrapper__product-rating-filters {
            display: flex;
            flex-direction: row;
            margin-top: 10px;
            align-items: center margin-right: 20px;
        }

        @media (max-width:768px) {
            .product-rating-count-container {
                width: 45% !important;
                margin-top: 20px !important;
            }
        }

        .product-rating-count-container {
            width: 150px;
            height: 38px;
            background: #fff;
            border: 2px solid #e6e6e6;
            box-sizing: border-box;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .0511637);
            border-radius: 6px;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
        }

        .product-rating-count-container__count {
            margin-left: 7px;
            margin-top: 3px
        }

        .product-review-section-wrapper__wrapper__filter_title {
            font-family: source_sans_proregular, sans-serif;
            font-style: normal;
            font-weight: 600;
            font-size: 11px;
            line-height: 15px;
            color: #999;
            margin-bottom: 10px;
        }

        #previewContainer img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin: 5px;
        }
    </style>
@endsection
