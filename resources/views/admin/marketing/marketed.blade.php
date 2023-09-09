@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Marketed</h2>
        <div class="mt-4">
            <div class="row g-4">
                <div class="col-12 col-xl-10 order-1 order-xl-0">
                    <div class="mb-9">
                        <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                            <div class="card-body p-0">
                                <div class="p-4 code-to-copy">
                                    <div class="d-flex align-items-center justify-content-end my-3">
                                        <div id="bulk-select-replace-element"><a href="{{ route('admin.housings.create') }}"
                                                class="btn btn-phoenix-success btn-sm" type="button"><span
                                                    class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span><span
                                                    class="ms-1">New</span></a></div>
                                        <div class="d-none ms-3" id="bulk-select-actions">
                                            <div class="d-flex"><select class="form-select form-select-sm"
                                                    aria-label="Bulk actions">
                                                    <option selected="selected">Bulk actions</option>
                                                    <option value="Delete">Delete</option>
                                                    <option value="Archive">Archive</option>
                                                </select><button class="btn btn-phoenix-danger btn-sm ms-2"
                                                    type="button">Apply</button></div>
                                        </div>
                                    </div>
                                    <div id="tableExample"
                                        data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
                                        <div class="table-responsive mx-n1 px-1">
                                            <table class="table table-sm border-top border-200 fs--1 mb-0">
                                                <thead>
                                                    <tr>
                                              
                                                        <th>Title</th>
                                                        <th>Sort Order</th>
                                                        <th>Date Start</th>
                                                        <th>Date End</th>
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
        var marketedProjects = @json($marketedProjects);

        var tbody = document.getElementById("bulk-select-body");
        marketedProjects.forEach(function(mp) {
            var row = document.createElement("tr");



            var titleCell = document.createElement("td");
            titleCell.className = "align-middle ps-3 ";
            titleCell.textContent = mp.project_title;

            var orderCell = document.createElement("td");
            orderCell.className = "align-middle ";
            orderCell.textContent = mp.sort_order;

            var dateStartCell = document.createElement("td");
            dateStartCell.className = "align-middle ";
            dateStartCell.textContent = new Date(mp.date_start).toLocaleDateString();

            var dateEndCell = document.createElement("td");
            dateEndCell.className = "align-middle ";
            dateEndCell.textContent = new Date(mp.date_end).toLocaleDateString();

            row.appendChild(titleCell);
            row.appendChild(orderCell);
            row.appendChild(dateStartCell);
            row.appendChild(dateEndCell);


            tbody.appendChild(row);
        });
    </script>
@endsection
