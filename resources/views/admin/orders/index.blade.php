@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="mb-9">
            <div class="row g-3 mb-4">
                <div class="col-auto">
                    <h2 class="mb-0">Siparişler</h2>
                </div>
            </div>
            <div id="orderTable"
                data-list='{"valueNames":["order","total","customer","payment_status","fulfilment_status","delivery_type","date"],"page":10,"pagination":true}'>
                <div class="mb-4">
                    <div class="row g-3">
                        <div class="col-auto">
                            <div class="search-box">
                                <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input
                                        class="form-control search-input search" type="search" placeholder="Search orders"
                                        aria-label="Search" />
                                    <span class="fas fa-search search-box-icon"></span>
                                </form>
                            </div>
                        </div>
                        <div class="col-auto scrollbar overflow-hidden-y flex-grow-1">
                            <div class="btn-group position-static" role="group">
                                <div class="btn-group position-static text-nowrap" role="group"><button
                                        class="btn btn-phoenix-secondary px-7 flex-shrink-0" type="button"
                                        data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                        aria-expanded="false" data-bs-reference="parent"> Payment status<span
                                            class="fas fa-angle-down ms-2"></span></button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                        <li>
                                            <hr class="dropdown-divider" />
                                        </li>
                                        <li><a class="dropdown-item" href="#">Separated link</a></li>
                                    </ul>
                                </div>
                                <div class="btn-group position-static text-nowrap" role="group"><button
                                        class="btn btn-sm btn-phoenix-secondary px-7 flex-shrink-0" type="button"
                                        data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                        aria-expanded="false" data-bs-reference="parent"> Fulfilment status<span
                                            class="fas fa-angle-down ms-2"></span></button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                        <li>
                                            <hr class="dropdown-divider" />
                                        </li>
                                        <li><a class="dropdown-item" href="#">Separated link</a></li>
                                    </ul>
                                </div><button class="btn btn-sm btn-phoenix-secondary px-7 flex-shrink-0">More filters
                                </button>
                            </div>
                        </div>
                        <div class="col-auto"><button class="btn btn-link text-900 me-4 px-0"><span
                                    class="fa-solid fa-file-export fs--1 me-2"></span>Export</button><button
                                class="btn btn-primary"><span class="fas fa-plus me-2"></span>Add order</button></div>
                    </div>
                </div>
                <div
                    class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white border-top border-bottom border-200 position-relative top-1">
                    <div class="table-responsive scrollbar mx-n1 px-1">
                        <table class="table table-sm fs--1 mb-0">
                            <thead>
                                <tr>
                                    <th class="white-space-nowrap fs--1 align-middle ps-0" style="width:26px;">
                                        <div class="form-check mb-0 fs-0"><input class="form-check-input"
                                                id="checkbox-bulk-order-select" type="checkbox"
                                                data-bulk-select='{"body":"order-table-body"}' /></div>
                                    </th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order" style="width:5%;">ORDER</th>
                                    <th class="sort align-middle text-end" scope="col" data-sort="total"
                                        style="width:6%;">TOTAL</th>
                                    <th class="sort align-middle ps-8" scope="col" data-sort="customer"
                                        style="width:28%; min-width: 250px;">CUSTOMER</th>
                                    <th class="sort align-middle pe-3" scope="col" data-sort="payment_status"
                                        style="width:10%;">PAYMENT STATUS</th>
                                    <th class="sort align-middle text-start pe-3" scope="col"
                                        data-sort="fulfilment_status" style="width:12%; min-width: 200px;">FULFILMENT
                                        STATUS</th>
                                    <th class="sort align-middle text-start" scope="col" data-sort="delivery_type"
                                        style="width:30%;">DELIVERY TYPE</th>
                                    <th class="sort align-middle text-end pe-0" scope="col" data-sort="date">DATE</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="order-table-body">
                            
                                <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                    <td class="fs--1 align-middle px-0 py-3">
                                        <div class="form-check mb-0 fs-0"><input class="form-check-input" type="checkbox"
                                                data-bulk-select-row='{"order":2440,"total":80,"customer":{"avatar":"/team/25.webp","name":"Michael Jenkins"},"payment_status":{"label":"Cancelled","type":"badge-phoenix-secondary","icon":"x"},"fulfilment_status":{"label":"Unfulfiled","type":"badge-phoenix-danger","icon":"x"},"delivery_type":"Free shipping","date":"Oct 30, 4:25 PM"}' />
                                        </div>
                                    </td>
                                    <td class="order align-middle white-space-nowrap py-0"><a class="fw-semi-bold"
                                            href="#!">#2440</a></td>
                                    <td class="total align-middle text-end fw-semi-bold text-1000">$80</td>
                                    <td class="customer align-middle white-space-nowrap ps-8"><a
                                            class="d-flex align-items-center text-900"
                                            href="../../../apps/e-commerce/landing/profile.html">
                                            <div class="avatar avatar-m"><img class="rounded-circle"
                                                    src="../../../assets/img/team/25.webp" alt="" /></div>
                                            <h6 class="mb-0 ms-3 text-900">Michael Jenkins</h6>
                                        </a></td>
                                    <td class="payment_status align-middle white-space-nowrap text-start fw-bold text-700">
                                        <span class="badge badge-phoenix fs--2 badge-phoenix-secondary"><span
                                                class="badge-label">Cancelled</span><span class="ms-1" data-feather="x"
                                                style="height:12.8px;width:12.8px;"></span></span></td>
                                    <td
                                        class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-700">
                                        <span class="badge badge-phoenix fs--2 badge-phoenix-danger"><span
                                                class="badge-label">Unfulfiled</span><span class="ms-1"
                                                data-feather="x" style="height:12.8px;width:12.8px;"></span></span></td>
                                    <td class="delivery_type align-middle white-space-nowrap text-900 fs--1 text-start">
                                        Free shipping</td>
                                    <td class="date align-middle white-space-nowrap text-700 fs--1 ps-4 text-end">Oct 30,
                                        4:25 PM</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="mb-9">
                <div id="userList">
                    <div class="row justify-content-between mb-4 gx-6 gy-3 align-items-center mt-5">
                        <div class="col-auto">
                            <h2 class="mb-0">Siparişler

                            </h2>

                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success text-white text-white">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger text-white text-white">
                            {{ session('error') }}
                        </div>
                    @endif

                    <style type="text/css">
                        .st0 {
                            fill: #e54242;
                        }

                        .st1 {
                            opacity: 0.15;
                        }

                        .st2 {
                            fill: #FFFFFF;
                        }
                    </style>

                    <div class="pb-6">
                        <div id="lealsTable" data-list='{"page":10,"pagination":true}'>


                            <div class="table-responsive scrollbar mx-n1 px-1 border-top">
                                <table class="table fs--1 mb-0 leads-table">
                                    <thead>
                                        <tr>
                                            <th>Sipariş No.</th>
                                            <th>Görsel</th>
                                            <th>Proje</th>
                                            <th>Tutar</th>
                                            <th>Sipariş Tarihi</th>
                                            <th>Durum</th>
                                            <th>Sipariş</th>
                                            <th>Kullanıcı</th>
                                            <th>Detay</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($cartOrders->count() > 0)
                                            @foreach ($cartOrders as $order)
                                                @php($o = json_decode($order->cart))
                                                @php($project = $o->type == 'project' ? App\Models\Project::find($o->item->id) : null)
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>
                                                        @if ($o->type == 'housing')
                                                            <img src="{{ asset('housing_images/' . json_decode(App\Models\Housing::find(json_decode($order->cart)->item->id ?? 0)->housing_type_data ?? '[]')->image ?? null) }}"
                                                                width="200px" height="120px"
                                                                style="object-fit: contain;" />
                                                        @else
                                                            <img src="{{ URL::to('/') . '/project_housing_images/' . $project->image }}"
                                                                width="200px" height="120px"
                                                                style="object-fit: contain;" />
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($o->type == 'project')
                                                            {{ $project->project_title ?? '?' }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>{{ $order->amount }}</td>
                                                    <td>{{ $order->created_at }}</td>
                                                    <td>{{ ['0' => 'Başarısız', '1' => 'Başarılı'][$order->status] }}</td>
                                                    <td>
                                                        {{ $o->item->title }}<br />
                                                        {{ $o->item->address }}
                                                    </td>
                                                    <td>{{ $order->user->email }}</td>
                                                    <td>
                                                        <a href="#" class="btn btn-danger" data-bs-toggle="modal"
                                                            data-bs-target="#modal-{{ $order->id }}">DETAY</a>
                                                        <div class="modal fade" id="modal-{{ $order->id }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Kullanıcı Detayları</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div>
                                                                            <b>ID:</b> {{ $order->user->id }}
                                                                        </div>
                                                                        <div>
                                                                            <b>Ad Soyad:</b> {{ $order->user->name }}
                                                                        </div>
                                                                        <div>
                                                                            <b>Email:</b> {{ $order->user->email }}
                                                                        </div>
                                                                        <div>
                                                                            <b>Telefon:</b> {{ $order->user->phone }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="button"
                                                                            class="btn btn-primary">Save changes</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">Sipariş Bulunamadı</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="row align-items-center justify-content-end py-4 pe-0 fs--1">
                                <div class="col-auto d-flex">
                                    <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900"
                                        data-list-info="data-list-info"></p><a class="fw-semi-bold" href="#!"
                                        data-list-view="*">View all<span class="fas fa-angle-right ms-1"
                                            data-fa-transform="down-1"></span></a><a class="fw-semi-bold d-none"
                                        href="#!" data-list-view="less">View Less<span
                                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                                </div>
                                <div class="col-auto d-flex"><button class="page-link" data-list-pagination="prev"><span
                                            class="fas fa-chevron-left"></span></button>
                                    <ul class="mb-0 pagination"></ul><button class="page-link pe-0"
                                        data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        let table = new DataTable('#table', {
            language: {
                url: '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json',
            },
        });
        $('#filterButton').click(function() {
            $('#filterModal').modal('show');
        });

        $(document).ready(function() {
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                console.log(formData);

                $.ajax({
                    type: 'GET',
                    url: "{{ route('admin.users.index') }}", // Filtreleme işlemi yapıldıktan sonra sonuçların nasıl getirileceği URL
                    data: formData,
                    success: function(data) {
                        // Filtrelenmiş verileri tabloya ekleme işlemi
                        $('.table-responsive').html(data);
                        console.log(data);

                        // DataTable yeniden yükleme (verileri güncellemek için)
                        table.ajax.reload();

                        $('#filterModal').modal('hide');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endsection

@section('css')
    <style>
        #table_filter {
            margin-bottom: 20px;
        }
    </style>
@endsection
