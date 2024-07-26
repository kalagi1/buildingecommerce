@extends('client.layouts.masterPanel')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="table-breadcrumb">
            <ul>
                <li>Hesabım</li>
                <li>Emlak İlanlarım</li>
            </ul>
        </div>
    </div>

    <section>
        <div class="front-project-tabs">
            <ul class="mt-3 mb-3" id="housingTabs">
                @foreach ([
                        ['id' => 'active', 'text' => 'Aktif İlanlar', 'count' => $activeHousingTypes->count()],
                ['id' => 'pendingHousingTypes', 'text' => 'Onay Bekleyen İlanlar', 'count' => $pendingHousingTypes->count()],
                ['id' => 'disabledHousingTypes', 'text' => 'Reddedilen İlanlar', 'count' => $disabledHousingTypes->count()],
                ['id' => 'inactive', 'text' => 'Pasif İlanlar', 'count' => $inactiveHousingTypes->count()],
                ['id' => 'soldHousingTypes', 'text' => 'Satılan İlanlar', 'count' => $soldHousingTypes->count()]
                ] as $tab)
                    <li class="tab-item {{ $tab['active'] ?? false ? 'active' : '' }}" 
                        id="{{ $tab['id'] }}-tab">
                        {{ $tab['text'] }} ({{ $tab['count'] }})

                    </li>
                @endforeach
            </ul>
        </div>
        <div class="tab-content">
            @foreach ([
                'active' => $activeHousingTypes,
                'pendingHousingTypes' => $pendingHousingTypes,
                'disabledHousingTypes' => $disabledHousingTypes,
                'inactive' => $inactiveHousingTypes,
                'soldHousingTypes' => $soldHousingTypes
            ] as $tabId => $housingTypes)
                <div class="tab-pane {{ $loop->first ? 'show active' : '' }}" id="{{ $tabId }}">
                    @if ($housingTypes->isEmpty())
                        <div class="project-table-content">
                            <p class="text-center mb-0">İlan bulunamadı</p>
                        </div>
                    @else
                        <div class="project-table">
                            @foreach ($housingTypes as $index => $housingType)
                                <div class="project-table-content">
                                    <ul class="list-unstyled d-flex housing-item">
                                        <!-- Index -->
                                        <li style="width: 5%">{{ $index + 1 }}</li>
                                        <li style="width: 5%">{{ $housingType->id + 2000000 }}</li>

                                        <!-- Housing Title -->
                                        <li style="width: 45%">
                                            <div>
                                                <p class="project-table-content-title">{{ $housingType->housing_title }}</p>
                                            </div>
                                        </li>

                                        <!-- Housing Type -->
                                        <li style="width: 10%">
                                            <div>
                                                <p class="project-table-content-title">{{ $housingType->housing_type }}</p>
                                            </div>
                                        </li>

                                        <!-- Consultant or User -->
                                        <li style="width: 10%">
                                            <div>
                                                <p class="project-table-content-title">
                                                    @if (!empty($housingType->consultant) && !empty($housingType->consultant->name))
                                                        {{ $housingType->consultant->name }}
                                                    @elseif (!empty($housingType->user) && !empty($housingType->user->name))
                                                        {{ $housingType->user->name }}
                                                    @else
                                                        Mağaza Yöneticisi
                                                    @endif
                                                </p>
                                            </div>
                                        </li>

                                        <!-- Created At -->
                                        <li style="width: 10%">
                                            <div>
                                                <p class="project-table-content-title">
                                                    {{ \Carbon\Carbon::parse($housingType->created_at)->format('d.m.Y H:i') }}
                                                </p>
                                            </div>
                                        </li>

                                        <!-- Status -->
                                        <li style="width: 10%">
                                            <div>
                                                <p class="project-table-content-title">
                                                    @php
                                                        $status = $housingType->status;
                                                        switch ($status) {
                                                            case 1:
                                                                $badge = '<span class="badge badge-success">Aktif</span>';
                                                                break;
                                                            case 2:
                                                                $badge = '<span class="badge badge-warning">Onay Bekleniyor</span>';
                                                                break;
                                                            case 3:
                                                                $badge = '<span class="badge badge-danger">Yönetim Tarafından Reddedildi</span>';
                                                                break;
                                                            default:
                                                                $badge = '<span class="badge badge-danger">Pasif</span>';
                                                                break;
                                                        }
                                                    @endphp
                                                    {!! $badge !!}
                                                </p>
                                            </div>
                                        </li>

                                        <!-- Actions -->
                                        <li style="width: 5%">
                                            <span class="project-table-content-actions-button" data-toggle="popover-{{ $housingType->id }}">
                                                <i class="fa fa-chevron-down"></i>
                                            </span>
                                        </li>
                                    </ul>

                                    <!-- Popover Actions -->
                                    <div class="popover-project-actions d-none" id="popover-{{ $housingType->id }}">
                                        <ul class="list-unstyled">
                                            @if (in_array('UpdateHousing', $userPermissions))
                                                <li>
                                                    <a href="{{ route('institutional.housing.edit', ['id' => $housingType->id]) }}">İlanı Düzenle</a>
                                                </li>
                                            @endif

                                            @if (in_array('UpdateHousing', $userPermissions))
                                                <li>
                                                    <a href="{{ route('institutional.housing.images.update', ['id' => $housingType->id]) }}">Resimleri Güncelle</a>
                                                </li>
                                            @endif
                                            <li>
                                                <a href="{{ route('institutional.bids.index', ['id' => $housingType->id]) }}">Pazarlık Teklifleri</a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#housingTabs .tab-item').on('click', function() {
                var targetId = $(this).attr('id').replace('-tab', '');
                
                // Remove active class from all tabs
                $('#housingTabs .tab-item').removeClass('active');
                
                // Add active class to the clicked tab
                $(this).addClass('active');

                // Hide all tab panes
                $('.tab-pane').removeClass('show active');

                // Show the corresponding tab pane
                $('#' + targetId).addClass('show active');
            });

            $('.project-table-content-actions-button').on('click', function() {
                var targetId = $(this).data('toggle');
                var $popover = $('#' + targetId);

                console.log("sas");

                // Hide other popovers
                $('.popover-project-actions').not($popover).addClass('d-none');

                // Toggle current popover
                $popover.toggleClass('d-none');
            });

            // Close popover when clicking outside
            $(document).on('click', function(event) {
                if (!$(event.target).closest('.project-table-content').length) {
                    $('.popover-project-actions').addClass('d-none');
                }
            });
        });


          // Search functionality
          $('#searchInput').on('input', function() {
            var query = $(this).val().toLowerCase();
            $('.tab-pane').each(function() {
                var $tabPane = $(this);
                $tabPane.find('.housing-item').each(function() {
                    var $item = $(this);
                    var text = $item.text().toLowerCase();
                    if (text.indexOf(query) > -1) {
                        $item.show();
                    } else {
                        $item.hide();
                    }
                });
            });
        });
    </script>
@endsection

<style>
    #housingTabs {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    #housingTabs .tab-item {
        display: inline-block;
        padding: 10px 20px;
        margin-right: 5px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    #housingTabs .tab-item.active {
        background-color: #007bff;
        color: #fff;
    }

    #housingTabs .tab-item:not(.active):hover {
        background-color: #f1f1f1;
    }

    .tab-pane {
        display: none;
    }

    .tab-pane.show {
        display: block;
    }

    .popover-project-actions {
        position: absolute;
        background: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        z-index: 1000;
        padding: 10px;
        width: 200px;
    }

    .modal-dialog {
        max-width: 500px;
    }
</style>
