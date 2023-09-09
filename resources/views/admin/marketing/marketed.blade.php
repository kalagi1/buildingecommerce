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
                                                        <th class="white-space-nowrap fs--1 align-middle ps-0"
                                                            style="max-width:20px; width:18px;">
                                                            <div class="form-check mb-0 fs-0"><input
                                                                    class="form-check-input" id="bulk-select-example"
                                                                    type="checkbox"
                                                                    data-bulk-select='{"body":"bulk-select-body","actions":"bulk-select-actions","replacedElement":"bulk-select-replace-element"}' />
                                                            </div>
                                                        </th>
                                                        <th>Title</th>
                                                        <th>Sort Order</th>
                                                        <th>Date Start</th>
                                                        <th>Date End</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list" id="bulk-select-body"></tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex flex-between-center pt-3 mb-3">
                                            <div class="pagination d-none"></div>
                                            <p class="mb-0 fs--1">
                                                <span class="d-none d-sm-inline-block"
                                                    data-list-info="data-list-info"></span>
                                                <span class="d-none d-sm-inline-block"> &mdash; </span>
                                                <a class="fw-semi-bold" href="#!" data-list-view="*">
                                                    View all
                                                    <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                                </a><a class="fw-semi-bold d-none" href="#!" data-list-view="less">
                                                    View Less
                                                    <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                                </a>
                                            </p>
                                            <div class="d-flex">
                                                <button class="btn btn-sm btn-primary" type="button"
                                                    data-list-pagination="prev"><span>Previous</span></button>
                                                <button class="btn btn-sm btn-primary px-4 ms-2" type="button"
                                                    data-list-pagination="next"><span>Next</span></button>
                                            </div>
                                        </div>
                                        <p class="mb-2">Click the button to get selected rows</p><button
                                            class="btn btn-warning" data-selected-rows="data-selected-rows">Get Selected
                                            Rows</button>
                                        <pre id="selectedRows"></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-2">
                    <div class="position-sticky mt-xl-4" style="top: 80px;">
                        <h5 class="lh-1">On this page </h5>
                        <hr class="text-300" />
                        <ul class="nav nav-vertical flex-column doc-nav" data-doc-nav="data-doc-nav">
                            <li class="nav-item"> <a class="nav-link" href="#docs">Docs</a></li>
                            <li class="nav-item"> <a class="nav-link" href="#example">Example</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
            <div class="toast align-items-center text-white bg-dark border-0 light" id="icon-copied-toast" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body p-3"></div><button class="btn-close btn-close-white me-2 m-auto" type="button"
                        data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <footer class="footer position-absolute">
            <div class="row g-0 justify-content-between align-items-center h-100">
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 mt-2 mt-sm-0 text-900">Thank you for creating with Phoenix<span
                            class="d-none d-sm-inline-block"></span><span class="d-none d-sm-inline-block mx-1">|</span><br
                            class="d-sm-none" />2023 &copy;<a class="mx-1"
                            href="https://themewagon.com/">Themewagon</a>
                    </p>
                </div>
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 text-600">v1.13.0</p>
                </div>
            </div>
        </footer>
    </div>
@endsection

@section('scripts')
    <script>
        var marketedProjects = @json($marketedProjects);

        var tbody = document.getElementById("bulk-select-body");
        marketedProjects.forEach(function(mp) {
            var row = document.createElement("tr");

            var checkboxCell = document.createElement("td");
            var checkboxDiv = document.createElement("div");
            checkboxDiv.className = "form-check mb-0 fs-0";
            var checkboxInput = document.createElement("input");
            checkboxInput.className = "form-check-input";
            checkboxInput.type = "checkbox";
            checkboxInput.setAttribute("data-bulk-select-row", JSON.stringify(mp));
            checkboxDiv.appendChild(checkboxInput);
            checkboxCell.appendChild(checkboxDiv);

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

            row.appendChild(checkboxCell);
            row.appendChild(titleCell);
            row.appendChild(orderCell);
            row.appendChild(dateStartCell);
            row.appendChild(dateEndCell);


            tbody.appendChild(row);
        });
    </script>
@endsection
