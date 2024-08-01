@extends('client.layouts.masterPanel')
@section('content')
    <div class="content">
        <div class="table-breadcrumb mb-5">
            <ul>
                <li>Hesabım</li>
                <li>CRM</li>
                <li>Ödül Sistemi</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-6" >
                <div class="form-container" style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;background-color: white; padding: 20px; border-radius: 5px;">
                    <form action="{{ route('institutional.crm.admin.odul.ekle.post') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="award_image">Ödül Resmi</label>
                            <input type="file" class="form-control" id="award_image" name="award_image" style="width: 100%">
                        </div>
                        <div class="form-group">
                            <label for="title">Başlık</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="award_name">Ödül Adı</label>
                            <input type="text" class="form-control" id="award_name" name="award_name" required>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate" name="status">
                            <label class="form-check-label" style="margin-left: 25px;" for="flexCheckIndeterminate">
                                Aktif Et
                            </label>
                        </div>
                        <button type="submit" class="btn btnDanisman">Gönder</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6" style="background-color: white; padding: 20px; border-radius: 5px;box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
                <div >
                    <h3>Ödüller</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Görsel</th>
                                <th scope="col">Başlık</th>
                                <th scope="col">Ödül</th>
                                <th scope="col">Aktif / Pasif</th>
                                <th scope="col">Düzenle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($awards as $award)
                                <tr>
                                    <td>
                                        <img src="{{ asset('awards/' . $award->award_image) }}" alt="{{ $award->award_name }}" style="width: 50px; height: 50px;">
                                    </td>
                                    <td>{{ $award->title }}</td>
                                    <td>{{ $award->award_name }}</td>
                                    <td>
                                        @if($award->status == 1)
                                            Aktif
                                        @else
                                            Pasif
                                        @endif        
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-edit" data-id="{{ $award->id }}">Düzenle</button>
                                    </td>
                                </tr>    
                            @endforeach                          
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .btnDanisman {
            background: linear-gradient(to top, #D32729, #84181A) !important;
            color: #ffffff;
            border-color: #D32729 !important;
            padding: 5px 25px;
            border-radius: 6px !important; 
            margin-top: 15px;
        }
        .btnDanisman:hover {
            color: white;
            background: linear-gradient(to top, #84181A, #D32729) !important;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){
            $('.btn-edit').click(function(){
                var awardId = $(this).data('id');
                $.ajax({
                    url: '/hesabim/awards/' + awardId + '/edit',
                    type: 'GET',
                    success: function(data) {
                        Swal.fire({
                            title: 'Ödül Düzenle',
                            html: `
                                <form id="edit-award-form">
                                    @csrf
                                    <input type="hidden" id="award_id" name="award_id" value="${data.id}">
                                    <div class="form-group">
                                        <label for="award_image" style="float:left">Ödül Resmi</label>
                                        <input type="file" class="form-control" id="edit_award_image" name="award_image" style="width: 100%">
                                    </div>
                                    <div class="form-group">
                                        <label for="title" style="float:left">Başlık</label>
                                        <input type="text" class="form-control" id="edit_title" name="title" value="${data.title}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="award_name" style="float:left">Ödül Adı</label>
                                        <input type="text" class="form-control" id="edit_award_name" name="award_name" value="${data.award_name}" required>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="edit_status" name="status" ${data.status == 1 ? 'checked' : ''}>
                                        <label class="form-check-label" for="edit_status">Aktif Et</label>
                                    </div>
                                </form>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Kaydet',
                            cancelButtonText: 'İptal',
                            preConfirm: () => {
                                var form = $('#edit-award-form')[0];
                                var formData = new FormData(form);
                                return $.ajax({
                                    url: '/hesabim/awards/' + awardId,
                                    type: 'POST',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        Swal.fire('Başarılı', 'Ödül güncellendi', 'success').then(function() {
                                            location.reload();
                                        });
                                    },
                                    error: function(response) {
                                        Swal.fire('Hata', 'Güncelleme başarısız', 'error');
                                    }
                                });
                            }
                        });
                    },
                    error: function() {
                        Swal.fire('Hata', 'Ödül yüklenemedi', 'error');
                    }
                });
            });

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    html: `
                        <ul style="text-align: left;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    `
                });
            @endif

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Başarılı!',
                    text: '{{ session('success') }}'
                });
            @endif
        });
    </script>
@endsection
