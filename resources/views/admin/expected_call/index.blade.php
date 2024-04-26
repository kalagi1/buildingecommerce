@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="col-auto">
            <h3 class="mb-3">Rol Değişikliği Talepleri (Bireysel => Kurumsal)</h3>
        </div>
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-warning" role="alert">
                {{ Session::get('error') }}
            </div>
        @endif
        <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white border-top border-bottom border-200 position-relative top-1">
            <div class="table-responsive scrollbar mx-n1 px-1">
                <table class="table table-sm fs--1 mb-0">
                    <thead>
                        <tr>
                            <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_no"
                                style="width: 3%"> No</th>
                            <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_date"
                                style="width: 15%">Ad Soyad</th>
                            <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="customer"
                                style="width: 10%">Cep Telefonu</th>
                            <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="sales_person">
                                Şehir</th>
                            <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_amount"
                                style="width: 18%">Vergi No</th>
                            <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="pay_type"
                                style="width: 18%">Ticari Unvan</th>
                            <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="pay_type"
                                style="width: 18%">Bilgileri Önizle</th>
                            <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_status">
                                Onay/Red</th>
                            <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_status">
                                Durum</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="order-table-body">

                        @if ($expectedCall->count() > 0)
                            @foreach ($expectedCall as $item)
                                <tr class="table">

                                    <td class="order_no align-middle  fw-semibold text-body-highlight">
                                        {{ $item->id }}
                                    </td>

                                    <td class="order_date align-middle white-space-nowrap text-body-tertiary  text-wrap">
                                        {{ $item->name }}
                                    </td>

                                    <td class="ad_no align-middle  fw-semibold text-body-highlight">
                                        {{ $item->mobile_phone }}
                                    </td>

                                    <td class="customer align-middle white-space-nowrap">
                                        @if ($item->city_id)
                                            {{ $item->city->title }}
                                        @else
                                            Şehir Bulunamadı
                                        @endif
                                    </td>


                                    <td class="order_amount align-middle fw-semibold text-body-highlight">
                                        {{ $item->taxNumber }}
                                    </td>

                                    <td class="order_amount align-middle  fw-semibold text-body-highlight">
                                        {{ $item->store_name }}
                                    </td>

                                    <td class="order_amount align-middle  fw-semibold text-body-highlight">
                                        <button type="button" class="badge badge-phoenix fs--2 badge-phoenix-info"
                                            data-bs-toggle="modal" data-bs-target="#onizlemeModal{{ $item->id }}">
                                            Bilgileri Önizle
                                        </button>
                                    </td>

                                    <td class="order_amount align-middle fw-semibold text-body-highlight">
                                        @if ($item->status == 0)
                                            <a href="{{ route('admin.institutional.give.approval', ['user_id' => $item->user_id]) }} "
                                                class="badge badge-phoenix fs--7 badge-phoenix-success"
                                                style="padding: 5px 45px 5px 45px;">
                                                Onayla</a><br>
                                            <a href="{{ route('admin.institutional.reject', ['user_id' => $item->user_id]) }} "
                                                class="badge badge-phoenix fs--4 badge-phoenix-danger"
                                                style="padding: 5px 45px 5px 45px;margin-top:5px;">Reddet</a><br>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="customer align-middle white-space-nowrap">
                                        @if ($item->status == 0)
                                            <span class="badge badge-phoenix fs--2 badge-phoenix-warning">Beklemede</span>
                                        @elseif($item->status == 1)
                                            <span class="badge badge-phoenix fs--2 badge-phoenix-success">Onaylandı</span>
                                        @elseif($item->status == 2)
                                            <span class="badge badge-phoenix fs--2 badge-phoenix-danger">Reddedildi</span>
                                        @endif
                                    </td>

                                    <!--önizleme Modal -->
                                    <div class="modal fade" id="onizlemeModal{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">{{ $item->id }}
                                                        numaralı önizleme</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p><strong>Yetkili İsim Soyisim:</strong> {{ $item->username }}
                                                            </p>
                                                            <p><strong>Mağaza Adı:</strong> {{ $item->name }}</p>
                                                            <p><strong>Ticari Unvan:</strong> {{ $item->store_name }}</p>
                                                            <p><strong>Sabit Telefon:</strong> {{ $item->phone }}</p>
                                                            <p><strong>Kurumsal Hesap Türü:</strong>
                                                                {{ $item->corporate_account_type }}</p>
                                                            <p><strong>İl:</strong> {{ $item->city->title }}</p>
                                                            <!-- İl title değeri -->
                                                            <p><strong>İlçe:</strong> {{ $item->county->title }}</p>
                                                            <!-- İlçe title değeri -->
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><strong>Mahalle:</strong>
                                                                {{ $item->neighborhood->mahalle_title }}</p>
                                                            <!-- Mahalle title değeri -->
                                                            <p><strong>İşletme Türü:</strong> {{ $item->account_type }}</p>
                                                            <p><strong>Vergi Dairesi İl:</strong> {{ $item->city->title }}
                                                            </p>
                                                            <p><strong>Vergi Dairesi:</strong> {{ $item->office->daire }}
                                                            </p>
                                                            <p><strong>Vergi No:</strong>{{ $item->taxNumber }}</p>
                                                            <p><strong>TC:</strong> {{ $item->idNumber }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Kapat</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="text-center">Kayıt Bulunamadı</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        // Onay ver butonuna tıklandığında
        $('.onayVer').on('click', function(e) {
            e.preventDefault(); // varsayılan davranışı engelle (form gönderme gibi)

            // SweetAlert ile onay mesajı göster
            Swal.fire({
                title: 'Onay Ver',
                text: "Onay vermek istediğinize emin misiniz?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Evet',
                cancelButtonText: 'Hayır'
            }).then((result) => {
                // Kullanıcı Evet'i seçtiyse
                if (result.isConfirmed) {
                    // Onaylama işlemi için ilgili rotaya git
                    window.location.href = $(this).attr('href');
                }
            });
        });
    </script>
    <script>
        // red ver butonuna tıklandığında
        $('.redVer').on('click', function(e) {
            e.preventDefault(); // varsayılan davranışı engelle (form gönderme gibi)

            // SweetAlert ile onay mesajı göster
            Swal.fire({
                title: 'Reddet',
                text: "Başvuruyu reddetmek istediğinize emin misiniz?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Evet',
                cancelButtonText: 'Hayır'
            }).then((result) => {
                // Kullanıcı Evet'i seçtiyse
                if (result.isConfirmed) {
                    // Onaylama işlemi için ilgili rotaya git
                    window.location.href = $(this).attr('href');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.btn-primary').click(function() {
                var orderId = $(this).closest('tr').find('.order_no').text();
                var modalBody = $('#documentsModal' + orderId + ' .modal-body');
                // Ajax isteği ile belgeleri al
                $.ajax({
                    url: '/getDocuments/' +
                        orderId, // Belge bilgilerini getiren bir rotaya yönlendirin
                    type: 'GET',
                    success: function(response) {
                        modalBody.html(response); // Modal içeriğine belgeleri ekle
                    }
                });
            });
        });
    </script>

@endsection

@section('styles')
    <style>
        .tableHeader {
            background-color: #343a40;
            color: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            letter-spacing: 1px;
            margin-left: 5px;
            margin-bottom: 35px;
        }
    </style>
