@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Konut Tipleri</h2>
        <div class="mt-4">
            <div class="row g-4">
                <div class="col-12 col-xl-12  order-1 order-xl-0">
                    <div class="mb-9">
                        <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                            <div class="card-body p-0">
                                <div class="p-4 code-to-copy">
                                    <div class="d-flex align-items-center justify-content-end my-3">
                                        <div id="bulk-select-replace-element"><button class="btn btn-phoenix-success btn-sm"
                                                type="button"><span class="fas fa-plus"
                                                    data-fa-transform="shrink-3 down-2"></span><span
                                                    class="ms-1">New</span></button></div>
                                    </div>
                                    <div id="tableExample"
                                        data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
                                        <div class="table-responsive mx-n1 px-1">
                                            <table class="table table-sm border-top border-200 fs--1 mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="white-space-nowrap fs--1 align-middle ps-0"
                                                            style="max-width:20px; width:18px;">
                                                            <div class="form-check mb-0 fs-0"><input
                                                                    class="form-check-input" id="bulk-select-example"
                                                                    type="checkbox"
                                                                    data-bulk-select='{"body":"bulk-select-body","actions":"bulk-select-actions","replacedElement":"bulk-select-replace-element"}' />
                                                            </div>
                                                        </th>
                                                        <th>Başlık</th>
                                                        <th>Statü</th>
                                                        <th>Anasayfa'da Gözüksün</th>
                                                        <th>Anasayfa'da Gözükme Sırası</th>
                                                        <th>İşlemler</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list" id="bulk-select-body"></tbody>
                                            </table>
                                        </div>
                                        <div
                                            class="d-flex flex-wrap align-items-center justify-content-between py-3 pe-0 fs--1 border-bottom border-200">
                                            <div class="d-flex">
                                                <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900"
                                                    data-list-info="data-list-info"></p>
                                            </div>
                                            <div class="d-flex"><button class="page-link" data-list-pagination="prev"><span
                                                        class="fas fa-chevron-left"></span></button>
                                                <ul class="mb-0 pagination"></ul><button class="page-link pe-0"
                                                    data-list-pagination="next"><span
                                                        class="fas fa-chevron-right"></span></button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        var housingStatuses = @json($housingStatuses);

        var tbody = document.getElementById("bulk-select-body");
        housingStatuses.forEach(function(housingStatus) {
            var row = document.createElement("tr");

            var checkboxCell = document.createElement("td");
            var checkboxDiv = document.createElement("div");
            checkboxDiv.className = "form-check mb-0 fs-0";
            var checkboxInput = document.createElement("input");
            checkboxInput.className = "form-check-input";
            checkboxInput.type = "checkbox";
            checkboxInput.setAttribute("data-bulk-select-row", JSON.stringify(housingStatus));
            checkboxDiv.appendChild(checkboxInput);
            checkboxCell.appendChild(checkboxDiv);

            var titleCell = document.createElement("td");
            titleCell.className = "align-middle ps-3 name";
            titleCell.textContent = housingStatus.name;

            var activeCell = document.createElement("td");
            activeCell.className = "align-middle status";
            activeCell.innerHTML = housingStatus.status == 1 ? "<span class='btn btn-success'>Aktif</span>" : "<span class='btn btn-danger'>Pasif</span>";

            var dashboarsShowCell = document.createElement("td");
            dashboarsShowCell.className = "align-middle status";
            dashboarsShowCell.innerHTML = housingStatus.in_dashboard == 1 ? "<span class='btn btn-success'><i class='fa fa-check'></i></span>" : "<span class='btn btn-danger'><i class='fa fa-times'></i></span>";
            
            var dashboarsOrderCell = document.createElement("td");
            dashboarsOrderCell.className = "align-middle status";
            dashboarsOrderCell.innerHTML = housingStatus.in_dashboard == 1 ? "<span class='btn btn-info'>"+(housingStatus.dashboard_order)+"</span>" : "-";

            var actionsCell = document.createElement("td");
            actionsCell.className = "align-middle white-space-nowrap     pe-0";
            var actionsDiv = document.createElement("div");
            actionsDiv.className = "font-sans-serif btn-reveal-trigger position-static";
            var actionsButton = document.createElement("button");
            actionsButton.className =
                "btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2";
            actionsButton.type = "button";
            actionsButton.setAttribute("data-bs-toggle", "dropdown");
            actionsButton.setAttribute("data-bs-boundary", "window");
            actionsButton.setAttribute("aria-haspopup", "true");
            actionsButton.setAttribute("aria-expanded", "false");
            actionsButton.setAttribute("data-bs-reference", "parent");
            var actionsIcon = document.createElement("span");
            actionsIcon.className = "fas fa-ellipsis-h fs--2";
            actionsButton.appendChild(actionsIcon);
            actionsDiv.appendChild(actionsButton);
            var dropdownMenu = document.createElement("div");
            dropdownMenu.className = "dropdown-menu dropdown-menu py-2";
            var viewLink = document.createElement("a");
            viewLink.className = "dropdown-item";
            viewLink.href = "#!";
            viewLink.textContent = "View";
            var exportLink = document.createElement("a");
            exportLink.className = "dropdown-item";
            exportLink.href = "{{URL::to('/')}}/admin/housing_status/"+housingStatus.id+'/edit';
            exportLink.textContent = "Düzenle";
            var divider = document.createElement("div");
            divider.className = "dropdown-divider";
            var removeLink = document.createElement("a");
            removeLink.className = "dropdown-item text-danger";
            removeLink.href = "#";
            removeLink.textContent = "Remove";
            dropdownMenu.appendChild(viewLink);
            dropdownMenu.appendChild(exportLink);
            dropdownMenu.appendChild(divider);
            dropdownMenu.appendChild(removeLink);
            actionsDiv.appendChild(dropdownMenu);
            actionsCell.appendChild(actionsDiv);

            row.appendChild(checkboxCell);
            row.appendChild(titleCell);
            row.appendChild(activeCell);
            row.appendChild(dashboarsShowCell);
            row.appendChild(dashboarsOrderCell);
            row.appendChild(actionsCell);

            tbody.appendChild(row);
        });
    </script>
@endsection
