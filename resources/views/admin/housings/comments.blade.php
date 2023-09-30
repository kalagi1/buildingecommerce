@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Konut Yorumları</h2>
        <div class="mt-4">
            <div class="row g-4">
                <div class="col-12 col-xl-12  order-1 order-xl-0">
                    <div class="mb-9">
                        <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                            <div class="card-body p-0">
                                <div class="p-4 code-to-copy">
                                    <div id="tableExample"
                                        data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
                                        <div class="table-responsive mx-n1 px-1">
                                            <table class="table table-sm border-top border-200 fs--1 mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Yorum Sahibi</th>
                                                        <th>Konut No.</th>
                                                        <th>Yorum</th>
                                                        <th>Oy</th>
                                                        <th>Resimler</th>
                                                        <th>Oluşturulma Tarihi</th>
                                                        <th>Durum</th>
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

            var housingUserCell = document.createElement("td");
            housingUserCell.className = "align-middle ps-3 housing_title";
            housingUserCell.textContent = housingType.user_id;

            var housingCell = document.createElement("td");
            housingCell.className = "align-middle housing_type";
            housingCell.textContent = housingType.housing_id;
            
            var housingCommentCell = document.createElement("td");
            housingCommentCell.className = "align-middle housing_type";
            housingCommentCell.textContent = housingType.comment;

            var housingRateCell = document.createElement("td");
            housingRateCell.className = "align-middle housing_type";
            housingRateCell.textContent = housingType.rate + " Yıldız";

            var housingImagesCell = document.createElement("td");
            housingImagesCell.className = "align-middle housing_type";

            var housingApproveCell = document.createElement("td");
            housingApproveCell.className = "align-middle";
            housingApproveCell.innerHTML = housingType.status ? `<a class="btn btn-danger" href="comment/unapprove/${housingType.id}">Onayı Kaldır</a>` : `<a class="btn btn-primary" href="comment/approve/${housingType.id}">Onayla</a>`;

            JSON.parse(housingType.images).map(e =>
            {
                housingImagesCell.innerHTML += `<img src="{{asset('storage')}}/${e.replace(/^public\//, "")}" width="156px" height="128px" class="d-block"/>`;
            })

            var createdAtCell = document.createElement("td");
            createdAtCell.className = "align-middle created_at";
            createdAtCell.textContent = new Date(housingType.created_at).toLocaleDateString();


            row.appendChild(idCell);
            row.appendChild(housingUserCell);
            row.appendChild(housingCell);
            row.appendChild(housingCommentCell);
            row.appendChild(housingRateCell);
            row.appendChild(housingImagesCell);
            row.appendChild(createdAtCell);
            row.appendChild(housingApproveCell);


            tbody.appendChild(row);
        });
    </script>
@endsection
