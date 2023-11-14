@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div id="tableExample"
        data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
        <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white border-top border-bottom border-200 position-relative top-1">

            <div class="table-responsive scrollbar mx-n1 px-1">
                <table class="table fs--1 mb-0">
                    <tr>
                        <th>ID</th>
                        <th>Başlık</th>
                        <th>Daire Türü</th>
                        <th>Statü</th>
                        <th>Oluşturulma Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody class="list" id="bulk-select-body"></tbody>
                </table>
            </div>
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
@endsection

@section('scripts')
    <script>
        var housingTypes = @json($housing);
        var tbody = document.getElementById("bulk-select-body");
        housingTypes.forEach(function(housingType) {
            var row = document.createElement("tr");

            var idCell = document.createElement("td");
            idCell.className = "align-middle id";
            idCell.textContent = housingType.id;

            var housingTitleCell = document.createElement("td");
            housingTitleCell.className = "align-middle ps-3 housing_title";
            housingTitleCell.textContent = housingType.housing_title;

            var housingTypeCell = document.createElement("td");
            housingTypeCell.className = "align-middle housing_type";
            housingTypeCell.textContent = housingType.housing_type;

            var statusCell = document.createElement("td");
            statusCell.className = "align-middle status";
            statusCell.innerHTML = housingType.status == 1 ? '<span class="btn btn-success">Aktif</span>' :
                housingType.status == 2 ? '<span class="btn btn-warning">Admin Onayı Bekliyor</span>' : housingType
                .status == 3 ? '<span class="btn btn-danger">Admin Tarafından Reddedildi</span>' :
                '<span class="btn btn-danger">Pasif</span>';

            var createdAtCell = document.createElement("td");
            createdAtCell.className = "align-middle created_at";
            createdAtCell.textContent = new Date(housingType.created_at).toLocaleDateString();

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
            viewLink.href = "{{ URL::to('/') }}/institutional/housings/" + housingType.id + '/logs';
            viewLink.textContent = "Loglar";
            var exportLink = document.createElement("a");
            exportLink.className = "dropdown-item";
            exportLink.href = "{{ URL::to('/') }}/institutional/edit_housing/" + housingType.id;
            exportLink.textContent = "Düzenle";
            var divider = document.createElement("div");
            divider.className = "dropdown-divider";
            var removeLink = document.createElement("a");
            removeLink.className = "dropdown-item text-danger";
            removeLink.href = "#!";
            removeLink.textContent = "Sil";
            removeLink.setAttribute("data-project-id", housingType.id);
            dropdownMenu.appendChild(viewLink);
            dropdownMenu.appendChild(exportLink);
            dropdownMenu.appendChild(divider);
            dropdownMenu.appendChild(removeLink);
            actionsDiv.appendChild(dropdownMenu);
            actionsCell.appendChild(actionsDiv);

            row.appendChild(idCell);
            row.appendChild(housingTitleCell);
            row.appendChild(housingTypeCell);
            row.appendChild(statusCell);
            row.appendChild(createdAtCell);
            row.appendChild(actionsCell);


            tbody.appendChild(row);
        });
    </script>
@endsection
