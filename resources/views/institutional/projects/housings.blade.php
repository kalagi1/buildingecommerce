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
        <div class="badge badge-phoenix badge-phoenix-warning w-100 py-2 mb-2"><i class="fa fa-info-circular"></i> Yapacağınız güncellemelerde ilan tekrar admin onayına düşecektir</div>
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
                                            <th class="sort" data-sort="price">Fiyat</th>
                                            <th class="sort" data-sort="price">Taksitli Fiyat</th>
                                            <th class="sort" data-sort="price">Taksit Sayısı</th>
                                            <th class="sort" data-sort="price">Peşinat</th>
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
                                                            <input type="text" name="advertise_title[]" style="width: 120px;" value="{{ getData($project, 'advertise_title[]', $i + 1)->value }}">
                                                            <span class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex" room-order="{{$i + 1}}"><i class="fa fa-check"></i></span>
                                                            <span class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i class="fa fa-times"></i></span>
                                                        </div>
                                                        <div class="text d-flex" style="align-items: flex-start;">
                                                            <span class="value-text">{{ getData($project, 'advertise_title[]', $i + 1)->value }}</span>
                                                            <span class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i class="fa fa-edit"></i></span>
                                                        </div>
                                                        
                                                    </div>
                                                </td>
        
                                                <td class="price">
                                                    <div class="d-flex">
                                                        <div class="input d-none d-flex" style="align-items: center">
                                                            <input type="text" name="price[]" class="price-only" style="width: 120px;" value="{{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}">
                                                            <span class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex" room-order="{{$i + 1}}"><i class="fa fa-check"></i></span>
                                                            <span class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i class="fa fa-times"></i></span>
                                                        </div>
                                                        <div class="text d-flex" style="align-items: flex-start;">
                                                            <span class="value-text">{{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}₺</span>
                                                            <span class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i class="fa fa-edit"></i></span>
                                                        </div>
                                                        
                                                    </div>
                                                </td>
        
                                                <td class="price">
                                                    @if(getData($project, 'installments-price[]', $i + 1))
                                                    <div class="d-flex">
                                                        <div class="input d-none d-flex" style="align-items: center">
                                                            <input type="text" name="installments-price[]" class="price-only" style="width: 120px;" value="{{ number_format(getData($project, 'installments-price[]', $i + 1)->value, 0, ',', '.') }}">
                                                            <span class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex" room-order="{{$i + 1}}"><i class="fa fa-check"></i></span>
                                                            <span class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i class="fa fa-times"></i></span>
                                                        </div>
                                                        <div class="text d-flex" style="align-items: flex-start;">
                                                            <span class="value-text">{{ number_format(getData($project, 'installments-price[]', $i + 1)->value, 0, ',', '.') }}₺</span>
                                                            <span class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i class="fa fa-edit"></i></span>
                                                        </div>
                                                        
                                                    </div>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                
                                                <td class="price">
                                                    @if(getData($project, 'installments[]', $i + 1))
                                                    <div class="d-flex">
                                                        <div class="input d-none d-flex" style="align-items: center">
                                                            <input type="number" min="1" max="150" name="installments[]" class="number-only" style="width: 120px;" value="{{ getData($project, 'installments[]', $i + 1)->value }}">
                                                            <span class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex" room-order="{{$i + 1}}"><i class="fa fa-check"></i></span>
                                                            <span class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i class="fa fa-times"></i></span>
                                                        </div>
                                                        <div class="text d-flex" style="align-items: flex-start;">
                                                            <span class="value-text">{{getData($project, 'installments[]', $i + 1)->value }}</span>
                                                            <span class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i class="fa fa-edit"></i></span>
                                                        </div>
                                                        
                                                    </div>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
        
                                                
                                                <td class="price">
                                                    @if(getData($project, 'advance[]', $i + 1))
                                                    <div class="d-flex">
                                                        <div class="input d-none d-flex" style="align-items: center">
                                                            <input type="text" name="advance[]" class="price-only" style="width: 120px;" value="{{ number_format(getData($project, 'advance[]', $i + 1)->value, 0, ',', '.') }}">
                                                            <span class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex" room-order="{{$i + 1}}"><i class="fa fa-check"></i></span>
                                                            <span class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i class="fa fa-times"></i></span>
                                                        </div>
                                                        <div class="text d-flex" style="align-items: flex-start;">
                                                            <span class="value-text">{{ number_format(getData($project, 'advance[]', $i + 1)->value, 0, ',', '.') }}₺</span>
                                                            <span class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i class="fa fa-edit"></i></span>
                                                        </div>
                                                        
                                                    </div>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="sold">
                                                    @if (getData($project, 'off_sale[]', $i + 1)->value != '[]')
                                                        <div class="input d-none d-flex" style="align-items: center">
                                                            <select name="off_sale[]" id="">
                                                                <option value="[]" >Satışa Açık</option>
                                                                <option value='["Satışa Kapalı"]' selected>Satışa Kapalı</option>
                                                            </select>
                                                            <span class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex" input-type="select" room-order="{{$i + 1}}"><i class="fa fa-check"></i></span>
                                                            <span class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i class="fa fa-times"></i></span>
                                                        </div>
                                                        <div class="text d-flex">
                                                            
                                                            <button class="badge badge-phoenix badge-phoenix-danger value-text">Satışa Kapatıldı</button>
                                                            <span class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i class="fa fa-edit"></i></span>
                                                        </div>
                                                        <p style="color: red;margin-top:10px;width:200px;" class="off-sale-red-text">Alıcılara satışa kapalı
                                                            olarak
                                                            gözükecektir.</p>
                                                    @else
                                                        @if ($sold && $sold[0]->status == 1)
                                                            <button class="badge badge-phoenix badge-phoenix-danger">Satıldı</button>
                                                        @elseif ($sold && $sold[0]->status == 0)
                                                            <button class="badge badge-phoenix badge-phoenix-warning">Ödeme Bekleniyor</button>
                                                        @elseif ($sold && $sold[0]->status == 2)
                                                            <button class="badge badge-phoenix badge-phoenix-success">Tekrar Satışta</button>
                                                        @else
                                                            <div class="input d-none d-flex" style="align-items: center">
                                                                <select name="off_sale[]" id="">
                                                                    <option value="[]" selected>Satışa Açık</option>
                                                                    <option value='["Satışa Kapalı"]' >Satışa Kapalı</option>
                                                                </select>
                                                                <span class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex" input-type="select" room-order="{{$i + 1}}"><i class="fa fa-check"></i></span>
                                                                <span class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i class="fa fa-times"></i></span>
                                                            </div>
                                                            <div class="text d-flex">
                                                                <button class="badge badge-phoenix badge-phoenix-success value-text">Satışa Açık</button>
                                                                <span class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i class="fa fa-edit"></i></span>
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
                    @endforeach
                @else
                    <div class="table-responsive scrollbar mx-n1 px-1">
                        <table class="table fs--1 mb-0">
                            <thead>
                                <tr>
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
                                @for ($i = 0; $i < $project->room_count; $i++)
                                    @php
                                        $sold = DB::select('SELECT * FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "project"  AND JSON_EXTRACT(cart, "$.item.housing") = ? AND JSON_EXTRACT(cart, "$.item.id") = ? LIMIT 1', [getData($project, 'price[]', $i + 1)->room_order, $project->id]);
                                    @endphp

                                    <tr>
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
                                                    <input type="text" name="advertise_title[]" style="width: 120px;" value="{{ getData($project, 'advertise_title[]', $i + 1)->value }}">
                                                    <span class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex" room-order="{{$i + 1}}"><i class="fa fa-check"></i></span>
                                                    <span class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i class="fa fa-times"></i></span>
                                                </div>
                                                <div class="text d-flex" style="align-items: flex-start;">
                                                    <span class="value-text">{{ getData($project, 'advertise_title[]', $i + 1)->value }}</span>
                                                    <span class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i class="fa fa-edit"></i></span>
                                                </div>
                                                
                                            </div>
                                        </td>

                                        <td class="price">
                                            <div class="d-flex">
                                                <div class="input d-none d-flex" style="align-items: center">
                                                    <input type="text" name="price[]" class="price-only" style="width: 120px;" value="{{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}">
                                                    <span class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex" room-order="{{$i + 1}}"><i class="fa fa-check"></i></span>
                                                    <span class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i class="fa fa-times"></i></span>
                                                </div>
                                                <div class="text d-flex" style="align-items: flex-start;">
                                                    <span class="value-text">{{ number_format(getData($project, 'price[]', $i + 1)->value, 0, ',', '.') }}₺</span>
                                                    <span class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i class="fa fa-edit"></i></span>
                                                </div>
                                                
                                            </div>
                                        </td>

                                        <td class="price">
                                            @if(getData($project, 'installments-price[]', $i + 1))
                                            <div class="d-flex">
                                                <div class="input d-none d-flex" style="align-items: center">
                                                    <input type="text" name="installments-price[]" class="price-only" style="width: 120px;" value="{{ number_format(getData($project, 'installments-price[]', $i + 1)->value, 0, ',', '.') }}">
                                                    <span class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex" room-order="{{$i + 1}}"><i class="fa fa-check"></i></span>
                                                    <span class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i class="fa fa-times"></i></span>
                                                </div>
                                                <div class="text d-flex" style="align-items: flex-start;">
                                                    <span class="value-text">{{ number_format(getData($project, 'installments-price[]', $i + 1)->value, 0, ',', '.') }}₺</span>
                                                    <span class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i class="fa fa-edit"></i></span>
                                                </div>
                                                
                                            </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        
                                        <td class="price">
                                            @if(getData($project, 'installments[]', $i + 1))
                                            <div class="d-flex">
                                                <div class="input d-none d-flex" style="align-items: center">
                                                    <input type="number" min="1" max="150" name="installments[]" class="number-only" style="width: 120px;" value="{{ getData($project, 'installments[]', $i + 1)->value }}">
                                                    <span class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex" room-order="{{$i + 1}}"><i class="fa fa-check"></i></span>
                                                    <span class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i class="fa fa-times"></i></span>
                                                </div>
                                                <div class="text d-flex" style="align-items: flex-start;">
                                                    <span class="value-text">{{getData($project, 'installments[]', $i + 1)->value }}</span>
                                                    <span class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i class="fa fa-edit"></i></span>
                                                </div>
                                                
                                            </div>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        
                                        <td class="price">
                                            @if(getData($project, 'advance[]', $i + 1))
                                            <div class="d-flex">
                                                <div class="input d-none d-flex" style="align-items: center">
                                                    <input type="text" name="advance[]" class="price-only" style="width: 120px;" value="{{ number_format(getData($project, 'advance[]', $i + 1)->value, 0, ',', '.') }}">
                                                    <span class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex" room-order="{{$i + 1}}"><i class="fa fa-check"></i></span>
                                                    <span class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i class="fa fa-times"></i></span>
                                                </div>
                                                <div class="text d-flex" style="align-items: flex-start;">
                                                    <span class="value-text">{{ number_format(getData($project, 'advance[]', $i + 1)->value, 0, ',', '.') }}₺</span>
                                                    <span class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i class="fa fa-edit"></i></span>
                                                </div>
                                                
                                            </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="sold">
                                            @if (getData($project, 'off_sale[]', $i + 1)->value != '[]')
                                                <div class="input d-none d-flex" style="align-items: center">
                                                    <select name="off_sale[]" id="">
                                                        <option value="[]" >Satışa Açık</option>
                                                        <option value='["Satışa Kapalı"]' selected>Satışa Kapalı</option>
                                                    </select>
                                                    <span class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex" input-type="select" room-order="{{$i + 1}}"><i class="fa fa-check"></i></span>
                                                    <span class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i class="fa fa-times"></i></span>
                                                </div>
                                                <div class="text d-flex">
                                                    
                                                    <button class="badge badge-phoenix badge-phoenix-danger value-text">Satışa Kapatıldı</button>
                                                    <span class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i class="fa fa-edit"></i></span>
                                                </div>
                                                <p style="color: red;margin-top:10px;width:200px;" class="off-sale-red-text">Alıcılara satışa kapalı
                                                    olarak
                                                    gözükecektir.</p>
                                            @else
                                                @if ($sold && $sold[0]->status == 1)
                                                    <button class="badge badge-phoenix badge-phoenix-danger">Satıldı</button>
                                                @elseif ($sold && $sold[0]->status == 0)
                                                    <button class="badge badge-phoenix badge-phoenix-warning">Ödeme Bekleniyor</button>
                                                @elseif ($sold && $sold[0]->status == 2)
                                                    <button class="badge badge-phoenix badge-phoenix-success">Tekrar Satışta</button>
                                                @else
                                                    <div class="input d-none d-flex" style="align-items: center">
                                                        <select name="off_sale[]" id="">
                                                            <option value="[]" selected>Satışa Açık</option>
                                                            <option value='["Satışa Kapalı"]' >Satışa Kapalı</option>
                                                        </select>
                                                        <span class="badge badge-phoenix badge-phoenix-success success-button-table mx-1 cursor-pointer d-flex" input-type="select" room-order="{{$i + 1}}"><i class="fa fa-check"></i></span>
                                                        <span class="badge badge-phoenix badge-phoenix-danger cancel-button-table mx-1 cursor-pointer d-flex"><i class="fa fa-times"></i></span>
                                                    </div>
                                                    <div class="text d-flex">
                                                        <button class="badge badge-phoenix badge-phoenix-success value-text">Satışa Açık</button>
                                                        <span class="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i class="fa fa-edit"></i></span>
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
                @endif
            </div>
        </div>
    </div>

    <div class="total-change-modal d-none">
        <div class="bg"></div>
        <div class="model-content">
            <div class="close"><i class="fa fa-times"></i></div>
            <h4 class="total-change-title">
                İlan Başlığı
            </h4>
            <span class="total-change-value">Deneme İlanı</span>
            <div class="mt-4">
                <div class="d-flex">
                    <button type="button" style="width: auto;display:block;border-radius: .25rem;" class="single-adv-do buyUserRequest">
                        <span class="buyUserRequest__text"> 
                            <div>Sadece belirtilen ilana uygula</div>
                        </span>
                    </button>
                    <button type="button" style="width: auto;display:block;border-radius: .25rem;" class="all-adv-do buyUserRequest mx-3">
                        <span class="buyUserRequest__text"> 
                            <div>Tüm ilanlara uygula</div>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .fade:not(.show){
            display:  none !important;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <script>
        $('.total-change-modal .close').click(function(){
            $('.total-change-modal').addClass('d-none');
        })

        
        $('.total-change-modal .bg').click(function(){
            $('.total-change-modal').addClass('d-none');
        })

        $('.edit-button-table').click(function(){
            $(this).closest('td').find('.input').removeClass('d-none');
            $(this).closest('td').find('.text').addClass('d-none');
        })

        $('.cancel-button-table').click(function(){
            $(this).closest('td').find('.input').addClass('d-none');
            $(this).closest('td').find('.text').removeClass('d-none');
        })

        $('.success-button-table').click(function(){
            if($(this).attr('input-type') == "select"){
                var newVal = $(this).closest('.input').find('select').val();
                var inputName = $(this).closest('.input').find('select').attr('name');
            }else{
                var newVal = $(this).closest('.input').find('input').val();
                var inputName = $(this).closest('.input').find('input').attr('name');
            }

            var roomOrder = $(this).attr('room-order');
            var thisx = $(this);

            $('.total-change-modal').removeClass('d-none');

            $('.single-adv-do').click(function(){
                $(this).html('<i class="fa fa-spinner spinner-borderx"></i>')
                $.ajax({
                    method: "POST",
                    url: "{{route('institutional.projects.set.single.data',$project->id)}}",
                    data: { inputName: inputName, newVal: newVal , roomOrder : roomOrder , "_token": "{{ csrf_token() }}", allData : 0 }
                })
                .done(function( res ) {
                    res = JSON.parse(res);
                    if(res.status){
                        thisx.html('<i class="fa fa-check"></i>')
                        thisx.closest('td').find('.input').addClass('d-none');
                        thisx.closest('td').find('.text').removeClass('d-none');

                        if(thisx.closest('td').find('.input').find('input').hasClass('price-only')){

                            var newTextVal =  newVal.replace(/\D/g, '');
                            // Her üç basamakta bir nokta ekleyin
                            newTextVal = newTextVal.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                            thisx.closest('td').find('.text').find('.value-text').html(newTextVal+'₺')
                        }else{
                            if(inputName == "off_sale[]"){
                                if(newVal != "[]"){
                                    newVal = "Satışa Kapalı";
                                    thisx.closest('td').find('.text').find('.value-text').removeClass('badge-phoenix-success').addClass('badge-phoenix-danger')
                                    thisx.closest('td').append('<p class="off-sale-red-text" style="color: red;margin-top:10px;width:200px;">Alıcılara satışa kapalı olarak gözükecektir.</p>')
                                }else{
                                    newVal = "Satışa Açık";
                                    thisx.closest('td').find('.text').find('.value-text').addClass('badge-phoenix-success').removeClass('badge-phoenix-danger')
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
                    }
                });
            })
            
            $('.all-adv-do').click(function(){
                $.ajax({
                    method: "POST",
                    url: "{{route('institutional.projects.set.single.data',$project->id)}}",
                    data: { inputName: inputName, newVal: newVal , roomOrder : roomOrder , "_token": "{{ csrf_token() }}" , allData : 1 }
                })
                .done(function( res ) {
                    res = JSON.parse(res);
                    var indexTd = thisx.closest('td').index();
                    if(res.status){
                        thisx.html('<i class="fa fa-check"></i>')

                        $('tbody tr').map(tr => {
                        })

                        $('tbody.list tr').map((key,tr) => {
                            $(tr).find('td').eq(indexTd).find('.input').addClass('d-none');
                            $(tr).find('td').eq(indexTd).find('.text').removeClass('d-none');
                        })
                        
                        if(thisx.closest('td').find('.input').find('input').hasClass('price-only')){

                            var newTextVal =  newVal.replace(/\D/g, '');
                            // Her üç basamakta bir nokta ekleyin
                            newTextVal = newTextVal.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            $('tbody.list tr').map((key,tr) => {
                                $(tr).find('td').eq(indexTd).find('.text').find('.value-text').html(newTextVal+'₺')
                            })
                        }else{
                            if(inputName == "off_sale[]"){
                                if(newVal != "[]"){
                                    newVal = "Satışa Kapalı";
                                    
                                    $('tbody.list tr').map((key,tr) => {
                                        $(tr).find('td').eq(indexTd).find('.text').find('.value-text').removeClass('badge-phoenix-success').addClass('badge-phoenix-danger');
                                        $(tr).find('td').eq(indexTd).append('<p class="off-sale-red-text" style="color: red;margin-top:10px;width:200px;">Alıcılara satışa kapalı olarak gözükecektir.</p>');
                                    })
                                }else{
                                    newVal = "Satışa Açık";
                                    $('tbody.list tr').map((key,tr) => {
                                        $(tr).find('td').eq(indexTd).find('.text').find('.value-text').addClass('badge-phoenix-success').removeClass('badge-phoenix-danger');
                                        $(tr).find('td').eq(indexTd).find('.off-sale-red-text').remove();;
                                    })
                                }
                            }

                            $('tbody.list tr').map((key,tr) => {
                                $(tr).find('td').eq(indexTd).find('.text').find('.value-text').html(newVal)
                            })
                        }

                        $.toast({
                            heading: 'Başarılı',
                            text: 'Başarıyla güncellediniz , proje yönetici onayının ardından aktife alınacaktır.',
                            position: 'top-right',
                            stack: false
                        })

                        $('.total-change-modal').addClass('d-none')
                    }
                });
            })
        })
        

        $('.price-only').keyup(function(){
            if($(this).val().replace('.','').replace('.','').replace('.','').replace('.','') != parseInt($(this).val().replace('.','').replace('.','').replace('.','').replace('.','').replace('.','') )){
                
                    $('.price-only').val("");
                
            }else{
                let inputValue = $(this).val();

                // Sadece sayı karakterlerine izin ver
                inputValue = inputValue.replace(/\D/g, '');

                // Her üç basamakta bir nokta ekleyin
                inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                $(this).val(inputValue)
                $(this).closest('.form-group').find('.error-text').remove();
            }
        })

        $('.number-only').keyup(function(){
            if(parseInt($(this).val()) > $(this).attr('max')){
                $(this).val($(this).attr('max'))
            }
            $('.number-only .error-text').remove();
            if($(this).val() != parseInt($(this).val())){
                if($(this).closest('.form-group').find('.error-text').length > 0){
                    $(this).val("");
                }else{
                    $(this).closest('.form-group').append('<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                    $(this).val("");
                }
                
            }else{
                $(this).closest('.form-group').find('.error-text').remove();
            }
        })

        $('.image-opa').click(function(){
            $(this).closest('.image-with-hover').find('input').trigger('click')
        })

        $('.change-image').change(function(){
            var input = this;
            var newVal = this.files[0];
            var roomOrder = parseInt($(this).closest('tr').index()) + 1;
            var thisx = $(this);
            
            $('.total-change-modal').removeClass('d-none');

            $('.single-adv-do').click(function(){
                var formdata = new FormData();  
                formdata.append('file',newVal);
                formdata.append('roomOrder',roomOrder);
                formdata.append('_token',"{{ csrf_token() }}");
                jQuery.ajax({
                    url: "{{route('institutional.projects.set.single.image',$project->id)}}",
                    type: "POST",
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success:function(res){
                        res = JSON.parse(res);
                        if(res.status){
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
                    thisx.parent('.image-with-hover').find('img').attr('src',e.target.result)
                };

                // Resmi okuyun
                reader.readAsDataURL(input.files[0]);

                $('.total-change-modal').addClass('d-none')
            })

            
            
            $('.all-adv-do').click(function(){
                var formdata = new FormData();  
                formdata.append('file',newVal);
                formdata.append('allData',1);
                formdata.append('roomOrder',roomOrder);
                formdata.append('_token',"{{ csrf_token() }}");
                jQuery.ajax({
                    url: "{{route('institutional.projects.set.single.image',$project->id)}}",
                    type: "POST",
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success:function(res){
                        res = JSON.parse(res);
                        if(res.status){
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
                    $('tbody.list tr').map((key,tr) => {
                        console.log($(tr).find('td').eq(1).find('.image-with-hover'));
                        $(tr).find('td').eq(1).find('.image-with-hover').find('img').attr('src',e.target.result)
                    })
                };

                // Resmi okuyun
                reader.readAsDataURL(input.files[0]);

                $('.total-change-modal').addClass('d-none')
                
            })
            
        })
    </script>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css" integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .fade:not(.show){
        display:  none !important;
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
@endsection