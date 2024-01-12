@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="card border mb-3" data-list="{&quot;valueNames&quot;:[&quot;icon-list-item&quot;]}">
            <div class="card-header border-bottom bg-body">
                <div class="row flex-between-center g-2">
                    <div class="col-auto">
                        <h4 class="mb-0">{{ $collection->name }}</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row project-filter-reverse blog-pots mt-3">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < count($items); $i++)
                                <tr>
                                    <td>
                                        <a
                                            href="{{ $items[$i]->item_type == 1 ? route('project.housings.detail', [$items[$i]->project->slug, $items[$i]->room_order]) : route('housing.show', [$items[$i]->housing->id]) }}">
                                            <img src="{{ $items[$i]->item_type == 1 ? URL::to('/') . '/project_housing_images/' . $items[$i]->project_values['image[]'] : URL::to('/') . '/housing_images/' . json_decode($items[$i]->housing->housing_type_data)->image }}"
                                                alt="home-1" class="img-responsive"
                                                style="height: 100px !important; object-fit: cover">
                                        </a>
                                    </td>
                                    <td>
                                        {{ $items[$i]->item_type == 1 ? $items[$i]->project_values['advertise_title[]'] : $items[$i]->housing->title }}
                                    </td>
                                    {{-- 
                                    <td>
                                        {{ $items[$i]->item_type == 1 ? ($items[$i]->project->listItemValues->column1_name ? $items[$i]->project_values[$items[$i]->project->listItemValues->column1_name . '[]'] : '') : ($items[$i]->housing->listItems->column1_name ? json_decode($items[$i]->housing->housing_type_data)->{$items[$i]->housing->listItems->column1_name}[0] ?? '' : '') }}
                                    </td>
                                    <td>
                                        {{ $items[$i]->item_type == 1 ? ($items[$i]->project->listItemValues->column2_name ? $items[$i]->project_values[$items[$i]->project->listItemValues->column2_name . '[]'] : '') : ($items[$i]->housing->listItems->column2_name ? json_decode($items[$i]->housing->housing_type_data)->{$items[$i]->housing->listItems->column2_name}[0] ?? '' : '') }}
                                    </td>
                                    <td>
                                        {{ $items[$i]->item_type == 1 ? ($items[$i]->project->listItemValues->column3_name ? $items[$i]->project_values[$items[$i]->project->listItemValues->column3_name . '[]'] : '') : ($items[$i]->housing->listItems->column3_name ? json_decode($items[$i]->housing->housing_type_data)->{$items[$i]->housing->listItems->column3_name}[0] ?? '' : '') }}
                                    </td> --}}
                                    <td>
                                        {{ number_format($items[$i]->item_type == 1 ? $items[$i]->project_values['price[]'] : json_decode($items[$i]->housing->housing_type_data)->price[0], 0, ',', '.') }}
                                        ₺
                                    </td>
                                    <td>
                                        <button class="btn btn-info remove-from-collection"
                                            data-type="{{ $items[$i]->item_type == 1 ? 'project' : 'housing' }}"
                                            data-id="{{ $items[$i]->item_type == 1 ? $items[$i]->room_order : $items[$i]->housing->id }}"
                                            @if ($items[$i]->item_type == 1) data-project="{{ $items[$i]->project->id }}" @endif
                                            onclick="removeFromCollection(this)">
                                            Koleksiyondan Kaldır
                                        </button>



                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
    @endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        function removeFromCollection(button) {
            var itemType = $(button).data('type');
            var itemId = $(button).data('id');
            var projectId = $(button).data('project');

            $.ajax({
                method: 'POST',
                url: '/remove-from-collection', 
                data: {
                    itemType: itemType,
                    itemId: itemId,
                    projectId: projectId,
                    _token: '{{ csrf_token() }}',

                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
; 
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>

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
