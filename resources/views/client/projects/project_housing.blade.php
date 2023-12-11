@extends('client.layouts.master')

@section('content')
    @php
    
    if(isset($projectCartOrders[$housingOrder])){
                                                    $sold = $projectCartOrders[$housingOrder];
                                                }else{
                                                    $sold = null;
                                                }    @endphp
    @php
        function getData($project, $key, $roomOrder)
        {
            foreach ($project->roomInfo as $room) {
                if ($room->room_order == $roomOrder && $room->name == $key) {
                    return $room;
                }
            }
        }

        function implodeData($array)
        {
           
            $html = '';

            

            for ($i = 0; $i < count($array); $i++) {
                if ($i == 0) {
                    $html .= ' ' . $array[$i];
                } else {
                    $html .= ', ' . $array[$i];
                }
            }

            return $html;
        }
    @endphp

    @php
        $discountAmount = 0;

        $offer = App\Models\Offer::where('type', 'project')
            ->where('project_id', $project->id)
            ->where('project_housings', 'LIKE', '%' . getData($project, 'price[]', $housingOrder)->room_order . '%')
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->where('end_date', '>=', date('Y-m-d H:i:s'))
            ->first();

        if ($offer) {
            $discountAmount = $offer->discount_amount;
        }
    @endphp

    <section class="single-proper blog details bg-white">
        <div class="loading-full d-none">
            <div class="back-opa">
    
            </div>
            <div class="content-loading">
                <i class="fa fa-spinner"></i>
            </div>
        </div>
        <div class="container">
            <div class="row mb-3" style="align-items: center">
                <div class="col-md-8">
                    <div class="container">
                        <section class="headings-2 pt-0">
                            <div class="pro-wrapper" style="width: 100%; justify-content: space-between;">
                                @if ($sold)
                                    @if ($sold->status != '0' && $sold->status != '1')
                                        <div class="detail-wrapper-body">
                                            <div class="listing-title-bar">

                                                <h3>
                                                    @if (getData($project, 'advertise_title[]', $housingOrder)->value ?? null)
                                                    <span class="title-fs">{{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}
                                                        Projesi</span>
                                                    <p class="title-fsp">
                                                        {{ getData($project, 'advertise_title[]', $housingOrder)->value }}
                                                    </p>
                                                    @else
                                                        <span class="title-fs">{{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}</span>
                                                        <br>
                                                        {{ $housingOrder }} {{ "No'lu" }}
                                                        {{ $project->step1_slug }}
                                                    @endif
                                                </h3>

                                            </div>
                                        </div>
                                    @else
                                        <div class="detail-wrapper-body">
                                            <div class="listing-title-bar">

                                                <h3>
                                                    @if (getData($project, 'advertise_title[]', $housingOrder)->value ?? null)
                                                    <span class="title-fs">{{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}
                                                        Projesi</span>
                                                    <p class="title-fsp">
                                                        {{ getData($project, 'advertise_title[]', $housingOrder)->value }}
                                                    </p>
                                                    @else
                                                        <span class="title-fs">{{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}</span><br>
                                                        {{ $housingOrder }} {{ "No'lu" }}
                                                        {{ $project->step1_slug }}
                                                    @endif

                                                </h3>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="detail-wrapper-body">
                                        <div class="listing-title-bar">

                                            <h3>
                                                @if (getData($project, 'advertise_title[]', $housingOrder)->value ?? null)
                                                    <span class="title-fs">{{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}
                                                        Projesi</span>
                                                    <p class="title-fsp">
                                                        {{ getData($project, 'advertise_title[]', $housingOrder)->value }}
                                                    </p>
                                                @else
                                                    <span class="title-fs">{{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}</span><br>
                                                    {{ $housingOrder }} {{ "No'lu" }}
                                                    {{ $project->step1_slug }}
                                                @endif
                                            </h3>


                                        </div>
                                    </div>
                                @endif
                            </div>
                        </section>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="headings-2 pt-0">
                        <div class="pro-wrapper" style="width: 100%; justify-content: space-between;">
                            @if ($sold)
                                    @if ($sold->status != '0' && $sold->status != '1')
                                   
                                        <div class="single detail-wrapper mr-2">
                                            <div class="detail-wrapper-body">
                                                <div class="listing-title-bar">
                                                    <h4 style="white-space: nowrap">

                                                        @if ($discountAmount)
                                                            <svg viewBox="0 0 24 24" width="24" height="24"
                                                                stroke="currentColor" stroke-width="2" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="css-i6dzq1">
                                                                <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                                <polyline points="17 18 23 18 23 12"></polyline>
                                                            </svg>
                                                        @endif
                                                        @if (getData($project, 'off_sale[]', $housingOrder)->value == '[]')
                                                            {{ number_format(getData($project, 'price[]', $housingOrder)->value - $discountAmount, 0, ',', '.') }}
                                                            ₺
                                                        @endif
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    
                                    <div class="single detail-wrapper mr-2">
                                        <div class="detail-wrapper-body">
                                            <div class="listing-title-bar">
                                                <h4 style="white-space: nowrap">

                                                    @if ($discountAmount)
                                                        <svg viewBox="0 0 24 24" width="24" height="24"
                                                            stroke="currentColor" stroke-width="2" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="css-i6dzq1">
                                                            <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                            <polyline points="17 18 23 18 23 12"></polyline>
                                                        </svg>
                                                    @endif
                                                    @if (getData($project, 'off_sale[]', $housingOrder)->value == '[]')
                                                        {{ number_format(getData($project, 'price[]', $housingOrder)->value - $discountAmount, 0, ',', '.') }}
                                                        ₺
                                                    @endif
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-12 blog-pots">
                    <div class="row">
                        <div class="col-md-12">
                           
                            <div id="listingDetailsSlider" class="carousel listing-details-sliders slide mb-30">
                                <div class="carousel-inner">
                            
                                    {{-- Kapak Görseli --}}
                                    <div class="item carousel-item active" data-slide-number="-1">
                                        <a href="{{ URL::to('/') . '/project_housing_images/' . getData($project, 'image[]', $housingOrder)->value }}"
                                            data-lightbox="image-gallery">
                                            <img src="{{ URL::to('/') . '/project_housing_images/' . getData($project, 'image[]', $housingOrder)->value }}"
                                                class="img-fluid" alt="slider-listing">
                                        </a>
                                    </div>
                            
                                    {{-- Diğer Görseller --}}
                                    @foreach ($project->images as $key => $housingImage)
                                        <div class="item carousel-item" data-slide-number="{{ $key }}">
                                            <a href="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $housingImage->image) }}"
                                                data-lightbox="image-gallery">
                                                <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $housingImage->image) }}"
                                                    class="img-fluid" alt="slider-listing">
                                            </a>
                                        </div>
                                    @endforeach
                            
                                    {{-- Carousel Kontrolleri --}}
                                    <a class="carousel-control left" href="#listingDetailsSlider" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                                    <a class="carousel-control right" href="#listingDetailsSlider" data-slide="next"><i class="fa fa-angle-right"></i></a>
                                </div>
                            
                                {{-- Küçük Resim Navigasyonu --}}
                                <div class="listingDetailsSliderNav mt-3">
                                    {{-- Kapak Görseli --}}
                                    <div class="item active" style="margin: 10px; cursor: pointer">
                                        <a id="carousel-selector--1" data-slide-to="-1" data-target="#listingDetailsSlider">
                                            <img src="{{ URL::to('/') . '/project_housing_images/' . getData($project, 'image[]', $housingOrder)->value }}"
                                                class="img-fluid carousel-indicator-image" alt="listing-small">
                                        </a>
                                    </div>
                            
                                    {{-- Diğer Görseller --}}
                                    @foreach ($project->images as $key => $housingImage)
                                        <div class="item" style="margin: 10px; cursor: pointer">
                                            <a id="carousel-selector-{{ $key }}" data-slide-to="{{ $key }}" data-target="#listingDetailsSlider">
                                                <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $housingImage->image) }}"
                                                    class="img-fluid carousel-indicator-image" alt="listing-small">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            



                        </div>
                    </div>

                    <div class="mobile-show">


                        @if ($sold)
                            @if ($sold->status != '0' && $sold->status != '1')
                                <div class="p-2">
                                    <div class="widget-boxed">
                                        <div class="widget-boxed-header">
                                            <h4>Özellikler</h4>
                                        </div>
                                        {!! $project->description !!}
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="p-2">
                                <div class="widget-boxed">
                                    <div class="widget-boxed-header">
                                        <h4>Özellikler</h4>
                                    </div>
                                    <div class="mt-2">
                                        {!! $project->description !!}
                                        <hr>
                                        @if (count($projectHousingSetting))
                                        <div class="single homes-content">
                                            <table class="table table-bordered">
                                                <tbody class="trStyle"> 
                                                    @foreach ($projectHousingSetting as $key => $housingSetting)
                                                        @php
                                                            $isArrayCheck = $housingSetting->is_array;
                                                            $onProject = false;
                                                            $valueArray = [];

                                                         
                                                                if ($isArrayCheck) {
                                                                $valueArray = json_decode($projectHousing[$housingSetting->column_name . '[]']['value']);
                                                                if(isset($valueArray))
                                                                {
                                                                     $value = implodeData($valueArray);
                                                                }
                                                               
                                                            } elseif ($housingSetting->is_parent_table) {
                                                                $value = $project[$housingSetting->column_name];
                                                                $onProject = true;
                                                            } else {
                                                                foreach ($project->roomInfo as $roomInfo) {
                                                                if ($roomInfo->room_order == $housingOrder) {
                                                                    if ($roomInfo['name'] === $housingSetting->column_name . '[]') {
                                                                    if ($roomInfo['value'] == '["on"]') {
                                                                        $value = 'Evet';
                                                                    } elseif ($roomInfo['value'] == '["off"]') {
                                                                        $value = 'Hayır';
                                                                    } else {
                                                                        $value = $roomInfo['value'];
                                                                    }
                                                                    $onProject = true;
                                                                }
                                                            }
                                                         
                                                        }
                                                            
                                                            }
                                                           
                                                        @endphp

                                                            @if (!$isArrayCheck && (isset($value) && $value !== ''))
                                                            <tr>
                                                                @if ($housingSetting->label  == 'Fiyat')
                                                            <td>  <span
                                                                class=" mr-1">{{ $housingSetting->label  }}:</span>
                                                            <span class="det"
                                                                style="color: black; ">
                                                                {{ number_format($value, 0, ',', '.') }} ₺
                                                            </span></td>
                                                            @else
                                                                <td> <span
                                                                    class=" mr-1">{{ $housingSetting->label }}:</span>{{ $value }}</td>
                                                                    @endif
                                                            </tr>
                                                            

                                                            @endif
                                                    @endforeach

                                                </tbody>
                                            </table>



                                            @foreach ($projectHousingSetting as $housingSetting)
                                                @php
                                                    $isArrayCheck = $housingSetting->is_array;
                                                    $onProject = false;
                                                    $valueArray = [];

                                                    if ($isArrayCheck) {
                                                        $valueArray = json_decode($projectHousing[$housingSetting->column_name . '[]']['value']);
                                                        if(isset($valueArray))
                                                                {
                                                                     $value = implodeData($valueArray);
                                                                }
                                                    } elseif ($housingSetting->is_parent_table) {
                                                        $value = $project[$housingSetting->column_name];
                                                        $onProject = true;
                                                    } else {
                                                        foreach ($project->roomInfo as $roomInfo) {
                                                            if ($roomInfo->room_order == $housingOrder) {
                                                                if ($roomInfo['name'] === $housingSetting->column_name . '[]') {
                                                                if ($roomInfo['value'] == '["on"]') {
                                                                    $value = 'Evet';
                                                                } elseif ($roomInfo['value'] == '["off"]') {
                                                                    $value = 'Hayır';
                                                                } else {
                                                                    $value = $roomInfo['value'];
                                                                }
                                                                $onProject = true;
                                                            }
                                                            }
                                                         
                                                        }
                                                    }
                                                @endphp

                                                @if ($isArrayCheck)
                                                    @if (isset($valueArray))
                                                        <div class="mt-5">
                                                            <h5>{{ $projectHousing[$housingSetting->column_name . '[]']['key'] }}:
                                                            </h5>
                                                            <ul class="homes-list clearfix">
                                                                @foreach ($valueArray as $ozellik)
                                                                    <li><i class="fa fa-check-square"
                                                                            aria-hidden="true"></i><span>{{ $ozellik }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div> 
                                        @endif
                                       
                                    </div>

                                </div>
                                <div class="widget-boxed-header mt-5 mb-3">
                                    <h4>Projenin Diğer Konutları</h4>
                                </div>
                                <div class="list">
                                    @if ($project->have_blocks == 1)
                                    <div class="ui-elements properties-right list featured portfolio blog pb-5 bg-white">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 ">
                                                    <div class="tabbed-content button-tabs">
                                                        <ul class="tabs">
                                                            @foreach ($project->blocks as $key => $block)
                                                                <li class="nav-item {{ $key == $blockIndex ? ' active' : '' }}" role="presentation"
                                                                    onclick="changeTabContent('{{ $block['id'] }}')">
                                                                    <div class="tab-title">
                                                                        <span>{{ $block['block_name'] }}</span>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                    
                                                        @foreach ($project->blocks as $key => $block)
                                                            <div id="content-{{ $block['id'] }}" class="tab-content{{ $loop->first ? ' active' : '' }}">
                                                                @php
                                                                $j = -1; 
                                                                    $blockHousingCount = $block['housing_count'];
                                                                    if ($key > 0) {
                                                                        $previousBlockHousingCount = $project->blocks[$key - 1]['housing_count'];
                                                                        $i = $previousBlockHousingCount;
                                                                        $j = -1; // Bir önceki bloğun housing_count değerinden başlat
                                                                        $blockHousingCount = $previousBlockHousingCount;
                                                                } else {
                                                                    $i = 0; 
                                                                                                    }
                                                                                                    
                                                                $pageCount = $currentBlockHouseCount / 10;
                                                                @endphp
                                    
                                                                <div class="mobile-hidden">
                                                                    <div class="container">
                                                                        <div class="row project-filter-reverse blog-pots">
                                                                            @for ($i = $startIndex; $i < $endIndex; $i++)
                                                                                @php
                                                                                    $j++;
                                                                                    if(isset($projectCartOrders[$i+1])){
                                                                                        $sold = $projectCartOrders[$i+1];
                                                                                    }else{
                                                                                        $sold = null;
                                                                                    }
                                                                                @endphp
                                    
                                                                                <div class="col-md-12 col-12">
                                                                                    <div class="project-card mb-3">
                                                                                        <div class="row">
                                                                                            <div class="col-md-3">
                                                                                                <a href="{{ route('project.housings.detail', [$project->slug, $i + 1]) }}"
                                                                                                    style="height: 100%">
                                                                                                    <div class="d-flex" style="height: 100%;">
                                                                                                        <div
                                                                                                            style="background-color: #dc3545 !important; border-radius: 0px 8px 0px 8px;height:100%">
                                                                                                            <p
                                                                                                                style="padding: 10px; color: white; height: 100%; display: flex; align-items: center;text-align:center; ">
                                                                                                                No
                                                                                                                 <br>{{ $i + 1 - $lastHousingCount}}</p>
                                                                                                        </div>
                                                                                                        <div class="project-single mb-0 bb-0 aos-init aos-animate"
                                                                                                            data-aos="fade-up">
                                                                                                            <div class="project-inner project-head">
                                    
                                                                                                                <div class="button-effect">
                                                                                                                    <div href="javascript:void()"
                                                                                                                        class="btn toggle-project-favorite bg-white"
                                                                                                                        data-project-housing-id="{{ $i + 1 }}"
                                                                                                                        data-project-id={{ $project->id }}>
                                                                                                                        <i class="fa fa-heart-o"></i>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="homes position-relative">
                                                                                                                    <!-- homes img -->
                                                                                                                    <img src="{{ URL::to('/') . '/project_housing_images/' . getData($project, 'image[]', $i + 1)->value }}"
                                                                                                                        alt="home-1"
                                                                                                                        class="img-responsive"
                                                                                                                        style="height: 120px !important;object-fit:cover">
                                                                                                                    @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                        <div
                                                                                                                            style="z-index: 2;right: 0;top: 0;background: #e54242; width: 96px; height: 96px; position: absolute; clip-path: polygon(0 0, 45% 0, 100% 55%, 100% 100%);">
                                                                                                                            <div
                                                                                                                                style="color: #FFF; transform: rotate(45deg); margin-left: 25px; margin-top: 30px; font-weight: bold;">
                                                                                                                                {{ '%' . round(($offer->discount_amount / getData($project, 'price[]', $i + 1)->value) * 100) }}
                                                                                                                                <svg viewBox="0 0 24 24"
                                                                                                                                    width="16"
                                                                                                                                    height="16"
                                                                                                                                    stroke="currentColor"
                                                                                                                                    stroke-width="2"
                                                                                                                                    fill="none"
                                                                                                                                    stroke-linecap="round"
                                                                                                                                    stroke-linejoin="round"
                                                                                                                                    class="css-i6dzq1"
                                                                                                                                    style="transform: rotate(45deg);">
                                                                                                                                    <polyline
                                                                                                                                        points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                                                                                    </polyline>
                                                                                                                                    <polyline
                                                                                                                                        points="17 18 23 18 23 12">
                                                                                                                                    </polyline>
                                                                                                                                </svg>
                                                                                                                            </div>
                                    
                                                                                                                        </div>
                                                                                                                    @endif
                                                                                                                </div>
                                    
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </a>
                                                                                            </div>
                                    
                                    
                                                                                            <div class="col-lg-9 col-md-9 homes-content pb-0 mb-44 aos-init aos-animate"
                                                                                                data-aos="fade-up"
                                                                                                @if ($sold && $sold->status != "2" || getData($project, 'off_sale[]', $i + 1)->value != '[]') style="background: #EEE !important;" @endif>
                                    
                                                                                                <div
                                                                                                    class="row align-items-center justify-content-between mobile-position">
                                                                                                    <div class="col-md-8">
                                    
                                                                                                        <div class="homes-list-div">
                                                                                                            <ul class="homes-list clearfix pb-3 d-flex">
                                                                                                                <li class="d-flex align-items-center itemCircleFont">
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
                                                                                                                            {{ getData($project, $project->listItemValues->column1_name . '[]', $i + 1)->value }}
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
                                                                                                                            {{ getData($project, $project->listItemValues->column2_name . '[]', $i + 1)->value }}
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
                                                                                                                            {{ getData($project, $project->listItemValues->column3_name . '[]', $i + 1)->value }}
                                                                                                                            @if (isset($project->listItemValues) &&
                                                                                                                                    isset($project->listItemValues->column3_additional) &&
                                                                                                                                    $project->listItemValues->column3_additional)
                                                                                                                                {{ $project->listItemValues->column3_additional }}
                                                                                                                            @endif
                                                                                                                        </span>
                                                                                                                    </li>
                                                                                                                @endif
                                    
                                                                                                                <li class="the-icons mobile-hidden">
                                                                                                                    <span>
                                                                                                                        @if (getData($project, 'off_sale[]', $i + 1)->value == '[]')
                                                                                                                            @if ($sold)
                                                                                                                                @if ($sold->status != '1' && $sold->status != '0')
                                                                                                                                    @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                                        <h6
                                                                                                                                            style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                                                                            {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                                                                                                                            ₺</h6>
                                                                                                                                        <h6
                                                                                                                                            style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                                                                            {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                                            ₺
                                    
                                                                                                                                        </h6>
                                                                                                                                    @else
                                                                                                                                        <h6
                                                                                                                                            style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                                            {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                                            ₺
                                                                                                                                        </h6>
                                                                                                                                    @endif
                                                                                                                                @endif
                                                                                                                            @else
                                                                                                                                @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                                    <h6
                                                                                                                                        style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                                                                        {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                                                                                                                        ₺</h6>
                                                                                                                                    <h6
                                                                                                                                        style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                                                                        {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                                        ₺
                                    
                                                                                                                                    </h6>
                                                                                                                                @else
                                                                                                                                    <h6
                                                                                                                                        style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                                        {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                                        ₺
                                                                                                                                    </h6>
                                                                                                                                @endif
                                                                                                                            @endif
                                                                                                                        @endif
                                    
                                    
                                                                                                                    </span>
                                                                                                                </li>
                                    
                                    
                                                                                                            </ul>
                                    
                                                                                                        </div>
                                                                                                        <div class="footer">
                                                                                                            <a
                                                                                                                href="{{ route('instituional.profile', Str::slug($project->user->name)) }}">
                                                                                                                <img src="{{ url('storage/profile_images/' . $project->user->profile_image) }}"
                                                                                                                    alt="" class="mr-2">
                                                                                                                {{ $project->user->name }}
                                                                                                            </a>
                                                                                                            <span class="price-mobile">
                                                                                                                @if (getData($project, 'off_sale[]', $i + 1)->value == '[]')
                                                                                                                    @if ($sold)
                                                                                                                        @if ($sold->status != '1' && $sold->status != '0')
                                                                                                                            @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                                <h6
                                                                                                                                    style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;margin-right:5px">
                                                                                                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                                    ₺
                                                                                                                                </h6>
                                                                                                                                <h6
                                                                                                                                    style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:20px;">
                                                                                                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                    
                                                                                                                                    ₺</h6>
                                                                                                                            @else
                                                                                                                                <h6
                                                                                                                                    style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}₺
                                                                                                                                </h6>
                                                                                                                            @endif
                                                                                                                        @endif
                                                                                                                    @else
                                                                                                                        @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                            <h6
                                                                                                                                style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;margin-right:5px">
                                                                                                                                {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                                ₺
                                                                                                                            </h6>
                                                                                                                            <h6
                                                                                                                                style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:20px;">
                                                                                                                                {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                    
                                                                                                                                ₺</h6>
                                                                                                                        @else
                                                                                                                            <h6
                                                                                                                                style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                                {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}₺
                                                                                                                            </h6>
                                                                                                                        @endif
                                                                                                                    @endif
                                                                                                                @endif
                                    
                                    
                                                                                                            </span>
                                                                                                        </div>
                                                                                                    </div>
                                    
                                                                                                    <div class="col-md-3 mobile-hidden"
                                                                                                        style="height: 120px;padding:0">
                                                                                                        <div class="homes-button"
                                                                                                            style="width:100%;height:100%">
                                                                                                            <button class="first-btn payment-plan-button"
                                                                                                            project-id="{{ $project->id }}"
                                                                                                            data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0) || getData($project, 'off_sale[]', $i + 1)->value != '[]') ? '1' : '0' }}"
                                                                                                            order="{{ $i }}">
                                                                                                            Ödeme Detayları
                                                                                                    </button>
                                                                                                    
                                                                                                            @if (getData($project, 'off_sale[]', $i + 1)->value != '[]')
                                                                                                                <button class="btn second-btn CartBtn"
                                                                                                                    disabled
                                                                                                                    style="background: red !important;width:100%;color:White;height: auto !important">
                                    
                                                                                                                    <span class="text">Satışa
                                                                                                                        Kapatıldı</span>
                                                                                                                </button>
                                                                                                            @else
                                                                                                                @if ($sold && $sold->status != '2')
                                                                                                                    <button class="btn second-btn soldBtn"
                                                                                                                        disabled
                                                                                                                        @if ($sold->status == '0') style="background: orange !important;color:White;height: auto !important" @else  style="background: red !important;color:White;height: auto !important" @endif>
                                                                                                                        @if ($sold->status == '0')
                                                                                                                            <span class="text">Onay
                                                                                                                                Bekleniyor</span>
                                                                                                                        @else
                                                                                                                            <span
                                                                                                                                class="text">Satıldı</span>
                                                                                                                        @endif
                                                                                                                    </button>
                                                                                                                @else
                                                                                                                    <button class="CartBtn second-btn"
                                                                                                                        data-type='project'
                                                                                                                        data-project='{{ $project->id }}'
                                                                                                                        style="height: auto !important"
                                                                                                                        data-id='{{ getData($project, 'price[]', $i + 1)->room_order }}'>
                                                                                                                        <span class="IconContainer">
                                                                                                                            <img src="{{ asset('sc.png') }}"
                                                                                                                                alt="">
                                                                                                                        </span>
                                                                                                                        <span class="text">Sepete
                                                                                                                            Ekle</span>
                                                                                                                    </button>
                                                                                                                @endif
                                                                                                            @endif
                                    
                                                                                                        </div>
                                                                                                    </div>
                                    
                                    
                                                                                                </div>
                                    
                                    
                                                                                            </div>
                                                                                        </div>
                                    
                                                                                    </div>
                                                                                </div>
                                                                            @endfor
                                    
                                                                            <div class="project-housing-pagination">
                                                                                <ul>
                                                                                    @for($t = 0; $t < $pageCount; $t++)
                                                                                        @php 
                                                                                            if(isset($startIndex)):
                                                                                        @endphp
                                                                                            <li @if($t == ($startIndex / 10)) class="active" @endif>{{$t+1}}</li>
                                                                                        @php
                                                                                            else:
                                                                                        @endphp
                                                                                            <li @if($t == 0) class="active" @endif>{{$t+1}}</li>
                                                                                        @php
                                                                                            endif;
                                                                                        @endphp
                                                                                    @endfor
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
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
                                            <div class="container">
                                                <div class="row project-filter-reverse blog-pots">
                                                    @for ($i = 0; $i < $project->room_count; $i++)
                                                        @php
                                                            if(isset($projectCartOrders[$i+1])){
                                                                $sold = $projectCartOrders[$i+1];
                                                            }else{
                                                                $sold = null;
                                                            }
                                                        @endphp
                                    
                                                        <div class="col-md-12 col-12">
                                                            <div class="project-card mb-3">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <a href="{{ route('project.housings.detail', [$project->slug, $i + 1]) }}"
                                                                            style="height: 100%">
                                                                            <div class="d-flex" style="height: 100%;">
                                                                                <div
                                                                                    style="background-color: #dc3545 !important; border-radius: 0px 8px 0px 8px;height:100%">
                                                                                    <p
                                                                                        style="padding: 10px;text-align:center; color: white; height: 100%; display: flex; align-items: center; ">
                                                                                        No<br>{{ $i + 1 }}</p>
                                                                                </div>
                                                                                <div class="project-single mb-0 bb-0 aos-init aos-animate"
                                                                                    data-aos="fade-up">
                                                                                    <div class="project-inner project-head">
                                    
                                                                                        <div class="button-effect">
                                                                                            <div href="javascript:void()"
                                                                                                class="btn toggle-project-favorite bg-white"
                                                                                                data-project-housing-id="{{ $i + 1 }}"
                                                                                                data-project-id={{ $project->id }}>
                                                                                                <i class="fa fa-heart-o"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="homes position-relative">
                                                                                            <!-- homes img -->
                                                                                            <img src="{{ URL::to('/') . '/project_housing_images/' . getData($project, 'image[]', $i + 1)->value }}"
                                                                                                alt="home-1" class="img-responsive"
                                                                                                style="height: 120px !important;object-fit:cover">
                                                                                            @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                <div
                                                                                                    style="z-index: 2;right: 0;top: 0;background: #e54242; width: 96px; height: 96px; position: absolute; clip-path: polygon(0 0, 45% 0, 100% 55%, 100% 100%);">
                                                                                                    <div
                                                                                                        style="color: #FFF; transform: rotate(45deg); margin-left: 25px; margin-top: 30px; font-weight: bold;">
                                                                                                        {{ '%' . round(($offer->discount_amount / getData($project, 'price[]', $i + 1)->value) * 100) }}
                                                                                                        <svg viewBox="0 0 24 24" width="16"
                                                                                                            height="16" stroke="currentColor"
                                                                                                            stroke-width="2" fill="none"
                                                                                                            stroke-linecap="round" stroke-linejoin="round"
                                                                                                            class="css-i6dzq1"
                                                                                                            style="transform: rotate(45deg);">
                                                                                                            <polyline points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                                                            </polyline>
                                                                                                            <polyline points="17 18 23 18 23 12">
                                                                                                            </polyline>
                                                                                                        </svg>
                                                                                                    </div>
                                    
                                                                                                </div>
                                                                                            @endif
                                                                                        </div>
                                    
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                    
                                    
                                                                    <div class="col-lg-9 col-md-9 homes-content pb-0 mb-44 aos-init aos-animate"
                                                                        data-aos="fade-up"
                                                                        @if ($sold && $sold->status != "2" || getData($project, 'off_sale[]', $i + 1)->value != '[]') style="background: #EEE !important;" @endif>
                                    
                                                                        <div class="row align-items-center justify-content-between mobile-position">
                                                                            <div class="col-md-8">
                                    
                                                                                <div class="homes-list-div">
                                                                                    <ul class="homes-list clearfix pb-3 d-flex">
                                                                                        <li class="d-flex align-items-center itemCircleFont">
                                                                                            <i class="fa fa-circle circleIcon mr-1" style="color: black;"
                                                                                                aria-hidden="true"></i>
                                                                                            <span>{{ $project->housingType->title }}</span>
                                                                                        </li>
                                                                                        @if (isset($project->listItemValues) &&
                                                                                                isset($project->listItemValues->column1_name) &&
                                                                                                $project->listItemValues->column1_name)
                                                                                            <li class="d-flex align-items-center itemCircleFont">
                                                                                                <i class="fa fa-circle circleIcon mr-1"
                                                                                                    aria-hidden="true"></i>
                                                                                                <span>
                                                                                                    {{ getData($project, $project->listItemValues->column1_name . '[]', $i + 1)->value }}
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
                                                                                                <i class="fa fa-circle circleIcon mr-1"
                                                                                                    aria-hidden="true"></i>
                                                                                                <span>
                                                                                                    {{ getData($project, $project->listItemValues->column2_name . '[]', $i + 1)->value }}
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
                                                                                                <i class="fa fa-circle circleIcon mr-1"
                                                                                                    aria-hidden="true"></i>
                                                                                                <span>
                                                                                                    {{ getData($project, $project->listItemValues->column3_name . '[]', $i + 1)->value }}
                                                                                                    @if (isset($project->listItemValues) &&
                                                                                                            isset($project->listItemValues->column3_additional) &&
                                                                                                            $project->listItemValues->column3_additional)
                                                                                                        {{ $project->listItemValues->column3_additional }}
                                                                                                    @endif
                                                                                                </span>
                                                                                            </li>
                                                                                        @endif
                                    
                                                                                        <li class="the-icons mobile-hidden">
                                                                                            <span>
                                                                                                @if (getData($project, 'off_sale[]', $i + 1)->value == '[]')
                                                                                                    @if ($sold)
                                                                                                        @if ($sold->status != '1' && $sold->status != '0')
                                                                                                            @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                <h6
                                                                                                                    style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                                                                                                    ₺</h6>
                                                                                                                <h6
                                                                                                                    style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                    ₺
                                    
                                                                                                                </h6>
                                                                                                            @else
                                                                                                                <h6
                                                                                                                    style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                    ₺
                                                                                                                </h6>
                                                                                                            @endif
                                                                                                        @endif
                                                                                                    @else
                                                                                                        @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                            <h6
                                                                                                                style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                                                {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                                                                                                ₺</h6>
                                                                                                            <h6
                                                                                                                style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                                                {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                ₺
                                    
                                                                                                            </h6>
                                                                                                        @else
                                                                                                            <h6
                                                                                                                style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                ₺
                                                                                                            </h6>
                                                                                                        @endif
                                                                                                    @endif
                                                                                                @endif
                                    
                                    
                                                                                            </span>
                                                                                        </li>
                                    
                                    
                                                                                    </ul>
                                    
                                                                                </div>
                                                                                <div class="footer">
                                                                                    <a
                                                                                        href="{{ route('instituional.profile', Str::slug($project->user->name)) }}">
                                                                                        <img src="{{ url('storage/profile_images/' . $project->user->profile_image) }}"
                                                                                            alt="" class="mr-2"> {{ $project->user->name }}
                                                                                    </a>
                                                                                    <span class="price-mobile">
                                                                                        @if (getData($project, 'off_sale[]', $i + 1)->value == '[]')
                                                                                            @if ($sold)
                                                                                                @if ($sold->status != '1' && $sold->status != '0')
                                                                                                    @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                        <h6
                                                                                                            style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;margin-right:5px">
                                                                                                            {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                            ₺
                                                                                                        </h6>
                                                                                                        <h6
                                                                                                            style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:20px;">
                                                                                                            {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                    
                                                                                                            ₺</h6>
                                                                                                    @else
                                                                                                        <h6
                                                                                                            style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                            {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}₺
                                                                                                        </h6>
                                                                                                    @endif
                                                                                                @endif
                                                                                            @else
                                                                                                @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                    <h6
                                                                                                        style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;margin-right:5px">
                                                                                                        {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                        ₺
                                                                                                    </h6>
                                                                                                    <h6
                                                                                                        style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:20px;">
                                                                                                        {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                    
                                                                                                        ₺</h6>
                                                                                                @else
                                                                                                    <h6
                                                                                                        style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                        {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}₺
                                                                                                    </h6>
                                                                                                @endif
                                                                                            @endif
                                                                                        @endif
                                    
                                    
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                    
                                                                            <div class="col-md-3 mobile-hidden" style="height: 120px;padding:0">
                                                                                <div class="homes-button" style="width:100%;height:100%">
                                                                                    <button class="first-btn payment-plan-button"
                                                                                                            project-id="{{ $project->id }}"
                                                                                                            data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0) || getData($project, 'off_sale[]', $i + 1)->value != '[]') ? '1' : '0' }}"
                                                                                                            order="{{ $i }}">
                                                                                                            Ödeme Detayları
                                                                                                    </button>
                                                                            
                                                                                    @if (getData($project, 'off_sale[]', $i + 1)->value != '[]')
                                                                                        <button class="btn second-btn CartBtn" disabled
                                                                                            style="background: red !important;width:100%;color:White;height: auto !important">
                                    
                                                                                            <span class="text">Satışa Kapatıldı</span>
                                                                                        </button>
                                                                                    @else
                                                                                        @if ($sold && $sold->status != '2')
                                                                                            <button class="btn second-btn soldBtn" disabled
                                                                                                @if ($sold->status == '0') style="background: orange !important;color:White;height: auto !important"
                                                                                @else 
                                                                                style="background: red !important;color:White;height: auto !important" @endif>
                                                                                                @if ($sold->status == '0')
                                                                                                    <span class="text">Onay Bekleniyor</span>
                                                                                                @else
                                                                                                    <span class="text">Satıldı</span>
                                                                                                @endif
                                                                                            </button>
                                                                                        @else
                                                                                            <button class="CartBtn second-btn" data-type='project'
                                                                                                data-project='{{ $project->id }}'
                                                                                                style="height: auto !important"
                                                                                                data-id='{{ getData($project, 'price[]', $i + 1)->room_order }}'>
                                                                                                <span class="IconContainer">
                                                                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                                                                </span>
                                                                                                <span class="text">Sepete Ekle</span>
                                                                                            </button>
                                                                                        @endif
                                                                                    @endif
                                    
                                                                                </div>
                                                                            </div>
                                    
                                    
                                                                        </div>
                                    
                                    
                                                                    </div>
                                                                </div>
                                    
                                                            </div>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    
                                    
                                    
                                    </div>
                                    @endif
                                </div>


                            </div>
                        @endif



                    </div>



                </div>
                <aside class="col-md-4  car">
                    <div class="single widget buyBtn">
                        <div class="schedule widget-boxed mt-33 mt-0">


                            <div class="row buttonDetail" style="align-items:center">
                             
                                <div class="col-md-9 col-10">
                                    @if (getData($project, 'off_sale[]', $housingOrder)->value != '[]')
                                        <button class="btn second-btn soldBtn" disabled
                                            style="background: red !important;width:100%;color:White">
                                            <span class="IconContainer">
                                                <img src="{{ asset('sc.png') }}" alt="">
                                            </span>
                                            <span class="text">Satıldı</span>
                                        </button>
                                    @else
                                        @if ($sold && $sold->status != '2')
                                            <button class="btn second-btn soldBtn" disabled
                                                @if ($sold->status == '0') style="background: orange !important;width:100%;color:White"
                                                            @else 
                                                            style="background: red !important;width:100%;color:White" @endif>
                                                @if ($sold->status == '0')
                                                    <span class="text">Onay Bekleniyor</span>
                                                @else
                                                    <span class="text">Satıldı</span>
                                                @endif
                                            </button>
                                        @else
                                            <button class="CartBtn" data-type='project'
                                                data-project='{{ $project->id }}'
                                                data-id='{{ getData($project, 'price[]', $housingOrder)->room_order }}'>
                                                <span class="IconContainer">
                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                </span>
                                                <span class="text">Sepete Ekle</span>
                                            </button>
                                        @endif
                                    @endif

                                </div>
                                <div class="col-md-3 col-2">
                                    <div class="button-effect toggle-project-favorite"
                                        data-project-housing-id="{{ getData($project, 'squaremeters[]', $housingOrder)->room_order }}"
                                        data-project-id={{ $project->id }}>
                                        <i class="fa fa-heart-o"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="single widget storeInfo">
                        <div class="widget-boxed">
                            <div class="widget-boxed-header">
                                <h4>Mağaza Bilgileri</h4>
                            </div>
                            <div class="widget-boxed-body">
                                <div class="sidebar-widget author-widget2">
                                    <div class="author-box clearfix d-flex align-items-center">
                                        <img src="{{ URL::to('/') . '/storage/profile_images/' . $project->user->profile_image }}"
                                            alt="author-image" class="author__img">
                                      <div>  <a href="{{ route('instituional.dashboard', Str::slug($project->user->name)) }}">
                                        <h4 class="author__title">{!! $project->user->name !!}</h4>
                                    </a>
                                    <p class="author__meta">{{ $project->user->corporate_type == "Emlakçı" ?  "Gayrimenkul Ofisi" : $project->user->corporate_type }}</p></div>
                                    </div>
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>
                                                İlan No: {{ $housingOrder + $project->id + 2000000 }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                               {{ $project->city->title }} {{ '/' }} {{ $project->county->ilce_title }}
                                            </td>
                                        </tr>
                                        @if ($project->user->phone)
                                            <tr>
                                                <td>
                                                    <a style="text-decoration: none;color:inherit" href="tel:{!! $project->user->phone !!}">{!! $project->user->phone !!}</a>
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($project->step1_slug)
                                            <tr>
                                                <td>
                                                    @if ($project->step2_slug)
                                                        @if ($project->step2_slug == 'kiralik')
                                                           Kiralık
                                                        @elseif ($project->step2_slug == 'satilik')
                                                           Satılık
                                                        @else
                                                        Günlük Kiralık
                                                                                                                @endif
                                                    @endif
                                                    {{ $parent->title }}
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>
                                                <a style="text-decoration: none;color:inherit" href="mailto:{!! $project->user->email !!}">{!! $project->user->email !!}</a>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                </div>
                                <hr>
                                <div class="first-footer">
                                    <ul class="netsocials px-2">
                                        @php
                                            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
                                            $host = $_SERVER['HTTP_HOST'];
                                            $uri = $_SERVER['REQUEST_URI'];
                                            $shareUrl = $protocol . '://' . $host . $uri;
                                        @endphp
                                        <li>
                                            <a href="https://twitter.com/share?url={{ $shareUrl }}">
                                                <i class="fa fa-twitter" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.instagram.com/">
                                                <i class="fa fa-instagram" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="whatsapp://send?text={{ $shareUrl }}">
                                                <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}">
                                                <i class="fa fa-facebook" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        {{-- @if (count($project->user->banners) > 0)
                            <div class="widget-boxed popular mt-5">
                                <div class="widget-boxed-header">
                                    <h4>{!! $project->user->name !!}</h4>
                                </div>

                                <div class="widget-boxed-body">
                                    @if (count($project->user->banners) > 0)
                                        @php
                                            $randomBanner = $project->user->banners[0];
                                            $imagePath = asset('storage/store_banners/' . $randomBanner['image']);
                                        @endphp
                                        <div class="banner"><img src="{{ $imagePath }}" alt=""></div>
                                    @else
                                        <p>No banners available.</p>
                                    @endif
                                </div>

                            </div>
                        @endif --}}

                    </div>
                </aside>

            </div>

            @if (getData($project, 'off_sale[]', $housingOrder)->value == '[]')

                <div class="mobile-hidden">
                    <div class="row" style="width:100%">
                        <div class="col-md-12">


                            @if ($sold)
                                @if ($sold->status != '0' && $sold->status != '1')
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                                data-bs-target="#home" type="button" role="tab"
                                                aria-controls="home" aria-selected="true">Açıklama</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                                data-bs-target="#profile" type="button" role="tab"
                                                aria-controls="profile" aria-selected="false">Özellikler</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                                data-bs-target="#contact" type="button" role="tab"
                                                aria-controls="contact" aria-selected="false">Projedeki Diğer
                                                Konutlar</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link payment-plan-tab" id="payment-tab"
                                                data-bs-toggle="tab" data-bs-target="#payment" type="button"
                                                role="tab" aria-controls="payment" project-id="{{ $project->id }}"
                                                order="{{ $housingOrder }}" aria-selected="false">Ödeme Planı</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active blog-info details mb-30" id="home"
                                            role="tabpanel" aria-labelledby="home-tab">
                                            {!! $project->description !!}
                                        </div>
                                        <div class="tab-pane fade blog-info details" id="profile" role="tabpanel"
                                            aria-labelledby="profile-tab">
                                            <div class="similar-property featured portfolio p-0 bg-white">

                                                <div class="single homes-content">

                                                    <h5 class="mb-4">Özellikler</h5>
                                                    <table class="table table-bordered">
                                                        <tbody class="trStyle"> 
                                                            <tr>
                                                                <td>
                                                                    <span class="mr-1">İlan No:</span>
                                                                    <span class="det" style="color: black;">
                                                                        {{ $housingOrder + $project->id + 2000000 }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            @foreach ($projectHousingSetting as $key => $housingSetting)
                                                                @php
                                                                    $isArrayCheck = $housingSetting->is_array;
                                                                    $onProject = false;
                                                                    $valueArray = [];
    
                                                                 
                                                                        if ($isArrayCheck) {
                                                                        $valueArray = json_decode($projectHousing[$housingSetting->column_name . '[]']['value']);
                                                                        if(isset($valueArray))
                                                                        {
                                                                             $value = implodeData($valueArray);
                                                                        }
                                                                       
                                                                    } elseif ($housingSetting->is_parent_table) {
                                                                        $value = $project[$housingSetting->column_name];
                                                                        $onProject = true;
                                                                    } else {
                                                                        foreach ($project->roomInfo as $roomInfo) {
                                                                        if ($roomInfo->room_order == $housingOrder) {
                                                                            if ($roomInfo['name'] === $housingSetting->column_name . '[]') {
                                                                            if ($roomInfo['value'] == '["on"]') {
                                                                                $value = 'Evet';
                                                                            } elseif ($roomInfo['value'] == '["off"]') {
                                                                                $value = 'Hayır';
                                                                            } else {
                                                                                $value = $roomInfo['value'];
                                                                            }
                                                                            $onProject = true;
                                                                        }
                                                                    }
                                                                 
                                                                }
                                                                    
                                                                    }
                                                                   
                                                                @endphp
    
                                                                    @if (!$isArrayCheck && (isset($value) && $value !== ''))
                                                                    <tr>
                                                                        @if ($housingSetting->label  == 'Fiyat')
                                                                    <td>  <span
                                                                        class=" mr-1">{{ $housingSetting->label  }}:</span>
                                                                    <span class="det"
                                                                        style="color: black; ">
                                                                        {{ number_format($value, 0, ',', '.') }} ₺
                                                                    </span></td>
                                                                    @else
                                                                        <td> <span
                                                                            class=" mr-1">{{ $housingSetting->label }}:</span>{{ $value }}</td>
                                                                            @endif
                                                                    </tr>
                                                                    
    
                                                                    @endif
                                                            @endforeach
    
                                                        </tbody>
                                                    </table>
    
    
     
                                                    @foreach ($projectHousingSetting as $housingSetting)
                                                        @php
                                                            $isArrayCheck = $housingSetting->is_array;
                                                            $onProject = false;
                                                            $valueArray = [];
    
                                                            if ($isArrayCheck) {
                                                                $valueArray = json_decode($projectHousing[$housingSetting->column_name . '[]']['value']);
                                                                if(isset($valueArray))
                                                                        {
                                                                             $value = implodeData($valueArray);
                                                                        }
                                                            } elseif ($housingSetting->is_parent_table) {
                                                                $value = $project[$housingSetting->column_name];
                                                                $onProject = true;
                                                            } else {
                                                                foreach ($project->roomInfo as $roomInfo) {
                                                                    if ($roomInfo->room_order == $housingOrder) {
                                                                        if ($roomInfo['name'] === $housingSetting->column_name . '[]') {
                                                                        if ($roomInfo['value'] == '["on"]') {
                                                                            $value = 'Evet';
                                                                        } elseif ($roomInfo['value'] == '["off"]') {
                                                                            $value = 'Hayır';
                                                                        } else {
                                                                            $value = $roomInfo['value'];
                                                                        }
                                                                        $onProject = true;
                                                                    }
                                                                    }
                                                                 
                                                                }
                                                            }
                                                        @endphp
    
                                                        @if ($isArrayCheck)
                                                            @if (isset($valueArray))
                                                                <div class="mt-5">
                                                                    <h5>{{ $projectHousing[$housingSetting->column_name . '[]']['key'] }}:
                                                                    </h5>
                                                                    <ul class="homes-list clearfix">
                                                                        @foreach ($valueArray as $ozellik)
                                                                            <li><i class="fa fa-check-square"
                                                                                    aria-hidden="true"></i><span>{{ $ozellik }}</span>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade  blog-info details" id="contact" role="tabpanel"
                                            aria-labelledby="contact-tab">
                                            @if ($project->have_blocks == 1)
                                            <div class="ui-elements properties-right list featured portfolio blog pb-5 bg-white">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 ">
                                                            <div class="tabbed-content button-tabs">
                                                                <ul class="tabs">
                                                                    @foreach ($project->blocks as $key => $block)
                                                                        <li class="nav-item {{ $key == $blockIndex ? ' active' : '' }}" role="presentation"
                                                                            onclick="changeTabContent('{{ $block['id'] }}')">
                                                                            <div class="tab-title">
                                                                                <span>{{ $block['block_name'] }}</span>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                            
                                                                @foreach ($project->blocks as $key => $block)
                                                                    <div id="content-{{ $block['id'] }}" class="tab-content{{ $loop->first ? ' active' : '' }}">
                                                                        @php
                                                                        $j = -1; 
                                                                            $blockHousingCount = $block['housing_count'];
                                                                            if ($key > 0) {
                                                                                $previousBlockHousingCount = $project->blocks[$key - 1]['housing_count'];
                                                                                $i = $previousBlockHousingCount;
                                                                                $j = -1; // Bir önceki bloğun housing_count değerinden başlat
                                                                                $blockHousingCount = $previousBlockHousingCount;
                                                                        } else {
                                                                            $i = 0; 
                                                                                                            }
                                                                                                            
                                                                        $pageCount = $currentBlockHouseCount / 10;
                                                                        @endphp
                                            
                                                                        <div class="mobile-hidden">
                                                                            <div class="container">
                                                                                <div class="row project-filter-reverse blog-pots">
                                                                                    @for ($i = $startIndex; $i < $endIndex; $i++)
                                                                                        @php
                                                                                            $j++;
                                                                                            if(isset($projectCartOrders[$i+1])){
                                                                                                $sold = $projectCartOrders[$i+1];
                                                                                            }else{
                                                                                                $sold = null;
                                                                                            }
                                                                                        @endphp
                                            
                                                                                        <div class="col-md-12 col-12">
                                                                                            <div class="project-card mb-3">
                                                                                                <div class="row">
                                                                                                    <div class="col-md-3">
                                                                                                        <a href="{{ route('project.housings.detail', [$project->slug, $i + 1]) }}"
                                                                                                            style="height: 100%">
                                                                                                            <div class="d-flex" style="height: 100%;">
                                                                                                                <div
                                                                                                                    style="background-color: #dc3545 !important; border-radius: 0px 8px 0px 8px;height:100%">
                                                                                                                    <p
                                                                                                                        style="padding: 10px; color: white; height: 100%; display: flex; align-items: center;text-align:center; ">
                                                                                                                        No
                                                                                                                         <br>{{ $i + 1 - $lastHousingCount}}</p>
                                                                                                                </div>
                                                                                                                <div class="project-single mb-0 bb-0 aos-init aos-animate"
                                                                                                                    data-aos="fade-up">
                                                                                                                    <div class="project-inner project-head">
                                            
                                                                                                                        <div class="button-effect">
                                                                                                                            <div href="javascript:void()"
                                                                                                                                class="btn toggle-project-favorite bg-white"
                                                                                                                                data-project-housing-id="{{ $i + 1 }}"
                                                                                                                                data-project-id={{ $project->id }}>
                                                                                                                                <i class="fa fa-heart-o"></i>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div class="homes position-relative">
                                                                                                                            <!-- homes img -->
                                                                                                                            <img src="{{ URL::to('/') . '/project_housing_images/' . getData($project, 'image[]', $i + 1)->value }}"
                                                                                                                                alt="home-1"
                                                                                                                                class="img-responsive"
                                                                                                                                style="height: 120px !important;object-fit:cover">
                                                                                                                            @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                                <div
                                                                                                                                    style="z-index: 2;right: 0;top: 0;background: #e54242; width: 96px; height: 96px; position: absolute; clip-path: polygon(0 0, 45% 0, 100% 55%, 100% 100%);">
                                                                                                                                    <div
                                                                                                                                        style="color: #FFF; transform: rotate(45deg); margin-left: 25px; margin-top: 30px; font-weight: bold;">
                                                                                                                                        {{ '%' . round(($offer->discount_amount / getData($project, 'price[]', $i + 1)->value) * 100) }}
                                                                                                                                        <svg viewBox="0 0 24 24"
                                                                                                                                            width="16"
                                                                                                                                            height="16"
                                                                                                                                            stroke="currentColor"
                                                                                                                                            stroke-width="2"
                                                                                                                                            fill="none"
                                                                                                                                            stroke-linecap="round"
                                                                                                                                            stroke-linejoin="round"
                                                                                                                                            class="css-i6dzq1"
                                                                                                                                            style="transform: rotate(45deg);">
                                                                                                                                            <polyline
                                                                                                                                                points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                                                                                            </polyline>
                                                                                                                                            <polyline
                                                                                                                                                points="17 18 23 18 23 12">
                                                                                                                                            </polyline>
                                                                                                                                        </svg>
                                                                                                                                    </div>
                                            
                                                                                                                                </div>
                                                                                                                            @endif
                                                                                                                        </div>
                                            
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </a>
                                                                                                    </div>
                                            
                                            
                                                                                                    <div class="col-lg-9 col-md-9 homes-content pb-0 mb-44 aos-init aos-animate"
                                                                                                        data-aos="fade-up"
                                                                                                        @if ($sold && $sold->status != "2" || getData($project, 'off_sale[]', $i + 1)->value != '[]') style="background: #EEE !important;" @endif>
                                            
                                                                                                        <div
                                                                                                            class="row align-items-center justify-content-between mobile-position">
                                                                                                            <div class="col-md-8">
                                            
                                                                                                                <div class="homes-list-div">
                                                                                                                    <ul class="homes-list clearfix pb-3 d-flex">
                                                                                                                        <li class="d-flex align-items-center itemCircleFont">
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
                                                                                                                                    {{ getData($project, $project->listItemValues->column1_name . '[]', $i + 1)->value }}
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
                                                                                                                                    {{ getData($project, $project->listItemValues->column2_name . '[]', $i + 1)->value }}
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
                                                                                                                                    {{ getData($project, $project->listItemValues->column3_name . '[]', $i + 1)->value }}
                                                                                                                                    @if (isset($project->listItemValues) &&
                                                                                                                                            isset($project->listItemValues->column3_additional) &&
                                                                                                                                            $project->listItemValues->column3_additional)
                                                                                                                                        {{ $project->listItemValues->column3_additional }}
                                                                                                                                    @endif
                                                                                                                                </span>
                                                                                                                            </li>
                                                                                                                        @endif
                                            
                                                                                                                        <li class="the-icons mobile-hidden">
                                                                                                                            <span>
                                                                                                                                @if (getData($project, 'off_sale[]', $i + 1)->value == '[]')
                                                                                                                                    @if ($sold)
                                                                                                                                        @if ($sold->status != '1' && $sold->status != '0')
                                                                                                                                            @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                                                <h6
                                                                                                                                                    style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                                                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                                                                                                                                    ₺</h6>
                                                                                                                                                <h6
                                                                                                                                                    style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                                                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                                                    ₺
                                            
                                                                                                                                                </h6>
                                                                                                                                            @else
                                                                                                                                                <h6
                                                                                                                                                    style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                                                    ₺
                                                                                                                                                </h6>
                                                                                                                                            @endif
                                                                                                                                        @endif
                                                                                                                                    @else
                                                                                                                                        @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                                            <h6
                                                                                                                                                style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                                                                                {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                                                                                                                                ₺</h6>
                                                                                                                                            <h6
                                                                                                                                                style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                                                                                {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                                                ₺
                                            
                                                                                                                                            </h6>
                                                                                                                                        @else
                                                                                                                                            <h6
                                                                                                                                                style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                                                {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                                                ₺
                                                                                                                                            </h6>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                @endif
                                            
                                            
                                                                                                                            </span>
                                                                                                                        </li>
                                            
                                            
                                                                                                                    </ul>
                                            
                                                                                                                </div>
                                                                                                                <div class="footer">
                                                                                                                    <a
                                                                                                                        href="{{ route('instituional.profile', Str::slug($project->user->name)) }}">
                                                                                                                        <img src="{{ url('storage/profile_images/' . $project->user->profile_image) }}"
                                                                                                                            alt="" class="mr-2">
                                                                                                                        {{ $project->user->name }}
                                                                                                                    </a>
                                                                                                                    <span class="price-mobile">
                                                                                                                        @if (getData($project, 'off_sale[]', $i + 1)->value == '[]')
                                                                                                                            @if ($sold)
                                                                                                                                @if ($sold->status != '1' && $sold->status != '0')
                                                                                                                                    @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                                        <h6
                                                                                                                                            style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;margin-right:5px">
                                                                                                                                            {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                                            ₺
                                                                                                                                        </h6>
                                                                                                                                        <h6
                                                                                                                                            style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:20px;">
                                                                                                                                            {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                            
                                                                                                                                            ₺</h6>
                                                                                                                                    @else
                                                                                                                                        <h6
                                                                                                                                            style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                                            {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}₺
                                                                                                                                        </h6>
                                                                                                                                    @endif
                                                                                                                                @endif
                                                                                                                            @else
                                                                                                                                @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                                    <h6
                                                                                                                                        style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;margin-right:5px">
                                                                                                                                        {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                                        ₺
                                                                                                                                    </h6>
                                                                                                                                    <h6
                                                                                                                                        style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:20px;">
                                                                                                                                        {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                            
                                                                                                                                        ₺</h6>
                                                                                                                                @else
                                                                                                                                    <h6
                                                                                                                                        style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                                        {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}₺
                                                                                                                                    </h6>
                                                                                                                                @endif
                                                                                                                            @endif
                                                                                                                        @endif
                                            
                                            
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                            </div>
                                            
                                                                                                            <div class="col-md-3 mobile-hidden"
                                                                                                                style="height: 120px;padding:0">
                                                                                                                <div class="homes-button"
                                                                                                                    style="width:100%;height:100%">
                                                                                                                    <button class="first-btn payment-plan-button"
                                                                                                                    project-id="{{ $project->id }}"
                                                                                                                    data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0) || getData($project, 'off_sale[]', $i + 1)->value != '[]') ? '1' : '0' }}"
                                                                                                                    order="{{ $i }}">
                                                                                                                    Ödeme Detayları
                                                                                                            </button>
                                                                                                            
                                                                                                                    @if (getData($project, 'off_sale[]', $i + 1)->value != '[]')
                                                                                                                        <button class="btn second-btn CartBtn"
                                                                                                                            disabled
                                                                                                                            style="background: red !important;width:100%;color:White;height: auto !important">
                                            
                                                                                                                            <span class="text">Satışa
                                                                                                                                Kapatıldı</span>
                                                                                                                        </button>
                                                                                                                    @else
                                                                                                                        @if ($sold && $sold->status != '2')
                                                                                                                            <button class="btn second-btn soldBtn"
                                                                                                                                disabled
                                                                                                                                @if ($sold->status == '0') style="background: orange !important;color:White;height: auto !important" @else  style="background: red !important;color:White;height: auto !important" @endif>
                                                                                                                                @if ($sold->status == '0')
                                                                                                                                    <span class="text">Onay
                                                                                                                                        Bekleniyor</span>
                                                                                                                                @else
                                                                                                                                    <span
                                                                                                                                        class="text">Satıldı</span>
                                                                                                                                @endif
                                                                                                                            </button>
                                                                                                                        @else
                                                                                                                            <button class="CartBtn second-btn"
                                                                                                                                data-type='project'
                                                                                                                                data-project='{{ $project->id }}'
                                                                                                                                style="height: auto !important"
                                                                                                                                data-id='{{ getData($project, 'price[]', $i + 1)->room_order }}'>
                                                                                                                                <span class="IconContainer">
                                                                                                                                    <img src="{{ asset('sc.png') }}"
                                                                                                                                        alt="">
                                                                                                                                </span>
                                                                                                                                <span class="text">Sepete
                                                                                                                                    Ekle</span>
                                                                                                                            </button>
                                                                                                                        @endif
                                                                                                                    @endif
                                            
                                                                                                                </div>
                                                                                                            </div>
                                            
                                            
                                                                                                        </div>
                                            
                                            
                                                                                                    </div>
                                                                                                </div>
                                            
                                                                                            </div>
                                                                                        </div>
                                                                                    @endfor
                                            
                                                                                    <div class="project-housing-pagination">
                                                                                        <ul>
                                                                                            @for($t = 0; $t < $pageCount; $t++)
                                                                                                @php 
                                                                                                    if(isset($startIndex)):
                                                                                                @endphp
                                                                                                    <li @if($t == ($startIndex / 10)) class="active" @endif>{{$t+1}}</li>
                                                                                                @php
                                                                                                    else:
                                                                                                @endphp
                                                                                                    <li @if($t == 0) class="active" @endif>{{$t+1}}</li>
                                                                                                @php
                                                                                                    endif;
                                                                                                @endphp
                                                                                            @endfor
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
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
                                                    <div class="container">
                                                        <div class="row project-filter-reverse blog-pots">
                                                            @for ($i = 0; $i < $project->room_count; $i++)
                                                                @php
                                                                    if(isset($projectCartOrders[$i+1])){
                                                                        $sold = $projectCartOrders[$i+1];
                                                                    }else{
                                                                        $sold = null;
                                                                    }
                                                                @endphp
                                            
                                                                <div class="col-md-12 col-12">
                                                                    <div class="project-card mb-3">
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <a href="{{ route('project.housings.detail', [$project->slug, $i + 1]) }}"
                                                                                    style="height: 100%">
                                                                                    <div class="d-flex" style="height: 100%;">
                                                                                        <div
                                                                                            style="background-color: #dc3545 !important; border-radius: 0px 8px 0px 8px;height:100%">
                                                                                            <p
                                                                                                style="padding: 10px;text-align:center; color: white; height: 100%; display: flex; align-items: center; ">
                                                                                                No<br>{{ $i + 1 }}</p>
                                                                                        </div>
                                                                                        <div class="project-single mb-0 bb-0 aos-init aos-animate"
                                                                                            data-aos="fade-up">
                                                                                            <div class="project-inner project-head">
                                            
                                                                                                <div class="button-effect">
                                                                                                    <div href="javascript:void()"
                                                                                                        class="btn toggle-project-favorite bg-white"
                                                                                                        data-project-housing-id="{{ $i + 1 }}"
                                                                                                        data-project-id={{ $project->id }}>
                                                                                                        <i class="fa fa-heart-o"></i>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="homes position-relative">
                                                                                                    <!-- homes img -->
                                                                                                    <img src="{{ URL::to('/') . '/project_housing_images/' . getData($project, 'image[]', $i + 1)->value }}"
                                                                                                        alt="home-1" class="img-responsive"
                                                                                                        style="height: 120px !important;object-fit:cover">
                                                                                                    @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                        <div
                                                                                                            style="z-index: 2;right: 0;top: 0;background: #e54242; width: 96px; height: 96px; position: absolute; clip-path: polygon(0 0, 45% 0, 100% 55%, 100% 100%);">
                                                                                                            <div
                                                                                                                style="color: #FFF; transform: rotate(45deg); margin-left: 25px; margin-top: 30px; font-weight: bold;">
                                                                                                                {{ '%' . round(($offer->discount_amount / getData($project, 'price[]', $i + 1)->value) * 100) }}
                                                                                                                <svg viewBox="0 0 24 24" width="16"
                                                                                                                    height="16" stroke="currentColor"
                                                                                                                    stroke-width="2" fill="none"
                                                                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                                                                    class="css-i6dzq1"
                                                                                                                    style="transform: rotate(45deg);">
                                                                                                                    <polyline points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                                                                    </polyline>
                                                                                                                    <polyline points="17 18 23 18 23 12">
                                                                                                                    </polyline>
                                                                                                                </svg>
                                                                                                            </div>
                                            
                                                                                                        </div>
                                                                                                    @endif
                                                                                                </div>
                                            
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                            
                                            
                                                                            <div class="col-lg-9 col-md-9 homes-content pb-0 mb-44 aos-init aos-animate"
                                                                                data-aos="fade-up"
                                                                                @if ($sold && $sold->status != "2" || getData($project, 'off_sale[]', $i + 1)->value != '[]') style="background: #EEE !important;" @endif>
                                            
                                                                                <div class="row align-items-center justify-content-between mobile-position">
                                                                                    <div class="col-md-8">
                                            
                                                                                        <div class="homes-list-div">
                                                                                            <ul class="homes-list clearfix pb-3 d-flex">
                                                                                                <li class="d-flex align-items-center itemCircleFont">
                                                                                                    <i class="fa fa-circle circleIcon mr-1" style="color: black;"
                                                                                                        aria-hidden="true"></i>
                                                                                                    <span>{{ $project->housingType->title }}</span>
                                                                                                </li>
                                                                                                @if (isset($project->listItemValues) &&
                                                                                                        isset($project->listItemValues->column1_name) &&
                                                                                                        $project->listItemValues->column1_name)
                                                                                                    <li class="d-flex align-items-center itemCircleFont">
                                                                                                        <i class="fa fa-circle circleIcon mr-1"
                                                                                                            aria-hidden="true"></i>
                                                                                                        <span>
                                                                                                            {{ getData($project, $project->listItemValues->column1_name . '[]', $i + 1)->value }}
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
                                                                                                        <i class="fa fa-circle circleIcon mr-1"
                                                                                                            aria-hidden="true"></i>
                                                                                                        <span>
                                                                                                            {{ getData($project, $project->listItemValues->column2_name . '[]', $i + 1)->value }}
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
                                                                                                        <i class="fa fa-circle circleIcon mr-1"
                                                                                                            aria-hidden="true"></i>
                                                                                                        <span>
                                                                                                            {{ getData($project, $project->listItemValues->column3_name . '[]', $i + 1)->value }}
                                                                                                            @if (isset($project->listItemValues) &&
                                                                                                                    isset($project->listItemValues->column3_additional) &&
                                                                                                                    $project->listItemValues->column3_additional)
                                                                                                                {{ $project->listItemValues->column3_additional }}
                                                                                                            @endif
                                                                                                        </span>
                                                                                                    </li>
                                                                                                @endif
                                            
                                                                                                <li class="the-icons mobile-hidden">
                                                                                                    <span>
                                                                                                        @if (getData($project, 'off_sale[]', $i + 1)->value == '[]')
                                                                                                            @if ($sold)
                                                                                                                @if ($sold->status != '1' && $sold->status != '0')
                                                                                                                    @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                        <h6
                                                                                                                            style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                                                            {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                                                                                                            ₺</h6>
                                                                                                                        <h6
                                                                                                                            style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                                                            {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                            ₺
                                            
                                                                                                                        </h6>
                                                                                                                    @else
                                                                                                                        <h6
                                                                                                                            style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                            {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                            ₺
                                                                                                                        </h6>
                                                                                                                    @endif
                                                                                                                @endif
                                                                                                            @else
                                                                                                                @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                    <h6
                                                                                                                        style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                                                        {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                                                                                                        ₺</h6>
                                                                                                                    <h6
                                                                                                                        style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                                                        {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                        ₺
                                            
                                                                                                                    </h6>
                                                                                                                @else
                                                                                                                    <h6
                                                                                                                        style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                        {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                        ₺
                                                                                                                    </h6>
                                                                                                                @endif
                                                                                                            @endif
                                                                                                        @endif
                                            
                                            
                                                                                                    </span>
                                                                                                </li>
                                            
                                            
                                                                                            </ul>
                                            
                                                                                        </div>
                                                                                        <div class="footer">
                                                                                            <a
                                                                                                href="{{ route('instituional.profile', Str::slug($project->user->name)) }}">
                                                                                                <img src="{{ url('storage/profile_images/' . $project->user->profile_image) }}"
                                                                                                    alt="" class="mr-2"> {{ $project->user->name }}
                                                                                            </a>
                                                                                            <span class="price-mobile">
                                                                                                @if (getData($project, 'off_sale[]', $i + 1)->value == '[]')
                                                                                                    @if ($sold)
                                                                                                        @if ($sold->status != '1' && $sold->status != '0')
                                                                                                            @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                <h6
                                                                                                                    style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;margin-right:5px">
                                                                                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                    ₺
                                                                                                                </h6>
                                                                                                                <h6
                                                                                                                    style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:20px;">
                                                                                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                            
                                                                                                                    ₺</h6>
                                                                                                            @else
                                                                                                                <h6
                                                                                                                    style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}₺
                                                                                                                </h6>
                                                                                                            @endif
                                                                                                        @endif
                                                                                                    @else
                                                                                                        @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                            <h6
                                                                                                                style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;margin-right:5px">
                                                                                                                {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                ₺
                                                                                                            </h6>
                                                                                                            <h6
                                                                                                                style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:20px;">
                                                                                                                {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                            
                                                                                                                ₺</h6>
                                                                                                        @else
                                                                                                            <h6
                                                                                                                style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}₺
                                                                                                            </h6>
                                                                                                        @endif
                                                                                                    @endif
                                                                                                @endif
                                            
                                            
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                            
                                                                                    <div class="col-md-3 mobile-hidden" style="height: 120px;padding:0">
                                                                                        <div class="homes-button" style="width:100%;height:100%">
                                                                                            <button class="first-btn payment-plan-button"
                                                                                                                    project-id="{{ $project->id }}"
                                                                                                                    data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0) || getData($project, 'off_sale[]', $i + 1)->value != '[]') ? '1' : '0' }}"
                                                                                                                    order="{{ $i }}">
                                                                                                                    Ödeme Detayları
                                                                                                            </button>
                                                                                    
                                                                                            @if (getData($project, 'off_sale[]', $i + 1)->value != '[]')
                                                                                                <button class="btn second-btn CartBtn" disabled
                                                                                                    style="background: red !important;width:100%;color:White;height: auto !important">
                                            
                                                                                                    <span class="text">Satışa Kapatıldı</span>
                                                                                                </button>
                                                                                            @else
                                                                                                @if ($sold && $sold->status != '2')
                                                                                                    <button class="btn second-btn soldBtn" disabled
                                                                                                        @if ($sold->status == '0') style="background: orange !important;color:White;height: auto !important"
                                                                                        @else 
                                                                                        style="background: red !important;color:White;height: auto !important" @endif>
                                                                                                        @if ($sold->status == '0')
                                                                                                            <span class="text">Onay Bekleniyor</span>
                                                                                                        @else
                                                                                                            <span class="text">Satıldı</span>
                                                                                                        @endif
                                                                                                    </button>
                                                                                                @else
                                                                                                    <button class="CartBtn second-btn" data-type='project'
                                                                                                        data-project='{{ $project->id }}'
                                                                                                        style="height: auto !important"
                                                                                                        data-id='{{ getData($project, 'price[]', $i + 1)->room_order }}'>
                                                                                                        <span class="IconContainer">
                                                                                                            <img src="{{ asset('sc.png') }}" alt="">
                                                                                                        </span>
                                                                                                        <span class="text">Sepete Ekle</span>
                                                                                                    </button>
                                                                                                @endif
                                                                                            @endif
                                            
                                                                                        </div>
                                                                                    </div>
                                            
                                            
                                                                                </div>
                                            
                                            
                                                                            </div>
                                                                        </div>
                                            
                                                                    </div>
                                                                </div>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                            
                                            </div>
                                            @endif

                                        </div>
                                        <div class="tab-pane fad blog-info details mb-30" id="payment" role="tabpanel"
                                            aria-labelledby="payment">
                                            <table class="payment-plan-table table">
                                                <thead>
                                                    <tr>
                                                        <th>Ödeme Türü</th>
                                                        <th>Fiyat</th>
                                                        <th>Taksit Sayısı</th>
                                                        <th>Peşin Ödenecek Tutar</th>
                                                        <th>Aylık Ödenecek Tutar</th>
                                                    </tr>

                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                            data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                            aria-selected="true">Açıklama</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                            data-bs-target="#profile" type="button" role="tab"
                                            aria-controls="profile" aria-selected="false">Özellikler</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                            data-bs-target="#contact" type="button" role="tab"
                                            aria-controls="contact" aria-selected="false">Projedeki Diğer
                                            Konutlar</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link payment-plan-tab" id="payment-tab" data-bs-toggle="tab"
                                            data-bs-target="#payment" type="button" role="tab"
                                            aria-controls="payment" project-id="{{ $project->id }}"
                                            order="{{ $housingOrder }}" aria-selected="false">Ödeme Planı</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active blog-info details mb-30" id="home"
                                        role="tabpanel" aria-labelledby="home-tab">
                                        {!! $project->description !!}
                                    </div>
                                    <div class="tab-pane fade blog-info details" id="profile" role="tabpanel"
                                        aria-labelledby="profile-tab">
                                        <div class="similar-property featured portfolio p-0 bg-white">

                                            <div class="single homes-content">
                                                <h5 class="mb-4">Özellikler</h5>

                                               <table class="table table-bordered">
                                                    <tbody class="trStyle"> 
                                                                <tr>
                                                                    <td>
                                                                        <span class="mr-1">İlan No:</span>
                                                                        <span class="det" style="color: black;">
                                                                            {{ $housingOrder + $project->id + 2000000 }}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                
                                                        @foreach ($projectHousingSetting as $key => $housingSetting)
                                                            @php
                                                                $isArrayCheck = $housingSetting->is_array;
                                                                $onProject = false;
                                                                $valueArray = [];

                                                             
                                                                    if ($isArrayCheck) {
                                                                    $valueArray = json_decode($projectHousing[$housingSetting->column_name . '[]']['value']);
                                                                    if(isset($valueArray))
                                                                    {
                                                                         $value = implodeData($valueArray);
                                                                    }
                                                                   
                                                                } elseif ($housingSetting->is_parent_table) {
                                                                    $value = $project[$housingSetting->column_name];
                                                                    $onProject = true;
                                                                } else {
                                                                    foreach ($project->roomInfo as $roomInfo) {
                                                                    if ($roomInfo->room_order == $housingOrder) {
                                                                        if ($roomInfo['name'] === $housingSetting->column_name . '[]') {
                                                                        if ($roomInfo['value'] == '["on"]') {
                                                                            $value = 'Evet';
                                                                        } elseif ($roomInfo['value'] == '["off"]') {
                                                                            $value = 'Hayır';
                                                                        } else {
                                                                            $value = $roomInfo['value'];
                                                                        }
                                                                        $onProject = true;
                                                                    }
                                                                }
                                                             
                                                            }
                                                                
                                                                }
                                                               
                                                            @endphp

                                                                @if (!$isArrayCheck && (isset($value) && $value !== ''))
                                                                <tr>
                                                                    @if ($housingSetting->label  == 'Fiyat')
                                                                <td>  <span
                                                                    class=" mr-1">{{ $housingSetting->label  }}:</span>
                                                                <span class="det"
                                                                    style="color: black; ">
                                                                    {{ number_format($value, 0, ',', '.') }} ₺
                                                                </span></td>
                                                                @else
                                                                    <td> <span
                                                                        class=" mr-1">{{ $housingSetting->label }}:</span>{{ $value }}</td>
                                                                        @endif
                                                                </tr>
                                                                

                                                                @endif
                                                        @endforeach

                                                    </tbody>
                                                </table>


 
                                                @foreach ($projectHousingSetting as $housingSetting)
                                                    @php
                                                        $isArrayCheck = $housingSetting->is_array;
                                                        $onProject = false;
                                                        $valueArray = [];

                                                        if ($isArrayCheck) {
                                                            $valueArray = json_decode($projectHousing[$housingSetting->column_name . '[]']['value']);
                                                            if(isset($valueArray))
                                                                    {
                                                                         $value = implodeData($valueArray);
                                                                    }
                                                        } elseif ($housingSetting->is_parent_table) {
                                                            $value = $project[$housingSetting->column_name];
                                                            $onProject = true;
                                                        } else {
                                                            foreach ($project->roomInfo as $roomInfo) {
                                                                if ($roomInfo->room_order == $housingOrder) {
                                                                    if ($roomInfo['name'] === $housingSetting->column_name . '[]') {
                                                                    if ($roomInfo['value'] == '["on"]') {
                                                                        $value = 'Evet';
                                                                    } elseif ($roomInfo['value'] == '["off"]') {
                                                                        $value = 'Hayır';
                                                                    } else {
                                                                        $value = $roomInfo['value'];
                                                                    }
                                                                    $onProject = true;
                                                                }
                                                                }
                                                             
                                                            }
                                                        }
                                                    @endphp

                                                    @if ($isArrayCheck)
                                                        @if (isset($valueArray))
                                                            <div class="mt-5">
                                                                <h5>{{ $projectHousing[$housingSetting->column_name . '[]']['key'] }}:
                                                                </h5>
                                                                <ul class="homes-list clearfix">
                                                                    @foreach ($valueArray as $ozellik)
                                                                        <li><i class="fa fa-check-square"
                                                                                aria-hidden="true"></i><span>{{ $ozellik }}</span>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>


                                        </div>
                                    </div>
                                    <div class="tab-pane fade  blog-info details" id="contact" role="tabpanel"
                                        aria-labelledby="contact-tab">
                                        @if ($project->have_blocks == 1)
                                        <div class="ui-elements properties-right list featured portfolio blog pb-5 bg-white">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 ">
                                                        <div class="tabbed-content button-tabs">
                                                            <ul class="tabs">
                                                                @foreach ($project->blocks as $key => $block)
                                                                    <li class="nav-item {{ $key == $blockIndex ? ' active' : '' }}" role="presentation"
                                                                        onclick="changeTabContent('{{ $block['id'] }}')">
                                                                        <div class="tab-title">
                                                                            <span>{{ $block['block_name'] }}</span>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                        
                                                            @foreach ($project->blocks as $key => $block)
                                                                <div id="content-{{ $block['id'] }}" class="tab-content{{ $loop->first ? ' active' : '' }}">
                                                                    @php
                                                                    $j = -1; 
                                                                        $blockHousingCount = $block['housing_count'];
                                                                        if ($key > 0) {
                                                                            $previousBlockHousingCount = $project->blocks[$key - 1]['housing_count'];
                                                                            $i = $previousBlockHousingCount;
                                                                            $j = -1; // Bir önceki bloğun housing_count değerinden başlat
                                                                            $blockHousingCount = $previousBlockHousingCount;
                                                                    } else {
                                                                        $i = 0; 
                                                                                                        }
                                                                                                        
                                                                    $pageCount = $currentBlockHouseCount / 10;
                                                                    @endphp
                                        
                                                                    <div class="mobile-hidden">
                                                                        <div class="container">
                                                                            <div class="row project-filter-reverse blog-pots">
                                                                                @for ($i = $startIndex; $i < $endIndex; $i++)
                                                                                    @php
                                                                                        $j++;
                                                                                        if(isset($projectCartOrders[$i+1])){
                                                                                            $sold = $projectCartOrders[$i+1];
                                                                                        }else{
                                                                                            $sold = null;
                                                                                        }
                                                                                    @endphp
                                        
                                                                                    <div class="col-md-12 col-12">
                                                                                        <div class="project-card mb-3">
                                                                                            <div class="row">
                                                                                                <div class="col-md-3">
                                                                                                    <a href="{{ route('project.housings.detail', [$project->slug, $i + 1]) }}"
                                                                                                        style="height: 100%">
                                                                                                        <div class="d-flex" style="height: 100%;">
                                                                                                            <div
                                                                                                                style="background-color: #dc3545 !important; border-radius: 0px 8px 0px 8px;height:100%">
                                                                                                                <p
                                                                                                                    style="padding: 10px; color: white; height: 100%; display: flex; align-items: center;text-align:center; ">
                                                                                                                    No
                                                                                                                     <br>{{ $i + 1 - $lastHousingCount}}</p>
                                                                                                            </div>
                                                                                                            <div class="project-single mb-0 bb-0 aos-init aos-animate"
                                                                                                                data-aos="fade-up">
                                                                                                                <div class="project-inner project-head">
                                        
                                                                                                                    <div class="button-effect">
                                                                                                                        <div href="javascript:void()"
                                                                                                                            class="btn toggle-project-favorite bg-white"
                                                                                                                            data-project-housing-id="{{ $i + 1 }}"
                                                                                                                            data-project-id={{ $project->id }}>
                                                                                                                            <i class="fa fa-heart-o"></i>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="homes position-relative">
                                                                                                                        <!-- homes img -->
                                                                                                                        <img src="{{ URL::to('/') . '/project_housing_images/' . getData($project, 'image[]', $i + 1)->value }}"
                                                                                                                            alt="home-1"
                                                                                                                            class="img-responsive"
                                                                                                                            style="height: 120px !important;object-fit:cover">
                                                                                                                        @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                            <div
                                                                                                                                style="z-index: 2;right: 0;top: 0;background: #e54242; width: 96px; height: 96px; position: absolute; clip-path: polygon(0 0, 45% 0, 100% 55%, 100% 100%);">
                                                                                                                                <div
                                                                                                                                    style="color: #FFF; transform: rotate(45deg); margin-left: 25px; margin-top: 30px; font-weight: bold;">
                                                                                                                                    {{ '%' . round(($offer->discount_amount / getData($project, 'price[]', $i + 1)->value) * 100) }}
                                                                                                                                    <svg viewBox="0 0 24 24"
                                                                                                                                        width="16"
                                                                                                                                        height="16"
                                                                                                                                        stroke="currentColor"
                                                                                                                                        stroke-width="2"
                                                                                                                                        fill="none"
                                                                                                                                        stroke-linecap="round"
                                                                                                                                        stroke-linejoin="round"
                                                                                                                                        class="css-i6dzq1"
                                                                                                                                        style="transform: rotate(45deg);">
                                                                                                                                        <polyline
                                                                                                                                            points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                                                                                        </polyline>
                                                                                                                                        <polyline
                                                                                                                                            points="17 18 23 18 23 12">
                                                                                                                                        </polyline>
                                                                                                                                    </svg>
                                                                                                                                </div>
                                        
                                                                                                                            </div>
                                                                                                                        @endif
                                                                                                                    </div>
                                        
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </a>
                                                                                                </div>
                                        
                                        
                                                                                                <div class="col-lg-9 col-md-9 homes-content pb-0 mb-44 aos-init aos-animate"
                                                                                                    data-aos="fade-up"
                                                                                                    @if ($sold && $sold->status != "2" || getData($project, 'off_sale[]', $i + 1)->value != '[]') style="background: #EEE !important;" @endif>
                                        
                                                                                                    <div
                                                                                                        class="row align-items-center justify-content-between mobile-position">
                                                                                                        <div class="col-md-8">
                                        
                                                                                                            <div class="homes-list-div">
                                                                                                                <ul class="homes-list clearfix pb-3 d-flex">
                                                                                                                    <li class="d-flex align-items-center itemCircleFont">
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
                                                                                                                                {{ getData($project, $project->listItemValues->column1_name . '[]', $i + 1)->value }}
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
                                                                                                                                {{ getData($project, $project->listItemValues->column2_name . '[]', $i + 1)->value }}
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
                                                                                                                                {{ getData($project, $project->listItemValues->column3_name . '[]', $i + 1)->value }}
                                                                                                                                @if (isset($project->listItemValues) &&
                                                                                                                                        isset($project->listItemValues->column3_additional) &&
                                                                                                                                        $project->listItemValues->column3_additional)
                                                                                                                                    {{ $project->listItemValues->column3_additional }}
                                                                                                                                @endif
                                                                                                                            </span>
                                                                                                                        </li>
                                                                                                                    @endif
                                        
                                                                                                                    <li class="the-icons mobile-hidden">
                                                                                                                        <span>
                                                                                                                            @if (getData($project, 'off_sale[]', $i + 1)->value == '[]')
                                                                                                                                @if ($sold)
                                                                                                                                    @if ($sold->status != '1' && $sold->status != '0')
                                                                                                                                        @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                                            <h6
                                                                                                                                                style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                                                                                {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                                                                                                                                ₺</h6>
                                                                                                                                            <h6
                                                                                                                                                style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                                                                                {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                                                ₺
                                        
                                                                                                                                            </h6>
                                                                                                                                        @else
                                                                                                                                            <h6
                                                                                                                                                style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                                                {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                                                ₺
                                                                                                                                            </h6>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                @else
                                                                                                                                    @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                                        <h6
                                                                                                                                            style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                                                                            {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                                                                                                                            ₺</h6>
                                                                                                                                        <h6
                                                                                                                                            style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                                                                            {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                                            ₺
                                        
                                                                                                                                        </h6>
                                                                                                                                    @else
                                                                                                                                        <h6
                                                                                                                                            style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                                            {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                                            ₺
                                                                                                                                        </h6>
                                                                                                                                    @endif
                                                                                                                                @endif
                                                                                                                            @endif
                                        
                                        
                                                                                                                        </span>
                                                                                                                    </li>
                                        
                                        
                                                                                                                </ul>
                                        
                                                                                                            </div>
                                                                                                            <div class="footer">
                                                                                                                <a
                                                                                                                    href="{{ route('instituional.profile', Str::slug($project->user->name)) }}">
                                                                                                                    <img src="{{ url('storage/profile_images/' . $project->user->profile_image) }}"
                                                                                                                        alt="" class="mr-2">
                                                                                                                    {{ $project->user->name }}
                                                                                                                </a>
                                                                                                                <span class="price-mobile">
                                                                                                                    @if (getData($project, 'off_sale[]', $i + 1)->value == '[]')
                                                                                                                        @if ($sold)
                                                                                                                            @if ($sold->status != '1' && $sold->status != '0')
                                                                                                                                @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                                    <h6
                                                                                                                                        style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;margin-right:5px">
                                                                                                                                        {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                                        ₺
                                                                                                                                    </h6>
                                                                                                                                    <h6
                                                                                                                                        style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:20px;">
                                                                                                                                        {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                        
                                                                                                                                        ₺</h6>
                                                                                                                                @else
                                                                                                                                    <h6
                                                                                                                                        style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                                        {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}₺
                                                                                                                                    </h6>
                                                                                                                                @endif
                                                                                                                            @endif
                                                                                                                        @else
                                                                                                                            @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                                <h6
                                                                                                                                    style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;margin-right:5px">
                                                                                                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                                    ₺
                                                                                                                                </h6>
                                                                                                                                <h6
                                                                                                                                    style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:20px;">
                                                                                                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                        
                                                                                                                                    ₺</h6>
                                                                                                                            @else
                                                                                                                                <h6
                                                                                                                                    style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}₺
                                                                                                                                </h6>
                                                                                                                            @endif
                                                                                                                        @endif
                                                                                                                    @endif
                                        
                                        
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                        
                                                                                                        <div class="col-md-3 mobile-hidden"
                                                                                                            style="height: 120px;padding:0">
                                                                                                            <div class="homes-button"
                                                                                                                style="width:100%;height:100%">
                                                                                                                <button class="first-btn payment-plan-button"
                                                                                                                project-id="{{ $project->id }}"
                                                                                                                data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0) || getData($project, 'off_sale[]', $i + 1)->value != '[]') ? '1' : '0' }}"
                                                                                                                order="{{ $i }}">
                                                                                                                Ödeme Detayları
                                                                                                        </button>
                                                                                                        
                                                                                                                @if (getData($project, 'off_sale[]', $i + 1)->value != '[]')
                                                                                                                    <button class="btn second-btn CartBtn"
                                                                                                                        disabled
                                                                                                                        style="background: red !important;width:100%;color:White;height: auto !important">
                                        
                                                                                                                        <span class="text">Satışa
                                                                                                                            Kapatıldı</span>
                                                                                                                    </button>
                                                                                                                @else
                                                                                                                    @if ($sold && $sold->status != '2')
                                                                                                                        <button class="btn second-btn soldBtn"
                                                                                                                            disabled
                                                                                                                            @if ($sold->status == '0') style="background: orange !important;color:White;height: auto !important" @else  style="background: red !important;color:White;height: auto !important" @endif>
                                                                                                                            @if ($sold->status == '0')
                                                                                                                                <span class="text">Onay
                                                                                                                                    Bekleniyor</span>
                                                                                                                            @else
                                                                                                                                <span
                                                                                                                                    class="text">Satıldı</span>
                                                                                                                            @endif
                                                                                                                        </button>
                                                                                                                    @else
                                                                                                                        <button class="CartBtn second-btn"
                                                                                                                            data-type='project'
                                                                                                                            data-project='{{ $project->id }}'
                                                                                                                            style="height: auto !important"
                                                                                                                            data-id='{{ getData($project, 'price[]', $i + 1)->room_order }}'>
                                                                                                                            <span class="IconContainer">
                                                                                                                                <img src="{{ asset('sc.png') }}"
                                                                                                                                    alt="">
                                                                                                                            </span>
                                                                                                                            <span class="text">Sepete
                                                                                                                                Ekle</span>
                                                                                                                        </button>
                                                                                                                    @endif
                                                                                                                @endif
                                        
                                                                                                            </div>
                                                                                                        </div>
                                        
                                        
                                                                                                    </div>
                                        
                                        
                                                                                                </div>
                                                                                            </div>
                                        
                                                                                        </div>
                                                                                    </div>
                                                                                @endfor
                                        
                                                                                <div class="project-housing-pagination">
                                                                                    <ul>
                                                                                        @for($t = 0; $t < $pageCount; $t++)
                                                                                            @php 
                                                                                                if(isset($startIndex)):
                                                                                            @endphp
                                                                                                <li @if($t == ($startIndex / 10)) class="active" @endif>{{$t+1}}</li>
                                                                                            @php
                                                                                                else:
                                                                                            @endphp
                                                                                                <li @if($t == 0) class="active" @endif>{{$t+1}}</li>
                                                                                            @php
                                                                                                endif;
                                                                                            @endphp
                                                                                        @endfor
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
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
                                                <div class="container">
                                                    <div class="row project-filter-reverse blog-pots">
                                                        @for ($i = 0; $i < $project->room_count; $i++)
                                                            @php
                                                                if(isset($projectCartOrders[$i+1])){
                                                                    $sold = $projectCartOrders[$i+1];
                                                                }else{
                                                                    $sold = null;
                                                                }
                                                            @endphp
                                        
                                                            <div class="col-md-12 col-12">
                                                                <div class="project-card mb-3">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <a href="{{ route('project.housings.detail', [$project->slug, $i + 1]) }}"
                                                                                style="height: 100%">
                                                                                <div class="d-flex" style="height: 100%;">
                                                                                    <div
                                                                                        style="background-color: #dc3545 !important; border-radius: 0px 8px 0px 8px;height:100%">
                                                                                        <p
                                                                                            style="padding: 10px;text-align:center; color: white; height: 100%; display: flex; align-items: center; ">
                                                                                            No<br>{{ $i + 1 }}</p>
                                                                                    </div>
                                                                                    <div class="project-single mb-0 bb-0 aos-init aos-animate"
                                                                                        data-aos="fade-up">
                                                                                        <div class="project-inner project-head">
                                        
                                                                                            <div class="button-effect">
                                                                                                <div href="javascript:void()"
                                                                                                    class="btn toggle-project-favorite bg-white"
                                                                                                    data-project-housing-id="{{ $i + 1 }}"
                                                                                                    data-project-id={{ $project->id }}>
                                                                                                    <i class="fa fa-heart-o"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="homes position-relative">
                                                                                                <!-- homes img -->
                                                                                                <img src="{{ URL::to('/') . '/project_housing_images/' . getData($project, 'image[]', $i + 1)->value }}"
                                                                                                    alt="home-1" class="img-responsive"
                                                                                                    style="height: 120px !important;object-fit:cover">
                                                                                                @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                    <div
                                                                                                        style="z-index: 2;right: 0;top: 0;background: #e54242; width: 96px; height: 96px; position: absolute; clip-path: polygon(0 0, 45% 0, 100% 55%, 100% 100%);">
                                                                                                        <div
                                                                                                            style="color: #FFF; transform: rotate(45deg); margin-left: 25px; margin-top: 30px; font-weight: bold;">
                                                                                                            {{ '%' . round(($offer->discount_amount / getData($project, 'price[]', $i + 1)->value) * 100) }}
                                                                                                            <svg viewBox="0 0 24 24" width="16"
                                                                                                                height="16" stroke="currentColor"
                                                                                                                stroke-width="2" fill="none"
                                                                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                                                                class="css-i6dzq1"
                                                                                                                style="transform: rotate(45deg);">
                                                                                                                <polyline points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                                                                </polyline>
                                                                                                                <polyline points="17 18 23 18 23 12">
                                                                                                                </polyline>
                                                                                                            </svg>
                                                                                                        </div>
                                        
                                                                                                    </div>
                                                                                                @endif
                                                                                            </div>
                                        
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                        
                                        
                                                                        <div class="col-lg-9 col-md-9 homes-content pb-0 mb-44 aos-init aos-animate"
                                                                            data-aos="fade-up"
                                                                            @if ($sold && $sold->status != "2" || getData($project, 'off_sale[]', $i + 1)->value != '[]') style="background: #EEE !important;" @endif>
                                        
                                                                            <div class="row align-items-center justify-content-between mobile-position">
                                                                                <div class="col-md-8">
                                        
                                                                                    <div class="homes-list-div">
                                                                                        <ul class="homes-list clearfix pb-3 d-flex">
                                                                                            <li class="d-flex align-items-center itemCircleFont">
                                                                                                <i class="fa fa-circle circleIcon mr-1" style="color: black;"
                                                                                                    aria-hidden="true"></i>
                                                                                                <span>{{ $project->housingType->title }}</span>
                                                                                            </li>
                                                                                            @if (isset($project->listItemValues) &&
                                                                                                    isset($project->listItemValues->column1_name) &&
                                                                                                    $project->listItemValues->column1_name)
                                                                                                <li class="d-flex align-items-center itemCircleFont">
                                                                                                    <i class="fa fa-circle circleIcon mr-1"
                                                                                                        aria-hidden="true"></i>
                                                                                                    <span>
                                                                                                        {{ getData($project, $project->listItemValues->column1_name . '[]', $i + 1)->value }}
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
                                                                                                    <i class="fa fa-circle circleIcon mr-1"
                                                                                                        aria-hidden="true"></i>
                                                                                                    <span>
                                                                                                        {{ getData($project, $project->listItemValues->column2_name . '[]', $i + 1)->value }}
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
                                                                                                    <i class="fa fa-circle circleIcon mr-1"
                                                                                                        aria-hidden="true"></i>
                                                                                                    <span>
                                                                                                        {{ getData($project, $project->listItemValues->column3_name . '[]', $i + 1)->value }}
                                                                                                        @if (isset($project->listItemValues) &&
                                                                                                                isset($project->listItemValues->column3_additional) &&
                                                                                                                $project->listItemValues->column3_additional)
                                                                                                            {{ $project->listItemValues->column3_additional }}
                                                                                                        @endif
                                                                                                    </span>
                                                                                                </li>
                                                                                            @endif
                                        
                                                                                            <li class="the-icons mobile-hidden">
                                                                                                <span>
                                                                                                    @if (getData($project, 'off_sale[]', $i + 1)->value == '[]')
                                                                                                        @if ($sold)
                                                                                                            @if ($sold->status != '1' && $sold->status != '0')
                                                                                                                @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                    <h6
                                                                                                                        style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                                                        {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                                                                                                        ₺</h6>
                                                                                                                    <h6
                                                                                                                        style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                                                        {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                        ₺
                                        
                                                                                                                    </h6>
                                                                                                                @else
                                                                                                                    <h6
                                                                                                                        style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                        {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                        ₺
                                                                                                                    </h6>
                                                                                                                @endif
                                                                                                            @endif
                                                                                                        @else
                                                                                                            @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                                <h6
                                                                                                                    style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                                                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                                                                                                    ₺</h6>
                                                                                                                <h6
                                                                                                                    style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;">
                                                                                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                    ₺
                                        
                                                                                                                </h6>
                                                                                                            @else
                                                                                                                <h6
                                                                                                                    style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                    ₺
                                                                                                                </h6>
                                                                                                            @endif
                                                                                                        @endif
                                                                                                    @endif
                                        
                                        
                                                                                                </span>
                                                                                            </li>
                                        
                                        
                                                                                        </ul>
                                        
                                                                                    </div>
                                                                                    <div class="footer">
                                                                                        <a
                                                                                            href="{{ route('instituional.profile', Str::slug($project->user->name)) }}">
                                                                                            <img src="{{ url('storage/profile_images/' . $project->user->profile_image) }}"
                                                                                                alt="" class="mr-2"> {{ $project->user->name }}
                                                                                        </a>
                                                                                        <span class="price-mobile">
                                                                                            @if (getData($project, 'off_sale[]', $i + 1)->value == '[]')
                                                                                                @if ($sold)
                                                                                                    @if ($sold->status != '1' && $sold->status != '0')
                                                                                                        @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                            <h6
                                                                                                                style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;margin-right:5px">
                                                                                                                {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                                ₺
                                                                                                            </h6>
                                                                                                            <h6
                                                                                                                style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:20px;">
                                                                                                                {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                        
                                                                                                                ₺</h6>
                                                                                                        @else
                                                                                                            <h6
                                                                                                                style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                                {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}₺
                                                                                                            </h6>
                                                                                                        @endif
                                                                                                    @endif
                                                                                                @else
                                                                                                    @if ($offer && in_array($i + 1, json_decode($offer->project_housings)))
                                                                                                        <h6
                                                                                                            style="color: #dc3545 !important;position: relative;top:4px;font-weight:600;font-size: 12px;text-decoration:line-through;margin-right:5px">
                                                                                                            {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}
                                                                                                            ₺
                                                                                                        </h6>
                                                                                                        <h6
                                                                                                            style="color: #e54242;position: relative;top:4px;font-weight:600;font-size:20px;">
                                                                                                            {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 0, ',', '.') }}
                                        
                                                                                                            ₺</h6>
                                                                                                    @else
                                                                                                        <h6
                                                                                                            style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                                                            {{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}₺
                                                                                                        </h6>
                                                                                                    @endif
                                                                                                @endif
                                                                                            @endif
                                        
                                        
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                        
                                                                                <div class="col-md-3 mobile-hidden" style="height: 120px;padding:0">
                                                                                    <div class="homes-button" style="width:100%;height:100%">
                                                                                        <button class="first-btn payment-plan-button"
                                                                                                                project-id="{{ $project->id }}"
                                                                                                                data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0) || getData($project, 'off_sale[]', $i + 1)->value != '[]') ? '1' : '0' }}"
                                                                                                                order="{{ $i }}">
                                                                                                                Ödeme Detayları
                                                                                                        </button>
                                                                                
                                                                                        @if (getData($project, 'off_sale[]', $i + 1)->value != '[]')
                                                                                            <button class="btn second-btn CartBtn" disabled
                                                                                                style="background: red !important;width:100%;color:White;height: auto !important">
                                        
                                                                                                <span class="text">Satışa Kapatıldı</span>
                                                                                            </button>
                                                                                        @else
                                                                                            @if ($sold && $sold->status != '2')
                                                                                                <button class="btn second-btn soldBtn" disabled
                                                                                                    @if ($sold->status == '0') style="background: orange !important;color:White;height: auto !important"
                                                                                    @else 
                                                                                    style="background: red !important;color:White;height: auto !important" @endif>
                                                                                                    @if ($sold->status == '0')
                                                                                                        <span class="text">Onay Bekleniyor</span>
                                                                                                    @else
                                                                                                        <span class="text">Satıldı</span>
                                                                                                    @endif
                                                                                                </button>
                                                                                            @else
                                                                                                <button class="CartBtn second-btn" data-type='project'
                                                                                                    data-project='{{ $project->id }}'
                                                                                                    style="height: auto !important"
                                                                                                    data-id='{{ getData($project, 'price[]', $i + 1)->room_order }}'>
                                                                                                    <span class="IconContainer">
                                                                                                        <img src="{{ asset('sc.png') }}" alt="">
                                                                                                    </span>
                                                                                                    <span class="text">Sepete Ekle</span>
                                                                                                </button>
                                                                                            @endif
                                                                                        @endif
                                        
                                                                                    </div>
                                                                                </div>
                                        
                                        
                                                                            </div>
                                        
                                        
                                                                        </div>
                                                                    </div>
                                        
                                                                </div>
                                                            </div>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        
                                        
                                        </div>
                                        @endif

                                    </div>
                                    <div class="tab-pane fad blog-info details mb-30" id="payment" role="tabpanel"
                                        aria-labelledby="payment">
                                        <table class="payment-plan-table table">
                                            <thead>
                                                <tr>
                                                    <th>Ödeme Türü</th>
                                                    <th>Fiyat</th>
                                                    <th>Taksit Sayısı</th>
                                                    <th>Peşin Ödenecek Tutar</th>
                                                    <th>Aylık Ödenecek Tutar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

            @endif


        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        if ($(window).width() <= 768) {

       var buyBtn =  $(".buyBtn").html();
            $("#listingDetailsSlider").after(buyBtn);
            $(".buyBtn").css("display", "none");

        };
        
        $('.project-housing-pagination li').click(function(){
            $('.loading-full').removeClass('d-none')
            console.log($(this).index());
            $.ajax({
                url: "{{ URL::to('/') }}/proje_konut_detayi_ajax/{{$project->slug}}/{{$housingOrder}}?selected_page="+$(this).index()+"&block_id="+$('.tabs .nav-item.active').index(), // Sepete veri eklemek için uygun URL'yi belirtin
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

        $('.tabs .nav-item').click(function(){
            $('.loading-full').removeClass('d-none')
            $.ajax({
                url: "{{ URL::to('/') }}/proje_konut_detayi_ajax/{{$project->slug}}/{{$housingOrder}}?selected_page=0"+"&block_id="+$(this).index(), // Sepete veri eklemek için uygun URL'yi belirtin
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
        $('.listingDetailsSliderNav').slick({
            slidesToShow: 5,
            slidesToScroll: 4,
            dots: false,
            loop: true,
            autoplay: false,
            arrows: false,
            margin: 20,
            adaptiveHeight: true,
            responsive: [{
                breakpoint: 993,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 2,
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
        $('.payment-plan-tab').click(function() {
            showLoadingSpinner();

            var order = $(this).attr('order');
            var cart = {
                project_id: $(this).attr('project-id'),
                order: $(this).attr('order'),
                _token: "{{ csrf_token() }}"
            };

            var paymentPlanDatax = {
                "pesin": "Peşin",
                "taksitli": "Taksitli"
            }

            function getDataJS(project, key, roomOrder) {
                var a = 0;
                project.room_info.forEach((room) => {
                    if (room.room_order == roomOrder && room.name == key) {
                        a = room.value;
                    }
                })

                return a;

            }
            // Ajax isteği gönderme


            $.ajax({
                url: "{{ route('get.housing.payment.plan') }}", // Sepete veri eklemek için uygun URL'yi belirtin
                type: "get", // Veriyi göndermek için POST kullanabilirsiniz
                data: cart, // Sepete eklemek istediğiniz ürün verilerini gönderin
                success: function(response) {
                    for (var i = 0; i < response.room_info.length; i++) {
                        if (response.room_info[i].name == "payment-plan[]" && response.room_info[i]
                            .room_order == parseInt(order)) {
                            var paymentPlanData = JSON.parse(response.room_info[i].value);


                            var html = "";

                            function formatPrice(number) {
                                number = parseFloat(number);
                                // Sayıyı ondalık kısmı virgülle ayır
                                const parts = number.toFixed(2).toString().split(".");

                                // Virgül ile ayırmak için her üç haneli kısma nokta ekleyin
                                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                                // Sonucu birleştirin ve virgül ile ayırın
                                return parts.join(",");
                            }
                            var tempPlans = [];
                            for (var j = 0; j < paymentPlanData.length; j++) {

                                if (!tempPlans.includes(paymentPlanData[j])) {
                                    if (paymentPlanData[j] == "pesin") {
                                        var priceData = getDataJS(response, "price[]", response
                                            .room_info[i].room_order);
                                        var installementData = "-";
                                        var advanceData = "-";
                                        var monhlyPrice = "-";
                                    } else {
                                        var priceData = getDataJS(response, "installments-price[]",
                                            response.room_info[i].room_order);
                                        var installementData = getDataJS(response, "installments[]",
                                            response.room_info[i].room_order);
                                        var advanceData = formatPrice(getDataJS(response, "advance[]",
                                            response.room_info[i].room_order)) + "₺";
                                        console.log((parseFloat(getDataJS(response,
                                            "installments-price[]", response.room_info[
                                                i].room_order)) - parseFloat(getDataJS(
                                            response, "advance[]", response.room_info[i]
                                            .room_order))));
                                        var monhlyPrice = (formatPrice(((parseFloat(getDataJS(response,
                                                "installments-price[]", response
                                                .room_info[i].room_order)) - parseFloat(
                                                getDataJS(response, "advance[]",
                                                    response.room_info[i].room_order))) /
                                            parseInt(installementData)))) + '₺';
                                    }
                                    html += "<tr>" +
                                        "<td>" + paymentPlanDatax[paymentPlanData[j]] + "</td>" +
                                        "<td>" + formatPrice(priceData) + "₺</td>" +
                                        "<td>" + installementData + "</td>" +
                                        "<td>" + advanceData + "</td>" +
                                        "<td>" + monhlyPrice + "</td>" +
                                        "</tr>"
                                }

                                tempPlans.push(paymentPlanData[j])

                            }

                            hideLoadingSpinner();

                            $('.payment-plan-table tbody').html(html);

                        }
                    }
                },
                error: function(error) {
                    hideLoadingSpinner();
                    toast.error(error)
                    console.error("Hata oluştu: " + error);
                }
            });
        })

        function showLoadingSpinner() {
            // Create a spinner row with colspan
            var spinnerElement = document.createElement('tr');
            spinnerElement.className = 'loading-spinner';

            // Create a single cell with colspan
            var spinnerCell = document.createElement('td');
            spinnerCell.colSpan = 5; // Adjust the colspan value based on the number of columns in your table

            // Add the spinner icon to the cell
            spinnerCell.innerHTML = '<i class="fa fa-spinner fa-spin"></i>'; // Use your preferred spinner

            // Append the cell to the row
            spinnerElement.appendChild(spinnerCell);

            // Append the spinner element to the tbody
            $('.payment-plan-table tbody').html(spinnerElement);
        }


        function hideLoadingSpinner() {
            // Remove the spinner element
            var spinnerElement = document.querySelector('.loading-spinner');
            if (spinnerElement) {
                spinnerElement.parentNode.removeChild(spinnerElement);
            }
        }
        @php
            $location = explode(',', $project->location);
            $location['latitude'] = $location[0];
            $location['longitude'] = $location[1];

            $location = json_encode($location);
            $location = json_decode($location);
        @endphp
        var map = L.map('map').setView([{{ $location->latitude }}, {{ $location->longitude }}], 13);
        var marker = L.marker([{{ $location->latitude }}, {{ $location->longitude }}]).addTo(map);

        // OpenStreetMap katmanını haritaya ekleyin
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var overpassUrl = 'https://overpass-api.de/api/interpreter';
        var query = `[out:json];
(
    node["public_transport"](around:1000,{{ $location->latitude }},{{ $location->longitude }});
    way["public_transport"](around:1000,{{ $location->latitude }},{{ $location->longitude }});
    relation["public_transport"](around:1000,{{ $location->latitude }},{{ $location->longitude }});
);
out center;`;
        var url = `${overpassUrl}?data=${encodeURIComponent(query)}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                var listingsContainer = document.querySelector('.slick-lancersx'); // Listeyi içeren div
                listingsContainer.innerHTML = ''; // Önceki içeriği temizleyin
                data.elements.forEach(element => {
                    var lat = element.lat;
                    var lon = element.lon;
                    var name = element.tags.name || 'Bilinmeyen Mağaza';

                    // Yeni bir liste öğesi oluşturun
                    var listingItem = document.createElement('div');
                    listingItem.classList.add('agents-grid');
                    listingItem.dataset.aos = 'fade-up';
                    listingItem.dataset.aosDelay = '150';
                    if (element.tags.highway == "bus_stop" || element.tags.type == "public_transport") {
                        // Liste içeriğini oluşturun
                        listingItem.innerHTML = `
                    <div class="landscapes" style="width: 140px; border: solid 1px #dcdcdc !important; ">
                        <div class="project-single">
                            <div class="project-inner project-head">
                                <div class="location-card">
                                    <div class="location-card-head">
                                        <img src="#/assets/images/durak:7299b7f721d8e670e9d070f1f816991a.png" alt="">
                                    </div>
                                    <div class="location-card-body">
                                        ${element.tags.type == "public_transport" ? `<p>${name} Metro Durağı </p>` : `<p>${name} Otobüs Durağı</p>`}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;


                        // Listeyi ekrana ekleyin
                        listingsContainer.appendChild(listingItem);
                    }




                });

                $('.slick-lancersx').slick({
                    infinite: false,
                    slidesToShow: 6,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: true,
                    adaptiveHeight: true,
                    responsive: [{
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2,
                                dots: false,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 993,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2,
                                dots: false,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 769,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                dots: false,
                                arrows: false
                            }
                        }
                    ]
                });
            })
            .catch(error => console.error('Hata:', error));

            $(document).ready(function() {
            $(".nav-item-block").click(function() {
                $(".nav-item-block").removeClass("active");
                $(this).addClass("active");
                $(".tab-content-block").hide();
                $(this).children(".tab-content-block").show();
            });
        });

        function changeTabContent(tabName) {
            document.querySelectorAll('.nav-item-block').forEach(function(content) {
                content.classList.remove('active');
            });
            document.querySelectorAll('.tab-content-block').forEach(function(content) {
                content.classList.remove('active');
            });
            document.getElementById('contentblock-' + tabName).classList.add('active');
            document.getElementById('contentblocktab-' + tabName).classList.add('active');
            
        }
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        .storeInfo{
            margin-top:30px;
        }
           .trStyle
        ,.trStyle tr {
            display: flex;
            flex-wrap: wrap;
        }
        .trStyle tr{
            width: 50%;
        }
        .trStyle tr td{ 
            width: 100%;
            font-size: 13px;

        }
        @media (max-width:768px) {
          
            .storeInfo{
                margin-top: 0 !important;
            }
            .trStyle tr{
            width: 100%;
        }
        }
        .tab-content-block{
            display:none
        }
        .tab-content-block.active{
            display:block !important
        }
        .button-effect {
            border: solid 1px #e6e6e6;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .housing-detail-box {
            display: flex;
            align-items: center;
            flex-wrap: wrap
        }
        .mobile-hidden {
            display: flex;
        }

        .desktop-hidden {
            display: none;
        }

        .homes-content .footer {
            display: none
        }

        .price-mobile {
            display: flex;
            align-items: self-end;
        }

        @media (max-width: 768px) {
            .widget-boxed {
                margin-bottom: 30px;
            }
            .car {
                margin-top: 10px
            }

            .mobile-hidden {
                display: none
            }

            .desktop-hidden {
                display: block;
            }

            .mobile-position {
                width: 100%;
                margin: 0 auto;
                box-shadow: 0 0 10px 1px rgba(71, 85, 95, 0.08);
            }

            .inner-pages .portfolio .homes-content .homes-list-div ul {
                flex-wrap: wrap
            }

            .homes-content .footer {
                display: block;
                background: none;
                border-top: 1px solid #e8e8e8;
                padding-top: 1rem;
                font-size: 13px;
                color: #666;
            }



        }


        .loading-spinner {
            text-align: center
        }

        .buttonDetail{
            width:100%;
        }
    </style>
@endsection
