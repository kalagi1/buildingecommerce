@extends('client.layouts.master')

@section('content')
    <div class="loading-full d-none">
        <div class="back-opa">

        </div>
        <div class="content-loading">
            <i class="fa fa-spinner"></i>
        </div>
    </div>
    <div class="brand-head">
        <div class="container">
            <div class="card mb-3">
                <div class="card-img-top" style="background-color: {{ $project->user->banner_hex_code }}">
                    <div class="brands-square">
                        <img src="{{ url('storage/profile_images/' . $project->user->profile_image) }}" alt=""
                            class="brand-logo">
                        <p class="brand-name"><a href="{{ route('instituional.profile', Str::slug($project->user->name)) }}"
                                style="color:White;">
                                {{ $project->user->name }}
                                <style type="text/css">
                                    .st0 {
                                        fill: #e54242;
                                    }

                                    .st1 {
                                        opacity: 0.15;
                                    }

                                    .st2 {
                                        fill: #FFFFFF;
                                    }
                                </style>
                                <svg id="Layer_1" style="enable-background:new 0 0 120 120;" version="1.1" width="24px"
                                    height="24px" viewBox="0 0 120 120" xml:space="preserve"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g>
                                        <path class="st0"
                                            d="M99.5,52.8l-1.9,4.7c-0.6,1.6-0.6,3.3,0,4.9l1.9,4.7c1.1,2.8,0.2,6-2.3,7.8L93,77.8c-1.4,1-2.3,2.5-2.7,4.1   l-0.9,5c-0.6,3-3.1,5.2-6.1,5.3l-5.1,0.2c-1.7,0.1-3.3,0.8-4.5,2l-3.5,3.7c-2.1,2.2-5.4,2.7-8,1.2l-4.4-2.6   c-1.5-0.9-3.2-1.1-4.9-0.7l-5,1.2c-2.9,0.7-6-0.7-7.4-3.4l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8   l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8   l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6c1.4-2.7,4.4-4.1,7.4-3.4l5,1.2c1.6,0.4,3.4,0.2,4.9-0.7l4.4-2.6c2.6-1.5,5.9-1.1,8,1.2   l3.5,3.7c1.2,1.2,2.8,2,4.5,2l5.1,0.2c3,0.1,5.6,2.3,6.1,5.3l0.9,5c0.3,1.7,1.3,3.2,2.7,4.1l4.2,2.9C99.7,46.8,100.7,50,99.5,52.8z   " />
                                        <g class="st1">
                                            <path
                                                d="M43.4,93.5l-2.3-4.6c-0.8-1.5-2.1-2.7-3.7-3.2l-4.8-1.6c-2.9-1-4.7-3.8-4.4-6.8l0.5-5.1c0.2-1.7-0.3-3.4-1.4-4.7l-3.2-4    c-1.9-2.4-1.9-5.7,0-8.1l3.2-4c1.1-1.3,1.6-3,1.4-4.7l-0.5-5.1c-0.3-3,1.5-5.8,4.4-6.8l4.8-1.6c1.6-0.5,2.9-1.7,3.7-3.2l2.3-4.6    c0.8-1.6,2.2-2.7,3.7-3.2c-2.7-0.4-5.4,1-6.6,3.5l-2.3,4.6c-0.8,1.5-2.1,2.7-3.7,3.2l-4.8,1.6c-2.9,1-4.7,3.8-4.4,6.8l0.5,5.1    c0.2,1.7-0.3,3.4-1.4,4.7l-3.2,4c-1.9,2.4-1.9,5.7,0,8.1l3.2,4c1.1,1.3,1.6,3,1.4,4.7l-0.5,5.1c-0.3,3,1.5,5.8,4.4,6.8l4.8,1.6    c1.6,0.5,2.9,1.7,3.7,3.2l2.3,4.6c1.4,2.7,4.4,4.1,7.4,3.4l0.6-0.1C46.3,96.7,44.4,95.5,43.4,93.5z" />
                                            <path
                                                d="M60.6,22.5l4.4-2.6c0.4-0.2,0.8-0.4,1.2-0.5c-1.4-0.2-2.9,0.1-4.1,0.8l-4.4,2.6c-0.4,0.2-0.8,0.4-1.2,0.5    C57.9,23.5,59.3,23.3,60.6,22.5z" />
                                            <path d="M81,92c-0.5,0-1,0.1-1.4,0.2l3.6-0.2c0.5,0,0.9-0.1,1.4-0.2L81,92z" />
                                            <path
                                                d="M65,98.9l-4.4-2.6c-1.5-0.9-3.2-1.1-4.9-0.7l-0.6,0.1c0.9,0.1,1.7,0.4,2.5,0.8l4.4,2.6c1.7,1,3.6,1.1,5.4,0.5    C66.6,99.6,65.8,99.4,65,98.9z" />
                                        </g>
                                        <polyline class="st0" points="44,53.6 56.5,67.9 82.1,47.3  " />
                                        <path class="st2"
                                            d="M53.5,75.3c-1.4,0-2.8-0.6-3.8-1.7L37.2,59.3c-1.8-2.1-1.6-5.2,0.4-7.1c2.1-1.8,5.2-1.6,7.1,0.4l9.4,10.7   l21.9-17.6c2.1-1.7,5.3-1.4,7,0.8c1.7,2.2,1.4,5.3-0.8,7L56.6,74.2C55.7,74.9,54.6,75.3,53.5,75.3z" />
                                    </g>
                                </svg>
                            </a></p>
                        <div class="mobile-hidden">
                            <p class="brand-name"><i class="fa fa-angle-right"></i> </p>
                            <p class="brand-name">{{ $project->project_title }}</p>
                        </div>
                    </div>


                </div>
                <div class="card-body">
                    <nav class="navbar" style="padding: 0 !important">
                        <div class="navbar-items">
                            <a class="navbar-item"
                                href="{{ route('instituional.dashboard', Str::slug($project->user->name)) }}">Anasayfa</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.profile', Str::slug($project->user->name)) }}">Mağaza
                                Profili</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.projects.detail', Str::slug($project->user->name)) }}">Proje
                                İlanları</a>
                            <a class="navbar-item"
                                href="{{ route('instituional.housings', Str::slug($project->user->name)) }}">Emlak
                                İlanları</a>
                        </div>
                        <form class="search-form" action="{{ route('instituional.search') }}" method="GET">
                            @csrf
                            <input class="search-input" type="search" placeholder="Mağazada Ara" id="search-project"
                                aria-label="Search" name="q">
                            <div class="header-search__suggestions">
                                <div class="header-search__suggestions__section">
                                    <h5>Projeler</h5>
                                    <div class="header-search__suggestions__section__items">
                                        @foreach ($project->user->projects as $item)
                                            <a href="{{ route('project.detail', ['slug' => $item->slug]) }}"
                                                class="project-item"
                                                data-title="{{ $item->project_title }}"><span>{{ $item->project_title }}</span></a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <button class="search-button" type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <section class="recently portfolio bg-white homepage-5 ">
        <div class="container">
            <div class="blog-section">
                <div class="news-item news-item-sm">
                    <div class="news-img-link">
                        <div class="news-item-img homes">
                            <div class="homes-tag button alt featured" style="width:150px !important">
                                <a href="{{ route('instituional.profile', Str::slug($project->user->name)) }}"
                                    style="color:White;">{{ $project->user->name }}</a>
                            </div>
                            <img class="resp-img"
                                src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                alt="blog image">
                        </div>
                    </div>
                    <div class="news-item-text">
                        <h3>{{ $project->project_title }}</h3>
                        <div class="the-agents">
                            <ul class="the-agents-details">
                                

                                <li><strong>İl-İlçe:</strong> {!! $project->city->title !!} {{ '/' }}
                                    {!! $project->county->ilce_title !!} </li>
                                <li><strong> Toplam {{ ucfirst($project->step1_slug) }}
                                        Sayısı:</strong> {{ $project->room_count }} </li>
                                <li><strong> Satışa Açık {{ ucfirst($project->step1_slug) }}
                                        Sayısı:</strong> {{ $project->room_count - $project->cartOrders }} </li>
                                <li><strong> Satılan {{ ucfirst($project->step1_slug) }}
                                        Sayısı:</strong> {{ $project->cartOrders }} </li>
                                <li><strong> {{ ucfirst($project->step1_slug) }} Tipi:</strong>
                                    {{ $project->housingtype->title }}
                                </li>
                                @if ($project->user->phone)
                                    <li><strong>İletişim No:</strong> {!! $project->user->phone !!} </li>
                                @endif
                                <li><strong>E-Posta:</strong> {!! $project->user->email !!} </li>

                            </ul>
                        </div>
                        <div class="news-item-bottom">

                            <div class="admin">
                                <p>{!! $project->user->name !!}</p>
                                <img src="{{ URL::to('/') . '/storage/profile_images/' . $project->user->profile_image }}"
                                    alt="">
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
                                                                            style="padding: 10px; color: white; height: 100%; display: flex; align-items: center; ">
                                                                            {{ $i + 1 }}</p>
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
                                                            @if ($sold || getData($project, 'off_sale[]', $i + 1)->value != '[]') style="background: #EEE !important;" @endif>

                                                            <div
                                                                class="row align-items-center justify-content-between mobile-position">
                                                                <div class="col-md-8">

                                                                    <div class="homes-list-div">
                                                                        <ul class="homes-list clearfix pb-3 d-flex">
                                                                            <li class="the-icons custom-width flex-1">
                                                                                <i class="fa fa-circle circleIcon mr-1"
                                                                                    style="color: black;"
                                                                                    aria-hidden="true"></i>
                                                                                <span>{{ $project->housingType->title }}</span>
                                                                            </li>
                                                                            @if (isset($project->listItemValues) &&
                                                                                    isset($project->listItemValues->column1_name) &&
                                                                                    $project->listItemValues->column1_name)
                                                                                <li
                                                                                    class="the-icons custom-width flex-1">
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
                                                                                    class="the-icons custom-width flex-1">
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
                                                                                    class="the-icons custom-width flex-1">
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
                                                                            order="{{ $i }}">
                                                                            Ödeme Detayları </button>
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
                                                                                    @if ($sold->status == '0') style="background: orange !important;color:White" @else  style="background: red !important;color:White" @endif>
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
                            <div class="mobile-show">
                                <div class="container">
                                    @for (; $i < 10; $i++)
                                        @php
                                            $room_order = $i + 1;
                                        @endphp
                                        <div class="d-flex" style="flex-wrap: nowrap">
                                            <div class="align-items-center d-flex"
                                                style="padding-right:0; width: 110px;">
                                                <div class="project-inner project-head">
                                                    <a
                                                        href="{{ route('project.housings.detail', [$project->slug, $room_order]) }}">
                                                        <div class="homes">
                                                            <!-- homes img -->
                                                            <div class="homes-img h-100 d-flex align-items-center"
                                                                style="width: 130px; height: 128px;">
                                                                <img src="{{ URL::to('/') . '/project_housing_images/' . getData($project, 'image[]', $i + 1)->value }}"
                                                                    alt="{{ $project->housingType->title }}"
                                                                    class="img-responsive"
                                                                    style="height: 100px !important;">
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="w-100" style="padding-left:0;">
                                                <div
                                                    class="bg-white px-3 h-100 d-flex flex-column justify-content-center">
                                                    <a style="text-decoration: none; height: 100%"
                                                        href="{{ route('project.housings.detail', [$project->slug, $room_order]) }}">
                                                        <h3>
                                                            @if (isset(getData($project, 'advertise_title[]', $i + 1)->value))
                                                                {{ getData($project, 'advertise_title[]', $i + 1)->value }}
                                                            @else
                                                                {{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}
                                                                Projesinde
                                                                {{ $i + 1 }} {{ "No'lu" }}
                                                                {{ $project->step1_slug }}
                                                            @endif
                                                        </h3>
                                                    </a>
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex" style="gap: 8px;">
                                                            <span
                                                                class="btn toggle-project-favorite bg-white"
                                                                data-project-housing-id="{{ $i + 1 }}"
                                                                style="color: white;"
                                                                data-project-id="{{ $project->id }}">
                                                                <i class="fa fa-heart-o-o"></i>
                                                            </span>
                                                            @if (getData($project, 'off_sale[]', $i + 1)->value != '[]')
                                                                <button class="btn   mobileBtn  second-btn CartBtn"
                                                                    disabled
                                                                    style="background: red !important;width:100%;color:White;">
                                                                    <span class="IconContainer">
                                                                        <img src="{{ asset('sc.png') }}"
                                                                            alt="">
                                                                    </span>
                                                                    <span class="text">Satışa Kapatıldı</span>
                                                                </button>
                                                            @else
                                                                @if ($sold && $sold->status != '2')
                                                                    <button class="btn mobileBtn second-btn CartBtn"
                                                                        disabled
                                                                        @if ($sold->status == '0') style="background: orange !important;width:100%;color:White"
                                        @else 
                                        style="background: red !important;width:100%;color:White;height: auto !important" @endif>
                                                                                        <span class="IconContainer">
                                                                            <img src="{{ asset('sc.png') }}"
                                                                                alt="">
                                                                        </span>
                                                                        @if ($sold->status == '0')
                                                                            <span class="text">Onay Bekleniyor</span>
                                                                        @else
                                                                            <span class="text">Satıldı</span>
                                                                        @endif
                                                                    </button>
                                                                @else
                                                                    <button class="CartBtn mobileBtn"
                                                                        data-type='project'
                                                                        data-project='{{ $project->id }}'
                                                                        data-id='{{ getData($project, 'price[]', $i + 1)->room_order }}'>
                                                                        <span class="IconContainer">
                                                                            <img src="{{ asset('sc.png') }}"
                                                                                alt="">
                                                                        </span>
                                                                        <span class="text">Sepete Ekle</span>
                                                                    </button>
                                                                @endif
                                                            @endif

                                                        </div>
                                                        <span class="ml-auto text-primary priceFont">
                                                            @if ($offer->discount_amount)
                                                                <svg viewBox="0 0 24 24" width="24"
                                                                    height="24" stroke="currentColor"
                                                                    stroke-width="2" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="css-i6dzq1">
                                                                    <polyline points="23 18 13.5 8.5 8.5 13.5 1 6">
                                                                    </polyline>
                                                                    <polyline points="17 18 23 18 23 12"></polyline>
                                                                </svg>
                                                            @endif
                                                            @if (getData($project, 'off_sale[]', $i + 1)->value == '[]')
                                                                @if ($sold)
                                                                    @if ($sold->status != '1' && $sold->status != '0')
                                                                        {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 2, ',', '.') }}
                                                                        ₺
                                                                    @endif
                                                                @else
                                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 2, ',', '.') }}
                                                                    ₺
                                                                @endif
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-100"
                                            style="height: 40px; background-color: #8080802e; margin-top: 20px">
                                            <ul class="d-flex justify-content-around align-items-center h-100"
                                                style="list-style: none; padding: 0; font-weight: 600">
                                                <li class="d-flex align-items-center itemCircleFont">
                                                    <i class="fa fa-circle circleIcon"></i>
                                                    {{ $room_order }} <span> No'lu</span>
                                                </li>
                                                @if (isset($project->listItemValues) && isset($project->listItemValues->column1_name) && $project->listItemValues->column1_name)
                                                    <li class="the-icons custom-width flex-1">
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
                                                @if (isset($project->listItemValues) && isset($project->listItemValues->column2_name) && $project->listItemValues->column2_name)
                                                    <li class="the-icons custom-width flex-1">
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
                                                @if (isset($project->listItemValues) && isset($project->listItemValues->column3_name) && $project->listItemValues->column3_name)
                                                    <li class="the-icons custom-width flex-1">
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
                                            </ul>
                                        </div>
                                        <hr>
                                    @endfor
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


