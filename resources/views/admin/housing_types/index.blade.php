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
                                        <div id="bulk-select-replace-element">
                                            <a href="{{url('/1a2b3c4d5e6f/secured/housing_types/create')}}">
                                                <button class="btn btn-phoenix-success btn-sm"
                                                type="button"><span class="fas fa-plus"
                                                    data-fa-transform="shrink-3 down-2"></span><span class="ms-1">Yeni
                                                    Ekle</span></button>
                                            </a>
                                        </div>
                                    </div>
                                    <div id="tableExample"
                                        data-list='{"valueNames":["name","email","age"],"page":15,"pagination":true}'>
                                        <div class="table-responsive mx-n1 px-1">
                                            <table class="table table-sm border-top border-200 fs--1 mb-0">
                                                <thead>
                                                    <tr>
                                                        <th 
                                                            style="width:20px; width:18px;">
                                                            #
                                                        </th>
                                                        <th>Başlık</th>
                                                        <th>URL</th>
                                                        <th>Aktif/Pasif</th>
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
        var housingTypes = @json($housingTypes);

        var tbody = document.getElementById("bulk-select-body");
        housingTypes.forEach(function(housingType, key) {
            var row = document.createElement("tr");


            var checkboxCell = document.createElement("td");
            checkboxCell.className = "align-middle ps-3 name";
            checkboxCell.textContent = housingType.id;

            var titleCell = document.createElement("td");
            titleCell.className = "align-middle ps-3 name";
            titleCell.textContent = housingType.title;

            var slugCell = document.createElement("td");
            slugCell.className = "align-middle slug";
            slugCell.textContent = housingType.slug;

            var activeCell = document.createElement("td");
            activeCell.className = "align-middle active";
            activeCell.textContent = housingType.active;

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
            var dropdownMenu = document.createElement("div");
            dropdownMenu.className = "dropdown-menu dropdown-menu py-2";
            var exportLink = document.createElement("a");
            exportLink.className = "btn btn-warning";
            exportLink.href = "{{URL::to('/')}}/1a2b3c4d5e6f/secured/housing_types/"+housingType.id+'/edit';
            exportLink.textContent = "Düzenle";
            var divider = document.createElement("div");
            divider.className = "dropdown-divider";
       
            actionsDiv.appendChild(exportLink);
            actionsCell.appendChild(actionsDiv);

            row.appendChild(checkboxCell);
            row.appendChild(titleCell);
            row.appendChild(slugCell);
            row.appendChild(activeCell);
            row.appendChild(actionsCell);

            tbody.appendChild(row);
        });
    </script>
@endsection
