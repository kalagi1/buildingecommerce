@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="mt-4">
            @if (session()->has('success'))
                <div class="alert alert-success text-white">
                    {{ session()->get('success') }}
                </div>
            @endif
            <div class="row g-4">
                <div class="col-12 col-xl-12  order-1 order-xl-0">
                    <h2 class=" lh-sm">Sat Kirala Form Verileri</h2>

                    <div class="mb-9">
                        <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                            <div class="card-body p-0">
                                <div class="p-4 code-to-copy">
                                    <div id="tableExample"
                                        data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
                                        <div class="table-responsive mx-n1 px-1">
                                            <table class="table table-sm border-top border-200 fs--1 mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>İsim Soyisim</th>
                                                        <th>Telefon</th>
                                                        <th>E-Posta</th>
                                                        <th>İstenilen Fiyat</th>
                                                        <th>Yapı Tipi</th>
                                                        <th>M2 Net</th>
                                                        <th>M2 Brüt</th>
                                                        <th>Oda Salon</th>
                                                        <th>Adres</th>
                                                        <th>Görüntülenme Durumu</th>
                                                        <th>Yetkilendirme Durumu</th>
                                                        <th>İşlemler</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($realEstates as $key => $realEstate)
                                                        <tr>
                                                            <td>{{ $realEstate->id }}</td>
                                                            <td>{{ $realEstate->name }}</td>
                                                            <td>{{ $realEstate->phone }}</td>
                                                            <td>{{ $realEstate->email }}</td>
                                                            <td>{{ $realEstate->istenilen_fiyat }}</td>
                                                            <td>{{ $realEstate->yapi_tipi }}</td>
                                                            <td>{{ $realEstate->m2_net }}</td>
                                                            <td>{{ $realEstate->m2_brut }}</td>
                                                            <td>{{ $realEstate->oda_salon }}</td>
                                                            <td>{{ $realEstate->adres }}</td>
                                                            <td>@if($realEstate->is_show) <span class="badge badge-phoenix badge-phoenix-success">Görüntülendi</span> @else <span class="badge badge-phoenix badge-phoenix-danger">Görüntülenmedi</span> @endif</td>
                                                            <td>
                                                                @if($realEstate->authorization_status == 1)
                                                                    <span class="badge badge-phoenix badge-phoenix-success">Yetki Verildi</span>
                                                                @else
                                                                  <a href="{{route('admin.sat.kirala.yetki.ver',['id' => $realEstate->id])}}" class="yetkiVerBtn">  <span class="badge badge-phoenix badge-phoenix-info">Yetki Ver</span> </a>
                                                                @endif
                                                            </td>
                                                            <td><a href="{{route('admin.real.estate.detail',$realEstate->id)}}" class="badge badge-phoenix badge-phoenix-info"><i class="fa fa-eye"></i></a></td>
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
                </div>

            </div>
        </div>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
            <div class="toast align-items-center text-white bg-dark border-0 light" id="icon-copied-toast" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body p-3"></div><button class="btn-close btn-close-white me-2 m-auto" type="button"
                        data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).ready(function() {
    $('.yetkiVerBtn').click(function(e) {
        e.preventDefault();
        
        var url = $(this).attr('href');
        
        swal({
            title: "Yetki verilsin mi?",
            text: "Yetki vermek istediğinize emin misiniz?",
            icon: "warning",
            buttons: ["Vazgeç", "Evet"],
            dangerMode: true,
            closeOnClickOutside: false,
            closeOnEsc: false,
        }).then((willMarkAsSearched) => {
            if (willMarkAsSearched) {
                window.location.href = url; 
              
                swal("Başarılı!", "Yetki başarıyla verildi.", "success");
            } else {
                swal("İşlem iptal edildi.", {
                    icon: "error",
                });
            }
        });
    });
});

</script>
@endsection
