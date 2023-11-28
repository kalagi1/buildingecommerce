@extends('institutional.layouts.master')

@php
    if (!function_exists('getData')) {
        function getData($project, $key, $roomOrder)
        {
            foreach ($project->roomInfo as $room) {
                if ($room->room_order == $roomOrder && $room->name == $key) {
                    return $room;
                }
            }
        }
    }
@endphp

@section('content')
    <div class="content">
        <div id="products">          
            <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white border-top border-bottom border-200 position-relative top-1">
                
                @if ($project->have_blocks == 1)
                    <ul class="nav nav-underline" id="myTab" role="tablist">
                        @foreach ($project->blocks as $block)
                        <li class="nav-item {{ $loop->first ? ' active' : '' }}" role="presentation">
                            <a class="nav-link {{ $loop->first ? ' active' : '' }}"  id="{{$block['id']}}-tab"
                            data-bs-toggle="tab" href="#tab-{{$block['id']}}" role="tab" aria-controls="tab-{{$block['id']}}" aria-selected="true">
                           {{ $block['block_name'] }}
                        </a>
                    </li>
                @endforeach
                    
                      
                      </ul>
                      <div class="table-responsive scrollbar mx-n1 px-1">
                        <table class="table fs--1 mb-0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Görsel</th>
                                    <th class="sort" data-sort="room_count">İlan Adı</th>
                                    <th class="sort" data-sort="room_count">Oda Sayısı</th>
                                    <th class="sort" data-sort="number_of_floors">Kat Sayısı</th>
                                    <th class="sort" data-sort="squaremeters">Metrekare (m<sup>2</sup>)</th>
                                    <th class="sort" data-sort="price">Fiyat</th>
                                    <th class="sort" data-sort="sold">Satış Durumu</th>
                                    <th class="sort" data-sort="sold">İşlemler</th>
                                </tr>
                            </thead>

                    @foreach ($project->blocks as $key => $block)
                            <div class="tab-pane fade {{ $loop->first ? ' active show' : '' }}" id="tab-{{ $block['id'] }}" role="tabpanel" aria-labelledby="{{ $block['id'] }}-tab">
                            @php
                            $j = -1; 
                                $blockHousingCount = $block['housing_count'];
                                if ($key > 0) {
                                    $previousBlockHousingCount = $project->blocks[$key - 1]['housing_count'];
                                    $i = $previousBlockHousingCount;
                                    $j = -1; 
                                    $blockHousingCount += $previousBlockHousingCount; 
                                } else {
                                $i = 0;  
                                                                }
                            @endphp
                        
                          
                                    <tbody class="list" id="products-table-body">
                                        @for (; $i < $blockHousingCount; $i++)
                                            @php
                                             $j++;
                                                $sold = DB::select('SELECT * FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "project"  AND JSON_EXTRACT(cart, "$.item.housing") = ? AND JSON_EXTRACT(cart, "$.item.id") = ? LIMIT 1', [getData($project, 'price[]', $i + 1)->room_order, $project->id]);
                                            @endphp

                                            <tr>
                                                <td>{{$j + 1}}</td>
                                                <td class="image">
                                                    <img src="{{ URL::to('/') . '/project_housing_images/' . getData($project, 'image[]', $i + 1)->value }}"
                                                        alt="home-1" class="img-responsive"
                                                        style="height: 100px !important;object-fit:cover">
                                                </td>
                                                <td class="image">
                                                    {{getData($project, 'advertise_title[]', $i + 1)->value }}
                                                </td>
                                                @if(isset($project->listItemValues) && isset($project->listItemValues->column1_name) && $project->listItemValues->column1_name)
                                                    <td class="room_count">
                                                        <i
                                                            class="fa fa-circle circleIcon mr-1"></i>
                                                        <span>
                                                            {{ getData($project, $project->listItemValues->column1_name.'[]', $i + 1)->value }}
                                                            @if(isset($project->listItemValues) && isset($project->listItemValues->column1_additional) && $project->listItemValues->column1_additional)
                                                                {{$project->listItemValues->column2_additional}}
                                                            @endif
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td class="room_count">
                                                        @if(isset($project->listItemValues) && isset($project->listItemValues->column2_name) && $project->listItemValues->column2_name)
                                                        <i class="fa fa-circle circleIcon mr-1"
                                                            aria-hidden="true"></i>
                                                        <span>{{ getData($project, $project->listItemValues->column2_name.'[]', $i + 1)->value }}
                                                            @if(isset($project->listItemValues) && isset($project->listItemValues->column2_additional) && $project->listItemValues->column2_additional)
                                                                {{$project->listItemValues->column2_additional}}
                                                            @endif
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td class="room_count">
                                                        @if(isset($project->listItemValues) && isset($project->listItemValues->column3_name) && $project->listItemValues->column3_name)
                                                        <i
                                                            class="fa fa-circle circleIcon mr-1"></i>
                                                        <span>
                                                            {{ getData($project, $project->listItemValues->column3_name.'[]', $i + 1)->value }}
                                                            @if(isset($project->listItemValues) && isset($project->listItemValues->column3_additional) && $project->listItemValues->column3_additional)
                                                                {{$project->listItemValues->column3_additional}}
                                                            @endif
                                                        </span>
                                                        @endif
                                                    </td>
                                            
                                                <td class="price">
                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value, 2, ',', '.') }}₺
                                                </td>
                                                <td class="sold">
                                                @if (getData($project, 'off_sale[]', $i + 1)->value != "[]")
                                                        <button class="btn btn-danger">Satışa Kapatıldı</button>
                                                        <p style="color: red;margin-top:10px;width:200px;">Alıcılara satışa kapalı olarak gözükecektir.</p>
                                                    @else
                                                        @if ($sold && $sold[0]->status == 1)
                                                            <button class="btn btn-danger">Satıldı</button>
                                                        @elseif ($sold && $sold[0]->status == 0)
                                                            <button class="btn btn-warning">Ödeme Bekleniyor</button>
                                                        @elseif ($sold && $sold[0]->status == 2)
                                                            <button class="btn btn-success">Tekrar Satışta</button>
                                                        @else
                                                            <button class="btn btn-success">Satışa Açık</button>
                                                        @endif
                                                    @endif
                                                </td>
                                            
                                                <td class="price">
                                                    <a href="{{route('institutional.projects.edit.housing',["project_id" => $project->id ,"room_order" => $i+1])}}" class="badge badge-phoenix badge-phoenix-primary">İlan Düzenle</a>
                                                    <a href="{{route('institutional.projects.delete.housing',["project_id" => $project->id ,"room_order" => $i+1])}}" class="badge badge-phoenix badge-phoenix-danger">Sil</a>
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                           
                    @endforeach
                </table>
            </div>
        </div>
            </div>
        </div>
    </div>
