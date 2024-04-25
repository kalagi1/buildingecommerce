@extends('client.layouts.master')

@section('content')
    <section class="divIlan">
        <div class="container">
            <div class="row">
                <div class="col-md-3" id="sozlesmeLink">
                    <nav id="sidebar">
                        <a href="{{ url('/destek') }}"><button type="button" class=" newButtonStyle w-100"
                                style="justify-content: start !important;padding:0 14px;">
                                <span class="buyUserRequest__text newButtonStyle__text"> Destek Talebi
                                    Oluştur</span>
                            </button></a>
                        <ul class="list-unstyled components" style="font-size: 13px;background: #060607;">
                            @foreach ($contract_pages as $page)
                                <li>
                                    <a href="#" data-target="{{ $page->title }}">{{ $page->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
                <div class="col-md-9" id="sozlesmeler">
                    <div class="row" style="margin-bottom:50px;">

                        <div class="col-md-12 text-center mt-5">
                            <p class="messageBaslik">Destek Merkezi</p>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 70px;">
                        <div class="col-md-12">
                            <div class="kategori-container">
                                <ul class="kategori-listesi">
                                    <li class="kategori" data-category="kategori1">Yeni Talep</li>
                                    <li class="kategori" data-category="kategori2">Geçmiş Talepler</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center align-items-center" style="margin:-top:70px;margin-bottom:60px;">
                        <div class="col-md-12 ">
                            <div id="kategori1Content" class="accordion-content">

                                <div class="col-md-9 mx-auto">
                                    <form action="{{ route('support.sendSupportMessage') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-md-12 mb-3">
                                            <label for="exampleFormControlTextarea1" class="form-label"
                                                style="font-size: 12px !important;">Kategori</label>
                                            <select class="formInput" aria-label="select example" name="category" required
                                                oninvalid="this.setCustomValidity('Lütfen bir kategori seçiniz.')">

                                                <option value="">Seçiniz</option>
                                                <option value="Bilgi">Bilgi</option>
                                                <option value="Evrak Gönderimi">Evrak Gönderimi</option>
                                                <option value="Öneri & Teşekkür">Öneri & Teşekkür</option>
                                                <option value="Şikayet">Şikayet</option>
                                                <option value="Talep">Talep</option>
                                            </select>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="exampleFormControlTextarea1" class="form-label"
                                                style="font-size: 12px !important;">Açıklama</label>
                                            <textarea class="formInput" id="exampleFormControlTextarea1" style="height: 150px !important" name="description"></textarea>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="custom-file-upload">
                                                <i class="fas fa-link" style="font-size:14px;"></i>
                                                <span style="font-size:14px; color: cornflowerblue;">Dosya Ekle</span>
                                                <input type="file" name="file" id="fileInput" />
                                            </label>
                                            <span id="fileStatus" style="font-size: 12px;"></span>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <span>Kişisel
                                                verilerin korunması hakkında detaylı bilgiye <a href=""
                                                    id="kvkkLink">buradan</a>
                                                ulaşabilirsiniz.</span>
                                        </div>


                                        <div class="col-md-3 mb-3">
                                            <button type="submit" class="btn btn-primary formButton">Gönder</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div id="kategori2Content" class="accordion-content" style="display: none;">

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table  table-hover" id="supportRequest">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Kategori</th>
                                                    <th scope="col">Evrak Gönderim Nedeni</th>
                                                    <th scope="col">Dosya</th>
                                                    <th scope="col">Açıklama</th>
                                                    <th scope="col">Oluşturma Tarihi</th>
                                                    <th scope="col">Talep Durumu</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($supports as $item)
                                                    <tr>
                                                        <td>{{ $item->id }}</td>
                                                        <td>{{ $item->category }}</td>
                                                        <td>{{ isset($item->send_reason) ? $item->send_reason : '-' }}</td>
                                                        <td>
                                                            @if(empty($item->file_path))
                                                            -
                                                            @else
                                                                <a href="{{ route('destek.talep.dosya.indir', ['id' => $item->id]) }}">Dosyayı indir</a><br>
                                                            @endif
                                                        </td>
                                                        <td>{{ $item->description }}</td>
                                                        <td>{{ $item->created_at->format('d.m.Y') }}</td>
                                                        <td>
                                                            @if(!$item->return_support)
                                                                <span>Talebiniz 24 saat içerisinde yanıtlanacaktır.</span>
                                                            @else
                                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#returnModalYanit{{ $item->id }}" >
                                                                    Yanıtı Gör
                                                                </button>
                                                            @endif    
                                                        </td>
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
                                                <div class="form-group">
                                                    <p>  {!! $item->return_support !!}</p>
                                                </div>                                            
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                                </div>                                            
                                            </div>
                                        </div>
                                    </div>
                                </div> 
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
    <script>
        $(document).ready(function() {
            $('#kvkkLink').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/get-kvkk/', // URL'yi doğrudan belirt
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        $('#sozlesmeler').html(response.kvkk);
                    },
                    error: function(xhr, status, error) {
                        console.error('İstek başarısız: ' + status);
                    }
                });

            })

        });

        $(document).ready(function() {

            $('#supportRequest').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Turkish.json"
                }
            });
        });

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

        $(document).ready(function() {
            $('#kategori1Content').show();

            $('.kategori').click(function() {
                var category = $(this).attr('data-category');

                $('#' + category + 'Content').show();

                $('.accordion-content').not('#' + category + 'Content').hide();

                $('.kategori').removeClass('active');
                $(this).addClass('active');
            });
        });

        // Tıklanan linklere tıklanma olayı ekle
        $('#sozlesmeLink ul.components li a').click(function(event) {
            event.preventDefault();
            var target = $(this).data('target');
            getContent(target);
        });

        // İçeriği getirme fonksiyonu
        function getContent(target) {
            $.ajax({
                url: '/get-content/' + target, // URL'yi doğrudan belirt
                type: 'GET',
                data: {
                    target: target
                },
                success: function(response) {
                    $('#sozlesmeler').html(response.content);
                },
                error: function(xhr, status, error) {
                    console.error('İstek başarısız: ' + status);
                }
            });
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
        #sozlesmeler p {
            color: black !important;
            font-size: 12px;
        }



        .table td {
            display: table-cell;
        }


        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #060607;
            color: #fff;
            transition: all 0.3s;
        }

        #sidebar.active {
            margin-left: -250px;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: #060607;
        }

        #sidebar ul p {
            color: #fff;
            padding: 10px;
        }

        #sidebar ul li a {
            padding: 10px;
            font-size: 12px;
            display: block;
            color: white;
            margin: 5px;

        }

        #sidebar ul li a:hover {
            color: #060607;
            background: #fff;
        }

        #sidebar ul li.active>a,
        a[aria-expanded="true"] {
            color: #fff;
            background: #6d7fcc;
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

        .messageBaslik {
            color: #333333;
            font-size: 32px !important;
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
