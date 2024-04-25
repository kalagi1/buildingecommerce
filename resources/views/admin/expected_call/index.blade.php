@extends('admin.layouts.master')

@section('content')
<div class="content" >
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
    <div   class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white border-top border-bottom border-200 position-relative top-1">
        <div class="table-responsive scrollbar mx-n1 px-1">
            <table class="table table-sm fs--1 mb-0">
                <thead>
                    <tr>
                        <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                            data-sort="order_no"> No</th>
                        <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                            data-sort="order_date" style="width: 18%">Ad Soyad</th>
                        <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                            data-sort="customer" style="width: 10%">Cep Telefonu</th>
                        <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                            data-sort="sales_person">Şehir</th>
                        <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                            data-sort="order_amount" style="width: 18%">Vergi No</th>
                        <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                            data-sort="pay_type" style="width: 18%">Ticari Unvan</th>   
                        <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                            data-sort="pay_type" style="width: 18%">Belgeler</th> 
                        <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                            data-sort="order_status">
                            Onay Ver</th>
                    </tr>
                </thead>
                <tbody class="list" id="order-table-body">

                    @if ($expectedCall->count() > 0)
                        @foreach ($expectedCall as $item)
                        
                            <tr  class="table">

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
                                    @if($item->city)
                                        {{ $item->city->title }}
                                    @else
                                        Şehir Bulunamadı
                                    @endif
                                </td>
                                

                                <td class="order_amount align-middle fw-semibold text-body-highlight">
                                        {{ $item->taxNumber }}
                                </td>

                                <td class="order_amount align-middle  fw-semibold text-body-highlight">
                                    {{$item->store_name}}
                                </td>
                                
                                <td class="order_amount align-middle  fw-semibold text-body-highlight">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#documentsModal{{$item->id}}">
                                        Belgeler
                                      </button>
                                </td>

                                <td class="order_amount align-middle fw-semibold text-body-highlight">
                                    @if($item->company_document_approve == 0)
                                        <a href="{{ route('institutional.give.approval', ['id' => $item->id]) }} " class="btn btn-success onayVer btn-sm">Onayla</a><br>
                                    @endif
                                </td>                                          


                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="documentsModal{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="text-center" style="font-weight: 400;" id="exampleModalLabel">Gerekli Evraklar</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @if($item->tax_document)
                                            <p>Vergi Belgesi: <a href="{{ $item->tax_document }}" style="color:rgba(0, 60, 255, 0.747);" target="_blank" download>Vergi Belgesini İndir</a></p>
                                        @else
                                            <p>Vergi Belgesi: Belge Bulunamadı</p>
                                        @endif
                                        @if($item->identity_document)
                                            <p>Kimlik Belgesi: <a href="{{ $item->identity_document }}" style="color:rgba(0, 60, 255, 0.747);" target="_blank" download>Kimlik Belgesini İndir</a></p>
                                        @else
                                            <p>Kimlik Belgesi: Belge Bulunamadı</p>
                                        @endif
                                        @if($item->record_document)
                                        <p>Sicil Belgesi: <a href="{{ $item->record_document }}" style="color:rgba(0, 60, 255, 0.747);" target="_blank" download>Sicil Belgesini İndir</a></p>
                                        @else
                                            <p>Vergi Belgesi: Belge Bulunamadı</p>
                                        @endif
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                    </div>
                                </div>
                                </div>
                            </div>
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
    $(document).ready(function() {
        $('.btn-primary').click(function() {
            var orderId = $(this).closest('tr').find('.order_no').text();
            var modalBody = $('#documentsModal' + orderId + ' .modal-body');
            // Ajax isteği ile belgeleri al
            $.ajax({
                url: '/getDocuments/' + orderId, // Belge bilgilerini getiren bir rotaya yönlendirin
                type: 'GET',
                success: function(response) {
                    modalBody.html(response); // Modal içeriğine belgeleri ekle
                }
            });
        });
    });
</script>

@endsection