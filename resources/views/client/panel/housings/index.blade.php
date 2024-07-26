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
                    ['id' => 'active', 'text' => 'Aktif İlanlar', 'active' => true],
                    ['id' => 'pendingHousingTypes', 'text' => 'Onay Bekleyen İlanlar'],
                    ['id' => 'disabledHousingTypes', 'text' => 'Reddedilen İlanlar'],
                    ['id' => 'inactive', 'text' => 'Pasif İlanlar'],
                    ['id' => 'soldHousingTypes', 'text' => 'Satılan İlanlar']
                ] as $tab)
                    <li class="tab-item {{ $tab['active'] ?? false ? 'active' : '' }}" 
                        id="{{ $tab['id'] }}-tab">
                        {{ $tab['text'] }}
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
                        <p class="text-center">İlan bulunamadı</p>
                    </div>
                    
                    @else
                        <div class="project-table">
                            @foreach ($housingTypes as $index => $housingType)
                                <div class="project-table-content">
                                    <ul class="list-unstyled d-flex">
                                        <!-- Index -->
                                        <li style="width: 5%">{{ $index + 1 }}</li>

                                        <!-- Housing Title -->
                                        <li style="width: 90%">
                                            <div>
                                                <p class="project-table-content-title">{{ $housingType->housing_title }}</p>
                                            </div>
                                        </li>

                                        <!-- Actions -->
                                        <li style="width: 5%">
                                            <span class="project-table-content-actions-button" data-bs-toggle="popover" data-bs-content="#popover-{{ $housingType->id }}">
                                                <i class="fa fa-chevron-down"></i>
                                            </span>
                                        </li>
                                    </ul>

                                    <!-- Popover Actions -->
                                    <div class="popover-project-actions d-none" id="popover-{{ $housingType->id }}">
                                        <ul class="list-unstyled">
                                            @if (in_array('UpdateHousing', $userPermissions))
                                                <li>
                                                    <a href="{{ route('institutional.housing.edit', ['id' => $housingType->id]) }}">Düzenle</a>
                                                </li>
                                            @endif

                                            @if (in_array('ViewHousing', $userPermissions))
                                                <li>
                                                    <a href="{{ route('institutional.housing.edit', ['id' => $housingType->id]) }}">Önizle</a>
                                                </li>
                                            @endif

                                            @if (in_array('DeleteHousing', $userPermissions))
                                                <li>
                                                    <a data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $housingType->id }}">Sil</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>

                                    <!-- Delete Modal -->
                                    @if (in_array('DeleteHousing', $userPermissions))
                                        <div class="modal fade" id="deleteModal-{{ $housingType->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $housingType->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel-{{ $housingType->id }}">Sil</h5>
                                                        <button type="button" class="btn p-1" data-bs-dismiss="modal" aria-label="Close">
                                                            <svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                                <path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-700 lh-lg mb-0">Bu ilanı silmek istediğinize emin misiniz?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                                        <button type="button" class="btn btn-danger" data-housing-id="{{ $housingType->id }}">Sil</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
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
                $('.tab-pane').removeClass('show').removeClass('active');

                // Show the corresponding tab pane
                $('#' + targetId).addClass('show').addClass('active');
            });

            $('.project-table-content-actions-button').on('click', function() {
                var targetId = $(this).data('bs-content');
                var $popover = $('#' + targetId);

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
