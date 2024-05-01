@extends('admin.layouts.master')

@section('content')
<div class="content" >
    <h4 class="tableHeader" style="">Kurumsal Onay Süreci</h4>
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
                        <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                            data-sort="order_no" style="width: 3%"> No</th>
                            <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                            data-sort="order_date" >Mağaza Adı</th>
                        <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                            data-sort="order_date" >Yetkili İsim Soyisim</th>
                        <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                            data-sort="order_date" >Cep Telefonu</th>
                        <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                            data-sort="order_date" >Sabit Telefonu</th>              
                        <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                            data-sort="order_date" >Email Doğrulaması</th>
                        <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                            data-sort="customer">Cep Telefonu Doğrulaması</th>
                        <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                            data-sort="sales_person">Belge Doğrulaması</th>
                        <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                            data-sort="order_amount" style="width: 18%">Arandı Mı ?</th>
                        {{-- <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                            data-sort="order_status">Durum</th> --}}
                    </tr>
                </thead>
                <tbody class="list" id="order-table-body">

                    @if ($users->count() > 0)
                        @foreach ($users as $item)
                        
                            <tr  class="table">

                                <td class="order_no align-middle  fw-semibold text-body-highlight">
                                    {{ $item->id }}
                                </td>

                                <td class="order_no align-middle  fw-semibold text-body-highlight">
                                    {{ $item->name }} <br>
                                    @if($item->email_verified_at && $item->phone_verification_status == 1 && $item->is_show_files == 1)
                                        <a href="{{route('admin.user.show-corporate-account',['user' => $item->id])}}" class="badge badge-phoenix fs--2 badge-phoenix-success ">Belgeleri Görüntüle</a>
                                    @endif
                                </td>

                                <td class="order_no align-middle  fw-semibold text-body-highlight">
                                    {{ $item->username }}
                                </td>
                                <td class="order_no align-middle  fw-semibold text-body-highlight">
                                    @if($item->mobile_phone)
                                        <a href="tel:{{ $item->mobile_phone }}" class="badge badge-phoenix fs--2 badge-phoenix-info">{{ $item->mobile_phone }}</a>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td class="order_no align-middle  fw-semibold text-body-highlight">
                                    @if($item->phone)
                                        <a class="badge badge-phoenix fs--2 badge-phoenix-info">{{ $item->phone }}</a>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td class="order_date align-middle white-space-nowrap text-body-tertiary  text-wrap">
                                    @if($item->email_verified_at == null)
                                        <a href="{{route('admin.mail.verification', ['id' => $item->id])}}" class="badge badge-phoenix fs--2 badge-phoenix-warning">Doğrulama Linki Gönder</a>
                                    @else
                                    <a href="#" class="badge badge-phoenix fs--2 badge-phoenix-success">Doğrulanmış</a>

                                    @endif
                                </td>

                                <td class="ad_no align-middle  fw-semibold text-body-highlight">
                                    @if($item->phone_verification_status == 0)
                                        <a href="#" class="badge badge-phoenix fs--2 badge-phoenix-warning">Doğrulanmamış</a>
                                    @else
                                        <a href="#" class="badge badge-phoenix fs--2 badge-phoenix-success">Doğrulanmış</a>
                                    @endif
                                </td>
                                

                                <td class="order_amount align-middle fw-semibold text-body-highlight">
                                        @if( ($item->email_verified_at) && $item->phone_verification_status == 1 )
                                            @if($item->corporate_account_status == 0)
                                                @if($item->is_show_files == 0)
                                                    <a href="{{route('admin.document.load.page',['id' => $item->id])}}" class="badge badge-phoenix fs--2 badge-phoenix-info belgeYuklemeEkrani">Belge Yükleme Ekranı Göster</a>
                                                @else
                                                    <a href="#" class="badge badge-phoenix fs--2 badge-phoenix-success ">Belge Yükleme Ekranına Yönlendirildi</a><br>
                                                    {{-- <a href="{{route('admin.user.show-corporate-account',['user' => $item->id])}}" class="badge badge-phoenix fs--2 badge-phoenix-success ">Belgeleri Görüntüle</a> --}}

                                                @endif
                                            @endif
                                        @else
                                            @if(($item->email_verified_at) && $item->phone_verification_status == 0)
                                                <span class="badge badge-phoenix fs--2 badge-phoenix-danger">Telefon Doğrulaması yapılmadı</span>  
                                            @endif
                                            @if(($item->email_verified_at == null) && $item->phone_verification_status == 0)
                                                <span class="badge badge-phoenix fs--2 badge-phoenix-danger">Email ve Telefon Doğrulaması yapılmadı</span>  
                                            @endif
                                          {{-- <span class="badge badge-phoenix fs--2 badge-phoenix-danger">Email ve Telefon Doğrulaması yapılmadı</span>   --}}
                                        @endif
                                </td>

                                <td class="order_amount align-middle  fw-semibold text-body-highlight">
                                    @if($item->is_called == 1)
                                        <a href="#" class="badge badge-phoenix fs--2 badge-phoenix-success">Arandı</a>
                                    @else
                                        <a href="{{route('admin.searched',['id' => $item->id])}}" class="badge badge-phoenix fs--2 badge-phoenix-warning isCalled">Aranacak</a>    
                                    @endif
                                </td>               
                                
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).ready(function() {
    $('.belgeYuklemeEkrani').click(function(e) {
        e.preventDefault();
        
        var url = $(this).attr('href');
        
        swal({
            title: "Emin misiniz?",
            text: "Kullanıcı belge yükleme ekranına yönlendirilsin mi?",
            icon: "warning",
            buttons: ["Vazgeç", "Eminim"],
            dangerMode: true,
            closeOnClickOutside: false,
            closeOnEsc: false,
        }).then((willMarkAsSearched) => {
            if (willMarkAsSearched) {
                window.location.href = url; 
              
                swal("Başarılı!", "Kullanıcı belge yükleme alanına başarıyla yönlendirildi.", "success");
            } else {
                swal("İşlem iptal edildi.", {
                    icon: "error",
                });
            }
        });
    });
});

</script>
<script>
    $(document).ready(function() {
        $('.isCalled').click(function(e) {
            e.preventDefault();
            
            var url = $(this).attr('href');
            
            swal({
                title: "Emin misiniz?",
                text: "Kullanıcı arandı olarak işaretlensin mi ?",
                icon: "warning",
                buttons: ["Vazgeç", "Eminim"],
                dangerMode: true,
                closeOnClickOutside: false,
                closeOnEsc: false,
            })
            .then((willMarkAsSearched) => {
                if (willMarkAsSearched) {
                    window.location.href = url; // SweetAlert onaylandıktan sonra doğrudan yönlendirme yap
                } else {
                    swal("İşlem iptal edildi.", {
                        icon: "error",
                    });
                }
            });
        });
    });
</script>

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

@section('styles')
<style>
    .tableHeader{
        padding: 10px; 
        border-radius: 5px; 
        letter-spacing:1px;
        margin-left: 5px;
        margin-bottom: 35px;
    }
    .badge-phoenix{
        padding:  7px 40px 7px 40px !important; 
        font-size: 12px !important;
        letter-spacing: 1.5px;
    }
</style>