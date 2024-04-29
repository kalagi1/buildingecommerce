@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <nav class="mb-3 mt-3" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#!">Emlak Sepette</a></li>
                <li class="breadcrumb-item active">Kiraladıklarım</li>
            </ol>
        </nav>
        <div class="mb-9">
            <div id="orderTable"
                data-list="{&quot;valueNames&quot;:[&quot;order&quot;,&quot;total&quot;,&quot;customer&quot;,&quot;payment_status&quot;,&quot;fulfilment_status&quot;,&quot;delivery_type&quot;,&quot;date&quot;],&quot;page&quot;:10,&quot;pagination&quot;:true}">
                <div class="card p-4">
                    <div class="bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
                        <div class="table-responsive scrollbar mx-n1 px-1">
                            <table class="table table-sm fs-9 mb-0">
                                <thead>
                                    <tr>
                                        <th class="white-space-nowrap fs-9 align-middle ps-0" style="width:26px;">
                                            <div class="form-check mb-0 fs-8"><input class="form-check-input"
                                                    id="checkbox-bulk-order-select" type="checkbox"
                                                    data-bulk-select="{&quot;body&quot;:&quot;order-table-body&quot;}"></div>
                                        </th>
                                        <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order"
                                            style="width:5%;">No.</th>
                                        <th class="sort align-middle " scope="col" data-sort="customer" style="width:20%">
                                            İLAN</th>
                                        <th class="sort align-middle text-start" scope="col" data-sort="customer"
                                            style="width:10%">KİŞİ SAYISI</th>
                                        <th class="sort align-middle text-start" scope="col" data-sort="total"
                                            style="width:10%;">TOPLAM FİYAT</th>
                                        <th class="sort align-middle text-start" scope="col" data-sort="total"
                                            style="width:10%;">ÖDENEN KAPORA</th>
                                        <th class="sort align-middle text-start " scope="col" data-sort="customer"
                                            style="width:10%">GİRİŞ TARİHİ</th>
                                        <th class="sort align-middle text-start " scope="col" data-sort="customer"
                                            style="width:10%">ÇIKIŞ TARİHİ</th>
                                        <th class="sort align-middle text-start pe-3" scope="col"
                                            data-sort="fulfilment_status" style="width:10%">FATURA</th>
                                        <th class="sort align-middle pe-3" scope="col" data-sort="payment_status"
                                            style="width:10%;">SİPARİŞ DURUMU</th>
                                        <th class="sort align-middle text-end pe-0" scope="col" data-sort="date" style="width:5%;">TARİH</th>
                                        <th class="sort align-middle text-end pe-0" scope="col" data-sort="date" style="width:5%;">İŞLEMLER</th>
                                    </tr>
                                </thead>
                                <tbody class="list" id="order-table-body">
                                    @foreach ($housingReservations as $order)
                                        @php
                                            $tarih = date('d F Y', strtotime($order->created_at));
                                            $tarih = str_replace(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'], $tarih);
                                            $check_in_date = date('d F Y', strtotime($order->check_in_date));
                                            $check_in_date = str_replace(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'], $check_in_date);
                                            $check_out_date = date('d F Y', strtotime($order->check_out_date));
                                            $check_out_date = str_replace(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'], $check_out_date);
                                        @endphp
                                        @php
                                            $estateSecured = $order->money_trusted == 1 ? 1000 : 0;
                                        @endphp
                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                            <td class="fs-9 align-middle px-0 py-3">
                                                <div class="form-check mb-0 fs-8"><input class="form-check-input"
                                                        type="checkbox"
                                                        data-bulk-select-row="{&quot;order&quot;:2453,&quot;total&quot;:87,&quot;customer&quot;:{&quot;avatar&quot;:&quot;/team/32.webp&quot;,&quot;name&quot;:&quot;Carry Anna&quot;},&quot;payment_status&quot;:{&quot;label&quot;:&quot;Complete&quot;,&quot;type&quot;:&quot;badge-phoenix-success&quot;,&quot;icon&quot;:&quot;check&quot;},&quot;fulfilment_status&quot;:{&quot;label&quot;:&quot;Cancelled&quot;,&quot;type&quot;:&quot;badge-phoenix-secondary&quot;,&quot;icon&quot;:&quot;x&quot;},&quot;delivery_type&quot;:&quot;Cash on delivery&quot;,&quot;date&quot;:&quot;Dec 12, 12:56 PM&quot;}">
                                                </div>
                                            </td>

                                            <td class="order align-middle white-space-nowrap py-0"><a class="fw-semibold"
                                                    href="#!">{{ 1000000 + $order->id }}</a></td>

                                            <td class="customer align-middle white-space-nowrap  text-start">
                                                {{ App\Models\Housing::find($order->housing_id ?? 0)->title ?? null }}

                                            </td>
                                            <td class="customer align-middle white-space-nowrap  text-start">
                                                {{ $order->person_count }}

                                            </td>
                                            <td class="total align-middle text-start fw-semibold text-body-highlight"> {{ number_format(floatval(str_replace('.', '', $order->total_price)), 0, ',', '.') }} ₺</td>

                                            <td class="total align-middle text-start fw-semibold text-body-highlight"> {{ number_format(floatval(str_replace('.', '', $order->total_price) / 2) + $estateSecured, 0, ',', '.') }} ₺ @if($order->money_trusted == 1) (+1000₺ Param Güvende Ödemesi) @endif </td>

                                            <td class="customer align-middle white-space-nowrap  text-start">
                                                {{ $check_in_date }}

                                            </td>
                                            <td class="customer align-middle white-space-nowrap  text-start">
                                                {{ $check_out_date }}

                                            </td>

                                            <td
                                                class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary">
                                                @if ($order->invoice && $order->status == 1)
                                                    <a href="{{ route('institutional.invoice.show', $order->id) }}">
                                                        <button class="invoiceBtn">
                                                            <span class="button_lg">
                                                                <span class="button_sl"></span>
                                                                <span class="button_text">Faturayı Görüntüle</span>
                                                            </span>
                                                        </button>
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td
                                                class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary">
                                                {!! [
                                                    '0' => '<span class="badge badge-phoenix fs-10 badge-phoenix-warning"><span
                                                                                                                                                                                                                                                                                                                                                                            class="badge-label">Rezerve Edildi</span><svg
                                                                                                                                                                                                                                                                                                                                                                            xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                                                                                                                                                                                                                                                                                                                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                                                                                                                                                                                                                                                                                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                                                                                                                                                                                                                                                                                                                            class="feather feather-check ms-1" style="height:12.8px;width:12.8px;">
                                                                                                                                                                                                                                                                                                                                                                            <polyline points="20 6 9 17 4 12"></polyline>
                                                                                                                                                                                                                                                                                                                                                                        </svg>',
                                                    '1' => '<span class="badge badge-phoenix fs-10 badge-phoenix-success"><span
                                                                                                                                                                                                                                                                                                                                                                            class="badge-label">Ödeme Onaylandı</span><svg
                                                                                                                                                                                                                                                                                                                                                                            xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                                                                                                                                                                                                                                                                                                                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                                                                                                                                                                                                                                                                                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                                                                                                                                                                                                                                                                                                                            class="feather feather-check ms-1" style="height:12.8px;width:12.8px;">
                                                                                                                                                                                                                                                                                                                                                                            <polyline points="20 6 9 17 4 12"></polyline>
                                                                                                                                                                                                                                                                                                                                                                        </svg>',
                                                    '2' => '<span class="badge badge-phoenix fs-10 badge-phoenix-danger"><span
                                                                                                                                                                                                                                                                                                                                                                            class="badge-label">Ödeme Reddedildi</span><svg
                                                                                                                                                                                                                                                                                                                                                                            xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                                                                                                                                                                                                                                                                                                                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                                                                                                                                                                                                                                                                                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                                                                                                                                                                                                                                                                                                                            class="feather feather-check ms-1" style="height:12.8px;width:12.8px;">
                                                                                                                                                                                                                                                                                                                                                                            <polyline points="20 6 9 17 4 12"></polyline>
                                                                                                                                                                                                                                                                                                                                                                        </svg>',
                                                ][$order->status] !!}
                                                </span>
                                            </td>
                                            <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-end"> {{ $tarih }}</td>
                                            <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-end reservation-actions-area">
                                                @if(!isset($order->cancelRequest))
                                                    <button class="badge badge-phoenix badge-phoenix-warning reservation-cancel" reservation_id="{{$order->id}}">İptal talebi oluştur</button>
                                                @else
                                                    <button class="badge badge-phoenix badge-phoenix-warning cancel_request_cancel" cancel_request_id="{{$order->cancelRequest->id}}" reservation_id="{{$order->id}}">İptal talebini geri çek</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-reservation-cancel d-none">
        <div class="modal-reservation-bg"></div>
        <div class="modal-reservation-cancel-content">
            <div class="title-top">
                <h3>Rezervasyon İptal Talebi</h3>
                <span class="badge badge-phoenix badge-phoenix-warning">Rezervasyon iptalinde param güvende ödemeniz EmlakSepette yönetimi tarafından geri ödenmeyecektir.</span>
            </div>
            <div class="reservation-cancel-table mt-2">
                <table>
                    <thead>
                        <tr>
                            <th>Rezervasyon Numarası</th>
                            <th>Rezervasyon Ücreti</th>
                            <th>Giriş Tarihi</th>
                            <th>Çıkış Tarihi</th>
                            <th>Rezervasyon Yapan Kişi</th>
                            <th>Param Güvende</th>
                            <th>Geri Ödenecek Tutar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="reservation-number"></td>
                            <td class="reservation-price"></td>
                            <td class="reservation-open-date"></td>
                            <td class="reservation-close-date"></td>
                            <td class="reservation-user"></td>
                            <td class="reservation-money-trusted"></td>
                            <td class="reservation-back-money"></td>
                        </tr>
                    </tbody>
                </table>

                <form action="" method="post" class="reservation_cancel_form">
                    @csrf
                    <input type="hidden" name="reservation_cancel_id" class="reservation_cancel_id">
                    <div class="info mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">İban Numarası</label>
                                    <input type="text" name="iban" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">İban alıcı adı</label>
                                    <input type="text" name="iban_name" required class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">İptal talebinin nedeni</label>
                            <textarea name="reservation_cancel_text" required class="form-control" cols="30" rows="15"></textarea>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-sm btn-success mt-3">İptal talebini oluştur</button>
                    </div>
                </form>



            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var months = ["Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık"]

        @if(request('status') == "cancel_reservation_request")
            $.toast({
                heading: 'Başarılı',
                text: "Başarıyla rezervasyon iptal talebinizi oluşturdunuz. En kısa sürede geri dönüş yapacağız",
                position: 'top-right',
                stack: false
            })
        @endif

        $(document).ready(function(){
            $(document).on('click',".reservation-cancel",function(e){
                e.preventDefault();
                console.log($(this));
                $('.modal-reservation-cancel').removeClass('d-none')
                var itemId = $(this).attr('reservation_id')
                $('.reservation_cancel_id').val(itemId);
                
                $('.reservation_cancel_form').attr('action','{{URL::to("/")}}/institutional/cancel_reservation/'+itemId)
                $.ajax({
                    type: 'GET',
                    url: "{{ URL::to('/') }}/institutional/reservation_info/"+itemId, // Filtreleme işlemi yapıldıktan sonra sonuçların nasıl getirileceği URL
                    success: function(data) {
                        data = JSON.parse(data);
                        var reservation = data.reservation;
                        console.log(reservation);
                        // Sadece sayı karakterlerine izin ver
                        var inputValue = reservation.total_price.toFixed(0);
                        inputValue = inputValue.replace(/\D/g, '');
                        // Her üç basamakta bir nokta ekleyin
                        inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                        var checkInDate = new Date(reservation.check_in_date);
                        var checkOutDate = new Date(reservation.check_out_date);

                        $('.reservation-number').html(1000000+reservation.id)
                        $('.reservation-price').html(inputValue+'₺')
                        $('.reservation-open-date').html(months[checkInDate.getMonth()]+', '+checkInDate.getDate()+' '+checkInDate.getFullYear())
                        $('.reservation-close-date').html(months[checkOutDate.getMonth()]+', '+checkOutDate.getDate()+' '+checkOutDate.getFullYear())
                        $('.reservation-user').html(reservation.user.name)
                        if(reservation.money_trusted){
                            $('.reservation-money-trusted').html("<span class='badge badge-phoenix badge-phoenix-success'><i class='fa fa-check'></span></span>")
                            $('.reservation-money-trusted').addClass('text-center')
                        }else{
                            $('.reservation-money-trusted').html("<span class='badge badge-phoenix badge-phoenix-danger'><i class='fa fa-times'></span></span>")
                            $('.reservation-money-trusted').addClass('text-center')
                        }
                        console.log(reservation.money_trusted);
                        if(reservation.money_trusted){
                            var backPrice = reservation.total_price / 2;
                            backPrice = backPrice.toFixed(0);
                            backPrice = backPrice.replace(/\D/g, '');
                            backPrice = backPrice.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            $('.reservation-back-money').html((backPrice)+'₺')
                            $('.reservation-estate-shopping-money').html('1000₺ (Param güvende ücreti)')
                            $('.reservation-tourism-money').html('0₺')
                        }else{
                            var price = reservation.total_price;
                            var backPrice = (price / 4).toFixed(0);
                            backPrice = backPrice.replace(/\D/g, '');
                            backPrice = backPrice.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            var estateBagPrice = ((price / 4) / 10 * 2).toFixed(0);
                            estateBagPrice = estateBagPrice.replace(/\D/g, '');
                            estateBagPrice = estateBagPrice.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            var institutionalPrice = ((price / 4) / 10 * 8).toFixed(0);
                            institutionalPrice = institutionalPrice.replace(/\D/g, '');
                            institutionalPrice = institutionalPrice.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            $('.reservation-back-money').html(backPrice+'₺')
                            $('.reservation-estate-shopping-money').html(estateBagPrice+'₺')
                            $('.reservation-tourism-money').html(institutionalPrice+'₺')
                        }


                        if(reservation.owner.iban){
                            $('.tourism-iban').html(reservation.owner.iban)
                        }else{
                            $('.tourism-iban').addClass('badge badge-phoenix badge-phoenix-danger d-inline-block')
                            $('.tourism-iban').css('text-align','left')
                            $('.tourism-iban').html("Acenteye ait iban bilgisi sistemde kayıtlı değil")
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            })

            $('.cancel_request_cancel').click(function(e){
                e.preventDefault();
                var thisx = $(this);
                Swal.fire({
                    title: "İptal etme isteğini geri çekmek istediğine emin misin? ",
                    showCancelButton: true,
                    confirmButtonText: "Evet",
                    cancelButtonText : "İptal"
                    }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        var csrfToken = $("meta[name='csrf-token']").attr("content");
                        formData.append('_token', csrfToken);
                        $.ajax({
                            type: "POST",
                            url: "{{URL::to('/')}}/institutional/cancel_reservation_cancel/"+$(this).attr('cancel_request_id'), // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if(response.status){
                                    $.toast({
                                        heading: 'Başarılı',
                                        text: "Başarıyla rezervasyon iptal talebinizi geri çektiniz",
                                        position: 'top-right',
                                        stack: false
                                    })

                                    $('.reservation-actions-area').html('<button class="badge badge-phoenix badge-phoenix-warning reservation-cancel" reservation_id="'+thisx.attr('reservation_id')+'">İptal talebi oluştur</button>')
                                }
                            },
                        });
                    }
                });
            })
        })
    </script>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css"
        integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @media(max-width: 768px) {
            .mobile-shadow {
                background: white;
                box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.103)
            }

            .my-properties table tr {
                margin-bottom: 20px;
            }

            .ps-section--account {
                padding: 60px 0;
            }

            .my-properties table tr td {
                padding: 10px !important;
            }

            .my-properties {
                background: transparent;
                padding: 0 !important;
                margin-top: 20px;
                box-shadow: none !important;
            }
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
            font-size: 12px;
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

        #orders-container .header-bar {
            border: 1px solid #e2e2e2;
            background: #fff;
            border-radius: 8px;
            display: flex;
            padding: 15px 20px;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #2a2a2a;
            
            margin-bottom: 20px;
        }

        #orders-container .header-bar .order-search-box-warn {
            font-size: 12px;
            font-weight: 600;
            color: #d21313;
            margin: 5px;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #orders-container .header-bar .order-search-box-container {
            position: relative;
            display: flex;
        }

        #orders-container .header-bar .order-search-box-container>div {
            display: inline-block;
            width: 100%;
        }

        #orders-container .header-bar .order-search-box-container>div input {
            padding-right: 30px;
            border-radius: 4px;
        }

        #orders-container .header-bar .order-search-box-container .osb-give-up {
            position: absolute;
            left: 310px;
        }

        #orders-container .header-bar .order-search-box-container .osb-give-up span {
            position: absolute;
            font-size: 12px;
            font-weight: 600;
            color: #333333;
            left: 15px;
            top: 9px;
        }

        #orders-container .header-bar .order-search-box-container .osb-give-up span:hover {
            cursor: pointer;
            color: #EA2B2E;
            text-decoration: underline;
        }

        #orders-container .header-bar .order-search-box-container .ty-button {
            border: none;
            position: absolute;
            right: 0;
            height: 34px;
            width: 25px;
        }

        #orders-container .header-bar .order-search-box-container .i-search {
            position: absolute;
            right: 9px;
            top: 9px;
            color: #EA2B2E;
            font-size: 12px;
            cursor: pointer;
        }

        #orders-container .header-bar .ty-input {
            height: 34px;
        }

        #orders-container .header-bar .ty-form {
            width: 310px;
        }

        #orders-container .header-bar .ty-form .ty-input-w div {
            display: none;
        }

        #orders-container .header-bar h1 {
            font-size: 18px;
        }

        #orders-container .header-bar .sorting {
            width: 130px;
        }

        #orders-container .header-bar .sorting>div>div:last-child {
            display: none;
        }

        #orders-container .header-bar .sorting .ty-input {
            border-radius: 4px;
        }

        #orders-container .header-info-box {
            border: 1px solid #deddbe;
            padding: 20px 20px 18px 64px;
            background: url("https://cdn.dsmcdn.com/web/production/orders-info-icon.svg") no-repeat 20px center #fffff1;
            display: flex;
            line-height: 20px;
            color: #333;
            background-size: 24px 24px;
            margin-bottom: 20px;
            border-radius: 3px;
        }

        #orders-container .order {
            border: 1px solid #e2e2e2;
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .text-red {
            color: #EA2B2E !important;
            font-weight: 600 !important
        }

        #orders-container .order .last-operation-text {
            padding: 25px 20px 0 20px;
        }

        #orders-container .order .order-header {
            display: flex;
            justify-content: space-between;
            border-bottom: solid 1px #e2e2e2;
            border-radius: 8px 8px 0 0;
            background-color: #fafafa;
            padding: 15px 20px;
            align-items: center;
        }

        .list-group {
            display: flex;
            flex-wrap: wrap;
            flex-direction: initial;
        }

        .list-group-item {
            width: 50%
        }

        #orders-container .order .order-header .order-header-info {
            color: #666;
            
            font-size: 13px;
            display: flex;
        }

        #orders-container .order .order-header .order-header-info b {
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            color: #333;
            width: 100%;
            font-weight: 400;
        }

        #orders-container .order .order-header .order-header-info b.orange {
            color: #EA2B2E;
        }

        #orders-container .order .order-header button {
            width: 150px;
            border-radius: 4px;
        }

        #orders-container .order .order-list {
            padding: 20px;
        }

        #orders-container .order .order-item {
            display: flex;
            align-items: center;
            border: 1px solid #e2e2e2;
            border-radius: 4px;
            margin-bottom: 15px;
            padding: 15px 20px;
        }

        #orders-container .order .order-item:last-child {
            margin-bottom: 0;
        }

        .list-group-item+.list-group-item {
            border-top-width: none !important;
        }

        #orders-container .order .order-item .order-item-status {
            display: flex;
            flex-direction: column;
            width: 80%;
            color: #333;
            font-size: 12px;
        }

        #orders-container .order .order-item .order-item-status .title {
            display: flex;
            vertical-align: center;
        }

        #orders-container .order .order-item .order-item-status .title .icon {
            margin-right: 10px;
        }

        #orders-container .order .order-item .order-item-status .title .at_collection_point {
            margin-right: 8px;
            height: 20px;
        }

        #orders-container .order .order-item .order-item-status .title .shipment-info {
            color: #666;
            font-size: 12px;
            margin-left: 10px;
            line-height: 18px;
            text-decoration: underline;
            transition: all 0.2s ease;
        }

        #orders-container .order .order-item .order-item-status .title .shipment-info:hover {
            color: #EA2B2E;
        }

        #orders-container .order .order-item .order-item-status .title.preparing_defective~.description,
        #orders-container .order .order-item .order-item-status .title.shipped_defective~.description,
        #orders-container .order .order-item .order-item-status .title.at_collection_point_defective~.description,
        #orders-container .order .order-item .order-item-status .title.delivered_defective~.description,
        #orders-container .order .order-item .order-item-status .title.undelivered_defective~.description,
        #orders-container .order .order-item .order-item-status .title.returned_defective~.description {
            width: 380px;
        }

        #orders-container .order .order-item .order-item-status .at_collection_point {
            align-items: center;
        }

        #orders-container .order .order-item .order-item-status .description {
            margin-top: 5px;
            font-size: 12px;
        }

        #orders-container .order .order-item .order-item-status .description .cargo-info {
            display: flex;
            align-items: center;
            color: #666666;
            font-weight: normal;
        }

        #orders-container .order .order-item .order-item-status .description .cargo-info .provider-name {
            margin-right: 5px;
        }

        #orders-container .order .order-item .order-item-status .description .cargo-info .tracking-number {
            padding: 2px 5px 0 5px;
            border: dashed 1px #efe1d3;
            background-color: #fff9f3;
            border-radius: 3px;
            color: #333333;
        }

        #orders-container .order .order-item .order-item-status .description .cargo-info .tracking-number .highlighted {
            font-weight: 600;
        }

        #orders-container .order .order-item .order-item-status .description b {
            vertical-align: middle;
        }

        #orders-container .order .order-item .order-item-status .description .refund-info {
            display: inline-block;
            border-left: 1px solid #e2e2e2;
            padding-left: 5px;
            margin-left: 5px;
            vertical-align: top;
        }

        #orders-container .order .order-item .order-item-status .description .refund-info.wallet {
            background: url("https://cdn.dsmcdn.com/web/production/orders-wallet-icon.svg") no-repeat 5px center;
            padding-left: 30px;
        }

        #orders-container .order .order-item .order-item-status .description .refund-info img {
            height: 10px;
            margin-right: 7px;
        }

        #orders-container .order .order-item .order-item-status strong {
            
        }

        #orders-container .order .order-item .order-item-status .at_collection_point,
        #orders-container .order .order-item .order-item-status .az_at_collection_point,
        #orders-container .order .order-item .order-item-status .created_assembly,
        #orders-container .order .order-item .order-item-status .appointed_assembly,
        #orders-container .order .order-item .order-item-status .completed_assembly,
        #orders-container .order .order-item .order-item-status .at_collection_point_defective,
        #orders-container .order .order-item .order-item-status .creating,
        #orders-container .order .order-item .order-item-status .created,
        #orders-container .order .order-item .order-item-status .preparing,
        #orders-container .order .order-item .order-item-status .shipped,
        #orders-container .order .order-item .order-item-status .az_shipped,
        #orders-container .order .order-item .order-item-status .delivered,
        #orders-container .order .order-item .order-item-status .az_delivered,
        #orders-container .order .order-item .order-item-status .preparing_defective,
        #orders-container .order .order-item .order-item-status .shipped_defective,
        #orders-container .order .order-item .order-item-status .delivered_defective,
        #orders-container .order .order-item .order-item-status .replacement_request_created,
        #orders-container .order .order-item .order-item-status .replacement_request_shipped,
        #orders-container .order .order-item .order-item-status .replacement_request_waiting,
        #orders-container .order .order-item .order-item-status .replacement_accepted,
        #orders-container .order .order-item .order-item-status .replacement_rejected {
            color: #0bc15c;
        }

        #orders-container .order .order-item .order-item-status .created_inbound,
        #orders-container .order .order-item .order-item-status .shipped_inbound,
        #orders-container .order .order-item .order-item-status .waiting_in_action,
        #orders-container .order .order-item .order-item-status .accepted,
        #orders-container .order .order-item .order-item-status .rejected,
        #orders-container .order .order-item .order-item-status .uncompleted_assembly,
        #orders-container .order .order-item .order-item-status .cancel,
        #orders-container .order .order-item .order-item-status .un_delivered,
        #orders-container .order .order-item .order-item-status .returned,
        #orders-container .order .order-item .order-item-status .payment_failed,
        #orders-container .order .order-item .order-item-status .undelivered_defective,
        #orders-container .order .order-item .order-item-status .returned_defective {
            color: #bb0000;
        }

        #orders-container .order .order-item .order-item-images {
            flex: 1;
            width: 20%;
            display: flex;
            align-items: center;
        }

        #orders-container .order .order-item .order-item-images .image-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 41px;
            height: 62px;
            border: 2px solid #e6e6e6;
            border-radius: 3px;
            margin-right: 10px;
            cursor: pointer;
        }

        #orders-container .order .order-item .order-item-images img {
            width: 90%;
        }

        #orders-container .order .order-item .order-item-images span {
            color: #666;
            width: 25px;
            text-align: center;
            font-size: 12px;
        }

        #orders-container .order .order-item .order-item-easy-return,
        #orders-container .order .order-item .order-item-group-deal-info {
            width: 130px;
        }

        #orders-container .order .order-item .order-item-easy-return button.ty-bordered,
        #orders-container .order .order-item .order-item-group-deal-info button.ty-bordered {
            border-radius: 2px;
        }

        #orders-container .loader {
            display: block;
            position: relative;
            clear: both;
        }

        #orders-container .spinner {
            display: block;
            position: relative;
            width: 64px;
            height: 64px;
            margin: 0 auto;
        }

        #orders-container .spinner div {
            transform-origin: 32px 32px;
            animation: spin 1.2s linear infinite;
        }

        #orders-container .spinner div:after {
            content: ' ';
            display: block;
            position: absolute;
            top: 3px;
            left: 29px;
            width: 5px;
            height: 14px;
            border-radius: 20%;
            background: #eee;
        }

        #orders-container .spinner div:nth-child(12) {
            transform: rotate(330deg);
            animation-delay: 0s;
        }

        #orders-container .spinner div:nth-child(11) {
            transform: rotate(300deg);
            animation-delay: -0.1s;
        }

        #orders-container .spinner div:nth-child(10) {
            transform: rotate(270deg);
            animation-delay: -0.2s;
        }

        #orders-container .spinner div:nth-child(9) {
            transform: rotate(240deg);
            animation-delay: -0.3s;
        }

        #orders-container .spinner div:nth-child(8) {
            transform: rotate(210deg);
            animation-delay: -0.4s;
        }

        #orders-container .spinner div:nth-child(7) {
            transform: rotate(180deg);
            animation-delay: -0.5s;
        }

        #orders-container .spinner div:nth-child(6) {
            transform: rotate(150deg);
            animation-delay: -0.6s;
        }

        #orders-container .spinner div:nth-child(5) {
            transform: rotate(120deg);
            animation-delay: -0.7s;
        }

        #orders-container .spinner div:nth-child(4) {
            transform: rotate(90deg);
            animation-delay: -0.8s;
        }

        #orders-container .spinner div:nth-child(3) {
            transform: rotate(60deg);
            animation-delay: -0.9s;
        }

        #orders-container .spinner div:nth-child(2) {
            transform: rotate(30deg);
            animation-delay: -1s;
        }

        #orders-container .spinner div:nth-child(1) {
            transform: rotate(0deg);
            animation-delay: -1.1s;
        }

        @keyframes spin {
            0% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        #orders-container .orders-error {
            font-size: 12px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 400px;
        }

        #orders-container .orders-error .orders-error-icon {
            width: 100px;
            height: 100px;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: solid 1px #e6e6e6;
            border-radius: 50%;
            margin-bottom: 10px;
            background: url("https://cdn.dsmcdn.com/web/production/orders-error-icon.svg") center no-repeat #fff;
        }

        #orders-container .orders-error .orders-error-icon img {
            margin-left: 3px;
        }

        #orders-container .orders-error button {
            width: 300px;
            height: 38px;
            font-size: 16px;
            margin-top: 10px;
        }

        #orders-container .icon.creating:before {
            content: url("https://cdn.dsmcdn.com/web/production/preparing.svg");
        }

        #orders-container .icon.created:before,
        #orders-container .icon.created_assembly {
            content: url("https://cdn.dsmcdn.com/web/production/created.svg");
        }

        #orders-container .icon.appointed_assembly:before {
            content: url("https://cdn.dsmcdn.com/web/production/assembly-appointed.svg");
        }

        #orders-container .icon.az_delivered:before,
        #orders-container .icon.delivered:before,
        #orders-container .icon.delivered_defective:before,
        #orders-container .icon.completed_assembly:before {
            content: url("https://cdn.dsmcdn.com/web/production/delivered.svg");
        }

        #orders-container .icon.rejected:before {
            content: url("https://cdn.dsmcdn.com/web/production/rejected.svg");
        }

        #orders-container .icon.un_delivered:before,
        #orders-container .icon.undelivered_defective:before,
        #orders-container .icon.uncompleted_assembly:before {
            content: url("https://cdn.dsmcdn.com/web/production/undelivered-icon.svg");
        }

        #orders-container .icon.returned:before,
        #orders-container .icon.returned_defective:before {
            content: url("https://cdn.dsmcdn.com/web/production/returned.svg");
        }

        #orders-container .icon.cancel:before {
            content: url("https://cdn.dsmcdn.com/web/production/cancel-icon.svg");
        }

        #orders-container .icon.payment_failed:before {
            content: url("https://cdn.dsmcdn.com/web/production/cancel-icon.svg");
        }

        #orders-container .icon.accepted:before {
            content: url("https://cdn.dsmcdn.com/web/production/accepted.svg");
        }

        #orders-container .icon.created_inbound:before {
            content: url("https://cdn.dsmcdn.com/web/production/createdinbound.svg");
        }

        #orders-container .icon.az_shipped:before,
        #orders-container .icon.shipped:before,
        #orders-container .icon.shipped_defective:before {
            content: url("https://cdn.dsmcdn.com/web/production/shipped.svg");
        }

        #orders-container .icon.waiting_in_action:before {
            content: url("https://cdn.dsmcdn.com/web/production/waitinginaction.svg");
        }

        #orders-container .icon.shipped_inbound:before {
            content: url("https://cdn.dsmcdn.com/web/production/shipped-in-bound.svg");
        }

        #orders-container .icon.preparing:before,
        #orders-container .icon.preparing_defective:before {
            content: url("https://cdn.dsmcdn.com/web/production/preparing.svg");
        }

        #orders-container .icon.at_collection_point:before,
        #orders-container .icon.at_collection_point_defective:before {
            content: url("https://cdn.dsmcdn.com/web/production/at-collection-point.svg");
        }

        #orders-container .icon.az_at_collection_point:before {
            content: url("https://cdn.dsmcdn.com/web/production/delivered.svg");
        }

        #orders-container .icon.replacement_request_created:before {
            content: url("https://cdn.dsmcdn.com/web/production/replacementrequestcreated.svg");
        }

        #orders-container .icon.replacement_request_shipped:before {
            content: url("https://cdn.dsmcdn.com/web/production/replacementrequestshipped.svg");
        }

        #orders-container .icon.replacement_request_waiting:before {
            content: url("https://cdn.dsmcdn.com/web/production/replacementrequestwaiting.svg");
        }

        #orders-container .icon.replacement_accepted:before {
            content: url("https://cdn.dsmcdn.com/web/production/replacementaccepted.svg");
        }

        #orders-container .icon.replacement_rejected:before {
            content: url("https://cdn.dsmcdn.com/web/production/replacementrejected.svg");
        }

        #orders-container .photo-gallery img {
            max-height: 90vh;
        }

        #orders-container .photo-gallery a {
            position: absolute;
            height: 50px;
            top: calc(50% - 25px);
            width: 50px;
            left: -50px;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0.6;
        }

        #orders-container .photo-gallery a:hover {
            opacity: 1;
        }

        #orders-container .photo-gallery a.next {
            left: auto;
            right: -50px;
        }

        #orders-container .empty-order-search-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 445px;
            border-radius: 3px;
            border: solid 1px #e2e2e2;
            background-color: #ffffff;
            flex-direction: column;
            line-height: 30px;
        }

        #orders-container .empty-order-search-container .ty-button {
            width: 210px;
            height: 44px;
            margin: 20px;
            border-radius: 6px;
            background-color: #EA2B2E;
            font-size: 12px;
            font-weight: 600;
        }

        #orders-container .empty-order-search-container .eos-icon {
            width: 94px;
            height: 94px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #fff4ec;
            font-size: 40px;
            color: #EA2B2E;
            margin-bottom: 10px;
        }

        #orders-container .empty-order-search-container .eos-title {
            font-size: 20px;
            font-weight: 600;
            color: #000000;
        }

        #orders-container .empty-order-search-container .eos-desc {
            font-size: 16px;
            font-weight: normal;
            color: #000000;
        }

        #orders-container .empty-order-search-container .eos-desc .highlighted {
            font-weight: 600;
        }

        #orders-container .order-search-info {
            margin: 0 0 15px 20px;
            font-size: 12px;
            color: #2a2a2a;
        }

        #orders-container .order-search-info .highlighted {
            font-weight: 600;
        }

        #orders-container .tooltip {
            position: relative;
        }

        #orders-container .tooltip .tooltip-content {
            position: absolute;
            bottom: -100%;
            left: 50%;
            transform: translateX(-50%);
            min-width: 12em;
            border-radius: 3px;
            z-index: 2;
            width: 100%;
            box-sizing: border-box;
            border: solid 1px #ffcfcf;
            background-color: #fff9f9;
        }

        #orders-container .tooltip .tooltip-content:after {
            content: '';
            position: absolute;
            width: 0;
            height: 0;
            left: 10%;
            z-index: -1;
            border-style: solid;
            border-width: 5px;
            border-color: #fff9f9 transparent transparent transparent;
            filter: drop-shadow(0 1px 0 #ffcfcf);
            transform: translateX(-50%) rotate(180deg);
            transition: bottom 300ms ease;
        }

        #orders-container .tooltip.is-visible .tooltip-content {
            transform: translateY(0%) translateX(-50%);
            opacity: 1;
            visibility: visible;
            transition: transform 300ms ease, opacity 300ms, visibility 300ms 0s;
        }

        #orders-container .tooltip.is-visible .tooltip-content:after {
            bottom: 100%;
        }

        #orders-container .tooltip.is-hidden .tooltip-content {
            transform: translateY(0%) translateX(-50%);
            opacity: 0;
            visibility: hidden;
            transition: transform 300ms ease, opacity 300ms, visibility 300ms 300ms;
        }

        #orders-container .tooltip.is-hidden .tooltip-content:after {
            bottom: 0;
        }

        @keyframes fade {
            0% {
                top: 0;
                opacity: 1;
            }

            100% {
                top: -1em;
                opacity: 0;
            }
        }

        #orders-container .orders-collection-point-description {
            margin: 15px 20px 0 20px;
        }

        #orders-container .orders-collection-point-description .delivery-point-desc {
            font-size: 12px;
            font-weight: 400;
            letter-spacing: -0.1px;
            color: #333333;
            display: flex;
            align-items: center;
        }

        #orders-container .orders-collection-point-description .highlighted-text {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 24px;
            background-color: #FEF4EC;
            color: #F27A1A;
            font-size: 12px;
            font-family: source_sans_prosemibold, sans-serif;
            border-top-right-radius: 2px;
            border-bottom-right-radius: 2px;
            padding-right: 6px;
            margin-right: 6px;
        }

        #orders-container .orders-collection-point-description .i-collection-point-orders {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 24px;
            background-color: #FEF4EC;
            color: #EA2B2E;
            border-top-left-radius: 2px;
            border-bottom-left-radius: 2px;
            padding: 0 6px;
            margin-left: 6px;
        }

        #orders-container .orders-collection-point-description .otp-code-description {
            margin-left: 5px;
            font-family: source_sans_prosemibold, sans-serif;
        }

        #orders-container .orders-collection-point-description .otp-code-description .otp-number {
            font-family: source_sans_prosemibold, sans-serif;
            color: #F27A1A;
        }

        #orders-container .collection-point-information-banner {
            display: flex;
            align-items: center;
            background: #FEF4EC;
            border-radius: 4px;
            height: 48px;
            box-sizing: border-box;
            margin-top: 15px;
        }

        #orders-container .collection-point-information-banner .collection-point-information {
            font-size: 12px;
            color: #333333;
        }

        #orders-container .collection-point-information-banner .collection-point-information strong {
            font-family: source_sans_prosemibold, sans-serif;
        }

        #orders-container .collection-point-information-banner .i-warning1-fill {
            font-size: 16px;
            padding-bottom: 1px;
            margin: 0 15px 0 20px;
        }

        #orders-container .collection-point-information-banner .i-warning1-fill .path1::before {
            color: #F27A1A;
        }

        #orders-container .no-order-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 445px;
            border-radius: 6px;
            border: solid 1px #e2e2e2;
            background-color: #ffffff;
            flex-direction: column;
            line-height: 30px;
        }

        #orders-container .no-order-container .ty-button {
            width: 210px;
            height: 44px;
            margin: 20px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        #orders-container .no-order-container .no-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #fff4ec;
            font-size: 32px;
            color: #EA2B2E;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        #orders-container .no-order-container .no-title {
            font-size: 20px;
            font-weight: 600;
            color: #EA2B2E;
        }

        #orders-container .no-order-container .no-desc {
            font-size: 16px;
            font-weight: normal;
            color: #666;
        }

        #orders-container .status-quick-filters-wrapper .sticky {
            top: 0;
        }

        #orders-container .status-quick-filters-wrapper .scrolled {
            position: fixed;
            box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.05);
            border: solid 1px #e6e6e6;
            z-index: 999;
        }

        #orders-container .status-quick-filters-wrapper .scrolled .status-quick-filter-tabs-wrapper {
            border-bottom: 1px solid #e6e6e6;
            box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.05);
            background-color: #fff;
            padding: 20px 0 20px 20px;
        }

        #orders-container .status-quick-filters-wrapper .status-quick-filter-tabs-wrapper {
            display: flex;
            align-items: center;
            padding-bottom: 20px;
            padding-left: 20px;
        }

        #orders-container .status-quick-filters-wrapper .status-quick-filter-tabs-wrapper .filter-tab {
            padding: 9px 11px;
            border-radius: 8px;
            box-sizing: border-box;
            box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.05), 0px 0px 0px 1px #e6e6e6;
            border: 2px solid transparent;
            color: #333333;
            font-family: source_sans_prosemibold, sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.4s ease;
            margin-right: 10px;
        }

        #orders-container .status-quick-filters-wrapper .status-quick-filter-tabs-wrapper .filter-tab:hover,
        #orders-container .status-quick-filters-wrapper .status-quick-filter-tabs-wrapper .filter-tab.active {
            border-color: #EA2B2E;
            color: #EA2B2E;
            box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.05);
        }

        #orders-container .countdown {
            display: flex;
            flex-direction: column;
            width: 125px;
            align-items: center;
        }

        #orders-container .countdown .title {
            color: #fff;
            font-size: 10px;
            
            align-self: center;
            margin-bottom: 4px;
        }

        #orders-container .countdown .times {
            display: flex;
            align-items: center;
        }

        #orders-container .countdown .times .break {
            color: #fff;
            margin: 0 4px 0 4px;
        }

        #orders-container .countdown .times .time {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            background: #fff;
            border-radius: 2px;
            font-family: source_sans_prosemibold, sans-serif;
            -webkit-font-smoothing: antialiased;
            font-style: normal;
            font-weight: 700;
            font-size: 18px;
        }

        #orders-container .group-deal-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(90deg, #0BC15C -54.18%, #84B3EC 106.8%);
            border-radius: 4px;
            height: 86px;
            padding: 20px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        #orders-container .group-deal-info .gdi-details {
            display: flex;
        }

        #orders-container .group-deal-info .gdi-details i {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            color: #008040;
            font-size: 10px;
            border-radius: 50%;
            width: 20px;
            height: 20px;
        }

        #orders-container .group-deal-info .gdi-details .gdi-d-content {
            display: flex;
            flex-direction: column;
            margin-left: 10px;
        }

        #orders-container .group-deal-info .gdi-details .gdi-d-content div {
            color: #fff;
            font-family: source_sans_proregular, sans-serif;
        }

        #orders-container .group-deal-info .gdi-details .gdi-d-content div.gdi-d-c-title {
            font-size: 16px;
            margin-bottom: 4px;
        }

        #orders-container .group-deal-info .gdi-details .gdi-d-content div.gdi-d-c-details {
            font-size: 12px;
        }

        #orders-container .group-deal-info .gdi-details .gdi-d-content div.gdi-d-c-details span {
            font-family: source_sans_prosemibold, sans-serif;
            font-weight: 600;
            -webkit-font-smoothing: antialiased;
        }

        #orders-container .group-deal-share-modal {
            width: 445px;
            font-family: source_sans_proregular, sans-serif;
            color: #333;
            border-radius: 4px;
        }

        #orders-container .group-deal-share-modal .gd-sm-header {
            padding: 20px;
            border-bottom: 1px solid #e6e6e6;
        }

        #orders-container .group-deal-share-modal .gd-sm-header h1 {
            width: 300px;
            margin: 0 auto;
            font-size: 18px;
            font-weight: 600;
            text-align: center;
        }

        #orders-container .group-deal-share-modal .gd-sm-content {
            padding: 0 20px 20px;
        }

        #orders-container .gd-share-description-item {
            display: flex;
            margin-top: 30px;
        }

        #orders-container .gd-share-description-item .gd-sdi-icon {
            display: flex;
            width: 48px;
            height: 48px;
            justify-content: center;
            align-items: center;
            flex-shrink: 0;
            border-radius: 50%;
            background-color: #effbf5;
        }

        #orders-container .gd-share-description-item .gd-sdi-icon i {
            font-size: 24px;
            font-style: normal;
        }

        #orders-container .gd-share-description-item .gd-sdi-icon i:before {
            color: #008040;
        }

        #orders-container .gd-share-description-item .gd-sdi-description-container {
            margin-left: 12px;
        }

        #orders-container .gd-share-description-item .gd-sdi-description-container h2 {
            font-size: 16px;
            font-weight: 600;
        }

        #orders-container .gd-share-description-item .gd-sdi-description-container p {
            margin-top: 6px;
            font-size: 12px;
        }

        #orders-container .gd-copy-link-box {
            margin-top: 30px;
            padding: 12px;
            border-radius: 4px;
            background-color: #f5f5f5;
        }

        #orders-container .gd-copy-link-box .gd-cp-lb-container {
            display: flex;
            height: 42px;
            padding: 0 10px 0 15px;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e6e6e6;
            border-radius: 3px;
            background-color: #fff;
        }

        #orders-container .gd-copy-link-box .gd-cp-lb-container>span {
            display: block;
            max-width: 278px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 12px;
            flex-shrink: 0;
        }

        #orders-container .gd-copy-link-box .gd-cp-lb-container button {
            padding: 0;
            align-self: stretch;
            border: none;
            outline: none;
            background-color: transparent;
            color: #1f6bc1;
            cursor: pointer;
        }

        #orders-container .gd-copy-link-box .gd-cp-lb-container button .i-copy-filled {
            font-size: 18px;
            vertical-align: middle;
        }

        #orders-container .gd-copy-link-box .gd-cp-lb-container button span {
            font-size: 12px;
            font-weight: 600;
            margin-left: 5px;
        }

        #orders-container .gd-copy-link-box .gd-cp-lb-container .i-check {
            font-size: 18px;
        }

        #orders-container .gd-copy-link-box .gd-cp-lb-container .i-check i {
            font-style: normal;
        }

        #orders-container .gd-copy-link-box .gd-cp-lb-container .i-check i.path1:before {
            color: #0BC15C;
        }

        #orders-container .gd-social-share-box {
            margin-top: 10px;
            padding: 19px 25px;
            display: flex;
            justify-content: space-between;
            border: 1px solid #e6e6e6;
            border-radius: 4px;
        }

        #orders-container .gd-social-share-box button {
            padding: 0;
            border: none;
            outline: none;
            background-color: transparent;
            cursor: pointer;
        }

        #orders-container .gd-social-share-box button i {
            font-style: normal;
        }

        #orders-container .gd-social-share-box button span {
            font-size: 32px;
        }

        #orders-container .gd-social-share-box button span.i-gmail {
            font-size: 24px;
        }

        #orders-container .gd-social-share-box .separator {
            width: 1px;
            background-color: #e6e6e6;
        }

        #orders-container .cobranded-card-offer-information {
            min-height: 54px;
            background: linear-gradient(94.54deg, #FFE6D8 0%, #FFFAF8 100%);
            border-radius: 8px;
            padding: 12px 50px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        #orders-container .cobranded-card-offer-information>img {
            border-radius: 4px;
            width: 110px;
            height: 70px;
            margin-right: 40px;
        }

        #orders-container .cobranded-card-offer-information .offer-information-text-wrapper {
            min-height: 70px;
            flex: 1;
        }

        #orders-container .cobranded-card-offer-information .offer-information-text-wrapper h4 {
            margin-bottom: 6px;
            font-family: source_sans_proregular, sans-serif;
            font-weight: 600;
            -webkit-font-smoothing: antialiased;
            font-size: 20px;
            line-height: 26px;
            color: #333333;
        }

        #orders-container .cobranded-card-offer-information .offer-information-text-wrapper .information-bullets {
            display: flex;
            flex-wrap: wrap;
            column-gap: 24px;
            row-gap: 6px;
        }

        #orders-container .cobranded-card-offer-information .offer-information-text-wrapper .information-bullets li {
            display: flex;
            align-items: center;
        }

        #orders-container .cobranded-card-offer-information .offer-information-text-wrapper .information-bullets li>i {
            font-size: 12px;
            margin-right: 6px;
        }

        #orders-container .cobranded-card-offer-information .offer-information-text-wrapper .information-bullets li>i>span.path1::before {
            color: #EA2B2E;
        }

        #orders-container .cobranded-card-offer-information .offer-information-text-wrapper .information-bullets li>p {
            font-family: source_sans_proregular, sans-serif;
            font-style: normal;
            font-size: 12px;
            line-height: 16px;
            color: #1C1C1C;
        }

        #orders-container .cobranded-card-offer-information .offer-information-text-wrapper .information-bullets li>p>strong {
            color: #F27A1A;
        }

        #orders-container .cobranded-card-offer-information>.apply-button {
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 200px;
            height: 28px;
            box-sizing: border-box;
            background: #EA2B2E;
            border-radius: 4px;
            padding: 8px;
            transition: 0.3s ease-in;
        }

        #orders-container .cobranded-card-offer-information>.apply-button>p {
            margin-top: 1px;
            font-family: source_sans_proregular, sans-serif;
            font-weight: 600;
            -webkit-font-smoothing: antialiased;
            font-size: 12px;
            line-height: 16px;
            color: #ffffff;
        }

        #orders-container .cobranded-card-offer-information>.apply-button:hover {
            background-color: #ff8b38;
        }

        #orders-container .page-loader {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 400px;
        }

        .ty-scroll-disabled-body {
            overflow: hidden;
            position: absolute;
        }

        .type-tag {
            background: #EA2B2E !important;
            right: 15px;
            text-align: center;
            width: 60px !important;
            margin-top: 15px;
            position: absolute;
        }
    </style>
@endsection
