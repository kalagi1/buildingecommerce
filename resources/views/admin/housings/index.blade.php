
@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Emlak İlanları</h2>
        <div class="card shadow-none border border-300 my-4">
            <ul class="nav nav-tabs px-4 mt-3 mb-3" id="housingTabs">
                <li class="nav-item">
                    <a class="nav-link active" id="active-tab" data-bs-toggle="tab" href="#active">Aktif İlanlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="inactive-tab" data-bs-toggle="tab" href="#inactive">Pasif İlanlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="deletedHousings-tab" data-bs-toggle="tab" href="#deletedHousings">Silinen İlanlar</a>
                </li>
            </ul>
            <div class="tab-content px-4 pb-4">
                <div class="tab-pane fade show active" id="active">
                    @include('admin.housings.housing_table', ['tableId' => 'bulk-select-body-active', 'housingTypes' => $activeHousingTypes])
                </div>
                <div class="tab-pane fade" id="inactive">
                    @include('admin.housings.housing_table', ['tableId' => 'bulk-select-body-inactive', 'housingTypes' => $inactiveHousingTypes])
                </div>
                <div class="tab-pane fade" id="deletedHousings">
                    @include('admin.housings.housing_table_delete', ['tableId' => 'bulk-select-body-deletedHousings', 'housingTypes' => $deletedHousings])
                </div>
            </div>
        </div>
      
    </div>
@endsection

@section('scripts')
    <script>
        var activeHousingTypes = @json($activeHousingTypes);
        var inactiveHousingTypes = @json($inactiveHousingTypes);
        var deletedHousings = @json($deletedHousings);

        function createTable(tbody, housingTypes) {
            housingTypes.forEach(function(housingType) {
            var row = document.createElement("tr");

            var idCell = document.createElement("td");
            idCell.className = "align-middle id";
            idCell.textContent = housingType.id + 2000000;

            var housingTitleCell = document.createElement("td");
            housingTitleCell.className = "align-middle housing_title";
            housingTitleCell.innerHTML = housingType.housing_title +
                    "<br><span style='color:black;font-size:11px !important;font-weight:700'>" + housingType.city
                    .title + " / " +
                    housingType.county.title + (housingType.neighborhood ? " / " + housingType.neighborhood
                        .mahalle_title : "") +
                    "</span>";

            var housingTypeCell = document.createElement("td");
            housingTypeCell.className = "align-middle housing_type";
            housingTypeCell.textContent = housingType.housing_type;

            var statusCell = document.createElement("td");
            statusCell.className = "align-middle status";
            statusCell.innerHTML = housingType.status == 1 ? '<span class="badge badge-phoenix badge-phoenix-success">Aktif</span>' :
                housingType.status == 2 ? '<span class="badge badge-phoenix badge-phoenix-warning">Admin Onayı Bekliyor</span>' : housingType
                .status == 3 ? '<span class="badge badge-phoenix badge-phoenix-danger">Admin Tarafından Reddedildi</span>' :
                '<span class="badge badge-phoenix badge-phoenix-danger">Pasif</span>';

            var createdAtCell = document.createElement("td");
            createdAtCell.className = "align-middle created_at";
            createdAtCell.textContent = new Date(housingType.created_at).toLocaleDateString();

            var actionsCell = document.createElement("td");
            actionsCell.className = "align-middle white-space-nowrap     pe-0";
            var exportLink = document.createElement("a");
            exportLink.className = "badge badge-phoenix badge-phoenix-primary";
            exportLink.href = "{{ URL::to('/') }}/admin/housings/" + housingType.id + '/detail';
            exportLink.textContent = "Görüntüle";
            var viewLink = document.createElement("a");
            viewLink.className = "badge badge-phoenix badge-phoenix-warning ml-2 mr-2";
            viewLink.href = "{{ URL::to('/') }}/admin/housings/" + housingType.id + '/logs';
            viewLink.textContent = "Loglar";
            actionsCell.appendChild(exportLink);
            actionsCell.appendChild(viewLink);


            row.appendChild(idCell);
            row.appendChild(housingTitleCell);
            row.appendChild(housingTypeCell);
            row.appendChild(statusCell);
            row.appendChild(createdAtCell);
            if (housingType.deleted_at == null) {
                row.appendChild(actionsCell);

            }


            tbody.appendChild(row);
        });
        }

        createTable(document.getElementById("bulk-select-body-active"), activeHousingTypes);
        createTable(document.getElementById("bulk-select-body-inactive"), inactiveHousingTypes);
        createTable(document.getElementById("bulk-select-body-deletedHousings"), deletedHousings);


        // Handle tab switching
        var housingTabs = new bootstrap.Tab(document.getElementById('active-tab'));
        housingTabs.show();
    </script>

    <!-- Your existing styles -->
    <style>
        .nav-tabs .nav-link{
            color:black !important;
        }
        .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link{
            color:red !important;
        }
        .ml-2 {
            margin-left: 20px;
        }

        .mr-2 {
            margin-right: 20px;
        }
    </style>
@endsection
