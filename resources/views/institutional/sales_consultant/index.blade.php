@extends('institutional.layouts.master')
@section('content')
<div class="content">
    <div class="text-header" style="border-radius: 18px;">
        <h2 class="sales-consultants-heading">Satış Danışmanları Listesi</h2>
    </div>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Ad Soyad</th>
                <th>E-posta</th>
                <th>Unvan</th>
                <th>Atanmış Projeler</th>
                <th>Proje Ataması Yap</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales_consultant as $index => $item)
            <tr>
                <td>{{$index + 1 }}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->email}}</td>
                <td>{{$item->role->name}}</td>
                <td>
                    @foreach($item->projectAssigments as $project)
                        {{ $project->project_title }}<br>
                    @endforeach
                </td>
                <td>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Proje Ata
                    </button>
                </td>
            </tr>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-2" id="exampleModalLabel">Projeler</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('institutional.assign.project.user')}}" method="POST">
                    @csrf
                    <div class="col-md-12 mb-3">
                        <label class="form-label mb-3 fs-1 text-center" for="projects">Proje Seç</label>
                        <div id="projects" style="max-height: 300px; overflow-y: auto;"> <!-- Scrollbar eklendi -->
                            @foreach ($projects as $project)
                                <div class="form-check">
                                    <input type="hidden" name="user_id" value="{{$item->id}}">
                                    <input class="form-check-input" type="checkbox" name="projectIds[]" value="{{ $project->id }}" id="project{{ $project->id }}">
                                    <label class="form-check-label" for="project{{ $project->id }}">
                                        {{ $project->project_title }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="valid-feedback">Looks good!</div>
                    </div> 
                    <div class="col-12">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
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


 
@endsection    
@section('scripts')
 <!-- jQuery -->
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <!-- DataTables CSS -->
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
 <!-- DataTables JS -->
 <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>

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
                "lengthMenu": "Göster _MENU_ kayıt",
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
    });
</script>

    @endsection

    <style>
        .sales-consultants-heading {
            font-size: 2.5em;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            border-bottom: 2px solid gray;
            padding-bottom: 10px;
            /* text-transform: uppercase; */
        }
        .text-header{
            padding: 20px;
            margin: 40px;
            background-color: white;
            border-radius: 18px !important;
        }
    </style>


