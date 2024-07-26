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
        <ul class="nav nav-tabs px-4 mt-3 mb-3" id="housingTabs">
            @foreach ([
                ['id' => 'active', 'text' => 'Aktif İlanlar', 'active' => true],
                ['id' => 'pendingHousingTypes', 'text' => 'Onay Bekleyen İlanlar'],
                ['id' => 'disabledHousingTypes', 'text' => 'Reddedilen İlanlar'],
                ['id' => 'inactive', 'text' => 'Pasif İlanlar'],
                ['id' => 'soldHousingTypes', 'text' => 'Satılan İlanlar']
            ] as $tab)
                <li class="nav-item">
                    <a class="nav-link {{ $tab['active'] ?? false ? 'active' : '' }}" 
                       id="{{ $tab['id'] }}-tab" 
                       data-bs-toggle="tab" 
                       href="#{{ $tab['id'] }}">
                        {{ $tab['text'] }}
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content px-4">
            @foreach ([
                'active' => $activeHousingTypes,
                'pendingHousingTypes' => $pendingHousingTypes,
                'disabledHousingTypes' => $disabledHousingTypes,
                'inactive' => $inactiveHousingTypes,
                'soldHousingTypes' => $soldHousingTypes
            ] as $tabId => $housingTypes)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $tabId }}">
                    @include('institutional.housings.housing_table', [
                        'tableId' => 'bulk-select-body-' . $tabId,
                        'housingTypes' => $housingTypes
                    ])
                </div>
            @endforeach
        </div>
    </section>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        var activeHousingTypes = @json($activeHousingTypes);
        var inactiveHousingTypes = @json($inactiveHousingTypes);
        var pendingHousingTypes = @json($pendingHousingTypes);
        var disabledHousingTypes = @json($disabledHousingTypes);
        var soldHousingTypes = @json($soldHousingTypes);
        var userPermissions = @json($userPermissions);

        function createTable(tbody, housingTypes) {
            housingTypes.forEach(function(housingType, index) {
                var row = document.createElement("div");
                row.className = "project-table-content";

                var ul = document.createElement("ul");

                // Index
                var indexLi = document.createElement("li");
                indexLi.style.width = "5%";
                indexLi.textContent = index + 1;
                ul.appendChild(indexLi);

                // Housing Title
                var titleLi = document.createElement("li");
                titleLi.style.width = "90%";
                var titleDiv = document.createElement("div");
                var titleP = document.createElement("p");
                titleP.className = "project-table-content-title";
                titleP.textContent = housingType.housing_title;
                titleDiv.appendChild(titleP);
                titleLi.appendChild(titleDiv);
                ul.appendChild(titleLi);

                // Actions
                var actionsLi = document.createElement("li");
                actionsLi.style.width = "5%";
                var actionsButton = document.createElement("span");
                actionsButton.className = "project-table-content-actions-button";
                actionsButton.setAttribute("data-bs-toggle", "popover");
                actionsButton.setAttribute("data-bs-content", "#popover-" + housingType.id);
                actionsButton.innerHTML = '<i class="fa fa-chevron-down"></i>';
                actionsLi.appendChild(actionsButton);
                ul.appendChild(actionsLi);

                row.appendChild(ul);

                // Popover Actions
                var popoverDiv = document.createElement("div");
                popoverDiv.className = "popover-project-actions d-none";
                popoverDiv.id = "popover-" + housingType.id;

                var popoverUl = document.createElement("ul");

                if (userPermissions.includes('UpdateHousingType')) {
                    var editLi = document.createElement("li");
                    var editLink = document.createElement("a");
                    editLink.href = "{{ route('institutional.housing.edit', ['id' => ':id']) }}".replace(':id', housingType.id);
                    editLink.textContent = "Düzenle";
                    editLi.appendChild(editLink);
                    popoverUl.appendChild(editLi);
                }

                if (userPermissions.includes('ViewHousingType')) {
                    var previewLi = document.createElement("li");
                    var previewLink = document.createElement("a");
                    previewLink.href = "{{ route('institutional.housing.edit', ['id' => ':id']) }}".replace(':id', housingType.id);
                    previewLink.textContent = "Önizle";
                    previewLi.appendChild(previewLink);
                    popoverUl.appendChild(previewLi);
                }

                if (userPermissions.includes('DeleteHousingType')) {
                    var deleteLi = document.createElement("li");
                    var deleteLink = document.createElement("a");
                    deleteLink.setAttribute("data-bs-toggle", "modal");
                    deleteLink.setAttribute("data-bs-target", "#deleteModal-" + housingType.id);
                    deleteLink.textContent = "Sil";
                    deleteLi.appendChild(deleteLink);
                    popoverUl.appendChild(deleteLi);
                }

                popoverDiv.appendChild(popoverUl);
                row.appendChild(popoverDiv);

                // Delete Modal
                var deleteModalDiv = document.createElement("div");
                deleteModalDiv.className = "modal fade";
                deleteModalDiv.id = "deleteModal-" + housingType.id;
                deleteModalDiv.setAttribute("tabindex", "-1");
                deleteModalDiv.setAttribute("aria-labelledby", "deleteModalLabel-" + housingType.id);
                deleteModalDiv.setAttribute("aria-hidden", "true");

                var modalDialogDiv = document.createElement("div");
                modalDialogDiv.className = "modal-dialog";

                var modalContentDiv = document.createElement("div");
                modalContentDiv.className = "modal-content";

                var modalHeaderDiv = document.createElement("div");
                modalHeaderDiv.className = "modal-header";
                var modalTitleH5 = document.createElement("h5");
                modalTitleH5.className = "modal-title";
                modalTitleH5.id = "deleteModalLabel-" + housingType.id;
                modalTitleH5.textContent = "Sil";
                var closeButton = document.createElement("button");
                closeButton.type = "button";
                closeButton.className = "btn p-1";
                closeButton.setAttribute("data-bs-dismiss", "modal");
                closeButton.setAttribute("aria-label", "Close");
                closeButton.innerHTML = '<svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg>';
                modalHeaderDiv.appendChild(modalTitleH5);
                modalHeaderDiv.appendChild(closeButton);
                modalContentDiv.appendChild(modalHeaderDiv);

                var modalBodyDiv = document.createElement("div");
                modalBodyDiv.className = "modal-body";
                modalBodyDiv.innerHTML = '<p class="text-700 lh-lg mb-0">Bu ilanı silmek istediğinize emin misiniz?</p>';
                modalContentDiv.appendChild(modalBodyDiv);

                var modalFooterDiv = document.createElement("div");
                modalFooterDiv.className = "modal-footer";
                var cancelButton = document.createElement("button");
                cancelButton.type = "button";
                cancelButton.className = "btn btn-secondary";
                cancelButton.setAttribute("data-bs-dismiss", "modal");
                cancelButton.textContent = "Kapat";
                var deleteButton = document.createElement("button");
                deleteButton.type = "button";
                deleteButton.className = "btn btn-danger";
                deleteButton.setAttribute("data-housing-id", housingType.id);
                deleteButton.textContent = "Sil";
                modalFooterDiv.appendChild(cancelButton);
                modalFooterDiv.appendChild(deleteButton);
                modalContentDiv.appendChild(modalFooterDiv);

                modalDialogDiv.appendChild(modalContentDiv);
                deleteModalDiv.appendChild(modalDialogDiv);

                row.appendChild(deleteModalDiv);

                tbody.appendChild(row);
            });
        }

        window.onload = function() {
            createTable(document.querySelector('#bulk-select-body-active'), activeHousingTypes);
            createTable(document.querySelector('#bulk-select-body-pendingHousingTypes'), pendingHousingTypes);
            createTable(document.querySelector('#bulk-select-body-disabledHousingTypes'), disabledHousingTypes);
            createTable(document.querySelector('#bulk-select-body-inactive'), inactiveHousingTypes);
            createTable(document.querySelector('#bulk-select-body-soldHousingTypes'), soldHousingTypes);
        };
    </script>
@endsection
