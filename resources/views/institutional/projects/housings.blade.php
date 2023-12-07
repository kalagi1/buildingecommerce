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
                        <li class="nav-item{{ $loop->first ? ' active' : '' }}" role="presentation">
                            <a class="nav-link{{ $loop->first ? ' active' : '' }}" id="{{ $block['id'] }}-tab"
                                data-bs-toggle="tab" href="#tab-{{ $block['id'] }}" role="tab"
                                aria-controls="tab-{{ $block['id'] }}" aria-selected="true">
                                {{ $block['block_name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                    @foreach ($project->blocks as $key => $block)
                    <div class="tab-pane fade{{ $loop->first ? ' active show' : '' }}" id="tab-{{ $block['id'] }}"
                        role="tabpanel" aria-labelledby="{{ $block['id'] }}-tab">
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
                                        @for (; $i < $blockHousingCount; $i++)
                                            @php
                                                $j++;
                                                $sold = DB::select('SELECT * FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "project"  AND JSON_EXTRACT(cart, "$.item.housing") = ? AND JSON_EXTRACT(cart, "$.item.id") = ? LIMIT 1', [getData($project, 'price[]', $i + 1)->room_order, $project->id]);
                                            @endphp

                                            <tr>
                                                <td>{{ $j + 1 }}</td>
                                                <td class="image">
                                                    <img src="{{ URL::to('/') . '/project_housing_images/' . getData($project, 'image[]', $i + 1)->value }}"
                                                        alt="home-1" class="img-responsive"
                                                        style="height: 100px !important;object-fit:cover">
                                                </td>
                                                <td class="image">
                                                    {{ getData($project, 'advertise_title[]', $i + 1)->value }}
                                                </td>
                                                @if (isset($project->listItemValues) &&
                                                        isset($project->listItemValues->column1_name) &&
                                                        $project->listItemValues->column1_name)
                                                    <td class="room_count">
                                                        <i class="fa fa-circle circleIcon mr-1"></i>
                                                        <span>
                                                            {{ getData($project, $project->listItemValues->column1_name . '[]', $i + 1)->value }}
                                                            @if (isset($project->listItemValues) &&
                                                                    isset($project->listItemValues->column1_additional) &&
                                                                    $project->listItemValues->column1_additional)
                                                                {{ $project->listItemValues->column2_additional }}
                                                            @endif
                                                        </span>
                                                @endif
                                                </td>
                                                <td class="room_count">
                                                    @if (isset($project->listItemValues) &&
                                                            isset($project->listItemValues->column2_name) &&
                                                            $project->listItemValues->column2_name)
                                                        <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                        <span>{{ getData($project, $project->listItemValues->column2_name . '[]', $i + 1)->value }}
                                                            @if (isset($project->listItemValues) &&
                                                                    isset($project->listItemValues->column2_additional) &&
                                                                    $project->listItemValues->column2_additional)
                                                                {{ $project->listItemValues->column2_additional }}
                                                            @endif
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="room_count">
                                                    @if (isset($project->listItemValues) &&
                                                            isset($project->listItemValues->column3_name) &&
                                                            $project->listItemValues->column3_name)
                                                        <i class="fa fa-circle circleIcon mr-1"></i>
                                                        <span>
                                                            {{ getData($project, $project->listItemValues->column3_name . '[]', $i + 1)->value }}
                                                            @if (isset($project->listItemValues) &&
                                                                    isset($project->listItemValues->column3_additional) &&
                                                                    $project->listItemValues->column3_additional)
                                                                {{ $project->listItemValues->column3_additional }}
                                                            @endif
                                                        </span>
                                                    @endif
                                                </td>

                                                <td class="price">
                                                    {{ number_format(getData($project, 'price[]', $i + 1)->value, 2, ',', '.') }}₺
                                                </td>
                                                <td class="sold">
                                                    @if (getData($project, 'off_sale[]', $i + 1)->value != '[]')
                                                        <button class="btn btn-danger">Satışa Kapatıldı</button>
                                                        <p style="color: red;margin-top:10px;width:200px;">Alıcılara satışa
                                                            kapalı olarak gözükecektir.</p>
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
                                                    <a href="{{ route('institutional.projects.edit.housing', ['project_id' => $project->id, 'room_order' => $i + 1]) }}"
                                                        class="badge badge-phoenix badge-phoenix-primary">İlan Düzenle</a>
                                                    <a href="{{ route('institutional.projects.delete.housing', ['project_id' => $project->id, 'room_order' => $i + 1]) }}"
                                                        class="badge badge-phoenix badge-phoenix-danger">Sil</a>
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
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
                                        <td>{{ $i + 1 }}</td>
                                        <td class="image">
                                            <img src="{{ URL::to('/') . '/project_housing_images/' . getData($project, 'image[]', $i + 1)->value }}"
                                                alt="home-1" class="img-responsive"
                                                style="height: 100px !important;object-fit:cover">
                                        </td>
                                        <td class="image">
                                            {{ getData($project, 'advertise_title[]', $i + 1)->value }}
                                        </td>
                                        @if (isset($project->listItemValues) &&
                                                isset($project->listItemValues->column1_name) &&
                                                $project->listItemValues->column1_name)
                                            <td class="room_count">
                                                <i class="fa fa-circle circleIcon mr-1"></i>
                                                <span>
                                                    {{ getData($project, $project->listItemValues->column1_name . '[]', $i + 1)->value }}
                                                    @if (isset($project->listItemValues) &&
                                                            isset($project->listItemValues->column1_additional) &&
                                                            $project->listItemValues->column1_additional)
                                                        {{ $project->listItemValues->column2_additional }}
                                                    @endif
                                                </span>
                                        @endif
                                        </td>
                                        <td class="room_count">
                                            @if (isset($project->listItemValues) &&
                                                    isset($project->listItemValues->column2_name) &&
                                                    $project->listItemValues->column2_name)
                                                <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                                <span>{{ getData($project, $project->listItemValues->column2_name . '[]', $i + 1)->value }}
                                                    @if (isset($project->listItemValues) &&
                                                            isset($project->listItemValues->column2_additional) &&
                                                            $project->listItemValues->column2_additional)
                                                        {{ $project->listItemValues->column2_additional }}
                                                    @endif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="room_count">
                                            @if (isset($project->listItemValues) &&
                                                    isset($project->listItemValues->column3_name) &&
                                                    $project->listItemValues->column3_name)
                                                <i class="fa fa-circle circleIcon mr-1"></i>
                                                <span>
                                                    {{ getData($project, $project->listItemValues->column3_name . '[]', $i + 1)->value }}
                                                    @if (isset($project->listItemValues) &&
                                                            isset($project->listItemValues->column3_additional) &&
                                                            $project->listItemValues->column3_additional)
                                                        {{ $project->listItemValues->column3_additional }}
                                                    @endif
                                                </span>
                                            @endif
                                        </td>

                                        <td class="price">
                                            {{ number_format(getData($project, 'price[]', $i + 1)->value, 2, ',', '.') }}₺
                                        </td>
                                        <td class="sold">
                                            @if (getData($project, 'off_sale[]', $i + 1)->value != '[]')
                                                <button class="btn btn-danger">Satışa Kapatıldı</button>
                                                <p style="color: red;margin-top:10px;width:200px;">Alıcılara satışa kapalı
                                                    olarak
                                                    gözükecektir.</p>
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
                                            <a href="{{ route('institutional.projects.edit.housing', ['project_id' => $project->id, 'room_order' => $i + 1]) }}"
                                                class="badge badge-phoenix badge-phoenix-primary">İlan Düzenle</a>
                                            <a href="{{ route('institutional.projects.delete.housing', ['project_id' => $project->id, 'room_order' => $i + 1]) }}"
                                                class="badge badge-phoenix badge-phoenix-danger">Sil</a>
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .fade:not(.show){
            display:  none !important;
        }
    </style>
@endsection

@section('styles')
<style>
    .fade:not(.show){
        display:  none !important;
    }
</style>
    
@endsection
