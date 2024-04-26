@extends('admin.layouts.master')

@section('content')
    <section class="content">
            <div class="col-md-12 mt-3 ml-4" 
            data-list='{"valueNames":["id","title"],"page":1,"pagination":true}'>
                <div class="row" style="margin-bottom:50px;">

                    <h3 class="mb-0">Destek Merkezi</h3>

                

                        <div class="card shadow-none border border-300 my-4 p-5">
                            <div class="table-responsive scrollbar">
                                <table class="table fs--1 mb-0 border-top border-200" >
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Gönderen</th>
                                            <th scope="col">Kategori</th>
                                            <th scope="col">Evrak Gönderim Nedeni</th>
                                            <th scope="col">Açıklama</th>
                                            <th scope="col">Belge</th>
                                            <th scope="col">Oluşturma Tarihi</th>
                                            <th>Yanıtla</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($supports as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>
                                                    @if($item->user)
                                                        {{ $item->user->name }}
                                                    @else
                                                        Kullanıcı Bulunamadı
                                                    @endif
                                                </td>
                                                
                                                <td>{{ $item->category }}</td>
                                                <td>{{ isset($item->send_reason) ? $item->send_reason : '-' }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>
                                                    @if($item->file_path)
                                                        <a href="{{ $item->file_path }}" class="btn btn-sm btn-info" style="background-color:#0080c7;" download>Belgeyi İndir</a>
                                                    @else
                                                        Belge Bulunamadı
                                                    @endif
                                                </td>
                                                
                                                <td>{{ $item->created_at->format('d.m.Y') }}</td>
                                                <td>
                                                    @if(!$item->return_support)
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#returnModal{{ $item->id }}" >
                                                            Yanıtla
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#returnModalYanit{{ $item->id }}" >
                                                            Yanıtı Gör
                                                        </button>
                                                    @endif    
                                                </td>
                                            </tr>
                                                      <!-- Modal -->
                                <div class="modal fade" id="returnModal{{ $item->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="returnModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="returnModalLabel{{ $item->id }}">Yanıtla
                                                </h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('admin.return.support') }}">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                                    <input type="hidden" name="user_id" value="{{ $item->user_id }}">
                                                    <div class="form-group">
                                                        <label class="form-label" for="response">Yanıtınız</label>
                                                        <textarea class="form-control" id="content_{{ $item->id }}" name="return_support" rows="10" required></textarea>
                                                    </div>
                                                    <div class="modal-footer" style="justify-content: space-between">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                                        <button type="submit" class="btn btn-info">Yanıtla</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Yanıtı Gör Modal -->
                                <div class="modal fade" id="returnModalYanit{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="returnModalYanitLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="returnModalYanitLabel{{ $item->id }}">Yanıt
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">      
                                            <form method="POST" action="{{ route('admin.return.support.edit') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <input type="hidden" name="user_id" value="{{ $item->user_id }}">                                          
                                            <div class="form-group">
                                                <textarea id="contentEdit_{{ $item->id }}" name="return_support_edit" class="formInput" >{{$item->return_support}}</textarea>
                                            </div>                                            
                                            <div class="modal-footer" style="justify-content: space-between">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                                <button type="submit" class="btn btn-info">Düzenle ve Gönder</button>
                                            </div> 
                                            </form>                                           
                                        </div>
                                    </div>
                                </div>
                            </div> 
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex flex-wrap align-items-center justify-content-between py-3 pe-0 fs--1 border-bottom border-200">
                                <div class="d-flex">
                                    <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900"
                                        data-list-info="data-list-info">
                                    </p>
                                </div>
                                <div class="d-flex">
                                    <button class="page-link" data-list-pagination="prev">
                                        <span class="fas fa-chevron-left"></span>
                                    </button>
                                    <ul class="mb-0 pagination"></ul>
                                    <button class="page-link pe-0" data-list-pagination="next">
                                        <span class="fas fa-chevron-right"></span>
                                    </button>
                                </div>
                            </div>
                            
                            
                        </div>
                </div>
            </div>   
    </section>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- DataTables CDN -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    <!-- DataTables Turkish Language File -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/plug-ins/1.10.24/i18n/Turkish.json">
    </script>
      <script src="//cdn.ckeditor.com/4.21.0/full/ckeditor.js"></script>
      <script>
          $(document).ready(function() {
              function createEditor(itemId) {
                  var editorId = 'content_' + itemId; // CKEDITOR'ün benzersiz ID'si
                  CKEDITOR.replace(editorId, {
                      filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                      filebrowserUploadMethod: 'form'
                  });
              }
  
              @foreach ($supports as $item)
                  createEditor({{ $item->id }});
              @endforeach
  
              // CKEDITOR içeriğini almak için bir fonksiyon
              function getContent(itemId) {
                  return CKEDITOR.instances['content_' + itemId].getData();
              }
          });
  
      </script>
            <script>
                $(document).ready(function() {
                    function createEditor(itemId) {
                        var editorId = 'contentEdit_' + itemId; // CKEDITOR'ün benzersiz ID'si
                        CKEDITOR.replace(editorId, {
                            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                            filebrowserUploadMethod: 'form'
                        });
                    }
        
                    @foreach ($supports as $item)
                        createEditor({{ $item->id }});
                    @endforeach
        
                    // CKEDITOR içeriğini almak için bir fonksiyon
                    function getContent(itemId) {
                        return CKEDITOR.instances['contentEdit_' + itemId].getData();
                    }
                });
        
            </script>
    <script>

        // $(document).ready(function() {

        //     $('#supportRequest').DataTable({
        //         "language": {
        //             "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Turkish.json"
        //         }
        //     });
        // });

        
        $(document).ready(function() {
            // Kategori seçimini izle
            $('select[name="category"]').change(function() {
                var selectedCategory = $(this).val();
                // Eğer seçilen kategori "Evrak Gönderimi" ise
                if (selectedCategory === "Evrak Gönderimi") {
                    // Ekstra bir seçim kutusu ekleyin
                    var extraSelectBox =
                        '<label class="form-label mt-3 " style="font-size: 12px !important;">Evrak Gönderim Nedeni</label><select class="formInput" name="sendReason"><option value="">Gönderim Nedeni Seçiniz</option><option value="Turizm Amaçlı Kiralama Amaçlı Kiralık Mağaza Doğrulama">Turizm Amaçlı Kiralama Amaçlı Kiralık Mağaza Doğrulama</option><option value="İlan İlgili Belge Talebi">İlan İlgili Belge Talebi</option><option value="Mağaza Açma">Mağaza Açma</option><option value="Marka Tescili">Marka Tescili</option><option value="Yetkili Bayii Belgesi">Yetkili Bayii Belgesi</option></select>';
                    $(this).parent().append(extraSelectBox);
                } else {
                    // Seçilen kategori "Evrak Gönderimi" değilse, ekstra seçim kutusunu kaldırın
                    $(this).parent().find('select[name="documentType"]').remove();
                }
            });

            $('#fileInput').change(function() {
                var fileName = $(this).val().split('\\').pop(); // Seçilen dosya adını al
                $('#fileStatus').text('Dosya Eklendi: ' + fileName); // Dosya adını görüntüle
            });
        });

