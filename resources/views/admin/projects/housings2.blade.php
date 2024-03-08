@extends('admin.layouts.master')

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

@if ($errors->any())
    <div class="alert alert-danger" style="margin-top:150px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-center">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@section('content')
    <div class="content">
        <div id="products">

            <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white border-top border-bottom border-200 position-relative top-1">
                <div class="table-collective-transactions">
                    <div class="updates-buttons d-none my-2">
                        <span class="price-update cursor-pointer badge badge-phoenix badge-phoenix-primary btn-sm">
                            Fiyatları Güncelle
                        </span>
                        <span
                            class="installments-price-update cursor-pointer badge badge-phoenix badge-phoenix-primary btn-sm">
                            Taksitli Fiyatları Güncelle
                        </span>
                        <span class="pay-dec-update cursor-pointer badge badge-phoenix badge-phoenix-primary btn-sm">
                            Ara Ödemeleri Güncelle
                        </span>
                        <span class="installments-update cursor-pointer badge badge-phoenix badge-phoenix-primary btn-sm">
                            Taksit Sayılarını Güncelle
                        </span>
                        <span class="advance-update cursor-pointer badge badge-phoenix badge-phoenix-primary btn-sm">
                            Peşinatları Güncelle
                        </span>
                    </div>
                </div>
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
                    @php 
                        $lastCountx = 0;
                    @endphp
                    @foreach ($project->blocks as $key => $block)
                        <div class="tab-pane fade{{ $loop->first ? ' active show' : '' }}" id="tab-{{ $block['id'] }}"
                            role="tabpanel" aria-labelledby="{{ $block['id'] }}-tab">
                            @php
                                $j = -1;
                                $blockHousingCount = $block['housing_count'];
                                
                                if ($key > 0) {
                                    $previousBlockHousingCount = $project->blocks[$key - 1]['housing_count'];
                                    $i = $lastCountx;
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
                                            {{-- <th class="sort" data-sort="sold">Komşumu Gör</th> --}}

                                            <th><input type="checkbox" class="all-select"></th>
                                            <th>No.</th>
                                            <th>Görsel</th>
                                            <th class="sort" data-sort="room_count">İlan Adı</th>
                                            <th class="sort" data-sort="price">Fiyat</th>
                                            <th class="sort" data-sort="price">Taksitli Fiyat</th>
                                            <th class="sort" data-sort="price">Taksit Sayısı</th>
                                            <th class="sort" data-sort="price">Peşinat</th>
                                            <th class="sort" data-sort="sold">Satış Durumu</th>
                                            <th class="sort" data-sort="sold">İşlemler</th>
                                        </tr>
                                    </thead>

                                    <tbody class="list" id="products-table-body">
                                        @for (; $i < $lastCountx + $block['housing_count']; $i++)
                                            @php
                                                $j++;
                                                $sold = DB::select('SELECT * FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "project"  AND JSON_EXTRACT(cart, "$.item.housing") = ? AND JSON_EXTRACT(cart, "$.item.id") = ? LIMIT 1', [getData($project, 'price[]', $i + 1)->room_order, $project->id]);
                                                $share_sale = $projectHousingsList[$i + 1]['share_sale[]'] ?? null;
                                                $number_of_share = $projectHousingsList[$i + 1]['number_of_shares[]'] ?? null;
                                            @endphp

                                            <tr>
                                                <td>Komşumu GÖr</td>
                                                <td><input type="checkbox" class="item-checkbox" item-id="{{  $i + 1 }}"
                                                    name="" id=""></td>
                                                <td>{{ $j + 1 }}</td>
                                                <td class="image">
                                                    <div class="image-with-hover">
                                                        <img src="{{ URL::to('/') . '/project_housing_images/' . getData($project, 'image[]', $i + 1)->value }}"
                                                            alt="home-1" class="img-responsive"
                                                            style="max-height: 100px !important;max-width:100px;object-fit:cover">
                                                    </div>
                                                </td>
                                                <td class="image">
                                                    <div class="d-flex" style="align-items: center">
                                                        <div class="input d-none d-flex" style="align-items: flex-start;">
                                                            <textarea class="form-control" style="height: 60px;width:350px;font-size:12px !importantß" type="text"
                                                                name="advertise_title[]">{{ getData($project, 'advertise_title[]', $i + 1)->value }}</textarea>
                                                            <span
                                                                class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex"
                                                                input-type="textarea" room-order="{{ $i + 1 }}"><i
                                                                    class="fa fa-check"></i></span>
                                                            <span
                                                                class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i
                                                                    class="fa fa-times"></i></span>
                                                        </div>
                                                        <div class="text d-flex" style="align-items: flex-start;">
                                                            <span
                                                                class="value-text">{{ getData($project, 'advertise_title[]', $i + 1)->value }}</span>
                                                            <span
                                                                class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i
                                                                    class="fa fa-edit"></i></span>
                                                        </div>

                                                    </div>
                                                </td>

                                                <td class="price">
                                                    <div class="d-flex">
                                                        <div class="input d-none d-flex" style="align-items: center">
                                                            <input type="text" name="price[]" class="price-only"
                                                                style="width: 120px;"
                                                                value="{{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}">
                                                            <span
                                                                class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex"
                                                                room-order="{{ $i + 1 }}"><i
                                                                    class="fa fa-check"></i></span>
                                                            <span
                                                                class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i
                                                                    class="fa fa-times"></i></span>
                                                        </div>
                                                        <div class="text d-flex" style="align-items: flex-start;">
                                                            <span
                                                                class="value-text">{{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}₺</span>
                                                            <span
                                                                class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i
                                                                    class="fa fa-edit"></i></span>
                                                        </div>

                                                    </div>
                                                </td>

                                                <td class="price">
                                                    @if (getData($project, 'installments-price[]', $i + 1))
                                                        <div class="d-flex">
                                                            <div class="input d-none d-flex" style="align-items: center">
                                                                <input type="text" name="installments-price[]"
                                                                    class="price-only" style="width: 120px;"
                                                                    value="{{ number_format(getData($project, 'installments-price[]', $i + 1)->value, 0, ',', '.') }}">
                                                                <span
                                                                    class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex"
                                                                    room-order="{{ $i + 1 }}"><i
                                                                        class="fa fa-check"></i></span>
                                                                <span
                                                                    class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i
                                                                        class="fa fa-times"></i></span>
                                                            </div>
                                                            <div class="text d-flex" style="align-items: flex-start;">
                                                                <span
                                                                    class="value-text">{{ number_format(getData($project, 'installments-price[]', $i + 1)->value, 0, ',', '.') }}₺</span>
                                                                <span
                                                                    class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i
                                                                        class="fa fa-edit"></i></span>
                                                            </div>

                                                        </div>
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td class="price">
                                                    @if (getData($project, 'installments[]', $i + 1))
                                                        <div class="d-flex">
                                                            <div class="input d-none d-flex" style="align-items: center">
                                                                <input type="number" min="1" max="150"
                                                                    name="installments[]" class="number-only"
                                                                    style="width: 120px;"
                                                                    value="{{ getData($project, 'installments[]', $i + 1)->value }}">
                                                                <span
                                                                    class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex"
                                                                    room-order="{{ $i + 1 }}"><i
                                                                        class="fa fa-check"></i></span>
                                                                <span
                                                                    class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i
                                                                        class="fa fa-times"></i></span>
                                                            </div>
                                                            <div class="text d-flex" style="align-items: flex-start;">
                                                                <span
                                                                    class="value-text">{{ getData($project, 'installments[]', $i + 1)->value }}</span>
                                                                <span
                                                                    class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i
                                                                        class="fa fa-edit"></i></span>
                                                            </div>

                                                        </div>
                                                    @else
                                                        -
                                                    @endif
                                                </td>


                                                <td class="price">
                                                    @if (getData($project, 'advance[]', $i + 1))
                                                        <div class="d-flex">
                                                            <div class="input d-none d-flex" style="align-items: center">
                                                                <input type="text" name="advance[]" class="price-only"
                                                                    style="width: 120px;"
                                                                    value="{{ number_format(getData($project, 'advance[]', $i + 1)->value, 0, ',', '.') }}">
                                                                <span
                                                                    class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex"
                                                                    room-order="{{ $i + 1 }}"><i
                                                                        class="fa fa-check"></i></span>
                                                                <span
                                                                    class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i
                                                                        class="fa fa-times"></i></span>
                                                            </div>
                                                            <div class="text d-flex" style="align-items: flex-start;">
                                                                <span
                                                                    class="value-text">{{ number_format(getData($project, 'advance[]', $i + 1)->value, 0, ',', '.') }}₺</span>
                                                                <span
                                                                    class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i
                                                                        class="fa fa-edit"></i></span>
                                                            </div>

                                                        </div>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="sold">
                                                    @if (isset($share_sale) && !empty($share_sale))
                                                        <span class=" d-block mb-2">
                                                            @if (isset($sumCartOrderQt[$i + 1]) && isset($sumCartOrderQt[$i + 1]['qt_total']))
                                                                {{ $sumCartOrderQt[$i + 1]['qt_total'] }}
                                                            @else
                                                                0
                                                            @endif / {{ $number_of_share }}
                                                        </span>
                                                    @endif 
                                                    @if (isset(getData($project, 'off_sale[]', $i + 1)->value) && getData($project, 'off_sale[]', $i + 1)->value != '[]' && !$sold)
                                                        <div class="input d-none d-flex" style="align-items: center">
                                                            <select name="off_sale[]" id="">
                                                                <option value="[]">Satışa Açık</option>
                                                                <option value='["Satışa Kapalı"]' selected>Satışa Kapalı
                                                                </option>
                                                            </select>
                                                            <span
                                                                class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex"
                                                                input-type="select" room-order="{{ $i + 1 }}"><i
                                                                    class="fa fa-check"></i></span>
                                                            <span
                                                                class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i
                                                                    class="fa fa-times"></i></span>
                                                        </div>
                                                        <div class="text d-flex">

                                                            <button
                                                                class="badge badge-phoenix badge-phoenix-danger value-text">Satışa
                                                                Kapatıldı</button>
                                                            <span
                                                                class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i
                                                                    class="fa fa-edit"></i></span>
                                                        </div>
                                                        
                                                    @else
                                                        @if (
                                                            ($sold && $sold[0]->status == 1 && $share_sale == '[]') ||
                                                                (isset($sumCartOrderQt[$i + 1]) && $sumCartOrderQt[$i + 1]['qt_total'] == $number_of_share))
                                                            <button
                                                                class="badge badge-phoenix badge-phoenix-danger">Satıldı</button>
                                                        @elseif ($sold && $sold[0]->status == 0)
                                                            <button class="badge badge-phoenix badge-phoenix-warning">Ödeme
                                                                Bekleniyor</button>
                                                        @elseif ($sold && $sold[0]->status == 2)
                                                            <button
                                                                class="badge badge-phoenix badge-phoenix-success">Tekrar
                                                                Satışta</button>
                                                        @else
                                                            <div class="input d-none d-flex" style="align-items: center">
                                                                <select name="off_sale[]" id="">
                                                                    <option value="[]" selected>Satışa Açık</option>
                                                                    <option value='["Satışa Kapalı"]'>Satışa Kapalı
                                                                    </option>
                                                                </select>
                                                                <span
                                                                    class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex"
                                                                    input-type="select"
                                                                    room-order="{{ $i + 1 }}"><i
                                                                        class="fa fa-check"></i></span>
                                                                <span
                                                                    class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i
                                                                        class="fa fa-times"></i></span>
                                                            </div>
                                                            <div class="text d-flex">
                                                                <button
                                                                    class="badge badge-phoenix badge-phoenix-success value-text">Satışa
                                                                    Açık</button>
                                                                <span
                                                                    class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i
                                                                        class="fa fa-edit"></i></span>
                                                            </div>
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
                        @php 
                            $lastCountx += isset($previousBlockHousingCount) ? $previousBlockHousingCount :  $block['housing_count'];
                        @endphp
                    @endforeach
                @else
                    <div class="table-responsive scrollbar mx-n1 px-1">
                        <table class="table fs--1 mb-0">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" class="all-select"></th>
                                    <th>No.</th>
                                    <th>Görsel</th>
                                    <th class="sort" data-sort="room_count">İlan Adı</th>
                                    <th class="sort" data-sort="price">Fiyat</th>
                                    <th class="sort" data-sort="price">Taksitli Fiyat</th>
                                    <th class="sort" data-sort="price">Ara Ödemeler</th>
                                    <th class="sort" data-sort="price">Taksit Sayısı</th>
                                    <th class="sort" data-sort="price">Peşinat</th>
                                    <th class="sort" data-sort="sold">Satış Durumu</th>
                                    <th class="sort" data-sort="sold">İşlemler</th>

                                </tr>
                            </thead>
                            <tbody class="list" id="products-table-body">
                                @for ($i = 0; $i < $project->room_count; $i++)
                                    @php
                                        $sold = DB::select('SELECT * FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "project"  AND JSON_EXTRACT(cart, "$.item.housing") = ? AND JSON_EXTRACT(cart, "$.item.id") = ? LIMIT 1', [getData($project, 'price[]', $i + 1)->room_order, $project->id]);
                                        $share_sale = $projectHousingsList[$i + 1]['share_sale[]'] ?? null;
                                        $number_of_share = $projectHousingsList[$i + 1]['number_of_shares[]'] ?? null;
                                    @endphp

                                    <tr>
                                        <td><input type="checkbox" class="item-checkbox" item-id="{{ $i + 1 }}"
                                                name="" id=""></td>
                                        <td>{{ $i + 1 }}</td>
                                        <td class="image">
                                            <div class="image-with-hover">
                                                <input type="file" class="d-none change-image">
                                                <div class="image-opa">
                                                    Resmi Güncelle
                                                </div>
                                                <img src="{{ URL::to('/') . '/project_housing_images/' . getData($project, 'image[]', $i + 1)->value }}"
                                                    alt="home-1" class="img-responsive"
                                                    style="max-height: 100px !important;max-width:100px;object-fit:cover">
                                            </div>
                                        </td>
                                        <td class="image">
                                            <div class="d-flex" style="align-items: center">
                                                <div class="input d-none d-flex" style="align-items: flex-start;">
                                                    <textarea class="form-control" style="height: 60px;width:350px;font-size:11px !important;" type="text"
                                                        name="advertise_title[]">{{ getData($project, 'advertise_title[]', $i + 1)->value }}</textarea>
                                                    <span
                                                        class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex"
                                                        input-type="textarea" room-order="{{ $i + 1 }}"><i
                                                            class="fa fa-check"></i></span>
                                                    <span
                                                        class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i
                                                            class="fa fa-times"></i></span>
                                                </div>
                                                <div class="text d-flex" style="align-items: flex-start;">
                                                    <span
                                                        class="value-text">{{ getData($project, 'advertise_title[]', $i + 1)->value }}</span>
                                                    @if ($sold && $sold[0]->status == 1)
                                                    @else
                                                        <span
                                                            class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i
                                                                class="fa fa-edit"></i></span>
                                                    @endif <br>
                                                </div>

                                            </div>
                                        </td>

                                        <td class="price">
                                            <div class="d-flex">
                                                <div class="input d-none d-flex" style="align-items: center">
                                                    <input type="text" name="price[]" class="price-only"
                                                        style="width: 120px;"
                                                        value="{{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}">
                                                    <span
                                                        class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex"
                                                        room-order="{{ $i + 1 }}"><i
                                                            class="fa fa-check"></i></span>
                                                    <span
                                                        class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i
                                                            class="fa fa-times"></i></span>
                                                </div>
                                                <div class="text d-flex" style="align-items: flex-start;">
                                                    <span
                                                        class="value-text">{{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}₺</span>
                                                    @if ($sold && $sold[0]->status == 1)
                                                    @else
                                                        <span
                                                            class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i
                                                                class="fa fa-edit"></i></span>
                                                    @endif <br>
                                                </div>

                                            </div>
                                        </td>

                                        <td class="price">
                                            @if (getData($project, 'installments-price[]', $i + 1) && getData($project, 'installments-price[]', $i + 1)->value)
                                                <div class="d-flex">
                                                    <div class="input d-none d-flex" style="align-items: center">
                                                        <input type="text" name="installments-price[]"
                                                            class="price-only" style="width: 120px;"
                                                            value="{{ number_format(getData($project, 'installments-price[]', $i + 1)->value, 0, ',', '.') }}">
                                                        <span
                                                            class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex"
                                                            room-order="{{ $i + 1 }}"><i
                                                                class="fa fa-check"></i></span>
                                                        <span
                                                            class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i
                                                                class="fa fa-times"></i></span>
                                                    </div>
                                                    <div class="text d-flex" style="align-items: flex-start;">
                                                        <span
                                                            class="value-text">{{ number_format(getData($project, 'installments-price[]', $i + 1)->value, 0, ',', '.') }}₺</span>
                                                        @if ($sold && $sold[0]->status == 1)
                                                        @else
                                                            <span
                                                                class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i
                                                                    class="fa fa-edit"></i></span>
                                                        @endif
                                                    </div>

                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="price">
                                            @if ($sold && $sold[0]->status == 1)
                                            @else
                                                <div class="pop-up-edit">
                                                    <span room-order="{{ $i + 1 }}"
                                                        class="badge badge-phoenix badge-phoenix-primary batch_update_button">
                                                        Ara ödemeleri güncelle <br>
                                                        {{ getData($project, 'pay-dec-count' . $i + 1, $i + 1) ? getData($project, 'pay-dec-count' . $i + 1, $i + 1)->value : 0 }}
                                                        Adet ara ödeme bulunmakta
                                                    </span>
                                                </div>
                                            @endif
                                        </td>

                                        <td class="price">
                                            @if (getData($project, 'installments[]', $i + 1))
                                                <div class="d-flex">
                                                    <div class="input d-none d-flex" style="align-items: center">
                                                        <input type="number" min="1" max="150"
                                                            name="installments[]" class="number-only"
                                                            style="width: 120px;"
                                                            value="{{ getData($project, 'installments[]', $i + 1)->value }}">
                                                        <span
                                                            class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex"
                                                            room-order="{{ $i + 1 }}"><i
                                                                class="fa fa-check"></i></span>
                                                        <span
                                                            class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i
                                                                class="fa fa-times"></i></span>
                                                    </div>
                                                    <div class="text d-flex" style="align-items: flex-start;">
                                                        <span
                                                            class="value-text">{{ getData($project, 'installments[]', $i + 1)->value }}</span>
                                                        @if ($sold && $sold[0]->status == 1)
                                                        @else
                                                            <span
                                                                class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i
                                                                    class="fa fa-edit"></i></span>
                                                        @endif
                                                    </div>

                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>


                                        <td class="price">
                                            @if (getData($project, 'advance[]', $i + 1) && getData($project, 'advance[]', $i + 1)->value)
                                                <div class="d-flex">
                                                    <div class="input d-none d-flex" style="align-items: center">
                                                        <input type="text" name="advance[]" class="price-only"
                                                            style="width: 120px;"
                                                            value="{{ number_format(getData($project, 'advance[]', $i + 1)->value, 0, ',', '.') }}">
                                                        <span
                                                            class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex"
                                                            room-order="{{ $i + 1 }}"><i
                                                                class="fa fa-check"></i></span>
                                                        <span
                                                            class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i
                                                                class="fa fa-times"></i></span>
                                                    </div>
                                                    <div class="text d-flex" style="align-items: flex-start;">
                                                        <span
                                                            class="value-text">{{ number_format(getData($project, 'advance[]', $i + 1)->value, 0, ',', '.') }}₺</span>
                                                        @if ($sold && $sold[0]->status == 1)
                                                        @else
                                                            <span
                                                                class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i
                                                                    class="fa fa-edit"></i></span>
                                                        @endif
                                                    </div>

                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="sold">
                                            @if (isset($share_sale) && !empty($share_sale) && !empty($share_sale))
                                                <span class=" d-block mb-2">
                                                    @if (isset($sumCartOrderQt[$i + 1]) && isset($sumCartOrderQt[$i + 1]['qt_total']))
                                                        {{ $sumCartOrderQt[$i + 1]['qt_total'] }}
                                                    @else
                                                        0
                                                    @endif / {{ $number_of_share }}
                                                </span>
                                            @endif
                                            @if (isset(getData($project, 'off_sale[]', $i + 1)->value) && getData($project, 'off_sale[]', $i + 1)->value != '[]' && !$sold)
                                                <div class="input d-none d-flex" style="align-items: center">
                                                    <select name="off_sale[]" id="">
                                                        <option value="[]">Satışa Açık</option>
                                                        <option value='["Satışa Kapalı"]' selected>Satışa Kapalı</option>
                                                    </select>
                                                    <span
                                                        class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex"
                                                        input-type="select" room-order="{{ $i + 1 }}"><i
                                                            class="fa fa-check"></i></span>
                                                    <span
                                                        class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i
                                                            class="fa fa-times"></i></span>
                                                </div>
                                                <div class="text d-flex">

                                                    <button
                                                        class="badge badge-phoenix badge-phoenix-danger value-text">Satışa
                                                        Kapatıldı</button>
                                                    <span
                                                        class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i
                                                            class="fa fa-edit"></i></span>
                                                </div>
                                             
                                            @else
                                                @if (
                                                    ($sold && $sold[0]->status == 1 && empty($share_sale)) ||
                                                        (isset($sumCartOrderQt[$i + 1]) && $sumCartOrderQt[$i + 1]['qt_total'] == $number_of_share))
                                                    <button class="badge badge-phoenix badge-phoenix-danger">Satıldı
                                                    </button>
                                                    </div>
                                                    @elseif ($sold && $sold[0]->status == 0 && empty($share_sale))
                                                        <button class="badge badge-phoenix badge-phoenix-warning">Ödeme
                                                            Bekleniyor</button>
                                                    @elseif ($sold && $sold[0]->status == 2 && empty($share_sale))
                                                        <button class="badge badge-phoenix badge-phoenix-success">Tekrar
                                                            Satışta</button>
                                                    @else
                                                        <div class="input d-none d-flex" style="align-items: center">
                                                            <select name="off_sale[]" id="">
                                                                <option value="[]" selected>Satışa Açık</option>
                                                                <option value='["Satışa Kapalı"]'>Satışa Kapalı</option>
                                                            </select>
                                                            <span
                                                                class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex"
                                                                input-type="select" room-order="{{ $i + 1 }}"><i class="fa fa-check"></i></span>
                                                            <span
                                                                class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i
                                                                    class="fa fa-times"></i></span>
                                                        </div>
                                                        <div class="text d-flex">
                                                            <button class="badge badge-phoenix badge-phoenix-success value-text">Satışa
                                                                Açık</button>
                                                            <span
                                                                class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i
                                                                    class="fa fa-edit"></i></span>
                                                        </div>
                                                    @endif
                                                    @endif
                                                </td>
                                                @if ($sold && $sold[0]->status == 1)
                                                    <td class="price">
                                                        @if (isset($sold[0]))
                                                            <a href="{{ route('admin.invoice.show', ['order' => $sold[0]->id]) }}"
                                                                class="badge badge-phoenix badge-phoenix-success value-text">Sipariş Detayı</a>
                                                        @endif

                                                    </td>
                                                @else
                                                    <td class="price">
                                                        <a type="button" class="badge badge-phoenix badge-phoenix-warning" data-bs-toggle="modal" data-bs-target="#exampleModal{{$i+1}}">
                                                            Komşumu Gör
                                                          </a><br>
                                                        <a href="{{ route('institutional.projects.edit.housing', ['project_id' => $project->id, 'room_order' => $i + 1]) }}"
                                                            class="badge badge-phoenix badge-phoenix-primary">İlan Düzenle</a><br>
                                                        <a href="{{ route('institutional.projects.delete.housing', ['project_id' => $project->id, 'room_order' => $i + 1]) }}"
                                                            class="badge badge-phoenix badge-phoenix-danger">Sil</a>
                                                    </td>
                                                
                                                @endif
                       <!--KOMŞUMU GOR Modal -->
                       <div class="modal fade" id="exampleModal{{$i+1}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title text-center mx-auto" id="exampleModalLabel">{{ getData($project, 'advertise_title[]', $i + 1)->value }}</h5>                                
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                            <form action="{{route('admin.projects.housings.komsumu.gor')}}" method="POST">
                                @csrf
                                <input type="hidden" name="no" value="{{ $i+1 }}">
                                <input type="hidden" name="price" value="{{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}">
                                <input type="hidden" name="projectID" value="{{$project->id}}">
                          
                                <div class="form-group">
                                    <label for="surname" class="modal-label">Ad Soyad: </label>
                                    <input type="text" class="modal-input" id="name" name="name" required>
                                </div>

                                <div class="form-group">
                                    <label for="surname" class="modal-label">Email: </label>
                                    <input type="text" class="modal-input" id="email" name="email" required>
                                </div>

                                <div class="form-group">
                                    <label for="surname" class="modal-label">TC : </label>
                                    <input type="number" class="modal-input" id="tc" name="tc" maxlength="11" required>
                                </div>
            
                                <div class="form-group">
                                    <label for="comment" class="modal-label">Adres:</label>
                                    <textarea class="modal-input" id="address" rows="45" style="height: 130px !important;"
                                        name="address" required></textarea>
                                </div>
            
                                <div class="modal-footer">
                                    <button type="submit" class="modal-btn-gonder">Gönder</button>
                                    <button type="button" class="modal-btn-kapat" data-dismiss="modal">Kapat</button>
                                </div>
                            </form>
                            </div>
                        </div>
                        </div>
                    </div>                 
                </tr>
                @endfor
                </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
    </div>

    <div class="total-change-modal d-none">
        <div class="bg"></div>
        <div class="model-content">
            <div class="close"><i class="fa fa-times"></i></div>
            <h4 class="total-change-title">
                Toplu/Tekil seçim
            </h4>

            <div class="kvkk mt-1">
                <div class="finish-tick " style="float:none;padding-left: 0;">
                    <input type="checkbox" id="rules_confirmx" value="1" class="rules_confirm">
                    <label for="rules_confirmx">
                        <span class="rulesOpen">İlan verme kurallarını</span>
                        <span>okudum, kabul ediyorum</span>
                    </label>
                </div>
            </div>
            <div class="mt-1">
                <div class="d-flex">
                    <button type="button" style="width: auto;display:block;border-radius: .25rem;"
                        class="single-adv-do buyUserRequest">
                        <span class="buyUserRequest__text">
                            <div>Sadece belirtilen ilana uygula</div>
                        </span>
                    </button>
                    <button type="button" style="width: auto;display:block;border-radius: .25rem;"
                        class="all-adv-do buyUserRequest mx-3">
                        <span class="buyUserRequest__text">
                            <div>Tüm ilanlara uygula</div>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="total-change-modal-with-input d-none">
        <div class="bg"></div>
        <div class="model-content">
            <div class="close"><i class="fa fa-times"></i></div>
            <h4 class="total-change-title">
                Toplu/Tekil seçim
            </h4>

            <form action="{{ route('institutional.set.selected.data', $project->id) }}" method="post">
                @csrf
                <div class="kvkk mt-1">
                    <input type="hidden" name="selected-items" class="selected-items">
                    <input type="hidden" name="transaction-type" class="transaction-type">
                    <div class="input">
                        <label for="">Yeni <span class="show-text-selected"></span></label>
                        <input type="text" name="new_data" class="form-control price-only" id="">
                    </div>
                    <div class="finish-tick " style="float:none;padding-left: 0;">
                        <input type="checkbox" id="rules_confirmx" value="1" class="rules_confirm">
                        <label for="rules_confirmx">
                            <span class="rulesOpen">İlan verme kurallarını</span>
                            <span>okudum, kabul ediyorum</span>
                        </label>
                    </div>
                </div>
                <div class="mt-1">
                    <div class="d-flex">
                        <button type="submit" style="width: auto;display:block;border-radius: .25rem;"
                            class="single-adv-do buyUserRequest">
                            <span class="buyUserRequest__text">
                                <div>Güncelle</div>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="rulesOpenModal" tabindex="-1" role="dialog"
        aria-labelledby="finalConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="finalConfirmationModalLabel">İlan Verme Kuralları</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <ol>
                        <li> İlan yayıncısı EMLAKSEPETTE’de ilanlarını yayınlayarak “İlan Yayınlama Kuralları”nı kabul etmiş
                            sayılır. Bu sebeple ilan yayınlayan her kişi ve kurum kurallara riayet etme mecburiyetindedir.
                        </li>
                        <li> İlan yayıncıları ilanın içeriğiyle ilgili bilgilerin doğruluğundan sorumludur. İlan bilgileri
                            içerisindeki gerçek dışı fiyat, metrekare, açıklama, kat sayısı gibi parametreler sonucunda
                            ilan, ilan sahibinde danışılmaksızın sistemden kaldırılabilir.</li>
                        <li> İlan içerisinde yer alan fotoğrafların emlak ile ilişkili olması, ilanı yayınlayan kurumun ya
                            da kişinin logo, tanıtım görseli vb.. olmaması gerekmektedir. Sistemde bulunan diğer ilanlardan
                            ayrışmak maksadıyla ve haksız rekabet yaratmak amacıyla ilan resimlerinin üzerine herhangi bir
                            yazı, ikon, şerit, çerçeve yerleştirilmesi fotoğrafın yayından kaldırılmasına sebep olabilir.
                        </li>
                        <li> İlan sahibi aynı gayrimenkulle ilgili sadece bir adet ilan yayınlayabilir. Aynı emlak ile
                            ilgili girilecek çoklu kayıtlar mükerrer ilan sayılacaktır. Mükerrer ilanlar haksız rekabete yol
                            açtığından ötürü sistemden ilan sahibine duyurmaksızın tamamen kaldırılabilir.</li>
                        <li> İlan başlığı içerisinde yalnızca ilanda söz konusu olan gayrimenkule ait bilgiler verilebilir.
                            İlan başlığı içerisinde iletişim bilgisi gibi haksız rekabete yol açabilecek bilgilerin yer
                            verilmesi ilanın yayından kaldırılmasına sebep olabilir.</li>
                        <li> İlan başlığı içerisinde Türkçe karakterler, Türk alfabesinde bulunmayan X, W, Q harfleri,
                            rakamlar, nokta(.), virgül(,), ünlem(!) noktalama işaretleri kullanılabilir. Bu karakterlerin
                            dışında kullanılacak alfanumerik olmayan, rekabete gölge düşürecek hiçbir karakterin ilanlarda
                            yer almasına izin verilmeyecektir.</li>
                        <li> İlan sahibi tarafından satılmış ya da kiralanmış gayrimenkullere ait ilanlar, ilan sahibi
                            tarafından arşivlenmelidir. EMLAKSEPETTE sistemindeki operasyonu tamamlanmış ilanları belirli
                            periyotlarla sistem haricine çıkarma hakkını saklı tutar. Bu işlem sonrasında doğacak yedekleme
                            problemlerinden EMLAKSEPETTE sorumlu değildir.</li>
                        <li> İlan bilgilerinin doluluğu ve doğruluğu, fotoğrafların kalitesi ve geçmiş hareketler göz önünde
                            bulundurularak ilan sahiplerinin ilanları değerlendirilebilir. İlan yayınlama kurallarını
                            sıklıkla ihlal eden kullanıcıların sözleşmesini tek taraflı olarak fesh etme hakkını
                            EMLAKSEPETTE saklı tutar. Aynı şekilde ilan bilgilerini daimi olarak doğru ve hatasız giren
                            kullanıcılar, haksız rekabete yol açmayacak şekilde sistem algoritması tarafından
                            ödüllendirilerek ilanların öne çıkması sağlanabilir.</li>
                        <li> İlan içerisinde yer alan ifadelerin cinsiyet, ırk, renk, dil, din, inanç, mezhep, felsefi ve
                            siyasi görüş, etnik köken, servet, doğum, medeni hâl, sağlık durumu, engellilik ve yaş
                            temellerine dayalı ayrımcılık niteliği taşımaması yasal bir zorunluluktur. Bu tür ifadeler
                            kullanılması hukuka aykırı olup, Türkiye İnsan Hakları ve Eşitlik Kurumu (TİHEK) tarafından
                            idari para cezası verilmesine sebep olabilir. Ayrıca, İlanda belirtilen ifadelerle ayrımcılığa
                            yol açabilecek bilgilere yer verilmesi ilgili ifadelerin ve/veya ilanın yayından kaldırılması
                            sebebidir.</li>
                        <li> İlan yayınlama kurallarına riayet etmeyen kullanıcıların ilanlarındaki bilgilerinin bir kısmı
                            ya da tamamının yayından kaldırılması hakkını EMLAKSEPETTE saklı tutar.</li>
                        <li> Bireysel ve Kurumsal Hesap Sahibi, Portal üzerinden ilan verme, ilan düzenleme ve ilanı yeniden
                            yayına alma işlemlerinden önce yasal mevzuat gereği sistem üzerinden kimliklerini
                            doğrulamalıdır. Bireysel ve Kurumsal Hesap Sahibi, doğrulama işlemi yapmadıkları takdirde ilgili
                            mevzuat uyarınca ilan veremeyeceklerini kabul eder. </li>
                        <li> İlan başlığında ve ilan açıklama bölümünde sadece gayrimenkul hakkındaki bilgiler yer
                            almalıdır.</li>
                        <li> İlan başlığında ve ilan açıklama bölümlerde reklam içerikli yazı yazılmaması, link ve ürüne ait
                            fotoğrafların eklenmemesi gerekmektedir.</li>
                        <li> Yayınlanmak istenen ilanlarda kullanılan fotoğraflar, videolar ve 3 Boyutlu Tur görüntüsü,
                            satılan/kiralanan gayrimenkule ait olmalıdır. Yayınlanan içerikler, fotoğraf, video veya link
                            olarak ilana eklenen 3 Boyutlu Tur görüntüler hakkında EMLAKSEPETTE'nin herhangi bir sorumluluğu
                            bulunmamaktadır.</li>
                        <li> İlan girişlerinde belirtilen kriterlerde (metrekare, oda sayısı, bulunduğu kat, fiyat v.b.)
                            doğru bilgiler yer almalıdır.</li>
                        <li> Eklenen fotoğrafların, videoların, 3 Boyutlu Tur görüntülerinin içeriğinde firma logoları,
                            telefon numarası veya farklı web sitelerinin link, logo ya da isimleri yer almamalıdır. Seçili
                            vitrin resmi olarak işaretlenen görsellerde; firma logoları, telefon numarası, web sitelerinin
                            linki, renkli arka plan, renkli çerçeve, metin içerikleri,firma isimleri, photoshop ve benzeri
                            uygulamalarla eklentiler yer almamalıdır.</li>
                        <li> Sistem içerisindeki farklı bir kullanıcının fotoğrafı / fotoğrafları kullanılmamalıdır.</li>
                        <li> Bir gayrimenkulü satmak için ayrı, kiralamak için ayrı ilan verilmelidir. Aynı ilanda hem
                            satılık hem kiralık detayları bulunamaz.</li>
                        <li> Girilen bir ilanın aynısı, ilk girilen ilan silinerek sisteme yeniden girilemez. Bir ilanın
                            silinip sisteme tekrar yeni baştan girilmesi ve benzeri nitelikteki faaliyetleri gerçekleştiren
                            hesap sahiplerinin bu ilanları silinebilir, hesapları geçici olarak durdurulabilir veya iptal
                            edilebilir.</li>
                        <li> Aynı sitede veya blokta bulunan ve aynı özellikleri taşıyan gayrimenkuller için ayrı ilan
                            girişi yapılmaması, tek bir ilan verilmesi ve bu ilanın açıklamasında aynı konumda farklı
                            dairelerin de olduğunun belirtilmesi gerekmektedir. Aynı özellikte ikinci ilan girişi mükerrer
                            (aynı kayıt) sayılmaktadır.</li>
                        <li> Her bir ilan için farklı resimler kullanılmalıdır, aynı konumda dahi olsa aynı resim ikinci bir
                            ilanda kullanılmamalıdır.</li>
                        <li> Emlak ilan girişleri mutlaka mal sahibi tarafından veya mal sahibinin onayı alınarak
                            yapılmalıdır. Bu sorumluluk ilan verene aittir. Mal sahibinin itirazı doğrultusunda hesap
                            sahiplerinin bu ilanları silinebilir, hesapları geçici olarak durdurulabilir veya iptal
                            edilebilir.</li>
                        <li> Satılık veya kiralık gayrimenkuller için temsili fiyat verilmemelidir.</li>
                        <li> İlan açıklama bölümlerinde web sayfası, mail adresi ve firma iletişim bilgilerine yer
                            verilmemelidir. Telefon numarası ve kullanıcı adı sadece “Kullanıcı bilgileri” bölümünde
                            yayınlanmalıdır. Mağaza kullanıcıları mağazaları için tanıtım sayfası hazırlayarak iletişim ve
                            adres bilgilerini bu alanda yayınlayabilirler ancak web sayfası ve mail adreslerini
                            belirtmemeleri gerekir</li>
                        <li> Satılan ya da kiralanan ürünler Satıldı / Kiralandı olarak tekrar yayına verilemez. Satış
                            işleminin devam ettiği izlenimi yaratan ya da tüketiciyi aldatma ve yanıltma ihtimali
                            yaratabilecek “opsiyonlanmıştır', “kaporası alınmıştır”, "satılmıştır", "ilginiz için
                            teşekkürler" gibi ya da bunlara benzer anlamda ibareler içeren ilanlar yayına alınmaz, yayında
                            olan ilanlar yayından kaldırılır.</li>
                        <li> İlan verme aşamasında, ilana ait belirlenmiş bazı kriterler için girilen bilgiler, ilan veren
                            tarafından sonradan değiştirilemez, ilan veren bu konuda itirazda bulunmayacağını peşinen kabul
                            etmektedir. EMLAKSEPETTE hangi kriterlere ait bilgilerin değiştirilemeyeceğini belirleme, zaman
                            içinde belirlediği kriterlerde değişiklik yapma ve değişiklik yapma tarihi itibariyle
                            belirlediği kriterleri tüm ilanlara uygulama hakkını saklı tutmaktadır.</li>
                        <li> Günlük Kiralık İlan yayınlayanlar; 22/11/2016 tarihli Olağanüstü Hal Kapsamında Bazı
                            Düzenlemeler Yapılması Hakkında Kanun Hükmünde Kararname ile getirilen yeni düzenlemelere, yasal
                            mevzuata ve Portal'daki İlan Yayınlama Kurallarına uygun hareket etmekle yükümlüdür. Yasal
                            yükümlülüklerini yerine getirmeden günlük kiralık ilan yayınlayanlar hakkında uygulanacak
                            cezalardan münhasıran Günlük Kiralık İlan Veren sorumlu olacaktır.</li>
                        <li> Turizm amaçlı kiralık ilan yayınlayanlar; “7464 sayılı “Konutların Turizm Amaçlı Kiralanmasına
                            ve Bazı Kanunlarda Değişiklik Yapılmasına Dair Kanun” ile getirilen yeni düzenlemelere, yasal
                            mevzuata ve Portal'daki İlan Yayınlama Kurallarına uygun hareket etmekle yükümlüdür. Yasal
                            yükümlülüklerini yerine getirmeden turizm amaçlı kiralık ilan yayınlayanlar hakkında uygulanacak
                            cezalardan münhasıran İlan Veren sorumlu olacaktır.</li>
                        <li> Konut> Kiralık kategorisinde sadece aylık kiralık ilanlar verilebilir. Günlük, haftalık vb.
                            kiralık ilanların Günlük Kiralık kategorisinden verilmesi gerekmektedir.</li>
                        <li> Günlük kiralık dairelerde, fiyat kriterine günlük kiralama bedeli girilmelidir.</li>
                        <li> İlanın işyeri ya da konut olarak değerlendirilmesinin kararı ilan verenin sorumluluğundadır.
                            Seçilmiş kategori doğru olarak kabul edilir, ilan verme kurallarına aykırı bir durum yer almıyor
                            ise ilan yayına alınır.</li>
                        <li> Her farklı taşınmaz için ayrı ilan verilmelidir. Farklı konumdaki, taşınmazlar için toplu satış
                            yapılamamaktadır.</li>
                        <li> Turistik Tesis kategorisinde sadece turistik bir tesisin tamamı kiralanabilir ya da tamamının
                            satışı yapılabilir.</li>
                        <li> 13 Eylül 2018 tarihli "Türk Parasının Kıymetini Koruma hakkında 32 sayılı Kararda Değişiklik
                            Yapılmasına Dair Karar"da, 6 Ekim 2018 tarihli “Türk Parası Kıymetini Koruma Hakkında 32 Sayılı
                            Karara İlişkin Tebliğ”de ve 16 Kasım 2018 tarihli ve 30597 sayılı Türk Parası Kıymetini Koruma
                            Hakkında 32 Sayılı Karara İlişkin Tebliğ'de Değişiklik Yapılmasına Dair Tebliğ'de belirtilen
                            sözleşme tiplerine dair kategorilerdeki ilanların fiyat bilgilerinin Türk Lirası olarak
                            girilmesi gerekmektedir.</li>
                        <li> Metaverse, OVR, sanal arazi, sanal dünya üzerinden arazi ve arsa satışları üzerinden arazi ve
                            arsa satışlarına izin verilmez.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="batch-update-pop-up d-none">
        <div class="batch-update-pop-up-bg"></div>
        <div class="batch-update-pop-up-content">
            <div class="close">
                <i class="fa fa-times"></i>
            </div>
            <div class="content-batch">

                <form action="{{ route('institutional.set.pay.decs') }}" method="post">
                    @csrf

                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <input type="hidden" name="item_order" class="item_order">
                    <div class="dec-pay-area">
                        <div class="top">
                            <h4>Ara Ödemeler</h4>
                            <button class="btn btn-primary add-pay-dec"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="pay-desc">
                            <div class="pay-desc-item">
                                <div class="row" style="align-items: flex-end;">
                                    <div class="flex-1">
                                        <button class="btn btn-primary remove-pay-dec"><i
                                                class="fa fa-trash"></i></button>
                                    </div>
                                    <div class="flex-10">
                                        <label for="">Ara Ödeme </label>
                                        <input type="text" value="" name="pay-dec-price[]"
                                            class="price-only form-control pay-desc-price">
                                    </div>
                                    <div class="flex-10">
                                        <label for="">Ara Ödeme Tarihi</label>
                                        <input type="date" value="" name="pay-dec-date[]"
                                            class="form-control pay-desc-date">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <input type="submit" name="current-item" value="Sadece Belirtilen İlana Uygula"
                            class="btn btn-primary btn-sm" />
                        <input type="submit" name="all-items" value="Tüm İlanlara Uygula"
                            class="btn btn-primary btn-sm" />
                    </div>
                </form>
            </div>
        </div>
    </div>


  
    <style>
        .fade:not(.show) {
            display: none !important;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
        integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        @if (Session::has('status') == 'update_selected_items')
            console.log("asd");
            $.toast({
                heading: 'Başarılı',
                text: 'Başarıyla güncellediniz , proje yönetici onayının ardından aktife alınacaktır.',
                position: 'top-right',
                stack: false
            })
        @endif

        function priceFormat(price) {
            let inputValue = price;
            inputValue = inputValue.replace(/\D/g, '');
            inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            return inputValue;
        }

        var targetObj = {};

        var targetProxy = new Proxy(targetObj, {
            set: function(target, key, value) {
                target[key] = value;
                console.log(selectedItems.join(','));
                $('.selected-items').val(selectedItems.join(','))
                $('.item_order').val(selectedItems.join(','))
                if (selectedItems.length > 0) {
                    $('.updates-buttons').removeClass('d-none')
                } else {
                    $('.updates-buttons').addClass('d-none')
                }
                return true;
            }
        });

        let selectedItems = [];
        $('.item-checkbox').change(function() {
            if ($(this).is(':checked')) {
                selectedItems.push($(this).attr('item-id'))
                targetProxy.hello_world = 1;
            } else {
                const index = selectedItems.indexOf($(this).attr('item-id'));
                if (index > -1) {
                    selectedItems.splice(index, 1);
                }
                targetProxy.hello_world = 1;
            }
        })

        $('.all-select').change(function() {
            if ($(this).is(':checked')) {
                $('.item-checkbox').prop('checked', true)
                for (var i = 0; i < $('.item-checkbox').length; i++) {
                    selectedItems.push($('.item-checkbox').eq(i).attr('item-id'))
                    $('.updates-buttons').removeClass('d-none')
                }
                targetProxy.hello_world = 1;
            } else {
                $('.item-checkbox').prop('checked', false)
                for (var i = 0; i < $('.item-checkbox').length; i++) {
                    selectedItems = [];
                    $('.updates-buttons').addClass('d-none')
                }
                targetProxy.hello_world = 0;
            }
        })



        $('.price-update').click(function() {
            $('.total-change-modal-with-input').removeClass('d-none')
            $('.show-text-selected').html('Fiyat')
            $('.transaction-type').val('price')
        })

        $('.installments-price-update').click(function() {
            $('.total-change-modal-with-input').removeClass('d-none')
            $('.transaction-type').val('installments-price')
            $('.show-text-selected').html('Taksitli Fiyat')
        })

        $('.installments-update').click(function() {
            $('.total-change-modal-with-input').removeClass('d-none')
            $('.transaction-type').val('installments')
            $('.show-text-selected').html('Taksit Sayısını')
        })

        $('.advance-update').click(function() {
            $('.total-change-modal-with-input').removeClass('d-none')
            $('.transaction-type').val('advance')
            $('.show-text-selected').html('Peşinat')
        })

        $('.pay-dec-update').click(function() {
            $('.batch-update-pop-up').removeClass('d-none')
        })


        $('.batch_update_button').click(function() {
            $('.batch-update-pop-up').removeClass('d-none')
            var roomOrder = $(this).attr('room-order');

            $.ajax({
                method: "GET",
                url: "{{ route('institutional.get.pay.decs') }}",
                data: {
                    item_order: roomOrder,
                    project_id: {{ $project->id }}
                },
                success: function(response) {
                    response = JSON.parse(response);
                    var html = "";
                    for (var i = 0; i < response.pay_dec_count.value; i++) {
                        html += `
                            <div class="pay-desc-item">
                                <div class="row" style="align-items: flex-end;">
                                    <div class="flex-1">
                                        <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                                    </div>
                                    <div class="flex-10">
                                        <label for="">Ara Ödeme </label>
                                        <input type="text" name="pay-dec-price[]" value="${priceFormat(response.pay_dec_price[i].value)}" class="price-only pay-desc-price form-control">
                                    </div>
                                    <div class="flex-10">
                                        <label for="">Ara Ödeme Tarihi</label>
                                        <input type="date" name="pay-dec-date[]" value="${response.pay_dec_date[i].value}" class="form-control pay-desc-date">
                                    </div>
                                </div>
                            </div>`
                    }

                    $('.pay-desc').html(html);

                },
                error: function(error) {
                    console.log(error)
                }
            })
            $('.item_order').val($(this).attr('room-order'))
        })

        $('.rulesOpen').click(function() {
            $('#rulesOpenModal').addClass('show')
            $('#rulesOpenModal').addClass('d-block')
        })

        $('.batch-update-pop-up-bg').click(function() {
            $('.batch-update-pop-up').addClass('d-none')
        })

        $('.batch-update-pop-up-content .close').click(function() {
            $('.batch-update-pop-up').addClass('d-none')
        })

        $('.add-pay-dec').click(function(e) {
            e.preventDefault();
            $('.pay-desc').append(`
                <div class="pay-desc-item">
                    <div class="row" style="align-items: flex-end;">
                        <div class="flex-1">
                            <button class="btn btn-primary remove-pay-dec"><i class="fa fa-trash"></i></button>
                        </div>
                        <div class="flex-10">
                            <label for="">Ara Ödeme </label>
                            <input type="text" name="pay-dec-price[]" class="price-only pay-desc-price form-control">
                        </div>
                        <div class="flex-10">
                            <label for="">Ara Ödeme Tarihi</label>
                            <input type="date" name="pay-dec-date[]" class="form-control pay-desc-date">
                        </div>
                    </div>
                </div>
            `)

        })

        $(document).on("keyup", ".price-only", function() {
            $('.price-only .error-text').remove();
            if ($(this).val().replace('.', '').replace('.', '').replace('.', '').replace('.', '') != parseInt($(
                    this).val().replace('.', '').replace('.', '').replace('.', '').replace('.', '').replace('.',
                    ''))) {
                if ($(this).closest('.form-group').find('.error-text').length > 0) {
                    $(this).val("");
                } else {
                    $(this).closest('.form-group').append(
                        '<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                    $(this).val("");
                }

            } else {
                let inputValue = $(this).val();

                // Sadece sayı karakterlerine izin ver
                inputValue = inputValue.replace(/\D/g, '');

                // Her üç basamakta bir nokta ekleyin
                inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                $(this).val(inputValue)
                $(this).closest('.form-group').find('.error-text').remove();
            }
        })


        $(document).on("click", ".remove-pay-dec", function(e) {
            e.preventDefault();
            $(this).closest('.pay-desc-item').remove();

        })

        $('#rulesOpenModal').click(function() {
            $(this).removeClass('show')
            $(this).removeClass('d-block')
        })

        $('#rulesOpenModal .close').click(function() {
            $(this).removeClass('show')
            $(this).removeClass('d-block')
        })

        $('#rulesOpenModal .modal-dialog').click(function(e) {
            if (!$(event.target).hasClass('close')) {
                e.stopPropagation();
            }
        })

        $('.total-change-modal .close').click(function() {
            $('.total-change-modal').addClass('d-none');
        })


        $('.total-change-modal .bg').click(function() {
            $('.total-change-modal').addClass('d-none');
        })

        $('.total-change-modal-with-input .close').click(function() {
            $('.total-change-modal-with-input').addClass('d-none');
        })


        $('.total-change-modal-with-input .bg').click(function() {
            $('.total-change-modal-with-input').addClass('d-none');
        })

        $('.edit-button-table').click(function() {
            $(this).closest('td').find('.input').removeClass('d-none');
            $(this).closest('td').find('.text').addClass('d-none');
        })

        $('.cancel-button-table').click(function() {
            $(this).closest('td').find('.input').addClass('d-none');
            $(this).closest('td').find('.text').removeClass('d-none');
        })

        $('.success-button-table').click(function() {
            if ($(this).attr('input-type') == "select") {
                var newVal = $(this).closest('.input').find('select').val();
                var inputName = $(this).closest('.input').find('select').attr('name');
            } else if ($(this).attr('input-type') == "textarea") {
                var newVal = $(this).closest('.input').find('textarea').val();
                var inputName = $(this).closest('.input').find('textarea').attr('name');
            } else {
                var newVal = $(this).closest('.input').find('input').val();
                var inputName = $(this).closest('.input').find('input').attr('name');
            }

            var roomOrder = $(this).attr('room-order');
            var thisx = $(this);

            $('.total-change-modal').removeClass('d-none');

            $('.single-adv-do').click(function() {
                if ($('#rules_confirmx').is(':checked')) {
                    $.ajax({
                            method: "POST",
                            url: "{{ route('institutional.projects.set.single.data', $project->id) }}",
                            data: {
                                inputName: inputName,
                                newVal: newVal,
                                roomOrder: roomOrder,
                                "_token": "{{ csrf_token() }}",
                                allData: 0
                            }
                        })
                        .done(function(res) {
                            res = JSON.parse(res);
                            if (res.status) {
                                thisx.html('<i class="fa fa-check"></i>')
                                thisx.closest('td').find('.input').addClass('d-none');
                                thisx.closest('td').find('.text').removeClass('d-none');

                                if (thisx.closest('td').find('.input').find('input').hasClass(
                                        'price-only')) {

                                    var newTextVal = newVal.replace(/\D/g, '');
                                    // Her üç basamakta bir nokta ekleyin
                                    newTextVal = newTextVal.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                                    thisx.closest('td').find('.text').find('.value-text').html(
                                        newTextVal + '₺')
                                } else {
                                    if (inputName == "off_sale[]") {
                                        if (newVal != "[]") {
                                            newVal = "Satışa Kapalı";
                                            thisx.closest('td').find('.text').find('.value-text')
                                                .removeClass('badge-phoenix-success').addClass(
                                                    'badge-phoenix-danger')
                                       
                                        } else {
                                            newVal = "Satışa Açık";
                                            thisx.closest('td').find('.text').find('.value-text')
                                                .addClass('badge-phoenix-success').removeClass(
                                                    'badge-phoenix-danger')
                                            thisx.closest('td').find('.off-sale-red-text').remove();
                                        }
                                    }
                                    thisx.closest('td').find('.text').find('.value-text').html(newVal)
                                }

                                $.toast({
                                    heading: 'Başarılı',
                                    text: 'Başarıyla güncellediniz , proje yönetici onayının ardından aktife alınacaktır.',
                                    position: 'top-right',
                                    stack: false
                                })

                                $('.total-change-modal').addClass('d-none')
                                $('#rules_confirmx').prop('checked', false);
                            }
                        });
                } else {
                    $.toast({
                        heading: 'Hata',
                        text: 'İlan verme kurallarını onaylamanız gerekmektedir',
                        position: 'top-right',
                        stack: false
                    })
                }


            })

            $('.all-adv-do').click(function() {

                if ($('#rules_confirmx').is(':checked')) {
                    $.ajax({
                            method: "POST",
                            url: "{{ route('institutional.projects.set.single.data', $project->id) }}",
                            data: {
                                inputName: inputName,
                                newVal: newVal,
                                roomOrder: roomOrder,
                                "_token": "{{ csrf_token() }}",
                                allData: 1
                            }
                        })
                        .done(function(res) {
                            res = JSON.parse(res);
                            var indexTd = thisx.closest('td').index();
                            if (res.status) {
                                thisx.html('<i class="fa fa-check"></i>')

                                $('tbody tr').map(tr => {})

                                $('tbody.list tr').map((key, tr) => {
                                    $(tr).find('td').eq(indexTd).find('.input').addClass(
                                        'd-none');
                                    $(tr).find('td').eq(indexTd).find('.text').removeClass(
                                        'd-none');
                                })

                                if (thisx.closest('td').find('.input').find('input').hasClass(
                                        'price-only')) {

                                    var newTextVal = newVal.replace(/\D/g, '');
                                    // Her üç basamakta bir nokta ekleyin
                                    newTextVal = newTextVal.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                    $('tbody.list tr').map((key, tr) => {
                                        $(tr).find('td').eq(indexTd).find('.text').find(
                                            '.value-text').html(newTextVal + '₺')
                                    })
                                } else {
                                    if (inputName == "off_sale[]") {
                                        if (newVal != "[]") {
                                            newVal = "Satışa Kapalı";

                                            $('tbody.list tr').map((key, tr) => {
                                                $(tr).find('td').eq(indexTd).find('.text').find(
                                                    '.value-text').removeClass(
                                                    'badge-phoenix-success').addClass(
                                                    'badge-phoenix-danger');
                                             
                                            })
                                        } else {
                                            newVal = "Satışa Açık";
                                            $('tbody.list tr').map((key, tr) => {
                                                $(tr).find('td').eq(indexTd).find('.text').find(
                                                    '.value-text').addClass(
                                                    'badge-phoenix-success').removeClass(
                                                    'badge-phoenix-danger');
                                                $(tr).find('td').eq(indexTd).find(
                                                    '.off-sale-red-text').remove();;
                                            })
                                        }
                                    }

                                    $('tbody.list tr').map((key, tr) => {
                                        $(tr).find('td').eq(indexTd).find('.text').find(
                                            '.value-text').html(newVal)
                                    })
                                }

                                $.toast({
                                    heading: 'Başarılı',
                                    text: 'Başarıyla güncellediniz , proje yönetici onayının ardından aktife alınacaktır.',
                                    position: 'top-right',
                                    stack: false
                                })

                                $('.total-change-modal').addClass('d-none')
                                $('#rules_confirmx').prop('checked', false);
                            }
                        });
                } else {
                    $.toast({
                        heading: 'Hata',
                        text: 'İlan verme kurallarını onaylamanız gerekmektedir',
                        position: 'top-right',
                        stack: false
                    })
                }
            })
        })


        $('.price-only').keyup(function() {
            if ($(this).val().replace('.', '').replace('.', '').replace('.', '').replace('.', '') != parseInt($(
                    this).val().replace('.', '').replace('.', '').replace('.', '').replace('.', '').replace('.',
                    ''))) {

                $('.price-only').val("");

            } else {
                let inputValue = $(this).val();

                // Sadece sayı karakterlerine izin ver
                inputValue = inputValue.replace(/\D/g, '');

                // Her üç basamakta bir nokta ekleyin
                inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                $(this).val(inputValue)
                $(this).closest('.form-group').find('.error-text').remove();
            }
        })

        $('.number-only').keyup(function() {
            if (parseInt($(this).val()) > $(this).attr('max')) {
                $(this).val($(this).attr('max'))
            }
            $('.number-only .error-text').remove();
            if ($(this).val() != parseInt($(this).val())) {
                if ($(this).closest('.form-group').find('.error-text').length > 0) {
                    $(this).val("");
                } else {
                    $(this).closest('.form-group').append(
                        '<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                    $(this).val("");
                }

            } else {
                $(this).closest('.form-group').find('.error-text').remove();
            }
        })

        $('.image-opa').click(function() {
            $(this).closest('.image-with-hover').find('input').trigger('click')
        })

        $('.change-image').change(function() {
            var input = this;
            var newVal = this.files[0];
            var roomOrder = parseInt($(this).closest('tr').index()) + 1;
            var thisx = $(this);

            $('.total-change-modal').removeClass('d-none');

            $('.single-adv-do').click(function() {
                if ($('#rules_confirmx').is(':checked')) {
                    var formdata = new FormData();
                    formdata.append('file', newVal);
                    formdata.append('roomOrder', roomOrder);
                    formdata.append('_token', "{{ csrf_token() }}");
                    jQuery.ajax({
                        url: "{{ route('institutional.projects.set.single.image', $project->id) }}",
                        type: "POST",
                        data: formdata,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            res = JSON.parse(res);
                            if (res.status) {
                                $.toast({
                                    heading: 'Başarılı',
                                    text: 'Başarıyla güncellediniz , proje yönetici onayının ardından aktife alınacaktır.',
                                    position: 'top-right',
                                    stack: false
                                })
                            }
                        }
                    });
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        // Resmi görüntülemek için bir div oluşturun
                        thisx.parent('.image-with-hover').find('img').attr('src', e.target.result)
                    };

                    // Resmi okuyun
                    reader.readAsDataURL(input.files[0]);

                    $('.total-change-modal').addClass('d-none')
                    $('#rules_confirmx').prop('checked', false);
                } else {
                    $.toast({
                        heading: 'Hata',
                        text: 'İlan verme kurallarını onaylamanız gerekmektedir',
                        position: 'top-right',
                        stack: false
                    })
                }
            })



            $('.all-adv-do').click(function() {
                if ($('#rules_confirmx').is(':checked')) {
                    var formdata = new FormData();
                    formdata.append('file', newVal);
                    formdata.append('allData', 1);
                    formdata.append('roomOrder', roomOrder);
                    formdata.append('_token', "{{ csrf_token() }}");
                    jQuery.ajax({
                        url: "{{ route('institutional.projects.set.single.image', $project->id) }}",
                        type: "POST",
                        data: formdata,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            res = JSON.parse(res);
                            if (res.status) {
                                $.toast({
                                    heading: 'Başarılı',
                                    text: 'Başarıyla güncellediniz , proje yönetici onayının ardından aktife alınacaktır.',
                                    position: 'top-right',
                                    stack: false
                                })
                            }
                        }
                    });
                    var thisx = $(this);
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        // Resmi görüntülemek için bir div oluşturun
                        $('tbody.list tr').map((key, tr) => {
                            console.log($(tr).find('td').eq(1).find('.image-with-hover'));
                            $(tr).find('td').eq(1).find('.image-with-hover').find('img').attr(
                                'src', e.target.result)
                        })
                    };

                    // Resmi okuyun
                    reader.readAsDataURL(input.files[0]);
                    $('#rules_confirmx').prop('checked', false);
                    $('.total-change-modal').addClass('d-none')
                } else {
                    $.toast({
                        heading: 'Hata',
                        text: 'İlan verme kurallarını onaylamanız gerekmektedir',
                        position: 'top-right',
                        stack: false
                    })
                }
            })

        })
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css"
        integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .fade:not(.show) {
            display: none !important;
        }
    </style>
@endsection


@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css"
        integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.css" />

    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/assets/css/daterangepicker.css">
    <link rel="stylesheet" href="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/skins/content/default/content.min.css">

    <style>
         .modal-label {
            margin: 0.3em 0em;
            font-size: 13px;
            font: bold;
            color: #000000 !important;
        }

        .modal-input {
            padding: 0.7em !important;
            border: 1px solid #ccc !important;
            border-radius: 0.4em !important;
            margin: 0.5em 0em;
            width: 100%;
            transition: border-color 0.3s;
        }

        .modal-footer {
            display: flex;
            justify-content: space-between;
        }

        .modal-btn-gonder,
        .modal-btn-kapat {
            padding: 0.8em 2em;
            font-weight: 600;
            letter-spacing: 2px;
            transition: background-color 0.3s;
            width: 45%;
            border: none;
            height: 45px;
        }

        .modal-btn-gonder {
            background-color: #ea2b2e;
            color: #fff;
        }

        .modal-btn-kapat {
            background-color: #1e1e1e;
            color: #fff;
        }
    </style>
@endsection
