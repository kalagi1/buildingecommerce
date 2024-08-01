@extends('client.layouts.masterPanel')
@section('content')
    <div class="content">
        <div class="text-header-title">
            <p class="sales-consultants-heading">Satış Danışmanları ve Projeleri</p>
        </div>
        <div class="text-header">
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Ad Soyad</th>
                        <th>E-posta</th>
                        <th>Unvan</th>
                        <th>Atanmış Projeler</th>
                        <th>Proje Ataması Yap</th>
                        <th>Bugün çalışıyor mu ?</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales_consultant as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->role->name }}</td>
                            <td>
                                @foreach ($item->projectAssigments as $project)
                                    {{ $project->project_title }}<br>
                                @endforeach
                            </td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btnProjectAssign" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal{{ $index }}">
                                    Proje Ata
                                </button>
                            </td>
                            <td style="display: flex;align-items:center;justify-content:center;">
                                <input type="checkbox" class="today-working-checkbox" data-user-id="{{ $item->id }}" 
                                {{ $item->today_working ? 'checked' : '' }}>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{ $index }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel{{ $index }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fs-2" id="exampleModalLabel{{ $index }}">Projeler</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('institutional.assign.project.user') }}" method="POST">
                                            @csrf
                                            <div class="col-md-12 mb-3">
                                                {{-- <label class="form-label mb-3 fs-1 text-center" for="projects{{$index}}">Proje Seç</label> --}}
                                                <div id="projects{{ $index }}"
                                                    style="max-height: 300px; overflow-y: auto;"> <!-- Scrollbar eklendi -->

                                                    @foreach ($projects as $project)
                                                    {{-- {{dd($projects)}} --}}
                                                        <div class="form-check mt-3">
                                                            <input type="hidden" name="user_id"
                                                                value="{{ $item->id }}">
                                                            <input class="form-check-input mr-3" type="checkbox"
                                                                name="projectIds[]" value="{{ $project->id }}"

                                                                id="project{{ $index }}_{{ $project->id }}">

                                                            <label class="form-check-label"
                                                                for="project{{ $index }}_{{ $project->id }}"
                                                                style="margin-left: 24px !important;">
                                                                {{ $project->project_title }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="valid-feedback">Looks good!</div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-between mt-2 mb-2">
                                                <!-- Flexbox ile düzenleme -->
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Kapat</button>

                                                <button class="btn btn-primary" type="submit">Kaydet</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "language": {
                    "decimal": "",
                    "emptyTable": "Tabloda veri yok",
                    "info": "_START_ - _END_ arasındaki kayıtlar gösteriliyor. Toplam: _TOTAL_ kayıt",
                    "infoEmpty": "Kayıt yok",
                    "infoFiltered": "(_MAX_ kayıt içerisinden filtrelendi)",
                    "infoPostFix": "",
                    "thousands": ".",
                    "lengthMenu": '<select>' +
                        '<option value="10">10</option>' +
                        '<option value="50">50</option>' +
                        '<option value="100">100</option>' +
                        '<option value="-1">Tüm</option>' +
                        '</select><span> kayıt gösteriliyor</span>',
                    "loadingRecords": "Yükleniyor...",
                    "processing": "İşleniyor...",
                    "search": "Ara:",
                    "zeroRecords": "Eşleşen kayıt bulunamadı",
                    "paginate": {
                        "first": "İlk",
                        "last": "Son",
                        "next": "Sonraki",
                        "previous": "Önceki"
                    },
                    "aria": {
                        "sortAscending": ": artan sırala",
                        "sortDescending": ": azalan sırala"
                    }
                }
            });

            $('.today-working-checkbox').on('change', function() {
                var userId = $(this).data('user-id');
                var isChecked = $(this).is(':checked');
                var todayWorkingStatus = isChecked ? 1 : 0;

                $.ajax({
                    url: '{{ route('institutional.update.today.working') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: userId,
                        today_working: todayWorkingStatus
                    },
                    success: function(response) {
                        if (todayWorkingStatus === 1) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Başarı!',
                                text: 'Danışman çalışıyor olarak işaretlendi.',
                                confirmButtonText: 'Tamam'
                            });
                        } else {
                            Swal.fire({
                                icon: 'info',
                                title: 'Bilgi',
                                text: 'Danışman bugün çalışmıyor olarak işaretlendi.',
                                confirmButtonText: 'Tamam'
                            });
                        }
                        console.log('Today working status updated successfully');
                    },
                    error: function(xhr) {
                        console.error('Error updating today working status');
                    }
                });
            });
        });
    </script>


@endsection
@section('styles')
    <style>
        .sales-consultants-heading {
            font-size: 2.2em;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            position: relative;
        }

        .sales-consultants-heading::after {
            content: '';
            display: block;
            margin: 0 auto;
            width: 50%;
            /* Çizgi genişliğini ayarla */
            padding-top: 10px;
            border-bottom: 2px solid gray;
        }

        .text-header {
            padding: 20px;
            margin-bottom: 25px;
            background-color: white;
            border-radius: 18px;
        }

        .text-header-title {
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 18px;
        }

        /* .btnProjectAssign{
                width: 100%;
                border-color: #333;
                background-color: #333;
                color: white;
                border-radius: 6px !important;
            }
            .btnProjectAssign:hover{
                background-color: white !important;
                color: #333;
                border-color: #333;
            }     */

        .btnProjectAssign {
            width: 95%;
            border-color: #D32729;
            background-color: #D32729;
            color: white;
            border-radius: 6px !important;
        }

        .btnProjectAssign:hover {
            background-color: white !important;
            color: #D32729;
            border-color: #D32729;
        }

        .dataTables_length select {
            width: 100px;
            /* Adjust width as needed */
        }

        /* DataTables Select Box Styles */

        .dataTables_wrapper .dataTables_length {
            display: flex;
            align-items: center;
            font-family: 'Open Sans', 'Helvetica Neue', 'Segoe UI', 'Calibri', 'Arial', sans-serif;
            font-size: 18px;
            color: #60666D;
        }

        .dataTables_wrapper .dataTables_length select {
            margin-left: 10px;
            margin-right: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }

        .dataTables_wrapper .dataTables_length select:hover,
        .dataTables_wrapper .dataTables_length select:focus {
            border-color: #333;
        }

        .dataTables_wrapper .dataTables_length label {
            white-space: nowrap;
        }

        .dataTables_wrapper .dataTables_length .select-box__icon {
            display: none;
        }

        .dataTables_wrapper .dataTables_filter {
            display: flex;
            align-items: center;
        }

        .dataTables_wrapper .dataTables_filter label {
            margin-right: 10px;
        }

        .dataTables_wrapper .dataTables_filter input[type="search"] {
            flex: 1;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            font-family: 'Open Sans', 'Helvetica Neue', 'Segoe UI', 'Calibri', 'Arial', sans-serif;
            color: #333;
        }

        .dataTables_wrapper .dataTables_filter input[type="search"]:hover,
        .dataTables_wrapper .dataTables_filter input[type="search"]:focus {
            border-color: #666;
            outline: none;
        }

        #example {
            border-spacing: 0 15px;
        }

        .dataTables_wrapper tbody tr {
            background-color: white !important;
        }

        .dataTables_wrapper tbody tr td {
            background-color: white !important;
            text-align: center;

            vertical-align: middle;
        }

        .dataTables_wrapper thead tr th {
            background-color: white !important;
            text-align: center;

            vertical-align: middle;
        }
    </style>
@endsection