// Veri kümesi hakkındaki bilgilerin içeriğini güncellemek için JavaScript kodu
var totalItems = {{ $supports->count() }}; // $supports, verileri içeren koleksiyon veya dizi ise
var infoElement = document.querySelector('[data-list-info="data-list-info"]');

if (infoElement) {
    infoElement.textContent = 'Toplam ' + totalItems + ' kayıt'; // Bu metni ihtiyacınıza göre ayarlayabilirsiniz
}

    </script>

    <script>
        @if (session('success'))
            toastr.success('{{ session('success') }}', 'Başarılı!');
        @endif

        @if (session('error'))
            toastr.error('{{ session('error') }}', 'Hata!');
        @endif
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>

        .table td {
            display: table-cell;
        }


        .formButton {
            border-radius: 4px !important;
            width: 100% !important;
            height: 20px;
        }

        input[type="file"] {
            display: none;
        }

        .custom-file-upload {
            border: 1px solid #ccc;
            display: inline-block;
            padding: 9px 12px;
            cursor: pointer;
            background-color: #cfcfcf69;
            height: 47px;
            width: 100%;
            text-align: center;
            style="color: #0056b3 !important;
        }

        .custom-file-upload:hover {
            background-color: #eee;
        }

        .custom-file-upload input[type="file"] {
     display: none;
        }

        .formInput {
            display: block;
            width: 100%;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 2.0;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #b9b9b9;
            border-radius: .35rem;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.07);
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .divIlan {
            /* background-color: #F6F9FF ; */
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .kategori-container {
            text-align: center;
        }

        .kategori-listesi {
            list-style-type: none;
            padding: 0;
            margin: 0;
            background: #ebebeb !important;
        }

        .kategori {
            display: inline-block;
            /* Yatayda hizala */
            padding: 5px 10px;
            /* background-color: #f0f0f0; */
            margin: 0 20px;
            /* İhtiyaca göre sağ tarafta boşluk bırakabilirsiniz */
            font-size: 15px;
            cursor: pointer;
            color: #333333;
            transition: color 0.3s, border-bottom 0.3s;
        }

        @media (max-width: 768px) {

            .kategori-listesi {
                list-style-type: none;
                padding: 0;
                margin: 0;
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .kategori {
                flex-basis: calc(15% - 0px);
                margin: 0px;
                font-size: 12px;
            }



        }
    </style>
@endsection
