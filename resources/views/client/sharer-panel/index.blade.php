@extends('client.layouts.master')

@section('content')
    <div class="container">
        <div class="list portfolio">
            <div class="brand-head">
                <div class="">
                    <div class="card mb-3">
                        <div class="card-img-top" style="background-color: {{ $sharer->banner_hex_code }}">
                            <div class="brands-square w-100">
                                <img src="{{ url('storage/profile_images/' . $sharer->profile_image) }}" alt="" class="brand-logo">
                                <p class="brand-name"><a href="{{ route('institutional.profile', ["slug" => Str::slug($sharer->name), "userID" => $sharer->id]) }}"
                                        style="color:White">
                                        {{ $sharer->name }}

                                        ({{count($items)}} Aktif ilan)
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
                                    </a>
                                </p>
                            </div>
        
                        </div>
                    </div>
                </div>
            </div>
            <h3 style="font-size: 23px;" class="mt-5">Linklerim</h3>
            <div class="row project-filter-reverse blog-pots mt-3">
                @for ($i = 0; $i < count($items); $i++)
                    @if($items[$i]->item_type == 1)
                        @php 
                            $project = $items[$i]->project;
                        @endphp

                        <div class="col-md-12 col-12">
                            <div class="project-card mb-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <a href="{{ route('project.housings.detail', [$project->id, $items[$i]->room_order]) }}" style="height: 100%">
                                            <div class="d-flex" style="height: 100%;">
                                                <div class="project-single mb-0 bb-0 aos-init aos-animate" data-aos="fade-up">
                                                    <div class="project-inner project-head">
                    
                                                        <div class="button-effect">
                                                            <div href="javascript:void()" class="btn toggle-project-favorite bg-white"
                                                                data-project-housing-id="2" data-project-id="292">
                                                                <i class="fa fa-heart-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="homes position-relative">
                                                            <!-- homes img -->
                                                            <img src="{{ URL::to('/') . '/project_housing_images/' . $items[$i]['project_values']['image[]']}}"
                                                                alt="home-1" class="img-responsive"
                                                                style="height: 120px !important;object-fit:cover">
                                                        </div>
                    
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                    
                    
                                    <div class="col-lg-9 col-md-9 homes-content pb-0 mb-44 aos-init aos-animate" data-aos="fade-up">
                    
                                        <div class="row align-items-center justify-content-between mobile-position">
                                            <div class="col-md-8">
                                                
                                                <div class="top-name">
                                                    {{$items[$i]['project_values']['advertise_title[]']}}
                                                </div>
                                                <div class="homes-list-div" style="height: 75px">
                                                    <ul class="homes-list clearfix pb-3 d-flex">
                                                        @if (isset($project->listItemValues) && isset($project->listItemValues->column1_name) && $project->listItemValues->column1_name)
                                                            <li class="the-icons custom-width flex-1">
                                                                <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                                <span>
                                                                    {{ $items[$i]['project_values'][$project->listItemValues->column1_name . '[]'] }}
                                                                    @if (isset($project->listItemValues) && isset($project->listItemValues->column1_additional) && $project->listItemValues->column1_additional)
                                                                        {{ $project->listItemValues->column1_additional }}
                                                                    @endif
                                                                </span>
                                                            </li>
                                                        @endif
                                                        @if (isset($project->listItemValues) && isset($project->listItemValues->column2_name) && $project->listItemValues->column2_name)
                                                            <li class="the-icons custom-width flex-1">
                                                                <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                                <span>
                                                                    {{ $items[$i]['project_values'][$project->listItemValues->column2_name . '[]'] }}
                                                                    @if (isset($project->listItemValues) && isset($project->listItemValues->column2_additional) && $project->listItemValues->column2_additional)
                                                                        {{ $project->listItemValues->column2_additional }}
                                                                    @endif
                                                                </span>
                                                            </li>
                                                        @endif
                                                        @if (isset($project->listItemValues) && isset($project->listItemValues->column3_name) && $project->listItemValues->column3_name)
                                                            <li class="the-icons custom-width flex-1">
                                                                <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                                <span>
                                                                    {{ $items[$i]['project_values'][$project->listItemValues->column3_name . '[]'] }}
                                                                    @if (isset($project->listItemValues) && isset($project->listItemValues->column3_additional) && $project->listItemValues->column3_additional)
                                                                        {{ $project->listItemValues->column3_additional }}
                                                                    @endif
                                                                </span>
                                                            </li>
                                                        @endif
                    
                                                        <li class="the-icons mobile-hidden">
                                                            <span>
                                                                <h6
                                                                    style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                    {{number_format($items[$i]['project_values']['price[]'], 0, ',', '.')}}
                                                                    ₺
                                                                </h6>
                    
                    
                                                            </span>
                                                        </li>
                    
                    
                                                    </ul>
                    
                                                </div>
                                                <div class="footer">
                                                    <a href="https://emlaksepette.com/magaza/master-realtor/profil">
                                                        <img src="https://emlaksepette.com/storage/profile_images/profile_image_1701685905.png"
                                                            alt="" class="mr-2"> Master Realtor
                                                    </a>
                                                    <span class="price-mobile">
                                                        <h6 style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                            {{number_format($items[$i]['project_values']['price[]'], 0, ',', '.')}} ₺
                                                        </h6>
                    
                    
                                                    </span>
                                                </div>
                                            </div>
                    
                                            <div class="col-md-3 mobile-hidden" style="height: 120px;padding:0">
                                                <div class="homes-button" style="width:100%;height:100%">
                                                    @if(auth()->check())
                                                        @if(auth()->user()->id == $sharer->id)
                                                            <button class="first-btn payment-plan-button" project-id="{{$project->id}}" data-sold="0" order="{{$items[$i]['room_order']}}">
                                                                Kar Oranı : 1%
                                                            </button>
                                                        @else 
                                                            <button class="first-btn payment-plan-button" project-id="{{$project->id}}" data-sold="0" order="{{$items[$i]['room_order']}}">
                                                                Ödeme Planı
                                                            </button>
                                                        @endif
                                                    @else 
                                                        <button class="first-btn payment-plan-button" project-id="{{$project->id}}" data-sold="0" order="{{$items[$i]['room_order']}}">
                                                            Ödeme Planı
                                                        </button>
                                                    @endif
                                                    
                                                    @if(auth()->check())
                                                        @if(auth()->user()->id == $sharer->id)
                                                            <button class="CartBtn second-btn" data-type="project" data-project="{{$project->id}}"
                                                                style="height: auto !important" data-id="{{$items[$i]['room_order']}}">
                                                                <span class="IconContainer">
                                                                    <img src="https://emlaksepette.com/link.png" alt="">
                                                                </span>
                                                                <span class="text">Linklerden çıkar</span>
                                                            </button>
                                                        @else 
                                                            <button class="CartBtn second-btn" data-type="project" data-project="{{$project->id}}"
                                                                style="height: auto !important" data-id="{{$items[$i]['room_order']}}">
                                                                <span class="IconContainer">
                                                                    <img src="https://emlaksepette.com/link.png" alt="">
                                                                </span>
                                                                <span class="text">Sepete Ekle</span>
                                                            </button>
                                                        @endif
                                                    @else 
                                                        <button class="CartBtn second-btn" data-type="project" data-project="{{$project->id}}"
                                                            style="height: auto !important" data-id="{{$items[$i]['room_order']}}">
                                                            <span class="IconContainer">
                                                                <img src="https://emlaksepette.com/link.png" alt="">
                                                            </span>
                                                            <span class="text">Sepete Ekle</span>
                                                        </button>
                                                    @endif
                    
                                                </div>
                                            </div>
                    
                    
                                        </div>
                    
                    
                                    </div>
                                </div>
                    
                            </div>
                        </div>
                    @else
                        @php 
                            $housing = $items[$i]->housing;
                            $housingTypeData = json_decode($housing->housing_type_data);
                        @endphp

                        <div class="col-md-12 col-12">
                            <div class="project-card mb-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <a href="{{ route('housing.show', ['housingSlug' =>  $housing->slug, 'housingID' => $housing->id + 2000000]) }}" style="height: 100%">
                                            <div class="d-flex" style="height: 100%;">
                                                
                                                <div class="project-single mb-0 bb-0 aos-init aos-animate" data-aos="fade-up">
                                                    <div class="project-inner project-head">
                    
                                                        <div class="button-effect">
                                                            <div href="javascript:void()" class="btn toggle-project-favorite bg-white"
                                                                data-project-housing-id="2" data-project-id="292">
                                                                <i class="fa fa-heart-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="homes position-relative">
                                                            <!-- homes img -->
                                                            <img src="{{ URL::to('/') . '/housing_images/' . json_decode($housing->housing_type_data)->image }}"
                                                                alt="home-1" class="img-responsive"
                                                                style="height: 120px !important;object-fit:cover">
                                                        </div>
                    
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                    
                    
                                    <div class="col-lg-9 col-md-9 homes-content pb-0 mb-44 aos-init aos-animate" data-aos="fade-up">
                    
                                        <div class="row align-items-center justify-content-between mobile-position">
                                            <div class="col-md-8">
                                                
                                                <div class="top-name">
                                                    {{$housing->title}}
                                                </div>
                                                <div class="homes-list-div" style="height: 75px">
                                                    <ul class="homes-list clearfix pb-3 d-flex">
                                                        @if ($housing->listItems->column1_name)
                                                            <li class="the-icons custom-width flex-1">
                                                                <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                                <span>
                                                                    {{ json_decode($housing->housing_type_data)->{$housing->listItems->column1_name}[0] ?? null }}
                                                                    @if ($housing->listItems->column1_additional)
                                                                        {{ $housing->listItems->column1_additional }}
                                                                    @endif
                                                                </span>
                                                            </li>
                                                        @endif
                                                        
                                                        @if ($housing->listItems->column2_name)
                                                            <li class="the-icons custom-width flex-1">
                                                                <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                                <span>
                                                                    {{ json_decode($housing->housing_type_data)->{$housing->listItems->column2_name}[0] ?? null }}
                                                                    @if ($housing->listItems->column2_additional)
                                                                        {{ $housing->listItems->column2_additional }}
                                                                    @endif
                                                                </span>
                                                            </li>
                                                        @endif

                                                        @if ($housing->listItems->column3_name)
                                                            <li class="the-icons custom-width flex-1">
                                                                <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                                <span>
                                                                    {{ json_decode($housing->housing_type_data)->{$housing->listItems->column3_name}[0] ?? null }}
                                                                    @if ($housing->listItems->column3_additional)
                                                                        {{ $housing->listItems->column3_additional }}
                                                                    @endif
                                                                </span>
                                                            </li>
                                                        @endif

                                                        <li class="the-icons mobile-hidden">
                                                            <span>
                                                                <h6
                                                                    style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                                    {{number_format($housingTypeData->price[0], 0, ',', '.')}}
                                                                    ₺
                                                                </h6>
                    
                    
                                                            </span>
                                                        </li>
                    
                    
                                                    </ul>
                    
                                                </div>
                                                <div class="footer">
                                                    <a href="https://emlaksepette.com/magaza/master-realtor/profil">
                                                        <img src="https://emlaksepette.com/storage/profile_images/profile_image_1701685905.png"
                                                            alt="" class="mr-2"> Master Realtor
                                                    </a>
                                                    <span class="price-mobile">
                                                        <h6 style="color: #dc3545 !important;position: relative;top:4px;font-weight:600">
                                                            {{number_format($housingTypeData->price[0], 0, ',', '.')}} ₺
                                                        </h6>
                    
                    
                                                    </span>
                                                </div>
                                            </div>
                    
                                            <div class="col-md-3 mobile-hidden" style="height: 120px;padding:0">
                                                <div class="homes-button" style="width:100%;height:100%">
                                                    @if(auth()->check())
                                                        @if(auth()->user()->id == $sharer->id)
                                                            <button class="first-btn payment-plan-button" project-id="292" data-sold="0" order="1">
                                                                Kar Oranı : 1%
                                                            </button>
                                                        @else 
                                                        @endif
                                                    @else 
                                                        <button class="first-btn payment-plan-button" project-id="292" data-sold="0" order="1">
                                                            Ödeme Planı
                                                        </button>
                                                    @endif
                    
                                                    @if(auth()->check())
                                                        @if(auth()->user()->id == $sharer->id)
                                                            <button class="CartBtn second-btn" data-type="housing"
                                                                style="height: auto !important" data-id="{{$housing->id}}">
                                                                <span class="IconContainer">
                                                                    <img src="https://emlaksepette.com/link.png" alt="">
                                                                </span>
                                                                <span class="text">Linklerden çıkar</span>
                                                            </button>
                                                        @else 
                                                            <button class="CartBtn second-btn" data-type="housing"
                                                                style="height: auto !important" data-id="{{$housing->id}}">
                                                                <span class="IconContainer">
                                                                    <img src="https://emlaksepette.com/link.png" alt="">
                                                                </span>
                                                                <span class="text">Sepete Ekle</span>
                                                            </button>
                                                        @endif
                                                    @else 
                                                        <button class="CartBtn second-btn" data-type="housing"
                                                            style="height: auto !important" data-id="{{$housing->id}}">
                                                            <span class="IconContainer">
                                                                <img src="https://emlaksepette.com/link.png" alt="">
                                                            </span>
                                                            <span class="text">Sepete Ekle</span>
                                                        </button>
                                                    @endif
                    
                                                </div>
                                            </div>
                    
                    
                                        </div>
                    
                    
                                    </div>
                                </div>
                    
                            </div>
                        </div>
                    @endif
                
                @endfor
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
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
    </style>
@endsection
