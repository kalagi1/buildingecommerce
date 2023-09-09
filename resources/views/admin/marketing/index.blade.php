@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Project Marketing</h2>
        <div class="mt-4">
            <div class="row g-4">
                <div class="col-12 col-xl-10 order-1 order-xl-0">
                    <div class="mb-6">
                        <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                            <div class="card-body p-4">

                                <form class="row g-3 needs-validation" novalidate="" method="POST"
                                    action="{{ route('admin.marketing.projects.setmarketed') }}">
                                    @csrf


                                    <div class="col-md-4">
                                        <label class="form-label" for="projects">Projects</label>
                                        <select name="project_id" class="form-select" id="validationCustom04"
                                            required="">
                                            <option selected disabled>Seç...</option>
                                            @foreach ($projects as $item)
                                                <option value="{{ $item->id }}">{{ $item->project_title }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="sort_order">Sort Order</label>
                                        <select name="sort_order" class="form-select" id="sort_order" required="">
                                            <option selected disabled>Seç...</option>
                                            @foreach ($avaliableMarketings as $item)
                                                <option value="{{ $item->sort_order }}">Order:{{ $item->sort_order }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="months">Months</label>
                                        <input name="months" class="form-control" id="months" type="text"
                                            value="" required="">
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>


                                    <div class="col-12">
                                        <button class="btn btn-primary" type="submit">Kaydet</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-10 order-1 order-xl-0">
                    <div class="mb-9">
                        <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                            <div class="card-body p-0">
                                <div class="p-4 code-to-copy">
                                    <form action="{{ route('admin.marketing.projects.store') }}" method="POST">
                                        @csrf
                                        <div class="d-flex align-items-center justify-content-end my-3 row">

                                            <div class="col-md-4">
                                                <label class="form-label" for="sort_order">Sort Order</label>
                                                <input name="sort_order" class="form-control" id="sort_order" type="text"
                                                    value="" required="">
                                                <div class="valid-feedback">Looks good!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="price">Price</label>
                                                <input name="price" class="form-control" id="price" type="text"
                                                    value="" required="">
                                                <div class="valid-feedback">Looks good!</div>
                                            </div>

                                            <div class="col-md-4">

                                                <button class="btn btn-phoenix-success btn-sm" type="submit">
                                                    <span class="fas fa-save" data-fa-transform="shrink-3 down-2"></span>
                                                    <span class="ms-1">Save</span>
                                                </button>
                                            </div>


                                        </div>
                                    </form>
                                    <div id="tableExample"
                                        data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
                                        <div class="table-responsive mx-n1 px-1">
                                            <table class="table table-sm border-top border-200 fs--1 mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Sort Order</th>
                                                        <th>Price</th>
                                                        <th>Status</th>
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
        var marketings = @json($marketings);

        var tbody = document.getElementById("bulk-select-body");
        marketings.forEach(function(marketing) {
            var row = document.createElement("tr");

            var orderCell = document.createElement("td");
            orderCell.className = "align-middle ps-6 order";
            orderCell.textContent = marketing.sort_order;

            var priceCell = document.createElement("td");
            priceCell.className = "align-middle price";
            priceCell.textContent = marketing.price;

            var statusCell = document.createElement("td");
            statusCell.className = "align-middle status";
            statusCell.textContent = !parseInt(marketing.status) ? 'Avaliable' : 'Not Avaliable';

            row.appendChild(orderCell);
            row.appendChild(priceCell);
            row.appendChild(statusCell);

            tbody.appendChild(row);
        });
    </script>
@endsection
