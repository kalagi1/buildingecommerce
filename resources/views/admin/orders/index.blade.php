@extends('admin.layouts.master')

@section('content')
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
                        <div class="alert alert-success text-white">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger text-white">
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
                        <div id="lealsTable"
                            data-list='{"page":10,"pagination":true}'>


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
                                            <td>{{$order->id}}</td>
                                            <td>
                                                @if ($o->type == 'housing')
                                                <img src="{{asset('housing_images/'.json_decode(App\Models\Housing::find(json_decode($order->cart)->item->id ?? 0)->housing_type_data ?? '[]')->image ?? null)}}" width="200px" height="120px" style="object-fit: contain;"/>
                                                @else
                                                <img src="{{asset($project->image)}}" width="200px" height="120px" style="object-fit: contain;"/>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($o->type == 'project')
                                                {{ $project->project_title ?? '?' }}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>{{$order->amount}}</td>
                                            <td>{{$order->created_at}}</td>
                                            <td>{{['0' => 'Başarısız', '1' => 'Başarılı'][$order->status]}}</td>
                                            <td>
                                                {{ $o->item->title }}<br/>
                                                {{ $o->item->address }}
                                            </td>
                                            <td>{{$order->user->email}}</td>
                                            <td>
                                                <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-{{$order->id}}">DETAY</a>
                                                <div class="modal fade" id="modal-{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Kullanıcı Detayları</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
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
        let table = new DataTable('.table', {
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