<section class="properties-right list featured portfolio blog pb-5 bg-white">


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
                                                    style="padding: 10px; color: white; height: 100%; display: flex; align-items: center; ">
                                                    {{ $i + 1 }}</p>
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
                                    @if ($sold || getData($project, 'off_sale[]', $i + 1)->value != '[]') style="background: #EEE !important;" @endif>

                                    <div class="row align-items-center justify-content-between mobile-position">
                                        <div class="col-md-8">

                                            <div class="homes-list-div">
                                                <ul class="homes-list clearfix pb-3 d-flex">
                                                    <li class="the-icons custom-width flex-1">
                                                        <i class="fa fa-circle circleIcon mr-1" style="color: black;"
                                                            aria-hidden="true"></i>
                                                        <span>{{ $project->housingType->title }}</span>
                                                    </li>
                                                    @if (isset($project->listItemValues) &&
                                                            isset($project->listItemValues->column1_name) &&
                                                            $project->listItemValues->column1_name)
                                                        <li class="the-icons custom-width flex-1">
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
                                                        <li class="the-icons custom-width flex-1">
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
                                                        <li class="the-icons custom-width flex-1">
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
                                                    project-id="{{ $project->id }}" order="{{ $i }}">
                                                    Ödeme Detayları </button>
                                                @if (getData($project, 'off_sale[]', $i + 1)->value != '[]')
                                                    <button class="btn second-btn CartBtn" disabled
                                                        style="background: red !important;width:100%;color:White;height: auto !important">

                                                        <span class="text">Satışa Kapatıldı</span>
                                                    </button>
                                                @else
                                                    @if ($sold && $sold->status != '2')
                                                        <button class="btn second-btn soldBtn" disabled
                                                            @if ($sold->status == '0') style="background: orange !important;color:White"
                                            @else 
                                            style="background: red !important;color:White" @endif>
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
    <div class="mobile-show">
        <div class="container">
            @for ($i = 0; $i < $project->room_count; $i++)
                @php
                    $room_order = $i + 1;
                @endphp
                <div class="d-flex" style="flex-wrap: nowrap">
                    <div class="align-items-center d-flex" style="padding-right:0; width: 110px;">
                        <div class="project-inner project-head">
                            <a href="{{ route('project.housings.detail', [$project->slug, $room_order]) }}">
                                <div class="homes">
                                    <!-- homes img -->
                                    <div class="homes-img h-100 d-flex align-items-center"
                                        style="width: 130px; height: 128px;">
                                        <img src="{{ URL::to('/') . '/project_housing_images/' . getData($project, 'image[]', $i + 1)->value }}"
                                            alt="{{ $project->housingType->title }}" class="img-responsive"
                                            style="height: 100px !important;">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="w-100" style="padding-left:0;">
                        <div class="bg-white px-3 h-100 d-flex flex-column justify-content-center">
                            <a style="text-decoration: none; height: 100%"
                                href="{{ route('project.housings.detail', [$project->slug, $room_order]) }}">
                                <h3>
                                    @if (isset(getData($project, 'advertise_title[]', $i + 1)->value))
                                        {{ getData($project, 'advertise_title[]', $i + 1)->value }}
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
                                        data-project-housing-id="{{ $i + 1 }}"
                                        style="color: white;" data-project-id="{{ $project->id }}">
                                        <i class="fa fa-heart-o-o"></i>
                                    </span>
                                    @if (getData($project, 'off_sale[]', $i + 1)->value != '[]')
                                        <button class="btn   mobileBtn  second-btn CartBtn" disabled
                                            style="background: red !important;width:100%;color:White;">
                                            <span class="IconContainer">
                                                <img src="{{ asset('sc.png') }}" alt="">
                                            </span>
                                            <span class="text">Satışa Kapatıldı</span>
                                        </button>
                                    @else
                                        @if ($sold && $sold->status != '2')
                                            <button class="btn mobileBtn second-btn CartBtn" disabled
                                                @if ($sold->status == '0') style="background: orange !important;width:100%;color:White"
                                            @else 
                                            style="background: red !important;width:100%;color:White" @endif>
                                                <span class="IconContainer">
                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                </span>
                                                @if ($sold->status == '0')
                                                    <span class="text">Onay Bekleniyor</span>
                                                @else
                                                    <span class="text">Satıldı</span>
                                                @endif
                                            </button>
                                        @else
                                            <button class="CartBtn mobileBtn" data-type='project'
                                                data-project='{{ $project->id }}'
                                                data-id='{{ getData($project, 'price[]', $i + 1)->room_order }}'>
                                                <span class="IconContainer">
                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                </span>
                                                <span class="text">Sepete Ekle</span>
                                            </button>
                                        @endif
                                    @endif

                                </div>
                                {{-- <span class="ml-auto text-primary priceFont">
                                    @if ($offer->discount_amount)
                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                            stroke-width="2" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" class="css-i6dzq1">
                                            <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                            <polyline points="17 18 23 18 23 12"></polyline>
                                        </svg>
                                    @endif
                                    @if (getData($project, 'off_sale[]', $i + 1)->value == '[]')
                                        @if ($sold)
                                            @if ($sold->status != '1' && $sold->status != '0')
                                                {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 2, ',', '.') }}
                                                ₺
                                            @endif
                                        @else
                                            {{ number_format(getData($project, 'price[]', $i + 1)->value - $offer->discount_amount, 2, ',', '.') }}
                                            ₺
                                        @endif
                                    @endif
                                </span> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100" style="height: 40px; background-color: #8080802e; margin-top: 20px">
                    <ul class="d-flex justify-content-around align-items-center h-100"
                        style="list-style: none; padding: 0; font-weight: 600">
                        <li class="d-flex align-items-center itemCircleFont">
                            <i class="fa fa-circle circleIcon"></i>
                            {{ $room_order }} <span> No'lu</span>
                        </li>
                        @if (isset($project->listItemValues) && isset($project->listItemValues->column1_name) && $project->listItemValues->column1_name)
                            <li class="the-icons custom-width flex-1">
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
                        @if (isset($project->listItemValues) && isset($project->listItemValues->column2_name) && $project->listItemValues->column2_name)
                            <li class="the-icons custom-width flex-1">
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
                        @if (isset($project->listItemValues) && isset($project->listItemValues->column3_name) && $project->listItemValues->column3_name)
                            <li class="the-icons custom-width flex-1">
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
                    </ul>
                </div>
                <hr>
            @endfor
        </div>
    </div>



