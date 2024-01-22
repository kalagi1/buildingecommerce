@extends('institutional.layouts.master')

@section('content')
    @php 
        $months = [
            "Ocak",
            "Şubat",
            "Mart",
            "Nisan",
            "Mayıs",
            "Haziran",
            "Temmuz",
            "Ağustos",
            "Eylül",
            "Ekim",
            "Kasım",
            "Aralık",
        ];
    @endphp

    <div class="content">
        <div class="mb-9">
            <div class="row g-3 mb-4">
                <div class="col-auto">
                    <h3 class="mb-0">Tanımlı Kuponlarım</h3>
                    <span><b><small>Emlak Kulüp Üyelerine Tanımlı Kuponlarım</small></b></span>
                </div>
            </div>
            <div id="orderTable"
                data-list='{"valueNames":["order_no","order_image","order_project","order_amount","order_date","order_status","order_user","order_seller","order_details"],"page":10,"pagination":true}'>
                <div class="mb-4">
                    <div class="row g-3">
                        <div class="col-auto">
                            <div class="search-box">
                                <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input
                                        class="form-control search-input search" type="search" placeholder="Ara"
                                        aria-label="Search" />
                                    <span class="fas fa-search search-box-icon"></span>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white border-top border-bottom border-200 position-relative top-1">
                    <div class="table-responsive scrollbar mx-n1 px-1">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <table class="table table-sm fs--1 mb-0">
                            <thead>
                                <tr>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_no">Kupon Kodu</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_no">Emlak İndirim Tipi</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_no">Emlak İndirim Tutarı</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_no">Emlak Kulüp Üyesi Kazanç Tipi</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_no">Emlak Kulüp Üyesi Kazanç Tutarı</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_no">Kalan Kullanım Sayısı</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_no">Kupon Geçerlilik Tarihleri</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_no">Tanımlanan Emlak Kulüp Üyesi</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_no">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="order-table-body">

                                @if ($coupons->count() > 0)
                                    @foreach ($coupons as $coupon)
                                        <tr>
                                            <td class="order_no">{{$coupon->coupon_code}}</td>
                                            <td class="order_no">{{$coupon->discount_type == 1 ? "Yüzdesel" : "Miktar"}}</td>
                                            <td class="order_no">{{number_format($coupon->amount, 0, ',', '.')}}{{$coupon->discount_type == 1 ? "%" : "₺"}}</td>
                                            <td class="order_no">{{$coupon->estate_club_user_amount_type == 1 ? "Satıştan Yüzde" : "Miktar"}}</td>
                                            <td class="order_no">{{number_format($coupon->estate_club_user_amount, 0, ',', '.')}}{{$coupon->estate_club_user_amount_type == 1 ? "%" : "₺"}}</td>
                                            <td class="order_no">{{$coupon->use_count}}</td>
                                            @if($coupon->time_type == 1)
                                                <td>Sınırsız</td>
                                            @else 
                                                <td class="order_no">{{$months[date('m',strtotime($coupon->start_date)) - 1].', '.date('d Y',strtotime($coupon->start_date)).' - '.$months[date('m',strtotime($coupon->end_date)) - 1].', '.date('d Y',strtotime($coupon->end_date))}}</td>
                                            @endif
                                            <td class="order_no">{{$coupon->user->name}}</td>
                                            <td class="order_no">
                                                <a href="{{route('institutional.estate.create.coupon',$user->id)}}" class="badge badge-phoenix badge-phoenix-primary">Satışları Listele</a>
                                                <a href="{{route('institutional.estate.edit.coupon',$coupon->id)}}" class="badge badge-phoenix badge-phoenix-primary">Düzenle</a>
                                                <a href="{{route('institutional.estate.coupon.destroy',$coupon->id)}}" class="badge badge-phoenix badge-phoenix-danger">Sil</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center">Kupon Bulunamadı</td>
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