@else

<div class="table-responsive scrollbar mx-n1 px-1">
    <table class="table fs--1 mb-0">
        <thead>
            <tr>
                <th>No.</th>
                <th>Görsel</th>
                <th class="sort" data-sort="room_count">İlan Adı</th>
                <th class="sort" data-sort="room_count">Oda Sayısı</th>
                <th class="sort" data-sort="number_of_floors">Kat Sayısı</th>
                <th class="sort" data-sort="squaremeters">Metrekare (m<sup>2</sup>)</th>
                <th class="sort" data-sort="price">Fiyat</th>
                <th class="sort" data-sort="sold">Satış Durumu</th>
                <th class="sort" data-sort="sold">İşlemler</th>
            </tr>
        </thead>
        <tbody class="list" id="products-table-body">
            @for ($i = 0; $i < $project->room_count; $i++)
                @php
                    $sold = DB::select('SELECT * FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "project"  AND JSON_EXTRACT(cart, "$.item.housing") = ? AND JSON_EXTRACT(cart, "$.item.id") = ? LIMIT 1', [getData($project, 'price[]', $i + 1)->room_order, $project->id]);
                @endphp

                <tr>
                    <td>{{$i + 1}}</td>
                    <td class="image">
                        <img src="{{ URL::to('/') . '/project_housing_images/' . getData($project, 'image[]', $i + 1)->value }}"
                            alt="home-1" class="img-responsive"
                            style="height: 100px !important;object-fit:cover">
                    </td>
                    <td class="image">
                        {{getData($project, 'advertise_title[]', $i + 1)->value }}
                    </td>
                    @if(isset($project->listItemValues) && isset($project->listItemValues->column1_name) && $project->listItemValues->column1_name)
                        <td class="room_count">
                            <i
                                class="fa fa-circle circleIcon mr-1"></i>
                            <span>
                                {{ getData($project, $project->listItemValues->column1_name.'[]', $i + 1)->value }}
                                @if(isset($project->listItemValues) && isset($project->listItemValues->column1_additional) && $project->listItemValues->column1_additional)
                                    {{$project->listItemValues->column2_additional}}
                                @endif
                            </span>
                            @endif
                        </td>
                        <td class="room_count">
                            @if(isset($project->listItemValues) && isset($project->listItemValues->column2_name) && $project->listItemValues->column2_name)
                            <i class="fa fa-circle circleIcon mr-1"
                                aria-hidden="true"></i>
                            <span>{{ getData($project, $project->listItemValues->column2_name.'[]', $i + 1)->value }}
                                @if(isset($project->listItemValues) && isset($project->listItemValues->column2_additional) && $project->listItemValues->column2_additional)
                                    {{$project->listItemValues->column2_additional}}
                                @endif
                            </span>
                            @endif
                        </td>
                        <td class="room_count">
                            @if(isset($project->listItemValues) && isset($project->listItemValues->column3_name) && $project->listItemValues->column3_name)
                            <i
                                class="fa fa-circle circleIcon mr-1"></i>
                            <span>
                                {{ getData($project, $project->listItemValues->column3_name.'[]', $i + 1)->value }}
                                @if(isset($project->listItemValues) && isset($project->listItemValues->column3_additional) && $project->listItemValues->column3_additional)
                                    {{$project->listItemValues->column3_additional}}
                                @endif
                            </span>
                            @endif
                        </td>
                
                    <td class="price">
                        {{ number_format(getData($project, 'price[]', $i + 1)->value, 2, ',', '.') }}₺
                    </td>
                    <td class="sold">
                    @if (getData($project, 'off_sale[]', $i + 1)->value != "[]")
                            <button class="btn btn-danger">Satışa Kapatıldı</button>
                            <p style="color: red;margin-top:10px;width:200px;">Alıcılara satışa kapalı olarak gözükecektir.</p>
                        @else
                            @if ($sold && $sold[0]->status == 1)
                                <button class="btn btn-danger">Satıldı</button>
                            @elseif ($sold && $sold[0]->status == 0)
                                <button class="btn btn-warning">Ödeme Bekleniyor</button>
                            @elseif ($sold && $sold[0]->status == 2)
                                <button class="btn btn-success">Tekrar Satışta</button>
                            @else
                                <button class="btn btn-success">Satışa Açık</button>
                            @endif
                        @endif
                    </td>
                
                    <td class="price">
                        <a href="{{route('institutional.projects.edit.housing',["project_id" => $project->id ,"room_order" => $i+1])}}" class="badge badge-phoenix badge-phoenix-primary">İlan Düzenle</a>
                        <a href="{{route('institutional.projects.delete.housing',["project_id" => $project->id ,"room_order" => $i+1])}}" class="badge badge-phoenix badge-phoenix-danger">Sil</a>
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>
@endif
             
                <div class="row align-items-center justify-content-between py-2 pe-0 fs--1">
                    <div class="col-auto d-flex">
                        <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info">1 to 10
                            <span class="text-600"> Items of </span>16</p><a class="fw-semi-bold" href="#!"
                            data-list-view="*">View all<svg class="svg-inline--fa fa-angle-right ms-1"
                                data-fa-transform="down-1" aria-hidden="true" focusable="false" data-prefix="fas"
                                data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 256 512" data-fa-i2svg="" style="transform-origin: 0.25em 0.5625em;">
                                <g transform="translate(128 256)">
                                    <g transform="translate(0, 32)  scale(1, 1)  rotate(0 0 0)">
                                        <path fill="currentColor"
                                            d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"
                                            transform="translate(-128 -256)"></path>
                                    </g>
                                </g>
                            </svg><!-- <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span> Font Awesome fontawesome.com --></a><a
                            class="fw-semi-bold d-none" href="#!" data-list-view="less">View Less<svg
                                class="svg-inline--fa fa-angle-right ms-1" data-fa-transform="down-1" aria-hidden="true"
                                focusable="false" data-prefix="fas" data-icon="angle-right" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""
                                style="transform-origin: 0.25em 0.5625em;">
                                <g transform="translate(128 256)">
                                    <g transform="translate(0, 32)  scale(1, 1)  rotate(0 0 0)">
                                        <path fill="currentColor"
                                            d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"
                                            transform="translate(-128 -256)"></path>
                                    </g>
                                </g>
                            </svg><!-- <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span> Font Awesome fontawesome.com --></a>
                    </div>
                    <div class="col-auto d-flex"><button class="page-link disabled" data-list-pagination="prev"
                            disabled=""><svg class="svg-inline--fa fa-chevron-left" aria-hidden="true"
                                focusable="false" data-prefix="fas" data-icon="chevron-left" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                <path fill="currentColor"
                                    d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z">
                                </path>
                            </svg><!-- <span class="fas fa-chevron-left"></span> Font Awesome fontawesome.com --></button>
                        <ul class="mb-0 pagination">
                            <li class="active"><button class="page" type="button" data-i="1"
                                    data-page="10">1</button></li>
                            <li><button class="page" type="button" data-i="2" data-page="10">2</button></li>
                        </ul><button class="page-link pe-0" data-list-pagination="next"><svg
                                class="svg-inline--fa fa-chevron-right" aria-hidden="true" focusable="false"
                                data-prefix="fas" data-icon="chevron-right" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                <path fill="currentColor"
                                    d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z">
                                </path>
                            </svg><!-- <span class="fas fa-chevron-right"></span> Font Awesome fontawesome.com --></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