</section>
@endif

   



@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
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
                                        <img src="https://www..com/assets/images/durak:7299b7f721d8e670e9d070f1f816991a.png" alt="">
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
                                slidesToShow: 4,
                                slidesToScroll: 4,
                                dots: false,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 769,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
                                dots: false,
                                arrows: false
                            }
                        }
                    ]
                });
            })
            .catch(error => console.error('Hata:', error));
    </script>
    <script>
        $('.project-housing-pagination li').click(function(){
            $('.loading-full').removeClass('d-none')
            $.ajax({
                url: "{{ URL::to('/') }}/proje_ajax/{{$project->slug}}?selected_page="+$(this).index()+"&block_id="+$('.tabs .nav-item.active').index(), // Sepete veri eklemek için uygun URL'yi belirtin
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
                url: "{{ URL::to('/') }}/proje_ajax/{{$project->slug}}?selected_page=0"+"&block_id="+$(this).index(), // Sepete veri eklemek için uygun URL'yi belirtin
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
                $(".tab-content").hide();
                $(this).children(".tab-content").show();
            });
        });

        function changeTabContent(tabName) {
            document.querySelectorAll('.tab-content').forEach(function(content) {
                content.classList.remove('active');
            });
            document.getElementById('content-' + tabName).classList.add('active');
        }
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
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block !important;
        }

        .mobile-hidden {
            display: flex;
        }

        @media (max-width: 768px) {
            .mobile-hidden {
                display: none
            }
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

        .title {
            font-family: sans-serif;
            color: red;
            text-align: center;
        }
    </style>
@endsection
