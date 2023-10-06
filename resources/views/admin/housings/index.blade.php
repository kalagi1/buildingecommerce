@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Konutlar</h2>
        <div class="mt-4">
            <div class="row g-4">
                <div class="col-12 col-xl-12  order-1 order-xl-0">
                    <div class="mb-9">
                        <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                            <div class="card-body p-0">
                                <div class="p-4 code-to-copy">
                                    <div class="d-flex align-items-center justify-content-end my-3">
                                        <div id="bulk-select-replace-element"><a href="{{ route('admin.housings.create') }}"
                                                class="btn btn-phoenix-success btn-sm" type="button"><span
                                                    class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span><span
                                                    class="ms-1">Yeni</span></a></div>

                                    </div>
                                    <div id="tableExample"
                                        data-list='{"valueNames":["name","email","age"],"page":10,"pagination":true}'>
                                        <div class="table-responsive mx-n1 px-1">
                                            <table class="table table-sm border-top border-200 fs--1 mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Başlık</th>
                                                        <th>Daire Türü</th>
                                                        <th>Statü</th>
                                                        <th>Oluşturulma Tarihi</th>
                                                        <th style="width: 50px">İşlemler</th>
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
            statusCell.innerHTML = housingType.status == 1 ? '<span class="btn btn-success">Aktif</span>' : housingType.status == 2 ? '<span class="btn btn-warning">Admin Onayı Bekliyor</span>' : housingType.status == 3 ? '<span class="btn btn-danger">Admin Tarafından Reddedildi</span>' : '<span class="btn btn-danger">Pasif</span>';

            var createdAtCell = document.createElement("td");
            createdAtCell.className = "align-middle created_at";
            createdAtCell.textContent = new Date(housingType.created_at).toLocaleDateString();

            var actionsCell = document.createElement("td");
            actionsCell.className = "align-middle white-space-nowrap     pe-0";
            var exportLink = document.createElement("a");
            exportLink.className = "btn btn-info";
            exportLink.href = "{{URL::to('/')}}/admin/housings/"+housingType.id+'/detail';
            exportLink.textContent = "Görüntüle";
            var viewLink = document.createElement("a");
            viewLink.className = "btn btn-warning ml-2 mr-2";
            viewLink.href = "{{URL::to('/')}}/admin/housings/"+housingType.id+'/logs';
            viewLink.textContent = "Loglar";
            actionsCell.appendChild(exportLink);
            actionsCell.appendChild(viewLink);


            row.appendChild(idCell);
            row.appendChild(housingTitleCell);
            row.appendChild(housingTypeCell);
            row.appendChild(statusCell);
            row.appendChild(createdAtCell);
            row.appendChild(actionsCell);


            tbody.appendChild(row);
        });
    </script>

    <style>
        .ml-2 {
            margin-left: 20px;
        }
        .mr-2 {
            margin-right: 20px;
        }
    </style>
@endsection
