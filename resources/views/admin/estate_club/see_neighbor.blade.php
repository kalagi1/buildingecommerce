@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="mb-9">
            <div class="row g-3 mb-4">
                <div class="col-auto">
                    <h2 class="mb-0">Komşumu Gör Başvuruları</h2>
                </div>
            </div>
            <div id="orderTable"
                data-list='{"valueNames":["order_no","order_image","order_project","order_amount","order_date","order_status","order_user","order_seller","order_details"],"page":10,"pagination":true}'>

                <div
                    class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white border-top border-bottom border-200 position-relative top-1">
                    <div class="table-responsive scrollbar mx-n1 px-1">
                        <table class="table table-sm fs--1 mb-0">
                            <thead>
                                <tr>

                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_no">Başvuru No</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_no">Başvuran Üye</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_no">Proje</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_no">Paylaşılacak Bilgiler</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_name">Tutar</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_date">Başvuru Tarihi</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_ok">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="order-table-body">

                                @if ($estateClubUsers->count() > 0)
                                    @foreach ($estateClubUsers as $key => $user)
                                        <tr>
                                            <td class="order_no">{{ $key + 1 }}</td>

                                            <td class="order_name">{{ $user->user->name }}</td>
                                            <td class="order_name">
                                                {{ $user->project->id + 1000000 + $user->housing }} <br>
                                                {{ $user->project->project_title }} projesinde
                                                {{ $user->housing }} No'lu Daire</td>

                                            <td class="order_name">
                                                Alıcı Adı: {{ $user->owner->name }} <br>
                                                Alıcı İletişim No: {{ $user->owner->phone }}</td>

                                            <td class="order_name">250 TL</td>
                                            <td class="order_date">
                                                {{ $user->created_at->locale('tr')->isoFormat('D MMM, HH:mm') }}</td>
                                            <!-- Tablo içindeki onay butonları -->
                                            <td class="order_ok">
                                                @if ($user->status == 1)
                                                    <button class="badge badge-phoenix fs-10 badge-phoenix-success btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#confirmationModal{{ $user->id }}">Onaylandı</button>
                                                @elseif ($user->status == 0)
                                                    <button class="badge badge-phoenix fs-10 badge-phoenix-warning btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#confirmationModal{{ $user->id }}">İnceleniyor</button>
                                                @elseif ($user->status == 2)
                                                    <button class="badge badge-phoenix fs-10 badge-phoenix-danger btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#confirmationModal{{ $user->id }}">Reddedildi</button>
                                                @endif

                                                <!-- Onaylama Modalı -->
                                                <div class="modal fade" id="confirmationModal{{ $user->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="confirmationModalLabel{{ $user->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="confirmationModalLabel{{ $user->id }}">Komşu
                                                                    bilgilerinin paylaşılması adına durum güncellemesi
                                                                    yapıyorsunuz. </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Kullanıcının durumunu değiştirmek istediğinize emin misiniz?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                    class="badge badge-phoenix fs-10 badge-phoenix-secondary"
                                                                    data-bs-dismiss="modal">Vazgeç</button>
                                                                <form
                                                                    action="{{ route('admin.changeStatusNeighbor', ['applyId' => $user->id, 'action' => 'approve']) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="badge badge-phoenix fs-10 badge-phoenix-success">Evet,
                                                                        Onayla</button>
                                                                </form>
                                                                <form
                                                                    action="{{ route('admin.changeStatusNeighbor', ['applyId' => $user->id, 'action' => 'reject']) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="badge badge-phoenix fs-10 badge-phoenix-danger">Reddet</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center">Sipariş Bulunamadı</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
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
        .order_status span {
            font-weight: 800
        }

        #table_filter {
            margin-bottom: 20px;
        }

        .invoiceBtn {
            width: 150px !important;
            -moz-appearance: none;
            -webkit-appearance: none;
            appearance: none;
            border: none;
            background: none;
            color: #0f1923;
            cursor: pointer;
            position: relative;
            padding: 8px;
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 11px;
            transition: all .15s ease;
        }

        .invoiceBtn::before,
        .invoiceBtn::after {
            content: '';
            display: block;
            position: absolute;
            right: 0;
            left: 0;
            height: calc(50% - 5px);
            border: 1px solid #7D8082;
            transition: all .15s ease;
        }

        .invoiceBtn::before {
            top: 0;
            border-bottom-width: 0;
        }

        .invoiceBtn::after {
            bottom: 0;
            border-top-width: 0;
        }

        .invoiceBtn:active,
        .invoiceBtn:focus {
            outline: none;
        }

        .invoiceBtn:active::before,
        .invoiceBtn:active::after {
            right: 3px;
            left: 3px;
        }

        .invoiceBtn:active::before {
            top: 3px;
        }

        .invoiceBtn:active::after {
            bottom: 3px;
        }

        .invoiceBtn_lg {
            position: relative;
            display: block;
            padding: 10px 20px;
            color: #fff;
            background-color: #0f1923;
            overflow: hidden;
            box-shadow: inset 0px 0px 0px 1px transparent;
        }

        .invoiceBtn_lg::before {
            content: '';
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: 2px;
            height: 2px;
            background-color: #0f1923;
        }

        .invoiceBtn_lg::after {
            content: '';
            display: block;
            position: absolute;
            right: 0;
            bottom: 0;
            width: 4px;
            height: 4px;
            background-color: #0f1923;
            transition: all .2s ease;
        }

        .invoiceBtn_sl {
            display: block;
            position: absolute;
            top: 0;
            bottom: -1px;
            left: -8px;
            width: 0;
            background-image: linear-gradient(to bottom right, #00c6ff,
                    #0072ff);
            transform: skew(-15deg);
            transition: all .2s ease;
        }

        .invoiceBtn_text {
            position: relative;
        }

        .invoiceBtn:hover {
            color: #0f1923;
        }

        .invoiceBtn:hover .invoiceBtn_sl {
            width: calc(100% + 15px);
        }

        .invoiceBtn:hover .invoiceBtn_lg::after {
            background-color: #fff;
        }
    </style>
@endsection
